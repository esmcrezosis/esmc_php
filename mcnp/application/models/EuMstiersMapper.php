<?php
 
class Application_Model_EuMstiersMapper {

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
        if(NULL === $this->_dbTable) {
           $this->setDbTable('Application_Model_DbTable_EuMstiers');
        }
        return $this->_dbTable;
    }

    public function find($id_mstiers, Application_Model_EuMstiers $mstiers) {
        $result = $this->getDbTable()->find($id_mstiers);
        if(count($result) == 0) {
           return false;
        }
		
        $row = $result->current();
        $mstiers->setId_mstiers($row->id_mstiers)
                ->setCode_membre($row->code_membre)
                ->setMontant_souscris($row->montant_souscris)
                ->setMontant_utilise($row->montant_utilise)
                ->setMontant_restant($row->montant_restant)
		        ->setType_souscription($row->type_souscription)
		        ->setId_souscription($row->id_souscription)
		        ->setDate_mstiers($row->date_mstiers)
		        ->setBon_neutre_code($row->bon_neutre_code)
		        ->setStatut_mstiers($row->statut_mstiers)
                ->setType_souscripteur($row->type_souscripteur)
                ->setType_mstiers($row->type_mstiers)
				->setBon_conso($row->bon_conso)
				->setFrais_solvabilite($row->frais_solvabilite)
				->setPeripherique($row->peripherique)
				->setConnectivite($row->connectivite)
				->setAssurance($row->assurance)
				->setDeposit($row->deposit)
				->setCompte_bancaire($row->compte_bancaire)
				->setDistributeur_peripherique($row->distributeur_peripherique)
				->setDistributeur_connectivite($row->distributeur_connectivite)
				->setDistributeur_assurance($row->distributeur_assurance)
				->setType_kit($row->type_kit)
				->setMontant_bc($row->montant_bc)
				->setMontant_peripherique($row->montant_peripherique)
				->setMontant_connectivite($row->montant_connectivite)
				->setMontant_assurance($row->montant_assurance)
				->setMontant_comptebancaire($row->montant_comptebancaire)
				->setId_cycle_formation($row->id_cycle_formation);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMstiers();
            $entry->setId_mstiers($row->id_mstiers)
                  ->setCode_membre($row->code_membre)
                  ->setMontant_souscris($row->montant_souscris)
                  ->setMontant_utilise($row->montant_utilise)
                  ->setMontant_restant($row->montant_restant)
		          ->setType_souscription($row->type_souscription)
		          ->setId_souscription($row->id_souscription)
		          ->setDate_mstiers($row->date_mstiers)
		          ->setBon_neutre_code($row->bon_neutre_code)
		          ->setStatut_mstiers($row->statut_mstiers)
                  ->setType_souscripteur($row->type_souscripteur)
                  ->setType_mstiers($row->type_mstiers)
				  ->setBon_conso($row->bon_conso)
				  ->setFrais_solvabilite($row->frais_solvabilite)
				  ->setPeripherique($row->peripherique)
				  ->setConnectivite($row->connectivite)
				  ->setAssurance($row->assurance)
				  ->setDeposit($row->deposit)
				  ->setCompte_bancaire($row->compte_bancaire)
				  ->setDistributeur_peripherique($row->distributeur_peripherique)
				  ->setDistributeur_connectivite($row->distributeur_connectivite)
				  ->setDistributeur_assurance($row->distributeur_assurance)
				  ->setType_kit($row->type_kit)
				  ->setMontant_bc($row->montant_bc)
				  ->setMontant_peripherique($row->montant_peripherique)
				  ->setMontant_connectivite($row->montant_connectivite)
				  ->setMontant_assurance($row->montant_assurance)
				  ->setMontant_comptebancaire($row->montant_comptebancaire)
				  ->setId_cycle_formation($row->id_cycle_formation);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_mstiers) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	public function fetchAllByMembre($membre) {
	    $tabela = new Application_Model_DbTable_EuMstiers();
	    $select = $tabela->select();
	    $select->where('code_membre = ?',$membre);
        //$select->where('type_souscription like ?',"CAPS");	   
	    $result = $tabela->fetchAll($select);
        if(count($result) == 0) {
           return NULL;
        }
	    $entries = array();
        foreach($result as $row) {
          $entry = new Application_Model_EuMstiers();
          $entry->setId_mstiers($row->id_mstiers)
                ->setCode_membre($row->code_membre)
                ->setMontant_souscris($row->montant_souscris)
                ->setMontant_utilise($row->montant_utilise)
                ->setMontant_restant($row->montant_restant)
		        ->setType_souscription($row->type_souscription)
		        ->setId_souscription($row->id_souscription)
		        ->setDate_mstiers($row->date_mstiers)
		        ->setBon_neutre_code($row->bon_neutre_code)
		        ->setStatut_mstiers($row->statut_mstiers)
                ->setType_souscripteur($row->type_souscripteur)
                ->setType_mstiers($row->type_mstiers)
				->setBon_conso($row->bon_conso)
				->setFrais_solvabilite($row->frais_solvabilite)
				->setPeripherique($row->peripherique)
				->setConnectivite($row->connectivite)
				->setAssurance($row->assurance)
				->setDeposit($row->deposit)
				->setCompte_bancaire($row->compte_bancaire)
				->setDistributeur_peripherique($row->distributeur_peripherique)
				->setDistributeur_connectivite($row->distributeur_connectivite)
				->setDistributeur_assurance($row->distributeur_assurance)
				->setType_kit($row->type_kit)
				->setMontant_bc($row->montant_bc)
				->setMontant_peripherique($row->montant_peripherique)
				->setMontant_connectivite($row->montant_connectivite)
				->setMontant_assurance($row->montant_assurance)
				->setMontant_comptebancaire($row->montant_comptebancaire)
				->setId_cycle_formation($row->id_cycle_formation);
		   $entries[] = $entry;
	     }
		 return $entries;
	 }
	 
	public  function findcumulMstiersAvecListe($membre)  {
	   $select = $this->getDbTable()->select();
       $select->from($this->getDbTable(), array('SUM(montant_restant) as somme'));
       $select->where("statut_mstiers = ?",'AvecListe');
	   $select->where('code_membre = ?',$membre);
	   $select->where("type_souscription = ?",'CAPS');
	   $select->where("montant_restant > ?",0);
	   $select->order(array("id_mstiers ASC"));
       $result = $this->getDbTable()->fetchAll($select);
       $row = $result->current();
       return $row['somme'];
	}
	 
	 
	 public function fetchAllMstiersAvecListe($membre)  {
	    $tabela = new Application_Model_DbTable_EuMstiers();
	    $select = $tabela->select();
	    $select->where('code_membre = ?',$membre);
		$select->where("statut_mstiers = ?",'AvecListe');
        $select->where('type_souscription like ?',"CAPS");
        $select->order(array("id_mstiers ASC"));		
	    $result = $tabela->fetchAll($select);
        if(count($result) == 0) {
           return false;
        }
	    $entries = array();
        foreach($result as $row) {
          $entry = new Application_Model_EuMstiers();
          $entry->setId_mstiers($row->id_mstiers)
                ->setCode_membre($row->code_membre)
                ->setMontant_souscris($row->montant_souscris)
                ->setMontant_utilise($row->montant_utilise)
                ->setMontant_restant($row->montant_restant)
				->setType_souscription($row->type_souscription)
				->setId_souscription($row->id_souscription)
				->setDate_mstiers($row->date_mstiers)
				->setBon_neutre_code($row->bon_neutre_code)
				->setStatut_mstiers($row->statut_mstiers)
                ->setType_souscripteur($row->type_souscripteur)
                ->setType_mstiers($row->type_mstiers)
				->setBon_conso($row->bon_conso)
				->setFrais_solvabilite($row->frais_solvabilite)
				->setPeripherique($row->peripherique)
				->setConnectivite($row->connectivite)
				->setAssurance($row->assurance)
				->setDeposit($row->deposit)
				->setCompte_bancaire($row->compte_bancaire)
				->setDistributeur_peripherique($row->distributeur_peripherique)
				->setDistributeur_connectivite($row->distributeur_connectivite)
				->setDistributeur_assurance($row->distributeur_assurance)
				->setType_kit($row->type_kit)
				->setMontant_bc($row->montant_bc)
				->setMontant_peripherique($row->montant_peripherique)
				->setMontant_connectivite($row->montant_connectivite)
				->setMontant_assurance($row->montant_assurance)
				->setMontant_comptebancaire($row->montant_comptebancaire)
				->setId_cycle_formation($row->id_cycle_formation);
		   $entries[] = $entry;
	    }
		return $entries;
	}
	 
	 
	 
	public function fetchAllMstiersSansListe() {
	    $select = $this->getDbTable()->select();
		$select->where("statut_mstiers = ?",'SansListe');
		$select->where("type_souscription = ?",'CAPS');
		$select->where("montant_restant > ?",0);
		$select->order(array("id_mstiers ASC")); 
		$result = $this->getDbTable()->fetchAll($select);
		if(count($result) == 0)  {
            return false;
        }
		
		$entries = array();
        foreach ($result as $row) {
	        $entry = new Application_Model_EuMstiers();
            $entry->setId_mstiers($row->id_mstiers)
                  ->setCode_membre($row->code_membre)
                  ->setMontant_souscris($row->montant_souscris)
                  ->setMontant_utilise($row->montant_utilise)
                  ->setMontant_restant($row->montant_restant)
				  ->setType_souscription($row->type_souscription)
				  ->setId_souscription($row->id_souscription)
				  ->setDate_mstiers($row->date_mstiers)
				  ->setBon_neutre_code($row->bon_neutre_code)
				  ->setStatut_mstiers($row->statut_mstiers)
                  ->setType_souscripteur($row->type_souscripteur)
                  ->setType_mstiers($row->type_mstiers)
				  ->setBon_conso($row->bon_conso)
				  ->setFrais_solvabilite($row->frais_solvabilite)
				  ->setPeripherique($row->peripherique)
				  ->setConnectivite($row->connectivite)
				  ->setAssurance($row->assurance)
				  ->setDeposit($row->deposit)
				  ->setCompte_bancaire($row->compte_bancaire)
				  ->setDistributeur_peripherique($row->distributeur_peripherique)
				  ->setDistributeur_connectivite($row->distributeur_connectivite)
				  ->setDistributeur_assurance($row->distributeur_assurance)
				  ->setType_kit($row->type_kit)
				  ->setMontant_bc($row->montant_bc)
				  ->setMontant_peripherique($row->montant_peripherique)
				  ->setMontant_connectivite($row->montant_connectivite)
				  ->setMontant_assurance($row->montant_assurance)
				  ->setMontant_comptebancaire($row->montant_comptebancaire)
				  ->setId_cycle_formation($row->id_cycle_formation);
            $entries[] = $entry;
	    }
		return $entries;
	}
	 
	 
	public  function findcumulMstiersSansListe()  {
	   $select = $this->getDbTable()->select();
       $select->from($this->getDbTable(), array('SUM(montant_restant) as somme'));
       $select->where("statut_mstiers = ?",'SansListe');
	   $select->where("type_souscription = ?",'CAPS');
	   $select->where("montant_restant > ?",0);
	   $select->order(array("id_mstiers ASC"));
       $result = $this->getDbTable()->fetchAll($select);
       $row = $result->current();
       return $row['somme'];
	}
	
	 
	public  function findcumulbc($apporteur,$type_souscription)  {
	    $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_restant) as somme'));
	    $select->where("code_membre like ?",$apporteur);
        $select->where("statut_mstiers = ?",'AvecListe');
	    $select->where("type_souscription like ?",$type_souscription);
		
		//$select->where("montant_bc = ?",$mont_bc);
		//$select->where("bon_conso = ?",1);
		
	    $select->where("montant_restant > ?",0);
	    $select->order(array("id_mstiers ASC"));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        if($row['somme'] == NULL) {
           return 0;
        } else {
           return $row['somme'];
        }
	}
	
	
	
    public function save(Application_Model_EuMstiers $mstiers) {
        $data = array(
            'id_mstiers' => $mstiers->getId_mstiers(),
            'code_membre' => $mstiers->getCode_membre(),
            'montant_souscris' => $mstiers->getMontant_souscris(),
			'montant_utilise' => $mstiers->getMontant_utilise(),
			'montant_restant' => $mstiers->getMontant_restant(),
			'type_souscription' => $mstiers->getType_souscription(),
            'type_souscripteur' => $mstiers->getType_souscripteur(),
            'type_mstiers' => $mstiers->getType_mstiers(),
			'id_souscription' => $mstiers->getId_souscription(),
			'date_mstiers' => $mstiers->getDate_mstiers(),
            'bon_neutre_code' => $mstiers->getBon_neutre_code(),
			'statut_mstiers' => $mstiers->getStatut_mstiers(),
			'bon_conso' => $mstiers->getBon_conso(),
			'frais_solvabilite' => $mstiers->getFrais_solvabilite(),
			'peripherique' => $mstiers->getPeripherique(),
			'connectivite' => $mstiers->getConnectivite(),
			'assurance' => $mstiers->getAssurance(),
			'compte_bancaire' => $mstiers->getCompte_bancaire(),
			'distributeur_peripherique' => $mstiers->getDistributeur_peripherique(),
			'distributeur_connectivite' => $mstiers->getDistributeur_connectivite(),
			'distributeur_assurance' => $mstiers->getDistributeur_assurance(),
			'type_kit' => $mstiers->getType_kit(),
			'montant_bc' => $mstiers->getMontant_bc(),
			'montant_peripherique' => $mstiers->getMontant_peripherique(),
			'montant_connectivite' => $mstiers->getMontant_connectivite(),
			'montant_assurance' => $mstiers->getMontant_assurance(),
			'montant_comptebancaire' => $mstiers->getMontant_comptebancaire(),
			'id_cycle_formation' => $mstiers->getId_cycle_formation(),
			'deposit' => $mstiers->getDeposit()
        );
        $this->getDbTable()->insert($data);
    }
	
	

    public function update(Application_Model_EuMstiers $mstiers) {
        $data = array(
            'id_mstiers' => $mstiers->getId_mstiers(),
            'code_membre' => $mstiers->getCode_membre(),
            'montant_souscris' => $mstiers->getMontant_souscris(),
			'montant_utilise' => $mstiers->getMontant_utilise(),
			'montant_restant' => $mstiers->getMontant_restant(),
			'type_souscription' => $mstiers->getType_souscription(),
            'type_souscripteur' => $mstiers->getType_souscripteur(),
            'type_mstiers' => $mstiers->getType_mstiers(),
			'id_souscription' => $mstiers->getId_souscription(),
			'date_mstiers' => $mstiers->getDate_mstiers(),
            'bon_neutre_code' => $mstiers->getBon_neutre_code(),
			'statut_mstiers' => $mstiers->getStatut_mstiers(),
			'bon_conso' => $mstiers->getBon_conso(),
			'frais_solvabilite' => $mstiers->getFrais_solvabilite(),
			'peripherique' => $mstiers->getPeripherique(),
			'connectivite' => $mstiers->getConnectivite(),
			'assurance' => $mstiers->getAssurance(),
			'compte_bancaire' => $mstiers->getCompte_bancaire(),
			'distributeur_peripherique' => $mstiers->getDistributeur_peripherique(),
			'distributeur_connectivite' => $mstiers->getDistributeur_connectivite(),
			'distributeur_assurance' => $mstiers->getDistributeur_assurance(),
			'type_kit' => $mstiers->getType_kit(),
			'montant_bc' => $mstiers->getMontant_bc(),
			'montant_peripherique' => $mstiers->getMontant_peripherique(),
			'montant_connectivite' => $mstiers->getMontant_connectivite(),
			'montant_assurance' => $mstiers->getMontant_assurance(),
			'montant_comptebancaire' => $mstiers->getMontant_comptebancaire(),
			'id_cycle_formation' => $mstiers->getId_cycle_formation(),
			'deposit' => $mstiers->getDeposit()
        );
        $this->getDbTable()->update($data, array('id_mstiers = ?' => $mstiers->getId_mstiers()));
    }

	
    public function delete($id_mstiers) {
        $this->getDbTable()->delete(array('id_mstiers = ?' => $id_mstiers));
    }


}


?>
