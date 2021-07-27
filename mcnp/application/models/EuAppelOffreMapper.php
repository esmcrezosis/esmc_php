<?php

class Application_Model_EuAppelOffreMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAppelOffre');
        }
        return $this->_dbTable;
    }

    public function find($id_appel_offre, Application_Model_EuAppelOffre $appel_offre) {
        $result = $this->getDbTable()->find($id_appel_offre);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $appel_offre->setId_appel_offre($row->id_appel_offre)
                ->setNumero_offre($row->numero_offre)
                ->setNom_appel_offre($row->nom_appel_offre)
                ->setDescrip_appel_offre($row->descrip_appel_offre)
                ->setType_appel_offre($row->type_appel_offre)
                ->setDate_creation($row->date_creation)
                ->setDuree_projet($row->duree_projet)
                ->setPublier($row->publier)
                ->setId_demande($row->id_demande)
                ->setId_utilisateur($row->id_utilisateur)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setMembre_morale_executante($row->membre_morale_executante);
    }
	
	
	public function findByAppelOffre($id_appel_offre, Application_Model_EuAppelOffre $appel_offre) {
        $select = $this->getDbTable()->select();
        $select->where('numero_appel = ?', $id_appel_offre);
        $result = $this->getDbTable->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $appel_offre->setId_appel_offre($row->id_appel_offre)
                ->setNumero_offre($row->numero_offre)
                ->setNom_appel_offre($row->nom_appel_offre)
                ->setDescrip_appel_offre($row->descrip_appel_offre)
                ->setType_appel_offre($row->type_appel_offre)
                ->setDate_creation($row->date_creation)
                ->setDuree_projet($row->duree_projet)
                ->setPublier($row->publier)
                ->setId_demande($row->id_demande)
                ->setId_utilisateur($row->id_utilisateur)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setMembre_morale_executante($row->membre_morale_executante);
        return true;
    }
	
	
	
	
	
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
	                ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_appel_offre) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuAppelOffre $appel_offre) {
        $data = array(
            'id_appel_offre' => $appel_offre->getId_appel_offre(),
            'numero_offre' => $appel_offre->getNumero_offre(),
            'nom_appel_offre' => $appel_offre->getNom_appel_offre(),
            'descrip_appel_offre' => $appel_offre->getDescrip_appel_offre(),
            'type_appel_offre' => $appel_offre->getType_appel_offre(),
            'date_creation' => $appel_offre->getDate_creation(),
            'duree_projet' => $appel_offre->getDuree_projet(),
            'publier' => $appel_offre->getPublier(),
            'id_demande' => $appel_offre->getId_demande(),
            'code_membre_morale' => $appel_offre->getCode_membre_morale(),
            'id_utilisateur' => $appel_offre->getId_utilisateur(),
            'membre_morale_executante' => $appel_offre->getMembre_morale_executante()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAppelOffre $appel_offre) {
        $data = array(
            'numero_offre' => $appel_offre->getNumero_offre(),
            'nom_appel_offre' => $appel_offre->getNom_appel_offre(),
            'descrip_appel_offre' => $appel_offre->getDescrip_appel_offre(),
            'type_appel_offre' => $appel_offre->getType_appel_offre(),
            'date_creation' => $appel_offre->getDate_creation(),
            'duree_projet' => $appel_offre->getDuree_projet(),
            'publier' => $appel_offre->getPublier(),
            'id_demande' => $appel_offre->getId_demande(),
            'code_membre_morale' => $appel_offre->getCode_membre_morale(),
            'id_utilisateur' => $appel_offre->getId_utilisateur(),
            'membre_morale_executante' => $appel_offre->getMembre_morale_executante()
        );
        $this->getDbTable()->update($data, array('id_appel_offre = ?' => $appel_offre->getId_appel_offre()));
    }

    public function delete($id_appel_offre) {
        $this->getDbTable()->delete(array('id_appel_offre = ?' => $id_appel_offre));
    }


    public function fetchAll2($id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
                    ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
	                ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll3() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
	                ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByNumero($numero_offre) {
        $select = $this->getDbTable()->select();
		$select->where("numero_offre = ? ", $numero_offre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
                    ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
	                ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAll5($id_filiere) {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_appel_offre.code_membre_morale');
		$select->where('eu_membre_morale.id_filiere = ? ', $id_filiere);
		$select->where("eu_appel_offre.publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
                    ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
	                ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll6($id_filiere) {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_appel_offre.code_membre_morale');
		$select->where('eu_membre_morale.id_filiere = ? ', $id_filiere);
		//$select->where("eu_appel_offre.publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
                    ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
	                ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function findByDemande($id_demande) {
        $select = $this->getDbTable()->select();
        $select->where('id_demande = ?', $id_demande);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
                    ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
	                ->setId_utilisateur($row->id_utilisateur)
                	->setMembre_morale_executante($row->membre_morale_executante);
        return $entry;
    }





    public function fetchAll7($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_appel_offre.id_utilisateur');
		$select->join('eu_acteur', 'eu_acteur.code_acteur = eu_utilisateur.code_acteur');

		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}
		
		//$select->where("eu_appel_offre.publier = ? ", 1);
		$select->order(array("eu_appel_offre.date_creation DESC"));

        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
                    ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
	                ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll8($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "", $id_filiere) {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->where('eu_appel_offre.code_membre_morale = ? ', $code_membre);
		//$select->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_appel_offre.code_membre_morale');
		//$select->join('eu_tete_division', 'eu_tete_division.code_membre = eu_appel_offre.code_membre_morale');
		//$select->join('eu_utilisateur', 'eu_utilisateur.code_membre = eu_tete_division.code_membre');
		//$select->where('eu_tete_division.id_filiere = ? ', $id_filiere);

		/*if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}*/
		
		$select->where("eu_appel_offre.publier = ? ", 1);
		$select->order(array("eu_appel_offre.date_creation DESC"));

        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
                    ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
	                ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll9($code_source_create = "", $code_monde_create = "", $code_zone_create = "", $id_pays = 0, $id_region = 0, $code_secteur_create = "", $code_agence_create = "", $code_membre = "") {
        //$select = $this->getDbTable()->select();
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
		$select->where('eu_appel_offre.code_membre_morale = ? ', $code_membre);
		//$select->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_appel_offre.code_membre_morale');
		//$select->join('eu_tete_division', 'eu_tete_division.code_membre = eu_appel_offre.code_membre_morale');
		//$select->join('eu_utilisateur', 'eu_utilisateur.code_membre = eu_tete_division.code_membre');
		//$select->where('eu_tete_division.id_filiere = ? ', $id_filiere);

		if($code_source_create != ""){
		$select->where("eu_acteur.code_source_create = ? ", $code_source_create);}
		
		if($code_monde_create != ""){
		$select->where("eu_acteur.code_monde_create = ? ", $code_monde_create);}
		
		if($code_zone_create != ""){
		$select->where("eu_acteur.code_zone_create = ? ", $code_zone_create);}
		
		if($id_pays > 0){
		$select->where("eu_acteur.id_pays = ? ", $id_pays);}
		
		if($id_region > 0){
		$select->where("eu_acteur.id_region = ? ", $id_region);}
		
		if($code_secteur_create != ""){
		$select->where("eu_acteur.code_secteur_create = ? ", $code_secteur_create);}
		
		if($code_agence_create != ""){
		$select->where("eu_acteur.code_agence_create = ? ", $code_agence_create);}
		
		$select->where("eu_appel_offre.publier = ? ", 1);
		$select->order(array("eu_appel_offre.date_creation DESC"));

        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppelOffre();
            $entry->setId_appel_offre($row->id_appel_offre)
	                ->setNumero_offre($row->numero_offre)
                    ->setNom_appel_offre($row->nom_appel_offre)
                    ->setDescrip_appel_offre($row->descrip_appel_offre)
	                ->setType_appel_offre($row->type_appel_offre)
                    ->setDate_creation($row->date_creation)
                    ->setDuree_projet($row->duree_projet)
                	->setPublier($row->publier)
	                ->setId_demande($row->id_demande)
                    ->setCode_membre_morale($row->code_membre_morale)
	                ->setId_utilisateur($row->id_utilisateur)
                ->setMembre_morale_executante($row->membre_morale_executante);
            $entries[] = $entry;
        }
        return $entries;

    }
	
}


?>
