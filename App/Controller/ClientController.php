<?php


namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;

class ClientController extends Controller
{


    public function init()
    {
        // Routing of actions
        try {
            if (isset($_GET['action'])) {
                if ($_GET['action'] === 'show') {
                    $this->show();
                } elseif($_GET['action'] === 'list') {
                    $this->list();
                } elseif($_GET['action'] === 'new') {
                    $this->new();
                } elseif($_GET['action'] === 'edit') {
                    $this->edit();
                } elseif($_GET['action'] === 'delete') {
                    $this->delete();
                } else {
                    throw new \Exception("L'action n'existe pas");
                }

            } else {
                throw new \Exception("Aucune action en paramètre");
            }
        }
        catch (\Exception $e) {
            $this->render('templates/error', [
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show()
    {
        $client = null;
        try {
            if (isset($_GET['id'])) {
                $clientRepository = new ClientRepository();

                $client = $clientRepository->findOneById($_GET['id']);
            } else {
                throw new \Exception("Paramètre d'url manquant");
            }
        }
        catch (\Exception $e) {
            $this->render('templates/error', [
                'message' => $e->getMessage()
            ]);
            return;
        }

        $this->render('templates/client/show', [
            'client' => $client
        ]);
    }

    public function list():void
    {

        $clientRepository = new ClientRepository();
        $clients = $clientRepository->findAll();


        $this->render('templates/client/list', [
            'clients' => $clients
        ]);
    }

    public function new():void
    {
        $client = new Client();
        $message = null;
        $errors = [];

        if (!empty($_POST) && isset($_POST['submitNewClient'])) {
            $client = $this->validatePostClient($client);
            $errors = $this->getErrors();

            if (!sizeof($errors)) {
                //insertion
                $clientRepository = new ClientRepository();
                if ($clientRepository->persist($client)) {
                    $client = new Client();
                    $message = 'Le client a bien été ajouté';
                } else {
                    $message = 'Erreur lors de l\'enregistrement ';
                }
            }
        }

        $this->render('templates/client/new', [
            'client' => $client,
            'errors' => $errors,
            'message' => $message
        ]);
    }

    public function edit():void
    {
        $client = null;
        $message = null;
        $errors = [];
        $errorGlobal = null;

        try {
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $clientRepository = new ClientRepository();
                /* @var $client \App\Entity\Client */
                $client = $clientRepository->findOneById((int)$_GET['id']);

                if ($client) {
                    if (!empty($_POST) && isset($_POST['submitEditClient'])) {
                        $client = $this->validatePostClient($client);
                        $errors = $this->getErrors();

                        if (!sizeof($errors)) {
                            //insertion
                            $clientRepository = new ClientRepository();
                            $res = $clientRepository->persist($client, $update = true);
                            if ($res) {
                                $message = 'Le client a bien été modifié';
                            } else {
                                $message = 'Erreur lors de l\'enregistrement ';
                            }
                        }
                    }
                    $this->render('templates/client/edit', [
                        'client' => $client,
                        'errors' => $errors,
                        'message' => $message,
                    ]);
                } else {
                    $errorGlobal = 'Ce client n\'existe pas';

                }
            } else {
                throw new \Exception("Paramètre d'url manquant");
            }
        }
        catch (\Exception $e) {
            $errorGlobal = $e->getMessage();
        }




        if ($errorGlobal) {
            $this->render('templates/error', [
                'message' => $errorGlobal
            ]);
        }
    }

    public function delete():void
    {
        $client = null;
        $message = null;
        $error = null;

        try {
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $clientRepository = new ClientRepository();
                /* @var $client \App\Entity\Client */

                $res = $clientRepository->removeById((int)$_GET['id']);
                if ($res === true) {

                } else {
                    $error = 'Aucun client supprimé';
                }

            } else {
                throw new \Exception("Paramètre d'url manquant");
            }
        }
        catch (\Exception $e) {
            $error =  $e->getMessage();
        }
        catch (\Error $e) {
            $error =  $e->getMessage();
        }

        if ($error) {
            $this->render('templates/error', [
                'message' => $error
            ]);
        } else {
            $this->list();
        }
    }

    /**
     * Validate the form data and set the data into the client object
     *
     * @param Client $client
     * @return Client
     */
    private function validatePostClient(Client $client):Client
    {
        $this->setErrors([]);
        if (!empty($_POST) && (isset($_POST['submitNewClient']) || isset($_POST['submitEditClient']))) {
            if (isset($_POST['first_name']) && $_POST['first_name'] != '') {
                $client->setFirstName(strip_tags($_POST['first_name']));
            } else {
                $this->pushErrors('first_name', 'Le champ prénom est requis');
            }
            if (isset($_POST['last_name']) && $_POST['last_name'] != '') {
                $client->setLastName(strip_tags($_POST['last_name']));
            } else {
                $this->pushErrors('last_name', 'Le champ nom est requis');
            }
            if (isset($_POST['email']) && $_POST['email'] != '') {
                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $client->setEmail(strip_tags($_POST['email']));
                } else {
                    $this->pushErrors('email', 'L\'email est incorrect');
                }

            } else {
                $this->pushErrors('email', 'Le champ email est requis');
            }
            if (isset($_POST['phone'])) {
                $client->setPhone(strip_tags($_POST['phone']));
            }
        }
        return $client;
    }
}