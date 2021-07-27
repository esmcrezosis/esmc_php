<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class  Application_Model_EuMembreFondateur107Mapper  {
       
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
            $this->setDbTable('Application_Model_DbTable_EuMembreFondateur107');
        }
        return $this->_dbTable;
    }

    
    public function find($numident, Application_Model_EuMembreFondateur107 $mf107) {
        $result = $this->getDbTable()->find($numident);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $mf107->setNumident($row->numident)
                ->setNom($row->nom)
                ->setPrenom($row->prenom)
                ->setTel($row->tel)
                ->setCel($row->cel)
                ->setCode_membre($row->code_membre)
                ->setSolde($row->solde)
                ->setNb_repartition($row->nb_repartition);
        
             return true;
    }
 
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreFondateur107();
            $entry->setNumident($row->numident)
                  ->setNom($row->nom)
                  ->setPrenom($row->prenom)
                  ->setTel($row->tel)
                  ->setCel($row->cel)
                  ->setCode_membre($row->code_membre)
                  ->setSolde($row->solde)
                  ->setNb_repartition($row->nb_repartition);
            $entries[] = $entry;
        }
        return $entries;
     }

     public function findnbrep($numident) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('nb_repartition'));
        $select->where('numident = ?', $numident);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['nb_repartition'];
     }
     
     
     public function save(Application_Model_EuMembreFondateur107 $mf107) {
            $data = array(
                  'numident' =>$mf107->getNumident(),
                  'nom' => $mf107->getNom(),
                  'prenom' => $mf107->getPrenom(),
                  'tel' => $mf107->getTel(),
                  'cel' => $mf107->getCel(),
                  'code_membre' => $mf107->getCode_membre(),
                  'solde' => $mf107->getSolde(),
                  'nb_repartition' => $mf107->getNb_repartition(),
                  'id_utilisateur' => $mf107->getId_utilisateur()
        );
        $this->getDbTable()->insert($data);
     }


     public function update(Application_Model_EuMembreFondateur107 $mf107) {
        $data = array(
                 'numident' =>$mf107->getNumident(),
                 'nom' => $mf107->getNom(),
                 'prenom' => $mf107->getPrenom(),
                 'tel' => $mf107->getTel(),
                 'cel' => $mf107->getCel(),
                 'code_membre' => $mf107->getCode_membre(),
                 'solde' => $mf107->getSolde(),
                 'nb_repartition' => $mf107->getNb_repartition(),
                 'id_utilisateur' => $mf107->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('numident = ?' => $mf107->getNumident()));
     }
  
 
     public function delete($numident) {
        $this->getDbTable()->delete(array('numident = ?' => $numident));       
     }
 

}
?>
