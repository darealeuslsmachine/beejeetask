<?php


class IndexController extends Controller {

    private $pageTpl = '/views/main.tpl.php';

    public function __construct() {

        $this->model = new IndexModel();
        $this->view = new View();

    }

    public function index() {

        $this->pageData['title'] = "Log in";

        if(!empty($_POST)) {

            if(!$this->login()) {

                $this->pageData['error'] = "Invalid username or password";

            }

        }

        $this->view->render($this->pageTpl, $this->pageData);

    }

    private function login() {

        if(!$this->model->checkUser()) {

            return false;

        }
    }
}
