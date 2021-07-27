<?php

class Application_Model_EuInformationAdditifMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuInformationAdditif');
        }
        return $this->_dbTable;
    }

    public function find($id_information_additif, Application_Model_EuInformationAdditif $information_additif) {
        $result = $this->getDbTable()->find($id_information_additif);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $information_additif->setId_information_additif($row->id_information_additif)
                ->setLibelle_information_additif($row->libelle_information_additif)
                ->setReference($row->reference)
                ->setCode_membre($row->code_membre)
                ->setMembreasso_id($row->membreasso_id)
                ->setEtat($row->etat)
				;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuInformationAdditif();
            $entry->setId_information_additif($row->id_information_additif)
                ->setLibelle_information_additif($row->libelle_information_additif)
	                ->setReference($row->reference)
                    ->setCode_membre($row->code_membre)
                ->setMembreasso_id($row->membreasso_id)
                ->setEtat($row->etat)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_information_additif) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuInformationAdditif $information_additif) {
        $data = array(
            'id_information_additif' => $information_additif->getId_information_additif(),
            'libelle_information_additif' => $information_additif->getLibelle_information_additif(),
            'reference' => $information_additif->getReference(),
            'code_membre' => $information_additif->getCode_membre(),
            'membreasso_id' => $information_additif->getMembreasso_id(),
            'etat' => $information_additif->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuInformationAdditif $information_additif) {
        $data = array(
            'id_information_additif' => $information_additif->getId_information_additif(),
            'libelle_information_additif' => $information_additif->getLibelle_information_additif(),
            'reference' => $information_additif->getReference(),
            'code_membre' => $information_additif->getCode_membre(),
            'membreasso_id' => $information_additif->getMembreasso_id(),
            'etat' => $information_additif->getEtat()
        );
        $this->getDbTable()->update($data, array('id_information_additif = ?' => $information_additif->getId_information_additif()));
    }

    public function delete($id_information_additif) {
        $this->getDbTable()->delete(array('id_information_additif = ?' => $id_information_additif));
    }


    public function fetchAllByCodeMembreReferenceMembreasso($code_membre = "", $reference = "", $membreasso_id = "", $etat = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
		$select->where("code_membre LIKE '".$code_membre."' ");
        }
        if($reference != ""){
        $select->where("reference LIKE '".$reference."' ");
        }
        if($membreasso_id != ""){
        $select->where("membreasso_id LIKE '".$membreasso_id."' ");
        }
        if($etat != ""){
        $select->where("etat = ? ", $etat);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuInformationAdditif();
            $entry->setId_information_additif($row->id_information_additif)
                ->setLibelle_information_additif($row->libelle_information_additif)
	                ->setReference($row->reference)
	                ->setCode_membre($row->code_membre)
                    ->setMembreasso_id($row->membreasso_id)
                    ->setEtat($row->etat)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
	


    public function fetchAllByCodeMembreReferenceLibelle($code_membre = "", $reference = "", $libelle_information_additif = "", $etat = "") {
        $select = $this->getDbTable()->select();
        if($code_membre != ""){
        $select->where("code_membre LIKE '".$code_membre."' ");
        }
        if($reference != ""){
        $select->where("reference LIKE '".$reference."' ");
        }
        if($libelle_information_additif != ""){
        $select->where("libelle_information_additif LIKE '".$libelle_information_additif."' ");
        }
        if($etat != ""){
        $select->where("etat = ? ", $etat);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuInformationAdditif();
            $entry->setId_information_additif($row->id_information_additif)
                ->setLibelle_information_additif($row->libelle_information_additif)
                    ->setReference($row->reference)
                    ->setCode_membre($row->code_membre)
                    ->setMembreasso_id($row->membreasso_id)
                    ->setEtat($row->etat)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }



}


?>
