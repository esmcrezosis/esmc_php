<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuUserGroup
 *
 * @author USER
 */
class Application_Form_EuTypeCompte extends Zend_Form {

    //put your code here
    public function init() {

        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");

        $code_type_compte = new Zend_Form_Element_Text('code_type_compte');
        $code_type_compte->setLabel('Code *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');
		
				
	    $lib_type = new Zend_Form_Element_Text('lib_type');
        $lib_type->setLabel('Libellé *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');
		
				
		$desc_type = new Zend_Form_Element_Text('desc_type');
        $desc_type->setLabel('Description ')
                  ->setRequired(false)
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim');					
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $annuler = new Zend_Form_Element_Button('cancel');
        $annuler->setLabel('Annuler');
        $this->addElements(array($code_type_compte, $lib_type, $desc_type,$submit, $annuler));
    }


}


?>
