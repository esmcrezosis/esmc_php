<?php

class BanqueopiController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */	
        
    }


    public function confirmationAction() 
    {
        /* page banqueopi/confirmation - Confirmation d'accès a cet espace d'banqueopi */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

            if(!isset($sessionbanqueopi->fois)){
                $sessionbanqueopi->fois = 0;
            }

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['confirme']) && $_POST['confirme'] != "" && $_POST['confirme'] == $sessionbanqueopi->confirmation) {

                 $sessionbanqueopi->confirmation = "";
            $this->_redirect('/banqueopi');

            } else {
                $sessionbanqueopi->error = "Erreur de Code de confirmation";
                $sessionbanqueopi->fois += 1;
                if($sessionbanqueopi->fois < 3){
            $this->_redirect('/banqueopi/confirmation');
                }else{
                $sessionbanqueopi->fois = 0;
            $this->_redirect('/banqueopi/nocompte');        
                }

            }
            //$this->_redirect('/banqueopi');
        }
    }


	
	public  function secureloginAction()  {
		$sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        $this->_helper->layout->disableLayout();
        //$this->_helper->layout()->setLayout('layoutpublicesmc');
		
		if(isset($_POST['ok']) && $_POST['ok']=="ok") {
		  if(isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!="") {
		
		       $eubanqueuser = new Application_Model_DbTable_EuBanqueUser();
	           $select = $eubanqueuser->select()->where('login_banque_user = ?', $_POST['login'])
						  	                    ->where('pwd_banque_user = ?', $_POST['pwd'])
							                    ->where('activer = ?', 1)
                                                ;
												
	           if($rowseubanqueuser = $eubanqueuser->fetchRow($select)) {
				     $sessionbanqueopi->id_banque_user = $rowseubanqueuser->id_banque_user;
				     $sessionbanqueopi->code_banque = $rowseubanqueuser->code_banque;
				     $sessionbanqueopi->nom_banque_user = $rowseubanqueuser->nom_banque_user;
				     $sessionbanqueopi->prenom_banque_user = $rowseubanqueuser->prenom_banque_user;
				     //$sessionbanqueopi->login = $rowseubanqueuser->login_banque_user;
				     $sessionbanqueopi->passe = $rowseubanqueuser->pwd_banque_user;
				     $sessionbanqueopi->activer = $rowseubanqueuser->activer;
				     $sessionbanqueopi->pwd_changed = $rowseubanqueuser->pwd_changed;
				     $sessionbanqueopi->date_created = $rowseubanqueuser->date_created;
				     $sessionbanqueopi->id_utilisateur = $rowseubanqueuser->id_utilisateur;
				     $sessionbanqueopi->role = $rowseubanqueuser->role;
                     $sessionbanqueopi->login_banque_user = $rowseubanqueuser->login_banque_user;
                     $sessionbanqueopi->pwd_banque_user = $rowseubanqueuser->pwd_banque_user;
                     $sessionbanqueopi->code_membre = $rowseubanqueuser->code_membre; 

					 if(substr($sessionbanqueopi->code_membre, -1) == "P") {
					    $m_membre = new Application_Model_EuMembreMapper();
					    $membre = new Application_Model_EuMembre();
					    $retour = $m_membre->find($sessionbanqueopi->code_membre, $membre);
                     }
                     else if (substr($sessionbanqueopi->code_membre, -1) == "M") {
					    $m_membre = new Application_Model_EuMembreMoraleMapper();
					    $membre = new Application_Model_EuMembreMorale();
					    $retour = $m_membre->find($sessionbanqueopi->code_membre, $membre);
			         }
					 
					 $sessionbanqueopi->desactiver = $membre->desactiver;
					 
					 if($membre->desactiver == 0) {
                         $sessionbanqueopi->confirmation = strtoupper(Util_Utils::genererCodeSMS(5));
					 
                         $os = Util_Utils::getOS();
                         $infos =  Util_Utils::detecterSysteme();
                         $texte_confirmation = "Confirmez vous la Tentative de connection à votre compte de Banque ESMC depuis un navigateur ".$infos['browser']." sous ".$os." ?";

					     $table = new Application_Model_DbTable_EuConfirmation();
                         $entryObject = new Application_Model_EuConfirmation();
                         $mapper = new Application_Model_EuConfirmationMapper();

                         $db = Zend_Db_Table::getDefaultAdapter();

                         $entryObject->setType_confirmation("2")
                                 ->setCode_operateur($rowseubanqueuser->login_banque_user)
                                 ->setNom_operateur("")
                                 ->setData_text($texte_confirmation)
                                 ->setData_json("")
                                 ->setActivite("https://esmcgie.com/banqueopi/securelogin")
                                 ->setStatus("2")
                                 ->setDate_creation(time())
                                 ->setDate_confirmation("")
                                 ->setTexte_confirmation($texte_confirmation)
                                 ->setPage("banqueopi/securelogin")
                                 ->setCode_sms($sessionbanqueopi->confirmation)
                                 ->setNom_appareil("")
                                 ->setImei_appareil("")
                                 ->setNumero_appareil("")
                                 ->setMac_appareil("")
                                 ->setIp_appareil("")
                                 ->setCode_membre($sessionbanqueopi->code_membre);
                         $mapper->save($entryObject);
               
                         $numero_insertion = $db->lastInsertId();

                         $sessionbanqueopi->numero_confirmation = $numero_insertion;

                         Util_Utils::envoiNotificationAdministrationBiometrique(""+$numero_insertion,$sessionbanqueopi->code_membre,"Banque ESMC",$texte_confirmation ,$sessionbanqueopi->confirmation);
                         $sessionbanqueopi->errorlogin = "";
					  
				 } else {
				      $sessionbanqueopi->errorlogin = "Veuillez procéder à la nouvelle activation de votre compte marchand ...";
                      $this->_redirect('/banqueopi/securelogin');
			     }
					 
			   }  else { $sessionbanqueopi->errorlogin = "Login ou Mot de Passe Erroné"; $this->_redirect('/banqueopi/login');}
			      
		  }   else { $sessionbanqueopi->errorlogin = "Saisir Login et Mot de Passe"; $this->_redirect('/banqueopi/login');} 
              
		}
	}
	
	

    public function loginAction() {
        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
        //if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
        //if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
		
        {$this->_redirect('/banqueopi/securelogin');}
		
		
        /*
	    if(isset($_POST['ok']) && $_POST['ok']=="ok") {
	      if(isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!=""){

	      $eubanqueuser = new Application_Model_DbTable_EuBanqueUser();
	      $select = $eubanqueuser->select()->where('login_banque_user = ?', $_POST['login'])
						  	     ->where('pwd_banque_user = ?', $_POST['pwd'])
							     ->where('activer = ?', 1);
	      if($rowseubanqueuser = $eubanqueuser->fetchRow($select)){
	
				 $sessionbanqueopi->id_banque_user = $rowseubanqueuser->id_banque_user;
				 $sessionbanqueopi->code_banque = $rowseubanqueuser->code_banque;
				 $sessionbanqueopi->nom_banque_user = $rowseubanqueuser->nom_banque_user;
				 $sessionbanqueopi->prenom_banque_user = $rowseubanqueuser->prenom_banque_user;
				 $sessionbanqueopi->login = $rowseubanqueuser->login_banque_user;
				 $sessionbanqueopi->passe = $rowseubanqueuser->pwd_banque_user;
				 $sessionbanqueopi->activer = $rowseubanqueuser->activer;
				 $sessionbanqueopi->pwd_changed = $rowseubanqueuser->pwd_changed;
				 $sessionbanqueopi->date_created = $rowseubanqueuser->date_created;
				 $sessionbanqueopi->id_utilisateur = $rowseubanqueuser->id_utilisateur;
				 $sessionbanqueopi->role = $rowseubanqueuser->role;
                 $sessionbanqueopi->login_banque_user = $rowseubanqueuser->login_banque_user;
                 $sessionbanqueopi->pwd_banque_user = $rowseubanqueuser->pwd_banque_user;
                 $sessionbanqueopi->code_membre = $rowseubanqueuser->code_membre;





            $sessionbanqueopi->confirmation = strtoupper(Util_Utils::genererCodeSMS(5));   
            
        $banque_telephone = new Application_Model_EuBanqueTelephoneMapper();
        $entries = $banque_telephone->fetchAllByCodeBanqueUser($sessionbanqueopi->code_banque, 1, $rowseubanqueuser->id_banque_user);
        foreach ($entries as $entry){
                $compteur = Util_Utils::findConuter() + 1; 
                Util_Utils::addSms($compteur, $entry->telephone, "Voici votre code de confirmation: ".$sessionbanqueopi->confirmation.". Veuillez le saisir dans le champ correspondant. Merci");        
        }


				 $sessionbanqueopi->errorlogin = "";
    $this->_redirect('/banqueopi');
	} else { $sessionbanqueopi->errorlogin = "Login ou Mot de Passe Erroné"; }
    $this->_redirect('/banqueopi/login');
	} else { $sessionbanqueopi->errorlogin = "Saisir Login et Mot de Passe"; } 
    $this->_redirect('/banqueopi/login');
	}
	*/

    }
	
	

    public function passwordAction() {
	    $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
        if(!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
        //if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
		
	    if(!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
          if (isset($_POST['ancien']) && $_POST['ancien'] != "" && isset($_POST['nouveau']) && $_POST['nouveau'] != "" && isset($_POST['confirmer']) && $_POST['confirmer'] == $_POST['nouveau']) {

                    $eubanqueuser = new Application_Model_DbTable_EuBanqueUser();
                    $select = $eubanqueuser->select()->where('login_banque_user = ?', $sessionbanqueopi->login);
                    $select->where('pwd_banque_user = ?', $_POST['ancien']);
                    $select->order(array("id_banque_user ASC"));
                    $select->limit(1);
                    if ($rowseubanqueuser = $eubanqueuser->fetchRow($select)) {
                        $mapper = new Application_Model_EuBanqueUserMapper();
                        $banqueuser = new Application_Model_EuBanqueUser();
                        $mapper->find($sessionbanqueopi->id_banque_user, $banqueuser);
                        $banqueuser->setPwdBanqueUser($_POST['nouveau']);
                        $mapper->update($banqueuser);
                        $this->view->error = "Modification effectuée";
                    }
            } else {
                $this->view->error = "Saisir tous les champs";
            }
            //$this->_redirect('/index/mcnp');
        }
    }
	
	
	

    function nocompteAction() {
	   Zend_Session::destroy(true);
       $this->_redirect('/banqueopi/login');
    }
	
	
	function logoutAction() {
	   Zend_Session::destroy(true);
       $this->_redirect('/banqueopi/login');
    }




    public function indexAction() {
	    $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
        if(!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
        //if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
		
	    if(!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
    }




    public function addtelephoneAction() {
        /* page espacepersonnel/addtelephone - Ajout telephone */
	    $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
        if(!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
        //if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
		
	    if(!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if(isset($_POST['telephone']) && $_POST['telephone'] != "") {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);

                $banque_telephone = new Application_Model_EuBanqueTelephone();
                $m_banque_telephone = new Application_Model_EuBanqueTelephoneMapper();

                $compteur = $m_banque_telephone->findConuter() + 1;

                $banque_telephone->setId_telephone($compteur);
                $banque_telephone->setTelephone($_POST['telephone']);
                $banque_telephone->setCode_banque($sessionbanqueopi->code_banque);
                $banque_telephone->setStatus(0);
                $banque_telephone->setId_banque_user($sessionbanqueopi->id_banque_user);
                $m_banque_telephone->save($banque_telephone);

                $this->_redirect('/banqueopi/listtelephone');
                $this->view->error = "Numéro telephone enregistré";
                
            } else {
                $this->view->error = "Champs * obligatoire";
            }
        }
    }




    public function edittelephoneAction() {
        /* page espacepersonnel/edittelephone - Editer telephone */

	    $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
        if(!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
        //if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
		
	    if(!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        if(isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if(isset($_POST['telephone']) && $_POST['telephone'] != "") {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);

                $banque_telephone = new Application_Model_EuBanqueTelephone();
                $m_banque_telephone = new Application_Model_EuBanqueTelephoneMapper();

                $m_banque_telephone->find($_POST['id_telephone'], $banque_telephone);

                $banque_telephone->setTelephone($_POST['telephone']);
                    //$banque_telephone->setCode_banque($sessionbanqueopi->code_banque);
                    //$banque_telephone->setId_banque_user($sessionbanqueopi->id_banque_user);
                    $m_banque_telephone->update($banque_telephone);

                    $this->_redirect('/banqueopi/listtelephone');
                    $this->view->error = "Numéro telephone corrigé";
                
            } else {
                $this->view->error = "Champs * obligatoire";

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $a = new Application_Model_EuBanqueTelephone();
        $ma = new Application_Model_EuBanqueTelephoneMapper();
        $ma->find($id, $a);
        $this->view->banque_telephone = $a;
            }
            }
        }else {

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $a = new Application_Model_EuBanqueTelephone();
        $ma = new Application_Model_EuBanqueTelephoneMapper();
        $ma->find($id, $a);
        $this->view->banque_telephone = $a;
            }
            }
    }



    public function listtelephoneAction()
    {
        /* page espacepersonnel/listtelephone - Liste des telephones */

	        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
		
	if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        $banque_telephone = new Application_Model_EuBanqueTelephoneMapper();
if($sessionbanqueopi->role == "B_ADMIN") {
        $this->view->entries = $banque_telephone->fetchAllByCodeBanqueUser($sessionbanqueopi->code_banque, 0, 0);
    }else{
        $this->view->entries = $banque_telephone->fetchAllByCodeBanqueUser($sessionbanqueopi->code_banque, 0, $sessionbanqueopi->id_banque_user);
    }

        $this->view->tabletri = 1;
    }






    public function statustelephoneAction()
    {
        /* page banqueopi/statustelephone - Publier la telephone libre d'information */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $banque_telephone = new Application_Model_EuBanqueTelephone();
        $banque_telephoneM = new Application_Model_EuBanqueTelephoneMapper();
        $banque_telephoneM->find($id, $banque_telephone);
        
        $banque_telephone->setStatus($this->_request->getParam('status'));
        $banque_telephoneM->update($banque_telephone);
        }

        $this->_redirect('/banqueopi/listtelephone');
    }

    











    public function addemailAction()
    {
        /* page espacepersonnel/addemail - Ajout email */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['email']) && $_POST['email'] != "") {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);

                $banque_email = new Application_Model_EuBanqueEmail();
                $m_banque_email = new Application_Model_EuBanqueEmailMapper();

                    $compteur = $m_banque_email->findConuter() + 1;

                    $banque_email->setId_email($compteur);
                    $banque_email->setEmail($_POST['email']);
                    $banque_email->setCode_banque($sessionbanqueopi->code_banque);
                    $banque_email->setStatus(0);
                    $banque_email->setId_banque_user($sessionbanqueopi->id_banque_user);
                    $m_banque_email->save($banque_email);

                    $this->_redirect('/banqueopi/listemail');
                    $this->view->error = "Numéro email enregistré";
                
            } else {
                $this->view->error = "Champs * obligatoire";
            }
        }
    }




    public function editemailAction()
    {
        /* page espacepersonnel/editemail - Editer email */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['email']) && $_POST['email'] != "") {


                $date_id = new Zend_Date(Zend_Date::ISO_8601);

                $banque_email = new Application_Model_EuBanqueEmail();
                $m_banque_email = new Application_Model_EuBanqueEmailMapper();

                $m_banque_email->find($_POST['id_email'], $banque_email);


                    $banque_email->setEmail($_POST['email']);
                    //$banque_email->setCode_banque($sessionbanqueopi->code_banque);
                    //$banque_email->setId_banque_user($sessionbanqueopi->id_banque_user);
                    $m_banque_email->update($banque_email);

                    $this->_redirect('/banqueopi/listemail');
                    $this->view->error = "Numéro email corrigé";
                
            } else {
                $this->view->error = "Champs * obligatoire";

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $a = new Application_Model_EuBanqueEmail();
        $ma = new Application_Model_EuBanqueEmailMapper();
        $ma->find($id, $a);
        $this->view->banque_email = $a;
            }
            }
        }else {

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $a = new Application_Model_EuBanqueEmail();
        $ma = new Application_Model_EuBanqueEmailMapper();
        $ma->find($id, $a);
        $this->view->banque_email = $a;
            }
            }
    }



    public function listemailAction()
    {
        /* page espacepersonnel/listemail - Liste des emails */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        $banque_email = new Application_Model_EuBanqueEmailMapper();
if($sessionbanqueopi->role == "B_ADMIN") {
        $this->view->entries = $banque_email->fetchAllByCodeBanqueUser($sessionbanqueopi->code_banque, 0, 0);
    }else{
        $this->view->entries = $banque_email->fetchAllByCodeBanqueUser($sessionbanqueopi->code_banque, 0, $sessionbanqueopi->id_banque_user);
    }

        $this->view->tabletri = 1;
    }






    public function statusemailAction()
    {
        /* page banqueopi/statusemail - Publier la email libre d'information */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $banque_email = new Application_Model_EuBanqueEmail();
        $banque_emailM = new Application_Model_EuBanqueEmailMapper();
        $banque_emailM->find($id, $banque_email);
        
        $banque_email->setStatus($this->_request->getParam('status'));
        $banque_emailM->update($banque_email);
        }

        $this->_redirect('/banqueopi/listemail');
    }

    



    public function detailstraiteAction() {
        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $traiteT = new Application_Model_DbTable_EuTraite();
        $select = $traiteT->select();
        if($sessionbanqueopi->code_banque != ""){
        $select->where('traite_code_banque = ?', $sessionbanqueopi->code_banque);
    }
        $select->where('bon_id > ?', 0);
        $select->where('traite_disponible = ?', 1);
        //$select->where('traite_imprimer = ?', 1);
        $select->where('traite_date_debut !=  ?', $date_id->toString('yyyy-MM-dd'));
        $select->where('traite_date_fin =  ?', $date_id->toString('yyyy-MM-dd'));
        $select->order('traite_id ASC');
        $traites = $traiteT->fetchAll($select);

        $this->view->traites = $traites;
        $this->view->tabletri = 1;

    }


    public function detailstraitejourAction() {
        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $traiteT = new Application_Model_DbTable_EuTraite();
        $select = $traiteT->select();
        if($sessionbanqueopi->code_banque != ""){
        $select->where('traite_code_banque = ?', $sessionbanqueopi->code_banque);
    }
        $select->where('bon_id > ?', 0);
        $select->where('traite_disponible = ?', 1);
        //$select->where('traite_imprimer = ?', 0);
        $select->where('traite_date_debut LIKE ?', $date_id->toString('yyyy-MM-dd'));
        $select->where('traite_date_fin LIKE ?', $date_id->toString('yyyy-MM-dd'));
        $select->order('traite_id ASC');
        $traites = $traiteT->fetchAll($select);

        $this->view->traites = $traites;
        $this->view->tabletri = 1;

    }


    public function detailstraite2Action() {
        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['date_debut']) && $_POST['date_debut'] != "" && isset($_POST['date_fin']) && $_POST['date_fin'] != "") {

        $traiteT = new Application_Model_DbTable_EuTraite();
        $select = $traiteT->select();
        if($sessionbanqueopi->code_banque != ""){
        $select->where('traite_code_banque = ?', $sessionbanqueopi->code_banque);
    }
        $select->where('bon_id > ?', 0);
        $select->where('traite_disponible = ?', 1);
        //$select->where('traite_imprimer = ?', 1);
        $select->where("traite_date_fin BETWEEN '".$_POST['date_debut']."' AND '".$_POST['date_fin']."'");
        $select->order('traite_id DESC');
        //$select->limit(100);
        $traites = $traiteT->fetchAll($select);

        $this->view->traites = $traites;
        $this->view->tabletri = 1;

            }
            }

    }



    public function detailstraite2jourAction() {
        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['date_debut']) && $_POST['date_debut'] != "") {

        $traiteT = new Application_Model_DbTable_EuTraite();
        $select = $traiteT->select();
        if($sessionbanqueopi->code_banque != ""){
        $select->where('traite_code_banque = ?', $sessionbanqueopi->code_banque);
    }
        $select->where('bon_id > ?', 0);
        $select->where('traite_disponible = ?', 1);
        $select->where('traite_imprimer = ?', 1);
        //$select->where('traite_date_debut = ?', $_POST['date_debut']);
        $select->where('traite_date_fin = ?', $_POST['date_debut']);
        $select->order('traite_id DESC');
        //$select->limit(100);
        $traites = $traiteT->fetchAll($select);

        $this->view->traites = $traites;
        $this->view->tabletri = 1;

            }
            }

    }




    public function addbanqueuserAction()
    {
        /* banqueuser banqueopi/addbanqueuser - Création de banqueuser libre d'information */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['role']) && $_POST['role']!="" && isset($_POST['nom_banque_user']) && $_POST['nom_banque_user']!="" && isset($_POST['prenom_banque_user']) && $_POST['prenom_banque_user']!="" && isset($_POST['code_membre']) && $_POST['code_membre']!="" && isset($_POST['login_banque_user']) && $_POST['login_banque_user']!="" && isset($_POST['pwd_banque_user']) && $_POST['pwd_banque_user']!="" && isset($_POST['c_pwd_banque_user']) && $_POST['pwd_banque_user']==$_POST['c_pwd_banque_user']) {
                    
        $date_id = new Zend_Date(Zend_Date::ISO_8601);

        $user_banque = new Application_Model_EuBanqueUser();
        $m_user_banque = new Application_Model_EuBanqueUserMapper();
                    
            $compteur = $m_user_banque->findConuter() + 1;
                    $user_banque->setIdBanqueUser ( $compteur );
                    $user_banque->setActiver ( 0 );
                    $user_banque->setCodeBanque ( $sessionbanqueopi->code_banque );
                    $user_banque->setLoginBanqueUser ( $_POST['login_banque_user'] );
                    $user_banque->setNomBanqueUser ( $_POST['nom_banque_user'] );
                    $user_banque->setPrenomBanqueUser ( $_POST['prenom_banque_user'] );
                    $user_banque->setCode_membre ( $_POST['code_membre'] );
                    $user_banque->setPwdBanqueUser ( $_POST['pwd_banque_user'] );
                    $user_banque->setPwdChanged ( 0 );
                    $user_banque->setRole ( $_POST['role'] );
                    $user_banque->setDateCreated ( $date_id->toString ( "yyyy-MM-dd" ) );
                    $user_banque->setIdUtilisateur ( 1 );
                    $m_user_banque->save($user_banque);
            
            $compteur_user_banque = $compteur;

//////////////////////////////////////////
            if (isset($_POST['email']) && $_POST['email'] != "") {

                $banque_email = new Application_Model_EuBanqueEmail();
                $m_banque_email = new Application_Model_EuBanqueEmailMapper();

                    $compteur = $m_banque_email->findConuter() + 1;

                    $banque_email->setId_email($compteur);
                    $banque_email->setEmail($_POST['email']);
                    $banque_email->setCode_banque($sessionbanqueopi->code_banque);
                    $banque_email->setStatus(0);
                    $banque_email->setId_banque_user($compteur_user_banque);
                    $m_banque_email->save($banque_email);
                }

//////////////////////////////////////////
            if (isset($_POST['telephone']) && $_POST['telephone'] != "") {

                $banque_telephone = new Application_Model_EuBanqueTelephone();
                $m_banque_telephone = new Application_Model_EuBanqueTelephoneMapper();

                    $compteur = $m_banque_telephone->findConuter() + 1;

                    $banque_telephone->setId_telephone($compteur);
                    $banque_telephone->setTelephone($_POST['telephone']);
                    $banque_telephone->setCode_banque($sessionbanqueopi->code_banque);
                    $banque_telephone->setStatus(0);
                    $banque_telephone->setId_banque_user($compteur_user_banque);
                    $m_banque_telephone->save($banque_telephone);
                }

//////////////////////////////////////////



        $this->_redirect('/banqueopi/listbanqueuser');
        } else {  $this->view->error = "Champs * obligatoire ...";  } 
        }
        
    }


    public function editbanqueuserAction()
    {
        /* banqueuser banqueopi/editbanqueuser - Modification de banqueuser libre d'information */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['role']) && $_POST['role']!="" && isset($_POST['nom_banque_user']) && $_POST['nom_banque_user']!="" && isset($_POST['prenom_banque_user']) && $_POST['prenom_banque_user']!="" && isset($_POST['code_membre']) && $_POST['code_membre']!="") {
        

            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $user_banque = new Application_Model_EuBanqueUser();
        $m_user_banque = new Application_Model_EuBanqueUserMapper();
        $m_user_banque->find($_POST['id_banque_user'], $user_banque);
            
                    $user_banque->setNomBanqueUser ( $_POST['nom_banque_user'] );
                    $user_banque->setPrenomBanqueUser ( $_POST['prenom_banque_user'] );
                    $user_banque->setCode_membre ( $_POST['code_membre'] );
                    $user_banque->setRole ( $_POST['role'] );
            $m_user_banque->update($user_banque);


///////////////////////////
            if (isset($_POST['telephone']) && $_POST['telephone'] != "") {
                $m_banque_telephone1 = new Application_Model_EuBanqueTelephoneMapper();
                if($banque_telephone1 = $m_banque_telephone1->fetchAllByUserBanqueOne($_POST['id_banque_user'])){

                $banque_telephone = new Application_Model_EuBanqueTelephone();
                $m_banque_telephone = new Application_Model_EuBanqueTelephoneMapper();
                $m_banque_telephone->find($banque_telephone1->id_telephone, $banque_telephone);

                    $banque_telephone->setTelephone($_POST['telephone']);
                    //$banque_telephone->setCode_banque($sessionbanqueopi->code_banque);
                    //$banque_telephone->setId_banque_user($sessionbanqueopi->id_banque_user);
                    $m_banque_telephone->update($banque_telephone);

                }else{

                $banque_telephone = new Application_Model_EuBanqueTelephone();
                $m_banque_telephone = new Application_Model_EuBanqueTelephoneMapper();

                    $compteur = $m_banque_telephone->findConuter() + 1;

                    $banque_telephone->setId_telephone($compteur);
                    $banque_telephone->setTelephone($_POST['telephone']);
                    $banque_telephone->setCode_banque($user_banque->getCodeBanque());
                    $banque_telephone->setStatus(0);
                    $banque_telephone->setId_banque_user($user_banque->getIdBanqueUser());
                    $m_banque_telephone->save($banque_telephone);

                }
            }

///////////////////////////
            if (isset($_POST['email']) && $_POST['email'] != "") {
                $m_banque_email1 = new Application_Model_EuBanqueEmailMapper();
                if($banque_email1 = $m_banque_email1->fetchAllByUserBanqueOne($_POST['id_banque_user'])){


                $banque_email = new Application_Model_EuBanqueEmail();
                $m_banque_email = new Application_Model_EuBanqueEmailMapper();
                $m_banque_email->find($banque_email1->id_email, $banque_email);


                    $banque_email->setEmail($_POST['email']);
                    //$banque_email->setCode_banque($sessionbanqueopi->code_banque);
                    //$banque_email->setId_banque_user($sessionbanqueopi->id_banque_user);
                    $m_banque_email->update($banque_email);

                }else{

                $banque_email = new Application_Model_EuBanqueEmail();
                $m_banque_email = new Application_Model_EuBanqueEmailMapper();

                    $compteur = $m_banque_email->findConuter() + 1;

                    $banque_email->setId_email($compteur);
                    $banque_email->setEmail($_POST['email']);
                    $banque_email->setCode_banque($user_banque->getCodeBanque());
                    $banque_email->setStatus(0);
                    $banque_email->setId_banque_user($user_banque->getIdBanqueUser());
                    $m_banque_email->save($banque_email);

                }
            }




///////////////////////////
            
        $this->_redirect('/banqueopi/listbanqueuser');
    }  else {   $this->view->error = "Les champs * sont obligatoires ...";  

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $user_banque = new Application_Model_EuBanqueUser();
        $ma = new Application_Model_EuBanqueUserMapper();
        $ma->find($id, $user_banque);
        $this->view->banque_user = $user_banque;

                $m_banque_telephone1 = new Application_Model_EuBanqueTelephoneMapper();
                $banque_telephone1 = $m_banque_telephone1->fetchAllByUserBanqueOne($user_banque->getIdBanqueUser());
        $this->view->banque_telephone = $banque_telephone1;

                $m_banque_email1 = new Application_Model_EuBanqueEmailMapper();
                $banque_email1 = $m_banque_email1->fetchAllByUserBanqueOne($user_banque->getIdBanqueUser());
        $this->view->banque_email = $banque_email1;


            }
    }
           
    } else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $user_banque = new Application_Model_EuBanqueUser();
        $ma = new Application_Model_EuBanqueUserMapper();
        $ma->find($id, $user_banque);
        $this->view->banque_user = $user_banque;

                $m_banque_telephone1 = new Application_Model_EuBanqueTelephoneMapper();
                $banque_telephone1 = $m_banque_telephone1->fetchAllByUserBanqueOne($user_banque->getIdBanqueUser());
        $this->view->banque_telephone = $banque_telephone1;

                $m_banque_email1 = new Application_Model_EuBanqueEmailMapper();
                $banque_email1 = $m_banque_email1->fetchAllByUserBanqueOne($user_banque->getIdBanqueUser());
        $this->view->banque_email = $banque_email1;

            }
    }
    }



    public function listbanqueuserAction()
    {
        /* banqueuser banqueopi/listbanqueuser - Liste des banqueuser libre d'information */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $banqueuser = new Application_Model_EuBanqueUserMapper();
        $this->view->entries = $banqueuser->findByBanque($sessionbanqueopi->code_banque);

        $this->view->tabletri = 1;

    }




    public function activerbanqueuserAction()
    {
        /* banqueuser banqueopi/activerbanqueuser - Activer la banqueuser libre d'information */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $banqueuser = new Application_Model_EuBanqueUser();
        $banqueuserM = new Application_Model_EuBanqueUserMapper();
        $banqueuserM->find($id, $banqueuser);
        
        $banqueuser->setActiver($this->_request->getParam('activer'));
        $banqueuserM->update($banqueuser);
        }

        $this->_redirect('/banqueopi/listbanqueuser');
    }





