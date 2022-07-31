<?php

namespace pscr\apps\home;

use pscr\extensions\pscr_content\model\pscr_content;
use pscr\extensions\pscr_content\html;

/**
 * Class index
 * @package pscr\apps\home
 */
class index extends pscr_content {
    protected $content_root_div;
    protected $header_bar;
    protected $side_bar;
    protected $content_area;
    protected $footer_bar;
    protected $sections;
    protected $head;

    protected $og_url;
    protected $og_type;
    protected $og_title;
    protected $og_desc;
    protected $og_image;
    protected $og_locale;
    protected $og_appid;

    protected $meta_desc;
    protected $robots;
    protected $googlebot;

    protected $keywords;
    protected $language;
    protected $charset;
    protected $viewport;

    protected $author;

    function __construct()
    {
        parent::__construct();

        $this->initialize_main_document_elements();

        $this->initialize_meta_tags();
        $this->initialize_open_graph_tags();

        $this->generate_header_bar($this->header_bar);
        $this->generate_side_bar($this->side_bar);
    }

    function generate()
    {
        $this->generate_content_area();
    }

    function initialize_open_graph_tags() {
        $this->og_url = $this->head->meta()
                      ->property("og:url")
                      ->content("https:///pscrdemo.herokuapp.com");

        $this->og_type = $this->head->meta()
                       ->property("og:type")
                       ->content("website");

        $this->og_title = $this->head->meta()
                        ->property("og:title")
                        ->content("PSCR Default Install Page");

        $this->og_desc = $this->head->meta()
                       ->property("og:description")
                       ->content("Progressive Solutions Content Renderer");
    }

    function initialize_meta_tags() {
        $this->meta_desc = $this->head->meta()
                         ->name("description")
                         ->content("https://pscrdemo.herokuapp.com");

        $this->robots = $this->head->meta()
                      ->name('robots')
                      ->content('index, follow');

        $this->googlebot = $this->head->meta()
                         ->name('googlebot')
                         ->content('index, follow');


        $this->keywords = $this->head->meta()
                        ->name("keywords")
                        ->content("Progressive Solutions Content Renderer");

        $this->language = $this->head->meta()
                        ->name("language")
                        ->content("english");

        $this->charset = $this->head->meta()
                       ->name("charset")
                       ->content("UTF-8");

        $this->viewport = $this->head->meta()
                        ->name("viewport")
                        ->content("width=device-width, initial-scale=1.0");

        $this->author = $this->head->meta()
                      ->name("author")
                      ->content("Paige A. Thompson");

        $this->meta_generator = $this->head->meta()
                              ->name("generator")
                              ->content("Progressive Solutions Content Renderer");
    }

    function initialize_main_document_elements() {

        $this->head = $this->html->head();
        $this->head->title()->innerText = "PSCR Default Install Page";

        $this->head->stylesheet("css/style.css");
        $this->head->javascript("js/index.js");

        $this->content_root_div = $this->html->body()->div("content-root");
        $this->header_bar = $this->content_root_div->div('header');
        $this->side_bar = $this->content_root_div->div('side-bar');
        $this->content_area = $this->content_root_div->div('content-area');

        // used by get_paragraph_h*
        $this->sections = $this->content_area->div('sections')->class("sections");

        $this->footer_bar = $this->content_root_div->div('footer')->footer();
    }

    function generate_header_bar($header_bar) {

        $header_company = $header_bar->div()->id('company');
        $header_title = $header_bar->div()->id('title');

        $header_company->h1("【﻿ＰＳＣＲ】")->class("company");
        $header_title->h1("ᴰᵉᶠᵃᵘˡᵗ ᴵⁿˢᵗᵃˡˡ ᴾᵃᵍᵉ")->class("title");


        $button = $header_bar->div('sidebar-button');

        $button->innerText = '☰';
        $button->onclick="w3_open();";

    }

    function generate_side_bar($side_bar) {
        // Add navigation links to side bar
        $nav_links = $this->side_bar
                   ->div('navigation')
                   ->nav()
                   ->class('sidebar-nav');

        $nav_links->div()
            ->class('nav-link')
            ->a("Home")
            ->href("/");

        $nav_links->div()
            ->class('nav-link')
            ->a("About")
            ->href("/about");

        $nav_links->div()
            ->class('nav-link')
            ->a("Login")
            ->href("/login");

        $nav_links->div()
            ->class('nav-link')
            ->a("Register")
            ->href("/register");
    }

    function generate_content_area() {

        $para = $this->get_paragraph_container_h2("System Status");

        $para->div()->samp(shell_exec("uname -a"));
        $para->div()->samp(shell_exec("uptime"));

        $para = $this->get_paragraph_container_h3("Disk usage");
        $para->pre(shell_exec("df -h"));

        $para = $this->get_paragraph_container_h3("Kernel commandline parameters");
        $para->div()->br()->samp(shell_exec("cat /proc/cmdline"));

        $para = $this->get_paragraph_container_h3("Interrupts");
        $para->pre(shell_exec("cat /proc/interrupts"));

        $para = $this->get_paragraph_container_h3("Memory Info");
        $data = shell_exec("cat /proc/meminfo");
        $data = explode("\n", $data);
        $this->generate_table($para, $data);

        $para = $this->get_paragraph_container_h3("net / dev");
        $data = shell_exec("cat /proc/net/dev");
        $data = explode("\n", $data);
        $this->generate_table($para, $data);

        $para = $this->get_paragraph_container_h3("supported protocols");
        $para->pre(shell_exec("cat /proc/net/protocols"));
    }
    function generate_table($para, $data) {
        $table = $para->table();

        $thead = $table->thead();
        $tbody = $table->tbody();

        $tr = $thead->tr();
        $th_count = 0;
        foreach($data as $key => $value) {
            $line = preg_split('/\s+/', $value);
            if($key == 0) {
                foreach($line as $key2 => $value2) {
                    if(!empty($value2)) {
                        $tr->th()->innerText = trim($value2);
                        $th_count++;
                    }
                }
            }
            else {
                $tr = $tbody->tr();
                $whitespace = 0;
                foreach($line as $key2 => $value2) {
                    if(!empty($value2)) {
                        $tr->td()->innerText = trim($value2);
                    }
                    else {
                        if($whitespace < $th_count)
                        $whitespace++;
                        $tr->td()->innerText = "N/A";
                    }
                }
            }
        }
    }

    function get_paragraph_container_h2($heading_text)  {
        $para = $this->sections->div();
        $para->class = "section";
        $para->h2($heading_text);
        $para->hr();
        return $para;
    }

    function get_paragraph_container_h3($heading_text)
    {
        $para = $this->sections->div();
        $para->class = "section";
        $para->h3($heading_text)->style()->margin_top = "20px";
        $para->hr();
        return $para;
    }

    function get_paragraph_container_h4($heading_text)
    {
        $para = $this->sections->div();
        $para->class = "section";
        $para->h4($heading_text)->style()->margin_top = "20px";
        $para->hr();
        return $para;
    }

    function get_paragraph_container_h5($heading_text)
    {
        $para = $this->sections->div();
        $para->class = "section";
        $para->h5($heading_text)->style()->margin_top = "20px";
        $para->hr();
        return $para;
    }
}

?>
