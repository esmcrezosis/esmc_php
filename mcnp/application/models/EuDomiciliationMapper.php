<?php

class Application_Model_EuDomiciliationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDomiciliation');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuDomiciliation $domici) {
        $data = array(
            'code_domicilier' => $domici->getCode_domicilier(),
            'code_membre_beneficiaire' => $domici->getCode_membre_beneficiaire(),
            'code_membre_assureur' => $domici->getCode_membre_assureur(),
            'cat_ressource' => $domici->getCat_ressource(),
            'montant_subvent' => $domici->getMontant_subvent(),
            'montant_domicilier' => $domici->getMontant_domicilier(),
            'domicilier' => $domici->getDomicilier(),
            'accorder' => $domici->getAccorder(),
            'date_domiciliation' => $domici->getDate_domiciliation(),
            'date_echue' => $domici->getDate_echue(),
            'type_domiciliation' => $domici->getType_domiciliation(),
            'code_smcipn' => $domici->getCode_smcipn(),
            'code_smcipnp' => $domici->getCode_smcipnp(),
            'id_utilisateur' => $domici->getId_utilisateur(),
            'id_proposition' => $domici->getId_proposition(),
            'duree_renouvellement' => $domici->getDuree_renouvellement(),
            'reste_duree' => $domici->getReste_duree()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDomiciliation $domici) {
        $data = array(
            'code_domicilier' => $domici->getCode_domicilier(),
            'code_membre_beneficiaire' => $domici->getCode_membre_beneficiaire(),
            'code_membre_assureur' => $domici->getCode_membre_assureur(),
            'cat_ressource' => $domici->getCat_ressource(),
            'montant_subvent' => $domici->getMontant_subvent(),
            'montant_domicilier' => $domici->getMontant_domicilier(),
            'domicilier' => $domici->getDomicilier(),
            'accorder' => $domici->getAccorder(),
            'date_domiciliation' => $domici->getDate_domiciliation(),
            'date_echue' => $domici->getDate_echue(),
            'type_domiciliation' => $domici->getType_domiciliation(),
            'code_smcipn' => $domici->getCode_smcipn(),
            'code_smcipnp' => $domici->getCode_smcipnp(),
            'id_utilisateur' => $domici->getId_utilisateur(),
            'id_proposition' => $domici->getId_proposition(),
            'duree_renouvellement' => $domici->getDuree_renouvellement(),
            'reste_duree' => $domici->getReste_duree()
        );

        $this->getDbTable()->update($data, array('code_domicilier = ?' => $domici->getCode_domicilier()));
    }

    public function find($code_domicilier, Application_Model_EuDomiciliation $domici) {
        $result = $this->getDbTable()->find($code_domicilier);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $domici->setCode_domicilier($row->code_domicilier)
                ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                ->setCode_membre_assureur($row->code_membre_assureur)
                ->setCat_ressource($row->cat_ressource)
                ->setMontant_subvent($row->montant_subvent)
                ->setMontant_domicilier($row->montant_domicilier)
                ->setDomicilier($row->domicilier)
                ->setAccorder($row->accorder)
                ->setDate_domiciliation($row->date_domiciliation)
                ->setDate_echue($row->date_echue)
                ->setType_domiciliation($row->type_domiciliation)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setId_utilisateur($row->id_utilisateur)
                ->setId_proposition($row->id_proposition)
                ->setDuree_renouvellement($row->duree_renouvellement)
                ->setReste_duree($row->reste_duree);
        return true;
    }

    public function findBySmcipnp($code_smcipnp) {
        $select = $this->getDbTable()->select();
        $select->where('code_smcipnp = ?', $code_smcipnp);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $domici = new Application_Model_EuDomiciliation();
        $domici->setCode_domicilier($row->code_domicilier)
                ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                ->setCode_membre_assureur($row->code_membre_assureur)
                ->setCat_ressource($row->cat_ressource)
                ->setMontant_subvent($row->montant_subvent)
                ->setMontant_domicilier($row->montant_domicilier)
                ->setDomicilier($row->domicilier)
                ->setAccorder($row->accorder)
                ->setDate_domiciliation($row->date_domiciliation)
                ->setDate_echue($row->date_echue)
                ->setType_domiciliation($row->type_domiciliation)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setId_utilisateur($row->id_utilisateur)
                ->setId_proposition($row->id_proposition)
                ->setDuree_renouvellement($row->duree_renouvellement)
                ->setReste_duree($row->reste_duree);
        return $domici;
    }

    public function findBySmcipn($code_smcipn) {
        $select = $this->getDbTable()->select();
        $select->where('code_smcipn = ?',$code_smcipn);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
           return NULL;
        }
        $row = $result->current();
        $domici = new Application_Model_EuDomiciliation();
        $domici->setCode_domicilier($row->code_domicilier)
                ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                ->setCode_membre_assureur($row->code_membre_assureur)
                ->setCat_ressource($row->cat_ressource)
                ->setMontant_subvent($row->montant_subvent)
                ->setMontant_domicilier($row->montant_domicilier)
                ->setDomicilier($row->domicilier)
                ->setAccorder($row->accorder)
                ->setDate_domiciliation($row->date_domiciliation)
                ->setDate_echue($row->date_echue)
                ->setType_domiciliation($row->type_domiciliation)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setId_utilisateur($row->id_utilisateur)
                ->setId_proposition($row->id_proposition)
                ->setDuree_renouvellement($row->duree_renouvellement)
                ->setReste_duree($row->reste_duree);
        return $domici;
    }
    
    public function findByProposition($id_proposition) {
        $select = $this->getDbTable()->select();
        $select->where('id_proposition = ?', $id_proposition);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $domici = new Application_Model_EuDomiciliation();
        $domici->setCode_domicilier($row->code_domicilier)
                ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                ->setCode_membre_assureur($row->code_membre_assureur)
                ->setCat_ressource($row->cat_ressource)
                ->setMontant_subvent($row->montant_subvent)
                ->setMontant_domicilier($row->montant_domicilier)
                ->setDomicilier($row->domicilier)
                ->setAccorder($row->accorder)
                ->setDate_domiciliation($row->date_domiciliation)
                ->setDate_echue($row->date_echue)
                ->setType_domiciliation($row->type_domiciliation)
                ->setCode_smcipn($row->code_smcipn)
                ->setCode_smcipnp($row->code_smcipnp)
                ->setId_utilisateur($row->id_utilisateur)
                ->setId_proposition($row->id_proposition)
                ->setDuree_renouvellement($row->duree_renouvellement)
                ->setReste_duree($row->reste_duree);
        return $domici;
    }

    public function getSumDomicilier($code_smcipnp) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_subvent) as somme'));
        $select->where('code_smcipnp !=?', $code_smcipnp);
        $select->where('type_domiciliation !=?', 'TPASMCIPNP');
        $select->where('montant_subvent > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }
    
	
    public function getSumByProposition($id_proposition) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(montant_subvent) as somme'));
        $select->where('id_proposition LIKE ?', $id_proposition);
        $select->where('montant_subvent > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return 0;
        }
        $row = $result->current();
        return $row['somme'];
    }

	
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDomiciliation();
            $entry->setCode_domicilier($row->code_domicilier)
                    ->setCode_membre_beneficiaire($row->code_membre_beneficiaire)
                    ->setCode_membre_assureur($row->code_membre_assureur)
                    ->setCat_ressource($row->cat_ressource)
                    ->setMontant_subvent($row->montant_subvent)
                    ->setMontant_domicilier($row->montant_domicilier)
                    ->setDomicilier($row->domicilier)
                    ->setAccorder($row->accorder)
                    ->setDate_domiciliation($row->date_domiciliation)
                    ->setDate_echue($row->date_echue)
                    ->setType_domiciliation($row->type_domiciliation)
                    ->setCode_smcipn($row->code_smcipn)
                    ->setCode_smcipnp($row->code_smcipnp)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setId_proposition($row->id_proposition)
                ->setDuree_renouvellement($row->duree_renouvellement)
                ->setReste_duree($row->reste_duree);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_domicilier) {
        $this->getDbTable()->delete(array('code_domicilier = ?' => $code_domicilier));
    }

}

?>
