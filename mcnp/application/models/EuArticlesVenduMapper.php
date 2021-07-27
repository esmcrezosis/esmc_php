<?php

class Application_Model_EuArticlesVenduMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuArticlesVendu');
        }
        return $this->_dbTable;
    }

    public function find($code_barre, Application_Model_EuArticlesVendu $articles_vendu) {
        $result = $this->getDbTable()->find($code_barre);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $articles_vendu->setCode_barre($row->code_barre)
                ->setReference($row->reference)
                ->setDate_vente($row->date_vente)
                ->setCode_membre_acheteur($row->code_membre_acheteur)
                ->setCode_membre_vendeur($row->code_membre_vendeur)
                ->setId_article_vendu($row->id_article_vendu)
                ->setDesignation($row->designation)
                ->setQuantite($row->quantite)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setBon_id($row->bon_id)
                ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticlesVendu();
            $entry->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDate_vente($row->date_vente)
                    ->setCode_membre_acheteur($row->code_membre_acheteur)
                    ->setCode_membre_vendeur($row->code_membre_vendeur)
                ->setId_article_vendu($row->id_article_vendu)
                ->setDesignation($row->designation)
                ->setQuantite($row->quantite)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setBon_id($row->bon_id)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_barre) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuArticlesVendu $articles_vendu) {
        $data = array(
            'code_barre' => $articles_vendu->getCode_barre(),
            'reference' => $articles_vendu->getReference(),
            'date_vente' => $articles_vendu->getDate_vente(),
            'code_membre_acheteur' => $articles_vendu->getCode_membre_acheteur(),
            'code_membre_vendeur' => $articles_vendu->getCode_membre_vendeur(),
            'id_article_vendu' => $articles_vendu->getId_article_vendu(),
            'designation' => $articles_vendu->getDesignation(),
            'quantite' => $articles_vendu->getQuantite(),
            'prix_unitaire' => $articles_vendu->getPrix_unitaire(),
            'bon_id' => $articles_vendu->getBon_id()

        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuArticlesVendu $articles_vendu) {
        $data = array(
            'code_barre' => $articles_vendu->getCode_barre(),
            'reference' => $articles_vendu->getReference(),
            'date_vente' => $articles_vendu->getDate_vente(),
            'code_membre_acheteur' => $articles_vendu->getCode_membre_acheteur(),
            'code_membre_vendeur' => $articles_vendu->getCode_membre_vendeur(),
            'id_article_vendu' => $articles_vendu->getId_article_vendu(),
            'designation' => $articles_vendu->getDesignation(),
            'quantite' => $articles_vendu->getQuantite(),
            'prix_unitaire' => $articles_vendu->getPrix_unitaire(),
            'bon_id' => $articles_vendu->getBon_id()
        );
        $this->getDbTable()->update($data, array('code_barre = ?' => $articles_vendu->getCode_barre()));
    }

    public function delete($code_barre) {
        $this->getDbTable()->delete(array('code_barre = ?' => $code_barre));
    }


    public function fetchAll2($code_membre_vendeur) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre_vendeur = ? ", $code_membre_vendeur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticlesVendu();
            $entry->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDate_vente($row->date_vente)
                    ->setCode_membre_acheteur($row->code_membre_acheteur)
                    ->setCode_membre_vendeur($row->code_membre_vendeur)
                ->setId_article_vendu($row->id_article_vendu)
                ->setDesignation($row->designation)
                ->setQuantite($row->quantite)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setBon_id($row->bon_id)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll3($code_membre_acheteur) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre_acheteur = ? ", $code_membre_acheteur);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticlesVendu();
            $entry->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDate_vente($row->date_vente)
                    ->setCode_membre_acheteur($row->code_membre_acheteur)
                    ->setCode_membre_vendeur($row->code_membre_vendeur)
                ->setId_article_vendu($row->id_article_vendu)
                ->setDesignation($row->designation)
                ->setQuantite($row->quantite)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setBon_id($row->bon_id)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByBonDistributeur($bon_id, $code_membre_vendeur = "") {
        $select = $this->getDbTable()->select();
        $select->where("bon_id = ? ", $bon_id);
        if($code_membre_vendeur != ""){
        $select->where("code_membre_vendeur = ? ", $code_membre_vendeur);
        }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticlesVendu();
            $entry->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDate_vente($row->date_vente)
                    ->setCode_membre_acheteur($row->code_membre_acheteur)
                    ->setCode_membre_vendeur($row->code_membre_vendeur)
                ->setId_article_vendu($row->id_article_vendu)
                ->setDesignation($row->designation)
                ->setQuantite($row->quantite)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setBon_id($row->bon_id)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }






    public function fetchAllByMemeDistributeur() {
        $select = $this->getDbTable()->select();
            $select->from(array('eu_articles_vendu'));
        $select->where("eu_articles_vendu.code_membre_acheteur = eu_articles_vendu.code_membre_vendeur");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticlesVendu();
            $entry->setCode_barre($row->code_barre)
                  ->setReference($row->reference)
                    ->setDate_vente($row->date_vente)
                  ->setCode_membre_acheteur($row->code_membre_acheteur)
                    ->setCode_membre_vendeur($row->code_membre_vendeur)
                ->setId_article_vendu($row->id_article_vendu)
                ->setDesignation($row->designation)
                ->setQuantite($row->quantite)
                ->setPrix_unitaire($row->prix_unitaire)
                ->setBon_id($row->bon_id)
        ;
            $entries[] = $entry;
        }
        return $entries;
    }




        public function fetchAllByMemeRepresentant() {
            $select = $this->getDbTable()->select();
                $select->from(array('eu_articles_vendu'));
            $select->where("eu_articles_vendu.code_membre_acheteur IN (SELECT eu_representation.code_membre FROM eu_representation WHERE eu_representation.code_membre_morale = eu_articles_vendu.code_membre_vendeur)");
            $resultSet = $this->getDbTable()->fetchAll($select);
            $entries = array();
            foreach ($resultSet as $row) {
                $entry = new Application_Model_EuArticlesVendu();
                $entry->setCode_barre($row->code_barre)
                      ->setReference($row->reference)
                        ->setDate_vente($row->date_vente)
                      ->setCode_membre_acheteur($row->code_membre_acheteur)
                        ->setCode_membre_vendeur($row->code_membre_vendeur)
                    ->setId_article_vendu($row->id_article_vendu)
                    ->setDesignation($row->designation)
                    ->setQuantite($row->quantite)
                    ->setPrix_unitaire($row->prix_unitaire)
                    ->setBon_id($row->bon_id)
            ;
                $entries[] = $entry;
            }
            return $entries;
        }






}


?>
