<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormsListController extends CI_Controller
{

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->load->view('layouts/app', array('page' => 'pages/formsList'));
    }

    public function getList()
    {
        $start = $this->input->post('start') ? $this->input->post('start') : 0;
        $limit = $this->input->post('length') ? $this->input->post('length') : 10;
        $searchArr = $this->input->post('search');
        $value = $searchArr['value'];
        $orderArr = $this->input->post('order');
        $order = $orderArr[0];

        $query = $query = $this->db->select('id', 'first_name_1', 'last_name_1', 'date_filled_14');
        $totalRecords = $query->count_all_results('boundbook_4473');

        if (!empty($value)) {
            $query->like('first_name_1', $value)
                ->or_like('last_name_1', $value);
        }

        $recordsFiltered = $query->count_all_results('boundbook_4473');

        switch ($order['column']) {
            case 0:
                $i = 'id';
                break;
            case 3 :
                $i = 'date_filled_14';
                break;
            default:
                $i = 'date_filled_14';
        }

        if ($limit > 0) {
            $query = $query->offset($start)->limit($limit);
        }

        $filteredData = $query->order_by($i, $order['dir'])->get('boundbook_4473')->result_array();

        $result = array(
            'data' => $filteredData,
            'draw' => $this->input->post('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
        );

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function pdfDownload()
    {
        if (empty($this->input->get('id'))) {
            return $this->output->set_status_header(400)->set_content_type('application/json')->set_output(array('error' => 'An error has occurred, please try again!'));
        }
        $id = $this->input->get('id');
        $this->load->model('BoundbookModel', 'boundbook');
        $this->load->helper(array('measure', 'date'));
        $record = $this->boundbook->getRecordById($id);

        $data = array(
            'form1[0].page1[0].TextField2[0]' => $record['first_name_1'],
            'form1[0].page1[0].TextField2[1]' => $record['last_name_1'],
            'form1[0].page1[0].TextField2[2]' => $record['middle_name_1'],
            'form1[0].page1[0].TextField3[1]' => $record['home_city_2'],
            'form1[0].page1[0].TextField3[2]' => $record['home_county_2'],
            'form1[0].page1[0].TextField4[0]' => $record['home_state_2'],
            'form1[0].page1[0].TextField4[1]' => $record['home_zip_2'],
            'form1[0].page1[0].TextField5[0]' => $record['birth_place_us_3'] ? $record['birth_city_3'] . ' ' . $record['birth_state_3'] : '',
            'form1[0].page1[0].TextField6[0]' => $record['birth_country_3'],
            'form1[0].page1[0].TextField7[0]' => cm2feetIn($record['height_4'])['ft'],
            'form1[0].page1[0].TextField7[1]' => cm2feetIn($record['height_4'])['in'],
            'form1[0].page1[0].TextField8[0]' => kg2pound($record['weight_5']),
            'form1[0].page1[0].TextField9[0]' => date('F', strtotime($record['birth_date_7'])),
            'form1[0].page1[0].TextField9[1]' => date('d', strtotime($record['birth_date_7'])),
            'form1[0].page1[0].TextField9[2]' => date('Y', strtotime($record['birth_date_7'])),
            'form1[0].page1[0].TextField10[0]' => $record['social_security_number_8'],
            'form1[0].page1[0].TextField11[0]' => $record['unique_personal_identification_number_9'],
            'form1[0].page1[0].CheckBox1[0]' => $record['ethnicity_hispanic_or_latino_10a'],
            'form1[0].page1[0].CheckBox2[0]' => $record['ethnicity_not_hispanic_or_latino_10a'],
            'form1[0].page1[0].CheckBox1[1]' => $record['race_american_indian_or_alaskan_10b'],
            'form1[0].page1[0].CheckBox2[1]' => $record['race_asian_10b'],
            'form1[0].page1[0].CheckBox1[2]' => $record['race_black_or_african_american_10b'],
            'form1[0].page1[0].CheckBox2[2]' => $record['race_native_hawaiian_10b'],
            'form1[0].page1[0].CheckBox2[3]' => $record['race_white_10b'],
            'form1[0].page1[0].RadioButtonList1[0]' => intval($record['actual_transferee_11a']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList2[0]' => intval($record['uder_indictment_11b']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList3[0]' => intval($record['convicted_11c']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList4[0]' => intval($record['fugitive_11d']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList5[0]' => intval($record['addicted_11e']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList6[0]' => intval($record['adjudicated_11f']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList7[0]' => intval($record['discharged_11g']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList8[0]' => intval($record['restraining_11h']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList9[0]' => intval($record['misdemeanor_11i']) ? 1 : 2,
            'form1[0].page1[0].CheckBox2[4]' => intval($record['us_citizen_12a']) ? 1 : 2,
            'form1[0].page1[0].CheckBox2[5]' => intval($record['us_citizen_12a']) ? 2 : 1,
            'form1[0].page1[0].TextField22[0]' => intval($record['us_citizen_12a']) ? '' : $record['other_country_citizen_12a'],

            'form1[0].page1[0].RadioButtonList10[0]' => intval($record['renounced_12b']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList11[0]' => intval($record['illegal_12c']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList12[0]' => intval($record['alien_12d']) ? 1 : 2,
            'form1[0].page1[0].RadioButtonList13[0]' => (intval($record['alien_exceptions_12e']) === 1) ? 1 : ((intval($record['alien_exceptions_12e']) === 2) ? 3 : 2),
            'form1[0].page1[0].TextField21[0]' => $record['alient_admission_number_12f'],
            'signature' => $record['signature_14'],
            'form1[0].page2[0].DateField1[0]' => date('F d Y', strtotime($record['date_filled_14'])),
        );

        $params = [
            'pdfUrl' => base_url('public/CI.pdf'),
            'data' => $data,
        ];

        $this->load->library('PDFtk/PdfForm', $params, 'pdfForm');
        $result = $this->pdfForm->flatten()->download();

        if(!empty($result)){
            unlink($result['output']);
            unlink($result['signature']);
            unlink($result['path']);

        }else{
            show_404();
        }
    }

    /**
     * @return mixed
     */
    public function getFilteredRecord()
    {
        if (!$this->input->post('id')) {
            return $this->output->set_status_header(400)->set_content_type('application/json')->set_output(array('error' => 'An error has occurred, please try again!'));
        }
        $this->load->model('BoundbookModel', 'boundbook');
        $record = $this->boundbook->getRecordById($this->input->post('id'));

        $filter = [
            'first_name_1' => ['name' => 'First Name', 'type' => 'txt'],
            'last_name_1' => ['name' => 'Last Name', 'type' => 'txt'],
            'middle_name_1' => ['name' => 'Middle Name', 'type' => 'txt'],
            'home_address1_2' => ['name' => 'Address 1', 'type' => 'txt'],
            'home_address2_2' => ['name' => 'Address 2', 'type' => 'txt'],
            'home_city_2' => ['name' => 'City', 'type' => 'txt'],
            'home_county_2' => ['name' => 'County', 'type' => 'txt'],
            'home_state_2' => ['name' => 'State', 'type' => 'txt'],
            'home_zip_2' => ['name' => 'Zip', 'type' => 'txt'],
            'birth_place_us_3' => ['name' => 'Birth Place US', 'type' => 'radio'],
            'birth_city_3' => ['name' => 'Birth City', 'type' => 'txt'],
            'birth_state_3' => ['name' => 'Birth State', 'type' => 'txt'],
            'birth_country_3' => ['name' => 'Foreign Country', 'type' => 'txt'],
            'birth_date_7' => ['name' => 'Birth Date', 'type' => 'date'],
            'height_4' => ['name' => 'Height', 'type' => 'txt'],
            'Weight' => ['name' => 'Weight', 'type' => 'txt'],
            'gender_6' => ['name' => 'Gender', 'type' => 'txt'],
            'us_citizen_12a' => ['name' => 'US Citizen', 'type' => 'radio'],
            'other_country_citizen_12a' => ['name' => 'Other Country Citizen', 'type' => 'radio'],
            'ethnicity_hispanic_or_latino_10a' => ['name' => 'Ethnicity hispanic or Latino', 'type' => 'radio'],
            'ethnicity_not_hispanic_or_latino_10a' => ['name' => 'Ethnicity not hispanic or Latino', 'type' => 'radio'],
            'race_american_indian_or_alaskan_10b' => ['name' => 'Race American Indian or Alaskan', 'type' => 'radio'],
            'race_asian_10b' => ['name' => 'Race Asia', 'type' => 'radio'],
            'race_black_or_african_american_10b' => ['name' => 'Race Black or African American', 'type' => 'radio'],
            'race_native_hawaiian_10b' => ['name' => 'Race Native Hawaiian', 'type' => 'radio'],
            'race_white_10b' => ['name' => 'Race White', 'type' => 'radio'],
            'actual_transferee_11a' => ['name' => 'Actual Transferee', 'type' => 'radio'],
            'uder_indictment_11b' => ['name' => 'Uder indictment', 'type' => 'radio'],
            'convicted_11c' => ['name' => 'Convicted', 'type' => 'radio'],
            'fugitive_11d' => ['name' => 'Fugitive', 'type' => 'radio'],
            'addicted_11e' => ['name' => 'Addicted', 'type' => 'radio'],
            'adjudicated_11f' => ['name' => 'Adjudicated', 'type' => 'radio'],
            'discharged_11g' => ['name' => 'Discharged', 'type' => 'radio'],
            'misdemeanor_11i' => ['name' => 'Misdemeanor', 'type' => 'radio'],
            'restraining_11h' => ['name' => 'Restraining', 'type' => 'radio'],
            'renounced_12b' => ['name' => 'Renounced', 'type' => 'radio'],
            'illegal_12c' => ['name' => 'Illegal', 'type' => 'radio'],
            'alien_12d' => ['name' => 'Alien', 'type' => 'radio'],
            'alien_exceptions_12e' => ['name' => 'Alien Exceptions', 'type' => 'radio'],
            'alient_admission_number_12f' => ['name' => 'Alient admission number', 'type' => 'radio'],
            'social_security_number_8' => ['name' => 'Social security number', 'type' => 'txt'],
            'phone' => ['name' => 'Social security number', 'type' => 'txt'],
            'email' => ['name' => 'Social security number', 'type' => 'txt'],
            'unique_personal_identification_number_9' => ['name' => 'UPIN', 'type' => 'txt'],
            'signature_14' => ['name' => 'Signature', 'type' => 'blob'],
        ];

        $filterdData = [];
        foreach ($record as $k => $v) {

            if ($v === '') {
                continue;
            }

            if (array_key_exists($k, $filter)) {
                if ($filter[$k]['type'] === 'radio') {
                    $value = ($v === '1') ? 'Yes' : (($v === '2') ? 'N/A' : 'No');
                } elseif ($filter[$k]['type'] === 'date') {
                    $value = date('M d Y', strtotime($v));
                } elseif ($filter[$k]['type'] === 'blob') {

                    $url = base_url() . 'public/images/' . $v;
                    $value = "<img src='$url' alt='Signature'/>";

                } else {
                    $value = $v;
                }
                $filterdData[$filter[$k]['name']] = $value;
            } else {
                continue;
            }
        }

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application / json')
            ->set_output(json_encode(['status' => 'success', 'filterdData' => $filterdData]));

    }

    public function page_pdf($id=NULL){

        if(empty($id)){
            show_404();
            return false;
        }

        $this->load->view('pdf/print_pdf');
    }
}
