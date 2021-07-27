<?php
class Application_Model_EuAncienFl {

    protected $code_fl;
    protected $code_membre;
    protected $mont_fl;
    protected $date_fl;
    protected $heure_fl;
    protected $id_utilisateur;
	protected $creditcode;

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
        $this->code_membre = (string) $code_membre;
        return $this;
    }
    
    function getMont_fl() {
        return $this->mont_fl;
    }

    function setMont_fl($mont_fl) {
        $this->mont_fl = (string) $mont_fl;
        return $this;
    }

    function getDate_fl() {
        return $this->date_fl;
    }

    function setDate_fl($date_fl) {
        $this->date_fl = (string) $date_fl;
        return $this;
    }

    function getHeure_fl() {
        return $this->heure_fl;
    }

    function setHeure_fl($heure_fl) {
        $this->heure_fl = (string) $heure_fl;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }
	
	function getCreditcode() {
        return $this->creditcode;
    }

    function setCreditcode($creditcode) {
        $this->creditcode = $creditcode;
        return $this;
    }
	
	

    public function exchangeArray($data) {
        $this->code_fl = (isset($data['code_fl'])) ? $data['code_fl'] : NULL;
        $this->code_membre = (isset($data['code_membre'])) ? $data['code_membre'] : NULL;
        $this->mont_fl = (isset($data['mont_fl'])) ? $data['mont_fl'] : NULL;
        $this->date_fl = (isset($data['date_fl'])) ? $data['date_fl'] : NULL;
        $this->heure_fl = (isset($data['heure_fl'])) ? $data['heure_fl'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
		$this->creditcode = (isset($data['creditcode'])) ? $data['creditcode'] : NULL;
    }

    public function toArray() {
        $data = array(
         'code_fl' => $this->code_fl,
         'code_membre' => $this->code_membre,
         'mont_fl' => $this->mont_fl,
         'date_fl' => $this->date_fl,
         'heure_fl' => $this->heure_fl,
         'id_utilisateur' => $this->id_utilisateur,
		 'creditcode' => $this->creditcode
        );
        return $data;
    }

}

