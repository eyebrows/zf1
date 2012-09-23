<?php
class IndexController extends Zend_Controller_Action {

	public function init() {
		$auth = Zend_Auth::getInstance();
		$data = $auth->getStorage()->read();
		if($data['user_id']) {
			$user_mapper = new Model_Mapper_Users();
			$user = $user_mapper->find($data['user_id']);
			$this->view->user = $user;
		}
	}

	public function indexAction() {
		$book_mapper = new Model_Mapper_Books();
		$this->view->all_books = $book_mapper->fetchAll();

		$author_mapper = new Model_Mapper_Authors();
		$this->view->highlight_author = $author_mapper->find(3);//load "ian m. banks" Author record

		$category_mapper = new Model_Mapper_Categories();
		$this->view->category_sf = $category_mapper->find(2);//load "scientific" Category record
	}

	public function libraryAction() {
	}
}
