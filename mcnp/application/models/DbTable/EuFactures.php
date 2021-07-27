<?php
 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuPage
 *
 * @author user
 */
class Application_Model_DbTable_EuFactures extends Zend_Db_Table_Abstract{
    //put your code here
    protected $_name = 'eu_factures';
	protected $_primary = 'facture_id';
    
}

?>
