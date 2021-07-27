<?php

/**
 * Description of EuOperation
 *
 * @author user
 */
class Application_Model_EuOperation {

    //put your code here
    protected $id_operation;
    protected $date_op;
    protected $heure_op;
    protected $montant_op;
    protected $code_membre;
	protected $code_membre_morale;
    protected $code_produit;
    protected $id_utilisateur;
    protected $lib_op;
    protected $code_cat;
    protected $type_op;

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

    public function getId_operation() {
        return $this->id_operation;
    }

    public function setId_operation($id_operation) {
        $this->id_operation = $id_operation;
        return $this;
    }

    public function getDate_op() {
        return $this->date_op;
    }

    public function setDate_op($date_op) {
        $this->date_op = $date_op;
        return $this;
    }
    
    public function getHeure_op(){
        return $this->heure_op;
    }
    
    public function setHeure_op($heure_op){
        $this->heure_op = $heure_op;
        return $this;
    }
    
    public function getMontant_op(){
        return $this->montant_op;
    }
    
    public function setMontant_op($montant_op){
        $this->montant_op = $montant_op;
        return $this;
    }
    
    public function getCode_membre(){
        return $this->code_membre;
    }
    
    public function setCode_membre($code_membre){
        $this->code_membre = $code_membre;
        return $this;
    }
	
	public function getCode_membre_morale(){
        return $this->code_membre_morale;
    }
    
    public function setCode_membre_morale($code_membre_morale){
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }
	
    public function getCode_produit(){
        return $this->code_produit;
    }
    
    public function setCode_produit($code_produit){
        $this->code_produit = $code_produit;
        return $this;
    }
    
    public function getId_utilisateur(){
        return $this->id_utilisateur;
    }
    
    public function setId_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    public function getLib_op(){
        return $this->lib_op;
    }
    
    public function setLib_op($lib_op){
        $this->lib_op = $lib_op;
        return $this;
    }
    
    public function getCode_cat(){
        return $this->code_cat;
    }
    
    public function setCode_cat($code_cat){
        $this->code_cat = $code_cat;
        return $this;
    }
    
    public function getType_op(){
        return $this->type_op;
    }
    
    public function setType_op($type_op){
        $this->type_op = $type_op;
        return $this;
    }

}

?>
