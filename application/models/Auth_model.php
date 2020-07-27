<?php

class Auth_Model extends CI_Model
{

    public $tbl;

    public function __construct()
    {
        parent::__construct();

        $this->config->load('authme');
        $this->tbl = $this->config->item('tbl_accounts');

    }

    public function get_users($order_by = 'id', $order = 'asc', $limit = 0, $offset = 0)
    {
        $this->db->order_by($order_by, $order);
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get($this->tbl);
        return $query->result();
    }

    public function get_user_by_username($username, $password)
    {
        $obj = array(
            'username' => $username,
            'password' => $password
        );

        $query = $this->db->get_where($this->tbl, $obj);
        return ($query->num_rows()) ? $query->row() : false;
    }


}