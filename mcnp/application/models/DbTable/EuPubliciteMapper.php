<?php

class Application_Model_EuPubliciteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPublicite');
        }
        return $this->_dbTable;
    }

    public function find($id_publicite, Application_Model_EuPublicite $publicite) {
        $result = $this->getDbTable()->find($id_publicite);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $publicite->setId_publicite($row->id_publicite)
                ->setType_publicite($row->type_publicite)
                ->setLien_publicite($row->lien_publicite)
                ->setLibelle_publicite($row->libelle_publicite)
                ->setDesc_publicite($row->desc_publicite)
                ->setDate_publicite($row->date_publicite)
                ->setDuree_publicite($row->duree_publicite)
                ->setInterface_publicite($row->interface_publicite)
                ->setCategorie_publicite($row->categorie_publicite)
                ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPublicite();
            $entry->setId_publicite($row->id_publicite)
	                ->setType_publicite($row->type_publicite)
                    ->setLien_publicite($row->lien_publicite)
					->setLibelle_publicite($row->libelle_publicite)
                    ->setDesc_publicite($row->desc_publicite)
                    ->setDate_publicite($row->date_publicite)
					->setDuree_publicite($row->duree_publicite)
                	->setInterface_publicite($row->interface_publicite)
					->setCategorie_publicite($row->categorie_publicite)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_publicite) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuPublicite $publicite) {
        $data = array(
            'id_publicite' => $publicite->getId_publicite(),
            'type_publicite' => $publicite->getType_publicite(),
            'lien_publicite' => $publicite->getLien_publicite(),
            'libelle_publicite' => $publicite->getLibelle_publicite(),
            'desc_publicite' => $publicite->getDesc_publicite(),
            'date_publicite' => $publicite->getDate_publicite(),
            'duree_publicite' => $publicite->getDuree_publicite(),
            'interface_publicite' => $publicite->getInterface_publicite(),
            'categorie_publicite' => $publicite->getCategorie_publicite(),
            'id_utilisateur' => $publicite->getId_utilisateur(),
            'box_publicite' => $publicite->getBox_publicite(),
            'status' => $publicite->getStatus()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPublicite $publicite) {
        $data = array(
            'id_publicite' => $publicite->getId_publicite(),
            'type_publicite' => $publicite->getType_publicite(),
            'lien_publicite' => $publicite->getLien_publicite(),
            'libelle_publicite' => $publicite->getLibelle_publicite(),
            'desc_publicite' => $publicite->getDesc_publicite(),
            'date_publicite' => $publicite->getDate_publicite(),
            'duree_publicite' => $publicite->getDuree_publicite(),
            'interface_publicite' => $publicite->getInterface_publicite(),
            'categorie_publicite' => $publicite->getCategorie_publicite(),
            'id_utilisateur' => $publicite->getId_utilisateur(),
            'box_publicite' => $publicite->getBox_publicite(),
            'status' => $publicite->getStatus()
        );
        $this->getDbTable()->update($data, array('id_publicite = ?' => $publicite->getId_publicite()));
    }

    public function delete($id_publicite) {
        $this->getDbTable()->delete(array('id_publicite = ?' => $id_publicite));
    }


    public function fetchAll2($id_utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("id_utilisateur = ? ", $id_utilisateur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPublicite();
            $entry->setId_publicite($row->id_publicite)
	                ->setType_publicite($row->type_publicite)
                    ->setLien_publicite($row->lien_publicite)
					->setLibelle_publicite($row->libelle_publicite)
                    ->setDesc_publicite($row->desc_publicite)
                    ->setDate_publicite($row->date_publicite)
					->setDuree_publicite($row->duree_publicite)
                	->setInterface_publicite($row->interface_publicite)
					->setCategorie_publicite($row->categorie_publicite)
	                ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAll3($interface_publicite) {
        $select = $this->getDbTable()->select();
		$select->where("interface_publicite = ? ", $interface_publicite);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPublicite();
            $entry->setId_publicite($row->id_publicite)
	                ->setType_publicite($row->type_publicite)
                    ->setLien_publicite($row->lien_publicite)
					->setLibelle_publicite($row->libelle_publicite)
                    ->setDesc_publicite($row->desc_publicite)
                    ->setDate_publicite($row->date_publicite)
					->setDuree_publicite($row->duree_publicite)
                	->setInterface_publicite($row->interface_publicite)
					->setCategorie_publicite($row->categorie_publicite)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll4($type_publicite) {
        $select = $this->getDbTable()->select();
		$select->where("type_publicite = ? ", $type_publicite);
		//$select->order("rand()");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPublicite();
            $entry->setId_publicite($row->id_publicite)
	                ->setType_publicite($row->type_publicite)
                    ->setLien_publicite($row->lien_publicite)
					->setLibelle_publicite($row->libelle_publicite)
                    ->setDesc_publicite($row->desc_publicite)
                    ->setDate_publicite($row->date_publicite)
					->setDuree_publicite($row->duree_publicite)
                	->setInterface_publicite($row->interface_publicite)
					->setCategorie_publicite($row->categorie_publicite)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll5($type_publicite, $categorie_publicite) {
        $select = $this->getDbTable()->select();
		$select->where("type_publicite = ? ", $type_publicite);
		$select->where("categorie_publicite = ? ", $categorie_publicite);
		//$select->order("rand()");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPublicite();
            $entry->setId_publicite($row->id_publicite)
	                ->setType_publicite($row->type_publicite)
                    ->setLien_publicite($row->lien_publicite)
					->setLibelle_publicite($row->libelle_publicite)
                    ->setDesc_publicite($row->desc_publicite)
                    ->setDate_publicite($row->date_publicite)
					->setDuree_publicite($row->duree_publicite)
                	->setInterface_publicite($row->interface_publicite)
					->setCategorie_publicite($row->categorie_publicite)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
            $entries[] = $entry;
        }
        return $entries;
    }


    
    public function fetchAllByTypeCategorieBoxInterface($type_publicite = 0, $categorie_publicite = 0, $box_publicite = 0, $interface_publicite = 0) {
        $select = $this->getDbTable()->select();
        if($type_publicite > 0){
        $select->where("type_publicite = ? ", $type_publicite);            
        }
        if($categorie_publicite > 0){
        $select->where("categorie_publicite = ? ", $categorie_publicite);
        }
        if($box_publicite > 0){
        $select->where("box_publicite = ? ", $box_publicite);            
        }
        if($interface_publicite > 0){
        $select->where("interface_publicite = ? ", $interface_publicite);
        }
        $select->where("status = ? ", 1);
        $select->order(array('id_publicite DESC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPublicite();
            $entry->setId_publicite($row->id_publicite)
                    ->setType_publicite($row->type_publicite)
                    ->setLien_publicite($row->lien_publicite)
                    ->setLibelle_publicite($row->libelle_publicite)
                    ->setDesc_publicite($row->desc_publicite)
                    ->setDate_publicite($row->date_publicite)
                    ->setDuree_publicite($row->duree_publicite)
                    ->setInterface_publicite($row->interface_publicite)
                    ->setCategorie_publicite($row->categorie_publicite)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
            $entries[] = $entry;
        }
        return $entries;
    }

	
    
    public function fetchAllByTypeCategorieBoxInterfaceMenu($type_publicite = 0, $categorie_publicite = 0, $box_publicite = 0, $interface_publicite = 0, $limit = 0) {
        $select = $this->getDbTable()->select();
        if($type_publicite > 0){
        $select->where("type_publicite = ? ", $type_publicite);            
        }
        if($categorie_publicite > 0){
        $select->where("categorie_publicite = ? ", $categorie_publicite);
        }
        if($box_publicite > 0){
        $select->where("box_publicite = ? ", $box_publicite);            
        }
        if($interface_publicite > 0){
        $select->where("interface_publicite = ? ", $interface_publicite);
        }
        $select->where("status = ? ", 1);
        if($limit == 0){
        $select->where("1 != 1");
        }
        $select->order("rand()");
        $select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPublicite();
            $entry->setId_publicite($row->id_publicite)
                    ->setType_publicite($row->type_publicite)
                    ->setLien_publicite($row->lien_publicite)
                    ->setLibelle_publicite($row->libelle_publicite)
                    ->setDesc_publicite($row->desc_publicite)
                    ->setDate_publicite($row->date_publicite)
                    ->setDuree_publicite($row->duree_publicite)
                    ->setInterface_publicite($row->interface_publicite)
                    ->setCategorie_publicite($row->categorie_publicite)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByTypeCategorieBoxInterfaceOne($type_publicite = 0, $categorie_publicite = 0, $box_publicite = 0, $interface_publicite = 0) {
        $select = $this->getDbTable()->select();
        if($type_publicite > 0){
        $select->where("type_publicite = ? ", $type_publicite);            
        }
        if($categorie_publicite > 0){
        $select->where("categorie_publicite = ? ", $categorie_publicite);
        }
        if($box_publicite > 0){
        $select->where("box_publicite = ? ", $box_publicite);            
        }
        if($interface_publicite > 0){
        $select->where("interface_publicite = ? ", $interface_publicite);
        }
        $select->where("status = ? ", 1);
        $select->order(array('id_publicite DESC'));
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPublicite();
            $entry->setId_publicite($row->id_publicite)
                    ->setType_publicite($row->type_publicite)
                    ->setLien_publicite($row->lien_publicite)
                    ->setLibelle_publicite($row->libelle_publicite)
                    ->setDesc_publicite($row->desc_publicite)
                    ->setDate_publicite($row->date_publicite)
                    ->setDuree_publicite($row->duree_publicite)
                    ->setInterface_publicite($row->interface_publicite)
                    ->setCategorie_publicite($row->categorie_publicite)
                    ->setId_utilisateur($row->id_utilisateur)
                ->setBox_publicite($row->box_publicite)
                ->setStatus($row->status)
              ;
      $entries = $entry;
        return $entries;
    }






}


?>
