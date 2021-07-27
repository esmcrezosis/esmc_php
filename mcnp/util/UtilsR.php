<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

final class Util_Utils {

    private function __construct() {
        
    }

	
	public static function getLastInsertNnId() {
        $t_nn = new Application_Model_DbTable_EuNn();
        $select = $t_nn->select();
        $select->from($t_nn, array('MAX(id_nn) as COUNT'));
        $result = $t_nn->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }
	
	public function findConuter() {
	    $t_sms = new Application_Model_DbTable_EuSms();
        $select = $t_sms->select();
        $select->from($t_sms, array('MAX(neng) as COUNT'));
        $result = $t_sms->fetchAll($select);
        $row = $result->current();
        return $row['COUNT'];
    }
	
	
	public function findquota($code_membre,$code_cat) {
	     $t_op = new Application_Model_DbTable_EuOperation();
         $select = $t_op->select();
         $select->from($t_op, array('COUNT(id_operation) as COUNT'));
		 $select->where('code_cat = ?',$code_cat);
		 $select->where('code_membre = ?',$code_membre);
         $result = $t_op->fetchAll($select);
         $row = $result->current();
         return $row['COUNT'];
    }
	
	
	public function findquotabypaysb($pays,$code_cat) {
	       $t_op = new Application_Model_DbTable_EuOperation();
		   $select = $t_op->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		   //$select = $t_op->distinct();
           $select->setIntegrityCheck(false)
		          ->join('eu_membre', 'eu_membre.code_membre = eu_operation.code_membre',array('COUNT(eu_membre.code_membre) COUNT','eu_operation.*','eu_membre.*'))
                  ->join('eu_utilisateur', 'eu_utilisateur.id_utilisateur = eu_operation.id_utilisateur')
				  ->where('eu_utilisateur.id_pays = ?',$pays)
				  ->where('eu_operation.code_cat = ?',$code_cat)
				  ;
		   $result = $t_op->fetchAll($select);
           $row = $result->current();
           return $row['COUNT'];
	       
	}
	
