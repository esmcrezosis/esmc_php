<?php

class Application_Form_EuPrkForm extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement('hidden', 'id_prk');

        $t_type_credit = new Application_Model_DbTable_EuTypeCredit();
        $rows = $t_type_credit->fetchAll();
        $t_options = array();
        $t_credit = new Zend_Form_Element_Select('code_type_credit');
        $t_credit->setLabel('Code Type Crédit:')
                ->setRequired(true);
        $t_credit->addMultiOption('', '');
        foreach ($rows as $c) {
            $t_options[$c->CODE_TYPE_CREDIT] = $c->LIB_TYPE_CREDIT;
        }
        $t_credit->addMultiOptions($t_options);
        $this->addElement($t_credit);


        $cat_select = new Zend_Form_Element_Select('id_type_acteur');
        $cat_select->setLabel('Acteurs:')
                ->setRequired(true);
        $options = array('', '','1' => 'Gossistes', '2' => 'Semi-grossistes', '3' => 'Détaillants', '4' => 'Consommateurs');
        $cat_select->addMultiOptions($options);
        $this->addElement($cat_select);

        $montant = new Zend_Form_Element_Text('valeur');
        $montant->setLabel('Valeur *:')
                ->setRequired(true)
                ->addFilter('StripTags');
        $this->addElement($montant);


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

