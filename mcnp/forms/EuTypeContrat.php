<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_EuTypeContrat extends Zend_Form
{
    
    public function init()
    {
       /* Form Elements & Other Definitions Here ... */
        
       $this->addElement('hidden', 'id_type_contrat'); 
       $this->addElement('text', 'libelle_type_contrat', array(
            'label' => 'Type contrat :',
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
