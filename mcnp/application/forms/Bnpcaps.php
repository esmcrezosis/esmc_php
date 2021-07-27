<?php

class Application_Form_Bnpcaps extends Zend_Form {

    public function init() {
        $this->setMethod("post");

        $this->addElement('text', 'type_bnp', array(
            'label' => 'Type BNP :',
            'required' => true
        ));

        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elem_ap = new ZendX_JQuery_Form_Element_AutoComplete("apport", array('label' => 'Numéro apporteur:'));
        $elem_ap->setJQueryParams(array('source' => $membres));
        $this->addElement($elem_ap);

        $this->addElement('text', 'montant', array(
            'label' => 'Montant:',
            'required' => true,
            'validators' => array('Digits')
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
