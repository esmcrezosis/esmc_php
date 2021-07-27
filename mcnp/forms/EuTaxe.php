<?php
class Application_Form_EuTaxe extends Zend_Form {
    public function init() {
        /* Form Elements & Other Definitions Here ... */
		
        $this->setMethod('post');
		$this->addElement('hidden', 'id_taxe');
        $this->addElement(
            'text', 'libelle_taxe', array(
            'label' => 'Libellé ',
            'required' => true,
            'filters' => array('StringTrim'),
        ));
        $taux = new Zend_Form_Element_Text('taux_taxe');
        $taux->setLabel('Taux de la taxe en % ')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
               ->addValidator('float', true, array('locale' => 'en_US'));
        $this->addElement($taux);
               
        $mapper = new Application_Model_EuPaysMapper();
        $pays = $mapper->fetchAll();
        $z_select = new Zend_Form_Element_Select('id_pays');
        $z_select->setLabel('Pays ')->isRequired(true);
        foreach ($pays as $c) {
            $z_select->addMultiOption($c->id_pays, $c->libelle_pays);
        }
        $this->addElement($z_select);
        
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Valider',
        ));

        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
    }

}


