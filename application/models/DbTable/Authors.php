<?php
class Model_DbTable_Authors extends ORM_DbTableAbstract {

    protected $_name = 'authors';

	protected $_dependentTables = array(
		'Books',
	);

}
