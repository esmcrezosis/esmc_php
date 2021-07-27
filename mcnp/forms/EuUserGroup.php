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
class Application_Form_EuUserGroup extends Zend_Form {

    //put your code here
    public function init() {

        /* Form Elements & Other Definitions Here ... */

        $this->setMethod("post");


        $code_groupe = new Zend_Form_Element_Text('code_groupe');
        $code_groupe->setLabel('Code *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');


        $libelle_groupe = new Zend_Form_Element_Text('libelle_groupe');
        $libelle_groupe->setLabel('Libellé *')
                ->setRequired(true)
				->setAttrib('size','40')
                ->addFilter('StripTags')
                ->addFilter('StringTrim');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $annuler = new Zend_Form_Element_Button('cancel');
        $annuler->setLabel('Annuler');
        $this->addElements(array($code_groupe, $libelle_groupe, $submit, $annuler));
    }

}

?>
