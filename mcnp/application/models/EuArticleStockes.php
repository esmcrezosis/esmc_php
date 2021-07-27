<?php

class Application_Model_EuArticleStockes {

    //put your code here
    protected $id_article_stockes;
    protected $code_barre;
    protected $reference;
    protected $designation;
    protected $prix;
    protected $date_enregistrement;
    protected $publier;
    protected $code_membre_morale;
    protected $vendu;
    protected $categorie;
    protected $type;
    protected $imageArticle;
    protected $remise;
    protected $article_stockes_categorie;
    protected $quantite;
	protected $qte_stock;
	protected $qte_vendu;
	protected $qte_solde;

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

    public function getId_article_stockes() {
        return $this->id_article_stockes;
    }

    public function setId_article_stockes($id_article_stockes) {
        $this->id_article_stockes = $id_article_stockes;
        return $this;
    }
    
    public function getCode_barre() {
        return $this->code_barre;
    }

    public function setCode_barre($code_barre) {
        $this->code_barre = $code_barre;
        return $this;
    }

    public function getDesignation() {
        return $this->designation;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
        return $this;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
        return $this;
    }

    public function getDate_enregistrement() {
        return $this->date_enregistrement;
    }

    public function setDate_enregistrement($date_enregistrement) {
        $this->date_enregistrement = $date_enregistrement;
        return $this;
    }

    public function getCode_membre_morale() {
        return $this->code_membre_morale;
    }

    public function setCode_membre_morale($code_membre_morale) {
        $this->code_membre_morale = $code_membre_morale;
        return $this;
    }

    public function getPublier() {
        return $this->publier;
    }

    public function setPublier($publier) {
        $this->publier = $publier;
        return $this;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;
        return $this;
    }

    public function getVendu() {
        return $this->vendu;
    }

    public function setVendu($vendu) {
        $this->vendu = $vendu;
        return $this;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getImageArticle() {
        return $this->imageArticle;
    }

    public function setImageArticle($imageArticle) {
        $this->imageArticle = $imageArticle;
        return $this;
    }

    public function getRemise() {
        return $this->remise;
    }

    public function setRemise($remise) {
        $this->remise = $remise;
        return $this;
    }

    public function getArticle_stockes_categorie() {
        return $this->article_stockes_categorie;
    }

    public function setArticle_stockes_categorie($article_stockes_categorie) {
        $this->article_stockes_categorie = $article_stockes_categorie;
        return $this;
    }
    
    public function getQuantite() {
        return $this->quantite;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
        return $this;
    }
	
	public function getQte_stock() {
        return $this->qte_stock;
    }

    public function setQte_stock($qte_stock) {
        $this->qte_stock = $qte_stock;
        return $this;
    }
	
	public function getQte_vendu() {
        return $this->qte_vendu;
    }

    public function setQte_vendu($qte_vendu) {
        $this->qte_vendu = $qte_vendu;
        return $this;
    }
	
	public function getQte_solde() {
        return $this->qte_solde;
    }

    public function setQte_solde($qte_solde) {
        $this->qte_solde = $qte_solde;
        return $this;
    }
	
	

}

?>
