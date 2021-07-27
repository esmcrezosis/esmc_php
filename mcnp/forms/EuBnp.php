<?php

class Application_Form_EuBnp extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setAttrib('id', 'bnp_form');
        $this->setName("fm_membre")->setDisableLoadDefaultDecorators(true)
                ->addDecorator('FormElements')
                ->addDecorator('Form');

        $this->addElement('text', 'type_bnp', array(
            'label' => 'Type BNP:',
            'required' => false,
            'filters' => array('StringTrim')
        ));

        $mode_select = new Zend_Form_Element_Select('mode_fin');
        $mode_select->setLabel('Mode de financement:');
        $mode_select->addMultiOptions(array('SMS' => 'Transfert SMS'));
        $this->addElement($mode_select);

        $elem_ap = new ZendX_JQuery_Form_Element_AutoComplete(
                'code_membre_app', array('label' => 'Code Apporteur:')
        );
        $elem_ap->setAttrib('size', '30');
        $this->addElement($elem_ap);

        $this->addElement('text', 'raison_app', array(
            'label' => 'Raison sociale :',
            'required' => false,
            'size' => 30,
            'readonly' => true,
            'filters' => array('StringTrim')
        ));
        $this->addElement('text', 'nom_rep_app', array(
            'label' => 'Nom:',
            'required' => false,
            'readonly' => true,
            'size' => 30,
            'filters' => array('StringTrim')
        ));
        $this->addElement('text', 'prenom_rep_app', array(
            'label' => 'Prénoms:',
            'required' => false,
            'readonly' => true,
            'size' => 30,
            'filters' => array('StringTrim')
        ));


        $elem_be = new ZendX_JQuery_Form_Element_AutoComplete(
                "code_membre_benef", array('label' => 'Code Bénéficiaire:')
        );

        $elem_be->setAttrib('size', '30');
        $this->addElement($elem_be);

        $this->addElement('text', 'raison_benef', array(
            'label' => 'Raison sociale :',
            'readonly' => true,
            'required' => false,
            'size' => 30,
            'filters' => array('StringTrim')
        ));
        $this->addElement('text', 'nom_rep_benef', array(
            'label' => 'Nom:',
            'required' => false,
            'readonly' => true,
            'size' => 30,
            'filters' => array('StringTrim')
        ));
        $this->addElement('text', 'prenom_rep_benef', array(
            'label' => 'Prénoms:',
            'required' => false,
            'readonly' => true,
            'size' => 30,
            'filters' => array('StringTrim')
        ));

        $prod_auto = new Zend_Form_Element_Select(
                'produit', array('label' => 'Produit:')
        );
        $prod_auto->addMultiOptions(array('' => '', 'I' => 'Investissement', 'RPG' => 'RPG'));
        $this->addElement($prod_auto);

        $cat_select = new Zend_Form_Element_Select('categorie');
        $cat_select->setLabel('Catégorie:')
                ->setRequired(true);
        $cat_select->addMultiOptions(array('' => '', 'r' => 'Récurrent', 'nr' => 'Non Récurrent'));
        $this->addElement($cat_select);

        $type_nn = new Zend_Form_Element_Select('type_nn');
        $type_nn->setLabel('Type de NN:');
        $type_nn->addMultiOptions(array('CMIT' => 'CMIT', 'CAPU' => 'CAPU', 'CAIPC' => 'CAIPC', 'GCP' => 'GCP'));
        $this->addElement($type_nn);

        $this->addElement('text', 'code_sms', array(
            'label' => 'Code SMS:'
        ));

        $this->addElement('text', 'montant', array(
            'label' => 'Montant apporté:',
            'required' => true,
            'validators' => array('Digits')
        ));
        
        $this->addElement('text', 'code_dev', array(
            'label' => 'Crédit:',
            'required' => false,
            'readonly' => true,
            'value' => 'XOF'
        ));

        $this->addElement('text', 'credit', array(
            'label' => 'Crédit:',
            'required' => false,
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

        foreach ($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
            $element->removeDecorator('Label');
        }
    }

}
