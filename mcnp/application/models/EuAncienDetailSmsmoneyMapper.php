<?php

class Application_Model_EuAncienDetailSmsmoneyMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAncienDetailSmsmoney');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuAncienDetailSmsmoney $detail) {
        $data = array(
            'id_detail_smsmoney' => $detail->getId_detail_smsmoney(),
            'num_bon' => $detail->getNum_bon(),
            'code_membre' => $detail->getCode_membre(),
            'code_membre_dist' => $detail->getCode_membre_dist(),
            'date_allocation' => $detail->getDate_allocation(),
            'id_utilisateur' => $detail->getId_utilisateur(),
            'creditcode' => $detail->getCreditcode(),
            'mont_sms' => $detail->getMont_sms(),
            'mont_vendu' => $detail->getMont_vendu(),
            'mont_regle' => $detail->getMont_regle(),
            'solde_sms' => $detail->getSolde_sms(),
            'type_sms' => $detail->getType_sms(),
            'origine_sms' => $detail->getOrigine_sms()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAncienDetailSmsmoney $detail) {
        $data = array(
            'id_detail_smsmoney' => $detail->getId_detail_smsmoney(),
            'num_bon' => $detail->getNum_bon(),
            'code_membre' => $detail->getCode_membre(),
            'code_membre_dist' => $detail->getCode_membre_dist(),
            'date_allocation' => $detail->getDate_allocation(),
            'id_utilisateur' => $detail->getId_utilisateur(),
            'creditcode' => $detail->getCreditcode(),
            'mont_sms' => $detail->getMont_sms(),
            'mont_vendu' => $detail->getMont_vendu(),
            'mont_regle' => $detail->getMont_regle(),
            'type_sms' => $detail->getType_sms(),
            'solde_sms' => $detail->getSolde_sms(),
            'origine_sms' => $detail->getOrigine_sms()
        );
        $this->getDbTable()->update($data, array('id_detail_smsmoney = ?' => $detail->getId_detail_smsmoney()));
    }

    public function find($id_detail_smsmoney, Application_Model_EuAncienDetailSmsmoney $detail) {
        $result = $this->getDbTable()->find($id_detail_smsmoney);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $detail->setId_detail_smsmoney($row->id_detail_smsmoney)
                    ->setNum_bon($row->num_bon)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_dist($row->code_membre_dist)
                    ->setDate_allocation($row->date_allocation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setCreditcode($row->creditcode)
                    ->setMont_sms($row->mont_sms)
                    ->setMont_vendu($row->mont_vendu)
                    ->setMont_regle($row->mont_regle)
                    ->setSolde_sms($row->solde_sms)
                    ->setType_sms($row->type_sms)
                    ->setOrigine_sms($row->origine_sms);
            return true;
        }
    }
    
	public function findSMSByMembre($code_membre_dist) {
	    $table = new Application_Model_DbTable_EuAncienDetailSmsmoney();
        $select = $table->select();
        $select->where('code_membre_dist LIKE ?', $code_membre_dist)
               ->where('origine_sms LIKE ?','MF')
               ->where('solde_sms > ?', 0);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienDetailSmsmoney();
            $entry->setId_detail_smsmoney($row->id_detail_smsmoney)
                  ->setNum_bon($row->num_bon)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_dist($row->code_membre_dist)
                  ->setDate_allocation($row->date_allocation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setCreditcode($row->creditcode)
                  ->setMont_sms($row->mont_sms)
                  ->setMont_vendu($row->mont_vendu)
                  ->setMont_regle($row->mont_regle)
                  ->setSolde_sms($row->solde_sms)
                  ->setType_sms($row->type_sms)
                  ->setOrigine_sms($row->origine_sms)
		    ;
			$entries[] = $entry;
        }
        return $entries;
	}
	
	
	public function findSum($code_membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde_sms) as somme'));
		$select->where('code_membre_dist LIKE ?', $code_membre);
		$select->where('origine_sms LIKE','MF');
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['somme'];
    }
	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienDetailSmsmoney();
            $entry->setId_detail_smsmoney($row->id_detail_smsmoney)
                    ->setNum_bon($row->num_bon)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_dist($row->code_membre_dist)
                    ->setDate_allocation($row->date_allocation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setCreditcode($row->creditcode)
                    ->setMont_sms($row->mont_sms)
                    ->setMont_vendu($row->mont_vendu)
                    ->setMont_regle($row->mont_regle)
                    ->setSolde_sms($row->solde_sms)
                    ->setType_sms($row->type_sms)
                    ->setOrigine_sms($row->origine_sms);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	public function findcumul($code_membre,$type_bnp) {
	       $table = new Application_Model_DbTable_EuAncienDetailSmsmoney();
           $select = $table->select();
		   //$select->from(array('eu_detail_smsmoney'), array('SUM(solde_sms) as solde'));
		  //$select->where('code_membre LIKE ?',$code_membre);
		  //$select->where('code_type_nn LIKE ?',$type_bnp);
		  //$result = $table->fetchAll($select);
		    //foreach ($result as $row) {
		       //$solde = $row->solde;
		    //}
			//return $solde;
			
		   $select->from(array('eu_detail_smsmoney'), array('code_membre', 'type_sms', 'solde' => 'SUM(solde_sms)'));
           $select->group(array('code_membre', 'type_sms'));
		   if(isset($code_membre) && $code_membre!=" "){        
		   $select->having('code_membre LIKE ?', $code_membre);}
		   if(isset($type_bnp) && $type_bnp!=" "){		
		   $select->having('type_sms LIKE ?', $type_bnp);}
           $result = $table->fetchRow($select);
		   $row = $result;
		   return $row->solde;
			
	
	}
	
	public function findSMSByCompte($membre,$type_bnp) {
	    $table = new Application_Model_DbTable_EuAncienDetailSmsmoney();
        $select = $table->select();
        $select->where('code_membre LIKE ?', $membre)
               ->where('type_sms LIKE ?', $type_bnp)
               ->where('solde_sms > ?', 0);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienDetailSmsmoney();
            $entry->setId_detail_smsmoney($row->id_detail_smsmoney)
                  ->setNum_bon($row->num_bon)
                  ->setCode_membre($row->code_membre)
                  ->setCode_membre_dist($row->code_membre_dist)
                  ->setDate_allocation($row->date_allocation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setCreditcode($row->creditcode)
                  ->setMont_sms($row->mont_sms)
                  ->setMont_vendu($row->mont_vendu)
                  ->setMont_regle($row->mont_regle)
                  ->setSolde_sms($row->solde_sms)
                  ->setType_sms($row->type_sms)
                  ->setOrigine_sms($row->origine_sms)
		    ;
			$entries[] = $entry;
        }
        return $entries;
	}
	
    public function delete($id_detail_smsmoney) {
        $this->getDbTable()->delete(array('id_detail_smsmoney = ?' => $id_detail_smsmoney));
    }



/////////////////////////////////////////////////////////////////////////////////

    public function fetchAll2($code_membre, $origine_sms) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_dist = ?', $code_membre)
				->where('origine_sms = ?', $origine_sms)
                ->order('date_allocation', 'DESC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienDetailSmsmoney();
            $entry->setId_detail_smsmoney($row->id_detail_smsmoney)
                    ->setNum_bon($row->num_bon)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_dist($row->code_membre_dist)
                    ->setDate_allocation($row->date_allocation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setCreditcode($row->creditcode)
                    ->setMont_sms($row->mont_sms)
                    ->setMont_vendu($row->mont_vendu)
                    ->setMont_regle($row->mont_regle)
                    ->setSolde_sms($row->solde_sms)
                    ->setType_sms($row->type_sms)
                    ->setOrigine_sms($row->origine_sms);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function findByOrigineSmsSolde($code_membre, $origine_sms, Application_Model_EuAncienDetailSmsmoney $DetailSmsmoney) {
        $table = new Application_Model_DbTable_EuAncienDetailSmsmoney();
        $select = $table->select();
		$select->from(array('eu_detail_smsmoney'), array('code_membre_dist', 'origine_sms', 'solde' => 'SUM(solde_sms)'));
        $select->group(array('code_membre_dist', 'origine_sms'));
		if(isset($code_membre) && $code_membre!=""){        
		$select->having('code_membre_dist LIKE ?', $code_membre);}
		if(isset($origine_sms) && $origine_sms!=""){		
		$select->having('origine_sms LIKE ?', $origine_sms);}
        $result = $table->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
        $DetailSmsmoney->setOrigine_sms($row->origine_sms)
                ->setSolde_sms($row->solde)
                ->setCode_membre_dist($row->code_membre_dist);
        return true;
    }


    public function findByCodeMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_dist = ?', $code_membre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienDetailSmsmoney();
            $entry->setId_detail_smsmoney($row->id_detail_smsmoney)
                    ->setNum_bon($row->num_bon)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_dist($row->code_membre_dist)
                    ->setDate_allocation($row->date_allocation)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setCreditcode($row->creditcode)
                    ->setMont_sms($row->mont_sms)
                    ->setMont_vendu($row->mont_vendu)
                    ->setMont_regle($row->mont_regle)
                    ->setSolde_sms($row->solde_sms)
                    ->setType_sms($row->type_sms)
                    ->setOrigine_sms($row->origine_sms);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_smsmoney) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}