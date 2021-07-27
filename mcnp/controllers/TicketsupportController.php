<?php

class TicketSupportController extends Zend_Controller_Action{

  public function gestiondespassifsAction () {

    $db = Zend_Db_Table::getDefaultAdapter();

    $tabscas = [];

    $sustabscas = [];

    $created = Zend_Date::now();

    $request = $this->getRequest();

    $paramsfirms = (string)$this->_request->getParam('firm');

    $dbselecttouslescasdespassifs = "SELECT * 
    
                                     FROM eu_cas_passif
                                     
                                      WHERE eu_cas_passif.entreprise = '$paramsfirms'";

    $db->setFetchMode(Zend_Db::FETCH_OBJ);

    $stmtselecttouslescasdespassifs = $db->query($dbselecttouslescasdespassifs);
 
    $selecttouslescasdespassifs = $stmtselecttouslescasdespassifs->fetchAll();

    foreach ($selecttouslescasdespassifs as $key => $value) {

        $id_caspassif = $value->id;

        $libellecaspassif = $value->libelle_cas;
      
        $dbselecttouslesdetailsdecasdespassifs = "SELECT eu_detail_cas_passif.libelle_detail
    
                                                  FROM eu_detail_cas_passif
                                     
                                                  WHERE eu_detail_cas_passif.id_cas_passif = '$id_caspassif'";

        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $stmtselecttouslesdetailsdecasdespassifs = $db->query($dbselecttouslesdetailsdecasdespassifs);
 
        $selecttouslesdetailsdecasdespassifs = $stmtselecttouslesdetailsdecasdespassifs->fetchAll();

        $tabscas[] = array(

              'id_caspassif'=>$id_caspassif,

              'libellecaspassif'=>$libellecaspassif,

              'detaildescas'=>$selecttouslesdetailsdecasdespassifs
        );

    }

    $this->view->paramsfirms = $paramsfirms;

    $this->view->selecttouslescasdespassifs = $tabscas;


    if($request->isPost()){

      
    }


  }

  public function espacepriveepassifAction ()  
  {
    
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

  }

