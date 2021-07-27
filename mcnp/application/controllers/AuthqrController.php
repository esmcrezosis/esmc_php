<?php
include('Classes/phpqrcode/qrlib.php');
//include('Classes/phpqrcode/qrconfig.php');
//include('../../Classes/phpqrcode/qrlib.php');
class AuthqrController extends Zend_Controller_Action{

   public function indexAction()
   {
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');



        $data = array();


        $eumembre = new Application_Model_DbTable_EuMembre();
        $select = $eumembre->select()->where('code_membre = ?', 'cm');


        $rowseumembre = $eumembre->fetchRow($select);


        print_r($rowseumembre);
   }




   public function secureconfirmationAction()
   {
        $request = $this->getRequest();
        $message = ''+$request->getParam('message_confirmation');
        $id_confirmation = ''+$request->getParam('id_confirmation');
        $code_membre = ''+$request->getParam('code_membre');
        $nom_operateur = ''+$request->getParam('nom_operateur');
        $code_operateur = ''+$request->getParam('code_operateur');

        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        $server_key = 'AAAA_x6ibNE:APA91bGS9Th7L4cIRPommheolMcR_u1vSZCDROil5qbyBLivoG4CC7DmJW8v_DbXYTvon52U42ufsJsXCLpKMAOl6hnWHsN1yQOH-hdJZAz010rKdEmdlnuFAtDhbrIZufG_fG0vmdoV';

                #API access key from Google API's Console
        define( 'API_ACCESS_KEY', $server_key);

         $target = '/topics/'.$code_membre;


        $registrationIds = $target;
        #prep the bundle
        $msg = array
          (
		'body' 	=> ''+$message ,
                'title'	=> 'Demande de confirmation',
                'text'	=> 'Demande de confirmation',
             	'icon'	=> 'myicon',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
          );

          $dataconfirm = array
          (      // TYPE 2 - CONFIRMATION
                'type' => '2',
                'data_text' => ''+$message,
		'id_confirmation' 	=> ''+$id_confirmation,
                'nom_operateur'	=> ''+$nom_operateur,
                'code_operateur' => ''+$code_operateur,

          );



	$fields = array
			(
				'to'		=> $registrationIds,
                                'notification'	=> $msg,
                                'data'	=> $dataconfirm
			);


	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
                curl_close( $ch );

                #Echo Result Of FireBase Server
                echo $result;
                print_r( $result);

   }



   public function requestcamauthAction()
   {
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

   }

   public function secureauthAction()
   {
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
   }



        public function authqrapiAction() {

        $this->_helper->layout()->disableLayout();
                $request = $this->getRequest();

                $data = array();
        // $data["test0"] = "test0";
                if($request->isPost()) {
                //   if($request->isGet()) {
                $code_operateur = $request->getParam('code_operateur');
              //  $code_membre_client = $request->getParam('code_membre_client');
                // $code_produit = $request->getParam('code_produit');
                $dbQRRequeteTable = new Application_Model_DbTable_EuQrauth();
                $dbQRRequete = new Application_Model_EuQrauth();
                $authrow = new Application_Model_DbTable_EuQrauth();
                $select = $authrow->select()->where('code_membre=?', '0010010010010091699P');
                //   ->where('code_operateur = ?', "0010010010010091699P");

                // $data["resultat"] = $authrow->fetchAllByCouple('0010010010010091699P', '0010010010010091699P');
                $code_groupe = array('personne_physique');


                $select = $authrow->select();

                // $data["resultat"] = $authrow->fetchAll();

                $resulat = $authrow->find(1);
                if(count($resulat) >= 1)  {
                        for($i = 0; $i < count($resulat); $i++) {
                        $value = $resulat[$i];
                                /*   $libelle_pays = $value->libelle_pays;
                                $reponse = ucfirst(htmlentities(utf8_decode($libelle_pays)));
                                $reponsetraiter = str_replace("?","e",$reponse);*/
                        $data[$i] = array(
                                'id_requete' => $value->id_requete,
                                'code_membre_client' => $value->code_membre_client,
                                'code_operateur' => $value->code_operateur,
                                'code_secret_client' => $value->code_secret_client,
                                'daterequete' => $value->daterequete,
                                'status_requete' => $value->status_requete
                        );
                        }
                } else {
                        // $data = '';
                        $data = $resulat;
                }

                }

        header('Content-type:application/json');
        header('Access-Control-Allow-Origin: *');
        die(json_encode($data[0]));
                // print_r($data);
        }





        public function champpersoAction()
        {
                $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        }



        public function requestauthAction()
        {
                $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        }

        public function genererqrcodeAction()
        {

  //   $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
  $request = $this->getRequest();
  $code_membre = $request->getParam("code_membre");
  //set it to writable location, a place for temp generated PNG files
  $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../../public/qrcode_cache'.DIRECTORY_SEPARATOR;
  //html PNG location prefix
/*  $PNG_WEB_DIR = 'test/';
          //ofcourse we need rights to create temp dir
  if (!file_exists($PNG_TEMP_DIR))
  mkdir($PNG_TEMP_DIR);*/

  $filename = $PNG_TEMP_DIR.''.$code_membre.'.png';

  $codeContents = '12345';

  // generating
  // $text = QRcode::png($codeContents, false, '../qrcode.png');
  QRcode::png ($code_membre.',biometrie', $filename, QR_ECLEVEL_L, 300, 4, false);
  //  chmod($filename , 0777);

  echo "<center>Code membre : ".$code_membre."<br/><br/> <img src='/qrcode_cache/".$code_membre.".png'/></center>";

        }

}