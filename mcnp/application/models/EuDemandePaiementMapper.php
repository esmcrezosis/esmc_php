<?php
class Application_Model_EuDemandePaiementMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuDemandePaiement');
        }
        return $this->_dbTable;
    }


    public function find($id_demande_paiement, Application_Model_EuDemandePaiement $demande_paiement) {
        $result = $this->getDbTable()->find($id_demande_paiement);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $demande_paiement->setId_demande_paiement($row->id_demande_paiement)
                  ->setMontant_demande_paiement($row->montant_demande_paiement)
                  ->setDate_demande_paiement($row->date_demande_paiement)
                  ->setCode_membre_employeur($row->code_membre_employeur)
                  ->setPayer($row->payer)
                  ->setDate_debut($row->date_debut)
                  ->setDate_fin($row->date_fin)
                  ->setType_demande($row->type_demande)
                  ->setNumero_demande_paiement($row->numero_demande_paiement)
                  ->setLibelle_type_demande($row->libelle_type_demande)
                  ;
    }


    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuDemandePaiement();
            $entry->setId_demande_paiement($row->id_demande_paiement)
                  ->setMontant_demande_paiement($row->montant_demande_paiement)
                  ->setDate_demande_paiement($row->date_demande_paiement)
                  ->setCode_membre_employeur($row->code_membre_employeur)
                  ->setPayer($row->payer)
                  ->setDate_debut($row->date_debut)
                  ->setDate_fin($row->date_fin)
                  ->setType_demande($row->type_demande)
                  ->setNumero_demande_paiement($row->numero_demande_paiement)
                  ->setLibelle_type_demande($row->libelle_type_demande)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    }
	  

    public function save(Application_Model_EuDemandePaiement $demande_paiement) {
        $data = array(
			      'id_demande_paiement' => $demande_paiement->getId_demande_paiement(),
            'code_membre_employeur' => $demande_paiement->getCode_membre_employeur(),
            'montant_demande_paiement' => $demande_paiement->getMontant_demande_paiement(),
            'date_demande_paiement' => $demande_paiement->getDate_demande_paiement(),
            'payer' => $demande_paiement->getPayer(),
            'date_debut' => $demande_paiement->getDate_debut(),
            'date_fin' => $demande_paiement->getDate_fin(),
            'type_demande' => $demande_paiement->getType_demande(),
            'numero_demande_paiement' => $demande_paiement->getNumero_demande_paiement(),
            'libelle_type_demande' => $demande_paiement->getLibelle_type_demande()
        );

        $this->getDbTable()->insert($data);
    }
    
	public function findConuter() {
        $tabela = new Application_Model_DbTable_EuDemandePaiement();
        $select = $tabela->select();
        $select->from('eu_demande_paiement', array('MAX(id_demande_paiement) as count'));
        $result = $tabela->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }
	
	
	
    public function update(Application_Model_EuDemandePaiement $demande_paiement) {
        $data = array(
          'id_demande_paiement' => $demande_paiement->getId_demande_paiement(),
          'code_membre_employeur' => $demande_paiement->getCode_membre_employeur(),
          'montant_demande_paiement' => $demande_paiement->getMontant_demande_paiement(),
          'date_demande_paiement' => $demande_paiement->getDate_demande_paiement(),
          'payer' => $demande_paiement->getPayer(),
          'date_debut' => $demande_paiement->getDate_debut(),
          'date_fin' => $demande_paiement->getDate_fin(),
            'type_demande' => $demande_paiement->getType_demande(),
            'numero_demande_paiement' => $demande_paiement->getNumero_demande_paiement(),
            'libelle_type_demande' => $demande_paiement->getLibelle_type_demande()
        );
        $this->getDbTable()->update($data, array('id_demande_paiement = ?' => $demande_paiement->getId_demande_paiement()));
    }


    public function delete($id_demande_paiement) {
        $this->getDbTable()->delete(array('id_demande_paiement = ?' => $id_demande_paiement));
    }


    public function fetchAllByEmployeur($code_membre_employeur) {
       $select = $this->getDbTable()->select();
       $select->where('code_membre_employeur = ?', $code_membre_employeur);
	   $select->order('id_demande_paiement DESC');
       $resultSet = $this->getDbTable()->fetchAll($select);
       $entries = array();
       foreach ($resultSet as $row) {
         $entry = new Application_Model_EuDemandePaiement();
         $entry->setId_demande_paiement($row->id_demande_paiement)
               ->setMontant_demande_paiement($row->montant_demande_paiement)
               ->setDate_demande_paiement($row->date_demande_paiement)
               ->setCode_membre_employeur($row->code_membre_employeur)
               ->setPayer($row->payer)
               ->setDate_debut($row->date_debut)
               ->setDate_fin($row->date_fin)
               ->setType_demande($row->type_demande)
                  ->setNumero_demande_paiement($row->numero_demande_paiement)
                  ->setLibelle_type_demande($row->libelle_type_demande)
                     ;
         $entries[] = $entry;
       }
       return $entries;
    }


