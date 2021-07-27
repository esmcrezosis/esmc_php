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
class Application_Model_EuDivisionMapper {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (NULL === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuDivision');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuDivision $division) {
      $data = array(
        'id_division' => $division->getId_division(),
        'code_division' => $division->getCode_division(),
        'nom_division' => $division->getNom_division(),
	    'desc_division' => $division->getDesc_division(),
		'date_creation' => $division->getDate_creation()
		
      );
      $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDivision $division) {
        $data = array(
          'id_division' => $division->getId_division(),
          'code_division' => $division->getCode_division(),
          'nom_division' => $division->getNom_division(),
	      'desc_division' => $division->getDesc_division(),
		  'date_creation' => $division->getDate_creation()
        );
        $this->getDbTable()->update($data, array('id_division = ?' => $division->getId_division()));
    }

    public function find($id_division, Application_Model_EuDivision $division) {
        $result = $this->getDbTable()->find($id_division);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $division->setId_division($row->id_division)
                 ->setCode_division($row->code_division)
                 ->setNom_division($row->nom_division)
				 ->setDesc_division($row->desc_division)
				 ->setDate_creation($row->date_creation)
				 ;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDivision();
            $entry->setId_division($row->id_division)
                  ->setCode_division($row->code_division)
                  ->setNom_division($row->nom_division)
				  ->setDesc_division($row->desc_division)
				  ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function findConuter() {
      $tabela = new Application_Model_DbTable_EuDivision(); 
      $select = $tabela->select();
      $select->from('eu_division', array('MAX(id_division) as count'));
      $result = $tabela->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	

    public function delete($id_division) {
      $this->getDbTable()->delete(array('id_division = ?' => $id_division));
    }

}

?>
