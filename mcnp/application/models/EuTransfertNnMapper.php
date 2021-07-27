<?php

class Application_Model_EuTransfertNnMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTransfertNn');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuTransfertNn $transfert) {
        $data = array(
            'id_transfert_nn' => $transfert->getId_transfert_nn,
            'date_transfert'  =>  $transfert->getDate_transfert,
            'mont_transfert'  =>  $transfert->getCode_membre,
            'mont_vendu'      =>  $transfert->getMont_sms,
            'solde_transfert' =>  $transfert->getType_sms,
            'type_reglement' =>   $transfert->getMont_vendu,
            'type_transfert' =>   $transfert->getSolde_sms,
            'code_compte_dist' => $transfert->getCode_compte_dist,
            'code_compte_transfert' => $transfert->getCode_compte_transfert,
            'code_type_nn' => $transfert->getCode_type_nn,
            'mont_regle' => $transfert->getMont_regle,
			'restant_du' => $transfert->getRestant_du,
			'code_document' => $transfert->getCode_document,
			'url_document' => $transfert->getUrl_document
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTransfertNn $transfert) {
        $data = array(
         'id_transfert_nn' => $transfert->getId_transfert_nn,
         'date_transfert'  =>  $transfert->getDate_transfert,
         'mont_transfert'  =>  $transfert->getCode_membre,
         'mont_vendu'      =>  $transfert->getMont_sms,
         'solde_transfert' =>  $transfert->getType_sms,
         'type_reglement' =>   $transfert->getMont_vendu,
         'type_transfert' =>   $transfert->getSolde_sms,
         'code_compte_dist' => $transfert->getCode_compte_dist,
         'code_compte_transfert' => $transfert->getCode_compte_transfert,
         'code_type_nn' => $transfert->getCode_type_nn,
         'mont_regle' => $transfert->getMont_regle,
	     'restant_du' => $transfert->getRestant_du,
	     'code_document' => $transfert->getCode_document,
	     'url_document' => $transfert->getUrl_document
        );
        $this->getDbTable()->update($data, array('id_transfert_nn = ?' => $transfert->getId_transfert_nn()));
    }

    public function find($id_transfert_nn, Application_Model_EuTransfertNn $transfert) {
        $result = $this->getDbTable()->find($id_transfert_nn);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $transfert->setId_transfert_nn($row->id_transfert_nn)
                      ->setDate_transfert($row->date_transfert)
                      ->setMont_transfert($row->mont_transfert)
                      ->setMont_vendu($row->mont_vendu)
                      ->setSolde_transfert($row->solde_transfert)
                      ->setType_reglement($row->type_reglement)
                      ->setType_transfert($row->type_transfert)
                      ->setCode_compte_dist($row->code_compte_dist)
                      ->setCode_compte_transfert($row->code_compte_transfert)
                      ->setCode_type_nn($row->code_type_nn)
                      ->setMont_regle($row->mont_regle)
                      ->setRestant_du($row->restant_du)
                      ->setCode_document($row->code_document)
					  ->setUrl_document($row->url_document)
					  ;
            return true;
        }
    }
	
	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTransfertNn();
            $entry->setId_transfert_nn($row->id_transfert_nn)
                      ->setDate_transfert($row->date_transfert)
                      ->setMont_transfert($row->mont_transfert)
                      ->setMont_vendu($row->mont_vendu)
                      ->setSolde_transfert($row->solde_transfert)
                      ->setType_reglement($row->type_reglement)
                      ->setType_transfert($row->type_transfert)
                      ->setCode_compte_dist($row->code_compte_dist)
                      ->setCode_compte_transfert($row->code_compte_transfert)
                      ->setCode_type_nn($row->code_type_nn)
                      ->setMont_regle($row->mont_regle)
                      ->setRestant_du($row->restant_du)
                      ->setCode_document($row->code_document)
					  ->setUrl_document($row->url_document);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	public function findcumultransfert($code_compte,$type_bnp) {
	       $table = new Application_Model_DbTable_EuTransfertNn();
           $select = $table->select();
		   //$select->from($table,array('SUM(solde_transfert) as solde'));
		   //$select->where('code_compte_dist LIKE ?',$code_compte);
		   //$select->where('code_type_nn LIKE ?',$type_bnp);
		   //$result = $table->fetchAll($select);
		   //$row = $result->current();
		   //return $row->solde;
		   
		   $select->from(array('eu_transfert_nn'), array('code_compte_dist', 'code_type_nn', 'solde' => 'SUM(solde_transfert)'));
           $select->group(array('code_compte_dist', 'code_type_nn'));
		   if(isset($code_compte) && $code_compte!=" "){        
		   $select->having('code_compte_dist LIKE ?', $code_compte);}
		   if(isset($type_bnp) && $type_bnp!=" "){		
		   $select->having('code_type_nn LIKE ?',$type_bnp);}
           $result = $table->fetchRow($select);
		   $row = $result;
		   return $row->solde;
		   
		   
	}
	
	
	public function findTransfertByCompte($code_compte,$type_bnp) {
	    $table = new Application_Model_DbTable_EuTransfertNn();
        $select = $table->select();
        $select->where('code_compte_dist LIKE ?', $code_compte)
               ->where('code_type_nn LIKE ?', $type_bnp)
               ->where('solde_transfert > ?', 0);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuTransfertNn();
            $entry->setId_transfert_nn($row->id_transfert_nn)
                  ->setDate_transfert($row->date_transfert)
                  ->setMont_transfert($row->mont_transfert)
                  ->setMont_vendu($row->mont_vendu)
                  ->setSolde_transfert($row->solde_transfert)
                  ->setType_reglement($row->type_reglement)
                  ->setType_transfert($row->type_transfert)
                  ->setCode_compte_dist($row->code_compte_dist)
                  ->setCode_compte_transfert($row->code_compte_transfert)
                  ->setCode_type_nn($row->code_type_nn)
                  ->setMont_regle($row->mont_regle)
                  ->setRestant_du($row->restant_du)
                  ->setCode_document($row->code_document)
				  ->setUrl_document($row->url_document)
		    ;
			$entries[] = $entry;
        }
        return $entries;
	}
	
	
	
	
    public function delete($id_transfert_nn) {
        $this->getDbTable()->delete(array('id_transfert_nn = ?' => $id_transfert_nn));
    }



