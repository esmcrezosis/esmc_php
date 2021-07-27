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
 
 
 
class Application_Model_EuDivisionGacMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDivisionGac');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuDivisionGac $division) {
      $data = array(
        'id_division_gac' => $division->getId_division_gac(),
        'code_gac' => $division->getCode_gac(),
        'code_membre' => $division->getCode_membre(),
	    'type_division' => $division->getType_division(),
		'nom_division' => $division->getNom_division(),
		'libelle_division' => $division->getLibelle_division()
      );
      $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDivisionGac $division) {
        $data = array(
          'id_division_gac' => $division->getId_division_gac(),
          'code_gac' => $division->getCode_gac(),
          'code_membre' => $division->getCode_membre(),
	      'type_division' => $division->getType_division(),
		  'nom_division' => $division->getNom_division(),
		  'libelle_division' => $division->getLibelle_division()
        );
        $this->getDbTable()->update($data, array('id_division_gac = ?' => $division->getId_division_gac()));
    }

    public function find($id_division_gac, Application_Model_EuDivisionGac $division) {
        $result = $this->getDbTable()->find($id_division_gac);
        if(0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $division->setId_division_gac($row->id_division_gac)
                 ->setCode_gac($row->code_gac)
                 ->setCode_membre($row->code_membre)
				 ->setType_division($row->type_division)
				 ->setNom_division($row->nom_division)
				 ->setLibelle_division($row->libelle_division);
        return true;
    }
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDivisionGac();
            $entry->setId_division_gac($row->id_division_gac)
                  ->setCode_gac($row->code_gac)
                  ->setCode_membre($row->code_membre)
				  ->setType_division($row->type_division)
				  ->setNom_division($row->nom_division)
				  ->setLibelle_division($row->libelle_division);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function findConuter() {
      $tabela = new Application_Model_DbTable_EuDivisionGac(); 
      $select = $tabela->select();
      $select->from('eu_division_gac', array('MAX(id_division_gac) as count'));
      $result = $tabela->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	

    public function delete($id_division_gac) {
      $this->getDbTable()->delete(array('id_division_gac = ?' => $id_division_gac));
    }

}

?>
