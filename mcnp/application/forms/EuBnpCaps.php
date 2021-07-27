<?php

class Application_Form_EuBnpCaps extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $this->setName("fm_membre")->setDisableLoadDefaultDecorators(true)
             ->addDecorator('FormElements')
             ->addDecorator('Form');

        $this->addElement('text','type_bnp',array('label' => 'Type BNP :','required' => true));

        $m_map = new Application_Model_EuMembreMapper();
        $rows = $m_map->fetchAll();
        $membres = array();
        foreach ($rows as $c) {
          $membres[] = $c->code_membre;
        }
        $elem_ap = new ZendX_JQuery_Form_Element_AutoComplete("apport", array('label' => 'Code Membre Apporteur:'));
        $elem_ap->setJQueryParams(array('source' => $membres));
        $elem_ap->setAttrib('size',30);
        $elem_ap->setAttrib('required',true);
        $this->addElement($elem_ap);

        $this->addElement('text', 'raison_apport', array('label' => 'Raison sociale :','size' => 30,'readonly' => true));

        $this->addElement('text','nom_apport',array('label' => 'Nom:','size' => 30,'readonly' => true));

        $this->addElement('text', 'prenom_apport', array('label' => 'Prenoms:','size' => 30,'readonly' => true));

        $type_fs = new Zend_Form_Element_Select('type_caps');
        $type_fs->setLabel('Type CAPS');
		$type_fs->addMultiOptions(array(''=>'','CAPSFLFCPS' => 'CAPS Avec FL et 1 KPS'));
		
        //$type_fs->addMultiOptions(array(''=>'','CAPSFLFCPS' => 'CAPS Avec FL et 1 CPS'
		//,'CAPSFL2FCPS' => 'CAPS Avec FL et 2 CPS','CAPSFL3FCPS' => 'CAPS Avec FL et 3 CPS'));
		
        $this->addElement($type_fs);

        $this->addElement('text', 'mont_caps', array('label' => 'Montant CAPS:','required' => true,'readonly' => true,'validators' => array('Digits')));

        $this->addElement('text', 'code_sms', array('label' => 'Code SMS:','required' => false));
		
		
		$mf_select = new Zend_Form_Element_Select('type_mf');
        $mf_select->setLabel('Compte MF *')
                ->isRequired(true);
        $mf = new Application_Model_DbTable_EuTypeMf();
        $select = $mf->select();
        $select->order('eu_type_mf.code_type_mf asc');
        $rows = $mf->fetchAll($select);
        foreach ($rows as $st) {
            //$mf_select->addMultiOption('', '');
            $mf_select->addMultiOption($st->code_type_mf, ucfirst($st->lib_type_mf));
        }
        $this->addElement($mf_select);

        $this->addElement('text', 'montant', array('label' => 'Montant:','required' => false,'validators' => array('Digits'),'readonly' => true));

        $this->addElement('submit', 'val', array('ignore' => true,'label' => 'Valider',));

        // Add the cancel button
        $this->addElement('button', 'cancel', array('ignore' => true,'label' => 'Annuler',));

        foreach ($this->getElements() as $element) {
           $element->removeDecorator('HtmlTag');
           $element->removeDecorator('DtDdWrapper');
           $element->removeDecorator('Label');
        }
    }

}
