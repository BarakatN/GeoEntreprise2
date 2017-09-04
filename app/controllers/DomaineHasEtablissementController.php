<?php
 
 namespace GeoEntreprise\Controllers;

use GeoEntreprise\Models\DomaineHasEtablissement ;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class DomaineHasEtablissementController extends ControllerBase
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
     * Searches for domaine_has_etablissement
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'GeoEntreprise\Models\DomaineHasEtablissement', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "domaine_id_domaine";

        $domaine_has_etablissement = DomaineHasEtablissement::find($parameters);
        if (count($domaine_has_etablissement) == 0) {
            $this->flash->notice("The search did not find any domaine_has_etablissement");

            $this->dispatcher->forward([
                "controller" => "domaine_has_etablissement",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $domaine_has_etablissement,
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
     * Edits a domaine_has_etablissement
     *
     * @param string $domaine_id_domaine
     */
    public function editAction($domaine_id_domaine)
    {
        if (!$this->request->isPost()) {

            $domaine_has_etablissement = DomaineHasEtablissement::findFirstBydomaine_id_domaine($domaine_id_domaine);
            if (!$domaine_has_etablissement) {
                $this->flash->error("domaine_has_etablissement was not found");

                $this->dispatcher->forward([
                    'controller' => "domaine_has_etablissement",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->domaine_id_domaine = $domaine_has_etablissement->domaine_id_domaine;

            $this->tag->setDefault("domaine_id_domaine", $domaine_has_etablissement->domaine_id_domaine);
            $this->tag->setDefault("etablissement_id_etab", $domaine_has_etablissement->etablissement_id_etab);
            
        }
    }

    /**
     * Creates a new domaine_has_etablissement
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "domaine_has_etablissement",
                'action' => 'index'
            ]);

            return;
        }

        $domaine_has_etablissement = new DomaineHasEtablissement();
        $domaine_has_etablissement->domaine_id_domaine = $this->request->getPost("domaine_id_domaine");
        $domaine_has_etablissement->etablissement_id_etab = $this->request->getPost("etablissement_id_etab");
        

        if (!$domaine_has_etablissement->save()) {
            foreach ($domaine_has_etablissement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "domaine_has_etablissement",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("domaine_has_etablissement was created successfully");

        $this->dispatcher->forward([
            'controller' => "domaine_has_etablissement",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a domaine_has_etablissement edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "domaine_has_etablissement",
                'action' => 'index'
            ]);

            return;
        }

        $domaine_id_domaine = $this->request->getPost("domaine_id_domaine");
        $domaine_has_etablissement = DomaineHasEtablissement::findFirstBydomaine_id_domaine($domaine_id_domaine);

        if (!$domaine_has_etablissement) {
            $this->flash->error("domaine_has_etablissement does not exist " . $domaine_id_domaine);

            $this->dispatcher->forward([
                'controller' => "domaine_has_etablissement",
                'action' => 'index'
            ]);

            return;
        }

        $domaine_has_etablissement->domaine_id_domaine = $this->request->getPost("domaine_id_domaine");
        $domaine_has_etablissement->etablissement_id_etab = $this->request->getPost("etablissement_id_etab");
        

        if (!$domaine_has_etablissement->save()) {

            foreach ($domaine_has_etablissement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "domaine_has_etablissement",
                'action' => 'edit',
                'params' => [$domaine_has_etablissement->domaine_id_domaine]
            ]);

            return;
        }

        $this->flash->success("domaine_has_etablissement was updated successfully");

        $this->dispatcher->forward([
            'controller' => "domaine_has_etablissement",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a domaine_has_etablissement
     *
     * @param string $domaine_id_domaine
     */
    public function deleteAction($domaine_id_domaine)
    {
        $domaine_has_etablissement = DomaineHasEtablissement::findFirstBydomaine_id_domaine($domaine_id_domaine);
        if (!$domaine_has_etablissement) {
            $this->flash->error("domaine_has_etablissement was not found");

            $this->dispatcher->forward([
                'controller' => "domaine_has_etablissement",
                'action' => 'index'
            ]);

            return;
        }

        if (!$domaine_has_etablissement->delete()) {

            foreach ($domaine_has_etablissement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "domaine_has_etablissement",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("domaine_has_etablissement was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "domaine_has_etablissement",
            'action' => "index"
        ]);
    }

}
