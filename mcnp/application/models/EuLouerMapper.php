<?php

class Application_Model_EuLouerMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuLouer');
        }
        return $this->_dbTable;
    }

    public function find($id_louer, Application_Model_EuLouer $louer) {
        $result = $this->getDbTable()->find($id_louer);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $louer->setId_louer($row->id_louer)
                ->setDuree_location($row->duree_location)
                ->setDate_location($row->date_location)
                ->setMont_loyer($row->mont_loyer)
                ->setId_proprietaire($row->id_proprietaire)
                ->setCode_domiciliation($row->code_domiciliation)
                ->setCode_membre_ag($row->code_membre_ag)
                ->setCode_membre_loc($row->code_membre_loc)
                ->setId_maison($row->id_maison)
                ->setId_appartement($row->id_appartement)
                ->setId_utilisateur($row->id_utilisateur);
    }

    public function findByDomiciliation($code_domiciliation) {
        $table = new Application_Model_DbTable_EuLouer();
        $select = $table->select();
        $select->where('code_domiciliation LIKE ?', $code_domiciliation);
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $louer = new Application_Model_EuLouer();
        $louer->setId_louer($row->id_louer)
                ->setDuree_location($row->duree_location)
                ->setDate_location($row->date_location)
                ->setMont_loyer($row->mont_loyer)
                ->setId_proprietaire($row->id_proprietaire)
                ->setCode_domiciliation($row->code_domiciliation)
                ->setCode_membre_ag($row->code_membre_ag)
                ->setCode_membre_loc($row->code_membre_loc)
                ->setId_maison($row->id_maison)
                ->setId_appartement($row->id_appartement)
                ->setId_utilisateur($row->id_utilisateur);
        return $louer;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuLouer();
            $entry->setId_louer($row->id_louer)
                    ->setDuree_location($row->duree_location)
                    ->setDate_location($row->date_location)
                    ->setMont_loyer($row->mont_loyer)
                    ->setId_proprietaire($row->id_proprietaire)
                    ->setCode_domiciliation($row->code_domiciliation)
                    ->setCode_membre_ag($row->code_membre_ag)
                    ->setCode_membre_loc($row->code_membre_loc)
                    ->setId_maison($row->id_maison)
                    ->setId_appartement($row->id_appartement)
                    ->setId_utilisateur($row->id_utilisateur);

            $entries[] = $entry;
        }
        return $entries;
    }

    public function save(Application_Model_EuLouer $louer) {
        $data = array(
            'id_louer' => $louer->getId_louer(),
            'duree_location' => $louer->getDuree_location(),
            'date_location' => $louer->getDate_location(),
            'mont_loyer' => $louer->getMont_loyer(),
            'id_proprietaire' => $louer->getId_proprietaire(),
            'code_domiciliation' => $louer->getCode_domiciliation(),
            'code_membre_ag' => $louer->getCode_membre_ag(),
            'code_membre_loc' => $louer->getCode_membre_loc(),
            'id_maison' => $louer->getId_maison(),
            'id_appartement' => $louer->getId_appartement(),
            'id_utilisateur' => $louer->getId_utilisateur()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuLouer $louer) {
        $data = array(
            'id_louer' => $louer->getId_louer(),
            'duree_location' => $louer->getDuree_location(),
            'date_location' => $louer->getDate_location(),
            'mont_loyer' => $louer->getMont_loyer(),
            'id_proprietaire' => $louer->getId_proprietaire(),
            'code_domiciliation' => $louer->getCode_domiciliation(),
            'code_membre_ag' => $louer->getCode_membre_ag(),
            'code_membre_loc' => $louer->getCode_membre_loc(),
            'id_maison' => $louer->getId_maison(),
            'id_appartement' => $louer->getId_appartement(),
            'id_utilisateur' => $louer->getId_utilisateur()
        );
        $this->getDbTable()->update($data, array('id_louer = ?' => $louer->getId_louer()));
    }

    public function delete($id_louer) {
        $this->getDbTable()->delete(array('id_louer = ?' => $id_louer));
    }

}

?>
