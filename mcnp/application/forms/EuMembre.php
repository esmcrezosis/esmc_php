<?php

class Application_Form_EuMembre extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("fm_membre")->setDisableLoadDefaultDecorators(true)
             ->addDecorator('FormElements')
             ->addDecorator('Form');

        $this->addElement('text', 'code_membre_morale', array('label' => 'Numéro d\'identité:',
            'required' => true,
            'size' => 30,
            'readonly'=> true,
            'filters' => array('StringTrim'),
            'validators' => array(array('validator' => 'StringLength', 'options' => array(0,25))
        )));

        $this->addElement('select', 'code_type_acteur', array('label' => 'Type d\'acteur:',
            'required' => true,
            'filters' => array('StringTrim'), 'multiOptions' => array(
               'EI' => 'Entreprises et Industries',
               'OSE' => 'Operateurs socio-économiques',
               'PEI' => 'Partenaires Entreprises et Industries',
               'POSE' => 'Partenaires Opérateurs socio-économiques'
            )
        ));
		
        $t_statut = new Application_Model_DbTable_EuStatutJuridique();
        $statuts = $t_statut->fetchAll();
        $statut_select = new Zend_Form_Element_Select('code_statut');
        $statut_select->setLabel('Statut juridique:')->isRequired(true);
        foreach ($statuts as $p) {
            $statut_select->addMultiOption($p->code_statut, $p->libelle_statut);
        }
        $this->addElement($statut_select);
        
		
        $this->addElement('text', 'raison_sociale', array('label' => 'Raison sociale:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));

        
        $this->addElement('text', 'domaine_activite', array('label' => 'Domaine d\'activite:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
            'size' => 45
        ));
        
		$pays = new Application_Model_DbTable_EuPays();
        $donnees = $pays->fetchAll();
        $pays_select = new Zend_Form_Element_Select('id_pays');
        $pays_select->setLabel('Pays :')->isRequired(true);
        foreach ($donnees as $p) {
            $pays_select->addMultiOption($p->id_pays, $p->libelle_pays);
        }
        $this->addElement($pays_select);
		
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
		
		
        $this->addElement('text', 'site_web', array('label' => 'Site web:',
            'required' => FALSE,
            'filters' => array('StringTrim'),
        ));
        
		
        $this->addElement('text', 'num_registre_membre', array('label' => 'Numéro Registre:',
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

