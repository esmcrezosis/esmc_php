
<?php 
    class Application_Model_EuSmsManuel {

       protected $id_sms_manuel;
       protected $id_utilisateur;
       protected $num_portable;
       protected $contenu_message;
       protected $date_envoi;
       protected $dlr_url;
       protected $dlr_mask;

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

    function getId_sms_manuel() {
        return $this->id_sms_manuel;
    }

    function setId_sms_manuel($id_sms_manuel) {
        $this->id_sms_manuel = $id_sms_manuel;
        return $this;
    }

    function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    function getNum_portable() {
        return $this->num_portable;
    }

    function setNum_portable($num_portable) {
        $this->num_portable = $num_portable;
        return $this;
    }

    function getContenu_message() {
        return $this->contenu_message;
    }

    function setContenu_message($contenu_message) {
        $this->contenu_message = $contenu_message;
        return $this;
    }

    function getDate_envoi() {
        return $this->date_envoi;
    }

    function setDate_envoi($date_envoi) {
        $this->date_envoi = $date_envoi;
        return $this;
    }

    function getDlr_url() {
        return $this->dlr_url;
    }

    function setDlr_url($dlr_url) {
        $this->dlr_url = $dlr_url;
        return $this;
    }

    function getDlr_mask() {
        return $this->dlr_mask;
    }

    function setDlr_mask($dlr_mask) {
        $this->dlr_mask = $dlr_mask;
        return $this;
    }
}