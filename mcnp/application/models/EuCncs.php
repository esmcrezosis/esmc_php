<?php

/**
 * Description of EuOperation
 *
 * @author user
 */
class Application_Model_EuCncs {

    //put your code here
    protected $id_cncs;
    protected $membre;
    protected $compte;
    protected $type;
    protected $montant;
    protected $date;

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

    public function getId_cncs() {
        return $this->id_cncs;
    }

    public function setId_cncs($id_cncs) {
        $this->id_cncs = $id_cncs;
        return $this;
    }
    
     public function getMembre() {
        return $this->membre;
    }

    public function setMembre($membre) {
        $this->membre = $membre;
        return $this;
    }
    
    public function getMontant(){
        return $this->montant;
    }
    
    public function setMontant($montant){
        $this->montant = $montant;
        return $this;
    }

    public function getType(){
        return $this->type;
    }
    
    public function setType($type){
        $this->type = $type;
        return $this;
    }
    
    public function getCompte(){
        return $this->compte;
    }
    
    public function setCompte($compte){
        $this->compte = $compte;
        return $this;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    public function setDate($date){
        $this->date = $date;
        return $this;
    }

}

?>
