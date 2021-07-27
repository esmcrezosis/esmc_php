<?php

class Application_Form_EuActeurCreneau extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");

        $this->addElement(
                'text', 'nom_acteur', array(
            'label' => 'Nom *',
            'required' => true,
            'size' => 35,
            'filters' => array('StringTrim'),
                )
        );

        $type_acteur = array();
        $c_mapper = new Application_Model_DbTable_EuTypeActeur();
        $select = $c_mapper->select();
        $select->order('lib_type_acteur', 'ASC');
        $typea = $c_mapper->fetchAll($select);
        foreach ($typea as $value) {
            $type_acteur[$value->id_type_acteur] = ucfirst($value->lib_type_acteur);
        }
        $a_select = new Zend_Form_Element_Select('id_type_acteur');
        $a_select->setLabel('Type acteur *');
        $a_select->setRequired(true);
        $a_select->addMultiOption('', '');
        $a_select->addMultiOptions($type_acteur);
        $this->addElement($a_select);

        $table = new Application_Model_DbTable_EuMembreMorale();
        $select = $table->select();
        $rows = $table->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre_morale;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre", array('label' => 'Numéro membre *','size' => 28)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $elem->setRequired(true);
        $this->addElement($elem);
      
        $activite = array();
        $a_mapper = new Application_Model_DbTable_EuActivite();
        $select = $a_mapper->select();
        $select->order('nom_activite', 'ASC');
        $typea = $a_mapper->fetchAll($select);
        foreach ($typea as $value) {
            $activite[$value->code_activite] = ucfirst($value->nom_activite);
        }
        $act = new Zend_Form_Element_Select('code_activite');
        $act->setLabel('Activité *');
        $act->setRequired(true);
        $act->addMultiOption('', '');
        $act->addMultiOptions($activite);
        $this->addElement($act);

        $this->addElement('button', 'add', array(
            'ignore' => true,
            'label' => 'Ajouter',
        ));

        $ng = new Application_Model_DbTable_EuMembre();
        $select = $ng->select();
        $rows = $ng->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre_gestionnaire", array('label' => 'Numéro gestionnaire *','size' => 28)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $elem->setRequired(true);
        $this->addElement($elem);

        $this->addElement('text', 'nom_gestion', array(
            'label' => 'Nom gestionnaire *',
            'required' => false,
            'size' => 28,
            'filters' => array('StringTrim'),
            'readonly' => true,
        ));

        $this->addElement('text', 'prenom_gestion', array(
            'label' => 'Prénoms gestionnaire',
            'required' => false,
            'size' => 28,
            'filters' => array('StringTrim'),
            'readonly' => true,
        ));

        $this->addElement('text', 'tel_gestion', array(
            'label' => 'Téléphone gestionnaire',
            'required' => false,
            'size' => 28,
            'filters' => array('StringTrim'),
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
                'hidden', 'code_acteur', array(
                )
        );
        foreach ($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
            $element->removeDecorator('Label');
        }
    }

}
