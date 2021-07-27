<?php

class CodeactivationController extends Zend_Controller_Action {

	public function init() 
	{
		/* Initialize action controller here */
		
include("Url.php");   
 
	}


    
      
    
    public function listcodeactivation0Action()
    {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}

        $membretierscode = new Application_Model_EuMembretierscodeMapper();
        $this->view->entries = $membretierscode->fetchAllByCodeActivation0($sessionmembre->code_membre);
 
        $this->view->tabletri = 1;

}

    public function listcodeactivation1Action()
    {
		$sessionmembre = new Zend_Session_Namespace('membre');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');

		if (!isset($sessionmembre->code_membre)) {
			$this->_redirect('/');
		}

        $membretierscode = new Application_Model_EuMembretierscodeMapper();
        $this->view->entries = $membretierscode->fetchAllByCodeActivation1($sessionmembre->code_membre);
 
        $this->view->tabletri = 1;

}
    





	public function testAction()
	{
		$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcperso');
		




	}


	
}

