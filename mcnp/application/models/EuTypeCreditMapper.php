<?php

class Application_Model_EuTypeCreditMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTypeCredit');
        }
        return $this->_dbTable;
    }

	
	public function save(Application_Model_EuTypeCredit $type_credit) {
        $data = array(
            'code_type_credit' => $type_credit->getCode_type_credit(),
            'lib_type_credit' => $type_credit->getLib_type_credit(),
            'code_cat_produit' => $type_credit->getCode_cat_produit(),
			'quotar' => $type_credit->getQuotar(),
			'quotanr' => $type_credit->getQuotanr(),
			'prk' => $type_credit->getPrk(),
			'type_produit' => $type_credit->getType_produit()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTypeCredit $type_credit) {
        $data = array(
            'code_type_credit' => $type_credit->getCode_type_credit(),
            'lib_type_credit' => $type_credit->getLib_type_credit(),
            'code_cat_produit' => $type_credit->getCode_cat_produit(),
			'quotar' => $type_credit->getQuotar(),
			'quotanr' => $type_credit->getQuotanr(),
			'prk' => $type_credit->getPrk(),
			'type_produit' => $type_credit->getType_produit()
        );

        $this->getDbTable()->update($data, array('code_type_credit = ?' => $type_credit->getCode_type_credit()));
    }

    public function find($code_type_credit, Application_Model_EuTypeCredit $type_credit) {
        $result = $this->getDbTable()->find($code_type_credit);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $type_credit->setCode_type_credit($row->code_type_credit)
                    ->setLib_type_credit($row->lib_type_credit)
                    ->setCode_cat_produit($row->code_cat_produit)
					->setQuotar($row->quotar)
					->setQuotanr($row->quotanr)
					->setPrk($row->prk)
					->setType_produit($row->type_produit);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTypeCredit();
            $entry->setCode_type_credit($row->code_type_credit)
                  ->setLib_type_credit($row->lib_type_credit)
                  ->setCode_cat_produit($row->code_cat_produit)
			      ->setQuotar($row->quotar)
				  ->setQuotanr($row->quotanr)
				  ->setPrk($row->prk)
				  ->setType_produit($row->type_produit);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_type_credit) {
        $this->getDbTable()->delete(array('code_type_credit = ?' => $code_type_credit));
    }

}

