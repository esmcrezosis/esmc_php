<?php

class Application_Form_EuCategorieCompte extends Zend_Form {

    //put your code here
    public function init() {

        $this->setMethod('post');
        $this->addElement(
                'text', 'code_cat', array(
            'label' => 'Code *',
            'required' => true,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('text', 'lib_cat', array(
            'label' => 'Libellé *',
            'required' => true,
            'class' => 'text',
            'filters' => array('StringTrim'),
        ));

        $this->addElement('textarea', 'desc_cat', array(
            'label' => 'Description',
            'required' => false,
            'filters' => array('StringTrim'),
        ));

        $type_select = new Zend_Form_Element_Select('code_type_compte');
        $type_select->setLabel('Type de Numérique *')
                ->isRequired(true);
        $t_type = new Application_Model_DbTable_EuTypeCompte();
        $rows = $t_type->fetchAll();
        foreach ($rows as $st) {
            $type_select->addMultiOption('', '');
            $type_select->addMultiOption($st->code_type_compte, $st->desc_type);
        }
        $this->addElement($type_select);

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

?>
