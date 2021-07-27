<?php

class Application_Form_EuAgence extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
		$auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->setMethod('post');

        $this->addElement('text', 'libelle_agence', array(
            'label' => 'Libellé *',
            'size' => '30',
            'required' => true,
        ));
        $sect_select = new Zend_Form_Element_Select('code_secteur');
        $sect_select->setLabel('Secteur *')
                ->isRequired(true);
        $sect = new Application_Model_DbTable_EuSecteur();
        $select = $sect->select();
        $select->order('eu_secteur.nom_secteur asc');
		//$select->where('eu_secteur.code_membre LIKE ?', $user->code_membre);
        $rows = $sect->fetchAll($select);
        foreach ($rows as $st) {
            $sect_select->addMultiOption('', '');
            $sect_select->addMultiOption($st->code_secteur, ucfirst($st->nom_secteur));
        }
        $this->addElement($sect_select);

        $canton_select = new Zend_Form_Element_select('id_canton');
        $canton_select->setLabel('Canton Lié')
                      ->isRequired(true);
        $canton = new Application_Model_DbTable_EuCanton();
        $select = $canton->select();
        $select->order('nom_canton', 'ASC');
        $rows = $canton->fetchAll($select);
        foreach ($rows as $row) {
            $canton_select->addMultiOption('', '');
            $canton_select->addMultiOption($row->id_canton,html_entity_decode($row->nom_canton));
        }
        $this->addElement($canton_select);
        
		
		//$type_gac = array('' => '', 'source' => 'SOURCE', 'monde' => 'MONDE', 'zone' => 'ZONE', 'pays' => 'PAYS','region' => 'REGION'
		//,'secteur' => 'SECTEUR','agence' => 'AGENCE');
        //$gac_select = new Zend_Form_Element_Select('type_gac');
        //$gac_select->setLabel('Type gac lié:')
        //           ->setRequired(true)->addMultiOptions($type_gac);
        //$this->addElement($gac_select);			  
				  
		
        //$part = new Zend_Form_Element_Checkbox('partenaire');
        //$part->setLabel('Partenaire');
        //$this->addElement($part);

        //$ng = new Application_Model_DbTable_EuMembreMorale();
        //$select = $ng->select();
        //$rows = $ng->fetchAll($select);
        //$membres = array();
        //foreach ($rows as $c) {
           // $membres[] = $c->code_membre_morale;
        //}
        //$elem = new ZendX_JQuery_Form_Element_AutoComplete(
        //                "code_membre", array('label' => 'Numéro membre')
        //);
        //$elem->setJQueryParams(array('source' => $membres));
        //$elem->setAttrib('size', '25');
        //$this->addElement($elem);
        
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
                'hidden', 'code_agence', array(
        ));
    }

}

