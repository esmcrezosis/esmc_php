<?php

class Application_Form_EuJustifSalaire extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");

        $this->addElement('text', 'code_demand', array(
            'required' => true,
            'filters' => array('StringTrim'),
            'readonly'=>true,
            'size'=>10
        ));
        
        $ng = new Application_Model_DbTable_EuMembre();
        $select = $ng->select();
        $select->where('type_membre=?', 'P');
        $rows = $ng->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->num_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "num_membre", array('label' => 'Numéro salarié *')
        );
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);

        $this->addElement('text', 'salaire', array('label' => 'Salaire *',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('validator' => 'digits')
        ));

        $this->addElement('button', 'ajout', array(
            'ignore' => true,
            'label' => 'Ajouter',
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
    }

}

