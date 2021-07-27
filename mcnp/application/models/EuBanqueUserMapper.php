<?php

class Application_Model_EuBanqueUserMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuBanqueUser');
        }
        return $this->_dbTable;
    }

    public function find($id_banque_user, Application_Model_EuBanqueUser $banque_user) {
        $result = $this->getDbTable()->find($id_banque_user);
        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        $banque_user->setIdBanqueUser($row->id_banque_user)
 			   ->setCodeBanque($row->code_banque)
 			   ->setNomBanqueUser($row->nom_banque_user)
 			   ->setPrenomBanqueUser($row->prenom_banque_user)
 			   ->setLoginBanqueUser($row->login_banque_user)
 			   ->setPwdBanqueUser($row->pwd_banque_user)
 			   ->setActiver($row->activer)
 			   ->setPwdChanged($row->pwd_changed)
 		       ->setDateCreated($row->date_created)
 		       ->setIdUtilisateur($row->id_utilisateur)
 			   ->setRole($row->role)
               ->setCode_membre($row->code_membre)
                ;
    }
    
    public function fetchAll() {
        
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuBanqueUser();
 			$entry->setIdBanqueUser($row->id_banque_user)
 			   ->setCodeBanque($row->code_banque)
 			   ->setNomBanqueUser($row->nom_banque_user)
 			   ->setPrenomBanqueUser($row->prenom_banque_user)
 			   ->setLoginBanqueUser($row->login_banque_user)
 			   ->setPwdBanqueUser($row->pwd_banque_user)
 			   ->setActiver($row->activer)
 			   ->setPwdChanged($row->pwd_changed)
 		       ->setDateCreated($row->date_created)
 		       ->setIdUtilisateur($row->id_utilisateur)
 			   ->setRole($row->role)
               ->setCode_membre($row->code_membre)
               ;
            $entries[] = $entry;
        }
        return $entries;
        
    }

    public function save(Application_Model_EuBanqueUser $banque_user) {
        $data = array(
 				'code_banque' => $banque_user->getCodeBanque(),
 				'nom_banque_user' => $banque_user->getNomBanqueUser(),
 				'prenom_banque_user' => $banque_user->getPrenomBanqueUser(),
 				'login_banque_user' => $banque_user->getLoginBanqueUser(),
 				'pwd_banque_user' => $banque_user->getPwdBanqueUser(),
 				'activer' => $banque_user->getActiver(),
 				'pwd_changed' => $banque_user->getPwdChanged(),
 				'id_utilisateur' => $banque_user->getIdUtilisateur(),
 				'date_created' => $banque_user->getDateCreated(),
 				'role' => $banque_user->getRole(),
                'code_membre' => $banque_user->getCode_membre()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuBanqueUser $banque_user) {
        $data = array(
 				'id_banque_user' => $banque_user->getIdBanqueUser(),
 				'code_banque' => $banque_user->getCodeBanque(),
 				'nom_banque_user' => $banque_user->getNomBanqueUser(),
 				'prenom_banque_user' => $banque_user->getPrenomBanqueUser(),
 				'login_banque_user' => $banque_user->getLoginBanqueUser(),
 				'pwd_banque_user' => $banque_user->getPwdBanqueUser(),
 				'activer' => $banque_user->getActiver(),
 				'pwd_changed' => $banque_user->getPwdChanged(),
 				'id_utilisateur' => $banque_user->getIdUtilisateur(),
 				'date_created' => $banque_user->getDateCreated(),
 				'role' => $banque_user->getRole(),
                'code_membre' => $banque_user->getCode_membre()
        );
        $this->getDbTable()->update($data, array('id_banque_user = ?' => $banque_user->getIdBanqueUser()));
    }

    public function delete($id_banque_user) {
        $this->getDbTable()->delete(array('id_banque_user = ?' => $id_banque_user));
    }

    public function findConuter() {
        $select = $this->getDbTable()->select();
        $select->from($this->getDbTable(), array('MAX(id_banque_user) as count'));
        $result = $this->getDbTable()->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

	
    public function findById($id_banque_user) {
        $select = $this->getDbTable()->select();
        $select->where("id_banque_user = ? ", $id_banque_user); 
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
 			$entry = new Application_Model_EuBanqueUser();
 			$entry->setIdBanqueUser($row->id_banque_user)
 			   ->setCodeBanque($row->code_banque)
 			   ->setNomBanqueUser($row->nom_banque_user)
 			   ->setPrenomBanqueUser($row->prenom_banque_user)
 			   ->setLoginBanqueUser($row->login_banque_user)
 			   ->setPwdBanqueUser($row->pwd_banque_user)
 			   ->setActiver($row->activer)
 			   ->setPwdChanged($row->pwd_changed)
 		       ->setDateCreated($row->date_created)
 		       ->setIdUtilisateur($row->id_utilisateur)
 			   ->setRole($row->role)
               ->setCode_membre($row->code_membre)
               ;
             $entries[] = $entry;
        }
        return $entries;
    }



	
    public function findByBanque($code_banque = "") {
        $select = $this->getDbTable()->select();
        if($code_banque != ""){
        $select->where("code_banque = ? ", $code_banque); 
    }
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
 			$entry = new Application_Model_EuBanqueUser();
 			$entry->setIdBanqueUser($row->id_banque_user)
 			   ->setCodeBanque($row->code_banque)
 			   ->setNomBanqueUser($row->nom_banque_user)
 			   ->setPrenomBanqueUser($row->prenom_banque_user)
 			   ->setLoginBanqueUser($row->login_banque_user)
 			   ->setPwdBanqueUser($row->pwd_banque_user)
 			   ->setActiver($row->activer)
 			   ->setPwdChanged($row->pwd_changed)
 		       ->setDateCreated($row->date_created)
 		       ->setIdUtilisateur($row->id_utilisateur)
 			   ->setRole($row->role)
               ->setCode_membre($row->code_membre)
               ;
             $entries[] = $entry;
        }
        return $entries;
    }


	
    public function findByLogin($login_banque_user) {
        $select = $this->getDbTable()->select();
        $select->where("login_banque_user = ? ", $login_banque_user); 
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
 			$entry = new Application_Model_EuBanqueUser();
 			$entry->setIdBanqueUser($row->id_banque_user)
 			   ->setCodeBanque($row->code_banque)
 			   ->setNomBanqueUser($row->nom_banque_user)
 			   ->setPrenomBanqueUser($row->prenom_banque_user)
 			   ->setLoginBanqueUser($row->login_banque_user)
 			   ->setPwdBanqueUser($row->pwd_banque_user)
 			   ->setActiver($row->activer)
 			   ->setPwdChanged($row->pwd_changed)
 		       ->setDateCreated($row->date_created)
 		       ->setIdUtilisateur($row->id_utilisateur)
 			   ->setRole($row->role)
               ->setCode_membre($row->code_membre)
               ;
             $entries[] = $entry;
        }
        return $entries;
    }


 	
    public function findByLoginAndPassword($login_banque_user, $pwd_banque_user) {
        $select = $this->getDbTable()->select();
        $select->where("login_banque_user = ? ", $login_banque_user); 
        $select->where("pwd_banque_user = ? ", $pwd_banque_user); 
        $select->where("activer = ? ", 1); 
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
 			$entry = new Application_Model_EuBanqueUser();
 			$entry->setIdBanqueUser($row->id_banque_user)
 			   ->setCodeBanque($row->code_banque)
 			   ->setNomBanqueUser($row->nom_banque_user)
 			   ->setPrenomBanqueUser($row->prenom_banque_user)
 			   ->setLoginBanqueUser($row->login_banque_user)
 			   ->setPwdBanqueUser($row->pwd_banque_user)
 			   ->setActiver($row->activer)
 			   ->setPwdChanged($row->pwd_changed)
 		       ->setDateCreated($row->date_created)
 		       ->setIdUtilisateur($row->id_utilisateur)
 			   ->setRole($row->role)
               ->setCode_membre($row->code_membre)
               ;
             $entries[] = $entry;
        }
        return $entries;
    }

   
	




}
?>

