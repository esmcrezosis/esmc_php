<?php
 
class Application_Model_EuMembretiers {

    //put your code here
    protected $membretiers_id;
    protected $membretiers_nom;
    protected $membretiers_prenom;
    protected $membretiers_mobile;
    protected $membretiers_souscription;
    protected $membretiers_email;
    protected $membretiers_date;
    protected $membretiers_filiere;
    protected $id_metier;
    protected $id_competence;
    protected $code_activite;
    protected $membretiers_quartier;
    protected $membretiers_ville;
    protected $publier;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid categorie property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getMembretiers_id() {
        return $this->membretiers_id;
    }

    public function setMembretiers_id($membretiers_id) {
        $this->membretiers_id = $membretiers_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getMembretiers_nom() {
        return htmlentities($this->membretiers_nom);
    }

    public function setMembretiers_nom($membretiers_nom) {
        $this->membretiers_nom = html_entity_decode($membretiers_nom);
        return $this;
    }

    public function getMembretiers_prenom() {
        return htmlentities($this->membretiers_prenom);
    }

    public function setMembretiers_prenom($membretiers_prenom) {
        $this->membretiers_prenom = html_entity_decode($membretiers_prenom);
        return $this;
    }

    public function getMembretiers_mobile() {
        return $this->membretiers_mobile;
    }

    public function setMembretiers_mobile($membretiers_mobile) {
        $this->membretiers_mobile = $membretiers_mobile;
        return $this;
    }

    public function getMembretiers_souscription() {
        return $this->membretiers_souscription;
    }

    public function setMembretiers_souscription($membretiers_souscription) {
        $this->membretiers_souscription = $membretiers_souscription;
        return $this;
    }

    public function getMembretiers_email() {
        return htmlentities($this->membretiers_email);
    }

    public function setMembretiers_email($membretiers_email) {
        $this->membretiers_email = html_entity_decode($membretiers_email);
        return $this;
    }

    public function getMembretiers_date() {
        return $this->membretiers_date;
    }

    public function setMembretiers_date($membretiers_date) {
        $this->membretiers_date = $membretiers_date;
        return $this;
    }

    public function getMembretiers_filiere() {
        return $this->membretiers_filiere;
    }

    public function setMembretiers_filiere($membretiers_filiere) {
        $this->membretiers_filiere = $membretiers_filiere;
        return $this;
    }

    function getCode_activite() {
        return $this->code_activite;
    }

    function setCode_activite($code_activite) {
        $this->code_activite = $code_activite;
        return $this;
    }

    function getId_metier() {
        return $this->id_metier;
    }

    function setId_metier($id_metier) {
        $this->id_metier = $id_metier;
        return $this;
    }

    function getId_competence() {
        return $this->id_competence;
    }

    function setId_competence($id_competence) {
        $this->id_competence = $id_competence;
        return $this;
    }
	
    public function getMembretiers_ville() {
        return $this->membretiers_ville;
    }

    public function setMembretiers_ville($membretiers_ville) {
        $this->membretiers_ville = $membretiers_ville;
        return $this;
    }

    public function getMembretiers_quartier() {
        return $this->membretiers_quartier;
    }

    public function setMembretiers_quartier($membretiers_quartier) {
        $this->membretiers_quartier = $membretiers_quartier;
        return $this;
    }



}

?>
