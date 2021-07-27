<?php

class Application_Model_EuArticleStockesAdditif {

    //put your code here
    protected $id_article_stockes_additif;
    protected $nom_article_stockes_additif;
    protected $reference;
    protected $code_membre_morale;
    protected $etat;

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

    public function getId_article_stockes_additif() {
        return $this->id_article_stockes_additif;
    }

    public function setId_article_stockes_additif($id_article_stockes_additif) {
        $this->id_article_stockes_additif = $id_article_stockes_additif;
        return $this;
    }
    
    public function getNom_article_stockes_additif() {
        return $this->nom_article_stockes_additif;
    }

    public function setNom_article_stockes_additif($nom_article_stockes_additif) {
        $this->nom_article_stockes_additif = $nom_article_stockes_additif;
        return $this;
    }


    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }


    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;
        return $this;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
	
}

?>
