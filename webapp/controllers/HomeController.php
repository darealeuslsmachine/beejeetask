<?php


class HomeController extends Controller {

    private $pageTpl = "/views/home.tpl.php";
    private $tasksPerPages = 3;

    public function __construct() {

        $this->model = new HomeModel();
        $this->view = new View();
        $this->utils = new Utils();
        $this->db = DB::connToDB();

    }

    public function index() {

        $this->pageData['title'] = "Home";
        $this->pageData['unwantedcharacters'] = array(">","<","script", "{", "}");

        $tasksCount = $this->model->getTasksCount();
        $this->pageData['tasksCount'] = $tasksCount;

        $tasks = $this->model->getTasks();
        $this->pageData['tasks'] = $tasks;
        $this->pageData['tasks'] = $this->model->sortTasks($this->pageData['tasks']);
        $this->pageData['tasks'] = $this->model->searchTasks($this->pageData['tasks']);

        $allTasks = count($this->model->getTasks());
        $totalPages = ceil($allTasks / $this->tasksPerPages);
        $this->makeTasksPager($allTasks, $totalPages);

        @$pagination = $this->utils->drawPager($tasksCount, $this->tasksPerPages, $_GET['sortparam1'], $_GET['sortparam2']);
        $this->pageData['pagination'] = $pagination;
        $this->utils->errorAuthorization();

        $this->view->render($this->pageTpl, $this->pageData);

    }

    public function save() {

        if (isset($_SESSION['user'])) {

            for ($id = 0; $id <= $this->model->getTasksMaxId(); $id++) {

                $btnName = "changetext" . $id;
                $checkboxname = "checkbox" . $id;
                if (isset($_POST["$btnName"])) {

                    $text = $_POST[$btnName];

                    if ($_POST[$checkboxname] == 'on') {

                        $status = 'DONE';

                    } else {

                        $status = null;

                    }

                    $originaltasks = $this->model->getTasks();
                    $originaltext = $originaltasks[$id]['text'];

                    if ($text !== $originaltext) {

                        $updatewadmin = 'Edited by admin';

                    } else {

                        $updatewadmin = null;

                    }

                    $unwantedcharacters = array(">","<","script", "{", "}");
                    $text = str_replace($unwantedcharacters, "", $text);

                    $sql = "UPDATE tasks
                            SET text = :text,
                            status = :status,
                            updatewadmin = :updatewadmin
                            WHERE id= :id
                           ";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindValue("text", $text, PDO::PARAM_STR);
                    $stmt->bindValue("status", $status, PDO::PARAM_STR);
                    $stmt->bindValue("updatewadmin", $updatewadmin, PDO::PARAM_STR);
                    $stmt->bindValue("id", $id, PDO::PARAM_INT);
                    $stmt->execute();

                    header("Location: /webapp/home");

                }
            }
        } else {

            header("Location: /webapp/home?error=error");

        }
    }

    public function newtask() {

        if (!empty($_POST['addusername']) && !empty($_POST['addemail']) && !empty($_POST['addtext']) && (filter_var($_POST['addemail'], FILTER_VALIDATE_EMAIL))) {

            $username = $_POST['addusername'];
            $email = $_POST['addemail'];
            $text = $_POST['addtext'];

            $unwantedcharacters = array(">","<","script", "{", "}");
            $username = str_replace($unwantedcharacters, "", $username);
            $text = str_replace($unwantedcharacters, "", $text);

            $sql = "INSERT INTO tasks
                        SET 
                        username = :username,
                        email = :email,
                        text = :text                        
                       ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue("username", $username, PDO::PARAM_STR);
            $stmt->bindValue("email", $email, PDO::PARAM_STR);
            $stmt->bindValue("text", $text, PDO::PARAM_STR);
            $stmt->execute();

            header("Location: /webapp/home");

        } else {

            header("Location: /webapp/home");

        }
    }


    public function makeTasksPager($allTasks, $totalPages) {

        if(!isset($_GET['page']) || intval($_GET['page']) == 0 || intval($_GET['page']) == 1 || intval($_GET['page']) < 0) {

            $pageNumber = 1;
            $leftLimit = 0;
            $rightLimit = $this->tasksPerPages;

        } elseif (intval($_GET['page']) > $totalPages || intval($_GET['page']) == $totalPages) {

            $pageNumber = $totalPages;
            $leftLimit = $this->tasksPerPages * ($pageNumber - 1);
            $rightLimit = $allTasks;

        } else {

            $pageNumber = intval($_GET['page']);
            $leftLimit = $this->tasksPerPages * ($pageNumber-1);
            $rightLimit = $this->tasksPerPages;

        }

        $this->pageData['tasksOnPage'] = $this->getLimitTasksOnTP($leftLimit, $rightLimit);

    }

    public function getLimitTasksOnTP ($leftLimit, $rightLimit) {

        $result = array();
        $result = array_slice($this->pageData['tasks'], $leftLimit, $rightLimit);
        return $result;

    }

    public function logout() {

        session_destroy();
        header("Location: /webapp/home");

    }
}