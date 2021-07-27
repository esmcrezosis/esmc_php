 <?php

class Application_Model_EuDetailPaiementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailPaiement');
        }
        return $this->_dbTable;
    }
	
    public function find($id_detail_paiement, Application_Model_EuDetailPaiement $detail_paiement) {
        $result = $this->getDbTable()->find($id_detail_paiement);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $categorie->setId_detail_paiement($row->id_detail_paiement)
                  ->setId_paiement($row->id_paiement)
                  ->setId_pointage($row->id_pointage)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                  ->setSouscription_id($row->souscription_id)
                  ->setTable($row->table)
                  ->setId_table($row->id_table)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailPaiement();
            $entry->setId_detail_paiement($row->id_detail_paiement)
                  ->setId_paiement($row->id_paiement)
                  ->setId_pointage($row->id_pointage)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                  ->setSouscription_id($row->souscription_id)
                  ->setTable($row->table)
                  ->setId_table($row->id_table)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	public function findConuter() {
      $tabela = new Application_Model_DbTable_EuDetailPaiement();
      $select = $tabela->select();
      $select->from('eu_detail_paiement', array('MAX(id_detail_paiement) as count'));
      $result = $tabela->fetchAll($select);
      $row = $result->current();
      return $row['count'];
    }
	
    public function save(Application_Model_EuDetailPaiement $detail_paiement) {
        $data = array(
		  'id_detail_paiement' => $detail_paiement->getId_detail_paiement(),
          'id_pointage' => $detail_paiement->getId_pointage(),
          'id_paiement' => $detail_paiement->getId_paiement(),
          'bon_neutre_appro_id' => $detail_paiement->getBon_neutre_appro_id(),
          'souscription_id' => $detail_paiement->getSouscription_id(),
          'montant_paiement' => $detail_paiement->getMontant_paiement(),
          'table' => $detail_paiement->getTable(),
          'id_table' => $detail_paiement->getId_table(),
          'taux_horaire' => $detail_paiement->getTaux_horaire(),
          'nombre_heure' => $detail_paiement->getNombre_heure()
        );

        $this->getDbTable()->insert($data);
    }
    

    public function update(Application_Model_EuDetailPaiement $detail_paiement) {
        $data = array(
          'id_detail_paiement' => $detail_paiement->getId_detail_paiement(),
          'id_pointage' => $detail_paiement->getId_pointage(),
          'id_paiement' => $detail_paiement->getId_paiement(),
          'bon_neutre_appro_id' => $detail_paiement->getBon_neutre_appro_id(),
          'souscription_id' => $detail_paiement->getSouscription_id(),
          'montant_paiement' => $detail_paiement->getMontant_paiement(),
          'table' => $detail_paiement->getTable(),
          'id_table' => $detail_paiement->getId_table(),
          'taux_horaire' => $detail_paiement->getTaux_horaire(),
          'nombre_heure' => $detail_paiement->getNombre_heure()
        );
        $this->getDbTable()->update($data, array('id_detail_paiement = ?' => $detail_paiement->getId_detail_paiement()));
    }

    public function delete($id_detail_paiement) {
        $this->getDbTable()->delete(array('id_detail_paiement = ?' => $id_detail_paiement));
    }


    public function fetchAllByPaiement($id_paiement) {
        $select = $this->getDbTable()->select();
        $select->where('id_paiement = ?', $id_paiement);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailPaiement();
            $entry->setId_detail_paiement($row->id_detail_paiement)
                  ->setId_paiement($row->id_paiement)
                  ->setId_pointage($row->id_pointage)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                  ->setSouscription_id($row->souscription_id)
                  ->setTable($row->table)
                  ->setId_table($row->id_table)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByPointage($id_pointage) {
        $select = $this->getDbTable()->select();
        $select->where('id_pointage = ?', $id_pointage);
          $result = $this->getDbTable()->fetchRow($select);
          $entries = array();
          if (0 == count($result)) {
              return;
          }
          $row = $result;
          $entry = new Application_Model_EuDetailPaiement();
            $entry->setId_detail_paiement($row->id_detail_paiement)
                  ->setId_paiement($row->id_paiement)
                  ->setId_pointage($row->id_pointage)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                  ->setSouscription_id($row->souscription_id)
                  ->setTable($row->table)
                  ->setId_table($row->id_table)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ;
        $entries = $entry;
          return $entries;
      }
      ///////////////////////////////////////////////////////////////



    public function fetchAllByTable($table = "") {
        $select = $this->getDbTable()->select();
        if($table != ""){
        $select->where('table = ?', $table);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailPaiement();
            $entry->setId_detail_paiement($row->id_detail_paiement)
                  ->setId_paiement($row->id_paiement)
                  ->setId_pointage($row->id_pointage)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                  ->setSouscription_id($row->souscription_id)
                  ->setTable($row->table)
                  ->setId_table($row->id_table)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByIdTable($table = "", $id_table = 0) {
        $select = $this->getDbTable()->select();
        if($table != ""){
        $select->where('table = ?', $table);
        }
        if($id_table != ""){
        $select->where('id_table = ?', $id_table);
        }
          $result = $this->getDbTable()->fetchRow($select);
          $entries = array();
          if (0 == count($result)) {
              return;
          }
          $row = $result;
          $entry = new Application_Model_EuDetailPaiement();
            $entry->setId_detail_paiement($row->id_detail_paiement)
                  ->setId_paiement($row->id_paiement)
                  ->setId_pointage($row->id_pointage)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                  ->setSouscription_id($row->souscription_id)
                  ->setTable($row->table)
                  ->setId_table($row->id_table)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ;
        $entries = $entry;
          return $entries;
      }


}

?>
