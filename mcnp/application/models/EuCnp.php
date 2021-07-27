<?php

/**
 * Description of EuOperation
 *
 * @author user
 */
 
class Application_Model_EuCnp {

    //put your code here
    protected $id_cnp;
	protected $date_cnp;
	protected $mont_credit;
	protected $mont_debit;
	protected $origine_cnp;
	protected $solde_cnp;
	protected $source_credit;
	protected $transfert_gcp;
	protected $type_cnp;
    protected $code_capa;
	protected $id_credit;
	protected $code_domicilier;
	protected $id_gcp;

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
	

    public function getId_cnp() {
        return $this->id_cnp;
    }

    public function setId_cnp($id_cnp) {
        $this->id_cnp = $id_cnp;
        return $this;
    }
	
	public function getDate_cnp() {
        return $this->date_cnp;
    }

    public function setDate_cnp($date_cnp) {
        $this->date_cnp = $date_cnp;
        return $this;
    }
	
	public function getMont_credit() {
        return $this->mont_credit;
    }

    public function setMont_credit($mont_credit) {
        $this->mont_credit = $mont_credit;
        return $this;
    }
	
	public function getMont_debit() {
        return $this->mont_debit;
    }

    public function setMont_debit($mont_debit) {
        $this->mont_debit = $mont_debit;
        return $this;
    }
	
	public function getOrigine_cnp(){
        return $this->origine_cnp;
    }

    public function setOrigine_cnp($origine_cnp){
        $this->origine_cnp = $origine_cnp;
        return $this;
    }
	
	public function getSolde_cnp() {
        return $this->solde_cnp;
    }

    public function setSolde_cnp($solde_cnp) {
        $this->solde_cnp = $solde_cnp;
        return $this;
    }
	
	public function getSource_credit() {
        return $this->source_credit;
    }

    public function setSource_credit($source_credit) {
        $this->source_credit = $source_credit;
        return $this;
    }
	
	public function getTransfert_gcp(){
        return $this->transfert_gcp;
    }

    public function setTransfert_gcp($transfert_gcp){
        $this->transfert_gcp = $transfert_gcp;
        return $this;
    }
	
	public function getId_gcp() {
        return $this->id_gcp;
    }

    public function setId_gcp($id_gcp) {
        $this->id_gcp = $id_gcp;
        return $this;
    }
	
	public function getType_cnp() {
        return $this->type_cnp;
    }

    public function setType_cnp($type_cnp) {
        $this->type_cnp = $type_cnp;
        return $this;
    }
	
    public function getCode_capa() {
        return $this->code_capa;
    }

    public function setCode_capa($code_capa) {
        $this->code_capa = $code_capa;
        return $this;
    }

    public function getId_credit() {
        return $this->id_credit;
    }

    public function setId_credit($id_credit) {
        $this->id_credit = $id_credit;
        return $this;
    }


    public function getCode_domicilier() {
        return $this->code_domicilier;
    }

    public function setCode_domicilier($code_domicilie) {
        $this->code_domicilier = $code_domicilie;
        return $this;
    }
	
	
	
}

?>
