<?php
require('../../../config.php');

require_login();
$context = context_system::instance();

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/simple_pay_demo/pages/success.php'));
$PAGE->set_title(get_string('title', 'local_simple_pay_demo'));
$PAGE->set_heading(get_string('title', 'local_simple_pay_demo'));

echo $OUTPUT->header();

echo html_writer::tag('h2', get_string('message_success', 'local_simple_pay_demo'));

$link = new moodle_url('/local/simple_pay_demo/index.php');

echo html_writer::link($link, get_string('back', 'local_simple_pay_demo'));

echo $OUTPUT->footer();
