<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EuCnpEntree
 *
 * @author user
 */
class Application_Model_EuCnpEntree {

    //put your code here
    protected $id_cnp_entree;
    protected $id_cnp;
    protected $date_entree;
    protected $mont_cnp_entree;
    protected $type_cnp_entree;

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

    public function getId_cnp_entree() {
        return $this->id_cnp_entree;
    }

    public function setId_cnp_entree($id_cnp_entree) {
        $this->id_cnp_entree = $id_cnp_entree;
        return $this;
    }

    public function getId_cnp() {
        return $this->id_cnp;
    }

    public function setId_cnp($id_cnp) {
        $this->id_cnp = $id_cnp;
        return $this;
    }

    public function getDate_entree() {
        return $this->date_entree;
    }

    public function setDate_entree($date_entree) {
        $this->date_entree = $date_entree;
        return $this;
    }

    public function getMont_cnp_entree() {
        return $this->mont_cnp_entree;
    }

    public function setMont_cnp_entree($mont_cnp_entree) {
        $this->mont_cnp_entree = $mont_cnp_entree;
        return $this;
    }

    public function getType_cnp_entree() {
        return $this->type_cnp_entree;
    }

    public function setType_cnp_entree($type_cnp_entree) {
        $this->type_cnp_entree = $type_cnp_entree;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_cnp = (isset($data['id_cnp'])) ? $data['id_cnp'] : NULL;
        $this->id_cnp_entree = (isset($data['id_cnp_entree'])) ? $data['id_cnp_entree'] : NULL;
        $this->date_entree = (isset($data['date_entree'])) ? $data['date_entree'] : NULL;
        $this->type_cnp_entree = (isset($data['type_cnp_entree'])) ? $data['type_cnp_entree'] : NULL;
        $this->mont_cnp_entree = (isset($data['mont_cnp_entree'])) ? $data['mont_cnp_entree'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_cnp_entree' => $this->id_cnp_entree,
            'id_cnp' => $this->id_cnp,
            'date_entree' => $this->date_entree,
            'mont_cnp_entree' => $this->mont_cnp_entree,
            'type_cnp_entree' => $this->type_cnp_entree
        );
        return $data;
    }

}

?>
