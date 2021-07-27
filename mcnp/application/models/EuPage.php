<?php

class Application_Model_EuPage {

    //put your code here
    protected $id_page;
    protected $titre;
    protected $resume;
    protected $description;
    protected $vignette;
    protected $menu;
    protected $menusous;
    protected $publier;
    protected $ordre;
    protected $spotlight;
    protected $deroulant;
    protected $titre_autre;
    protected $titre_deroulant;
    protected $liendirect;
    
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

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

    public function getId_page() {
        return $this->id_page;
    }

    public function setId_page($id_page) {
        $this->id_page = $id_page;
        return $this;
    }

    public function getResume() {
        return ($this->resume);
    }

    public function setResume($resume) {
        $this->resume = ($resume);
        return $this;
    }

    public function getDescription() {
        return ($this->description);
    }

    public function setDescription($description) {
        $this->description = ($description);
        return $this;
    }

    public function getVignette() {
        return $this->vignette;
    }

    public function setVignette($vignette) {
        $this->vignette = $vignette;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getTitre() {
        return ($this->titre);
    }

    public function setTitre($titre) {
        $this->titre = ($titre);
        return $this;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function setMenu($menu) {
        $this->menu = $menu;
        return $this;
    }
    
    public function getMenusous() {
        return $this->menusous;
    }

    public function setMenusous($menusous) {
        $this->menusous = $menusous;
        return $this;
    }
    

    public function getOrdre() {
        return $this->ordre;
    }

    public function setOrdre($ordre) {
        $this->ordre = $ordre;
        return $this;
    }


    public function getSpotlight() {
        return $this->spotlight;
    }

    public function setSpotlight($spotlight) {
        $this->spotlight = $spotlight;
        return $this;
    }

    public function getDeroulant() {
        return $this->deroulant;
    }

    public function setDeroulant($deroulant) {
        $this->deroulant = $deroulant;
        return $this;
    }

    public function getTitre_autre() {
        return ($this->titre_autre);
    }

    public function setTitre_autre($titre_autre) {
        $this->titre_autre = ($titre_autre);
        return $this;
    }

    public function getTitre_deroulant() {
        return ($this->titre_deroulant);
    }

    public function setTitre_deroulant($titre_deroulant) {
        $this->titre_deroulant = ($titre_deroulant);
        return $this;
    }

    public function getLiendirect() {
        return ($this->liendirect);
    }

    public function setLiendirect($liendirect) {
        $this->liendirect = ($liendirect);
        return $this;
    }

}

?>
