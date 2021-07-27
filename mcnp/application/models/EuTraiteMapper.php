<?php
 
class Application_Model_EuTraiteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTraite');
        }
        return $this->_dbTable;
    }

    public function find($traite_id, Application_Model_EuTraite $traite) {
        $result = $this->getDbTable()->find($traite_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $traite->setTraite_id($row->traite_id)
                ->setTraite_tegcp($row->traite_tegcp)
                ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
        $select->order("traite_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                    ->setTraite_tegcp($row->traite_tegcp)
                    ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                    ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(traite_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuTraite $traite) {
        $data = array(
            'traite_id' => $traite->getTraite_id(),
            'traite_tegcp' => $traite->getTraite_tegcp(),
            'traite_code_banque' => $traite->getTraite_code_banque(),
            'bon_id' => $traite->getBon_id(),
            'traite_numero' => $traite->getTraite_numero(),
            'traite_date_debut' => $traite->getTraite_date_debut(),
            'traite_date_fin' => $traite->getTraite_date_fin(),
            'traite_disponible' => $traite->getTraite_disponible(),
            'traite_imprimer' => $traite->getTraite_imprimer(),
            'traite_escompte_nature' => $traite->getTraite_escompte_nature(),
            'traiter' => $traite->getTraiter(),
            'traite_montant' => $traite->getTraite_montant(),
            'traite_payer' => $traite->getTraite_payer(),
            'traite_avant_vte' => $traite->getTraite_avant_vte(),
            'id_utilisateur' => $traite->getId_utilisateur(),
            'mode_paiement' => $traite->getMode_paiement(),
            'bon_type' => $traite->getBon_type(),
            'reference_paiement' => $traite->getReference_paiement()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTraite $traite) {
        $data = array(
            'traite_id' => $traite->getTraite_id(),
            'traite_tegcp' => $traite->getTraite_tegcp(),
            'traite_code_banque' => $traite->getTraite_code_banque(),
            'bon_id' => $traite->getBon_id(),
            'traite_numero' => $traite->getTraite_numero(),
            'traite_date_debut' => $traite->getTraite_date_debut(),
            'traite_date_fin' => $traite->getTraite_date_fin(),
            'traite_disponible' => $traite->getTraite_disponible(),
            'traite_imprimer' => $traite->getTraite_imprimer(),
            'traite_escompte_nature' => $traite->getTraite_escompte_nature(),
            'traiter' => $traite->getTraiter(),
            'traite_montant' => $traite->getTraite_montant(),
            'traite_payer' => $traite->getTraite_payer(),
            'traite_avant_vte' => $traite->getTraite_avant_vte(),
            'id_utilisateur' => $traite->getId_utilisateur(),
            'mode_paiement' => $traite->getMode_paiement(),
            'bon_type' => $traite->getBon_type(),
            'reference_paiement' => $traite->getReference_paiement()
        );
        $this->getDbTable()->update($data, array('traite_id = ?' => $traite->getTraite_id()));
    }

    public function delete($traite_id) {
        $this->getDbTable()->delete(array('traite_id = ?' => $traite_id));
    }


    public function fetchAll0() {
        $select = $this->getDbTable()->select();
        $select->where("traiter != ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                    ->setTraite_tegcp($row->traite_tegcp)
                    ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                    ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll1() {
        $select = $this->getDbTable()->select();
        $select->where("traiter = ? ", 8);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                    ->setTraite_tegcp($row->traite_tegcp)
                    ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                    ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    
    
    
    
    /*public function findTraiteTegcp($tegcp) {
       $select = $this->getDbTable()->select();
        $select->where("traite_tegcp = ? ", $tegcp);
       $results = $this->getDbTable()->fetchAll($select);
       if (count($results) > 0) {
          $row = $results->current();
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                    ->setTraite_tegcp($row->traite_tegcp)
                    ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                    ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            return $entry; 
        } 
        else {
            return false;
        }
    }*/
    
    public function findTraiteTegcp($tegcp) {
       $select = $this->getDbTable()->select();
        $select->where("traite_tegcp = ? ", $tegcp);
       $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                    ->setTraite_tegcp($row->traite_tegcp)
                    ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                    ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    public function findTraiteTegcpTraiter($tegcp, $traiter) {
       $select = $this->getDbTable()->select();
        $select->where("traite_tegcp = ? ", $tegcp);
        $select->where("traiter = ? ", $traiter);
       $results = $this->getDbTable()->fetchAll($select);
       if (count($results) > 0) {
          $row = $results->current();
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                    ->setTraite_tegcp($row->traite_tegcp)
                    ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                    ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            return $entry; 
        } 
        else {
            return false;
        }
    }
    
    
    
    
    
    public function fetchAllByNumero($traite_numero) {
    $select = $this->getDbTable()->select();
    $select->where("traite_numero = ? ", $traite_numero);
    $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                ->setTraite_tegcp($row->traite_tegcp)
                ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            return $entry; 
        } else {
            return false;
        }
    }
    
    

    
    public function fetchAllByMembreNumero($code_membre, $traite_numero) {
    $select = $this->getDbTable()->select();
    $select->where("traite_numero = ? ", $traite_numero);
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");
    $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                ->setTraite_tegcp($row->traite_tegcp)
                ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            return $entry; 
        } else {
            return false;
        }
    }
    
    
    
    public function fetchAllByMembreNumero1($code_membre, $traite_numero) {
    $select = $this->getDbTable()->select();
    $select->where("traite_numero LIKE '%".$traite_numero."%' ");
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");
    $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                ->setTraite_tegcp($row->traite_tegcp)
                ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            return $entry; 
        } else {
            return false;
        }
    }

    
    public function fetchAllByOPIBAn($code_membre) {
        $select = $this->getDbTable()->select();
        //$select->where("traite_payer = ? ", 0);
        //$select->where("traite_disponible = ? ", 1);
        $select->where("traite_imprimer = ? ", 0);
        $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");
        $select->order(array("traite_date_fin ASC"));
        $select->limit(6);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                    ->setTraite_tegcp($row->traite_tegcp)
                    ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                    ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setTraite_statut($row->traite_statut)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    



    
    public function fetchAllByEchu($id_tpagcp, $traite_date_fin)   {
        $select = $this->getDbTable()->select();
        $select->where("traite_tegcp = ? ", $id_tpagcp);
        $select->where("traite_date_fin <= '".$traite_date_fin."'");
        $select->where("traite_imprimer = ? ", 0);
        $select->order(array("traite_date_fin ASC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                  ->setTraite_tegcp($row->traite_tegcp)
                  ->setTraite_code_banque($row->traite_code_banque)
                  ->setBon_id($row->bon_id)
                  ->setTraite_numero($row->traite_numero)
                  ->setTraite_date_debut($row->traite_date_debut)
                  ->setTraite_date_fin($row->traite_date_fin)
                  ->setTraite_disponible($row->traite_disponible)
                  ->setTraite_imprimer($row->traite_imprimer)
                  ->setTraite_escompte_nature($row->traite_escompte_nature)
                  ->setTraiter($row->traiter)
                  ->setTraite_montant($row->traite_montant)
                  ->setTraite_payer($row->traite_payer)
                  ->setTraite_avant_vte($row->traite_avant_vte)
                  ->setTraite_statut($row->traite_statut)
          ->setId_utilisateur($row->id_utilisateur)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }




    
    public function fetchAllByMembreDateMontant($code_membre, $traite_date_fin, $traite_montant) {
    $select = $this->getDbTable()->select();
    $select->where("traite_date_fin = ? ", $traite_date_fin);
    $select->where("traite_montant = ? ", $traite_montant);
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");
    $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                ->setTraite_tegcp($row->traite_tegcp)
                ->setTraite_code_banque($row->traite_code_banque)
                ->setBon_id($row->bon_id)
                ->setTraite_numero($row->traite_numero)
                ->setTraite_date_debut($row->traite_date_debut)
                ->setTraite_date_fin($row->traite_date_fin)
                ->setTraite_disponible($row->traite_disponible)
                ->setTraite_imprimer($row->traite_imprimer)
                ->setTraite_escompte_nature($row->traite_escompte_nature)
                ->setTraiter($row->traiter)
                ->setTraite_montant($row->traite_montant)
                ->setTraite_payer($row->traite_payer)
                ->setTraite_avant_vte($row->traite_avant_vte)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            return $entry; 
        } else {
            return false;
        }
    }
    


    public function fetchAllByMembreDateFin($code_membre, $traite_date_fin) {
    $select = $this->getDbTable()->select();
    $select->where("traite_date_fin >= ? ", $traite_date_fin);
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");
    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                  ->setTraite_tegcp($row->traite_tegcp)
                  ->setTraite_code_banque($row->traite_code_banque)
                  ->setBon_id($row->bon_id)
                  ->setTraite_numero($row->traite_numero)
                  ->setTraite_date_debut($row->traite_date_debut)
                  ->setTraite_date_fin($row->traite_date_fin)
                  ->setTraite_disponible($row->traite_disponible)
                  ->setTraite_imprimer($row->traite_imprimer)
                  ->setTraite_escompte_nature($row->traite_escompte_nature)
                  ->setTraiter($row->traiter)
                  ->setTraite_montant($row->traite_montant)
                  ->setTraite_payer($row->traite_payer)
                  ->setTraite_avant_vte($row->traite_avant_vte)
                  ->setTraite_statut($row->traite_statut)
          ->setId_utilisateur($row->id_utilisateur)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    

    /*public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(traite_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }*/

    public function fetchAllByMembreDebutFinDisponibleImprimerPayerMode($code_membre = "", $traite_date_debut = "", $traite_date_fin = "", $traite_disponible = 0, $traite_imprimer = 0, $traite_payer = 0, $mode_paiement = "") {
    $select = $this->getDbTable()->select();
    if($code_membre != ""){
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");   
    }
    //if($traite_date_debut != ""){
    //$select->where("traite_date_debut > ? ", $traite_date_debut);
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE date_deb > '".$traite_date_debut."')");   
    //}
    //if($traite_date_fin != ""){
    $select->where("traite_date_fin = ? ", $traite_date_fin);
    $select->where("traite_date_debut != ? ", $traite_date_fin);
    //}
    //if($traite_disponible > 0){
    //$select->where("traite_disponible = ? ", $traite_disponible);
    //}
    //if($traite_imprimer > 0){
    $select->where("traite_imprimer = ? ", $traite_imprimer);
    //}
    //if($traite_payer > 0){
    $select->where("traite_payer = ? ", $traite_payer);
    //}
    //if($mode_paiement != ""){
    $select->where("mode_paiement LIKE ? ", $mode_paiement);
    //}
    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                  ->setTraite_tegcp($row->traite_tegcp)
                  ->setTraite_code_banque($row->traite_code_banque)
                  ->setBon_id($row->bon_id)
                  ->setTraite_numero($row->traite_numero)
                  ->setTraite_date_debut($row->traite_date_debut)
                  ->setTraite_date_fin($row->traite_date_fin)
                  ->setTraite_disponible($row->traite_disponible)
                  ->setTraite_imprimer($row->traite_imprimer)
                  ->setTraite_escompte_nature($row->traite_escompte_nature)
                  ->setTraiter($row->traiter)
                  ->setTraite_montant($row->traite_montant)
                  ->setTraite_payer($row->traite_payer)
                  ->setTraite_avant_vte($row->traite_avant_vte)
                  ->setTraite_statut($row->traite_statut)
          ->setId_utilisateur($row->id_utilisateur)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
   

    public function fetchAllByMembreDebutFinDisponibleImprimerPayerModeCUMUL($code_membre = "", $traite_date_debut = "", $traite_date_fin = "", $traite_disponible = 0, $traite_imprimer = 0, $traite_payer = 0, $mode_paiement = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(traite_montant) as count'));
    if($code_membre != ""){
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");   
    }
    //if($traite_date_debut != ""){
    //$select->where("traite_date_debut > ? ", $traite_date_debut);
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE date_deb > '".$traite_date_debut."')");   
    //}
    //if($traite_date_fin != ""){
    $select->where("traite_date_fin = ? ", $traite_date_fin);
    $select->where("traite_date_debut != ? ", $traite_date_fin);
    //}
    //if($traite_disponible > 0){
    //$select->where("traite_disponible = ? ", $traite_disponible);
    //}
    //if($traite_imprimer > 0){
    $select->where("traite_imprimer = ? ", $traite_imprimer);
    //}
    //if($traite_payer > 0){
    $select->where("traite_payer = ? ", $traite_payer);
    //}
    //if($mode_paiement != ""){
    $select->where("mode_paiement LIKE ? ", $mode_paiement);
    //}
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        //return $select;
        return $row['count'];
    }



    public function fetchAllByMembreDebutFinDisponibleImprimerPayerModeCUMUL2($code_membre = "", $traite_date_debut = "", $traite_date_fin = "", $traite_disponible = 0, $traite_imprimer = 0, $traite_payer = 0, $mode_paiement = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(traite_montant) as count'));
    if($code_membre != ""){
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");   
    }
    //if($traite_date_debut != ""){
    //$select->where("traite_date_debut > ? ", $traite_date_debut);
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE date_deb > '".$traite_date_debut."')");   
    //}
    $select->where("traite_date_debut != traite_date_fin");
    //if($traite_disponible > 0){
    //$select->where("traite_disponible = ? ", $traite_disponible);
    //}
    //if($traite_imprimer > 0){
    $select->where("traite_imprimer = ? ", $traite_imprimer);
    //}
    //if($traite_payer > 0){
    $select->where("traite_payer = ? ", $traite_payer);
    //}
    //if($mode_paiement != ""){
    $select->where("mode_paiement LIKE ? ", $mode_paiement);
    //}
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        //return $select;
        return $row['count'];
    }


    public function fetchAllByMembreDebutFinDisponibleImprimerPayerMode2($code_membre = "", $traite_date_debut = "", $traite_date_fin = "", $traite_disponible = 0, $traite_imprimer = 0, $traite_payer = 0, $mode_paiement = "") {
    $select = $this->getDbTable()->select();
    if($code_membre != ""){
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE code_membre LIKE '".$code_membre."')");   
    }
    //if($traite_date_debut != ""){
    //$select->where("traite_date_debut > ? ", $traite_date_debut);
    $select->where("traite_tegcp IN (SELECT id_tpagcp FROM eu_tpagcp WHERE date_deb > '".$traite_date_debut."')");   
    //}
    //if($traite_date_fin != ""){
    $select->where("traite_date_fin = ? ", $traite_date_fin);
    $select->where("traite_date_debut != ? ", $traite_date_fin);
    //}
    //if($traite_disponible > 0){
    //$select->where("traite_disponible = ? ", $traite_disponible);
    //}
    //if($traite_imprimer > 0){
    $select->where("traite_imprimer = ? ", $traite_imprimer);
    //}
    //if($traite_payer > 0){
    $select->where("traite_payer = ? ", $traite_payer);
    //}
    //if($mode_paiement != ""){
    $select->where("mode_paiement IN (?)", $mode_paiement);
    //}
    $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTraite();
            $entry->setTraite_id($row->traite_id)
                  ->setTraite_tegcp($row->traite_tegcp)
                  ->setTraite_code_banque($row->traite_code_banque)
                  ->setBon_id($row->bon_id)
                  ->setTraite_numero($row->traite_numero)
                  ->setTraite_date_debut($row->traite_date_debut)
                  ->setTraite_date_fin($row->traite_date_fin)
                  ->setTraite_disponible($row->traite_disponible)
                  ->setTraite_imprimer($row->traite_imprimer)
                  ->setTraite_escompte_nature($row->traite_escompte_nature)
                  ->setTraiter($row->traiter)
                  ->setTraite_montant($row->traite_montant)
                  ->setTraite_payer($row->traite_payer)
                  ->setTraite_avant_vte($row->traite_avant_vte)
                  ->setTraite_statut($row->traite_statut)
          ->setId_utilisateur($row->id_utilisateur)
                ->setId_utilisateur($row->id_utilisateur)
                ->setMode_paiement($row->mode_paiement)
                ->setReference_paiement($row->reference_paiement)
                ->setBon_type($row->bon_type)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
   


}


?>
