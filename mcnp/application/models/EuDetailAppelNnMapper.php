
<?php
class Application_Model_EuDetailAppelNnMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuDetailAppelNn');
        }
        return $this->_dbTable;
    }
	
	
	
	public function find($id_detail_appel_nn, Application_Model_EuDetailAppelNn $detail_appel_nn) {
       $result = $this->getDbTable()->find($id_detail_appel_nn);
       if (0 == count($result)) {
           return false;
       }
       $row = $result->current();
       $detail_appel_nn->setId_detail_appel_nn($row->id_detail_appel_nn)
                       ->setId_appel_nn($row->id_appel_nn)
			           ->setCode_membre($row->code_membre)
			           ->setDate_apport($row->date_apport)
			           ->setHeure_apport($row->heure_apport)
			           ->setMontant_apport($row->montant_apport)
			           ->setCode_compte($row->code_compte)
			           ->setId_utilisateur($row->id_utilisateur)
					   ->setPayer($row->payer)
	    ;
		return true;
	
	}
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuDetailAppelNn();
           $entry->setId_detail_appel_nn($row->id_detail_appel_nn)
                 ->setId_appel_nn($row->id_appel_nn)
			     ->setCode_membre($row->code_membre)
			     ->setDate_apport($row->date_apport)
			     ->setHeure_apport($row->heure_apport)
			     ->setMontant_apport($row->montant_apport)
			     ->setCode_compte($row->code_compte)
			     ->setId_utilisateur($row->id_utilisateur)
				 ->setPayer($row->payer);
           $entries[] = $entry;
        }
        return $entries;
    }
    
	public function findrepbycompte($id_proposition) {
	        $tabela = new Application_Model_DbTable_EuDetailAppelNn();
	        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		    $select->setIntegrityCheck(false)
                   ->join('eu_appel_nn', 'eu_appel_nn.id_appel_nn = eu_detail_appel_nn.id_appel_nn',array('eu_detail_appel_nn.*','eu_appel_nn.id_proposition'))
				   ->where('eu_appel_nn.id_proposition = ?',$id_proposition)
				   ->where('eu_detail_appel_nn.payer = ?',0);
	        $result = $tabela->fetchAll($select);
            if (count($result) == 0) {
               return NULL;
            }
            $entries = array();
            foreach ($result as $row) {
            $entry = new Application_Model_EuDetailAppelNn();
            $entry->setId_detail_appel_nn($row->id_detail_appel_nn)
                  ->setId_appel_nn($row->id_appel_nn)
			      ->setCode_membre($row->code_membre)
			      ->setDate_apport($row->date_apport)
			      ->setHeure_apport($row->heure_apport)
			      ->setMontant_apport($row->montant_apport)
			      ->setCode_compte($row->code_compte)
			      ->setId_utilisateur($row->id_utilisateur)
				  ->setPayer($row->payer);
			$entries[] = $entry;
        }
        return $entries;
	}
	
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_appel_nn) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
    public function save(Application_Model_EuDetailAppelNn $detailappelnn) {
        $data = array(
         'id_detail_appel_nn' => $detailappelnn->getId_detail_appel_nn(),
         'id_appel_nn' => $detailappelnn->getId_appel_nn(),
		 'code_membre' => $detailappelnn->getCode_membre(),
		 'date_apport' => $detailappelnn->getDate_apport(),
		 'heure_apport' => $detailappelnn->getHeure_apport(),
		 'montant_apport' => $detailappelnn->getMontant_apport(),
		 'code_compte' => $detailappelnn->getCode_compte(),
		 'id_utilisateur' => $detailappelnn->getId_utilisateur(),
		 'payer' => $detailappelnn->getPayer()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailAppelNn $detailappelnn) {
        $data = array(
          'id_detail_appel_nn' => $detailappelnn->getId_detail_appel_nn(),
          'id_appel_nn' => $detailappelnn->getId_appel_nn(),
		  'code_membre' => $detailappelnn->getCode_membre(),
		  'date_apport' => $detailappelnn->getDate_apport(),
		  'heure_apport' => $detailappelnn->getHeure_apport(),
		  'montant_apport' => $detailappelnn->getMontant_apport(),
		  'code_compte' => $detailappelnn->getCode_compte(),
		  'id_utilisateur' => $detailappelnn->getId_utilisateur(),
		  'payer' => $detailappelnn->getPayer()
        );
        $this->getDbTable()->update($data, array('id_detail_appel_nn = ?' => $detailappelnn->getId_detail_appel_nn()));
    }

	
    public function delete($id_detail_appel_nn) {
	
           $this->getDbTable()->delete(array('id_detail_appel_nn = ?' => $id_detail_appel_nn));
		   
    }
	
	public function fetchAll2($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuDetailAppelNn();
           $entry->setId_detail_appel_nn($row->id_detail_appel_nn)
                 ->setId_appel_nn($row->id_appel_nn)
			     ->setCode_membre($row->code_membre)
			     ->setDate_apport($row->date_apport)
			     ->setHeure_apport($row->heure_apport)
			     ->setMontant_apport($row->montant_apport)
			     ->setCode_compte($row->code_compte)
			     ->setId_utilisateur($row->id_utilisateur)
				 ->setPayer($row->payer);
           $entries[] = $entry;
        }
        return $entries;
    }
    
	
	public function fetchAll3($code_compte) {
        $select = $this->getDbTable()->select();
		$select->where("code_compte = ? ", $code_compte);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = new Application_Model_EuDetailAppelNn();
           $entry->setId_detail_appel_nn($row->id_detail_appel_nn)
                 ->setId_appel_nn($row->id_appel_nn)
			     ->setCode_membre($row->code_membre)
			     ->setDate_apport($row->date_apport)
			     ->setHeure_apport($row->heure_apport)
			     ->setMontant_apport($row->montant_apport)
			     ->setCode_compte($row->code_compte)
			     ->setId_utilisateur($row->id_utilisateur)
				 ->setPayer($row->payer);
           $entries[] = $entry;
        }
        return $entries;
    }
	
}		
?>	
	
	
	
	
	
	
	
	
	