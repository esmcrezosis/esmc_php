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
class Application_Model_DbTable_EuTravailleur extends Zend_Db_Table_Abstract{
    //put your code here
    protected $_name = 'eu_travailleur';
	protected $_primary = 'travailleur_id';
    
}

?>
