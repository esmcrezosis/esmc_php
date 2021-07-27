<?php

class Application_Model_EuUserMapper {

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
            $this->setDbTable('Application_Model_DbTable_EuUser');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_EuUser $user) {
        $data = array(
            'id_user' => $user->getId_user(),
            'login' => $user->getLogin(),
            'pwd' => $user->getPwd(),
            'descr' => $user->getDescr(),
            'ulock' => $user->getUlock(),
            'ch_pwd_flog' => $user->getCh_pwd_flog(),
            'usergroup' => $user->getUsergroup(),
            'num_membre' => $user->getNum_membre(),
            'secteur' => $user->getSecteur(),
            'agence' => $user->getAgence(),
            'zone' => $user->getZone(),
            'num_gac_filiere' => $user->getNum_gac_filiere(),
            'code_acteur' => $user->getCode_acteur(),
            'nom_user' => $user->getNom_user(),
            'prenom_user' => $user->getPrenom_user(),
            'question_secrete' => $user->getQuestion_secrete(),
            'reponse' => $user->getReponse()
        );

        $this->getDbTable()->insert($data);
    }

    public function update(Application_Model_EuUser $user) {
        $data = array(
            'id_user' => $user->getId_user(),
            'login' => $user->getLogin(),
            'pwd' => $user->getPwd(),
            'descr' => $user->getDescr(),
            'ulock' => $user->getUlock(),
            'ch_pwd_flog' => $user->getCh_pwd_flog(),
            'usergroup' => $user->getUsergroup(),
            'connecte' => $user->getConnecte(),
            'num_membre' => $user->getNum_membre(),
            'secteur' => $user->getSecteur(),
            'agence' => $user->getAgence(),
            'zone' => $user->getZone(),
            'num_gac_filiere' => $user->getNum_gac_filiere(),
            'code_acteur' => $user->getCode_acteur(),
            'nom_user' => $user->getNom_user(),
            'prenom_user' => $user->getPrenom_user(),
            'question_secrete' => $user->getQuestion_secrete(),
            'reponse' => $user->getReponse()
        );

        $this->getDbTable()->update($data, array('id_user = ?' => $user->getId_user()));
    }

    public function find($id_user, Application_Model_EuUser $user) {

        $result = $this->getDbTable()->find($id_user);
        $row = $result->current();
        $user->setId_user($row->id_user);
        $user->setLogin($row->login);
        $user->setPwd($row->pwd);
        $user->setDescr($row->descr);
        $user->setUlock($row->ulock);
        $user->setCh_pwd_flog($row->ch_pwd_flog);
        $user->setUsergroup($row->usergroup);
        $user->setNum_membre($row->num_membre);
        $user->setSecteur($row->secteur);
        $user->setAgence($row->agence);
        $user->setZone($row->zone);
        $user->setNum_gac_filiere($row->num_gac_filiere);
        $user->setCode_acteur($row->code_acteur);
        $user->setNom_user($row->nom_user);
        $user->setPrenom_user($row->prenom_user);
        $user->setQuestion_secrete($row->question_secrete);
        $user->setReponse($row->reponse);
    }

    public function findLogin($login) {
        $select = $this->getDbTable()->select();
        $select->where('login=?', $login);
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $row = $resultSet->current();
        $user = new Application_Model_EuUser();
        $user->setId_user($row->id_user);
        $user->setLogin($row->login);
        $user->setPwd($row->pwd);
        $user->setDescr($row->descr);
        $user->setUlock($row->ulock);
        $user->setCh_pwd_flog($row->ch_pwd_flog);
        $user->setUsergroup($row->usergroup);
        $user->setNum_membre($row->num_membre);
        $user->setSecteur($row->secteur);
        $user->setAgence($row->agence);
        $user->setZone($row->zone);
        $user->setNum_gac_filiere($row->num_gac_filiere);
        $user->setCode_acteur($row->code_acteur);
        $user->setNom_user($row->nom_user);
        $user->setPrenom_user($row->prenom_user);
        $user->setQuestion_secrete($row->question_secrete);
        $user->setReponse($row->reponse);
        return true;
    }

    public function findgac($num_membre) {
        $select = $this->getDbTable()->select();
        $select->where('num_membre=?', $num_membre)
                ->where('usergroup=?', 'gac')
                ->Orwhere('usergroup=?', 'gac_filiere')
                ->Orwhere('usergroup=?', 'creneaux')
                ->Orwhere('usergroup=?', 'acteurs_creneaux');
        $resultSet = $this->getDbTable()->fetchAll($select);
        if (count($resultSet) == 0) {
            return false;
        }
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUser();
            $entry->setId_user($row->id_user)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescr($row->descr)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setUsergroup($row->usergroup)
                    ->setNum_membre($row->num_membre)
                    ->setSecteur($row->secteur)
                    ->setAgence($row->agence)
                    ->setZone($row->zone)
                    ->setNum_gac_filiere($row->num_gac_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_user($row->nom_user)
                    ->setPrenom_user($row->prenom_user)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EuUser();
            $entry->setId_user($row->id_user)
                    ->setLogin($row->login)
                    ->setPwd($row->pwd)
                    ->setDescr($row->descr)
                    ->setUlock($row->ulock)
                    ->setCh_pwd_flog($row->ch_pwd_flog)
                    ->setUsergroup($row->usergroup)
                    ->setNum_membre($row->num_membre)
                    ->setSecteur($row->secteur)
                    ->setAgence($row->agence)
                    ->setZone($row->zone)
                    ->setNum_gac_filiere($row->num_gac_filiere)
                    ->setCode_acteur($row->code_acteur)
                    ->setNom_user($row->nom_user)
                    ->setPrenom_user($row->prenom_user)
                    ->setQuestion_secrete($row->question_secrete)
                    ->setReponse($row->reponse);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function delete($id_user) {
        $this->getDbTable()->delete(array('id_user = ?' => $id_user));
    }

}
	