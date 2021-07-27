<?php

class Application_Form_EuPartenaire extends Zend_Form
{
 public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->addElement('text','code_partenaire',array('label' => 'Code partenaire:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 10))
                )));
        
        $this->addElement('text','type_partenaire',array('label' => 'Type partenaire:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            ));
        
        $this->addElement('select', 'type_partenaire', array('label' => 'Type partenaire:',
            'required' => true,
            'filters' => array('StringTrim'),
            'multiOptions' => array(
                'financier' => 'Financier',
                'technique' => 'Technique',
                'commercial' => 'Commercial',
            )
        ));
        
        $this->addElement('text', 'nom_partenaire', array(
            'label'      => 'Dénomination partenaire:',
            'required'   => FALSE,
        ));
        
         $this->addElement('text','tel_partenaire',array('label' => 'Téléphone partenaire:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            ));
        
        $this->addElement('text', 'bp_partenaire', array(
            'label'      => 'Boite postale:',
            'required'   => FALSE,
        ));
         $this->addElement('text','fax_partenaire',array('label' => 'Fax partenaire:',
            'required'   => FALSE,
            'filters'    => array('StringTrim'),
            ));
        
        $this->addElement('text', 'email_partenaire', array(
            'label'      => 'Email partenaire:',
            'required'   => FALSE,
        ));
                $this->addElement('text', 'interlocuteur', array(
            'label'      => 'Représentant:',
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

