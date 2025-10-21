<?php
require('../../config.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/table_demo/index.php'));
$PAGE->set_title(get_string('title', 'local_table_demo'));
$PAGE->set_heading(get_string('title', 'local_table_demo'));

$PAGE->requires->js(new moodle_url('https://cdn.datatables.net/2.3.4/js/dataTables.min.js'));
$PAGE->requires->css(new moodle_url('https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css'));
$PAGE->requires->js_call_amd('local_table_demo/main', 'init');

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_table_demo/main_page', []);
echo $OUTPUT->footer();
