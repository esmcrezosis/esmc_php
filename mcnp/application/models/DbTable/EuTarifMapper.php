<?php

class Application_Model_EuTarifMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTarif');
        }
        return $this->_dbTable;
    }
	
	

    public function save(Application_Model_EuTarif $tarif) {
        $data = array(
          'id_tarif' => $tarif->getId_tarif(),
          'montant_inferieur' => $tarif->getMontant_inferieur(),
          'montant_superieur' => $tarif->getMontant_superieur(),
          'montant_tarif' => $tarif->getMontant_tarif(),
          'mode_paiement' => $tarif->getMode_paiement(),
          'statut' => $tarif->getStatut()
        );

        $this->getDbTable()->insert($data);
    }
	
	
	public function findConuter() {
      $select = $this->getDbTable()->select();
      $select->from($this->getDbTable(), array('MAX(id_tarif) as count'));
      $result = $this->getDbTable()->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	
	

    public function update(Application_Model_EuTarif $tarif) {
        $data = array(
          'id_tarif' => $tarif->getId_tarif(),
          'montant_inferieur' => $tarif->getMontant_inferieur(),
          'montant_superieur' => $tarif->getMontant_superieur(),
          'montant_tarif' => $tarif->getMontant_tarif(),
          'mode_paiement' => $tarif->getMode_paiement(),
          'statut' => $tarif->getStatut()
        );

        $this->getDbTable()->update($data, array('id_tarif = ?' => $tarif->getId_tarif()));
    }

    public function find($id_tarif, Application_Model_EuTarif $tarif) {
        $result = $this->getDbTable()->find($id_tarif);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $tarif->setId_tarif($row->id_tarif)
                   ->setMontant_inferieur($row->montant_inferieur)
                   ->setMontant_superieur($row->montant_superieur)
                   ->setMontant_tarif($row->montant_tarif)
                   ->setMode_paiement($row->mode_paiement)
                   ->setStatut($row->statut)
				   ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTarif();
            $entry->setId_tarif($row->id_tarif)
                  ->setMontant_inferieur($row->montant_inferieur)
                  ->setMontant_superieur($row->montant_superieur)
                  ->setMontant_tarif($row->montant_tarif)
                  ->setMode_paiement($row->mode_paiement)
                  ->setStatut($row->statut)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_tarif) {
        $this->getDbTable()->delete(array('id_tarif = ?' => $id_tarif));
    }


    



  
    
    public function fetchAllByHome() {//$limit
        $select = $this->getDbTable()->select();
        $select->where("statut = ? ", 1);
        $select->order(array("date_creation DESC"));
        //$select->limit($limit);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTarif();
            $entry->setId_tarif($row->id_tarif)
                  ->setMontant_inferieur($row->montant_inferieur)
                  ->setMontant_superieur($row->montant_superieur)
                  ->setMontant_tarif($row->montant_tarif)
                  ->setMode_paiement($row->mode_paiement)
                  ->setStatut($row->statut)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMontantTarif($montant_tarif = 0)
    {
        $select = $this->getDbTable()->select();
        if($montant_tarif > 0){
    $select->where("montant_inferieur <= ? ", $montant_tarif);
    $select->where("montant_superieur >= ? ", $montant_tarif);
  }
    $select->where("statut = ? ", 1);
    //$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuTarif();
            $entry->setId_tarif($row->id_tarif)
                  ->setMontant_inferieur($row->montant_inferieur)
                  ->setMontant_superieur($row->montant_superieur)
                  ->setMontant_tarif($row->montant_tarif)
                  ->setMode_paiement($row->mode_paiement)
                  ->setStatut($row->statut)
                  ;
      $entries = $entry;
        return $entries;
    }




}

