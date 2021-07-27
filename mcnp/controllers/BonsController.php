<?php

class BonsController extends Zend_Controller_Action{

	public function init() {
	   /* Initialize action controller here */
       include("Url.php");
	}
 

	public function recudepayementdebanpdfAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
		//$bon_neutre_code = $sessionmcnp->code_BAn;
		//$bon_neutre_montant = $sessionmcnp->montantban;

        $id = (int) $this->_request->getParam('id');
        $this->view->id = $id;

        //Util_Utils::genererPdfBAn($id, $code);
        $this->_redirect(Util_Utils::genererRecuPdfBAn($id));
	}
	
	
	
	public function recudepayementdebanappropdfAction() {
        $sessionmembre = new Zend_Session_Namespace('membre');

        //$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		//$bon_neutre_code = $sessionmembre->code_BAn;
		//$bon_neutre_montant_appro = $sessionmembre->montantbanappro;

        $id = (int) $this->_request->getParam('id');
        $this->view->id = $id; 

        //Util_Utils::genererPdfBAn($id, $code);
        $this->_redirect(Util_Utils::genererRecuPdfBAn($id));
	}
	
	
	
	public function recudepayementdebanapprointegrateurpdfAction () {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
        //$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcint');
		//$this->_helper->layout()->setLayout('layoutpublicesmc');
		
		//$bon_neutre_code = (string)$this->_request->getParam('code');
        //$this->view->code = $bon_neutre_code;
		
		
		$id =  $this->_request->getParam('id');
        $this->view->id = $id;
		
		
		
		//$bon_neutre_code = $sessionmembreasso->code_BAn;
		//$bon_neutre_montant_appro = $sessionmembreasso->membreassomontanbanappro;
/*
        $id = (int)$this->_request->getParam('id');
        $this->view->id = $id;*/

        //Util_Utils::genererPdfBAn($id, $code);
        $this->_redirect(Util_Utils::genererRecuPdfBAn($id));
	}

	public function recudepayementdebanintegrateurAction () {
		$sessionmembreasso = new Zend_Session_Namespace('membreasso');
        

        //$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcint');
		$bon_neutre_code = $sessionmembreasso->code_BAn;
		$bon_neutre_montant_appro = $sessionmembreasso->montantbanmembreasso;
/*
        $id = (int)$this->_request->getParam('id');
        $this->view->id = $id;*/

        //Util_Utils::genererPdfBAn($id, $code);
        $this->_redirect(Util_Utils::genererRecuPdfBAn($bon_neutre_code, $bon_neutre_montant_appro));
	}
	
	public function recudepayementdebanapprointegrateurcmpdfAction () {
        $sessionmembreasso = new Zend_Session_Namespace('membreasso');
        

        //$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmcint');
		$bon_neutre_code = $sessionmembreasso->code_BAn;
		$bon_neutre_montant_appro = $sessionmembreasso->montantbanapprocm;
/*
        $id = (int)$this->_request->getParam('id');
        $this->view->id = $id;*/

        //Util_Utils::genererPdfBAn($id, $code);
        $this->_redirect(Util_Utils::genererRecuPdfBAn($bon_neutre_code, $bon_neutre_montant_appro));
	}
	
	public function recudepayementdebanbanquepdfAction () {
		$sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        

        //$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		$bon_neutre_code = $sessionbanqueopi->code_BAn;
		$bon_neutre_montant_appro = $sessionbanqueopi->montantbanbanque;
/*
        $id = (int)$this->_request->getParam('id');
        $this->view->id = $id;*/

        //Util_Utils::genererPdfBAn($id, $code);
        $this->_redirect(Util_Utils::genererRecuPdfBAn($bon_neutre_code, $bon_neutre_montant_appro));
	}
	
	public function recudepayementdebanapprobanquepdfAction () {		
		$sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
		

        //$this->_helper->layout->disableLayout();
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		$bon_neutre_code = $sessionbanqueopi->code_BAn;
		$bon_neutre_montant_appro = $sessionbanqueopi->montantbanapprobanqueopi;
/*
        $id = (int)$this->_request->getParam('id');
        $this->view->id = $id;*/

        //Util_Utils::genererPdfBAn($id, $code);
        $this->_redirect(Util_Utils::genererRecuPdfBAn($bon_neutre_code, $bon_neutre_montant_appro));
    }

    public function achteurrevendeurAction() {
          $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
          $db = Zend_Db_Table::getDefaultAdapter();
		  $sessionmembre = new Zend_Session_Namespace('membre');	


		  $code_membre_utilisateur  = $sessionmembre->code_membre;
		
		  if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $dbverifid = " SELECT eu_convention.id_convention
            FROM eu_convention
			WHERE eu_convention.code_membre = '$code_membre_utilisateur'
			AND eu_convention.signature_new_convention = 1";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationducodemembrebyconvention = $stmt->fetchAll();
            $countdbverificationducodemembrebyconvention = count($dbverificationducodemembrebyconvention);
	
			$dbverifid = " SELECT eu_convention_eli_opi.id_convention_eli
            FROM eu_convention_eli_opi
            WHERE eu_convention_eli_opi.code_membre = '$code_membre_utilisateur'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationducodemembrebyeli = $stmt->fetchAll();
			$countdbverificationducodemembrebyeli = count($dbverificationducodemembrebyeli);
			
			$dbverifid = " SELECT *
            FROM eu_form_avr
            WHERE eu_form_avr.code_membre_avr = '$code_membre_utilisateur'";
            $db->setFetchMode(Zend_Db::FETCH_OBJ);
            $stmt = $db->query($dbverifid);
            $dbverificationducodemembrebyavr = $stmt->fetchAll();
            $countdbverificationducodemembrebyavr = count($dbverificationducodemembrebyavr);

            if($countdbverificationducodemembrebyconvention == 0){

				$this->_redirect('/convention');		              
				
			}
			
			if($countdbverificationducodemembrebyeli == 0){
                if (in_array(substr($code_membre_utilisateur,-1), array('M'))) {
					$this->_redirect('/formsguichet/engagementdelivraisonirrevocablebpspourlesmembresdejainscrit');		              
				}
				if(in_array(substr($code_membre_utilisateur,-1), array('P'))){

					$this->_redirect('/formsguichet/validationdelaconventionelipersonnephysiquespacepersonnel');	                                
				}
			}
			
			if($countdbverificationducodemembrebyavr == 0){
				$this->_redirect('/formsguichet/formulaireassociativedebpsvenduetdebpsacheterventereciproques2');		              
			}
		  }
          $dbrevselect = "SELECT DISTINCT(eu_revendeur.nom_produit) FROM  eu_revendeur ";
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $revmt = $db->query($dbrevselect);
		  $dbrevselect_all = $revmt->fetchAll();
		  
		  if (in_array(substr($code_membre_utilisateur,-1), array('P'))) {
			$dbrevselect = "SELECT eu_compte_bancaire.num_compte_bancaire, eu_compte_bancaire.code_banque FROM  eu_compte_bancaire WHERE eu_compte_bancaire.code_membre ='$code_membre_utilisateur' AND eu_compte_bancaire.principal = 1";
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			$cptprinc = $db->query($dbrevselect);
			$dbcptprincselect_all = $cptprinc->fetchAll();		  
		  }

		  if (in_array(substr($code_membre_utilisateur,-1), array('M'))) {
			$dbrevselect = "SELECT eu_compte_bancaire.num_compte_bancaire, eu_compte_bancaire.code_banque FROM  eu_compte_bancaire WHERE eu_compte_bancaire.code_membre_morale ='$code_membre_utilisateur' AND eu_compte_bancaire.principal = 1";
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			$cptprinc = $db->query($dbrevselect);
			$dbcptprincselect_all = $cptprinc->fetchAll();
		  
		  }


          $dbbqselect = "SELECT * FROM  eu_banque ";
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $bqmt = $db->query($dbbqselect);
          $dbbqselect_all = $bqmt->fetchAll();

          $dbtegcselect = "SELECT eu_tegc.code_tegc, eu_tegc.nom_tegc, eu_tegc.code_membre_physique  FROM  eu_tegc WHERE eu_tegc.code_membre_physique = '$code_membre_utilisateur'";
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $tegcmt = $db->query($dbtegcselect);
          $dbtegcselect_all = $tegcmt->fetchAll();


          $dbtelselect = "SELECT DISTINCT(eu_telephone.numero_telephone), eu_telephone.compagnie_telephone  FROM  eu_telephone  WHERE eu_telephone.code_membre = '$code_membre_utilisateur'";
          $db->setFetchMode(Zend_Db::FETCH_OBJ);
          $telmt = $db->query($dbtelselect);
          $dbtelselect_all = $telmt->fetchAll();

          $this->view->produits = $dbrevselect_all;
          $this->view->banques = $dbbqselect_all;
          $this->view->terminale = $dbtegcselect_all;
		  $this->view->telephone = $dbtelselect_all;
          $this->view->compteprincipale = $dbcptprincselect_all;
		  
	}
     
	     public function sendsmsoperateurAction(){
     	  $this->_helper->layout->disableLayout();
          $resultjson = array();
          $content_message = "";
		  $errors_message = "";
		 
		  
          $code_membre_utilisateur = $_SESSION['membre']['code_membre'];
          $numero_telephone = $_POST['numero_telephone'];
		 
          $dbban = Zend_Db_Table::getDefaultAdapter();
          $dbcapa = Zend_Db_Table::getDefaultAdapter();
          $map_sms_connexion = new Application_Model_EuSmsConnexionMapper();
          $sms_connexion = new Application_Model_EuSmsConnexion();
          $dbsms_connexion = new Application_Model_DbTable_EuSmsConnexion();
          $date_sms_now = Zend_Date::now();


          $dbsms_connexion_select = $dbsms_connexion->select();

          $dbsms_connexion_select->from('eu_sms_connexion',array('MAX(sms_connexion_id) as count'));
          $dbsms_connexion_id = $dbsms_connexion->fetchAll($dbsms_connexion_select);
          $new_sms_connexion_id = $dbsms_connexion_id[0]['count'] + 1; 
		  $max_sms_connexion_id = $dbsms_connexion_id[0]['count'];
           
          $dbbanselect = "SELECT eu_bon_neutre.bon_neutre_montant_solde, eu_bon_neutre.bon_neutre_code  FROM  eu_bon_neutre  WHERE eu_bon_neutre.bon_neutre_code_membre = '$code_membre_utilisateur'";
          $dbban->setFetchMode(Zend_Db::FETCH_OBJ);
          $dbbanmt = $dbban->query($dbbanselect);
          $dbbanselect_all = $dbbanmt->fetchAll();


          $dbcapaselect = "SELECT SUM(eu_capa.montant_solde) as Montant_Solde_Revendeur  FROM  eu_capa  WHERE eu_capa.code_membre = '$code_membre_utilisateur'";
          $dbcapa->setFetchMode(Zend_Db::FETCH_OBJ);
          $dbcapamt = $dbcapa->query($dbcapaselect);
          $dbcapaselect_all = $dbcapamt->fetchAll();

          $sms_code = Util_Utils::genererCodeSMS(5);
		  $new_smscode = strtoupper($sms_code);
		  $receive_code = Util_Utils::genererCodeSMS(5);
		  $new_receive_code = strtoupper($receive_code);
		  

          if($_POST['type_souscription'] == "BAI"){
               if(count($dbcapaselect) > 0){
                   $montant_bai = $dbcapaselect_all[0]->Montant_Solde_Revendeur;
                   $montant_bai_saisi = $_POST['montant_ban'];
                  if($montant_bai >= $montant_bai_saisi){
                     $content_message = "ESMC:".$new_receive_code." est votre Code de confirmation de operation acheteur revendeur";
                  }else{
                    $errors_message = "Operation non effectué. Le montant BAi saisi est superieur au montant BAi disponible";
                  }
               }else{
                    $errors_message = "Operation non effectué. Le montant BAi disponible est insuffisant";
			   }
          }

          if($_POST['type_souscription'] == "BAN"){
              if(count($dbbanselect_all) > 0){
                   $code_ban_revendeur = $dbbanselect_all[0]->bon_neutre_code;
                   $montant_ban_solde = $dbbanselect_all[0]->bon_neutre_montant_solde;
                   $montant_ban_saisi = $_POST['montant_ban'];
                 if($montant_ban_solde >= $montant_ban_saisi){
                    $content_message = "ESMC:".$new_receive_code." est votre Code de confirmation de operation acheteur revendeur";
                 }else{
                    $errors_message = "Operation non effectué. Le montant BAn saisi est superieur au montant BAn disponible";			 
                }
              }else{
                    $errors_message = "Operation non effectué. Le montant BAn disponible est insuffisant";				  
			  }
          }
		
		if($content_message == "" && $errors_message != ""){
               $resultjson = array('success'=>'false', 'successcontent'=>"$errors_message");					
		}
        if($content_message != ""){
				$compteur = Util_Utils::findConuter() + 1; 
				$paramdbesmc = Util_Utils::getParamEsmc(12);
                $sms_connexion->setSms_connexion_id($new_sms_connexion_id)
                              ->setSms_connexion_code_envoi($new_smscode)
                              ->setSms_connexion_code_membre($code_membre_utilisateur)
                              ->setSms_connexion_code_recu($content_message)
                              ->setSms_connexion_date($date_sms_now->toString('yyyy-MM-dd HH:mm:ss'))
                              ->setSms_connexion_utilise(0);
                 $map_sms_connexion->save($sms_connexion);			  
			     $resultjson = array('success'=>'true', 'paramesmc'=> $paramdbesmc, 'smsenvoicourt'=>$new_smscode);		
		}  
             
            header('Content-type:application/json');
           die(json_encode($resultjson));
  }
    public function curlAction(){
        $content_message = "Operation bien effectue";

		$numero_telephone = "22891975052";
		$compteur = Util_Utils::findConuter() + 1; 
        Util_Utils::addSms3Easys($compteur, $numero_telephone, $content_message);
  }


    public function communiqueAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}

	public function legalitelistingAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}

	public function coordinationationaldesentitesAction () {
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}

	public function framevideolegaliteesmcAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');

	}

	public function frameaudiolegaliteesmcAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}


	public function framevideoappelmondialpppmAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');

	}

	public function frameaudioappelmondialpppmAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}

	public function framevideoappelmondialancienpppmAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');

	}

	public function frameaudioappelmondialancienpppmAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}

	public function framevideoappelmodialfoaddipAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');

	}

     public function framevideoappelmondialfoaddipAction () {
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		 
	 }

	public function framevideoappelmondialpbfAction () {
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}


	public function frameaudioappelmodialfoaddipAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}

	public function framevideoappelmodialpbfAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');

	}

	public function frameaudioappelmodialpbfAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}

	public function legaliteAction(){
		$this->_helper->layout()->setLayout('layoutpublicesmc');
		
	}

	public function legaliteflipAction(){
		$this->_helper->layout()->disableLayout();
		
	}

	public function contratprestataireAction () {
		var_dump(Zend_Version::VERSION);
	}
    public function urlAction(){

		$db = Zend_Db_Table::getDefaultAdapter();
        $resultjson = array();		
		$confirmationducodemembreatraversleqrcode = $_POST['codeMembreRevendeur'];
		$type_bon = $_POST['typeBon'];
		$montant_bon = $_POST['montantBon'];
		$curl = curl_init();
		$designation_produit = "Production Commune";
		$code_tegc = $_POST['codeTegc'];
		$mode_paiement = $_POST['modePaiement'];
		$reference_paiement = $_POST['referencePayement'];
		$reinjecter = $_POST['reinjecter'];
		$nbre_injection = $_POST['nbreInjection'];
		/*$code_confirmation = $_POST['codeConfirmation'];
		$code_envoi = $_POST['codeEnvoi'];*/
		$codeMembreRevendeur = $_SESSION['membre']['code_membre'];
		$code = "MDAxMDAxMDAxMDAxMDAzODIzMFA6QlQ1RkpCWGc=";
		$errors_type_bon_message = "";

		
		/*
		$dbconfirmselect = "SELECT eu_confirmation.id_confirmation  FROM  eu_confirmation  WHERE eu_confirmation.code_membre = '$confirmationducodemembreatraversleqrcode' AND eu_confirmation.status = 2";
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$dbconfirm = $db->query($dbbanselect);
		$dbconfirmselect_all = $dbconfirm->fetchAll();



		if(count($dbconfirmselect_all) == 0){
			$resultjson = array('answer'=>'Vous tentez d\'effectuer une action qui n\'est pas autorisé!');          
		}

		if(count($dbconfirmselect_all) != 0){	*/
	
	
			if($type_bon == "BAI"){
				$dbcapaselect = "SELECT SUM(eu_capa.montant_solde) as Montant_Solde_Revendeur  FROM  eu_capa  WHERE eu_capa.code_membre = '$confirmationducodemembreatraversleqrcode'";
				$dbcapa->setFetchMode(Zend_Db::FETCH_OBJ);
				$dbcapamt = $dbcapa->query($dbcapaselect);
				$dbcapaselect_all = $dbcapamt->fetchAll();
				
				if(count($dbcapaselect_all) > 0){
					$montant_bai = $dbcapaselect_all[0]->Montant_Solde_Revendeur;
				   if($montant_bai < $montant_bon){
	
					 $errors_type_bon_message = "Operation non effectué. Le montant BAi saisi est superieur au montant BAi disponible";
				   }
				}else{
					 $errors_type_bon_message = "Operation non effectué. Le montant BAi disponible est insuffisant";
				}
		   }
	
		   if($type_bon == "BAN"){
			$dbbanselect = "SELECT eu_bon_neutre.bon_neutre_montant_solde, eu_bon_neutre.bon_neutre_code  FROM  eu_bon_neutre  WHERE eu_bon_neutre.bon_neutre_code_membre = '$confirmationducodemembreatraversleqrcode'";
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			$dbbanmt = $db->query($dbbanselect);
			$dbbanselect_all = $dbbanmt->fetchAll();

			   if(count($dbbanselect_all) > 0){
					$code_ban_revendeur = $dbbanselect_all[0]->bon_neutre_code;
					$montant_ban_solde = $dbbanselect_all[0]->bon_neutre_montant_solde;
				  if($montant_ban_solde < $montant_bon){
					 $errors_type_bon_message = "Operation non effectué. Le montant BAn saisi est superieur au montant BAn disponible";			 
				   }
			   }else{
					 $errors_type_bon_message = "Operation non effectué. Le montant BAn disponible est insuffisant";				  
			   }
		   }

		   if($errors_type_bon_message != ""){
     			$resultjson = array('answer'=>$errors_type_bon_message);          
		   }

		   if($errors_type_bon_message == ""){

            curl_setopt_array($curl, array(
               CURLOPT_URL => "http://tom.gacsource.net/jmcnpApi/revendeur/souscrire",
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => "",
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 30,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => "POST",
               CURLOPT_POSTFIELDS => "{\n\t\"codeMembreRevendeur\":\"$codeMembreRevendeur\",\n\t\"designationProduit\":\"$designation_produit\",\n\t\"codeTegc\":\"$code_tegc\",\n\t\"modePaiement\":\"$mode_paiement\",\n\t\"referencePayement\":\"$reference_paiement\",\n\t\"typeBon\":\"$type_bon\",\n\t\"montantBon\":\"$montant_bon\",\n\t\"reinjecter\":$reinjecter,\n\t\"nbreInjection\":$nbre_injection,\n\t\"codeEnvoi\":\"$code_envoi\",\n\t\"codeConfirmation\":\"$code_confirmation\"\n\n}",
               CURLOPT_HTTPHEADER => array(
                 "authorization: Basic dXNlcndlYnNlcnZpY2U6VXNlckAwNiEyMDE3X1NlSTIqJcK1I2ljZQ==",
                 "content-type: application/json"
               ),
            ));

            $response = json_decode(curl_exec($curl));
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
              $resultjson = array('errors'=>$err);          
            } else {
			  $response_message = $response->message;
              $resultjson = array('answer'=>$response_message);            
			}
         }
			
	    /*}*/

            header('Content-type:application/json');
           die(json_encode($resultjson));
    }


	public function listdesdifferentsbonsAction(){
	   $sessionmembre = new Zend_Session_Namespace('membre');
 		 $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			  $this->_redirect('/');
		 }

         $bontype = (string) $this->_request->getParam('bontype');
		 if($bontype != ""){

		$this->view->bontype = $bontype;

		 $map_bon = new Application_Model_EuBonMapper();
         $db_bon = new Application_Model_EuBon();

         $touslesbons = $map_bon->fetchAllByMembre($sessionmembre->code_membre, $bontype);
         $this->view->entries = $touslesbons;

        $this->view->tabletri = 1;
		}

	}


