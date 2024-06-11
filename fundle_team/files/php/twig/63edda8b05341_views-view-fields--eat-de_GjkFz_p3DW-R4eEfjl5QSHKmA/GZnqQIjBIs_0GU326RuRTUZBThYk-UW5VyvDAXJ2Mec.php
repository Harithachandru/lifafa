<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* sites/fundle.team/themes/custom/fundlev/templates/views/eat_deals/views-view-fields--eat-deals--block-2.html.twig */
class __TwigTemplate_d49cc0ac20ff90224fb9372c55d98acca85d9e3fa72c6b1dc15506a08e2004ac extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 4];
        $filters = ["escape" => 3];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<div class=\"item \">
      <div class=\"deals-box \">
\t\t\t\t  <a href=\"";
        // line 3
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "view_node", []), "content", [])), "html", null, true);
        echo "\">
          ";
        // line 4
        if ($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_brand_thumbnail", []), "content", [])) {
            // line 5
            echo "                <div class=\"deals-img\">
                    ";
            // line 6
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_brand_thumbnail", []), "content", [])), "html", null, true);
            echo "
                </div>
                ";
        }
        // line 9
        echo "                    <div class=\"text-1 eq-2\" style=\"height: 60px;\">";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_brand_name", []), "content", [])), "html", null, true);
        echo " <span class=\"text-10 link-1\">";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_sub_category", []), "content", [])), "html", null, true);
        echo "</span>
                     </div>
\t\t\t\t\t  </a>
                  </div>
               </div>";
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/themes/custom/fundlev/templates/views/eat_deals/views-view-fields--eat-deals--block-2.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 9,  68 => 6,  65 => 5,  63 => 4,  59 => 3,  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/themes/custom/fundlev/templates/views/eat_deals/views-view-fields--eat-deals--block-2.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\themes\\custom\\fundlev\\templates\\views\\eat_deals\\views-view-fields--eat-deals--block-2.html.twig");
    }
}
