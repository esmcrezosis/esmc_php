<?php

class Application_Form_EuRegion extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement('hidden', 'id_region', array());
        
        $this->addElement('text', 'nom_region', array(
            'label' => 'Nom *',
            'required' => true,
        ));
        
        $sect_select = new Zend_Form_Element_Select('id_pays');
        $sect_select->setLabel('Pays *')
                ->isRequired(true);
        $sect = new Application_Model_DbTable_EuPays();
        $select = $sect->select();
        $select->order('eu_pays.libelle_pays asc');
        $rows = $sect->fetchAll($select);
        $sect_select->addMultiOption('', '');
        foreach ($rows as $st) {
          $sect_select->addMultiOption($st->id_pays,utf8_encode($st->libelle_pays));
        }
        $this->addElement($sect_select);

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