public function detailstraiteexcelAction()
    {
        /* page banqueopi/etatqbanexcel - exportation en excel */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

$date_id = new Zend_Date(Zend_Date::ISO_8601);

        $id = (int) $this->_request->getParam('id');
if($id == 1){
        $traiteT = new Application_Model_DbTable_EuTraite();
        $select = $traiteT->select();
        if($sessionbanqueopi->code_banque != ""){
        $select->where('traite_code_banque = ?', $sessionbanqueopi->code_banque);
    }
        $select->where('bon_id > ?', 0);
        $select->where('traite_disponible = ?', 1);
        $select->where('traite_imprimer = ?', 0);
        $select->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
        $select->order('traite_id ASC');
        $traites = $traiteT->fetchAll($select);

$this->_redirect(Util_Utils::genererExcelTraiteListe($traites));
}

if($id == 2){
        $traiteT = new Application_Model_DbTable_EuTraite();
        $select = $traiteT->select();
        if($sessionbanqueopi->code_banque != ""){
        $select->where('traite_code_banque = ?', $sessionbanqueopi->code_banque);
    }
        $select->where('bon_id > ?', 0);
        $select->where('traite_disponible = ?', 1);
        $select->where('traite_imprimer = ?', 1);
        $select->where('traite_date_fin <= ?', $date_id->toString('yyyy-MM-dd'));
        $select->order('traite_id DESC');
        $traites = $traiteT->fetchAll($select);

$this->_redirect(Util_Utils::genererExcelTraiteListe($traites));
}
    }











    public function payertraiteAction()
    {
        /* banqueuser banqueopi/activerbanqueuser - Activer la banqueuser libre d'information */

        $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

            $date = new Zend_Date(Zend_Date::ISO_8601);

        $validation_opi = new Application_Model_EuValidationOpi();
        $m_validation_opi = new Application_Model_EuValidationOpiMapper();
                    
            $compteur = $m_validation_opi->findConuter() + 1;
                    $validation_opi->setValidation_opi_id($compteur);
                    $validation_opi->setValidation_opi_banque_user($sessionbanqueopi->id_banque_user);
                    $validation_opi->setValidation_opi_traite($id);
                    $validation_opi->setValidation_opi_date($date->toString("yyyy-MM-dd HH:mm:ss"));
                    $validation_opi->setPublier(1);
                    $m_validation_opi->save($validation_opi);

        $traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($id, $traite);
        
        $traite->setTraite_payer($this->_request->getParam('payer'));
        $traiteM->update($traite);


        }

        $this->_redirect('/banqueopi/detailstraite');
    }







    public function listrelevebancaireAction() {
        /* page espacepersonnel/addtelephone - Ajout telephone */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
        
        $entries = array ();
        $request = $this->getRequest ();
        if ($request->isPost ()) {
            try {
                $pdate = $request->getParam ( "date_depot" );
                $montant = $request->getParam ( "montant" );
                $nom = $request->getParam ( "nomp" );
                $t_det_releve = new Application_Model_DbTable_EuRelevebancairedetail ();
                $select = $t_det_releve->select ( Zend_Db_Table::SELECT_WITH_FROM_PART );
                $select->setIntegrityCheck ( false );
                if (! empty ( $pdate ) && ! empty ( $nom ) && ! empty ( $montant )) {
                    //$date = new Zend_Date ( Util_Utils::convertDate ( $pdate ), Zend_Date::ISO_8601 );
                    $select->where ( 'relevebancairedetail_date = ?', $pdate );
                    $select->where ( 'relevebancairedetail_libelle like ?', "%" . $nom . "%" );
                    $select->where ( 'relevebancairedetail_montant = ?', $montant );
                } else if (! empty ( $pdate ) && ! empty ( $nom )) {
                    //$date = new Zend_Date ( Util_Utils::convertDate ( $pdate ), Zend_Date::ISO_8601 );
                    $select->where ( 'relevebancairedetail_date = ?', $pdate );
                    $select->where ( 'relevebancairedetail_libelle like ?', "%" . $nom . "%" );
                } else if (! empty ( $nom ) && ! empty ( $montant )) {
                    $select->where ( 'relevebancairedetail_libelle like ?', "%" . $nom . "%" );
                    $select->where ( 'relevebancairedetail_montant = ?', $montant );
                } else if (! empty ( $pdate ) && ! empty ( $montant )) {
                    //$date = new Zend_Date ( Util_Utils::convertDate ( $pdate ), Zend_Date::ISO_8601 );
                    $select->where ( 'relevebancairedetail_date = ?', $pdate );
                    $select->where ( 'relevebancairedetail_montant = ?', $montant );
                } else if (! empty ( $pdate )) {
                    //$date = new Zend_Date ( Util_Utils::convertDate ( $pdate ), Zend_Date::ISO_8601 );
                    $select->where ( 'relevebancairedetail_date = ?', $pdate );
                } else if (! empty ( $nom )) {
                    $select->where ( 'relevebancairedetail_libelle like ?', "%" . $nom . "%" );
                } else if (! empty ( $montant )) {
                    $select->where ( 'relevebancairedetail_montant = ?', $montant );
                }
                $select->join ( array (
                        'r' => 'eu_relevebancaire' 
                ), 'eu_relevebancairedetail.relevebancairedetail_relevebancaire = r.relevebancaire_id', 'r.relevebancaire_id' );
                $select->where ( 'r.relevebancaire_banque like ?', $sessionbanqueopi->code_banque );
                $select->join ( array (
                        'b' => 'eu_banque' 
                ), 'r.relevebancaire_banque = b.code_banque', 'b.code_banque' );
                $entries = $t_det_releve->fetchAll ( $select );
                
                $this->view->entries = $entries;
                $this->view->date_depot = $pdate;
                $this->view->montant = $montant;
                $this->view->nom = $nom;
                $this->view->tabletri = 1;
                return;
            } catch ( Exception $e ) {
                $this->view->message = "Echec d'ajout de relevé bancaire; Erreur de :" . $e->getMessage ();
                return;
            }
        }
    }
    public function addreleveAction() {
        /* page espacepersonnel/addtelephone - Ajout telephone */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        $request = $this->getRequest ();
        $db = Zend_Db_Table::getDefaultAdapter ();
        $date = new Zend_Date ( Zend_Date::ISO_8601 );
        if ($request->isPost ()) {
            $date_releve = $request->getParam ( "date_releve" );
            $libelle = $request->getParam ( "libelle" );
            $numero = $request->getParam ( "numero" );
            $montant = $request->getParam ( "montant" );
            $date_valeur = $request->getParam ( "date_valeur" );
            $relbancaire = new Application_Model_EuRelevebancaire ();
            $m_releve = new Application_Model_EuRelevebancaireMapper ();
            $m_detReleve = new Application_Model_EuRelevebancairedetailMapper ();
            $releves = $m_releve->fetchAllByDateFlooz ( $date->toString ( "yyyy-MM-dd" ), $sessionbanqueopi->code_banque );
            $db->beginTransaction ();
            try {
                //$date_depot = new Zend_Date ( Util_Utils::convertDate ( $date_releve ), Zend_Date::ISO_8601 );
                //$date_v = new Zend_Date ( Util_Utils::convertDate ( $date_valeur ), Zend_Date::ISO_8601 );
                if (count ( $releves ) >= 1) {
                    $releve = $releves;// [0]
                    $lastDetId = $m_detReleve->findConuter ();
                    if (isset ( $lastDetId )) {
                        $lastDetId ++;
                    } else {
                        $lastDetId = 1;
                    }
                    $detReleve = new Application_Model_EuRelevebancairedetail ();
                    $detReleve->setRelevebancairedetail_id ( $lastDetId );
                    $detReleve->setRelevebancairedetail_relevebancaire ( $releve->getRelevebancaire_id () );
                    $detReleve->setPublier ( 0 );
                    $detReleve->setRelevebancairedetail_date ( $date_releve );
                    $detReleve->setRelevebancairedetail_date_valeur ( $date_valeur );
                    $detReleve->setRelevebancairedetail_libelle ( $libelle );
                    $detReleve->setRelevebancairedetail_montant ( $montant );
                    $detReleve->setRelevebancairedetail_numero ( $numero );
                    $m_detReleve->save ( $detReleve );
                } else {
                    $lastId = $m_releve->findConuter ();
                    if (isset ( $lastId )) {
                        $lastId ++;
                    } else {
                        $lastId = 1;
                    }
                    $relbancaire->setRelevebancaire_id ( $lastId );
                    $relbancaire->setPublier ( 1 );
                    $relbancaire->setRelevebancaire_banque ( $sessionbanqueopi->code_banque );
                    $relbancaire->setRelevebancaire_date ( $date->toString ( "yyyy-MM-dd" ) );
                    $relbancaire->setRelevebancaire_utilisateur ( $sessionbanqueopi->id_banque_user );
                    $m_releve->save ( $relbancaire );
                    
                    $lastDetId = $m_detReleve->findConuter ();
                    if (isset ( $lastDetId )) {
                        $lastDetId ++;
                    } else {
                        $lastDetId = 1;
                    }
                    $detReleve = new Application_Model_EuRelevebancairedetail ();
                    $detReleve->setRelevebancairedetail_id ( $lastDetId );
                    $detReleve->setRelevebancairedetail_relevebancaire ( $relbancaire->getRelevebancaire_id () );
                    $detReleve->setPublier ( 0 );
                    $detReleve->setRelevebancairedetail_date ( $date_releve );
                    $detReleve->setRelevebancairedetail_date_valeur ( $date_valeur );
                    $detReleve->setRelevebancairedetail_libelle ( $libelle );
                    $detReleve->setRelevebancairedetail_montant ( $montant );
                    $detReleve->setRelevebancairedetail_numero ( $numero );
                    $m_detReleve->save ( $detReleve );
                }
                $db->commit ();
                $sessionbanqueopi->message = "Ajout d'utilisateur effectué avec succès!";
                $this->_redirect ( "/banqueopi/addreleve" );
            } catch ( Exception $e ) {
                $db->rollBack ();
                $sessionbanqueopi->message = "Echec d'ajout de relevé bancaire; Erreur de :" . $e->getMessage ();
                $this->view->date_releve = $date_releve;
                $this->view->libelle = $libelle;
                $this->view->numero = $numero;
                $this->view->montant = $montant;
                $this->view->date_valeur = $date_valeur;
                return;
            }
        } else {
            return;
        }
    }

    public function addbanqueAction() {
        /* page espacepersonnel/addtelephone - Ajout telephone */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        $request = $this->getRequest ();
        $db = Zend_Db_Table::getDefaultAdapter ();
        $m_banque = new Application_Model_EuBanqueMapper ();
        $rows = $m_banque->fetchAll ();
        $date = new Zend_Date ( Zend_Date::ISO_8601 );
        if ($request->isPost ()) {
            $nom = $request->getParam ( "nom_banque_user" );
            $prenom = $request->getParam ( "prenom_banque_user" );
            $login = $request->getParam ( "login_banque_user" );
            $pwd = $request->getParam ( "pwd_banque_user" );
            $pwd_confirm = $request->getParam ( "c_pwd_banque_user" );
            $banque = $request->getParam ( "code_banque" );
            $role = $request->getParam ( "role" );
            if (strcmp ( $pwd, $pwd_confirm ) == 0) {
                $db->beginTransaction ();
                try {
                    $user_banque = new Application_Model_EuBanqueUser ();
                    $m_user_banque = new Application_Model_EuBanqueUserMapper ();
                    $user_banque->setActiver ( 1 );
                    $user_banque->setCodeBanque ( $sessionbanqueopi->code_banque );
                    $user_banque->setLoginBanqueUser ( $login );
                    $user_banque->setNomBanqueUser ( $nom );
                    $user_banque->setPrenomBanqueUser ( $prenom );
                    $user_banque->setPwdBanqueUser ( $pwd );
                    $user_banque->setPwdChanged ( 0 );
                    $user_banque->setRole ( $role );
                    $user_banque->setDateCreated ( $date->toString ( "yyyy-MM-dd" ) );
                    $user_banque->setIdUtilisateur ( $sessionbanqueopi->id_banque_user );
                    $m_user_banque->save ( $user_banque );
                    $db->commit ();
                    $this->view->message = "Ajout d'utilisateur effectué avec succès!";
                    $this->_redirect ( "/banqueopi/addbanque" );
                } catch ( Exception $e ) {
                    $db->rollBack ();
                    $this->view->nom = $nom;
                    $this->view->prenom = $prenom;
                    $this->view->login = $login;
                    $this->view->pwd = $pwd;
                    $this->view->pwd_confirm = $pwd_confirm;
                    $this->view->role = $role;
                    $this->view->rows = $rows;
                    $this->view->message = "Echec d'ajout d'utilisateur; Erreur :" . $e->getMessage () . "->" . $e->getTraceAsString ();
                    return;
                }
            } else {
                $this->view->message = "Les mot de passe ne corresondent pas!";
                $this->view->nom = $nom;
                $this->view->prenom = $prenom;
                $this->view->login = $login;
                $this->view->pwd = $pwd;
                $this->view->pwd_confirm = $pwd_confirm;
                $this->view->role = $role;
                $this->view->rows = $rows;
                return;
            }
        } else {
            $this->view->rows = $rows;
            return;
        }
    }
    
    public function listtraiteAction() {
        /* page espacepersonnel/addtelephone - Ajout telephone */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_traite', 'eu_traite.traite_tegcp = eu_tpagcp.id_tpagcp');
        $select->where('eu_tpagcp.escomptable = 3');
        //$select->where('eu_traite.traiter = 8');
        $select->where("eu_tpagcp.mode_reglement LIKE 'OPI'");
        //$select->where('eu_tpagcp.code_membre = ?', $sessionmembre->code_membre);
        //$select->where("eu_traite.traite_code_banque IN (SELECT code_banque FROM eu_banque WHERE code_membre_morale LIKE '".$sessionmembre->code_membre."')");
        $select->order('eu_tpagcp.date_deb ASC');
        $traites = $tabela->fetchAll($select);

        $this->view->traites = $traites;

        $this->view->tabletri = 1;

    }
    
    public function detailstraite3Action() {
        /* page espacepersonnel/addtelephone - Ajout telephone */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}

        $id = (int)$this->_request->getParam('id');
        if ($id > 0) {
            $tpagcp = new Application_Model_EuTpagcp();
            $tpagcpM = new Application_Model_EuTpagcpMapper();
            $tpagcpM->find($id, $tpagcp);
            $this->view->tpagcp = $tpagcp;



            $traiteT = new Application_Model_DbTable_EuTraite();
            $select = $traiteT->select();
            $select->where('traite_tegcp = ?', $id);
            //$select->where("traite_code_banque IN (SELECT code_banque FROM eu_banque WHERE code_membre_morale LIKE '".$sessionmembre->code_membre."')");
            $select->order('traiter ASC');
            $traites = $traiteT->fetchAll($select);

             $this->view->traites = $traites;
            }

    }
    



