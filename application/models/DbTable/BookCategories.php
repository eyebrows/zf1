<?php
class Model_DbTable_BookCategories extends ORM_DbTableAbstract {

    protected $_name = 'book_categories';

	protected $_referenceMap = array(
		'Book'=>array(
			'columns'=>'book_id',
			'refTableClass'=>'Books',
			'refColumns'=>'id',
		),
		'Category'=>array(
			'columns'=>'category_id',
			'refTableClass'=>'Categories',
			'refColumns'=>'id',
		),
	);
}