  public function ticketnonvalidAction(){
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $dbvt = new Application_Model_DbTable_EuValidationTicket();
      $vt = new Application_Model_EuValidationTicket();
      $dbct = new Application_Model_DbTable_EuComiteticket();
      $ct = new Application_Model_EuComiteTicket();
      $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
      $asts = new Application_Model_EuAssociationTicketComite();


      $dbasctselect = $dbastc->select();
      $dbasctselect->from('eu_association_ticket_comite')
                   ->where('statut = "non traité"');
      $dbasctselect_all = $dbastc->fetchAll($dbasctselect);
      var_dump($dbasctselect_all);
  }
  public function conventionAction(){

    $this->_helper->layout()->setLayout('layoutpublicesmc');


	  $sessionmcnp = new Zend_Session_Namespace('mcnp');
    $dbcv = new Application_Model_DbTable_EuConvention();
    $cv = new Application_Model_EuConvention();
    $mpcv = new Application_Model_EuConventionMapper();
    $request = $this->getRequest();
    $validationerrors = array();
    $validationemailerrors = array();
    $validationperteerrors = array();
    $validationpertesuccess = array();
    $convention_array = array();
    $created = Zend_Date::now();

    if($request->isPost()){
      if(!array_key_exists('renseignement_check_name', $_POST)){
        $validationerrors['error_demandeur'] = "Erreur 404: de ce ticket n'existe pas";
      }
      if($_POST['renseignement_check_name'] == "Personne_physique"){
         if(!array_key_exists('civilite_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom et Prenoms du demandeur de ce ticket n'existe pas";
         }
         if(empty($_POST['civilite_name'])){
            $validationerrors['empty_civilite_name'] = "Vos Nom et Prenoms ne doivent pas être vide";
         }

         if(!array_key_exists('civilite_type_demeure', $_POST)){
            $validationerrors['error_civilite_type_demeure'] = "Erreur 404:Le Type demeur n'existe pas";
         }
         if(empty($_POST['civilite_type_demeure']) || $_POST['civilite_type_demeure'] == ""){
            $validationerrors['empty_civilite_type_demeure'] = "Le lieu ne doivent pas être vide";
         }

        if(!array_key_exists('civilite_quartier', $_POST)){
            $validationerrors['error_civilite_quartier'] = "Erreur 404:le quartier n'existe pas";
         }
         if(empty($_POST['civilite_quartier'])){
            $validationerrors['empty_civilite_quartier'] = "Le quartier n'est pas rempli";
         }

        if(!array_key_exists('civilite_bp', $_POST)){
            $validationerrors['error_civilite_bp'] = "Erreur 404:La boîte postale n'est pas précisé";
        }

        if(!array_key_exists('civilite_phone', $_POST)){
            $validationerrors['error_civilite_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['civilite_phone'])){
            $validationerrors['empty_civilite_phone'] = "Le numero de telephone n'est pas rempli";
        }
        if($_POST['civilite_phone'] !== ""){
          if(filter_var($_POST['civilite_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_civilite_phone'] = "Le Numero de telephone doit être numérique";
           }
        }

         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["civilite_name"],
           "demeure"=>$_POST["civilite_type_demeure"],
           "libelle_demeure"=>$_POST["civilite_domicile"],
           "quartier"=>$_POST["civilite_quartier"],
           "boite_postale"=>$_POST["civilite_bp"],
           "telephone"=>$_POST["civilite_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }
       
       /**,
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           "fournisseur_specifique"=>$_POST["fournisseur_specifique"],
           "fournisseur_utilisateur"=>$_POST["fournisseur_utilisateur"],
           "fournisseur_externe"=>$_POST["fournisseur_externe"],
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]**/

       if($_POST['renseignement_check_name'] == "Etablissement"){
         if(!array_key_exists('etablissement_name', $_POST)){
            $validationerrors['error_demandeur'] = "Erreur 404:Le Nom de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_name'])){
            $validationerrors['empty_etablissement_name'] = "Le nom de l'établissement pas être vide";
         }

         if(!array_key_exists('etablissement_residence', $_POST)){
            $validationerrors['error_etablissement_residence'] = "Erreur 404:Le Lieu de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_residence'])){
            $validationerrors['empty_etablissement_residence'] = "Le Lieu de l'établissement ne doit pas être vide";
         }

        if(!array_key_exists('etablissement_quartier', $_POST)){
            $validationerrors['error_etablissement_quartier'] = "Erreur 404:le quartier de l'établissement n'existe pas";
         }
         if(empty($_POST['etablissement_quartier'])){
            $validationerrors['empty_etablissement_quartier'] = "Le quartier de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant l'établissemnt est invalide";
        }

        if(empty($_POST['etablissement_representant_bp'])){
            $validationerrors['empty_etablissement_representant_bp'] = "La boîte postale du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_phone', $_POST)){
            $validationerrors['error_etablissement_representant_phone'] = "Erreur 404:Le champs numero de telephone n'est pas précisé";
        }
        if(empty($_POST['etablissement_representant_phone'])){
            $validationerrors['empty_etablissement_representant_phone'] = "Le numero de telephone n'est pas rempli";
        }
        if($_POST['etablissement_representant_phone'] !== ""){
          if(filter_var($_POST['etablissement_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_etablissement_representant_phone'] = "Le Numero de telephone doit être numérique";
           }
        }

        if(!array_key_exists('etablissement_rue', $_POST)){
            $validationerrors['error_etablissement_rue'] = "Erreur 404:La Rue de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_rue'])){
            $validationerrors['empty_etablissement_rue'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_name', $_POST)){
            $validationerrors['error_etablissement_representant_name'] = "Erreur 404:Le Nom du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_name'])){
            $validationerrors['empty_etablissement_representant_name'] = "Le Nom du représentant de l'établissement n'est pas rempli";
         }

        if(!array_key_exists('etablissement_representant_operateur', $_POST)){
            $validationerrors['error_etablissement_representant_operateur'] = "Erreur 404:Le Numero d'opérateur du représentant de l'établissemnt est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['etablissement_representant_operateur'])){
            $validationerrors['empty_etablissement_representant_operateur'] = "Le Numero d'opérateur du représentant de l'établissement n'est pas rempli";
         }

        $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["etablissement_name"],
           "libelle_situation"=>$_POST["etablissement_residence"],
           "quartier"=>$_POST["etablissement_quartier"],
           "boite_postale"=>$_POST["etablissement_representant_bp"],
           "telephone"=>$_POST["etablissement_representant_phone"],
           "rue"=>$_POST["etablissement_rue"],
           "civilite_representant"=>$_POST["etablissement_representant"],
           "nom_representant"=>$_POST["etablissement_representant_name"],
           "carte_operateur"=>$_POST["etablissement_representant_operateur"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['renseignement_check_name'] == "Maison_Villa_Immeuble"){
         if(!array_key_exists('residence_name', $_POST)){
            $validationerrors['error_residence_name'] = "Erreur 404:Le Nom de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_name'])){
            $validationerrors['empty_residence_name'] = "Le nom de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_situation', $_POST)){
            $validationerrors['error_residence_situation'] = "Erreur 404:Le lieu de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_situation'])){
            $validationerrors['empty_residence_situation'] = "Le lieu de la maison/Villa/Immeuble ne doit pas être vide";
         }

         if(!array_key_exists('residence_representant_demeure', $_POST)){
            $validationerrors['error_residence_representant_demeure'] = "Erreur 404:Le Lieu de residence du représentant de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_representant_demeure'])){
            $validationerrors['empty_residence_representant_demeure'] = "Le Lieu de residence du représentant de la maison/Villa/Immeuble ne doit pas être vide";
         }

        if(!array_key_exists('residence_quartier', $_POST)){
            $validationerrors['error_residence_quartier'] = "Erreur 404:le quartier de la maison/Villa/Immeuble n'existe pas";
         }
         if(empty($_POST['residence_quartier'])){
            $validationerrors['empty_residence_quartier'] = "Le quartier de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_bp', $_POST)){
            $validationerrors['error_etablissement_representant_bp'] = "Erreur 404:La boîte postale du représentant la résidence est invalide";
        }

        if(empty($_POST['residence_representant_bp'])){
            $validationerrors['empty_residence_representant_bp'] = "La boîte postale du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant_phone', $_POST)){
            $validationerrors['error_residence_representant_phone'] = "Erreur 404:Le champs numero de la maison/Villa/Immeuble n'est pas précisé";
        }
        if(empty($_POST['residence_representant_phone'])){
            $validationerrors['empty_residence_representant_phone'] = "Le numero de telephone du represésentant de la maison/Villa/Immeuble n'est pas rempli";
        }
        if($_POST['residence_representant_phone'] !== ""){
          if(filter_var($_POST['residence_representant_phone'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_residence_representant_phone'] = "Le Numero de telephone du represésentant de la maison/Villa/Immeuble doit être numérique";
           }
        }

        if(!array_key_exists('residence_rue', $_POST)){
            $validationerrors['error_residence_rue'] = "Erreur 404:La Rue de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_rue'])){
            $validationerrors['empty_residence_rue'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }

        if(!array_key_exists('residence_representant', $_POST)){
            $validationerrors['error_residence_representant'] = "Erreur 404:Le Nom du représentant de la maison/Villa/Immeuble est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['residence_representant'])){
            $validationerrors['empty_residence_representant'] = "Le Nom du représentant de la maison/Villa/Immeuble n'est pas rempli";
         }


         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "type_maison"=>$_POST["residence_name"],
           "demeure"=>$_POST["residence_representant_demeure"],
           "libelle_situation"=>$_POST["residence_situation"],
           "quartier"=>$_POST["residence_quartier"],
           "boite_postale"=>$_POST["residence_representant_bp"],
           "telephone"=>$_POST["residence_representant_phone"],
           "rue"=>$_POST["residence_rue"],
           "nom_representant"=>$_POST["residence_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }


       if($_POST['renseignement_check_name'] == "Collectivité"){
        if(!array_key_exists('collectivite_name', $_POST)){
            $validationerrors['error_collectivite_name'] = "Erreur 404:Le Nom de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_name'])){
            $validationerrors['empty_collectivite_name'] = "Le nom de la collectivité ne doit pas être vide";
         }

         if(!array_key_exists('collectivite_domicile', $_POST)){
            $validationerrors['error_collectivite_domicile'] = "Erreur 404:Le Lieu de residence du représentant de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_domicile'])){
            $validationerrors['empty_collectivite_domicile'] = "Le Lieu de residence du représentant de la collectivité ne doit pas être vide";
         }

        if(!array_key_exists('collectivite_quartier', $_POST)){
            $validationerrors['error_collectivite_quartier'] = "Erreur 404:le quartier de la collectivité n'existe pas";
         }
         if(empty($_POST['collectivite_quartier'])){
            $validationerrors['empty_collectivite_quartier'] = "Le quartier de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_bp', $_POST)){
            $validationerrors['error_collectivite_bp'] = "Erreur 404:La boîte postale du représentant de la collectivité est invalide";
        }

        if(empty($_POST['collectivite_bp'])){
            $validationerrors['empty_collectivite_bp'] = "La boîte postale du représentant de la collectivité n'est pas rempli";
         }

        if(!array_key_exists('collectivite_tel', $_POST)){
            $validationerrors['error_collectivite_tel'] = "Erreur 404:Le champs numero de telephone du representant de la collectivité n'est pas précisé";
        }
        if(empty($_POST['residence_collectivite_tel'])){
            $validationerrors['empty_collectivite_tel'] = "Le numero de telephone du represésentant de la collectivité n'est pas rempli";
        }
        if($_POST['collectivite_tel'] !== ""){
          if(filter_var($_POST['collectivite_tel'], FILTER_VALIDATE_REGEXP,
             array("options"=>array("regexp"=>"#[^0-9]#")))){
             $validationerrors['verif_collectivite_tel'] = "Le Numero de telephone du represésentant de la collectivité doit être numérique";
           }
        }

        if(!array_key_exists('collectivite_representant', $_POST)){
            $validationerrors['error_collectivite_representant'] = "Erreur 404:Le Nom du représentant de la collectivité est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['collectivite_representant'])){
            $validationerrors['empty_collectivite_representant'] = "Le Nom du représentant de la collectivité n'est pas rempli";
         }
          $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["collectivite_name"],
           "demeure"=>$_POST["collectivite_domicile"],
           "quartier"=>$_POST["collectivite_quartier"],
           "boite_postale"=>$_POST["collectivite_bp"],
           "telephone"=>$_POST["collectivite_tel"],
           "nom_representant"=>$_POST["collectivite_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['renseignement_check_name'] == "Association"){
        if(!array_key_exists('association_name', $_POST)){
            $validationerrors['error_association_name'] = "Erreur 404:Le Nom de l'Association est invalide:Impossible de faire une quelconque sauvegarde";
        }

        if(empty($_POST['association_name'])){
            $validationerrors['empty_association_name'] = "Le Nom de l'Association n'est pas rempli";
         }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["association_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

        if($_POST['renseignement_check_name'] == "Groupement"){
          if(!array_key_exists('groupement_name', $_POST)){
            $validationerrors['error_groupement_name'] = "Erreur 404:Le Nom du groupement est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['groupement_name'])){
            $validationerrors['empty_groupement_name'] = "Le Nom du groupement n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["groupement_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['renseignement_check_name'] == "Coopérative"){
          if(!array_key_exists('cooperative_name', $_POST)){
            $validationerrors['error_cooperative_name'] = "Erreur 404:Le Nom de la coopérative est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['cooperative_name'])){
            $validationerrors['empty_cooperative_name'] = "Le Nom de la coopérative n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["cooperative_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['renseignement_check_name'] == "Union"){
          if(!array_key_exists('union_name', $_POST)){
            $validationerrors['error_union_name'] = "Erreur 404:Le Nom de l'Union est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['union_name'])){
            $validationerrors['empty_union_name'] = "Le Nom de l'Union n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["union_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
         
       }

       
      if($_POST['renseignement_check_name'] == "ONG"){
          if(!array_key_exists('ong_name', $_POST)){
            $validationerrors['error_ong_name'] = "Erreur 404:Le Nom de l'ONG est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['ong_name'])){
            $validationerrors['empty_ong_name'] = "Le Nom de l'ONG n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["ong_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }
       
       
      if($_POST['renseignement_check_name'] == "Confédération"){
          if(!array_key_exists('confédération_name', $_POST)){
            $validationerrors['error_confédération_name'] = "Erreur 404:Le Nom de la confédération est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confédération_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom de la confédération n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["confédération_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }
      
      if($_POST['renseignement_check_name'] == "Réseau"){
          if(!array_key_exists('reseau_name', $_POST)){
            $validationerrors['error_reseau_name'] = "Erreur 404:Le Nom du réseau est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['reseau_name'])){
            $validationerrors['empty_confédération_name'] = "Le Nom du réseau n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["reseau_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['renseignement_check_name'] == "Faitière"){
          if(!array_key_exists('faitiere_name', $_POST)){
            $validationerrors['error_faitiere_name'] = "Erreur 404:Le Nom du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_name'])){
            $validationerrors['empty_faitiere_name'] = "Le Nom du faitière n'est pas rempli";
          }

          if(!array_key_exists('numero_recipice', $_POST)){
            $validationerrors['error_numero_recipice'] = "Erreur 404:Le Numéro de recipice du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['numero_recipice'])){
            $validationerrors['empty_numero_recipice'] = "Le Numéro de recipice du faitière n'est pas rempli";
          }

          if(!array_key_exists('faitiere_representant', $_POST)){
            $validationerrors['error_faitiere_representant'] = "Erreur 404:Le Représentant du faitière est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['faitiere_representant'])){
            $validationerrors['empty_faitiere_representant'] = "Le Représentant du faitière n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["faitiere_name"],
           "numero_recipice"=>$_POST["faitiere_numero"],
           "nom_representant"=>$_POST["faitiere_representant"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['renseignement_check_name'] == "Confession_réligieuse"){
          if(!array_key_exists('confession_religieuse_name', $_POST)){
            $validationerrors['error_confession_religieuse_name'] = "Erreur 404:Le Nom de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Nom de la confession réligieuse n'est pas rempli";
          }
          if(!array_key_exists('confession_religieuse_quartier_name', $_POST)){
            $validationerrors['error_confession_religieuse_quartier_name'] = "Erreur 404:Le Nom du quartier de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_quartier_name'])){
            $validationerrors['empty_confession_religieuse_quartier_name'] = "Le Nom du quartier de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_representant', $_POST)){
            $validationerrors['error_confession_religieuse_representant'] = "Erreur 404:Le Représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_representant'])){
            $validationerrors['empty_confession_religieuse_representant'] = "Le Représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_demeure', $_POST)){
            $validationerrors['error_confession_religieuse_demeure'] = "Erreur 404:Le domicile du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_demeure'])){
            $validationerrors['empty_confession_religieuse_demeure'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_bp', $_POST)){
            $validationerrors['error_confession_religieuse_bp'] = "Erreur 404:La boîte postale du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_bp'])){
            $validationerrors['empty_confession_religieuse_bp'] = "Le domicile du représentant de la confession réligieuse n'est pas rempli";
          }

          if(!array_key_exists('confession_religieuse_phone', $_POST)){
            $validationerrors['error_confession_religieuse_phone'] = "Erreur 404:Le numéro de telephone du représentant de la confession réligieuse est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['confession_religieuse_phone'])){
            $validationerrors['empty_confession_religieuse_phone'] = "Le numéro de telephone du représentant de la confession réligieuse n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["confession_religieuse_name"],
           "quartier"=>$_POST["confession_religieuse_quartier_name"],
           "demeure"=>$_POST["confession_religieuse_demeure"],
           "nom_representant"=>$_POST["confession_religieuse_representant"],
           "boite_postale"=>$_POST["confession_religieuse_bp"],
           "telephone"=>$_POST["confession_religieuse_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['renseignement_check_name'] == "EPA"){
          if(!array_key_exists('etablissement_administratif_name', $_POST)){
            $validationerrors['error_etablissement_administratif_name'] = "Erreur 404:Le Nom de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_name'])){
            $validationerrors['empty_etablissement_administratif_name'] = "Le Nom de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_bp', $_POST)){
            $validationerrors['error_etablissement_administratif_bp'] = "Erreur 404:La boîte postale l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_bp'])){
            $validationerrors['empty_etablissement_administratif_bp'] = "Le boîte postale de l'établissement public administratif n'est pas rempli";
          }

          if(!array_key_exists('etablissement_administratif_telephone', $_POST)){
            $validationerrors['error_etablissement_administratif_telephone'] = "Erreur 404:Le numéro de telephone de l'établissement public administratif est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_administratif_telephone'])){
            $validationerrors['empty_etablissement_administratif_telephone'] = "Le numéro de telephone de l'établissement public administratif n'est pas rempli";
          }

         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["etablissement_administratif_name"],
           "boite_postale"=>$_POST["etablissement_administratif_bp"],
           "telephone"=>$_POST["etablissement_administratif_telephone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

       if($_POST['renseignement_check_name'] == "EPIC"){
          if(!array_key_exists('etablissement_industriel_commercial_name', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_name'] = "Erreur 404:Le Nom de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_name'])){
            $validationerrors['empty_etablissement_industriel_commercial_name'] = "Le Nom de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_bp', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_bp'] = "Erreur 404:La boîte postale  de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_bp'])){
            $validationerrors['empty_etablissement_industriel_commercial_bp'] = "Le boîte postale du représentant de l'établissement industriel commercial n'est pas rempli";
          }

          if(!array_key_exists('etablissement_industriel_commercial_phone', $_POST)){
            $validationerrors['error_etablissement_industriel_commercial_phone'] = "Erreur 404:Le numéro de telephone de l'établissement industriel commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['etablissement_industriel_commercial_phone'])){
            $validationerrors['empty_etablissement_industriel_commercial_phone'] = "Le numéro de telephone de l'établissement industriel commercial n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["etablissement_industriel_commercial_name"],
           "boite_postale"=>$_POST["etablissement_industriel_commercial_bp"],
           "telephone"=>$_POST["etablissement_industriel_commercial_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['renseignement_check_name'] == "Organisation_Internationale"){
          if(!array_key_exists('organisation_internationale_name', $_POST)){
            $validationerrors['error_organisation_internationale_name'] = "Erreur 404:Le Nom de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_name'])){
            $validationerrors['empty_organisation_internationale_name'] = "Le Nom de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_bp', $_POST)){
            $validationerrors['error_organisation_internationale_bp'] = "Erreur 404:La boîte postale  de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_bp'])){
            $validationerrors['empty_organisation_internationale_bp'] = "Le boîte postale de l'organisation internationale n'est pas rempli";
          }

          if(!array_key_exists('organisation_internationale_phone', $_POST)){
            $validationerrors['error_organisation_internationale_phone'] = "Erreur 404:Le numéro de téléphone de l'organisation internationale est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['organisation_internationale_phone'])){
            $validationerrors['empty_organisation_internationale_phone'] = "Le numéro de téléphone de l'organisation internationale n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["organisation_internationale_name"],
           "boite_postale"=>$_POST["organisation_internationale_bp"],
           "telephone"=>$_POST["organisation_internationale_phone"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }

      if($_POST['renseignement_check_name'] == "Société"){
          if(!array_key_exists('societe_name', $_POST)){
            $validationerrors['error_societe_name'] = "Erreur 404:Le Nom de l'organisation internationale commercial est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_name'])){
            $validationerrors['empty_societe_name'] = "Le Nom de l'organisation internationale commercial n'est pas rempli";
          }

          if(!array_key_exists('societe_imatriculation_numero', $_POST)){
            $validationerrors['error_societe_imatriculation_numero'] = "Erreur 404:Le numéro d'imatriculation de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_imatriculation_numero'])){
            $validationerrors['empty_societe_imatriculation_numero'] = "Le numéro d'imatriculation de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_siege', $_POST)){
            $validationerrors['error_societe_siege'] = "Erreur 404:Le siege de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_siege'])){
            $validationerrors['empty_societe_siege'] = "Le siege de la société n'est pas rempli";
          }

          if(!array_key_exists('societe_representant_name', $_POST)){
            $validationerrors['error_societe_representant_name'] = "Erreur 404:Le nom du représentant de la société est invalide:Impossible de faire une quelconque sauvegarde";
          }
          if(empty($_POST['societe_representant_name'])){
            $validationerrors['empty_societe_representant_name'] = "Le nom du représentant de la société n'est pas rempli";
          }
         $convention_array = array(
           "civilite"=>$_POST["renseignement_check_name"],
           "nom"=>$_POST["societe_name"],
           "numero_recipice"=>$_POST["societe_imatriculation_numero"],
           "siege"=>$_POST["societe_siege"],
           "nom_representant"=>$_POST["societe_representant_name"],
           "date_convention"=>$created->toString('yyyy-MM-dd HH:mm:ss'),
           "biens"=>$_POST["biens"],
           "producteur"=>$_POST["producteur"],
           'type_acteur'=>$_POST["type_acteur"],           
           "services"=>$_POST["services"],
           "transformateur"=>$_POST["transformateur"],           
           "vendeur"=>$_POST["vendeur"],
           "produits"=>$_POST["produit"]
         );
       }
       
          if(!empty($validationerrors)){
            $sessionmcnp->error .= $validationerrors;
          }
         if(!empty($convention_array) && empty($validationerrors)){
              $paramban = (int)$this->_request->getParam('paramban');
           
              $_SESSION['information_convention'] = $convention_array;
              $this->_redirect("/souscriptionbon/addsouscriptionban");
         }
    }
  }

    public function statistiqueoperationAction(){
      $db = Zend_Db_Table::getDefaultAdapter();
      
      $datefirst  = Zend_Locale_Format::getDate(
        $_POST["firstday"],
          array(
            'date_format' => 'dd.MM.yyyy',
            'fix_date'    => true,
          )
      );
      $datesecond  = Zend_Locale_Format::getDate(
        $_POST["lastday"],
          array(
            'date_format' => 'dd.MM.yyyy',
            'fix_date'    => true,
          )
      );
      $first = $datefirst['year']."-".$datefirst['month']."-".$datefirst['day'];
      $second = $datesecond['year']."-".$datesecond['month']."-".$datesecond['day'];

      $dbtselect = "SELECT * FROM  eu_ticket_support WHERE DATE(created) >= '$first' AND DATE(created) <= '$second'";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbtselect_all = $stmt->fetchAll();


      $dbtselect = "SELECT * FROM  eu_ticket_support WHERE DATE(created) >= '$first' AND DATE(created) <= '$second' AND DATE(date_validation) >= '$first' AND DATE(date_validation) <= '$second' AND valid = 6";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbtselect_spec = $stmt->fetchAll();


      $dbtselect = "SELECT * FROM  eu_ticket_support WHERE DATE(created) >= '$first' AND DATE(created) <= '$second' AND DATE(date_validation) >= '$first' AND DATE(date_validation) <= '$second' AND valid = 5";
      $db->setFetchMode(Zend_Db::FETCH_OBJ);
      $stmt = $db->query($dbtselect);
      $dbtselect_spec_traite = $stmt->fetchAll();

      $resultjson = array(
         'count_ticket_traite'=>count($dbtselect_spec),
         'count_ticket_spec_traite'=>count($dbtselect_spec_traite),
         'count_ticket'=>count($dbtselect_all),
         'count_first'=>$first,
         'count_second'=>$second
       );

      header('Content-type:application/json');
      die(json_encode($resultjson));
    }

  public function ticketonlineAction(){
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();

    $dbastselect = $dbasts->select();
    $dbastselect->from('eu_association_ticket_comite',array('membre_section_comite_ticket', 'count(membre_section_comite_ticket) as number_ticket'))
                ->where('statut = ""')
                ->group('membre_section_comite_ticket');
    $dbtastselect_all = $dbasts->fetchAll($dbastselect);
    $this->view->entries = $dbtastselect_all;

  }

  public function seealljointefileAction(){
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $id = (int)$this->_request->getParam('id');

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support')
              ->where('id_ticket like ?', $id);
    $dbtselect_all = $dbts->fetchAll($dbtselect);

    $this->view->entries = $dbtselect_all;

  }
  public function pdfticketgerantAction(){
     $id = (int)$this->_request->getParam('id');
     $this->_redirect(Util_Utils::genererPdfTicketGeranttwo($id));
  }

  public function pdfticketarchiveAction(){
    $id = (int)$this->_request->getParam('id');
    $this->_redirect(Util_Utils::genererPdfTicketGeranttwo($id));

  }

  public function pdfticketrgerantAction(){

  }

  public function statistiqueticketAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

  }



  public function historybyintervenantAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();

    $nom_traitant = $_SESSION['utilisateur']['nom_utilisateur'];

    $dbasctselect = $dbasts->select();
    $dbasctselect->from('eu_association_ticket_comite')
                 ->where("membre_section_comite_ticket like '%$nom_traitant%'")
                 ->where('statut != ""');
    $dbasctselect_all = $dbasts->fetchAll($dbasctselect);
    $this->view->entries = $dbasctselect_all;

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');

    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $this->view->ticket = $dbtselect_all;
    $this->view->tabletri = 1;    

  }
  public function edittickettraiteAction(){

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $id = (int)$this->_request->getParam('id');
    
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support')
              ->where('id_ticket like ?', $id)
              ->where('visa_one != ""');

    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $dbctselect = $dbct->select();
    $dbctselect->from('eu_comite_ticket');
    $dbctselect_all = $dbct->fetchAll($dbctselect);
    $dbasctselect = $dbasts->select();
    $dbasctselect->from('eu_association_ticket_comite')
                 ->where('id_ticket like ?',$id);
    $dbasctselect_all = $dbasts->fetchAll($dbasctselect);
    $this->view->entries = $dbtselect_all;
    $this->view->association = $dbasctselect_all;
    $this->view->comite = $dbctselect_all;

  }

  public function editticketnontraiteAction(){

  }

  public function designAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
    $dbpartenaire = new Application_Model_DbTable_EuPage();
    
     $dbone = array(
        'id_page'=>'100',
        'titre'=>'Achats-Ventes rÃ©ciproques Partenaires ODD',
        'resume'=>'',
        'description'=>'<style type="text/css"><!--
           p.MsoListParagraph {
           margin-top:0cm;
           margin-right:0cm;
           margin-bottom:10.0pt;
           margin-left:36.0pt;
           line-height:150%;
           font-size:11.0pt;
           font-family:\'Lato\', Calibri, Arial, sans-serif;}-->
</style>
<p><span style="font-family:\'Lato\', Calibri, Arial, sans-serif; ">C&#39;est l&#39;activit&eacute; par laquelle tout Partenaire OE t&ecirc;te de division de fili&egrave;res de biens, de produits et de services, faiti&egrave;res, monopoles et oligopoles disposant de Compte Marchand GAC Partenaire OE, pour assurer ses achats et ses ventes propose &agrave; la Production Commune ses marchandises avec ou sans Engagements de Livraison Irr&eacute;vocable (ELI) contre l&#39;&eacute;mission anticip&eacute;e d&#39;Ordre de Pr&eacute;l&egrave;vement Irr&eacute;vocable <span style="color:#aa325f; ">ESMC</span>. Ces OPI, au nombre de 12 minimum sont utilis&eacute;s pour tirer de l&#39;argent sur les comptes bancaires de l&#39;<span style="color:#aa325f; ">ESMC</span> aupr&egrave;s des banques &agrave; chaque &eacute;ch&eacute;ance de 30 jours, faire ses commandes, ses consommations directes ou honorer ses engagements vis-&agrave;-vis de ses cr&eacute;anciers. Cela permet de domicilier ses ventes &eacute;gales &agrave; ses achats sur la plateforme <span style="color:#aa325f; ">ESMC </span>en guise de preuve de sa solvabilit&eacute; vis-&agrave;-vis de tous.</span></p>
',
        'publier'=>'1',
        'menu'=>'18',
        'menusous'=>'78',
        'ordre'=>'4',
        'spotlight'=>'0',
        'deroulant'=>'0',
        'titre_autre'=>'Achats-Ventes rÃ©ciproques Partenaires ODD',
        'titre_deroulant'=>'Achats-Ventes rÃ©ciproques Partenaires ODD',
        'liendirect'=>''
        );
    $dbpartenaire->insert($dbone);    
  }


  public function updatephonemembreAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    
    $dbmemb = new Application_Model_DbTable_EuMembre();

    $id = (int)$this->_request->getParam('id');
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    

    if (!isset($sessionutilisateur->login)){
      $this->_redirect('/administration/login');
    }
    $request = $this->getRequest();

    
    if($request->isPost()){
      $codemembre = $_POST['code_membre_phone'];
      $phonemembre = "228".$_POST['phone_membre'];
      $dbmemb->update(array('portable_membre'=>$phonemembre), array('code_membre = ?'=>$codemembre));
      
    }

        
    
  }
  public function editticketsectiontraitementAction(){
    //$this->_helper->layout->disableLayout();

    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbut = new Application_Model_DbTable_EuUtilisateur();
    $dbutm = new Application_Model_EuUtilisateurMapper();
    $dbmemb = new Application_Model_DbTable_EuMembre();
    $dbmembasso = new Application_Model_DbTable_EuMembreasso();
    $dbreleve= new Application_Model_DbTable_EuRelevebancairedetail();
    $dbmembmorale = new Application_Model_DbTable_EuMembreMorale();
    
    
    
    $id = (int)$this->_request->getParam('id');
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    

    if (!isset($sessionutilisateur->login)){
      $this->_redirect('/administration/login');
    }

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support')
              ->where('id_ticket like ?', $id)
              ->where('visa_one != ""');
    $dbtselect_all = $dbts->fetchAll($dbtselect);

    $dbctselect = $dbct->select();
    $dbctselect->from('eu_comite_ticket');
    $dbctselect_all = $dbct->fetchAll($dbctselect);
    $dbasctselect = $dbasts->select();
    $dbasctselect->from('eu_association_ticket_comite')
                 ->where('membre_section_comite_ticket like ?',$_SESSION['utilisateur']['nom_utilisateur'])
                 ->where('id_ticket like ?',$id);
    $dbasctselect_all = $dbasts->fetchAll($dbasctselect);
    $this->view->entries = $dbtselect_all;
    $this->view->association = $dbasctselect_all;
    $request = $this->getRequest();
    if($request->isPost()){
         $tmpFilePath = $_FILES['ticket_traitement_upload_file']['tmp_name'];
         $dir_files = str_replace('/','_',$dbtselect_all[0]["numero_demandeur"]);
         $file_ticket = explode('.',$_FILES['ticket_traitement_upload_file']['name']);
         $true_file_ticket = $file_ticket[1];
         if($tmpFilePath != "" && $true_file_ticket == "pdf"){
          $true_name_ticket = $dir_files.".".$file_ticket[1];
          $newFilePath = "../../webfiles/pdf_ticket_traite_upload"."/".$true_name_ticket;
          move_uploaded_file($tmpFilePath, $newFilePath);
          $dbasts->update(array('file_observation'=>$true_name_ticket), array('id_ticket = ?'=>$id));
         }
    }
  }

  public function editticketredispatchingAction(){

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $id = (int)$this->_request->getParam('id');

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support')
              ->where('id_ticket like ?', $id);
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $dbvselect = $dbvt->select();
    $dbvselect->from('eu_validation_ticket')
              ->where('id_ticket like ?', $id)
              ->where('num_validation like ?', '2');
    $dbvselect_all = $dbvt->fetchAll($dbvselect);

    $dbctselect = $dbct->select();
    $dbctselect->from('eu_comite_ticket');
    $dbctselect_all = $dbct->fetchAll($dbctselect);
    $dbasctselect = $dbasts->select();
    $dbasctselect->from('eu_association_ticket_comite')
                 ->where('id_ticket like ?',$id);
    $dbasctselect_all = $dbasts->fetchAll($dbasctselect);
    $this->view->validation = $dbvselect_all;
    $this->view->entries = $dbtselect_all;
    $this->view->comite = $dbctselect_all;
    $this->view->association = $dbasctselect_all;

  }


    public function editticketdispatcheurAction(){

      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $dbvt = new Application_Model_DbTable_EuValidationTicket();
      $vt = new Application_Model_EuValidationTicket();
      $dbct = new Application_Model_DbTable_EuComiteticket();
      $ct = new Application_Model_EuComiteTicket();

      $id = (int)$this->_request->getParam('id');

      $dbtselect = $dbts->select();
      $dbtselect->from('eu_ticket_support')
                ->where('id_ticket like ?', $id)
                ->where('visa_one != ""');
      $dbtselect_all = $dbts->fetchAll($dbtselect);

      $dbctselect = $dbct->select();
      $dbctselect->from('eu_comite_ticket');
      $dbctselect_all = $dbct->fetchAll($dbctselect);
      $this->view->entries = $dbtselect_all;
      $this->view->comite = $dbctselect_all;


    }

    public function editticketsecretariatsendtodemandeurAction(){
      //$this->_helper->layout->disableLayout();

      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $dbvt = new Application_Model_DbTable_EuValidationTicket();
      $vt = new Application_Model_EuValidationTicket();
      $dbct = new Application_Model_DbTable_EuComiteticket();
      $ct = new Application_Model_EuComiteTicket();
      $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
      $asts = new Application_Model_EuAssociationTicketComite();
      $id = (int)$this->_request->getParam('id');/*
      Util_Utils::genererPdfTicket($id);*/

      $dbtselect = $dbts->select();
      $dbtselect->from('eu_ticket_support')
                ->where('id_ticket like ?', $id)
                ->where('visa_one != ""')
                ->where('visa_two != ""');

      $dbtselect_all = $dbts->fetchAll($dbtselect);
      $dbvselect = $dbvt->select();
      $dbvselect->from('eu_validation_ticket')
                ->where('id_ticket like ?', $id)
                ->where('num_validation like ?', '2');
      $dbasctselect = $dbasts->select();
      $dbasctselect->from('eu_association_ticket_comite')
                   ->where('id_ticket like ?',$id);
      $dbasctselect_all = $dbasts->fetchAll($dbasctselect);
      $this->view->entries = $dbtselect_all;
      $this->view->association = $dbasctselect_all;
    }

    public function editticketdemandeurAction(){

      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $dbvt = new Application_Model_DbTable_EuValidationTicket();
      $vt = new Application_Model_EuValidationTicket();
      $dbct = new Application_Model_DbTable_EuComiteticket();
      $ct = new Application_Model_EuComiteTicket();
      $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
      $asts = new Application_Model_EuAssociationTicketComite();
      $id = (int)$this->_request->getParam('id');

      $dbtselect = $dbts->select();
      $dbtselect->from('eu_ticket_support')
                ->where('id_ticket like ?', $id)
                ->where('visa_one != ""');

      $dbtselect_all = $dbts->fetchAll($dbtselect);
      $dbvselect = $dbvt->select();
      $dbasctselect = $dbasts->select();
      $dbasctselect->from('eu_association_ticket_comite')
                   ->where('id_ticket like ?',$id);
      $dbasctselect_all = $dbasts->fetchAll($dbasctselect);
      $this->view->validation = $dbvselect_all;
      $this->view->entries = $dbtselect_all;
      $this->view->association = $dbasctselect_all;
    }


    public function editticketgerantsecondvisaAction(){

      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $dbvt = new Application_Model_DbTable_EuValidationTicket();
      $vt = new Application_Model_EuValidationTicket();
      $dbct = new Application_Model_DbTable_EuComiteticket();
      $ct = new Application_Model_EuComiteTicket();
      $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
      $asts = new Application_Model_EuAssociationTicketComite();
      $id = (int)$this->_request->getParam('id');/*
      Util_Utils::genererPdfTicket($id);*/

      $dbtselect = $dbts->select();
      $dbtselect->from('eu_ticket_support')
                ->where('id_ticket like ?', $id)
                ->where('visa_one != ""');

      $dbtselect_all = $dbts->fetchAll($dbtselect);
      $dbvselect = $dbvt->select();
      $dbasctselect = $dbasts->select();
      $dbasctselect->from('eu_association_ticket_comite')
                   ->where('id_ticket like ?',$id);
      $dbasctselect_all = $dbasts->fetchAll($dbasctselect);
      $this->view->validation = $dbvselect_all;
      $this->view->entries = $dbtselect_all;
      $this->view->association = $dbasctselect_all;
    }

    public function editticketgerantfirstvisaAction(){

      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $id = (int)$this->_request->getParam('id');/*
      Util_Utils::genererPdfTicket($id);*/


      $dbtselect = $dbts->select();
      $dbtselect->from('eu_ticket_support')
                ->where('id_ticket like ?', $id);
      $dbtselect_all = $dbts->fetchAll($dbtselect);
       if($dbtselect_all[0]['valid'] >= 2){
         $this->_redirect('/administration');         
       }

      $this->view->entries = $dbtselect_all;

    }

  public function addinterneAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    
    $created = Zend_Date::now();
    $request = $this->getRequest();
    $validationerrors = array();
    if($request->isPost()){
      if(!array_key_exists('integrateur_demandeur_ticket_support', $_POST)){
        $validationerrors['error_demandeur'] = "Erreur 404:Le Nom et Prenoms du demandeur de ce ticket n'existe pas";
      }

      if(empty($_POST['integrateur_demandeur_ticket_support'])){
         $validationerrors['empty_demandeur'] = "Le Nom et Prenoms de l'integrateur ne doit pas être vide";
      }

      if(filter_var($_POST['integrateur_demandeur_ticket_support'], FILTER_VALIDATE_REGEXP,
         array("options"=>array("regexp"=>"#[0-9]#")))){
         $validationerrors['integrateur_demandeur_ticket_support'] = "Le Nom et prénoms du demandeur ne doit pas comporté de valeurs numeriques";
      }
      if(!array_key_exists('integrateur_description_probleme',$_POST)){
        $validationerrors['error_description_demandeur'] = "Erreur 404:La Description du probleme de votre ticket n'existe pas";
      }

      if(empty($_POST['integrateur_description_probleme']) || $_POST['integrateur_description_probleme'] === ""){
           $validationerrors['emptyMessage'] = "Le Contenu de votre ticket ne doit pas être vide";
      }
      if(!empty($validationerrors)){
        $_SESSION['validationerrors'] = $validationerrors;
      }

     if(empty($validationerrors)){
       $db_ts_select = $dbts->select();
       $db_ts_select->from('eu_ticket_support',array('MAX(id_ticket) as count'));
       $mature_capa = $dbts->fetchAll($db_ts_select);
       $true_mature_capa = $mature_capa[0]['count'] + 1;

       $numero_demandeur = $true_mature_capa."/ESMC/TS/".$_POST["integrateur_demandeur_ticket_support"];
     $ts = array(
        'id_ticket'=>$true_mature_capa,
        'numero_demandeur'=>$numero_demandeur,
        'email'=>$_POST['integrateur_demandeur_email_interne'],
        'description'=>$_POST['integrateur_description_probleme'],
        'created'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
     $dbts->insert($ts);
       $validationpertesuccess['success_request'] = "Votre ticket de support a été parfaitement enregistré.";
       $_SESSION['validationpertesuccess'] = $validationpertesuccess;
    }
  }

  }

  public function addAction(){
    $cd = md5('interimfloozte');
    $de = md5('interimtmoneyte');

    $sessionmcnp = new Zend_Session_Namespace('mcnp');
    //$this->_helper->layout->disableLayout();
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbri = new Application_Model_DbTable_EuRenseignementIdentite();
    $ri = new Application_Model_EuRenseignementIdentite();
    $pre = new Application_Model_EuPrefecture();
    $prem = new Application_Model_EuPrefectureMapper();
    $can = new Application_Model_EuCanton();
    $canm = new Application_Model_EuCantonMapper();
    $vi = new Application_Model_EuVille();
    $vim = new Application_Model_EuVilleMapper();
    $re = new Application_Model_EuRegion();
    $rem = new Application_Model_EuRegionMapper();
    $rel = new Application_Model_EuReligion();
    $relm = new Application_Model_EuReligionMapper();
    $pa = new Application_Model_EuPays();
    $pam = new Application_Model_EuPaysMapper();
    $created = Zend_Date::now();
    $pre_all = $prem->fetchAll();
    $can_all = $canm->fetchAll();
    $vi_all = $vim->fetchAll();
    $re_all = $rem->fetchAll();
    $rel_all = $relm->fetchAll();
    $pa_all = $pam->fetchAll();
    $this->view->pre_all_entry = $pre_all;
    $this->view->can_all_entry = $can_all;
    $this->view->vi_all_entry = $vi_all;
    $this->view->re_all_entry = $re_all;
    $this->view->rel_all_entry = $rel_all;
    $this->view->pa_all_entry = $pa_all;
    $request = $this->getRequest();
    $validationerrors = array();



    if($request->isPost()){
      if(!array_key_exists('integrateur_demandeur_ticket_support', $_POST)){
        $validationerrors['error_demandeur'] = "Erreur 404:Le Nom,prenoms ou raison sociale du demandeur de ce ticket n'existe pas";
      }

      if(empty($_POST['integrateur_demandeur_ticket_support'])){
         $validationerrors['empty_demandeur'] = "Le Nom,prenoms ou raison sociale de l'integrateur ne doit pas être vide";
      }

      if(!array_key_exists('integrateur_code_membre_ticket_support', $_POST)){
        $validationerrors['error_code_membre_responsable_personne_perte'] = "Erreur 404:le Code membre du demandeur n'existe pas";
      }

      if(empty($_POST['integrateur_code_membre_ticket_support']) || $_POST['integrateur_code_membre_ticket_support'] === ""){
          $validationerrors['empty_integrateur_code_membre_ticket_support'] = "Erreur 404:le Code membre du demandeur ne doit pas être vide";
      }
      if(!filter_var($_POST['integrateur_code_membre_ticket_support'], FILTER_VALIDATE_REGEXP,
         array("options"=>array("regexp"=>"#[0-9{19}(P)$]#")))){
         $validationerrors['verif_integrateur_code_membre_ticket_support'] = "le Code membre du demandeur n'est pas valide";
      }

      if(!array_key_exists('integrateur_lieu_demandeur_ticket_support',$_POST)){
        $validationerrors['error_lieu_demandeur'] = "Erreur 404:Le Lieu du demandeur de ce ticket de support n'existe pas";
      }

      if(!array_key_exists('integrateur_telephone_ticket_support',$_POST)){
        $validationerrors['error_telephone_demandeur'] = "Le numero de telephone du demandeur n'existe pas dans la requête";
      }

      if($_POST['integrateur_telephone_ticket_support'] !== ""){
        if(filter_var($_POST['integrateur_telephone_ticket_support'], FILTER_VALIDATE_REGEXP,
           array("options"=>array("regexp"=>"#[^0-9]#")))){
           $validationerrors['verif_integrateur_telephone_ticket_support'] = "Le Numero de telephone du demandeur doit être numérique";
        }
      }


      if(!array_key_exists('integrateur_description_probleme',$_POST)){
        $validationerrors['error_description_demandeur'] = "Erreur 404:La Description du probleme de votre ticket n'existe pas";
      }

      if(empty($_POST['integrateur_description_probleme']) || $_POST['integrateur_description_probleme'] === ""){
           $validationerrors['emptyMessage'] = "Le Contenu de votre ticket ne doit pas être vide";
      }
       if($_POST['integrateur_email_ticket_support'] !== ""){
         if(!filter_var($_POST['integrateur_email_ticket_support'], FILTER_VALIDATE_EMAIL)){
           $validationerrors['error_integrateur_email_ticket_support'] = "Votre Email est Invalide";
         }
       }



        if(array_key_exists('piece_perte_personne',$_POST)){
          if($_POST['piece_perte_personne'] === '1'){

            $files = $_FILES['ticket_multiple_upload_file'];
            foreach ($files as $key => $value) {
              if(!array_key_exists('name',$files)){
                  $validationerrors['errors_file_name'] = "Le nom des fichiers n'existent pas";
              }
              if(!array_key_exists('type',$files)){
                  $validationerrors['errors_file_type'] = "Le type des fichiers n'existe pas";
              }

              if(!array_key_exists('tmp_name',$files)){
                $validationerrors['errors_file_tmp_name'] = "Le Chemin des fichiers n'existe pas";
              }

              if(!array_key_exists('size',$files)){
                $validationerrors['errors_size'] = "La taille des fichiers n'existe pas";
              }
              if($files['name'] === "" || empty($files['name'])){
                $validationerrors['empty_file_name'] = "Le nom des fichiers ne doit pas être vide";
              }
              if($files['type'] === "" || empty($files['type'])){
                $validationerrors['empty_file_type'] = "Le type des fichiers ne doit pas être vide";
              }
              if($files['tmp_name'] === "" || empty($files['tmp_name'])){
                $validationerrors['empty_file_tmp_name'] = "Le Chemin des fichiers ne doit pas être vide";
              }
              if($files['size'] === "" || empty($files['size'])){
                $validationerrors['empty_file_size'] = "La taille des fichiers ne doit pas être vide";
              }
             }
              $total_files = count($_FILES['ticket_multiple_upload_file']['name']);
              for($i=0; $i<$total_files; $i++) {
              $extension = strtolower(pathinfo($_FILES['ticket_multiple_upload_file']['name'][$i],PATHINFO_EXTENSION));
                 if(!in_array($extension,array('pdf','jpg','png','jpeg')) || !in_array($_FILES['ticket_multiple_upload_file']['type'][$i], array("application/pdf","image/jpg","image/jpeg","image/png"))){
                    $validationerrors['extensions'] = "Ce type de fichier n'est pas autorisé";
                 }
              }
           }
           if($_POST['piece_perte_personne'] === '0' || $_POST['piece_perte_personne'] === '-1'){
             if(!array_key_exists('nom_perte', $_POST)){
               $validationerrors['error_nom_perte'] = "Erreur 404:Le Nom de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['nom_perte']) || $_POST['nom_perte'] === ""){
                $validationerrors['empty_nom_perte'] = "Le Nom de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('prenom_perte', $_POST)){
               $validationerrors['error_prenom_perte'] = "Erreur 404:Le Prenom de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['prenom_perte']) || $_POST['nom_perte'] === ""){
                $validationerrors['empty_prenom_perte'] = "Le Prenom de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('sexe_perte', $_POST)){
               $validationerrors['error_sexe_perte'] = "Erreur 404:Le Sexe de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['sexe_perte']) || $_POST['sexe_perte'] === ""){
                $validationerrors['empty_sexe_perte'] = "Le Sexe de la personne declarant la perte ne doit pas être vide";
             }
             if(!in_array($_POST['sexe_perte'], array('Masculin','Feminin'))){
                $validationerrors['search_sexe_perte'] = "Le Sexe de la personne declarant la perte n'est pas valide";
            }

             if(!array_key_exists('nationalite_perte', $_POST)){
               $$validationerrors['error_nationalite_perte'] = "Erreur 404:La Nationalite de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['nationalite_perte']) || $_POST['nationalite_perte'] === ""){
                $validationerrors['empty_nationalite_perte'] = "Le Nationalite de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('nom_pere_perte', $_POST)){
               $validationerrors['error_nom_pere_perte'] = "Erreur 404:La Nom du Père de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['nom_pere_perte']) || $_POST['nom_pere_perte'] === ""){
                $validationerrors['empty_nom_pere_perte'] = "Le Nom du Père de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('nom_mère_perte', $_POST)){
               $validationerrors['error_nom_pere_perte'] = "Erreur 404:La Nom du Mère de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['nom_mère_perte']) || $_POST['nom_mère_perte'] === ""){
                $validationerrors['empty_nom_mère_perte'] = "Le Nom du Mère de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('situation_matrimoniale_perte', $_POST)){
               $validationerrors['error_nom_pere_perte'] = "Erreur 404:La Nom du Mère de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['situation_matrimoniale_perte']) || $_POST['situation_matrimoniale_perte'] === ""){
                $validationerrors['empty_situation_matrimoniale_perte'] = "La Situation Matrimoniale de la personne declarant la perte ne doit pas être vide";
             }

             if(!in_array($_POST['situation_matrimoniale_perte'],array('celibataire','marié(e)','divorcé(e)','fiancé(e)','voeuf(ve)'))){
               $validationerrors['search_situation_matrimoniale_perte'] = "La Situation Matrimoniale de la personne declarant la perte n'est pas valide";
             }

             if(!array_key_exists('date_naissance_perte', $_POST)){
               $validationerrors['error_date_naissance_perte'] = "Erreur 404:La Date de naissance de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['date_naissance_perte']) || $_POST['date_naissance_perte'] === ""){
                $validationerrors['empty_date_naissance_perte'] = "La Date de naissance de la personne declarant la perte ne doit pas être vide";
             }

             if(!filter_var($_POST['date_naissance_perte'], FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[^a-zA-Z]#")))){
                $validationerrors['verif_date_naissance_perte'] = "La Date de naissance ne doit pas être alphabétique ni alphanumerique mais doit être seulement numerique";
             }

             if(!array_key_exists('lieu_naissance_perte', $_POST)){
               $validationerrors['error_lieu_naissance_perte'] = "Erreur 404:Le Lieu de naissance de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['lieu_naissance_perte']) || $_POST['lieu_naissance_perte'] === ""){
                $validationerrors['empty_lieu_naissance_perte'] = "Le Lieu de naissance de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('nombre_enfant_perte', $_POST)){
               $validationerrors['error_nombre_enfant_perte'] = "Erreur 404:Le nombre d'enfant de la personne declarant la perte n'existe pas";
             }
/*
             if(empty($_POST['nombre_enfant_perte']) || $_POST['nombre_enfant_perte'] === ""){
                $validationperteerrors['empty_nombre_enfant_perte'] = "Le nombre d'enfant de la personne declarant la perte ne doit pas être vide";
             }

             if(!filter_var($_POST['nombre_enfant_perte'], FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationperteerrors['verif_nombre_enfant_perte'] = "Le nombre d'enfant de la personne declarant la perte doit être numerique";
             }*/
             if(!array_key_exists('adresse_perte', $_POST)){
               $validationerrors['error_adresse_perte'] = "Erreur 404:Le nombre d'enfant de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['adresse_perte']) || $_POST['adresse_perte'] === ""){
                $validationerrors['empty_adresse_perte'] = "L'Adresse de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('zone_monetaire_perte', $_POST)){
               $validationerrors['error_zone_monetaire_perte'] = "Erreur 404:la Zone monétaire de la personne declarant la perte n'existe pas";
             }

             if(!array_key_exists('region_perte', $_POST)){
               $validationerrors['error_region_perte'] = "Erreur 404:la Région de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['region_perte']) || $_POST['region_perte'] === ""){
                $validationerrors['empty_region_perte'] = "la Région de la personne declarant la perte ne doit pas être vide";
             }
             if(!array_key_exists('ville_perte', $_POST)){
               $validationerrors['error_ville_perte'] = "Erreur 404:la Ville de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['ville_perte']) || $_POST['ville_perte'] === ""){
                $validationerrors['empty_ville_perte'] = "la Ville de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('email_perte', $_POST)){
               $validationerrors['error_email_perte'] = "Erreur 404:l'Email de la personne declarant la perte n'existe pas";
             }

             if($_POST['email_perte'] !== ""){
               if(!filter_var($_POST['email_perte'], FILTER_VALIDATE_EMAIL)){
                 $validationerrors['verif_email_perte'] = "l'Email de la personne declarant la perte est Invalide";
               }
             }

             if(!array_key_exists('cellulaire_perte', $_POST)){
               $validationerrors['error_cellulaire_perte'] = "Erreur 404:le Numero de telephone portable de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['cellulaire_perte']) || $_POST['cellulaire_perte'] === ""){
                $validationerrors['empty_cellulaire_perte'] = "le Numero de telephone portable de la personne declarant la perte ne doit pas être vide";
             }

             if(!filter_var($_POST['cellulaire_perte'], FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationerrors['verif_cellulaire_perte'] = "le Numero de telephone portable de la personne declarant la perte doit être seulement numerique";
             }
             if(!array_key_exists('telephone_perte', $_POST)){
               $validationerrors['error_telephone_perte'] = "Erreur 404:le Numero de telephone fixe de la personne declarant la perte n'existe pas";
             }
             if($_POST['telephone_perte'] !== ""){
               if(!filter_var($_POST['telephone_perte'], FILTER_VALIDATE_REGEXP,
                  array("options"=>array("regexp"=>"#[0-9]#")))){
                  $validationerrors['verif_telephone_perte'] = "le Numero de telephone fixe de la personne declarant la perte doit être seulement numerique";
               }
             }

             if(!array_key_exists('profession_perte', $_POST)){
               $validationerrors['error_profession_perte'] = "Erreur 404:la profession de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['profession_perte']) || $_POST['profession_perte'] === ""){
                $validationerrors['empty_profession_perte'] = "la profession de la personne declarant la perte ne doit pas être vide";
             }
             if(filter_var($_POST['profession_perte'], FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationerrors['verif_profession_perte'] = "la profession de la personne declarant la perte ne doit pas être numerique";
             }
             if(!array_key_exists('religion_perte', $_POST)){
               $validationerrors['error_religion_perte'] = "Erreur 404:la religion de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['religion_perte']) || $_POST['religion_perte'] === ""){
                $validationerrors['empty_religion_perte'] = "la religion de la personne declarant la perte ne doit pas être vide";
             }

             if(!filter_var($_POST['religion_perte'], FILTER_VALIDATE_REGEXP,
                array("options"=>array("regexp"=>"#[0-9]#")))){
                $validationerrors['verif_religion_perte'] = "la religion de la personne declarant la perte doit être numerique";
             }
             if(!array_key_exists('quartier_perte', $_POST)){
               $validationerrors['error_quartier_perte'] = "Erreur 404:le Quartier de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['quartier_perte']) || $_POST['quartier_perte'] === ""){
                $validationerrors['empty_quartier_perte'] = "le quartier de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('canton_perte', $_POST)){
               $validationerrors['error_canton_perte'] = "Erreur 404:le Canton de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['canton_perte']) || $_POST['canton_perte'] === ""){
                $validationerrors['empty_canton_perte'] = "le canton de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('bp_perte', $_POST)){
               $validationerrors['error_bp_perte'] = "Erreur 404:la Boîte Postale de la personne declarant la perte n'existe pas";
             }

             if(!array_key_exists('pays_perte', $_POST)){
               $validationerrors['error_pays_perte'] = "Erreur 404:le Pays de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['pays_perte']) || $_POST['pays_perte'] === ""){
                $validationerrors['empty_pays_perte'] = "le pays de la personne declarant la perte ne doit pas être vide";
             }

             if(!array_key_exists('prefecture_perte', $_POST)){
               $validationerrors['error_pays_perte'] = "Erreur 404:la prefecture de la personne declarant la perte n'existe pas";
             }

             if(empty($_POST['prefecture_perte']) || $_POST['prefecture_perte'] === ""){
                $validationerrors['empty_prefecture_perte'] = "la prefecture de la personne declarant la perte ne doit pas être vide";
             }

              if(!array_key_exists('qualite_responsable_perte', $_POST)){
                $validationerrors['error_qualite_responsable_perte'] = "Erreur 404:la qualité du responsable de la personne declarant la perte n'existe pas";
              }

              if(empty($_POST['qualite_responsable_perte']) || $_POST['qualite_responsable_perte'] === ""){
                  $validationerrors['empty_qualite_responsable_perte'] = "la Qualité du responsable de la personne declarant la perte ne doit pas être vide";
              }

              if(!in_array($_POST['qualite_responsable_perte'],array('parent','tuteur','moi-même'))){
                $validationerrors['verif_qualite_responsable_perte'] = "la Qualité du responsable de la personne declarant la perte n'est pas valide";
              }

              if(!array_key_exists('nom_responsable_personne_perte', $_POST)){
                $validationerrors['error_nom_responsable_personne_perte'] = "Erreur 404:le nom du responsable de la personne declarant la perte n'existe pas";
              }

              if(empty($_POST['nom_responsable_personne_perte']) || $_POST['nom_responsable_personne_perte'] === ""){
                  $validationerrors['empty_nom_responsable_personne_perte'] = "Erreur 404:le nom du responsable de la personne declarant la perte ne doit pas être vide";
              }

              if(!array_key_exists('numero_responsable_telephone_personne_perte', $_POST)){
                $validationerrors['error_numero_responsable_telephone_personne_perte'] = "Erreur 404:le Numero de telephone portable du responsable de la personne declarant la perte n'existe pas";
              }

              if(empty($_POST['numero_responsable_telephone_personne_perte']) || $_POST['numero_responsable_telephone_personne_perte'] === ""){
                  $validationerrors['empty_telephone_responsable_personne_perte'] = "Erreur 404:le Numero de telephone portable du responsable de la personne declarant la perte ne doit pas être vide";
              }
              if($_POST['numero_responsable_telephone_personne_perte'] !== ""){
                if(!filter_var($_POST['numero_responsable_telephone_personne_perte'], FILTER_VALIDATE_REGEXP,
                   array("options"=>array("regexp"=>"#[0-9]#")))){
                   $validationerrors['verif_numero_responsable_telephone_personne_perte'] = "le Numero de telephone portable de la personne declarant la perte doit être seulement numerique";
                }
              }

              if(!array_key_exists('code_membre_responsable_personne_perte', $_POST)){
                $validationerrors['error_code_membre_responsable_personne_perte'] = "Erreur 404:le Code membre du responsable de la personne declarant la perte n'existe pas";
              }

              if(empty($_POST['code_membre_responsable_personne_perte']) || $_POST['code_membre_responsable_personne_perte'] === ""){
                  $validationerrors['empty_code_membre_resonsable_personne_perte'] = "Erreur 404:le Code membre du responsable de la personne declarant la perte ne doit pas être vide";
              }
              if(!filter_var($_POST['code_membre_responsable_personne_perte'], FILTER_VALIDATE_REGEXP,
                 array("options"=>array("regexp"=>"#[0-9{19}(P)$]#")))){
                 $validationerrors['verif_code_membre_resonsable_personne_perte'] = "le Code membre du responsable de la personne declarant la perte n'est pas valide";
              }
             }
           }
           if(!empty($validationerrors)){
             $_SESSION['validationerrors'] = $validationerrors;
           }

          if(empty($validationerrors)){
        /*    Util_Utils::sendprivateinternemail("benedicte@gacsource","ALIHONOU Benedicte");*/

            $db_ts_select = $dbts->select();
            $db_ts_select->from('eu_ticket_support',array('MAX(id_ticket) as count'));
            $mature_capa = $dbts->fetchAll($db_ts_select);
            $true_mature_capa = $mature_capa[0]['count'] + 1;

            $numero_demandeur = $true_mature_capa."/ESMC/TS/".$_POST["integrateur_demandeur_ticket_support"];
            $true_ri_find = 0;
            if(array_key_exists('piece_perte_personne',$_POST)){
            if($_POST['piece_perte_personne'] === '0' || $_POST['piece_perte_personne'] === '-1'){
              $db_ri_select = $dbri->select();
              $db_ri_select->from('eu_renseignement_identite',array('MAX(id) as count'));
              $ri_find = $dbri->fetchAll($db_ri_select);
              $true_ri_find = $ri_find[0]['count'] + 1;
                 $ri = array(
                   'id'=>$true_ri_find,
                   'nom'=>$_POST['nom_perte'],
                   'prenoms'=>$_POST["prenom_perte"],
                   'sexe'=>$_POST['sexe_perte'],
                   'ville'=>$_POST['ville_perte'],
                   'nationalite'=>$_POST['nationalite_perte'],
                   'email'=>$_POST['email_perte'],
                   'pere'=>$_POST['nom_pere_perte'],
                   'mere'=>$_POST['nom_mère_perte'],
                   'cellulaire'=>$_POST['cellulaire_perte'],
                   'telephone'=>$_POST['telephone_perte'],
                   'matrimonial'=>$_POST['situation_matrimoniale_perte'],
                   'profession'=>$_POST['profession_perte'],
                   'date_naissance'=>$_POST['date_naissance_perte'],
                   'religion'=>$_POST['religion_perte'],
                   'lieu_naissance'=>$_POST['lieu_naissance_perte'],
                   'quartier'=>$_POST['quartier_perte'],
                   'nbre_enfant'=>$_POST['nombre_enfant_perte'],
                   'cantons'=>$_POST['canton_perte'],
                   'addresse'=>$_POST['adresse_perte'],
                   'bp'=>$_POST['bp_perte'],
                   'monetaire'=>$_POST['zone_monetaire_perte'],
                   'pays'=>$_POST['pays_perte'],
                   'region'=>$_POST['region_perte'],
                   'prefecture'=>$_POST['prefecture_perte'],
                   'perdu'=>$_POST['piece_perte_personne'],
                   'qualite_responsable'=>$_POST['qualite_responsable_perte'],
                   'nom_responsable'=>$_POST['nom_responsable_personne_perte'],
                   'telephone_responsable'=>$_POST['numero_responsable_telephone_personne_perte'],
                   'code_membre_responsable'=>$_POST['code_membre_responsable_personne_perte'],
                   'created'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
                  $dbri->insert($ri);
              }
          }
          $ts = array(
             'id_ticket'=>$true_mature_capa,
             'renseignement_id'=>$true_ri_find,
             'numero_demandeur'=>$numero_demandeur,
             'telephone'=>$_POST["integrateur_telephone_ticket_support"],
             'email'=>$_POST['integrateur_email_ticket_support'],
             'lieu'=>$_POST['integrateur_lieu_demandeur_ticket_support'],
             'addresse_integrateur'=>$_POST['integrateur_addresse'],
             'code_membre_demandeur'=>$_POST['integrateur_code_membre_ticket_support'],
             'description'=>$_POST['integrateur_description_probleme'],
             'created'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
          $dbts->insert($ts);
          if(array_key_exists('piece_perte_personne',$_POST)){
            if($_POST['piece_perte_personne'] === '1'){
              $ts = array('file_name'=>"true");
              $dir_files = $true_mature_capa."_ESMC_FILES_".$_POST["integrateur_demandeur_ticket_support"];
              $src_file = "../../webfiles/pdf_upload/$dir_files";
              mkdir($src_file,0777);
              $total_files = count($_FILES['ticket_multiple_upload_file']['name']);
              for($i=0; $i<$total_files; $i++) {
                $tmpFilePath = $_FILES['ticket_multiple_upload_file']['tmp_name'][$i];

                if ($tmpFilePath != ""){
                  $file_ticket = explode('.',$_FILES['ticket_multiple_upload_file']['name'][$i]);
                  $true_file_ticket = $file_ticket[1];
                  $true_name_ticket = $true_mature_capa."_$i".".".$file_ticket[1];
                  $newFilePath = "../../webfiles/pdf_upload"."/".$dir_files."/".$true_name_ticket;
                  move_uploaded_file($tmpFilePath, $newFilePath);
               }
              }
              $dbts->update($ts,array('id_ticket = ?'=>$true_mature_capa));

            }
          }

          $validationpertesuccess['success_request'] = "Votre ticket de support a été parfaitement enregistré.";
          $_SESSION['validationpertesuccess'] = $validationpertesuccess;
        }
      }
  }

  public function renseignementAction(){

  }

  public function formusergroupAction(){
    $dbug = new Application_Model_DbTable_EuUserGroup();
    $ug = new Application_Model_EuUserGroup();
    $request = $this->getRequest();
    if($request->getPost()){
      $ug = array(
         'code_groupe'=>$_POST['code_group_ticket_support'],
         'libelle_groupe'=>$_POST['libelle_group_ticket_support']);
      $dbug->insert($ug);
    }


  }

  public function ticketsendallajaxAction(){
    $this->_helper->layout()->disableLayout();
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $listallrefticketsendtodg = json_decode($_POST["listallrefticketsendtodg"]);


    foreach($listallrefticketsendtodg as $key => $value){
      $dbts->update(array('valid'=>'1'),array('id_ticket = ?'=>$value));
    }
    $resultjson = array('success'=>'Ticket envoye au gerant avec success');
    header('Content-type:application/json');
    die(json_encode($resultjson));
    
  }

  public function adduserticketAction(){
    $dbug = new Application_Model_DbTable_EuUserGroup();
    $ug = new Application_Model_EuUserGroup();
    $ugm = new Application_Model_EuUserGroupMapper();
    $ugm_all = $ugm->fetchAll();
    $this->view->code_group = $ugm_all;
    $dbut = new Application_Model_DbTable_EuUtilisateur();
    $dbutm = new Application_Model_EuUtilisateurMapper();

    $ut = new Application_Model_EuUtilisateur();
    $request = $this->getRequest();
    if($request->getPost()){
      $id_utilisateur = $dbutm->findConuter() + 1;
      $ut = array(
         'id_utilisateur'=>$id_utilisateur,
         'login'=>$_POST['login'],
         'pwd'=>$_POST['pwd'],
         'nom_utilisateur'=>$_POST['nom'],
         'prenom_utilisateur'=>$_POST['prenom'],
         'code_groupe'=>$_POST['code_group']);
      $dbut->insert($ut);
    }
  }

  public function listevalideniveauoneAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid >= ?', '0');
    $dbtselect_all = $dbts->fetchAll($dbtselect);

   /**LISTE DES TICKETS DE SUPPORT EMIS**/
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->order(array('id_ticket ASC'));
    
    $list_ticket_all = $dbts->fetchAll($dbtselect);
    $count_list_ticket_all = count($list_ticket_all);

    /**LISTE DES TICKETS DE SUPPORT DISPONIBLE AU SECREATARIAT**/
        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '0');
        $list_ticket_secretariat_one_all = $dbts->fetchAll($dbtselect);
        $count_list_ticket_secretariat_one_all = count($list_ticket_secretariat_one_all);
    /**LISTE DES TICKETS DE SUPPORT DISPONIBLE CHEZ LE GERANT POUR PREMIER VISA**/
        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '1');
        $list_ticket_gerant_one_all = $dbts->fetchAll($dbtselect);
        $count_list_ticket_gerant_one_all = count($list_ticket_gerant_one_all);
    /**LISTE DES TICKETS DE SUPPORT DISPONIBLE CHEZ LE DISPATCHEUR**/
        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '2');
        $list_ticket_dispatcheur_one_all = $dbts->fetchAll($dbtselect);
        $count_list_ticket_dispatcheur_one_all = count($list_ticket_dispatcheur_one_all);
    /**LISTE DES TICKETS DE SUPPORT DISPONIBLE CHEZ LES SECTIONS*/
        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '3');
        $list_ticket_section_one_all = $dbts->fetchAll($dbtselect);
        $count_list_ticket_section_one_all = count($list_ticket_section_one_all);
    /**LISTE DES TICKETS DE SUPPORT DISPONIBLE CHEZ LE DISTACHEUR POUR VALIDATION DE TRAITEMENT*/
        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '4');
        $list_ticket_dispatcheur_two_all = $dbts->fetchAll($dbtselect);
        $count_list_ticket_dispatcheur_two_all = count($list_ticket_dispatcheur_two_all);
  /**LISTE DES TICKETS DE SUPPORT DISPONIBLE CHEZ LE GERANT POUR DEUXIEME SIGNATURE*/

        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '5');
        $list_ticket_gerant_two_all = $dbts->fetchAll($dbtselect);
        $count_list_ticket_gerant_two_all = count($list_ticket_gerant_two_all);
  /**LISTE DES TICKETS DE SUPPORT DISPONIBLE CHEZ LE SECREATARIAT POUR ENVOI DANS ESPACE PERSONNEL*/

        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '6');
        $list_ticket_secretariat_two_all = $dbts->fetchAll($dbtselect);
        $count_ticket_secretariat_two_all = count($list_ticket_secretariat_two_all);
  /**LISTE DES TICKETS DE SUPPORT DISPONIBLE CHEZ LE DEMANDEUR DANS ESPACE PERSONNEL*/

        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '7');
        $list_ticket_demandeur_two_all = $dbts->fetchAll($dbtselect);
        $count_list_demandeur_two_all = count($list_ticket_demandeur_two_all);
  /**LISTE DES TICKETS DE SUPPORT QUI SONT TRAITES*/

        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '8');
        $list_ticket_ready_all = $dbts->fetchAll($dbtselect);
        $count_list_ticket_ready_all = count($list_ticket_ready_all);
  /**LISTE DES TICKETS DE SUPPORT QUI SONT ARCHIVES*/
        $dbtselect = $dbts->select();
        $dbtselect->from('eu_ticket_support');
        $dbtselect->where('valid like ?', '9');
        $list_ticket_archive_all = $dbts->fetchAll($dbtselect);
        $count_list_ticket_archive_all = count($list_ticket_archive_all);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->count_list_ticket_archive_all = $count_list_ticket_archive_all;
    $this->view->count_list_ticket_ready_all = $count_list_ticket_ready_all;
    $this->view->count_list_demandeur_two_all = $count_list_demandeur_two_all;
    $this->view->count_ticket_secretariat_two_all = $count_ticket_secretariat_two_all;
    $this->view->count_list_ticket_gerant_two_all = $count_list_ticket_gerant_two_all;
    $this->view->count_list_ticket_section_one_all = $count_list_ticket_section_one_all;
    $this->view->count_list_ticket_dispatcheur_one_all = $count_list_ticket_dispatcheur_one_all;
    $this->view->count_list_ticket_dispatcheur_two_all = $count_list_ticket_dispatcheur_two_all;
    $this->view->count_list_ticket_gerant_one_all = $count_list_ticket_gerant_one_all;
    $this->view->count_list_ticket_secretariat_one_all = $count_list_ticket_secretariat_one_all;
    $this->view->count_list_ticket_all = $count_list_ticket_all;
        $this->view->tabletri = 1;
  }

  public function listevalideniveauonegerantAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    if ($validation != "" && $validation >= 1 && $validation <= 6) {
      $dbtselect->where('valid like ?', $validation);
    }
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
        $this->view->tabletri = 1;
    
  }

  public function listevalideniveautwoAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    $validation = (int)$this->_request->getParam('valid');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid >= ?', '2');
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
  }

  public function listevalidationniveautwodispatchAction(){
    $validation = (int)$this->_request->getParam('valid');
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    if ($validation != "" && $validation >= 2 && $validation <= 6) {
      $dbtselect->where('valid like ?', $validation);
    }
    $dbtselect_all = $dbts->fetchAll($dbtselect);

    $dbctselect = $dbct->select();
    $dbctselect->from('eu_comite_ticket');
    $dbctselect_all = $dbct->fetchAll($dbctselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
    $this->view->comite = $dbctselect_all;
    $this->view->tabletri = 1;

  }

  public function listevalidationniveauthreeAction(){

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');

    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbastc = new Application_Model_DbTable_EuAssociationTicketComite();
    $astc = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid >= ?', '3');
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $dbasctselect = $dbastc->select();
    $dbasctselect->from('eu_association_ticket_comite');
    $dbasctselect_all = $dbastc->fetchAll($dbasctselect);

    $dbctselect = $dbct->select();
    $dbctselect->from('eu_comite_ticket');
    $dbctselect_all = $dbct->fetchAll($dbctselect);

    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
    $this->view->assoc = $dbasctselect_all;
    $this->view->comite = $dbctselect_all;
    $this->view->tabletri = 1;
    
  }

  public function listevalidationniveauthreesectionAction(){

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');
    $db = Zend_Db_Table::getDefaultAdapter();
    

    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbastc = new Application_Model_DbTable_EuAssociationTicketComite();
    $astc = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $dbcv = new Application_Model_DbTable_EuConvention();
    
    $vt = new Application_Model_EuValidationTicket();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $identitie_utilisateur = $_SESSION['utilisateur']['nom_utilisateur'];
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    
    
    if (!isset($sessionutilisateur->login)){
      $this->_redirect('/administration/login');
    }
/*    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    if ($validation != "" && $validation >= 3 && $validation <= 6) {
      $dbtselect->where('valid like ?', $validation);
    }


    $dbtselect_all = $dbts->fetchAll($dbtselect);

    $dbasctselect = $dbastc->select();
    $dbasctselect->from('eu_association_ticket_comite')
                 ->where("membre_section_comite_ticket like '%$identitie_utilisateur%'");
    $dbasctselect_all = $dbastc->fetchAll($dbasctselect);
    $dbctselect = $dbct->select();
    $dbctselect->from('eu_comite_ticket');
    $dbctselect_all = $dbct->fetchAll($dbctselect);


    $this->view->entries = $dbtselect_all;
    $this->view->assoc = $dbasctselect_all;
    $this->view->comite = $dbctselect_all;*/

    $dbtselect = "SELECT *
    FROM eu_ticket_support, eu_association_ticket_comite
    WHERE eu_ticket_support.id_ticket = eu_association_ticket_comite.id_ticket
    AND eu_ticket_support.valid = 3
    AND eu_association_ticket_comite.membre_section_comite_ticket like '%$identitie_utilisateur%'
    AND eu_association_ticket_comite.statut NOT IN ('traité', 'non traité', 'en cours')";

    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbtselect_all = $stmt->fetchAll();


    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
    $this->view->tabletri = 1;
    
  }

  public function listevalidationniveauforthAction(){

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');
    $db = Zend_Db_Table::getDefaultAdapter();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";


    /*
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    if ($validation != "" && $validation >= 4 && $validation <= 6) {
      $dbtselect->where('valid like ?', $validation);
    }
    $dbtselect_all = $dbts->fetchAll($dbtselect);

    $dbasctselect = $dbastc->select();
    $dbasctselect->from('eu_association_ticket_comite');
    $dbasctselect_all = $dbastc->fetchAll($dbasctselect);

    $dbctselect = $dbct->select();
    $dbctselect->from('eu_comite_ticket');
    $dbctselect_all = $dbct->fetchAll($dbctselect);*/
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";


    $dbtselect = "SELECT *
    FROM eu_ticket_support, eu_association_ticket_comite
    WHERE eu_ticket_support.id_ticket = eu_association_ticket_comite.id_ticket
    AND eu_ticket_support.valid = 4
    AND eu_association_ticket_comite.statut IN ('traité', 'non traité')";

    $db->setFetchMode(Zend_Db::FETCH_OBJ);
    $stmt = $db->query($dbtselect);
    $dbtselect_all = $stmt->fetchAll();

    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;

  }

  public function listevalidationniveauforthdispatchAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');

    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbastc = new Application_Model_DbTable_EuAssociationTicketComite();
    $astc = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    if ($validation != "" && $validation >= 4 && $validation <= 6) {
      $dbtselect->where('valid like ?', $validation);
    }
    $dbtselect_all = $dbts->fetchAll($dbtselect);

    $dbasctselect = $dbastc->select();
    $dbasctselect->from('eu_association_ticket_comite');
    $dbasctselect_all = $dbastc->fetchAll($dbasctselect);

    $dbctselect = $dbct->select();
    $dbctselect->from('eu_comite_ticket');
    $dbctselect_all = $dbct->fetchAll($dbctselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
    $this->view->comite = $dbctselect_all;
    $this->view->assoc = $dbasctselect_all;
    $this->view->tabletri = 1;

  }

  public function listevalidationniveauforthdispatchrenewAction(){

  }

  public function listevalidationniveaufifthAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid >= ?', "5");
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
  }

  public function listevalidationniveaufifthgerantAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    if ($validation != "" && $validation >= 5 && $validation <= 6) {
      $dbtselect->where('valid like ?', $validation);
    }
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
  }

  public function listevalidationniveausixAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $validation = (int)$this->_request->getParam('valid');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid like ?', '6');
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
        $this->view->tabletri = 1;
    
  }

  public function ticketpersonontraiteAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    //$this->_helper->layout()->setLayout('layoutpublicesmcadminperso');
    $sessionmembre = new Zend_Session_Namespace('membre');
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('code_membre_demandeur like ?',$sessionmembre->code_membre);
    $dbtselect->where('valid = 0 OR valid = 1 OR valid = 2 OR valid = 3 OR valid = 4 OR valid = 5 OR valid = 6');

    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
        $this->view->tabletri = 1;
    
  }

  public function ticketenvoiepersonnelAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    //$this->_helper->layout()->setLayout('layoutpublicesmcadminperso');
    $sessionmembre = new Zend_Session_Namespace('membre');
    $this->_helper->layout()->setLayout('layoutpublicesmcperso');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('code_membre_demandeur like ?',$sessionmembre->code_membre);
    $dbtselect->where('valid = 5 OR valid = 6');

    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
    $this->view->tabletri = 1;
    
  }

  public function selectallticketAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    if (!isset($sessionutilisateur->login)){
      $this->_redirect('/administration/login');
    }
    if($sessionutilisateur->confirmation != ""){
      $this->_redirect('/administration/confirmation');
    }/*
    if($sessionutilisateur->login != "acnevanima2"){
      $this->_redirect('/administration/login');
    }*/
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid like ?','0');
    $dbtselect->where('invalid like ?','0');

    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
  }

  public function archivesticketsecretariatAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');
    $dbut = new Application_Model_DbTable_EuUtilisateur();
    $dbutm = new Application_Model_EuUtilisateurMapper();
    //$this->_helper->layout->disableLayout();
    //$this->_helper->layout()->setLayout('layoutpublicesmcadminperso');
    $sessionmembre = new Zend_Session_Namespace('membre');

    $this->_helper->layout()->setLayout('layoutpublicesmcadminperso');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid like ?','6');

    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
    $this->view->tabletri = 1;
    
  }

  public function listdesarchivageticketsupportAction(){
    $sessionmcnp = new Zend_Session_Namespace('mcnp');

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid like ?','6');

    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
    $this->view->tabletri = 1;
    
  }


    public function backgroundticketsAction(){
      $sessionmcnp = new Zend_Session_Namespace('mcnp');

      //$this->_helper->layout->disableLayout();
      $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $dbvt = new Application_Model_DbTable_EuValidationTicket();
      $vt = new Application_Model_EuValidationTicket();
      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

      $dbvselect = $dbvt->select();
      $dbvselect->from('eu_validation_ticket');
      $dbvselect_all = $dbvt->fetchAll($dbvselect);

      $dbtselect = $dbts->select();
      $dbtselect->from('eu_ticket_support');
      $dbtselect_all = $dbts->fetchAll($dbtselect);

      $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";
      $this->view->entries = $dbvselect_all;
      $this->view->file_upload = $src_file;
      $this->view->ticket = $dbtselect_all;
    }

  public function listinvalidticketAction(){

    //$this->_helper->layout->disableLayout();
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    if (!isset($sessionutilisateur->login)){
      $this->_redirect('/administration/login');
    }
    if($sessionutilisateur->confirmation != ""){
      $this->_redirect('/administration/confirmation');
    }/*
    if($sessionutilisateur->login != "acnevanima2"){
      $this->_redirect('/administration/login');
    }*/
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('invalid like ?','1');
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
  }
  public function listAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    if (!isset($sessionutilisateur->login)){
      $this->_redirect('/administration/login');
    }
    if($sessionutilisateur->confirmation != ""){
      $this->_redirect('/administration/confirmation');
    }/*
    if($sessionutilisateur->login != "acnevanima2"){
      $this->_redirect('/administration/login');
    }*/
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support');
    $dbtselect->where('valid like ?','0');
    $dbtselect->where('invalid like ?','0');

    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $src_file = Util_Utils::getParamEsmc(1)."/pdf_upload";

    $this->view->entries = $dbtselect_all;
    $this->view->file_upload = $src_file;
  }

  public function editAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    $id = (int)$this->_request->getParam('id');

   $this->_redirect(Util_Utils::genererPdfTicket($id));

  }
  public function editingAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $id = (int)$this->_request->getParam('id');/*
    Util_Utils::genererPdfTicket($id);*/

    $dbtselect = $dbts->select();
    $dbtselect->from('eu_ticket_support')
              ->where('id_ticket like ?', $id);
    $dbtselect_all = $dbts->fetchAll($dbtselect);
    $this->view->entries = $dbtselect_all;

  }

  public function fileeditAction(){
    $this->_helper->layout()->setLayout('layoutpublicesmcadmin');
    $id = (int)$this->_request->getParam('id');

    $this->_redirect(Util_Utils::genererPdfRenseignement($id));
  }

  public function deleteAction(){
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $current_id = (int) $this->_request->getParam('id');
    $resultjson = array();
    if($dbts->delete(array('id_ticket = ?' => $current_id))){
      $resultjson = array(
        'delete'=>'La Suppression de ce ticket a ete effectue avec success'
      );
    }

    header('Content-type:application/json');
    die(json_encode($resultjson));

  }


      public function invalidAction(){
        $this->_helper->layout()->setLayout('layoutpublicesmcadmin');

        $current_id = $_POST['idticket'];
        $dbts = new Application_Model_DbTable_EuTicketSupport();
        $ts = new Application_Model_EuTicketSupport();
        $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
        $asts = new Application_Model_EuAssociationTicketComite();
        $dbct = new Application_Model_DbTable_EuComiteticket();
        $ct = new Application_Model_EuComiteTicket();
        $dbvt = new Application_Model_DbTable_EuValidationTicket();
        $vt = new Application_Model_EuValidationTicket();
        $created = Zend_Date::now();
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

        $resultjson = array();
        $ts = array(
           'invalid'=>'1',
           'valid'=>'-1'
          );
        $db_vt_select = $dbvt->select();
        $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
        $validation = $dbvt->fetchAll($db_vt_select);
        $true_validation = $validation[0]['count'] + 1;
        $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
        $vt = array(
              'id'=>$true_validation,
              'num_validation'=>'0',
              'id_ticket'=>$current_id,
              'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
              'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

      if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
        $resultjson = array(
          'update'=>'Ce ticket est maintenant invalide'
        );
      }

        header('Content-type:application/json');
        die(json_encode($resultjson));
      }
      public function ticketrecycleAction(){
        $current_id = $_POST['idticket'];
        $dbts = new Application_Model_DbTable_EuTicketSupport();
        $ts = new Application_Model_EuTicketSupport();
        $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
        $asts = new Application_Model_EuAssociationTicketComite();
        $dbct = new Application_Model_DbTable_EuComiteticket();
        $ct = new Application_Model_EuComiteTicket();
        $dbvt = new Application_Model_DbTable_EuValidationTicket();
        $vt = new Application_Model_EuValidationTicket();
        $created = Zend_Date::now();
        $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

        $resultjson = array();
        $ts = array(
           'invalid'=>'1','valid'=>'-1','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
        $db_vt_select = $dbvt->select();
        $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
        $validation = $dbvt->fetchAll($db_vt_select);
        $true_validation = $validation[0]['count'] + 1;
        $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
        $vt = array(
              'id'=>$true_validation,
              'num_validation'=>'0',
              'id_ticket'=>$current_id,
              'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
              'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

      if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
        $resultjson = array(
          'update'=>'Ce ticket est maintenant invalide'
        );
      }

        header('Content-type:application/json');
        die(json_encode($resultjson));
      }



    public function validAction(){
      $current_id = $_POST['idticket'];
      $dbts = new Application_Model_DbTable_EuTicketSupport();
      $ts = new Application_Model_EuTicketSupport();
      $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
      $asts = new Application_Model_EuAssociationTicketComite();
      $dbct = new Application_Model_DbTable_EuComiteticket();
      $ct = new Application_Model_EuComiteTicket();
      $dbvt = new Application_Model_DbTable_EuValidationTicket();
      $vt = new Application_Model_EuValidationTicket();
      $created = Zend_Date::now();
      $sessionutilisateur = new Zend_Session_Namespace('utilisateur');

      $resultjson = array();
      $ts = array(
         'valid'=>'1','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
      $db_vt_select = $dbvt->select();
      $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
      $validation = $dbvt->fetchAll($db_vt_select);
      $true_validation = $validation[0]['count'] + 1;
      $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
      $vt = array(
            'id'=>$true_validation,
            'num_validation'=>'1',
            'id_ticket'=>$current_id,
            'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
            'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

    if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
      $resultjson = array(
        'update'=>'Ce ticket a été transféré avec succès au gérant '
      );
    }

      header('Content-type:application/json');
      die(json_encode($resultjson));
    }



  public function validationdispatchAction(){
    $current_id = $_POST['idticket'];
    $comite_id = $_POST['comiteidticket'];
    $section_comite_ticket = $_POST['sectionticket'];
    $email_comite_ticket = $_POST['emailticket'];


    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbastc = new Application_Model_DbTable_EuAssociationTicketComite();
    $astc = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();
    $ts = array(
       'valid'=>'3','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;

    $db_astc_select = $dbastc->select();
    $db_astc_select->from('eu_association_ticket_comite',array('MAX(id) as count'));
    $association_validation = $dbastc->fetchAll($db_astc_select);
    $true_association_validation = $association_validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'3',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $as = array(
                'id'=>$true_association_validation,
                'id_ticket'=>$current_id,
                'id_comite_ticket'=>$comite_id,
                'membre_section_comite_ticket'=>$section_comite_ticket,
                'statut'=>"",
                'date_dispatch'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

      $das = array(
        'id_ticket'=>$current_id,
        'id_comite_ticket'=>$comite_id,
        'membre_section_comite_ticket'=>$section_comite_ticket,
        'statut'=>'',
        'observation'=>'',
        'date_dispatch'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
      $db_search_select = $dbastc->select();
      $db_search_select->from('eu_association_ticket_comite')
                     ->where('id_ticket like ?',$current_id);
      $association_find = $dbastc->fetchAll($db_search_select);

    if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket like ?'=>$current_id))){
      Util_Utils::sendprivateinternemail($email_comite_ticket,$section_comite_ticket);
      if(count($association_find) > 0){
        $dbastc->update($das,array('id like ?'=>$association_find[0]['id']));
      }else{
         $dbastc->insert($as);
      }

            $resultjson = array(
              'update'=>'Re-Dispatch effectue avec success'
            );
    }
            header('Content-type:application/json');
            die(json_encode($resultjson));
  }

  public function transfertdispatchgerantAction(){
    $current_id = $_POST['idticket'];
    $current_num = $_POST['numticket'];
    $current_date = $_POST['dateticket'];
    $current_email = $_POST['emailticket'];
    $current_name = $_POST['recepteur'];
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
     $resultjson = array();
    $ts = array(
       'valid'=>'5','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'5',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

  if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
    /*Util_Utils::sendprivateinternemail("gsda@gacsource.com","Gérant");*/
    Util_Utils::sendpublicexternemail($current_name,$current_email,$current_num,$current_date);


    $resultjson = array(
      'update'=>'Ce ticket a été transféré avec succès au gérant pour deuxieme visa.Une copie est enoyé dans l\'espace personnel du membre pour confirmation'
    );
  }
    header('Content-type:application/json');
    die(json_encode($resultjson));
  }

  public function invalidtovalidAction(){
    $current_id = $_POST['idticket'];
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();

    $ts = array(
       'valid'=>'2',
       'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'),
       'invalid'=>'0'
     );
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'2',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

  if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
    $resultjson = array(
      'update'=>'Remise dans le circuit effectué avec succes'
    );
  }
    header('Content-type:application/json');
    die(json_encode($resultjson));
  }

  public function visaonegerantAction(){
    $current_id = $_POST['idticket'];
    $visa_one = $_POST['visaticket'];
    $avis_one = $_POST['avisticket'];

    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();

    $ts = array(
       'valid'=>'2',
       'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'),  
       'visa_one'=>$visa_one,
       'avis_one'=>$avis_one
     );
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'2',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

  if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
    /*Util_Utils::sendprivateinternemail("atiyodi@gacsource.com","ATIYODI");*/

    $resultjson = array(
      'update'=>'Premiere signature effectue avec success'
    );
  }
    header('Content-type:application/json');
    die(json_encode($resultjson));
  }


  public function sendespaceAction(){
    $current_id = $_POST['idticket'];
    $current_num = $_POST['numticket'];
    $current_date = $_POST['dateticket'];
    $current_email = $_POST['emailticket'];
    $current_name = $_POST['recepteur'];


    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();

    $ts = array(
       'valid'=>'7','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'7',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

  if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
        $resultjson = array(
      'update'=>'L\'envoi s\'est effectue avec success'
    );
  }
  header('Content-type:application/json');
  die(json_encode($resultjson));
  }

  public function archivagesecretariatAction(){
    $current_id = $_POST['idticket'];
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();

    $ts = array(
       'valid'=>'9','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'9',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

  if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
    $resultjson = array(
      'update'=>'Archivage effectue avec success'
    );
  }
  header('Content-type:application/json');
  die(json_encode($resultjson));
  }

  public function ticketenvoiepersonnelvalidAction(){
    $current_id = $_POST['idticket'];
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();

    $ts = array(
       'valid'=>'8','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'8',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

  if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
    $resultjson = array(
      'update'=>'L\'envoi s\'est effectue avec success'
    );
  }
  header('Content-type:application/json');
  die(json_encode($resultjson));
  }

  public function visatwogerantAction(){
    $current_id = $_POST['idticket'];
    $visa_one = $_POST['visaoneticket'];
    $avis_one = $_POST['avisoneticket'];
    $visa_two = $_POST['visaticket'];
    $avis_two = $_POST['avisticket'];
    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbasts = new Application_Model_DbTable_EuAssociationTicketComite();
    $asts = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();

    $ts = array(
       'valid'=>'6',
       'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'),
       'visa_two'=>$visa_two,
       'avis_two'=>$avis_two
     );
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'6',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

  if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=>$current_id))){
    /*Util_Utils::sendprivateinternemail("gsda@gacsource.com","Gérant");*/

    $resultjson = array(
      'update'=>'Deuxieme signature effectue avec success'
    );
  }
  header('Content-type:application/json');
  die(json_encode($resultjson));
  }

  public function sectionvalidAction(){
    $current_id = $_POST['idticket'];
    $comite_id = $_POST['comiteidticket'];
    $observation = $_POST['observation'];
    $statut = $_POST['statut'];

    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbastc = new Application_Model_DbTable_EuAssociationTicketComite();
    $astc = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();

    $ts = array(
       'valid'=>'4','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;

    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'4',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $membre_section_comite_ticket = $_SESSION['utilisateur']['nom_utilisateur']." ".$_SESSION['utilisateur']['prenom_utilisateur'];
    $astc = array(
      'observation'=>$observation,
      'statut'=>$statut,
      'date_observation'=>$created->toString('yyyy-MM-dd HH:mm:ss'),
      'membre_section_comite_ticket'=>$membre_section_comite_ticket
    );
      if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket = ?'=> $current_id)) && $dbastc->update($astc,array('id_ticket = ?'=>$current_id))){
                  $resultjson = array(
                    'update'=>'Validation effectué avec succes'
                  );
      }
      header('Content-type:application/json');
      die(json_encode($resultjson));
  }


  public function dispatchAction(){
    $current_id = $_POST['idticket'];
    $comite_id = $_POST['idcomiteticket'];

    $section_comite_ticket = $_POST['sectionticket'];
    $email_comite_ticket = $_POST['emailticket'];


    $dbts = new Application_Model_DbTable_EuTicketSupport();
    $ts = new Application_Model_EuTicketSupport();
    $dbastc = new Application_Model_DbTable_EuAssociationTicketComite();
    $astc = new Application_Model_EuAssociationTicketComite();
    $dbct = new Application_Model_DbTable_EuComiteticket();
    $ct = new Application_Model_EuComiteTicket();
    $dbvt = new Application_Model_DbTable_EuValidationTicket();
    $vt = new Application_Model_EuValidationTicket();
    $created = Zend_Date::now();
    $sessionutilisateur = new Zend_Session_Namespace('utilisateur');
    $resultjson = array();
    $ts = array(
       'valid'=>'3','date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $db_vt_select = $dbvt->select();
    $db_vt_select->from('eu_validation_ticket',array('MAX(id) as count'));
    $validation = $dbvt->fetchAll($db_vt_select);
    $true_validation = $validation[0]['count'] + 1;

    $db_astc_select = $dbastc->select();
    $db_astc_select->from('eu_association_ticket_comite',array('MAX(id) as count'));
    $association_validation = $dbastc->fetchAll($db_astc_select);
    $true_association_validation = $association_validation[0]['count'] + 1;
    $responsable_traitement_ticket = $sessionutilisateur->id_utilisateur;
    $vt = array(
          'id'=>$true_validation,
          'num_validation'=>'3',
          'id_ticket'=>$current_id,
          'id_responsable_traitement_ticket_support'=>$responsable_traitement_ticket,
          'date_validation'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
    $as = array(
                'id'=>$true_association_validation,
                'id_ticket'=>$current_id,
                'id_comite_ticket'=>$comite_id,
                'membre_section_comite_ticket'=>$section_comite_ticket,
                'date_dispatch'=>$created->toString('yyyy-MM-dd HH:mm:ss'));

      $das = array(
        'id_ticket'=>$current_id,
        'id_comite_ticket'=>$comite_id,
        'section_comite_ticket'=>$section_comite_ticket,
        'date_dispatch'=>$created->toString('yyyy-MM-dd HH:mm:ss'));
      $db_search_select = $dbastc->select();
      $db_search_select->from('eu_association_ticket_comite')
                     ->where('id_ticket like ?',$current_id)
                     ->where('id_comite_ticket like ?',$comite_id)
                     ->where('membre_section_comite_ticket like ?',$section_comite_ticket);
      $association_find = $dbastc->fetchAll($db_search_select);


    if($dbvt->insert($vt) && $dbts->update($ts,array('id_ticket like ?'=>$current_id))){
      Util_Utils::sendprivateinternemail($email_comite_ticket,$section_comite_ticket);
      if(count($association_find) > 0){
        $dbastc->update($das,array('id like ?'=>$association_find[0]['id']));
      }else{
         $dbastc->insert($as);
      }

            $resultjson = array(
              'update'=>'Dispatch effectue avec success'
            );
    }
            header('Content-type:application/json');
            die(json_encode($resultjson));

  }



}
