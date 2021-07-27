<?php

class Application_Model_EuSmcipnMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuSmcipn');
        }
        return $this->_dbTable;
    }

    public function findmtsalaire($code) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('montant_salaire'));
        $select->where('code_smcipn = ?', $code);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['montant_salaire'];
    }

    public function findmtinvesti($code) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('montant_investis'));
        $select->where('code_smcipn = ?', $code);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['montant_investis'];
    }
    
    public function getLastCodeByMembre($code_membre) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_smcipn) as code'));
        $select->where('code_membre LIKE ?', $code_membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        } else {
            $row = $result->current();
            return $row['code'];
        }
    }

    public function save(Application_Model_EuSmcipn $smcipn) {
        $data = array(
            'code_smcipn' => $smcipn->getCode_smcipn(),
            'lib_demande' => $smcipn->getLib_demande(),
            'code_membre' => $smcipn->getCode_membre(),
            'desc_demande' => $smcipn->getDesc_demande(),
            'req_demande' => $smcipn->getReq_demande(),
            'date_demande' => $smcipn->getDate_demande(),
            'heure_demande' => $smcipn->getHeure_demande(),
            'date_deb' => $smcipn->getDate_deb(),
            'date_fin' => $smcipn->getDate_fin(),
            'date_alloc' => $smcipn->getDate_alloc(),
            'dvm_demande' => $smcipn->getDvm_demande(),
            'montant_salaire' => $smcipn->getMontant_salaire(),
            'montant_investis' => $smcipn->getMontant_investis(),
            'etat_demande_inv' => $smcipn->getEtat_demande_inv(),
            'id_utilisateur' => $smcipn->getId_utilisateur(),
            'source_demande' => $smcipn->getSource_demande(),
            'valid_gac' => $smcipn->getValid_gac(),
            'valid_fil' => $smcipn->getValid_fil(),
            'valid_creneau' => $smcipn->getValid_creneau(),
            'alloc_gac_inv' => $smcipn->getAlloc_gac_inv(),
            'alloc_fil_inv' => $smcipn->getAlloc_fil_inv(),
            'alloc_creneau_inv' => $smcipn->getAlloc_creneau_inv(),
            'type_objet' => $smcipn->getType_objet(),
            'code_gac' => $smcipn->getCode_gac(),
            'domicilier' => $smcipn->getDomicilier(),
            'rembourser' => $smcipn->getRembourser(),
            'type_smcipn' => $smcipn->getType_smcipn(),
            'salaire_alloue' => $smcipn->getSalaire_alloue(),
            'investis_alloue' => $smcipn->getInvestis_alloue(),
            'allouer_i' => $smcipn->getAllouer_i(),
            'allouer_s' => $smcipn->getAllouer_s(),
            'type_alloc' => $smcipn->getType_alloc(),
            'etat_demande_sal' => $smcipn->getEtat_demande_sal(),
            'alloc_gac_sal' => $smcipn->getAlloc_gac_sal(),
            'alloc_fil_sal' => $smcipn->getAlloc_fil_sal(),
            'alloc_creneau_sal' => $smcipn->getAlloc_creneau_sal(),
            'sal_transmis' => $smcipn->getSal_transmis(),
            'etat_sal' => $smcipn->getEtat_sal()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuSmcipn $smcipn) {
        $data = array(
            'code_smcipn' => $smcipn->getCode_smcipn(),
            'lib_demande' => $smcipn->getLib_demande(),
            'code_membre' => $smcipn->getCode_membre(),
            'desc_demande' => $smcipn->getDesc_demande(),
            'req_demande' => $smcipn->getReq_demande(),
            'date_demande' => $smcipn->getDate_demande(),
            'heure_demande' => $smcipn->getHeure_demande(),
            'date_deb' => $smcipn->getDate_deb(),
            'date_fin' => $smcipn->getDate_fin(),
            'date_alloc' => $smcipn->getDate_alloc(),
            'dvm_demande' => $smcipn->getDvm_demande(),
            'montant_salaire' => $smcipn->getMontant_salaire(),
            'montant_investis' => $smcipn->getMontant_investis(),
            'etat_demande_inv' => $smcipn->getEtat_demande_inv(),
            'id_utilisateur' => $smcipn->getId_utilisateur(),
            'source_demande' => $smcipn->getSource_demande(),
            'valid_gac' => $smcipn->getValid_gac(),
            'valid_fil' => $smcipn->getValid_fil(),
            'valid_creneau' => $smcipn->getValid_creneau(),
            'alloc_gac_inv' => $smcipn->getAlloc_gac_inv(),
            'alloc_fil_inv' => $smcipn->getAlloc_fil_inv(),
            'alloc_creneau_inv' => $smcipn->getAlloc_creneau_inv(),
            'type_objet' => $smcipn->getType_objet(),
            'code_gac' => $smcipn->getCode_gac(),
            'domicilier' => $smcipn->getDomicilier(),
            'rembourser' => $smcipn->getRembourser(),
            'type_smcipn' => $smcipn->getType_smcipn(),
            'salaire_alloue' => $smcipn->getSalaire_alloue(),
            'investis_alloue' => $smcipn->getInvestis_alloue(),
            'allouer_i' => $smcipn->getAllouer_i(),
            'allouer_s' => $smcipn->getAllouer_s(),
            'type_alloc' => $smcipn->getType_alloc(),
            'etat_demande_sal' => $smcipn->getEtat_demande_sal(),
            'alloc_gac_sal' => $smcipn->getAlloc_gac_sal(),
            'alloc_fil_sal' => $smcipn->getAlloc_fil_sal(),
            'alloc_creneau_sal' => $smcipn->getAlloc_creneau_sal(),
            'sal_transmis' => $smcipn->getSal_transmis(),
            'etat_sal' => $smcipn->getEtat_sal()
        );

        $this->getDbTable()->update($data, array('code_smcipn = ?' => $smcipn->getCode_smcipn()));
    }

    public function find($code_smcipn, Application_Model_EuSmcipn $smcipn) {
        $result = $this->getDbTable()->find($code_smcipn);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $smcipn->setCode_smcipn($row->code_smcipn)
                ->setLib_demande($row->lib_demande)
                ->setCode_membre($row->code_membre)
                ->setDesc_demande($row->desc_demande)
                ->setReq_demande($row->req_demande)
                ->setDate_demande($row->date_demande)
                ->setHeure_demande($row->heure_demande)
                ->setDate_deb($row->date_deb)
                ->setDate_fin($row->date_fin)
                ->setDate_alloc($row->date_alloc)
                ->setDvm_demande($row->dvm_demande)
                ->setMontant_salaire($row->montant_salaire)
                ->setMontant_investis($row->montant_investis)
                ->setEtat_demande_inv($row->etat_demande_inv)
                ->setId_utilisateur($row->id_utilisateur)
                ->setSource_demande($row->source_demande)
                ->setValid_gac($row->valid_gac)
                ->setValid_fil($row->valid_fil)
                ->setValid_creneau($row->valid_creneau)
                ->setAlloc_gac_inv($row->alloc_gac_inv)
                ->setAlloc_fil_inv($row->alloc_fil_inv)
                ->setAlloc_creneau_inv($row->alloc_creneau_inv)
                ->setType_objet($row->type_objet)
                ->setCode_gac($row->code_gac)
                ->setDomicilier($row->domicilier)
                ->setRembourser($row->rembourser)
                ->setType_smcipn($row->type_smcipn)
                ->setSalaire_alloue($row->salaire_alloue)
                ->setInvestis_alloue($row->investis_alloue)
                ->setAllouer_i($row->allouer_i)
                ->setAllouer_s($row->allouer_s)
                ->setType_alloc($row->type_alloc)
                ->setEtat_demande_sal($row->etat_demande_sal)
                ->setAlloc_gac_sal($row->alloc_gac_sal)
                ->setAlloc_fil_sal($row->alloc_fil_sal)
                ->setAlloc_creneau_sal($row->alloc_creneau_sal)
                ->setSal_transmis($row->sal_transmis)
                ->setEtat_sal($row->etat_sal);
        return true;
    }

    public function findByMembre($membre, Application_Model_EuSmcipn $smcipn) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre = ?', $membre)
                ->where('rembourser = ?', 0)
                ->where('domicilier = ?', 0);
        $result = $this->getDbTable->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $smcipn->setCode_smcipn($row->code_smcipn)
                ->setLib_demande($row->lib_demande)
                ->setCode_membre($row->code_membre)
                ->setDesc_demande($row->desc_demande)
                ->setReq_demande($row->req_demande)
                ->setDate_demande($row->date_demande)
                ->setHeure_demande($row->heure_demande)
                ->setDate_deb($row->date_deb)
                ->setDate_fin($row->date_fin)
                ->setDate_alloc($row->date_alloc)
                ->setDvm_demande($row->dvm_demande)
                ->setMontant_salaire($row->montant_salaire)
                ->setMontant_investis($row->montant_investis)
                ->setEtat_demande_inv($row->etat_demande_inv)
                ->setId_utilisateur($row->id_utilisateur)
                ->setSource_demande($row->source_demande)
                ->setValid_gac($row->valid_gac)
                ->setValid_fil($row->valid_fil)
                ->setValid_creneau($row->valid_creneau)
                ->setAlloc_gac_inv($row->alloc_gac_inv)
                ->setAlloc_fil_inv($row->alloc_fil_inv)
                ->setAlloc_creneau_inv($row->alloc_creneau_inv)
                ->setType_objet($row->type_objet)
                ->setCode_gac($row->code_gac)
                ->setDomicilier($row->domicilier)
                ->setRembourser($row->rembourser)
                ->setType_smcipn($row->type_smcipn)
                ->setSalaire_alloue($row->salaire_alloue)
                ->setInvestis_alloue($row->investis_alloue)
                ->setAllouer_i($row->allouer_i)
                ->setAllouer_s($row->allouer_s)
                ->setType_alloc($row->type_alloc)
                ->setEtat_demande_sal($row->etat_demande_sal)
                ->setAlloc_gac_sal($row->alloc_gac_sal)
                ->setAlloc_fil_sal($row->alloc_fil_sal)
                ->setAlloc_creneau_sal($row->alloc_creneau_sal)
                ->setSal_transmis($row->sal_transmis)
                ->setEtat_sal($row->etat_sal);
        return true;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuSmcipn();
            $entry->setCode_smcipn($row->code_smcipn)
                    ->setLib_demande($row->lib_demande)
                    ->setCode_membre($row->code_membre)
                    ->setDesc_demande($row->desc_demande)
                    ->setReq_demande($row->req_demande)
                    ->setDate_demande($row->date_demande)
                    ->setHeure_demande($row->heure_demande)
                    ->setDate_deb($row->date_deb)
                    ->setDate_fin($row->date_fin)
                    ->setDate_alloc($row->date_alloc)
                    ->setDvm_demande($row->dvm_demande)
                    ->setMontant_salaire($row->montant_salaire)
                    ->setMontant_investis($row->montant_investis)
                    ->setEtat_demande_inv($row->etat_demande_inv)
                    ->setId_utilisateur($row->id_utilisateur)
                    ->setSource_demande($row->source_demande)
                    ->setValid_gac($row->valid_gac)
                    ->setValid_fil($row->valid_fil)
                    ->setValid_creneau($row->valid_creneau)
                    ->setAlloc_gac_inv($row->alloc_gac_inv)
                    ->setAlloc_fil_inv($row->alloc_fil_inv)
                    ->setAlloc_creneau_inv($row->alloc_creneau_inv)
                    ->setType_objet($row->type_objet)
                    ->setCode_gac($row->code_gac)
                    ->setDomicilier($row->domicilier)
                    ->setRembourser($row->rembourser)
                    ->setType_smcipn($row->type_smcipn)
                    ->setSalaire_alloue($row->salaire_alloue)
                    ->setInvestis_alloue($row->investis_alloue)
                    ->setAllouer_i($row->allouer_i)
                    ->setAllouer_s($row->allouer_s)
                    ->setType_alloc($row->type_alloc)
                    ->setEtat_demande_sal($row->etat_demande_sal)
                    ->setAlloc_gac_sal($row->alloc_gac_sal)
                    ->setAlloc_fil_sal($row->alloc_fil_sal)
                    ->setAlloc_creneau_sal($row->alloc_creneau_sal)
                    ->setSal_transmis($row->sal_transmis)
                    ->setEtat_sal($row->etat_sal);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($code_smcipn) {
        $this->getDbTable()->delete(array('code_smcipn = ?' => $code_smcipn));
    }

}

?>