public function listdestegcAction(){
	   $sessionmembre = new Zend_Session_Namespace('membre');
 		 $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			  $this->_redirect('/');
		 }


		 $map_tegc = new Application_Model_EuTegcMapper();
         $db_tegc = new Application_Model_EuTegc();

         $touslestegcs = $map_tegc->fetchByMembre($sessionmembre->code_membre);
         $this->view->entries = $touslestegcs;

        $this->view->tabletri = 1;


	}

	public function listdesdifferentsbons2Action(){
	   $sessionmembre = new Zend_Session_Namespace('membre');
 		 $this->_helper->layout()->setLayout('layoutpublicesmcperso');

		 if (!isset($sessionmembre->code_membre)) {
			  $this->_redirect('/');
		 }

         $bontype = (string) $this->_request->getParam('bontype');
		 if($bontype != ""){

		$this->view->bontype = $bontype;

		 $map_bon = new Application_Model_EuBonMapper();
         $db_bon = new Application_Model_EuBon();

         $touslesbons = $map_bon->fetchAllByMembre2($sessionmembre->code_membre, $bontype);
         $this->view->entries = $touslesbons;

        $this->view->tabletri = 1;
		}

	}


public function listdesdifferentsbonsdistributeurAction(){
     $sessionmembre = new Zend_Session_Namespace('membre');
     $this->_helper->layout()->setLayout('layoutpublicesmcperso');

     if (!isset($sessionmembre->code_membre)) {
        $this->_redirect('/');
     }

         $bontype = (string) $this->_request->getParam('bontype');
     if($bontype != ""){

    $this->view->bontype = $bontype;

     $map_bon = new Application_Model_EuBonMapper();
         $db_bon = new Application_Model_EuBon();

         $touslesbons = $map_bon->fetchAllByDistributeur($sessionmembre->code_membre, $bontype);
         $this->view->entries = $touslesbons;

        $this->view->tabletri = 1;
    }

  }

  public function centraledachatcommuneAction() {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	   

  }

  public function centraledeproductioncommuneAction() {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  }

  public function centraledetransformationcommuneAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  }

  public function guichetuniquedintegrationuniverselleAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  }

  public function conventiongenererpdfAction () {
	$sessionmembre = new Zend_Session_Namespace('membre');
	$codemembre = $sessionmembre->code_membre;

	$this->_redirect(Util_Utils::genererPdfConvention($codemembre));

  }

  public function conventiongenererpdftestAction () {
	$codemembre = "0010010010010000395M";
	$db = Zend_Db_Table::getDefaultAdapter();
	

	$this->_redirect(Util_Utils::genererPdfConvention($codemembre));



  }

  public function franchisegenererpdfAction () {
	  
	$sessionmembre = new Zend_Session_Namespace('membre');
	$codemembre = $sessionmembre->code_membre;	

	$this->_redirect(Util_Utils::genererPdfFranchise($codemembre));
  }

  public function franchisegeneratestpdfAction () {
	$codemembre = "0010010010010000089M";

	$this->_redirect(Util_Utils::genererPdfFranchise($codemembre));
  }

  public function debugconventionpdfAction () {
	$codemembre = (string)$this->_request->getParam('codemembre');
	$db = Zend_Db_Table::getDefaultAdapter();

	$dbtselect = "SELECT *
	              FROM eu_convention
	              WHERE eu_convention.code_membre = '$codemembre'
	              AND eu_convention.signature_new_convention = 1";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
	$dbsearchconventionmembre = $stmt->fetchAll();
	
	$countdbsearchconventionmembre = count($dbsearchconventionmembre);


	if (in_array(substr($codemembre,-1), array('P')) && $countdbsearchconventionmembre > 0){
		$dbtselect = "SELECT *
		              FROM eu_convention
		              WHERE eu_convention.code_membre = '$codemembre'
		              AND eu_convention.signature_new_convention = 1";
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $stmt = $db->query($dbtselect);
		$dbsearchconventionmembre = $stmt->fetchAll();
		var_dump($dbsearchconventionmembre);
		var_dump($dbsearchconventionmembre[0]->nom);
		
   
   }

  }

  public function engagementdelivraisonirrevocablegenererpdfAction () {

	$sessionmembre = new Zend_Session_Namespace('membre');
	$codemembre = $sessionmembre->code_membre;

	$this->_redirect(Util_Utils::genererPdfEli($codemembre));
   
  }

  public function elicodemembreAction () {
	$db = Zend_Db_Table::getDefaultAdapter();

    $dbtselect = "SELECT * FROM eu_convention_eli_opi WHERE code_membre = '0010010010010000009P'";
    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
	$dbsearchpersonnephysique = $stmt->fetchAll();
	
	var_dump($dbsearchpersonnephysique);
	var_dump($dbsearchpersonnephysique[0]->id_convention_eli);

	if ((in_array(substr($code_membre_fournisseur,-1), array('M')))){

	}
	
	
	  
  }
  public function guichetuniquedintegrationuniversellecommunauteAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  }

  public function guichetuniquedintegrationuniverselleutilisateurAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
	  
  }

   public function guichetuniquedintegrationuniverselleinterfacepartenaireoddAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

   }
    public function bapdfAction() {
	    $sessionmcnp = new Zend_Session_Namespace('mcnp');

		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');

		$id = (int)$this->_request->getParam('id');
	    $this->view->id = $id;
		$numero = (string)$this->_request->getParam('numero');
	    $this->view->numero = $numero;

        //Util_Utils::genererPdfBA($id, $numero);
$this->_redirect(Util_Utils::genererPdfBA($id, $numero));

	}





    public function bcrpdfAction() {
	    $sessionmcnp = new Zend_Session_Namespace('mcnp');

		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');

		$id = (int)$this->_request->getParam('id');
	    $this->view->id = $id;
		$numero = (string)$this->_request->getParam('numero');
	    $this->view->numero = $numero;

        //Util_Utils::genererPdfBCr($id, $numero);
$this->_redirect(Util_Utils::genererPdfBCr($id, $numero));

	}


    public function bcnrpdfAction() {
	    $sessionmcnp = new Zend_Session_Namespace('mcnp');

		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');

		$id = (int)$this->_request->getParam('id');
	    $this->view->id = $id;
		$numero = (string)$this->_request->getParam('numero');
	    $this->view->numero = $numero;

        //Util_Utils::genererPdfBCnr($id, $numero);
$this->_redirect(Util_Utils::genererPdfBCnr($id, $numero));

	}


    public function bcpdfAction() {
	    $sessionmcnp = new Zend_Session_Namespace('mcnp');

		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');

		$id = (int)$this->_request->getParam('id');
	    $this->view->id = $id;
		$numero = (string)$this->_request->getParam('numero');
	    $this->view->numero = $numero;

        //Util_Utils::genererPdfBC($id, $numero);
$this->_redirect(Util_Utils::genererPdfBC($id, $numero));

	}



    public function bspdfAction() {
	    $sessionmcnp = new Zend_Session_Namespace('mcnp');

		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');

		$id = (int)$this->_request->getParam('id');
	    $this->view->id = $id;
		$numero = (string)$this->_request->getParam('numero');
	    $this->view->numero = $numero;

        //Util_Utils::genererPdfBS($id, $numero);
$this->_redirect(Util_Utils::genererPdfBS($id, $numero));

	}


    public function blpdfAction() {
	    $sessionmcnp = new Zend_Session_Namespace('mcnp');

		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');

		$id = (int)$this->_request->getParam('id');
	    $this->view->id = $id;
		$numero = (string)$this->_request->getParam('numero');
	    $this->view->numero = $numero;

        //Util_Utils::genererPdfBL($id, $numero);
$this->_redirect(Util_Utils::genererPdfBL($id, $numero));

	}




    public function blgpdfAction() {
      $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');

    $id = (int)$this->_request->getParam('id');
      $this->view->id = $id;
    $numero = (string)$this->_request->getParam('numero');
      $this->view->numero = $numero;

        //Util_Utils::genererPdfBLG($id, $numero);
$this->_redirect(Util_Utils::genererPdfBLG($id, $numero));

  }



	public function connectAction(){
//initialisation des tables intervenant dans la base
	 $db_souscription = new Application_Model_DbTable_EuSouscription();
	 $db_membre = new Application_Model_DbTable_EuMembre();
	 $db_sms = new Application_Model_DbTable_EuSms();
	 $db_code_activation = new Application_Model_DbTable_EuCodeActivation();
	 $db_ancien_membre = new Application_Model_DbTable_EuAncienMembre();



	 $db_souscription_select = $db_souscription->select();
	 $db_membre_select = $db_membre->select();
	 $db_ancien_membre_select = $db_ancien_membre->select();
	 $db_code_activation_select = $db_code_activation->select();



	 $nom_membre = "DK";
	 $prenom_membre = "RODRIGUE";
	 $code_membre = "";

	 if($nom_membre !== "" && $prenom_membre !== ""){
			 $db_membre_select->from('eu_membre')
												->where("nom_membre like '%$nom_membre%'")
												->where("prenom_membre like '%$prenom_membre%'");
	 }

	 if($code_membre !== ""){
			 $db_membre_select->from('eu_membre')
												->where("code_membre like '%$code_membre%'");
	 }
		$db_membre_result = $db_membre->fetchAll($db_membre_select);


	if(count($db_membre_result) >= 1){
			$find_code_membre = $db_membre_result[0]["code_membre"];
			$db_sms_select = $db_sms->select();
			$db_sms_select->from('eu_sms')
										 ->where("smsbody like '%$find_code_membre%'");
			$db_sms_result = $db_sms->fetchAll($db_sms_select);
			if(count($db_sms_result) > 0){
				$variable_sms = array('mcnp','mcnp!','mcnp!!','mcnp!!!','MCNP ','MCNP!','MCNP!!','MCNP!!!');
				 $message_sms = explode('Bienvenue dans le reseau',$db_sms_result[0]['smsbody']);
				 $recup_true_message_sms = "";
				 foreach ($variable_sms as  $value) {
					if(strpos($message_sms[1], $value) !== false){
						$explode_message_sms = explode($value, $message_sms[1]);
						$recup_true_message_sms = $explode_message_sms[1];
					}
				 }
			}

	}else{
			 $db_souscription_select->from('eu_souscription')
															->where("souscription_nom like '%AHARA%'")
															->where("souscription_prenom like '%Torrah%'")
															->where('souscription_programme like ?', "KACM")
															->where('publier like ?', '3');
			 $res_souscription = $db_souscription->fetchAll($db_souscription_select);
			 if(count($res_souscription) > 0){
/*
					if(count($res_souscription) === 1){
							 echo "Presence de Doublons.Vous devez supprimer le doublons";
					 }*/

					 if(count($res_souscription) > 0){
						 echo "Presence de Doublons.Vous devez supprimer le doublons ayant pour id $res_souscription[0]['souscription_id'], $res_souscription[1]['souscription_id']";
						 var_dump($res_souscription);

					 }

					if(count($res_souscription) === 1){
						 $res_souscription_id = $res_souscription[0]["souscription_id"];
						 $db_code_activation_select->from('eu_code_activation')
																			 ->where('souscription_id like ?', $res_souscription_id);
						 $res_code_activation = $db_code_activation->fetchAll($db_code_activation_select);
						 if(count($res_code_activation) > 0){

							 if(count($res_code_activation) === 1){
									if($res_code_activation[0]['code_membre'] !== ""){
										$db_sms_select = $db_sms->select();
										$db_sms_select->from('eu_sms')
																	 ->where("smsbody like '%$res_code_activation[0]['code_membre']%'");
										$db_sms_result = $db_sms->fetchAll($db_sms_select);
										if(count($db_sms_result) > 0){
											$variable_sms = array('mcnp','mcnp!','mcnp!!','mcnp!!!','MCNP ','MCNP!','MCNP!!','MCNP!!!');
											 $message_sms = explode('Bienvenue dans le reseau',$db_sms_result[0]['smsbody']);
											 $recup_true_message_sms = "";
											 foreach ($variable_sms as  $value) {
												if(strpos($message_sms[1], $value) !== false){
													$explode_message_sms = explode($value, $message_sms[1]);
													$recup_true_message_sms = $explode_message_sms[1];
												}
											 }
											 echo $recup_true_message_sms;
										}
									}
							 }

								var_dump($res_code_activation);

						 }else if(count($res_souscription) === 0){
							 echo "Aucun code d'activation trouvé pour Mr/Mme $res_souscription[0]['souscription_nom']";
						 }

					}
			 }

			 if(count($res_souscription) <= 0){
					 $db_ancien_membre_select->from('eu_ancien_membre')
																	->where("nom_membre like '%$nom_membre%'")
																	->where("prenom_membre like '%$prenom_membre%'");
					 $res_ancien_membre = $db_ancien_membre_select->fetchAll($db_ancien_membre_select);
					 if(count($res_ancien_membre) > 0){
								echo "Ce membre doit faire reactivation";
					 }

					 if(count($res_ancien_membre) <= 0){
							 echo "Aucun resultat trouvé";
					 }


			 }
	}

}

