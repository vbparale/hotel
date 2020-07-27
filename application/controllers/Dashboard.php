<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard extends CI_Controller
{

    public $user_id = '';
    public $role_id = '';

    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->user_id = user('id');
        $this->role_id = user('role');
    }

    public function index()
    {
       
        switch ($this->role_id) {
            case 1:
                $this->_admin();
                break;
            case 2:
                $this->_frontdesk();
                break;
            case 3:
                $this->_cashier();
                break; 
        }
    }

    public function _admin()
    {
        if (logged_in()) {
            redirect('admin/dashboard', 'refresh');
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

    public function _frontdesk()
    {
        if (logged_in()) {
            redirect('frontdesk/dashboard', 'refresh');
        } else {
            redirect('auth/signin', 'refresh');
        }
    }

     public function _cashier()
    {
        if (logged_in()) {
            redirect('cashier/dashboard', 'refresh');
        } else {
            redirect('auth/signin', 'refresh');
        }
    }



}