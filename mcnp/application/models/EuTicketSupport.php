<?php

class Application_Model_EuTicketSupport {
  protected $id_ticket;
  protected $numero_demandeur;
  protected $telephone;
  protected $email;
  protected $lieu;
  protected $addresse_integrateur;
  protected $description;
  protected $created;

  public function __construct(array $options = NULL) {
      if (is_array($options)) {
          $this->setOptions($options);
      }
  }

  public function __set($name, $value) {
      $method = 'set' . $name;
      if (('mapper' == $name) || !method_exists($this, $method)) {
          throw new Exception('Invalid compte_gcp property');
      }
      $this->$method($value);
  }


      public function __get($name) {
          $method = 'get' . $name;
          if (('mapper' == $name) || !method_exists($this, $method)) {
              throw new Exception('Invalid compte_gcp property');
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

      function getId_ticket(){
        return $this->id_ticket;
      }

      function setId_ticket($id_ticket) {
        $this->id_ticket = $id_ticket;
        return $this;
      }

      function getNumero_demandeur(){
        return $this->numero_demandeur;
      }

      function setNumero_demandeur($numero_demandeur) {
        $this->numero_demandeur = $numero_demandeur;
        return $this;
      }


      function getTelephone(){
        return $this->telephone;
      }

      function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
      }

      function getEmail(){
        return $this->email;
      }

      function setEmail($email) {
        $this->email = $email;
        return $this;
      }

      function getLieu(){
        return $this->lieu;
      }

      function setLieu($lieu) {
        $this->lieu = $lieu;
        return $this;
      }

      function getAddresse_integrateur(){
        return $this->addresse_integrateur;
      }

      function setAddresse_integrateur($addresse_integrateur) {
        $this->addresse_integrateur = $addresse_integrateur;
        return $this;
      }

      function getDescription(){
        return $this->description;
      }

      function setDescription($description) {
        $this->description = $description;
        return $this;
      }

      function getCreated(){
        return $this->created;
      }

      function setCreated($created) {
        $this->created = $created;
        return $this;
      }


}
