<?php
class Model_DbTable_UserBooks extends ORM_DbTableAbstract {

    protected $_name = 'user_books';

	protected $_referenceMap = array(
		'Users'=>array(
			'columns'=>'user_id',
			'refTableClass'=>'Users',
			'refColumns'=>'id',
		),
		'Books'=>array(
			'columns'=>'book_id',
			'refTableClass'=>'Books',
			'refColumns'=>'id',
		),
	);
}
