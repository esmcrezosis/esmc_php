<?php 
class Application_Model_EuDetailMscmMapper {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if(!$dbTable instanceof Zend_Db_Table_Abstract) {
           throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if(NULL === $this->_dbTable) {
          $this->setDbTable('Application_Model_DbTable_EuDetailMscm');
        }
        return $this->_dbTable;
    }

    public function find($id_detail_mscm, Application_Model_EuDetailMscm $dmscm) {
        $result = $this->getDbTable()->find($acheteur_id);
        if(count($result) == 0) {
           return false;
        }
        $row = $result->current();
        $dmscm->setId_detail_mscm($row->id_detail_mscm)
              ->setId_mscm($row->id_mscm)
              ->setBon_neutre_code($row->bon_neutre_code)
              ->setMontant_utilise($row->montant_utilise)
              ->setId_souscription($row->id_souscription)
              ->setCode_membre($row->code_membre)
              ->setDate_mscm($row->date_mscm);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailMscm();
            $entry->setId_detail_mscm($row->id_detail_mscm)
                  ->setId_mscm($row->id_mscm)
                  ->setBon_neutre_code($row->bon_neutre_code)
                  ->setMontant_utilise($row->montant_utilise)
                  ->setId_souscription($row->id_souscription)
                  ->setCode_membre($row->code_membre)
                  ->setDate_mscm($row->date_mscm);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_mscm) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	public function fetchAllByMembre($membre) {
	   $tabela = new Application_Model_DbTable_EuDetailMscm();
	   $select = $tabela->select();
	   $select->where('code_membre = ?',$membre);   
	   $result = $tabela->fetchAll($select);
       if(count($result) == 0) {
         return NULL;
       }
	   $entries = array();
       foreach($result as $row) {
          $entry = new Application_Model_EuDetailMscm();
          $entry->setId_detail_mscm($row->id_detail_mscm)
                ->setId_mscm($row->id_mscm)
			    ->setBon_neutre_code($row->bon_neutre_code)
			    ->setMontant_utilise($row->montant_utilise)
			    ->setId_souscription($row->id_souscription)
			    ->setCode_membre($row->code_membre)
			    ->setDate_mscm($row->date_mscm);
		   $entries[] = $entry;
	    }
		return $entries;
	}
	
	
    public function save(Application_Model_EuDetailMscm $dmscm) {
        $data = array(
            'id_detail_mscm' => $dmscm->getId_detail_mscm(),
            'id_mscm' => $dmscm->getId_mscm(),
            'bon_neutre_code' => $dmscm->getBon_neutre_code(),
            'montant_utilise' => $dmscm->getMontant_utilise(),
            'id_souscription' => $dmscm->getId_souscription(),
            'code_membre' => $dmscm->getCode_membre(),
            'date_mscm' => $dmscm->getDate_mscm()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailMscm $dmscm) {
        $data = array(
          'id_detail_mscm' => $dmscm->getId_detail_mscm(),
          'id_mscm' => $dmscm->getId_mscm(),
          'bon_neutre_code' => $dmscm->getBon_neutre_code(),
          'montant_utilise' => $dmscm->getMontant_utilise(),
          'id_souscription' => $dmscm->getId_souscription(),
          'code_membre' => $dmscm->getCode_membre(),
          'date_mscm' => $dmscm->getDate_mscm()
        );
        $this->getDbTable()->update($data, array('id_detail_mscm = ?' => $dmscm->getId_detail_mscm()));
    }

	
    public function delete($id_detail_mscm) {
        $this->getDbTable()->delete(array('id_detail_mscm = ?' => $id_detail_mscm));
    }
    

}


?>
