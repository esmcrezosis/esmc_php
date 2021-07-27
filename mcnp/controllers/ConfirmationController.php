<?php


include('Classes/phpqrcode/qrlib.php');
//include('Classes/phpqrcode/qrconfig.php');
//include('../../Classes/phpqrcode/qrlib.php');
class ConfirmationController extends Zend_Controller_Action{

        public function init() {
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
            /* Initialize action controller here */
            include("Url.php");

        }


        public function indexAction()
        {
                echo "test";

                $homepage = file_get_contents("https://esmcgie.com/notif/envoipush.php?message_confirmation=test
                &id_confirmation=1&code_membre=0010010010010091699P&nom_operateur=code_operateur&message=messagetest");
                print_r($homepage);

        }


        public function secureconfirmationmessageAction() {
		   $eurepresentation = new Application_Model_DbTable_EuRepresentation();
           $request = $this->getRequest();
           $message = $request->getParam('message_confirmation');
           $id_confirmation = $request->getParam('id_confirmation');
           $code_membre = $request->getParam('code_membre');
           $nom_operateur = $request->getParam('nom_operateur');
           $code_operateur = $request->getParam('code_operateur');

		   if(substr($code_membre, -1) == "P") {
                $homepage = file_get_contents("https://esmcgie.com/notif/envoipush.php?message_confirmation=".urlencode(($message))."&id_confirmation=".$id_confirmation."&code_membre=".$code_membre."&nom_operateur=".$code_operateur."&message=".$code_operateur);
                print_r($homepage);
				 
           } else if(substr($code_membre, -1) == "M")  {
				$select = $eurepresentation->select();
				$select->where('code_membre_morale = ?',$code_membre);
				//$select->where('etat like ?',"inside");
				$representants = $eurepresentation->fetchAll($select);
				
				foreach($representants as $row) {
					$homepage = file_get_contents("https://esmcgie.com/notif/envoipush.php?message_confirmation=".urlencode(($message))."&id_confirmation=".$id_confirmation."&code_membre=".$row->code_membre."&nom_operateur=".$code_operateur."&message=".$code_operateur);
                    print_r($homepage);
				}
		    }
				
        }




     public function requestAction() {
       $request = $this->getRequest();
       if($request->isPost()) {
                //  if($request->isPost()) {
                $table = new Application_Model_DbTable_EuConfirmation();
                $entryObject = new Application_Model_EuConfirmation();
                $mapper = new Application_Model_EuConfirmationMapper();

                $db = Zend_Db_Table::getDefaultAdapter();
        // $db->beginTransaction();

                $entryObject
                        ->setType_confirmation("1")
                        ->setCode_operateur($request->getParam('code_operateur'))
                        ->setCode_membre($request->getParam('code_membre'))
                        ->setNom_operateur($request->getParam('nom_operateur'))
                        ->setData_text($request->getParam('message_confirmation'))
                        ->setData_json("")
                        ->setStatus("1")
                        ->setActivite($request->getParam('activite'))
                        ->setDate_creation(time())
                        ->setDate_confirmation("0")
                        ->setTexte_confirmation($request->getParam('message_confirmation'))
                        ->setPage("");

                        $mapper->save($entryObject);
                        //$table->insert($entry);
                // $table->save($entry);

                // echo "nouvelle insertion".$db->lastInsertId();
                        $numero_insertion = $db->lastInsertId();

                $data[0] = array(
                        'status' => "1",
                        'id_verif' => $numero_insertion,
                        'texte_confirmation'=> "En attente de la confirmation du membre"
                        );
                        header('Content-type:application/json');
                        header('Access-Control-Allow-Origin: *');
                        die(json_encode($data[0]));


        }
        else
        {
                $data[0] = array(
                        'status' => "-1",
                        'texte_confirmation'=> "Transaction non autorisée"

                );
                header('Content-type:application/json');
                header('Access-Control-Allow-Origin: *');
                die(json_encode($data[0]));
        }

     }


     public function checktestAction()
     {
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();

        $data = array();

        $id_verification = 110;
        $code_operateur = "0010010010010091699P";

        $table = new Application_Model_DbTable_EuConfirmation();
        $entryObject = new Application_Model_EuConfirmation();
        $mapper = new Application_Model_EuConfirmationMapper();



        $dbQRRequeteTable = new Application_Model_DbTable_EuConfirmation();
        $dbQRRequete = new Application_Model_EuConfirmation();
        $authrow = new Application_Model_DbTable_EuConfirmation();

        $code_groupe = array('personne_physique');


       // $select = $authrow->select();

        // $data["resultat"] = $authrow->fetchAll();
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');


        $resulat = $authrow->find($id_verification);
        if(count($resulat) >= 1)  {
                for($i = 0; $i < count($resulat); $i++) {
                $value = $resulat[$i];
                $data[$i] = array(
                        'id_confirmation' => $value->id_confirmation,
                        'code_operateur'=> $value->code_operateur,
                        'status'=> $value->status,
                        'texte_confirmation'=> $value->texte_confirmation,
                        'sessionutilisateur'=> $sessionutilisateur->code_membre,
                        'confirmation'=> $sessionutilisateur->confirmation
                );

              //  echo '$sessionutilisateur->confirmation = '+$sessionutilisateur->confirmation;
                if($value->type_confirmation == "2")
                {
                        echo '$value->type_confirmation == 2';
                        if($value->status == "2")
                        {
                                echo '$value->status == 2';
                                $sessionutilisateur->confirmation = "";
                                $sessionutilisateur->login = $value->code_operateur;
                              //  echo '$sessionutilisateur->confirmation = '.$sessionutilisateur->confirmation;
                        }
                        if($value->status == "3")
                        {
                                echo '$value->status == 3';
                                Zend_Session::destroy(true);
                        }
                }
                else
                {
                        echo '$value->type_confirmation not equal 2';
                }



                }
        } else {
                // $data = '';
                $data = $resulat;
        }


        /*header('Access-Control-Allow-Origin: *');
        header('Content-type:application/json');
        die(json_encode($data[0]));*/
     }




     public function checkAction() {
        $this->_helper->layout()->disableLayout();
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $sessionmembre = new Zend_Session_Namespace('membre');
        $sessionutilisateur->confirmation = "";
        $request = $this->getRequest();

        $data = array();

        if($request->isPost()) {
           // if($request->isGet()) {
           $id_verification = $request->getParam('id_verification');
           $code_operateur = $request->getParam('code_operateur');

           $table = new Application_Model_DbTable_EuConfirmation();
           $entryObject = new Application_Model_EuConfirmation();
           $mapper = new Application_Model_EuConfirmationMapper();

           $db = Zend_Db_Table::getDefaultAdapter();

           $dbQRRequeteTable = new Application_Model_DbTable_EuConfirmation();
           $dbQRRequete = new Application_Model_EuConfirmation();
           $authrow = new Application_Model_DbTable_EuConfirmation();

           $code_groupe = array('personne_physique');
           // $select = $authrow->select();

           // $data["resultat"] = $authrow->fetchAll();
           $resulat = $authrow->find($id_verification);

           if(count($resulat) >= 1)  {
                for($i = 0; $i < count($resulat); $i++) {
                $value = $resulat[$i];



                $difference_temps = ((time() - $value->date_creation));

                if($difference_temps > 300)
                {
                        $entryObject
                        ->setId_confirmation($value->id_confirmation)
                     //   ->setDate_confirmation(time())
                        ->setStatus("4");

                      //  ->setCode_sms(""+$request->getParam('nom_appareil'))
                      //  ->setNom_appareil("".$request->getParam('nom_appareil'))
                    //    ->setImei_appareil("".$request->getParam('imei_appareil'))
                    //    ->setNumero_appareil("".$request->getParam('numero_appareil'))
                   //     ->setMac_appareil("".$request->getParam('mac_appareil'))
                    //    ->setIp_appareil("".$request->getParam('ip_appareil'));
    
                           $mapper->update($entryObject);
                }

                $data[$i] = array(
                        'difference_temps' => $difference_temps,
                        'id_confirmation' => $value->id_confirmation,
                        'code_operateur'=> $value->code_operateur,
                        'status'=> $value->status,
                        'texte_confirmation'=> $value->texte_confirmation,
                        'sessionutilisateur'=> $sessionutilisateur->code_membre,
                        'confirmation'=> $sessionutilisateur->confirmation,
                        'type_confirmation'=> $value->type_confirmation,
                        'date_creation'=> $value->date_creation,
                        'date_confirmation'=> $value->date_confirmation
                );

                if($value->type_confirmation == "2") {
                     if($value->status == "2") {
                             
			if($value->activite == "https://esmcgie.com/administration/securelogin") { 
                           $sessionutilisateur->confirmation = "";
                           $sessionutilisateur->login = $value->code_operateur;
                        }
						
						
                        if($value->activite == "https://esmcgie.com/index/securelogin") {
                           $sessionmembre->numero_confirmation = "";
                           $sessionmembre->confirmation_envoi= "";
                        }

                        if($value->activite == "https://esmcgie.com/integrateur/securelogin") {
                          $sessionmembreasso = new Zend_Session_Namespace('membreasso');
                          $sessionmembreasso->login = $value->code_operateur;
						}
						

						if($value->activite == "https://esmcgie.com/banqueopi/securelogin") {
						  $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
                          $sessionbanqueopi->login = $value->code_operateur;
						}

						if($value->activite == "https://esmcgie.com/index/securelogin") {
						  $sessionmembre = new Zend_Session_Namespace('membre');
						  $sessionmembre->code_membre = $value->code_operateur;
						}
						  
						if($value->activite == "https://esmcgie.com/terminal/securelogin") {  
						  $sessionterminal = new Zend_Session_Namespace('terminal');
						  $sessionterminal->login = $value->code_operateur;
						}
                      }
                      if($value->status == "3") {
                         Zend_Session::destroy(true);
                      }
                }
                }
        } else  {
           // $data = '';
           $data = $resulat;
        }

        }

        header('Access-Control-Allow-Origin: *');
        header('Content-type:application/json');
        die(json_encode($data[0]));
     }

}