public function declarelessalarieAction(){

	//Declaration de variable
			$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
			$map_membre_morale = new Application_Model_EuMembreMoraleMapper();
			$db_membre_morale = new Application_Model_EuMembreMorale();
			$map_membre = new Application_Model_EuMembreMapper();
			$db_membre = new Application_Model_EuMembre();
			$map_employe = new Application_Model_EuEmployeMapper();
			$db_employe = new Application_Model_EuEmploye();

			$request = $this->getRequest();
			$validationerrors = array();
			if($request->getPost()){
					$validraisonsociale = $map_membre_morale->resultfindByCodeMembreMorale($_POST['member_moral_salarial'], $db_membre_morale);

					$validmembre = $map_membre->resultfindByCodeMembre($_POST['member_salarial'], $db_membre);
					$raison_sociale = $validraisonsociale->raison_sociale;
					$lastname = $validmembre->nom_membre;
					$firstname = $validmembre->prenom_membre;

				//Conditionnement et Verification de la validité des donnée envoyé dans la base de donnée
						//Les Données ne doivent pas être vide
				if($_POST['member_moral_salarial'] === ""){
						$validationerrors['empty_membre_moral_salarial'] = "Le Code Membre Morale ne doit pas être vide";
				}

				if(!array_key_exists('member_moral_salarial', $_POST)){
						$validationerrors['exist_membre_moral_salarial'] = "Erreur 404:Le Code Membre Morale n'existe pas";
				}

				if($_POST['member_salarial_raison'] === ""){
						$validationerrors['empty_raison_salarial'] = "La Raison Sociale de Membre Morale ne doit pas être vide";
				}

				if($_POST['member_salarial_raison'] !== $raison_sociale){
						$validationerrors['valid_raison_salarial'] = "La Raison Sociale de Membre Morale n'est pas valide";
				}

				if(!array_key_exists('member_salarial_raison', $_POST)){
						$validationerrors['exist_raison_salarial'] = "La Raison Sociale de Membre Morale n'existe pas";
				}

				if($_POST['member_salarial'] === ""){
						$validationerrors['empty_membre_salarial'] = "Le Code Membre ne doit pas être vide";
				}

				if(!array_key_exists('member_salarial',$_POST)){
						$validationerrors['exist_membre_salarial'] = "Le Code Membre du salarié n'existe pas";
				}

				if($_POST['name_salarial'] === ""){
						$validationerrors['name_salarial'] = "Le Nom du Salarié ne doit pas être vide";
				}

				if($_POST['name_salarial'] !== $lastname){
						$validationerrors['valid_name_salarial'] = "Le Nom du Salarié n'est pas valide";
				}
				if(!array_key_exists('name_salarial', $_POST)){
						$validationerrors['name_salarial'] = "Le Nom du Salarié n'existe pas";
				}

				if(!array_key_exists('firstname_salarial', $_POST)){
						$validationerrors['firstname_salarial'] = "Le Prenom du Salarié n'existe pas";
				}

				if($_POST['firstname_salarial'] === ""){
						$validationerrors['firstname_salarial'] = "Le Prenom du Salarié ne doit pas être vide";
				}

				if($_POST['firstname_salarial'] !== $firstname){
						$validationerrors['valid_firstname_salarial'] = "Le Prenom du Salarié n'est pas valide";
				}

				if(!array_key_exists('montant_salarial', $_POST)){
						$validationerrors['montant_salarial'] = "Le Montant du Salarié n'existe pas";
				}

				if($_POST['montant_salarial'] === ""){
						$validationerrors['montant_salarial'] = "Le Montant du Salarié ne doit pas être vide";
				}
					if(!filter_var($_POST['member_moral_salarial'], FILTER_VALIDATE_REGEXP,
						 array("options"=>array("regexp"=>"#^[0-9]{19}(M)$#")))){
						 $validationerrors['num_membre_moral_salarial'] = "Le Code Membre Morale n'est pas correcte";
					 }

					if(!filter_var($_POST['member_salarial'], FILTER_VALIDATE_REGEXP,
						 array("options"=>array("regexp"=>"#^[0-9]{19}(P)$#")))){
						 $validationerrors['num_membre_moral_salarial'] = "Le Code Membre n'est pas correcte";
					 }

					if(!filter_var($_POST['name_salarial'], FILTER_VALIDATE_REGEXP,
						 array("options"=>array("regexp"=>"#[^0-9]#")))){
						 $validationerrors['name_salarial'] = "Le Nom ne doit pas contenir des valeurs numériques";
					 }

					if(!filter_var($_POST['firstname_salarial'], FILTER_VALIDATE_REGEXP,
						 array("options"=>array("regexp"=>"#[^0-9]#")))){
						 $validationerrors['firstname_salarial'] = "Le Prenom ne doit pas contenir des valeurs numériques";
					 }

					if(filter_var($_POST['montant_salarial'], FILTER_VALIDATE_REGEXP,
						 array("options"=>array("regexp"=>"#[^0-9]#")))){
						 $validationerrors['firstname_salarial'] = "Le Montant doit être numérique";
					 }

					 if(!empty($validationerrors)){
							$_SESSION['validationerrors'] = $validationerrors;
					 }
	if(empty($validationerrors)){

			$db = Zend_Db_Table::getDefaultAdapter();
			$t_employe = new Application_Model_DbTable_EuEmploye();

			$emp_select = $t_employe->select();
			$emp_select->where('code_membre_employe like ?', $_POST['member_salarial'])
								 ->where('code_membre_employeur like ?', $_POST['member_moral_salarial']);
			$results = $t_employe->fetchAll($emp_select);
			if (count($results) > 0) {
				$row = $results->current();
				$validationseconderrors['duplicate_entry'] = 'Cet membre N°: ' . $row->code_membre_employe . ' a été déjà enregistré chez l\'employeur N°: ' . $row->code_membre_employeur . ' !!!';
			} else {
				$id_employe = $map_employe->findConuter() + 1;
				$date_declaration = Zend_Date::now();
				$db_employe->setId_employe($id_employe);

				if($_POST['optionsRadios'] === "options1"){
							$db_employe->setCnss(1)
												 ->setNum_rccm($_POST['num_register']);
									}elseif($_POST['optionsRadios'] === "options2"){
							$db_employe->setCnss(0);

									}
							$db_employe->setCode_membre_employeur($_POST['member_moral_salarial'])
												 ->setCode_membre_employe($_POST['member_salarial'])
												 ->setDate_declaration($date_declaration->toString('yyyy-MM-dd HH:mm:ss'))
												 ->setId_utilisateur(isset($_SESSION['utilisateur'])?'0':$_SESSION['utilisateur']['id_utilisateur'])
												 ->setMont_salaire($_POST['montant_salarial']);
						 $map_employe->save($db_employe);
							$this->_redirect("/bons/listdessalairedeclare");
						}
					 if(!empty($validationseconderrors)){
							$_SESSION['validationseconderrors'] = $validationseconderrors;
					 }
				}
		}
}

