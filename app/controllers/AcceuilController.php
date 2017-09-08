<?php

namespace GeoEntreprise\Controllers;
use GeoEntreprise\Models\Etablissement ;
use GeoEntreprise\Models\Departement ;
use GeoEntreprise\Models\Domaine ;
use GeoEntreprise\Models\Entreprise ;
use Phalcon\Mvc\Model\Query;
 use GeoEntreprise\Models\DomaineHasEtablissement  ;
class AcceuilController extends ControllerBase
{

    public function indexAction()
    {
          
      

        $this->view->pick('acceuil/acceuil');
    }

  public function allAction()
    {
          
        $temp = array();
        $etablissements=Etablissement::find();
        foreach ($etablissements as $a) {
                    $temp[]=$a   ; 
                        }
       
           $this->view->disable();
   echo json_encode($temp);

        
    }
 

       public function search_by_domaineAction()
    {

        $id = $_POST["id"];
        
        $domaine_etabs = DomaineHasEtablissement::findBydomaine_id_domaine($id);
 
 $temp = array();
        foreach ($domaine_etabs as $d) {
     
        $e=Etablissement::findFirst($d->etablissement_id_etab);
    
   $temp[]=$e ;
    


}
        

     $this->view->disable();
   echo json_encode($temp);
       

      

}  

public function search_by_entrepriseAction()
    {

        $id = $_POST["id"];
        
        $etabs =Etablissement::findByentreprise_id_entreprise($id);
 
 $temp = array();
        foreach ($etabs as $d) {
     
       
    
   $temp[]=$d ;
    


}
        

     $this->view->disable();
   echo json_encode($temp);
       

      

}  

public function search_domaine_entrepriseAction()
    {

        $id = $_POST["id"];//entreprise
          $id2 = $_POST["id2"]; //domaine
        
        $etabs =Etablissement::findByentreprise_id_entreprise($id);
      $domaine_etabs = DomaineHasEtablissement::findBydomaine_id_domaine($id2);

 $temp = array();

        foreach ($etabs as $d) {
     
       
    foreach ($domaine_etabs as $de ) {
      
     if($d->id_etab == $de->etablissement_id_etab)

     {$temp[]=$d ;
    
          break; }

    }
   
    


}     

     $this->view->disable();
   echo json_encode($temp);
}  

public function search_by_departAction()
    {

        $l = $_POST["id"];//libelle
       
        
        $depart =Departement::findBylibelle($l);
      

 $temp = array();
        foreach ($depart as $d) {
     
            $etab=Etablissement::findFirstByid_etab($d->etablissement_id_etab) ; 
     $temp[]=$etab ; 
    


}     

     $this->view->disable();
   echo json_encode($temp);
       

      

}  

public function search_depart_entrepriseAction()
    {

        $id = $_POST["id"];  // entreprise
        $id2 = $_POST["id2"];// departement 
        
        $etabs =Etablissement::findByentreprise_id_entreprise($id);
        


 $temp = array();
      foreach ($etabs as $d) {
     
       
     $departs=Departement::query()
    ->where("libelle = :l:")
    ->andWhere("etablissement_id_etab = :etab:")
    ->bind(["l" => $id2,
             "etab" => $d->id_etab ])
    ->execute();
   
    if(count($departs)>0)
       $temp[]=$d ; 


} 
        

     $this->view->disable();
   echo json_encode($temp);
       

      

}  
public function search_depart_domaineAction()
    {

        $id = $_POST["id"];  // domaine
        $id2 = $_POST["id2"];// departement 
        
        $domaine_etabs = DomaineHasEtablissement::findBydomaine_id_domaine($id);
 
$temp = array();
        foreach ($domaine_etabs as $d) {
 
     $departs=Departement::query()
    ->where("libelle = :l:")
    ->andWhere("etablissement_id_etab = :etab:")
    ->bind(["l" => $id2,
             "etab" => $d->etablissement_id_etab ])
    ->execute();
   
    if(count($departs)>0)
      {

          $e=Etablissement::findFirst($d->etablissement_id_etab);
        $temp[]=$e; 

        }
} 
        

     $this->view->disable();
   echo json_encode($temp);
       

 }


 public function search_by_allAction()
    {

        $id = $_POST["id"];//entreprise
          $id2 = $_POST["id2"]; //domaine
          $id3 = $_POST["id3"]; //departement
        
        $etabs =Etablissement::findByentreprise_id_entreprise($id);
      $domaine_etabs = DomaineHasEtablissement::findBydomaine_id_domaine($id2);

 $temp = array();

        foreach ($etabs as $d) {
     
       
    foreach ($domaine_etabs as $de ) 
        {
      
     if($d->id_etab == $de->etablissement_id_etab)

     {
           
                $departs=Departement::query()
    ->where("libelle = :l:")
    ->andWhere("etablissement_id_etab = :etab:")
    ->bind(["l" => $id3,
             "etab" => $d->id_etab ])
    ->execute();
   
    if(count($departs)>0)

      $temp[]=$d ;
    
          break; }

    

        }
   
    


}     

     $this->view->disable();
   echo json_encode($temp);
}  




    public function getInfoAction()
    {
       $id = $_POST["id"];
        $temp= array() ;
            foreach ($id as $t) {
              

                  $entreprise=Entreprise::findFirstByid_entreprise($t) ; 

    
                    $temp[]=$entreprise ;
            }
    

      $this->view->disable();
   echo json_encode($temp);


    }
      public function localiserAction()
    {
       
   $this->view->pick('acceuil/localiser');

    }
       public function contactAction()
    {
       
   $this->view->pick('acceuil/contact');

    }

         public function submitAction()
    {
       
      $this->view->disable();


   echo "done";

    }



}