/////////////////////////////////////////////////////////////////////////////////


    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_transfert_nn) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }




    public function findByTypeNNSmsSolde($code_comte, $code_type_nn, Application_Model_EuTransfertNn $TransfertNn) {
        $table = new Application_Model_DbTable_EuTransfertNn();
        $select = $table->select();
		$select->from(array('eu_transfert_nn'), array('code_compte_dist', 'code_type_nn', 'solde' => 'SUM(solde_transfert)'));
        $select->group(array('code_compte_dist', 'code_type_nn'));
		if(isset($code_compte) && $code_compte!=""){        
		$select->having("code_compte_dist LIKE '".$code_compte."'");}
		if(isset($code_type_nn) && $code_type_nn!=""){		
		$select->having('code_type_nn LIKE ?', $code_type_nn);}
        $result = $table->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
        $TransfertNn->setCode_type_nn($row->code_type_nn)
                ->setSolde_transfert($row->solde)
                ->setCode_compte_dist($row->code_compte_dist);
        return true;
    }


    public function fetchAll2($code_membre, $code_type_nn) {
        $select = $this->getDbTable()->select();
        $select->where("code_compte_dist LIKE '%".$code_membre."%'")
				->where('code_type_nn = ?', $code_type_nn)
                ->order('date_transfert', 'DESC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTransfertNn();
            $entry->setId_transfert_nn($row->id_transfert_nn)
                  ->setDate_transfert($row->date_transfert)
                  ->setMont_transfert($row->mont_transfert)
                  ->setMont_vendu($row->mont_vendu)
                  ->setSolde_transfert($row->solde_transfert)
                  ->setType_reglement($row->type_reglement)
                  ->setType_transfert($row->type_transfert)
                  ->setCode_compte_dist($row->code_compte_dist)
                  ->setCode_compte_transfert($row->code_compte_transfert)
                  ->setCode_type_nn($row->code_type_nn)
                  ->setMont_regle($row->mont_regle)
                  ->setRestant_du($row->restant_du)
                  ->setCode_document($row->code_document)
				  ->setUrl_document($row->url_document)
				  ;
            $entries[] = $entry;
        }
        return $entries;
    }


}