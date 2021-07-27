<?php

class Application_Model_MoraleMapper {

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
            $this->setDbTable('Application_Model_DbTable_Morale');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Morale $morale) {
           $data = array(
               'numidentm' => $morale->getCode_categorie(),
               'nomm' => $morale->getNomm(),
               'representant' => $morale->getRepresentant(),
               'qart' => $morale->getQart(),
               'rue' => $morale->getRue(),
               'ville' => $morale->getVille(),
               'bp' => $morale->getBp(),
               'tel' => $morale->getTel(),
               'portable' => $morale->getPortable(),
               'email' => $morale->getEmail(),
               'site' => $morale->getSite(),
               'dateident' => $morale->getDateIdent(),
               'numcompbq' => $morale->getNumCompBq(),
               'agence' => $morale->getAgence(),
               'montant' => $morale->getMontant(),
               'heurid' => $morale->getHeurid(),
               'user' => $morale->getUser(),
               'etat_contrat' => $morale->getEtat_contrat(),
			   'code_membre' => $morale->getCode_membre()
                
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_Morale $morale) {
        $data = array(
               'numidentm' => $morale->getNumIdentm(),
               'nomm' => $morale->getNomm(),
               'representant' => $morale->getRepresentant(),
               'qart' => $morale->getQart(),
               'rue' => $morale->getRue(),
               'ville' => $morale->getVille(),
               'bp' => $morale->getBp(),
               'tel' => $morale->getTel(),
               'portable' => $morale->getPortable(),
               'email' => $morale->getEmail(),
               'site' => $morale->getSite(),
               'dateident' => $morale->getDateIdent(),
               'numcompbq' => $morale->getNumCompBq(),
               'agence' => $morale->getAgence(),
               'montant' => $morale->getMontant(),
               'heurid' => $morale->getHeurid(),
               'user' => $morale->getUser(),
               'etat_contrat' => $morale->getEtat_contrat(),
			   'code_membre' => $morale->getCode_membre()
        );

        $this->getDbTable()->update($data, array('numidentm = ?' => $morale->getNumIdentm()));
    }

    public function find($numIdentm, Application_Model_Morale $morale) {
        $result = $this->getDbTable()->find($numIdentm);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $morale->setNumIdentm($row->numidentm)
               ->setNomm($row->nomm)
               ->setRepresentant($row->representant)
               ->setQart($row->qart)
               ->setRue($row->rue)
               ->setVille($row->ville)
               ->setBp($row->bp)
               ->setTel($row->tel)
               ->setPortable($row->portable)
               ->setEmail($row->email)
               ->setSite($row->site)
               ->setDateIdent($row->dateident)
               ->setNumCompBq($row->numcompbq)
               ->setAgence($row->agence)
               ->setMontant($row->montant)
               ->setHeurid($row->heurid)
               ->setUser($row->user) 
               ->setEtat_contrat($row->etat_contrat)
			   ->setCode_membre($row->code_membre)
			   ;
        return true;
    }

    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Morale();
            $entry->setNumIdentm($row->numidentm)
                  ->setNomm($row->nomm)
                  ->setRepresentant($row->representant)
                  ->setQart($row->qart)
                  ->setRue($row->rue)
                  ->setVille($row->ville)
                  ->setBp($row->bp)
                  ->setTel($row->tel)
                  ->setPortable($row->portable)
                  ->setEmail($row->email)
                  ->setSite($row->site)
                  ->setDateIdent($row->dateident)
                  ->setNumCompBq($row->numcompbq)
                  ->setAgence($row->agence)
                  ->setMontant($row->montant)
                  ->setHeurid($row->heurid)
                  ->setUser($row->user)
                  ->setEtat_contrat($row->etat_contrat)
				  ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
    public function delete($numIdentm) {
        $this->getDbTable()->delete(array('numidentm = ?' => $numIdentm));
    }


}


