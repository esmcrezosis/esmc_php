<?php
 
class Application_Model_EuPostes {

    //put your code here
    protected $id_postes;
    protected $nom_postes;

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

    public function getId_postes() {
        return $this->id_postes;
    }

    public function setId_postes($id_postes) {
        $this->id_postes = $id_postes;
        return $this;
    }


    public function getNom_postes() {
        return ($this->nom_postes);
    }

    public function setNom_postes($nom_postes) {
        $this->nom_postes = ($nom_postes);
        return $this;
    }




}

?>
