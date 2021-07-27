<?php

class Application_Model_EuAppareilsMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Invalid table data gateway provided");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (NULL === $this->_dbTable) {
            $this->setDbTable("Application_Model_DbTable_EuAppareils");
        }
        return $this->_dbTable;
    }


    public function findByMembreAndImei($code_membre, $imei_appareil) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre = ?', $code_membre);
        $select->where('imei_appareil = ?', $imei_appareil);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
      //  $row = $resultSet->current();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppareils();
            $entry->setId($row->id)
            ->setCode_membre($row->code_membre)
            ->setMarque_appareil($row->marque_appareil)
            ->setModele_appareil($row->modele_appareil)
            ->setImei_appareil($row->imei_appareil)
            ->setNom_appareil($row->nom_appareil)
            ->setMac_appareil($row->mac_appareil)
            ->setIp_appareil($row->ip_appareil)
            ->setLock_status($row->lock_status)
            ->setUpdate_time($row->update_time);

            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre = ?', $code_membre);
   //s     $select->where('imei_appareil = ?', $imei_appareil);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        $row = $resultSet->current();
      //  $row = $resultSet->current();
      //  foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppareils();
            $entry->setId($row->id)
            ->setCode_membre($row->code_membre)
            ->setMarque_appareil($row->marque_appareil)
            ->setModele_appareil($row->modele_appareil)
            ->setImei_appareil($row->imei_appareil)
            ->setNom_appareil($row->nom_appareil)
            ->setMac_appareil($row->mac_appareil)
            ->setIp_appareil($row->ip_appareil)
            ->setLock_status($row->lock_status)
            ->setUpdate_time($row->update_time);

            $entries = $entry;
       // }
        return $entry;
    }


	public  function fetchAllByCouple($code_membre, $imei_appareil)  {
		$select = $this->getDbTable()->select();
       // $select->where("code_membre = ?", $code_membre);
       // ->where("imei_appareil = ? ", $imei_appareil);
	    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
       /* if(0 == count($resultSet)) {
            return false;
        }*/
	    foreach($resultSet as $row) {
	       $entry = new Application_Model_EuAppareils();
           $appareilsrequete = new Application_Model_EuAppareils();
           $appareilsrequete->setId($row->id)
           ->setCode_membre($row->code_membre)
           ->setMarque_appareil($row->marque_appareil)
           ->setModele_appareil($row->modele_appareil)
           ->setImei_appareil($row->imei_appareil)
           ->setNom_appareil($row->nom_appareil)
           ->setMac_appareil($row->mac_appareil)
           ->setIp_appareil($row->ip_appareil)
           ->setLock_status($row->lock_status)
           ->setUpdate_time($row->update_time);
           $entries[] = $entry;
	    }
		return $entries;
    }



    public function save(Application_Model_EuAppareils $appareils) {

           $data = array(
		//	"id" => $appareils->getId(),
			"code_membre" => $appareils->getCode_membre(),
			"marque_appareil" => $appareils->getMarque_appareil(),
			"modele_appareil" => $appareils->getModele_appareil(),
			"imei_appareil" => $appareils->getImei_appareil(),
			"nom_appareil" => $appareils->getNom_appareil(),
			"mac_appareil" => $appareils->getMac_appareil(),
			"ip_appareil" => $appareils->getIp_appareil(),
		//	"lock_status" => $appareils->getLock_status(),
			"update_time" => $appareils->getUpdate_time()

        );

        $this->getDbTable()->insert($data);
    } 


 public function update(Application_Model_EuAppareils $appareils) {
        $data = array(
		//	"id" => $appareils->getId(),
			"code_membre" => $appareils->getCode_membre(),
			"marque_appareil" => $appareils->getMarque_appareil(),
			"modele_appareil" => $appareils->getModele_appareil(),
			"imei_appareil" => $appareils->getImei_appareil(),
			"nom_appareil" => $appareils->getNom_appareil(),
			"mac_appareil" => $appareils->getMac_appareil(),
			"ip_appareil" => $appareils->getIp_appareil(),
			"lock_status" => $appareils->getLock_status(),
			"update_time" => $appareils->getUpdate_time()
    );

        $this->getDbTable()->update($data, array("code_membre = ?" => $appareils->getCode_membre()));
    } 


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAppareils();
            $entry->setId($row->id)
		->setCode_membre($row->code_membre)
		->setMarque_appareil($row->marque_appareil)
		->setModele_appareil($row->modele_appareil)
		->setImei_appareil($row->imei_appareil)
		->setNom_appareil($row->nom_appareil)
		->setMac_appareil($row->mac_appareil)
		->setIp_appareil($row->ip_appareil)
		->setLock_status($row->lock_status)
        ->setUpdate_time($row->update_time);

        $entries[] = $entry;
        }
        return $entries;
    } 

    public function find($id) {
        $result = $this->getDbTable()->find(id);
        if(0 == count($result)) {
           return false;
        }
        $appareilsrequete = new Application_Model_EuAppareils();
        $row = $result->current();
    	$appareilsrequete->setId($row->id)
		->setCode_membre($row->code_membre)
		->setMarque_appareil($row->marque_appareil)
		->setModele_appareil($row->modele_appareil)
		->setImei_appareil($row->imei_appareil)
		->setNom_appareil($row->nom_appareil)
		->setMac_appareil($row->mac_appareil)
		->setIp_appareil($row->ip_appareil)
		->setLock_status($row->lock_status)
		->setUpdate_time($row->update_time);
        return $appareilsrequete;
	}
	
	
	
	public  function findAll($id, Application_Model_EuAppareils $appareils) {
	   $result = $this->getDbTable()->find($id);
       if(count($result) == 0) {
          return false;
       }
       $row = $result->current();
	   $appareils->setId($row->id)
		         ->setCode_membre($row->code_membre)
		         ->setMarque_appareil($row->marque_appareil)
		         ->setModele_appareil($row->modele_appareil)
		         ->setImei_appareil($row->imei_appareil)
		         ->setNom_appareil($row->nom_appareil)
		         ->setMac_appareil($row->mac_appareil)
		         ->setIp_appareil($row->ip_appareil)
		         ->setLock_status($row->lock_status)
		         ->setUpdate_time($row->update_time);
	   return true;
	}
	
	
	public function updateone(Application_Model_EuAppareils $appareils) {
        $data = array(
		  "id" => $appareils->getId(),
	      "code_membre" => $appareils->getCode_membre(),
		  "marque_appareil" => $appareils->getMarque_appareil(),
		  "modele_appareil" => $appareils->getModele_appareil(),
		  "imei_appareil" => $appareils->getImei_appareil(),
		  "nom_appareil" => $appareils->getNom_appareil(),
		  "mac_appareil" => $appareils->getMac_appareil(),
		  "ip_appareil" => $appareils->getIp_appareil(),
		  "lock_status" => $appareils->getLock_status(),
		  "update_time" => $appareils->getUpdate_time()
         );
         $this->getDbTable()->update($data, array("id = ?" => $appareils->getId()));
    }
	

    public function delete($id) {
        $this->getDbTable()->delete(array("id = ?" => $id));
    }

}