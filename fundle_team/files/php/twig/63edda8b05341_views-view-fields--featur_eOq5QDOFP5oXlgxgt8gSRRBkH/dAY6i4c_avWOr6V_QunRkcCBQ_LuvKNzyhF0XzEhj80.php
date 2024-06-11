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

/* sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-fields--featured-top-deals--page-1.html.twig */
class __TwigTemplate_f22e1089f60d636a7c372f06332f62a44e70e1557871e6340768dd7ad8f13ce9 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = ["escape" => 10];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                [],
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
        // line 5
        echo "    <div class=\"grid-item dept-clarks \" data-dept=\"Clarks\">
        <div class=\"category-box\">
            <table>
                <tr>
                    <td>
                        <div class=\"text-12 bold\">";
        // line 10
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_brand_name", []), "content", [])), "html", null, true);
        echo "</div>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
            <div class=\"category-sec top-deals-banner-sec\">
                <table class=\"btm-des\">
                    <tr>
                        <td><div class=\"link-1\">";
        // line 19
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_header", []), "content", [])), "html", null, true);
        echo "</div><div class=\"text-12 midd-font\">";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_sub_header", []), "content", [])), "html", null, true);
        echo "</div>
                        </td>
                        <td>
                            <div class=\"text-9 text-right midd-font\">";
        // line 22
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_store_floor", []), "content", [])), "html", null, true);
        echo ",";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_storenumber", []), "content", [])), "html", null, true);
        echo "</div>

                                <div class=\"text-9  text-right\">Valid Till ";
        // line 24
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_event_end_date", []), "content", [])), "html", null, true);
        echo "</div>

                            ";
        // line 27
        echo "                        </td>
                    </tr>
                </table>
                <div class=\"top-deals-banner\">
                    <a href=\"";
        // line 31
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "view_node", []), "content", [])), "html", null, true);
        echo "\">";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["fields"] ?? null), "field_listing_detail_image", []), "content", [])), "html", null, true);
        echo " </a>
                </div>
            </div>
            <hr>
        </div>
    </div>


";
        // line 41
        echo "

";
        // line 88
        echo "
";
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-fields--featured-top-deals--page-1.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 88,  113 => 41,  100 => 31,  94 => 27,  89 => 24,  82 => 22,  74 => 19,  62 => 10,  55 => 5,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-fields--featured-top-deals--page-1.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\themes\\custom\\fundlev\\templates\\views\\featured_top_deals\\views-view-fields--featured-top-deals--page-1.html.twig");
    }
}