public function rechercheopibanqueAction()
    {
        /* page espacepersonnel/addtelephone - Ajout telephone */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
         
       
        if(isset($_POST['ok']) && $_POST['ok']=="ok" && isset($_POST['traite_numero']) && $_POST['traite_numero']!=""){
    $mapper_traite = new Application_Model_EuTraiteMapper();
    $traite = $mapper_traite->fetchAllByNumero($_POST['traite_numero']);
if ($traite != false) {
        $tabela = new Application_Model_DbTable_EuTpagcp();
        $select = $tabela->select();
        $select->where('id_tpagcp = ?', $traite->traite_tegcp);
        $tpagcp = $tabela->fetchRow($select);
        $this->view->tpagcp = $tpagcp;

    $mapper_traite2 = new Application_Model_EuTraiteMapper();
    $this->view->traite2 = $mapper_traite2->findTraiteTegcp($traite->traite_tegcp);
    

}else{
  $this->view->error = "Pas d'OPI trouvé à ce numero ...";
}

$this->view->traite_numero = $_POST['traite_numero'];
        }

$this->view->tabletri = 1;

            }











    
    
    public function addrelevebanAction() {
        /* page espacepersonnel/addtelephone - Ajout telephone */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
        

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


        $date_id = Zend_Date::now();
        $date = Zend_Date::now();


        $request = $this->getRequest ();
        if ($request->isPost ()) {

  if (
  (
  (isset($_POST['bon_neutre_nom']) && $_POST['bon_neutre_nom']!="" && isset($_POST['bon_neutre_prenom']) && $_POST['bon_neutre_prenom']!="") ||
  (isset($_POST['bon_neutre_raison']) && $_POST['bon_neutre_raison']!="")
  ) &&
  isset($_POST['bon_neutre_autonome']) &&
  isset($_POST['bon_neutre_mobile']) && $_POST['bon_neutre_mobile']>0 &&
  isset($_POST['bon_neutre_email']) && $_POST['bon_neutre_email']!="" &&
  isset($_POST['bon_neutre_personne']) && $_POST['bon_neutre_personne']!="" &&
  isset($_POST['id_canton']) && $_POST['id_canton']!="" &&
  
  //isset($_POST['bon_neutre_banque']) && $_POST['bon_neutre_banque']!="" &&
  //isset($_POST['bon_neutre_numero']) && $_POST['bon_neutre_numero']!="" && $_POST['bon_neutre_numero']!=NULL &&
  //isset($_POST['bon_neutre_date_numero']) && $_POST['bon_neutre_date_numero']!="" &&
  //isset($_POST['bon_neutre_montant']) && $_POST['bon_neutre_montant']!="" &&

  
  isset($_POST['date_releve']) && $_POST['date_releve']!="" &&
  isset($_POST['libelle']) && $_POST['libelle']!="" &&
  isset($_POST['numero']) && $_POST['numero']!="" &&
  isset($_POST['montant']) && $_POST['montant']!="") {


                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
                    try {
                            $date_id = Zend_Date::now();

            $date_releve = $request->getParam ( "date_releve" );
            $libelle = $request->getParam ( "libelle" );
            $numero = $request->getParam ( "numero" );
            $montant = $request->getParam ( "montant" );
            $date_valeur = $request->getParam ( "date_valeur" );
            $relbancaire = new Application_Model_EuRelevebancaire ();
            $m_releve = new Application_Model_EuRelevebancaireMapper ();
            $m_detReleve = new Application_Model_EuRelevebancairedetailMapper ();
            $releves = $m_releve->fetchAllByDateFlooz ( $date->toString ( "yyyy-MM-dd" ), $sessionbanqueopi->code_banque);

                        /////////////////controle nom prenom
                        /*$eubon_neutre = new Application_Model_DbTable_EuBonNeutre();
                        $select = $eubon_neutre->select();
                        $select->where("LOWER(REPLACE(bon_neutre_nom, ' ', '')) = ? ", strtolower(str_replace(" ", "",$request->getParam("bon_neutre_nom"))));
                        $select->where("LOWER(REPLACE(bon_neutre_prenom, ' ', '')) = ? ", strtolower(str_replace(" ", "",$request->getParam("bon_neutre_prenom"))));
                        $select->order(array("bon_neutre_id ASC"));
                        $select->limit(1);
                        $rowseubon_neutre = $eubon_neutre->fetchRow($select);
                        if(count($rowseubon_neutre) > 0) {
                          $bon_neutre_ok = 1;
                          $bon_neutre_first = $rowseubon_neutre->bon_neutre_id;
                        } else {
                          $bon_neutre_ok = 0;
                        }*/

                        /////////////////controle numero de banque
                        $eubon_neutre_detail = new Application_Model_DbTable_EuBonNeutreDetail();
                        $select = $eubon_neutre_detail->select()
                                                ->where('bon_neutre_detail_banque = ?',$sessionbanqueopi->code_banque)
                                                ->where('bon_neutre_detail_numero = ?',$_POST['numero'])
                                                ->where('bon_neutre_detail_date_numero = ?',$_POST['date_releve'])
                                                ;
                        if ($rowseubon_neutre_detail = $eubon_neutre_detail->fetchRow($select)) {
                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($rowseubon_neutre_detail->bon_neutre_id, $bon_neutre);

                                $code_BAn = $bon_neutre->bon_neutre_code;

                            //$db->rollback();
                            //$sessionbanqueopi->error = "Numéro de banque déjà utilisé ...";
                            //$this->_redirect('/banqueopi/addreleveban');
                            //return;
                        }else{

                        /////////////////controle email
                        if(!filter_var($request->getParam("bon_neutre_email"), FILTER_VALIDATE_EMAIL)){
                            $db->rollback();
                            $sessionbanqueopi->error = "E-mail non valable ...";
                            $this->_redirect('/banqueopi/addreleveban');
                            return;
                        }

                    //////////////////////////bon_neutre_code_ban
                    if(isset($_POST['bon_neutre_code_ban']) && $_POST['bon_neutre_code_ban']!=""){
                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByCode($request->getParam("bon_neutre_code_ban"));
                    if(count($bon_neutre2) > 0){
                    }else{
                        $db->rollback();
                            $sessionbanqueopi->error = "Ancien Code BAn erroné ...";
                            $this->_redirect('/banqueopi/addreleveban');
                            return;
                    }
                    }


////////////////////////////////////////////////////////////

                //$date_depot = new Zend_Date ( Util_Utils::convertDate ( $date_releve ), Zend_Date::ISO_8601 );
                //$date_v = new Zend_Date ( Util_Utils::convertDate ( $date_valeur ), Zend_Date::ISO_8601 );
                
                //$date_releve = $date_releve->toString ( "yyyy-MM-dd" );
                //$date_valeur = $date_valeur->toString ( "yyyy-MM-dd" );
                if (count ( $releves ) >= 1) {
                    $releve = $releves;// [0]
                    $lastDetId = $m_detReleve->findConuter ();
                    if (isset ( $lastDetId )) {
                        $lastDetId ++;
                    } else {
                        $lastDetId = 1;
                    }
                    $detReleve = new Application_Model_EuRelevebancairedetail ();
                    $detReleve->setRelevebancairedetail_id ( $lastDetId );
                    $detReleve->setRelevebancairedetail_relevebancaire ( $releve->getRelevebancaire_id () );
                    $detReleve->setPublier ( 0 );
                    $detReleve->setRelevebancairedetail_date ( $date_releve);
                    $detReleve->setRelevebancairedetail_date_valeur ( $date_valeur);
                    $detReleve->setRelevebancairedetail_libelle ( $libelle );
                    $detReleve->setRelevebancairedetail_montant ( $montant );
                    $detReleve->setRelevebancairedetail_numero ( $numero );
                    $m_detReleve->save ( $detReleve );
                } else {
                    $lastId = $m_releve->findConuter ();
                    if (isset ( $lastId )) {
                        $lastId ++;
                    } else {
                        $lastId = 1;
                    }
                    $relbancaire->setRelevebancaire_id ( $lastId );
                    $relbancaire->setPublier ( 1 );
                    $relbancaire->setRelevebancaire_banque ( $sessionbanqueopi->code_banque );
                    $relbancaire->setRelevebancaire_date ( $date->toString ( "yyyy-MM-dd" ) );
                    $relbancaire->setRelevebancaire_utilisateur ( $sessionbanqueopi->id_banque_user );
                    $m_releve->save ( $relbancaire );
                    
                    $lastDetId = $m_detReleve->findConuter ();
                    if (isset ( $lastDetId )) {
                        $lastDetId ++;
                    } else {
                        $lastDetId = 1;
                    }
                    $detReleve = new Application_Model_EuRelevebancairedetail ();
                    $detReleve->setRelevebancairedetail_id ( $lastDetId );
                    $detReleve->setRelevebancairedetail_relevebancaire ( $relbancaire->getRelevebancaire_id () );
                    $detReleve->setPublier ( 0 );
                    $detReleve->setRelevebancairedetail_date ( $date_releve );
                    $detReleve->setRelevebancairedetail_date_valeur ( $date_valeur );
                    $detReleve->setRelevebancairedetail_libelle ( $libelle );
                    $detReleve->setRelevebancairedetail_montant ( $montant );
                    $detReleve->setRelevebancairedetail_numero ( $numero );
                    $m_detReleve->save ( $detReleve );
                }


                        /*
                        /////////////////controle montant
                        if($request->getParam("bon_neutre_banque") == "BOA" || $request->getParam("bon_neutre_banque") == "UTB" || $request->getParam("bon_neutre_banque") == "BAT" || $request->getParam("bon_neutre_banque") == "ECOBANK" || $request->getParam("bon_neutre_banque") == "ORABANK") {

                            $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                            $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate2($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $request->getParam("bon_neutre_date_numero"));
                            if(count($relevebancairedetail) > 0) {
                                if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                $db->rollback();
                                $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                $this->_redirect('/banqueopi/addreleveban');
                                return;
                                }
                            }else{

                                if($request->getParam("bon_neutre_banque") == "BAT"){
                            $libellebanques = array(strtolower($request->getParam("bon_neutre_nom")), strtolower($request->getParam("bon_neutre_prenom")), strtolower($request->getParam("bon_neutre_raison")));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addreleveban');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addreleveban');
                                        return;
                                    }

                                } else if($request->getParam("bon_neutre_banque") == "ECOBANK"){
                                    $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                    $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate6($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addreleveban');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addreleveban');
                                        return;
                                    }

                                } else if($request->getParam("bon_neutre_banque") == "ORABANK"){
                            $libellebanques = array(strtolower($request->getParam("bon_neutre_nom")), strtolower($request->getParam("bon_neutre_prenom")), strtolower($request->getParam("bon_neutre_raison")));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addreleveban');
                                        return;
                                        }
                                    } else {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addreleveban');
                                        return;
                                    }

                                }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addreleveban');
                                        return;
                                }
                            }
                        } else {

                                    $db->rollback();
                                    $sessionbanqueopi->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...";
                                    $this->_redirect('/banqueopi/addreleveban');
                                    return;
                        }

                        */


$message_sms_bancaire = Util_Utils::verifSmsBancaire($sessionbanqueopi->code_banque, $_POST['numero'], $_POST['date_releve'], $_POST['montant'], $request->getParam("bon_neutre_nom"), $request->getParam("bon_neutre_prenom"), $request->getParam("bon_neutre_raison"));

if(is_int($message_sms_bancaire) || $message_sms_bancaire > 0){
    $sessionbanqueopi->error = "";

}else if($message_sms_bancaire == "Montant"){
    $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...1";
    $this->_redirect('/banqueopi/addreleveban');

}else if($message_sms_bancaire == "banque"){
    $sessionbanqueopi->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...1";
    $this->_redirect('/banqueopi/addreleveban');

}else{
    $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...1";
    //$this->_redirect('/banqueopi/addreleveban');

    $message_releve_bancaire = Util_Utils::verifReleveBancaire($sessionbanqueopi->code_banque, $_POST['numero'], $_POST['date_releve'], $_POST['montant'], $request->getParam("bon_neutre_nom"), $request->getParam("bon_neutre_prenom"), $request->getParam("bon_neutre_raison"));

    if(is_int($message_releve_bancaire) || $message_releve_bancaire > 0){
        $sessionbanqueopi->error = "";

    }else if($message_releve_bancaire == "Montant"){
        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
        $this->_redirect('/banqueopi/addreleveban');

    }else if($message_releve_bancaire == "banque"){
        $sessionbanqueopi->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...";
        $this->_redirect('/banqueopi/addreleveban');

    }else{
        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
        $this->_redirect('/banqueopi/addreleveban');

    }
}





//$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
do{
                    $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
}while(count($bon_neutre_detail2) > 0);



/////////////////////////////////////controle code membre
if(isset($_POST['bon_neutre_code_membre']) && $_POST['bon_neutre_code_membre']!=""){
if(strlen($_POST['bon_neutre_code_membre']) != 20) {
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                                    $this->_redirect('/banqueopi/addreleveban');
                                    return;
}else{
if(substr($_POST['bon_neutre_code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['bon_neutre_code_membre'], $membre);
                                if(count($membre) == 0){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                                    $this->_redirect('/banqueopi/addreleveban');
                                    return;
                                }
                                if($_POST['bon_neutre_nom'] == "" || $_POST['bon_neutre_nom'] == NULL){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Veuillez bien saisir le nom et prénom(s)";
                                    $this->_redirect('/banqueopi/addreleveban');
                                    return;
                                }
    }
if(substr($_POST['bon_neutre_code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['bon_neutre_code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                    $this->_redirect('/banqueopi/addreleveban');
                                    return;
                                }
                                if($_POST['bon_neutre_raison'] == "" || $_POST['bon_neutre_raison'] == NULL){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Veuillez bien saisir la raison sociale";
                                    $this->_redirect('/banqueopi/addreleveban');
                                    return;
                                }
    }
}

////////////////////////////////////////////////////////////

                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($request->getParam("bon_neutre_code_membre"));
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                                $bon_neutre->setBon_neutre_code($code_BAn);
                                $bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant() + $_POST['montant']);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() + $_POST['montant']);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;

                        }else{

                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre($request->getParam("bon_neutre_code_membre"));
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($_POST['montant']);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($_POST['montant']);
                            $bon_neutre->setBon_neutre_nom($request->getParam("bon_neutre_nom"));
                            $bon_neutre->setBon_neutre_prenom($request->getParam("bon_neutre_prenom"));
                            $bon_neutre->setBon_neutre_raison($request->getParam("bon_neutre_raison"));
                            $bon_neutre->setBon_neutre_email($request->getParam("bon_neutre_email"));
                            $bon_neutre->setBon_neutre_mobile($request->getParam("bon_neutre_mobile"));
                            $bon_neutre_mapper->save($bon_neutre);

                                $bon_neutre_id = $compteur_bon_neutre;
                            }


                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($_POST['montant']);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($_POST['montant']);
                            $bon_neutre_detail->setBon_neutre_detail_banque($sessionbanqueopi->code_banque);
                            $bon_neutre_detail->setBon_neutre_detail_numero($_POST['numero']);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($_POST['date_releve']);
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);

}else if(isset($_POST['bon_neutre_code_ban']) && $_POST['bon_neutre_code_ban']!=""){



                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByCode($request->getParam("bon_neutre_code_ban"));
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                                $bon_neutre->setBon_neutre_code($code_BAn);
                                $bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant() + $_POST['montant']);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() + $_POST['montant']);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;

                        }else{

                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre(NULL);
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($_POST['montant']);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($_POST['montant']);
                            $bon_neutre->setBon_neutre_nom($request->getParam("bon_neutre_nom"));
                            $bon_neutre->setBon_neutre_prenom($request->getParam("bon_neutre_prenom"));
                            $bon_neutre->setBon_neutre_raison($request->getParam("bon_neutre_raison"));
                            $bon_neutre->setBon_neutre_email($request->getParam("bon_neutre_email"));
                            $bon_neutre->setBon_neutre_mobile($request->getParam("bon_neutre_mobile"));
                            $bon_neutre_mapper->save($bon_neutre);

                                $bon_neutre_id = $compteur_bon_neutre;
                            }


                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($_POST['montant']);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($_POST['montant']);
                            $bon_neutre_detail->setBon_neutre_detail_banque($sessionbanqueopi->code_banque);
                            $bon_neutre_detail->setBon_neutre_detail_numero($_POST['numero']);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($_POST['date_releve']);
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);


}else{


                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre(NULL);
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($_POST['montant']);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($_POST['montant']);
                            $bon_neutre->setBon_neutre_nom($request->getParam("bon_neutre_nom"));
                            $bon_neutre->setBon_neutre_prenom($request->getParam("bon_neutre_prenom"));
                            $bon_neutre->setBon_neutre_raison($request->getParam("bon_neutre_raison"));
                            $bon_neutre->setBon_neutre_email($request->getParam("bon_neutre_email"));
                            $bon_neutre->setBon_neutre_mobile($request->getParam("bon_neutre_mobile"));
                            $bon_neutre_mapper->save($bon_neutre);




                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($_POST['montant']);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($_POST['montant']);
                            $bon_neutre_detail->setBon_neutre_detail_banque($sessionbanqueopi->code_banque);
                            $bon_neutre_detail->setBon_neutre_detail_numero($_POST['numero']);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($_POST['date_releve']);
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);


    }


        if(is_int($message_sms_bancaire) || $message_sms_bancaire > 0){
                                $relevesmsdetail2 = new Application_Model_EuRelevesmsdetail();
                                $relevesmsdetail2M = new Application_Model_EuRelevesmsdetailMapper();
                                $relevesmsdetail2M->find($message_sms_bancaire, $relevesmsdetail2);

                                $relevesmsdetail2->setPublier(1);
                                $relevesmsdetail2M->update($relevesmsdetail2);

        }else if(is_int($message_releve_bancaire) || $message_releve_bancaire > 0){
                                $relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
                                $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail2M->find($message_releve_bancaire, $relevebancairedetail2);

                                $relevebancairedetail2->setPublier(1);
                                $relevebancairedetail2M->update($relevebancairedetail2);

        }
                        }

                            ///////////////////////////////////////////////////////////////////////////////////////

                            $db->commit();

                            $sessionbanqueopi->code_BAn = $code_BAn;
                            $sessionbanqueopi->membre_code = $bon_neutre->bon_neutre_code_membre;

                            $sessionbanqueopi->error = "Opération bien effectuée. <br />
