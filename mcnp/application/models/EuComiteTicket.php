<?php

class Application_Model_EuComiteTicket {
   protected $id_ticket;

   protected $responsable_comite_ticket;

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

   public function getId_comite_ticket() {
       return $this->id_comite_ticket;
   }

   public function setId_comite_ticket($id_comite_ticket) {
       $this->id_comite_ticket = $id_comite_ticket;
       return $this;
   }


      public function getResponsable_comite_ticket() {
          return $this->responsable_comite_ticket;
      }

      public function setResponsable_comite_ticket($responsable_comite_ticket) {
          $this->responsable_comite_ticket = $responsable_comite_ticket;
          return $this;
      }
}
