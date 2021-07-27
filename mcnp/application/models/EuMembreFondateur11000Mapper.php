<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class  Application_Model_EuMembreFondateur11000Mapper  {
       
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
            $this->setDbTable('Application_Model_DbTable_EuMembreFondateur11000');
        }
        return $this->_dbTable;
    }

    
    
    public function find($num_bon, Application_Model_EuMembreFondateur11000 $mf11000) {
        $result = $this->getDbTable()->find($num_bon);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $mf11000->setNum_bon($row->num_bon)
                ->setNom($row->nom)
                ->setPrenom($row->prenom)
                ->setTel($row->tel)
                ->setCel($row->cel)
                ->setCode_membre($row->code_membre)
                ->setSolde($row->solde)
                ->setNb_repartition($row->nb_repartition)
				->setId_utilisateur($row->id_utilisateur);
        return true;
    }
 
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMembreFondateur11000();
            $entry->setNum_bon($row->num_bon)
                  ->setNom($row->nom)
                  ->setPrenom($row->prenom)
                  ->setTel($row->tel)
                  ->setCel($row->cel)
                  ->setCode_membre($row->code_membre)
                  ->setSolde($row->solde)
                  ->setNb_repartition($row->nb_repartition)
				  ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
     }

     public function findnbrep($num_bon) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('nb_repartition'));
        $select->where('num_bon = ?', $num_bon);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['nb_repartition'];
    }
     
     
     public function save(Application_Model_EuMembreFondateur11000 $mf11000) {
            $data = array(
              'num_bon' =>$mf11000->getNum_bon(),
              'nom' => $mf11000->getNom(),
              'prenom' => $mf11000->getPrenom(),
              'tel' => $mf11000->getTel(),
              'cel' => $mf11000->getCel(),
              'code_membre' => $mf11000->getCode_membre(),
              'solde' => $mf11000->getSolde(),
              'nb_repartition' => $mf11000->getNb_repartition(),
              'id_utilisateur' => $mf11000->getId_utilisateur()
        );
        $this->getDbTable()->insert($data);
 }


 public function update(Application_Model_EuMembreFondateur11000 $mf11000) {
        $data = array(
             'num_bon' =>$mf11000->getNum_bon(),
             'nom' => $mf11000->getNom(),
             'prenom' => $mf11000->getPrenom(),
             'tel' => $mf11000->getTel(),
             'cel' => $mf11000->getCel(),
             'code_membre' => $mf11000->getCode_membre(),
             'solde' => $mf11000->getSolde(),
             'nb_repartition' => $mf11000->getNb_repartition(),
             'id_utilisateur' => $mf11000->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('num_bon = ?' => $mf11000->getNum_bon()));
 }
  
 
  public function delete($num_bon) {
         $this->getDbTable()->delete(array('num_bon = ?' => $num_bon));       
  }
 

}
?>
