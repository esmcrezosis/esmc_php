<?php
class Application_Model_EuCommandeMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuCommande');
        }
        return $this->_dbTable;
    }
    public function find($code_commande, Application_Model_EuCommande $commande) {
        $result = $this->getDbTable()->find($code_commande);
        if (0 == count($result)) {
            return false;
        }
        $row = $result->current();
        $commande->setCode_commande($row->code_commande)
                 ->setDate_commande($row->date_commande)
                 ->setMontant_commande($row->montant_commande)
                 ->setCode_membre_acheteur($row->code_membre_acheteur)
                 ->setCode_membre_vendeur($row->code_membre_vendeur)
                 ->setQuartier_acheteur($row->quartier_acheteur)
                 ->setVille_acheteur($row->ville_acheteur)
                 ->setTel_acheteur($row->tel_acheteur)
                 ->setAdresse_livraison($row->adresse_livraison)
                 ->setCode_livraison($row->code_livraison)
                 ->setCode_confirmation($row->code_confirmation)
                 ->setMontant_livraison($row->montant_livraison)
				 ->setExecuter($row->executer)
                 ->setCode_zone($row->code_zone)
                 ->setId_pays($row->id_pays)
                 ->setId_region($row->id_region)
                 ->setId_prefecture($row->id_prefecture)
                 ->setCode_membre_livreur($row->code_membre_livreur)
                 ->setCode_membre_transitaire($row->code_membre_transitaire)
                 ->setCode_membre_transporteur($row->code_membre_transporteur)
                 ->setMode_livraison($row->mode_livraison)
                 ->setFrais_livraison($row->frais_livraison)
                 ->setFrais_transit($row->frais_transit)
                 ->setFrais_transport($row->frais_transport)
                 ->setDate_livraison($row->date_livraison)
                 ->setLivrer($row->livrer)
                 ->setType_recurrent($row->type_recurrent)
                 ->setPeriode_recurrent($row->periode_recurrent)
                 ->setType_bon($row->type_bon)
                      ;    
    }

    
    public function findclt($code_commande) {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('code_membre_acheteur'));
        $select->where('code_commande = ?', $code_commande);
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['code_membre_acheteur'];
    }
    
    public function findfournis($code_commande) {
        $commande = new Application_Model_DbTable_EuCommande();
        $select = $commande->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)        
               ->join('eu_proforma', 'eu_proforma.montant_livraison = eu_commande.montant_livraison')        
               ->where('eu_commande.code_commande = ?', $code_commande);
        $result = $commande->fetchAll($select);
        $row = $result->current();
        return $row['code_membre_acheteur_fournisseur'];
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCommande();
            $entry->setCode_commande($row->code_commande)
                 ->setDate_commande($row->date_commande)
                 ->setMontant_commande($row->montant_commande)
                 ->setCode_membre_acheteur($row->code_membre_acheteur)
                 ->setCode_membre_vendeur($row->code_membre_vendeur)
                 ->setQuartier_acheteur($row->quartier_acheteur)
                 ->setVille_acheteur($row->ville_acheteur)
                 ->setTel_acheteur($row->tel_acheteur)
                 ->setAdresse_livraison($row->adresse_livraison)
                 ->setCode_livraison($row->code_livraison)
                 ->setCode_confirmation($row->code_confirmation)
                 ->setMontant_livraison($row->montant_livraison)
                 ->setExecuter($row->executer)
                 ->setCode_zone($row->code_zone)
                 ->setId_pays($row->id_pays)
                 ->setId_region($row->id_region)
                 ->setId_prefecture($row->id_prefecture)
                 ->setCode_membre_livreur($row->code_membre_livreur)
                 ->setCode_membre_transitaire($row->code_membre_transitaire)
                 ->setCode_membre_transporteur($row->code_membre_transporteur)
                 ->setMode_livraison($row->mode_livraison)
                 ->setFrais_livraison($row->frais_livraison)
                 ->setFrais_transit($row->frais_transit)
                 ->setFrais_transport($row->frais_transport)
                 ->setDate_livraison($row->date_livraison)
                 ->setLivrer($row->livrer)
                 ->setType_recurrent($row->type_recurrent)
                 ->setPeriode_recurrent($row->periode_recurrent)
                 ->setType_bon($row->type_bon)
                      ;    
            $entries[] = $entry;
        }
        return $entries;
    }
	
    public function save(Application_Model_EuCommande $commande){
        $data = array(
            'code_commande' => $commande->getCode_commande(),
            'date_commande' => $commande->getDate_commande(),
            'montant_commande' => $commande->getMontant_commande(),
            'code_membre_acheteur' => $commande->getCode_membre_acheteur(),
            'code_membre_vendeur' => $commande->getCode_membre_vendeur(),
            'quartier_acheteur' => $commande->getQuartier_acheteur(),
            'ville_acheteur' => $commande->getVille_acheteur(),
            'tel_acheteur' => $commande->getTel_acheteur(),
            'adresse_livraison' => $commande->getAdresse_livraison(),
            'code_livraison' => $commande->getCode_livraison(),
            'code_confirmation' => $commande->getCode_confirmation(),
            'montant_livraison' => $commande->getMontant_livraison(),
            'executer' => $commande->getExecuter(), 
            'code_zone' => $commande->getCode_zone(),
            'id_pays' => $commande->getId_pays(),
            'id_region' => $commande->getId_region(),
            'id_prefecture' => $commande->getId_prefecture(),
            'code_membre_livreur' => $commande->getCode_membre_livreur(),
            'code_membre_transitaire' => $commande->getCode_membre_transitaire(),
            'code_membre_transporteur' => $commande->getCode_membre_transporteur(),
            'mode_livraison' => $commande->getMode_livraison(),
            'frais_livraison' => $commande->getFrais_livraison(),
            'frais_transit' => $commande->getFrais_transit(),
            'frais_transport' => $commande->getFrais_transport(),
            'date_livraison' => $commande->getDate_livraison(),
            'livrer' => $commande->getLivrer(),
            'type_recurrent' => $commande->getType_recurrent(),
            'periode_recurrent' => $commande->getPeriode_recurrent(),
            'type_bon' => $commande->getType_bon()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuCommande $commande) {
        $data = array(
            'code_commande' => $commande->getCode_commande(),
            'date_commande' => $commande->getDate_commande(),
            'montant_commande' => $commande->getMontant_commande(),
            'code_membre_acheteur' => $commande->getCode_membre_acheteur(),
            'code_membre_vendeur' => $commande->getCode_membre_vendeur(),
            'quartier_acheteur' => $commande->getQuartier_acheteur(),
            'ville_acheteur' => $commande->getVille_acheteur(),
            'tel_acheteur' => $commande->getTel_acheteur(),
            'adresse_livraison' => $commande->getAdresse_livraison(),
            'code_livraison' => $commande->getCode_livraison(),
            'code_confirmation' => $commande->getCode_confirmation(),
            'montant_livraison' => $commande->getMontant_livraison(),
            'executer' => $commande->getExecuter(), 
            'code_zone' => $commande->getCode_zone(),
            'id_pays' => $commande->getId_pays(),
            'id_region' => $commande->getId_region(),
            'id_prefecture' => $commande->getId_prefecture(),
            'code_membre_livreur' => $commande->getCode_membre_livreur(),
            'code_membre_transitaire' => $commande->getCode_membre_transitaire(),
            'code_membre_transporteur' => $commande->getCode_membre_transporteur(),
            'mode_livraison' => $commande->getMode_livraison(),
            'frais_livraison' => $commande->getFrais_livraison(),
            'frais_transit' => $commande->getFrais_transit(),
            'frais_transport' => $commande->getFrais_transport(),
            'date_livraison' => $commande->getDate_livraison(),
            'livrer' => $commande->getLivrer(),
            'type_recurrent' => $commande->getType_recurrent(),
            'periode_recurrent' => $commande->getPeriode_recurrent(),
            'type_bon' => $commande->getType_bon()
        );

        $this->getDbTable()->update($data, array('code_commande = ?' => $commande->getCode_commande()));
    }
    
    public function delete($code_commande) {
        $this->getDbTable()->delete(array('code_commande = ?' => $code_commande));
    }

    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(code_commande) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }




    /*public function fetchAllByCode($code_livraison) {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuCommande();
            $entry->setCode_commande($row->code_commande)
                 ->setDate_commande($row->date_commande)
                 ->setMontant_commande($row->montant_commande)
                 ->setCode_membre_acheteur($row->code_membre_acheteur)
                 ->setCode_membre_vendeur($row->code_membre_vendeur)
                 ->setQuartier_acheteur($row->quartier_acheteur)
                 ->setVille_acheteur($row->ville_acheteur)
                 ->setTel_acheteur($row->tel_acheteur)
                 ->setAdresse_livraison($row->adresse_livraison)
                 ->setCode_livraison($row->code_livraison)
                 ->setCode_confirmation($row->code_confirmation)
                 ->setMontant_livraison($row->montant_livraison)
                 ->setExecuter($row->executer)
                 ->setCode_zone($row->code_zone)
                 ->setId_pays($row->id_pays)
                 ->setId_region($row->id_region)
                 ->setId_prefecture($row->id_prefecture)
                 ->setCode_membre_livreur($row->code_membre_livreur)
                 ->setCode_membre_transitaire($row->code_membre_transitaire)
                 ->setCode_membre_transporteur($row->code_membre_transporteur)
                 ->setMode_livraison($row->mode_livraison)
                 ->setFrais_livraison($row->frais_livraison)
                 ->setFrais_transit($row->frais_transit)
                 ->setFrais_transport($row->frais_transport)
                 ->setDate_livraison($row->date_livraison)
                 ->setLivrer($row->livrer)
                 ->setType_recurrent($row->type_recurrent)
                 ->setPeriode_recurrent($row->periode_recurrent)
                 ->setType_bon($row->type_bon)
                      ;    
            $entries[] = $entry;
        }
        return $entries;
    }*/
    

          public function fetchAllByCodeConfirmation($code_confirmation){
              $select = $this->getDbTable()->select();
              $select->where("code_confirmation LIKE ? ", $code_confirmation);
              $select->limit(1);
              $result = $this->getDbTable()->fetchRow($select);
              $entries = array();
              if (0 == count($result)) {
                  return;
              }
              $row = $result;
              $entry = new Application_Model_EuCommande();
            $entry->setCode_commande($row->code_commande)
                 ->setDate_commande($row->date_commande)
                 ->setMontant_commande($row->montant_commande)
                 ->setCode_membre_acheteur($row->code_membre_acheteur)
                 ->setCode_membre_vendeur($row->code_membre_vendeur)
                 ->setQuartier_acheteur($row->quartier_acheteur)
                 ->setVille_acheteur($row->ville_acheteur)
                 ->setTel_acheteur($row->tel_acheteur)
                 ->setAdresse_livraison($row->adresse_livraison)
                 ->setCode_livraison($row->code_livraison)
                 ->setCode_confirmation($row->code_confirmation)
                 ->setMontant_livraison($row->montant_livraison)
                 ->setExecuter($row->executer)
                 ->setCode_zone($row->code_zone)
                 ->setId_pays($row->id_pays)
                 ->setId_region($row->id_region)
                 ->setId_prefecture($row->id_prefecture)
                 ->setCode_membre_livreur($row->code_membre_livreur)
                 ->setCode_membre_transitaire($row->code_membre_transitaire)
                 ->setCode_membre_transporteur($row->code_membre_transporteur)
                 ->setMode_livraison($row->mode_livraison)
                 ->setFrais_livraison($row->frais_livraison)
                 ->setFrais_transit($row->frais_transit)
                 ->setFrais_transport($row->frais_transport)
                 ->setDate_livraison($row->date_livraison)
                 ->setLivrer($row->livrer)
                 ->setType_recurrent($row->type_recurrent)
                 ->setPeriode_recurrent($row->periode_recurrent)
                 ->setType_bon($row->type_bon)
                      ;
                $entries = $entry;
              return $entries;
          }
    
    

          public function fetchAllByCodeLivraison($code_livraison){
              $select = $this->getDbTable()->select();
              $select->where("code_livraison LIKE ? ", $code_livraison);
              $select->limit(1);
              $result = $this->getDbTable()->fetchRow($select);
              $entries = array();
              if (0 == count($result)) {
                  return;
              }
              $row = $result;
              $entry = new Application_Model_EuCommande();
            $entry->setCode_commande($row->code_commande)
                 ->setDate_commande($row->date_commande)
                 ->setMontant_commande($row->montant_commande)
                 ->setCode_membre_acheteur($row->code_membre_acheteur)
                 ->setCode_membre_vendeur($row->code_membre_vendeur)
                 ->setQuartier_acheteur($row->quartier_acheteur)
                 ->setVille_acheteur($row->ville_acheteur)
                 ->setTel_acheteur($row->tel_acheteur)
                 ->setAdresse_livraison($row->adresse_livraison)
                 ->setCode_livraison($row->code_livraison)
                 ->setCode_confirmation($row->code_confirmation)
                 ->setMontant_livraison($row->montant_livraison)
                 ->setExecuter($row->executer)
                 ->setCode_zone($row->code_zone)
                 ->setId_pays($row->id_pays)
                 ->setId_region($row->id_region)
                 ->setId_prefecture($row->id_prefecture)
                 ->setCode_membre_livreur($row->code_membre_livreur)
                 ->setCode_membre_transitaire($row->code_membre_transitaire)
                 ->setCode_membre_transporteur($row->code_membre_transporteur)
                 ->setMode_livraison($row->mode_livraison)
                 ->setFrais_livraison($row->frais_livraison)
                 ->setFrais_transit($row->frais_transit)
                 ->setFrais_transport($row->frais_transport)
                 ->setDate_livraison($row->date_livraison)
                 ->setLivrer($row->livrer)
                 ->setType_recurrent($row->type_recurrent)
                 ->setPeriode_recurrent($row->periode_recurrent)
                 ->setType_bon($row->type_bon)
                      ;
                $entries = $entry;
              return $entries;
          }
    



}

