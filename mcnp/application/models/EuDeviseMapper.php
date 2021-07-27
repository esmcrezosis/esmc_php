    <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDeviseMapper
 *
 * @author user
 */
class Application_Model_EuDeviseMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDevise');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuDevise $devise) {
        $data = array(
            'code_dev' => $devise->getCode_dev(),
            'lib_dev' => $devise->getLib_dev(),
            'symbole_dev' => $devise->getSymbole_dev()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDevise $devise) {
        $data = array(
            'code_dev' => $devise->getCode_dev(),
            'lib_dev' => $devise->getLib_dev(),
            'symbole_dev' => $devise->getSymbole_dev()
        );

        $this->getDbTable()->update($data, array('code_dev = ?' => $devise->getCode_dev()));
    }

    public function find($code_dev, Application_Model_EuDevise $devise) {
        $result = $this->getDbTable()->find($code_dev);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $devise->setCode_dev($row->code_dev)
                ->setLib_dev($row->lib_dev)
                ->setSymbole_dev($row->symbole_dev);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDevise();
            $entry->setCode_dev($row->code_dev)
                    ->setLib_dev($row->lib_dev)
                    ->setSymbole_dev($row->symbole_dev);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_dev) {
        $this->getDbTable()->delete(array('code_dev = ?' => $code_dev));
    }

}

?>
