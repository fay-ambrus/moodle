<?php

namespace local\email_sender\form;

require_once("$CFG->libdir/formslib.php");
class email_form extends \moodleform {
	public function definition() {
		$mform = $this->_form;
		global $DB;

		// add recipient
		$users = $DB->get_records('user', ['deleted' => 0], 'email ASC', 'id, email');
		$options = [];
		foreach ($users as $user) {
			$options[$user->id] = $user->email;
		}
		$mform->addElement('select', 'recipient', get_string('recipient', 'local_email_sender'), $options);
		$mform->setType('recipient', PARAM_INT);

		// add subject
		$mform->addElement('text', 'subject', get_string('subject', 'local_email_sender'));
		$mform->setType('subject', PARAM_TEXT);

		// add text
		$mform->addElement('editor', 'content', get_string('content', 'local_email_sender'));
		$mform->setType('content', PARAM_CLEANHTML);

		// add submit button
		$this->add_action_buttons(false, 'Send');
	}

	function validation($data, $files) {
		return [];
	}
}
