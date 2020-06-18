<?php


class HomeModel extends Model {

    public function getTasksCount() {

        $sql = "SELECT COUNT(*) FROM tasks";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchColumn();

        return $res;

    }


    //Getting all tasks
    public function getTasks() {

        $sql = "SELECT
                    tasks.id,
                    tasks.text,
                    tasks.username,
                    tasks.email,
                    tasks.status,
                    tasks.updatewadmin
                FROM tasks
               
        ";

        $result = array();
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $result[$row['id']] = $row;

        }

        return $result;

    }


    //Getting max tasks id
    public function getTasksMaxId() {

        $sql = "SELECT id FROM tasks ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchColumn();

        return $res;

    }


    //Sort tasks
    public function arrMultisort($array,$field) {

        $sortArr = array();
        foreach($array as $key=>$val){
            $sortArr[$key] = $val[$field];
        }

        array_multisort($sortArr, $array);

        return $array;

    }

    public function arrMultisortDesc($array,$field) {

        $sortArr = array();
        foreach($array as $key=>$val){

            $sortArr[$key] = $val[$field];
        }

        array_multisort($sortArr, SORT_DESC, $array);

        return $array;

    }

    public function sortTasks($arrTasks) {

        if (@$_GET['sortparam2'] == "Ascending") {

            switch ($_GET['sortparam1']) {

                case "Username": $arrTasks = $this->arrMultisort($arrTasks, 'username'); break;
                case "Email": $arrTasks = $this->arrMultisort($arrTasks, 'email'); break;
                case "Status": $arrTasks = $this->arrMultisortDesc($arrTasks, 'status'); break;

            }

        } elseif (@$_GET['sortparam2'] == "Descending") {

            switch ($_GET['sortparam1']) {

                case "Username": $arrTasks = $this->arrMultisortDesc($arrTasks, 'username'); break;
                case "Email": $arrTasks = $this->arrMultisortDesc($arrTasks, 'email'); break;
                case "Status": $arrTasks = $this->arrMultisort($arrTasks, 'status'); break;

            }
        }

        return $arrTasks;

    }


    public function searchTasks($arrTasks) {

        if (isset($_POST['searchstr'])) {

            $searchquery = $_POST['searchstr'];
            $arrcount = count($arrTasks);

            foreach ($arrTasks as $id) {

                if (array_search($searchquery, $id) == false) {

                    unset($arrTasks[$id['id']]);

                }
            }
        }

        return $arrTasks;

    }
}