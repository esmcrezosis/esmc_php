<?php
class InscriptionpbfController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
include("Url.php");   
    }

    


    public function faippdfppAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfFAIPPP($membre);

$this->_redirect(Util_Utils::genererPdfFAIPPP($membre));

    }




    public function faippdfpmAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfFAIPPM($membre);

$this->_redirect(Util_Utils::genererPdfFAIPPM($membre));

    }





    public function ceclpdfppAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfCECLPP($membre);

$this->_redirect(Util_Utils::genererPdfCECLPP($membre));

    }




    public function ceclpdfpmAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfCECLPM($membre);

$this->_redirect(Util_Utils::genererPdfCECLPM($membre));

    }




    public function mecitpdfppAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfMECITPP($membre);

$this->_redirect(Util_Utils::genererPdfMECITPP($membre));

    }




    public function mecitpdfpmAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfMECITPM($membre);

$this->_redirect(Util_Utils::genererPdfMECITPM($membre));

    }




    public function mecipdfppAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfMECIPP($membre);

$this->_redirect(Util_Utils::genererPdfMECIPP($membre));

    }




    public function mecipdfpmAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfMECIPM($membre);

$this->_redirect(Util_Utils::genererPdfMECIPM($membre));

    }






    public function mutualpdfppAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfMUTUALPP($membre);

$this->_redirect(Util_Utils::genererPdfMUTUALPP($membre));

    }




    public function mutualpdfpmAction() {
        $sessionmcnp = new Zend_Session_Namespace('mcnp');

        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');

        $membre = (string)$this->_request->getParam('membre');
        $this->view->membre = $membre;

        //Util_Utils::genererPdfMUTUALPM($membre);

$this->_redirect(Util_Utils::genererPdfMUTUALPM($membre));

    }




    public  function listmembrefifovaliderAction()  {
        
            $sessionbanqueopi = new Zend_Session_Namespace('banqueopi');
        //$this->_helper->layout->disableLayout();
        $this->_helper->layout()->setLayout('layoutpublicesmc');
        
    if (!isset($sessionbanqueopi->login)) {$this->_redirect('/banqueopi/login');}
//if($sessionbanqueopi->confirmation != ""){$this->_redirect('/banqueopi/confirmation');}
        
        $db_mstierslistebc = new Application_Model_DbTable_EuMstiersListebc();
        $select = $db_mstierslistebc->select();
        $select->where('statut = ?',0);
        $select->where('type_liste like ?',"SansListe");        
        $entries = $db_mstierslistebc->fetchAll($select);
        $this->view->entries = $entries;
        $this->view->tabletri = 1;
    }
    


}
