<?php

/**
 * Description of EuOperation
 *
 * @author user
 */
class Application_Model_EuCompensation {

    //put your code here
    protected $id_compens;
    protected $code_compte;
    protected $mont_compens;
    protected $code_membre_pbf;
    protected $code_membre_benef;
    protected $date_compens;
    protected $heure_compens;
    protected $id_operation;
    protected $ntf;
    protected $reste_ntf;
    protected $mont_tranche;
    protected $date_deb;
    protected $periode;
    protected $date_fin;
    protected $mont_echu;
    protected $date_deb_tranche;
    protected $date_fin_tranche;
    protected $solde_compensation;

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

    public function getId_compens() {
        return $this->id_compens;
    }

    public function setId_compens($id_compens) {
        $this->id_compens = $id_compens;
        return $this;
    }

    public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }

    public function getCode_membre_pbf() {
        return $this->code_membre_pbf;
    }

    public function setCode_membre_pbf($code_membre_pbf) {
        $this->code_membre_pbf = $code_membre_pbf;
        return $this;
    }

    public function getCode_membre_benef() {
        return $this->code_membre_benef;
    }

    public function setCode_membre_benef($code_membre_benef) {
        $this->code_membre_benef = $code_membre_benef;
        return $this;
    }

    public function getMont_compens() {
        return $this->mont_compens;
    }

    public function setMont_compens($mont_compens) {
        $this->mont_compens = $mont_compens;
        return $this;
    }

    public function getDate_compens() {
        return $this->date_compens;
    }

    public function setDate_compens($date_compens) {
        $this->date_compens = $date_compens;
        return $this;
    }

    public function getHeure_compens() {
        return $this->heure_compens;
    }

    public function setHeure_compens($heure_compens) {
        $this->heure_compens = $heure_compens;
        return $this;
    }

    public function getId_operation() {
        return $this->id_operation;
    }

    public function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }

    function getNtf() {
        return $this->ntf;
    }

    function setNtf($ntf) {
        $this->ntf = $ntf;
        return $this;
    }

    function getReste_ntf() {
        return $this->reste_ntf;
    }

    function setReste_ntf($reste_ntf) {
        $this->reste_ntf = $reste_ntf;
        return $this;
    }

    function getMont_tranche() {
        return $this->mont_tranche;
    }

    function setMont_tranche($mont_tranche) {
        $this->mont_tranche = $mont_tranche;
        return $this;
    }

    function getDate_deb() {
        return $this->date_deb;
    }

    function setDate_deb($date_deb) {
        $this->date_deb = $date_deb;
        return $this;
    }

    function getPeriode() {
        return $this->periode;
    }

    function setPeriode($periode) {
        $this->periode = $periode;
        return $this;
    }

    function getDate_fin() {
        return $this->date_fin;
    }

    function setDate_fin($date_fin) {
        $this->date_fin = $date_fin;
        return $this;
    }

    function getMont_echu() {
        return $this->mont_echu;
    }

    function setMont_echu($mont_echu) {
        $this->mont_echu = $mont_echu;
        return $this;
    }

    function getDate_deb_tranche() {
        return $this->date_deb_tranche;
    }

    function setDate_deb_tranche($date_deb_tranche) {
        $this->date_deb_tranche = $date_deb_tranche;
        return $this;
    }

    function getDate_fin_tranche() {
        return $this->date_fin_tranche;
    }

    function setDate_fin_tranche($date_fin_tranche) {
        $this->date_fin_tranche = $date_fin_tranche;
        return $this;
    }

    public function getSolde_compensation() {
        return $this->solde_compensation;
    }

    public function setSolde_compensation($solde_compensation) {
        $this->solde_compensation = $solde_compensation;
        return $this;
    }

}

?>
