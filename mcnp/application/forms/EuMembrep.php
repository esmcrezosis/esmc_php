<?php

class Application_Form_EuMembrep extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("fm_membre")->setDisableLoadDefaultDecorators(true)
                ->addDecorator('FormElements')
                ->addDecorator('Form');

        $this->addElement('text', 'code_membre', array('label' => 'Numéro d\'identité:',
            'required' => true,
            'size' => 30,
            'readonly' => true,
            'filters' => array('StringTrim'),
            'validators' => array(array('validator' => 'StringLength', 'options' => array(0, 25)))));

        $this->addElement('text', 'nom_membre', array('label' => 'Nom:',
            'required' => true,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('text', 'prenom_membre', array('label' => 'Prenom:',
            'required' => true,
            'filters' => array('StringTrim'),
        ));
		
        $this->addElement('select', 'sexe_membre', array('label' => 'Sexe:',
            'required' => true,
            'filters' => array('StringTrim'),
            'multiOptions' => array(
                'M' => 'Masculin',
                'F' => 'Féminin',
            )
        ));
		
        $this->addElement('text', 'date_nais_membre', array('label' => 'Date de naissance:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('text', 'lieu_nais_membre', array('label' => 'Lieu de naissance:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
		
        $this->addElement('select', 'sitfam_membre', array('label' => 'Situation familiale:',
            'required' => FALSE,
            'filters' => array('StringTrim'), 'multiOptions' => array(
                'C' => 'Célibataire',
                'M' => 'Marié(e)',
                'D' => 'Divorcé(e)',
                'V' => 'Veuf(ve)',
            )
        ));
		
        $this->addElement('text', 'nbr_enf_membre', array('label' => 'Nombre d\'enfant:',
            'required' => False,
            'filters' => array('StringTrim'),
        ));

        $t_pays = new Application_Model_DbTable_EuPays();
        $pays = $t_pays->fetchAll();
        $pays_select = new Zend_Form_Element_Select('id_pays');
        $pays_select->setLabel('Nationalité:')->isRequired(true);
        foreach ($pays as $p) {
            $pays_select->addMultiOption($p->id_pays, $p->nationalite);
        }
        $this->addElement($pays_select);

        $this->addElement('text', 'pere_membre', array('label' => 'Nom du père:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
        $this->addElement('text', 'mere_membre', array('label' => 'Nom de la mère:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));

        $t_religion = new Application_Model_DbTable_EuReligion();
        $results = $t_religion->fetchAll();
        $rel_select = new Zend_Form_Element_Select('id_religion_membre');
        $rel_select->setLabel('Religion:')->isRequired(true);
        foreach ($results as $c) {
            $rel_select->addMultiOption($c->id_religion_membre, utf8_encode($c->libelle_religion));
        }
        $this->addElement($rel_select);

        $this->addElement('text', 'profession_membre', array('label' => 'Profession:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
        $this->addElement('text', 'formation', array('label' => 'Formation:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('text', 'quartier_membre', array('label' => 'Quartier de résidence:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
        $this->addElement('text', 'ville_membre', array('label' => 'Ville:',
            'required' => true,
            'filters' => array('StringTrim'),
        ));
        $this->addElement('text', 'bp_membre', array('label' => 'BP:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
        $this->addElement('text', 'tel_membre', array('label' => 'Numéro de téléphone:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
        $this->addElement('text', 'email_membre', array('label' => 'Email:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
        $this->addElement('text', 'portable_membre', array('label' => 'Numero portable:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
        
        

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Valider',
        ));

        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));

        foreach ($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
            $element->removeDecorator('Label');
        }
    }

}

