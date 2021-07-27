<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuGac
 *
 * @author USER
 */
class Application_Form_EuAlerte extends Zend_Form {

    //put your code here
    public function init() {

        $this->setMethod('post');

        $table = new Application_Model_DbTable_EuMembre();
        $select = $table->select();
        //$select->where('type_membre = ?', 'P');
        $rows = $table->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->code_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "num_client", array('label' => 'Numéro plaignant *')
        );
        $elem->setAttrib('size', '25');
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);

        $select1 = $table->select();
        $select1->where('type_membre = ?', 'M');
        $rows1 = $table->fetchAll($select1);
        $assureur = array();
        foreach ($rows1 as $c) {
            $assureur[] = $c->code_membre;
        }
        $elem1 = new ZendX_JQuery_Form_Element_AutoComplete(
                        "num_assureur", array('label' => 'Numéro assureur *')
        );
        $elem1->setAttrib('size', '25');
        $elem1->setJQueryParams(array('source' => $assureur));
        $this->addElement($elem1);

        $select2 = $table->select();
        $select2->where('type_membre = ?', 'M');
        $rows2 = $table->fetchAll($select2);
        $acteur = array();
        foreach ($rows2 as $c) {
            $acteur[] = $c->code_membre;
        }
        $elem2 = new ZendX_JQuery_Form_Element_AutoComplete(
                        "num_acteur", array('label' => 'Numéro exécutant *')
        );
        $elem2->setAttrib('size', '25');
        $elem2->setJQueryParams(array('source' => $acteur));
        $this->addElement($elem2);

        $smc = array();
        $table = new Application_Model_DbTable_EuSmcipn();
        $select = $table->select();
        $select->from('eu_smcipn',array('*',"to_char((eu_smcipn.date_demande),'DD/MM/YYYY') date_demande"))
                ->where('valid_gac=?', 1)
                ->where('domicilier=?', 1)
                ->where("rembourser = ?", 0);
        $select->order('eu_smcipn.date_demande', 'DESC');
        $bes = $table->fetchAll($select);
        foreach ($bes as $value) {
            $smc[$value->code_smcipn] = ucfirst($value->lib_demande) . '--' . $value->date_demande;
        }
        $f_select = new Zend_Form_Element_Select('code_demand');
        $f_select->setLabel('Code SMCIPN *')->isRequired(FALSE);
        $f_select->addMultiOption('', '');
        $f_select->addMultiOptions($smc);
        $this->addElement($f_select);

        $this->addElement('text', 'lib_alerte', array(
            'label' => 'Libellé de l\'alerte *',
            'required' => true,
            'size' => 43,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('textarea', 'motif_alerte', array(
            'label' => 'Motif de l\'alerte',
            'required' => false,
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

        $this->addElement('hidden', 'id_alerte', array(
        ));
    }

}

?>
