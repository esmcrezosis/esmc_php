<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of EuCnpEntree
 *
 * @author user
 */
 
class Application_Model_EuMf {


      //put your code here
      protected $id_mf;
      protected $date_mf;
	  protected $mont_mf;
	  protected $gain_mf;
	  protected $date_deb_mf;
	  protected $date_fin_mf;
	  protected $code_membre;
	  protected $nb_gain;
	  protected $domicilier;
	  protected $code_compte;
	  protected $id_utilisateur;
	  protected $code_type_mf;
	  
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
	  
	
    public function getId_mf() {
        return $this->id_mf;
    }

    public function setId_mf($id_mf) {
        $this->id_mf = $id_mf;
        return $this;
    }

    public function getDate_mf() {
        return $this->date_mf;
    }

    public function setDate_mf($date_mf) {
        $this->date_mf = $date_mf;
        return $this;
    }
	
	public function getMont_mf() {
        return $this->mont_mf;
    }

    public function setMont_mf($mont_mf) {
        $this->mont_mf = $mont_mf;
        return $this;
    }
	
	public function getGain_mf() {
        return $this->gain_mf;
    }

    public function setGain_mf($gain_mf) {
        $this->gain_mf = $gain_mf;
        return $this;
    }
	
	public function getDate_deb_mf() {
        return $this->date_deb_mf;
    }

    public function setDate_deb_mf($date_deb_mf) {
        $this->date_deb_mf = $date_deb_mf;
        return $this;
    }
	
	public function getDate_fin_mf() {
        return $this->date_fin_mf;
    }

    public function setDate_fin_mf($date_fin_mf) {
        $this->date_fin_mf = $date_fin_mf;
        return $this;
    }
	  
	public function getCode_membre() {
        return $this->code_membre;
    }

    public function setCode_membre($code_membre) {
        $this->code_membre = $code_membre;
        return $this;
    }
	
	public function getNb_gain() {
        return $this->nb_gain;
    }

    public function setNb_gain($nb_gain) {
        $this->nb_gain = $nb_gain;
        return $this;
    }
	 
	public function getDomicilier() {
        return $this->domicilier;
    }

    public function setDomicilier($domicilier) {
        $this->domicilier = $domicilier;
        return $this;
    } 
	 
	public function getCode_compte() {
        return $this->code_compte;
    }

    public function setCode_compte($code_compte) {
        $this->code_compte = $code_compte;
        return $this;
    }
     
	public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    } 

    public function getCode_type_mf() {
        return $this->code_type_mf;
    }

    public function setCode_type_mf($code_type_mf) {
        $this->code_type_mf = $code_type_mf;
        return $this;
    }

	

}