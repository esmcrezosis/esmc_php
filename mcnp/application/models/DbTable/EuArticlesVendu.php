<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuArticlesVendu
 *
 * @author user
 */
class Application_Model_DbTable_EuArticlesVendu extends Zend_Db_Table_Abstract{
    //put your code here
    protected $_name = 'eu_articles_vendu';
	protected $_primary = 'code_barre';
    
}

?>
