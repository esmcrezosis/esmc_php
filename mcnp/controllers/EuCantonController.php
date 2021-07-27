<?php

class EuCantonController extends Zend_Controller_Action {

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
        $menu = "<li><a href=\" /eu-canton/new \">Nouveau</a></li>";
        $this->view->placeholder("menu")->set($menu);
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

	
	
    public function indexAction() {
        // action body
    }

	
	
    public function dataAction() {
        $nom_canton = $_GET["nom_canton"];
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 100);
        $sidx = $this->_request->getParam("sidx", 'code_agence');
        $sord = $this->_request->getParam("sord", 'asc');
        $tabela = new Application_Model_DbTable_EuSubSecteur();
        $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
	    if($nom_canton !="") {
		 $select->setIntegrityCheck(false)
                ->join('eu_secteur', 'eu_secteur.code_secteur = eu_sub_secteur.code_secteur')
				->join('eu_agence', 'eu_agence.code_agence = eu_sub_secteur.code_agence')
			    ->where('eu_sub_secteur.nom_sub_secteur like ?', '%'.$nom_canton.'%');
		} else {
		    $select->setIntegrityCheck(false)
                   ->join('eu_secteur', 'eu_secteur.code_secteur = eu_sub_secteur.code_secteur')
				   ->join('eu_agence', 'eu_agence.code_agence = eu_sub_secteur.code_agence');
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
            $responce['rows'][$i]['id'] = $row->id_sub_secteur;
            $responce['rows'][$i]['cell'] = array(
            $row->id_sub_secteur,
			ucfirst($row->nom_sub_secteur),
            ucfirst($row->nom_secteur),
            ucfirst($row->libelle_agence),       
        );
            $i++;
        }
        $this->view->data = $responce;
    }

   

    public function newAction() {
	    // action body
        $request = $this->getRequest();
        $form = new Application_Form_EuCanton();
        
        if ($this->getRequest()->isPost()) {
             $msubsecteur = new Application_Model_EuSubSecteurMapper();
             $subsecteur = new Application_Model_EuSubSecteur();
             //Enregistrement dans la table eu_sub_secteur
			 $count = $msubsecteur->findConuter() + 1;
             $subsecteur->setId_sub_secteur($count);
             $subsecteur->setNom_sub_secteur(ucfirst($_POST["nom_sub_secteur"]));
             $subsecteur->setCode_secteur($_POST["code_secteur"]);
             $subsecteur->setCode_agence($_POST["code_agence"]);
			 $msubsecteur->save($subsecteur);
             return $this->_helper->redirector('index');
                
        }
		// Add the link to the cancel button
            $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
            $this->view->url(array('controller' => 'eu-canton','action' => 'index'), 'default', true) ."','_self')");

            $this->view->form = $form;
    }
   
   
   
    public function newoldeAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $users = $auth->getIdentity();
        $request = $this->getRequest();
        $form = new Application_Form_EuAgence();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                
                $ag->setCode_agence($code_agence);
                $ag->setCode_gac_create($users->code_acteur);
                $mapper->save($ag);
                return $this->_helper->redirector('index');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-canton',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");

        $this->view->form = $form;
    }

	
	
	
    public function editAction() {
        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuCanton();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        // action body
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout->enableLayout();
            if ($form->isValid($request->getPost())) {
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $canton = new Application_Model_EuSubSecteur($form->getValues());
                    $canton->setCode_secteur($this->_request->getPost("code_secteur"));
                    $canton->setCode_agence($this->_request->getPost("code_agence"));
                    $mapper = new Application_Model_EuSubSecteurMapper();
                    $mapper->update($canton);
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
            $id = $request->id_sub_secteur;
            $mapper = new Application_Model_EuSubSecteurMapper();
            $subsecteur = new Application_Model_EuSubSecteur();
            $mapper->find($id,$subsecteur);
            if ($subsecteur->getId_sub_secteur() == $id) {
                $data = array(
                 'id_sub_secteur' => $id,
                 'nom_sub_secteur' => utf8_encode($subsecteur->getNom_sub_secteur()),
				 'code_secteur' => $subsecteur->getCode_secteur(),
                 'code_agence' => $subsecteur->getCode_agence(),
                );
                $form->populate($data);
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-canton',
                    'action' => 'index'
                        ), 'default', true) .
                "','_self')");
        $this->view->form = $form;
    }




    

    public function getlibelleAction() {
           $data = array();
           $agence = new Application_Model_DbTable_EuSubSecteur();
           $select = $agence->select();
           $result = $agence->fetchAll($select);
           foreach ($result as $p) {
             $data[] = $p->nom_sub_secteur;
           }
           $this->view->data = $data;
    }

}

