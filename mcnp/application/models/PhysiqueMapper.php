<?php

class Application_Model_PhysiqueMapper {

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
            $this->setDbTable('Application_Model_DbTable_Physique');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Physique $physique) {
           $data = array(
               'numidentp' => $physique->getNumidentp(),
               'photo' => $physique->getPhoto(),
               'nom' => $physique->getNom(),
               'prenom' => $physique->getPrenom(),
               'sexe' => $physique->getSexe(),
               'datenais' => $physique->getDatenais(),
               'lieunais' => $physique->getLieunais(),
               'nationalite' => $physique->getNationalite(),
               'prof' => $physique->getProf(),
               'formation' => $physique->getFormation(),
               'pere' => $physique->getPere(),
               'mere' => $physique->getMere(),
               'sitmatr' => $physique->getSitmatr(),
               'nbrenf' => $physique->getNbrenf(),
               'qartresid' => $physique->getQartresid(),
               'ville' => $physique->getVille(),
               'bp' => $physique->getBp(),
               'tel' => $physique->getTel(),
               'email' => $physique->getEmail(),
               'dateident' => $physique->getDateident(),
               'portable' => $physique->getPortable(),
               'numcompbq' => $physique->getNumcompbq(),
               'emprunt' => $physique->getEmprunt(),
               'agence' => $physique->getAgence(),
               'heurid' => $physique->getHeurid(),
               'religion' => $physique->getReligion(),
               'user' => $physique->getUser(),
               'etat_contrat' => $physique->getEtat_contrat(),
			   'code_membre' => $physique->getCode_membre()
                
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_Physique $physique) {
        $data = array(
               'numidentp' => $physique->getNumidentp(),
               'photo' => $physique->getPhoto(),
               'nom' => $physique->getNom(),
               'prenom' => $physique->getPrenom(),
               'sexe' => $physique->getSexe(),
               'datenais' => $physique->getDatenais(),
               'lieunais' => $physique->getLieunais(),
               'nationalite' => $physique->getNationalite(),
               'prof' => $physique->getProf(),
               'formation' => $physique->getFormation(),
               'pere' => $physique->getPere(),
               'mere' => $physique->getMere(),
               'sitmatr' => $physique->getSitmatr(),
               'nbrenf' => $physique->getNbrenf(),
               'qartresid' => $physique->getQartresid(),
               'ville' => $physique->getVille(),
               'bp' => $physique->getBp(),
               'tel' => $physique->getTel(),
               'email' => $physique->getEmail(),
               'dateident' => $physique->getDateident(),
               'portable' => $physique->getPortable(),
               'numcompbq' => $physique->getNumcompbq(),
               'emprunt' => $physique->getEmprunt(),
               'agence' => $physique->getAgence(),
               'heurid' => $physique->getHeurid(),
               'religion' => $physique->getReligion(),
               'user' => $physique->getUser(),
               'etat_contrat' => $physique->getEtat_contrat(),
			   'code_membre' => $physique->getCode_membre()
        );

        $this->getDbTable()->update($data, array('numidentp = ?' => $physique->getNumidentp()));
    }

    public function find($numidentp, Application_Model_Physique $physique) {
        
        $result = $this->getDbTable()->find($numidentp);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $physique->setNumidentp($row->numidentp)
                 ->setPhoto($row->photo)
                 ->setNom($row->nom)
                 ->setPrenom($row->prenom)
                 ->setSexe($row->sexe)
                 ->setDatenais($row->datenais)
                 ->setLieunais($row->lieunais)
                 ->setNationalite($row->nationalite)
                 ->setProf($row->prof)
                 ->setFormation($row->formation)
                 ->setPere($row->pere)
                 ->setMere($row->mere)
                 ->setSitmatr($row->sitmatr)
                 ->setNbrenf($row->nbrenf)
                 ->setQartresid($row->qartresid)
                 ->setVille($row->ville)
                 ->setBp($row->bp)
                 ->setTel($row->tel)
                 ->setEmail($row->email)
                 ->setDateident($row->dateident)
                 ->setPortable($row->portable)
                 ->setNumcompbq($row->numcompbq)
                 ->setEmprunt($row->emprunt)
                 ->setAgence($row->agence)
                 ->setHeurid($row->heurid)
                 ->setReligion($row->religion)
                 ->setUser($row->user)
                 ->setEtat_contrat($row->etat_contrat)
				 ->setCode_membre($row->code_membre);
         return true;
    }

    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Physique();
            $entry->setNumidentp($row->numidentp)
                  ->setPhoto($row->photo)
                  ->setNom($row->nom)
                  ->setPrenom($row->prenom)
                  ->setSexe($row->sexe)
                  ->setDatenais($row->datenais)
                  ->setLieunais($row->lieunais)
                  ->setNationalite($row->nationalite)
                  ->setProf($row->prof)
                  ->setFormation($row->formation)
                  ->setPere($row->pere)
                  ->setMere($row->mere)
                  ->setSitmatr($row->sitmatr)
                  ->setNbrenf($row->nbrenf)
                  ->setQartresid($row->qartresid)
                  ->setVille($row->ville)
                  ->setBp($row->bp)
                  ->setTel($row->tel)
                  ->setEmail($row->email)
                  ->setDateident($row->dateident)
                  ->setPortable($row->portable)
                  ->setNumcompbq($row->numcompbq)
                  ->setEmprunt($row->emprunt)
                  ->setAgence($row->agence)
                  ->setHeurid($row->heurid)
                  ->setReligion($row->religion)
                  ->setUser($row->user)
                  ->setEtat_contrat($row->etat_contrat)
				  ->setCode_membre($row->code_membre);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    public function delete($numidentp) {
        $this->getDbTable()->delete(array('numidentp = ?' => $numidentp));
    }

    
    
    
}



