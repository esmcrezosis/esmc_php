<?php

/**
 * EuReleveBancaireController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class EuBanqueController extends Zend_Controller_Action {
	function preDispatch() {
		$session_banque = new Zend_Session_Namespace ( "banque" );
		if (! isset ( $session_banque ) && ! isset ( $session_banque->login_banque_user )) {
			$this->_redirect ( "/eu-banque/login" );
		}
	}
	function nocompteAction() {
		Zend_Session::destroy ( true );
		$this->_redirect ( '/eu-banque/login' );
	}
	
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		/* page administration/index - Tableau de bord Espace Administration */
		$session_banque = new Zend_Session_Namespace ( 'banque' );
		// $this->_helper->layout->disableLayout();
		$this->_helper->layout ()->setLayout ( 'layoutpublicesmc' );
		
		if (! isset ( $session_banque->login_banque_user )) {
			$this->_redirect ( '/eu-banque/login' );
		}
		
		$date = new Zend_Date ( Zend_Date::ISO_8601 );
		$t_det_releve = new Application_Model_DbTable_EuRelevebancairedetail ();
		$select = $t_det_releve->select ( Zend_Db_Table::SELECT_WITH_FROM_PART );
		$select->setIntegrityCheck ( false );
		$select->where ( 'relevebancairedetail_date = ?', $date->toString ( 'yyyy-MM-dd' ) );
		$select->join ( array (
				'r' => 'eu_relevebancaire' 
		), 'eu_relevebancairedetail.relevebancairedetail_relevebancaire = r.relevebancaire_id', 'r.relevebancaire_id' );
		$select->where ( 'r.relevebancaire_banque like ?', $session_banque->code_banque );
		$select->join ( array (
				'b' => 'eu_banque' 
		), 'r.relevebancaire_banque = b.code_banque', 'b.code_banque' );
		$this->view->entries = $t_det_releve->fetchAll ( $select );
		
		$this->view->tabletri = 1;
	}
	public function listrelevebancaireAction() {
		/* page administration/listrelevebancaire - Liste des relevebancaires */
		$session_banque = new Zend_Session_Namespace ( 'banque' );
		// $this->_helper->layout->disableLayout();
		$this->_helper->layout ()->setLayout ( 'layoutpublicesmc' );
		
		if (! isset ( $session_banque->login_banque_user )) {
			$this->_redirect ( '/eu-banque/login' );
		}
		
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
					$date = new Zend_Date ( Util_Utils::convertDate ( $pdate ), Zend_Date::ISO_8601 );
					$select->where ( 'relevebancairedetail_date = ?', $date->toString ( 'yyyy-MM-dd' ) );
					$select->where ( 'relevebancairedetail_libelle like ?', "%" . $nom . "%" );
					$select->where ( 'relevebancairedetail_montant = ?', $montant );
				} else if (! empty ( $pdate ) && ! empty ( $nom )) {
					$date = new Zend_Date ( Util_Utils::convertDate ( $pdate ), Zend_Date::ISO_8601 );
					$select->where ( 'relevebancairedetail_date = ?', $date->toString ( 'yyyy-MM-dd' ) );
					$select->where ( 'relevebancairedetail_libelle like ?', "%" . $nom . "%" );
				} else if (! empty ( $nom ) && ! empty ( $montant )) {
					$select->where ( 'relevebancairedetail_libelle like ?', "%" . $nom . "%" );
					$select->where ( 'relevebancairedetail_montant = ?', $montant );
				} else if (! empty ( $pdate ) && ! empty ( $montant )) {
					$date = new Zend_Date ( Util_Utils::convertDate ( $pdate ), Zend_Date::ISO_8601 );
					$select->where ( 'relevebancairedetail_date = ?', $date->toString ( 'yyyy-MM-dd' ) );
					$select->where ( 'relevebancairedetail_montant = ?', $montant );
				} else if (! empty ( $pdate )) {
					$date = new Zend_Date ( Util_Utils::convertDate ( $pdate ), Zend_Date::ISO_8601 );
					$select->where ( 'relevebancairedetail_date = ?', $date->toString ( 'yyyy-MM-dd' ) );
				} else if (! empty ( $nom )) {
					$select->where ( 'relevebancairedetail_libelle like ?', "%" . $nom . "%" );
				} else if (! empty ( $montant )) {
					$select->where ( 'relevebancairedetail_montant = ?', $montant );
				}
				$select->join ( array (
						'r' => 'eu_relevebancaire' 
				), 'eu_relevebancairedetail.relevebancairedetail_relevebancaire = r.relevebancaire_id', 'r.relevebancaire_id' );
				$select->where ( 'r.relevebancaire_banque like ?', $session_banque->code_banque );
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
		$session_banque = new Zend_Session_Namespace ( "banque" );
		if (! isset ( $session_banque->login_banque_user )) {
			$this->_redirect ( '/eu-banque/login' );
		}
		$this->_helper->layout ()->setLayout ( 'layoutpublicesmc' );
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
			$releves = $m_releve->fetchAllByDate ( $date->toString ( "yyyy-MM-dd" ) );
			$db->beginTransaction ();
			try {
				$date_depot = new Zend_Date ( Util_Utils::convertDate ( $date_releve ), Zend_Date::ISO_8601 );
				$date_v = new Zend_Date ( Util_Utils::convertDate ( $date_valeur ), Zend_Date::ISO_8601 );
				if (count ( $releves ) >= 1) {
					$releve = $releves [0];
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
					$detReleve->setRelevebancairedetail_date ( $date_depot->toString ( "yyyy-MM-dd" ) );
					$detReleve->setRelevebancairedetail_date_valeur ( $date_v->toString ( "yyyy-MM-dd" ) );
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
					$relbancaire->setRelevebancaire_banque ( $session_banque->code_banque );
					$relbancaire->setRelevebancaire_date ( $date->toString ( "yyyy-MM-dd" ) );
					$relbancaire->setRelevebancaire_utilisateur ( $session_banque->id_banque_user );
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
					$detReleve->setRelevebancairedetail_date ( $date_depot->toString ( "yyyy-MM-dd" ) );
					$detReleve->setRelevebancairedetail_date_valeur ( $date_v->toString ( "yyyy-MM-dd" ) );
					$detReleve->setRelevebancairedetail_libelle ( $libelle );
					$detReleve->setRelevebancairedetail_montant ( $montant );
					$detReleve->setRelevebancairedetail_numero ( $numero );
					$m_detReleve->save ( $detReleve );
				}
				$db->commit ();
				$this->view->message = "Ajout d'utilisateur effectué avec succès!";
				$this->_redirect ( "/eu-banque/addreleve" );
			} catch ( Exception $e ) {
				$db->rollBack ();
				$this->view->message = "Echec d'ajout de relevé bancaire; Erreur de :" . $e->getMessage ();
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
		$session_banque = new Zend_Session_Namespace ( "banque" );
		if (! isset ( $session_banque->login_banque_user )) {
			$this->_redirect ( '/eu-banque/login' );
		}
		$this->_helper->layout ()->setLayout ( 'layoutpublicesmc' );
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
					$user_banque->setCodeBanque ( $session_banque->code_banque );
					$user_banque->setLoginBanqueUser ( $login );
					$user_banque->setNomBanqueUser ( $nom );
					$user_banque->setPrenomBanqueUser ( $prenom );
					$user_banque->setPwdBanqueUser ( $pwd );
					$user_banque->setPwdChanged ( 0 );
					$user_banque->setRole ( $role );
					$user_banque->setDateCreated ( $date->toString ( "yyyy-MM-dd" ) );
					$user_banque->setIdUtilisateur ( $session_banque->id_banque_user );
					$m_user_banque->save ( $user_banque );
					$db->commit ();
					$this->view->message = "Ajout d'utilisateur effectué avec succès!";
					$this->_redirect ( "/eu-banque/addbanque" );
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
        /* page administration/listtraite2 - Liste des traites trait�es */
        $session_banque = new Zend_Session_Namespace ('banque');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        if (! isset ( $session_banque->login_banque_user )) {
		   $this->_redirect ('/eu-banque/login');
		}

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
	
	public function detailstraiteAction() {
        $session_banque = new Zend_Session_Namespace ('banque');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        if (! isset ( $session_banque->login_banque_user )) {
		   $this->_redirect ('/eu-banque/login');
		}

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
	
	public function loginAction() {
		$session_banque = new Zend_Session_Namespace ( 'banque' );
		// $this->_helper->layout->disableLayout();
		$this->_helper->layout ()->setLayout ( 'layoutpublicesmc' );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$ok = $request->getParam ( "ok" );
			$login = $request->getParam ( "login" );
			$password = $request->getParam ( "pwd" );
			
			if (isset ( $ok ) && $ok === "ok") {
				try {
					$m_banque_user = new Application_Model_EuBanqueUserMapper ();
					$banque_user = new Application_Model_EuBanqueUser ();
					$rows = $m_banque_user->findByLoginAndPassword ( $login, $password );
					
					$m_user = new Application_Model_EuUtilisateurMapper();
					$user = new Application_Model_EuUtilisateur();
					
					$rows = $m_banque_user->findByLoginAndPassword($login,$password);
					$rowsuser = $m_user->findLoginAndPwd($login,md5($password));
					
					if ($rows != null && count ( $rows ) == 1) {
						$row = $rows [0];
						$session_banque->id_banque_user = $row->getIdBanqueUser ();
						$session_banque->code_banque = $row->getCodeBanque ();
						$session_banque->nom_banque_user = $row->getNomBanqueUser ();
						$session_banque->prenom_banque_user = $row->getPrenomBanqueUser ();
						$session_banque->login_banque_user = $row->getLoginBanqueUser ();
						$session_banque->pwd_changed = $row->getPwdChanged ();
						
						$session_banque->errorlogin = "";
						$this->_redirect ( '/eu-banque' );
					} elseif($rowsuser != false && count($rowsuser) >= 1) {
					    $rowuser = $rowsuser [0];
						$session_banque->id_banque_user = $rowuser->getId_utilisateur();
						$session_banque->code_banque = "";
						$session_banque->nom_banque_user = $rowuser->getNom_utilisateur();
						$session_banque->prenom_banque_user = $rowuser->getPrenom_utilisateur();
						$session_banque->login_banque_user = $rowuser->getLogin();
						$session_banque->pwd_changed = $rowuser->getPwd();
						$session_banque->role = $rowuser->getCode_groupe();
						
						$session_banque->errorlogin = "";
						$this->_redirect ('/eu-banque');
                    }
					
					else {
						$session_banque->errorlogin = "Login ou Mot de Passe Erroné";
						return;
					}
				} catch ( Exception $e ) {
					$session_banque->errorlogin = "Erreur :" . $e->getMessage ();
					return;
				}
			} else {
				$session_banque->errorlogin = "Saisir Login et Mot de Passe";
				return;
			}
		}
	}
	public function passwordAction() {
		/* page administration/password - Modification de mot de passe */
		$session_banque = new Zend_Session_Namespace ( 'banque' );
		// $this->_helper->layout->disableLayout();
		$this->_helper->layout ()->setLayout ( 'layoutpublicesmc' );
		
		if (! isset ( $session_banque->login_banque_user )) {
			$this->_redirect ( '/eu-banque/login' );
		}
		$request = $this->getRequest ();
		$ok = $request->getParam ( "ok" );
		$ancien = $request->getParam ( "ancien" );
		$nouveau = $request->getParam ( "nouveau" );
		$confirmer = $request->getParam ( "confirmer" );
		if (isset ( $ok ) && $ok === "ok") {
			if (isset ( $ancien ) && $ancien != "" && isset ( $nouveau ) && $nouveau != "" && isset ( $confirmer ) && $confirmer == $nouveau) {
				
				$t_user = new Application_Model_DbTable_EuBanqueUser ();
				$select = $t_user->select ()->where ( 'login_banque_user = ?', $session_banque->login_banque_user );
				$select->where ( 'pwd_banque_user = ?', $ancien );
				if (($rows_user = $t_user->fetchRow ( $select )) == 1) {
					$user = new Application_Model_EuBanqueUser ();
					$mapper = new Application_Model_EuBanqueUserMapper ();
					$mapper->find ( $session_banque->id_banque_user, $user );
					
					$user->setPwdBanqueUser ( $nouveau );
					$user->setPwdChanged ( 1 );
					$mapper->update ( $user );
					$this->view->error = "Modification effectuée";
				}
			} else {
				$this->view->error = "Saisir tous les champs";
			}
			// $this->_redirect('/administration');
		}
	}



	

public function rechercheopibanqueAction()
    {
       $session_banque = new Zend_Session_Namespace ( 'banque' );
		// $this->_helper->layout->disableLayout();
		$this->_helper->layout ()->setLayout ( 'layoutpublicesmc' );
		
		if (! isset ( $session_banque->login_banque_user )) {
			$this->_redirect ( '/eu-banque/login' );
		}
		 
       
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
		$session_banque = new Zend_Session_Namespace ( "banque" );
		if (! isset ( $session_banque->login_banque_user )) {
			$this->_redirect ( '/eu-banque/login' );
		}
		$this->_helper->layout ()->setLayout ( 'layoutpublicesmc' );
		

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
			$releves = $m_releve->fetchAllByDateFlooz ( $date->toString ( "yyyy-MM-dd" ), $session_banque->code_banque);

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
                                                ->where('bon_neutre_detail_banque = ?',$session_banque->code_banque)
                                                ->where('bon_neutre_detail_numero = ?',$_POST['numero'])
                                                ->where('bon_neutre_detail_date_numero = ?',$_POST['date_releve'])
                                                ;
                        if ($rowseubon_neutre_detail = $eubon_neutre_detail->fetchRow($select)) {
                                $bon_neutre = new Application_Model_EuBonNeutre();
                                $bon_neutreM = new Application_Model_EuBonNeutreMapper();
                                $bon_neutreM->find($rowseubon_neutre_detail->bon_neutre_id, $bon_neutre);

                                $code_BAn = $bon_neutre->bon_neutre_code;

                            //$db->rollback();
                            //$session_banque->error = "Numéro de banque déjà utilisé ...";
                            //$this->_redirect('/eu-banque/addreleveban');
                            //return;
                        }else{

						/////////////////controle email
						if(!filter_var($request->getParam("bon_neutre_email"), FILTER_VALIDATE_EMAIL)){
                            $db->rollback();
                            $session_banque->error = "E-mail non valable ...";
                            $this->_redirect('/eu-banque/addreleveban');
                            return;
						}

                    //////////////////////////bon_neutre_code_ban
					if(isset($_POST['bon_neutre_code_ban']) && $_POST['bon_neutre_code_ban']!=""){
					$bon_neutre2_mapper = new Application_Model_EuBonNeutreMapper();
                    $bon_neutre2 = $bon_neutre2_mapper->fetchAllByCode($request->getParam("bon_neutre_code_ban"));
					if(count($bon_neutre2) > 0){
					}else{
						$db->rollback();
                            $session_banque->error = "Ancien Code BAn erroné ...";
                            $this->_redirect('/eu-banque/addreleveban');
                            return;
					}
					}


////////////////////////////////////////////////////////////

				//$date_depot = new Zend_Date ( Util_Utils::convertDate ( $date_releve ), Zend_Date::ISO_8601 );
				//$date_v = new Zend_Date ( Util_Utils::convertDate ( $date_valeur ), Zend_Date::ISO_8601 );
				
				//$date_releve = $date_releve->toString ( "yyyy-MM-dd" );
				//$date_valeur = $date_valeur->toString ( "yyyy-MM-dd" );
				if (count ( $releves ) >= 1) {
					$releve = $releves [0];
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
					$relbancaire->setRelevebancaire_banque ( $session_banque->code_banque );
					$relbancaire->setRelevebancaire_date ( $date->toString ( "yyyy-MM-dd" ) );
					$relbancaire->setRelevebancaire_utilisateur ( $session_banque->id_banque_user );
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
								$session_banque->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
								$this->_redirect('/eu-banque/addreleveban');
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
										$session_banque->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
										$this->_redirect('/eu-banque/addreleveban');
										return;
										}
									}else{
										$db->rollback();
										$session_banque->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
										$this->_redirect('/eu-banque/addreleveban');
										return;
									}

								} else if($request->getParam("bon_neutre_banque") == "ECOBANK"){
									$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
									$relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate6($request->getParam("bon_neutre_banque"), $request->getParam("bon_neutre_numero"), $request->getParam("bon_neutre_date_numero"));
									if(count($relevebancairedetail) > 0) {
										if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
										$db->rollback();
										$session_banque->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
										$this->_redirect('/eu-banque/addreleveban');
										return;
										}
									}else{
										$db->rollback();
										$session_banque->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
										$this->_redirect('/eu-banque/addreleveban');
										return;
									}

								} else if($request->getParam("bon_neutre_banque") == "ORABANK"){
							$libellebanques = array(strtolower($request->getParam("bon_neutre_nom")), strtolower($request->getParam("bon_neutre_prenom")), strtolower($request->getParam("bon_neutre_raison")));
								$relevebancairedetailM = new Application_Model_EuRelevebancairedetailMapper();
								$relevebancairedetail = $relevebancairedetailM->fetchAllByBanqueNumeroDate5($request->getParam("bon_neutre_banque"), $libellebanques, $request->getParam("bon_neutre_date_numero"));
									if(count($relevebancairedetail) > 0) {
										if($request->getParam("bon_neutre_montant") != $relevebancairedetail->relevebancairedetail_montant) {
										$db->rollback();
										$session_banque->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
										$this->_redirect('/eu-banque/addreleveban');
										return;
										}
									} else {
										$db->rollback();
										$session_banque->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
										$this->_redirect('/eu-banque/addreleveban');
										return;
									}

								}else{
										$db->rollback();
										$session_banque->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
										$this->_redirect('/eu-banque/addreleveban');
										return;
								}
							}
						} else {

									$db->rollback();
									$session_banque->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...";
									$this->_redirect('/eu-banque/addreleveban');
									return;
						}

						*/


