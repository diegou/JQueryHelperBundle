<?php
/**
 * CMF for web applications based on
 * Symfony 2, Domain Model DDD, Doctrine 2 (Doctrine Extension)
 *
 * @copyright  Copyright (c) 2011 Valery Nayda aka naydav <web@naydav.com>
 * @link  http://www.webcreator.kiev.ua
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GPLv3
 */

namespace WC\JQueryHelperBundle\Twig\Node;

/**
 * Represents a javascript node.
 *
 * @author Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class JQueryNode extends \Twig_Node
{
    /**
     * @param \Twig_NodeInterface $value
     * @param integer $lineno
     * @param string $tag (optional)
     * @return void
     */
    public function __construct(\Twig_NodeInterface $method, $lineno, $tag = null)
    {
        parent::__construct(array('method' => $method), array(), $lineno, $tag);
    }
    
    /**
     * Compiles the node to PHP.
     *
     * @param \Twig_Compiler A Twig_Compiler instance
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write("echo \$this->env->getExtension('templating')->getContainer()->get('jquery.api')->")
            ->raw($this->getNode('method')->getAttribute('value'))
            ->raw("();\n");
        ;
    }
}