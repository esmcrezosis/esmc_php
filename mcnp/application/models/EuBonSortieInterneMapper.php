<?php
class Application_Model_EuBonSortieInterneMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBonSortieInterne');
        }
        return $this->_dbTable;
    }
    
    public function find($id_bon_sortie_interne, Application_Model_EuBonSortieInterne $article) {
        $result = $this->getDbTable()->find($id_bon_sortie_interne);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $article->setId_bon_sortie_interne($row->id_bon_sortie_interne)
                    ->setReference_bon_sortie_interne($row->reference_bon_sortie_interne)
	                ->setDate_bon_sortie_interne($row->date_bon_sortie_interne)
	                ->setNature_article($row->nature_article)
	                ->setObjet_bon_sortie($row->objet_bon_sortie)
	                ->setQuantite_article($row->quantite_article)
	                ->setPrix_unitaire($row->prix_unitaire)
	                ->setMontant_total_bon_sortie_interne($row->montant_total_bon_sortie_interne)
	                ->setImputation($row->imputation)
	                ->setNom_beneficiaire($row->nom_beneficiaire)
	                ->setNo_vehicule($row->no_vehicule)
	                ->setDate_livraison($row->date_livraison)
	                ->setRejet($row->rejet)
                    ->setCode_membre($row->code_membre)
                    ->setValider_up($row->valider_up)
                    ->setvalider_down($row->valider_down)
                    ;    
    }
/*
    id_bon_sortie_interne
    reference_bon_sortie_interne
    date_bon_sortie_interne
    nature_article
    objet_bon_sortie
    quantite_article
    prix_unitaire
    montant_total_bon_sortie_interne
    imputation
    nom_beneficiaire
    no_vehicule
    date_livraison
    rejet
    code_membre
    valider_up
    valider_down
    PRIMARY KEY (`id_bon_sortie_interne`)
*/
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBonSortieInterne();
            $entry->setId_bon_sortie_interne($row->id_bon_sortie_interne)
                    ->setReference_bon_sortie_interne($row->reference_bon_sortie_interne)
                    ->setDate_bon_sortie_interne($row->date_bon_sortie_interne)
                    ->setNature_article($row->nature_article)
                    ->setObjet_bon_sortie($row->objet_bon_sortie)
                    ->setQuantite_article($row->quantite_article)
                    ->setPrix_unitaire($row->prix_unitaire)
                    ->setMontant_total_bon_sortie_interne($row->montant_total_bon_sortie_interne)
                    ->setImputation($row->imputation)
                    ->setNom_beneficiaire($row->nom_beneficiaire)
                    ->setNo_vehicule($row->no_vehicule)
                    ->setDate_livraison($row->date_livraison)
                    ->setRejet($row->rejet)
                    ->setCode_membre($row->code_membre)
                    ->setValider_up($row->valider_up)
                    ->setValider_down($row->valider_down)
                    ;
            $entries[] = $entry;
        }
        return $entries;
    }
    public function save(Application_Model_EuBonSortieInterne $article){
        $data = array(
            'id_bon_sortie_interne' => $article->getId_bon_sortie_interne(),
            'reference_bon_sortie_interne' => $article->getReference_bon_sortie_interne(),
            'date_bon_sortie_interne' => $article->getDate_bon_sortie_interne(),
            'nature_article' => $article->getNature_article(),
            'objet_bon_sortie' => $article->getObjet_bon_sortie(),
            'quantite_article' => $article->getQuantite_article(),
            'prix_unitaire' => $article->getPrix_unitaire(),
            'montant_total_bon_sortie_interne' => $article->getMontant_total_bon_sortie_interne(),
            'imputation' => $article->getImputation(),
            'nom_beneficiaire' => $article->getNom_beneficiaire(),
            'no_vehicule' => $article->getNo_vehicule(),
            'date_livraison' => $article->getDate_livraison(),
            'rejet' => $article->getRejet(),
            'code_membre' => $article->getCode_membre(),
            'valider_up' => $article->getValider_up(),
            'valider_down' => $article->getValider_down()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBonSortieInterne $article) {
        $data = array(
            'id_bon_sortie_interne' => $article->getId_bon_sortie_interne(),
            'reference_bon_sortie_interne' => $article->getReference_bon_sortie_interne(),
            'date_bon_sortie_interne' => $article->getDate_bon_sortie_interne(),
            'nature_article' => $article->getNature_article(),
            'objet_bon_sortie' => $article->getObjet_bon_sortie(),
            'quantite_article' => $article->getQuantite_article(),
            'prix_unitaire' => $article->getPrix_unitaire(),
            'montant_total_bon_sortie_interne' => $article->getMontant_total_bon_sortie_interne(),
            'imputation' => $article->getImputation(),
            'nom_beneficiaire' => $article->getNom_beneficiaire(),
            'no_vehicule' => $article->getNo_vehicule(),
            'date_livraison' => $article->getDate_livraison(),
            'rejet' => $article->getRejet(),
            'code_membre' => $article->getCode_membre(),
            'valider_up' => $article->getValider_up(),
            'valider_down' => $article->getValider_down()
        );
        $this->getDbTable()->update($data, array('id_bon_sortie_interne = ?' => $article->getId_bon_sortie_interne()));
    }
    
    public function delete($id_bon_sortie_interne,$id_bon_sortie_interne) {
        $this->getDbTable()->delete(array('id_bon_sortie_interne = ?' => $id_bon_sortie_interne));
    }

    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_bon_sortie_interne) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
}
?>