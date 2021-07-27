<?php

class Application_Form_EuDistributeur extends Zend_Form {

    public function init() {

        $this->setMethod("post");

        $nom = new Zend_Form_Element_Text('nom_utilisateur');
        $nom->setLabel('Nom *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');

        $prenom = new Zend_Form_Element_Text('prenom_utilisateur');
        $prenom->setLabel('Prenom *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');

        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');
        
        $type_groupe = new Zend_Form_Element_Select('type_groupe');
        $type_groupe->setLabel('Groupe utilisateur *')->isRequired(true);
        $type_groupe->addMultiOption('', '');
        $type_groupe->addMultiOption('dist', 'Distributeur');
        $type_groupe->addMultiOption('boutique', 'Boutique');

        $pwd = new Zend_Form_Element_Password('pwd');
        $pwd->setLabel('Mot de passe *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');


        $pwd1 = new Zend_Form_Element_Password('pwd1');
        $pwd1->setLabel('Confirmer mot de pass *')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');

        $descr = new Zend_Form_Element_Textarea('description');
        $descr->setLabel('Description  ')
                ->setRequired(false)
                ->addFilter('StripTags')
                ->addFilter('StringTrim');

        $ulock = new Zend_Form_Element_Checkbox('ulock');
        $ulock->setLabel('Désactiver');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $annuler = new Zend_Form_Element_Button('cancel');
        $annuler->setLabel('Annuler');

        $this->addElements(array($nom, $prenom, $login, $pwd, $pwd1,$type_groupe, $descr, $ulock, $submit, $annuler));
        $this->addElement('hidden', 'id_utilisateur');
    }

}

