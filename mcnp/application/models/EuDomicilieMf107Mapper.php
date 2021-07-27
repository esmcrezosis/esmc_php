<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDomicilieMf107Mapper {
    
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
            $this->setDbTable('Application_Model_DbTable_EuDomicilieMf107');
        }
        return $this->_dbTable;
    }
    
    
    public function findMaxDom() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_dom) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
    
    
    
    public function save(Application_Model_EuDomicilieMf107 $domici) {
        $data = array(
           'id_dom' => $domici->getId_dom(),
           'mt_domiciliation' => $domici->getMt_domiciliation(),
           'mt_domicilie' => $domici->getMt_domicilie(),
           'etat_domiciliation' => $domici->getEtat_domiciliation(),
           'code_membre' => $domici->getCode_membre(),
           'date_dom' => $domici->getDate_dom(),
           'heure_dom' => $domici->getHeure_dom(),
           'id_utilisateur' => $domici->getId_utilisateur() 
        );

        $this->getDbTable()->insert($data);
    }
    
    
    public function update(Application_Model_EuDomicilieMf107 $domici) {
        $data = array(
           'id_dom' => $domici->getId_dom(),
           'mt_domiciliation' => $domici->getMt_domiciliation(),
           'mt_domicilie' => $domici->getMt_domicilie(),
           'etat_domiciliation' => $domici->getEtat_domiciliation(),
           'code_membre' => $domici->getCode_membre(),
           'date_dom' => $domici->getDate_dom(),
           'heure_dom' => $domici->getHeure_dom(),
           'id_utilisateur' => $domici->getId_utilisateur() 
        );

        $this->getDbTable()->update($data, array('id_dom = ?' => $domici->getId_dom()));
    }
    
    
    public function find($id_dom, Application_Model_EuDomicilieMf107 $domici) {
        $result = $this->getDbTable()->find($id_dom);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $domici->setId_dom($row->id_dom)
               ->setMt_domiciliation($row->mt_domiciliation)
               ->setMt_domicilie($row->mt_domicilie)
               ->setEtat_domiciliation($row->etat_domiciliation)
               ->setCode_membre($row->code_membre)
               ->setDate_dom($row->date_dom)
               ->setHeure_dom($row->heure_dom)
               ->setId_utilisateur($row->id_utilisateur); ;
        return true;
    }
    
    
    public function getSumDomicilie($id_mf107) {
        $somme=0;
        $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_detail_domicilie_mf107', 'eu_detail_domicilie_mf107.id_dom = eu_domicilie_mf107.id_dom');
        $select->where('eu_detail_domicilie_mf107.id_mf107 =?',$id_mf107);
        $select->where('eu_domicilie_mf107.etat_domiciliation <> ?',1);
        $result = $this->getDbTable()->fetchAll($select);
        foreach ($result as $row) {
            $somme = $somme + $row->mt_domi_apport;
        }
        return $somme;
    }
    
    
     public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDomicilieMf107();
            $entry->setId_dom($row->id_dom)
                  ->setMt_domiciliation($row->mt_domiciliation)
                  ->setMt_domicilie($row->mt_domicilie)
                  ->setEtat_domiciliation($row->etat_domiciliation)
                  ->setCode_membre($row->code_membre)
                  ->setDate_dom($row->date_dom)
                  ->setHeure_dom($row->heure_dom)
                  ->setId_utilisateur($row->id_utilisateur);
            $entries[] = $entry;
        }
        return $entries;
     }

     
    public function delete($id_dom) {
        $this->getDbTable()->delete(array('id_dom = ?' => $id_dom));
    }    
}

?>
