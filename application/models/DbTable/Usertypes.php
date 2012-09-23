<?php
class Model_DbTable_Usertypes extends ORM_DbTableAbstract {

    protected $_name = 'usertypes';

	protected $_dependentTables = array(
		'Users',
	);
}
