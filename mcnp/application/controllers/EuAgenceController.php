<?php

class EuAgenceController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' and $group != 'agregat' and $group != 'acnev' and $group != 'acteur_pbf' and $group != 'gac' and $group != 'gacp' 
                    and $group != 'gacex' and $group != 'gacsu' and $group != 'gacse' and $group != 'gacr' and $group != 'gacs' 
                    and $group != 'gaca' and $group != 'gacreg' and $group != 'gacco' and $group != 'gacpro' 
                    and $group != 'gac_pbf' and $group != 'gacp_pbf' and $group != 'gacse_pbf' 
                    and $group != 'gacex_pbf' and $group != 'gacsu_pbf' and $group != 'gacr_pbf' and $group != 'gacs_pbf' and $group != 'gaca_pbf' and $group != 'paraenro') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-agence/new \">Ajouter agence</a></li>".
		        "<li><a href=\" /eu-agence/addcanton \">Ajouter canton</a></li>".
				"<li><a href=\" /eu-agence/listcanton \">Liste des cantons</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function indexAction() {
        // action body
    }
	
	public function listcantonAction() {
        // action body
    }
	
	
	public function  addcantonAction()  {
	    $request = $this->getRequest();
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		$t_prefecture =  new Application_Model_DbTable_EuPrefecture();
        $prefectures  = $t_prefecture->fetchAll();
	    $this->view->prefectures = $prefectures;
		
        if($this->getRequest()->isPost()) {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
               $canton = new Application_Model_EuCanton();
			   $cantonM   = new Application_Model_EuCantonMapper();
			   $id_canton = $cantonM->findConuter() + 1;
			   $nom_canton = $request->getParam("nom_canton");
			   $id_prefecture = $request->getParam("id_prefecture");

               $canton->setId_canton($id_canton);
               $canton->setNom_canton($nom_canton);
               $canton->setId_prefecture($id_prefecture);
               $cantonM->save($canton);			
        
		       $db->commit();
			   return $this->_helper->redirector('listcanton');

           }  catch(Exception $exc) {
               $db->rollback();
               $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
               return;
            }		   
		
		}
	
	}
	
	
	public function datacantonAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_agence');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuCanton();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		
		  $select->setIntegrityCheck(false)
                 ->join('eu_prefecture', 'eu_prefecture.id_prefecture = eu_canton.id_prefecture')
                 ->order('eu_canton.id_canton DESC');  
			   
         $agences = $tabela->fetchAll($select);
         $count = count($agences);
         if ($count > 0) {
            $total_pages = ceil($count / $limit);
         } else {
            $total_pages = 0;
         }

         if ($page > $total_pages)
            $page = $total_pages;

         $agences = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0; 
        foreach($agences as $row) {
            $responce['rows'][$i]['id'] = $row->id_canton;
            $responce['rows'][$i]['cell'] = array(
            $row->id_canton,
            ucfirst($row->nom_canton),
            ucfirst($row->nom_prefecture)        
            );
            $i++;
        }
        $this->view->data = $responce;
    }
	
	
	
	

    public function dataAction() {
        $code_agence = $_GET["code_agence"];
        $libelle_agence = $_GET["libelle_agence"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_agence');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuAgence();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		if($code_agence !="") {
          $select->setIntegrityCheck(false)
               ->join('eu_secteur', 'eu_secteur.code_secteur = eu_agence.code_secteur')
			   ->where('eu_agence.code_agence like ?', $code_agence);
		} else if($libelle_agence !="") {
		  $select->setIntegrityCheck(false)
                ->join('eu_secteur', 'eu_secteur.code_secteur = eu_agence.code_secteur')
			    ->where('eu_agence.libelle_agence like ?', $libelle_agence);
		}   else if($code_agence !="" && $libelle_agence !="") {
		  $select->setIntegrityCheck(false)
                 ->join('eu_secteur', 'eu_secteur.code_secteur = eu_agence.code_secteur')
			     ->where('eu_agence.code_agence like ?', $code_agence)
				 ->where('eu_agence.libelle_agence like ?', $libelle_agence);
		
		}  else  {
		  $select->setIntegrityCheck(false)
                 ->join('eu_secteur', 'eu_secteur.code_secteur = eu_agence.code_secteur')
                 ->order('eu_agence.date_creation asc');
		}
		  //->where('eu_agence.code_membre like ?', $user->code_membre)	   
			   
         $agences = $tabela->fetchAll($select);
         $count = count($agences);
         if ($count > 0) {
            $total_pages = ceil($count / $limit);
         } else {
            $total_pages = 0;
         }

         if ($page > $total_pages)
            $page = $total_pages;

         $agences = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0; 
        foreach ($agences as $row) {
            $date_create = new Zend_Date($row->date_creation);
            $responce['rows'][$i]['id'] = $row->code_agence;
            $responce['rows'][$i]['cell'] = array(
            $row->code_agence,
            ucfirst($row->libelle_agence),
            //$row->code_membre,
            ucfirst($row->nom_secteur),
            $date_create->toString('dd/MM/yyyy')        
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $date_id = new Zend_Date();
        $date_creation = clone $date_id;
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $z = new Application_Model_EuAgence();
        $mz = new Application_Model_EuAgenceMapper();
        $oper = $this->_request->getPost("oper");

        if ($oper == "edit") {
            $z->setCode_agence($this->_request->getPost("code_agence"));
            $z->setLibelle_agence($this->_request->getPost("libelle_agence"));
            $z->setCode_secteur($this->_request->getPost("code_secteur"));
            $z->setCode_membre($users->code_membre);
            $mz->update($z);
        } elseif ($oper == "add") {
            $z->setCode_agence($this->_request->getPost("code_agence"));
            $z->setLibelle_agence($this->_request->getPost("libelle_agence"));
            $z->setCode_secteur($this->_request->getPost("code_secteur"));
            $z->setCode_membre($users->code_membre);
            $z->setDate_creation($date_creation->toString('yyyy-mm-dd'));
            $mz->save($z);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("code_agence");
            $mz->delete($id);
        }
    }

	
    public function newAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $request = $this->getRequest();
        $form = new Application_Form_EuAgence();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $date_id = new Zend_Date();
                $date_creation = clone $date_id;
                $mapper = new Application_Model_EuAgenceMapper();
                $ag = new Application_Model_EuAgence($form->getValues());
                $ag->setDate_creation($date_creation->toString('yyyy-MM-dd'));
                //if ($this->_request->getPost("code_membre") == '') {
                $ag->setCode_membre(null);
                //}
                //Formation du code de l'agence à partir du code du secteur
                $code_secteur = $this->_request->getPost("code_secteur");
                $code = $mapper->getLastCodeAgenceBySect($code_secteur);
                $ag->setCode_secteur($code_secteur);
				
                if ($code == null) {
                   $code_agence = $code_secteur . '001';
                } else {
                   $num_ordre = substr($code, -3);
                   $num_ordre++;
                   $code_agence = $code_secteur . str_pad($num_ordre, 3, 0, STR_PAD_LEFT);
                }
				
                $ag->setCode_agence($code_agence);
				
				$id_canton = $this->_request->getPost("id_canton");
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
				
				$ag->setId_canton($id_canton);
				$ag->setId_prefecture($id_prefecture);
				$ag->setId_region($id_region);
				$ag->setId_pays($id_pays);
				$ag->setCode_zone($code_zone);
				
                $mapper->save($ag);
                return $this->_helper->redirector('index');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-agence',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuAgence();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date();
                    $date_creation = clone $date_id;
                    $ag = new Application_Model_EuAgence($form->getValues());
                    $ag->setDate_creation($date_creation->toString('yyyy-MM-dd'));
                    $ag->setCode_membre($this->_request->getPost("code_membre"));
                    $ag->setCode_secteur($this->_request->getPost("code_secteur"));
					//$ag->setType_gac($this->_request->getPost("type_gac"));
                    $ag->setCode_gac_create($user->code_acteur);
                    $mapper = new Application_Model_EuAgenceMapper();
                    $mapper->update($ag);
                    $db->commit();
                    return $this->_helper->redirector('index');
                    $this->view->form = $form;
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    //$message = 'Vérifiez votre saisie';
                    $this->view->message = $message;
                }
            }
        } else {
            $code_agence = $request->code_agence;
            $mapper = new Application_Model_EuAgenceMapper();
            $agence = new Application_Model_EuAgence();
            $mapper->find($code_agence, $agence);
            if ($agence->getCode_agence() == $code_agence) {
                $data = array(
                 'code_agence' => $code_agence,
                 'libelle_agence' => $agence->getLibelle_agence(),
                 'code_membre' => $agence->getCode_membre(),
                 'code_secteur' => $agence->getCode_secteur(),
                 //'type_gac' => $agence->getType_gac(),
                 'partenaire' => $agence->getPartenaire(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-agence',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
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

    public function getcodeAction() {
        $data = array();
        $agence = new Application_Model_DbTable_EuAgence();
        $select = $agence->select();
        $result = $agence->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_agence;
        }
        $this->view->data = $data;
    }

    public function getlibelleAction() {
        $data = array();
        $agence = new Application_Model_DbTable_EuAgence();
        $select = $agence->select();
        $result = $agence->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->libelle_agence;
        }
        $this->view->data = $data;
    }

}

