<?php
class Application_Form_EuPck extends Zend_Form {

       public function init() {
           
              /* Form Elements & Other Definitions Here ... */
              $this->setMethod('post');
             
              $this->addElement(
                'text', 'code_param', array(
                'label' => 'Code *',
                'readonly' => true,
                'value' => 'PRK',
              ));
              
              $this->addElement('text', 'lib_param', array(
              'label' => 'Libellé *',
              'required' => true,
        ));
              
//        $this->addElement('text', 'montant', array(
//            'label' => 'Montant *',
//            'required' => true,
//            'filters' => array('StringTrim'),
//            'validators' => array('validator' => 'float'),
//        ));
     
        $montant = new Zend_Form_Element_Text('montant');
        $montant->setLabel('Montant *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('float', true, array('locale' => 'en_US'));
        $this->addElement($montant);

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

