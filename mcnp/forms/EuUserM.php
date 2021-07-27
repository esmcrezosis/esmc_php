<?php

class Application_Form_EuUserM extends Zend_Form {

    public function init() {
        
        /* Form Elements & Other Definitions Here ... */
        
        $this->setMethod("post");
        $this->addElement('hidden', 'id_utilisateur');
        
        
        $nom = new Zend_Form_Element_Text('nom_utilisateur');
        $nom->setLabel('Nom *')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim');
        
        
        $prenom = new Zend_Form_Element_Text('prenom_utilisateur');
        $prenom->setLabel('Prenom *')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim');
        
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
        $agence->setLabel('Agence *')
               ->isRequired(true);
        
        
        foreach ($rows as $c) {
            $agence->addMultiOption($c->code_agence,$c->libelle_agence);
        }

        
        $zoo = new Application_Model_EuZoneMapper();
        $zones = $zoo->fetchAll();
        $zone_select = new Zend_Form_Element_Select('code_zone', array('separator' => ' '));
        $zone_select->setLabel('Zone *')
                ->isRequired(true);
        
        
        foreach ($zones as $z) {
            $zone_select->addMultiOption($z->code_zone, $z->nom_zone);
        }

        
        $sect = new Application_Model_EuSecteurMapper();
        $secteurs = $sect->fetchAll();
        $sect_select = new Zend_Form_Element_Select('code_secteur');
        $sect_select->setLabel('Secteur *')
                ->isRequired(true);
        
        
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
                        "code_membre", array('label' => 'Numéro membre','size' => '35')
        );
        $elem->setRequired(false);
        $elem->setJQueryParams(array('source' => $membres));
        
        
        $f = new Application_Model_EuFiliereMapper();
        $filiere = $f->fetchAll();
        $filiere_select = new Zend_Form_Element_Select('id_filiere');
        $filiere_select->setLabel('Nom filière')
                ->isRequired(false);
        foreach ($filiere as $f) {
          $filiere_select->addMultiOption(" "," ");
          $filiere_select->addMultiOption($f->id_filiere, $f->nom_filiere);
        }
		
        $p = new Application_Model_EuPaysMapper();
        $pays = $p->fetchAll();
        $pays_select = new Zend_Form_Element_Select('id_pays');
        $pays_select->setLabel('Pays')
                    ->isRequired(true);
        foreach ($pays as $f) {
          //$pays_select->addMultiOption(" "," ");
          $pays_select->addMultiOption($f->id_pays,$f->libelle_pays);
        }

		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $annuler = new Zend_Form_Element_Button('cancel');
        $annuler->setLabel('Annuler');
		
        $this->addElements(array($nom,$prenom,$usergroup,$descr,$ulock,$zone_select,$sect_select,$agence,$elem,$filiere_select,$pays_select,$submit,$annuler));
    }
}

