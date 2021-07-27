<?php

class Application_Model_EuAppartement {

      protected $id_appartement;
      //protected $code_appartement;
      protected $id_maison;
      protected $type_appartement;
      protected $wc_douche_interne;
      protected $terasse;
      protected $cuisine;
      protected $garage;
      protected $prix_location;
      protected $statut;
      protected $nb_piece;
      protected $desc_appart;
      protected $date_enregistrement;
      protected $heure_enregistrement;
      protected $id_utilisateur;
      
     
       public function __construct(array $options = NULL) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid produit property');
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
    
    
    function getId_appartement() {
        return $this->id_appartement;
    }

    function setId_appartement($id_appartement) {
        $this->id_appartement = $id_appartement;
        return $this;
    }
    
    
    
    function getId_maison() {
        return $this->id_maison;
    }

    function setId_maison($id_maison) {
        $this->id_maison = $id_maison;
        return $this;
    }
    
    function getType_appartement() {
        return $this->type_appartement;
    }

    function setType_appartement($type_appartement) {
        $this->type_appartement = $type_appartement;
        return $this;
    }
    
    function getWc_douche_interne() {
        return $this->wc_douche_interne;
    }

    function setWc_douche_interne($wc_douche_interne) {
        $this->wc_douche_interne = $wc_douche_interne;
        return $this;
    }
   
    function getTerasse() {
        return $this->terasse;
    }

    function setTerasse($terasse) {
        $this->terasse = $terasse;
        return $this;
    }
    
    function getCuisine() {
        return $this->cuisine;
    }

    function setCuisine($cuisine) {
        $this->cuisine = $cuisine;
        return $this;
    }
    
    function getGarage() {
        return $this->garage;
    }

    function setGarage($garage) {
        $this->garage = $garage;
        return $this;
    }
    
    function getPrix_location() {
        return $this->prix_location;
    }

    function setPrix_location($prix_location) {
        $this->prix_location = $prix_location;
        return $this;
    }
    
    function getStatut() {
        return $this->statut;
    }

    function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }
    
    function getNb_piece() {
        return $this->nb_piece;
    }

    function setNb_piece($nb_piece) {
        $this->nb_piece = $nb_piece;
        return $this;
    }
    
    function getDesc_appart() {
        return $this->desc_appart;
    }

    function setDesc_appart($desc_appart) {
        $this->desc_appart = $desc_appart;
        return $this;
    }
    
    function getDate_enregistrement() {
        return $this->date_enregistrement;
    }

    function setDate_enregistrement($date_enregistrement) {
        $this->date_enregistrement = $date_enregistrement;
        return $this;
    }
    
    function getHeure_enregistrement() {
        return $this->heure_enregistrement;
    }

    function setHeure_enregistrement($heure_enregistrement) {
        $this->heure_enregistrement = $heure_enregistrement;
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
