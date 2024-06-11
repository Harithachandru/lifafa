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

/* sites/fundle.team/modules/custom/fundle_store/templates/points-detail-block.html.twig */
class __TwigTemplate_916675d1f89578d919ace7c227a8290b7765f41293755dbde7f444c4fe6e1c7e extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = ["escape" => 4];
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
        // line 1
        echo "<section class=\"points-sec top-deal\">
    <div class=\"container p-10\">
        <div class=\"rd-points rd-black text-center\">
            <div class=\"point-icon\"><img alt=\"fundle\" data-entity-type=\"file\" data-entity-uuid=\"cccccf75-29e2-4b49-a3b4-5daa1369e3d2\" src=\"";
        // line 4
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null)) . $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null))), "html", null, true);
        echo "/images/Path-1754.png\" /></div>
            <h2>";
        // line 5
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "points", [])), "html", null, true);
        echo " Points</h2>
            <table>
                <tbody>
                    <tr>
                        <td class=\"points-icon\">
                           ";
        // line 11
        echo "                            <div class=\"points-icon-box  bl-w \">
                            <img alt=\"fundle\" data-entity-type=\"file\" data-entity-uuid=\"1ebdb2df-8203-4e2c-aaa4-24b62c4cdb37\" onclick=\"postRedeemOneClickedToRN();\" src=\"";
        // line 12
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null)) . $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null))), "html", null, true);
        echo "/images/ic-55.png\" /></div>
                            <div class=\"text-1\">Redeem</div>
                        </td>
                        <td class=\"points-icon\">
                          ";
        // line 17
        echo "                           <div class=\"points-icon-box  bl-w \">
                            <img alt=\"fundle\" data-entity-type=\"file\" data-entity-uuid=\"c3048bfb-a2bb-47ac-b4b7-840428198a44\" onclick=\"postJwtToRN();\" src=\"";
        // line 18
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null)) . $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null))), "html", null, true);
        echo "/images/Union-56.png\" /></div>
                            <div class=\"text-1\"><span style=\"padding-left:7px;\"> Earn Points </span></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>";
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/modules/custom/fundle_store/templates/points-detail-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 18,  82 => 17,  75 => 12,  72 => 11,  64 => 5,  60 => 4,  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/modules/custom/fundle_store/templates/points-detail-block.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\modules\\custom\\fundle_store\\templates\\points-detail-block.html.twig");
    }
}
