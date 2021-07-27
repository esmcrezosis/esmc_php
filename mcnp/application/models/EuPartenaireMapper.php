<?php

class Application_Model_EuPartenaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPartenaire');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuPartenaire $partenaire) {
        $data = array(
            'code_partenaire' => $partenaire->getCode_partenaire(),
            'type_partenaire' => $partenaire->getType_partenaire(),
            'nom_partenaire' => $partenaire->getNom_partenaire(),
            'tel_partenaire' => $partenaire->getTel_partenaire(),
            'bp_partenaire' => $partenaire->getBp_partenaire(),
            'fax_partenaire' => $partenaire->getFax_partenaire(),
            'email_partenaire' => $partenaire->getEmail_partenaire(),
            'interlocuteur' => $partenaire->getInterlocuteur(),
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPartenaire $partenaire) {
        $data = array(
            'code_partenaire' => $partenaire->getCode_partenaire(),
            'type_partenaire' => $partenaire->getType_partenaire(),
            'nom_partenaire' => $partenaire->getNom_partenaire(),
            'tel_partenaire' => $partenaire->getTel_partenaire(),
            'bp_partenaire' => $partenaire->getBp_partenaire(),
            'fax_partenaire' => $partenaire->getFax_partenaire(),
            'email_partenaire' => $partenaire->getEmail_partenaire(),
            'interlocuteur' => $partenaire->getInterlocuteur(),
        );

        $this->getDbTable()->update($data, array('code_partenaire = ?' => $partenaire->getCode_partenaire()));
    }

    public function find($code_partenaire, Application_Model_EuPartenaire $partenaire) {
        $result = $this->getDbTable()->find($code_partenaire);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $partenaire->setCode_partenaire($row->code_partenaire)
                ->setType_partenaire($row->type_partenaire)
                ->setNom_partenaire($row->nom_partenaire)
                ->setTel_partenaire($row->tel_partenaire)
                ->setBp_partenaire($row->bp_partenaire)
                ->setFax_partenaire($row->fax_partenaire)
                ->setEmail_partenaire($row->email_partenaire)
                ->setInterlocuteur($row->interlocuteur);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartenaire();
            $entry->setCode_partenaire($row->code_partenaire)
                    ->setType_partenaire($row->type_partenaire)
                    ->setNom_partenaire($row->nom_partenaire)
                    ->setTel_partenaire($row->tel_partenaire)
                    ->setBp_partenaire($row->bp_partenaire)
                    ->setFax_partenaire($row->fax_partenaire)
                    ->setEmail_partenaire($row->email_partenaire)
                    ->setInterlocuteur($row->interlocuteur);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_partenaire) {
        $this->getDbTable()->delete(array('code_partenaire = ?' => $code_partenaire));
    }

    
    public function fetchAllByOne()
    {
        $select = $this->getDbTable()->select();
    $select->where("statut = ? ", 1);
    $select->order(array("RAND()"));
    $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPartenaire();
            $entry->setId_partenaire($row->id_partenaire)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
          ->setDate_creation($row->date_creation);
      $entries = $entry;
        return $entries;
    }



  
    
    public function fetchAllByHome($limit) {
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        $select->order("rand()");
        $select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartenaire();
            $entry->setId_partenaire($row->id_partenaire)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
          ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByAll() {
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        //$select->order("rand()");
        //$select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartenaire();
            $entry->setId_partenaire($row->id_partenaire)
                  ->setTitre($row->titre)
                  ->setResume($row->resume)
                  ->setDescription($row->description)
                  ->setVignette($row->vignette)
                  ->setStatut($row->statut)
                  ->setLiendirect($row->liendirect)
          ->setDate_creation($row->date_creation);
            $entries[] = $entry;
        }
        return $entries;
    }

}

