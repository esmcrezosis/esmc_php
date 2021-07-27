<?php

class Application_Form_EuCanton extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement('hidden', 'id_sub_secteur', array());
        
        $this->addElement('text', 'nom_sub_secteur', array(
            'label' => 'Nom *',
            'required' => true,
        ));
        
        $sect_select = new Zend_Form_Element_Select('code_secteur');
        $sect_select->setLabel('Secteur *')
                ->isRequired(true);
        $sect = new Application_Model_DbTable_EuSecteur();
        $select = $sect->select();
        $select->order('eu_secteur.nom_secteur asc');
        $rows = $sect->fetchAll($select);
        $sect_select->addMultiOption('', '');
        foreach ($rows as $st) {
          $sect_select->addMultiOption($st->code_secteur,utf8_encode($st->nom_secteur));
        }
        $this->addElement($sect_select);
		
		
		$agence_select = new Zend_Form_Element_Select('code_agence');
        $agence_select->setLabel('Agence *')
                    ->isRequired(true);
        $sect = new Application_Model_DbTable_EuAgence();
        $select = $sect->select();
        $select->order('eu_agence.libelle_agence asc');
        $rows = $sect->fetchAll($select);
        $sect_select->addMultiOption('', '');
        foreach ($rows as $st) {
          $agence_select->addMultiOption($st->code_agence,utf8_encode($st->libelle_agence));
        }
        $this->addElement($agence_select);
		
		
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Valider',
        ));

        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
        
        $this->addElement('hidden', 'id_utilisateur', array( ));
    }

}

