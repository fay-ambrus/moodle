<?php

namespace local\simple_pay_demo;

require_once("$CFG->libdir/formslib.php");
class select_transaction_form extends \moodleform {
	public function definition() {
		$mform = $this->_form;
		global $DB;
        global $USER;

		// select transaction
		$users = $DB->get_records('local_simple_pay_demo', ['userid' => $USER->id, 'status' => 'pending'], 'email ASC', 'id, email');
		$options = [];
		foreach ($users as $user) {
			$options[$user->id] = $user->email;
		}
		$mform->addElement('select', 'transaction', get_string('transaction', 'local_simple_pay_demo'), $options);
		$mform->setType('transaction', PARAM_INT);
        $mform->addRule('transaction', get_string('required_transaction', 'local_simple_pay_demo'), 'required');

		// add submit button
		$this->add_action_buttons(false, 'Send');
	}

	function validation($data, $files) {
		return [];
	}
}
