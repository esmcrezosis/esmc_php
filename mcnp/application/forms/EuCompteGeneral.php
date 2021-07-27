<?php

class Application_Form_EuCompteGeneral extends Zend_Form
{

  public function init()
  {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->addElement('text','num_compte',array('label' => 'Numéro du compte:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 10))
                )));
        
        $sect_select = new Zend_Form_Element_Select('code_type');
        $sect_select->setLabel('Code type:')
                ->isRequired(true);
        $sect =  new Application_Model_EuTypeCompteMapper();
        $rows = $sect->fetchAll();
        foreach ($rows as $st) {
            $sect_select->addMultiOption($st->code_type, $st->lib_type);
        } 
        $this->addElement($sect_select);
        
        $this->addElement(
                'select', 'service', array(
                'label' => 'Service ',
                'required' => true,
                'filters' => array('StringTrim'),
                'multiOptions' => array(
                'E' => 'Entrée',
                'S' => 'Sortie'
            )
                )
        );
        
        $this->addElement('text','intitule',array('label' => 'Intitulé du compte:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            ));
        
        $this->addElement('text', 'montant', array(
            'label'      => 'Montant du compte:',
            'required'   => FALSE,
        ));
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Valider',
        ));
        
         // Add the cancel button
    $this->addElement('button', 'cancel', array(
        'ignore'   => true,
        'label'    => 'Annuler',
      )); 
    }
}

