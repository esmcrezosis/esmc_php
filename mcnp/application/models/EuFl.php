<?php

class Application_Model_EuFl {

    protected $code_fl;
    protected $code_membre;
    protected $mont_fl;
    protected $date_fl;
    protected $heure_fl;
    protected $id_utilisateur;
    protected $code_membre_morale;
    protected $creditcode;
	protected $origine_fl;

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

    function getCode_fl() {
        return $this->code_fl;
    }

    function setCode_fl($code_fl) {
        $this->code_fl = $code_fl;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre =  $code_membre;
        return $this;
    }
    
    function getMont_fl() {
        return $this->mont_fl;
    }

    function setMont_fl($mont_fl) {
        $this->mont_fl =  $mont_fl;
        return $this;
    }

    function getDate_fl() {
        return $this->date_fl;
    }

    function setDate_fl($date_fl) {
        $this->date_fl =  $date_fl;
        return $this;
    }

    function getHeure_fl() {
        return $this->heure_fl;
    }
	
	function getOrigine_fl() {
        return $this->origine_fl;
    }

    function setOrigine_fl($origine_fl) {
        $this->origine_fl =  $origine_fl;
        return $this;
    }
	

    function setHeure_fl($heure_fl) {
        $this->heure_fl = $heure_fl;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
    
    public function getCreditcode(){
        return $this->creditcode;
    }
    
    public function setCreditcode($creditcode){
        $this->creditcode = $creditcode;
        return $this;
    }

    function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale =  $code_membre_morale;
        return $this;
    }

    public function exchangeArray($data) {
        $this->code_fl = (isset($data['code_fl'])) ? $data['code_fl'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
        $this->creditcode = (isset($data['creditcode'])) ? $data['creditcode'] : NULL;
        $this->mont_fl = (isset($data['mont_fl'])) ? $data['mont_fl'] : NULL;
        $this->date_fl = (isset($data['date_fl'])) ? $data['date_fl'] : NULL;
        $this->heure_fl = (isset($data['heure_fl'])) ? $data['heure_fl'] : NULL;
		 $this->origine_fl = (isset($data['origine_fl'])) ? $data['origine_fl'] : NULL;
        $this->code_membre_morale = (isset($data['code_membre_morale'])) ? $data['code_membre_morale'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
    }

    public function toArray() {
        $data = array(
            'code_fl' => $this->code_fl,
            'creditcode' => $this->creditcode,
            'code_membre' => $this->code_membre,
            'mont_fl' => $this->mont_fl,
            'date_fl' => $this->date_fl,
            'heure_fl' => $this->heure_fl,
			'origine_fl' => $this->origine_fl,
            'code_membre_morale' => $this->code_membre_morale,
            'id_utilisateur' => $this->id_utilisateur
        );
        return $data;
    }

}

