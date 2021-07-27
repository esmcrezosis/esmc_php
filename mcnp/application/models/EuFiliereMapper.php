<?php

class Application_Model_EuFiliereMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFiliere');
        }
        return $this->_dbTable;
    }

    public function find($id_filiere, Application_Model_EuFiliere $filiere) {
        $result = $this->getDbTable()->find($id_filiere);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $filiere->setId_filiere($row->id_filiere)
                ->setNom_filiere($row->nom_filiere)
                ->setDescrip_filiere($row->descrip_filiere)
                ->setDate_creation($row->date_creation)
                ->setId_utilisateur($row->id_utilisateur)
				->setCode_division($row->code_division)
				->setId_sous_division($row->id_sous_division);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFiliere();
            $entry->setId_filiere($row->id_filiere)
                  ->setNom_filiere($row->nom_filiere)
                  ->setDescrip_filiere($row->descrip_filiere)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
			      ->setCode_division($row->code_division)
			      ->setId_sous_division($row->id_sous_division);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_filiere) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }



    public function save(Application_Model_EuFiliere $filiere) {
        $data = array(
            'id_filiere' => $filiere->getId_filiere(),
            'nom_filiere' => $filiere->getNom_filiere(),
            'descrip_filiere' => $filiere->getDescrip_filiere(),
            'date_creation' => $filiere->getDate_creation(),
            'id_utilisateur' => $filiere->getId_utilisateur(),
			'code_division' => $filiere->getCode_division(),
			'id_sous_division' => $filiere->getId_sous_division()	
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFiliere $filiere) {
        $data = array(
            'id_filiere' => $filiere->getId_filiere(),
            'nom_filiere' => $filiere->getNom_filiere(),
            'descrip_filiere' => $filiere->getDescrip_filiere(),
            'date_creation' => $filiere->getDate_creation(),
            'id_utilisateur' => $filiere->getId_utilisateur(),
			'code_division' => $filiere->getCode_division(),
			'id_sous_division' => $filiere->getId_sous_division()
       );
       $this->getDbTable()->update($data, array('id_filiere = ?' => $filiere->getId_filiere()));
    }


      public function findByDivision($code_division) {
		$table = new Application_Model_DbTable_EuFiliere;
        $select = $table->select();
		if(isset($code_division) && $code_division!=""){
        $select->where('code_division = ?', $code_division);
		}
        $resultSet = $table->fetchAll($select);
        if (0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFiliere();
            $entry->setId_filiere($row->id_filiere)
                  ->setNom_filiere($row->nom_filiere)
                  ->setDescrip_filiere($row->descrip_filiere)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setCode_division($row->code_division)
				  ->setId_sous_division($row->id_sous_division);
             $entries[] = $entry;
        }
        return $entries;
    }
	 
	 
	 
	 


    public function delete($id_filiere) {
        $this->getDbTable()->delete(array('id_filiere = ?' => $id_filiere));
    }

//////////////////////////////////////////////////////////


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("id_filiere IN (SELECT DISTINCT id_filiere FROM eu_membre_morale WHERE id_filiere IS NOT NULL)");
		$select->order(array('nom_filiere ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFiliere();
            $entry->setId_filiere($row->id_filiere)
                  ->setNom_filiere($row->nom_filiere)
                  ->setDescrip_filiere($row->descrip_filiere)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setCode_division($row->code_division)
				  ->setId_sous_division($row->id_sous_division);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll3() {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_membre_morale', 'eu_membre_morale.id_filiere = eu_filiere.id_filiere');
		$select->join('eu_article_stockes', 'eu_article_stockes.code_membre_morale = eu_membre_morale.code_membre_morale');
		$select->where('eu_article_stockes.vendu = ? ', 0);
		$select->where('eu_article_stockes.publier = ? ', 1);
		$select->order(array('eu_filiere.nom_filiere ASC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFiliere();
            $entry->setId_filiere($row->id_filiere)
                  ->setNom_filiere($row->nom_filiere)
                  ->setDescrip_filiere($row->descrip_filiere)
                  ->setDate_creation($row->code_barre)
                  ->setId_utilisateur($row->code_membre_morale)
				  ->setCode_division($row->code_division)
				  ->setId_sous_division($row->id_sous_division);
            $entries[] = $entry;
        }
        return $entries;
    }




}


?>
