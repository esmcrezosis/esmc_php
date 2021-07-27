<?php
 
class Application_Model_EuBanVenduMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBanVendu');
        }
        return $this->_dbTable;
    }

    public function find($id_ban_vendu, Application_Model_EuBanVendu $ban_vendu) {
        $result = $this->getDbTable()->find($id_ban_vendu);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $ban_vendu->setId_ban_vendu($row->id_ban_vendu)
                ->setMont_vendu($row->mont_vendu)
                ->setDate_ban_vendu($row->date_ban_vendu)
                ->setNumero_recu($row->numero_recu)
                ->setCode_membre($row->code_membre)
                ->setId_ban($row->id_ban)
                ->setId_user($row->id_user);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanVendu();
            $entry->setId_ban_vendu($row->id_ban_vendu)
	                ->setMont_vendu($row->mont_vendu)
                    ->setDate_ban_vendu($row->date_ban_vendu)
                    ->setNumero_recu($row->numero_recu)
	                ->setCode_membre($row->code_membre)
					->setId_ban($row->id_ban)
                	->setId_user($row->id_user);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_ban_vendu) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBanVendu $ban_vendu) {
        $data = array(
            'id_ban_vendu' => $ban_vendu->getId_ban_vendu(),
            'mont_vendu' => $ban_vendu->getMont_vendu(),
            'date_ban_vendu' => $ban_vendu->getDate_ban_vendu(),
            'numero_recu' => $ban_vendu->getNumero_recu(),
            'code_membre' => $ban_vendu->getCode_membre(),
            'id_ban' => $ban_vendu->getId_ban(),
            'id_user' => $ban_vendu->getId_user()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBanVendu $ban_vendu) {
        $data = array(
            'id_ban_vendu' => $ban_vendu->getId_ban_vendu(),
            'mont_vendu' => $ban_vendu->getMont_vendu(),
            'date_ban_vendu' => $ban_vendu->getDate_ban_vendu(),
            'numero_recu' => $ban_vendu->getNumero_recu(),
            'code_membre' => $ban_vendu->getCode_membre(),
            'id_ban' => $ban_vendu->getId_ban(),
            'id_user' => $ban_vendu->getId_user()
        );
        $this->getDbTable()->update($data, array('id_ban_vendu = ?' => $ban_vendu->getId_ban_vendu()));
    }

    public function delete($id_ban_vendu) {
        $this->getDbTable()->delete(array('id_ban_vendu = ?' => $id_ban_vendu));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		//$select->where("id_user = ? ", 1);
		$select->order("id_ban_vendu DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanVendu();
            $entry->setId_ban_vendu($row->id_ban_vendu)
	                ->setMont_vendu($row->mont_vendu)
                    ->setDate_ban_vendu($row->date_ban_vendu)
                    ->setNumero_recu($row->numero_recu)
	                ->setCode_membre($row->code_membre)
					->setId_ban($row->id_ban)
                	->setId_user($row->id_user);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllMembre($code_membre) {
        $select = $this->getDbTable()->select();
		$select->where("code_membre = ? ", $code_membre);
		$select->order("id_ban_vendu DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanVendu();
            $entry->setId_ban_vendu($row->id_ban_vendu)
	                ->setMont_vendu($row->mont_vendu)
                    ->setDate_ban_vendu($row->date_ban_vendu)
                    ->setNumero_recu($row->numero_recu)
	                ->setCode_membre($row->code_membre)
					->setId_ban($row->id_ban)
                	->setId_user($row->id_user);
            $entries[] = $entry;
        }
        return $entries;
    }






	
}


?>
