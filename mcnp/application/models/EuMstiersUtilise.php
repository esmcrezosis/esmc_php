<?php
 
class Application_Model_EuMstiersUtilise {

    //put your code here
    protected $id_mstiers_utilise;
    protected $id_mstiers;
    protected $code_caps;
	protected $code_bnp;
    protected $montant_utilise;
	protected $date_mstiers_utilise;
    

	
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
	
	public function getId_mstiers_utilise() {
      return $this->id_mstiers_utilise;
    }

    public function setId_mstiers_utilise($id_mstiers_utilise) {
        $this->id_mstiers_utilise = $id_mstiers_utilise;
        return $this;
    }
	

    public function getId_mstiers() {
      return $this->id_mstiers;
    }

    public function setId_mstiers($id_mstiers) {
        $this->id_mstiers = $id_mstiers;
        return $this;
    }
	

    public function getCode_caps() {
        return $this->code_caps;
    }

    public function setCode_caps($code_caps) {
        $this->code_caps = $code_caps;
        return $this;
    }
	
	
	public function getCode_bnp() {
        return $this->code_bnp;
    }

    public function setCode_bnp($code_bnp) {
        $this->code_bnp = $code_bnp;
        return $this;
    }


    public function getMontant_utilise() {
        return $this->montant_utilise;
    }

    public function setMontant_utilise($montant_utilise) {
        $this->montant_utilise = $montant_utilise;
        return $this;
    }
	
	
	public function getDate_mstiers_utilise() {
        return $this->date_mstiers_utilise;
    }

    public function setDate_mstiers_utilise($date_mstiers_utilise) {
        $this->date_mstiers_utilise = $date_mstiers_utilise;
        return $this;
    }
    

}

?>
