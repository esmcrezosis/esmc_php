<?php

class Application_Model_EuDetailCommande
{
    protected $id_detail_commande;
    protected $code_commande;
    protected $qte;
    protected $prix_unitaire;
    protected $remise;
    protected $reference;
    protected $designation;
    protected $livrer;
    protected $prepayer;
    protected $code_barre;
    protected $commander;

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

    function getId_detail_commande() {
        return $this->id_detail_commande;
    }

    function setId_detail_commande($id_detail_commande) {
        $this->id_detail_commande = $id_detail_commande;
        return $this;
    }
    
    function getCode_commande() {
        return $this->code_commande;
    }
    function setCode_commande($code_commande) {
        $this->code_commande = $code_commande;
        return $this;
    } 
  
    function getQte() {
        return $this->qte;
    }
    function setQte($qte) {
        $this->qte = $qte;
        return $this;
    }
    function getPrix_unitaire() {
        return $this->prix_unitaire;
    }
    function setPrix_unitaire($prix_unitaire) {
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }
    function getCode_barre() {
        return $this->code_barre;
    }
    function setCode_barre($code_barre) {
        $this->code_barre = $code_barre;
        return $this;
    } 
    function getRemise() {
        return $this->remise;
    }
    function setRemise($remise) {
        $this->remise = $remise;
        return $this;
    }
  
    function getReference() {
        return $this->reference;
    }
    function setReference($reference) {
        $this->reference = $reference;
        return $this;
    }
  
    function getDesignation() {
        return $this->designation;
    }
    function setDesignation($designation) {
        $this->designation = $designation;
        return $this;
    }
  
    function getLivrer() {
        return $this->livrer;
    }
    function setLivrer($livrer) {
        $this->livrer = $livrer;
        return $this;
    }
    function getPrepayer() {
        return $this->prepayer;
    }
    function setPrepayer($prepayer) {
        $this->prepayer = $prepayer;
        return $this;
    }
  
    function getCommander() {
        return $this->commander;
    }
    function setCommander($commander) {
        $this->commander = $commander;
        return $this;
    }

}


