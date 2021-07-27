<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuMprgMapper
 *
 * @author user
 */
class Application_Model_EuMfMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuMf');
        }
        return $this->_dbTable;
    }

    public function find($id_mf,Application_Model_EuMf $mf) {
        $result = $this->getDbTable()->find($id_mf);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $mf->setId_mf($row->id_mf)
              ->setDate_mf($row->date_mf)
              ->setMont_mf($row->mont_mf)
                ->setGain_mf($row->gain_mf)
                ->setDate_deb_mf($row->date_deb_mf)
                ->setDate_fin_mf($row->date_fin_mf)
                ->setCode_membre($row->code_membre)
                ->setNb_gain($row->nb_gain)
                ->setDomicilier($row->domicilier)
                ->setCode_compte($row->code_compte)
                ->setId_utilisateur($row->id_utilisateur)
				->setCode_type_mf($row->code_type_mf)
		;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuMf();
            $entry->setId_mf($row->id_mf)
                  ->setDate_mf($row->date_mf)
                  ->setMont_mf($row->mont_mf)
                  ->setGain_mf($row->gain_mf)
                  ->setDate_deb_mf($row->date_deb_mf)
                  ->setDate_fin_mf($row->date_fin_mf)
                  ->setCode_membre($row->code_membre)
                  ->setNb_gain($row->nb_gain)
                  ->setDomicilier($row->domicilier)
                  ->setCode_compte($row->code_compte)
                  ->setId_utilisateur($row->id_utilisateur)
				  ->setCode_type_mf($row->code_type_mf);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuMf $mf) {
        $data = array(
          'id_mf' => $mf->getId_mf(),
          'date_mf' => $mf->getDate_mf(),
          'mont_mf' => $mf->getMont_mf(),
          'gain_mf' => $mf->getGain_mf(),
          'date_deb_mf' => $mf->getDate_deb_mf(),
          'date_fin_mf' => $mf->getDate_fin_mf(),
          'code_membre' => $mf->getCode_membre(),
          'nb_gain' => $mf->getNb_gain(),
          'domicilier' => $mf->getDomicilier(),
          'code_compte' => $mf->getCode_compte(),
          'id_utilisateur' => $mf->getId_utilisateur(),
		  'code_type_mf' => $mf->getCode_type_mf()
        );

        $this->getDbTable()->insert($data);
    }
    
	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_mf) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
    public function update(Application_Model_EuMf $mf) {
        $data = array(
         'id_mf' => $mf->getId_mf(),
         'date_mf' => $mf->getDate_mf(),
         'mont_mf' => $mf->getMont_mf(),
         'gain_mf' => $mf->getGain_mf(),
         'date_deb_mf' => $mf->getDate_deb_mf(),
         'date_fin_mf' => $mf->getDate_fin_mf(),
         'code_membre' => $mf->getCode_membre(),
         'nb_gain' => $mf->getNb_gain(),
         'domicilier' => $mf->getDomicilier(),
         'code_compte' => $mf->getCode_compte(),
         'id_utilisateur' => $mf->getId_utilisateur(),
		 'code_type_mf' => $mf->getCode_type_mf()
        );
        $this->getDbTable()->update($data, array('id_mf = ?' => $mf->getId_mf()));
    }

    public function delete($id_mf) {
           $this->getDbTable()->delete(array('id_mf = ?' => $id_mf));
    }

}

?>
