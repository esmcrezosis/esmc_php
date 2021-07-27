<?php

class Application_Model_EuDetailPropositionMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDetailProposition');
        }
        return $this->_dbTable;
    }

    public function find($id_detail_proposition, Application_Model_EuDetailProposition $detail_proposition) {
        $result = $this->getDbTable()->find($id_detail_proposition);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $detail_proposition->setId_detail_proposition($row->id_detail_proposition)
                ->setId_proposition($row->id_proposition)
                ->setLibelle_produit($row->libelle_produit)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setQuantite($row->quantite)
                ->setType_produit($row->type_produit)
                ->setUnite_mesure($row->unite_mesure)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setAppartenance($row->appartenance)
                ->setMdv($row->mdv);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailProposition();
            $entry->setId_detail_proposition($row->id_detail_proposition)
                    ->setId_proposition($row->id_proposition)
					->setLibelle_produit($row->libelle_produit)
					->setPrix_unitaire($row->prix_unitaire)
					->setQuantite($row->quantite)
					->setType_produit($row->type_produit)
					->setUnite_mesure($row->unite_mesure)
					->setCode_membre_morale($row->code_membre_morale)
                ->setAppartenance($row->appartenance)
					->setMdv($row->mdv);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_detail_proposition) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuDetailProposition $detail_proposition) {
        $data = array(
            'id_detail_proposition' => $detail_proposition->getId_detail_proposition(),
            'id_proposition' => $detail_proposition->getId_proposition(),
            'libelle_produit' => $detail_proposition->getLibelle_produit(),
            'prix_unitaire' => $detail_proposition->getPrix_unitaire(),
            'quantite' => $detail_proposition->getQuantite(),
            'type_produit' => $detail_proposition->getType_produit(),
            'unite_mesure' => $detail_proposition->getUnite_mesure(),
            'code_membre_morale' => $detail_proposition->getCode_membre_morale(),
            'appartenance' => $detail_proposition->getAppartenance(),
            'mdv' => $detail_proposition->getMdv()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuDetailProposition $detail_proposition) {
        $data = array(
            'id_detail_proposition' => $detail_proposition->getId_detail_proposition(),
            'id_proposition' => $detail_proposition->getId_proposition(),
            'libelle_produit' => $detail_proposition->getLibelle_produit(),
            'prix_unitaire' => $detail_proposition->getPrix_unitaire(),
            'quantite' => $detail_proposition->getQuantite(),
            'type_produit' => $detail_proposition->getType_produit(),
            'unite_mesure' => $detail_proposition->getUnite_mesure(),
            'code_membre_morale' => $detail_proposition->getCode_membre_morale(),
            'appartenance' => $detail_proposition->getAppartenance(),
            'mdv' => $detail_proposition->getMdv()
        );
        $this->getDbTable()->update($data, array('id_detail_proposition = ?' => $detail_proposition->getId_detail_proposition()));
    }

    public function delete($id_detail_proposition) {
        $this->getDbTable()->delete(array('id_detail_proposition = ?' => $id_detail_proposition));
    }


    public function fetchAll2($id_proposition) {
        $select = $this->getDbTable()->select();
		$select->where("id_proposition = ? ", $id_proposition);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDetailProposition();
            $entry->setId_detail_proposition($row->id_detail_proposition)
                    ->setId_proposition($row->id_proposition)
					->setLibelle_produit($row->libelle_produit)
					->setPrix_unitaire($row->prix_unitaire)
					->setQuantite($row->quantite)
					->setType_produit($row->type_produit)
					->setUnite_mesure($row->unite_mesure)
					->setCode_membre_morale($row->code_membre_morale)
                ->setAppartenance($row->appartenance)
					->setMdv($row->mdv);
            $entries[] = $entry;
        }
        return $entries;
    }
    

}


?>
