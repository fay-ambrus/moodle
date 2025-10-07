<?php
require('../../config.php');
require_once(__DIR__.'/classes/form/email_form.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/email_sender/index.php'));
$PAGE->set_title('Email sender');
$PAGE->set_heading('Email sender');

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
