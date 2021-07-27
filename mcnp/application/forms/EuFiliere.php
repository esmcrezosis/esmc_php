<?php

class Application_Form_EuFiliere extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
		$this->addElement('text', 'code_division', array(
            'size' => 35,
            'label' => 'Code Division *',
            'required' => true,
        ));
		
        $this->addElement('text', 'nom_filiere', array(
            'size' => 35,
            'label' => 'Nom *',
            'required' => true,
        ));
        $this->addElement('textarea', 'descrip_filiere', array(
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
        $this->addElement(
                'hidden', 'id_filiere', array(
        ));
    }

}

