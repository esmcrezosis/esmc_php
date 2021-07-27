<?php
class Application_Model_EuDetailCompteMf107Mapper {


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
            $this->setDbTable('Application_Model_DbTable_EuDetailCompteMf107');
        }
        return $this->_dbTable;
    }

	 public function find($id_detail_compte_mf107, Application_Model_EuDetailCompteMf107 $detail_compte_mf107) {
         $result = $this->getDbTable()->find($id_detail_compte_mf107);
         if (0 == count($result)) {
           return;
         }
         $row = $result->current();
         $detail_compte_mf107->setId_detail_compte_mf107($row->id_detail_compte_mf107)
                             ->setCode_compte($row->code_compte)
                             ->setDate_detail($row->date_detail)
                             ->setMontant_rep($row->montant_rep)
                             ->setCumul($row->cumul)
                             ->setNumident($row->numident)
                             ->setPourcentage($row->pourcentage)
                             ->setId_utilisateur($row->id_utilisateur)
                             ->setEtat_detail_compte($row->etat_detail_compte)
                             ->setCreditcode($row->creditcode);

	}
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailCompteMf107();
            $entry->setId_detail_compte_mf107($row->id_detail_compte_mf107)
                  ->setCode_compte($row->code_compte)
                  ->setDate_detail($row->date_detail)
                  ->setMontant_rep($row->montant_rep)
                  ->setCumul($row->cumul)
                  ->setNumident($row->numident)
                  ->setPourcentage($row->pourcentage)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setEtat_detail_compte($row->etat_detail_compte)
                  ->setCreditcode($row->creditcode);

            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	 public function save(Application_Model_EuDetailCompteMf107 $detail_compte_mf107) {
        $data = array(
            'id_detail_compte_mf107' =>   $detail_compte_mf107->getId_detail_compte_mf107(),
            'code_compte'            =>   $detail_compte_mf107->getCode_compte(),
            'date_detail'            => $detail_compte_mf107->getDate_detail(),
            'montant_rep'            => $detail_compte_mf107->getMontant_rep(),
            'cumul'                  => $detail_compte_mf107->getCumul(),
            'numident'               => $detail_compte_mf107->getNumident(),
            'pourcentage'            => $detail_compte_mf107->getPourcentage(),
            'id_utilisateur'         => $detail_compte_mf107->getId_utilisateur(),
            'etat_detail_compte'     => $detail_compte_mf107->getEtat_detail_compte(),
            'creditcode'             => $detail_compte_mf107->getCreditcode()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailCompteMf107 $detail_compte_mf107) {
        $data = array(
            'id_detail_compte_mf107' =>   $detail_compte_mf107->getId_detail_compte_mf107(),
            'code_compte'            =>   $detail_compte_mf107->getCode_compte(),
            'date_detail'            =>   $detail_compte_mf107->getDate_detail(),
            'montant_rep'            =>   $detail_compte_mf107->getMontant_rep(),
            'cumul'                  =>   $detail_compte_mf107->getCumul(),
            'numident'               =>   $detail_compte_mf107->getNumident(),
            'pourcentage'            =>   $detail_compte_mf107->getPourcentage(),
            'id_utilisateur'         =>   $detail_compte_mf107->getId_utilisateur(),
            'etat_detail_compte'     =>   $detail_compte_mf107->getEtat_detail_compte(),
            'creditcode'             =>   $detail_compte_mf107->getCreditcode()
        );
        $this->getDbTable()->update($data, array('code_acteur = ?' => $acteur->getcode_acteur()));
    }

    public function delete($id_detail_compte_mf107) {
        $this->getDbTable()->delete(array('id_detail_compte_mf107 = ?' => $id_detail_compte_mf107));
    }
	
	
	




	




























}





























?>