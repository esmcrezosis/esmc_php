<?php
class EuMiseChaineController extends Zend_Controller_Action {

      //put your code here
      public function init() {
         $this->view->jQuery()->enable();
         $this->view->jQuery()->uiEnable();
         $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
         $user = $auth->getIdentity();
         $group = $user->code_groupe;
         if ($group == 'mise_chaine' or $group == 'filiere' or  $group == 'scmacnev'  or  $group == 'technopole' or  $group == 'productiong' or  $group == 'productionsg'  or  $group == 'productiond'
		    or  $group == 'transformationg' or  $group == 'transformationsg' or  $group == 'transformationd' or  $group == 'distributiong' or  $group == 'distributionsg' or  $group == 'distributiond') {
            $menu = "<li><a href=\"/eu-mise-chaine/newmisechaine\">Nouveau acteur</a></li>" .
                    "<li><a href=\"/eu-mise-chaine/misesurchaine\">Ancien acteur</a></li>";
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
            if ($group != 'mise_chaine' and  $group != 'filiere'  and  $group != 'scmacnev' and  $group != 'technopole' and  $group != 'productiong' and  $group != 'productionsg' and  $group != 'productiond'
		        and  $group != 'transformationg' and  $group != 'transformationsg' and  $group != 'transformationd' and  $group != 'distributiong'
		        and  $group != 'distributionsg' and  $group != 'distributiond') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function indexAction() {
        
    }

    public function dataAction() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_acteur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuActeurCreneau();
        $select = $tabela->select();
        $ugroupe = $user->code_groupe;

        if ($ugroupe == 'creneau') {
            $select->setIntegrityCheck(false)
                    ->from(array('a' => 'EU_aCTEURS_CRENEaUX'), array('a.CODE_aCTEUR', 'a.NOM_aCTEUR', 'a.code_membre', "TO_CHaR((a.DaTE_CREaTION),'dd/mm/yyyy') DaTE_CREaTION"))
                    ->join(array('c' => 'EU_cRENEaUX'), 'c.cODE_cRENEaU = a.cODE_cRENEaU', array('NOM_cRENEaU'))
                    ->join(array('t' => 'EU_tYPE_aCtEUR'), 't.ID_tYPE_aCtEUR = a.ID_tYPE_aCtEUR', array('LIB_tYPE_aCtEUR'))
                    ->join(array('m' => 'EU_mEmBRE'), 'm.CODE_mEmBRE = a.CODE_mEmBRE_GESTIONNaIRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE', 'PORTaBLE_mEmBRE'))
                    ->where('a.ID_UTILISaTEUR = ?', $user->ID_UTILISaTEUR);
        } elseif ($ugroupe == 'filiere') {
            $select->setIntegrityCheck(false)
                   ->from(array('a' => 'EU_aCTEURS_CRENEaUX'),array('a.CODE_aCTEUR', 'a.NOM_aCTEUR', 'a.code_membre', 'a.CODE_GaC_FILIERE', "TO_CHaR((a.DaTE_CREaTION),'dd/mm/yyyy') DaTE_CREaTION"))
                   ->join(array('f' => 'EU_GaC_fILIERE'), 'f.CODE_GaC_fILIERE = a.CODE_GaC_fILIERE', array('NOM_GaC_fILIERE'))
                   ->join(array('t' => 'EU_tYPE_aCtEUR'), 't.ID_tYPE_aCtEUR = a.ID_tYPE_aCtEUR', array('LIB_tYPE_aCtEUR'))
                   ->join(array('m' => 'EU_mEmBRE'), 'm.CODE_mEmBRE = a.CODE_mEmBRE_GESTIONNaIRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE', 'PORTaBLE_mEmBRE'))
                   ->where('a.ID_UTILISaTEUR = ?', $user->ID_UTILISaTEUR);
        } else {
            $select->setIntegrityCheck(false)
                    ->from(array('a' => 'EU_aCTEURS_CRENEaUX'), array('a.CODE_aCTEUR', 'a.NOM_aCTEUR', 'a.code_membre', 'a.CODE_GaC', "TO_CHaR((a.DaTE_CREaTION),'dd/mm/yyyy') DaTE_CREaTION"))
                    ->join(array('g' => 'EU_gaC'), 'g.CODE_gaC = a.CODE_gaC', array('NOM_gaC'))
                    ->join(array('t' => 'EU_tYPE_aCtEUR'), 't.ID_tYPE_aCtEUR = a.ID_tYPE_aCtEUR', array('LIB_tYPE_aCtEUR'))
                    ->join(array('m' => 'EU_mEmBRE'), 'm.CODE_mEmBRE = a.CODE_mEmBRE_GESTIONNaIRE', array('NOm_mEmBRE', 'PRENOm_mEmBRE', 'PORTaBLE_mEmBRE'))
                    ->where('a.ID_UTILISaTEUR = ?', $user->ID_UTILISaTEUR);
        }
        $acteurs = $tabela->fetchAll($select);
        $count = count($acteurs);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $acteurs = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($acteurs as $row) {
            if ($ugroupe == 'creneau') {
                $nom_acteur = ucfirst($row->nom_creneau);
                $code_gac_fil = null;
            } elseif ($ugroupe == 'filiere') {
                $nom_acteur = ucfirst($row->nom_gac_filiere);
                $code_gac_fil = $row->code_gac_filiere;
            } else {
                $nom_acteur = ucfirst($row->nom_gac);
                $code_gac_fil = null;
            }
            $responce['rows'][$i]['id'] = $row->code_acteur;
            $responce['rows'][$i]['cell'] = array(
                $row->code_acteur,
                ucfirst($row->nom_acteur),
                $row->code_membre,
                ucfirst($row->lib_type_acteur),
                strtoupper($row->nom_membre) . ' ' . ucfirst($row->PREnom_membre),
                $nom_acteur,
                $row->date_creation,
                $code_gac_fil
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function typeacteurAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
		if($group == 'productiong' or  $group == 'productionsg' or  $group == 'productiond'
		  or $group == 'transformationg' or  $group == 'transformationsg' or  $group == 'transformationd' or  $group == 'distributiong'
		  or $group == 'distributionsg' or  $group == 'distributiond') {
        $t_type = new Application_Model_DbTable_EuTypeActeur();
        $types = $t_type->fetchAll();
        if (count($types) >= 1) {
           $data = array();
           for ($i = 0; $i < count($types); $i++) {
               $value = $types[$i];
               $data[$i][0] = $value->id_type_acteur;
               $data[$i][1] = $value->lib_type_acteur;
           }
        } else {
               $data = '';
        }
		} elseif($group == 'filiere') {
		      $tab = new Application_Model_DbTable_EuTypeContrat();
              $sel = $tab->select();
			  $data = array();
		      $sel->where('id_type_contrat = ?',4);
		      $tgac = $tab->fetchAll($sel);
              $i = 0;
              foreach ($tgac as $value) {
                $data[$i][0] = $value->id_type_contrat;
                $data[$i][1] = ucfirst($value->libelle_type_contrat);
                $i++;
              }
		}elseif($group == 'scmacnev') {
		      $tab = new Application_Model_DbTable_EuTypeContrat();
              $sel = $tab->select();
			  $data = array();
		      $sel->where('id_type_contrat = ?',5);
		      $tgac = $tab->fetchAll($sel);
              $i = 0;
              foreach ($tgac as $value) {
                $data[$i][0] = $value->id_type_contrat;
                $data[$i][1] = ucfirst($value->libelle_type_contrat);
                $i++;
              }
		}elseif($group == 'technopole') {
		      $tab = new Application_Model_DbTable_EuTypeContrat();
              $sel = $tab->select();
			  $data = array();
		      $sel->where('id_type_contrat = ?',6);
		      $tgac = $tab->fetchAll($sel);
              $i = 0;
              foreach ($tgac as $value) {
                $data[$i][0] = $value->id_type_contrat;
                $data[$i][1] = ucfirst($value->libelle_type_contrat);
                $i++;
              }
		}	
        $this->view->data = $data;
		
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

    public function activiteAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = $user->code_groupe;
		if($group == 'productiong' or  $group == 'productionsg' or  $group == 'productiond'
		   or $group == 'transformationg' or  $group == 'transformationsg' or  $group == 'transformationd' or  $group == 'distributiong'
		   or $group == 'distributionsg' or  $group == 'distributiond') {
		$filiere = new Application_Model_DbTable_EuActivite();
        $filieres = $filiere->fetchAll();	
        if (count($filieres) >= 1) {
            $data = array();
            for ($i = 0; $i < count($filieres); $i++) {
                $value = $filieres[$i];
                $data[$i][0] = $value->code_activite;
                $data[$i][1] = $value->nom_activite;
            }
        }   else {
                  $data = '';
            }
		} else {
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
		       
		}
        $this->view->data = $data;
    }

    public function traiterAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();

        $code_acteur = $_POST['code_acteur'];
        $nom_acteur = $_POST['nom'];
        $num_membre = $_POST['num_membre'];
        $type_acteur = $_POST['id_type_acteur'];
        $code_activite = $_POST['code_activite'];
        $code_membre_gestion = $_POST['code_membre_gestionnaire'];

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            //$select = "delete from eu_acteurs_creneaux  where code_acteur= '$code_acteur'";
            //$db->query($select);
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_creation = clone $date_id;
            $cm = new Application_Model_EuActeurCreneauMapper();
            $acren = new Application_Model_EuActeurCreneau();
            $find_acren = $cm->find($code_acteur, $acren);
            $acren->setNom_acteur($nom_acteur);
            $acren->setCode_membre($num_membre);
            $acren->setId_type_acteur($type_acteur);
            $acren->setCode_activite($code_activite);
            $acren->setCode_membre_gestionnaire($code_membre_gestion);
            $acren->setDate_creation($date_creation->toString('yyyy-mm-dd'));
            $acren->setId_utilisateur($users->id_utilisateur);
            $ugroupe = $users->code_groupe;
            $type = '';
            if ($ugroupe == 'creneau_pbf' || $ugroupe == 'filiere_pbf') {
                $acren->setGroupe('pbf');
                $type = 'pbf';
            }
            if ($ugroupe == 'creneau' || $ugroupe == 'filiere') {
                $acren->setGroupe('gac');
                $type = 'gac';
            }
            $code_cre = $users->code_acteur;
            if ($ugroupe == 'creneau') {
                $acren->setCode_creneau($code_cre);
                $acren->setCode_gac_filiere(null);
                $acren->setCode_gac(null);
            } elseif ($ugroupe == 'filiere') {
                $acren->setCode_creneau(null);
                $acren->setCode_gac_filiere($code_cre);
                $acren->setCode_gac(null);
            } else {
                $acren->setCode_creneau(null);
                $acren->setCode_gac_filiere(null);
                $acren->setCode_gac($code_cre);
            }

            //Formation du code de l'acteur à partir du code du créneau ou code gac filiere
            /*   if ($ugroupe == 'creneau') {
              $code = $cm->getLastActeurByCrenau($code_cre);
              }
              else {
              $code = $cm->getLastActeurByFiliere($code_cre);
              }
              if ($code == null) {
              $code_act = $code_cre . 'a' . '0001';
              } else {
              $num_ordre = substr($code, -4);
              $num_ordre++;
              $code_act = $code_cre . 'a' . str_pad($num_ordre, 4, 0, STR_PaD_LEFT);
              }
             */

            //$acren->setCode_acteur($code_act);
            $acteur = $this->_request->getPost("id_type_acteur");

            //Vérification du type de contrat de l'acteur du créneau d'activités
            $mcontra = new Application_Model_EuContratMapper();
            $find_contra = $mcontra->findByMembre($num_membre);
            if ($find_contra != false) {
                $id_type_acteur = $find_contra->getId_type_acteur();
                $mtypeact = new Application_Model_EuTypeActeurMapper();
                $typeact = new Application_Model_EuTypeActeur();
                $mtypeact->find($id_type_acteur, $typeact);
                $type_acteur = $typeact->getLib_type_acteur();
                if ($type_acteur == 'grossiste' || $type_acteur == 'semi-grossiste' || $type_acteur == 'détaillant') {
                    if ($id_type_acteur != $acteur) {
                        //Récup du libellé du type d'acteur
                        $mtypeact->find($acteur, $typeact);
                        $this->view->data = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat d\'acteur ' . ucfirst($typeact->getLib_type_acteur());
                        return;
                    } else {
                        // Vérification du code membre du créneau
                        //  $find_mb = $cm->findByMembre($num_membre);
                        //  if ($find_mb != false) {
                        // $this->view->data = 'Ce membre ' . $num_membre . ' est déjà enregistré comme acteur créneau';
                        // } else {
                        //Création de l'acteur créneau
                        $cm->update($acren);
                        //Récupération de la filière liéé à l'activité
                        $mapper = new Application_Model_DbTable_EuActivite();
                        $rows = $mapper->find($code_activite);
                        $row = $rows->current();
                        $id_filiere = $row->id_filiere;
                        //Récupération de la pck nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prk = 0;
                        $par_prk = $param->find('prk', 'nr', $par);
                        if ($par_prk == true) {
                            $prk = $par->getMontant();
                        }
                        $mdvm = new Application_Model_EuMdvMapper();
                        $find_mdv = $mdvm->findMdvByFiliere($id_filiere);
                        if ($find_mdv == null) {
                            $mdv = ceil($prk);
                        } else {
                            $md = $find_mdv->getDuree_vie();
                            if ($md < $prk) {
                                $mdv = ceil($prk);
                            } else {
                                $mdv = $md;
                            }
                        }
						
                        //Création du tegc du créneau d'activités
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'tegcp' . $id_filiere . $num_membre;
                        $find_te = $te_mapper->find($code_te, $te);
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
                                    ->setId_filiere($id_filiere)
                                    ->setMdv($mdv)
                                    ->setCode_membre($num_membre)
                                    ->setMontant(0);
                            $te_mapper->save($te);
                        } else {
                            $te->setId_filiere($id_filiere);
                            $te->setMdv($mdv);
                            $te_mapper->update($te);
                        }
                        //Initialisation du compte tegcp du créneau d'activités
                        $date_alloc = new Zend_Date(Zend_Date::ISO_8601);
                        $code_cat = 'tpagcp';
                        $code_compte = 'nb-' . $code_cat . '-' . $num_membre;
                        $compte_mapper = new Application_Model_EuCompteMapper();
                        $compte = new Application_Model_EuCompte();
                        $find_compte = $compte_mapper->find($code_compte, $compte);
                        if ($find_compte == false) {
                           $compte->setCode_compte($code_compte)
                                  ->setCode_membre(null)
                                  ->setLib_compte('gcp')
                                  ->setSolde(0)
                                  ->setDate_alloc($date_alloc->toString('yyyy-mm-dd'))
                                  ->setCode_type_compte('nb')
                                  ->setCode_cat($code_cat)
                                  ->setDesactiver(0)
                                  ->setMifareCard('')
                                  ->setCardPrintedDate('')
                                  ->setCardPrintedIDDate(0)
                                  ->setCode_membre_morale($num_membre)
                                  ->setNumero_carte(null);
                            $compte_mapper->save($compte);
                        }
						
                        //Mise à jour du id_filiere de la table membre
                        $membm = new Application_Model_EuMembreMoraleMapper();
                        $membre = new Application_Model_EuMembreMorale();
                        $membm->find($num_membre, $membre);
                        $membre->setId_filiere($id_filiere);
                        $membm->update($membre);

                        $db->commit();
                        $this->view->data = true;
                        return;
                        //}
                    }
                } else {
                    $this->view->data = 'Ce membre ' . $num_membre . ' ne dispose pas d\'un contrat d\'acteur créneau';
                    //$this->view->form = $form;
                    return;
                }
            } else {
                $this->view->data = 'Ce membre ' . $num_membre . ' ne dispose d\'aucun contrat';
                //$this->view->form = $form;
                return;
            }
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            //$this->view->message = $message;
            $this->view->data = $message;
            return;
        }
    }

    public function misesurchaineAction() {
        
    }

    public function newmisechaineAction() {
        
    }

    public function gestionchangeAction() {
        $num_gesttion = $_GET['gestion'];
        $data = array();
        $mb_db = new Application_Model_DbTable_EuMembre();
        $mb_find = $mb_db->find($num_gesttion);
        if (count($mb_find) == 1) {
            $result = $mb_find->current();
            $data[0] = $result->nom_membre;
            $data[1] = $result->prenom_membre;
            $data[2] = $result->portable_membre;
        } else {
            $data[0] = '';
            $data[1] = '';
            $data[2] = '';
        }
        $this->view->data = $data;
    }

    public function domainesAction() {
        $gac = array();
        $tab = new Application_Model_DbTable_EuFiliere();
        $sel = $tab->select();
        $sel->order('nom_filiere', 'asc');
        $ngac = $tab->fetchAll($sel);
        $i = 0;
        foreach ($ngac as $value) {
            $gac[$i][1] = $value->id_filiere;
            $gac[$i][2] = ucfirst($value->nom_filiere);
            $i++;
        }
        $this->view->data = $gac;
    }

    public function recupnomAction() {
        $num_membre = $_GET['num_membre'];

        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            //$data[0] = strtoupper($result->nom_membre) . ' ' . ucfirst($result->PREnom_membre);
            $data[1] = $result->raison_sociale;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function recupacteurAction() {

        $num_membre = $_GET['num_membre'];
        $acteur_db = new Application_Model_DbTable_EuActeurCreneau();
        $select = $acteur_db->select();
        $select->where('code_membre like ?', $num_membre);
        $acteur = $acteur_db->fetchAll($select);
        if (count($acteur) == 1) {
            $result = $acteur->current();
            $data[0] = strtoupper($result->nom_acteur);
            $data[1] = $result->code_membre;
            $data[2] = $result->id_type_acteur;
            $data[3] = $result->code_activite;
            $data[4] = $result->code_membre_gestionnaire;
            $data[5] = $result->code_acteur;
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }

    public function changeAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembreMorale();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre_morale;
        }
        $this->view->data = $data;
    }

    public function changephysAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }

    public function recupmembreAction() {

        $num_membre = $_GET['num_membre'];
        $membrem_db = new Application_Model_DbTable_EuMembreMorale();
        $select = $membrem_db->select();
        $select->setIntegrityCheck(false);
        $select->from(array('a' => 'EU_MEMBRE_MORaLE'), array('a.CODE_MEMBRE_MORaLE', 'a.RaISON_SOCIaLE'));
        $select->where('a.CODE_MEMBRE_MORaLE like ?', $num_membre);
        $select->join(array('r' => 'EU_rEPrESENTaTION'), 'a.CODE_MEMBrE_MOraLE = r.CODE_MEMBrE_MOraLE', array('TITrE'));
        $select->join(array('m' => 'EU_mEmBrE'), 'm.CODE_mEmBrE = r.CODE_mEmBrE', array('CODE_mEmBrE', 'NOm_mEmBrE', 'PrENOm_mEmBrE', 'POrTABLE_mEmBrE'));
        $select->where('r.TITrE like ?', 'representant');
        $acteur = $membrem_db->fetchAll($select);
        if (count($acteur) == 1) {
            $result = $acteur->current();
            $data[0] = strtoupper($result->raison_sociale);
            $data[1] = $result->code_membre_morale;
            $data[2] = $result->code_membre;
            $data[3] = $result->nom_membre;
            $data[4] = $result->prenom_membre;
            $data[5] = $result->portable_membre;
        } else {
            $membrem_db = new Application_Model_DbTable_EuMembreMorale();
            $select = $membrem_db->select();
            $select->setIntegrityCheck(false);
            $select->from(array('a' => 'EU_MEMBRE_MORaLE'), array('a.CODE_MEMBRE_MORaLE', 'a.RaISON_SOCIaLE'));
            $select->where('a.CODE_MEMBRE_MORaLE like ?', $num_membre);
            $acteur = $membrem_db->fetchAll($select);
            $result = $acteur->current();
            $data[0] = strtoupper($result->raison_sociale);
            $data[1] = $result->code_membre_morale;
        }
        $this->view->data = $data;
    }

	
	
    public function traiternewAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
		   
		$code_acteur = $_POST['code_acteur'];
        $nom_acteur = $_POST['nom'];
        $num_membre = $_POST['num_membre'];
        $type_acteur = $_POST['id_type_acteur'];
        $code_activite = $_POST['code_activite'];
        $code_membre_gestion = $_POST['code_membre_gestionnaire'];

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
		   	   
		
		
		
		
		
		
		
		
		
    }

}

?>
