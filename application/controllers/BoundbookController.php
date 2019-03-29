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
            'signature_14' => $formData['signature'],
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

}
