<?php

class Application_Model_DbTable_EuProduit extends Zend_Db_Table_Abstract
{

    protected $_name = 'eu_produit';
	protected $_primary = 'code_produit';
    protected $_referenceMap    = array(
        'Categorie' => array(
            'columns'           => 'code_categorie',
            'refTableClass'     => 'Application_Model_DbTable_Categorie',
            'refColumns'        => 'code_categorie'
        )
    );

}

