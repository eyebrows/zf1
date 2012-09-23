<?php
class Model_DbTable_Books extends ORM_DbTableAbstract {

    protected $_name = 'books';

	protected $_dependentTables = array(
		'BookCategories',
		'UserBooks',
	);

	protected $_referenceMap = array(
		'Authors'=>array(
			'columns'=>'author_id',
			'refTableClass'=>'Authors',
			'refColumns'=>'id',
		),
	);
}
