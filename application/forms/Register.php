<?php
class Form_Register extends Zend_Form {

	public function init() {
		$forename = $this->createElement('text', 'forename');
		$forename
			->setLabel('Forename')
			->setRequired(true);

		$surname = $this->createElement('text', 'surname');
		$surname
			->setLabel('Surname')
			->setRequired(true);

		$username = $this->createElement('text', 'username');
		$username
			->setLabel('Email Address')
			->setRequired(true);

		$password = $this->createElement('password', 'password');
		$password
			->setLabel('Choose Password')
			->setRequired(true);

		$confirm = $this->createElement('password', 'confirm');
		$confirm
			->setLabel('Confirm Password')
			->setRequired(true);

		$submit = $this->createElement('submit', 'signin');
		$submit
			->setLabel('Register')
			->setIgnore(true);

		$this->addElements(array(
			$forename,
			$surname,
			$username,
			$password,
			$confirm,
			$submit,
		));
	}
}
