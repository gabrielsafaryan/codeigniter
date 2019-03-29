<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BoundbookModel extends CI_Model
{

    /**
     * @param array $data
     * @return mixed
     */
    public function saveFromData($data)
    {
        try {
            $queryResult = $this->db->insert('boundbook_4473', $data);
        } catch (Exception $e) {
            log_message('error', 'Error in file ' . $e->getFile() . ', in line ' . $e->getLine() . '. Message is ' . $e->getMessage());
            return;
        }

        return $queryResult;
    }

    /**
     * @param integer $id
     * @return array|boolean
     */
    public function getRecordById($id)
    {
        try {
                $queryResult = $this->db->get_where('boundbook_4473', array('id' => $id));
            if (!$queryResult) {
                throw new Exception('An error has occurred during the getting record from DB.');
            }
        } catch (Exception $e) {
            log_message('error', 'Error in file ' . $e->getFile() . ', in line ' . $e->getLine() . '. Message is ' . $e->getMessage());
            return false;
        }
        return $queryResult->row_array();
    }

}