<?php
class Model_Mapper_Users extends ORM_MapperAbstract {

	protected $class_name = 'User';

	protected function createModelObject_defaultFields($fields) {
		if(!isset($fields['id'])) {
//creating new objects from raw data
			if(!isset($fields['date_registered']))
				$fields['date_registered'] = date('Y-m-d H:i:s');
			if(!isset($fields['usertype_id']))
				$fields['usertype_id'] = 1;
			if(!isset($fields['max_concurrent_rentals']) || !isset($fields['max_rental_days'])) {
				$mapper_settings = new Model_Mapper_Settings();
				$settings = $mapper_settings->fetchAll();
				if(!isset($fields['max_concurrent_rentals']))
					$fields['max_concurrent_rentals'] = $settings->getField('max_concurrent_rentals');
				if(!isset($fields['max_rental_days']))
					$fields['max_rental_days'] = $settings->getField('max_rental_days');
			}
		}
		else {
//creating by pulling data from DB
		}
		return $fields;
	}
}
