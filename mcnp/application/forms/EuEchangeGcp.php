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
class Application_Form_EuEchangeGcp extends Zend_Form {

    //put your code here
    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->setName("fm_membre")->setDisableLoadDefaultDecorators(true)
                ->addDecorator('FormElements')
                ->addDecorator('Form');

        $this->addElement('hidden', 'cat', array());
        $this->addElement('text', 'categorie', array(
            'label' => 'Echange du :',
            'required' => true)
        );

        $prods = array();
        $prod_auto = new Zend_Form_Element_Select(
                "compte", array('label' => 'Compte:')
        );
        $prod_auto->setRequired(true);
        $prod_auto->addMultiOptions($prods);
        $this->addElement($prod_auto);

        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAllByType('M');
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elemm = new ZendX_JQuery_Form_Element_AutoComplete(
                "membre", array('label' => 'Code Membre PM:')
        );
        $elemm->setRequired(true);
        $elemm->setAttrib('size', 30);
        $elemm->setJQueryParams(array('source' => $membres));
        $this->addElement($elemm);
        $this->addElement('text', 'raison_sociale', array(
            'label' => 'Raison sociale:',
            'size' => 30,
            'readOnly' => true
        ));
        
        $this->addElement('text', 'nom_membrem', array(
            'label' => 'Nom:',
            'size' => 30,
            'readOnly' => true
        ));

        $this->addElement('text', 'prenom_membrem', array(
            'label' => 'Prénoms:',
            'size' => 30,
            'readOnly' => true
        ));
        
        $membresp = array();
        $elemp = new ZendX_JQuery_Form_Element_AutoComplete(
                "membrep", array('label' => 'Code Membre PP')
        );
        $elemp->setAttrib('size', 30);
        $elemp->setJQueryParams(array('source' => $membresp));
        $this->addElement($elemp);

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
        
        $this->addElement('text', 'solde', array(
            'label' => 'Solde du compte:',
            'readonly' => true,
            'style' => 'text-align:right',
            'validators' => array('Digits')
        ));

        $this->addElement('text', 'montant', array(
            'label' => 'Montant:',
            'required' => true,
            'style' => 'text-align:right',
            'validators' => array('Digits')
        ));

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
