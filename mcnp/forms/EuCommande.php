<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_EuCommande extends Zend_Form {
    
    public function init()
    {   
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $code_membre = $user->code_membre;
		if(isset($code_membre)){
        $this->setMethod("post");   
        $besoin = new Application_Model_DbTable_EuBesoin();
        $select=$besoin->select();
        $select->from($besoin)
               ->where('code_membre = ?',$code_membre)
               ->where('disponible = ?',0)  
               ->order('eu_besoin.date_besoin DESC'); 
        $nbesoin = $besoin->fetchAll($select);
        $besoin_select = new Zend_Form_Element_Select('id_besoin');
        $besoin_select->setLabel('Libellé des besoins:')
                ->isRequired(true);
        $besoin_select->addMultiOption('', '');
        
        foreach ($nbesoin as $b) {
            $date_besoin = new Zend_Date($b->date_besoin, Zend_Date::ISO_8601);
            $besoin_select->addMultiOption($b->id_besoin, $b->objet_besoin.'--'.$date_besoin->toString('dd/MM/yyyy'));
        }
        $this->addElement($besoin_select);
        
        
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
}
