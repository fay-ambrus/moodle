<?php

use core\check\performance\debugging;
require('../../config.php');
require_once(__DIR__.'/src/config.php');
require_once(__DIR__.'/src/SimplePayV21.php');
require_once(__DIR__.'/src/billing_form.php');

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
$trx->addData('timeout', @date("c", time() + 600)); // 10 minutes
$trx->addData('methods', array('CARD', 'EAM'));

// Add urls
$trx->addGroupData('urls', 'success', $config['URLS_SUCCESS']);
$trx->addGroupData('urls', 'fail', $config['URLS_FAIL']);
$trx->addGroupData('urls', 'cancel', $config['URLS_CANCEL']);
$trx->addGroupData('urls', 'timeout', $config['URLS_TIMEOUT']);
$trx->addData('threeDSReqAuthMethod', '02');

$trx->formDetails['element'] = 'button';

if (isset($USER->phone)) {
    $trx->addGroupData('invoice', 'phone', $USER->phone);
}

$trx->addGroupData('invoice', 'name', fullname($USER));

echo $OUTPUT->header();

// If billing data is not set, show a form to collect it
if (empty($USER->country) || empty($USER->city) || empty($USER->address)) {
    $form = new \local\simple_pay_demo\billing_form();

    $form->display();

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/my/'));
    }

    else if ($data = $form->get_data()) {
        $trx->addGroupData('invoice', 'country', $data->country);
        $trx->addGroupData('invoice', 'state', $data->state);
        $trx->addGroupData('invoice', 'city', $data->city);
        $trx->addGroupData('invoice', 'zip', $data->zip);
        $trx->addGroupData('invoice', 'address', $data->address);

        $trx->runStart();
        $trx->getHtmlForm();
        $returnData = $trx->getReturnData();

        echo $trx->returnData['form'];
        echo html_writer::empty_tag('br');
        echo html_writer::empty_tag('br');
    }
}
// If billing data is present, then set it andproceed with the transaction
else {
    $trx->addGroupData('invoice', 'country', $USER->country);
    $trx->addGroupData('invoice', 'city', $USER->city);
    $trx->addGroupData('invoice', 'address', $USER->address);

    $trx->runStart();
    $trx->getHtmlForm();
    $returnData = $trx->getReturnData();

    echo $trx->returnData['form'];
    echo html_writer::empty_tag('br');
    echo html_writer::empty_tag('br');
}

echo $OUTPUT->footer();
