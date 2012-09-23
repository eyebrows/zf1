<?php
//A Placeholder is for when e.g. a Book has an Author - where to find its Author can be stored with the Book, so it can be easily fetched
//essentially just a wrapper for Array so we can check for its data-type in our Models' referenced/dependent holders
class ORM_ModelPlaceholder {

	private $data;

	public function __construct(Array $data) {
		$this->data = $data;
	}

	public function getData($key=null) {
		if(!is_null($key))
			return $this->data[$key];
		return $this->data;
	}

//for references (e.g. we're a Book, fetch our Author)
	public function fetchObject() {
		$mapper = new $this->data['mapper_name']();
		return $mapper->find($this->data['id']);
	}

//for dependents (e.g. we're an Author, fetch our Books)
	public function fetchObjects() {
		$mapper = new $this->data['mapper_name']();
		return $mapper->fetchAll($mapper->getDbTable()->select()->where($this->data['column'].'=?', $this->data['value']));
	}
}