public function listingdessalariedeclareparraisonsocialAction(){


			$map_employe = new Application_Model_EuEmployeMapper();
			$db_employe = new Application_Model_EuEmploye();
			$map_membre = new Application_Model_EuMembreMapper();
			$db_membre = new Application_Model_EuMembre();


			$resultjson = array();

			if($_SERVER['REQUEST_METHOD'] != 'POST'){
					http_response_code(403);
					die('Vous n\'êtes pas autorisé a effectuer cette action');
			}
			if($_POST['code_membre_morale'] === ""){
				 http_response_code(403);
				 die('Le Code Membre Morale ne doit pas être vide');
			}

			if(!array_key_exists('code_membre_morale', $_POST)){
				 http_response_code(403);
				 die('Le Code Membre Morale n\'existe pas');
			}

			if(!filter_var($_POST['code_membre_morale'], FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>"#^[0-9]{19}(M)$#")))){
				 http_response_code(403);
				 die('Le Code Membre Morale n\'est pas correcte');
			}
			if($_POST['member_solde_compte'] <= 0){
					http_response_code(403);
				 die('Le solde de votre compte est nulle');
			}
		 $result = $map_employe->resultfindByCodeMembre($_POST['code_membre_morale']);
		 if(count($result) >= 1){
			 foreach ($result as $value) {
				 $membre = $value->code_membre_employe;

				 $code_membre_employe = $map_membre->resultfindByCodeMembre($membre,$db_membre);
				 $resultjson[] = array(
					'nom_membre'=>$code_membre_employe->nom_membre,
					'prenom_membre'=>$code_membre_employe->prenom_membre,
					'code_membre'=> $value->code_membre_employe,
					'montant_salaire'=> $value->mont_salaire
				 );
			 }
		 }else{
				 http_response_code(403);
				 die('Votre entreprise n\'a pas été declare pour l\'octroi de salaire aux employes');
		 }


			header('Content-type:application/json');
			die(json_encode($resultjson));
}


