<?php
 
class Application_Model_EuSerieOpi {

    //put your code here
    protected $acheteur_id;
    protected $acheteur_nom;

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

	
    public function getId_serie_opi() {
        return $this->id_serie_opi;
    }

    public function setId_serie_opi($id_serie_opi) {
        $this->id_serie_opi = $id_serie_opi;
        return $this;
    }

    public function getValeur_serie() {
        return $this->valeur_serie;
    }

    public function setValeur_serie($valeur_serie) {
        $this->valeur_serie = $valeur_serie;
        return $this;
    }

}

?>
