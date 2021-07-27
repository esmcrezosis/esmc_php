<?php

class Application_Form_EuProduit extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->addElement('text', 'code_produit', array('label' => 'Code:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 10))
                )));

        $this->addElement('text', 'libelle_produit', array('label' => 'Libellé:',
            'required' => true,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('textarea', 'description_produit', array(
            'label' => 'Description:',
            'required' => FALSE,
        ));
        
        $type = new Zend_Form_Element_Select('type_produit');
        $type->setLabel('Type du produit:')
                ->setRequired(true)->addMultiOptions(array('r' =>'récurrent','nr' => 'Non récurrent'));
        $this->addElement($type);

        $cat = new Zend_Form_Element_Select('code_categorie');
        $cat->setLabel('Catégorie:')
                ->setRequired(true);
        $prod = new Application_Model_EuCategorieCompteMapper();
        $rows = $prod->fetchAll();
        foreach ($rows as $c) {
            $cat->addMultiOption($c->code_cat, $c->code_cat);
        }
        $this->addElement($cat);

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

