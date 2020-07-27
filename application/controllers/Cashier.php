<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cashier extends CI_Controller
{

    public $user_id = '';
    public $role_id = '';

    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->user_id = user('id');
        $this->role_id = user('role');
        $this->load->library('user_agent');
    }

  
    public function index() {
        if (!logged_in()) {
            redirect('auth/signin', 'refresh');
        } else {
            $this->dashboard();
        }
    }

    public function dashboard() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Dashboard',
                'page' => 'dashboard',
                'products' => $this->Admin_model->_get_all_products_low_quantity(),
                'recent_transaction' => $this->Admin_model->_get_recent_transactions()

            );

            $this->load->view('header', $obj);
            $this->load->view('cashier/dashboard');
            $this->load->view('footer');
            
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

       //francis
    public function products() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Product List',
                'page' => 'products',
                'products' => $this->Admin_model->_get_all_products()
            );

            $this->load->view('header', $obj);
            $this->load->view('cashier/products');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function transaction() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Transaction',
                'page' => 'transaction',
                'products' => $this->Admin_model->_get_all_products(),
                'temps' => $this->Admin_model->_get_products_bought_temp(user('id'))
            );

            $this->load->view('header', $obj);
            $this->load->view('cashier/transaction');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function transaction_history() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Transaction History',
                'page' => 'transaction_history'
            );

            $this->load->view('header', $obj);
            $this->load->view('cashier/transaction_history');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    //francis
    public function product_list_json() {
       if (logged_in()) {
           $this->datatables
                   ->select('*')
                   ->from('tbl_products');
           echo $this->datatables->generate();
       } else {
           redirect('auth/signin', 'refresh');
       }
   }


   public function add_item(){
    $product_id = $this->uri->segment(3);

    $check = $this->Admin_model->_check_existing_temp($product_id, user('id'));

    if($check) {
        // if there's existing
        $count = $check->quantity + 1;
        $data1 = array(
            'quantity' => $count
        );
        $this->Admin_model->_edit_item_temp($product_id, user('id'), $data1);

    } else {
        $data = array(
            'product_id' => $product_id,
            'quantity' => 1,
            'cashier_id' => user('id')
        );
        $this->Admin_model->_add_item_temp($data);
    }
    

    

    redirect('cashier/transaction');
   }


   public function product_temp_list_json() {
       if (logged_in()) {
           $this->datatables
                   ->select('*, tbl_products.id AS product_id, tbl_temp.quantity AS quantity')
                   ->from('tbl_temp')
                   ->join('tbl_products', 'tbl_temp.product_id = tbl_products.id')
                   -> where('cashier_id', user('id'));
           echo $this->datatables->generate();
       } else {
           redirect('auth/signin', 'refresh');
       }
   }
 
  public function checkout_product(){

     $data2 = array(
        'total_amount' => $this->input->post('total_amount'),
        'total_amount_paid' => $this->input->post('amount_paid'),
        'other_charges' => $this->input->post('other_charges'),
        'change_amount' => $this->input->post('change'),
        'cashier_id' => user('id'),
        'date_time' => date("Y-m-d H:i:s")
      );

    $max_id= $this->Admin_model->_insert_transaction($data2);

    $products_bought = $this->Admin_model->_get_products_bought_temp(user('id'));
    foreach ($products_bought AS $product) {
      $data1 = array(
        'product_id' => $product->product_id,
        'transaction_id' => $max_id,
        'quantity' => $product->quantity
        
      );
      $this->Admin_model->_insert_transaction_history($data1);
    }

   

    // remove temp
    $this->Admin_model->_remove_temp_details(user('id'));

    $this->session->set_flashdata('success', 'Success Purchased!');
    redirect('cashier/transaction');
   
   }

    public function history_list_json() {
       if (logged_in()) {
           $this->datatables
                   -> select('tbl_transaction.trans_id AS transaction_id, tbl_transaction_history.quantity, 
                    tbl_transaction.date_time, tbl_products.amount, tbl_products.name AS product_name, tbl_accounts.username AS cashier')
                   -> from('tbl_transaction_history')
                   -> join('tbl_products', 'tbl_products.id = tbl_transaction_history.product_id')
                   -> join('tbl_transaction', 'tbl_transaction_history.transaction_id = tbl_transaction.trans_id')
                   -> join('tbl_accounts', 'tbl_accounts.id = tbl_transaction.cashier_id');
           echo $this->datatables->generate();
       } else {
           redirect('auth/signin', 'refresh');
       }
   }
   
   public function delete_item() {
    $item_id = $this->uri->segment(3);
    $this->Admin_model->_remove_temp_item($item_id);
    redirect('cashier/transaction');

   }

   public function edit_item() {
    $item_id = $this->uri->segment(3);
    $data = array(
      'quantity' => $this->input->post('prod_quantity')
      );
    $this->Admin_model->_edit_item_temp($item_id, user('id'), $data);
    redirect('cashier/transaction');

   }

   public function search_products() {
    $keyword = $this->uri->segment(3);
    $data = array(
      'product_data' => $this->Admin_model->_search_products($keyword)
    );
    echo json_encode($data);
   }

  public function delete_all_temp() {
    $this->Admin_model->_remove_temp_details(user('id'));
    redirect('cashier/transaction','refresh');
   }


}