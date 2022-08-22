<?php


namespace App\Controller;

class Controller
{
    protected string $rootPath;

    protected array $errors = [];


    public function __construct($rootPath)
    {
        $this->rootPath = $rootPath;
    }

    public function init()
    {

        try {
            if (isset($_GET['controller'])) {
                if ($_GET['controller'] === 'client') {
                    $clientController = new ClientController($this->rootPath);
                    $clientController->init();

                } elseif ($_GET['controller'] === 'invoice') {
                    $clientController = new InvoiceController($this->rootPath);
                    $clientController->init();
                } else {
                    throw new \Exception("Le controleur n'existe pas");
                }

            } else {
                $homeController = new HomeController($this->rootPath);
                $homeController->init();
            }
        } catch (\Exception $e) {
            $this->render('templates/error', [
                'message' => $e->getMessage()
            ]);
            return;
        }

    }


    protected function render(string $path, array $params = []):void
    {
        $filePath = $this->rootPath.'/'.$path.'.php';
        try {
            if (!file_exists($filePath))
                throw new \Exception ('Fichier non trouvé : '.$filePath);
            else {
                ob_start();
                extract($params);
                $content = ob_get_clean();
                require($filePath);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @return array
     */
    protected function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    protected function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    protected function pushErrors($key, $message): void
    {
        $this->errors[$key] = $message;
    }

}