	public function findquotabypays($pays,$code_cat) {
	    $db = Zend_Db_Table::getDefaultAdapter();
	    $requete = "SELECT count(DISTINCT eu_operation.code_membre) as COUNT FROM eu_operation,eu_utilisateur WHERE  eu_operation.id_utilisateur=eu_utilisateur.id_utilisateur AND
                   eu_operation.code_cat LIKE '$code_cat' AND eu_utilisateur.id_pays=$pays";
	    $db->setFetchMode(Zend_Db::FETCH_OBJ);
		$stmt = $db->query($requete);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
                return $row->COUNT;
	    }		 
	}
	
	
	
	
   /* public static function addSms($compteur, $recipient, $smsbody) {
        $t_sms = new Application_Model_DbTable_EuSms();
        if ($recipient != '' && $smsbody != '') {
            $date = Zend_Date::now();
            $data = array(
                'neng' => $compteur,
                'recipient' => $recipient,
                'smsbody' => $smsbody,
                'datetime' => $date->toString('dd/MM/yyyy HH:mm:ss'),
                'iddatetime' => self::getIDDate($date->toString('dd/MM/yyyy'))
            );
            $t_sms->insert($data);
			
			
			
			
/////////////////////////////////////////////////////////////////////////			
			
			
			
$mysqli = @new mysqli("localhost", "gnokii", "smsgnokii", "sms");

if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}

if ($result = $mysqli->query("INSERT INTO  `outbox` (`number` ,`processed_date` ,`insertdate` ,`text` ,`phone` ,`processed` ,`error` ,`dreport` ,`not_before` ,`not_after`) VALUES ('".$recipient."', '".$date->toString('yyyy-MM-dd HH:mm:ss')."', '".$date->toString('yyyy-MM-dd HH:mm:ss')."', '".$smsbody."', '', 0, 0, 0, '00:00:00',	'23:59:59');")) {

}

$mysqli->close();
			
			
			
			
			
			
			
			
        }
    }*/

	
	public static function genererCodeSMS($number) {
        $string = "";
        $user_ramdom_key = "aLABbC0cEd1eDf2FghR3ij4kYXQl5UmOPn6pVq7rJs8tuW9IvGwxHTyKZMS";
        srand((double) microtime() * time());
        for ($i = 0; $i < $number; $i++) {
            $string .= $user_ramdom_key[rand() % strlen($user_ramdom_key)];
        }
        return $string;
    }
     public static function toDate_bis($date) {
        $z_date = new DateTime($date->toString('yyyy-MM-dd'));
        $date_exp = date_format($z_date, 'Y-m-d H:i:s');
        return $date_exp;
    }

    public static function toDate($date) {
        $date_exp = $date->toString('yyyy-MM-dd');
        return $date_exp;
    }
	
    public static function convertDate($date) {
        if ($date != '') {
            $date1 = explode("/", $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            return $dated;
        }
    }
   
    
    public static function convertDated($date,$delimiter) {
        if ($date != '') {
            $date1 = explode($delimiter, $date);
            $dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            return $dated;
        }
    }


    public static function calculCredit($mont_capa, $pck, $prk) {
        return ($mont_capa * $prk) / $pck;
    }


    public static function getCapaByCredit($id_credit) {
        $t_capa = new Application_Model_DbTable_EuCapa();
        $select = $t_capa->select();
        $select->where('id_credit = ?', $id_credit);
        $results = $t_capa->fetchAll($select);
        if (count($results) > 0) {
            return $results->current();
        } else {
            return NULL;
        }
    }

    public static function calculCapa($mont_credit, $pck, $prk) {
        return ($mont_credit * $pck) / $prk;
    }

    public static function getTypeRappro($type) {
        $type_rappro = '';
        if ($type == 'FGRPGr') {
            $type_rappro = 'FGRPG1/RPGr';
        } elseif ($type == 'FGRPGnr') {
            $type_rappro = 'FGRPG1/RPGnr';
        } elseif ($type == 'FGInr') {
            $type_rappro = 'Inr2/InrSC';
        } elseif ($type == 'FGIr') {
            $type_rappro = 'Ir2/IrSC';
        } elseif ($type == 'EInr') {
            $type_rappro = 'Inr4/InrSC';
        } elseif ($type == 'ECNCSr') {
            $type_rappro = 'CNCSr6/RPGnr';
        } elseif ($type == 'ECNCSnr') {
            $type_rappro = 'CNCSnr5/RPGnr';
        } elseif ($type == 'EGCP-Inr') {
            $type_rappro = 'GCP11/Inr';
        } elseif ($type == 'EGCP-RPGnr') {
            $type_rappro = 'GCP12/RPGnr';
        }
        return $type_rappro;
    }

    public static function getParametre($code_param, $lib_param) {
        $param = 0;
        try {
            $tparam = new Application_Model_DbTable_EuParametres();
            $select_pck = $tparam->select();
            $select_pck->where('code_param = ?', $code_param)
                    ->where('lib_param = ?', $lib_param);
            $rows = $tparam->fetchAll($select_pck);
            if (count($rows) > 0) {
                $row = $rows->current();
                $param = $row->montant;
            }
            return $param;
        } catch (Exception $exc) {
            echo "Erreur d'éxécution: " . $exc->getMessage();
        }
    }

     public static function addOperation($id, $code_membre, $code_membre_morale, $code_cat, $montant_op, $code_produit, $lib_op, $type_op, $date_op, $heure_op, $utilisateur) {
        $t_operation = new Application_Model_DbTable_EuOperation();
        if ($id != NULL) {
            $data = array(
                'id_operation' => $id,
                'date_op' => Util_Utils::toDate($date_op),
                'montant_op' => $montant_op,
                'code_membre' => $code_membre,
                'code_membre_morale' => $code_membre_morale,
                'heure_op' => Util_Utils::toDate($heure_op),
                'code_produit' => $code_produit,
                'id_utilisateur' => $utilisateur,
                'lib_op' => $lib_op,
                'code_cat' => $code_cat,
                'type_op' => $type_op
            );
            $t_operation->insert($data);
        }
    }

    public static function addCnp($id_credit, $mont_debit, $mont_credit, $solde_cnp, $source, $type, $date_cnp, $code_capa, $dom) {
        $t_operation = new Application_Model_DbTable_EuCnp();
        if ($id_credit != '') {
            $data = array(
                'id_credit' => $id_credit,
                'mont_debit' => $mont_debit,
                'mont_credit' => $mont_credit,
                'solde_cnp' => $solde_cnp,
                'source_credit' => $source,
                'type_cnp' => $type,
                'date_cnp' => $date_cnp,
                'code_capa' => $code_capa,
                'code_domicilier' => $dom
            );
            $t_operation->insert($data);
        }
    }

    public static function createCompte($code, $libelle, $code_cat, $solde, $membre, $type_compte, $date, $desactiver,$code_membre_morale) {
        $t_compte = new Application_Model_DbTable_EuCompte();
        if ($code != '' && $membre != '' && $code_cat != '' && $type_compte != '') {
            $data = array(
                'code_compte' => $code,
                'code_membre' => $membre,
				'code_membre_morale' => $code_membre_morale,
                'solde' => $solde,
                'lib_compte' => $libelle,
                'date_alloc' => $date,
                'desactiver' => $desactiver,
                'code_type_compte' => $type_compte,
                'code_cat' => $code_cat
            );

            $t_compte->insert($data);
        }
    }

   public static function createCompteCredit($id, $affecter, $id_op, $membre, $produit, $compte, $montant, $mont_place, $datedeb, $datefin, $source, $compte_source, $krr, $renouveller, $domicilier, $bnp, $code_bnp,$type_credit,$prk) {
        $t_credit = new Application_Model_DbTable_EuCompteCredit();
        if ($id != '' && $membre != '' && $produit != '' && $compte != '') {
            $data = array(
                'id_credit' => $id,
                'montant_credit' => $montant,
                'code_membre' => $membre,
                'code_produit' => $produit,
                'montant_place' => $mont_place,
                'datefin' => Util_Utils::toDate($datefin),
                'datedeb' => Util_Utils::toDate($datedeb),
                'source' => $source,
                'date_octroi' => Util_Utils::toDate($datedeb),
                'compte_source' => $compte_source,
                'krr' => $krr,
                'renouveller' => $renouveller,
                'bnp' => $bnp,
                'code_compte' => $compte,
                'id_operation' => $id_op,
                'domicilier' => $domicilier,
                'code_bnp' => $code_bnp,
                'affecter' => $affecter,
                'code_type_credit' => $type_credit,
                'prk' => $prk
            );
            $t_credit->insert($data);
        }
    }
	
	public static function getMembreType($membre) {
        if (isset($membre)) {
            return substr($membre, -1, 1);
        } else {
            return '';
        }
    }

    public static function getMembreMorale($code_membre, Application_Model_EuMembreMorale $moral) {
        if (isset($code_membre)) {
            $type = Util_Utils::getMembreType($code_membre);
            if ($type === 'M') {
                $m_moral = new Application_Model_EuMembreMoraleMapper();
                return $m_moral->find($code_membre, $moral);
            }
        } else {
            return FALSE;
        }
    }

    public static function getMembre($code_membre, Application_Model_EuMembre $membre) {
        if (isset($code_membre)) {
            $type = Util_Utils::getMembreType($code_membre);
            if ($type === 'P') {
                $m_membre = new Application_Model_EuMembreMapper();
                return $m_membre->find($code_membre, $membre);
            }
        } else {
            return FALSE;
        }
    }

    public static function verifierCodeSMS(Application_Model_EuSmsmoney $sms) {
        $montant = 0;
        if ($sms != NULL && $sms->getDestAccount_Consumed() == ' ') {
            $compte_transfert = $sms->getFromAccount();
            list($type_Num, $code_cat, $membre_transfert) = explode('-', $compte_transfert);
            if ($type_Num == 'NN' && $code_cat == 'TR') {
                $tab_acteur = new Application_Model_DbTable_EuActeur();
                $select = $tab_acteur->select();
                $select->where('code_membre like ?', $membre_transfert)
                        ->where('code_activite in (?)', array('PBF', 'DSMS'));
                $acteurs = $tab_acteur->fetchAll($select);
                if (count($acteurs) > 0) {
                    $montant = $sms->getCreditAmount();
                    $code_dev = $sms->getCurrencyCode();
                    if ($code_dev != 'XOF') {
                        $code_cours = $code_dev . '-XOF';
                        $cours = new Application_Model_EuCours();
                        $m_cours = new Application_Model_EuCoursMapper();
                        $ret = $m_cours->find($code_cours, $cours);
                        if ($ret) {
                            if (isset($montant)) {
                                $montant = $montant * $cours->getVal_dev_fin();
                            }
                        }
                    }
                }
            }
        }
        return $montant;
    }

    public static function verifierMembre($membre) {
        $ret = false;
        if (isset($membre)) {
            if (substr($membre, -1, 1) === 'M') {
                $t_moral = new Application_Model_DbTable_EuMembreMorale();
                $m_result = $t_moral->find($membre);
                $ret = (count($m_result) == 1);
            } else {
                $t_membre = new Application_Model_DbTable_EuMembre();
                $m_result = $t_membre->find($membre);
                $ret = (count($m_result) == 1);
            }
        }
        return $ret;
    }

    public function verifierMembreType($membre, $type) {
        if (isset($membre) && isset($type)) {
            $type_membre = Util_Utils::getMembreType($membre);
            return ($type_membre === $type);
        } else {
            return FALSE;
        }
    }
	

    public static function getIDDate($Unedate) {
        try {
            if ($Unedate == '') {
                return 0;
                exit();
            }

            list($Jour, $Mois, $Annee) = explode('/', $Unedate);
            IF ($Annee < 100)
                $Annee = "20" . $Annee;  //Provisoire

            $timestamp = mktime(0, 0, 0, $Mois, $Jour, $Annee);
            $timestamp1 = $timestamp - mktime(0, 0, 0, 1, 1, $Annee) + (3600 * 24);

            $Result = round($timestamp1 / (3600 * 24)) + 366 * (date('Y', $timestamp) - 1);

            return $Result;
        } catch (Exception $e) {
            echo 'Exception reçue : ', $e->getMessage(), "\n";
        }
    }

}

?>
