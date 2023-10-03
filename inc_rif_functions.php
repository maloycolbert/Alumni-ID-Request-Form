<?php
$environment = 'www';
if(strpos($_SERVER['HTTP_HOST'],'local') !== false) { $environment = 'local';}
if(strpos($_SERVER['HTTP_HOST'],'dev.') !== false ) { $environment = 'dev'; }
if(strpos($_SERVER['HTTP_HOST'],'test.') !== false) { $environment = 'test'; }

$current_location = current_location();

/**
 * @param $environment
 * @return string
 * Function to call the myLU Endpoints based upon the environments
 */
function mylu_link($environment) {

    switch ($environment) {
        //note: per azure rules, anything other than "localhost" must be https, so alumni.local will not be usable for this process if it doesnt have ssl
        case 'local' :
            // $mylu_link = 'https://login.microsoftonline.com/baf8218e-b302-4465-a993-4a39c97251b2/oauth2/v2.0/authorize?client_id=f06cc17b-1415-4507-ba0e-63e5ebdc8b51&response_type=code&redirect_uri=https://edu.local/alumni/new-alumni-card-request/&scope=offline_access openid';
            // $mylu_link = 'https://login.microsoftonline.com/baf8218e-b302-4465-a993-4a39c97251b2/oauth2/v2.0/authorize?client_id=f06cc17b-1415-4507-ba0e-63e5ebdc8b51&response_type=code&redirect_uri=https://alumni.local/alumni/alumni-card-request/&scope=offline_access openid';
            $mylu_link = 'https://login.microsoftonline.com/baf8218e-b302-4465-a993-4a39c97251b2/oauth2/v2.0/authorize?client_id=f06cc17b-1415-4507-ba0e-63e5ebdc8b51&response_type=code&redirect_uri=http://localhost/alumni/alumni-card-request/&scope=offline_access openid';
            break;
        case 'dev' :
            // $mylu_link = 'https://login.microsoftonline.com/baf8218e-b302-4465-a993-4a39c97251b2/oauth2/v2.0/authorize?client_id=f06cc17b-1415-4507-ba0e-63e5ebdc8b51&response_type=code&redirect_uri=https://dev.liberty.edu/wp/alumni/alumni-card-request/&scope=offline_access openid';
            $mylu_link = 'https://login.microsoftonline.com/baf8218e-b302-4465-a993-4a39c97251b2/oauth2/v2.0/authorize?client_id=f06cc17b-1415-4507-ba0e-63e5ebdc8b51&response_type=code&redirect_uri=https://alumni-dev.okd.liberty.edu/alumni-card-request/&scope=offline_access openid';
            break;
        case 'test' :
            // $mylu_link = 'https://login.microsoftonline.com/567757b6-d576-47f2-b515-0313b21ee8ee/oauth2/v2.0/authorize?client_id=b7ace2cb-59e1-4ccb-9e44-65299edbcee8&response_type=code&redirect_uri=https://test.liberty.edu/wp/alumni/alumni-card-request/&scope=offline_access openid';
            $mylu_link = 'https://login.microsoftonline.com/567757b6-d576-47f2-b515-0313b21ee8ee/oauth2/v2.0/authorize?client_id=b7ace2cb-59e1-4ccb-9e44-65299edbcee8&response_type=code&redirect_uri=https://alumni-test.okd.liberty.edu/alumni-card-request/&scope=offline_access openid';
            break;
        default :
            $mylu_link = 'https://login.microsoftonline.com/baf8218e-b302-4465-a993-4a39c97251b2/oauth2/v2.0/authorize?client_id=f06cc17b-1415-4507-ba0e-63e5ebdc8b51&response_type=code&redirect_uri=https://www.liberty.edu/alumni/alumni-card-request/&scope=offline_access openid';
    }

    return ($mylu_link);
}

function mylu_redirect_uri($environment): string {
    return get_bloginfo('url') . '/alumni-card-request/';
}


/**
 * @param $environment
 * @return string
 * Function to get to the beginning link based upon the environment
 */
function rif_beginning_link($environment) {
    return get_bloginfo('url') . '/alumni-card-request/';
}


/**
 * @param $environment
 * @param $endpoint
 * @return string
 * Function to get the submit link based upon the environment
 */
function rif_form_submit_link($environment, $endpoint): string {
        switch ($environment) {
        case 'local' :
            return true;
        case 'dev' :
            $rif_form_submitlink = 'https://is-devluo-api-dev.okd.liberty.edu/is-devluo-api/'.$endpoint;
            break;
        case 'test' :
            $rif_form_submitlink = 'https://is-devluo-api-test.okd.liberty.edu/is-devluo-api/'.$endpoint;
            break;
        case 'www' :
            $rif_form_submitlink = 'https://is-devluo-api.okd.liberty.edu/is-devluo-api/'.$endpoint;
            break;
        default :
            $rif_form_submitlink = 'https://is-devluo-api.okd.liberty.edu/is-devluo-api/'.$endpoint;
    }

    return $rif_form_submitlink;
}


