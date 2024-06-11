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

/* sites/fundle.team/themes/custom/fundlev/templates/layout/page.html.twig */
class __TwigTemplate_f190c9b03dbf7f7e967105d86c9e5d135b5122ee3db0f6b57ab5f18611ff0792 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 24];
        $filters = ["escape" => 25];
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
        // line 10
        echo "
";
        // line 21
        echo "<section class=\"mall-listing tpa \">
    <div class=\"container\">

";
        // line 24
        if (($context["is_front"] ?? null)) {
            // line 25
            echo "  ";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["page"] ?? null), "content", []), "breadcrumbs", [])), "html", null, true);
            echo "
  ";
            // line 26
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["page"] ?? null), "content", []), "page_title", [])), "html", null, true);
            echo "
  ";
            // line 27
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["page"] ?? null), "content", []), "local_tasks", [])), "html", null, true);
            echo "
  ";
            // line 28
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["page"] ?? null), "content", []), "help", [])), "html", null, true);
            echo "
  ";
            // line 29
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["page"] ?? null), "content", []), "local_actions", [])), "html", null, true);
            echo "
  ";
            // line 30
            echo " < no content
";
        } else {
            // line 32
            echo "  ";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
            echo "
";
        }
        // line 34
        echo "
";
        // line 35
        if ($this->getAttribute(($context["page"] ?? null), "footer_top", [])) {
            // line 36
            echo "    ";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer_top", [])), "html", null, true);
            echo "
";
        }
        // line 38
        echo "
";
        // line 48
        echo "    </div>
</section>";
    }

    public function getTemplateName()
    {
        return "sites/fundle.team/themes/custom/fundlev/templates/layout/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  110 => 48,  107 => 38,  101 => 36,  99 => 35,  96 => 34,  90 => 32,  86 => 30,  82 => 29,  78 => 28,  74 => 27,  70 => 26,  65 => 25,  63 => 24,  58 => 21,  55 => 10,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "sites/fundle.team/themes/custom/fundlev/templates/layout/page.html.twig", "C:\\xampp\\htdocs\\lms\\sites\\fundle.team\\themes\\custom\\fundlev\\templates\\layout\\page.html.twig");
    }
}
