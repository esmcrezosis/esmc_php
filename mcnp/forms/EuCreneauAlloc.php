<?php

class Application_Form_EuCreneauAlloc extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->setMethod('post');
        $login = $user->code_acteur;
        $gacs = array();
        $g_map = new Application_Model_DbTable_EuCreneau();
        $select = $g_map->select()
                ->where('code_gac_filiere = ?', $login)
                ->where('groupe = ?', 'GAC')
                ->order('date_creation', 'ASC');
        $ngac = $g_map->fetchAll($select);
        foreach ($ngac as $value) {
            $gacs[$value->code_creneau] = ucfirst($value->nom_creneau);
        }
        $g_select = new Zend_Form_Element_Select('code_creneau');
        $g_select->setLabel('Nom créneau *')->isRequired(true);
        $g_select->addMultiOption('', '');
        $g_select->addMultiOptions($gacs);
        $this->addElement($g_select);

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

