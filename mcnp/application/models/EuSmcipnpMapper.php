<?php

class Application_Model_EuSmcipnpMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSmcipnp');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuSmcipnp $smcipnp) {
        $data = array(
            'code_smcipnp' => $smcipnp->getCode_smcipnp(),
            'lib_smcipnp' => $smcipnp->getLib_smcipnp(),
            'code_membre' => $smcipnp->getCode_membre(),
            'desc_smcipnp' => $smcipnp->getDesc_smcipnp(),
            'date_smcipnp' => $smcipnp->getDate_smcipnp(),
            'heure_smcipnp' => $smcipnp->getHeure_smcipnp(),
            'montant_smcipnp' => $smcipnp->getMontant_smcipnp(),
            'source_smcipnp' => $smcipnp->getSource_smcipnp(),
            'code_acteur' => $smcipnp->getCode_acteur(),
            'date_alloc' => $smcipnp->getDate_alloc(),
            'etat_smcipnp' => $smcipnp->getEtat_smcipnp(),
            'transferer' => $smcipnp->getTransferer(),
            'rembourser' => $smcipnp->getRembourser(),
            'id_utilisateur' => $smcipnp->getId_utilisateur(),
            'domicilier' => $smcipnp->getDomicilier()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSmcipnp $smcipnp) {
        $data = array(
            'code_smcipnp' => $smcipnp->getCode_smcipnp(),
            'lib_smcipnp' => $smcipnp->getLib_smcipnp(),
            'code_membre' => $smcipnp->getCode_membre(),
            'desc_smcipnp' => $smcipnp->getDesc_smcipnp(),
            'date_smcipnp' => $smcipnp->getDate_smcipnp(),
            'heure_smcipnp' => $smcipnp->getHeure_smcipnp(),
            'montant_smcipnp' => $smcipnp->getMontant_smcipnp(),
            'source_smcipnp' => $smcipnp->getSource_smcipnp(),
            'code_acteur' => $smcipnp->getCode_acteur(),
            'date_alloc' => $smcipnp->getDate_alloc(),
            'etat_smcipnp' => $smcipnp->getEtat_smcipnp(),
            'transferer' => $smcipnp->getTransferer(),
            'rembourser' => $smcipnp->getRembourser(),
            'id_utilisateur' => $smcipnp->getId_utilisateur(),
            'domicilier' => $smcipnp->getDomicilier()
        );
        $this->getDbTable()->update($data, array('code_smcipnp = ?' => $smcipnp->getCode_smcipnp()));
    }

    public function find($code_smcipnp, Application_Model_EuSmcipnp $smcipnp) {
        $result = $this->getDbTable()->find($code_smcipnp);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $smcipnp->setCode_smcipnp($row->code_smcipnp)
                ->setLib_smcipnp($row->lib_smcipnp)
                ->setCode_membre($row->code_membre)
                ->setDesc_smcipnp($row->desc_smcipnp)
                ->setDate_smcipnp($row->date_smcipnp)
                ->setHeure_smcipnp($row->heure_smcipnp)
                ->setMontant_smcipnp($row->montant_smcipnp)
                ->setSource_smcipnp($row->source_smcipnp)
                ->setCode_acteur($row->code_acteur)
                ->setDate_alloc($row->date_alloc)
                ->setEtat_smcipnp($row->etat_smcipnp)
                ->setTransferer($row->transferer)
                ->setRembourser($row->rembourser)
                ->setId_utilisateur($row->id_utilisateur)
                ->setDomicilier($row->domicilier);
        return true;
    }

    public function findByMembre($membre, Application_Model_EuSmcipnp $smcipnp) {
        $select = $this->getDbTable()->select();
        $select->where('num_membre = ?', $membre)
                ->where('rembourser = ?', 0)
                ->where('domicilier = ?', 0);
        $result = $this->getDbTable->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $smcipnp->setCode_smcipnp($row->code_smcipnp)
                ->setLib_smcipnp($row->lib_smcipnp)
                ->setCode_membre($row->code_membre)
                ->setDesc_smcipnp($row->desc_smcipnp)
                ->setDate_smcipnp($row->date_smcipnp)
                ->setHeure_smcipnp($row->heure_smcipnp)
                ->setMontant_smcipnp($row->montant_smcipnp)
                ->setSource_smcipnp($row->source_smcipnp)
                ->setCode_acteur($row->code_acteur)
                ->setDate_alloc($row->date_alloc)
                ->setEtat_smcipnp($row->etat_smcipnp)
                ->setTransferer($row->transferer)
                ->setRembourser($row->rembourser)
                ->setId_utilisateur($row->id_utilisateur)
                ->setDomicilier($row->domicilier);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmcipn();
            $entry->setCode_smcipnp($row->code_smcipnp)
                    ->setLib_smcipnp($row->lib_smcipnp)
                    ->setCode_membre($row->code_membre)
                    ->setDesc_smcipnp($row->desc_smcipnp)
                    ->setDate_smcipnp($row->date_smcipnp)
                    ->setHeure_smcipnp($row->heure_smcipnp)
                    ->setMontant_smcipnp($row->montant_smcipnp)
                    ->setSource_smcipnp($row->source_smcipnp)
                    ->setCode_acteur($row->code_acteur)
                    ->setDate_alloc($row->date_alloc)
                    ->setEtat_smcipnp($row->etat_smcipnp)
                    ->setTransferer($row->transferer)
                    ->setRembourser($row->rembourser)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setDomicilier($row->domicilier);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_smcipnp) {
        $this->getDbTable()->delete(array('code_smcipnp = ?' => $code_smcipnp));
    }

}

?>
