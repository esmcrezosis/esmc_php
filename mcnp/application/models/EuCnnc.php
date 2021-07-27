<?php

/**
 * Description of EuOperation
 *
 * @author user
 */
class Application_Model_EuCnnc {
    //put your code here
    protected $id_cnnc;
    protected $code_membre;
    protected $datefin;
    protected $libelle;
    protected $mont_credit;
    protected $source_credit;
	protected $id_credit;
	protected $mont_utilise;
	protected $solde;
	

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

   
    public function getId_cnnc() {
        return $this->id_cnnc;
    }

    public function setId_cnnc($id_cnnc) {
        $this->id_cnnc = $id_cnnc;
        return $this;
    }
    
     public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getDatefin(){
        return $this->datefin;
    }
    
    public function setDatefin($datefin){
        $this->datefin = $datefin;
        return $this;
    }
	
    public function getLibelle(){
        return $this->libelle;
    }
    
    public function setLibelle($libelle){
        $this->libelle = $libelle;
        return $this;
    }
    
    public function getMont_credit(){
        return $this->mont_credit;
    }
    
    public function setMont_credit($mont_credit){
        $this->mont_credit = $mont_credit;
        return $this;
    }
    
    public function getSource_credit(){
        return $this->source_credit;
    }
    
    public function setSource_credit($source_credit){
        $this->source_credit = $source_credit;
        return $this;
    }
	
	public function getId_credit(){
        return $this->id_credit;
    }
    
    public function setId_credit($id_credit){
        $this->id_credit = $id_credit;
        return $this;
    }
	
    public function getMont_utilise(){
        return $this->mont_utilise;
    }
    
    public function setMont_utilise($mont_utilise){
        $this->mont_utilise = $mont_utilise;
        return $this;
    }
	
	public function getSolde(){
        return $this->solde;
    }
    
    public function setSolde($solde){
        $this->solde = $solde;
        return $this;
    }
	
}

?>
