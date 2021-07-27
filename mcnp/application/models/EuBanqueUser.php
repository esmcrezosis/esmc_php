<?php
class Application_Model_EuBanqueUser {
	protected $id_banque_user;
	protected $code_banque;
	protected $nom_banque_user;
	protected $prenom_banque_user;
	protected $login_banque_user;
	protected $pwd_banque_user;
	protected $activer;
	protected $pwd_changed;
	protected $date_created;
	protected $id_utilisateur;
	protected $role;
	protected $code_membre;
	
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
	public function getIdBanqueUser() {
		return $this->id_banque_user;
	}
	public function setIdBanqueUser($id_banque_user) {
		$this->id_banque_user = $id_banque_user;
		return $this;
	}
	public function getCodeBanque() {
		return $this->code_banque;
	}
	public function setCodeBanque($code_banque) {
		$this->code_banque = $code_banque;
		return $this;
	}
	public function getNomBanqueUser() {
		return $this->nom_banque_user;
	}
	public function setNomBanqueUser($nom_banque_user) {
		$this->nom_banque_user = $nom_banque_user;
		return $this;
	}
	public function getPrenomBanqueUser() {
		return $this->prenom_banque_user;
	}
	public function setPrenomBanqueUser($prenom_banque_user) {
		$this->prenom_banque_user = $prenom_banque_user;
		return $this;
	}
	public function getLoginBanqueUser() {
		return $this->login_banque_user;
	}
	public function setLoginBanqueUser($login_banque_user) {
		$this->login_banque_user = $login_banque_user;
		return $this;
	}
	public function getPwdBanqueUser() {
		return $this->pwd_banque_user;
	}
	public function setPwdBanqueUser($pwd_banque_user) {
		$this->pwd_banque_user = $pwd_banque_user;
		return $this;
	}
	public function getActiver() {
		return $this->activer;
	}
	public function setActiver($activer) {
		$this->activer = $activer;
		return $this;
	}
	public function getPwdChanged() {
		return $this->pwd_changed;
	}
	public function setPwdChanged($pwd_changed) {
		$this->pwd_changed = $pwd_changed;
		return $this;
	}
	public function getDateCreated() {
		return $this->date_created;
	}
	public function setDateCreated($date_created) {
		$this->date_created = $date_created;
		return $this;
	}
	public function getIdUtilisateur() {
		return $this->id_utilisateur;
	}
	public function setIdUtilisateur($id_utilisateur) {
		$this->id_utilisateur = $id_utilisateur;
		return $this;
	}
	
	public function getRole(){
		return $this->role;
	}
	
	public function setRole($role){
		$this->role = $role;
		return $this;
	}
	public function getCode_membre() {
		return $this->code_membre;
	}
	public function setCode_membre($code_membre) {
		$this->code_membre = $code_membre;
		return $this;
	}
}