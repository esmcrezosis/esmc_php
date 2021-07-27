<?php
class EuMembreController extends Zend_Controller_Action  {

      public function init()   {
        /* Initialize action controller here */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $group = trim($user->code_groupe);
		$date_id = new Zend_Date(Zend_Date::ISO_8601);
        $date_idd = clone $date_id;
		
        if(($group == 'cm' or $group == 'dg')) {
		    $menu = "<li><a id=\"new\" href=\"/eu-membre/new\" style=\"font-size:11px\">Ajout MPP</a></li>" .
                    //"<li><a id=\"\" href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>" .
					"<li><a id=\"cmfh\" href=\"/eu-membre/cmfh\" style=\"font-size:11px\">Ajout CMFH</a></li>".
                    "<li><a id=\"\" href=\"/eu-membre/physique\" style=\"font-size:11px\">Personnes physiques</a></li>".
				    //"<li><a id=\"\" href=\"/eu-membre/verifier\" style=\"font-size:11px\">Tableau de bord fs</a></li>" .
                    "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                    $this->view->placeholder("menu")->set($menu);
		}
		else if ($group == 'cmm') {
            $menu = "<li><a id=\"new\" href=\"/eu-membre/newpm\" style=\"font-size:11px\">Ajout MPM</a></li>".
                    "<li><a id=\"\" href=\"#\" style=\"font-size:11px\">Personnes morales</a></li>";
            $this->view->placeholder("menu")->set($menu);
        }   else if ($group == 'cmp') {
            $menu = "<li><a id=\"new\" href=\"/eu-membre/new\" style=\"font-size:11px\">Ajout MPP</a></li>" .
                    "<li><a id=\"\" href=\"#\" style=\"font-size:11px\">Personnes physiques</a></li>";
            $this->view->placeholder("menu")->set($menu);
        }   elseif ($group == 'caps') {
            $menu = '<li><a id="caps" href="/eu-bnp/capscmfh" style=\"font-size:11px\">CAPS</a></li>
					<li><a id="cmfh" href="/eu-membre/cmfh" style=\"font-size:11px\">New CMFH</a></li>
					<li><a  href="/eu-membre/physique" style=\"font-size:11px\">Personnes physiques</a></li>';
                    //<li><a id="listes" href="/eu-bnp/listes" style=\"font-size:11px\">Vue des bnp</a></li>
                    //<li><a id="new" href="/eu-contrat/new" style=\"font-size:11px\">Ajout de contrats</a></li>';
            $this->view->placeholder("menu")->set($menu);
        }   
		
		/*else if ($group == 'productiong' or  $group == 'productionsg'  or  $group == 'productiond'
		    or  $group == 'transformationg' or  $group == 'transformationsg' or  $group == 'transformationd' or  $group == 'distributiong' or  $group == 'distributionsg' or  $group == 'distributiond') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmcreneau\" style=\"font-size:11px\">Mise sur chaine</a></li>".
				        "<li><a id=\"new\"href=\"/eu-membre/newpmcreneauint\" style=\"font-size:11px\">Mise sur chaine interim</a></li>".
                        "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
						"<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
						"<li><a id=\"liste\" href=\"/eu-membre/representation\" style=\"font-size:9px\">Liste Représentantion</a></li>".
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        } */
		
		else if ($group == 'scmpmaoe') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmcreneau\" style=\"font-size:11px\">Mise sur chaine</a></li>".
				        "<li><a id=\"new\"href=\"/eu-membre/newpmcreneauint\" style=\"font-size:11px\">Mise sur chaine interim</a></li>".
                        "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
						"<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
						"<li><a id=\"liste\" href=\"/eu-membre/representation\" style=\"font-size:9px\">Liste Représentation</a></li>".
                        "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        }
		
		else if ($group == 'gacd') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_DETENTRICE" style="font-size:11px">Création GACSD</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACSD</a></li>
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
				
        } else if ($group == 'gacdm') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_DETENTRICE" style="font-size:11px">Création GACMD</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACMD</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
				
        } else if ($group == 'gacdz') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_DETENTRICE" style="font-size:11px">Création GACZD</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACZD</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
				
        } else if ($group == 'gacdp') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_DETENTRICE" style="font-size:11px">Création GACPD</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACPD</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
				
        } else if ($group == 'gacdregion') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_DETENTRICE" style="font-size:11px">Création GACRD</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACRD</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
				
        } else if ($group == 'gacdsecteur') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_DETENTRICE" style="font-size:11px">Création GACSD</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACSD</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
				
        } else if ($group == 'gacdagence') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_DETENTRICE" style="font-size:11px">Création GACAD</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACAD</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
				
        }
		else if ($group == 'gacs') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_SURVEILLANCE" style="font-size:11px">Création GACSS</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACSS</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        }
		else if ($group == 'gacsm') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_SURVEILLANCE" style="font-size:11px">Création GACMS</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACMS</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        }
		else if ($group == 'gacsz') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_SURVEILLANCE" style="font-size:11px">Création GACZS</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACZS</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        }
		else if ($group == 'gacsp') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_SURVEILLANCE" style="font-size:11px">Création GACPS</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACPS</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        }
		else if ($group == 'gacsregion') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_SURVEILLANCE" style="font-size:11px">Création GACRS</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACRS</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'gacssecteur') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_SURVEILLANCE" style="font-size:11px">Création GACSS</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACSS</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'gacsagence') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_SURVEILLANCE" style="font-size:11px">Création GACAS</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACAS</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        }
		else if ($group == 'gacex') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_EXECUTANTE" style="font-size:11px">Création GACSEX</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACSEX</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'gacexm') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_EXECUTANTE" style="font-size:11px">Création GACMEX</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACMEX</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'gacexz') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_EXECUTANTE" style="font-size:11px">Création GACZEX</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACZEX</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'gacexp') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_EXECUTANTE" style="font-size:11px">Création GACPEX</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACPEX</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'gacexregion') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_EXECUTANTE" style="font-size:11px">Création GACREX</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACREX</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'gacexsecteur') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_EXECUTANTE" style="font-size:11px">Création GACSEX</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACSEX</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'gacexagence') {
                $menu = '<li><a id="mise" href="/eu-membre/deploiementgac?type_gac=GAC_EXECUTANTE" style="font-size:11px">Création GACAEX</a></li>
                        <li><a id="mise" href="/eu-membre/listgac" style="font-size:11px">Liste GACAEX</a></li>
						
                        <li><a id="mise" href="/login/changepwd" style="font-size:11px">Changer le mot de passe</a></li>';
                $this->view->placeholder("menu")->set($menu);
        } else if ($group == 'filiere' or  $group == 'scmacnev'  or  $group == 'technopole') {
		        $menu = "<li><a id=\"new\"href=\"/eu-membre/newpm\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentation</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
		} 
		
		/*
		else if ($group == 'scmd' or  $group == 'scmsg'  or  $group == 'scmg') {
		        $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmose\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentantion</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
		} */ 
		
		else if ($group == 'scmpmaose') {
		        $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmose\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentation</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
		}
		
		
		
		else if ($group == 'scmdpbf' or  $group == 'scmsgpbf'  or  $group == 'scmgpbf') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmpbf\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentation</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        }  
		
		
		else if ($group == 'scmpmapbf') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmpbf\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentation</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        }
		
		
		/*
		else if ($group == 'scmdd' or  $group == 'scmsgd'  or  $group == 'scmgd') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmd\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentantion</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        } 
		*/
		
		
		else if ($group == 'scmpmad') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmd\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentation</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        }
		
		/*
		else if ($group == 'scmds' or  $group == 'scmsgs'  or  $group == 'scmgs') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpms\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentantion</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        } */
		
		
		else if ($group == 'scmpmas') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpms\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentation</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        }
		
		
		/*
		else if ($group == 'scmdex' or  $group == 'scmsgex'  or  $group == 'scmgex') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmex\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentation</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        }
		*/
		
		else if ($group == 'scmpmaex') {
                $menu = "<li><a id=\"new\"href=\"/eu-membre/newpmex\" style=\"font-size:11px\">Mise sur chaine</a></li>".
                      "<li><a id=\"\"href=\"/eu-membre/morale\" style=\"font-size:11px\">Personnes morales</a></li>".
					  "<li><a id=\"new\" href=\"/eu-membre/newrep\" style=\"font-size:9px\">Représentations</a></li>".
					  "<li><a id=\"\"href=\"/eu-membre/representation\" style=\"font-size:11px\">Liste Représentation</a></li>".
                      "<li><a id=\"chpwd\" href=\"/login/changepwd\" style=\"font-size:11px\">Changer le mot de passe</a></li>";
                $this->view->placeholder("menu")->set($menu);
        }
		
		
		
		
        $this->view->jQuery()->enable();
        $this->view->jQuery()->uiEnable();
        //$liste = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $liste = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ";
        $codesecret = "";
        while(strlen($codesecret) != 8) {
            $codesecret .= $liste[rand(0,strlen($liste)-1)];  
        }
        $this->view->codesecret = $codesecret;

    }

	
    function preDispatch() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        if (!$auth->hasIdentity()) {
            $this->_redirect('login');
        } else {
            $user = $auth->getIdentity();
            $group = trim($user->code_groupe);
            if ($user->code_agence == null) {
              $this->view->user = $user;
              return $this->_redirect('index2');
            }
            if($group != 'bnp' and $group != 'caps' and $group != 'cm' and $group != 'cmm' and $group != 'cmp' and $group != 'dg' and  $group != 'filiere' 
		       and  $group != 'scmacnev' and  $group != 'technopole' and  $group != 'productiong' and  $group != 'productionsg' and  $group != 'productiond'
		       and  $group != 'transformationg' and  $group != 'transformationsg' and  $group != 'transformationd' and  $group != 'distributiong'
		       and  $group != 'distributionsg' and  $group != 'distributiond' and  $group != 'scmg' and  $group != 'scmsg' and  $group != 'scmd' and  
			   $group != 'gacd' and  $group != 'gacs' and  $group != 'gacex' and  $group != 'scmdpbf' and  $group != 'scmsgpbf' and  $group != 'scmgpbf' and  $group != 'scmdkr' and  $group != 'scmsgkr' and  $group != 'scmgkr'
			   and  $group != 'scmdd' and  $group != 'scmsgd' and  $group != 'scmgd'
			   and  $group != 'scmds' and  $group != 'scmsgs' and  $group != 'scmgs'
			   and  $group != 'scmdex' and  $group != 'scmsgex' and  $group != 'scmgex'
			   and  $group != 'gacdregion' and  $group != 'gacdsecteur' and  $group != 'gacdagence'
			   and  $group != 'gacsregion' and  $group != 'gacssecteur' and  $group != 'gacsagence'
			   and  $group != 'gacexregion' and  $group != 'gacexsecteur' and  $group != 'gacexagence'
			   and  $group != 'gacdm' and  $group != 'gacdz' and  $group != 'gacdp'
			   and  $group != 'gacsm' and  $group != 'gacsz' and  $group != 'gacsp'
			   and  $group != 'gacexm' and  $group != 'gacexz' and  $group != 'gacexp' 
			   and  $group != 'scmpmaoe'and  $group != 'scmpmaose'and  $group != 'scmpmam'
			   and  $group != 'scmpmapbf'and  $group != 'scmpmad'and  $group != 'scmpmaex') {
               $this->view->user = $user;
               return $this->_redirect('index2');
            }
            $this->view->user = $user;
        }
    }

	
    public function indexAction() {
        // action body
        $request = $this->_request;
        if ($request->isXmlHttpRequest()) {
           $this->_helper->layout->disableLayout();
        }
    }

	
    public function compteAction() {
        $tbanque = new Application_Model_DbTable_EuBanque();
        $results = $tbanque->fetchAll();
        if (count($results) > 0) {
            $data = array();
            foreach ($results as $value) {
                $data[] = $value->code_banque;
            }
        }

        $this->view->data = $data;
    }

	
    public function membrephysAction() {
        $data = array();
        $mb = new Application_Model_DbTable_EuMembre();
        $select = $mb->select();
		$select->where('code_membre like ?','%P');
        $result = $mb->fetchAll($select);
        foreach ($result as $p) {
            $data[] = $p->code_membre;
        }
        $this->view->data = $data;
    }
	
	
	public function membreapporteurAction() {
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
		    
		    } else {
              $data = '';
            }
	        $this->view->data = $data;
	}
	
	
	
	
	public function cmfhAction() {
	
	
	}
	
	
	
	public function membremoralAction() {
           $data = array();
           $mb = new Application_Model_DbTable_EuMembreMorale();
           $select = $mb->select();
           $result = $mb->fetchAll($select);
           foreach ($result as $p) {
             $data[] = $p->code_membre;
           }
           $this->view->data = $data;
    }
	
	
	public function recupnomAction() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembre();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
           $result = $membre_find->current();
           $data = strtoupper(ucfirst(utf8_encode($result->nom_membre))) . ' ' . ucfirst(utf8_encode($result->prenom_membre));
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	
	public function paysAction() {
        $t_religion = new Application_Model_DbTable_EuPays();
        $results = $t_religion->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_pays;
                $data[$i][1] = ucfirst(utf8_encode($value->libelle_pays));
            }
        }
        $this->view->data = $data;
    }
	
	
	public function listpaysAction()  {
	   $code_zone = $_GET["type"];
       $t_pays = new Application_Model_DbTable_EuPays();
	   $select = $t_pays->select();
       $select->where('code_zone like ?',$code_zone);
       $results = $t_pays->fetchAll($select);
       if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_pays;
                $data[$i][1] = ucfirst(utf8_encode($value->libelle_pays));
            }
        }
        $this->view->data = $data;
	
	
	}
	
	public function listregionAction()  {
	
	   $id_pays = $_GET["type"];
        $t_region = new Application_Model_DbTable_EuRegion();
		$select = $t_region->select();
        $select->where('id_pays like ?',$id_pays);
        $results = $t_region->fetchAll($select);
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_region;
                $data[$i][1] = ucfirst(utf8_encode($value->nom_region));
            }
        }
        $this->view->data = $data;
	
	
	}
	
	public function listprefectureAction()  {
	    $id_region = $_GET["type"];
        $t_prefecture = new Application_Model_DbTable_EuPrefecture();
		$select = $t_prefecture->select();
        $select->where('id_region like ?',$id_region);
        $results = $t_prefecture->fetchAll($select);
        if (count($results) > 0) {
            $data = array();
            for($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_prefecture;
                $data[$i][1] = ucfirst(utf8_encode($value->nom_prefecture));
            }
        }
        $this->view->data = $data;
	
	}
	
	public function listcantonAction()  {
	    $id_prefecture = $_GET["type"];
        $t_canton = new Application_Model_DbTable_EuCanton();
		$select = $t_canton->select();
        $select->where('id_prefecture like ?',$id_prefecture);
        $results = $t_canton->fetchAll($select);
        if (count($results) > 0) {
            $data = array();
            for($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_canton;
                $data[$i][1] = ucfirst(utf8_encode($value->nom_canton));
            }
        }
        $this->view->data = $data;
	
	}
	
	
	
	
	public function gacAction() {
        $t_gac = new Application_Model_DbTable_EuTypeGac();
        $results = $t_gac->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->code_type_gac;
                $data[$i][1] = ucfirst(utf8_encode($value->nom_type_gac));
            }
        }
        $this->view->data = $data;
    }
	
	public function regionAction() {
	    $id_pays = $_GET["id_pays"];
        $t_region = new Application_Model_DbTable_EuRegion();
		$select = $t_region->select();
        $select->where('id_pays like ?',$id_pays);
        $results = $t_region->fetchAll($select);
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_region;
                $data[$i][1] = ucfirst(utf8_encode($value->nom_region));
            }
        }
        $this->view->data = $data;
    }
	
	public function secteurAction() {
	    $id_region = $_GET["id_region"];
        $t_prefecture = new Application_Model_DbTable_EuPrefecture();
		$select = $t_prefecture->select();
        $select->where('id_region like ?',$id_region);
        $results = $t_prefecture->fetchAll($select);
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_prefecture;
                $data[$i][1] = ucfirst(utf8_encode($value->nom_prefecture));
            }
        }
        $this->view->data = $data;
    }
	
	public function agenceAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
	       $code_acteur = $user->code_acteur;
		   $groupe = $user->code_groupe;
		   $groupe_create = $user->code_groupe_create;
	       $code_secteur = $_GET["code_secteur"];
           $t_agence = new Application_Model_DbTable_EuAgence();
		   $select = $t_agence->select();
           $select->where('code_secteur like ?',$code_secteur);
	       $select->where('type_gac like ?','agence');
           $results = $t_agence->fetchAll($select);
           if (count($results) > 0) {
               $data = array();
               for ($i = 0; $i < count($results); $i++) {
                   $value = $results[$i];
                   $data[$i][0] = $value->code_agence;
                   $data[$i][1] = ucfirst(utf8_encode($value->libelle_agence));
               }
           }
           $this->view->data = $data;
    }
	
	
	public function cantonAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
	       $code_acteur = $user->code_acteur;
		   $groupe = $user->code_groupe;
		   $groupe_create = $user->code_groupe_create;
	       $id_prefecture = $_GET["id_prefecture"];
           $t_canton = new Application_Model_DbTable_EuCanton();
		   $select = $t_canton->select();
           $select->where('id_prefecture like ?',$id_prefecture);
           $results = $t_canton->fetchAll($select);
           if (count($results) > 0) {
               $data = array();
               for ($i = 0; $i < count($results); $i++) {
                   $value = $results[$i];
                   $data[$i][0] = $value->id_canton;
                   $data[$i][1] = $value->nom_canton;
               }
           }
           $this->view->data = $data;
    }
	
	
	
	
	
	public function trouvegacAction() {
        $type = $_GET["code_type_gac"];
        $t_gac = new Application_Model_DbTable_EuTypeGac();
        $select = $t_gac->select();
        $select->where('code_type_gac like ?',$type);
        $results = $t_gac->fetchAll($select);
        if (count($results) > 0) {
           foreach ($results as $value) {
              $donnees = $value->code_type_gac;
           }
        }
		if($donnees == "gac_detentrice") {
		     $data[0] = 1;
		} elseif($donnees == "gac_surveillance") {
		     $data[0] = 2;
		} elseif($donnees == "gac_executante") {
		     $data[0] = 3;
		} else {
		     $data[0] = 0;
		}
        $this->view->data = $data;
    }
	
	
	
	public function recupgacAction() {
        $type = $_GET["code_type_gac"];
        $t_gac = new Application_Model_DbTable_EuGac();
        $select = $t_gac->select();
        $select->where('code_type_gac like ?',$type);
        $results = $t_gac->fetchAll($select);
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->code_gac;
                $data[$i][1] = ucfirst(utf8_encode($value->nom_gac));
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
                 $data[$i][1] = ucfirst(utf8_encode($value->nom_filiere));
            }
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	

    public function soldeAction() {
       $code_membre = $_GET["membre_reg"];
       if ($code_membre != '') {
            if (strpos($code_membre, 'p') !== false) {
                $code_compte = 'NB-TPAGCRPG-' . $code_membre;
            } else {
                $code_compte = 'NB-TPAGCI-' . $code_membre;
            }
            $cm_map = new Application_Model_EuCompteMapper();
            $cm = new Application_Model_EuCompte();
            $ret = $cm_map->find($code_compte, $cm);
            if ($ret) {
                $fs = Util_Utils::getParametre('FS', 'valeur');
                if ($cm->getSolde() >= $fs) {
                    $this->view->data = 'ok';
                } else {
                    $this->view->data = 'Solde du compte insuffisant !!!';
                }
            }
        }
    }

	
	
    public function religionAction() {
        $t_religion = new Application_Model_DbTable_EuReligion();
        $results = $t_religion->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_religion_membre;
                $data[$i][1] = ucfirst(utf8_encode($value->libelle_religion));
            }
        }
        $this->view->data = $data;
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

	
	
    public function nationAction() {
        $t_religion = new Application_Model_DbTable_EuPays();
        $results = $t_religion->fetchAll();
        if (count($results) > 0) {
            $data = array();
            for ($i = 0; $i < count($results); $i++) {
                $value = $results[$i];
                $data[$i][0] = $value->id_pays;
                $data[$i][1] = ucfirst(utf8_encode($value->nationalite));
            }
        }
        $this->view->data = $data;
    }

	
	
    public function statutAction() {
        $type = $_GET["type"];
        if ($type == '') {
           $type = '%';
        }
        $t_stat = new Application_Model_DbTable_EuStatutJuridique();
        $select = $t_stat->select();
        $select->where('type_statut like ?', $type);
        $results = $t_stat->fetchAll($select);
        if (count($results) > 0) {
            $data = array();
            foreach ($results as $value) {
              $data[] = $value->code_statut;
            }
        }
        $this->view->data = $data;
    }

	
	
    public function nomcompteAction() {
        $code = $_GET["code"];
        if ($code != '') {
            $tbanque = new Application_Model_DbTable_EuBanque();
            $result = $tbanque->find($code);
            if (count($result) > 0) {
                $data = ucfirst(utf8_encode($result->current()->libelle_banque));
            }
        }
        $this->view->data = $data;
    }

	
	
    public function agencesAction() {
        $gac = array();
        $tab = new Application_Model_DbTable_EuAgence();
        $ngac = $tab->fetchAll();
        $i = 0;
        foreach ($ngac as $value) {
            $gac[$i][1] = $value->code_agence;
            $gac[$i][2] = ucfirst(utf8_encode($value->libelle_agence));
            $i++;
        }
        $this->view->data = $gac;
    }

	
    public function moraleAction() {
            // action body
           $request = $this->_request;
           if ($request->isXmlHttpRequest()) {
              $this->_helper->layout->disableLayout();
          }
        
    }
	
	public function listgacAction() {
            // action body
           $request = $this->_request;
           if ($request->isXmlHttpRequest()) {
              $this->_helper->layout->disableLayout();
          }
        
    }

	
    public function physiqueAction() {
           // action body
           $request = $this->_request;
           if ($request->isXmlHttpRequest()) {
              $this->_helper->layout->disableLayout();
          }
       
    }
	
	
	public function representationAction() {
	        $request = $this->_request;
            if ($request->isXmlHttpRequest()) {
               $this->_helper->layout->disableLayout();
            }
	}
	
	
	public function datarepAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 200000);
           $sidx = $this->_request->getParam("sidx", 'code_membre');
           $sord = $this->_request->getParam("sord", 'desc');
		   
		   $request = $this->getRequest();
           $membre = $request->membre;
		   $code_membre = $request->code_membre;
		   
		   
		   $tabela = new Application_Model_DbTable_EuRepresentation();
           $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
           if ($membre != "" && $code_membre != "") {
           $select->setIntegrityCheck(false) 
                  ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre')
                  ->where('eu_representation.code_membre_morale = ?',$membre) 
				  ->where('eu_representation.code_membre = ?',$code_membre)
                  ->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur);
            } elseif($membre != "") {
		     $select->setIntegrityCheck(false) 
                    ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre')
                    ->where('eu_representation.code_membre_morale = ?',$membre) 
                    ->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur);
		    } elseif($code_membre != "") {
		     $select->setIntegrityCheck(false) 
                    ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre')
                    ->where('eu_representation.code_membre = ?',$code_membre) 
                    ->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur);
		    }
            else {
             $select->setIntegrityCheck(false) 
                    ->join('eu_membre', 'eu_membre.code_membre = eu_representation.code_membre') 
                    ->where('eu_representation.id_utilisateur = ?',$user->id_utilisateur)
					->order('eu_representation.code_membre_morale');    
            }
		   
		    $representations = $tabela->fetchAll($select);
            $count = count($representations);
            if ($count > 0) {
                $total_pages = ceil($count / $limit);
            } 
            else {
                $total_pages = 0;
            }
            if ($page > $total_pages)
               $page = $total_pages;
               $maisons = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));
               $responce['page'] = $page;
               $responce['total'] = $total_pages;
               $responce['records'] = $count;
               $i = 0;
               foreach ($representations as $row) {
                //$date = new Zend_Date($row->date_contrat, Zend_Date::ISO_8601);
                $responce['rows'][$i]['id'] = $row->code_membre."-".$row->code_membre_morale;
                $responce['rows'][$i]['cell'] = array(
				    $row->code_membre."-".$row->code_membre_morale,
				    $row->code_membre_morale,
                    $row->code_membre,
                    $row->nom_membre,
			        $row->prenom_membre,
                    $row->date_creation,
                    $row->titre,
				    $row->etat
            );
            $i++;
        }      
        $this->view->data = $responce;
		   	   
	}
	
	public function recupnom1Action() {
        $num_membre = $_GET['num_membre'];
        $membre_db = new Application_Model_DbTable_EuMembreMorale();
        $membre_find = $membre_db->find($num_membre);
        if (count($membre_find) == 1) {
            $result = $membre_find->current();
            $data[2] = ucfirst(utf8_encode($result->raison_sociale));  
        } else {
            $data = '';
        }
        $this->view->data = $data;
    }
	
	
	public function newrepAction() {
	
	}
	
	public function representerAction() {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
		   
		    if ($this->getRequest()->isPost()) {
		        $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {  
				  $date_id = new Zend_Date(Zend_Date::ISO_8601);
                  $date_idd = clone $date_id; 
				  $rep_mapper = new Application_Model_EuRepresentationMapper();
                  $rep = new Application_Model_EuRepresentation();
				  $rep_table = new Application_Model_DbTable_EuRepresentation();
				  $code = $_POST["code_memb"];
				  $code_rep = $_POST["code_rep"];
				  $findrepresentation = $rep_mapper->findbyrep($code); 
				  $findtablerep = $rep_table->find($code_rep,$code); 
				    
				    //insertion dans la table eu_representation des membres personnes physiques  
				    if(count($findtablerep) != 0) {
					   $db->rollBack();
					   $this->view->data ="echec";                           
					   return;
					} 
					
					/*elseif (($findrepresentation != false)) {
					   $db->rollBack();
					   $this->view->data ="verifiertitre";                           
					   return;
					}*/ 
					
					elseif($_POST['code_memb'] != '' && $code_rep != '') {
					    $rep->setCode_membre_morale($code)
                            ->setCode_membre($code_rep)
                            ->setTitre('Representant')
						    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
						    ->setId_utilisateur($user->id_utilisateur)
						    ->setEtat('outside');
					    $rep_mapper->save($rep);
					 
					}
				    $db->commit();
                    $this->view->data = 'good';
                    return;   
				   
			    } catch (Exception $exc) {
                    $db->rollback();
				    $this->view->data = $exc->getMessage() . ': ' . $exc->getTraceAsString();
			        return;
			    }
		   
		  
		    }
		   
		   
	}
	
	public function octroiAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
		   $user = $auth->getIdentity();
           $selection = array();
           $selection = $_GET['lignes'];
           $rep_map = new Application_Model_EuRepresentationMapper();
           $rep = new Application_Model_EuRepresentation();
		   $utilisateur_map = new Application_Model_EuUtilisateurMapper();
		   $utilisateur = new Application_Model_EuUtilisateur() ;
		   $membre = new Application_Model_EuMembre();
		   $membre_map = new Application_Model_EuMembreMapper();
		   $membremorale = new Application_Model_EuMembreMorale();
		   $membremorale_map = new Application_Model_EuMembreMoraleMapper(); 
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
		   try {
		     foreach ($selection as $sel) {
			    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
			    $p_m = $sel['physique_morale'];
			    $p_m = explode("-",$p_m);
			    $p = $p_m[0];
			    $m = $p_m[1];
				$ret = $rep_map->find($p,$m,$rep);
				$findmembremorale = $membremorale_map->find($m,$membremorale);
				$code_type_acteur = $membremorale->getCode_type_acteur();
				$findrepresentation = $rep_map->findbyrep($m);
				$reponse = $rep_map->find($findrepresentation->getCode_membre(),$m,$rep);
				
				if($user->code_groupe == 'scmgm' && $code_type_acteur == 'EI') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'oe_grossiste');
				} elseif($user->code_groupe == 'scmsgm' && $code_type_acteur == 'EI') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'oe_semi_grossiste');
				} elseif($user->code_groupe == 'scmdm' && $code_type_acteur == 'EI') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'oe_detaillant');
				} elseif($user->code_groupe == 'scmsgm' && $code_type_acteur == 'OSE') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'ose_semi_grossiste');
				} elseif($user->code_groupe == 'scmdm' && $code_type_acteur == 'OSE') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'ose_detaillant');
				} elseif($user->code_groupe == 'scmgm' && $code_type_acteur == 'OSE') { 
				    $finduser = $utilisateur_map->findUserCodeGroupe($m,'ose_grossiste');
				}	
				$resultat = $utilisateur_map->find($finduser->getId_utilisateur(),$utilisateur);
				$result   = $membre_map->find($p,$membre);
				
				if($resultat) {
				  $utilisateur->setNom_utilisateur($membre->getNom_membre());
				  $utilisateur->setPrenom_utilisateur($membre->getPrenom_membre());
				  $utilisateur_map->update($utilisateur);
				} 
				  
				  
				if ($reponse) {
				    $rep->setCode_membre($findrepresentation->getCode_membre());
				    $rep->setCode_membre_morale($findrepresentation->getCode_membre_morale());
				    $rep->setTitre($findrepresentation->getTitre());
				    $rep->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				    $rep->setId_utilisateur($findrepresentation->getId_utilisateur());
                    $rep->setEtat('outside');
                    $rep_map->update($rep);
                }
				if ($ret) {
				    $rep->setCode_membre($p);
				    $rep->setCode_membre_morale($m);
				    $rep->setTitre('Representant');
					$rep->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					$rep->setId_utilisateur($user->id_utilisateur);
                    $rep->setEtat('inside');
                    $rep_map->update($rep);
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
	
	
	
	
	
	
	
	public function inputAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $selection = array();
      $selection = $_GET['lignes'];
      $rep_map = new Application_Model_EuRepresentationMapper();
      $rep = new Application_Model_EuRepresentation();
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          foreach ($selection as $sel) {
             $p_m = $sel['physique_morale'];
			 $p_m = explode("-",$p_m);
			 $p = $p_m[0];
			 $m = $p_m[1];
             $ret = $rep_map->find($p,$m,$rep);
			 $findrepresentation = $rep_map->findbyrep($m);
			 if (($findrepresentation != false)) {
			    $db->rollBack();
			    $this->view->data ="bad";                           
			    return;
		     } else if ($ret) {
                   $rep->setEtat('inside');
                   $rep_map->update($rep);
             }      
          }    
          $db->commit();
          $this->view->data = 'good';
          return;
        } catch (Exception $exc) {
            $db->rollback();
            $message = 'Erreur d\'éxécution : ' . $exc->getMessage() . $exc->getTraceAsString();
            $this->view->message = $message;
            $this->view->data = 'echec';
            return;
        }    
    }
	
	public function outputAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $selection = array();
      $selection = $_GET['lignes'];
      $rep_map = new Application_Model_EuRepresentationMapper();
      $rep = new Application_Model_EuRepresentation();
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          foreach ($selection as $sel) {
              $p_m = $sel['physique_morale'];
			  $p_m = explode("-", $p_m);
			  $p = $p_m[0];
			  $m = $p_m[1];
              $ret = $rep_map->find($p,$m,$rep);
              if ($ret) {
                  $rep->setEtat('outside');
                  $rep_map->update($rep);
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
	
	
	
	
	
	
	
	
	
	
	
	public function dataphysiqueAction() {
	
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'code_membre');
           $sord = $this->_request->getParam("sord", 'asc');
		   $membre = $this->_request->getParam("membre");
		   $tabela = new Application_Model_DbTable_EuMembre();
		   
		    if($membre !=''){
			      $select = $tabela->select();
	              $select->where('code_membre = ?',$membre);
	              $select->where('id_utilisateur = ?', $user->id_utilisateur);
	        }
            else {
		          $select = $tabela->select();
	              $select->where('id_utilisateur = ?', $user->id_utilisateur);
				  $select->where('code_membre like ?','%P');
		          $select->order('code_membre');
		    }
		  
		   
		   $membres = $tabela->fetchAll($select);
           $count = count($membres);
		   $membres = $tabela->fetchAll($select);
           $count = count($membres);

            if ($count > 0) {
            $total_pages = ceil($count / $limit);
            } else {
                  $total_pages = 0;
            }

           if ($page > $total_pages)
               $page = $total_pages;
           $membres = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

           $responce['page'] = $page;
           $responce['total'] = $total_pages;
           $responce['records'] = $count;
           $i = 0;
		   foreach ($membres as $row) {
            $responce['rows'][$i]['id'] = $row->code_membre;
            $responce['rows'][$i]['cell'] = array(
              $row->code_membre,
              $row->nom_membre,
              $row->prenom_membre,
              $row->sexe_membre,
              $row->profession_membre,
              $row->portable_membre,
              $row->ville_membre
            );
            $i++;
        }	 
        $this->view->data = $responce;	
	}
	
	
	/*
	public function datamoraleAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $this->_helper->layout->disableLayout();
           $page = $this->_request->getParam("page", 1);
           $limit = $this->_request->getParam("rows", 10);
           $sidx = $this->_request->getParam("sidx", 'code_membre_morale');
           $sord = $this->_request->getParam("sord", 'asc');
		   $membre = $this->_request->getParam("membre");
		   
		   
		   $tabela = new Application_Model_DbTable_EuMembreMorale();
		   
		   if($membre !=''){
			      $select = $tabela->select();
	              $select->where('code_membre_morale = ?',$membre);
	              $select->where('id_utilisateur = ?', $user->id_utilisateur);
	       }
           else {
		          $select = $tabela->select();
	              $select->where('id_utilisateur = ?', $user->id_utilisateur);
		   }
		   $membres = $tabela->fetchAll($select);
           $count = count($membres);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        $membres = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
        foreach ($membres as $row) {
         $responce['rows'][$i]['id'] = $row->code_membre_morale;
         $responce['rows'][$i]['cell'] = array(
             $row->code_membre_morale,
             $row->code_type_acteur,
			 $row->code_statut,
             stripslashes (html_entity_decode($row->raison_sociale)),
			 stripslashes (html_entity_decode($row->domaine_activite)),
			 stripslashes (html_entity_decode($row->ville_membre)),
             $row->tel_membre,
             $row->portable_membre
          );
          $i++;
        }
	    $this->view->data = $responce;
	}
	
*/	
    
	
	public  function deploiementgacAction()   {
	   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $request = $this->getRequest();
       $type_gac = $request->type_gac;
		
	   $t_agence = new Application_Model_DbTable_EuAgence();
	   
	   $t_zone = new Application_Model_DbTable_EuZone();
       $zones = $t_zone->fetchAll();
       $this->view->zones = $zones;
       $t_pays = new Application_Model_DbTable_EuPays();
       $pays = $t_pays->fetchAll();
       $this->view->pays = $pays;
       $t_region = new Application_Model_DbTable_EuRegion();
       $regions = $t_region->fetchAll();
       $this->view->regions = $regions;
       $t_prefecture = new Application_Model_DbTable_EuPrefecture();
       $prefectures = $t_prefecture->fetchAll();
       $this->view->prefectures = $prefectures;
       $t_canton = new Application_Model_DbTable_EuCanton();
       $cantons = $t_canton->fetchAll();
       $this->view->cantons = $cantons;
	   $agences = $t_agence->fetchAll();
       $this->view->agences = $agences;
	   $this->view->type_gac = $type_gac;
		
		
	   if($this->getRequest()->isPost()) {
		  $db = Zend_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try {
              $utilisateur = NULL;
			  $nom_gac = $request->getParam("designation_gac");
			  $code_membre = $request->getParam("code_membre");
			  //$code_membre_gac = $request->getParam("code_membre_gac");
			  $type_gac = $request->getParam("type_gac");
			  $appartenance = $request->getParam("niveau_gac");
              $code_agence = $request->getParam("code_agence");
			  $login = $request->getParam("gac_login");
			  $pwd = $request->getParam("gac_passe");
			  $confirme = $request->getParam("confirme");
              //$code_zone = substr($code_agence, 0, 3);
			  $code_zone = $request->getParam("code_zone");
			  $id_pays = $request->getParam("id_pays");
			  $id_region = $request->getParam("id_region");
			  $id_prefecture = $request->getParam("id_prefecture");
			  $id_canton = $request->getParam("id_canton");
              $groupe = NULL;
			 
			  $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;

              $membre = new Application_Model_EuMembre();
	          $m_map  = new Application_Model_EuMembreMapper();
			 
			  $representation = new Application_Model_EuRepresentation();
	          $m_representation  = new Application_Model_EuRepresentationMapper();

              $membremorale    = new Application_Model_EuMembreMorale();
	          $m_membremorale  = new Application_Model_EuMembreMoraleMapper();
			 
			  $gac_mapper = new Application_Model_EuGacMapper();
              $gac = new Application_Model_EuGac();

              /*$findmembre = $m_membremorale->find($code_membre_gac,$membremorale);
			  if($findmembre == false) {
			     $db->rollback();
			     $this->view->message = "Le code membre personne morale de la GAC est introuvable ...";
		         return;
			  }
			  */

              $findmembre = $m_map->find($code_membre,$membre);
			  if($findmembre == false) {
			     $db->rollback();
			     $this->view->message = "Le code membre personne physique representant de la gac est introuvable ...";
		         return;
			  }

              if($appartenance == 'SOURCE' || $appartenance == 'MONDE') {
			    $findgac =  $gac_mapper->findgacsourcemonde($appartenance,$type_gac);  
			  } elseif($appartenance == 'ZONE') {
			    $findgac =  $gac_mapper->findgaczone($code_zone,$appartenance,$type_gac);
			  } elseif($appartenance == 'PAYS') {
			    $findgac =  $gac_mapper->findgacpays($id_pays,$appartenance,$type_gac);
			  } elseif($appartenance == 'REGION') {
			    $findgac =  $gac_mapper->findgacregion($id_region,$appartenance,$type_gac);
			  } elseif($appartenance == 'PREFECTURE') {
			    $findgac =  $gac_mapper->findgacsecteur($id_prefecture,$appartenance,$type_gac);
			  } elseif($appartenance == 'CANTON') {
                $findgac =  $gac_mapper->findgacagence($id_canton,$appartenance,$type_gac);
              }
			  
			  if($findgac != false) {
			     $db->rollback();
			     $this->view->message = "Le type de gac est déja créé !!! ";
		         return;
			  }
			  
			  $utilisateur = new Application_Model_EuUtilisateur();
              $m_utilisateur = new Application_Model_EuUtilisateurMapper();
			  $find_user = $m_utilisateur->findLogin($login);

              if($find_user != false) {
			     $db->rollback();
                 $error = 'Ce login existe déjà.';
                 $this->view->message = $error;
			     return;      
              } elseif($pwd != $confirme) {
			     $db->rollback();
                 $error = 'Erreur de confirmation du mot de passe.';
                 $this->view->message = $error;
                 return;
              } elseif (stripos($login, " ") !== false) {
			    $db->rollback();
                $error = "Le Login ne doit pas contenir d'espace";
                $this->view->message = $error;
                return;
              }
			  
			  
			  // GAC
			  $code_admin = "000000000000";
			  $code_membre_gac = $m_membremorale->getLastCodeMembreAdmin();
              if($code_membre_gac == NULL) {
                 $code_membre_gac = $code_admin . '0000001' . 'M';
              } else {
                 $num_ordre = substr($code_membre_gac, 12, 7);
                 $num_ordre++;
                 $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                 $code_membre_gac = $code_admin . $num_ordre_bis . 'M';
              }
			  
			  $membremorale->setId_filiere(null);
              $membremorale->setCode_membre_morale($code_membre_gac);
			  if($type_gac == "GAC_DETENTRICE" || $type_gac == "GAC_EXECUTANTE") {
                 $membremorale->setCode_type_acteur("OE");
                 $membremorale->setCode_statut("SARL");
			  } else {
				 $membremorale->setCode_type_acteur("OSE");
                 $membremorale->setCode_statut("association"); 
			  }
              $membremorale->setRaison_sociale($nom_gac);
              $membremorale->setId_pays($request->getParam("id_pays"));
              $membremorale->setNum_registre_membre("000000000000");
              $membremorale->setDomaine_activite("PRESTATION");
              $membremorale->setSite_web(null);
              $membremorale->setQuartier_membre($membre->quartier_membre);
              $membremorale->setVille_membre($membre->ville_membre);
              $membremorale->setBp_membre(null);
              $membremorale->setTel_membre(null);
              $membremorale->setEmail_membre("");
              $membremorale->setPortable_membre($membre->portable_membre);
              $membremorale->setId_utilisateur(NULL);
              $membremorale->setHeure_identification($date_idd->toString('HH:mm:ss'));
              $membremorale->setDate_identification($date_idd->toString('yyyy-MM-dd'));
              $membremorale->setCode_agence(null);
              $membremorale->setCodesecret(md5("123456"));
              $membremorale->setAuto_enroler('O');
              $membremorale->setEtat_membre("N");
              $membremorale->setType_fournisseur(NULL);
			  $membremorale->setDesactiver(2);
			  $membremorale->setId_canton($request->getParam("id_canton"));
              $m_membremorale->save($membremorale);
			  
			  $representation->setCode_membre_morale($code_membre_gac)
                             ->setCode_membre($code_membre)
                             ->setTitre("Representant")
                             ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
                             ->setId_utilisateur(NULL)
                             ->setEtat('inside');
              $m_representation->save($representation);
			  
			  //insertion dans la table eu_gac
			  $code_recup = $gac_mapper->getLastGacByZone($code_zone);
              if($code_recup == null) {
                 $code_gac = 'G' . $code_zone . '0001';
              } else {
                 $num_ordre = substr($code_recup, -4);
                 $num_ordre++;
                 $code_gac = 'G' . $code_zone . str_pad($num_ordre,4,0,STR_PAD_LEFT);
              }
			
			  $gac->setCode_gac($code_gac);
              $gac->setCode_membre($code_membre_gac);
              $gac->setNom_gac($nom_gac);
              $gac->setCode_type_gac($type_gac);
              $gac->setCode_zone($code_zone);
              $gac->setCode_membre_gestionnaire($request->getParam("code_membre"));
              $gac->setDate_creation($date_idd->toString('yyyy-MM-dd'));
              $gac->setId_utilisateur($user->id_utilisateur);
			  $gac->setType_gac($appartenance);
			  $gac->setZone($code_zone);
			  $gac->setId_pays($id_pays);
			  $gac->setId_region($id_region);
			  $gac->setId_prefecture($id_prefecture);
			  $gac->setId_canton($id_canton);
              $gac->setGroupe('GAC');
			  $gac->setCode_secteur(null);
			  $gac->setCode_agence($code_agence);
              $gac->setCode_gac_create(null);
              $gac->setCode_gac_chaine($user->code_acteur);
              $gac_mapper->save($gac);
			  
			  
			  
			  //insertion dans la table eu_acteur
			  $t_acteur = new Application_Model_DbTable_EuActeur();
              $c_acteur = new Application_Model_EuActeur();
			  
			  $count = $c_acteur->findConuter() + 1;
			  $c_acteur->setId_acteur($count)
                       ->setCode_acteur($code_gac)
			           ->setCode_division(NULL)
                       ->setCode_membre($code_membre_gac)
                       ->setType_acteur($type_gac)
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					 
			  if($appartenance == 'SOURCE') {
			     $c_acteur->setCode_activite('SOURCE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			   } else if($appartenance == 'MONDE') {
			     $c_acteur->setCode_activite('MONDE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
							 
			   } else if($appartenance == 'ZONE') {
			     $c_acteur->setCode_activite('ZONE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			  }  else if($appartenance == 'PAYS') {
			     $c_acteur->setCode_activite('PAYS');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
							 
			  } else if($appartenance == 'REGION') {
			     $c_acteur->setCode_activite('REGION');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			  } else if($appartenance == 'PREFECTURE') {
			     $c_acteur->setCode_activite('PREFECTURE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
						  
			  } else if($appartenance == 'CANTON')   { 
				$c_acteur->setCode_activite('CANTON');
				$c_acteur->setCode_source_create('SOURCE');
				$c_acteur->setCode_monde_create('MONDE');
				$c_acteur->setCode_zone_create($code_zone);
				$c_acteur->setId_pays($id_pays);
				$c_acteur->setId_region($id_region);
				$c_acteur->setId_prefecture($id_prefecture);
				$c_acteur->setId_canton($id_canton);
				$c_acteur->setCode_secteur_create(NULL);
				$c_acteur->setCode_agence_create(NULL);
			  }
						  
			  $c_acteur->setCode_gac_chaine(null);
			  $t_acteur->insert($c_acteur->toArray());
			  
			  
			  $tetedivisiontechno = "TECHNOPOLE";
			  $tetedivisionfiliere = "FILIERE";
			  $tetedivisionacnev = "ACNEV";
			  
			  
			  // TECHNOPOLE
			  
			  $code = $m_membremorale->getLastCodeMembreAdmin();
              if($code == NULL) {
                 $code = $code_admin . '0000001' . 'M';
              } else {
                 $num_ordre = substr($code, 12, 7);
                 $num_ordre++;
                 $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                 $code = $code_admin . $num_ordre_bis . 'M';
              }
			  
			  $membremorale->setId_filiere(null);
              $membremorale->setCode_membre_morale($code);
              if($type_gac == "GAC_DETENTRICE" || $type_gac == "GAC_EXECUTANTE") {
                 $membremorale->setCode_type_acteur("OE");
                 $membremorale->setCode_statut("SARL");
			  } else {
				 $membremorale->setCode_type_acteur("OSE");
                 $membremorale->setCode_statut("association"); 
			  }
              $membremorale->setRaison_sociale($tetedivisiontechno." ".$appartenance);
              $membremorale->setId_pays($request->getParam("id_pays"));
              $membremorale->setNum_registre_membre("00000000000");
              $membremorale->setDomaine_activite("PRESTATION");
              $membremorale->setSite_web(null);
              $membremorale->setQuartier_membre($membre->quartier_membre);
              $membremorale->setVille_membre($membre->ville_membre);
              $membremorale->setBp_membre(null);
              $membremorale->setTel_membre(null);
              $membremorale->setEmail_membre($membre->email_membre);
              $membremorale->setPortable_membre($membre->portable_membre);
              $membremorale->setId_utilisateur(NULL);
              $membremorale->setHeure_identification($date_idd->toString('HH:mm:ss'));
              $membremorale->setDate_identification($date_idd->toString('yyyy-MM-dd'));
              $membremorale->setCode_agence(null);
              $membremorale->setCodesecret(md5("123456"));
              $membremorale->setAuto_enroler('O');
              $membremorale->setEtat_membre("N");
              $membremorale->setType_fournisseur(NULL);
			  $membremorale->setDesactiver(2);
			  $membremorale->setId_canton($request->getParam("id_canton"));
              $m_membremorale->save($membremorale);
			  
			  
			  $representation->setCode_membre_morale($code)
                             ->setCode_membre($code_membre)
                            ->setTitre("Representant")
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
                            ->setId_utilisateur(NULL)
                            ->setEtat('inside');
              $m_representation->save($representation);
			  
			  $count = $c_acteur->findConuter() + 1;
			  $c_acteur->setId_acteur($count)
                       ->setCode_acteur($code_gac)
			           ->setCode_division(NULL)
                       ->setCode_membre($code)
                       ->setType_acteur($tetedivisiontechno)
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					 
			  if($appartenance == 'SOURCE') {
			     $c_acteur->setCode_activite('SOURCE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			   } else if($appartenance == 'MONDE') {
			     $c_acteur->setCode_activite('MONDE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
							 
			   } else if($appartenance == 'ZONE') {
			     $c_acteur->setCode_activite('ZONE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			  }  else if($appartenance == 'PAYS') {
			     $c_acteur->setCode_activite('PAYS');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
							 
			  } else if($appartenance == 'REGION') {
			     $c_acteur->setCode_activite('REGION');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			  } else if($appartenance == 'PREFECTURE') {
			     $c_acteur->setCode_activite('PREFECTURE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
						  
			  } else if($appartenance == 'CANTON')   { 
				$c_acteur->setCode_activite('CANTON');
				$c_acteur->setCode_source_create('SOURCE');
				$c_acteur->setCode_monde_create('MONDE');
				$c_acteur->setCode_zone_create($code_zone);
				$c_acteur->setId_pays($id_pays);
				$c_acteur->setId_region($id_region);
				$c_acteur->setId_prefecture($id_prefecture);
				$c_acteur->setId_canton($id_canton);
				$c_acteur->setCode_secteur_create(NULL);
				$c_acteur->setCode_agence_create(NULL);
			  }
						  
			  $c_acteur->setCode_gac_chaine(null);
			  $t_acteur->insert($c_acteur->toArray());
			  
			  
			  
			  
			  // FILIERE
			  
			  $code = $m_membremorale->getLastCodeMembreAdmin();
              if($code == NULL) {
                 $code = $code_admin . '0000001' . 'M';
              } else {
                 $num_ordre = substr($code, 12, 7);
                 $num_ordre++;
                 $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                 $code = $code_admin . $num_ordre_bis . 'M';
              }
			  
			  $membremorale->setId_filiere(null);
              $membremorale->setCode_membre_morale($code);
              if($type_gac == "GAC_DETENTRICE" || $type_gac == "GAC_EXECUTANTE") {
                 $membremorale->setCode_type_acteur("OE");
                 $membremorale->setCode_statut("SARL");
			  } else {
				 $membremorale->setCode_type_acteur("OSE");
                 $membremorale->setCode_statut("association"); 
			  }
              $membremorale->setRaison_sociale($tetedivisionfiliere." ".$appartenance);
              $membremorale->setId_pays($request->getParam("id_pays"));
              $membremorale->setNum_registre_membre("0000000000");
              $membremorale->setDomaine_activite("PRESTATION");
              $membremorale->setSite_web(null);
              $membremorale->setQuartier_membre($membre->quartier_membre);
              $membremorale->setVille_membre($membre->ville_membre);
              $membremorale->setBp_membre(null);
              $membremorale->setTel_membre(null);
              $membremorale->setEmail_membre($membre->email_membre);
              $membremorale->setPortable_membre($membre->portable_membre);
              $membremorale->setId_utilisateur(NULL);
              $membremorale->setHeure_identification($date_idd->toString('HH:mm:ss'));
              $membremorale->setDate_identification($date_idd->toString('yyyy-MM-dd'));
              $membremorale->setCode_agence(null);
              $membremorale->setCodesecret(md5("123456"));
              $membremorale->setAuto_enroler('O');
              $membremorale->setEtat_membre("N");
              $membremorale->setType_fournisseur(NULL);
			  $membremorale->setDesactiver(2);
			  $membremorale->setId_canton($request->getParam("id_canton"));
              $m_membremorale->save($membremorale);
			  
			  
			  $representation->setCode_membre_morale($code)
                             ->setCode_membre($code_membre)
                             ->setTitre("Representant")
                             ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
                             ->setId_utilisateur(NULL)
                             ->setEtat('inside');
              $m_representation->save($representation);
			  
			  $count = $c_acteur->findConuter() + 1;
			  $c_acteur->setId_acteur($count)
                       ->setCode_acteur($code_gac)
			           ->setCode_division(NULL)
                       ->setCode_membre($code)
                       ->setType_acteur($tetedivisionfiliere)
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					 
			  if($appartenance == 'SOURCE') {
			     $c_acteur->setCode_activite('SOURCE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			   } else if($appartenance == 'MONDE') {
			     $c_acteur->setCode_activite('MONDE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
							 
			   } else if($appartenance == 'ZONE') {
			     $c_acteur->setCode_activite('ZONE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			   }  else if($appartenance == 'PAYS') {
			     $c_acteur->setCode_activite('PAYS');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
							 
			  } else if($appartenance == 'REGION') {
			     $c_acteur->setCode_activite('REGION');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			  } else if($appartenance == 'PREFECTURE') {
			     $c_acteur->setCode_activite('PREFECTURE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
						  
			  } else if($appartenance == 'CANTON')   { 
				$c_acteur->setCode_activite('CANTON');
				$c_acteur->setCode_source_create('SOURCE');
				$c_acteur->setCode_monde_create('MONDE');
				$c_acteur->setCode_zone_create($code_zone);
				$c_acteur->setId_pays($id_pays);
				$c_acteur->setId_region($id_region);
				$c_acteur->setId_prefecture($id_prefecture);
				$c_acteur->setId_canton($id_canton);
				$c_acteur->setCode_secteur_create(NULL);
				$c_acteur->setCode_agence_create(NULL);
			  }
						  
			  $c_acteur->setCode_gac_chaine(null);
			  $t_acteur->insert($c_acteur->toArray());
			  
			  
			  // ACNEV
			  
			  $code = $m_membremorale->getLastCodeMembreAdmin();
              if($code == NULL) {
                 $code = $code_admin . '0000001' . 'M';
              } else {
                 $num_ordre = substr($code, 12, 7);
                 $num_ordre++;
                 $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                 $code = $code_admin . $num_ordre_bis . 'M';
              }
			  
			  $membremorale->setId_filiere(null);
              $membremorale->setCode_membre_morale($code);
              if($type_gac == "GAC_DETENTRICE" || $type_gac == "GAC_EXECUTANTE") {
                 $membremorale->setCode_type_acteur("OE");
                 $membremorale->setCode_statut("SARL");
			  } else {
				 $membremorale->setCode_type_acteur("OSE");
                 $membremorale->setCode_statut("association"); 
			  }
              $membremorale->setRaison_sociale($tetedivisionacnev." ".$appartenance);
              $membremorale->setId_pays($request->getParam("id_pays"));
              $membremorale->setNum_registre_membre("00000000000");
              $membremorale->setDomaine_activite("PRESTATION");
              $membremorale->setSite_web(null);
              $membremorale->setQuartier_membre($membre->quartier_membre);
              $membremorale->setVille_membre($membre->ville_membre);
              $membremorale->setBp_membre(null);
              $membremorale->setTel_membre(null);
              $membremorale->setEmail_membre($membre->email_membre);
              $membremorale->setPortable_membre($membre->portable_membre);
              $membremorale->setId_utilisateur(NULL);
              $membremorale->setHeure_identification($date_idd->toString('HH:mm:ss'));
              $membremorale->setDate_identification($date_idd->toString('yyyy-MM-dd'));
              $membremorale->setCode_agence(null);
              $membremorale->setCodesecret(md5("123456"));
              $membremorale->setAuto_enroler('O');
              $membremorale->setEtat_membre("N");
              $membremorale->setType_fournisseur(NULL);
			  $membremorale->setDesactiver(2);
			  $membremorale->setId_canton($request->getParam("id_canton"));
              $m_membremorale->save($membremorale);
			  
			  
			  $representation->setCode_membre_morale($code)
                             ->setCode_membre($code_membre)
                            ->setTitre("Representant")
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
                            ->setId_utilisateur(NULL)
                            ->setEtat('inside');
              $m_representation->save($representation);
			  
			  $count = $c_acteur->findConuter() + 1;
			  $c_acteur->setId_acteur($count)
                       ->setCode_acteur($code_gac)
			           ->setCode_division(NULL)
                       ->setCode_membre($code)
                       ->setType_acteur($tetedivisionacnev)
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					 
			  if($appartenance == 'SOURCE') {
			     $c_acteur->setCode_activite('SOURCE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			   } else if($appartenance == 'MONDE') {
			     $c_acteur->setCode_activite('MONDE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
							 
			   } else if($appartenance == 'ZONE') {
			     $c_acteur->setCode_activite('ZONE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			  }  else if($appartenance == 'PAYS') {
			     $c_acteur->setCode_activite('PAYS');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
							 
			  } else if($appartenance == 'REGION') {
			     $c_acteur->setCode_activite('REGION');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
			   
			  } else if($appartenance == 'PREFECTURE') {
			     $c_acteur->setCode_activite('PREFECTURE');
			     $c_acteur->setCode_source_create('SOURCE');
			     $c_acteur->setCode_monde_create('MONDE');
			     $c_acteur->setCode_zone_create($code_zone);
			     $c_acteur->setId_pays($id_pays);
			     $c_acteur->setId_region($id_region);
			     $c_acteur->setId_prefecture($id_prefecture);
			     $c_acteur->setId_canton($id_canton);
			     $c_acteur->setCode_secteur_create(NULL);
			     $c_acteur->setCode_agence_create(NULL);
						  
			  } else if($appartenance == 'CANTON')   { 
				$c_acteur->setCode_activite('CANTON');
				$c_acteur->setCode_source_create('SOURCE');
				$c_acteur->setCode_monde_create('MONDE');
				$c_acteur->setCode_zone_create($code_zone);
				$c_acteur->setId_pays($id_pays);
				$c_acteur->setId_region($id_region);
				$c_acteur->setId_prefecture($id_prefecture);
				$c_acteur->setId_canton($id_canton);
				$c_acteur->setCode_secteur_create(NULL);
				$c_acteur->setCode_agence_create(NULL);
			  }
						  
			  $c_acteur->setCode_gac_chaine(null);
			  $t_acteur->insert($c_acteur->toArray());
			  
			  
			  //////// insertion dans la table eu_utilisateur ///////////////////////////////
			   $user_mapper = new Application_Model_EuUtilisateurMapper();
               $userin = new Application_Model_EuUtilisateur();
               $membre_mapper = new Application_Model_EuMembreMapper();
               $membrein = new Application_Model_EuMembre();
               $find_membre = $membre_mapper->find($code_membre,$membrein);
               $id_user = $user_mapper->findConuter() + 1;
						  
			   $userin->setId_utilisateur($id_user);
               $userin->setId_utilisateur_parent($user->id_utilisateur); 
               $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
               $userin->setNom_utilisateur($membrein->getNom_membre());
               $userin->setLogin($login);
               $userin->setPwd(md5($pwd));
               $userin->setDescription(null);
               $userin->setUlock(0);
               $userin->setCh_pwd_flog(0);
						  
			   if($appartenance == 'SOURCE' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice');
			     $userin->setCode_groupe_create('detentrice');			 
			   } elseif($appartenance == 'MONDE' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_monde');
			     $userin->setCode_groupe_create('detentrice_monde');			 
               } elseif($appartenance == 'ZONE' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_zone');
			     $userin->setCode_groupe_create('detentrice_zone');			 
               } elseif($appartenance == 'PAYS' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_pays');
				 $userin->setCode_groupe_create('detentrice_pays');			 
               } elseif($appartenance == 'REGION' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_region');
			     $userin->setCode_groupe_create('detentrice_region');			 
               } elseif($appartenance == 'PREFECTURE' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_secteur');
			     $userin->setCode_groupe_create('detentrice_secteur');			 
               } elseif($appartenance == 'CANTON' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_agence');
				 $userin->setCode_groupe_create('detentrice_agence');			 
               } else if($appartenance == 'SOURCE' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance');
				 $userin->setCode_groupe_create('surveillance');			 
			   } elseif($appartenance == 'MONDE' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_monde');
			     $userin->setCode_groupe_create('surveillance_monde');			 
               } elseif($appartenance == 'ZONE' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_zone');
				 $userin->setCode_groupe_create('surveillance_zone');			 
               } elseif($appartenance == 'PAYS' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_pays');
			     $userin->setCode_groupe_create('surveillance_pays');			 
               } elseif($appartenance == 'REGION' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_region');
			     $userin->setCode_groupe_create('surveillance_region');			 
               } elseif($appartenance == 'PREFECTURE' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_secteur');
			     $userin->setCode_groupe_create('surveillance_secteur');			 
               } elseif($appartenance == 'CANTON' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_agence');
			     $userin->setCode_groupe_create('surveillance_agence');		 
               } else if($appartenance == 'SOURCE' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante');
				 $userin->setCode_groupe_create('executante');			 
			   } elseif($appartenance == 'MONDE' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_monde');
				 $userin->setCode_groupe_create('executante_monde');			 
               } elseif($appartenance == 'ZONE' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_zone');
			     $userin->setCode_groupe_create('executante_zone');			 
               } elseif($appartenance == 'PAYS' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_pays');
				 $userin->setCode_groupe_create('executante_pays');			 
               } elseif($appartenance == 'REGION' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_region');
				 $userin->setCode_groupe_create('executante_region');			 
               } elseif($appartenance == 'PREFECTURE' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_secteur');
			     $userin->setCode_groupe_create('executante_secteur');			 
               } elseif($appartenance == 'CANTON' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_agence');
			     $userin->setCode_groupe_create('executante_agence');			 
               }
			   
			   if($type_gac == "GAC_DETENTRICE") {
				  $userin->setRole("ESMC");   
			   } else if($type_gac == "GAC_SURVEILLANCE") {
				  $userin->setRole("FOADDIP"); 
			   } else if($type_gac == "GAC_EXECUTANTE") {
				  $userin->setRole("CMFH"); 
			   }
						  
			   $userin->setConnecte(0);
               $userin->setCode_agence($code_agence);
               $userin->setCode_secteur(NULL);
			   $userin->setSection(NULL);
               $userin->setCode_zone($code_zone);
               $userin->setId_filiere(NULL);
               $userin->setCode_acteur($code_gac);
                   
               $userin->setCode_membre($code_membre_gac);
               $userin->setId_pays($id_pays);
               $userin->setId_canton($id_canton);						  
               $user_mapper->save($userin);
               		       
			   $db->commit();
               return $this->_helper->redirector('listgac', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'listgac'));
		  } catch(Exception $exc) {
             $db->rollback();
             $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
             return;
          } 
		   
	   }
		
		
	}
	
	
	
	
	
	
	public function deploiementgacOLDAction() {
	   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
       $user = $auth->getIdentity();
       $request = $this->getRequest();
       $type_gac = $request->type_gac;
	   
	   
	   $t_agence = new Application_Model_DbTable_EuAgence();
	   
	   $t_zone = new Application_Model_DbTable_EuZone();
       $zones = $t_zone->fetchAll();
       $this->view->zones = $zones;
       $t_pays = new Application_Model_DbTable_EuPays();
       $pays = $t_pays->fetchAll();
       $this->view->pays = $pays;
       $t_region = new Application_Model_DbTable_EuRegion();
       $regions = $t_region->fetchAll();
       $this->view->regions = $regions;
       $t_prefecture = new Application_Model_DbTable_EuPrefecture();
       $prefectures = $t_prefecture->fetchAll();
       $this->view->prefectures = $prefectures;
       $t_canton = new Application_Model_DbTable_EuCanton();
       $cantons = $t_canton->fetchAll();
       $this->view->cantons = $cantons;
	   $agences = $t_agence->fetchAll();
       $this->view->agences = $agences;
	   $this->view->type_gac = $type_gac;
	   
	   if($this->getRequest()->isPost()) {
	       $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
	           $utilisateur = NULL;
			 $nom_gac = $request->getParam("designation_gac");
			 $code_membre = $request->getParam("code_membre");
			 $code_membre_gac = $request->getParam("code_membre_gac");
			 $type_gac = $request->getParam("type_gac");
			 $appartenance = $request->getParam("niveau_gac");
             $code_agence = $request->getParam("code_agence");
			 $login = $request->getParam("gac_login");
			 $pwd = $request->getParam("gac_passe");
			 $confirme = $request->getParam("confirme");
             //$code_zone = substr($code_agence, 0, 3);
			 $code_zone = $request->getParam("code_zone");
			 $id_pays = $request->getParam("id_pays");
			 $id_region = $request->getParam("id_region");
			 $id_prefecture = $request->getParam("id_prefecture");
			 $id_canton = $request->getParam("id_canton");
             $groupe = NULL;
			 
			 $date_id = new Zend_Date(Zend_Date::ISO_8601);
             $date_idd = clone $date_id;
			 
			 $membre = new Application_Model_EuMembre();
	         $m_map  = new Application_Model_EuMembreMapper();
			 
			 $representation = new Application_Model_EuRepresentation();
	         $m_representation  = new Application_Model_EuRepresentationMapper();
			 
			 //$findrep  = $m_representation->findbyrep($code_membre);
			 
			 $membremorale    = new Application_Model_EuMembreMorale();
	         $m_membremorale  = new Application_Model_EuMembreMapper();
			 
			 $gac_mapper = new Application_Model_EuGacMapper();
             $gac = new Application_Model_EuGac();
			 
			 
			 /*if(substr($code_membre,19,1) == 'M')  {
			   $findmembre = $m_membremorale->find($code_membre,$membremorale);
			   if($findmembre == false) {
			      $db->rollback();
			      $sessionmcnp->error = "Le code membre de la gac est introuvable ...";
		          return;
			   }
			 }*/
			 
			 $findmembre = $m_membremorale->find($code_membre_gac,$membremorale);
			 if($findmembre == false) {
			    $db->rollback();
			    $this->view->message = "Le code membre personne morale de la GAC est introuvable ...";
		        return;
			 }
			 
			 
			 if($appartenance == 'SOURCE' || $appartenance == 'MONDE') {
			    $findgac =  $gac_mapper->findgacsourcemonde($appartenance,$type_gac);  
			 } elseif($appartenance == 'ZONE') {
			    $findgac =  $gac_mapper->findgaczone($code_zone,$appartenance,$type_gac);
			 } elseif($appartenance == 'PAYS') {
			    $findgac =  $gac_mapper->findgacpays($id_pays,$appartenance,$type_gac);
			 } elseif($appartenance == 'REGION') {
			    $findgac =  $gac_mapper->findgacregion($id_region,$appartenance,$type_gac);
			 } elseif($appartenance == 'PREFECTURE') {
			    $findgac =  $gac_mapper->findgacsecteur($id_prefecture,$appartenance,$type_gac);
			 } elseif($appartenance == 'CANTON') {
                $findgac =  $gac_mapper->findgacagence($id_canton,$appartenance,$type_gac);
             }			 
			 
			 $findmembre = $m_map->find($code_membre,$membre);
			 if($findmembre == false) {
			   $db->rollback();
			   $this->view->message = "Le code membre personne physique representant de la gac est introuvable ...";
		       return;
			 }
			 
			 if($findgac != false) {
			   $db->rollback();
			   $this->view->message = "Le type de gac est déja créé !!! ";
		       return;
			 }
			 
			 $utilisateur = new Application_Model_EuUtilisateur();
             $m_utilisateur = new Application_Model_EuUtilisateurMapper();
			 $find_user = $m_utilisateur->findLogin($login);

             if($find_user != false) {
			   $db->rollback();
               $error = 'Ce login existe déjà.';
               $this->view->message = $error;
			   return;      
             } elseif($pwd != $confirme) {
			   $db->rollback();
               $error = 'Erreur de confirmation du mot de passe.';
               $this->view->message = $error;
               return;
             }
			 
			 elseif (stripos($login, " ") !== false) {
			   $db->rollback();
               $error = "Le Login ne doit pas contenir d'espace";
               $this->view->message = $error;
               return;
             }
			 
			 // Controle sur la table eu_acteur
			 $mapper_acteur = new Application_Model_EuActeurMapper();
			 $findacteur = $mapper_acteur->findByActeur($code_membre);
			 
			 if($findacteur != false) {
			   $db->rollback();
               $error = "Ce membre represente deja une gestion d'action commune ...";
               $this->view->message = $error;
               return;
			 }
			 
			 //insertion dans la table eu_gac
			
			 $code_recup = $gac_mapper->getLastGacByZone($code_zone);
             if($code_recup == null) {
               $code_gac = 'G' . $code_zone . '0001';
             } else {
               $num_ordre = substr($code_recup, -4);
               $num_ordre++;
               $code_gac = 'G' . $code_zone . str_pad($num_ordre,4,0,STR_PAD_LEFT);
             }
			
			 $gac->setCode_gac($code_gac);
             $gac->setCode_membre($code_membre_gac);
             $gac->setNom_gac($nom_gac);
             $gac->setCode_type_gac($type_gac);
             $gac->setCode_zone($code_zone);
             $gac->setCode_membre_gestionnaire($request->getParam("code_membre"));
             $gac->setDate_creation($date_idd->toString('yyyy-MM-dd'));
             $gac->setId_utilisateur($user->id_utilisateur);
			 $gac->setType_gac($appartenance);
			 $gac->setZone($code_zone);
			 $gac->setId_pays($id_pays);
			 $gac->setId_region($id_region);
			 $gac->setId_prefecture($id_prefecture);
			 $gac->setId_canton($id_canton);
             $gac->setGroupe('GAC');
			 $gac->setCode_secteur(null);
			 $gac->setCode_agence($code_agence);
             $gac->setCode_gac_create(null);
             $gac->setCode_gac_chaine($user->code_acteur);
             $gac_mapper->save($gac);
			
			 //insertion dans la table eu_acteur
			 $t_acteur = new Application_Model_DbTable_EuActeur();
             $c_acteur = new Application_Model_EuActeur();
			 $tetedivision = "";
			 if($type_gac == "GAC_DETENTRICE") {
			   $tetedivision = "TECHNOPOLE"; 
			 } elseif($type_gac == "GAC_SURVEILLANCE") {
			   $tetedivision = "FILIERE";
			 } elseif($type_gac == "GAC_EXECUTANTE") {
			   $tetedivision = "ACNEV";
			 }
						  
			 $count = $c_acteur->findConuter() + 1;
			 $c_acteur->setId_acteur($count)
                     ->setCode_acteur($code_gac)
			         ->setCode_division(NULL)
                     ->setCode_membre($code_membre)
                     ->setType_acteur($tetedivision)
                     ->setId_utilisateur($user->id_utilisateur)
                     ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					 
			 if($appartenance == 'SOURCE') {
			   $c_acteur->setCode_activite('SOURCE');
			   $c_acteur->setCode_source_create('SOURCE');
			   $c_acteur->setCode_monde_create('MONDE');
			   $c_acteur->setCode_zone_create($code_zone);
			   $c_acteur->setId_pays($id_pays);
			   $c_acteur->setId_region($id_region);
			   $c_acteur->setId_prefecture($id_prefecture);
			   $c_acteur->setId_canton($id_canton);
			   $c_acteur->setCode_secteur_create(NULL);
			   $c_acteur->setCode_agence_create(NULL);
			   
			 } else if($appartenance == 'MONDE') {
			   $c_acteur->setCode_activite('MONDE');
			   $c_acteur->setCode_source_create('SOURCE');
			   $c_acteur->setCode_monde_create('MONDE');
			   $c_acteur->setCode_zone_create($code_zone);
			   $c_acteur->setId_pays($id_pays);
			   $c_acteur->setId_region($id_region);
			   $c_acteur->setId_prefecture($id_prefecture);
			   $c_acteur->setId_canton($id_canton);
			   $c_acteur->setCode_secteur_create(NULL);
			   $c_acteur->setCode_agence_create(NULL);
							 
			 } else if($appartenance == 'ZONE') {
			   $c_acteur->setCode_activite('ZONE');
			   $c_acteur->setCode_source_create('SOURCE');
			   $c_acteur->setCode_monde_create('MONDE');
			   $c_acteur->setCode_zone_create($code_zone);
			   $c_acteur->setId_pays($id_pays);
			   $c_acteur->setId_region($id_region);
			   $c_acteur->setId_prefecture($id_prefecture);
			   $c_acteur->setId_canton($id_canton);
			   $c_acteur->setCode_secteur_create(NULL);
			   $c_acteur->setCode_agence_create(NULL);
			   
			 } else if($appartenance == 'PAYS') {
			   $c_acteur->setCode_activite('PAYS');
			   $c_acteur->setCode_source_create('SOURCE');
			   $c_acteur->setCode_monde_create('MONDE');
			   $c_acteur->setCode_zone_create($code_zone);
			   $c_acteur->setId_pays($id_pays);
			   $c_acteur->setId_region($id_region);
			   $c_acteur->setId_prefecture($id_prefecture);
			   $c_acteur->setId_canton($id_canton);
			   $c_acteur->setCode_secteur_create(NULL);
			   $c_acteur->setCode_agence_create(NULL);
							 
			 } else if($appartenance == 'REGION') {
			   $c_acteur->setCode_activite('REGION');
			   $c_acteur->setCode_source_create('SOURCE');
			   $c_acteur->setCode_monde_create('MONDE');
			   $c_acteur->setCode_zone_create($code_zone);
			   $c_acteur->setId_pays($id_pays);
			   $c_acteur->setId_region($id_region);
			   $c_acteur->setId_prefecture($id_prefecture);
			   $c_acteur->setId_canton($id_canton);
			   $c_acteur->setCode_secteur_create(NULL);
			   $c_acteur->setCode_agence_create(NULL);
			   
			 } else if($appartenance == 'PREFECTURE') {
			   $c_acteur->setCode_activite('PREFECTURE');
			   $c_acteur->setCode_source_create('SOURCE');
			   $c_acteur->setCode_monde_create('MONDE');
			   $c_acteur->setCode_zone_create($code_zone);
			   $c_acteur->setId_pays($id_pays);
			   $c_acteur->setId_region($id_region);
			   $c_acteur->setId_prefecture($id_prefecture);
			   $c_acteur->setId_canton($id_canton);
			   $c_acteur->setCode_secteur_create(NULL);
			   $c_acteur->setCode_agence_create(NULL);
						  
			 } else if($appartenance == 'CANTON')   { 
				$c_acteur->setCode_activite('CANTON');
				$c_acteur->setCode_source_create('SOURCE');
				$c_acteur->setCode_monde_create('MONDE');
				$c_acteur->setCode_zone_create($code_zone);
				$c_acteur->setId_pays($id_pays);
				$c_acteur->setId_region($id_region);
				$c_acteur->setId_prefecture($id_prefecture);
				$c_acteur->setId_canton($id_canton);
				$c_acteur->setCode_secteur_create(NULL);
				$c_acteur->setCode_agence_create(NULL);
			  }
						  
			   $c_acteur->setCode_gac_chaine(null);
			   $t_acteur->insert($c_acteur->toArray());
			   
			   //////// insertion dans la table eu_utilisateur ///////////////////////////////
			   $user_mapper = new Application_Model_EuUtilisateurMapper();
               $userin = new Application_Model_EuUtilisateur();
               $membre_mapper = new Application_Model_EuMembreMapper();
               $membrein = new Application_Model_EuMembre();
               $find_membre = $membre_mapper->find($code_membre,$membrein);
               $id_user = $user_mapper->findConuter() + 1;
						  
			   $userin->setId_utilisateur($id_user);
               $userin->setId_utilisateur_parent($user->id_utilisateur); 
               $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
               $userin->setNom_utilisateur($membrein->getNom_membre());
               $userin->setLogin($login);
               $userin->setPwd(md5($pwd));
               $userin->setDescription(null);
               $userin->setUlock(0);
               $userin->setCh_pwd_flog(0);
						  
			   if($appartenance == 'SOURCE' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice');
			     $userin->setCode_groupe_create('detentrice');			 
			   } elseif($appartenance == 'MONDE' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_monde');
			     $userin->setCode_groupe_create('detentrice_monde');			 
               } elseif($appartenance == 'ZONE' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_zone');
			     $userin->setCode_groupe_create('detentrice_zone');			 
               } elseif($appartenance == 'PAYS' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_pays');
				 $userin->setCode_groupe_create('detentrice_pays');			 
               } elseif($appartenance == 'REGION' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_region');
			     $userin->setCode_groupe_create('detentrice_region');			 
               } elseif($appartenance == 'PREFECTURE' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_secteur');
			     $userin->setCode_groupe_create('detentrice_secteur');			 
               } elseif($appartenance == 'CANTON' && $type_gac == "GAC_DETENTRICE") {
                 $userin->setCode_groupe('detentrice_agence');
				 $userin->setCode_groupe_create('detentrice_agence');			 
               } else if($appartenance == 'SOURCE' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance');
				 $userin->setCode_groupe_create('surveillance');			 
			   } elseif($appartenance == 'MONDE' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_monde');
			     $userin->setCode_groupe_create('surveillance_monde');			 
               } elseif($appartenance == 'ZONE' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_zone');
				 $userin->setCode_groupe_create('surveillance_zone');			 
               } elseif($appartenance == 'PAYS' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_pays');
			     $userin->setCode_groupe_create('surveillance_pays');			 
               } elseif($appartenance == 'REGION' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_region');
			     $userin->setCode_groupe_create('surveillance_region');			 
               } elseif($appartenance == 'PREFECTURE' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_secteur');
			     $userin->setCode_groupe_create('surveillance_secteur');			 
               } elseif($appartenance == 'CANTON' && $type_gac == "GAC_SURVEILLANCE") {
                 $userin->setCode_groupe('surveillance_agence');
			     $userin->setCode_groupe_create('surveillance_agence');		 
               } else if($appartenance == 'SOURCE' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante');
				 $userin->setCode_groupe_create('executante');			 
			   } elseif($appartenance == 'MONDE' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_monde');
				 $userin->setCode_groupe_create('executante_monde');			 
               } elseif($appartenance == 'ZONE' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_zone');
			     $userin->setCode_groupe_create('executante_zone');			 
               } elseif($appartenance == 'PAYS' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_pays');
				 $userin->setCode_groupe_create('executante_pays');			 
               } elseif($appartenance == 'REGION' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_region');
				 $userin->setCode_groupe_create('executante_region');			 
               } elseif($appartenance == 'PREFECTURE' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_secteur');
			     $userin->setCode_groupe_create('executante_secteur');			 
               } elseif($appartenance == 'CANTON' && $type_gac == "GAC_EXECUTANTE") {
                 $userin->setCode_groupe('executante_agence');
			     $userin->setCode_groupe_create('executante_agence');			 
               }
						  
			   $userin->setConnecte(0);
               $userin->setCode_agence($code_agence);
               $userin->setCode_secteur(NULL);
               $userin->setCode_zone($code_zone);
               $userin->setId_filiere(NULL);
               $userin->setCode_acteur($code_gac);
                   
               $userin->setCode_membre($code_membre);
               $userin->setId_pays($id_pays);
               $userin->setId_canton($id_canton);						  
               $user_mapper->save($userin); 
				
				
			   $db->commit();
               return $this->_helper->redirector('listgac', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'listgac'));
	       } catch(Exception $exc) {
              $db->rollback();
              $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
              return;
           }
	   }
	
	}
	

    public function datagacAction()  {
	  $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $user = $auth->getIdentity();
      $this->_helper->layout->disableLayout();
      $page = $this->_request->getParam("page", 1);
      $limit = $this->_request->getParam("rows", 10);
      $sidx = $this->_request->getParam("sidx", 'code_gac');
      $sord = $this->_request->getParam("sord", 'asc');
      $type = $this->_request->getParam("type");
        
      $tabela = new Application_Model_DbTable_EuGac();
	  $select = $tabela->select();
	  $select->where('id_utilisateur = ?', $user->id_utilisateur); 
       
      $membres = $tabela->fetchAll($select);
      $count = count($membres);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if($page > $total_pages) $page = $total_pages;
        $agences = $tabela->fetchAll($select, "$sidx $sord", $limit, ($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;
		
        foreach ($agences as $row) {
         $responce['rows'][$i]['id'] = $row->code_gac;
         $responce['rows'][$i]['cell'] = array(
            $row->code_gac,
            $row->code_type_gac,
			$row->nom_gac,
            $row->type_gac,
            $row->code_membre_gestionnaire
          );
          $i++;
        }
    
	    $this->view->data = $responce;
	}
	
    public function dataAction() {
      $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
      $user = $auth->getIdentity();
      $this->_helper->layout->disableLayout();
      $page = $this->_request->getParam("page", 1);
      $limit = $this->_request->getParam("rows", 10);
      $sidx = $this->_request->getParam("sidx", 'code_membre');
      $sord = $this->_request->getParam("sord", 'asc');
      $type = $this->_request->getParam("type");
      $membre = $this->_request->getParam("membre");
      $nom_membre = $this->_request->getParam("nom_membre");
      $prenom_membre = $this->_request->getParam("prenom_membre");
      $raison = $this->_request->getParam("raison");
      $date = $this->_request->getParam("date");
      $agence = $this->_request->getParam("agence");
	    if($type=="M") {
               $tabela = new Application_Model_DbTable_EuMembreMorale();
			   if($membre !='') {
			      $select = $tabela->select();
	              $select->where('code_membre_morale = ?',$membre);
	              $select->where('id_utilisateur = ?', $user->id_utilisateur);
	           }
               else {
			        $select = $tabela->select();
	                $select->where('id_utilisateur = ?', $user->id_utilisateur); 
               }			   
	  }
	  else {
	       $tabela = new Application_Model_DbTable_EuMembre();
		   $select = $tabela->select();
		   if($membre !='') {
		      $select->where('code_membre = ?',$membre);
	          $select->where('id_utilisateur = ?', $user->id_utilisateur);
		      $select->where('code_membre like ?','%P');
		      $select->order('code_membre');
		   } else {
			  $select = $tabela->select();
	          $select->where('id_utilisateur = ?', $user->id_utilisateur); 
           }	  
	  }
       
      $membres = $tabela->fetchAll($select);
      $count = count($membres);

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
		if($type=="M") {
        foreach ($agences as $row) {
         $responce['rows'][$i]['id'] = $row->code_membre_morale;
         $responce['rows'][$i]['cell'] = array(
            $row->code_membre_morale,
            $row->code_type_acteur,
			$row->code_statut,
            $row->raison_sociale,
			$row->domaine_activite,
			$row->ville_membre,
            $row->tel_membre,
            $row->portable_membre
          );
          $i++;
        }
	}
    else {
        foreach ($agences as $row) {
        $responce['rows'][$i]['id'] = $row->code_membre;
        $responce['rows'][$i]['cell'] = array(
           $row->code_membre,
           $row->nom_membre,
           $row->prenom_membre,
           $row->sexe_membre,
           $row->profession_membre,
           $row->portable_membre,
           $row->ville_membre
        );
        $i++;
        }
    }	 
        $this->view->data = $responce;
    }


    public function detailAction() {
        $this->_helper->layout->disableLayout(); 
        $num_membre = $this->getRequest()->membre;
        $mapper = new Application_Model_EuMembreMapper();
        $membre = new Application_Model_EuMembre();
        //$mapper->find($num_membre, $membre);
		$membre=$mapper->detail($num_membre);
        $this->view->membre = $membre;
    }


    public function mdetailAction() {
        $this->_helper->layout->disableLayout();
        $num_membre = $this->getRequest()->membre;
        $mapper = new Application_Model_EuMembreMoraleMapper();
        $membre = new Application_Model_EuMembreMorale();
        $mapper->find($num_membre,$membre);
        $this->view->membre = $membre;
    }

	
	
	

    public function saveAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $membre = new Application_Model_EuMembre();
        $mz = new Application_Model_EuMembreMapper();
        $oper = $this->_request->getPost("oper");
        //  $date_fin = new Zend_Date(Zend_Date::ISO_8601);

        if ($oper == "edit") {
            $membre->setNum_membre($this->_request->getPost("num_membre"));
            $membre->setNom_membre($this->_request->getPost("nom_membre"));
            $membre->setPrenom_membre($this->_request->getPost("prenom_membre"));
            $membre->setPortable_membre($this->_request->getPost("portable_membre"));
            $mz->update($membre);
        } elseif ($oper == "del") {
            $id = $this->_request->getPost("num_membre");
            $mz->delete($id);
        }
    }


    public function changeAction() {
        $data = array();
        $membre = new Application_Model_DbTable_EuMembre();
        $select = $membre->select();
        $select->from($membre, array('code_membre'));
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
            $data[] = $m->code_membre;
        }
        $this->view->data = $data;
    }

	

    public function changepAction() {
        $data = array();
        $membre = new Application_Model_DbTable_EuMembre();
        $select = $membre->select();
        $select->from($membre, array('code_membre'))
               ->where('code_membre like ?', '%P');
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
             $data[] = $m->code_membre;
        }
        $this->view->data = $data;
    }

	
	

    public function changemAction() {
        $data = array();
        $membre = new Application_Model_DbTable_EuMembreMorale();
        $select = $membre->select();
        $select->from($membre, array('code_membre_morale'))
                ->order('code_membre_morale asc');
        $result = $membre->fetchAll($select);
        foreach ($result as $m) {
                $data[] = $m->code_membre_morale;
        }
        $this->view->data = $data;
    }

	
	
	public function verifierAction() {
	
	
	}
	
	
	
	
	public function dataverifierAction() {
	    $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows", 10);
        $sidx = $this->_request->getParam("sidx", 'neng');
        $sord = $this->_request->getParam("sord", 'asc');
		$tabela = new Application_Model_DbTable_EuSmsmoney();
		$code = $this->_request->getParam("code");
		
        $select = $tabela->select();
		if ($code != '') {
		   $select->where('motif like ?','FS')
		          ->order('neng DESC')
				  ->where('creditcode like ?',$code);
		} else {
           $select->where('motif like ?','FS')
		          ->order('neng DESC');
        }		
		$achats = $tabela->fetchAll($select);
        $count = count($achats);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages)
           $page = $total_pages;
        $achats = $tabela->fetchAll($select,"$sidx $sord",$limit,($page * $limit - $limit));

        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;
        $i = 0;

        foreach ($achats as $row) {
		    if($row->destaccount_consumed == null) {
			    $entree = 0;
				$solde  = $row->creditamount;
			} else {
			    $entree = $row->creditamount;
				$solde  = 0;
			}
            $responce['rows'][$i]['id'] = $row->neng;
            $responce['rows'][$i]['cell'] = array(
              $row->neng,
              $row->fromaccount,
              $row->creditcode,
              $row->motif,
			  $row->creditamount,
			  $entree,
              $solde
            );
            $i++;
        }
        $this->view->data = $responce;
	
	}
	
	
	
	
	public function newpmoseAction() {
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
           $code_agence = $user->code_agence;
           $fs = Util_Utils::getParametre('FS','valeur');
           $this->view->fs = $fs;
		   //$groupe = trim($user->code_groupe);
		   $acteur = $user->code_acteur;
           if ($this->getRequest()->isPost()) {
              $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;
              $code_sms = $_POST["code_sms"];
			  
			  $id_type_acteur = "";
			  $id_type_creneau = "";
			  $id_filiere = "";
			  
			  //$groupe = trim($user->code_groupe);
			    $table = new Application_Model_DbTable_EuActeur();
			    //$select = $table->select();
			    //$select->where('code_acteur like ?',$user->code_acteur);
			    //$result = $table->fetchAll($select);
			    //$findacteur = $result->current();
			    //$code_gac_chaine = $findacteur->code_gac_chaine;
			    //$selection = $table->select();
			    //$selection->where('code_gac_chaine like ?',$code_gac_chaine);
			    //$selection->where('type_acteur like ?','gac_surveillance');
			    //$resultat = $table->fetchAll($selection);
			    //$trouvacteursur = $resultat->current();
			    //$acteur = $trouvacteursur->code_acteur;
				
				$acteur = $user->code_acteur;
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                  $frais_identification = trim($_POST["frais_identification"]);  
                  $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                  $agrement_mapper = new Application_Model_EuAgrementMapper();
                  $agrement        = new Application_Model_EuAgrement();
                  $sms = $sms_mapper->findByCreditCode($code_sms);
                   
                  $agrement_filiere  =  $_POST["agrement_filiere"];
                  $agrement_acnev    =  $_POST["agrement_acnev"];
                  $agrement_technopole =  $_POST["agrement_technopole"];
				  
                    if ($sms != null)  { 
                        $mont = $sms->getCreditAmount();
                        if ($mont == $frais_identification) {
                            if($sms->getMotif() != 'FS') {
                              $db->rollBack();
                              $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                              $this->view->type_acteur = $_POST["type_acteur"];
                              $this->view->statut_juridique = $_POST["statut_juridique"];
                              $this->view->raison = $_POST["raison_sociale"];
                              $this->view->domaine_activite = $_POST["domaine_activite"];
                              $this->view->site_web = $_POST["site_web"];
                              $this->view->quartier_membre = $_POST["quartier_membre"];
                              $this->view->ville_membre = $_POST["ville_membre"];
                              $this->view->bp = $_POST["bp_membre"];
                              $this->view->tel = $_POST["tel_membre"];
                              $this->view->email = $_POST["email_membre"];
                              $this->view->portable = $_POST["portable_membre"];
                              //$this->view->profession = $_POST["profession_membre"];
                              $this->view->registre = $_POST["num_registre"];
                              return;    
                        }
                   
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }  
                        

                        
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
                        $membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        
						
						   // verification agrement filiere
						if($trouveagrementf != false) {
                            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_type_acteur =  $agrement->getId_type_acteur();
							$id_filiere =  $agrement->getId_filiere();
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
							
							
							//insertion dans la table membre
                            $membre->setId_filiere($id_filiere);
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
                            $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                            $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                            $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                            $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($user->id_utilisateur);
                            $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('O');
                            $membre->setEtat_membre('N');
                            $mapper->save($membre);
                     
							
                            // eu_acteurs_creneau
                            $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
                            
                            $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
							
                            
							// insertion dans la table eu_acteurs_creneaux
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($user->id_utilisateur);
                            $acren->setGroupe(trim($user->code_groupe));
							$acren->setId_type_acteur($id_type_acteur);
                            $acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
                            
                            
                            $code_zone = $user->code_zone;
                            $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'A' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                            }
                        
                            $acren->setCode_acteur($code_acteur);
                            $acren->setId_filiere($id_filiere);
                            $cm->save($acren);   
                            
                            // insertion dans la table eu_operation
                            Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                            
                            //insertion dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                        
						
                            //insertion dans la table eu_compte_bancaire
                            $cpte = $_POST['cpteur'];
                            $i = 1;
                            $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $id_compte = $cb_mapper->findConuter() + 1;
                            $cb = new Application_Model_EuCompteBancaire();
                            while ($i <= $cpte) {
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                                    $cb->setId_compte($id_compte)
                                       ->setCode_banque($_POST['code_banque' . $i])
                                       ->setCode_membre_morale($code)
                                       ->setCode_membre(null)
                                       ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                    $cb_mapper->save($cb);
                            }
                                $i++;
                            }                           
                        
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						// verification agrement acnev
                        if($trouveagrementacnev != false) {
                            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						// verification agrement technopole
                        if($trouveagrementtechno != false) {
                            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                               $db->rollBack();
                               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
                               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
                        }
						
                        $filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($id_filiere,$filiere);
                        $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						
						$t_cmfh = new Application_Model_DbTable_EuCmfh();
                        $c_cmfh = new Application_Model_EuCmfh();
						
                        $count = $c_acteur->findConuter() + 1;
						$countcmfh = $c_cmfh->findConuter() + 1;
						
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
						
						// insertion dans la table eu_acteur
                        $c_acteur->setId_acteur($count);
                        $c_acteur->setCode_acteur(null);
						$c_acteur->setCode_division($filiere->getCode_division());
                        $c_acteur->setCode_membre($code);
                        $c_acteur->setId_utilisateur($user->id_utilisateur);
                        $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
						$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						$c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						$c_acteur->setId_pays($ligneacteur->id_pays);
						$c_acteur->setId_region($ligneacteur->id_region);
						$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
						//$c_acteur->setId_sub_secteur($ligneacteur->id_sub_secteur);
                               
                        if($id_type_acteur == 3) {
                          $c_acteur->setCode_activite('detaillant');	
                        } elseif($id_type_acteur == 2) {
                          $c_acteur->setCode_activite('semi-grossiste');  
                        } elseif($id_type_acteur == 1) {
                          $c_acteur->setCode_activite('grossiste'); 
                        }
						//if(isset($_POST['actcmfh'])) {	
                        //  $c_acteur->setType_acteur('CMFH');	
						//} else 
						if(isset($_POST['actenro'])) {
						  $c_acteur->setType_acteur('DSMS');	
					    } else {
						  $c_acteur->setType_acteur('DSMS');  
						}	
						$c_acteur->setCode_gac_chaine($acteur);         
                        $t_acteur->insert($c_acteur->toArray());
						
						if(isset($_POST['actcmfh'])) {
						    // insertion dans la table eu_cmfh
                            $c_cmfh->setId_cmfh($countcmfh);
                            $c_cmfh->setCode_membre($code);
                            $c_cmfh->setId_utilisateur($user->id_utilisateur);
                            $c_cmfh->setDate_creation($date_idd->toString('yyyy-MM-dd'));
						    $c_cmfh->setCode_source_create($ligneacteur->code_source_create);
						    $c_cmfh->setCode_monde_create($ligneacteur->code_monde_create);
						    $c_cmfh->setCode_zone_create($ligneacteur->code_zone_create);
						    $c_cmfh->setId_pays($ligneacteur->id_pays);
						    $c_cmfh->setId_region($ligneacteur->id_region);
						    $c_cmfh->setCode_secteur_create($ligneacteur->code_secteur_create);
						    $c_cmfh->setCode_agence_create($ligneacteur->code_agence_create);   
                            $c_cmfh->setCode_activite(null);	
						    $c_cmfh->setType_acteur('CMFH');  	
						    $c_cmfh->setCode_gac_chaine($acteur);         
                            $t_cmfh->insert($c_cmfh->toArray());
						}
						
                        //Recuperation de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prc = 0;
                        $par_prc = $param->find('prc', 'nr', $par);
                        if ($par_prc == true) {
                           $prc = $par->getMontant();
                        }
                       
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'TEGCP' .$id_filiere. $code;
                        $find_te = $te_mapper->find($code_te,$te);
						
						// insertion dans la table eu_tegc
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
                              ->setId_filiere($id_filiere)
                              ->setMdv($prc)
                              ->setCode_membre($code)
                              ->setMontant(0)
							  ->setMontant_utilise(0)
							  ->setSolde_tegc(0);
                            $te_mapper->save($te);
                        } else {
                            $te->setId_filiere($id_filiere);
                            $te->setMdv($prc);
                            $te_mapper->update($te);
                        } 
					
                        // table eu_utilisateur
                        $membre_mapper = new Application_Model_EuMembreMapper();
                        $membrein = new Application_Model_EuMembre();
					    $userin = new Application_Model_EuUtilisateur();
					    $user_mapper = new Application_Model_EuUtilisateurMapper();                   
                        $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                        $id_user = $user_mapper->findConuter() + 1;
						
						// insertion dans la table eu_utilisateur
                        $userin->setId_utilisateur($id_user);
                        $userin->setId_utilisateur_parent($user->id_utilisateur); 
                        $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                        $userin->setNom_utilisateur($membrein->getNom_membre());
                        $userin->setLogin($code);
                        $userin->setPwd(md5($_POST["codesecret"]));
                        $userin->setDescription(null);
                        $userin->setUlock(0);
                        $userin->setCh_pwd_flog(0);
                        if($id_type_acteur == 3) {
                           $userin->setCode_groupe('ose_detaillant');
                           $userin->setCode_gac_filiere('ose_detaillant');
					       $userin->setCode_groupe_create('ose_detaillant');
                        } elseif($id_type_acteur == 2) {
                          $userin->setCode_groupe('ose_semi_grossiste');
					      $userin->setCode_groupe_create('ose_semi_grossiste');
                          $userin->setCode_gac_filiere(null);
                        } elseif($id_type_acteur == 1) {
                          $userin->setCode_groupe('ose_grossiste');
					      $userin->setCode_groupe_create('ose_grossiste');
                          $userin->setCode_gac_filiere(null);
                        }
						
                        $userin->setConnecte(0);
                        $userin->setCode_agence($code_agence);
                        $userin->setCode_secteur(null);
                        $userin->setCode_zone($code_zone);
                        $userin->setId_filiere($id_filiere);
                    
                        $userin->setCode_acteur($acteur);
                    
                        $userin->setCode_membre($code);
                        $userin->setId_pays($user->id_pays);            
                        $user_mapper->save($userin);
					
					    
					
					
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					// insertion dans la table eu_contrat
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(3);
                    $contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					
					/*if(trim($user->code_groupe) == 'scmd') {
                       $contrat->setId_type_acteur(3);
					} elseif(trim($user->code_groupe) == 'scmsg') {
                       $contrat->setId_type_acteur(2);
                    } elseif(trim($user->code_groupe) == 'scmg') {
                       $contrat->setId_type_acteur(1);
                    }*/
					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					      
                    } else {
                           $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                    }                     
                    } else {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       //$this->view->profession = $_POST["profession_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
                }
                   
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('FS-'.$code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());

                    // Mise à jour de la table eu_smsmoney					
                    $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);  
					
                    $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));      
                } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }    
               
            }
	
	}
	
	

    public function newpmpbfAction() {
            $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
            $request = $this->getRequest();
            $code_agence = $user->code_agence;
            $fs = Util_Utils::getParametre('FS','valeur');
            $this->view->fs = $fs;
		    $utilisateur = $user->id_utilisateur;
		    $code_groupe = $user->code_groupe;
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
			$acteur = $trouvacteursur->code_acteur;
			//$acteur = $user->code_acteur;
		  
            if ($this->getRequest()->isPost()) {
               $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               $code_sms = $_POST["code_sms"];
			   $id_type_creneau="";
			   $id_type_acteur ="";
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
                try {
                   $frais_identification = trim($_POST["frais_identification"]);  
                   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                   $agrement_mapper = new Application_Model_EuAgrementMapper();
                   $agrement        = new Application_Model_EuAgrement();
                   $sms = $sms_mapper->findByCreditCode($code_sms);
                   
                   $agrement_filiere  =  $_POST["agrement_filiere"];
                   $agrement_acnev    =  $_POST["agrement_acnev"];
                   $agrement_technopole =  $_POST["agrement_technopole"];
                   if ($sms != null)  { 
                        $mont = $sms->getCreditAmount();
                        if ($mont == $frais_identification) {
                           if($sms->getMotif() != 'FS') {
                           $db->rollBack();
                           $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;    
                        }
                        
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
						$membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }  

                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
                        
						// verification de agrement filiere
                        if($trouveagrementf != false) {
                            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
							
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_type_acteur = $agrement->getId_type_acteur();
							$id_filiere = $agrement->getId_filiere();
							
							
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
							
							//insertion dans la table eu_membre
                            $membre->setId_filiere($id_filiere);
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(htmlentities (addslashes (trim ($_POST["raison_sociale"]))));
                            $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(htmlentities (addslashes (trim ($_POST["domaine_activite"]))));
                            $membre->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))));
                            $membre->setQuartier_membre(htmlentities (addslashes (trim ($_POST["quartier_membre"]))));
                            $membre->setVille_membre(htmlentities (addslashes (trim ($_POST["ville_membre"]))));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($utilisateur);
                            $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('O');
                            $membre->setEtat_membre('N');
                            $mapper->save($membre);
                            
							
                            // insertion dans la table eu_acteurs_creneau
                            $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
                            
                            $acren->setNom_acteur($_POST["raison_sociale"]);
                            $acren->setCode_membre($code);
							
                            //$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($utilisateur);
                            $acren->setGroupe($code_groupe);
                            $acren->setCode_creneau(null);
							$acren->setId_type_acteur($id_type_acteur);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
                            
                            
                            $code_zone = $user->code_zone;
                            $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'A' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                            }
                        
                            $acren->setCode_acteur($code_acteur);
                            $acren->setId_filiere($id_filiere);
                            $cm->save($acren);   
                            
                            // insertion dans la table eu_operation
                            Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                            
                            //insertion dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                        
                            //insertion dans la table eu_compte_bancaire
                            $cpte = $_POST['cpteur'];
                            $i = 1;
                            $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $id_compte = $cb_mapper->findConuter() + 1;
                            $cb = new Application_Model_EuCompteBancaire();
                            while ($i <= $cpte) {
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                                $cb->setId_compte($id_compte)
                                   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
                                   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                            }                           
                        
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						// verification agrement acnev
                        if($trouveagrementacnev != false) {
                            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						// verification agrement technopole
                        if($trouveagrementtechno != false) {
                            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                               $db->rollBack();
                               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
                               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
                        }
                        
						$filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($id_filiere,$filiere);
                        $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $count = $c_acteur->findConuter() + 1;
						// insertion dans la table eu_acteur
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
								 
						$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						$c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						$c_acteur->setId_pays($ligneacteur->id_pays);
						$c_acteur->setId_region($ligneacteur->id_region);
						$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);	
                        						
                               
                        if($id_type_acteur == 3) {
                            $c_acteur->setCode_activite('detaillant');			
                        } elseif($id_type_acteur == 2) {
                            $c_acteur->setCode_activite('semi-grossiste');			
                        } elseif($id_type_acteur == 1) {
                            $c_acteur->setCode_activite('grossiste');			
                        }
                    
                        $c_acteur->setType_acteur('PBF');
					    $c_acteur->setCode_gac_chaine($acteur);
                        $t_acteur->insert($c_acteur->toArray());
                               
					    //R�cup�ration de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prc = 0;
                        $par_prc = $param->find('prc', 'nr', $par);
                        if ($par_prc == true) {
                           $prc = $par->getMontant();
                        }
                       
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'TEGCP' .$id_filiere. $code;
                        $find_te = $te_mapper->find($code_te,$te);
						
						//insertion dans la table eu_tegc
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
                               ->setId_filiere($id_filiere)
                               ->setMdv($prc)
                               ->setCode_membre($code)
                               ->setMontant(0)
							   ->setMontant_utilise(0)
							   ->setSolde_tegc(0);
                            $te_mapper->save($te);
                        } else {
                            $te->setId_filiere($id_filiere);
                            $te->setMdv($prc);
                            $te_mapper->update($te);
                        } 
                    
                    // insertion dans la table eu_utilisateur
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					$userin = new Application_Model_EuUtilisateur();
					$user_mapper = new Application_Model_EuUtilisateurMapper();                   
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                    $id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if($id_type_acteur == 3) {
                      $userin->setCode_groupe('pbf_detaillant');
                      $userin->setCode_gac_filiere('pbf_detaillant');
					  $userin->setCode_groupe_create('pbf_detaillant');
                    } elseif($id_type_acteur == 2) {
                      $userin->setCode_groupe('pbf_semi_grossiste');
					  $userin->setCode_groupe_create('pbf_semi_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } elseif($id_type_acteur == 1) {
                      $userin->setCode_groupe('pbf_grossiste');
					  $userin->setCode_groupe_create('pbf_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
                    
                    $userin->setCode_acteur($acteur);
                    
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays);            
                    $user_mapper->save($userin);
					
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
                    $contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    $mapper_contrat->save($contrat);
					      
                    } else {
                           $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                    }                     
                   
                   } else {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       //$this->view->profession = $_POST["profession_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
                    }
                   
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());
					
					// Mise à jour de eu_smsmoney
                    $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);  
					
                    $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est : " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));       
                   
                } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }   
               
            }
    }

    // 
	public function newpmdAction() {
	
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
           $code_agence = $user->code_agence;
           $fs = Util_Utils::getParametre('FS','valeur');
           $this->view->fs = $fs;
		   $utilisateur = $user->id_utilisateur;
		   $code_groupe = $user->code_groupe;
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
			   $acteur = $trouvacteursur->code_acteur;
		   
            if ($this->getRequest()->isPost()) {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $code_sms = $_POST["code_sms"];
			    $id_type_creneau = "";
			    $id_type_acteur = "";
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                   $frais_identification = trim($_POST["frais_identification"]);  
                   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                   $agrement_mapper = new Application_Model_EuAgrementMapper();
                   $agrement        = new Application_Model_EuAgrement();
                   $sms = $sms_mapper->findByCreditCode($code_sms);
                   
                   $agrement_filiere  =  $_POST["agrement_filiere"];
                   $agrement_acnev    =  $_POST["agrement_acnev"];
                   $agrement_technopole =  $_POST["agrement_technopole"];
                   if ($sms != null)  { 
                      $mont = $sms->getCreditAmount();
                      if ($mont == $frais_identification) {
                        if($sms->getMotif() != 'FS') {
                           $db->rollBack();
                           $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;    
                        }
                        
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
						$membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }  

                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
                        
						// Mise à jour agrement filiere
                        if($trouveagrementf != false) {
                            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_type_acteur = $agrement->getId_type_acteur();
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
							
							// insertion dans la table eu_membre
                            $membre->setId_filiere($membre1->getId_filiere());
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
                            $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                            $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                            $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                            $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($utilisateur);
                            $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('O');
                            $membre->setEtat_membre('N');
                            $mapper->save($membre);
							
                            // insertion dans la table eu_acteurs_creneau
                            $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
                            
                            $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
							$acren->setId_type_acteur($id_type_acteur);
							
							
                            //$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($utilisateur);
                            $acren->setGroupe($code_groupe);
                            $acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
                            
                            
                            $code_zone = $user->code_zone;
                            $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'A' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                            }
                        
                            $acren->setCode_acteur($code_acteur);
                            $acren->setId_filiere($membre1->getId_filiere());
                            $cm->save($acren);   
                            
                           //insertion dans la table eu_operation
                           Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                            
                            //insertion dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                        
                            //insertion dans la table eu_compte_bancaire
                            $cpte = $_POST['cpteur'];
                            $i = 1;
                            $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $id_compte = $cb_mapper->findConuter() + 1;
                            $cb = new Application_Model_EuCompteBancaire();
                            while ($i <= $cpte) {
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                                $cb->setId_compte($id_compte)
                                   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
                                   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                            }                           
                        
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						// verification agrement acnev
                        if($trouveagrementacnev != false) {
                            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						// verification agrement technopole
                        if($trouveagrementtechno != false) {
                            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                               $db->rollBack();
                               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
                               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
                        }
                        
						$filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
                        $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $count = $c_acteur->findConuter() + 1;
						
						
						//verification de la table eu_acteur
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
						$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						$c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						$c_acteur->setId_pays($ligneacteur->id_pays);
						$c_acteur->setId_region($ligneacteur->id_region);
						$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					    $c_acteur->setId_sub_secteur($ligneacteur->id_sub_secteur);		 
                               
                        if($id_type_acteur == 3) {
                            $c_acteur->setCode_activite('detaillant');
								  
                        } elseif($id_type_acteur == 2) {
                            $c_acteur->setCode_activite('semi-grossiste');
								  
                        } elseif($id_type_acteur == 1) {
                            $c_acteur->setCode_activite('grossiste');
									
                        }
                    
                        $c_acteur->setType_acteur('DSMS');
					    $c_acteur->setCode_gac_chaine($acteur);
                                
                        $t_acteur->insert($c_acteur->toArray());
                        //R�cup�ration de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prc = 0;
                        $par_prc = $param->find('prc', 'nr', $par);
                        if ($par_prc == true) {
                            $prc = $par->getMontant();
                        }
                       
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'TEGCP' .$membre1->getId_filiere(). $code;
                        $find_te = $te_mapper->find($code_te,$te);
						
						//insertion de la table eu_tegc
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
                               ->setId_filiere($membre1->getId_filiere())
                               ->setMdv($prc)
                               ->setCode_membre($code)
                               ->setMontant(0)
							   ->setMontant_utilise(0)
							   ->setSolde_tegc(0);
                            $te_mapper->save($te);
                        } else {
                            $te->setId_filiere($membre1->getId_filiere());
                            $te->setMdv($prc);
                            $te_mapper->update($te);
                        } 
                    
                    //insertion dans la table eu_utilisateur
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					$userin = new Application_Model_EuUtilisateur();
					$user_mapper = new Application_Model_EuUtilisateurMapper();                   
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                    $id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if($id_type_acteur == 3) {
                      $userin->setCode_groupe('oe_detaillant');
                      $userin->setCode_gac_filiere('oe_detaillant');
					  $userin->setCode_groupe_create('oe_detaillant');
                    } elseif($id_type_acteur == 2) {
                      $userin->setCode_groupe('oe_semi_grossiste');
					  $userin->setCode_groupe_create('oe_semi_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } elseif($id_type_acteur == 1) {
                      $userin->setCode_groupe('oe_grossiste');
					  $userin->setCode_groupe_create('oe_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($membre1->getId_filiere());
                    
                    $userin->setCode_acteur($acteur);
                    
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays);            
                    $user_mapper->save($userin);
					
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
                    $contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					
					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					      
                    } else {
                           $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                    }                     
                   
                    } else {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       //$this->view->profession = $_POST["profession_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
                    }
                   
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());

					
					// Mise à jour de la table eu_smsmoney
                    $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);  
					
                    $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est : " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));       
                   
                } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
            }   
               
           }
	}
	
	
	public function newpmsAction() {
	        
		   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
           $code_agence = $user->code_agence;
           $fs = Util_Utils::getParametre('FS','valeur');
           $this->view->fs = $fs;
		   $utilisateur = $user->id_utilisateur;
		   $code_groupe = $user->code_groupe;
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
			   $acteur = $trouvacteursur->code_acteur;
		   
            if ($this->getRequest()->isPost()) {
                $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $code_sms = $_POST["code_sms"];
				$id_type_creneau = "";
				$id_type_acteur = "";
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                   $frais_identification = trim($_POST["frais_identification"]);  
                   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                   $agrement_mapper = new Application_Model_EuAgrementMapper();
                   $agrement        = new Application_Model_EuAgrement();
                   $sms = $sms_mapper->findByCreditCode($code_sms);
                   
                   $agrement_filiere  =  $_POST["agrement_filiere"];
                   $agrement_acnev    =  $_POST["agrement_acnev"];
                   $agrement_technopole =  $_POST["agrement_technopole"];
                   if ($sms != null)  { 
                      $mont = $sms->getCreditAmount();
                      if ($mont == $frais_identification) {
                         if($sms->getMotif() != 'FS') {
                           $db->rollBack();
                           $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;    
                        }
                        
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
						$membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }  

                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
                        
						//verification agrement filiere
                        if($trouveagrementf != false) {
                            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
							
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_type_acteur = $agrement->getId_type_acteur();
							
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
                            $membre->setId_filiere($membre1->getId_filiere());
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
                            $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                            $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                            $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                            $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($utilisateur);
                            $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('O');
                            $membre->setEtat_membre('N');
                            $mapper->save($membre);
                            
							
							
                            //insertion dans la table eu_acteurs_creneau
                            $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
                            
                            $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
							$acren->setId_type_acteur($id_type_acteur);
							
                            //$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($utilisateur);
                            $acren->setGroupe($code_groupe);
                            $acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
                            
                            
                            $code_zone = $user->code_zone;
                            $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'A' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                            }
                        
                            $acren->setCode_acteur($code_acteur);
                            $acren->setId_filiere($membre1->getId_filiere());
                            $cm->save($acren);   
                            
                            // eu_operation
                            Util_Utils::addOperation($compteur,null,$code,'tfs', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                            
                            //insertion dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                        
                            //insertion dans la table eu_compte_bancaire
                            $cpte = $_POST['cpteur'];
                            $i = 1;
                            $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $id_compte = $cb_mapper->findConuter() + 1;
                            $cb = new Application_Model_EuCompteBancaire();
                            while ($i <= $cpte) {
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                                $cb->setId_compte($id_compte)
                                   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
                                   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                            }                           
                        
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						//verification agrement acnev
                        if($trouveagrementacnev != false) {
                            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						// verification agrement technopole
                        if($trouveagrementtechno != false) {
                            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                               $db->rollBack();
                               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
                               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
                        }
                        
						$filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
                        $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $count = $c_acteur->findConuter() + 1;
						
						// insertion dans la table eu_acteur
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
								 
                        $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						$c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						$c_acteur->setId_pays($ligneacteur->id_pays);
						$c_acteur->setId_region($ligneacteur->id_region);
						$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
						$c_acteur->setId_sub_secteur($ligneacteur->id_sub_secteur);       
                                
								if($id_type_acteur == 3) {
                                    $c_acteur->setCode_activite('detaillant');	
                                } elseif($id_type_acteur == 2){
                                    $c_acteur->setCode_activite('semi-grossiste');
                                } elseif($id_type_acteur == 1) {
                                    $c_acteur->setCode_activite('grossiste');
									
                                }
                    
                                $c_acteur->setType_acteur('DSMS');
							    $c_acteur->setCode_gac_chaine($acteur);
                                
                                $t_acteur->insert($c_acteur->toArray());
                                //R�cup�ration de la prk nr
                                $param = new Application_Model_EuParametresMapper();
                                $par = new Application_Model_EuParametres();
                                $prc = 0;
                                $par_prc = $param->find('prc', 'nr', $par);
                                if ($par_prc == true) {
                                     $prc = $par->getMontant();
                                }
                       
                                $te_mapper = new Application_Model_EuTegcMapper();
                                $te = new Application_Model_EuTegc();
                                $code_te = 'TEGCP' .$membre1->getId_filiere(). $code;
                                $find_te = $te_mapper->find($code_te,$te);
								
								// insertion dans la table eu_tegc
                                if ($find_te == false) {
                                $te->setCode_tegc($code_te)
                                   ->setId_filiere($membre1->getId_filiere())
                                   ->setMdv($prc)
                                   ->setCode_membre($code)
                                   ->setMontant(0)
							       ->setMontant_utilise(0)
							       ->setSolde_tegc(0);
                                $te_mapper->save($te);
                                } else {
                                    $te->setId_filiere($membre1->getId_filiere());
                                    $te->setMdv($prc);
                                    $te_mapper->update($te);
                                } 
                    
                    //insertion dans la table eu_utilisateur
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					$userin = new Application_Model_EuUtilisateur();
					$user_mapper = new Application_Model_EuUtilisateurMapper();                   
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                    $id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if($id_type_acteur == 3) {
                      $userin->setCode_groupe('oe_detaillant');
                      $userin->setCode_gac_filiere('oe_detaillant');
					  $userin->setCode_groupe_create('oe_detaillant');
                    } elseif($id_type_acteur == 2) {
                      $userin->setCode_groupe('oe_semi_grossiste');
					  $userin->setCode_groupe_create('oe_semi_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } elseif($id_type_acteur == 1) {
                      $userin->setCode_groupe('oe_grossiste');
					  $userin->setCode_groupe_create('oe_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($membre1->getId_filiere());
                    
                    $userin->setCode_acteur($acteur);
                    
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays);            
                    $user_mapper->save($userin);
					
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
                    $contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					      
                    } else {
                           $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                    }                     
                   
                    } else {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       //$this->view->profession = $_POST["profession_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
                    }
                   
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('fs-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());
					
					
                    $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);  
					
                    $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est : " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));       
                   
                } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }   
               
            }
			
	}
	
	
	
	
	public function newpmexAction() {
	       
		   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
           $code_agence = $user->code_agence;
           $fs = Util_Utils::getParametre('FS','valeur');
           $this->view->fs = $fs;
		   $utilisateur = $user->id_utilisateur;
		   $code_groupe = $user->code_groupe;
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
			   $acteur = $trouvacteursur->code_acteur;
		   
            if ($this->getRequest()->isPost()) {
               $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               $code_sms = $_POST["code_sms"];
			   
			   $id_type_acteur = "";
			   $id_type_creneau = "";
			   
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
               try {
                   $frais_identification = trim($_POST["frais_identification"]);  
                   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                   $agrement_mapper = new Application_Model_EuAgrementMapper();
                   $agrement        = new Application_Model_EuAgrement();
                   $sms = $sms_mapper->findByCreditCode($code_sms);
                   
                   $agrement_filiere  =  $_POST["agrement_filiere"];
                   $agrement_acnev    =  $_POST["agrement_acnev"];
                   $agrement_technopole =  $_POST["agrement_technopole"];
                   if ($sms != null)  { 
                      $mont = $sms->getCreditAmount();
                      if ($mont == $frais_identification) {
                         if($sms->getMotif() != 'FS') {
                           $db->rollBack();
                           $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;    
                        }
                        
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
						$membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }  

                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
                        
						//verification agrement filiere
                        if($trouveagrementf != false) {
                            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
							
							$id_type_acteur = $agrement->getId_type_acteur();
							$id_type_creneau = $agrement->getId_type_creneau();
							
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
                            $membre->setId_filiere($membre1->getId_filiere());
							
							// insertion dans la table eu_membre
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
                            $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                            $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                            $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                            $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($utilisateur);
                            $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('O');
                            $membre->setEtat_membre('N');
                            $mapper->save($membre);
							
							
                            // eu_acteurs_creneau
                            $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
                            
                            $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
							$acren->setId_type_acteur($id_type_acteur);
							
							
                            //$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($utilisateur);
                            $acren->setGroupe($code_groupe);
                            $acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
                            
                            
                            $code_zone = $user->code_zone;
                            $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'A' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                            }
                        
                           $acren->setCode_acteur($code_acteur);
                           $acren->setId_filiere($membre1->getId_filiere());
                           $cm->save($acren);   
                            
                           //insertion dans la table eu_operation
                           Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                            
                           //insertion dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                        
                            //insertion dans la table eu_compte_bancaire
                            $cpte = $_POST['cpteur'];
                            $i = 1;
                            $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                            $id_compte = $cb_mapper->findConuter() + 1;
                            $cb = new Application_Model_EuCompteBancaire();
                            while ($i <= $cpte) {
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                                $cb->setId_compte($id_compte)
                                   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
                                   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                            }                           
                        
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						// verification agrement acnev
                        if($trouveagrementacnev != false) {
                            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                            $db->rollBack();
                            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
                        }
                        
						
						// verification agrement technopole
                        if($trouveagrementtechno != false) {
                            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
                            $agrement->setCode_membre_morale($code);
                            $agrement_mapper->update($agrement);
                                
                        } else {
                               $db->rollBack();
                               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
                               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
                        }
                        
						$filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
						
                        $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $count = $c_acteur->findConuter() + 1;
						
						// insertion dans la table eu_acteur
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                        $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						$c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						$c_acteur->setId_pays($ligneacteur->id_pays);
						$c_acteur->setId_region($ligneacteur->id_region);
						$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					    $c_acteur->setId_sub_secteur($ligneacteur->id_sub_secteur);       
                                
						if($id_type_acteur == 3) {
                            $c_acteur->setCode_activite('detaillant');
                        } elseif($id_type_acteur == 2) {
                            $c_acteur->setCode_activite('semi-grossiste');	
                        } elseif($id_type_acteur == 1) {
                            $c_acteur->setCode_activite('grossiste');	
                        }
                    
                        $c_acteur->setType_acteur('DSMS');
					    $c_acteur->setCode_gac_chaine($acteur);
                                
                        $t_acteur->insert($c_acteur->toArray());
                        //R�cup�ration de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prk = 0;
                        $par_prk = $param->find('prk', 'nr', $par);
                        if ($par_prk == true) {
                            $prk = $par->getMontant();
                        }
                       
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'TEGCP' .$membre1->getId_filiere(). $code;
                        $find_te = $te_mapper->find($code_te,$te);
						
						// insertion dans la table eu_tegc
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
                               ->setId_filiere($membre1->getId_filiere())
                               ->setMdv($prk)
                               ->setCode_membre($code)
                               ->setMontant(0)
							   ->setMontant_utilise(0)
							   ->setSolde_tegc(0);
                                 $te_mapper->save($te);
                            } else {
                                $te->setId_filiere($membre1->getId_filiere());
                                $te->setMdv($prk);
                                $te_mapper->update($te);
                            } 
                    
                    // table eu_utilisateur
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					$userin = new Application_Model_EuUtilisateur();
					$user_mapper = new Application_Model_EuUtilisateurMapper();                   
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                    $id_user = $user_mapper->findConuter() + 1;
					
					// insertion dans la table eu_utilisateur
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if($id_type_acteur == 3) {
                      $userin->setCode_groupe('oe_detaillant');
                      $userin->setCode_gac_filiere('oe_detaillant');
					  $userin->setCode_groupe_create('oe_detaillant');
                    } elseif($id_type_acteur == 2) {
                      $userin->setCode_groupe('oe_semi_grossiste');
					  $userin->setCode_groupe_create('oe_semi_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } elseif($id_type_acteur == 1) {
                      $userin->setCode_groupe('oe_grossiste');
					  $userin->setCode_groupe_create('oe_grossiste');
                      $userin->setCode_gac_filiere(null);
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($membre1->getId_filiere());
                    
                    $userin->setCode_acteur($acteur);
                    
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays);            
                    $user_mapper->save($userin);
					
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(null);
                    $contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					
					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					      
                    } else {
                           $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                    }                     
                   
                    } else {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       //$this->view->profession = $_POST["profession_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
                    }
                   
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());

                    
					
					// Mise à jour de la table eu_smsmoney
                    $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);  
					
                   $compteur = Util_Utils::findConuter() + 1;
                   Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est : " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                   $db->commit();
                   return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));       
                   
                } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
            }   
               
           }
	       
	}
	

    public function newpmcreneauintAction() {
	        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
            $user = $auth->getIdentity();
		    $request = $this->getRequest();
		    $code_agence = $user->code_agence;
		    $fs = Util_Utils::getParametre('FS','valeur');
            $this->view->fs = $fs;
		    $utilisateur = $user->id_utilisateur;
		    $groupe = $user->code_groupe;
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
			   $acteur = $trouvacteursur->code_acteur;
		   
		    if ($this->getRequest()->isPost()) {
			   $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               $code_sms = $_POST["code_sms"];
			   $id_type_acteur = "";
			   $id_type_creneau = "";
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			   try {
			       $frais_identification = trim($_POST["frais_identification"]);  
				   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
				   $agrement_mapper = new Application_Model_EuAgrementMapper();
			       $agrement        = new Application_Model_EuAgrement();
                   $sms = $sms_mapper->findByCreditCode($code_sms);
				   
                   $agrement_filiere  =  $_POST["agrement_filiere"];
                   $agrement_acnev    =  $_POST["agrement_acnev"];
                   $agrement_technopole =  $_POST["agrement_technopole"];
				   
				   if ($sms != null)  { 
					  $mont = $sms->getCreditAmount();
					  if ($mont == $frais_identification) {
                        if($sms->getMotif() != 'FS') {
					       $db->rollBack();
					       $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
						   $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;    
					    }
						
						//insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
						$membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }  

                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
						
						$trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
						
						// verification agrement filiere
						if($trouveagrementf != false) {
				           $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
						   $id_type_acteur = $agrement->getId_type_acteur();
						   $id_type_creneau = $agrement->getId_type_creneau();
						   
				           $agrement->setCode_membre_morale($code);
				           $agrement_mapper->update($agrement);
						   $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
						   
						   // insertion dans la table eu_membre
						   $membre->setId_filiere($membre1->getId_filiere());
						   $membre->setCode_membre_morale($code);
                           $membre->setCode_type_acteur($_POST["type_acteur"]);
                           $membre->setCode_statut($_POST["statut_juridique"]);
                           $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
						   $membre->setId_pays($_POST["id_pays"]);
                           $membre->setNum_registre_membre($_POST["num_registre"]);
                           $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                           $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                           $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                           $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                           $membre->setBp_membre($_POST["bp_membre"]);
                           $membre->setTel_membre($_POST["tel_membre"]);
                           $membre->setEmail_membre($_POST["email_membre"]);
                           $membre->setPortable_membre($_POST["portable_membre"]);
                           $membre->setId_utilisateur($utilisateur);
                           $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                           $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                           $membre->setCode_agence($code_agence);
                           $membre->setCodesecret(md5($_POST["codesecret"]));
                           $membre->setAuto_enroler('O');
						   $membre->setEtat_membre('N');
				           $mapper->save($membre);
							
							// Mise à jour de la table eu_acteurs_creneau
					        $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
							
							$acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
							$acren->setId_type_acteur($id_type_acteur);
							
							//$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($utilisateur);
							$acren->setGroupe($groupe);
							$acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
							
							
							$code_zone = $user->code_zone;
			                $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                                $code_acteur = 'A' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                            }
						
						   $acren->setCode_acteur($code_acteur);
						   $acren->setId_filiere($membre1->getId_filiere());
						   $cm->save($acren);	
							
						   // insertion dans la table eu_operation
                           Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
						    
						    //insertion dans la table eu_representation
						    $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
						    $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
						
						    //insertion dans la table eu_compte_bancaire
                            $cpte = $_POST['cpteur'];
                            $i = 1;
                            $cb_mapper = new Application_Model_EuCompteBancaireMapper();
						    $id_compte = $cb_mapper->findConuter() + 1;
                            $cb = new Application_Model_EuCompteBancaire();
                            while ($i <= $cpte) {
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                                  $cb->setId_compte($id_compte)
								     ->setCode_banque($_POST['code_banque' . $i])
                                     ->setCode_membre_morale($code)
								     ->setCode_membre(null)
                                     ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                  $cb_mapper->save($cb);
                            }
                                  $i++;
                            }							
						
						} else {
				            $db->rollBack();
				            $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
				        }
						
						// verification agrement acnev
						if($trouveagrementacnev != false) {
				            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
								
						} else {
				            $db->rollBack();
				            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
				        }
						
						// verification agrement technopole
						if($trouveagrementtechno != false) {
				            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
								
						} else {
				               $db->rollBack();
				               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
				        }
						
						$filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
						
						$t_acteur = new Application_Model_DbTable_EuActeur();
						$c_acteur = new Application_Model_EuActeur();
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
						$count = $c_acteur->findConuter() + 1;
						
						// insertion dans la table eu_acteur
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
						$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						$c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						$c_acteur->setId_pays($ligneacteur->id_pays);
						$c_acteur->setId_region($ligneacteur->id_region);
						$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);		 
								 
                        if($id_type_acteur == 3) {
                            $c_acteur->setCode_activite('detaillant');    
                        } elseif($id_type_acteur == 2) {
                            $c_acteur->setCode_activite('semi-grossiste');   
                        } elseif($id_type_acteur == 1) {
                            $c_acteur->setCode_activite('grossiste');
                        }
                            if(isset($_POST['actcmfh'])) {	
                                $c_acteur->setType_acteur('CMFH');	
						    } else if(isset($_POST['actenro'])) {
						        $c_acteur->setType_acteur('DSMS');	
						    } else {
						        $c_acteur->setType_acteur('DSMS');
						    }
                                
							$c_acteur->setCode_gac_chaine($acteur);
                            $t_acteur->insert($c_acteur->toArray());
								
					        // Recuperation de la prk nr
                            $param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $prc = 0;
                            $par_prc = $param->find('prc', 'nr', $par);
                            if ($par_prc == true) {
                               $prc = $par->getMontant();
                            }
					   
					            $te_mapper = new Application_Model_EuTegcMapper();
                                $te = new Application_Model_EuTegc();
                                $code_te = 'TEGCP' .$membre1->getId_filiere(). $code;
                                $find_te = $te_mapper->find($code_te,$te);
								
								// insertion dans la table eu_tegc
                                if ($find_te == false) {
                                $te->setCode_tegc($code_te)
                                   ->setId_filiere($membre1->getId_filiere())
                                   ->setMdv($prc)
                                   ->setCode_membre($code)
                                   ->setMontant(0)
							       ->setMontant_utilise(0)
							       ->setSolde_tegc(0);
                                 $te_mapper->save($te);
                                } else {
                                     $te->setId_filiere($membre1->getId_filiere());
                                     $te->setMdv($prc);
                                     $te_mapper->update($te);
                                }
					
					// table eu_zppe
					
					$zppe_mapper = new Application_Model_EuZppeMapper();
                    $zppe = new Application_Model_EuZppe();
					$zppe_id = $zppe_mapper->findConuter() + 1;
					   
					$zppe->setZppe_id($zppe_id);
					$zppe->setZppe_libelle(addslashes (trim ($_POST["raison_sociale"])));
                    $zppe->setZppe_description(addslashes (trim ($_POST["raison_sociale"])));
                    $zppe->setZppe_resume(addslashes (trim ($_POST["domaine_activite"])));
					$zppe->setZppe_vignette(null);
					$zppe->setZppe_login($code);
					$zppe->setZppe_password(md5($_POST["codesecret"]));
                    $zppe->setZppe_date_genere($date_idd->toString('yyyy-MM-dd'));
                    $zppe->setZppe_portable($_POST["portable_membre"]);
                    $zppe->setZppe_email($_POST["email_membre"]);
                    $zppe->setZppe_code_membre($code);
                	$zppe->setPublier(1);	
					   
					$zppe_mapper->save($zppe);		
								
					
					// insertion dans la table eu_utilisateur
					$user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                    if($id_type_acteur == 3) {
                          $userin->setCode_groupe('oe_detaillant');
                          $userin->setCode_gac_filiere('oe_detaillant');
						  $userin->setCode_groupe_create('oe_detaillant');
                    } elseif($id_type_acteur == 2) {
                          $userin->setCode_groupe('oe_semi_grossiste');
                          $userin->setCode_gac_filiere(null);
						  $userin->setCode_groupe_create('oe_semi_grossiste');
                    } elseif($id_type_acteur == 1) {
                          $userin->setCode_groupe('oe_grossiste');
                          $userin->setCode_gac_filiere(null);
						  $userin->setCode_groupe_create('oe_grossiste');
                    }
					
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($membre1->getId_filiere());
                    
				    $userin->setCode_acteur($acteur);
					
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(3);
					$contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);  
										
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
  
                    } else {
                           $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                           $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;
                    }					  
				   
				    } else {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       //$this->view->profession = $_POST["profession_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
                }
				   
				    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
				             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());
					
                    // Mise à jour de la table eu_smsmoney					
                    $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms); 
				
				    $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$membrein->getPortable_membre(),"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                $db->commit();
                return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));      
				   
			    } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
				    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }   
			   
	       }
	}


	
	
	
	
	public function newpmcreneauAction() {
		   $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
		   $request = $this->getRequest();
		   $code_agence = $user->code_agence;
		   $fs = Util_Utils::getParametre('FS','valeur');
           $this->view->fs = $fs;
		   $utilisateur = $user->id_utilisateur;
		   $groupe = $user->code_groupe;
		   $table = new Application_Model_DbTable_EuActeur();
			   //$select = $table->select();
			   //$select->where('code_acteur like ?',$user->code_acteur);
			   //$result = $table->fetchAll($select);
			   //$findacteur = $result->current();
			   //$code_gac_chaine = $findacteur->code_gac_chaine;
			   //$selection = $table->select();
			   //$selection->where('code_gac_chaine like ?',$code_gac_chaine);
			   //$selection->where('type_acteur like ?','gac_surveillance');
			   //$resultat = $table->fetchAll($selection);
			   //$trouvacteursur = $resultat->current();
			   //$acteur = $trouvacteursur->code_acteur;
			   $acteur = $user->code_acteur;
		   
		    if ($this->getRequest()->isPost()) {
			    $date_id = new Zend_Date(Zend_Date::ISO_8601);
                $date_idd = clone $date_id;
                $code_sms = $_POST["code_sms"];
				$id_type_acteur = "";
				$id_type_creneau = "";
				$id_filiere = "";
                $db = Zend_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
			    try {
			       $frais_identification = trim($_POST["frais_identification"]);  
				   $sms_mapper = new Application_Model_EuSmsmoneyMapper();
				   $agrement_mapper = new Application_Model_EuAgrementMapper();
			       $agrement        = new Application_Model_EuAgrement();
                   $sms = $sms_mapper->findByCreditCode($code_sms);
				   
                   $agrement_filiere  =  $_POST["agrement_filiere"];
                   $agrement_acnev    =  $_POST["agrement_acnev"];
                   $agrement_technopole =  $_POST["agrement_technopole"];
				   
				   if ($sms != null)  { 
					    $mont = $sms->getCreditAmount();
					    // if ($mont == $frais_identification) {
                           if($sms->getMotif() != 'FS') {
					       $db->rollBack();
					       $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
						   $this->view->type_acteur = $_POST["type_acteur"];
                           $this->view->statut_juridique = $_POST["statut_juridique"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           //$this->view->profession = $_POST["profession_membre"];
                           $this->view->registre = $_POST["num_registre"];
                           return;    
					    }
						
						//insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
						$membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre,7,0,STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }  
					    

                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
						
						$trouveagrementf = $agrement_mapper->findagrementfiliere($agrement_filiere);
				        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
				        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
						
						// verification agrement filiere
						if($trouveagrementf != false) {
				            $result = $agrement_mapper->find($trouveagrementf->getId_agrement(),$agrement);
							
							$id_type_acteur = $agrement->getId_type_acteur();
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_filiere = $agrement->getId_filiere();
							
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
							$resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
							
							// insertion dans la table eu_membre
							$membre->setId_filiere($id_filiere);
							$membre->setCode_membre_morale($code);
                            $membre->setCode_type_acteur($_POST["type_acteur"]);
                            $membre->setCode_statut($_POST["statut_juridique"]);
                            $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
						    $membre->setId_pays($_POST["id_pays"]);
                            $membre->setNum_registre_membre($_POST["num_registre"]);
                            $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                            $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                            $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                            $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                            $membre->setBp_membre($_POST["bp_membre"]);
                            $membre->setTel_membre($_POST["tel_membre"]);
                            $membre->setEmail_membre($_POST["email_membre"]);
                            $membre->setPortable_membre($_POST["portable_membre"]);
                            $membre->setId_utilisateur($utilisateur);
                            $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                            $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                            $membre->setCode_agence($code_agence);
                            $membre->setCodesecret(md5($_POST["codesecret"]));
                            $membre->setAuto_enroler('O');
						    $membre->setEtat_membre('N');
				            $mapper->save($membre);
							
							
							// insertion dans la table eu_acteurs_creneau
					        $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
							
							$acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
							$acren->setId_type_acteur($id_type_acteur);
							
							
							//$acren->setCode_activite(null);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($utilisateur);
							$acren->setGroupe($groupe);
							$acren->setCode_creneau(null);
                            $acren->setCode_gac_filiere(null);
                            $acren->setCode_gac(null);
							
							
							$code_zone = $user->code_zone;
			                $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == null) {
                               $code_acteur = 'A' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                            }
						
						    $acren->setCode_acteur($code_acteur);
						    $acren->setId_filiere($membre1->getId_filiere());
						    $cm->save($acren);	
							
						    //insertion dans la table eu_operation
                            Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
						    
						    //insertion dans la table eu_representation
						    $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
						    $rep->setCode_membre_morale($code)
                                ->setCode_membre($_POST['code_rep'])
                                ->setTitre("Representant")
							    ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							    ->setId_utilisateur($user->id_utilisateur)
							    ->setEtat('inside');
                            $rep_mapper->save($rep);
						
						    //insertion dans la table eu_compte_bancaire
                            $cpte = $_POST['cpteur'];
                            $i = 1;
                            $cb_mapper = new Application_Model_EuCompteBancaireMapper();
						    $id_compte = $cb_mapper->findConuter() + 1;
                            $cb = new Application_Model_EuCompteBancaire();
                            while ($i <= $cpte) {
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '')  {
                                $cb->setId_compte($id_compte)
								   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
								   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                                $i++;
                            }							
						
						} else {
				            $db->rollBack();
				            $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
				            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
				        }
						
						
						// verification agrement acnev
						if($trouveagrementacnev != false) {
				            $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
								
						} else {
				            $db->rollBack();
				            $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
				            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;
				        }
						
						
						// verification agrement technopole
						if($trouveagrementtechno != false) {
				            $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
				            $agrement->setCode_membre_morale($code);
				            $agrement_mapper->update($agrement);
								
						} else {
				               $db->rollBack();
				               $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
				               $this->view->type_acteur = $_POST["type_acteur"];
                               $this->view->statut_juridique = $_POST["statut_juridique"];
                               $this->view->raison = $_POST["raison_sociale"];
                               $this->view->domaine_activite = $_POST["domaine_activite"];
                               $this->view->site_web = $_POST["site_web"];
                               $this->view->quartier_membre = $_POST["quartier_membre"];
                               $this->view->ville_membre = $_POST["ville_membre"];
                               $this->view->bp = $_POST["bp_membre"];
                               $this->view->tel = $_POST["tel_membre"];
                               $this->view->email = $_POST["email_membre"];
                               $this->view->portable = $_POST["portable_membre"];
                               //$this->view->profession = $_POST["profession_membre"];
                               $this->view->registre = $_POST["num_registre"];
                               return;
				        }
						$filiere =  new Application_Model_EuFiliere();
						$map_filiere = new Application_Model_EuFiliereMapper();
						$find_filiere = $map_filiere->find($id_filiere,$filiere);
						
						$t_acteur = new Application_Model_DbTable_EuActeur();
						$c_acteur = new Application_Model_EuActeur();
						
						$t_cmfh = new Application_Model_DbTable_EuCmfh();
						$c_cmfh = new Application_Model_EuCmfh();
						
						
						$table = new Application_Model_DbTable_EuActeur();
                        $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
						$count = $c_acteur->findConuter() + 1;
						$countcmfh = $c_cmfh->findConuter() + 1;
						
						// insertion dans la table eu_acteur
                        $c_acteur->setId_acteur($count)
                                 ->setCode_acteur(null)
								 ->setCode_division($filiere->getCode_division())
                                 ->setCode_membre($code)
                                 ->setId_utilisateur($utilisateur)
                                 ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
								 
						$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						$c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						$c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						$c_acteur->setId_pays($ligneacteur->id_pays);
						$c_acteur->setId_region($ligneacteur->id_region);
						$c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						$c_acteur->setCode_agence_create($ligneacteur->code_agence_create);		 
								 
                        if($id_type_acteur == 3) {
                            $c_acteur->setCode_activite('detaillant');    
                        } elseif($id_type_acteur == 2) {
                            $c_acteur->setCode_activite('semi-grossiste');
                        } elseif($id_type_acteur == 1){
                            $c_acteur->setCode_activite('grossiste');
                        }
						
                        //if(isset($_POST['actcmfh'])) {	
                        //$c_acteur->setType_acteur('CMFH');	
						//} else 
						
						/* if(isset($_POST['actenro'])) {
						  $c_acteur->setType_acteur('DSMS');	
						} else {
						  $c_acteur->setType_acteur('DSMS');
						} */
						
						$c_acteur->setType_acteur(NULL);
                        $c_acteur->setCode_gac_chaine($acteur);
                        $t_acteur->insert($c_acteur->toArray());
						
						/*
                        if(isset($_POST['actcmfh'])) {
						    // insertion dans la table eu_cmfh
                            $c_cmfh->setId_cmfh($countcmfh)
                                   ->setCode_membre($code)
                                   ->setId_utilisateur($utilisateur)
                                   ->setDate_creation($date_idd->toString('yyyy-MM-dd'));	 
						    $c_cmfh->setCode_source_create($ligneacteur->code_source_create);
						    $c_cmfh->setCode_monde_create($ligneacteur->code_monde_create);
						    $c_cmfh->setCode_zone_create($ligneacteur->code_zone_create);
						    $c_cmfh->setId_pays($ligneacteur->id_pays);
						    $c_cmfh->setId_region($ligneacteur->id_region);
						    $c_cmfh->setCode_secteur_create($ligneacteur->code_secteur_create);
						    $c_cmfh->setCode_agence_create($ligneacteur->code_agence_create);		 
                            $c_cmfh->setCode_activite(null);    	
						    $c_cmfh->setType_acteur('CMFH');
                            $c_cmfh->setCode_gac_chaine($acteur);
                            $t_cmfh->insert($c_cmfh->toArray());
						}
						*/
					    // Recuperation de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prc = 0;
                        $par_prc = $param->find('prc', 'nr', $par);
                        if ($par_prc == true) {
                            $prc = $par->getMontant();
                        }
					   
					    $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
						
                        $code_te = 'TEGCP'.$id_filiere.$code. '00001';
                        $find_te = $te_mapper->find($code_te,$te);
							
					    // insertion dans la table eu_tegc
                            if ($find_te == false) {
                                $te->setCode_tegc($code_te)
								   ->setNom_tegc(addslashes (trim ($_POST["raison_sociale"])))
								   ->setSubvention(0)
                                   ->setId_filiere($id_filiere)
                                   ->setMdv($prc)
                                   ->setCode_membre($code)
                                   ->setMontant(0)
							       ->setMontant_utilise(0)
							       ->setSolde_tegc(0);
                                 $te_mapper->save($te);
                                } else {
                                    $te->setId_filiere($id_filiere);
                                    $te->setMdv($prc);
                                    $te_mapper->update($te);
                                }
					
					
					// insertion de la table eu_utilisateur
					$user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();					
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
					
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                    if($id_type_acteur == 3) {
                        $userin->setCode_groupe('oe_detaillant');
                        $userin->setCode_gac_filiere('oe_detaillant');
						$userin->setCode_groupe_create('oe_detaillant');
                    } elseif($id_type_acteur == 2) {
                        $userin->setCode_groupe('oe_semi_grossiste');
                        $userin->setCode_gac_filiere(null);
						$userin->setCode_groupe_create('oe_semi_grossiste');
                    } elseif($id_type_acteur == 1) {
                        $userin->setCode_groupe('oe_grossiste');
                        $userin->setCode_gac_filiere(null);
						$userin->setCode_groupe_create('oe_grossiste');
                    }
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
                    
				    $userin->setCode_acteur($acteur);
					
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
					
					$contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
				    $contrat->setId_type_contrat(3);
					$contrat->setId_type_creneau($id_type_creneau);
					$contrat->setId_type_acteur($id_type_acteur);
					  					
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
  
/* } 
					else {
                        $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        //$this->view->profession = $_POST["profession_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
                    } */ 					  
				   
				    } else {
                       $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                       $this->view->type_acteur = $_POST["type_acteur"];
                       $this->view->statut_juridique = $_POST["statut_juridique"];
                       $this->view->raison = $_POST["raison_sociale"];
                       $this->view->domaine_activite = $_POST["domaine_activite"];
                       $this->view->site_web = $_POST["site_web"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       //$this->view->profession = $_POST["profession_membre"];
                       $this->view->registre = $_POST["num_registre"];
                       return;
                }
				   
				    //Creation du FS
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
				             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());
					
                    // Mise à jour de la table eu_smsmoney					
                    $sms->setDestAccount_Consumed('NB-TFS-'.$code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms); 
					
				
				$compteur = Util_Utils::findConuter() + 1;
                Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                $db->commit();
                return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));      
				   
			    } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
				    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }   
			   
	        }
	
	}
    
	public function newpmgacagenceAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
           $type_gac = $request->type_gac;
           $this->view->type_gac = $type_gac;
           $code_agence = $user->code_agence;
		   $code_zone = substr($code_agence,0,3);
		   $acteur      = $user->code_acteur;
		   $num_membre  = $user->code_membre;
		   
		   $gac_mapper = new Application_Model_EuGacMapper();
           $gac = new Application_Model_EuGac();
		   
		   $agence_mapper = new Application_Model_EuAgenceMapper();
           $agence = new Application_Model_EuAgence();
		   
		   //$secteur_mapper = new Application_Model_EuSecteurMapper();
           //$secteur = new Application_Model_EuSecteur();
		   
		   $prefecture_mapper = new Application_Model_EuPrefectureMapper();
           $prefecture = new Application_Model_EuPrefecture();
		   
		   //$region_mapper = new Application_Model_EuRegionMapper();
           //$region = new Application_Model_EuRegion();
		   
		    $pays_mapper = new Application_Model_EuPaysMapper();
            $pays = new Application_Model_EuPays();
		   
		    $pays_mapper = new Application_Model_EuPaysMapper();
            $pays = new Application_Model_EuPays();
            $fs = Util_Utils::getParametre('FS','valeur');
            $this->view->fs = $fs;
		   
		    //if($acteur !='' || $acteur != NULL) {
		       //$find_gac = $gac_mapper->find($acteur,$gac);
		       //$find_pays = $pays_mapper->find($gac->getId_pays(),$pays);
		       //$this->view->id_pays = $gac->getId_pays();
		       //$this->view->id_region = $gac->getId_region();
		       //$this->view->code_secteur = $gac->getCode_secteur();
		       //$this->view->nationalite = $pays->getNationalite();
			//} else {
			
			    $find_agence = $agence_mapper->find($code_agence,$agence);
			    $find_secteur = $prefecture_mapper->find($agence->getId_prefecture(),$prefecture);
			    $find_pays = $pays_mapper->find($agence->getId_pays(),$pays);
			    $this->view->id_pays = $agence->getId_pays();
		        $this->view->id_region = $agence->getId_region();
		        $this->view->id_prefecture = $agence->getId_prefecture();
		        $this->view->nationalite = $pays->getNationalite();
			   

            //}
		   
		   
           $fs = Util_Utils::getParametre('FS','valeur');
           $this->view->fs = $fs;
		   //$this->view->id_pays = $gac->getId_pays();
		   //$this->view->id_region = $gac->getId_region();
		   //$this->view->nationalite = $pays->getNationalite();
		   
		   if ($this->getRequest()->isPost()) {
           $date_id = new Zend_Date(Zend_Date::ISO_8601);
           $date_idd = clone $date_id;
           //$code_sms = $_POST["code_sms"];
		   
		   $fs = Util_Utils::getParametre('FS','valeur');
		   $mont_fl = Util_Utils::getParametre('FL','valeur');
           $fcps = Util_Utils::getParametre('FKPS','valeur');
		   $tcartes = array();
           $tscartes = array();
		   
		   
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
               //$frais_identification = trim($_POST["frais_identification"]);
               $licence_mapper = new Application_Model_EuLicenceMapper();
               $licence = new Application_Model_EuLicence();
               $offres_mapper = new Application_Model_EuAppeloffresMapper();
               $offres = new Application_Model_EuAppeloffres();
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
               $cm_map = new Application_Model_EuCompteMapper();
               $_compte = new Application_Model_EuCompte();
               //$sms = $sms_mapper->findByCreditCode($code_sms);
			   $suppliant = "";
               //if ($sms != null) {
               //$mont = $sms->getCreditAmount();
               //if ($mont == $frais_identification) {
                        /*if($sms->getMotif() != 'FS') {
                            $db->rollBack();
                            $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;    
                        }*/
                         
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
						
						// insertion dans la table eu_membre
                        $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($_POST["type_acteur"]);
                        $membre->setCode_statut($_POST["statut_juridique"]);
                        $membre->setRaison_sociale(htmlentities (addslashes (trim ($_POST["raison_sociale"]))));
                        $membre->setId_pays($_POST["id_pays"]);
                        $membre->setNum_registre_membre($_POST["num_registre"]);
                        $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                        $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                        $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                        $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                        $membre->setBp_membre($_POST["bp_membre"]);
                        $membre->setTel_membre($_POST["tel_membre"]);
                        $membre->setEmail_membre($_POST["email_membre"]);
                        $membre->setPortable_membre($_POST["portable_membre"]);
                        $membre->setId_utilisateur($user->id_utilisateur);
                        $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('O');
                        $membre->setEtat_membre('N');
                        $membre->setId_filiere($user->id_filiere);   
                        
                        $mapper->save($membre);
                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteur,null,$code,'TFS',$fs,'FS','Auto-enrôlement','AERL',$date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                        
					        // insertion  dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                        
						
						// insertion dans la table eu_compte_bancaire
                        $cpte = $_POST['cpteur'];
                        $i = 1;
                        $cb_mapper = new Application_Model_EuCompteBancaireMapper(); 
                        $cb = new Application_Model_EuCompteBancaire();
                        while ($i <= $cpte) {
						    $id_compte = $cb_mapper->findConuter() + 1;
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                                $cb->setId_compte($id_compte)
                                   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
                                   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                        }
                    //} 
					
					/*else {
                        $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        //$this->view->profession = $_POST["profession_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
                    }*/
                //} 
				
				/*else {
                    $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    //$this->view->profession = $_POST["profession_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    return;
                } */
				
				
				
                    $gac_mapper = new Application_Model_EuGacMapper();
                    $gac = new Application_Model_EuGac();
					$findgac = $gac_mapper->findtypegac($_POST["id_pays"],$_POST["categorie_gac"],$_POST["type_gac"]);
                    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
					
					$t_division = new Application_Model_DbTable_EuTeteDivision();
                    $c_division = new Application_Model_EuTeteDivision();
					
                    $userin = new Application_Model_EuUtilisateur();
                    $user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					
					if($findgac != false) {
					  $db->rollBack();
                      $this->view->message = "Le type de gac est déja créé !!!";
                      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      //$this->view->profession = $_POST["profession_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
					}
                    
                    if(trim($user->code_groupe) == 'gacdagence' || trim($user->code_groupe) == 'gacsagence' || trim($user->code_groupe) == 'gacexagence')  {
                        $type_gac = $_POST["type_gac"];
                        if(trim($user->code_groupe) == 'gacdagence') {
						   // verification du numero contrat licence
                           $trouvel = $licence_mapper->findlicence($_POST["numero_licence"]);
                           if($trouvel != false) {
                           $num_licence = $_POST["numero_licence"];
                           $result = $licence_mapper->find($trouvel->getId_licence(),$licence);
                           $licence->setCode_membre_morale($code);
                           $licence_mapper->update($licence);
                        }  else {
                                $db->rollBack();
                                $this->view->message = " Le numéro de licence est invalide ou est déjà utilisé";
                                $this->view->type_acteur = $_POST["type_acteur"];
                                $this->view->statut_juridique = $_POST["statut_juridique"];
                                $this->view->raison = $_POST["raison_sociale"];
                                $this->view->domaine_activite = $_POST["domaine_activite"];
                                $this->view->site_web = $_POST["site_web"];
                                $this->view->quartier_membre = $_POST["quartier_membre"];
                                $this->view->ville_membre = $_POST["ville_membre"];
                                $this->view->bp = $_POST["bp_membre"];
                                $this->view->tel = $_POST["tel_membre"];
                                $this->view->email = $_POST["email_membre"];
                                $this->view->portable = $_POST["portable_membre"];
                                //$this->view->profession = $_POST["profession_membre"];
                                $this->view->registre = $_POST["num_registre"];
                                return;
                       }   
                    } else {
					       // verification numero contrat 
                           $trouveof = $offres_mapper->findoffres($_POST["numero_offre"]);
                           if($trouveof != false) {
                                  $num_offre = $_POST["numero_offre"];
                                  $result = $offres_mapper->find($trouveof->getId_appeloffres(),$offres);
                                  $offres->setCode_membre_morale($code);
                                  $offres_mapper->update($offres);
                           } else {
                                  $db->rollBack();
                                  $this->view->message = " Le numéro du document d'appel d'offre est invalide ou est déjà utilisé";
                                  $this->view->type_acteur = $_POST["type_acteur"];
                                  $this->view->statut_juridique = $_POST["statut_juridique"];
                                  $this->view->raison = $_POST["raison_sociale"];
                                  $this->view->domaine_activite = $_POST["domaine_activite"];
                                  $this->view->site_web = $_POST["site_web"];
                                  $this->view->quartier_membre = $_POST["quartier_membre"];
                                  $this->view->ville_membre = $_POST["ville_membre"];
                                  $this->view->bp = $_POST["bp_membre"];
                                  $this->view->tel = $_POST["tel_membre"];
                                  $this->view->email = $_POST["email_membre"];
                                  $this->view->portable = $_POST["portable_membre"];
                                  //$this->view->profession = $_POST["profession_membre"];
                                  $this->view->registre = $_POST["num_registre"];
                                  return;
                            }
                    }
                       //$code_zone = $user->code_zone;
                       $code_recup = $gac_mapper->getLastGacByZone($code_zone);
                       if ($code_recup == null) {
                          $code_gac = 'G' . $code_zone . '0001';
                       } else {
                          $num_ordre = substr($code_recup, -4);
                          $num_ordre++;
                          $code_gac = 'G' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                       }
                       
					   // insertion dans la table eu_gac
                       $gac->setCode_gac($code_gac);
                       $gac->setCode_membre($code);
                       $gac->setNom_gac($_POST["raison_sociale"]);
                       $gac->setCode_type_gac($type_gac);
                       $gac->setCode_zone($code_zone);
                       $gac->setCode_membre_gestionnaire($_POST['code_rep']);
                       $gac->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                       $gac->setId_utilisateur($user->id_utilisateur);
					   $gac->setType_gac($_POST["categorie_gac"]);
					   $gac->setId_pays($_POST["id_pays"]);
                       $gac->setGroupe('GAC');
                       $gac->setZone($code_zone);
					   $gac->setId_region($_POST["id_region"]);
					   $gac->setCode_secteur($_POST["id_prefecture"]);
					   $gac->setCode_agence($_POST["id_canton"]);
                       $gac->setCode_gac_create(null);
                       $gac->setCode_gac_chaine(null);
                       $gac_mapper->save($gac);
                       
					   
					   $filiere =  new Application_Model_EuFiliere();
					   $map_filiere = new Application_Model_EuFiliereMapper();
					   $find_filiere = $map_filiere->find($user->id_filiere,$filiere);
					   
					   // insertion dans la table eu_acteur
                       $count = $c_acteur->findConuter() + 1;
                       $c_acteur->setId_acteur($count)
                                ->setCode_acteur($code_gac)
								->setCode_division($filiere->getCode_division())
                                ->setCode_membre($code)
                                ->setType_acteur($type_gac)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					    if($_POST["categorie_gac"] == 'agence') {			
                          $c_acteur->setCode_activite('CANTON');
						  $c_acteur->setCode_source_create('SOURCE');
						  $c_acteur->setCode_monde_create('MONDE');
						  $c_acteur->setCode_zone_create($code_zone);
						  $c_acteur->setId_pays($_POST["id_pays"]);
						  $c_acteur->setId_region($_POST["id_region"]);
						  $c_acteur->setId_prefecture($_POST["id_prefecture"]);
						  $c_acteur->setId_canton($_POST["id_canton"]);
						  //$c_acteur->setCode_secteur_create($_POST["code_secteur"]);
						  //$c_acteur->setCode_agence_create($_POST["id_canton"]);
                        }   
                        $c_acteur->setCode_gac_chaine($acteur);					   
                        $t_acteur->insert($c_acteur->toArray());
                       
					   
                        //R�cup�ration de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prc = 0;
                        $par_prc = $param->find('prc', 'nr', $par);
                        if ($par_prc == true) {
                            $prc = $par->getMontant();
                        }
						
						// insertion dans la table eu_tegc
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'TEGCP' .$user->id_filiere. $code.'00001';
                        $find_te = $te_mapper->find($code_te, $te);
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
							   ->setNom_tegc(addslashes (trim ($_POST["raison_sociale"])))
							   ->setSubvention(0)
                               ->setId_filiere($user->id_filiere)
                               ->setMdv($prc)
                               ->setCode_membre($code)
                               ->setMontant(0)
							   ->setMontant_utilise(0)
							   ->setSolde_tegc(0);
                            $te_mapper->save($te);
                        } else {
                                $te->setId_filiere($user->id_filiere);
                                $te->setMdv($prc);
                                $te_mapper->update($te);
                        }
                        
                        //Initialisation du compte tegcp
                        $date_alloc = new Zend_Date(Zend_Date::ISO_8601);
                        $code_cat = 'TPAGCP';
                        $code_compte = 'NB-' . $code_cat . '-' . $code;
                        $compte_mapper = new Application_Model_EuCompteMapper();
                        $compte = new Application_Model_EuCompte();
                        $find_compte = $compte_mapper->find($code_compte,$compte);       
                    }
					
					// insertion dans la table eu_utilisateur
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                    $id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if(trim($user->code_groupe) == 'gacdagence') {
					  if($_POST["categorie_gac"] == 'agence'){
                         $userin->setCode_groupe('detentrice_agence');
					     $userin->setCode_groupe_create('detentrice_agence');
						 
					  } 					  
                    } elseif(trim($user->code_groupe) == 'gacexagence') {
					  if($_POST["categorie_gac"] == 'agence'){
                         $userin->setCode_groupe('executante_agence');
					     $userin->setCode_groupe_create('executante_agence');
					  } 
                    } elseif(trim($user->code_groupe) == 'gacsagence') {
					  if($_POST["categorie_gac"] == 'agence') {
                         $userin->setCode_groupe('surveillance_agence');
					     $userin->setCode_groupe_create('surveillance_agence');
					  } 
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($user->id_filiere);
                    
                    $userin->setCode_acteur($code_gac);
                   
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays); 
                    $userin->setId_canton($_POST["id_canton"]);					
                    $user_mapper->save($userin);
                    
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
                    
				    $contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
					if(trim($user->code_groupe) == 'gacdagence') {
				      $contrat->setId_type_contrat(1);
					} elseif(trim($user->code_groupe) == 'gacsagence') {   
					  $contrat->setId_type_contrat(2);
					} elseif(trim($user->code_groupe) == 'gacexagence') { 
					  $contrat->setId_type_contrat(3);
					}   
                    $contrat->setId_type_creneau(null);
                    $contrat->setId_type_acteur(null);
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             //->setCreditcode($sms->getCreditCode())
							 ->setCreditcode(null)
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());

					// Mise à jour de la table eu_smsmoney 
                    /*$sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);*/
					
					
					$tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
                    $code_fl = 'FL-' . $code;
						
				    $fl->setCode_fl($code_fl)
                       ->setCode_membre(NULL)
					   ->setOrigine_fl(null)
                       ->setCode_membre_morale($code)
                       ->setMont_fl($mont_fl)
                       ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                       ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setCreditcode(null);   
				  
                    $tfl->insert($fl->toArray());
					
					$compte = new Application_Model_EuCompte();
                    $map_compte = new Application_Model_EuCompteMapper();
					
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
					
					for($i = 1; $i < count($tcartes); $i++) {
                       if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                         $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NR';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE" || $tcartes[$i] == "TMARGE") {
                         $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NN';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
                         $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NB';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIN") {
                         $tcartes[$i] = "TI"; 
                         $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NN';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIR") {
                         $tcartes[$i] = "TI"; 
                         $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NR';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIB") {
                         $tcartes[$i] = "TI";
                         $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NB';
                         $res = $map_compte->find($code_compte,$compte);
                       }
                         if(!$res) {
                           $compte->setCode_cat($tcartes[$i])
                                  ->setCode_compte($code_compte)
                                  ->setCode_membre(NULL)
                                  ->setCode_membre_morale($code)
                                  ->setCode_type_compte($type_carte)
                                  ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
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
						
						for($j = 0; $j < count($tscartes); $j++) {
                           if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                             $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NR';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSMARGE" || $tscartes[$j] == "TSRE") {
                             $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NN';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
                             $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NB';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSIN") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NN';
                             $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIR") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NR';
                             $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIB") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NB';
                             $res = $map_compte->find($code_comptets,$compte);
                            }
                            if(!$res) {
                              $compte->setCode_cat($tscartes[$j])
                                     ->setCode_compte($code_comptets)
                                     ->setCode_membre(NULL)
                                     ->setCode_membre_morale($code)
                                     ->setCode_type_compte($type_carte)
                                     ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                     ->setDesactiver(0)
                                     ->setLib_compte($tscartes[$j])
                                     ->setSolde(0);
                                $map_compte->save($compte);
                            }

                        }
						
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
                        $id_demande = $carte->findConuter() + 1;
                        $carte->setId_demande($id_demande)
                              ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("NB-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
							  ->setOrigine_fkps(null)
                              ->setId_utilisateur($user->id_utilisateur);	  
                        $t_carte->insert($carte->toArray());
					
                        $compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,NULL,$code, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
                        
                        $compteur=Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau ESMC!!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                        $db->commit();
                        return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));
                
				//}
            } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
            }
        }	   	   
	}
	
	
	public function newpmgacsecteurAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
           $type_gac = $request->type_gac;
           $this->view->type_gac = $type_gac;
           $code_agence = $user->code_agence;
		   $code_zone = substr($code_agence,0,3);
		   $acteur      = $user->code_acteur;
		   $num_membre  = $user->code_membre;
		   $fs = Util_Utils::getParametre('FS','valeur');
		   
		   
		   $gac_mapper = new Application_Model_EuGacMapper();
           $gac = new Application_Model_EuGac();
		   
		   
		   $agence_mapper = new Application_Model_EuAgenceMapper();
           $agence = new Application_Model_EuAgence();
		   
		   //$secteur_mapper = new Application_Model_EuSecteurMapper();
           //$secteur = new Application_Model_EuSecteur();
		   
		   $prefecture_mapper = new Application_Model_EuPrefectureMapper();
           $prefecture = new Application_Model_EuPrefecture();
		   
		   $pays_mapper = new Application_Model_EuPaysMapper();
           $pays = new Application_Model_EuPays();
		   
		    //if($acteur !='' && $acteur != NULL) {
		        //$find_gac = $gac_mapper->find($acteur,$gac);
		        //$find_pays = $pays_mapper->find($gac->getId_pays(),$pays);
		        //$this->view->id_pays = $gac->getId_pays();
		        //$this->view->id_region = $gac->getId_region();
		        //$this->view->nationalite = $pays->getNationalite();
			//} else {
			    $find_agence = $agence_mapper->find($code_agence,$agence);
			    $find_pre = $prefecture_mapper->find($agence->getId_prefecture(),$prefecture);
			    $find_pays = $pays_mapper->find($agence->getId_pays(),$pays);
			    $this->view->id_pays = $agence->getId_pays();
		        $this->view->id_region = $agence->getId_region();
		        //$this->view->code_secteur = $secteur->getCode_secteur();
		        $this->view->nationalite = $pays->getNationalite();
            //}
           
            //$this->view->fs = $fs;
		    //$this->view->id_pays = $gac->getId_pays();
		    //$this->view->id_region = $gac->getId_region();
		    //$this->view->nationalite = $pays->getNationalite();
		   
		   
		    if ($this->getRequest()->isPost()) {
              $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;
              //$code_sms = $_POST["code_sms"];
			  $fs = Util_Utils::getParametre('FS','valeur');
		      $mont_fl = Util_Utils::getParametre('FL','valeur');
              $fcps = Util_Utils::getParametre('FKPS','valeur');
		      $tcartes = array();
              $tscartes = array();
              $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
            try {
               //$frais_identification = trim($_POST["frais_identification"]);
               $licence_mapper = new Application_Model_EuLicenceMapper();
               $licence = new Application_Model_EuLicence();
               $offres_mapper = new Application_Model_EuAppeloffresMapper();
               $offres = new Application_Model_EuAppeloffres();
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
               $cm_map = new Application_Model_EuCompteMapper();
               $_compte = new Application_Model_EuCompte();
			   $suppliant ="";
			   
               //$sms = $sms_mapper->findByCreditCode($code_sms);
               //if ($sms != null) {
               //$mont = $sms->getCreditAmount();
               //if ($mont == $frais_identification) {
                         
                        /*if($sms->getMotif() != 'FS') {
                            $db->rollBack();
                            $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;    
                        }*/
                         
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0,STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
                        $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($_POST["type_acteur"]);
                        $membre->setCode_statut($_POST["statut_juridique"]);
                        $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
                        $membre->setId_pays($_POST["id_pays"]);
                        $membre->setNum_registre_membre($_POST["num_registre"]);
                        $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                        $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                        $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                        $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                        $membre->setBp_membre($_POST["bp_membre"]);
                        $membre->setTel_membre($_POST["tel_membre"]);
                        $membre->setEmail_membre($_POST["email_membre"]);
                        $membre->setPortable_membre($_POST["portable_membre"]);
                        $membre->setId_utilisateur($user->id_utilisateur);
                        $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('O');
                        $membre->setEtat_membre('N');
                        $membre->setId_filiere($user->id_filiere);   
                        
                        $mapper->save($membre);
                        //
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
						
						// insertion dans la table eu_operation
                        Util_Utils::addOperation($compteur,null,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                        
					       // insertion dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                           
						// insertion dans la table eu_compte_bancaire
                        $cpte = $_POST['cpteur'];
                        $i = 1;
                        $cb_mapper = new Application_Model_EuCompteBancaireMapper(); 
                        $cb = new Application_Model_EuCompteBancaire();
                        while ($i <= $cpte) {
						    $id_compte = $cb_mapper->findConuter() + 1;
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                                $cb->setId_compte($id_compte)
                                   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
                                   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                        }
						
						
                    //} 
					
					/*else {
                        $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        //$this->view->profession = $_POST["profession_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
                    }*/
                //} 
				
				/*else {
                    $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    //$this->view->profession = $_POST["profession_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    return;
                }*/
				
				
                    $gac_mapper = new Application_Model_EuGacMapper();
                    $gac = new Application_Model_EuGac();
					$findgac = $gac_mapper->findtypegac($_POST["id_pays"],$_POST["categorie_gac"],$_POST["type_gac"]);
                    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
					
					$t_division =   new Application_Model_DbTable_EuTeteDivision();
                    $c_division =   new Application_Model_EuTeteDivision();
					
                    $userin = new Application_Model_EuUtilisateur();
                    $user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					
					if($findgac != false) {
					  $db->rollBack();
                      $this->view->message = "Le type de gac est déja créé !!!";
                      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      //$this->view->profession = $_POST["profession_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
					}
                    
                    if(trim($user->code_groupe) == 'gacdsecteur' || trim($user->code_groupe) == 'gacssecteur' || trim($user->code_groupe) == 'gacexsecteur')  {
                        $type_gac = $_POST["type_gac"];
                        if(trim($user->code_groupe) == 'gacdsecteur') {
						
						   // verification du numero de licence
                           $trouvel = $licence_mapper->findlicence($_POST["numero_licence"]);
                           if($trouvel != false) {
                           $num_licence = $_POST["numero_licence"];
                           $result = $licence_mapper->find($trouvel->getId_licence(),$licence);
                           $licence->setCode_membre_morale($code);
                           $licence_mapper->update($licence);
                        }  else {
                                $db->rollBack();
                                $this->view->message = " Le numéro de licence est invalide ou est déjà utilisé";
                                $this->view->type_acteur = $_POST["type_acteur"];
                                $this->view->statut_juridique = $_POST["statut_juridique"];
                                $this->view->raison = $_POST["raison_sociale"];
                                $this->view->domaine_activite = $_POST["domaine_activite"];
                                $this->view->site_web = $_POST["site_web"];
                                $this->view->quartier_membre = $_POST["quartier_membre"];
                                $this->view->ville_membre = $_POST["ville_membre"];
                                $this->view->bp = $_POST["bp_membre"];
                                $this->view->tel = $_POST["tel_membre"];
                                $this->view->email = $_POST["email_membre"];
                                $this->view->portable = $_POST["portable_membre"];
                                //$this->view->profession = $_POST["profession_membre"];
                                $this->view->registre = $_POST["num_registre"];
                                return;
                       }   
                    } else {
                            $trouveof = $offres_mapper->findoffres($_POST["numero_offre"]);
                            if($trouveof != false) {
						          // verification du numero contrat
                                  $num_offre = $_POST["numero_offre"];
                                  $result = $offres_mapper->find($trouveof->getId_appeloffres(),$offres);
                                  $offres->setCode_membre_morale($code);
                                  $offres_mapper->update($offres);
                            } else {
                                  $db->rollBack();
                                  $this->view->message = " Le numéro du document d'appel d'offre est invalide ou est déjà utilisé";
                                  $this->view->type_acteur = $_POST["type_acteur"];
                                  $this->view->statut_juridique = $_POST["statut_juridique"];
                                  $this->view->raison = $_POST["raison_sociale"];
                                  $this->view->domaine_activite = $_POST["domaine_activite"];
                                  $this->view->site_web = $_POST["site_web"];
                                  $this->view->quartier_membre = $_POST["quartier_membre"];
                                  $this->view->ville_membre = $_POST["ville_membre"];
                                  $this->view->bp = $_POST["bp_membre"];
                                  $this->view->tel = $_POST["tel_membre"];
                                  $this->view->email = $_POST["email_membre"];
                                  $this->view->portable = $_POST["portable_membre"];
                                  //$this->view->profession = $_POST["profession_membre"];
                                  $this->view->registre = $_POST["num_registre"];
                                  return;
                            }
                    }
                       //$code_zone = $user->code_zone;
                       $code_recup = $gac_mapper->getLastGacByZone($code_zone);
                        if ($code_recup == null) {
                          $code_gac = 'G' . $code_zone . '0001';
                        } else {
                          $num_ordre = substr($code_recup, -4);
                          $num_ordre++;
                          $code_gac = 'G' . $code_zone . str_pad($num_ordre, 4, 0,STR_PAD_LEFT);
                        }
                       
					   // insertion dans la table eu_gac
                       $gac->setCode_gac($code_gac);
                       $gac->setCode_membre($code);
                       $gac->setNom_gac($_POST["raison_sociale"]);
                       $gac->setCode_type_gac($type_gac);
                       $gac->setCode_zone($code_zone);
                       $gac->setCode_membre_gestionnaire($_POST['code_rep']);
                       $gac->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                       $gac->setId_utilisateur($user->id_utilisateur);
					   $gac->setType_gac($_POST["categorie_gac"]);
					   $gac->setId_pays($_POST["id_pays"]);
                       $gac->setGroupe('gac');
                       $gac->setZone($code_zone);
					   $gac->setId_region($_POST["id_region"]);
					   $gac->setCode_secteur($_POST["id_prefecture"]);
					   $gac->setCode_agence(null);
                       $gac->setCode_gac_create(null);
                       $gac->setCode_gac_chaine(null);
                       $gac_mapper->save($gac);
                       
					   
					    $filiere =  new Application_Model_EuFiliere();
					    $map_filiere = new Application_Model_EuFiliereMapper();
					    $find_filiere = $map_filiere->find($user->id_filiere,$filiere);
						
						// insertion dans la table eu_acteur
                        $count = $c_acteur->findConuter() + 1;
                        $c_acteur->setId_acteur($count)
                                ->setCode_acteur($code_gac)
								->setCode_division($filiere->getCode_division())
                                ->setCode_membre($code)
                                ->setType_acteur($type_gac)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					    if($_POST["categorie_gac"] == 'secteur') {			
                          $c_acteur->setCode_activite('PREFECTURE');
						  $c_acteur->setCode_source_create('SOURCE');
						  $c_acteur->setCode_monde_create('MONDE');
						  $c_acteur->setCode_zone_create($code_zone);
						  $c_acteur->setId_pays($_POST["id_pays"]);
						  $c_acteur->setId_region($_POST["id_region"]);
						  $c_acteur->setId_prefecture($_POST["id_prefecture"]);
						  //$c_acteur->setCode_secteur_create($_POST["code_secteur"]);
						  $c_acteur->setCode_agence_create(null);  
                        }   
                        $c_acteur->setCode_gac_chaine($acteur);					   
                        $t_acteur->insert($c_acteur->toArray());
                       
					   
					   
                        //R�cup�ration de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prc = 0;
                        $par_prc = $param->find('prc', 'nr', $par);
                        if ($par_prc == true) {
                           $prc = $par->getMontant();
                        }
						
						// insertion dans la table eu_tegc
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'TEGCP' .$user->id_filiere. $code.'00001';
                        $find_te = $te_mapper->find($code_te, $te);
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
							   ->setNom_tegc(addslashes (trim ($_POST["raison_sociale"])))
								   ->setSubvention(0)
                               ->setId_filiere($user->id_filiere)
                               ->setMdv($prc)
                               ->setCode_membre($code)
                               ->setMontant(0)
							   ->setMontant_utilise(0)
							   ->setSolde_tegc(0);
                            $te_mapper->save($te);
                        } else {
                                $te->setId_filiere($user->id_filiere);
                                $te->setMdv($prc);
                                $te_mapper->update($te);
                        }
                        
                        //Initialisation du compte tegcp
                        $date_alloc = new Zend_Date(Zend_Date::ISO_8601);
                        $code_cat = 'TPAGCP';
                        $code_compte = 'NB-' . $code_cat . '-' . $code;
                        $compte_mapper = new Application_Model_EuCompteMapper();
                        $compte = new Application_Model_EuCompte();
                        $find_compte = $compte_mapper->find($code_compte,$compte);       
                    }
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					
					// insertion dans la table eu_utilisateur
                    $id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if(trim($user->code_groupe) == 'gacdsecteur') {
					  if($_POST["categorie_gac"] == 'secteur'){
                         $userin->setCode_groupe('detentrice_secteur');
					     $userin->setCode_groupe_create('detentrice_secteur');
					  } 					  
                    } elseif(trim($user->code_groupe) == 'gacexsecteur') {
					    if($_POST["categorie_gac"] == 'secteur'){
                         $userin->setCode_groupe('executante_secteur');
					     $userin->setCode_groupe_create('executante_secteur');
					    } 
                    } elseif(trim($user->code_groupe) == 'gacssecteur') {
					  if($_POST["categorie_gac"] == 'secteur') {
                         $userin->setCode_groupe('surveillance_secteur');
					     $userin->setCode_groupe_create('surveillance_secteur');
					  } 
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($user->id_filiere);
                    
                    $userin->setCode_acteur($code_gac);
                   
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays);            
                    $user_mapper->save($userin);
                    
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
                    
				    $contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
					if(trim($user->code_groupe) == 'gacdsecteur') {
				      $contrat->setId_type_contrat(1);
					} elseif(trim($user->code_groupe) == 'gacssecteur') {   
					  $contrat->setId_type_contrat(2);
					} elseif(trim($user->code_groupe) == 'gacexsecteur') { 
					  $contrat->setId_type_contrat(3);
					}   
                    $contrat->setId_type_creneau(null);
                    $contrat->setId_type_acteur(null);
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode(null)
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());

                    
					// Mise à jour de la table eu_smsmoney  
                    /* $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms); */
					
					$tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
                    $code_fl = 'FL-' . $code;
						
				    $fl->setCode_fl($code_fl)
                       ->setCode_membre(NULL)
					   ->setOrigine_fl(null)
                       ->setCode_membre_morale($code)
                       ->setMont_fl($mont_fl)
                       ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                       ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setCreditcode(null);   
				  
                    $tfl->insert($fl->toArray());
					
					$compte = new Application_Model_EuCompte();
                    $map_compte = new Application_Model_EuCompteMapper();
					
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
					
					for($i = 1; $i < count($tcartes); $i++) {
                       if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                         $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NR';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE" || $tcartes[$i] == "TMARGE") {
                         $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NN';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
                         $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NB';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIN") {
                         $tcartes[$i] = "TI"; 
                         $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NN';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIR") {
                         $tcartes[$i] = "TI"; 
                         $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NR';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIB") {
                         $tcartes[$i] = "TI";
                         $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NB';
                         $res = $map_compte->find($code_compte,$compte);
                       }
                         if(!$res) {
                           $compte->setCode_cat($tcartes[$i])
                                  ->setCode_compte($code_compte)
                                  ->setCode_membre(NULL)
                                  ->setCode_membre_morale($code)
                                  ->setCode_type_compte($type_carte)
                                  ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
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
						
						for($j = 0; $j < count($tscartes); $j++) {
                           if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                             $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NR';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSMARGE" || $tscartes[$j] == "TSRE") {
                             $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NN';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
                             $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NB';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSIN") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NN';
                             $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIR") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NR';
                             $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIB") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NB';
                             $res = $map_compte->find($code_comptets,$compte);
                            }
                            if(!$res) {
                              $compte->setCode_cat($tscartes[$j])
                                     ->setCode_compte($code_comptets)
                                     ->setCode_membre(NULL)
                                     ->setCode_membre_morale($code)
                                     ->setCode_type_compte($type_carte)
                                     ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                     ->setDesactiver(0)
                                     ->setLib_compte($tscartes[$j])
                                     ->setSolde(0);
                                $map_compte->save($compte);
                            }

                        }
						
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
                        $id_demande = $carte->findConuter() + 1;
                        $carte->setId_demande($id_demande)
                              ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("NB-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
							  ->setOrigine_fkps(null)
                              ->setId_utilisateur($user->id_utilisateur);	  
                        $t_carte->insert($carte->toArray());
					
                        $compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,NULL,$code, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
                        
					
					
					
					
					
				
                $compteur=Util_Utils::findConuter() + 1;
                Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau ESMC! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                $db->commit();
                return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));
            } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
            }
        }
	}
	
	
	public function newpmgacregionAction() {
	       $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $request = $this->getRequest();
           $type_gac = $request->type_gac;
           $this->view->type_gac = $type_gac;
           $code_agence = $user->code_agence;
		   $code_zone = substr($code_agence,0,3);
		   $acteur      = $user->code_acteur;
		   $num_membre  = $user->code_membre;
		   
		   $gac_mapper = new Application_Model_EuGacMapper();
           $gac = new Application_Model_EuGac();
		   //$pays_mapper = new Application_Model_EuPaysMapper();
           //$pays = new Application_Model_EuPays();
		   //$find_gac = $gac_mapper->find($acteur,$gac);
		   //$find_pays = $pays_mapper->find($gac->getId_pays(),$pays);
           $fs = Util_Utils::getParametre('FS','valeur');
           $this->view->fs = $fs;
		   //$this->view->id_pays = $gac->getId_pays();
		   //$this->view->nationalite = $pays->getNationalite();
		   
		    $agence_mapper = new Application_Model_EuAgenceMapper();
            $agence = new Application_Model_EuAgence();
		   
		    $secteur_mapper = new Application_Model_EuSecteurMapper();
            $secteur = new Application_Model_EuSecteur();
			
			$prefecture_mapper = new Application_Model_EuPrefectureMapper();
            $prefecture = new Application_Model_EuPrefecture();
		   
		    //$region_mapper = new Application_Model_EuRegionMapper();
            //$region = new Application_Model_EuRegion();
		   
		    $pays_mapper = new Application_Model_EuPaysMapper();
            $pays = new Application_Model_EuPays();
		   
		     //if($acteur !='' && $acteur != NULL) {
		        //$find_gac = $gac_mapper->find($acteur,$gac);
		        //$find_pays = $pays_mapper->find($gac->getId_pays(),$pays);
		        //$this->view->id_pays = $gac->getId_pays();
		        //$this->view->id_region = $gac->getId_region();
		        //$this->view->nationalite = $pays->getNationalite();
			 //} else {
			    $find_agence = $agence_mapper->find($code_agence,$agence);
			    $find_pre = $prefecture_mapper->find($agence->getId_prefecture(),$prefecture);
			    $find_pays = $pays_mapper->find($agence->getId_pays(),$pays);
			    $this->view->id_pays = $agence->getId_pays();
		        $this->view->id_region = $agence->getId_region();
		        //$this->view->code_secteur = $secteur->getCode_secteur();
		        $this->view->nationalite = $pays->getNationalite();
             //}
		   
		   
		   if ($this->getRequest()->isPost()) {
           $date_id = new Zend_Date(Zend_Date::ISO_8601);
           $date_idd = clone $date_id;
           //$code_sms = $_POST["code_sms"];
		   $fs = Util_Utils::getParametre('FS','valeur');
		   $mont_fl = Util_Utils::getParametre('FL','valeur');
           $fcps = Util_Utils::getParametre('FKPS','valeur');
		   $tcartes = array();
           $tscartes = array();
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
               //$frais_identification = trim($_POST["frais_identification"]);
               $licence_mapper = new Application_Model_EuLicenceMapper();
               $licence = new Application_Model_EuLicence();
               $offres_mapper = new Application_Model_EuAppeloffresMapper();
               $offres = new Application_Model_EuAppeloffres();
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
               $cm_map = new Application_Model_EuCompteMapper();
               $_compte = new Application_Model_EuCompte();
               //$sms = $sms_mapper->findByCreditCode($code_sms);
               //if ($sms != null) {
                  //$mont = $sms->getCreditAmount();
                  //if ($mont == $frais_identification) {
                         
                        /* if($sms->getMotif() != 'FS') {
                            $db->rollBack();
                            $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;    
                        }*/
                         
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
                        $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($_POST["type_acteur"]);
                        $membre->setCode_statut($_POST["statut_juridique"]);
                        $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
                        $membre->setId_pays($_POST["id_pays"]);
                        $membre->setNum_registre_membre($_POST["num_registre"]);
                        $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                        $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                        $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                        $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                        $membre->setBp_membre($_POST["bp_membre"]);
                        $membre->setTel_membre($_POST["tel_membre"]);
                        $membre->setEmail_membre($_POST["email_membre"]);
                        $membre->setPortable_membre($_POST["portable_membre"]);
                        $membre->setId_utilisateur($user->id_utilisateur);
                        $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('O');
                        $membre->setEtat_membre('N');
                        $membre->setId_filiere($user->id_filiere);   
                        
                        $mapper->save($membre);
                        //insertion  dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteur,null,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                        //Util_Utils::createCompte('nb-tpagci-' . $code, 'tpagci', 'tpagci', 0, $code, 'nb', $date_id, 0);
    
					        // insertion dans la table eu_representation
                            $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                            $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
                           
                           
						// insertion dans la table eu_compte_bancaire
                        $cpte = $_POST['cpteur'];
                        $i = 1;
                        $cb_mapper = new Application_Model_EuCompteBancaireMapper(); 
                        $cb = new Application_Model_EuCompteBancaire();
                        while ($i <= $cpte) {
						    $id_compte = $cb_mapper->findConuter() + 1;
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                                $cb->setId_compte($id_compte)
                                   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
                                   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                        }
                    //} 
					
					/*else {
                        $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        //$this->view->profession = $_POST["profession_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
                    }*/
					
                //} 
				
				/*
				else {
                    $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    //$this->view->profession = $_POST["profession_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    return;
                }*/
				
				
				
				
                    $gac_mapper = new Application_Model_EuGacMapper();
                    $gac = new Application_Model_EuGac();
					$findgac = $gac_mapper->findtypegac($_POST["id_pays"],$_POST["categorie_gac"],$_POST["type_gac"]);
                    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
					
					$t_division = new Application_Model_DbTable_EuTeteDivision();
                    $c_division = new Application_Model_EuTeteDivision();
					
                    $userin = new Application_Model_EuUtilisateur();
                    $user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					
					if($findgac != false) {
					  $db->rollBack();
                      $this->view->message = "Le type de gac est déja créé !!!";
                      $this->view->type_acteur = $_POST["type_acteur"];
                      $this->view->statut_juridique = $_POST["statut_juridique"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      //$this->view->profession = $_POST["profession_membre"];
                      $this->view->registre = $_POST["num_registre"];
                      return;
					}
                    
                    if(trim($user->code_groupe) == 'gacdregion' || trim($user->code_groupe) == 'gacsregion' || trim($user->code_groupe) == 'gacexregion')  {
                        $type_gac = $_POST["type_gac"];
                        if(trim($user->code_groupe) == 'gacdregion') {
						   // verification du numero de licence
                           $trouvel = $licence_mapper->findlicence($_POST["numero_licence"]);
                           if($trouvel != false) {
                           $num_licence = $_POST["numero_licence"];
                           $result = $licence_mapper->find($trouvel->getId_licence(),$licence);
                           $licence->setCode_membre_morale($code);
                           $licence_mapper->update($licence);
                        }  else {
                                $db->rollBack();
                                $this->view->message = " Le numéro de licence est invalide ou est déjà utilisé";
                                $this->view->type_acteur = $_POST["type_acteur"];
                                $this->view->statut_juridique = $_POST["statut_juridique"];
                                $this->view->raison = $_POST["raison_sociale"];
                                $this->view->domaine_activite = $_POST["domaine_activite"];
                                $this->view->site_web = $_POST["site_web"];
                                $this->view->quartier_membre = $_POST["quartier_membre"];
                                $this->view->ville_membre = $_POST["ville_membre"];
                                $this->view->bp = $_POST["bp_membre"];
                                $this->view->tel = $_POST["tel_membre"];
                                $this->view->email = $_POST["email_membre"];
                                $this->view->portable = $_POST["portable_membre"];
                                //$this->view->profession = $_POST["profession_membre"];
                                $this->view->registre = $_POST["num_registre"];
                                return;
                       }   
                    } else {
					       // verification du numero contrat
                           $trouveof = $offres_mapper->findoffres($_POST["numero_offre"]);
                           if($trouveof != false) {
                                  $num_offre = $_POST["numero_offre"];
                                  $result = $offres_mapper->find($trouveof->getId_appeloffres(),$offres);
                                  $offres->setCode_membre_morale($code);
                                  $offres_mapper->update($offres);
                           } else {
                                  $db->rollBack();
                                  $this->view->message = " Le numéro du document d'appel d'offre est invalide ou est déjà utilisé";
                                  $this->view->type_acteur = $_POST["type_acteur"];
                                  $this->view->statut_juridique = $_POST["statut_juridique"];
                                  $this->view->raison = $_POST["raison_sociale"];
                                  $this->view->domaine_activite = $_POST["domaine_activite"];
                                  $this->view->site_web = $_POST["site_web"];
                                  $this->view->quartier_membre = $_POST["quartier_membre"];
                                  $this->view->ville_membre = $_POST["ville_membre"];
                                  $this->view->bp = $_POST["bp_membre"];
                                  $this->view->tel = $_POST["tel_membre"];
                                  $this->view->email = $_POST["email_membre"];
                                  $this->view->portable = $_POST["portable_membre"];
                                  //$this->view->profession = $_POST["profession_membre"];
                                  $this->view->registre = $_POST["num_registre"];
                                  return;
                            }
                    }
                       
                        $code_recup = $gac_mapper->getLastGacByZone($code_zone);
                        if ($code_recup == null) {
                          $code_gac = 'G' . $code_zone . '0001';
                        } else {
                          $num_ordre = substr($code_recup, -4);
                          $num_ordre++;
                          $code_gac = 'G' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                        }
                       
					   // insertion dans la table eu_gac
                       $gac->setCode_gac($code_gac);
                       $gac->setCode_membre($code);
                       $gac->setNom_gac($_POST["raison_sociale"]);
                       $gac->setCode_type_gac($type_gac);
                       $gac->setCode_zone($code_zone);
                       $gac->setCode_membre_gestionnaire($_POST['code_rep']);
                       $gac->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                       $gac->setId_utilisateur($user->id_utilisateur);
					   $gac->setType_gac($_POST["categorie_gac"]);
					   $gac->setId_pays($_POST["id_pays"]);
                       $gac->setGroupe('gac');
                       $gac->setZone($code_zone);
					   $gac->setId_region($_POST["id_region"]);
					   $gac->setCode_secteur(null);
					   $gac->setCode_agence(null);
                       $gac->setCode_gac_create(null);
                       $gac->setCode_gac_chaine(null);
                       $gac_mapper->save($gac);
                       
					   $filiere =  new Application_Model_EuFiliere();
					   $map_filiere = new Application_Model_EuFiliereMapper();
					   $find_filiere = $map_filiere->find($user->id_filiere,$filiere);
					   
					   // insertion dans la table eu_acteur
                       $count = $c_acteur->findConuter() + 1;
                       $c_acteur->setId_acteur($count)
                                ->setCode_acteur($code_gac)
								->setCode_division($filiere->getCode_division())
                                ->setCode_membre($code)
                                ->setType_acteur($type_gac)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					   if($_POST["categorie_gac"] == 'region') {
					   			
                          $c_acteur->setCode_activite('REGION');
						  $c_acteur->setCode_source_create('SOURCE');
						  $c_acteur->setCode_monde_create('MONDE');
						  $c_acteur->setCode_zone_create($code_zone);
						  $c_acteur->setId_pays($_POST["id_pays"]);
						  $c_acteur->setId_region($_POST["id_region"]);
						  $c_acteur->setCode_secteur_create(null);
						  $c_acteur->setCode_agence_create(null);
                       }   
                       $c_acteur->setCode_gac_chaine($acteur);					   
                       $t_acteur->insert($c_acteur->toArray());
					   
					  
                        //R�cup�ration de la prk nr
                        $param = new Application_Model_EuParametresMapper();
                        $par = new Application_Model_EuParametres();
                        $prc = 0;
                        $par_prc = $param->find('prc', 'nr', $par);
                        if ($par_prc == true) {
                          $prc = $par->getMontant();
                        }
						
						// insertion dans la table eu_tegc
                        $te_mapper = new Application_Model_EuTegcMapper();
                        $te = new Application_Model_EuTegc();
                        $code_te = 'TEGCP' .$user->id_filiere. $code.'00001';
                        $find_te = $te_mapper->find($code_te, $te);
                        if ($find_te == false) {
                            $te->setCode_tegc($code_te)
							   ->setNom_tegc(addslashes (trim ($_POST["raison_sociale"])))
							   ->setSubvention(0)
                               ->setId_filiere($user->id_filiere)
                               ->setMdv($prc)
                               ->setCode_membre($code)
                               ->setMontant(0)
							   ->setMontant_utilise(0)
							   ->setSolde_tegc(0);
                            $te_mapper->save($te);
                        } else {
                                $te->setId_filiere($user->id_filiere);
                                $te->setMdv($prc);
                                $te_mapper->update($te);
                        }
                        
                        //Initialisation du compte tegcp
                        $date_alloc = new Zend_Date(Zend_Date::ISO_8601);
                        $code_cat = 'TPAGCP';
                        $code_compte = 'NB-' . $code_cat . '-' . $code;
                        $compte_mapper = new Application_Model_EuCompteMapper();
                        $compte = new Application_Model_EuCompte();
                        $find_compte = $compte_mapper->find($code_compte,$compte);       
                    }
					
					// insertion dans la table eu_utilisateur
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                    $id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if(trim($user->code_groupe) == 'gacdregion') {
					  if($_POST["categorie_gac"] == 'region'){
                         $userin->setCode_groupe('detentrice_region');
					     $userin->setCode_groupe_create('detentrice_region');
					  } 					  
                    } elseif(trim($user->code_groupe) == 'gacexregion') {
					  if($_POST["categorie_gac"] == 'region'){
                         $userin->setCode_groupe('executante_region');
					     $userin->setCode_groupe_create('executante_region');
					  } 
                    } elseif(trim($user->code_groupe) == 'gacsregion') {
					  if($_POST["categorie_gac"] == 'region') {
                         $userin->setCode_groupe('surveillance_region');
					     $userin->setCode_groupe_create('surveillance_region');
					  } 
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($user->id_filiere);
                    
                    $userin->setCode_acteur($code_gac);
                   
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays);            
                    $user_mapper->save($userin);
                    
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
                    
				    $contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
					if(trim($user->code_groupe) == 'gacdregion') {
				      $contrat->setId_type_contrat(1);
					} elseif(trim($user->code_groupe) == 'gacsregion') {   
					  $contrat->setId_type_contrat(2);
					} elseif(trim($user->code_groupe) == 'gacexregion') { 
					  $contrat->setId_type_contrat(3);
					}
					
                    $contrat->setId_type_creneau(null);
                    $contrat->setId_type_acteur(null);
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('fs-' . $code)
                             //->setCreditcode($sms->getCreditCode())
							 ->setCreditcode(NULL)
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());
					
					
					$tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
                    $code_fl = 'FL-' . $code;
						
				    $fl->setCode_fl($code_fl)
                       ->setCode_membre(NULL)
					   ->setOrigine_fl(null)
                       ->setCode_membre_morale($code)
                       ->setMont_fl($mont_fl)
                       ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                       ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setCreditcode(null);   
				  
                    $tfl->insert($fl->toArray());
					
					$compte = new Application_Model_EuCompte();
                    $map_compte = new Application_Model_EuCompteMapper();
					
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
					
					for($i = 1; $i < count($tcartes); $i++) {
                       if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                         $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NR';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE" || $tcartes[$i] == "TMARGE") {
                         $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NN';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
                         $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NB';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIN") {
                         $tcartes[$i] = "TI"; 
                         $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NN';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIR") {
                         $tcartes[$i] = "TI"; 
                         $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NR';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIB") {
                         $tcartes[$i] = "TI";
                         $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NB';
                         $res = $map_compte->find($code_compte,$compte);
                       }
                         if(!$res) {
                           $compte->setCode_cat($tcartes[$i])
                                  ->setCode_compte($code_compte)
                                  ->setCode_membre(NULL)
                                  ->setCode_membre_morale($code)
                                  ->setCode_type_compte($type_carte)
                                  ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
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
						
						for($j = 0; $j < count($tscartes); $j++) {
                           if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                             $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NR';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSMARGE" || $tscartes[$j] == "TSRE") {
                             $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NN';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
                             $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NB';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSIN") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NN';
                             $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIR") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NR';
                             $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIB") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NB';
                             $res = $map_compte->find($code_comptets,$compte);
                            }
                            if(!$res) {
                              $compte->setCode_cat($tscartes[$j])
                                     ->setCode_compte($code_comptets)
                                     ->setCode_membre(NULL)
                                     ->setCode_membre_morale($code)
                                     ->setCode_type_compte($type_carte)
                                     ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                     ->setDesactiver(0)
                                     ->setLib_compte($tscartes[$j])
                                     ->setSolde(0);
                                $map_compte->save($compte);
                            }

                        }
						
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
                        $id_demande = $carte->findConuter() + 1;
                        $carte->setId_demande($id_demande)
                              ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("NB-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
							  ->setOrigine_fkps(null)
                              ->setId_utilisateur($user->id_utilisateur);	  
                        $t_carte->insert($carte->toArray());
					
                        $compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,NULL,$code, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
                        
					
					

                    
					// Mise à jour de la table eu_smsmoney  
                    /*$sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);*/
				
                $compteur=Util_Utils::findConuter() + 1;
                Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau ESMC! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                $db->commit();
                return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));
                
				//}
            } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
            }
        }
	
	}
	
	

	
	
	
	
    public function newpmgacAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $type_gac = $request->type_gac;
        $this->view->type_gac = $type_gac;
        $code_agence = $user->code_agence;
		$code_zone = substr($code_agence,0,3);
		$acteur      = $user->code_acteur;
        $fs = Util_Utils::getParametre('FS','valeur');
        $mont_fl = Util_Utils::getParametre('FL','valeur');
        $fcps = Util_Utils::getParametre('FKPS','valeur');
        $this->view->fs = $fs;
        if ($this->getRequest()->isPost()) {
           $date_id = new Zend_Date(Zend_Date::ISO_8601);
           $date_idd = clone $date_id;
           //$code_sms = $_POST["code_sms"];
		   $suppliant = "";
		   $tcartes = array();
           $tscartes = array();
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
               //$frais_identification = trim($_POST["frais_identification"]);
               $licence_mapper = new Application_Model_EuLicenceMapper();
               $licence = new Application_Model_EuLicence();
               $offres_mapper = new Application_Model_EuAppeloffresMapper();
               $offres = new Application_Model_EuAppeloffres();
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
               $cm_map = new Application_Model_EuCompteMapper();
               $_compte = new Application_Model_EuCompte();
               //$sms = $sms_mapper->findByCreditCode($code_sms);
			   
               //if ($sms != null) {
               //$mont = $sms->getCreditAmount();
               //if ($mont == $frais_identification) { 
                        /*if($sms->getMotif() != 'FS') {
                            $db->rollBack();
                            $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                            $this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;    
                        }*/
                         
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
                        $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($_POST["type_acteur"]);
                        $membre->setCode_statut($_POST["statut_juridique"]);
                        $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
                        $membre->setId_pays($_POST["id_pays"]);
                        $membre->setNum_registre_membre($_POST["num_registre"]);
                        $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                        $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                        $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                        $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                        $membre->setBp_membre($_POST["bp_membre"]);
                        $membre->setTel_membre($_POST["tel_membre"]);
                        $membre->setEmail_membre($_POST["email_membre"]);
                        $membre->setPortable_membre($_POST["portable_membre"]);
                        $membre->setId_utilisateur($user->id_utilisateur);
                        $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('O');
                        $membre->setEtat_membre('N');
                        $membre->setId_filiere($user->id_filiere);   
                        
                        $mapper->save($membre);
                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteur,null,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                        
					   
                        $rep_mapper = new Application_Model_EuRepresentationMapper();
                        $rep = new Application_Model_EuRepresentation();
                        $rep->setCode_membre_morale($code)
                            ->setCode_membre($_POST['code_rep'])
                            ->setTitre("Representant")
							->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							->setId_utilisateur($user->id_utilisateur)
							->setEtat('inside');
                        $rep_mapper->save($rep);
                              
						// Mise à jour de la table eu_representation
                        $cpte = $_POST['cpteur'];
                        $i = 1;
                        $cb_mapper = new Application_Model_EuCompteBancaireMapper(); 
                        $cb = new Application_Model_EuCompteBancaire();
                        while ($i <= $cpte) {
						    $id_compte = $cb_mapper->findConuter() + 1;
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                                $cb->setId_compte($id_compte)
                                   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
                                   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                        }
                    //} 
					
					/*else {
                        $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        //$this->view->profession = $_POST["profession_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
                    }*/
					
                //} 
				
				/*else {
                    $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    //$this->view->profession = $_POST["profession_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    return;
                }*/
                    $gac_mapper = new Application_Model_EuGacMapper();
                    $gac = new Application_Model_EuGac();
					$findgac = $gac_mapper->findtypegac($_POST["id_pays"],$_POST["categorie_gac"],$_POST["type_gac"]);
                    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
					
					$t_division = new Application_Model_DbTable_EuTeteDivision();
                    $c_division = new Application_Model_EuTeteDivision();
					
                    $userin = new Application_Model_EuUtilisateur();
                    $user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    
                    $membre_mapper = new Application_Model_EuMembreMapper();
                    $membrein = new Application_Model_EuMembre();
					
					if($findgac != false) {
					    $db->rollBack();
                        $this->view->message = "Le type de gac est déja créé !!!";
                        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        //$this->view->profession = $_POST["profession_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
					}
                    
                    if(trim($user->code_groupe) == 'gacd' || trim($user->code_groupe) == 'gacs' || trim($user->code_groupe) == 'gacex' ||
					   trim($user->code_groupe) == 'gacdm' || trim($user->code_groupe) == 'gacsm' || trim($user->code_groupe) == 'gacexm' ||
					   trim($user->code_groupe) == 'gacdz' || trim($user->code_groupe) == 'gacsz' || trim($user->code_groupe) == 'gacexz'  ||
					   trim($user->code_groupe) == 'gacdp' || trim($user->code_groupe) == 'gacsp' || trim($user->code_groupe) == 'gacexp'
					)  {
                        $type_gac = $_POST["type_gac"];
                        if(trim($user->code_groupe) == 'gacd' || trim($user->code_groupe) == 'gacdm' || trim($user->code_groupe) == 'gacdz' || trim($user->code_groupe) == 'gacdp') {
                            // verification du numero licence
						    $trouvel = $licence_mapper->findlicence($_POST["numero_licence"]);
                            if($trouvel != false) {
                              $num_licence = $_POST["numero_licence"];
                              $result = $licence_mapper->find($trouvel->getId_licence(),$licence);
                              $licence->setCode_membre_morale($code);
                              $licence_mapper->update($licence);
                            }  else {
                                $db->rollBack();
                                $this->view->message = " Le numéro de licence est invalide ou est déjà utilisé";
                                $this->view->type_acteur = $_POST["type_acteur"];
                                $this->view->statut_juridique = $_POST["statut_juridique"];
                                $this->view->raison = $_POST["raison_sociale"];
                                $this->view->domaine_activite = $_POST["domaine_activite"];
                                $this->view->site_web = $_POST["site_web"];
                                $this->view->quartier_membre = $_POST["quartier_membre"];
                                $this->view->ville_membre = $_POST["ville_membre"];
                                $this->view->bp = $_POST["bp_membre"];
                                $this->view->tel = $_POST["tel_membre"];
                                $this->view->email = $_POST["email_membre"];
                                $this->view->portable = $_POST["portable_membre"];
                                //$this->view->profession = $_POST["profession_membre"];
                                $this->view->registre = $_POST["num_registre"];
                                return;
                           }   
                    } else {
					        // verification du numero contrat
                            $trouveof = $offres_mapper->findoffres($_POST["numero_offre"]);
                            if($trouveof != false) {
                                  $num_offre = $_POST["numero_offre"];
                                  $result = $offres_mapper->find($trouveof->getId_appeloffres(),$offres);
                                  $offres->setCode_membre_morale($code);
                                  $offres_mapper->update($offres);
                            } else {
                                  $db->rollBack();
                                  $this->view->message = " Le numéro du document d'appel d'offre est invalide ou est déjà utilisé";
                                  $this->view->type_acteur = $_POST["type_acteur"];
                                  $this->view->statut_juridique = $_POST["statut_juridique"];
                                  $this->view->raison = $_POST["raison_sociale"];
                                  $this->view->domaine_activite = $_POST["domaine_activite"];
                                  $this->view->site_web = $_POST["site_web"];
                                  $this->view->quartier_membre = $_POST["quartier_membre"];
                                  $this->view->ville_membre = $_POST["ville_membre"];
                                  $this->view->bp = $_POST["bp_membre"];
                                  $this->view->tel = $_POST["tel_membre"];
                                  $this->view->email = $_POST["email_membre"];
                                  $this->view->portable = $_POST["portable_membre"];
                                  //$this->view->profession = $_POST["profession_membre"];
                                  $this->view->registre = $_POST["num_registre"];
                                  return;
                            }
                    }
                       
                        $code_recup = $gac_mapper->getLastGacByZone($code_zone);
                        if ($code_recup == null) {
                          $code_gac = 'G' . $code_zone . '0001';
                        } else {
                          $num_ordre = substr($code_recup, -4);
                          $num_ordre++;
                          $code_gac = 'G' . $code_zone . str_pad($num_ordre, 4, 0,STR_PAD_LEFT);
                        }
                       // insertion dans la table eu_gac
                       $gac->setCode_gac($code_gac);
                       $gac->setCode_membre($code);
                       $gac->setNom_gac($_POST["raison_sociale"]);
                       $gac->setCode_type_gac($type_gac);
                       $gac->setCode_zone($code_zone);
                       $gac->setCode_membre_gestionnaire($_POST['code_rep']);
                       $gac->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                       $gac->setId_utilisateur($user->id_utilisateur);
					   $gac->setType_gac($_POST["categorie_gac"]);
					   $gac->setId_pays($_POST["id_pays"]);
                       $gac->setGroupe('GAC');
                       $gac->setZone($code_zone);
					   $gac->setId_region(null);
					   $gac->setCode_secteur(null);
					   $gac->setCode_agence(null);
                       $gac->setCode_gac_create(null);
                       $gac->setCode_gac_chaine(null);
                       $gac_mapper->save($gac);
                       
					    // insertion dans la table eu_acteur
					    $filiere =  new Application_Model_EuFiliere();
					    $map_filiere = new Application_Model_EuFiliereMapper();
					    $find_filiere = $map_filiere->find($user->id_filiere,$filiere);
                        $count = $c_acteur->findConuter() + 1;
                        $c_acteur->setId_acteur($count)
                                ->setCode_acteur($code_gac)
								->setCode_division($filiere->getCode_division())
                                ->setCode_membre($code)
                                ->setType_acteur($type_gac)
                                ->setId_utilisateur($user->id_utilisateur)
                                ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
					    if($_POST["categorie_gac"] == 'source') {		
                          $c_acteur->setCode_activite('SOURCE');
						  $c_acteur->setCode_source_create('SOURCE');
						  $c_acteur->setCode_monde_create('MONDE');
						  $c_acteur->setCode_zone_create(null);
						  $c_acteur->setId_pays(null);
						  $c_acteur->setId_region(null);
						  $c_acteur->setCode_secteur_create(null);
						  $c_acteur->setCode_agence_create(null);
						  //$c_acteur->setId_sub_secteur(null);
						  
                        } elseif($_POST["categorie_gac"] == 'zone') {
					   
                          $c_acteur->setCode_activite('ZONE');
						  $c_acteur->setCode_source_create('SOURCE');
						  $c_acteur->setCode_monde_create('MONDE');
						  $c_acteur->setCode_zone_create($code_zone);
						  $c_acteur->setId_pays(null);
						  $c_acteur->setId_region(null);
						  $c_acteur->setCode_secteur_create(null);
						  $c_acteur->setCode_agence_create(null);
						  //$c_acteur->setId_sub_secteur(null);
						  
                        } elseif($_POST["categorie_gac"] == 'monde') {
                          $c_acteur->setCode_activite('MONDE');
						  $c_acteur->setCode_source_create('SOURCE');
						  $c_acteur->setCode_monde_create('MONDE');
						  $c_acteur->setCode_zone_create(null);
						  $c_acteur->setId_pays(null);
						  $c_acteur->setId_region(null);
						  $c_acteur->setCode_secteur_create(null);
						  $c_acteur->setCode_agence_create(null);
						  //$c_acteur->setId_sub_secteur(null);
						  
                        } elseif($_POST["categorie_gac"] == 'pays') {
                          $c_acteur->setCode_activite('PAYS');
						  $c_acteur->setCode_source_create('SOURCE');
						  $c_acteur->setCode_monde_create('MONDE');
						  $c_acteur->setCode_zone_create($code_zone);
						  $c_acteur->setId_pays($_POST["id_pays"]);
						  $c_acteur->setId_region(null);
						  $c_acteur->setCode_secteur_create(null);
						  $c_acteur->setCode_agence_create(null);
						  //$c_acteur->setId_sub_secteur(null);
                        }
					    
                        if(($acteur !='') || ($acteur != null)) {						
                           $c_acteur->setCode_gac_chaine($acteur);
                        } else {
                           $c_acteur->setCode_gac_chaine(null);
                        }						
                        $t_acteur->insert($c_acteur->toArray());
					   
					   
					   
                       
                       //R�cup�ration de la prk nr
                       $param = new Application_Model_EuParametresMapper();
                       $par = new Application_Model_EuParametres();
                       $prc = 0;
                       $par_prc = $param->find('prc', 'nr', $par);
                       if ($par_prc == true) {
                          $prc = $par->getMontant();
                       }
					   
					   // insertion dans la table eu_tegc
                       $te_mapper = new Application_Model_EuTegcMapper();
                       $te = new Application_Model_EuTegc();
                       $code_te = 'TEGCP' .$user->id_filiere. $code.'00001';
                       $find_te = $te_mapper->find($code_te, $te);
                       if ($find_te == false) {
                            $te->setCode_tegc($code_te)
							   ->setNom_tegc(addslashes (trim ($_POST["raison_sociale"])))
								   ->setSubvention(0)
                               ->setId_filiere($user->id_filiere)
                               ->setMdv($prc)
                               ->setCode_membre($code)
                               ->setMontant(0)
							   ->setMontant_utilise(0)
							   ->setSolde_tegc(0);
                            $te_mapper->save($te);
                       } else {
                            $te->setId_filiere($user->id_filiere);
                            $te->setMdv($prc);
                            $te_mapper->update($te);
                       }
                        
                        //Initialisation du compte tegcp
                        $date_alloc = new Zend_Date(Zend_Date::ISO_8601);
                        $code_cat = 'TPAGCP';
                        $code_compte = 'NB-' . $code_cat . '-' . $code;
                        $compte_mapper = new Application_Model_EuCompteMapper();
                        $compte = new Application_Model_EuCompte();
                        $find_compte = $compte_mapper->find($code_compte,$compte);       
                    }
					
					// insertion dans la table eu_utilisateur
                    $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                    $id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
                    if(trim($user->code_groupe) == 'gacd' || trim($user->code_groupe) == 'gacdm'  || trim($user->code_groupe) == 'gacdz' || 
					   trim($user->code_groupe) == 'gacdp' ) {
					  if($_POST["categorie_gac"] == 'source'){
                         $userin->setCode_groupe('detentrice');
					     $userin->setCode_groupe_create('detentrice');
					  } elseif($_POST["categorie_gac"] == 'zone') {
                         $userin->setCode_groupe('detentrice_zone');
					     $userin->setCode_groupe_create('detentrice_zone');
                      } elseif($_POST["categorie_gac"] == 'monde') {
                         $userin->setCode_groupe('detentrice_monde');
					     $userin->setCode_groupe_create('detentrice_monde');
                      }elseif($_POST["categorie_gac"] == 'pays') {
                         $userin->setCode_groupe('detentrice_pays');
					     $userin->setCode_groupe_create('detentrice_pays');
                      }					  
                    } elseif(trim($user->code_groupe) == 'gacex' || trim($user->code_groupe) == 'gacexm' || trim($user->code_groupe) == 'gacexz' || trim($user->code_groupe) == 'gacexp') {
					  if($_POST["categorie_gac"] == 'source'){
                         $userin->setCode_groupe('executante');
					     $userin->setCode_groupe_create('executante');
					  } elseif($_POST["categorie_gac"] == 'zone') {
                         $userin->setCode_groupe('executante_zone');
					     $userin->setCode_groupe_create('executante_zone');
                      } elseif($_POST["categorie_gac"] == 'monde') {
                         $userin->setCode_groupe('executante_monde');
					     $userin->setCode_groupe_create('executante_monde');
                      }elseif($_POST["categorie_gac"] == 'pays') {
                         $userin->setCode_groupe('executante_pays');
					     $userin->setCode_groupe_create('executante_pays');
                      }
                    } elseif(trim($user->code_groupe) == 'gacs' || trim($user->code_groupe) == 'gacsm' || trim($user->code_groupe) == 'gacsz' || trim($user->code_groupe) == 'gacsp' ) {
					  if($_POST["categorie_gac"] == 'source') {
                         $userin->setCode_groupe('surveillance');
					     $userin->setCode_groupe_create('surveillance');
					  } elseif($_POST["categorie_gac"] == 'zone') {
                         $userin->setCode_groupe('surveillance_zone');
					     $userin->setCode_groupe_create('surveillance_zone');
                      } elseif($_POST["categorie_gac"] == 'monde') {
                         $userin->setCode_groupe('surveillance_monde');
					     $userin->setCode_groupe_create('surveillance_monde');
                      } elseif($_POST["categorie_gac"] == 'pays') {
                         $userin->setCode_groupe('surveillance_pays');
					     $userin->setCode_groupe_create('surveillance_pays');
                      }
                    } 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($user->id_filiere);
                    
                    $userin->setCode_acteur($code_gac);
                   
                    $userin->setCode_membre($code);
                    $userin->setId_pays($user->id_pays);            
                    $user_mapper->save($userin);
                    
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
                    
					// INSERTION DANS LA TABLE EU_CONTRAT
				    $contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-mm-dd'));
                    $contrat->setNature_contrat(null);
					if(trim($user->code_groupe) == 'gacd' || trim($user->code_groupe) == 'gacdm' || trim($user->code_groupe) == 'gacdz' || trim($user->code_groupe) == 'gacdp') {
				      $contrat->setId_type_contrat(1);
					} elseif(trim($user->code_groupe) == 'gacs' || trim($user->code_groupe) == 'gacsm' || trim($user->code_groupe) == 'gacsz' || trim($user->code_groupe) == 'gacsp') {   
					  $contrat->setId_type_contrat(2);
					} elseif(trim($user->code_groupe) == 'gacex' || trim($user->code_groupe) == 'gacexm' || trim($user->code_groupe) == 'gacexz' || trim($user->code_groupe) == 'gacexp') { 
					  $contrat->setId_type_contrat(3);
					}   
                    $contrat->setId_type_creneau(null);
                    $contrat->setId_type_acteur(null);
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
                             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
							 ->setCreditcode(null)
							 ->setOrigine_fs(null)
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMont_fs($fs);
                    $tab_fs->insert($fs_model->toArray());

                    
					// insertion dans la table eu_smsmoney  
                    /*$sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms);*/
					
					
                    $tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
                    $code_fl = 'FL-' . $code;
						
				    $fl->setCode_fl($code_fl)
                       ->setCode_membre(NULL)
					   ->setOrigine_fl(null)
                       ->setCode_membre_morale($code)
                       ->setMont_fl($mont_fl)
                       ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                       ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                       ->setId_utilisateur($user->id_utilisateur)
                       ->setCreditcode(null);   
				  
                    $tfl->insert($fl->toArray());
					
					$compte = new Application_Model_EuCompte();
                    $map_compte = new Application_Model_EuCompteMapper();
					
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
					
					for($i = 1; $i < count($tcartes); $i++) {
                       if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                         $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NR';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE" || $tcartes[$i] == "TMARGE") {
                         $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NN';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
                         $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NB';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIN") {
                         $tcartes[$i] = "TI"; 
                         $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NN';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIR") {
                         $tcartes[$i] = "TI"; 
                         $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NR';
                         $res = $map_compte->find($code_compte,$compte);
                       } elseif($tcartes[$i] == "TIB") {
                         $tcartes[$i] = "TI";
                         $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                         $type_carte = 'NB';
                         $res = $map_compte->find($code_compte,$compte);
                       }
                         if(!$res) {
                           $compte->setCode_cat($tcartes[$i])
                                  ->setCode_compte($code_compte)
                                  ->setCode_membre(NULL)
                                  ->setCode_membre_morale($code)
                                  ->setCode_type_compte($type_carte)
                                  ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
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
						
						for($j = 0; $j < count($tscartes); $j++) {
                           if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                             $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NR';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSMARGE" || $tscartes[$j] == "TSRE") {
                             $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NN';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR" || $tscartes[$j] == "TSFS") {
                             $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NB';
                             $res = $map_compte->find($code_comptets,$compte);
                           } elseif($tscartes[$j] == "TSIN") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NN';
                             $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIR") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NR';
                             $res = $map_compte->find($code_comptets,$compte);
                            } elseif($tscartes[$j] == "TSIB") {
                             $tscartes[$j] = "TSI";
                             $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                             $type_carte = 'NB';
                             $res = $map_compte->find($code_comptets,$compte);
                            }
                            if(!$res) {
                              $compte->setCode_cat($tscartes[$j])
                                     ->setCode_compte($code_comptets)
                                     ->setCode_membre(NULL)
                                     ->setCode_membre_morale($code)
                                     ->setCode_type_compte($type_carte)
                                     ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                     ->setDesactiver(0)
                                     ->setLib_compte($tscartes[$j])
                                     ->setSolde(0);
                                $map_compte->save($compte);
                            }

                        }
						
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
                        $id_demande = $carte->findConuter() + 1;
                        $carte->setId_demande($id_demande)
                              ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("NB-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
							  ->setOrigine_fkps(null)
                              ->setId_utilisateur($user->id_utilisateur);	  
                        $t_carte->insert($carte->toArray());
					
                        $compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,NULL,$code, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
                        
					
                        $compteur=Util_Utils::findConuter() + 1;
                        Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau ESMC !!! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                        $db->commit();
                        return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));
                
				//}
            } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
            }
        }

 
    }

	
	public function newpmAction() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
		$request = $this->getRequest();
		$type_gac = $request->type_gac;
		$this->view->type_gac = $type_gac;
        $code_agence = $user->code_agence;
        $fs = Util_Utils::getParametre('FS','valeur');
        $this->view->fs = $fs;
        if ($this->getRequest()->isPost()) {
           $date_id = new Zend_Date(Zend_Date::ISO_8601);
           $date_idd = clone $date_id;
           $code_sms = $_POST["code_sms"];
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
           try {
			   $frais_identification = trim($_POST["frais_identification"]);
			   $licence_mapper = new Application_Model_EuLicenceMapper();
			   $licence = new Application_Model_EuLicence();
			   $offres_mapper = new Application_Model_EuAppeloffresMapper();
			   $offres = new Application_Model_EuAppeloffres();
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
			   $cm_map = new Application_Model_EuCompteMapper();
               $_compte = new Application_Model_EuCompte();
               $c_acteur = new Application_Model_EuActeur();
			   $t_acteur = new Application_Model_DbTable_EuActeur();
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
			   $acteur = $trouvacteursur->code_acteur;
			   
               $sms = $sms_mapper->findByCreditCode($code_sms);
               if ($sms != null) {
                  $mont = $sms->getCreditAmount();
                  if($mont == $frais_identification) { 
				        if($sms->getMotif() != 'FS') {
					        $db->rollBack();
					        $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
							$this->view->type_acteur = $_POST["type_acteur"];
                            $this->view->statut_juridique = $_POST["statut_juridique"];
                            $this->view->raison = $_POST["raison_sociale"];
                            $this->view->domaine_activite = $_POST["domaine_activite"];
                            $this->view->site_web = $_POST["site_web"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            //$this->view->profession = $_POST["profession_membre"];
                            $this->view->registre = $_POST["num_registre"];
                            return;    
					    }
						 
                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == null) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
                        $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($_POST["type_acteur"]);
                        $membre->setCode_statut($_POST["statut_juridique"]);
                        $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
						$membre->setId_pays($_POST["id_pays"]);
                        $membre->setNum_registre_membre($_POST["num_registre"]);
                        $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                        $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                        $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                        $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                        $membre->setBp_membre($_POST["bp_membre"]);
                        $membre->setTel_membre($_POST["tel_membre"]);
                        $membre->setEmail_membre($_POST["email_membre"]);
                        $membre->setPortable_membre($_POST["portable_membre"]);
                        $membre->setId_utilisateur($user->id_utilisateur);
                        $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('O');
						$membre->setEtat_membre('N');
					    $membre->setId_filiere($user->id_filiere);   
                        $mapper->save($membre);
						
                        //insertion dans la table eu_operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteur,null,$code,'TFS', $frais_identification, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                          
						    // insertion dans la table eu_representation
						    $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
						    $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['code_rep'])
                               ->setTitre("Representant")
							   ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
							   ->setId_utilisateur($user->id_utilisateur)
							   ->setEtat('inside');
                            $rep_mapper->save($rep);
						 
                        // Insertion dans la table eu_compte_bancaire
                        $cpte = $_POST['cpteur'];
                        $i = 1;
                        $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                        $cb = new Application_Model_EuCompteBancaire();
                        while ($i <= $cpte) {
						    $id_compte = $cb_mapper->findConuter() + 1;
                            if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                                $cb->setId_compte($id_compte)
								   ->setCode_banque($_POST['code_banque' . $i])
                                   ->setCode_membre_morale($code)
								   ->setCode_membre(null)
                                   ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                                $cb_mapper->save($cb);
                            }
                            $i++;
                        }
                    } else {
                        $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                        $this->view->type_acteur = $_POST["type_acteur"];
                        $this->view->statut_juridique = $_POST["statut_juridique"];
                        $this->view->raison = $_POST["raison_sociale"];
                        $this->view->domaine_activite = $_POST["domaine_activite"];
                        $this->view->site_web = $_POST["site_web"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        //$this->view->profession = $_POST["profession_membre"];
                        $this->view->registre = $_POST["num_registre"];
                        return;
                    }
                } else {
                    $this->view->message = 'Le code sms [' . $code_sms . '] est invalide !!!';
                    $this->view->type_acteur = $_POST["type_acteur"];
                    $this->view->statut_juridique = $_POST["statut_juridique"];
                    $this->view->raison = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    //$this->view->profession = $_POST["profession_membre"];
                    $this->view->registre = $_POST["num_registre"];
                    return;
                }
				    $gac_mapper = new Application_Model_EuGacMapper();
		            $gac = new Application_Model_EuGac();
					$filiere =  new Application_Model_EuFiliere();
					$map_filiere = new Application_Model_EuFiliereMapper();
					$find_filiere = $map_filiere->find($user->id_filiere,$filiere);
					
                    $select = $table->select();
					$select->where('code_acteur like ?', $acteur);
					$resultSet = $table->fetchAll($select);
					$ligneacteur = $resultSet->current();
					
		            $userin = new Application_Model_EuUtilisateur();
					$user_mapper = new Application_Model_EuUtilisateurMapper();
		            $userin = new Application_Model_EuUtilisateur();
					$util = new Application_Model_DbTable_EuUtilisateur();
					$membre_mapper = new Application_Model_EuMembreMapper();
		            $membrein = new Application_Model_EuMembre();
					$select = $util->select();  
                    $select->where('eu_utilisateur.id_utilisateur = ?',$user->id_utilisateur_parent);
                    $data = $util->fetchAll($select);
					$row = $data->current();
					
					if(trim($user->code_groupe) == 'filiere')  {
					        // verification numero contrat
					        $trouveof = $offres_mapper->findoffres($_POST["numero_offre"]);
				            if($trouveof != false) {
				                $num_offre = $_POST["numero_offre"];
				                $result = $offres_mapper->find($trouveof->getId_appeloffres(),$offres);
				                $offres->setCode_membre_morale($code);
				                $offres_mapper->update($offres);
							    $count = $c_acteur->findConuter() + 1;
                                $c_acteur->setId_acteur($count)
                                        ->setCode_acteur(null)
										->setCode_division($filiere->getCode_division())
                                        ->setCode_membre($code)
                                        ->setCode_activite('filiere')
                                        ->setId_utilisateur($user->id_utilisateur)
                                        ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
										
                                if($row->code_groupe == 'mise_chainepmpbf') {
							      $c_acteur->setType_acteur('PBF');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
								}  
								else {
                                  $c_acteur->setType_acteur('DSMS');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                }
								//insertion dans la table eu_acteur
                                $c_acteur->setCode_gac_chaine($acteur);							   
                                $t_acteur->insert($c_acteur->toArray());
					   
					            //R�cup�ration de la prk nr
                                $param = new Application_Model_EuParametresMapper();
                                $par = new Application_Model_EuParametres();
                                $prc = 0;
                                $par_prc = $param->find('prc', 'nr', $par);
                                if ($par_prc == true) {
                                   $prc = $par->getMontant();
                                }
					   
					            // insertion dans la table eu_tegc
					            $te_mapper = new Application_Model_EuTegcMapper();
                                $te = new Application_Model_EuTegc();
                                $code_te = 'TEGCP' .$user->id_filiere. $code;
                                $find_te = $te_mapper->find($code_te,$te);
                                if ($find_te == false) {
                                    $te->setCode_tegc($code_te)
                                       ->setId_filiere($user->id_filiere)
                                       ->setMdv($prc)
                                       ->setCode_membre($code)
                                       ->setMontant(0)
							           ->setMontant_utilise(0)
							           ->setSolde_tegc(0);
                                    $te_mapper->save($te);
                                } else {
                                    $te->setId_filiere($user->id_filiere);
                                    $te->setMdv($prc);
                                    $te_mapper->update($te);
                                }
				            } else {
				                  $db->rollBack();
				                  $this->view->message = " Le numéro du document d'appel d'offre est invalide ou est déjà utilisé";
				                  $this->view->type_acteur = $_POST["type_acteur"];
                                  $this->view->statut_juridique = $_POST["statut_juridique"];
                                  $this->view->raison = $_POST["raison_sociale"];
                                  $this->view->domaine_activite = $_POST["domaine_activite"];
                                  $this->view->site_web = $_POST["site_web"];
                                  $this->view->quartier_membre = $_POST["quartier_membre"];
                                  $this->view->ville_membre = $_POST["ville_membre"];
                                  $this->view->bp = $_POST["bp_membre"];
                                  $this->view->tel = $_POST["tel_membre"];
                                  $this->view->email = $_POST["email_membre"];
                                  $this->view->portable = $_POST["portable_membre"];
                                  //$this->view->profession = $_POST["profession_membre"];
                                  $this->view->registre = $_POST["num_registre"];
                                  return;
				            }
					} elseif((trim($user->code_groupe) == 'scmacnev') || (trim($user->code_groupe) == 'technopole')) { 
					        // verification du numero licence
							$trouveof = $offres_mapper->findoffres($_POST["numero_offre"]);
				            if($trouveof != false) {
				                  $num_offre = $_POST["numero_offre"];
				                  $result = $offres_mapper->find($trouveof->getId_appeloffres(),$offres);
				                  $offres->setCode_membre_morale($code);
				                  $offres_mapper->update($offres);
								  $count = $c_acteur->findConuter() + 1;
                                  $c_acteur->setId_acteur($count);
                                  $c_acteur->setCode_acteur(null);
								  $c_acteur->setCode_division($filiere->getCode_division());
                                  $c_acteur->setCode_membre($code);
								  if(trim($user->code_groupe) == 'scmacnev'){
                                     $c_acteur->setCode_activite('acnev');
								  }  elseif(trim($user->code_groupe) == 'technopole') {
                                     $c_acteur->setCode_activite('technopole');
								  }	 
                                  $c_acteur->setId_utilisateur($user->id_utilisateur);
                                  $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                                  if($row->code_groupe == 'mise_chainepmpbf') {
							        $c_acteur->setType_acteur('PBF');
									$c_acteur->setCode_source_create($ligneacteur->code_source_create);
						            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						            $c_acteur->setId_pays($ligneacteur->id_pays);
						            $c_acteur->setId_region($ligneacteur->id_region);
						            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                  } 
								  elseif($row->code_groupe == 'mise_chainepmd') {
							        $c_acteur->setType_acteur('DSMS');
								    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						            $c_acteur->setId_pays($ligneacteur->id_pays);
						            $c_acteur->setId_region($ligneacteur->id_region);
						            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
								  
                                } elseif($row->code_groupe == 'mise_chainepms') {
							      $c_acteur->setType_acteur('DSMS');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($row->code_groupe == 'mise_chainepmex') {
							      $c_acteur->setType_acteur('DSMS');
								  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						          $c_acteur->setId_pays($ligneacteur->id_pays);
						          $c_acteur->setId_region($ligneacteur->id_region);
						          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                }
								else {
                                    $c_acteur->setType_acteur('DSMS');
								    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
						            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
						            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
						            $c_acteur->setId_pays($ligneacteur->id_pays);
						            $c_acteur->setId_region($ligneacteur->id_region);
						            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
						            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                }
								
								// insertion dans la table eu_acteur
                                $c_acteur->setCode_gac_chaine($acteur);								  
                                $t_acteur->insert($c_acteur->toArray());
								 
								//R�cup�ration de la prk nr
                                $param = new Application_Model_EuParametresMapper();
                                $par = new Application_Model_EuParametres();
                                $prc = 0;
                                $par_prc = $param->find('prc', 'nr', $par);
                                if ($par_prc == true) {
                                   $prc = $par->getMontant();
                                }
					             
								// insertion dans la table eu_tegc
					            $te_mapper = new Application_Model_EuTegcMapper();
                                $te = new Application_Model_EuTegc();
                                $code_te = 'TEGCP' .$user->id_filiere. $code;
                                $find_te = $te_mapper->find($code_te,$te);
                                if ($find_te == false) {
                                $te->setCode_tegc($code_te)
                                   ->setId_filiere($user->id_filiere)
                                   ->setMdv($prc)
                                   ->setCode_membre($code)
                                   ->setMontant(0)
							       ->setMontant_utilise(0)
							       ->setSolde_tegc(0);
                                $te_mapper->save($te);
                                } else {
                                  $te->setId_filiere($user->id_filiere);
                                  $te->setMdv($prc);
                                  $te_mapper->update($te);
                                }
								 
								 
				            } else {
				                    $db->rollBack();
				                    $this->view->message = " Le numéro du document d'appel d'offre est invalide ou est déjà utilisé";
				                    $this->view->type_acteur = $_POST["type_acteur"];
                                    $this->view->statut_juridique = $_POST["statut_juridique"];
                                    $this->view->raison = $_POST["raison_sociale"];
                                    $this->view->domaine_activite = $_POST["domaine_activite"];
                                    $this->view->site_web = $_POST["site_web"];
                                    $this->view->quartier_membre = $_POST["quartier_membre"];
                                    $this->view->ville_membre = $_POST["ville_membre"];
                                    $this->view->bp = $_POST["bp_membre"];
                                    $this->view->tel = $_POST["tel_membre"];
                                    $this->view->email = $_POST["email_membre"];
                                    $this->view->portable = $_POST["portable_membre"];
                                    //$this->view->profession = $_POST["profession_membre"];
                                    $this->view->registre = $_POST["num_registre"];
                                    return;
				            }
					        
					}
					
					// insertion dans la table eu_utilisateur
					$find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
					$id_user = $user_mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($user->id_utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(null);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);
					if(trim($user->code_groupe) == 'filiere') {
                      $userin->setCode_groupe('detentrice_filiere');
					  $userin->setCode_groupe_create('detentrice_filiere');
					} elseif(trim($user->code_groupe) == 'scmacnev') {
                      $userin->setCode_groupe('executante_acnev');
					  $userin->setCode_groupe_create('executante_acnev');
					} elseif(trim($user->code_groupe) == 'technopole') {
                      $userin->setCode_groupe('surveillance_technopole');
					  $userin->setCode_groupe_create('surveillance_technopole');
					} 
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(null);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($user->id_filiere);
                    if(trim($user->code_groupe) == 'gacd' || trim($user->code_groupe) == 'gacs' || trim($user->code_groupe) == 'gacex') {
                      $userin->setCode_acteur($code_gac);
                    } else {
				      $userin->setCode_acteur($acteur);
					}
					$userin->setCode_membre($code);
		            $userin->setId_pays($user->id_pays);	    	
                    $user_mapper->save($userin);
				    
					
					// Mise à jour de la table eu_contrat
					$contrat = new Application_Model_EuContrat();
				    $mapper_contrat = new Application_Model_EuContratMapper();
				    $id_contrat = $mapper_contrat->findConuter() + 1;
                    
				    $contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(null);
					if(trim($user->code_groupe) == 'filiere') {
				       $contrat->setId_type_contrat(4);
					} elseif(trim($user->code_groupe) == 'scmacnev') {   
					   $contrat->setId_type_contrat(5);
					} elseif(trim($user->code_groupe) == 'technopole') { 
					   $contrat->setId_type_contrat(6);
					}   
                    $contrat->setId_type_creneau(null);
                    $contrat->setId_type_acteur(null);
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur($user->id_utilisateur);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
					
                    //Creation du fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    $fs_model->setCode_membre_morale($code)
				             ->setCode_membre(null)
                             ->setCode_fs('FS-' . $code)
                             ->setCreditcode($sms->getCreditCode())
                             ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                             ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                             ->setId_utilisateur($user->id_utilisateur)
                             ->setMont_fs($frais_identification);
                    $tab_fs->insert($fs_model->toArray());

					// Mise à jour de la table eu_smsmoney  
                    $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                        ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                        ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                    $sms_mapper->update($sms); 
					
                    
				$compteur=Util_Utils::findConuter() + 1;
                Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                $db->commit();
                return $this->_helper->redirector('morale', 'eu-membre', null, array('controller' => 'eu-membre', 'action' => 'morale'));
                //}
            } catch (Exception $exc) {
                $db->rollback();
                $this->view->type_acteur = $_POST["type_acteur"];
                $this->view->statut_juridique = $_POST["statut_juridique"];
                $this->view->raison = $_POST["raison_sociale"];
                $this->view->domaine_activite = $_POST["domaine_activite"];
                $this->view->site_web = $_POST["site_web"];
                $this->view->quartier_membre = $_POST["quartier_membre"];
                $this->view->ville_membre = $_POST["ville_membre"];
                $this->view->bp = $_POST["bp_membre"];
                $this->view->tel = $_POST["tel_membre"];
                $this->view->email = $_POST["email_membre"];
				$this->view->id_pays = $_POST["id_pays"];
                $this->view->portable = $_POST["portable_membre"];
                $this->view->registre = $_POST["num_registre"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                return;
            }
        }
    }
	
	public function newcapsAction() {
	       // action body
           $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
           $user = $auth->getIdentity();
           $code_agence = $user->code_agence;
           $code = '';
		   try {
            $val_caps = Util_Utils::getParametre('CAPS','valeur');
			$valcaps = explode(".",$val_caps);
            $val_caps = $valcaps[0];
            if ($this->getRequest()->fs != null) {
                $val_caps = $this->getRequest()->fs;
                if ($val_caps >= $val_fs) {
                    $this->view->fs = $val_fs;
                    $code = $this->getRequest()->code;
                    $this->view->code = $code;
					$this->view->apporteur = $this->getRequest()->apporteur;
                }
            } 
			else {
                $this->view->caps = $val_caps;
            }	
			
            } catch (Exception $exc) {
                    $this->view->message = "Erreur d'exécution :" . $exc->getMessage();
                    return;
            }
			
			if ($this->getRequest()->isPost())   {
			   // if ($form->isValid($request->getPost())) {
              $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;
              $mode_reg = $_POST["reglement_membre"];
              $membre_reg = $_POST["membre_reg"];
              $code_caps = $_POST["code_caps"];
              $frais_identification = trim($_POST["frais_identification"]);
			    
              $caps = Util_Utils::getParametre('CAPS','valeur');
			  $fs = Util_Utils::getParametre('FS','valeur');
			  $mont_fl = Util_Utils::getParametre('FL','valeur');
			  $mont_cps = Util_Utils::getParametre('FKPS','valeur');
			  	  
              if ($mode_reg == 'N') {
                $code_sms = $_POST["code_sms"];
              } else {
                $code_sms = '';
              }
              $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
			  try {  
			      //traitement des numero avec ajout des zero pour obtenir les 13 chiffres
                  $m_caps = new Application_Model_EuCapsMapper();
                  $caps = new Application_Model_EuCaps();
				  $cm_map = new Application_Model_EuCompteMapper();
                  $cm = new Application_Model_EuCompte();
                  if ($mode_reg == 'N' && $code_sms != '') {
                     $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                     $sms = $sms_mapper->findByCreditCode($code_sms);
                     if ($sms == null) {
                        $db->rollback();
                        $this->view->message = 'Le code sms [' . $code_sms . ']  est  invalide !!!';
                        if ($code_caps != '') {
                           $this->view->code = $code_caps;
                        }
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
                    }
					
                    $mont = $sms->getCreditAmount();
					if($sms->getMotif() != 'CAPS') {
					    $db->rollBack();
                        $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                        if ($code_caps != '') {
                           $this->view->code = $code_caps;
                        }
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;    
					}	
					
                }   else if ($code_sms == '' && $membre_reg != '' && $mode_reg == 'CNP') {
                    $membre_map = new Application_Model_EuMembreMapper();
                    $membre = new Application_Model_EuMembre();
                    $ret_m = $membre_map->find($membre_reg,$membre);
                    if ($ret_m) {
                        if (substr($membre_reg,19,1) == 'P') {
                            $code_compte = 'NB-TPAGCRPG-' . $membre_reg;
                        } else {
                            $code_compte = 'NB-TPAGCI-' . $membre_reg;
                        }
                    } else {
                           $this->view->message = "Ce membre " . $membre_reg . " n'existe pas !!!";
                           $db->rollback();
                           if ($code_caps != '') {
                               $this->view->code = $code_caps;
                           }
                           $this->view->nom_membre = $_POST["nom_membre"];
                           $this->view->prenom_membre = $_POST["prenom_membre"];
                           $this->view->sexe = $_POST["sexe_membre"];
                           $this->view->sitfam = $_POST["sitfam_membre"];
                           $this->view->datnais = $_POST["date_nais_membre"];
                           $this->view->nation = $_POST["nationalite_membre"];
                           $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                           $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                           $this->view->formation = $_POST["formation"];
                           $this->view->profession = $_POST["profession_membre"];
                           $this->view->religion = $_POST["religion_membre"];
                           $this->view->pere = $_POST["pere_membre"];
                           $this->view->mere = $_POST["mere_membre"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           return;
                    }
					
                    $cm_map = new Application_Model_EuCompteMapper();
                    $cm = new Application_Model_EuCompte();
                    $ret = $cm_map->find($code_compte,$cm);
                    if ($ret && $cm->getSolde() >= $caps) {
                       $mont = $caps;
                    }
                } 
				elseif ($mode_reg == 'NN') {
				    $type_comptenn  =  $_POST['type_mf'];
					$apporteur  =  $_POST['membre_nn'];
					$code_compte = 'NN-' .'T'. $type_comptenn . '-' . $apporteur;
				    $compte_nn = new Application_Model_EuCompte();
				    $cm_map = new Application_Model_EuCompteMapper();
                    $result_nn = $cm_map->find($code_compte, $compte_nn);
					if ($result_nn && $compte_nn->getSolde() >= $caps) {
					    // Mise à jour des comptes crédits		 
                        $t_produit = new Application_Model_DbTable_EuCompteCredit();
                        $select = $t_produit->select();
                        $select->from($t_produit, array('sum(montant_credit) as somme'));
                        $select->where('code_membre = ?',$apporteur)
                               ->where('code_compte like ?','NN%')
                               ->where('code_produit like ?',$type_comptenn);
                        $result = $t_produit->fetchAll($select);
                        $row = $result->current();
						 
				    //if ($row['somme'] != $compte_nn->getSolde()) {
                    //$db->rollback();
                    //$this->view->message = "Integrite du compte est mise en cause";
                    //return;
                    //}
						 
                    if ($row['somme'] < $caps) {
                       $db->rollback();
                       $this->view->message = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cette operation";
					   $this->view->nom_membre = $_POST["nom_membre"];
                       $this->view->prenom_membre = $_POST["prenom_membre"];
                       $this->view->sexe = $_POST["sexe_membre"];
                       $this->view->sitfam = $_POST["sitfam_membre"];
                       $this->view->datnais = $_POST["date_nais_membre"];
                       $this->view->nation = $_POST["nationalite_membre"];
                       $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                       $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                       $this->view->formation = $_POST["formation"];
                       $this->view->profession = $_POST["profession_membre"];
                       $this->view->religion = $_POST["religion_membre"];
                       $this->view->pere = $_POST["pere_membre"];
                       $this->view->mere = $_POST["mere_membre"];
                       $this->view->quartier_membre = $_POST["quartier_membre"];
                       $this->view->ville_membre = $_POST["ville_membre"];
                       $this->view->bp = $_POST["bp_membre"];
                       $this->view->tel = $_POST["tel_membre"];
                       $this->view->email = $_POST["email_membre"];
                       $this->view->portable = $_POST["portable_membre"];
                       return;
                    }
						
					   $m_credit = new Application_Model_EuCompteCreditMapper();
				       $credits = $m_credit->findCreditByCompte($apporteur,$type_comptenn);
					    if ($credits != null) {
						  $j = 0;
                          $reste = $caps;
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
					    $compte_nn->setSolde($compte_nn->getSolde() - $caps);
                        $cm_map->update($compte_nn);
						
					} else {
						$db->rollback();
                        $this->view->message = "Votre compte ".$type_comptenn." est inexistante ou le solde de votre compte est insuffisant";
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
				   }
				}
				else {
                    $this->view->message = "Erreur d'execution: Le mode de règlement m.$mode_reg n'est pas valide !!!";
                    $db->rollback();
                    if ($code_caps != '') {
                       $this->view->code = $code_caps;
                    }
                    $this->view->nom_membre = $_POST["nom_membre"];
                    $this->view->prenom_membre = $_POST["prenom_membre"];
                    $this->view->sexe = $_POST["sexe_membre"];
                    $this->view->sitfam = $_POST["sitfam_membre"];
                    $this->view->datnais = $_POST["date_nais_membre"];
                    $this->view->nation = $_POST["nationalite_membre"];
                    $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                    $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                    $this->view->formation = $_POST["formation"];
                    $this->view->profession = $_POST["profession_membre"];
                    $this->view->religion = $_POST["religion_membre"];
                    $this->view->pere = $_POST["pere_membre"];
                    $this->view->mere = $_POST["mere_membre"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    return;
                }
                if (($code_sms != '' && $mont == $frais_identification) || ($membre_reg != '' && $mont >= $frais_identification) || $code_caps != '' || $mode_reg == 'nn') {
                    //insertion dans la table membre des informations du nouveau membre
                    $membre = new Application_Model_EuMembre();
                    $mapper = new Application_Model_EuMembreMapper();
                    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                        $code = $code_agence . '0000001' . 'P';
                    } else {
                        $num_ordre = substr($code, 12, 7);
                        $num_ordre++;
                        $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                        $code = $code_agence . $num_ordre_bis . 'P';
                    }
					
                    $date_nais = new Zend_Date($_POST["date_nais_membre"]);
                    if ($date_nais >= $date_idd) {
                        $this->view->message = "Erreur d'execution: La date de naissance doit etre antérieure à la date actuelle !!!";
                        $db->rollback();
                        if ($code_caps != '') {
                            $this->view->code = $code_caps;
                        }
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
                    }
					
					// insertion dans la table eu_membre
                    $membre->setCode_membre($code)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($_POST["nationalite_membre"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                           ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                           ->setCode_agence($user->code_agence)
						   ->setCode_gac($user->code_acteur)
                           ->setId_maison(null)
                           ->setCodesecret(md5($_POST["codesecret"]))
						   ->setEtat_membre('N')
							;
                    if (($code_caps != null && $code_caps != '') || ($mode_reg == 'CAPS')) {
                        $membre->setAuto_enroler('N');
                    } else {
                        $membre->setAuto_enroler('O');
                    }
                    $mapper->save($membre);
					
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
				
				//insertion dans la table eu_utilisateur
			    $acteur = $trouvacteursur->code_acteur;
                    $userin = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user)
                           ->setId_utilisateur_parent($user->id_utilisateur)
                           ->setPrenom_utilisateur($_POST["prenom_membre"])
                           ->setNom_utilisateur($_POST["nom_membre"])
                           ->setLogin($code)
                           ->setPwd(md5($_POST["codesecret"]))
                           ->setDescription(null)
                           ->setUlock(0)
                           ->setCh_pwd_flog(0)
                           ->setCode_groupe('personne_physique')
					       ->setCode_groupe_create('personne_physique')
                           ->setConnecte(0)
                           ->setCode_agence($user->code_agence)
                           ->setCode_secteur(null)
                           ->setCode_zone($user->code_zone)
                           //->setCode_gac_filiere(null)
		                   ->setId_pays($user->id_pays)	    	
                           ->setCode_acteur($acteur)
					       ->setCode_membre($code);    
                    $mapper->save($userin);
					
				
				// Mise à jour de la table eu_contrat
                $contrat = new Application_Model_EuContrat();
		        $mapper_contrat = new Application_Model_EuContratMapper();
		        $id_contrat = $mapper->findConuter() + 1;
				$contrat->setId_contrat($id_contrat);
                $contrat->setCode_membre($code);
                $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd'));
                $contrat->setNature_contrat('numerique');
                $contrat->setId_type_contrat(null);
                $contrat->setId_type_creneau(null);
                $contrat->setId_type_acteur(null);
                $contrat->setId_pays(null);
                $contrat->setId_utilisateur($user->id_utilisateur);
                $contrat->setFiliere(null);
                $mapper_contrat->save($contrat);
				
				
				// insertion dans la table eu_compte_bancaire
                $cpte = $_POST['cpteur'];
                $i = 1;
                $cb_mapper = new Application_Model_EuCompteBancaireMapper();
			    $id_compte = $cb_mapper->findConuter() + 1;
                $cb = new Application_Model_EuCompteBancaire();
                while ($i <= $cpte) {
					$id_compte = $cb_mapper->findConuter() + 1;
                    if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                        $cb->setId_compte($id_compte)
						   ->setCode_banque($_POST['code_banque' . $i])
                           ->setCode_membre($code)
						   ->setCode_membre_morale(null)
                           ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                        $cb_mapper->save($cb);
                      }
                      $i++;
                    }

                    //Mise à jour du bnp caps
                    if (($code_caps != null && $code_caps != '') || $mode_reg == 'CAPS') {
                        if ($rep) {
                           $caps->setCode_membre_benef($code)
                                ->setFs_utiliser(1);
                           $m_caps->update($caps);
						   
						   //insertion des frais d'identification dans la table operation
                           $mapper_op = new Application_Model_EuOperationMapper();
                           $compteur = $mapper_op->findConuter() + 1;
						   $lib_op = 'Enrôlement';
                           $type_op = 'ERL';
						   Util_Utils::addOperation($compteur,$code,null,'TFS',$fs,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_id->toString('HH:mm:ss'), $user->id_utilisateur);
                        
                        }
                    } else if($mode_reg == 'N') {
					   
                        //insertion des frais d'identification dans la table operation
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteurfs = $mapper_op->findConuter() + 1;
                        $lib_op = 'Auto-enrolement';
                        $type_op = 'AERL';
                        Util_Utils::addOperation($compteurfs,$code,null,'TFS',$fs,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_id->toString('HH:mm:ss'), $user->id_utilisateur);
                        //Util_Utils::createCompte('nb-tpagcrpg-' . $code, 'tpagcrpg', 'tpagcrpg', 0, $code, 'nb', $date_id, 0);
                    } 
					
					// insertion dans la table eu_fs
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
					$tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
                    $code_fl = 'FL-' . $code;
                    if ($code_sms != '' && $sms != null) {
                       $fs_model->setCode_membre($code)
						         ->setCode_membre_morale(null)
                                 ->setCode_fs('FS-' . $code)
                                 ->setCreditcode($sms->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                 ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                 ->setId_utilisateur($user->id_utilisateur)
                                 ->setMont_fs($fs);
                       $tab_fs->insert($fs_model->toArray());
						
					   $fl->setCode_fl($code_fl)
                          ->setCode_membre($code)
						  ->setCode_membre_morale(null)
                          ->setMont_fl($mont_fl)
                          ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                          ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                          ->setId_utilisateur($user->id_utilisateur)
                          ->setCreditcode($sms->getCreditCode());
                        $tfl->insert($fl->toArray());
						
						//Mise e jour du compte general fgfl
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                           $cg_fgfn->setCode_compte('FL')
                                   ->setIntitule('Frais de licence')
                                   ->setService('E')
                                   ->setCode_type_compte('NN')
                                   ->setSolde($mont_sms);
                           $cg_mapper->save($cg_fgfn);
                        }
	
						$compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,$code,null, null, $mont_fl, null, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
						$tcartes = array();
			            $tscartes = array();
						$compte = new Application_Model_EuCompte();
                        $map_compte = new Application_Model_EuCompteMapper();
						
						
						
						
						/*
						$compte->setCode_cat($code_caps)
                               ->setCode_compte($code_comptecaps)
                               ->setCode_membre($code)
							   ->setCode_membre_morale(null)
                               ->setCode_type_compte('nn')
                               ->setDate_alloc($date_idd->toString('yyyy-mm-dd'))
                               ->setDesactiver(0)
                               ->setLib_compte($code_caps)
                               ->setSolde(0);
					    $map_compte->save($compte); */
						
						// insertion dans la table eu_compte
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
                                    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
									$type_carte = 'NR';
									$res = $map_compte->find($code_compte,$compte);
								} elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NN';
									$res = $map_compte->find($code_compte,$compte);
								} else  {
								    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
								    $type_carte = 'NB';
									$res = $map_compte->find($code_compte,$compte);
							    }
										
								if(!$res) {
                                  $compte->setCode_cat($tcartes[$i])
                                         ->setCode_compte($code_compte)
                                         ->setCode_membre($code)
										 ->setCode_membre_morale(null)
                                         ->setCode_type_compte($type_carte)
                                         ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                         ->setDesactiver(0)
                                         ->setLib_compte($tcartes[$i])
                                         ->setSolde(0);
									$map_compte->save($compte);
									
								}
									
                            }
							
							
							for($j = 0; $j < count($tscartes); $j++) {
							
							    if($tscartes[$j] == "TSCNCS") {
                                    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
								    $type_carte = 'NR';
								    $res = $map_compte->find($code_comptets,$compte);
								} elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
									$type_carte = 'NN';
									$res = $map_compte->find($code_comptets,$compte);
								} else {
								    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
									$type_carte = 'NB';
								    $res = $map_compte->find($code_comptets,$compte);
								}
										
								if(!$res) {
                                    $compte->setCode_cat($tscartes[$j])
                                           ->setCode_compte($code_comptets)
                                           ->setCode_membre($code)
										   ->setCode_membre_morale(null)
                                           ->setCode_type_compte($type_carte)
                                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                           ->setDesactiver(0)
                                           ->setLib_compte($tscartes[$j])
                                           ->setSolde(0);
									$map_compte->save($compte);
									
							    }
							}
							
						// insertion dans la table eu_carte	
						$carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
						$id_demande = $carte->findConuter() + 1;
						$carte->setId_demande($id_demande)
							  ->setCode_cat(null)
                              ->setCode_membre($code)
                              ->setMont_carte($mont_cps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte(null)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur($user->id_utilisateur);
                        $t_carte->insert($carte->toArray()); 
						$compteurcps = $mapper_op->findConuter() + 1; 
						Util_Utils::addOperation($compteurcps, $code,null, null, $mont_cps, null, 'Frais de CPS', 'CPS', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                        
						// Mise à jour de la table eu_smsmoney
						$sms->setDestAccount_Consumed('CAPS-'.$code)
                            ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms);
						
						
						// insertion dans eu_acteur
						$acteur = $user->code_acteur;
						$t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
						
						$t_cmfh = new Application_Model_DbTable_EuCmfh();
                        $c_cmfh = new Application_Model_EuCmfh();
						
                        $count = $c_acteur->findConuter() + 1;
						$countcmfh = $c_cmfh->findConuter() + 1;
						$table = new Application_Model_DbTable_EuActeur();
						
						if(isset($_POST["actcmfh"])) {
                           $select = $table->select();
				           $select->where('code_acteur like ?', $acteur);
				           $resultSet = $table->fetchAll($select);
				           $ligneacteur = $resultSet->current();
                           $c_cmfh->setId_acteur($countcmfh);
                  
                           $c_cmfh->setCode_membre($code);
                           $c_cmfh->setId_utilisateur($user->id_utilisateur);
                           $c_cmfh->setDate_creation($date_idd->toString('yyyy-mm-dd'));
				           $c_cmfh->setCode_activite(null);
				           $c_cmfh->setCode_source_create($ligneacteur->code_source_create);
				           $c_cmfh->setCode_monde_create($ligneacteur->code_monde_create);
				           $c_cmfh->setCode_zone_create($ligneacteur->code_zone_create);
				           $c_cmfh->setId_pays($ligneacteur->id_pays);
				           $c_cmfh->setId_region($ligneacteur->id_region);
				           $c_cmfh->setCode_secteur_create($ligneacteur->code_secteur_create);
				           $c_cmfh->setCode_agence_create($ligneacteur->code_agence_create);				  
                           $c_cmfh->setType_acteur('CMFH');
				           $c_cmfh->setCode_gac_chaine($acteur);         
                           $t_cmfh->insert($c_cmfh->toArray());
				        } else if(isset($_POST["actenro"])) {	 
				          $select = $table->select();
				          $select->where('code_acteur like ?', $acteur);
				          $resultSet = $table->fetchAll($select);
				          $ligneacteur = $resultSet->current();
                          $c_acteur->setId_acteur($count);
                          $c_acteur->setCode_acteur(null);
				          $c_acteur->setCode_division(null);
                          $c_acteur->setCode_membre($code);
                          $c_acteur->setId_utilisateur($user->id_utilisateur);
                          $c_acteur->setDate_creation($date_idd->toString('yyyy-mm-dd'));
				          $c_acteur->setCode_activite(null);
				          $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				          $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				          $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
				          $c_acteur->setId_pays($ligneacteur->id_pays);
			              $c_acteur->setId_region($ligneacteur->id_region);
				          $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
				          $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
				          $c_acteur->setType_acteur('DSMS');
				          $c_acteur->setCode_gac_chaine($acteur);         
                          $t_acteur->insert($c_acteur->toArray());	  
			            }
								 	    
                    } 
                    $compteur=Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP!!! Votre numero de membre est: " . $code . ". Votre Code Secret est: ".$_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('index');
					} else {
                    $db->rollback();
                    $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                    $this->view->nom_membre = $_POST["nom_membre"];
                    $this->view->prenom_membre = $_POST["prenom_membre"];
                    if ($code_caps != '') {
                       $this->view->code = $code_caps;
                    }
                    $this->view->sexe = $_POST["sexe_membre"];
                    $this->view->sitfam = $_POST["sitfam_membre"];
                    $this->view->datnais = $_POST["date_nais_membre"];
                    $this->view->nation = $_POST["nationalite_membre"];
                    $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                    $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                    $this->view->formation = $_POST["formation"];
                    $this->view->profession = $_POST["profession_membre"];
                    $this->view->religion = $_POST["religion_membre"];
                    $this->view->pere = $_POST["pere_membre"];
                    $this->view->mere = $_POST["mere_membre"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    return;
                }	   
				   
		    }   catch (Exception $exc) {
                $db->rollback();
                $this->view->nom_membre = $_POST["nom_membre"];
                if ($code_caps != '') {
                   $this->view->code = $code_caps;
                }
                $this->view->prenom_membre = $_POST["prenom_membre"];
                $this->view->sexe = $_POST["sexe_membre"];
                $this->view->sitfam = $_POST["sitfam_membre"];
                $this->view->datnais = $_POST["date_nais_membre"];
                $this->view->nation = $_POST["nationalite_membre"];
                $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                $this->view->formation = $_POST["formation"];
                $this->view->profession = $_POST["profession_membre"];
                $this->view->religion = $_POST["religion_membre"];
                $this->view->pere = $_POST["pere_membre"];
                $this->view->mere = $_POST["mere_membre"];
                $this->view->quartier_membre = $_POST["quartier_membre"];
                $this->view->ville_membre = $_POST["ville_membre"];
                $this->view->bp = $_POST["bp_membre"];
                $this->view->tel = $_POST["tel_membre"];
                $this->view->email = $_POST["email_membre"];
                $this->view->portable = $_POST["portable_membre"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
            }
		}
	}
	
	
	/*
	public function newmfAction() {
	    // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_agence = $user->code_agence;
	    try {
            $val_fs = Util_Utils::getParametre('fs', 'valeur');
			$this->view->fs = $val_fs;
		} catch (Exception $exc) {
            $this->view->message = "Erreur d'exécution :" . $exc->getMessage();
            return;
        }
		
		if ($this->getRequest()->isPost())   { 
		    // if ($form->isValid($request->getPost())) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
			$frais_identification = trim($_POST["frais_identification"]);
			$apporteur = $_POST['code_membre'];
		    $mode_fin = $_POST['mode_fin'];
		    $type_mf = $_POST['reglement_membre'];
			$ancienmembre = new Application_Model_EuAncienMembre();
		    $ancienmembre_map = new Application_Model_EuAncienMembreMapper();
			$anciencompte_nn = new Application_Model_EuAncienCompte();
		    $anciencm_map = new Application_Model_EuAncienCompteMapper();
			$rep = new Application_Model_EuRepartitionMf11000();
			$m_rep = new Application_Model_EuRepartitionMf11000Mapper();
			$db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
		        if ($mode_fin == 'bon') {
				   $num_bon = $_POST['num_bon'];
				   $montant = $frais_identification;
				   $code_compte = 'nn-tr-'.$num_bon;
                   $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
				   if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
				   
				      // Mise à jour de la table eu_repartition_mf11000		 
                             $t_repartition = new Application_Model_DbTable_EuRepartitionMf11000();
                             $select = $t_repartition->select();
                             $select->from($t_repartition,array('sum(solde_rep) as somme'));
                             $select->where('CODE_MF11000 = ?',$num_bon);
                             $result = $t_repartition->fetchAll($select);
                             $row = $result->current();
							 if ($row['somme'] < $frais_identification) {
                                $db->rollback();
								$this->view->prenom_membre = $_POST["prenom_membre"];
                                $this->view->sexe = $_POST["sexe_membre"];
                                $this->view->sitfam = $_POST["sitfam_membre"];
                                $this->view->datnais = $_POST["date_nais_membre"];
                                $this->view->nation = $_POST["nationalite_membre"];
                                $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                                $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                                $this->view->formation = $_POST["formation"];
                                $this->view->profession = $_POST["profession_membre"];
                                $this->view->religion = $_POST["religion_membre"];
                                $this->view->pere = $_POST["pere_membre"];
                                $this->view->mere = $_POST["mere_membre"];
                                $this->view->quartier_membre = $_POST["quartier_membre"];
                                $this->view->ville_membre = $_POST["ville_membre"];
                                $this->view->bp = $_POST["bp_membre"];
                                $this->view->tel = $_POST["tel_membre"];
                                $this->view->email = $_POST["email_membre"];
                                $this->view->portable = $_POST["portable_membre"];
                                $this->view->message = "Votre crédit de " . $row['somme'] . " est insuffisant pour effectuer cette operation";
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
							 if($mf->getNb_repartition() != 32) {
							   for ($i = 1; $i <= 26; $i++)  {
								   $id_rep = $m_repmf11000->findConuter() + 1;
								   $repmf11000->setId_rep($id_rep);
								   $repmf11000->setId_mf11000($num_bon);
                                   $repmf11000->setCode_mf11000($num_bon);
                                   $repmf11000->setCode_membre($mf->getCode_membre());
                                   $repmf11000->setDate_rep(Util_Utils::toDate($date_deb));
                                   $repmf11000->setMont_rep($mf->getSolde());
                                   $repmf11000->setMont_reglt(0);
                                   $repmf11000->setSolde_rep($mf->getSolde());
                                   $repmf11000->setId_utilisateur($user->id_utilisateur);
                                   $repmf11000->setPayer(0);
                                   $m_repmf11000->save($repmf11000);
								   //Création ou mise à jour du compte nn de transfert du MF11000
					               $anciencompte_nn->setSolde($anciencompte_nn->getSolde() + $mf->getSolde());
                                   $anciencm_map->update($anciencompte_nn);	           
								 }
								   //Mise à jour de la table eu_membre_fondateur11000
                                   $query = "update EU_MEMBRE_FONDATEUR11000 set nb_repartition =(nb_repartition + 26) where num_bon ='$num_bon'";
                                   $db->query($query);
							   }
							 
							 
							 /*if($mf->getNb_repartition() == 32) {
							     $db->rollback();
								 $this->view->prenom_membre = $_POST["prenom_membre"];
                                 $this->view->sexe = $_POST["sexe_membre"];
                                 $this->view->sitfam = $_POST["sitfam_membre"];
                                 $this->view->datnais = $_POST["date_nais_membre"];
                                 $this->view->nation = $_POST["nationalite_membre"];
                                 $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                                 $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                                 $this->view->formation = $_POST["formation"];
                                 $this->view->profession = $_POST["profession_membre"];
                                 $this->view->religion = $_POST["religion_membre"];
                                 $this->view->pere = $_POST["pere_membre"];
                                 $this->view->mere = $_POST["mere_membre"];
                                 $this->view->quartier_membre = $_POST["quartier_membre"];
                                 $this->view->ville_membre = $_POST["ville_membre"];
                                 $this->view->bp = $_POST["bp_membre"];
                                 $this->view->tel = $_POST["tel_membre"];
                                 $this->view->email = $_POST["email_membre"];
                                 $this->view->portable = $_POST["portable_membre"];
                                 $this->view->message = "Ce compte est destiné à faire du caps";
                                 return;
							  }
							  
							  if ($mfcredits != null) {
					              $j = 0;
                                  $reste = $frais_identification;
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
					               $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $frais_identification);
                                   $anciencm_map->update($anciencompte_nn);
				   
				   } else {
				          $db->rollback();
                          $this->view->message ="Votre compte ".$type_mf." est inexistante ou insuffisant";
                          $this->view->prenom_membre = $_POST["prenom_membre"];
                          $this->view->sexe = $_POST["sexe_membre"];
                          $this->view->sitfam = $_POST["sitfam_membre"];
                          $this->view->datnais = $_POST["date_nais_membre"];
                          $this->view->nation = $_POST["nationalite_membre"];
                          $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                          $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                          $this->view->formation = $_POST["formation"];
                          $this->view->profession = $_POST["profession_membre"];
                          $this->view->religion = $_POST["religion_membre"];
                          $this->view->pere = $_POST["pere_membre"];
                          $this->view->mere = $_POST["mere_membre"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          return;      
				          
				   }
				
				
				
				} else {
				
				        if($type_mf == 'MF11000') {
						   $montant = $frais_identification;
						   $code_compte = " ";
						   $code_compte = 'nn-tr-'.$apporteur;
						   $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn);
						   if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
						       //Mise à jour du compte principal
					           $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                               $anciencm_map->update($anciencompte_nn);
						
				           } else {
						      $db->rollback();
                              $this->view->message ="Votre compte ".$type_mf." est inexistante ou insuffisant";
                              $this->view->prenom_membre = $_POST["prenom_membre"];
                              $this->view->sexe = $_POST["sexe_membre"];
                              $this->view->sitfam = $_POST["sitfam_membre"];
                              $this->view->datnais = $_POST["date_nais_membre"];
                              $this->view->nation = $_POST["nationalite_membre"];
                              $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                              $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                              $this->view->formation = $_POST["formation"];
                              $this->view->profession = $_POST["profession_membre"];
                              $this->view->religion = $_POST["religion_membre"];
                              $this->view->pere = $_POST["pere_membre"];
                              $this->view->mere = $_POST["mere_membre"];
                              $this->view->quartier_membre = $_POST["quartier_membre"];
                              $this->view->ville_membre = $_POST["ville_membre"];
                              $this->view->bp = $_POST["bp_membre"];
                              $this->view->tel = $_POST["tel_membre"];
                              $this->view->email = $_POST["email_membre"];
                              $this->view->portable = $_POST["portable_membre"];
                              return;
						   
						   }
				
				
				        } else {
						    $rep = new Application_Model_EuRepartitionMf107();
				            $m_rep = new Application_Model_EuRepartitionMf107Mapper();
						    $dmf = new Application_Model_EuDetailMf11000();
							$mdmf = new Application_Model_EuDetailMf107Mapper();
							$mf107 = new Application_Model_EuMembreFondateur107();
							$mmf107 = new Application_Model_EuMembreFondateur107Mapper();
							$montant = $frais_identification;
							$nb_dmf = 0;
							$code_compteancien = 'nn-tr-'.$apporteur;
							
							$dbase = Zend_Db_Table::getDefaultAdapter();
                            $dbase->setFetchMode(Zend_Db::fetch_obj);
							$select ="select count(id_rep) as nb from EU_REPARTITION_MF107 where code_membre like '$apporteur' ";
							$donnees = $db->fetchAll($select);
							
                            foreach ($donnees as $row) {
                              $nb = $row->nb;
                            }
							   
							$ok = false;
							if($nb == 0)  {
						      $findmf = $mdmf->fetchAllByMf();
							  $nb_dmf = count($findmf); 
							  for ($j = 0;$j < $nb_dmf;$j++) {  
							      $mont = 0;
                                  $montant_recu = 0;
                                  $res_mf = $findmf[$j];
								  $mont = ($res_mf->getMont_apport() * $res_mf->getPourcentage()) / 100;
                                  $montant_recu = $res_mf->getMont_apport() - $mont;
								      
								  $code_apporteur = $res_mf->getCode_membre();
								  $findmf107 = $mmf107->find($res_mf->getNumident(),$mf107);
								  $code_proprio = $mf107->getCode_membre(); 
								  
								  if((trim($apporteur) ==  trim($code_apporteur)) || (trim($apporteur) ==  trim($code_proprio)))  {
								  
		                    $ok = true;
							for ($i=1;$i<=32;$i++)  {
							    if ($montant_recu > 0) {
								    $id_rep = $m_rep->findConuter() + 1;
									$rep->setId_rep($id_rep);
                                    $rep->setId_mf107($res_mf->getId_mf107());
                                    $rep->setCode_membre($code_apporteur);
                                    $rep->setDate_rep(Util_Utils::toDate($date));
                                    $rep->setMont_rep($montant_recu);
                                    $rep->setId_utilisateur($user->id_utilisateur);
                                    $rep->setMont_reglt(0);
					                $rep->setSolde_rep($montant_recu);
                                    $rep->setPayer(0);
                                    $m_rep->save($rep);
									   
								    //Création ou mise à jour du compte nn de transfert de l'apporteur 
                                    $code_compte = 'nn-tr-' . $code_apporteur;
                                    $ret_req = $anciencm_map->find($code_compte, $anciencompte_nn);
									
									if ($ret_req == false) { 
                                       $anciencompte_nn->setCode_cat('tr')
                                                       ->setCode_membre($code_apporteur)
                                                       ->setCode_compte($code_compte)
                                                       ->setCode_type_compte('nn')
                                                       ->setDate_alloc(Util_Utils::toDate($date))
                                                       ->setDesactiver(0)
                                                       ->setLib_compte('Compte de recharge')
                                                       ->setSolde($montant_recu);			   
                                       $anciencm_map->save($anciencompte_nn);
                                     } else {
                                        $anciencompte_nn->setSolde($anciencompte_nn->getSolde() + $montant_recu);
                                        $anciencm_map->update($anciencompte_nn);
                                     }
								
								}
								
								if ($mont > 0) {
								     $id_rep = $m_rep->findConuter() + 1;
											  $rep->setId_rep($id_rep);
                                              $rep->setId_mf107($res_mf->getId_mf107());
                                              $rep->setCode_membre($code_proprio);
                                              $rep->setDate_rep(Util_Utils::toDate($date));
                                              $rep->setMont_rep($mont);
                                              $rep->setId_utilisateur($user->id_utilisateur);
                                              $rep->setMont_reglt(0);
					                          $rep->setSolde_rep($mont);
                                              $rep->setPayer(0);
                                              $m_rep->save($rep);
									   
									          //Création ou mise à jour du compte nn de transfert du propriétaire du compte MF107
                                              $code_compte = 'nn-tr-' . $code_proprio;
                                              $ret_req = $anciencm_map->find($code_compte,$anciencompte_nn);
                                              if ($ret_req == false) {
                                              $anciencompte_nn->setCode_cat('tr')
                                                              ->setCode_membre($code_proprio)
                                                              ->setCode_compte($code_compte)
                                                              ->setCode_type_compte('nn')
                                                              ->setDate_alloc(Util_Utils::toDate($date))
                                                              ->setDesactiver(0)
                                                              ->setLib_compte('Compte de recharge')
                                                              ->setSolde($mont);
                                                 $anciencm_map->save($anciencompte_nn);
                                               } else {
                                                 $anciencompte_nn->setSolde($anciencompte_nn->getSolde() + $mont);
                                                 $anciencm_map->update($anciencompte_nn);
                                               }
								 
								       }
								
							       }
								  
		                         }
							   
							  }
							  
							  if($ok == true) {
							         $mfcredits = $m_rep->fetchRepByMembre($apporteur);
								     //enregistrement de l'operation
                                     $place = new Application_Model_EuOperation();
						             $mapper = new Application_Model_EuOperationMapper();
                                     $count = $mapper->findConuter() + 1;
                                     $date_fin = new Zend_Date(Zend_Date::ISO_8601);
                                     $date_deb = clone $date_fin;
					
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
                                            $m_rep->update($mfcredit);			 							   
						                } else {
							                //Mise à jour du compte crédit mf11000
                                            $mfcredit->setSolde_rep($mfcredit->getSolde_rep() - $reste);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $reste);
                                            $m_rep->update($mfcredit);
						                    $reste = 0;
						                }
							            $j++;
						                }
						 
				                   }
								   
					               //Mise à jour du compte principal
								   $ret_req = $anciencm_map->find($code_compteancien,$anciencompte_nn);           
                                   $anciencompte_nn->setSolde($anciencompte_nn->getSolde() - $montant);
                                   $anciencm_map->update($anciencompte_nn);
							  
							  
							  } else {
							      $code_compte = 'nn-tr-'.$apporteur;
                                  $result_nn = $anciencm_map->find($code_compte,$anciencompte_nn); 
						          if ($result_nn && $anciencompte_nn->getSolde() >= $montant) {
							         $mfcredits = $m_rep->fetchRepByMembre($ancienm->getAncien_code_membre());
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
						                    //Mise à jour du compte crédit mf11000
                                            $reste = $reste - $mfcredit->getSolde_rep();
                                            $mfcredit->setSolde_rep(0);
											$mfcredit->setMont_reglt($mfcredit->getMont_reglt() + $mfcredit->getSolde_rep());
											$mfcredit->setPayer(1);
                                            $m_rep->update($mfcredit);			 							   
						                } else {
							                //Mise à jour du compte crédit mf11000
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
							      $this->view->message = "Votre compte ".$type_mf." est inexistante ou insuffisant !!!";
                                  $db->rollback();
                                  $this->view->nom_membre = $_POST["nom_membre"];
                                  $this->view->prenom_membre = $_POST["prenom_membre"];
                                  $this->view->sexe = $_POST["sexe_membre"];
                                  $this->view->sitfam = $_POST["sitfam_membre"];
                                  $this->view->datnais = $_POST["date_nais_membre"];
                                  $this->view->nation = $_POST["nationalite_membre"];
                                  $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                                  $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                                  $this->view->formation = $_POST["formation"];
                                  $this->view->profession = $_POST["profession_membre"];
                                  $this->view->religion = $_POST["religion_membre"];
                                  $this->view->pere = $_POST["pere_membre"];
                                  $this->view->mere = $_POST["mere_membre"];
                                  $this->view->quartier_membre = $_POST["quartier_membre"];
                                  $this->view->ville_membre = $_POST["ville_membre"];
                                  $this->view->bp = $_POST["bp_membre"];
                                  $this->view->tel = $_POST["tel_membre"];
                                  $this->view->email = $_POST["email_membre"];
                                  $this->view->portable = $_POST["portable_membre"];
                                  return;
							  
							  
							  }
							       
						    }
						
						} 
				    }
				
			     }	
			  
			   //insertion dans la table membre des informations du nouveau membre
               $membre = new Application_Model_EuMembre();
               $mapper = new Application_Model_EuMembreMapper();
               $code = $mapper->getLastCodeMembreByAgence($code_agence);
               if ($code == null) {
                 $code = $code_agence . '0000001' . 'p';
               } else {
                 $num_ordre = substr($code, 12, 7);
                 $num_ordre++;
                 $num_ordre_bis = str_pad($num_ordre, 7, 0, str_pad_left);
                 $code = $code_agence . $num_ordre_bis . 'p';
               }	
               $date_nais = new Zend_Date($_POST["date_nais_membre"]);
			   
			   
			   if ($date_nais >= $date_idd) {
                        $this->view->message = "Erreur d'execution: La date de naissance doit etre antérieure à la date actuelle !!!";
                        $db->rollback();
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
                    }
                    $membre->setCode_membre($code)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-mm-dd'))
                           ->setId_pays($_POST["nationalite_membre"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setHeure_identification($date_idd->toString('hh:mm:ss'))
                           ->setDate_identification($date_id->toString('yyyy-mm-dd'))
                           ->setCode_agence($user->code_agence)
                           ->setId_maison(null)
                           ->setCodesecret(md5($_POST["codesecret"]))
						   ->setEtat_membre('n')
							;
                        $membre->setAuto_enroler('o');
                        $mapper->save($membre);
  
                    $userin = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user)
                           ->setId_utilisateur_parent($user->id_utilisateur)
                           ->setPrenom_utilisateur($_POST["prenom_membre"])
                           ->setNom_utilisateur($_POST["nom_membre"])
                           ->setLogin($code)
                           ->setPwd(md5($_POST["codesecret"]))
                           ->setDescription(null)
                           ->setUlock(0)
                           ->setCh_pwd_flog(0)
                           ->setCode_groupe('personne_physique')
					       ->setCode_groupe_create('personne_physique')
                           ->setConnecte(0)
                           ->setCode_agence($user->code_agence)
                           ->setCode_secteur(null)
                           ->setCode_zone($user->code_zone)
                           //->setCode_gac_filiere(null)
		                   ->setId_pays($user->id_pays)	    	
                           ->setCode_acteur($user->code_acteur)
					       ->setCode_membre($code);    
                    $mapper->save($userin);
					
				
				// Mise à jour de la table eu_contrat
                $contrat = new Application_Model_EuContrat();
		        $mapper_contrat = new Application_Model_EuContratMapper();
		        $id_contrat = $mapper->findConuter() + 1;
				$contrat->setId_contrat($id_contrat);
                $contrat->setCode_membre($code);
                $contrat->setDate_contrat($date_id->toString('yyyy-mm-dd'));
                $contrat->setNature_contrat('numerique');
                $contrat->setId_type_contrat(null);
                $contrat->setId_type_creneau(null);
                $contrat->setId_type_acteur(null);
                $contrat->setId_pays(null);
                $contrat->setId_utilisateur($user->id_utilisateur);
                $contrat->setFiliere(null);
                $mapper_contrat->save($contrat);
				
                $cpte = $_POST['cpteur'];
                $i = 1;
                $cb_mapper = new Application_Model_EuCompteBancaireMapper();
			    $id_compte = $cb_mapper->findConuter() + 1;
                $cb = new Application_Model_EuCompteBancaire();
                while ($i <= $cpte) {
					$id_compte = $cb_mapper->findConuter() + 1;
                    if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                        $cb->setId_compte($id_compte)
						   ->setCode_banque($_POST['code_banque' . $i])
                           ->setCode_membre($code)
						   ->setCode_membre_morale(null)
                           ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                        $cb_mapper->save($cb);
                      }
                      $i++;
                }
				
				$tab_fs = new Application_Model_DbTable_EuFs();
                $fs_model = new Application_Model_EuFs();
                $fs_model->setCode_membre($code)
						 ->setCode_membre_morale(null)
                         ->setCode_fs('fs-' . $code)
                         ->setCreditcode($type_mf.'-'.$apporteur)
                         ->setDate_fs($date_idd->toString('yyyy-mm-dd'))
                         ->setHeure_fs($date_idd->toString('hh:mm:ss'))
                         ->setId_utilisateur($user->id_utilisateur)
                         ->setMont_fs($frais_identification);
                $tab_fs->insert($fs_model->toArray());
				
			   
                //insertion des frais d'identification dans la table operation
                $mapper_op = new Application_Model_EuOperationMapper();
                $compteur = $mapper_op->findConuter() + 1;
				$lib_op = 'Auto-enrolement';
                $type_op = 'erl';
			    Util_Utils::addOperation($compteur,$code,null,'tfs',$frais_identification,'fs',$lib_op,$type_op,$date_idd->toString('yyyy-mm-dd'), $date_id->toString('hh:mm:ss'), $user->id_utilisateur);
				
				
				if(isset($_POST["actcmfh"])) {
                  $select = $table->select();
				  $select->where('code_acteur like ?', $acteur);
				  $resultSet = $table->fetchAll($select);
				  $ligneacteur = $resultSet->current();
                  $c_acteur->setId_acteur($count);
                  $c_acteur->setCode_acteur(null);
				  $c_acteur->setCode_division(null);
                  $c_acteur->setCode_membre($code);
                  $c_acteur->setId_utilisateur($user->id_utilisateur);
                  $c_acteur->setDate_creation($date_idd->toString('yyyy-mm-dd'));
				  $c_acteur->setCode_activite(null);
				  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				  $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				  $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
				  $c_acteur->setId_pays($ligneacteur->id_pays);
				  $c_acteur->setId_region($ligneacteur->id_region);
				  $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
				  $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);			
                  $c_acteur->setType_acteur('cmfh');
				  $c_acteur->setCode_gac_chaine($acteur);         
                  $t_acteur->insert($c_acteur->toArray());
				} else if(isset($_POST["actenro"])) {	 
				  $select = $table->select();
				  $select->where('code_acteur like ?', $acteur);
				  $resultSet = $table->fetchAll($select);
				  $ligneacteur = $resultSet->current();
                  $c_acteur->setId_acteur($count);
                  $c_acteur->setCode_acteur(null);
				  $c_acteur->setCode_division(null);
                  $c_acteur->setCode_membre($code);
                  $c_acteur->setId_utilisateur($user->id_utilisateur);
                  $c_acteur->setDate_creation($date_idd->toString('yyyy-mm-dd'));
				  $c_acteur->setCode_activite(null);
				  $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				  $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
				  $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
				  $c_acteur->setId_pays($ligneacteur->id_pays);
			      $c_acteur->setId_region($ligneacteur->id_region);
				  $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
				  $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
				  $c_acteur->setType_acteur('dsms');
				  $c_acteur->setCode_gac_chaine($acteur);         
                  $t_acteur->insert($c_acteur->toArray());	  
			   }
				
			   $compteur=Util_Utils::findConuter() + 1;
               Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau mcnp! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
               $db->commit();
               return $this->_helper->redirector('index');		  		
		    } 
			catch (Exception $exc) {
                  $db->rollback();
                  $this->view->nom_membre = $_POST["nom_membre"];
                  if ($code_caps != '') {
                     $this->view->code = $code_caps;
                  }
                  $this->view->prenom_membre = $_POST["prenom_membre"];
                  $this->view->sexe = $_POST["sexe_membre"];
                  $this->view->sitfam = $_POST["sitfam_membre"];
                  $this->view->datnais = $_POST["date_nais_membre"];
                  $this->view->nation = $_POST["nationalite_membre"];
                  $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                  $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                  $this->view->formation = $_POST["formation"];
                  $this->view->profession = $_POST["profession_membre"];
                  $this->view->religion = $_POST["religion_membre"];
                  $this->view->pere = $_POST["pere_membre"];
                  $this->view->mere = $_POST["mere_membre"];
                  $this->view->quartier_membre = $_POST["quartier_membre"];
                  $this->view->ville_membre = $_POST["ville_membre"];
                  $this->view->bp = $_POST["bp_membre"];
                  $this->view->tel = $_POST["tel_membre"];
                  $this->view->email = $_POST["email_membre"];
                  $this->view->portable = $_POST["portable_membre"];
                  $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
            }
	     }
	} 
	*/
	
	
    public function newAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_agence = $user->code_agence;
        $code = '';
        try {
            $val_fs = Util_Utils::getParametre('FS', 'valeur');
			$valfs = explode(".",$val_fs);
            $val_fs = $valfs[0];
            if ($this->getRequest()->fs != null) {
                $val_caps = $this->getRequest()->fs;
                if ($val_caps >= $val_fs) {
                    $this->view->fs = $val_fs;
                    $code = $this->getRequest()->code;
                    $this->view->code = $code;
					$this->view->apporteur = $this->getRequest()->apporteur;
                }
            } else {
                $this->view->fs = $val_fs;
            }	
			
        } catch (Exception $exc) {
            $this->view->message = "Erreur d'exécution :" . $exc->getMessage();
            return;
        }
		
        if ($this->getRequest()->isPost())   {
            // if ($form->isValid($request->getPost())) {
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
            $mode_reg = $_POST["reglement_membre"];
            $membre_reg = $_POST["membre_reg"];
            $code_caps = $_POST["code_caps"];
            $frais_identification = trim($_POST["frais_identification"]);
			    
            $fs = Util_Utils::getParametre('FS','valeur');
			  	  
            if ($mode_reg == 'N') {
                $code_sms = $_POST["code_sms"];
            } else {
                $code_sms = '';
            }
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                //traitement des numero avec ajout des zero pour obtenir les 13 chiffres
                $m_caps = new Application_Model_EuCapsMapper();
                $caps = new Application_Model_EuCaps();
				$cm_map = new Application_Model_EuCompteMapper();
                $cm = new Application_Model_EuCompte();
                if ($mode_reg == 'N' && $code_sms != '') {
                    $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $sms = $sms_mapper->findByCreditCode($code_sms);
                    if ($sms == null) {
                        $db->rollback();
                        $this->view->message = 'Le code sms [' . $code_sms . ']  est  invalide !!!';
                        if ($code_caps != '') {
                           $this->view->code = $code_caps;
                        }
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
                    }
					
                    $mont = $sms->getCreditAmount();
					if($sms->getMotif() != 'FS') {
					    $db->rollBack();
                        $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                        if ($code_caps != '') {
                           $this->view->code = $code_caps;
                        }
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;    
					}	
					
                }   elseif ($code_sms == '' && $membre_reg != '' && $mode_reg == 'CNP') {
                    $membre_map = new Application_Model_EuMembreMapper();
                    $membre = new Application_Model_EuMembre();
                    $ret_m = $membre_map->find($membre_reg, $membre);
                    if ($ret_m) {
                        if (substr($membre_reg,19,1) == 'P') {
                            $code_compte = 'NB-TPAGCRPG-'.$membre_reg;
                        } else {
                            $code_compte = 'NB-TPAGCI-'.$membre_reg;
                        }
                    } else {
                            $this->view->message = "Ce membre " . $membre_reg . " n'existe pas !!!";
                            $db->rollback();
                            if ($code_caps != '') {
                               $this->view->code = $code_caps;
                            }
                            $this->view->nom_membre = $_POST["nom_membre"];
                            $this->view->prenom_membre = $_POST["prenom_membre"];
                            $this->view->sexe = $_POST["sexe_membre"];
                            $this->view->sitfam = $_POST["sitfam_membre"];
                            $this->view->datnais = $_POST["date_nais_membre"];
                            $this->view->nation = $_POST["nationalite_membre"];
                            $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                            $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                            $this->view->formation = $_POST["formation"];
                            $this->view->profession = $_POST["profession_membre"];
                            $this->view->religion = $_POST["religion_membre"];
                            $this->view->pere = $_POST["pere_membre"];
                            $this->view->mere = $_POST["mere_membre"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            return;
                    }
                    $cm_map = new Application_Model_EuCompteMapper();
                    $cm = new Application_Model_EuCompte();
                    $ret = $cm_map->find($code_compte, $cm);
                    if ($ret && $cm->getSolde() >= $fs) {
                       $mont = $fs;
                    }
                } elseif ($code_caps != '') {
                    $rep = $m_caps->find($code_caps, $caps);
                    if ($rep && $caps->getMont_caps() >= $fs) {
                       $mont = $fs;
                    }
                } elseif ($mode_reg == 'CAPS' && $membre_reg != '') {
                    $caps = $m_caps->fetchByApporteur($membre_reg);
					$rep = $m_caps->find($caps->getCode_caps(),$caps);
					$code_caps = $caps->getCode_caps();
                    if ($caps != null && $caps->getMont_caps() >= $fs) {
                        $mont = $fs;
                    }
                } else {
                    $this->view->message = "Erreur d'execution: Le mode de règlement m.$mode_reg n'est pas valide !!!";
                    $db->rollback();
                    if ($code_caps != '') {
                       $this->view->code = $code_caps;
                    }
                    $this->view->nom_membre = $_POST["nom_membre"];
                    $this->view->prenom_membre = $_POST["prenom_membre"];
                    $this->view->sexe = $_POST["sexe_membre"];
                    $this->view->sitfam = $_POST["sitfam_membre"];
                    $this->view->datnais = $_POST["date_nais_membre"];
                    $this->view->nation = $_POST["nationalite_membre"];
                    $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                    $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                    $this->view->formation = $_POST["formation"];
                    $this->view->profession = $_POST["profession_membre"];
                    $this->view->religion = $_POST["religion_membre"];
                    $this->view->pere = $_POST["pere_membre"];
                    $this->view->mere = $_POST["mere_membre"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    return;
                }
                if (($code_sms != '' && $mont == $frais_identification) || ($membre_reg != '' && $mont >= $frais_identification) || $code_caps != '') {
					//insertion dans la table membre des informations du nouveau membre
                    $membre = new Application_Model_EuMembre();
                    $mapper = new Application_Model_EuMembreMapper();
                    $code = $mapper->getLastCodeMembreByAgence($code_agence);
                    if ($code == null) {
                       $code = $code_agence . '0000001' . 'P';
                    } else {
                       $num_ordre = substr($code, 12, 7);
                       $num_ordre++;
                       $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                       $code = $code_agence . $num_ordre_bis . 'P';
                    }
					
                    $date_nais = new Zend_Date($_POST["date_nais_membre"]);
					
                    if ($date_nais >= $date_idd) {
                        $this->view->message = "Erreur d'execution: La date de naissance doit etre antérieure à la date actuelle !!!";
                        $db->rollback();
                        if ($code_caps != '') {
                           $this->view->code = $code_caps;
                        }
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
                    }
					
					// insertion dans la table eu_membre
                    $membre->setCode_membre($code)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($_POST["nationalite_membre"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setId_utilisateur($user->id_utilisateur)
                           ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                           ->setDate_identification($date_idd->toString('yyyy-MM-dd'))
                           ->setCode_agence($user->code_agence)
                           ->setId_maison(null)
                           ->setCodesecret(md5($_POST["codesecret"]))
						   ->setEtat_membre('N')
						   ->setCode_gac($user->code_acteur);
						   
                    if (($code_caps != null && $code_caps != '') || ($mode_reg == 'CAPS')) {
                        $membre->setAuto_enroler('N');
                    } else {
                        $membre->setAuto_enroler('O');
                    }
                    $mapper->save($membre);
  
                $acteur = '';
                $table = new Application_Model_DbTable_EuActeur();
			    /*$select = $table->select();
			    $select->where('code_acteur like ?',$user->code_acteur);
			    $result = $table->fetchAll($select);
			    $findacteur = $result->current();
			    $code_gac_chaine = $findacteur->code_gac_chaine;
			    $selection = $table->select();
			    $selection->where('code_gac_chaine like ?',$code_gac_chaine);
			    $selection->where('type_acteur like ?','gac_surveillance');
			    $resultat = $table->fetchAll($selection);
			    $trouvacteursur = $resultat->current();
			    $acteur = $trouvacteursur->code_acteur;*/
				$acteur = $user->code_acteur;
			    
				    /*if($acteur != '') {
				      $acteur = $trouvacteursur->code_acteur;
				    } else {
				      $acteur  = NULL;
				    }*/
			   
                    $userin = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();
					// insertion dans la table eu_utilisateur
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user)
                           ->setId_utilisateur_parent($user->id_utilisateur)
                           ->setPrenom_utilisateur($_POST["prenom_membre"])
                           ->setNom_utilisateur($_POST["nom_membre"])
                           ->setLogin($code)
                           ->setPwd(md5($_POST["codesecret"]))
                           ->setDescription(null)
                           ->setUlock(0)
                           ->setCh_pwd_flog(0)
                           ->setCode_groupe('personne_physique')
					       ->setCode_groupe_create('personne_physique')
                           ->setConnecte(0)
                           ->setCode_agence($user->code_agence)
                           ->setCode_secteur(null)
                           ->setCode_zone($user->code_zone)
                           //->setCode_gac_filiere(null)
		                   ->setId_pays($user->id_pays)	    	
                           ->setCode_acteur($acteur)
					       ->setCode_membre($code);    
                    
					
				
				// Mise à jour de la table eu_contrat
                $contrat = new Application_Model_EuContrat();
		        $mapper_contrat = new Application_Model_EuContratMapper();
		        $id_contrat = $mapper->findConuter() + 1;
				$contrat->setId_contrat($id_contrat);
                $contrat->setCode_membre($code);
                $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                $contrat->setNature_contrat('numerique');
                $contrat->setId_type_contrat(null);
                $contrat->setId_type_creneau(null);
                $contrat->setId_type_acteur(null);
                $contrat->setId_pays(null);
                $contrat->setId_utilisateur($user->id_utilisateur);
                $contrat->setFiliere(null);
                $mapper_contrat->save($contrat);
				
				// insertion dans la table eu_compte_bancaire
                $cpte = $_POST['cpteur'];
                $i = 1;
                $cb_mapper = new Application_Model_EuCompteBancaireMapper();
			    $id_compte = $cb_mapper->findConuter() + 1;
                $cb = new Application_Model_EuCompteBancaire();
                
				while ($i <= $cpte) {
					$id_compte = $cb_mapper->findConuter() + 1;
                    if ($_POST['code_banque' . $i] != '' && $_POST['num_compte' . $i] != '') {
                        $cb->setId_compte($id_compte)
						   ->setCode_banque($_POST['code_banque' . $i])
                           ->setCode_membre($code)
						   ->setCode_membre_morale(null)
                           ->setNum_compte_bancaire($_POST['num_compte' . $i]);
                        $cb_mapper->save($cb);
                        }
                        $i++;
                    }
                    //Mise � jour du bnp caps
                    if (($code_caps != null && $code_caps != '') || $mode_reg == 'CAPS') {
                       if ($rep) {
                          $caps->setCode_membre_benef($code)
                               ->setFs_utiliser(1);
                          $m_caps->update($caps);
						   
						    // insertion dans eu_fs
						    $tab_fs = new Application_Model_DbTable_EuFs();
                            $fs_model = new Application_Model_EuFs();
                            $fs_model->setCode_membre($code)
						           ->setCode_membre_morale(null)
                                   ->setCode_fs('FS-' . $code)
                                   ->setCreditcode($code_caps)
                                   ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                   ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                   ->setId_utilisateur($user->id_utilisateur)
                                   ->setMont_fs($frais_identification);
                            $tab_fs->insert($fs_model->toArray()); 
						   
						   
						    //insertion des frais d'identification dans la table operation
                            $mapper_op = new Application_Model_EuOperationMapper();
                            $compteur = $mapper_op->findConuter() + 1;
						    $lib_op = 'Enrôlement';
                            $type_op = 'ERL';
						    Util_Utils::addOperation($compteur,$code,null,'TFS',$frais_identification,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), $user->id_utilisateur);
                        
                        }
                    } else if($mode_reg == 'N') {
                      //insertion des frais d'identification dans la table operation
                      $mapper_op = new Application_Model_EuOperationMapper();
                      $compteur = $mapper_op->findConuter() + 1;
                      $lib_op = 'Auto-enrôlement'; 
                      $type_op = 'AERL';
                      Util_Utils::addOperation($compteur,$code,null,'TFS',$frais_identification,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'),$user->id_utilisateur);
					   //Util_Utils::createCompte('nb-tpagcrpg-' . $code, 'tpagcrpg', 'tpagcrpg', 0, $code, 'nb', $date_id, 0);
                    } 
                    $tab_fs = new Application_Model_DbTable_EuFs();
                    $fs_model = new Application_Model_EuFs();
                    if ($code_sms != '' && $sms != null) {
                        $fs_model->setCode_membre($code)
						         ->setCode_membre_morale(NULl)
                                 ->setCode_fs('FS-'.$code)
                                 ->setCreditcode($sms->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                 ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                 ->setId_utilisateur($user->id_utilisateur)
                                 ->setMont_fs($frais_identification);
                        $tab_fs->insert($fs_model->toArray());
 
                        $sms->setDestAccount_Consumed('NB-TFS-' . $code)
                            ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms);	 	    
                    }
					
					$acteur = $user->code_acteur;
					$t_cmfh = new Application_Model_DbTable_EuCmfh();
                    $c_cmfh = new Application_Model_EuCmfh();
				    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
                    $count = $c_acteur->findConuter() + 1;
					$countcmfh = $c_cmfh->findConuter() + 1;
					$table = new Application_Model_DbTable_EuActeur();
					
					// insertion dans la table eu_cmfh
					if(isset($_POST["actcmfh"])) {
                      $select = $table->select();
					  $select->where('code_acteur like ?', $acteur);
					  $resultSet = $table->fetchAll($select);
					  $ligneacteur = $resultSet->current();
                      $c_cmfh->setId_cmfh($countcmfh);
                      $c_cmfh->setCode_membre($code);
                      $c_cmfh->setId_utilisateur($user->id_utilisateur);
                      $c_cmfh->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				      $c_cmfh->setCode_activite(null);
				      $c_cmfh->setCode_source_create($ligneacteur->code_source_create);
				      $c_cmfh->setCode_monde_create($ligneacteur->code_monde_create);
					  $c_cmfh->setCode_zone_create($ligneacteur->code_zone_create);
					  $c_cmfh->setId_pays($ligneacteur->id_pays);
					  $c_cmfh->setId_region($ligneacteur->id_region);
					  $c_cmfh->setCode_secteur_create($ligneacteur->code_secteur_create);
					  $c_cmfh->setCode_agence_create($ligneacteur->code_agence_create);					  
                      $c_cmfh->setType_acteur('CMFH');
				        if(($acteur !='') || ($acteur != null)) {
				           $c_cmfh->setCode_gac_chaine($acteur);           
                        } else {
						   $c_cmfh->setCode_gac_chaine(null);
						}         
                        $t_cmfh->insert($c_cmfh->toArray());
					  
					} else if(isset($_POST["actenro"])) {
					    $select = $table->select();
					    $select->where('code_acteur like ?', $acteur);
					    $resultSet = $table->fetchAll($select);
					    $ligneacteur = $resultSet->current();
                        $c_acteur->setId_acteur($count);
                        $c_acteur->setCode_acteur(null);
						$c_acteur->setCode_division(null);
                        $c_acteur->setCode_membre($code);
                        $c_acteur->setId_utilisateur($user->id_utilisateur);
                        $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				        $c_acteur->setCode_activite(null);
				        $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				        $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
					    $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					    $c_acteur->setId_pays($ligneacteur->id_pays);
					    $c_acteur->setId_region($ligneacteur->id_region);
					    $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					    $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					    $c_acteur->setType_acteur('DSMS');
						if(($acteur !='') || ($acteur != null)) {
				           $c_acteur->setCode_gac_chaine($acteur);           
                        } else {
						   $c_acteur->setCode_gac_chaine(null);
						}
                        $t_acteur->insert($c_acteur->toArray());						
					}
					
                    $mapper->save($userin);					
                    $compteur=Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    return $this->_helper->redirector('index');
					
					} else {
                        $db->rollback();
                        $this->view->message = 'Ce code [' . $code_sms . '] correspond à un montant de: ' . $sms->getCreditAmount() . ' ' . $sms->getCurrencyCode();
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
					   
                        if ($code_caps != '') {
                            $this->view->code = $code_caps;
                        }
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;
                }
            } 
			catch (Exception $exc) {
                $db->rollback();
                $this->view->nom_membre = $_POST["nom_membre"];
                if ($code_caps != '') {
                   $this->view->code = $code_caps;
                }
                $this->view->prenom_membre = $_POST["prenom_membre"];
                $this->view->sexe = $_POST["sexe_membre"];
                $this->view->sitfam = $_POST["sitfam_membre"];
                $this->view->datnais = $_POST["date_nais_membre"];
                $this->view->nation = $_POST["nationalite_membre"];
                $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                $this->view->formation = $_POST["formation"];
                $this->view->profession = $_POST["profession_membre"];
                $this->view->religion = $_POST["religion_membre"];
                $this->view->pere = $_POST["pere_membre"];
                $this->view->mere = $_POST["mere_membre"];
                $this->view->quartier_membre = $_POST["quartier_membre"];
                $this->view->ville_membre = $_POST["ville_membre"];
                $this->view->bp = $_POST["bp_membre"];
                $this->view->tel = $_POST["tel_membre"];
                $this->view->email = $_POST["email_membre"];
                $this->view->portable = $_POST["portable_membre"];
                $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
            }
        }
    }

	public function docmfhAction() {
	        $request = $this->getRequest();
            $user = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'))->getIdentity();
		    if ($request->isPost()) {
			   $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
			   $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
			    try {
	                $code_membre = $request->code_membre;
			        if(isset($request->actcmfh)) { $actcmfh =   $request->actcmfh;}
			        if(isset($request->actenro)) { $actenro =   $request->actenro;}
				    $acteur = $user->code_acteur;
				    $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
					
					$t_cmfh = new Application_Model_DbTable_EuCmfh();
                    $c_cmfh = new Application_Model_EuCmfh();
                    $count = $c_acteur->findConuter() + 1;
					$countcmfh = $c_cmfh->findConuter() + 1;
			        $table = new Application_Model_DbTable_EuActeur();
					
				    // insertion dans la table eu_acteur
				    $findacteur =  $c_acteur->findByActeur($code_membre);
					$findcmfh =  $c_cmfh->findByActeur($code_membre);
					
				    if($findcmfh == false) {
					    if(isset($actcmfh)) {
                            $select = $table->select();
					        $select->where('code_acteur like ?',$acteur);
					        $resultSet = $table->fetchAll($select);
					        $ligneacteur = $resultSet->current();
                            $c_cmfh->setId_cmfh($countcmfh);
                            $c_cmfh->setCode_membre($code_membre);
                            $c_cmfh->setId_utilisateur($user->id_utilisateur);
                            $c_cmfh->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				            $c_cmfh->setCode_activite(null);
				            $c_cmfh->setCode_source_create($ligneacteur->code_source_create);
				            $c_cmfh->setCode_monde_create($ligneacteur->code_monde_create);
					        $c_cmfh->setCode_zone_create($ligneacteur->code_zone_create);
					        $c_cmfh->setId_pays($ligneacteur->id_pays);
					        $c_cmfh->setId_region($ligneacteur->id_region);
					        $c_cmfh->setCode_secteur_create($ligneacteur->code_secteur_create);
					        $c_cmfh->setCode_agence_create($ligneacteur->code_agence_create);					  
                            $c_cmfh->setType_acteur('CMFH');
				            if(($acteur !='') || ($acteur != null)) {
				               $c_cmfh->setCode_gac_chaine($acteur);           
                            } else {
						      $c_cmfh->setCode_gac_chaine(null);
						    }         
                            $t_cmfh->insert($c_cmfh->toArray());
					  
					    } 						
			    } else  {
				    $this->view->data = 'Le membre est dejà enrôlé comme CMFH !!!';
                    $db->rollback();
                    return;    
                }
				
				if($findacteur == false) {
				    if(isset($actenro)) {
					   $select = $table->select();
					   $select->where('code_acteur like ?', $acteur);
					   $resultSet = $table->fetchAll($select);
					   $ligneacteur = $resultSet->current();
                       $c_acteur->setId_acteur($count);
                       $c_acteur->setCode_acteur(null);
				       $c_acteur->setCode_division(null);
                       $c_acteur->setCode_membre($code_membre);
                       $c_acteur->setId_utilisateur($user->id_utilisateur);
                       $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
				       $c_acteur->setCode_activite(null);
				       $c_acteur->setCode_source_create($ligneacteur->code_source_create);
				       $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
					   $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
					   $c_acteur->setId_pays($ligneacteur->id_pays);
					   $c_acteur->setId_region($ligneacteur->id_region);
					   $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
					   $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
					   $c_acteur->setType_acteur('DSMS');
				        if(($acteur !='') || ($acteur != null)) {
				          $c_acteur->setCode_gac_chaine($acteur);           
                        } else {
					      $c_acteur->setCode_gac_chaine(null);
				        }
                        $t_acteur->insert($c_acteur->toArray());
					}
				
				} else  {
				    $this->view->data = 'Le membre est dejà un membre enrôleur !!! ';
                    $db->rollback();
                    return;    
                }
				    $db->commit();
                    $this->view->data = true;
                    return;
	            
				} catch (Exception $exc) {
                    $db->rollback();
                    $this->view->data = $exc->getMessage() . '--> ' . $exc->getTraceAsString();
                    return;
                }
	        
			}
	
	}
	
	
    public function codesmsAction() {
        $code = $_GET["code"];
        if ($code != '') {
           $tsms = new Application_Model_DbTable_EuSmsmoney();
           $select = $tsms->select();
           $select->where('creditcode = ?', $code)
                  ->where('iddatetimeconsumed = ?', 0);
           $results = $tsms->fetchAll($select);
           if (count($results) > 0) {
                $data[0] = $results->current()->creditamount;
                $data[1] = $results->current()->currencycode;
           } else {
                $data[0] = 0;
                $data[1] = $code;
           }
        }
        $this->view->data = $data;
    }

    public function deleteAction() {
        // action body
        $form = new Application_Form_EuMembre();
        if ($this->getRequest()->isPost()) {
            $mapper = new Application_Model_EuMembreMapper();
            $mapper->delete($this->getRequest()->num_membre);
            return $this->_helper->redirector('index');
        } else {
            // initial rendering of the form, get the employee id
            // from the parameters
            $num_membre = $this->getRequest()->num_membre;
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
            $mapper->find($num_membre, $membre);
            if ($membre->getCode_membre() == $num_membre) {
                $data = array(
                 'code_membre' => $num_membre,
                 'nom_membre' => $membre->getNom_membre(),
                 'prenom_membre' => $membre->getPrenom_membre(),
                 'sexe_membre' => $membre->getSexe_membre(),
                 'date_nais_membre' => $membre->getDate_nais_membre(),
                 'lieu_nais_membre' => $membre->getLieu_nais_membre(),
                 'id_pays' => $membre->getId_pays(),
                 'profession_membre' => $membre->getProfession_membre(),
                 'formation' => $membre->getFormation(),
                 'pere_membre' => $membre->getPere_membre(),
                 'mere_membre' => $membre->getMere_membre(),
                 'sitfam_membre' => $membre->getSitfam_membre(),
                 'nbr_enf_membre' => $membre->getNbr_enf_membre(),
                 'quartier_membre' => $membre->getQuartier_membre(),
                 'ville_membre' => $membre->getVille_membre(),
                 'bp_membre' => $membre->getBp_membre(),
                 'tel_membre' => $membre->getTel_membre(),
                 'email_membre' => $membre->getEmail_membre(),
                 'date_identification' => $membre->getDate_identification(),
                 'portable_membre' => $membre->getPortable_membre(),
                 'empreinte_membre' => $membre->getEmpreinte_membre(),
                 'code_agence' => $membre->getCode_agence(),
                 'heure_identification' => $membre->getHeure_identification(),
                 'id_religion_membre' => $membre->getId_religion_membre(),
                 'id_utilisateur' => $membre->getId_utilisateur(),
                 'raison_sociale' => $membre->getRaison_sociale(),
                 'type_membre' => $membre->getType_membre(),
                 'site_web' => $membre->getSite_web(),
                 'domaine_activite' => $membre->getDomaine_activite(),
                 'photo_membre' => $membre->getPhoto_membre()
                );
                $form->populate($data);
            } else {
                // redirect to new action if the employee id is invalid
                return $this->_helper->redirector('new');
            }
        }
        // make form read-only
        foreach ($form->getElements() as $formElement) {
            if ($formElement->getAttrib('id') != 'submit-label') {
                $formElement->setAttrib('readonly', 'true');
            }
        }
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                'controller' => 'eu-membre',
                'action' => 'index'), 'default', true) . "','_self')");

        $this->view->form = $form;
    }

    // fonction pour modifier les informations du membre personne morale
    public function editAction() {
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_agence = $user->code_agence;
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuMembre();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $mapper = new Application_Model_EuMembreMoraleMapper();
                $membre = new Application_Model_EuMembreMorale($form->getValues());
                $membre->setCode_membre_morale($this->getRequest()->code_membre_morale);
                $membre->setCode_agence($code_agence)
				        ->setCode_type_acteur($request->code_type_acteur)
				        ->setCode_statut(trim ($request->code_statut))
						->setNum_registre_membre(trim ($request->num_registre_membre))
						->setId_pays($request->id_pays)
						->setQuartier_membre(trim($request->quartier_membre))
						->setVille_membre(trim($request->ville_membre))
						->setBp_membre($request->bp_membre)
						->setTel_membre($request->tel_membre)
						->setEmail_membre(trim($request->email_membre))
						->setPortable_membre($request->portable_membre)
						->setRaison_sociale(trim ($request->raison_sociale))
						->setSite_web(trim ($request->site_web))
						->setDomaine_activite(trim($request->domaine_activite))
                        ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                        ->setHeure_identification($date_id->toString('HH:mm:ss'))
                        ->setId_utilisateur($user->id_utilisateur);
                $mapper->update($membre);
                return $this->_helper->redirector('morale');
            }
        } else {
            $num_membre = $request->membre;
            $mapper = new Application_Model_EuMembreMoraleMapper();
            $membre = new Application_Model_EuMembreMorale();
            $mapper->find($num_membre, $membre);
            if ($membre->getCode_membre_morale() == $num_membre) {
                $data = array(
                    'code_membre_morale' => $num_membre,
                    'code_type_acteur' => $membre->getCode_type_acteur(),
                    'code_statut' => $membre->getCode_statut(),
                    'num_registre_membre' => $membre->getNum_registre_membre(),
                    'id_pays' => $membre->getId_pays(),
                    'quartier_membre' => $membre->getQuartier_membre(),
                    'ville_membre' => $membre->getVille_membre(),
                    'bp_membre' => $membre->getBp_membre(),
                    'tel_membre' => $membre->getTel_membre(),
                    'email_membre' => $membre->getEmail_membre(),
                    'portable_membre' => $membre->getPortable_membre(),
                    'code_agence' => $membre->getCode_agence(),
                    'id_utilisateur' => $membre->getId_utilisateur(),
                    'raison_sociale' => $membre->getRaison_sociale(),
                    'site_web' => $membre->getSite_web(),
                    'domaine_activite' => $membre->getDomaine_activite()
                );
                $form->populate($data);
            }
        }
		
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick', "window.open('" .
                $this->view->url(array(
                    'controller' => 'eu-membre',
                    'action' => 'morale'
                ), 'default', true) .
                "','_self')");

        $this->view->membre = $membre;
        $this->view->form = $form;
    }


