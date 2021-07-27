<?php

class Application_Form_Bnp extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setAttrib('id', 'bnp_form');

        $type_bnp = array('' => '', 'CAIPC' => 'CAIPC', 'CAPU' => 'CAPU', 'CMIT' => 'CMIT', 'CACB' => 'CACB', 'CSCOE' => 'CSCOE');
        $bnp_select = new Zend_Form_Element_Select('type_bnp');
        $bnp_select->setLabel('Type BNP:')
                ->setRequired(true)->addMultiOptions($type_bnp);
        $this->addElement($bnp_select);

        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->num_membre;
        }
        $elem_ap = new ZendX_JQuery_Form_Element_AutoComplete(
                        'apporteur', array('label' => 'Numéro Apporteur:')
        );
        $elem_ap->setJQueryParams(array('source' => $membres));
        $this->addElement($elem_ap);

        $elem_be = new ZendX_JQuery_Form_Element_AutoComplete(
                        "benef", array('label' => 'Numéro Bénéficiaire:')
        );
        $elem_be->setJQueryParams(array('source' => $membres));
        $this->addElement($elem_be);

        $cat_select = new Zend_Form_Element_Select('categorie');
        $cat_select->setLabel('Produit:')
                ->setRequired(true);

        $tmap = new Application_Model_DbTable_Categorie();
        $select = $tmap->select();
        $select->where('code_categorie IN (?)', array('I', 'RPG'));
        $rows = $tmap->fetchAll($select);
        $cat_select->addMultiOption('', '');
        foreach ($rows as $c) {
            $cat_select->addMultiOption($c->code_categorie, $c->code_categorie);
        }
        $this->addElement($cat_select);

        $prods = array();
        $prod = new Application_Model_DbTable_EuProduit();
        $pselect = $prod->select();
        $pselect->where('code_categorie IN (?)', array('TPAGCI', 'TPAGCRPG'))
                ->where('type_produit <> ?','nr');
        $prows = $prod->fetchAll($pselect);
        foreach ($prows as $c) {
            $prods[] = $c->code_produit;
        }
        $prod_auto = new ZendX_JQuery_Form_Element_AutoComplete(
                        'produit', array('label' => 'Compte:')
        );
        $prod_auto->setJQueryParams(array('source' => $prods));
        $this->addElement($prod_auto);

        $this->addElement('text', 'montant', array(
            'label' => 'Montant apporté:',
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
