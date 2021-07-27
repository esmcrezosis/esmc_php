<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuBnpSqmaxMapper
 *
 * @author user
 */
class Application_Model_EuRepresentationMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuRepresentation');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuRepresentation $Representation) {
        $data = array(
            'code_membre_morale' =>$Representation->getCode_membre_morale(),
            'code_membre' => $Representation->getCode_membre(),
            'titre' => $Representation->getTitre(),
			'date_creation' => $Representation->getDate_creation(),
			'id_utilisateur' => $Representation->getId_utilisateur(),
			'etat' => $Representation->getEtat()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuRepresentation $Representation) {
        $data = array(
            'code_membre_morale' =>$Representation->getCode_membre_morale(),
            'code_membre' => $Representation->getCode_membre(),
            'titre' => $Representation->getTitre(),
			'date_creation' => $Representation->getDate_creation(),
			'id_utilisateur' => $Representation->getId_utilisateur(),
			'etat' => $Representation->getEtat()
        );
        $this->getDbTable()->update($data, array('code_membre_morale = ?' => $Representation->getCode_membre_morale(), 'code_membre = ?' => $Representation->getCode_membre()));
    }

    public function find($code_membre,$code_membre_morale, Application_Model_EuRepresentation $EuRepresentation) {
        $result = $this->getDbTable()->find($code_membre,$code_membre_morale);
        if (0 == count($result)) {
           return false;
        }
        $row = $result->current();
        $EuRepresentation->setCode_membre_morale($row->code_membre_morale)
                         ->setCode_membre($row->code_membre)
                         ->setTitre($row->titre)
						 ->setDate_creation($row->date_creation)
						 ->setId_utilisateur($row->id_utilisateur)
						 ->setEtat($row->etat)
						 ;
		return true;				 
    }


    public function findbyrep($code_membre_morale) { 
		   $select = $this->getDbTable()->select();
	       $select->where('code_membre_morale LIKE ?', $code_membre_morale)
                  ->where('titre LIKE ?','Representant')
			      ->where('etat LIKE ?','inside');
           $results = $this->getDbTable()->fetchAll($select);
		   if (count($results) > 0) {
		      $row = $results->current();
              $representation = new Application_Model_EuRepresentation();
              $representation->setCode_membre_morale($row->code_membre_morale)
                             ->setCode_membre($row->code_membre)
                             ->setTitre($row->titre)
						     ->setDate_creation($row->date_creation)
						     ->setId_utilisateur($row->id_utilisateur)
						     ->setEtat($row->etat);
              return $representation; 
		   } else {
              return false;
           }
	
	}

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuRepresentation();
            $entry->setCode_membre_morale($row->code_membre_morale)
                  ->setCode_membre($row->code_membre)
                  ->setTitre($row->titre)
				  ->setDate_creation($row->date_creation)
				  ->setId_utilisateur($row->id_utilisateur)
				  ->setEtat($row->etat)
				 ;
            $entries[] = $entry;
        }
        return $entries;
    }

	 /*public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_rep) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }*/

    public function delete($code_membre_morale, $code_membre) {
        $this->getDbTable()->delete(array('code_membre_morale = ?' => $code_membre_morale, 'code_membre = ?' => $code_membre));
    }

    public function fetchAllByMembreMorale($code_membre_morale) {
           $select = $this->getDbTable()->select();
           $select->where('code_membre_morale LIKE ?', $code_membre_morale);
           $select->order(array('etat ASC'));
           $results = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($results as $row) {
            $entry = new Application_Model_EuRepresentation();
            $entry->setCode_membre_morale($row->code_membre_morale)
                  ->setCode_membre($row->code_membre)
                  ->setTitre($row->titre)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setEtat($row->etat)
                 ;
            $entries[] = $entry;
        }
        return $entries;
    }


    public function fetchAllByMembreMorale2($code_membre_morale) {
           $select = $this->getDbTable()->select();
           $select->where('code_membre_morale LIKE ?', $code_membre_morale);
           $select->where('etat LIKE ?','outside');
           $select->order(array('date_creation ASC'));
           $results = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($results as $row) {
            $entry = new Application_Model_EuRepresentation();
            $entry->setCode_membre_morale($row->code_membre_morale)
                  ->setCode_membre($row->code_membre)
                  ->setTitre($row->titre)
                  ->setDate_creation($row->date_creation)
                  ->setId_utilisateur($row->id_utilisateur)
                  ->setEtat($row->etat)
                 ;
            $entries[] = $entry;
        }
        return $entries;
    }



}

?>
