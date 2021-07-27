<?php
class Application_Model_EuFicheStockMapper {

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
/*
	id_fiche_stock
	nom_article
	validation_ggsm
	validation_agent_comptable
	validation_rsf 
*/
    public function getDbTable() {
        if (NULL === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_EuFicheStock');
        }
        return $this->_dbTable;
    }
    public function find($id_fiche_stock, Application_Model_EuFicheStock $fiche_stock) {
        $result = $this->getDbTable()->find($id_fiche_stock);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $fiche_stock->setId_fiche_stock($row->id_fiche_stock)
				->setNom_article($row->nom_article)
				->setValidation_ggsm($row->validation_ggsm)
				->setValidation_agent_comptable($row->validation_agent_comptable)
				->setValidation_rsf($row->validation_rsf)
           ->setValid($row->valid)
           ->setEtat($row->etat)
                      ;    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuFicheStock();
            $entry->setId_fiche_stock($row->id_fiche_stock)
				->setNom_article($row->nom_article)
				->setValidation_ggsm($row->validation_ggsm)
				->setValidation_agent_comptable($row->validation_agent_comptable)
				->setValidation_rsf($row->validation_rsf)
           ->setValid($row->valid)
           ->setEtat($row->etat)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuFicheStock $fiche_stock){
        $data = array(
			'id_fiche_stock' => $fiche_stock->getId_fiche_stock(),
	        'nom_article' => $fiche_stock->getNom_article(),
			'validation_ggsm' => $fiche_stock->getValidation_gsm(),
			'validation_agent_comptable' => $fiche_stock->getValidation_agent_comptable(),
			'validation_rsf' => $fiche_stock->getValidation_rsf(),
            'valid' => $fiche_stock->getValid(),
            'etat' => $fiche_stock->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailFicheStock $fiche_stock) {
        $data = array(
			'id_fiche_stock' => $fiche_stock->getId_fiche_stock(),
	        'nom_article' => $fiche_stock->getNom_article(),
			'validation_ggsm' => $fiche_stock->getValidation_gsm(),
			'validation_agent_comptable' => $fiche_stock->getValidation_agent_comptable(),
			'validation_rsf' => $fiche_stock->getValidation_rsf(),
            'valid' => $fiche_stock->getValid(),
            'etat' => $fiche_stock->getEtat()
        );
        $this->getDbTable()->update($data, array('id_fiche_stock = ?' => $fiche_stock->getId_fiche_stock()));
    }
    
    public function delete($id_fiche_stock,$id_fiche_stock) {
        $this->getDbTable()->delete(array('id_fiche_stock = ?' => $id_fiche_stock));
    }

    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fiche_stock) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}  
?>