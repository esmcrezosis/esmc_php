<?php

class Application_Model_EuTpagcpMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuTpagcp');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuTpagcp $tpagcp) {
        $data = array(
            'id_tpagcp' => $tpagcp->getId_tpagcp(),
            'code_compte' => $tpagcp->getCode_compte(),
            'code_membre' => $tpagcp->getCode_membre(),
            'mont_gcp' => $tpagcp->getMont_gcp(),
            'ntf' => $tpagcp->getNtf(),
            'mont_tranche' => $tpagcp->getMont_tranche(),
            'date_deb' => $tpagcp->getDate_deb(),
            'periode' => $tpagcp->getPeriode(),
            'date_fin' => $tpagcp->getDate_fin(),
            'mont_echu' => $tpagcp->getMont_echu(),
            'mont_echange' => $tpagcp->getMont_echange(),
            'mont_escompte' => $tpagcp->getMont_escompte(),
            'solde' => $tpagcp->getSolde(),
            'date_fin_tranche' => $tpagcp->getDate_fin_tranche(),
            'date_deb_tranche' => $tpagcp->getDate_deb_tranche(),
            'reste_ntf' => $tpagcp->getReste_ntf(),
            'escomptable' => $tpagcp->getEscomptable(),
            'type_ressource' => $tpagcp->getType_ressource(),
            'mode_reglement' => $tpagcp->getMode_reglement(),
            'mont_gcp_maj' => $tpagcp->getMont_gcp_maj(),
            'numero_bl' => $tpagcp->getNumero_bl(),
            'type_bl' => $tpagcp->getType_bl(),
            'reinjecter' => $tpagcp->getReinjecter(),
            'nbre_injection' => $tpagcp->getNbre_injection()

        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuTpagcp $tpagcp) {
        $data = array(
            'id_tpagcp' => $tpagcp->getId_tpagcp(),
            'code_compte' => $tpagcp->getCode_compte(),
            'code_membre' => $tpagcp->getCode_membre(),
            'mont_gcp' => $tpagcp->getMont_gcp(),
            'ntf' => $tpagcp->getNtf(),
            'mont_tranche' => $tpagcp->getMont_tranche(),
            'date_deb' => $tpagcp->getDate_deb(),
            'periode' => $tpagcp->getPeriode(),
            'date_fin' => $tpagcp->getDate_fin(),
            'mont_echu' => $tpagcp->getMont_echu(),
            'mont_echange' => $tpagcp->getMont_echange(),
            'mont_escompte' => $tpagcp->getMont_escompte(),
            'solde' => $tpagcp->getSolde(),
            'escomptable' => $tpagcp->getEscomptable(),
            'date_fin_tranche' => $tpagcp->getDate_fin_tranche(),
            'date_deb_tranche' => $tpagcp->getDate_deb_tranche(),
            'reste_ntf' => $tpagcp->getReste_ntf(),
            'escomptable' => $tpagcp->getEscomptable(),
            'type_ressource' => $tpagcp->getType_ressource(),
            'mode_reglement' => $tpagcp->getMode_reglement(),
            'mont_gcp_maj' => $tpagcp->getMont_gcp_maj(),
            'numero_bl' => $tpagcp->getNumero_bl(),
            'type_bl' => $tpagcp->getType_bl(),
            'reinjecter' => $tpagcp->getReinjecter(),
            'nbre_injection' => $tpagcp->getNbre_injection()
        );
        $this->getDbTable()->update($data, array('id_tpagcp = ?' => $tpagcp->getId_tpagcp()));
    }



    public function find($id_gcp,Application_Model_EuTpagcp $tpagcp) {
        $result = $this->getDbTable()->find($id_gcp);
        if (0 == count($result)) {
            return false;
        }else{
        $row = $result->current();
        $tpagcp->setId_tpagcp($row->id_tpagcp)
            ->setCode_compte($row->code_compte)
            ->setCode_membre($row->code_membre)
            ->setMont_gcp($row->mont_gcp)
            ->setNtf($row->ntf)
            ->setMont_tranche($row->mont_tranche)
            ->setDate_deb($row->date_deb)
            ->setPeriode($row->periode)
            ->setDate_fin($row->date_fin)
            ->setMont_echu($row->mont_echu)
            ->setMont_echange($row->mont_echange)
            ->setMont_escompte($row->mont_escompte)
            ->setDate_deb_tranche($row->date_deb_tranche)
            ->setDate_fin_tranche($row->date_fin_tranche)
            ->setSolde($row->solde)
            ->setEscomptable($row->escomptable)
            ->setReste_ntf($row->reste_ntf)
            ->setType_ressource($row->type_ressource)
            ->setMode_reglement($row->mode_reglement)
            ->setMont_gcp_maj($row->mont_gcp_maj)
            ->setNumero_bl($row->numero_bl)
            ->setType_bl($row->type_bl)
            ->setReinjecter($row->reinjecter)
            ->setNbre_injection($row->nbre_injection)
            ;
        return true;
        }
    }

    public function findByCategorieCompte($compte, $membre, Application_Model_EuTpagcp $tpagcp) {
        $select = $this->getDbTable()->select();
        $select->where('code_compte= ?', $compte)->where('code_membre = ?', $membre);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $tpagcp->setId_tpagcp($row->id_tpagcp)
                ->setCode_compte($row->code_compte)
                ->setCode_membre($row->code_membre)
                ->setMont_gcp($row->mont_gcp)
                ->setNtf($row->ntf)
                ->setMont_tranche($row->mont_tranche)
                ->setDate_deb($row->date_deb)
                ->setPeriode($row->periode)
                ->setDate_fin($row->date_fin)
                ->setMont_echu($row->mont_echu)
                ->setMont_echange($row->mont_echange)
                ->setMont_escompte($row->mont_escompte)
                ->setDate_deb_tranche($row->date_deb_tranche)
                ->setDate_fin_tranche($row->date_fin_tranche)
                ->setSolde($row->solde)
                ->setEscomptable($row->escomptable)
                ->setReste_ntf($row->reste_ntf)
                ->setType_ressource($row->type_ressource)
            ->setMode_reglement($row->mode_reglement)
            ->setMont_gcp_maj($row->mont_gcp_maj)
            ->setNumero_bl($row->numero_bl)
            ->setType_bl($row->type_bl)
            ->setReinjecter($row->reinjecter)
            ->setNbre_injection($row->nbre_injection)
            ;
        return true;
    }

    public function findSommeTpaGcp($comptes) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(solde) as total'));
        $select->where('id_tpagcp IN (?)', $comptes)
                ->where('solde > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            return $row['total'];
        } else {
            return 0;
        }
    }

    public function findSommeTpaGcpEchu($compte) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mont_echu) as total'));
        $select->where('code_compte = ?', $compte)
                ->where('solde > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            return $row['total'];
        } else {
            return 0;
        }
    }

    public function findSommeTrancheGcp($compte) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mont_tranche) as total'));
        $select->where('code_compte=?', $compte)
                ->where('solde > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            return $row['total'];
        } else {
            return 0;
        }
    }

    public function findSommeTrancheGcpByComptes($comptes) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('SUM(mont_tranche) as total'));
        $select->where('id_tpagcp IN (?)', $comptes)
                ->where('solde > ?', 0);
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) > 0) {
            $row = $result->current();
            return $row['total'];
        } else {
            return 0;
        }
    }

    public function findGcp($comptes) {
        $select = $this->getDbTable()->select();
        $select->where('id_tpagcp IN (?)', $comptes)
                ->where('solde > ?', 0)
                ->order('solde', 'DESC');
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuTpagcp();
            $entry->setId_tpagcp($row->id_tpagcp)
                    ->setCode_compte($row->code_compte)
                    ->setCode_membre($row->code_membre)
                    ->setMont_gcp($row->mont_gcp)
                    ->setNtf($row->ntf)
                    ->setMont_tranche($row->mont_tranche)
                    ->setDate_deb($row->date_deb)
                    ->setPeriode($row->periode)
                    ->setDate_fin($row->date_fin)
                    ->setMont_echu($row->mont_echu)
                    ->setMont_echange($row->mont_echange)
                    ->setMont_escompte($row->mont_escompte)
                    ->setDate_deb_tranche($row->date_deb_tranche)
                    ->setDate_fin_tranche($row->date_fin_tranche)
                    ->setSolde($row->solde)
                    ->setEscomptable($row->escomptable)
                    ->setReste_ntf($row->reste_ntf)
                    ->setType_ressource($row->type_ressource)
            ->setMode_reglement($row->mode_reglement)
            ->setMont_gcp_maj($row->mont_gcp_maj)
            ->setNumero_bl($row->numero_bl)
            ->setType_bl($row->type_bl)
            ->setReinjecter($row->reinjecter)
            ->setNbre_injection($row->nbre_injection)
            ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findGcpByComptes($comptes) {
        $select = $this->getDbTable()->select();
        $select->where('code_compte IN (?)', $comptes)
                ->where('solde > ?', 0)
                ->order('solde', 'DESC');
        $result = $this->getDbTable()->fetchAll($select);
        if (count($result) == 0) {
            return NULL;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuTpagcp();
            $entry->setId_tpagcp($row->id_tpagcp)
                    ->setCode_compte($row->code_compte)
                    ->setCode_membre($row->code_membre)
                    ->setMont_gcp($row->mont_gcp)
                    ->setNtf($row->ntf)
                    ->setMont_tranche($row->mont_tranche)
                    ->setDate_deb($row->date_deb)
                    ->setPeriode($row->periode)
                    ->setDate_fin($row->date_fin)
                    ->setMont_echu($row->mont_echu)
                    ->setMont_echange($row->mont_echange)
                    ->setMont_escompte($row->mont_escompte)
                    ->setDate_deb_tranche($row->date_deb_tranche)
                    ->setDate_fin_tranche($row->date_fin_tranche)
                    ->setSolde($row->solde)
                    ->setEscomptable($row->escomptable)
                    ->setReste_ntf($row->reste_ntf)
                    ->setType_ressource($row->type_ressource)
            ->setMode_reglement($row->mode_reglement)
            ->setMont_gcp_maj($row->mont_gcp_maj)
            ->setNumero_bl($row->numero_bl)
            ->setType_bl($row->type_bl)
            ->setReinjecter($row->reinjecter)
            ->setNbre_injection($row->nbre_injection)
            ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuTpagcp();
            $entry->setId_tpagcp($row->id_tpagcp)
                    ->setCode_compte($row->code_compte)
                    ->setCode_membre($row->code_membre)
                    ->setMont_gcp($row->mont_gcp)
                    ->setNtf($row->ntf)
                    ->setMont_tranche($row->mont_tranche)
                    ->setDate_deb($row->date_deb)
                    ->setDate_fin($row->date_fin)
                    ->setPeriode($row->periode)
                    ->setMont_echu($row->mont_echu)
                    ->setMont_echange($row->mont_echange)
                    ->setMont_escompte($row->mont_escompte)
                    ->setDate_deb_tranche($row->date_deb_tranche)
                    ->setDate_fin_tranche($row->date_fin_tranche)
                    ->setSolde($row->solde)
                    ->setEscomptable($row->escomptable)
                    ->setReste_ntf($row->reste_ntf)
                    ->setType_ressource($row->type_ressource)
            ->setMode_reglement($row->mode_reglement)
            ->setMont_gcp_maj($row->mont_gcp_maj)
            ->setNumero_bl($row->numero_bl)
            ->setType_bl($row->type_bl)
            ->setReinjecter($row->reinjecter)
            ->setNbre_injection($row->nbre_injection)
            ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_tpagcp) {
        $this->getDbTable()->delete(array('id_tpagcp = ?' => $id_tpagcp));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_tpagcp) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

}
