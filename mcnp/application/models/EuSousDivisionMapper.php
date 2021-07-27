    <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuSousDivisionMapper
 *
 * @author user
 */
 
class Application_Model_EuSousDivisionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSousDivision');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuSousDivision $sousdivision) {
      $data = array(
        'id_sous_division' => $sousdivision->getId_sous_division(),
        'id_division' => $sousdivision->getId_division(),
        'nom_sous_division' => $sousdivision->getNom_sous_division(),
	    'desc_sous_division' => $sousdivision->getDesc_sous_division(),
		'date_creation' => $sousdivision->getDate_creation()	
      );
      $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSousDivision $sousdivision) {
        $data = array(
          'id_sous_division' => $sousdivision->getId_sous_division(),
          'id_division' => $sousdivision->getId_division(),
          'nom_sous_division' => $sousdivision->getNom_sous_division(),
	      'desc_sous_division' => $sousdivision->getDesc_sous_division(),
		  'date_creation' => $sousdivision->getDate_creation()
        );
        $this->getDbTable()->update($data, array('id_sous_division = ?' => $sousdivision->getId_sous_division()));
    }

    public function find($id_sous_division, Application_Model_EuSousDivision $sousdivision) {
        $result = $this->getDbTable()->find($id_sous_division);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $sousdivision->setId_sous_division($row->id_sous_division)
                     ->setId_division($row->id_division)
                     ->setNom_sous_division($row->nom_sous_division)
				     ->setDesc_sous_division($row->desc_sous_division)
					 ->setDate_creation($row->date_creation)
					 ;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
          $entry = new Application_Model_EuSousDivision();
          $entry->setId_sous_division($row->id_sous_division)
                ->setId_division($row->id_division)
                ->setNom_sous_division($row->nom_sous_division)
				->setDesc_sous_division($row->desc_sous_division)
				->setDate_creation($row->date_creation);
          $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findConuter() {
        $tabela = new Application_Model_DbTable_EuSousDivision();
        $select = $tabela->select();
        $select->from('eu_sous_division', array('MAX(id_sous_division) as count'));
        $result = $tabela->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function delete($id_sous_division) {
        $this->getDbTable()->delete(array('id_sous_division = ?' => $id_sous_division));
    }

}

?>
