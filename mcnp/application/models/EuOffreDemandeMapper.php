<?php

class Application_Model_EuOffreDemandeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuOffreDemande');
        }
        return $this->_dbTable;
    }

    public function find($id_offre_demande, Application_Model_EuOffreDemande $offre_demande) {
        $result = $this->getDbTable()->find($id_offre_demande);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $offre_demande->setId_offre_demande($row->id_offre_demande)
                 ->setType_offre_demande($row->type_offre_demande)
                 ->setDate_offre_demande($row->date_offre_demande)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setCode_cat($row->code_cat)
                 ->setType_credit_of($row->type_credit_of)
                 ->setType_credit_de($row->type_credit_de)
                 ->setNum_offre_demande($row->num_offre_demande)
				 ->setId_credit($row->id_credit);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemande();
            $entry->setId_offre_demande($row->id_offre_demande)
                 ->setType_offre_demande($row->type_offre_demande)
                 ->setDate_offre_demande($row->date_offre_demande)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setCode_cat($row->code_cat)
                 ->setType_credit_of($row->type_credit_of)
                 ->setType_credit_de($row->type_credit_de)
                 ->setNum_offre_demande($row->num_offre_demande)
				 ->setId_credit($row->id_credit);
            $entries[] = $entry;
        }
        return $entries;
    }
    
	
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_offre_demande) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function save(Application_Model_EuOffreDemande $offre_demande) {
        $data = array(
            'id_offre_demande' => $offre_demande->getId_offre_demande(),
            'type_offre_demande' => $offre_demande->getType_offre_demande(),
            'date_offre_demande' => $offre_demande->getDate_offre_demande(),
            'code_membre' => $offre_demande->getCode_membre(),
            'code_compte' => $offre_demande->getCode_compte(),
            'code_cat' => $offre_demande->getCode_cat(),
            'type_credit_of' => $offre_demande->getType_credit_of(),
            'type_credit_de' => $offre_demande->getType_credit_de(),
            'num_offre_demande' => $offre_demande->getNum_offre_demande(),
            'id_credit' => $offre_demande->getId_credit()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuOffreDemande $offre_demande) {
        $data = array(
            'id_offre_demande' => $offre_demande->getId_offre_demande(),
            'type_offre_demande' => $offre_demande->getType_offre_demande(),
            'date_offre_demande' => $offre_demande->getDate_offre_demande(),
            'code_membre' => $offre_demande->getCode_membre(),
            'code_compte' => $offre_demande->getCode_compte(),
            'code_cat' => $offre_demande->getCode_cat(),
            'type_credit_of' => $offre_demande->getType_credit_of(),
            'type_credit_de' => $offre_demande->getType_credit_de(),
            'num_offre_demande' => $offre_demande->getNum_offre_demande(),
            'id_credit' => $offre_demande->getId_credit()
        );
        $this->getDbTable()->update($data, array('id_offre_demande = ?' => $offre_demande->getId_offre_demande()));
    }

    public function delete($id_offre_demande) {
        $this->getDbTable()->delete(array('id_offre_demande = ?' => $id_offre_demande));
    }


    public function fetchAllByCompte($code_compte) {
        $select = $this->getDbTable()->select();
		$select->where("code_compte = ? ", $code_compte);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemande();
            $entry->setId_offre_demande($row->id_offre_demande)
                 ->setType_offre_demande($row->type_offre_demande)
                 ->setDate_offre_demande($row->date_offre_demande)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setCode_cat($row->code_cat)
                 ->setType_credit_of($row->type_credit_of)
                 ->setType_credit_de($row->type_credit_de)
                 ->setNum_offre_demande($row->num_offre_demande)
				 ->setId_credit($row->id_credit);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByMembre($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemande();
            $entry->setId_offre_demande($row->id_offre_demande)
                 ->setType_offre_demande($row->type_offre_demande)
                 ->setDate_offre_demande($row->date_offre_demande)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setCode_cat($row->code_cat)
                 ->setType_credit_of($row->type_credit_of)
                 ->setType_credit_de($row->type_credit_de)
                 ->setNum_offre_demande($row->num_offre_demande)
				 ->setId_credit($row->id_credit);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByNoMembre($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre != ? ", $code_membre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemande();
            $entry->setId_offre_demande($row->id_offre_demande)
                 ->setType_offre_demande($row->type_offre_demande)
                 ->setDate_offre_demande($row->date_offre_demande)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setCode_cat($row->code_cat)
                 ->setType_credit_of($row->type_credit_of)
                 ->setType_credit_de($row->type_credit_de)
                 ->setNum_offre_demande($row->num_offre_demande)
				 ->setId_credit($row->id_credit);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByMembreType($code_membre, $type) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
		$select->where("type_offre_demande = ? ", $type);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemande();
            $entry->setId_offre_demande($row->id_offre_demande)
                 ->setType_offre_demande($row->type_offre_demande)
                 ->setDate_offre_demande($row->date_offre_demande)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setCode_cat($row->code_cat)
                 ->setType_credit_of($row->type_credit_of)
                 ->setType_credit_de($row->type_credit_de)
                 ->setNum_offre_demande($row->num_offre_demande)
				 ->setId_credit($row->id_credit);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByMembreType2($code_membre, $type, $type_of, $type_de) {
		
if($type == "Offre"){
	$code_cat = substr($type_de, 3);
switch ($code_cat) {
    case "TSGCI":
        $code_cat2 = "TPAGCI";
        break;
    case "TSCNCSEI":
        $code_cat2 = "TCNCSEI";
        break;
    case "TSPN":
        $code_cat2 = "TPN";
        break;
    case "TSFS":
        $code_cat2 = "TFS";
        break;
    case "TSI":
        $code_cat2 = "TI";
        break;
    case "TSGCP":
        $code_cat2 = "TPAGCP";
        break;
    case "TSCI":
        $code_cat2 = "TSCI";
        break;
    case "TSCAPA":
        $code_cat2 = "CAPA";
        break;
    case "TR":
        $code_cat2 = "TR";
        break;
    case "TSRPG":
        $code_cat2 = "TPAGCRPG";
        break;
    case "TSCNCS":
        $code_cat2 = "TCNCS";
        break;
    case "TSPaNu":
        $code_cat2 = "TPaNu";
        break;
    case "TSPaR":
        $code_cat2 = "TPaR";
        break;
    case "TSMF107":
        $code_cat2 = "TMF107";
        break;
    case "TSMF11000":
        $code_cat2 = "TMF11000";
        break;
    case "TSMFL":
        $code_cat2 = "TMFL";
        break;
}
$type_de_2 = substr($type_de, 0, 3).$code_cat2;
		
		
	$code_cat = substr($type_of, 3);
switch ($code_cat) {
    case "TPAGCI":
        $code_cat2 = "TSGCI";
        break;
    case "TCNCSEI":
        $code_cat2 = "TSCNCSEI";
        break;
    case "TPN":
        $code_cat2 = "TSPN";
        break;
    case "TFS":
        $code_cat2 = "TSFS";
        break;
    case "TI":
        $code_cat2 = "TSI";
        break;
    case "TPAGCP":
        $code_cat2 = "TSGCP";
        break;
    case "TSCI":
        $code_cat2 = "TSCI";
        break;
    case "CAPA":
        $code_cat2 = "TSCAPA";
        break;
    case "TR":
        $code_cat2 = "TR";
        break;
    case "TPAGCRPG":
        $code_cat2 = "TSRPG";
        break;
    case "TCNCS":
        $code_cat2 = "TSCNCS";
        break;
    case "TPaNu":
        $code_cat2 = "TSPaNu";
        break;
    case "TPaR":
        $code_cat2 = "TSPaR";
        break;
    case "TMF107":
        $code_cat2 = "TSMF107";
        break;
    case "TMF11000":
        $code_cat2 = "TSMF11000";
        break;
    case "TMFL":
        $code_cat2 = "TSMFL";
        break;
}
$type_of_2 = substr($type_of, 0, 3).$code_cat2;


}else if($type == "Demande"){
	$code_cat = substr($type_of, 3);
switch ($code_cat) {
    case "TSGCI":
        $code_cat2 = "TPAGCI";
        break;
    case "TSCNCSEI":
        $code_cat2 = "TCNCSEI";
        break;
    case "TSPN":
        $code_cat2 = "TPN";
        break;
    case "TSFS":
        $code_cat2 = "TFS";
        break;
    case "TSI":
        $code_cat2 = "TI";
        break;
    case "TSGCP":
        $code_cat2 = "TPAGCP";
        break;
    case "TSCI":
        $code_cat2 = "TSCI";
        break;
    case "TSCAPA":
        $code_cat2 = "CAPA";
        break;
    case "TR":
        $code_cat2 = "TR";
        break;
    case "TSRPG":
        $code_cat2 = "TPAGCRPG";
        break;
    case "TSCNCS":
        $code_cat2 = "TCNCS";
        break;
    case "TSPaNu":
        $code_cat2 = "TPaNu";
        break;
    case "TSPaR":
        $code_cat2 = "TPaR";
        break;
    case "TSMF107":
        $code_cat2 = "TMF107";
        break;
    case "TSMF11000":
        $code_cat2 = "TMF11000";
        break;
    case "TSMFL":
        $code_cat2 = "TMFL";
        break;
}
$type_of_2 = substr($type_of, 0, 3).$code_cat2;
		
		
	$code_cat = substr($type_de, 3);
switch ($code_cat) {
    case "TPAGCI":
        $code_cat2 = "TSGCI";
        break;
    case "TCNCSEI":
        $code_cat2 = "TSCNCSEI";
        break;
    case "TPN":
        $code_cat2 = "TSPN";
        break;
    case "TFS":
        $code_cat2 = "TSFS";
        break;
    case "TI":
        $code_cat2 = "TSI";
        break;
    case "TPAGCP":
        $code_cat2 = "TSGCP";
        break;
    case "TSCI":
        $code_cat2 = "TSCI";
        break;
    case "CAPA":
        $code_cat2 = "TSCAPA";
        break;
    case "TR":
        $code_cat2 = "TR";
        break;
    case "TPAGCRPG":
        $code_cat2 = "TSRPG";
        break;
    case "TCNCS":
        $code_cat2 = "TSCNCS";
        break;
    case "TPaNu":
        $code_cat2 = "TSPaNu";
        break;
    case "TPaR":
        $code_cat2 = "TSPaR";
        break;
    case "TMF107":
        $code_cat2 = "TSMF107";
        break;
    case "TMF11000":
        $code_cat2 = "TSMF11000";
        break;
    case "TMFL":
        $code_cat2 = "TSMFL";
        break;
}
$type_de_2 = substr($type_de, 0, 3).$code_cat2;
}



		
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
		$select->where("type_offre_demande = ? ", $type);
		$select->where("type_credit_of = ? ", $type_of_2);
		$select->where("type_credit_de = ? ", $type_de_2);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOffreDemande();
            $entry->setId_offre_demande($row->id_offre_demande)
                 ->setType_offre_demande($row->type_offre_demande)
                 ->setDate_offre_demande($row->date_offre_demande)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setCode_cat($row->code_cat)
                 ->setType_credit_of($row->type_credit_of)
                 ->setType_credit_de($row->type_credit_de)
                 ->setNum_offre_demande($row->num_offre_demande)
				 ->setId_credit($row->id_credit);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAllByMembreOffreDemande($code_membre, $id_offre_demande) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
		$select->where("id_offre_demande = ? ", $id_offre_demande);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $entry = new Application_Model_EuOffreDemande();
            $entry->setId_offre_demande($row->id_offre_demande)
                 ->setType_offre_demande($row->type_offre_demande)
                 ->setDate_offre_demande($row->date_offre_demande)
                 ->setCode_membre($row->code_membre)
                 ->setCode_compte($row->code_compte)
                 ->setCode_cat($row->code_cat)
                 ->setType_credit_of($row->type_credit_of)
                 ->setType_credit_de($row->type_credit_de)
                 ->setNum_offre_demande($row->num_offre_demande)
				 ->setId_credit($row->id_credit);
            return $entry;
        } else {
            return NULL;
        }
    }


}

?>
