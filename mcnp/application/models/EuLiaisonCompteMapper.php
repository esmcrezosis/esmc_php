    <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDivisionMapper
 *
 * @author user
 */
 
 
 
class Application_Model_EuLiaisonCompteMapper  {

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
           $this->setDbTable('Application_Model_DbTable_EuLiaisonCompte');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuLiaisonCompte $liaison) {
      $data = array(
        'id' => $liaison->getId(),
        'code_membre_admin' => $liaison->getCode_membre_admin(),
        'code_membre_anim' => $liaison->getCode_membre_anim(),
	    'date_liaison' => $liaison->getDate_liaison()
      );
      $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuLiaisonCompte $liaison) {
        $data = array(
          'id' => $liaison->getId(),
          'code_membre_admin' => $liaison->getCode_membre_admin(),
          'code_membre_anim' => $liaison->getCode_membre_anim(),
	      'date_liaison' => $liaison->getDate_liaison()
        );
        $this->getDbTable()->update($data, array('id = ?' => $division->getId()));
    }
	
	

    public function find($id, Application_Model_EuLiaisonCompte $liaison) {
        $result = $this->getDbTable()->find($id);
        if(0 == count($result)) {
          return false;
        }
        $row = $result->current();
        $liaison->setId($row->id)
                ->setCode_membre_admin($row->code_membre_admin)
                ->setCode_membre_anim($row->code_membre_anim)
				->setDate_liaison($row->date_liaison);
        return true;
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLiaisonCompte();
            $entry->setId($row->id)
                  ->setCode_membre_admin($row->code_membre_admin)
                  ->setCode_membre_anim($row->code_membre_anim)
				  ->setDate_liaison($row->date_liaison);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	
	public function findConuter() {
      $tabela = new Application_Model_DbTable_EuLiaisonCompte(); 
      $select = $tabela->select();
      $select->from('eu_liaison_compte', array('MAX(id) as count'));
      $result = $tabela->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	

    public function delete($id) {
      $this->getDbTable()->delete(array('id = ?' => $id));
    }

}

?>
