<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application_Model_EuTypeBnp
 *
 * @author user
 */
class Application_Model_EuTypeBnpMapper {

    //put your code here
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
            $this->setDbTable('Application_Model_DbTable_EuTypeBnp');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuTypeBnp $typebnp) {
        $data = array(
            'code_type_bnp' => $typebnp->getCode_type_bnp(),
            'libelle_bnp' => $typebnp->getLibelle_bnp(),
            'tx_conus' => $typebnp->getTx_conus(),
            'tx_par' => $typebnp->getTx_par(),
            'tx_panu' => $typebnp->getTx_panu(),
            'tx_fs' => $typebnp->getTx_fs(),
            'tx_panu_fs' => $typebnp->getTx_panu_fs()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeBnp $typebnp) {
        $data = array(
            'code_type_bnp' => $typebnp->getCode_type_bnp(),
            'libelle_bnp' => $typebnp->getLibelle_bnp(),
            'tx_conus' => $typebnp->getTx_conus(),
            'tx_par' => $typebnp->getTx_par(),
            'tx_panu' => $typebnp->getTx_panu(),
            'tx_fs' => $typebnp->getTx_fs(),
            'tx_panu_fs' => $typebnp->getTx_panu_fs()
        );
        $this->getDbTable()->update($data, array('code_type_bnp = ?' => $typebnp->getCode_type_bnp()));
    }

    public function find($type, Application_Model_EuTypeBnp $typebnp) {
        $result = $this->getDbTable()->find($type);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $typebnp->setCode_type_bnp($row->code_type_bnp)
                ->setLibelle_bnp($row->libelle_bnp)
                ->setTx_conus($row->tx_conus)
                ->setTx_par($row->tx_par)
                ->setTx_panu($row->tx_panu)
                ->setTx_fs($row->tx_fs)
                ->setTx_panu_fs($row->tx_panu_fs);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeBnp();
            $entry->setCode_type_bnp($row->code_type_bnp)
                    ->setLibelle_bnp($row->libelle_bnp)
                    ->setTx_conus($row->tx_conus)
                    ->setTx_par($row->tx_par)
                    ->setTx_panu($row->tx_panu)
                    ->setTx_fs($row->tx_fs)
                    ->setTx_panu_fs($row->tx_panu_fs);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_type_bnp) {
        $this->getDbTable()->delete(array('code_type_bnp = ?' => $code_type_bnp));
    }

}

?>
