<?php

class ArticlesvenduController extends Zend_Controller_Action
{

    public function init()
    {
	$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        /* Initialize action controller here */

//include("Url.php");
	}


  public function listarticlevendudistributeurAction()
  {
    /* page espacepersonnel/listarticlevendu - Liste des articles */

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

	if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    $article_vendu = new Application_Model_EuArticlesVenduMapper();
    $this->view->entries = $article_vendu->fetchAllByMemeDistributeur();

    $this->view->tabletri = 1;


  }


  public function listarticlevendurepresentantAction()
  {
    /* page espacepersonnel/listarticlevendu - Liste des articles */
  
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
  if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}


    $article_vendu = new Application_Model_EuArticlesVenduMapper();
    $this->view->entries = $article_vendu->fetchAllByMemeRepresentant();

    $this->view->tabletri = 1;


  }





}
