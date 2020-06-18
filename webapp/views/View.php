<?php


class View {

    public function render($tpl, $pageData) {

        $include_url = str_replace(' ', '', ROOT. $tpl);
        include $include_url;

    }

}