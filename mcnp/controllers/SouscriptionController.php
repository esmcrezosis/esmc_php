<?php

class SouscriptionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */	
        
    }

    public function loginAction()
    {
	$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!=""){

	$eusouscription = new Application_Model_DbTable_EuSouscription();
	$select = $eusouscription->select()->where('souscription_login = ?', $_POST['login'])
						  	  ->where('souscription_passe = ?', $_POST['pwd'])
							  ->where('publier = ?', 3);
	if ($rowseusouscription = $eusouscription->fetchRow($select)){
	
				 $sessionsouscription->souscription_id = $rowseusouscription->souscription_id;
				 $sessionsouscription->souscription_nom = $rowseusouscription->souscription_nom;
				 $sessionsouscription->souscription_prenom = $rowseusouscription->souscription_prenom;
				 $sessionsouscription->souscription_mobile = $rowseusouscription->souscription_mobile;
				 $sessionsouscription->souscription_membreasso = $rowseusouscription->souscription_membreasso;
				 $sessionsouscription->souscription_email = $rowseusouscription->souscription_email;
				 $sessionsouscription->login = $rowseusouscription->souscription_login;
				 $sessionsouscription->souscription_passe = $rowseusouscription->souscription_passe;
				 $sessionsouscription->souscription_type = $rowseusouscription->souscription_type;
				 $sessionsouscription->souscription_date = $rowseusouscription->souscription_date;
				 $sessionsouscription->publier = $rowseusouscription->publier;
				 $sessionsouscription->souscription_personne = $rowseusouscription->souscription_personne;
				 $sessionsouscription->souscription_souscription = $rowseusouscription->souscription_souscription;
				 $sessionsouscription->souscription_programme = $rowseusouscription->souscription_programme;
				 $sessionsouscription->souscription_type_candidat = $rowseusouscription->souscription_type_candidat;



        $codeactivation_m = new Application_Model_EuCodeActivationMapper();
		$codeactivation = $codeactivation_m->fetchAllBySouscription($rowseusouscription->souscription_id);		
if(count($codeactivation) > 0){
				 $sessionsouscription->code_membre = $codeactivation->code_membre;
	}else{
				 $sessionsouscription->code_membre = "";
		}






				 $sessionsouscription->errorlogin = "";
    $this->_redirect('/souscription');
	} else { $sessionsouscription->errorlogin = "Login ou Mot de Passe Erroné"; }
    $this->_redirect('/souscription/login');
	} else { $sessionsouscription->errorlogin = "Saisir Login et Mot de Passe"; } 
    $this->_redirect('/souscription/login');
	}

    }

    public function passwordAction() {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['ancien']) && $_POST['ancien'] != "" && isset($_POST['nouveau']) && $_POST['nouveau'] != "" && isset($_POST['confirmer']) && $_POST['confirmer'] == $_POST['nouveau']) {

                    $eusouscription = new Application_Model_DbTable_EuSouscription();
                    $select = $eusouscription->select()->where('souscription_login = ?', $sessionsouscription->login);
                    $select->where('souscription_passe = ?', $_POST['ancien']);
                    $select->order(array("souscription_id ASC"));
                    $select->limit(1);
                    if ($rowseusouscription = $eusouscription->fetchRow($select)) {
                        $mapper = new Application_Model_EuSouscriptionMapper();
                        $souscription = new Application_Model_EuSouscription();
                        $mapper->find($sessionsouscription->souscription_id, $souscription);
                        $souscription->setSouscription_passe($_POST['nouveau']);
                        $mapper->update($souscription);
                        $this->view->error = "Modification effectuée";
                    }
            } else {
                $this->view->error = "Saisir tous les champs";
            }
            //$this->_redirect('/index/mcnp');
        }
    }

    function nocompteAction()
    {
	Zend_Session::destroy(true);
    $this->_redirect('/souscription/login');
    }




    public function indexAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}


    }






    public function addmembretiersAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}
		


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['membretiers_mobile']) && $_POST['membretiers_mobile']!="" && isset($_POST['membretiers_nom']) && $_POST['membretiers_nom']!="" && isset($_POST['membretiers_prenom']) && $_POST['membretiers_prenom']!="") {
		
		
			
			
        $date_id = Zend_Date::now();

        $membretiers = new Application_Model_EuMembretiers();
        $membretiers_mapper = new Application_Model_EuMembretiersMapper();
		
			
            $compteur_membretiers = $membretiers_mapper->findConuter() + 1;
            $membretiers->setMembretiers_id($compteur_membretiers);
            $membretiers->setMembretiers_nom($_POST['membretiers_nom']);
            $membretiers->setMembretiers_prenom($_POST['membretiers_prenom']);
            $membretiers->setMembretiers_email($_POST['membretiers_email']);
            $membretiers->setMembretiers_mobile($_POST['membretiers_mobile']);
            $membretiers->setMembretiers_souscription($_POST['membretiers_souscription']);
            //$membretiers->setMembretiers_filiere($_POST['membretiers_filiere']);
            $membretiers->setMembretiers_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $membretiers->setCode_activite($_POST["code_activite"]);
            $membretiers->setId_metier($_POST["id_metier"]);
            $membretiers->setId_competence($_POST["id_competence"]);
            $membretiers->setMembretiers_ville($_POST['membretiers_ville']);
            $membretiers->setMembretiers_quartier($_POST['membretiers_quartier']);
            $membretiers->setPublier(0);
            $membretiers_mapper->save($membretiers);
			
			
			$membretierscode_code = strtoupper(Util_Utils::genererCodeSMS(10));
			
        $membretierscode = new Application_Model_EuMembretierscode();
        $membretierscode_mapper = new Application_Model_EuMembretierscodeMapper();
            $compteur_membretierscode = $membretierscode_mapper->findConuter() + 1;
            $membretierscode->setMembretierscode_id($compteur_membretierscode);
            $membretierscode->setMembretierscode_membretiers($compteur_membretiers);
            $membretierscode->setMembretierscode_code($membretierscode_code);
            $membretierscode->setMembretierscode_souscription($_POST['membretiers_souscription']);
            $membretierscode->setPublier(0);
            $membretierscode_mapper->save($membretierscode);
		

		$this->_redirect('/souscription/listmembretiers/id/'.$_POST['membretiers_souscription']);/**/
		} else {  $this->view->error = "Champs * obligatoire ...";  
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
		
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($id, $a);
		
        $mas = new Application_Model_EuMembretiersMapper();
		$as = $mas->fetchAllBySouscription($id);		
		
		if(count($as) < ($a->souscription_nombre - $a->souscription_autonome)){
		$this->view->souscription = $a;
		}else{
		$this->_redirect('/souscription');/**/
			}
            }
			}
	} else {
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
		
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($id, $a);
		
        $mas = new Application_Model_EuMembretiersMapper();
		$as = $mas->fetchAllBySouscription($id);		
		
		if(count($as) < ($a->souscription_nombre - $a->souscription_autonome)){
		$this->view->souscription = $a;
		}else{
		$this->_redirect('/souscription');/**/
			}
            }
		}
	 
	}



    public function editmembretiersAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['membretiers_mobile']) && $_POST['membretiers_mobile']!="" && isset($_POST['membretiers_nom']) && $_POST['membretiers_nom']!="" && isset($_POST['membretiers_prenom']) && $_POST['membretiers_prenom']!="") {
		
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $membretiers = new Application_Model_EuMembretiers();
        $m_membretiers = new Application_Model_EuMembretiersMapper();
		$m_membretiers->find($_POST['membretiers_id'], $membretiers);
			
			
            $membretiers->setMembretiers_nom($_POST['membretiers_nom']);
            $membretiers->setMembretiers_prenom($_POST['membretiers_prenom']);
            $membretiers->setMembretiers_email($_POST['membretiers_email']);
            $membretiers->setMembretiers_mobile($_POST['membretiers_mobile']);
            //$membretiers->setMembretiers_souscription($_POST['membretiers_souscription']);
            //$membretiers->setMembretiers_filiere($_POST['membretiers_filiere']);
            //$membretiers->setMembretiers_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $membretiers->setCode_activite($_POST["code_activite"]);
            $membretiers->setId_metier($_POST["id_metier"]);
            $membretiers->setId_competence($_POST["id_competence"]);
            $membretiers->setMembretiers_ville($_POST['membretiers_ville']);
            $membretiers->setMembretiers_quartier($_POST['membretiers_quartier']);
            $m_membretiers->update($membretiers);
			
		$this->_redirect('/souscription/listmembretiers/id/'.$membretiers->membretiers_souscription);
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMembretiers();
        $ma = new Application_Model_EuMembretiersMapper();
		$ma->find($id, $a);
		$this->view->membretiers = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMembretiers();
        $ma = new Application_Model_EuMembretiersMapper();
		$ma->find($id, $a);
		$this->view->membretiers = $a;
            }
	}
	}



    public function listmembretiersAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $membretiers = new Application_Model_EuMembretiersMapper();
        $this->view->entries = $membretiers->fetchAllBySouscription($id);

        $this->view->tabletri = 1;
			}else{
		$this->_redirect('/souscription');
				}

    }

	
    public function publiermembretiersAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $membretiers = new Application_Model_EuMembretiers();
        $membretiersM = new Application_Model_EuMembretiersMapper();
        $membretiersM->find($id, $membretiers);
		
        $membretiers->setPublier($this->_request->getParam('publier'));
		$membretiersM->update($membretiers);
        }

		$this->_redirect('/souscription/listmembretiers/id/'.$membretiers->membretiers_souscription);
    }




    public function suppmembretiersAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $membretiers = new Application_Model_EuMembretiers();
        $membretiersM = new Application_Model_EuMembretiersMapper();
        $membretiersM->find($id, $membretiers);
		
        $membretierscodeM = new Application_Model_EuMembretierscodeMapper();
        $membretierscode = $membretierscodeM->fetchAllBySouscriptionMembretiers($membretiers->membretiers_souscription, $membretiers->membretiers_id);
        $membretierscodeM->delete($membretierscode->membretierscode_id);
		
        $membretiersM->delete($membretiers->membretiers_id);

        }

		$this->_redirect('/souscription/listmembretiers/id/'.$membretiers->membretiers_souscription);
    }



    public function detailsmembretiersAction() {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $membretiers = new Application_Model_EuMembretiers();
        $membretiersM = new Application_Model_EuMembretiersMapper();
        $membretiersM->find($id, $membretiers);
		$this->view->membretiers = $membretiers;

            }

	}

    public function codegenerermembretiersAction() {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);

        $mas = new Application_Model_EuMembretiersMapper();
		$as = $mas->fetchAllBySouscription($id);		
		
		if($souscription->souscription_autonome == 1){
		$nombre = $souscription->souscription_nombre - count($as) - $souscription->souscription_autonome;
			}else{
		$nombre = $souscription->souscription_nombre - count($as);
				}
				
		for($i = 0; $i < $nombre; $i++){
			
			$membretierscode_code = strtoupper(Util_Utils::genererCodeSMS(10));
			
        $membretierscode = new Application_Model_EuMembretierscode();
        $membretierscode_mapper = new Application_Model_EuMembretierscodeMapper();
            $compteur_membretierscode = $membretierscode_mapper->findConuter() + 1;
            $membretierscode->setMembretierscode_id($compteur_membretierscode);
            $membretierscode->setMembretierscode_membretiers(0);
            $membretierscode->setMembretierscode_code($membretierscode_code);
            $membretierscode->setMembretierscode_souscription($id);
            $membretierscode->setPublier(0);
            $membretierscode_mapper->save($membretierscode);

			}

		$this->_redirect('/souscription/listmembretierscode/id/'.$id);

            }

	}


    public function listmembretierscodeAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $membretierscode = new Application_Model_EuMembretierscodeMapper();
        $this->view->entries = $membretierscode->fetchAllBySouscription($id);
        $this->view->tabletri = 1;
			}

    }
	


    public function listsouscription2Action()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
		
        $entries1 = $souscription->fetchAllBySouscription($sessionsouscription->souscription_souscription);
		
        $this->view->entries = $souscription->fetchAllBySouscriptionSouscription($entries1->souscription_souscription);

        $this->view->tabletri = 1;

    }
	
    public function listsouscription3Action()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
		
        $entries1 = $souscription->fetchAllBySouscription($sessionsouscription->souscription_souscription);
		
        $this->view->entries = $souscription->fetchAllBySouscriptionSouscription($entries1->souscription_souscription);

        $this->view->tabletri = 1;

    }
	
    public function listsouscription4Action()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
		
        $entries1 = $souscription->fetchAllBySouscription($sessionsouscription->souscription_souscription);
		
        $this->view->entries = $souscription->fetchAllBySouscriptionSouscription($entries1->souscription_souscription);

        $this->view->tabletri = 1;

    }
	
    public function listsouscription5Action()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
		
        $entries1 = $souscription->fetchAllBySouscription($sessionsouscription->souscription_souscription);
		
        $this->view->entries = $souscription->fetchAllBySouscriptionSouscription($entries1->souscription_souscription);

        $this->view->tabletri = 1;

    }
	
    public function listsouscription6Action()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
		
        $entries1 = $souscription->fetchAllBySouscription($sessionsouscription->souscription_souscription);
		
        $this->view->entries = $souscription->fetchAllBySouscriptionSouscription($entries1->souscription_souscription);

        $this->view->tabletri = 1;

    }
	
    public function listsouscription31Action()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllByAssociation($sessionsouscription->souscription_souscription);

        $this->view->tabletri = 1;

    }




    public function addcaracteristiqueAction()
    {
        /* page souscription/addcaracteristique - Ajout d'un caracteristique */

		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['caracteristique_libelle']) && $_POST['caracteristique_libelle']!="") {
		
            $caracteristique_type = (int)$this->_request->getParam('type');



		include("Transfert.php");
		if(isset($_FILES['caracteristique_fichier']['name']) && $_FILES['caracteristique_fichier']['name']!=""){
		$chemin	= "caracteristiques";
		$file = $_FILES['caracteristique_fichier']['name'];
		$file1='caracteristique_fichier';
		$caracteristique = $chemin."/".transfert($chemin,$file1);
		} else {$caracteristique = "";}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuCaracteristique();
        $ma = new Application_Model_EuCaracteristiqueMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setCaracteristique_id($compteur);
            $a->setCaracteristique_type($caracteristique_type);
            $a->setCaracteristique_libelle($_POST['caracteristique_libelle']);
            $a->setCaracteristique_description($_POST['caracteristique_description']);
            $a->setCaracteristique_fichier($caracteristique);
            $a->setCaracteristique_souscription($sessionsouscription->souscription_id);
            $a->setCaracteristique_date($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
			
		$this->_redirect('/souscription/listcaracteristique');
		} else {  $this->view->error = "Champs * obligatoire ...";  } 
		}
		
    }


    public function editcaracteristiqueAction()
    {
        /* page souscription/editcaracteristique - Modification d'un caracteristique */

		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['caracteristique_libelle']) && $_POST['caracteristique_libelle']!="") {
		
		include("Transfert.php");
		if(isset($_FILES['caracteristique_fichier']['name']) && $_FILES['caracteristique_fichier']['name']!=""){
		$chemin	= "caracteristiques";
		$file = $_FILES['caracteristique_fichier']['name'];
		$file1='caracteristique_fichier';
		$caracteristique = $chemin."/".transfert($chemin,$file1);
		} else {$caracteristique = $_POST['caracteristique_fichier_old'];}
			
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuCaracteristique();
        $ma = new Application_Model_EuCaracteristiqueMapper();
		$ma->find($_POST['caracteristique_id'], $a);
			
            $a->setCaracteristique_libelle($_POST['caracteristique_libelle']);
            $a->setCaracteristique_description($_POST['caracteristique_description']);
            $a->setCaracteristique_fichier($caracteristique);
            $ma->update($a);
			
		$this->_redirect('/souscription/listcaracteristique');
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuCaracteristique();
        $ma = new Application_Model_EuCaracteristiqueMapper();
		$ma->find($id, $a);
		$this->view->caracteristique = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuCaracteristique();
        $ma = new Application_Model_EuCaracteristiqueMapper();
		$ma->find($id, $a);
		$this->view->caracteristique = $a;
            }
	}
	}




    public function listcaracteristiqueAction()
    {
        /* page souscription/listcaracteristique - Liste des caracteristiques */

		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $caracteristique = new Application_Model_EuCaracteristiqueMapper();
        $this->view->entries = $caracteristique->fetchAll4($sessionsouscription->souscription_souscription);

        $this->view->tabletri = 1;

    }


    public function suppcaracteristiqueAction()
    {
        /* page souscription/suppcaracteristique - Suppression d'un caracteristique */

		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $caracteristique = new Application_Model_EuCaracteristique();
        $caracteristiqueM = new Application_Model_EuCaracteristiqueMapper();
        $caracteristiqueM->find($id, $caracteristique);
		
        $caracteristiqueM->delete($caracteristique->caracteristique_id);
		//unlink($caracteristique->caracteristique_fichier);	

        }

		$this->_redirect('/souscription/listcaracteristique');
    }







	
    public function listsouscriptioncmfhAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $type = (int) $this->_request->getParam('type');
        if ($type != 0) {
				
        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllBySouscriptionTypeCandidat($type);
		$this->view->type = $type;
        $this->view->tabletri = 1;
        }else{
		$this->_redirect('/souscription');
			}

    }



	
    public function listsouscriptioncmfhrechercheAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

        $type = (int) $this->_request->getParam('type');
        if ($type != 0) {
		$this->view->type = $type;

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['debut']) && $_POST['debut']!="" && isset($_POST['fin']) && $_POST['fin']!="") {
				
        $souscription = new Application_Model_EuSouscriptionMapper();
        $this->view->entries = $souscription->fetchAllBySouscriptionTypeCandidatRecherche($_POST['type'], $_POST['debut'], $_POST['fin']);

        $this->view->tabletri = 1;
	}
	}
        }/*else{
		$this->_redirect('/administration');
			}*/

    }




    public function addcodegenerermembretiersAction() {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['membretiers_mobile']) && $_POST['membretiers_mobile']!="") {
		
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($_POST['souscription_id'], $souscription);

        $mas = new Application_Model_EuMembretierscodeMapper();
		$as = $mas->fetchAllBySouscription($_POST['souscription_id']);		
		
		if($souscription->souscription_autonome == 1){
		$nombre = $souscription->souscription_nombre - count($as) - $souscription->souscription_autonome;
			}else{
		$nombre = $souscription->souscription_nombre - count($as);
				}

if($nombre > 0){
						$membretierscode_code = strtoupper(Util_Utils::genererCodeSMS(10));
			
        $membretierscode = new Application_Model_EuMembretierscode();
        $membretierscode_mapper = new Application_Model_EuMembretierscodeMapper();
            $compteur_membretierscode = $membretierscode_mapper->findConuter() + 1;
            $membretierscode->setMembretierscode_id($compteur_membretierscode);
            $membretierscode->setMembretierscode_membretiers(0);
            $membretierscode->setMembretierscode_code($membretierscode_code);
            $membretierscode->setMembretierscode_souscription($souscription->souscription_id);
            $membretierscode->setPublier(0);
            $membretierscode_mapper->save($membretierscode);
			
			
			if($souscription->souscription_personne = "PP"){
				
				}else{
					
					}
			
			
			
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $_POST['membretiers_mobile'], "Bonjour, ");
			

		$this->_redirect('/souscription/listmembretierscode/id/'.$id);
	}
		} else {  $this->view->error = "Champs * obligatoire ..."; 
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		$this->view->caracteristique = $a;
            }
	}
		   
	} else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $souscription = new Application_Model_EuSouscription();
        $souscriptionM = new Application_Model_EuSouscriptionMapper();
        $souscriptionM->find($id, $souscription);
		$this->view->caracteristique = $a;
            }
	}
	
	
	
	}



	
    public function listdepotventeAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}

				
        $depotvente = new Application_Model_EuDepotVenteMapper();
        $this->view->entries = $depotvente->findbycmfh($sessionsouscription->code_membre);

        $this->view->tabletri = 1;

    }



    public function addmembretierscodeAction()
    {
		$sessionsouscription = new Zend_Session_Namespace('souscription');
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	if (!isset($sessionsouscription->login)) {$this->_redirect('/souscription/login');}
		


	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['membretiers_mobile']) && $_POST['membretiers_mobile']!="" && isset($_POST['membretiers_nom']) && $_POST['membretiers_nom']!="" && isset($_POST['membretiers_prenom']) && $_POST['membretiers_prenom']!="") {
		
		
			
			
        $date_id = Zend_Date::now();

        $membretiers = new Application_Model_EuMembretiers();
        $membretiers_mapper = new Application_Model_EuMembretiersMapper();
		
			
            $compteur_membretiers = $membretiers_mapper->findConuter() + 1;
            $membretiers->setMembretiers_id($compteur_membretiers);
            $membretiers->setMembretiers_nom($_POST['membretiers_nom']);
            $membretiers->setMembretiers_prenom($_POST['membretiers_prenom']);
            $membretiers->setMembretiers_email($_POST['membretiers_email']);
            $membretiers->setMembretiers_mobile($_POST['membretiers_mobile']);
            $membretiers->setMembretiers_souscription($_POST['membretiers_souscription']);
            //$membretiers->setMembretiers_filiere($_POST['membretiers_filiere']);
            $membretiers->setMembretiers_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $membretiers->setCode_activite($_POST["code_activite"]);
            $membretiers->setId_metier($_POST["id_metier"]);
            $membretiers->setId_competence($_POST["id_competence"]);
            $membretiers->setMembretiers_ville($_POST['membretiers_ville']);
            $membretiers->setMembretiers_quartier($_POST['membretiers_quartier']);
            $membretiers->setPublier(0);
            $membretiers_mapper->save($membretiers);
			
			
			$membretierscode_code = strtoupper(Util_Utils::genererCodeSMS(10));
			
        $membretierscode = new Application_Model_EuMembretierscode();
        $membretierscode_mapper = new Application_Model_EuMembretierscodeMapper();
            $compteur_membretierscode = $membretierscode_mapper->findConuter() + 1;
            $membretierscode->setMembretierscode_id($compteur_membretierscode);
            $membretierscode->setMembretierscode_membretiers($compteur_membretiers);
            $membretierscode->setMembretierscode_code($membretierscode_code);
            $membretierscode->setMembretierscode_souscription($_POST['membretiers_souscription']);
            $membretierscode->setPublier(0);
            $membretierscode_mapper->save($membretierscode);
		

		$this->_redirect('/souscription/listmembretiers/id/'.$_POST['membretiers_souscription']);/**/
		} else {  $this->view->error = "Champs * obligatoire ...";  
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
		
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($id, $a);
		
        $mas = new Application_Model_EuMembretiersMapper();
		$as = $mas->fetchAllBySouscription($id);		
		
		if(count($as) < ($a->souscription_nombre - $a->souscription_autonome)){
		$this->view->souscription = $a;
		}else{
		$this->_redirect('/souscription');/**/
			}
            }
			}
	} else {
		 
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
		
        $a = new Application_Model_EuSouscription();
        $ma = new Application_Model_EuSouscriptionMapper();
		$ma->find($id, $a);
		
        $mas = new Application_Model_EuMembretiersMapper();
		$as = $mas->fetchAllBySouscription($id);		
		
		if(count($as) < ($a->souscription_nombre - $a->souscription_autonome)){
		$this->view->souscription = $a;
		}else{
		$this->_redirect('/souscription');/**/
			}
            }
		}
	 
	}










}



