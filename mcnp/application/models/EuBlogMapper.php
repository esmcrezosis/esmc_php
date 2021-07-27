<?php
 
class Application_Model_EuBlogMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBlog');
        }
        return $this->_dbTable;
    }

    public function find($blog_id, Application_Model_EuBlog $blog) {
        $result = $this->getDbTable()->find($blog_id);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $blog->setBlog_id($row->blog_id)
                ->setBlog_titre($row->blog_titre)
                ->setBlog_description($row->blog_description)
                ->setBlog_resume($row->blog_resume)
                ->setId_type_blog($row->id_type_blog)
                ->setBlog_vignette($row->blog_vignette)
                ->setBlog_date($row->blog_date)
                ->setId_utilisateur($row->id_utilisateur)
                ->setSpotlight($row->spotlight)
                ->setPublier($row->publier);
        return true;
    }

    public function fetchAll() {
        $select = $this->getDbTable()->select();
		$select->order("blog_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlog();
            $entry->setBlog_id($row->blog_id)
	                ->setBlog_titre($row->blog_titre)
                    ->setBlog_description($row->blog_description)
                    ->setBlog_resume($row->blog_resume)
	                ->setId_type_blog($row->id_type_blog)
					->setBlog_vignette($row->blog_vignette)
					->setBlog_date($row->blog_date)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setSpotlight($row->spotlight)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(blog_id) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuBlog $blog) {
        $data = array(
            'blog_id' => $blog->getBlog_id(),
            'blog_titre' => $blog->getBlog_titre(),
            'blog_description' => $blog->getBlog_description(),
            'blog_resume' => $blog->getBlog_resume(),
            'id_type_blog' => $blog->getId_type_blog(),
            'blog_vignette' => $blog->getBlog_vignette(),
            'blog_date' => $blog->getBlog_date(),
            'id_utilisateur' => $blog->getId_utilisateur(),
            'spotlight' => $blog->getSpotlight(),
            'publier' => $blog->getPublier()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBlog $blog) {
        $data = array(
            'blog_id' => $blog->getBlog_id(),
            'blog_titre' => $blog->getBlog_titre(),
            'blog_description' => $blog->getBlog_description(),
            'blog_resume' => $blog->getBlog_resume(),
            'id_type_blog' => $blog->getId_type_blog(),
            'blog_vignette' => $blog->getBlog_vignette(),
            'blog_date' => $blog->getBlog_date(),
            'id_utilisateur' => $blog->getId_utilisateur(),
            'spotlight' => $blog->getSpotlight(),
            'publier' => $blog->getPublier()
        );
        $this->getDbTable()->update($data, array('blog_id = ?' => $blog->getBlog_id()));
    }

    public function delete($blog_id) {
        $this->getDbTable()->delete(array('blog_id = ?' => $blog_id));
    }


    public function fetchAll2() {
        $select = $this->getDbTable()->select();
		$select->where("publier = ? ", 1);
		$select->order("blog_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlog();
            $entry->setBlog_id($row->blog_id)
	                ->setBlog_titre($row->blog_titre)
                    ->setBlog_description($row->blog_description)
                    ->setBlog_resume($row->blog_resume)
	                ->setId_type_blog($row->id_type_blog)
					->setBlog_vignette($row->blog_vignette)
					->setBlog_date($row->blog_date)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setSpotlight($row->spotlight)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByType($type) {
        $select = $this->getDbTable()->select();
		$select->where("id_type_blog = ? ", $type);
		$select->where("publier = ? ", 1);
		$select->order("blog_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlog();
            $entry->setBlog_id($row->blog_id)
	                ->setBlog_titre($row->blog_titre)
                    ->setBlog_description($row->blog_description)
                    ->setBlog_resume($row->blog_resume)
	                ->setId_type_blog($row->id_type_blog)
					->setBlog_vignette($row->blog_vignette)
					->setBlog_date($row->blog_date)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setSpotlight($row->spotlight)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function fetchAll4($id) {
        $select = $this->getDbTable()->select();
		$select->where("blog_id != ? ", $id);
		$select->where("publier = ? ", 1);
		$select->order("blog_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlog();
            $entry->setBlog_id($row->blog_id)
	                ->setBlog_titre($row->blog_titre)
                    ->setBlog_description($row->blog_description)
                    ->setBlog_resume($row->blog_resume)
	                ->setId_type_blog($row->id_type_blog)
					->setBlog_vignette($row->blog_vignette)
					->setBlog_date($row->blog_date)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setSpotlight($row->spotlight)
                	->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    
    public function fetchAllBySpotlight($spotlight) {
        $select = $this->getDbTable()->select();
        $select->where("spotlight = ? ", $spotlight);
        $select->where("publier = ? ", 1);
        $select->order("blog_date DESC");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBlog();
            $entry->setBlog_id($row->blog_id)
                    ->setBlog_titre($row->blog_titre)
                    ->setBlog_description($row->blog_description)
                    ->setBlog_resume($row->blog_resume)
                    ->setId_type_blog($row->id_type_blog)
                    ->setBlog_vignette($row->blog_vignette)
                    ->setBlog_date($row->blog_date)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setSpotlight($row->spotlight)
                    ->setPublier($row->publier);
            $entries[] = $entry;
        }
        return $entries;
    }


}


?>
