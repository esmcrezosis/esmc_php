<?php

class Application_Form_EuGammeProduit extends Zend_Form
{
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
                 
         $this->addElement('text', 'code_gamme', array(
            'label' => 'Code de la gamme *',
            'required' => true,
            ));    
              
         $this->addElement('text', 'design_gamme', array(
            'label' => 'Nom de la gamme *',
            'required' => true,
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