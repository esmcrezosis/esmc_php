<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuOperationMapper
 *
 * @author user
 */
class Application_Model_EuOperationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuOperation');
        }
        return $this->_dbTable;
    }

    public function find($num_op, Application_Model_EuOperation $operation) {
        $result = $this->getDbTable()->find($num_op);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $operation->setId_operation($row->id_operation)
                ->setDate_op($row->date_op)
                ->setHeure_op($row->heure_op)
                ->setMontant_op($row->montant_op)
                ->setCode_membre($row->code_membre)
				->setCode_membre_morale($row->code_membre_morale)
                ->setCode_produit($row->code_produit)
                ->setId_utilisateur($row->id_utilisateur)
                ->setLib_op($row->lib_op)
                ->setCode_cat($row->code_cat)
                ->setType_op($row->type_op);
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_operation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	public function findlastinsert() {
		$last_id = $this->getDbTable()->lastInsertId();
        return $last_id;
	}
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOperation();
            $entry->setId_operation($row->id_operation)
                    ->setDate_op($row->date_op)
                    ->setHeure_op($row->heure_op)
                    ->setMontant_op($row->montant_op)
                    ->setCode_membre($row->code_membre)
					->setCode_membre_morale($row->code_membre_morale)
                    ->setCode_produit($row->code_produit)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setLib_op($row->lib_op)
                    ->setCode_cat($row->code_cat)
                    ->setType_op($row->type_op);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByUser($user) {
        $select = $this->getDbTable()->select();
        $select->where('id_utilisateur=?', $user)
                ->order('date_op', 'ASC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOperation();
            $entry->setId_operation($row->id_operation)
                    ->setDate_op($row->date_op)
                    ->setHeure_op($row->heure_op)
                    ->setMontant_op($row->montant_op)
                    ->setCode_membre($row->code_membre)
					->setCode_membre_morale($row->code_membre_morale)
                    ->setCode_produit($row->code_produit)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setLib_op($row->lib_op)
                    ->setCode_cat($row->code_cat)
                    ->setType_op($row->type_op);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByUserAndDate($user, $date) {
        $select = $this->getDbTable()->select();
        $select->where('id_utilisateur = ?', $user)
                ->where('date_op=?', $date)
                ->order('date_op', 'ASC');
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOperation();
            $entry->setId_operation($row->id_operation)
                    ->setDate_op($row->date_op)
                    ->setHeure_op($row->heure_op)
                    ->setMontant_op($row->montant_op)
                    ->setCode_membre($row->code_membre)
					->setCode_membre_morale($row->code_membre_morale)
                    ->setCode_produit($row->code_produit)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setLib_op($row->lib_op)
                    ->setCode_cat($row->code_cat)
                    ->setType_op($row->type_op);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getSumRPG($num_membre,$cat_compte) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_op) as somme'));
        $select->where('code_membre = ?', $num_membre);
        $select->where('code_cat = ?', $cat_compte);
        $select->where('type_op = ?', 'CAPARPG');
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

    public function save(Application_Model_EuOperation $operation) {
        $data = array(
            'id_operation' => $operation->getId_operation(),
            'date_op' => $operation->getDate_op(),
            'montant_op' => $operation->getMontant_op(),
            'code_membre' => $operation->getCode_membre(),
			'code_membre_morale' => $operation->getCode_membre_morale(),
            'heure_op' => $operation->getHeure_op(),
            'code_produit' => $operation->getCode_produit(),
            'id_utilisateur' => $operation->getId_utilisateur(),
            'lib_op' => $operation->getLib_op(),
            'code_cat' => $operation->getCode_cat(),
            'type_op' => $operation->getType_op()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuOperation $operation) {
        $data = array(
            'id_operation' => $operation->getId_operation(),
            'date_op' => $operation->getDate_op(),
            'montant_op' => $operation->getMontant_op(),
            'code_membre' => $operation->getCode_membre(),
			'code_membre_morale' => $operation->getCode_membre_morale(),
            'heure_op' => $operation->getHeure_op(),
            'code_produit' => $operation->getCode_produit(),
            'id_utilisateur' => $operation->getId_utilisateur(),
            'lib_op' => $operation->getLib_op(),
            'code_cat' => $operation->getCode_cat(),
            'type_op' => $operation->getType_op()
        );

        $this->getDbTable()->update($data, array('id_operation = ?' => $operation->getId_operation()));
    }

    public function delete($id_operation) {
        $this->getDbTable()->delete(array('id_operation = ?' => $id_operation));
    }
///////////////////////////////////////////////////////////////
    public function fetchAll2($code_membre, $code_cat, $code_produit) {
        $select = $this->getDbTable()->select();
				if(isset($code_membre) && $code_membre!=""){
					if (substr($code_membre, -1) == "P") {
						$select->where("code_membre LIKE '%".$code_membre."'");
					}else if (substr($code_membre, -1) == "M") {
						$select->where("code_membre_morale LIKE '%".$code_membre."'");
					}
		}
		if(isset($code_cat) && $code_cat!=""){
		$select->where('code_cat = ?', $code_cat);}
		if(isset($code_produit) && $code_produit!=""){
		$select->where('code_produit = ?', $code_produit);}
        $select->order(array('id_operation DESC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOperation();
            $entry->setId_operation($row->id_operation)
                    ->setDate_op($row->date_op)
                    ->setHeure_op($row->heure_op)
                    ->setMontant_op($row->montant_op)
                    ->setCode_membre($row->code_membre)
					->setCode_membre_morale($row->code_membre_morale)
                    ->setCode_produit($row->code_produit)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setLib_op($row->lib_op)
                    ->setCode_cat($row->code_cat)
                    ->setType_op($row->type_op);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function findByTypeopSolde($code_membre, $type_op, Application_Model_EuOperation $Operation) {
        $table = new Application_Model_DbTable_EuOperation();
        $select = $table->select();
		if(isset($code_membre) && $code_membre!=""){
					if (substr($code_membre, -1) == "P") {
		$select->from(array('eu_operation'), array('code_membre', 'type_op', 'solde' => 'SUM(montant_op)'));
        $select->group(array('code_membre', 'type_op'));
						$select->having("code_membre LIKE '%".$code_membre."'");
					}else if (substr($code_membre, -1) == "M") {
		$select->from(array('eu_operation'), array('code_membre_morale', 'type_op', 'solde' => 'SUM(montant_op)'));
        $select->group(array('code_membre_morale', 'type_op'));
						$select->having("code_membre_morale LIKE '%".$code_membre."'");
					}
		}
		if(isset($type_op) && $type_op!=""){		
		$select->having('type_op LIKE ?', $type_op);}
        $result = $table->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
        $Operation->setType_op($row->type_op)
                ->setMontant_op($row->solde);
		if(isset($code_membre) && $code_membre!=""){
					if (substr($code_membre, -1) == "P") {
                    $Operation->setCode_membre($row->code_membre);
					}else if (substr($code_membre, -1) == "M") {
                    $Operation->setCode_membre_morale($row->code_membre_morale);
					}
		}
        return true;
    }



    public function fetchAll3($code_membre, $type_op) {
        $select = $this->getDbTable()->select();
		if(isset($code_membre) && $code_membre!=""){
					if (substr($code_membre, -1) == "P") {
						$select->where("code_membre LIKE '%".$code_membre."'");
					}else if (substr($code_membre, -1) == "M") {
						$select->where("code_membre_morale LIKE '%".$code_membre."'");
					}
		}
		if(isset($type_op) && $type_op!=""){
		$select->where('type_op = ?', $type_op);}
        $select->order(array('id_operation DESC'));
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuOperation();
            $entry->setId_operation($row->id_operation)
                    ->setDate_op($row->date_op)
                    ->setHeure_op($row->heure_op)
                    ->setMontant_op($row->montant_op)
                    ->setCode_membre($row->code_membre)
					->setCode_membre_morale($row->code_membre_morale)
                    ->setCode_produit($row->code_produit)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setLib_op($row->lib_op)
                    ->setCode_cat($row->code_cat)
                    ->setType_op($row->type_op);
            $entries[] = $entry;
        }
        return $entries;
    }
	
}
