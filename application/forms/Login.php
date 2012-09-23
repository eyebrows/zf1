<?php
class Form_Login extends Zend_Form {

	public function init() {
		$username = $this->createElement('text', 'username');
		$username
			->setLabel('Email Address')
			->setRequired(true);

		$password = $this->createElement('password', 'password');
		$password
			->setLabel('Password')
			->setRequired(true);

		$submit = $this->createElement('submit', 'signin');
		$submit
			->setLabel('Login')
			->setIgnore(true);

		$this->addElements(array(
			$username,
			$password,
			$submit,
		));
	}
}
