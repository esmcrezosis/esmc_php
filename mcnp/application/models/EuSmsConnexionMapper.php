<?php

class Application_Model_EuSmsConnexionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSmsConnexion');
        }
        return $this->_dbTable;
    }

    public function find($sms_connexion_id, Application_Model_EuSmsConnexion $sms_connexion) {
        $result = $this->getDbTable()->find($sms_connexion_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $sms_connexion->setSms_connexion_id($row->sms_connexion_id)
                ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
                ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
                ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
                ->setSms_connexion_utilise($row->sms_connexion_utilise)
                ->setSms_connexion_date($row->sms_connexion_date)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("sms_connexion_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsConnexion();
            $entry->setSms_connexion_id($row->sms_connexion_id)
	                ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
                    ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
                    ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
	                ->setSms_connexion_utilise($row->sms_connexion_utilise)
                ->setSms_connexion_date($row->sms_connexion_date)
					;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(sms_connexion_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuSmsConnexion $sms_connexion) {
        $data = array(
            'sms_connexion_id' => $sms_connexion->getSms_connexion_id(),
            'sms_connexion_code_envoi' => $sms_connexion->getSms_connexion_code_envoi(),
            'sms_connexion_code_membre' => $sms_connexion->getSms_connexion_code_membre(),
            'sms_connexion_code_recu' => $sms_connexion->getSms_connexion_code_recu(),
            'sms_connexion_date' => $sms_connexion->getSms_connexion_date(),
            'sms_connexion_utilise' => $sms_connexion->getSms_connexion_utilise()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSmsConnexion $sms_connexion) {
        $data = array(
            'sms_connexion_id' => $sms_connexion->getSms_connexion_id(),
            'sms_connexion_code_envoi' => $sms_connexion->getSms_connexion_code_envoi(),
            'sms_connexion_code_membre' => $sms_connexion->getSms_connexion_code_membre(),
            'sms_connexion_code_recu' => $sms_connexion->getSms_connexion_code_recu(),
            'sms_connexion_date' => $sms_connexion->getSms_connexion_date(),
            'sms_connexion_utilise' => $sms_connexion->getSms_connexion_utilise()
        );
        $this->getDbTable()->update($data, array('sms_connexion_id = ?' => $sms_connexion->getSms_connexion_id()));
    }

    public function delete($sms_connexion_id) {
        $this->getDbTable()->delete(array('sms_connexion_id = ?' => $sms_connexion_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->order("sms_connexion_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsConnexion();
            $entry->setSms_connexion_id($row->sms_connexion_id)
	                ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
                    ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
                    ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
	                ->setSms_connexion_utilise($row->sms_connexion_utilise)
                ->setSms_connexion_date($row->sms_connexion_date)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMembre($sms_connexion_code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("sms_connexion_code_membre = ? ", $sms_connexion_code_membre);
		$select->order("sms_connexion_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmsConnexion();
            $entry->setSms_connexion_id($row->sms_connexion_id)
	                ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
                    ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
                    ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
	                ->setSms_connexion_utilise($row->sms_connexion_utilise)
                ->setSms_connexion_date($row->sms_connexion_date)
					;
            $entries[] = $entry;
        }
        return $entries;
    }


    

      public function fetchAllByCodeEnvoi($sms_connexion_code_envoi) {
          $select = $this->getDbTable()->select();
          $select->where("sms_connexion_utilise = ? ", 0);
          $select->where("LOWER(sms_connexion_code_envoi) = ? ", strtolower($sms_connexion_code_envoi));
  		    $select->limit(1);
          $result = $this->getDbTable()->fetchRow($select);
          $entries = array();
          if (0 == count($result)) {
              return;
          }
          $row = $result;
          $entry = new Application_Model_EuSmsConnexion();
          $entry->setSms_connexion_id($row->sms_connexion_id)
                ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
                  ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
                  ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
                ->setSms_connexion_utilise($row->sms_connexion_utilise)
              ->setSms_connexion_date($row->sms_connexion_date)
        ;
  			$entries = $entry;
          return $entries;
      }


      public function fetchAllByCodeMembre($sms_connexion_code_membre) {
          $select = $this->getDbTable()->select();
      $select->where("sms_connexion_utilise = ? ", 0);
      $select->where("sms_connexion_code_membre = ? ", $sms_connexion_code_membre);
      $select->limit(1);
          $result = $this->getDbTable()->fetchRow($select);
          $entries = array();
          if (0 == count($result)) {
              return;
          }
          $row = $result;
          $entry = new Application_Model_EuSmsConnexion();
          $entry->setSms_connexion_id($row->sms_connexion_id)
                ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
                  ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
                  ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
                ->setSms_connexion_utilise($row->sms_connexion_utilise)
              ->setSms_connexion_date($row->sms_connexion_date)
        ;
        $entries = $entry;
          return $entries;
      }



      public function fetchAllByCodeMembre2($sms_connexion_code_membre) {
          $select = $this->getDbTable()->select();
      $select->where("sms_connexion_utilise = ? ", 0);
      $select->where("sms_connexion_code_membre = ? ", $sms_connexion_code_membre);
      $select->where("sms_connexion_code_recu LIKE '%"."authentification"."%' ");
      $select->limit(1);
          $result = $this->getDbTable()->fetchRow($select);
          $entries = array();
          if (0 == count($result)) {
              return;
          }
          $row = $result;
          $entry = new Application_Model_EuSmsConnexion();
          $entry->setSms_connexion_id($row->sms_connexion_id)
                ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
                  ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
                  ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
                ->setSms_connexion_utilise($row->sms_connexion_utilise)
              ->setSms_connexion_date($row->sms_connexion_date)
        ;
        $entries = $entry;
          return $entries;
    }


    public function fetchAllByCodeMembre3($sms_connexion_code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("sms_connexion_utilise = ? ", 0);
        $select->where("sms_connexion_code_membre = ? ", $sms_connexion_code_membre);
        $select->where("sms_connexion_code_recu LIKE '%"."approvisionnement"."%' ");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if(0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuSmsConnexion();
        $entry->setSms_connexion_id($row->sms_connexion_id)
              ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
              ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
              ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
              ->setSms_connexion_utilise($row->sms_connexion_utilise)
              ->setSms_connexion_date($row->sms_connexion_date);
        $entries = $entry;
        return $entries;
    }
	
	
	
	
	public function fetchAllByCodeMembre4($sms_connexion_code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("sms_connexion_utilise = ? ", 0);
        $select->where("sms_connexion_code_membre = ? ", $sms_connexion_code_membre);
        $select->where("sms_connexion_code_recu LIKE '%"."approvisionnement BL"."%' ");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if(0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuSmsConnexion();
        $entry->setSms_connexion_id($row->sms_connexion_id)
              ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
              ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
              ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
              ->setSms_connexion_utilise($row->sms_connexion_utilise)
              ->setSms_connexion_date($row->sms_connexion_date);
        $entries = $entry;
        return $entries;
    }
	
	
	public function fetchAllByCodeMembre5($sms_connexion_code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("sms_connexion_utilise = ? ", 0);
        $select->where("sms_connexion_code_membre = ? ", $sms_connexion_code_membre);
        $select->where("sms_connexion_code_recu LIKE '%"."approvisionnement BC"."%' ");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if(0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuSmsConnexion();
        $entry->setSms_connexion_id($row->sms_connexion_id)
              ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
              ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
              ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
              ->setSms_connexion_utilise($row->sms_connexion_utilise)
              ->setSms_connexion_date($row->sms_connexion_date);
        $entries = $entry;
        return $entries;
    }
	
	
	public function fetchAllByCodeMembre6($sms_connexion_code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("sms_connexion_utilise = ? ", 0);
        $select->where("sms_connexion_code_membre = ? ", $sms_connexion_code_membre);
        $select->where("sms_connexion_code_recu LIKE '%"."approvisionnement BAi"."%' ");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if(0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuSmsConnexion();
        $entry->setSms_connexion_id($row->sms_connexion_id)
              ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
              ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
              ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
              ->setSms_connexion_utilise($row->sms_connexion_utilise)
              ->setSms_connexion_date($row->sms_connexion_date);
        $entries = $entry;
        return $entries;
    }
	
	
	public function fetchAllByCodeMembre7($sms_connexion_code_membre) {
        $select = $this->getDbTable()->select();
        $select->where("sms_connexion_utilise = ? ", 0);
        $select->where("sms_connexion_code_membre = ? ", $sms_connexion_code_membre);
        $select->where("sms_connexion_code_recu LIKE '%"."approvisionnement BS"."%' ");
        $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if(0 == count($result)) {
            return;
        }
        $row = $result;
        $entry = new Application_Model_EuSmsConnexion();
        $entry->setSms_connexion_id($row->sms_connexion_id)
              ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
              ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
              ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
              ->setSms_connexion_utilise($row->sms_connexion_utilise)
              ->setSms_connexion_date($row->sms_connexion_date);
        $entries = $entry;
        return $entries;
    }
	
	
	
	
	
	

    public function fetchAllByCodeRecu($sms_connexion_code_recu) {
              $select = $this->getDbTable()->select();
              $select->where("sms_connexion_utilise = ? ", 0);
              $select->where("LOWER(sms_connexion_code_recu) LIKE '%".strtolower($sms_connexion_code_recu)."%' ");
      		    $select->limit(1);
              $result = $this->getDbTable()->fetchRow($select);
              $entries = array();
              if (0 == count($result)) {
                  return;
              }
              $row = $result;
              $entry = new Application_Model_EuSmsConnexion();
              $entry->setSms_connexion_id($row->sms_connexion_id)
                    ->setSms_connexion_code_envoi($row->sms_connexion_code_envoi)
                      ->setSms_connexion_code_membre($row->sms_connexion_code_membre)
                      ->setSms_connexion_code_recu($row->sms_connexion_code_recu)
                    ->setSms_connexion_utilise($row->sms_connexion_utilise)
                  ->setSms_connexion_date($row->sms_connexion_date)
            ;
      			$entries = $entry;
              return $entries;
          }




}


?>
