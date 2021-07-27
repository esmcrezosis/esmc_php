<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCapsMapper
 *
 * @author user
 */
 
class Application_Model_EuCapsMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCaps');
        }
        return $this->_dbTable;
    }

    public function find($code_caps, Application_Model_EuCaps $caps) {
        $result = $this->getDbTable()->find($code_caps);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $caps->setCode_caps($row->code_caps)
                ->setId_credit($row->id_credit)
                ->setId_operation($row->id_operation)
                ->setCode_membre_app($row->code_membre_app)
				->setCode_membre_morale_app($row->code_membre_morale_app)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMont_caps($row->mont_caps)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setReconst_fs($row->reconst_fs)
                ->setPeriode($row->periode)
                ->setRembourser($row->rembourser)
                ->setIndexer($row->indexer)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setType_caps($row->type_caps)
                ->setFs_utiliser($row->fs_utiliser)
                ->setFl_utiliser($row->fl_utiliser)
                ->setCps_utiliser($row->cps_utiliser)
                ->setDate_caps($row->date_caps)
                ->setPanu($row->panu)
                ->setId_utilisateur($row->id_utilisateur)
				->setType_op($row->type_op)
				->setNature($row->nature)
				;
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCaps();
            $entry->setCode_caps($row->code_caps)
                ->setId_credit($row->id_credit)
                ->setId_operation($row->id_operation)
                ->setCode_membre_app($row->code_membre_app)
				->setCode_membre_morale_app($row->code_membre_morale_app)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMont_caps($row->mont_caps)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setReconst_fs($row->reconst_fs)
                ->setPeriode($row->periode)
                ->setRembourser($row->rembourser)
                ->setIndexer($row->indexer)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setType_caps($row->type_caps)
                ->setFs_utiliser($row->fs_utiliser)
                ->setFl_utiliser($row->fl_utiliser)
                ->setCps_utiliser($row->cps_utiliser)
                ->setDate_caps($row->date_caps)
                ->setPanu($row->panu)
                ->setId_utilisateur($row->id_utilisateur)
				->setType_op($row->type_op)
				->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllByApporteur($apporteur) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_app = ?', $apporteur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCaps();
            $entry->setCode_caps($row->code_caps)
                ->setId_credit($row->id_credit)
                ->setId_operation($row->id_operation)
                ->setCode_membre_app($row->code_membre_app)
				->setCode_membre_morale_app($row->code_membre_morale_app)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMont_caps($row->mont_caps)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setReconst_fs($row->reconst_fs)
                ->setPeriode($row->periode)
                ->setRembourser($row->rembourser)
                ->setIndexer($row->indexer)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setType_caps($row->type_caps)
                ->setFs_utiliser($row->fs_utiliser)
                ->setFl_utiliser($row->fl_utiliser)
                ->setCps_utiliser($row->cps_utiliser)
                ->setDate_caps($row->date_caps)
                ->setPanu($row->panu)
                ->setId_utilisateur($row->id_utilisateur)
				->setType_op($row->type_op)
				->setNature($row->nature);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchByApporteur($apporteur) {
        $select = $this->getDbTable()->select();
		if(substr($apporteur,19,1)== 'p') {
            $select->where('code_membre_app = ?', $apporteur)
                   ->where('code_membre_benef IS NULL')
                   ->where('fs_utiliser = ?', 0);
		} else {
            $select->where('code_membre_morale_app = ?', $apporteur)
                   ->where('code_membre_benef IS NULL')
                   ->where('fs_utiliser = ?', 0);
        }		
        $resultSet = $this->getDbTable()->fetchAll($select);
        $caps = new Application_Model_EuCaps();
        if (count($resultSet) > 0) {
            $row = $resultSet->current();
            $caps->setCode_caps($row->code_caps)
                ->setId_credit($row->id_credit)
                ->setId_operation($row->id_operation)
                ->setCode_membre_app($row->code_membre_app)
				->setCode_membre_morale_app($row->code_membre_morale_app)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMont_caps($row->mont_caps)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setReconst_fs($row->reconst_fs)
                ->setPeriode($row->periode)
                ->setRembourser($row->rembourser)
                ->setIndexer($row->indexer)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setType_caps($row->type_caps)
                ->setFs_utiliser($row->fs_utiliser)
                ->setFl_utiliser($row->fl_utiliser)
                ->setCps_utiliser($row->cps_utiliser)
                ->setDate_caps($row->date_caps)
                ->setPanu($row->panu)
                ->setId_utilisateur($row->id_utilisateur)
				->setType_op($row->type_op)
				->setNature($row->nature);
            return $caps;
        } else {
            return NULL;
        }
    }

    public function fetchCapsByAppFl($apporteur,$beneficiaire) {
        $select = $this->getDbTable()->select();
		if(substr($apporteur,19,1) == 'P') {
           $select->where('code_membre_app = ?',$apporteur)
                  ->where('code_membre_benef = ?', $beneficiaire)
                  ->where('type_caps IN (?)', array('CAPSFLFCPS', 'CAPSFL2FCPS','CAPSFL3FCPS'))
                  ->where('fl_utiliser = ?', 0);
		} else {
           $select->where('code_membre_morale_app = ?',$apporteur)
                  ->where('code_membre_benef = ?', $beneficiaire)
                  ->where('type_caps IN (?)', array('CAPSFLFCPS', 'CAPSFL2FCPS','CAPSFL3FCPS'))
                  ->where('fl_utiliser = ?', 0);
		}
        $resultSet = $this->getDbTable()->fetchAll($select);
        $caps = new Application_Model_EuCaps();
        if (count($resultSet) > 0) {
            $row = $resultSet->current();
            $caps->setCode_caps($row->code_caps)
                ->setId_credit($row->id_credit)
                ->setId_operation($row->id_operation)
                ->setCode_membre_app($row->code_membre_app)
				->setCode_membre_morale_app($row->code_membre_morale_app)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMont_caps($row->mont_caps)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setReconst_fs($row->reconst_fs)
                ->setPeriode($row->periode)
                ->setRembourser($row->rembourser)
                ->setIndexer($row->indexer)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setType_caps($row->type_caps)
                ->setFs_utiliser($row->fs_utiliser)
                ->setFl_utiliser($row->fl_utiliser)
                ->setCps_utiliser($row->cps_utiliser)
                ->setDate_caps($row->date_caps)
                ->setPanu($row->panu)
                ->setId_utilisateur($row->id_utilisateur)
				->setType_op($row->type_op)
				->setNature($row->nature);
            return $caps;
        } else {
            return NULL;
        }
    }

    public function fetchCapsByAppCps($apporteur,$beneficiaire) {
        $select = $this->getDbTable()->select();
		if(substr($apporteur,19,1)=='P') {
           $select->where('code_membre_app = ?',$apporteur)
                  ->where('code_membre_benef = ?', $beneficiaire)
                  ->where('type_caps IN (?)', array('CAPSFLFCPS', 'CAPSFL2FCPS','CAPSFL3FCPS'))
                  ->where('cps_utiliser <> ?', 0);
		} else  {
           $select->where('code_membre_morale_app = ?',$apporteur)
                  ->where('code_membre_benef = ?', $beneficiaire)
                  ->where('type_caps IN (?)', array('CAPSFLFCPS', 'CAPSFL2FCPS','CAPSFL3FCPS'))
                  ->where('cps_utiliser <> ?', 0);
		}
        
        $resultSet = $this->getDbTable()->fetchAll($select);
        $caps = new Application_Model_EuCaps();
        if (count($resultSet) > 0) {
            $row = $resultSet->current();
            $caps->setCode_caps($row->code_caps)
                ->setId_credit($row->id_credit)
                ->setId_operation($row->id_operation)
                ->setCode_membre_app($row->code_membre_app)
                ->setCode_membre_benef($row->code_membre_benef)
				->setCode_membre_morale_app($row->code_membre_morale_app)
                ->setMont_caps($row->mont_caps)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setReconst_fs($row->reconst_fs)
                ->setPeriode($row->periode)
                ->setRembourser($row->rembourser)
                ->setIndexer($row->indexer)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setType_caps($row->type_caps)
                ->setFs_utiliser($row->fs_utiliser)
                ->setFl_utiliser($row->fl_utiliser)
                ->setCps_utiliser($row->cps_utiliser)
                ->setDate_caps($row->date_caps)
                ->setPanu($row->panu)
                ->setId_utilisateur($row->id_utilisateur)
				->setType_op($row->type_op)
				->setNature($row->nature);
            return $caps;
        } else {
            return NULL;
        }
    }

    public function fetchCapsByBeneficiaire($beneficiaire) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_benef = ?', $beneficiaire);
		//$select->where('indexer = ?',0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return NULL;
        }
        $row = $resultSet->current();
        $entry = new Application_Model_EuCaps();
        $entry->setCode_caps($row->code_caps)
                ->setId_credit($row->id_credit)
                ->setId_operation($row->id_operation)
                ->setCode_membre_app($row->code_membre_app)
				->setCode_membre_morale_app($row->code_membre_morale_app)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMont_caps($row->mont_caps)
                ->setMont_fs($row->mont_fs)
                ->setMont_panu_fs($row->mont_panu_fs)
                ->setReconst_fs($row->reconst_fs)
                ->setPeriode($row->periode)
                ->setRembourser($row->rembourser)
                ->setIndexer($row->indexer)
                ->setCode_type_bnp($row->code_type_bnp)
                ->setType_caps($row->type_caps)
                ->setFs_utiliser($row->fs_utiliser)
                ->setFl_utiliser($row->fl_utiliser)
                ->setCps_utiliser($row->cps_utiliser)
                ->setDate_caps($row->date_caps)
                ->setPanu($row->panu)
                ->setId_utilisateur($row->id_utilisateur)
				->setType_op($row->type_op)
				->setNature($row->nature);
        return $entry;
    }

    public function save(Application_Model_EuCaps $caps) {
        $data = array(
          'code_caps' => $caps->getCode_caps(),
          'id_operation' => $caps->getId_operation(),
          'id_credit' => $caps->getId_credit(),
          'code_membre_app' => $caps->getCode_membre_app(),
		  'code_membre_morale_app' => $caps->getCode_membre_morale_app(),
          'code_membre_benef' => $caps->getCode_membre_benef(),
          'mont_caps' => $caps->getMont_caps(),
          'mont_fs' => $caps->getMont_fs(),
          'mont_panu_fs' => $caps->getMont_panu_fs(),
          'reconst_fs' => $caps->getReconst_fs(),
          'periode' => $caps->getPeriode(),
          'rembourser' => $caps->getRembourser(),
          'indexer' => $caps->getIndexer(),
          'code_type_bnp' => $caps->getCode_type_bnp(),
          'type_caps' => $caps->getType_caps(),
          'fs_utiliser' => $caps->getFs_utiliser(),
          'fl_utiliser' => $caps->getFl_utiliser(),
          'cps_utiliser' => $caps->getCps_utiliser(),
          'date_caps' => $caps->getDate_caps(),
          'panu' => $caps->getPanu(),
          'id_utilisateur' => $caps->getId_utilisateur(),
		  'type_op' => $caps->getType_op(),
		  'nature' => $caps->getNature()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCaps $caps) {
        $data = array(
            'code_caps' => $caps->getCode_caps(),
            'id_operation' => $caps->getId_operation(),
            'id_credit' => $caps->getId_credit(),
            'code_membre_app' => $caps->getCode_membre_app(),
			'code_membre_morale_app' => $caps->getCode_membre_morale_app(),
            'code_membre_benef' => $caps->getCode_membre_benef(),
            'mont_caps' => $caps->getMont_caps(),
            'mont_fs' => $caps->getMont_fs(),
            'periode' => $caps->getPeriode(),
            'rembourser' => $caps->getRembourser(),
            'indexer' => $caps->getIndexer(),
            'code_type_bnp' => $caps->getCode_type_bnp(),
            'type_caps' => $caps->getType_caps(),
            'fs_utiliser' => $caps->getFs_utiliser(),
            'fl_utiliser' => $caps->getFl_utiliser(),
            'cps_utiliser' => $caps->getCps_utiliser(),
            'date_caps' => $caps->getDate_caps(),
            'panu' => $caps->getPanu(),
            'id_utilisateur' => $caps->getId_utilisateur(),
			'type_op' => $caps->getType_op(),
			'nature' => $caps->getNature()
        );
        $this->getDbTable()->update($data, array('code_caps = ?' => $caps->getCode_caps()));
    }

    public function delete($code_caps) {
      $this->getDbTable()->delete(array('code_caps = ?' => $code_caps));
    }

}

?>
