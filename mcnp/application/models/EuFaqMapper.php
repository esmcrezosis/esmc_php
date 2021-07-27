<?php 

class Application_Model_EuFaqMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFaq');
        }
        return $this->_dbTable;
    }

    public function find($faq_id, Application_Model_EuFaq $faq) {
        $result = $this->getDbTable()->find($faq_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $faq->setFaq_id($row->faq_id)
                ->setFaq_question($row->faq_question)
                ->setFaq_reponse($row->faq_reponse)
                ->setFaq_categorie($row->faq_categorie)
                ->setFaq_type($row->faq_type)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFaq();
            $entry->setFaq_id($row->faq_id)
	                ->setFaq_question($row->faq_question)
                    ->setFaq_reponse($row->faq_reponse)
                    ->setFaq_categorie($row->faq_categorie)
	                ->setFaq_type($row->faq_type)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(faq_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuFaq $faq) {
        $data = array(
            'faq_id' => $faq->getFaq_id(),
            'faq_question' => $faq->getFaq_question(),
            'faq_reponse' => $faq->getFaq_reponse(),
            'faq_categorie' => $faq->getFaq_categorie(),
            'faq_type' => $faq->getFaq_type(),
            'publier' => $faq->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFaq $faq) {
        $data = array(
            'faq_id' => $faq->getFaq_id(),
            'faq_question' => $faq->getFaq_question(),
            'faq_reponse' => $faq->getFaq_reponse(),
            'faq_categorie' => $faq->getFaq_categorie(),
            'faq_type' => $faq->getFaq_type(),
            'publier' => $faq->getPublier()
        );
        $this->getDbTable()->update($data, array('faq_id = ?' => $faq->getFaq_id()));
    }

    public function delete($faq_id) {
        $this->getDbTable()->delete(array('faq_id = ?' => $faq_id));
    }




}


?>
