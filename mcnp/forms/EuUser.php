<?php

class Application_Form_EuUser extends Zend_Form {

    public function init() {
        
        /* Form Elements & Other Definitions Here ... */
        
        $this->setMethod("post");
        $this->addElement('hidden', 'id_utilisateur');
        
        
        $nom = new Zend_Form_Element_Text('nom_utilisateur');
        $nom->setLabel('Nom *')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
			->setAttrib('size',30);
        
        
        $prenom = new Zend_Form_Element_Text('prenom_utilisateur');
        $prenom->setLabel('Prenom *')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
			   ->setAttrib('size',30);
        
        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login *')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
			  ->setAttrib('size',30);
 
        
        $pwd = new Zend_Form_Element_Password('pwd');
        $pwd->setLabel('Mot de passe *')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
			->setAttrib('size',30);
        
        
        $pwd1 = new Zend_Form_Element_Password('pwd1');
        $pwd1->setLabel('Confirmer mot de pass *')
             ->setRequired(true)
             ->addFilter('StripTags')
             ->addFilter('StringTrim')
			 ->setAttrib('size',30);

        
        $groupe = new Application_Model_EuUserGroupMapper();
        $rows = $groupe->fetchAll();
        $usergroup = new Zend_Form_Element_Select('code_groupe', array('separator' => ' '));
        $usergroup->setLabel('Groupe *')
                  ->isRequired(true);
        
        
        foreach ($rows as $c) {
            $usergroup->addMultiOption($c->code_groupe, $c->libelle_groupe);
        }

        $descr = new Zend_Form_Element_Textarea('description');
        $descr->setLabel('Description  ')
              ->setRequired(false)
              ->addFilter('StripTags')
              ->addFilter('StringTrim');
        
        $ulock = new Zend_Form_Element_Checkbox('ulock');
        $ulock->setLabel('Désactiver');

        
        $ag = new Application_Model_EuAgenceMapper();
        $rows = $ag->fetchAll();
        $agence = new Zend_Form_Element_Select('code_agence');
        $agence->setLabel('Agence')
               ->isRequired(false);
        
        
        foreach ($rows as $c) {
            $agence->addMultiOption($c->code_agence,$c->libelle_agence);
        }

        
        $zoo = new Application_Model_EuZoneMapper();
        $zones = $zoo->fetchAll();
        $zone_select = new Zend_Form_Element_Select('code_zone', array('separator' => ' '));
        $zone_select->setLabel('Zone')
                ->isRequired(false);
        
        
        foreach ($zones as $z) {
            $zone_select->addMultiOption($z->code_zone, $z->nom_zone);
        }

        
        $sect = new Application_Model_EuSecteurMapper();
        $secteurs = $sect->fetchAll();
        $sect_select = new Zend_Form_Element_Select('code_secteur');
        $sect_select->setLabel('Secteur ')
                ->isRequired(false);
        
        
        foreach ($secteurs as $s) {
            $sect_select->addMultiOption($s->code_secteur, $s->nom_secteur);
        }
        
        
        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre", array('label' => 'Numéro membre','size' => 30)
        );
        $elem->setRequired(false);
        $elem->setJQueryParams(array('source' => $membres));
        
        
        $gac_f = new Application_Model_EuGacFiliereMapper();
        $filiere = $gac_f->fetchAll();
        $filiere_select = new Zend_Form_Element_Select('code_gac_filiere');
        $filiere_select->setLabel('Gac filière')
                ->isRequired(false);
        foreach ($filiere as $f) {
          $filiere_select->addMultiOption(" "," ");
          $filiere_select->addMultiOption($f->code_gac_filiere, $f->nom_gac_filiere);
        }
		 
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $annuler = new Zend_Form_Element_Button('cancel');
        $annuler->setLabel('Annuler');
		
        $this->addElements(array($nom,$prenom,$login,$pwd,$pwd1,$usergroup,$descr,$ulock,$agence,$sect_select,$zone_select,$elem,$filiere_select,$submit,$annuler));
    }
}

