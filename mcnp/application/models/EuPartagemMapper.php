<?php
 
class Application_Model_EuPartagemMapper {

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
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuPartagem');
        }
        return $this->_dbTable;
    }

    public function find($partagem_id, Application_Model_EuPartagem $partagem) {
        $result = $this->getDbTable()->find($partagem_id);
        if (count($result) == 0) {
            return FALSE;
        }
        $row = $result->current();
        $partagem->setPartagem_id($row->partagem_id)
                ->setPartagem_membreasso($row->partagem_membreasso)
                ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
				;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
	                ->setPartagem_membreasso($row->partagem_membreasso)
	                ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(partagem_id) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function save(Application_Model_EuPartagem $partagem) {
        $data = array(
            'partagem_id' => $partagem->getPartagem_id(),
            'partagem_membreasso' => $partagem->getPartagem_membreasso(),
            'partagem_souscription' => $partagem->getPartagem_souscription(),
            'partagem_integrateur' => $partagem->getPartagem_integrateur(),
            'partagem_offreur_projet' => $partagem->getPartagem_offreur_projet(),
            'partagem_montant' => $partagem->getPartagem_montant(),
            'partagem_montant_utilise' => $partagem->getPartagem_montant_utilise(),
            'partagem_montant_solde' => $partagem->getPartagem_montant_solde(),
            'partagem_montant_impot' => $partagem->getPartagem_montant_impot(),
            'partagem_date' => $partagem->getPartagem_date(),
            'partagem_activation' => $partagem->getPartagem_activation(),
            'partagem_code_activation' => $partagem->getPartagem_code_activation()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPartagem $partagem) {
        $data = array(
            'partagem_membreasso' => $partagem->getPartagem_membreasso(),
            'partagem_souscription' => $partagem->getPartagem_souscription(),
            'partagem_integrateur' => $partagem->getPartagem_integrateur(),
            'partagem_offreur_projet' => $partagem->getPartagem_offreur_projet(),
            'partagem_montant' => $partagem->getPartagem_montant(),
            'partagem_montant_utilise' => $partagem->getPartagem_montant_utilise(),
            'partagem_montant_solde' => $partagem->getPartagem_montant_solde(),
            'partagem_montant_impot' => $partagem->getPartagem_montant_impot(),
            'partagem_date' => $partagem->getPartagem_date(),
            'partagem_activation' => $partagem->getPartagem_activation(),
            'partagem_code_activation' => $partagem->getPartagem_code_activation()
        );
        $this->getDbTable()->update($data, array('partagem_id = ?' => $partagem->getPartagem_id()));
    }

    public function delete($partagem_id) {
        $this->getDbTable()->delete(array('partagem_id = ?' => $partagem_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
	                ->setPartagem_membreasso($row->partagem_membreasso)
	                ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
				;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMembreassoSouscription($partagem_membreasso, $partagem_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("partagem_membreasso = ? ", $partagem_membreasso);
		$select->where("partagem_souscription = ? ", $partagem_souscription);
        $select->order(array("partagem_id DESC"));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
	                ->setPartagem_membreasso($row->partagem_membreasso)
	                ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
				;
			$entries = $entry;
        return $entries;
    }



    public function fetchAllByMembreassoIntegrateur($partagem_membreasso, $partagem_integrateur) {
        $select = $this->getDbTable()->select();
		$select->where("partagem_membreasso = ? ", $partagem_membreasso);
		$select->where("partagem_integrateur = ? ", $partagem_integrateur);
        $select->order(array("partagem_id DESC"));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
	                ->setPartagem_membreasso($row->partagem_membreasso)
	                ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
				;
			$entries = $entry;
        return $entries;
    }


    public function fetchAllByMembreassoOffreurProjet($partagem_membreasso, $partagem_offreur_projet) {
        $select = $this->getDbTable()->select();
		$select->where("partagem_membreasso = ? ", $partagem_membreasso);
		$select->where("partagem_offreur_projet = ? ", $partagem_offreur_projet);
        $select->order(array("partagem_id DESC"));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
	                ->setPartagem_membreasso($row->partagem_membreasso)
	                ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
				;
			$entries = $entry;
        return $entries;
    }
    
    public function findSomme($partagea_association = 0, $partagem_membreasso = 0, $partagem_souscription_date1, $partagem_souscription_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'SUM(partagem_montant_utilise) as UTILISE', 'SUM(partagem_montant_solde) as SOLDE', 'SUM(partagem_montant_impot) as IMPOT', 'partagem_membreasso'));
		if($partagea_association > 0){
		$select->where("partagem_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ? )", $partagea_association);
			}
		$select->where("partagem_souscription IN (SELECT souscription_id FROM eu_souscription WHERE publier = 3 AND (souscription_date) >= '".$partagem_souscription_date1."' AND (souscription_date) <= '".$partagem_souscription_date2."')");
		$select->group("partagem_membreasso");
		if($partagem_membreasso > 0){
		$select->having("partagem_membreasso = ? ", $partagem_membreasso);
			}
        $select->order(array("partagem_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$row = $resultSet->current();
        $entries = array();
        //foreach ($resultSet as $row) {
        $entry = array();
		$entry[0] = $row['SOMME'];
		$entry[1] = $row['UTILISE'];
		$entry[2] = $row['SOLDE'];
		$entry[4] = $row['IMPOT'];
		$entry[3] = $row['partagem_membreasso'];
            $entries = $entry;
        //}
        return $entries;
    }


    
    public function findSommeIntegrateur($partagea_association = 0, $partagem_membreasso = 0, $partagem_integrateur_date1, $partagem_integrateur_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'partagem_membreasso'));
		if($partagea_association > 0){
		$select->where("partagem_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ? )", $partagea_association);
			}
		$select->where("partagem_integrateur IN (SELECT integrateur_id FROM eu_integrateur WHERE publier = 1 AND (integrateur_date) >= '".$partagem_integrateur_date1."' AND (integrateur_date) <= '".$partagem_integrateur_date2."')");
		$select->group("partagem_membreasso");
		if($partagem_membreasso > 0){
		$select->having("partagem_membreasso = ? ", $partagem_membreasso);
			}
        $select->order(array("partagem_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
		$entry['SOMME'] = $row['SOMME'];
		$entry['partagem_membreasso'] = $row['partagem_membreasso'];
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function findSommeOffreurProjet($partagea_association = 0, $partagem_membreasso = 0, $partagem_offreur_projet_date1, $partagem_offreur_projet_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'partagem_membreasso'));
		if($partagea_association > 0){
		$select->where("partagem_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ? )", $partagea_association);
			}
		$select->where("partagem_offreur_projet IN (SELECT offreur_projet_id FROM eu_offreur_projet WHERE publier = 1 AND (offreur_projet_date) >= '".$partagem_offreur_projet_date1."' AND (offreur_projet_date) <= '".$partagem_offreur_projet_date2."')");
		$select->group("partagem_membreasso");
		if($partagem_membreasso > 0){
		$select->having("partagem_membreasso = ? ", $partagem_membreasso);
			}
        $select->order(array("partagem_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
		$entry['SOMME'] = $row['SOMME'];
		$entry['partagem_membreasso'] = $row['partagem_membreasso'];
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByCommissionSouscription($partagem_membreasso = 0, $partagem_souscription_date1, $partagem_souscription_date2) {
        $select = $this->getDbTable()->select();
		if($partagem_souscription_date1 != ""){
		$select->where("partagem_souscription IN (SELECT souscription_id FROM eu_souscription WHERE publier = 3 AND (souscription_date) >= '".$partagem_souscription_date1."' AND (souscription_date) <= '".$partagem_souscription_date2."')");
		}
		if($partagem_membreasso > 0){
		$select->where("partagem_membreasso = ? ", $partagem_membreasso);
			}
        $select->order(array("partagem_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
	                ->setPartagem_membreasso($row->partagem_membreasso)
	                ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
				;
            $entries[] = $entry;
        }
        return $entries;
    }














	public function fetchAllByPayer() {
		$select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);

        //$select = $this->getDbTable()->select()->setIntegrityCheck(false);
        //$select = $this->getDbTable()->select();
		$select->join('eu_validation_quittance', 'eu_validation_quittance.validation_quittance_souscription = eu_partagem.partagem_souscription');
        $select->where('eu_validation_quittance.validation_quittance_utilisateur = ?', 717);
        $select->where('eu_validation_quittance.validation_quittance_date <= ?', '2016-03-31');
        $select->order(array("partagem_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
	                ->setPartagem_membreasso($row->partagem_membreasso)
	                ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
				;
            $entries[] = $entry;
        }
        return $entries;
		
    }















 
    public function findSomme2($partagem_membreasso = 0, $partagem_souscription_date1, $partagem_souscription_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'SUM(partagem_montant_utilise) as UTILISE', 'SUM(partagem_montant_solde) as SOLDE', 'SUM(partagem_montant_impot) as IMPOT', 'partagem_membreasso'));
        if($partagem_souscription_date1 != ""){
        $select->where("partagem_souscription IN (SELECT souscription_id FROM eu_souscription WHERE publier = 3 AND (souscription_date) >= '".$partagem_souscription_date1."' AND (souscription_date) <= '".$partagem_souscription_date2."')");
        }
        $select->where("partagem_souscription != 0");
        $select->group("partagem_membreasso");
        if($partagem_membreasso > 0){
        $select->having("partagem_membreasso = ? ", $partagem_membreasso);
            }
        $select->order(array("partagem_membreasso DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagem_membreasso'];
             $entries[] = $entry;
        }
        return $entries;
    }




    public function fetchAllByCommissionAutre($partagem_membreasso = 0) {
        $select = $this->getDbTable()->select();
        $select->where("partagem_souscription = 0");
        if($partagem_membreasso > 0){
        $select->where("partagem_membreasso = ? ", $partagem_membreasso);
            }
        $select->order(array("partagem_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
                    ->setPartagem_membreasso($row->partagem_membreasso)
                    ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


public function findSomme22($partagem_membreasso = 0) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'SUM(partagem_montant_utilise) as UTILISE', 'SUM(partagem_montant_solde) as SOLDE', 'SUM(partagem_montant_impot) as IMPOT', 'partagem_membreasso'));
        $select->where("partagem_souscription = 0");
        $select->group("partagem_membreasso");
        if($partagem_membreasso > 0){
        $select->having("partagem_membreasso = ? ", $partagem_membreasso);
            }
        $select->order(array("partagem_membreasso DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagem_membreasso'];
             $entries[] = $entry;
        }
        return $entries;
    }










 
    public function findSomme3($partagem_membreasso = 0, $partagem_date1, $partagem_date2) {
        $partagem_date2_ = new Zend_Date($partagem_date2);
        $partagem_date2_->add('1', Zend_Date::DAY_SHORT);

        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'SUM(partagem_montant_utilise) as UTILISE', 'SUM(partagem_montant_solde) as SOLDE', 'SUM(partagem_montant_impot) as IMPOT', 'partagem_membreasso'));
        if($partagem_date1 != ""){
        $select->where("partagem_date >= '".$partagem_date1."' AND partagem_date <= '".$partagem_date2_->toString('yyyy-MM-dd')."'");
        }
        $select->where("partagem_souscription != 0");
        $select->group("partagem_membreasso");
        if($partagem_membreasso > 0){
        $select->having("partagem_membreasso = ? ", $partagem_membreasso);
            }
        $select->order(array("partagem_membreasso DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagem_membreasso'];
             $entries[] = $entry;
        }
        return $entries;
    }




public function findSomme33($partagem_membreasso = 0) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'SUM(partagem_montant_utilise) as UTILISE', 'SUM(partagem_montant_solde) as SOLDE', 'SUM(partagem_montant_impot) as IMPOT', 'partagem_membreasso'));
        $select->where("partagem_souscription = 0");
        $select->group("partagem_membreasso");
        if($partagem_membreasso > 0){
        $select->having("partagem_membreasso = ? ", $partagem_membreasso);
            }
        $select->order(array("partagem_membreasso DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagem_membreasso'];
             $entries[] = $entry;
        }
        return $entries;
    }






    public function fetchAllByCommissionSouscription3($partagem_membreasso = 0, $partagem_date1, $partagem_date2) {
        $partagem_date2_ = new Zend_Date($partagem_date2);
        $partagem_date2_->add('1', Zend_Date::DAY_SHORT);

        $select = $this->getDbTable()->select();
        if($partagem_date1 != ""){
        $select->where("partagem_date >= '".$partagem_date1."' AND partagem_date <= '".$partagem_date2_->toString('yyyy-MM-dd')."'");
        }
        $select->where("partagem_souscription != 0");
        if($partagem_membreasso > 0){
        $select->where("partagem_membreasso = ? ", $partagem_membreasso);
            }
        $select->order(array("partagem_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
                    ->setPartagem_membreasso($row->partagem_membreasso)
                    ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }




public function findMoisAnnee3() {
        $select = $this->getDbTable()->select();
        $select->distinct();
        $select->from($this->getDbTable(), array('MONTH(partagem_date) as MOIS, YEAR(partagem_date) as ANNEE'));
        $select->order(array("partagem_date DESC"));
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






 
    public function findSomme4($partagem_membreasso = 0) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'SUM(partagem_montant_utilise) as UTILISE', 'SUM(partagem_montant_solde) as SOLDE', 'SUM(partagem_montant_impot) as IMPOT', 'partagem_membreasso'));
        $select->group("partagem_membreasso");
        if($partagem_membreasso > 0){
        $select->having("partagem_membreasso = ? ", $partagem_membreasso);
            }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagem_membreasso'];
             $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByCommissionSouscription4($partagem_membreasso = 0) {
        $select = $this->getDbTable()->select();
        if($partagem_membreasso > 0){
        $select->where("partagem_membreasso = ? ", $partagem_membreasso);
            }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
                    ->setPartagem_membreasso($row->partagem_membreasso)
                    ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }









 
    public function findSomme5($partagem_membreasso = 0, $partagem_date1, $partagem_date2) {
        $partagem_date2_ = new Zend_Date($partagem_date2);
        $partagem_date2_->add('1', Zend_Date::DAY_SHORT);

        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagem_montant) as SOMME', 'SUM(partagem_montant_utilise) as UTILISE', 'SUM(partagem_montant_solde) as SOLDE', 'SUM(partagem_montant_impot) as IMPOT', 'partagem_membreasso'));
        $select->group("partagem_membreasso");
        if($partagem_membreasso > 0){
        $select->having("partagem_membreasso = ? ", $partagem_membreasso);
            }
        if($partagem_date1 != ""){
        $select->where("partagem_date >= '".$partagem_date1."'");
        }
        if($partagem_date2 != ""){
        $select->where("partagem_date <= '".$partagem_date2_->toString('yyyy-MM-dd')."'");
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagem_membreasso'];
             $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByCommissionSouscription5($partagem_membreasso = 0, $partagem_date1, $partagem_date2) {
        $partagem_date2_ = new Zend_Date($partagem_date2);
        $partagem_date2_->add('1', Zend_Date::DAY_SHORT);

        $select = $this->getDbTable()->select();
        if($partagem_membreasso > 0){
        $select->where("partagem_membreasso = ? ", $partagem_membreasso);
            }
        if($partagem_date1 != ""){
        $select->where("partagem_date >= '".$partagem_date1."'");
        }
        if($partagem_date2 != ""){
        $select->where("partagem_date <= '".$partagem_date2_->toString('yyyy-MM-dd')."'");
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
                    ->setPartagem_membreasso($row->partagem_membreasso)
                    ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }








    public function fetchAllByCommissionSouscription10($partagem_membreasso = 0, $partagem_date1, $partagem_date2) {
        $select = $this->getDbTable()->select();
        if($partagem_date1 != ""){
        $select->where("partagem_date >= '".$partagem_date1."' AND partagem_date <= '".$partagem_date2."'");
        }
        if($partagem_membreasso > 0){
        $select->where("partagem_membreasso = ? ", $partagem_membreasso);
            }
        //$select->where("partagem_montant_solde > 0");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagem();
            $entry->setPartagem_id($row->partagem_id)
                    ->setPartagem_membreasso($row->partagem_membreasso)
                    ->setPartagem_souscription($row->partagem_souscription)
                ->setPartagem_integrateur($row->partagem_integrateur)
                ->setPartagem_offreur_projet($row->partagem_offreur_projet)
                ->setPartagem_montant($row->partagem_montant)
                ->setPartagem_montant_utilise($row->partagem_montant_utilise)
                ->setPartagem_montant_solde($row->partagem_montant_solde)
                ->setPartagem_montant_impot($row->partagem_montant_impot)
                                ->setPartagem_date($row->partagem_date)
                ->setPartagem_activation($row->partagem_activation)
                ->setPartagem_code_activation($row->partagem_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }








}


?>
