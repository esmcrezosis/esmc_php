<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_EuTypeActeur  extends Zend_Form
{
    
    public function init()
    {
       /* Form Elements & Other Definitions Here ... */
        
       $this->addElement('hidden', 'id_type_acteur'); 
       $this->addElement('text', 'lib_type_acteur', array(
            'label' => 'Type acteur :',
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

