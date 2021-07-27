<?php

class StatistiquesController extends Zend_Controller_Action {
    
    public function init(){

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        if(!isset($sessionutilisateur->login)) { $this->_redirect('/administration/login');}
        
        if($sessionutilisateur->confirmation != "") { $this->_redirect('/administration/confirmation');}

    }


    public function etatsouscriptionbanAction () {

    }

    public function etatexpressionbanAction () {

    }

    public function etatsouscriptionbcAction () {

    }

    public function etatexpressionbcAction () {

    }


}