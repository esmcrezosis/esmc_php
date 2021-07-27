 <?php

class Application_Model_EuPostePointageMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPostePointage');
        }
        return $this->_dbTable;
    }
	
    public function find($id_poste_pointage, Application_Model_EuPostePointage $poste_pointage) {
        $result = $this->getDbTable()->find($id_poste_pointage);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $poste_pointage->setId_poste_pointage($row->id_poste_pointage)
                  ->setLibelle_poste_pointage($row->libelle_poste_pointage)
                  ->setCode_membre_employeur($row->code_membre_employeur)
                  ->setSalaire_base($row->salaire_base)
                  ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPostePointage();
            $entry->setId_poste_pointage($row->id_poste_pointage)
                  ->setLibelle_poste_pointage($row->libelle_poste_pointage)
                  ->setCode_membre_employeur($row->code_membre_employeur)
                  ->setSalaire_base($row->salaire_base)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
	  

    public function save(Application_Model_EuPostePointage $poste_pointage) {
        $data = array(
			      'id_poste_pointage' => $poste_pointage->getId_poste_pointage(),
            'code_membre_employeur' => $poste_pointage->getCode_membre_employeur(),
            'libelle_poste_pointage' => $poste_pointage->getLibelle_poste_pointage(),
            'salaire_base' => $poste_pointage->getSalaire_base()
        );

        $this->getDbTable()->insert($data);
    }
    
	
	
    public function update(Application_Model_EuPostePointage $poste_pointage) {
        $data = array(
          'id_poste_pointage' => $poste_pointage->getId_poste_pointage(),
          'code_membre_employeur' => $poste_pointage->getCode_membre_employeur(),
          'libelle_poste_pointage' => $poste_pointage->getLibelle_poste_pointage(),
          'salaire_base' => $poste_pointage->getSalaire_base()
        );
        $this->getDbTable()->update($data, array('id_poste_pointage = ?' => $poste_pointage->getId_poste_pointage()));
    }

    public function delete($id_poste_pointage) {
        $this->getDbTable()->delete(array('id_poste_pointage = ?' => $id_poste_pointage));
    }



  public function findConuter() {
        $tabela = new Application_Model_DbTable_EuPostePointage();
        $select = $tabela->select();
        $select->from('eu_poste_pointage', array('MAX(id_poste_pointage) as count'));
        $result = $tabela->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


public function fetchAllByEmployeur($code_membre_employeur) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_employeur = ?', $code_membre_employeur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPostePointage();
            $entry->setId_poste_pointage($row->id_poste_pointage)
                  ->setLibelle_poste_pointage($row->libelle_poste_pointage)
                  ->setCode_membre_employeur($row->code_membre_employeur)
                  ->setSalaire_base($row->salaire_base)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }

///////////////////////////////////////////////////////////////







}

?>
