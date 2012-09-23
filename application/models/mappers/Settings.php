<?php
class Model_Mapper_Settings extends ORM_MapperAbstract {

	protected $class_name = 'Settings';

	public function fetchAll($where=null) {
		$resultSet = $this->_db->fetchAll($where);
		$settings = array();
		foreach($resultSet as $row) {
			$setting = $row->toArray();
			$settings[$setting['name']] = $setting['value'];
		}
		return $this->createModelObject($settings);
	}
}
