<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application_Model_EuKrrMapper
 *
 * @author user
 */
class Application_Model_EuKrrMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuKrr');
        }
        return $this->_dbTable;
    }

    public function find($code_credi, Application_Model_EuKrr $krr) {
        $result = $this->getDbTable()->find($code_credi);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $krr->setId_credit($row->id_credit)
                ->setCode_membre($row->code_membre)
                ->setCode_produit($row->code_produit)
                ->setDate_echue($row->date_echue)
                ->setDate_renouveller($row->date_renouveller)
                ->setMont_capa($row->mont)
                ->setPayer($row->payer)
                ->setDate_demande($row->date_demande)
                ->setReconstituer($row->reconstituer)
                ->setMont_reconst($row->capa_reconst)
                ->setMont_krr($row->mont_krr)
				->setCode_membre_morale($row->code_membre_morale)
				->setType_krr($row->type_krr);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuKrr();
            $entry->setId_credit($row->id_credit)
                    ->setCode_membre($row->code_membre)
                    ->setCode_produit($row->code_produit)
                    ->setDate_echue($row->date_echue)
                    ->setDate_renouveller($row->date_renouveller)
                    ->setMont_capa($row->mont)
                    ->setPayer($row->payer)
                    ->setDate_demande($row->date_demande)
                    ->setReconstituer($row->reconstituer)
                    ->setMont_reconst($row->capa_reconst)
                    ->setMont_krr($row->mont_krr)
					->setCode_membre_morale($row->code_membre_morale)
				    ->setType_krr($row->type_krr);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuKrr $krr) {
        $data = array(
            'id_credit' => $krr->getId_credit(),
            'code_membre' => $krr->getCode_membre(),
            'code_produit' => $krr->getCode_produit(),
            'date_renouveller' => $krr->getDate_renouveller(),
            'date_echue' => $krr->getDate_echue(),
            'mont_capa' => $krr->getMont_capa(),
            'payer' => $krr->getPayer(),
            'date_demande' => $krr->getDate_demande(),
            'reconstituer' => $krr->getReconstituer(),
            'mont_krr' => $krr->getMont_krr(),
            'mont_reconst' => $krr->getMont_reconst(),
			'code_membre_morale' => $krr->getCode_membre_morale(),
			'type_krr' => $krr->getType_krr()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuKrr $krr) {
        $data = array(
            'id_credit' => $krr->getId_credit(),
            'code_membre' => $krr->getCode_membre(),
            'code_produit' => $krr->getCode_produit(),
            'date_renouveller' => $krr->getDate_renouveller(),
            'date_echue' => $krr->getDate_echue(),
            'mont_capa' => $krr->getMont_capa(),
            'payer' => $krr->getPayer(),
            'date_demande' => $krr->getDate_demande(),
            'reconstituer' => $krr->getReconstituer(),
            'mont_krr' => $krr->getMont_krr(),
            'mont_reconst' => $krr->getMont_reconst(),
			'code_membre_morale' => $krr->getCode_membre_morale(),
			'type_krr' => $krr->getType_krr()
        );
        $this->getDbTable()->update($data, array('id_credit = ?' => $krr->getId_credit()));
    }

    public function delete($id_credit) {
        $this->getDbTable()->delete(array('id_credit = ?' => $id_credit));
    }

}

?>
