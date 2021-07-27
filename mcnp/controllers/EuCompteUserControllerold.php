<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
class EuCompteUserController extends Zend_Controller_Action {

    //put your code here
    public function init() {
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
        
        if ($group != "") {       
		    $menu = "<li><a href=\" /eu-compte-user/new \"  style=\"font-size:9px\">Nouveau</a></li>".
			        "<li><a href=\" /eu-compte-user/index\" style=\"font-size:9px\">Liste des comptes</a></li>";   	   
        } 
        $this->view->placeholder("menu")->set($menu);
		
	}

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
           $this->_redirect('login');		
        } else {
           $user = $auth->getIdentity();
           $group = $user->code_groupe;
           if ($group != 'agregat' && $group != 'detentrice' && $group != 'surveillance' && $group != 'executante' && $group != 'nn' && $group != 'cnp' && $group != 'fn' && $group != 'FGnn' && $group != 'fgnb' && $group != 'd_fgcnp' && $group != 'fgnr'
		   && $group != 'smc' && $group != 'reglementation' && $group != 'controlefn' && $group != 'protection' && $group != 'acnevtpsvsbps' && $group != 'acnevtpsvstps' && $group != 'acnevpbfvstps'
		   && $group != 'enrolement' && $group != 'mise_chaine' && $group != 'serviceapa' && $group != 'smcipn' && $group != 'audit' && $group != 'alerte' && $group != 'assurance'
		   && $group != 'servicebnp' && $group != 'domiciliation' && $group != 'collecte' && $group == 'repartition' && $group == 'mise_chainepmose' && $group == 'mise_chainepmd' && $group == 'mise_chainepms' && $group == 'mise_chainepmex' && $group == 'mise_chainepmpbf' && $group == 'mise_chainepmoe' && $group == 'mise_chainepmpose' && $group == 'mise_chainepmkr' && $group == 'mise_chainepmpoe' && $group == 'scmfilierepmpoe' && $group == 'scmfilierepmpose' && $group == 'sqmaxui' && $group == 'cmit' && $group == 'cacb' && $group == 'cscoe' && $group == 'caipc' && $group == 'capu'
		   && $group == 'annulationbnp' && $group == 'destructionbnp' && $group == 'filiere' && $group == 'scmacnev' && $group == 'technopole' && $group == 'productiong' && $group == 'productionsg' && $group == 'productiond' && $group == 'transformationg' && $group == 'transformationsg' && $group == 'transformationd'
		   && $group == 'distributiong' && $group == 'distributionsg' && $group == 'distributiond' || $group == 'tegcppbf' && $group == 'tegcp' && $group == 'tegcsc' && $group == 'ti' && $group == 'tpn' && $group == 'tesmcipnp' && $group == 'tesmcipnwi' && $group != 'paraenro'
		   && $group == 'detentrice_pays' && $group == 'surveillance_pays' && $group == 'executante_pays'
		   && $group == 'detentrice_region' && $group == 'surveillance_region' && $group == 'executante_region'
		   && $group == 'detentrice_secteur' && $group == 'surveillance_secteur' && $group == 'executante_secteur'
		   && $group == 'detentrice_agence' && $group == 'surveillance_agence' && $group == 'executante_agence'
		   && $group != 'mise_chainep' && $group != 'mise_chainer' && $group != 'mise_chaines' && $group != 'mise_chainea') {
           $this->view->user = $user;
           return $this->_redirect('index2');
        }
           $this->view->user = $user;
        }
    }

	

    public function indexAction() {
	       $this->view->jQuery()->enable();
           $this->view->jQuery()->uiEnable(); 
    }

	
    public function enrolementAction() {
      
  
    }

	
    public function listecarteAction() {
      
  
    }

	
    public function listebnpAction() {
    

    }
    
	
	
    public function paysAction() {
	    $g = array();
	    $tab = new Application_Model_DbTable_EuPays();
        $sel = $tab->select();
        $sel->order('libelle_pays asc');
        $group = $tab->fetchAll($sel);
        $i = 0;
        foreach ($group as $value) {
           $g[$i][0] = $value->id_pays;
		   $g[$i][1] = ucfirst(utf8_encode($value->libelle_pays));
           $i++;       
        }          
	    $this->view->data = $g;   
    }
	
	public function cantonAction() {
	    $g = array();
	    $tab = new Application_Model_DbTable_EuCanton();
        $sel = $tab->select();
        $sel->order('nom_canton asc');
        $group = $tab->fetchAll($sel);
        $i = 0;
        foreach ($group as $value) {
          $g[$i][0] = $value->id_canton;
		  $g[$i][1] = ucfirst(utf8_encode($value->nom_canton));
          $i++;       
        }          
	    $this->view->data = $g;   
    }
	
	
	
   
   
   public function agenceAction() {
    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
    $user = $auth->getIdentity();
	$groupe_create = $user->code_groupe_create;
    $g = array();
    $tab = new Application_Model_DbTable_EuAgence();
    $sel = $tab->select();
    $sel->order('libelle_agence asc');
	
	/*
	if($groupe_create == 'surveillance_agence' || $groupe_create == 'detentrice_agence' || $groupe_create == 'executante_agence') {
	    $sel->where('type_gac like ?','agence');
	} else if($groupe_create == 'surveillance_secteur' || $groupe_create == 'detentrice_secteur' || $groupe_create == 'executante_secteur') {
	    $sel->where('type_gac in (?)',array('secteur','agence'));
	} else if($groupe_create == 'surveillance_region' || $groupe_create == 'detentrice_region' || $groupe_create == 'executante_region') {
	    $sel->where('type_gac in (?)',array('region','secteur'));
	} else if($groupe_create == 'surveillance_pays' || $groupe_create == 'detentrice_pays' || $groupe_create == 'executante_pays') {
	    $sel->where('type_gac in (?)',array('pays','region'));
	}	  
	else {
	    $sel->where('type_gac in (?)',array('source','monde','zone','pays'));
	} 
	 */
	 
	$agences = $tab->fetchAll($sel);
    $i = 0;
    foreach ($agences as $value) {
        $g[$i][0] = $value->code_agence;
        $g[$i][1] = ucfirst(utf8_encode($value->libelle_agence));
        $i++;       
    }          
	$this->view->data = $g;
   }
   
   
   
    public function agence1Action() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
	    $code_acteur = $user->code_acteur;
	    $tab_acteur = new Application_Model_DbTable_EuActeur();
		$selection = $tab_acteur->select();
		$selection->where('code_acteur like ?',$code_acteur);
		$resultSet = $tab_acteur->fetchAll($selection);
		$row = $resultSet->current();
	    if(($row->type_acteur == 'gac_surveillance') && ($row->code_activite == 'detaillant')) {
		  $gac_mapper = new Application_Model_EuGacMapper();
          $gac = new Application_Model_EuGac();
		  $findgac = $gac_mapper->find($code_acteur,$gac);
		}
	    $g = array();
	    $tab = new Application_Model_DbTable_EuAgence();
        $sel = $tab->select();
        $sel->order('libelle_agence asc');
		
		if( 
		  ($row->type_acteur == 'gac_surveillance') && ($row->code_activite == 'grossiste')
		  || ($row->type_acteur == 'gac_surveillance') && ($row->code_activite == 'semi-grossiste')
		  ) {
		   $sel->where('code_gac_create like ?',$code_acteur);
		} elseif(($row->type_acteur == 'gac_surveillance') && ($row->code_activite == 'source')) {
		    $sel->where('code_gac_create like ?',$code_acteur);
		    $sel->orwhere('code_gac_create  is  null');
		} elseif(($row->type_acteur == 'gac_surveillance') && ($row->code_activite == 'detaillant')) {
		    $gac_mapper = new Application_Model_EuGacMapper();
            $gac = new Application_Model_EuGac();
		    $findgac = $gac_mapper->find($code_acteur,$gac);
			$sel->where('code_agence like ?',$gac->getCode_agence());
			$sel->orwhere('code_gac_create like ?',$code_acteur);
		} else {
		    $sel->where('code_gac_create like ?',$row->code_gac_chaine);
		}
        $group = $tab->fetchAll($sel);
        $i = 0;
        foreach ($group as $value) {
              $g[$i][0] = $value->code_agence;
              $g[$i][1] = ucfirst($value->libelle_agence);
              $i++;       
        }          
	    $this->view->data = $g;   
    }
	
	
	//function permettant d'afficher les comptes utilisateurs
    public function groupeAction()   {
	
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_group = $user->code_groupe;
		$id_filiere = $user->id_filiere;
        $g = array();
        $tab = new Application_Model_DbTable_EuUserGroup();
		$gac_mapper = new Application_Model_EuGacMapper();
		$acteur = new Application_Model_EuActeur();
		$find_kr = $acteur->findByKr($user->code_membre);
		$find_ex = $acteur->findByEx($user->code_membre);
		$find_sur = $acteur->findBySur($user->code_membre);
		$find_d = $acteur->findByD($user->code_membre);
		
		$find_exa = $acteur->findByExA($user->code_membre);
		$find_sura = $acteur->findBySurA($user->code_membre);
		$find_da = $acteur->findByDA($user->code_membre);
		
		$find_cmfh = $acteur->findByCmfh($user->code_membre);
        
		$sel = $tab->select();
        $sel->order('libelle_groupe asc');
        $group = $tab->fetchAll($sel);
        $i = 0;
        if ($code_group == 'agregat') {
                $greg = array('paraenro','cm','gacd','admin_site');
				foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
					
				}	
        } 
		elseif ($code_group == 'admin_site')  {
		        $greg = array('espace_kacm','espace_cmfh','espace_caps','espace_capa','espace_bps_ei','espace_bps_gp','espace_traite','espace_gp_mf107','espace_gp_mf11000','espace_gp_redemare','espace_gp_mcnp','espace_zppe','espace_tc_pp','espace_tc_pm','espace_tr_pm','espace_bourse','secretariat'); 
                foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
					
				}					
		}
		elseif ($code_group == 'detentrice')  {
		        $greg = array('gsnp_nn','gsn_nn','gsn_cnp','gsn_fn','gsn_smc','fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','enrolement','gacs','gacex','gacdm','detentrice_technopole','agrement_technopole','tableau_bord','rpgr_nonconso','ir_nonconso','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','parametre','escompte','compensation','mprg'); 
                foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
					
				}					
		}
		elseif ($code_group == 'detentrice_monde')  {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','enrolement','gacsm','gacexm','gacdz','detentrice_technopole','agrement_technopole','tableau_bord','rpgr_nonconso','ir_nonconso','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','escompte','compensation','mprg');            
                foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
				}					
		} 
		elseif ($code_group == 'detentrice_zone')  {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','enrolement','gacsz','gacexz','gacdp','detentrice_technopole','agrement_technopole','tableau_bord','rpgr_nonconso','ir_nonconso','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','escompte','compensation','mprg');            
                foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
					
				}						
		}
		elseif ($code_group == 'detentrice_pays')  {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','paraenro','enrolement','gacsp','gacexp','gacdregion','detentrice_technopole','agrement_technopole','tableau_bord','rpgr_nonconso','ir_nonconso','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','escompte','compensation','mprg');            
                foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
				}				
		}
		elseif ($code_group == 'detentrice_region')  {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','enrolement','gacsregion','gacexregion','gacdsecteur','detentrice_technopole','agrement_technopole','tableau_bord','rpgr_nonconso','ir_nonconso','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');            
                foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
					
				}				
				
		}
		elseif ($code_group == 'detentrice_secteur')  {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','enrolement','gacssecteur','gacexsecteur','gacdagence','detentrice_technopole','agrement_technopole','tableau_bord','rpgr_nonconso','ir_nonconso','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');            
                foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
					
				}				
				
		} elseif ($code_group == 'detentrice_agence')  {
                $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','enrolement','gacsagence','gacexagence','detentrice_technopole','agrement_technopole','tableau_bord','rpgr_nonconso','ir_nonconso','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');            
                foreach ($group as $value) {
                    if (in_array($value->code_groupe, $greg)) {
                       $g[$i][0] = $value->code_groupe;
                       $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                       $i++;
                    }
					
			    }				
				
		} elseif ($code_group == 'surveillance') {
		        $greg = array('SIF','fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','surveillance_filiere','agrement_filiere','domiciliation','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti_nn','fn_ti_nr','fn_ti_nb','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','collecte','repartition','escompte','compensation','mprg');
			    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
			    }	
        } elseif ($code_group == 'surveillance_monde') {
		        $greg = array('SIF','fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','surveillance_filiere','agrement_filiere','domiciliation','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti_nn','fn_ti_nr','fn_ti_nb','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','collecte','repartition','escompte','compensation','mprg');
			    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
			    }	
        }
		elseif ($code_group == 'surveillance_zone') {
		        $greg = array('SIF','fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','surveillance_filiere','agrement_filiere','domiciliation','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti_nn','fn_ti_nr','fn_ti_nb','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','collecte','repartition','escompte','compensation','mprg');
			    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
			    }	
        }
		elseif ($code_group == 'surveillance_pays') {
		        $greg = array('SIF','fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','surveillance_filiere','agrement_filiere','domiciliation','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti_nn','fn_ti_nr','fn_ti_nb','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','collecte','repartition','escompte','compensation','mprg');
			    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
			    }	
        } elseif ($code_group == 'surveillance_region') {
		        $greg = array('SIF','fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','surveillance_filiere','agrement_filiere','domiciliation','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti_nn','fn_ti_nr','fn_ti_nb','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','collecte','repartition');
			    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
			    }	
        } elseif ($code_group == 'surveillance_secteur') {
		        $greg = array('SIF','fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','surveillance_filiere','agrement_filiere','domiciliation','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti_nn','fn_ti_nr','fn_ti_nb','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','collecte','repartition');
			    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
			    }	
        } elseif ($code_group == 'surveillance_agence') {
		        $greg = array('SIF','fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','surveillance_filiere','agrement_filiere','domiciliation','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti_nn','fn_ti_nr','fn_ti_nb','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','collecte','repartition');
			    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
			    }	
        }
		elseif  ($code_group == 'executante') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','executante_acnev','agrement_acnev','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','escompte','compensation','mprg');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } 
		elseif  ($code_group == 'executante_monde') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','escompte','compensation','mprg','executante_acnev','agrement_acnev');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif  ($code_group == 'executante_zone') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','escompte','compensation','mprg','executante_acnev','agrement_acnev');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        }
		elseif  ($code_group == 'executante_pays') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','escompte','compensation','mprg','executante_acnev','agrement_acnev');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif  ($code_group == 'executante_region') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','executante_acnev','agrement_acnev');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif  ($code_group == 'executante_secteur') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','executante_acnev','agrement_acnev');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif  ($code_group == 'executante_agence') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','executante_acnev','agrement_acnev');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        }
		
		elseif  ($code_group == 'detentrice_filiere') {
                $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','mise_chaine','enrolement');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        } 
		
		elseif  ($code_group == 'surveillance_filiere') {
                $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','mise_chaine','enrolement');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        }
		
		elseif  ($code_group == 'surveillance_technopole') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } 
		
		elseif  ($code_group == 'detentrice_technopole') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        }
		
		elseif  ($code_group == 'executante_acnev') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi','scmpmapbf');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                             $g[$i][0] = $value->code_groupe;
                             $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                             $i++;
					    }
					}
        }  
		
		elseif ($code_group == 'pbf_grossiste') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif  ($code_group == 'pbf_semi_grossiste') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}
        } elseif ($code_group == 'pbf_detaillant') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','nn_tegcp_pbf','cnp_tegcp_pbf','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif ($code_group == 'oe_grossiste') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif  ($code_group == 'oe_semi_grossiste') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}
        } elseif ($code_group == 'oe_detaillant') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        } elseif ($code_group == 'ose_grossiste') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif ($code_group == 'ose_semi_grossiste') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif ($code_group == 'ose_detaillant') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_fn','fg_smc','e_nn','e_cnp','e_fn','e_smc','tableau_bord','cnp_tegcp','cnp_tegcsc','fn_ti','smc_tpn','smc_tesmcipnp','smc_tesmcipnwi');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}
						
        } elseif (($code_group == 'personne_physique') && ($find_cmfh != false)) {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_smc','e_nn','e_cnp','e_smc','tableau_bord','domiciliation');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif ($code_group == 'personne_physique') {
                    $greg = array('fgp_nn','fg_nn','fg_cnp','fg_smc','e_nn','e_cnp','e_smc','tableau_bord','domiciliation');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
					    }
					}	
        } elseif ($code_group == 'enrolement') {
                    $greg = array('cm','caps');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        } elseif ($code_group == 'mise_chaine') {
                    $greg = array('mise_chainepmoe','mise_chainepmose','mise_chainepmpoe','mise_chainepmpose','mise_chainepmmaison','mise_chainepmpbf','paraenro','gacdagence','gacdsecteur','gacdregion','gacdp','gacdz','gacdm');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        }
		
		/*
		elseif ($code_group == 'mise_chainem') {
                    $greg = array('mise_chainepmoe','mise_chainepmose','mise_chainepmpoe','mise_chainepmpose',
					'mise_chainepmmaison','mise_chainepmpbf','paraenro');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        } elseif ($code_group == 'mise_chainez') {
                    $greg = array('mise_chainepmoe','mise_chainepmose','mise_chainepmpoe','mise_chainepmpose',
					'mise_chainepmmaison','mise_chainepmpbf','paraenro');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        } elseif ($code_group == 'mise_chainep') {
                    $greg = array('mise_chainepmoe','mise_chainepmose','mise_chainepmpoe','mise_chainepmpose',
					'mise_chainepmmaison','mise_chainepmpbf','paraenro','gacdregion');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        } elseif ($code_group == 'mise_chainer') {
                    $greg = array('mise_chainepmoe','mise_chainepmose','mise_chainepmpoe',
					'mise_chainepmpose','mise_chainepmmaison','mise_chainepmpbf','paraenro','gacdsecteur');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        }  elseif ($code_group == 'mise_chaines') {
                    $greg = array('mise_chainepmoe','mise_chainepmose','mise_chainepmpoe',
					'mise_chainepmpose','mise_chainepmmaison','mise_chainepmpbf','paraenro','gacdagence');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        } elseif ($code_group == 'mise_chainea') {
                    $greg = array('mise_chainepmoe','mise_chainepmose','mise_chainepmpoe','mise_chainepmpose','mise_chainepmmaison','mise_chainepmpbf','paraenro');
                    foreach ($group as $value) { 
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
					    }
					}	
        }
        */
		
		elseif ($code_group == 'mise_chainepmoe') {
                    $greg = array('scmpmaoe');
                    foreach ($group as $value) {  
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					}	
        }   elseif ($code_group == 'mise_chainepmose') {
                    $greg = array('scmpmaose');
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					}	
        }   elseif ($code_group == 'mise_chainepmpose') {
                    $greg = array('scmpmaose');
					foreach ($group as $value) {  
                        if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
                        }
					}	
        }   elseif ($code_group == 'mise_chainepmpoe') {
                    $greg = array('scmpmaoe');
					foreach ($group as $value) {			   
                        if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					}	
        }   elseif ($code_group == 'mise_chainepmmaison') {
                    $greg = array('scmpmam');
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                            $g[$i][0] = $value->code_groupe;
                            $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                            $i++;
                        }
					}	
        }   elseif ($code_group == 'mise_chainepmpbf') {
                    $greg = array('scmpmapbf');
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					}
					
        }   elseif ($code_group == 'fgp_nn') {
			        //if($user->code_groupe_create == "personne_physique") {
					//$greg = array('fgp_nn_achatpppm','fgp_nn_achatpp'); 
					//} 
					//else {
					    $tab2 = new Application_Model_DbTable_EuUserGroup();
					    $sel2 = $tab2->select();
					    $sel2->where('code_groupe_parent = ?', $code_group);
					    $sel2->order('libelle_groupe asc');
					    $group2 = $tab2->fetchAll($sel2);
					    $j = 0;
					    foreach ($group2 as $value2) {
						   $greg[$j] = $value2->code_groupe;
						   $j++;
					    }
					//}
					foreach ($group as $value) {
					    if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					}	
			
			
			} elseif ($code_group == 'fg_nn') {
					//if($user->code_groupe_create == "personne_physique"){
						//$greg = array('fg_nn_achatpppm','fg_nn_achatpp'); 
					//} 
					//else {
					$tab2 = new Application_Model_DbTable_EuUserGroup();
					$sel2 = $tab2->select();
					$sel2->where('code_groupe_parent = ?', $code_group);
					$sel2->order('libelle_groupe asc');
					$group2 = $tab2->fetchAll($sel2);
					$j = 0;
					foreach ($group2 as $value2) {
						$greg[$j] = $value2->code_groupe;
						$j++;
					}
					//}
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					}
                } elseif ($code_group == 'e_nn') {
					if($user->code_groupe_create == "personne_physique"){
						$greg = array('e_nn_achatpppm','e_nn_achatpp'); 
					} else if($user->code_groupe_create != "personne_physique"){
						$greg = array('e_nn_achatpppm','e_nn_achatpm','e_nn_reapropm','e_nn_rscaps'); 
					} else {
					$tab2 = new Application_Model_DbTable_EuUserGroup();
					$sel2 = $tab2->select();
					$sel2->where('code_groupe_parent = ?', $code_group);
					$sel2->order('libelle_groupe asc');
					$group2 = $tab2->fetchAll($sel2);
					$j = 0;
					foreach ($group2 as $value2) {
						$greg[$j] = $value2->code_groupe;
						$j++;
					}
					}
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					}	

            } elseif ($code_group == 'fg_cnp') {
					if($user->code_groupe_create == "personne_physique") {
						$greg = array('fg_cnp_consopp'); 
					} else {
					$tab2 = new Application_Model_DbTable_EuUserGroup();
					$sel2 = $tab2->select();
					$sel2->where('code_groupe_parent = ?', $code_group);
					$sel2->order('libelle_groupe asc');
					$group2 = $tab2->fetchAll($sel2);
					$j = 0;
					foreach ($group2 as $value2) {
						$greg[$j] = $value2->code_groupe;
						$j++;
					}
					}
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					}	
                } elseif ($code_group == 'e_cnp') {
					if($user->code_groupe_create == "personne_physique"){
						$greg = array('e_cnp_consopp'); 
					} else if($user->code_groupe_create != "personne_physique"){
						$greg = array('e_cnp_consopm','e_cnp_reapropm'); 
					} else{
					$tab2 = new Application_Model_DbTable_EuUserGroup();
					$sel2 = $tab2->select();
					$sel2->where('code_groupe_parent = ?', $code_group);
					$sel2->order('libelle_groupe asc');
					$group2 = $tab2->fetchAll($sel2);
					$j = 0;
					foreach ($group2 as $value2) {
						$greg[$j] = $value2->code_groupe;
						$j++;
					}
					}
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                           $g[$i][0] = $value->code_groupe;
                           $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                           $i++;
                        }
					} 

            } elseif ($code_group == 'fg_smc' || $code_group == 'fg_fn' || $code_group == 'e_smc' || $code_group == 'e_fn') {
					$tab2 = new Application_Model_DbTable_EuUserGroup();
					$sel2 = $tab2->select();
					$sel2->where('code_groupe_parent = ?', $code_group);
					$sel2->order('libelle_groupe asc');
					$group2 = $tab2->fetchAll($sel2);
					$j = 0;
					foreach ($group2 as $value2) {
						if(strripos($value2->code_groupe, 'creation') === false) {
						  $greg[$j] = $value2->code_groupe;
						  $j++;
					    }
					}
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                          $g[$i][0] = $value->code_groupe;
                          $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                          $i++;
                        }
					}	

			}   else {
					$tab2 = new Application_Model_DbTable_EuUserGroup();
					$sel2 = $tab2->select();
					$sel2->where('code_groupe_parent = ?', $code_group);
					$sel2->order('libelle_groupe asc');
					$group2 = $tab2->fetchAll($sel2);
					$j = 0;
					foreach ($group2 as $value2) {
						$greg[$j] = $value2->code_groupe;
						$j++;
					}
					foreach ($group as $value) {
                        if (in_array($value->code_groupe, $greg)) {
                        $g[$i][0] = $value->code_groupe;
                        $g[$i][1] = ucfirst(utf8_encode($value->libelle_groupe));
                        $i++;
					    }
					}
				}
        $this->view->data = $g;
    }
	
	
	
	public function filiereAction() {
        $filiere = new Application_Model_DbTable_EuFiliere();
        $filieres = $filiere->fetchAll();
        if (count($filieres) >= 1) {
            $data = array();
            for ($i = 0; $i < count($filieres); $i++) {
                $value = $filieres[$i];
                $data[$i][0] = $value->id_filiere;
                $data[$i][1] = $value->nom_filiere;
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	
	
	public function newAction()   {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_acteur = $user->code_acteur;
        $groupe = $user->code_groupe;
		$this->view->code_groupe = $user->code_groupe;
		$this->view->code_groupe_create = $user->code_groupe_create;
        $code_zone = $user->code_zone;
	    $code_acteur = $user->code_acteur;
	    $code_gac_filiere = $user->code_gac_filiere;
		$code_groupe_create = $user->code_groupe_create;
		$acteur = new Application_Model_EuActeur();
		$m_acteur = new Application_Model_EuActeurMapper();
		
		//$find_cmfh = $acteur->findByCmfh($user->code_membre);
		//$t_prk   = new Application_Model_DbTable_EuPrk();
		//$select = $t_prk->select();
		//$select->distinct();
		//$select->from(array('eu_prk'),'valeur');
        //$prks = $t_prk->fetchAll($select);
		//$this->view->prks = $prks;
		
        if ($this->getRequest()->isPost()) {
            $pwd = $this->_request->getPost("pwd");
	        $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_creation = clone $date_id;
            $pwd1 = $this->_request->getPost("pwd1");
            $code_groupe = $this->_request->getPost("groupe");
            if(isset($_POST['code_membre'])) {
              $code_membre = $this->_request->getPost("code_membre");
			if(substr($code_membre, -1) == "P") {
			    $tab5 = new Application_Model_DbTable_EuMembre();
				$sel5 = $tab5->select();
				$sel5->where('code_membre = ?', $code_membre);
				$membre5 = $tab5->fetchAll($sel5);
			} else {
				$tab5 = new Application_Model_DbTable_EuMembreMorale();
				$sel5 = $tab5->select();
			    $sel5->where('code_membre_morale = ?', $code_membre);
				$membre5 = $tab5->fetchAll($sel5);
			}
			////////////////////////////////////////////////////
            } else {
                $code_membre = null;
            }
          
	    $id_pays = $this->_request->getPost("pays");
		$id_canton = $this->_request->getPost("canton");
		
		$type_acteur = "";
		$code_activite = "";
		
        if(isset($_POST['agence'])) {
           $code_agence = $_POST['agence']; 
        } else {
           $code_agence = null;
        }
		
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Mise � jour de la table eu_utilisateur
            $userin = new Application_Model_EuUtilisateur();
            $mapper = new Application_Model_EuUtilisateurMapper();
		    $gm = new Application_Model_EuGacMapper();
		    $gac = new Application_Model_EuGac();
			
			$canton = new Application_Model_EuCanton();
            $mapper_canton = new Application_Model_EuCantonMapper();
			$findcanton = $mapper_canton->find($id_canton,$canton);
			
			$prefecture = new Application_Model_EuPrefecture();
            $mapper_prefecture = new Application_Model_EuPrefectureMapper();
			$findprefecture = $mapper_prefecture->find($canton->id_prefecture,$prefecture);
			$id_prefecture = $prefecture->id_prefecture;
			
			$region = new Application_Model_EuRegion();
            $mapper_region = new Application_Model_EuRegionMapper();
			$findregion = $mapper_region->find($prefecture->id_region,$region);
			$id_region = $region->id_region;
			
			$pays = new Application_Model_EuPays();
            $mapper_pays = new Application_Model_EuPaysMapper();
			$findpays = $mapper_pays->find($region->id_pays,$pays);
			$id_pays = $pays->id_pays;
			
			$zone = new Application_Model_EuZone();
            $mapper_zone = new Application_Model_EuZoneMapper();
			$findzone = $mapper_zone->find($pays->code_zone,$zone);
			$code_zone = $zone->code_zone;
			
			
            $find_user = $mapper->findLogin($this->_request->getPost("login"));			
			if((trim($code_groupe) == 'filiere') || (trim($code_groupe) == 'scmacnev') || (trim($code_groupe) == 'technopole')) {
			   $nbre_chaine = $mapper->findcountchaine($code_groupe,$user->id_utilisateur,$_POST['filiere']);
			   $nbre_user = 0;
			} else {
               $nbre_chaine = 0;
			   $nbre_user = $mapper->findcountuser($code_groupe,$user->id_utilisateur);
			}			
			$compteuruser = Util_Utils::getParametre('user','compteur');
			$compteursourceuser = Util_Utils::getParametre('usersource','compteur');
			$compteurchaine = Util_Utils::getParametre('userchaine','compteur');
			$gsn = substr($code_groupe,0,4);
			$fg  = substr($code_groupe,0,3);
			
            if ($find_user != false) {
                    $message = 'Ce login existe déjà.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } 
			
			elseif ($pwd != $pwd1) {
                    $message = 'Erreur de confirmation du mot de passe.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } 
			
			elseif (stripos($this->_request->getPost("login"), " ") !== false) {
                    $message = "Le Login ne doit pas contenir d'espace";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            }   
			
			/*elseif((trim($gsn) == 'gsnp' || trim($fg) == 'fgp') && ($nbre_user >= $compteursourceuser)) {
					$message = "Impossible de créer ce compte utilisateur : son nombre de création a atteint le paramètre compteur user defini source";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            }*/
			
			/*
			elseif(($code_groupe == 'filiere' || $code_groupe == 'scmacnev' || $code_groupe == 'technopole') && ($nbre_chaine >= $compteurchaine)) {
					$message = "Impossible de créer ce compte utilisateur : son nombre de création a atteint le paramètre compteur user defini chaine";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } */  
			
			elseif(($code_groupe == 'detentrice_technopole' || $code_groupe == 'surveillance_filiere' || $code_groupe == 'executante_acnev' || $code_groupe == 'agrement_filiere' || $code_groupe == 'agrement_technopole' || $code_groupe == 'agrement_acnev') 
			         && ($_POST['code_membre'] =='')) {
					$message = "Vous devez saisir le code membre personne physique representant";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            }
			/*
			elseif($nbre_user >= $compteuruser) {
                    $message = "Impossible de créer ce compte utilisateur : son nombre de création a atteint le paramètre compteur user defini";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            }*/
			
			elseif($code_membre != null && count($membre5) == 0) {
                    $message = "Impossible de créer ce compte utilisateur : le Code Membre n'est pas valide";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } 
			else    {
			        //insertion dans la table eu_utilisateur
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($this->_request->getPost("prenom"));
                    $userin->setNom_utilisateur($this->_request->getPost("nom"));
                    $userin->setLogin(trim($this->_request->getPost("login")));
                    $userin->setPwd(md5($pwd));
                    $userin->setDescription($this->_request->getPost("desc"));
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    $userin->setCode_groupe($code_groupe);
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
				    		 
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
					
                    if(isset($_POST['filiere'])) {
                        $userin->setId_filiere($_POST['filiere']);
				    } else {
                        $userin->setId_filiere(null);
				    }
					
				    $userin->setCode_acteur($code_acteur);	   
				    $userin->setCode_gac_filiere($code_gac_filiere);
				    $userin->setCode_groupe_create($code_groupe_create);
               
                    if($code_groupe_create == 'personne_physique' || $code_groupe == 'mise_chaine'  || $code_groupe == 'mise_chainep' || $code_groupe == 'mise_chainer'
					|| $code_groupe == 'mise_chaines' || $code_groupe == 'mise_chainea' || $code_groupe == 'enrolement' || $code_groupe == 'gacd'
					|| $code_groupe == 'gacs' || $code_groupe == 'gacex' || $code_groupe == 'gacdregion' || $code_groupe == 'gacsregion' || $code_groupe == 'gacexregion'
					|| $code_groupe == 'gacdsecteur' || $code_groupe == 'gacssecteur' || $code_groupe == 'gacexsecteur'
					|| $code_groupe == 'gacdagence' || $code_groupe == 'gacsagence' || $code_groupe == 'gacexagence'
					|| $code_groupe == 'cnp_tegcp') {
				       $userin->setCode_membre($user->code_membre);
				    } else {
                        if($_POST['code_membre'] =='') {    				   
		                    $userin->setCode_membre(null);
                        } else {
                            $userin->setCode_membre($_POST['code_membre']);
                        }
				    }
		            
					if($code_groupe == 'detentrice_technopole' || $code_groupe == 'surveillance_filiere' || $code_groupe == 'executante_acnev'
					  || $code_groupe == 'agrement_filiere' || $code_groupe == 'agrement_technopole' || $code_groupe == 'agrement_acnev') {
					   
					  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                      $date_idd = clone $date_id;
					  $t_acteur = new Application_Model_DbTable_EuActeur();
                      $c_acteur = new Application_Model_EuActeur();
					
					  $t_division = new Application_Model_DbTable_EuTeteDivision();
                      $c_division = new Application_Model_EuTeteDivision();
					  
					  if($code_groupe == 'detentrice_technopole') {
						$type_acteur = "TECHNOPOLE"; 
				      } elseif($code_groupe == 'surveillance_filiere') {
						$type_acteur = "FILIERE";
					  } elseif($code_groupe == 'executante_acnev') {
						$type_acteur = "ACNEV";
					  }
							
					  if($user->code_groupe == 'detentrice' || $user->code_groupe == 'surveillance' || $user->code_groupe == 'executante') {
						$code_activite = "SOURCE";
					  } elseif($user->code_groupe == 'detentrice_monde' || $user->code_groupe == 'surveillance_monde' || $user->code_groupe == 'executante_monde') {
						$code_activite = "MONDE";
					  } elseif($user->code_groupe == 'detentrice_zone' || $user->code_groupe == 'surveillance_zone' || $user->code_groupe == 'executante_zone') {
						$code_activite = "ZONE";
					  } elseif($user->code_groupe == 'detentrice_pays' || $user->code_groupe == 'surveillance_pays' || $user->code_groupe == 'executante_pays') {
						$code_activite = "PAYS";
					  } elseif($user->code_groupe == 'detentrice_region' || $user->code_groupe == 'surveillance_region' || $user->code_groupe == 'executante_region') {
						$code_activite = "REGION";
					  } elseif($user->code_groupe == 'detentrice_secteur' || $user->code_groupe == 'surveillance_secteur' || $user->code_groupe == 'executante_secteur') {
						$code_activite = "PREFECTURE";
					  } elseif($user->code_groupe == 'detentrice_agence' || $user->code_groupe == 'surveillance_agence' || $user->code_groupe == 'executante_agence') {
						$code_activite = "CANTON";
					  }
					  
					  	
					  /*
					  if($code_groupe == 'detentrice_technopole' || $code_groupe == 'surveillance_filiere' || $code_groupe == 'executante_acnev') {
						 $find_acteur = $acteur->findByActeur($_POST['code_membre']);
						 if ($find_acteur != false) {
                            $message = 'Ce compte membre personne physique est déjà associé à  un compte acteur : '.$_POST['code_membre'];
                            $this->view->message = $message;
                            $this->view->nom = $this->_request->getPost("nom");
                            $this->view->prenom = $this->_request->getPost("prenom");
                            $this->view->login = $this->_request->getPost("login");
                            return;
                         }
						
					  }
					  */
						
				      /*$rep_mapper = new Application_Model_EuRepresentationMapper();
                      $rep = new Application_Model_EuRepresentation();
				      $rep_table = new Application_Model_DbTable_EuRepresentation();
						
					  $findtablerep = $rep_table->find($_POST['code_membre'],$user->code_membre);
					  if(count($findtablerep) == 0) {
						$rep->setCode_membre_morale($user->code_membre)
                            ->setCode_membre($_POST['code_membre'])
                            ->setTitre('Representant')
						    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						    ->setId_utilisateur($user->id_utilisateur)
						    ->setEtat('outside');
					    $rep_mapper->save($rep);
					  }*/
						
					  $filiere =  new Application_Model_EuFiliere();
					  $map_filiere = new Application_Model_EuFiliereMapper();
					
					  if($code_groupe == 'detentrice_technopole' || $code_groupe == 'surveillance_filiere' || $code_groupe == 'executante_acnev') {
					    $find_filiere = $map_filiere->find($user->id_filiere,$filiere);
					  } else {
					    $find_filiere = $map_filiere->find($_POST['filiere'],$filiere);
					  }
						
					  if($code_groupe == 'executante_acnev' || $code_groupe == 'agrement_acnev') {
						 $table = new Application_Model_DbTable_EuActeur();
			             $select = $table->select();
			             $select->where('code_acteur like ?',$user->code_acteur);
			             $result = $table->fetchAll($select);
			             $findacteur = $result->current();
			             $code_gac_chaine = $findacteur->code_gac_chaine;
			             $selection = $table->select();
			             $selection->where('code_gac_chaine like ?',$code_gac_chaine);
			             $selection->where('type_acteur like ?','gac_surveillance');
			             $resultat = $table->fetchAll($selection);
			             $trouvacteursur = $resultat->current();
					     $code_acteur = $trouvacteursur->code_acteur;
					  }
						
					  $table = new Application_Model_DbTable_EuActeur();
                      $select = $table->select();
				      $select->where('code_acteur like ?', $code_acteur);
					  $resultSet = $table->fetchAll($select);
					  $ligneacteur = $resultSet->current();
				      $count = $c_acteur->findConuter() + 1;
					
					  if($code_groupe == 'detentrice_technopole' || $code_groupe == 'surveillance_filiere' || $code_groupe == 'executante_acnev') {
					
					    // insertion dans la table eu_acteur
						$find_acteur = $m_acteur->findByAdministrateur($user->code_membre,$type_acteur);
						if ($find_acteur == false) {
                              $c_acteur->setId_acteur($count)
                                       ->setCode_acteur(null)
								       ->setCode_division($filiere->getCode_division())
                                       ->setCode_membre($user->code_membre)
                                       ->setId_utilisateur($user->id_utilisateur)
                                       ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
								 
						      $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						      $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						      $c_acteur->setCode_zone_create($code_zone);
						      $c_acteur->setId_pays($id_pays);
						      $c_acteur->setId_region($id_region);
						      $c_acteur->setId_prefecture($id_prefecture);
						      $c_acteur->setId_canton($id_canton);
						      $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						      $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                              $c_acteur->setCode_activite($code_activite);
                              $c_acteur->setType_acteur($type_acteur);						
								 
                              $c_acteur->setCode_gac_chaine($code_acteur);
                              $t_acteur->insert($c_acteur->toArray());
                         }						
					}
                        
				    // insertion dans la table eu_tete_division
					$countd = $c_division->findConuter() + 1;
                    $c_division->setId_tete_division($countd)
                               ->setCode_acteur($user->code_acteur)
							   ->setCode_division($filiere->getCode_division())
							   ->setCode_agence($user->code_agence)
                               ->setCode_membre_morale($user->code_membre)
							   ->setCode_membre($_POST['code_membre'])
                               ->setId_utilisateur($user->id_utilisateur)
                               ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					
					 $c_division->setCode_source_create($ligneacteur->code_source_create);
					 $c_division->setCode_monde_create($ligneacteur->code_monde_create);
				     $c_division->setCode_zone_create($code_zone);
					 $c_division->setId_pays($id_pays);
					 $c_division->setId_region($id_region);
					 $c_division->setId_prefecture($id_prefecture);
					 $c_division->setId_canton($id_canton);
					 $c_division->setCode_secteur_create($ligneacteur->code_secteur_create);
					 $c_division->setCode_agence_create($ligneacteur->code_agence_create);
					 $c_division->setType_tete_division($type_acteur);
						
					 if($code_groupe == 'surveillance_filiere' || $code_groupe == 'detentrice_technopole' || $code_groupe == 'executante_acnev') {
					    $c_division->setId_filiere($user->id_filiere);
					 } else {
						$c_division->setId_filiere($_POST['filiere']);
					 }
					 $c_division->setCode_activite($code_activite);
					 $t_division->insert($c_division->toArray());
					}
					
                    $userin->setId_pays($id_pays);
                    $userin->setId_canton($id_canton);					
                    $mapper->save($userin);    
                        						
                    $db->commit();
                    return $this->_helper->redirector('index');
					}
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = 'Echec '.$exc->getMessage();
		            $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                }
          }
    }
	
	
	
	
	
    public function newoldAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_acteur = $user->code_acteur;
        $groupe = $user->code_groupe;
		$this->view->code_groupe = $user->code_groupe;
		$this->view->code_groupe_create = $user->code_groupe_create;
        $code_zone = $user->code_zone;
	    $code_acteur = $user->code_acteur;
	    $code_gac_filiere = $user->code_gac_filiere;
		$code_groupe_create = $user->code_groupe_create;
		$acteur = new Application_Model_EuActeur();
		//$find_cmfh = $acteur->findByCmfh($user->code_membre);
		
        if ($this->getRequest()->isPost()) {
            $pwd = $this->_request->getPost("pwd");
	        $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_creation = clone $date_id;
            $pwd1 = $this->_request->getPost("pwd1");
            $code_groupe = $this->_request->getPost("groupe");
            if(isset($_POST['code_membre'])) {
              $code_membre = $this->_request->getPost("code_membre");
			if(substr($code_membre, -1) == "P") {
			    $tab5 = new Application_Model_DbTable_EuMembre();
				$sel5 = $tab5->select();
				$sel5->where('code_membre = ?', $code_membre);
				$membre5 = $tab5->fetchAll($sel5);
			} else {
				$tab5 = new Application_Model_DbTable_EuMembreMorale();
				$sel5 = $tab5->select();
			    $sel5->where('code_membre_morale = ?', $code_membre);
				$membre5 = $tab5->fetchAll($sel5);
			}
			////////////////////////////////////////////////////
            } else {
                $code_membre = null;
            }
          
	    $id_pays = $this->_request->getPost("pays");
		$id_canton = $this->_request->getPost("canton");
		
        if(isset($_POST['agence'])) {
           $code_agence = $_POST['agence']; 
        } else {
           $code_agence = null;
        }
		
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //Mise � jour de la table eu_utilisateur
            $userin = new Application_Model_EuUtilisateur();
            $mapper = new Application_Model_EuUtilisateurMapper();
		    $gm = new Application_Model_EuGacMapper();
		    $gac = new Application_Model_EuGac();
			
			$canton = new Application_Model_EuCanton();
            $mapper_canton = new Application_Model_EuCantonMapper();
			$findcanton = $mapper_canton->find($id_canton,$canton);
			
			$prefecture = new Application_Model_EuPrefecture();
            $mapper_prefecture = new Application_Model_EuPrefectureMapper();
			$findprefecture = $mapper_prefecture->find($canton->id_prefecture,$prefecture);
			$id_prefecture = $prefecture->id_prefecture;
			
			$region = new Application_Model_EuRegion();
            $mapper_region = new Application_Model_EuRegionMapper();
			$findregion = $mapper_region->find($prefecture->id_region,$region);
			$id_region = $region->id_region;
			
			$pays = new Application_Model_EuPays();
            $mapper_pays = new Application_Model_EuPaysMapper();
			$findpays = $mapper_pays->find($region->id_pays,$pays);
			$id_pays = $pays->id_pays;
			
			$zone = new Application_Model_EuZone();
            $mapper_zone = new Application_Model_EuZoneMapper();
			$findzone = $mapper_zone->find($pays->code_zone,$zone);
			$code_zone = $zone->code_zone;
			
            $find_user = $mapper->findLogin($this->_request->getPost("login"));
						
			if((trim($code_groupe) == 'filiere') || (trim($code_groupe) == 'scmacnev') || (trim($code_groupe) == 'technopole')) {
			   $nbre_chaine = $mapper->findcountchaine($code_groupe,$user->id_utilisateur,$_POST['filiere']);
			   $nbre_user = 0;
			} else {
               $nbre_chaine = 0;
			   $nbre_user = $mapper->findcountuser($code_groupe,$user->id_utilisateur);
			}			
			$compteuruser = Util_Utils::getParametre('user','compteur');
			$compteursourceuser = Util_Utils::getParametre('usersource','compteur');
			$compteurchaine = Util_Utils::getParametre('userchaine','compteur');
			$gsn = substr($code_groupe,0,4);
			$fg  = substr($code_groupe,0,3);
			
            if ($find_user != false) {
                    $message = 'Ce login existe déjà.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } 
			
			elseif ($pwd != $pwd1) {
                    $message = 'Erreur de confirmation du mot de passe.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } 
			
			elseif (stripos($this->_request->getPost("login"), " ") !== false) {
                    $message = "Le Login ne doit pas contenir d'espace";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            }   
			
			/*elseif((trim($gsn) == 'gsnp' || trim($fg) == 'fgp') && ($nbre_user >= $compteursourceuser)) {
					$message = "Impossible de créer ce compte utilisateur : son nombre de création a atteint le paramètre compteur user defini source";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            }
			
			elseif(($code_groupe == 'filiere' || $code_groupe == 'scmacnev' || $code_groupe == 'technopole') && ($nbre_chaine >= $compteurchaine)) {
					$message = "Impossible de créer ce compte utilisateur : son nombre de création a atteint le paramètre compteur user defini chaine";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } */   
			
			elseif(($code_groupe == 'surveillance_filiere' || $code_groupe == 'detentrice_technopole' || $code_groupe == 'executante_acnev' || $code_groupe == 'agrement_filiere' || $code_groupe == 'agrement_technopole' || $code_groupe == 'agrement_acnev') 
			         && ($_POST['code_membre'] =='')) {
					$message = "Vous devez saisir le code membre personne physique representant";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            }
			
			/*elseif($nbre_user >= $compteuruser) {
                    $message = "Impossible de créer ce compte utilisateur : son nombre de création a atteint le paramètre compteur user defini";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            }*/
			
			elseif($code_membre != null && count($membre5) == 0) {
                    $message = "Impossible de créer ce compte utilisateur : le Code Membre n'est pas valide";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } 
			else    {
			        //insertion dans la table eu_utilisateur
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($this->_request->getPost("prenom"));
                    $userin->setNom_utilisateur($this->_request->getPost("nom"));
                    $userin->setLogin(trim($this->_request->getPost("login")));
                    $userin->setPwd(md5($pwd));
                    $userin->setDescription($this->_request->getPost("desc"));
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    $userin->setCode_groupe($code_groupe);
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
				    		 
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
					
                    if(isset($_POST['filiere'])) {
                        $userin->setId_filiere($_POST['filiere']);
				    } else {
                        $userin->setId_filiere(null);
				    }
					
				    $userin->setCode_acteur($code_acteur);	   
				    $userin->setCode_gac_filiere($code_gac_filiere);
				    $userin->setCode_groupe_create($code_groupe_create);
               
                    if($code_groupe_create == 'personne_physique' || $code_groupe == 'mise_chaine'  || $code_groupe == 'mise_chainep' || $code_groupe == 'mise_chainer'
					|| $code_groupe == 'mise_chaines' || $code_groupe == 'mise_chainea' || $code_groupe == 'enrolement' || $code_groupe == 'gacd'
					|| $code_groupe == 'gacs' || $code_groupe == 'gacex' || $code_groupe == 'gacdregion' || $code_groupe == 'gacsregion' || $code_groupe == 'gacexregion'
					|| $code_groupe == 'gacdsecteur' || $code_groupe == 'gacssecteur' || $code_groupe == 'gacexsecteur'
					|| $code_groupe == 'gacdagence' || $code_groupe == 'gacsagence' || $code_groupe == 'gacexagence'
					) {
				       $userin->setCode_membre($user->code_membre);
				    } else {
                        if($_POST['code_membre'] =='') {    				   
		                    $userin->setCode_membre(null);
                        } else {
                            $userin->setCode_membre($_POST['code_membre']);
                        }
				    }
		            
					if($code_groupe == 'surveillance_filiere' || $code_groupe == 'detentrice_technopole' || $code_groupe == 'executante_acnev'
					    || $code_groupe == 'agrement_filiere' || $code_groupe == 'agrement_technopole' || $code_groupe == 'agrement_acnev') {
					   
					    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                        $date_idd = clone $date_id;
					    $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
					
					    $t_division = new Application_Model_DbTable_EuTeteDivision();
                        $c_division = new Application_Model_EuTeteDivision();
						
						if($code_groupe == 'surveillance_filiere' || $code_groupe == 'detentrice_technopole' || $code_groupe == 'executante_acnev') {
						    $find_acteur = $acteur->findByActeur($_POST['code_membre']);
						    if ($find_acteur != false) {
                               $message = 'Ce compte membre personne physique est déjà associé à  un compte acteur : '.$_POST['code_membre'];
                               $this->view->message = $message;
                               $this->view->nom = $this->_request->getPost("nom");
                               $this->view->prenom = $this->_request->getPost("prenom");
                               $this->view->login = $this->_request->getPost("login");
                               return;
                            }
						
						}
						
				        $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
				        $rep_table = new Application_Model_DbTable_EuRepresentation();
						
						$findtablerep = $rep_table->find($_POST['code_membre'],$user->code_membre);
						if(count($findtablerep) == 0) {
						    $rep->setCode_membre_morale($user->code_membre)
                                ->setCode_membre($_POST['code_membre'])
                                ->setTitre('Representant')
						        ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						        ->setId_utilisateur($user->id_utilisateur)
						        ->setEtat('outside');
					        $rep_mapper->save($rep);
						}
						
					    $filiere =  new Application_Model_EuFiliere();
					    $map_filiere = new Application_Model_EuFiliereMapper();
					
					    if($code_groupe == 'surveillance_filiere' || $code_groupe == 'detentrice_technopole' || $code_groupe == 'executante_acnev') {
					        $find_filiere = $map_filiere->find($user->id_filiere,$filiere);
					    } else {
					        $find_filiere = $map_filiere->find($_POST['filiere'],$filiere);
					    }
						
					    if($code_groupe == 'executante_acnev' || $code_groupe == 'agrement_acnev') {
						    $table = new Application_Model_DbTable_EuActeur();
			                $select = $table->select();
			                $select->where('code_acteur like ?',$user->code_acteur);
			                $result = $table->fetchAll($select);
			                $findacteur = $result->current();
			                $code_gac_chaine = $findacteur->code_gac_chaine;
			                $selection = $table->select();
			                $selection->where('code_gac_chaine like ?',$code_gac_chaine);
			                $selection->where('type_acteur like ?','gac_surveillance');
			                $resultat = $table->fetchAll($selection);
			                $trouvacteursur = $resultat->current();
							$code_acteur = $trouvacteursur->code_acteur;
						}
					    $table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
				        $select->where('code_acteur like ?', $code_acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
				        $count = $c_acteur->findConuter() + 1;
					
					if($code_groupe == 'surveillance_filiere' || $code_groupe == 'detentrice_technopole' || $code_groupe == 'executante_acnev') {
					
					    // insertion dans la table eu_acteur
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($_POST['code_membre'])
                                 ->setId_utilisateur($user->id_utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
								 
						$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						$c_acteur->setCode_zone_create($code_zone);
						$c_acteur->setId_pays($id_pays);
						$c_acteur->setId_region($id_region);
						$c_acteur->setId_prefecture($id_prefecture);
						$c_acteur->setId_canton($id_canton);
						$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);		 
								 
                        if(($code_groupe == 'surveillance_filiere')) {
						    $c_acteur->setType_acteur('FILIERE');    
                        } elseif(($code_groupe == 'detentrice_technopole')) {
						    $c_acteur->setType_acteur('TECHNOPOLE');
                        } elseif(($code_groupe == 'executante_acnev')) {
						    $c_acteur->setType_acteur('ACNEV');
                        }
							
                        $c_acteur->setCode_activite($_POST['type_admin']);	
						
                        $c_acteur->setCode_gac_chaine($code_acteur);
                        $t_acteur->insert($c_acteur->toArray());	
					}
                        
				        // insertion dans la table eu_tete_division
					    $countd = $c_division->findConuter() + 1;
                        $c_division->setId_tete_division($countd)
                                   ->setCode_acteur($user->code_acteur)
								   ->setCode_division($filiere->getCode_division())
								   ->setCode_agence($user->code_agence)
                                   ->setCode_membre_morale($user->code_membre)
								   ->setCode_membre($_POST['code_membre'])
                                   ->setId_utilisateur($user->id_utilisateur)
                                   ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					
					    $c_division->setCode_source_create($ligneacteur->code_source_create);
						$c_division->setCode_monde_create($ligneacteur->code_monde_create);
						$c_division->setCode_zone_create($code_zone);
						$c_division->setId_pays($id_pays);
						$c_division->setId_region($id_region);
						$c_division->setId_prefecture($id_prefecture);
						$c_division->setId_canton($id_canton);
						$c_division->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_division->setCode_agence_create($ligneacteur->code_agence_create);
						
						if(($code_groupe == 'surveillance_filiere') || ($code_groupe == 'agrement_filiere')) {
                          $c_division->setType_tete_division('FILIERE');    
                        } elseif(($code_groupe == 'detentrice_technopole') || ($code_groupe == 'agrement_technopole')) {
                          $c_division->setType_tete_division('TECHNOPOLE');
                        } elseif(($code_groupe == 'executante_acnev') || ($code_groupe == 'agrement_acnev')) {
                          $c_division->setType_tete_division('ACNEV');
                        }
						
						if($code_groupe == 'surveillance_filiere' || $code_groupe == 'detentrice_technopole' || $code_groupe == 'executante_acnev') {
						  $c_division->setId_filiere($user->id_filiere);
						} else {
						  $c_division->setId_filiere($_POST['filiere']);
						}
							
                        $c_division->setCode_activite($_POST['type_admin']);	
						
						$t_division->insert($c_division->toArray());
					}
                        $userin->setId_pays($id_pays);
                        $userin->setId_canton($id_canton);						
                        $mapper->save($userin);					
                        $db->commit();
                        return $this->_helper->redirector('index');
					}
                } catch (Exception $exc) {
                        $db->rollback();
                        $message = 'Echec '.$exc->getMessage();
		                $this->view->message = $message;
                        $this->view->nom = $this->_request->getPost("nom");
                        $this->view->prenom = $this->_request->getPost("prenom");
                        $this->view->login = $this->_request->getPost("login");
                }
        }
    }

	
    public function agencesAction() {
        $tagences = new Application_Model_EuAgenceMapper();
        $agences = $tagences->fetchAll();
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

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $id_utilisateur = $user->id_utilisateur;
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page",1);
        $limit = $this->_request->getParam("rows",10);
        $sidx = $this->_request->getParam("sidx",'id_utilisateur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuUtilisateur();
        
		if(isset($_GET["code_groupe"]))  {
		   $code_groupe = $_GET["code_groupe"];
		} else {
		   $code_groupe = '';
		}
		
		if(isset($_GET["connecte"])) {
		   $connecte = $_GET["connecte"];
		} else {
		   $connecte = '';
		}
		
		if(isset($_GET["ulock"])) {
		   $ulock = $_GET["ulock"];
		} else {
		   $ulock = '';
		}
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false);
			
			//$select = $tabela->select();
        
        if($code_groupe != '' && $connecte != '' && $ulock != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.code_groupe like ?',$code_groupe);
           $select->where('eu_utilisateur.connecte like ?',$connecte);
           $select->where('eu_utilisateur.ulock like ?',$ulock);     
        } elseif($code_groupe != '' && $connecte != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.code_groupe like ?',$code_groupe);
           $select->where('eu_utilisateur.connecte like ?',$connecte); 
        } elseif($code_groupe != '' && $ulock != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.code_groupe like ?',$code_groupe);
           $select->where('eu_utilisateur.ulock like ?',$ulock); 
        } elseif($connecte != '' && $ulock != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.connecte like ?',$connecte);
           $select->where('eu_utilisateur.ulock like ?',$ulock); 
        } elseif($code_groupe != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.code_groupe like ?',$code_groupe); 
        } elseif($ulock != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.ulock like ?',$ulock); 
        } elseif($connecte != '') {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
           $select->where('eu_utilisateur.connecte like ?',$connecte); 
        }
        else {
           $select->join('eu_user_group', 'eu_user_group.code_groupe = eu_utilisateur.code_groupe');
           $select->where('eu_utilisateur.id_utilisateur_parent = ?',$id_utilisateur);
           $select->order('id_utilisateur desc');
        }
		
        $cats = $tabela->fetchAll($select);
        $count = count($cats);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $cats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($cats as $row) {
            if($row->ulock == 0) {
               $ulock="Compte activé";
            } else {
               $ulock="Compte desactivé";
            }
            if($row->connecte == 0) {
               $connecte="Non";
            } else {
               $connecte="Oui";
            }
              $responce['rows'][$i]['id'] = $row->id_utilisateur;
              $responce['rows'][$i]['cell'] = array(
              $row->id_utilisateur,    
              $row->nom_utilisateur,
              $row->prenom_utilisateur,
              $row->login,
              $row->libelle_groupe,
              $connecte,
              $ulock
            );
            $i++;
        }
        $this->view->data = $responce;
		
		} catch (Exception $exc) {
		        $db->rollback();
		        $this->view->data = $exc->getMessage() . ': ' . $exc->getTraceAsString();
		}
		
			
    }

    
    public function activerAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $selection = array();
      $selection = $_GET['lignes'];
      $user_map = new Application_Model_EuUtilisateurMapper();
      $user = new Application_Model_EuUtilisateur();
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          foreach ($selection as $sel) {
            $id_user = $sel['id_utilisateur'];
            $ret = $user_map->find($id_user, $user);
            if ($ret) {
               $user->setUlock(0);
               $user_map->update($user);
            }
                 
          }    
          $db->commit();
          $this->view->data = 'good';
          return;
        } catch (Exception $exc) {
            $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                 $this->view->data = 'bad';
                 return;
        }    
    }
    
    public function desactiverAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $selection = array();
      $selection = $_GET['lignes'];
      $user_map = new Application_Model_EuUtilisateurMapper();
      $user = new Application_Model_EuUtilisateur();
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
        try {
            foreach ($selection as $sel) {
               $id_user = $sel['id_utilisateur'];
               $ret = $user_map->find($id_user, $user);
                if ($ret) {
                   $user->setUlock(1);
                   $user_map->update($user);
                }
                 
            }    
          $db->commit();
          $this->view->data = 'good';
          return;
        } catch (Exception $exc) {
            $db->rollback();
                $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
                $this->view->message = $message;
                 $this->view->data = 'bad';
                 return;
        }    
    }
    
	
	

    public function editAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_acteur = $user->code_acteur;
        $groupe = $user->code_groupe;
        $code_zone = $user->code_zone;
	    $code_acteur = $user->code_acteur;
	    $code_gac_filiere = $user->code_gac_filiere;
		
        $userin = new Application_Model_EuUtilisateur();
        $mapper = new Application_Model_EuUtilisateurMapper();
		$gm = new Application_Model_EuGacMapper();
		$gac = new Application_Model_EuGac();
		
		$m_acteur = new Application_Model_EuActeurMapper();
		$acteur   = new Application_Model_EuActeur();
		
        if ($this->getRequest()->isPost()) {
            $find_user = $mapper->findNoLogin($this->_request->getPost("login"), $this->_request->getPost("id_utilisateur"));
            //$pwd = $this->_request->getPost("pwd");
	        $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_creation = clone $date_id;
            //$pwd1 = $this->_request->getPost("pwd1");
            $code_groupe = $this->_request->getPost("groupe");
            if(isset($_POST['code_membre'])) {
              $code_membre = $this->_request->getPost("code_membre");
            } else {
              $code_membre = null;
            }
          
	        $id_pays = $this->_request->getPost("pays");
			$id_canton = $this->_request->getPost("canton");
			
            if(isset($_POST['agence'])) {
              $code_agence = $_POST['agence']; 
            } else {
              $code_agence = null;
            }
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
            //Mise � jour de la table eu_utilisateur
            if ($find_user != false) {
                    $message = 'Ce login existe déjà.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            /*} elseif ($pwd != $pwd1) {
                    $message = 'Erreur de confirmation du mot de passe.';
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;*/
            } elseif (stripos($this->_request->getPost("login"), " ") !== false) {
                    $message = "Le Login ne doit pas contenir d'espace";
                    $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                    return;
            } else {
                   $id_user = $this->_request->getPost("id_utilisateur");
				   $mapper->find($id_user, $userin);
                   //$userin->setId_utilisateur($id_user);
                   //$userin->setId_utilisateur_parent($user->id_utilisateur); 
                   $userin->setPrenom_utilisateur($this->_request->getPost("prenom"));
                   $userin->setNom_utilisateur($this->_request->getPost("nom"));
                   $userin->setLogin(trim($this->_request->getPost("login")));
                   //$userin->setPwd(md5($pwd));
                   $userin->setDescription($this->_request->getPost("desc"));
                   //$userin->setUlock(0);
                   //$userin->setCh_pwd_flog(0);
                   $userin->setCode_groupe($code_groupe);
                   //$userin->setConnecte(0);
                   $userin->setCode_agence($code_agence);
                   //$userin->setCode_secteur(null);
                   //$userin->setCode_zone($code_zone);
                    if(isset($_POST['filiere'])) {
                        $userin->setId_filiere($_POST['filiere']);
				    } else {
                        $userin->setId_filiere(null);
				    }
				    //$userin->setCode_acteur($code_acteur);	   
				    //$userin->setCode_gac_filiere($code_gac_filiere);
               
                    if(!isset($_POST['code_membre'])) {    				   
		              $userin->setCode_membre(null);
                    } else {
                      $userin->setCode_membre($_POST['code_membre']);
                    }
		            $userin->setId_pays($_POST['pays']);
                    $userin->setId_canton($_POST['canton']);					
                    $mapper->update($userin);
					
					$id_canton = $_POST['canton'];
				    $canton = new Application_Model_EuCanton();
                    $mapper_canton = new Application_Model_EuCantonMapper();
			        $findcanton = $mapper_canton->find($id_canton,$canton);
			
			        $prefecture = new Application_Model_EuPrefecture();
                    $mapper_prefecture = new Application_Model_EuPrefectureMapper();
			        $findprefecture = $mapper_prefecture->find($canton->id_prefecture,$prefecture);
			        $id_prefecture = $prefecture->id_prefecture;
			
			        $region = new Application_Model_EuRegion();
                    $mapper_region = new Application_Model_EuRegionMapper();
			        $findregion = $mapper_region->find($prefecture->id_region,$region);
			        $id_region = $region->id_region;
			
			        $pays = new Application_Model_EuPays();
                    $mapper_pays = new Application_Model_EuPaysMapper();
			        $findpays = $mapper_pays->find($region->id_pays,$pays);
			        $id_pays = $pays->id_pays;
			
			        $zone = new Application_Model_EuZone();
                    $mapper_zone = new Application_Model_EuZoneMapper();
			        $findzone = $mapper_zone->find($pays->code_zone,$zone);
			        $code_zone = $zone->code_zone;
				  
				    $rep_mapper = new Application_Model_EuRepresentationMapper();
                    $rep = new Application_Model_EuRepresentation();
				    $rep_table = new Application_Model_DbTable_EuRepresentation();
				  
				    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_idd = clone $date_id;
					
					
                    $db->commit();
                    return $this->_helper->redirector('index');
                    }
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = 'Echec '.$exc->getMessage();
		            $this->view->message = $message;
                    $this->view->nom = $this->_request->getPost("nom");
                    $this->view->prenom = $this->_request->getPost("prenom");
                    $this->view->login = $this->_request->getPost("login");
                }
        } else {
            $this->_helper->layout->disableLayout();
            $id_user = $this->_request->getParam("id_utilisateur");
		    $mapper->find($id_user,$userin);
            $this->view->id_utilisateur = $userin->id_utilisateur;
            $this->view->prenom = $userin->prenom_utilisateur;
            $this->view->nom = $userin->nom_utilisateur;
            $this->view->login = $userin->login;
			$this->view->pwd = $userin->pwd;
            $this->view->desc = $userin->description;
            $this->view->groupe = $userin->code_groupe;
            $this->view->filiere = $userin->id_filiere;
		    $this->view->code_membre = $userin->code_membre;
		    $this->view->pays = $userin->id_pays;
			$this->view->canton = $userin->id_canton;
            $this->view->agence = $userin->code_agence;
			if($userin->code_groupe == 'detentrice_technopole' || $userin->code_groupe == 'surveillance_filiere' || $userin->code_groupe == 'executante_acnev') {
			   $findacteur = $m_acteur->findByActeur($userin->code_membre);
			   $this->view->acteur = $findacteur;     
			}
	    }
    }





}

?>
