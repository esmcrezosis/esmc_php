<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_EuMembreFondateur107 {
      
     protected $numident;
     protected $nom;
     protected $prenom;
     protected $tel;
     protected $cel;
     protected $code_membre;
     protected $solde;
     protected $nb_repartition;
     protected $id_utilisateur;
    
     
     public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }
    
    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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
      
    
    function getNumident() {
        return $this->numident;
    }

    function setNumident($numident) {
        $this->numident = $numident;
        return $this;
    }
    
    function getNom() {
        return $this->nom;
    }

    function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }
    
    function getPrenom() {
        return $this->prenom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }
    
    function getTel() {
        return $this->tel;
    }

    function setTel($tel) {
        $this->tel = $tel;
        return $this;
    }
    
    function getCel() {
        return $this->cel;
    }

    function setCel($cel) {
        $this->cel = $cel;
        return $this;
    }
    
    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    function getSolde() {
        return $this->solde;
    }

    function setSolde($solde) {
        $this->solde = $solde;
        return $this;
    }
    
    
    function getNb_repartition() {
        return $this->nb_repartition;
    }

    function setNb_repartition($nb_repartition) {
        $this->nb_repartition = $nb_repartition;
        return $this;
    }
     
    
    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
 }
?>
