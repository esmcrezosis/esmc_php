<?php
class Application_Model_EuRayonMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRayon');
        }
        return $this->_dbTable;
    }

    public function find($code_rayon, Application_Model_EuRayon $rayon) {
        $result = $this->getDbTable()->find($code_rayon);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $rayon->setCode_rayon($row->code_rayon)
                ->setCode_bout($row->code_bout)
                ->setProprietaire_rayon($row->proprietaire_rayon)
                ->setDesign_rayon($row->design_rayon)
                ->setTelephone($row->telephone)
                ->setAdresse($row->adresse)
                ->setCreer_par($row->creer_par);
    }
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRayon();
            $entry->setCode_rayon($row->code_rayon)
                  ->setCode_bout($row->code_bout)
                  ->setProprietaire_rayon($row->proprietaire_rayon)
                  ->setDesign_rayon($row->design_rayon)
                  ->setTelephone($row->telephone)
                  ->setAdresse($row->adresse)
                  ->setCreer_par($row->creer_par)  
                    ;
            $entries[] = $entry;
        }
        return $entries;
}
    
    
    public function save(Application_Model_EuRayon $rayon) {
        $data = array(
            'code_rayon' => $rayon->getCode_rayon(),
            'code_bout' => $rayon->getCode_bout(),
            'proprietaire_rayon' => $rayon->getProprietaire_rayon(),
            'design_rayon' => $rayon->getDesign_rayon(),
            'telephone' => $rayon->getTelephone(),
            'adresse' => $rayon->getAdresse(),
            'creer_par' => $rayon->getCreer_par()
        );

        $this->getDbTable()->insert($data);
 }

 
 public function update(Application_Model_EuRayon $rayon) {
        $data = array(
            'code_rayon' => $rayon->getCode_rayon(),
            'code_bout' => $rayon->getCode_bout(),
            'proprietaire_rayon' => $rayon->getProprietaire_rayon(),
            'design_rayon' => $rayon->getDesign_rayon(),
            'telephone' => $rayon->getTelephone(),
            'adresse' => $rayon->getAdresse(),
            'creer_par' => $rayon->getCreer_par()
        );
        $this->getDbTable()->update($data, array('code_rayon = ?' => $rayon->getCode_rayon()));
 }

    
  public function delete($code_rayon) {
      
        $this->getDbTable()->delete(array('code_rayon = ?' => $code_rayon));
    }
}

?>
