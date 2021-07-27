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
class Application_Model_EuRegion {

    //put your code here
    protected $id_region;
    protected $nom_region;
    protected $id_pays;
    protected $id_utilisateur;

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

    public function getId_region() {
        return $this->id_region;
    }

    public function setId_region($id_region) {
        $this->id_region = $id_region;
        return $this;
    }

    public function getNom_region() {
        return $this->nom_region;
    }

    public function setNom_region($nom_region) {
        $this->nom_region = $nom_region;
        return $this;
    }

    public function getId_pays() {
        return $this->id_pays;
    }

    public function setId_pays($id_pays) {
        $this->id_pays = $id_pays;
        return $this;
    }
    
    public function getId_utilisateur(){
        return $this->id_utilisateur;
    }
    
     public function setId_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_region = (isset($data['id_region'])) ? $data['id_region'] : NULL;
        $this->nom_region = (isset($data['nom_region'])) ? $data['nom_region'] : NULL;
        $this->id_pays = (isset($data['id_pays'])) ? $data['id_pays'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_region' => $this->id_region,
            'nom_region' => $this->nom_region,
            'id_pays' => $this->id_pays,
            'id_utilisateur' => $this->id_utilisateur
        );
        return $data;
    }

}

?>
