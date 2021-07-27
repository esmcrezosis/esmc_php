    <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuLiaisonUserMapper
 *
 * @author user
 */
 
 
 
class Application_Model_EuLiaisonUserMapper  {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if(is_string($dbTable)) {
           $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if(NULL === $this->_dbTable) {
           $this->setDbTable('Application_Model_DbTable_EuLiaisonUser');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuLiaisonUser $liaison) {
      $data = array(
	    'id_liaison_user' => $liaison->getId_liaison_user(),
        'id_utilisateur' => $liaison->getId_utilisateur(),
        'id_division_gac' => $liaison->getId_division_gac(),
	    'date_liaison' => $liaison->getDate_liaison()
      );
      $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuLiaisonUser $liaison) {
        $data = array(
		  'id_liaison_user' => $liaison->getId_liaison_user(),
          'id_utilisateur' => $liaison->getId_utilisateur(),
          'id_division_gac' => $liaison->getId_division_gac(),
	      'date_liaison' => $liaison->getDate_liaison()
        );
        $this->getDbTable()->update($data, array('id_liaison_user = ?' => $liaison->getId_liaison_user()));
    }
	
	

    public function find($id_liaison_user, Application_Model_EuLiaisonUser $liaison) {
        $result = $this->getDbTable()->find($id_liaison_user);
        if(0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $liaison->setId_liaison_user($row->id_liaison_user)
		        ->setId_utilisateur($row->id_utilisateur)
                ->setId_division_gac($row->id_division_gac)
				->setDate_liaison($row->date_liaison);
        return true;
    }
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuLiaisonUser();
            $entry->setId_liaison_user($row->id_liaison_user)
			      ->setId_utilisateur($row->id_utilisateur)
                  ->setId_division_gac($row->id_division_gac)
				  ->setDate_liaison($row->date_liaison);
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function delete($id_liaison_user) {
      $this->getDbTable()->delete(array('id_liaison_user = ?' => $id_liaison_user));
    }

}

?>
