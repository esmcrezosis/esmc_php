<?php

class Application_Form_EuNn extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here */
        $sect_select = new Zend_Form_Element_Select('code_type_nn');
        $sect_select->setLabel('Type NN')
                    ->isRequired(true);
        $sect = new Application_Model_DbTable_EuTypeNn();
        $select = $sect->select();
		$select->where('code_type_nn IN (?)',array('FCPS','FL','FS'));
		
        $rows = $sect->fetchAll($select);
        foreach ($rows as $st) {
            $sect_select->addMultiOption('', '');
            $sect_select->addMultiOption($st->code_type_nn,ucfirst(utf8_encode($st->lib_type_nn)));
        }
        $this->addElement($sect_select);

        $this->addElement('text', 'montant_emis', array(
            'label' => 'Montant NN *',
            'required' => TRUE,
            'filters' => array('StringTrim'),
            'validators' => array('Digits'),
        ));
        $this->addElement('submit','submit',array('ignore'=> true,'label'=>'Valider'));

        // Add the cancel button
        $this->addElement('button', 'cancel', array('ignore' => true,'label' => 'Annuler'));
    }

}

