<?php

class Application_Form_EuGacAllocSal extends Zend_Form {

    //put your code here
    public function init() {


        $this->setMethod('post');

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->setMethod('post');
        $login = $user->id_utilisateur;
        $gacs = array();
        $g_map = new Application_Model_DbTable_EuGac();
        $select = $g_map->select()
                //->where('id_utilisateur = ?', $login)
                ->where('groupe = ?', 'GAC')
                ->order('date_creation', 'ASC');
        $ngac = $g_map->fetchAll($select);
        foreach ($ngac as $value) {
            $gacs[$value->code_gac] = ucfirst($value->nom_gac);
        }
        $g_select = new Zend_Form_Element_Select('num_gac');
        $g_select->setLabel('Nom GAC *')->isRequired(true);
        $g_select->addMultiOption('', '');
        $g_select->addMultiOptions($gacs);
        $this->addElement($g_select);

        $this->addElement(
                'select', 'type_alloc', array(
            'label' => 'Type d\'allocation *',
            'required' => true,
            'filters' => array('StringTrim'),
            'multiOptions' => array(
                '' => '',
                'globale' => 'Globale',
                'periodique' => 'Périodique'
            )
                )
        );

        $this->addElement('button', 'valider', array(
            'ignore' => true,
            'label' => 'Valider',
        ));

        // Add the cancel button
        $this->addElement('reset', 'annuler', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
    }

}

?>
