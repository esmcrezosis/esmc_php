<?php

class Application_Form_EuGac extends Zend_Form {

    //put your code here
    public function init() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_groupe = $user->code_groupe;

        $this->setMethod('post');

        $this->addElement('text', 'nom_gac', array(
            'label' => 'Nom *',
            'required' => true,
            'size' => 30,
            'filters' => array('StringTrim'),
        ));

        $nm = new Application_Model_DbTable_EuMembreMorale();
        $select = $nm->select();
        $rows = $nm->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre_morale;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre", array('label' => 'Code membre','required' => false)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $elem->setAttrib('size', '25');
        $elem->setRequired(false);
        $this->addElement($elem);

        $mapper = new Application_Model_DbTable_EuTypeGac();
        $select = $mapper->select();
        $select->order('ordre_type_gac', 'ASC');
        if ($code_groupe == 'agregat') {
            $select->where('ordre_type_gac >=?', 1);
            $select->where('ordre_type_gac <=?', 8);
        } elseif ($code_groupe == 'gac') {
            $select->where('ordre_type_gac >=?', 2);
            $select->where('ordre_type_gac <=?', 8);
        } elseif ($code_groupe == 'gacp') {
            $select->where('ordre_type_gac >=?', 3);
            $select->where('ordre_type_gac <=?', 8);
        } elseif ($code_groupe == 'gacsu') {
            $select->where('ordre_type_gac >=?', 9);
            $select->where('ordre_type_gac <=?', 11);
        } elseif ($code_groupe == 'gacex') {
            $select->where('ordre_type_gac >=?', 3);
        } elseif ($code_groupe == 'gacse') {
            $select->where('ordre_type_gac >=?', 4);
            $select->where('ordre_type_gac <=?', 8);
        } elseif ($code_groupe == 'gacr') {
            $select->where('ordre_type_gac >=?', 5);
            $select->where('ordre_type_gac <=?', 8);
        } elseif ($code_groupe == 'gacs') {
            $select->where('ordre_type_gac >=?', 6);
            $select->where('ordre_type_gac <=?', 8);
        }
        $tgac = $mapper->fetchAll($select);
        $t_select = new Zend_Form_Element_Select('code_type_gac');
        $t_select->setLabel('Type GAC *');
        $t_select->setRequired(true);
        foreach ($tgac as $c) {
            $t_select->addMultiOption('', '');
            $t_select->addMultiOption($c->code_type_gac, $c->nom_type_gac);
        }
        $this->addElement($t_select);

        $mapper = new Application_Model_EuZoneMapper();
        $zones = $mapper->fetchAll();
        $z_select = new Zend_Form_Element_Select('code_zone');
        $z_select->setLabel('Zone géographique');
        $z_select->isRequired(true);
        foreach ($zones as $c) {
            $z_select->addMultiOption('', '');
            $z_select->addMultiOption($c->code_zone, $c->nom_zone);
        }
        $mapper = new Application_Model_EuPaysMapper();
        $zones = $mapper->fetchAll();
        $z_select->isRequired(true);
        foreach ($zones as $c) {
            $z_select->addMultiOption('', '');
            $z_select->addMultiOption($c->id_pays, $c->libelle_pays);
        }
        $mapper = new Application_Model_DbTable_EuSection();
        $zones = $mapper->fetchAll();
        $z_select->isRequired(true);
        foreach ($zones as $c) {
            $z_select->addMultiOption('', '');
            $z_select->addMultiOption($c->id_section, $c->nom_section);
        }
        $mapper = new Application_Model_DbTable_EuRegion();
        $zones = $mapper->fetchAll();
        $z_select->isRequired(true);
        foreach ($zones as $c) {
            $z_select->addMultiOption('', '');
            $z_select->addMultiOption($c->id_region, $c->nom_region);
        }
        $mapper = new Application_Model_EuSecteurMapper();
        $zones = $mapper->fetchAll();
        $z_select->isRequired(true);
        foreach ($zones as $c) {
            $z_select->addMultiOption('', '');
            $z_select->addMultiOption($c->code_secteur, $c->nom_secteur);
        }
        $mapper = new Application_Model_EuAgenceMapper();
        $zones = $mapper->fetchAll();
        $z_select->isRequired(true);
        foreach ($zones as $c) {
            $z_select->addMultiOption('', '');
            $z_select->addMultiOption($c->code_agence, $c->libelle_agence);
        }
        $this->addElement($z_select);

        $a_select = new Zend_Form_Element_Multiselect('code_agence');
        $a_select->setLabel('Agences couvertes');
        $a_select->isRequired(false);
        $mapper = new Application_Model_DbTable_EuAgence();
        $select = $mapper->select();
        $select->order('libelle_agence', 'ASC');
        $agence = $mapper->fetchAll($select);
        foreach ($agence as $c) {
            $a_select->addMultiOption('', '');
            $a_select->addMultiOption($c->code_agence, $c->libelle_agence);
        }
        $this->addElement($a_select);
        
        $ng = new Application_Model_DbTable_EuMembre();
        $select = $ng->select();
        $rows = $ng->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre_gestionnaire", array('label' => 'Numéro gestionnaire','required' => false)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $elem->setAttrib('size', '25');
        $elem->setRequired(false);
        $this->addElement($elem);

        $this->addElement('text', 'nom_gestion', array(
            'label' => 'Nom gestionnaire',
            'required' => false,
            'filters' => array('StringTrim'),
            'size' => 25,
            'readonly' => true,
        ));

        $this->addElement('text', 'prenom_gestion', array(
            'label' => 'Prénoms gestionnaire',
            'required' => false,
            'filters' => array('StringTrim'),
            'size' => 25,
            'readonly' => true,
        ));

        $this->addElement('text', 'tel_gestion', array(
            'label' => 'Téléphone gestionnaire',
            'required' => false,
            'filters' => array('StringTrim'),
            'size' => 25,
            'readonly' => true,
        ));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Valider',
        ));

        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
        $this->addElement(
                'hidden', 'code_gac', array(
        ));
        $this->addElement(
                'hidden', 'zone', array(
        ));
        
    }

}

?>
