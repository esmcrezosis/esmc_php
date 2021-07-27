<?php

class Application_Form_EuConsommation extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $m_mapper = new Application_Model_EuMembreMapper();
        $rows = $m_mapper->fetchAllByType('M');
        $membres = array();
        foreach ($rows as $mb) {
            $membres[] = $mb->num_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "vendeur", array('label' => 'Distributeur:',
                    'required' => true,
                    'filters' => array('StringTrim'))
        );
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);

        $produit = new Application_Model_DbTable_EuProduit();
        $p_select = $produit->select();
        $p_select->where('code_categorie NOT IN (?)',array('TCNCS','TCNCSEI','TPAGCP'));
        $produits = $produit->fetchAll($p_select);
        $produit_select = new Zend_Form_Element_Select('produit');
        $produit_select->setLabel('Produit:')
                ->isRequired(true);
        $produit_select->addMultiOption('', '');
        foreach ($produits as $p) {
            $produit_select->addMultiOption($p->code_produit, $p->code_produit);
        }
        $this->addElement($produit_select);

        $m_mapper = new Application_Model_EuMembreMapper();
        $rows = $m_mapper->fetchAll();
        $membres = array();
        foreach ($rows as $mb) {
            $membres[] = $mb->num_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "acheteur", array('label' => 'Acheteur:',
                    'required' => true)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);

        $this->addElement(
                'text', 'montant', array(
            'label' => 'Montant:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array('Digits'),
                )
        );

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

