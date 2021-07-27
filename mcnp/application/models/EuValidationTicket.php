<?php

class Application_Model_EuValidationTicket {
   protected $id;
   protected $num_validation;
   protected $id_ticket;
   protected $id_responsable_traitement_ticket;
   protected $date_validation;

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


   public function getNum_validation() {
       return $this->num_validation;
   }

   public function setNum_validation($num_validation) {
       $this->num_validation = $num_validation;
       return $this;
   }

   public function getId_ticket() {
       return $this->id_ticket;
   }

   public function setId_ticket($id_ticket) {
       $this->id_ticket = $id_ticket;
       return $this;
   }

   public function getId_responsable_taitement_ticket() {
       return $this->id_responsable_traitement_ticket;
   }

   public function setId_responsable_taitement_ticket($id_responsable_traitement_ticket) {
       $this->id_responsable_traitement_ticket = $id_responsable_traitement_ticket;
       return $this;
   }

     public function getDate_validation() {
         return $this->date_validation;
     }

     public function setDate_validation($date_validation) {
         $this->date_validation = $date_validation;
         return $this;
     }
}
