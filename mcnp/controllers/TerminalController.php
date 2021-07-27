<?php

class TerminalController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */	
        
    }


    public function confirmationAction()  {
        /* page terminal/confirmation - Confirmation d'accès a cet espace d'terminal */
        $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
        if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}

            if(!isset($sessionterminal->fois)) {
                $sessionterminal->fois = 0;
            }

        if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if(isset($_POST['confirme']) && $_POST['confirme'] != "" && $_POST['confirme'] == $sessionterminal->confirmation) {

              $sessionterminal->confirmation = "";
              $this->_redirect('/terminal');

            } else {
                $sessionterminal->error = "Erreur de Code de confirmation";
                $sessionterminal->fois += 1;
                if($sessionterminal->fois < 3){
                   $this->_redirect('/terminal/confirmation');
                } else {
                   $sessionterminal->fois = 0;
                   $this->_redirect('/terminal/nocompte');        
                }

            }
            //$this->_redirect('/terminal');
        }
    }
	
	
	public function secureloginAction()  {
	   $sessionterminal = new Zend_Session_Namespace('terminal');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublicesmcint');
	   
	   if(isset($_POST['ok']) && $_POST['ok']=="ok") {
	      if(isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!="") {
			   $euutilisateur = new Application_Model_DbTable_EuUtilisateur();
               $select = $euutilisateur->select()->where('login = ?', $_POST['login'])
                                                 ->where('pwd = ?', md5($_POST['pwd']))
                                                 ->where("code_groupe = 'cnp_tegcp'");
               $rowseuutilisateur = $euutilisateur->fetchRow($select);
               if(count($rowseuutilisateur) > 0) {
				   $eutegc = new Application_Model_DbTable_EuTegc();
                   $select = $eutegc->select();
                   $select->where('code_tegc = ?', $rowseuutilisateur->code_tegc);
                   $rowseutegc = $eutegc->fetchRow($select);
                   if(count($rowseutegc) > 0) {
					   $sessionterminal->id_utilisateur = $rowseuutilisateur->id_utilisateur;
                       //$sessionterminal->login = $rowseuutilisateur->login;
                       $sessionterminal->code_groupe = $rowseuutilisateur->code_groupe;
                       $sessionterminal->nom_utilisateur = $rowseuutilisateur->nom_utilisateur;
                       $sessionterminal->prenom_utilisateur = $rowseuutilisateur->prenom_utilisateur;
                       $sessionterminal->pays = $rowseuutilisateur->id_pays;
                       $sessionterminal->code_membre = $rowseutegc->code_membre;
					   $sessionterminal->nom_tegc = $rowseutegc->nom_tegc;
				       $sessionterminal->code_membre_user = $rowseuutilisateur->code_membre;
                       $sessionterminal->id_filiere = $rowseuutilisateur->id_filiere;
                       $sessionterminal->code_acteur = $rowseuutilisateur->code_acteur;
                       $sessionterminal->code_groupe_create = $rowseuutilisateur->code_groupe_create;
                       $sessionterminal->code_agence = $rowseuutilisateur->code_agence;
                       $sessionterminal->code_tegc = $rowseuutilisateur->code_tegc;

                       if(substr($sessionterminal->code_membre_user, -1) == "P") {
					       $m_membre = new Application_Model_EuMembreMapper();
					       $membre = new Application_Model_EuMembre();
					       $retour = $m_membre->find($sessionterminal->code_membre_user, $membre);
				       } else if (substr($sessionterminal->code_membre_user, -1) == "M") {
					       $m_membre = new Application_Model_EuMembreMoraleMapper();
					       $membre = new Application_Model_EuMembreMorale();
					       $retour = $m_membre->find($sessionterminal->code_membre_user, $membre);
				       }
					   
					   $sessionterminal->desactiver = $membre->desactiver;
					   
					   //if($sessionterminal->code_tegc  != "TEGCP60010010010010000003M00145") {
						   
					   if($sessionterminal->code_membre  != "0010010010010000003M") {
					 
					      if($membre->desactiver == 0) {
						     $sessionterminal->confirmation = strtoupper(Util_Utils::genererCodeSMS(5));
                          
                             $os = Util_Utils::getOS();
                             $infos =  Util_Utils::detecterSysteme();
                             $texte_confirmation = "Confirmez vous la Tentative de connection à votre compte de Vente ESMC depuis un navigateur ".$infos['browser']." sous ".$os." ?";

					         $table = new Application_Model_DbTable_EuConfirmation();
                             $entryObject = new Application_Model_EuConfirmation();
                             $mapper = new Application_Model_EuConfirmationMapper();

                             $db = Zend_Db_Table::getDefaultAdapter();
                             $entryObject->setType_confirmation("2")
                                         ->setCode_operateur($rowseuutilisateur->login)
                                         ->setNom_operateur("")
                                         ->setData_text($texte_confirmation)
                                         ->setData_json("")
                                         ->setActivite("http://prod.esmcgacsource.com/terminal/securelogin")
                                         ->setStatus("1")
                                         ->setDate_creation(time())
                                         ->setDate_confirmation("")
                                         ->setTexte_confirmation($texte_confirmation)
                                         ->setPage("terminal/securelogin")
                                         ->setCode_sms($sessionterminal->confirmation)
                                         ->setNom_appareil("")
                                         ->setImei_appareil("")
                                         ->setNumero_appareil("")
                                         ->setMac_appareil("")
                                         ->setIp_appareil("")
                                         ->setCode_membre($sessionterminal->code_membre_user);
                              $mapper->save($entryObject);
               
                              $numero_insertion = $db->lastInsertId();

                              $sessionterminal->numero_confirmation = $numero_insertion;

                              Util_Utils::envoiNotificationAdministrationBiometrique(""+$numero_insertion,$sessionterminal->code_membre_user,"Terminal ESMC",$texte_confirmation ,$sessionterminal->confirmation);
                              $sessionterminal->errorlogin = "";						  
						   
					      } else {						   
				             $sessionterminal->errorlogin = "Veuillez procéder à la nouvelle activation de votre compte marchand ...";
                             $this->_redirect('/terminal/securelogin');
			              }
					   
				        } else {
							$sessionterminal->login = $rowseuutilisateur->login;
							$this->_redirect('/terminal');
						}
					   
					   
				   } else { 
			          $sessionterminal->errorlogin = "Vous n'avez pas de terminal d'échange ...";
				      $this->_redirect('/terminal/login');
			       }
			   } else { $sessionterminal->errorlogin = "Login ou Mot de Passe Erroné"; }			   
			 
		  } else { $sessionterminal->errorlogin = "Saisir Login et Mot de Passe"; }
	   }
	}



    public function loginAction() {
	   $sessionterminal = new Zend_Session_Namespace('terminal');
       $this->_helper->layout->disableLayout();
       //$this->_helper->layout()->setLayout('layoutpublicesmcint');
	   
	   $this->_redirect('/terminal/securelogin');
	   
	   /*
	   if(isset($_POST['ok']) && $_POST['ok']=="ok") {
	   if(isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!="") {

         $euutilisateur = new Application_Model_DbTable_EuUtilisateur();
         $select = $euutilisateur->select()->where('login = ?', $_POST['login'])
                                           ->where('pwd = ?', md5($_POST['pwd']))
                                           ->where("code_groupe = 'cnp_tegcp'");
         $rowseuutilisateur = $euutilisateur->fetchRow($select);
         if(count($rowseuutilisateur) > 0) {
             $eutegc = new Application_Model_DbTable_EuTegc();
             $select = $eutegc->select();
             $select->where('code_tegc = ?', $rowseuutilisateur->code_tegc);
             $rowseutegc = $eutegc->fetchRow($select);
             if(count($rowseutegc) > 0) {
                 $sessionterminal->id_utilisateur = $rowseuutilisateur->id_utilisateur;
                 $sessionterminal->login = $rowseuutilisateur->login;
                 $sessionterminal->code_groupe = $rowseuutilisateur->code_groupe;
                 $sessionterminal->nom_utilisateur = $rowseuutilisateur->nom_utilisateur;
                 $sessionterminal->prenom_utilisateur = $rowseuutilisateur->prenom_utilisateur;
                 $sessionterminal->pays = $rowseuutilisateur->id_pays;
                 $sessionterminal->code_membre = $rowseutegc->code_membre;
				 $sessionterminal->code_membre_user = $rowseuutilisateur->code_membre;
                 $sessionterminal->id_filiere = $rowseuutilisateur->id_filiere;
                 $sessionterminal->code_acteur = $rowseuutilisateur->code_acteur;
                 $sessionterminal->code_groupe_create = $rowseuutilisateur->code_groupe_create;
                 $sessionterminal->code_agence = $rowseuutilisateur->code_agence;
                 $sessionterminal->code_tegc = $rowseuutilisateur->code_tegc;

                 $sessionterminal->confirmation = strtoupper(Util_Utils::genererCodeSMS(5));
                 if(substr($sessionterminal->code_membre_user, -1) == "P") {
					$m_membre = new Application_Model_EuMembreMapper();
					$membre = new Application_Model_EuMembre();
					$retour = $m_membre->find($sessionterminal->code_membre_user, $membre);
				 } else if (substr($sessionterminal->code_membre_user, -1) == "M") {
					$m_membre = new Application_Model_EuMembreMoraleMapper();
					$membre = new Application_Model_EuMembreMorale();
					$retour = $m_membre->find($sessionterminal->code_membre_user, $membre);
				 }				 
            
				 $sessionterminal->errorlogin = "";
				 
				 $compteur = Util_Utils::findConuter() + 1; 
                 Util_Utils::addSms3Easys($compteur, $membre->portable_membre, "Voici votre code de confirmation: ".$sessionterminal->confirmation.". Veuillez le saisir dans le champ correspondant. Merci");        

                 $this->_redirect('/terminal/confirmation');
				 
                 //$this->_redirect('/terminal');
             } else { 
			     $sessionterminal->errorlogin = "Vous n'avez pas de terminal d'échange ...";
				 $this->_redirect('/terminal/login');
			 }
             //$this->_redirect('/terminal');
	} else { $sessionterminal->errorlogin = "Login ou Mot de Passe Erroné"; }
        $this->_redirect('/terminal/login');
	} else { $sessionterminal->errorlogin = "Saisir Login et Mot de Passe"; } 
        $this->_redirect('/terminal/login');
	}
	   */
	   
	}

    public function passwordAction() {
	   $sessionterminal = new Zend_Session_Namespace('terminal');
       //$this->_helper->layout->disableLayout();
       $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
       if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
       //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}
		
	   if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['ancien']) && $_POST['ancien'] != "" && isset($_POST['nouveau']) && $_POST['nouveau'] != "" && isset($_POST['confirmer']) && $_POST['confirmer'] == $_POST['nouveau']) {

                    $euutilisateur = new Application_Model_DbTable_EuUtilisateur();
                    $select = $euutilisateur->select()->where('login = ?', $sessionterminal->login);
                    $select->where('pwd = ?', md5($_POST['ancien']));
                    if ($rowseuutilisateur = $euutilisateur->fetchRow($select)) {
                        $utilisateur = new Application_Model_EuUtilisateur();
                        $mapper = new Application_Model_EuUtilisateurMapper();
                        $mapper->find($sessionterminal->id_utilisateur, $utilisateur);
                        
                        $utilisateur->setPwd(md5($_POST['nouveau']));
                        $mapper->update($utilisateur);
                        $this->view->error = "Modification effectuée";
                    }
            } else {
                $this->view->error = "Saisir tous les champs";
            }
            //$this->_redirect('/administration');
        }
    }

    function nocompteAction() {
	  Zend_Session::destroy(true);
      $this->_redirect('/terminal/login');
    }
	
	function logoutAction() {
	   Zend_Session::destroy(true);
       $this->_redirect('/terminal/login');
    }

    public function indexAction() {
	    $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
        if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
        //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}
		
	    if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}


    }








  public function addarticleAction()
  {
    /* page terminal/addarticle - Ajout article */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

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
          $article_stockes->setCode_membre_morale($sessionterminal->code_membre);
          $article_stockes->setPublier(1);
          $article_stockes->setVendu(0);
          $article_stockes->setRemise($_POST['remise']);
          $article_stockes->setImageArticle($article);
          $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
          $m_article_stockes->save($article_stockes);

}

          //$this->_redirect('/terminal/listarticle');
          $this->view->error = "Articles enregistrés";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function editarticleAction()
  {
    /* page terminal/addarticle - Ajout article */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

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
          //$article_stockes->setCode_membre_morale($sessionterminal->code_membre);
          //$article_stockes->setPublier(1);
          //$article_stockes->setVendu(0);
          $article_stockes->setRemise($_POST['remise']);
          $article_stockes->setImageArticle($article);
          $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
          $m_article_stockes->update($article_stockes);

}
}

          $this->view->error = "Articles bien modifiés";
          $this->_redirect('/terminal/listarticle');
        
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
    /* page terminal/addarticle - Ajout article */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if(isset($_POST['code_barre']) && $_POST['code_barre'] != "" && isset($_POST['designation']) && $_POST['designation'] != "" && isset($_POST['prix']) && $_POST['prix'] != "" && isset($_POST['categorie']) && $_POST['categorie'] != "" && isset($_POST['type']) && $_POST['type'] != "") {

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
          $article_stockes->setCode_membre_morale($sessionterminal->code_membre);
          $article_stockes->setPublier(1);
          $article_stockes->setVendu(0);
          $article_stockes->setRemise($_POST['remise']);
		  $article_stockes->setQuantite($_POST['quantite']);
          $article_stockes->setImageArticle($article);
          $article_stockes->setArticle_stockes_categorie($_POST['article_stockes_categorie']);
          $m_article_stockes->save($article_stockes);

//}

          //$this->_redirect('/terminal/listarticle');
          $this->view->error = "Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }




  public function listarticleAction() {
     /* page terminal/listarticle - Liste des articles */
     $sessionterminal = new Zend_Session_Namespace('terminal');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
     if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
     //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

     $article_stockes = new Application_Model_EuArticleStockesMapper();
     $this->view->entries = $article_stockes->fetchAllByReference($sessionterminal->code_tegc);

     $this->view->tabletri = 1;
  }
  
  

  public function listarticlevenduAction() {
     /* page terminal/listarticlevendu - Liste des articles */

     $sessionterminal = new Zend_Session_Namespace('terminal');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
     if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
     //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

     $article_stockes = new Application_Model_EuArticleStockesMapper();
     $this->view->entries = $article_stockes->fetchAllByVendu($sessionterminal->code_tegc);

     $this->view->tabletri = 1;
  }

  public function publierarticleAction() {
    /* page terminal/publierarticle - Publier un article */
    $sessionterminal = new Zend_Session_Namespace('terminal');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
    //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    $id = (string) $this->_request->getParam('id');
    if($id != "") {

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

    $this->_redirect('/terminal/listarticle');
 }




  public function supparticleAction()
  {
    /* page terminal/supparticle - Suppression d'un article */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockesM = new Application_Model_EuArticleStockesMapper();
      //$article_stockesM->delete($id);
    }

    $this->_redirect('/terminal/listarticle');
  }



  public function listarticleachatAction()
  {
    /* page terminal/listarticleachat - Liste des articles achats */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    $article_vendus = new Application_Model_EuArticlesVenduMapper();
    $this->view->entries = $article_vendus->fetchAll3($sessionterminal->code_membre);

    $this->view->tabletri = 1;
  }






  public function listarticlecommandeoldAction()
  {
    /* page terminal/listarticleachat - Liste des articles achats */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      //if (isset($_POST['designation']) && $_POST['designation'] != "") {

                  $date_fin = new Zend_Date($_POST['date_fin']);
                  $date_fin->addDay(1);

    $detailcommande = new Application_Model_EuDetailCommandeMapper();
    $this->view->entries = $detailcommande->fetchAllByCommander($sessionterminal->code_membre, $_POST['designation'], $_POST['date_debut'], $_POST['date_fin'], $_POST['commander']);

    //$this->view->select = $detailcommande->fetchAllByCommanderSelect($sessionterminal->code_membre, $_POST['designation'], $_POST['date_debut'], $_POST['date_fin'], $_POST['commander']);

          /*} else {
        $this->view->error = "Champs * obligatoire";
      }*/
}

    $this->view->tabletri = 1;
  }


  public function listarticlecommandeAction() {
     /* page terminal/listarticleachat - Liste des articles achats */

     $sessionterminal = new Zend_Session_Namespace('terminal');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
     if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
     //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

     if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
      //if (isset($_POST['designation']) && $_POST['designation'] != "") {

      //$date_fin = new Zend_Date($_POST['date_fin']);
      //$date_fin->addDay(1);

      $detailcommande = new Application_Model_EuDetailCommandeMapper();
      $this->view->entries = $detailcommande->fetchAllByCommandeTegc($sessionterminal->code_membre, $sessionterminal->code_tegc, $_POST['date_debut'], $_POST['date_fin'], "");
      $this->view->entries2 = $detailcommande->fetchAllByCommandeTegc($sessionterminal->code_membre, $sessionterminal->code_tegc, $_POST['date_debut'], $_POST['date_fin'], "");

      //$this->view->select = $detailcommande->fetchAllByCommanderSelect($sessionterminal->code_membre, $_POST['designation'], $_POST['date_debut'], $_POST['date_fin'], $_POST['commander']);

          /*} else {
        $this->view->error = "Champs * obligatoire";
      }*/
}

    $this->view->tabletri = 1;
  }



  public function listarticlecommandetodayAction() {
     /* page terminal/listarticleachat - Liste des articles achats */
     $sessionterminal = new Zend_Session_Namespace('terminal');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
     if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
     //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_debut = $date_id->toString('yyyy-MM-dd');
        $date_fin = new Zend_Date($date_debut);
        $date_fin->addDay(1);
		$date_fin = $date_fin->toString('yyyy-MM-dd');

        $detailcommande = new Application_Model_EuDetailCommandeMapper();
        $this->view->entries = $detailcommande->fetchAllByCommandeTegc($sessionterminal->code_membre, $sessionterminal->code_tegc, $date_debut, $date_fin, 0);
        $this->view->tabletri = 1;
  }
  
  
  
  
  
  public function listarticlecommandetodayexcelAction() {
      /* page administration/listarticlecommandetodayexcel - exportation en excel */
      $sessionterminal = new Zend_Session_Namespace('terminal');
      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
      $date_id = new Zend_Date(Zend_Date::ISO_8601);
      $date_debut = $date_id->toString('yyyy-MM-dd');
      $date_fin = new Zend_Date($date_debut);
      $date_fin->addDay(1);
      $date_fin = $date_fin->toString('yyyy-MM-dd');

      $this->_redirect(Util_Utils::genererExcelCommandeToday($sessionterminal->code_membre,$sessionterminal->code_tegc,$date_debut,$date_fin,0));

  }
  
  
  
  


  public function listarticlecommandeexcelAction() {
      /* page administration/etatqopibanexcel - exportation en excel */
      $sessionterminal = new Zend_Session_Namespace('terminal');
      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
      $date_debut = (string)$this->_request->getParam('date_debut');
      $this->view->date_debut = $date_debut;
      $date_fin = (string)$this->_request->getParam('date_fin');
      $this->view->date_fin = $date_fin;
      $commander = (int)$this->_request->getParam('commander');
      $this->view->commander = $commander;

      //Util_Utils::genererExcelCommande($sessionterminal->code_membre, $date_debut, $date_fin, $sessionterminal->code_tegc, $commander);
      $this->_redirect(Util_Utils::genererExcelCommande($sessionterminal->code_membre, $date_debut, $date_fin, $sessionterminal->code_tegc, $commander));

  }
  
  
  public function listarticlecommandeexcelmailAction() {
      /* page administration/etatqopibanexcel - exportation en excel */
      $sessionterminal = new Zend_Session_Namespace('terminal');
      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
      $date_debut = (string)$this->_request->getParam('date_debut');
      $this->view->date_debut = $date_debut;
      $date_fin = (string)$this->_request->getParam('date_fin');
      $this->view->date_fin = $date_fin;
      $commander = (int)$this->_request->getParam('commander');
      $this->view->commander = $commander;

      //Util_Utils::genererExcelCommande($sessionterminal->code_membre, $date_debut, $date_fin, $sessionterminal->code_tegc, $commander);
      Util_Utils::genererExcelCommandemail($sessionterminal->code_membre, $date_debut, $date_fin, $sessionterminal->code_tegc, $commander);
      
	  $this->_redirect('/terminal/listarticlecommande');
  }







  public function addtariflivraisonAction() {
      /* page terminal/addtariflivraison - Ajout tariflivraison */
      $sessionterminal = new Zend_Session_Namespace('terminal');
      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
      if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
      //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

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


        if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
        if(isset($_POST['code_zone']) && $_POST['code_zone'] != "" && isset($_POST['id_pays']) && $_POST['id_pays'] != "" && isset($_POST['id_region']) && $_POST['id_region'] != "" && isset($_POST['id_prefecture']) && $_POST['id_prefecture'] != "" && isset($_POST['montant_tarif_livraison']) && $_POST['montant_tarif_livraison'] != "") {

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
          $tarif_livraison->setCode_membre($sessionterminal->code_membre);
          $tarif_livraison->setStatut(1);
          $m_tarif_livraison->save($tarif_livraison);

          //$this->_redirect('/terminal/listtariflivraison');
          $this->view->error = "Tarifs des articles enregistrés";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }




  public function edittariflivraisonAction()
  {
    /* page terminal/edittariflivraison - Modification d'une tariflivraison */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

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
          //$tarif_livraison->setCode_membre($sessionterminal->code_membre);
          //$tarif_livraison->setStatut(1);
          $m_tarif_livraison->update($tarif_livraison);

          $this->_redirect('/terminal/listtariflivraison');
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
    /* page terminal/listtariflivraison - Liste des tariflivraisons */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    $tarif_livraison = new Application_Model_EuTarifLivraisonMapper();
    $this->view->entries = $tarif_livraison->fetchAllByVendeur($sessionterminal->code_membre);

    $this->view->tabletri = 1;
  }


  public function statuttariflivraisonAction()
  {
    /* page terminal/statuttariflivraison - Statut un tariflivraison */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    $id = (int) $this->_request->getParam('id');
    if (isset($id) && $id != 0) {

    $tariflivraison = new Application_Model_EuTarifLivraison();
    $tariflivraisonM = new Application_Model_EuTarifLivraisonMapper();
    $tariflivraisonM->find($id, $tariflivraison);

    $tariflivraison->setStatut($this->_request->getParam('statut'));
    $tariflivraisonM->update($tariflivraison);
    }

    $this->_redirect('/terminal/listtariflivraison');
  }













  public function addarticlestockesadditifAction()
  {
    /* page terminal/addarticlestockesadditif - Ajout article additif */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
      if (isset($_POST['nom_article_stockes_additif']) && $_POST['nom_article_stockes_additif'] != "" && isset($_POST['reference']) && $_POST['reference'] != "") {

        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $article_stockes_additif = new Application_Model_EuArticleStockesAdditif();
        $m_article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();

        $compteur_id_article_additif = $m_article_stockes_additif->findConuter() + 1;

          $article_stockes_additif->setId_article_stockes_additif($compteur_id_article_additif);
          $article_stockes_additif->setNom_article_stockes_additif($_POST['nom_article_stockes_additif']);
          $article_stockes_additif->setReference($_POST['reference']);
          $article_stockes_additif->setCode_membre_morale($sessionterminal->code_membre);
          $article_stockes_additif->setEtat(1);
          $m_article_stockes_additif->save($article_stockes_additif);


          //$this->_redirect('/terminal/listarticlestockesadditif');
          $this->view->error = "Additif Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function listarticlestockesadditifAction()
  {
    /* page terminal/listarticlestockesadditif - Liste des articles additif*/

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    $article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();
    $this->view->entries = $article_stockes_additif->fetchAllByCodeMembreMoraleReference($sessionterminal->code_membre, "", "");

    $this->view->tabletri = 1;
  }


  public function etatarticlestockesadditifAction()
  {
    /* page terminal/publierarticle - Publier un article */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockes_additif = new Application_Model_EuArticleStockesAdditif();
      $m_article_stockes_additif = new Application_Model_EuArticleStockesAdditifMapper();
      $m_article_stockes_additif->find($id, $article_stockes_additif);


      $article_stockes_additif->setEtat($this->_request->getParam('etat'));
      $m_article_stockes_additif->update($article_stockes_additif);
    }

    $this->_redirect('/terminal/listarticlestockesadditif');
  }






  public function addarticlestockescategorieAction() {
         /* page terminal/addarticlestockescategorie - Ajout article categorie */

         $sessionterminal = new Zend_Session_Namespace('terminal');
         //$this->_helper->layout->disableLayout();
         $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
         if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
         //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

         if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
           if(isset($_POST['nom_article_stockes_categorie']) && $_POST['nom_article_stockes_categorie'] != "") {

            $date_id = new Zend_Date(Zend_Date::ISO_8601);

            $article_stockes_categorie = new Application_Model_EuArticleStockesCategorie();
            $m_article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();

            $compteur_id_article_categorie = $m_article_stockes_categorie->findConuter() + 1;

            $article_stockes_categorie->setId_article_stockes_categorie($compteur_id_article_categorie);
            $article_stockes_categorie->setNom_article_stockes_categorie($_POST['nom_article_stockes_categorie']);
            $article_stockes_categorie->setCode_membre_morale($sessionterminal->code_membre);
            $article_stockes_categorie->setEtat(1);
			$article_stockes_categorie->setCode_tegc($sessionterminal->code_tegc);
            $m_article_stockes_categorie->save($article_stockes_categorie);


            //$this->_redirect('/terminal/listarticlestockescategorie');
            $this->view->error = "Categorie Article enregistré";
        
      } else {
        $this->view->error = "Champs * obligatoire";
      }
    }
  }



  public function listarticlestockescategorieAction() {
     /* page terminal/listarticlestockescategorie - Liste des articles categorie*/
     $sessionterminal = new Zend_Session_Namespace('terminal');
     //$this->_helper->layout->disableLayout();
     $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
     if(!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
     //if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

     $article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();
     //$this->view->entries = $article_stockes_categorie->fetchAllByCodeMembreMorale($sessionterminal->code_membre, "");
     $this->view->entries = $article_stockes_categorie->fetchAllByTegc($sessionterminal->code_tegc,"");

     $this->view->tabletri = 1;
  }


  public function etatarticlestockescategorieAction() {
    /* page terminal/publierarticle - Publier un article */

            $sessionterminal = new Zend_Session_Namespace('terminal');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcint');
        
    if (!isset($sessionterminal->login)) {$this->_redirect('/terminal/login');}
//if($sessionterminal->confirmation != ""){$this->_redirect('/terminal/confirmation');}

    $id = (string) $this->_request->getParam('id');
    if ($id != "") {

      $article_stockes_categorie = new Application_Model_EuArticleStockesCategorie();
      $m_article_stockes_categorie = new Application_Model_EuArticleStockesCategorieMapper();
      $m_article_stockes_categorie->find($id, $article_stockes_categorie);


      $article_stockes_categorie->setEtat($this->_request->getParam('etat'));
      $m_article_stockes_categorie->update($article_stockes_categorie);
    }

    $this->_redirect('/terminal/listarticlestockescategorie');
  }





  





















}



