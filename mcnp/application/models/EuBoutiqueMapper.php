<?php

class Application_Model_EuBoutiqueMapper
{
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
            $this->setDbTable('Application_Model_DbTable_EuBoutique');
        }
        return $this->_dbTable;
    }
    public function findboutique($boutique) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_bout'));
        $select->where('code_bout = ?', $boutique);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_bout'];
    }
    
    public function findbout($boutique,$membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_bout'));
        $select->where('proprietaire = ?', $membre);
        $select->where('code_bout != ?', $boutique);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_bout'];
    }
    
    public function findmembre($membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_bout'));
        $select->where('proprietaire = ?', $membre);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_bout'];
    }
    
    public function find($code_bout, Application_Model_EuBoutique $boutique) {
        $result = $this->getDbTable()->find($code_bout);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $boutique->setCode_bout($row->code_bout)
                 ->setProprietaire($row->proprietaire)
                 ->setDesign_bout($row->design_bout)
                 ->setTelephone($row->telephone)
                 ->setAdresse($row->adresse)
                 ->setMail($row->mail)
                 ->setSiteweb($row->siteweb)
                 ->setCreer_par($row->creer_par)
                 ->setCodesect($row->codesect)
                 ->setNom_responsable($row->nom_responsable)
                 ->setPrenom_responsable($row->prenom_responsable)
                ;
    }
    
  public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBoutique();
            $entry->setCode_bout($row->code_bout);
            $entry->setProprietaire($row->proprietaire);
            $entry->setDesign_bout($row->design_bout);
            $entry->setTelephone($row->telephone);
            $entry->setAdresse($row->adresse);
            $entry->setMail($row->mail);
            $entry->setSiteweb($row->siteweb);
            $entry->setCreer_par($row->creer_par);
            $entry->setCodesect($row->codesect);
            $entry->setNom_responsable($row->nom_responsable);
            $entry->setPrenom_responsable($row->prenom_responsable);
            $entries[] = $entry;
        }
        return $entries;
    }

  public function save(Application_Model_EuBoutique $boutique) {
        $data = array(
            'code_bout' => $boutique->getCode_bout(),
            'proprietaire' => $boutique->getProprietaire(),
            'design_bout' => $boutique->getDesign_bout(),
            'telephone' => $boutique->getTelephone(),
            'adresse' => $boutique->getAdresse(),
            'mail' => $boutique->getMail(),
            'siteweb' => $boutique->getSiteweb(),
            'creer_par' => $boutique->getCreer_par(),
            'codesect' => $boutique->getCodesect(),
            'nom_responsable' => $boutique->getNom_responsable(),
            'prenom_responsable' => $boutique->getPrenom_responsable()
        ); 

        $this->getDbTable()->insert($data);
    }
    
  public function update(Application_Model_EuBoutique $boutique) {
        $data = array(
            'code_bout' => $boutique->getCode_bout(),
            'proprietaire' => $boutique->getProprietaire(),
            'design_bout' => $boutique->getDesign_bout(),
            'telephone' => $boutique->getTelephone(),
            'adresse' => $boutique->getAdresse(),
            'mail' => $boutique->getMail(),
            'siteweb' => $boutique->getSiteweb(),
            'creer_par' => $boutique->getCreer_par(),
            'codesect' => $boutique->getCodesect(),
            'nom_responsable' => $boutique->getNom_responsable(),
            'prenom_responsable' => $boutique->getPrenom_responsable()
        );

        $this->getDbTable()->update($data, array('code_bout = ?' => $boutique->getCode_bout()));
    }
     public function delete($code_bout) {
        $this->getDbTable()->delete(array('code_bout = ?' => $code_bout));
    }  
}


