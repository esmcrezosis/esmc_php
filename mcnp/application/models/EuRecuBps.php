<?php
 
class Application_Model_EuRecuBps {

    //put your code here
    protected $recu_bps_id;
    protected $recu_bps_libelle;
    protected $zppe_id;
    protected $recu_bps_prk;

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

    public function getRecu_bps_id() {
        return $this->recu_bps_id;
    }

    public function setRecu_bps_id($recu_bps_id) {
        $this->recu_bps_id = $recu_bps_id;
        return $this;
    }


    public function getRecu_bps_libelle() {
        return ($this->recu_bps_libelle);
    }

    public function setRecu_bps_libelle($recu_bps_libelle) {
        $this->recu_bps_libelle = ($recu_bps_libelle);
        return $this;
    }

    public function getZppe_id() {
        return $this->zppe_id;
    }

    public function setZppe_id($zppe_id) {
        $this->zppe_id = $zppe_id;
        return $this;
    }


    public function getRecu_bps_prk() {
        return ($this->recu_bps_prk);
    }

    public function setRecu_bps_prk($recu_bps_prk) {
        $this->recu_bps_prk = ($recu_bps_prk);
        return $this;
    }


}

?>
