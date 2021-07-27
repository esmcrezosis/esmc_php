<?php

class Application_Form_EuCreneau extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");

        $this->addElement(
                'text', 'nom_creneau', array(
            'label' => 'Nom *',
            'required' => true,
            'size' => 40,
            'filters' => array('StringTrim'),
                )
        );
        
        $type_creneau = array();
        $c_mapper = new Application_Model_DbTable_EuTypeCreneau();
        $select = $c_mapper->select();
        $select->order('libelle_type_creneau', 'ASC');
        $typec = $c_mapper->fetchAll($select);
        foreach ($typec as $value) {
            $type_creneau[$value->id_type_creneau] = ucfirst($value->libelle_type_creneau);
        }
        $c_select = new Zend_Form_Element_Select('id_type_creneau');
        $c_select->setLabel('Type créneau *');
        $c_select->setRequired(true);
        $c_select->addMultiOption('', '');
        $c_select->addMultiOptions($type_creneau);
        $this->addElement($c_select);

        $table = new Application_Model_DbTable_EuMembreMorale();
        $select = $table->select();
        $rows = $table->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre_morale;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre", array('label' => 'Numéro membre','size' => 25)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);

        $ng = new Application_Model_DbTable_EuMembre();
        $select = $ng->select();
        $rows = $ng->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre_gestionnaire", array('label' => 'Numéro gestionnaire *','size' => 25)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $elem->setRequired(true);
        $this->addElement($elem);

        $this->addElement('text', 'nom_gestion', array(
            'label' => 'Nom gestionnaire',
            'required' => true,
            'size' => 30,
            'filters' => array('StringTrim'),
			'readonly' => true,
        ));

        $this->addElement('text', 'prenom_gestion', array(
            'label' => 'Prénoms gestionnaire',
            'required' => false,
            'size' => 30,
            'filters' => array('StringTrim'),
			'readonly' => true,
        ));

        $this->addElement('text', 'tel_gestion', array(
            'label' => 'Téléphone gestionnaire',
            'required' => false,
            'filters' => array('StringTrim'),
            //'validators' => array('validator' => 'digits'),
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
                'hidden', 'code_creneau', array(
                )
        );
    }

}
