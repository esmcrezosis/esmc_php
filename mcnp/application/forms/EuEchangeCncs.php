<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuEchange
 *
 * @author USER
 */
class Application_Form_EuEchangeCncs extends Zend_Form {

    //put your code here
    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->setName("fm_membre")->setDisableLoadDefaultDecorators(true)
                ->addDecorator('FormElements')
                ->addDecorator('Form');
        
        $comptes = array();
        $cat_select = new Zend_Form_Element_Select('categorie');
        $cat_select->setLabel('Catégorie:')
                ->setRequired(true);
        $cat_select->addMultiOptions($comptes);
        $this->addElement($cat_select);
        
        $prods = array();
        $prod_auto = new Zend_Form_Element_Select(
                        "compte", array('label' => 'Compte:')
        );
        $prod_auto->setRequired(true);
        $prod_auto->addMultiOptions($prods);
        $this->addElement($prod_auto);

        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAllByType('P');
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "membre", array('label' => 'Membres:')
        );
        $elem->setRequired(true);
        $elem->setAttrib('size','30');
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);
        
        $this->addElement('text', 'nom_membre', array(
            'label' => 'Nom:',
            'size' => 30,
            'readOnly' => true
        ));

        $this->addElement('text', 'prenom_membre', array(
            'label' => 'Prénoms:',
            'size' => 30,
            'readOnly' => true
        ));
        
        $elemb = new ZendX_JQuery_Form_Element_AutoComplete(
                        "membre_benef", array('label' => 'Membres:')
        );
        $elemb->setRequired(true);
        $elemb->setAttrib('size','30');
        $elemb->setJQueryParams(array('source' => $membres));
        $this->addElement($elemb);
        
        $this->addElement('text', 'nom_membre_benef', array(
            'label' => 'Nom:',
            'size' => 30,
            'readOnly' => true
        ));

        $this->addElement('text', 'prenom_membre_benef', array(
            'label' => 'Prénoms:',
            'size' => 30,
            'readOnly' => true
        ));
        
        $this->addElement('text', 'solde_cncs', array(
            'label' => 'Solde du compte:',
            'readonly' => true,
            'size' => '25',
            'style' => 'text-align:right',
            'validators' => array('Digits')
        ));

        $this->addElement('text', 'montant', array(
            'label' => 'Montant:',
            'required' => true,
            'size' => '25',
            'style' => 'text-align:right',
            'validators' => array('Digits')
        ));
        
         $this->addElement('hidden', 'type', array());

        $this->addElement('submit', 'valider', array(
            'ignore' => true,
            'label' => 'Valider',
        ));

        // Add the cancel button
        $this->addElement('reset', 'annuler', array(
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

?>
