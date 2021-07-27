<?php

class BoutiqueligneController extends Zend_Controller_Action {

	public function init()
	{
		/* Initialize action controller here */
      
      //include("Url.php");

	}

	


  public function addarticleAction()
  {
    /* page espacepersonnel/addarticle - Ajout article */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['quantite']) && $_POST['quantite'] != "" && isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['prix']) && $_POST['prix'] != "" && isset($_POST['categorie']) && $_POST['categorie'] != "" && isset($_POST['type']) && $_POST['type'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $article_stockes = new Application_Model_EuArticleStockes();
        $m_article_stockes = new Application_Model_EuArticleStockesMapper();

    include("Transfert.php");
    if (isset($_FILES['imageArticle']['name']) && $_FILES['imageArticle']['name']!="") {
    $chemin = "article_stockes";
    $file = $_FILES['imageArticle']['name'];
    $file1='imageArticle';
    $article = $chemin."/".transfert($chemin,$file1);
    } else {$article = "";}
      
$designation = explode(" ", $_POST['designation']); 
$designation_initial = "";
for ($i=0; $i < count($designation); $i++) {
$designation_initial .= strtoupper($designation[$i]);
}    
$compteur_id = $m_article_stockes->findConuter() + 1;
$reference = $designation_initial.$compteur_id;

for ($i=0; $i < $_POST['quantite']; $i++) { 

        $compteur_id_article = $m_article_stockes->findConuter() + 1;

          $article_stockes->setId_article_stockes($compteur_id_article);
          $article_stockes->setCode_barre("ESMCART".$compteur_id_article);
          $article_stockes->setType($_POST['type']);
          $article_stockes->setCategorie($_POST['categorie']);
          $article_stockes->setReference($reference);
          $article_stockes->setDesignation($_POST['designation']);
          $article_stockes->setPrix($_POST['prix']);
          $article_stockes->setDate_enregistrement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
          $article_stockes->setCode_membre_morale($sessionmembre->code_membre);
          $article_stockes->setPublier(1);
          $article_stockes->setVendu(0);
          $article_stockes->setRemise($_POST['remise']);
          $article_stockes->setImageArticle($article);
          $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
          $m_article_stockes->save($article_stockes);

}

          //$this->_redirect('/boutiqueligne/listarticle');
          $this->view->error = "Articles enregistrés";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function editarticleAction()
  {
    /* page espacepersonnel/addarticle - Ajout article */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['prix']) && $_POST['prix'] != "" && isset($_POST['categorie']) && $_POST['categorie'] != "" && isset($_POST['type']) && $_POST['type'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $article_stockes1 = new Application_Model_EuArticleStockes();
        $m_article_stockes1 = new Application_Model_EuArticleStockesMapper();
        $m_article_stockes1->find($_POST['id_article_stockes'], $article_stockes1);

        $m_article_stockes_all = new Application_Model_EuArticleStockesMapper();
        $article_stockes_all = $m_article_stockes_all->fetchAllByDesignation($article_stockes1->reference);


    include("Transfert.php");
    if (isset($_FILES['imageArticle']['name']) && $_FILES['imageArticle']['name']!="") {
    $chemin = "article_stockes";
    $file = $_FILES['imageArticle']['name'];
    $file1='imageArticle';
    $article = $chemin."/".transfert($chemin,$file1);
    } else {$article = $_POST['imageArticleold'];}

if(count($article_stockes_all) > 0){      
foreach ($article_stockes_all as $entry){
//for ($i=0; $i < $_POST['quantite']; $i++) { 

        $article_stockes = new Application_Model_EuArticleStockes();
        $m_article_stockes = new Application_Model_EuArticleStockesMapper();
        $m_article_stockes->find($entry->id_article_stockes, $article_stockes);

        //$compteur_id_article = $m_article_stockes->findConuter() + 1;

          //$article_stockes->setId_article_stockes($compteur_id_article);
          //$article_stockes->setCode_barre("ESMCART".$compteur_id_article);
          $article_stockes->setType($_POST['type']);
          $article_stockes->setCategorie($_POST['categorie']);
          //$article_stockes->setReference($_POST['reference']);
          $article_stockes->setDesignation($_POST['designation']);
          $article_stockes->setPrix($_POST['prix']);
          //$article_stockes->setDate_enregistrement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
          //$article_stockes->setCode_membre_morale($sessionmembre->code_membre);
          //$article_stockes->setPublier(1);
          //$article_stockes->setVendu(0);
          $article_stockes->setRemise($_POST['remise']);
          $article_stockes->setImageArticle($article);
          $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
          $m_article_stockes->update($article_stockes);

}
}

          $this->view->error = "Articles bien modifiés";
          $this->_redirect('/boutiqueligne/listarticle');
        
      } else {
        $this->view->error = "Champs * obligatoire";

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {
      $article_stockes = new Application_Model_EuArticleStockes();
      $m_article_stockes = new Application_Model_EuArticleStockesMapper();
      $m_article_stockes->find($id, $article_stockes);
    $this->view->article_stockes = $article_stockes;
        $this->view->id = $id;

      }
  }

  } else {

    $id = (int) $this->_request->getParam('id');
    if ($id > 0) {
      $article_stockes = new Application_Model_EuArticleStockes();
      $m_article_stockes = new Application_Model_EuArticleStockesMapper();
      $m_article_stockes->find($id, $article_stockes);
    $this->view->article_stockes = $article_stockes;
        $this->view->id = $id;
      }
  }
  }




  public function addarticleoneAction() {
    /* page espacepersonnel/addarticle - Ajout article */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if(!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
    if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
       if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

       if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
       if(isset($_POST['code_barre']) && $_POST['code_barre'] != "" && isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['prix']) && $_POST['prix'] != "" && isset($_POST['categorie']) && $_POST['categorie'] != "" && isset($_POST['type']) && $_POST['type'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $article_stockes = new Application_Model_EuArticleStockes();
        $m_article_stockes = new Application_Model_EuArticleStockesMapper();

        include("Transfert.php");
        if(isset($_FILES['imageArticle']['name']) && $_FILES['imageArticle']['name']!="") {
            $chemin = "article_stockes";
            $file = $_FILES['imageArticle']['name'];
            $file1='imageArticle';
            $article = $chemin."/".transfert($chemin,$file1);
        } else {$article = "";}
      
        $designation = explode(" ", $_POST['designation']); 
        $designation_initial = "";
        for($i=0; $i < count($designation); $i++) {
            $designation_initial .= strtoupper($designation[$i]);
        }
		
        $compteur_id = $m_article_stockes->findConuter() + 1;
        $reference = $designation_initial.$compteur_id;
        //for ($i=0; $i < $_POST['quantite']; $i++) { 
        $compteur_id_article = $m_article_stockes->findConuter() + 1;

        $article_stockes->setId_article_stockes($compteur_id_article);
        $article_stockes->setCode_barre($_POST['code_barre']);
        $article_stockes->setType($_POST['type']);
        $article_stockes->setCategorie($_POST['categorie']);
        $article_stockes->setReference($reference);
        $article_stockes->setDesignation($_POST['designation']);
        $article_stockes->setPrix($_POST['prix']);
        $article_stockes->setDate_enregistrement($date_id->toString('yyyy-MM-dd HH:mm:ss'));
        $article_stockes->setCode_membre_morale($sessionmembre->code_membre);
        $article_stockes->setPublier(1);
        $article_stockes->setVendu(0);
        $article_stockes->setRemise($_POST['remise']);
		$article_stockes->setQuantite($_POST['quantite']);
        $article_stockes->setImageArticle($article);
        $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
        $m_article_stockes->save($article_stockes);

//}

          //$this->_redirect('/boutiqueligne/listarticle');
          $this->view->error = "Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }




  public function listarticleAction()
  {
    /* page espacepersonnel/listarticle - Liste des articles */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $article_stockes = new Application_Model_EuArticleStockesMapper();
    $this->view->entries = $article_stockes->fetchAllByReference($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }

  public function listarticlevenduAction()
  {
    /* page espacepersonnel/listarticlevendu - Liste des articles */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $article_stockes = new Application_Model_EuArticleStockesMapper();
    $this->view->entries = $article_stockes->fetchAllByVendu($sessionmembre->code_membre);

    $this->view->tabletri = 1;


  }

  public function publierarticleAction()
  {
    /* page espacepersonnel/publierarticle - Publier un article */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockes = new Application_Model_EuArticleStockes();
      $m_article_stockes = new Application_Model_EuArticleStockesMapper();
      $m_article_stockes->find($id, $article_stockes);

    $article_stockes_designation_M = new Application_Model_EuArticleStockesMapper();
    $article_stockes_designation = $article_stockes_designation_M->fetchAllByDesignation($article_stockes->reference);

foreach ($article_stockes_designation as $value) {
      $article_stockes1 = new Application_Model_EuArticleStockes();
      $m_article_stockes1 = new Application_Model_EuArticleStockesMapper();
      $m_article_stockes1->find($value->id_article_stockes, $article_stockes1);

      $article_stockes1->setPublier($this->_request->getParam('publier'));
      $m_article_stockes1->update($article_stockes1);
}
    }

    $this->_redirect('/boutiqueligne/listarticle');
  }




  public function supparticleAction()
  {
    /* page espacepersonnel/supparticle - Suppression d'un article */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockesM = new Application_Model_EuArticleStockesMapper();
      //$article_stockesM->delete($id);
    }

    $this->_redirect('/boutiqueligne/listarticle');
  }



  public function listarticleachatAction()
  {
    /* page espacepersonnel/listarticleachat - Liste des articles achats */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $article_vendus = new Application_Model_EuArticlesVenduMapper();
    $this->view->entries = $article_vendus->fetchAll3($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }





    public function acteurcreneaumembremoraleAction() {
      /* page index  */
      $sessionmcnp = new Zend_Session_Namespace('mcnp');
      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutesmc');

        $membre = (string) $this->_request->getParam('membre');
    if($membre != ""){
        $membremorale = new Application_Model_EuMembreMorale();
        $membremoraleM = new Application_Model_EuMembreMoraleMapper();
        $membremoraleM->find($membre, $membremorale);
    $this->view->membremorale = $membremorale;


        $article_stockes_m = new Application_Model_EuArticleStockesMapper();
        $this->view->entries = $article_stockes_m->fetchAllByVendeur($membre);


    } else {  $this->_redirect('/index/acteurcreneau');  }

       $this->view->tabletri = 1;

    }





  public function listarticlecommandeAction()
  {
    /* page espacepersonnel/listarticleachat - Liste des articles achats */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      //if (isset($_POST['designation']) && $_POST['designation'] != "") {

                  $date_fin = new Zend_Date($_POST['date_fin']);
                  $date_fin->addDay(1);

    $detailcommande = new Application_Model_EuDetailCommandeMapper();
    $this->view->entries = $detailcommande->fetchAllByCommanderEnligne($sessionmembre->code_membre, $_POST['designation'], $_POST['date_debut'], $_POST['date_fin'], $_POST['commander']);

    //$this->view->select = $detailcommande->fetchAllByCommanderSelect($sessionmembre->code_membre, $_POST['designation'], $_POST['date_debut'], $_POST['date_fin'], $_POST['commander']);

          /*} else {
        $this->view->error = "Champs * obligatoire";
      }*/
}

    $this->view->tabletri = 1;
  }



public function listarticlecommandeexcelAction()
    {
        /* page administration/etatqopibanexcel - exportation en excel */

    $sessionmembre = new Zend_Session_Namespace('membre');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcperso');
        

        $date_debut = (string)$this->_request->getParam('date_debut');
        $this->view->date_debut = $date_debut;
        $date_fin = (string)$this->_request->getParam('date_fin');
        $this->view->date_fin = $date_fin;
        $designation = (string)$this->_request->getParam("designation");
        $this->view->designation = $designation;
        $commander = (int)$this->_request->getParam('commander');
        $this->view->commander = $commander;

        //Util_Utils::genererExcelCommande($sessionmembre->code_membre, $date_debut, $date_fin, $designation, $commander);
$this->_redirect(Util_Utils::genererExcelCommande($sessionmembre->code_membre, $date_debut, $date_fin, $designation, $commander));

    }




    public function detailarticlecommandeAction()
    {
      /* page espacepersonnel/detailarticlecommande - detail d'un article */
  
      $sessionmembre = new Zend_Session_Namespace('membre');
      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcperso');
  
      if (!isset($sessionmembre->code_membre)) {
        $this->_redirect('/');
      }
    if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
  if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}
  
      $id =  $this->_request->getParam('id');
      if ($id != "") {
  

        $commande = new Application_Model_EuCommande();
        $m_commande = new Application_Model_EuCommandeMapper();
        $m_commande->find($id, $commande);
        $this->view->commande = $commande;

        $m_detail_commande = new Application_Model_EuDetailCommandeMapper();
        $detail_commande = $m_detail_commande->fetchAllByDetailCommande($id);
        $this->view->detail_commande = $detail_commande;


      
      
      
      
      
      }
  
      //$this->_redirect('/boutiqueligne/listarticle');
    }
  
  



  public function addtariflivraisonAction()
  {
    /* page espacepersonnel/addtariflivraison - Ajout tariflivraison */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        $t_zone = new Application_Model_DbTable_EuZone();
        $zones = $t_zone->fetchAll();
        $this->view->zones = $zones;
        $t_pays = new Application_Model_DbTable_EuPays();
        $pays = $t_pays->fetchAll();
        $this->view->pays = $pays;
        $t_region = new Application_Model_DbTable_EuRegion();
        $regions = $t_region->fetchAll();
        $this->view->regions = $regions;
        $t_prefecture = new Application_Model_DbTable_EuPrefecture();
        $prefectures = $t_prefecture->fetchAll();
        $this->view->prefectures = $prefectures;
        $t_canton = new Application_Model_DbTable_EuCanton();
        $cantons = $t_canton->fetchAll();
        $this->view->cantons = $cantons;


    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['montant_tarif_livraison']) && $_POST['montant_tarif_livraison'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $tarif_livraison = new Application_Model_EuTarifLivraison();
        $m_tarif_livraison = new Application_Model_EuTarifLivraisonMapper();

        $compteur_id_tarif_livraison = $m_tarif_livraison->findConuter() + 1;

          $tarif_livraison->setId_tarif_livraison($compteur_id_tarif_livraison);
          $tarif_livraison->setCode_zone($_POST['code_zone']);
          $tarif_livraison->setId_pays($_POST['id_pays']);
          $tarif_livraison->setId_region($_POST['id_region']);
          $tarif_livraison->setId_prefecture($_POST['id_prefecture']);
          $tarif_livraison->setMontant_tarif_livraison($_POST['montant_tarif_livraison']);
          $tarif_livraison->setCode_membre($sessionmembre->code_membre);
          $tarif_livraison->setStatut(1);
          $m_tarif_livraison->save($tarif_livraison);


          //$this->_redirect('/boutiqueligne/listtariflivraison');
          $this->view->error = "Tarifs des articles enregistrés";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }




  public function edittariflivraisonAction()
  {
    /* page boutiqueligne/edittariflivraison - Modification d'une tariflivraison */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

        $t_zone = new Application_Model_DbTable_EuZone();
        $zones = $t_zone->fetchAll();
        $this->view->zones = $zones;
        $t_pays = new Application_Model_DbTable_EuPays();
        $pays = $t_pays->fetchAll();
        $this->view->pays = $pays;
        $t_region = new Application_Model_DbTable_EuRegion();
        $regions = $t_region->fetchAll();
        $this->view->regions = $regions;
        $t_prefecture = new Application_Model_DbTable_EuPrefecture();
        $prefectures = $t_prefecture->fetchAll();
        $this->view->prefectures = $prefectures;
        $t_canton = new Application_Model_DbTable_EuCanton();
        $cantons = $t_canton->fetchAll();
        $this->view->cantons = $cantons;

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['montant_tarif_livraison']) && $_POST['montant_tarif_livraison'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $tarif_livraison = new Application_Model_EuTarifLivraison();
        $m_tarif_livraison = new Application_Model_EuTarifLivraisonMapper();

        $m_tarif_livraison->find($_POST['id_tarif_livraison'], $tarif_livraison);

          $tarif_livraison->setCode_zone($_POST['code_zone']);
          $tarif_livraison->setId_pays($_POST['id_pays']);
          $tarif_livraison->setId_region($_POST['id_region']);
          $tarif_livraison->setId_prefecture($_POST['id_prefecture']);
          $tarif_livraison->setMontant_tarif_livraison($_POST['montant_tarif_livraison']);
          //$tarif_livraison->setCode_membre($sessionmembre->code_membre);
          //$tarif_livraison->setStatut(1);
          $m_tarif_livraison->update($tarif_livraison);

          $this->_redirect('/boutiqueligne/listtariflivraison');
  }  else { $this->view->error = "Les champs * sont obligatoires ...";

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTarifLivraison();
    $ma = new Application_Model_EuTarifLivraisonMapper();
    $ma->find($id, $a);
    $this->view->tariflivraison = $a;
      }
  }

  } else {

      $id = (int)$this->_request->getParam('id');
      if ($id > 0) {
    $a = new Application_Model_EuTarifLivraison();
    $ma = new Application_Model_EuTarifLivraisonMapper();
    $ma->find($id, $a);
    $this->view->tariflivraison = $a;
      }
  }
  }




  public function listtariflivraisonAction()
  {
    /* page espacepersonnel/listtariflivraison - Liste des tariflivraisons */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $tarif_livraison = new Application_Model_EuTarifLivraisonMapper();
    $this->view->entries = $tarif_livraison->fetchAllByVendeur($sessionmembre->code_membre);

    $this->view->tabletri = 1;
  }


  public function statuttariflivraisonAction()
  {
    /* page espacepersonnel/statuttariflivraison - Statut un tariflivraison */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $id = (int) $this->_request->getParam('id');
    if (isset($id) && $id != 0) {

    $tariflivraison = new Application_Model_EuTarifLivraison();
    $tariflivraisonM = new Application_Model_EuTarifLivraisonMapper();
    $tariflivraisonM->find($id, $tariflivraison);

    $tariflivraison->setStatut($this->_request->getParam('statut'));
    $tariflivraisonM->update($tariflivraison);
    }

    $this->_redirect('/boutiqueligne/listtariflivraison');
  }









  public function panierAction()
  {
    /* page espacepersonnel/panier - Achat en ligne */

    $sessionpanier = new Zend_Session_Namespace('panier');
    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutesmc');

        $t_zone = new Application_Model_DbTable_EuZone();
        $zones = $t_zone->fetchAll();
        $this->view->zones = $zones;
        $t_pays = new Application_Model_DbTable_EuPays();
        $pays = $t_pays->fetchAll();
        $this->view->pays = $pays;
        $t_region = new Application_Model_DbTable_EuRegion();
        $regions = $t_region->fetchAll();
        $this->view->regions = $regions;
        $t_prefecture = new Application_Model_DbTable_EuPrefecture();
        $prefectures = $t_prefecture->fetchAll();
        $this->view->prefectures = $prefectures;
        $t_canton = new Application_Model_DbTable_EuCanton();
        $cantons = $t_canton->fetchAll();
        $this->view->cantons = $cantons;

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['montant']) && $_POST['montant'] != "" && isset($_POST['code_membre_acheteur']) && $_POST['code_membre_acheteur'] != "" && isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['quartier_acheteur']) && $_POST['quartier_acheteur'] != "" && isset($_POST['ville_acheteur']) && $_POST['ville_acheteur'] != "" && isset($_POST['tel_acheteur']) && $_POST['tel_acheteur'] != "" && isset($_POST['mode_livraison']) && $_POST['mode_livraison'] != "" && isset($_POST['montant_livraison']) && $_POST['montant_livraison'] != "" && isset($_POST['type_recurrent']) && $_POST['type_recurrent'] != "" && isset($_POST['type_bon']) && $_POST['type_bon'] != "") {


        $date_id = new Zend_Date(Zend_Date::ISO_8601);

//$code_confirmation = strtoupper(Util_Utils::genererCodeSMS(10));
do{
                    $code_confirmation = strtoupper(Util_Utils::genererCodeSMS(10));
                    $commande2_mapper = new Application_Model_EuCommandeMapper();
                    $commande2 = $commande2_mapper->fetchAllByCodeConfirmation($code_confirmation);
}while(count($commande2) > 0);

$date_commande = $date_id->toString('yyyy-MM-dd HH:mm:ss');

        $commande = new Application_Model_EuCommande();
        $m_commande = new Application_Model_EuCommandeMapper();

          $compt_commande = $m_commande->findConuter() + 1;

          $commande->setCode_commande($compt_commande);
          $commande->setDate_commande($date_commande);
          $commande->setMontant_commande($_POST['montant']);
          $commande->setCode_membre_acheteur($_POST['code_membre_acheteur']);
          $commande->setCode_membre_vendeur($_POST['code_membre_vendeur']);
          $commande->setCode_membre_livreur(NULL);
          $commande->setCode_membre_transitaire(NULL);
          $commande->setCode_membre_transporteur(NULL);
          $commande->setQuartier_acheteur($_POST['quartier_acheteur']);
          $commande->setVille_acheteur($_POST['ville_acheteur']);
          $commande->setTel_acheteur($_POST['tel_acheteur']);
          $commande->setAdresse_livraison($_POST['adresse_livraison']);
          $commande->setCode_confirmation($code_confirmation);
          $commande->setCode_livraison(NULL);
          $commande->setExecuter(0);
          $commande->setLivrer(0);
          $commande->setFrais_livraison(0);
          $commande->setFrais_transit(0);
          $commande->setFrais_transport(0);
          $commande->setDate_livraison(NULL);
          $commande->setCode_zone($_POST['code_zone']);
          $commande->setId_pays($_POST['id_pays']);
          $commande->setId_region($_POST['id_region']);
          $commande->setId_prefecture($_POST['id_prefecture']);
          $commande->setMode_livraison($_POST['mode_livraison']);
          $commande->setType_recurrent($_POST['type_recurrent']);
          $commande->setPeriode_recurrent($_POST['periode_recurrent']);
          $commande->setType_bon($_POST['type_bon']);
          $commande->setMontant_livraison($_POST['montant_livraison']);
          $commande->setEnligne(1);
          $m_commande->save($commande);

for($i = 0; $i < count($sessionpanier->produit); $i++){
if($sessionpanier->produit[$i][0] != ""){

        $detailcommande = new Application_Model_EuDetailCommande();
        $m_detailcommande = new Application_Model_EuDetailCommandeMapper();

          $compt_detailcommande = $m_detailcommande->findConuter() + 1;

          $detailcommande->setId_detail_commande($compt_detailcommande);
          $detailcommande->setCode_commande($compt_commande);
          $detailcommande->setQte($_POST['qte'][$i]);
          $detailcommande->setPrix_unitaire($sessionpanier->produit[$i][3]);
          $detailcommande->setReference($sessionpanier->produit[$i][1]);
          $detailcommande->setDesignation($sessionpanier->produit[$i][2]);
          $detailcommande->setLivrer(0);
          $detailcommande->setRemise($sessionpanier->produit[$i][7]);
          $detailcommande->setPrepayer(1);
          $detailcommande->setCode_barre($sessionpanier->produit[$i][0]);
          $m_detailcommande->save($detailcommande);

}
}

$code_envoi = "Vous venez de lancer une commande. Veuillez confirmer avec ce code : " . $code_confirmation . ". ESMC";
          $date_id = new Zend_Date(Zend_Date::ISO_8601);
          $sms_connexion1 = new Application_Model_EuSmsConnexion();
          $sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();

          $compteur = $sms_connexion1_mapper->findConuter() + 1;
          $sms_connexion1->setSms_connexion_id($compteur);
          $sms_connexion1->setSms_connexion_code_envoi($code_confirmation);
          $sms_connexion1->setSms_connexion_code_recu($code_envoi);
          $sms_connexion1->setSms_connexion_code_membre($_POST['code_membre_acheteur']);
          $sms_connexion1->setSms_connexion_utilise(0);
          $sms_connexion1->setSms_connexion_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
          $sms_connexion1_mapper->save($sms_connexion1);


        $sessionpanier->errorlogin = "Commande bien effectuée. Veuillez confirmer avec le code de confirmation que vous allez recevoir par SMS ...";
        $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms3Easys($compteur, $_POST['tel_acheteur'], $code_envoi);

        $this->_redirect('/boutiqueligne/panierconfirme');

       } else {
        $sessionpanier->errorlogin = "Les champs * sont obligatoires";
      }
} 

  }





  public function panierconfirmeAction()
  {
    $sessionmcnp = new Zend_Session_Namespace('mcnp');
    $sessionpanier = new Zend_Session_Namespace('panier');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutesmc');

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_confirmation']) && $_POST['code_confirmation'] != "") {

        $commande3_mapper = new Application_Model_EuCommandeMapper();
        $commande3 = $commande3_mapper->fetchAllByCodeConfirmation($_POST['code_confirmation']);
if(count($commande3) > 0){

        $commande = new Application_Model_EuCommande();
        $m_commande = new Application_Model_EuCommandeMapper();
        $m_commande->find($commande3->code_commande, $commande);


if($commande->executer == 0){

//$code_livraison = strtoupper(Util_Utils::genererCodeSMS(10));
do{
                    $code_livraison = strtoupper(Util_Utils::genererCodeSMS(10));
                    $commande2_mapper = new Application_Model_EuCommandeMapper();
                    $commande2 = $commande2_mapper->fetchAllByCodeLivraison($code_livraison);
}while(count($commande2) > 0);

$code_envoi = "Vous venez de confirmer votre commande. Voici le code de livraison : " . $code_livraison . ". ESMC";
          $date_id = new Zend_Date(Zend_Date::ISO_8601);
          $sms_connexion1 = new Application_Model_EuSmsConnexion();
          $sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();

          $compteur = $sms_connexion1_mapper->findConuter() + 1;
          $sms_connexion1->setSms_connexion_id($compteur);
          $sms_connexion1->setSms_connexion_code_envoi($code_livraison);
          $sms_connexion1->setSms_connexion_code_recu($code_envoi);
          $sms_connexion1->setSms_connexion_code_membre($commande->code_membre_acheteur);
          $sms_connexion1->setSms_connexion_utilise(0);
          $sms_connexion1->setSms_connexion_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
          $sms_connexion1_mapper->save($sms_connexion1);


          $commande->setCode_livraison($code_livraison);
          $commande->setExecuter(1);
          $m_commande->update($commande);


          $sms_connexion_mapper = new Application_Model_EuSmsConnexionMapper();
          $sms_connexion = $sms_connexion_mapper->fetchAllByCodeRecu($_POST['code_confirmation']);
          
            $sms_connexion1 = new Application_Model_EuSmsConnexion();
            $sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();
            $sms_connexion1_mapper->find($sms_connexion->sms_connexion_id, $sms_connexion1);

            $sms_connexion1->setSms_connexion_utilise(1);
            $sms_connexion1_mapper->update($sms_connexion1);


        Zend_Session::namespaceUnset('panier');
        
        $sessionmcnp->errorlogin = "Opération de commande bien confirmée ...";

        $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms3Easys($compteur, $commande->tel_acheteur, $code_envoi);

      } else{
        $sessionmcnp->errorlogin = "Comfirmation déjà effectuée ...";
      } 

      }else{
        $sessionmcnp->errorlogin = "Code de confirmation erronné ...";
        //var_dump($commande2);
      }


       } else {
        $sessionmcnp->errorlogin = "Les champs * sont obligatoires";
      }
} 



  }



  public function retirerpanierAction()
  {
    $sessionpanier = new Zend_Session_Namespace('panier');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutesmc');

    $i = (int) $this->_request->getParam('id');
    if ($i > -1) {

  $sessionpanier->produit[$i][0] = "";
  $sessionpanier->produit[$i][1] = "";
  $sessionpanier->produit[$i][2] = "";
  $sessionpanier->produit[$i][3] = "";
  $sessionpanier->produit[$i][4] = "";
  $sessionpanier->produit[$i][5] = "";
  $sessionpanier->produit[$i][6] = "";
  $sessionpanier->produit[$i][7] = "";
  $sessionpanier->produit[$i][8] = "";
  $sessionpanier->produit[$i][9] = "";
  $sessionpanier->produit[$i][10] = "";
  //$sessionpanier->produit[$i][11] = "";
  //$sessionpanier->produit[$i][12] = "";

      }
      $this->_redirect('/boutiqueligne/panier');

  }



