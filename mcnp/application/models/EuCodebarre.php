<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuDevise
 *
 * @author user
 */
class Application_Model_EuCodebarre {
    //put your code here
    protected $codebarre;
    protected $type_codebar;
    protected $date_generer;
    protected $codemembre_four;
    protected $raisonsociale_four;
    protected $date_four;
    protected $id_utilisateur;
    protected $codemembre_dem;
    
    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid membre property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function getCodebarre(){
        return $this->codebarre;
    }
    public function setCodebarre($codebarre){
        $this->codebarre = $codebarre;
        return $this;
    }

    public function getType_codebar(){
        return $this->type_codebar;
    }
    public function setType_codebar($type_codebar){
        $this->type_codebar = $type_codebar;
        return $this;
    }
    
    public function getDate_generer(){
        return $this->date_generer;
    }
    public function setDate_generer($date_generer){
        $this->date_generer = $date_generer;
        return $this;
    }
    
    public function getCodemembre_four(){
        return $this->codemembre_four;
    }
    public function setCodemembre_four($codemembre_four){
        $this->codemembre_four = $codemembre_four;
        return $this;
    }
	
    public function getRaisonsociale_four(){
        return $this->raisonsociale_four;
    }
    public function setRaisonsociale_four($raisonsociale_four){
        $this->raisonsociale_four = $raisonsociale_four;
        return $this;
    }
	
    public function getDate_four(){
        return $this->date_four;
    }
    public function setDate_four($date_four){
        $this->date_four = $date_four;
        return $this;
    }
	
    public function getId_utilisateur(){
        return $this->id_utilisateur;
    }
    public function setId_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    public function getCodemembre_dem(){
        return $this->codemembre_dem;
    }
    public function setCodemembre_dem($codemembre_dem){
        $this->codemembre_dem = $codemembre_dem;
        return $this;
    }
	
}

?>
