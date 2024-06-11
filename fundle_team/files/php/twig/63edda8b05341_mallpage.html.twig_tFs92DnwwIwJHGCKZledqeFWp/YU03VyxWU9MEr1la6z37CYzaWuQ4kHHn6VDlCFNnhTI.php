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

/* sites/fundle.team/modules/custom/fundle_store/templates/mallpage.html.twig */
class __TwigTemplate_8e4c13d3a1692bc3c8ee9a4ca4fc3c37d3751820cc70d703bd3a3ab1586fe308 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 13, "for" => 14];
        $filters = ["escape" => 28];
        $functions = ["drupal_block" => 28];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape'],
                ['drupal_block']
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
        // line 12
        echo "           
";
        // line 13
        if ($this->getAttribute(($context["storedata"] ?? null), "store_blocks", [])) {
            // line 14
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["storedata"] ?? null), "store_blocks", []));
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                echo "                
";
                // line 27
                echo "                               
    ";
                // line 28
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\twig_tweak\TwigExtension')->drupalBlock($this->sandbox->ensureToStringAllowed($this->getAttribute($context["row"], "block_stores", [])), [], false), "html", null, true);
                echo "
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 29
            echo " 
";
        }
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/modules/custom/fundle_store/templates/mallpage.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 29,  73 => 28,  70 => 27,  64 => 14,  62 => 13,  59 => 12,  55 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/modules/custom/fundle_store/templates/mallpage.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\modules\\custom\\fundle_store\\templates\\mallpage.html.twig");
    }
}
