<?php

class Application_Form_EuDomiciliation extends Zend_Form {

    public function init() {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $num_membre = $user->num_membre;
        $group = $user->usergroup;
        $this->setMethod('post');

        $table = new Application_Model_DbTable_EuMembre();
        $select = $table->select();
        $rows = $table->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->num_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "num_benef", array('label' => 'Numéro bénéficiaire *')
        );
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);

        if ($group == 'gac') {
            $condi = 'valid_gac = ?';
        } elseif ($group == 'gac_filiere') {
            $condi = 'valid_gac = ?';
        } elseif ($group == 'creneaux') {
            $condi = 'valid_fil = ?';
        } elseif ($group == 'acteurs_creneaux') {
            $condi = 'valid_creneau = ?';
        }
        $smc = array();
        $table = new Application_Model_DbTable_EuSmcipn();
        $select = $table->select();
        $select->where('num_membre=?', $num_membre);
        $select->where('etat_demand=?', 0);
        //$select->where($condi, 0);
        $select->order('date_demand', 'DESC');
        $bes = $table->fetchAll($select);
        foreach ($bes as $value) {
            $smc[$value->code_demand] = $value->code_demand;
        }
        $f_select = new Zend_Form_Element_Select('code_demand');
        $f_select->setLabel('Code SMCIPN *')->isRequired(false);
        $f_select->addMultiOption('', '');
        $this->addElement($f_select);

        $this->addElement('text', 'mt_salaire', array(
            'label' => 'Montant subvention *',
            'readonly' => true,
            'filters' => array('StringTrim'),
        ));

        $this->addElement('text', 'dvm_demand', array(
            'label' => 'Durée du projet (jours) *',
            'readonly' => true,
            'filters' => array('StringTrim'),
        ));

        $table = new Application_Model_DbTable_EuMembre();
        $select = $table->select();
        $rows = $table->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->num_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "num_client", array('label' => 'Numéro client *')
        );
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);

        $cat_res = array('' => '', 'r' => 'Récurrent', 'nr' => 'Non récurrent');
        $cat_select = new Zend_Form_Element_Select('cat_ressource');
        $cat_select->setLabel('Type de ressource *')
                ->setRequired(true)->addMultiOptions($cat_res);
        $this->addElement($cat_select);

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
