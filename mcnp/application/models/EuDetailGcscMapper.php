<?php

class Application_Model_EuDetailGcscMapper {

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
           $this->setDbTable('Application_Model_DbTable_EuDetailGcsc');
        }
        return $this->_dbTable;
    }
	
	$id_detail_gcsc;
    $code_membre;
    $date_conso;
    $mont_gcsc;
    $source;
    $id_credit;
    $id_gcsc;
    $bon_id;

    public function save(Application_Model_EuDetailGcsc $gcsc) {
        $data = array(
          'id_detail_gcsc' => $gcsc->getId_detail_gcsc(),
          'code_membre' => $gcsc->getCode_membre(),
          'date_conso' => $gcsc->getDate_conso(),
          'mont_gcsc' => $gcsc->getMont_gcsc(),
          'source' => $gcsc->getSource(),
          'id_credit' => $gcsc->getId_credit(),
	      'id_gcsc' => $gcsc->getId_gcsc(),
          'bon_id' => $gcsc->getBon_id()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailGcsc $gcsc) {
        $data = array(
          'id_detail_gcsc' => $gcsc->getId_detail_gcsc(),
          'code_membre' => $gcsc->getCode_membre(),
          'date_conso' => $gcsc->getDate_conso(),
          'mont_gcsc' => $gcsc->getMont_gcsc(),
          'source' => $gcsc->getSource(),
          'id_credit' => $gcsc->getId_credit(),
		  'id_gcsc' => $gcsc->getId_gcsc(),
          'bon_id' => $gcsc->getBon_id()
        );
        $this->getDbTable()->update($data, array('id_detail_gcsc = ?' => $gcsc->getId_detail_gcsc()));
    }

    public function find($id_detail_gcsc, Application_Model_EuDetailGcsc $gcsc) {
        $result = $this->getDbTable()->find($id_detail_gcsc);
        if (0 == count($result)) {
           return;
        }
        $row = $result->current();
        $gcsc->setId_detail_gcsc($row->id_detail_gcsc)
             ->setCode_membre($row->code_membre)
             ->setDate_conso($row->date_conso)
             ->setMont_gcsc($row->mont_gcsc)
             ->setSource($row->source)
             ->setId_credit($row->id_credit)
			 ->setId_gcsc($row->id_gcsc)
             ->setBon_id($row->bon_id);
    }

	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailGcsc();
            $entry->setId_detail_gcsc($row->id_detail_gcsc)
                  ->setCode_membre($row->code_membre)
                  ->setDate_conso($row->date_conso)
                  ->setMont_gcsc($row->mont_gcsc)
                  ->setSource($row->source)
                  ->setId_credit($row->id_credit)
			      ->setId_gcsc($row->id_gcsc)
                  ->setBon_id($row->bon_id)
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findByMembre($membre) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre= ?', $membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return NULL;
        }
        $row = $result->current();
        $gcsc = new Application_Model_EuDetailGcsc();
        $gcsc->setId_detail_gcsc($row->id_detail_gcsc)
             ->setCode_membre($row->code_membre)
             ->setDate_conso($row->date_conso)
             ->setMont_gcsc($row->mont_gcsc)
             ->setSource($row->source)
             ->setId_credit($row->id_credit)
			 ->setId_gcsc($row->id_gcsc)
             ->setBon_id($row->bon_id)
        return $gcsc;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_gcsc) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function delete($id_detail_gcsc) {
      $this->getDbTable()->delete(array('id_detail_gcsc = ?' => $id_detail_gcsc));
    }

}

