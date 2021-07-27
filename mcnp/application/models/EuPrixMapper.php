<?php

class Application_Model_EuPrixMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuPrix');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuPrix $prix) {
        $data = array(
            'id_value' => $prix->getId_value(),
            'prix_unitaire' => $prix->getPrix_unitaire(),
            'code_objet' => $prix->getCode_objet(),
            'boutique' => $prix->getBoutique(),
            'rayon' => $prix->getRayon(),
            'num_gamme' => $prix->getNum_gamme(),
            'creer_par' => $prix->getCreer_par(),
            'code_demand' => $prix->getCode_demand(),
            'caract_objet' => $prix->getCaract_objet(),
            'duree_vie' => $prix->getDuree_vie(),
            'membre_rayon' => $prix->getMembre_rayon()
        );
        $this->getDbTable()->insert($data);
    }

    public function findobjet($id_value) {

        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_objet'));
        $select->where('id_value = ?', $id_value);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_objet'];
    }

    public function findrayon($id_value) {

        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('rayon'));
        $select->where('id_value = ?', $id_value);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['rayon'];
    }

    public function findcaract($code, $rayon) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_value'));
        $select->where('code_objet = ?', $code);
        $select->where('rayon = ?', $rayon);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['id_value'];
    }

    public function controle($code, $boutique) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_value'));
        $select->where('code_objet = ?', $code);
        $select->where('boutique = ?', $boutique);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['id_value'];
    }

    public function findsub($code) {

        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_value'));
        $select->where('code_demand = ?', $code);
        $select->where('code_demand <> ?', '');
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['id_value'];
    }

    public function findbout($code_rayon) {
        $rayon = new Application_Model_DbTable_EuRayon;
        $select = $rayon->select();
        $select->from($rayon, array('proprietaire_rayon'));
        $select->where('code_rayon = ?', $code_rayon);
        $result = $rayon->fetchAll($select);
        $row = $result->current();
        return $row['proprietaire_rayon'];
    }

    public function findsub1($code, $id) {

        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_value'));
        $select->where('code_demand = ?', $code);
        $select->where('id_value != ?', $id);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['id_value'];
    }

    public function findsubvention($code, $id) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_value'));
        $select->where('code_demand = ?', $code);
        $select->where('id_value != ?', $id);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['id_value'];
    }

    public function update(Application_Model_EuPrix $prix) {
        $data = array(
            'id_value' => $prix->getId_value(),
            'prix_unitaire' => $prix->getPrix_unitaire(),
            'code_objet' => $prix->getCode_objet(),
            'boutique' => $prix->getBoutique(),
            'rayon' => $prix->getRayon(),
            'num_gamme' => $prix->getNum_gamme(),
            'creer_par' => $prix->getCreer_par(),
            'code_demand' => $prix->getCode_demand(),
            'caract_objet' => $prix->getCaract_objet(),
            'duree_vie' => $prix->getDuree_vie(),
            'membre_rayon' => $prix->getMembre_rayon()
        );
        $this->getDbTable()->update($data, array('id_value = ?' => $prix->getId_value()));
    }

    public function find($id_value, Application_Model_EuPrix $prix) {
        $result = $this->getDbTable()->find($id_value);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $prix->setId_value($row->id_value)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setCode_objet($row->code_objet)
                ->setBoutique($row->boutique)
                ->setRayon($row->rayon)
                ->setNum_gamme($row->num_gamme)
                ->setCreer_par($row->creer_par)
                ->setCode_demand($row->code_demand)
                ->setCaract_objet($row->caract_objet)
                ->setDuree_vie($row->duree_vie)
                ->setMembre_rayon($row->membre_rayon);
        return true;
    }

    public function findByProduitRayon($produit, $boutique, $rayon) {
        $select = $this->getDbTable()->select();
        $select->where('code_objet = ?', $produit);
        if ($rayon != '' && $rayon != NULL) {
            $select->where('rayon = ?', $rayon);
        }
        if ($boutique != '' && $boutique != NULL) {
            $select->where('boutique = ?', $boutique);
        }
        $result = $this->getDbTable()->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $prix = new Application_Model_EuPrix();
        $prix->setId_value($row->id_value)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setCode_objet($row->code_objet)
                ->setDuree_vie($row->duree_vie)
                ->setBoutique($row->boutique)
                ->setRayon($row->rayon)
                ->setNum_gamme($row->num_gamme)
                ->setCreer_par($row->creer_par)
                ->setCode_demand($row->code_demand)
                ->setCaract_objet($row->caract_objet)
                ->setMembre_rayon($row->membre_rayon);
        return $prix;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuPrix();
            $entry->setId_value($row->id_value);
            $entry->setPrix_unitaire($row->prix_unitaire);
            $entry->setDuree_vie($row->duree_vie);
            $entry->setCode_objet($row->code_objet);
            $entry->setBoutique($row->boutique);
            $entry->setRayon($row->rayon);
            $entry->setNum_gamme($row->num_gamme);
            $entry->setCreer_par($row->creer_par);
            $entry->setCaract_objet($row->caract_objet);
            $entry->setMembre_rayon($row->membre_rayon);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_value) {
        $this->getDbTable()->delete(array('id_value = ?' => $id_value));
    }

}

