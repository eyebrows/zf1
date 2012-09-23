<?php
class ORM_MapperAbstract {

	protected $_db, $mapper_name, $dbtable_class, $mapper_class, $model_class;

	public function __construct() {
		$this->mapper_name = str_replace('Model_Mapper_', '', get_called_class());
		$this->dbtable_class = 'Model_DbTable_'.$this->mapper_name;
		$this->mapper_class = 'Model_Mapper_'.$this->mapper_name;
		$this->model_class = 'Model_'.$this->class_name;
		$this->_db = new $this->dbtable_class();
		if(!$this->_db instanceof Zend_Db_Table_Abstract)
			throw new Exception('Invalid table data gateway provided');
	}

	public function getDbTable() {
		return $this->_db;
	}

	public function save($object) {
		if(!$object instanceof $this->model_class)
			throw new Exception('Invalid model object provided');
		$data = $object->getFields();
		foreach($object->getAllReferenced() as $reference=>$referenced_object)
			$data[$reference.'_id'] = $referenced_object->getId();
		if(is_null($object->getId()))
			return $this->_db->insert($data);
		else
			return $this->_db->update($data, array('id = ?'=>$object->getId()));
	}

	public function find($id) {
		$result = $this->_db->find($id);
		if(!count($result))
			throw new Exception($this->class_name.' not found');
		return $this->createModelObject($result->current()->toArray());
	}

	public function fetchAll($where=null) {
		$resultSet = $this->_db->fetchAll($where);
		$entries = array();
		foreach($resultSet as $row)
			$entries[] = $this->createModelObject($row->toArray());
		return $entries;
	}

	public function createModelObject(array $fields) {
		if(method_exists($this->mapper_class, 'createModelObject_defaultFields'))
			$fields = call_user_func(array($this->mapper_class, 'createModelObject_defaultFields'), $fields);
		$object = new $this->model_class($fields);
		$this->addReferencePlaceholders($object);
//because dependent objects can't exist in the DB if there's no id yet (aka no DB record yet)
		if(isset($fields['id']))
			$this->addDependentPlaceholders($object);
		return $object;
	}

	protected function addReferencePlaceholders($object) {
//this is for _referenceMap objects, e.g. when a Book has an Author, the Author is a "referenced object"
		if($referenceMap = $this->_db->getReferences())
			foreach($referenceMap as $referenced_name=>$map) {
				$referenced_mapper_name = 'Model_Mapper_'.$map['refTableClass'];
				$object->addReferencedObjectPlaceholder(new ORM_ModelPlaceholder(array(
					'name'=>$referenced_name,
					'mapper_name'=>$referenced_mapper_name,
					'id'=>$object->getField($map['columns']),
				)));
			}
	}

	protected function addDependentPlaceholders($object) {
//this is for _dependentTable objects, e.g. when an Author has several Books, the Books are "dependent objects"
		if($dependentTables = $this->_db->getDependentTables())
			foreach($dependentTables as $table) {
				$dependent_dbtable_name = 'Model_DbTable_'.$table;
				$dependent_dbtable = new $dependent_dbtable_name();
				$reference_map = $dependent_dbtable->getReference($this->mapper_name);
				$dependent_mapper_name = 'Model_Mapper_'.$table;
				$object->addDependentObjectPlaceholder(new ORM_ModelPlaceholder(array(
					'name'=>$table,
					'mapper_name'=>$dependent_mapper_name,
					'column'=>$reference_map['columns'][0],
					'value'=>$object->getId(),
				)));
			}
	}
}
