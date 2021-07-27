<?php

 class Application_Form_EuMdv extends Zend_Form
{
     
     public function init()
     {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        
        $this->addElement('hidden', 'id_mdv');
        // $this->addElement('hidden', 'duree_vie');
         
        $type_unite = array('jour' => 'Jour', 'mois' => 'Mois', 'annee' => 'Année');
        $unit_select = new Zend_Form_Element_Select('unite_mdv');
        $unit_select->setLabel('Unité de durée *')
                ->setRequired(true)
                ->addMultiOptions($type_unite);
        $this->addElement($unit_select);
        
        $this->addElement('text', 'duree_vie', array(
            'label' => 'Durée de vie',
            'required' => true,
            'validators'=>array('validator' => 'digits'),
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
