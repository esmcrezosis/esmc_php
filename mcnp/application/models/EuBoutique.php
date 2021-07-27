<?php

class Application_Model_EuBoutique
{
    protected $code_bout;
    protected $proprietaire;
    protected $design_bout;
    protected $telephone;
    protected $adresse;
    protected $mail;
    protected $siteweb;
    protected $cree_par;
    protected $codesect;
    protected $nom_responsable;
    protected $prenom_responsable;
    
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

    function getCode_bout(){
        return $this->code_bout;
    }
    
    function setCode_bout($code_bout){
        $this->code_bout = $code_bout;
        return $this;
    }
    
    function getProprietaire(){
        return $this->proprietaire;
    }
    
    function setProprietaire($proprietaire){
        $this->proprietaire = $proprietaire;
        return $this;
    }    
    function getDesign_bout(){
        return $this->design_bout;
    }
    
    function setDesign_bout($design_bout){
        $this->design_bout = $design_bout;
        return $this;
    }
    
    function getTelephone(){
        return $this->telephone;
    }
    
    function setTelephone($telephone){
        $this->telephone = (string) $telephone;
        return $this;
    }
    function getAdresse(){
        return $this->adresse;
    }
    
    function setAdresse($adresse){
        $this->adresse = $adresse;
        return $this;
    }
    function getMail(){
        return $this->mail;
    }    
    function setMail($mail){
        $this->mail = $mail;
        return $this;
    }
    function getSiteweb(){
        return $this->siteweb;
    }
    
    function setSiteweb($siteweb){
        $this->siteweb = $siteweb;
        return $this;
    }
    
    function getCreer_par(){
        return $this->creer_par;
    }
    
    function setCreer_par($creer_par){
        $this->creer_par = $creer_par;
        return $this;
    }
    
    function getCodesect(){
        return $this->codesect;
    }
    function setCodesect($codesect){
        $this->codesect = $codesect;
        return $this;
    }
    
    function getNom_responsable(){
        return $this->nom_responsable;
    }
    
    function setNom_responsable($nom_responsable){
        $this->nom_responsable = $nom_responsable;
        return $this;
    }
    
    function getPrenom_responsable(){
        return $this->prenom_responsable;
    }
    
    function setPrenom_responsable($prenom_responsable){
        $this->prenom_responsable = $prenom_responsable;
        return $this;
    }
    
}


