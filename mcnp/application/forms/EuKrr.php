<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuKrr
 *
 * @author USER
 */
 
class Application_Form_EuKrr extends Zend_Form {

    //put your code here
    public function init() {
        parent::init();
        $this->setMethod("post");
        $this->setName("fm_krr")->setDisableLoadDefaultDecorators(true)
             ->addDecorator('FormElements')
             ->addDecorator('Form');
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
		$user = $auth->getIdentity();
        $group = $user->CODE_GROUPE;
		if($group == 'e_nn_achatpp_nn_krr_rpgr') {
           $prods = array('RPG' => 'RPG');   
		} else {
           $prods = array('I' => 'Investissement');
        }	
        
        $prod_auto = new Zend_Form_Element_Select (
            "code_produit", array('label' => 'Code Produit:')
        );
        $prod_auto->setMultiOptions($prods);
        $this->addElement($prod_auto);
		$membres = array();
		if($group == 'e_nn_achatpp_nn_krr_rpgr') {
           $m_map = new Application_Model_EuMembreMapper();
		   $rows = $m_map->fetchAll();
           foreach ($rows as $c) {
              $membres[] = $c->code_membre;
           }
		} else {
           $m_map = new Application_Model_EuMembreMoraleMapper();
		   $rows = $m_map->fetchAll();
           foreach ($rows as $c) {
           $membres[] = $c->code_membre_morale;
        }
        }		
        
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "code_membre", array('label' => 'Numéro membre:')
        );
        $elem->setJQueryParams(array('source' => $membres));
        $elem->setAttrib('size',30);
        $this->addElement($elem);

        $this->addElement('button', 'val', array(
            'ignore' => true,
            'label' => 'OK',
        ));

		
        // Add the cancel button
        $this->addElement('reset', 'annuler', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
        
		
        foreach ($this->getElements() as $element) {
          $element->removeDecorator('HtmlTag');
          $element->removeDecorator('DtDdWrapper');
          $element->removeDecorator('Label');
        }
    }

}

?>
