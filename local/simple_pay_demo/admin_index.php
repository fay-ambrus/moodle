<?php
require('../../config.php');
require_once(__DIR__.'/src/create_transaction_form.php');

require_login();
require_admin();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/simple_pay_demo/admin_index.php'));
$PAGE->set_title(get_string('title_admin', 'local_simple_pay_demo'));
$PAGE->set_heading(get_string('title_admin', 'local_simple_pay_demo'));

global $DB;

$form = new \local\simple_pay_demo\create_transaction_form();

echo $OUTPUT->header();

$form->display();

if ($form->is_cancelled()) {
    redirect(new moodle_url('/my/'));
}

else if ($data = $form->get_data()) {
    // create db entry for payment request
    $record = new stdClass();
    $record->userid = $data->debtor;
    $record->amount = $data->amount;
    $record->description = $data->description;
    $record->status = 'pending';
    $record->timecreated = time();

    $DB->insert_record('local_simple_pay_demo', $record);
}

echo $OUTPUT->footer();
