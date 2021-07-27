<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuDetailMf107
{
    protected $id_mf107;
    protected $numident;
    protected $code_membre;
    protected $date_mf107;
    protected $mont_apport;
    protected $id_utilisateur;
    protected $pourcentage;
    protected $proprietaire;
	protected $creditcode;
	protected $nature;
    

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }
    
    
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
     }
     
     
    function getId_mf107() {
        return $this->id_mf107;
    }

    function setId_mf107($id_mf107) {
        $this->id_mf107 = $id_mf107;
        return $this;
    }
    
    
    function getNumident() {
        return $this->numident;
    }

    function setNumident($numident) {
        $this->numident = $numident;
        return $this;
    }

    
    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    
    function getDate_mf107() {
        return $this->date_mf107;
    }

    function setDate_mf107($date_mf107) {
        $this->date_mf107 = $date_mf107;
        return $this;
    }
    
    function getMont_apport() {
        return $this->mont_apport;
    }

    function setMont_apport($mont_apport) {
        $this->mont_apport = $mont_apport;
        return $this;
    }
    
    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    
    function getPourcentage() {
        return $this->pourcentage;
    }

    function setPourcentage($pourcentage) {
        $this->pourcentage = $pourcentage;
        return $this;
    }
    
    function getProprietaire() {
        return $this->proprietaire;
    }

    function setProprietaire($proprietaire) {
        $this->proprietaire = $proprietaire;
        return $this;
    }
	
	function getCreditcode() {
      return $this->creditcode;
    }

    function setCreditcode($creditcode) {
      $this->creditcode = $creditcode;
      return $this;
    }
	
	function getNature() {
      return $this->nature;
    }

    function setNature($nature) {
      $this->nature = $nature;
      return $this;
    }
	
	
	

}
?>

