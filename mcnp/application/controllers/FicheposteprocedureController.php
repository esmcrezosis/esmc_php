<?php

class FicheposteprocedureController extends Zend_Controller_Action{



  public function schemaproceduretechnopoleachatAction () {

  }

  
  public function schemaprocedurestockAction () {
      
  }

  public function schemaprocedureimmobilisationAction () {


  }

  public function schemaproceduretechopolegestionotAction () {
      
  }

  public function fichepostedivisionasectionAction () {

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

    $sessionmembre = new Zend_Session_Namespace('membre');

    $db = Zend_Db_Table::getDefaultAdapter();

    $fullNameCurrentAgent = "";

    $fullNameDirectCollaborator = "";   

    if (isset($sessionutilisateur)){


        $libelleOfCurrentUser = $sessionutilisateur->libelle_current_user;

        $typeCentre = $sessionutilisateur->type_centre;
    
        $libelleOfDirectCollaborator = $sessionutilisateur->libelle_collaborateur_direct;
    
        $fullNameCurrentAgent = "AGENT $libelleOfCurrentUser GIE ESMC ODD $typeCentre";
    
        $fullNameDirectCollaborator = "$libelleOfDirectCollaborator GIE ESMC ODD $typeCentre";

    }

    if (isset($sessionmembre))
    {

            $post = (int)$this->_request->getParam('post');
    
            $parentpost = (int)$this->_request->getParam('parentpost');
    
            $typeCentre = (string)$this->_request->getParam('typecentre');
    
                
            $dbgetnamepostes = "SELECT eu_roles.libelle_roles

                                FROM eu_roles
                                           
                                WHERE eu_roles.id_roles = $post";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtgetnamepostes = $db->query($dbgetnamepostes);

            $getnamepostes = $stmtgetnamepostes->fetchAll();

            $dbgetnameposteduparent = "SELECT eu_roles.libelle_roles

                                       FROM eu_roles
                                           
                                       WHERE eu_roles.parent_roles_id = $post";

            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            $stmtgetnameposteduparent = $db->query($dbgetnameposteduparent);

            $getnameposteduparent = $stmtgetnameposteduparent->fetchAll();

            $name_post = $getnamepostes[0]->libelle_roles;

            $name_parent_postes = $getnameposteduparent[0]->libelle_roles;


            $fullNameCurrentAgent = "AGENT $name_post GIE ESMC ODD $typeCentre";
        
            $fullNameDirectCollaborator = "$name_parent_postes GIE ESMC ODD $typeCentre";
            
    }
    
    $this->view->current_user = $fullNameCurrentAgent;

    $this->view->direct_collaborator = $fullNameDirectCollaborator;

  }

  public function fichepostesoussectionasouscelluleAction () {

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

    $fullNameCurrentAgent = "";

    $fullNameDirectCollaborator = "";   

    if (isset($sessionutilisateur)){


        $libelleOfCurrentUser = $sessionutilisateur->libelle_current_user;

        $typeCentre = $sessionutilisateur->type_centre;
    
        $libelleOfDirectCollaborator = $sessionutilisateur->libelle_collaborateur_direct;
    
        $fullNameCurrentAgent = "AGENT $libelleOfCurrentUser GIE ESMC ODD $typeCentre";
    
        $fullNameDirectCollaborator = "$libelleOfDirectCollaborator GIE ESMC ODD $typeCentre";

    }else {

        $post = (string)$this->_request->getParam('post');

        $parentpost = (string)$this->_request->getParam('parentpost');

        $typecentre = (string)$this->_request->getParam('typecentre');

            
        $fullNameCurrentAgent = "AGENT $post GIE ESMC ODD $typecentre";
    
        $fullNameDirectCollaborator = "$parentpost GIE ESMC ODD $typecentre";
        
    }
    
    $this->view->current_user = $fullNameCurrentAgent;

    $this->view->direct_collaborator = $fullNameDirectCollaborator;

  }
 
  public function adminprincipaltechdetentriceAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  }

  public function technopoleprincipalAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  }

  public function acnevprincipalAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  }

  public function filiereprincipalAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      
  }

  public function techadministratifAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
      
    if ($id == 0){
        $pagetitle = "Agent Technopole Administratif";
        $postehierarchique = "G??rant";       
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
  }

 public function achatAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole Achats";
        $postehierarchique = "Agent Technopole Administratif";
    }

    if ($id == 2){
        $pagetitle = "Agent CAC Gestionnaire des Achats";
        $postehierarchique = "Agent CAC Administratif";
        
        
    }

    if ($id == 3){
        $pagetitle = "Agent CPC Gestionnaire des Achats ";
        $postehierarchique = "Agent CPC Administratif";
        
        
    }

    if ($id == 4){
        $pagetitle = "Agent CTC Gestionnaire des Achats";
        $postehierarchique = "Agent CTC Administratif";
        
        
    }

    if ($id == 5){
        $pagetitle = "Agent CVC Gestionnaire des Achats";
        $postehierarchique = "Agent CVC Administratif";
        
        
        
    }

    if ($id == 6){
        $pagetitle = "Agent GUIU CAC Gestionnaire des Achats ";
        $postehierarchique = "Agent GUIU CAC Administratif ";
        
        
    }

    if ($id == 7){
        $pagetitle = "Agent GUIU CPC Gestionnaire des Achats ";
        $postehierarchique = "Agent GUIU CPC Administratif ";
        
        
    }

    if ($id == 8){
        $pagetitle = "Agent GUIU CTC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIU CTC Administratif ";

        
    }

    if ($id == 9){
        $pagetitle = "Agent GUIU CVC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIU CVC Administratif ";
        
    }

    if ($id == 10){
        $pagetitle = "Agent GUIUIC CAC Gestionnaire des Achats ";
        $postehierarchique = "Agent GUIUIC CAC Administratif ";
        
    }

    if ($id == 11){
        $pagetitle = "Agent GUIUIC CPC Gestionnaire des Achats ";
        $postehierarchique = "Agent GUIUIC CPC Administratif ";
        
    }

    if ($id == 12){
        $pagetitle = "Agent GUIUIC CTC Gestionnaire des Achats ";
        $postehierarchique = "Agent GUIUIC CTC Administratif ";
        
    }

    if ($id == 13){
        $pagetitle = "Agent GUIUIC CVC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIUIC CVC Administratif ";
        
    }

    if ($id == 14){
        $pagetitle = "Agent GUIUIPODD CAC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIUIPODD CAC Administratif ";
        
    }

    if ($id == 15){
        $pagetitle = "Agent GUIUIPODD CPC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIUIPODD CPC Administratif ";
        
    }

    if ($id == 16){
        $pagetitle = "Agent GUIUIPODD CTC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIUIPODD CTC Administratif ";
        
    }

    if ($id == 17){
        $pagetitle = "Agent GUIUIPODD CVC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIUIPODD CVC Administratif ";
        
    }

    if ($id == 18){
        $pagetitle = "Agent GUIUIU CAC Gestionnaire des Achats";
        $postehierarchique = "Agent GGUIUIU CAC Administratif ";
        
    }
    if ($id == 19){
        $pagetitle = "Agent GUIUIU CPC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIUIU CPC Administratif ";
        
    }

    if ($id == 20){
        $pagetitle = "Agent GUIUIU CTC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIUIU CTC Administratif ";
        
    }
    if ($id == 21){
        $pagetitle = "Agent GUIUIU CVC Gestionnaire des Achats";
        $postehierarchique = "Agent GUIUIU CVC Administratif ";
        
    }



    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
    

 }

 public function stockAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    $id = (int)$this->_request->getParam('id');
    

    if ($id == 1){
        $pagetitle = "Agent Technopole Stocks";
        $postehierarchique = "Agent Technopole Administratif";
    }

    if ($id == 2){
        $pagetitle = "Agent CAC Gestionnaire des Stocks";
        $postehierarchique = "Agent CAC Administratif";
        
        
    }

    if ($id == 3){
        $pagetitle = "Agent CPC Gestionnaire des Stocks ";
        $postehierarchique = "Agent CPC Administratif";
        
        
    }

    if ($id == 4){
        $pagetitle = "Agent CTC Gestionnaire des Stocks";
        $postehierarchique = "Agent CTC Administratif";
        
        
    }

    if ($id == 5){
        $pagetitle = "Agent CVC Gestionnaire des Stocks";
        $postehierarchique = "Agent CVC Administratif";
        
        
        
    }

    if ($id == 6){
        $pagetitle = "Agent GUIU CAC Gestionnaire des Stocks ";
        $postehierarchique = "Agent GUIU CAC Administratif ";
        
        
    }

    if ($id == 7){
        $pagetitle = "Agent GUIU CPC Gestionnaire des Stocks ";
        $postehierarchique = "Agent GUIU CPC Administratif ";
        
        
    }

    if ($id == 8){
        $pagetitle = "Agent GUIU CTC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIU CTC Administratif ";

        
    }

    if ($id == 9){
        $pagetitle = "Agent GUIU CVC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIU CVC Administratif ";
        
    }

    if ($id == 10){
        $pagetitle = "Agent GUIUIC CAC Gestionnaire des Stocks ";
        $postehierarchique = "Agent GUIUIC CAC Administratif ";
        
    }

    if ($id == 11){
        $pagetitle = "Agent GUIUIC CPC Gestionnaire des Stocks ";
        $postehierarchique = "Agent GUIUIC CPC Administratif ";
        
    }

    if ($id == 12){
        $pagetitle = "Agent GUIUIC CTC Gestionnaire des Stocks ";
        $postehierarchique = "Agent GUIUIC CTC Administratif ";
        
    }

    if ($id == 13){
        $pagetitle = "Agent GUIUIC CVC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIUIC CVC Administratif ";
        
    }

    if ($id == 14){
        $pagetitle = "Agent GUIUIPODD CAC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIUIPODD CAC Administratif ";
        
    }

    if ($id == 15){
        $pagetitle = "Agent GUIUIPODD CPC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIUIPODD CPC Administratif ";
        
    }

    if ($id == 16){
        $pagetitle = "Agent GUIUIPODD CTC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIUIPODD CTC Administratif ";
        
    }

    if ($id == 17){
        $pagetitle = "Agent GUIUIPODD CVC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIUIPODD CVC Administratif ";
        
    }

    if ($id == 18){
        $pagetitle = "Agent GUIUIU CAC Gestionnaire des Stocks";
        $postehierarchique = "Agent GGUIUIU CAC Administratif ";
        
    }
    if ($id == 19){
        $pagetitle = "Agent GUIUIU CPC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIUIU CPC Administratif ";
        
    }

    if ($id == 20){
        $pagetitle = "Agent GUIUIU CTC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIUIU CTC Administratif ";
        
    }
    if ($id == 21){
        $pagetitle = "Agent GUIUIU CVC Gestionnaire des Stocks";
        $postehierarchique = "Agent GUIUIU CVC Administratif ";
        
    }



    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function immobilisationAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     

    
    if ($id == 1){
        $pagetitle = "Agent Technopole Gestionnaire des Immobilisations";
        $postehierarchique = "Agent Technopole Administratif";
    }

    if ($id == 2){
        $pagetitle = "Agent CAC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent CAC Administratif";
        
        
    }

    if ($id == 3){
        $pagetitle = "Agent CPC Gestionnaire des Immobilisations ";
        $postehierarchique = "Agent CPC Administratif";
        
        
    }

    if ($id == 4){
        $pagetitle = "Agent CTC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent CTC Administratif";
        
        
    }

    if ($id == 5){
        $pagetitle = "Agent CVC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent CVC Administratif";
        
        
        
    }

    if ($id == 6){
        $pagetitle = "Agent GUIU CAC Gestionnaire des Immobilisations ";
        $postehierarchique = "Agent GUIU CAC Administratif ";
        
        
    }

    if ($id == 7){
        $pagetitle = "Agent GUIU CPC Gestionnaire des Immobilisations ";
        $postehierarchique = "Agent GUIU CPC Administratif ";
        
        
    }

    if ($id == 8){
        $pagetitle = "Agent GUIU CTC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIU CTC Administratif ";

        
    }

    if ($id == 9){
        $pagetitle = "Agent GUIU CVC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIU CVC Administratif ";
        
    }

    if ($id == 10){
        $pagetitle = "Agent GUIUIC CAC Gestionnaire des Immobilisations ";
        $postehierarchique = "Agent GUIUIC CAC Administratif ";
        
    }

    if ($id == 11){
        $pagetitle = "Agent GUIUIC CPC Gestionnaire des Immobilisations ";
        $postehierarchique = "Agent GUIUIC CPC Administratif ";
        
    }

    if ($id == 12){
        $pagetitle = "Agent GUIUIC CTC Gestionnaire des Immobilisations ";
        $postehierarchique = "Agent GUIUIC CTC Administratif ";
        
    }

    if ($id == 13){
        $pagetitle = "Agent GUIUIC CVC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIUIC CVC Administratif ";
        
    }

    if ($id == 14){
        $pagetitle = "Agent GUIUIPODD CAC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIUIPODD CAC Administratif ";
        
    }

    if ($id == 15){
        $pagetitle = "Agent GUIUIPODD CPC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIUIPODD CPC Administratif ";
        
    }

    if ($id == 16){
        $pagetitle = "Agent GUIUIPODD CTC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIUIPODD CTC Administratif ";
        
    }

    if ($id == 17){
        $pagetitle = "Agent GUIUIPODD CVC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIUIPODD CVC Administratif ";
        
    }

    if ($id == 18){
        $pagetitle = "Agent GUIUIU CAC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GGUIUIU CAC Administratif ";
        
    }
    if ($id == 19){
        $pagetitle = "Agent GUIUIU CPC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIUIU CPC Administratif ";
        
    }

    if ($id == 20){
        $pagetitle = "Agent GUIUIU CTC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIUIU CTC Administratif ";
        
    }
    if ($id == 21){
        $pagetitle = "Agent GUIUIU CVC Gestionnaire des Immobilisations";
        $postehierarchique = "Agent GUIUIU CVC Administratif ";
        
    }

    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;

 }

 public function juridiqueAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole Juridique";
        $postehierarchique = "G??rant";
    }
    
    if ($id == 2){
        $pagetitle = "Agent CAC Juridique";
        $postehierarchique = "G??rant";
        
        
    }
    
    if ($id == 3){
        $pagetitle = "Agent CPC Juridique ";
        $postehierarchique = "G??rant";
        
        
    }
    
    if ($id == 4){
        $pagetitle = "Agent CTC Juridique";
        $postehierarchique = "G??rant";
    
    }
    
    if ($id == 5){
        $pagetitle = "Agent CVC Juridique";
        $postehierarchique = "G??rant";
        
        
        
    }
    
    if ($id == 6){
        $pagetitle = "Agent GUIU CAC Juridique ";
        $postehierarchique = "G??rant";
        
        
    }
    
    if ($id == 7){
        $pagetitle = "Agent GUIU CPC Juridique ";
        $postehierarchique = "G??rant";
        
        
    }
    
    if ($id == 8){
        $pagetitle = "Agent GUIU CTC Juridique";
        $postehierarchique = "G??rant";
    
        
    }
    
    if ($id == 9){
        $pagetitle = "Agent GUIU CVC Juridique";
        $postehierarchique = "G??rant";
        
    }
    
    if ($id == 10){
        $pagetitle = "Agent GUIUIC CAC Juridique ";
        $postehierarchique = "G??rant";
        
    }
    
    if ($id == 11){
        $pagetitle = "Agent GUIUIC CPC Juridique ";
        $postehierarchique = "Agent GUIUIC CPC Administratif ";
        
    }
    
    if ($id == 12){
        $pagetitle = "Agent GUIUIC CTC Juridique ";
        $postehierarchique = "Agent GUIUIC CTC Administratif ";
        
    }
    
    if ($id == 13){
        $pagetitle = "Agent GUIUIC CVC Juridique";
        $postehierarchique = "G??rant";
        
    }
    
    if ($id == 14){
        $pagetitle = "Agent GUIUIPODD CAC Juridique";
        $postehierarchique = "G??rant";
        
    }
    
    if ($id == 15){
        $pagetitle = "Agent GUIUIPODD CPC Juridique";
        $postehierarchique = "G??rant";
        
    }
    
    if ($id == 16){
        $pagetitle = "Agent GUIUIPODD CTC Juridique";
        $postehierarchique = "G??rant";
        
    }
    
    if ($id == 17){
        $pagetitle = "Agent GUIUIPODD CVC Juridique";
        $postehierarchique = "G??rant";
        
    }
    
    if ($id == 18){
        $pagetitle = "Agent GUIUIU CAC Juridique";
        $postehierarchique = "G??rant";
        
    }
    if ($id == 19){
        $pagetitle = "Agent GUIUIU CPC Juridique";
        $postehierarchique = "G??rant";
        
    }
    
    if ($id == 20){
        $pagetitle = "Agent GUIUIU CTC Juridique";
        $postehierarchique = "G??rant";
        
    }
    if ($id == 21){
        $pagetitle = "Agent GUIUIU CVC Juridique";
        $postehierarchique = "G??rant ";
        
    }
    
    
    
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function ressourceshumaineAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