$message_sms_bancaire = Util_Utils::verifSmsBancaire($session_banque->code_banque, $_POST['numero'], $_POST['date_releve'], $_POST['montant'], $request->getParam("bon_neutre_nom"), $request->getParam("bon_neutre_prenom"), $request->getParam("bon_neutre_raison"));

if(is_int($message_sms_bancaire) || $message_sms_bancaire > 0){
	$session_banque->error = "";

}else if($message_sms_bancaire == "Montant"){
	$session_banque->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...1";
	$this->_redirect('/eu-banque/addreleveban');

}else if($message_sms_bancaire == "banque"){
	$session_banque->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...1";
	$this->_redirect('/eu-banque/addreleveban');

}else{
	$session_banque->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...1";
	//$this->_redirect('/eu-banque/addreleveban');

	$message_releve_bancaire = Util_Utils::verifReleveBancaire($session_banque->code_banque, $_POST['numero'], $_POST['date_releve'], $_POST['montant'], $request->getParam("bon_neutre_nom"), $request->getParam("bon_neutre_prenom"), $request->getParam("bon_neutre_raison"));

	if(is_int($message_releve_bancaire) || $message_releve_bancaire > 0){
		$session_banque->error = "";

	}else if($message_releve_bancaire == "Montant"){
		$session_banque->error = "Montant saisi non conforme au montant du versement. Veuillez bien vérifier le montant du reçu de banque ou de la transaction ...";
		$this->_redirect('/eu-banque/addreleveban');

	}else if($message_releve_bancaire == "banque"){
		$session_banque->error = "La banque choisie n'est pas dans la liste des banques autorisées pour la souscription du Bon d'Achat neutre (BAn). Veuillez apporter votre reçu bancaire à la direction de l'ESMC. Merci ...";
		$this->_redirect('/eu-banque/addreleveban');

	}else{
		$session_banque->error = "Les renseignements concernant le versement sont erronés ou ne sont pas encore vérifiables. Veuillez bien vérifier ces informations ou revenez plus tard dans les 24 heures. Merci ...";
		$this->_redirect('/eu-banque/addreleveban');

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
		                            $session_banque->error = "Le Code Membre est erroné. Vérifiez bien le nombre de caractères du Code Membre. Merci...";
									$this->_redirect('/eu-banque/addreleveban');
									return;
}else{
if(substr($_POST['bon_neutre_code_membre'], -1, 1) == 'P'){
                                $membre = new Application_Model_EuMembre();
                                $membre_mapper = new Application_Model_EuMembreMapper();
                                $membre_mapper->find($_POST['bon_neutre_code_membre'], $membre);
                                if(count($membre) == 0){
									$db->rollback();
		                            $session_banque->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PP ...";
									$this->_redirect('/eu-banque/addreleveban');
									return;
								}
								if($_POST['bon_neutre_nom'] == "" || $_POST['bon_neutre_nom'] == NULL){
									$db->rollback();
		                            $session_banque->error = "Veuillez bien saisir le nom et prénom(s)";
									$this->_redirect('/eu-banque/addreleveban');
									return;
								}
	}
if(substr($_POST['bon_neutre_code_membre'], -1, 1) == 'M'){
                                $membremorale = new Application_Model_EuMembreMorale();
                                $membremorale_mapper = new Application_Model_EuMembreMoraleMapper();
                                $membremorale_mapper->find($_POST['bon_neutre_code_membre'], $membremorale);
                                if(count($membremorale) == 0){
									$db->rollback();
		                            $session_banque->error = "Le Code Membre est erroné. Veuillez bien saisir le Code Membre PM ...";
									$this->_redirect('/eu-banque/addreleveban');
									return;
								}
								if($_POST['bon_neutre_raison'] == "" || $_POST['bon_neutre_raison'] == NULL){
									$db->rollback();
		                            $session_banque->error = "Veuillez bien saisir la raison sociale";
									$this->_redirect('/eu-banque/addreleveban');
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
                            $bon_neutre_detail->setBon_neutre_detail_banque($session_banque->code_banque);
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
                            $bon_neutre_detail->setBon_neutre_detail_banque($session_banque->code_banque);
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
                            $bon_neutre_detail->setBon_neutre_detail_banque($session_banque->code_banque);
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

                            $session_banque->code_BAn = $code_BAn;
                            $session_banque->membre_code = $bon_neutre->bon_neutre_code_membre;

                            $session_banque->error = "Opération bien effectuée. <br />
Vous venez de souscrire au Bon d'Achat neutre (BAn). <br />
Utilisez ce BAn pour : <br />
- votre propre Activation Personne Physique et/ou Personne Morale <br />
- la souscription pour tiers (CMFH) de votre choix <br />
<br />
";
if($session_banque->membre_code != "" && $session_banque->membre_code != NULL){
   $session_banque->error .= "Le code du Bon d'Achat neutre (BAn) se trouve dans le compte marchand du membre <strong>".$session_banque->membre_code."</strong><br />";
   $session_banque->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
} else {
    $session_banque->error .= "Voici le code du Bon d'Achat neutre (BAn) : <strong>".$code_BAn."</strong><br />";
}
    $session_banque->error .= "<strong>Veuillez bien noter votre code BAn. Il est très important. </strong>Le cas échéant, en cas de perte, reprenez l'opération.";

                            $this->_redirect('/eu-banque/addreleveban');
                            return;

		            }  catch (Exception $exc) {
                        $session_banque->error = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                        $db->rollback();
                        $this->_redirect('/eu-banque/addreleveban');
                        return;
                    }


		    }   else {  $session_banque->error = "Champs * obligatoire ..."; }


		}


	}









}
