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
class Application_Model_EuSalaireAffecter {

    //put your code here
    protected $id_affectation;
    protected $id_smc;
    protected $id_credit;
    protected $id_credit_affecter;
    protected $date_affectation;
    protected $heure_affectation;
    protected $mont_affecter;
    protected $type_cncs;
    protected $code_membre;
    protected $code_membre_emp;
    protected $id_utilisateur;
    protected $id_operation;
    protected $date_deb;
    protected $date_fin;

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

    public function getId_affectation() {
        return $this->id_affectation;
    }

    public function setId_affectation($id_affectation) {
        $this->id_affectation = $id_affectation;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }

    public function getId_smc() {
        return $this->id_smc;
    }

    public function setId_smc($id_smc) {
        $this->id_smc = $id_smc;
        return $this;
    }

    public function getId_credit_affecter() {
        return $this->id_credit_affecter;
    }

    public function setId_credit_affecter($id_credit_affecter) {
        $this->id_credit_affecter = $id_credit_affecter;
        return $this;
    }

    function getId_operation() {
        return $this->id_operation;
    }

    function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }

    public function getDate_affectation() {
        return $this->date_affectation;
    }

    public function setDate_affectation($date_affectation) {
        $this->date_affectation = $date_affectation;
        return $this;
    }
    
    public function getHeure_affectation() {
        return $this->heure_affectation;
    }

    public function setHeure_affectation($heure_affectation) {
        $this->heure_affectation = $heure_affectation;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = (string) $code_membre;
        return $this;
    }
    
    function getCode_membre_epm() {
        return $this->code_membre_emp;
    }

    function setCode_membre_emp($code_membre_emp) {
        $this->code_membre_emp = (string) $code_membre_emp;
        return $this;
    }

    public function getMont_affecter() {
        return $this->mont_affecter;
    }

    public function setMont_affecter($mont_affecter) {
        $this->mont_affecter = $mont_affecter;
        return $this;
    }

    function getDate_fin() {
        return $this->date_fin;
    }

    function setDate_fin($date_fin) {
        $this->date_fin = (string) $date_fin;
        return $this;
    }

    function getDate_deb() {
        return $this->date_deb;
    }

    function setDate_deb($date_deb) {
        $this->date_deb = (string) $date_deb;
        return $this;
    }

    public function getType_cncs() {
        return $this->type_cncs;
    }

    public function setType_cncs($type_cncs) {
        $this->type_cncs = $type_cncs;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_affectation = (isset($data['id_affectation'])) ? $data['id_affectation'] : NULL;
        $this->id_smc = (isset($data['id_smc'])) ? $data['id_smc'] : NULL;
        $this->id_credit = (isset($data['id_credit'])) ? $data['id_credit'] : NULL;
        $this->id_credit_affecter = (isset($data['id_credit_affecter'])) ? $data['id_credit_affecter'] : NULL;
        $this->date_affectation = (isset($data['date_affectation'])) ? $data['date_affectation'] : NULL;
        $this->heure_affectation = (isset($data['heure_affectation'])) ? $data['heure_affectation'] : NULL;
        $this->type_cncs = (isset($data['type_cncs'])) ? $data['type_cncs'] : NULL;
        $this->mont_affecter = (isset($data['mont_affecter'])) ? $data['mont_affecter'] : NULL;
        $this->id_operation = (isset($data['id_operation'])) ? $data['id_operation'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
        $this->code_membre_emp = (isset($data['code_membre_emp'])) ? $data['code_membre_emp'] : NULL;
        $this->date_deb = (isset($data['date_deb'])) ? $data['date_deb'] : NULL;
        $this->date_fin = (isset($data['date_fin'])) ? $data['date_fin'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_affectation' => $this->id_affectation,
            'id_smc' => $this->id_smc,
            'id_credit' => $this->id_credit,
            'id_credit_affecter' => $this->id_credit_affecter,
            'date_affectation' => $this->date_affectation,
            'heure_affectation' => $this->heure_affectation,
            'mont_affecter' => $this->mont_affecter,
            'type_cncs' => $this->type_cncs,
            'code_membre' => $this->code_membre,
            'code_membre_emp' => $this->code_membre_emp,
            'id_operation' => $this->id_operation,
            'id_utilisateur' => $this->id_utilisateur,
            'date_deb' => $this->date_deb,
            'date_fin' => $this->date_fin
        );
        return $data;
    }

}

?>
