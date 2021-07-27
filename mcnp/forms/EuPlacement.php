<?php

class Application_Form_EuPlacement extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->num_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "num_membre", array('label' => 'Numéro membre:')
        );

        $elem->setRequired(true);
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);
        $cat_select = new Zend_Form_Element_Select('ressource');
        $cat_select->setLabel('Produits:')
                ->setRequired(true);
        $options = array('I' => 'I', 'RPG' => 'RPG', 'CNCS' => 'CNCS');
        $cat_select->addMultiOption('', '');
        foreach ($rows as $c) {
            $cat_select->addMultiOptions($options);
        }
        $this->addElement($cat_select);

        $prods = array('nr' => 'nr', 'r' => 'r');
        $prod_auto = new Zend_Form_Element_Select(
                        "categorie", array('label' => 'Catégorie:')
        );
        $prod_auto->setRequired(true);
        $prod_auto->addMultiOptions($prods);
        $this->addElement($prod_auto);

        $this->addElement('text', 'montant_op', array(
            'label' => 'Montant:',
            'required' => true,
            'validators' => array('Digits')
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
    }

}

