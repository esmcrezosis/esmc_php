<?php

class Application_Form_Categorie extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->addElement('text', 'code_categorie', array('label' => 'Code:',
            'required' => true,
            'filters' => array('StringTrim'),
            'class' => 'text',
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 10))
                )));

        $this->addElement('text', 'libelle_categorie', array('label' => 'Libelle:',
            'required' => true,
            'filters' => array('StringTrim'),
            'class' => 'text'
        ));

        $this->addElement('textarea', 'description_categorie', array(
            'label' => 'Description:',
            'required' => FALSE,
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

