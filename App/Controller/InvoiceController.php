<?php


namespace App\Controller;

use App\Entity\Client;
use App\Entity\Invoice;
use App\Repository\ClientRepository;
use App\Repository\InvoiceRepository;

class InvoiceController extends Controller
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
        $invoice = null;
        try {
            if (isset($_GET['id'])) {
                $invoiceRepository = new InvoiceRepository();
                /* @var $invoice \App\Entity\Invoice */
                $invoice = $invoiceRepository->findOneById($_GET['id']);

                $clientRepository = new ClientRepository();

                $client = $clientRepository->findOneById($invoice->getClientId());
                $invoice->setClient($client);
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

        $this->render('templates/invoice/show', [
            'invoice' => $invoice
        ]);
    }

    public function list():void
    {

        $invoiceRepository = new InvoiceRepository();
        $invoices = $invoiceRepository->findAll();


        $this->render('templates/invoice/list', [
            'invoices' => $invoices
        ]);
    }

    public function new():void
    {
        $invoice = new Invoice();
        $message = null;
        $errors = [];

        $clientRepository = new ClientRepository();
        $clients = $clientRepository->findAll();
        if (!$clients) {
            $this->render('templates/error', [
                'message' => 'Vous devez ajouter au moins un client avant d\'ajouter une facture'
            ]);
        } else {
            if (!empty($_POST) && isset($_POST['submitNewInvoice'])) {
                $invoice = $this->validatePostInvoice($invoice);
                $errors = $this->getErrors();

                if (!sizeof($errors)) {
                    //insertion
                    $invoiceRepository = new InvoiceRepository();
                    if ($invoiceRepository->persist($invoice)) {
                        $invoice = new Invoice();
                        $message = 'La facture a bien été ajoutée';
                    } else {
                        $message = 'Erreur lors de l\'enregistrement ';
                    }
                }
            }

            $this->render('templates/invoice/new', [
                'invoice' => $invoice,
                'errors' => $errors,
                'message' => $message,
                'clients' => $clients
            ]);
        }


    }

    public function edit():void
    {
        $invoice = null;
        $message = null;
        $errors = [];
        $errorGlobal = null;

        $clientRepository = new ClientRepository();
        $clients = $clientRepository->findAll();

        try {
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $invoiceRepository = new InvoiceRepository();
                /* @var $invoice \App\Entity\Invoice */
                $invoice = $invoiceRepository->findOneById((int)$_GET['id']);
                if ($invoice) {
                    if (!empty($_POST) && isset($_POST['submitEditInvoice'])) {
                        $invoice = $this->validatePostInvoice($invoice);
                        $errors = $this->getErrors();
                        if (!sizeof($errors)) {
                            //insertion
                            $invoiceRepository = new InvoiceRepository();
                            $res = $invoiceRepository->persist($invoice, $update = true);
                            if ($res) {
                                $message = 'Le invoice a bien été modifié';
                            } else {
                                $errorGlobal = 'Erreur lors de l\'enregistrement';
                            }
                        }
                    }
                    $this->render('templates/invoice/edit', [
                        'invoice' => $invoice,
                        'clients' => $clients,
                        'errors' => $errors,
                        'message' => $message,
                    ]);
                } else {
                    $errorGlobal = 'Cette facture n\'existe pas';
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
                $invoiceRepository = new InvoiceRepository();
                /* @var $invoice \App\Entity\Invoice */

                $res = $invoiceRepository->removeById((int)$_GET['id']);
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
     * Validate the form data and set the data into the invoice object
     *
     * @param Invoice $invoice
     * @return Invoice
     */
    private function validatePostInvoice(Invoice  $invoice):Invoice
    {
        $this->setErrors([]);
        if (!empty($_POST) && (isset($_POST['submitNewInvoice']) || isset($_POST['submitEditInvoice']))) {
            if (isset($_POST['title']) && $_POST['title'] != '') {
                $invoice->setTitle(strip_tags($_POST['title']));
            } else {
                $this->pushErrors('title', 'Le champ titre est requis');
            }
            if (isset($_POST['total_tax_excl']) && $_POST['total_tax_excl'] != '') {
                if (is_numeric($_POST['total_tax_excl'])) {
                    $invoice->setTotalTaxExcl($_POST['total_tax_excl']);
                } else {
                    $this->pushErrors('total_tax_excl', 'Nombre uniquement');
                }
            } else {
                $this->pushErrors('total_tax_excl', 'Le champ total HT est requis');
            }
            if (isset($_POST['tax_rate']) && $_POST['tax_rate'] != '') {
                if (is_numeric($_POST['tax_rate'])) {
                    $invoice->setTaxRate($_POST['tax_rate']);
                } else {
                    $this->pushErrors('tax_rate', 'Nombre uniquement');
                }
            } else {
                $this->pushErrors('tax_rate', 'Le champ taux TVA est requis');
            }
            if (isset($_POST['date']) && $_POST['date'] != '') {
                $dateCheck = \DateTime::createFromFormat('Y-m-d', $_POST['date']);
                if ($dateCheck && $dateCheck->format('Y-m-d') === $_POST['date']) {
                    $invoice->setDate($dateCheck);
                } else {
                    $this->pushErrors('date', 'Date incorrecte');
                }
            } else {
                $this->pushErrors('date', 'Le champ date est requis');
            }

            if (isset($_POST['client_id']) && $_POST['client_id'] != '') {
                if (is_numeric($_POST['client_id'])) {
                    $clientRepository = new ClientRepository();
                    $client = $clientRepository->findOneById($_POST['client_id']);
                    if ($client) {
                        $invoice->setClientId($_POST['client_id']);
                    } else {
                        $this->pushErrors('client_id', 'Client invalide');
                    }

                } else {
                    $this->pushErrors('client_id', 'Client invalide');
                }
            }



        }
        return $invoice;
    }
}