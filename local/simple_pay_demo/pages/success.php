<?php
require('../../../config.php');
require_once(__DIR__.'/../src/config.php');
require_once(__DIR__.'/../src/SimplePayV21.php');

require_login();
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/simple_pay_demo/pages/success.php'));
$PAGE->set_title(get_string('title', 'local_simple_pay_demo'));
$PAGE->set_heading(get_string('title', 'local_simple_pay_demo'));

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

$trx = new SimplePayBack;

$trx->addConfig($config);

$result = array();
if (isset($_REQUEST['r']) && isset($_REQUEST['s'])) {
    if ($trx->isBackSignatureCheck($_REQUEST['r'], $_REQUEST['s'])) {
        $result = $trx->getRawNotification();
    }
}

echo $OUTPUT->header();

echo html_writer::tag('h2', get_string('message_success', 'local_simple_pay_demo'));

$link = new moodle_url('/local/simple_pay_demo/index.php');

echo var_dump($result);

echo html_writer::link($link, get_string('back', 'local_simple_pay_demo'));

echo $OUTPUT->footer();
