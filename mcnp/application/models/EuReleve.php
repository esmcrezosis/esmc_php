<?php
 
class Application_Model_EuReleve {

    //put your code here
    protected $releve_id;
    protected $releve_membre;
    protected $releve_fichier;
    protected $releve_type;
    protected $publier;
    protected $releve_date;
	protected $new_code_membre;
	protected $utilisateur;
	protected $traiter;

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

    public function getReleve_id() {
        return $this->releve_id;
    }

    public function setReleve_id($releve_id) {
        $this->releve_id = $releve_id;
        return $this;
    }

    public function getReleve_fichier() {
        return $this->releve_fichier;
    }

    public function setReleve_fichier($releve_fichier) {
        $this->releve_fichier = $releve_fichier;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getReleve_membre() {
        return ($this->releve_membre);
    }

    public function setReleve_membre($releve_membre) {
        $this->releve_membre = ($releve_membre);
        return $this;
    }

    public function getReleve_type() {
        return $this->releve_type;
    }

    public function setReleve_type($releve_type) {
        $this->releve_type = $releve_type;
        return $this;
    }

    public function getReleve_date() {
        return ($this->releve_date);
    }

    public function setReleve_date($releve_date) {
        $this->releve_date = ($releve_date);
        return $this;
    }
	
	
	public function getNew_code_membre() {
        return ($this->new_code_membre);
    }
	
	
	public function setNew_code_membre($new_code_membre) {
        $this->new_code_membre = ($new_code_membre);
        return $this;
    }
	
	public function getUtilisateur() {
        return ($this->utilisateur);
    }
	
	
    public function setUtilisateur($utilisateur) {
        $this->utilisateur = ($utilisateur);
        return $this;
    }
	
	
	public function getTraiter() {
       return ($this->traiter);
    }
	
	
    public function setTraiter($traiter) {
        $this->traiter = ($traiter);
        return $this;
    }


}

?>
