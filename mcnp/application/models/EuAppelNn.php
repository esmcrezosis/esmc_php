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
 
class Application_Model_EuAppelNn {

    //put your code here
    protected $id_appel_nn;
    protected $id_proposition;
    protected $designation_appel;
    protected $date_appel;
	protected $date_fin;
    protected $code_compte;
    protected $montant_nn;
    protected $disponible;
	protected $code_membre_morale;
    protected $id_utilisateur;
	
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
	
    public function getId_appel_nn() {
        return $this->id_appel_nn;
    }

    public function setId_appel_nn($id_appel_nn) {
        $this->id_appel_nn = $id_appel_nn;
        return $this;
    }

    public function getId_proposition() {
        return $this->id_proposition;
    }

    public function setId_proposition($id_proposition) {
        $this->id_proposition = $id_proposition;
        return $this;
    }
    
    public function getDesignation_appel() {
        return $this->designation_appel;
    }

    public function setDesignation_appel($designation_appel) {
        $this->designation_appel = $designation_appel;
        return $this;
    }

    public function getDate_appel() {
        return $this->date_appel;
    }

    public function setDate_appel($date_appel) {
        $this->date_appel = $date_appel;
        return $this;
    }
	
	public function getDate_fin() {
        return $this->date_fin;
    }

    public function setDate_fin($date_fin) {
        $this->date_fin = $date_fin;
        return $this;
    }
	

    public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }
    
    public function getMontant_nn(){
        return $this->montant_nn;
    }
	
    public function setMontant_nn($montant_nn){
        $this->montant_nn = $montant_nn;
        return $this;
    }
    
    public function getDisponible(){
        return $this->disponible;
    }
    
    public function setDisponible($disponible){
        $this->disponible = $disponible;
        return $this;
    }
	
	public function getCode_membre_morale(){
        return $this->code_membre_morale;
    }
    
    public function setCode_membre_morale($code_membre_morale){
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }
	
	public function getId_utilisateur(){
        return $this->id_utilisateur;
    }
    
    public function setId_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }


}

?>
