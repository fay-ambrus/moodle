<?php
require('../../config.php');
require_once(__DIR__.'/src/config.php');
require_once(__DIR__.'/src/SimplePayV21.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/simple_pay_demo/index.php'));
$PAGE->set_title(get_string('title', 'local_simple_pay_demo'));
$PAGE->set_heading(get_string('title', 'local_simple_pay_demo'));

global $USER;

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Create transaction
$trx = new SimplePayStart;
$trx->addConfig($config);
$trx->addData('currency', 'HUF');
$trx->addData('total', 25); // $trx->addItems-zel hozzá lehet adni résztételeket.

$trx->addData('orderRef', str_replace(array('.', ':', '/'), "", @$_SERVER['SERVER_ADDR']) . @date("U", time()) . rand(1000, 9999));
$trx->addData('customer', fullname($USER));
$trx->addData('customerEmail', $USER->email);
$trx->addData('language', 'EN');
$trx->addData('threeDSReqAuthMethod', '02');
$trx->addData('timeout', @date("c", time() + 600));     // 10 minutes
$trx->addData('methods', array('CARD', 'EAM'));

// Add urls
$trx->addGroupData('urls', 'success', $config['URLS_SUCCESS']);
$trx->addGroupData('urls', 'fail', $config['URLS_FAIL']);
$trx->addGroupData('urls', 'cancel', $config['URLS_CANCEL']);
$trx->addGroupData('urls', 'timeout', $config['URLS_TIMEOUT']);

// todo: itt miket kéne még, hogyan kéne még? valami törvényi előírással complyolni kell amúgy
$trx->addGroupData('invoice', 'name', fullname($USER));
if (isset($USER->country)) {
    $trx->addGroupData('invoice', 'country', $USER->country);
}
if (isset($USER->city)) {
    $trx->addGroupData('invoice', 'city', $USER->city);
}
if (isset($USER->address)) {
    $trx->addGroupData('invoice', 'address', $USER->address);
}
if (isset($USER->phone)) {
    $trx->addGroupData('invoice', 'phone', $USER->phone);
}

$trx->formDetails['element'] = 'button';

$trx->runStart();
$trx->getHtmlForm();

$returnData = $trx->getReturnData();

echo $OUTPUT->header();
echo $trx->returnData['form'];
echo var_export($returnData, true);
echo $OUTPUT->footer();
