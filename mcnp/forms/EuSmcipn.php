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
class Application_Form_EuSmcipn extends Zend_Form {

    //put your code here
    public function init() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->setMethod('post');

        $num_membre = $user->num_membre;

        $this->addElement(
                'text', 'code_demand', array(
            'label' => 'Code *',
            'required' => true,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('text', 'lib_demand', array(
            'label' => 'Libellé *',
            'required' => true,
            'size' => 43,
            'filters' => array('StringTrim'),
        ));

        $gac = array();
        $tab = new Application_Model_DbTable_EuGac();
        $sel = $tab->select();
        $sel->order('date_creation', 'DESC');
        $ngac = $tab->fetchAll($sel);
        foreach ($ngac as $value) {
            $gac[$value->num_gac] = ucfirst($value->num_gac) . '--' . $value->nom_gac;
        }
        $g_select = new Zend_Form_Element_Select('num_gac');
        $g_select->setLabel('Nom de la GAC *')->isRequired(true);
        $g_select->addMultiOption('', '');
        $g_select->addMultiOptions($gac);
        $this->addElement($g_select);

        $besoin = array();
        $table = new Application_Model_DbTable_EuBesoin();
        $select = $table->select();
        $select->where('num_client=?', $num_membre);
        $select->order('id_besoin', 'DESC');
        $bes = $table->fetchAll($select);
        foreach ($bes as $value) {
            $besoin[$value->id_besoin] = ucfirst($value->objet_besoin) . ' ' . $value->date_besoin;
        }
        $f_select = new Zend_Form_Element_Select('id_besoin');
        $f_select->setLabel('Expression de besoin ')->isRequired(false);
        $f_select->addMultiOption('', '');
        $f_select->addMultiOptions($besoin);
        $this->addElement($f_select);

        $this->addElement('textarea', 'desc_demand', array(
            'label' => 'Description',
            'required' => false,
            'filters' => array('StringTrim'),
        ));

        $type_unite = array('' => '', 'jour' => 'Jour', 'mois' => 'Mois', 'annee' => 'Année');
        $unit_select = new Zend_Form_Element_Select('unite_mdv');
        $unit_select->setLabel('Unité de durée *')
                ->setRequired(true)
                ->addMultiOptions($type_unite);
        $this->addElement($unit_select);

        $this->addElement('text', 'mdv', array(
            'label' => 'Durée du projet *',
            'required' => true,
            'size' => 8,
            'filters' => array('StringTrim'),
            'validators' => array('validator' => 'digits'),
        ));

        $this->addElement('text', 'mt_salaire', array(
            'label' => 'Salaire',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array('validator' => 'digits'),
        ));

        $this->addElement('text', 'mt_investis', array(
            'label' => 'Investissement',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array('validator' => 'digits'),
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
    }

}

?>
