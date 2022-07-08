<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* select_rule_group/formSelect.html.twig */
class __TwigTemplate_828586744f9c5c2cfff58512bdf1f1cd51035917b34d48de0d4d22c0902eea81 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "select_rule_group/formSelect.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "select_rule_group/formSelect.html.twig"));

        // line 1
        echo "<form method=\"post\" action=\"";
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_add_rule_group");
        echo "\">
    <div class=\"mb-3\">
      <label for=\"\" class=\"form-label\">Disabled select menu</label>
        <select name=\"ruleId\" id=\"ruleId\" class=\"form-select\">
        ";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["rules"]) || array_key_exists("rules", $context) ? $context["rules"] : (function () { throw new RuntimeError('Variable "rules" does not exist.', 5, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["rule"]) {
            // line 6
            echo "    <option value=";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["rule"], "id", [], "any", false, false, false, 6), "html", null, true);
            echo ">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["rule"], "name", [], "any", false, false, false, 6), "html", null, true);
            echo "</option>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rule'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 8
        echo "    </select>
    <input type=\"hidden\" name=\"campaignId\" value=";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["campaignId"]) || array_key_exists("campaignId", $context) ? $context["campaignId"] : (function () { throw new RuntimeError('Variable "campaignId" does not exist.', 9, $this->source); })()), "html", null, true);
        echo ">
    <input type=\"hidden\" name=\"campaignId\" value=";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["campaignId"]) || array_key_exists("campaignId", $context) ? $context["campaignId"] : (function () { throw new RuntimeError('Variable "campaignId" does not exist.', 10, $this->source); })()), "html", null, true);
        echo ">
    </div>
    <button type=\"submit\" class=\"btn btn-primary\">Submit</button>
  </fieldset>
</form>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "select_rule_group/formSelect.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 10,  69 => 9,  66 => 8,  55 => 6,  51 => 5,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<form method=\"post\" action=\"{{path('app_add_rule_group')}}\">
    <div class=\"mb-3\">
      <label for=\"\" class=\"form-label\">Disabled select menu</label>
        <select name=\"ruleId\" id=\"ruleId\" class=\"form-select\">
        {% for rule in rules %}
    <option value={{ rule.id }}>{{ rule.name }}</option>
        {% endfor %}
    </select>
    <input type=\"hidden\" name=\"campaignId\" value={{campaignId}}>
    <input type=\"hidden\" name=\"campaignId\" value={{campaignId}}>
    </div>
    <button type=\"submit\" class=\"btn btn-primary\">Submit</button>
  </fieldset>
</form>
", "select_rule_group/formSelect.html.twig", "A:\\git\\Renovads-Data\\templates\\select_rule_group\\formSelect.html.twig");
    }
}
