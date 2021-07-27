<?php

class Application_Model_EuUtiliserNnMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuUtiliserNn');
        }
        return $this->_dbTable;
    }

    public function find($id_utiliser_nn, Application_Model_EuUtiliserNn $utiliser_nn) {
        $result = $this->getDbTable()->find($id_utiliser_nn);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $utiliser_nn->setId_utiliser_nn($row->id_utiliser_nn)
                    ->setCode_membre_nn($row->code_membre_nn)
                    ->setCode_membre_nb($row->code_membre_nb)
                    ->setMont_transfert($row->mont_transfert)
                    ->setDate_transfert($row->date_transfert)
                    ->setCode_produit($row->code_produit)
                    ->setCode_sms($row->code_sms)
                    ->setNum_bon($row->num_bon)
                    ->setId_operation($row->id_operation)
                    ->setCode_produit_nn($row->code_produit_nn)
                    ->setId_utilisateur($row->id_utilisateur)
					->setMotif($row->motif);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUtiliserNn();
            $entry->setId_utiliser_nn($row->id_utiliser_nn)
	                ->setCode_membre_nn($row->code_membre_nn)
                    ->setCode_membre_nb($row->code_membre_nb)
                    ->setMont_transfert($row->mont_transfert)
                    ->setDate_transfert($row->date_transfert)
                	->setCode_produit($row->code_produit)
					->setCode_sms($row->code_sms)
					->setNum_bon($row->num_bon)
					->setId_operation($row->id_operation)
					->setCode_produit_nn($row->code_produit_nn)
                    ->setId_utilisateur($row->id_utilisateur)
					->setMotif($row->motif);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_utiliser_nn) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuUtiliserNn $utiliser_nn) {
        $data = array(
            'id_utiliser_nn' => $utiliser_nn->getId_utiliser_nn(),
            'code_membre_nn' => $utiliser_nn->getCode_membre_nn(),
            'code_membre_nb' => $utiliser_nn->getCode_membre_nb(),
            'mont_transfert' => $utiliser_nn->getMont_transfert(),
            'date_transfert' => $utiliser_nn->getDate_transfert(),
            'code_produit' => $utiliser_nn->getCode_produit(),
            'code_sms' => $utiliser_nn->getCode_sms(),
            'num_bon' => $utiliser_nn->getNum_bon(),
            'id_operation' => $utiliser_nn->getId_operation(),
            'code_produit_nn' => $utiliser_nn->getCode_produit_nn(),
            'id_utilisateur' => $utiliser_nn->getId_utilisateur(),
			'motif' => $utiliser_nn->getMotif()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuUtiliserNn $utiliser_nn) {
        $data = array(
            'id_utiliser_nn' => $utiliser_nn->getId_utiliser_nn(),
            'code_membre_nn' => $utiliser_nn->getCode_membre_nn(),
            'code_membre_nb' => $utiliser_nn->getCode_membre_nb(),
            'mont_transfert' => $utiliser_nn->getMont_transfert(),
            'date_transfert' => $utiliser_nn->getDate_transfert(),
            'code_produit' => $utiliser_nn->getCode_produit(),
            'code_sms' => $utiliser_nn->getCode_sms(),
            'num_bon' => $utiliser_nn->getNum_bon(),
            'id_operation' => $utiliser_nn->getId_operation(),
            'code_produit_nn' => $utiliser_nn->getCode_produit_nn(),
            'id_utilisateur' => $utiliser_nn->getId_utilisateur(),
			'motif' => $utiliser_nn->getMotif()
        );
        $this->getDbTable()->update($data, array('id_utiliser_nn = ?' => $utiliser_nn->getId_utiliser_nn()));
    }

    public function delete($id_utiliser_nn) {
        $this->getDbTable()->delete(array('id_utiliser_nn = ?' => $id_utiliser_nn));
    }




}


?>
