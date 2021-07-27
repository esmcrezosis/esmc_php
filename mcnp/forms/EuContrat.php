<?php
class Application_Form_EuContrat extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");

        $this->addElement('hidden', 'membre');

        $t_contrat = new Application_Model_DbTable_EuTypeContrat();
        $t_select = $t_contrat->select();
        $t_select->where('id_type <> ?',1);
        $contrat = $t_contrat->fetchAll($t_select);
        $z_select = new Zend_Form_Element_Select('type');
        $z_select->setLabel('Type contrat ')->isRequired(true);
        foreach ($contrat as $c) {
            $z_select->addMultiOption($c->id_type, $c->design_type);
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

