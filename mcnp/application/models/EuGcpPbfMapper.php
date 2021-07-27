<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuGcpPbfMapper
 *
 * @author user
 */
class Application_Model_EuGcpPbfMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuGcpPbf');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuGcpPbf $gcp) {
        $data = array(
            'code_gcp_pbf' => $gcp->getCode_gcp_pbf(),
            'code_membre' => $gcp->getCode_membre(),
            'code_compte' => $gcp->getCode_compte(),
            'mont_gcp' => $gcp->getMont_gcp(),
            'mont_agio' => $gcp->getMont_agio(),
            'mont_gcp_reel' => $gcp->getMont_gcp_reel(),
            'gcp_compense' => $gcp->getGcp_compense(),
            'agio_consomme' => $gcp->getAgio_comsomme(),
            'solde_gcp' => $gcp->getSolde_gcp(),
            'solde_agio' => $gcp->getSolde_agio(),
            'solde_gcp_reel' => $gcp->getSolde_gcp_reel(),
            'type_capa' => $gcp->getType_capa()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuGcpPbf $gcp) {
        $data = array(
            'code_gcp_pbf' => $gcp->getCode_gcp_pbf(),
            'code_membre' => $gcp->getCode_membre(),
            'code_compte' => $gcp->getCode_compte(),
            'mont_gcp' => $gcp->getMont_gcp(),
            'mont_agio' => $gcp->getMont_agio(),
            'mont_gcp_reel' => $gcp->getMont_gcp_reel(),
            'gcp_compense' => $gcp->getGcp_compense(),
            'agio_consomme' => $gcp->getAgio_comsomme(),
            'solde_gcp' => $gcp->getSolde_gcp(),
            'solde_agio' => $gcp->getSolde_agio(),
            'solde_gcp_reel' => $gcp->getSolde_gcp_reel(),
            'type_capa' => $gcp->getType_capa()
        );
        $this->getDbTable()->update($data, array('code_gcp_pbf = ?' => $gcp->getCode_gcp_pbf()));
    }

    public function find($code_gcp_pbf, Application_Model_EuGcpPbf $gcp) {
        $result = $this->getDbTable()->find($code_gcp_pbf);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $gcp->setCode_gcp_pbf($row->code_gcp_pbf)
                ->setCode_membre($row->code_membre)
                ->setCode_compte($row->code_compte)
                ->setMont_gcp($row->mont_gcp)
                ->setMont_agio($row->mont_agio)
                ->setMont_gcp_reel($row->mont_gcp_reel)
                ->setGcp_compense($row->gcp_compense)
                ->setSolde_gcp($row->solde_gcp)
                ->setSolde_agio($row->solde_agio)
                ->setSolde_gcp_reel($row->solde_gcp_reel)
                ->setType_capa($row->type_capa);
        return true;
    }

    public function findSommeGcpPbf($membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde_gcp) as total'));
        $select->where('code_membre = ?', $membre)
                ->where('solde_gcp > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            return $row['total'];
        } else {
            return 0;
        }
    }
    
    public function findAgioGcpPbf($membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(agio) as total'));
        $select->where('code_membre = ?', $membre)
                ->where('agio > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            return $row['total'];
        } else {
            return 0;
        }
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGcpPbf();
            $entry->setCode_gcp_pbf($row->code_gcp_pbf)
                    ->setCode_membre($row->code_membre)
                    ->setCode_compte($row->code_compte)
                    ->setMont_gcp($row->mont_gcp)
                    ->setMont_agio($row->mont_agio)
                    ->setMont_gcp_reel($row->mont_gcp_reel)
                    ->setGcp_compense($row->gcp_compense)
                    ->setSolde_gcp($row->solde_gcp)
                    ->setSolde_agio($row->solde_agio)
                    ->setSolde_gcp_reel($row->solde_gcp_reel)
                    ->setType_capa($row->type_capa);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByPbf($membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre = ?', $membre)
                ->where('solde_gcp > ?', 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGcpPbf();
            $entry->setCode_gcp_pbf($row->code_gcp_pbf)
                    ->setCode_membre($row->code_membre)
                    ->setCode_compte($row->code_compte)
                    ->setMont_gcp($row->mont_gcp)
                    ->setMont_agio($row->mont_agio)
                    ->setMont_gcp_reel($row->mont_gcp_reel)
                    ->setGcp_compense($row->gcp_compense)
                    ->setSolde_gcp($row->solde_gcp)
                    ->setSolde_agio($row->solde_agio)
                    ->setSolde_gcp_reel($row->solde_gcp_reel)
                    ->setType_capa($row->type_capa);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_gcp_pbf) {
        $this->getDbTable()->delete(array('code_gcp_pbf = ?' => $code_gcp_pbf));
    }

}

?>