Vous venez de souscrire au Bon d'Achat neutre (BAn). <br />
Utilisez ce BAn pour : <br />
- votre propre Activation Personne Physique et/ou Personne Morale <br />
- la souscription pour tiers (CMFH) de votre choix <br />
<br />
";
if($sessionbanqueopi->membre_code != "" && $sessionbanqueopi->membre_code != NULL){
   $sessionbanqueopi->error .= "Le code du Bon d'Achat neutre (BAn) se trouve dans le compte marchand du membre <strong>".$sessionbanqueopi->membre_code."</strong><br />";
   $sessionbanqueopi->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
} else {
    $sessionbanqueopi->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
}
    $sessionbanqueopi->error .= "<strong>Veuillez bien noter votre code BAn. Il est très important. </strong>Le cas échéant, en cas de perte, reprenez l'opération.";

                            $this->_redirect('/banqueopi/addreleveban');
                            return;

                    }  catch (Exception $exc) {
                        $sessionbanqueopi->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();
                        $this->_redirect('/banqueopi/addreleveban');
                        return;
                    }


            }   else {  $sessionbanqueopi->error = "Champs * obligatoire ..."; }


        }


    }

















    public function addpcommissionAction()
    {
        /* page espacepersonnel/addpcommission - Ajout pcommission */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['pcommission']) && $_POST['pcommission'] != "" && isset($_POST['id_type_acteur']) && $_POST['id_type_acteur'] != "") {

                $date_id = new Zend_Date(Zend_Date::ISO_8601);

                $banque_pcommission = new Application_Model_EuBanquePcommission();
                $m_banque_pcommission = new Application_Model_EuBanquePcommissionMapper();

                    $compteur = $m_banque_pcommission->findConuter() + 1;

                    $banque_pcommission->setId_pcommission($compteur);
                    $banque_pcommission->setPcommission($_POST['pcommission']);
                    $banque_pcommission->setCode_banque($sessionbanqueopi->code_banque);
                    $banque_pcommission->setStatus(0);
                    $banque_pcommission->setId_type_acteur($_POST['id_type_acteur']);
                    $m_banque_pcommission->save($banque_pcommission);

                    $this->_redirect('/banqueopi/listpcommission');
                    $this->view->error = "Numéro pcommission enregistré";
                
            } else {
                $this->view->error = "Champs * obligatoire";
            }
        }
    }




    public function editpcommissionAction()
    {
        /* page espacepersonnel/editpcommission - Editer pcommission */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['pcommission']) && $_POST['pcommission'] != "" && isset($_POST['id_type_acteur']) && $_POST['id_type_acteur'] != "") {


                $date_id = new Zend_Date(Zend_Date::ISO_8601);

                $banque_pcommission = new Application_Model_EuBanquePcommission();
                $m_banque_pcommission = new Application_Model_EuBanquePcommissionMapper();

                $m_banque_pcommission->find($_POST['id_pcommission'], $banque_pcommission);


                    $banque_pcommission->setPcommission($_POST['pcommission']);
                    //$banque_pcommission->setCode_banque($sessionbanqueopi->code_banque);
                    $banque_pcommission->setId_type_acteur($_POST['id_type_acteur']);
                    $m_banque_pcommission->update($banque_pcommission);

                    $this->_redirect('/banqueopi/listpcommission');
                    $this->view->error = "Numéro pcommission corrigé";
                
            } else {
                $this->view->error = "Champs * obligatoire";

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $a = new Application_Model_EuBanquePcommission();
        $ma = new Application_Model_EuBanquePcommissionMapper();
        $ma->find($id, $a);
        $this->view->banque_pcommission = $a;
            }
            }
        }else {

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $a = new Application_Model_EuBanquePcommission();
        $ma = new Application_Model_EuBanquePcommissionMapper();
        $ma->find($id, $a);
        $this->view->banque_pcommission = $a;
            }
            }
    }



    public function listpcommissionAction()
    {
        /* page espacepersonnel/listpcommission - Liste des pcommissions */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $banque_pcommission = new Application_Model_EuBanquePcommissionMapper();
        $this->view->entries = $banque_pcommission->fetchAllByCodeBanqueTypeActeur($sessionbanqueopi->code_banque, 0, 0);

        $this->view->tabletri = 1;
    }






    public function statuspcommissionAction()
    {
        /* page banqueopi/statuspcommission - Publier la pcommission libre d'information */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $banque_pcommission = new Application_Model_EuBanquePcommission();
        $banque_pcommissionM = new Application_Model_EuBanquePcommissionMapper();
        $banque_pcommissionM->find($id, $banque_pcommission);
        
        $banque_pcommission->setStatus($this->_request->getParam('status'));
        $banque_pcommissionM->update($banque_pcommission);
        }

        $this->_redirect('/banqueopi/listpcommission');
    }

    











    public function addsouscriptionbanAction()  {
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

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


        $date_id = Zend_Date::now();

        $request = $this->getRequest ();
        if ($request->isPost ()) {

  if (
  (
  (isset($_POST['bon_neutre_nom']) && $_POST['bon_neutre_nom']!="" && isset($_POST['bon_neutre_prenom']) && $_POST['bon_neutre_prenom']!="") ||
  (isset($_POST['bon_neutre_raison']) && $_POST['bon_neutre_raison']!="")
  ) &&
  isset($_POST['bon_neutre_autonome']) &&
  isset($_POST['bon_neutre_mobile']) && $_POST['bon_neutre_mobile']>0 &&
  isset($_POST['bon_neutre_email']) && $_POST['bon_neutre_email']!="" &&
  isset($_POST['bon_neutre_personne']) && $_POST['bon_neutre_personne']!="" &&
  isset($_POST['id_canton']) && $_POST['id_canton']!="" &&
  isset($_POST['bon_neutre_banque']) && $_POST['bon_neutre_banque']!="" &&
  isset($_POST['bon_neutre_numero']) && $_POST['bon_neutre_numero']!="" && $_POST['bon_neutre_numero']!=NULL &&
  isset($_POST['bon_neutre_date_numero']) && $_POST['bon_neutre_date_numero']!="" &&
  isset($_POST['bon_neutre_montant']) && $_POST['bon_neutre_montant']!="" &&
  isset($_POST['bon_neutre_code_membre']) && $_POST['bon_neutre_code_membre']!="") {


                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
                    try {
                            $date_id = Zend_Date::now();

                        /////////////////controle nom prenom
                        /*$eubon_neutre = new Application_Model_DbTable_EuBonNeutre();
                        $select = $eubon_neutre->select();
                        $select->where("LOWER(REPLACE(bon_neutre_nom, ' ', '')) = ? ", strtolower(str_replace(" ", "",$request->getParam("bon_neutre_nom"))));
                        $select->where("LOWER(REPLACE(bon_neutre_prenom, ' ', '')) = ? ", strtolower(str_replace(" ", "",$request->getParam("bon_neutre_prenom"))));
                        $select->order(array("bon_neutre_id ASC"));
                        $select->limit(1);
                        $rowseubon_neutre = $eubon_neutre->fetchRow($select);
                        if(count($rowseubon_neutre) > 0) {
                          $bon_neutre_ok = 1;
                          $bon_neutre_first = $rowseubon_neutre->bon_neutre_id;
                        } else {
                          $bon_neutre_ok = 0;
                        }*/

                        /////////////////controle numero de banque
                        $eubon_neutre_detail = new Application_Model_DbTable_EuBonNeutreDetail();
                        $select = $eubon_neutre_detail->select()
                                                ->where('bon_neutre_detail_banque = ?',$request->getParam("bon_neutre_banque"))
                                                ->where('bon_neutre_detail_numero = ?',$request->getParam("bon_neutre_numero"))
                                                ->where('bon_neutre_detail_date_numero = ?',$request->getParam("bon_neutre_date_numero"))
                                                ;
                        if ($rowseubon_neutre_detail = $eubon_neutre_detail->fetchRow($select)) {
                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($rowseubon_neutre_detail->bon_neutre_id, $bon_neutre);

                                $code_BAn = $bon_neutre->bon_neutre_code;

                            //$db->rollback();
                            //$sessionbanqueopi->error = "Numéro de banque déjà utilisé ...";
                            //$this->_redirect('/banqueopi/addsouscriptionban');
                            //return;
                        }else{

                        /////////////////controle email
                        if(!filter_var($request->getParam("bon_neutre_email"), FILTER_VALIDATE_EMAIL)){
                            $db->rollback();
                            $sessionbanqueopi->error = "E-mail non valable ...";
                            $this->_redirect('/banqueopi/addsouscriptionban');
                            return;
                        }

                    //////////////////////////bon_neutre_code_ban
                    if(isset($_POST['bon_neutre_code_ban']) && $_POST['bon_neutre_code_ban']!=""){
                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByCode($request->getParam("bon_neutre_code_ban"));
                    if(count($bon_neutre2) > 0){
                    }else{
                        $db->rollback();
                            $sessionbanqueopi->error = "Ancien Code BAn erroné ...";
                            $this->_redirect('/banqueopi/addsouscriptionban');
                            return;
                    }
                    }


                        


$message_sms_bancaire = Util_Utils::verifSmsBancaire($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $request->getParam("bon_neutre_date_numero"), $request->getParam("bon_neutre_montant"), $request->getParam("bon_neutre_nom"), $request->getParam("bon_neutre_prenom"), $request->getParam("bon_neutre_raison"));

if(is_int($message_sms_bancaire) || $message_sms_bancaire > 0){
    $sessionbanqueopi->error = "";

}else if($message_sms_bancaire == "Montant"){
    $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...1";
    $this->_redirect('/banqueopi/addsouscriptionban');

}else if($message_sms_bancaire == "banque"){
    $sessionbanqueopi->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...1";
    $this->_redirect('/banqueopi/addsouscriptionban');

}else{
    $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...1";
    //$this->_redirect('/banqueopi/addsouscriptionban');

    $message_releve_bancaire = Util_Utils::verifReleveBancaire($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $request->getParam("bon_neutre_date_numero"), $request->getParam("bon_neutre_montant"), $request->getParam("bon_neutre_nom"), $request->getParam("bon_neutre_prenom"), $request->getParam("bon_neutre_raison"));

    if(is_int($message_releve_bancaire) || $message_releve_bancaire > 0){
        $sessionbanqueopi->error = "";

    }else if($message_releve_bancaire == "Montant"){
        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
        $this->_redirect('/banqueopi/addsouscriptionban');

    }else if($message_releve_bancaire == "banque"){
        $sessionbanqueopi->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...";
        $this->_redirect('/banqueopi/addsouscriptionban');

    }else{
        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
        $this->_redirect('/banqueopi/addsouscriptionban');

    }
}





//$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
do{
                    $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn2 = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn2);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn3 = strtoupper(Util_Utils::genererCodeSMS(6));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn3);
}while(count($bon_neutre_detail2) > 0);


///////////////////////////////////calcul commission banque//////////////////////////////

$montant_commission_banque = floor($request->getParam("bon_neutre_montant") * Util_Utils::getParamEsmc(17) / 100);



/////////////////////////////////////controle code membre
if(isset($_POST['bon_neutre_code_membre']) && $_POST['bon_neutre_code_membre']!=""){
if(strlen($_POST['bon_neutre_code_membre']) != 20) {
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                                    $this->_redirect('/banqueopi/addsouscriptionban');
                                    return;
}else{
if(substr($_POST['bon_neutre_code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['bon_neutre_code_membre'], $membre);
                                if(count($membre) == 0){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                                    $this->_redirect('/banqueopi/addsouscriptionban');
                                    return;
                                }
                                if($_POST['bon_neutre_nom'] == "" || $_POST['bon_neutre_nom'] == NULL){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Veuillez bien saisir le nom et prénom(s)";
                                    $this->_redirect('/banqueopi/addsouscriptionban');
                                    return;
                                }
    }
if(substr($_POST['bon_neutre_code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['bon_neutre_code_membre'], $membremorale);
                                if(count($membremorale) == 0){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                    $this->_redirect('/banqueopi/addsouscriptionban');
                                    return;
                                }
                                if($_POST['bon_neutre_raison'] == "" || $_POST['bon_neutre_raison'] == NULL){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Veuillez bien saisir la raison sociale";
                                    $this->_redirect('/banqueopi/addsouscriptionban');
                                    return;
                                }
    }
}


                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($request->getParam("bon_neutre_code_membre"));
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                                $bon_neutre->setBon_neutre_code($code_BAn);
                                $bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant() + $request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() + $request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;

                        }else{

                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre($request->getParam("bon_neutre_code_membre"));
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_nom($request->getParam("bon_neutre_nom"));
                            $bon_neutre->setBon_neutre_prenom($request->getParam("bon_neutre_prenom"));
                            $bon_neutre->setBon_neutre_raison($request->getParam("bon_neutre_raison"));
                            $bon_neutre->setBon_neutre_email($request->getParam("bon_neutre_email"));
                            $bon_neutre->setBon_neutre_mobile($request->getParam("bon_neutre_mobile"));
                            $bon_neutre_mapper->save($bon_neutre);

                                $bon_neutre_id = $compteur_bon_neutre;
                            }


                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_banque($request->getParam("bon_neutre_banque"));
                            $bon_neutre_detail->setBon_neutre_detail_numero($request->getParam("bon_neutre_numero"));
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($request->getParam("bon_neutre_date_numero"));
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);



/////////////////////////////commission esmc banque
                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn2);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_banque("CS-ESMC");
                            $bon_neutre_detail->setBon_neutre_detail_type("COM");
                            $bon_neutre_detail->setBon_neutre_detail_numero($code_BAn3);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);



}else if(isset($_POST['bon_neutre_code_ban']) && $_POST['bon_neutre_code_ban']!=""){



                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByCode($request->getParam("bon_neutre_code_ban"));
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                                $bon_neutre->setBon_neutre_code($code_BAn);
                                $bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant() + $request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() + $request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;

                        }else{

                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre(NULL);
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_nom($request->getParam("bon_neutre_nom"));
                            $bon_neutre->setBon_neutre_prenom($request->getParam("bon_neutre_prenom"));
                            $bon_neutre->setBon_neutre_raison($request->getParam("bon_neutre_raison"));
                            $bon_neutre->setBon_neutre_email($request->getParam("bon_neutre_email"));
                            $bon_neutre->setBon_neutre_mobile($request->getParam("bon_neutre_mobile"));
                            $bon_neutre_mapper->save($bon_neutre);

                                $bon_neutre_id = $compteur_bon_neutre;
                            }


                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_banque($request->getParam("bon_neutre_banque"));
                            $bon_neutre_detail->setBon_neutre_detail_numero($request->getParam("bon_neutre_numero"));
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($request->getParam("bon_neutre_date_numero"));
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);


/////////////////////////////commission esmc banque
                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn2);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_banque("CS-ESMC");
                            $bon_neutre_detail->setBon_neutre_detail_type("COM");
                            $bon_neutre_detail->setBon_neutre_detail_numero($code_BAn3);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);



}else{


                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre(NULL);
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_nom($request->getParam("bon_neutre_nom"));
                            $bon_neutre->setBon_neutre_prenom($request->getParam("bon_neutre_prenom"));
                            $bon_neutre->setBon_neutre_raison($request->getParam("bon_neutre_raison"));
                            $bon_neutre->setBon_neutre_email($request->getParam("bon_neutre_email"));
                            $bon_neutre->setBon_neutre_mobile($request->getParam("bon_neutre_mobile"));
                            $bon_neutre_mapper->save($bon_neutre);




                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_banque($request->getParam("bon_neutre_banque"));
                            $bon_neutre_detail->setBon_neutre_detail_numero($request->getParam("bon_neutre_numero"));
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($request->getParam("bon_neutre_date_numero"));
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);


