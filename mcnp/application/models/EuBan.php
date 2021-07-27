<?php
 
class Application_Model_EuBan {

    //put your code here
    protected $id_ban;
    protected $code_membre;
    protected $date_emission;
    protected $mont_emis;
    protected $mont_vendu;
    protected $solde;


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

    public function getId_ban() {
        return $this->id_ban;
    }

    public function setId_ban($id_ban) {
        $this->id_ban = $id_ban;
        return $this;
    }

    public function getDate_emission() {
        return $this->date_emission;
    }

    public function setDate_emission($date_emission) {
        $this->date_emission = $date_emission;
        return $this;
    }

    public function getMont_vendu() {
        return $this->mont_vendu;
    }

    public function setMont_vendu($mont_vendu) {
        $this->mont_vendu = $mont_vendu;
        return $this;
    }

    public function getSolde() {
        return $this->solde;
    }

    public function setSolde($solde) {
        $this->solde = $solde;
        return $this;
    }

    public function getMont_emis() {
        return ($this->mont_emis);
    }

    public function setMont_emis($mont_emis) {
        $this->mont_emis = ($mont_emis);
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }



}

?>
