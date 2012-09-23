<?php
class Model_DbTable_Categories extends ORM_DbTableAbstract {

    protected $_name = 'categories';

	protected $_dependentTables = array(
		'BookCategories',
	);

}