/////////////////////////////commission esmc banque
                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn2);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_banque("CS-ESMC");
                            $bon_neutre_detail->setBon_neutre_detail_type("COM");
                            $bon_neutre_detail->setBon_neutre_detail_numero($code_BAn3);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                            $bon_neutre_detail->setId_canton($request->getParam("id_canton"));
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);



    }


        if(is_int($message_sms_bancaire) || $message_sms_bancaire > 0){
                                $relevesmsdetail2 = new Application_Model_EuRelevesmsdetail();
                                $relevesmsdetail2M = new Application_Model_EuRelevesmsdetailMapper();
                                $relevesmsdetail2M->find($message_sms_bancaire, $relevesmsdetail2);

                                $relevesmsdetail2->setPublier(1);
                                $relevesmsdetail2M->update($relevesmsdetail2);

        }else if(is_int($message_releve_bancaire) || $message_releve_bancaire > 0){
                                $relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
                                $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail2M->find($message_releve_bancaire, $relevebancairedetail2);

                                $relevebancairedetail2->setPublier(1);
                                $relevebancairedetail2M->update($relevebancairedetail2);

        }
                        }

                            ///////////////////////////////////////////////////////////////////////////////////////




                            $db->commit();

                            $sessionbanqueopi->code_BAn = $code_BAn;
                            $montantbanbanque = $request->getParam("bon_neutre_montant");
                            $sessionbanqueopi->montantbanbanque = $montantbanbanque;
                            $sessionbanqueopi->membre_code = $bon_neutre->bon_neutre_code_membre;

                            $sessionbanqueopi->error = "Opération bien effectuée. <br />
Vous venez de souscrire au Bon d'Achat neutre (BAn) en gros. <br />
<br />
";
if($sessionbanqueopi->membre_code != "" && $sessionbanqueopi->membre_code != NULL){
   $sessionbanqueopi->error .= "Le code du Bon d'Achat neutre (BAn) se trouve dans le compte marchand du membre <strong>".$sessionbanqueopi->membre_code."</strong><br />";
   $sessionbanqueopi->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
} else {
    $sessionbanqueopi->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
}
    $sessionbanqueopi->error .= "<strong>Veuillez bien noter votre code BAn. Il est très important. </strong>Le cas échéant, en cas de perte, reprenez l'opération.";

                            $this->_redirect('/banqueopi/addsouscriptionban');
                            return;

                    }  catch (Exception $exc) {
                        $sessionbanqueopi->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();
                        $this->_redirect('/banqueopi/addsouscriptionban');
                        return;
                    }


            }   else {  $sessionbanqueopi->error = "Champs * obligatoire ..."; }


        }


    }
    






    public function addbangrosAction()  {
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

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


        $date_id = Zend_Date::now();

        $request = $this->getRequest ();
        if ($request->isPost ()) {

  if (
  isset($_POST['bon_neutre_banque']) && $_POST['bon_neutre_banque']!="" &&
  isset($_POST['bon_neutre_numero']) && $_POST['bon_neutre_numero']!="" && $_POST['bon_neutre_numero']!=NULL &&
  isset($_POST['bon_neutre_date_numero']) && $_POST['bon_neutre_date_numero']!="" &&
  isset($_POST['bon_neutre_montant']) && $_POST['bon_neutre_montant']!="" &&
  isset($_POST['caution']) && $_POST['caution']!="") {


                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
                    try {
                            $date_id = Zend_Date::now();


                                $banque = new Application_Model_EuBanque();
                                $banqueM = new Application_Model_EuBanqueMapper();
                                $banqueM->find($request->getParam("bon_neutre_banque"), $banque);

                                $membre_morale = new Application_Model_EuMembreMorale();
                                $membre_moraleM = new Application_Model_EuMembreMoraleMapper();
                                $membre_moraleM->find($banque->code_membre_morale, $membre_morale);

   $representationM = new Application_Model_EuRepresentationMapper();
   $representation = $representationM->findbyrep($membre_morale->code_membre_morale);

   $membre2 = new Application_Model_EuMembre();
   $membre2M = new Application_Model_EuMembreMapper();
   $membre2M->find($representation->code_membre, $membre2);

                                $bon_neutre_nom = $membre2->nom_membre;
                                $bon_neutre_prenom = $membre2->prenom_membre;
                                $bon_neutre_raison = $membre_morale->raison_sociale;
                                $bon_neutre_code_membre = $membre_morale->code_membre_morale;
                                $bon_neutre_email = $membre_morale->email_membre;
                                $bon_neutre_mobile = $membre_morale->portable_membre;
                                $id_canton = $membre_morale->id_canton;



                        /////////////////controle montant
                        if($request->getParam("bon_neutre_banque") == "BOA" || $request->getParam("bon_neutre_banque") == "UTB" || $request->getParam("bon_neutre_banque") == "BAT" || $request->getParam("bon_neutre_banque") == "ECOBANK" || $request->getParam("bon_neutre_banque") == "ORABANK" || $request->getParam("bon_neutre_banque") == "WARI" || $request->getParam("bon_neutre_banque") == "BPEC" || $request->getParam("bon_neutre_banque") == "CCP" || $request->getParam("bon_neutre_banque") == "BTCI" || $request->getParam("bon_neutre_banque") == "FAIP" || $request->getParam("bon_neutre_banque") == "CECL" || $request->getParam("bon_neutre_banque") == "MECIT" || $request->getParam("bon_neutre_banque") == "MUTUAL" || $request->getParam("bon_neutre_banque") == "MECI" || $request->getParam("bon_neutre_banque") == "ASMA" || $request->getParam("bon_neutre_banque") == "ESMC") {

                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                            $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                            $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate7($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                            
                            if(count($relevebancairedetail) > 0) {
                                if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                $db->rollback();
                                $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                $this->_redirect('/banqueopi/addbangros');
                                return;
                                }
                            }else{

                                if($request->getParam("bon_neutre_banque") == "BAT"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                    }

                                } else if($request->getParam("bon_neutre_banque") == "ECOBANK"){
                                    $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                    $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate6($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                    }

                                } else if($request->getParam("bon_neutre_banque") == "ORABANK"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                    }

                                }else if($request->getParam("bon_neutre_banque") == "UTB"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                    }

                                }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangros');
                                        return;
                                }
                            }
                        } else {

                                    $db->rollback();
                                    $sessionbanqueopi->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...";
                                    $this->_redirect('/banqueopi/addbangros');
                                    return;
                        }

//}




//$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
do{
                    $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn2 = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn2);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn3 = strtoupper(Util_Utils::genererCodeSMS(6));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn3);
}while(count($bon_neutre_detail2) > 0);


///////////////////////////////////calcul commission banque//////////////////////////////

if($request->getParam("caution") == "AvecCommission"){

$$montant_commission_2 = 0;
$montant_commission = 0;
$montant = $request->getParam("bon_neutre_montant");
$montant_2 = 0;

do {
    if($montant > Util_Utils::getParamEsmc(23)){
        $montant_2 = Util_Utils::getParamEsmc(23);
        $montant = $montant - Util_Utils::getParamEsmc(23);
    }else{
        $montant_2 = $montant;
        $montant = $montant - $montant;
    }


    if($montant_2 > Util_Utils::getParamEsmc(22) && $montant_2 < Util_Utils::getParamEsmc(23)){
        $montant_commission = floor((Util_Utils::getParamEsmc(22) * Util_Utils::getParamEsmc(19) / 100) + (($montant_2 - Util_Utils::getParamEsmc(22)) * Util_Utils::getParamEsmc(21)));   
    }else if($montant_2 < Util_Utils::getParamEsmc(22)){
        $montant_commission = floor($montant_2 * (Util_Utils::getParamEsmc(20) * $montant_2 / 1000000) / 100);
    }else if($montant_2 == Util_Utils::getParamEsmc(22)){
        $montant_commission = floor($montant_2 * (Util_Utils::getParamEsmc(20) * $montant_2 / 1000000) / 100);
    }else if($montant_2 == Util_Utils::getParamEsmc(23)){
        $montant_commission = floor(Util_Utils::getParamEsmc(22) * Util_Utils::getParamEsmc(17) / 100);
    }



$montant_commission_2 = $montant_commission_2 + $montant_commission;
} while ($montant > 0);

$montant_commission_banque = $montant_commission_2;

}else if($request->getParam("caution") == "SansCommission"){
    $montant_commission_banque = $request->getParam("bon_neutre_montant");
}
                            



/////////////////////////////////////controle code membre
if(isset($bon_neutre_code_membre) && $bon_neutre_code_membre!=""){
if(strlen($bon_neutre_code_membre) != 20) {
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                                    $this->_redirect('/banqueopi/addbangros');
                                    return;
}else{
if(substr($bon_neutre_code_membre, -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($bon_neutre_code_membre, $membre);
                                if(count($membre) == 0){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                                    $this->_redirect('/banqueopi/addbangros');
                                    return;
                                }
                                if($bon_neutre_nom == "" || $bon_neutre_nom == NULL){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Veuillez bien saisir le nom et prénom(s)";
                                    $this->_redirect('/banqueopi/addbangros');
                                    return;
                                }
    }
if(substr($bon_neutre_code_membre, -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($bon_neutre_code_membre, $membremorale);
                                if(count($membremorale) == 0){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                    $this->_redirect('/banqueopi/addbangros');
                                    return;
                                }
                                if($bon_neutre_raison == "" || $bon_neutre_raison == NULL){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Veuillez bien saisir la raison sociale";
                                    $this->_redirect('/banqueopi/addbangros');
                                    return;
                                }
    }
}

//////////////////////////////////////////////
                                $ban2M = new Application_Model_EuBanMapper();
                                $ban2 = $ban2M->fetchAllOneMembre();
                                if($ban2->solde >= $request->getParam("bon_neutre_montant")){ 

                                $ban = new Application_Model_EuBan();
                                $banM = new Application_Model_EuBanMapper();
                                $banM->find($ban2->id_ban, $ban);

                                $ban->setMont_vendu($ban->getMont_vendu() + ($request->getParam("bon_neutre_montant") + $montant_commission_banque));
                                $ban->setSolde($ban->getSolde() - ($request->getParam("bon_neutre_montant") + $montant_commission_banque));
                                $banM->update($ban);

                                $ban_id = $ban->id_ban;


                            $ban_vendu = new Application_Model_EuBanVendu();
                            $ban_vendu_mapper = new Application_Model_EuBanVenduMapper();

                            $compteur_ban_vendu = $ban_vendu_mapper->findConuter() + 1;
                            $ban_vendu->setId_ban_vendu($compteur_ban_vendu);
                            $ban_vendu->setId_ban($ban_id);
                            $ban_vendu->setDate_ban_vendu($date_id->toString('yyyy-MM-dd'));
                            $ban_vendu->setCode_membre($bon_neutre_code_membre);
                            $ban_vendu->setMont_vendu($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $ban_vendu->setNumero_recu($request->getParam("bon_neutre_numero"));
                            $ban_vendu->setId_user($sessionbanqueopi->id_banque_user);
                            $ban_vendu_mapper->save($ban_vendu);

//////////////////////////////////////////////

                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($bon_neutre_code_membre);
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                                $bon_neutre->setBon_neutre_code($code_BAn);
                                $bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant() + $request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() + $request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;

                        }else{

                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre($bon_neutre_code_membre);
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_nom($bon_neutre_nom);
                            $bon_neutre->setBon_neutre_prenom($bon_neutre_prenom);
                            $bon_neutre->setBon_neutre_raison($bon_neutre_raison);
                            $bon_neutre->setBon_neutre_email($bon_neutre_email);
                            $bon_neutre->setBon_neutre_mobile($bon_neutre_mobile);
                            $bon_neutre_mapper->save($bon_neutre);

                                $bon_neutre_id = $compteur_bon_neutre;
                            }


                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_banque($request->getParam("bon_neutre_banque"));
                            $bon_neutre_detail->setBon_neutre_detail_numero($request->getParam("bon_neutre_numero"));
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($request->getParam("bon_neutre_date_numero"));
                            $bon_neutre_detail->setId_canton($id_canton);
                            if($request->getParam("caution") == "AvecCommission"){
                            $bon_neutre_detail->setBon_neutre_detail_commission("AvecCommission");
                            }else if($request->getParam("caution") == "SansCommission"){
                            $bon_neutre_detail->setBon_neutre_detail_commission("SansCommission");
                            }
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);



/////////////////////////////commission esmc banque
                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn2);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_banque("CS-ESMC");
                            $bon_neutre_detail->setBon_neutre_detail_type("COM");
                            $bon_neutre_detail->setBon_neutre_detail_numero($code_BAn3);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                            $bon_neutre_detail->setId_canton($id_canton);
                            if($request->getParam("caution") == "AvecCommission"){
                            $bon_neutre_detail->setBon_neutre_detail_commission("AvecCommission");
                            }else if($request->getParam("caution") == "SansCommission"){
                            $bon_neutre_detail->setBon_neutre_detail_commission("SansCommission");
                            }
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);


                                $relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
                                $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail2M->find($relevebancairedetail->relevebancairedetail_id, $relevebancairedetail2);

                                $relevebancairedetail2->setPublier(1);
                                $relevebancairedetail2M->update($relevebancairedetail2);
        

                        

                            ///////////////////////////////////////////////////////////////////////////////////////




                            $db->commit();

                            $sessionbanqueopi->code_BAn = $code_BAn;
                            $sessionbanqueopi->membre_code = $bon_neutre->bon_neutre_code_membre;

                            $sessionbanqueopi->error = "Opération bien effectuée. <br />
Vous venez de souscrire au Bon d'Achat neutre (BAn) en gros. <br />
<br />
";
if($sessionbanqueopi->membre_code != "" && $sessionbanqueopi->membre_code != NULL){
   $sessionbanqueopi->error .= "Le code du Bon d'Achat neutre (BAn) se trouve dans le compte marchand du membre <strong>".$sessionbanqueopi->membre_code."</strong><br />";
   $sessionbanqueopi->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
} else {
    $sessionbanqueopi->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
}
    $sessionbanqueopi->error .= "<strong>Veuillez bien noter votre code BAn. Il est très important. </strong>Le cas échéant, en cas de perte, reprenez l'opération.";

                            $this->_redirect('/banqueopi/addbangros');
                            return;
}else{
                        $db->rollback();
                                    $sessionbanqueopi->error = "Solde BAn Source inferieur au montant";
                                    $this->_redirect('/banqueopi/addbangros');
                                    return;
}
    }

                    }  catch (Exception $exc) {
                        $sessionbanqueopi->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();
                        $this->_redirect('/banqueopi/addbangros');
                        return;
                    }


            }   else {  $sessionbanqueopi->error = "Champs * obligatoire ..."; }


        }


    }
    



    public function addbangroscodemembreAction()  {
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

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


        $date_id = Zend_Date::now();

        $request = $this->getRequest ();
        if ($request->isPost ()) {

  if (
  isset($_POST['code_membre']) && $_POST['code_membre']!="" &&
  isset($_POST['bon_neutre_banque']) && $_POST['bon_neutre_banque']!="" &&
  isset($_POST['bon_neutre_numero']) && $_POST['bon_neutre_numero']!="" && $_POST['bon_neutre_numero']!=NULL &&
  isset($_POST['bon_neutre_date_numero']) && $_POST['bon_neutre_date_numero']!="" &&
  isset($_POST['bon_neutre_montant']) && $_POST['bon_neutre_montant']!="" &&
  isset($_POST['caution']) && $_POST['caution']!="") {


                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
                    try {
                            $date_id = Zend_Date::now();


                                $banque = new Application_Model_EuBanque();
                                $banqueM = new Application_Model_EuBanqueMapper();
                                $banqueM->find($request->getParam("bon_neutre_banque"), $banque);

                                $membre_morale = new Application_Model_EuMembreMorale();
                                $membre_moraleM = new Application_Model_EuMembreMoraleMapper();
                                $membre_moraleM->find($request->getParam("code_membre"), $membre_morale);

   $representationM = new Application_Model_EuRepresentationMapper();
   $representation = $representationM->findbyrep($membre_morale->code_membre_morale);

   $membre2 = new Application_Model_EuMembre();
   $membre2M = new Application_Model_EuMembreMapper();
   $membre2M->find($representation->code_membre, $membre2);

                                $bon_neutre_nom = $membre2->nom_membre;
                                $bon_neutre_prenom = $membre2->prenom_membre;
                                $bon_neutre_raison = $membre_morale->raison_sociale;
                                $bon_neutre_code_membre = $membre_morale->code_membre_morale;
                                $bon_neutre_email = $membre_morale->email_membre;
                                $bon_neutre_mobile = $membre_morale->portable_membre;
                                $id_canton = $membre_morale->id_canton;



                        /////////////////controle montant
                        if($request->getParam("bon_neutre_banque") == "BOA" || $request->getParam("bon_neutre_banque") == "UTB" || $request->getParam("bon_neutre_banque") == "BAT" || $request->getParam("bon_neutre_banque") == "ECOBANK" || $request->getParam("bon_neutre_banque") == "ORABANK" || $request->getParam("bon_neutre_banque") == "WARI" || $request->getParam("bon_neutre_banque") == "BPEC" || $request->getParam("bon_neutre_banque") == "CCP" || $request->getParam("bon_neutre_banque") == "BTCI" || $request->getParam("bon_neutre_banque") == "FAIP" || $request->getParam("bon_neutre_banque") == "CECL" || $request->getParam("bon_neutre_banque") == "MECIT" || $request->getParam("bon_neutre_banque") == "MUTUAL" || $request->getParam("bon_neutre_banque") == "MECI" || $request->getParam("bon_neutre_banque") == "ASMA" || $request->getParam("bon_neutre_banque") == "ESMC") {

                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                            $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                            $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate7($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                            
                            if(count($relevebancairedetail) > 0) {
                                if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                $db->rollback();
                                $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                $this->_redirect('/banqueopi/addbangroscodemembre');
                                return;
                                }
                            }else{

                                if($request->getParam("bon_neutre_banque") == "BAT"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                    }

                                } else if($request->getParam("bon_neutre_banque") == "ECOBANK"){
                                    $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                    $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate6($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                    }

                                } else if($request->getParam("bon_neutre_banque") == "ORABANK"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                    }

                                }else if($request->getParam("bon_neutre_banque") == "UTB"){
                            $libellebanques = array(strtolower($bon_neutre_nom), strtolower($bon_neutre_prenom), strtolower($bon_neutre_raison));
                                $relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
                                    if(count($relevebancairedetail) > 0) {
                                        if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                        }
                                    }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                    }

                                }else{
                                        $db->rollback();
                                        $sessionbanqueopi->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
                                        $this->_redirect('/banqueopi/addbangroscodemembre');
                                        return;
                                }
                            }
                        } else {

                                    $db->rollback();
                                    $sessionbanqueopi->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...";
                                    $this->_redirect('/banqueopi/addbangroscodemembre');
                                    return;
                        }

