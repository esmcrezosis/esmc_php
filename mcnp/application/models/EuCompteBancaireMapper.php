<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCompteBancaireMapper
 *
 * @author user
 */
class Application_Model_EuCompteBancaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCompteBancaire');
        }
        return $this->_dbTable;
    }

    public function find($id_compte, Application_Model_EuCompteBancaire $compte) {
        $result = $this->getDbTable()->find($id_compte);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $compte->setId_compte($row->id_compte)
                ->setCode_banque($row->code_banque)
                ->setCode_membre($row->code_membre)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
				;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteBancaire();
            $entry->setId_compte($row->id_compte)
                ->setCode_banque($row->code_banque)
                ->setCode_membre($row->code_membre)
				->setCode_membre_morale($row->code_membre_morale)
                ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_compte) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
    public function save(Application_Model_EuCompteBancaire $compte) {
        $data = array(
        'id_compte' => $compte->getId_compte(),
        'code_banque' => $compte->getCode_banque(),
        'code_membre' => $compte->getCode_membre(),
		'code_membre_morale' => $compte->getCode_membre_morale(),
        'principal' => $compte->getPrincipal(),
        'num_compte_bancaire' => $compte->getNum_compte_bancaire()   
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCompteBancaire $compte) {
        $data = array(
        'id_compte' => $compte->getId_compte(),
        'code_banque' => $compte->getCode_banque(),
        'code_membre' => $compte->getCode_membre(),
		'code_membre_morale' => $compte->getCode_membre_morale(),
        'principal' => $compte->getPrincipal(),
        'num_compte_bancaire' => $compte->getNum_compte_bancaire()
        );

        $this->getDbTable()->update($data, array('id_compte = ?' => $compte->getId_compte()));
    }

    public function delete($id_compte) {
           $this->getDbTable()->delete(array('id_compte = ?' => $id_compte));
    }




    
    public function fetchAllByMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre = ?', $code_membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteBancaire();
            $entry->setId_compte($row->id_compte)
                  ->setCode_banque($row->code_banque)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    
    public function fetchAllByMembreMorale($code_membre_morale) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_morale = ?', $code_membre_morale);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteBancaire();
            $entry->setId_compte($row->id_compte)
                  ->setCode_banque($row->code_banque)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
    




    public function fetchAllByAutre($id_compte = 0, $code_membre = "") {
        $select = $this->getDbTable()->select();
        $select->where("id_compte != ? ", $id_compte); 
        if($code_membre != ""){
            if (substr($code_membre, -1) == "P") {
        $select->where("code_membre = ? ", $code_membre); 
            }else{
        $select->where("code_membre_morale = ? ", $code_membre); 
            }
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteBancaire();
            $entry->setId_compte($row->id_compte)
                  ->setCode_banque($row->code_banque)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findByCodeMembrePrincipal($code_membre = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
            if (substr($code_membre, -1) == "P") {
        $select->where("code_membre = ? ", $code_membre); 
            }else{
        $select->where("code_membre_morale = ? ", $code_membre); 
            }
        }
        $select->where("principal = ? ", 1); 
        $select->order(array("id_compte DESC"));
        $select->limit(1);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $row = $result->current();
        $entry = new Application_Model_EuCompteBancaire();
            $entry->setId_compte($row->id_compte)
                  ->setCode_banque($row->code_banque)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
                  ;
        return $entry;
    }


    public function fetchAllByMembre2($code_membre) {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
            if (substr($code_membre, -1) == "P") {
        $select->where("code_membre = ? ", $code_membre); 
            }else{
        $select->where("code_membre_morale = ? ", $code_membre); 
            }
        }
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuCompteBancaire();
            $entry->setId_compte($row->id_compte)
                  ->setCode_banque($row->code_banque)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }


    
    public function findByCodeMembreBanqueNum($code_membre = "", $code_banque = "", $num_compte_bancaire = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
            if (substr($code_membre, -1) == "P") {
        $select->where("code_membre = ? ", $code_membre); 
            }else{
        $select->where("code_membre_morale = ? ", $code_membre); 
            }
        }
        if($code_banque != ""){
        $select->where("code_banque = ? ", $code_banque); 
        }
        if($num_compte_bancaire != ""){
        $select->where("num_compte_bancaire = ? ", $num_compte_bancaire); 
        }
        $select->order(array("id_compte DESC"));
        $select->limit(1);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $row = $result->current();
        $entry = new Application_Model_EuCompteBancaire();
            $entry->setId_compte($row->id_compte)
                  ->setCode_banque($row->code_banque)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
                  ;
        return $entry;
    }


    
    public function findByBanqueNum($code_banque = "", $num_compte_bancaire = "") {
        $select = $this->getDbTable()->select();
        if($code_banque != ""){
        $select->where("code_banque = ? ", $code_banque); 
        }
        if($num_compte_bancaire != ""){
        $select->where("num_compte_bancaire = ? ", $num_compte_bancaire); 
        }
        $select->order(array("id_compte DESC"));
        $select->limit(1);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $row = $result->current();
        $entry = new Application_Model_EuCompteBancaire();
            $entry->setId_compte($row->id_compte)
                  ->setCode_banque($row->code_banque)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setNum_compte_bancaire($row->num_compte_bancaire)
                ->setPrincipal($row->principal)
                  ;
        return $entry;
    }

}

?>
