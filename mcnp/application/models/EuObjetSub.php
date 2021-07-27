<?php
class Application_Model_EuObjetSub
{
    protected $code_objet;
    protected $code_demand;
    protected $qte_stock;
    protected $pu_sub;
    protected $Num_pro;
    
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
    function getCode_objet(){
        return $this->code_objet;
    }
    function setCode_objet($code_objet){
        $this->code_objet = $code_objet;
        return $this;
    }    
    function getCode_demand(){
        return $this->code_demand;
    }
    function setCode_demand($code_demand){
        $this->code_demand = $code_demand;
        return $this;
    }
    function getQte_stock(){
        return $this->qte_stock;
    }
    function setQte_stock($qte_stock){
        $this->qte_stock = $qte_stock;
        return $this;
    } 
    function getPu_sub(){
        return $this->pu_sub;
    }
    function setPu_sub($pu_sub){
        $this->pu_sub = $pu_sub;
        return $this;
    }
     function getNum_pro(){
        return $this->num_pro;
    }
    function setNum_pro($num_pro){
        $this->num_pro = $num_pro;
        return $this;
    }
}