public function salaireaaffecterparlemploeuralemployeAction(){
			$mcompte = new Application_Model_EuCompteMapper();
			$compte = new Application_Model_EuCompte();

			$db_capa = new Application_Model_DbTable_EuCapa();

			$db_capa_select = $db_capa->select();
			$db_capa_select->from('eu_capa')
									->where('code_compte like ?', "NN-CAPA-0010010010020000003P")
									->where('type_capa like ?', 'RPG')
									->where('origine_capa like ?', 'SMS');
			$resultjson = array();
			if($_SERVER['REQUEST_METHOD'] != 'POST'){
					http_response_code(403);
					die('Vous n\'êtes pas autorisé a effectuer cette action');
			}
			if($_POST['code_membre_morale'] === ""){
				 http_response_code(403);
				 die(json_encode('Le Code Membre Morale ne doit pas être vide'));
			}

			if(!array_key_exists('code_membre_morale', $_POST)){
				 http_response_code(403);
				 die(json_encode('Le Code Membre Morale n\'existe pas'));
			}

			if($_POST['member_compte_type'] === ""){
				 http_response_code(403);
				 die(json_encode('Le Compte Source n\'est pas selectionné'));
			}

			if(!array_key_exists('member_compte_type', $_POST)){
				 http_response_code(403);
				 die(json_encode('Le Compte Source n\'existe pas'));
			}

			if(!filter_var($_POST['code_membre_morale'], FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>"#^[0-9]{19}(M)$#")))){
				 http_response_code(403);
				 die(json_encode('Le Code Membre Morale n\'est pas correcte'));
			}

			$compte_source = 'NN-CAPA-'. $_POST['code_membre_morale'];
			//Récupération du montant total du salaire perçu sur le compte tpn

			$db_capa_select = $db_capa->select();
			$db_capa_select->from('eu_salaire_affecter',array('montant_solde'))
										 ->where('code_compte like ?', $compte_source)
										 ->where('type_capa like ?', 'CNCS')
										 ->where('origine_capa like ?', 'NN');
			$mature_capa = $db_capa->fetchAll($db_capa_select);
			if(count($mature_capa) > 0){
					 $resultjson = array(
						 'salaire_percu'=>$mature_capa[0]['montant_solde']
					 );
			}else{
				 http_response_code(403);
				 die(json_encode('Le salaire pour cet membre est indisponible'));
			}

			header('Content-type:application/json');
		 die(json_encode($resultjson));
}

