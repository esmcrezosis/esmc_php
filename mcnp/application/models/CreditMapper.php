<?php
 
class Application_Model_CreditMapper {

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
            $this->setDbTable('Application_Model_DbTable_Credit');
        }
        return $this->_dbTable;
    }

    public function find($codecredi, Application_Model_Credit $credit) {
        $result = $this->getDbTable()->find($codecredi);
        if (count($result) == 0) {
            return false;
        }
		
        $row = $result->current();
        $credit->setCodecredi($row->codecredi)
                ->setMontantcredi($row->montantcredi)
                ->setMembre($row->membre)
                ->setLibelle($row->libelle)
                ->setMontplace($row->montplace)
                ->setDatefin($row->datefin)
                ->setDatedeb($row->datedeb)
                ->setVal($row->val)
                ->setPeriode($row->periode)
                ->setSource($row->source)
                ->setDateoctroi($row->dateoctroi)
                ->setAgence($row->agence)
                ->setInn($row->inn);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Credit();
            $entry->setCodecredi($row->codecredi)
                  ->setMontantcredi($row->montantcredi)
                  ->setMembre($row->membre)
                  ->setLibelle($row->libelle)
                  ->setMontplace($row->montplace)
                  ->setDatefin($row->datefin)
                  ->setDatedeb($row->datedeb)
                  ->setVal($row->val)
                  ->setPeriode($row->periode)
                  ->setSource($row->source)
                  ->setDateoctroi($row->dateoctroi)
                  ->setAgence($row->agence)
                  ->setInn($row->inn);
            $entries[] = $entry;
        }
        return $entries;
    }
    

    public function save(Application_Model_Credit $credit) {
	    
        $data = array(
            'codecredi' => $credit->getCodecredi(),
            'montantcredi' => $credit->getMontantcredi(),
            'membre' => $credit->getMembre(),
            'libelle' => $credit->getLibelle(),
            'montplace' => $credit->getMontplace(),
            'datefin' => $credit->getDatefin(),
            'datedeb' => $credit->getDatedeb(),
            'val' => $credit->getVal(),
            'periode' => $credit->getPeriode(),
            'source' => $credit->getSource(),
            'dateoctroi' => $credit->getDateoctroi(),
            'agence' => $credit->getAgence(),
            'inn' => $credit->getInn()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_Credit $credit) {
        $data = array(
            'codecredi' => $credit->getCodecredi(),
            'montantcredi' => $credit->getMontantcredi(),
            'membre' => $credit->getMembre(),
            'libelle' => $credit->getLibelle(),
            'montplace' => $credit->getMontplace(),
            'datefin' => $credit->getDatefin(),
            'datedeb' => $credit->getDatedeb(),
            'val' => $credit->getVal(),
            'periode' => $credit->getPeriode(),
            'source' => $credit->getSource(),
            'dateoctroi' => $credit->getDateoctroi(),
            'agence' => $credit->getAgence(),
            'inn' => $credit->getInn()
        );
        $this->getDbTable()->update($data, array('codecredi = ?' => $credi->getCodecredi()));
    }

    public function delete($codecredi) {
        $this->getDbTable()->delete(array('codecredi = ?' => $codecredi));
    }

}


?>
