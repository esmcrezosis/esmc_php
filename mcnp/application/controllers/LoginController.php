<?php
class LoginController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if ($auth->hasIdentity()) {
           $user = $auth->getIdentity();
           $this->view->user = $user;
        }
    }

    public function init() {
       $this->view->jQuery()->enable();
       $this->view->jQuery()->uiEnable();
    }

	/*
	public function index1Action {
	
	        $this->_helper->layout->setLayout('index');
            $request = $this->getRequest();
            $form = new Application_Form_Login();
			
			$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
			
			if ($this->_request->isPost()) {
			    if ($form->isValid($request->getPost())) {
					$username = $this->_request->getPost('login');
                    $password = $this->_request->getPost('pwd');
					$pass = md5($password);
					$util = new Application_Model_EuUtilisateur();
                    $util_m = new Application_Model_EuUtilisateurMapper();
					$id = $user->id_utilisateur;
					
					try {
			            
			
			        
					
					
					
					
					} catch (Exception $exc) {
                       $this->view->message = "Echec de l'identification :" . $exc->getMessage();
                       $this->view->form = $form;
                       //echo $exc->getTraceAsString();
                    }
					
					
	            }
	        }
	
	        // Add the link to the cancel button
            $form->getElement('cancel')->setAttrib('onclick', "window.open('".
            $this->view->url(array(
                    'controller' => 'default',
                    'action' => 'index'
            ), 'default', true).
                "','_self')");
            $this->view->form = $form;
			
			
			
			
			
	
	
	
	}*/
	
	
	
    public function indexAction() {
        $this->_helper->layout->setLayout('index');
        $request = $this->getRequest();
        $form = new Application_Form_Login();
        if ($this->_request->isPost()) {
            // collect the data from the user
            if ($form->isValid($request->getPost())) {
               Zend_Loader::loadClass('Zend_Filter_StripTags');
               $f = new Zend_Filter_StripTags();
               $username = $f->filter($this->_request->getPost('login'));
               $password = $f->filter($this->_request->getPost('pwd'));

			   $pass = md5($password);
               $dbAdapter = Zend_Db_Table::getDefaultAdapter();
               $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
               $authAdapter->setTableName('eu_utilisateur')
                           ->setIdentityColumn('login')
                           ->setCredentialColumn('pwd');
                //ajout des données du formulaire pour l'authentification
                $authAdapter->setIdentity($username)
                            ->setCredential($pass);
                //lancement de l'authentification
                try {
                    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
					//$user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
                    $result = $auth->authenticate($authAdapter);
                    if ($result->isValid()) {
                        //success: store database row to auth's storage
                        //system. (Not the password though!)
                        $util = new Application_Model_EuUtilisateur();
                        $util_m = new Application_Model_EuUtilisateurMapper();
						//$resultat = $util_m->find($user->id_utilisateur,$util);
                        $data = $authAdapter->getResultRowObject(null, 'password');
                        if ($data->ulock == 1)  {
                           $this->view->message = "Votre compte a est désactivé.Veuillez voir votre supérieur hiérarchique !!!";
                           $this->view->form = $form;
                           return;
                        }  
						//elseif($data->connecte == 1) {
						   //$this->view->message = "Ce compte utilisateur est en utilisation !!!";
                           //$this->view->form = $form;
                          // return;
                        //}  
						elseif ($data->ch_pwd_flog == 0) {
						    $util_m->find($data->id_utilisateur, $util);
                            $util->setConnecte(1);
                            $util_m->update($util);
                            $auth->getStorage()->write($data);
                            return $this->_helper->redirector('beforechangepwd', 'login', null, array('controller' => 'login', 'action' => 'beforechangepwd'));
                        } else {
                               $util_m->find($data->id_utilisateur, $util);
                               if ($util->getCode_groupe() == 'apacncs' ||$util->getCode_groupe() == 'apai' ||$util->getCode_groupe() == 'aparpg' || $util->getCode_groupe() == 'dist') {
                               if ($util->getCode_membre() == '' || $util->getCode_membre() == null) {
                                    $this->view->message = "Ce compte doit être associé à un membre";
                                    $this->view->form = $form;
                                    return;
                               }
                               if ($util->getCode_groupe()== 'dist' && ($util->getCode_membre() != '' || $util->getCode_membre() != null) && ($util->getCode_gac_filiere() == null || $util->getCode_gac_filiere() == '')) {
                                    $this->view->message = "Ce compte doit être associé à un membre et à un gac Filière";
                                    $this->view->form = $form;
                                    return;
                               }
                        }
                            $util->setConnecte(1);
                            //$util_m->update($util);
                            $auth->getStorage()->write($data);
                            $this->_redirect('index2');
                        }
                    } else {
                           // failure: clear database row from session
                           $this->view->message = "Echec de l'identification";
                           $this->view->form = $form;
                           return;
                    }
                } catch (Exception $exc) {
                        $this->view->message = "Echec de l'identification :" . $exc->getMessage();
                        $this->view->form = $form;
                        //echo $exc->getTraceAsString();
                }
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('".
            $this->view->url(array(
                    'controller' => 'default',
                    'action' => 'index'
            ), 'default', true).
                "','_self')");
            $this->view->form = $form;
					
    }

	
    public function changepwdAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        if ($request->isPost()) {
          $id_user = $user->id_utilisateur;
          $nom_utilisateur = $request->nom_utilisateur;
          $prenom_utilisateur = $request->prenom_utilisateur;
          $login = $request->login;
          $oldpwd = $request->oldpwd;
          $newpwd = $request->newpwd;
          $newpwdconf = $request->newpwdconf;
		  $codepasse = $request->code_passe;
          $question_secrete = $request->question_secrete;
          $reponse = $request->reponse;
          try {
              if ($id_user != '') {
                 $user_mapper = new Application_Model_EuUtilisateurMapper();
                 $userm = new Application_Model_EuUtilisateur();
				 
				 $tableuser = new Application_Model_DbTable_EuUtilisateur();
				 $select = $tableuser->select();
				 $select->where('login = ?', $user->login)
                		->where('pwd = ?', md5($oldpwd))
                		->where('code_passe = ?', $codepasse);
        $resultSet = $tableuser->fetchRow($select);
        if (count($resultSet) > 0) { 
                $retour = $user_mapper->find($id_user, $userm);
                if ($retour && $userm->getPwd() == md5($oldpwd)) {
                    if ($newpwd == $newpwdconf) {
                        $userm->setLogin($login)
                             ->setPwd(md5($newpwd))
                             ->setConnecte(0)
						     ->setCh_pwd_flog(1);
					    if($question_secrete != '' && $reponse != ''){
							$userm->setQuestion_secrete($question_secrete)
                                  ->setReponse(md5($reponse));
					    }
                        $user_mapper->update($userm);
                } else {
                       $this->view->message = 'Les nouveau mots de passe ne correspondent pas !!!';
                       $this->view->id_user = $id_user;
                       $this->view->nom_utilisateur = $nom_utilisateur;
                       $this->view->prenom_utilisateur = $prenom_utilisateur;
                       $this->view->login = $login;
                       $this->view->oldpwd = $oldpwd;
                       $this->view->newpwd = $newpwd;
                       $this->view->newpwdconf = $newpwdconf;
                       $this->view->question_secrete = $question_secrete;
                       $this->view->reponse = $reponse;
                       return;
                }
                       $auth->clearIdentity();
                       $this->_redirect('index2');
                    }
                }
				} else {
					$this->view->message = "Le code de modification du mot de passe est incorrect ...";
                return;
					}
            } catch (Exception $exc) {
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
        } else {
            $id_user = $user->id_utilisateur;
            $this->view->login = $user->login;
            $this->view->nom_utilisateur = $user->nom_utilisateur;
            $this->view->prenom_utilisateur = $user->prenom_utilisateur;
            $this->view->id_user = $id_user;
        }
    }

	
    public function logoutAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $util = new Application_Model_EuUtilisateur();
        $util_m = new Application_Model_EuUtilisateurMapper();
        $util_m->find($user->id_utilisateur,$util);
        $util->setConnecte(0);
        $util_m->update($util);
        $auth->clearIdentity();
        $this->_redirect('index2');
    }




    public function beforechangepwdAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        if ($request->isPost()) {
          $id_user = $user->id_utilisateur;
		  
			$code_mot_de_passe = strtoupper(Util_Utils::genererCodeSMS(8));

			$utilisateur = new Application_Model_EuUtilisateur();
			$mapper = new Application_Model_EuUtilisateurMapper();
			$rep = $mapper->find($id_user, $utilisateur);
			
			$utilisateur->setCode_passe($code_mot_de_passe);
			$mapper->update($utilisateur);
		  
			$compteur = Util_Utils::findConuter() + 1;
			Util_Utils::addSms($compteur, $user->portable_membre, "Voici votre code de modification du mot de passe : ".$code_mot_de_passe);
		  
	return $this->_helper->redirector('changepwd', 'login', null, array('controller' => 'login', 'action' => 'changepwd'));

        } else {
            $id_user = $user->id_utilisateur;
        }
    }



}

