<?php
class ORM_ModelAbstract {

	protected $fields = array(), $referenced_objects = array(), $descendent_objects = array();

	public function __construct(array $fields=null) {
		if(is_array($fields))
			foreach($fields as $k=>$v)
				$this->setField($k, $v);
	}

	public function getId() {
		if(isset($this->fields['id']))
			return $this->fields['id'];
		return null;
	}

	public function getField($name) {
//		if(method_exists(get_called_class(), 'getField_'.$name))
//			return call_user_func(array(get_called_class(), 'getField_'.$name));
//		else
			return $this->fields[$name];
	}

	public function setField($name, $value) {
//shouldn't use these as the Mapper should handle it
//		if(method_exists(get_called_class(), 'setField_'.$name))
//			call_user_func(array(get_called_class(), 'setField_'.$name), $value);
//		else
			$this->fields[$name] = $value;
	}

	public function getFields() {
		return $this->fields;
	}

	public function addReferencedObjectPlaceholder($placeholder) {
		$this->referenced_objects[$placeholder->getData('name')] = $placeholder;
	}

	public function addDependentObjectPlaceholder($placeholder) {
		$this->descendent_objects[$placeholder->getData('name')] = $placeholder;
	}

//these are referenced tables so if, say, $this is a Book, the Author data won't actually get loaded until getReferenced('Authors') is called
	public function getReferenced($reference) {
		if(isset($this->referenced_objects[$reference])) {
			if('ORM_ModelPlaceholder'==get_class($this->referenced_objects[$reference]))
				$this->referenced_objects[$reference] = $this->referenced_objects[$reference]->fetchObject();
			return $this->referenced_objects[$reference];
		}
		throw new Exception('Invalid referenced object access \''.$reference.'\'');
	}

	public function getAllReferenced() {
		return $this->referenced_objects;
	}

//these are dependent tables, so if $this is an Author, Books might be a descendent thing
	public function getDependents($reference) {
		if(isset($this->descendent_objects[$reference])) {
			if('ORM_ModelPlaceholder'==get_class($this->descendent_objects[$reference]))
				$this->descendent_objects[$reference] = $this->descendent_objects[$reference]->fetchObjects();
			return $this->descendent_objects[$reference];
		}
		throw new Exception('Invalid dependent object access \''.$reference.'\'');
	}
}
