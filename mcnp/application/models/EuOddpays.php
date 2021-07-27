<?php

class Application_Model_EuOddpays {
    
    protected $id_odd_pays;
    protected $titre;
    protected $resume;
    protected $description;
    protected $vignette;
    protected $statut;
    protected $liendirect;
    protected $date_creation;
    protected $id_pays;

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
    

    function getId_odd_pays() {
      return $this->id_odd_pays;
    }

    function setId_odd_pays($id_odd_pays) {
      $this->id_odd_pays = $id_odd_pays;
      return $this;
    }

    function getTitre() {
        return $this->titre;
    }

    function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

    function getResume() {
        return $this->resume;
    }

    function setResume($resume) {
        $this->resume = $resume;
        return $this;
    }

    
    function getDescription() {
      return $this->description;
    }

    function setDescription($description) {
      $this->description = $description;
      return $this;
    }
    
    
    function getVignette() {
      return $this->vignette;
    }

    function setVignette($vignette) {
      $this->vignette = $vignette;
      return $this;
    }
    
    function getStatut() {
      return $this->statut;
    }

    function setStatut($statut) {
      $this->statut = $statut;
      return $this;
    }
    
    function getLiendirect() {
      return $this->liendirect;
    }

    function setLiendirect($liendirect) {
      $this->liendirect = $liendirect;
      return $this;
    }
    
    function getDate_creation() {
      return $this->date_creation;
    }

    function setDate_creation($date_creation) {
      $this->date_creation = $date_creation;
      return $this;
    }

    function getId_pays() {
      return $this->id_pays;
    }

    function setId_pays($id_pays) {
      $this->id_pays = $id_pays;
      return $this;
    }

    
    
    
    
}

