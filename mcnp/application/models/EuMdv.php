<?php
class Application_Model_EuMdv {
    
    protected $id_mdv;
    protected $duree_vie;
    protected $id_filiere;
    protected $code_membre;
    
    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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
    
    function getId_mdv() {
        return $this->id_mdv;
    }

    function setId_mdv($id_mdv) {
        $this->id_mdv = $id_mdv;
        return $this;
    }
   
    function getDuree_vie() {
        return $this->duree_vie;
    }

    function setDuree_vie($duree_vie) {
        $this->duree_vie = $duree_vie;
        return $this;
    }
    
    function getId_filiere() {
        return $this->id_filiere;
    }

    function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }

    
    function getCode_membre() {
        return $this->code_membre;
    }


    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    
}
?>

