<?php

class Application_Form_EuObjetM extends Zend_Form
{
     public function init()
     {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        
        $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
        $user = $auth->getIdentity();
        $login = $user->login;
        $num_membre = $user->num_membre;
        
        $this->addElement('hidden', 'id_value');
       // $this->addElement('hidden', 'duree_vie');
        
        $this->addElement('text', 'code_objet',array(
            'label' => 'Code',
            'required' => true,
            'readonly' => true
            ));
            
        $this->addElement('text', 'design_objet', array(
            'label' => 'Désignation ',
            'required' => true,
            'readonly' => true
            ));
       
        $gamme_select = new Zend_Form_Element_Select('num_gamme');
        $gamme_select->setLabel('Gamme ')
                ->setRequired(true);
        $g = new Application_Model_DbTable_EuGammeProduit();
        $rows = $g->fetchAll();
        foreach ($rows as $c) {
            $gamme_select->addMultiOption($c->code_gamme, $c->design_gamme);
        }
        $this->addElement($gamme_select);
         
        $type_unite = array('jour' => 'Jour', 'mois' => 'Mois', 'annee' => 'Année');
        $unit_select = new Zend_Form_Element_Select('unite_mdv');
        $unit_select->setLabel('Unité de durée *')
                ->setRequired(true)
                ->addMultiOptions($type_unite);
        $this->addElement($unit_select);
        
        $this->addElement('text', 'duree_vie', array(
            'label' => 'Durée de vie ',
            'required' => true,
            'validators'=>array('validator' => 'digits'),
            ));
        
        $this->addElement('text', 'prix_unitaire', array(
            'label' => 'Prix unitaire ',
            'required' => true,
            'validators'=>array('validator' => 'digits'),
            ));
         
        $rayon_select = new Zend_Form_Element_Select('code_rayon');
        $rayon_select->setLabel('Rayon ')
                ->setRequired(false);
        $r = new Application_Model_DbTable_EuRayon();
        $select=$r->select();
        $select->from($r)
               ->where('creer_par = ?', $login);
        $rows = $r->fetchAll($select);
        $rayon_select->addMultiOption('','');
        foreach ($rows as $c) {
            $rayon_select->addMultiOption($c->code_rayon, $c->design_rayon);
        }
        $this->addElement($rayon_select);
        
        
        $bout_select = new Zend_Form_Element_Select('code_bout');
        $bout_select->setLabel('Boutique ')
                ->setRequired(false);
        $b = new Application_Model_DbTable_EuBoutique();
        $select=$b->select();
        $select->from($b)
               ->where('proprietaire = ?', $num_membre);
        $rows = $b->fetchAll($select);
        foreach ($rows as $c) {
            $bout_select->addMultiOption($c->code_bout, $c->design_bout);
        }
        $this->addElement($bout_select);
        
        $smcipn_select = new Zend_Form_Element_Select('code_demand');
        $smcipn_select->setLabel('Code subvention ')
                      ->setRequired(false);
        $s = new Application_Model_DbTable_EuSmcipn();
        $rows = $s->fetchAll();
        $smcipn_select->addMultiOption('', '');
        foreach ($rows as $c) {
            $smcipn_select->addMultiOption($c->code_demand, $c->code_demand);
        }
        $this->addElement($smcipn_select);
      
        
        $this->addElement('textarea', 'caract_objet', array(
            'label' => 'Caractéristique ',
            'required' => false,
            ));
        
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
