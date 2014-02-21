<?php if (!defined('BASEPATH')) die('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
    * Check if a user exists in the registration table
    * Return all their details
    */
    function login($table, $email)
    {
        $this->db->select($table.'.*');
        $this->db->from($table);
        $this->db->where($table.'.email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
}
