<?php

class Application_Model_EuGcpMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuGcp');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuGcp $gcp) {
        $data = array(
            'id_gcp' => $gcp->getId_gcp(),
            'code_tegc' => $gcp->getCode_tegc(),
            'id_credit' => $gcp->getId_credit(),
            'code_cat' => $gcp->getCode_cat(),
            'mont_gcp' => $gcp->getMont_gcp(),
            'source' => $gcp->getSource(),
            'date_conso' => $gcp->getDate_conso(),
            'code_membre' => $gcp->getCode_membre(),
            'mont_preleve' => $gcp->getMont_preleve(),
            'reste' => $gcp->getReste(),
            'bon_id' => $gcp->getBon_id(),
			'type_gcp' => $gcp->getType_gcp()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuGcp $gcp) {
        $data = array(
            'id_gcp' => $gcp->getId_gcp(),
            'code_tegc' => $gcp->getCode_tegc(),
            'id_credit' => $gcp->getId_credit(),
            'code_cat' => $gcp->getCode_cat(),
            'mont_gcp' => $gcp->getMont_gcp(),
            'source' => $gcp->getSource(),
            'date_conso' => $gcp->getDate_conso(),
            'code_membre' => $gcp->getCode_membre(),
            'mont_preleve' => $gcp->getMont_preleve(),
            'reste' => $gcp->getReste(),
			'bon_id' => $gcp->getBon_id(),
			'type_gcp' => $gcp->getType_gcp()
        );
        $this->getDbTable()->update($data, array('id_gcp = ?' => $gcp->getId_gcp()));
    }

    public function find($id_gcp, Application_Model_EuGcp $gcp) {
        $result = $this->getDbTable()->find($id_gcp);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $gcp->setId_gcp($row->id_gcp)
                ->setCode_tegc($row->code_tegc)
                ->setId_credit($row->id_credit)
                ->setSource($row->source)
                ->setCode_cat($row->code_cat)
                ->setMont_gcp($row->mont_gcp)
                ->setDate_conso($row->date_conso)
                ->setCode_membre($row->code_membre)
                ->setMont_preleve($row->mont_preleve)
                ->setReste($row->reste)
				->setBon_id($row->bon_id)
				->setType_gcp($row->type_gcp);
        return true;
    }

    public function findSommeGcp($membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(reste) as total'));
        $select->where('code_membre = ?', $membre)
                ->where('reste > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            return $row['total'];
        } else {
            return 0;
        }
    }

    public function findGcp($compte) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre = ?', $compte)
                ->where('reste > ?', 0)
                ->order('date_conso', 'ASC');
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGcp();
            $entry->setId_gcp($row->id_gcp)
                  ->setCode_tegc($row->code_tegc)
                  ->setId_credit($row->id_credit)
                  ->setSource($row->source)
                  ->setCode_cat($row->code_cat)
                  ->setMont_gcp($row->mont_gcp)
                  ->setDate_conso($row->date_conso)
                  ->setCode_membre($row->code_membre)
                  ->setMont_preleve($row->mont_preleve)
                  ->setReste($row->reste)
				  ->setBon_id($row->bon_id)
				  ->setType_gcp($row->type_gcp);;
            $entries[] = $entry;
        }
        return $entries;
    }
	
	

    public function findGcpByTegcp($code_te) {
        $select = $this->getDbTable()->select();
        $select->where('code_tegc LIKE ?', $code_te)
               ->where('reste > ?',0)
               ->order('reste DESC')
               ->order('date_conso ASC');
        $result = $this->getDbTable()->fetchAll($select);
        if(count($result) == 0) {
           return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuGcp();
            $entry->setId_gcp($row->id_gcp)
                  ->setCode_tegc($row->code_tegc)
                  ->setId_credit($row->id_credit)
                  ->setSource($row->source)
                  ->setCode_cat($row->code_cat)
                  ->setMont_gcp($row->mont_gcp)
                  ->setDate_conso($row->date_conso)
                  ->setCode_membre($row->code_membre)
                  ->setMont_preleve($row->mont_preleve)
                  ->setReste($row->reste)
				  ->setBon_id($row->bon_id)
				  ->setType_gcp($row->type_gcp);
            $entries[] = $entry;
        }
        return $entries;
    }
	
	
	

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGcp();
            $entry->setId_gcp($row->id_gcp)
                    ->setCode_tegc($row->code_tegc)
                    ->setId_credit($row->id_credit)
                    ->setSource($row->source)
                    ->setCode_cat($row->code_cat)
                    ->setMont_gcp($row->mont_gcp)
                    ->setDate_conso($row->date_conso)
                    ->setCode_membre($row->code_membre)
                    ->setMont_preleve($row->mont_preleve)
                    ->setReste($row->reste)
					->setBon_id($row->bon_id)
				    ->setType_gcp($row->type_gcp);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_gcp) {
        $this->getDbTable()->delete(array('id_gcp = ?' => $id_gcp));
    }
	
	
    //////////////////////////////////////////////////////////	
	
	
    public function fetchAll2($code_membre, $code_cat) {
        $select = $this->getDbTable()->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);}
		if(isset($code_cat) && $code_cat!=""){
        $select->where('code_cat LIKE ?', $code_cat);}
        $select->order(array('date_conso DESC'));
		$select->limit(50);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuGcp();
            $entry->setId_gcp($row->id_gcp)
                    ->setCode_tegc($row->code_tegc)
                    ->setId_credit($row->id_credit)
                    ->setSource($row->source)
                    ->setCode_cat($row->code_cat)
                    ->setMont_gcp($row->mont_gcp)
                    ->setDate_conso($row->date_conso)
                    ->setCode_membre($row->code_membre)
                    ->setMont_preleve($row->mont_preleve)
                    ->setReste($row->reste)
					->setBon_id($row->bon_id)
				    ->setType_gcp($row->type_gcp);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function findByCodeCatSolde($code_membre, $code_cat, Application_Model_EuGcp $Gcp) {
        $table = new Application_Model_DbTable_EuGcp();
        $select = $table->select();
		$select->from(array('eu_gcp'), array('code_membre', 'code_cat', 'solde' => 'SUM(reste)'));
        $select->group(array('code_membre', 'code_cat'));
		if(isset($code_membre) && $code_membre!=""){        
		$select->having("code_membre LIKE '".$code_membre."'");}
		if(isset($code_cat) && $code_cat!=""){		
		$select->having('code_cat LIKE ?', $code_cat);}
        $result = $table->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
        $Gcp->setCode_cat($row->code_cat)
                ->setReste($row->solde)
                    ->setCode_membre($row->code_membre);
        return true;
    }

    public function findOne($code_membre, Application_Model_EuGcp $Gcp) {
        $select = $this->getDbTable()->select();
		if(isset($code_membre) && $code_membre!=""){
        $select->where('code_membre = ?', $code_membre);}
		$select->limit(1);
        $resultSet = $this->getDbTable()->fetchRow($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result;
            $Gcp = new Application_Model_EuGcp();
            $Gcp->setId_gcp($row->id_gcp)
                    ->setCode_tegc($row->code_tegc)
                    ->setId_credit($row->id_credit)
                    ->setSource($row->source)
                    ->setCode_cat($row->code_cat)
                    ->setMont_gcp($row->mont_gcp)
                    ->setDate_conso($row->date_conso)
                    ->setCode_membre($row->code_membre)
                    ->setMont_preleve($row->mont_preleve)
                    ->setReste($row->reste)
					->setBon_id($row->bon_id)
				->setType_gcp($row->type_gcp);
        return true;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_gcp) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function fetchByTegcCumul($code_tegc = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(reste) as count'));
        if($code_tegc != ""){
        $select->where("code_tegc LIKE '".$code_tegc."'");
    }
        $select->where("type_gcp LIKE 'DIST'");
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }


}

