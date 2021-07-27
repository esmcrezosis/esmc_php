<?php
class Application_Model_EuDetailGcpPbfMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailGcpPbf');
        }
        return $this->_dbTable;
    }
	
	
	public function save(Application_Model_EuDetailGcpPbf $dgcppbf) {
        $data = array(
            'id_credit' => $dgcppbf->getId_credit(),
			'id_echange' => $dgcppbf->getId_echange(),
			'id_escompte' => $dgcppbf->getId_escompte(),
            'source_credit' => $dgcppbf->getSource_credit(),
            'code_gcp_pbf' => $dgcppbf->getCode_gcp_pbf(),
            'id_gcp_pbf' => $dgcppbf->getId_gcp_pbf(),
            'mont_gcp_pbf' => $dgcppbf->getMont_gcp_pbf(),
            'mont_preleve' => $dgcppbf->getMont_preleve(),
            'solde_gcp_pbf' => $dgcppbf->getSolde_gcp_pbf(),
            'type_capa' => $dgcppbf->getType_capa(),
            'agio' => $dgcppbf->getAgio(),
            'compensable' => $dgcppbf->getCompensable()
        );
        $this->getDbTable()->insert($data);
    }
	
	
	public function update(Application_Model_EuDetailGcpPbf $dgcppbf) {
        $data = array(
            'id_credit' => $dgcppbf->getId_credit(),
			'id_echange' => $dgcppbf->getId_echange(),
			'id_escompte' => $dgcppbf->getId_escompte(),
            'source_credit' => $dgcppbf->getSource_credit(),
            'code_gcp_pbf' => $dgcppbf->getCode_gcp_pbf(),
            'id_gcp_pbf' => $dgcppbf->getId_gcp_pbf(),
            'mont_gcp_pbf' => $dgcppbf->getMont_gcp_pbf(),
            'mont_preleve' => $dgcppbf->getMont_preleve(),
            'solde_gcp_pbf' => $dgcppbf->getSolde_gcp_pbf(),
            'type_capa' => $dgcppbf->getType_capa(),
            'agio' => $dgcppbf->getAgio(),
            'compensable' => $dgcppbf->getCompensable()
        );
        $this->getDbTable()->update($data, array('id_gcp_pbf = ?' => $dgcppbf->getId_gcp_pbf()));
    }
	
	
	
	public function find($id_gcp_pbf,Application_Model_EuDetailGcpPbf $dgcppbf) {
        $result = $this->getDbTable()->find($id_gcp_pbf);
        if (0 == count($result)) {
            return false;
        } else {
          $row = $result->current();
          $dgcppbf->setId_credit($row->id_credit)
                  ->setId_echange($row->id_echange)
                  ->setId_escompte($row->id_escompte)
                  ->setSource_credit($row->source_credit)
                  ->setCode_gcp_pbf($row->code_gcp_pbf)
                  ->setId_gcp_pbf($row->id_gcp_pbf)
                  ->setMont_gcp_pbf($row->mont_gcp_pbf)
                  ->setMont_preleve($row->mont_preleve)
                  ->setSolde_gcp_pbf($row->solde_gcp_pbf)
                  ->setType_capa($row->type_capa)
                  ->setAgio($row->agio)
                  ->setCompensable($row->compensable);
           return true;
		}
    }
	
	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailGcpPbf();
            $entry->setId_credit($row->id_credit)
                  ->setId_echange($row->id_echange)
                  ->setId_escompte($row->id_escompte)
                  ->setSource_credit($row->source_credit)
                  ->setCode_gcp_pbf($row->code_gcp_pbf)
                  ->setId_gcp_pbf($row->id_gcp_pbf)
                  ->setMont_gcp_pbf($row->mont_gcp_pbf)
                  ->setMont_preleve($row->mont_preleve)
                  ->setSolde_gcp_pbf($row->solde_gcp_pbf)
                  ->setType_capa($row->type_capa)
                  ->setAgio($row->agio)
                  ->setCompensable($row->compensable);
            $entries[] = $entry;
        }
        return $entries;
    }


    public function delete($id_gcp_pbf) {
        $this->getDbTable()->delete(array('id_gcp_pbf = ?' => $id_gcp_pbf));
    }
	
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_gcp_pbf) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    
}