//}




//$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
do{
                    $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn2 = strtoupper(Util_Utils::genererCodeSMS(9));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn2);
}while(count($bon_neutre_detail2) > 0);

do{
                    $code_BAn3 = strtoupper(Util_Utils::genererCodeSMS(6));
                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn3);
}while(count($bon_neutre_detail2) > 0);


///////////////////////////////////calcul commission banque//////////////////////////////

if($request->getParam("caution") == "AvecCommission"){

$montant_commission_banque = floor($request->getParam("bon_neutre_montant") * Util_Utils::getParamEsmc(19) / 100);

}else if($request->getParam("caution") == "SansCommission"){
    $montant_commission_banque = $request->getParam("bon_neutre_montant");
}
                            



/////////////////////////////////////controle code membre
if(isset($bon_neutre_code_membre) && $bon_neutre_code_membre!=""){
if(strlen($bon_neutre_code_membre) != 20) {
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                                    $this->_redirect('/banqueopi/addbangroscodemembre');
                                    return;
}else{
if(substr($bon_neutre_code_membre, -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($bon_neutre_code_membre, $membre);
                                if(count($membre) == 0){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                                    $this->_redirect('/banqueopi/addbangroscodemembre');
                                    return;
                                }
                                if($bon_neutre_nom == "" || $bon_neutre_nom == NULL){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Veuillez bien saisir le nom et prénom(s)";
                                    $this->_redirect('/banqueopi/addbangroscodemembre');
                                    return;
                                }
    }
if(substr($bon_neutre_code_membre, -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($bon_neutre_code_membre, $membremorale);
                                if(count($membremorale) == 0){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                    $this->_redirect('/banqueopi/addbangroscodemembre');
                                    return;
                                }
                                if($bon_neutre_raison == "" || $bon_neutre_raison == NULL){
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Veuillez bien saisir la raison sociale";
                                    $this->_redirect('/banqueopi/addbangroscodemembre');
                                    return;
                                }
    }
}

//////////////////////////////////////////////
                                $ban2M = new Application_Model_EuBanMapper();
                                //$ban2 = $ban2M->fetchAllOneMembre();
                                $ban_solde = $ban2M->getSumByBan("0010010010010000016M");
                                //if($ban2->solde >= $request->getParam("bon_neutre_montant")){ 
                                	$montant_ban = ($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                if($ban_solde >= $montant_ban){ 
                                $ban2 = $ban2M->fetchAllMembre0("0010010010010000016M");
                    foreach ($ban2 as $ban2_entry){

                                $ban = new Application_Model_EuBan();
                                $banM = new Application_Model_EuBanMapper();
                                $banM->find($ban2_entry->id_ban, $ban);

                        if($ban->getSolde() < $montant_ban){

                                $montant_ban = $montant_ban - $ban->getSolde();
                                
                                $ban->setMont_vendu($ban->getMont_vendu() + $ban->getSolde());
                                $ban->setSolde($ban->getSolde() - $ban->getSolde());
                                $banM->update($ban);

                                $ban_id = $ban->id_ban;

                            $ban_vendu = new Application_Model_EuBanVendu();
                            $ban_vendu_mapper = new Application_Model_EuBanVenduMapper();

                            $compteur_ban_vendu = $ban_vendu_mapper->findConuter() + 1;
                            $ban_vendu->setId_ban_vendu($compteur_ban_vendu);
                            $ban_vendu->setId_ban($ban_id);
                            $ban_vendu->setDate_ban_vendu($date_id->toString('yyyy-MM-dd'));
                            $ban_vendu->setCode_membre($bon_neutre_code_membre);
                            $ban_vendu->setMont_vendu($ban->getSolde());
                            $ban_vendu->setNumero_recu($request->getParam("bon_neutre_numero"));
                            $ban_vendu->setId_user($sessionbanqueopi->id_banque_user);
                            $ban_vendu_mapper->save($ban_vendu);

}else{
                                $ban->setMont_vendu($ban->getMont_vendu() + $montant_ban);
                                $ban->setSolde($ban->getSolde() - $montant_ban);
                                $banM->update($ban);

                                $ban_id = $ban->id_ban;

                            $ban_vendu = new Application_Model_EuBanVendu();
                            $ban_vendu_mapper = new Application_Model_EuBanVenduMapper();

                            $compteur_ban_vendu = $ban_vendu_mapper->findConuter() + 1;
                            $ban_vendu->setId_ban_vendu($compteur_ban_vendu);
                            $ban_vendu->setId_ban($ban_id);
                            $ban_vendu->setDate_ban_vendu($date_id->toString('yyyy-MM-dd'));
                            $ban_vendu->setCode_membre($bon_neutre_code_membre);
                            $ban_vendu->setMont_vendu($montant_ban);
                            $ban_vendu->setNumero_recu($request->getParam("bon_neutre_numero"));
                            $ban_vendu->setId_user($sessionbanqueopi->id_banque_user);
                            $ban_vendu_mapper->save($ban_vendu);
}

}
//////////////////////////////////////////////

                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($bon_neutre_code_membre);
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                                $bon_neutre->setBon_neutre_code($code_BAn);
                                $bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant() + $request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() + $request->getParam("bon_neutre_montant") + $montant_commission_banque);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;

                        }else{

                            $bon_neutre = new Application_Model_EuBonNeutre();
                            $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                            $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                            $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                            $bon_neutre->setBon_neutre_type("BAn");
                            $bon_neutre->setBon_neutre_code($code_BAn);
                            $bon_neutre->setBon_neutre_code_membre($bon_neutre_code_membre);
                            $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre->setBon_neutre_montant($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_montant_utilise(0);
                            $bon_neutre->setBon_neutre_montant_solde($request->getParam("bon_neutre_montant") + $montant_commission_banque);
                            $bon_neutre->setBon_neutre_nom($bon_neutre_nom);
                            $bon_neutre->setBon_neutre_prenom($bon_neutre_prenom);
                            $bon_neutre->setBon_neutre_raison($bon_neutre_raison);
                            $bon_neutre->setBon_neutre_email($bon_neutre_email);
                            $bon_neutre->setBon_neutre_mobile($bon_neutre_mobile);
                            $bon_neutre_mapper->save($bon_neutre);

                                $bon_neutre_id = $compteur_bon_neutre;
                            }


                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($request->getParam("bon_neutre_montant"));
                            $bon_neutre_detail->setBon_neutre_detail_banque($request->getParam("bon_neutre_banque"));
                            $bon_neutre_detail->setBon_neutre_detail_numero($request->getParam("bon_neutre_numero"));
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($request->getParam("bon_neutre_date_numero"));
                            $bon_neutre_detail->setId_canton($id_canton);
                            if($request->getParam("caution") == "AvecCommission"){
                            $bon_neutre_detail->setBon_neutre_detail_commission("AvecCommission");
                            }else if($request->getParam("caution") == "SansCommission"){
                            $bon_neutre_detail->setBon_neutre_detail_commission("SansCommission");
                            }
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);



/////////////////////////////commission esmc banque
                            $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                            $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                            $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                            $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                            $bon_neutre_detail->setBon_neutre_id($bon_neutre_id);
                            $bon_neutre_detail->setBon_neutre_detail_code($code_BAn2);
                            $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_detail->setBon_neutre_detail_montant($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                            $bon_neutre_detail->setBon_neutre_detail_montant_solde($montant_commission_banque);
                            $bon_neutre_detail->setBon_neutre_detail_banque("CS-ESMC");
                            $bon_neutre_detail->setBon_neutre_detail_type("COM");
                            $bon_neutre_detail->setBon_neutre_detail_numero($code_BAn3);
                            $bon_neutre_detail->setBon_neutre_detail_date_numero($date_id->toString('yyyy-MM-dd'));
                            $bon_neutre_detail->setId_canton($id_canton);
                            if($request->getParam("caution") == "AvecCommission"){
                            $bon_neutre_detail->setBon_neutre_detail_commission("AvecCommission");
                            }else if($request->getParam("caution") == "SansCommission"){
                            $bon_neutre_detail->setBon_neutre_detail_commission("SansCommission");
                            }
                            $bon_neutre_detail_mapper->save($bon_neutre_detail);


                                $relevebancairedetail2 = new Application_Model_EuRelevebancairedetail();
                                $relevebancairedetail2M = new Application_Model_EuRelevebancairedetailMapper();
                                $relevebancairedetail2M->find($relevebancairedetail->relevebancairedetail_id, $relevebancairedetail2);

                                $relevebancairedetail2->setPublier(1);
                                $relevebancairedetail2M->update($relevebancairedetail2);
        

                        

                            ///////////////////////////////////////////////////////////////////////////////////////




                            $db->commit();

                            $sessionbanqueopi->code_BAn = $code_BAn;
                            $sessionbanqueopi->membre_code = $bon_neutre->bon_neutre_code_membre;

                            $sessionbanqueopi->error = "Opération bien effectuée. <br />
Vous venez de souscrire au Bon d'Achat neutre (BAn) en gros. <br />
<br />
";
if($sessionbanqueopi->membre_code != "" && $sessionbanqueopi->membre_code != NULL){
   $sessionbanqueopi->error .= "Le code du Bon d'Achat neutre (BAn) se trouve dans le compte marchand du membre <strong>".$sessionbanqueopi->membre_code."</strong><br />";
   $sessionbanqueopi->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
} else {
    $sessionbanqueopi->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
}
    $sessionbanqueopi->error .= "<strong>Veuillez bien noter votre code BAn. Il est très important. </strong>Le cas échéant, en cas de perte, reprenez l'opération.";

                            $this->_redirect('/banqueopi/addbangroscodemembre');
                            return;
}else{
                        $db->rollback();
                                    $sessionbanqueopi->error = "Solde BAn Source inferieur au montant";
                                    $this->_redirect('/banqueopi/addbangroscodemembre');
                                    return;
}
    }

                    }  catch (Exception $exc) {
                        $sessionbanqueopi->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();
                        $this->_redirect('/banqueopi/addbangroscodemembre');
                        return;
                    }


            }   else {  $sessionbanqueopi->error = "Champs * obligatoire ..."; }


        }


    }
    






    public function listbonachatneutreAction()
    {
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

$banque = new Application_Model_EuBanque();
$banque_mapper = new Application_Model_EuBanqueMapper();
$banque_mapper->find($sessionbanqueopi->code_banque, $banque);
if($banque->code_membre_morale != ""){
        $bon_neutre = new Application_Model_EuBonNeutreMapper();
        $this->view->entries = $bon_neutre->fetchAllByMembreBAn($banque->code_membre_morale);
}
        $this->view->tabletri = 1;

}

    public function detailbonneutreAction()
    {
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $bon_neutre_detail = new Application_Model_EuBonNeutreDetailMapper();
        $this->view->entries = $bon_neutre_detail->fetchAllByBonNeutre($id);

        }

        $this->view->tabletri = 1;

}





    public function utilisebonneutreAction()
    {
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $bon_neutre_utilise = new Application_Model_EuBonNeutreUtiliseMapper();
        $this->view->entries = $bon_neutre_utilise->fetchAllByBonNeutre($id);

        }

        $this->view->tabletri = 1;

}






    public function addbanapproAction() {
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}


        $date_id = Zend_Date::now();

        $request = $this->getRequest ();
        if ($request->isPost ()) {

$banque = new Application_Model_EuBanque();
$banque_mapper = new Application_Model_EuBanqueMapper();
$banque_mapper->find($sessionbanqueopi->code_banque, $banque);
          
$membre_morale = new Application_Model_EuMembreMorale();
$membre_morale_mapper = new Application_Model_EuMembreMoraleMapper();
$membre_morale_mapper->find($banque->code_membre_morale, $membre_morale);



  if (isset($_POST['bon_neutre_appro_beneficiaire']) && $_POST['bon_neutre_appro_beneficiaire']!="" && isset($_POST['id_type_acteur']) && $_POST['id_type_acteur']!="" && isset($_POST['bon_neutre_appro_montant']) && $_POST['bon_neutre_appro_montant'] > 0) {

                    $db = Zend_Db_Table::getDefaultAdapter();
                    $db->beginTransaction();
                    try {
                            $date_id = Zend_Date::now();

                //$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
                do{
                                    $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                                    $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                                    $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
                }while(count($bon_neutre_detail2) > 0);

if($_POST['bon_neutre_appro_beneficiaire'] == $banque->code_membre_morale) {
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre du bénéficiaire doit etre different du Code Membre de l'apporteur. Merci...";
                                    $this->_redirect('/banqueopi/addbanappro');
                                    return;
}
/////////////////////////////////////controle code membre
if(strlen($_POST['bon_neutre_appro_beneficiaire']) != 20) {
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
                                    $this->_redirect('/banqueopi/addbanappro');
                                    return;
}else{
if(substr($_POST['bon_neutre_appro_beneficiaire'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                if($membre_mapper->find($_POST['bon_neutre_appro_beneficiaire'], $membre)){
                                }else{
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
                                    $this->_redirect('/banqueopi/addbanappro');
                                    return;
                                }
                $canton = $membre->id_canton;
                $nom = $membre->nom_membre;
                $prenom = $membre->prenom_membre;
                $email = $membre->email_membre;
                $mobile = $membre->portable_membre;
                $raison = "";
    } else if(substr($_POST['bon_neutre_appro_beneficiaire'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                if($membremorale_mapper->find($_POST['bon_neutre_appro_beneficiaire'], $membremorale)){
                                }else{
                                  $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
                                    $this->_redirect('/banqueopi/addbanappro');
                                    return;
                                }
                $canton = $membremorale->id_canton;
                $nom = "";
                $prenom = "";
                $email = $membremorale->email_membre;
                $mobile = $membremorale->portable_membre;
                $raison = $membremorale->raison_sociale;
    }else{
      $db->rollback();
                                    $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre...";
                                    $this->_redirect('/banqueopi/addbanappro');
                                    return;
    }
}



                                $banque_pcommission = new Application_Model_EuBanquePcommission();
                                $banque_pcommissionM = new Application_Model_EuBanquePcommissionMapper();
                                $banque_pcommission2 = $banque_pcommissionM->fetchAllByCodeBanqueTypeActeur($sessionbanqueopi->code_banque, $_POST['id_type_acteur'], 1);
                                if (count($banque_pcommission2) > 0) {
                                    //
                                }else{
                                $banque_pcommission = new Application_Model_EuBanquePcommission();
                                $banque_pcommissionM = new Application_Model_EuBanquePcommissionMapper();
                                $banque_pcommission2 = $banque_pcommissionM->fetchAllByCodeBanqueTypeActeur($sessionbanqueopi->code_banque, $_POST['id_type_acteur'], -1);
                                if (count($banque_pcommission2) > 0) {
                                    //
                                }else{
                                    $db->rollback();
                                    $sessionbanqueopi->error = "Le pourcentage de commission n'est pas défini ...";
                                    $this->_redirect('/banqueopi/addbanappro');
                                    return;
                                }
                            }/**/


if($_POST['id_type_acteur'] == 2 || $_POST['id_type_acteur'] == 3){
    $avecsanscommission = "AvecCommission";
                            $franchise = new Application_Model_EuFranchise();
                            $franchiseM = new Application_Model_EuFranchiseMapper();
                            $franchise2 = $franchiseM->fetchAllByMembreType($_POST['bon_neutre_appro_beneficiaire'], "");
                            if (count($franchise2) == 0) {
                                $db->rollback();
                                $sessionbanqueopi->error = "Le bénéficiaire n'a pas encore signé la franchise ...";
                                $this->_redirect('/banqueopi/addbanappro');
                                return;
                            }

$bon_neutre_appro_montant = $request->getParam("bon_neutre_appro_montant") + ($request->getParam("bon_neutre_appro_montant") * $banque_pcommission2->pcommission / 100);




//if($request->getParam("caution") == "AvecCommission"){
/*
$$montant_commission_2 = 0;
$montant_commission = 0;
$montant = $bon_neutre_appro_montant;
$montant_2 = 0;

do {
    if($montant > Util_Utils::getParamEsmc(23)){
        $montant_2 = Util_Utils::getParamEsmc(23);
        $montant = $montant - Util_Utils::getParamEsmc(23);
    }else{
        $montant_2 = $montant;
        $montant = $montant - $montant;
    }


    if($montant_2 > Util_Utils::getParamEsmc(22) && $montant_2 < Util_Utils::getParamEsmc(23)){
        $montant_commission = floor((Util_Utils::getParamEsmc(22) * Util_Utils::getParamEsmc(19) / 100) + (($montant_2 - Util_Utils::getParamEsmc(22)) * Util_Utils::getParamEsmc(21)));   
    }else if($montant_2 < Util_Utils::getParamEsmc(22)){
        $montant_commission = floor($montant_2 * (Util_Utils::getParamEsmc(20) * $montant_2 / 1000000) / 100);
    }else if($montant_2 == Util_Utils::getParamEsmc(22)){
        $montant_commission = floor($montant_2 * (Util_Utils::getParamEsmc(20) * $montant_2 / 1000000) / 100);
    }else if($montant_2 == Util_Utils::getParamEsmc(23)){
        $montant_commission = floor(Util_Utils::getParamEsmc(22) * Util_Utils::getParamEsmc(17) / 100);
    }



$montant_commission_2 = $montant_commission_2 + $montant_commission;
} while ($montant > 0);

$montant_commission_banque = $montant_commission_2;
*/
/*}else if($request->getParam("caution") == "SansCommission"){
    $montant_commission_banque = $request->getParam("bon_neutre_montant");
}*/
//$bon_neutre_appro_montant = $montant_commission_banque;  



/*
                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($banque->code_membre_morale);
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                    $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail_somme = $bon_neutre_detail_mapper->getSumByBonNeutreCommision($bon_neutre->bon_neutre_id, $avecsanscommission);


if($bon_neutre_appro_montant > $bon_neutre_detail_somme){
  $db->rollback();
                $sessionbanqueopi->error = "Le montant à allouer est supérieur au solde de votre BAn Avec Commission ...";
  $this->_redirect('/banqueopi/addbanappro');
  return;
}
}   else {
                            $db->rollback();
                                          $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre ...";
                            $this->_redirect('/banqueopi/addbanappro');
                            return;
}*/

}else if($_POST['id_type_acteur'] == 4) {
    $avecsanscommission = "SansCommission";
                            /*$franchise = new Application_Model_EuFranchise();
                            $franchiseM = new Application_Model_EuFranchiseMapper();
                            $franchise2 = $franchiseM->fetchAllByMembreType($_POST['bon_neutre_appro_beneficiaire'], "");
                            if (count($franchise2) == 0) {
                                $db->rollback();
                                $sessionbanqueopi->error = "Le bénéficiaire n'a pas encore signé la franchise ...";
                                $this->_redirect('/banqueopi/addbanappro');
                                return;
                            }*/

$bon_neutre_appro_montant = $request->getParam("bon_neutre_appro_montant");
/*
                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($banque->code_membre_morale);
                    if(count($bon_neutre2) > 0){

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);

                    $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();
                    $bon_neutre_detail_somme = $bon_neutre_detail_mapper->getSumByBonNeutreCommision($bon_neutre->bon_neutre_id, $avecsanscommission);

if($bon_neutre_appro_montant > $bon_neutre_detail_somme){
  $db->rollback();
                $sessionbanqueopi->error = "Le montant à allouer est supérieur au solde de votre BAn Sans Commission ...";
  $this->_redirect('/banqueopi/addbanappro');
  return;
}
}   else {
                            $db->rollback();
                                          $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre ...";
                            $this->_redirect('/banqueopi/addbanappro');
                            return;
}*/

}else{
  $db->rollback();
                $sessionbanqueopi->error = "Veuillez choisir le type acteur ...";
  $this->_redirect('/banqueopi/addbanappro');
  return;

}

                    $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($banque->code_membre_morale);
					//$bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre("0010010010010000017M");
                    if(count($bon_neutre2) > 0) {

                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);
}   else {
                            $db->rollback();
                                          $sessionbanqueopi->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre ...";
                            $this->_redirect('/banqueopi/addbanappro');
                            return;
}

$bon_neutre_appro = new Application_Model_EuBonNeutreAppro();
$bon_neutre_appro_mapper = new Application_Model_EuBonNeutreApproMapper();

$compteur_bon_neutre_appro = $bon_neutre_appro_mapper->findConuter() + 1;
$bon_neutre_appro->setBon_neutre_appro_id($compteur_bon_neutre_appro);
$bon_neutre_appro->setBon_neutre_appro_beneficiaire(strtoupper($request->getParam("bon_neutre_appro_beneficiaire")));
$bon_neutre_appro->setBon_neutre_appro_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$bon_neutre_appro->setBon_neutre_appro_montant($bon_neutre_appro_montant);
$bon_neutre_appro->setBon_neutre_appro_apporteur($banque->code_membre_morale);
$bon_neutre_appro->setBon_neutre_appro_banque_user($sessionbanqueopi->id_banque_user);
$bon_neutre_appro_mapper->save($bon_neutre_appro);





                                //$bon_neutre->setBon_neutre_code($code_BAn);
                                //$bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant());

                				$bon_neutre->setBon_neutre_montant_utilise($bon_neutre->getBon_neutre_montant_utilise() + $bon_neutre_appro_montant);
                                $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() - $bon_neutre_appro_montant);
                                $bon_neutreM->update($bon_neutre);

                                $bon_neutre_id = $bon_neutre->bon_neutre_id;



                                /*$bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                                $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                                $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                                $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                                $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                                $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($_POST['bon_neutre_appro_beneficiaire'], -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($_POST['bon_neutre_appro_beneficiaire'], -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_utilise2->setBon_neutre_utilise_montant($bon_neutre_appro_montant);
                                $bon_neutre_utilise2M->save($bon_neutre_utilise2);*/

///////////////////////////////////////////////////////////////////////////

$mont = $bon_neutre_appro_montant;

                    $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();
                   
                    $bon_neutre_detail = $bon_neutre_detail_mapper->fetchAllByBonNeutreValide($bon_neutre->bon_neutre_id);
                    foreach ($bon_neutre_detail as $detail){
                                $bon_neutre_detail2 = new Application_Model_EuBonNeutreDetail();
                                $bon_neutre_detail2M = new Application_Model_EuBonNeutreDetailMapper();
                                $bon_neutre_detail2M->find($detail->bon_neutre_detail_id, $bon_neutre_detail2);

if($bon_neutre_detail2->getBon_neutre_detail_banque() == "" || $bon_neutre_detail2->getBon_neutre_detail_banque() == NULL){
$appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();
$appro_detail = $appro_detail_mapper->fetchAllByBanque($detail->bon_neutre_appro_id);
$code_banque = $appro_detail->bon_neutre_appro_detail_banque;
}else{
$code_banque = $bon_neutre_detail2->getBon_neutre_detail_banque();
}

                       if($bon_neutre_detail2->getBon_neutre_detail_type() == "ELI"){
                        $code_banque2 = $bon_neutre_detail2->getBon_neutre_detail_numero();
                       }else if($bon_neutre_detail2->getBon_neutre_detail_type() == "COM"){
                        $code_banque2 = "COM-".$bon_neutre_detail2->getBon_neutre_detail_numero();
                       }else{
                        $code_banque2 = $code_banque;
                       }


                        if($bon_neutre_detail2->getBon_neutre_detail_montant_solde() < $mont){
$mont = $mont - $bon_neutre_detail2->getBon_neutre_detail_montant_solde();

$bon_neutre_appro_detail = new Application_Model_EuBonNeutreApproDetail();
$bon_neutre_appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();

$bon_neutre_appro_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
$bon_neutre_appro_detail->setBon_neutre_detail_id($detail->bon_neutre_detail_id);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$bon_neutre_appro_detail->setBon_neutre_appro_detail_montant($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
$bon_neutre_appro_detail->setBon_neutre_appro_detail_mont_utilise(0);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
$bon_neutre_appro_detail->setBon_neutre_appro_detail_banque($code_banque2);
$bon_neutre_appro_detail_mapper->save($bon_neutre_appro_detail);

                $bon_neutre_detail2->setBon_neutre_detail_montant_utilise($bon_neutre_detail2->getBon_neutre_detail_montant_utilise() + $bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                                $bon_neutre_detail2->setBon_neutre_detail_montant_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde() - $bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                                $bon_neutre_detail2M->update($bon_neutre_detail2);
                                


                                $bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                                $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                                $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                                $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                                $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                                $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($_POST['bon_neutre_appro_beneficiaire'], -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($_POST['bon_neutre_appro_beneficiaire'], -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_utilise2->setBon_neutre_utilise_montant($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                                $bon_neutre_utilise2->setBon_neutre_detail_id($bon_neutre_detail2->bon_neutre_detail_id);
                       $bon_neutre_utilise2->setUsertable("banque_user");
                       $bon_neutre_utilise2->setUser_id($sessionbanqueopi->id_banque_user);
                               $bon_neutre_utilise2M->save($bon_neutre_utilise2);

///////////////////////////////////////////////////////////////////////////
                                }else{

$bon_neutre_appro_detail = new Application_Model_EuBonNeutreApproDetail();
$bon_neutre_appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();

$bon_neutre_appro_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
$bon_neutre_appro_detail->setBon_neutre_detail_id($detail->bon_neutre_detail_id);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
$bon_neutre_appro_detail->setBon_neutre_appro_detail_montant($mont);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_mont_utilise(0);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_solde($mont);
$bon_neutre_appro_detail->setBon_neutre_appro_detail_banque($code_banque2);
$bon_neutre_appro_detail_mapper->save($bon_neutre_appro_detail);

                                $bon_neutre_detail2->setBon_neutre_detail_montant_utilise($bon_neutre_detail2->getBon_neutre_detail_montant_utilise() + $mont);
                                $bon_neutre_detail2->setBon_neutre_detail_montant_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde() - $mont);
                                $bon_neutre_detail2M->update($bon_neutre_detail2);



                                $bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                                $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                                $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                                $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                                $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                                $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($_POST['bon_neutre_appro_beneficiaire'], -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($_POST['bon_neutre_appro_beneficiaire'], -1, 1));
                                $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_utilise2->setBon_neutre_utilise_montant($mont);
                                $bon_neutre_utilise2->setBon_neutre_detail_id($bon_neutre_detail2->bon_neutre_detail_id);
                       $bon_neutre_utilise2->setUsertable("banque_user");
                       $bon_neutre_utilise2->setUser_id($sessionbanqueopi->id_banque_user);
                                $bon_neutre_utilise2M->save($bon_neutre_utilise2);

///////////////////////////////////////////////////////////////////////////
                                break;
                                }


                        }
                            


///////////////////////////////////////////////////////////////////////////

                $bon_neutre3_mapper = new Application_Model_EuBonNeutreMapper();
                $bon_neutre3 = $bon_neutre3_mapper->fetchAllByMembre(strtoupper($_POST['bon_neutre_appro_beneficiaire']));
                if(count($bon_neutre3) > 0){
                  $bon_neutre31 = new Application_Model_EuBonNeutre();
                                $bon_neutre31M = new Application_Model_EuBonNeutreMapper();
                                $bon_neutre31M->find($bon_neutre3->bon_neutre_id, $bon_neutre31);

                                $bon_neutre31->setBon_neutre_code($code_BAn);
                                $bon_neutre31->setBon_neutre_montant($bon_neutre31->getBon_neutre_montant() + $bon_neutre_appro_montant);
                  $bon_neutre31->setBon_neutre_montant_solde($bon_neutre31->getBon_neutre_montant_solde() + $bon_neutre_appro_montant);
                                $bon_neutre31M->update($bon_neutre31);


                                $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                                $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                                $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                                $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                                $bon_neutre_detail->setBon_neutre_id($bon_neutre3->bon_neutre_id);
                                $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                                $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                $bon_neutre_detail->setBon_neutre_detail_montant($bon_neutre_appro_montant);
                                $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                                $bon_neutre_detail->setBon_neutre_detail_montant_solde($bon_neutre_appro_montant);
                                $bon_neutre_detail->setBon_neutre_detail_banque(NULL);
                                $bon_neutre_detail->setBon_neutre_detail_numero(NULL);
                                $bon_neutre_detail->setBon_neutre_detail_date_numero(NULL);
                                $bon_neutre_detail->setId_canton($canton);
                                $bon_neutre_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
                                $bon_neutre_detail_mapper->save($bon_neutre_detail);


                  }else{

                                              $bon_neutre = new Application_Model_EuBonNeutre();
                                  $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                                  $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                                  $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                                  $bon_neutre->setBon_neutre_type("BAn");
                                  $bon_neutre->setBon_neutre_code($code_BAn);
                                  $bon_neutre->setBon_neutre_code_membre(strtoupper($_POST['bon_neutre_appro_beneficiaire']));
                                  $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                  $bon_neutre->setBon_neutre_montant($bon_neutre_appro_montant);
                                  $bon_neutre->setBon_neutre_montant_utilise(0);
                                  $bon_neutre->setBon_neutre_montant_solde($bon_neutre_appro_montant);
                                  $bon_neutre->setBon_neutre_nom($nom);
                                  $bon_neutre->setBon_neutre_prenom($prenom);
                                  $bon_neutre->setBon_neutre_raison($raison);
                                  $bon_neutre->setBon_neutre_email($email);
                                  $bon_neutre->setBon_neutre_mobile($mobile);
                                  $bon_neutre_mapper->save($bon_neutre);




                                $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                                  $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                                  $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                                  $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                                  $bon_neutre_detail->setBon_neutre_id($compteur_bon_neutre);
                                  $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                                  $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                                  $bon_neutre_detail->setBon_neutre_detail_montant($bon_neutre_appro_montant);
                                  $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                                  $bon_neutre_detail->setBon_neutre_detail_montant_solde($bon_neutre_appro_montant);
                                  $bon_neutre_detail->setBon_neutre_detail_banque(NULL);
                                  $bon_neutre_detail->setBon_neutre_detail_numero(NULL);
                                  $bon_neutre_detail->setBon_neutre_detail_date_numero(NULL);
                                  $bon_neutre_detail->setId_canton($canton);
                                  $bon_neutre_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
                                  $bon_neutre_detail_mapper->save($bon_neutre_detail);


                    }


                            ///////////////////////////////////////////////////////////////////////////////////////

                            $db->commit();
                            $sessionbanqueopi->error = "Opération bien effectuée. <br />
Vous venez de faire un approvisionnement de Bon d'Achat neutre (BAn). <br />
Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong>";
                            $sessionbanqueopi->code_BAn = $code_BAn;
                            $montantbanapprobanqueopi = $request->getParam("bon_neutre_appro_montant");
                            
                            $sessionbanqueopi->montantbanapprobanqueopi = $montantbanapprobanqueopi;
							$sessionbanqueopi->bon_neutre_detail_id = $compteur_bon_neutre_detail;
                            

                            $this->_redirect('/banqueopi/addbanappro');
                            return;



                    }  catch (Exception $exc) {
                        $sessionbanqueopi->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();
                        $this->_redirect('/banqueopi/addbanappro');
                        return;
                    }
                  }   else {  $sessionbanqueopi->error = "Champs * obligatoire ..."; }
}
    }






   public  function  addbanapprocmAction()  {
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}


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

        $date_id = Zend_Date::now();


$banque = new Application_Model_EuBanque();
$banque_mapper = new Application_Model_EuBanqueMapper();
$banque_mapper->find($sessionbanqueopi->code_banque, $banque);
          
$membre_morale = new Application_Model_EuMembreMorale();
$membre_morale_mapper = new Application_Model_EuMembreMoraleMapper();
$membre_morale_mapper->find($banque->code_membre_morale, $membre_morale);




        $request = $this->getRequest();
        if($request->isPost()) {
             if(((isset($_POST['bon_neutre_nom']) && $_POST['bon_neutre_nom']!="" && isset($_POST['bon_neutre_prenom']) 
             && $_POST['bon_neutre_prenom']!="" && isset($_POST['date_nais_membre']) && $_POST['date_nais_membre']!="") 
             ||(isset($_POST['bon_neutre_raison']) && $_POST['bon_neutre_raison']!="")) 
             && isset($_POST['bon_neutre_mobile']) && $_POST['bon_neutre_mobile'] > 0 
             && isset($_POST['bon_neutre_email']) && $_POST['bon_neutre_email']!="" 
             && isset($_POST['bon_neutre_personne']) && $_POST['bon_neutre_personne']!="" 
             && isset($_POST['bon_neutre_appro_montant']) && $_POST['bon_neutre_appro_montant']!="") {
                
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = Zend_Date::now();
                    /////////////////controle nom prenom
                    if(isset($_POST['bon_neutre_personne']) && $_POST['bon_neutre_personne']=="PP") {
                        $eupreinscription = new Application_Model_DbTable_EuMembre();
                        $prenom_membre = $_POST['bon_neutre_prenom'];
                        $prenom_membre = str_replace("'", " ", $prenom_membre);
                        $tabprenom = explode(" ",$prenom_membre);
                    
                        $nom_membre = $_POST['bon_neutre_nom'];
                        $nom_membre = str_replace("'", " ", $nom_membre);

                        $select = $eupreinscription->select();
                        $select->where("LOWER(REPLACE(nom_membre, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "",$nom_membre)));

                        //$tabprenom = explode(" ", $bon_neutre->bon_neutre_prenom);
                        foreach($tabprenom as $value) {
                           $select->where("LOWER(REPLACE(prenom_membre, ' ', '')) LIKE '%".strtolower(str_replace(" ", "",$value))."%' ");
                        }

                        $select->where("LOWER(REPLACE(date_nais_membre, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "",$request->getParam("date_nais_membre"))));
                        $select->limit(1);
                        $rowseupreinscription = $eupreinscription->fetchRow($select);
                        if(count($rowseupreinscription) > 0) {
                           $sessionbanqueopi->error = $_POST['bon_neutre_nom']." ".$_POST['bon_neutre_prenom']." est déjà membre ...";
                           $db->rollback();
                           return;
                        }
                     }
                     
                     /////////////////controle raison sociale
                     if(isset($_POST['bon_neutre_personne']) && $_POST['bon_neutre_personne']=="PM") {
                         $eupreinscription = new Application_Model_DbTable_EuMembreMorale();
                         $select = $eupreinscription->select();
                         $select->where("LOWER(REPLACE(raison_sociale, ' ', '')) LIKE ? ", strtolower(str_replace(" ", "",$_POST['bon_neutre_raison'])));

                         $select->limit(1);
                         $rowseupreinscription = $eupreinscription->fetchRow($select);
                         if(count($rowseupreinscription) > 0) {
                            $sessionbanqueopi->error = $_POST['bon_neutre_raison']." est déjà membre ...";
                            $db->rollback();
                            return;
                         }
                      }
                      
                      $bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                      $bon_neutre2 = $bon_neutre2_mapper->fetchAllByMembre($banque->code_membre_morale);
                      
                      if(count($bon_neutre2) == 0) {
                        $db->rollback();
                        $sessionbanqueopi->error = "Le membre apporteur ne dispose pas de BAn ...";
                        return;
                      }
                      
                      $bon_neutre = new Application_Model_EuBonNeutre();
                      $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                      $bon_neutreM->find($bon_neutre2->bon_neutre_id, $bon_neutre);
                      
                      if($request->getParam("bon_neutre_appro_montant") <= 0) {
                        $db->rollback();
                        $sessionbanqueopi->error = "Le montant à allouer doit etre supérieur à 0...";
                        return;
                      }
                      
                      if($request->getParam("bon_neutre_appro_montant") > $bon_neutre->getBon_neutre_montant_solde()) {
                        $db->rollback();
                        $sessionbanqueopi->error = "Le montant à allouer est supérieur au solde de votre BAn...";
                        return;
                      }
                      
                      //$code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));/
                      do {
                         $code_BAn = strtoupper(Util_Utils::genererCodeSMS(9));
                         $bon_neutre_detail2_mapper = new Application_Model_EuBonNeutreDetailMapper();
                         $bon_neutre_detail2 = $bon_neutre_detail2_mapper->fetchAllByCode($code_BAn);
                      } while(count($bon_neutre_detail2) > 0);
                      
                      $bon_neutre_appro = new Application_Model_EuBonNeutreAppro();
                      $bon_neutre_appro_mapper = new Application_Model_EuBonNeutreApproMapper();

                      $compteur_bon_neutre_appro = $bon_neutre_appro_mapper->findConuter() + 1;
                      $bon_neutre_appro->setBon_neutre_appro_id($compteur_bon_neutre_appro);
                      $bon_neutre_appro->setBon_neutre_appro_beneficiaire(NULL);
                      $bon_neutre_appro->setBon_neutre_appro_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                      $bon_neutre_appro->setBon_neutre_appro_montant($request->getParam("bon_neutre_appro_montant"));
                      $bon_neutre_appro->setBon_neutre_appro_apporteur($banque->code_membre_morale);
                      $bon_neutre_appro_mapper->save($bon_neutre_appro);
                      
                      //$bon_neutre->setBon_neutre_code($code_BAn);
                      //$bon_neutre->setBon_neutre_montant($bon_neutre->getBon_neutre_montant());
                      $bon_neutre->setBon_neutre_montant_utilise($bon_neutre->getBon_neutre_montant_utilise() + $request->getParam("bon_neutre_appro_montant"));
                      $bon_neutre->setBon_neutre_montant_solde($bon_neutre->getBon_neutre_montant_solde() - $request->getParam("bon_neutre_appro_montant"));
                      $bon_neutreM->update($bon_neutre);

                      $bon_neutre_id = $bon_neutre->bon_neutre_id;

                      /*$bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                      $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                      $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                      $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                      $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                      $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($_POST['bon_neutre_personne'], -1, 1));
                      $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($_POST['bon_neutre_personne'], -1, 1)." pour CM");
                      $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                      $bon_neutre_utilise2->setBon_neutre_utilise_montant($request->getParam("bon_neutre_appro_montant"));
                      $bon_neutre_utilise2M->save($bon_neutre_utilise2);*/
                      
                      
                      ///////////////////////////////////////////////////////////////////////////
                      $mont = $request->getParam("bon_neutre_appro_montant");
                      $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();
                      $bon_neutre_detail = $bon_neutre_detail_mapper->fetchAllByBonNeutreValide($bon_neutre->bon_neutre_id);
                      
                      foreach($bon_neutre_detail as $detail) {
                         $bon_neutre_detail2 = new Application_Model_EuBonNeutreDetail();
                         $bon_neutre_detail2M = new Application_Model_EuBonNeutreDetailMapper();
                         $bon_neutre_detail2M->find($detail->bon_neutre_detail_id, $bon_neutre_detail2);
                         if($bon_neutre_detail2->getBon_neutre_detail_banque() == "" || $bon_neutre_detail2->getBon_neutre_detail_banque() == NULL) {
                            $appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();
                            $appro_detail = $appro_detail_mapper->fetchAllByBanque($detail->bon_neutre_appro_id);
                            $code_banque = $appro_detail->bon_neutre_appro_detail_banque;
                         } else {
                            $code_banque = $bon_neutre_detail2->getBon_neutre_detail_banque();
                         }

                       if($bon_neutre_detail2->getBon_neutre_detail_type() == "ELI"){
                        $code_banque2 = $bon_neutre_detail2->getBon_neutre_detail_numero();
                       }else if($bon_neutre_detail2->getBon_neutre_detail_type() == "COM"){
                        $code_banque2 = "COM-".$bon_neutre_detail2->getBon_neutre_detail_numero();
                       }else{
                        $code_banque2 = $code_banque;
                       }


                         if($bon_neutre_detail2->getBon_neutre_detail_montant_solde() < $mont) {
                            $mont = $mont - $bon_neutre_detail2->getBon_neutre_detail_montant_solde();
                            $bon_neutre_appro_detail = new Application_Model_EuBonNeutreApproDetail();
                            $bon_neutre_appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();

                            $bon_neutre_appro_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
                            $bon_neutre_appro_detail->setBon_neutre_detail_id($detail->bon_neutre_detail_id);
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_montant($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_mont_utilise(0);
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_banque($code_banque2);
                            $bon_neutre_appro_detail_mapper->save($bon_neutre_appro_detail);

                            $bon_neutre_detail2->setBon_neutre_detail_montant_utilise($bon_neutre_detail2->getBon_neutre_detail_montant_utilise() + $bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                            $bon_neutre_detail2->setBon_neutre_detail_montant_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde() - $bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                            $bon_neutre_detail2M->update($bon_neutre_detail2);
                    

                      $bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                      $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                      $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                      $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                      $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                      $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($_POST['bon_neutre_personne'], -1, 1));
                      $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($_POST['bon_neutre_personne'], -1, 1)." pour CM");
                      $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                      $bon_neutre_utilise2->setBon_neutre_utilise_montant($bon_neutre_detail2->getBon_neutre_detail_montant_solde());
                      $bon_neutre_utilise2->setBon_neutre_detail_id($bon_neutre_detail2->bon_neutre_detail_id);
                       $bon_neutre_utilise2->setUsertable("banque_user");
                       $bon_neutre_utilise2->setUser_id($sessionbanqueopi->id_banque_user);
                      $bon_neutre_utilise2M->save($bon_neutre_utilise2);
                             
                          } else {
                            $bon_neutre_appro_detail = new Application_Model_EuBonNeutreApproDetail();
                            $bon_neutre_appro_detail_mapper = new Application_Model_EuBonNeutreApproDetailMapper();

                            $bon_neutre_appro_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
                            $bon_neutre_appro_detail->setBon_neutre_detail_id($detail->bon_neutre_detail_id);
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_montant($mont);
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_mont_utilise(0);
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_solde($mont);
                            $bon_neutre_appro_detail->setBon_neutre_appro_detail_banque($code_banque2);
                            $bon_neutre_appro_detail_mapper->save($bon_neutre_appro_detail);

                            $bon_neutre_detail2->setBon_neutre_detail_montant_utilise($bon_neutre_detail2->getBon_neutre_detail_montant_utilise() + $mont);
                            $bon_neutre_detail2->setBon_neutre_detail_montant_solde($bon_neutre_detail2->getBon_neutre_detail_montant_solde() - $mont);
                            $bon_neutre_detail2M->update($bon_neutre_detail2);
                    

                      $bon_neutre_utilise2 = new Application_Model_EuBonNeutreUtilise();
                      $bon_neutre_utilise2M = new Application_Model_EuBonNeutreUtiliseMapper();

                      $compteur_bon_neutre_utilise = $bon_neutre_utilise2M->findConuter() + 1;
                      $bon_neutre_utilise2->setBon_neutre_utilise_id($compteur_bon_neutre_utilise);
                      $bon_neutre_utilise2->setBon_neutre_id($bon_neutre->bon_neutre_id);
                      $bon_neutre_utilise2->setBon_neutre_utilise_type("P".substr($_POST['bon_neutre_personne'], -1, 1));
                      $bon_neutre_utilise2->setBon_neutre_utilise_libelle("Approvisionnement de BAn de P".substr($_POST['bon_neutre_personne'], -1, 1)." pour CM");
                      $bon_neutre_utilise2->setBon_neutre_utilise_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                      $bon_neutre_utilise2->setBon_neutre_utilise_montant($mont);
                      $bon_neutre_utilise2->setBon_neutre_detail_id($bon_neutre_detail2->bon_neutre_detail_id);
                       $bon_neutre_utilise2->setUsertable("banque_user");
                       $bon_neutre_utilise2->setUser_id($sessionbanqueopi->id_banque_user);
                      $bon_neutre_utilise2M->save($bon_neutre_utilise2);
                             
                            break;
                          }
                      }
                      
                      ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                      $bon_neutre = new Application_Model_EuBonNeutre();
                      $bon_neutre_mapper = new Application_Model_EuBonNeutreMapper();

                      $compteur_bon_neutre = $bon_neutre_mapper->findConuter() + 1;
                      $bon_neutre->setBon_neutre_id($compteur_bon_neutre);
                      $bon_neutre->setBon_neutre_type("BAn");
                      $bon_neutre->setBon_neutre_code($code_BAn);
                      $bon_neutre->setBon_neutre_code_membre(NULL);
                      $bon_neutre->setBon_neutre_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                      $bon_neutre->setBon_neutre_montant($request->getParam("bon_neutre_appro_montant"));
                      $bon_neutre->setBon_neutre_montant_utilise(0);
                      $bon_neutre->setBon_neutre_montant_solde($request->getParam("bon_neutre_appro_montant"));
                      $bon_neutre->setBon_neutre_nom($_POST['bon_neutre_nom']);
                      $bon_neutre->setBon_neutre_prenom($_POST['bon_neutre_prenom']);
                      $bon_neutre->setBon_neutre_raison($_POST['bon_neutre_raison']);
                      $bon_neutre->setBon_neutre_email($_POST['bon_neutre_email']);
                      $bon_neutre->setBon_neutre_mobile($_POST['bon_neutre_mobile']);
                      $bon_neutre_mapper->save($bon_neutre);
                      
                      $bon_neutre_detail = new Application_Model_EuBonNeutreDetail();
                      $bon_neutre_detail_mapper = new Application_Model_EuBonNeutreDetailMapper();

                      $compteur_bon_neutre_detail = $bon_neutre_detail_mapper->findConuter() + 1;
                      $bon_neutre_detail->setBon_neutre_detail_id($compteur_bon_neutre_detail);
                      $bon_neutre_detail->setBon_neutre_id($compteur_bon_neutre);
                      $bon_neutre_detail->setBon_neutre_detail_code($code_BAn);
                      $bon_neutre_detail->setBon_neutre_detail_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
                      $bon_neutre_detail->setBon_neutre_detail_montant($request->getParam("bon_neutre_appro_montant"));
                      $bon_neutre_detail->setBon_neutre_detail_montant_utilise(0);
                      $bon_neutre_detail->setBon_neutre_detail_montant_solde($request->getParam("bon_neutre_appro_montant"));
                      $bon_neutre_detail->setBon_neutre_detail_banque(NULL);
                      $bon_neutre_detail->setBon_neutre_detail_numero(NULL);
                      $bon_neutre_detail->setBon_neutre_detail_date_numero(NULL);
                      $bon_neutre_detail->setId_canton($_POST['id_canton']);
                      $bon_neutre_detail->setBon_neutre_appro_id($compteur_bon_neutre_appro);
                      $bon_neutre_detail_mapper->save($bon_neutre_detail);

                      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                      $db->commit();
                      $sessionbanqueopi->error = "Opération bien effectuée. <br />
                      Vous venez de faire un approvisionnement de Bon d'Achat neutre (BAn). <br />
                      Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong>";
                      $sessionbanqueopi->code_BAn = $code_BAn;
					  $sessionbanqueopi->bon_neutre_detail_id = $compteur_bon_neutre_detail;

                      $sessionbanqueopi->bon_neutre_appro_apporteur = "";
                      $sessionbanqueopi->bon_neutre_nom = "";
                      $sessionbanqueopi->bon_neutre_prenom = "";
                      $sessionbanqueopi->bon_neutre_raison = "";
                      $sessionbanqueopi->bon_neutre_personne = "";
                      $sessionbanqueopi->bon_neutre_mobile = "";
                      $sessionbanqueopi->bon_neutre_email = "";
                      //$sessionbanqueopi->id_canton = "";
                      $sessionbanqueopi->bon_neutre_appro_montant = "";
                      $sessionbanqueopi->confirmation_envoi = "";
                      $sessionbanqueopi->date_nais_membre = "";

                      $this->_redirect('/banqueopi/addbanapprocm');
                    
                } catch(Exception $exc) {
                    $sessionbanqueopi->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    $db->rollback();
                    return;
                }
                
             } else {  $sessionbanqueopi->error = "Champs * obligatoire ..."; }
         }
         
         
   }
   
 

    public function listbanapproapporteurAction()
    {
        /* page espacepersonnel/listrecu - Liste des reçus */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $banque = new Application_Model_EuBanque();
        $banque_mapper = new Application_Model_EuBanqueMapper();
        $banque_mapper->find($sessionbanqueopi->code_banque, $banque);
                  
        $membre_morale = new Application_Model_EuMembreMorale();
        $membre_morale_mapper = new Application_Model_EuMembreMoraleMapper();
        $membre_morale_mapper->find($banque->code_membre_morale, $membre_morale);
if($membre_morale->code_membre_morale != ""){
        $banappro = new Application_Model_EuBonNeutreApproMapper();
        $this->view->entries = $banappro->fetchAllByApporteur($membre_morale->code_membre_morale);
}
        $this->view->tabletri = 1;

    }









    public function addfichierAction()
    {
        /* page banqueopi/addfichier - Ajout d'un fichier */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['fichier_banque']) && $_POST['fichier_banque']!="" && isset($_POST['fichier_libelle']) && $_POST['fichier_libelle']!="" && isset($_FILES['fichier_url']['name']) && $_FILES['fichier_url']['name']!="") {
        
        include("Transfert.php");
        if(isset($_FILES['fichier_url']['name']) && $_FILES['fichier_url']['name']!=""){
        $chemin = "fichierbanques";
        $file = $_FILES['fichier_url']['name'];
        $file1='fichier_url';
        $fichier = $chemin."/".transfert($chemin,$file1);
        } else {$fichier = "";}
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFichierBanque();
        $ma = new Application_Model_EuFichierBanqueMapper();
            
            $compteur = $ma->findConuter() + 1;
            $a->setFichier_id($compteur);
            $a->setFichier_banque($_POST['fichier_banque']);
            $a->setFichier_libelle($_POST['fichier_libelle']);
            $a->setFichier_url($fichier);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
            
        $this->_redirect('/banqueopi/listfichier');
        } else {  $this->view->error = "Champs * obligatoire ...";  } 
        }
        
    }


    public function editfichierAction()
    {
        /* page banqueopi/editfichier - Modification d'un fichier */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['fichier_banque']) && $_POST['fichier_banque']!="" && isset($_POST['fichier_libelle']) && $_POST['fichier_libelle']!="") {
        
        include("Transfert.php");
        if(isset($_FILES['fichier_url']['name']) && $_FILES['fichier_url']['name']!=""){
        $chemin = "fichierbanques";
        $file = $_FILES['fichier_url']['name'];
        $file1='fichier_url';
        $fichier = $chemin."/".transfert($chemin,$file1);
        } else {$fichier = $_POST['fichier_url_old'];}
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFichierBanque();
        $ma = new Application_Model_EuFichierBanqueMapper();
        $ma->find($_POST['fichier_id'], $a);
            
            $a->setFichier_banque($_POST['fichier_banque']);
            $a->setFichier_libelle($_POST['fichier_libelle']);
            $a->setFichier_url($fichier);
            $ma->update($a);
            
        $this->_redirect('/banqueopi/listfichier');
        } else {  $this->view->error = "Champs * obligatoire ..."; 
         
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFichierBanque();
        $ma = new Application_Model_EuFichierBanqueMapper();
        $ma->find($id, $a);
        $this->view->fichier = $a;
            }
    }
           
    } else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuFichierBanque();
        $ma = new Application_Model_EuFichierBanqueMapper();
        $ma->find($id, $a);
        $this->view->fichier = $a;
            }
    }
    }




    public function listfichierAction()
    {
        /* page banqueopi/listfichier - Liste des fichiers */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $fichier = new Application_Model_EuFichierBanqueMapper();
        $this->view->entries = $fichier->fetchAllByBanque($sessionbanqueopi->code_banque);

        $this->view->tabletri = 1;

    }


    public function suppfichierAction()
    {
        /* page banqueopi/suppfichier - Suppression d'un fichier */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $fichier = new Application_Model_EuFichierBanque();
        $fichierM = new Application_Model_EuFichierBanqueMapper();
        $fichierM->find($id, $fichier);
        
        $fichierM->delete($fichier->fichier_id);
        //unlink($fichier->fichier_url);    

        }

        $this->_redirect('/banqueopi/listfichier');
    }




    public function publierfichierAction()
    {
        /* page banqueopi/publierfichier - Publier un fichier */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $fichier = new Application_Model_EuFichierBanque();
        $fichierM = new Application_Model_EuFichierBanqueMapper();
        $fichierM->find($id, $fichier);
        
        $fichier->setPublier($this->_request->getParam('publier'));
        $fichierM->update($fichier);
        }

        $this->_redirect('/banqueopi/listfichier');
    }










    public function addfichiermstierslistebcAction()
    {
        /* page banqueopi/addfichiermstierslistebc - Ajout d'un fichier */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['fichier_banque']) && $_POST['fichier_banque']!="" && isset($_POST['fichier_mstiers_listebc']) && $_POST['fichier_mstiers_listebc']!="" && isset($_FILES['fichier_url']['name']) && $_FILES['fichier_url']['name']!="") {
        
        include("Transfert.php");
        if(isset($_FILES['fichier_url']['name']) && $_FILES['fichier_url']['name']!=""){
        $chemin = "fichierbanques";
        $file = $_FILES['fichier_url']['name'];
        $file1='fichier_url';
        $fichier = $chemin."/".transfert($chemin,$file1);
        } else {$fichier = "";}
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuFichierMstiersListebc();
        $ma = new Application_Model_EuFichierMstiersListebcMapper();
            
            $compteur = $ma->findConuter() + 1;
            $a->setFichier_id($compteur);
            $a->setFichier_banque($_POST['fichier_banque']);
            $a->setFichier_mstiers_listebc($_POST['fichier_mstiers_listebc']);
            $a->setFichier_url($fichier);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
            
        $this->_redirect('/banqueopi/addfichiermstierslistebc');
        } else {  $this->view->error = "Champs * obligatoire ..."; 
         
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMstiersListebc();
        $ma = new Application_Model_EuMstiersListebcMapper();
        $ma->find($id, $a);
        $this->view->mstierslistebc = $a;
            }
    }
           
    } else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuMstiersListebc();
        $ma = new Application_Model_EuMstiersListebcMapper();
        $ma->find($id, $a);
        $this->view->mstierslistebc = $a;
            }
    }
    }










    public function listbanpbfAction()
    {
        /* page administration/listfichiertachemembreasso - Liste des fichiers */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $ban = new Application_Model_EuBanMapper();
        $this->view->entries = $ban->fetchAll2();

        $this->view->tabletri = 1;

    }


    public function listbanpbfvenduAction()
    {
        /* page administration/listfichiertachemembreasso - Liste des fichiers */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}

        $banvendu = new Application_Model_EuBanVenduMapper();
        $this->view->entries = $banvendu->fetchAll2();

        $this->view->tabletri = 1;

    }




    public function detailstraitepayerAction()
    {
        /* page banqueopi/detailstraitepayer - Payer  */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}


             $date = new Zend_Date(Zend_Date::ISO_8601);
    
