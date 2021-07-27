<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuFnMapper
 *
 * @author user
 */
class Application_Model_EuDetailFgfnMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailFgfn');
        }
        return $this->_dbTable;
    }

    public function find($idfg_fn, Application_Model_EuDetailFgfn $fn) {
        $result = $this->getDbTable()->find($idfg_fn);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $fn->setId_fgfn($row->id_fgfn)
                ->setCode_membre_pbf($row->code_membre_pbf)
                ->setMont_fgfn($row->mont_fgfn)
                ->setMont_preleve($row->mont_preleve)
                ->setSolde_fgfn($row->solde_fgfn)
                ->setDate_fgfn($row->date_fgfn)
                ->setCode_fgfn($row->code_fgfn)
                ->setCreditcode($row->creditcode)
                ->setOrigine_fgfn($row->origine_fgfn)
				->setType_fgfn($row->type_fgfn)
				;
    }

    public function find1() {
        $table = new Application_Model_DbTable_EuFgfn();
        $select = $table->select();
        $select->where('solde_fgfn >?', 0)
                ->order('date_fgfn', 'ASC')
                ->order('id_fgfn', 'ASC');
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuDetailFgfn();
            $entry->setId_fgfn($row->id_fgfn)
                    ->setCode_membre_pbf($row->code_membre_pbf)
                    ->setMont_fgfn($row->mont_fgfn)
                    ->setMont_preleve($row->mont_preleve)
                    ->setSolde_fgfn($row->solde_fgfn)
                    ->setDate_fgfn($row->date_fgfn)
                    ->setCode_fgfn($row->code_fgfn)
                    ->setCreditcode($row->creditcode)
                    ->setOrigine_fgfn($row->origine_fgfn)
					->setType_fgfn($row->type_fgfn);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fgfn) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailFgfn();
            $entry->setId_fgfn($row->id_fgfn)
                    ->setCode_membre_pbf($row->code_membre_pbf)
                    ->setMont_fgfn($row->mont_fgfn)
                    ->setMont_preleve($row->mont_preleve)
                    ->setSolde_fgfn($row->solde_fgfn)
                    ->setDate_fgfn($row->date_fgfn)
                    ->setCode_fgfn($row->code_fgfn)
                    ->setCreditcode($row->creditcode)
                    ->setOrigine_fgfn($row->origine_fgfn)
					->setType_fgfn($row->type_fgfn);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByFgfn($code_fgfn) {
        $select = $this->getDbTable()->select();
        $select->where('code_fgfn = ?', $code_fgfn)
                ->where('solde_fgfn > ?', 0)
                ->order('mont_fgfn', 'DESC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) > 0) {
            $entries = array();
            foreach ($resultSet as $row) {
                $entry = new Application_Model_EuDetailFgfn();
                $entry->setId_fgfn($row->id_fgfn)
                        ->setCode_membre_pbf($row->code_membre_pbf)
                        ->setMont_fgfn($row->mont_fgfn)
                        ->setMont_preleve($row->mont_preleve)
                        ->setSolde_fgfn($row->solde_fgfn)
                        ->setDate_fgfn($row->date_fgfn)
                        ->setCode_fgfn($row->code_fgfn)
                        ->setCreditcode($row->creditcode)
                        ->setOrigine_fgfn($row->origine_fgfn)
						->setType_fgfn($row->type_fgfn);
                $entries[] = $entry;
            }
            return $entries;
        } else {
            return NULL;
        }
    }

    public function fetchAllByUser($user) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_pbf =?', $user)
                ->order('date_fgfn', 'ASC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailFgfn();
            $entry->setId_fgfn($row->id_fgfn)
                    ->setCode_membre_pbf($row->code_membre_pbf)
                    ->setMont_fgfn($row->mont_fgfn)
                    ->setMont_preleve($row->mont_preleve)
                    ->setSolde_fgfn($row->solde_fgfn)
                    ->setDate_fgfn($row->date_fgfn)
                    ->setCode_fgfn($row->code_fgfn)
                    ->setCreditcode($row->creditcode)
                    ->setOrigine_fgfn($row->origine_fgfn)
					->setType_fgfn($row->type_fgfn);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getSumRPG($membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde_fgfn) as somme'));
        $select->where('code_membre_pbf = ?', $membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function save(Application_Model_EuDetailFgfn $fn) {
        $data = array(
            'id_fgfn' => $fn->getId_fgfn(),
            'code_membre_pbf' => $fn->getCode_membre_pbf(),
            'mont_fgfn' => $fn->getMont_fgfn(),
            'mont_preleve' => $fn->getMont_preleve(),
            'solde_fgfn' => $fn->getSolde_fgfn(),
            'date_fgfn' => $fn->getDate_fgfn(),
            'code_fgfn' => $fn->getCode_fgfn(),
            'creditcode' => $fn->getCreditcode(),
            'origine_fgfn' => $fn->getOrigine_fgfn(),
			'type_fgfn' => $fn->getType_fgfn()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailFgfn $fn) {
        $data = array(
            'id_fgfn' => $fn->getId_fgfn(),
            'code_membre_pbf' => $fn->getCode_membre_pbf(),
            'mont_fgfn' => $fn->getMont_fgfn(),
            'mont_preleve' => $fn->getMont_preleve(),
            'solde_fgfn' => $fn->getSolde_fgfn(),
            'date_fgfn' => $fn->getDate_fgfn(),
            'code_fgfn' => $fn->getCode_fgfn(),
            'creditcode' => $fn->getCreditcode(),
            'origine_fgfn' => $fn->getOrigine_fgfn(),
			'type_fgfn' => $fn->getType_fgfn()
        );
        $this->getDbTable()->update($data, array('id_fgfn = ?' => $fn->getId_fgfn()));
    }

    public function delete($idfg_fn) {
        $this->getDbTable()->delete(array('id_fgfn = ?' => $idfg_fn));
    }

}
