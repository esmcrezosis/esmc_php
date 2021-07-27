<?php

class Application_Form_EuZone extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->addElement('text', 'nom_zone', array(
            'label' => 'Nom *',
            'required' => true,
            ));
        
        $pays_select = new Zend_Form_Element_Select('code_dev');
        $pays_select->setLabel('Devise *')
                    ->setAttrib("required","true");
        $pays = new Application_Model_DbTable_EuDevise();
        $select = $pays->select();
        $rows = $pays->fetchAll($select);
        
        foreach ($rows as $ps) {
          $pays_select->addMultiOption('', '');
          $pays_select->addMultiOption($ps->code_dev, ucfirst(utf8_encode($ps->lib_dev)));
        }
        $this->addElement($pays_select);
        
        $this->addElement('submit', 'submit', array('ignore'   => true,'label'    => 'Valider',));
        
        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
        $this->addElement(
                'hidden', 'code_zone', array(
        ));
    }


}

