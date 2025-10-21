<?php
require('../../config.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/table_demo/index.php'));
$PAGE->set_title('Table Demo');
$PAGE->set_heading('Table Demo');

$PAGE->requires->js(new moodle_url('https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css'));

$form = new local\email_sender\form\email_form();

if ($form->is_cancelled()) {
	redirect('/');
} else if ($data = $form->get_data()) {
	global $USER;
    global $DB;

	$recipient = $DB->get_record('user', ['id' => $data->recipient], '*');

	$subject = $data->subject;
	$textmessage = $data->content['text'];
	$htmlmessage = $data->content['text'];

	$success = email_to_user($recipient, $USER, $subject, $textmessage, $htmlmessage);

	if ($success) {
		\core\notification::success('Email sent to successfully!');
	} else {
		\core\notification::error('Failed to send email.');
	}
}

echo $OUTPUT->header();
$form->display();
echo $OUTPUT->footer();
