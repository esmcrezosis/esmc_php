<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_EuTypeCreneau extends Zend_Form
{
    
    public function init()
    {
       /* Form Elements & Other Definitions Here ... */
        
       $this->addElement('hidden', 'id_type_creneau'); 
       $this->addElement('text', 'libelle_type_creneau', array(
            'label' => 'Type creneau :',
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
?>
