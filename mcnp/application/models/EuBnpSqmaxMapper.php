<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuBnpSqmaxMapper
 *
 * @author user
 */
class Application_Model_EuBnpSqmaxMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBnpSqmax');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuBnpSqmax $sqmax) {
        $data = array(
            'id_sqmax' => $sqmax->getId_sqmax(),
            'code_membre' => $sqmax->getCode_membre(),
            'code_cat' => $sqmax->getCode_cat(),
            'montant' => $sqmax->getMontant(),
			'id_credit' => $sqmax->getId_credit()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBnpSqmax $sqmax) {
        $data = array(
            'id_sqmax' => $sqmax->getId_sqmax(),
            'code_membre' => $sqmax->getCode_membre(),
            'code_cat' => $sqmax->getCode_cat(),
            'montant' => $sqmax->getMontant(),
			'id_credit' => $sqmax->getId_credit()
        );

        $this->getDbTable()->update($data, array('code_sqmax = ?' => $sqmax->getCode_sqmax()));
    }

    public function find($num_compte, Application_Model_EuBnpSqmax $sqmax) {
        $result = $this->getDbTable()->find($num_compte);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $sqmax->setId_sqmax($row->id_sqmax)
                ->setCode_cat($row->code_cat)
                ->setCode_membre($row->code_membre)
                ->setMontant($row->montant)
				->setId_credit($row->id_credit)
				;
        return true;
    }

    public function findSqmax($num_membre,$code_cat) {
         $select = $this->getDbTable()->select();
         $select->from($this->getDbTable(), array('SUM(montant) as somme'));
         $select->where('num_membre = ?', $num_membre);
         $select->where('code_cat = ?', $code_cat);
         $result = $this->getDbTable()->fetchAll($select);
         if (count($result) == 0) {
            return 0;
         }
         $row = $result->current();
         return $row['somme'];
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCompteGeneral();
            $entry->setId_sqmax($row->id_sqmax)
                    ->setCode_cat($row->code_cat)
                    ->setCode_membre($row->code_membre)
                    ->setMontant($row->montant)
					->setId_credit($row->id_credit);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_sqmax) {
        $this->getDbTable()->delete(array('id_sqmax = ?' => $id_sqmax));
    }
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_sqmax) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}

?>
