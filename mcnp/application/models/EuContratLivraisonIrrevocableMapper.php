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
                ->setType_validateur($row->type_validateur)
                ->setCivilite($row->civilite)
                ->setNom($row->nom)
                ->setDemeure($row->demeure)
                ->setLibelle_demeure($row->libelle_demeure)
                ->setQuartier($row->quartier)
                ->setQuartier_maison($row->quartier_maison)
                ->setBoite_postale($row->boite_postale)
                ->setTelephone($row->telephone)
                ->setType_maison($row->type_maison)
                ->setSituation($row->situation)
                ->setLibelle_situation($row->libelle_situation)
                ->setRue($row->rue)
                ->setCivilite_representant($row->civilite_representant)
                ->setNom_representant($row->nom_representant)
                ->setCarte_operateur($row->carte_operateur)
                ->setNumero_recipice($row->numero_recipice)
                ->setSiege($row->siege)
                ->setMatricule_rccm($row->matricule_rccm)
                ->setPeriode_garde($row->periode_garde)
                ->setChargement_produit($row->chargement_produit)
                ->setDate_contrat($row->date_contrat)
                ->setStatut($row->statut)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("id_contrat DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuContratLivraisonIrrevocable();
            $entry->setId_contrat($row->id_contrat)
                ->setCode_membre($row->code_membre)
                ->setNumero_contrat($row->numero_contrat)
                ->setType_validateur($row->type_validateur)
                ->setCivilite($row->civilite)
                ->setNom($row->nom)
                ->setDemeure($row->demeure)
                ->setLibelle_demeure($row->libelle_demeure)
                ->setQuartier($row->quartier)
                ->setQuartier_maison($row->quartier_maison)
                ->setBoite_postale($row->boite_postale)
                ->setTelephone($row->telephone)
                ->setType_maison($row->type_maison)
                ->setSituation($row->situation)
                ->setLibelle_situation($row->libelle_situation)
                ->setRue($row->rue)
                ->setCivilite_representant($row->civilite_representant)
                ->setNom_representant($row->nom_representant)
                ->setCarte_operateur($row->carte_operateur)
                ->setNumero_recipice($row->numero_recipice)
                ->setSiege($row->siege)
                ->setMatricule_rccm($row->matricule_rccm)
                ->setPeriode_garde($row->periode_garde)
                ->setChargement_produit($row->chargement_produit)
                ->setDate_contrat($row->date_contrat)
                ->setStatut($row->statut)
                ;
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
            'type_validateur' => $contrat->getType_validateur(),
            'civilite' => $contrat->getCivilite(),
            'nom' => $contrat->getNom(),
            'demeure' => $contrat->getDemeure(),
            'libelle_demeure' => $contrat->getLibelle_demeure(),
            'quartier' => $contrat->getQuartier(),
            'quartier_maison' => $contrat->getQuartier_maison(),
            'boite_postale' => $contrat->getBoite_postale(),
            'telephone' => $contrat->getTelephone(),
            'type_maison' => $contrat->getType_maison(),
            'situation' => $contrat->getSituation(),
            'libelle_situation' => $contrat->getLibelle_situation(),
            'rue' => $contrat->getRue(),
            'civilite_representant' => $contrat->getCivilite_representant(),
            'nom_representant' => $contrat->getNom_representant(),
            'carte_operateur' => $contrat->getCarte_operateur(),
            'numero_recipice' => $contrat->getNumero_recipice(),
            'siege' => $contrat->getSiege(),
            'matricule_rccm' => $contrat->getMatricule_rccm(),
            'periode_garde' => $contrat->getPeriode_garde(),
            'chargement_produit' => $contrat->getChargement_produit(),
            'date_contrat' => $contrat->getDate_contrat(),
            'statut' => $contrat->getStatut()
        );
        
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuContratLivraisonIrrevocable $contrat) {
        $data = array(
            'id_contrat' => $contrat->getId_contrat(),
            'code_membre' => $contrat->getCode_membre(),
            'numero_contrat' => $contrat->getNumero_contrat(),
            'type_validateur' => $contrat->getType_validateur(),
            'civilite' => $contrat->getCivilite(),
            'nom' => $contrat->getNom(),
            'demeure' => $contrat->getDemeure(),
            'libelle_demeure' => $contrat->getLibelle_demeure(),
            'quartier' => $contrat->getQuartier(),
            'quartier_maison' => $contrat->getQuartier_maison(),
            'boite_postale' => $contrat->getBoite_postale(),
            'telephone' => $contrat->getTelephone(),
            'type_maison' => $contrat->getType_maison(),
            'situation' => $contrat->getSituation(),
            'libelle_situation' => $contrat->getLibelle_situation(),
            'rue' => $contrat->getRue(),
            'civilite_representant' => $contrat->getCivilite_representant(),
            'nom_representant' => $contrat->getNom_representant(),
            'carte_operateur' => $contrat->getCarte_operateur(),
            'numero_recipice' => $contrat->getNumero_recipice(),
            'siege' => $contrat->getSiege(),
            'matricule_rccm' => $contrat->getMatricule_rccm(),
            'periode_garde' => $contrat->getPeriode_garde(),
            'chargement_produit' => $contrat->getChargement_produit(),
            'date_contrat' => $contrat->getDate_contrat(),
            'statut' => $contrat->getStatut()
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
                ->setType_validateur($row->type_validateur)
                ->setCivilite($row->civilite)
                ->setNom($row->nom)
                ->setDemeure($row->demeure)
                ->setLibelle_demeure($row->libelle_demeure)
                ->setQuartier($row->quartier)
                ->setQuartier_maison($row->quartier_maison)
                ->setBoite_postale($row->boite_postale)
                ->setTelephone($row->telephone)
                ->setType_maison($row->type_maison)
                ->setSituation($row->situation)
                ->setLibelle_situation($row->libelle_situation)
                ->setRue($row->rue)
                ->setCivilite_representant($row->civilite_representant)
                ->setNom_representant($row->nom_representant)
                ->setCarte_operateur($row->carte_operateur)
                ->setNumero_recipice($row->numero_recipice)
                ->setSiege($row->siege)
                ->setMatricule_rccm($row->matricule_rccm)
                ->setPeriode_garde($row->periode_garde)
                ->setChargement_produit($row->chargement_produit)
                ->setDate_contrat($row->date_contrat)
                ->setStatut($row->statut)
				;
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
                ->setType_validateur($row->type_validateur)
                ->setCivilite($row->civilite)
                ->setNom($row->nom)
                ->setDemeure($row->demeure)
                ->setLibelle_demeure($row->libelle_demeure)
                ->setQuartier($row->quartier)
                ->setQuartier_maison($row->quartier_maison)
                ->setBoite_postale($row->boite_postale)
                ->setTelephone($row->telephone)
                ->setType_maison($row->type_maison)
                ->setSituation($row->situation)
                ->setLibelle_situation($row->libelle_situation)
                ->setRue($row->rue)
                ->setCivilite_representant($row->civilite_representant)
                ->setNom_representant($row->nom_representant)
                ->setCarte_operateur($row->carte_operateur)
                ->setNumero_recipice($row->numero_recipice)
                ->setSiege($row->siege)
                ->setMatricule_rccm($row->matricule_rccm)
                ->setPeriode_garde($row->periode_garde)
                ->setChargement_produit($row->chargement_produit)
                ->setDate_contrat($row->date_contrat)
                ->setStatut($row->statut)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByCodeMembre1($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre = ? ", $code_membre);
        }
        $select->where("statut = ? ", 1);
        $select->order("id_contrat DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuContratLivraisonIrrevocable();
            $entry->setId_contrat($row->id_contrat)
                ->setCode_membre($row->code_membre)
                ->setNumero_contrat($row->numero_contrat)
                ->setType_validateur($row->type_validateur)
                ->setCivilite($row->civilite)
                ->setNom($row->nom)
                ->setDemeure($row->demeure)
                ->setLibelle_demeure($row->libelle_demeure)
                ->setQuartier($row->quartier)
                ->setQuartier_maison($row->quartier_maison)
                ->setBoite_postale($row->boite_postale)
                ->setTelephone($row->telephone)
                ->setType_maison($row->type_maison)
                ->setSituation($row->situation)
                ->setLibelle_situation($row->libelle_situation)
                ->setRue($row->rue)
                ->setCivilite_representant($row->civilite_representant)
                ->setNom_representant($row->nom_representant)
                ->setCarte_operateur($row->carte_operateur)
                ->setNumero_recipice($row->numero_recipice)
                ->setSiege($row->siege)
                ->setMatricule_rccm($row->matricule_rccm)
                ->setPeriode_garde($row->periode_garde)
                ->setChargement_produit($row->chargement_produit)
                ->setDate_contrat($row->date_contrat)
                ->setStatut($row->statut)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	

    
	
 
    
   

}


?>
