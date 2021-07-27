 <?php

class Application_Model_EuQrauthMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuQrauth');
        }
        return $this->_dbTable;
    }

	

    public function find($id_requete) {
        $result = $this->getDbTable()->find($id_requete);
        if(0 == count($result)) {
           return false;
        }
        $qrauthrequete = new Application_Model_Qrauth();
        $row = $result->current();
        $qrauthrequete->setId_requete($row->id_requete)
                ->setCode_membre_client($row->code_membre_client)
		        ->setCode_operateur($row->code_operateur)
                ->setCode_secret_client($row->code_secret_client)
                ->setDaterequete($row->daterequete)
                ->setId_requete($row->id_requete);

      //  return $qrauthrequete;
	}
	


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Qrauth();
            $entry->setId_requete($row->id_requete)
            ->setCode_membre_client($row->code_membre_client)
            ->setCode_operateur($row->code_operateur)
            ->setCode_secret_client($row->code_secret_client)
            ->setDaterequete($row->daterequete)
            ->setId_requete($row->id_requete);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	

	
	public  function fetchAllByCouple($code_operateur, $code_membre_client)  {
		$select = $this->getDbTable()->select();
	    $select->where("code_operateur = ? ", $code_operateur)->where("code_membre_client = ? ", $code_membre_client);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_Qrauth();
		   $entry->setId_requete($row->id_requete)
           ->setCode_membre_client($row->code_membre_client)
           ->setCode_operateur($row->code_operateur)
           ->setCode_secret_client($row->code_secret_client)
           ->setDaterequete($row->daterequete)
           ->setId_requete($row->id_requete);
           $entries[] = $entry;
		  
	    }
		return $entries;
	}
	
	


    

    public function save(Application_Model_Qrauth $qrauthrequete) {
        $data = array(
		    'id_requete' => $qrauthrequete->getId_requete(),
			'code_membre_client' => $qrauthrequete->getCode_membre_client(),
            'code_operateur' => $qrauthrequete->getCode_operateur(),
            'code_secret_client' => $qrauthrequete->getCode_secret_client(),
            'daterequete' => $qrauthrequete->getDaterequete()
         //   'id_requete' => $qrauthrequete->getPrix_unitaire()

        );

        $this->getDbTable()->insert($data);
    }
    
	
	
    public function update(Application_Model_Qrauth $qrauthrequete) {
        $data = array(
            'id_requete' => $qrauthrequete->getId_requete(),
			'code_membre_client' => $qrauthrequete->getCode_membre_client(),
            'code_operateur' => $qrauthrequete->getCode_operateur(),
            'code_secret_client' => $qrauthrequete->getCode_secret_client(),
            'daterequete' => $qrauthrequete->getDaterequete()
        );
        $this->getDbTable()->update($data, array('id_requete = ?' => $qrauthrequete->id_requete()));
    }

	

    public function delete($id_requete) {
        $this->getDbTable()->delete(array('id_requete = ?' => $id_requete));
    }

    ///////////////////////////////////////////////////////////////

}

?>
