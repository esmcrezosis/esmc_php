<?php 

class Application_Model_EuCategorieFaqMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCategorieFaq');
        }
        return $this->_dbTable;
    }

    public function find($id_categorie_faq, Application_Model_EuCategorieFaq $faq) {
        $result = $this->getDbTable()->find($id_categorie_faq);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $faq->setId_categorie_faq($row->id_categorie_faq)
                ->setLibelle_categorie_faq($row->libelle_categorie_faq);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCategorieFaq();
            $entry->setId_categorie_faq($row->id_categorie_faq)
                    ->setLibelle_categorie_faq($row->libelle_categorie_faq);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuCategorieFaq $faq) {
        $data = array(
            'id_categorie_faq' => $faq->getId_categorie_faq(),
            'libelle_categorie_faq' => $faq->getLibelle_categorie_faq()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCategorieFaq $faq) {
        $data = array(
            'id_categorie_faq' => $faq->getId_categorie_faq(),
            'libelle_categorie_faq' => $faq->getLibelle_categorie_faq()
        );
        $this->getDbTable()->update($data, array('id_categorie_faq = ?' => $faq->getId_categorie_faq()));
    }

    public function delete($id_categorie_faq) {
        $this->getDbTable()->delete(array('id_categorie_faq = ?' => $id_categorie_faq));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_categorie_faq) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}
?>

