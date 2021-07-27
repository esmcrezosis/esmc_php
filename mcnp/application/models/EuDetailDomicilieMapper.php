<?php

class Application_Model_EuDetailDomicilieMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailDomicilie');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuDetailDomicilie $detail) {
        $data = array(
            'code_domicilier' => $detail->getCode_domicilier(),
            'id_credit' => $detail->getId_credit(),
            'code_membre' => $detail->getCode_membre(),
            'montant_credit' => $detail->getMontant_credit(),
            'utiliser' => $detail->getUtiliser(),
            'duree_renouvellement' => $detail->getDuree_renouvellement(),
            'reste_duree' => $detail->getReste_duree()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailDomicilie $detail) {
        $data = array(
            'code_domicilier' => $detail->getCode_domicilier(),
            'id_credit' => $detail->getId_credit(),
            'code_membre' => $detail->getCode_membre(),
            'montant_credit' => $detail->getMontant_credit(),
            'utiliser' => $detail->getUtiliser(),
            'duree_renouvellement' => $detail->getDuree_renouvellement(),
            'reste_duree' => $detail->getReste_duree()
        );
        $this->getDbTable()->update($data, array('code_domicilier = ?' => $detail->getCode_domicilier(), 'id_credit = ?' => $detail->getId_credit()));
    }

    public function find($code_domicilier,$id_credit,Application_Model_EuDetailDomicilie $detail) {
        $result = $this->getDbTable()->find($code_domicilier,$id_credit);
        if (0 == count($result)) {
            return false;
        } else {
            $row = $result->current();
            $detail->setCode_domicilier($row->code_domicilier)
                   ->setId_credit($row->id_credit)
                   ->setCode_membre($row->code_membre)
                   ->setMontant_credit($row->montant_credit)
                   ->setUtiliser($row->utiliser)
                   ->setDuree_renouvellement($row->duree_renouvellement)
                   ->setReste_duree($row->reste_duree)
		  ;
          return true;
        }
    }

    public function findByCreditDomi($code_dom, $id_credit) {
        $select = $this->getDbTable()->select();
        $select->where('code_domicilier LIKE ?', $code_dom);
        $select->where('id_credit LIKE ?', $id_credit);
        $select->where('utiliser LIKE ?', 1);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $ddomi = new Application_Model_EuDetailDomicilie();
        $ddomi->setCode_domicilier($row->code_domicilier)
                ->setId_credit($row->id_credit)
                ->setCode_membre($row->code_membre)
                ->setMontant_credit($row->montant_credit)
                ->setUtiliser($row->utiliser)
                ->setDuree_renouvellement($row->duree_renouvelllement)
                ->setReste_duree($row->reste_duree);
        return $ddomi;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailDomicilie();
            $entry->setCode_domicilier($row->code_domicilier)
                    ->setId_credit($row->id_credit)
                    ->setCode_membre($row->code_membre)
                    ->setMontant_credit($row->montant_credit)
                    ->setUtiliser($row->utiliser)
                    ->setDuree_renouvellement($row->duree_renouvelllement)
                    ->setReste_duree($row->reste_duree);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_domicilier, $id_credit) {
        $this->getDbTable()->delete(array('code_domicilier = ?' => $code_domicilier, 'id_credit = ?' => $id_credit));
    }

}
