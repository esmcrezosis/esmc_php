<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_EuRenseignementIdentite {
  protected $id;
  protected $nom;
  protected $prenoms;
  protected $sexe;
  protected $ville;
  protected $nationalite;
  protected $email;
  protected $pere;
  protected $cellulaire;
  protected $telephone;
  protected $matrimonial;
  protected $profession;
  protected $date_naissance;
  protected $lieu_naissance;
  protected $religion;
  protected $region;
  protected $quartier;
  protected $nbre_enfant;
  protected $cantons;
  protected $monetaire;
  protected $pays;
  protected $prefecture;
  protected $perdu;
  protected $bp;
  protected $addresse;
  protected $created;

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
  function getId() {
      return $this->id;
  }

  function setId($id) {
      $this->id = $id;
      return $this;
  }
  function getNom() {
      return $this->nom;
  }

  function setNom($nom) {
      $this->nom = $nom;
      return $this;
  }
  function getPrenoms() {
      return $this->prenoms;
  }

  function setPrenoms($prenoms) {
      $this->prenoms = $prenoms;
      return $this;
  }

  function getSexe() {
      return $this->sexe;
  }

  function setSexe($sexe) {
      $this->sexe = $sexe;
      return $this;
  }

  function getVille() {
      return $this->ville;
  }

  function setVille($ville) {
      $this->ville = $ville;
      return $this;
  }

  function getNationalite() {
      return $this->nationalite;
  }

  function setNationalite($nationalite) {
      $this->nationalite = $nationalite;
      return $this;
  }

  function getEmail() {
      return $this->email;
  }

  function setEmail($email) {
      $this->email = $email;
      return $this;
  }
  function getPere() {
      return $this->pere;
  }

  function setPere($pere) {
      $this->pere = $pere;
      return $this;
  }

  function getCellulaire() {
      return $this->ville;
  }

  function setCellulaire($cellulaire) {
      $this->cellulaire = $cellulaire;
      return $this;
  }
  function getTelephone() {
      return $this->telephone;
  }

  function setTelephone($telephone) {
      $this->telephone = $telephone;
      return $this;
  }

  function getMatrimonial() {
      return $this->matrimonial;
  }

  function setMatrimonial($matrimonial) {
      $this->matrimonial = $matrimonial;
      return $this;
  }

  function getProfession() {
      return $this->profession;
  }

  function setProfession($profession) {
      $this->profession = $profession;
      return $this;
  }

  function getDate_naissance() {
      return $this->date_naissance;
  }

  function setDate_naissance($date_naissance) {
      $this->date_naissance = $date_naissance;
      return $this;
  }

  function getReligion() {
      return $this->religion;
  }

  function setReligion($religion) {
      $this->religion = $religion;
      return $this;
  }
  function getLieu_naissance() {
      return $this->lieu_naissance;
  }

  function setLieu_naissance($lieu_naissance) {
      $this->lieu_naissance = $lieu_naissance;
      return $this;
  }
  function getQuartier() {
      return $this->quartier;
  }

  function setQuartier($quartier) {
      $this->quartier = $quartier;
      return $this;
  }
  function getNbre_enfant() {
      return $this->nbre_enfant;
  }

  function setNbre_enfant($nbre_enfant) {
      $this->nbre_enfant = $nbre_enfant;
      return $this;
  }
  function getCantons() {
      return $this->cantons;
  }

  function setCantons($cantons) {
      $this->cantons = $cantons;
      return $this;
  }
  function getAddresse() {
      return $this->addresse;
  }

  function setAddresse($addresse) {
      $this->addresse = $addresse;
      return $this;
  }
  function getBp() {
      return $this->bp;
  }

  function setBp($bp) {
      $this->bp = $bp;
      return $this;
  }
  function getMonetaire() {
      return $this->monetaire;
  }

  function setMonetaire($monetaire) {
      $this->monetaire = $monetaire;
      return $this;
  }
  function getPays() {
      return $this->pays;
  }

  function setPays($pays) {
      $this->pays = $pays;
      return $this;
  }
  function getRegion() {
      return $this->region;
  }

  function setRegion($region) {
      $this->region = $region;
      return $this;
  }
  function getPrefecture() {
      return $this->prefecture;
  }

  function setPrefecture($prefecture) {
      $this->prefecture = $prefecture;
      return $this;
  }

  function getPerdu() {
      return $this->perdu;
  }

  function setPerdu($perdu) {
      $this->perdu = $perdu;
      return $this;
  }

    function getCreated() {
        return $this->created;
    }

    function setCreated($created) {
        $this->created = $created;
        return $this;
    }
}
?>
