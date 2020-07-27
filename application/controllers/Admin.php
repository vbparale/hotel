<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin extends CI_Controller
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
                'guests_today' => $this->Admin_model->_all_guests_this_day(),
                'guests_this_week' => $this->Admin_model->_checkin_guests_this_week(),
                'products' => $this->Admin_model->_get_all_products_low_quantity(),
                'recent_transaction' => $this->Admin_model->_get_recent_transactions(),
                'checkin_details' => $this->Admin_model->_get_checkin_data_by_guest_dashboard(),
                /*'overdue_details' => $this->Admin_model->_get_checkin_data_status()*/
                'checkin_distinct' => $this->Admin_model->_get_checkin_data_by_guest_dashboard_distinct(),
                'guest_banned' => $this->Admin_model->_get_banned_customer()

            );

            $this->load->view('header', $obj);
            $this->load->view('admin/dashboard');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function guests() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Guests',
                'page' => 'guests',
                'rooms' => $this->Admin_model->_get_available_rooms(),
                'data' => $this->Admin_model->_get_all_guests()
                //'data' => $this->Admin_model->_get_all_checkin_data()
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/guests');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }


    public function guest_details() {
        if (logged_in()) {
            $guest_id = $this->uri->segment(3);
            $obj = array(
                'page_title' => 'Guests',
                'page' => 'guest_details',
                'guest_details' => $this->Admin_model->_get_guest_details($guest_id),
                'payment_details' => $this->Admin_model->_get_payment_by_guest($guest_id),
                'checkin_details' => $this->Admin_model->_get_checkin_data_by_guest($guest_id)
                //'payment_details' => $this->Admin_model->_get_guest_details($guest_id),
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/guest_details');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }


    public function rooms() {
        if (logged_in()) {

            $obj = array(
                'page_title' => 'Rooms',
                'page' => 'rooms',
                'occupied_rooms' => $this->Admin_model->_get_occupied_rooms(),
                'available_rooms' => $this->Admin_model->_get_available_rooms(),
                'room_types' => $this->Admin_model->_get_all_room_types()
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/rooms');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function reservations() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Reservations',
                'page' => 'reservations',
                'rooms' => $this->Admin_model->_get_available_rooms(),
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/reservations');
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
            $this->load->view('admin/products');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }
    //francis
    public function accounts() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Accounts List',
                'page' => 'accounts',
                'accounts'=> $this->Admin_model->_get_all_accounts(),
                'roles'=> $this->Admin_model->_get_all_roles()
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/accounts');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function status() {
        if (logged_in()) {
            $guest_id = $this->uri->segment(3);
            $obj = array(
                'page_title' => 'Status',
                'page' => 'status',
                'checkin_distinct' => $this->Admin_model->_get_checkin_data_by_guest_dashboard_distinct(),
                'checkin_details' => $this->Admin_model->_get_checkin_data_status()

            );

            $this->load->view('header', $obj);
            $this->load->view('admin/status');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function transfer_guest() {
        if (logged_in()) {
            $guest_id = $this->input->post('guest_id');
            date_default_timezone_set('Asia/Manila');
                  $current_date = date('Y-m-d H:i:s');
            $checkin = new DateTime($current_date);
            $checkout = new DateTime($this->input->post('checkout_date'));
            $date_diff = date_diff($checkin, $checkout);
            $rate=$this->input->post('room_rate');
            $total_amount =  $rate * $date_diff->d;

            $data = array(
                'status' => 1,
                'checkout_date' => $current_date,
            );
            $this->Admin_model->_update_checkin_status($data,  $this->input->post('prev_service_id'));

            $data2 = array(
                'room_id' => $this->input->post('room_id'),
                'guest_id' =>$guest_id,
                'checkin_date' => $current_date,
                'checkout_date' => $this->input->post('checkout_date'),
                'guests' =>$this->input->post('guest_count'),
                'status' => 0,
                'rate_per_day' => $this->input->post('room_rate'),
                'total_amount' => $total_amount,
            );
            $this->Admin_model->_checkin($data2);

            $this->session->set_flashdata('success', 'Transferred Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

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
            $this->load->view('admin/transaction_history');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function edit_product() {
        if (logged_in()) {
            $id=$this->input->post('product_id');
            $data = array(
                'name' => $this->input->post('product_name'),
                'quantity' => $this->input->post('quantity'),
                'amount' => $this->input->post('amount'),
                'cost' => $this->input->post('cost'),
                'best_before' => $this->input->post('best_before'),
                'status' => $this->input->post('status')
            );
            $this->Admin_model->_edit_products($data,$id);

            $this->session->set_flashdata('success', 'Product Edited Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }
    //francis
    public function remove_account() {
        if (logged_in()) {
            $id=$this->input->post('remove_account_id');
            $data = array(
                'status' => 0
            );
            $this->Admin_model->_remove_account($data,$id);
            $this->session->set_flashdata('success', 'Account removed Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }
    //francis
    public function change_password() {
        if (logged_in()) {

            $old_password=$this->Admin_model->_get_user_password_by_id($this->input->post('account_id'));
            $id = $this->input->post('account_id');
            $password=md5($this->input->post('edit_old_password'));
            if($this->input->post('edit_new_password')==$this->input->post('edit_confirm_new_password')){
              if($old_password->password == md5($password)){
                  $pass=$this->input->post('edit_new_password');
                  $data = array(
                      'password' => md5($pass)
                  );
                  $this->Admin_model->_change_password($id,$data);
                  $this->session->set_flashdata('success', 'Password Changed Successfully!');
                  redirect($_SERVER['HTTP_REFERER']);
                }else{
                  $this->session->set_flashdata('error', 'Old password is Incorrect!');
                  redirect($_SERVER['HTTP_REFERER']);
                }
              }else{
                $this->session->set_flashdata('error', 'New password is Mismatch!');
                redirect($_SERVER['HTTP_REFERER']);
              }


        } else {
            redirect('auth/signin', 'refresh');
        }
    }
    //francis
    public function add_product() {
        if (logged_in()) {
            $data = array(
                'name' => $this->input->post('add_product_name'),
                'quantity' => $this->input->post('add_quantity'),
                'amount' => $this->input->post('add_amount'),
                'cost' => $this->input->post('add_cost'),
                'best_before' => $this->input->post('add_best_before'),
                'status' => $this->input->post('add_status')
            );
            $this->Admin_model->_add_products($data);

            $this->session->set_flashdata('success', 'Product added Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }
    //francis
    public function add_account() {
      if (logged_in()) {

        if($this->input->post('add_password')==$this->input->post('add_confirm_password')){
          $password = $this->input->post('add_password');
          $username = $this->input->post('add_user_name');
          $data = array(
            'username' => $username,
            'password' => md5($password),
            'role' => $this->input->post('add_role'),
            'status' => $this->input->post('add_status')
          );
          $this->Admin_model->_add_account($data);
          $this->session->set_flashdata('success', 'Account Added Successfully!');
          redirect($_SERVER['HTTP_REFERER']);
        }else{
          $this->session->set_flashdata('add_error', 'Password Mismatch!');
          redirect($_SERVER['HTTP_REFERER']);
        }

      } else {
        redirect('auth/signin', 'refresh');
      }
    }
    //francis
    public function delete_product() {
        if (logged_in()) {
            $id=$this->input->post('delete_product_id');
            $this->Admin_model->_delete_products($id);

            $this->session->set_flashdata('success', 'Product Edited Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     //francis
    public function cancel_reservation() {
        if (logged_in()) {
            $id=$this->input->post('cancel_service_id');
            $this->Admin_model->_cancel_reservation($id);

            $this->session->set_flashdata('success', 'Cancelled Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    //francis
    public function delete_checkin_and_payment() {
        if (logged_in()) {
            $id=$this->input->post('cancel_service_id');
            $this->Admin_model->_delete_checkin($id);
            $this->Admin_model->_delete_payment($id);

            $this->session->set_flashdata('success', 'Cancelled Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }


    public function reports() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Reports',
                'page' => 'reports'
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/reports');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function report_hotel() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Hotel Management System Reports',
                'page' => 'reports'
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/report_hotel');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function report_inventory() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Inventory System Reports',
                'page' => 'report_inventory',
                'reports' => $this->Admin_model->_get_inventory_report()
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/report_inventory');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function report_sales() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Sales Reports',
                'page' => 'reports'
            );

            $this->load->view('header', $obj);
            $this->load->view('admin/report_sales');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function checkin() {
        if (logged_in()) {

            $data = array(
                'firstname' => $this->input->post('fname'),
                'lastname' => $this->input->post('lname'),
                'address' => $this->input->post('address'),
                'contact_number' => $this->input->post('contact')
            );
            $guest_id = $this->Admin_model->_add_guest_info($data);

            $data2 = array(
                'room_id' => $this->input->post('room_id'),
                'guest_id' => $guest_id,
                'reservation_date' => date("Y-m-d H:i:s"),
                'checkin_date' => $this->input->post('checkin_date'),
                'checkout_date' => $this->input->post('checkout_date'),
                'guests' => $this->input->post('guest_count'),
                /*'total_amount' => $this->input->post('total_amount'),*/
                /*'total_amount_paid' => $this->input->post('amount_paid'),
                'other_charges' => $this->input->post('other_charges')*/
            );
            $service_id = $this->Admin_model->_checkin($data2);

            $this->Admin_model->_update_service_id_to_group($service_id);

            $this->session->set_flashdata('success', 'Checked-in Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function add_guest() {
        if (logged_in()) {
            $fullname =  $this->input->post('fname') . $this->input->post('lname');
             $photo = "default.png";
            if ($_FILES['photo']) {

                $image = $this->upload_image( 'photo', 'jpg|jpeg|png', './assets/img/thumbnails/', $fullname);


                if($image['upload_data']['file_name']) {
                    $photo = $image['upload_data']['file_name'];
                } else {
                    $photo = "default.png";
                }
            }



            $data = array(
                'firstname' => $this->input->post('fname'),
                'lastname' => $this->input->post('lname'),
                'address' => $this->input->post('address'),
                'birthday' => $this->input->post('birthday'),
                'note' => $this->input->post('note'),
                'contact_number' => $this->input->post('contact'),
                'referred_by' => $this->input->post('referred_by'), //add by francis
                'photo' => $photo
            );
            $guest_id = $this->Admin_model->_add_guest_info($data);

            $this->session->set_flashdata('success', 'Added Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function edit_guest() {
        if (logged_in()) {
            $guest_id = $this->input->post('edit_guest_id');
            $fullname =  $this->input->post('edit_fname') . $this->input->post('edit_lname');
            $image = $this->upload_image( 'edit_photo', 'jpg|jpeg|png', './assets/img/thumbnails/', $fullname);
            if($image) {
                $photo = "";
                if(isset($image)) {
                    $photo = $image['upload_data']['file_name'];
                }

                $data = array(
                    'firstname' => $this->input->post('edit_fname'),
                    'lastname' => $this->input->post('edit_lname'),
                    'address' => $this->input->post('edit_address'),
                    'birthday' => $this->input->post('edit_birthday'),
                    'note' => $this->input->post('edit_note'),
                    'contact_number' => $this->input->post('edit_contact'),
                    'photo' => $photo
                );
            } else {
                $data = array(
                    'firstname' => $this->input->post('edit_fname'),
                    'lastname' => $this->input->post('edit_lname'),
                    'address' => $this->input->post('edit_address'),
                    'birthday' => $this->input->post('edit_birthday'),
                    'note' => $this->input->post('edit_note'),
                    'contact_number' => $this->input->post('edit_contact')
                );
            }



            $guest_id = $this->Admin_model->_edit_guest_info($guest_id, $data);

            $this->session->set_flashdata('success', 'Added Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    //francis
  public function edit_reservation() {
     if (logged_in()) {
       $rate = $this->input->post('edit_rate_per_day');
       $rate_txt = $this->input->post('edit_other_amount');
       if(!$rate && !$rate_txt) {
           $data = $this->Admin_model->_get_room_by_id($this->input->post('edit_this_guest_room'));
           $rate_per_day = $data->rate;
       } elseif(!$rate && $rate_txt) {
           $rate_per_day = $rate_txt;
       } elseif($rate && !$rate_txt) {
           $rate_per_day = $rate;
       }
       $checkin_date =  new DateTime($this->input->post('edit_checkin_date'));
       $checkout_date = new DateTime($this->input->post('edit_checkout_date'));

       if($this->input->post('edit_checkout_date')) {
           $interval = date_diff($checkin_date, $checkout_date);

           $total_amount = 0;
           if($interval->d > 0) {
               $total_amount = $interval->d * $rate_per_day;
           }
       } else {
           $total_amount = 1 * $rate_per_day;
       }


         $id=$this->input->post('reserve_service_id');
         $data = array(
             'guests' => $this->input->post('edit_guest_count'),
             'checkin_date' => $this->input->post('edit_checkin_date'),
             'reservation_date' => date("Y-m-d H:i:s"),
             'checkout_date' => $this->input->post('edit_checkout_date'),
             'room_id' => $this->input->post('edit_this_guest_room'),
             'total_amount' => $total_amount,
             'rate_per_day' => $rate_per_day,
             'checkin_note' => $this->input->post('edit_checkin_note')
         );
         $this->Admin_model->_edit_reservation($data,$id);
         $this->Admin_model->_delete_other_charges($id);

         $this->session->set_flashdata('success', 'Reservation Edited Successfully!');
         redirect($_SERVER['HTTP_REFERER']);

     } else {
         redirect('auth/signin', 'refresh');
     }
 }

 //Francis Dy
  public function add_banned_guest() {

    if (logged_in()) {
      $fullname =  $this->input->post('firstname') . $this->input->post('lastname');
      $photo = "";
      if ($this->input->post('picture')) {
        $image = $this->upload_image( 'picture', 'jpg|jpeg|png', './assets/img/thumbnails/', $fullname);
        if(isset($image)) {
          $photo = $image['upload_data']['file_name'];
        }
        $data = array(
          'firstname' => $this->input->post('firstname'),
          'lastname' => $this->input->post('lastname'),
          'photo' => $photo,
          'is_banned' => 1
        );
      }else{
        $data = array(
          'firstname' => $this->input->post('firstname'),
          'lastname' => $this->input->post('lastname'),
          'is_banned' => 1
        );
      }


      $this->Admin_model->_add_guest_info($data);
      $this->session->set_flashdata('success', 'Added Successfully!');
      redirect($_SERVER['HTTP_REFERER']);
      echo json_encode(array('status' => TRUE ));

    } else {
      redirect('auth/signin', 'refresh');
    }
  }

 //francis
 public function banned_guest_detail() {
    if (logged_in()) {
        $id=$this->input->post('ban_service_id');
        $data = array(
            'is_banned' => 1,
        );
        $this->Admin_model->_banned_guest_details($data,$id);

        $this->session->set_flashdata('success', 'Guest has been banned!');
        redirect($_SERVER['HTTP_REFERER']);

    } else {
        redirect('auth/signin', 'refresh');
    }
}

     public function upload_image( $field_name = null, $type = null, $path = null, $filename = null ) {

        $config['upload_path'] = $path;
        $config['allowed_types'] = $type;
        $config['max_size']    = 0;
        $config['file_name'] = preg_replace('/[^A-Za-z0-9]/', "", $filename);

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload($field_name)) {
            $data['error_msg'] = $this->upload->display_errors();
        }
        else {
            $data = array('upload_data' => $this->upload->data());
        }
        return $data;

    }



    public function add_room_guest () {
         if (logged_in()) {
            $service_id = $this->input->post('room_service_id');
            $guest_info = $this->Admin_model->_get_checkin_data($service_id);
            $data2 = array(
                'room_id' => $this->input->post('room_id'),
                'guest_id' => $guest_info[0]->guest_id,
                'reservation_date' => date("Y-m-d H:i:s"),
                'checkin_date' => $this->input->post('checkin_date'),
                'checkout_date' => $this->input->post('checkout_date'),
                'guests' => $this->input->post('guest_count'),
                'group_guest_id' => $guest_info[0]->service_id
            );
            $service_id = $this->Admin_model->_checkin($data2);

            $this->session->set_flashdata('success', 'Checked-in Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function edit_checkin() {
        if (logged_in()) {
            $service_id = $this->input->post('service_id');
            $guest_id = $this->input->post('guest_id');
            $data = array(
                'firstname' => $this->input->post('fname'),
                'lastname' => $this->input->post('lname'),
                'address' => $this->input->post('address'),
                'contact_number' => $this->input->post('contact')
            );
            $guest_id = $this->Admin_model->_edit_guest_info($guest_id, $data);

            $data2 = array(
                'room_id' => $this->input->post('room_id'),
                'guest_id' => $guest_id,
                'reservation_date' => date("Y-m-d H:i:s"),
                'checkin_date' => $this->input->post('checkin_date'),
                'checkout_date' => $this->input->post('checkout_date'),
                'guests' => $this->input->post('guest_count')
            );
            $this->Admin_model->_edit_checkin_details($service_id, $data2);

            $this->session->set_flashdata('success', 'Details Updated Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function remove_reservation() {
        if (logged_in()) {
            $service_id = $this->uri->segment(3);
            $this->Admin_model->_remove_checkin_details($service_id, $data);

            $this->session->set_flashdata('success', 'Successfully Deleted!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function checkin_this_guest() {
        if (logged_in()) {
            $rate = $this->input->post('rate_per_day');
            $rate_txt = $this->input->post('other_amount');
            $data = $this->Admin_model->_get_room_by_id($this->input->post('room_id'));

            $guest_count = $this->input->post('guest_count');

            if(!$rate && !$rate_txt) {
                $rate_per_day = $data->rate;
            } elseif(!$rate && $rate_txt) {
                $rate_per_day = $rate_txt;
            } elseif($rate && !$rate_txt) {
                $rate_per_day = $rate;
            }


            if(intval($data->max_capacity) < intval($guest_count)) {
               $minus = $guest_count - $data->max_capacity;
               $value = 100 * $minus;
               $rate_per_day = $rate_per_day + $value;
            }

            $checkin_date =  new DateTime($this->input->post('checkin_date'));
            $checkout_date = new DateTime($this->input->post('checkout_date'));
            if($this->input->post('checkout_date')) {
                $interval = date_diff($checkin_date, $checkout_date);

                $total_amount = 0;
                if($interval->d > 1) {
                    $total_amount = $interval->d * $rate_per_day;
                } else {
                    $total_amount = 1 * $rate_per_day;
                }
            } else {
                $total_amount = 1 * $rate_per_day;
            }

            $data = array(
                'room_id' => $this->input->post('room_id'),
                'guest_id' => $this->input->post('guest_id'),
                'reservation_date' => date("Y-m-d H:i:s"),
                'checkin_date' => $this->input->post('checkin_date'),
                'checkout_date' => $this->input->post('checkout_date'),
                'rate_per_day' => $rate_per_day,
                'guests' => $guest_count,
                'total_amount' => $total_amount,
                'checkin_note' => $this->input->post('checkin_note'),
                'status' => 2 // RESERVE FIRST
            );
            $last_id = $this->Admin_model->_checkin($data);
            // check if there's exceeding guest
            /*$value = 0;
            if($data->max_capacity < $guest_count) {
               $minus = $guest_count - $data->max_capacity;
               $price = 100 * $minus;
               $value = $price * rate_per_day
            }

             $data = array(
                'service_id' => $last_id,
                'description' => 'Extra Pax',
                'amount' => $value
                );
            $this->Admin_model->_add_charges($last_id, $data);*/

            $this->session->set_flashdata('success', 'Checked-in Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }


    public function checkout() {
        if (logged_in()) {

            $service_id = $this->input->post('service_id');
            $group_id = $this->input->post('group_id');
            $data = array(
                'status' => 0,
                'checkout_date' => date($this->input->post('checkout_date')),
                'total_amount' => $this->input->post('total_amount'),
                'total_amount_paid' => $this->input->post('amount_paid'),
                'other_charges' => $this->input->post('other_charges'),
                'change_amount' => $this->input->post('change')
            );
            $this->Admin_model->_checkout($service_id, $data);

            if ($group_id > 0) {
                $this->Admin_model->_checkout_group($group_id);
            }

            $this->session->set_flashdata('success', 'Checked-out Successfully!');

            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function add_rooms() {
        if (logged_in()) {

            $data = array(
                'room_name' => $this->input->post('room_name'),
                'room_type' => $this->input->post('room_type'),
                'rate' => $this->input->post('rate'),
                'max_capacity' => $this->input->post('capacity'),
                'floor' => $this->input->post('floor')
            );
            $guest_id = $this->Admin_model->_add_room_info($data);

            $this->session->set_flashdata('success', 'Successfully Added a Room!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function edit_room() {
        if (logged_in()) {
            $room_id = $this->input->post('room_id');
            $data = array(
                'room_name' => $this->input->post('room_name'),
                'room_type' => $this->input->post('room_type'),
                'rate' => $this->input->post('rate'),
                'floor' => $this->input->post('floor')
            );
             $this->Admin_model->_update_room_info($room_id, $data);

            $this->session->set_flashdata('success', 'Successfully Updated!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function remove_room() {
        if (logged_in()) {
            $room_id = $this->uri->segment(3);
            $this->Admin_model->_remove_room_info($room_id, $data);

            $this->session->set_flashdata('success', 'Successfully Deleted!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function guest_list_json() {
        if (logged_in()) {
            $this->datatables
                    ->select('*, tbl_guest_info.id AS guest_id')
                    ->from('tbl_guest_info');
            echo $this->datatables->generate();
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

   //francis
   public function accounts_list_json() {
      if (logged_in()) {
        $this->datatables
          -> select('tbl_accounts.*,tbl_accounts.id as account_id, tbl_roles.role_name as role_name')
          -> from('tbl_accounts')
          -> join('tbl_roles', 'tbl_accounts.role = tbl_roles.id')
          -> where('tbl_accounts.status',1)
          -> where('tbl_accounts.id <>',1);

          echo $this->datatables->generate();
      } else {
          redirect('auth/signin', 'refresh');
      }
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

    public function get_events()
    {
         // Our Start and End Dates
         $start = $this->input->get("start");
         $end = $this->input->get("end");

         $startdt = new DateTime('now'); // setup a local datetime
         $startdt->setTimestamp($start); // Set the date based on timestamp
         $start_format = $startdt->format('Y-m-d H:i:s');

         $enddt = new DateTime('now'); // setup a local datetime
         $enddt->setTimestamp($end); // Set the date based on timestamp
         $end_format = $enddt->format('Y-m-d H:i:s');

         $events = $this->Admin_model->get_events($start_format, $end_format);

         $data_events = array();

         foreach($events->result() as $r) {
            $name = $r->firstname . ' ' . $r->lastname;
            $room = $r->room_type . ' - ' . $r->room_name;
            /*$c_out = date('Y-m-d H:i:s'. strtotime($r->checkout_date.' + 1 days'));*/
            $c_out = new DateTime($r->checkout_date);
            $c_out->modify('+ 1 day');
            $checkout = $c_out->format('Y-m-d H:i:s');
            $data_events[] = array(
                 "id" => $r->service_id,
                 "title" => $name,
                 "description" => $room,
                 "end" => $checkout,
                 "start" => $r->checkin_date,
                 "url" => 'http://localhost/hotel/admin/guest_details/' . $r->guest_id
            );
         }
         echo json_encode(array("events" => $data_events));
         /*exit();*/
    }

     public function view_invoice(){
        $service_id = $this->uri->segment(3);
        $group_id = $this->uri->segment(4);
        $payment_id = $this->uri->segment(5);
        if (logged_in()) {
          $data = array(
            'checkin_data' => $this->Admin_model->_get_checkin_data($service_id),
            'rooms_data' => $this->Admin_model->_get_rooms_by_group($group_id),
            'payment_data' => $this->Admin_model->_get_payment_by_id($payment_id, $service_id),
          );
          echo json_encode($data);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    /*public function view_invoice_group(){
        $service_id = $this->uri->segment(3);
        if (logged_in()) {
          $data = array(
            'checkin_data' => $this->Admin_model->_get_checkin_data_group($service_id)
          );
          echo json_encode($data);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }*/

    public function daily_reports(){
        $date = $this->uri->segment(3);
        if (logged_in()) {
          $reports = array(
            'daily_report' => $this->Admin_model->_get_daily_report($date),
            'total_daily' => $this->Admin_model->total_daily_report($date)
          );
          echo json_encode($reports);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function daily_sales_reports(){
        $date = $this->uri->segment(3);
        if (logged_in()) {
          $reports = array(
            'daily_report' => $this->Admin_model->_get_daily_sales_report($date),
            'total_daily' => $this->Admin_model->total_daily_sales_report($date),
            'total_cost' => $this->Admin_model->total_cost_daily_sales_report($date)
          );
          echo json_encode($reports);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function monthly_sales_reports(){
        $month = $this->uri->segment(3);
        if (logged_in()) {
          $reports = array(
            'monthly_report' => $this->Admin_model->_get_monthly_sales_report($month),
            'total_monthly' => $this->Admin_model->total_monthly_sales_report($month),
            'total_cost' => $this->Admin_model->total_cost_monthly_sales_report($month)
          );
          echo json_encode($reports);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function inventory_reports(){
        if (logged_in()) {
          $reports = array(
            'reports' => $this->Admin_model->_get_inventory_report()
          );
          echo json_encode($reports);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function monthly_reports(){
        $month = $this->uri->segment(3);
        if (logged_in()) {
          $reports = array(
            'monthly_report' => $this->Admin_model->_get_monthly_report($month),
            'total_monthly' => $this->Admin_model->total_monthly_report($month)
          );
          echo json_encode($reports);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function yearly_reports(){
    $year = $this->uri->segment(3);

    if (logged_in()) {
      $reports = array(
        'yearly_report' => $this->Admin_model->_get_yearly_report($year),
        'total_year' => $this->Admin_model->total_yearly_report($year)
      );
      echo json_encode($reports);
    } else {
      redirect('auth/signin', 'refresh');
    }
  }

  public function yearly_sales_reports(){
  $year = $this->uri->segment(3);

  if (logged_in()) {
    $reports = array(
      'yearly_report' => $this->Admin_model->_get_yearly_sales_report($year),
      'total_year' => $this->Admin_model->total_yearly_sales_report($year),
      'total_cost_year' => $this->Admin_model->total_cost_yearly_sales_report($year)
    );
    echo json_encode($reports);
  } else {
    redirect('auth/signin', 'refresh');
  }
}

  public function view_available_rooms(){
    if (logged_in()) {
    $checkin = $this->uri->segment(3);
    $checkout = $this->uri->segment(4);
    $type = $this->uri->segment(5);

    $room = array();
    if($checkin != 0 && $checkout != 0 && $type == 0) {
        $room = array(
            'room_data' => $this->Admin_model->_get_available_rooms_date($checkin, $checkout)

        );
    } elseif($checkin == 0 && $checkout == 0 && $type > 0) {
        $room = array(
            'room_data' => $this->Admin_model->_get_available_rooms_type($type)

        );
    } elseif($checkin != 0 && $checkout != 0 && $type > 0) {
        $room = array(
            'room_data' => $this->Admin_model->_get_available_rooms_datetype($checkin, $checkout, $type)

        );
    }

    echo json_encode($room);

    } else {
      redirect('auth/signin', 'refresh');
    }
  }

 /* public function checkout_confirm(){
    if (logged_in()) {
        $service_id = $this->uri->segment(3);
        $this->Admin_model->_user_confirm_checkout($service_id);

        $this->session->set_flashdata('success', 'User has been Checked-out!');
        redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect('auth/signin', 'refresh');
    }

  }*/



  // BULK UPLOAD OF RECORDS
    public function bulk_user_data() {
        if (logged_in()) {
            date_default_timezone_set("Asia/Manila");
            $date_created = date("Y-m-d h:i:s");
            $email = 'example@email.com';
            $avatar = 'default.jpg';

            $data['error'] = 'qwe';    //initialize image upload error array to empty
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';

            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $this->session->set_flashdata('error', 'There seems to be a problem with your CSV file!');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];

                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);

                    foreach ($csv_array as $row) {
                        $user = array(
                        'firstname' => utf8_encode(ucwords(strtolower($row['firstname']))),
                        'lastname' => utf8_encode(ucwords(strtolower($row['lastname']))),
                        'address' => $row['address'],
                        'birthday' => $row['birthday'],
                        'note' => $row['note'],
                        'contact_number' => $row['contact_number'],
                        'status' => 1);

                        $this->db->insert('tbl_guest_info', $user);
                        $last_id = $this->db->insert_id();
                        $this->session->set_flashdata('success', 'User Accounts Uploaded !');

                    }
                   redirect($_SERVER['HTTP_REFERER']);
            }
        }
        } else {
            redirect('auth/signin', 'refresh');
        }

    }

    public function bulk_checkin_data() {
        if (logged_in()) {
            date_default_timezone_set("Asia/Manila");
            $date_created = date("Y-m-d h:i:s");
            $email = 'example@email.com';
            $avatar = 'default.jpg';

            $data['error'] = 'qwe';    //initialize image upload error array to empty
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';

            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $this->session->set_flashdata('error', 'There seems to be a problem with your CSV file!');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];

                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);

                    foreach ($csv_array as $row) {
                        $guest = $this->Admin_model->_get_guest_details_by_name(utf8_encode(ucwords(strtolower($row['firstname']))), utf8_encode(ucwords(strtolower($row['lastname']))));
                        $room_data = $this->Admin_model->_get_room(strtolower($row['room_name']));
                        if ($room_data) {
                            $checkin_date =  new DateTime($row['checkin_date']);
                            $checkout_date = new DateTime($row['checkout_date']);

                            $total_amount = 0;
                            if($row['checkout_date']) {
                                $interval = date_diff($checkin_date, $checkout_date);
                                if($interval->d > 0) {
                                    $total_amount = $interval->d * intval($room_data->rate);
                                }
                            } else {
                                $total_amount = 1 * intval($room_data->rate);
                            }

                            $checkin = array(
                                'guest_id' => $guest->id,
                                'room_id' => $room_data->room_id,
                                'guests' => $row['guests_count'],
                                'reservation_date' => date("Y-m-d H:i:s",strtotime($row['checkin_date'])),
                                'checkin_date' => date("Y-m-d H:i:s",strtotime($row['checkin_date'])),
                                'checkout_date' => date("Y-m-d H:i:s",strtotime($row['checkout_date'])),
                                'rate_per_day' => $room_data->rate,
                                'total_amount' => $total_amount,
                                'checkin_note' => $row['note'],
                                'group_guest_id' => 0, // zero default
                                'status' => 1);

                                $this->db->insert('tbl_checkin', $checkin);
                                $last_service_id = $this->db->insert_id();
                                $this->session->set_flashdata('success', 'Checkin Data Uploaded !');

                        } else {
                            var_dump($room_data);exit;
                        }
                       }

                    }
                }
                redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }

    }


     public function bulk_payment_data() {
        if (logged_in()) {
            date_default_timezone_set("Asia/Manila");
            $date_created = date("Y-m-d h:i:s");
            $email = 'example@email.com';
            $avatar = 'default.jpg';

            $data['error'] = 'qwe';    //initialize image upload error array to empty
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';

            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $this->session->set_flashdata('error', 'There seems to be a problem with your CSV file!');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];

                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);

                    foreach ($csv_array as $row) {
                        $guest = $this->Admin_model->_get_guest_details_by_name(utf8_encode(ucwords(strtolower($row['firstname']))), utf8_encode(ucwords(strtolower($row['lastname']))));
                        $description = "Previous Balance - " + $row['date'];
                        if ($guest) {
                            $checkin = array(
                                'guest_id' => $guest->id,
                                'service_id' => 0,
                                'description' => $description,
                                'amount' => $row['total_amount_due'],
                            );

                                $this->db->insert('tbl_other_charges', $checkin);
                                $last_service_id = $this->db->insert_id();
                                $this->session->set_flashdata('success', 'Payment Data for Old Accounts Uploaded !');

                        } else {
                            var_dump($guest);exit;
                        }
                       }

                    }
                }
                redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }

    }

    public function bulk_room_data() {
        if (logged_in()) {
            date_default_timezone_set("Asia/Manila");
            $date_created = date("Y-m-d h:i:s");
            $email = 'example@email.com';
            $avatar = 'default.jpg';

            $data['error'] = 'qwe';    //initialize image upload error array to empty
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';

            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $this->session->set_flashdata('error', 'There seems to be a problem with your CSV file!');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $file_data = $this->upload->data();
                $file_path = './uploads/' . $file_data['file_name'];

                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);

                    foreach ($csv_array as $row) {
                            $room = array(
                                'room_name' => $row['room_name'],
                                'room_type' => $row['room_type'],
                                'max_capacity' => $row['max_capacity'],
                                'rate' =>$row['rate'],
                                'floor' => $row['floor'],
                                );

                                $this->db->insert('tbl_room_info', $room);
                                $last_service_id = $this->db->insert_id();
                                $this->session->set_flashdata('success', 'Rooms Data Uploaded !');


                       }

                    }
                }
                redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }

    }

    public function checkout_confirm(){
        if (logged_in()) {
            $service_id = $this->input->post('service_id');
            $data = array('status' => 0);
            $this->Admin_model->_checkout($service_id, $data);
            $this->session->set_flashdata('success', 'User has been Checked-out!');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function checkin_confirm(){
        if (logged_in()) {
            $service_id = $this->input->post('service_id');
            //var_dump($service_id); exit;
            $data = array('status' => 1);
            $this->Admin_model->_checkout($service_id, $data);
            $this->session->set_flashdata('success', 'User has been Checked-in!');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }


}
