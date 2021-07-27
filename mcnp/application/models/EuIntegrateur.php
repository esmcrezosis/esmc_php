<?php
 
class Application_Model_EuIntegrateur {

    //put your code here
    protected $integrateur_id;
    protected $integrateur_souscription;
    protected $integrateur_critere1;
    protected $integrateur_critere2;
    protected $integrateur_critere3;
    protected $integrateur_type;
    protected $integrateur_date;
    protected $publier;
    protected $integrateur_poste;
    protected $integrateur_document;
    protected $integrateur_diplome;
    protected $integrateur_membreasso;
    protected $integrateur_education;
    protected $integrateur_affiliation;
    protected $integrateur_formation;
    protected $integrateur_langue;
    protected $integrateur_experience;
    protected $integrateur_attestation;
	protected $code_membre;
	protected $integrateur_adresse;
	protected $integrateur_canton;
	protected $integrateur_ville;

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

    public function getIntegrateur_id() {
        return $this->integrateur_id;
    }

    public function setIntegrateur_id($integrateur_id) {
        $this->integrateur_id = $integrateur_id;
        return $this;
    }

    public function getIntegrateur_critere2() {
        return $this->integrateur_critere2;
    }

    public function setIntegrateur_critere2($integrateur_critere2) {
        $this->integrateur_critere2 = $integrateur_critere2;
        return $this;
    }

    public function getIntegrateur_critere1() {
        return $this->integrateur_critere1;
    }

    public function setIntegrateur_critere1($integrateur_critere1) {
        $this->integrateur_critere1 = $integrateur_critere1;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getIntegrateur_souscription() {
        return ($this->integrateur_souscription);
    }

    public function setIntegrateur_souscription($integrateur_souscription) {
        $this->integrateur_souscription = ($integrateur_souscription);
        return $this;
    }

    public function getIntegrateur_critere3() {
        return $this->integrateur_critere3;
    }

    public function setIntegrateur_critere3($integrateur_critere3) {
        $this->integrateur_critere3 = $integrateur_critere3;
        return $this;
    }

    public function getIntegrateur_type() {
        return $this->integrateur_type;
    }

    public function setIntegrateur_type($integrateur_type) {
        $this->integrateur_type = $integrateur_type;
        return $this;
    }

    public function getIntegrateur_date() {
        return $this->integrateur_date;
    }

    public function setIntegrateur_date($integrateur_date) {
        $this->integrateur_date = $integrateur_date;
        return $this;
    }

    public function getIntegrateur_poste() {
        return ($this->integrateur_poste);
    }

    public function setIntegrateur_poste($integrateur_poste) {
        $this->integrateur_poste = ($integrateur_poste);
        return $this;
    }

    public function getIntegrateur_document() {
        return $this->integrateur_document;
    }

    public function setIntegrateur_document($integrateur_document) {
        $this->integrateur_document = $integrateur_document;
        return $this;
    }

    public function getIntegrateur_diplome() {
        return $this->integrateur_diplome;
    }

    public function setIntegrateur_diplome($integrateur_diplome) {
        $this->integrateur_diplome = $integrateur_diplome;
        return $this;
    }

    public function getIntegrateur_membreasso() {
        return ($this->integrateur_membreasso);
    }

    public function setIntegrateur_membreasso($integrateur_membreasso) {
        $this->integrateur_membreasso = ($integrateur_membreasso);
        return $this;
    }

    public function getIntegrateur_education() {
        return ($this->integrateur_education);
    }

    public function setIntegrateur_education($integrateur_education) {
        $this->integrateur_education = ($integrateur_education);
        return $this;
    }

    public function getIntegrateur_affiliation() {
        return ($this->integrateur_affiliation);
    }

    public function setIntegrateur_affiliation($integrateur_affiliation) {
        $this->integrateur_affiliation = ($integrateur_affiliation);
        return $this;
    }

    public function getIntegrateur_formation() {
        return ($this->integrateur_formation);
    }

    public function setIntegrateur_formation($integrateur_formation) {
        $this->integrateur_formation = ($integrateur_formation);
        return $this;
    }

    public function getIntegrateur_langue() {
        return ($this->integrateur_langue);
    }

    public function setIntegrateur_langue($integrateur_langue) {
        $this->integrateur_langue = ($integrateur_langue);
        return $this;
    }

    public function getIntegrateur_experience() {
        return ($this->integrateur_experience);
    }

    public function setIntegrateur_experience($integrateur_experience) {
        $this->integrateur_experience = ($integrateur_experience);
        return $this;
    }

    public function getIntegrateur_attestation() {
        return ($this->integrateur_attestation);
    }

    public function setIntegrateur_attestation($integrateur_attestation) {
        $this->integrateur_attestation = ($integrateur_attestation);
        return $this;
    }
	
	public function getCode_membre() {
        return ($this->code_membre);
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = ($code_membre);
        return $this;
    }
	
	public function getIntegrateurAdresse() {
        return ($this->integrateur_adresse);
    }

    public function setIntegrateurAdresse($integrateur_adresse) {
        $this->integrateur_adresse = ($integrateur_adresse);
        return $this;
    }
	
	public function getIntegrateurCanton() {
        return ($this->integrateur_canton);
    }

    public function setIntegrateurCanton($integrateur_canton) {
        $this->integrateur_canton = ($integrateur_canton);
        return $this;
    }
	
	public function getIntegrateurVille() {
        return ($this->integrateur_ville);
    }

    public function setIntegrateurVille($integrateur_ville) {
        $this->integrateur_ville = ($integrateur_ville);
        return $this;
    }
	
	
	
	
	


}

?>
