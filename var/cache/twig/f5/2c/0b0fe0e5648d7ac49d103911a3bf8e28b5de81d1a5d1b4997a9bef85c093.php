<?php

/* layout.html */
class __TwigTemplate_f52c0b0fe0e5648d7ac49d103911a3bf8e28b5de81d1a5d1b4997a9bef85c093 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <title>";
        // line 4
        $this->displayBlock('title', $context, $blocks);
        echo " - My Silex Application</title>
        <link href=\"/css/sass/gumby.css\" rel=\"stylesheet\" type=\"text/css\">
        <link href=\"/css/main.css\" rel=\"stylesheet\" type=\"text/css\">

       \t<script src=\"/js/jquery.min.js\" type=\"text/javascript\"></script>
       \t<script src=\"/js/modernizr.js\" type=\"text/javascript\"></script>
       \t<script gumby-touch=\"/js\" src=\"/js/gumby.min.js\" type=\"text/javascript\"></script>
    </head>
    <body>
    \t<div class='navcontain'>
\t        <div class=\"navbar\" id=\"navbar-main-nav\">
\t          <div class=\"row\">
\t\t\t\t  <!-- Toggle for mobile navigation, targeting the <ul> -->
\t\t\t\t  <a class=\"toggle\" gumby-trigger=\"#navbar-main-nav > ul\" href=\"#\"><i class=\"icon-menu\"></i></a>
\t\t\t\t  <h1 class=\"eight columns logo\">
\t\t\t\t    <a href=\"/\">
\t\t\t\t      <img src=\"/img/jimmy.png\" gumby-retina />
\t\t\t\t    </a>
\t\t\t\t  </h1>
\t\t\t\t  <ul class=\"two_up tiles\">
\t\t\t\t    <li>
\t\t\t\t      <a href=\"#\">Albums</a>
\t\t\t\t      <div class=\"dropdown\">
\t\t\t\t        <ul>
\t\t\t\t          <li><a href=\"#\">The Grid</a></li>
\t\t\t\t          <li><a href=\"#\">UI Kit</a></li>
\t\t\t\t          <li><a href=\"#\">Sass</a></li>
\t\t\t\t          <li><a href=\"#\">JavaScript</a></li>
\t\t\t\t          <li><a href=\"#\">Demo</a></li>
\t\t\t\t        </ul>
\t\t\t\t      </div>
\t\t\t\t    </li>
\t\t\t\t    <li><a href=\"/about-me/\">À Propos</a></li>
\t\t\t\t  </ul>
\t\t\t  </div>
\t\t\t</div>
\t\t</div>
\t\t";
        // line 41
        $this->displayBlock('content', $context, $blocks);
        // line 42
        echo "    </body>
    <footer>
    \t<nav class=\"footer\">
    \t\t<section class=\"row\">
    \t\t\t<div class=\"eight columns\"></div>
    \t\t\t<div class=\"four columns copyright\">
    \t\t\t\t<p>© Copyright 2013. Tous droits réservés.</p>
    \t\t\t</div>
    \t\t</section>
    \t</div>
    </footer>
</html>

";
    }

    // line 4
    public function block_title($context, array $blocks = array())
    {
        echo "";
    }

    // line 41
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout.html";
    }

    public function getDebugInfo()
    {
        return array (  91 => 41,  85 => 4,  68 => 42,  66 => 41,  26 => 4,  21 => 1,  38 => 6,  35 => 5,  29 => 3,);
    }
}