function nocompteAction()
  {
    Zend_Session::destroy(true);
    $this->_redirect('/');
  }




  public function panierlivrerAction()
  {
    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_livraison2']) && $_POST['code_livraison2'] != "") {

        $commande2_mapper = new Application_Model_EuCommandeMapper();
        $commande2 = $commande2_mapper->fetchAllByCodeLivraison($_POST['code_livraison2']);

if(count($commande2) > 0){

        $commande = new Application_Model_EuCommande();
        $m_commande = new Application_Model_EuCommandeMapper();
        $m_commande->find($commande2->code_commande, $commande);

if($commande->code_membre_vendeur == $sessionmembre->code_membre){

        $commande = new Application_Model_EuCommande();
        $m_commande = new Application_Model_EuCommandeMapper();
        $m_commande->find($commande2->code_commande, $commande);
        $this->view->commande = $commande;

        $m_detail_commande = new Application_Model_EuDetailCommandeMapper();
        $detail_commande = $m_detail_commande->fetchAllByDetailCommande($commande2->code_commande);
        $this->view->detail_commande = $detail_commande;

      }else{
        $sessionmembre->errorlogin = "Cette commande n'est pas pour vous ...";
      }
      }else{
        $sessionmembre->errorlogin = "Code de livraison erronné.";
      }


       }else if (isset($_POST['code_livraison']) && $_POST['code_livraison'] != "") {

        $commande2_mapper = new Application_Model_EuCommandeMapper();
        $commande2 = $commande2_mapper->fetchAllByCodeLivraison($_POST['code_livraison']);

if(count($commande2) > 0){

        $commande = new Application_Model_EuCommande();
        $m_commande = new Application_Model_EuCommandeMapper();
        $m_commande->find($commande2->code_commande, $commande);

if($commande->code_membre_vendeur == $sessionmembre->code_membre){

if($commande->livrer == 0){

          $commande->setLivrer(1);
          $m_commande->update($commande);


          $sms_connexion_mapper = new Application_Model_EuSmsConnexionMapper();
          $sms_connexion = $sms_connexion_mapper->fetchAllByCodeRecu($_POST['code_livraison']);
          
            $sms_connexion1 = new Application_Model_EuSmsConnexion();
            $sms_connexion1_mapper = new Application_Model_EuSmsConnexionMapper();
            $sms_connexion1_mapper->find($sms_connexion->sms_connexion_id, $sms_connexion1);

            $sms_connexion1->setSms_connexion_utilise(1);
            $sms_connexion1_mapper->update($sms_connexion1);


        $sessionmembre->errorlogin = "Commande bien livrée ...";
        }else{
        $sessionmembre->errorlogin = "Livraison déjà effectuée ...";
        }
      }else{
        $sessionmembre->errorlogin = "Cette commande n'est pas pour vous ...";
      }
      }else{
        $sessionmembre->errorlogin = "Code de livraison erronné.";
      }


       } else {
        $sessionmembre->errorlogin = "Les champs * sont obligatoires";
      }
} 



  }













  public function addarticlestockesadditifAction()
  {
    /* page espacepersonnel/addarticlestockesadditif - Ajout article additif */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['nom_article_stockes_additif']) && $_POST['nom_article_stockes_additif'] != "" && isset($_POST['reference']) && $_POST['reference'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $article_stockes_additif = new Application_Model_EuArticleStockesAdditif();
        $m_article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();

        $compteur_id_article_additif = $m_article_stockes_additif->findConuter() + 1;

          $article_stockes_additif->setId_article_stockes_additif($compteur_id_article_additif);
          $article_stockes_additif->setNom_article_stockes_additif($_POST['nom_article_stockes_additif']);
          $article_stockes_additif->setReference($_POST['reference']);
          $article_stockes_additif->setCode_membre_morale($sessionmembre->code_membre);
          $article_stockes_additif->setEtat(1);
          $m_article_stockes_additif->save($article_stockes_additif);


          //$this->_redirect('/boutiqueligne/listarticlestockesadditif');
          $this->view->error = "Additif Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function listarticlestockesadditifAction()
  {
    /* page espacepersonnel/listarticlestockesadditif - Liste des articles additif*/

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();
    $this->view->entries = $article_stockes_additif->fetchAllByCodeMembreMoraleReference($sessionmembre->code_membre, "", "");

    $this->view->tabletri = 1;
  }


  public function etatarticlestockesadditifAction()
  {
    /* page espacepersonnel/publierarticle - Publier un article */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
  if (!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockes_additif = new Application_Model_EuArticleStockesAdditif();
      $m_article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();
      $m_article_stockes_additif->find($id, $article_stockes_additif);


      $article_stockes_additif->setEtat($this->_request->getParam('etat'));
      $m_article_stockes_additif->update($article_stockes_additif);
    }

    $this->_redirect('/boutiqueligne/listarticlestockesadditif');
  }






  public function addarticlestockescategorieAction() {
    /* page espacepersonnel/addarticlestockescategorie - Ajout article categorie */
    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if(!isset($sessionmembre->code_membre)) {
       $this->_redirect('/');
    }
    if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
      if($sessionmembre->confirmation_envoi != "") {$this->_redirect('/espacepersonnel/confirmation');}

      if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
         if(isset($_POST['nom_article_stockes_categorie']) && $_POST['nom_article_stockes_categorie'] != "") {

         $date_id = new Zend_Date(Zend_Date::ISO_8601);

         $article_stockes_categorie = new Application_Model_EuArticleStockesCategorie();
         $m_article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();

         $compteur_id_article_categorie = $m_article_stockes_categorie->findConuter() + 1;

         $article_stockes_categorie->setId_article_stockes_categorie($compteur_id_article_categorie);
         $article_stockes_categorie->setNom_article_stockes_categorie($_POST['nom_article_stockes_categorie']);
         $article_stockes_categorie->setCode_membre_morale($sessionmembre->code_membre);
		 $article_stockes_categorie->setCode_tegc($sessionmembre->code_tegc);
         $article_stockes_categorie->setEtat(1);
         $m_article_stockes_categorie->save($article_stockes_categorie);

         //$this->_redirect('/boutiqueligne/listarticlestockescategorie');
         $this->view->error = "Categorie Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function listarticlestockescategorieAction() {
    /* page espacepersonnel/listarticlestockescategorie - Liste des articles categorie*/
    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if(!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
    if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
      if($sessionmembre->confirmation_envoi != "")  {$this->_redirect('/espacepersonnel/confirmation');}

      $article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();
      $this->view->entries = $article_stockes_categorie->fetchAllByCodeMembreMorale($sessionmembre->code_membre, "");
	  //$this->view->entries = $article_stockes_categorie->fetchAllByTegc($sessionmembre->code_tegc,"");

      $this->view->tabletri = 1;
  }


  
  
  public function etatarticlestockescategorieAction() {
    /* page espacepersonnel/publierarticle - Publier un article */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');

    if (!isset($sessionmembre->code_membre)) {
      $this->_redirect('/');
    }
    if(!isset($sessionmembre->code_membre)) {$this->_redirect('/');}
       if($sessionmembre->confirmation_envoi != ""){$this->_redirect('/espacepersonnel/confirmation');}

    $id = (string) $this->_request->getParam('id');
    if($id != "") {
       $article_stockes_categorie = new Application_Model_EuArticleStockesCategorie();
       $m_article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();
       $m_article_stockes_categorie->find($id, $article_stockes_categorie);

       $article_stockes_categorie->setEtat($this->_request->getParam('etat'));
       $m_article_stockes_categorie->update($article_stockes_categorie);
    }

    $this->_redirect('/boutiqueligne/listarticlestockescategorie');
  }





  




  public function addinformationadditifAction()
  {
    /* page espacepersonnel/addinformationadditif - Ajout article additif */

      $sessionmembreasso = new Zend_Session_Namespace('membreasso');
      $this->_helper->layout()->setLayout('layoutpublicesmcint');
      if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['libelle_information_additif']) && $_POST['libelle_information_additif'] != "" && isset($_POST['reference']) && $_POST['reference'] != "" && isset($_POST['code_membre']) && $_POST['code_membre'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $information_additif = new Application_Model_EuInformationAdditif();
        $m_information_additif = new Application_Model_EuInformationAdditifMapper();

        $compteur_id_information_additif = $m_information_additif->findConuter() + 1;

          $information_additif->setId_information_additif($compteur_id_information_additif);
          $information_additif->setLibelle_information_additif($_POST['libelle_information_additif']);
          $information_additif->setReference($_POST['reference']);
          $information_additif->setCode_membre($_POST['code_membre']);
          $information_additif->setMembreasso_id($sessionmembreasso->membreasso_id);
          $information_additif->setEtat(1);
          $m_information_additif->save($information_additif);


          //$this->_redirect('/boutiqueligne/listinformationadditif');
          $this->view->error = "Information Additif enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function listinformationadditifAction()
  {
    /* page espacepersonnel/listinformationadditif - Liste des articles additif*/


      $sessionmembreasso = new Zend_Session_Namespace('membreasso');
      $this->_helper->layout()->setLayout('layoutpublicesmcint');
      if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $information_additif = new Application_Model_EuInformationAdditifMapper();
    $this->view->entries = $information_additif->fetchAllByCodeMembreReferenceMembreasso("", "", $sessionmembreasso->membreasso_id, "");

    $this->view->tabletri = 1;
  }


  public function listinformationadditifadminAction()
  {
    /* page espacepersonnel/listinformationadditif - Liste des articles additif*/

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');
    
  if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    $information_additif = new Application_Model_EuInformationAdditifMapper();
    $this->view->entries = $information_additif->fetchAllByCodeMembreReferenceMembreasso("", "", "", "");

    $this->view->tabletri = 1;
  }


  public function etatinformationadditifAction()
  {
    /* page espacepersonnel/publierarticle - Publier un article */


      $sessionmembreasso = new Zend_Session_Namespace('membreasso');
      $this->_helper->layout()->setLayout('layoutpublicesmcint');
      if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $information_additif = new Application_Model_EuInformationAdditif();
      $m_information_additif = new Application_Model_EuInformationAdditifMapper();
      $m_information_additif->find($id, $information_additif);


      $information_additif->setEtat($this->_request->getParam('etat'));
      $m_information_additif->update($information_additif);
    }

    $this->_redirect('/boutiqueligne/listinformationadditif');
  }







  




}
