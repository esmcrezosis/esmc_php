<?php
class Application_Form_EuStand extends Zend_Form
{
      public function init()
      {
          /* Form Elements & Other Definitions Here ... */
          $this->setMethod('post');
        
          $this->addElement('hidden', 'id_stand');
         
          $this->addElement('text', 'design_stand', array(
            'label' => 'Désignation ',
            'required' => true
          ));
          
          $this->addElement('textarea', 'description', array(
            'label' => 'Description ',
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
?>
