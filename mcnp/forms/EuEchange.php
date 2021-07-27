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
class Application_Form_EuEchange extends Zend_Form {

    //put your code here
    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");

        $this->addElement('text', 'cat_echange', array(
            'label' => 'Echange du:',
            'required' => true)
        );

        $this->addElement('text', 'categorie', array(
            'label' => 'Categorie:',
            'required' => true)
        );
        
        $this->addElement('text', 'compte', array(
            'label' => 'Compte:',
            'required' => true)
        );

        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAllByType('M');
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "membre", array('label' => 'Membres:')
        );
        $elem->setRequired(true);
        $elem->setAttrib('size',30);
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);
        $this->addElement('text', 'raison_sociale', array(
            'label' => 'Raison sociale:',
            'size' => 30,
            'readOnly' => true
        ));
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

        $this->addElement('text', 'montant', array(
            'label' => 'Montant:',
            'style' => 'text-align:right',
            'required' => true,
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
            'type' => 'reset'
        ));
    }

}

?>
