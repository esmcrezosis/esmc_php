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
class Application_Model_EuEmploye {

    //put your code here
    protected $id_employe;
    protected $code_membre_employeur;
    protected $code_membre_employe;
    protected $date_declaration;
    protected $cnss;
    protected $mont_salaire;

    public function __construct(array $options = null) {
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

    public function getId_employe() {
        return $this->id_employe;
    }

    public function setId_employe($id_employe) {
        $this->id_employe = $id_employe;
        return $this;
    }

    public function getCode_membre_employeur() {
        return $this->code_membre_employeur;
    }

    public function setCode_membre_employeur($code_membre_employeur) {
        $this->code_membre_employeur = $code_membre_employeur;
        return $this;
    }

    public function getCode_membre_employe() {
        return $this->code_membre_employe;
    }

    public function setCode_membre_employe($code_membre_employe) {
        $this->code_membre_employe = $code_membre_employe;
        return $this;
    }

    public function getDate_declaration() {
        return $this->date_declaration;
    }

    public function setDate_declaration($date_declaration) {
        $this->date_declaration = $date_declaration;
        return $this;
    }

    public function getCnss() {
        return $this->cnss;
    }

    public function setCnss($cnss) {
        $this->cnss = $cnss;
        return $this;
    }

    public function getMont_salaire() {
        return $this->mont_salaire;
    }

    public function setMont_salaire($mont_salaire) {
        $this->mont_salaire = $mont_salaire;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_employe = (isset($data['id_employe'])) ? $data['id_employe'] : null;
        $this->code_membre_employeur = (isset($data['code_membre_employeur'])) ? $data['code_membre_employeur'] : null;
        $this->date_declaration = (isset($data['date_declaration'])) ? $data['date_declaration'] : null;
        $this->code_membre_employe = (isset($data['code_membre_employe'])) ? $data['code_membre_employe'] : null;
        $this->cnss = (isset($data['cnss'])) ? $data['cnss'] : null;
        $this->mont_salaire = (isset($data['mont_salaire'])) ? $data['mont_salaire'] : 0;
    }

    public function toArray() {
        $data = array(
            'id_employe' => $this->id_employe,
            'code_membre_employeur' => $this->code_membre_employeur,
            'date_declaration' => $this->date_declaration,
            'code_membre_employe' => $this->code_membre_employe,
            'cnss' => $this->cnss,
            'mont_salaire' => $this->mont_salaire
        );
        return $data;
    }

}

?>
