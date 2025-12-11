<?php

namespace local\simple_pay_demo;

require_once("$CFG->libdir/formslib.php");
class billing_form extends \moodleform {
	public function definition() {
		$mform = $this->_form;

		// header text
        $mform->addElement('static', 'headerinfo', '',
            '<p>Please provide the following billing information. This information is required to process your payments correctly.</p>'
        );

		// country
        $mform->addElement('select', 'country', get_string('country', 'local_simple_pay_demo'), get_string_manager()->get_list_of_countries());
        $mform->addRule('country', get_string('required', 'local_simple_pay_demo'), 'required');

        // state (optional)
        $mform->addElement('text', 'state', get_string('state', 'local_simple_pay_demo'));
        $mform->setType('state', PARAM_TEXT);

        // city.
        $mform->addElement('text', 'city', get_string('city', 'local_simple_pay_demo'));
        $mform->setType('city', PARAM_TEXT);
        $mform->addRule('city', get_string('required', 'local_simple_pay_demo'), 'required');

        // ZIP.
        $mform->addElement('text', 'zip', get_string('zip', 'local_simple_pay_demo'));
        $mform->setType('zip', PARAM_TEXT);
        $mform->addRule('zip', get_string('required', 'local_simple_pay_demo'), 'required');

        // address
        $mform->addElement('text', 'address', get_string('address', 'local_simple_pay_demo'));
        $mform->setType('address', PARAM_TEXT);
        $mform->addRule('address', get_string('required', 'local_simple_pay_demo'), 'required');

		// Agreement checkbox.
        $mform->addElement('advcheckbox', 'agreement', 'Agreement', get_string('agreement', 'local_simple_pay_demo'));
        $mform->addRule('agreement', get_string('required_agreement', 'local_simple_pay_demo'), 'required', null, 'client');

        $this->add_action_buttons(true, get_string('submit', 'local_simple_pay_demo'));
	}

	function validation($data, $files) {
		if ($data['agreement'] != 1) {
            return ['agreement' => get_string('required_agreement', 'local_simple_pay_demo')];
        }
        return [];
	}
}
