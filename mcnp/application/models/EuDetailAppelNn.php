<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of EuCnpEntree
 *
 * @author user
 */
class Application_Model_EuDetailAppelNn {

     //put your code here
     protected $id_detail_appel_nn;
     protected $id_appel_nn;
     protected $code_membre;
     protected $date_apport;
     protected $heure_apport;
     protected $montant_apport;
	 protected $code_compte;
     protected $id_utilisateur;
	 protected $payer;
	
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }
	
	
    public function getId_detail_appel_nn() {
        return $this->id_detail_appel_nn;
    }

    public function setId_detail_appel_nn($id_detail_appel_nn) {
        $this->id_detail_appel_nn = $id_detail_appel_nn;
        return $this;
    }

    public function getId_appel_nn() {
        return $this->id_appel_nn;
    }

    public function setId_appel_nn($id_appel_nn) {
        $this->id_appel_nn = $id_appel_nn;
        return $this;
    }
    
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getDate_apport() {
        return $this->date_apport;
    }

    public function setDate_apport($date_apport) {
        $this->date_apport = $date_apport;
        return $this;
    }

    public function getHeure_apport() {
        return $this->heure_apport;
    }

    public function setHeure_apport($heure_apport) {
        $this->heure_apport = $heure_apport;
        return $this;
    }
    
    public function getMontant_apport(){
        return $this->montant_apport;
    }
   
    public function setMontant_apport($montant_apport) {
        $this->montant_apport = $montant_apport;
        return $this;
    }
	
	public function getCode_compte() {
        return $this->code_compte;
    }
    
    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }
	
	
	public function getId_utilisateur() {
        return $this->id_utilisateur;
    }
    
    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	
	public function getPayer() {
        return $this->payer;
    }
    
    public function setPayer($payer) {
        $this->payer = $payer;
        return $this;
    }
	
	
	
	

}

?>
