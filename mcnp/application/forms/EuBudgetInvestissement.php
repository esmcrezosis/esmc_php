<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_EuBudgetInvestissement extends Zend_Form {

    public function init() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
        $this->setMethod("post");
        $besoin = new Application_Model_DbTable_EuBesoin();
        $select = $besoin->select();
        $select->setIntegrityCheck(false)
                ->from('eu_besoin',array('*',"to_char((date_besoin),'DD/MM/YYYY') date_besoin"))
                ->where('code_membre = ?', $code_membre)
                ->where('dsponible != ?', 1);
        $besoin = $besoin->fetchAll($select);
        $besoin_select = new Zend_Form_Element_Select('id_besoin');
        $besoin_select->setLabel('Libellé du besoin *')
                ->isRequired(true);
        $besoin_select->addMultiOption('', '');
        foreach ($besoin as $b) {
            $besoin_select->addMultiOption($b->id_besoin, $b->objet_besoin.' -- '.$b->date_besoin);
        }
        $this->addElement($besoin_select);

        $this->addElement('button', 'valider', array(
            'ignore' => true,
            'label' => 'Valider',
        ));
    }

}
