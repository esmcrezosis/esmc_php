<?php

class Application_Model_EuQuestionReponseCategorieMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuQuestionReponseCategorie');
        }
        return $this->_dbTable;
    }

    public function find($question_reponse_categorie_cod, Application_Model_EuQuestionReponseCategorie $question_reponse_categorie) {
        $result = $this->getDbTable()->find($question_reponse_categorie_cod);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $question_reponse_categorie->setQuestion_reponse_categorie_cod($row->question_reponse_categorie_cod)
                ->setQuestion_reponse_categorie_lib($row->question_reponse_categorie_lib);
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionReponseCategorie();
            $entry->setQuestion_reponse_categorie_cod($row->question_reponse_categorie_cod)
                    ->setQuestion_reponse_categorie_lib($row->question_reponse_categorie_lib);
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuQuestionReponseCategorie $question_reponse_categorie) {
        $data = array(
            'question_reponse_categorie_cod' => $question_reponse_categorie->getQuestion_reponse_categorie_cod(),
            'question_reponse_categorie_lib' => $question_reponse_categorie->getQuestion_reponse_categorie_lib()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuQuestionReponseCategorie $question_reponse_categorie) {
        $data = array(
            'question_reponse_categorie_cod' => $question_reponse_categorie->getQuestion_reponse_categorie_cod(),
            'question_reponse_categorie_lib' => $question_reponse_categorie->getQuestion_reponse_categorie_lib()
        );
        $this->getDbTable()->update($data, array('question_reponse_categorie_cod = ?' => $question_reponse_categorie->getQuestion_reponse_categorie_cod()));
    }

    public function delete($question_reponse_categorie_cod) {
        $this->getDbTable()->delete(array('question_reponse_categorie_cod = ?' => $question_reponse_categorie_cod));
    }



}
?>

