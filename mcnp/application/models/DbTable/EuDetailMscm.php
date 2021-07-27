<?php
 
class Application_Model_EuDetailMscm {

    //put your code here
    protected $id_detail_mscm;
    protected $id_mscm;
    protected $bon_neutre_code;
    protected $montant_utilise;
    protected $id_souscription;
    protected $code_membre;
    protected $date_mscm;
    

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
	

    public function getId_detail_mscm() {
        return $this->acheteur_id;
    }

    public function setId_detail_mscm($id_detail_mscm) {
        $this->id_detail_mscm = $id_detail_mscm;
        return $this;
    }

    public function getId_mscm() {
        return $this->id_mscm;
    }

    public function setId_mscm($id_mscm) {
        $this->id_mscm = $id_mscm;
        return $this;
    }
	
    public function getBon_neutre_code() {
      return $this->bon_neutre_code;
    }

    public function setBon_neutre_code($bon_neutre_code) {
        $this->bon_neutre_code = $bon_neutre_code;
        return $this;
    }


    public function getMontant_utilise() {
      return $this->montant_utilise;
    }

    public function setMontant_utilise($montant_utilise) {
        $this->montant_utilise = $montant_utilise;
        return $this;
    }
	
    public function getId_souscription() {
        return $this->id_souscription;
    }

    public function setId_souscription($id_souscription) {
        $this->id_souscription = $id_souscription;
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getDate_mscm() {
        return $this->date_mscm;
    }

    public function setDate_mscm($date_mscm) {
        $this->date_mscm = $date_mscm;
        return $this;
    }

}

?>
