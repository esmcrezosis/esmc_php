<?php

/**
 * Description of EuSection
 *
 * @author user
 */
class Application_Model_EuNn {

    //put your code here
    protected $id_nn;
    protected $date_emission;
    protected $type_emission;
    protected $montant_emis;
    protected $montant_remb;
    protected $solde_nn;
    protected $emetteur_nn;
    protected $code_type_nn;
    protected $id_utilisateur;

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

    public function getId_nn() {
        return $this->id_nn;
    }

    public function setId_nn($id_nn) {
        $this->id_nn = $id_nn;
        return $this;
    }

    public function getDate_emission() {
        return $this->date_emission;
    }

    public function setDate_emission($date_emission) {
        $this->date_emission = $date_emission;
        return $this;
    }

    public function getType_emission() {
        return $this->type_emission;
    }

    public function setType_emission($type_emission) {
        $this->type_emission = $type_emission;
        return $this;
    }

    public function getMontant_emis() {
        return $this->montant_emis;
    }

    public function setMontant_emis($montant_emis) {
        $this->montant_emis = $montant_emis;
        return $this;
    }

    public function getMontant_remb() {
        return $this->montant_remb;
    }

    public function setMontant_remb($montant_remb) {
        $this->montant_remb = $montant_remb;
        return $this;
    }

    public function getSolde_nn() {
        return $this->solde_nn;
    }

    public function setSolde_nn($solde_nn) {
        $this->solde_nn = $solde_nn;
        return $this;
    }

    public function getEmetteur_nn() {
        return $this->emetteur_nn;
    }

    public function setEmetteur_nn($emetteur_nn) {
        $this->emetteur_nn = $emetteur_nn;
        return $this;
    }
    
    public function getCode_type_nn() {
        return $this->code_type_nn;
    }

    public function setCode_type_nn($code_type_nn) {
        $this->code_type_nn = $code_type_nn;
        return $this;
    }
    
    public function getId_utilisateur() {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }

    public function exchangeArray($data) {
        $this->id_nn = (isset($data['id_nn'])) ? $data['id_nn'] : NULL;
        $this->date_emission = (isset($data['date_emission'])) ? $data['date_emission'] : NULL;
        $this->type_emission = (isset($data['type_emission'])) ? $data['type_emission'] : NULL;
        $this->montant_emis = (isset($data['montant_emis'])) ? $data['montant_emis'] : NULL;
        $this->montant_remb = (isset($data['montant_remb'])) ? $data['montant_remb'] : NULL;
        $this->solde_nn = (isset($data['solde_nn'])) ? $data['solde_nn'] : NULL;
        $this->emetteur_nn = (isset($data['emetteur_nn'])) ? $data['emetteur_nn'] : NULL;
        $this->code_type_nn = (isset($data['code_type_nn'])) ? $data['code_type_nn'] : NULL;
        $this->id_utilisateur = (isset($data['id_utilisateur'])) ? $data['id_utilisateur'] : NULL;
    }

    public function toArray() {
        $data = array(
            'id_nn' => $this->id_nn,
            'date_emission' => $this->date_emission,
            'type_emission' => $this->type_emission,
            'montant_emis' => $this->montant_emis,
            'montant_remb' => $this->montant_remb,
            'solde_nn' => $this->solde_nn,
            'emetteur_nn' => $this->emetteur_nn,
            'code_type_nn' => $this->code_type_nn,
            'id_utilisateur' => $this->id_utilisateur
        );
        return $data;
    }

    public function findConuter() {
        $tabela = new Application_Model_DbTable_EuNn();
        $select = $tabela->select();
        $select->from('eu_nn', array('MAX(id_nn) as count'));
        $result = $tabela->fetchAll($select);
        $row = $result->current();
        return $row['count'];
    }

}

?>
