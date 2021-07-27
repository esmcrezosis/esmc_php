<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EuCompteUserController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        if ($group == 'agregat') {
            $menu = "<li><a href=\" /eu-compte-user/new \">Nouveau</a></li>".
			        "<li><a href=\" /eu-compte-user/index\">Liste des comptes</a></li>";
        } 
        $this->view->placeholder("menu")->set($menu);
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'agregat') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    
  


   

    public function indexAction() {
        //$this->_helper->layout->disableLayout(); 
    }

    public function enrolementAction() {
        
    }

    public function listecarteAction() {
        
    }

    public function listebnpAction() {
        
    }


    public function agencesAction() {
        $tagences = new Application_Model_EuAgenceMapper();
        $agences = $tagences->fetchAll();
        if (count($agences) >= 1) {
            foreach ($agences as $value) {
                $data[0][] = $value->getCode_agence();
                $data[1][] = $value->getLibelle_agence();
            }
            $this->view->data = $data;
        } else {
            $this->view->data = false;
        }
    }

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_acteur = $user->code_acteur;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_utilisateur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuUtilisateur();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->where('code_acteur like ?', $code_acteur);
        $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
        $select->order('id_utilisateur desc');
        $cat = $tabela->fetchAll($select);
        $count = count($cat);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $cats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cats as $row) {
            $responce['rows'][$i]['id'] = $row->id_utilisateur;
            $responce['rows'][$i]['cell'] = array(
            strtoupper($row->nom_utilisateur) . ' ' . ucfirst($row->PREnom_utilisateur),
                $row->login,
                ucfirst($row->libelle_groupe),
                $row->connecte,
                $row->code_membre,
                $row->code_agence
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    


}

?>
