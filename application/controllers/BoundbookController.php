<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BoundbookController extends CI_Controller
{

    /**
     * Index Page for this controller.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BoundbookModel', 'boundbook');
        $this->load->model('State_model');
        $this->load->model('SecD_firearms_model', 'SecD_firearms');
        $this->load->helper('string');
    }


    public function index()
    {


    }

    public function fill_sectionA($id=NULL){

        if(empty($id)){

            $data['states'] = $this->State_model->get_all_state();
            $data['page'] = 'pages/buyerForm';
            $data['sectionTitle'] =  'Section A - Must be Completed Personally by the Buyer';
            $this->load->view('layouts/app', $data);
            return false;
        }

        $data['record'] = $this->boundbook->getRecordById($id);

        if(empty($data['record'])){
            show_404();
            return false;
        }

        $data['states'] = $this->State_model->get_all_state();

        $data['page'] = 'pages/buyerForm';
        $data['sectionTitle'] =  'Section A - Must be Completed Personally by the Buyer';
        $this->load->view('layouts/app', $data);

    }

    /**
     * @return mixed
     */
    public function saveForm()
    {
        if (!$this->input->is_ajax_request()) {
            return $this->output->set_status_header(400)->set_content_type('application/json')->set_output(array('error' => 'An error has occurred, please try again!'));
        }

        $this->load->library('form_validation');
        parse_str($_POST['formData'], $formData);
        $validate = $this->validationRules($formData);

        if ($validate['errors']) {
            return $this->output->set_status_header(422)->set_content_type('application/json')->set_output(json_encode($validate['errors']));
        }
        $this->load->helper('measure');
        $image_name = '';

        $data['errors'] = [];
        $data['success'] = [];
        $record = '';

        if(!empty($formData['id'])){

            $record = $this->boundbook->getRecordById($formData['id']);
        }

        if ($this->input->post('signature') == '' && empty($record['signature_14'])) {

            $data['errors'][] = 'Signature field is required.';
            echo json_encode($data);
            return false;
        }

        $signature = str_replace('[removed]', '', $this->input->post('signature'));
        $signature = base64_decode($signature);

        $image_name = random_string('alnum', 16) . '.png';


        $data = array(
            'first_name_1' => $formData['fName'],
            'middle_name_1' => $formData['mName'],
            'last_name_1	' => $formData['lName'],
            'date_filled_14' => date('Y-m-d H:i:s'),
            'birth_place_us_3' => $formData['birthPlace'] === 'US' ? 1 : 0,
            'birth_city_3' => $formData['birthCity'],
            'birth_state_3' => $formData['birthState'],
            'birth_country_3' => $formData['foreignCountry'],
            'birth_date_7' => $formData['datepicker'] ? date('Y-m-d H:i:s', strtotime($formData['datepicker'])) : null,
            'height_4' => feetIn2Cm($formData['height-ft'], $formData['height-in']),
            'weight_5' => round($formData['weight'], 2),
            'gender_6' => (empty($formData['gender'])?'Male':$formData['gender']),
            'home_address1_2' => $formData['homeAddress1'],
            'home_address2_2' => $formData['homeAddress2'],
            'home_city_2' => $formData['homeCity'],
            'home_state_2' => $formData['homeState'],
            'home_zip_2' => $formData['homeZip'],
            'home_county_2' => $formData['residencyState'],
            'us_citizen_12a' => (!empty($formData['residencyCountry']))?$formData['residencyCountry']:0,
            'other_country_citizen_12a' => $formData['otherCountryCitizen'],
            'ethnicity_hispanic_or_latino_10a' => $formData['ethnicity'] === 1 ? 1 : 0,
            'ethnicity_not_hispanic_or_latino_10a' => $formData['ethnicity'] === 1 ? 1 : 0,
            'race_american_indian_or_alaskan_10b' => $formData['indianOrAk'],
            'race_asian_10b' => $formData['asianRace'],
            'race_black_or_african_american_10b' => $formData['blackOrAfro'],
            'race_native_hawaiian_10b' => $formData['raceNativeHawaiian'],
            'race_white_10b' => $formData['isRaceWhite'],
            'actual_transferee_11a' => $formData['isActualTransferee'],
            'uder_indictment_11b' => $formData['isUnderIndictment'],
            'convicted_11c' => $formData['isConvicted'],
            'fugitive_11d' => $formData['isFugitive'],
            'addicted_11e' => $formData['isAddicted'],
            'adjudicated_11f' => $formData['isAdjudicated'],
            'discharged_11g' => $formData['isDischarged'],
            'misdemeanor_11i' => $formData['haveMisdemeanor'],
            'restraining_11h' => $formData['isRestraining'],
            'renounced_12b' => $formData['isRenouncedUsCitizenship'],
            'illegal_12c' => $formData['isIllegally'],
            'alien_12d' => $formData['alienWithNonimmigrantVisa'],
            'alien_exceptions_12e' => $formData['withinAlienExceptions'],
            'alient_admission_number_12f' => $formData['alienAdmissionNumber'],
            'social_security_number_8' => $formData['socialSecNumber'],
            'phone' => $formData['phoneNumber'],
            'email' => $formData['email'],
            'unique_personal_identification_number_9' => $formData['upin'],
            'signature_14' => $image_name,
        );


        if(empty($formData['id'])){

            $return_id = $this->boundbook->saveFromData($data);

            if (!$return_id) {
                $data['errors'][] = 'An error has occurred, please try again!';
                echo json_encode($data);
                return false;
            }
        }else{
            $this->boundbook->update_boundook($formData['id'], $data);
            $return_id = $formData['id'];
        }



        if ($image_name != '') {

            $dir = FCPATH . '/public/images/' . $return_id;

            if (!is_dir($dir)) {
                mkdir($dir, 0775, TRUE);
            }

            file_put_contents($dir . '/' . $image_name, $signature);
        }
        $data['success'][] = 'Your information successfully saved.';
        $data['status'][] = 'success';
        echo json_encode($data);
        return false;
    }

    /**
     * @param $data
     * @return array
     */
    public function validationRules($data)
    {
        $rules = array(
            array(
                'field' => 'fName',
                'label' => 'First Name',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'mName',
                'label' => 'Middle Name',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'lName',
                'label' => 'Last Name',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'datepicker',
                'label' => 'Birth Date',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'birthPlace',
                'label' => 'Birth Place',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'birthState',
                'label' => 'Birth State',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'birthCity',
                'label' => 'Birth City',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'foreignCountry',
                'label' => 'Place Of Date',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'height-ft',
                'label' => 'Height foot',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'height-in',
                'label' => 'Height inches',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'weight',
                'label' => 'Weight',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'homeAddress1',
                'label' => 'Home Address1',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'homeAddress2',
                'label' => 'Home Address2',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'homeZip',
                'label' => 'Home Zip',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'homeState',
                'label' => 'Home State',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'homeCity',
                'label' => 'Home City',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'residencyState',
                'label' => 'State of Residency',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'residencyCountry',
                'label' => 'Country of Residency',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'citizenship',
                'label' => 'Citizenship',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'ethnicity',
                'label' => 'Ethnicity',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'indianOrAk',
                'label' => 'AM Indian or AK Native',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'asianRace',
                'label' => 'Race Asian',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'blackOrAfro',
                'label' => 'Black or African American',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'raceNativeHawaiian',
                'label' => 'Native HAW / Pacific Is.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isRaceWhite',
                'label' => 'White',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isActualTransferee',
                'label' => 'Question 11.a.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isUnderIndictment',
                'label' => 'Question 11.b.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isConvicted',
                'label' => 'Question 11.c.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isFugitive',
                'label' => 'Question 11.d.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isAddicted',
                'label' => 'Question 11.e.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isAdjudicated',
                'label' => 'Question 11.f.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isDischarged',
                'label' => 'Question 11.g.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'haveMisdemeanor',
                'label' => 'Question 11.i.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isRenouncedUsCitizenship',
                'label' => 'Question 12.b.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isRestraining',
                'label' => 'Question 11.h.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'isIllegally',
                'label' => 'Question 12.c.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'alienWithNonimmigrantVisa',
                'label' => 'Question 12.d.',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'withinAlienExceptions',
                'label' => 'Question 12.d.2',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'alienAdmissionNumber',
                'label' => 'Question 13',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'socialSecNumber',
                'label' => 'Social Security Number',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'phoneNumber',
                'label' => 'Phone',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            array(
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'trim|xss_clean|strip_tags|valid_email'
            ),
            array(
                'field' => 'upin',
                'label' => 'Upin',
                'rules' => 'trim|xss_clean|strip_tags'
            ),
        );

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === false) {
            $errors = validation_errors();
            return array('errors' => $errors);
        } else {
            return array('errors' => null);
        }

    }

    public function fill_sectionB($id = NULL)
    {

        if (empty($id)) {

            show_404();
            return false;
        }

        $record = $this->boundbook->getRecordById($id);

        if (empty($record)) {
            show_404();
            return false;
        }

        $data['states'] = $this->State_model->get_all_state();

        $data['record'] = $record;
        $data['id'] = $id;
        $data['page'] = 'pages/sectionB';
        $data['sectionTitle'] = 'Section B - Must be Completed Personally by the Buyer';

        $this->load->view('layouts/app', $data);
    }

    public function ax_save_sectionB()
    {

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $record = $this->boundbook->getRecordById($this->input->post('record_id'));

        $data['errors'] = [];

        if (empty($record)) {
            $data['errors'][] = 'Record not found.';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH . '/public/images/' . $this->input->post('record_id');

        $update_data = [
            'handgun_options' => $this->input->post('handgun_options'),
            'long_gun_options' => $this->input->post('long_gun_options'),
            'other_firearm' => $this->input->post('other_firearm'),
            'name_of_functions' => $this->input->post('name_of_functions'),
            'function_state' => $this->input->post('function_state'),
            'function_city' => $this->input->post('function_city'),
            'issuing_authority' => $this->input->post('issuing_authority'),
            'type_of_identification' => $this->input->post('type_of_identification'),
            'number_identification' => $this->input->post('number_identification'),
            'identification_exp_date' => $this->input->post('identification_exp_date'),
            'government_issued_documentation' => $this->input->post('government_issued_documentation'),
            'exception_documentation' => $this->input->post('exception_documentation'),
            'transaction_number' => $this->input->post('transaction_number'),
            'd19_nics_options' => $this->input->post('d19_nics_options'),
            'e19_nics_options' => $this->input->post('e19_nics_options'),
            'f19_name' => $this->input->post('f19_name'),
            'f19_number' => $this->input->post('f19_number'),
            'issuance_date' => $this->input->post('issuance_date'),
            'date_19a' => $this->input->post('date_19a'),
            'expiration_date' => $this->input->post('expiration_date'),
            'transferred_date' => $this->input->post('transferred_date'),
            'g19_name' => $this->input->post('g19_name'),
            'd19_nics_date' => $this->input->post('d19_nics_date'),
            'e19_nics_date' => $this->input->post('e19_nics_date'),
            'nifs_20' => $this->input->post('nifs_20'),
            'nifc_21' => $this->input->post('nifc_21'),
            'state_permit_dade' => $this->input->post('state_permit_dade'),
            'permit_number' => $this->input->post('permit_number'),
            'transferror_seller_title' => $this->input->post('transferror_seller_title'),
            'c19_nics_options' => $this->input->post('c19_nics_options'),
            'state_transaction' => $this->input->post('state_transaction'),
            'transferror_seller_fname' => $this->input->post('transferror_seller_fname'),
        ];


        if (!is_dir($url)) {
            mkdir($url, 0775, TRUE);
        }

        if ($this->input->post('signature') != '') {

            $signature = str_replace('[removed]', '', $this->input->post('signature'));
            $signature = base64_decode($signature);

            $signature_name = random_string('alnum', 16) . '.png';

            file_put_contents($url . '/' . $signature_name, $signature);

            $update_data['secB_signature'] = $signature_name;

            if(!empty($record['secB_signature']) && file_exists($url.'/'.$record['secB_signature'])){

                unlink($url.'/'.$record['secB_signature']);
            }
        }

        $config['upload_path'] = $url;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 4096;
        $config['file_name'] = random_string('numeric', 10).'.png';
        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('identification_photo_id') == true) {

            $update_data['identification_photo_id'] = $config['file_name'];

            if(file_exists($url.'/'.$record['identification_photo_id'])){

                unlink($url.'/'.$record['identification_photo_id']);
            }
        }

        $config['file_name'] = random_string('numeric', 10).'.png';

        $this->upload->initialize($config);

        if ($this->upload->do_upload('government_photo') == true) {

            $update_data['government_photo'] = $config['file_name'];

            if(file_exists($url.'/'.$record['government_photo'])){

                unlink($url.'/'.$record['government_photo']);
            }

        }

        $config['file_name'] = random_string('numeric', 10).'.png';
        $this->upload->initialize($config);

        if ($this->upload->do_upload('exception_photo') == true) {

            if(file_exists($url.'/'.$record['exception_photo'])){

                unlink($url.'/'.$record['exception_photo']);
            }

            $update_data['exception_photo'] = $config['file_name'];

        }

        $result = $this->boundbook->update_boundook($this->input->post('record_id'), $update_data);

        echo json_encode($data);
    }

    public function fill_sectionD($id){

        if (empty($id)) {

            show_404();
            return false;
        }

        $record = $this->boundbook->getRecordById($id);

        if (empty($record)) {
            show_404();
            return false;
        }

        $data['firearms'] = $this->SecD_firearms->get_firearms_data(['boundbook_id'=>$id]);
        $data['record'] = $record;
        $data['states'] = $this->State_model->get_all_state();
        $data['id'] = $id;
        $data['page'] = 'pages/sectionD';
        $data['sectionTitle'] = 'Section B - Must be Completed Personally by the Buyer';

        $this->load->view('layouts/app', $data);
    }

    public function ax_save_sectionD(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $rec_id = $this->input->post('record_id');

        $record = $this->boundbook->getRecordById($rec_id);

        $data['errors'] = [];

        if (empty($record)) {
            $data['errors'][] = 'Record not found.';
            echo json_encode($data);
            return false;
        }

        if ($this->input->post('signature') == '' && empty($record['sec_d_signature'])) {

            $data['errors'][] = 'Signature field is required.';
            echo json_encode($data);
            return false;
        }

        $url = FCPATH . '/public/images/' . $rec_id;

        $boundock_update_data = [
            'sec_d_one'            => $this->input->post('sec_d_one'),
            'sec_d_30_1'           => $this->input->post('sec_d_30_1'),
            'sec_d_30_2'           => $this->input->post('sec_d_30_2'),
            'sec_d_32'             => $this->input->post('sec_d_32'),
            'sec_d_31'             => $this->input->post('sec_d_31'),
            'sec_d_33'             => $this->input->post('sec_d_33'),
            'sec_d_transfer_fname' => $this->input->post('sec_d_transfer_fname'),
            'sec_d_transfer_title' => $this->input->post('sec_d_transfer_title'),
            'sec_d_transfer_date'  => $this->input->post('sec_d_transfer_date'),
        ];

        $signature = str_replace('[removed]', '', $this->input->post('signature'));
        $signature = base64_decode($signature);

        $signature_name = random_string('alnum', 16) . '.png';

        file_put_contents($url . '/' . $signature_name, $signature);

        $boundock_update_data['sec_d_signature'] = $signature_name;

        if(!empty($record['sec_d_signature']) && file_exists($url.'/'.$record['sec_d_signature'])){

            unlink($url.'/'.$record['sec_d_signature']);
        }

        $insert_update_data = [];

        $secD_firearms = $this->SecD_firearms->get_firearms_data(['boundbook_id'=>$rec_id]);

        foreach ($this->input->post('manufacturer_importer') as $index => $value){

            $insert_update_data[] = [
                'boundbook_id'          => $rec_id,
                'manufacturer_importer' => (!empty($this->input->post('manufacturer_importer')[$index]))?$this->input->post('manufacturer_importer')[$index]:'',
                'model'                 => (!empty($this->input->post('model')[$index]))?$this->input->post('model')[$index]:'',
                'serial_number'         => (!empty($this->input->post('serial_number')[$index]))?$this->input->post('serial_number')[$index]:'',
                'type'                  => (!empty($this->input->post('type')[$index]))?$this->input->post('type')[$index]:'',
                'caliber_gauge'         => (!empty($this->input->post('caliber_gauge')[$index]))?$this->input->post('caliber_gauge')[$index]:'',
            ];
        }

        if(!empty($secD_firearms)){

            $this->SecD_firearms->delete_data($rec_id);
        }

        $this->SecD_firearms->insert_data($insert_update_data);

        $this->boundbook->update_boundook($rec_id, $boundock_update_data);

        echo json_encode($data);
    }

    public function ax_search_zip_code(){

        if ($this->input->method() != 'post' || !$this->input->is_ajax_request()) {
            show_404();
            return false;
        }

        $this->load->library('google_api');

        $zip = trim($this->input->post("search"));
        $input_id = $this->input->post("inputid");

        $zipcode_array = $this->google_api->get_place_id($zip);

        if(empty($zipcode_array)){
            echo "no data";
            return false;
        }

        $zipcode_array['zip'] = $zip;

        $data = [
            "zip_codes_array" => $zipcode_array,
            "input_id" => $input_id
        ];
        $this->load->view('pages/answer_zip_code', $data);
    }
}
