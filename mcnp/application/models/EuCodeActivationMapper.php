<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDeviseMapper
 *
 * @author user
 */
class Application_Model_EuCodeActivationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCodeActivation');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCodeActivation $codeactivation) {
        $data = array(
          'id_code_activation' => $codeactivation->getId_code_activation(),
          'souscription_id' => $codeactivation->getSouscription_id(),
          'membreasso_id' => $codeactivation->getMembreasso_id(),
          'code_fs' => $codeactivation->getCode_fs(),
          'code_fl' => $codeactivation->getCode_fl(),
          'code_fkps' => $codeactivation->getCode_fkps(),
          'code_membre' => $codeactivation->getCode_membre(),
          'date_generer' => $codeactivation->getDate_generer(),
		  'montant_souscrit' => $codeactivation->getMontant_souscrit(),
		  'origine_code' => $codeactivation->getOrigine_code()
		   
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCodeActivation $codeactivation) {
        $data = array(
          'id_code_activation' => $codeactivation->getId_code_activation(),
          'souscription_id' => $codeactivation->getSouscription_id(),
          'membreasso_id' => $codeactivation->getMembreasso_id(),
          'code_fs' => $codeactivation->getCode_fs(),
          'code_fl' => $codeactivation->getCode_fl(),
          'code_fkps' => $codeactivation->getCode_fkps(),
          'code_membre' => $codeactivation->getCode_membre(),
          'date_generer' => $codeactivation->getDate_generer(),
		  'montant_souscrit' => $codeactivation->getMontant_souscrit(),
		  'origine_code' => $codeactivation->getOrigine_code()
        );
        $this->getDbTable()->update($data, array('id_code_activation = ?' => $codeactivation->getId_code_activation()));
    }

    public function find($id_code_activation, Application_Model_EuCodeActivation $codeactivation) {
        $result = $this->getDbTable()->find($id_code_activation);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $codeactivation->setId_code_activation($row->id_code_activation)
                       ->setSouscription_id($row->souscription_id)
                       ->setCode_fs($row->code_fs)
                       ->setCode_fl($row->code_fl)
                       ->setCode_fkps($row->code_fkps)
                       ->setCode_membre($row->code_membre)
                       ->setDate_generer($row->date_generer)
					   ->setMembreasso_id($row->membreasso_id)
					   ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCodeActivation();
            $entry->setId_code_activation($row->id_code_activation)
                       ->setSouscription_id($row->souscription_id)
                       ->setCode_fs($row->code_fs)
                       ->setCode_fl($row->code_fl)
                       ->setCode_fkps($row->code_fkps)
                       ->setCode_membre($row->code_membre)
                       ->setDate_generer($row->date_generer)
					   ->setMembreasso_id($row->membreasso_id)
					   ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	public function findbycode($code_fs,$code_fl,$code_fkps) {
	        $tabela = new Application_Model_DbTable_EuCodeActivation();
	        $select = $tabela->select();
		    $select->where('code_fs like ?',$code_fs);
			$select->where('code_fl like ?',$code_fl);
			$select->where('code_fkps like ?',$code_fkps);
	        $result = $tabela->fetchAll($select);
            if (count($result) == 0) {
               return NULL;
            }
            $entries = array();
            foreach ($result as $row) {
            $entry = new Application_Model_EuCodeActivation();
            $entry->setId_code_activation($row->id_code_activation)
                  ->setSouscription_id($row->souscription_id)
                  ->setCode_fs($row->code_fs)
                  ->setCode_fl($row->code_fl)
                  ->setCode_fkps($row->code_fkps)
                  ->setCode_membre($row->code_membre)
                  ->setDate_generer($row->date_generer)
				  ->setMembreasso_id($row->membreasso_id)
				  ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
			$entries[] = $entry;
        }
        return $entries;
	}
	
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_code_activation) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	

    public function delete($id_code_activation) {
        $this->getDbTable()->delete(array('id_code_activation = ?' => $id_code_activation));
    }


    public function fetchAllBySouscription($souscription_id) {
        $select = $this->getDbTable()->select();
		$select->where("souscription_id = ? ", $souscription_id);
		$select->where('code_fs IS NOT NULL');
		$select->where('code_fl IS NOT NULL');
		$select->where('code_fkps IS NOT NULL');
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuCodeActivation();
            $entry->setId_code_activation($row->id_code_activation)
                  ->setSouscription_id($row->souscription_id)
                  ->setCode_fs($row->code_fs)
                  ->setCode_fl($row->code_fl)
                  ->setCode_fkps($row->code_fkps)
                  ->setCode_membre($row->code_membre)
                  ->setDate_generer($row->date_generer)
				  ->setMembreasso_id($row->membreasso_id)
				  ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
			$entries = $entry;
        return $entries;
    }



    public function fetchAllByCodeFSFLFCPS($code_fsflfcps, $motif) {
        $select = $this->getDbTable()->select();
		if($motif == "FS"){
		$select->where('code_fs = ?', $code_fsflfcps);
			}
		if($motif == "FL"){
		$select->where('code_fl = ?', $code_fsflfcps);
			}
		if($motif == "FCPS"){
		$select->where('code_fkps = ?', $code_fsflfcps);
			}
		$select->where('code_membre IS NULL');
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuCodeActivation();
            $entry->setId_code_activation($row->id_code_activation)
                  ->setSouscription_id($row->souscription_id)
                  ->setCode_fs($row->code_fs)
                  ->setCode_fl($row->code_fl)
                  ->setCode_fkps($row->code_fkps)
                  ->setCode_membre($row->code_membre)
                  ->setDate_generer($row->date_generer)
				  ->setMembreasso_id($row->membreasso_id)
				  ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
			$entries = $entry;
        return $entries;
    }




    public function fetchAllByCodeFSFLFCPS_KO($code_fsflfcps, $motif) {
        $select = $this->getDbTable()->select();
		if($motif == "FS"){
		$select->where('code_fs = ?', $code_fsflfcps);
			}
		if($motif == "FL"){
		$select->where('code_fl = ?', $code_fsflfcps);
			}
		if($motif == "FCPS"){
		$select->where('code_fkps = ?', $code_fsflfcps);
			}
		$select->where('code_membre = -1');
		$select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuCodeActivation();
            $entry->setId_code_activation($row->id_code_activation)
                  ->setSouscription_id($row->souscription_id)
                  ->setCode_fs($row->code_fs)
                  ->setCode_fl($row->code_fl)
                  ->setCode_fkps($row->code_fkps)
                  ->setCode_membre($row->code_membre)
                  ->setDate_generer($row->date_generer)
				  ->setMembreasso_id($row->membreasso_id)
				  ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
			$entries = $entry;
        return $entries;
    }



    
    public function fetchAllByCodeMembre($code_membre) {
        $select = $this->getDbTable()->select();
    $select->where('code_membre = ?', $code_membre);
    $select->limit(1);
        $result = $this->getDbTable()->fetchRow($select);
        $entries = array();
        if (0 == count($result)) {
            return;
        }
        $row = $result;
            $entry = new Application_Model_EuCodeActivation();
            $entry->setId_code_activation($row->id_code_activation)
                  ->setSouscription_id($row->souscription_id)
                  ->setCode_fs($row->code_fs)
                  ->setCode_fl($row->code_fl)
                  ->setCode_fkps($row->code_fkps)
                  ->setCode_membre($row->code_membre)
                  ->setDate_generer($row->date_generer)
                  ->setMembreasso_id($row->membreasso_id)
				  ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
      $entries = $entry;
        return $entries;
    }





    public function fetchAllByMembreasso($membreasso_id = 0) {
        $select = $this->getDbTable()->select();
        if($membreasso_id > 0){
        $select->where("membreasso_id = ? ", $membreasso_id);
            }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCodeActivation();
            $entry->setId_code_activation($row->id_code_activation)
                  ->setSouscription_id($row->souscription_id)
                  ->setCode_fs($row->code_fs)
                  ->setCode_fl($row->code_fl)
                  ->setCode_fkps($row->code_fkps)
                  ->setCode_membre($row->code_membre)
                  ->setDate_generer($row->date_generer)
                  ->setMembreasso_id($row->membreasso_id)
				  ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByAssociation($association_id = 0) {
        $select = $this->getDbTable()->select();
        if($association_id > 0){
        $select->where("membreasso_id IN (SELECT membreasso_id FROM eu_membreasso WHERE membreasso_association = ?)", $association_id);
            }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCodeActivation();
            $entry->setId_code_activation($row->id_code_activation)
                  ->setSouscription_id($row->souscription_id)
                  ->setCode_fs($row->code_fs)
                  ->setCode_fl($row->code_fl)
                  ->setCode_fkps($row->code_fkps)
                  ->setCode_membre($row->code_membre)
                  ->setDate_generer($row->date_generer)
                  ->setMembreasso_id($row->membreasso_id)
				  ->setMontant_souscrit($row->montant_souscrit)
                  ->setOrigine_code($row->origine_code);
             $entries[] = $entry;
        }
        return $entries;
    }



}

?>
