<?php
class Application_Form_Bnptype extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        
        $this->addElement('text', 'type_bnp', array(
            'label' => 'Type BNP :',
            'required' => true,
			'validators' => array('Digits')
        ));
        
        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->num_membre;
        }
        $elem_be = new ZendX_JQuery_Form_Element_AutoComplete(
                        "benef", array('label' => 'Bénéficiaire:')
        );
        $elem_be->setJQueryParams(array('source' => $membres));
        $this->addElement($elem_be);
        
        $cat_select = new Zend_Form_Element_Select('categorie');
        $cat_select->setLabel('Produit:')
                ->setRequired(true);
        $catmap = new Application_Model_CategorieMapper();
        $rows = $catmap->fetchAllByType();
		$cat_select->addMultiOption('', '');
        foreach ($rows as $c) {
            $cat_select->addMultiOption($c->code_categorie, $c->code_categorie);
        }
        $this->addElement($cat_select);
		
        $prods = array();
        $prod = new Application_Model_EuProduitMapper();
        $rows = $prod->fetchAllByCatgorie();
        foreach ($rows as $c) {
            $prods[] = $c->code_produit;
        }
        $prod_auto = new ZendX_JQuery_Form_Element_AutoComplete(
                        "produit", array('label' => 'Compte:')
        );
        $prod_auto->setJQueryParams(array('source' => $prods));
        $this->addElement($prod_auto);

        $this->addElement('text', 'montant', array(
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
