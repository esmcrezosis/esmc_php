<?php
 
class Application_Model_EuContratLivraisonIrrevocable {

    //put your code here
    protected $id_contrat;
    protected $code_membre;
    protected $numero_contrat;
    protected $type_validateur;
    protected $civilite;
    protected $nom;
    protected $demeure;
    protected $libelle_demeure;
    protected $quartier;
    protected $quartier_maison;
    protected $boite_postale;
    protected $telephone;
    protected $type_maison;
    protected $situation;
    protected $libelle_situation;
    protected $rue;
    protected $civilite_representant;
    protected $nom_representant;
    protected $carte_operateur;
    protected $numero_recipice;
    protected $siege;
    protected $matricule_rccm;
    protected $periode_garde;
    protected $chargement_produit;
    protected $date_contrat;
    protected $statut;
    
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

    public function getId_contrat() {
        return $this->id_contrat;
    }

    public function setId_contrat($id_contrat) {
        $this->id_contrat = $id_contrat;
        return $this;
    }

    public function getCode_membre() {
        return ($this->code_membre);
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = ($code_membre);
        return $this;
    }

    public function getNumero_contrat() {
        return $this->numero_contrat;
    }

    public function setNumero_contrat($numero_contrat) {
        $this->numero_contrat = $numero_contrat;
        return $this;
    }

    public function getType_validateur() {
        return $this->type_validateur;
    }

    public function setType_validateur($type_validateur) {
        $this->type_validateur = $type_validateur;
        return $this;
    } 
    

    public function getCivilite() {
        return $this->civilite;
    }

    public function setCivilite($civilite) {
        $this->civilite = $civilite;
        return $this;
    }
    
    public function getNom() {
        return $this->nom;
    }
    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }
     
    public function getDemeure() {
        return $this->demeure;
    }
    public function setDemeure($demeure) {
        $this->demeure =$demeure;
        return $this;
    }
    
    public function getLibelle_demeure() {
        return $this->libelle_demeure;
    }
    
    public function setLibelle_demeure($libelle_demeure) {
        $this->libelle_demeure =$libelle_demeure;
        return $this;
    }
    
    public function getQuartier() {
        return $this->quartier;
    }
    
    public function setQuartier($quartier) {
        $this->quartier =$quartier;
        return $this;
    }
    
    
    public function getQuartier_maison() {
        return $this->quartier_maison;
    }
    
    public function setQuartier_maison($quartier_maison) {
        $this->quartier =$quartier_maison;
        return $this;
    }
    
    public function getBoite_postale() {
        return $this->boite_postale;
    }
    
    public function setBoite_postale($boite_postale) {
        $this->boite_postale =$boite_postale;
        return $this;
    }
    
    public function getTelephone() {
        return $this->telephone;
    }
    public function setTelephone($telephone) {
        $this->telephone =$telephone;
        return $this;
    } 
    
    public function getType_maison() {
        return $this->type_maison;
    }
    public function setType_maison($type_maison) {
        $this->type_maison =$type_maison;
        return $this;
    } 
    
     public function getSituation() {
        return $this->situation;
    }

    public function setSituation($situation) {
        $this->situation = $situation;
        return $this;
    }

    public function getLibelle_situation() {
        return $this->libelle_situation;
    }

    public function setLibelle_situation($libelle_situation) {
        $this->libelle_situation = $libelle_situation;
        return $this;
    }

    public function getRue() {
        return $this->rue;
    }

    public function setRue($rue) {
        $this->rue = $rue;
        return $this;
    }

    public function getCivilite_representant() {
        return $this->civilite_representant;
    }

    public function setCivilite_representant($civilite_representant) {
        $this->civilite_representant = $civilite_representant;
        return $this;
    }

    public function getNom_representant() {
        return $this->nom_representant;
    }

    public function setNom_representant($nom_representant) {
        $this->nom_representant = $nom_representant;
        return $this;
    }

    public function getCarte_operateur() {
        return $this->carte_operateur;
    }

    public function setCarte_operateur($carte_operateur) {
        $this->carte_operateur = $carte_operateur;
        return $this;
    }

         public function getNumero_recipice() {
        return $this->numero_recipice;
    }

    public function setNumero_recipice($numero_recipice) {
        $this->numero_recipice = $numero_recipice;
        return $this;
    }

    public function getSiege() {
        return $this->siege;
    }

    public function setSiege($siege) {
        $this->siege = $siege;
        return $this;
    }
    
    
    public function getMatricule_rccm() {
        return $this->matricule_rccm;
    }

    public function setMatricule_rccm($matricule_rccm) {
        $this->matricule_rccm = $matricule_rccm;
        return $this;
    }


    public function getPeriode_garde() {
        return $this->periode_garde;
    }

    public function setPeriode_garde($periode_garde) {
        $this->periode_garde = $periode_garde;
        return $this;
    }


    public function getChargement_produit() {
        return $this->chargement_produit;
    }

    public function setChargement_produit($chargement_produit) {
        $this->chargement_produit = $chargement_produit;
        return $this;
    }

    public function getDate_contrat() {
        return $this->date_contrat;
    }

    public function setDate_contrat($date_contrat) {
        $this->date_contrat = $date_contrat;
        return $this;
    }


    public function getStatut() {
        return $this->statut;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

}

?>