for ($i=0; $i < count($_POST['payer']); $i++) { 

        $validation_opi = new Application_Model_EuValidationOpi();
        $m_validation_opi = new Application_Model_EuValidationOpiMapper();
                    
            $compteur = $m_validation_opi->findConuter() + 1;
                    $validation_opi->setValidation_opi_id($compteur);
                    $validation_opi->setValidation_opi_banque_user($sessionbanqueopi->id_banque_user);
                    $validation_opi->setValidation_opi_traite($_POST['traite_id'][$i]);
                    $validation_opi->setValidation_opi_date($date->toString("yyyy-MM-dd HH:mm:ss"));
                    $validation_opi->setPublier(1);
                    $m_validation_opi->save($validation_opi);

        $traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($_POST['traite_id'][$i], $traite);
        
        $traite->setTraite_payer($_POST['payer'][$i]);
        $traiteM->update($traite);
}



        $this->_redirect('/banqueopi/detailstraite');
    }


    public function detailstraitepayer2Action()
    {
        /* page banqueopi/detailstraitepayer - Payer  */

            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}


             $date = new Zend_Date(Zend_Date::ISO_8601);
    
for ($i=0; $i < count($_POST['payer']); $i++) { 

        $validation_opi = new Application_Model_EuValidationOpi();
        $m_validation_opi = new Application_Model_EuValidationOpiMapper();
                    
            $compteur = $m_validation_opi->findConuter() + 1;
                    $validation_opi->setValidation_opi_id($compteur);
                    $validation_opi->setValidation_opi_banque_user($sessionbanqueopi->id_banque_user);
                    $validation_opi->setValidation_opi_traite($_POST['traite_id'][$i]);
                    $validation_opi->setValidation_opi_date($date->toString("yyyy-MM-dd HH:mm:ss"));
                    $validation_opi->setPublier(1);
                    $m_validation_opi->save($validation_opi);

        $traite = new Application_Model_EuTraite();
        $traiteM = new Application_Model_EuTraiteMapper();
        $traiteM->find($_POST['traite_id'][$i], $traite);
        
        $traite->setTraite_payer($_POST['payer'][$i]);
        $traiteM->update($traite);
}



        $this->_redirect('/banqueopi/detailstraite2jour');
    }



}



