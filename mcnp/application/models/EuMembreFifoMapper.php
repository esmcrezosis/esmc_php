 <?php

class Application_Model_EuMembreFifoMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMembreFifo');
        }
        return $this->_dbTable;
    }
	
	

    public function find($id_membre_fifo, Application_Model_EuMembreFifo $membrefifo) {
           $table = new Application_Model_DbTable_EuMembreFifo;
           $select = $table->select();
           $select->where('id_membre_fifo = ?', $id_membre_fifo);
           $result = $table->fetchAll($select);
		
           if(0 == count($result)) {
              return;
           }
		
           $row = $result->current();
           $membrefifo->setId_membre_fifo($row->id_membre_fifo)
                      ->setCode_membre_benef($row->code_membre_benef)
                      ->setDesactiver($row->desactiver)
                      ->setMotif_desactivation($row->motif_desactivation)
                      ->setSubstituer($row->substituer)
                      ->setMotif_substitution($row->motif_substitution)
                      ->setCode_membre_substituer($row->code_membre_substituer)
			          ->setUtilisateur($row->utilisateur)
			          ->setValider($row->valider);
	}
	
	
	public function findByBeneficiaire($code_membre) {
		$table = new Application_Model_DbTable_EuMembreFifo;
        $select = $table->select();
		if(isset($code_membre) && $code_membre!="") {
             $select->where('code_membre_benef = ?', $code_membre);
		}
        $resultSet = $table->fetchAll($select);
        if(0 == count($resultSet)) {
            return false;
        }
        $row = $resultSet->current();
        $entry = new Application_Model_EuMembreFifo();
        $entry->setId_membre_fifo($row->id_membre_fifo)
              ->setCode_membre_benef($row->code_membre_benef)
              ->setDesactiver($row->desactiver)
              ->setMotif_desactivation($row->motif_desactivation)
              ->setSubstituer($row->substituer)
              ->setMotif_substitution($row->motif_substitution)
              ->setCode_membre_substituer($row->code_membre_substituer)
			  ->setUtilisateur($row->utilisateur)
			  ->setValider($row->valider);
        return $entry;
    }
    

    public function save(Application_Model_EuMembreFifo $membrefifo) {
        $data = array(
			'id_membre_fifo' => $membrefifo->getId_membre_fifo(),
            'code_membre_benef' => $membrefifo->getCode_membre_benef(),
            'desactiver' => $membrefifo->getDesactiver(),
            'motif_desactivation' => $membrefifo->getMotif_desactivation(),
            'substituer' => $membrefifo->getSubstituer(),
            'motif_substitution' => $membrefifo->getMotif_substitution(),
            'code_membre_substituer' => $membrefifo->getCode_membre_substituer(),
		    'utilisateur' => $membrefifo->getUtilisateur(),
		    'valider' => $membrefifo->getValider()
        );

        $this->getDbTable()->insert($data);
    }
    
	
	
    public function update(Application_Model_EuMembreFifo $membrefifo) {
        $data = array(
          'id_membre_fifo' => $membrefifo->getId_membre_fifo(),
          'code_membre_benef' => $membrefifo->getCode_membre_benef(),
          'desactiver' => $membrefifo->getDesactiver(),
          'motif_desactivation' => $membrefifo->getMotif_desactivation(),
          'substituer' => $membrefifo->getSubstituer(),
          'motif_substitution' => $membrefifo->getMotif_substitution(),
          'code_membre_substituer' => $membrefifo->getCode_membre_substituer(),
		  'utilisateur' => $membrefifo->getUtilisateur(),
		  'valider' => $membrefifo->getValider()
        );
        $this->getDbTable()->update($data, array('id_membre_fifo = ?' => $membrefifo->getId_membre_fifo()));
    }
	
	

    public function delete($id_membre_fifo) {
        $this->getDbTable()->delete(array('id_membre_fifo = ?' => $id_membre_fifo));
    }

    ///////////////////////////////////////////////////////////////

}

?>
