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

/* sites/fundle.team/modules/custom/gcm_store/templates/gcm-store-block.html.twig */
class __TwigTemplate_809242d942193b3df4e09e1b17ac1b1eec7918b3c2023c84e72d8c34794304c7 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 5, "set" => 6, "for" => 22];
        $filters = ["escape" => 32, "raw" => 36];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'set', 'for'],
                ['escape', 'raw'],
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
        // line 2
        echo "
";
        // line 4
        echo "
";
        // line 5
        if ((($context["store_gcm_url"] ?? null) && ($context["logged_in"] ?? null))) {
            // line 6
            echo "    ";
            $context["store_url"] = ($context["store_gcm_url"] ?? null);
        } else {
            // line 8
            echo "    ";
            $context["store_url"] = ($context["store_landing_url"] ?? null);
        }
        // line 10
        echo "
<section class=\"top-deal-sec\">
    <div class=\"container\">
        <div class=\"top-deal\">
            <table class=\"pb-5\">
                <tr>
                    <td class=\"title-1\">Discounted Vouchers </td>
                    <td style=\"text-align:right;\" class=\"link-1 link-btn \"><a  onclick=\"postVouchersViewAllClicked();\"  >View All</a></td>
                </tr>
            </table>

            <div class=\"vouchers-card-box Offer-hover\">
                ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["content"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["row"]) {
            // line 23
            echo "                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["row"], "data", []));
            foreach ($context['_seq'] as $context["key2"] => $context["data"]) {
                // line 24
                echo "                        ";
                if (($this->getAttribute($context["data"], "field_store", []) != "")) {
                    // line 25
                    echo "                            ";
                    // line 26
                    echo "                            <table class=\"vouchers-table\" cellpadding=\"0\" cellspacing=\"0\">
                                <tr>                                   
                                    <td class=\"logo-box\">
                                         ";
                    // line 29
                    if ($this->getAttribute($context["data"], "field_special_offer", [])) {
                        // line 30
                        echo "                                        <div class=\"vouchers-Offer\">Special Offer </div>
                                         ";
                    }
                    // line 32
                    echo "                                        <img src=\"";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["data"], "field_image", [])), "html", null, true);
                    echo "\" alt=\"fundle\">
                                    </td>
                                    <td class=\"vouchers-dsc\">
                                    <div class=\"ma-vouchers-title\">";
                    // line 35
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["data"], "title", [])), "html", null, true);
                    echo "</div>
                                    <div class=\"ma-vouchers pt-5\">";
                    // line 36
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->sandbox->ensureToStringAllowed($this->getAttribute($context["data"], "body", [])));
                    echo " 
                                      ";
                    // line 38
                    echo "                                    </div> 
                                    </td>
                                    <td class=\"text-right vouchers-link\">
                                        <div class=\"text-14 bold\">Save ";
                    // line 41
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["data"], "field_discount", [])), "html", null, true);
                    echo "%</div>
                                        <div class=\" pt-5\">
                                        <a ";
                    // line 43
                    echo " onclick=\"postVouchersViewAllClickedBUY('";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["data"], "title", [])), "html", null, true);
                    echo "');\" class=\"btn btn-primary\">Buy Now</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>                            
                        ";
                }
                // line 49
                echo "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key2'], $context['data'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 50
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo "   
            </div>

        </div>
    </div>
</section>
                    
";
        // line 135
        echo "



";
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/modules/custom/gcm_store/templates/gcm-store-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  165 => 135,  151 => 50,  145 => 49,  135 => 43,  130 => 41,  125 => 38,  121 => 36,  117 => 35,  110 => 32,  106 => 30,  104 => 29,  99 => 26,  97 => 25,  94 => 24,  89 => 23,  85 => 22,  71 => 10,  67 => 8,  63 => 6,  61 => 5,  58 => 4,  55 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/modules/custom/gcm_store/templates/gcm-store-block.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\modules\\custom\\gcm_store\\templates\\gcm-store-block.html.twig");
    }
}
