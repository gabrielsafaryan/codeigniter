<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google_api
{
    private $Google_Maps_Distance_Matrix_API_Key = 'AIzaSyAkN75HQ0wpAJEQ73M3hlsh2KEZkS2AnOo'; // AIzaSyDICQSPPb1aYLgdnPQTtzfvfwgh6-9wS8E
    private $Maps_Embed_API                      = 'AIzaSyAkN75HQ0wpAJEQ73M3hlsh2KEZkS2AnOo'; // AIzaSyA2fOimuZ1qcFq8rZg2WI6fzVhjtHb_Di4
    private $Geocode_API_Key                     = 'AIzaSyDpQFWb2RWEJvc-P8e1EBzvmwCLscIeP1w'; // AIzaSyAPfz4PEBWLvF4Y66HNl-0hV9vJpP_V8Sg
    private $CI;
    private $request_limit = '5';

    public function __construct(){
        $this->CI = get_instance();
    }
    public function get_distance_by_zip($zip_1, $zip_2, $table = 'lts_us_zipcode'){
        $this->CI->load->model('Order_model');
        $info1 = $this->CI->Order_model->get_data_by_zip_code($table, $zip_1);
        $info2 = $this->CI->Order_model->get_data_by_zip_code($table, $zip_2);
        if( empty($info1['latitude']) || empty($info1['longitude']) ||
            empty($info2['latitude']) || empty($info2['longitude']) ){
            $data_error = [
                'zip_1' => $zip_1,
                'zip_2' => $zip_2,
                'error' => 'No coordinate info on db or incorrect zip code.'
            ];
            $this->log_error($data_error);
            return false;
        }
        $lat1 = $info1['latitude'];
        $lon1 = $info1['longitude'];
        $lat2 = $info2['latitude'];
        $lon2 = $info2['longitude'];
        $result = $this->get_distance($lat1, $lon1, $lat2, $lon2);
        if(empty($result)){
            return false;
        }
        return $result;
    }


    public function get_place_id($zip, $all = false){

        $limit = $this->request_limit;

        $debugging = [
            'function' => 'get_place_id',
            'params'   => 'zip -> '.$zip,
        ];

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:'.$zip.'|country:US&key='.$this->Geocode_API_Key;

/*        while($limit > 0){
            $limit --;
            if(empty($result_string = $this->get_web_page($url))){
                continue;
            }

            $result = json_decode($result_string, true);
            if($result['status'] !== 'OK'){
                continue;
            }
            break;
        }*/

        $result_string = $this->get_web_page($url);

        if(empty($result_string)){
            $debugging['error'] = $result_string;
            $this->log_error($debugging);
            return false;
        }
       /* if($result_string['status'] !== 'OK'){
            $debugging['error'] = $result_string;
            $this->log_error($debugging);
            return false;
        }*/

        $result = json_decode($result_string['content']);

        if(empty($result->results)){
            return false;
        }

        $return_data = [
            'city' => '',
            'state' => '',
        ];

        foreach ($result->results[0]->address_components as $val){

            if($val->types[0] == 'locality'){
                $return_data['city'] = $val->long_name;
            }

            if($val->types[0] == 'administrative_area_level_1'){
                $return_data['state'] = $val->long_name;
            }
        }

        return $return_data;
    }

    public function search_place($search){
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$search.'&sensor=true&key='.$this->Maps_Embed_API;
        if(empty($result_string = $this->php_curl(array('url'=> $url)))){
            return false;
        }
        $result = json_decode($result_string, true);
        if($result['status'] !== 'OK'){
            return false;
        }
        return $result['results'][0];
    }
    public function php_curl($array) {
        if(empty($array['url'])) {
            return false;
        }
        $url = $array['url'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
    public function get_web_page( $url )
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 5,        // timeout on connect
            CURLOPT_TIMEOUT        => 5,        // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );
        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
    public function google_map_search($search){
        $src = 'https://www.google.com/maps/embed/v1/place?q='.$search.'&key='.$this->Maps_Embed_API;
        return $src;
    }
    public function google_map_multi_search($search){
        $src = 'https://www.google.com/maps/embed/v1/search?q='.$search.'&key='.$this->Maps_Embed_API;
        return $src;
    }
    public function calculate_distance($lat1, $lon1, $lat2, $lon2){
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) *sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515 * 1.2073;
        return number_format($miles, 2, '.', '');
    }
    public function log_error($data){
        $url = FCPATH.'google_log.html';
        $caller = 'Error';
        $data = '<pre>'.var_export($data, true).'</pre>';
    }

}
?>