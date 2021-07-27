<?php
 
class Application_Model_EuPostulatMapper {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if(is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if(!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if(NULL === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuPostulat');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_postulat, Application_Model_EuPostulat $postulat) {
        $result = $this->getDbTable()->find($id_postulat);
        if(count($result) == 0)  {
           return false;
        }
        $row = $result->current();
        $postulat->setId_postulat($row->id_postulat)
                 ->setCode_membre($row->code_membre)
                 ->setId_type_candidat($row->id_type_candidat)
                 ->setDate_postulat($row->date_postulat)
                 ->setNom_postulat($row->nom_postulat)
		 ->setPrenom_postulat($row->prenom_postulat)
		 ->setRaison_postulat($row->raison_postulat)
		 ->setCode_zone($row->code_zone)
		 ->setId_pays($row->id_pays)
		 ->setId_region($row->id_region)
		 ->setId_prefecture($row->id_prefecture)
		 ->setId_canton($row->id_canton)
		 ->setTraiter($row->traiter)
		 ->setCode_postulat($row->code_postulat)
		 ->setEmail_postulat($row->email_postulat)
		 ->setMobile_postulat($row->mobile_postulat)
                 ->setUtilisateur($row->utilisateur);
        return true;
    }
	
    public function fetchAllByCode($code_postulat)  {
        $select = $this->getDbTable()->select();
	$select->where("code_postulat = ? ", $code_postulat);
	$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if(0 == count($result)) {
           return;
        }
        $row = $result;
        $entry = new Application_Model_EuPostulat();
        $entry->setId_postulat($row->id_postulat)
              ->setCode_membre($row->code_membre)
              ->setId_type_candidat($row->id_type_candidat)
              ->setDate_postulat($row->date_postulat)
              ->setNom_postulat($row->nom_postulat)
              ->setPrenom_postulat($row->prenom_postulat)
	      ->setRaison_postulat($row->raison_postulat)
	      ->setCode_zone($row->code_zone)
	      ->setId_pays($row->id_pays)
	      ->setId_region($row->id_region)
	      ->setId_prefecture($row->id_prefecture)
	      ->setId_canton($row->id_canton)
	      ->setTraiter($row->traiter)
	      ->setCode_postulat($row->code_postulat)
	      ->setEmail_postulat($row->email_postulat)
	      ->setMobile_postulat($row->mobile_postulat)
              ->setUtilisateur($row->utilisateur);
	$entries = $entry;
        return $entries;
    }

    

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPostulat();
            $entry->setId_postulat($row->id_postulat)
                  ->setCode_membre($row->code_membre)
                  ->setId_type_candidat($row->id_type_candidat)
                  ->setDate_postulat($row->date_postulat)
                  ->setNom_postulat($row->nom_postulat)
		  ->setPrenom_postulat($row->prenom_postulat)
		  ->setRaison_postulat($row->raison_postulat)
		  ->setCode_zone($row->code_zone)
		  ->setId_pays($row->id_pays)
		  ->setId_region($row->id_region)
		  ->setId_prefecture($row->id_prefecture)
		  ->setId_canton($row->id_canton)
		  ->setTraiter($row->traiter)
		  ->setCode_postulat($row->code_postulat)
		  ->setEmail_postulat($row->email_postulat)
		  ->setMobile_postulat($row->mobile_postulat)
                  ->setUtilisateur($row->utilisateur);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_postulat) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuPostulat $postulat) {    
        $data = array(
          'id_postulat' => $postulat->getId_postulat(),
          'code_membre' => $postulat->getCode_membre(),
          'id_type_candidat' => $postulat->getId_type_candidat(),
          'date_postulat' => $postulat->getDate_postulat(),
          'nom_postulat' => $postulat->getNom_postulat(),
	  'prenom_postulat' => $postulat->getPrenom_postulat(),
	  'raison_postulat' => $postulat->getRaison_postulat(), 
	  'code_zone' => $postulat->getCode_zone(),
	  'id_pays' => $postulat->getId_pays(),
	  'id_region' => $postulat->getId_region(),
	  'id_prefecture' => $postulat->getId_prefecture(),
	  'id_canton' => $postulat->getId_canton(),
	  'traiter' => $postulat->getTraiter(),
	  'code_postulat' => $postulat->getCode_postulat(),
	  'email_postulat' => $postulat->getEmail_postulat(),
	  'mobile_postulat' => $postulat->getMobile_postulat(),
          'utilisateur' => $postulat->getUtilisateur()	
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPostulat $postulat) {
        $data = array(
          'id_postulat' => $postulat->getId_postulat(),
          'code_membre' => $postulat->getCode_membre(),
          'id_type_candidat' => $postulat->getId_type_candidat(),
          'date_postulat' => $postulat->getDate_postulat(),
          'nom_postulat' => $postulat->getNom_postulat(),
	  'prenom_postulat' => $postulat->getPrenom_postulat(),
	  'raison_postulat' => $postulat->getRaison_postulat(), 
	  'code_zone' => $postulat->getCode_zone(),
	  'id_pays' => $postulat->getId_pays(),
	  'id_region' => $postulat->getId_region(),
	  'id_prefecture' => $postulat->getId_prefecture(),
	  'id_canton' => $postulat->getId_canton(),
	  'traiter' => $postulat->getTraiter(),
	  'code_postulat' => $postulat->getCode_postulat(),
	  'email_postulat' => $postulat->getEmail_postulat(),
	  'mobile_postulat' => $postulat->getMobile_postulat(),
          'utilisateur' => $postulat->getUtilisateur()
        );
        $this->getDbTable()->update($data, array('id_postulat = ?' => $postulat->getId_postulat()));
    }

	
    public function delete($id_postulat) {
        $this->getDbTable()->delete(array('id_postulat = ?' => $id_postulat));
    }




}


?>
