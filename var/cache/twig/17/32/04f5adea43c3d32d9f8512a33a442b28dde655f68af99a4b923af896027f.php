<?php

/* about_me.html */
class __TwigTemplate_173204f5adea43c3d32d9f8512a33a442b28dde655f68af99a4b923af896027f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout.html");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "À Propos";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "\t<div class=\"example-grid\">
\t\t<div class=\"parallax\" gumby-parallax=\"0.5\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"centered ten columns\" align=\"center\">
\t\t\t\t\t<p>\"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>
\t\t\t\t</div>\t
\t\t\t</div>
\t\t</div>
\t\t<div class=\"row\">
\t\t\t<div class=\"centered six columns\" align=\"center\">
\t\t\t\t<ul>
\t\t\t\t  <li class=\"prepend field\">
\t\t\t\t    <span class=\"adjoined\">@</span>
\t\t\t\t    <input class=\"xwide text input\" type=\"text\" placeholder=\"Adresse Email\" />
\t\t\t\t  </li>
\t\t\t\t  <li class=\"field\">
\t\t\t\t    <textarea class=\"xwide input textarea\" placeholder=\"Message\"></textarea>
\t\t\t\t  </li>
\t\t\t\t</ul>
\t\t\t\t<fieldset>
\t\t\t\t  <legend>Fieldset with legend</legend>
\t\t\t\t  <ul>
\t\t\t\t    <li class=\"field\">
\t\t\t\t      <label class=\"inline\" for=\"text1\">Label 1</label>
\t\t\t\t      <input class=\"wide text input\" id=\"text1\" type=\"text\" placeholder=\"wide input\" />
\t\t\t\t    </li>
\t\t\t\t    <li class=\"field\">
\t\t\t\t      <label class=\"inline\" for=\"text2\">Label 2</label>
\t\t\t\t      <input class=\"wide password input\" id=\"text2\" type=\"password\" placeholder=\"wide input\" />
\t\t\t\t    </li>
\t\t\t\t  </ul>
\t\t\t\t</fieldset>
\t\t\t</div>
\t\t</div>
\t</div>
";
    }

    public function getTemplateName()
    {
        return "about_me.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  35 => 5,  29 => 3,);
    }
}
