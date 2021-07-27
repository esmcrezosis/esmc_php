<?php

class Application_Model_EuEscompteMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuAncienEscompte');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuAncienEscompte $escompte) {
        $data = array(
            'id_escompte' => $escompte->getId_escompte(),
            'code_compte' => $escompte->getCode_compte(),
            'code_membre' => $escompte->getCode_membre(),
            'code_membre_benef' => $escompte->getCode_membre_benef(),
            'montant' => $escompte->getMontant(),
            'ntf' => $escompte->getNtf(),
            'reste_ntf' => $escompte->getReste_ntf(),
            'mont_tranche' => $escompte->getMont_tranche(),
            'date_deb' => $escompte->getDate_deb(),
            'periode' => $escompte->getPeriode(),
            'date_fin' => $escompte->getDate_fin(),
            'mont_echu' => $escompte->getMont_echu(),
            'mont_echu_transferer' => $escompte->getMont_echu_transferer(),
            'date_fin_tranche' => $escompte->getDate_fin_tranche(),
            'date_deb_tranche' => $escompte->getDate_deb_tranche(),
            'solde' => $escompte->getSolde(),
            'date_escompte' => $escompte->getDate_escompte(),
            'id_echange' => $escompte->getId_echange()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuAncienEscompte $escompte) {
        $data = array(
            'id_escompte' => $escompte->getId_escompte(),
            'code_compte' => $escompte->getCode_compte(),
            'code_membre' => $escompte->getCode_membre(),
            'code_membre_benef' => $escompte->getCode_membre_benef(),
            'montant' => $escompte->getMontant(),
            'ntf' => $escompte->getNtf(),
            'mont_tranche' => $escompte->getMont_tranche(),
            'date_deb' => $escompte->getDate_deb(),
            'periode' => $escompte->getPeriode(),
            'date_fin' => $escompte->getDate_fin(),
            'mont_echu' => $escompte->getMont_echu(),
            'mont_echu_transferer' => $escompte->getMont_echu_transferer(),
            'date_fin_tranche' => $escompte->getDate_fin_tranche(),
            'date_deb_tranche' => $escompte->getDate_deb_tranche(),
            'reste_ntf' => $escompte->getReste_ntf(),
            'solde' => $escompte->getSolde(),
            'date_escompte' => $escompte->getDate_escompte(),
            'id_echange' => $escompte->getId_echange()
        );
        $this->getDbTable()->update($data, array('id_escompte = ?' => $escompte->getId_escompte()));
    }

    public function getLastInsertId() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_escompte) as id'));
        $row = $this->getDbTable()->fetchRow($select);
        return $row->id;
    }

    public function find($id_escompte, Application_Model_EuAncienEscompte $escompte) {
        $result = $this->getDbTable()->find($id_escompte);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $escompte->setId_escompte($row->id_escompte)
                ->setCode_compte($row->code_compte)
                ->setCode_membre($row->code_membre)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMontant($row->montant)
                ->setPeriode($row->periode)
                ->setNtf($row->ntf)
                ->setMont_tranche($row->mont_tranche)
                ->setDate_deb($row->date_deb)
                ->setDate_fin($row->date_fin)
                ->setMont_echu($row->mont_echu)
                ->setDate_deb_tranche($row->date_deb_tranche)
                ->setDate_fin_tranche($row->date_fin_tranche)
                ->setReste_ntf($row->reste_ntf)
                ->setSolde($row->solde)
                ->setDate_escompte($row->date_escompte)
                ->setId_echange($row->id_echange)
                ->setMont_echu_transferer($row->mont_echu_transferer);
        return true;
    }

    public function findByCategorieCompte($compte, $categorie, Application_Model_EuAncienEscompte $escompte) {
        $select = $this->getDbTable()->select();
        $select->where('code_compte= ?', $compte)->where('cat_compte = ?', $categorie);
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $escompte->setId_escompte($row->id_escompte)
                ->setCode_compte($row->code_compte)
                ->setCode_membre($row->code_membre)
                ->setCode_membre_benef($row->code_membre_benef)
                ->setMontant($row->montant)
                ->setPeriode($row->periode)
                ->setNtf($row->ntf)
                ->setMont_tranche($row->mont_tranche)
                ->setDate_deb($row->date_deb)
                ->setDate_fin($row->date_fin)
                ->setMont_echu($row->mont_echu)
                ->setDate_deb_tranche($row->date_deb_tranche)
                ->setDate_fin_tranche($row->date_fin_tranche)
                ->setReste_ntf($row->reste_ntf)
                ->setSolde($row->solde)
                ->setDate_escompte($row->date_escompte)
                ->setId_echange($row->id_echange)
                ->setMont_echu_transferer($row->mont_echu_transferer);
        return true;
    }

    public function findEscompte($compte) {
        $table = new Application_Model_DbTable_EuAncienEscompte();
        $select = $table->select();
        $select->where('code_compte=?', $compte);
        $result = $table->fetchAll($select);
        if (count($result) == 0) {
            return false;
        }
        $entries = array();
        foreach ($result as $row) {
            $entry = new Application_Model_EuAncienEscompte();
            $entry->setId_escompte($row->id_escompte)
                    ->setCode_compte($row->code_compte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_benef($row->code_membre_benef)
                    ->setMontant($row->montant)
                    ->setPeriode($row->periode)
                    ->setNtf($row->ntf)
                    ->setMont_tranche($row->mont_tranche)
                    ->setDate_deb($row->date_deb)
                    ->setDate_fin($row->date_fin)
                    ->setMont_echu($row->mont_echu)
                    ->setMont_echu_transferer($row->mont_echu_transferer)
                    ->setDate_deb_tranche($row->date_deb_tranche)
                    ->setDate_fin_tranche($row->date_fin_tranche)
                    ->setReste_ntf($row->reste_ntf)
                    ->setSolde($row->solde)
                    ->setDate_escompte($row->date_escompte)
                    ->setId_echange($row->id_echange);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuAncienEscompte();
            $entry->setId_escompte($row->id_escompte)
                    ->setCode_compte($row->code_compte)
                    ->setCode_membre($row->code_membre)
                    ->setCode_membre_benef($row->code_membre_benef)
                    ->setMontant($row->montant)
                    ->setPeriode($row->periode)
                    ->setNtf($row->ntf)
                    ->setMont_tranche($row->mont_tranche)
                    ->setDate_deb($row->date_deb)
                    ->setDate_fin($row->date_fin)
                    ->setMont_echu($row->mont_echu)
                    ->setMont_echu_transferer($row->mont_echu_transferer)
                    ->setDate_deb_tranche($row->date_deb_tranche)
                    ->setDate_fin_tranche($row->date_fin_tranche)
                    ->setReste_ntf($row->reste_ntf)
                    ->setSolde($row->solde)
                    ->setDate_escompte($row->date_escompte)
                    ->setId_echange($row->id_echange);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_escompte) {
        $this->getDbTable()->delete(array('id_escompte = ?' => $id_escompte));
    }

}
