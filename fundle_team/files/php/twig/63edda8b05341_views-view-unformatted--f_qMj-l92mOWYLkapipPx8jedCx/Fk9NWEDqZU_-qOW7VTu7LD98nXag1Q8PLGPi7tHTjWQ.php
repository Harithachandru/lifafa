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

/* sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-unformatted--featured-top-deals--block-1.html.twig */
class __TwigTemplate_53c666630e58dd8c8c4211a4e9be6d84b4a192417e4dd85b6c0d253d340dd68b extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["for" => 31];
        $filters = ["escape" => 27];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['for'],
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
        // line 21
        echo "<section class=\"top-deal-sec\">
    <div class=\"container\">
        <div class=\"top-deal\">
            <table class=\"pb-5\">
                <tr>
                    <td class=\"title-1\">Top Deals</td>
                    <td style=\"text-align:right;\" class=\"link-1 link-btn\"><a href=\"/mall/";
        // line 27
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["storeId"] ?? null)), "html", null, true);
        echo "/";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["mallId"] ?? null)), "html", null, true);
        echo "/topdeals/\">View All</a></td>
                </tr>
            </table>
            <div class=\"deals-slider\">          
                ";
        // line 31
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["rows"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 32
            echo "                    ";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["row"], "content", [])), "html", null, true);
            echo "
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "            </div>
        </div>

    </div>
</section>";
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-unformatted--featured-top-deals--block-1.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 34,  76 => 32,  72 => 31,  63 => 27,  55 => 21,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/themes/custom/fundlev/templates/views/featured_top_deals/views-view-unformatted--featured-top-deals--block-1.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\themes\\custom\\fundlev\\templates\\views\\featured_top_deals\\views-view-unformatted--featured-top-deals--block-1.html.twig");
    }
}
