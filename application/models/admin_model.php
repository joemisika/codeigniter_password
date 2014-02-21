<?php if (!defined('BASEPATH')) die('No direct script access allowed');

class Admin_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /**
    * Save new data to the database and return last insert id
    *
    * @access public
    */
    public function saveinfo($table, $dbdata)
    {
        $this->db->insert($table, $dbdata);
        return $this->db->insert_id();
    }
}
