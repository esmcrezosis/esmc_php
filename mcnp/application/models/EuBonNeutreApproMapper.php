<?php
 
class Application_Model_EuBonNeutreApproMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonNeutreAppro');
        }
        return $this->_dbTable;
    }

    public function find($bon_neutre_appro_id, Application_Model_EuBonNeutreAppro $bon_neutre_appro) {
        $result = $this->getDbTable()->find($bon_neutre_appro_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $bon_neutre_appro->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                ->setBon_neutre_appro_apporteur($row->bon_neutre_appro_apporteur)
                ->setBon_neutre_appro_montant($row->bon_neutre_appro_montant)
                ->setBon_neutre_appro_beneficiaire($row->bon_neutre_appro_beneficiaire)
                ->setBon_neutre_appro_date($row->bon_neutre_appro_date)
                ->setBon_neutre_appro_banque_user($row->bon_neutre_appro_banque_user)
                ->setBon_neutre_appro_commission($row->bon_neutre_appro_commission)
                ;
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
        $select->order("bon_neutre_appro_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreAppro();
            $entry->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_apporteur($row->bon_neutre_appro_apporteur)
                    ->setBon_neutre_appro_montant($row->bon_neutre_appro_montant)
                    ->setBon_neutre_appro_beneficiaire($row->bon_neutre_appro_beneficiaire)
                    ->setBon_neutre_appro_date($row->bon_neutre_appro_date)
                    ->setBon_neutre_appro_banque_user($row->bon_neutre_appro_banque_user)
                ->setBon_neutre_appro_commission($row->bon_neutre_appro_commission)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(bon_neutre_appro_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBonNeutreAppro $bon_neutre_appro) {
        $data = array(
            'bon_neutre_appro_id' => $bon_neutre_appro->getBon_neutre_appro_id(),
            'bon_neutre_appro_apporteur' => $bon_neutre_appro->getBon_neutre_appro_apporteur(),
            'bon_neutre_appro_montant' => $bon_neutre_appro->getBon_neutre_appro_montant(),
            'bon_neutre_appro_beneficiaire' => $bon_neutre_appro->getBon_neutre_appro_beneficiaire(),
            'bon_neutre_appro_banque_user' => $bon_neutre_appro->getBon_neutre_appro_banque_user(),
            'bon_neutre_appro_commission' => $bon_neutre_appro->getBon_neutre_appro_commission(),
            'bon_neutre_appro_date' => $bon_neutre_appro->getBon_neutre_appro_date()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonNeutreAppro $bon_neutre_appro) {
        $data = array(
            'bon_neutre_appro_id' => $bon_neutre_appro->getBon_neutre_appro_id(),
            'bon_neutre_appro_apporteur' => $bon_neutre_appro->getBon_neutre_appro_apporteur(),
            'bon_neutre_appro_montant' => $bon_neutre_appro->getBon_neutre_appro_montant(),
            'bon_neutre_appro_beneficiaire' => $bon_neutre_appro->getBon_neutre_appro_beneficiaire(),
            'bon_neutre_appro_banque_user' => $bon_neutre_appro->getBon_neutre_appro_banque_user(),
            'bon_neutre_appro_commission' => $bon_neutre_appro->getBon_neutre_appro_commission(),
            'bon_neutre_appro_date' => $bon_neutre_appro->getBon_neutre_appro_date()
        );
        $this->getDbTable()->update($data, array('bon_neutre_appro_id = ?' => $bon_neutre_appro->getBon_neutre_appro_id()));
    }

    public function delete($bon_neutre_appro_id) {
        $this->getDbTable()->delete(array('bon_neutre_appro_id = ?' => $bon_neutre_appro_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
        $select->order("bon_neutre_appro_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreAppro();
            $entry->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_apporteur($row->bon_neutre_appro_apporteur)
                    ->setBon_neutre_appro_montant($row->bon_neutre_appro_montant)
                    ->setBon_neutre_appro_beneficiaire($row->bon_neutre_appro_beneficiaire)
                    ->setBon_neutre_appro_date($row->bon_neutre_appro_date)
                    ->setBon_neutre_appro_banque_user($row->bon_neutre_appro_banque_user)
                ->setBon_neutre_appro_commission($row->bon_neutre_appro_commission)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByBeneficiaire($bon_neutre_appro_beneficiaire) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_appro_beneficiaire = ? ", $bon_neutre_appro_beneficiaire);
        $select->order("bon_neutre_appro_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreAppro();
            $entry->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_apporteur($row->bon_neutre_appro_apporteur)
                    ->setBon_neutre_appro_montant($row->bon_neutre_appro_montant)
                    ->setBon_neutre_appro_beneficiaire($row->bon_neutre_appro_beneficiaire)
                    ->setBon_neutre_appro_date($row->bon_neutre_appro_date)
                    ->setBon_neutre_appro_banque_user($row->bon_neutre_appro_banque_user)
                ->setBon_neutre_appro_commission($row->bon_neutre_appro_commission)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByApporteur($bon_neutre_appro_apporteur) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_appro_apporteur = ? ", $bon_neutre_appro_apporteur);
        $select->order("bon_neutre_appro_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreAppro();
            $entry->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_apporteur($row->bon_neutre_appro_apporteur)
                    ->setBon_neutre_appro_montant($row->bon_neutre_appro_montant)
                    ->setBon_neutre_appro_beneficiaire($row->bon_neutre_appro_beneficiaire)
                    ->setBon_neutre_appro_date($row->bon_neutre_appro_date)
                    ->setBon_neutre_appro_banque_user($row->bon_neutre_appro_banque_user)
                ->setBon_neutre_appro_commission($row->bon_neutre_appro_commission)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByBonNeutre($bon_neutre_id) {
        $select = $this->getDbTable()->select();
        $select->where("bon_neutre_appro_id IN (SELECT bon_neutre_appro_id FROM eu_bon_neutre WHERE bon_neutre_id = ? )", $bon_neutre_id);
        $select->order("bon_neutre_appro_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreAppro();
            $entry->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_apporteur($row->bon_neutre_appro_apporteur)
                    ->setBon_neutre_appro_montant($row->bon_neutre_appro_montant)
                    ->setBon_neutre_appro_beneficiaire($row->bon_neutre_appro_beneficiaire)
                    ->setBon_neutre_appro_date($row->bon_neutre_appro_date)
                    ->setBon_neutre_appro_banque_user($row->bon_neutre_appro_banque_user)
                ->setBon_neutre_appro_commission($row->bon_neutre_appro_commission)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }




    
    public function findMoisAnnee() {
        $select = $this->getDbTable()->select();
        $select->distinct();
        $select->from($this->getDbTable(), array('MONTH(bon_neutre_appro_date) as MOIS, YEAR(bon_neutre_appro_date) as ANNEE'));
        $select->order(array("bon_neutre_appro_date DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
           $entry = array();
           $entry['MOIS'] = $row['MOIS'];
           $entry['ANNEE'] = $row['ANNEE'];
           $entries[] = $entry;
        }
        return $entries;
   }




 
    public function findSomme3($bon_neutre_appro_apporteur = "", $bon_neutre_appro_date1, $bon_neutre_appro_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(bon_neutre_appro_montant) as SOMME', 'bon_neutre_appro_apporteur'));
        if($bon_neutre_appro_date1 != ""){
        $select->where("bon_neutre_appro_date >= '".$bon_neutre_appro_date1."' AND bon_neutre_appro_date <= '".$bon_neutre_appro_date2."'");
        }
        $select->where("bon_neutre_appro_id IN (SELECT bon_neutre_appro_id FROM eu_bon_neutre_appro_detail WHERE bon_neutre_detail_id IN (SELECT bon_neutre_detail_id FROM eu_bon_neutre_detail WHERE bon_neutre_detail_banque IS NOT NULL))");
        $select->group("bon_neutre_appro_apporteur");
        if($bon_neutre_appro_apporteur != ""){
        $select->having("bon_neutre_appro_apporteur = ? ", $bon_neutre_appro_apporteur);
            }
        $resultSet = $this->getDbTable()->fetchRow($select);
        $entries = array();
        //foreach ($resultSet as $row) {
        $row = $resultSet;
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['bon_neutre_appro_apporteur'];
             $entries = $entry;
        //}
        return $entries;
    }



    public function fetchAllByCommission3($bon_neutre_appro_apporteur = "", $bon_neutre_appro_date1, $bon_neutre_appro_date2) {
        $select = $this->getDbTable()->select();
        if($bon_neutre_appro_date1 != ""){
        $select->where("bon_neutre_appro_date >= '".$bon_neutre_appro_date1."' AND bon_neutre_appro_date <= '".$bon_neutre_appro_date2."'");
        }
        if($bon_neutre_appro_apporteur != ""){
        $select->where("bon_neutre_appro_apporteur = ? ", $bon_neutre_appro_apporteur);
            }
        $select->where("bon_neutre_appro_id IN (SELECT bon_neutre_appro_id FROM eu_bon_neutre_appro_detail WHERE bon_neutre_detail_id IN (SELECT bon_neutre_detail_id FROM eu_bon_neutre_detail WHERE bon_neutre_detail_banque IS NOT NULL))");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreAppro();
            $entry->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_apporteur($row->bon_neutre_appro_apporteur)
                    ->setBon_neutre_appro_montant($row->bon_neutre_appro_montant)
                    ->setBon_neutre_appro_beneficiaire($row->bon_neutre_appro_beneficiaire)
                    ->setBon_neutre_appro_date($row->bon_neutre_appro_date)
                    ->setBon_neutre_appro_banque_user($row->bon_neutre_appro_banque_user)
                ->setBon_neutre_appro_commission($row->bon_neutre_appro_commission)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }

/*SELECT code_membre, nom_membre, prenom_membre, relevebancairedetail_libelle, portable_membre, bon_neutre_code_membre, bon_neutre_appro_apporteur, bon_neutre_appro_beneficiaire, relevebancairedetail_montant  
FROM eu_membre m, eu_bon_neutre bn, eu_bon_neutre_appro bna, eu_bon_neutre_appro_detail bnad, eu_bon_neutre_detail bnd, eu_relevebancairedetail r  
WHERE bna.bon_neutre_appro_id = bnad.bon_neutre_appro_id 
AND bnad.bon_neutre_detail_id = bnd.bon_neutre_detail_id 
AND bn.bon_neutre_id = bnd.bon_neutre_id 
AND m.code_membre = bn.bon_neutre_code_membre 
AND r.relevebancairedetail_numero LIKE CONCAT('%', bnd.bon_neutre_detail_numero, '%')
AND r.relevebancairedetail_libelle LIKE CONCAT('%', m.nom_membre, '%');*/


    public function findSomme10($bon_neutre_appro_apporteur = "", $bon_neutre_appro_date1, $bon_neutre_appro_date2) {
        $bon_neutre_appro = new Application_Model_DbTable_EuBonNeutreAppro();
        $select = $bon_neutre_appro->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->from($bon_neutre_appro, array('SUM(eu_bon_neutre_appro.bon_neutre_appro_montant) as SOMME', 'eu_bon_neutre_appro.bon_neutre_appro_apporteur'));
        $select->join('eu_bon_neutre_detail', 'eu_bon_neutre_detail.bon_neutre_detail_id = eu_bon_neutre_appro_detail.bon_neutre_detail_id');
        $select->join('eu_bon_neutre_appro_detail', 'eu_bon_neutre_appro_detail.bon_neutre_appro_id = eu_bon_neutre_appro.bon_neutre_appro_id');
        $select->join('eu_bon_neutre', 'eu_bon_neutre.bon_neutre_id = eu_bon_neutre_detail.bon_neutre_id');
        $select->join('eu_membre', 'eu_membre.code_membre = eu_bon_neutre.bon_neutre_code_membre');
        if($bon_neutre_appro_date1 != ""){
        $select->where("eu_bon_neutre_appro.bon_neutre_appro_date >= '".$bon_neutre_appro_date1."' AND eu_bon_neutre_appro.bon_neutre_appro_date <= '".$bon_neutre_appro_date2."'");
        }
        $select->where("eu_bon_neutre_detail.bon_neutre_detail_banque IS NOT NULL");
        $select->where("eu_bon_neutre_appro.bon_neutre_appro_commission = 0");
        $select->where("eu_bon_neutre_appro.bon_neutre_appro_banque_user IS NULL");
        $select->group("eu_bon_neutre_appro.bon_neutre_appro_apporteur");
        if($bon_neutre_appro_apporteur != ""){
        $select->having("eu_bon_neutre_appro.bon_neutre_appro_apporteur = ? ", $bon_neutre_appro_apporteur);
            }
        $resultSet = $bon_neutre_appro->fetchRow($select);
        $entries = array();
        //foreach ($resultSet as $row) {
        $row = $resultSet;
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['eu_bon_neutre_appro.bon_neutre_appro_apporteur'];
             $entries = $entry;
        //}
        return $entries;
    }


    public function fetchAllByCommission10($bon_neutre_appro_apporteur = "", $bon_neutre_appro_date1, $bon_neutre_appro_date2) {
        $select = $this->getDbTable()->select();
        if($bon_neutre_appro_date1 != ""){
        $select->where("bon_neutre_appro_date >= '".$bon_neutre_appro_date1."' AND bon_neutre_appro_date <= '".$bon_neutre_appro_date2."'");
        }
        if($bon_neutre_appro_apporteur != ""){
        $select->where("bon_neutre_appro_apporteur = ? ", $bon_neutre_appro_apporteur);
            }
        $select->where("bon_neutre_appro_id IN (SELECT bon_neutre_appro_id FROM eu_bon_neutre_appro_detail WHERE bon_neutre_detail_id IN (SELECT bon_neutre_detail_id FROM eu_bon_neutre_detail WHERE bon_neutre_detail_banque IS NOT NULL))");
        $select->where("bon_neutre_appro_commission = 0");
        $select->where("bon_neutre_appro_banque_user IS NULL");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonNeutreAppro();
            $entry->setBon_neutre_appro_id($row->bon_neutre_appro_id)
                    ->setBon_neutre_appro_apporteur($row->bon_neutre_appro_apporteur)
                    ->setBon_neutre_appro_montant($row->bon_neutre_appro_montant)
                    ->setBon_neutre_appro_beneficiaire($row->bon_neutre_appro_beneficiaire)
                    ->setBon_neutre_appro_date($row->bon_neutre_appro_date)
                    ->setBon_neutre_appro_banque_user($row->bon_neutre_appro_banque_user)
                ->setBon_neutre_appro_commission($row->bon_neutre_appro_commission)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
}


?>
