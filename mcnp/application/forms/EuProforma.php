<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_EuProforma extends  Zend_Form {
    
    public function init()
    {
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->CODE_MEMBRE;
		$date = new Zend_Date(Zend_Date::ISO_8601);
		if(isset($code_membre)){
        $this->setMethod("post");    
        $besoin = new Application_Model_DbTable_EuBesoin();
        $select = $besoin->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->setIntegrityCheck(false)
               ->where('eu_besoin.code_membre <> ?',$code_membre)
               ->where('eu_besoin.disponible = ?',0)
			   ->where('eu_besoin.date_valide >= ?',$date->toString('yyyy/MM/dd'))  
               ->order('eu_besoin.date_besoin DESC');
        $besoin = $besoin->fetchAll($select);
        $besoin_select = new Zend_Form_Element_Select('lib_besoin');
        $besoin_select->setLabel('Libellé des besoins :')
                      ->isRequired(true);
        $besoin_select->addMultiOption('', '');
        
        foreach ($besoin as $b) {
            $date_besoin = new Zend_Date($b->date_besoin, Zend_Date::ISO_8601);
            $besoin_select->addMultiOption($b->id_besoin,$b->objet_besoin.' -- '.$date_besoin->toString('dd/MM/yyyy'));
        }
        
        $this->addElement($besoin_select);  
        $this->addElement('submit', 'valider', array(
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
}

