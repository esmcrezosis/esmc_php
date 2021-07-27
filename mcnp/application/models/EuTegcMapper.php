<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuTegcMapper
 *
 * @author user
 */
 
 
class Application_Model_EuTegcMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTegc');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuTegc $gc) {
        $data = array(
            'code_tegc' => $gc->getCode_tegc(),
            'id_filiere' => $gc->getId_filiere(),
            'mdv' => $gc->getMdv(),
            'montant' => $gc->getMontant(),
            'code_membre' => $gc->getCode_membre(),
			'montant_utilise' => $gc->getMontant_utilise(),
			'solde_tegc' => $gc->getSolde_tegc(),
			'recurrent_illimite' => $gc->getRecurrent_illimite(),
			'recurrent_limite' => $gc->getRecurrent_limite(),
			'nonrecurrent' => $gc->getNonrecurrent(),
			'periode1' => $gc->getPeriode1(),
			'periode2' => $gc->getPeriode2(),
			'periode3' => $gc->getPeriode3(),
			'special' => $gc->getSpecial(),
			'ordinaire' => $gc->getOrdinaire(),
			'nom_tegc' => $gc->getNom_tegc(),
			'date_tegc' => $gc->getDate_tegc(),
			'nom_produit' => $gc->getNom_produit(),
			'id_utilisateur' => $gc->getId_utilisateur(),
			'tranche_payement' => $gc->getTranche_payement(),
            'subvention' => $gc->getSubvention(),
            'code_zone' => $gc->getCode_zone(),
            'id_pays' => $gc->getId_pays(),
            'id_region' => $gc->getId_region(),
            'id_prefecture' => $gc->getId_prefecture(),
            'id_canton' => $gc->getId_canton(),
			'formel' => $gc->getFormel(),
			'regime_tva' => $gc->getRegime_tva(),
			'type_tegc' => $gc->getType_tegc(),
			'code_membre_physique' => $gc->getCode_membre_physique()
			 			
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTegc $gc) {
        $data = array(
            'code_tegc' => $gc->getCode_tegc(),
            'id_filiere' => $gc->getId_filiere(),
            'mdv' => $gc->getMdv(),
            'montant' => $gc->getMontant(),
            'code_membre' => $gc->getCode_membre(),
			'montant_utilise' => $gc->getMontant_utilise(),
			'solde_tegc' => $gc->getSolde_tegc(),
			'recurrent_illimite' => $gc->getRecurrent_illimite(),
			'recurrent_limite' => $gc->getRecurrent_limite(),
			'nonrecurrent' => $gc->getNonrecurrent(),
			'periode1' => $gc->getPeriode1(),
			'periode2' => $gc->getPeriode2(),
			'periode3' => $gc->getPeriode3(),
			'special' => $gc->getSpecial(),
			'ordinaire' => $gc->getOrdinaire(),
			'nom_tegc' => $gc->getNom_tegc(),
			'date_tegc' => $gc->getDate_tegc(),
			'nom_produit' => $gc->getNom_produit(),
			'id_utilisateur' => $gc->getId_utilisateur(),
			'tranche_payement' => $gc->getTranche_payement(),
			'subvention' => $gc->getSubvention(),
            'code_zone' => $gc->getCode_zone(),
            'id_pays' => $gc->getId_pays(),
            'id_region' => $gc->getId_region(),
            'id_prefecture' => $gc->getId_prefecture(),
            'id_canton' => $gc->getId_canton(),
			'formel' => $gc->getFormel(),
			'regime_tva' => $gc->getRegime_tva(),
            'type_tegc' => $gc->getType_tegc(),
            'code_membre_physique' => $gc->getCode_membre_physique()			
        );
        $this->getDbTable()->update($data, array('code_tegc = ?' => $gc->getCode_tegc()));
    }

	
    public function find($code_tegc, Application_Model_EuTegc $gc) {
        $result = $this->getDbTable()->find($code_tegc);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $gc->setCode_tegc($row->code_tegc)
               ->setCode_membre($row->code_membre)
               ->setId_filiere($row->id_filiere)
               ->setMdv($row->mdv)
               ->setMontant($row->montant)
			   ->setMontant_utilise($row->montant_utilise)
			   ->setSolde_tegc($row->solde_tegc)
			   ->setRecurrent_illimite($row->recurrent_illimite)
			   ->setRecurrent_limite($row->recurrent_limite)
			   ->setNonrecurrent($row->nonrecurrent)
			   ->setPeriode1($row->periode1)
			   ->setPeriode2($row->periode2)
			   ->setPeriode3($row->periode3)
			   ->setSpecial($row->special)
			   ->setOrdinaire($row->ordinaire)
			   ->setNom_tegc($row->nom_tegc)
			   ->setDate_tegc($row->date_tegc)
			   ->setNom_produit($row->nom_produit)
			   ->setId_utilisateur($row->id_utilisateur)
			   ->setTranche_payement($row->tranche_payement)
			   ->setSubvention($row->subvention)
			   ->setCode_zone($row->code_zone)
			   ->setId_pays($row->id_pays)
			   ->setId_region($row->id_region)
			   ->setId_prefecture($row->id_prefecture)
			   ->setId_canton($row->id_canton)
			   ->setFormel($row->formel)
			   ->setRegime_tva($row->regime_tva)
			   ->setType_tegc($row->type_tegc)
			   ->setCode_membre_physique($row->code_membre_physique);
            return true;
        }
    }

	
    public function findByMembrefiliere($membre, $filiere, Application_Model_EuTegc $gc) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre= ?', $membre)->where('code_gac_filiere = ?', $filiere);  
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $gc->setCode_tegc($row->code_tegc)
           ->setCode_membre($row->code_membre)
           ->setId_filiere($row->id_filiere)
           ->setMdv($row->mdv)
           ->setMontant($row->montant)
		   ->setMontant_utilise($row->montant_utilise)
		   ->setSolde_tegc($row->solde_tegc)
		   ->setRecurrent_illimite($row->recurrent_illimite)
		   ->setRecurrent_limite($row->recurrent_limite)
		   ->setNonrecurrent($row->nonrecurrent)
		   ->setPeriode1($row->periode1)
		   ->setPeriode2($row->periode2)
		   ->setPeriode3($row->periode3)
		   ->setSpecial($row->special)
		   ->setOrdinaire($row->ordinaire)
		   ->setNom_tegc($row->nom_tegc)
		   ->setDate_tegc($row->date_tegc)
		   ->setNom_produit($row->nom_produit)
		   ->setId_utilisateur($row->id_utilisateur)
		   ->setTranche_payement($row->tranche_payement)
		   ->setSubvention($row->subvention)
		   ->setCode_zone($row->code_zone)
		   ->setId_pays($row->id_pays)
		   ->setId_region($row->id_region)
		   ->setId_prefecture($row->id_prefecture)
		   ->setId_canton($row->id_canton)
		   ->setFormel($row->formel)
		   ->setRegime_tva($row->regime_tva)
		   ->setType_tegc($row->type_tegc)
		   ->setCode_membre_physique($row->code_membre_physique);
        return true;
    }
    
	
	public function fetchByMembreConfig($code_membre)  {
	    $select = $this->getDbTable()->select();
	    if(substr($code_membre,19,1)=='M') {
	      $select->where('code_membre = ?', $code_membre);
		} else {
          $select->where('code_membre_physique = ?', $code_membre);
        }		
	    $select->where('tranche_payement is not null');
	    $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
	    $entries = array();
        foreach ($result as $row) {
	     $entry = new Application_Model_EuTegc();
         $entry->setCode_tegc($row->code_tegc)
               ->setCode_membre($row->code_membre)
               ->setId_filiere($row->id_filiere)
               ->setMdv($row->mdv)
               ->setMontant($row->montant)
		       ->setMontant_utilise($row->montant_utilise)
		       ->setSolde_tegc($row->solde_tegc)
		       ->setRecurrent_illimite($row->recurrent_illimite)
		       ->setRecurrent_limite($row->recurrent_limite)
		       ->setNonrecurrent($row->nonrecurrent)
		       ->setPeriode1($row->periode1)
		       ->setPeriode2($row->periode2)
			   ->setPeriode3($row->periode3)
		       ->setSpecial($row->special)
		       ->setOrdinaire($row->ordinaire)
		       ->setNom_tegc($row->nom_tegc)
		       ->setDate_tegc($row->date_tegc)
		       ->setNom_produit($row->nom_produit)
		       ->setId_utilisateur($row->id_utilisateur)
		       ->setTranche_payement($row->tranche_payement)
			   ->setSubvention($row->subvention)
			   ->setCode_zone($row->code_zone)
			   ->setId_pays($row->id_pays)
			   ->setId_region($row->id_region)
			   ->setId_prefecture($row->id_prefecture)
			   ->setId_canton($row->id_canton)
			   ->setFormel($row->formel)
		       ->setRegime_tva($row->regime_tva)
			   ->setType_tegc($row->type_tegc)
			   ->setCode_membre_physique($row->code_membre_physique);
         $entries[] = $entry;
	   }
	   return $entries;
	}
	
	
    public function findByMembreTe($membre,Application_Model_EuTegc $gc) {
        $select = $this->getDbTable()->select();
		if(substr($membre,19,1)=='M') {
          $select->where('code_membre = ?', $membre);
		} else {
          $select->where('code_membre_physique = ?', $membre);
        }
        $select->where('type_tegc <> ?', "PRESTATAIRE");		
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $gc->setCode_tegc($row->code_tegc)
           ->setCode_membre($row->code_membre)
           ->setId_filiere($row->id_filiere)
           ->setMdv($row->mdv)
           ->setMontant($row->montant)
	   ->setMontant_utilise($row->montant_utilise)
           ->setSolde_tegc($row->solde_tegc)
	   ->setRecurrent_illimite($row->recurrent_illimite)
	   ->setRecurrent_limite($row->recurrent_limite)
	   ->setNonrecurrent($row->nonrecurrent)
	   ->setPeriode1($row->periode1)
	   ->setPeriode2($row->periode2)
	   ->setPeriode3($row->periode3)
	   ->setSpecial($row->special)
	   ->setOrdinaire($row->ordinaire)
	   ->setNom_tegc($row->nom_tegc)
	   ->setDate_tegc($row->date_tegc)
	   ->setNom_produit($row->nom_produit)
	   ->setId_utilisateur($row->id_utilisateur)
	   ->setTranche_payement($row->tranche_payement)
	   ->setSubvention($row->subvention)
	   ->setCode_zone($row->code_zone)
	   ->setId_pays($row->id_pays)
	   ->setId_region($row->id_region)
	   ->setId_prefecture($row->id_prefecture)
	   ->setId_canton($row->id_canton)
	   ->setFormel($row->formel)
	   ->setRegime_tva($row->regime_tva)
	   ->setType_tegc($row->type_tegc)
	   ->setCode_membre_physique($row->code_membre_physique);
        return true;
    }
	
    public function findByMembre($membre,Application_Model_EuTegc $gc) {
        $select = $this->getDbTable()->select();
		if(substr($membre,19,1)=='M') {
          $select->where('code_membre = ?', $membre);
		} else {
          $select->where('code_membre_physique = ?', $membre);
        }		
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $gc->setCode_tegc($row->code_tegc)
           ->setCode_membre($row->code_membre)
           ->setId_filiere($row->id_filiere)
           ->setMdv($row->mdv)
           ->setMontant($row->montant)
	       ->setMontant_utilise($row->montant_utilise)
		   ->setSolde_tegc($row->solde_tegc)
		   ->setRecurrent_illimite($row->recurrent_illimite)
		   ->setRecurrent_limite($row->recurrent_limite)
		   ->setNonrecurrent($row->nonrecurrent)
		   ->setPeriode1($row->periode1)
		   ->setPeriode2($row->periode2)
		   ->setPeriode3($row->periode3)
		   ->setSpecial($row->special)
		   ->setOrdinaire($row->ordinaire)
		   ->setNom_tegc($row->nom_tegc)
		   ->setDate_tegc($row->date_tegc)
		   ->setNom_produit($row->nom_produit)
		   ->setId_utilisateur($row->id_utilisateur)
		   ->setTranche_payement($row->tranche_payement)
		   ->setSubvention($row->subvention)
		   ->setCode_zone($row->code_zone)
		   ->setId_pays($row->id_pays)
		   ->setId_region($row->id_region)
		   ->setId_prefecture($row->id_prefecture)
		   ->setId_canton($row->id_canton)
		   ->setFormel($row->formel)
		   ->setRegime_tva($row->regime_tva)
		   ->setType_tegc($row->type_tegc)
		   ->setCode_membre_physique($row->code_membre_physique);
        return true;
    }

	
	public function getLastTegc() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(substring(code_tegc,-5)) as code'));
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
           return NULL;
        } else {
           $row = $result->current();
           return $row['code'];
        }
    }
	
	public function getLastTegcByMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(substring(code_tegc,-5)) as code'));
		if(substr($code_membre,19,1) == 'M') {
		   $select->where('code_membre like ?',$code_membre);
		} else {
		   $select->where('code_membre_physique like ?',$code_membre);
		}
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
           $row = $result->current();
           return $row['code'];
        }
    }
	
	
	
	
	
    public function findGcpByTe($membre, $te) {
        $db = $this->getDbTable()->getAdapter();
        $sql = "SELECT t.code_tegc, t.code_membre, g.* FROM eu_tegc t JOIN eu_gcp g WHERE t.code_tegc = g.code_tegc AND t.code_membre = " . $membre . "t.code_tegc =" . $te;
        $select = $db->query($sql);
        $results = $select->fetchAll();
        if (count($results) > 0) {
            return $results;
        } else {
            return NULL;
        }
    }

	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTegc();
            $entry->setCode_tegc($row->code_tegc)
                  ->setCode_membre($row->code_membre)
                  ->setId_filiere($row->id_filiere)
                  ->setMdv($row->mdv)
                  ->setMontant($row->montant)
			      ->setMontant_utilise($row->montant_utilise)
			      ->setSolde_tegc($row->solde_tegc)
				  ->setRecurrent_illimite($row->recurrent_illimite)
				  ->setRecurrent_limite($row->recurrent_limite)
				  ->setNonrecurrent($row->nonrecurrent)
				  ->setPeriode1($row->periode1)
				  ->setPeriode2($row->periode2)
				  ->setPeriode3($row->periode3)
				  ->setSpecial($row->special)
				  ->setOrdinaire($row->ordinaire)
				  ->setNom_tegc($row->nom_tegc)
				  ->setDate_tegc($row->date_tegc)
				  ->setNom_produit($row->nom_produit)
				  ->setId_utilisateur($row->id_utilisateur)
				  ->setTranche_payement($row->tranche_payement)
				  ->setSubvention($row->subvention)
			      ->setCode_zone($row->code_zone)
			      ->setId_pays($row->id_pays)
			      ->setId_region($row->id_region)
			      ->setId_prefecture($row->id_prefecture)
			      ->setId_canton($row->id_canton)
				  ->setFormel($row->formel)
		          ->setRegime_tva($row->regime_tva)
				  ->setType_tegc($row->type_tegc)
				  ->setCode_membre_physique($row->code_membre_physique);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_tegc) {
      $this->getDbTable()->delete(array('code_tegc = ?' => $code_tegc));
    }

	public function fetchByMembre($code_membre)  {
	    $select = $this->getDbTable()->select();
	    if(substr($code_membre,19,1) == 'M') {
	       $select->where('code_membre = ?', $code_membre);
		} else {
           $select->where('code_membre_physique = ?', $code_membre);
        }		
        //$select->where("code_tegc IN (SELECT code_tegc FROM eu_gcp WHERE type_gcp LIKE 'DIST')");
	    //$select->where('tranche_payement is not null');
	    $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
          return false;
        }
	    $entries = array();
        foreach ($result as $row)    {
	     $entry = new Application_Model_EuTegc();
         $entry->setCode_tegc($row->code_tegc)
                  ->setCode_membre($row->code_membre)
                  ->setId_filiere($row->id_filiere)
                  ->setMdv($row->mdv)
                  ->setMontant($row->montant)
			      ->setMontant_utilise($row->montant_utilise)
			      ->setSolde_tegc($row->solde_tegc)
				  ->setRecurrent_illimite($row->recurrent_illimite)
				  ->setRecurrent_limite($row->recurrent_limite)
				  ->setNonrecurrent($row->nonrecurrent)
				  ->setPeriode1($row->periode1)
				  ->setPeriode2($row->periode2)
				  ->setPeriode3($row->periode3)
				  ->setSpecial($row->special)
				  ->setOrdinaire($row->ordinaire)
				  ->setNom_tegc($row->nom_tegc)
				  ->setDate_tegc($row->date_tegc)
				  ->setNom_produit($row->nom_produit)
				  ->setId_utilisateur($row->id_utilisateur)
				  ->setTranche_payement($row->tranche_payement)
				  ->setSubvention($row->subvention)
			      ->setCode_zone($row->code_zone)
			      ->setId_pays($row->id_pays)
			      ->setId_region($row->id_region)
			      ->setId_prefecture($row->id_prefecture)
			      ->setId_canton($row->id_canton)
				  ->setFormel($row->formel)
		          ->setRegime_tva($row->regime_tva)
				  ->setType_tegc($row->type_tegc)
				  ->setCode_membre_physique($row->code_membre_physique);
         $entries[] = $entry;
	   }
	   return $entries;
	}
	
	
	/* Fonction pour récuperer le code_tegc dont le nom est celui de la surveillance*/
	public function findCodeTegc($code_membre = "", $nom_tegc = "") {
        $select = $this->getDbTable()->select();
      	$select->from($this->getDbTable(), array('code_tegc'));
		if($code_membre != "") {
           $select->where("code_membre LIKE '%".$code_membre."%'");
		}
		if($nom_tegc != "") {
		   $select->where("nom_tegc LIKE '%".$nom_tegc."%'");
		}
		$result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
           return false;
        } else {
           $row = $result->current();
           return $row['code_tegc'];
        }
    }
	
	public function findCodeMembre($code_membre = "") {
        $select = $this->getDbTable()->select();
      	$select->from($this->getDbTable(), array('nom_tegc'));
		if($code_membre != "") {
           $select->where("code_tegc LIKE '%".$code_membre."%'");
		}
		$select->where("nom_tegc IS NOT NULL");
		$result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
           return false;
        } else {
           $row = $result->current();
           return $row['nom_tegc'];
        }
    }
	
	

}

?>
