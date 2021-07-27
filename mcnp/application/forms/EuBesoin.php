<?php

class Application_Form_EuBesoin extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        
     
        $this->addElement('text', 'delai_paie', array('label' => 'Delai de la paie:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 10))
                )));
        $this->addElement('text', 'objet_besoin', array('label' => 'Designation besoin:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 20))
                )));
        $this->addElement('text', 'qte_objet', array('label' => 'Quantité:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 5))
                )));
        $this->addElement('button', 'ajout', array(
            'ignore'   => true,
            'label'    => 'Ajouter',
            ));
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Valider',
            ));
        
        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
    }

}


