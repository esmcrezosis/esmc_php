<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class   Application_Model_EuDetailMf107Mapper {
    
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
            $this->setDbTable('Application_Model_DbTable_EuDetailMf107');
        }
        return $this->_dbTable;
    }

    public function find($id_mf107, Application_Model_EuDetailMf107 $dmf107) {
        $result = $this->getDbTable()->find($id_mf107);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $dmf107->setId_mf107($row->id_mf107)
               ->setNumident($row->numident)
               ->setCode_membre($row->code_membre)
               ->setDate_mf107($row->date_mf107)
               ->setMont_apport($row->mont_apport)
               ->setPourcentage($row->pourcentage)
               ->setId_utilisateur($row->id_utilisateur)
               ->setProprietaire($row->proprietaire)
			   ->setCreditcode($row->creditcode)
			   ->setNature($row->nature)
			   ;
    }
    
    public function findmontant($numident) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('mont_apport'));
        $select->where('numident = ?', $numident)
               ->where('proprietaire = ?',1);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['mont_apport'];
    }
    
    public function findid($numident) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_mf107'));
        $select->where('numident = ?', $numident)
               ->where('proprietaire = ?',1);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['id_mf107'];
    }
    
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(),array('MAX(id_mf107) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function fetchAllByMf() { 
      $select = $this->getDbTable()->select();
      $select->where('proprietaire IS NULL')
             ->order('date_mf107 ASC');
      $resultSet = $this->getDbTable()->fetchAll($select);
      if (count($resultSet) > 0) {
         $entries = array();
         foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailMf107();
            $entry->setId_mf107($row->id_mf107)
                  ->setNumident($row->numident)
                  ->setCode_membre($row->code_membre)
                  ->setMont_apport($row->mont_apport)
                  ->setPourcentage($row->pourcentage)
                  ->setProprietaire($row->proprietaire)
			      ->setCreditcode($row->creditcode)
				  ->setNature($row->nature);
            $entries[] = $entry;
         }
         return $entries;
        }
        else {
             return NULL;
        }
        
    }
  
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailMf107();
            $entry->setId_mf107($row->id_mf107)
                  ->setNumident($row->numident)
                  ->setCode_membre($row->code_membre)
                  ->setDate_mf107($row->date_mf107)  
                  ->setMont_apport($row->mont_apport)
                  ->setPourcentage($row->pourcentage)
                  ->setProprietaire($row->proprietaire)
				  ->setCreditcode($row->creditcode)
				  ->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
     }

     public function save(Application_Model_EuDetailMf107 $dmf107) {
        $data = array(
          'id_mf107' =>$dmf107->getId_mf107(),
          'numident' => $dmf107->getNumident(),
          'code_membre' => $dmf107->getCode_membre(),
          'date_mf107' => $dmf107->getDate_mf107(),
          'mont_apport' => $dmf107->getMont_apport(),
          'id_utilisateur' => $dmf107->getId_utilisateur(),
          'pourcentage' => $dmf107->getPourcentage(),
          'proprietaire' => $dmf107->getProprietaire(),
		  'creditcode' => $dmf107->getCreditcode(),
          'nature' => $dmf107->getNature()		  
        );
        $this->getDbTable()->insert($data);
     }

     
     
    public function update(Application_Model_EuDetailMf107 $dmf107) {
        $data = array(
           'id_mf107' =>$dmf107->getId_mf107(),
           'numident' => $dmf107->getNumident(),
           'code_membre' => $dmf107->getCode_membre(),
           'date_mf107' => $dmf107->getDate_mf107(),
           'mont_apport' => $dmf107->getMont_apport(),
           'id_utilisateur' => $dmf107->getId_utilisateur(),
           'pourcentage' => $dmf107->getPourcentage(),
           'proprietaire' => $dmf107->getProprietaire(),
		   'creditcode' => $dmf107->getCreditcode(),
           'nature' => $dmf107->getNature()		   
      );
      $this->getDbTable()->update($data, array('id_mf107 = ?' => $dmf107->getId_mf107()));
    }
    
    public function delete($id_mf107) {
           $this->getDbTable()->delete(array('id_mf107 = ?' => $id_mf107));      
    }
}
?>
