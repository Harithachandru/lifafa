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

/* sites/fundle.team/modules/custom/fundle_store/templates/homepage-banner-slider.html.twig */
class __TwigTemplate_d5e2e63abd693481478b606f37bccd8f8b789938744b1ea6c1117ad1c5bb067b extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 35, "for" => 36];
        $filters = ["escape" => 39];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
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
        // line 12
        echo " 
                        ";
        // line 31
        echo "
<div class=\"banner clear dot-right dot-wh\">
            <div class=\"container\">
                <div class=\"banner-slider\">
            ";
        // line 35
        if (($context["content"] ?? null)) {
            // line 36
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["content"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 37
                echo "
                    <div class=\"item \">
                         <img src=\"";
                // line 39
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["row"], "bannerUrl", [])), "html", null, true);
                echo "\" alt=\"fundle\">
                        <div class=\"\">
                            <div class=\"container\">  
                                <div class=\"fms-sec text-center title-1 pd-25 upc\" style=\"height: 80px;\"> 
                                    ";
                // line 43
                if ($this->getAttribute($context["row"], "banner_heading", [])) {
                    // line 44
                    echo "                                        ";
                    echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($context["row"], "banner_heading", [])), "html", null, true);
                    echo "
                                    ";
                }
                // line 46
                echo "                                </div>
                            </div>
                        </div>
                    </div>
                      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 50
            echo " 
            ";
        }
        // line 52
        echo "                </div>
            </div>
        </div>";
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/modules/custom/fundle_store/templates/homepage-banner-slider.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 52,  100 => 50,  90 => 46,  84 => 44,  82 => 43,  75 => 39,  71 => 37,  66 => 36,  64 => 35,  58 => 31,  55 => 12,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/modules/custom/fundle_store/templates/homepage-banner-slider.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\modules\\custom\\fundle_store\\templates\\homepage-banner-slider.html.twig");
    }
}
