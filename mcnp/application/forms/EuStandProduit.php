<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_EuStandProduit  extends  Zend_Form
{
    
     public function init()
     {
         /* Form Elements & Other Definitions Here ... */
         $this->setMethod('post');
         $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
         $user = $auth->getIdentity();
         $code_membre = $user->code_membre;  
         
         $this->addElement('hidden', 'id_produit');
         
         $this->addElement('text', 'design_produit', array(
            'label' => 'Désignation *',
            'required' => true,
         ));
         
         
          $s = new Application_Model_DbTable_EuStand();
          $select=$s->select();
          $select->setIntegrityCheck(false)
                  ->where('code_membre = ?', $code_membre);
          $stand = $s->fetchAll($select);          
          $z_select = new Zend_Form_Element_Select('id_stand');
          $z_select->setLabel('Désignation stand *')->isRequired(true);
          //$z_select->addMultiOption('','');
          foreach ($stand as $c) {
            $z_select->addMultiOption($c->id_stand, $c->design_stand);
          }
          $this->addElement($z_select);
          
          
          $f = new Application_Model_DbTable_EuFiliere();
          $filiere = $f->fetchAll();
          $f_select = new Zend_Form_Element_Select('id_filiere');
          $f_select->setLabel('Nom de la filière *')->isRequired(true);
          foreach ($filiere as $r) { 
            $f_select->addMultiOption($r->id_filiere, $r->nom_filiere);
          }
          $this->addElement($f_select);
          
          
          $this->addElement('submit', 'submit', array(
             'ignore'   => true,
             'label'    => 'Valider',
          )); 
        
        
        // Add the cancel button
        $this->addElement('button', 'cancel', array(
            'ignore' => true,
            'label' => 'Annuler',
        ));
            
     }
    
    
    
    
    
    
    
    
    
    
    


}