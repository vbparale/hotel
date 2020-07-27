<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    public $user= "";

    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(FALSE);

    }


	public function index()
    {
        if (!logged_in()) {

            $data = array(
                'page' => "",
                'page_title' => "Sign in"
            );
            $this->load->view('header', $data);
            $this->load->view('auth/signin');
            $this->load->view('footer');
           
        } else {
            redirect('dashboard', 'refresh');
        }

    }


    public function signin()
    {
       
        if (logged_in()) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $error = "";
        if ($this->form_validation->run()) {
            if ($this->authme->signin( set_value('username'), set_value('password') )) {
                
                    $this->dashboard();
              
            } else {
                $error = 'Invalid Username and/or Password.';
            }
        }
      
        $data = array(
            'page' => "",
            'page_title' => "Sign in",
            'error' => $error
        );
        $this->load->view('header', $data);
        $this->load->view('auth/signin');
        $this->load->view('footer');
    }

    public function dashboard()
    {
       // if (!logged_in()) {
            if (user('role') == 1) {
                redirect('admin/dashboard', 'refresh');

            } elseif (user('role') == 2) {
                redirect('frontdesk/dashboard', 'refresh');
            }
            else {
                redirect('dashboard', 'refresh');
            }
        /*} else {
            $this->authme->signout('/');
        }*/
    }

    public function signout()
    {
        if (!logged_in()) {
            redirect('auth/signin');
        } else {
            $this->authme->signout('/');
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */