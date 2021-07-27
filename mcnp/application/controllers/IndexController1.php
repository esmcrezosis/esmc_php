<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
		
include("Url.php");   
 
    $liste = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codesecret = "";
    while(strlen($codesecret) != 8) {
    $codesecret .= $liste[rand(0,61)]; 
    }
    $this->view->codesecret = $codesecret;
	

    }

    public function mcnpAction()
    {
      /* page index/mcnp  */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
$this->view->index = "mcnp";


    }

    public function ceuAction()
    {
      /* page index/ceu  */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicceu');
    
$this->view->index = "ceu";


    }
    public function esmcAction()
    {
      /* page index/esmc  */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
$this->view->index = "esmc";

    }
  

    public function indexAction()
    {
      /* page index  */

    $sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
$this->view->index = "esmc";

    }
  
    public function filiereAction()
    {
        /* page index/filiere - Liste des acteurs */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $filiere = new Application_Model_EuFiliereMapper();
        $this->view->selectfiliere = $filiere->fetchAll2();
		
        $acteursmembremorale = new Application_Model_EuMembreMoraleMapper();
        if(isset($_POST['ok']) && $_POST['ok']=="ok"){
        $this->view->entriesrecherche = $acteursmembremorale->fetchAllrecherche($_POST['id_filiere'], $_POST['quartier'], $_POST['ville']);
        }else{
        $this->view->entries = $filiere->fetchAll2();
			}

    }

    public function rechercheAction()
    {
        /* page index/recherche - Recherche des acteurs par criteres quartier, ville et filiere */

    $this->_helper->layout()->setLayout('layoutpublic');
        $filiere = new Application_Model_EuFiliereMapper();
        $acteursmembremorale = new Application_Model_EuMembreMoraleMapper();
        $this->view->selectfiliere = $filiere->fetchAll2();
        if(isset($_POST['ok']) && $_POST['ok']=="ok"){
        $this->view->entries = $acteursmembremorale->fetchAllrecherche($_POST['id_filiere'], $_POST['quartier'], $_POST['ville']);
        }
    }



    public function filiereproduitAction()
    {
        /* page index/filiereproduit - Liste des produits en fonction des acteurs  */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $filiere = new Application_Model_EuFiliereMapper();
        $this->view->entries = $filiere->fetchAll3();
    $this->view->selectfiliere = $filiere->fetchAll3();

    }


    public function categorieAction()
    {
        /* page index/categorie - Liste des produits en fonction des categories  */

$sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $categorie = new Application_Model_EuCategorieBpsMapper();
        $this->view->selectcategorie = $categorie->fetchAll();
		
        $articlestockes = new Application_Model_EuArticleStockesMapper();
        if(isset($_POST['ok']) && $_POST['ok']=="ok"){
        $this->view->entriesrecherche = $articlestockes->fetchAllByCategorieTypeImage($_POST['id_categorie'], $_POST['type'], $_POST['image']);
        }else{
        $this->view->entries = $categorie->fetchAll();
			}

if (!isset($sessionmembre->code_membre)) {
                    $sessionmembre->errorlogin = "Vous devez vous connecter à votre espace avant d'effectuer cette action...";
          } 


    }


    public function documentAction()
    {
        /* page index/document - Liste des DAC (Dossiers d'Appel à Candidature) et des AAOO (Avis d'Appel d'Offres Ouverts) */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

        $document = new Application_Model_EuDocumentMapper();
        $this->view->entries = $document->fetchAll3();

    }


    public function addappeloffresAction()
    {
        /* page index/addappeloffres - Soumission à l'appel d'offre */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['id_document']) && $_POST['id_document']!="" && isset($_POST['num_appeloffres']) && $_POST['num_appeloffres']!="" && isset($_POST['libelle_appeloffres']) && $_POST['libelle_appeloffres']!="" && isset($_FILES['desc_appeloffres']['name']) && $_FILES['desc_appeloffres']['name']!="") {
    
    include("Transfert.php");
    $chemin = "appeloffress";
    $file = $_FILES['desc_appeloffres']['name'];
    $file1='desc_appeloffres';
    $appeloffres = $chemin."/".transfert($chemin,$file1);
      
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuAppeloffres();
        $ma = new Application_Model_EuAppeloffresMapper();
      
            $compteur = $ma->findConuter() + 1;
            $a->setId_appeloffres($compteur);
            $a->setId_document($_POST['id_document']);
            $a->setNum_appeloffres($_POST['num_appeloffres']);
            $a->setLibelle_appeloffres($_POST['libelle_appeloffres']);
            $a->setDesc_appeloffres($appeloffres);
            $a->setId_utilisateur($_POST['id_utilisateur']);
            $a->setPreselection(0);
            $a->setSelection(0);
            $a->setPropo(0);
            $a->setOkfinal(0);
      $a->setDate_appeloffres($date_id->toString('yyyy-MM-dd'));
            $ma->save($a);
      
    $this->_redirect('/index/document');
    } else {  $this->view->error = "Champs * obligatoire ..."; 
     
            $id = (int)$this->_request->aram('id');
            if ($id != 0) {
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
    $ma->find($id, $a);
    $this->view->document = $a;
            }
  }
       
  } else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $a = new Application_Model_EuDocument();
        $ma = new Application_Model_EuDocumentMapper();
    $ma->find($id, $a);
    $this->view->document = $a;
            }
  }
  }


    public function acteurproduitAction()
    {
        /* page index/acteurproduit - Liste des produits par acteur */

$sessionmembre = new Zend_Session_Namespace('membre');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

        $id = (string) $this->_request->getParam('id');
    if($id!=""){
      $this->view->code_membre_vendeur = $id;

        $articlestockes = new Application_Model_EuArticleStockesMapper();
        $this->view->entries = $articlestockes->fetchAllByVendeur($id);

if (!isset($sessionmembre->code_membre)) {
                    $sessionmembre->errorlogin = "Vous devez vous connecter à votre espace avant d'effectuer cette action...";
          } 



    } else {  $this->_redirect('/index/filiere');  } 
    }


    public function appelnnAction()
    {
        /* page index/appelnn - Liste des collectes */

$sessionmembre = new Zend_Session_Namespace('membre');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;
              $date_fin = clone $date_id;
        $periode = Util_Utils::getParametre('periode', 'collecte');
              $date_fin->addDay($periode);
        
        $proposition = new Application_Model_EuProposition();
        $map_proposition = new Application_Model_EuPropositionMapper();
        $membre = new Application_Model_EuMembre();
        $map_membre = new Application_Model_EuMembreMapper();
        $membremorale = new Application_Model_EuMembreMorale();
        $map_membremorale = new Application_Model_EuMembreMoraleMapper();
        $proposition = new Application_Model_EuProposition();
        $map_proposition = new Application_Model_EuPropositionMapper();
              $appel = new Application_Model_EuAppelNn();
        $map_appel = new Application_Model_EuAppelNnMapper();
              $t_appel = new Application_Model_DbTable_EuAppelNn();
              $compte = new Application_Model_EuCompte();
              $map_compte = new Application_Model_EuCompteMapper();
              $dappel = new Application_Model_EuDetailAppelNn();
        $map_dappel = new Application_Model_EuDetailAppelNnMapper();

        $appel_offre = new Application_Model_EuAppelOffre();
        $map_appel_offre = new Application_Model_EuAppelOffreMapper();

    $t_frais = new Application_Model_DbTable_EuFrais();
        $select = $t_frais->select();
    $select->where('valider = ?',1);
    $select->where('disponible = ?',1); 
        $frais = $t_frais->fetchAll($select);

        foreach ($frais as $row) {

    $id_proposition = $row->id_proposition;
    $map_proposition->find($row->id_proposition, $proposition);
    $map_appel_offre->find($proposition->id_appel_offre, $appel_offre);
    $appel_nn = "Collecte : ".$appel_offre->numero_offre." / ".$appel_offre->nom_appel_offre;
    
    $t_utilisateur = new Application_Model_DbTable_EuUtilisateur();
        $select = $t_utilisateur->select();
    $select->where('code_groupe = ?',"surveillance");
        $utilisateur = $t_utilisateur->fetchRow($select);
    $code_compte == "NN-CAPA-".$utilisateur->code_membre;
    $code_membreb == $utilisateur->code_membre;
    
               $nn = $map_appel->findByAppel($id_proposition);
             $compteur_appel = $map_appel->findConuter() + 1;
             if ($nn == NULL) {
                $appel->setId_appel_nn($compteur_appel)
                  ->setId_proposition($id_proposition)
                      ->setDesignation_appel($appel_nn)
                                  ->setDate_appel($date_idd->toString('yyyy-MM-dd'))
                  ->setDate_fin($date_fin->toString('yyyy-MM-dd'))
                                  ->setCode_compte($code_compte)
                                  ->setMontant_nn(0)
                                  ->setDisponible(0)
                                  ->setCode_membre_morale($code_membreb)
                                  ->setId_utilisateur(NULL);//$user->id_utilisateur    
                      $map_appel->save($appel);
             }

             }


        $appelnn = new Application_Model_EuAppelNnMapper();
    
    $t_utilisateur = new Application_Model_DbTable_EuUtilisateur();
        $select = $t_utilisateur->select();
    $select->where('code_groupe = ?',"surveillance");
    $select->where('code_membre = ?',$sessionmembre->code_membre);
        $utilisateur = $t_utilisateur->fetchRow($select);
    if(count($utilisateur) > 0){
        $this->view->entries = $appelnn->fetchAll3();
      }else{
        $this->view->entries = $appelnn->fetchAll2();
        }

    }






    public function acteurpbfAction()
    {
        /* page index/acteurpbf - Liste des pdf */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

        $acteurpbf = new Application_Model_EuMembreMoraleMapper();
        $this->view->entries = $acteurpbf->fetchAllPbfDsms();

    }


    public function acteurpbfsourceAction()
    {
        /* page index/acteurpbfsource - Liste des pdf source */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

        $acteurpbf = new Application_Model_EuMembreMoraleMapper();
        $this->view->entries = $acteurpbf->fetchAllDivisionSource(3);//

    }


    public function codesmsAction()
    {
        /* page index/codesms - Achat de Code SMS */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $id = (int) $this->_request->getParam('id');
    if($id > 0){
      
$acteurM = new Application_Model_EuActeur();
$acteur = new Application_Model_EuActeur();
$acteurM->find($id, $acteur);

      $this->view->code_membre_vendeur = $acteur->code_membre;
      $this->view->code_envoi = 'NN-TR-' . $acteur->code_membre;

        if (isset($_POST['ok']) && $_POST['ok'] == "ok") {
            if (isset($_POST['type_transfert']) && $_POST['type_transfert'] != "" && isset($_POST['mont_transfert']) && $_POST['mont_transfert'] > 0 && isset($_POST['tel_dest']) && $_POST['tel_dest'] != "") {


if($_POST['type_transfert'] == "MF107" || $_POST['type_transfert'] == "MF11000" || $_POST['type_transfert'] == "MFL"){
$mont = Util_Utils::getParametre('FCPS', 'valeur') + Util_Utils::getParametre('FL', 'valeur') + Util_Utils::getParametre('FS', 'valeur');
$quota = Util_Utils::getParametre('quotaMF', 'valeur');
$montant_total = $quota * $mont;
$result = $_POST['mont_transfert'] % $mont;
  if($result != 0){
                    $this->view->error = "Le montant n'est pas un multiple de ".$mont.".";
                    return;
    }
  if($_POST['mont_transfert'] > $montant_total){
                    $this->view->error = "Le montant dépasse le montant autorisé, soit ".$quota." part de ".$mont.".";
                    return;
    }
  }


$acteurM = new Application_Model_EuActeur();
$acteur = new Application_Model_EuActeur();
$acteurM->find($id, $acteur);

      $this->view->code_membre_vendeur = $acteur->code_membre;

        $type = $_POST['type_transfert'];
        $tel = $_POST['tel_dest'];
        $code_envoi = 'NN-TR-' . $acteur->code_membre;
        //$code_recu = $request->code_recu;
        $montant = $_POST['mont_transfert'];
        //$code_dev = $request->code_dev;
    

            $date = Zend_Date::now();

                $cm_map = new Application_Model_EuCompteMapper();
                $cm = new Application_Model_EuCompte();
                $ret = $cm_map->find($code_envoi, $cm);

                if ($ret && $cm->getSolde() >= $montant) {
          
                    $code_transfert = strtoupper(Util_Utils::genererCodeSMS(8));
          
            $money_map = new Application_Model_EuSmsmoneyMapper();
            $compteursmsmoney = $money_map->findConuter() + 1;
            $sms_money = new Application_Model_EuSmsmoney();
                  $sms_money->setNEng($compteursmsmoney)
                    ->setCreditAmount($montant)
                    ->setFromAccount($code_envoi)
                    ->setCreditCode($code_transfert)
                    ->setSentTo($tel)
                    ->setDestAccount(NULL)
                    ->setDatetime($date->toString('yyyy-MM-dd HH:mm:ss'))
                    ->setDatetimeConsumed(NULL)
                    ->setDestAccount_Consumed(NULL)
                    ->setCurrencyCode('XOF')
                    ->setIDDatetimeConsumed(0)
                    ->setIDDatetime(Util_Utils::getIDDate($date->toString('yyyy-MM-dd')))
                    ->setId_Utilisateur(NULL)
                    ->setMotif($type)
                    ->setCode_Agence(NULL)
                    ->setNum_recu($NULL);
                    $money_map->save($sms_money);
            
    

$mp_detailsmsmoney = new Application_Model_EuDetailSmsmoneyMapper();
$p_detailsmsmoney = new Application_Model_EuDetailSmsmoney();
$entries_detailsmsmoney = $mp_detailsmsmoney->findByCodeMembre($acteur->code_membre);
$montplace = $montant;
foreach ($entries_detailsmsmoney as $entry):            

if($montplace <= $entry->solde_sms){      
$detailsmsmoney_mapper = new Application_Model_EuDetailSmsmoneyMapper();
$detailsmsmoney_p = new Application_Model_EuDetailSmsmoney();
$result_detailsmsmoney = $detailsmsmoney_mapper->find($entry->id_detail_smsmoney, $detailsmsmoney_p);
$detailsmsmoney_p->setSolde_sms($detailsmsmoney_p->getSolde_sms() - $montplace);
$detailsmsmoney_p->setMont_vendu($detailsmsmoney_p->getMont_vendu() + $montplace);
$detailsmsmoney_mapper->update($detailsmsmoney_p);


            $td_dvent = new Application_Model_DbTable_EuDetailVentesms();
                        $d_dvent = new Application_Model_EuDetailVentesms();
                                $d_dvent->setId_detail_smsmoney($entry->id_detail_smsmoney)
                                        ->setId_utilisateur(NULL)
                                        ->setCode_membre(NULL)
                                        ->setCode_membre_dist($acteur->code_membre)
                                        ->setMont_vente($montplace)
                                        ->setDate_vente($date->toString('yyyy-MM-dd HH:mm:ss'))
                                        ->setType_tansfert($type)
                                        ->setCreditcode($code_transfert)
                                        ->setCode_produit($type);
                                $td_dvent->insert($d_dvent->toArray());


break;
}else{
$detailsmsmoney_mapper = new Application_Model_EuDetailSmsmoneyMapper();
$detailsmsmoney_p = new Application_Model_EuDetailSmsmoney();
$result_detailsmsmoney = $detailsmsmoney_mapper->find($entry->id_detail_smsmoney, $detailsmsmoney_p);
$detailsmsmoney_p->setSolde_sms($detailsmsmoney_p->getSolde_sms() - $entry->solde_sms);
$detailsmsmoney_p->setMont_vendu($detailsmsmoney_p->getMont_vendu() + $entry->solde_sms);
$detailsmsmoney_mapper->update($detailsmsmoney_p);
$montplace = $montplace - $entry->solde_sms;


            $td_dvent = new Application_Model_DbTable_EuDetailVentesms();
                        $d_dvent = new Application_Model_EuDetailVentesms();
                                $d_dvent->setId_detail_smsmoney($entry->id_detail_smsmoney)
                                        ->setId_utilisateur(NULL)
                                        ->setCode_membre(NULL)
                                        ->setCode_membre_dist($acteur->code_membre)
                                        ->setMont_vente($entry->solde_sms)
                                        ->setDate_vente($date->toString('yyyy-MM-dd HH:mm:ss'))
                                        ->setType_tansfert($type)
                                        ->setCreditcode($code_transfert)
                                        ->setCode_produit($type);
                                $td_dvent->insert($d_dvent->toArray());


}     
endforeach;           
            


            $sms = new Application_Model_EuSms();
            $compteursms = $sms->findConuter() + 1;
            $tbl_sms = new Application_Model_DbTable_EuSms();
                      $sms->setNEng($compteursms)
                        ->setDateEnvoi(NULL)
                            ->setDateTime($date->toString('yyyy-MM-dd HH:mm:ss'))
                            ->setHeureEnvoi(NULL)
                            ->setIDHeureEnvoi(0)
                            ->setDecodeString(NULL)
                            ->setTypeDestinataire(NULL)
              ->setRecipient($tel)
                            ->setNom(NULL)
                            ->setPrenom(NULL)
                            ->setSociete(NULL)
                            ->setRetries(0)
                            ->setEnvoyeLe(NULL)
                            ->setEnvoyePar(NULL)
                            ->setIDDatetime(Util_Utils::getIDDate($date->toString('yyyy-MM-dd')))
                            ->setIDDateEnvoi(0)
                            ->setSMSBody($montant . ' ont ete ajoute au Code: ' . $code_transfert)
                            ->setEtat(0);
                    $tbl_sms->insert($sms->toArray());







                    $cm->setSolde($cm->getSolde() - $montant);
                    $cm_map->update($cm);

                $this->view->error = "Operation bien effectuée";
                } else {
                    $this->view->error = "Erreur de traitement: Le solde du transfert est insuffisant ou ce compte n'existe pas";
                    //return;
                }

            } else {
                $this->view->error = "Saisir tous les champs";
            }
        }

    } else {  $this->_redirect('/index/acteurpbf');  } 


    }



    public function codesmssourceAction()
    {
        /* page index/codesmssource - Achat de Code SMS Source */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $id = (int) $this->_request->getParam('id');
    if($id > 0){
      
$acteurM = new Application_Model_EuActeur();
$acteur = new Application_Model_EuActeur();
$acteurM->find($id, $acteur);

      $this->view->code_membre_vendeur = $acteur->code_membre;
      
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['acheteur_type']) && $_POST['acheteur_type']!="" && 
  (
  (isset($_POST['acheteur_nom']) && $_POST['acheteur_nom']!="" && isset($_POST['acheteur_prenom']) && $_POST['acheteur_prenom']!="") || 
  isset($_POST['acheteur_raison_sociale']) && $_POST['acheteur_raison_sociale']!=""
  ) && 
  isset($_POST['acheteur_numero']) && $_POST['acheteur_numero']!="" && isset($_POST['type_transfert']) && $_POST['type_transfert']!="" && isset($_POST['acheteur_cel']) && $_POST['acheteur_cel']!="" && isset($_POST['acheteur_banque']) && $_POST['acheteur_banque']!="" && isset($_POST['mont_transfert']) && $_POST['mont_transfert']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {
    
      
        $acheteur_mapper = new Application_Model_EuAcheteurMapper();
    $acheteur = $acheteur_mapper->fetchAllByNumero($_POST['acheteur_numero'], $_POST['acheteur_banque']); 
    if(count($acheteur) > 0){
$this->view->error = "Numéro de reçu déjà utilisé ...";
      }else{
      
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
      
        $acheteur = new Application_Model_EuAcheteur();
        $acheteur_mapper = new Application_Model_EuAcheteurMapper();
      
            $compteur_acheteur = $acheteur_mapper->findConuter() + 1;
            $acheteur->setAcheteur_id($compteur_acheteur);
            $acheteur->setAcheteur_prenom($_POST['acheteur_prenom']);
            $acheteur->setAcheteur_nom($_POST['acheteur_nom']);
            $acheteur->setAcheteur_raison_sociale($_POST['acheteur_raison_sociale']);
            $acheteur->setAcheteur_numero($_POST['acheteur_numero']);
            $acheteur->setAcheteur_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $acheteur->setType_transfert($_POST['type_transfert']);
            $acheteur->setAcheteur_banque($_POST['acheteur_banque']);
            $acheteur->setAcheteur_cel($_POST['acheteur_cel']);
            $acheteur->setMont_transfert($_POST['mont_transfert']);
            $acheteur->setAcheteur_code_membre($acteur->code_membre);
            $acheteur->setAcheteur_type($_POST['acheteur_type']);
            $acheteur->setCode_agence($_POST['code_agence']);
            $acheteur->setPublier(0);
            $acheteur_mapper->save($acheteur);


if($_POST['acheteur_type'] == "PP"){
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $_POST["acheteur_cel"], "Vous venez de payer un code SMS. Vous allez recevoir une confirmation dans quelques minutes");

$mobilekacm = Util_Utils::getParametre('mobile', 'kacm');
$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSms($compteur, $mobilekacm, "Un achat de Code SMS est fait. Acheteur: ".$_POST['acheteur_nom']." ".$_POST['acheteur_prenom'].", Reçu banque: ".$_POST['acheteur_numero'].", Banque: ".$_POST['acheteur_banque'].", Type transfert: ".$_POST['type_transfert']);

}else if($_POST['acheteur_type'] == "PM"){
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $_POST["acheteur_cel"], "Vous venez de payer un code SMS. Vous allez recevoir une confirmation. Veuillez contacter le centre de enrolement le plus proche pour avoir vos agrements...");

$mobilekacm = Util_Utils::getParametre('mobile', 'kacm');
$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSms($compteur, $mobilekacm, "Un achat de Code SMS est fait. Acheteur: ".$_POST['acheteur_raison_sociale'].", Reçu banque: ".$_POST['acheteur_numero'].", Banque: ".$_POST['acheteur_banque'].", Type transfert: ".$_POST['type_transfert']);
  }

$this->view->error = "Opération bien réussie. Vous serez contacté dans quelques instants.";

    //$this->_redirect('/index/codesmssource/id/'.$id);
        } 
    } else {  $this->view->error = "Champs * obligatoire ..."; }
  }


    } else {  $this->_redirect('/index/acteurpbfsource');  } 


    }




    public function enrolementsmsAction()
    {
        /* page index/enrolementsms - Enrolement avec Code SMS */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
  
    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if (isset($_POST['code_fs']) && $_POST['code_fs']!="" && isset($_POST['code_fl']) && $_POST['code_fl']!="" && isset($_POST['nom_membre']) && $_POST['nom_membre']!="" && isset($_POST['sexe_membre']) && $_POST['sexe_membre']!="" && isset($_POST['nationalite_membre']) && $_POST['nationalite_membre']!="" && isset($_POST['sitfam_membre']) && $_POST['sitfam_membre']!="" && isset($_POST['prenom_membre']) && $_POST['prenom_membre']!="" && isset($_POST['date_nais_membre']) && $_POST['date_nais_membre']!="" && isset($_POST['lieu_nais_membre']) && $_POST['lieu_nais_membre']!="" && isset($_POST['nbr_enf_membre']) && $_POST['nbr_enf_membre']!="" && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" && isset($_POST['profession_membre']) && $_POST['profession_membre']!="" && isset($_POST['religion_membre']) && $_POST['religion_membre']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="") {
// && isset($_POST['code_fkps']) && $_POST['code_fkps']!=""     


$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
if($smsmoneyFS = $smsmoneyM->findByCreditCode9($_POST['code_fs'], "FS") && $smsmoneyFL = $smsmoneyM->findByCreditCode9($_POST['code_fl'], "FL") && (($_POST['code_fkps']=="") || (isset($_POST['code_fkps']) && $_POST['code_fkps']!="" && $smsmoneyFKPS = $smsmoneyM->findByCreditCode9($_POST['code_fkps'], "FCPS")))){
// && $smsmoneyFKPS = $smsmoneyM->findByCreditCode9($_POST['code_fkps'], "FCPS")

            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
                    $date_nais = new Zend_Date($_POST["date_nais_membre"]);

$preinsc_mapper = new Application_Model_EuPreinscriptionMapper();
$compteur = $preinsc_mapper->findConuter() + 1;         
          
                        $preinscription = new Application_Model_EuPreinscription();
                        $mapper = new Application_Model_EuPreinscriptionMapper();
            
                    $preinscription->setId_preinscription($compteur)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($_POST["id_pays"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setHeure_inscription($date_idd->toString('HH:mm:ss'))
                           ->setDate_inscription($date_id->toString('yyyy-MM-dd'))
                           ->setCode_membre(NULL)
                           ->setCode_fs($_POST["code_fs"])
                           ->setCode_fl($_POST["code_fl"]);
                    $preinscription->setCode_fkps($_POST["code_fkps"]);

                    $mapper->save($preinscription);

          
          
          for($i = 0; $i < count($_POST['code_banque']); $i++){
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
          
$cb_compteur = $cb_mapper->findConuter() + 1;         
          
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre(NULL)
                   ->setCode_membre_morale(NULL)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i])
                               ->setId_preinscription($compteur)
                   ->setId_preinscription_morale(NULL)
                 ;
                            $cb_mapper->save($cb);
                    }

/*          */          
                    
                      
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $_POST["portable_membre"], "Vous venez de faire une preinscription PP. Vous allez recevoir une confirmation dans quelques minutes");

$mobilekacm = Util_Utils::getParametre('mobile', 'kacm');
$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSms($compteur, $mobilekacm, "Une preinscription PP est faite. Membre: ".$_POST['nom_membre']." ".$_POST['prenom_membre'].", Portable: ".$_POST['portable_membre']);

      $this->view->error = "Pré-inscription bien effectuée ...";
    //$this->_redirect('/');
    } else {  $this->view->error = "Vérifier bien les codes SMS ...";  } 
    } else {  $this->view->error = "Champs * obligatoire ...";  } 
    }
    
    }


    public function enrolementpmsmsAction()
    {
        /* page index/enrolementpmsms - Mise sur chaine avec Code SMS */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
        
  
    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if (isset($_POST['code_fs']) && $_POST['code_fs']!="" && isset($_POST['code_fl']) && $_POST['code_fl']!="" && isset($_POST['code_type_acteur']) && $_POST['code_type_acteur']!="" && isset($_POST['raison_sociale']) && $_POST['raison_sociale']!="" && isset($_POST['num_registre_membre']) && $_POST['num_registre_membre']!="" && isset($_POST['code_statut']) && $_POST['code_statut']!="" && isset($_POST['code_rep']) && $_POST['code_rep']!="" && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="") {
// && isset($_POST['code_fkps']) && $_POST['code_fkps']!=""     

$offres_mapper = new Application_Model_EuAppeloffresMapper();
$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
$agrement_mapper = new Application_Model_EuAgrementMapper();
$licence_mapper = new Application_Model_EuLicenceMapper();

if(
$smsmoneyFS = $smsmoneyM->findByCreditCode9($_POST['code_fs'], "FS") && 
$smsmoneyFL = $smsmoneyM->findByCreditCode9($_POST['code_fl'], "FL") && 
(($_POST['code_fkps']=="") || (isset($_POST['code_fkps']) && $_POST['code_fkps']!="" && $smsmoneyFKPS = $smsmoneyM->findByCreditCode9($_POST['code_fkps'], "FCPS"))) && 
(
(isset($_POST["numero_contrat"]) && $_POST["numero_contrat"] != "" && $trouveof = $offres_mapper->findoffres($_POST["numero_contrat"])) || 
(isset($_POST["numero_licence"]) && $_POST["numero_licence"] != "" && $trouvel = $licence_mapper->findlicence($_POST["numero_licence"])) || 
($trouveagrementfiliere = $agrement_mapper->findagrementfiliere($_POST["numero_agrement_filiere"]) && 
$trouveagrementacnev = $agrement_mapper->findagrementacnev($_POST["numero_agrement_acnev"]) && 
$trouveagrementtechno = $agrement_mapper->findagrementtechno($_POST["numero_agrement_technopole"]))
)
){
//$smsmoneyFKPS = $smsmoneyM->findByCreditCode9($_POST['code_fkps'], "FCPS") && 

            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;

$preinsc_mapper = new Application_Model_EuPreinscriptionMoraleMapper();
$compteur = $preinsc_mapper->findConuter() + 1;         
          
                        $preinscriptionmorale = new Application_Model_EuPreinscriptionMorale();
                        $mapper = new Application_Model_EuPreinscriptionMoraleMapper();
            
                        $preinscriptionmorale->setId_preinscription_morale($compteur)
                               ->setCode_type_acteur($_POST["code_type_acteur"])
                               ->setCode_statut($_POST["code_statut"])
                               ->setRaison_sociale($_POST["raison_sociale"])
                 ->setId_pays($_POST["id_pays"])
                               ->setNum_registre_membre($_POST["num_registre_membre"])
                               ->setDomaine_activite($_POST["domaine_activite"])
                               ->setSite_web($_POST["site_web"])
                               ->setQuartier_membre($_POST["quartier_membre"])
                               ->setVille_membre($_POST["ville_membre"])
                               ->setCategorie_membre($_POST["categorie_membre"])
                               ->setBp_membre($_POST["bp_membre"])
                               ->setTel_membre($_POST["tel_membre"])
                               ->setEmail_membre($_POST["email_membre"])
                               ->setPortable_membre($_POST["portable_membre"])
                               ->setHeure_inscription($date_idd->toString('HH:mm:ss'))
                               ->setDate_inscription($date_idd->toString('yyyy-MM-dd'))
                               ->setCode_rep($_POST["code_rep"])
                ->setCode_membre_morale(NULL)
                ->setNumero_contrat($_POST["numero_contrat"])
                ->setNumero_agrement_filiere($_POST["numero_agrement_filiere"])
                ->setNumero_agrement_acnev($_POST["numero_agrement_acnev"])
                ->setNumero_agrement_technopole($_POST["numero_agrement_technopole"])
                 ->setCode_fs($_POST["code_fs"])
                 ->setCode_fl($_POST["code_fl"])
                ->setCode_fkps($_POST["code_fkps"])
                ;
                        $mapper->save($preinscriptionmorale);/**/

          for($i = 0; $i < count($_POST['code_banque']); $i++){
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
          
$cb_compteur = $cb_mapper->findConuter() + 1;         
          
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre(NULL)
                   ->setCode_membre_morale(NULL)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i])
                               ->setId_preinscription(NULL)
                   ->setId_preinscription_morale($compteur)
                 ;
                            $cb_mapper->save($cb);
                    }

/**/                    
                    
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $_POST["portable_membre"], "Vous venez de faire une preinscription PM. Vous allez recevoir une confirmation dans quelques minutes.");

$mobilekacm = Util_Utils::getParametre('mobile', 'kacm');
$compteur = Util_Utils::findConuter() + 1;
//Util_Utils::addSms($compteur, $mobilekacm, "Une preinscription PM est faite. Membre Moral: ".$_POST['raison_sociale'].", Domaine:".$_POST['domaine_activite'].", Portable: ".$_POST['portable_membre']);
                      
      $this->view->error = "Pré-inscription bien effectuée ...";
    //$this->_redirect('/');
    } else {  $this->view->error = "Vérifier bien les codes SMS et les numéros ...";  } 
    } else {  $this->view->error = "Champs * obligatoire ...";  } 
    }
    

    }



    public function enrolementmaisonsmsAction()
    {
        /* page index/enrolementmaisonsms - Mise sur chaine maison avec Code SMS */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');

    
        $code_agence = '001001001001';
        $code = '';
$code_membre_acnev = "0010010010010000001M";//$user->code_membre
    
    $parametreM = new Application_Model_EuParametresMapper();
    $parametre = new Application_Model_EuParametres();
    $parametreM->find('FS', 'valeur', $parametre);

        $val_fs = $parametre->montant;
        $this->view->fs = $parametre->montant;

    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
      
            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
            $code_sms = $_POST["code_sms"];
                $frais_identification = trim($_POST["frais_identification"]);
            $mode_reg = $_POST["reglement_membre"];
            $membre_reg = $_POST["membre_reg"];
            $code_caps = $_POST["code_caps"];
      
    
      
    $parametre2M = new Application_Model_EuParametresMapper();
    $parametre2 = new Application_Model_EuParametres();
    $parametre2M->find('FL', 'valeur', $parametre2);
    $prix = $parametre2->montant;
    
    $table = new Application_Model_DbTable_EuPrixCarte();
        $select = $table->select()->where('id_prix_carte = ?', 5);
        $prixcarte = $table->fetchRow($select);
        $carte = $prixcarte->prix_carte;
      
    $parametreM = new Application_Model_EuParametresMapper();
    $parametre = new Application_Model_EuParametres();
    $parametreM->find('FS', 'valeur', $parametre);

         $fs = $parametre->montant;

            if ($mode_reg == 'N') {
                $code_sms = $_POST["creditcode"];
            } else {
                $code_sms = '';
            }
      //$code_sms = $_POST["creditcode"];
          $sms_mapper = new Application_Model_EuSmsmoneyMapper();
                    $sms = $sms_mapper->findByCreditCode($code_sms);
          
if ($sms->getCreditAmount() == ($fs + $prix + $carte)){
          
        $cm_map = new Application_Model_EuCompteMapper();
                $_compte = new Application_Model_EuCompte();

                        //insertion dans la table membremorale des information du nouveau membre
                        $membre = new Application_Model_EuMembreMorale();
                        $mapper = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == NULL) {
                            $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
                        $membre->setCode_membre_morale($code)
                               ->setCode_type_acteur($_POST["type_acteur"])
                               ->setCode_statut($_POST["statut_juridique"])
                               ->setRaison_sociale(htmlentities (addslashes (trim ($_POST["design"]))))
                 ->setId_pays($_POST["id_pays"])
                               ->setNum_registre_membre($_POST["numero"])
                               ->setDomaine_activite(htmlentities (addslashes (trim ("Immobilière"))))
                               ->setSite_web(htmlentities (addslashes (trim ($_POST["site_web"]))))
                               ->setQuartier_membre(htmlentities (addslashes (trim ($_POST["quartier_membre"]))))
                               ->setVille_membre(htmlentities (addslashes (trim ($_POST["ville_membre"]))))
                               ->setBp_membre($_POST["bp_membre"])
                               ->setTel_membre($_POST["tel_membre"])
                               ->setEmail_membre($_POST["email_membre"])
                               ->setPortable_membre($_POST["portable_membre"])
                               ->setId_utilisateur(NULL)//$user->id_utilisateur
                               ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                               ->setDate_identification($date_idd->toString('yyyy-MM-dd'))
                               ->setCode_agence($code_agence)
                               ->setCodesecret($_POST["codesecret"])
                 ->setAuto_enroler('O')
                 ->setEtat_membre('N');
                        $mapper->save($membre);



                      // Enrégistrement du proprietaire dans la table  eu_proprietaire
               $proprio_mapper = new Application_Model_EuProprietaireMapper();
                           $proprio = new Application_Model_EuProprietaire();
               $proprio = $proprio_mapper->findProprio($_POST['proprio']);
                          if(!$proprio){
              $compteur_proprietaire = $proprio_mapper->findConuter() + 1;
               $proprio->setId_proprietaire($compteur_proprietaire)
                  ->setCode_membre_pro($_POST['proprio'])
                                ->setCode_membre_ag($code_membre_acnev)
                  ->setDate_declaration($date_idd->toString('yyyy-MM-dd'))
                                ->setId_utilisateur(NULL)
                                ->setNbre_maison(1);
                           $proprio_mapper->save($proprio);
               }else{
              $proprio->setNbre_maison($proprio->getNbre_maison() + 1);
                           $proprio_mapper->update($proprio);
                  }


                      // Enrégistrement du representant dans la table  eu_representation
               $rep_mapper = new Application_Model_EuRepresentationMapper();
                           $rep = new Application_Model_EuRepresentation();
               $rep->setCode_membre_morale($code)
                               ->setCode_membre($_POST['proprio'])
                               ->setTitre("Représentant");
                           $rep_mapper->save($rep);
               



                        $maison = new Application_Model_EuMaison();
            $mapper_m = new Application_Model_EuMaisonMapper();
                        $compteur_maison = $mapper_m->findConuter() + 1;
                        
                        $maison->setId_maison($compteur_maison);
                        $maison->setDesignation($_POST["design"]);
                        $maison->setId_proprietaire($proprio->getId_proprietaire());
                        $maison->setCode_membre($code);
                        $maison->setType_maison($_POST["type_maison"]);
                        if(isset($_POST['eau'])) {
                          $maison->setEau($_POST["eau"]);
              $maison->setFrais_eau($_POST["frais_eau"]);
                        }
                        else {
                            $maison->setEau(0);
                            $maison->setFrais_eau(0);             
                        }
                        $maison->setDate_enregistrement($date_idd->toString('yyyy-MM-dd'));
                            if(isset($_POST['elect'])) {
                            $maison->setElectrifier($_POST['elect']);
              $maison->setFrais_electricite($_POST["frais_elect"]);
                        }
                        else {
                        $maison->setElectrifier(0);
                         $maison->setFrais_electricite(0);            
                        }
                        if(isset($_POST['wd'])) {
                          $maison->setWc_douche($_POST['wd']);
              $maison->setFrais_vidange($_POST["frais_vidange"]);
                        }
                        else {
                            $maison->setWc_douche(0);
                            $maison->setFrais_vidange(0);             
                        }
            if(isset($_POST['tel'])) {
              $maison->setFrais_tel($_POST["frais_tel"]);
                        }
                        else {
                            $maison->setFrais_tel(0);             
                        }
            if($_POST['taxe'] != '') {
              $maison->setTaxe($_POST["taxe"]);
                        }
                        else {
                            $maison->setTaxe(0);              
                        }
                        if($_POST['numero'] != '') {
                             $maison->setNum_maison($_POST["numero"]);              
                        }
            else {
                 $maison->setNum_maison(NULL);
            }
                        $maison->setStatut(0);
                        $maison->setDesc_maison($_POST["desc"]);
                        $maison->setRue($_POST["rue"]);
                        $maison->setNum_police_electricite($_POST["num_police"]);
                        $maison->setNum_compteur_eau($_POST["num_compteur"]);
                        $maison->setNum_ligne_tel($_POST["num_ligne"]);
                        $maison->setId_utilisateur(NULL);//$user->id_utilisateur
                        $maison->setId_quartier($_POST["quartier_membre"]);
                            
                        $mapper_m->save($maison);
                            



                        //insertion des frais d'identification dans la table placement
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteur = $mapper_op->findConuter() + 1;
                        
        $place_op = new Application_Model_EuOperation();
                $place_op->setId_operation($compteur)
                        ->setDate_op($date_idd->toString('yyyy-MM-dd'))
                        ->setMontant_op($frais_identification)
                        ->setCode_membre(NULL)
                        ->setCode_membre_morale($code)
                        ->setHeure_op($date_idd->toString('HH:mm:ss'))
                        ->setCode_produit('FS')
                        ->setId_utilisateur(NULL)
                        ->setLib_op('Auto-enrôlement')
                        ->setCode_cat('TFS')
                        ->setType_op('AERL');
                $mapper_op->save($place_op);

                        //Util_Utils::createCompte('NB-TPAGCI-' . $code, 'TPAGCI', 'TPAGCI', 0, $code, 'NB', $date_id, 0);
    
                      

        
                //Creation du FS
                $tab_fs = new Application_Model_DbTable_EuFs();
                $fs_model = new Application_Model_EuFs();
                $fs_model->setCode_membre_morale($code)
                 ->setCode_membre(NULL)
                         ->setCode_fs('FS-' . $code)
                         ->setCreditcode($sms->getCreditCode())//
                         ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                         ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                         ->setId_utilisateur(NULL)//$user->id_utilisateur
                         ->setMont_fs($frais_identification);
                $tab_fs->insert($fs_model->toArray());

        
        
        $compteur=Util_Utils::findConuter() + 1;
                Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le réseau MCNP! Votre numéro de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                     //return $this->_helper->redirector('morale', 'eu-membre', NULL, array('controller' => 'eu-membre', 'action' => 'morale'));


/////////////////////////////////licence////////////////////////////////////////////////          
          
            $code_membre = $code;
            $code_dev = 'XOF';
      $code_sms = '';
      
    $parametre2M = new Application_Model_EuParametresMapper();
    $parametre2 = new Application_Model_EuParametres();
    $parametre2M->find('FL', 'valeur', $parametre2);

            $prix = $parametre2->montant;

          $tfl = new Application_Model_DbTable_EuFl();
                $fl = new Application_Model_EuFl();
                $code_fl = 'FL-' . $code_membre;
                /*$result = $tfl->find($code_fl);
                if (count($result) > 0) {
                    $this->view->message = "Vous avez déja souscrit au frais de licence!!! ";
                    return;
                }*/
                $cm_map = new Application_Model_EuCompteMapper();
                   
                 $mapper_op = new Application_Model_EuOperationMapper();
                                $compteur = $mapper_op->findConuter() + 1;
                                $date_deb = new Zend_Date(Zend_Date::ISO_8601);
        
        $place_op = new Application_Model_EuOperation();
                $place_op->setId_operation($compteur)
                        ->setDate_op($date_deb->toString('yyyy-MM-dd'))
                        ->setMontant_op($prix)
                        ->setCode_membre(NULL)
                        ->setCode_membre_morale($code_membre)
                        ->setHeure_op($date_deb->toString('HH:mm:ss'))
                        ->setCode_produit(NULL)
                        ->setId_utilisateur(NULL)
                        ->setLib_op('Frais de licences')
                        ->setCode_cat(NULL)
                        ->setType_op('FL');
                $mapper_op->save($place_op);


          $tfl = new Application_Model_DbTable_EuFl();
                $fl = new Application_Model_EuFl();
                                $fl->setCode_fl($code_fl)
                                        ->setCode_membre_morale($code_membre)
                                        ->setMont_fl($prix)
                                        ->setDate_fl($date_deb->toString('yyyy-MM-dd'))
                                        ->setHeure_fl($date_deb->toString('HH:mm:ss'))
                                        ->setId_utilisateur(NULL)//$user->id_utilisateur
                                        ->setCreditcode($sms->getCreditCode());//
                                $tfl->insert($fl->toArray());

                                //Mise à jour du compte général FGFL
                                $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                                $cg_fgfn = new Application_Model_EuCompteGeneral();
                                $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                                if ($result3) {
                                    $cg_fgfn->setSolde($cg_fgfn->getSolde() + $prix);
                                    $cg_mapper->update($cg_fgfn);
                                } else {
                                    $cg_fgfn->setCode_compte('FL')
                                            ->setIntitule('Frais de licence')
                                            ->setService('E')
                                            ->setCode_type_compte('NN')
                                            ->setSolde($prix);
                                    $cg_mapper->save($cg_fgfn);
                                }
                

/////////////////////////////////carte///////////////////////////////////////////         
          
           $date = Zend_Date::now();
               $carte = new Application_Model_EuCartes();
               $t_carte = new Application_Model_DbTable_EuCartes();
               $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
               $map_membre = new Application_Model_EuMembreMapper();
         $map_membreM = new Application_Model_EuMembreMoraleMapper();

              $membre = $code_membre;
      
               $table = new Application_Model_DbTable_EuPrixCarte();
        $select = $table->select()->where('id_prix_carte = ?', 5);
        $prixcarte = $table->fetchRow($select);
         $montant = $prixcarte->prix_carte;
                
          // vérification de la licence
                    $tfl = new Application_Model_DbTable_EuFl();
                    $code_fl = 'FL-' . $membre;
                    $result = $tfl->find($code_fl);
                             $somme = $somme + $montant;
            
            $cm_map = new Application_Model_EuCompteMapper();
                        $code_sms = '';

                                    $code_cat = "TPAGCI";
                  $code_cat_ts = "TSI";
                                    $type_carte = "NB";
                                    $type_membre = "M";
                                    $code_compte = $type_carte . '-' . $code_cat . '-' . $membre;
                  $code_compte_ts = $type_carte . '-' . $code_cat_ts . '-' . $membre;
                  
                                    $c_select = $t_carte->select();
                                    $c_select->where('code_membre like ?', $membre)
                                            ->where('code_cat like ?', $code_cat);
                                    $results = $t_carte->fetchAll($c_select);
                  
                                    $res = $map_compte->find($code_compte, $compte);
                                    if (!$res) {
                                        $compte->setCode_cat($code_cat)
                                                ->setCode_compte($code_compte)
                                                ->setCode_membre_morale($membre)
                                                ->setCode_type_compte($type_carte)
                                                ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setDesactiver(0)
                                                ->setLib_compte($code_cat)
                                                ->setSolde(0)
                                                ->setSource(NULL);
                                        $map_compte->save($compte);
                    
                    $compte->setCode_cat($code_cat)
                                                ->setCode_compte($code_compte_ts)
                                                ->setCode_membre_morale($membre)
                                                ->setCode_type_compte($type_carte)
                                                ->setDate_alloc($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setDesactiver(0)
                                                ->setLib_compte($code_cat)
                                                ->setSolde(0)
                                                ->setSource(NULL);
                                        $map_compte->save($compte);
                    
                                        $prix = $montant;
                                        $carte->setCode_cat($code_cat)
                                                ->setCode_membre($membre)
                                                ->setMont_carte($montant)
                                                ->setDate_demande($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                ->setLivrer(0)
                                                ->setCode_Compte($code_compte)
                                                ->setImprimer(0)
                                                ->setCardPrintedDate(NULL)
                                                ->setCardPrintedIDDate(0)
                                                ->setId_utilisateur(NULL);//$user->id_utilisateur
                                        $t_carte->insert($carte->toArray());
                                    } else {
                                        if ($compte->getCardPrintedDate() == '' || $compte->getCardPrintedIDDate() == 0) {
                                            $prix = $montant;
                                            $carte->setCode_cat($code_cat)
                                                    ->setCode_membre($membre)
                                                    ->setMont_carte($montant)
                                                    ->setDate_demande($date->toString('yyyy-MM-dd HH:mm:ss'))
                                                    ->setLivrer(0)
                                                    ->setImprimer(0)
                                                    ->setCardPrintedDate(NULL)
                                                    ->setCardPrintedIDDate(0)
                                                    ->setCode_Compte($code_compte)
                                                    ->setId_utilisateur(NULL);//$user->id_utilisateur
                                            $t_carte->insert($carte->toArray());
                                        }
                                    }
                
                                $mapper_op = new Application_Model_EuOperationMapper();
                                $compteur = $mapper_op->findConuter() + 1;
                
                $place_op = new Application_Model_EuOperation();
                $place_op->setId_operation($compteur)
                        ->setDate_op($date->toString('yyyy-MM-dd'))
                        ->setMontant_op($montant)
                        ->setCode_membre(NULL)
                        ->setCode_membre_morale($membre)
                        ->setHeure_op($date->toString('HH:mm:ss'))
                        ->setCode_produit(NULL)
                        ->setId_utilisateur(NULL)
                        ->setLib_op('Frais de CPS')
                        ->setCode_cat(NULL)
                        ->setType_op('CPS');
                $mapper_op->save($place_op);

                    
/////////////////////////////////////////////////////////// 
            $compte_transfert = $sms->getFromAccount();
                        $transfert = explode('-', $compte_transfert);
                        $membre_transfert = $transfert[2];
            $sms->setDestAccount_Consumed('NB-TFS-' . $membre)
                            ->setDateTimeconsumed($date->toString('yyyy-MM-dd HH:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date->toString('yyyy-MM-dd')));
            $sms_mapper->update($sms);

$this->view->message = 'Enrôlement Maison bien effectué';

} else {
$this->view->message = 'Le code SMS [' . $code_sms . ']  est  invalide !!!';
}
                      
//$this->_redirect('/index');


        }



    }


    public function pagemenuesmcAction()
    {
        /* page index/pagemenuesmc - Page ESMC */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    

        $id = (int) $this->_request->getParam('id');
    if($id > 0){
        $menu = new Application_Model_EuMenu();
        $menuM = new Application_Model_EuMenuMapper();
        $menuM->find($id, $menu);
    $this->view->menu = $menu;
    } else {  $this->_redirect('/');  } 
    }



    public function pagemenuceuAction()
    {
        /* page index/pagemenuceu - Page CEU */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicceu');
    

        $id = (int) $this->_request->getParam('id');
    if($id > 0){
        $menu = new Application_Model_EuMenu();
        $menuM = new Application_Model_EuMenuMapper();
        $menuM->find($id, $menu);
    $this->view->menu = $menu;
    } else {  $this->_redirect('/');  } 
    }


    public function pagemenumcnpAction()
    {
        /* page index/pagemenumcnp - Page MCNP */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

        $id = (int) $this->_request->getParam('id');
    if($id > 0){
        $menu = new Application_Model_EuMenu();
        $menuM = new Application_Model_EuMenuMapper();
        $menuM->find($id, $menu);
    $this->view->menu = $menu;
    } else {  $this->_redirect('/');  } 
    }


    public function pageesmcAction()
    {
        /* page index/pageesmc - Page ESMC */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    

        $id = (int) $this->_request->getParam('id');
    if($id > 0){
        $page = new Application_Model_EuPage();
        $pageM = new Application_Model_EuPageMapper();
        $pageM->find2($id, $page);
    $this->view->page = $page;
    } else {  $this->_redirect('/');  } 
    }


    public function pageceuAction()
    {
        /* page index/pageceu - Page CEU/ReDeMaRe */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicceu');
    

        $id = (int) $this->_request->getParam('id');
    if($id > 0){
        $page = new Application_Model_EuPage();
        $pageM = new Application_Model_EuPageMapper();
        $pageM->find2($id, $page);
    $this->view->page = $page;
    } else {  $this->_redirect('/');  } 
    }

    public function pagemcnpAction()
    {
        /* page index/pagemcn - Page MCNP */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

        $id = (int) $this->_request->getParam('id');
    if($id > 0){
        $page = new Application_Model_EuPage();
        $pageM = new Application_Model_EuPageMapper();
        $pageM->find2($id, $page);
    $this->view->page = $page;
    } else {  $this->_redirect('/');  } 
    }





    public function addcontactesmcAction()
    {
         /* page index/addcontact - Page Contact ESMC */

   //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
           $date = Zend_Date::now();
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['contact_nom']) && $_POST['contact_nom']!="" && isset($_POST['contact_email']) && $_POST['contact_email']!="" && isset($_POST['contact_sujet']) && $_POST['contact_sujet']!="" && isset($_POST['contact_message']) && $_POST['contact_message']!="" && isset($_POST['calcul']) && $_POST['calcul']=="2") {
          
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuContact();
        $ma = new Application_Model_EuContactMapper();
      
            $compteur = $ma->findConuter() + 1;
            $a->setContact_id($compteur);
            $a->setContact_nom($_POST['contact_nom']);
            $a->setContact_email($_POST['contact_email']);
            $a->setContact_sujet($_POST['contact_sujet']);
            $a->setContact_message($_POST['contact_message']);
            $a->setContact_type("ESMC");
            $a->setContact_date($date->toString('yyyy-MM-dd'));
            $a->setTraiter(0);
            $ma->save($a);


                    
$mobilecontactesmc = Util_Utils::getParametre('mobile', 'contactesmc');
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $mobilecontactesmc, "Un message vient d'être laissé dans la rubrique Contacts ESMC. Interface: ESMC. Nom: ".$_POST['contact_nom'].". Sujet: ".$_POST['contact_sujet']);
                      

      $this->view->error = "Message bien envoyé ...";
    //$this->_redirect('/');
    } else {  $this->view->error = "Champs * obligatoire ...";  } 
    }
    

    }

    public function addcontactceuAction()
    {
         /* page index/addcontactceu - Page Contact CEU/ReDeMaRe */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicceu');
    
           $date = Zend_Date::now();

  
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['contact_nom']) && $_POST['contact_nom']!="" && isset($_POST['contact_email']) && $_POST['contact_email']!="" && isset($_POST['contact_sujet']) && $_POST['contact_sujet']!="" && isset($_POST['contact_message']) && $_POST['contact_message']!="" && isset($_POST['calcul']) && $_POST['calcul']=="2") {
          
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuContact();
        $ma = new Application_Model_EuContactMapper();
      
            $compteur = $ma->findConuter() + 1;
            $a->setContact_id($compteur);
            $a->setContact_nom($_POST['contact_nom']);
            $a->setContact_email($_POST['contact_email']);
            $a->setContact_sujet($_POST['contact_sujet']);
            $a->setContact_message($_POST['contact_message']);
            $a->setContact_type("CEU/ReDeMaRe");
            $a->setContact_date($date->toString('yyyy-MM-dd'));
            $a->setTraiter(0);
            $ma->save($a);


                    
$mobilecontactceu = Util_Utils::getParametre('mobile', 'contactceu');
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $mobilecontactceu, "Un message vient d'être laissé dans la rubrique Contacts CEU/ReDeMaRe. Interface: CEU/ReDeMaRe. Nom: ".$_POST['contact_nom'].". Sujet: ".$_POST['contact_sujet']);
                      

      $this->view->error = "Message bien envoyé ...";
    //$this->_redirect('/');
    } else {  $this->view->error = "Champs * obligatoire ...";  } 
    }
    

    }

    public function addcontactmcnpAction()
    {
         /* page index/addcontactmcnp - Page Contact MCNP */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
           $date = Zend_Date::now();

  
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['contact_nom']) && $_POST['contact_nom']!="" && isset($_POST['contact_email']) && $_POST['contact_email']!="" && isset($_POST['contact_sujet']) && $_POST['contact_sujet']!="" && isset($_POST['contact_message']) && $_POST['contact_message']!="" && isset($_POST['calcul']) && $_POST['calcul']=="2") {
          
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuContact();
        $ma = new Application_Model_EuContactMapper();
      
            $compteur = $ma->findConuter() + 1;
            $a->setContact_id($compteur);
            $a->setContact_nom($_POST['contact_nom']);
            $a->setContact_email($_POST['contact_email']);
            $a->setContact_sujet($_POST['contact_sujet']);
            $a->setContact_message($_POST['contact_message']);
            $a->setContact_type("MCNP");
            $a->setContact_date($date->toString('yyyy-MM-dd'));
            $a->setTraiter(0);
            $ma->save($a);


                    
$mobilecontactmcnp = Util_Utils::getParametre('mobile', 'contactmcnp');
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $mobilecontactmcnp, "Un message vient d'être laissé dans la rubrique Contacts MCNP. Interface: MCNP. Nom: ".$_POST['contact_nom'].". Sujet: ".$_POST['contact_sujet']);
                      

      $this->view->error = "Message bien envoyé ...";
    //$this->_redirect('/');
    } else {  $this->view->error = "Champs * obligatoire ...";  } 
    }
    

    }
  


    public function videoesmcAction()
    {
         /* page index/videoesmc - Page Video ESMC */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    

        $id = (string) $this->_request->getParam('id');
    if($id > 0){
        $video = new Application_Model_EuVideo();
        $videoM = new Application_Model_EuVideoMapper();
        $videoM->find($id, $video);
    $this->view->video = $video;
    } else {  $this->_redirect('/');  } 
    }

    public function videoceuAction()
    {
        /* page index/videoceu - Page Video CEU/ReDeMaRe */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicceu');
    

        $id = (string) $this->_request->getParam('id');
    if($id > 0){
        $video = new Application_Model_EuVideo();
        $videoM = new Application_Model_EuVideoMapper();
        $videoM->find($id, $video);
    $this->view->video = $video;
    } else {  $this->_redirect('/');  } 
    }

    public function videomcnpAction()
    {
        /* page index/videomcnp - Page Video MCNP */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

        $id = (string) $this->_request->getParam('id');
    if($id > 0){
        $video = new Application_Model_EuVideo();
        $videoM = new Application_Model_EuVideoMapper();
        $videoM->find($id, $video);
    $this->view->video = $video;
    } else {  $this->_redirect('/');  } 
    }

    public function videolisteesmcAction()
    {
        /* page index/videolisteesmc - Page Liste Video ESMC */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
        $video = new Application_Model_EuVideoMapper();
        $this->view->entries = $video->fetchAll3("ESMC");

    }

    public function videolisteceuAction()
    {
        /* page index/videolisteceu - Page Liste Video CEU/ReDeMaRe */

     //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicceu');
    
        $video = new Application_Model_EuVideoMapper();
        $this->view->entries = $video->fetchAll3("CEU/ReDeMaRe");

    }

    public function videolistemcnpAction()
    {
        /* page index/videolistemcnp - Page Liste Video MCNP */

     //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $video = new Application_Model_EuVideoMapper();
        $this->view->entries = $video->fetchAll3("MCNP");

    }


    public function addcandidatcmfhAction()
    {
        /* page index/addcandidatcmfh - Ajout de la candidature CMFH */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['id_type_candidat']) && $_POST['id_type_candidat']!="" && isset($_POST['candidat_document']) && $_POST['candidat_document']!="" && isset($_POST['candidat_nom']) && $_POST['candidat_nom']!="" && isset($_POST['candidat_poste']) && $_POST['candidat_poste']!="" && isset($_POST['candidat_datenaiss']) && $_POST['candidat_datenaiss']!="" && isset($_POST['candidat_nationalite']) && $_POST['candidat_nationalite']!="" && isset($_POST['candidat_education']) && $_POST['candidat_education']!="" && isset($_POST['candidat_pays']) && $_POST['candidat_pays']!="" && isset($_POST['candidat_langue']) && $_POST['candidat_langue']!="" && isset($_POST['candidat_attestation']) && $_POST['candidat_attestation']!="" && isset($_POST['candidat_date']) && $_POST['candidat_date']!="") {
    
      
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $candidat = new Application_Model_EuCandidat();
        $candidat_mapper = new Application_Model_EuCandidatMapper();
      
            $compteur_candidat = $candidat_mapper->findConuter() + 1;
            $candidat->setCandidat_id($compteur_candidat);
            $candidat->setId_type_candidat($_POST['id_type_candidat']);
            $candidat->setCandidat_document($_POST['candidat_document']);
            $candidat->setCandidat_nom($_POST['candidat_nom']);
            $candidat->setCandidat_poste($_POST['candidat_poste']);
            $candidat->setCandidat_datenaiss($_POST['candidat_datenaiss']);
            $candidat->setCandidat_nationalite($_POST['candidat_nationalite']);
            $candidat->setCandidat_education($_POST['candidat_education']);
            $candidat->setCandidat_affiliation($_POST['candidat_affiliation']);
            $candidat->setCandidat_formation($_POST['candidat_formation']);
            $candidat->setCandidat_pays($_POST['candidat_pays']);
            $candidat->setCandidat_langue($_POST['candidat_langue']);
            $candidat->setCandidat_experience($_POST['candidat_experience']);
            $candidat->setCandidat_tache($_POST['candidat_tache']);
            $candidat->setCandidat_competence($_POST['candidat_competence']);
            $candidat->setCandidat_attestation($_POST['candidat_attestation']);
            $candidat->setCandidat_date($_POST['candidat_date']);
            $candidat->setPublier(0);
            $candidat_mapper->save($candidat);
      
	  if($_POST['id_type_candidat'] == 7){$cmfh = "FC";}else{$cmfh = "CMFH";}
	  
	  
$mobilecandidatcmfh = Util_Utils::getParametre('mobile', 'candidatcmfh');
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $mobilecandidatcmfh, "Une candidature de ".$cmfh." vient d\'être faite. Nom du candidat: ".$_POST['candidat_nom'].". Date: ".$_POST['candidat_date']);
                      
$this->view->error = "Opération bien effectuée...";

/*if($_POST['id_type_candidat'] != 7){
    $this->_redirect('/index/addquittancecmfh/id/'.$compteur_candidat);
}*/
    } else {  $this->view->error = "Champs * obligatoire ..."; 
     
            $type = (int)$this->_request->getParam('type');
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $document = new Application_Model_EuDocument();
        $document_mapper = new Application_Model_EuDocumentMapper();
    $document_mapper->find($id, $document);
    $this->view->document = $document;
    $this->view->type = $type;
            }
  }
       
  } else {

            $type = (int)$this->_request->getParam('type');
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $document = new Application_Model_EuDocument();
        $document_mapper = new Application_Model_EuDocumentMapper();
    $document_mapper->find($id, $document);
    $this->view->document = $document;
    $this->view->type = $type;
            }
  }
  

  }


    public function addquittancecmfhAction()
    {
        /* page index/addquittancecmfh - Ajout de la quittance CMFH/CAPS */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['quittance_nom']) && $_POST['quittance_nom']!="" && isset($_POST['quittance_code']) && $_POST['quittance_code']!="" && isset($_POST['quittance_numero']) && $_POST['quittance_numero']!="" && isset($_POST['quittance_type']) && $_POST['quittance_type']!="" && isset($_POST['quittance_cel']) && $_POST['quittance_cel']!="" && isset($_POST['quittance_banque']) && $_POST['quittance_banque']!="" && isset($_POST['quittance_code_membre']) && $_POST['quittance_code_membre']!="") {
    

      
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
      
        $quittance = new Application_Model_EuQuittance();
        $quittance_mapper = new Application_Model_EuQuittanceMapper();
      
            $compteur_quittance = $quittance_mapper->findConuter() + 1;
            $quittance->setQuittance_id($compteur_quittance);
            $quittance->setQuittance_code($_POST['quittance_code']);
            $quittance->setQuittance_nom($_POST['quittance_nom']);
            $quittance->setQuittance_numero($_POST['quittance_numero']);
            $quittance->setQuittance_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $quittance->setQuittance_type($_POST['quittance_type']);
            $quittance->setQuittance_banque($_POST['quittance_banque']);
            $quittance->setQuittance_cel($_POST['quittance_cel']);
            $quittance->setQuittance_candidat($_POST['quittance_candidat']);
            $quittance->setQuittance_code_membre($_POST['quittance_code_membre']);
            $quittance->setPublier(0);
            $quittance_mapper->save($quittance);



$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $_POST["quittance_cel"], "Vous venez de vous inscrire pour le programme de CMFH/CAPS/GAC. Vous allez recevoir une confirmation et vos accès dans quelques minutes");

$mobilequittance = Util_Utils::getParametre('mobile', 'quittance');
$compteur = Util_Utils::findConuter() + 1;
Util_Utils::addSms($compteur, $mobilequittance, "Un CMFH/CAPS/GAC vient de s\'inscrire sur la plateforme. Quittance: ".$_POST['quittance_code'].", Acheteur: ".$_POST['quittance_nom'].", Reçu de banque: ".$_POST['quittance_numero'].", Banque: ".$_POST['quittance_banque'].", Nbre de code achetés: ".$_POST['quittance_type']);

$this->view->error = "Opération bien réussie. Vous serez contacté dans quelques instants.";

    //$this->_redirect('/index');
    } else {  $this->view->error = "Champs * obligatoire ..."; 
     
            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $candidat = new Application_Model_EuCandidat();
        $candidat_mapper = new Application_Model_EuCandidatMapper();
    $candidat_mapper->find($id, $candidat);
    $this->view->candidat = $candidat;
            }
  }
       
  } else {

            $id = (int)$this->_request->getParam('id');
            if ($id != 0) {
        $candidat = new Application_Model_EuCandidat();
        $candidat_mapper = new Application_Model_EuCandidatMapper();
    $candidat_mapper->find($id, $candidat);
    $this->view->candidat = $candidat;
            }
  }

  }

  






    public function fichierlisteesmcAction()
    {
        /* page index/fichierlisteesmc - Liste des fichiers */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
        $fichier = new Application_Model_EuFichierMapper();
        $this->view->entries = $fichier->fetchAll2();

    }


    public function actualitelisteesmcAction()
    {
        /* page index/actualitelisteesmc - Liste des actualités */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    
        $actualite = new Application_Model_EuActualiteMapper();
        $this->view->entries = $actualite->fetchAll2();

    }




    public function actualiteesmcAction()
    {
        /* page index/actualiteesmc - Détail actualité */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmc');
    

        $id = (string) $this->_request->getParam('id');
    if($id > 0){
        $actualite = new Application_Model_EuActualite();
        $actualiteM = new Application_Model_EuActualiteMapper();
        $actualiteM->find($id, $actualite);
    $this->view->actualite = $actualite;
    } else {  $this->_redirect('/');  } 
    }




    public function centreenrolementAction()
    {
        /* page index/centreenrolement - Liste des centres d'enrolements */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $centre = new Application_Model_EuCentreMapper();
        $this->view->entries = $centre->fetchAll2();

    }




    public function loginAction()
    {
        /* page index/login - Authentification ZPPE */

   $sessionzppe = new Zend_Session_Namespace('zppe');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['login']) && $_POST['login']!="" && isset($_POST['pwd']) && $_POST['pwd']!=""){

  $euzppe = new Application_Model_DbTable_EuZppe();
  $select = $euzppe->select()->where('zppe_login = ?', $_POST['login'])
                  ->where('zppe_password = ?', md5($_POST['pwd']))
                ->where('publier = ?', 1);
  $rowseuzppe = $euzppe->fetchRow($select);
if (count($rowseuzppe)>0){
         $sessionzppe->zppe_id = $rowseuzppe->zppe_id;
         $sessionzppe->zppe_login = $rowseuzppe->zppe_login;
         $sessionzppe->zppe_password = $rowseuzppe->zppe_password;
         $sessionzppe->zppe_libelle = $rowseuzppe->zppe_libelle;
         $sessionzppe->zppe_resume = $rowseuzppe->zppe_resume;
         $sessionzppe->zppe_description = $rowseuzppe->zppe_description;
         $sessionzppe->zppe_portable = $rowseuzppe->zppe_portable;
         $sessionzppe->zppe_email = $rowseuzppe->zppe_email;
         $sessionzppe->zppe_vignette = $rowseuzppe->zppe_vignette;
         $sessionzppe->publier = $rowseuzppe->publier;
         

         $sessionzppe->errorlogin = "";
    $this->_redirect('/index/zppe');
  } else { $sessionzppe->errorlogin = "Login ou Mot de Passe Erroné"; }
    $this->_redirect('/index/login');
  } else { $sessionzppe->errorlogin = "Saisir Login et Mot de Passe"; } 
    $this->_redirect('/index/login');
  }

        $zppe = new Application_Model_EuZppeMapper();
        $this->view->entries = $zppe->fetchAll2();

    }
  
    function nocompteAction()
    {
  Zend_Session::destroy(true);
    $this->_redirect('/index/login');
    }


    public function zppeAction()
    {
        /* page index/zppe - Liste des ZPPEs */

     $sessionzppe = new Zend_Session_Namespace('zppe');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
  if (!isset($sessionzppe->zppe_login)) {$this->_redirect('/index/login');}

        $bon = new Application_Model_EuBonMapper();
        $this->view->entries = $bon->fetchAllByZppe($sessionzppe->zppe_id);

        $this->view->tabletri = 1;

    }




    public function listrecuAction()
    {
        /* page index/listrecu - Liste des reçus */

    $sessionzppe = new Zend_Session_Namespace('zppe');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
  if (!isset($sessionzppe->zppe_login)) {$this->_redirect('/index/login');}

        $recu = new Application_Model_EuRecuMapper();
        $this->view->entries = $recu->fetchAllByZppe($sessionzppe->zppe_id);

        $this->view->tabletri = 1;

    }




    public function addquestionreponseAction()
    {
        /* page index/addquestionreponse - Ajout de question reponse */

   $sessionzppe = new Zend_Session_Namespace('zppe');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    
        $question_reponse = new Application_Model_EuQuestionReponseMapper();
        $this->view->entries = $question_reponse->fetchAll2();

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['question_reponse_nom']) && $_POST['question_reponse_nom']!="" && isset($_POST['question_reponse_categorie']) && $_POST['question_reponse_categorie']!="" && isset($_POST['question_reponse_question']) && $_POST['question_reponse_question']!="") {
    
      
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
        $a = new Application_Model_EuQuestionReponse();
        $ma = new Application_Model_EuQuestionReponseMapper();
      
            $compteur = $ma->findConuter() + 1;
            $a->setQuestion_reponse_id($compteur);
            $a->setQuestion_reponse_categorie($_POST['question_reponse_categorie']);
            $a->setQuestion_reponse_question($_POST['question_reponse_question']);
            $a->setQuestion_reponse_nom($_POST['question_reponse_nom']);
            $a->setQuestion_reponse_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $a->setPublier($_POST['publier']);
            $ma->save($a);
      
$sessionzppe->errorlogin = "Opération bien effectuée. Veuillez patienter un instant. ...";
$sessionzppe->id = $compteur;
    $this->_redirect('/index/addquestionreponse');
    } else {  $this->view->error = "Champs * obligatoire ...";  } 
    }
    
    }




    public function enrolementsms2Action()
    {
        /* page index/enrolementsms2 - Enrolement avec Code SMS */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if (isset($_POST['code_fs']) && $_POST['code_fs']!="" && isset($_POST['code_fl']) && $_POST['code_fl']!="" && isset($_POST['nom_membre']) && $_POST['nom_membre']!="" && isset($_POST['sexe_membre']) && $_POST['sexe_membre']!="" && isset($_POST['nationalite_membre']) && $_POST['nationalite_membre']!="" && isset($_POST['sitfam_membre']) && $_POST['sitfam_membre']!="" && isset($_POST['prenom_membre']) && $_POST['prenom_membre']!="" && isset($_POST['date_nais_membre']) && $_POST['date_nais_membre']!="" && isset($_POST['lieu_nais_membre']) && $_POST['lieu_nais_membre']!="" && isset($_POST['nbr_enf_membre']) && $_POST['nbr_enf_membre']!="" && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" && isset($_POST['profession_membre']) && $_POST['profession_membre']!="" && isset($_POST['religion_membre']) && $_POST['religion_membre']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {
// && isset($_POST['code_fkps']) && $_POST['code_fkps']!=""     


$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
if($smsmoneyFS = $smsmoneyM->findByCreditCode9($_POST['code_fs'], "FS") && $smsmoneyFL = $smsmoneyM->findByCreditCode9($_POST['code_fl'], "FL") && (($_POST['code_fkps']=="") || (isset($_POST['code_fkps']) && $_POST['code_fkps']!="" && $smsmoneyFKPS = $smsmoneyM->findByCreditCode9($_POST['code_fkps'], "FCPS")))){
// && $smsmoneyFKPS = $smsmoneyM->findByCreditCode9($_POST['code_fkps'], "FCPS")
$code_agence = $_POST['code_agence'];
$code_zone = substr($_POST['code_agence'], 0, 3);
$id_pays = $_POST['id_pays'];
         $table = new Application_Model_DbTable_EuActeur();
         $selection = $table->select();
         $selection->where('code_membre LIKE ?',$code_agence.'%');
         $selection->where('type_acteur LIKE ?','gac_surveillance');
         $resultat = $table->fetchAll($selection);
         $trouvacteursur = $resultat->current();
         $code_acteur = $trouvacteursur->code_acteur;



         $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               $membre = new Application_Model_EuMembre();
               $mapper = new Application_Model_EuMembreMapper();
         $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
         $sms_mapper = new Application_Model_EuSmsmoneyMapper();
         $fs = Util_Utils::getParametre('FS','valeur');
         $mont_fl = Util_Utils::getParametre('FL','valeur');
         $mont_cps = Util_Utils::getParametre('FCPS','valeur');
           $tcartes = array();
         $tscartes = array();
         $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
         try {
            $code_fs = $_POST["code_fs"];
            $code_fl = $_POST["code_fl"];
            $code_fkps = $_POST["code_fkps"];
          
          if($code_fs != "") {
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == NULL) {
                           $code = $code_agence . '0000001' . 'P';
                        } 
                        else {
                           $num_ordre = substr($code, 12, 7);
                           $num_ordre++;
                           $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                           $code = $code_agence . $num_ordre_bis . 'P';
                        }
            $sms_fs = $sms_mapper->findByCreditCode($code_fs);
            
            if ($sms_fs == NULL) {
                            $db->rollback();
                            $this->view->message = 'Le code FS [' . $code_fs . ']  est  invalide !!!';
                            $this->view->nom_membre = $_POST["nom_membre"];
                            $this->view->prenom_membre = $_POST["prenom_membre"];
                            $this->view->sexe = $_POST["sexe_membre"];
                            $this->view->sitfam = $_POST["sitfam_membre"];
                            $this->view->datnais = $_POST["date_nais_membre"];
                            $this->view->nation = $_POST["nationalite_membre"];
                            $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                            $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                            $this->view->formation = $_POST["formation"];
                            $this->view->profession = $_POST["profession_membre"];
                            $this->view->religion = $_POST["religion_membre"];
                            $this->view->pere = $_POST["pere_membre"];
                            $this->view->mere = $_POST["mere_membre"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            return;
                        }
            
            if($sms_fs->getMotif() != 'FS') {
                $db->rollBack();
                          $this->view->message = " Le motif pour lequel ce code est émis ne correspond pas pour ce type d'operation";
                          $this->view->nom_membre = $_POST["nom_membre"];
                          $this->view->prenom_membre = $_POST["prenom_membre"];
                          $this->view->sexe = $_POST["sexe_membre"];
                          $this->view->sitfam = $_POST["sitfam_membre"];
                          $this->view->datnais = $_POST["date_nais_membre"];
                          $this->view->nation = $_POST["nationalite_membre"];
                          $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                          $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                          $this->view->formation = $_POST["formation"];
                          $this->view->profession = $_POST["profession_membre"];
                          $this->view->religion = $_POST["religion_membre"];
                          $this->view->pere = $_POST["pere_membre"];
                          $this->view->mere = $_POST["mere_membre"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          return;    
              }   
            
            $date_nais = new Zend_Date($_POST["date_nais_membre"]);
            if ($date_nais >= $date_idd) {
                            $this->view->message = "Erreur d'éxecution: La date de naissance doit être antérieure à la date actuelle !!!";
                            $db->rollback();
                            $this->view->nom_membre = $_POST["nom_membre"];
                            $this->view->prenom_membre = $_POST["prenom_membre"];
                            $this->view->sexe = $_POST["sexe_membre"];
                            $this->view->sitfam = $_POST["sitfam_membre"];
                            $this->view->datnais = $_POST["date_nais_membre"];
                            $this->view->nation = $_POST["nationalite_membre"];
                            $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                            $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                            $this->view->formation = $_POST["formation"];
                            $this->view->profession = $_POST["profession_membre"];
                            $this->view->religion = $_POST["religion_membre"];
                            $this->view->pere = $_POST["pere_membre"];
                            $this->view->mere = $_POST["mere_membre"];
                            $this->view->quartier_membre = $_POST["quartier_membre"];
                            $this->view->ville_membre = $_POST["ville_membre"];
                            $this->view->bp = $_POST["bp_membre"];
                            $this->view->tel = $_POST["tel_membre"];
                            $this->view->email = $_POST["email_membre"];
                            $this->view->portable = $_POST["portable_membre"];
                            return;
                        }
            $membre->setCode_membre($code)
                               ->setNom_membre($_POST["nom_membre"])
                               ->setPrenom_membre($_POST["prenom_membre"])
                               ->setSexe_membre($_POST["sexe_membre"])
                               ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                               ->setId_pays($_POST["nationalite_membre"])
                               ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                               ->setPere_membre($_POST["pere_membre"])
                               ->setMere_membre($_POST["mere_membre"])
                               ->setSitfam_membre($_POST["sitfam_membre"])
                               ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                               ->setProfession_membre($_POST["profession_membre"])
                               ->setFormation($_POST["formation"])
                               ->setId_religion_membre($_POST["religion_membre"])
                               ->setQuartier_membre($_POST["quartier_membre"])
                               ->setVille_membre($_POST["ville_membre"])
                               ->setBp_membre($_POST["bp_membre"])
                               ->setTel_membre($_POST["tel_membre"])
                               ->setEmail_membre($_POST["email_membre"])
                               ->setPortable_membre($_POST["portable_membre"])
                               ->setId_utilisateur(NULL)
                               ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                               ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                               ->setCode_agence($code_agence)
                   ->setCodesecret(md5($_POST["codesecret"]))
                   ->setEtat_membre('N');
                        $mapper->save($membre);
            
            

          for($i = 0; $i < count($_POST['code_banque']); $i++){
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
              $cb_compteur = $cb_mapper->findConuter() + 1;         
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre($code)
                   ->setCode_membre_morale(NULL)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i])
                 ;
                            $cb_mapper->save($cb);
                    }

            
                        $mapper_op = new Application_Model_EuOperationMapper();
                        $compteurfs = $mapper_op->findConuter() + 1;
                        $lib_op = 'Auto-enrôlement';
                        $type_op = 'AERL';
                        Util_Utils::addOperation($compteurfs,$code,NULL,'TFS',$fs,'FS',$lib_op,$type_op,$date_idd->toString('yyyy-MM-dd'), $date_id->toString('HH:mm:ss'), NULL);
                        
            $tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre($code)
                     ->setCode_membre_morale(NULL)
                                 ->setCode_fs('FS-' . $code)
                                 ->setCreditcode($sms_fs->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                 ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                 ->setId_utilisateur(NULL)
                                 ->setMont_fs($fs);
                        $tab_fs->insert($fs_model->toArray());
            
            
            $sms_fs->setDestAccount_Consumed('NB-TFS-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms_fs);
             
            $userin = new Application_Model_EuUtilisateur();
                        $mapper = new Application_Model_EuUtilisateurMapper();
                        $id_user = $mapper->findConuter() + 1;
                        $userin->setId_utilisateur($id_user)
                               ->setId_utilisateur_parent(NULL)
                               ->setPrenom_utilisateur($_POST["prenom_membre"])
                               ->setNom_utilisateur($_POST["nom_membre"])
                               ->setLogin($code)
                               ->setPwd(md5($_POST["codesecret"]))
                               ->setDescription(NULL)
                               ->setUlock(0)
                               ->setCh_pwd_flog(0)
                               ->setCode_groupe('personne_physique')
                     ->setCode_groupe_create('personne_physique')
                               ->setConnecte(0)
                               ->setCode_agence($code_agence)
                               ->setCode_secteur(NULL)
                               ->setCode_zone($code_zone)
                                 //->setCode_gac_filiere(NULL)
                           ->setId_pays($id_pays)       
                               ->setCode_acteur($code_acteur)
                     ->setCode_membre($code);    
                        $mapper->save($userin);
              
              // Mise à jour de la table eu_contrat
                        $contrat = new Application_Model_EuContrat();
                    $mapper_contrat = new Application_Model_EuContratMapper();
                    $id_contrat = $mapper->findConuter() + 1;
                $contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd'));
                        $contrat->setNature_contrat('numerique');
                        $contrat->setId_type_contrat(NULL);
                        $contrat->setId_type_creneau(NULL);
                        $contrat->setId_type_acteur(NULL);
                        $contrat->setId_pays(NULL);
                        $contrat->setId_utilisateur(NULL);
                        $contrat->setFiliere(NULL);
                        $mapper_contrat->save($contrat);
              
              $acteur = $code_acteur;
                $t_acteur = new Application_Model_DbTable_EuActeur();
                        $c_acteur = new Application_Model_EuActeur();
                        $count = $c_acteur->findConuter() + 1;
              $table = new Application_Model_DbTable_EuActeur();
          
              if(isset($_POST["actcmfh"])) { 
                            $select = $table->select();
                  $select->where('code_acteur LIKE ?', $acteur);
                  $resultSet = $table->fetchAll($select);
                  $ligneacteur = $resultSet->current();
                            $c_acteur->setId_acteur($count);
                            $c_acteur->setCode_acteur(NULL);
                            $c_acteur->setCode_membre($code);
                            $c_acteur->setId_utilisateur(NULL);
                            $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                    $c_acteur->setCode_activite(NULL);
                    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
                    $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
                  $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
                  $c_acteur->setId_pays($ligneacteur->id_pays);
                  $c_acteur->setId_region($ligneacteur->id_region);
                  $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
                  $c_acteur->setCode_agence_create($ligneacteur->code_agence_create); 
                            $c_acteur->setType_acteur('CMFH');
                    $c_acteur->setCode_gac_chaine($acteur);         
                            $t_acteur->insert($c_acteur->toArray());
             
          }   else if(isset($_POST["actenro"])) { 
                  $select = $table->select();
                  $select->where('code_acteur LIKE ?', $acteur);
                  $resultSet = $table->fetchAll($select);
                  $ligneacteur = $resultSet->current();
                            $c_acteur->setId_acteur($count);
                            $c_acteur->setCode_acteur(NULL);
                            $c_acteur->setCode_membre($code);
                            $c_acteur->setId_utilisateur(NULL);
                            $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                    $c_acteur->setCode_activite(NULL);
                    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
                    $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
                  $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
                  $c_acteur->setId_pays($ligneacteur->id_pays);
                  $c_acteur->setId_region($ligneacteur->id_region);
                  $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
                  $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                  $c_acteur->setType_acteur('DSMS');
                    $c_acteur->setCode_gac_chaine($acteur);         
                            $t_acteur->insert($c_acteur->toArray());
          }

                    } else {
                        $this->view->message = "Erreur d'éxecution: Le code FS est inexistant !!!";
                        $db->rollback();
                        $this->view->nom_membre = $_POST["nom_membre"];
                        $this->view->prenom_membre = $_POST["prenom_membre"];
                        $this->view->sexe = $_POST["sexe_membre"];
                        $this->view->sitfam = $_POST["sitfam_membre"];
                        $this->view->datnais = $_POST["date_nais_membre"];
                        $this->view->nation = $_POST["nationalite_membre"];
                        $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                        $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                        $this->view->formation = $_POST["formation"];
                        $this->view->profession = $_POST["profession_membre"];
                        $this->view->religion = $_POST["religion_membre"];
                        $this->view->pere = $_POST["pere_membre"];
                        $this->view->mere = $_POST["mere_membre"];
                        $this->view->quartier_membre = $_POST["quartier_membre"];
                        $this->view->ville_membre = $_POST["ville_membre"];
                        $this->view->bp = $_POST["bp_membre"];
                        $this->view->tel = $_POST["tel_membre"];
                        $this->view->email = $_POST["email_membre"];
                        $this->view->portable = $_POST["portable_membre"];
                        return;  
                    }
          
          if($code_fl != "") {
              $sms_fl = $sms_mapper->findByCreditCode($code_fl);
            if ($sms_fl == NULL) {
                           $db->rollback();
                           $this->view->message = 'Le code FL [' . $code_fl . ']  est  invalide !!!';
                           $this->view->nom_membre = $_POST["nom_membre"];
                           $this->view->prenom_membre = $_POST["prenom_membre"];
                           $this->view->sexe = $_POST["sexe_membre"];
                           $this->view->sitfam = $_POST["sitfam_membre"];
                           $this->view->datnais = $_POST["date_nais_membre"];
                           $this->view->nation = $_POST["nationalite_membre"];
                           $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                           $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                           $this->view->formation = $_POST["formation"];
                           $this->view->profession = $_POST["profession_membre"];
                           $this->view->religion = $_POST["religion_membre"];
                           $this->view->pere = $_POST["pere_membre"];
                           $this->view->mere = $_POST["mere_membre"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           return;
                        }
            
            if($sms_fl->getMotif() != 'FL') {
                $db->rollBack();
                          $this->view->message = " Le motif pour lequel ce code FL est émis ne correspond pas pour ce type d'operation";
                          $this->view->nom_membre = $_POST["nom_membre"];
                          $this->view->prenom_membre = $_POST["prenom_membre"];
                          $this->view->sexe = $_POST["sexe_membre"];
                          $this->view->sitfam = $_POST["sitfam_membre"];
                          $this->view->datnais = $_POST["date_nais_membre"];
                          $this->view->nation = $_POST["nationalite_membre"];
                          $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                          $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                          $this->view->formation = $_POST["formation"];
                          $this->view->profession = $_POST["profession_membre"];
                          $this->view->religion = $_POST["religion_membre"];
                          $this->view->pere = $_POST["pere_membre"];
                          $this->view->mere = $_POST["mere_membre"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          return;    
              }
            
            $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
            
            $fl->setCode_fl($code_fl)
                           ->setCode_membre($code)
               ->setCode_membre_morale(NULL)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur(NULL)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
            
            //Mise e jour du compte general FGFL
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
            $compteurfl = $mapper_op->findConuter() + 1;
                        Util_Utils::addOperation($compteurfl,$code,NULL, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
            
            $sms_fl->setDestAccount_Consumed('FL-'.$code)
                               ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms_fl);
            
            $tcartes[0]="TPAGCRPG";
            $tcartes[1]="TCNCS";
              $tcartes[2]="TPaNu";
              $tcartes[3]="TPaR";
            $tcartes[4]="TR";
            $tcartes[5]="CAPA";
            $tcartes[6]="TRE";
               
            $tscartes[0]="TSRPG";
              $tscartes[1]="TSCNCS";
            $tscartes[2]="TSPaNu";
            $tscartes[3]="TSPaR";
            $tscartes[4]="TSCAPA";
			$tscartes[5]="TSRE";
            
            for($i = 0; $i < count($tcartes); $i++) {
                if($tcartes[$i] == "TCNCS") {
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                  $type_carte = 'NR';
                $res = $map_compte->find($code_compte,$compte);
              } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                $type_carte = 'NN';
                  $res = $map_compte->find($code_compte,$compte);
              } else  {
                $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                $type_carte = 'NB';
                  $res = $map_compte->find($code_compte,$compte);
              }
                    
                if(!$res) {
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre($code)
                     ->setCode_membre_morale(NULL)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
                  $map_compte->save($compte);
                  
              }
                  
                        }
            
            for($j = 0; $j < count($tscartes); $j++) {
              if($tscartes[$j] == "TSCNCS") {
                              $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                $type_carte = 'NR';
                $res = $map_compte->find($code_comptets,$compte);
              } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                              $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                $type_carte = 'NN';
                $res = $map_compte->find($code_comptets,$compte);
                } else {
                $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                $type_carte = 'NB';
                $res = $map_compte->find($code_comptets,$compte);
              }     
              if(!$res) {
                                $compte->setCode_cat($tscartes[$j])
                                       ->setCode_compte($code_comptets)
                                       ->setCode_membre($code)
                     ->setCode_membre_morale(NULL)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tscartes[$j])
                                       ->setSolde(0);
                  $map_compte->save($compte);   
              } 
            }
            
          }
          
          if($code_fkps != "") {
                        $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
            if ($sms_fkps == NULL) {
                           $db->rollback();
                           $this->view->message = 'Le code FKPS [' . $code_fkps . ']  est  invalide !!!';
                           $this->view->nom_membre = $_POST["nom_membre"];
                           $this->view->prenom_membre = $_POST["prenom_membre"];
                           $this->view->sexe = $_POST["sexe_membre"];
                           $this->view->sitfam = $_POST["sitfam_membre"];
                           $this->view->datnais = $_POST["date_nais_membre"];
                           $this->view->nation = $_POST["nationalite_membre"];
                           $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                           $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                           $this->view->formation = $_POST["formation"];
                           $this->view->profession = $_POST["profession_membre"];
                           $this->view->religion = $_POST["religion_membre"];
                           $this->view->pere = $_POST["pere_membre"];
                           $this->view->mere = $_POST["mere_membre"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           return;
                        }
            
            if($sms_fkps->getMotif() != 'FKPS') {
                $db->rollBack();
                          $this->view->message = " Le motif pour lequel ce code FKPS est émis ne correspond pas pour ce type d'operation";
                          $this->view->nom_membre = $_POST["nom_membre"];
                          $this->view->prenom_membre = $_POST["prenom_membre"];
                          $this->view->sexe = $_POST["sexe_membre"];
                          $this->view->sitfam = $_POST["sitfam_membre"];
                          $this->view->datnais = $_POST["date_nais_membre"];
                          $this->view->nation = $_POST["nationalite_membre"];
                          $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                          $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                          $this->view->formation = $_POST["formation"];
                          $this->view->profession = $_POST["profession_membre"];
                          $this->view->religion = $_POST["religion_membre"];
                          $this->view->pere = $_POST["pere_membre"];
                          $this->view->mere = $_POST["mere_membre"];
                          $this->view->quartier_membre = $_POST["quartier_membre"];
                          $this->view->ville_membre = $_POST["ville_membre"];
                          $this->view->bp = $_POST["bp_membre"];
                          $this->view->tel = $_POST["tel_membre"];
                          $this->view->email = $_POST["email_membre"];
                          $this->view->portable = $_POST["portable_membre"];
                          return;    
              } 
            
            $carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
            $id_demande = $carte->findConuter() + 1;
            $carte->setId_demande($id_demande)
                ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($mont_cps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("NB-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur(NULL);
                        $t_carte->insert($carte->toArray()); 
            $compteurcps = $mapper_op->findConuter() + 1; 
            Util_Utils::addOperation($compteurcps, $code,NULL, NULL, $mont_cps, NULL, 'Frais de CPS', 'CPS', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), NULL);
                        $sms_fkps->setDestAccount_Consumed('CPS-'.$code)
                            ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                            ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms_fkps);    
          }
          
                    $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP! Votre numero de membre est: " . $code ."  Votre Code Secret est : " .$_POST["codesecret"]); 
                    $db->commit();
                    //return $this->_helper->redirector('index'); 
        } catch (Exception $exc) {
            $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
          $db->rollback();
                    $this->view->nom_membre = $_POST["nom_membre"];
                    $this->view->prenom_membre = $_POST["prenom_membre"];
                    $this->view->sexe = $_POST["sexe_membre"];
                    $this->view->sitfam = $_POST["sitfam_membre"];
                    $this->view->datnais = $_POST["date_nais_membre"];
                    $this->view->nation = $_POST["nationalite_membre"];
                    $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                    $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                    $this->view->formation = $_POST["formation"];
                    $this->view->profession = $_POST["profession_membre"];
                    $this->view->religion = $_POST["religion_membre"];
                    $this->view->pere = $_POST["pere_membre"];
                    $this->view->mere = $_POST["mere_membre"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->portable = $_POST["portable_membre"];
                    return;
                }
        

      $this->view->message = "Enrôlement bien effectuée ...";
    //$this->_redirect('/');
    } else {  $this->view->message = "Vérifier bien les codes SMS ...";  } 
    } else {  $this->view->message = "Champs * obligatoire ...";  } 
    }
    
    }

  
    public function enrolementpmsms2Action()
    {
        /* page index/enrolementpmsms2 - Mise sur chaine avec Code SMS */

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
        

    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if (isset($_POST['code_fs']) && $_POST['code_fs']!="" && isset($_POST['code_fl']) && $_POST['code_fl']!="" && isset($_POST['code_type_acteur']) && $_POST['code_type_acteur']!="" && isset($_POST['raison_sociale']) && $_POST['raison_sociale']!="" && isset($_POST['num_registre_membre']) && $_POST['num_registre_membre']!="" && isset($_POST['code_statut']) && $_POST['code_statut']!="" && isset($_POST['code_rep']) && $_POST['code_rep']!="" && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {
// && isset($_POST['code_fkps']) && $_POST['code_fkps']!=""     

$offres_mapper = new Application_Model_EuAppeloffresMapper();
$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
$agrement_mapper = new Application_Model_EuAgrementMapper();
$licence_mapper = new Application_Model_EuLicenceMapper();

if(
$smsmoneyFS = $smsmoneyM->findByCreditCode9($_POST['code_fs'], "FS") && 
$smsmoneyFL = $smsmoneyM->findByCreditCode9($_POST['code_fl'], "FL") && 
(($_POST['code_fkps']=="") || (isset($_POST['code_fkps']) && $_POST['code_fkps']!="" && $smsmoneyFKPS = $smsmoneyM->findByCreditCode9($_POST['code_fkps'], "FCPS"))) && 
(
//(isset($_POST["numero_contrat"]) && $_POST["numero_contrat"] != "" && $trouveof = $offres_mapper->findoffres($_POST["numero_contrat"])) ||
//(isset($_POST["numero_licence"]) && $_POST["numero_licence"] != "" && $trouvel = $licence_mapper->findlicence($_POST["numero_licence"]))||
($trouveagrementfiliere = $agrement_mapper->findagrementfiliere($_POST["numero_agrement_filiere"]) && 
$trouveagrementacnev = $agrement_mapper->findagrementacnev($_POST["numero_agrement_acnev"]) && 
$trouveagrementtechno = $agrement_mapper->findagrementtechno($_POST["numero_agrement_technopole"]))
)
){
//$smsmoneyFKPS = $smsmoneyM->findByCreditCode9($_POST['code_fkps'], "FCPS") && 

               $utilisateur = NULL;
           //$groupe = $user->code_groupe;
$code_agence = $_POST['code_agence'];
$code_zone = substr($_POST['code_agence'], 0, 3);
$id_pays = $_POST['id_pays'];
$groupe = NULL;

         $table = new Application_Model_DbTable_EuActeur();
         $selection = $table->select();
         $selection->where('code_membre LIKE ?',$code_agence.'%');
         $selection->where('type_acteur LIKE ?','gac_surveillance');
         $resultat = $table->fetchAll($selection);
         $trouvacteursur = $resultat->current();
         $code_acteur = $trouvacteursur->code_acteur;
           $acteur      =  $code_acteur;
           
               $fs = Util_Utils::getParametre('FS','valeur');
         $mont_fl = Util_Utils::getParametre('FL','valeur');
         $fcps = Util_Utils::getParametre('FCPS','valeur');
           
         $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               $code_fs = $_POST["code_fs"];
         $code_fl = $_POST["code_fl"];
         $code_fkps = $_POST["code_fkps"];
         
         $membre = new Application_Model_EuMembreMorale();
               $mapper = new Application_Model_EuMembreMoraleMapper();
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
         $agrement_mapper = new Application_Model_EuAgrementMapper();
               $agrement        = new Application_Model_EuAgrement();
               $mapper_op = new Application_Model_EuOperationMapper();
               $compte = new Application_Model_EuCompte();
               $map_compte = new Application_Model_EuCompteMapper();
         $tcartes = array();
         $tscartes = array();
               $db = Zend_Db_Table::getDefaultAdapter();
               $db->beginTransaction();
          try {
              if($code_fs !="") {
                        $sms_fs = $sms_mapper->findByCreditCode($code_fs);
                       $agrement_filiere  =  $_POST["numero_agrement_filiere"];
                       $agrement_acnev    =  $_POST["numero_agrement_acnev"];
                       $agrement_technopole =  $_POST["numero_agrement_technopole"];
             
              $membre1 = new Application_Model_EuMembreMorale();
                        $mapper1 = new Application_Model_EuMembreMoraleMapper();
                        $code = $mapper->getLastCodeMembreByAgence($code_agence);
                        if ($code == NULL) {
                                $code = $code_agence . '0000001' . 'M';
                        } else {
                            $num_ordre = substr($code, 12, 7);
                            $num_ordre++;
                            $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                            $code = $code_agence . $num_ordre_bis . 'M';
                        }
              
              $compteur = $mapper_op->findConuter() + 1;
                        
                        $trouveagrementfiliere = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
            
            if($trouveagrementfiliere != FALSE) {
              $result = $agrement_mapper->find($trouveagrementfiliere->getId_agrement(),$agrement);
			  
							$id_type_acteur = $agrement->getId_type_acteur();
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_filiere = $agrement->getId_filiere();

                  $agrement->setCode_membre_morale($code);
                  $agrement_mapper->update($agrement);
              $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
            }
            
            if($trouveagrementacnev != FALSE) {
                    $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
                    $agrement->setCode_membre_morale($code);
                    $agrement_mapper->update($agrement);    
            }
            
            if($trouveagrementtechno != FALSE) {
                   $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
                   $agrement->setCode_membre_morale($code);
                   $agrement_mapper->update($agrement); 
            }
            
            $membre->setId_filiere($id_filiere);
              $membre->setCode_membre_morale($code);
                        $membre->setCode_type_acteur($_POST["code_type_acteur"]);
                        $membre->setCode_statut($_POST["code_statut"]);
                        $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));

            $membre->setId_pays($_POST["id_pays"]);
                        $membre->setNum_registre_membre($_POST["num_registre_membre"]);
                        $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                        $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                        $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                        $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                        $membre->setBp_membre($_POST["bp_membre"]);
                        $membre->setTel_membre($_POST["tel_membre"]);
                        $membre->setEmail_membre($_POST["email_membre"]);
                        $membre->setPortable_membre($_POST["portable_membre"]);
                        $membre->setId_utilisateur(NULL);
                        $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                        $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                        $membre->setCode_agence($code_agence);
                        $membre->setCodesecret(md5($_POST["codesecret"]));
                        $membre->setAuto_enroler('O');
            $membre->setEtat_membre('N');
                $mapper->save($membre);
             
             
            
            // eu_acteurs_creneau
                  $cm = new Application_Model_EuActeurCreneauMapper();
                            $acren = new Application_Model_EuActeurCreneau();
              
              $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                            $acren->setCode_membre($code);
                 $acren->setId_type_acteur($id_type_acteur);
              
              
              //$acren->setCode_activite(NULL);
                            $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                            $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                            $acren->setId_utilisateur($utilisateur);
              $acren->setGroupe($groupe);
              $acren->setCode_creneau(NULL);
                            $acren->setCode_gac_filiere(NULL);
                            $acren->setCode_gac(NULL);
              
              //$code_zone = $code_zone;
                      $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                            if ($code_acteur == NULL) {
                                $code_acteur = 'A' . $code_zone . '0001';
                            } else {
                              $num_ordre = substr($code_acteur, -4);
                              $num_ordre++;
                              $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                            }
            
                $acren->setCode_acteur($code_acteur);
                $acren->setId_filiere($id_filiere);
                $cm->save($acren);
              
            
              // eu_operation
                            Util_Utils::addOperation($compteur,NULL,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), NULL);
               
              
            
              //insertion dans la table eu_representation
                $rep_mapper = new Application_Model_EuRepresentationMapper();
                            $rep = new Application_Model_EuRepresentation();
                $rep->setCode_membre_morale($code)
                                ->setCode_membre($_POST['code_rep'])
                                ->setTitre("Representant")
                  ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
                  ->setId_utilisateur(NULL)
                  ->setEtat('inside');
                            $rep_mapper->save($rep);
              
                  
              
                    for($i = 0; $i < count($_POST['code_banque']); $i++){
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
              $cb_compteur = $cb_mapper->findConuter() + 1;         
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre(NULL)
                   ->setCode_membre_morale($code)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i])
                 ;
                            $cb_mapper->save($cb);
                    }


              $filiere =  new Application_Model_EuFiliere();
                $map_filiere = new Application_Model_EuFiliereMapper();
                $find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
                            $t_acteur = new Application_Model_DbTable_EuActeur();
                $c_acteur = new Application_Model_EuActeur();
                $table = new Application_Model_DbTable_EuActeur();
                            $select = $table->select();
                  $select->where('code_acteur LIKE ?', $acteur);
                  $resultSet = $table->fetchAll($select);
                  $ligneacteur = $resultSet->current();
                $count = $c_acteur->findConuter() + 1;
                            $c_acteur->setId_acteur($count)
                                     ->setCode_acteur(NULL)
                   ->setCode_division($filiere->getCode_division())
                                     ->setCode_membre($code)
                                     ->setId_utilisateur($utilisateur)
                                     ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                                if($trouveagrementfiliere->id_type_acteur == 3) {
                                   $c_acteur->setCode_activite('detaillant');
                   $c_acteur->setCode_source_create($ligneacteur->code_source_create);
                       $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
                       $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
                       $c_acteur->setId_pays($ligneacteur->id_pays);
                       $c_acteur->setId_region($ligneacteur->id_region);
                       $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
                       $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($trouveagrementfiliere->id_type_acteur == 2) {
                                   $c_acteur->setCode_activite('semi-grossiste');
                       $c_acteur->setCode_source_create($ligneacteur->code_source_create);
                       $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
                       $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
                       $c_acteur->setId_pays($ligneacteur->id_pays);
                       $c_acteur->setId_region($ligneacteur->id_region);
                       $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
                       $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } elseif($trouveagrementfiliere->id_type_acteur == 1){
                                   $c_acteur->setCode_activite('grossiste');
                    $c_acteur->setCode_source_create($ligneacteur->code_source_create);
                       $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
                       $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
                       $c_acteur->setId_pays($ligneacteur->id_pays);
                       $c_acteur->setId_region($ligneacteur->id_region);
                       $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
                       $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                }
                                //if(isset($_POST['actcmfh'])) {  
                                   // $c_acteur->setType_acteur('CMFH');  
                    //} else
					
					if(isset($_POST['actenro'])) {
                        $c_acteur->setType_acteur('DSMS');  
                    } else {
                        $c_acteur->setType_acteur('DSMS');
                    }
                    $c_acteur->setCode_gac_chaine($acteur);
                    $t_acteur->insert($c_acteur->toArray());
                
                
                
                // Recuperation de la PRK nr
                $param = new Application_Model_EuParametresMapper();
                            $par = new Application_Model_EuParametres();
                            $prc = 0;
                            $par_prc = $param->find('prc', 'nr', $par);
                            if ($par_prc == true) {
                               $prc = $par->getMontant();
                            } 
            
                $te_mapper = new Application_Model_EuTegcMapper();
                $te = new Application_Model_EuTegc();
                $code_te = 'TEGCP' .$id_filiere. $code;
                $find_te = $te_mapper->find($code_te,$te);
                if ($find_te == false) {
                    $te->setCode_tegc($code_te)
                        ->setId_filiere($id_filiere)
                        ->setMdv($prc)
                        ->setCode_membre($code)
                        ->setMontant(0)
                        ->setMontant_utilise(0)
                        ->setSolde_tegc(0);
                    $te_mapper->save($te);
                } else {
                    $te->setId_filiere($id_filiere);
                    $te->setMdv($prc);
                    $te_mapper->update($te);
                }
              
                // table eu_utilisateur
                $user_mapper = new Application_Model_EuUtilisateurMapper();
                $userin = new Application_Model_EuUtilisateur();
                $membre_mapper = new Application_Model_EuMembreMapper();
                $membrein = new Application_Model_EuMembre();         
                $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                $id_user = $user_mapper->findConuter() + 1;
          
                            $userin->setId_utilisateur($id_user);
                            $userin->setId_utilisateur_parent($utilisateur); 
                            $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                            $userin->setNom_utilisateur($membrein->getNom_membre());
                            $userin->setLogin($code);
                            $userin->setPwd(md5($_POST["codesecret"]));
                            $userin->setDescription(NULL);
                            $userin->setUlock(0);
                            $userin->setCh_pwd_flog(0);
                        
                $code_type_acteur = $_POST["code_type_acteur"];
            
                        if($trouveagrementfiliere->id_type_acteur == 3 && $code_type_acteur == 'EI') {
                          $userin->setCode_groupe('oe_detaillant');
                          $userin->setCode_gac_filiere('oe_detaillant');
                $userin->setCode_groupe_create('oe_detaillant');
                        } 
                elseif($trouveagrementfiliere->id_type_acteur == 3 && $code_type_acteur == 'OSE') {
                          $userin->setCode_groupe('ose_detaillant');
                          $userin->setCode_gac_filiere('ose_detaillant');
                $userin->setCode_groupe_create('ose_detaillant');
                        }
            
                elseif($trouveagrementfiliere->id_type_acteur == 2  && $code_type_acteur == 'EI') {
                          $userin->setCode_groupe('oe_semi_grossiste');
                          $userin->setCode_gac_filiere(NULL);
                $userin->setCode_groupe_create('oe_semi_grossiste');
                        } elseif($trouveagrementfiliere->id_type_acteur == 2  && $code_type_acteur == 'OSE') {
                        $userin->setCode_groupe('ose_semi_grossiste');
                        $userin->setCode_gac_filiere(NULL);
                $userin->setCode_groupe_create('ose_semi_grossiste');
                        } 
                elseif($trouveagrementfiliere->id_type_acteur == 1  && $code_type_acteur == 'EI') {
                        $userin->setCode_groupe('oe_grossiste');
                        $userin->setCode_gac_filiere(NULL);
                $userin->setCode_groupe_create('oe_grossiste');
                        }
                elseif($trouveagrementfiliere->id_type_acteur == 1  && $code_type_acteur == 'OSE') {
                        $userin->setCode_groupe('ose_grossiste');
                        $userin->setCode_gac_filiere(NULL);
                $userin->setCode_groupe_create('ose_grossiste');
                        }
                        $userin->setConnecte(0);
                        $userin->setCode_agence($code_agence);
                        $userin->setCode_secteur(NULL);
                        $userin->setCode_zone($code_zone);
                        $userin->setId_filiere($id_filiere);
                    
                $userin->setCode_acteur($acteur);
          
                $userin->setCode_membre($code);
                    $userin->setId_pays($id_pays);        
                        $user_mapper->save($userin);
            
            
            
                // Mise à jour de la table eu_contrat
                $contrat = new Application_Model_EuContrat();
                $mapper_contrat = new Application_Model_EuContratMapper();
                $id_contrat = $mapper_contrat->findConuter() + 1;
          
              $contrat->setId_contrat($id_contrat);
                        $contrat->setCode_membre($code);
                        $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                        $contrat->setNature_contrat(NULL);
                $contrat->setId_type_contrat(3);
                            $contrat->setId_type_creneau($id_type_creneau);

                            $contrat->setId_type_acteur($id_type_acteur);

                        $contrat->setId_pays($_POST['id_pays']);
                        $contrat->setId_utilisateur(NULL);
                        $contrat->setFiliere(''); 
                        $mapper_contrat->save($contrat);
            
            
            $tab_fs = new Application_Model_DbTable_EuFs();
                        $fs_model = new Application_Model_EuFs();
                        $fs_model->setCode_membre_morale($code)
                         ->setCode_membre(NULL)
                                 ->setCode_fs('FS-' . $code)
                                 ->setCreditcode($sms_fs->getCreditCode())
                                 ->setDate_fs($date_idd->toString('yyyy-MM-dd'))
                                 ->setHeure_fs($date_idd->toString('HH:mm:ss'))
                                 ->setId_utilisateur($utilisateur)
                                 ->setMont_fs($fs);
                        $tab_fs->insert($fs_model->toArray());
            
          
            $sms_fs->setDestAccount_Consumed('NB-TFS-' . $code)
                               ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                               ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_id->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms_fs);
            
          
                     
                    }
          
                    if($code_fl !="") {
            $sms_fl = $sms_mapper->findByCreditCode($code_fl);
              $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
             
              $fl->setCode_fl($code_fl)
                           ->setCode_membre(NULL)
               ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur(NULL)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
                        
            //Mise e jour du compte general FGFL
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
                $compteurfl = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteurfl,NULL,$code, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
            
                $sms_fl->setDestAccount_Consumed('FL-'.$code)
                                   ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                                   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                            $sms_mapper->update($sms_fl);

                        
                        
            $tcartes[0]="TPAGCP";
              $tcartes[1]="TCNCSEI";
            $tcartes[2]="TPAGCI";
              $tcartes[3]="TIR";
              $tcartes[4]="TR";
            $tcartes[5]="TPaNu";
            $tcartes[6]="TPaR";
              $tcartes[7]="TFS";
              $tcartes[8]="TPN";
            $tcartes[9]="TIB";
            $tcartes[10]="TPaNu";
            $tcartes[11]="TIN";
            $tcartes[12]="CAPA";
            $tcartes[13]="TMARGE";
              $tcartes[14]="TRE";
            
            for($i = 0; $i < count($tcartes); $i++) {
              if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                          $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                      $type_carte = 'NR';
                        $res = $map_compte->find($code_compte,$compte);
              } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE" || $tcartes[$i] == "TMARGE") {
                                          $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                      $type_carte = 'NN';
                        $res = $map_compte->find($code_compte,$compte);
              } elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
                        $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                        $type_carte = 'NB';
                          $res = $map_compte->find($code_compte,$compte);
              } elseif($tcartes[$i] == "TIN") {
                $tcartes[$i] = "TI"; 
                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                $type_carte = 'NN';
                  $res = $map_compte->find($code_compte,$compte);
              } elseif($tcartes[$i] == "TIR") {
                $tcartes[$i] = "TI"; 
                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                $type_carte = 'NR';
                  $res = $map_compte->find($code_compte,$compte);
              } elseif($tcartes[$i] == "TIB") {
                $tcartes[$i] = "TI";
                $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                $type_carte = 'NB';
                  $res = $map_compte->find($code_compte,$compte);
              }
                    
                if(!$res) {
                                    $compte->setCode_cat($tcartes[$i])
                                          ->setCode_compte($code_compte)
                                          ->setCode_membre(NULL)
                      ->setCode_membre_morale($code)
                                          ->setCode_type_compte($type_carte)
                                          ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                          ->setDesactiver(0)
                                          ->setLib_compte($tcartes[$i])
                                         ->setSolde(0);
                    $map_compte->save($compte); 
                  }
                  
                            }
              
              $tscartes[0]="TSGCP";
              $tscartes[1]="TSCNCSEI";
              $tscartes[2]="TSGCI";
              $tscartes[3]="TSCAPA";
              $tscartes[4]="TSPaNu";
              $tscartes[5]="TSPaR";
              $tscartes[6]="TSFS";
              $tscartes[7]="TSPN";
              $tscartes[8]="TSIN";
              $tscartes[9]="TSIB";
              $tscartes[10]="TSIR";
              $tscartes[11]="TSMARGE";
			  $tscartes[12]="TSRE";
              
                            for($j = 0; $j < count($tscartes); $j++) {  
                  if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NR';
                    $res = $map_compte->find($code_comptets,$compte);
                } elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSMARGE" || $tscartes[$j] == "TSRE") {
                    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NN';
                    $res = $map_compte->find($code_comptets,$compte);
                } elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
                      || $tscartes[$j] == "TSFS") {
                    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NB';
                    $res = $map_compte->find($code_comptets,$compte);
                } elseif($tscartes[$j] == "TSIN") {
                    $tscartes[$j] = "TSI"; 
                    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NN';
                    $res = $map_compte->find($code_comptets,$compte);
                } elseif($tscartes[$j] == "TSIR") {
                    $tscartes[$j] = "TSI"; 
                    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NR';
                    $res = $map_compte->find($code_comptets,$compte);
                } elseif($tscartes[$j] == "TSIB") {
                    $tscartes[$j] = "TSI";
                    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NB';
                    $res = $map_compte->find($code_comptets,$compte);
                }
                  if(!$res) {
                                        $compte->setCode_cat($tscartes[$j])
                                               ->setCode_compte($code_comptets)
                                               ->setCode_membre(NULL)
                         ->setCode_membre_morale($code)
                                               ->setCode_type_compte($type_carte)
                                               ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                               ->setDesactiver(0)
                                               ->setLib_compte($tscartes[$j])
                                               ->setSolde(0);
                      $map_compte->save($compte);
                  }
                  
                                } 
                    }

                    if($code_fkps !="") {
              $sms_fkps = $sms_mapper->findByCreditCode($code_fkps);
             
            $carte = new Application_Model_EuCartes();
                        $t_carte = new Application_Model_DbTable_EuCartes();
            $id_demande = $carte->findConuter() + 1;
            $carte->setId_demande($id_demande)
                ->setCode_cat($tcartes[0])
                              ->setCode_membre($code)
                              ->setMont_carte($fkps)
                              ->setDate_demande($date_idd->toString('yyyy-MM-dd'))
                              ->setLivrer(0)
                              ->setCode_Compte("NB-".$tcartes[0]."-".$code)
                              ->setImprimer(0)
                              ->setCardPrintedDate('')
                              ->setCardPrintedIDDate(0)
                              ->setId_utilisateur(NULL);
                        $t_carte->insert($carte->toArray());
                             
              $sms_fkps->setDestAccount_Consumed('CPS-' . $code)
                                 ->setDateTimeconsumed($date_id->toString('dd/MM/yyyy HH:mm:ss'))
                                 ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                        $sms_mapper->update($sms_fkps); 
                    }
                  
          $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                    $db->commit();
                    //return $this->_helper->redirector('morale','eu-preinscription',NULL,array('controller' => 'eu-preinscription','action'=>'morale')); 
          } catch (Exception $exc) {
                    $db->rollback();
                    $this->view->code_type_acteur = $_POST["code_type_acteur"];
                    $this->view->code_statut = $_POST["code_statut"];
                    $this->view->raison_sociale = $_POST["raison_sociale"];
                    $this->view->domaine_activite = $_POST["domaine_activite"];
                    $this->view->site_web = $_POST["site_web"];
                    $this->view->quartier_membre = $_POST["quartier_membre"];
                    $this->view->ville_membre = $_POST["ville_membre"];
                    $this->view->bp = $_POST["bp_membre"];
                    $this->view->tel = $_POST["tel_membre"];
                    $this->view->email = $_POST["email_membre"];
                    $this->view->id_pays = $_POST["id_pays"];
                    $this->view->portable = $_POST["portable_membre"];
                    $this->view->registre = $_POST["num_registre_membre"];
                    $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                    return;
                }
      
                      
      $this->view->message = "Mise sur chaine bien effectuée ...";
    //$this->_redirect('/');
    } else {  $this->view->message = "Vérifier bien les codes SMS et les numéros ...";  } 
    } else {  $this->view->message = "Champs * obligatoire ...";  } 
    }
    
    }

    public function testAction()
    {
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

$compteur = Util_Utils::findConuter() + 1; 
Util_Utils::addSms($compteur, '90291387', "Vous venez d'etre selectionne pour l'appel d'offre auquel vous avez soumissionner");        



    }





    public function ancienppAction()
    {
        /* page index/ancienpp - Retrouve ancienne personne physique GIE/ReDeMaRe */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
    
        $tabela = new Application_Model_DbTable_Physique();
    $membres = new Application_Model_DbTable_EuAncienMembre();
        $select=$tabela->select();
        $select->from($tabela)
               ->where('numidentp like ?', '%'.$_POST['code_membre'].'%')
         ->where('etat_contrat != 1')
         ;
    $memb = $tabela->fetchAll($select);
    if(count($memb) > 0){
    $trouvmembre = $memb->current();      
      
    $this->_redirect('/index/ancienppedit/id/'.$trouvmembre->numidentp);
    } else {  $this->view->message = "Pas de resultat ...";}
    } else {  $this->view->message = "Champs * obligatoire ...";}
       
  } 
  }





    public function ancienppeditAction()
    {
        /* page index/ancienppedit - Enrolement ancienne personne physique GIE/ReDeMaRe */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if (isset($_POST['nom_membre']) && $_POST['nom_membre']!="" && isset($_POST['sexe_membre']) && $_POST['sexe_membre']!="" && isset($_POST['nationalite_membre']) && $_POST['nationalite_membre']!="" && isset($_POST['sitfam_membre']) && $_POST['sitfam_membre']!="" && isset($_POST['prenom_membre']) && $_POST['prenom_membre']!="" && isset($_POST['date_nais_membre']) && $_POST['date_nais_membre']!="" && isset($_POST['lieu_nais_membre']) && $_POST['lieu_nais_membre']!="" && isset($_POST['nbr_enf_membre']) && $_POST['nbr_enf_membre']!="" && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" && isset($_POST['profession_membre']) && $_POST['profession_membre']!="" && isset($_POST['religion_membre']) && $_POST['religion_membre']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {

            
$code_agence = $_POST['code_agence'];
$code_zone = substr($_POST['code_agence'], 0, 3);
$id_pays = $_POST['id_pays'];
         $table = new Application_Model_DbTable_EuActeur();
         $selection = $table->select();
         $selection->where('code_membre LIKE ?',$code_agence.'%');
         $selection->where('type_acteur LIKE ?','gac_surveillance');
         $resultat = $table->fetchAll($selection);
         $trouvacteursur = $resultat->current();
         $code_acteur = $trouvacteursur->code_acteur;


            $date_id = new Zend_Date(Zend_Date::ISO_8601);
            $date_idd = clone $date_id;
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                  //insertion dans la table membre des information du nouveau membre
          
                  $membre = new Application_Model_EuMembre();
                  $mapper = new Application_Model_EuMembreMapper();
          $compte = new Application_Model_EuCompte();
                  $map_compte = new Application_Model_EuCompteMapper();
              $tcartes = array();
            $tscartes = array();
          
                  $code = $mapper->getLastCodeMembreByAgence($code_agence);
                  if ($code == NULL) {
                      $code = $code_agence . '0000001' . 'P';
                  } 
                  else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'P';
                  }
                      $date_nais = new Zend_Date($_POST["date_nais_membre"]);
                      if ($date_nais >= $date_idd) {
                         $this->view->message = "Erreur d'éxecution: La date de naissance doit être antérieure à la date actuelle !!!";
                         $db->rollback();
                         if ($code_caps != '') {
                            $this->view->code = $code_caps;
                         }
                         $this->view->nom_membre = $_POST["nom_membre"];
                         $this->view->prenom_membre = $_POST["prenom_membre"];
                         $this->view->sexe = $_POST["sexe_membre"];
                         $this->view->sitfam = $_POST["sitfam_membre"];
                         $this->view->datnais = $_POST["date_nais_membre"];
                         $this->view->nation = $_POST["nationalite_membre"];
                         $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                         $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                         $this->view->formation = $_POST["formation"];
                         $this->view->profession = $_POST["profession_membre"];
                         $this->view->religion = $_POST["religion_membre"];
                         $this->view->pere = $_POST["pere_membre"];
                         $this->view->mere = $_POST["mere_membre"];
                         $this->view->quartier_membre = $_POST["quartier_membre"];
                         $this->view->ville_membre = $_POST["ville_membre"];
                         $this->view->bp = $_POST["bp_membre"];
                         $this->view->tel = $_POST["tel_membre"];
                         $this->view->email = $_POST["email_membre"];
                         $this->view->portable = $_POST["portable_membre"];
                         return;
                    }
                    $membre->setCode_membre($code)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($_POST["nationalite_membre"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setId_utilisateur(NULL)//$user->id_utilisateur
                           ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                           ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                           ->setCode_agence($code_agence)
               ->setCodesecret(md5($_POST["codesecret"]))
               ->setEtat_membre('A');
                      $mapper->save($membre);
                        
                      //Mise à jour de la table physique
                      $p_mapper = new Application_Model_PhysiqueMapper();
                      $p = new Application_Model_Physique();
                      $rep = $p_mapper->find($_POST["numident"],$p);
                      if ($rep == true) {      
                         $p->setEtat_contrat(1)
               ->setCode_membre($code);
                         $p_mapper->update($p);      
                      }
               
          for($i = 0; $i < count($_POST['code_banque']); $i++){
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
              $cb_compteur = $cb_mapper->findConuter() + 1;         
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre($code)
                   ->setCode_membre_morale(NULL)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i])
                 ;
                            $cb_mapper->save($cb);
                    }

                     //Util_Utils::createCompte('NB-TPAGCRPG-' . $code, 'TPAGCRPG', 'TPAGCRPG', 0, $code, 'NB', $date_id, 0);
          // Mise à jour de la table eu_utilisateur
            
          $userin = new Application_Model_EuUtilisateur();
                    $mapper = new Application_Model_EuUtilisateurMapper();
                    $id_user = $mapper->findConuter() + 1;
                    $userin->setId_utilisateur($id_user)
                           ->setId_utilisateur_parent(NULL)//$user->id_utilisateur
                           ->setPrenom_utilisateur($_POST["prenom_membre"])
                           ->setNom_utilisateur($_POST["nom_membre"])
                           ->setLogin($code)
                           ->setPwd(md5($_POST["codesecret"]))
                           ->setDescription(NULL)
                           ->setUlock(0)
                           ->setCh_pwd_flog(0)
                           ->setCode_groupe('personne_physique')
                 ->setCode_groupe_create('personne_physique')
                           ->setConnecte(0)
                           ->setCode_agence($code_agence)
                           ->setCode_secteur(NULL)
                           ->setCode_zone($code_zone)
                                 //->setCode_gac_filiere(NULL)
                       ->setId_pays($id_pays)       
                           ->setCode_acteur($code_acteur)
                 ->setCode_membre($code);    
                     $mapper->save($userin);
          
        
             // Mise à jour de la table eu_contrat
                     $contrat = new Application_Model_EuContrat();
                 $mapper_contrat = new Application_Model_EuContratMapper();
                 $id_contrat = $mapper->findConuter() + 1;
             $contrat->setId_contrat($id_contrat);
                     $contrat->setCode_membre($code);
                     $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd'));
                     $contrat->setNature_contrat('numerique');
                     $contrat->setId_type_contrat(NULL);
                     $contrat->setId_type_creneau(NULL);
                     $contrat->setId_type_acteur(NULL);
                     $contrat->setId_pays(NULL);
                     $contrat->setId_utilisateur(NULL);//$user->id_utilisateur
                     $contrat->setFiliere(NULL);
                     $mapper_contrat->save($contrat);
              
              
             $acteur = $code_acteur;
             $t_acteur = new Application_Model_DbTable_EuActeur();
                     $c_acteur = new Application_Model_EuActeur();
                     $count = $c_acteur->findConuter() + 1;
           $table = new Application_Model_DbTable_EuActeur();
          
           if(isset($_POST["actcmfh"])) { 
                       $select = $table->select();
             $select->where('code_acteur LIKE ?', $acteur);
             $resultSet = $table->fetchAll($select);
             $ligneacteur = $resultSet->current();
                       $c_acteur->setId_acteur($count);
                       $c_acteur->setCode_acteur(NULL);
                       $c_acteur->setCode_membre($code);
                       $c_acteur->setId_utilisateur(NULL);//$user->id_utilisateur
                       $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
               $c_acteur->setCode_activite(NULL);
               $c_acteur->setCode_source_create($ligneacteur->code_source_create);
               $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
             $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
             $c_acteur->setId_pays($ligneacteur->id_pays);
             $c_acteur->setId_region($ligneacteur->id_region);
             $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
             $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                
                       $c_acteur->setType_acteur('CMFH');
               $c_acteur->setCode_gac_chaine($acteur);         
                       $t_acteur->insert($c_acteur->toArray());
          }  else if(isset($_POST["actenro"])) { 
              $select = $table->select();
              $select->where('code_acteur LIKE ?', $acteur);
              $resultSet = $table->fetchAll($select);
              $ligneacteur = $resultSet->current();
                        $c_acteur->setId_acteur($count);
                        $c_acteur->setCode_acteur(NULL);
                        $c_acteur->setCode_membre($code);
                        $c_acteur->setId_utilisateur(NULL);//$user->id_utilisateur
                        $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                $c_acteur->setCode_activite(NULL);
                $c_acteur->setCode_source_create($ligneacteur->code_source_create);
                $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
              $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
              $c_acteur->setId_pays($ligneacteur->id_pays);
              $c_acteur->setId_region($ligneacteur->id_region);
              $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
              $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
            
              $c_acteur->setType_acteur('DSMS');
                $c_acteur->setCode_gac_chaine($acteur);         
                        $t_acteur->insert($c_acteur->toArray());
             
          }
          
              $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
            $tafl = new Application_Model_DbTable_EuAncienFl();
                        $afl = new Application_Model_EuAncienFl();
                        $code_fl = 'FL-'.$code;
                        $result = $tafl->find($code_fl);
              
              //if (count($result) > 0) {
            $code_afl = 'FL-'.$code;
            $mont_fl = Util_Utils::getParametre('FL','valeur'); 
            $fl->setCode_fl($code_afl)
                           ->setCode_membre($code)
               ->setCode_membre_morale(NULL)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_id->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_id->toString('HH:mm:ss'))
                           ->setId_utilisateur(NULL)//$user->id_utilisateur
                           ->setCreditcode(NULL);
                         $tfl->insert($fl->toArray());
                
             $tcartes[0]="TPAGCRPG";
             $tcartes[1]="TCNCS";
             $tcartes[2]="TPaNu";
             $tcartes[3]="TPaR";
             $tcartes[4]="TR";
             $tcartes[5]="CAPA";
             $tcartes[6]="TRE";
               
             $tscartes[0]="TSRPG";
             $tscartes[1]="TSCNCS";
             $tscartes[2]="TSPaNu";
             $tscartes[3]="TSPaR";
             $tscartes[4]="TSCAPA";
			 $tscartes[5]="TSRE";
               
             for($i = 0; $i < count($tcartes); $i++) {
              if($tcartes[$i] == "TCNCS") {
                                $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                $type_carte = 'NR';
                $res = $map_compte->find($code_compte,$compte);
              } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                $type_carte = 'NN';
                  $res = $map_compte->find($code_compte,$compte);
              } else  {
                $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                $type_carte = 'NB';
                $res = $map_compte->find($code_compte,$compte);
               }
                    
              if(!$res) {
                                $compte->setCode_cat($tcartes[$i])
                                       ->setCode_compte($code_compte)
                                       ->setCode_membre($code)
                     ->setCode_membre_morale(NULL)
                                       ->setCode_type_compte($type_carte)
                                       ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                       ->setDesactiver(0)
                                       ->setLib_compte($tcartes[$i])
                                       ->setSolde(0);
                 $map_compte->save($compte);  
              }
                  
                            }
              
              
              for($j = 0; $j < count($tscartes); $j++) {
              
                  if($tscartes[$j] == "TSCNCS") {
                    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NR';
                    $res = $map_compte->find($code_comptets,$compte);
                } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NN';
                    $res = $map_compte->find($code_comptets,$compte);
                } else {
                    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NB';
                    $res = $map_compte->find($code_comptets,$compte);
                }
                    
                if(!$res) {
                    $compte->setCode_cat($tscartes[$j])
                           ->setCode_compte($code_comptets)
                           ->setCode_membre($code)
                           ->setCode_membre_morale(NULL)
                           ->setCode_type_compte($type_carte)
                           ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                           ->setDesactiver(0)
                           ->setLib_compte($tscartes[$j])
                           ->setSolde(0);
                    $map_compte->save($compte);
                  
                  }
              
              }
            
                    $compteur=Util_Utils::findConuter() + 1;
                            Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP! Votre numero de membre est: " . $code ."  Votre Code Secret est : " .$_POST["codesecret"]); 
                            $db->commit();
                            //Redirection sur le formulaire du contrat
                            //return $this->_helper->redirector('newpp', 'eu-contrat', NULL, array('controller' => 'eu-contrat', 'action' => 'newpp', 'membre' => $code, 'type' => 'P'));
                    //return $this->_helper->redirector('index');
            } 
            catch (Exception $exc) {
                   $db->rollback();
                   $this->view->nom = $_POST["nom_membre"];
                   $this->view->prenom = $_POST["prenom_membre"];
                   $this->view->sexe = $_POST["sexe_membre"];
                   $this->view->sitmatr = $_POST["sitfam_membre"];
                   $this->view->datenais = $_POST["date_nais_membre"];
                   $this->view->nation = $_POST["nationalite_membre"];
                   $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                   $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                   $this->view->formation = $_POST["formation"];
                   $this->view->prof = $_POST["profession_membre"];
                   $this->view->religion = $_POST["religion_membre"];
                   $this->view->pere = $_POST["pere_membre"];
                   $this->view->mere = $_POST["mere_membre"];
                   $this->view->quartier_membre = $_POST["quartier_membre"];
                   $this->view->ville_membre = $_POST["ville_membre"];
                   $this->view->bp = $_POST["bp_membre"];
                   $this->view->tel = $_POST["tel_membre"];
                   $this->view->email = $_POST["email_membre"];
                   $this->view->portable = $_POST["portable_membre"];
                   $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
             }
          

/*          */          

         $sessionmcnp->errorlogin = "Ré-activation du compte marchant membre personne physique bien effectuée ...";
    $this->_redirect('/index/ancienpp');
    //$this->_redirect('/');
    } else {  $this->view->message = "Champs * obligatoire ...";  } 
    } else {
      
            $id = (string)$this->_request->getParam('id');
      
        $tabela = new Application_Model_DbTable_Physique();
    $membres = new Application_Model_DbTable_EuAncienMembre();
        $select=$tabela->select();
        $select->from($tabela)
               ->where('numidentp like ?', '%'.$id.'%')
         ->where('etat_contrat != 1')
         ;
    $memb = $tabela->fetchAll($select);
    $trouvmembre = $memb->current();
      
$this->view->numident = $trouvmembre->numidentp;
$this->view->nom_membre = $trouvmembre->nom;
$this->view->prenom_membre = $trouvmembre->prenom;
$this->view->sexe = $trouvmembre->sexe;
$this->view->profession = $trouvmembre->prof;
$this->view->tel = $trouvmembre->tel;
$this->view->ville_membre = $trouvmembre->ville; 
$this->view->pere = $trouvmembre->pere;
$this->view->mere = $trouvmembre->mere;
$this->view->quartier_membre = $trouvmembre->qartresid;
$this->view->bp = $trouvmembre->bp;
$this->view->nbre_enf = $trouvmembre->nbrenf;
$this->view->email = $trouvmembre->email;
$this->view->portable = $trouvmembre->portable;
$this->view->formation = $trouvmembre->formation;
$this->view->lieu_nais = $trouvmembre->lieunais;
      
      }
    
    }













    public function ancienppmcnpAction()
    {
        /* page index/ancienppmcnp - Retrouve ancienne personne physique MCNP */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
    
        $tabela = new Application_Model_DbTable_EuAncienMembre();
       $select = $tabela->select();
           $select->where('ancien_code_membre LIKE ?', '%'.$_POST['code_membre'].'%')
          ->where('etat_contrat != 1');       
    $memb = $tabela->fetchAll($select);
    if(count($memb) > 0){
    $trouvmembre = $memb->current();      
      
    $this->_redirect('/index/ancienppmcnpedit/id/'.$trouvmembre->ancien_code_membre);
    } else {  $this->view->message = "Pas de resultat ...";}
    } else {  $this->view->message = "Champs * obligatoire ...";}
       
  } 
  }





    public function ancienppmcnpeditAction()
    {
        /* page index/ancienppmcnpedit - Enrolement ancienne personne physique MCNP */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if (isset($_POST['nom_membre']) && $_POST['nom_membre']!="" && isset($_POST['sexe_membre']) && $_POST['sexe_membre']!="" && isset($_POST['nationalite_membre']) && $_POST['nationalite_membre']!="" && isset($_POST['sitfam_membre']) && $_POST['sitfam_membre']!="" && isset($_POST['prenom_membre']) && $_POST['prenom_membre']!="" && isset($_POST['date_nais_membre']) && $_POST['date_nais_membre']!="" && isset($_POST['lieu_nais_membre']) && $_POST['lieu_nais_membre']!="" && isset($_POST['nbr_enf_membre']) && $_POST['nbr_enf_membre']!="" && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" && isset($_POST['profession_membre']) && $_POST['profession_membre']!="" && isset($_POST['religion_membre']) && $_POST['religion_membre']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {

            
$code_agence = $_POST['code_agence'];
$code_zone = substr($_POST['code_agence'], 0, 3);
$id_pays = $_POST['id_pays'];
         $table = new Application_Model_DbTable_EuActeur();
         $selection = $table->select();
         $selection->where('code_membre LIKE ?',$code_agence.'%');
         $selection->where('type_acteur LIKE ?','gac_surveillance');
         $resultat = $table->fetchAll($selection);
         $trouvacteursur = $resultat->current();
         $code_acteur = $trouvacteursur->code_acteur;


         
       $date_id = new Zend_Date(Zend_Date::ISO_8601);
           $date_idd = clone $date_id;
           $db = Zend_Db_Table::getDefaultAdapter();
           $db->beginTransaction();
       try {
             //insertion dans la table membre des information du nouveau membre
                  $membre = new Application_Model_EuMembre();
                  $mapper = new Application_Model_EuMembreMapper();
          $compte = new Application_Model_EuCompte();
                  $map_compte = new Application_Model_EuCompteMapper();
              $tcartes = array();
            $tscartes = array();
          
                  $code = $mapper->getLastCodeMembreByAgence($code_agence);
                  if ($code == NULL) {
                      $code = $code_agence . '0000001' . 'P';
                  } 
                  else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'P';
                  }
                      $date_nais = new Zend_Date($_POST["date_nais_membre"]);
                      if ($date_nais >= $date_idd) {
                         $this->view->message = "Erreur d'éxecution: La date de naissance doit être antérieure à la date actuelle !!!";
                         $db->rollback();
                         if ($code_caps != '') {
                            $this->view->code = $code_caps;
                         }
                         $this->view->nom_membre = $_POST["nom_membre"];
                         $this->view->prenom_membre = $_POST["prenom_membre"];
                         $this->view->sexe = $_POST["sexe_membre"];
                         $this->view->sitfam = $_POST["sitfam_membre"];
                         $this->view->datnais = $_POST["date_nais_membre"];
                         $this->view->nation = $_POST["nationalite_membre"];
                         $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                         $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                         $this->view->formation = $_POST["formation"];
                         $this->view->profession = $_POST["profession_membre"];
                         $this->view->religion = $_POST["religion_membre"];
                         $this->view->pere = $_POST["pere_membre"];
                         $this->view->mere = $_POST["mere_membre"];
                         $this->view->quartier_membre = $_POST["quartier_membre"];
                         $this->view->ville_membre = $_POST["ville_membre"];
                         $this->view->bp = $_POST["bp_membre"];
                         $this->view->tel = $_POST["tel_membre"];
                         $this->view->email = $_POST["email_membre"];
                         $this->view->portable = $_POST["portable_membre"];
                         return;
                    }
                    $membre->setCode_membre($code)
                           ->setNom_membre($_POST["nom_membre"])
                           ->setPrenom_membre($_POST["prenom_membre"])
                           ->setSexe_membre($_POST["sexe_membre"])
                           ->setDate_nais_membre($date_nais->toString('yyyy-MM-dd'))
                           ->setId_pays($_POST["nationalite_membre"])
                           ->setLieu_nais_membre($_POST["lieu_nais_membre"])
                           ->setPere_membre($_POST["pere_membre"])
                           ->setMere_membre($_POST["mere_membre"])
                           ->setSitfam_membre($_POST["sitfam_membre"])
                           ->setNbr_enf_membre($_POST["nbr_enf_membre"])
                           ->setProfession_membre($_POST["profession_membre"])
                           ->setFormation($_POST["formation"])
                           ->setId_religion_membre($_POST["religion_membre"])
                           ->setQuartier_membre($_POST["quartier_membre"])
                           ->setVille_membre($_POST["ville_membre"])
                           ->setBp_membre($_POST["bp_membre"])
                           ->setTel_membre($_POST["tel_membre"])
                           ->setEmail_membre($_POST["email_membre"])
                           ->setPortable_membre($_POST["portable_membre"])
                           ->setId_utilisateur(NULL)
                           ->setHeure_identification($date_idd->toString('HH:mm:ss'))
                           ->setDate_identification($date_id->toString('yyyy-MM-dd'))
                           ->setCode_agence($code_agence)
               ->setCodesecret(md5($_POST["codesecret"]))
               ->setEtat_membre('A');
                     $mapper->save($membre);
                        
            
                            // Mise à jour de la table eu_ancien_membre
                              $p_mapper = new Application_Model_EuAncienMembreMapper();
                              $p = new Application_Model_EuAncienMembre();
                              $rep = $p_mapper->find($_POST["ancien_code_membre"],$p);
                              if ($rep == true) {      
                                 $p->setEtat_contrat(1)
                     ->setCode_membre($code);
                                 $p_mapper->update($p);      
                              }
               
               
               
          for($i = 0; $i < count($_POST['code_banque']); $i++){
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
              $cb_compteur = $cb_mapper->findConuter() + 1;         
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre($code)
                   ->setCode_membre_morale(NULL)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i])
                 ;
                            $cb_mapper->save($cb);
                    }
            
                        //Util_Utils::createCompte('NB-TPAGCRPG-' . $code, 'TPAGCRPG', 'TPAGCRPG', 0, $code, 'NB', $date_id, 0);
            // Mise à jour de la table eu_utilisateur
            
            $userin = new Application_Model_EuUtilisateur();
                        $mapper = new Application_Model_EuUtilisateurMapper();
                        $id_user = $mapper->findConuter() + 1;
                        $userin->setId_utilisateur($id_user)
                               ->setId_utilisateur_parent(NULL)
                               ->setPrenom_utilisateur($_POST["prenom_membre"])
                               ->setNom_utilisateur($_POST["nom_membre"])
                               ->setLogin($code)
                               ->setPwd(md5($_POST["codesecret"]))
                               ->setDescription(NULL)
                               ->setUlock(0)
                               ->setCh_pwd_flog(0)
                               ->setCode_groupe('personne_physique')
                     ->setCode_groupe_create('personne_physique')
                               ->setConnecte(0)
                               ->setCode_agence($code_agence)
                               ->setCode_secteur(NULL)
                               ->setCode_zone($code_zone)
                                 //->setCode_gac_filiere(NULL)
                           ->setId_pays($id_pays)       
                               ->setCode_acteur($code_acteur)
                     ->setCode_membre($code);    
                          $mapper->save($userin);
          
        
                  // Mise à jour de la table eu_contrat
                          $contrat = new Application_Model_EuContrat();
                      $mapper_contrat = new Application_Model_EuContratMapper();
                      $id_contrat = $mapper->findConuter() + 1;
                  $contrat->setId_contrat($id_contrat);
                          $contrat->setCode_membre($code);
                          $contrat->setDate_contrat($date_id->toString('yyyy-MM-dd'));
                          $contrat->setNature_contrat('numerique');
                          $contrat->setId_type_contrat(NULL);
                          $contrat->setId_type_creneau(NULL);
                          $contrat->setId_type_acteur(NULL);
                          $contrat->setId_pays(NULL);
                          $contrat->setId_utilisateur(NULL);
                          $contrat->setFiliere(NULL);
                          $mapper_contrat->save($contrat);
              
              
            $acteur = $code_acteur;
            $t_acteur = new Application_Model_DbTable_EuActeur();
                    $c_acteur = new Application_Model_EuActeur();
                    $count = $c_acteur->findConuter() + 1;
          $table = new Application_Model_DbTable_EuActeur();
          
          if(isset($_POST["actcmfh"])) { 
                       $select = $table->select();
             $select->where('code_acteur LIKE ?', $acteur);
             $resultSet = $table->fetchAll($select);
             $ligneacteur = $resultSet->current();
                       $c_acteur->setId_acteur($count);
                       $c_acteur->setCode_acteur(NULL);
                       $c_acteur->setCode_membre($code);
                       $c_acteur->setId_utilisateur(NULL);
                       $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
               $c_acteur->setCode_activite(NULL);
               $c_acteur->setCode_source_create($ligneacteur->code_source_create);
               $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
             $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
             $c_acteur->setId_pays($ligneacteur->id_pays);
             $c_acteur->setId_region($ligneacteur->id_region);
             $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
             $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                
                       $c_acteur->setType_acteur('CMFH');
               $c_acteur->setCode_gac_chaine($acteur);         
                       $t_acteur->insert($c_acteur->toArray());
             
          } else if(isset($_POST["actenro"])) { 
              $select = $table->select();
              $select->where('code_acteur LIKE ?', $acteur);
              $resultSet = $table->fetchAll($select);
              $ligneacteur = $resultSet->current();
                        $c_acteur->setId_acteur($count);
                        $c_acteur->setCode_acteur(NULL);
                        $c_acteur->setCode_membre($code);
                        $c_acteur->setId_utilisateur(NULL);
                        $c_acteur->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                $c_acteur->setCode_activite(NULL);
                $c_acteur->setCode_source_create($ligneacteur->code_source_create);
                $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
              $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
              $c_acteur->setId_pays($ligneacteur->id_pays);
              $c_acteur->setId_region($ligneacteur->id_region);
              $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
              $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
              $c_acteur->setType_acteur('DSMS');
                $c_acteur->setCode_gac_chaine($acteur);         

                        $t_acteur->insert($c_acteur->toArray());
          }
              
            $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
            $tafl = new Application_Model_DbTable_EuAncienFl();
                        $afl = new Application_Model_EuAncienFl();
                        $code_fl = 'FL-'.$_POST["ancien_code_membre"];
                        $result = $tafl->find($code_fl);
              
              //if (count($result) > 0) {
                 $code_afl = 'FL-'.$code;
               $mont_fl = Util_Utils::getParametre('FL','valeur'); 
               $fl->setCode_fl($code_afl)
                                ->setCode_membre($code)
                  ->setCode_membre_morale(NULL)
                                ->setMont_fl($mont_fl)
                                ->setDate_fl($date_id->toString('yyyy-MM-dd'))
                                ->setHeure_fl($date_id->toString('HH:mm:ss'))
                                ->setId_utilisateur(NULL)
                                ->setCreditcode(NULL);
                             $tfl->insert($fl->toArray());
                
               $tcartes[0]="TPAGCRPG";
                 $tcartes[1]="TCNCS";
               $tcartes[2]="TPaNu";
               $tcartes[3]="TPaR";
                 $tcartes[4]="TR";
               $tcartes[5]="CAPA";
                 $tcartes[6]="TRE";
               
               $tscartes[0]="TSRPG";
               $tscartes[1]="TSCNCS";
               $tscartes[2]="TSPaNu";
               $tscartes[3]="TSPaR";
               $tscartes[4]="TSCAPA";
			   $tscartes[5]="TSRE";
               
               for($i = 0; $i < count($tcartes); $i++) {
                if($tcartes[$i] == "TCNCS") {
                                    $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                  $type_carte = 'NR';
                  $res = $map_compte->find($code_compte,$compte);
                } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE") {
                                    $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                    $type_carte = 'NN';
                  $res = $map_compte->find($code_compte,$compte);
                } else  {
                    $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                    $type_carte = 'NB';
                  $res = $map_compte->find($code_compte,$compte);
                  }
                    
                if(!$res) {
                                  $compte->setCode_cat($tcartes[$i])
                                         ->setCode_compte($code_compte)
                                         ->setCode_membre($code)
                     ->setCode_membre_morale(NULL)
                                         ->setCode_type_compte($type_carte)
                                         ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                         ->setDesactiver(0)
                                         ->setLib_compte($tcartes[$i])
                                         ->setSolde(0);
                  $map_compte->save($compte); 
                }
                  
                            }
              
              
              for($j = 0; $j < count($tscartes); $j++) {
              
                  if($tscartes[$j] == "TSCNCS") {
                                    $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                    $type_carte = 'NR';
                    $res = $map_compte->find($code_comptets,$compte);
                } elseif($tscartes[$j] == "TR" || $tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSRE") {
                                    $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                  $type_carte = 'NN';
                  $res = $map_compte->find($code_comptets,$compte);
                } else {
                    $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                  $type_carte = 'NB';
                    $res = $map_compte->find($code_comptets,$compte);
                }
                    
                if(!$res) {
                                   $compte->setCode_cat($tscartes[$j])
                                          ->setCode_compte($code_comptets)
                                          ->setCode_membre($code)
                      ->setCode_membre_morale(NULL)
                                          ->setCode_type_compte($type_carte)
                                          ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                          ->setDesactiver(0)
                                          ->setLib_compte($tscartes[$j])
                                          ->setSolde(0);
                   $map_compte->save($compte);
                  
                  }
              
              } 
               
        
                $compteur=Util_Utils::findConuter() + 1;
                          Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP! Votre numero de membre est: " . $code ."  Votre Code Secret est : " .$_POST["codesecret"]); 
                          $db->commit();
                          //Redirection sur le formulaire du contrat
                          //return $this->_helper->redirector('newpp', 'eu-contrat', NULL, array('controller' => 'eu-contrat', 'action' => 'newpp', 'membre' => $code, 'type' => 'P'));
              //return $this->_helper->redirector('index');      
         } catch (Exception $exc) {
                   $db->rollback();
                   $this->view->nom = $_POST["nom_membre"];
                   $this->view->prenom = $_POST["prenom_membre"];
                   $this->view->sexe = $_POST["sexe_membre"];
                   $this->view->sitmatr = $_POST["sitfam_membre"];
                   $this->view->datenais = $_POST["date_nais_membre"];
                   $this->view->nation = $_POST["nationalite_membre"];
                   $this->view->lieu_nais = $_POST["lieu_nais_membre"];
                   $this->view->nbre_enf = $_POST["nbr_enf_membre"];
                   $this->view->formation = $_POST["formation"];
                   $this->view->prof = $_POST["profession_membre"];
                   $this->view->religion = $_POST["religion_membre"];
                   $this->view->pere = $_POST["pere_membre"];
                   $this->view->mere = $_POST["mere_membre"];

                   $this->view->quartier_membre = $_POST["quartier_membre"];
                   $this->view->ville_membre = $_POST["ville_membre"];
                   $this->view->bp = $_POST["bp_membre"];
                   $this->view->tel = $_POST["tel_membre"];
                   $this->view->email = $_POST["email_membre"];
                   $this->view->portable = $_POST["portable_membre"];
                   $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
           }
          

/*          */          

      $sessionmcnp->errorlogin = "Ré-activation du compte marchant membre personne physique bien effectuée ...";
    $this->_redirect('/index/ancienppmcnp');
    //$this->_redirect('/');
    } else {  $this->view->message = "Champs * obligatoire ...";  } 
    } else {
      
            $id = (string)$this->_request->getParam('id');
      
        $tabela = new Application_Model_DbTable_EuAncienMembre();
       $select = $tabela->select();
           $select->from($tabela,array('eu_ancien_membre.*',"date_nais_membre as datenaismembre"))
                  ->where('ancien_code_membre LIKE ?', '%'.$id.'%')
          ->where('etat_contrat != 1');       
    $memb = $tabela->fetchAll($select);
    $trouvmembre = $memb->current();
      
$this->view->ancien_code_membre = $trouvmembre->ancien_code_membre;
$this->view->nom_membre = $trouvmembre->nom_membre;
$this->view->prenom_membre = $trouvmembre->prenom_membre;
$this->view->sexe = $trouvmembre->sexe_membre;
$this->view->profession = $trouvmembre->profession_membre;
$this->view->tel = $trouvmembre->tel_membre;
$this->view->ville_membre = $trouvmembre->ville_membre; 
$this->view->pere = $trouvmembre->pere_membre;
$this->view->mere = $trouvmembre->mere_membre;
$this->view->quartier_membre = $trouvmembre->quartier_membre;
$this->view->bp = $trouvmembre->bp_membre;
$this->view->nbre_enf = $trouvmembre->nbr_enf_membre;
$this->view->email = $trouvmembre->email_membre;
$this->view->portable = $trouvmembre->portable_membre;
$this->view->formation = $trouvmembre->formation;
$this->view->lieu_nais = $trouvmembre->lieu_nais_membre;
$this->view->datnais = $trouvmembre->datenaismembre;
$this->view->sitfam = $trouvmembre->sitfam_membre;
$this->view->nation = $trouvmembre->id_pays;
$this->view->religion = $trouvmembre->id_religion_membre;

      }
    
    }





    public function ancienpmAction()
    {
        /* page index/ancienpm - Retrouve ancienne personne morale GIE/ReDeMaRe */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
    
           $tabela = new Application_Model_DbTable_Morale();
           $select=$tabela->select();
           $select->from($tabela)
                  ->where('numidentm like ?', '%'.$_POST['code_membre'].'%')
            ->where('etat_contrat != 1')
                ->order('nomm ASC');
    $memb = $tabela->fetchAll($select);
    if(count($memb) > 0){
    $trouvmembre = $memb->current();      
      
    $this->_redirect('/index/ancienpmedit/id/'.$trouvmembre->numidentm);
    } else {  $this->view->message = "Pas de resultat ...";}
    } else {  $this->view->message = "Champs * obligatoire ...";}
       
  } 
  }




    public function ancienpmeditAction()
    {
        /* page index/ancienpmedit - Mise sur chaine ancienne personne morale GIE/ReDeMaRe */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    


    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if (isset($_POST['code_type_acteur']) && $_POST['code_type_acteur']!="" && isset($_POST['raison_sociale']) && $_POST['raison_sociale']!="" && isset($_POST['num_registre_membre']) && $_POST['num_registre_membre']!="" && isset($_POST['code_statut']) && $_POST['code_statut']!="" && isset($_POST['code_rep']) && $_POST['code_rep']!="" && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {

$offres_mapper = new Application_Model_EuAppeloffresMapper();
$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
$agrement_mapper = new Application_Model_EuAgrementMapper();
$licence_mapper = new Application_Model_EuLicenceMapper();

if($trouveagrementfiliere = $agrement_mapper->findagrementfiliere($_POST["numero_agrement_filiere"]) && $trouveagrementacnev = $agrement_mapper->findagrementacnev($_POST["numero_agrement_acnev"]) && $trouveagrementtechno = $agrement_mapper->findagrementtechno($_POST["numero_agrement_technopole"])){

               $utilisateur = NULL;
           //$groupe = $user->code_groupe;
$code_agence = $_POST['code_agence'];
$code_zone = substr($_POST['code_agence'], 0, 3);
$id_pays = $_POST['id_pays'];
$groupe = NULL;
         $table = new Application_Model_DbTable_EuActeur();
         $selection = $table->select();
         $selection->where('code_membre LIKE ?',$code_agence.'%');
         $selection->where('type_acteur LIKE ?','gac_surveillance');
         $resultat = $table->fetchAll($selection);
         $trouvacteursur = $resultat->current();
         $code_acteur = $trouvacteursur->code_acteur;
           $acteur      =  $code_acteur;
           
               $fs = Util_Utils::getParametre('FS','valeur');
         $mont_fl = Util_Utils::getParametre('FL','valeur');
         $fcps = Util_Utils::getParametre('FCPS','valeur');
           
         $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               //$code_fs = $_POST["code_fs"];
         //$code_fl = $_POST["code_fl"];
         //$code_fkps = $_POST["code_fkps"];
         
           
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;
         
        $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
        try {
        
             $agrement_mapper = new Application_Model_EuAgrementMapper();
             $agrement        = new Application_Model_EuAgrement();
           
           $agrement_filiere  =  $_POST["numero_agrement_filiere"];
                   $agrement_acnev    =  $_POST["numero_agrement_acnev"];
                   $agrement_technopole =  $_POST["numero_agrement_technopole"];
           
           //insertion dans la table membremorale des information du nouveau membre
                   $membre = new Application_Model_EuMembreMorale();
                   $mapper = new Application_Model_EuMembreMoraleMapper();
           $membre1 = new Application_Model_EuMembreMorale();
                   $mapper1 = new Application_Model_EuMembreMoraleMapper();
                   $code = $mapper->getLastCodeMembreByAgence($code_agence);
                   if ($code == NULL) {
                      $code = $code_agence . '0000001' . 'M';
                   } else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'M';
                   }
           
           //insertion dans la table eu_operation
                   $mapper_op = new Application_Model_EuOperationMapper();
                   $compteur = $mapper_op->findConuter() + 1;
            
                        
                        $trouveagrementfiliere = $agrement_mapper->findagrementfiliere($agrement_filiere);
                        $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
                        $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
            
            
           
           if($trouveagrementfiliere != FALSE) {
              $result = $agrement_mapper->find($trouveagrementfiliere->getId_agrement(),$agrement);
			  
							$id_type_acteur = $agrement->getId_type_acteur();
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_filiere = $agrement->getId_filiere();

              $agrement->setCode_membre_morale($code);
              $agrement_mapper->update($agrement);
            
            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
            $membre->setId_filiere($id_filiere);
            $membre->setCode_membre_morale($code);
                      $membre->setCode_type_acteur($_POST["code_type_acteur"]);
                      $membre->setCode_statut($_POST["code_statut"]);
                      $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
            $membre->setId_pays($_POST["id_pays"]);
                      $membre->setNum_registre_membre($_POST["num_registre_membre"]);
                      $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                      $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                      $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                      $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                      $membre->setBp_membre($_POST["bp_membre"]);
                      $membre->setTel_membre($_POST["tel_membre"]);
                      $membre->setEmail_membre($_POST["email_membre"]);
                      $membre->setPortable_membre($_POST["portable_membre"]);
                      $membre->setId_utilisateur($utilisateur);
                      $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                      $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                      $membre->setCode_agence($code_agence);
                      $membre->setCodesecret(md5($_POST["codesecret"]));
                      $membre->setAuto_enroler('O');
            $membre->setEtat_membre('A');
              $mapper->save($membre);
            
            
            // eu_acteurs_creneau
            $cm = new Application_Model_EuActeurCreneauMapper();
                      $acren = new Application_Model_EuActeurCreneau();
              
            $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                      $acren->setCode_membre($code);
            $acren->setId_type_acteur($id_type_acteur);
            
            //$acren->setCode_activite(NULL);
                      $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                      $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                      $acren->setId_utilisateur($utilisateur);
            $acren->setGroupe($groupe);
            $acren->setCode_creneau(NULL);
                      $acren->setCode_gac_filiere(NULL);
                      $acren->setCode_gac(NULL);
              
              
            $code_zone = $code_zone;
                $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                      if ($code_acteur == NULL) {
                        $code_acteur = 'A' . $code_zone . '0001';
                      } else {
                        $num_ordre = substr($code_acteur, -4);
                        $num_ordre++;
                        $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                      }
            
            $acren->setCode_acteur($code_acteur);
            $acren->setId_filiere($id_filiere);
            $cm->save($acren);  
            $fs = Util_Utils::getParametre('FS','valeur');  
              // eu_operation
                      Util_Utils::addOperation($compteur,NULL,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), NULL);
             
            //insertion dans la table eu_representation
            $rep_mapper = new Application_Model_EuRepresentationMapper();
                      $rep = new Application_Model_EuRepresentation();
            $rep->setCode_membre_morale($code)
                          ->setCode_membre($_POST['code_rep'])
                          ->setTitre("Representant")
              ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
              ->setId_utilisateur(NULL)
              ->setEtat('inside');
                      $rep_mapper->save($rep);
            
              //insertion dans la table eu_compte_bancaire
                    for($i = 0; $i < count($_POST['code_banque']); $i++){
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
              $cb_compteur = $cb_mapper->findConuter() + 1;         
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre(NULL)
                   ->setCode_membre_morale($code)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i])
                 ;
                            $cb_mapper->save($cb);
                    }
          
           } else {
             $db->rollBack();
             $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
             $this->view->type_acteur = $_POST["code_type_acteur"];
                     $this->view->statut_juridique = $_POST["code_statut"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre_membre"];
                     return;
           }
           
           if($trouveagrementacnev != FALSE) {
             $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
             $agrement->setCode_membre_morale($code);
             $agrement_mapper->update($agrement);     
            } else {
             $db->rollBack();
             $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
             $this->view->type_acteur = $_POST["code_type_acteur"];
                     $this->view->statut_juridique = $_POST["code_statut"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre_membre"];
                     return;
            }
          
          
          if($trouveagrementtechno != FALSE) {
              $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
              $agrement->setCode_membre_morale($code);
              $agrement_mapper->update($agrement);      
            } else {
              $db->rollBack();
              $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
             $this->view->type_acteur = $_POST["code_type_acteur"];
                     $this->view->statut_juridique = $_POST["code_statut"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre_membre"];
                      return;
           } 
           
           $filiere =  new Application_Model_EuFiliere();
           $map_filiere = new Application_Model_EuFiliereMapper();
           $find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
           $t_acteur = new Application_Model_DbTable_EuActeur();
           $c_acteur = new Application_Model_EuActeur();
           $table = new Application_Model_DbTable_EuActeur();
                   $select = $table->select();
           $select->where('code_acteur LIKE ?', $acteur);
           $resultSet = $table->fetchAll($select);
           $ligneacteur = $resultSet->current();
           $count = $c_acteur->findConuter() + 1;
                   $c_acteur->setId_acteur($count)
                            ->setCode_acteur(NULL)
              ->setCode_division($filiere->getCode_division())
                            ->setCode_membre($code)
                            ->setId_utilisateur($utilisateur)
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
              
                                if($trouveagrementfiliere->id_type_acteur == 3) {
                      $c_acteur->setCode_activite('detaillant');
            $c_acteur->setCode_source_create($ligneacteur->code_source_create);
            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
              $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
            $c_acteur->setId_pays($ligneacteur->id_pays);
            $c_acteur->setId_region($ligneacteur->id_region);
            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                } else if($trouveagrementfiliere->id_type_acteur == 2) {
                      $c_acteur->setCode_activite('semi-grossiste');
              $c_acteur->setCode_source_create($ligneacteur->code_source_create);
            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
            $c_acteur->setId_pays($ligneacteur->id_pays);
            $c_acteur->setId_region($ligneacteur->id_region);
            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                                } else if($trouveagrementfiliere->id_type_acteur == 1) {
                      $c_acteur->setCode_activite('grossiste');
            $c_acteur->setCode_source_create($ligneacteur->code_source_create);
            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
            $c_acteur->setId_pays($ligneacteur->id_pays);
            $c_acteur->setId_region($ligneacteur->id_region);
            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                }
                      $c_acteur->setType_acteur('DSMS');
                      $c_acteur->setCode_gac_chaine($acteur);
                      $t_acteur->insert($c_acteur->toArray());
            //R�cup�ration de la PRK nr
                      $param = new Application_Model_EuParametresMapper();
                      $par = new Application_Model_EuParametres();
                      $prc = 0;
                      $par_prc = $param->find('prc', 'nr', $par);
                      if ($par_prc == true) {
                         $prc = $par->getMontant();
                      }
             
            $te_mapper = new Application_Model_EuTegcMapper();
                      $te = new Application_Model_EuTegc();
                      $code_te = 'TEGCP' .$membre1->getId_filiere(). $code;
                      $find_te = $te_mapper->find($code_te,$te);
                      if ($find_te == false) {
                         $te->setCode_tegc($code_te)
                            ->setId_filiere($membre1->getId_filiere())
                            ->setMdv($prc)
                            ->setCode_membre($code)
                            ->setMontant(0)
              ->setMontant_utilise(0)
              ->setSolde_tegc(0);
                          $te_mapper->save($te);
                       } else {
                          $te->setId_filiere($id_filiere);
                          $te->setMdv($prc);
                          $te_mapper->update($te);
                       }
                
          // table EU_UTILISATEUR
          $user_mapper = new Application_Model_EuUtilisateurMapper();
                    $userin = new Application_Model_EuUtilisateur();
                    $membre_mapper = new Application_Model_EuMembreMapper();
                $membrein = new Application_Model_EuMembre();         
          $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
          $id_user = $user_mapper->findConuter() + 1;
          
                    $userin->setId_utilisateur($id_user);
                    $userin->setId_utilisateur_parent($utilisateur); 
                    $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                    $userin->setNom_utilisateur($membrein->getNom_membre());
                    $userin->setLogin($code);
                    $userin->setPwd(md5($_POST["codesecret"]));
                    $userin->setDescription(NULL);
                    $userin->setUlock(0);
                    $userin->setCh_pwd_flog(0);

                                if($trouveagrementfiliere->id_type_acteur == 3) {
                          $userin->setCode_groupe('oe_detaillant');
                          $userin->setCode_gac_filiere('oe_detaillant');
              $userin->setCode_groupe_create('oe_detaillant');
                } else if($trouveagrementfiliere->id_type_acteur == 2) {
                          $userin->setCode_groupe('oe_semi_grossiste');
                          $userin->setCode_gac_filiere(NULL);
              $userin->setCode_groupe_create('oe_semi_grossiste');
                                } else if($trouveagrementfiliere->id_type_acteur == 1) {
                          $userin->setCode_groupe('oe_grossiste');
                          $userin->setCode_gac_filiere(NULL);
              $userin->setCode_groupe_create('oe_grossiste');
                }
          
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(NULL);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
                    
            $userin->setCode_acteur($acteur);
          
          $userin->setCode_membre($code);
                $userin->setId_pays($id_pays);        
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
          $contrat = new Application_Model_EuContrat();
            $mapper_contrat = new Application_Model_EuContratMapper();
            $id_contrat = $mapper_contrat->findConuter() + 1;
          
          $contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(NULL);
            $contrat->setId_type_contrat(3);
                        $contrat->setId_type_creneau($id_type_creneau);
            
                       $contrat->setId_type_acteur($id_type_acteur);

                    $contrat->setId_pays($id_pays);
                    $contrat->setId_utilisateur(NULL);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
          
          //Mise à jour de la table morale
                    $m_mapper = new Application_Model_MoraleMapper();
                    $m = new Application_Model_Morale();
                    $rep = $m_mapper->find($_POST["numidentm"],$m);
                    if ($rep == true) {
                       $m->setEtat_contrat(1)
                 ->setCode_membre($code);
                       $m_mapper->update($m);
                    }
          $compteur = Util_Utils::findConuter() + 1;
                    Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                $db->commit();
                //return $this->_helper->redirector('morale', 'eu-membre', NULL, array('controller' => 'eu-membre-ancien', 'action' => 'morale'));
        } catch (Exception $exc) {
             $db->rollback();
             $this->view->type_acteur = $_POST["code_type_acteur"];
                     $this->view->statut_juridique = $_POST["code_statut"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre_membre"];
             $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                   return;
              }
      
          

/*          */          

      $sessionmcnp->errorlogin = "Ré-activation du compte marchant membre personne morale bien effectuée ... ...";
    $this->_redirect('/index/ancienpm');
    //$this->_redirect('/');
    } else {  $this->view->message = "Vérifier bien les numéros agréments...";  } 
    } else {  $this->view->message = "Champs * obligatoire ...";  } 
    } else {
      
            $id = (string)$this->_request->getParam('id');
      
           $tabela = new Application_Model_DbTable_Morale();
           $select=$tabela->select();
           $select->from($tabela)
                  ->where('numidentm like ?', '%'.$id.'%')
            ->where('etat_contrat != 1')
                ->order('nomm ASC');
    $memb = $tabela->fetchAll($select);
    $trouvmembre = $memb->current();
      
$this->view->numidentm = $trouvmembre->numidentm;
$this->view->raison = $trouvmembre->nomm;
$this->view->code_rep = $trouvmembre->representant;
$this->view->quartier_membre = $trouvmembre->qart;
$this->view->ville_membre = $trouvmembre->ville;
$this->view->bp = $trouvmembre->bp;
$this->view->tel = $trouvmembre->tel;
$this->view->portable = $trouvmembre->portable;
$this->view->email = $trouvmembre->email;
$this->view->site_web = $trouvmembre->site;   
      }
    
    }


      







    public function ancienpmmcnpAction()
    {
        /* page index/ancienpmmcnp - Retrouve ancienne personne morale MCNP */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
    
           $tabela = new Application_Model_DbTable_EuAncienMembre();
       $select = $tabela->select();
           $select->from($tabela,array('eu_ancien_membre.*',"date_identification as dateidentif"))
                  ->where('ancien_code_membre LIKE ?', '%'.$_POST['code_membre'].'%')
          ->where('etat_contrat != 1');        
    $memb = $tabela->fetchAll($select);
    if(count($memb) > 0){
    $trouvmembre = $memb->current();      
      
    $this->_redirect('/index/ancienpmmcnpedit/id/'.$trouvmembre->ancien_code_membre);
    } else {  $this->view->message = "Pas de resultat ...";}
    } else {  $this->view->message = "Champs * obligatoire ...";}
       
  } 
  }




    public function ancienpmmcnpeditAction()
    {
        /* page index/ancienpmmcnpedit - Mise sur chaine ancienne personne morale MCNP */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    


    if(isset($_POST['ok']) && $_POST['ok']=="ok"){
  if (isset($_POST['code_type_acteur']) && $_POST['code_type_acteur']!="" && isset($_POST['raison_sociale']) && $_POST['raison_sociale']!="" && isset($_POST['num_registre_membre']) && $_POST['num_registre_membre']!="" && isset($_POST['code_statut']) && $_POST['code_statut']!="" && isset($_POST['code_rep']) && $_POST['code_rep']!="" && isset($_POST['quartier_membre']) && $_POST['quartier_membre']!="" && isset($_POST['ville_membre']) && $_POST['ville_membre']!="" && isset($_POST['portable_membre']) && $_POST['portable_membre']!="" && isset($_POST['id_pays']) && $_POST['id_pays']!="" && isset($_POST['code_agence']) && $_POST['code_agence']!="") {

$offres_mapper = new Application_Model_EuAppeloffresMapper();
$smsmoneyM = new Application_Model_EuSmsmoneyMapper();
$agrement_mapper = new Application_Model_EuAgrementMapper();
$licence_mapper = new Application_Model_EuLicenceMapper();

if($trouveagrementfiliere = $agrement_mapper->findagrementfiliere($_POST["numero_agrement_filiere"]) && $trouveagrementacnev = $agrement_mapper->findagrementacnev($_POST["numero_agrement_acnev"]) && $trouveagrementtechno = $agrement_mapper->findagrementtechno($_POST["numero_agrement_technopole"])){

               $utilisateur = NULL;
           //$groupe = $user->code_groupe;
$code_agence = $_POST['code_agence'];
$code_zone = substr($_POST['code_agence'], 0, 3);
$id_pays = $_POST['id_pays'];
$groupe = NULL;
         $table = new Application_Model_DbTable_EuActeur();
         $selection = $table->select();
         $selection->where('code_membre LIKE ?',$code_agence.'%');
         $selection->where('type_acteur LIKE ?','gac_surveillance');
         $resultat = $table->fetchAll($selection);
         $trouvacteursur = $resultat->current();
         $code_acteur = $trouvacteursur->code_acteur;
           $acteur      =  $code_acteur;
           
               $fs = Util_Utils::getParametre('FS','valeur');
         $mont_fl = Util_Utils::getParametre('FL','valeur');
         $fcps = Util_Utils::getParametre('FCPS','valeur');
           
         $date_id = new Zend_Date(Zend_Date::ISO_8601);
               $date_idd = clone $date_id;
               //$code_fs = $_POST["code_fs"];
         //$code_fl = $_POST["code_fl"];
         //$code_fkps = $_POST["code_fkps"];
               $sms_mapper = new Application_Model_EuSmsmoneyMapper();
         
           
           
        $date_id = new Zend_Date(Zend_Date::ISO_8601);
              $date_idd = clone $date_id;
         
        $db = Zend_Db_Table::getDefaultAdapter();
              $db->beginTransaction();
        try {
            $agrement_mapper = new Application_Model_EuAgrementMapper();
            $agrement        = new Application_Model_EuAgrement();
          $compte = new Application_Model_EuCompte();
                  $map_compte = new Application_Model_EuCompteMapper();
           
          $agrement_filiere  =  $_POST["numero_agrement_filiere"];
                  $agrement_acnev    =  $_POST["numero_agrement_acnev"];
                  $agrement_technopole =  $_POST["numero_agrement_technopole"];
          $code_agence = $code_agence;
          $fs = Util_Utils::getParametre('FS', 'valeur');
           
          //insertion dans la table membremorale des information du nouveau membre
                   $membre = new Application_Model_EuMembreMorale();
                   $mapper = new Application_Model_EuMembreMoraleMapper();
           $membre1 = new Application_Model_EuMembreMorale();
                   $mapper1 = new Application_Model_EuMembreMoraleMapper();
                   $code = $mapper->getLastCodeMembreByAgence($code_agence);
                   if ($code == NULL) {
                      $code = $code_agence . '0000001' . 'M';
                   } else {
                      $num_ordre = substr($code, 12, 7);
                      $num_ordre++;
                      $num_ordre_bis = str_pad($num_ordre, 7, 0, STR_PAD_LEFT);
                      $code = $code_agence . $num_ordre_bis . 'M';
                   }
           
           //insertion dans la table eu_operation
                   $mapper_op = new Application_Model_EuOperationMapper();
                   $compteur = $mapper_op->findConuter() + 1;
            
           $trouveagrementfiliere = $agrement_mapper->findagrementfiliere($agrement_filiere);
           $trouveagrementacnev = $agrement_mapper->findagrementacnev($agrement_acnev);
           $trouveagrementtechno = $agrement_mapper->findagrementtechno($agrement_technopole);
           
           if($trouveagrementfiliere != FALSE) {
              $result = $agrement_mapper->find($trouveagrementfiliere->getId_agrement(),$agrement);
			  
							$id_type_acteur = $agrement->getId_type_acteur();
							$id_type_creneau = $agrement->getId_type_creneau();
							$id_filiere = $agrement->getId_filiere();

              $agrement->setCode_membre_morale($code);
              $agrement_mapper->update($agrement);
            
            $resmembre = $mapper1->find($agrement->getCode_membre_morale_agrement(),$membre1);
            $membre->setId_filiere($id_filiere);
            $membre->setCode_membre_morale($code);
                      $membre->setCode_type_acteur($_POST["code_type_acteur"]);
                      $membre->setCode_statut($_POST["code_statut"]);
                      $membre->setRaison_sociale(addslashes (trim ($_POST["raison_sociale"])));
            $membre->setId_pays($_POST["id_pays"]);
                      $membre->setNum_registre_membre($_POST["num_registre_membre"]);
                      $membre->setDomaine_activite(addslashes (trim ($_POST["domaine_activite"])));
                      $membre->setSite_web(addslashes (trim ($_POST["site_web"])));
                      $membre->setQuartier_membre(addslashes (trim ($_POST["quartier_membre"])));
                      $membre->setVille_membre(addslashes (trim ($_POST["ville_membre"])));
                      $membre->setBp_membre($_POST["bp_membre"]);
                      $membre->setTel_membre($_POST["tel_membre"]);
                      $membre->setEmail_membre($_POST["email_membre"]);
                      $membre->setPortable_membre($_POST["portable_membre"]);
                      $membre->setId_utilisateur($utilisateur);
                      $membre->setHeure_identification($date_idd->toString('HH:mm:ss'));
                      $membre->setDate_identification($date_idd->toString('yyyy-MM-dd'));
                      $membre->setCode_agence($code_agence);
                      $membre->setCodesecret(md5($_POST["codesecret"]));
                      $membre->setAuto_enroler('O');
            $membre->setEtat_membre('A');
              $mapper->save($membre);
            
            
            // eu_acteurs_creneau
            $cm = new Application_Model_EuActeurCreneauMapper();
                      $acren = new Application_Model_EuActeurCreneau();
              
            $acren->setNom_acteur(addslashes (trim ($_POST["raison_sociale"])));
                      $acren->setCode_membre($code);
                 $acren->setId_type_acteur($id_type_acteur);
            
            //$acren->setCode_activite(NULL);
                      $acren->setCode_membre_gestionnaire($_POST['code_rep']);
                      $acren->setDate_creation($date_idd->toString('yyyy-MM-dd'));
                      $acren->setId_utilisateur($utilisateur);
            $acren->setGroupe($groupe);
            $acren->setCode_creneau(NULL);
                      $acren->setCode_gac_filiere(NULL);
                      $acren->setCode_gac(NULL);
              
              
            $code_zone = $code_zone;
                $code_acteur = $cm->getLastActeurByCrenau($code_zone);
                      if ($code_acteur == NULL) {
                        $code_acteur = 'A' . $code_zone . '0001';
                      } else {
                        $num_ordre = substr($code_acteur, -4);
                        $num_ordre++;
                        $code_acteur = 'A' . $code_zone . str_pad($num_ordre, 4, 0, STR_PAD_LEFT);
                      }
            
            $acren->setCode_acteur($code_acteur);
            $acren->setId_filiere($id_filiere);
            $cm->save($acren);  
              
              // eu_operation
                      Util_Utils::addOperation($compteur,NULL,$code,'TFS', $fs, 'FS', 'Auto-enrôlement', 'AERL', $date_idd->toString('yyyy-MM-dd'), $date_idd->toString('HH:mm:ss'), NULL);
             
            //insertion dans la table eu_representation
            $rep_mapper = new Application_Model_EuRepresentationMapper();
                      $rep = new Application_Model_EuRepresentation();
            $rep->setCode_membre_morale($code)
                          ->setCode_membre($_POST['code_rep'])
                          ->setTitre("Representant")
              ->setDate_creation($date_idd->toString('yyyy-MM-dd'))
              ->setId_utilisateur(NULL)
              ->setEtat('inside');
                      $rep_mapper->save($rep);
            
              //insertion dans la table eu_compte_bancaire
                    for($i = 0; $i < count($_POST['code_banque']); $i++){
                    $cb_mapper = new Application_Model_EuCompteBancaireMapper();
                    $cb = new Application_Model_EuCompteBancaire();
              $cb_compteur = $cb_mapper->findConuter() + 1;         
                            $cb->setCode_banque($_POST['code_banque'][$i])
                               ->setId_compte($cb_compteur)
                               ->setCode_membre(NULL)
                   ->setCode_membre_morale($code)
                               ->setNum_compte_bancaire($_POST['num_compte'][$i])
                 ;
                            $cb_mapper->save($cb);
                    }

           } else {
             $db->rollBack();
             $this->view->message = " Le numéro agrément de la filière est invalide ou est déjà utilisé";
             $this->view->type_acteur = $_POST["code_type_acteur"];
                     $this->view->statut_juridique = $_POST["code_statut"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre_membre"];
                     return;
           }
           
           if($trouveagrementacnev != FALSE) {
             $result = $agrement_mapper->find($trouveagrementacnev->getId_agrement(),$agrement);
             $agrement->setCode_membre_morale($code);
             $agrement_mapper->update($agrement);     
            } else {
             $db->rollBack();
             $this->view->message = " Le numéro agrément de l'acnev est invalide ou est déjà utilisé";
             $this->view->type_acteur = $_POST["code_type_acteur"];
                     $this->view->statut_juridique = $_POST["code_statut"];
                     $this->view->raison = $_POST["raison_sociale"];
                     $this->view->domaine_activite = $_POST["domaine_activite"];
                     $this->view->site_web = $_POST["site_web"];
                     $this->view->quartier_membre = $_POST["quartier_membre"];
                     $this->view->ville_membre = $_POST["ville_membre"];
                     $this->view->bp = $_POST["bp_membre"];
                     $this->view->tel = $_POST["tel_membre"];
                     $this->view->email = $_POST["email_membre"];
                     $this->view->portable = $_POST["portable_membre"];
                     $this->view->registre = $_POST["num_registre_membre"];
                     return;
            }
          
          
          if($trouveagrementtechno != FALSE) {
              $result = $agrement_mapper->find($trouveagrementtechno->getId_agrement(),$agrement);
              $agrement->setCode_membre_morale($code);
              $agrement_mapper->update($agrement);      
            } else {
              $db->rollBack();
              $this->view->message = " Le numéro agrément de la technopole est invalide ou est déjà utilisé";
              $this->view->type_acteur = $_POST["code_type_acteur"];
                      $this->view->statut_juridique = $_POST["code_statut"];
                      $this->view->raison = $_POST["raison_sociale"];
                      $this->view->domaine_activite = $_POST["domaine_activite"];
                      $this->view->site_web = $_POST["site_web"];
                      $this->view->quartier_membre = $_POST["quartier_membre"];
                      $this->view->ville_membre = $_POST["ville_membre"];
                      $this->view->bp = $_POST["bp_membre"];
                      $this->view->tel = $_POST["tel_membre"];
                      $this->view->email = $_POST["email_membre"];
                      $this->view->portable = $_POST["portable_membre"];
                      $this->view->registre = $_POST["num_registre_membre"];
                      return;
           } 
           
           $filiere =  new Application_Model_EuFiliere();
           $map_filiere = new Application_Model_EuFiliereMapper();
           $find_filiere = $map_filiere->find($membre1->getId_filiere(),$filiere);
           
           $t_acteur = new Application_Model_DbTable_EuActeur();
           $c_acteur = new Application_Model_EuActeur();
           $table = new Application_Model_DbTable_EuActeur();
                   $select = $table->select();
           $select->where('code_acteur LIKE ?', $acteur);
           $resultSet = $table->fetchAll($select);
           $ligneacteur = $resultSet->current();
           $count = $c_acteur->findConuter() + 1;
                   $c_acteur->setId_acteur($count)
                            ->setCode_acteur(NULL)
              ->setCode_division($filiere->getCode_division())
                            ->setCode_membre($code)
                            ->setId_utilisateur($utilisateur)
                            ->setDate_creation($date_idd->toString('yyyy-MM-dd'));
              
                   if($trouveagrementfiliere->id_type_acteur == 3) {
                      $c_acteur->setCode_activite('detaillant');
            $c_acteur->setCode_source_create($ligneacteur->code_source_create);
            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
              $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
            $c_acteur->setId_pays($ligneacteur->id_pays);
            $c_acteur->setId_region($ligneacteur->id_region);
            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                   } elseif($trouveagrementfiliere->id_type_acteur == 2) {
                      $c_acteur->setCode_activite('semi-grossiste');
              $c_acteur->setCode_source_create($ligneacteur->code_source_create);
            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
            $c_acteur->setId_pays($ligneacteur->id_pays);
            $c_acteur->setId_region($ligneacteur->id_region);
            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                    } elseif($trouveagrementfiliere->id_type_acteur == 1) {
                      $c_acteur->setCode_activite('grossiste');
            $c_acteur->setCode_source_create($ligneacteur->code_source_create);
            $c_acteur->setCode_monde_create($ligneacteur->code_monde_create);
            $c_acteur->setCode_zone_create($ligneacteur->code_zone_create);
            $c_acteur->setId_pays($ligneacteur->id_pays);
            $c_acteur->setId_region($ligneacteur->id_region);
            $c_acteur->setCode_secteur_create($ligneacteur->code_secteur_create);
            $c_acteur->setCode_agence_create($ligneacteur->code_agence_create);
                    }
                      $c_acteur->setType_acteur('DSMS');
                      $c_acteur->setCode_gac_chaine($acteur);
                      $t_acteur->insert($c_acteur->toArray());
            //R�cup�ration de la PRK nr
                      $param = new Application_Model_EuParametresMapper();
                      $par = new Application_Model_EuParametres();
                      $prc = 0;
                      $par_prc = $param->find('prc', 'nr', $par);
                      if ($par_prc == true) {
                         $prc = $par->getMontant();
                      }
             
            $te_mapper = new Application_Model_EuTegcMapper();
                      $te = new Application_Model_EuTegc();
                      $code_te = 'TEGCP' .$membre1->getId_filiere(). $code;
                      $find_te = $te_mapper->find($code_te,$te);
                      if ($find_te == false) {
                         $te->setCode_tegc($code_te)
                            ->setId_filiere($membre1->getId_filiere())
                            ->setMdv($prc)
                            ->setCode_membre($code)
                            ->setMontant(0)
              ->setMontant_utilise(0)
              ->setSolde_tegc(0);
                          $te_mapper->save($te);
                       } else {
                          $te->setId_filiere($id_filiere);
                          $te->setMdv($prc);
                          $te_mapper->update($te);
                       }
                
                // table EU_UTILISATEUR
                $user_mapper = new Application_Model_EuUtilisateurMapper();
                $userin = new Application_Model_EuUtilisateur();
                $membre_mapper = new Application_Model_EuMembreMapper();
                $membrein = new Application_Model_EuMembre();         
                $find_membre = $membre_mapper->find($_POST['code_rep'],$membrein);
                $id_user = $user_mapper->findConuter() + 1;
          
                $userin->setId_utilisateur($id_user);
                $userin->setId_utilisateur_parent($utilisateur); 
                $userin->setPrenom_utilisateur($membrein->getPrenom_membre());
                $userin->setNom_utilisateur($membrein->getNom_membre());
                $userin->setLogin($code);
                $userin->setPwd(md5($_POST["codesecret"]));
                $userin->setDescription(NULL);
                $userin->setUlock(0);
                $userin->setCh_pwd_flog(0);

                if($trouveagrementfiliere->id_type_acteur == 3) {
                    $userin->setCode_groupe('oe_detaillant');
                    $userin->setCode_gac_filiere('oe_detaillant');
                    $userin->setCode_groupe_create('oe_detaillant');
                } elseif($trouveagrementfiliere->id_type_acteur == 2) {
                    $userin->setCode_groupe('oe_semi_grossiste');
                    $userin->setCode_gac_filiere(NULL);
                    $userin->setCode_groupe_create('oe_semi_grossiste');
                } elseif($trouveagrementfiliere->id_type_acteur == 1) {
                    $userin->setCode_groupe('oe_grossiste');
                    $userin->setCode_gac_filiere(NULL);
                    $userin->setCode_groupe_create('oe_grossiste');
                }
                    $userin->setConnecte(0);
                    $userin->setCode_agence($code_agence);
                    $userin->setCode_secteur(NULL);
                    $userin->setCode_zone($code_zone);
                    $userin->setId_filiere($id_filiere);
                    
            $userin->setCode_acteur($acteur);
          
          $userin->setCode_membre($code);
                $userin->setId_pays($id_pays);        
                    $user_mapper->save($userin);

                    // Mise à jour de la table eu_contrat
          $contrat = new Application_Model_EuContrat();
            $mapper_contrat = new Application_Model_EuContratMapper();
            $id_contrat = $mapper_contrat->findConuter() + 1;
          
          $contrat->setId_contrat($id_contrat);
                    $contrat->setCode_membre($code);
                    $contrat->setDate_contrat($date_idd->toString('yyyy-MM-dd'));
                    $contrat->setNature_contrat(NULL);
            $contrat->setId_type_contrat(NULL);
                        $contrat->setId_type_creneau($id_type_creneau);
                       $contrat->setId_type_acteur($id_type_acteur);
                    $contrat->setId_pays($_POST['id_pays']);
                    $contrat->setId_utilisateur(NULL);
                    $contrat->setFiliere(''); 
                    
                    $mapper_contrat->save($contrat);
          
          $tfl = new Application_Model_DbTable_EuFl();
                    $fl = new Application_Model_EuFl();
            $tafl = new Application_Model_DbTable_EuAncienFl();
                    $afl = new Application_Model_EuAncienFl();
                    $code_fl = 'FL-'.$_POST["ancien_code_membre"];
                    $result = $tafl->find($code_fl);
          
          $tcartes = array();
              $tscartes = array();
          
          if ((count($result) > 0) || ($_POST["code_fl"] != "" && $smsmoneyFL = $smsmoneyM->findByCreditCode9($_POST['code_fl'], "FL"))) {
            
          if (count($result) > 0) {
                        
            
             $code_afl = 'FL-'.$code;
             $mont_fl = Util_Utils::getParametre('FL','valeur'); 
             $fl->setCode_fl($code_afl)
                          ->setCode_membre(NULL)
              ->setCode_membre_morale($code)
                          ->setMont_fl($mont_fl)
                          ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                          ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                          ->setId_utilisateur(NULL)
                          ->setCreditcode(NULL);
                       $tfl->insert($fl->toArray());
            
            
            
          } else if ($_POST["code_fl"] != "" && $smsmoneyFL = $smsmoneyM->findByCreditCode9($_POST['code_fl'], "FL")) { 
            
             $mont_fl = Util_Utils::getParametre('FL','valeur'); 
            $sms_fl = $sms_mapper->findByCreditCode($_POST["code_fl"]);
              $tfl = new Application_Model_DbTable_EuFl();
                        $fl = new Application_Model_EuFl();
                        $code_fl = 'FL-' . $code;
             
              $fl->setCode_fl($code_fl)
                           ->setCode_membre(NULL)
               ->setCode_membre_morale($code)
                           ->setMont_fl($mont_fl)
                           ->setDate_fl($date_idd->toString('yyyy-MM-dd'))
                           ->setHeure_fl($date_idd->toString('HH:mm:ss'))
                           ->setId_utilisateur(NULL)
                           ->setCreditcode($sms_fl->getCreditCode());
                        $tfl->insert($fl->toArray());
                        
            //Mise e jour du compte general FGFL
                        $cg_mapper = new Application_Model_EuCompteGeneralMapper();
                        $cg_fgfn = new Application_Model_EuCompteGeneral();
                        $result3 = $cg_mapper->find('FL', 'NN', 'E', $cg_fgfn);
                        if ($result3) {
                           $cg_fgfn->setSolde($cg_fgfn->getSolde() + $mont_fl);
                           $cg_mapper->update($cg_fgfn);
                        } else {
                            $cg_fgfn->setCode_compte('FL')
                                    ->setIntitule('Frais de licence')
                                    ->setService('E')
                                    ->setCode_type_compte('NN')
                                    ->setSolde($mont_fl);
                            $cg_mapper->save($cg_fgfn);
                        }
                $compteurfl = $mapper_op->findConuter() + 1;
                            Util_Utils::addOperation($compteurfl,NULL,$code, NULL, $mont_fl, NULL, 'Frais de licences', 'FL',$date_idd->toString('yyyy-MM-dd'),$date_idd->toString('HH:mm:ss'), NULL);
            
                $sms_fl->setDestAccount_Consumed('FL-'.$code)
                                   ->setDateTimeconsumed($date_idd->toString('dd/MM/yyyy HH:mm:ss'))
                                   ->setIDDatetimeConsumed(Util_Utils::getIDDate($date_idd->toString('dd/MM/yyyy')));
                            $sms_mapper->update($sms_fl);
            
          }
            
            
            
            
            $tcartes[0]="TPAGCP";
            $tcartes[1]="TCNCSEI";
            $tcartes[2]="TPAGCI";
            $tcartes[3]="TIR";
            $tcartes[4]="TR";
            $tcartes[5]="TPaNu";
            $tcartes[6]="TPaR";
            $tcartes[7]="TFS";
            $tcartes[8]="TPN";
            $tcartes[9]="TIB";
            $tcartes[10]="TPaNu";
            $tcartes[11]="TIN";
            $tcartes[12]="CAPA";
            $tcartes[13]="TMARGE";
            $tcartes[14]="TRE";
                  
                  for($i = 0; $i < count($tcartes); $i++) {
                      if($tcartes[$i] == "TCNCSEI" || $tcartes[$i] == "TPN") {
                                          $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                      $type_carte = 'NR';
                        $res = $map_compte->find($code_compte,$compte);
                    } elseif($tcartes[$i] == "TR" || $tcartes[$i] == "CAPA" || $tcartes[$i] == "TRE" || $tcartes[$i] == "TMARGE") {
                                          $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                      $type_carte = 'NN';
                        $res = $map_compte->find($code_compte,$compte);
                    } elseif($tcartes[$i] == "TPAGCP" || $tcartes[$i] == "TPAGCI" || $tcartes[$i] == "TPaNu" || $tcartes[$i] == "TPaR" || $tcartes[$i] == "TFS") {
                        $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                        $type_carte = 'NB';
                          $res = $map_compte->find($code_compte,$compte);
                    } elseif($tcartes[$i] == "TIN") {
                        $tcartes[$i] = "TI"; 
                        $code_compte = 'NN' . '-' . $tcartes[$i] . '-' . $code;
                        $type_carte = 'NN';
                          $res = $map_compte->find($code_compte,$compte);
                    } elseif($tcartes[$i] == "TIR") {
                        $tcartes[$i] = "TI"; 
                        $code_compte = 'NR' . '-' . $tcartes[$i] . '-' . $code;
                        $type_carte = 'NR';
                          $res = $map_compte->find($code_compte,$compte);
                    } elseif($tcartes[$i] == "TIB") {
                        $tcartes[$i] = "TI";
                        $code_compte = 'NB' . '-' . $tcartes[$i] . '-' . $code;
                        $type_carte = 'NB';
                          $res = $map_compte->find($code_compte,$compte);
                    }
                    
                    if(!$res) {
                                          $compte->setCode_cat($tcartes[$i])
                                                 ->setCode_compte($code_compte)
                                                 ->setCode_membre(NULL)
                           ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                                 ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tcartes[$i])
                                                 ->setSolde(0);
                      $map_compte->save($compte);
                  
                      }
                  
                                    }
                  
                  $tscartes[0]="TSGCP";
                  $tscartes[1]="TSCNCSEI";
                  $tscartes[2]="TSGCI";
                  $tscartes[3]="TSCAPA";
                  $tscartes[4]="TSPaNu";
                  $tscartes[5]="TSPaR";
                  $tscartes[6]="TSFS";
                  $tscartes[7]="TSPN";
                  $tscartes[8]="TSIN";
                  $tscartes[9]="TSIB";
                  $tscartes[10]="TSIR";
                  $tscartes[11]="TSMARGE";
                  
                  for($j = 0; $j < count($tscartes); $j++) {
                  
                      if($tscartes[$j] == "TSCNCSEI" || $tscartes[$j] == "TSPN") {
                                          $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                      $type_carte = 'NR';
                        $res = $map_compte->find($code_comptets,$compte);
                    } elseif($tscartes[$j] == "TSCAPA" || $tscartes[$j] == "TSMARGE") {
                                          $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                      $type_carte = 'NN';
                        $res = $map_compte->find($code_comptets,$compte);
                    } elseif($tscartes[$j] == "TSGCP" || $tscartes[$j] == "TSGCI" || $tscartes[$j] == "TSPaNu" || $tscartes[$j] == "TSPaR"
                      || $tscartes[$j] == "TSFS") {
                        $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                        $type_carte = 'NB';
                          $res = $map_compte->find($code_comptets,$compte);
                    } elseif($tscartes[$j] == "TSIN") {
                        $tscartes[$j] = "TSI"; 
                        $code_comptets = 'NN' . '-' . $tscartes[$j] . '-' . $code;
                        $type_carte = 'NN';
                          $res = $map_compte->find($code_comptets,$compte);
                    } elseif($tscartes[$j] == "TSIR") {
                        $tscartes[$j] = "TSI"; 
                        $code_comptets = 'NR' . '-' . $tscartes[$j] . '-' . $code;
                        $type_carte = 'NR';
                          $res = $map_compte->find($code_comptets,$compte);
                    } elseif($tscartes[$j] == "TSIB") {
                        $tscartes[$j] = "TSI";
                        $code_comptets = 'NB' . '-' . $tscartes[$j] . '-' . $code;
                        $type_carte = 'NB';
                          $res = $map_compte->find($code_comptets,$compte);
                    }
                    
                    if(!$res) {
                                          $compte->setCode_cat($tscartes[$j])
                                                 ->setCode_compte($code_comptets)
                                                 ->setCode_membre(NULL)
                           ->setCode_membre_morale($code)
                                                 ->setCode_type_compte($type_carte)
                                                 ->setDate_alloc($date_idd->toString('yyyy-MM-dd'))
                                                 ->setDesactiver(0)
                                                 ->setLib_compte($tscartes[$j])
                                                 ->setSolde(0);
                      $map_compte->save($compte);
                      }
                  
                                    } 
            
            
          
          } else {
                   $db->rollBack();
                   $this->view->message = "Vous devez payer les frais de licence";
                   $this->view->type_acteur = $_POST["code_type_acteur"];
                           $this->view->statut_juridique = $_POST["code_statut"];
                           $this->view->raison = $_POST["raison_sociale"];
                           $this->view->domaine_activite = $_POST["domaine_activite"];
                           $this->view->site_web = $_POST["site_web"];
                           $this->view->quartier_membre = $_POST["quartier_membre"];
                           $this->view->ville_membre = $_POST["ville_membre"];
                           $this->view->bp = $_POST["bp_membre"];
                           $this->view->tel = $_POST["tel_membre"];
                           $this->view->email = $_POST["email_membre"];
                           $this->view->portable = $_POST["portable_membre"];
                           $this->view->registre = $_POST["num_registre_membre"];
                           return;
           }
          
          
          
          
           //Mise à jour de la table morale
                     $m_mapper = new Application_Model_EuAncienMembreMapper();
                     $m = new Application_Model_EuAncienMembre();
                     $rep = $m_mapper->find($_POST["ancien_code_membre"],$m);
                     if ($rep == true) {
                       $m->setEtat_contrat(1)
                 ->setCode_membre($code);
                       $m_mapper->update($m);
                     }
           $compteur = Util_Utils::findConuter() + 1;
                     Util_Utils::addSms($compteur,$_POST["portable_membre"],"Bienvenue dans le reseau MCNP! Votre numero de membre est: " . $code . ". Votre Code Secret est: " . $_POST["codesecret"]);
                $db->commit();
                //return $this->_helper->redirector('morale', 'eu-membre', NULL, array('controller' => 'eu-membre-ancien', 'action' => 'morale'));
        } catch (Exception $exc) {
             $db->rollback();
           $this->view->type_acteur = $_POST["code_type_acteur"];
                   $this->view->statut_juridique = $_POST["code_statut"];
                   $this->view->raison = $_POST["raison_sociale"];
                   $this->view->domaine_activite = $_POST["domaine_activite"];
                   $this->view->site_web = $_POST["site_web"];
                   $this->view->quartier_membre = $_POST["quartier_membre"];
                   $this->view->ville_membre = $_POST["ville_membre"];
                   $this->view->bp = $_POST["bp_membre"];
                   $this->view->tel = $_POST["tel_membre"];
                   $this->view->email = $_POST["email_membre"];
           $this->view->id_pays = $_POST["id_pays"];
                   $this->view->portable = $_POST["portable_membre"];
                   $this->view->registre = $_POST["num_registre_membre"];
             $this->view->message = $exc->getMessage() . ': ' . $exc->getTraceAsString();
                   return;
              }
      
          

/*          */          

      $sessionmcnp->errorlogin = "Ré-activation du compte marchant membre personne morale bien effectuée ...";
    $this->_redirect('/index/ancienpmmcnp');
    //$this->_redirect('/');
    } else {  $this->view->message = "Vérifier bien les numéros agréments...";  } 
    } else {  $this->view->message = "Champs * obligatoire ...";  } 
    } else {
      
            $id = (string)$this->_request->getParam('id');
      
           $tabela = new Application_Model_DbTable_EuAncienMembre();
       $select = $tabela->select();
           $select->from($tabela,array('eu_ancien_membre.*',"date_identification as dateidentif"))
                  ->where('ancien_code_membre LIKE ?', '%'.$id.'%')
          ->where('etat_contrat != 1');        
    $memb = $tabela->fetchAll($select);
    $trouvmembre = $memb->current();

$this->view->ancien_code_membre = $trouvmembre->ancien_code_membre;
$this->view->raison = $trouvmembre->raison_sociale;
$this->view->code_rep = $trouvmembre->nom_membre." ".$trouvmembre->prenom_membre;
$this->view->quartier_membre = $trouvmembre->quartier_membre;
$this->view->ville_membre = $trouvmembre->ville_membre;
$this->view->bp = $trouvmembre->bp_membre;
$this->view->tel = $trouvmembre->tel_membre; 
$this->view->portable = $trouvmembre->portable_membre;
$this->view->email = $trouvmembre->email_membre;
$this->view->site_web = $trouvmembre->site_web;
      


      }
    
    }











    public function addsouscriptionAction()
    {
		//$this->_helper->layout->disableLayout();
 		$this->_helper->layout()->setLayout('layoutpublicesmc');
		

	if (isset($_POST['ok']) && $_POST['ok']=="ok") {
	if (isset($_POST['souscription_mobile']) && $_POST['souscription_mobile']!="" && isset($_POST['souscription_personne']) && $_POST['souscription_personne']!="" && isset($_POST['souscription_type']) && $_POST['souscription_type']!="" && isset($_POST['souscription_programme']) && $_POST['souscription_programme']!="") {
		
			
        $date_id = Zend_Date::now();

        $souscription = new Application_Model_EuSouscription();
        $souscription_mapper = new Application_Model_EuSouscriptionMapper();
		
		include("Transfert.php");
		if(isset($_FILES['souscription_vignette']['name']) && $_FILES['souscription_vignette']['name']!=""){
		$chemin	= "souscriptions";
		$file = $_FILES['souscription_vignette']['name'];
		$file1='souscription_vignette';
		$souscription_vignette = $chemin."/".transfert($chemin,$file1);
		} else {$souscription_vignette = "";}
			
            $compteur_souscription = $souscription_mapper->findConuter() + 1;
            $souscription->setSouscription_id($compteur_souscription);
            $souscription->setSouscription_personne($_POST['souscription_personne']);
			if($_POST['souscription_personne'] == "PP"){
            $souscription->setSouscription_nom($_POST['souscription_nom']);
            $souscription->setSouscription_prenom($_POST['souscription_prenom']);
			}else{
            $souscription->setSouscription_raison($_POST['souscription_raison']);
            $souscription->setCode_type_acteur($_POST["type_acteur"]);
            $souscription->setCode_statut($_POST["statut_juridique"]);
			}
            $souscription->setSouscription_email($_POST['souscription_email']);
            $souscription->setSouscription_mobile($_POST['souscription_mobile']);
            $souscription->setSouscription_membreasso(1);
            $souscription->setSouscription_type($_POST['souscription_type']);
            $souscription->setSouscription_numero($_POST['souscription_numero']);
			if($_POST['souscription_type'] == "Banque"){
            $souscription->setSouscription_banque($_POST['souscription_banque']);
			}
            $souscription->setSouscription_montant($_POST['souscription_montant']);
            $souscription->setSouscription_nombre($_POST['souscription_nombre']);
            $souscription->setSouscription_programme($_POST['souscription_programme']);
            $souscription->setSouscription_type_candidat($_POST['souscription_type_candidat']);
            $souscription->setSouscription_filiere($_POST['souscription_filiere']);
            $souscription->setSouscription_date($date_id->toString('yyyy-MM-dd HH:mm:ss'));
            $souscription->setSouscription_vignette($souscription_vignette);
            $souscription->setCode_activite($_POST["code_activite"]);
            $souscription->setId_competence($_POST["id_competence"]);
            $souscription->setPublier(0);
            $souscription_mapper->save($souscription);
			
			
			
//////////////////////////////////////////
			
        $association = new Application_Model_EuAssociation();
        $m_association = new Application_Model_EuAssociationMapper();
		$m_association->find(1, $association);
			if($_POST['souscription_programme'] == "KACM"){
			$partagea_montant = floor($_POST['souscription_montant'] / 100 * 10);
				}else{
			$partagea_montant = floor($_POST['souscription_montant'] / 100 * 5);
					}
			
			
//////////////////////////////////////////

        /*$partagem = new Application_Model_EuPartagem();
        $partagem_mapper = new Application_Model_EuPartagemMapper();

            $compteur_partagem = $partagem_mapper->findConuter() + 1;
            $partagem->setPartagem_id($compteur_partagem);
            $partagem->setPartagem_membreasso(1);
            $partagem->setPartagem_souscription($compteur_souscription);
            $partagem->setPartagem_montant($partagem_montant);
            $partagem_mapper->save($partagem);*/
			
//////////////////////////////////////////

        $partagea = new Application_Model_EuPartagea();
        $partagea_mapper = new Application_Model_EuPartageaMapper();

            $compteur_partagea = $partagea_mapper->findConuter() + 1;
            $partagea->setPartagea_id($compteur_partagea);
            $partagea->setPartagea_association(1);
            $partagea->setPartagea_souscription($compteur_souscription);
            $partagea->setPartagea_montant($partagea_montant);
            $partagea_mapper->save($partagea);
			
//////////////////////////////////////////
        /*$membreasso = new Application_Model_EuMembreasso();
        $m_membreasso = new Application_Model_EuMembreassoMapper();
		$m_membreasso->find(1, $membreasso);*/

$html = "";

			if($_POST['souscription_personne'] == "PP"){
$html .= "Nom : ".$_POST['souscription_nom']."<br />";
$html .= "Prenom : ".$_POST['souscription_prenom']."<br />";
			}else{
$html .= "Raison sociale : ".$_POST['souscription_raison']."<br />";
if($_POST["type_acteur"] == 'EI'){$html .= "Type Association : Entreprise Industrie<br />";}
if($_POST["type_acteur"] == 'OSE'){$html .= "Type Association : Opérateur Socio-Economique<br />";}
if($_POST["type_acteur"] == 'PEI'){$html .= "Type Association : Partenaire Entreprise Industrie<br />";}
if($_POST["type_acteur"] == 'POSE'){$html .= "Type Association : Partenaire Opérateur Socio-Economique<br />";}

        $statutjuridique = new Application_Model_EuStatutJuridique();
        $statutjuridiqueM = new Application_Model_EuStatutJuridiqueMapper();
        $statutjuridiqueM->find($_POST["statut_juridique"], $statutjuridique);
$html .= "Statut juridique : ".$statutjuridique->libelle_statut."<br />";
			}
$html .= "E-mail : ".$_POST['souscription_email']."<br />";
$html .= "Mobile : ".$_POST['souscription_mobile']."<br />";
$html .= "Programme : ".$_POST['souscription_programme']."<br />";

        $type_candidatM = new Application_Model_DbTable_EuTypeCandidat();
        $type_candidat = $type_candidatM->find($_POST['souscription_type_candidat']);
$html .= "Type candidat : ".$type_candidat->libelle_type_candidat."<br />";

        $filiere = new Application_Model_EuFiliere();
        $filiereM = new Application_Model_EuFiliereMapper();
        $filiereM->find($_POST['souscription_filiere'], $filiere);
$html .= "Filiere : ".$filiere->nom_filiere."<br />";

        $activiteM = new Application_Model_DbTable_EuActivite();
        $activite = $activiteM->find($_POST['code_activite']);
$html .= "BPS : ".$activite->nom_activite."<br />";

        $competenceM = new Application_Model_DbTable_EuCompetence();
        $competence = $competenceM->find($_POST['id_competence']);
$html .= "Compétence : ".$competence->libelle_competence."<br />";

$html .= "Type : ".$_POST['souscription_type']."<br />";

			if($_POST['souscription_type'] == "Banque"){
        $banque = new Application_Model_EuBanque();
        $banqueM = new Application_Model_EuBanqueMapper();
        $banqueM->find($_POST['souscription_banque'], $banque);
$html .= "Banque : ".$banque->libelle_banque."<br />";
			}

$html .= "Numero Reçu Banque ou Numéro Transaction Flooz: ".$_POST['souscription_numero']."<br />";
$html .= "Montant : ".$_POST['souscription_montant']."<br />";
$html .= "Nombre : ".$_POST['souscription_nombre']."<br />";

$html .= "Date : ".$date_id->toString('yyyy-MM-dd HH:mm:ss')."<br />";
$html .= "Vignette : <a href='http://www.esmcgacsource.com/".$souscription_vignette."'>".$souscription_vignette."</a>";

$html .= "Agrément OSE/OE: ".$association->association_nom."<br />";
			
$esmc_email	 = "achatcmmcnp@esmcgacsource.com";	
			
$mail = new Zend_Mail();
//$mail->setBodyText('Mon texte de test');
$mail->setBodyHtml($html);
$mail->setFrom($association->association_email, $association->association_nom);
$mail->addTo($esmc_email, "ESMC - SIF");
$mail->setSubject('Nouvelle souscription : '.$date_id->toString('dd-MM-yyyy HH:mm:ss'));

$mail->send();

$this->view->error = "Opération bien effectuée";
		//$this->_redirect('/association/listsouscription2');/**/
		} else {  $this->view->error = "Champs * obligatoire ..."; }
	}
	 
	}









    public function relevesalaireAction()
    {
        /* page index/relevesalaire - Retrouve salaire */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

		    $code_membre  = '';
			$designation  = '';
			$cncs         = 0;
			$escompte     = 0;
			$echange      = 0;
		    $soldenr      = 0;
		    $soldenn      = 0;
		    $code_membre = '';

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    
				$db_cccncs = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_cccncs = $db_cccncs->select();
				$select_cccncs->from($db_cccncs,array('SUM(montant_place) as somme_cccncs'));
                $select_cccncs->where('code_membre = ?', $code_membre);
				$select_cccncs->where('code_produit in (?)',array('CNCSr','CNCSnr'));
                $result_cccncs = $db_cccncs->fetchAll($select_cccncs);
		        $row_cccncs = $result_cccncs->current();
		        $cncs = $row_cccncs['somme_cccncs'];
				
				
				$db_escompte     = new Application_Model_DbTable_EuAncienEchange();
				$select_escompte = $db_escompte->select();
				$select_escompte->from($db_escompte,array('SUM(montant) as somme_escompte'));
                $select_escompte->where('code_membre = ?', $code_membre);
				$select_escompte->where('type_echange like ?','NR/NN');
                $result_escompte   = $db_escompte->fetchAll($select_escompte);
		        $row_escompte = $result_escompte->current();
		        $escompte = $row_escompte['somme_escompte'];
				
				
				$db_echange      = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_echange  = $db_echange->select();
				$select_echange->from($db_echange,array('SUM(montant_place) as somme_echange'));
                //$select_echange->where('code_membre = ?', $code_membre);
				$select_echange->where('compte_source like ?','NR-TCNCS-'.$code_membre);
				$select_echange->orwhere('compte_source like ?','NN-TCNCS-'.$code_membre);
                $result_echange   = $db_echange->fetchAll($select_echange);
		        $row_echange = $result_echange->current();
		        $echange = $row_echange['somme_echange'];
				
				
				/*
				$db_ccnr = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_ccnr = $db_ccnr->select();
				$select_ccnr->from($db_ccnr,array('SUM(montant_credit) as somme_ccnr'));
                $select_ccnr->where('code_membre = ?', $code_membre);
				$select_ccnr->where('code_produit in (?)',array('CNCSr','CNCSnr'));
                $result_ccnr = $db_ccnr->fetchAll($select_ccnr);
		        $row_ccnr = $result_ccnr->current();
		        $soldenr = $row_ccnr['somme_ccnr'];*/
				
				
				
                 
				if(substr($code_membre,19,1) == 'M')  {
				    $db_cnn = new Application_Model_DbTable_EuAncienCompte();
				    $select_cnn = $db_cnn->select();
				    $select_cnn->from($db_cnn,array('SUM(solde) as somme_cnn'));
                    $select_cnn->where('code_membre = ?', $code_membre);
				    $select_cnn->where('code_cat in (?)',array('TCNCSEI','TPN','TCNCS'));
                    $result_cnn = $db_cnn->fetchAll($select_cnn);
		            $row_cnn = $result_cnn->current();
		            $soldenn = $row_cnn['somme_cnn'];
				
				} else {
				    $soldenn = abs($cncs-$escompte-$echange);
				
				}	


			$this->view->code_membre    = $code_membre;
			$this->view->designation    = $designation;
		    $this->view->cncs           = $cncs;
			$this->view->escompte       = $escompte;
			$this->view->echange        = $echange;
		    $this->view->soldenn        = $soldenn;		   
	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
		   
		if ($code_membre != '' || $code_membre != null) {
            $select->where('eu_ancien_compte_credit.code_membre = ?',$code_membre);
		} else {
            $code_membre = '%';
        }
		$select->where('eu_ancien_compte_credit.code_produit in (?)', array('CNCSnr','CNCSr'));
		$select->order('eu_ancien_compte_credit.date_octroi asc');
        $this->view->detailsalaire = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienEchange();
        $select = $tabela->select();
		if ($code_membre != '' || $code_membre != null) {
           $select->where('eu_ancien_echange.code_membre = ?',$code_membre);
		}
		$select->where('eu_ancien_echange.type_echange like ?','NR/NN');
        $select->order('date_echange asc');
        $this->view->escomptesalaire = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
	    if ($code_membre != '' || $code_membre != null) {
           //$select->where('eu_ancien_compte_credit.code_membre = ?',$code_membre);
		} else {
           $code_membre = '%';
        }		
		$select->where('eu_ancien_compte_credit.compte_source like ?','NR-TCNCS-'.$code_membre);
		$select->orwhere('eu_ancien_compte_credit.compte_source like ?','NN-TCNCS-'.$code_membre);
		$select->order('eu_ancien_compte_credit.date_octroi asc');
        $this->view->echangesalaire = $tabela->fetchAll($select);








    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }









    public function relevecreditAction()
    {
        /* page index/relevecredit - Retrouve rpg/i */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $compte = '';
        $membre = $_POST['code_membre'];
		$origine = '';
		
		
		if($membre != '' && $compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else
		if($compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->order('date_octroi asc');
		} else
        if ($compte != '' or $compte != null) {
		    $select = $tabela->select();
            $select->where('code_produit = ?', $compte);
			$select->order('date_octroi asc');
        } else
		if ($origine != '' or $origine != null) {
		    $select = $tabela->select();
            $select->where('compte_source like ?',$origine.'%');
		    $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
            			
        } else
        if ($membre != '' or $membre != null) {
		    $select = $tabela->select();
            $select->where('code_membre = ?', $membre);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
			$select->order('date_octroi asc');
        } else {
		    $select = $tabela->select();
            $select->from($tabela);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
		}
        		
		
        $this->view->creditrpgi = $tabela->fetchAll($select);






			$this->view->code_membre    = $code_membre;


    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }










    public function relevegcpAction()
    {
        /* page index/relevegcp - Retrouve gcp */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

		$code_membre  = '';
		$designation  = '';
		$gcp          = 0;
		$escompte     = 0;
		$echange      = 0;
		$reste        = 0;
		$echu         = 0;

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    
		   $db_gcp = new Application_Model_DbTable_EuAncienGcp();
		   $select_gcp = $db_gcp->select();
           $select_gcp->from($db_gcp,array('SUM(mont_gcp) as somme_gcp'));
           $select_gcp->where('code_membre = ?', $code_membre);
           $result_gcp = $db_gcp->fetchAll($select_gcp);
		   $row_gcp = $result_gcp->current();
		   $gcp = $row_gcp['somme_gcp'];
		   
		   
		   $db_escompte = new Application_Model_DbTable_EuAncienEscompte();
		   $select_escompte = $db_escompte->select();
		   $select_escompte->from($db_escompte,array('SUM(montant) as somme_escompte'));
		   $select_escompte->where('code_membre = ?', $code_membre);
		   $result_escompte = $db_escompte->fetchAll($select_escompte);
		   $row_escompte = $result_escompte->current();
		   $escompte = $row_escompte['somme_escompte'];
		   
		   
		   $db_echange = new Application_Model_DbTable_EuAncienEchange();
		   $select_echange = $db_echange->select();
		   $select_echange->from($db_echange,array('SUM(montant) as somme_echange'));
		   $select_echange->where('code_membre = ?', $code_membre);
		   $select_echange->where('type_echange = ?','NB/NB');
		   $result_echange = $db_echange->fetchAll($select_echange);
		   $row_echange = $result_echange->current();
		   $echange = $row_echange['somme_echange'];
		   $reste = floor($gcp - $escompte - $echange);
		   
		   
		   $db_tpagcp = new Application_Model_DbTable_EuAncienTpagcp();
		   $select_tpagcp = $db_tpagcp->select();
		   $select_tpagcp->from($db_tpagcp,array('SUM(mont_echu) as somme_echu'));
		   $select_tpagcp->where('code_membre = ?', $code_membre);
		   $result_tpagcp = $db_tpagcp->fetchAll($select_tpagcp);
		   $row_tpagcp = $result_tpagcp->current();
		   $echu = $row_tpagcp['somme_echu'];


		$this->view->code_membre = $code_membre;
		$this->view->designation = $designation;
		$this->view->gcp         = $gcp;
		$this->view->escompte    = $escompte;
		$this->view->echange     = $echange;
		$this->view->reste       = $reste;
		$this->view->echue       = $echu;	
	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienGcp();
		//if ($code_membre != '' || $code_membre != null) {
            $select = $tabela->select()->setIntegrityCheck(false);
            $select->from($tabela, array('id_gcp','date_conso', 'mont_gcp', 'mont_preleve', 'reste', 'code_cat', 'id_credit'))
		           ->join('eu_ancien_compte_credit', 'eu_ancien_compte_credit.id_credit = eu_ancien_gcp.id_credit', array('code_membre', 'code_produit'));
            $select->order('eu_ancien_gcp.date_conso asc');
			if ($code_membre != '' || $code_membre != null) {
			   $select->where('eu_ancien_gcp.code_membre like ?',$code_membre);
			}
            $this->view->consult = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienEscompte();
        $select = $tabela->select()->setIntegrityCheck(false);
		$select->from($tabela,array('*'));
		$select->join('eu_ancien_membre','eu_ancien_membre.ancien_code_membre = eu_ancien_escompte.code_membre_benef');
		if ($code_membre != '' || $code_membre != null) {
            $select->where('eu_ancien_escompte.code_membre like ?',$code_membre);
		}
        $select->order('eu_ancien_escompte.date_escompte asc');
        $this->view->escomptes = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienEchange();
        $select = $tabela->select();
		
		if ($code_membre != '' || $code_membre != null) {
           $select->where('eu_ancien_echange.code_membre like ?', $code_membre);
		}   
		$select->where('eu_ancien_echange.type_echange like ?','NB/NB');
        $select->order('date_echange asc');
        $this->view->echanges = $tabela->fetchAll($select);




    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }











    public function relevekacmAction()
    {
        /* page index/relevekcm - Retrouve les kacm */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

		   $code_membre  = '';
		   $designation  = '';
		   $fs           = 0;
		   $fl           = 0;
		   $fcps         = 0;
		   
		   $fsu          = 0;
		   $flu          = 0;
		   $fcpsu        = 0;
		   
		   $fsnu         = 0;
		   $flnu         = 0;
		   $fcpsnu       = 0;
		   
		   $kacm         = 0;

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    
				$db_fs = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fs = $db_fs->select();
				$select_fs->from($db_fs,array('SUM(CreditAmount) as somme_fs'));
				
				if($code_membre != '') {
                  $select_fs->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fs->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fs->where('Motif like ?','FS');
                $result_fs = $db_fs->fetchAll($select_fs);
		        $row_fs = $result_fs->current();
		        $fs = $row_fs['somme_fs'];
				
				$db_fl = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fl = $db_fl->select();
				$select_fl->from($db_fl,array('SUM(CreditAmount) as somme_fl'));
				
				if($code_membre != '') {
                  $select_fl->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fl->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fl->where('Motif like ?','FL');
                $result_fl = $db_fl->fetchAll($select_fl);
		        $row_fl = $result_fl->current();
		        $fl = $row_fl['somme_fl'];
				
				
				$db_cps = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cps = $db_cps->select();
				$select_cps->from($db_cps,array('SUM(CreditAmount) as somme_cps'));
				
				if($code_membre != '') {
                  $select_cps->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cps->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cps->where('Motif like ?','CPS');
                $result_cps = $db_cps->fetchAll($select_cps);
		        $row_cps = $result_cps->current();
		        $fcps = $row_cps['somme_cps'];
				
				
				$db_fsu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fsu = $db_fsu->select();
				$select_fsu->from($db_fsu,array('SUM(CreditAmount) as somme_fsu'));
				
				if($code_membre != '') {
                  $select_fsu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fsu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fsu->where('Motif like ?','FS');
				$select_fsu->where('IDDateTimeConsumed <> ?',0);
                $result_fsu = $db_fsu->fetchAll($select_fsu);
		        $row_fsu = $result_fsu->current();
		        $fsu = $row_fsu['somme_fsu'];
				
				
				$db_flu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_flu = $db_flu->select();
				$select_flu->from($db_flu,array('SUM(CreditAmount) as somme_flu'));
				
				if($code_membre != '') {
                  $select_flu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_flu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_flu->where('Motif like ?','FL');
				$select_flu->where('IDDateTimeConsumed <> ?',0);
                $result_flu = $db_flu->fetchAll($select_flu);
		        $row_flu = $result_flu->current();
		        $flu = $row_flu['somme_flu'];
				
				
				$db_cpsu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cpsu = $db_cpsu->select();
				$select_cpsu->from($db_cpsu,array('SUM(CreditAmount) as somme_cpsu'));
				
				if($code_membre != '') {
                  $select_cpsu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cpsu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cpsu->where('Motif like ?','CPS');
				$select_cpsu->where('IDDateTimeConsumed <> ?',0);
                $result_cpsu = $db_cpsu->fetchAll($select_cpsu);
		        $row_cpsu = $result_cpsu->current();
		        $fcpsu = $row_cpsu['somme_cpsu'];
				
				
				
				$db_fsnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fsnu = $db_fsnu->select();
				$select_fsnu->from($db_fsnu,array('SUM(CreditAmount) as somme_fsnu'));
				
				if($code_membre != '') {
                  $select_fsnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fsnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fsnu->where('Motif like ?','FS');
				$select_fsnu->where('IDDateTimeConsumed = ?',0);
                $result_fsnu = $db_fsnu->fetchAll($select_fsnu);
		        $row_fsnu = $result_fsnu->current();
		        $fsnu = $row_fsnu['somme_fsnu'];
				
				
				$db_flnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_flnu = $db_flnu->select();
				$select_flnu->from($db_flnu,array('SUM(CreditAmount) as somme_flnu'));
				
				if($code_membre != '') {
                  $select_flnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_flnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_flnu->where('Motif like ?','FL');
				$select_flnu->where('IDDateTimeConsumed = ?',0);
                $result_flnu = $db_flnu->fetchAll($select_flnu);
		        $row_flnu = $result_flnu->current();
		        $flnu = $row_flnu['somme_flnu'];
				
				
				$db_cpsnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cpsnu = $db_cpsnu->select();
				$select_cpsnu->from($db_cpsnu,array('SUM(CreditAmount) as somme_cpsnu'));
				
				if($code_membre != '') {
                  $select_cpsnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cpsnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cpsnu->where('Motif like ?','CPS');
				$select_cpsnu->where('IDDateTimeConsumed = ?',0);
                $result_cpsnu = $db_cpsnu->fetchAll($select_cpsnu);
		        $row_cpsnu = $result_cpsnu->current();
		        $fcpsnu = $row_cpsnu['somme_cpsnu'];


			$this->view->code_membre  = $code_membre;
			$this->view->designation  = $designation;
		    $this->view->fs           = $fs;
			$this->view->fl           = $fl;
			$this->view->fcps         = $fcps;
			
			$this->view->fsu           = $fsu;
			$this->view->flu           = $flu;
			$this->view->fcpsu         = $fcpsu;
			
			$this->view->fsnu           = $fsnu;
			$this->view->flnu           = $flnu;
			$this->view->fcpsnu         = $fcpsnu;
	
////////////////////////////////////////////////////////////////////////////////

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','FS');
			$select->order('NEng asc');
			
			$this->view->detailfs = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','FL');
			$select->order('NEng asc');
			
			$this->view->detailfl = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','CPS');
			$select->order('NEng asc');
			
			$this->view->detailfcps = $tabela->fetchAll($select);








    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }








    public function relevemf11000ppAction()
    {
        /* page index/relevemf11000 - Retrouve mf11000 */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

			$num_bon          = '';
			$nom              = '';
            $code_membre      = '';
	        $designation      = '';
		    $mf11000_recu     = 0;
		    $mf11000_vendu    = 0;
		    $mf11000_restant  = 0;
		   
		    $entrees     = 0;
		    $sorties     = 0;
		    $solde       = 0;
		   
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['num_bon']) && $_POST['num_bon']!="") {
    
				$num_bon = $_POST['num_bon'];
				$nom = "";

				    $db_entrees = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_entrees = $db_entrees->select();
			        $select_entrees->from($db_entrees,array('SUM(mont_rep) as somme_entrees'));
			        $select_entrees->where('code_mf11000 like ?',$num_bon);
			        $result_entrees     = $db_entrees->fetchAll($select_entrees);
		            $row_entrees        = $result_entrees->current();
		            $entrees  = $row_entrees['somme_entrees'];
					
					$db_sorties = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_sorties = $db_sorties->select();
			        $select_sorties->from($db_sorties,array('SUM(mont_reglt) as somme_sorties'));
			        $select_sorties->where('code_mf11000 like ?',$num_bon);
			        $result_sorties     = $db_sorties->fetchAll($select_sorties);
		            $row_sorties        = $result_sorties->current();
		            $sorties  = $row_sorties['somme_sorties'];
					
					
					$db_solde = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_solde = $db_solde->select();
			        $select_solde->from($db_solde,array('SUM(solde_rep) as solde'));
			        $select_solde->where('code_mf11000 like ?',$num_bon);
			        $result_solde     = $db_solde->fetchAll($select_solde);
		            $row_solde        = $result_solde->current();
		            $solde  = $row_solde['solde'];
				
				


			$this->view->code_membre     = $code_membre;
			$this->view->designation     = $designation;
			$this->view->num_bon         = $num_bon;
			$this->view->nom             = $nom;
		    $this->view->mf11000_recu    = $mf11000_recu;
			$this->view->mf11000_vendu   = $mf11000_vendu;
			$this->view->mf11000_restant = $mf11000_restant;
			
			$this->view->entrees    = $entrees;
			$this->view->sorties    = $sorties;
			$this->view->solde      = $solde;
	
////////////////////////////////////////////////////////////////////////////////

		    $tabela = new Application_Model_DbTable_EuRepartitionMf11000();
		    $num_bon = $this->_request->getParam("num_bon");
		    $select = $tabela->select();
	        $select->where('code_mf11000 like ?',$num_bon);
			$select->order('id_rep asc');
			
			$this->view->detailbon = $tabela->fetchAll($select);

	

    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }














    public function relevemf11000pmAction()
    {
        /* page index/relevemf11000 - Retrouve mf11000 */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

			$num_bon          = '';
			$nom              = '';
            $code_membre      = '';
	        $designation      = '';
		    $mf11000_recu     = 0;
		    $mf11000_vendu    = 0;
		    $mf11000_restant  = 0;
		   
		    $entrees     = 0;
		    $sorties     = 0;
		    $solde       = 0;
		   
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    

			    $db_dsms = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsms = $db_dsms->select();
			    $select_dsms->from($db_dsms,array('SUM(mont_sms) as somme_mf'));
			    $select_dsms->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsms->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsms->where('code_membre_dist like ?','%');
                }
			    $result_dsms = $db_dsms->fetchAll($select_dsms);
		        $row_dsms = $result_dsms->current();
		        $mf11000_recu = $row_dsms['somme_mf'];
			   
			   
			    $db_dsmsv = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsmsv = $db_dsmsv->select();
			    $select_dsmsv->from($db_dsmsv,array('SUM(mont_vendu) as somme_vendu'));
			    $select_dsmsv->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsmsv->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsmsv->where('code_membre_dist like ?','%');
                }
			    $result_dsmsv = $db_dsmsv->fetchAll($select_dsmsv);
		        $row_dsmsv = $result_dsmsv->current();
		        $mf11000_vendu = $row_dsmsv['somme_vendu'];
			   
			    $db_dsmss = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsmss = $db_dsmss->select();
			    $select_dsmss->from($db_dsmss,array('SUM(solde_sms) as somme_sms'));
			    $select_dsmss->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsmss->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsmss->where('code_membre_dist like ?','%');
                }
			    $result_dsmss     = $db_dsmss->fetchAll($select_dsmss);
		        $row_dsmss        = $result_dsmss->current();
		        $mf11000_restant  = $row_dsmss['somme_sms'];
				
				


			$this->view->code_membre     = $code_membre;
			$this->view->designation     = $designation;
			$this->view->num_bon         = $num_bon;
			$this->view->nom             = $nom;
		    $this->view->mf11000_recu    = $mf11000_recu;
			$this->view->mf11000_vendu   = $mf11000_vendu;
			$this->view->mf11000_restant = $mf11000_restant;
			
			$this->view->entrees    = $entrees;
			$this->view->sorties    = $sorties;
			$this->view->solde      = $solde;
	
////////////////////////////////////////////////////////////////////////////////

		    $tabela = new Application_Model_DbTable_EuAncienDetailSmsmoney();
		    $select = $tabela->select();
		    if($code_membre != '') {
	           $select->where('code_membre_dist like ?',$code_membre);
	        } else {
			   $select->where('code_membre_dist like ?','%');
			}
			$select->where('origine_sms like ?','MF');
			$select->order('id_detail_smsmoney asc');
			
			$this->view->detailmf11000 = $tabela->fetchAll($select);

	

    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }













    public function relevemf107Action()
    {
        /* page index/relevemf107 - Retrouve mf107 */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

		    $code_membre  = '';
		    $designation  = '';
		    $soldemf107   = 0;
		   
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    

			        $anciencompte_nn   = new Application_Model_EuAncienCompte();
		            $anciencm_map      = new Application_Model_EuAncienCompteMapper();
					$date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
			        $rep = new Application_Model_EuRepartitionMf107();
			        $m_rep = new Application_Model_EuRepartitionMf107Mapper();
			        $dmf = new Application_Model_EuDetailMf107();
			        $mdmf = new Application_Model_EuDetailMf107Mapper();
			        $mf107 = new Application_Model_EuMembreFondateur107();
			        $mmf107 = new Application_Model_EuMembreFondateur107Mapper();
			        $montant = 0;
			        $nb_dmf = 0;
			        $code_compteancien = 'NN-TR-'.$code_membre;
					$soldemf107 = $m_rep->findSum($code_membre);	
				
				
			$this->view->code_membre  = $code_membre;
			$this->view->designation  = $designation;
            $this->view->soldemf107  = $soldemf107;			
	
////////////////////////////////////////////////////////////////////////////////

			$mf107  = new Application_Model_EuMembreFondateur107();
			$mmf107 = new Application_Model_EuMembreFondateur107Mapper();
		    $tabela = new Application_Model_DbTable_EuRepartitionMf107();
		    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                   ->join('eu_detail_mf107', 'eu_detail_mf107.id_mf107 = eu_repartition_mf107.id_mf107',array('code_membre','id_mf107','mont_apport','pourcentage','numident'));
		    $select->where('eu_repartition_mf107.code_membre like ?',$code_membre);
			//$select->order('eu_repartition_mf107.id_rep asc');
			$select->order('eu_detail_mf107.code_membre asc');
		    //$select = $tabela->select();
	        
			$this->view->detailmf107 = $tabela->fetchAll($select);
			

	

    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }










	 public function relevesalairepdfAction() {
    
	
        /* page index/relevesalairepdf - Génération de relevé salaire en PDF */

		$this->_helper->layout->disableLayout();
		

		include("Transfert.php");
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);
		

		    $code_membre  = '';
			$designation  = '';
			$cncs         = 0;
			$escompte     = 0;
			$echange      = 0;
		    $soldenr      = 0;
		    $soldenn      = 0;
		    $code_membre = '';

	            $code_membre =  (string)$this->_request->getParam('code');

				$designation = "";
    
				$db_cccncs = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_cccncs = $db_cccncs->select();
				$select_cccncs->from($db_cccncs,array('SUM(montant_place) as somme_cccncs'));
                $select_cccncs->where('code_membre = ?', $code_membre);
				$select_cccncs->where('code_produit in (?)',array('CNCSr','CNCSnr'));
                $result_cccncs = $db_cccncs->fetchAll($select_cccncs);
		        $row_cccncs = $result_cccncs->current();
		        $cncs = $row_cccncs['somme_cccncs'];
				
				
				$db_escompte     = new Application_Model_DbTable_EuAncienEchange();
				$select_escompte = $db_escompte->select();
				$select_escompte->from($db_escompte,array('SUM(montant) as somme_escompte'));
                $select_escompte->where('code_membre = ?', $code_membre);
				$select_escompte->where('type_echange like ?','NR/NN');
                $result_escompte   = $db_escompte->fetchAll($select_escompte);
		        $row_escompte = $result_escompte->current();
		        $escompte = $row_escompte['somme_escompte'];
				
				
				$db_echange      = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_echange  = $db_echange->select();
				$select_echange->from($db_echange,array('SUM(montant_place) as somme_echange'));
                //$select_echange->where('code_membre = ?', $code_membre);
				$select_echange->where('compte_source like ?','NR-TCNCS-'.$code_membre);
				$select_echange->orwhere('compte_source like ?','NN-TCNCS-'.$code_membre);
                $result_echange   = $db_echange->fetchAll($select_echange);
		        $row_echange = $result_echange->current();
		        $echange = $row_echange['somme_echange'];
				
				
				/*
				$db_ccnr = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_ccnr = $db_ccnr->select();
				$select_ccnr->from($db_ccnr,array('SUM(montant_credit) as somme_ccnr'));
                $select_ccnr->where('code_membre = ?', $code_membre);
				$select_ccnr->where('code_produit in (?)',array('CNCSr','CNCSnr'));
                $result_ccnr = $db_ccnr->fetchAll($select_ccnr);
		        $row_ccnr = $result_ccnr->current();
		        $soldenr = $row_ccnr['somme_ccnr'];*/
				
				
				
                 
				if(substr($code_membre,19,1) == 'M')  {
				    $db_cnn = new Application_Model_DbTable_EuAncienCompte();
				    $select_cnn = $db_cnn->select();
				    $select_cnn->from($db_cnn,array('SUM(solde) as somme_cnn'));
                    $select_cnn->where('code_membre = ?', $code_membre);
				    $select_cnn->where('code_cat in (?)',array('TCNCSEI','TPN','TCNCS'));
                    $result_cnn = $db_cnn->fetchAll($select_cnn);
		            $row_cnn = $result_cnn->current();
		            $soldenn = $row_cnn['somme_cnn'];
				
				} else {
				    $soldenn = abs($cncs-$escompte-$echange);
				
				}	


			$code_membre    = $code_membre;
			$designation    = $designation;
		    $cncs           = $cncs;
			$escompte       = $escompte;
			$echange        = $echange;
		    $soldenn        = $soldenn;		   
	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
		   
		if ($code_membre != '' || $code_membre != null) {
            $select->where('eu_ancien_compte_credit.code_membre = ?',$code_membre);
		} else {
            $code_membre = '%';
        }
		$select->where('eu_ancien_compte_credit.code_produit in (?)', array('CNCSnr','CNCSr'));
		$select->order('eu_ancien_compte_credit.date_octroi asc');
        $detailsalaire = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienEchange();
        $select = $tabela->select();
		if ($code_membre != '' || $code_membre != null) {
           $select->where('eu_ancien_echange.code_membre = ?',$code_membre);
		}
		$select->where('eu_ancien_echange.type_echange like ?','NR/NN');
        $select->order('date_echange asc');
        $escomptesalaire = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $select = $tabela->select();
	    if ($code_membre != '' || $code_membre != null) {
           //$select->where('eu_ancien_compte_credit.code_membre = ?',$code_membre);
		} else {
           $code_membre = '%';
        }		
		$select->where('eu_ancien_compte_credit.compte_source like ?','NR-TCNCS-'.$code_membre);
		$select->orwhere('eu_ancien_compte_credit.compte_source like ?','NN-TCNCS-'.$code_membre);
		$select->order('eu_ancien_compte_credit.date_octroi asc');
        $echangesalaire = $tabela->fetchAll($select);



$membre = (string)$this->_request->getParam('code');

$membree = new Application_Model_EuAncienMembre();
$mapper_membree = new Application_Model_EuAncienMembreMapper();
$mapper_membree->find($membre, $membree);
if (substr($membre, -1) == "P") {
$nom_membree = $membree->nom_membre.' '.$membree->prenom_membre;
} else if (substr($membre, -1) == "M") {
$nom_membree = $membree->raison_sociale;
}


$html = "";

$html .= '
    <page backbottom="15mm">
    <page_footer>
        <table>
<tr>
    <td align="center">
	<hr>
	Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425 - [ Page [[page_cu]] / [[page_nb]] ]</td>
  </tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><barcode type="C128B" value="'.$membre.'" style="height:10mm;" label="none"></barcode></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>
<strong><u><h3>RELEVE SALAIRE CNCS</h3></u></strong>
Membre : '.$nom_membree.' <strong style="font-size:16px;">('.$membre.')</strong><br />
Date d&rsquo;émission  du relevé : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>';

$html .= '
        

	





  <blockquote>Récapitulatif</blockquote>
<table>
    <thead>
        <tr>
            <th align="right">CNCS Global</th>
            <th align="right">CNCS Escompté</th>
            <th align="right">CNCS Echangé</th>
            <th align="right">Solde CNCS</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td align="right"><strong>'.number_format($cncs,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($escompte,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($echange,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($soldenn,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>




  <blockquote>Détails salaires affectés</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Compte origine</th>
            <th align="center">Produit</th>
            <th align="right">Montant</th>
            <th align="center">Date</th>
        </tr>
    </thead>
    <tbody>
    ';

$montant = 0;
$html .= '

';

foreach ($detailsalaire as $entry): 
$html .= '

        <tr>
          <td align="left">'.$entry->compte_source.'</td>
          <td align="center">'.$entry->code_produit.'</td>
          <td align="right"><strong>'.number_format($entry->montant_place,0,',',' ').'</strong></td>
          ';

$date_op = new Zend_Date($entry->date_octroi, Zend_Date::ISO_8601);
$html .= '

          <td align="center">'.$date_op->toString('dd/MM/yyyy').'</td>
        </tr>
    ';

$montant += $entry->montant_place;
$html .= '

';

endforeach; 
$html .= '

        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($montant,0,',',' ').'</strong></td>
          <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>





  <blockquote>Détails salaires escomptés</blockquote>
<table>
    <thead>
        <tr>
            <th align="center">Produit</th>
            <th align="left">Compte Destinataire</th>
            <th align="right">Montant</th>
            <th align="center">Date</th>
        </tr>
    </thead>
    <tbody>
    ';

$montant = 0;
$html .= '

';

foreach ($escomptesalaire as $entry): 
$html .= '

        <tr>
          <td align="center">'.$entry->cat_echange.'</td>
          <td align="left">'.$entry->code_compte_obt.'</td>
          <td align="right"><strong>'.number_format($entry->montant,0,',',' ').'</strong></td>
          ';

$date_op = new Zend_Date($entry->date_echange, Zend_Date::ISO_8601);
$html .= '

          <td align="center">'.$date_op->toString('dd/MM/yyyy').'</td>
        </tr>
    ';

$montant += $entry->montant;
$html .= '

';

endforeach; 
$html .= '

        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($montant,0,',',' ').'</strong></td>
          <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>







  <blockquote>Détails salaires échangés</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Compte origine</th>
            <th align="left">Compte Destinataire</th>
            <th align="right">Montant</th>
            <th align="center">Date</th>
        </tr>
    </thead>
    <tbody>
    ';

$montant = 0;
$html .= '

';

foreach ($echangesalaire as $entry): 
$html .= '

        <tr>
          <td align="left">'.$entry->compte_source.'</td>
          <td align="left">'.$entry->code_compte.'</td>
          <td align="right"><strong>'.number_format($entry->montant_place,0,',',' ').'</strong></td>
          ';

$date_op = new Zend_Date($entry->date_octroi, Zend_Date::ISO_8601);
$html .= '

          <td align="center">'.$date_op->toString('dd/MM/yyyy').'</td>
        </tr>
    ';

$montant += $entry->montant_place;
$html .= '

';

endforeach; 
$html .= '

        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($montant,0,',',' ').'</strong></td>
          <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$html .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/releve.html';
$somecontent = $html;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("pdf_releve/")) {
mkdir("pdf_releve/", 0777);
}

$newfile = "pdf_releve/RELEVE_SALAIRE_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html"	;
$newnom = "RELEVE_SALAIRE_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_releve/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';

unlink($newfile);

	
		$this->_redirect($file);
	    
    }
	















	 public function relevecreditpdfAction() {
    
	
        /* page index/relevecreditpdf - Génération de relevé rpg/i en PDF */

		$this->_helper->layout->disableLayout();
		

		include("Transfert.php");
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);
		
	            $code_membre =  (string)$this->_request->getParam('code');

        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $compte = '';
        $membre = (string)$this->_request->getParam('code');
		$origine = '';
		
		
		if($membre != '' && $compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else
		if($compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->order('date_octroi asc');
		} else
        if ($compte != '' or $compte != null) {
		    $select = $tabela->select();
            $select->where('code_produit = ?', $compte);
			$select->order('date_octroi asc');
        } else
		if ($origine != '' or $origine != null) {
		    $select = $tabela->select();
            $select->where('compte_source like ?',$origine.'%');
		    $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
            			
        } else
        if ($membre != '' or $membre != null) {
		    $select = $tabela->select();
            $select->where('code_membre = ?', $membre);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
			$select->order('date_octroi asc');
        } else {
		    $select = $tabela->select();
            $select->from($tabela);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
		}
        		
		
        $creditrpgi = $tabela->fetchAll($select);






			$code_membre    = $code_membre;



$membre = (string)$this->_request->getParam('code');

$membree = new Application_Model_EuAncienMembre();
$mapper_membree = new Application_Model_EuAncienMembreMapper();
$mapper_membree->find($membre, $membree);
if (substr($membre, -1) == "P") {
$nom_membree = $membree->nom_membre.' '.$membree->prenom_membre;
} else if (substr($membre, -1) == "M") {
$nom_membree = $membree->raison_sociale;
}


$html = "";

$html .= '
    <page backbottom="15mm">
    <page_footer>
        <table>
<tr>
    <td align="center">
	<hr>
	Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425 - [ Page [[page_cu]] / [[page_nb]] ]</td>
  </tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><barcode type="C128B" value="'.$membre.'" style="height:10mm;" label="none"></barcode></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>
<strong><u><h3>RELEVE RPG/I</h3></u></strong>
Membre : '.$nom_membree.' <strong style="font-size:16px;">('.$membre.')</strong><br />
Date d&rsquo;émission  du relevé : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>';

$html .= '
        

	





  <blockquote>Compte RPG et I</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Compte</th>
            <th align="center">Produit</th>
            <th align="right">Montant CAPA</th>
            <th align="right">Montant Revenu</th>
            <th align="center">Date Début</th>
            <th align="center">Date Fin</th>
        </tr>
    </thead>
    <tbody>';
$montantplace = 0;
$html .= '
';
$montantcredit = 0;
$html .= '

';
foreach ($creditrpgi as $entry): 
$html .= '
        <tr>
          <td align="left">'.$entry->code_compte.'</td>
          <td align="center">'.$entry->code_produit.'</td>
          <td align="right"><strong>'.number_format($entry->montant_place,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($entry->montant_credit,0,',',' ').'</strong></td>
          ';
$date_deb = new Zend_Date($entry->datedeb, Zend_Date::ISO_8601);
$html .= '<td align="center">'.$date_deb->toString('dd/MM/yyyy').'</td>
          ';
$date_fin = new Zend_Date($entry->datefin, Zend_Date::ISO_8601);
$html .= '

          <td align="center">'.$date_fin->toString('dd/MM/yyyy').'</td>
        </tr>';
$montantplace += $entry->montant_place;
$html .= '
';
$montantcredit += $entry->montant_credit;
$html .= '

';
endforeach; 
$html .= '

        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Totaux</strong></td>
          <td align="right"><strong>'.number_format($montantplace,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($montantcredit,0,',',' ').'</strong></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$html .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/releve.html';
$somecontent = $html;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("pdf_releve/")) {
mkdir("pdf_releve/", 0777);
}

$newfile = "pdf_releve/RELEVE_RPG_I_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html"	;
$newnom = "RELEVE_RPG_I_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_releve/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';

unlink($newfile);

	
		$this->_redirect($file);
	    
    }
	











	 public function relevegcppdfAction() {
    
	
        /* page index/relevegcppdf - Génération de relevé gcp en PDF */

		$this->_helper->layout->disableLayout();
		

		include("Transfert.php");
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);
		

		$code_membre  = '';
		$designation  = '';
		$gcp          = 0;
		$escompte     = 0;
		$echange      = 0;
		$reste        = 0;
		$echu         = 0;
	            $code_membre =  (string)$this->_request->getParam('code');

				$designation = "";
    
		   $db_gcp = new Application_Model_DbTable_EuAncienGcp();
		   $select_gcp = $db_gcp->select();
           $select_gcp->from($db_gcp,array('SUM(mont_gcp) as somme_gcp'));
           $select_gcp->where('code_membre = ?', $code_membre);
           $result_gcp = $db_gcp->fetchAll($select_gcp);
		   $row_gcp = $result_gcp->current();
		   $gcp = $row_gcp['somme_gcp'];
		   
		   
		   $db_escompte = new Application_Model_DbTable_EuAncienEscompte();
		   $select_escompte = $db_escompte->select();
		   $select_escompte->from($db_escompte,array('SUM(montant) as somme_escompte'));
		   $select_escompte->where('code_membre = ?', $code_membre);
		   $result_escompte = $db_escompte->fetchAll($select_escompte);
		   $row_escompte = $result_escompte->current();
		   $escompte = $row_escompte['somme_escompte'];
		   
		   
		   $db_echange = new Application_Model_DbTable_EuAncienEchange();
		   $select_echange = $db_echange->select();
		   $select_echange->from($db_echange,array('SUM(montant) as somme_echange'));
		   $select_echange->where('code_membre = ?', $code_membre);
		   $select_echange->where('type_echange = ?','NB/NB');
		   $result_echange = $db_echange->fetchAll($select_echange);
		   $row_echange = $result_echange->current();
		   $echange = $row_echange['somme_echange'];
		   $reste = floor($gcp - $escompte - $echange);
		   
		   
		   $db_tpagcp = new Application_Model_DbTable_EuAncienTpagcp();
		   $select_tpagcp = $db_tpagcp->select();
		   $select_tpagcp->from($db_tpagcp,array('SUM(mont_echu) as somme_echu'));
		   $select_tpagcp->where('code_membre = ?', $code_membre);
		   $result_tpagcp = $db_tpagcp->fetchAll($select_tpagcp);
		   $row_tpagcp = $result_tpagcp->current();
		   $echu = $row_tpagcp['somme_echu'];


		$code_membre = $code_membre;
		$designation = $designation;
		$gcp         = $gcp;
		$escompte    = $escompte;
		$echange     = $echange;
		$reste       = $reste;
		$echue       = $echu;	
	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienGcp();
		//if ($code_membre != '' || $code_membre != null) {
            $select = $tabela->select()->setIntegrityCheck(false);
            $select->from($tabela, array('id_gcp','date_conso', 'mont_gcp', 'mont_preleve', 'reste', 'code_cat', 'id_credit'))
		           ->join('eu_ancien_compte_credit', 'eu_ancien_compte_credit.id_credit = eu_ancien_gcp.id_credit', array('code_membre', 'code_produit'));
            $select->order('eu_ancien_gcp.date_conso asc');
			if ($code_membre != '' || $code_membre != null) {
			   $select->where('eu_ancien_gcp.code_membre like ?',$code_membre);
			}
            $consult = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienEscompte();
        $select = $tabela->select()->setIntegrityCheck(false);
		$select->from($tabela,array('*'));
		$select->join('eu_ancien_membre','eu_ancien_membre.ancien_code_membre = eu_ancien_escompte.code_membre_benef');
		if ($code_membre != '' || $code_membre != null) {
            $select->where('eu_ancien_escompte.code_membre like ?',$code_membre);
		}
        $select->order('eu_ancien_escompte.date_escompte asc');
        $escomptes = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

        $tabela = new Application_Model_DbTable_EuAncienEchange();
        $select = $tabela->select();
		
		if ($code_membre != '' || $code_membre != null) {
           $select->where('eu_ancien_echange.code_membre like ?', $code_membre);
		}   
		$select->where('eu_ancien_echange.type_echange like ?','NB/NB');
        $select->order('date_echange asc');
        $echanges = $tabela->fetchAll($select);




$membre = (string)$this->_request->getParam('code');

$membree = new Application_Model_EuAncienMembre();
$mapper_membree = new Application_Model_EuAncienMembreMapper();
$mapper_membree->find($membre, $membree);
if (substr($membre, -1) == "P") {
$nom_membree = $membree->nom_membre.' '.$membree->prenom_membre;
} else if (substr($membre, -1) == "M") {
$nom_membree = $membree->raison_sociale;
}


$html = "";

$html .= '
<page backbottom="15mm">
    <page_footer>
        <table>
<tr>
    <td align="center">
	<hr>
	Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425 - [ Page [[page_cu]] / [[page_nb]] ]</td>
  </tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><barcode type="C128B" value="'.$membre.'" style="height:10mm;" label="none"></barcode></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>
<strong><u><h3>RELEVE GCp</h3></u></strong>
Membre : '.$nom_membree.' <strong style="font-size:16px;">('.$membre.')</strong><br />
Date d&rsquo;émission  du relevé : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>';

$html .= '
        

	





  <blockquote>Récapitulatif</blockquote>
<table>
    <thead>
        <tr>
            <th align="right">Total GCP</th>
            <th align="right">GCP escomptées</th>
            <th align="right">GCP echangées en I et RPG</th>
            <th align="right">Solde GCP</th>
            <th align="right">GCP échues</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td align="right"><strong>'.number_format($gcp,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($escompte,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($echange,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($reste,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($echue,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>




  <blockquote>Les ventes effectuées</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Code membre Acheteur</th>
            <th align="center">Produit</th>
            <th align="right">Montant</th>
            <th align="center">Date Opération</th>
        </tr>
    </thead>
    <tbody>
    ';
	$montant = 0;
	$html .= '
';
	foreach ($consult as $entry): 
	if($entry->code_membre == $membre){ $classes =' style="color:#F00;"'; }else{ $classes =''; }
	$html .= '
        <tr '.$classes.'>
          <td align="left">'.$entry->code_membre.'</td>
          <td align="center">'.$entry->code_produit.'</td>
          <td align="right"><strong>'.number_format($entry->mont_gcp,0,',',' ').'</strong></td>
          ';
	$date_op = new Zend_Date($entry->date_conso, Zend_Date::ISO_8601);
	$html .= '
          <td align="center">'.$date_op->toString('dd/MM/yyyy').'</td>
        </tr>
    ';
	$montant += $entry->mont_gcp;
	$html .= '
';
	endforeach; 
	$html .= '
        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($montant,0,',',' ').'</strong></td>
          <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>





  <blockquote>Les escomptes effectuées</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">PBF</th>
            <th align="left">Raison sociale</th>
            <th align="right">Montant</th>
            <th align="center">Date Escompte</th>
        </tr>
    </thead>
    <tbody>
    ';
	$montant = 0;
	$html .= '
';
	foreach ($escomptes as $entry): 
	$html .= '
        <tr>
          <td align="left">'.$entry->code_membre_benef.'</td>
          <td align="left">'.$entry->raison_sociale.'</td>
          <td align="right"><strong>'.number_format($entry->montant,0,',',' ').'</strong></td>
          ';
	$date_op = new Zend_Date($entry->date_escompte, Zend_Date::ISO_8601);
	$html .= '
          <td align="center">'.$date_op->toString('dd/MM/yyyy').'</td>
        </tr>
    ';
	$montant += $entry->montant;
	$html .= '
';
	endforeach; 
	$html .= '
        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($montant,0,',',' ').'</strong></td>
          <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>







  <blockquote>Les échanges effectués</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Type echange</th>
            <th align="left">Compte Destinataire</th>
            <th align="right">Montant</th>
            <th align="center">Date</th>
        </tr>
    </thead>
    <tbody>
    ';
	$montant = 0;
	$html .= '
';
	foreach ($echanges as $entry): 
	$html .= '
        <tr>
          <td align="left">'.$entry->type_echange.'</td>
          <td align="left">'.$entry->code_compte_obt.'</td>
          <td align="right"><strong>'.number_format($entry->montant,0,',',' ').'</strong></td>
          ';
	$date_op = new Zend_Date($entry->date_echange, Zend_Date::ISO_8601);
	$html .= '
          <td align="center">'.$date_op->toString('dd/MM/yyyy').'</td>
        </tr>
    ';
	$montant += $entry->montant;
	$html .= '
';
	endforeach; 
	$html .= '
        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($montant,0,',',' ').'</strong></td>
          <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$html .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/releve.html';
$somecontent = $html;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("pdf_releve/")) {
mkdir("pdf_releve/", 0777);
}

$newfile = "pdf_releve/RELEVE_GCP_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html"	;
$newnom = "RELEVE_GCP_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_releve/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';

unlink($newfile);

	
		$this->_redirect($file);
	    
    }
	











	 public function relevekacmpdfAction() {
    
	
        /* page index/relevekacmpdf - Génération de relevé kacm en PDF */

		$this->_helper->layout->disableLayout();
		

		include("Transfert.php");
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);
		

		   $code_membre  = '';
		   $designation  = '';
		   $fs           = 0;
		   $fl           = 0;
		   $fcps         = 0;
		   
		   $fsu          = 0;
		   $flu          = 0;
		   $fcpsu        = 0;
		   
		   $fsnu         = 0;
		   $flnu         = 0;
		   $fcpsnu       = 0;
		   
		   $kacm         = 0;

	            $code_membre =  (string)$this->_request->getParam('code');

				$designation = "";
    
				$db_fs = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fs = $db_fs->select();
				$select_fs->from($db_fs,array('SUM(CreditAmount) as somme_fs'));
				
				if($code_membre != '') {
                  $select_fs->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fs->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fs->where('Motif like ?','FS');
                $result_fs = $db_fs->fetchAll($select_fs);
		        $row_fs = $result_fs->current();
		        $fs = $row_fs['somme_fs'];
				
				$db_fl = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fl = $db_fl->select();
				$select_fl->from($db_fl,array('SUM(CreditAmount) as somme_fl'));
				
				if($code_membre != '') {
                  $select_fl->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fl->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fl->where('Motif like ?','FL');
                $result_fl = $db_fl->fetchAll($select_fl);
		        $row_fl = $result_fl->current();
		        $fl = $row_fl['somme_fl'];
				
				
				$db_cps = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cps = $db_cps->select();
				$select_cps->from($db_cps,array('SUM(CreditAmount) as somme_cps'));
				
				if($code_membre != '') {
                  $select_cps->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cps->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cps->where('Motif like ?','CPS');
                $result_cps = $db_cps->fetchAll($select_cps);
		        $row_cps = $result_cps->current();
		        $fcps = $row_cps['somme_cps'];
				
				
				$db_fsu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fsu = $db_fsu->select();
				$select_fsu->from($db_fsu,array('SUM(CreditAmount) as somme_fsu'));
				
				if($code_membre != '') {
                  $select_fsu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fsu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fsu->where('Motif like ?','FS');
				$select_fsu->where('IDDateTimeConsumed <> ?',0);
                $result_fsu = $db_fsu->fetchAll($select_fsu);
		        $row_fsu = $result_fsu->current();
		        $fsu = $row_fsu['somme_fsu'];
				
				
				$db_flu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_flu = $db_flu->select();
				$select_flu->from($db_flu,array('SUM(CreditAmount) as somme_flu'));
				
				if($code_membre != '') {
                  $select_flu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_flu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_flu->where('Motif like ?','FL');
				$select_flu->where('IDDateTimeConsumed <> ?',0);
                $result_flu = $db_flu->fetchAll($select_flu);
		        $row_flu = $result_flu->current();
		        $flu = $row_flu['somme_flu'];
				
				
				$db_cpsu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cpsu = $db_cpsu->select();
				$select_cpsu->from($db_cpsu,array('SUM(CreditAmount) as somme_cpsu'));
				
				if($code_membre != '') {
                  $select_cpsu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cpsu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cpsu->where('Motif like ?','CPS');
				$select_cpsu->where('IDDateTimeConsumed <> ?',0);
                $result_cpsu = $db_cpsu->fetchAll($select_cpsu);
		        $row_cpsu = $result_cpsu->current();
		        $fcpsu = $row_cpsu['somme_cpsu'];
				
				
				
				$db_fsnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fsnu = $db_fsnu->select();
				$select_fsnu->from($db_fsnu,array('SUM(CreditAmount) as somme_fsnu'));
				
				if($code_membre != '') {
                  $select_fsnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fsnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fsnu->where('Motif like ?','FS');
				$select_fsnu->where('IDDateTimeConsumed = ?',0);
                $result_fsnu = $db_fsnu->fetchAll($select_fsnu);
		        $row_fsnu = $result_fsnu->current();
		        $fsnu = $row_fsnu['somme_fsnu'];
				
				
				$db_flnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_flnu = $db_flnu->select();
				$select_flnu->from($db_flnu,array('SUM(CreditAmount) as somme_flnu'));
				
				if($code_membre != '') {
                  $select_flnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_flnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_flnu->where('Motif like ?','FL');
				$select_flnu->where('IDDateTimeConsumed = ?',0);
                $result_flnu = $db_flnu->fetchAll($select_flnu);
		        $row_flnu = $result_flnu->current();
		        $flnu = $row_flnu['somme_flnu'];
				
				
				$db_cpsnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cpsnu = $db_cpsnu->select();
				$select_cpsnu->from($db_cpsnu,array('SUM(CreditAmount) as somme_cpsnu'));
				
				if($code_membre != '') {
                  $select_cpsnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cpsnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cpsnu->where('Motif like ?','CPS');
				$select_cpsnu->where('IDDateTimeConsumed = ?',0);
                $result_cpsnu = $db_cpsnu->fetchAll($select_cpsnu);
		        $row_cpsnu = $result_cpsnu->current();
		        $fcpsnu = $row_cpsnu['somme_cpsnu'];


			$code_membre  = $code_membre;
			$designation  = $designation;
		    $fs           = $fs;
			$fl           = $fl;
			$fcps         = $fcps;
			
			$fsu           = $fsu;
			$flu           = $flu;
			$fcpsu         = $fcpsu;
			
			$fsnu           = $fsnu;
			$flnu           = $flnu;
			$fcpsnu         = $fcpsnu;
	
////////////////////////////////////////////////////////////////////////////////

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','FS');
			$select->order('NEng asc');
			
			$detailfs = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','FL');
			$select->order('NEng asc');
			
			$detailfl = $tabela->fetchAll($select);

	
////////////////////////////////////////////////////////////////////////////////

		   $tabela = new Application_Model_DbTable_EuAncienSmsmoney();
		   $code_membre = $this->_request->getParam("code_membre");
		   $select = $tabela->select();
		   
		    if($code_membre != '') {
	           $select->where('FromAccount like ?','NN-TR-'.$code_membre);
	        } else {
			   $select->where('FromAccount like ?','NN-TR-'.'%');
			}
			$select->where('Motif like ?','CPS');
			$select->order('NEng asc');
			
			$detailfcps = $tabela->fetchAll($select);




$membre = (string)$this->_request->getParam('code');

$membree = new Application_Model_EuAncienMembre();
$mapper_membree = new Application_Model_EuAncienMembreMapper();
$mapper_membree->find($membre, $membree);
if (substr($membre, -1) == "P") {
$nom_membree = $membree->nom_membre.' '.$membree->prenom_membre;
} else if (substr($membre, -1) == "M") {
$nom_membree = $membree->raison_sociale;
}


$html = "";

$html .= '
    <page backbottom="15mm">
    <page_footer>
        <table>
<tr>
    <td align="center">
	<hr>
	Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425 - [ Page [[page_cu]] / [[page_nb]] ]</td>
  </tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><barcode type="C128B" value="'.$membre.'" style="height:10mm;" label="none"></barcode></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>
<strong><u><h3>RELEVE FS - FL - FCPS</h3></u></strong>
Membre : '.$nom_membree.' <strong style="font-size:16px;">('.$membre.')</strong><br />
Date d&rsquo;émission  du relevé : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>';

$html .= '
        

	





  <blockquote>Récapitulatif</blockquote>
<table>
    <thead>
        <tr>
            <th align="right">FS Transférés</th>
            <th align="right">FS utilisés</th>
            <th align="right">Solde FS</th>
            <th align="right">FL Transférés</th>
            <th align="right">FL utilisés</th>
            <th align="right">Solde FL</th>
            <th align="right">FCPS Transférés</th>
            <th align="right">FCPS utilisés</th>
            <th align="right">Solde FCPS</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td align="right"><strong>'.number_format($fs,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($fsu,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($fsnu,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($fl,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($flu,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($flnu,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($fcps,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($fcpsu,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($fcpsnu,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>


<br />
<br />


  <blockquote>Détails FS</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Compte Transfert</th>
            <th align="center">Code SMS</th>
            <th align="center">Motif</th>
            <th align="right">Montant Entré</th>
            <th align="right">Montant Sorti</th>
            <th align="right">Solde</th>
        </tr>
    </thead>
    <tbody>
    ';

	
			$tot_entrees = 0;
			$tot_sorties = 0;
			$tot_solde = 0;

$html .= '
';

foreach ($detailfs as $entry): 
$html .= '
';


		      if($entry->DestAccount_Consumed == NULL) {
			    $sortie = 0;
				$solde  = $entry->CreditAmount;
			  } else {
			    $sortie = $entry->CreditAmount;
				$solde  = 0;
			  }

$html .= '
        <tr>
          <td align="left">'.$entry->FromAccount.'</td>
          <td align="center">'.$entry->CreditCode.'</td>
          <td align="center">'.$entry->Motif.'</td>
          <td align="right"><strong>'.number_format($entry->CreditAmount,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($sortie,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($solde,0,',',' ').'</strong></td>
        </tr>
    ';


			   $tot_entrees += $entry->CreditAmount;
			   $tot_sorties += $sortie;
			   $tot_solde += $solde;
	
$html .= '
';

endforeach; 
$html .= '
        <tr>
          <td align="left">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($tot_entrees,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_sorties,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_solde,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>



<br />
<br />


  <blockquote>Détails FL</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Compte Transfert</th>
            <th align="center">Code SMS</th>
            <th align="center">Motif</th>
            <th align="right">Montant Entré</th>
            <th align="right">Montant Sorti</th>
            <th align="right">Solde</th>
        </tr>
    </thead>
    <tbody>
    ';

	
			$tot_entrees = 0;
			$tot_sorties = 0;
			$tot_solde = 0;

$html .= '
';

foreach ($detailfl as $entry): 
$html .= '
';


		      if($entry->DestAccount_Consumed == NULL) {
			    $sortie = 0;
				$solde  = $entry->CreditAmount;
			  } else {
			    $sortie = $entry->CreditAmount;
				$solde  = 0;
			  }

$html .= '
        <tr>
          <td align="left">'.$entry->FromAccount.'</td>
          <td align="center">'.$entry->CreditCode.'</td>
          <td align="center">'.$entry->Motif.'</td>
          <td align="right"><strong>'.number_format($entry->CreditAmount,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($sortie,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($solde,0,',',' ').'</strong></td>
        </tr>
    ';


			   $tot_entrees += $entry->CreditAmount;
			   $tot_sorties += $sortie;
			   $tot_solde += $solde;
	
$html .= '
';

endforeach; 
$html .= '
        <tr>
          <td align="left">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($tot_entrees,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_sorties,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_solde,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>





<br />
<br />


  <blockquote>Détails FCPS</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Compte Transfert</th>
            <th align="center">Code SMS</th>
            <th align="center">Motif</th>
            <th align="right">Montant Entré</th>
            <th align="right">Montant Sorti</th>
            <th align="right">Solde</th>
        </tr>
    </thead>
    <tbody>
    ';

	
			$tot_entrees = 0;
			$tot_sorties = 0;
			$tot_solde = 0;

$html .= '
';

foreach ($detailfcps as $entry): 
$html .= '
';


		      if($entry->DestAccount_Consumed == NULL) {
			    $sortie = 0;
				$solde  = $entry->CreditAmount;
			  } else {
			    $sortie = $entry->CreditAmount;
				$solde  = 0;
			  }

$html .= '
        <tr>
          <td align="left">'.$entry->FromAccount.'</td>
          <td align="center">'.$entry->CreditCode.'</td>
          <td align="center">'.$entry->Motif.'</td>
          <td align="right"><strong>'.number_format($entry->CreditAmount,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($sortie,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($solde,0,',',' ').'</strong></td>
        </tr>
    ';


			   $tot_entrees += $entry->CreditAmount;
			   $tot_sorties += $sortie;
			   $tot_solde += $solde;
	
$html .= '
';

endforeach; 
$html .= '
        <tr>
          <td align="left">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($tot_entrees,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_sorties,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_solde,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$html .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/releve.html';
$somecontent = $html;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("pdf_releve/")) {
mkdir("pdf_releve/", 0777);
}

$newfile = "pdf_releve/RELEVE_FS_FL_FCPS_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html"	;
$newnom = "RELEVE_FS_FL_FCPS_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_releve/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';

unlink($newfile);

	
		$this->_redirect($file);
	    
    }
	








	 public function relevemf11000pppdfAction() {
    
	
        /* page index/relevemf11000pppdf - Génération de relevé mf11000 pp en PDF */

		$this->_helper->layout->disableLayout();
		

		include("Transfert.php");
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);
		


			$num_bon          = '';
			$nom              = '';
            $code_membre      = '';
	        $designation      = '';
		    $mf11000_recu     = 0;
		    $mf11000_vendu    = 0;
		    $mf11000_restant  = 0;
		   
		    $entrees     = 0;
		    $sorties     = 0;
		    $solde       = 0;
		   
	            $num_bon =  (string)$this->_request->getParam('code');
    
				$nom = "";

				    $db_entrees = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_entrees = $db_entrees->select();
			        $select_entrees->from($db_entrees,array('SUM(mont_rep) as somme_entrees'));
			        $select_entrees->where('code_mf11000 like ?',$num_bon);
			        $result_entrees     = $db_entrees->fetchAll($select_entrees);
		            $row_entrees        = $result_entrees->current();
		            $entrees  = $row_entrees['somme_entrees'];
					
					$db_sorties = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_sorties = $db_sorties->select();
			        $select_sorties->from($db_sorties,array('SUM(mont_reglt) as somme_sorties'));
			        $select_sorties->where('code_mf11000 like ?',$num_bon);
			        $result_sorties     = $db_sorties->fetchAll($select_sorties);
		            $row_sorties        = $result_sorties->current();
		            $sorties  = $row_sorties['somme_sorties'];
					
					
					$db_solde = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_solde = $db_solde->select();
			        $select_solde->from($db_solde,array('SUM(solde_rep) as solde'));
			        $select_solde->where('code_mf11000 like ?',$num_bon);
			        $result_solde     = $db_solde->fetchAll($select_solde);
		            $row_solde        = $result_solde->current();
		            $solde  = $row_solde['solde'];
				
				


			$code_membre     = $code_membre;
			$designation     = $designation;
			$num_bon         = $num_bon;
			$nom             = $nom;
		    $mf11000_recu    = $mf11000_recu;
			$mf11000_vendu   = $mf11000_vendu;
			$mf11000_restant = $mf11000_restant;
			
			$entrees    = $entrees;
			$sorties    = $sorties;
			$solde      = $solde;
	
////////////////////////////////////////////////////////////////////////////////

		    $tabela = new Application_Model_DbTable_EuRepartitionMf11000();
		    //$num_bon = $this->_request->getParam("num_bon");
		    $select = $tabela->select();
	        $select->where('code_mf11000 like ?',$num_bon);
			$select->order('id_rep asc');
			
			$detailbon = $tabela->fetchAll($select);




$membre = (string)$this->_request->getParam('code');

$membree = new Application_Model_EuMembreFondateur11000();
$mapper_membree = new Application_Model_EuMembreFondateur11000Mapper();
$mapper_membree->find($membre, $membree);
$nom_membree = $membree->nom.' '.$membree->prenom;


$html = "";

$html .= '
    <page backbottom="15mm">
    <page_footer>
        <table>
<tr>
    <td align="center">
	<hr>
	Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425 - [ Page [[page_cu]] / [[page_nb]] ]</td>
  </tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><barcode type="C128B" value="'.$membre.'" style="height:10mm;" label="none"></barcode></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>
<strong><u><h3>RELEVE MF11000 PERSONNE PHYSIQUE</h3></u></strong>
Membre : '.$nom_membree.' <strong style="font-size:16px;">('.$membre.')</strong><br />
Date d&rsquo;émission  du relevé : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>';

$html .= '
        

	





  <blockquote>Récapitulatif</blockquote>
<table>
    <thead>
        <tr>
            <th align="right">Total Unité MF11000 reçu</th>
            <th align="right">Total Unité MF11000 utilisé</th>
            <th align="right">Total Unité MF11000 restant</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td align="right"><strong>'.number_format($entrees,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($sorties,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($solde,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>


<br />
<br />


  <blockquote>Détails MF11000</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Numero Bon</th>
            <th align="center">Ressource</th>
            <th align="right">Montant reçu</th>
            <th align="right">Montant utilisé</th>
            <th align="right">Solde</th>
        </tr>
    </thead>
    <tbody>
    ';

			   $tot_entrees = 0;
			   $tot_sorties = 0;
			   $tot_solde = 0;
	
$html .= '

';
foreach ($detailbon as $entry): 
$html .= '

        <tr>
          <td align="left">'.$entry->code_mf11000.'</td>
          <td align="center">'.'MF11000'.'</td>
          <td align="right"><strong>'.number_format($entry->mont_rep,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($entry->mont_reglt,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($entry->solde_rep,0,',',' ').'</strong></td>
        </tr>
    ';

			    $tot_entrees += $entry->mont_rep;
			    $tot_sorties += $entry->mont_reglt;
			    $tot_solde += $entry->solde_rep;
	
$html .= '

';
endforeach; 
$html .= '

        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($tot_entrees,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_sorties,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_solde,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$html .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/releve.html';
$somecontent = $html;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("pdf_releve/")) {
mkdir("pdf_releve/", 0777);
}

$newfile = "pdf_releve/RELEVE_MF11000_PP_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html"	;
$newnom = "RELEVE_MF11000_PP_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_releve/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';

unlink($newfile);

	
		$this->_redirect($file);
	    
    }
	








	 public function relevemf11000pmpdfAction() {
    
	
        /* page index/relevemf11000pmpdf - Génération de relevé mf11000 pm en PDF */

		$this->_helper->layout->disableLayout();
		

		include("Transfert.php");
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);
		

			$num_bon          = '';
			$nom              = '';
            $code_membre      = '';
	        $designation      = '';
		    $mf11000_recu     = 0;
		    $mf11000_vendu    = 0;
		    $mf11000_restant  = 0;
		   
		    $entrees     = 0;
		    $sorties     = 0;
		    $solde       = 0;
		   
	            $code_membre =  (string)$this->_request->getParam('code');

				$designation = "";
    

			    $db_dsms = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsms = $db_dsms->select();
			    $select_dsms->from($db_dsms,array('SUM(mont_sms) as somme_mf'));
			    $select_dsms->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsms->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsms->where('code_membre_dist like ?','%');
                }
			    $result_dsms = $db_dsms->fetchAll($select_dsms);
		        $row_dsms = $result_dsms->current();
		        $mf11000_recu = $row_dsms['somme_mf'];
			   
			   
			    $db_dsmsv = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsmsv = $db_dsmsv->select();
			    $select_dsmsv->from($db_dsmsv,array('SUM(mont_vendu) as somme_vendu'));
			    $select_dsmsv->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsmsv->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsmsv->where('code_membre_dist like ?','%');
                }
			    $result_dsmsv = $db_dsmsv->fetchAll($select_dsmsv);
		        $row_dsmsv = $result_dsmsv->current();
		        $mf11000_vendu = $row_dsmsv['somme_vendu'];
			   
			    $db_dsmss = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsmss = $db_dsmss->select();
			    $select_dsmss->from($db_dsmss,array('SUM(solde_sms) as somme_sms'));
			    $select_dsmss->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsmss->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsmss->where('code_membre_dist like ?','%');
                }
			    $result_dsmss     = $db_dsmss->fetchAll($select_dsmss);
		        $row_dsmss        = $result_dsmss->current();
		        $mf11000_restant  = $row_dsmss['somme_sms'];
				
				


			$code_membre     = $code_membre;
			$designation     = $designation;
			$num_bon         = $num_bon;
			$nom             = $nom;
		    $mf11000_recu    = $mf11000_recu;
			$mf11000_vendu   = $mf11000_vendu;
			$mf11000_restant = $mf11000_restant;
			
			$entrees    = $entrees;
			$sorties    = $sorties;
			$solde      = $solde;
	
////////////////////////////////////////////////////////////////////////////////

		    $tabela = new Application_Model_DbTable_EuAncienDetailSmsmoney();
		    $select = $tabela->select();
		    if($code_membre != '') {
	           $select->where('code_membre_dist like ?',$code_membre);
	        } else {
			   $select->where('code_membre_dist like ?','%');
			}
			$select->where('origine_sms like ?','MF');
			$select->order('id_detail_smsmoney asc');
			
			$detailmf11000 = $tabela->fetchAll($select);




$membre = (string)$this->_request->getParam('code');

$membree = new Application_Model_EuAncienMembre();
$mapper_membree = new Application_Model_EuAncienMembreMapper();
$mapper_membree->find($membre, $membree);
if (substr($membre, -1) == "P") {
$nom_membree = $membree->nom_membre.' '.$membree->prenom_membre;
} else if (substr($membre, -1) == "M") {
$nom_membree = $membree->raison_sociale;
}


$html = "";

$html .= '
    <page backbottom="15mm">
    <page_footer>
        <table>
<tr>
    <td align="center">
	<hr>
	Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425 - [ Page [[page_cu]] / [[page_nb]] ]</td>
  </tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><barcode type="C128B" value="'.$membre.'" style="height:10mm;" label="none"></barcode></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>
<strong><u><h3>RELEVE MF11000 PERSONNE MORALE</h3></u></strong>
Membre : '.$nom_membree.' <strong style="font-size:16px;">('.$membre.')</strong><br />
Date d&rsquo;émission  du relevé : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>';

$html .= '
        

	





  <blockquote>Récapitulatif</blockquote>
<table>
    <thead>
        <tr>
            <th align="right">Total Unité MF11000 reçu</th>
            <th align="right">Total Unité MF11000 vendu</th>
            <th align="right">Total Unité MF11000 restant</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td align="right"><strong>'.number_format($mf11000_recu,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($mf11000_vendu,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($mf11000_restant,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>


<br />
<br />


  <blockquote>Détails MF11000</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Numero Bon / Code membre</th>
            <th align="center">Ressource</th>
            <th align="right">Montant reçu</th>
            <th align="right">Montant vendu</th>
            <th align="right">Solde</th>
        </tr>
    </thead>
    <tbody>
    ';

			   $tot_entrees = 0;
			   $tot_sorties = 0;
			   $tot_solde = 0;
	
$html .= '

';
foreach ($detailmf11000 as $entry): 
$html .= '

';

		        if($entry->num_bon == null) {
				  $numero = $entry->code_membre;
			    } else {
			      $numero = $entry->num_bon;
			    }

$html .= '

        <tr>
          <td align="left">'.$numero.'</td>
          <td align="center">'.$entry->origine_sms.'11000'.'</td>
          <td align="right"><strong>'.number_format($entry->mont_sms,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($entry->mont_vendu,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($entry->solde_sms,0,',',' ').'</strong></td>
        </tr>
    ';

			    $tot_entrees += $entry->mont_sms;
			    $tot_sorties += $entry->mont_vendu;
			    $tot_solde += $entry->solde_sms;
	
$html .= '

';
endforeach; 
$html .= '

        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($tot_entrees,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_sorties,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_solde,0,',',' ').'</strong></td>
        </tr>
      <tr>
        <td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$html .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/releve.html';
$somecontent = $html;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("pdf_releve/")) {
mkdir("pdf_releve/", 0777);
}

$newfile = "pdf_releve/RELEVE_MF11000_PM_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html"	;
$newnom = "RELEVE_MF11000_PM_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_releve/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';

unlink($newfile);

	
		$this->_redirect($file);
	    
    }
	










	 public function relevemf107pdfAction() {
    
	
        /* page index/relevemf107pdf - Génération de relevé mf107 en PDF */

		$this->_helper->layout->disableLayout();
		

		include("Transfert.php");
		
$date_id = new Zend_Date(Zend_Date::ISO_8601);
		

		    $code_membre  = '';
		    $designation  = '';
		    $soldemf107   = 0;
		   
	            $code_membre =  (string)$this->_request->getParam('code');

				$designation = "";
    

			        $anciencompte_nn   = new Application_Model_EuAncienCompte();
		            $anciencm_map      = new Application_Model_EuAncienCompteMapper();
					$date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
			        $rep = new Application_Model_EuRepartitionMf107();
			        $m_rep = new Application_Model_EuRepartitionMf107Mapper();
			        $dmf = new Application_Model_EuDetailMf107();
			        $mdmf = new Application_Model_EuDetailMf107Mapper();
			        $mf107 = new Application_Model_EuMembreFondateur107();
			        $mmf107 = new Application_Model_EuMembreFondateur107Mapper();
			        $montant = 0;
			        $nb_dmf = 0;
			        $code_compteancien = 'NN-TR-'.$code_membre;
					$soldemf107 = $m_rep->findSum($code_membre);	
				
				
			$code_membre  = $code_membre;
			$designation  = $designation;
            $soldemf107  = $soldemf107;			
	
////////////////////////////////////////////////////////////////////////////////

			$mf107  = new Application_Model_EuMembreFondateur107();
			$mmf107 = new Application_Model_EuMembreFondateur107Mapper();
		    $tabela = new Application_Model_DbTable_EuRepartitionMf107();
		    $select = $tabela->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            $select->setIntegrityCheck(false)
                   ->join('eu_detail_mf107', 'eu_detail_mf107.id_mf107 = eu_repartition_mf107.id_mf107',array('code_membre','id_mf107','mont_apport','pourcentage','numident'));
		    $select->where('eu_repartition_mf107.code_membre like ?',$code_membre);
			//$select->order('eu_repartition_mf107.id_rep asc');
			$select->order('eu_detail_mf107.code_membre asc');
		    //$select = $tabela->select();
	        
			$detailmf107 = $tabela->fetchAll($select);
			



$membre = (string)$this->_request->getParam('code');

$membree = new Application_Model_EuAncienMembre();
$mapper_membree = new Application_Model_EuAncienMembreMapper();
$mapper_membree->find($membre, $membree);
if (substr($membre, -1) == "P") {
$nom_membree = $membree->nom_membre.' '.$membree->prenom_membre;
} else if (substr($membre, -1) == "M") {
$nom_membree = $membree->raison_sociale;
}


$html = "";

$html .= '
    <page backbottom="15mm">
    <page_footer>
        <table>
<tr>
    <td align="center">
	<hr>
	Conseil en Organisation des Affaires Commerciales, Recherche & Developpement de logiciels, Exploitation du Progiciel <span style="color:#F00;">MCNP</span>, Commerce sur Internet - RCCM N° : TG-LOME 2014 B 514 - N°FISCAL 1455870 - N°CNCS 42425 - [ Page [[page_cu]] / [[page_nb]] ]</td>
  </tr>
        </table>
    </page_footer>

<table width="768" border="0">
  <tr>
    <td colspan="2"><img src="'.Util_Utils::getParamEsmc(2).'/images/entete.gif" width="738" height="156" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><barcode type="C128B" value="'.$membre.'" style="height:10mm;" label="none"></barcode></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td>
<strong><u><h3>RELEVE MF107 </h3></u></strong>
Membre : '.$nom_membree.' <strong style="font-size:16px;">('.$membre.')</strong><br />
Date d&rsquo;émission  du relevé : <strong>'.$date_id->toString('dd-MM-yyyy').'</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>';

$html .= '
        

	





  <blockquote>Récapitulatif</blockquote>
<table>
    <thead>
        <tr>
            <th align="right">Solde MF107</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td align="right"><strong>'.number_format($soldemf107,0,',',' ').'</strong></td>
        </tr>
    </tbody>
</table>


<br />
<br />


  <blockquote>Détails MF107</blockquote>
<table>
    <thead>
        <tr>
            <th align="left">Apporteur</th>
            <th align="center">Type</th>
            <th align="right">Montant apporté</th>
            <th align="right">% Perçu</th>
            <th align="right">Montant reçu</th>
            <th align="right">Montant utilisé</th>
            <th align="right">Solde</th>
        </tr>
    </thead>
    <tbody>
    ';

			   $tot_apport = 0;
			   $tot_pourcentage = 0;
			   $tot_entrees = 0;
			   $tot_sorties = 0;
			   $tot_solde = 0;
	
$html .= '

';
foreach ($detailmf107 as $entry): 
$html .= '

';

			$mf107  = new Application_Model_EuMembreFondateur107();
			$mmf107 = new Application_Model_EuMembreFondateur107Mapper();
			    $findmf107 = $mmf107->find($entry->numident,$mf107);
				$code_proprio = $mf107->getCode_membre();
				if(($code_proprio == $code_membre) && ($entry->code_membre == $code_membre)) {
				  $pourcentage = 100;
				}
			    elseif($code_proprio == $code_membre) {
				  $pourcentage = $entry->pourcentage;
				} elseif($entry->code_membre == $code_membre) {
				  $pourcentage = 100 - $entry->pourcentage;
				}

$html .= '

        <tr>
          <td align="left">'.$entry->code_membre.'</td>
          <td align="center">'.'MF107'.'</td>
          <td align="right"><strong>'.number_format($entry->mont_apport,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($pourcentage,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($entry->mont_rep,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($entry->mont_reglt,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($entry->solde_rep,0,',',' ').'</strong></td>
        </tr>
    ';

				$tot_apport += $entry->mont_apport;
				//$tot_pourcentage += $entry->pourcentage;
			    $tot_entrees += $entry->mont_rep;
			    $tot_sorties += $entry->mont_reglt;
			    $tot_solde += $entry->solde_rep;
	
$html .= '

';
endforeach; 
$html .= '

        <tr>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>Total</strong></td>
          <td align="right"><strong>'.number_format($tot_apport,0,',',' ').'</strong></td>
          <td align="left">&nbsp;</td>
          <td align="right"><strong>'.number_format($tot_entrees,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_sorties,0,',',' ').'</strong></td>
          <td align="right"><strong>'.number_format($tot_solde,0,',',' ').'</strong></td>
        </tr>
    </tbody>
</table>

<br />
<br />
&nbsp;

</page>


  



';

$html .= '
  

';

		

////////////////////////////////////////////////////////////////////////////////
$filename = ''.Util_Utils::getParamEsmc(1).'/releve.html';
$somecontent = $html;

// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w+')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
       echo "Impossible d'écrire dans le fichier ($filename)";
       exit;
    }
    
    //echo "L'écriture de ($somecontent) dans le fichier ($filename) a réussi";
    
    fclose($handle);
                    
} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}

////////////////////////////////////////////////////////////////////////////	
$file = $filename;
if (!is_dir("pdf_releve/")) {
mkdir("pdf_releve/", 0777);
}

$newfile = "pdf_releve/RELEVE_MF107_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss')))).".html"	;
$newnom = "RELEVE_MF107_".str_replace("/", "_", mettreaccents($membre)."_".str_replace("/", "_", mettreaccents($date_id->toString('ddMMyyyyHHmmss'))));
$newchemin = "pdf_releve/"	;

copy($file, $newfile);

    ob_start();
    include(dirname(__FILE__).'/../../public/'.$newfile);
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../../public/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->writeHTML($content);
        $html2pdf->Output($newchemin.$newnom.'.pdf', "F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

$file = $newchemin.$newnom.'.pdf';

unlink($newfile);

	
		$this->_redirect($file);
	    
    }
	








    public function trouvecode1Action() {
           
		   /* page index/trouvecode - Retrouve code membre */

            $sessionmcnp = new Zend_Session_Namespace('mcnp');
            //$this->_helper->layout->disableLayout();
            $this->_helper->layout()->setLayout('layoutpublic');
		   
		    if (isset($_POST['ok']) && $_POST['ok']=="ok") {
			
			    if ((isset($_POST['nom']) && $_POST['nom']!="") || (isset($_POST['prenom']) && $_POST['prenom']!="") || (isset($_POST['raison_sociale']) && $_POST['raison_sociale']!="")) {
			       
				    if (isset($_POST["raison_sociale"])) $raison_sociale =  strtoupper($_POST["raison_sociale"]);
                    if (isset($_POST["nom"]))            $nom = strtoupper($_POST["nom"]);
                    if (isset($_POST["prenom"]))         $prenom = strtoupper($_POST["prenom"]);
					$t_physique = new Application_Model_DbTable_Physique();
					$t_morale = new Application_Model_DbTable_Morale();
					
					
					if($nom !="" && $prenom !="") {
					    $select = $t_physique->select();
                        $select->from($t_physique)
                               ->where('nom like ?', '%'.$nom.'%')
                               ->where('prenom like ?', '%'.$prenom.'%');
					    $this->view->recherche = $t_physique->fetchAll($select);
			        
					} elseif($nom !="") {
					    $select = $t_physique->select();
                        $select->from($t_physique)
                               ->where('nom like ?', '%'.$nom.'%');
					    $this->view->recherche = $t_physique->fetchAll($select);
					
					} elseif($prenom !="") {
					    $select = $t_physique->select();
                        $select->from($t_physique)
                               ->where('prenom like ?', '%'.$prenom.'%');
					    $this->view->recherche = $t_physique->fetchAll($select);
					
					} elseif($raison_sociale !="")   {
					    $select = $t_morale->select();
                        $select->from($t_morale)
                               ->where('nomm like ?', '%'.$raison_sociale.'%');
					    $this->view->recherche = $t_morale->fetchAll($select);
					
					}
			
			    }
			
			}
   
   
   
   
    }







    public function trouvecodeAction()
    {
        /* page index/trouvecode - Retrouve code membre */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    


  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if ((isset($_POST['nom']) && $_POST['nom']!="") || (isset($_POST['prenom']) && $_POST['prenom']!="") || (isset($_POST['raison_sociale']) && $_POST['raison_sociale']!="")) {

	    if (isset($_POST["raison_sociale"])) $raison_sociale =  strtoupper($_POST["raison_sociale"]);
        if (isset($_POST["nom"])) $nom = strtoupper($_POST["nom"]);
        if (isset($_POST["prenom"])) $prenom = strtoupper($_POST["prenom"]);

        $tabela = new Application_Model_DbTable_EuAncienMembre();
		
		if($raison_sociale !="" && $nom !="" && $prenom !="") {
		    $select = $tabela->select();
            $select->from($tabela)
                   ->where('raison_sociale like ?', '%'.$raison_sociale.'%')
                   ->where('nom_membre like ?', '%'.$nom .'%')
                   ->where('prenom_membre like ?', '%'.$prenom .'%');	 		  
	        $this->view->recherche = $tabela->fetchAll($select);
	
	    } else if($raison_sociale !="" && $nom !="") {
		  $select = $tabela->select();
          $select->from($tabela,array('eu_ancien_membre'))
                 ->where('raison_sociale like ?', '%'.$raison_sociale.'%')
                 ->where('nom_membre like ?', '%'.$nom.'%');	 		  
	      $this->view->recherche = $tabela->fetchAll($select);
		   
		} else if($raison_sociale !="" && $prenom !="") {
		  $select = $tabela->select();
          $select->from($tabela,array('eu_ancien_membre'))
                 ->where('raison_sociale like ?', '%'.$raison_sociale.'%')
                 ->where('prenom_membre like ?', '%'.$prenom.'%');	 		  
	      $this->view->recherche = $tabela->fetchAll($select);
		
		} else if($nom!="" && $prenom!="") {
		   
		    $select = $tabela->select();
            $select->from($tabela,array('eu_ancien_membre'))
                  ->where('nom_membre like ?', '%'.$nom . '%')
                  ->where('prenom_membre like ?', '%'.$prenom.'%');	 		  
	        $this->view->recherche = $tabela->fetchAll($select);
		   
		} else if($raison_sociale!="") {
		       
		    $select = $tabela->select();
            $select->from($tabela)
                  ->where('raison_sociale like ?', '%'.$raison_sociale.'%');	 		  
	        $this->view->recherche = $tabela->fetchAll($select);

		} else if($nom!="") {
		    
			$select = $tabela->select();
            $select->from($tabela)
                   ->where('nom_membre like ?', '%'.$nom .'%');	 		  
	        $this->view->recherche = $tabela->fetchAll($select);

		} else if($prenom!="") {
		  $select = $tabela->select();
          $select->from($tabela)
                 ->where('prenom_membre like ?', '%'.$prenom . '%');	 		  
	      $this->view->recherche = $tabela->fetchAll($select);
		
		}


    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }










    public function relevevalidationsalaireAction()
    {
        /* page index/relevevalidationsalaire - Retrouve salaire */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

		    $code_membre  = '';
			$designation  = '';
			$cncs         = 0;
			$escompte     = 0;
			$echange      = 0;
		    $soldenr      = 0;
		    $soldenn      = 0;
		    $code_membre = '';

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    
				$db_cccncs = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_cccncs = $db_cccncs->select();
				$select_cccncs->from($db_cccncs,array('SUM(montant_place) as somme_cccncs'));
                $select_cccncs->where('code_membre = ?', $code_membre);
				$select_cccncs->where('code_produit in (?)',array('CNCSr','CNCSnr'));
                $result_cccncs = $db_cccncs->fetchAll($select_cccncs);
		        $row_cccncs = $result_cccncs->current();
		        $cncs = $row_cccncs['somme_cccncs'];
				
				
				$db_escompte     = new Application_Model_DbTable_EuAncienEchange();
				$select_escompte = $db_escompte->select();
				$select_escompte->from($db_escompte,array('SUM(montant) as somme_escompte'));
                $select_escompte->where('code_membre = ?', $code_membre);
				$select_escompte->where('type_echange like ?','NR/NN');
                $result_escompte   = $db_escompte->fetchAll($select_escompte);
		        $row_escompte = $result_escompte->current();
		        $escompte = $row_escompte['somme_escompte'];
				
				
				$db_echange      = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_echange  = $db_echange->select();
				$select_echange->from($db_echange,array('SUM(montant_place) as somme_echange'));
                //$select_echange->where('code_membre = ?', $code_membre);
				$select_echange->where('compte_source like ?','NR-TCNCS-'.$code_membre);
				$select_echange->orwhere('compte_source like ?','NN-TCNCS-'.$code_membre);
                $result_echange   = $db_echange->fetchAll($select_echange);
		        $row_echange = $result_echange->current();
		        $echange = $row_echange['somme_echange'];
				
				
				/*
				$db_ccnr = new Application_Model_DbTable_EuAncienCompteCredit();
				$select_ccnr = $db_ccnr->select();
				$select_ccnr->from($db_ccnr,array('SUM(montant_credit) as somme_ccnr'));
                $select_ccnr->where('code_membre = ?', $code_membre);
				$select_ccnr->where('code_produit in (?)',array('CNCSr','CNCSnr'));
                $result_ccnr = $db_ccnr->fetchAll($select_ccnr);
		        $row_ccnr = $result_ccnr->current();
		        $soldenr = $row_ccnr['somme_ccnr'];*/
				
				
				
                 
				if(substr($code_membre,19,1) == 'M')  {
				    $db_cnn = new Application_Model_DbTable_EuAncienCompte();
				    $select_cnn = $db_cnn->select();
				    $select_cnn->from($db_cnn,array('SUM(solde) as somme_cnn'));
                    $select_cnn->where('code_membre = ?', $code_membre);
				    $select_cnn->where('code_cat in (?)',array('TCNCSEI','TPN','TCNCS'));
                    $result_cnn = $db_cnn->fetchAll($select_cnn);
		            $row_cnn = $result_cnn->current();
		            $soldenn = $row_cnn['somme_cnn'];
				
				} else {
				    $soldenn = abs($cncs-$escompte-$echange);
				
				}	


			$this->view->code_membre    = $code_membre;
			$this->view->designation    = $designation;
		    $this->view->cncs           = $cncs;
			$this->view->escompte       = $escompte;
			$this->view->echange        = $echange;
		    $this->view->soldenn        = $soldenn;		   
	
////////////////////////////////////////////////////////////////////////////////



        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
		$relev = $ma->fetchAllByTypeMembre("SALAIRE", $code_membre);
		if(count($relev) > 0){
			$this->view->trouve    = 1;
			}




  if (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
	  
$dir = "pdf_releve/";
$findme = "RELEVE_SALAIRE_".$code_membre;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			$nomfile = basename($file).PHP_EOL;
			if(stripos($nomfile, $findme) !== false){
			$releve = $dir.$file;

        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setReleve_id($compteur);
            $a->setReleve_type("SALAIRE");
            $a->setReleve_membre($code_membre);
            $a->setReleve_fichier($releve);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
	$sessionmcnp->errorlogin = "Validation bien effectuée";
			$this->view->code_membre    = "";
	$_POST['code_membre'] = "";
	$this->view->message = "";
			break;
			}else{
	$this->view->message = "Veuillez d'abord faire la demande de relevé";
				}
        }
        closedir($dh);
    }
}
			
  }



    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }









    public function relevevalidationcreditAction()
    {
        /* page index/relevevalidationcredit - Retrouve rpg/i */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
        $tabela = new Application_Model_DbTable_EuAncienCompteCredit();
        $compte = '';
        $membre = $_POST['code_membre'];
		$origine = '';
		
		
		if($membre != '' && $compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else
		if($compte != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_produit = ?', $compte);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $origine != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('compte_source like ?',$origine.'%');
		   $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		   $select->order('date_octroi asc');
		} 
		else if($membre != '' && $compte != '') {
		   $select = $tabela->select();
		   $select->where('code_membre = ?', $membre);
		   $select->where('code_produit = ?', $compte);
		   $select->order('date_octroi asc');
		} else
        if ($compte != '' or $compte != null) {
		    $select = $tabela->select();
            $select->where('code_produit = ?', $compte);
			$select->order('date_octroi asc');
        } else
		if ($origine != '' or $origine != null) {
		    $select = $tabela->select();
            $select->where('compte_source like ?',$origine.'%');
		    $select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
            			
        } else
        if ($membre != '' or $membre != null) {
		    $select = $tabela->select();
            $select->where('code_membre = ?', $membre);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
			$select->order('date_octroi asc');
        } else {
		    $select = $tabela->select();
            $select->from($tabela);
			$select->where('code_produit in (?)', array('RPGnr','RPGr','Inr','Ir'));
		    $select->order('date_octroi asc');
		}
        		
		
        $this->view->creditrpgi = $tabela->fetchAll($select);

			$this->view->code_membre    = $code_membre;


        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
		$relev = $ma->fetchAllByTypeMembre("RPG_I", $code_membre);
		if(count($relev) > 0){
			$this->view->trouve    = 1;
			}




  if (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
	  
$dir = "pdf_releve/";
$findme = "RELEVE_RPG_I_".$code_membre;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			$nomfile = basename($file).PHP_EOL;
			if(stripos($nomfile, $findme) !== false){
			$releve = $dir.$file;

        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setReleve_id($compteur);
            $a->setReleve_type("RPG_I");
            $a->setReleve_membre($code_membre);
            $a->setReleve_fichier($releve);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
	$sessionmcnp->errorlogin = "Validation bien effectuée";
			$this->view->code_membre    = "";
	$_POST['code_membre'] = "";
	$this->view->message = "";
			break;
			}else{
	$this->view->message = "Veuillez d'abord faire la demande de relevé";
				}
        }
        closedir($dh);
    }
}
			
  }



    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }










    public function relevevalidationgcpAction()
    {
        /* page index/relevevalidationgcp - Retrouve gcp */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

		$code_membre  = '';
		$designation  = '';
		$gcp          = 0;
		$escompte     = 0;
		$echange      = 0;
		$reste        = 0;
		$echu         = 0;

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    
		   $db_gcp = new Application_Model_DbTable_EuAncienGcp();
		   $select_gcp = $db_gcp->select();
           $select_gcp->from($db_gcp,array('SUM(mont_gcp) as somme_gcp'));
           $select_gcp->where('code_membre = ?', $code_membre);
           $result_gcp = $db_gcp->fetchAll($select_gcp);
		   $row_gcp = $result_gcp->current();
		   $gcp = $row_gcp['somme_gcp'];
		   
		   
		   $db_escompte = new Application_Model_DbTable_EuAncienEscompte();
		   $select_escompte = $db_escompte->select();
		   $select_escompte->from($db_escompte,array('SUM(montant) as somme_escompte'));
		   $select_escompte->where('code_membre = ?', $code_membre);
		   $result_escompte = $db_escompte->fetchAll($select_escompte);
		   $row_escompte = $result_escompte->current();
		   $escompte = $row_escompte['somme_escompte'];
		   
		   
		   $db_echange = new Application_Model_DbTable_EuAncienEchange();
		   $select_echange = $db_echange->select();
		   $select_echange->from($db_echange,array('SUM(montant) as somme_echange'));
		   $select_echange->where('code_membre = ?', $code_membre);
		   $select_echange->where('type_echange = ?','NB/NB');
		   $result_echange = $db_echange->fetchAll($select_echange);
		   $row_echange = $result_echange->current();
		   $echange = $row_echange['somme_echange'];
		   $reste = floor($gcp - $escompte - $echange);
		   
		   
		   $db_tpagcp = new Application_Model_DbTable_EuAncienTpagcp();
		   $select_tpagcp = $db_tpagcp->select();
		   $select_tpagcp->from($db_tpagcp,array('SUM(mont_echu) as somme_echu'));
		   $select_tpagcp->where('code_membre = ?', $code_membre);
		   $result_tpagcp = $db_tpagcp->fetchAll($select_tpagcp);
		   $row_tpagcp = $result_tpagcp->current();
		   $echu = $row_tpagcp['somme_echu'];


		$this->view->code_membre = $code_membre;
		$this->view->designation = $designation;
		$this->view->gcp         = $gcp;
		$this->view->escompte    = $escompte;
		$this->view->echange     = $echange;
		$this->view->reste       = $reste;
		$this->view->echue       = $echu;	
	
////////////////////////////////////////////////////////////////////////////////



        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
		$relev = $ma->fetchAllByTypeMembre("GCP", $code_membre);
		if(count($relev) > 0){
			$this->view->trouve    = 1;
			}




  if (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
	  
$dir = "pdf_releve/";
$findme = "RELEVE_GCP_".$code_membre;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			$nomfile = basename($file).PHP_EOL;
			if(stripos($nomfile, $findme) !== false){
			$releve = $dir.$file;

        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setReleve_id($compteur);
            $a->setReleve_type("GCP");
            $a->setReleve_membre($code_membre);
            $a->setReleve_fichier($releve);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
	$sessionmcnp->errorlogin = "Validation bien effectuée";
			$this->view->code_membre    = "";
	$_POST['code_membre'] = "";
	$this->view->message = "";
			break;
			}else{
	$this->view->message = "Veuillez d'abord faire la demande de relevé";
				}
        }
        closedir($dh);
    }
}
			
  }



    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }











    public function relevevalidationkacmAction()
    {
        /* page index/relevevalidationkcm - Retrouve les kacm */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

		   $code_membre  = '';
		   $designation  = '';
		   $fs           = 0;
		   $fl           = 0;
		   $fcps         = 0;
		   
		   $fsu          = 0;
		   $flu          = 0;
		   $fcpsu        = 0;
		   
		   $fsnu         = 0;
		   $flnu         = 0;
		   $fcpsnu       = 0;
		   
		   $kacm         = 0;

  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    
				$db_fs = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fs = $db_fs->select();
				$select_fs->from($db_fs,array('SUM(CreditAmount) as somme_fs'));
				
				if($code_membre != '') {
                  $select_fs->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fs->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fs->where('Motif like ?','FS');
                $result_fs = $db_fs->fetchAll($select_fs);
		        $row_fs = $result_fs->current();
		        $fs = $row_fs['somme_fs'];
				
				$db_fl = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fl = $db_fl->select();
				$select_fl->from($db_fl,array('SUM(CreditAmount) as somme_fl'));
				
				if($code_membre != '') {
                  $select_fl->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fl->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fl->where('Motif like ?','FL');
                $result_fl = $db_fl->fetchAll($select_fl);
		        $row_fl = $result_fl->current();
		        $fl = $row_fl['somme_fl'];
				
				
				$db_cps = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cps = $db_cps->select();
				$select_cps->from($db_cps,array('SUM(CreditAmount) as somme_cps'));
				
				if($code_membre != '') {
                  $select_cps->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cps->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cps->where('Motif like ?','CPS');
                $result_cps = $db_cps->fetchAll($select_cps);
		        $row_cps = $result_cps->current();
		        $fcps = $row_cps['somme_cps'];
				
				
				$db_fsu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fsu = $db_fsu->select();
				$select_fsu->from($db_fsu,array('SUM(CreditAmount) as somme_fsu'));
				
				if($code_membre != '') {
                  $select_fsu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fsu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fsu->where('Motif like ?','FS');
				$select_fsu->where('IDDateTimeConsumed <> ?',0);
                $result_fsu = $db_fsu->fetchAll($select_fsu);
		        $row_fsu = $result_fsu->current();
		        $fsu = $row_fsu['somme_fsu'];
				
				
				$db_flu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_flu = $db_flu->select();
				$select_flu->from($db_flu,array('SUM(CreditAmount) as somme_flu'));
				
				if($code_membre != '') {
                  $select_flu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_flu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_flu->where('Motif like ?','FL');
				$select_flu->where('IDDateTimeConsumed <> ?',0);
                $result_flu = $db_flu->fetchAll($select_flu);
		        $row_flu = $result_flu->current();
		        $flu = $row_flu['somme_flu'];
				
				
				$db_cpsu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cpsu = $db_cpsu->select();
				$select_cpsu->from($db_cpsu,array('SUM(CreditAmount) as somme_cpsu'));
				
				if($code_membre != '') {
                  $select_cpsu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cpsu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cpsu->where('Motif like ?','CPS');
				$select_cpsu->where('IDDateTimeConsumed <> ?',0);
                $result_cpsu = $db_cpsu->fetchAll($select_cpsu);
		        $row_cpsu = $result_cpsu->current();
		        $fcpsu = $row_cpsu['somme_cpsu'];
				
				
				
				$db_fsnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_fsnu = $db_fsnu->select();
				$select_fsnu->from($db_fsnu,array('SUM(CreditAmount) as somme_fsnu'));
				
				if($code_membre != '') {
                  $select_fsnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_fsnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_fsnu->where('Motif like ?','FS');
				$select_fsnu->where('IDDateTimeConsumed = ?',0);
                $result_fsnu = $db_fsnu->fetchAll($select_fsnu);
		        $row_fsnu = $result_fsnu->current();
		        $fsnu = $row_fsnu['somme_fsnu'];
				
				
				$db_flnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_flnu = $db_flnu->select();
				$select_flnu->from($db_flnu,array('SUM(CreditAmount) as somme_flnu'));
				
				if($code_membre != '') {
                  $select_flnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_flnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_flnu->where('Motif like ?','FL');
				$select_flnu->where('IDDateTimeConsumed = ?',0);
                $result_flnu = $db_flnu->fetchAll($select_flnu);
		        $row_flnu = $result_flnu->current();
		        $flnu = $row_flnu['somme_flnu'];
				
				
				$db_cpsnu = new Application_Model_DbTable_EuAncienSmsmoney();
				$select_cpsnu = $db_cpsnu->select();
				$select_cpsnu->from($db_cpsnu,array('SUM(CreditAmount) as somme_cpsnu'));
				
				if($code_membre != '') {
                  $select_cpsnu->where('FromAccount like ?','NN-TR-'.$code_membre);
				} else {
                  $select_cpsnu->where('FromAccount like ?','NN-TR-'.'%');
                }				
				$select_cpsnu->where('Motif like ?','CPS');
				$select_cpsnu->where('IDDateTimeConsumed = ?',0);
                $result_cpsnu = $db_cpsnu->fetchAll($select_cpsnu);
		        $row_cpsnu = $result_cpsnu->current();
		        $fcpsnu = $row_cpsnu['somme_cpsnu'];


			$this->view->code_membre  = $code_membre;
			$this->view->designation  = $designation;
		    $this->view->fs           = $fs;
			$this->view->fl           = $fl;
			$this->view->fcps         = $fcps;
			
			$this->view->fsu           = $fsu;
			$this->view->flu           = $flu;
			$this->view->fcpsu         = $fcpsu;
			
			$this->view->fsnu           = $fsnu;
			$this->view->flnu           = $flnu;
			$this->view->fcpsnu         = $fcpsnu;
	
////////////////////////////////////////////////////////////////////////////////




        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
		$relev = $ma->fetchAllByTypeMembre("FS_FL_FCPS", $code_membre);
		if(count($relev) > 0){
			$this->view->trouve    = 1;
			}




  if (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
	  
$dir = "pdf_releve/";
$findme = "RELEVE_FS_FL_FCPS_".$code_membre;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			$nomfile = basename($file).PHP_EOL;
			if(stripos($nomfile, $findme) !== false){
			$releve = $dir.$file;

        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setReleve_id($compteur);
            $a->setReleve_type("FS_FL_FCPS");
            $a->setReleve_membre($code_membre);
            $a->setReleve_fichier($releve);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
	$sessionmcnp->errorlogin = "Validation bien effectuée";
			$this->view->code_membre    = "";
	$_POST['code_membre'] = "";
	$this->view->message = "";
			break;
			}else{
	$this->view->message = "Veuillez d'abord faire la demande de relevé";
				}
        }
        closedir($dh);
    }
}
			
  }



    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }








    public function relevevalidationmf11000ppAction()
    {
        /* page index/relevevalidationmf11000 - Retrouve mf11000 */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

			$num_bon          = '';
			$nom              = '';
            $code_membre      = '';
	        $designation      = '';
		    $mf11000_recu     = 0;
		    $mf11000_vendu    = 0;
		    $mf11000_restant  = 0;
		   
		    $entrees     = 0;
		    $sorties     = 0;
		    $solde       = 0;
		   
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['num_bon']) && $_POST['num_bon']!="") {
    
				$num_bon = $_POST['num_bon'];
				$nom = "";

				    $db_entrees = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_entrees = $db_entrees->select();
			        $select_entrees->from($db_entrees,array('SUM(mont_rep) as somme_entrees'));
			        $select_entrees->where('code_mf11000 like ?',$num_bon);
			        $result_entrees     = $db_entrees->fetchAll($select_entrees);
		            $row_entrees        = $result_entrees->current();
		            $entrees  = $row_entrees['somme_entrees'];
					
					$db_sorties = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_sorties = $db_sorties->select();
			        $select_sorties->from($db_sorties,array('SUM(mont_reglt) as somme_sorties'));
			        $select_sorties->where('code_mf11000 like ?',$num_bon);
			        $result_sorties     = $db_sorties->fetchAll($select_sorties);
		            $row_sorties        = $result_sorties->current();
		            $sorties  = $row_sorties['somme_sorties'];
					
					
					$db_solde = new Application_Model_DbTable_EuRepartitionMf11000();
			        $select_solde = $db_solde->select();
			        $select_solde->from($db_solde,array('SUM(solde_rep) as solde'));
			        $select_solde->where('code_mf11000 like ?',$num_bon);
			        $result_solde     = $db_solde->fetchAll($select_solde);
		            $row_solde        = $result_solde->current();
		            $solde  = $row_solde['solde'];
				
				


			$this->view->code_membre     = $code_membre;
			$this->view->designation     = $designation;
			$this->view->num_bon         = $num_bon;
			$this->view->nom             = $nom;
		    $this->view->mf11000_recu    = $mf11000_recu;
			$this->view->mf11000_vendu   = $mf11000_vendu;
			$this->view->mf11000_restant = $mf11000_restant;
			
			$this->view->entrees    = $entrees;
			$this->view->sorties    = $sorties;
			$this->view->solde      = $solde;
	
////////////////////////////////////////////////////////////////////////////////



        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
		$relev = $ma->fetchAllByTypeMembre("MF11000_PP", $code_membre);
		if(count($relev) > 0){
			$this->view->trouve    = 1;
			}




  if (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
	  
$dir = "pdf_releve/";
$findme = "RELEVE_MF11000_PP_".$code_membre;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			$nomfile = basename($file).PHP_EOL;
			if(stripos($nomfile, $findme) !== false){
			$releve = $dir.$file;

        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setReleve_id($compteur);
            $a->setReleve_type("MF11000_PP");
            $a->setReleve_membre($code_membre);
            $a->setReleve_fichier($releve);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
	$sessionmcnp->errorlogin = "Validation bien effectuée";
			$this->view->code_membre    = "";
	$_POST['code_membre'] = "";
	$this->view->message = "";
			break;
			}else{
	$this->view->message = "Veuillez d'abord faire la demande de relevé";
				}
        }
        closedir($dh);
    }
}
			
  }



    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }














    public function relevevalidationmf11000pmAction()
    {
        /* page index/relevevalidationmf11000 - Retrouve mf11000 */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

			$num_bon          = '';
			$nom              = '';
            $code_membre      = '';
	        $designation      = '';
		    $mf11000_recu     = 0;
		    $mf11000_vendu    = 0;
		    $mf11000_restant  = 0;
		   
		    $entrees     = 0;
		    $sorties     = 0;
		    $solde       = 0;
		   
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    

			    $db_dsms = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsms = $db_dsms->select();
			    $select_dsms->from($db_dsms,array('SUM(mont_sms) as somme_mf'));
			    $select_dsms->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsms->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsms->where('code_membre_dist like ?','%');
                }
			    $result_dsms = $db_dsms->fetchAll($select_dsms);
		        $row_dsms = $result_dsms->current();
		        $mf11000_recu = $row_dsms['somme_mf'];
			   
			   
			    $db_dsmsv = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsmsv = $db_dsmsv->select();
			    $select_dsmsv->from($db_dsmsv,array('SUM(mont_vendu) as somme_vendu'));
			    $select_dsmsv->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsmsv->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsmsv->where('code_membre_dist like ?','%');
                }
			    $result_dsmsv = $db_dsmsv->fetchAll($select_dsmsv);
		        $row_dsmsv = $result_dsmsv->current();
		        $mf11000_vendu = $row_dsmsv['somme_vendu'];
			   
			    $db_dsmss = new Application_Model_DbTable_EuAncienDetailSmsmoney();
			    $select_dsmss = $db_dsmss->select();
			    $select_dsmss->from($db_dsmss,array('SUM(solde_sms) as somme_sms'));
			    $select_dsmss->where('origine_sms like ?','MF');
			    if($code_membre != '') {
                  $select_dsmss->where('code_membre_dist like ?',$code_membre);
				} else {
                  $select_dsmss->where('code_membre_dist like ?','%');
                }
			    $result_dsmss     = $db_dsmss->fetchAll($select_dsmss);
		        $row_dsmss        = $result_dsmss->current();
		        $mf11000_restant  = $row_dsmss['somme_sms'];
				
				


			$this->view->code_membre     = $code_membre;
			$this->view->designation     = $designation;
			$this->view->num_bon         = $num_bon;
			$this->view->nom             = $nom;
		    $this->view->mf11000_recu    = $mf11000_recu;
			$this->view->mf11000_vendu   = $mf11000_vendu;
			$this->view->mf11000_restant = $mf11000_restant;
			
			$this->view->entrees    = $entrees;
			$this->view->sorties    = $sorties;
			$this->view->solde      = $solde;
	
