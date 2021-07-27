<?php

class Application_Form_EuObjetNsub extends Zend_Form
{
    public function init()
   {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
       
        $this->addElement(
            'text', 'code_objet', array(
                'label' => 'Code *',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));
         
        $this->addElement('text', 'design_objet', array(
            'label' => 'Designation *',
            'required' => true,
            ));
       
       $this->addElement('text', 'duree_vie', array(
            'label' => 'Durée de vie (jours) *',
            'required' => true,
            'validators'=>array('validator' => 'digits'),
            )); 
        
        $gamme_select = new Zend_Form_Element_Select('num_gamme');
        $gamme_select->setLabel('Gamme de produit *')
                ->setRequired(true);
        $gammemap = new Application_Model_EuGammeProduitMapper();
        $rows = $gammemap->fetchAll();
        foreach ($rows as $c) {
            $gamme_select->addMultiOption($c->code_gamme, $c->design_gamme);
        }
        $this->addElement($gamme_select);
        
        $this->addElement('text', 'pu_objet', array(
            'label' => 'Prix unitaire *',
            'required' => true,
            'validators'=>array('validator' => 'digits'),
            ));
        
        $this->addElement('text', 'qte_stock', array(
            'label' => 'Quantité *',
            'size' => '7',
            'required' => true,
            'validators'=>array('validator' => 'digits'),
            ));
            
        $this->addElement('textarea', 'caract_objet', array(
            'label' => 'Caractéristique ',
            'required' => false,
            ));
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Valider',
            ));
        
        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
    }
}