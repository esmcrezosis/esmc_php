<?php
 
class Application_Model_EuBlogCommentaireMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBlogCommentaire');
        }
        return $this->_dbTable;
    }

    public function find($blog_commentaire_id, Application_Model_EuBlogCommentaire $blog_commentaire) {
        $result = $this->getDbTable()->find($blog_commentaire_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $blog_commentaire->setBlog_commentaire_id($row->blog_commentaire_id)
                ->setCode_membre($row->code_membre)
                ->setBlog_commentaire_message($row->blog_commentaire_message)
                ->setBlog_id($row->blog_id)
                ->setBlog_commentaire_emoticone($row->blog_commentaire_emoticone)
                ->setBlog_commentaire_date($row->blog_commentaire_date)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("blog_commentaire_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlogCommentaire();
            $entry->setBlog_commentaire_id($row->blog_commentaire_id)
	                ->setCode_membre($row->code_membre)
                    ->setBlog_commentaire_message($row->blog_commentaire_message)
                    ->setBlog_id($row->blog_id)
					->setBlog_commentaire_emoticone($row->blog_commentaire_emoticone)
					->setBlog_commentaire_date($row->blog_commentaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(blog_commentaire_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBlogCommentaire $blog_commentaire) {
        $data = array(
            'blog_commentaire_id' => $blog_commentaire->getBlog_commentaire_id(),
            'code_membre' => $blog_commentaire->getCode_membre(),
            'blog_commentaire_message' => $blog_commentaire->getBlog_commentaire_message(),
            'blog_id' => $blog_commentaire->getBlog_id(),
            'blog_commentaire_emoticone' => $blog_commentaire->getBlog_commentaire_emoticone(),
            'blog_commentaire_date' => $blog_commentaire->getBlog_commentaire_date(),
            'publier' => $blog_commentaire->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBlogCommentaire $blog_commentaire) {
        $data = array(
            'blog_commentaire_id' => $blog_commentaire->getBlog_commentaire_id(),
            'code_membre' => $blog_commentaire->getCode_membre(),
            'blog_commentaire_message' => $blog_commentaire->getBlog_commentaire_message(),
            'blog_id' => $blog_commentaire->getBlog_id(),
            'blog_commentaire_emoticone' => $blog_commentaire->getBlog_commentaire_emoticone(),
            'blog_commentaire_date' => $blog_commentaire->getBlog_commentaire_date(),
            'publier' => $blog_commentaire->getPublier()
        );
        $this->getDbTable()->update($data, array('blog_commentaire_id = ?' => $blog_commentaire->getBlog_commentaire_id()));
    }

    public function delete($blog_commentaire_id) {
        $this->getDbTable()->delete(array('blog_commentaire_id = ?' => $blog_commentaire_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("blog_commentaire_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlogCommentaire();
            $entry->setBlog_commentaire_id($row->blog_commentaire_id)
	                ->setCode_membre($row->code_membre)
                    ->setBlog_commentaire_message($row->blog_commentaire_message)
                    ->setBlog_id($row->blog_id)
					->setBlog_commentaire_emoticone($row->blog_commentaire_emoticone)
					->setBlog_commentaire_date($row->blog_commentaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByBlog($blog_id) {
        $select = $this->getDbTable()->select();
		$select->where("blog_id = ? ", $blog_id);
		$select->where("publier = ? ", 1);
		$select->order("blog_commentaire_date DESC");
        $select->limit(30);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlogCommentaire();
            $entry->setBlog_commentaire_id($row->blog_commentaire_id)
	                ->setCode_membre($row->code_membre)
                    ->setBlog_commentaire_message($row->blog_commentaire_message)
                    ->setBlog_id($row->blog_id)
					->setBlog_commentaire_emoticone($row->blog_commentaire_emoticone)
					->setBlog_commentaire_date($row->blog_commentaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("blog_commentaire_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("blog_commentaire_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlogCommentaire();
            $entry->setBlog_commentaire_id($row->blog_commentaire_id)
	                ->setCode_membre($row->code_membre)
                    ->setBlog_commentaire_message($row->blog_commentaire_message)
                    ->setBlog_id($row->blog_id)
					->setBlog_commentaire_emoticone($row->blog_commentaire_emoticone)
					->setBlog_commentaire_date($row->blog_commentaire_date)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    


}


?>