////////////////////////////////////////////////////////////////////////////////



        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
		$relev = $ma->fetchAllByTypeMembre("MF11000_PM", $code_membre);
		if(count($relev) > 0){
			$this->view->trouve    = 1;
			}




  if (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
	  
$dir = "pdf_releve/";
$findme = "RELEVE_MF11000_PM_".$code_membre;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			$nomfile = basename($file).PHP_EOL;
			if(stripos($nomfile, $findme) !== false){
			$releve = $dir.$file;

        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setReleve_id($compteur);
            $a->setReleve_type("MF11000_PM");
            $a->setReleve_membre($code_membre);
            $a->setReleve_fichier($releve);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
	$sessionmcnp->errorlogin = "Validation bien effectuée";
			$this->view->code_membre    = "";
	$_POST['code_membre'] = "";
	$this->view->message = "";
			break;
			}else{
	$this->view->message = "Veuillez d'abord faire la demande de relevé";
				}
        }
        closedir($dh);
    }
}
			
  }



    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }













    public function relevevalidationmf107Action()
    {
        /* page index/relevevalidationmf107 - Retrouve mf107 */

  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublic');
    

		    $code_membre  = '';
		    $designation  = '';
		    $soldemf107   = 0;
		   
  if (isset($_POST['ok']) && $_POST['ok']=="ok") {
  if (isset($_POST['code_membre']) && $_POST['code_membre']!="") {
	            $code_membre = $_POST['code_membre'];
				$designation = "";
    

			        $anciencompte_nn   = new Application_Model_EuAncienCompte();
		            $anciencm_map      = new Application_Model_EuAncienCompteMapper();
					$date_fin = new Zend_Date(Zend_Date::ISO_8601);
                    $date_deb = clone $date_fin;
			        $rep = new Application_Model_EuRepartitionMf107();
			        $m_rep = new Application_Model_EuRepartitionMf107Mapper();
			        $dmf = new Application_Model_EuDetailMf107();
			        $mdmf = new Application_Model_EuDetailMf107Mapper();
			        $mf107 = new Application_Model_EuMembreFondateur107();
			        $mmf107 = new Application_Model_EuMembreFondateur107Mapper();
			        $montant = 0;
			        $nb_dmf = 0;
			        $code_compteancien = 'NN-TR-'.$code_membre;
					$soldemf107 = $m_rep->findSum($code_membre);	
				
				
			$this->view->code_membre  = $code_membre;
			$this->view->designation  = $designation;
            $this->view->soldemf107  = $soldemf107;			
	
////////////////////////////////////////////////////////////////////////////////



        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
		$relev = $ma->fetchAllByTypeMembre("MF107", $code_membre);
		if(count($relev) > 0){
			$this->view->trouve    = 1;
			}




  if (isset($_POST['ok1']) && $_POST['ok1']=="ok1") {
	  
$dir = "pdf_releve/";
$findme = "RELEVE_MF107_".$code_membre;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			$nomfile = basename($file).PHP_EOL;
			if(stripos($nomfile, $findme) !== false){
			$releve = $dir.$file;

        $a = new Application_Model_EuReleve();
        $ma = new Application_Model_EuReleveMapper();
			
            $compteur = $ma->findConuter() + 1;
            $a->setReleve_id($compteur);
            $a->setReleve_type("MF107");
            $a->setReleve_membre($code_membre);
            $a->setReleve_fichier($releve);
            $a->setPublier($_POST['publier']);
            $ma->save($a);
	$sessionmcnp->errorlogin = "Validation bien effectuée";
			$this->view->code_membre    = "";
	$_POST['code_membre'] = "";
	$this->view->message = "";
			break;
			}else{
	$this->view->message = "Veuillez d'abord faire la demande de relevé";
				}
        }
        closedir($dh);
    }
}
			
  }



    } else {  
	$this->view->message = "Champs * obligatoire ...";}
       
  } 
        $this->view->tabletri = 1;
  }































	

}



