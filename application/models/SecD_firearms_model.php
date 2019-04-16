<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SecD_firearms_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_firearms_data($crt){

        if(!empty($crt)){

            $this->db->where($crt);
        }

        $result = $this->db->get('sec_d_firearms')->result_array();

        return $result;
    }

    public function insert_data($data){

        return $this->db->insert_batch('sec_d_firearms', $data);
    }

    public function delete_data($boundbook_id){

        if(empty($boundbook_id)){
            return false;
        }

        $this->db->where('boundbook_id', $boundbook_id);

        return $this->db->delete('sec_d_firearms');
    }
}