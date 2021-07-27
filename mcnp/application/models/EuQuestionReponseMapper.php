<?php 

class Application_Model_EuQuestionReponseMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuQuestionReponse');
        }
        return $this->_dbTable;
    }

    public function find($question_reponse_id, Application_Model_EuQuestionReponse $question_reponse) {
        $result = $this->getDbTable()->find($question_reponse_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $question_reponse->setQuestion_reponse_id($row->question_reponse_id)
                ->setQuestion_reponse_question($row->question_reponse_question)
                ->setQuestion_reponse_reponse($row->question_reponse_reponse)
                ->setQuestion_reponse_categorie($row->question_reponse_categorie)
                ->setQuestion_reponse_utilisateur($row->question_reponse_utilisateur)
                ->setQuestion_reponse_nom($row->question_reponse_nom)
                ->setQuestion_reponse_date($row->question_reponse_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionReponse();
            $entry->setQuestion_reponse_id($row->question_reponse_id)
	                ->setQuestion_reponse_question($row->question_reponse_question)
                    ->setQuestion_reponse_reponse($row->question_reponse_reponse)
                    ->setQuestion_reponse_categorie($row->question_reponse_categorie)
	                ->setQuestion_reponse_utilisateur($row->question_reponse_utilisateur)
					->setQuestion_reponse_nom($row->question_reponse_nom)
                    ->setQuestion_reponse_date($row->question_reponse_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(question_reponse_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuQuestionReponse $question_reponse) {
        $data = array(
            'question_reponse_id' => $question_reponse->getQuestion_reponse_id(),
            'question_reponse_question' => $question_reponse->getQuestion_reponse_question(),
            'question_reponse_reponse' => $question_reponse->getQuestion_reponse_reponse(),
            'question_reponse_categorie' => $question_reponse->getQuestion_reponse_categorie(),
            'question_reponse_utilisateur' => $question_reponse->getQuestion_reponse_utilisateur(),
            'question_reponse_nom' => $question_reponse->getQuestion_reponse_nom(),
            'question_reponse_date' => $question_reponse->getQuestion_reponse_date(),
            'publier' => $question_reponse->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuQuestionReponse $question_reponse) {
        $data = array(
            'question_reponse_id' => $question_reponse->getQuestion_reponse_id(),
            'question_reponse_question' => $question_reponse->getQuestion_reponse_question(),
            'question_reponse_reponse' => $question_reponse->getQuestion_reponse_reponse(),
            'question_reponse_categorie' => $question_reponse->getQuestion_reponse_categorie(),
            'question_reponse_utilisateur' => $question_reponse->getQuestion_reponse_utilisateur(),
            'question_reponse_nom' => $question_reponse->getQuestion_reponse_nom(),
            'question_reponse_date' => $question_reponse->getQuestion_reponse_date(),
            'publier' => $question_reponse->getPublier()
        );
        $this->getDbTable()->update($data, array('question_reponse_id = ?' => $question_reponse->getQuestion_reponse_id()));
    }

    public function delete($question_reponse_id) {
        $this->getDbTable()->delete(array('question_reponse_id = ?' => $question_reponse_id));
    }



    public function fetchAllByCategorie($categorie) {
        $select = $this->getDbTable()->select();
		$select->where("question_reponse_categorie = ? ", $categorie);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionReponse();
            $entry->setQuestion_reponse_id($row->question_reponse_id)
	                ->setQuestion_reponse_question($row->question_reponse_question)
                    ->setQuestion_reponse_reponse($row->question_reponse_reponse)
                    ->setQuestion_reponse_categorie($row->question_reponse_categorie)
	                ->setQuestion_reponse_utilisateur($row->question_reponse_utilisateur)
					->setQuestion_reponse_nom($row->question_reponse_nom)
                    ->setQuestion_reponse_date($row->question_reponse_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByUtilisateur($utilisateur) {
        $select = $this->getDbTable()->select();
		$select->where("question_reponse_utilisateur = ? ", $utilisateur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionReponse();
            $entry->setQuestion_reponse_id($row->question_reponse_id)
	                ->setQuestion_reponse_question($row->question_reponse_question)
                    ->setQuestion_reponse_reponse($row->question_reponse_reponse)
                    ->setQuestion_reponse_categorie($row->question_reponse_categorie)
	                ->setQuestion_reponse_utilisateur($row->question_reponse_utilisateur)
					->setQuestion_reponse_nom($row->question_reponse_nom)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		//$select->where("publier = ? ", 1);
		$select->order("question_reponse_id DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionReponse();
            $entry->setQuestion_reponse_id($row->question_reponse_id)
	                ->setQuestion_reponse_question($row->question_reponse_question)
                    ->setQuestion_reponse_reponse($row->question_reponse_reponse)
                    ->setQuestion_reponse_categorie($row->question_reponse_categorie)
	                ->setQuestion_reponse_utilisateur($row->question_reponse_utilisateur)
					->setQuestion_reponse_nom($row->question_reponse_nom)
                    ->setQuestion_reponse_date($row->question_reponse_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3($categorie) {
        $select = $this->getDbTable()->select();
		$select->where("question_reponse_categorie = ? ", $categorie);
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionReponse();
            $entry->setQuestion_reponse_id($row->question_reponse_id)
	                ->setQuestion_reponse_question($row->question_reponse_question)
                    ->setQuestion_reponse_reponse($row->question_reponse_reponse)
                    ->setQuestion_reponse_categorie($row->question_reponse_categorie)
	                ->setQuestion_reponse_utilisateur($row->question_reponse_utilisateur)
					->setQuestion_reponse_nom($row->question_reponse_nom)
                    ->setQuestion_reponse_date($row->question_reponse_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAll4() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuQuestionReponse();
            $entry->setQuestion_reponse_id($row->question_reponse_id)
	                ->setQuestion_reponse_question($row->question_reponse_question)
                    ->setQuestion_reponse_reponse($row->question_reponse_reponse)
                    ->setQuestion_reponse_categorie($row->question_reponse_categorie)
	                ->setQuestion_reponse_utilisateur($row->question_reponse_utilisateur)
					->setQuestion_reponse_nom($row->question_reponse_nom)
                    ->setQuestion_reponse_date($row->question_reponse_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
