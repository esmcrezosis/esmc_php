<?php

class Application_Form_EuGacFiliereAllocSal extends Zend_Form {

    //put your code here
    public function init() {

        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $this->setMethod('post');
        $login = $user->code_acteur;
		if($login!='' || $login!= NULL){
			$login1=$login;
		}else{
			$login1='';
		}
        $gacs = array();
        $g_map = new Application_Model_DbTable_EuGacFiliere();
        $select = $g_map->select()
                ->where('code_gac = ?', $login1)
                ->where('groupe = ?', 'GAC')
                ->order('date_creation', 'ASC');
        $ngac = $g_map->fetchAll($select);
        foreach ($ngac as $value) {
            $gacs[$value->code_gac_filiere] = ucfirst($value->nom_gac_filiere);
        }
        $g_select = new Zend_Form_Element_Select('num_gac_filiere');
        $g_select->setLabel('Nom GAC Filière *')->isRequired(true);
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

?>
