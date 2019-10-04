<?php

require_once(ROOT . 'library/smarty-3.1.33/libs/Smarty.class.php');

class View extends Smarty {

    public $maintpl = "main";
    public $si_ajax;
    public $aJS;
    public $show_fotter;
    public $cache_time;

    function __construct() {
        parent::__construct();

        $this->debugging = 0;
        $this->caching = 0;
        $this->compile_check = 1;
        $this->si_ajax = false;
        if (isset($_POST['ajax']) && $_POST['ajax'] == "1") {
            $this->si_ajax = true;
        }

        if (isset($_GET['ajax']) && $_GET['ajax'] == "1") {
            $this->si_ajax = true;
        }
        
        //echo ROOT;
        $this->cache_time = 0;
        $this->template_dir = ROOT . 'View/templates/';
        $this->compile_dir = ROOT . 'View/templates_c/';
        $this->config_dir = ROOT . 'View/configs/';
        $this->cache_dir = ROOT . 'View/cache/';
        $this->aJS = array(
            "JS_SERVERTIME" => time() * 1000,
            "SERVER_NAME"   => BASE_URL,
            "SERVER_PUBLIC" => SERVER_NAME."Public/",
            "BASE_URL" => BASE_URL,
        );
        $this->show_fotter = true;
        $this->assign("SERVER_NAME", SERVER_NAME);
        $this->assign("BASE_URL", BASE_URL);
        $this->assign("SERVER_PUBLIC", SERVER_NAME . 'Public/');
        $this->assign("menu","");
        $this->assign("title","");
        $this->assign("descripcion","");
        $this->assign("listaCiudad",array());
        $this->assign("edit_ruta",0);
        $this->assign("asignar_tt_nrovuelo",0);
        $this->assign("JS","");
        $this->assign("NAME_USER",'');
        $this->assign("permiso",'');
    }

    function show404page() {
        $this->maintpl = "mainx";
        $this->display("404.tpl");
    }

    function display_web() {
        if ($this->si_ajax == false) {
            $aJSTxt = "";
            foreach ($this->aJS as $idVar => $valueVar) {
                if (is_string($valueVar)) {
                    $aJSTxt.='var ' . $idVar . '="' . $valueVar . '"; ';
                } else {
                    $aJSTxt.='var ' . $idVar . '=' . $valueVar . "; ";
                }
            }
            $this->assign("aJSTxt", $aJSTxt);
            $this->caching = 0;
            $this->include_template("content_head", "inc/head");
            if ($this->show_fotter) {
                $this->include_template("content_footer", "inc/footer");
            }
            $this->include_template("content_footer_js", "inc/js");

            $this->display($this->maintpl . '.tpl');
        }
    }

    function show_page($page_html, $cache_id = "") {

        if ($this->si_ajax) {
            $this->resp_json($page_html);
        } else {
            $html = $this->fetch($page_html, $cache_id);
            $this->assign("content_main", $html);
        }

        $this->display_web();
    }

    function include_template($var, $template, $cache_id = "") {
        $html = $this->fetch($template . ".tpl", $cache_id);
        $this->assign($var, $html);
    }

    function resp_json($aVars) {
        if (is_array($aVars)) {
            foreach ($aVars as $aVars_id => $aVars_val) {
                $aVars[$aVars_id] = $this->limpiarHtml($aVars_val);
            }
        } else {
            $aVars["html"] = $this->limpiarHtml($aVars);
        }
        echo json_encode($aVars);
        exit;
    }

    function limpiarHtml($html) {
        $busca = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $reemplaza = array('>', '<', '\\1');
        $html = str_replace("´", "", $html);
        return preg_replace($busca, $reemplaza, $html);
    }

}

?>