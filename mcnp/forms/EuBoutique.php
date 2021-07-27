<?php

class Application_Form_EuBoutique extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
         $this->setMethod('post');

         $this->addElement(
            'text', 'code_bout', array(
                'label' => 'Code *',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));

        $this->addElement('text', 'design_bout', array(
            'label' => 'Raison sociale *',
            'required' => true,
            ));
        
        $this->addElement('text', 'telephone', array(
            'label' => 'Téléphone *',
            'required' => true,
            'filters' => array('StringTrim'),
            ));
        
        $this->addElement('text', 'adresse', array(
            'label' => 'Adresse *',
            'required' => true,
            'filters' => array('StringTrim'),
            ));
        
        $ms = new Application_Model_EuSecteurMapper();
        $secteur = $ms->fetchAll();
        $z_select = new Zend_Form_Element_Select('codesect');
        $z_select->setLabel('Nom secteur *: ')->isRequired(true);
        foreach ($secteur as $s) {
            $z_select->addMultiOption($s->codesect, $s->nomsect);
        }
        $this->addElement($z_select);
        
        $this->addElement('text', 'nom_responsable', array(
            'label' => 'Nom responsable*:',
            'required' => true,
            'filters' => array('StringTrim'),
            ));
        
        $this->addElement('text', 'prenom_responsable', array(
            'label' => 'Prenom responsable*:',
            'required' => true,
            'filters' => array('StringTrim'),
            ));
        
       // $nm = new Application_Model_DbTable_EuMembre();
      // $select = $nm->select();
      //  $select->where('type_membre=?', 'M');
      //  $rows = $nm->fetchAll($select);
      //  $membres = array();
      //  foreach ($rows as $c) {
      //      $membres[] = $c->num_membre;
      //  }
      //  $elem = new ZendX_JQuery_Form_Element_AutoComplete(
      //                  "proprietaire", array('label' => 'Numéro membre *')
      //  );
      //  $elem->setJQueryParams(array('source' => $membres));
      //  $this->addElement($elem);
        
        
        $this->addElement('text', 'mail', array(
            'label' => 'E-Mail:',
            'required' => false,
            'filters' => array('StringTrim'),
            ));
        
        $this->addElement('text', 'siteweb', array(
            'label' => 'Site web:',
            'required' =>false,
            'filters' => array('StringTrim'),
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