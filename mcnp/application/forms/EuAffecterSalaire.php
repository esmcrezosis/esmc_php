<?php

class Application_Form_EuAffecterSalaire extends Zend_Form {

    //put your code here
    public function init() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->setMethod('post');
        $num = $user->code_membre;

        $mys = array();
        $tab = new Application_Model_DbTable_EuSmcipn();
        $select = $tab->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
                ->join(array('j' => 'eu_justifier'), 'j.code_smcipn = eu_smcipn.code_smcipn', array('code_smcipn','solde'))
                ->where('solde != ?', 0)
                ->where('eu_smcipn.salaire_alloue != ?', 0)
                ->where('eu_smcipn.sal_transmis = ?', 0)
                ->where('eu_smcipn.code_membre LIKE  ?', $num)
                ->where('eu_smcipn.rembourser LIKE  ?', 0);
        $ngac = $tab->fetchAll($select);
        foreach ($ngac as $value) {
            $date_dem = new Zend_Date($value->date_demande, Zend_Date::ISO_8601);
            $mys[$value->code_smcipn] = ucfirst($value->lib_demande) . '--' . $date_dem->toString('dd/MM/yyyy');
        }
        $g_select = new Zend_Form_Element_Select('code_demand');
        $g_select->setLabel('Code SMCIPN *')->isRequired(true);
        $g_select->addMultiOption('', '');
        $g_select->addMultiOptions($mys);
        $this->addElement($g_select);
        $this->addElement('button', 'valider', array(
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
