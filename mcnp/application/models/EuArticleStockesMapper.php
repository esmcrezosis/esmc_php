<?php

class Application_Model_EuArticleStockesMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuArticleStockes');
        }
        return $this->_dbTable;
    }

    public function find($id_article_stockes, Application_Model_EuArticleStockes $article_stockes) {
        $result = $this->getDbTable()->find($id_article_stockes);
        if (count($result) == 0) {
            return false;
        }
        $row = $result->current();
        $article_stockes->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                ->setReference($row->reference)
                ->setDesignation($row->designation)
                ->setPrix($row->prix)
                ->setDate_enregistrement($row->date_enregistrement)
                ->setPublier($row->publier)
                ->setVendu($row->vendu)
                ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                ->setArticle_stockes_categorie($row->article_stockes_categorie)
                ->setQuantite($row->quantite)
				->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                  ->setCode_barre($row->code_barre)
                  ->setReference($row->reference)
                  ->setDesignation($row->designation)
                  ->setPrix($row->prix)
                  ->setDate_enregistrement($row->date_enregistrement)
                  ->setPublier($row->publier)
                  ->setVendu($row->vendu)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setCategorie($row->categorie)
                  ->setType($row->type)
                  ->setRemise($row->remise)
                  ->setImageArticle($row->imageArticle)
                  ->setArticle_stockes_categorie($row->article_stockes_categorie)
                  ->setQuantite($row->quantite)
				  ->setQte_stock($row->qte_stock)
				  ->setQte_vendu($row->qte_vendu)
				  ->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_article_stockes) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

    public function save(Application_Model_EuArticleStockes $article_stockes) {
        $data = array(
            'id_article_stockes' => $article_stockes->getId_article_stockes(),
            'code_barre' => $article_stockes->getCode_barre(),
            'reference' => $article_stockes->getReference(),
            'designation' => $article_stockes->getDesignation(),
            'prix' => $article_stockes->getPrix(),
            'date_enregistrement' => $article_stockes->getDate_enregistrement(),
            'publier' => $article_stockes->getPublier(),
            'vendu' => $article_stockes->getVendu(),
            'categorie' => $article_stockes->getCategorie(),
            'type' => $article_stockes->getType(),
            'imageArticle' => $article_stockes->getImageArticle(),
            'code_membre_morale' => $article_stockes->getCode_membre_morale(),
            'remise' => $article_stockes->getRemise(),
            'quantite' => $article_stockes->getQuantite(),
			'qte_stock' => $article_stockes->getQte_stock(),
			'qte_vendu' => $article_stockes->getQte_vendu(),
			'qte_solde' => $article_stockes->getQte_solde(),
            'article_stockes_categorie' => $article_stockes->getArticle_stockes_categorie()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuArticleStockes $article_stockes) {
        $data = array(
            'id_article_stockes' => $article_stockes->getId_article_stockes(),
            'code_barre' => $article_stockes->getCode_barre(),
            'reference' => $article_stockes->getReference(),
            'designation' => $article_stockes->getDesignation(),
            'prix' => $article_stockes->getPrix(),
            'date_enregistrement' => $article_stockes->getDate_enregistrement(),
            'publier' => $article_stockes->getPublier(),
            'vendu' => $article_stockes->getVendu(),
            'categorie' => $article_stockes->getCategorie(),
            'type' => $article_stockes->getType(),
            'imageArticle' => $article_stockes->getImageArticle(),
            'code_membre_morale' => $article_stockes->getCode_membre_morale(),
            'remise' => $article_stockes->getRemise(),
            'quantite' => $article_stockes->getQuantite(),
			'qte_stock' => $article_stockes->getQte_stock(),
			'qte_vendu' => $article_stockes->getQte_vendu(),
			'qte_solde' => $article_stockes->getQte_solde(),
            'article_stockes_categorie' => $article_stockes->getArticle_stockes_categorie()
        );
        $this->getDbTable()->update($data, array('id_article_stockes = ?' => $article_stockes->getId_article_stockes()));
    }

    public function delete($id_article_stockes) {
        $this->getDbTable()->delete(array('id_article_stockes = ?' => $id_article_stockes));
    }


    public function fetchAll2($code_membre_morale) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre_morale = ? ", $code_membre_morale);
        $select->where("vendu = ? ", 0);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAllByVendeur1($code_membre_morale) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre_morale = ? ", $code_membre_morale);
        //$select->where("vendu = ? ", 0);
        $select->where("publier = ? ", 1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function found($code_membre_morale) {
        $select = $this->getDbTable()->select();
        $select->where("code_membre_morale = ? ", $code_membre_morale);
        $select->where("vendu = ? ",1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }
    
    
    



    public function fetchAll4($id_filiere) {
           $articlestockes = new Application_Model_DbTable_EuArticleStockes();
           $select = $articlestockes->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
                  ->join('eu_membre_morale', 'eu_membre_morale.code_membre_morale = eu_article_stockes.code_membre_morale')
                  ->where('eu_membre_morale.id_filiere = ? ', $id_filiere)
                  ->where('eu_article_stockes.vendu = ? ', 0)
                  ->where('eu_article_stockes.publier = ? ', 1);
           $resultSet = $articlestockes->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
            }


    public function fetchAllByCategorie($categorie = 0, $type = "") {
           $articlestockes = new Application_Model_DbTable_EuArticleStockes();
           $select = $articlestockes->select();
           if($categorie > 0){
           $select->where('categorie = ? ', $categorie);
           }
           if($type != ""){
           $select->where('type LIKE ? ', $type);
           }
           $select->where('vendu = ? ', 0);
           $select->where('publier = ? ', 1);
           $resultSet = $articlestockes->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
            }

    public function fetchAllByCategorieTypeImage($categorie = 0, $type = "", $image = 0) {
           $articlestockes = new Application_Model_DbTable_EuArticleStockes();
           $select = $articlestockes->select();
           if($categorie > 0){
           $select->where('categorie = ? ', $categorie);
           }
           if($type != ""){
           $select->where('type LIKE ? ', $type);
           }
           if($image > 0){
           $select->where('imageArticle IS NOT NULL');
           }
           $select->where('vendu = ? ', 0);
           $select->where('publier = ? ', 1);
        $select->order(array('categorie ASC', 'designation ASC'));
           $resultSet = $articlestockes->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
            }

    
    public function fectchByCodebarre($code_barre) {
        $select = $this->getDbTable()->select();
        $select->where("code_barre = ? ", $code_barre);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
           return NULL;
        }
        $row = $resultSet->current();
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            
            return $entry;
    }

    

    public function fetchAllByReference($code_tegc = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_article_stockes', 'code_barre', 'date_enregistrement', 'categorie', 'article_stockes_categorie', 'type', 'designation', 'prix', 'publier', 'reference', 'code_membre_morale', 'vendu', 'imageArticle', 'remise', 'qte_stock', 'qte_vendu', 'qte_solde', 'COUNT(reference) as counter'));
        if($code_tegc != "") {
           $select->where("categorie = ? ", $code_tegc);
        }
        //$select->where("vendu = ? ", 0);
		$select->where("qte_stock is not null");
        $select->group("reference");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                  ->setCode_barre($row->code_barre)
                  ->setReference($row->reference)
                  ->setDesignation($row->designation)
                  ->setPrix($row->prix)
                  ->setDate_enregistrement($row->date_enregistrement)
                  ->setPublier($row->publier)
                  ->setVendu($row->counter)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setCategorie($row->categorie)
                  ->setType($row->type)
                  ->setRemise($row->remise)
                  ->setImageArticle($row->imageArticle)
                  ->setArticle_stockes_categorie($row->article_stockes_categorie)
                  //->setQuantite($row->quantite)
				  ->setQte_stock($row->qte_stock)
				  ->setQte_vendu($row->qte_vendu)
				  ->setQte_solde($row->qte_solde);
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function fetchAllByVendu($code_tegc = "") {
        $select = $this->getDbTable()->select();
        if($code_tegc != "") {
           $select->where("categorie = ? ", $code_tegc);
        }
        $select->where("vendu = ? ",1);
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                  ->setCode_barre($row->code_barre)
                  ->setReference($row->reference)
                  ->setDesignation($row->designation)
                  ->setPrix($row->prix)
                  ->setDate_enregistrement($row->date_enregistrement)
                  ->setPublier($row->publier)
                  ->setVendu($row->vendu)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setCategorie($row->categorie)
                  ->setType($row->type)
                  ->setRemise($row->remise)
                  ->setImageArticle($row->imageArticle)
                  ->setArticle_stockes_categorie($row->article_stockes_categorie)
                  ->setQuantite($row->quantite)
			      ->setQte_stock($row->qte_stock)
				  ->setQte_vendu($row->qte_vendu)
				  ->setQte_solde($row->qte_solde);
            $entries[] = $entry;
        }
        return $entries;
    }



    public function fetchAllByDesignation($reference) {
        $select = $this->getDbTable()->select();
        $select->where("reference LIKE '".$reference."' ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }

    
    public function fetchAllByVendeur($code_membre_morale) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_article_stockes', 'code_barre', 'date_enregistrement', 'categorie', 'article_stockes_categorie', 'type', 'designation', 'prix', 'publier', 'reference', 'code_membre_morale', 'vendu', 'imageArticle', 'remise','qte_stock', 'qte_vendu', 'qte_solde', 'COUNT(reference) as counter'));
        $select->where("code_membre_morale = ? ", $code_membre_morale);
        //$select->where("vendu = ? ", 0);
        $select->where("publier = ? ", 1);
        $select->group("reference");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->counter)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    //->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }




    
    public function fectchByReference($reference) {
        $select = $this->getDbTable()->select();
        $select->where("reference = ? ", $reference);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
           return NULL;
        }
        $row = $resultSet->current();
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                ->setCode_barre($row->code_barre)
                    ->setReference($row->reference)
                    ->setDesignation($row->designation)
                    ->setPrix($row->prix)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setPublier($row->publier)
                    ->setVendu($row->vendu)
                    ->setCode_membre_morale($row->code_membre_morale)
                ->setCategorie($row->categorie)
                ->setType($row->type)
                    ->setRemise($row->remise)
                ->setImageArticle($row->imageArticle)
                    ->setArticle_stockes_categorie($row->article_stockes_categorie)
                    ->setQuantite($row->quantite)
					->setQte_stock($row->qte_stock)
				->setQte_vendu($row->qte_vendu)
				->setQte_solde($row->qte_solde)
                ;
            
            return $entry;
    }



    
    public function fetchAllByVendeurCategorie($code_membre_morale = "", $categorie = "") {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('id_article_stockes', 'code_barre', 'date_enregistrement', 'categorie', 'article_stockes_categorie', 'type', 'designation', 'prix', 'publier', 'reference', 'code_membre_morale', 'vendu', 'imageArticle', 'remise','qte_stock', 'qte_vendu', 'qte_solde', 'COUNT(reference) as counter'));
        if($code_membre_morale != "") {
           $select->where("code_membre_morale = ? ", $code_membre_morale);
        }
        if($categorie != "") {
           $select->where("categorie = ? ", $categorie);
        }
		$select->where("qte_stock is not null");
        $select->where("vendu = ? ", 0);
        $select->where("publier = ? ", 1);
        $select->group("reference");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuArticleStockes();
            $entry->setId_article_stockes($row->id_article_stockes)
                  ->setCode_barre($row->code_barre)
                  ->setReference($row->reference)
                  ->setDesignation($row->designation)
                  ->setPrix($row->prix)
                  ->setDate_enregistrement($row->date_enregistrement)
                  ->setPublier($row->publier)
                  ->setVendu($row->counter)
                  ->setCode_membre_morale($row->code_membre_morale)
                  ->setCategorie($row->categorie)
                  ->setType($row->type)
                  ->setRemise($row->remise)
                  ->setImageArticle($row->imageArticle)
                    //->setQuantite($row->quantite)
                  ->setArticle_stockes_categorie($row->article_stockes_categorie)
			      ->setQte_stock($row->qte_stock)
				  ->setQte_vendu($row->qte_vendu)
				  ->setQte_solde($row->qte_solde)
                ;
            $entries[] = $entry;
        }
        return $entries;
    }



}


?>
