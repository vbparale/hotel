<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Frontdesk extends CI_Controller
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
                'checkin_details' => $this->Admin_model->_get_checkin_data_by_guest_dashboard(),
                'checkin_distinct' => $this->Admin_model->_get_checkin_data_by_guest_dashboard_distinct(),
                'guest_banned' => $this->Admin_model->_get_banned_customer(),
                /*'overdue_details' => $this->Admin_model->_get_checkin_data_status()*/

            );

            $this->load->view('header', $obj);
            $this->load->view('frontdesk/dashboard');
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
            );

            $this->load->view('header', $obj);
            $this->load->view('frontdesk/guests');
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
                 'rooms' => $this->Admin_model->_get_available_rooms(),
                'guest_details' => $this->Admin_model->_get_guest_details($guest_id),
                'payment_details' => $this->Admin_model->_get_payment_by_guest($guest_id),
                'checkin_details' => $this->Admin_model->_get_checkin_data_by_guest($guest_id),
                'available_rooms' => $this->Admin_model->_get_available_rooms(),
                'room_types' => $this->Admin_model->_get_room_types()
            );

            $this->load->view('header', $obj);
            $this->load->view('frontdesk/guest_details');
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
            $this->load->view('frontdesk/rooms');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function reservations() {
        if (logged_in()) {
            $obj = array(
                'page_title' => 'Reservations',
                'page' => 'reservations'
            );

            $this->load->view('header', $obj);
            $this->load->view('frontdesk/reservations');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function status() {
        if (logged_in()) {
            $guest_id = $this->uri->segment(3);
            $obj = array(
                'page_title' => 'Pending Balances',
                'page' => 'status',
                /*'checkin_details' => $this->Admin_model->_get_checkin_data_status()*/
                'checkin_distinct' => $this->Admin_model->_get_checkin_data_by_guest_dashboard_distinct(),
                'checkin_details' => $this->Admin_model->_get_checkin_data_by_guest_dashboard()

            );

            $this->load->view('header', $obj);
            $this->load->view('frontdesk/status');
            $this->load->view('footer');

        } else {
            redirect('auth/signin', 'refresh');
        }
    }
     public function checkout() {
        if (logged_in()) {

            $service_id = $this->input->post('service_id');
            $data = array(
                'status' => 0,
                'checkout_date' => date($this->input->post('checkout_date')),
                'total_amount' => $this->input->post('total_amount'),
                'total_amount_paid' => $this->input->post('amount_paid'),
                'other_charges' => $this->input->post('other_charges'),
                'change_amount' => $this->input->post('change')
            );
            $this->Admin_model->_checkout($service_id, $data);
            $this->session->set_flashdata('success', 'Checked-out Successfully!');

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
            $this->Admin_model->_edit_guest_info($guest_id, $data);

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
                 "url" => 'http://localhost/hotel/frontdesk/guest_details/' . $r->guest_id
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

     public function view_full_invoice(){
        $guest_id = $this->uri->segment(3);
         $group_id = $this->uri->segment(4);

        if (logged_in()) {
          $data = array(
            'checkin_data' => $this->Admin_model->_get_checkin_data_by_guest($guest_id),
            //'rooms_data' => $this->Admin_model->_get_rooms_by_group($group_id)
            'payment_data' => $this->Admin_model->_get_payment_by_guest_id($guest_id),
          );
          echo json_encode($data);
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function view_bill(){
        $service_id = $this->uri->segment(3);
        $guest_id = $this->uri->segment(4);
        if (logged_in()) {
          $data = array(
            'checkin_data' => $this->Admin_model->_get_checkin_data($service_id),
            'rooms_data' => $this->Admin_model->_get_rooms_by_guest_bill($service_id),
          );
          echo json_encode($data);
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

     public function add_payment () {
         if (logged_in()) {
            $service_id = $this->input->post('checkin_service_id');
            $guest_id = $this->input->post('checkin_guest_id');

            if($this->input->post('payment_amount_due') <= $this->input->post('payment_amount'))
            {
                $this->Admin_model->_delete_other_charges($service_id);
            }

            if($this->input->post('payment_amount') >= $this->input->post('other_charges_txt')) {
                $this->Admin_model->_delete_other_charges($service_id);
            }
            

            $data2 = array(
                'service_id' => $service_id,
                'guest_id' => $guest_id,
                'total_amount_due' => $this->input->post('payment_amount_due'),
                'payment_amount' => $this->input->post('payment_amount')
            );
            $service_id = $this->Admin_model->_add_payment($data2);


            $this->session->set_flashdata('success', 'Payment Added Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function add_payment_guest () {
         if (logged_in()) {
            $service_id = $this->input->post('checkin_service_id');
            $guest_id = $this->input->post('checkin_guest_id');
            $data2 = array(
                'guest_id' => $guest_id,
                'total_amount_due' => $this->input->post('payment_amount_due'),
                'payment_amount' => $this->input->post('payment_amount')
            );
            $service_id = $this->Admin_model->_add_payment($data2);

            $pymnt_due = $this->input->post('payment_amount_due');
            $pymnt = $this->input->post('payment_amount');
            $result = $pymnt_due - $pymnt;
            $data3 = array(
                'amount' => $result
            );
            $service_id = $this->Admin_model->_update_other_charges($data3,$guest_id,$this->input->post('payment_amount_due'));

            $this->session->set_flashdata('success', 'Payment Added Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }


    public function add_full_payment () {
         if (logged_in()) {
            $guest_id = $this->input->post('checkin_guest_id');
            $service_id = $this->input->post('checkin_service_id');
            $data2 = array(
                'service_id' => 0,
                'guest_id' => $guest_id,
                'total_amount_due' => $this->input->post('payment_amount_due'),
                'payment_amount' => $this->input->post('payment_amount_due'),
                'has_advance_or_full' =>1
            );
            $service_id = $this->Admin_model->_add_payment($data2);

            $this->session->set_flashdata('success', 'Full Payment Added Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function add_advance_payment () {
         if (logged_in()) {
            $guest_id = $this->input->post('checkin_guest_id');
            $service_id = $this->input->post('checkin_service_id');
            $balance = $this->input->post('payment_amount_due');
            if($balance == $this->input->post('payment_amount')){
                $data = array(
                'service_id' => 0,
                'guest_id' => $guest_id,
                'total_amount_due' => $this->input->post('payment_amount_due'),
                'payment_amount' => $this->input->post('payment_amount'),
                'has_advance_or_full' =>1
            );
            $service_id = $this->Admin_model->_add_payment($data);
            }else{
               $data = array(
                'advance_payment' => $this->input->post('payment_amount')
            );
            $service_id = $this->Admin_model->_edit_checkin_details($service_id, $data); 
            }
            

            $this->session->set_flashdata('success', 'Full Payment Added Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function add_charges() {
        if (logged_in()) {
            $service_id = $this->input->post('service_id2');
            $guest_id = $this->input->post('guest_id2');
            $data = array(
                'service_id' => $service_id,
                'guest_id' => $guest_id,
                'description' => $this->input->post('desc'),
                'amount' => $this->input->post('amt')
            );
            $service_id = $this->Admin_model->_add_charges($service_id, $data);

            $this->session->set_flashdata('success', 'Other Charges Added Successfully!');
            redirect($_SERVER['HTTP_REFERER']);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    //francis
    public function get_all_banned_customer() {
        if (logged_in()) {

            $obj = array(
                'banned_customer' => $this->Admin_model->_get_banned_customer()
            );
            echo json_encode($obj);

        } else {
            redirect('auth/signin', 'refresh');
        }
    }
    //francis
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

    //Francis Dy
    public function add_banned_guest() {

      if (logged_in()) {
        $fullname =  $this->input->post('firstname') . $this->input->post('lastname');
        if(!$this->input->post('firstname') && !$this->input->post('lastname')) { $fname = "thumbnail"; } else { $fname = $fullname; }

        $photo = "";
        if ($_FILES['photo']) {
          $image = $this->upload_image( 'photo', 'jpg|jpeg|png', './assets/img/thumbnails/', $fname);

          if(isset($image)) {
            $photo = $image['upload_data']['file_name'];
          }

        }

        $data = array(
          'firstname' => $this->input->post('firstname'),
          'lastname' => $this->input->post('lastname'),
          'photo' => $photo,
          'is_banned' => 1
        );


        $guest_id = $this->Admin_model->_add_guest_info($data);
        $this->session->set_flashdata('success', 'Added Successfully!');
        redirect($_SERVER['HTTP_REFERER']);
        // echo json_encode(array('status' => TRUE ));

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

 public function update_advance_payment() {
    if (logged_in()) {
         $balance = $this->input->post('balance_amount');
         $service_id = $this->input->post('advance_service_id');
         $guest_id = $this->input->post('advance_guest');
         $data = array(
             'advance_payment' => $balance,
         );
         $data2 = array(
             'service_id' => 0,
             'guest_id' => $guest_id,
             'total_amount_due' => $balance,
             'payment_amount' => $balance,
             'has_advance_or_full' => 0
         );


         $service_id = $this->Admin_model->_add_payment($data2);
         $this->Admin_model->_update_advance_payment($data, $guest_id);

         $this->session->set_flashdata('success', 'Balance Successfully Removed!');
         redirect($_SERVER['HTTP_REFERER']);

     } else {
         redirect('auth/signin', 'refresh');
     }
 }

 public function edit_recent_payment() {
    if (logged_in()) {
         $payment_id = $this->input->post('payment_id');
         $data = array(
             'payment_amount' => $this->input->post('payment_amount'),
         );
         $this->Admin_model->_update_recent_payment($data, $payment_id);

         $this->session->set_flashdata('success', 'Payment Successfully Edited!');
         redirect($_SERVER['HTTP_REFERER']);

     } else {
         redirect('auth/signin', 'refresh');
     }
 }

}
