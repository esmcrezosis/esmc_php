<?php

class Application_Model_EuDemandeConfigteMapper {
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
           $this->setDbTable('Application_Model_DbTable_EuDemandeConfigte');
        }
        return $this->_dbTable;
    }

	
    public function find($id_demande, Application_Model_EuDemandeConfigte $demandeconfig) {
        $result = $this->getDbTable()->find($id_demande);
        if (0 == count($result)) {
           return;
        }
        $row = $result->current();
        $demandeconfig->setId_demande($row->id_demande)
                      ->setNom_produit($row->nom_produit)
					  ->setProduit_special($row->produit_special)
					  ->setProduit_ordinaire($row->produit_ordinaire)
                      ->setCode_membre_morale($row->code_membre_morale)
                      ->setValider($row->valider)
					  ->setDate_demande($row->date_demande)
                      ->setId_canton($row->id_canton);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemandeConfigte();
            $entry->setId_demande($row->id_demande)
                  ->setNom_produit($row->nom_produit)
				  ->setProduit_special($row->produit_special)
				  ->setProduit_ordinaire($row->produit_ordinaire)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setValider($row->valider)
            ->setDate_demande($row->date_demande)
				  ->setId_canton($row->id_canton);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('COUNT(id_demande) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }

    public function save(Application_Model_EuDemandeConfigte $demandeconfigte) {
        $data = array(
          'id_demande' => $demandeconfigte->getId_demande(),
          'nom_produit' => $demandeconfigte->getNom_produit(),
	      'produit_special' => $demandeconfigte->getProduit_special(),
		  'produit_ordinaire' => $demandeconfigte->getProduit_ordinaire(),
          'code_membre_morale' => $demandeconfigte->getCode_membre_morale(),
          'valider' => $demandeconfigte->getValider(),
          'date_demande' => $demandeconfigte->getDate_demande(),
		  'id_canton' => $demandeconfigte->getId_canton()  
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDemandeConfigte $demandeconfigte) {
        $data = array(
          'id_demande' => $demandeconfigte->getId_demande(),
          'nom_produit' => $demandeconfigte->getNom_produit(),
		  'produit_special' => $demandeconfigte->getProduit_special(),
		  'produit_ordinaire' => $demandeconfigte->getProduit_ordinaire(),
          'code_membre_morale' => $demandeconfigte->getCode_membre_morale(),
          'valider' => $demandeconfigte->getValider(),
          'date_demande' => $demandeconfigte->getDate_demande(),
		  'id_canton' => $demandeconfigte->getId_canton()  
        );
        $this->getDbTable()->update($data, array('id_demande = ?' => $demandeconfigte->getId_demande()));
    }
	
	
	
	public function findbymembre($code_membre) {
	   $select = $this->getDbTable()->select();
	   $select->where("code_membre_morale = ? ", $code_membre);
	   $select->where("valider = ? ",3);
	   $result = $this->getDbTable()->fetchAll($select);
	   if (0 == count($result)) {
          return false;
       }
	   $row = $result->current();
	   $entry = new Application_Model_EuDemandeConfigte();
	   $entry->setId_demande($row->id_demande)
		     ->setNom_produit($row->nom_produit)
		     ->setProduit_special($row->produit_special)
			 ->setProduit_ordinaire($row->produit_ordinaire)
		     ->setCode_membre_morale($row->code_membre_morale)
			 ->setValider($row->valider)
            ->setDate_demande($row->date_demande)
			 ->setId_canton($row->id_canton);
	    return $entry;
	}
	
	
	

    public function delete($id_alerte) {
        $this->getDbTable()->delete(array('id_demande = ?' => $id_demande));
    }





public function fetchAllByValider($valider = 0) {
     $select = $this->getDbTable()->select();
     //if($valider > 0){
     $select->where("valider = ? ", $valider);
   //}
     $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemandeConfigte();
            $entry->setId_demande($row->id_demande)
                  ->setNom_produit($row->nom_produit)
          ->setProduit_special($row->produit_special)
          ->setProduit_ordinaire($row->produit_ordinaire)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setValider($row->valider)
            ->setDate_demande($row->date_demande)
          ->setId_canton($row->id_canton);
            $entries[] = $entry;
        }
        return $entries;
  }


public function fetchAllByMembre($code_membre_morale) {
     $select = $this->getDbTable()->select();
     $select->where("code_membre_morale = ? ", $code_membre_morale);
     $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemandeConfigte();
            $entry->setId_demande($row->id_demande)
                  ->setNom_produit($row->nom_produit)
          ->setProduit_special($row->produit_special)
          ->setProduit_ordinaire($row->produit_ordinaire)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setValider($row->valider)
            ->setDate_demande($row->date_demande)
          ->setId_canton($row->id_canton);
            $entries[] = $entry;
        }
        return $entries;
  }




}