public function operationaffectationdessalairesachaqueemployeAction(){
	 $map_employe = new Application_Model_EuEmployeMapper();
	 $db_employe = new Application_Model_EuEmploye();
	 $map_membre = new Application_Model_EuMembreMapper();
	 $db_membre = new Application_Model_EuMembre();
	 $credit = new Application_Model_EuCompteCredit();
	 $compte = new Application_Model_EuCompte();
	 $cm_mapper = new Application_Model_EuCompteMapper();
	 $cc_mapper = new Application_Model_EuCompteCreditMapper();
	 $smc_mapper = new Application_Model_EuSmcMapper();
	 $sal_affecter = new Application_Model_EuSalaireAffecter();
	 $map_sal_affecter = new Application_Model_EuSalaireAffecterMapper();
	 $tsal = new Application_Model_DbTable_EuSalaireAffecter();
	 $t_employe = new Application_Model_DbTable_EuEmploye();
	 $mapper = new Application_Model_EuOperationMapper();
	 $alloc = new Application_Model_EuOperation();
	 $db_capa = new Application_Model_DbTable_EuCapa();
	 $capa = new Application_Model_EuCapa();
	 $map_capa = new Application_Model_EuCapaMapper();


	 $request = $this->getRequest();

	 if($request->isPost()){

					$categorie_compte = $_POST['member_compte_type'];

					$membre_morale_octroant = $_POST['code_membre_morale'];
					$salaire_dispo_employeur = $_POST['member_salarial_dispo'];
					$affectation_employe_salaire = $_POST['affectation_employe_salaire'];
					$compte_source = 'NN-CAPA-'. $membre_morale_octroant;


//Convertion des dates debut et fin soumis lors de l'allocation
					if($_SERVER['REQUEST_METHOD'] != 'POST'){
						 http_response_code(403);
						 $this->_redirect("/bons/operationaffectationdessalairesachaqueemploye");

						 die('Vous n\'êtes pas autorisé a effectuer cette action');
					}



					$diff_salaire_dispo_salaire_octroi = $salaire_dispo_employeur - $affectation_employe_salaire ;
					$sel_emp = $t_employe->select();
					$sel_emp->where('code_membre_employe like ?', $_POST["num_membre_employe"])
									->where('code_membre_employeur like ?', $_POST['code_membre_morale']);
					$emp_ret = $t_employe->fetchAll($sel_emp);
					$current_result_employe_montant_salaire = $emp_ret[0]['mont_salaire'];
					$date_alloc = Zend_Date::now();
					$dated = "";
					$datef = "";

					if($_POST['affectation_employe_date_deb'] === ""){
						http_response_code(403);
						die(json_encode('Attention :La date de debut d\'affectation de salaire des employés ne doit pas être vide'));
					}
					if($_POST['affectation_employe_date_fin'] === ""){
						http_response_code(403);
						die(json_encode('Attention :La date de fin d\'affectation de salaire des employés ne doit pas être vide'));
					}
					if(strpos($_POST['affectation_employe_date_deb'], "/") !== false){
							$date_pre_explode = explode("/", $_POST['affectation_employe_date_deb']);
							$dated = $date_pre_explode[2].'-'.$date_pre_explode[0].'-'.$date_pre_explode[1];
					}

					if(strpos($_POST['affectation_employe_date_fin'], "/") !== false){
						$date_pre_explode = explode("/", $_POST['affectation_employe_date_fin']);
						$datef = $date_pre_explode[2].'-'.$date_pre_explode[0].'-'.$date_pre_explode[1];
					}

					if(strpos($_POST['affectation_employe_date_deb'], "/") === false){
						$dated = $_POST['affectation_employe_date_deb'];
					}
					if(strpos($_POST['affectation_employe_date_fin'], "/") === false){
						$datef = $_POST['affectation_employe_date_fin'];
					}
					if(!array_key_exists('member_compte_type', $_POST)){
						http_response_code(403);
						die(json_encode('Attention:Le type de Compte n\'existe pas.impossible de faire de continuer l\'opération'));
					}

					if($membre_morale_octroant === ""){
						http_response_code(403);
						die(json_encode('Attention:Le Numero du membre morale ne doit pas être vide'));
					}

					if(!array_key_exists('code_membre_morale', $_POST)){
						http_response_code(403);
						die(json_encode('Attention:Le Numero du membre morale n\'existe pas.impossible de faire de continuer l\'opération'));
					}

					if(!filter_var($_POST['code_membre_morale'], FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"#^[0-9]{19}(M)$#")))){
							http_response_code(403);
							die(json_encode('Le Code Membre Morale n\'est pas correcte'));
					}

					if($salaire_dispo_employeur === ""){
						http_response_code(403);
						die(json_encode('Attention:Le Salaire disponible de l\'employeur ne doit pas être vide'));
					}

					if(!array_key_exists('member_salarial_dispo', $_POST)){
						http_response_code(403);
						die(json_encode('Attention:Le Salaire disponible de l\'employeur n\'existe pas.impossible de faire de continuer l\'opération'));
					}


					if($salaire_dispo_employeur < 0 ){
						http_response_code(403);
						die(json_encode('Attention :Le Salaire de l\'employeur est négatif'));
					}

					if($salaire_dispo_employeur === 0){
						http_response_code(403);
						die(json_encode('Attention :Le Salaire est nulle'));
					}

					if($affectation_employe_salaire > $current_result_employe_montant_salaire){
						http_response_code(403);
						die(json_encode(array('mont_salaire'=>$current_result_employe_montant_salaire)));
					}

					if(!filter_var($_POST['member_salarial_dispo'], FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"#[0-9]#")))){
							http_response_code(403);
							die(json_encode('Attention :Le Salaire disponible de votre entreprise est invalide'));
					}

					if(!filter_var($_POST['affectation_employe_salaire'], FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"#[0-9]#")))){
							http_response_code(403);
							die(json_encode('Attention :Le Salaire disponible de ce employé est invalide'));
					}
					if($affectation_employe_salaire > $current_result_employe_montant_salaire){
						 http_response_code(403);
						 die(json_encode('Attention : Le montant alloué est supérieur au montant déclaré pour l\'employé ' . $_POST["num_membre_employe"] . '!!!'));
					}
					if($affectation_employe_salaire === 0){
						http_response_code(403);
						die(json_encode('Attention :Le salaire de l\'employé est nulle'));
					}

					if($affectation_employe_salaire < 0){
						 http_response_code(403);
						 die(json_encode('Attention :Le salaire octoyé à l\'employé est negatif'));
					}

					if($diff_salaire_dispo_salaire_octroi > 0 && $affectation_employe_salaire > 0 && $affectation_employe_salaire <= $current_result_employe_montant_salaire){

								if(count($emp_ret) === 0){
										 http_response_code(403);
										 die(json_encode('Cet employé n\'est pas déclaré'));
								}
								if(count($emp_ret) > 0){
										$db_capa_select = $db_capa->select();
										$db_capa_select->from('eu_capa')
																	 ->where('code_compte like ?', $compte_source)
																	 ->where('type_capa like ?', 'CNCS')
																	 ->where('origin_capa like ?', 'NN');

									$mature_capa = $db_capa->fetchAll($db_capa_select);
									if(count($mature_capa) <= 0){
											http_response_code(403);
											die(json_encode('Pas de crédits salaires matures (Les crédits cncs doivent faire 30 jours avant affectation) !!!'));
									}


									$sal_select = $tsal->select();
									$sal_select->from('eu_salaire_affecter')
														 ->where('code_membre like ?', $_POST["num_membre_employe"])
														 ->where('code_membre_emp like ?', $membre_morale_octroant);
									$res = $tsal->fetchAll($sal_select);


											$diff = date_diff(date_create($dated),date_create($datef));
											if($diff->days !== 30){
																http_response_code(403);
																die(json_encode('la periode d\'affectation de ce salarié doit être de 30 jours'));
											}

											if($dated < $date_alloc->toString('yyyy-MM-dd')){
																http_response_code(403);
																die(json_encode('la date de debut d\'affectation de cet employé ne doit pas être antérieure à la date daujourd\'hui'));
											}
											if($datef < $date_alloc->toString('yyyy-MM-dd')){
																http_response_code(403);
																die(json_encode('la date de fin d\'affectation de cet employé ne doit pas être antérieure à la date daujourd\'hui'));
											}

									if (count($res) > 0) {
														foreach ($res as $key => $value) {
															$date_debut = strtotime($value['date_deb']);
															$date_fin = strtotime($value['date_fin']);
															$dated = strtotime($dated);
															$datef = strtotime($datef);
																if ($dated >= $date_debut && $dated <= $date_fin || $datef >= $date_debut && $datef <= $date_fin) {
																	 http_response_code(403);
																	 die(json_encode('Vous ne pouvez pas affecter du salaire plusieurs fois dans la même période'));
																}
														}
									}



									if($mature_capa !== null || count($mature_capa) > 0 && $diff->days === 30){
										if(strpos($_POST['affectation_employe_date_deb'], "/") !== false){
											 $date_pre_explode = explode("/", $_POST['affectation_employe_date_deb']);
											 $dated = $date_pre_explode[2].'-'.$date_pre_explode[0].'-'.$date_pre_explode[1];
										}

									 if(strpos($_POST['affectation_employe_date_fin'], "/") !== false){
											$date_pre_explode = explode("/", $_POST['affectation_employe_date_fin']);
											$datef = $date_pre_explode[2].'-'.$date_pre_explode[0].'-'.$date_pre_explode[1];
									 }

									 if(strpos($_POST['affectation_employe_date_deb'], "/") === false){
										 $dated = $_POST['affectation_employe_date_deb'];
									 }
									 if(strpos($_POST['affectation_employe_date_fin'], "/") === false){
										 $datef = $_POST['affectation_employe_date_fin'];
									 }

														$num_comptes = 'NN-CAPA-'. $_POST["num_membre_employe"];
														$result = $cm_mapper->find($num_comptes, $compte);
														if ($result === false) {
															 $compte->setCode_membre($_POST["num_membre_employe"])
																			->setCode_type_compte('NN')
																			->setSolde($affectation_employe_salaire)
																			->setDate_alloc($date_alloc->toString('yyyy-MM-dd'))
																			->setCode_compte($num_comptes)
																			->setLib_compte("CAPA")
																			->setDesactiver(0);
															 $cm_mapper->save($compte);
														} else {
															 $compte->setSolde($compte->getSolde() + $affectation_employe_salaire);
															 $cm_mapper->update($compte);
														}
														$compteur = $mapper->findConuter() + 1;
														$alloc->setId_operation($compteur)
																	->setDate_op($date_alloc->toString('yyyy-MM-dd'))
																	->setHeure_op($date_alloc->toString('hh:mm'))
																	->setMontant_op($affectation_employe_salaire)
																	->setCode_membre($_POST["num_membre_employe"])
																	->setCode_produit('CNCS')
																	->setLib_op('Affectation de salaire à l\'employé')
																	->setCode_cat("CAPA")
																	->setType_op('ase');
														$mapper->save($alloc);
														$maxcc = $cc_mapper->findConuter() + 1;

														$frais_salaire = $affectation_employe_salaire * 0.02;
														$credit->setId_credit($maxcc)
																	 ->setCode_membre($_POST["num_membre_employe"])
																	 ->setCode_produit('CNCS')
																	 ->setMontant_place($frais_salaire)
																	 ->setDatedeb($dated)
																	 ->setDatefin($datef)
																	 ->setDate_octroi($date_alloc->toString('yyyy-MM-dd HH:mm:ss'))
																	 ->setSource($_POST["num_membre_employe"] . $date_alloc->toString('yyyyMMddHHmmss'))
																	 ->setCode_compte($num_comptes)
																	 ->setMontant_credit($frais_salaire)
																	 ->setRenouveller('N')
																	 ->setId_operation($compteur)
																	 ->setCompte_source($compte_source)
																	 ->setKrr('N')
																	 ->setBnp(0)
																	 ->setCode_bnp(null)
																	 ->setDomicilier(0);
														$cc_mapper->save($credit);
														$id_afectation = $map_sal_affecter->findConuter() + 1;
														$saf = array(
															 'id_affectation'=>$id_afectation,
															 'date_affectation'=>$date_alloc->toString('yyyy-MM-dd HH:mm:ss'),
															 'mont_affecter'=>$affectation_employe_salaire,
															 'code_membre'=>$value->num_membre_employe,
															 'id_operation'=>$compteur,
															 'date_deb'=>$dated,
															 'date_fin'=>$dated,
															 'heure_affectation'=>$date_alloc->toString('HH:mm:ss'),
															 'code_membre_emp'=>$membre_morale_octroant,
															 'type_cncs'=>'CNCS');

														$tsal->insert($saf);
														$capa->setMontant_solde($capa->getMontant_solde() - $affectation_employe_salaire);
														$capa->setMontant_utiliser($capa->getMontant_utiliser() + $affectation_employe_salaire);
														$map_capa->update($capa);

								}
							}
					}

	}
			header('Content-type:application/json');
			die(json_encode(array("success"=>"OK")));
}


