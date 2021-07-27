<?php
 
class Application_Model_EuSerieOpiMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuSerieOpi');
        }
        return $this->_dbTable;
    }

    public function find($id_serie_opi, Application_Model_EuSerieOpi $serie) {
        $result = $this->getDbTable()->find($id_serie_opi);
        if (count($result) == 0) {
           return false;
        }
        $row = $result->current();
        $serie->setId_serie_opi($row->id_serie_opi)
              ->setValeur_serie($row->valeur_serie);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
          $entry = new Application_Model_EuSerieOpi();
          $entry->setId_serie_opi($row->id_serie_opi)
                  ->setValeur_serie($row->valeur_serie);
          $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_serie_opi) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuSerieOpi $serie) {
        $data = array(
          'id_serie_opi' => $serie->getAcheteur_id(),
          'valeur_serie' => $serie->getValeur_serie()
        );

        $this->getDbTable()->insert($data);
    }

	
    public function update(Application_Model_EuSerie $serie) {
        $data = array(
            'id_serie_opi' => $serie->getId_serie_opi(),
            'valeur_serie' => $serie->getValeur_serie()
        );
        $this->getDbTable()->update($data, array('id_serie_opi = ?' => $serie->getId_serie_opi()));
    }

	
    public function delete($id_serie_opi) {
        $this->getDbTable()->delete(array('id_serie_opi = ?' => $id_serie_opi));
    }


}


?>
