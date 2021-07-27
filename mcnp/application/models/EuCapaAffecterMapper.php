<?php

class Application_Model_EuCapaAffecterMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCapaAffecter');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuCapaAffecter $affecter) {
        $data = array(
            'id_affecter' => $affecter->getId_affecter(),
            'duree_renouvellement' => $affecter->getDuree_renouvellement(),
            'reste_duree' => $affecter->getReste_duree(),
            'type_credit' => $affecter->getType_credit(),
            'id_credit' => $affecter->getId_credit(),
            'code_domicilier' => $affecter->getCode_domicilier(),
            'mont_invest' => $affecter->getMont_invest(),
            'code_capa' => $affecter->getCode_capa()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCapaAffecter $affecter) {
        $data = array(
            'id_affecter' => $affecter->getId_affecter(),
            'duree_renouvellement' => $affecter->getDuree_renouvellement(),
            'reste_duree' => $affecter->getReste_duree(),
            'type_credit' => $affecter->getType_credit(),
            'id_credit' => $affecter->getId_credit(),
            'code_domicilier' => $affecter->getCode_domicilier(),
            'mont_invest' => $affecter->getMont_invest(),
            'code_capa' => $affecter->getCode_capa()
        );
        $this->getDbTable()->update($data, array('id_affecter = ?' => $affecter->getId_affecter()));
    }

    public function find($id_affecter, Application_Model_EuCapaAffecter $capaaffecter) {
        $result = $this->getDbTable()->find($id_affecter);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $capaaffecter->setId_affecter($row->id_affecter)
                ->setDuree_renouvellement($row->duree_renouvellement)
                ->setReste_duree($row->reste_duree)
                ->setType_credit($row->type_credit)
                ->setId_credit($row->id_credit)
                ->setCode_domicilier($row->code_domicilier)
                ->setMont_invest($row->mont_invest)
                ->setCode_capa($row->code_capa);
        return true;
    }

    public function findByCredit($id_credit) {
        $select = $this->getDbTable()->select();
        $select->where('id_credit = ?', $id_credit);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return false;
        } else {
            $row = $result->current();
            $capaa = new Application_Model_EuCapaAffecter();
            $capaa->setId_affecter($row->id_affecter)
                 ->setDuree_renouvellement($row->duree_renouvellement)
                 ->setReste_duree($row->reste_duree)
                 ->setType_credit($row->type_credit)
                 ->setId_credit($row->id_credit)
                 ->setCode_domicilier($row->code_domicilier)
                 ->setMont_invest($row->mont_invest)
                 ->setCode_capa($row->code_capa);
            return $capaa;
        }
    }

	public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_affecter) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
    public function delete($id_affecter) {
        $this->getDbTable()->delete(array('id_affecter = ?' => $id_affecter));
    }


///////////////////////////////////
    





}

