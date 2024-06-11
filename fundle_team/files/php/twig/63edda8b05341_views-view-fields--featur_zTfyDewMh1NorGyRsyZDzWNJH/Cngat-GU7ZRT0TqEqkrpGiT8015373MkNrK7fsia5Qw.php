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

/* sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-fields--featured-top-deals--block-1.html.twig */
class __TwigTemplate_bb65f715b296fe95c5eb60395393acd69faf0a881db6672a627d88041bf67bbf extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 54];
        $filters = ["escape" => 53];
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
        // line 34
        echo "

";
        // line 50
        echo "
<div class=\"item \">
    <div class=\"deals-box \">
        <a href=\"";
        // line 53
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "view_node", []), "content", [])), "html", null, true);
        echo "\">
            ";
        // line 54
        if ($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_brand_thumbnail", []), "content", [])) {
            // line 55
            echo "                <div class=\"deals-img \">
                    ";
            // line 56
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_brand_thumbnail", []), "content", [])), "html", null, true);
            echo "
                </div>
            ";
        }
        // line 59
        echo "
            <div class=\"text-1 eq-2\" style=\"height: 80px;\">";
        // line 60
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_sub_header", []), "content", [])), "html", null, true);
        echo "</div>

        </a>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-fields--featured-top-deals--block-1.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 60,  79 => 59,  73 => 56,  70 => 55,  68 => 54,  64 => 53,  59 => 50,  55 => 34,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-fields--featured-top-deals--block-1.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\themes\\custom\\fundlev\\templates\\views\\featured_top_deals\\views-view-fields--featured-top-deals--block-1.html.twig");
    }
}
