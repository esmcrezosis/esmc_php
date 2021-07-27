<?php
 
class Application_Model_EuMembreasso {

    //put your code here
    protected $membreasso_id;
    protected $membreasso_nom;
    protected $membreasso_prenom;
    protected $membreasso_mobile;
    protected $membreasso_association;
    protected $membreasso_email;
    protected $membreasso_login;
    protected $membreasso_passe;
    protected $membreasso_type;
    protected $membreasso_date;
    protected $publier;
    protected $local;
    protected $souscription_id;
    protected $integrateur_id;
    protected $code_membre;
    protected $appro;

    public function __construct(array $options = null) {
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

    public function getMembreasso_id() {
        return $this->membreasso_id;
    }

    public function setMembreasso_id($membreasso_id) {
        $this->membreasso_id = $membreasso_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getMembreasso_nom() {
        return htmlentities($this->membreasso_nom);
    }

    public function setMembreasso_nom($membreasso_nom) {
        $this->membreasso_nom = html_entity_decode($membreasso_nom);
        return $this;
    }

    public function getMembreasso_prenom() {
        return htmlentities($this->membreasso_prenom);
    }

    public function setMembreasso_prenom($membreasso_prenom) {
        $this->membreasso_prenom = html_entity_decode($membreasso_prenom);
        return $this;
    }

    public function getMembreasso_mobile() {
        return $this->membreasso_mobile;
    }

    public function setMembreasso_mobile($membreasso_mobile) {
        $this->membreasso_mobile = $membreasso_mobile;
        return $this;
    }

    public function getMembreasso_association() {
        return $this->membreasso_association;
    }

    public function setMembreasso_association($membreasso_association) {
        $this->membreasso_association = $membreasso_association;
        return $this;
    }

    public function getMembreasso_email() {
        return htmlentities($this->membreasso_email);
    }

    public function setMembreasso_email($membreasso_email) {
        $this->membreasso_email = html_entity_decode($membreasso_email);
        return $this;
    }

    public function getMembreasso_login() {
        return htmlentities($this->membreasso_login);
    }

    public function setMembreasso_login($membreasso_login) {
        $this->membreasso_login = html_entity_decode($membreasso_login);
        return $this;
    }

    public function getMembreasso_passe() {
        return htmlentities($this->membreasso_passe);
    }

    public function setMembreasso_passe($membreasso_passe) {
        $this->membreasso_passe = html_entity_decode($membreasso_passe);
        return $this;
    }

    public function getMembreasso_type() {
        return htmlentities($this->membreasso_type);
    }

    public function setMembreasso_type($membreasso_type) {
        $this->membreasso_type = html_entity_decode($membreasso_type);
        return $this;
    }

    public function getMembreasso_date() {
        return $this->membreasso_date;
    }

    public function setMembreasso_date($membreasso_date) {
        $this->membreasso_date = $membreasso_date;
        return $this;
    }

    public function getLocal() {
        return $this->local;
    }

    public function setLocal($local) {
        $this->local = $local;
        return $this;
    }

    public function getSouscription_id() {
        return $this->souscription_id;
    }

    public function setSouscription_id($souscription_id) {
        $this->souscription_id = $souscription_id;
        return $this;
    }
    
    public function getIntegrateur_id() {
        return $this->integrateur_id;
    }

    public function setIntegrateur_id($integrateur_id) {
        $this->integrateur_id = $integrateur_id;
        return $this;
    }
    
    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
    
    public function getAppro() {
        return $this->appro;
    }

    public function setAppro($appro) {
        $this->appro = $appro;
        return $this;
    }
    
    
    
    
    

}

?>
