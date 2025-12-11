<?php

require('../../config.php');
require_once(__DIR__.'/src/config.php');
require_once(__DIR__.'/src/SimplePayV21.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/simple_pay_demo/back.php'));
$PAGE->set_title(get_string('title', 'local_simple_pay_demo'));
$PAGE->set_heading(get_string('title', 'local_simple_pay_demo'));

//Optional error riporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

 //Import config data
require_once 'src/config.php';

//Import SimplePayment class
require_once 'src/SimplePayV21.php';

$trx = new SimplePayBack;

$trx->addConfig($config);


//result
//-----------------------------------------------------------------------------------------
$result = array();
if (isset($_REQUEST['r']) && isset($_REQUEST['s'])) {
    if ($trx->isBackSignatureCheck($_REQUEST['r'], $_REQUEST['s'])) {
        $result = $trx->getRawNotification();
    }
}


// test data
//-----------------------------------------------------------------------------------------
print "<pre>";
print '<a href="index.html">INDEX</a>';
print "<br/><br/>";
print_r($result);
print "</pre>";


if (count($result) > 0) {

    // QUERY
    print '<a href="query.php?orderRef=' . $result['o'] . '&transactionId=' . $result['t'] . '&merchant=' . $result['m'] . '"> QUERY: ' . $result['t'] . '</a>';
    print "<br/><br/>";

    // REFUND
    print '<a href="refund.php?orderRef=' . $result['o'] . '&transactionId=' . $result['t'] . '&merchant=' . $result['m'] . '"> REFUND 5 HUF</a>';
    print "<br/><br/>";

    print "Kétlépcsős tranzakció lezárása esetén<br/><br/>";
    // FINISH FULL
    print '<a href="finish.php?orderRef=' . $result['o'] . '&transactionId=' . $result['t'] . '&merchant=' . $result['m'] . '&originalTotal=25&approveTotal=25"> FINISH 25 HUF (terhelés teljes összeggel)</a>';
    print "<br/><br/>";

    // FINISH 20
    print '<a href="finish.php?orderRef=' . $result['o'] . '&transactionId=' . $result['t'] . '&merchant=' . $result['m'] . '&originalTotal=25&approveTotal=10"> FINISH 10 HUF (terhelés a foglaltnál kisebb összeggel)</a>';
    print "<br/><br/>";

    // FINISH 0
    print '<a href="finish.php?orderRef=' . $result['o'] . '&transactionId=' . $result['t'] . '&merchant=' . $result['m'] . '&originalTotal=25&approveTotal=0"> FINISH 0 HUF (foglalás feloldása)</a>';
    print "<br/><br/>";

}
