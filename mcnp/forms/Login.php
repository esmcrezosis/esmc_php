<?php

class Application_Form_Login extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement(
                'text', 'login', array(
            'label' => 'Login:',
            'required' => true,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('password', 'pwd', array(
            'label' => 'Mot de passe:',
            'required' => true,
        ));
        
        $sub = new Zend_Form_Element_Submit('submit');
        $sub->setLabel('Connecter');
        $this->addElement($sub);

        $ann = new Zend_Form_Element_Button('cancel');
        $ann->setLabel('Annuler');
        $this->addElement($ann);
    }

}

