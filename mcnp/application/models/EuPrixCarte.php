<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuPrixCarte
 *
 * @author user
 */
class Application_Model_EuPrixCarte {

    //put your code here
    protected $id_prix_carte;
    protected $code_cat;
    protected $embosser;
    protected $prix_carte;

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid prix_carte property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid prix_carte property');
        }
        return $this->$method();
    }

    public function exchangeArray($data) {
        $this->id_prix_carte = (isset($data['id_prix_carte'])) ? $data['id_prix_carte'] : NULL;
        $this->code_cat = (isset($data['code_cat'])) ? $data['code_cat'] : NULL;
        $this->embosser = (isset($data['embosser'])) ? $data['embosser'] : NULL;
        $this->prix = (isset($data['prix'])) ? $data['prix'] : 0;
    }

    public function toArray() {
        $data = array(
            'id_prix_carte' => $this->id_prix_carte,
            'code_cat' => $this->code_cat,
            'embosser' => $this->embosser,
            'prix' => $this->prix
        );
        return $data;
    }

    public function getId_prix_carte() {
        return $this->id_prix_carte;
    }

    public function setId_prix_carte($id_prix_carte) {
        $this->id_prix_carte = $id_prix_carte;
        return $this;
    }

    function getCode_cat() {
        return $this->code_cat;
    }

    function setCode_cat($code_cat) {
        $this->code_cat = $code_cat;
        return $this;
    }

    public function getEmbosser() {
        return $this->embosser;
    }

    public function setEmbosser($embosser) {
        $this->embosser = $embosser;
        return $this;
    }

    public function getPrix_carte() {
        return $this->prix_carte;
    }

    public function setPrix_carte($prix_carte) {
        $this->prix_carte = $prix_carte;
        return $this;
    }

}

?>