public function operationaffectationdessalairesachaqueemployepargroupAction(){
	 $map_employe = new Application_Model_EuEmployeMapper();
	 $db_employe = new Application_Model_EuEmploye();
	 $map_membre = new Application_Model_EuMembreMapper();
	 $db_membre = new Application_Model_EuMembre();
	 $credit = new Application_Model_EuCompteCredit();
	 $compte = new Application_Model_EuCompte();
	 $cm_mapper = new Application_Model_EuCompteMapper();
	 $cc_mapper = new Application_Model_EuCompteCreditMapper();
	 $smc_mapper = new Application_Model_EuSmcMapper();
	 $sal_affecter = new Application_Model_EuSalaireAffecter();
	 $map_sal_affecter = new Application_Model_EuSalaireAffecterMapper();
	 $tsal = new Application_Model_DbTable_EuSalaireAffecter();
	 $t_employe = new Application_Model_DbTable_EuEmploye();
	 $mapper = new Application_Model_EuOperationMapper();
	 $alloc = new Application_Model_EuOperation();
	 $db_capa = new Application_Model_DbTable_EuCapa();
	 $capa = new Application_Model_EuCapa();
	 $map_capa = new Application_Model_EuCapaMapper();


	 $request = $this->getRequest();

	 $listarticlesvendus = json_decode($_POST["listarticlesvendus"]);

	 $ni = array();
	 if($_SERVER['REQUEST_METHOD'] != 'POST'){
			http_response_code(403);
			$this->_redirect("/bons/operationaffectationdessalairesachaqueemployepargroup");
	 }
	 $cumulsalaire = 0;
	 $salaire_dispo_employeurext = 0;
	 foreach ($listarticlesvendus as $key => $value) {
					$cumulsalaire += $value->affectation_employe_salaire;
					$salaire_dispo_employeurext = $value->member_salarial_dispo;
	 }

		if($cumulsalaire > $salaire_dispo_employeurext){
				http_response_code(403);
				die(json_encode('Attention :La somme totale d\'allocation de salaire des employes est superieure au montant disponible dans votre compte'));
		}

	 foreach ($listarticlesvendus as $key => $value) {
					$categorie_compte = $value->member_compte_type;

					$membre_morale_octroant = $value->code_membre_morale;
					$salaire_dispo_employeur = $value->member_salarial_dispo;
					$affectation_employe_salaire = $value->affectation_employe_salaire;
					$compte_source = 'NN-CAPA-'. $membre_morale_octroant;

//Convertion des dates debut et fin soumis lors de l'allocation

					$diff_salaire_dispo_salaire_octroi = $salaire_dispo_employeur - $affectation_employe_salaire ;
					$sel_emp = $t_employe->select();
					$sel_emp->where('code_membre_employe like ?', $value->num_membre_employe)
									->where('code_membre_employeur like ?', $value->code_membre_morale);
					$emp_ret = $t_employe->fetchAll($sel_emp);
					$current_result_employe_montant_salaire = $emp_ret[0]['mont_salaire'];
					$date_alloc = Zend_Date::now();
					$dated = "";
					$datef = "";
					if($value->affectation_employe_date_deb === ""){
						http_response_code(403);
						die(json_encode('Attention :La date de debut d\'affectation de salaire des employés ne doit pas être vide'));
					}
					if($value->affectation_employe_date_fin === ""){
						http_response_code(403);
						die(json_encode('Attention :La date de fin d\'affectation de salaire des employés ne doit pas être vide'));
					}
					if(strpos($value->affectation_employe_date_deb, "/") !== false){
							$date_pre_explode = explode("/", $value->affectation_employe_date_deb);
							$dated = $date_pre_explode[2].'-'.$date_pre_explode[0].'-'.$date_pre_explode[1];
					}

					if(strpos($value->affectation_employe_date_fin, "/") !== false){
						$date_pre_explode = explode("/", $value->affectation_employe_date_fin);
						$datef = $date_pre_explode[2].'-'.$date_pre_explode[0].'-'.$date_pre_explode[1];
					}

					if(strpos($value->affectation_employe_date_deb, "/") === false){
						$dated = $value->affectation_employe_date_deb;
					}
					if(strpos($value->affectation_employe_date_fin, "/") === false){
						$datef = $value->affectation_employe_date_fin;
					}

					if($membre_morale_octroant === ""){
						http_response_code(403);
						die(json_encode('Attention:Le Numero du membre morale ne doit pas être vide'));
					}

					if(!filter_var($membre_morale_octroant, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"#^[0-9]{19}(M)$#")))){
							http_response_code(403);
							die(json_encode('Le Code Membre Morale n\'est pas correcte'));
					}

					if($salaire_dispo_employeur === ""){
						http_response_code(403);
						die(json_encode('Attention:Le Salaire disponible de l\'employeur ne doit pas être vide'));
					}


					if($salaire_dispo_employeur < 0 ){
						http_response_code(403);
						die(json_encode('Attention :Le solde disponible sur votre compte salaire est négatif'));
					}

					if($salaire_dispo_employeur === 0){
						http_response_code(403);
						die(json_encode('Attention :Le solde disponible sur votre compte salaire est nulle'));
					}

					if($affectation_employe_salaire > $current_result_employe_montant_salaire){
						http_response_code(403);
						die(json_encode('Attention :Le Salaire affecté a Mr '.$value->nom_membre_employe.' '.$value->prenom_membre_employe.' est superieure au salaire declaré.Impossible d\'effectuer l\'operation'));
					}

					if(!filter_var($value->member_salarial_dispo, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"#[0-9]#")))){
							http_response_code(403);
							die(json_encode('Attention :Le Salaire disponible de votre entreprise est invalide'));
					}

					if(!filter_var($value->affectation_employe_salaire, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"#[0-9]#")))){
							http_response_code(403);
							die(json_encode('Attention :Le Salaire disponible de ce employé est invalide'));
					}
					if($affectation_employe_salaire > $current_result_employe_montant_salaire){
						 http_response_code(403);
						 die(json_encode('Attention : Le montant alloué est supérieur au montant déclaré pour l\'employé ' . $value->num_membre_employe . '!!!'));
					}
					if($affectation_employe_salaire === 0){
						http_response_code(403);
						die(json_encode('Attention :Le salaire de l\'employé est nulle'));
					}

					if($affectation_employe_salaire < 0){
						 http_response_code(403);
						 die(json_encode('Attention :Le salaire octoyé à l\'employé est negatif'));
					}

					if($diff_salaire_dispo_salaire_octroi > 0 && $affectation_employe_salaire > 0 && $affectation_employe_salaire <= $current_result_employe_montant_salaire){

								if(count($emp_ret) === 0){
										 http_response_code(403);
										 die(json_encode('Cet employé n\'est pas déclaré'));
								}
								if(count($emp_ret) > 0){
									$db_capa_select = $db_capa->select();
									$db_capa_select->from('eu_capa')
																	 ->where('code_compte like ?', $compte_source)
																	 ->where('type_capa like ?', 'CNCS')
																	 ->where('origine_capa like ?', 'NN');

									$mature_capa = $db_capa->fetchAll($db_capa_select);
									if(count($mature_capa) <= 0){
											http_response_code(403);
											die(json_encode('Pas de crédits salaires matures (Les crédits cncs doivent faire 30 jours avant affectation) !!!'));
									}

									$sal_select = $tsal->select();
									$sal_select->from('eu_salaire_affecter')
														 ->where('code_membre like ?', $value->num_membre_employe)
														 ->where('code_membre_emp like ?', $membre_morale_octroant);
									$res = $tsal->fetchAll($sal_select);

									$diff = date_diff(date_create($dated),date_create($datef));


									if($dated < $date_alloc->toString('yyyy-MM-dd')){
														http_response_code(403);
														die(json_encode('la date de debut d\'affectation de salaire des employés ne doit pas être antérieure à la date daujourd\'hui'));
									}
									 if($datef < $date_alloc->toString('yyyy-MM-dd')){
														http_response_code(403);
														die(json_encode('la date de fin d\'affectation de salaire des employes ne doit pas être antérieure à la date daujourd\'hui'));
									 }

									if($dated > $datef){
														http_response_code(403);
														die(json_encode('la date de fin d\'affectation de salaire des employes ne doit pas etre anterieure a la date de debut d\'affectation de salaire'));
									}

									if($diff->days !== 30){
														http_response_code(403);
														die(json_encode('la periode d\'affectation de ce salarié doit être de 30 jours'));
									}

									if (count($res) > 0) {
														foreach ($res as $key => $v) {
															$date_debut = strtotime($v['date_deb']);
															$date_fin = strtotime($v['date_fin']);
															$dated = strtotime($dated);
															$datef = strtotime($datef);
																if ($dated >= $date_debut && $dated <= $date_fin || $datef >= $date_debut && $datef <= $date_fin) {
																	 http_response_code(403);
																	 die(json_encode('Vous ne pouvez pas affecter du salaire plusieurs fois dans la même période'));
																}
														}
									}



									if($mature_capa != null || count($res) === 0 && count($mature_capa) > 0 && $diff->days === 30){
										if(strpos($value->affectation_employe_date_deb, "/") !== false){
											 $date_pre_explode = explode("/", $value->affectation_employe_date_deb);
											 $dated = $date_pre_explode[2].'-'.$date_pre_explode[0].'-'.$date_pre_explode[1];
										}

									 if(strpos($value->affectation_employe_date_fin, "/") !== false){
											$date_pre_explode = explode("/", $value->affectation_employe_date_fin);
											$datef = $date_pre_explode[2].'-'.$date_pre_explode[0].'-'.$date_pre_explode[1];
									 }

									 if(strpos($value->affectation_employe_date_deb, "/") === false){
										 $dated = $value->affectation_employe_date_deb;
									 }
									 if(strpos($value->affectation_employe_date_fin, "/") === false){
										 $datef = $value->affectation_employe_date_fin;
									 }
										$num_comptes = 'NN-CAPA-'. $value->num_membre_employe;
										$result = $cm_mapper->find($num_comptes, $compte);
														if ($result === false) {
															 $compte->setCode_membre($value->num_membre_employe)
																			->setCode_type_compte('NN')
																			->setSolde($affectation_employe_salaire)
																			->setDate_alloc($date_alloc->toString('yyyy-MM-dd'))
																			->setCode_compte($num_comptes)
																			->setLib_compte("CAPA")
																			->setDesactiver(0);
															$cm_mapper->save($compte);
														} else {
															 $compte->setSolde($compte->getSolde() + $affectation_employe_salaire);
															 $cm_mapper->update($compte);
														}
														$compteur = $mapper->findConuter() + 1;
														$alloc->setId_operation($compteur)
																	->setDate_op($date_alloc->toString('yyyy-MM-dd'))
																	->setHeure_op($date_alloc->toString('hh:mm:ss'))
																	->setMontant_op($affectation_employe_salaire)
																	->setCode_membre($value->num_membre_employe)
																	->setCode_produit('CNCS')
																	->setLib_op('Affectation de salaire à l\'employé')
																	->setCode_cat("CAPA")
																	->setType_op('ase');
														$mapper->save($alloc);
														$maxcc = $cc_mapper->findConuter() + 1;
														$frais_salaire = $affectation_employe_salaire * 0.02;
														$credit->setId_credit($maxcc)
																	 ->setCode_membre($value->num_membre_employe)
																	 ->setCode_produit('CNCS')
																	 ->setMontant_place($frais_salaire)
																	 ->setDatedeb($dated)
																	 ->setDatefin($datef)
																	 ->setDate_octroi($date_alloc->toString('yyyy-MM-dd HH:mm:ss'))
																	 ->setSource($_POST["num_membre_employe"] . $date_alloc->toString('yyyyMMddHHmmss'))
																	 ->setCode_compte($num_comptes)
																	 ->setMontant_credit($frais_salaire)
																	 ->setRenouveller('N')
																	 ->setId_operation($compteur)
																	 ->setCompte_source($compte_source)
																	 ->setKrr('N')
																	 ->setBnp(0)
																	 ->setCode_bnp(null)
																	 ->setDomicilier(0);
														$cc_mapper->save($credit);
														$id_afectation = $map_sal_affecter->findConuter() + 1;
														$saf = array(
															 'id_affectation'=>$id_afectation,
															 'date_affectation'=>$date_alloc->toString('yyyy-MM-dd HH:mm:ss'),
															 'mont_affecter'=>$affectation_employe_salaire,
															 'code_membre'=>$value->num_membre_employe,
															 'id_operation'=>$compteur,
															 'date_deb'=>$dated,
															 'date_fin'=>$dated,
															 'heure_affectation'=>$date_alloc->toString('HH:mm:ss'),
															 'code_membre_emp'=>$membre_morale_octroant,
															 'type_cncs'=>'CNCS');

														$tsal->insert($saf);
														$capa->setMontant_solde($capa->getMontant_solde() - $affectation_employe_salaire);
														$capa->setMontant_utiliser($capa->getMontant_utiliser() + $affectation_employe_salaire);
														$map_capa->update($capa);
								 }
							}
					}
	 }
					header('Content-type:application/json');
					die(json_encode(array("success"=>"OK")));
}




