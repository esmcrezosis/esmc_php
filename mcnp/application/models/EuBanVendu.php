<?php
 
class Application_Model_EuBanVendu {

    //put your code here
    protected $id_ban_vendu;
    protected $date_ban_vendu;
    protected $code_membre;
    protected $mont_vendu;
    protected $id_ban;
    protected $numero_recu;
    protected $id_user;

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

    public function getId_ban_vendu() {
        return $this->id_ban_vendu;
    }

    public function setId_ban_vendu($id_ban_vendu) {
        $this->id_ban_vendu = $id_ban_vendu;
        return $this;
    }

    public function getDate_ban_vendu() {
        return $this->date_ban_vendu;
    }

    public function setDate_ban_vendu($date_ban_vendu) {
        $this->date_ban_vendu = $date_ban_vendu;
        return $this;
    }

    public function getMont_vendu() {
        return $this->mont_vendu;
    }

    public function setMont_vendu($mont_vendu) {
        $this->mont_vendu = $mont_vendu;
        return $this;
    }

    public function getId_user() {
        return $this->id_user;
    }

    public function setId_user($id_user) {
        $this->id_user = $id_user;
        return $this;
    }

    public function getNumero_recu() {
        return ($this->numero_recu);
    }

    public function setNumero_recu($numero_recu) {
        $this->numero_recu = ($numero_recu);
        return $this;
    }

    public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }

    public function getId_ban() {
        return $this->id_ban;
    }

    public function setId_ban($id_ban) {
        $this->id_ban = $id_ban;
        return $this;
    }


}

?>
