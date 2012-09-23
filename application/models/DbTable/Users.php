<?php
class Model_DbTable_Users extends ORM_DbTableAbstract {

    protected $_name = 'users';

	protected $_dependentTables = array(
		'UserBooks',
	);

	protected $_referenceMap = array(
		'Usertypes'=>array(
			'columns'=>'usertype_id',
			'refTableClass'=>'Usertypes',
			'refColumns'=>'id',
		),
	);
}
