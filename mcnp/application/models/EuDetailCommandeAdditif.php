<?php

class Application_Model_EuDetailCommandeAdditif {

    //put your code here
    protected $id_detail_commande_additif;
    protected $id_detail_commande;
    protected $reference_additif;
    protected $id_article_stockes_additif;

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

    public function getId_detail_commande_additif() {
        return $this->id_detail_commande_additif;
    }

    public function setId_detail_commande_additif($id_detail_commande_additif) {
        $this->id_detail_commande_additif = $id_detail_commande_additif;
        return $this;
    }
    
    public function getId_detail_commande() {
        return $this->id_detail_commande;
    }

    public function setId_detail_commande($id_detail_commande) {
        $this->id_detail_commande = $id_detail_commande;
        return $this;
    }


    public function getId_article_stockes_additif() {
        return $this->id_article_stockes_additif;
    }

    public function setId_article_stockes_additif($id_article_stockes_additif) {
        $this->id_article_stockes_additif = $id_article_stockes_additif;
        return $this;
    }


    public function getReference_additif() {
        return $this->reference_additif;
    }

    public function setReference_additif($reference_additif) {
        $this->reference_additif = $reference_additif;
        return $this;
    }

	
}

?>
