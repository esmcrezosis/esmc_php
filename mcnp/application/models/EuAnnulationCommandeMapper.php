    <?php

 
class Application_Model_EuAnnulationCommandeMapper  {

    //put your code here
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if(is_string($dbTable)) {
           $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if(NULL === $this->_dbTable) {
           $this->setDbTable('Application_Model_DbTable_EuAnnulationCommande');
        }
        return $this->_dbTable;
    }

	
    public function save(Application_Model_EuAnnulationCommande $annulation_commande) {
      $data = array(
	    'id_annulation_commande' => $annulation_commande->getId_annulation_commande(),
        'code_commande' => $annulation_commande->getCode_commande(),
        'id_detail' => $annulation_commande->getId_detail(),
	    'montant' => $annulation_commande->getMontant()
      );
      $this->getDbTable()->insert($data);
    }
	

    public function update(Application_Model_EuAnnulationCommande $annulation_commande) {
        $data = array(
		  'id_annulation_commande' => $annulation_commande->getId_annulation_commande(),
          'code_commande' => $annulation_commande->getCode_commande(),
          'id_detail' => $annulation_commande->getId_detail(),
	      'montant' => $annulation_commande->getMontant()
        );
        $this->getDbTable()->update($data, array('id_annulation_commande = ?' => $annulation_commande->getId_annulation_commande()));
    }
	
	

    public function find($id_annulation_commande, Application_Model_EuAnnulationCommande $annulation_commande) {
        $result = $this->getDbTable()->find($id_annulation_commande);
        if(0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $annulation_commande->setId_annulation_commande($row->id_annulation_commande)
		        ->setCode_commande($row->code_commande)
                ->setId_detail($row->id_detail)
				->setMontant($row->montant);
        return true;
    }
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuAnnulationCommande();
            $entry->setId_annulation_commande($row->id_annulation_commande)
			      ->setCode_commande($row->code_commande)
                  ->setId_detail($row->id_detail)
				  ->setMontant($row->montant);
            $entries[] = $entry;
        }
        return $entries;
    }
	

    public function delete($id_annulation_commande) {
      $this->getDbTable()->delete(array('id_annulation_commande = ?' => $id_annulation_commande));
    }

        
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_annulation_commande) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }


}

?>
