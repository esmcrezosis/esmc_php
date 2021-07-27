<?php

class Application_Form_EuGacFiliere extends Zend_Form {

    //put your code here
    public function init() {

        $this->setMethod('post');

        $this->addElement('text', 'nom_gac_filiere', array(
            'label' => 'Nom *',
            'required' => true,
            'size' => 38,
            'filters' => array('StringTrim'),
        ));

        $filieres = array();
        $f_mapper = new Application_Model_DbTable_EuFiliere();
        $select = $f_mapper->select();
        $select->order('nom_filiere', 'ASC');
        $fils = $f_mapper->fetchAll($select);
        foreach ($fils as $value) {
            $filieres[$value->id_filiere] = ucfirst($value->nom_filiere);
        }
        $f_select = new Zend_Form_Element_Multiselect('id_filiere');
        $f_select->setLabel('Filières *');
        $f_select->setRequired(true);
        $f_select->addMultiOption('', '');
        $f_select->addMultiOptions($filieres);
        $this->addElement($f_select);

        $table = new Application_Model_DbTable_EuMembreMorale();
        $select = $table->select();
        $rows = $table->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre_morale;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre", array('label' => 'Code membre')
        );
        $elem->setJQueryParams(array('source' => $membres));
        $elem->setAttrib('size', '25');
        $this->addElement($elem);

        $ng = new Application_Model_DbTable_EuMembre();
        $select = $ng->select();
        $rows = $ng->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre_morale;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre_gestionnaire", array('label' => 'Numéro gestionnaire *','required' => true,)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $elem->setAttrib('size', '25');
        $elem->setRequired(true);
        $this->addElement($elem);

        $this->addElement('text', 'nom_gestion', array(
            'label' => 'Nom gestionnaire *',
            'required' => false,
            'size' => 25,
            'filters' => array('StringTrim'),
            'readonly' => true,
        ));

        $this->addElement('text', 'prenom_gestion', array(
            'label' => 'Prénoms gestionnaire',
            'required' => false,
            'size' => 25,
            'filters' => array('StringTrim'),
            'readonly' => true,
        ));

        $this->addElement('text', 'tel_gestion', array(
            'label' => 'Téléphone gestionnaire',
            'required' => false,
            'filters' => array('StringTrim'),
            'size' => 25,
            'readonly' => true,
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

        $this->addElement(
            'hidden', 'code_gac_filiere', array(
        ));

        foreach ($this->getElements() as $element) {
            $element->removeDecorator('HtmlTag');
            $element->removeDecorator('DtDdWrapper');
            $element->removeDecorator('Label');
        }
    }

}

?>
