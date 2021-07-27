<?php  
 class Application_Model_EuProprietaireMapper {
       
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
            $this->setDbTable('Application_Model_DbTable_EuProprietaire');
        }
        return $this->_dbTable;
      }
     
      public function find($id_proprietaire, Application_Model_EuProprietaire $proprietaire) {
        $result = $this->getDbTable()->find($id_proprietaire);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $proprietaire->setId_proprietaire($row->id_proprietaire)
                     ->setCode_membre_pro($row->code_membre_pro)
                     ->setCode_membre_ag($row->code_membre_ag)
                     ->setDate_declaration($row->date_declaration)
                     ->setId_utilisateur($row->id_utilisateur)
                     ->setNbre_maison($row->nbre_maison);
    }
    
    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_proprietaire) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

	public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuProprietaire();
            $entry->setId_proprietaire($row->id_proprietaire)
                  ->setCode_membre_pro($row->code_membre_pro)
                  ->setCode_membre_ag($row->code_membre_ag)
                  ->setDate_declaration($row->date_declaration)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setNbre_maison($row->nbre_maison)
                  ;
            $entries[] = $entry;
        }
        return $entries;
    } 
	 
    public function findprop($code_membre) {
           $select = $this->getDbTable()->select();
           $select->from($this->getDbTable(), array('code_membre_pro'));
           $select->where('code_membre_pro LIKE ?', $code_membre);
		   $select->where('code_membre_ag LIKE ?', $code_membre_ag);
           $result = $this->getDbTable()->fetchAll($select);
		   $row = $result->current();
           return $row['code_membre_pro'];
    }
    
	 public function findpro($code_membre,$code_membre_ag) {
        $select = $this->getDbTable()->select();
        $select->where('code_membre_pro LIKE ?', $code_membre);
        $select->where('code_membre_ag LIKE ?',  $code_membre_ag);
        $results = $this->getDbTable()->fetchAll($select);
        if (count($results) > 0) {
            $row = $results->current();
            $pro = new Application_Model_EuProprietaire();
            $pro->setId_proprietaire($row->id_proprietaire)
                ->setCode_membre_pro($row->code_membre_pro)
                ->setCode_membre_ag($row->code_membre_ag)
                ->setDate_declaration($row->date_declaration)
                ->setId_utilisateur($row->id_utilisateur)
                ->setNbre_maison($row->nbre_maison);
            return $pro;
        } else {
            return NULL;
        }
    }
	
    public function findProprio($code_membre) {
        $table = new Application_Model_DbTable_EuProprietaire();
        $select = $table->select();
        $select->where('code_membre_pro LIKE ?', $code_membre);
        $result = $table->fetchAll($select);
        if (0 == count($result)) {
            return NULL;
        }
        $row = $result->current();
        $rappro = new Application_Model_EuProprietaire();
        $rappro->setId_proprietaire($row->id_proprietaire)
                ->setCode_membre_pro($row->code_membre_pro)
                ->setCode_membre_ag($row->code_membre_ag)
                ->setDate_declaration($row->date_declaration)
                ->setNbre_maison($row->nbre_maison)
                ->setId_utilisateur($row->id_utilisateur);
        return $rappro;
    }
	
    public function findnom($id_proprio) {
           $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
                  ->join('eu_membre', 'eu_membre.code_membre = eu_proprietaire.code_membre_pro')
                  ->where('eu_proprietaire.id_proprietaire = ?', $id_proprio); 
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['nom_membre'];
           
    }
    
    
    public function findprenom($id_proprio) {
           $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
                  ->join('eu_membre', 'eu_membre.code_membre = eu_proprietaire.code_membre_pro')
                  ->where('eu_proprietaire.id_proprietaire = ?', $id_proprio); 
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['prenom_membre'];
           
    }
    
    public function findfonction($id_proprio) {
           $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           $select->setIntegrityCheck(false)
                  ->join('eu_membre', 'eu_membre.code_membre = eu_proprietaire.code_membre_pro')
                  ->where('eu_proprietaire.id_proprietaire = ?',$id_proprio); 
           $result = $this->getDbTable()->fetchAll($select);
           $row = $result->current();
           return $row['profession_membre'];
           
    }
       
    
    public function save(Application_Model_EuProprietaire $proprietaire) {
        $data = array(
            'id_proprietaire' => $proprietaire->getId_proprietaire(),
            'code_membre_pro' => $proprietaire->getCode_membre_pro(),
            'code_membre_ag' => $proprietaire->getCode_membre_ag(),
            'date_declaration' => $proprietaire->getDate_declaration(),
            'id_utilisateur' => $proprietaire->getId_utilisateur(),
            'nbre_maison' => $proprietaire->getNbre_maison()
        );
        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuProprietaire $proprietaire) {
        $data = array(
            'id_proprietaire' => $proprietaire->getId_proprietaire(),
            'code_membre_pro' => $proprietaire->getCode_membre_pro(),
            'code_membre_ag' => $proprietaire->getCode_membre_ag(),
            'date_declaration' => $proprietaire->getDate_declaration(),
            'id_utilisateur' => $proprietaire->getId_utilisateur(),
            'nbre_maison' => $proprietaire->getNbre_maison()
        );
        $this->getDbTable()->update($data, array('id_proprietaire = ?' => $proprietaire->getId_proprietaire()));
    }
 
    
    public function delete($id_proprietaire) {
        $this->getDbTable()->delete(array('id_proprietaire = ?' => $id_proprietaire));
    } 
    
    
 }
?>
