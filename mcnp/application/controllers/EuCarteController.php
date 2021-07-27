<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of EucarteController
 *
 * @author user
 */
 
 
class EuCarteController extends Zend_Controller_Action {

      //put your code here
      public function init() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		$group = $user->code_groupe;
        if ($user->code_groupe == 'cm') {
            $menu = '<li><a id="newcarte" href="/eu-carte/newp" style="font-size:11px">Demande KPS MPP</a></li>
			          <li><a id="newlicence" href="/eu-carte/newlicencep" style="font-size:11px">Vente licence MPP</a></li>
                      <li><a id="indexcarte" href="/eu-carte/index" style="font-size:11px">Listes des cartes</a></li>
					  <li><a id="indexlicence" href="/eu-carte/listelicence" style="font-size:11px">Liste des licences</a></li>';
        } else if($user->code_groupe == 'caps') {
		    $menu = '<li><a id="caps" href="/eu-bnp/caps" style=\"font-size:11px\">CAPS</a></li>
			         <li><a id="newcarte" href="/eu-carte/newp" style="font-size:11px">Demande KPS MPP</a></li>
			         <li><a id="newlicence" href="/eu-carte/newlicencep" style="font-size:11px">Vente de licence MPP </a></li>
                     <li><a id="indexcarte" href="/eu-carte/index" style="font-size:11px">Listes des kits</a></li>
					 <li><a id="indexlicence" href="/eu-carte/listelicence" style="font-size:11px">Liste des licences</a></li>
					 <li><a id="newcompte" href="/eu-carte/newcomptepp" style="font-size:11px">Creation compte </a></li>'; 
		}
		elseif ($user->code_groupe == 'fl') {
            $menu = '<li><a id="newlicence" href="/eu-carte/newlicense" style=\"font-size:11px\">Vente de licences</a></li>
                     <li><a id="indexcarte" href="/eu-carte/licence" style=\"font-size:11px\">Listes des Licences</a></li>';
        } elseif ($user->code_groupe == 'cps') {
            $menu = '<li><a id="newcarte" href="/eu-carte/new" style=\"font-size:11px\">Demande</a></li>
			         <li><a id="newlicence" href="/eu-carte/newlicense" style=\"font-size:11px\">Vente de licences</a></li>
                     <li><a id="newcarte" href="/eu-carte/listes" style=\"font-size:11px\">Vue des cartes vendues</a></li>';
        } elseif ($user->code_groupe == 'compta') {
            $menu = '<li><a id="newlicence" href="/eu-carte/newl" style=\"font-size:11px\">Ajout de licences</a></li>
                     <li><a id="newlicence" href="/eu-carte/newlicense" style=\"font-size:11px\">Vente de licences</a></li>
                     <li><a id="indexcarte" href="/eu-carte/licence" style=\"font-size:11px\">Listes des Licences</a></li>';
        } elseif ($user->code_groupe == 'compta') {
            $menu = '<li><a id="newlicence" href="/eu-carte/newl" style=\"font-size:11px\">Ajout de licences</a></li>
                    <li><a id="newlicence" href="/eu-carte/newlicense" style=\"font-size:11px\">Vente de licences</a></li>
                    <li><a id="indexcarte" href="/eu-carte/licence" style=\"font-size:11px\">Listes des Licences</a></li>';
        } elseif($user->code_groupe == 'filiere' or  $user->code_groupe == 'scmacnev'  or  $user->code_groupe == 'technopole' or  $user->code_groupe == 'productiong' or  $user->code_groupe == 'productionsg'  or  $user->code_groupe == 'productiond'
		    or $user->code_groupe == 'transformationg' or  $user->code_groupe == 'transformationsg' or  $user->code_groupe == 'transformationd' or  $user->code_groupe == 'distributiong' or  $user->code_groupe == 'distributionsg' or  $user->code_groupe == 'distributiond'
			or  $user->code_groupe == 'scmd'  or  $user->code_groupe == 'scmsg' or  $user->code_groupe == 'scmg' or  $user->code_groupe == 'scmgm' or  $user->code_groupe == 'scmsgm' or  $user->code_groupe == 'scmdm' or  $user->code_groupe == 'gacd' or  $user->code_groupe == 'gacs'
			or  $user->code_groupe == 'gacex' or  $user->code_groupe == 'scmdpbf' or  $user->code_groupe == 'scmsgpbf' or  $user->code_groupe == 'scmgpbf' or  $user->code_groupe == 'scmgkr' or  $user->code_groupe == 'scmsgkr' or  $user->code_groupe == 'scmdkr' or $group == 'scmdm' or  $group == 'scmsgm' or  $group == 'scmgm' or  $group == 'gacdm'  or  $group == 'gacsm' or  $group == 'gacexm'
			or  $group == 'gacdz'  or  $group == 'gacsz' or  $group == 'gacexz'
			or  $group == 'gacdp'  or  $group == 'gacsp' or  $group == 'gacexp'
			or  $group == 'scmdd' or  $group == 'scmsgd' or  $group == 'scmgd'
			or  $group == 'scmds' or  $group == 'scmsgs' or  $group == 'scmgs'
			or  $group == 'scmdex' or  $group == 'scmsgex' or  $group == 'scmgex'
			or  $group == 'gacdregion' or  $group == 'gacdsecteur' or  $group == 'gacdagence'
			or  $group == 'gacsregion' or  $group == 'gacssecteur' or  $group == 'gacsagence'
			or  $group == 'gacexregion' or  $group == 'gacexsecteur' or  $group == 'gacexagence'
			or  $group == 'scmpmaose' or  $group == 'scmpmapbf' or  $group == 'scmpmam' or  $group == 'scmpmaoe')  {
			
            $menu ='<li><a id="newcarte" href="/eu-carte/newm" style="font-size:11px">Demande KPS MPM</a></li>
				    <li><a id="newlicence" href="/eu-carte/newlicencem" style="font-size:11px">Vente de licence MPM </a></li>
                    <li><a id="indexcarte" href="/eu-carte/index" style="font-size:11px">Listes des cartes</a></li>
					<li><a id="indexlicence" href="/eu-carte/listelicence" style="font-size:11px">Liste des licences</a></li>
					<li><a id="newcompte" href="/eu-carte/newcompte" style="font-size:11px">Creation compte </a></li>';
        }
            $this->view->placeholder("menu")->set($menu);
            $this->view->jQuery()->enable();
            $this->view->jQuery()->uiEnable();
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'compta' && $group != 'cm' &&  $group != 'caps' && $group != 'fl' && $group != 'cps' and  $group != 'filiere' 
		       and  $group != 'scmacnev' and  $group != 'technopole' and  $group != 'productiong' and  $group != 'productionsg' and  $group != 'productiond'  and  $group != 'transformationg' and  $group != 'transformationsg' and  $group != 'transformationd' and  $group != 'distributiong'
		       and  $group != 'distributionsg' and  $group != 'distributiond' and  $group != 'scmd' and  $group != 'scmsg' and  $group != 'scmg'
		       and  $group != 'scmgm' and  $group != 'scmsgm' and  $group != 'gacd' and  $group != 'gacs' and  $group != 'gacex' 
			   and  $group != 'scmdpbf' and  $group != 'scmsgpbf' and  $group != 'scmgpbf' and  $group != 'scmgkr' and  $group != 'scmsgkr' and  $group != 'scmdkr'  and  $group != 'gacdm' and  $group != 'gacsm' and  $group != 'gacexm'
			 and  $group != 'gacdz' and  $group != 'gacsz' and  $group != 'gacexz'
			 and  $group != 'gacdp' and  $group != 'gacsp' and  $group != 'gacexp'
			 and  $group != 'scmdd' and  $group != 'scmsgd' and  $group != 'scmgd'
			   and  $group != 'scmds' and  $group != 'scmsgs' and  $group != 'scmgs'
			   and  $group != 'scmdex' and  $group != 'scmsgex' and  $group != 'scmgex' and $group != 'scmpmaoe'
			   and $group != 'scmpmaose' and  $group != 'scmpmapbf' and  $group != 'scmpmam'
			 and  $group != 'gacdregion' and  $group != 'gacdsecteur' and  $group != 'gacdagence'
			 and  $group != 'gacsregion' and  $group != 'gacssecteur' and  $group != 'gacsagence'
			 and  $group != 'gacexregion' and  $group != 'gacexsecteur' and  $group != 'gacexagence') {
                 $this->view->user = $user;
                 return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }
	
	
	public function listelicenceAction() {
        
    }


	public function datalicenceAction() {
	  $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
      $this->_helper->layout->disableLayout();
      $page = $this->_request->getParam("page", 1);
      $limit = $this->_request->getParam("rows", 10);
      $sidx = $this->_request->getParam("sidx", 'code_fl');
      $sord = $this->_request->getParam("sord", 'asc');
      $code_membre = $this->_request->getParam("membre");
      $datesys = Zend_Date::now();
      $date = $this->_request->getParam("date");
      $tabela = new Application_Model_DbTable_EuFl();
      $select = $tabela->select();
      if ($date != '' && $code_membre != '') {
	     $date1 = explode("/", $date);
         $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
		 $select->from('eu_fl');
            $select->where('id_utilisateur = ?', $user->id_utilisateur);
            $select->where('code_membre like ?', $code_membre);
            $select->where('date_fl = ?', $dated);  
     }
	 elseif ($code_membre != '') {
	        $select->from('eu_fl');
            $select->where('id_utilisateur = ?', $user->id_utilisateur);
	        $select->where('code_membre like ?', $code_membre);     
	 }
	 elseif($date != '') {
	        $date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
			
			$select->from('eu_fl');
            $select->where('id_utilisateur = ?', $user->id_utilisateur);
            $select->where('date_fl = ?',$dated);
	}
	else {
	     $select->from('eu_fl');
         $select->where('id_utilisateur = ?', $user->id_utilisateur);
	}
	 
    $licences = $tabela->fetchAll($select);
    $count = count($licences);

    if ($count > 0) {
            $total_pages = ceil($count / $limit);
    } else {
            $total_pages = 0;
    }

    if ($page > $total_pages) $page = $total_pages;

        $licences = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($licences as $row) {
		    $datefl = new Zend_Date($row->date_fl, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->code_fl;
            $responce['rows'][$i]['cell'] = array(
                $row->code_fl,
                $row->code_membre.' '.$row->code_membre_morale,
                $datefl->toString('dd/MM/yyyy'),
                $row->mont_fl
            );
            $i++;
        }
        $this->view->data = $responce;
	}
	
	
	
    public function dataAction() {
	
      $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
      $this->_helper->layout->disableLayout();
      $page = $this->_request->getParam("page", 1);
      $limit = $this->_request->getParam("rows", 10);
      $sidx = $this->_request->getParam("sidx", 'id_demande');
      $sord = $this->_request->getParam("sord", 'asc');
      $code_membre = $this->_request->getParam("membre");
      $code_cat = $this->_request->getParam("compte");
      $datesys = Zend_Date::now();
      $date = $this->_request->getParam("date");
	  
        $tabela = new Application_Model_DbTable_EuCartes();
        $select = $tabela->select();
        if ($date != '' && $code_membre != '') {
	        $date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $select->from('eu_cartes');
            $select->where('id_utilisateur = ?', $user->id_utilisateur);
            $select->where('code_membre like ?', $code_membre);
            //$select->where('code_cat like ?', $code_cat);
            $select->where('date_demande = ?', $dated);
		    $select->where('livrer = ?', 0);
        }
	    elseif($date != '') {
	        $date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
	        $select->from('eu_cartes');
            $select->where('id_utilisateur = ?', $user->id_utilisateur);
			$select->where('date_demande = ?', $dated);
			$select->where('livrer = ?', 0);
	    }
	    //elseif($code_cat != '') {
	        //$select->from('eu_cartes');
            //$select->where('id_utilisateur = ?', $user->id_utilisateur);
			//$select->where('code_cat like ?', $code_cat);
			//$select->where('livrer = ?', 0);
	    //}  
		elseif($code_membre != '') {
	        $select->from('eu_cartes');
            $select->where('id_utilisateur = ?', $user->id_utilisateur);
			$select->where('code_membre like ?', $code_membre);
			$select->where('livrer = ?', 0);
	    } 
		else {
	        $select->from('eu_cartes');
            $select->where('id_utilisateur = ?', $user->id_utilisateur);
		    $select->where('livrer = ?', 0);
		    $select->order('date_demande asc');
	    }
	 
    $cartes = $tabela->fetchAll($select);
    $count = count($cartes);

    if ($count > 0) {
        $total_pages = ceil($count / $limit);
    } else {
        $total_pages = 0;
    }

    if ($page > $total_pages)
        $page = $total_pages;
        $cartes = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cartes as $row) {
		    $datedemande = new Zend_Date($row->date_demande, Zend_Date::ISO_8601);
            $responce['rows'][$i]['id'] = $row->id_demande;
            $responce['rows'][$i]['cell'] = array(
               $row->id_demande,
               $datedemande->toString('dd/MM/yyyy'),
               $row->code_membre,
                //$row->code_cat,
                //$row->code_compte,
               $row->mont_carte,
               $row->livrer,
               $row->date_livraison
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function listesAction() {
        
    }


    public function listeAction() {
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_demande');
        $sord = $this->_request->getParam("sord", 'asc');
        $id_utilisateur = $this->_request->getParam("id_user");
        $code_agence = $this->_request->getParam("agence");
        $date = $this->_request->getParam("date");
        $tabela = new Application_Model_DbTable_EuCartes();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false);
        $select->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_cartes.id_utilisateur', array('nom_utilisateur', 'prenom_utilisateur'));
        $select->join('eu_agence', 'eu_utilisateur.code_agence = eu_agence.code_agence', array('libelle_agence'));
        if ($date == '' && $code_agence == '' && $id_utilisateur == '') {
            $cartes = $tabela->fetchAll($select);
        } else {
            if ($id_utilisateur != '') {
                $select->where('eu_cartes.id_utilisateur like ?', $id_utilisateur);
            }
            if ($code_agence != '') {
                $select->where('eu_utilisateur.code_agence like ?', $code_agence);
            }
            if ($date != '') {
                $date1 = explode("/", $date);
                $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $select->where('date_demande = ?', $dated);
            } else {
                $date = Zend_Date::now();
                $select->where('date_demande = ?', $date->toString('yyyy-mm-dd'));
            }
            $cartes = $tabela->fetchAll($select);
        }
        $count = count($cartes);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
           $page = $total_pages;

        $cartes = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($cartes as $row) {
            $utilisateur = $row->nom_utilisateur . ' ' . $row->prenom_utilisateur;
            $responce['rows'][$i]['id'] = $row->id_demande;
            $responce['rows'][$i]['cell'] = array(
                $row->id_demande,
                $row->libelle_agence,
                $utilisateur,
                $row->date_demande,
                $row->code_membre,
                $row->code_cat,
                $row->mont_carte
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function agencesAction() {
        $tagences = new Application_Model_EuAgenceMapper();
        $agences = $tagences->fetchAll();
        $data = array();
        if (count($agences) >= 1) {
            foreach ($agences as $value) {
                $data[0][] = $value->getCode_agence();
                $data[1][] = $value->getLibelle_agence();
            }
            $this->view->data = $data;
        } else {
            $this->view->data = false;
        }
    }

    public function usersAction() {
        $code_agence = $_GET["agence"];
        if ($code_agence != '') {
            $t_user = new Application_Model_DbTable_EuUtilisateur();
            $select = $t_user->select();
            $select->where('code_agence like ?', $code_agence)
                    ->where('code_groupe in (?)', array('cm', 'cps'));
            $results = $t_user->fetchAll($select);
            $data = array();
            if (count($results) > 0) {
                foreach ($results as $value) {
                    $data[0][] = $value->id_utilisateur;
                    $data[1][] = $value->nom_utilisateur . ' ' . $value->prenom_utilisateur;
                }
                $this->view->data = $data;
            } else {
                $this->view->data = false;
            }
        }
    }

    public function licenceAction() {
        
    }


    public function typemfAction() {
        $t_mf = new Application_Model_DbTable_EuTypeMf();
        $results = $t_mf->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->code_type_mf;
                $data[$i][1] = $value->code_type_mf;
            }
        }
        $this->view->data = $data;
    }
	 
	 
	 

    public function licensesAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'id_operation');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuOperation();
        $date_deb = Zend_Date::now();
        $select = $tabela->select();
        $select->where('id_utilisateur like ?', $user->id_utilisateur)
                ->where('type_op = ?', 'fl')
                ->order('date_op', 'asc');
        $achats = $tabela->fetchAll($select);
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $achats = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($achats as $row) {
            $date_op = new Zend_Date($row->date_op);
            $responce['rows'][$i]['id'] = $row->id_operation;
            $responce['rows'][$i]['cell'] = array(
                $row->id_operation,
                $date_op->toString('dd/MM/yyyy'),
                $row->code_membre,
                $row->lib_op,
                $row->montant_op,
                $row->type_op
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function flAction() {
	    $val_fl = Util_Utils::getParametre('FL', 'valeur');
	    $valfl = explode(".",$val_fl);
        $val_fl = $valfl[0];
        $this->view->data = $val_fl;
    }
	
	public function fcpsAction() {
	    $val_fkps = Util_Utils::getParametre('FKPS', 'valeur');
	    $valfkps = explode(".",$val_fkps);
        $val_fkps = $valfkps[0];
        $this->view->data = $val_fkps;
    }
	
	

    public function newlicenceAction() {
        
    }

    

	public function newlicencepAction() {
	
	}
	
	public function newlicencemfAction() {
	
	}
	
	public function newlicencemAction() {
	
	}
	
	public function newcompteAction() {
	
	}
	
	public function newcompteppAction() {
	
	}
	
	
	public function donewlicencemfAction() {
	
	       $request = $this->getRequest();
           $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		   if ($request->isPost()) {
		   
		       $code_membre = $request->code_membre;
			   $prix = $request->prix;
			   $mode_fin  =  $request->mode_fin;
			   $type_mf   =   $request->compte_nn;
               $apporteur = $request->code_membre_app;
			   
			   $ancienmembre = new Application_Model_EuAncienMembre();
			   $ancienmembre_map = new Application_Model_EuAncienMembreMapper();
			   $anciencompte_nn = new Application_Model_EuAncienCompte();
			   $anciencm_map = new Application_Model_EuAncienCompteMapper();
			   
			   $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			   try {
			        $tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
                    $code_fl = 'FL-' . $code_membre;
                    $result = $tfl->find($code_fl);
                    if (count($result) > 0) {
                       $this->view->data = "Vous avez deja souscrit au frais de licence!!! ";
                       $db->rollBack();
                       return;
                    }
                    $cm_map = new Application_Model_EuCompteMapper();
                    $mont_fl = Util_Utils::getParametre('FL', 'valeur');
                    if ($mont_fl != null && $mont_fl != $prix) {
                       $this->view->data = "La valeur du fl doit etre egale e " . $mont_fl;
                       return;
                    } 
					if ($mode_fin == 'bon') {
					    $num_bon = $_POST['num_bon'];
						$montant = $mont_fl;
						$code_compte = 'NN-TR-'.$num_bon;
                        $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
						if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
							 // Mise à jour de la table eu_repartition_mf11000		 
                             $t_repartition = new Application_Model_DbTable_EuRepartitionMf11000();
                             $select = $t_repartition->select();
                             $select->from($t_repartition,array('sum(solde_rep) as somme'));
                             $select->where('code_mf11000 = ?',$num_bon);
                             $result = $t_repartition->fetchAll($select);
                             $row = $result->current();
							 if ($row['somme'] < $montant) {
                                 $this->view->data = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cette operation";
                                 return;
                             }
							 $repmf11000  =  new Application_Model_EuRepartitionMf11000(); 
							 $m_repmf11000 = new Application_Model_EuRepartitionMf11000Mapper();
				             $mfcredits = $m_repmf11000->fetchRepByNumBon($num_bon);
							 $mapper = new Application_Model_EuOperationMapper();
                             $count = $mapper->findConuter() + 1;
                             $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                             $date_deb = clone $date_fin;
							 $mf = new Application_Model_EuMembreFondateur11000();
                             $mfm = new Application_Model_EuMembreFondateur11000Mapper();
							 
							 //Récupération des informations du membre fondateur 11000
                             $find_mf = $mfm->find($num_bon,$mf);
							 if($mf->getNb_repartition() == 32) {
							    $db->rollback();
                                $this->view->data = "Ce compte est destiné à faire du caps";
                                return;
							 } 
							 if ($mfcredits != null) {
					            $j = 0;
                                $reste = $montant;
                                $nbre_credit = count($mfcredits);
					            while ($reste > 0 && $j < $nbre_credit) {
					                  $mfcredit = $mfcredits[$j];
                                      $id = $mfcredit->getId_rep();
									  $findrep = $m_rep->find($id,$rep);
						              if ($reste >= $mfcredit->getSolde_rep()) {
						                    //Mise à jour du compte crédit mf11000
                                            $reste = $reste - $mfcredit->getSolde_rep();
                                            $mfcredit->setSolde_rep(0);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
											$mfcredit->setPayer(1);
                                            $m_repmf11000->update($mfcredit);			 							   
						               } else {
							                //Mise à jour du compte crédit mf11000
                                            $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                            $m_repmf11000->update($mfcredit);
						                    $reste = 0;
						                }
							            $j++;
						                }
				                   }
								   
					               //Mise à jour du compte principal
					               $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                   $anciencm_map->update($anciencompte_nn);
									
						} else {
						       $db->rollback();
                               $this->view->data ="Votre compte ".$type_mf." est inexistante ou insuffisant";
                               return;
						}
					
					
					} else {
					       if($type_mf == 'MF11000') {
						      $montant = $mont_fl;
						      $code_compte = " ";
						      $code_compte = 'NN-TR-'.$apporteur;
						      $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
						      if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
						         //Mise à jour du compte principal
					             $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                 $anciencm_map->update($anciencompte_nn);
						
				              } else {
						          $db->rollback();
                                  $this->view->data ="Votre compte ".$type_mf." est inexistante ou insuffisant";
                                  return;
						      }
						   
						   
						   } else {
						           $rep = new Application_Model_EuRepartitionMf107();
				                   $m_rep = new Application_Model_EuRepartitionMf107Mapper();
						           $dmf = new Application_Model_EuDetailMf11000();
							       $mdmf = new Application_Model_EuDetailMf107Mapper();
							       $mf107 = new Application_Model_EuMembreFondateur107();
							       $mmf107 = new Application_Model_EuMembreFondateur107Mapper();
							       $montant = $mont_fl;
							       $nb_dmf = 0;
								   
								   $code_compte = 'NN-TR-'.$apporteur;
                                   $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn); 
						           if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
							        $mfcredits = $m_rep->fetchRepByMembre($apporteur);
								    //enregistrement de l'operation
                                    $place = new Application_Model_EuOperation();
					
					                if ($mfcredits != null) {
					                $j = 0;
                                    $reste = $montant;
                                    $nbre_credit = count($mfcredits);
					                while ($reste > 0 && $j < $nbre_credit) {
					                    $mfcredit = $mfcredits[$j];
                                        $id = $mfcredit->getId_rep();
										$findrep = $m_rep->find($id,$rep);
						                if ($reste >= $mfcredit->getSolde_rep()) {
						                    //Mise à jour du compte crédit mf107
                                            $reste = $reste - $mfcredit->getSolde_rep();
                                            $mfcredit->setSolde_rep(0);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
											$mfcredit->setPayer(1);
                                            $m_rep->update($mfcredit);			 							   
						                } else {
							                //Mise à jour du compte crédit mf107
                                            $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                            $m_rep->update($mfcredit);
						                    $reste = 0;
						                }
							            $j++;
						                }
						 
				                    } 
					                //Mise à jour du compte principal
								    $ret_req = $anciencm_map->find($code_compte,$anciencompte_nn);           
                                    $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                    $anciencm_map->update($anciencompte_nn);
							  
							    } else {
							        $this->view->data = "Votre compte ".$type_mf." est inexistante ou insuffisant !!!";
                                    $db->rollback();
                                    return;
							    }
								   
						   }
					}
					$mapper = new Application_Model_EuOperationMapper();
                    $compteur = $mapper->findConuter() + 1;
                    $date_deb = new Zend_Date(Zend_Date::ISO_8601);
                    Util_Utils::addOperation($compteur,$code_membre,null, null, $prix, null,'Frais de licences','fl',$date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);
					
				   $fl->setCode_fl($code_fl)
                      ->setCode_membre($code_membre)
					  ->setCode_membre_morale(null)
                      ->setMont_fl($prix)
                      ->setDate_fl($date_deb->toString('yyyy-mm-dd'))
                      ->setHeure_fl($date_deb->toString('hh:mm:ss'))
                      ->setId_utilisateur($user->id_utilisateur)
                      ->setCreditcode($type_mf.'-'.$apporteur);
                    $tfl->insert($fl->toArray());
					
					 $compte = new Application_Model_EuCompte();
                     $map_compte = new Application_Model_EuCompteMapper();
					 $tcartes = array();
			         $tscartes = array();
					
					 $tcartes[0]="TPAGCRPG";
					 $tcartes[1]="TCNCS";
					 $tcartes[2]="TPaNu";
					 $tcartes[3]="TPaR";
					 $tcartes[4]="TR";
					 $tcartes[5]="CAPA";
									
					 $tscartes[0]="TSRPG";
					 $tscartes[1]="TSCNCS";
					 $tscartes[2]="TSPaNu";
					 $tscartes[3]="TSPaR";
				     $tscartes[4]="TSCAPA";
					 
					 for($i = 0; $i < count($tcartes); $i++) {
					    
						 if($tcartes[$i] == "TCNCS") {
                            $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
							$type_carte = 'NR';
							$res = $map_compte->find($code_compte,$compte);
						 } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA") {
                            $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
							$type_carte = 'NN';
							$res = $map_compte->find($code_compte,$compte);
						 } else {
							$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
						    $type_carte = 'NB';
							$res = $map_compte->find($code_compte,$compte);
						 }
										
						 if(!$res) {
                            $compte->setCode_cat($tcartes[$i])
                                   ->setCode_compte($code_compte)
                                   ->setCode_membre($code_membre)
								   ->setCode_membre_morale(null)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tcartes[$i])
                                   ->setSolde(0);
							$map_compte->save($compte);
									
						}
									
                    }
					
					for($j = 0; $j < count($tscartes); $j++) {
					    if($tscartes[$j] == "TSCNCS") {
                           $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
					       $type_carte = 'NR';
						   $res = $map_compte->find($code_comptets,$compte);
					    } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA") {
                           $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
					       $type_carte = 'NN';
						   $res = $map_compte->find($code_comptets,$compte);
					    } else {
						   $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
						   $type_carte = 'NB';
						   $res = $map_compte->find($code_comptets,$compte);
					    }
										
					if(!$res)   {
                        $compte->setCode_cat($tscartes[$j])
                               ->setCode_compte($code_comptets)
                               ->setCode_membre($code_membre)
							   ->setCode_membre_morale(null)
                               ->setCode_type_compte($type_carte)
                               ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                               ->setDesactiver(0)
                               ->setLib_compte($tscartes[$j])
                               ->setSolde(0);
						$map_compte->save($compte);
									
					}
									
                }
					 
					 
					 
						
                    //Mise e jour du compte general fgfn
                    $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                    $cg_fgfn = new Application_Model_EuCompteGeneral();
                    $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $prix);
                            $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($prix);
                            $cg_mapper->save($cg_fgfn);
                       }
					   $db->commit();
                       $this->view->data = true;
                       return;		
	            } catch (Exception $exc) {
                  $db->rollback();
                  $this->view->message = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                  return;
                }
	       
	       }
		   
	}

	public function donewcompteppAction() {
	    $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		if ($request->isPost()) {
		    $compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
		    $tcartes = array();
			$tscartes = array();
			
            $code_membre = $request->code_membre;
			$db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try {
		        $tcartes[0]="TPAGCRPG";
				$tcartes[1]="TCNCS";
				$tcartes[2]="TPaNu";
			    $tcartes[3]="TPaR";
				$tcartes[4]="TR";
				$tcartes[5]="CAPA";
				$tcartes[6]="TRE";
									
				$tscartes[0]="TSRPG";
				$tscartes[1]="TSCNCS";
				$tscartes[2]="TSPaNu";
				$tscartes[3]="TSPaR";
				$tscartes[4]="TSCAPA";
				$tscartes[5]="TSRE";
				
				
				$date_deb = new Zend_Date(Zend_Date::ISO_8601);
				for($i = 0; $i < count($tcartes); $i++) {
					if($tcartes[$i] == "TCNCS") {
                        $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
						$type_carte = 'NR';
						$res = $map_compte->find($code_compte,$compte);
					} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                        $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
						$type_carte = 'NN';
						$res = $map_compte->find($code_compte,$compte);
					} else {
						$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
						$type_carte = 'NB';
						$res = $map_compte->find($code_compte,$compte);
					}
						if(!$res) {
							// insertion dans la table eu_compte
                            $compte->setCode_cat($tcartes[$i])
                                   ->setCode_compte($code_compte)
                                   ->setCode_membre($code_membre)
								   ->setCode_membre_morale(null)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tcartes[$i])
                                   ->setSolde(0);
							$map_compte->save($compte);
						}
                }
									
				for($j = 0; $j < count($tscartes); $j++) {
					if($tscartes[$j] == "TSCNCS") {
                        $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
						$type_carte = 'NR';
						$res = $map_compte->find($code_comptets,$compte);
					} elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                        $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
						$type_carte = 'NN';
						$res = $map_compte->find($code_comptets,$compte);
					} else  {
						$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
						$type_carte = 'NB';
						$res = $map_compte->find($code_comptets,$compte);
					}				
						if(!$res) {
							// insertion dans la table eu_compte
                            $compte->setCode_cat($tscartes[$j])
                                   ->setCode_compte($code_comptets)
                                   ->setCode_membre($code_membre)
								   ->setCode_membre_morale(null)
                                   ->setCode_type_compte($type_carte)
                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                   ->setDesactiver(0)
                                   ->setLib_compte($tscartes[$j])
                                   ->setSolde(0);
							$map_compte->save($compte);			
						}					
                }
				$db->commit();
                $this->view->data = true;
                return;
				
		    } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                return;
            }	
		}
	}
	
	
	public function donewcompteAction() {
		    $request = $this->getRequest();
            $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		    if ($request->isPost()) {
			  $compte = new Application_Model_EuCompte();
              $map_compte = new Application_Model_EuCompteMapper();
		      $tcartes = array();
			  $tscartes = array();
			  $tpbfcartes = array();
              $code_membre = $request->code_membre;
			  $mapper_acteur = new Application_Model_EuActeurMapper();
			  $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
			  try { 
			      $findacteur = $mapper_acteur->findByActeur($code_membre);
				  //if($findacteur != false) {
					//$tcartes[0]="TPAGCP";
				  //}	
					$tcartes[1]="TCNCSEI";
					$tcartes[2]="TPAGCI";
					$tcartes[3]="TIR";
					$tcartes[4]="TR";
					$tcartes[5]="TPaNu";
					$tcartes[6]="TPaR";
					$tcartes[7]="TFS";
					$tcartes[8]="TPN";
					$tcartes[9]="TIB";
					$tcartes[10]="TPaNu";
					$tcartes[11]="TIN";
					$tcartes[12]="CAPA";
					$tcartes[13]="TMARGE";
					//$tcartes[14]="TRE";
				 //if($findacteur != false) {	  
					//$tscartes[0]="TSGCP";
				 //}	
					$tscartes[1]="TSCNCSEI";
					$tscartes[2]="TSGCI";
					$tscartes[3]="TSCAPA";
					$tscartes[4]="TSPaNu";
					$tscartes[5]="TSPaR";
					$tscartes[6]="TSFS";
					$tscartes[7]="TSPN";
					$tscartes[8]="TSIN";
					$tscartes[9]="TSIB";
					$tscartes[10]="TSIR";
					$tscartes[11]="TSMARGE";
					//$tscartes[12]="TSRE";
					
					$date_deb = new Zend_Date(Zend_Date::ISO_8601);
					for($i = 1; $i < count($tcartes); $i++) {			    
						if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                            $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
							$type_carte = 'NR';
							$res = $map_compte->find($code_compte,$compte);
						} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TMARGE" || $tcartes[$i] == "TRE") {
                            $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
							$type_carte = 'NN';
							$res = $map_compte->find($code_compte,$compte);
						} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
							$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
							$type_carte = 'NB';
							$res = $map_compte->find($code_compte,$compte);
						} elseif($tcartes[$i] == "TIN") {
							$tcartes[$i] = "TI"; 
							$code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
							$type_carte = 'NN';
							$res = $map_compte->find($code_compte,$compte);
					    } elseif($tcartes[$i] == "TIR") {
						    $tcartes[$i] = "TI"; 
							$code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
							$type_carte = 'NR';
							$res = $map_compte->find($code_compte,$compte);
						} elseif($tcartes[$i] == "TIB") {
							$tcartes[$i] = "TI";
							$code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
							$type_carte = 'NB';
							$res = $map_compte->find($code_compte,$compte);
						}
										
						    if(!$res)  {
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre(null)
									   ->setCode_membre_morale($code_membre)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
								$map_compte->save($compte);
									
							}
									
                        }
									
						for($j = 1; $j < count($tscartes); $j++) {
									
							if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NR';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSMARGE" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NN';
							    $res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIN") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIR") {
								$tscartes[$j] = "TSI"; 
								$code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NR';
								$res = $map_compte->find($code_comptets,$compte);
							} elseif($tscartes[$j] == "TSIB") {
								$tscartes[$j] = "TSI";
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							}
										
								if(!$res) {
                                    $compte->setCode_cat($tscartes[$j])
                                           ->setCode_compte($code_comptets)
                                           ->setCode_membre(null)
										   ->setCode_membre_morale($code_membre)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tscartes[$j])
                                           ->setSolde(0);
									$map_compte->save($compte);
								}
									
                            }
							
							/*$table = new Application_Model_DbTable_EuActeur();
                            $select = $table->select();
					        $select->where('code_membre like ?', $code_membre);
					        $resultSet = $table->fetchAll($select);
					        $ligneacteur = $resultSet->current();
									
							if($ligneacteur->type_acteur == 'PBF' || $ligneacteur->type_acteur == 'gac_executante')  {
							    $tpbfcartes[0]="TPAGCPPBF";
								$tpbfcartes[1]="TSGCPPBF";
							    for($k = 0; $k < count($tpbfcartes); $k++) {
								    $numero_compte = 'NB' . '-' . $tpbfcartes[$k] . '-' . $code_membre;
									$type_carte = 'NB';
									$res = $map_compte->find($numero_compte,$compte);
										if(!$res) {
										    // insertion dans la table eu_compte
                                            $compte->setCode_cat($tpbfcartes[$k])
                                                   ->setCode_compte($numero_compte)
                                                   ->setCode_membre(null)
											       ->setCode_membre_morale($code_membre)
                                                   ->setCode_type_compte($type_carte)
                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($tpbfcartes[$k])
                                                   ->setSolde(0);
											$map_compte->save($compte);
									
                                        }
                                }	
						    }*/
							
							
					 
					$db->commit();
                    $this->view->data = true;
                    return; 
			    }
			    catch (Exception $exc) {
                    $db->rollback();
                    $this->view->message = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                    return;
                }
			
			}
	}
	
	
	
	
	public function donewlicenceAction() {
        $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        if ($request->isPost()) {
		    $compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
		    $tcartes = array();
			$tscartes = array();
			$tpbfcartes = array();
            $code_membre = $request->code_membre;
            $code_dev = $request->code_dev;
            $prix = $request->prix;
			$mode_fin = $request->mode_fin;
			if ($mode_fin == 'SMS') {
                $code_sms = $request->code_sms;
            } else if ($mode_fin == 'NN') {
                $type_comptenn = $request->compte_nn;
                $code_membre_app = $request->code_membre_app;
            } else {
                $membre_caps = $request->code_memb_caps;
            }
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			try {
			    $tfl = new Application_Model_DbTable_EuFl();
                $fl = new Application_Model_EuFl();
                $code_fl = 'FL-' . $code_membre;
                $result = $tfl->find($code_fl);
                if (count($result) > 0) {
                   $this->view->message = "Vous avez deja souscrit au frais de licence!!! ";
                   $db->rollBack();
                   return;
                }
                $cm_map = new Application_Model_EuCompteMapper();
                $mont_fl = Util_Utils::getParametre('FL', 'valeur');
                if ($mont_fl != null && $mont_fl != $prix) {
                   $this->view->message = "La valeur du fl doit etre egale à " . $mont_fl;
                   return;
                }
				if ($mode_fin == 'SMS') {
				    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
				    if ($code_sms != '') {
				       $sms = $sms_mapper->findByCreditCode($code_sms);
                       if ($sms != null) {
					      $mont_sms = $sms->getCreditAmount();
                            $dev_act = $sms->getCurrencyCode();
                            if ($dev_act == $code_dev) {
                                if ($dev_act != 'XOF') {
                                    $code_cours = $code_dev . '-XOF';
                                    $cours = new Application_Model_EuCours();
                                    $m_cours = new Application_Model_EuCoursMapper();
                                    $ret = $m_cours->find($code_cours, $cours);
                                    if ($ret) {
                                        $mont_sms = $mont_sms * $cours->getVal_dev_fin();
                                    }
                                }
                            } else {
                                $db->rollback();
                                $message = "Le code Devise $code_dev n'est conforme e celui du transfert $dev_act !!!";
                                $this->view->message = $message;
                                return;
                            }
							if($sms->getMotif() != 'FL') {
							   $db->rollback();
                               $message = "Le motif pour lequel ce code est emis ne correspond pas pour ce type d'operation!!!";
                               $this->view->message = $message;
                               return;
							}
							
							 if ($mont_sms == $mont_fl) {
							     
								$mapper = new Application_Model_EuOperationMapper();
								
								// insertion dans la table eu_operation
                                $compteur = $mapper->findConuter() + 1;
                                $date_deb = new Zend_Date(Zend_Date::ISO_8601);
								if(substr($code_membre,19,1)=='P') {
                                  Util_Utils::addOperation($compteur, $code_membre,null, null, $prix, null, 'Frais de licences', 'FL',$date_deb->toString('yyyy-MM-dd'), $date_deb->toString('HH:mm:ss'), $user->id_utilisateur);
                                }
								else {
								  Util_Utils::addOperation($compteur,null,$code_membre, null, $prix, null, 'Frais de licences', 'FL',$date_deb->toString('yyyy-MM-dd'), $date_deb->toString('HH:mm:ss'), $user->id_utilisateur);
                                
								}
								if(substr($code_membre,19,1)=='P') {
								    // insertion dans la table eu_fl
                                    $fl->setCode_fl($code_fl)
                                       ->setCode_membre($code_membre)
									   ->setCode_membre_morale(null)
                                       ->setMont_fl($mont_sms)
                                       ->setDate_fl($date_deb->toString('yyyy-MM-dd'))
                                       ->setHeure_fl($date_deb->toString('HH:mm:ss'))
                                       ->setId_utilisateur($user->id_utilisateur)
                                       ->setCreditcode($sms->getCreditCode());
                                    $tfl->insert($fl->toArray());
								   
								    $tcartes[0]="TPAGCRPG";
								    $tcartes[1]="TCNCS";
								    $tcartes[2]="TPaNu";
								    $tcartes[3]="TPaR";
								    $tcartes[4]="TR";
								    $tcartes[5]="CAPA";
									$tcartes[6]="TRE";
									
								    $tscartes[0]="TSRPG";
								    $tscartes[1]="TSCNCS";
								    $tscartes[2]="TSPaNu";
								    $tscartes[3]="TSPaR";
								    $tscartes[4]="TSCAPA";
									$tscartes[5]="TSRE";
								   
								   
								    for($i = 0; $i < count($tcartes); $i++) {
									    if($tcartes[$i] == "TCNCS") {
                                          $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
										  $type_carte = 'NR';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                          $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
										  $type_carte = 'NN';
									      $res = $map_compte->find($code_compte,$compte);
										} else {
										  $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
										  $type_carte = 'NB';
									      $res = $map_compte->find($code_compte,$compte);
										}
										if(!$res) {
										    // insertion dans la table eu_compte
                                            $compte->setCode_cat($tcartes[$i])
                                                   ->setCode_compte($code_compte)
                                                   ->setCode_membre($code_membre)
											       ->setCode_membre_morale(null)
                                                   ->setCode_type_compte($type_carte)
                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($tcartes[$i])
                                                   ->setSolde(0);
											$map_compte->save($compte);
									    }
                                    }
									
									for($j = 0; $j < count($tscartes); $j++) {
									    if($tscartes[$j] == "TSCNCS") {
                                          $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
										  $type_carte = 'NR';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                          $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
										  $type_carte = 'NN';
									      $res = $map_compte->find($code_comptets,$compte);
										} else {
										  $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
										  $type_carte = 'NB';
									      $res = $map_compte->find($code_comptets,$compte);
										}
										
										if(!$res) {
										    // insertion dans la table eu_compte
                                            $compte->setCode_cat($tscartes[$j])
                                                   ->setCode_compte($code_comptets)
                                                   ->setCode_membre($code_membre)
											       ->setCode_membre_morale(null)
                                                   ->setCode_type_compte($type_carte)
                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($tscartes[$j])
                                                   ->setSolde(0);
											$map_compte->save($compte);
									
									    }
									
                                    }   
								      
                                } else {
								    // insertion dans la table eu_fl
								    $fl->setCode_fl($code_fl)
                                       ->setCode_membre(null)
								       ->setCode_membre_morale($code_membre)
                                       ->setMont_fl($mont_sms)
                                       ->setDate_fl($date_deb->toString('yyyy-MM-dd'))
                                       ->setHeure_fl($date_deb->toString('HH:mm:ss'))
                                       ->setId_utilisateur($user->id_utilisateur)
                                       ->setCreditcode($sms->getCreditCode());
                                    $tfl->insert($fl->toArray());
									
									$tcartes[0]="TPAGCP";
									$tcartes[1]="TCNCSEI";
									$tcartes[2]="TPAGCI";
									$tcartes[3]="TIR";
									$tcartes[4]="TR";
									$tcartes[5]="TPaNu";
									$tcartes[6]="TPaR";
									$tcartes[7]="TFS";
									$tcartes[8]="TPN";
									$tcartes[9]="TIB";
									$tcartes[10]="TPaNu";
									$tcartes[11]="TIN";
									$tcartes[12]="CAPA";
									$tcartes[13]="TMARGE";
									$tcartes[14]="TRE";
									
									for($i = 0; $i < count($tcartes); $i++) {
									    if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                          $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
										  $type_carte = 'NR';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
										  $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
										  $type_carte = 'NN';
									      $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
										    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TIN") {
										    $tcartes[$i] = "TI"; 
										    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TMARGE") {
										    $tcartes[$i] = "TMARGE"; 
										    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_compte,$compte);
										}
										
										/*elseif($tcartes[$i] == "TMARGENB") {
										    $tcartes[$i] = "TMARGE"; 
										    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_compte,$compte);
										}*/
										
										elseif($tcartes[$i] == "TIR") {
										    $tcartes[$i] = "TI"; 
										    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
										    $type_carte = 'NR';
									        $res = $map_compte->find($code_compte,$compte);
										} elseif($tcartes[$i] == "TIB") {
										    $tcartes[$i] = "TI";
										    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_compte,$compte);
										}
										
										if(!$res) {
										    // insertion dans la table eu_compte
                                            $compte->setCode_cat($tcartes[$i])
                                                 ->setCode_compte($code_compte)
                                                 ->setCode_membre(null)
											     ->setCode_membre_morale($code_membre)
                                                 ->setCode_type_compte($type_carte)
                                                 ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tcartes[$i])
                                                 ->setSolde(0);
										    $map_compte->save($compte);
									
									    }
									
                                    }
									
									$tscartes[0]="TSGCP";
									$tscartes[1]="TSCNCSEI";
									$tscartes[2]="TSGCI";
									$tscartes[3]="TSCAPA";
									$tscartes[4]="TSPaNu";
									$tscartes[5]="TSPaR";
									$tscartes[6]="TSFS";
									$tscartes[7]="TSPN";
									$tscartes[8]="TSIN";
									$tscartes[9]="TSIB";
									$tscartes[10]="TSIR";
									$tscartes[11]="TSMARGE";
									$tscartes[12]="TSRE";
									
									for($j = 0; $j < count($tscartes); $j++) {
									
									    if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                          $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
										  $type_carte = 'NR';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                          $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
										  $type_carte = 'NN';
									      $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
										    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSIN") {
										    $tscartes[$j] = "TSI"; 
										    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSMARGE") {
										    $tscartes[$j] = "TSMARGE"; 
										    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
										    $type_carte = 'NN';
									        $res = $map_compte->find($code_comptets,$compte);
										}  
										elseif($tscartes[$j] == "TSIR") {
										    $tscartes[$j] = "TSI"; 
										    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
										    $type_carte = 'NR';
									        $res = $map_compte->find($code_comptets,$compte);
										} elseif($tscartes[$j] == "TSIB") {
										    $tscartes[$j] = "TSI";
										    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
										    $type_carte = 'NB';
									        $res = $map_compte->find($code_comptets,$compte);
										}
										
										if(!$res) {
										    // insertion dans la table eu_compte
                                            $compte->setCode_cat($tscartes[$j])
                                                   ->setCode_compte($code_comptets)
                                                   ->setCode_membre(null)
											       ->setCode_membre_morale($code_membre)
                                                   ->setCode_type_compte($type_carte)
                                                   ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($tscartes[$j])
                                                   ->setSolde(0);
											$map_compte->save($compte);
									    }
									
                                    }
									
                                    $table = new Application_Model_DbTable_EuActeur();
                                    $select = $table->select();
					                $select->where('code_membre like ?', $code_membre);
					                $resultSet = $table->fetchAll($select);
					                $ligneacteur = $resultSet->current();
									
									if($ligneacteur->type_acteur == 'PBF' || $ligneacteur->type_acteur == 'gac_executante')  {
									    $tpbfcartes[0]="TPAGCPPBF";
									    $tpbfcartes[1]="TSGCPPBF";
									    for($k = 0; $k < count($tpbfcartes); $k++) {
										    $numero_compte = 'NB' . '-' . $tpbfcartes[$k] . '-' . $code_membre;
										    $type_carte = 'NB';
									        $res = $map_compte->find($numero_compte,$compte);
										    if(!$res) {
										        // insertion dans la table eu_compte
                                                $compte->setCode_cat($tpbfcartes[$k])
                                                       ->setCode_compte($numero_compte)
                                                       ->setCode_membre(null)
											           ->setCode_membre_morale($code_membre)
                                                       ->setCode_type_compte($type_carte)
                                                       ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                                       ->setDesactiver(0)
                                                       ->setLib_compte($tpbfcartes[$k])
                                                       ->setSolde(0);
											    $map_compte->save($compte);
									
                                            }
                                        }	
									}	
									
								}
								
                                //Mise e jour du compte general fgfl
                                $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                                $cg_fgfn = new Application_Model_EuCompteGeneral();
                                $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                                if ($result3) {
                                    $cg_fgfn->setSolde($cg_fgfn->getSolde() + $prix);
                                    $cg_mapper->update($cg_fgfn);
                                } else {
                                    $cg_fgfn->setCode_compte('FL')
                                            ->setIntitule('Frais de licence')
                                            ->setService('E')
                                            ->setCode_type_compte('NN')
                                            ->setSolde($mont_sms);
                                    $cg_mapper->save($cg_fgfn);
                                }
                                         
								// Mise à jour de la table eu_smsmoney		  
                                $sms->setDestAccount_Consumed('FL-' . $code_membre)
                                    ->setDateTimeconsumed($date_deb->toString('dd/MM/yyyy HH:mm:ss'))
                                    ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/MM/yyyy')));
                                $sms_mapper->update($sms);
                
                                $db->commit();
                                $this->view->message = true;
                                return;    								
							 }
							 else {
                                $this->view->message = 'Le montant du fl doit etre egale ' . $mont_fl;
                                $db->rollback();
                                return;
                            }	
					}
				}
				else {
				    $this->view->message = 'Le Code sms  est requis pour continuer l\'operation!!!';
                    $db->rollback();
                    return; 
				}
                              
                } else if($mode_fin == 'NN') {
				
			        if ($code_dev != 'XOF') {
                        $code_cours = $code_dev . '-XOF';
                        $cours = new Application_Model_EuCours();
                        $m_cours = new Application_Model_EuCoursMapper();
                        $ret = $m_cours->find($code_cours, $cours);
                        if ($ret) {
                            if ($prix != '') {
                               $prix = $prix * $cours->getVal_dev_fin();
                            }
                        }
                    }
				    if ($prix == $mont_fl) {
				        $code_compte = 'NN-T' . $type_comptenn . '-' . $code_membre_app;
                        $compte_nn = new Application_Model_EuCompte();
                        $result_nn = $cm_map->find($code_compte, $compte_nn);
					    if ($result_nn && $compte_nn->getSolde() >= $prix) {
					    // Mise à jour des comptes crédits		 
                        $t_produit = new Application_Model_DbTable_EuCompteCredit();
                        $select = $t_produit->select();
                        $select->from($t_produit, array('sum(montant_credit) as somme'));
                        $select->where('code_membre = ?',$code_membre_app)
                               ->where('code_compte like ?','NN%')
                               ->where('code_produit like ?',$type_comptenn);
                        $result = $t_produit->fetchAll($select);
                        $row = $result->current();
						
						if ($row['somme'] < $prix) {
                            $db->rollback();
                            $this->view->message = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cette operation";
						    return;
						}  
						 
						$m_credit = new Application_Model_EuCompteCreditMapper();
				        $credits = $m_credit->findCreditByCompte($code_membre_app,$type_comptenn);
					    if ($credits != null) {
						   $j = 0;
                           $reste = $fs;
                           $nbre_credit = count($credits);
					       while ($reste > 0 && $j < $nbre_credit) {
					          $credit = $credits[$j];
                              $id = $credit->getId_credit();
						      if ($reste > $credit->getMontant_credit()) {
						          //Mise à jour du compte crédit
                                  $reste = $reste - $credit->getMontant_credit();
                                  $credit->setMontant_credit(0);
                                  $m_credit->update($credit); 
								   
						       } else {
							         //Mise à jour du compte crédit
                                     $credit->setMontant_credit($credit->getMontant_credit() - $reste);
                                     $m_credit->update($credit);
						             $reste = 0;
						        }
							    $j++;
						    }
						
						  }
						
						    //Mise à jour du compte principal
					        $compte_nn->setSolde($compte_nn->getSolde() - $prix);
                            $cm_map->update($compte_nn); 
						   
						    $mapper = new Application_Model_EuOperationMapper();
                            $compteur = $mapper->findConuter() + 1;
                            $date_deb = new Zend_Date(Zend_Date::ISO_8601);
                            Util_Utils::addOperation($compteur,$code_membre,null, null, $prix, null,'Frais de licences','FL',$date_deb->toString('yyyy-MM-dd'), $date_deb->toString('HH:mm:ss'), $user->id_utilisateur);
						   
						    $fl->setCode_fl($code_fl)
                               ->setCode_membre($code_membre)
						       ->setCode_membre_morale(null)
                               ->setMont_fl($prix)
                               ->setDate_fl($date_deb->toString('yyyy-MM-dd'))
                               ->setHeure_fl($date_deb->toString('HH:mm:ss'))
                               ->setId_utilisateur($user->id_utilisateur)
                               ->setCreditcode($type_comptenn . '-' . $code_membre_app);
                            $tfl->insert($fl->toArray());
							
							$tcartes[0]="TPAGCRPG";
							$tcartes[1]="TCNCS";
							$tcartes[2]="TPaNu";
							$tcartes[3]="TPaR";
						    $tcartes[4]="TR";
							$tcartes[5]="CAPA";
							$tcartes[5]="TRE";
									
							$tscartes[0]="TSRPG";
							$tscartes[1]="TSCNCS";
							$tscartes[2]="TSPaNu";
							$tscartes[3]="TSPaR";
							$tscartes[4]="TSCAPA";
							$tscartes[5]="TSRE";
							
							for($i = 0; $i < count($tcartes); $i++) {
							
							    if($tcartes[$i] == "TCNCS") {
                                    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
								    $type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
								} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
								    $type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
								} else {
								    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
									$type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
								}
										
								if(!$res) {
                                    $compte->setCode_cat($tcartes[$i])
                                           ->setCode_compte($code_compte)
                                           ->setCode_membre($code_membre)
										   ->setCode_membre_morale(null)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tcartes[$i])
                                           ->setSolde(0);
									$map_compte->save($compte);
									
							    }
									
                            }
							
							for($j = 0; $j < count($tscartes); $j++) {
							
							    if($tscartes[$j] == "TSCNCS") {
                                    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
								    $type_carte = 'NR';
									$res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
								    $type_carte = 'NN';
									$res = $map_compte->find($code_comptets,$compte);
								} else {
								    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_comptets,$compte);
								}
										
									if(!$res) {
                                        $compte->setCode_cat($tscartes[$j])
                                               ->setCode_compte($code_comptets)
                                               ->setCode_membre($code_membre)
											   ->setCode_membre_morale(null)
                                               ->setCode_type_compte($type_carte)
                                               ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                               ->setDesactiver(0)
                                               ->setLib_compte($tscartes[$j])
                                               ->setSolde(0);
										$map_compte->save($compte);
									
									}
									
                            }
							
                            //Mise e jour du compte general fgfn
                            $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                            $cg_fgfn = new Application_Model_EuCompteGeneral();
                            $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                            if ($result3) {
                                $cg_fgfn->setSolde($cg_fgfn->getSolde() + $prix);
                                $cg_mapper->update($cg_fgfn);
                            } else {
                                $cg_fgfn->setCode_compte('FL')
                                        ->setIntitule('Frais de licence')
                                        ->setService('E')
                                        ->setCode_type_compte('NN')
                                        ->setSolde($prix);
                                $cg_mapper->save($cg_fgfn);
                            }
							$db->commit();
                            $this->view->message = true;
                            return;	 
					} else {
                        $this->view->message = 'Le solde de votre compte nn est insuffisant !!! ';
                        $db->rollback();
                        return;
                    } 
					 
				 
				 } else {
                    $this->view->message = 'Le montant du fl doit être égal à ' . $mont_fl;
                    $db->rollback();
                    return;
                 }
				                   
			  
			    }   else {
                    if($code_dev != 'XOF') {
                        $code_cours = $code_dev . '-XOF';
                        $cours = new Application_Model_EuCours();
                        $m_cours = new Application_Model_EuCoursMapper();
                        $ret = $m_cours->find($code_cours, $cours);
                        if ($ret) {
                            if ($prix != '') {
                               $prix = $prix * $cours->getVal_dev_fin();
                            }
                        }
                    }
					$membre_caps = $request->code_memb_caps;
                    $caps_map = new Application_Model_EuCapsMapper();
                    $caps = $caps_map->fetchCapsByAppFl($membre_caps,$code_membre);
                    if ($caps != null) {
                        $mapper = new Application_Model_EuOperationMapper();
                        $compteur = $mapper->findConuter() + 1;
                        $date_deb = new Zend_Date(Zend_Date::ISO_8601);
						
						// insertion dans la table eu_operation
                        Util_Utils::addOperation($compteur,$code_membre,null, null, $prix, null,'Frais de licences','FL',$date_deb->toString('yyyy-MM-dd'), $date_deb->toString('HH:mm:ss'), $user->id_utilisateur);
						
						// insertion dans la table eu_fl
						$fl->setCode_fl($code_fl)
                           ->setCode_membre($code_membre)
						   ->setCode_membre_morale(null)
                           ->setMont_fl($prix)
                           ->setDate_fl($date_deb->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_deb->toString('HH:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($caps->getCode_caps());
                        $tfl->insert($fl->toArray());
						
						$tcartes[0]="TPAGCRPG";
						$tcartes[1]="TCNCS";
						$tcartes[2]="TPaNu";
						$tcartes[3]="TPaR";
						$tcartes[4]="TR";
						$tcartes[5]="CAPA";
						$tcartes[5]="TRE";
									
						$tscartes[0]="TSRPG";
					    $tscartes[1]="TSCNCS";
					    $tscartes[2]="TSPaNu";
						$tscartes[3]="TSPaR";
						$tscartes[4]="TSCAPA";
						$tscartes[5]="TSRE";
						
						for($i = 0; $i < count($tcartes); $i++) {
							if($tcartes[$i] == "TCNCS") {
                              $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code_membre;
							  $type_carte = 'NR';
							  $res = $map_compte->find($code_compte,$compte);
							} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                              $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code_membre;
							  $type_carte = 'NN';
							  $res = $map_compte->find($code_compte,$compte);
							} else {
							  $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code_membre;
							  $type_carte = 'NB';
							  $res = $map_compte->find($code_compte,$compte);
							}		
								if(!$res) {
								    // insertion dans la table eu_compte
                                    $compte->setCode_cat($tcartes[$i])
                                           ->setCode_compte($code_compte)
                                           ->setCode_membre($code_membre)
										   ->setCode_membre_morale(null)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tcartes[$i])
                                           ->setSolde(0);
									$map_compte->save($compte);
									
							    }
									
                        }
						
						for($j = 0; $j < count($tscartes); $j++) {
							if($tscartes[$j] == "TSCNCS") {
                                $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NR';
							    $res = $map_compte->find($code_comptets,$compte);
						    } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NN';
								$res = $map_compte->find($code_comptets,$compte);
							} else  {
								$code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code_membre;
								$type_carte = 'NB';
								$res = $map_compte->find($code_comptets,$compte);
							}
										
								if(!$res) {
								    // insertion dans la table eu_compte
                                    $compte->setCode_cat($tscartes[$j])
                                           ->setCode_compte($code_comptets)
                                           ->setCode_membre($code_membre)
										   ->setCode_membre_morale(null)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_deb->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tscartes[$j])
                                           ->setSolde(0);
									$map_compte->save($compte);
									
							    }
									
                        }
						
						
						
                        //Mise e jour du compte general fgfn
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $prix);
                            $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($prix);
                            $cg_mapper->save($cg_fgfn);
                        }
						// Mise à jour de la table eu_caps
                        $caps->setFl_utiliser(1);
                        $caps_map->update($caps);
                        $db->commit();
                        $this->view->message = true;
                        return;
                    } else {
                        $this->view->message = 'Le caps demande n\'existe pas !!! ';
                        $db->rollback();
                        return;
                    }
                }
				
			}
			catch (Exception $exc) {
                  $db->rollback();
                  $this->view->message = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                  return;
            }
	    }		
            
    }
	public function donewlAction() {
        $request = $this->getRequest();
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        if ($request->isPost()) {
            $type_comptenn = '';
            $code_membre = $request->code_membre;
            $code_dev = $request->code_dev;
            $mode_fin = $request->mode_fin;
            if ($mode_fin == 'NN') {
                $type_comptenn = $request->compte_nn;
                $code_membre_app = $request->code_membre_app;
            } elseif ($mode_fin == 'SMS') {
                $code_sms = $request->code_sms;
            } else {
                $membre_caps = $request->code_membre_caps;
            }
            $prix = $request->prix;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $tfl = new Application_Model_DbTable_EuFl();
                $fl = new Application_Model_EuFl();
                $code_fl = 'FL-' . $code_membre;
                $result = $tfl->find($code_fl);
                if (count($result) > 0) {
                    $this->view->message = "Vous avez deja souscrit au frais de licence!!! ";
                    $db->rollBack();
                    return;
                }
                $cm_map = new Application_Model_EuCompteMapper();
                $mont_fl = Util_Utils::getParametre('fl', 'valeur');
                if ($mont_fl != null && $mont_fl != $prix) {
                    $this->view->message = "La valeur du fl doit etre egale e " . $mont_fl;
                    return;
                }
                if ($mode_fin == 'SMS') {
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    if ($code_sms != '') {
                        $sms = $sms_mapper->findByCreditCode($code_sms);
                        if ($sms != null && $sms->getIDDateTimeConsumed() == 0 && $sms->getDestAccount_Consumed() == '') {
                            $mont_sms = $sms->getCreditAmount();
                            $dev_act = $sms->getCurrencyCode();
                            if ($dev_act == $code_dev) {
                                if ($dev_act != 'XOF') {
                                    $code_cours = $code_dev . '-XOF';
                                    $cours = new Application_Model_EuCours();
                                    $m_cours = new Application_Model_EuCoursMapper();
                                    $ret = $m_cours->find($code_cours, $cours);
                                    if ($ret) {
                                       $mont_sms = $mont_sms * $cours->getVal_dev_fin();
                                    }
                                }
                            } else {
                                $db->rollback();
                                $message = "Le code Devise $code_dev n'est conforme e celui du transfert $dev_act !!!";
                                $this->view->message = $message;
                                return;
                            }
                            if ($mont_sms == $mont_fl) {
                                $mapper = new Application_Model_EuOperationMapper();
                                $compteur = $mapper->findConuter() + 1;
                                $date_deb = new Zend_Date(Zend_Date::ISO_8601);
                                Util_Utils::addOperation($compteur, $code_membre, null, $prix, null, 'Frais de licences', 'FL', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);

                                $fl->setCode_fl($code_fl)
                                        ->setCode_membre($code_membre)
                                        ->setMont_fl($mont_sms)
                                        ->setDate_fl($date_deb->toString('yyyy-mm-dd'))
                                        ->setHeure_fl($date_deb->toString('hh:mm:ss'))
                                        ->setId_utilisateur($user->id_utilisateur)
                                        ->setCreditcode($sms->getCreditCode());
                                $tfl->insert($fl->toArray());

                                //Mise e jour du compte general fgfl
                                $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                                $cg_fgfn = new Application_Model_EuCompteGeneral();
                                $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                                if ($result3) {
                                    $cg_fgfn->setSolde($cg_fgfn->getSolde() + $prix);
                                    $cg_mapper->update($cg_fgfn);
                                } else {
                                    $cg_fgfn->setCode_compte('FL')
                                            ->setIntitule('Frais de licence')
                                            ->setService('E')
                                            ->setCode_type_compte('NN')
                                            ->setSolde($mont_sms);
                                    $cg_mapper->save($cg_fgfn);
                                }

                                //Verification de l'origine du code sms et Mise e jour du detail
                                $td_fact = new Application_Model_DbTable_EuDetailFacturation();
                                $d_fact = new Application_Model_EuDetailFacturation();
                                $tx_prestation = Util_Utils::getParametre('CNCS', 'CAPA');
                                $compte_transfert = $sms->getFromAccount();
                                $transfert = explode('-', $compte_transfert);
                                $membre_transfert = $transfert[2];
                                $t_acteur = new Application_Model_DbTable_EuActeur();
                                $select = $t_acteur->select();
                                $select->where('code_membre like ?', $membre_transfert)
                                        ->where('code_activite in (?)', array('DSMS', 'PBF'));
                                $results = $t_acteur->fetchAll($select);
                                if (count($results) > 0) {
                                    $acteur = $results->current();
                                    if ($acteur->code_activite == 'DSMS') {
                                        $t_detsms = new Application_Model_DbTable_EuDetailSmsmoney();
                                        $sms_select = $db->select();
                                        $sms_select->from('eu_detail_smsmoney', array('code_membre_dist', 'sum(solde_sms) as solde'));
                                        $sms_select->where('code_membre_dist like ?', $acteur->code_membre)
                                                   ->where('origine_sms in (?)', array('PBF', 'MF'))
                                                   ->having('solde > ?', $mont_fl)
                                                   ->order('origine_sms', 'asc');
                                        $sms_results = $db->fetchAll($sms_select);
                                        if (count($sms_results) > 0) {
                                            $select_det_sms = $db->select();
                                            $select_det_sms->from('eu_detail_smsmoney')
                                                    ->where('code_membre_dist like ?', $acteur->code_membre)
                                                    ->where('origine_sms in (?)', array('PBF', 'MF'));
                                            $details_sms = $db->fetchAll($select_det_sms);
                                            if (count($details_sms) > 0) {
                                                $mont_deduire = $prix;
                                                $det_sms = new Application_Model_EuDetailSmsmoney();
                                                $det_vtesms = new Application_Model_EuDetailVentesms();
                                                $tdet_vtesms = new Application_Model_DbTable_EuDetailVentesms();
                                                try {
                                                    foreach ($details_sms as $value) {
                                                        $det_sms->exchangeArray($value);
                                                        if ($det_sms->getSolde_sms() >= $mont_deduire) {
                                                            $det_vtesms->setId_detail_smsmoney($det_sms->getId_detail_smsmoney())
                                                                    ->setCode_membre_dist($det_sms->getCode_membre_dist())
                                                                    ->setCode_membre($code_membre)
                                                                    ->setType_tansfert($sms->getMotif())
                                                                    ->setCreditcode($sms->getCreditcode())
                                                                    ->setDate_vente($date_deb->toString('yyyy-mm-dd'))
                                                                    ->setMont_vente($mont_deduire)
                                                                    ->setId_utilisateur($user->id_utilisateur)
                                                                    ->setCode_produit('FL');
                                                            $tdet_vtesms->insert($det_vtesms->toArray());

                                                            $det_sms->setMont_vendu($det_sms->getMont_vendu() + $mont_deduire)
                                                                    ->setSolde_sms($det_sms->getSolde_sms() - $mont_deduire);
                                                            $mont_deduire = 0;
                                                            $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));
                                                        } else {
                                                            $mont_deduire -= $det_sms->getSolde_sms();

                                                            $det_vtesms->setId_detail_smsmoney($det_sms->getId_detail_smsmoney())
                                                                    ->setCode_membre_dist($det_sms->getCode_membre_dist())
                                                                    ->setCode_membre($code_membre)
                                                                    ->setType_tansfert($sms->getMotif())
                                                                    ->setCreditcode($sms->getCreditcode())
                                                                    ->setDate_vente($date_deb->toString('yyyy-mm-dd'))
                                                                    ->setMont_vente($det_sms->getSolde_sms())
                                                                    ->setId_utilisateur($user->id_utilisateur)
                                                                    ->setCode_produit('FL');
                                                            $tdet_vtesms->insert($det_vtesms->toArray());

                                                            $det_sms->setMont_vendu($det_sms->getMont_vendu() + $det_sms->getSolde_sms())
                                                                    ->setSolde_sms(0);
                                                            $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));
                                                        }
                                                        if ($mont_deduire == 0) {
                                                            break;
                                                        }
                                                    }
                                                    $sms->setDestAccount_Consumed('FL-' . $code_membre)
                                                            ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                                    $sms_mapper->update($sms);

                                                    //Facturations de la prestation
                                                    $mont_fact = $sms->getCreditAmount() * $tx_prestation / 100;
                                                    $_compte = new Application_Model_EuCompte();
                                                    $num_compte_fact = 'NN-' . 'TPAGCP-' . $membre_transfert;
                                                    $result = $cm_map->find($num_compte_fact, $_compte);
                                                    if ($result == false) {
                                                        $_compte->setCode_membre($membre_transfert)
                                                                ->setCode_cat('TPAGCP')
                                                                ->setSolde($mont_fact)
                                                                ->setDate_alloc($date_deb->toString('yyyy-mm-dd'))
                                                                ->setCode_compte($num_compte_fact)
                                                                ->setLib_compte('GCP')
                                                                ->setCode_type_compte('NN')
                                                                ->setDesactiver(0);
                                                        $cm_map->save($_compte);
                                                    } else {
                                                        $_compte->setSolde($_compte->getSolde() + $mont_fact);
                                                        $cm_map->update($_compte);
                                                    }

                                                    $d_fact->setCode_compte($num_compte_fact)
                                                            ->setCode_membre($code_membre)
                                                            ->setCreditcode($sms->getCreditcode())
                                                            ->setDate_facturation($date_deb->toString('yyyy-mm-dd'))
                                                            ->setMont_facturation($mont_fact)
                                                            ->setId_operation($compteur)
                                                            ->setId_cnp(0);
                                                    $td_fact->insert($d_fact->toArray());
                                                } catch (Exception $exc) {
                                                    $db->rollback();
                                                    $this->view->message = "Nbre : " . count($details_sms) . " " . $exc->getMessage() . " => " . $exc->getTraceAsString();
                                                    return;
                                                }
                                            } else {
                                                $db->rollback();
                                                $this->view->message = "Aucun enregistrement trouve!!!";
                                                return;
                                            }
                                        } else {
                                            $db->rollback();
                                            $this->view->message = "Pas de transfert sur votre compte de transfert!!!";
                                            return;
                                        }
                                    } elseif (count($results) == 0 && $acteur->code_activite == 'PBF') {
                                        $sms->setDestAccount_Consumed('FL-' . $code_membre)
                                            ->setDateTimeconsumed($date_deb->toString('dd/mm/yyyy hh:mm:ss'))
                                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_deb->toString('dd/mm/yyyy')));
                                        $sms_mapper->update($sms);
                                    } else {
                                        $db->rollback();
                                        $message = 'Erreur d\'execution : Votre compte de transfert est insuffisant pour effectuer cet operation';
                                        $this->view->message = $message;
                                        return;
                                    }
                                } else {
                                    $db->rollback();
                                    $message = "Erreur d\'execution : Cet acteur " . $membre_transfert . " n'existe pas. Veuilez contacter le mcnp!";
                                    $this->view->message = $message;
                                    return;
                                }
                                $db->commit();
                                $this->view->message = true;
                                return;
                            } else {
                                $this->view->message = 'Le montant du fl doit etre egal e ' . $mont_fl;
                                $db->rollback();
                                return;
                            }
                        } else {
                            $this->view->message = 'Le Code sms ' . $code_sms . ' a deje ete utilise ou invalide!!!';
                            $db->rollback();
                            return;
                        }
                    } else {
                        $this->view->message = 'Le Code sms  est requis pour continuer l\'operation!!!';
                        $db->rollback();
                        return;
                    }
                } elseif ($mode_fin == 'NN') {
                    if ($code_dev != 'XOF') {
                        $code_cours = $code_dev . '-XOF';
                        $cours = new Application_Model_EuCours();
                        $m_cours = new Application_Model_EuCoursMapper();
                        $ret = $m_cours->find($code_cours, $cours);
                        if ($ret) {
                            if ($prix != '') {
                                $prix = $prix * $cours->getVal_dev_fin();
                            }
                        }
                    }
                    if ($prix == $mont_fl) {
                        $code_compte = 'NN-' . $type_comptenn . '-' . $code_membre_app;
                        $compte_nn = new Application_Model_EuCompte();
                        $result_nn = $cm_map->find($code_compte, $compte_nn);
                        if ($result_nn && $compte_nn->getSolde() >= $prix) {
                            $mapper = new Application_Model_EuOperationMapper();
                            $compteur = $mapper->findConuter() + 1;
                            $date_deb = new Zend_Date(Zend_Date::ISO_8601);
                            Util_Utils::addOperation($compteur, $code_membre, null, $prix, null, 'Frais de licences', 'FL', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);
                            $fl->setCode_fl($code_fl)
                                    ->setCode_membre($code_membre)
                                    ->setMont_fl($prix)
                                    ->setDate_fl($date_deb->toString('yyyy-mm-dd'))
                                    ->setHeure_fl($date_deb->toString('hh:mm:ss'))
                                    ->setId_utilisateur($user->id_utilisateur)
                                    ->setCreditcode($code_compte);
                            $tfl->insert($fl->toArray());
                            //Mise e jour du compte general fgfn
                            $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                            $cg_fgfn = new Application_Model_EuCompteGeneral();
                            $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                            if ($result3) {
                                $cg_fgfn->setSolde($cg_fgfn->getSolde() + $prix);
                                $cg_mapper->update($cg_fgfn);
                            } else {
                                $cg_fgfn->setCode_compte('FL')
                                        ->setIntitule('Frais de licence')
                                        ->setService('E')
                                        ->setCode_type_compte('NN')
                                        ->setSolde($prix);
                                $cg_mapper->save($cg_fgfn);
                            }

                            $compte_nn->setSolde($compte_nn->getSolde() - $prix);
                            $cm_map->update($compte_nn);

                            $db->commit();
                            $this->view->message = true;
                            return;
                        } else {
                            $this->view->message = 'Le solde de votre compte nn est insuffisant !!! ';
                            $db->rollback();
                            return;
                        }
                    } else {
                        $this->view->message = 'Le montant du fl doit etre egal e ' . $mont_fl;
                        $db->rollback();
                        return;
                    }
                } else {
                    if ($code_dev != 'XOF') {
                        $code_cours = $code_dev . '-XOF';
                        $cours = new Application_Model_EuCours();
                        $m_cours = new Application_Model_EuCoursMapper();
                        $ret = $m_cours->find($code_cours, $cours);
                        if ($ret) {
                            if ($prix != '') {
                                $prix = $prix * $cours->getVal_dev_fin();
                            }
                        }
                    }

                    $caps_map = new Application_Model_EuCapsMapper();
                    $caps = $caps_map->fetchCapsByAppFl($membre_caps, $code_membre);
                    if ($caps != null) {
                        $mapper = new Application_Model_EuOperationMapper();
                        $compteur = $mapper->findConuter() + 1;
                        $date_deb = new Zend_Date(Zend_Date::ISO_8601);
                        Util_Utils::addOperation($compteur, $code_membre, null, $prix, null, 'Frais de licences', 'FL', $date_deb->toString('yyyy-mm-dd'), $date_deb->toString('hh:mm:ss'), $user->id_utilisateur);
                        $fl->setCode_fl($code_fl)
                           ->setCode_membre($code_membre)
                           ->setMont_fl($prix)
                           ->setDate_fl($date_deb->toString('yyyy-mm-dd'))
                           ->setHeure_fl($date_deb->toString('hh:mm:ss'))
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setCreditcode($caps->getCode_caps());
                        $tfl->insert($fl->toArray());
                        //Mise e jour du compte general fgfn
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                            $cg_fgfn->setSolde($cg_fgfn->getSolde() + $prix);
                            $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($prix);
                            $cg_mapper->save($cg_fgfn);
                        }
                        $caps->setFl_utiliser(1);
                        $caps_map->update($caps);

                        $db->commit();
                        $this->view->message = true;
                        return;
                    } else {
                        $this->view->message = 'Le caps demande n\'existe pas !!! ';
                        $db->rollback();
                        return;
                    }
                }
                //Redirection sur le contrat
                //return $this->_helper->redirector('licence', 'eu-html2-pdf-contrat', null, array('controller' => 'eu-html2-pdf-contrat', 'action' => 'licence', 'membre' => $code_membre));
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->message = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                return;
            }
        }
    }
	
    public function membreAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }
	
	
	public function membremAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre_morale;
        }
        $this->view->data = $data;
    }
	
	
	public function licencecodeAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $result = $mb->fetchAll();
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }
	

    public function soldennAction() {
        $code_membre = $_GET["membre"];
        $type_compte = $_GET["compte"];
        if ($code_membre != '' && $type_compte) {
            $tsms = new Application_Model_DbTable_EuCompte();
            $select = $tsms->select();
            $select->where('code_membre like ?', $code_membre)
                    ->where('code_cat = ?', $type_compte)
                    ->where('code_type_compte like ?', 'NN');
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $data = $results->current()->solde;
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
    }

    public function soldemfAction() {
        $num_bon = $_GET["num_bon"];
        if ($num_bon) {
            $tsms = new Application_Model_DbTable_EuCompte();
            $select = $tsms->select();
            $select->where('code_compte like ?', 'NN-TR-' . $num_bon)
                    ->where('code_cat = ?', 'tr')
                    ->where('code_type_compte like ?', 'NN');
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $data = $results->current()->solde;
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
    }

    public function typemembreAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data = $result->type_membre;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[1] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->prenom_membre);
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	public function recupraisonAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[1] = strtoupper($result->raison_sociale) ;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	
	
	public function categoriemAction() {
        $type = $_GET["type"];
        $code_membre = $_GET["memb"];
        $membre_map = new Application_Model_EuMembreMoraleMapper();
        $membre = new Application_Model_EuMembreMorale();
        $t_type = new Application_Model_DbTable_EuCategorieCompte();
        $select = $t_type->select();
        $select->where('code_cat like ?', 'T%')
		       ->where('code_cat not like ?', 'TS%')
			   ->where('code_cat <> ?', 'TI')
               ->where('code_type_compte like ?', $type)
			   ->where('type_membre like ?', '%' .'M'.'%');
        
        $types = $t_type->fetchAll($select);
        if (count($types) >= 1) {
            $data = array();
            foreach ($types as $value) {
                $data[] = $value->code_cat;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	public function categoriepAction() {
        $type = $_GET["type"];
        //$code_membre = $_GET["memb"];
        $membre_map = new Application_Model_EuMembreMapper();
        $membre = new Application_Model_EuMembre();
        $t_type = new Application_Model_DbTable_EuCategorieCompte();
        $select = $t_type->select();
        $select->where('code_cat like ?', 'T%')
		       ->where('code_cat not like ?', 'TS%')
               ->where('code_type_compte like ?', $type)
			   ->where('type_membre like ?','%'.'P'.'%');
        $types = $t_type->fetchAll($select);
        if (count($types) >= 1) {
           $data = array();
           foreach ($types as $value) {
            $data[] = $value->code_cat;
           }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	

    public function categorieAction() {
        $type = $_GET["type"];
        $code_membre = $_GET["memb"];
        $membre_map = new Application_Model_EuMembreMapper();
        $membre = new Application_Model_EuMembre();
        $t_type = new Application_Model_DbTable_EuCategorieCompte();
        $select = $t_type->select();
        $select->where('code_cat like ?', 'T%')
                ->where('code_type_compte like ?', $type);
        if ($membre != '') {
            $ret = $membre_map->find($code_membre, $membre);
            if ($ret) {
                $t_membre = $membre->getType_membre();
                $select->where('type_membre like ?', '%' . $t_membre . '%');
            }
        }
        $types = $t_type->fetchAll($select);
        if (count($types) >= 1) {
            $data = array();
            foreach ($types as $value) {
                $data[] = $value->code_cat;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function catAction() {
        $type = $_GET["type"];
        $t_type = new Application_Model_DbTable_EuCategorieCompte();
        $select = $t_type->select();
        $select->where('code_cat like ?', 'T%')
		       ->where('code_cat not like ?', 'TS%')
			   ->where('code_cat <> ?', 'TI')
               ->where('type_membre like ?', '%' . $type . '%');
        $types = $t_type->fetchAll($select);
        if (count($types) >= 1) {
            $data = array();
            foreach ($types as $value) {
                $data[] = $value->code_cat;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function typecarteAction() {
        $t_type = new Application_Model_DbTable_EuTypeCompte();
        $types = $t_type->fetchAll();
        if (count($types) >= 1) {
            $data = array();
            for ($i = 0; $i < count($types); $i++) {
                $value = $types[$i];
                $data[$i][0] = $value->code_type_compte;
                $data[$i][1] = $value->desc_type;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	public function membreapporteurAction(){
	       $data = array();
	       $type_membre = $_GET["type_membre"];
		   if($type_membre!='' && $type_membre=='P') {
		      $mb = new Application_Model_DbTable_EuMembre();
              $result = $mb->fetchAll();
              foreach ($result as $p) {
                  $data[] = $p->code_membre;
              }   
		   }
		   else if($type_membre!='' && $type_membre=='M') {
		       $mb = new Application_Model_DbTable_EuMembreMorale();
               $result = $mb->fetchAll();
               foreach ($result as $p) {
                  $data[] = $p->code_membre_morale;
               }
		    
		  }else {
            $data = '';
          }
		  
	      $this->view->data = $data;
	}
	

    public function newAction() {
        
    }

	public function newmAction() {
        
    }
	
	public function newpAction() {
        
    }
	
	public function newpmfAction() {
        
    }
	
	
	
    public function deviseAction() {
        $m_dev = new Application_Model_EuDeviseMapper();
        $results = $m_dev->fetchAll();
        $data = array();
        foreach ($results as $value) {
            $data[] = $value->getCode_dev();
        }
        $this->view->data = $data;
    }

    public function codesmsAction() {
        $code = $_GET["code"];
        if ($code != '') {
            $data = array();
            $tsms = new Application_Model_DbTable_EuSmsmoney();
            $select = $tsms->select();
            $select->where('creditcode = ?', $code)
                    ->where('iddatetimeconsumed = ?', 0);
            $results = $tsms->fetchAll($select);
            if (count($results) > 0) {
                $mont_capa = $results->current()->creditamount;
                $data = $mont_capa;
            } else {
                $data = 0;
            }
        }
        $this->view->data = $data;
    }

    public function prixAction() {
        $code_cat = $_GET["code_cat"];
        if ($code_cat != '') {
            $t_prix = new Application_Model_DbTable_EuPrixCarte();
            $select = $t_prix->select();
            $select->where('code_cat like ?', $code_cat);
            $results = $t_prix->fetchAll($select);
            if (count($results) > 0) {
                $row = $results->current();
                $this->view->data = $row["prix_carte"];
            } else {
                $this->view->data = 0;
            }
        }
    }
	
	
	public function donewcartemfAction() {
	       $compteur = $_POST['cpteur'];
		   $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		   if ($compteur >= 1) {
		       $date = Zend_Date::now();
               $carte = new Application_Model_EuCartes();
               $t_carte = new Application_Model_DbTable_EuCartes();
               $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
               $map_membre = new Application_Model_EuMembreMapper();
			   $map_membreM = new Application_Model_EuMembreMoraleMapper();
			   
			   $ancienmembre = new Application_Model_EuAncienMembre();
			   $ancienmembre_map = new Application_Model_EuAncienMembreMapper();
			   $anciencompte_nn = new Application_Model_EuAncienCompte();
			   $anciencm_map = new Application_Model_EuAncienCompteMapper();
			   
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			   try {
			       $membre = $_POST["code_membre"];
			       $mode_fin = $_POST['sel_mode_fin'];
				   $type_mf   = $_POST['type_mf'];
                   $apporteur = $_POST['code_membre_app'];
				   
				   // verification de la licence
                   $tfl = new Application_Model_DbTable_EuFl();
                   $code_fl = 'FL-' . $membre;
                   $result = $tfl->find($code_fl);
				   if (count($result) > 0) {
				       $somme = 0;
                       for ($i = 1; $i <= $compteur; $i++) {
                        $somme = $somme + $_POST["prix" . $i];
                       }
					   $montant = $somme;
					   if ($mode_fin == 'bon') {
					      $num_bon = $_POST['num_bon'];
						  $montant = $somme;
						  $code_compte = 'NN-TR-'.$num_bon;
                          $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
						  if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
						  
							 // Mise à jour de la table eu_repartition_mf11000		 
                             $t_repartition = new Application_Model_DbTable_EuRepartitionMf11000();
                             $select = $t_repartition->select();
                             $select->from($t_repartition,array('sum(solde_rep) as somme'));
                             $select->where('code_mf11000 = ?',$num_bon);
                             $result = $t_repartition->fetchAll($select);
                             $row = $result->current();
							 
							 if ($row['somme'] < $montant) {
                                $this->view->data = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cette operation";
                                return;
                             }
							 
							 $repmf11000  =  new Application_Model_EuRepartitionMf11000(); 
							 $m_repmf11000 = new Application_Model_EuRepartitionMf11000Mapper();
				             $mfcredits = $m_repmf11000->fetchRepByNumBon($num_bon);
							 $mapper = new Application_Model_EuOperationMapper();
                             $count = $mapper->findConuter() + 1;
                             $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                             $date_deb = clone $date_fin;
							 $mf = new Application_Model_EuMembreFondateur11000();
                             $mfm = new Application_Model_EuMembreFondateur11000Mapper();
							 
							 //Récupération des informations du membre fondateur 11000
                             $find_mf = $mfm->find($num_bon,$mf);
							 if($mf->getNb_repartition() == 32) {
							   $db->rollback();
                               $this->view->data = "Ce compte est destiné à faire du caps";
                               return;
							 } 
							 
							 if ($mfcredits != null) {
					            $j = 0;
                                $reste = $montant;
                                $nbre_credit = count($mfcredits);
					            while ($reste > 0 && $j < $nbre_credit) {
					                  $mfcredit = $mfcredits[$j];
                                      $id = $mfcredit->getId_rep();
									  $findrep = $m_rep->find($id,$rep);
						              if ($reste >= $mfcredit->getSolde_rep()) {
						                    //Mise à jour du compte crédit mf11000
                                            $reste = $reste - $mfcredit->getSolde_rep();
                                            $mfcredit->setSolde_rep(0);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
											$mfcredit->setPayer(1);
                                            $m_repmf11000->update($mfcredit);			 							   
						               } else {
							                //Mise à jour du compte crédit mf11000
                                            $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                            $m_repmf11000->update($mfcredit);
						                    $reste = 0;
						                }
							            $j++;
						                }
				               }
							   //Mise à jour du compte principal
					           $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                               $anciencm_map->update($anciencompte_nn);
							  
						  } else {
						     $db->rollback();
                             $this->view->data ="Votre compte ".$type_mf." est inexistante ou insuffisant";
                             return;
						  }
					   } else {
							  if($type_mf == 'MF11000') {
						         $montant = $somme;
						         $code_compte = " ";
						         $code_compte = 'NN-TR-'.$apporteur;
						         $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
						         if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
						            //Mise à jour du compte principal
					                $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                    $anciencm_map->update($anciencompte_nn);
						
				                 } else {
						             $db->rollback();
                                     $this->view->data ="Votre compte ".$type_mf." est inexistante ou insuffisant";
                                     return;
						         }
						   } else {
						           $rep = new Application_Model_EuRepartitionMf107();
				                   $m_rep = new Application_Model_EuRepartitionMf107Mapper();
						           $dmf = new Application_Model_EuDetailMf11000();
							       $mdmf = new Application_Model_EuDetailMf107Mapper();
							       $mf107 = new Application_Model_EuMembreFondateur107();
							       $mmf107 = new Application_Model_EuMembreFondateur107Mapper();
							       $montant = $somme;
							       $nb_dmf = 0;
								   
								   $code_compte = 'NN-TR-'.$apporteur;
                                   $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn); 
						           if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
							         $mfcredits = $m_rep->fetchRepByMembre($apporteur);
								     //enregistrement de l'operation
                                     $place = new Application_Model_EuOperation();
					
					                 if ($mfcredits != null) {
					                 $j = 0;
                                     $reste = $montant;
                                     $nbre_credit = count($mfcredits);
					                 while ($reste > 0 && $j < $nbre_credit) {
					                    $mfcredit = $mfcredits[$j];
                                        $id = $mfcredit->getId_rep();
										$findrep = $m_rep->find($id,$rep);
						                if ($reste >= $mfcredit->getSolde_rep()) {
						                    //Mise à jour du compte crédit mf107
                                            $reste = $reste - $mfcredit->getSolde_rep();
                                            $mfcredit->setSolde_rep(0);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
											$mfcredit->setPayer(1);
                                            $m_rep->update($mfcredit);			 							   
						                } else {
							                //Mise à jour du compte crédit mf107
                                            $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                            $m_rep->update($mfcredit);
						                    $reste = 0;
						                }
							            $j++;
						                }
						 
				                   } 
					               //Mise à jour du compte principal
								   $ret_req = $anciencm_map->find($code_compte,$anciencompte_nn);           
                                   $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                   $anciencm_map->update($anciencompte_nn);
							  
							  } else {
							      $this->view->data = "Votre compte ".$type_mf." est inexistante ou insuffisant !!!";
                                  $db->rollback();
                                  return;
							  }
								   
						   }
					   }
					   
					   for ($i = 1; $i <= $compteur; $i++)  {
					       $code_cat = $_POST["carte" . $i];
                           $type_carte = $_POST["typecarte" . $i];
                           $type_membre = substr($membre,19,1);
                           $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                           if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI")) {
                             $db->rollBack();
                             $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                             return;
                           }
						   
						   if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                              $db->rollBack();
                              $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                              return;
                           }
						   
						   $c_select = $t_carte->select();
                           $c_select->where('code_membre like ?', $membre)
                                    ->where('code_cat like ?', $_POST["carte" . $i])
									->where('code_compte like ?', $code_compte);
                           $results = $t_carte->fetchAll($c_select);
						   
						    if (count($results) >= 1) {
                              $db->rollBack();
                              $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                              return;
                            }
						   
						    $res = $map_compte->find($code_compte,$compte);   
							$id_demande = $carte->findConuter() + 1;
						    $prix = $_POST["prix" . $i];
                            $carte->setId_demande($id_demande)
								  ->setCode_cat($_POST["carte" . $i])
                                  ->setCode_membre($membre)
                                  ->setMont_carte($prix)
                                  ->setDate_demande($date->toString('yyyy-mm-dd'))
                                  ->setLivrer(0)
                                  ->setCode_Compte($code_compte)
                                  ->setImprimer(0)
                                  ->setCardPrintedDate('')
                                  ->setCardPrintedIDDate(0)
                                  ->setId_utilisateur($user->id_utilisateur);
                            $t_carte->insert($carte->toArray());
						    
					    }
					   
					    $mapper = new Application_Model_EuOperationMapper();
                        $compteur = $mapper->findConuter() + 1;
								
					    if(substr($membre,19,1)=='P') {
                         Util_Utils::addOperation($compteur, $membre,null, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
                        }
					  else {
					  Util_Utils::addOperation($compteur,null,$membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
					  }
								  
					  $db->commit();
                      $this->view->data = true;
                      return;  
				   
				   } else {
                     $db->rollback();
                     $this->view->data = "Vous devez souscrire à la licence de 10000 avant la demande de cartes";
                     return;
                   }    
			   
			   } catch (Exception $e) {
                   $db->rollback();
                   $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
               }
		 
	       }
		         
	}
	
	
	
	public function donewcartemfoldAction() {
	       $compteur = $_POST['cpteur'];
		   $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		   if ($compteur >= 1) {
		       $date = Zend_Date::now();
               $carte = new Application_Model_EuCartes();
               $t_carte = new Application_Model_DbTable_EuCartes();
               $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
               $map_membre = new Application_Model_EuMembreMapper();
			   $map_membreM = new Application_Model_EuMembreMoraleMapper();
			   
			   $ancienmembre = new Application_Model_EuAncienMembre();
			   $ancienmembre_map = new Application_Model_EuAncienMembreMapper();
			   $anciencompte_nn = new Application_Model_EuAncienCompte();
			   $anciencm_map = new Application_Model_EuAncienCompteMapper();
			   
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			   try {
			       $membre = $_POST["code_membre"];
			       $mode_fin = $_POST['sel_mode_fin'];
				   $type_mf   = $_POST['type_mf'];
                   $apporteur = $_POST['code_membre_app'];
				   
				   // verification de la licence
                   $tfl = new Application_Model_DbTable_EuFl();
                   $code_fl = 'FL-' . $membre;
                   $result = $tfl->find($code_fl);
				   if (count($result) > 0) {
				       $somme = 0;
                       for ($i = 1; $i <= $compteur; $i++) {
                        $somme = $somme + $_POST["prix" . $i];
                       }
					   $montant = $somme;
					   if ($mode_fin == 'bon') {
					      $num_bon = $_POST['num_bon'];
						  $montant = $somme;
						  $code_compte = 'NN-TR-'.$num_bon;
                          $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
						  if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
						  
							 // Mise à jour de la table eu_repartition_mf11000		 
                             $t_repartition = new Application_Model_DbTable_EuRepartitionMf11000();
                             $select = $t_repartition->select();
                             $select->from($t_repartition,array('sum(solde_rep) as somme'));
                             $select->where('code_mf11000 = ?',$num_bon);
                             $result = $t_repartition->fetchAll($select);
                             $row = $result->current();
							 
							 if ($row['somme'] < $montant) {
                                $this->view->data = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cette operation";
                                return;
                             }
							 
							 $repmf11000  =  new Application_Model_EuRepartitionMf11000(); 
							 $m_repmf11000 = new Application_Model_EuRepartitionMf11000Mapper();
				             $mfcredits = $m_repmf11000->fetchRepByNumBon($num_bon);
							 $mapper = new Application_Model_EuOperationMapper();
                             $count = $mapper->findConuter() + 1;
                             $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                             $date_deb = clone $date_fin;
							 $mf = new Application_Model_EuMembreFondateur11000();
                             $mfm = new Application_Model_EuMembreFondateur11000Mapper();
							 
							 //Récupération des informations du membre fondateur 11000
                             $find_mf = $mfm->find($num_bon,$mf);
							 if($mf->getNb_repartition() == 32) {
							   $db->rollback();
                               $this->view->data = "Ce compte est destiné à faire du caps";
                               return;
							 } 
							 
							 if ($mfcredits != null) {
					            $j = 0;
                                $reste = $montant;
                                $nbre_credit = count($mfcredits);
					            while ($reste > 0 && $j < $nbre_credit) {
					                  $mfcredit = $mfcredits[$j];
                                      $id = $mfcredit->getId_rep();
									  $findrep = $m_rep->find($id,$rep);
						              if ($reste >= $mfcredit->getSolde_rep()) {
						                    //Mise à jour du compte crédit mf11000
                                            $reste = $reste - $mfcredit->getSolde_rep();
                                            $mfcredit->setSolde_rep(0);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
											$mfcredit->setPayer(1);
                                            $m_repmf11000->update($mfcredit);			 							   
						               } else {
							                //Mise à jour du compte crédit mf11000
                                            $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                            $m_repmf11000->update($mfcredit);
						                    $reste = 0;
						                }
							            $j++;
						                }
				               }
							   //Mise à jour du compte principal
					           $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                               $anciencm_map->update($anciencompte_nn);
							  
						  } else {
						     $db->rollback();
                             $this->view->data ="Votre compte ".$type_mf." est inexistante ou insuffisant";
                             return;
						  }
					   } else {
							  if($type_mf == 'MF11000') {
						         $montant = $somme;
						         $code_compte = " ";
						         $code_compte = 'NN-TR-'.$apporteur;
						         $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
						         if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
						            //Mise à jour du compte principal
					                $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                    $anciencm_map->update($anciencompte_nn);
						
				                 } else {
						             $db->rollback();
                                     $this->view->data ="Votre compte ".$type_mf." est inexistante ou insuffisant";
                                     return;
						         }
						   } else {
						           $rep = new Application_Model_EuRepartitionMf107();
				                   $m_rep = new Application_Model_EuRepartitionMf107Mapper();
						           $dmf = new Application_Model_EuDetailMf11000();
							       $mdmf = new Application_Model_EuDetailMf107Mapper();
							       $mf107 = new Application_Model_EuMembreFondateur107();
							       $mmf107 = new Application_Model_EuMembreFondateur107Mapper();
							       $montant = $somme;
							       $nb_dmf = 0;
								   
								   $code_compte = 'NN-TR-'.$apporteur;
                                   $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn); 
						           if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
							         $mfcredits = $m_rep->fetchRepByMembre($apporteur);
								     //enregistrement de l'operation
                                     $place = new Application_Model_EuOperation();
					
					                 if ($mfcredits != null) {
					                 $j = 0;
                                     $reste = $montant;
                                     $nbre_credit = count($mfcredits);
					                 while ($reste > 0 && $j < $nbre_credit) {
					                    $mfcredit = $mfcredits[$j];
                                        $id = $mfcredit->getId_rep();
										$findrep = $m_rep->find($id,$rep);
						                if ($reste >= $mfcredit->getSolde_rep()) {
						                    //Mise à jour du compte crédit mf107
                                            $reste = $reste - $mfcredit->getSolde_rep();
                                            $mfcredit->setSolde_rep(0);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
											$mfcredit->setPayer(1);
                                            $m_rep->update($mfcredit);			 							   
						                } else {
							                //Mise à jour du compte crédit mf107
                                            $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                            $m_rep->update($mfcredit);
						                    $reste = 0;
						                }
							            $j++;
						                }
						 
				                   } 
					               //Mise à jour du compte principal
								   $ret_req = $anciencm_map->find($code_compte,$anciencompte_nn);           
                                   $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                   $anciencm_map->update($anciencompte_nn);
							  
							  } else {
							      $this->view->data = "Votre compte ".$type_mf." est inexistante ou insuffisant !!!";
                                  $db->rollback();
                                  return;
							  }
								   
						   }
					   }
					   
					   for ($i = 1; $i <= $compteur; $i++)  {
					       $code_cat = $_POST["carte" . $i];
                           $type_carte = $_POST["typecarte" . $i];
                           $type_membre = substr($membre,19,1);
                           $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                            if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI")) {
                             $db->rollBack();
                             $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                             return;
                            }
						   
						    if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                              $db->rollBack();
                              $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                              return;
                            }
						   
						    $c_select = $t_carte->select();
                            $c_select->where('code_membre like ?', $membre)
                                    ->where('code_cat like ?', $_POST["carte" . $i])
									->where('code_compte like ?', $code_compte);
                            $results = $t_carte->fetchAll($c_select);
						   
						    if (count($results) >= 1) {
                              $db->rollBack();
                              $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                              return;
                            }
						   
						    $res = $map_compte->find($code_compte,$compte);
                            if (!$res) {
						      if ($_POST["carte" . $i] == 'TR') {  
								 $code_cat='CAPA';
								 $code_compte_capa = $type_carte . '-' . $code_cat . '-' . $membre;
								 $compte->setCode_cat($code_cat)
                                        ->setCode_compte($code_compte_capa)
                                        ->setCode_membre($membre)
									    ->setCode_membre_morale(null)
                                        ->setCode_type_compte($_POST["typecarte" . $i])
                                        ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                        ->setDesactiver(0)
                                        ->setLib_compte($code_cat)
                                        ->setSolde(0);
								  $map_compte->save($compte);
								  
								  $id_demande = $carte->findConuter() + 1;
								  $prix = $_POST["prix" . $i];
                                  $carte->setId_demande($id_demande)
								      ->setCode_cat($code_cat)
                                      ->setCode_membre($membre)
                                      ->setMont_carte($prix)
                                      ->setDate_demande($date->toString('yyyy-mm-dd'))
                                      ->setLivrer(0)
                                      ->setCode_Compte($code_compte_capa)
                                      ->setImprimer(0)
                                      ->setCardPrintedDate('')
                                      ->setCardPrintedIDDate(0)
                                      ->setId_utilisateur($user->id_utilisateur);
                                  $t_carte->insert($carte->toArray()); 		   
								}
											   
								$compte->setCode_cat($_POST["carte" . $i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre($membre)
									   ->setCode_membre_morale(null)
                                       ->setCode_type_compte($_POST["typecarte" . $i])
                                       ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($_POST["carte" . $i])
                                       ->setSolde(0);
									   
							    $id_demande = $carte->findConuter() + 1;
								$map_compte->save($compte);
								
								
								if ($type_membre == "P") {
								    if ($_POST["carte" . $i] == 'TPAGCRPG') {  
									   $code_catts='TSRPG';
								    }   elseif ($_POST["carte" . $i] == 'TCNCS') {  
									   $code_catts='TSCNCS';	    
								    }   elseif ($_POST["carte" . $i] == 'TPaNu') {  
									   $code_catts='TSPaNu';	    
								    }   elseif ($_POST["carte" . $i] == 'TPaR') {  
									   $code_catts='TSPaR';	    
								    }   elseif ($_POST["carte" . $i] == 'TR') {  
									   $code_catts='TSCAPA';	    
								    }   elseif ($_POST["carte" . $i] == 'TFS') {  
									   $code_catts='TSFS';	    
								    }
										   
								    $code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
                                    $compte->setCode_cat($code_catts)
                                          ->setCode_compte($code_comptets)
                                          ->setCode_membre($membre)
										  ->setCode_membre_morale(null)
                                          ->setCode_type_compte($_POST["typecarte" . $i])
                                          ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                          ->setDesactiver(0)
                                          ->setLib_compte($_POST["carte" . $i])
                                          ->setSolde(0);
								    $map_compte->save($compte);
								
								}
							   
							    $prix = $_POST["prix" . $i];
                                $carte->setId_demande($id_demande)
								      ->setCode_cat($_POST["carte" . $i])
                                      ->setCode_membre($membre)
                                      ->setMont_carte($prix)
                                      ->setDate_demande($date->toString('yyyy-mm-dd'))
                                      ->setLivrer(0)
                                      ->setCode_Compte($code_compte)
                                      ->setImprimer(0)
                                      ->setCardPrintedDate('')
                                      ->setCardPrintedIDDate(0)
                                      ->setId_utilisateur($user->id_utilisateur);
                                 $t_carte->insert($carte->toArray());
							   
						   
						    } else  {
								    if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0)  {
						              if ($_POST["carte" . $i] == 'TPAGCRPG') {  
									     $code_catts='TSRPG';
										 $code_cat ='TPAGCRPG';
								      }   elseif ($_POST["carte" . $i] == 'TCNCS') {  
									     $code_catts='TSCNCS';
										 $code_cat ='TCNCS';	    
									  }    elseif ($_POST["carte" . $i] == 'TPaNu') {  
									     $code_catts='TSPaNu';
										 $code_cat ='TPaNu';	    
									  }   elseif ($_POST["carte" . $i] == 'TPaR') {  
										 $code_catts='TSPaR';
										 $code_cat='TPaR';	    
									  }   elseif ($_POST["carte" . $i] == 'TR') {  
										 $code_catts='TSCAPA';
										 $code_cat='CAPA';	    
									  }  elseif ($_POST["carte" . $i] == 'TFS') {  
									     $code_catts='TSFS';
										 $code_cat='TFS';	    
								      }
										   
									    $code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
									    $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                        $compte->setCode_cat($code_catts)
                                               ->setCode_compte($code_comptets)
                                               ->setCode_membre($membre)
										       ->setCode_membre_morale(null)
                                               ->setCode_type_compte($_POST["typecarte" . $i])
                                               ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                               ->setDesactiver(0)
                                               ->setLib_compte($code_cat)
                                               ->setSolde(0);
										
										$map_compte->save($compte); 
										$id_demande = $carte->findConuter() + 1;
                                        $prix = $_POST["prix" . $i];
                                        $carte->setId_demande($id_demande) 
											  ->setCode_cat($code_cat)
                                              ->setCode_membre($membre)
                                              ->setMont_carte($prix)
                                              ->setDate_demande($date->toString('yyyy-mm-dd'))
                                              ->setLivrer(0)
                                              ->setImprimer(0)
                                              ->setCardPrintedDate('')
                                              ->setCardPrintedIDDate(0)
                                              ->setCode_Compte($code_compte)
                                              ->setId_utilisateur($user->id_utilisateur);
                                            $t_carte->insert($carte->toArray());
										
						           } else {
                                     $db->rollBack();
                                     $this->view->data = 'La carte ' . $code_cat . ' a deje ete imprime pour ce membre !!!';
                                     return;
                                   }
						   
						   }
						   
					   
					   }
					   
					   $mapper = new Application_Model_EuOperationMapper();
                       $compteur = $mapper->findConuter() + 1;
								
					   if(substr($membre,19,1)=='P') {
                         Util_Utils::addOperation($compteur, $membre,null, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
                      }
					  else {
					  Util_Utils::addOperation($compteur,null,$membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
					  }
								  
					  $db->commit();
                      $this->view->data = true;
                      return;  
				   
				   } else {
                     $db->rollback();
                     $this->view->data = "Vous devez souscrire à la licence de 10000 avant la demande de cartes";
                     return;
                   }
				   
				   
				   
				    
			   
			   } catch (Exception $e) {
                   $db->rollback();
                   $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
               }
		 
	       }
		         
	}
	
	
	
	
	public function donewcarteAction()   {
		    $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		    $date = Zend_Date::now();
            $carte = new Application_Model_EuCartes();
            $t_carte = new Application_Model_DbTable_EuCartes();
            $compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
            $map_membre = new Application_Model_EuMembreMapper();
			$map_membreM = new Application_Model_EuMembreMoraleMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
			    try {
			      $membre = $_POST["code_membre"];
                  $montant = $_POST["mont_sms"];
				  $mode_fin = $_POST['sel_mode_fin'];	   
				  // verification de la licence
                  $tfl = new Application_Model_DbTable_EuFl();
                  $code_fl = 'FL-' . $membre;
                  $result = $tfl->find($code_fl);
				  if (count($result) > 0) {
					$cm_map = new Application_Model_EuCompteMapper();
					if ($mode_fin == 'SMS') {
                        $code_sms = $_POST["code_sms"];
                        $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                        $sms = $sms_mapper->findByCreditCode($code_sms);
						if ($code_sms != '') {
                            if ($sms == null) {
							   $db->rollBack();
                               $this->view->data = 'Le Code sms ' . $code_sms . ' a deje ete utilise ou invalide!!!';
                               return;
                            } 
						if($sms->getMotif() != 'FKPS' && $sms->getMotif() != 'FCPS') {
						    $db->rollBack();
                            $this->view->data = 'Le motif pour lequel ce code est emis ne correspond pas pour cette operation';
                            return;			   
						}
									
                        $c_select = $t_carte->select();
                        $c_select->where('code_membre like ?', $membre);
                        $results = $t_carte->fetchAll($c_select);
						
						// verification de la demande de carte			
                        if (count($results) >= 1) {
                            $db->rollBack();
                            $this->view->data = 'La demande de carte  a deje ete effectuee pour ce membre !!!';
                            return;
                        }            
                        
                        // insertion dans la table eu_carte						
						$id_demande = $carte->findConuter() + 1;
                        $mont_fkps = Util_Utils::getParametre('FKPS', 'valeur');
                            $carte->setId_demande($id_demande)
								  ->setCode_cat(null)
                                  ->setCode_membre($membre)
                                  ->setMont_carte($mont_fkps)
                                  ->setDate_demande($date->toString('yyyy-MM-dd'))
                                  ->setLivrer(0)
                                  ->setCode_Compte(null)
                                  ->setImprimer(0)
                                  ->setCardPrintedDate('')
                                  ->setCardPrintedIDDate(0)
                                  ->setId_utilisateur($user->id_utilisateur);
                            $t_carte->insert($carte->toArray());
                                     
                        }
                        $mapper = new Application_Model_EuOperationMapper();
                        $compteur = $mapper->findConuter() + 1;
						
                        // insertion dans la table eu_operation						
						if(substr($membre,19,1)=='P') {
                            Util_Utils::addOperation($compteur, $membre,null, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-MM-dd'), $date->toString('HH:mm:ss'), $user->id_utilisateur);
                        }
						else {
						    Util_Utils::addOperation($compteur,null,$membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-MM-dd'), $date->toString('HH:mm:ss'), $user->id_utilisateur);
						}
						
                        // Mise à jour de la table eu_smsmoney						
                        $sms->setDestAccount_Consumed('CPS-' . $membre)
                            ->setDateTimeconsumed($date->toString('dd/MM/yyyy HH:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms);    
                                    
                        $db->commit();
                        $this->view->data = true;
                        return;
                      
                    }   
					elseif ($mode_fin == 'NN') { 
					    $code_membre_app = $_POST['code_memb_app'];
                        $type_comptenn = $_POST['select_compte'];
                        $code_compte = 'NN-T' . $type_comptenn . '-' . $code_membre_app;
                        $compte_nn = new Application_Model_EuCompte();
                        $result_nn = $cm_map->find($code_compte, $compte_nn);
                        if ($result_nn && $compte_nn->getSolde() >= $montant) {
							    // Mise à jour des comptes crédits		 
                                $t_produit = new Application_Model_DbTable_EuCompteCredit();
                                $select = $t_produit->select();
                                $select->from($t_produit, array('sum(montant_credit) as somme'));
                                $select->where('code_membre = ?',$code_membre_app)
                                       ->where('code_compte like ?','NN%')
                                       ->where('code_produit like ?',$type_comptenn);
                                $result = $t_produit->fetchAll($select);
                                $row = $result->current(); 
								 
							    if ($row['somme'] < $montant) {
                                    $db->rollback();
                                    $this->view->data = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cette operation";
								}
								 
								$m_credit = new Application_Model_EuCompteCreditMapper();
				                $credits = $m_credit->findCreditByCompte($code_membre_app,$type_comptenn);
								 
								if ($credits != null) {
						            $j = 0;
                                    $reste = $fs;
                                    $nbre_credit = count($credits);
					                while ($reste > 0 && $j < $nbre_credit) {
					                       $credit = $credits[$j];
                                           $id = $credit->getId_credit();
						                if ($reste > $credit->getMontant_credit()) {
						                   //Mise à jour du compte crédit
                                           $reste = $reste - $credit->getMontant_credit();
                                           $credit->setMontant_credit(0);
                                           $m_credit->update($credit); 
								   
						                } else {
							              //Mise à jour du compte crédit
                                          $credit->setMontant_credit($credit->getMontant_credit() - $reste);
                                          $m_credit->update($credit);
						                  $reste = 0;
						                }
							            $j++;
						            }
						
						        }
								  
						            //Mise à jour du compte principal
					                $compte_nn->setSolde($compte_nn->getSolde() - $montant);
                                    $cm_map->update($compte_nn);
									
                                    $c_select = $t_carte->select();
                                    $c_select->where('code_membre like ?', $membre);	
                                    $results = $t_carte->fetchAll($c_select);
									
                                    if (count($results) >= 1) {
                                        $db->rollBack();
                                        $this->view->data = 'La demande de cette carte a deje ete effectuee pour ce membre !!!';
                                        return;
                                    }
									  
										$id_demande = $carte->findConuter() + 1;
										$mont_fkps = Util_Utils::getParametre('FKPS', 'valeur');
                                        $carte->setId_demande($id_demande)
										      ->setCode_cat(null)
                                              ->setCode_membre($membre)
                                              ->setMont_carte($mont_fkps)
                                              ->setDate_demande($date->toString('yyyy-MM-dd'))
                                              ->setLivrer(0)
                                              ->setCode_Compte(null)
                                              ->setImprimer(0)
                                              ->setCardPrintedDate('')
                                              ->setCardPrintedIDDate(0)
                                              ->setId_utilisateur($user->id_utilisateur);
                                        $t_carte->insert($carte->toArray());
								  
								    $mapper = new Application_Model_EuOperationMapper();
                                    $compteur = $mapper->findConuter() + 1;
								
								if(substr($membre,19,1)=='P') {
                                  Util_Utils::addOperation($compteur, $membre,null, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-MM-dd'), $date->toString('HH:mm:ss'), $user->id_utilisateur);
                                }
								else {
								   Util_Utils::addOperation($compteur,null,$membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-MM-dd'), $date->toString('HH:mm:ss'), $user->id_utilisateur);
								}
								  
								$db->commit();
                                $this->view->data = true;
                                return;   
						} else {
						       $db->rollback();
                               $this->view->data = "Votre compte ".$type_comptenn." est inexistante ou le solde de votre compte est insuffisant"; 
							   return; 
							   
						  
						}	     
					} else {
                        $code_membre_caps = $_POST['code_memb_caps'];
                        $caps_map = new Application_Model_EuCapsMapper();
                        $caps = $caps_map->fetchCapsByAppCps($code_membre_caps,$membre);
							if ($caps != null)  {   
                                $c_select = $t_carte->select();
                                $c_select->where('code_membre like ?', $membre);       
                                $results = $t_carte->fetchAll($c_select);
                                    if (count($results) >= 1) {
                                        $db->rollBack();
                                        $this->view->data = 'La demande de cette carte  a deje ete effectuee pour ce membre !!!';
                                        return;
                                    }
                                $mont_fkps = Util_Utils::getParametre('FKPS', 'valeur');
								
								// insertion dans la table eu_carte
    						    $id_demande = $carte->findConuter() + 1;
                                $carte->setId_demande($id_demande)
									  ->setCode_cat(null)
                                      ->setCode_membre($membre)
                                      ->setMont_carte($mont_fkps)
                                      ->setDate_demande($date->toString('yyyy-MM-dd'))
                                      ->setLivrer(0)
                                      ->setCode_Compte(null)
                                      ->setImprimer(0)
                                      ->setCardPrintedDate('')
                                      ->setCardPrintedIDDate(0)
                                      ->setId_utilisateur($user->id_utilisateur);
                                $t_carte->insert($carte->toArray());
                                     
								$caps->setCps_utiliser($caps->getCps_utiliser() - 1);
                                $caps_map->update($caps);
										
								} else {
                                    $db->rollBack();
                                    $this->view->data = "Le caps de l'apporteur $code_membre_caps n'existe pas !!!";
                                    return;
                                }
								
								// insertion dans la table eu_operation
                                $mapper = new Application_Model_EuOperationMapper();
                                $compteur = $mapper->findConuter() + 1;
								if(substr($membre,19,1)== 'P') {
                                  Util_Utils::addOperation($compteur, $membre,null, null, $montant, null, 'Frais de CPS', 'CPS',$date->toString('yyyy-MM-dd'), $date->toString('HH:mm:ss'), $user->id_utilisateur);
                                }
								else {
								  Util_Utils::addOperation($compteur,null,$membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-MM-dd'), $date->toString('HH:mm:ss'), $user->id_utilisateur);
								}
                                $db->commit();
                                $this->view->data = true;
                                return;
                    }  
						
					} else {
                        $db->rollback();
                        $this->view->data = "Vous devez souscrire à la licence de 10000 avant la demande de cartes";
                        return;
                    }		
			   }
			    catch (Exception $e) {
                   $db->rollback();
                   $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
                }
		   
		    //}
	
	}
	
	

	public function donewcarteoldAction()   {
	       $compteur = $_POST['cpteur'];
		   $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		   if ($compteur >= 1) {
		      $date = Zend_Date::now();
              $carte = new Application_Model_EuCartes();
              $t_carte = new Application_Model_DbTable_EuCartes();
              $compte = new Application_Model_EuCompte();
              $map_compte = new Application_Model_EuCompteMapper();
              $map_membre = new Application_Model_EuMembreMapper();
			  $map_membreM = new Application_Model_EuMembreMoraleMapper();
              $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
			  try {
			      $membre = $_POST["code_membre"];
                  $montant = $_POST["mont_sms"];
				  $mode_fin = $_POST['sel_mode_fin'];	   
				  // verification de la licence
                  $tfl = new Application_Model_DbTable_EuFl();
                  $code_fl = 'FL-' . $membre;
                  $result = $tfl->find($code_fl);
				  if (count($result) > 0) {
                    $somme = 0;
                    for ($i = 1; $i <= $compteur; $i++) {
                        $somme = $somme + $_POST["prix" . $i];
                    }
					$cm_map = new Application_Model_EuCompteMapper();
					if ($mode_fin == 'SMS') {
                        $code_sms = $_POST["code_sms"];
                        $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                        $sms = $sms_mapper->findByCreditCode($code_sms);
						if ($code_sms != '') {
                                if ($sms != null) {
                                   $montant = $sms->getCreditAmount();
                                   if ($somme != $montant) {
                                       $db->rollBack();
                                       $this->view->data = 'La valeur du Code sms ' . $code_sms . ' doit etre egale au montant des cartes demandees!!!';
                                       return;
                                   }
                                } else {
                                       $db->rollBack();
                                       $this->view->data = 'Le Code sms ' . $code_sms . ' a deje ete utilise ou invalide!!!';
                                       return;
                                }
								if($sms->getMotif() != 'FKPS' || $sms->getMotif() != 'FCPS') {
								       $db->rollBack();
                                       $this->view->data = 'Le motif pour lequel ce code est emis ne correspond pas pour cette operation';
                                       return;
									   
								}

                            if ($montant == $somme) {
                                for ($i = 1; $i <= $compteur; $i++) {
                                    $code_cat = $_POST["carte" . $i];
                                    $type_carte = $_POST["typecarte" . $i];
                                    $type_membre = substr($membre,19,1);
                                    $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                    if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                                        return;
                                    }
                                    if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                                        return;
                                    }
									
                                    $c_select = $t_carte->select();
                                    $c_select->where('code_membre like ?', $membre)
                                             ->where('code_cat like ?', $_POST["carte" . $i])
											 ->where('code_compte like ?', $code_compte);
                                    $results = $t_carte->fetchAll($c_select);
									
                                    if (count($results) >= 1) {
                                        $db->rollBack();
                                        $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                                        return;
                                    }
                                    $res = $map_compte->find($code_compte,$compte);
                                    if (!$res) {
									   if ($type_membre == "P") {
									      if($_POST["carte" . $i] == 'TR') {
											  $code_cat='CAPA';
								              $code_compte_capa = $type_carte . '-' . $code_cat . '-' . $membre;
											  $rescapa = $map_compte->find($code_compte_capa,$compte);
											  if (!$rescapa) {
								                 $compte->setCode_cat($code_cat)
                                                        ->setCode_compte($code_compte_capa)
                                                        ->setCode_membre($membre)
									                    ->setCode_membre_morale(null)
                                                        ->setCode_type_compte($_POST["typecarte" . $i])
                                                        ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                        ->setDesactiver(0)
                                                        ->setLib_compte($code_cat)
                                                        ->setSolde(0);
								                  $map_compte->save($compte);
											   }
								  
								    $id_demande = $carte->findConuter() + 1;
								    $prix = $_POST["prix" . $i];
                                    $carte->setId_demande($id_demande)
								          ->setCode_cat($code_cat)
                                          ->setCode_membre($membre)
                                          ->setMont_carte($prix)
                                          ->setDate_demande($date->toString('yyyy-mm-dd'))
                                          ->setLivrer(0)
                                          ->setCode_Compte($code_compte_capa)
                                          ->setImprimer(0)
                                          ->setCardPrintedDate('')
                                          ->setCardPrintedIDDate(0)
                                          ->setId_utilisateur($user->id_utilisateur);
                                    $t_carte->insert($carte->toArray());
										    } 
												$compte->setCode_cat($_POST["carte" . $i])
                                                       ->setCode_compte($code_compte)
                                                       ->setCode_membre($membre)
												       ->setCode_membre_morale(null)
                                                       ->setCode_type_compte($_POST["typecarte" . $i])
                                                       ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                       ->setDesactiver(0)
                                                       ->setLib_compte($_POST["carte" . $i])
                                                       ->setSolde(0);
													
								    }   else  {
									    if ($_POST["carte" . $i] == 'TR') {  
										    $code_cat='CAPA';
											$code_compte_capa = $type_carte . '-' . $code_cat . '-' . $membre;
											$rescapa = $map_compte->find($code_compte_capa,$compte);
											if (!$rescapa) {
											    $compte->setCode_cat($code_cat)
                                                      ->setCode_compte($code_compte_capa)
                                                      ->setCode_membre(null)
											          ->setCode_membre_morale($membre)
                                                      ->setCode_type_compte($_POST["typecarte" . $i])
                                                      ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                      ->setDesactiver(0)
                                                      ->setLib_compte($code_cat)
                                                      ->setSolde(0);
										        $map_compte->save($compte);
											}		   
											
										}
									    
										$compte->setCode_cat($_POST["carte" . $i])
                                               ->setCode_compte($code_compte)
                                               ->setCode_membre(null)
											   ->setCode_membre_morale($membre)
                                               ->setCode_type_compte($_POST["typecarte" . $i])
                                               ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                               ->setDesactiver(0)
                                               ->setLib_compte($_POST["carte" . $i])
                                               ->setSolde(0); 
                                    }
									
								    $id_demande = $carte->findConuter() + 1;
								    $map_compte->save($compte);
										
									//if ($_POST["carte" . $i] != 'tr') {	
									if ($type_membre == "P") {
										if ($_POST["carte" . $i] == 'TPAGCRPG') {  
											    $code_catts='TSRPG';
										}   elseif ($_POST["carte" . $i] == 'TCNCS') {  
											    $code_catts='TSCNCS';	    
										}   elseif ($_POST["carte" . $i] == 'TPaNu') {  
											    $code_catts='TSPaNu';	    
										}   elseif ($_POST["carte" . $i] == 'TPaR') {  
											    $code_catts='TSPaR';	    
										}   elseif ($_POST["carte" . $i] == 'TR') {  
											    $code_catts='TSCAPA';	    
										}
										   
										$code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
                                        $compte->setCode_cat($code_catts)
                                                   ->setCode_compte($code_comptets)
                                                   ->setCode_membre($membre)
												   ->setCode_membre_morale(null)
                                                   ->setCode_type_compte($_POST["typecarte" . $i])
                                                   ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($_POST["carte" . $i])
                                                   ->setSolde(0);
										 $map_compte->save($compte);
										  
										  		   	
										} else {
											$code_catts = "";
										    if ($_POST["carte" . $i] == 'TPAGCP') {  
											      $code_catts='TSGCP';
										    }   elseif ($_POST["carte" . $i] == 'TCNCSEI') {  
											      $code_catts='TSCNCSEI';	    
										    }   elseif ($_POST["carte" . $i] == 'TPAGCI') {  
											      $code_catts='TSGCI';	    
										    }   elseif ($_POST["carte" . $i] == 'TI') {  
											      $code_catts='TSI';	    
										    }   elseif ($_POST["carte" . $i] == 'TR') {  
											      $code_catts='TSCAPA';	    
										    }  elseif ($_POST["carte" . $i] == 'TPaNu') {  
											    $code_catts='TSPaNu';	    
										    }   elseif ($_POST["carte" . $i] == 'TPaR') {  
											    $code_catts='TSPaR';	    
										    }   elseif ($_POST["carte" . $i] == 'TFS') {  
											    $code_catts='TSFS';	    
										    }   elseif ($_POST["carte" . $i] == 'TPN') {  
											    $code_catts='TSPN';	    
										    }
											$code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
										    $compte->setCode_cat($code_catts)
                                                   ->setCode_compte($code_comptets)
                                                   ->setCode_membre(null)
												   ->setCode_membre_morale($membre)
                                                   ->setCode_type_compte($_POST["typecarte".$i])
                                                   ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($_POST["carte".$i])
                                                   ->setSolde(0);
										     $map_compte->save($compte);		    
                                        }
										
									//}	
                                        $prix = $_POST["prix" . $i];
                                        $carte->setId_demande($id_demande)
										      ->setCode_cat($_POST["carte" . $i])
                                              ->setCode_membre($membre)
                                              ->setMont_carte($prix)
                                              ->setDate_demande($date->toString('yyyy-mm-dd'))
                                              ->setLivrer(0)
                                              ->setCode_Compte($code_compte)
                                              ->setImprimer(0)
                                              ->setCardPrintedDate('')
                                              ->setCardPrintedIDDate(0)
                                              ->setId_utilisateur($user->id_utilisateur);
                                        $t_carte->insert($carte->toArray());
                                    } else {
                                        if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
										    if ($type_membre == "P") {
										        if ($_POST["carte" . $i] == 'TPAGCRPG') {  
											        $code_catts='TSRPG';
										        }   elseif ($_POST["carte" . $i] == 'TCNCS') {  
											        $code_catts='TSCNCS';	    
										        }    elseif ($_POST["carte" . $i] == 'TPaNu') {  
											        $code_catts='TSPaNu';	    
										        }   elseif ($_POST["carte" . $i] == 'TPaR') {  
											        $code_catts='TSPaR';	    
										        }   elseif ($_POST["carte" . $i] == 'TR') {  
											        $code_catts='TSCAPA';	    
										        }
										   
										    $code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
                                            $compte->setCode_cat($code_catts)
                                                  ->setCode_compte($code_comptets)
                                                  ->setCode_membre($membre)
												  ->setCode_membre_morale(null)
                                                  ->setCode_type_compte($_POST["typecarte" . $i])
                                                  ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                  ->setDesactiver(0)
                                                  ->setLib_compte($_POST["carte" . $i])
                                                  ->setSolde(0);
											  $map_compte->save($compte);	 	
										    } else {
											    $code_catts = "";
										        if ($_POST["carte" . $i] == 'TPAGCP') {  
											      $code_catts='TSGCP';
										        } elseif ($_POST["carte" . $i] == 'TCNCSEI') {  
											      $code_catts='TSCNCSEI';	    
										        }   elseif ($_POST["carte" . $i] == 'TPAGCI') {  
											      $code_catts='TSGCI';	    
										        }   elseif ($_POST["carte" . $i] == 'TI') {  
											      $code_catts='TSI';	    
										        }   elseif ($_POST["carte" . $i] == 'TR') {  
											      $code_catts='TSCAPA';	    
										        }  elseif ($_POST["carte" . $i] == 'TPaNu') {  
											    $code_catts='TSPaNu';	    
										        }   elseif ($_POST["carte" . $i] == 'TPaR') {  
											    $code_catts='TSPaR';	    
										        }   elseif ($_POST["carte" . $i] == 'TFS') {  
											    $code_catts='TSFS';	    
										        }  elseif ($_POST["carte" . $i] == 'TPN') {  
											    $code_catts='TSPN';	    
										        }
											    $code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
										        $compte->setCode_cat($code_catts)
                                                       ->setCode_compte($code_comptets)
                                                       ->setCode_membre(null)
												       ->setCode_membre_morale($membre)
                                                       ->setCode_type_compte($_POST["typecarte".$i])
                                                       ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                       ->setDesactiver(0)
                                                       ->setLib_compte($_POST["carte".$i])
                                                       ->setSolde(0); 
												 $map_compte->save($compte);	   
                                        }
										     
										    $id_demande = $carte->findConuter() + 1;
                                            $prix = $_POST["prix" . $i];
                                            $carte->setId_demande($id_demande) 
											      ->setCode_cat($_POST["carte" . $i])
                                                  ->setCode_membre($membre)
                                                  ->setMont_carte($prix)
                                                  ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                  ->setLivrer(0)
                                                  ->setImprimer(0)
                                                  ->setCardPrintedDate('')
                                                  ->setCardPrintedIDDate(0)
                                                  ->setCode_Compte($code_compte)
                                                  ->setId_utilisateur($user->id_utilisateur);
                                            $t_carte->insert($carte->toArray());
                                        } else {
                                            $db->rollBack();
                                            $this->view->data = 'La carte ' . $code_cat . ' a deje ete imprime pour ce membre !!!';
                                            return;
                                        }
                                    }
                                }
                                $mapper = new Application_Model_EuOperationMapper();
                                $compteur = $mapper->findConuter() + 1;
								
								if(substr($membre,19,1)=='P') {
                                   Util_Utils::addOperation($compteur, $membre,null, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
                                }
								else {
								   Util_Utils::addOperation($compteur,null,$membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
								}
                                //Verification de l'origine du code sms et Mise e jour du detail
                                //$td_fact = new Application_Model_DbTable_EuDetailFacturation();
                                //$d_fact = new Application_Model_EuDetailFacturation();
                                //$tx_prestation = Util_Utils::getParametre('cncs', 'capa');
                                //$compte_transfert = $sms->getFromAccount();
                                //$transfert = explode('-', $compte_transfert);
                                //$membre_transfert = $transfert[2];
                                //$t_acteur = new Application_Model_DbTable_EuActeur();
                                //$select = $t_acteur->select();
                                //$select->where('code_membre like ?', $membre_transfert)
                                //        ->where('code_activite in (?)', array('dsms', 'pbf'));
                                //$results = $t_acteur->fetchAll($select);
                                //if (count($results) > 0) {
                                   // $acteur = $results->current();
                                    //if ($acteur->code_activite == 'dsms') {           
                                        $sms->setDestAccount_Consumed('CPS-' . $membre)
                                            ->setDateTimeconsumed($date->toString('dd/mm/yyyy hh:mm:ss'))
                                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')));
                                        $sms_mapper->update($sms);    
                                    //} elseif ($acteur->code_activite == 'pbf') {
                                       // $sms->setDestAccount_Consumed('cps-' . $membre)
                                       //     ->setDateTimeconsumed($date->toString('dd/mm/yyyy hh:mm:ss'))
                                      //      ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')));
                                     //   $sms_mapper->update($sms);
                                    //} 
                                //} else {
                                    //$db->rollback();
                                    //$message = "Erreur d\'execution : Cet acteur " . $membre_transfert . " n'existe pas. Veuilez contacter le mcnp!";
                                    //$this->view->data = $message;
                                    //return;
                                //}
                                $db->commit();
                                $this->view->data = true;
                                return;
                            } else {
                                $this->view->data = 'Le montant doit etre egal e la somme des prix des cartes!!!';
                                return;
                            }
                         }
                    } elseif ($mode_fin == 'NN') { 
					     $code_membre_app = $_POST['code_memb_app'];
                         $type_comptenn = $_POST['select_compte'];
                         $code_compte = 'NN-T' . $type_comptenn . '-' . $code_membre_app;
                         $compte_nn = new Application_Model_EuCompte();
                         $result_nn = $cm_map->find($code_compte, $compte_nn);
                         if ($result_nn && $compte_nn->getSolde() >= $montant) {
						    if ($montant == $somme) {
							    // Mise à jour des comptes crédits		 
                                 $t_produit = new Application_Model_DbTable_EuCompteCredit();
                                 $select = $t_produit->select();
                                 $select->from($t_produit, array('sum(montant_credit) as somme'));
                                 $select->where('code_membre = ?',$code_membre_app)
                                        ->where('code_compte like ?','NN%')
                                        ->where('code_produit like ?',$type_comptenn);
                                 $result = $t_produit->fetchAll($select);
                                 $row = $result->current(); 
								 
								 if ($row['somme'] < $montant) {
                                    $db->rollback();
                                    $this->view->data = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cette operation";
								 }
								 
								 $m_credit = new Application_Model_EuCompteCreditMapper();
				                 $credits = $m_credit->findCreditByCompte($code_membre_app,$type_comptenn);
								 
								 if ($credits != null) {
						             $j = 0;
                                     $reste = $fs;
                                     $nbre_credit = count($credits);
					                 while ($reste > 0 && $j < $nbre_credit) {
					                       $credit = $credits[$j];
                                           $id = $credit->getId_credit();
						             if ($reste > $credit->getMontant_credit()) {
						                //Mise à jour du compte crédit
                                        $reste = $reste - $credit->getMontant_credit();
                                        $credit->setMontant_credit(0);
                                        $m_credit->update($credit); 
								   
						            } else {
							              //Mise à jour du compte crédit
                                          $credit->setMontant_credit($credit->getMontant_credit() - $reste);
                                          $m_credit->update($credit);
						                  $reste = 0;
						            }
							        $j++;
						            }
						
						          }
								  
						          //Mise à jour du compte principal
					              $compte_nn->setSolde($compte_nn->getSolde() - $montant);
                                  $cm_map->update($compte_nn);
								  for ($i = 1; $i <= $compteur; $i++) {
									  $code_cat = $_POST["carte" . $i];
                                      $type_carte = $_POST["typecarte" . $i];
                                      $type_membre = substr($membre,19,1);
                                      $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                      if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI")) {
                                      $db->rollBack();
                                      $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                                      return;
                                      }
                                      if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                                         $db->rollBack();
                                         $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                                         return;
                                      }
									
                                      $c_select = $t_carte->select();
                                      $c_select->where('code_membre like ?', $membre)
                                             ->where('code_cat like ?', $_POST["carte" . $i])
											 ->where('code_compte like ?', $code_compte);
                                      $results = $t_carte->fetchAll($c_select);
									
                                      if (count($results) >= 1) {
                                         $db->rollBack();
                                         $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                                         return;
                                      }
									  
									    $res = $map_compte->find($code_compte,$compte);
                                        if (!$res) {
									        if ($type_membre == "P") {
									            if($_POST["carte" . $i] == 'TR') {
											    $code_cat = 'CAPA';
											    $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                                $compte->setCode_cat($code_cat)
                                                       ->setCode_compte($code_compte)
                                                       ->setCode_membre($membre)
												       ->setCode_membre_morale(null)
                                                       ->setCode_type_compte($_POST["typecarte" . $i])
                                                       ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                       ->setDesactiver(0)
                                                       ->setLib_compte($code_cat)
                                                       ->setSolde(0);
										     } else  {
											    $compte->setCode_cat($_POST["carte" . $i])
                                                       ->setCode_compte($code_compte)
                                                       ->setCode_membre($membre)
												       ->setCode_membre_morale(null)
                                                       ->setCode_type_compte($_POST["typecarte" . $i])
                                                       ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                       ->setDesactiver(0)
                                                       ->setLib_compte($_POST["carte" . $i])
                                                       ->setSolde(0);
											  }
											  
									       } else  {
									         if ($_POST["carte" . $i] == 'TR') {  
										         $code_cat='CAPA';
											     $code_compte_capa = $type_carte . '-' . $code_cat . '-' . $membre;
											     $compte->setCode_cat($code_cat)
                                                        ->setCode_compte($code_compte_capa)
                                                        ->setCode_membre(null)
											            ->setCode_membre_morale($membre)
                                                        ->setCode_type_compte($_POST["typecarte" . $i])
                                                        ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                        ->setDesactiver(0)
                                                        ->setLib_compte($code_cat)
                                                        ->setSolde(0);
										          $map_compte->save($compte);		   
										       }
										       $compte->setCode_cat($_POST["carte" . $i])
                                                      ->setCode_compte($code_compte)
                                                      ->setCode_membre(null)
											          ->setCode_membre_morale($membre)
                                                      ->setCode_type_compte($_POST["typecarte" . $i])
                                                      ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                      ->setDesactiver(0)
                                                      ->setLib_compte($_POST["carte" . $i])
                                                      ->setSolde(0); 
                                            }
											$id_demande = $carte->findConuter() + 1;
								            $map_compte->save($compte);
											
											if ($type_membre == "P") {
										        if ($_POST["carte" . $i] == 'TPAGCRPG') {  
											      $code_catts='TSRPG';
										        }   elseif ($_POST["carte" . $i] == 'TCNCS') {  
											      $code_catts='TSCNCS';	    
										        }   elseif ($_POST["carte" . $i] == 'TPaNu') {  
											      $code_catts='TSPaNu';	    
										        }   elseif ($_POST["carte" . $i] == 'TPaR') {  
											       $code_catts='TSPaR';	    
										        }   elseif ($_POST["carte" . $i] == 'TR') {  
											       $code_catts='TSCAPA';	    
										        }
										   
										        $code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
                                                $compte->setCode_cat($code_catts)
                                                     ->setCode_compte($code_comptets)
                                                     ->setCode_membre($membre)
												     ->setCode_membre_morale(null)
                                                     ->setCode_type_compte($_POST["typecarte" . $i])
                                                     ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                     ->setDesactiver(0)
                                                     ->setLib_compte($_POST["carte" . $i])
                                                     ->setSolde(0);	
										       }
											else {
											        $code_catts = "";
										            if ($_POST["carte" . $i] == 'TPAGCP') {  
											           $code_catts='TSGCP';
										            }   elseif ($_POST["carte" . $i] == 'TCNCSEI') {  
											           $code_catts='TSCNCSEI';	    
										            }   elseif ($_POST["carte" . $i] == 'TPAGCI') {  
											           $code_catts='TSGCI';	    
										            }   elseif ($_POST["carte" . $i] == 'TI') {  
											           $code_catts='TSI';	    
										            }   elseif ($_POST["carte" . $i] == 'TR') {  
											           $code_catts='TSCAPA';	    
										            }    elseif ($_POST["carte" . $i] == 'TPaNu') {  
											           $code_catts='TSPaNu';	    
										            }   elseif ($_POST["carte" . $i] == 'TPaR') {  
											           $code_catts='TSPaR';	    
										            }    elseif ($_POST["carte" . $i] == 'TFS') {  
											           $code_catts='TSFS';	    
										            }    elseif ($_POST["carte" . $i] == 'TPN') {  
											           $code_catts='TSPN';	    
										            }
											$code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
										    $compte->setCode_cat($code_catts)
                                                   ->setCode_compte($code_comptets)
                                                   ->setCode_membre(null)
												   ->setCode_membre_morale($membre)
                                                   ->setCode_type_compte($_POST["typecarte".$i])
                                                   ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($_POST["carte".$i])
                                                   ->setSolde(0); 
                                        }
										$map_compte->save($compte);
										$prix = $_POST["prix" . $i];
                                        $carte->setId_demande($id_demande)
										      ->setCode_cat($_POST["carte" . $i])
                                              ->setCode_membre($membre)
                                              ->setMont_carte($prix)
                                              ->setDate_demande($date->toString('yyyy-mm-dd'))
                                              ->setLivrer(0)
                                              ->setCode_Compte($code_compte)
                                              ->setImprimer(0)
                                              ->setCardPrintedDate('')
                                              ->setCardPrintedIDDate(0)
                                              ->setId_utilisateur($user->id_utilisateur);
                                        $t_carte->insert($carte->toArray());
										  
									  
									  } else {
                                        if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
										    if ($type_membre == "P") {
										        if ($_POST["carte" . $i] == 'TPAGCRPG') {  
											        $code_catts='TSRPG';
										        }   elseif ($_POST["carte" . $i] == 'TCNCS') {  
											        $code_catts='TSCNCS';	    
										        }    elseif ($_POST["carte" . $i] == 'TPaNu') {  
											        $code_catts='TSPaNu';	    
										        }   elseif ($_POST["carte" . $i] == 'TPaR') {  
											        $code_catts='TSPaR';	    
										        }   elseif ($_POST["carte" . $i] == 'TR') {  
											        $code_catts='TSCAPA';	    
										        }
										   
										    $code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
                                            $compte->setCode_cat($code_catts)
                                                 ->setCode_compte($code_comptets)
                                                 ->setCode_membre($membre)
												 ->setCode_membre_morale(null)
                                                 ->setCode_type_compte($_POST["typecarte" . $i])
                                                 ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($_POST["carte" . $i])
                                                 ->setSolde(0);	
										    }   else {
											    $code_catts = "";
										        if ($_POST["carte" . $i] == 'TPAGCP') {  
											      $code_catts='TSGCP';
										        } elseif ($_POST["carte" . $i] == 'TCNCSEI') {  
											      $code_catts='TSCNCSEI';	    
										        }   elseif ($_POST["carte" . $i] == 'TPAGCI') {  
											      $code_catts='TSGCI';	    
										        }   elseif ($_POST["carte" . $i] == 'TI') {  
											      $code_catts='TSI';	    
										        }   elseif ($_POST["carte" . $i] == 'TR') {  
											      $code_catts='TSCAPA';	    
										        }  elseif ($_POST["carte" . $i] == 'TPaNu') {  
											    $code_catts='TSPaNu';	    
										        }   elseif ($_POST["carte" . $i] == 'TPaR') {  
											    $code_catts='TSPaR';	    
										        }   elseif ($_POST["carte" . $i] == 'TFS') {  
											    $code_catts='TSFS';	    
										        }  elseif ($_POST["carte" . $i] == 'TPN') {  
											    $code_catts='TSPN';	    
										        }
											    $code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
										        $compte->setCode_cat($code_catts)
                                                       ->setCode_compte($code_comptets)
                                                       ->setCode_membre(null)
												       ->setCode_membre_morale($membre)
                                                       ->setCode_type_compte($_POST["typecarte".$i])
                                                       ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                       ->setDesactiver(0)
                                                       ->setLib_compte($_POST["carte".$i])
                                                       ->setSolde(0); 
                                        }
										    $map_compte->save($compte); 
										    $id_demande = $carte->findConuter() + 1;
                                            $prix = $_POST["prix" . $i];
                                            $carte->setId_demande($id_demande) 
											      ->setCode_cat($_POST["carte" . $i])
                                                  ->setCode_membre($membre)
                                                  ->setMont_carte($prix)
                                                  ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                  ->setLivrer(0)
                                                  ->setImprimer(0)
                                                  ->setCardPrintedDate('')
                                                  ->setCardPrintedIDDate(0)
                                                  ->setCode_Compte($code_compte)
                                                  ->setId_utilisateur($user->id_utilisateur);
                                            $t_carte->insert($carte->toArray());
                                        } else {
                                            $db->rollBack();
                                            $this->view->data = 'La carte ' . $code_cat . ' a deje ete imprime pour ce membre !!!';
                                            return;
                                        }
                                    }
								  
								  }   //Fin de la boucle for
								  
								  $mapper = new Application_Model_EuOperationMapper();
                                  $compteur = $mapper->findConuter() + 1;
								
								if(substr($membre,19,1)=='p') {
                                  Util_Utils::addOperation($compteur, $membre,null, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
                                }
								else {
								   Util_Utils::addOperation($compteur,null,$membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
								}
								  
								$db->commit();
                                $this->view->data = true;
                                return;   
								
							} else {
							   $db->rollBack();
                               $this->view->data = 'Le montant doit être égal à la somme des prix des cartes!!!';
                               return;
							 
							}
						 } else {
						      $db->rollback();
                              $this->view->data = "Votre compte ".$type_comptenn." est inexistante ou le solde de votre compte est insuffisant"; 
							  return; 
							   
						  
						 }	     
					}
					else {
                        $code_membre_caps = $_POST['code_memb_caps'];
                        $caps_map = new Application_Model_EuCapsMapper();
                        //if ($caps != null)  {
                            if ($montant == $somme) {
                                for ($i = 1; $i <= $compteur; $i++)  {
                                    $caps = $caps_map->fetchCapsByAppCps($code_membre_caps, $membre);
									if ($caps != null)  {
                                    $code_cat = $_POST["carte" . $i];
                                    $type_carte = $_POST["typecarte" . $i];
                                    $type_membre = substr($membre,19,1);
                                    $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                    if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                                        return;
                                    }
                                    if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                                        return;
                                    }
                                    $c_select = $t_carte->select();
                                    $c_select->where('code_membre like ?', $membre)
                                             ->where('code_cat like ?', $_POST["carte" . $i])
											 ->where('code_compte like ?', $code_compte)
									;
                                    $results = $t_carte->fetchAll($c_select);
                                    if (count($results) >= 1) {
                                        $db->rollBack();
                                        $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                                        return;
                                    }
                                    $res = $map_compte->find($code_compte,$compte);
                                    if (!$res) {
                                        if ($_POST["carte" . $i] == 'TR') {
										    $code_cat = "CAPA";
                                            $compte->setCode_cat($code_cat)
                                                   ->setCode_compte($code_compte)
                                                   ->setCode_membre($membre)
												   ->setCode_membre_morale(null)
                                                   ->setCode_type_compte($_POST["typecarte" . $i])
                                                   ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($code_cat)
                                                   ->setSolde(0);
										} else  {
										      $compte->setCode_cat($_POST["carte" . $i])
                                                    ->setCode_compte($code_compte)
                                                    ->setCode_membre($membre)
												    ->setCode_membre_morale(null)
                                                    ->setCode_type_compte($_POST["typecarte" . $i])
                                                    ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                    ->setDesactiver(0)
                                                    ->setLib_compte($_POST["carte" . $i])
                                                    ->setSolde(0); 
                                        }
										
                                        $map_compte->save($compte);
                                        $prix = $_POST["prix" . $i];
											
							
										if ($_POST["carte" . $i] == 'TPAGCRPG') {  
											    $code_catts='TSRPG';
										}   elseif ($_POST["carte" . $i] == 'TCNCS') {  
											    $code_catts='TSCNCS';	    
										}    elseif ($_POST["carte" . $i] == 'TPaNu') {  
											    $code_catts='TSPaNu';	    
										}   elseif ($_POST["carte" . $i] == 'TPaR') {  
											    $code_catts='TSPaR';	    
										}   elseif ($_POST["carte" . $i] == 'TR') {  
											    $code_catts='TSCAPA';	    
									    }
										   
										$code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
                                        $compte->setCode_cat($code_catts)
                                                ->setCode_compte($code_comptets)
                                                ->setCode_membre($membre)
												->setCode_membre_morale(null)
                                                ->setCode_type_compte($_POST["typecarte" . $i])
                                                ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                ->setDesactiver(0)
                                                ->setLib_compte($_POST["carte" . $i])
                                                ->setSolde(0);	
										 
										$map_compte->save($compte);
										
										
										$id_demande = $carte->findConuter() + 1;
                                        $carte->setId_demande($id_demande)
										      ->setCode_cat($_POST["carte" . $i])
                                              ->setCode_membre($membre)
                                              ->setMont_carte($prix)
                                              ->setDate_demande($date->toString('yyyy-mm-dd'))
                                              ->setLivrer(0)
                                              ->setCode_Compte($code_compte)
                                              ->setImprimer(0)
                                              ->setCardPrintedDate('')
                                              ->setCardPrintedIDDate(0)
                                              ->setId_utilisateur($user->id_utilisateur);
                                        $t_carte->insert($carte->toArray());
                                    } else {
                                        if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
										    if ($_POST["carte" . $i] == 'TPAGCRPG') {  
											        $code_catts='TSRPG';
										    }   elseif ($_POST["carte" . $i] == 'TCNCS') {  
											        $code_catts='TSCNCS';	    
										    }    elseif ($_POST["carte" . $i] == 'TPaNu') {  
											        $code_catts='TSPaNu';	    
										    }   elseif ($_POST["carte" . $i] == 'TPaR') {  
											        $code_catts='TSPaR';	    
										    }   elseif ($_POST["carte" . $i] == 'TR') {  
											        $code_catts='TSCAPA';	    
										    }
										   
										    $code_comptets = $type_carte . '-' . $code_catts . '-' . $membre;
                                            $compte->setCode_cat($code_catts)
                                                   ->setCode_compte($code_comptets)
                                                   ->setCode_membre($membre)
												   ->setCode_membre_morale(null)
                                                   ->setCode_type_compte($_POST["typecarte" . $i])
                                                   ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                   ->setDesactiver(0)
                                                   ->setLib_compte($_POST["carte" . $i])
                                                   ->setSolde(0);
											$map_compte->save($compte);
										    
                                            $prix = $_POST["prix" . $i];
											$id_demande = $carte->findConuter() + 1;
                                            $carte->setId_demande($id_demande)
											      ->setCode_cat($_POST["carte" . $i])
                                                  ->setCode_membre($membre)
                                                  ->setMont_carte($prix)
                                                  ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                  ->setLivrer(0)
                                                  ->setImprimer(0)
                                                  ->setCardPrintedDate('')
                                                  ->setCardPrintedIDDate(0)
                                                  ->setCode_Compte($code_compte)
                                                  ->setId_utilisateur($user->id_utilisateur);
                                            $t_carte->insert($carte->toArray());
											
                                        } else {
                                            $db->rollBack();
                                            $this->view->data = 'La carte ' . $code_cat . ' a deje ete imprime pour ce membre !!!';
                                            return;
                                        }
                                    }
									    $caps->setCps_utiliser($caps->getCps_utiliser() - 1);
                                        $caps_map->update($caps);
									} else {
                                           $db->rollBack();
                                           $this->view->data = "Le caps de l'apporteur $code_membre_caps n'existe pas ou Vous ne pouvez faire au plus 3 cartes avec caps!!!";
                                           return;
                                    }
									
									
                                }

                                $mapper = new Application_Model_EuOperationMapper();
                                $compteur = $mapper->findConuter() + 1;
								if(substr($membre,19,1)=='P') {
                                     Util_Utils::addOperation($compteur, $membre,null, null, $montant, null, 'Frais de CPS', 'CPS',$date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
                                }
								else {
								     Util_Utils::addOperation($compteur,null,$membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
								}
                                //$caps->setCps_utiliser($caps->getCps_utiliser - 1);
                                //$caps_map->update($caps);

                                $db->commit();
                                $this->view->data = true;
                                return;
                            }   else {
                                     $db->rollBack();
                                     $this->view->data = 'Le montant doit etre egal e la somme des prix des cartes!!!';
                                     return;
                            }
                        //} else {
                            //$db->rollBack();
                           // $this->view->data = "Le caps de l'apporteur $code_membre_caps n'existe pas ou Vous ne pouvez faire qu'une seule carte avec caps!!!";
                           // return;
                        //}
                    }  
						
					} else {
                           $db->rollback();
                           $this->view->data = "Vous devez souscrire à la licence de 10000 avant la demande de cartes";
                           return;
                    }		
			   }
			   catch (Exception $e) {
                 $db->rollback();
                 $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
               }
		   
		   }
	
	}
	
	
    public function saveAction() {
	
        $compteur = $_POST['cpteur'];
        $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
        if ($compteur >= 1) {
            $date = Zend_Date::now();
            $carte = new Application_Model_EuCartes();
            $t_carte = new Application_Model_DbTable_EuCartes();
            $compte = new Application_Model_EuCompte();
            $map_compte = new Application_Model_EuCompteMapper();
            $map_membre = new Application_Model_EuMembreMapper();
			$map_membreM = new Application_Model_EuMembreMoraleMapper();
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
			
                $membre = $_POST["code_membre"];
                $montant = $_POST["mont_sms"];
                $mode_fin = $_POST['sel_mode_fin'];
                // verification de la licence
                $tfl = new Application_Model_DbTable_EuFl();
                $code_fl = 'FL-' . $membre;
                $result = $tfl->find($code_fl);
                if (count($result) > 0) {
                    $somme = 0;
                    for ($i = 1; $i <= $compteur; $i++) {
                        $somme = $somme + $_POST["prix" . $i];
                    }
                    $cm_map = new Application_Model_EuCompteMapper();
                    if ($mode_fin == 'SMS') {
                        $code_sms = $_POST["code_sms"];
                        $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                        $sms = $sms_mapper->findByCreditCode($code_sms);
                        if ($code_sms != '') {
                            if ($sms != null && $sms->getIDDateTimeConsumed() == 0 && $sms->getDestAccount_Consumed() == '') {
                                $montant = $sms->getCreditAmount();
                                if ($somme != $montant) {
                                    $db->rollBack();
                                    $this->view->data = 'La valeur du Code sms ' . $code_sms . ' doit etre egale au montant des cartes demandees!!!';
                                    return;
                                }
                            } else {
                                $db->rollBack();
                                $this->view->data = 'Le Code sms ' . $code_sms . ' a deje ete utilise ou invalide!!!';
                                return;
                            }

                            if ($montant == $somme) {
                                for ($i = 1; $i <= $compteur; $i++) {
                                    $code_cat = $_POST["carte" . $i];
                                    $type_carte = $_POST["typecarte" . $i];
                                    $type_membre = substr($membre,19,1);
                                    $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                    if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI" || $code_cat == "TR")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                                        return;
                                    }
                                    if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                                        return;
                                    }
                                    $c_select = $t_carte->select();
                                    $c_select->where('code_membre like ?', $membre)
                                            ->where('code_cat like ?', $_POST["carte" . $i]);
                                    $results = $t_carte->fetchAll($c_select);
                                    if (count($results) >= 1) {
                                        $db->rollBack();
                                        $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                                        return;
                                    }
                                    $res = $map_compte->find($code_compte, $compte);
                                    if (!$res) {
                                        $compte->setCode_cat($_POST["carte" . $i])
                                                ->setCode_compte($code_compte)
                                                ->setCode_membre($membre)
                                                ->setCode_type_compte($_POST["typecarte" . $i])
                                                ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                ->setDesactiver(0)
                                                ->setLib_compte($_POST["carte" . $i])
                                                ->setSolde(0);
                                        $map_compte->save($compte);
                                        $prix = $_POST["prix" . $i];
                                        $carte->setCode_cat($_POST["carte" . $i])
                                                ->setCode_membre($membre)
                                                ->setMont_carte($prix)
                                                ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                ->setLivrer(0)
                                                ->setCode_Compte($code_compte)
                                                ->setImprimer(0)
                                                ->setCardPrintedDate('')
                                                ->setCardPrintedIDDate(0)
                                                ->setId_utilisateur($user->id_utilisateur);
                                        $t_carte->insert($carte->toArray());
                                    } else {
                                        if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
                                            $prix = $_POST["prix" . $i];
                                            $carte->setCode_cat($_POST["carte" . $i])
                                                    ->setCode_membre($membre)
                                                    ->setMont_carte($prix)
                                                    ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                    ->setLivrer(0)
                                                    ->setImprimer(0)
                                                    ->setCardPrintedDate('')
                                                    ->setCardPrintedIDDate(0)
                                                    ->setCode_Compte($code_compte)
                                                    ->setId_utilisateur($user->id_utilisateur);
                                            $t_carte->insert($carte->toArray());
                                        } else {
                                            $db->rollBack();
                                            $this->view->data = 'La carte ' . $code_cat . ' a deje ete imprime pour ce membre !!!';
                                            return;
                                        }
                                    }
                                }
                                $mapper = new Application_Model_EuOperationMapper();
                                $compteur = $mapper->findConuter() + 1;
                                Util_Utils::addOperation($compteur, $membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);

                                //Verification de l'origine du code sms et Mise e jour du detail
                                $td_fact = new Application_Model_DbTable_EuDetailFacturation();
                                $d_fact = new Application_Model_EuDetailFacturation();
                                $tx_prestation = Util_Utils::getParametre('CNCS', 'CAPA');
                                $compte_transfert = $sms->getFromAccount();
                                $transfert = explode('-', $compte_transfert);
                                $membre_transfert = $transfert[2];
                                $t_acteur = new Application_Model_DbTable_EuActeur();
                                $select = $t_acteur->select();
                                $select->where('code_membre like ?', $membre_transfert)
                                       ->where('code_activite in (?)', array('DSMS', 'PBF'));
                                $results = $t_acteur->fetchAll($select);
                                if (count($results) > 0) {
                                    $acteur = $results->current();
                                    if ($acteur->code_activite == 'DSMS') {
                                        $t_detsms = new Application_Model_DbTable_EuDetailSmsmoney();
                                        $sms_select = $db->select();
                                        $sms_select->from('eu_detail_smsmoney', array('code_membre_dist', 'sum(solde_sms) as solde'));
                                        $sms_select->where('code_membre_dist like ?', $acteur->code_membre)
                                                ->where('origine_sms in (?)', array('PBF', 'MF'))
                                                ->having('solde > ?', $montant);
                                        $sms_results = $db->fetchAll($sms_select);
                                        if (count($sms_results) > 0) {
                                            $select_det_sms = $db->select();
                                            $select_det_sms->from('eu_detail_smsmoney')
                                                    ->where('code_membre_dist like ?', $acteur->code_membre)
                                                    ->where('origine_sms in (?)', array('PBF', 'MF'));
                                            $details_sms = $db->fetchAll($select_det_sms);
                                            if (count($details_sms) > 0) {
                                                $mont_deduire = $montant;
                                                $det_sms = new Application_Model_EuDetailSmsmoney();
                                                $det_vtesms = new Application_Model_EuDetailVentesms();
                                                $tdet_vtesms = new Application_Model_DbTable_EuDetailVentesms();
                                                try {
                                                    foreach ($details_sms as $value) {
                                                        $det_sms->exchangeArray($value);
                                                        if ($det_sms->getSolde_sms() >= $mont_deduire) {
                                                            $det_vtesms->setId_detail_smsmoney($det_sms->getId_detail_smsmoney())
                                                                    ->setCode_membre_dist($det_sms->getCode_membre_dist())
                                                                    ->setCode_membre($membre)
                                                                    ->setType_tansfert($sms->getMotif())
                                                                    ->setCreditcode($sms->getCreditcode())
                                                                    ->setDate_vente($date->toString('yyyy-mm-dd'))
                                                                    ->setMont_vente($mont_deduire)
                                                                    ->setId_utilisateur($user->id_utilisateur)
                                                                    ->setCode_produit('cps');
                                                            $tdet_vtesms->insert($det_vtesms->toArray());

                                                            $det_sms->setMont_vendu($det_sms->getMont_vendu() + $mont_deduire)
                                                                    ->setSolde_sms($det_sms->getSolde_sms() - $mont_deduire);
                                                            $mont_deduire = 0;
                                                            $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));
                                                        } else {
                                                            $mont_deduire -= $det_sms->getSolde_sms();

                                                            $det_vtesms->setId_detail_smsmoney($det_sms->getId_detail_smsmoney())
                                                                    ->setCode_membre_dist($det_sms->getCode_membre_dist())
                                                                    ->setCode_membre($membre)
                                                                    ->setType_tansfert($sms->getMotif())
                                                                    ->setCreditcode($sms->getCreditcode())
                                                                    ->setDate_vente($date->toString('yyyy-mm-dd'))
                                                                    ->setMont_vente($det_sms->getSolde_sms())
                                                                    ->setId_utilisateur($user->id_utilisateur)
                                                                    ->setCode_produit('cps');
                                                            $tdet_vtesms->insert($det_vtesms->toArray());

                                                            $det_sms->setMont_vendu($det_sms->getMont_vendu() + $det_sms->getSolde_sms())
                                                                    ->setSolde_sms(0);
                                                            $t_detsms->update($det_sms->toArray(), array('id_detail_smsmoney = ?' => $det_sms->getId_detail_smsmoney()));
                                                        }
                                                        if ($mont_deduire == 0) {
                                                            break;
                                                        }
                                                    }
                                                    $sms->setDestAccount_Consumed('CPS-' . $membre)
                                                            ->setDateTimeconsumed($date->toString('dd/mm/yyyy hh:mm:ss'))
                                                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')));
                                                    $sms_mapper->update($sms);

                                                    //Facturations de la prestation
                                                    $mont_fact = $sms->getCreditAmount() * $tx_prestation / 100;
                                                    $_compte = new Application_Model_EuCompte();
                                                    $num_compte_fact = 'NN-' . 'TPAGCP-' . $membre_transfert;
                                                    $result = $cm_map->find($num_compte_fact, $_compte);
                                                    if ($result == false) {
                                                        $_compte->setCode_membre($membre_transfert)
                                                                ->setCode_cat('TPAGCP')
                                                                ->setSolde($mont_fact)
                                                                ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                                ->setCode_compte($num_compte_fact)
                                                                ->setLib_compte('GCP')
                                                                ->setCode_type_compte('NN')
                                                                ->setDesactiver(0);
                                                        $cm_map->save($_compte);
                                                    } else {
                                                        $_compte->setSolde($_compte->getSolde() + $mont_fact);
                                                        $cm_map->update($_compte);
                                                    }

                                                    $d_fact->setCode_compte($num_compte_fact)
                                                            ->setCode_membre($membre)
                                                            ->setCreditcode($sms->getCreditcode())
                                                            ->setDate_facturation($date->toString('yyyy-mm-dd'))
                                                            ->setMont_facturation($mont_fact)
                                                            ->setId_operation($compteur)
                                                            ->setId_cnp(0);
                                                    $td_fact->insert($d_fact->toArray());
                                                } catch (Exception $exc) {
                                                    $db->rollback();
                                                    $this->view->data = "Nbre : " . count($details_sms) . " " . $exc->getMessage() . " => " . $exc->getTraceAsString();
                                                    return;
                                                }
                                            } else {
                                                $db->rollback();
                                                $this->view->data = "Aucun enregistrement trouve!!!";
                                                return;
                                            }
                                        }
                                    } elseif (count($results) == 0 && $acteur->code_activite == 'pbf') {
                                        $sms->setDestAccount_Consumed('cps-' . $membre)
                                                ->setDateTimeconsumed($date->toString('dd/mm/yyyy hh:mm:ss'))
                                                ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('dd/mm/yyyy')));
                                        $sms_mapper->update($sms);
                                    } else {
                                        $db->rollback();
                                        $message = 'Erreur d\'execution : Votre compte de transfert est insuffisant pour effectuer cet operation';
                                        $this->view->data = $message;
                                        return;
                                    }
                                } else {
                                    $db->rollback();
                                    $message = "Erreur d\'execution : Cet acteur " . $membre_transfert . " n'existe pas. Veuilez contacter le mcnp!";
                                    $this->view->data = $message;
                                    return;
                                }

                                $db->commit();
                                $this->view->data = true;
                                return;
                            } else {
                                $this->view->data = 'Le montant doit etre egal e la somme des prix des cartes!!!';
                                return;
                            }
                        }
                    } elseif ($mode_fin == 'CAPS') {
                        $code_membre_caps = $_POST['code_memb_caps'];
                        $caps_map = new Application_Model_EuCapsMapper();
                        $caps = $caps_map->fetchCapsByAppCps($code_membre_caps, $membre);
                        if ($caps != null && $compteur == 1) {
                            if ($montant == $somme) {
                                for ($i = 1; $i <= $compteur; $i++) {
                                    $code_cat = $_POST["carte" . $i];
                                    $type_carte = $_POST["typecarte" . $i];
                                    $type_membre = $map_membre->getTypeMembre($membre);
                                    $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                    if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI" || $code_cat == "TR")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                                        return;
                                    }
                                    if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                                        return;
                                    }
                                    $c_select = $t_carte->select();
                                    $c_select->where('code_membre like ?', $membre)
                                            ->where('code_cat like ?', $_POST["carte" . $i]);
                                    $results = $t_carte->fetchAll($c_select);
                                    if (count($results) >= 1) {
                                        $db->rollBack();
                                        $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                                        return;
                                    }
                                    $res = $map_compte->find($code_compte, $compte);
                                    if (!$res) {
                                        $compte->setCode_cat($_POST["carte" . $i])
                                                ->setCode_compte($code_compte)
                                                ->setCode_membre($membre)
                                                ->setCode_type_compte($_POST["typecarte" . $i])
                                                ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                ->setDesactiver(0)
                                                ->setLib_compte($_POST["carte" . $i])
                                                ->setSolde(0);
                                        $map_compte->save($compte);
                                        $prix = $_POST["prix" . $i];
                                        $carte->setCode_cat($_POST["carte" . $i])
                                                ->setCode_membre($membre)
                                                ->setMont_carte($prix)
                                                ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                ->setLivrer(0)
                                                ->setCode_Compte($code_compte)
                                                ->setImprimer(0)
                                                ->setCardPrintedDate('')
                                                ->setCardPrintedIDDate(0)
                                                ->setId_utilisateur($user->id_utilisateur);
                                        $t_carte->insert($carte->toArray());
                                    } else {
                                        if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
                                            $prix = $_POST["prix" . $i];
                                            $carte->setCode_cat($_POST["carte" . $i])
                                                    ->setCode_membre($membre)
                                                    ->setMont_carte($prix)
                                                    ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                    ->setLivrer(0)
                                                    ->setImprimer(0)
                                                    ->setCardPrintedDate('')
                                                    ->setCardPrintedIDDate(0)
                                                    ->setCode_Compte($code_compte)
                                                    ->setId_utilisateur($user->id_utilisateur);
                                            $t_carte->insert($carte->toArray());
                                        } else {
                                            $db->rollBack();
                                            $this->view->data = 'La carte ' . $code_cat . ' a deje ete imprime pour ce membre !!!';
                                            return;
                                        }
                                    }
                                }

                                $mapper = new Application_Model_EuOperationMapper();
                                $compteur = $mapper->findConuter() + 1;
                                Util_Utils::addOperation($compteur, $membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);

                                $caps->setCps_utiliser(1);
                                $caps_map->update($caps);

                                $db->commit();
                                $this->view->data = true;
                                return;
                            } else {
                                $db->rollBack();
                                $this->view->data = 'Le montant doit etre egal e la somme des prix des cartes!!!';
                                return;
                            }
                        } else {
                            $db->rollBack();
                            $this->view->data = "Le caps de l'apporteur $code_membre_caps n'existe pas ou Vous ne pouvez faire qu'une seule carte avec caps!!!";
                            return;
                        }
                    } elseif ($mode_fin == 'NN') {
                        $code_membre_app = $_POST['code_memb_app'];
                        $type_comptenn = $_POST['select_compte'];
                        $code_compte = 'NN-' . $type_comptenn . '-' . $code_membre_app;
                        $compte_nn = new Application_Model_EuCompte();
                        $result_nn = $cm_map->find($code_compte, $compte_nn);
                        if ($result_nn && $compte_nn->getSolde() >= $montant) {
                            if ($montant == $somme) {
                                for ($i = 1; $i <= $compteur; $i++) {
                                    $code_cat = $_POST["carte" . $i];
                                    $type_carte = $_POST["typecarte" . $i];
                                    $type_membre = $map_membre->getTypeMembre($membre);
                                    $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                    if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI" || $code_cat == "TR")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                                        return;
                                    }
                                    if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                                        $db->rollBack();
                                        $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                                        return;
                                    }
                                    $c_select = $t_carte->select();
                                    $c_select->where('code_membre like ?', $membre)
                                            ->where('code_cat like ?', $_POST["carte" . $i]);
                                    $results = $t_carte->fetchAll($c_select);
                                    if (count($results) >= 1) {
                                        $db->rollBack();
                                        $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                                        return;
                                    }
                                    $res = $map_compte->find($code_compte, $compte);
                                    if (!$res) {
                                        $compte->setCode_cat($_POST["carte" . $i])
                                                ->setCode_compte($code_compte)
                                                ->setCode_membre($membre)
                                                ->setCode_type_compte($_POST["typecarte" . $i])
                                                ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                                ->setDesactiver(0)
                                                ->setLib_compte($_POST["carte" . $i])
                                                ->setSolde(0);
                                        $map_compte->save($compte);
                                        $prix = $_POST["prix" . $i];
                                        $carte->setCode_cat($_POST["carte" . $i])
                                                ->setCode_membre($membre)
                                                ->setMont_carte($prix)
                                                ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                ->setLivrer(0)
                                                ->setCode_Compte($code_compte)
                                                ->setImprimer(0)
                                                ->setCardPrintedDate('')
                                                ->setCardPrintedIDDate(0)
                                                ->setId_utilisateur($user->id_utilisateur);
                                        $t_carte->insert($carte->toArray());
                                    } else {
                                        if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
                                            $prix = $_POST["prix" . $i];
                                            $carte->setCode_cat($_POST["carte" . $i])
                                                    ->setCode_membre($membre)
                                                    ->setMont_carte($prix)
                                                    ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                    ->setLivrer(0)
                                                    ->setImprimer(0)
                                                    ->setCardPrintedDate('')
                                                    ->setCardPrintedIDDate(0)
                                                    ->setCode_Compte($code_compte)
                                                    ->setId_utilisateur($user->id_utilisateur);
                                            $t_carte->insert($carte->toArray());
                                        } else {
                                            $db->rollBack();
                                            $this->view->data = 'La carte ' . $code_cat . ' a deje ete imprime pour ce membre !!!';
                                            return;
                                        }
                                    }
                                }
                                $mapper = new Application_Model_EuOperationMapper();
                                $compteur = $mapper->findConuter() + 1;
                                Util_Utils::addOperation($compteur, $membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);

                                $compte_nn->setSolde($compte_nn->getSolde() - $montant);
                                $cm_map->update($compte_nn);

                                $db->commit();
                                $this->view->data = true;
                                return;
                            } else {
                                $db->rollBack();
                                $this->view->data = 'Le montant doit etre egal e la somme des prix des cartes!!!';
                                return;
                            }
                        }
                    } else {
                        if ($montant == $somme) {
                            for ($i = 1; $i <= $compteur; $i++) {
                                $code_cat = $_POST["carte" . $i];
                                $type_carte = $_POST["typecarte" . $i];
                                $type_membre = $map_membre->getTypeMembre($membre);
                                $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                                if ($type_membre == "P" && ($code_cat == "TPAGCI" || $code_cat == "TCNCSEI" || $code_cat == "TPN" || $code_cat == "TI" || $code_cat == "TPAGCP" || $code_cat == "TSCI" || $code_cat == "TR")) {
                                    $db->rollBack();
                                    $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes physiques!!!';
                                    return;
                                }
                                if ($type_membre == "M" && ($code_cat == "TPAGCRPG" || $code_cat == "TCNCS")) {
                                    $db->rollBack();
                                    $this->view->data = 'Pas de cartes ' . $code_cat . ' pour les personnes morales!!!';
                                    return;
                                }
                                $c_select = $t_carte->select();
                                $c_select->where('code_membre like ?', $membre)
                                        ->where('code_cat like ?', $_POST["carte" . $i]);
                                $results = $t_carte->fetchAll($c_select);
                                if (count($results) >= 1) {
                                    $db->rollBack();
                                    $this->view->data = 'La demande de cette carte ' . $code_cat . ' a deje ete effectuee pour ce membre !!!';
                                    return;
                                }
                                $res = $map_compte->find($code_compte, $compte);
                                if (!$res) {
                                    $compte->setCode_cat($_POST["carte" . $i])
                                            ->setCode_compte($code_compte)
                                            ->setCode_membre($membre)
                                            ->setCode_type_compte($_POST["typecarte" . $i])
                                            ->setDate_alloc($date->toString('yyyy-mm-dd'))
                                            ->setDesactiver(0)
                                            ->setLib_compte($_POST["carte" . $i])
                                            ->setSolde(0);
                                    $map_compte->save($compte);
                                    $prix = $_POST["prix" . $i];
                                    $carte->setCode_cat($_POST["carte" . $i])
                                            ->setCode_membre($membre)
                                            ->setMont_carte($prix)
                                            ->setDate_demande($date->toString('yyyy-mm-dd'))
                                            ->setLivrer(0)
                                            ->setCode_Compte($code_compte)
                                            ->setImprimer(0)
                                            ->setCardPrintedDate('')
                                            ->setCardPrintedIDDate(0)
                                            ->setId_utilisateur($user->id_utilisateur);
                                    $t_carte->insert($carte->toArray());
                                } else {
                                    if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
                                        $prix = $_POST["prix" . $i];
                                        $carte->setCode_cat($_POST["carte" . $i])
                                                ->setCode_membre($membre)
                                                ->setMont_carte($prix)
                                                ->setDate_demande($date->toString('yyyy-mm-dd'))
                                                ->setLivrer(0)
                                                ->setImprimer(0)
                                                ->setCardPrintedDate('')
                                                ->setCardPrintedIDDate(0)
                                                ->setCode_Compte($code_compte)
                                                ->setId_utilisateur($user->id_utilisateur);
                                        $t_carte->insert($carte->toArray());
                                    } else {
                                        $db->rollBack();
                                        $this->view->data = 'La carte ' . $code_cat . ' a deje ete imprime pour ce membre !!!';
                                        return;
                                    }
                                }
                            }
                            $mapper = new Application_Model_EuOperationMapper();
                            $compteur = $mapper->findConuter() + 1;
                            Util_Utils::addOperation($compteur, $membre, null, $montant, null, 'Frais de CPS', 'CPS', $date->toString('yyyy-mm-dd'), $date->toString('hh:mm:ss'), $user->id_utilisateur);
                            $db->commit();
                            $this->view->data = true;
                            return;
                        } else {
                            $db->rollBack();
                            $this->view->data = 'Le montant doit etre egal e la somme des prix des cartes!!!';
                            return;
                        }
                    }
                } else {
                    $db->rollback();
                    $this->view->data = "Vous devez souscrire e la licence de 10000 avant la demande de cartes";
                    return;
                }
            } catch (Exception $e) {
                $db->rollback();
                $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
            }
        }
    }

    public function traiterAction() {
        $code = $_GET['code'];
		$date = $_GET['date'];
		if($date!=''){
		   $date1 = explode("/", $date);
           $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
		}   
        $carte = new Application_Model_EuCartes();
        $t_carte = new Application_Model_DbTable_EuCartes();
        $date = Zend_Date::now();
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            if ($code != '') {
                $rows = $t_carte->find($code);
                if (count($rows) > 0) {
                    $row = $rows->current();
                    $carte->exchangeArray($row);
                    $carte->setLivrer(1)
                            ->setDate_livraison($dated);
                    $t_carte->update($carte->toArray(), array('id_demande = ?' => $carte->getId_demande()));
                    $db->commit();
                    $this->view->data = true;
                } else {
                    $this->view->data = 'Cette demande n\'existe pas!!!';
                    return;
                }
            } else {
                $this->view->data = 'Cette demande n\'existe pas!!!';
                return;
            }
        } catch (Exception $e) {
            $db->rollback();
            $this->view->data = $e->getMessage() . '->' . $e->getTraceAsString();
        }
    }

}

?>
