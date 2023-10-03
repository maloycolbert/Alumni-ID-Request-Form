<?php
// Leave these lines for debugging purposes
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once('../../../../../wp-load.php');
require_once('inc_rif_functions.php');

$_POST = clean_submission($_POST);

// Fix the PIDM in case of guest
if (!isset($_POST['pidm']) || ($_POST['pidm'] == '')) {
    $_POST['pidm'] = '019710';
}

// Fix the username in case of guest
if (!isset($_POST['username']) || ($_POST['username'] == '')) {
    $_POST['username'] = 'guest1971';
}


$create_date = current_datetime()->format("Y-m-d H:i:s");

// Start the XML
$writer = new XMLWriter();
$writer->openMemory();
$writer->startDocument('1.0', 'UTF-8');
$writer->setIndent(0);

// Hack to write the namespace according to BizFlow
$writer->startElement('formData');
$writer->startAttribute('xmlns');
$writer->text('http://www.hyfinity.com/mvc');
$writer->endAttribute();

// Top Level Information
$writer->writeElement('IDNUM', $_POST['libertyuid']);
$writer->writeElement('PIDM', $_POST['pidm']);
$writer->writeElement('USERNAME', $_POST['username']);
$writer->writeElement('IDNUM_DISP', $_POST['libertyuid']);

// Student Information
$writer->writeElement('FIRSTNAME', $_POST['firstname']);
$writer->writeElement('MIDDLENAME', $_POST['middlename']);
$writer->writeElement('LASTNAME', $_POST['lastname']);
$writer->writeElement('EMAIL', $_POST['email']);
$writer->writeElement('PHONE', $_POST['phone']);
$writer->writeElement('BDAY', $_POST['bday']);
$writer->writeElement('MAIDENNAME', $_POST['maidenname']);
$writer->writeElement('COUNTRY', $_POST['country']);
$writer->writeElement('ADDR1', $_POST['address1']);
$writer->writeElement('ADDR2', $_POST['address2']);
$writer->writeElement('ADDR3', $_POST['address3']);
$writer->writeElement('ADDR4', $_POST['address4']);
$writer->writeElement('CITY', $_POST['city']);
$writer->writeElement('STATE', $_POST['state']);
$writer->writeElement('ZIP', $_POST['zip']);
$writer->writeElement('CREATE_DATE', $create_date);
$writer->endElement();

$writer->endElement();
// End Namespace Hack
$writer->endElement();
$writer->endDocument();
$xml = $writer->outputMemory(TRUE);

$body = array(
    'form_name' => 'Alumni ID Request '.$_POST['libertyuid'].' '. $create_date,
    'key' => 'KEY:FormNumber123',
    'form_id' => null,
    'xml_data' => $xml,
    'data_username' => $_POST['username'],
    'data_pidm' => $_POST['pidm'],
    'status' => 'S',
    'user_id' => 'EXAMPLE_USERID',
    'version' => null,
    'data_origin' => 'PROJECT',
    'vpdi_code' => null
);

$json = json_encode($body);

$url = rif_form_submit_link($environment, 'bizflow_record');
$user_pass = rif_form_user_pass($environment);

if (!$user_pass) {
    $http = 'Error: Credentials not found.';
} else {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, $user_pass);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json))
    );
    $result = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
}

if($http == '201') {
    header('Location: '.$_POST['location_url'].'?submitted=true');
    exit();
} 
else {
    header('Location: '.$_POST['location_url'].'?issues=true');
    exit();
}
?>