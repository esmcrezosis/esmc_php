<?php

class Application_Model_EuLettreImmobilisationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuLettreImmobilisation');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuLettreImmobilisation $lettre) {
      $data = array(
         'id_lettre' => $lettre->getId_lettre(),
	     'id_fiche_immobilisation' => $lettre->getId_fiche_immobilisation(),
         'motif1' => $lettre->getMotif1(),
         'valider' => $lettre->getValider(),
         'rejeter' => $lettre->getRejeter(),
         'code_membre_fournisseur' => $lettre->getCode_membre_fournisseur(),
         'date_creation' => $lettre->getDate_creation(),
		 'motif2' => $lettre->getMotif2(),
		 'date_restitution' => $lettre->getDate_restitution()
      );
      $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuLettreImmobilisation $lettre) {
        $data = array(
         'id_lettre' => $lettre->getId_lettre(),
	     'id_fiche_immobilisation' => $lettre->getId_fiche_immobilisation(),
         'motif1' => $lettre->getMotif1(),
         'valider' => $lettre->getValider(),
         'rejeter' => $lettre->getRejeter(),
         'code_membre_fournisseur' => $lettre->getCode_membre_fournisseur(),
         'date_creation' => $lettre->getDate_creation(),
		 'motif2' => $lettre->getMotif2(),
		 'date_restitution' => $lettre->getDate_restitution()
        );
        $this->getDbTable()->update($data, array('id_lettre = ?' => $lettre->getId_lettre()));
    }
	
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_lettre) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function find($id_lettre, Application_Model_EuLettreImmobilisation $lettre) {
        $result = $this->getDbTable()->find($id_lettre);
        if(count($result) == 0) {
           return false;
        }
        $row = $result->current();
        $lettre->setId_lettre($row->id_lettre)
		       ->setId_fiche_immobilisation($row->id_fiche_immobilisation)
		       ->setMotif1($row->motif1)
               ->setValider($row->valider)
		       ->setRejeter($row->rejeter)
               ->setCode_membre_fournisseur($row->code_membre_fournisseur)
               ->setDate_creation($row->date_creation)
			   ->setMotif2($row->motif2)
			   ->setDate_restitution($row->date_restitution);
        return true;
    }
    

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuUtilisateur();
            $entry->setId_lettre($row->id_lettre)
		          ->setId_fiche_immobilisation($row->id_fiche_immobilisation)
		          ->setMotif1($row->motif1)
                  ->setValider($row->valider)
		          ->setRejeter($row->rejeter)
                  ->setCode_membre_fournisseur($row->code_membre_fournisseur)
                  ->setDate_creation($row->date_creation)
				  ->setMotif2($row->motif2)
				  ->setDate_restitution($row->date_restitution)
				  ;
            $entries[] = $entry;
        }
        return $entries;
    }

	
    public function delete($id_lettre) {
        $this->getDbTable()->delete(array('id_lettre = ?' => $id_lettre));
    }
	
	
}

