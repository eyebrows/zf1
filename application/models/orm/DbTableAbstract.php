<?php
class ORM_DbTableAbstract extends Zend_Db_Table_Abstract {

	public function getReferences() {
		return $this->_referenceMap;
	}
}
