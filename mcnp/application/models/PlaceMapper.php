<?php
 
class Application_Model_PlaceMapper {

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
            $this->setDbTable('Application_Model_DbTable_Place');
        }
        return $this->_dbTable;
    }

    public function find($num, Application_Model_Place $place) {
        $result = $this->getDbTable()->find($num);
        if (count($result) == 0) {
           return false;
        }
        $row = $result->current();
        $place->setNum($row->num)
              ->setMembre($row->membre)
              ->setMontant($row->montant)
              ->setLib($row->lib)
              ->setDatedepot($row->datedepot)
              ->setAgence($row->agence)
              ->setHeureid($row->heureid)
              ->setCais($row->cais);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Place();
            $entry->setNum($row->num)
                  ->setMembre($row->membre)
                  ->setMontant($row->montant)
                  ->setLib($row->lib)
                  ->setDatedepot($row->datedepot)
                  ->setAgence($row->agence)
                  ->setHeureid($row->heureid)
                  ->setCais($row->cais);
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function save(Application_Model_Place $place) {
        $data = array(
          'num' => $place->getNum(),
          'membre' => $place->getMembre(),
          'montant' => $place->getMontant(),
          'lib' => $place->getLib(),
          'datedepot' => $place->getDatedepot(),
          'agence' => $place->getAgence(),
          'heureid' => $place->getHeureid(),
          'cais' => $place->getCais()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_Place $place) {
        $data = array(
            'num' => $place->getNum(),
            'membre' => $place->getMembre(),
            'montant' => $place->getMontant(),
            'lib' => $place->getLib(),
            'datedepot' => $place->getDatedepot(),
            'agence' => $place->getAgence(),
            'heureid' => $place->getHeureid(),
            'cais' => $place->getCais()
        );
        $this->getDbTable()->update($data, array('num = ?' => $place->getNum()));
    }

    public function delete($num) {
        $this->getDbTable()->delete(array('num = ?' => $num));
    }



}


?>
