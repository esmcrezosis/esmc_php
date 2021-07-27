<?php

class Application_Model_EuAchatCredit {

    protected $id_achat;
    protected $date_achat;
    protected $code_membre_acheteur;
    protected $code_membre_vendeur;
    protected $mont_achat;
    protected $id_tpagcp;
    protected $id_utilisateur;
    protected $credit_obt;
    protected $code_sms;

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

    public function getId_achat() {
        return $this->id_achat;
    }

    public function setId_achat($id_achat) {
        $this->id_achat = $id_achat;
        return $this;
    }

    public function getDate_achat() {
        return $this->date_achat;
    }

    public function setDate_achat($date_achat) {
        $this->date_achat = $date_achat;
        return $this;
    }

    public function getCode_membre_acheteur() {
        return $this->code_membre_acheteur;
    }

    public function setCode_membre_acheteur($code_membre_acheteur) {
        $this->code_membre_acheteur = $code_membre_acheteur;
        return $this;
    }

    public function getCode_membre_vendeur() {
        return $this->code_membre_vendeur;
    }

    public function setCode_membre_vendeur($code_membre_vendeur) {
        $this->code_membre_vendeur = $code_membre_vendeur;
        return $this;
    }

    public function getMont_achat() {
        return $this->mont_achat;
    }

    public function setMont_achat($mont_achat) {
        $this->mont_achat = $mont_achat;
        return $this;
    }

    public function getId_tpagcp() {
        return $this->id_tpagcp;
    }

    public function setId_tpagcp($id_tpagcp) {
        $this->id_tpagcp = $id_tpagcp;
        return $this;
    }

    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function getCredit_obt() {
        return $this->credit_obt;
        ;
    }

    public function setCredit_obt($credit_obt) {
        $this->credit_obt = $credit_obt;
        return $this;
    }

    public function getCode_sms() {
        return $this->code_sms;
    }

    public function setCode_sms($code_sms) {
        $this->code_sms = $code_sms;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_achat = (isset($data['id_achat'])) ? $data['id_achat'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
        $this->code_membre_acheteur = (isset($data['code_membre_acheteur'])) ? $data['code_membre_acheteur'] : NULL;
        $this->code_membre_vendeur = (isset($data['code_membre_vendeur'])) ? $data['code_membre_vendeur'] : NULL;
        $this->date_achat = (isset($data['date_achat'])) ? $data['date_achat'] : NULL;
        $this->mont_achat = (isset($data['mont_achat'])) ? $data['mont_achat'] : 0;
        $this->credit_obt = (isset($data['credit_obt'])) ? $data['credit_obt'] : '';
        $this->code_sms = (isset($data['code_sms'])) ? $data['code_sms'] : '';
        $this->id_tpagcp = (isset($data['id_tpagcp'])) ? $data['id_tpagcp'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_achat' => $this->id_achat,
            'id_utilisateur' => $this->id_utilisateur,
            'code_membre_acheteur' => $this->code_membre_acheteur,
            'code_membre_vendeur' => $this->code_membre_vendeur,
            'date_achat' => $this->date_achat,
            'mont_achat' => $this->mont_achat,
            'credit_obt' => $this->credit_obt,
            'code_sms' => $this->code_sms,
            'id_tpagcp' => $this->id_tpagcp
        );
        return $data;
    }

}

?>
