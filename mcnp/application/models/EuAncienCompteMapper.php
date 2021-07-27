<?php

class Application_Model_EuAncienCompteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAncienCompte');
        }
        return $this->_dbTable;
    }

    public function findsolde($code_compte) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('solde'));
        $select->where('code_compte = ?', $code_compte);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['solde'];
    }

    public function save(Application_Model_EuAncienCompte $compte) {
        $data = array(
            'code_compte' => $compte->getCode_compte(),
            'code_membre' => $compte->getCode_membre(),
            'solde' => $compte->getSolde(),
            'lib_compte' => $compte->getLib_compte(),
            'date_alloc' => $compte->getDate_alloc(),
            'desactiver' => $compte->getDesactiver(),
            'code_type_compte' => $compte->getCode_type_compte(),
            'code_cat' => $compte->getCode_cat(),
            'cardprinteddate' => $compte->getCardPrintedDate(),
            'cardprintediddate' => $compte->getCardPrintedIDDate(),
            'mifarecard' => $compte->getMifareCard()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAncienCompte $compte) {
        $data = array(
            'code_membre' => $compte->getCode_membre(),
            'solde' => $compte->getSolde(),
            'lib_compte' => $compte->getLib_compte(),
            'date_alloc' => $compte->getDate_alloc(),
            'desactiver' => $compte->getDesactiver(),
            'code_type_compte' => $compte->getCode_type_compte(),
            'code_cat' => $compte->getCode_cat(),
            'cardprinteddate' => $compte->getCardPrintedDate(),
            'cardprintediddate' => $compte->getCardPrintedIDDate(),
            'mifarecard' => $compte->getMifareCard()
        );
        $this->getDbTable()->update($data, array('code_compte = ?' => $compte->getCode_compte()));
    }

    public function find($num_compte, Application_Model_EuAncienCompte $compte) {
        $result = $this->getDbTable()->find($num_compte);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $compte->setCode_compte($row->code_compte)
                ->setCode_membre($row->code_membre)
                ->setLib_compte($row->lib_compte)
                ->setSolde($row->solde)
                ->setDate_alloc($row->date_alloc)
                ->setDesactiver($row->desactiver)
                ->setCode_type_compte($row->code_type_compte)
                ->setCode_cat($row->code_cat)
                ->setCardPrintedIDDate($row->cardprintediddate)
                ->setMifareCard($row->mifarecard)
                ->setCardPrintedDate($row->cardprinteddate);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompte();
            $entry->setCode_compte($row->code_compte)
                    ->setCode_membre($row->code_membre)
                    ->setLib_compte($row->lib_compte)
                    ->setSolde($row->solde)
                    ->setDate_alloc($row->date_alloc)
                    ->setDesactiver($row->desactiver)
                    ->setCode_type_compte($row->code_type_compte)
                    ->setCode_cat($row->code_cat)
                    ->setCardPrintedIDDate($row->cardprintediddate)
                    ->setMifareCard($row->mifarecard)
                    ->setCardPrintedDate($row->cardprinteddate);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_compte) {
        $this->getDbTable()->delete(array('code_compte = ?' => $code_compte));
    }


//////////////////////////////////////////////////////////////////
    public function fetchAll2($code_membre) {
        $select = $this->getDbTable()->select();
        //$select->from($this->getDbTable());
        $select->where("code_compte LIKE '%TS%".$code_membre."'");
        $select->orwhere("code_compte LIKE '%NN-TR%".$code_membre."'");
        //$select->where("code_compte LIKE '%".$code_membre."'");
		$select->order(array("code_type_compte ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompte();
            $entry->setCode_compte($row->code_compte)
                    ->setCode_membre($row->code_membre)
                    ->setLib_compte($row->lib_compte)
                    ->setSolde($row->solde)
                    ->setDate_alloc($row->date_alloc)
                    ->setDesactiver($row->desactiver)
                    ->setCode_type_compte($row->code_type_compte)
                    ->setCode_cat($row->code_cat)
                    ->setCardPrintedIDDate($row->cardprintediddate)
                    ->setMifareCard($row->mifarecard)
	                ->setNumero_carte($row->numero_carte)
                    ->setCardPrintedDate($row->cardprinteddate);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByCompteTS($code_membre) {
		    $compte = array('NN-TPAGCRPG', 'NN-TPAGCI', 'NN-TPAGCP', 'NN-TMF107', 'NN-TMF11000', 'NN-TMFL', 'NN-TCNCS');
            $select = $this->getDbTable()->select();
            $select->from($this->getDbTable(), array("code_compte"));
		    $select->distinct();
		    $select->where("code_compte LIKE '%TS%".$code_membre."'");
		    //$select->orwhere("SUBSTRING(code_compte, 0, -21) IN (?)", $compte);
            $select->where("code_compte NOT LIKE '%TSCI%".$code_membre."'");
            $resultSet = $this->getDbTable()->fetchAll($select);
            $entries = array();
            foreach ($resultSet as $row) {
              $entry = new Application_Model_EuCompteCreditTs();
              $entry->setCode_compte($row->code_compte);
              $entries[] = $entry;
            }
            return $entries;
    }

    public function fetchAllByCompteTS2($code_membre) {
		    //$compte = array('NN-TPAGCRPG', 'NN-TPAGCI', 'NN-TPAGCP', 'NN-TMF107', 'NN-TMF11000', 'NN-TMFL', 'NN-TCNCS');
            $select = $this->getDbTable()->select();
            $select->from($this->getDbTable(), array("code_compte"));
		    $select->distinct();
		    $select->where("code_compte LIKE '%ts%".$code_membre."'");
		    //$select->orwhere("SUBSTRING(code_compte, 0, -21) IN (?)", $compte);
            $select->where("code_compte NOT LIKE '%TSCI%".$code_membre."'");
            $resultSet = $this->getDbTable()->fetchAll($select);
            $entries = array();
            foreach ($resultSet as $row) {
              $entry = new Application_Model_EuCompteCreditTs();
              $entry->setCode_compte($row->code_compte);
              $entries[] = $entry;
            }
            return $entries;
    }

	
	
}

