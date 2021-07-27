<?php

class BoutiqueligneintegrateurController extends Zend_Controller_Action {

	public function init()
	{
		/* Initialize action controller here */
      
      //include("Url.php");

	}

	


  public function addarticleAction()
  {
    /* page espacepersonnel/addarticle - Ajout article */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['quantite']) && $_POST['quantite'] != "" && isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['prix']) && $_POST['prix'] != "" && isset($_POST['categorie']) && $_POST['categorie'] != "" && isset($_POST['type']) && $_POST['type'] != "" && isset($_POST['code_membre_morale']) && $_POST['code_membre_morale'] != "") {

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
          $article_stockes->setCode_membre_morale($_POST['code_membre_morale']);
          $article_stockes->setPublier(1);
          $article_stockes->setVendu(0);
          $article_stockes->setRemise($_POST['remise']);
          $article_stockes->setImageArticle($article);
          $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
          $m_article_stockes->save($article_stockes);

}

          //$this->_redirect('/boutiqueligneintegrateur/listarticle');
          $this->view->error = "Articles enregistrés";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function editarticleAction()
  {
    /* page espacepersonnel/addarticle - Ajout article */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['prix']) && $_POST['prix'] != "" && isset($_POST['categorie']) && $_POST['categorie'] != "" && isset($_POST['type']) && $_POST['type'] != "" && isset($_POST['code_membre_morale']) && $_POST['code_membre_morale'] != "") {

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
          $article_stockes->setCode_membre_morale($_POST['code_membre_morale']);
          //$article_stockes->setPublier(1);
          //$article_stockes->setVendu(0);
          $article_stockes->setRemise($_POST['remise']);
          $article_stockes->setImageArticle($article);
          $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
          $m_article_stockes->update($article_stockes);

}
}

          $this->view->error = "Articles bien modifiés";
          $this->_redirect('/boutiqueligneintegrateur/listarticle');
        
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




  public function addarticleoneAction()
  {
    /* page espacepersonnel/addarticle - Ajout article */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['code_barre']) && $_POST['code_barre'] != "" && isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['prix']) && $_POST['prix'] != "" && isset($_POST['categorie']) && $_POST['categorie'] != "" && isset($_POST['type']) && $_POST['type'] != "" && isset($_POST['code_membre_morale']) && $_POST['code_membre_morale'] != "") {

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
          $article_stockes->setCode_membre_morale($_POST['code_membre_morale']);
          $article_stockes->setPublier(1);
          $article_stockes->setVendu(0);
          $article_stockes->setRemise($_POST['remise']);
          $article_stockes->setImageArticle($article);
          $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
          $m_article_stockes->save($article_stockes);

//}

          //$this->_redirect('/boutiqueligneintegrateur/listarticle');
          $this->view->error = "Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }




  public function listarticleAction()
  {
    /* page espacepersonnel/listarticle - Liste des articles */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $article_stockes = new Application_Model_EuArticleStockesMapper();
    $this->view->entries = $article_stockes->fetchAllByReference("");

    $this->view->tabletri = 1;
  }

  public function listarticlevenduAction()
  {
    /* page espacepersonnel/listarticlevendu - Liste des articles */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $article_stockes = new Application_Model_EuArticleStockesMapper();
    $this->view->entries = $article_stockes->fetchAllByVendu("");

    $this->view->tabletri = 1;


  }

  public function publierarticleAction()
  {
    /* page espacepersonnel/publierarticle - Publier un article */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

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

    $this->_redirect('/boutiqueligneintegrateur/listarticle');
  }




  public function supparticleAction()
  {
    /* page espacepersonnel/supparticle - Suppression d'un article */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockesM = new Application_Model_EuArticleStockesMapper();
      //$article_stockesM->delete($id);
    }

    $this->_redirect('/boutiqueligneintegrateur/listarticle');
  }








  public function listarticlecommandeAction()
  {
    /* page espacepersonnel/listarticleachat - Liste des articles achats */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      //if (isset($_POST['designation']) && $_POST['designation'] != "") {

                  $date_fin = new Zend_Date($_POST['date_fin']);
                  $date_fin->addDay(1);

    $detailcommande = new Application_Model_EuDetailCommandeMapper();
    $this->view->entries = $detailcommande->fetchAllByCommander($_POST['code_membre_morale'], $_POST['designation'], $_POST['date_debut'], $_POST['date_fin'], $_POST['commander']);

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

    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        

        $date_debut = (string)$this->_request->getParam('date_debut');
        $this->view->date_debut = $date_debut;
        $date_fin = (string)$this->_request->getParam('date_fin');
        $this->view->date_fin = $date_fin;
        $designation = (string)$this->_request->getParam("designation");
        $this->view->designation = $designation;
        $commander = (int)$this->_request->getParam('commander');
        $this->view->commander = $commander;

        //Util_Utils::genererExcelCommande($sessionmembreasso->code_membre, $date_debut, $date_fin, $designation, $commander);
$this->_redirect(Util_Utils::genererExcelCommande($_POST['code_membre_morale'], $date_debut, $date_fin, $designation, $commander));

    }







  public function addtariflivraisonAction()
  {
    /* page espacepersonnel/addtariflivraison - Ajout tariflivraison */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

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
      if (isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['montant_tarif_livraison']) && $_POST['montant_tarif_livraison'] != "" && isset($_POST['code_membre_morale']) && $_POST['code_membre_morale'] != "") {

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
          $tarif_livraison->setCode_membre($_POST['code_membre_morale']);
          $tarif_livraison->setStatut(1);
          $m_tarif_livraison->save($tarif_livraison);


          //$this->_redirect('/boutiqueligneintegrateur/listtariflivraison');
          $this->view->error = "Tarifs des articles enregistrés";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }




  public function edittariflivraisonAction()
  {
    /* page boutiqueligneintegrateur/edittariflivraison - Modification d'une tariflivraison */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

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
      if (isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['montant_tarif_livraison']) && $_POST['montant_tarif_livraison'] != "" && isset($_POST['code_membre_morale']) && $_POST['code_membre_morale'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $tarif_livraison = new Application_Model_EuTarifLivraison();
        $m_tarif_livraison = new Application_Model_EuTarifLivraisonMapper();

        $m_tarif_livraison->find($_POST['id_tarif_livraison'], $tarif_livraison);

          $tarif_livraison->setCode_zone($_POST['code_zone']);
          $tarif_livraison->setId_pays($_POST['id_pays']);
          $tarif_livraison->setId_region($_POST['id_region']);
          $tarif_livraison->setId_prefecture($_POST['id_prefecture']);
          $tarif_livraison->setMontant_tarif_livraison($_POST['montant_tarif_livraison']);
          $tarif_livraison->setCode_membre($_POST['code_membre_morale']);
          //$tarif_livraison->setStatut(1);
          $m_tarif_livraison->update($tarif_livraison);

          $this->_redirect('/boutiqueligneintegrateur/listtariflivraison');
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

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $tarif_livraison = new Application_Model_EuTarifLivraisonMapper();
    $this->view->entries = $tarif_livraison->fetchAllByVendeur("");

    $this->view->tabletri = 1;
  }


  public function statuttariflivraisonAction()
  {
    /* page espacepersonnel/statuttariflivraison - Statut un tariflivraison */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $id = (int) $this->_request->getParam('id');
    if (isset($id) && $id != 0) {

    $tariflivraison = new Application_Model_EuTarifLivraison();
    $tariflivraisonM = new Application_Model_EuTarifLivraisonMapper();
    $tariflivraisonM->find($id, $tariflivraison);

    $tariflivraison->setStatut($this->_request->getParam('statut'));
    $tariflivraisonM->update($tariflivraison);
    }

    $this->_redirect('/boutiqueligneintegrateur/listtariflivraison');
  }


















  public function addarticlestockesadditifAction()
  {
    /* page espacepersonnel/addarticlestockesadditif - Ajout article additif */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['nom_article_stockes_additif']) && $_POST['nom_article_stockes_additif'] != "" && isset($_POST['reference']) && $_POST['reference'] != "" && isset($_POST['code_membre_morale']) && $_POST['code_membre_morale'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $article_stockes_additif = new Application_Model_EuArticleStockesAdditif();
        $m_article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();

        $compteur_id_article_additif = $m_article_stockes_additif->findConuter() + 1;

          $article_stockes_additif->setId_article_stockes_additif($compteur_id_article_additif);
          $article_stockes_additif->setNom_article_stockes_additif($_POST['nom_article_stockes_additif']);
          $article_stockes_additif->setReference($_POST['reference']);
          $article_stockes_additif->setCode_membre_morale($_POST['code_membre_morale']);
          $article_stockes_additif->setEtat(1);
          $m_article_stockes_additif->save($article_stockes_additif);


          //$this->_redirect('/boutiqueligneintegrateur/listarticlestockesadditif');
          $this->view->error = "Additif Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function listarticlestockesadditifAction()
  {
    /* page espacepersonnel/listarticlestockesadditif - Liste des articles additif*/

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();
    $this->view->entries = $article_stockes_additif->fetchAllByCodeMembreMoraleReference("", "", "");

    $this->view->tabletri = 1;
  }


  public function etatarticlestockesadditifAction()
  {
    /* page espacepersonnel/publierarticle - Publier un article */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockes_additif = new Application_Model_EuArticleStockesAdditif();
      $m_article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();
      $m_article_stockes_additif->find($id, $article_stockes_additif);


      $article_stockes_additif->setEtat($this->_request->getParam('etat'));
      $m_article_stockes_additif->update($article_stockes_additif);
    }

    $this->_redirect('/boutiqueligneintegrateur/listarticlestockesadditif');
  }






  public function addarticlestockescategorieAction()
  {
    /* page espacepersonnel/addarticlestockescategorie - Ajout article categorie */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['nom_article_stockes_categorie']) && $_POST['nom_article_stockes_categorie'] != "" && isset($_POST['code_membre_morale']) && $_POST['code_membre_morale'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $article_stockes_categorie = new Application_Model_EuArticleStockesCategorie();
        $m_article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();

        $compteur_id_article_categorie = $m_article_stockes_categorie->findConuter() + 1;

          $article_stockes_categorie->setId_article_stockes_categorie($compteur_id_article_categorie);
          $article_stockes_categorie->setNom_article_stockes_categorie($_POST['nom_article_stockes_categorie']);
          $article_stockes_categorie->setCode_membre_morale($_POST['code_membre_morale']);
          $article_stockes_categorie->setEtat(1);
          $m_article_stockes_categorie->save($article_stockes_categorie);


          //$this->_redirect('/boutiqueligneintegrateur/listarticlestockescategorie');
          $this->view->error = "Categorie Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function listarticlestockescategorieAction()
  {
    /* page espacepersonnel/listarticlestockescategorie - Liste des articles categorie*/

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();
    $this->view->entries = $article_stockes_categorie->fetchAllByCodeMembreMorale("", "");

    $this->view->tabletri = 1;
  }


  public function etatarticlestockescategorieAction()
  {
    /* page espacepersonnel/publierarticle - Publier un article */

	    $sessionmembreasso = new Zend_Session_Namespace('membreasso');
 	    $this->_helper->layout()->setLayout('layoutpublicesmcint');
	    if(!isset($sessionmembreasso->login)) {$this->_redirect('/integrateur/login');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockes_categorie = new Application_Model_EuArticleStockesCategorie();
      $m_article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();
      $m_article_stockes_categorie->find($id, $article_stockes_categorie);


      $article_stockes_categorie->setEtat($this->_request->getParam('etat'));
      $m_article_stockes_categorie->update($article_stockes_categorie);
    }

    $this->_redirect('/boutiqueligneintegrateur/listarticlestockescategorie');
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


          //$this->_redirect('/boutiqueligneintegrateur/listinformationadditif');
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

    $this->_redirect('/boutiqueligneintegrateur/listinformationadditif');
  }







  




}
