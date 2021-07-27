<?php 

class EnvoiesmsController extends Zend_Controller_Action{


   public function init(){
      include ("Url.php");
   }

   public function addsmsAction(){
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        $map_sms = new Application_Model_EuSmsManuelMapper();
        $db_sms = new Application_Model_EuSmsManuel();
        $request = $this->getRequest();
        $validationerrors = array();
      if($request->isPost()){
    	  if(!filter_var($_POST["numero_portable"], FILTER_VALIDATE_REGEXP,
          array("options"=>array("regexp"=>"#^[0-9]([ ]?[0-9])*$#")))){
           $validationerrors['num_portable'] = "Votre numero de portable est invalide";
    	  }
          if(!empty($validationerrors)){
            $_SESSION['validationerrors'] = $validationerrors;
          }
    	    if(empty($validationerrors) && !empty($_POST["numero_portable"]) && !empty($_POST['contenu_message'])){
            {
    		   $compteur = Util_Utils::findConuter() + 1;
           $idsms = $map_sms->findConuter() + 1;
           $datenow = Zend_Date::now();
    	     Util_Utils::addtoSms($compteur, $_POST["numero_portable"], $_POST['contenu_message'], $_POST['dlr_mask'], $_POST['dlr_url']);
    	     $db_sms->setId_sms_manuel($idsms)
                  ->setId_utilisateur($_SESSION['utilisateur']['id_utilisateur'])
                  ->setNum_portable($_POST["numero_portable"])
                  ->setContenu_message($_POST['contenu_message'])
                  ->setDate_envoi($datenow->toString('yyyy-MM-dd HH:mm:ss'));
            $map_sms->save($db_sms);     
           $this->_redirect("/envoiesms/listdessmsrecunonvalide");
        }
      }  
     }
   }

   public function listdessmsrecunonvalideAction(){
        $map_sms = new Application_Model_EuSmsManuelMapper();
         $selectlistdessmsrecunonvalide = $map_sms->fetchAll();
         $this->view->entries = $selectlistdessmsrecunonvalide;
   }

   public function editsmsAction(){
        $validationerrors = array();
        $editview = array();
        $id = (int)$this->_request->getParam('id');
        $request = $this->getRequest();


        if($id > 0){
            $editsms = Util_Utils::findsms($id);
            foreach ($editsms as $key => $value) {
              $editview = array(
               'id'=>$value['sql_id'],
               'receiver'=>$value['receiver'],
               'msgdata'=>$value['msgdata']
              );
            }

            $this->view->findsms = $editview;
        }
            

        if($request->isPost()){
             $numportable = $_POST['numero_portable'];
             $contenu_message = $_POST['contenu_message'];
             $ids = $_POST['id'];
             $mysqli = new mysqli("localhost", "esmc", "esmc", "kannel");
             $mysqli->query("UPDATE send_sms SET receiver = $numportable,msgdata = $contenu_message WHERE sql_id = $ids");

        }
      }
   }