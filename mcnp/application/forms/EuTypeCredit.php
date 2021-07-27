<?php

class Application_Form_EuTypeCredit extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement('text', 'code_type_credit', array(
            'label' => 'Code type credit:',
            'required' => true)
        );

        $this->addElement('text', 'lib_type_credit', array(
            'label' => 'Libellé credit:',
            'required' => true,
            'size' => 32)
        );


        $cat_select = new Zend_Form_Element_Select('code_cat_produit');
        $cat_select->setLabel('Categorie produit:')
                ->setRequired(true);
        $options = array('IMM' => 'IMM', 'CNPC' => 'Carburant', 'CNPF' => 'Factures', 'CNPG' => 'Consommations générales');
        $cat_select->addMultiOption('', '');
        $cat_select->addMultiOptions($options);
        $this->addElement($cat_select);


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

