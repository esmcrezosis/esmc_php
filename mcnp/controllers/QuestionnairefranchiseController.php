<?php

class QuestionnairefranchiseController extends Zend_Controller_Action{


    public function init() {
		/* Initialize action controller here */
        //include("Url.php");
	  }




    public function addquestionnairefranchiseAction()
    {
        /* page questionnairefranchise/addquestionnairefranchise - Ajout d'une questionnairefranchise */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['designation']) && $_POST['designation']!="" && isset($_POST['type_membre']) && $_POST['type_membre']!="") {
        
            
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $questionnairefranchise = new Application_Model_EuQuestionnaireFranchise();
        $m_questionnairefranchise = new Application_Model_EuQuestionnaireFranchiseMapper();
            
            $compteur = $m_questionnairefranchise->findConuter() + 1;
            $questionnairefranchise->setId_questionnaire_franchise($compteur);
            $questionnairefranchise->setDesignation($_POST['designation']);
            $questionnairefranchise->setCode_membre($_POST['code_membre']);
            $questionnairefranchise->setType_membre($_POST['type_membre']);
            $questionnairefranchise->setType_acteur($_POST['type_acteur']);
            $questionnairefranchise->setAvec_intermediaire($_POST['avec_intermediaire']);
            $questionnairefranchise->setSans_intermediaire($_POST['sans_intermediaire']);
            $questionnairefranchise->setAvec_abonne($_POST['avec_abonne']);
            $questionnairefranchise->setSans_abonne($_POST['sans_abonne']);
            $questionnairefranchise->setFiliere_biens($_POST['filiere_biens']);
            $questionnairefranchise->setFiliere_produits($_POST['filiere_produits']);
            $questionnairefranchise->setFiliere_services($_POST['filiere_services']);
            $questionnairefranchise->setAvec_stock($_POST['avec_stock']);
            $questionnairefranchise->setSans_stock($_POST['sans_stock']);
            $questionnairefranchise->setVente_enligne($_POST['vente_enligne']);
            $questionnairefranchise->setAccord_partenariat($_POST['accord_partenariat']);
            $questionnairefranchise->setCm_soi($_POST['cm_soi']);
            $questionnairefranchise->setCm_tiers($_POST['cm_tiers']);
            $questionnairefranchise->setCm_tiers_opi($_POST['cm_tiers_opi']);
            $questionnairefranchise->setCm_tiers_bps($_POST['cm_tiers_bps']);
            $questionnairefranchise->setKit_su_tic($_POST['kit_su_tic']);
            $questionnairefranchise->setKit_su_finance($_POST['kit_su_finance']);
            $questionnairefranchise->setKit_su_protection($_POST['kit_su_protection']);
            $questionnairefranchise->setKit_su_bcr($_POST['kit_su_bcr']);
            $questionnairefranchise->setKit_t_tic($_POST['kit_t_tic']);
            $questionnairefranchise->setKit_t_finance($_POST['kit_t_finance']);
            $questionnairefranchise->setKit_t_protection($_POST['kit_t_protection']);
            $questionnairefranchise->setKit_t_bcr($_POST['kit_t_bcr']);
            $questionnairefranchise->setTe_interim($_POST['te_interim']);
            $questionnairefranchise->setTe_utilisateur_ppc_op($_POST['te_utilisateur_ppc_op']);
            $questionnairefranchise->setTe_utilisateur_ppc_ot($_POST['te_utilisateur_ppc_ot']);
            $questionnairefranchise->setTe_utilisateur_pp($_POST['te_utilisateur_pp']);
            $questionnairefranchise->setFranchise($_POST['franchise']);
            $questionnairefranchise->setCaution($_POST['caution']);
            $questionnairefranchise->setEli_bai_anticipe($_POST['eli_bai_anticipe']);
            $questionnairefranchise->setEli_opi_anticipe($_POST['eli_opi_anticipe']);
            $questionnairefranchise->setEli_ban_anticipe($_POST['eli_ban_anticipe']);
            $questionnairefranchise->setAchat_vente_reciproque($_POST['achat_vente_reciproque']);
            $questionnairefranchise->setBudget_nature($_POST['budget_nature']);
            $questionnairefranchise->setId_utilisateur($_POST['id_utilisateur']);
            $questionnairefranchise->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $questionnairefranchise->setEtat($_POST['etat']);
            $m_questionnairefranchise->save($questionnairefranchise);
            
        $this->_redirect('/questionnairefranchise/listquestionnairefranchise');
        } else {  $this->view->error = "Champs * obligatoire ...";  } 
        }
        
    }


    public function editquestionnairefranchiseAction()
    {
        /* page questionnairefranchise/editquestionnairefranchise - Modification d'une questionnairefranchise */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
    if (isset($_POST['designation']) && $_POST['designation']!="" && isset($_POST['type_membre']) && $_POST['type_membre']!="") {
        
           
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $questionnairefranchise = new Application_Model_EuQuestionnaireFranchise();
        $m_questionnairefranchise = new Application_Model_EuQuestionnaireFranchiseMapper();
        $m_questionnairefranchise->find($_POST['id_questionnaire_franchise'], $questionnairefranchise);
            
            $questionnairefranchise->setDesignation($_POST['designation']);
            $questionnairefranchise->setCode_membre($_POST['code_membre']);
            $questionnairefranchise->setType_membre($_POST['type_membre']);
            $questionnairefranchise->setType_acteur($_POST['type_acteur']);
            $questionnairefranchise->setAvec_intermediaire($_POST['avec_intermediaire']);
            $questionnairefranchise->setSans_intermediaire($_POST['sans_intermediaire']);
            $questionnairefranchise->setAvec_abonne($_POST['avec_abonne']);
            $questionnairefranchise->setSans_abonne($_POST['sans_abonne']);
            $questionnairefranchise->setFiliere_biens($_POST['filiere_biens']);
            $questionnairefranchise->setFiliere_produits($_POST['filiere_produits']);
            $questionnairefranchise->setFiliere_services($_POST['filiere_services']);
            $questionnairefranchise->setAvec_stock($_POST['avec_stock']);
            $questionnairefranchise->setSans_stock($_POST['sans_stock']);
            $questionnairefranchise->setVente_enligne($_POST['vente_enligne']);
            $questionnairefranchise->setAccord_partenariat($_POST['accord_partenariat']);
            $questionnairefranchise->setCm_soi($_POST['cm_soi']);
            $questionnairefranchise->setCm_tiers($_POST['cm_tiers']);
            $questionnairefranchise->setCm_tiers_opi($_POST['cm_tiers_opi']);
            $questionnairefranchise->setCm_tiers_bps($_POST['cm_tiers_bps']);
            $questionnairefranchise->setKit_su_tic($_POST['kit_su_tic']);
            $questionnairefranchise->setKit_su_finance($_POST['kit_su_finance']);
            $questionnairefranchise->setKit_su_protection($_POST['kit_su_protection']);
            $questionnairefranchise->setKit_su_bcr($_POST['kit_su_bcr']);
            $questionnairefranchise->setKit_t_tic($_POST['kit_t_tic']);
            $questionnairefranchise->setKit_t_finance($_POST['kit_t_finance']);
            $questionnairefranchise->setKit_t_protection($_POST['kit_t_protection']);
            $questionnairefranchise->setKit_t_bcr($_POST['kit_t_bcr']);
            $questionnairefranchise->setTe_interim($_POST['te_interim']);
            $questionnairefranchise->setTe_utilisateur_ppc_op($_POST['te_utilisateur_ppc_op']);
            $questionnairefranchise->setTe_utilisateur_ppc_ot($_POST['te_utilisateur_ppc_ot']);
            $questionnairefranchise->setTe_utilisateur_pp($_POST['te_utilisateur_pp']);
            $questionnairefranchise->setFranchise($_POST['franchise']);
            $questionnairefranchise->setCaution($_POST['caution']);
            $questionnairefranchise->setEli_bai_anticipe($_POST['eli_bai_anticipe']);
            $questionnairefranchise->setEli_opi_anticipe($_POST['eli_opi_anticipe']);
            $questionnairefranchise->setEli_ban_anticipe($_POST['eli_ban_anticipe']);
            $questionnairefranchise->setAchat_vente_reciproque($_POST['achat_vente_reciproque']);
            $questionnairefranchise->setBudget_nature($_POST['budget_nature']);
            //$questionnairefranchise->setId_utilisateur($_POST['id_utilisateur']);
            //$questionnairefranchise->setDate_creation($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            //$questionnairefranchise->setEtat($_POST['etat']);
            $m_questionnairefranchise->update($questionnairefranchise);
            
        $this->_redirect('/questionnairefranchise/listquestionnairefranchise');
        } else {  $this->view->error = "Champs * obligatoire ..."; 
         
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $questionnairefranchise = new Application_Model_EuQuestionnaireFranchise();
        $m_questionnairefranchise = new Application_Model_EuQuestionnaireFranchiseMapper();
        $m_questionnairefranchise->find($id, $questionnairefranchise);
        $this->view->questionnairefranchise = $questionnairefranchise;
            }
    }
           
    } else {


            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $questionnairefranchise = new Application_Model_EuQuestionnaireFranchise();
        $m_questionnairefranchise = new Application_Model_EuQuestionnaireFranchiseMapper();
        $m_questionnairefranchise->find($id, $questionnairefranchise);
        $this->view->questionnairefranchise = $questionnairefranchise;
            }
    }
    }




    public function listquestionnairefranchiseadminAction()
    {
        /* page questionnairefranchise/listquestionnairefranchise - Liste des questionnairefranchises */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $questionnairefranchise = new Application_Model_EuQuestionnaireFranchiseMapper();
        $this->view->entries = $questionnairefranchise->fetchAll();

        $this->view->tabletri = 1;

    }


    public function listquestionnairefranchiseAction()
    {
        /* page questionnairefranchise/listquestionnairefranchise - Liste des questionnairefranchises */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

       $questionnairefranchise = new Application_Model_EuQuestionnaireFranchiseMapper();
        $this->view->entries = $questionnairefranchise->fetchAllByUtilisateur($sessionutilisateur->id_utilisateur);

        $this->view->tabletri = 1;

    }



    public function suppquestionnairefranchiseAction()
    {
        /* page questionnairefranchise/suppquestionnairefranchise - Suppression d'une questionnairefranchise */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $questionnairefranchise = new Application_Model_EuProcedure();
        $m_questionnairefranchise = new Application_Model_EuProcedureMapper();
        $m_questionnairefranchise->find($id, $questionnairefranchise);
        
        $m_questionnairefranchise->delete($questionnairefranchise->id_questionnaire_franchise);

        }

        $this->_redirect('/questionnairefranchise/listquestionnairefranchise');
    }


    public function detailsquestionnairefranchiseAction() 
    {
        /* page questionnairefranchise/detailsquestionnairefranchise - Detail d'une questionnairefranchise */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
        $questionnairefranchise = new Application_Model_EuQuestionnaireFranchise();
        $m_questionnairefranchise = new Application_Model_EuQuestionnaireFranchiseMapper();
        $m_questionnairefranchise->find($id, $questionnairefranchise);
        $this->view->questionnairefranchise = $questionnairefranchise;

            }

    }


    public function etatquestionnairefranchiseAction()
    {
        /* page questionnairefranchise/etatquestionnairefranchise - Etat une questionnairefranchise */

        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
        
    if (!isset($sessionutilisateur->login)) {$this->_redirect('/administration/login');}
if($sessionutilisateur->confirmation != ""){$this->_redirect('/administration/confirmation');}

        $id = (int) $this->_request->getParam('id');
        if (isset($id) && $id != 0) {

        $questionnairefranchise = new Application_Model_EuQuestionnaireFranchise();
        $m_questionnairefranchise = new Application_Model_EuQuestionnaireFranchiseMapper();
        $m_questionnairefranchise->find($id, $questionnairefranchise);
        
        $questionnairefranchise->setEtat($this->_request->getParam('etat'));
        $m_questionnairefranchise->update($questionnairefranchise);
        }

        $this->_redirect('/questionnairefranchise/listquestionnairefranchise');
    }





























}
