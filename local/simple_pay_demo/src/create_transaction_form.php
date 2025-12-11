<?php

namespace local\simple_pay_demo;

require_once("$CFG->libdir/formslib.php");
class create_transaction_form extends \moodleform {
	public function definition() {
		$mform = $this->_form;
		global $DB;

		// select debtor
		$users = $DB->get_records('user', ['deleted' => 0], 'email ASC', 'id, email');
		$options = [];
		foreach ($users as $user) {
			$options[$user->id] = $user->email;
		}
		$mform->addElement('select', 'debtor', get_string('debtor', 'local_simple_pay_demo'), $options);
		$mform->setType('debtor', PARAM_INT);
        $mform->addRule('debtor', get_string('required_transaction', 'local_simple_pay_demo'), 'required');

		// add description
		$mform->addElement('text', 'description', get_string('description', 'local_simple_pay_demo'));
		$mform->setType('description', PARAM_TEXT);
        $mform->addRule('description', get_string('required_transaction', 'local_simple_pay_demo'), 'required');

		// add amount
		$mform->addElement('text', 'amount', get_string('amount', 'local_simple_pay_demo'));
		$mform->setType('amount', PARAM_INT);
        $mform->addRule('amount', get_string('required_transaction', 'local_simple_pay_demo'), 'required');
        $mform->addRule('amount', get_string('required_minimal_value', 'local_simple_pay_demo'), 'minvalue', 1);
        $mform->addRule('amount', 'Must be an integer', 'numeric');

		// add submit button
		$this->add_action_buttons(false, 'Send');
	}

	function validation($data, $files) {
		return [];
	}
}
