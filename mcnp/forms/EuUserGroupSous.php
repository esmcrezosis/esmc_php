<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuUserGroupSous
 *
 * @author USER
 */
class Application_Form_EuUserGroupSous extends Zend_Form {

    //put your code here
    public function init() {

        /* Form Elements & Other Definitions Here ... */

        $this->setMethod("post");


        $code_groupe_sous = new Zend_Form_Element_Text('code_groupe_sous');
        $code_groupe_sous->setLabel('Code *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');


        $libelle_groupe_sous = new Zend_Form_Element_Text('libelle_groupe_sous');
        $libelle_groupe_sous->setLabel('Libellé *')
                ->setRequired(true)
				->setAttrib('size','40')
                ->addFilter('StripTags')
                ->addFilter('StringTrim');


        $groupe = new Application_Model_EuUserGroupMapper();
        $rows = $groupe->fetchAll();
        $usergroup = new Zend_Form_Element_Select('code_groupe', array('separator' => ' '));
        $usergroup->setLabel('Groupe *')
                  ->isRequired(true);
        
        
        foreach ($rows as $c) {
            $usergroup->addMultiOption($c->code_groupe, $c->libelle_groupe);
        }


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $annuler = new Zend_Form_Element_Button('cancel');
        $annuler->setLabel('Annuler');
        $this->addElements(array($code_groupe_sous, $libelle_groupe_sous, $usergroup, $submit, $annuler));
    }

}

?>
