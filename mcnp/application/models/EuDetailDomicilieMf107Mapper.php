<?php
     
 class Application_Model_EuDetailDomicilieMf107Mapper {
        
     
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
            $this->setDbTable('Application_Model_DbTable_EuDetailDomicilieMf107');
        }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_EuDetailDomicilieMf107 $domici) {
        $data = array(
          'id_dom' => $domici->getId_dom(),
          'id_mf107' => $domici->getId_mf107(),
          'mt_domi_apport' => $domici->getMt_domi_apport(),
          'nb_rep' => $domici->getNb_rep(),
          'nb_reste' => $domici->getNb_reste()  
        );

        $this->getDbTable()->insert($data);
    }
    
    public function update(Application_Model_EuDetailDomicilieMf107 $domici) {
        $data = array(
            'id_dom' => $domici->getId_dom(),
            'id_mf107' => $domici->getId_mf107(),
            'mt_domi_apport' => $domici->getMt_domi_apport(),
            'nb_rep' => $domici->getNb_rep(),
            'nb_reste' => $domici->getNb_reste()
        );

        $this->getDbTable()->update($data, array('id_dom = ?' => $domici->getId_dom(),'id_mf107 = ?' => $domici->getId_mf107()));
    }
    
    
    public function find($id_mf107,$id_dom, Application_Model_EuDetailDomicilieMf107 $domici) {
        $result = $this->getDbTable()->find($id_mf107,$id_dom);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $domici->setId_dom($row->id_dom)
               ->setId_mf107($row->id_mf107)
               ->setMt_domi_apport($row->mt_domi_apport)
               ->setNb_rep($row->nb_rep)
               ->setNb_reste($row->nb_reste);
        return true;
    }
    
    
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailDomicilieMf107();
            $entry->setId_dom($row->id_dom)
                  ->setId_mf107($row->id_mf107)
                  ->setMt_domi_apport($row->mt_domi_apport)
                  ->setNb_rep($row->nb_rep)
                  ->setNb_reste($row->nb_reste)  ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    
    public function getSumDomicilie($id_mf107) {
        
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mt_domi_apport) as somme'));
        $select->where('id_mf107 =?', $id_mf107);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }
    
    public function findById_mf107($id_mf107) {
         
        $select = $this->getDbTable()->select();
        $select->where('id_mf107 = ?', $id_mf107);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) > 0) {
           $entries = array();
           foreach ($resultSet as $row) {
                $entry = new Application_Model_EuDetailDomicilieMf107();
                $entry->setId_mf107($row->id_mf107)
                      ->setId_dom($row->id_dom)
                      ->setMt_domi_apport($row->mt_domi_apport)
                      ->setNb_rep($row->nb_rep)
                      ->setNb_reste($row->nb_reste)  ;
                $entries[] = $entry;
           }
           return $entries;
        }
        else {
             return NULL;
        }
        
    }
    
    
    public function findById_dom($id_dom) {
        $select = $this->getDbTable()->select();
        $select->where('id_dom = ?', $id_dom);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) > 0) {
           $entries = array();
           foreach ($resultSet as $row) {
                $entry = new Application_Model_EuDetailDomicilieMf107();
                $entry->setId_mf107($row->id_mf107)
                      ->setId_dom($row->id_dom)
                      ->setMt_domi_apport($row->mt_domi_apport)
                      ->setNb_rep($row->nb_rep)
                      ->setNb_reste($row->nb_reste)  ;
                $entries[] = $entry;
            }
            return $entries;
        }
        else {
             return NULL;
        }
    }
    
   
    public function delete($id_dom,$id_mf107) {
        $this->getDbTable()->delete(array('id_dom = ?' => $id_dom,'id_mf107 = ?' => $id_mf107));
    }
    
    
          
 }

?>