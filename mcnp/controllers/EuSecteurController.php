<?php

class EuSecteurController extends Zend_Controller_Action {

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = $user->code_groupe;
            if ($group != 'admin' and $group != 'agregat' and $group != 'gac' and $group != 'gacp' and $group != 'gacse'  and $group != 'gacr' and $group != 'acteur_pbf' and $group != 'paraenro') {
                $this->view->user = $user;
                return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

    public function init() {
        /* Initialize action controller here */
        $menu = "<li><a href=\" /eu-secteur/new \">Ajouter secteur</a></li>".
		        "<li><a href=\" /eu-secteur/addprefecture \">Ajouter prefecture</a></li>".
				"<li><a href=\" /eu-secteur/listpre \">Liste des prefecture</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    public function indexAction() {
        // action body
    }
	
	public function listpreAction() {
       //action body
    }
	
	
	public function datapreAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'id_prefecture');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuPrefecture();
        $select = $tabela->select();
		$select->order('id_prefecture desc');
        //$select->setIntegrityCheck(false)
        //->join('eu_region', 'eu_region.id_region = eu_prefecture.id_region') 
        //->from('eu_prefecture')
			   //->where('eu_secteur.code_membre like ?', $user->code_membre)
			  ;
        $secteurs = $tabela->fetchAll($select);
        $count = count($secteurs);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $secteurs = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($secteurs as $row) {
		    $region = new Application_Model_EuRegion();
			$regionM = new Application_Model_EuRegionMapper();
			$regionM->find($row->id_region,$region);
            $responce['rows'][$i]['id'] = $row->id_prefecture;
            $responce['rows'][$i]['cell'] = array(
                $row->id_prefecture,
                $row->nom_prefecture,
                $region->nom_region
            );
            $i++;
        }
        $this->view->data = $responce;
    }
	
	
	public  function  addprefectureAction()  {
	    $request = $this->getRequest();
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		$t_region =  new Application_Model_DbTable_EuRegion();
        $regions  = $t_region->fetchAll();
	    $this->view->regions = $regions;
		
        if($this->getRequest()->isPost()) {
		   $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
               $prefecture = new Application_Model_EuPrefecture();
			   $prefectureM   = new Application_Model_EuPrefectureMapper();
			   $id_prefecture = $prefectureM->findConuter() + 1;
			   $nom_prefecture = $request->getParam("nom_prefecture");
			   $id_region = $request->getParam("id_region");

               $prefecture->setId_prefecture($id_prefecture);
               $prefecture->setNom_prefecture($nom_prefecture);
               $prefecture->setId_region($id_region);
               $prefectureM->save($prefecture);			
        
		       $db->commit();
			   return $this->_helper->redirector('listpre');

           }  catch(Exception $exc) {
               $db->rollback();
               $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
               return;
            }		   
		
		}
	
	}
	
	
	
	
	

    public function dataAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 50);
        $sidx = $this->_request->getParam("sidx", 'code_secteur');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSecteur();
        $select = $tabela->select();
        $select->setIntegrityCheck(false)
              //->join('eu_re', 'eu_zone.code_zone = eu_pays.code_zone') 
               ->from('eu_secteur')
			   //->where('eu_secteur.code_membre like ?', $user->code_membre)
			  ;
        $secteurs = $tabela->fetchAll($select);
        $count = count($secteurs);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;

        $secteurs = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($secteurs as $row) {
		    $datecreation = new Zend_Date($row->date_creation);
            $responce['rows'][$i]['id'] = $row->code_secteur;
            $responce['rows'][$i]['cell'] = array(
                $row->code_secteur,
                ucfirst($row->nom_secteur),
                //ucfirst($row->id_region),
                //ucfirst($row->id_pays),
                $datecreation->toString('dd/MM/yyyy')
            );
            $i++;
        }
        $this->view->data = $responce;
    }

    public function saveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $s = new Application_Model_EuSecteur();
        $ms = new Application_Model_EuSecteurMapper();
        $oper = $this->_request->getPost("oper");
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);

        if ($oper == "edit") {
            $s->setCode_secteur($this->_request->getPost("code_secteur"));
            $s->setNom_secteur($this->_request->getPost("nom_secteur"));
            $s->setId_region($this->_request->getPost("id_region"));
            $s->setId_pays($this->_request->getPost("id_pays"));
            $s->setDate_creation($date_fin->toString('yyyy-mm-dd'));
            $ms->update($s);
        } elseif ($oper == "add") {
            $s->setCode_secteur($this->_request->getPost("code_secteur"));
            $s->setNom_secteur($this->_request->getPost("nom_secteur"));
            $s->setId_region($this->_request->getPost("id_region"));
            $s->setId_pays($this->_request->getPost("id_pays"));
            $s->setDate_creation($date_fin->toString('yyyy-mm-dd'));
            $ms->save($s);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("code_secteur");
            $ms->delete($id);
        }
    }



    public function newAction() {
        // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuSecteur();
        $date_fin = new Zend_Date(Zend_Date::ISO_8601);
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {
            if($form->isValid($request->getPost())) {
               $mapper = new Application_Model_EuSecteurMapper();
               $sect = new Application_Model_EuSecteur($form->getValues());
               $sect->setDate_creation($date_fin->toString('yyyy-MM-dd'));
               //Formation du code de la zone à partir du code pays

               $id_prefecture = $this->_request->getPost("id_prefecture");
               $id_region = $request->getPost("id_region");
               $code_zone = '';
			   $code_secteur = "";
               
			   $region = new Application_Model_EuRegion();
			   $regionM = new Application_Model_EuRegionMapper();
			 
			   $pays = new Application_Model_EuPays();
			   $paysM = new Application_Model_EuPaysMapper();
			   
			   $regionM->find($id_region,$region);
			   $id_pays = $region->id_pays;
			   
			   $t_pays = new Application_Model_DbTable_EuPays();
               $rows = $t_pays->find($id_pays);
               if(count($rows) > 0) {
                 $code_zone = $rows->current()->code_zone;
               }
			   
			   
               if($code_zone != '') {
                 $code = $mapper->getLastCodeSectByZone($id_pays,$id_region);
                 if($code == null) {
                   $id_region = str_pad($id_region, 3, '0',STR_PAD_LEFT);
                   $code_secteur = $code_zone . $id_region . '001';
                 } else {
                   $num_ordre = substr($code, -3);
                   $num_ordre++;
                   $ordre = str_pad($num_ordre, 3, 0,STR_PAD_LEFT);     
                   $id_region = str_pad($id_region, 3, '0',STR_PAD_LEFT);
                   $code_secteur = $code_zone . $id_region . $ordre;  
                 }
                 $sect->setCode_secteur($code_secteur);
                 $sect->setId_pays($id_pays);
                    
                 $sect->setCode_secteur($code_secteur);
				 $sect->setCode_membre(NULL);
                 $mapper->save($sect);
                 return $this->_helper->redirector('index');
				  
                } else {
                    // Add the link to the cancel button
                    $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                            $this->view->url(array(
                                'controller' => 'eu-secteur',
                                'action' => 'index'
                                    ), 'default', true) .
                            "','_self')");

                    $this->view->form = $form;
                    $this->view->message = 'Code zone introuvable ou invalide :' . $code_zone;
                    return;
                }
               
			}
        }

        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-secteur',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuSecteur();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                    $date_creation = clone $date_id;
                    $sect = new Application_Model_EuSecteur($form->getValues());
                    $sect->setDate_creation($date_creation->toString('yyyy-MM-dd'));
                    $sect->setCode_secteur($this->_request->getPost("code_secteur"));
                    $id_prefecture = $this->_request->getPost("id_prefecture");
                    $id_region = $request->getPost("id_region");
                    
                    $mapper = new Application_Model_EuSecteurMapper();
                    $mapper->update($sect);
                    $db->commit();
                    return $this->_helper->redirector('index');
                    $this->view->form = $form;
                } catch (Exception $exc) {
                    $db->rollback();
                    $message = ' Erreur d\'éxécution : ' . $exc->getMessage();
                    $this->view->message = $message;
                }
            }
        } else {
            $code_secteur = $request->code_secteur;
            $mapper = new Application_Model_EuSecteurMapper();
            $secteur = new Application_Model_EuSecteur();
            $mapper->find($code_secteur, $secteur);
            if ($secteur->getCode_secteur() == $code_secteur) {
                $data = array(
                    'code_secteur' => $code_secteur,
                    'nom_secteur' => $secteur->getNom_secteur(),
                    'date_creation' => $secteur->getDate_creation(),
                    'id_prefecture' => $secteur->getId_prefecture(),
                    'id_region' => $secteur->getId_region()
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-secteur',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }

}