public function editsalaireAction(){
	 $map_capa = new Application_Model_EuCapaMapper();
	 $capa = new Application_Model_EuCapa();
	 $db_capa = new Application_Model_DbTable_EuCapa();

			$db_capa_select = $db_capa->select();
			$db_capa_select->from('eu_capa',array('montant_solde'))
										 ->where('code_compte like ?', 'NN-CAPA-0010010010010000003M')
										 ->where('type_capa like ?', 'CNCS')
										 ->where('origine_capa like ?', 'NN');
			$mature_capa = $db_capa->fetchAll($db_capa_select);


}

public function interfacedaffectationdesalairesauxsalariersparlemployeurAction(){

}
public function listdessalairedeclareAction(){
			$sessionutilisateur = new Zend_Session_Namespace('utilisateur');
			$map_employe = new Application_Model_EuEmployeMapper();
			$db_employe = new Application_Model_EuEmploye();
			$map_membre_morale = new Application_Model_EuMembreMoraleMapper();
			$db_membre_morale = new Application_Model_EuMembreMorale();
			$map_membre = new Application_Model_EuMembreMapper();
			$db_membre = new Application_Model_EuMembre();
			$list_employe = $map_employe->fetchAll();
			$tab_declare = array();

			foreach ($list_employe as $value) {
				$search_member_morale = $map_membre_morale->resultfindByCodeMembreMorale($value->code_membre_employeur, $db_membre_morale);
				$search_member = $map_membre->resultfindByCodeMembre($value->code_membre_employe, $db_membre);
				$tab_declare[] = array(
					'id_employe'=>$value->id_employe,
					'raison_sociale'=>$search_member_morale->raison_sociale,
					'nom_membre'=>$search_member->nom_membre,
					'prenom_membre'=>$search_member->prenom_membre,
					'date_declaration'=>$value->date_declaration,
					'cnss'=>$value->cnss,
					'montant_salaire'=>$value->mont_salaire,
					'id_utilisateur'=>$value->id_utilisateur
				);
			}
			$this->view->entries = $tab_declare;

}

public function ajaxsearchraisonsocialAction(){
			$map_membre_morale = new Application_Model_EuMembreMoraleMapper();
			$db_membre_morale = new Application_Model_EuMembreMorale();
			$mcompte = new Application_Model_EuCompteMapper();
			$compte = new Application_Model_EuCompte();
			$db_capa = new Application_Model_DbTable_EuCapa();
			$capa = new Application_Model_EuCapa();
			$map_capa = new Application_Model_EuCapaMapper();
			$resultjson = array();
			if($_SERVER['REQUEST_METHOD'] != 'POST'){
					http_response_code(403);
					die('Vous n\'êtes pas autorisé a effectuer cette action');
			}

			if($_POST['code_membre_morale'] === ""){
				 http_response_code(403);
				 die(json_encode('Le Code Membre Morale ne doit pas être vide'));
			}

			if(!array_key_exists('code_membre_morale', $_POST)){
				 http_response_code(403);
				 die(json_encode('Le Code Membre Morale n\'existe pas'));
			}

			if(!filter_var($_POST['code_membre_morale'], FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>"#^[0-9]{19}(M)$#")))){
				 http_response_code(403);
				 die(json_encode('Le Code Membre Morale n\'est pas correcte'));
			}

			$result = $map_membre_morale->resultfindByCodeMembreMorale($_POST['code_membre_morale'], $db_membre_morale);
			$compte_source = 'NN-CAPA-'. $_POST['code_membre_morale'];
			//Récupération du montant total du salaire perçu sur le compte tpn

			$rest = $mcompte->findsolde($compte_source);
			$db_capa_select = $db_capa->select();
			$db_capa_select->from('eu_capa',array('montant_solde'))
										 ->where('code_compte like ?', $compte_source)
										 ->where('type_capa like ?', 'CNCS')
										 ->where('origine_capa like ?', 'NN');
			$mature_capa = $db_capa->fetchAll($db_capa_select);

			if($result === false){
				 http_response_code(403);
				 die(json_encode('Cet entreprise n\'a pas encore été déclaré'));
			}

			if(count($mature_capa) <= 0){
				 http_response_code(403);
				 die(json_encode('Le salaire est indisponible'));
			}
			if(count($result) > 0 && count($mature_capa) > 0){
				$resultjson = array(
				 'raison_sociale'=>$result->raison_sociale,
				 'count'=>count($result),
				 'salaire_percu'=>$mature_capa[0]['montant_solde']);
			}


			header('Content-type:application/json');
			die(json_encode($resultjson));
}

public function ajaxsearchnometprenomAction(){
			$map_membre = new Application_Model_EuMembreMapper();
			$db_membre = new Application_Model_EuMembre();

			$resultjson = array();

			if($_SERVER['REQUEST_METHOD'] != 'POST'){
					http_response_code(403);
					die('Vous n\'êtes pas autorisé a effectuer cette action');
			}

			if($_POST['code_membre'] === ""){
				 http_response_code(403);
				 die(json_encode('Le Code Membre ne doit pas être vide'));
			}



			if(!array_key_exists('code_membre', $_POST)){
				 http_response_code(403);
				 die(json_encode('Ce Code Membre n\'existe pas'));
			}

			if(!filter_var($_POST['code_membre'], FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>"#^[0-9]{19}(P)$#")))){
				 http_response_code(403);
				 die('Ce Code Membre n\'est pas correcte');
			}

			$result = $map_membre->resultfindByCodeMembre($_POST['code_membre'], $db_membre);
			$resultjson = array(
				 'nom_membre'=>$result->nom_membre,
				 'prenom_membre'=>$result->prenom_membre
			);
			header('Content-type:application/json');
			die(json_encode($resultjson));
}

public function socialAction(){
	$map_membre_morale = new Application_Model_EuMembreMoraleMapper();
	$db_membre_morale = new Application_Model_EuMembreMorale();
	$mcompte = new Application_Model_EuCompteMapper();
	$compte = new Application_Model_EuCompte();

	$resultjson = array();
	if($_SERVER['REQUEST_METHOD'] != 'POST'){
			http_response_code(403);
			die('Vous n\'êtes pas autorisé a effectuer cette action');
	}

	if($_POST['code_membre_morale'] === ""){
		 http_response_code(403);
		 die(json_encode('Le Code Membre Morale ne doit pas être vide'));
	}

	if(!array_key_exists('code_membre_morale', $_POST)){
		 http_response_code(403);
		 die(json_encode('Le Code Membre Morale n\'existe pas'));
	}

	if(!filter_var($_POST['code_membre_morale'], FILTER_VALIDATE_REGEXP,
		array("options"=>array("regexp"=>"#^[0-9]{19}(M)$#")))){
		 http_response_code(403);
		 die(json_encode('Le Code Membre Morale n\'est pas correcte'));
	}

	$result = $map_membre_morale->resultfindByCodeMembreMorale($_POST['code_membre_morale'], $db_membre_morale);

	if($result === false || count($result) <= 0){
		 http_response_code(403);
		 die(json_encode('Cet entreprise n\'a pas encore été déclaré'));
	}
	if(count($result) > 0){
		$resultjson = array(
		 'raison_sociale'=>$result->raison_sociale,
		 'count'=>count($result));
	}


	header('Content-type:application/json');
	die(json_encode($resultjson));
}











}
