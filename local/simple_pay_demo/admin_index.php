<?php
require('../../config.php');

require_login();
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/simple_pay_demo/pages/manage.php'));
$PAGE->set_title('Manage Something');
$PAGE->set_heading('Manage Something');

echo $OUTPUT->header();

// your content here

echo $OUTPUT->footer();
