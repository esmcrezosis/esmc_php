<?php
class Application_Form_EuObjetType extends Zend_Form {
    
    
     public function init() {
        $this->setMethod("post");
        $this->addElement('select', 'type_boutique', array('label' => 'Type de boutique:',
            'required' => true,
            'filters' => array('StringTrim'), 'multiOptions' => array(
                'BS' => 'Boutique simple',
                'BC' => 'Boutique complexe'
            )
        ));
        
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Valider',
        ));

        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
     }
    
    
    
    
}
?>
