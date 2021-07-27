<?php
class Index2Controller extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
    }

    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $this->view->user = $user;
            $gp_user = $user->code_groupe;
            if ($gp_user == 'admin') {
                $menu = "<li><a href=\" /eu-agence/new \">Ajouter une agence</a></li>" .
                        "<li><a href=\" /eu-secteur/new \">Ajouter un secteur</a></li>" .
                        "<li><a href=\" /eu-zone/new \">Ajouter une zone</a></li>" .
                        "<li><a href=\" /categorie/new \">Ajouter une catégorie</a></li>" .
                        "<li><a href=\" /eu-produit/new \">Ajouter un produit</a></li>" .
                        "<li><a href=\" /eu-user/new \">Ajouter un utilisateur</a></li>".
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            } 
			/*else if ($gp_user == 'agregat') {
                $menu = "<li><a id=\"gac\" href=\"/eu-gac/new#\">Ajouter une gac</a></li>" .
                        "<li><a id=\"compteg\" href=\"/eu-gac/allocgac#\">Allouer investissement</a></li>".
                        "<li><a id=\"compteg\" href=\"/eu-gac/allocgacsal#\">Allouer salaire</a></li>".
						"<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            }*/ else if ($gp_user == 'gac' || $gp_user == 'gacp' || $gp_user == 'gacr' || $gp_user == 'gacs' || $gp_user == 'gaca' || $gp_user == 'gac_pbf' || $gp_user == 'gacp_pbf' || $gp_user == 'gacr_pbf' || $gp_user == 'gacs_pbf' || $gp_user == 'gaca_pbf') {
                $menu = "<li><a href=\"/eu-gac-filiere/new\">Ajouter une gac Filière</a></li>" .
                        "<li><a id=\"new\" href=\"/eu-besoin/new\">Exprimer un besoin</a></li>" .
                        "<li><a id=\"new\" href=\"/eu-proforma/new\">Etablir un proforma</a></li>" .
                        "<li><a href=\" /eu-budget/new \">Budget investissement</a></li>" .
                        "<li><a href=\"/eu-smcipn/newsmcipn \">Demande smcipn</a></li>" .
                        "<li><a href=\"/eu-smcipnp/newsmcipnp \">Demande smcipnp</a></li>" .
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            } else if ($gp_user == 'filiere' || $gp_user == 'filiere_pbf') {
                $menu = "<li><a href=\" /eu-creneau/new\">Ajouter un créneau</a></li>" .
                        "<li><a id=\"new\" href=\"/eu-besoin/new\">Exprimer un besoin</a></li>" .
                        "<li><a id=\"new\" href=\"/eu-proforma/new\">Etablir un proforma</a></li>" .
                        "<li><a href=\" /eu-budget/new \">Budget investissement</a></li>" .
                        "<li><a href=\"/eu-smcipn/newsmcipn \">Demande smcipn</a></li>" .
                        "<li><a href=\"/eu-smcipnp/newsmcipnp \">Demande smcipnp</a></li>" .
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            } else if ($gp_user == 'creneau' || $gp_user == 'creneau_pbf') {
                $menu = "<li><a href=\" /eu-acteur-creneau/new \">Ajouter un acteur créneau</a></li>" .
                        "<li><a id=\"new\" href=\"/eu-besoin/new\">Exprimer un besoin</a></li>" .
                        "<li><a id=\"new\" href=\"/eu-proforma/new\">Etablir un proforma</a></li>" .
                        "<li><a href=\" /eu-budget/new \">Budget investissement</a></li>" .
                        "<li><a href=\"/eu-smcipn/newsmcipn \">Demande smcipn</a></li>" .
                        "<li><a href=\"/eu-smcipnp/newsmcipnp \">Demande smcipnp</a></li>" .
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            } else if ($gp_user == 'acteur' || $gp_user == 'acteur_pbf') {
                $menu = "<li><a id=\"new\" href=\"/eu-besoin/new\">Exprimer un besoin</a></li>" .
                        "<li><a id=\"new\" href=\"/eu-proforma/new\">Etablir un proforma</a></li>" .
                        "<li><a href=\" /eu-budget/new \">Budget investissement</a></li>" .
                        "<li><a href=\"/eu-smcipn/newsmcipn \">Demande smcipn</a></li>" .
                        "<li><a href=\"/eu-smcipnp/newsmcipnp \">Demande smcipnp</a></li>" .
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            } else if ($gp_user == 'assurance' || $gp_user == 'ass_smcii' || $gp_user == 'ass_smcpnw') {
                $menu = "<li><a href=\"/eu-domiciliation/domicilier \">Domiciliation prk</a></li>" .
                        "<li><a href=\"/eu-domiciliation/domicilierimm \">Domiciliation pre</a></li>" .
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            } else if ($gp_user == 'ass_smcip' || $gp_user == 'ass_smcpnp') {
                $menu = "<li><a href=\"/eu-smcipnp/domicilier \">Domiciliation prk</a></li>" .
                        "<li><a href=\"/eu-smcipnp/domicilierimm \">Domiciliation pre</a></li>" .
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            } else if ($gp_user == 'alerte') {
                $menu = "<li><a href=\" /eu-alerte/new \">Nouvelle alerte</a></li>" .
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            } else if ($gp_user == 'acnev') {
                $menu = "<li><a href=\"/eu-smcipnp/domicilier \">Domiciliation prk</a></li>" .
                        "<li><a href=\"/eu-smcipnp/domicilierimm \">Domiciliation pre</a></li>" .
                        "<li><a href=\"/eu-smcipnp/newsmcipnp \">Demande smcipnp</a></li>" .
                        "<li><a href=\"/eu-smcipnp/newsmcipnpsans \">Demande smcipnp sans domiciliation</a></li>" .
                        "<li><a href=\"/eu-smcipnp/transfert\">Transfert ti / tpn</a></li>" .
                        "<li><a href=\"/eu-smcipnp/affectersalaire\">Affectation salaire</a></li>" .
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
            }
        }
    }

    public function indexAction() {
        // action body
        //$this->render('topmenu', 'topmenu');
    }

}
?>

