<?php

class Application_Model_EuDemande
{
    
    protected $id_demande;
    protected $objet_demande;
    protected $description_demande;
    protected $date_demande;
    protected $code_membre_morale;
    protected $publier;
    protected $livrer;
    
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

    function getId_demande() {
        return $this->id_demande;
    }

    function setId_demande($id_demande) {
        $this->id_demande = $id_demande;
        return $this;
    }


    function getObjet_demande() {
        return $this->objet_demande;
    }

    function setObjet_demande($objet_demande) {
        $this->objet_demande = (string)$objet_demande;
        return $this;
    }
	
    function getDescription_demande() {
        return $this->description_demande;
    }
    function setDescription_demande($description_demande) {
        $this->description_demande = $description_demande;
        return $this;
    }
    function getDate_demande() {
        return $this->date_demande;
    }

    function setDate_demande($date_demande) {
        $this->date_demande = $date_demande;
        return $this;
    }
    function getCode_membre_morale() {
        return $this->code_membre_morale;
    }
    function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }
    
    function getPublier() {
        return $this->publier;
    }
    
    function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }
    
    function getLivrer() {
        return $this->livrer;
    }
    
    function setLivrer($livrer) {
        $this->livrer = $livrer;
        return $this;
    }
    
}