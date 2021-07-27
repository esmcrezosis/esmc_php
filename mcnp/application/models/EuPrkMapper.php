<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuPrkMapper
 *
 * @author user
 */
 
 
class Application_Model_EuPrkMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPrk');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuPrk $prk) {
        $data = array(
         'id_prk' => $prk->getId_prk(),
         'code_tegc' => $prk->getCode_tegc(),
         'valeur' => $prk->getValeur(),
		 'code_type_credit' => $prk->getCode_type_credit(),
		 'type_produit'  => $prk->getType_produit()
       );
       $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPrk $prk) {
        $data = array(
          'id_prk' => $prk->getId_prk(),
          'code_tegc' => $prk->getCode_tegc(),
          'valeur' => $prk->getValeur(),
		  'code_type_credit' => $prk->getCode_type_credit(),
		  'type_produit'  => $prk->getType_produit()
        );
        $this->getDbTable()->update($data, array('id_prk = ?' => $prk->getId_prk()));
    }

    public function find($id_prk, Application_Model_EuPrk $prk) {
        $result = $this->getDbTable()->find($id_prk);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $prk->setId_prk($row->id_prk)
                ->setCode_tegc($row->code_tegc)
                ->setValeur($row->valeur)
				->setCode_type_credit($row->code_type_credit)
				->setType_produit($row->type_produit);
            return true;
        }
    }
	

    public function findByTegc($code_tegc, $valeur, Application_Model_EuPrk $prk) {
        $select = $this->getDbTable()->select();
        $select->where('code_tegc = ?', $code_tegc)->where('valeur = ?', $valeur);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $prk->setId_prk($row->id_prk)
            ->setCode_tegc($row->code_tegc)
            ->setValeur($row->valeur)
			->setCode_type_credit($row->code_type_credit)
			->setType_produit($row->type_produit);
        return true;
    }
	
	public function findByCreditTegc($code_tegc, $code_type_credit, Application_Model_EuPrk $prk) {
        $select = $this->getDbTable()->select();
        $select->where('code_tegc = ?', $code_tegc)->where('code_type_credit = ?', $code_type_credit);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $prk->setId_prk($row->id_prk)
            ->setCode_tegc($row->code_tegc)
            ->setValeur($row->valeur)
			->setCode_type_credit($row->code_type_credit)
		    ->setType_produit($row->type_produit);
        return true;
    }
	
	
	public function fetchByTegc($code_tegc)  {
	   $select = $this->getDbTable()->select();
	   $select->where('code_tegc = ?', $code_tegc);
	   $result = $this->getDbTable()->fetchAll($select);
       if (0 == count($result)) {
          return false;
       }
	   $entries = array();
       foreach ($result as $row) {
	     $entry = new Application_Model_EuPrk();
         $entry->setId_prk($row->id_prk)
               ->setCode_tegc($row->code_tegc)
               ->setValeur($row->valeur)
			   ->setCode_type_credit($row->code_type_credit)
			   ->setType_produit($row->type_produit);
         $entries[] = $entry;
	   }
	   return $entries;
	}

	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPrk();
            $entry->setId_prk($row->id_prk)
                  ->setCode_tegc($row->code_tegc)
                  ->setValeur($row->valeur)
				  ->setCode_type_credit($row->code_type_credit)
				  ->setType_produit($row->type_produit);
            $entries[] = $entry;
        }
        return $entries;
    }

	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_prk) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
    public function delete($id_prk) {
        $this->getDbTable()->delete(array('id_prk = ?' => $id_prk));
    }

}

?>
