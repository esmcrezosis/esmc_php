<?php

class Application_Form_EuFsMf11000 extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */

        $sect_select = new Zend_Form_Element_Select('code_type_compte');
        $sect_select->setLabel('Type de ressource')
                ->isRequired(true);
        $sect = new Application_Model_EuTypeCompteMapper();
        $rows = $sect->fetchAll();
        foreach ($rows as $st) {
            //$sect_select->addMultiOption($st->code_type_compte, $st->code_type_compte);
            $sect_select->addMultiOption('NN', 'NN');
        }
        $this->addElement($sect_select);

        $this->addElement('text', 'solde', array(
            'label' => 'Montant FS *',
            'required' => TRUE,
            'filters' => array('StringTrim'),
            'validators' => array('Digits'),
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

