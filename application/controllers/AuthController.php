<?php
class AuthController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function registerAction() {
		$form = new Form_Register();
		$this->view->form = $form;
		if($this->getRequest()->isPost()) {
			if($form->isValid($_POST)) {
				$data = $form->getValues();
				if(strlen($data['password'])>=8) {
					if($data['password']==$data['confirm']) {
						$mapper = new Model_Mapper_Users();
						$exists = $mapper->fetchAll($mapper->getDbTable()->select()->where('username=?', $data['username']));
						if(!count($exists)) {
							unset($data['confirm']);
							if($mapper->save($mapper->createModelObject($data)))
								$this->_redirect('auth/login#registered=justnow');
							else
								$this->view->error = 'There was an error creating your account; please try again';
						}
						else
							$this->view->error = 'Sorry, this email address is already registered with an account';
					}
					else
						$this->view->error = 'Please make sure your password and confirmation match';
				}
				else
					$this->view->error = 'Please ensure your password is at least 8 characters long';
			}
			else
				$this->view->error = 'Please complete all the form fields';
		}
	}

	public function loginAction() {
		$form = new Form_Login();
		$this->view->form = $form;
		if($this->getRequest()->isPost()) {
			if($form->isValid($_POST)) {
				$data = $form->getValues();
				$auth = Zend_Auth::getInstance();
				$dbtable_users = new Model_DbTable_Users();
				$authAdapter = new Zend_Auth_Adapter_DbTable($dbtable_users->getAdapter(), 'users');
				$authAdapter
					->setIdentityColumn('username')
					->setCredentialColumn('password')
					->setIdentity($data['username'])
					->setCredential(md5($data['password']));
				if($auth->authenticate($authAdapter)->isValid()) {
					$auth->getStorage()->write(array(
						'user_id'=>$authAdapter->getResultRowObject()->id,
					));
					$this->_redirect('#loggedin=justnow');
				}
				else
					$this->view->error = 'Invalid username or password; please try again';
			}
			else
				$this->view->error = 'Please enter your username and password to sign in';
		}
	}

	public function logoutAction() {
		$storage = new Zend_Auth_Storage_Session();
		$storage->clear();
		$this->_redirect('/');
	}
}
