<?php
 
class Application_Model_EuPartageaMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPartagea');
        }
        return $this->_dbTable;
    }

    public function find($partagea_id, Application_Model_EuPartagea $partagea) {
        $result = $this->getDbTable()->find($partagea_id);
        if (count($result) == 0) {
            return FALSE;
        }
        $row = $result->current();
        $partagea->setPartagea_id($row->partagea_id)
                ->setPartagea_association($row->partagea_association)
                ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
				->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
                ;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
	                ->setPartagea_association($row->partagea_association)
	                ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
				;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(partagea_id) as COUNT'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }

    public function save(Application_Model_EuPartagea $partagea) {
        $data = array(
            'partagea_id' => $partagea->getPartagea_id(),
            'partagea_association' => $partagea->getPartagea_association(),
            'partagea_souscription' => $partagea->getPartagea_souscription(),
            'partagea_integrateur' => $partagea->getPartagea_integrateur(),
            'partagea_offreur_projet' => $partagea->getPartagea_offreur_projet(),
            'partagea_montant' => $partagea->getPartagea_montant(),
            'partagea_montant_utilise' => $partagea->getPartagea_montant_utilise(),
            'partagea_montant_solde' => $partagea->getPartagea_montant_solde(),
            'partagea_montant_impot' => $partagea->getPartagea_montant_impot(),
            'partagea_date' => $partagea->getPartagea_date(),
            'partagea_activation' => $partagea->getPartagea_activation(),
            'partagea_code_activation' => $partagea->getPartagea_code_activation()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuPartagea $partagea) {
        $data = array(
            'partagea_association' => $partagea->getPartagea_association(),
            'partagea_souscription' => $partagea->getPartagea_souscription(),
            'partagea_integrateur' => $partagea->getPartagea_integrateur(),
            'partagea_offreur_projet' => $partagea->getPartagea_offreur_projet(),
            'partagea_montant' => $partagea->getPartagea_montant(),
            'partagea_montant_utilise' => $partagea->getPartagea_montant_utilise(),
            'partagea_montant_solde' => $partagea->getPartagea_montant_solde(),
            'partagea_montant_impot' => $partagea->getPartagea_montant_impot(),
            'partagea_date' => $partagea->getPartagea_date(),
            'partagea_activation' => $partagea->getPartagea_activation(),
            'partagea_code_activation' => $partagea->getPartagea_code_activation()
        );
        $this->getDbTable()->update($data, array('partagea_id = ?' => $partagea->getPartagea_id()));
    }

    public function delete($partagea_id) {
        $this->getDbTable()->delete(array('partagea_id = ?' => $partagea_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
        $select->order(array("partagea_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
	                ->setPartagea_association($row->partagea_association)
	                ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
				;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByAssociationSouscription($partagea_association, $partagea_souscription) {
        $select = $this->getDbTable()->select();
		$select->where("partagea_association = ? ", $partagea_association);
		$select->where("partagea_souscription = ? ", $partagea_souscription);
        $select->order(array("partagea_id DESC"));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
	                ->setPartagea_association($row->partagea_association)
	                ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
				->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
				;
			$entries = $entry;
        return $entries;
    }

    public function fetchAllByAssociationIntegrateur($partagea_association, $partagea_integrateur) {
        $select = $this->getDbTable()->select();
		$select->where("partagea_association = ? ", $partagea_association);
		$select->where("partagea_integrateur = ? ", $partagea_integrateur);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
	                ->setPartagea_association($row->partagea_association)
	                ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
				->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
				;
			$entries = $entry;
        return $entries;
    }


    public function fetchAllByAssociationOffreurProjet($partagea_association, $partagea_offreur_projet) {
        $select = $this->getDbTable()->select();
		$select->where("partagea_association = ? ", $partagea_association);
		$select->where("partagea_offreur_projet = ? ", $partagea_offreur_projet);
        $select->order(array("partagea_id DESC"));
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
	                ->setPartagea_association($row->partagea_association)
	                ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
				->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
				;
			$entries = $entry;
        return $entries;
    }

    
    public function findSomme($partagea_association = 0, $partagea_souscription_date1, $partagea_souscription_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'SUM(partagea_montant_utilise) as UTILISE', 'SUM(partagea_montant_solde) as SOLDE', 'SUM(partagea_montant_impot) as IMPOT', 'partagea_association'));
		if($partagea_souscription_date1 != ""){
		$select->where("partagea_souscription IN (SELECT souscription_id FROM eu_souscription WHERE publier = 3 AND (souscription_date) >= '".$partagea_souscription_date1."' AND (souscription_date) <= '".$partagea_souscription_date2."')");
		}
		$select->group("partagea_association");
		if($partagea_association > 0){
		$select->having("partagea_association = ? ", $partagea_association);
			}
        $select->order(array("partagea_association DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
		$row = $resultSet->current();
        $entries = array();
        //foreach ($resultSet as $row) {
        $entry = array();
		$entry[0] = $row['SOMME'];
		$entry[1] = $row['UTILISE'];
		$entry[2] = $row['SOLDE'];
		$entry[4] = $row['IMPOT'];
		$entry[3] = $row['partagea_association'];
            $entries = $entry;
        //}
        return $entries;
    }


    
    public function findSommeIntegrateur($partagea_association = 0, $partagea_integrateur_date1, $partagea_integrateur_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'partagea_association'));
		$select->where("partagea_integrateur IN (SELECT integrateur_id FROM eu_integrateur WHERE publier = 1 AND (integrateur_date) >= '".$partagea_integrateur_date1."' AND (integrateur_date) <= '".$partagea_integrateur_date2."')");
		$select->group("partagea_association");
		if($partagea_association > 0){
		$select->having("partagea_association = ? ", $partagea_association);
			}
        $select->order(array("partagea_association DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
		$entry['SOMME'] = $row['SOMME'];
		$entry['partagea_association'] = $row['partagea_association'];
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findSommeOffreurProjet($partagea_association = 0, $partagea_offreur_projet_date1, $partagea_offreur_projet_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'partagea_association'));
		$select->where("partagea_offreur_projet IN (SELECT offreur_projet_id FROM eu_offreur_projet WHERE publier = 1 AND (offreur_projet_date) >= '".$partagea_offreur_projet_date1."' AND (offreur_projet_date) <= '".$partagea_offreur_projet_date2."')");
		$select->group("partagea_association");
		if($partagea_association > 0){
		$select->having("partagea_association = ? ", $partagea_association);
			}
        $select->order(array("partagea_association DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
		$entry['SOMME'] = $row['SOMME'];
		$entry['partagea_association'] = $row['partagea_association'];
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByCommissionSouscription($partagea_association = 0, $partagea_souscription_date1, $partagea_souscription_date2) {
        $select = $this->getDbTable()->select();
		if($partagea_souscription_date1 != ""){
		$select->where("partagea_souscription IN (SELECT souscription_id FROM eu_souscription WHERE publier = 3 AND (souscription_date) >= '".$partagea_souscription_date1."' AND (souscription_date) <= '".$partagea_souscription_date2."')");
		}
		if($partagea_association > 0){
		$select->where("partagea_association = ? ", $partagea_association);
			}
        $select->order(array("partagea_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
	                ->setPartagea_association($row->partagea_association)
	                ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
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
		$select->join('eu_validation_quittance', 'eu_validation_quittance.validation_quittance_souscription = eu_partagea.partagea_souscription');
        $select->where('eu_validation_quittance.validation_quittance_utilisateur = ?', 717);
        $select->where('eu_validation_quittance.validation_quittance_date <= ?', '2016-03-31');
        $select->order(array("partagea_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
	                ->setPartagea_association($row->partagea_association)
	                ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
				;
            $entries[] = $entry;
        }
        return $entries;
		
    }







    public function findMoisAnnee() {
        $select = $this->getDbTable()->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
        $select->distinct();
        //$select->setIntegrityCheck(false);
        $select->from($this->getDbTable(), array('MONTH(partagea_date) as MOIS, YEAR(partagea_date) as ANNEE'));
        //$select->join('eu_souscription', 'eu_souscription.souscription_id = eu_partagea.partagea_souscription', array('MONTH(eu_souscription.souscription_date) as MOIS, YEAR(eu_souscription.souscription_date) as ANNEE'));
        //$select = $this->getDbTable()->select();
        //$select->from($this->getDbTable(), array('MONTH(souscription_date) as MOIS, YEAR(souscription_date) as ANNEE'));
        //$select->where("eu_souscription.publier = ? ", 3);
        $select->order(array("partagea_date DESC"));
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


    public function findMoisAnneeAssociation($association) {
		$select = $this->getDbTable()->select();//Zend_Db_Table::SELECT_WITH_FROM_PART
		$select->distinct();
        $select->setIntegrityCheck(false);
        $select->from($this->getDbTable(), array());
		$select->join('eu_souscription', 'eu_souscription.souscription_id = eu_partagea.partagea_souscription', array('MONTH(eu_souscription.souscription_date) as MOIS, YEAR(eu_souscription.souscription_date) as ANNEE'));
        //$select = $this->getDbTable()->select();
        //$select->from($this->getDbTable(), array('MONTH(souscription_date) as MOIS, YEAR(souscription_date) as ANNEE'));
		$select->where("eu_souscription.souscription_membreasso IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association);
		$select->where("eu_souscription.publier = ? ", 3);
		$select->order(array("eu_souscription.souscription_date DESC"));
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








 
    public function findSomme2($partagea_association = 0, $partagea_souscription_date1, $partagea_souscription_date2) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'SUM(partagea_montant_utilise) as UTILISE', 'SUM(partagea_montant_solde) as SOLDE', 'SUM(partagea_montant_impot) as IMPOT', 'partagea_association'));
        if($partagea_souscription_date1 != ""){
        $select->where("partagea_souscription IN (SELECT souscription_id FROM eu_souscription WHERE publier = 3 AND (souscription_date) >= '".$partagea_souscription_date1."' AND (souscription_date) <= '".$partagea_souscription_date2."')");
        }
        $select->where("partagea_souscription != 0");
        $select->group("partagea_association");
        if($partagea_association > 0){
        $select->having("partagea_association = ? ", $partagea_association);
            }
        $select->order(array("partagea_association DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagea_association'];
             $entries[] = $entry;
        }
        return $entries;
    }





public function fetchAllByCommissionAutre($partagea_association = 0) {
        $select = $this->getDbTable()->select();
        $select->where("partagea_souscription = 0");
        if($partagea_association > 0){
        $select->where("partagea_association = ? ", $partagea_association);
            }
        $select->order(array("partagea_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
                    ->setPartagea_association($row->partagea_association)
                    ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }




public function findSomme22($partagea_association = 0) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'SUM(partagea_montant_utilise) as UTILISE', 'SUM(partagea_montant_solde) as SOLDE', 'SUM(partagea_montant_impot) as IMPOT', 'partagea_association'));
        $select->where("partagea_souscription  = 0");
        $select->group("partagea_association");
        if($partagea_association > 0){
        $select->having("partagea_association = ? ", $partagea_association);
            }
        $select->order(array("partagea_association DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagea_association'];
             $entries[] = $entry;
        }
        return $entries;
    }






public function findSomme3($partagea_association = 0, $partagea_date1, $partagea_date2) {
        $partagea_date2_ = new Zend_Date($partagea_date2);
        $partagea_date2_->add('1', Zend_Date::DAY_SHORT);

        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'SUM(partagea_montant_utilise) as UTILISE', 'SUM(partagea_montant_solde) as SOLDE', 'SUM(partagea_montant_impot) as IMPOT', 'partagea_association'));
        if($partagea_date1 != ""){
        $select->where("partagea_date >= '".$partagea_date1."' AND partagea_date <= '".$partagea_date2_->toString('yyyy-MM-dd')."'");
        }
        $select->where("partagea_souscription != 0");
        $select->group("partagea_association");
        if($partagea_association > 0){
        $select->having("partagea_association = ? ", $partagea_association);
            }
        $select->order(array("partagea_association DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagea_association'];
             $entries[] = $entry;
        }
        return $entries;
    }


public function findSomme33($partagea_association = 0) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'SUM(partagea_montant_utilise) as UTILISE', 'SUM(partagea_montant_solde) as SOLDE', 'SUM(partagea_montant_impot) as IMPOT', 'partagea_association'));
        $select->where("partagea_souscription = 0");
        $select->group("partagea_association");
        if($partagea_association > 0){
        $select->having("partagea_association = ? ", $partagea_association);
            }
        $select->order(array("partagea_association DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagea_association'];
             $entries[] = $entry;
        }
        return $entries;
    }





    public function fetchAllByCommissionSouscription3($partagea_association = 0, $partagea_date1, $partagea_date2) {
        $partagea_date2_ = new Zend_Date($partagea_date2);
        $partagea_date2_->add('1', Zend_Date::DAY_SHORT);

        $select = $this->getDbTable()->select();
        if($partagea_date1 != ""){
        $select->where("partagea_date >= '".$partagea_date1."' AND partagea_date <= '".$partagea_date2_->toString('yyyy-MM-dd')."'");
        }
        $select->where("partagea_souscription != 0");
        if($partagea_association > 0){
        $select->where("partagea_association = ? ", $partagea_association);
            }
        $select->order(array("partagea_id DESC"));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
                    ->setPartagea_association($row->partagea_association)
                    ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }



public function findMoisAnnee3() {
        $select = $this->getDbTable()->select();
        $select->distinct();
        $select->from($this->getDbTable(), array('MONTH(partagea_date) as MOIS, YEAR(partagea_date) as ANNEE'));
        $select->order(array("partagea_date DESC"));
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









public function findSomme4($partagea_association = 0) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'SUM(partagea_montant_utilise) as UTILISE', 'SUM(partagea_montant_solde) as SOLDE', 'SUM(partagea_montant_impot) as IMPOT', 'partagea_association'));
        $select->group("partagea_association");
        if($partagea_association > 0){
        $select->having("partagea_association = ? ", $partagea_association);
            }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagea_association'];
             $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByCommissionSouscription4($partagea_association = 0) {
        $select = $this->getDbTable()->select();
        if($partagea_association > 0){
        $select->where("partagea_association = ? ", $partagea_association);
            }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
                    ->setPartagea_association($row->partagea_association)
                    ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }







public function findSomme5($partagea_association = 0, $partagea_date1, $partagea_date2) {
        $partagea_date2_ = new Zend_Date($partagea_date2);
        $partagea_date2_->add('1', Zend_Date::DAY_SHORT);

        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(partagea_montant) as SOMME', 'SUM(partagea_montant_utilise) as UTILISE', 'SUM(partagea_montant_solde) as SOLDE', 'SUM(partagea_montant_impot) as IMPOT', 'partagea_association'));
        $select->group("partagea_association");
        if($partagea_association > 0){
        $select->having("partagea_association = ? ", $partagea_association);
            }
        if($partagea_date1 != ""){
        $select->where("partagea_date >= '".$partagea_date1."'");
        }
        if($partagea_date2 != ""){
        $select->where("partagea_date <= '".$partagea_date2_->toString('yyyy-MM-dd')."'");
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
        $entry = array();
        $entry[0] = $row['SOMME'];
        $entry[1] = $row['UTILISE'];
        $entry[2] = $row['SOLDE'];
        $entry[4] = $row['IMPOT'];
        $entry[3] = $row['partagea_association'];
             $entries[] = $entry;
        }
        return $entries;
    }

 

    public function fetchAllByCommissionSouscription5($partagea_association = 0, $partagea_date1, $partagea_date2) {
        $partagea_date2_ = new Zend_Date($partagea_date2);
        $partagea_date2_->add('1', Zend_Date::DAY_SHORT);

        $select = $this->getDbTable()->select();
        if($partagea_association > 0){
        $select->where("partagea_association = ? ", $partagea_association);
            }
        if($partagea_date1 != ""){
        $select->where("partagea_date >= '".$partagea_date1."'");
        }
        if($partagea_date2 != ""){
        $select->where("partagea_date <= '".$partagea_date2_->toString('yyyy-MM-dd')."'");
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
                    ->setPartagea_association($row->partagea_association)
                    ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }





    public function fetchAllByCommissionSouscription10($partagea_association = 0, $partagea_date1 = "", $partagea_date2 = "") {
        $select = $this->getDbTable()->select();
        if($partagea_date1 != ""){
        $select->where("partagea_date >= '".$partagea_date1."' AND partagea_date <= '".$partagea_date2."'");
        }
        if($partagea_association > 0){
        $select->where("partagea_association = ? ", $partagea_association);
            }
        //$select->where("partagea_montant_solde > 0");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPartagea();
            $entry->setPartagea_id($row->partagea_id)
                    ->setPartagea_association($row->partagea_association)
                    ->setPartagea_souscription($row->partagea_souscription)
                ->setPartagea_integrateur($row->partagea_integrateur)
                ->setPartagea_offreur_projet($row->partagea_offreur_projet)
                ->setPartagea_montant($row->partagea_montant)
                ->setPartagea_montant_utilise($row->partagea_montant_utilise)
                ->setPartagea_montant_solde($row->partagea_montant_solde)
                ->setPartagea_montant_impot($row->partagea_montant_impot)
                ->setPartagea_date($row->partagea_date)
                ->setPartagea_activation($row->partagea_activation)
                ->setPartagea_code_activation($row->partagea_code_activation)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
