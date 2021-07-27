<?php

class Application_Model_EuArticleStockesCategorie {

    //put your code here
    protected $id_article_stockes_categorie;
    protected $nom_article_stockes_categorie;
    protected $code_membre_morale;
    protected $etat;
	protected $code_tegc;
	
	

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

    public function getId_article_stockes_categorie() {
        return $this->id_article_stockes_categorie;
    }

    public function setId_article_stockes_categorie($id_article_stockes_categorie) {
        $this->id_article_stockes_categorie = $id_article_stockes_categorie;
        return $this;
    }
    
    public function getNom_article_stockes_categorie() {
        return $this->nom_article_stockes_categorie;
    }

    public function setNom_article_stockes_categorie($nom_article_stockes_categorie) {
        $this->nom_article_stockes_categorie = $nom_article_stockes_categorie;
        return $this;
    }


    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }


    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
	
	public function getCode_tegc() {
        return $this->code_tegc;
    }

    public function setCode_tegc($code_tegc) {
        $this->code_tegc = $code_tegc;
        return $this;
    }
	
	
	
	
	
	
}

?>
