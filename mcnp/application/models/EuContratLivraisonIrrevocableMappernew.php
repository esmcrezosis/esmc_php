<?php
 
class Application_Model_EuContratLivraisonIrrevocableMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuContratLivraisonIrrevocable');
        }
        return $this->_dbTable;
    }

    public function find($id_contrat, Application_Model_EuContratLivraisonIrrevocable $contrat) {
        $result = $this->getDbTable()->find($id_contrat);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $contrat->setId_contrat($row->id_contrat)
                ->setCode_membre($row->code_membre)
                ->setNumero_contrat($row->numero_contrat)
                ->setPeriode_garde($row->periode_garde)
                ->setChargement_produit($row->chargement_produit)
                ->setDate_contrat($row->date_contrat)
                ->setStatut($row->statut)
				->setValider($row->valider)
				->setBai($row->bai)
				->setMontant_bai($row->montant_bai)
				->setBan($row->ban)
				->setMontant_ban($row->montant_ban)
				->setOpi($row->opi)
				->setMontant_opi($row->montant_opi)
				->setMontant_contrat($row->montant_contrat);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("id_contrat DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuContratLivraisonIrrevocable();
            $entry->setId_contrat($row->id_contrat)
                  ->setCode_membre($row->code_membre)
                  ->setNumero_contrat($row->numero_contrat)
                  ->setPeriode_garde($row->periode_garde)
                  ->setChargement_produit($row->chargement_produit)
                  ->setDate_contrat($row->date_contrat)
                  ->setStatut($row->statut)
				  ->setValider($row->valider)
				  ->setBai($row->bai)
				  ->setMontant_bai($row->montant_bai)
				  ->setBan($row->ban)
				  ->setMontant_ban($row->montant_ban)
				  ->setOpi($row->opi)
				  ->setMontant_opi($row->montant_opi)
				  ->setMontant_contrat($row->montant_contrat);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_contrat) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	

    public function save(Application_Model_EuContratLivraisonIrrevocable $contrat) {
        $data = array(
          'id_contrat' => $contrat->getId_contrat(),
          'code_membre' => $contrat->getCode_membre(),
          'numero_contrat' => $contrat->getNumero_contrat(),
          'periode_garde' => $contrat->getPeriode_garde(),
          'chargement_produit' => $contrat->getChargement_produit(),
          'date_contrat' => $contrat->getDate_contrat(),
          'statut' => $contrat->getStatut(),
		  'valider' => $contrat->getValider(),
		  'bai' => $contrat->getBai(),
		  'montant_bai' => $contrat->getMontant_bai(),
		  'ban' => $contrat->getBan(),
		  'montant_ban' => $contrat->getMontant_ban(),
		  'opi' => $contrat->getOpi(),
		  'montant_opi' => $contrat->getMontant_opi(),
		  'montant_contrat' => $contrat->getMontant_contrat()
        );
        
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuContratLivraisonIrrevocable $contrat) {
        $data = array(
          'id_contrat' => $contrat->getId_contrat(),
          'code_membre' => $contrat->getCode_membre(),
          'numero_contrat' => $contrat->getNumero_contrat(),
          'periode_garde' => $contrat->getPeriode_garde(),
          'chargement_produit' => $contrat->getChargement_produit(),
          'date_contrat' => $contrat->getDate_contrat(),
          'statut' => $contrat->getStatut(),
	      'valider' => $contrat->getValider(),
		  'bai' => $contrat->getBai(),
		  'montant_bai' => $contrat->getMontant_bai(),
		  'ban' => $contrat->getBan(),
		  'montant_ban' => $contrat->getMontant_ban(),
		  'opi' => $contrat->getOpi(),
		  'montant_opi' => $contrat->getMontant_opi(),
		  'montant_contrat' => $contrat->getMontant_contrat()
        );
        
        $this->getDbTable()->update($data, array('id_contrat = ?' => $contrat->getId_contrat()));
    }

    public function delete($id_contrat) {
        $this->getDbTable()->delete(array('id_contrat = ?' => $id_contrat));
    }


    public function fetchAllByCodeMembre($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
		$select->where("code_membre = ? ", $code_membre);
        }
        //$select->where("statut = ? ", 1);
        $select->order("id_contrat DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuContratLivraisonIrrevocable();
            $entry->setId_contrat($row->id_contrat)
                  ->setCode_membre($row->code_membre)
                  ->setNumero_contrat($row->numero_contrat)
                  ->setPeriode_garde($row->periode_garde)
                  ->setChargement_produit($row->chargement_produit)
                  ->setDate_contrat($row->date_contrat)
                  ->setStatut($row->statut)
				  ->setValider($row->valider)
				  ->setBai($row->bai)
				  ->setMontant_bai($row->montant_bai)
				  ->setBan($row->ban)
				  ->setMontant_ban($row->montant_ban)
				  ->setOpi($row->opi)
				  ->setMontant_opi($row->montant_opi)
				  ->setMontant_contrat($row->montant_contrat);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByCodeMembre0($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);
        }
        $select->where("statut = ? ", 0);
        $select->order("id_contrat DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuContratLivraisonIrrevocable();
            $entry->setId_contrat($row->id_contrat)
                  ->setCode_membre($row->code_membre)
                  ->setNumero_contrat($row->numero_contrat)
                  ->setPeriode_garde($row->periode_garde)
                  ->setChargement_produit($row->chargement_produit)
                  ->setDate_contrat($row->date_contrat)
                  ->setStatut($row->statut)
				  ->setValider($row->valider)
				  ->setBai($row->bai)
				  ->setMontant_bai($row->montant_bai)
				  ->setBan($row->ban)
				  ->setMontant_ban($row->montant_ban)
				  ->setOpi($row->opi)
				  ->setMontant_opi($row->montant_opi)
				  ->setMontant_contrat($row->montant_contrat);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByCodeMembre1($code_membre = "")   {
       $select = $this->getDbTable()->select();
       if($code_membre != "") {
          $select->where("code_membre = ? ", $code_membre);
       }
       $select->where("statut = ? ", 1);
       $select->order("id_contrat DESC");
       $resultSet = $this->getDbTable()->fetchAll($select);
       $entries = array();
       foreach($resultSet as $row) {
            $entry = new Application_Model_EuContratLivraisonIrrevocable();
            $entry->setId_contrat($row->id_contrat)
                ->setCode_membre($row->code_membre)
                ->setNumero_contrat($row->numero_contrat)
                ->setPeriode_garde($row->periode_garde)
                ->setChargement_produit($row->chargement_produit)
                ->setDate_contrat($row->date_contrat)
                ->setStatut($row->statut)
				->setValider($row->valider)
				->setBai($row->bai)
				->setMontant_bai($row->montant_bai)
				->setBan($row->ban)
				->setMontant_ban($row->montant_ban)
				->setOpi($row->opi)
				->setMontant_opi($row->montant_opi)
				->setMontant_contrat($row->montant_contrat);
            $entries[] = $entry;
        }
        return $entries;
    }
 
    
   

}


?>
