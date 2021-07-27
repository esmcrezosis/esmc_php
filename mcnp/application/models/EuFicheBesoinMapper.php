<?php

class Application_Model_EuFicheBesoinMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuFicheBesoin');
        }
        return $this->_dbTable;
    }
    
    public function find($id_fiche_besoin, Application_Model_EuFicheBesoin $fichebesoin) {
        $result = $this->getDbTable()->find($id_fiche_besoin);
        if(0 == count($result)) {
           return;
        }
        $row = $result->current();
        $fichebesoin->setId_fiche_besoin($row->id_fiche_besoin)
                    ->setDesignation_besoin($row->designation_besoin)
	                ->setDebut_periode_besoin($row->debut_periode_besoin)
	                ->setFin_periode_besoin($row->fin_periode_besoin)
	                ->setDate_besoin_exprime($row->date_besoin_exprime)
					->setCode_membre_demandeur($row->code_membre_demandeur)
	                ->setDesignation_demande($row->designation_demande)
	                ->setDate_demande($row->date_demande)
                    ->setValider($row->valider)
                    ->setLivrer($row->livrer)
                    ->setRejeter($row->rejeter)
					->setCode_membre_prestataire($row->code_membre_prestataire)
					;    
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach($resultSet as $row) {
            $entry = new Application_Model_EuFicheBesoin();
            $entry->setId_fiche_besoin($row->id_fiche_besoin)
                  ->setDesignation_besoin($row->designation_besoin)
	              ->setDebut_periode_besoin($row->debut_periode_besoin)
	              ->setFin_periode_besoin($row->fin_periode_besoin)
	              ->setDate_besoin_exprime($row->date_besoin_exprime)
				  ->setCode_membre_demandeur($row->code_membre_demandeur)
	              ->setDesignation_demande($row->designation_demande)
	              ->setDate_demande($row->date_demande)
                  ->setValider($row->valider)
                  ->setLivrer($row->livrer)
                  ->setRejeter($row->rejeter)
				  ->setCode_membre_prestataire($row->code_membre_prestataire);
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function save(Application_Model_EuFicheBesoin $fichebesoin) {
        $data = array(
            'id_fiche_besoin' => $fichebesoin->getId_fiche_besoin(),
            'designation_besoin' => $fichebesoin->getDesignation_besoin(),
            'debut_periode_besoin' => $fichebesoin->getDebut_periode_besoin(),
			'fin_periode_besoin' => $fichebesoin->getFin_periode_besoin(),
            'date_besoin_exprime' => $fichebesoin->getDate_besoin_exprime(),
            'code_membre_demandeur' => $fichebesoin->getCode_membre_demandeur(),
            'designation_demande' => $fichebesoin->getDesignation_demande(),
            'date_demande' => $fichebesoin->getDate_demande(),
            'valider' => $fichebesoin->getValider(),
            'livrer' => $fichebesoin->getLivrer(),
            'rejeter' => $fichebesoin->getRejeter(),
			'code_membre_prestataire' => $fichebesoin->getCode_membre_prestataire()
			
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuFicheBesoin $fichebesoin) {
        $data = array(
            'id_fiche_besoin' => $fichebesoin->getId_fiche_besoin(),
            'designation_besoin' => $fichebesoin->getDesignation_besoin(),
            'debut_periode_besoin' => $fichebesoin->getDebut_periode_besoin(),
			'fin_periode_besoin' => $fichebesoin->getFin_periode_besoin(),
            'date_besoin_exprime' => $fichebesoin->getDate_besoin_exprime(),
            'code_membre_demandeur' => $fichebesoin->getCode_membre_demandeur(),
            'designation_demande' => $fichebesoin->getDesignation_demande(),
            'date_demande' => $fichebesoin->getDate_demande(),
            'valider' => $fichebesoin->getValider(),
            'livrer' => $fichebesoin->getLivrer(),
            'rejeter' => $fichebesoin->getRejeter(),
			'code_membre_prestataire' => $fichebesoin->getCode_membre_prestataire()
        );
        $this->getDbTable()->update($data, array('id_fiche_besoin = ?' => $fichebesoin->getId_fiche_besoin()));
    }
    
    public function delete($id_fiche_besoin) {
        $this->getDbTable()->delete(array('id_fiche_besoin = ?' => $id_fiche_besoin));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_fiche_besoin) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>