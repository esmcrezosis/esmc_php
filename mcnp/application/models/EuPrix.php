<?php
class Application_Model_EuPrix
{
    protected  $id_value;
    protected  $prix_unitaire;
    protected  $code_objet;
    protected  $duree_vie;
    protected  $boutique;
    protected  $rayon;
    protected  $num_gamme;
    protected  $creer_par;
    protected  $code_demand;
    protected  $caract_objet;
    protected  $membre_rayon;
   
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
    function getId_value(){
        return $this->id_value;
    }
    function setId_value($id_value){
        $this->id_value = $id_value;
        return $this;
    }    
    function getPrix_unitaire(){
        return $this->prix_unitaire;
    }
    function setPrix_unitaire($prix_unitaire){
        $this->prix_unitaire = $prix_unitaire;
        return $this;
    }
    function getCode_objet(){
        return $this->code_objet;
    }
    function setCode_objet($code_objet){
        $this->code_objet = $code_objet;
        return $this;
    }
    
    function getBoutique(){
        return $this->boutique;
    }
    
    function setBoutique($boutique){
        $this->boutique = $boutique;
        return $this;
    }
    
    function getRayon(){
        return $this->rayon;
    }
    function setRayon($rayon){
        $this->rayon = $rayon;
        return $this;
    }
    function getNum_gamme(){
        return $this->num_gamme;
    }
    function setNum_gamme($num_gamme){
        $this->num_gamme = $num_gamme;
        return $this;
    }
    function getCreer_par(){
        return $this->creer_par;
    }
    function setCreer_par($creer_par){
        $this->creer_par = $creer_par;
        return $this;
    }
    
    function getCode_demand(){
        return $this->code_demand;
    }
    function setCode_demand($code_demand){
        $this->code_demand = $code_demand;
        return $this;
    }
    
    function getCaract_objet(){
        return $this->caract_objet;
    }
    function setCaract_objet($caract_objet){
        $this->caract_objet = $caract_objet;
        return $this;
    } 
    
    function getDuree_vie(){
        return $this->duree_vie;
    }
    function setDuree_vie($duree_vie){
        $this->duree_vie = $duree_vie;
        return $this;
    }
    
    function getMembre_rayon(){
        return $this->membre_rayon;
    }
    function setMembre_rayon($membre_rayon){
        $this->membre_rayon = $membre_rayon;
        return $this;
    } 
}
?>
