<?php

class Application_Model_EuPartenaire
{

  protected $code_partenaire;
    protected $type_partenaire;
    protected $nom_partenaire;
     protected $tel_partenaire;
    protected $bp_partenaire;
    protected $fax_partenaire;
     protected $email_partenaire;
    protected $interlocuteur;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
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

    function getCode_partenaire() {
        return $this->code_partenaire;
    }

    function setCode_partenaire($code_partenaire) {
        $this->code_partenaire = $code_partenaire;
        return $this;
    }

    function getType_partenaire() {
        return $this->type_partenaire;
    }

    function setType_partenaire($type_partenaire) {
        $this->type_partenaire = (string)$type_partenaire;
        return $this;
    }

    function getNom_partenaire() {
        return $this->nom_partenaire;
    }

    function setNom_partenaire($nom_partenaire) {
        $this->nom_partenaire = (string)$nom_partenaire;
        return $this;
    }
    function getTel_partenaire() {
        return $this->tel_partenaire;
    }

    function setTel_partenaire($tel_partenaire) {
        $this->tel_partenaire = (string)$tel_partenaire;
        return $this;
    }
    function getBp_partenaire() {
        return $this->bp_partenaire;
    }

    function setBp_partenaire($bp_partenaire) {
        $this->bp_partenaire = (string)$bp_partenaire;
        return $this;
    }
    function getFax_partenaire() {
        return $this->fax_partenaire;
    }

    function setFax_partenaire($fax_partenaire) {
        $this->fax_partenaire = (string)$fax_partenaire;
        return $this;
    }
    function getEmail_partenaire() {
        return $this->email_partenaire;
    }

    function setEmail_partenaire($email_partenaire) {
        $this->email_partenaire = (string)$email_partenaire;
        return $this;
    }
    function getInterlocuteur() {
        return $this->interlocuteur;
    }

    function setInterlocuteur($interlocuteur) {
        $this->interlocuteur = (string)$interlocuteur;
        return $this;
    }
}

