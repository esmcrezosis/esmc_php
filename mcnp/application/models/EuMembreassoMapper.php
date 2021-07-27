<?php
 
class Application_Model_EuMembreassoMapper {

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
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuMembreasso');
        }
        return $this->_dbTable;
    }

    public function find($membreasso_id, Application_Model_EuMembreasso $membreasso) {
        $result = $this->getDbTable()->find($membreasso_id);
        if (count($result) == 0) {
            return FALSE;
        }
        $row = $result->current();
        $membreasso->setMembreasso_id($row->membreasso_id)
                ->setMembreasso_nom($row->membreasso_nom)
                ->setMembreasso_prenom($row->membreasso_prenom)
                ->setMembreasso_mobile($row->membreasso_mobile)
                ->setMembreasso_association($row->membreasso_association)
                ->setMembreasso_email($row->membreasso_email)
                ->setMembreasso_login($row->membreasso_login)
                ->setMembreasso_passe($row->membreasso_passe)
                ->setMembreasso_type($row->membreasso_type)
                ->setMembreasso_date($row->membreasso_date)
                ->setLocal($row->local)
                ->setSouscription_id($row->souscription_id)
                ->setCode_membre($row->code_membre)
                ->setAppro($row->appro)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreasso();
            $entry->setMembreasso_id($row->membreasso_id)
                    ->setMembreasso_nom($row->membreasso_nom)
                    ->setMembreasso_prenom($row->membreasso_prenom)
                ->setMembreasso_mobile($row->membreasso_mobile)
                ->setMembreasso_association($row->membreasso_association)
                ->setMembreasso_email($row->membreasso_email)
                ->setMembreasso_login($row->membreasso_login)
                ->setMembreasso_passe($row->membreasso_passe)
                ->setMembreasso_type($row->membreasso_type)
                ->setMembreasso_date($row->membreasso_date)
                ->setLocal($row->local)
                ->setSouscription_id($row->souscription_id)
                ->setCode_membre($row->code_membre)
                ->setAppro($row->appro)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(membreasso_id) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function save(Application_Model_EuMembreasso $membreasso) {
        $data = array(
            'membreasso_id' => $membreasso->getMembreasso_id(),
            'membreasso_nom' => $membreasso->getMembreasso_nom(),
            'membreasso_prenom' => $membreasso->getMembreasso_prenom(),
            'membreasso_mobile' => $membreasso->getMembreasso_mobile(),
            'membreasso_association' => $membreasso->getMembreasso_association(),
            'membreasso_email' => $membreasso->getMembreasso_email(),
            'membreasso_login' => $membreasso->getMembreasso_login(),
            'membreasso_passe' => $membreasso->getMembreasso_passe(),
            'membreasso_type' => $membreasso->getMembreasso_type(),
            'membreasso_date' => $membreasso->getMembreasso_date(),
            'local' => $membreasso->getLocal(),
            'souscription_id' => $membreasso->getSouscription_id(),
            'code_membre' => $membreasso->getCode_membre(),
            'appro' => $membreasso->getAppro(),
            'publier' => $membreasso->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuMembreasso $membreasso) {
        $data = array(
            'membreasso_nom' => $membreasso->getMembreasso_nom(),
            'membreasso_prenom' => $membreasso->getMembreasso_prenom(),
            'membreasso_mobile' => $membreasso->getMembreasso_mobile(),
            'membreasso_association' => $membreasso->getMembreasso_association(),
            'membreasso_email' => $membreasso->getMembreasso_email(),
            'membreasso_login' => $membreasso->getMembreasso_login(),
            'membreasso_passe' => $membreasso->getMembreasso_passe(),
            'membreasso_type' => $membreasso->getMembreasso_type(),
            'membreasso_date' => $membreasso->getMembreasso_date(),
            'local' => $membreasso->getLocal(),
            'souscription_id' => $membreasso->getSouscription_id(),
            'code_membre' => $membreasso->getCode_membre(),
            'appro' => $membreasso->getAppro(),
            'publier' => $membreasso->getPublier()
        );
        $this->getDbTable()->update($data, array('membreasso_id = ?' => $membreasso->getMembreasso_id()));
    }

    public function delete($membreasso_id) {
        $this->getDbTable()->delete(array('membreasso_id = ?' => $membreasso_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
        $select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreasso();
            $entry->setMembreasso_id($row->membreasso_id)
                    ->setMembreasso_nom($row->membreasso_nom)
                    ->setMembreasso_prenom($row->membreasso_prenom)
                ->setMembreasso_mobile($row->membreasso_mobile)
                ->setMembreasso_association($row->membreasso_association)
                ->setMembreasso_email($row->membreasso_email)
                ->setMembreasso_login($row->membreasso_login)
                ->setMembreasso_passe($row->membreasso_passe)
                ->setMembreasso_type($row->membreasso_type)
                ->setMembreasso_date($row->membreasso_date)
                ->setLocal($row->local)
                ->setSouscription_id($row->souscription_id)
                ->setCode_membre($row->code_membre)
                ->setAppro($row->appro)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByMembreasso($membreasso_association) {
        $select = $this->getDbTable()->select();
        $select->where("membreasso_association = ? ", $membreasso_association);
        $select->order(array("membreasso_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreasso();
            $entry->setMembreasso_id($row->membreasso_id)
                    ->setMembreasso_nom($row->membreasso_nom)
                    ->setMembreasso_prenom($row->membreasso_prenom)
                ->setMembreasso_mobile($row->membreasso_mobile)
                ->setMembreasso_association($row->membreasso_association)
                ->setMembreasso_email($row->membreasso_email)
                ->setMembreasso_login($row->membreasso_login)
                ->setMembreasso_passe($row->membreasso_passe)
                ->setMembreasso_type($row->membreasso_type)
                ->setMembreasso_date($row->membreasso_date)
                ->setLocal($row->local)
                ->setSouscription_id($row->souscription_id)
                ->setCode_membre($row->code_membre)
                ->setAppro($row->appro)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByAssociation($membreasso_association) {
        $select = $this->getDbTable()->select();
        $select->where("membreasso_association = ? ", $membreasso_association);
        $select->where("membreasso_type = ? ", 1);
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuMembreasso();
            $entry->setMembreasso_id($row->membreasso_id)
                    ->setMembreasso_nom($row->membreasso_nom)
                    ->setMembreasso_prenom($row->membreasso_prenom)
                ->setMembreasso_mobile($row->membreasso_mobile)
                ->setMembreasso_association($row->membreasso_association)
                ->setMembreasso_email($row->membreasso_email)
                ->setMembreasso_login($row->membreasso_login)
                ->setMembreasso_passe($row->membreasso_passe)
                ->setMembreasso_type($row->membreasso_type)
                ->setMembreasso_date($row->membreasso_date)
                ->setLocal($row->local)
                ->setSouscription_id($row->souscription_id)
                ->setCode_membre($row->code_membre)
                ->setAppro($row->appro)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }



    public function fetchAllBySouscription($souscription_id) {
        $select = $this->getDbTable()->select();
        $select->where("souscription_id = ? ", $souscription_id);
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuMembreasso();
            $entry->setMembreasso_id($row->membreasso_id)
                    ->setMembreasso_nom($row->membreasso_nom)
                    ->setMembreasso_prenom($row->membreasso_prenom)
                ->setMembreasso_mobile($row->membreasso_mobile)
                ->setMembreasso_association($row->membreasso_association)
                ->setMembreasso_email($row->membreasso_email)
                ->setMembreasso_login($row->membreasso_login)
                ->setMembreasso_passe($row->membreasso_passe)
                ->setMembreasso_type($row->membreasso_type)
                ->setMembreasso_date($row->membreasso_date)
                ->setLocal($row->local)
                ->setSouscription_id($row->souscription_id)
                ->setCode_membre($row->code_membre)
                ->setAppro($row->appro)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }


    public function fetchAllByRechercheMembre($nom) {
        $select = $this->getDbTable()->select();
        $select->where("LOWER(REPLACE(CONCAT(membreasso_nom, membreasso_prenom), ' ', '')) = ? ", strtolower(str_replace(" ", "", $nom)));
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuMembreasso();
            $entry->setMembreasso_id($row->membreasso_id)
                    ->setMembreasso_nom($row->membreasso_nom)
                    ->setMembreasso_prenom($row->membreasso_prenom)
                ->setMembreasso_mobile($row->membreasso_mobile)
                ->setMembreasso_association($row->membreasso_association)
                ->setMembreasso_email($row->membreasso_email)
                ->setMembreasso_login($row->membreasso_login)
                ->setMembreasso_passe($row->membreasso_passe)
                ->setMembreasso_type($row->membreasso_type)
                ->setMembreasso_date($row->membreasso_date)
                ->setLocal($row->local)
                ->setSouscription_id($row->souscription_id)
                ->setCode_membre($row->code_membre)
                ->setAppro($row->appro)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }



    public function fetchAllByGuichet($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre LIKE '".$code_membre."' ");
        $select->where("membreasso_association IN (SELECT association_id FROM eu_association WHERE guichet = 1)");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuMembreasso();
            $entry->setMembreasso_id($row->membreasso_id)
                    ->setMembreasso_nom($row->membreasso_nom)
                    ->setMembreasso_prenom($row->membreasso_prenom)
                ->setMembreasso_mobile($row->membreasso_mobile)
                ->setMembreasso_association($row->membreasso_association)
                ->setMembreasso_email($row->membreasso_email)
                ->setMembreasso_login($row->membreasso_login)
                ->setMembreasso_passe($row->membreasso_passe)
                ->setMembreasso_type($row->membreasso_type)
                ->setMembreasso_date($row->membreasso_date)
                ->setLocal($row->local)
                ->setSouscription_id($row->souscription_id)
                ->setCode_membre($row->code_membre)
                ->setAppro($row->appro)
                    ->setPublier($row->publier);
            $entries = $entry;
        return $entries;
    }





}


?>
