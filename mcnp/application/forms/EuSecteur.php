<?php

class Application_Form_EuSecteur extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');

        $this->addElement('text', 'nom_secteur', array(
            'label' => 'Nom *',
            'required' => true,
            'filters' => array('StringTrim'),
        ));
        
        $map_region = new Application_Model_DbTable_EuRegion();
        $select = $map_region->select();
        $select->order('nom_region', 'ASC');
        $zones = $map_region->fetchAll($select);
        $z_select = new Zend_Form_Element_Select('id_region');
        $z_select->setLabel('Region');
        foreach ($zones as $c) {
            $z_select->addMultiOption('', '');
            $z_select->addMultiOption($c->id_region, utf8_encode($c->nom_region));
        }
        $this->addElement($z_select);

        $mapper = new Application_Model_DbTable_EuPrefecture();
        $pselect = $mapper->select();
        $pselect->order('nom_prefecture asc');
        $pays = $mapper->fetchAll($pselect);
        $p_select = new Zend_Form_Element_Select('id_prefecture');
        $p_select->setLabel('Prefecture');
        foreach ($pays as $c) {
          $p_select->addMultiOption('', '');
          $p_select->addMultiOption($c->id_prefecture, html_entity_decode($c->nom_prefecture));
        }
        $this->addElement($p_select);

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Valider',
        ));

        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
        $this->addElement(
                'hidden', 'code_secteur', array(
        ));
    }

}

