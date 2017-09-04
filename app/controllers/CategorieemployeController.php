<?php
 namespace GeoEntreprise\Controllers  ; 

use GeoEntreprise\Models\Categorieemploye ; 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CategorieemployeController extends ControllerBase
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
     * Searches for categorieemploye
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'GeoEntreprise\Models\Categorieemploye', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id_categ";

        $categorieemploye = Categorieemploye::find($parameters);
        if (count($categorieemploye) == 0) {
            $this->flash->notice("The search did not find any categorieemploye");

            $this->dispatcher->forward([
                "controller" => "categorieemploye",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $categorieemploye,
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
     * Edits a categorieemploye
     *
     * @param string $id
     */
    public function editAction($id_categ)
    {
        if (!$this->request->isPost()) {

            $categorieemploye = Categorieemploye::findFirstByid($id_categ);
            if (!$categorieemploye) {
                $this->flash->error("categorieemploye was not found");

                $this->dispatcher->forward([
                    'controller' => "categorieemploye",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $categorieemploye->id;

            $this->tag->setDefault("id", $categorieemploye->id_categ);
            $this->tag->setDefault("type", $categorieemploye->type);
            $this->tag->setDefault("salaire", $categorieemploye->salaire);
            $this->tag->setDefault("nbr", $categorieemploye->nbr);
            $this->tag->setDefault("nbr_heure", $categorieemploye->nbr_heure);
            $this->tag->setDefault("entreprise_id", $categorieemploye->entreprise_id_entreprise);
            
        }
    }

    /**
     * Creates a new categorieemploye
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "categorieemploye",
                'action' => 'index'
            ]);

            return;
        }

        $categorieemploye = new Categorieemploye();
        $categorieemploye->type = $this->request->getPost("type");
        $categorieemploye->salaire = $this->request->getPost("salaire");
        $categorieemploye->nbr = $this->request->getPost("nbr");
        $categorieemploye->nbr_heure = $this->request->getPost("nbr_heure");
        $categorieemploye->entreprise_id = $this->request->getPost("entreprise_id_entreprise");
        

        if (!$categorieemploye->save()) {
            foreach ($categorieemploye->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categorieemploye",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("categorieemploye was created successfully");

        $this->dispatcher->forward([
            'controller' => "categorieemploye",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a categorieemploye edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "categorieemploye",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id_categ");
        $categorieemploye = Categorieemploye::findFirstByid($id_categ);

        if (!$categorieemploye) {
            $this->flash->error("categorieemploye does not exist " . $id_categ);

            $this->dispatcher->forward([
                'controller' => "categorieemploye",
                'action' => 'index'
            ]);

            return;
        }

        $categorieemploye->type = $this->request->getPost("type");
        $categorieemploye->salaire = $this->request->getPost("salaire");
        $categorieemploye->nbr = $this->request->getPost("nbr");
        $categorieemploye->nbr_heure = $this->request->getPost("nbr_heure");
        $categorieemploye->entreprise_id = $this->request->getPost("entreprise_id_entreprise");
        

        if (!$categorieemploye->save()) {

            foreach ($categorieemploye->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categorieemploye",
                'action' => 'edit',
                'params' => [$categorieemploye->id_categ]
            ]);

            return;
        }

        $this->flash->success("categorieemploye was updated successfully");

        $this->dispatcher->forward([
            'controller' => "categorieemploye",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a categorieemploye
     *
     * @param string $id
     */
    public function deleteAction($id_categ)
    {
        $categorieemploye = Categorieemploye::findFirstByid($id_categ);
        if (!$categorieemploye) {
            $this->flash->error("categorieemploye was not found");

            $this->dispatcher->forward([
                'controller' => "categorieemploye",
                'action' => 'index'
            ]);

            return;
        }

        if (!$categorieemploye->delete()) {

            foreach ($categorieemploye->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categorieemploye",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("categorieemploye was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "categorieemploye",
            'action' => "index"
        ]);
    }

}
