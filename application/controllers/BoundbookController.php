<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BoundbookController extends CI_Controller
{

    /**
     * Index Page for this controller.
     */
    public function index()
    {

        $this->load->view('layouts/app', array('page' => 'pages/buyerForm', 'sectionTitle' => 'Section A - Must be Completed Personally by the Buyer'));
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

        $this->load->helper('string');

        if($this->input->post('signature') != ''){

            $signature = str_replace('[removed]', '', $this->input->post('signature'));
            $signature = base64_decode($signature);

            $dir = FCPATH.'/public/images';

            if(!is_dir($dir)){
                mkdir($dir, 0775, TRUE);
            }

            $image_name = random_string('alnum', 16).'.png';

            file_put_contents($dir.'/'.$image_name, $signature);
        }

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
            'gender_6' => $formData['gender'],
            'home_address1_2' => $formData['homeAddress1'],
            'home_address2_2' => $formData['homeAddress2'],
            'home_city_2' => $formData['homeCity'],
            'home_state_2' => $formData['homeState'],
            'home_zip_2' => $formData['homeZip'],
            'home_county_2' => $formData['residencyState'],
            'us_citizen_12a' => $formData['residencyCountry'],
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

        $this->load->model('BoundbookModel', 'boundbook');
        $result = $this->boundbook->saveFromData($data);
        if (!$result) {
            return $this->output->set_status_header(500)->set_content_type('application/json')->set_output(array('error' => 'An error has occurred, please try again!'));
        }

        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(array('status' => 'success', 'message' => 'Your information successfully saved.')));
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

    public function test()
    {

        echo '<img src="data:image/png;base64,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">';
    }

}
