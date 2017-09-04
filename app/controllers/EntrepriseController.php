<?php
namespace GeoEntreprise\Controllers;

use GeoEntreprise\Models\Entreprise;

use GeoEntreprise\Models\DomaineHasEntreprise;
use GeoEntreprise\Models\Domaine;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class EntrepriseController extends ControllerBase
{
    /**
     * Index action
     */
     public function initialize()
     {
              if($this->session->has('auth-identity'))
            {
                
                $this->view->setlayout('private');
            }
        
         else 
           { $this->dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index'
                ));}
     }
    public function indexAction()
    {
        $this->persistent->parameters = null;

    }

    /**
     * Searches for entreprise
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'GeoEntreprise\Models\Entreprise', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id_entreprise";

        $entreprise = Entreprise::find($parameters);
        if (count($entreprise) == 0) {
            $this->flash->notice("The search did not find any entreprise");

            $this->dispatcher->forward([
                "controller" => "entreprise",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $entreprise,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a entreprise
     *
     * @param string $id_entreprise
     */
    public function editAction($id_entreprise)
    {

        if (!$this->request->isPost()) {

            $entreprise = Entreprise::findFirstByid_entreprise($id_entreprise);
            if (!$entreprise) {
                $this->flash->error("entreprise was not found");

                $this->dispatcher->forward([
                    'controller' => "entreprise",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id_entreprise = $entreprise->id_entreprise;

            $this->tag->setDefault("id_entreprise", $entreprise->id_entreprise);
            $this->tag->setDefault("nom", $entreprise->nom);
            $this->tag->setDefault("siren", $entreprise->siren);
            $this->tag->setDefault("adresse", $entreprise->adresse);
            $this->tag->setDefault("denomination", $entreprise->denomination);
            $this->tag->setDefault("ville", $entreprise->ville);
            $this->tag->setDefault("code_postal", $entreprise->code_postal);
            $this->tag->setDefault("capital_social", $entreprise->capital_social);
            $this->tag->setDefault("forme_juridique", $entreprise->forme_juridique);
            $this->tag->setDefault("CA", $entreprise->CA);
            $this->tag->setDefault("date_creation", $entreprise->date_creation);
            $this->tag->setDefault("rayonnement", $entreprise->rayonnement);
            // modifier le domaine de l'entreprise
       

        }
    }

    /**
     * Creates a new entreprise
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'index'
            ]);

            return;
        }

        $entreprise = new Entreprise();
        $entreprise->nom = $this->request->getPost("nom");
        $entreprise->siren = $this->request->getPost("siren");
        $entreprise->adresse = $this->request->getPost("adresse");
        $entreprise->denomination = $this->request->getPost("denomination");
        $entreprise->ville = $this->request->getPost("ville");
        $entreprise->code_postal = $this->request->getPost("code_postal");
        $entreprise->capital_social = $this->request->getPost("capital_social");
        $entreprise->forme_juridique = $this->request->getPost("forme_juridique");
        $entreprise->CA = $this->request->getPost("CA");
        $entreprise->date_creation = $this->request->getPost("date_creation");
        $entreprise->rayonnement = $this->request->getPost("rayonnement");


        if (!$entreprise->save()) {
                
            foreach ($entreprise->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'new'
            ]);

            return;
        }  
             
           

        $this->flash->success("entreprise was created successfully");
           // enregistrer le domaine - entreprise dans la table DomaineHasEntreprise
          foreach ($this->request->getPost("domaines") as $key => $value) {
                $d_e=new DomaineHasEntreprise() ;
                
                $d_e->entreprise_id_entreprise=$entreprise->id_entreprise ;
                   $d_e->domaine_id_domaine=$value ;
                   if(!$d_e->save()) 
                   { foreach ($d_e->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'new'
            ]);

            return;}
            }
          
  

        $this->dispatcher->forward([
            'controller' => "entreprise",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a entreprise edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'index'
            ]);

            return;
        }

        $id_entreprise = $this->request->getPost("id_entreprise");
        $entreprise = Entreprise::findFirstByid_entreprise($id_entreprise);

        if (!$entreprise) {
            $this->flash->error("entreprise does not exist " . $id_entreprise);

            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'index'
            ]);

            return;
        }

        $entreprise->nom = $this->request->getPost("nom");
        $entreprise->siren = $this->request->getPost("siren");
        $entreprise->adresse = $this->request->getPost("adresse");
        $entreprise->denomination = $this->request->getPost("denomination");
        $entreprise->ville = $this->request->getPost("ville");
        $entreprise->code_postal = $this->request->getPost("code_postal");
        $entreprise->capital_social = $this->request->getPost("capital_social");
        $entreprise->forme_juridique = $this->request->getPost("forme_juridique");
        $entreprise->CA = $this->request->getPost("CA");
        $entreprise->date_creation = $this->request->getPost("date_creation");
        $entreprise->rayonnement = $this->request->getPost("rayonnement");

      $de=DomaineHasEntreprise::findByentreprise_id_entreprise($id_entreprise);
                     
         foreach ($de as $d) {
             $d->delete() ;
         }
                   
                  foreach($this->request->getPost("domaines") as $key => $value) {
                $d_e=new DomaineHasEntreprise() ;
                
                $d_e->entreprise_id_entreprise=$id_entreprise ;
                   $d_e->domaine_id_domaine=$value ;
                   if(!$d_e->save()) 
                   { foreach ($d_e->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'index'
            ]);

            return;
            
        }
            }
        if (!$entreprise->save()) {
            
            foreach ($entreprise->getMessages() as $message) {
                $this->flash->error($message);
            }
       
            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'edit',
                'params' => [$entreprise->id]
            ]);

            return;
        }


        $this->flash->success("entreprise was updated successfully");

        $this->dispatcher->forward([
            'controller' => "entreprise",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a entreprise
     *
     * @param string $id_entreprise
     */
    public function deleteAction($id_entreprise)
    {

        $entreprise = Entreprise::findFirstByid_entreprise($id_entreprise);
        if (!$entreprise) {
            $this->flash->error("entreprise was not found");

            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'index'
            ]);

            return;
        }


        if (!$entreprise->delete()) {

            foreach ($entreprise->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "entreprise",
                'action' => 'search'
            ]);

            return;
        }
     


        $this->flash->success("entreprise was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "entreprise",
            'action' => "index"
        ]);
    }


}
