<?php

class Utils {

    public function drawPager($totalTasks, $perPage,$sortparam1, $sortparam2) {

        $pages = ceil($totalTasks / $perPage);

        if (!isset($_GET['page']) || intval($_GET['page']) == 0) {

            $page = 1;

        } else if (intval($_GET['page']) > $totalTasks) {

            $page = $pages;

        } else {

            $page = intval($_GET['page']);

        }

        $pager = "<ul class=''>";
        $pager .= "<li><a href='home?page=1&sortparam1=".$sortparam1."&sortparam2=".$sortparam2."' aria-label='Previous'><span aria-hidden='true'>1</span></a></li>";
        for($i=2; $i<=$pages-1; $i++) {

            $pager .= "<li><a href='home?page=" . $i . "&sortparam1=" . $sortparam1 . "&sortparam2=" . $sortparam2 . "'>" . $i . "</a></li>";

        }
        if ($pages != 1) {
            $pager .= "<li><a href='home?page=" . $pages . "&sortparam1=" . $sortparam1 . "&sortparam2=" . $sortparam2 . "' aria-label='Next'><span aria-hidden='true'>" . $i++ . "</span></a></li>";
        }
        $pager .= "</ul>";

        return $pager;

    }

    public function errorAuthorization() {

        if (@$_GET['error'] == 'error') {
            echo "<script>alert('Log in to edit the task!');</script>";
        }

    }

}