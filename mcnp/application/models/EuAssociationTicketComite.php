<?php

class Application_Model_EuAssociationTicketComite {
   protected $id;
   protected $id_ticket;
   protected $comite_ticket;
   protected $observation;
   protected $date_observation;

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

   public function getId() {
       return $this->id;
   }

   public function setId($id) {
       $this->id = $id;
       return $this;
   }


   public function getComite_ticket() {
       return $this->comite_ticket;
   }

   public function setComite_ticket($comite_ticket) {
       $this->comite_ticket = $comite_ticket;
       return $this;
   }

   public function getId_ticket() {
       return $this->id_ticket;
   }

   public function setId_ticket($id_ticket) {
       $this->id_ticket = $id_ticket;
       return $this;
   }

   public function getObservation() {
       return $this->observation;
   }

   public function setObservation($observation) {
       $this->observation = $observation;
       return $this;
   }

     public function getDate_observation() {
         return $this->date_observation;
     }

     public function setDate_observation($date_observation) {
         $this->date_observation = $date_observation;
         return $this;
     }
}
