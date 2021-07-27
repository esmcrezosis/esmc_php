<?php

/**
 * EuBanqueUser
 *  
 * @author Mawuli
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Application_Model_DbTable_EuBanqueUser extends Zend_Db_Table_Abstract {
	/**
	 * The default table name
	 */
	protected $_name = 'eu_banque_user';
	protected $_primary = 'id_banque_user';
	protected $_sequence = true;
}