// fonction pour modifier les informations du membre personne physique
public function peditAction() {
	
        // action body
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_agence = $user->code_agence;
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $form = new Application_Form_EuMembrep();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
			    $membre = new Application_Model_EuMembre($form->getValues());
			    $date_nais = new Zend_Date($this->getRequest()->date_nais_membre);
                $membre->setCode_membre($this->getRequest()->code_membre);
                $membre->setCode_agence($code_agence)
                       ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                       ->setHeure_identification($date_id->toString('HH:mm:ss'))
                       ->setId_utilisateur($user->id_utilisateur)
					   ->setNom_membre(trim($this->getRequest()->nom_membre))
					   ->setPrenom_membre(trim($this->getRequest()->prenom_membre))
					   ->setSexe_membre($this->getRequest()->sexe_membre)
					   ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
					   ->setLieu_nais_membre(trim($this->getRequest()->lieu_nais_membre))
					   ->setId_pays($this->getRequest()->id_pays)
					   ->setProfession_membre(trim ($this->getRequest()->profession_membre))
					   ->setFormation(trim ($this->getRequest()->formation))
					   ->setPere_membre(trim ($this->getRequest()->pere_membre))
					   ->setMere_membre(trim ($this->getRequest()->mere_membre))
					   ->setSitfam_membre(trim($this->getRequest()->sitfam_membre))
					   ->setNbr_enf_membre($this->getRequest()->nbr_enf_membre)
					   ->setQuartier_membre(trim ($this->getRequest()->quartier_membre))
					   ->setVille_membre(trim ($this->getRequest()->ville_membre))
					   ->setBp_membre($this->getRequest()->bp_membre)
					   ->setTel_membre($this->getRequest()->tel_membre)
					   ->setEmail_membre(trim ($this->getRequest()->email_membre))
					   ->setPortable_membre($this->getRequest()->portable_membre)
					   ->setId_religion_membre($this->getRequest()->id_religion_membre);
                $mapper = new Application_Model_EuMembreMapper();
                $mapper->update($membre);
                return $this->_helper->redirector('index');
            } else {
                
            }
            $num_membre = $this->getRequest()->code_membre;
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
        } else {
            $num_membre = $request->membre;
            $mapper = new Application_Model_EuMembreMapper();
            $membre = new Application_Model_EuMembre();
            $mapper->find($num_membre, $membre);
			$tabela = new Application_Model_DbTable_EuMembre();
			$select = $tabela->select();
			$select->from('eu_membre');
			$select->where('code_membre like ?',$membre->getCode_membre());
			$membres = $tabela->fetchAll($select);
			$row = $membres->current();
			$datenais = new Zend_Date($row->date_nais_membre, Zend_Date::ISO_8601);
            if ($membre->getCode_membre() == $num_membre) {
                $data = array(
                'code_membre' => $num_membre,
                'nom_membre' => $membre->getNom_membre(),
                'prenom_membre' => $membre->getPrenom_membre(),
                'sexe_membre' => $membre->getSexe_membre(),
                'date_nais_membre' => $datenais->toString('dd/MM/yyyy'),
                'lieu_nais_membre' => $membre->getLieu_nais_membre(),
                'id_pays' => $membre->getId_pays(),
                'profession_membre' => $membre->getProfession_membre(),
                'formation' => $membre->getFormation(),
                'pere_membre' => $membre->getPere_membre(),
                'mere_membre' => $membre->getMere_membre(),
                'sitfam_membre' => $membre->getSitfam_membre(),
                'nbr_enf_membre' => $membre->getNbr_enf_membre(),
                'quartier_membre' => $membre->getQuartier_membre(),
                'ville_membre' => $membre->getVille_membre(),
                'bp_membre' => $membre->getBp_membre(),
                'tel_membre' => $membre->getTel_membre(),
                'email_membre' => $membre->getEmail_membre(),
                'date_identification' => $membre->getDate_identification(),
                'portable_membre' => $membre->getPortable_membre(),
                'code_agence' => $membre->getCode_agence(),
                'heure_identification' => $membre->getHeure_identification(),
                'id_religion_membre' => $membre->getId_religion_membre(),
                'id_utilisateur' => $membre->getId_utilisateur(),
                'auto_enroler' => $membre->getAuto_enroler()
                );
                $form->populate($data);
            }
        }
		
        // Add the link to the cancel button
        $form->getElement('cancel')->setAttrib('onclick',"window.open('" .
        $this->view->url(array('controller' => 'eu-membre','action' => 'index'), 'default', true) ."','_self')");

        $this->view->membre = $membre;
        $this->view->form = $form;
    }

    public function contratAction() {

        $request = $this->getRequest();
        $code_membre = $request->code_membre;
        $contrat = new Application_Model_DbTable_EuContrat;
        $select = $contrat->select();
        $select->from($contrat, array('code_membre'));
        $select->where('code_membre = ?', $code_membre);
        $result = $contrat->fetchAll($select);
        $row = $result->current();
        $this->view->data = $row['code_membre'];
    }

    
    public function newcpmAction() {

        // action body
        $this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $request = $this->getRequest();
        $code_membre = $request->membre;
        $this->view->code_membre = $code_membre;
        if ($this->getRequest()->isPost()) {
            // if ($form->isValid($request->getPost())){
            $date_contrat = new Zend_Date(Zend_Date::ISO_8601);
            $contrat = new Application_Model_EuContrat();

            $contrat->setCode_membre($_POST['code_membre']);
            $contrat->setDate_contrat($date_contrat->toString('yyyy-mm-dd'));
            $contrat->setNature_contrat('');
            $contrat->setId_type_contrat($_POST['type_contrat']);
            if (isset($_POST['type_creneau']))
                $contrat->setId_type_creneau($_POST['type_creneau']);
            else
                $contrat->setId_type_creneau(null);
            if (isset($_POST['type_acteur']) && $_POST['type_acteur'] != '')
                $contrat->setId_type_acteur($_POST['type_acteur']);
            else
                $contrat->setId_type_acteur(null);
            $contrat->setId_pays($_POST['pays']);
            $contrat->setId_utilisateur($user->id_utilisateur);
            $contrat->setFiliere('');
            $mapper = new Application_Model_EuContratMapper();
            $mapper->save($contrat);
            if (trim($user->code_groupe) == 'cm') {
                return $this->_helper->redirector('index', 'eu-contrat', null, array('controller' => 'eu-contrat', 'action' => 'index'));
            } elseif (trim($user->code_groupe) == 'banque') {
                return $this->_helper->redirector('index', 'eu-placement', null, array('controller' => 'eu-placement', 'action' => 'index'));
            } else {
                return $this->_helper->redirector('index', 'eu-bnp', null, array('controller' => 'eu-bnp', 'action' => 'index'));
            }
            // }
        }
    }

    public function newcppAction() {

        // action body
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        $type = $request->type;
        $membre = $request->membre;

        if ($type == "p") {
            $this->view->type_contrat = "Investisseurs physiques";
        }

        $this->view->code_membre = $membre;
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        if ($this->getRequest()->isPost()) {

            $mapper = new Application_Model_EuContratMapper();
            $datecontrat = new Zend_Date(Zend_Date::ISO_8601);
            $contrat = new Application_Model_EuContrat();
            $date_contrat = clone $datecontrat;
            $contrat->setCode_membre($_POST['code_membre']);
            $contrat->setDate_contrat($date_contrat->toString('yyyy-mm-dd'));
            $contrat->setNature_contrat($_POST['nature_contrat']);
            $contrat->setId_type_contrat(null);
            $contrat->setId_type_creneau(null);
            $contrat->setId_type_acteur(null);
            $contrat->setId_pays(null);
            $contrat->setId_utilisateur($user->id_utilisateur);
            if (isset($_POST['filiere']))
                $contrat->setFiliere($_POST['filiere']);
            else
                $contrat->setFiliere('');

            $mapper->save($contrat);
            if (trim($user->code_groupe) == 'cm') {
                return $this->_helper->redirector('index', 'eu-contrat', null, array('controller' => 'eu-contrat', 'action' => 'index'));
            } elseif (trim($user->code_groupe) == 'banque') {
                return $this->_helper->redirector('index', 'eu-placement', null, array('controller' => 'eu-placement', 'action' => 'index'));
            } else {
                return $this->_helper->redirector('index', 'eu-bnp', null, array('controller' => 'eu-bnp', 'action' => 'index'));
            }
        }
    }





}