/**
 * @param $environment
 * @return bool
 * Function to make sure the main endpoint is up
 */
function check_status($environment): bool {
    switch ($environment) {
        case 'local' :
            return true;
        case 'dev' :
            $status_url = 'https://is-devluo-api-dev.okd.liberty.edu/is-devluo-api/hi';
            break;
        case 'test' :
            $status_url = 'https://is-devluo-api-test.okd.liberty.edu/is-devluo-api/hi';
            break;
        case 'www' :
            $status_url = 'https://is-devluo-api.okd.liberty.edu/is-devluo-api/hi';
            break;
        default :
            $status_url = 'https://is-devluo-api.okd.liberty.edu/is-devluo-api/hi';
    }


    $url = $status_url;

    $curl_handle=curl_init();

    curl_setopt($curl_handle, CURLOPT_URL,$url);

    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);

    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl_handle);

    curl_close($curl_handle);

    if($response === 'hello') {
        return true;
    } else {
        return false;
    }


}

/**
 * @return string
 * Function to get back our current location
 * (Used in the form action process)
 */
function current_location(): string
{
    return get_bloginfo('url') . '/alumni-card-request/';
}


function rif_form_user_pass($environment): string {

    $user = getenv('ALUMNI_API_USER');
    $pass = getenv('ALUMNI_API_PASS');

    if (!$user || !$pass || !is_string($user) || !is_string($pass)) return "";
    else return $user . ':' . $pass;
}

/**
 * Function to get list of states
 * (Used to populate us state dropdown)
 */

function callStatesURL($environment) {
    switch ($environment) {
        case 'local' :
            return true;
        case 'dev' :
            $statesURL = 'https://idp-dev.liberty.edu/rest/fga/banner/stv/states/';
            break;
        case 'test' :
            $statesURL = 'https://idp-test.liberty.edu/rest/fga/banner/stv/states/';
            break;        
        default :
            $statesURL = 'https://idp.liberty.edu/rest/fga/banner/stv/states/';
    }
    

    $stateHTML = '';

    $url = $statesURL;

    $curl_handle=curl_init();

    curl_setopt($curl_handle, CURLOPT_URL,$url);

    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);

    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl_handle);

    curl_close($curl_handle);

    $response = json_decode($response);

    $state = $_POST['STUDENT']['STATE'];

    foreach($response as $key=>$value) {
        if ($state == $key) {
            $stateHTML .= "<option value=$key selected>$value</option>";
        } else {
            $stateHTML .= "<option value=$key>$value</option>";
        }
    }

    return $stateHTML;

}

function callNationsURL($environment) {
    switch ($environment) {
        case 'local' :
            return true;
        case 'dev' :
            $nationURL = 'https://idp-dev.liberty.edu/rest/fga/banner/stv/nations/';
            break;
        case 'test' :
            $nationURL = 'https://idp-test.liberty.edu/rest/fga/banner/stv/nations/';
            break;        
        default :
            $nationURL = 'https://idp.liberty.edu/rest/fga/banner/stv/nations/';
    }    

    $nationHTML = '';

    $url = $nationURL;

    $curl_handle=curl_init();

    curl_setopt($curl_handle, CURLOPT_URL,$url);

    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);

    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl_handle);

    curl_close($curl_handle);

    $response = json_decode($response);

    $nation = $_POST['STUDENT']['COUNTRY'];

    foreach($response as $key=>$value) {
        $nationHTML .= "<option value=$key>$value</option>";
    }

    return $nationHTML;

}

/**
 * Class to clean our post submission
 */
require_once(get_stylesheet_directory().'/inc/class_utils.php');

/**
 * @param $post
 * @return mixed
 * Cleans our post input and sanitize it.
 */
function clean_submission($post)
{
    $request_id_map = array(
        'firstname' => 'string|trim',
        'lastname' => 'string|trim',
        'middlename' => 'string|trim',
        'libertyuid' => 'string|trim',
        'location_url' => 'string|trim',
        'pidm' => 'string|trim',
        'username' => 'string|trim',
        'idnum' => 'string|trim',
        'email' => 'string|trim',
        'bday' => 'string|trim',
        'phone' => 'string|trim',
        'maidenname' => 'string|trim',
        'country' => 'string|trim',
        'address1' => 'string|trim',
        'address2' => 'string|trim',
        'address3' => 'string|trim',
        'address4' => 'string|trim',
        'city' => 'string|trim',
        'state' => 'string|trim',
        'zip' => 'string|trim'
    );

    $post = Kiss\Utils::array_clean($post, $request_id_map, FALSE);

    return $post;
}