public function fetchAllByEmploye($code_membre_employe) {
       $select = $this->getDbTable()->select();
       $select->where('id_demande_paiement IN (SELECT id_demande_paiement FROM eu_paiement WHERE code_membre_employe = ?)',$code_membre_employe);
       $select->order('id_demande_paiement DESC');
       $resultSet = $this->getDbTable()->fetchAll($select);
       $entries = array();
       foreach ($resultSet as $row) {
         $entry = new Application_Model_EuDemandePaiement();
         $entry->setId_demande_paiement($row->id_demande_paiement)
               ->setMontant_demande_paiement($row->montant_demande_paiement)
               ->setDate_demande_paiement($row->date_demande_paiement)
               ->setCode_membre_employeur($row->code_membre_employeur)
               ->setPayer($row->payer)
               ->setDate_debut($row->date_debut)
               ->setDate_fin($row->date_fin)
               ->setType_demande($row->type_demande)
                  ->setNumero_demande_paiement($row->numero_demande_paiement)
                  ->setLibelle_type_demande($row->libelle_type_demande)
                     ;
         $entries[] = $entry;
       }
       return $entries;
    }
///////////////////////////////////////////////////////////////

   /*
    public function fetchAllByEmployeur($code_membre_employeur) {
       $select = $this->getDbTable()->select();
       $select->where('code_membre_employeur = ?', $code_membre_employeur);
     $select->order('id_demande_paiement DESC');
       $resultSet = $this->getDbTable()->fetchAll($select);
       $entries = array();
       foreach ($resultSet as $row) {
         $entry = new Application_Model_EuDemandePaiement();
         $entry->setId_demande_paiement($row->id_demande_paiement)
               ->setMontant_demande_paiement($row->montant_demande_paiement)
               ->setDate_demande_paiement($row->date_demande_paiement)
               ->setCode_membre_employeur($row->code_membre_employeur)
               ->setPayer($row->payer)
               ->setDate_debut($row->date_debut)
               ->setDate_fin($row->date_fin)
               ->setType_demande($row->type_demande)
                  ->setNumero_demande_paiement($row->numero_demande_paiement)
                  ->setLibelle_type_demande($row->libelle_type_demande)
                     ;
         $entries[] = $entry;
       }
       return $entries;
    }*/



    public function fetchAllByQuizaine($code_membre_employeur, $debut, $fin, $type_demande) {
       $select = $this->getDbTable()->select();

       if($code_membre_employeur != "") {
         $select->where("code_membre_employeur LIKE '%".$code_membre_employeur."%'");
       }
       if($debut != "") {
         $select->where("date_debut LIKE '".$debut."'");
       }
       if($fin != "") {
         $select->where("date_fin LIKE '".$fin."'");
       }
       if($type_demande != "") {
         $select->where("type_demande LIKE '%".$type_demande."%'");
       }
       $select->order('id_demande_paiement DESC');
       $result = $this->getDbTable()->fetchRow($select);
       $entries = array();
	   
       if (0 == count($result))  {
          return NULL;
       }
	   
       $row = $result;
       $entry = new Application_Model_EuDemandePaiement();
       $entry->setId_demande_paiement($row->id_demande_paiement)
             ->setMontant_demande_paiement($row->montant_demande_paiement)
             ->setDate_demande_paiement($row->date_demande_paiement)
             ->setCode_membre_employeur($row->code_membre_employeur)
             ->setPayer($row->payer)
             ->setDate_debut($row->date_debut)
             ->setDate_fin($row->date_fin)
             ->setType_demande($row->type_demande)
                  ->setNumero_demande_paiement($row->numero_demande_paiement)
                  ->setLibelle_type_demande($row->libelle_type_demande)
                  ;
       $entries = $entry;
       return $entries;
    }





public function fetchAllPayer($payer) {
       $select = $this->getDbTable()->select();
       $select->where('payer = ?', 0);
       $select->order('id_demande_paiement DESC');
       $resultSet = $this->getDbTable()->fetchAll($select);
       $entries = array();
       foreach ($resultSet as $row) {
         $entry = new Application_Model_EuDemandePaiement();
         $entry->setId_demande_paiement($row->id_demande_paiement)
               ->setMontant_demande_paiement($row->montant_demande_paiement)
               ->setDate_demande_paiement($row->date_demande_paiement)
               ->setCode_membre_employeur($row->code_membre_employeur)
               ->setPayer($row->payer)
               ->setDate_debut($row->date_debut)
               ->setDate_fin($row->date_fin)
               ->setType_demande($row->type_demande)
                  ->setNumero_demande_paiement($row->numero_demande_paiement)
                  ->setLibelle_type_demande($row->libelle_type_demande)
                     ;
         $entries[] = $entry;
       }
       return $entries;
    }


          public function fetchAllByNumero_demande_paiement($numero_demande_paiement){
              $select = $this->getDbTable()->select();
              $select->where("numero_demande_paiement LIKE ? ", $numero_demande_paiement);
              $select->limit(1);
              $result = $this->getDbTable()->fetchRow($select);
              $entries = array();
              if (0 == count($result)) {
                  return;
              }
              $row = $result;
              $entry = new Application_Model_EuDemandePaiement();
         $entry->setId_demande_paiement($row->id_demande_paiement)
               ->setMontant_demande_paiement($row->montant_demande_paiement)
               ->setDate_demande_paiement($row->date_demande_paiement)
               ->setCode_membre_employeur($row->code_membre_employeur)
               ->setPayer($row->payer)
               ->setDate_debut($row->date_debut)
               ->setDate_fin($row->date_fin)
               ->setType_demande($row->type_demande)
                  ->setNumero_demande_paiement($row->numero_demande_paiement)
                  ->setLibelle_type_demande($row->libelle_type_demande)
                     ;
                $entries = $entry;
              return $entries;
          }
    
 

}

?>
