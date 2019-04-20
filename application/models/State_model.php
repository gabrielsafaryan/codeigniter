<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_state(){

        $result = $this->db->get('states')->result_array();

        return $result;
    }

    public function get_state_by_id($id){


    }

}