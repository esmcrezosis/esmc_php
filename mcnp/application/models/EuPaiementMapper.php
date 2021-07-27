 <?php

class Application_Model_EuPaiementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPaiement');
        }
        return $this->_dbTable;
    }


    public function find($id_paiement, Application_Model_EuPaiement $paiement) {
        $result = $this->getDbTable()->find($id_paiement);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $paiement->setId_paiement($row->id_paiement)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setDate_paiement($row->date_paiement)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_demande_paiement($row->id_demande_paiement)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ->setPayer($row->payer)
                  ;
    }


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPaiement();
            $entry->setId_paiement($row->id_paiement)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setDate_paiement($row->date_paiement)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_demande_paiement($row->id_demande_paiement)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ->setPayer($row->payer)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
	  

    public function save(Application_Model_EuPaiement $paiement) {
        $data = array(
			      'id_paiement' => $paiement->getId_paiement(),
            'code_membre_employe' => $paiement->getCode_membre_employe(),
            'montant_paiement' => $paiement->getMontant_paiement(),
            'date_paiement' => $paiement->getDate_paiement(),
            'id_demande_paiement' => $paiement->getId_demande_paiement(),
          'taux_horaire' => $paiement->getTaux_horaire(),
          'nombre_heure' => $paiement->getNombre_heure(),
            'payer' => $paiement->getPayer()
        );

        $this->getDbTable()->insert($data);
    }
    
	
    public function update(Application_Model_EuPaiement $paiement) {
        $data = array(
          'id_paiement' => $paiement->getId_paiement(),
          'code_membre_employe' => $paiement->getCode_membre_employe(),
          'montant_paiement' => $paiement->getMontant_paiement(),
          'date_paiement' => $paiement->getDate_paiement(),
          'id_demande_paiement' => $paiement->getId_demande_paiement(),
          'taux_horaire' => $paiement->getTaux_horaire(),
          'nombre_heure' => $paiement->getNombre_heure(),
            'payer' => $paiement->getPayer()
        );
        $this->getDbTable()->update($data, array('id_paiement = ?' => $paiement->getId_paiement()));
    }


    public function delete($id_paiement) {
        $this->getDbTable()->delete(array('id_paiement = ?' => $id_paiement));
    }

	
	public function findConuter() {
        $tabela = new Application_Model_DbTable_EuPaiement();
        $select = $tabela->select();
        $select->from('eu_paiement', array('MAX(id_paiement) as count'));
        $result = $tabela->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function fetchAllByEmploye($code_membre_employe) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_employe = ?', $code_membre_employe);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPaiement();
            $entry->setId_paiement($row->id_paiement)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setDate_paiement($row->date_paiement)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_demande_paiement($row->id_demande_paiement)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ->setPayer($row->payer)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByDemande($id_demande_paiement) {
        $select = $this->getDbTable()->select();
        $select->where('id_demande_paiement = ?', $id_demande_paiement);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPaiement();
            $entry->setId_paiement($row->id_paiement)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setDate_paiement($row->date_paiement)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_demande_paiement($row->id_demande_paiement)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ->setPayer($row->payer)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }

///////////////////////////////////////////////////////////////

    public function fetchAllByEmployeur($code_membre_employeur) {
        $select = $this->getDbTable()->select();
        $select->where("id_demande_paiement IN (SELECT id_demande_paiement FROM eu_demande_paiement WHERE code_membre_employeur LIKE '".$code_membre_employeur."')");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPaiement();
            $entry->setId_paiement($row->id_paiement)
                  ->setMontant_paiement($row->montant_paiement)
                  ->setDate_paiement($row->date_paiement)
                  ->setCode_membre_employe($row->code_membre_employe)
                  ->setId_demande_paiement($row->id_demande_paiement)
                  ->setTaux_horaire($row->taux_horaire)
                  ->setNombre_heure($row->nombre_heure)
                  ->setPayer($row->payer)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }







}

?>
