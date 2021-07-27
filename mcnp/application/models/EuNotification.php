<?php

class Application_Model_EuNotification {
    
    protected $id_notification;
    protected $to;
    protected $titre;
    protected $message;
    protected $message_id;
    protected $error;
    protected $statut;
	protected $date_notification;

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
	

    function getId_notification() {
      return $this->id_notification;
    }

    function setId_notification($id_notification) {
      $this->id_notification = $id_notification;
      return $this;
    }

    function getTo() {
        return $this->to;
    }

    function setTo($to) {
        $this->to = $to;
        return $this;
    }

    function getTitre() {
        return $this->titre;
    }

    function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

	function getMessage() {
        return $this->message;
    }

    function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    function getMessage_id() {
      return $this->message_id;
    }

    function setMessage_id($message_id) {
      $this->message_id = $message_id;
      return $this;
    }
	
	
    function getError() {
      return $this->error;
    }

    function setError($error) {
      $this->error = $error;
      return $this;
    }
	
    function getStatut() {
      return $this->statut;
    }

    function setStatut($statut) {
      $this->statut = $statut;
      return $this;
    }
		
	function getDate_notification() {
      return $this->date_notification;
    }

    function setDate_notification($date_notification) {
      $this->date_notification = $date_notification;
      return $this;
    }
	
	
	
    
}

