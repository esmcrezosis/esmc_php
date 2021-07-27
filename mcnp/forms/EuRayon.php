<?php
class Application_Form_EuRayon extends  Zend_Form
{
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
         $this->setMethod('post');
         $auth = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('admin'));
         $user = $auth->getIdentity();
         $num_membre = $user->num_membre;
         
         
         $this->addElement(
            'text', 'code_rayon', array(
                'label' => 'Code rayon *',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));

         
         $this->addElement('text', 'design_rayon', array(
            'label' => 'Nom du rayon *',
            'required' => true,
            ));
        
         
         $this->addElement('text', 'telephone', array(
            'label' => 'Téléphone *',
            'required' => true,
            'filters' => array('StringTrim'),
            ));
         
         
         $this->addElement('text', 'adresse', array(
            'label' => 'Adresse *:',
            'required' => true,
            'filters' => array('StringTrim'),
            ));
        
        $b = new Application_Model_DbTable_EuBoutique();
        $select=$b->select();
        
        $select->from($b)
              ->where('proprietaire = ?', $num_membre);
        $boutique = $b->fetchAll($select);
        
        $z_select = new Zend_Form_Element_Select('code_bout');
        $z_select->setLabel('Boutique *')->isRequired(true);
        foreach ($boutique as $c) {
            $z_select->addMultiOption($c->code_bout, $c->design_bout);
        }
        $this->addElement($z_select);
        
        
        $nm = new Application_Model_DbTable_EuMembre();
        $select = $nm->select();
        $select->where('type_membre=?', 'M');
        $rows = $nm->fetchAll($select);
        $membres = array();
        foreach ($rows as $c) {
            $membres[] = $c->num_membre;
        }
        $elem = new ZendX_JQuery_Form_Element_AutoComplete(
                        "proprietaire_rayon", array('label' => 'Numéro membre *','required' => true)
        );
        $elem->setJQueryParams(array('source' => $membres));
        $this->addElement($elem);
         
        
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