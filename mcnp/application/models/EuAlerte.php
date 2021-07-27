<?php

/**
 * Description of EuOperation
 *
 * @author user
 */
class Application_Model_EuAlerte {

    //put your code here
    protected $id_alerte;
    protected $code_membre_client;
    protected $code_membre_assureur;
    protected $code_membre_acteur;
    protected $lib_alerte;
    protected $motif_alerte;
    protected $code_smcipn;
    protected $date_alerte;
    protected $heure_alerte;
    protected $id_utilisateur;

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

    public function getId_alerte() {
        return $this->id_alerte;
    }

    public function setId_alerte($id_alerte) {
        $this->id_alerte = $id_alerte;
        return $this;
    }

    public function getCode_membre_client() {
        return $this->code_membre_client;
    }

    public function setCode_membre_client($code_membre_client) {
        $this->code_membre_client = $code_membre_client;
        return $this;
    }

    public function getCode_membre_assureur() {
        return $this->code_membre_assureur;
    }

    public function setCode_membre_assureur($code_membre_assureur) {
        $this->code_membre_assureur = $code_membre_assureur;
        return $this;
    }

    public function getCode_membre_acteur() {
        return $this->code_membre_acteur;
    }

    public function setCode_membre_acteur($code_membre_acteur) {
        $this->code_membre_acteur = $code_membre_acteur;
        return $this;
    }

    public function getLib_alerte() {
        return $this->lib_alerte;
    }

    public function setLib_alerte($lib_alerte) {
        $this->lib_alerte = $lib_alerte;
        return $this;
    }

    public function getMotif_alerte() {
        return $this->motif_alerte;
    }

    public function setMotif_alerte($motif_alerte) {
        $this->motif_alerte = $motif_alerte;
        return $this;
    }

    public function getCode_smcipn() {
        return $this->code_smcipn;
    }

    public function setCode_smcipn($code_smcipn) {
        $this->code_smcipn = $code_smcipn;
        return $this;
    }

    public function getDate_alerte() {
        return $this->date_alerte;
    }

    public function setDate_alerte($date_alerte) {
        $this->date_alerte = $date_alerte;
        return $this;
    }

    public function getHeure_alerte() {
        return $this->heure_alerte;
    }

    public function setHeure_alerte($heure_alerte) {
        $this->heure_alerte = $heure_alerte;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

}

?>
