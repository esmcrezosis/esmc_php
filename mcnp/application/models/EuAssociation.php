<?php
 
class Application_Model_EuAssociation {

    //put your code here
    protected $association_id;
    protected $association_nom;
    protected $association_numero;
    protected $association_mobile;
    protected $association_date_agrement;
    protected $association_email;
    protected $association_recepisse;
    protected $association_adresse;
    protected $association_date;
    protected $id_filiere;
    protected $code_type_acteur;
    protected $code_statut;
    protected $publier;
    protected $code_agence;
    protected $guichet;
    protected $code_membre;

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

    public function getAssociation_id() {
        return $this->association_id;
    }

    public function setAssociation_id($association_id) {
        $this->association_id = $association_id;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getAssociation_nom() {
        return htmlentities($this->association_nom);
    }

    public function setAssociation_nom($association_nom) {
        $this->association_nom = html_entity_decode($association_nom);
        return $this;
    }

    public function getAssociation_numero() {
        return htmlentities($this->association_numero);
    }

    public function setAssociation_numero($association_numero) {
        $this->association_numero = html_entity_decode($association_numero);
        return $this;
    }

    public function getAssociation_mobile() {
        return $this->association_mobile;
    }

    public function setAssociation_mobile($association_mobile) {
        $this->association_mobile = $association_mobile;
        return $this;
    }

    public function getAssociation_date_agrement() {
        return $this->association_date_agrement;
    }

    public function setAssociation_date_agrement($association_date_agrement) {
        $this->association_date_agrement = $association_date_agrement;
        return $this;
    }

    public function getAssociation_email() {
        return htmlentities($this->association_email);
    }

    public function setAssociation_email($association_email) {
        $this->association_email = html_entity_decode($association_email);
        return $this;
    }

    public function getAssociation_recepisse() {
        return htmlentities($this->association_recepisse);
    }

    public function setAssociation_recepisse($association_recepisse) {
        $this->association_recepisse = html_entity_decode($association_recepisse);
        return $this;
    }

    public function getAssociation_adresse() {
        return htmlentities($this->association_adresse);
    }

    public function setAssociation_adresse($association_adresse) {
        $this->association_adresse = html_entity_decode($association_adresse);
        return $this;
    }

    public function getAssociation_date() {
        return $this->association_date;
    }

    public function setAssociation_date($association_date) {
        $this->association_date = $association_date;
        return $this;
    }

    function getId_filiere() {
        return $this->id_filiere;
    }

    function setId_filiere($id_filiere) {
        $this->id_filiere = $id_filiere;
        return $this;
    }

    function getCode_type_acteur() {
        return $this->code_type_acteur;
    }

    function setCode_type_acteur($code_type_acteur) {
        $this->code_type_acteur = $code_type_acteur;
        return $this;
    }

    function getCode_statut() {
        return $this->code_statut;
    }

    function setCode_statut($code_statut) {
        $this->code_statut = $code_statut;
        return $this;
    }

    function getCode_agence() {
        return $this->code_agence;
    }

    function setCode_agence($code_agence) {
        $this->code_agence = $code_agence;
        return $this;
    }

    function getGuichet() {
        return $this->guichet;
    }

    function setGuichet($guichet) {
        $this->guichet = $guichet;
        return $this;
    }

    function getCode_membre() {
        return $this->code_membre;
    }

    function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

}

?>
