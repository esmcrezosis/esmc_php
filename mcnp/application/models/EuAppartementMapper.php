<?php
     
class Application_Model_EuAppartementMapper {     

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
            $this->setDbTable('Application_Model_DbTable_EuAppartement');
       }
          return $this->_dbTable;
       }
       
       public function find($id_appartement, Application_Model_EuAppartement $appartement) {
        $result = $this->getDbTable()->find($id_appartement);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $appartement->setId_appartement($row->id_appartement)
                    ->setId_maison($row->id_maison)
                    ->setType_appartement($row->type_appartement)
                    ->setWc_douche_interne($row->wc_douche_interne)
                    ->setTerasse($row->terasse)
                    ->setCuisine($row->cuisine)
                    ->setGarage($row->garage) 
                    ->setPrix_location($row->prix_location)
                    ->setStatut($row->statut) 
                    ->setNb_piece($row->nb_piece)
                    ->setDesc_appart($row->desc_appart)
                    ->setDate_enregistrement($row->date_enregistrement)
                    ->setHeure_enregistrement($row->heure_enregistrement)
                    ->setId_utilisateur($row->id_utilisateur);
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
          $entry = new Application_Model_EuAppartement();
          $entry->setId_appartement($row->id_appartement)
                  ->setId_maison($row->id_maison)
                  ->setType_appartement($row->type_appartement)
                  ->setWc_douche_interne($row->wc_douche_interne)
                  ->setTerasse($row->terasse)
                  ->setCuisine($row->cuisine)
                  ->setGarage($row->garage) 
                  ->setPrix_location($row->prix_location)
                  ->setStatut($row->statut)
                  ->setNb_piece($row->nb_piece)
                  ->setDesc_appart($row->desc_appart)
                  ->setDate_enregistrement($row->date_enregistrement)
                  ->setHeure_enregistrement($row->heure_enregistrement)
                  ->setId_utilisateur($row->id_utilisateur);  
                  
                  $entries[] = $entry;
        }
        return $entries;
    }


    public function save(Application_Model_EuAppartement $appartement) {
        $data = array(
          'id_appartement' => $appartement->getId_appartement(),
          'id_maison' => $appartement->getId_maison(),  
          'type_appartement' => $appartement->getType_appartement(),
          'wc_douche_interne' => $appartement->getWc_douche_interne(),
          'terasse' => $appartement->getTerasse(),
          'cuisine' => $appartement->getCuisine(),
          'garage' => $appartement->getGarage(),
          'prix_location' => $appartement->getPrix_location(),
          'statut' => $appartement->getStatut(),
          'nb_piece' => $appartement->getNb_piece(),
          'desc_appart' => $appartement->getDesc_appart(),
          'date_enregistrement' => $appartement->getDate_enregistrement(),
          'heure_enregistrement' => $appartement->getHeure_enregistrement(),  
          'id_utilisateur' => $appartement->getId_utilisateur() 
        );
        $this->getDbTable()->insert($data);
    }


    public function update(Application_Model_EuAppartement $appartement) {
        $data = array(
          'id_appartement' => $appartement->getId_appartement(),
          'id_maison' => $appartement->getId_maison(),  
          'type_appartement' => $appartement->getType_appartement(),
          'wc_douche_interne' => $appartement->getWc_douche_interne(),
          'terasse' => $appartement->getTerasse(),
          'cuisine' => $appartement->getCuisine(),
          'garage' => $appartement->getGarage(),
          'prix_location' => $appartement->getPrix_location(),
          'statut' => $appartement->getStatut(),
          'nb_piece' => $appartement->getNb_piece(),
          'desc_appart' => $appartement->getDesc_appart(),
          'date_enregistrement' => $appartement->getDate_enregistrement(),
          'heure_enregistrement' => $appartement->getHeure_enregistrement(),  
          'id_utilisateur' => $appartement->getId_utilisateur() 
        );
        $this->getDbTable()->update($data, array('id_appartement = ?' => $appartement->getId_appartement()));
    }
    
     public function findid_maison($code_membre) {
            $maison= new Application_Model_DbTable_EuMaison;
            $select = $maison->select();
            $select->from($maison, array('id_maison'));
            $select->where('code_membre LIKE ?', $code_membre);
            $result = $maison->fetchAll($select);
            $row = $result->current();
            return $row['id_maison'];
    }
    
    
    public function delete($id_appartement) {
        $this->getDbTable()->delete(array('id_appartement = ?' => $id_appartement));
    }


}
?>