if ($id == 1){
    $pagetitle = "Agent Technopole Ressources Humaines";
    $postehierarchique = "G??rant";
}

if ($id == 2){
    $pagetitle = "Agent CAC Ressources Humaines";
    $postehierarchique = "G??rant";
    
    
}

if ($id == 3){
    $pagetitle = "Agent CPC Ressources Humaines ";
    $postehierarchique = "G??rant";
    
    
}

if ($id == 4){
    $pagetitle = "Agent CTC Ressources Humaines";
    $postehierarchique = "G??rant";

}

if ($id == 5){
    $pagetitle = "Agent CVC Ressources Humaines";
    $postehierarchique = "G??rant";
    
    
    
}

if ($id == 6){
    $pagetitle = "Agent GUIU CAC Ressources Humaines ";
    $postehierarchique = "G??rant";
    
    
}

if ($id == 7){
    $pagetitle = "Agent GUIU CPC Ressources Humaines ";
    $postehierarchique = "G??rant";
    
    
}

if ($id == 8){
    $pagetitle = "Agent GUIU CTC Ressources Humaines";
    $postehierarchique = "G??rant";

    
}

if ($id == 9){
    $pagetitle = "Agent GUIU CVC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}

if ($id == 10){
    $pagetitle = "Agent GUIUIC CAC Ressources Humaines ";
    $postehierarchique = "G??rant";
    
}

if ($id == 11){
    $pagetitle = "Agent GUIUIC CPC Ressources Humaines ";
    $postehierarchique = "Agent GUIUIC CPC Administratif ";
    
}

if ($id == 12){
    $pagetitle = "Agent GUIUIC CTC Ressources Humaines ";
    $postehierarchique = "Agent GUIUIC CTC Administratif ";
    
}

if ($id == 13){
    $pagetitle = "Agent GUIUIC CVC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}

if ($id == 14){
    $pagetitle = "Agent GUIUIPODD CAC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}

if ($id == 15){
    $pagetitle = "Agent GUIUIPODD CPC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}

if ($id == 16){
    $pagetitle = "Agent GUIUIPODD CTC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}

if ($id == 17){
    $pagetitle = "Agent GUIUIPODD CVC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}

if ($id == 18){
    $pagetitle = "Agent GUIUIU CAC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}
if ($id == 19){
    $pagetitle = "Agent GUIUIU CPC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}

if ($id == 20){
    $pagetitle = "Agent GUIUIU CTC Ressources Humaines";
    $postehierarchique = "G??rant";
    
}
if ($id == 21){
    $pagetitle = "Agent GUIUIU CVC Ressources Humaines";
    $postehierarchique = "G??rant ";
    
}



$this->view->pagetitle = $pagetitle;
$this->view->postehierarchique = $postehierarchique;
 }

 public function secretaireAction () {
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

if ($id == 1){
    $pagetitle = "Agent Technopole Secr??taire Administratif";
    $postehierarchique = "G??rant";
}

if ($id == 2){
    $pagetitle = "Agent CAC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
    
}

if ($id == 3){
    $pagetitle = "Agent CPC Secr??taire Administratif ";
    $postehierarchique = "G??rant";
    
    
}

if ($id == 4){
    $pagetitle = "Agent CTC Secr??taire Administratif";
    $postehierarchique = "G??rant";

}

if ($id == 5){
    $pagetitle = "Agent CVC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
    
    
}

if ($id == 6){
    $pagetitle = "Agent GUIU CAC Secr??taire Administratif ";
    $postehierarchique = "G??rant";
    
    
}

if ($id == 7){
    $pagetitle = "Agent GUIU CPC Secr??taire Administratif ";
    $postehierarchique = "G??rant";
    
    
}

if ($id == 8){
    $pagetitle = "Agent GUIU CTC Secr??taire Administratif";
    $postehierarchique = "G??rant";

    
}

if ($id == 9){
    $pagetitle = "Agent GUIU CVC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}

if ($id == 10){
    $pagetitle = "Agent GUIUIC CAC Secr??taire Administratif ";
    $postehierarchique = "G??rant";
    
}

if ($id == 11){
    $pagetitle = "Agent GUIUIC CPC Secr??taire Administratif ";
    $postehierarchique = "Agent GUIUIC CPC Administratif ";
    
}

if ($id == 12){
    $pagetitle = "Agent GUIUIC CTC Secr??taire Administratif ";
    $postehierarchique = "Agent GUIUIC CTC Administratif ";
    
}

if ($id == 13){
    $pagetitle = "Agent GUIUIC CVC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}

if ($id == 14){
    $pagetitle = "Agent GUIUIPODD CAC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}

if ($id == 15){
    $pagetitle = "Agent GUIUIPODD CPC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}

if ($id == 16){
    $pagetitle = "Agent GUIUIPODD CTC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}

if ($id == 17){
    $pagetitle = "Agent GUIUIPODD CVC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}

if ($id == 18){
    $pagetitle = "Agent GUIUIU CAC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}
if ($id == 19){
    $pagetitle = "Agent GUIUIU CPC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}

if ($id == 20){
    $pagetitle = "Agent GUIUIU CTC Secr??taire Administratif";
    $postehierarchique = "G??rant";
    
}
if ($id == 21){
    $pagetitle = "Agent GUIUIU CVC Secr??taire Administratif";
    $postehierarchique = "G??rant ";
    
}



$this->view->pagetitle = $pagetitle;
$this->view->postehierarchique = $postehierarchique;
 }

 public function amenagementetconstructionAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole Amenagement & Construction";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function connectiviteAction () {
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole Connectivit??";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function developpementAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole D??veloppement";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function energietelectriciteAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole Energie Electrique";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function entretienAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole Entretien";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function reseauetsystemeAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole R??seaux et Syst??me";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function securiteAction () {
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole S??curit??";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function servicesgenerauxAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole Services g??n??raux";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function supportAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Technopole Support";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }


 public function budgetAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Fili??re Budget";
        $postehierarchique = "Agent Fili??re Financier";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function comptabiliteAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Fili??re Comptable";
        $postehierarchique = "Agent Fili??re Financier";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function auditetcontrolAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Fili??re Audit et Contr??le G??n??rale";
        $postehierarchique = "G??rant";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function financierAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Fili??re financier";
        $postehierarchique = "Agent Fili??re Financier";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function tresorerieAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "Agent Fili??re Tr??sorerie";
        $postehierarchique = "Agent Fili??re Finances";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function mobilisationAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Fili??re Mobilisation";
        $postehierarchique = "Agent Fili??re Finances";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function souscriptionAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Souscription";
        $postehierarchique = "Agent Acnev Souscription";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function expressionAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Expression";
        $postehierarchique = "Agent Acnev Expression";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function reglementAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Reglement";
        $postehierarchique = "Agent Acnev Reglement";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function rapprochementAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Rapprochement";
        $postehierarchique = "Agent Acnev Rapprochement";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function compensationAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Compensation";
        $postehierarchique = "Agent Acnev Compensation";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function annulationAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Annulation";
        $postehierarchique = "Agent Acnev Annulation";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function archivageAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Archivage";
        $postehierarchique = "Agent Acnev Archivage";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function destructionAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Destruction";
        $postehierarchique = "Agent Acnev Destruction";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 
 public function tableaudebordAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Tableau de Bord";
        $postehierarchique = "Agent Acnev Tableau de Bord";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 
 public function multimediaAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Multimedia";
        $postehierarchique = "Agent Acnev Multimedia";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 public function reseausocialAction () {
	 $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Reseau Sociaux";
        $postehierarchique = "Agent Acnev Reseau Sociaux";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }

 
 public function digitalAction () {
    $id = (int)$this->_request->getParam('id');
     
    if ($id == 1){
        $pagetitle = "Agent Acnev Digital";
        $postehierarchique = "Agent Acnev Digital";
    }
    $this->view->pagetitle = $pagetitle;
    $this->view->postehierarchique = $postehierarchique;
 }
 public function detentriceAction () {
	$this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    $id = (int)$this->_request->getParam('id');

    if ($id == 1){
        $pagetitle = "TETE DE DIVISION FILIERE / SURVEILLANCE";
    }
    $this->view->pagetitle = $pagetitle;
 }


}