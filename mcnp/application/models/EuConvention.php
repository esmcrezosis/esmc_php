<?php
class Application_Model_EuConvention {

    protected $id_convention;
    protected $civilite;
    protected $nom;
    protected $demeure;
    protected $libelle_demeure;
    protected $quartier;
    protected $boite_postale;
    protected $telephone;
    protected $type_validateur;
	protected $situation;
	protected $libelle_situation;
	protected $rue;
	protected $civilite_representant;
	protected $nom_representant;
	protected $carte_operateur;
	protected $numero_recipice;
	protected $siege;
	protected $matricule_rccm;
	protected $statut_convention;
	protected $date_convention;
    

    public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid contrat property');
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

 
    function getId_convention() {
        return $this->id_convention;
    }

    function setId_convention($id_convention) {
        $this->id_convention = $id_convention;
        return $this;
    }

    function getCivilite() {
        return $this->civilite;
    }

    function setCivilite($civilite) {
        $this->civilite = $civilite;
        return $this;
    }
    
    function getNom() {
        return $this->nom;
    }
    function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }
     
    function getDemeure() {
        return $this->demeure;
    }
    function setDemeure($demeure) {
        $this->demeure =$demeure;
        return $this;
    }
    
    function getLibelle_demeure() {
        return $this->libelle_demeure;
    }
    
    function setLibelle_demeure($libelle_demeure) {
        $this->libelle_demeure =$libelle_demeure;
        return $this;
    }
    
    function getQuartier() {
        return $this->quartier;
    }
    
    function setQuartier($quartier) {
        $this->quartier =$quartier;
        return $this;
    }
    
    
    function getBoite_postale() {
        return $this->boite_postale;
    }
    
    function setBoite_postale($boite_postale) {
        $this->boite_postale =$boite_postale;
        return $this;
    }
    
    function getTelephone() {
        return $this->telephone;
    }
    function setTelephone($telephone) {
        $this->telephone =$telephone;
        return $this;
    } 
	
	function getType_validateur() {
        return $this->type_validateur;
    }

    function setType_validateur($type_validateur) {
        $this->type_validateur = $type_validateur;
        return $this;
    } 
	
	 function getSituation() {
        return $this->situation;
    }

    function setSituation($situation) {
        $this->situation = $situation;
        return $this;
    }

    function getLibelle_situation() {
        return $this->libelle_situation;
    }

    function setLibelle_situation($libelle_situation) {
        $this->libelle_situation = $libelle_situation;
        return $this;
    }

    function getRue() {
        return $this->rue;
    }

    function setRue($rue) {
        $this->rue = $rue;
        return $this;
    }

    function getCivilite_representant() {
        return $this->civilite_representant;
    }

    function setCivilite_representant($civilite_representant) {
        $this->civilite_representant = $civilite_representant;
        return $this;
    }

    function getNom_representant() {
        return $this->nom_representant;
    }

    function setNom_representant($nom_representant) {
        $this->nom_representant = $nom_representant;
        return $this;
    }

    	 function getCarte_operateur() {
        return $this->carte_operateur;
    }

    function setCarte_operateur($carte_operateur) {
        $this->carte_operateur = $carte_operateur;
        return $this;
    }

    	 function getNumero_recipice() {
        return $this->numero_recipice;
    }

    function setNumero_recipice($numero_recipice) {
        $this->numero_recipice = $numero_recipice;
        return $this;
    }

    function getSiege() {
        return $this->siege;
    }

    function setSiege($siege) {
        $this->siege = $siege;
        return $this;
    }
	
    
    function getMatricule_rccm() {
        return $this->matricule_rccm;
    }

    function setMatricule_rccm($matricule_rccm) {
        $this->matricule_rccm = $matricule_rccm;
        return $this;
    }

    
    function getStatut_convention() {
        return $this->siege;
    }

    function setStatut_convention($statut_convention) {
        $this->statut_convention = $statut_convention;
        return $this;
    }

    
    function getDate_convention() {
        return $this->siege;
    }

    function setDate_convention($date_convention) {
        $this->date_convention = $date_convention;
        return $this;
    }
	      
}
?>



