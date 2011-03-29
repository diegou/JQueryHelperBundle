<?php
/**
 * CMF for web applications based on
 * Symfony 2, Domain Model DDD, Doctrine 2 (Doctrine Extension)
 *
 * @copyright  Copyright (c) 2011 Valery Nayda aka naydav <web@naydav.com>
 * @link  http://www.webcreator.kiev.ua
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GPLv3
 */

namespace WC\JQueryHelperBundle\jQuery;

/**
 * Capture Class.
 *
 * @author  naydav <web@naydav.com>
 */
class Capture implements Renderer
{
    /**
     * NoConflictMode helper
     * 
     * @var \WC\JQueryHelperBundle\jQuery\NoConflictMode
     */
    protected $_noConflictModeHelper;

    /**
     * Indicates if a capture start method for javascript or onLoad has been called.
     *
     * @var Boolean
     */
    protected $_captureLock = false;
    
    /**
     * jQuery onLoad statements Stack
     *
     * @var Array
     */
    protected $_onLoadActions = array();

    protected $_isXhtml = true;

    /**
     * Set NoConflictMode helper
     *
     * @param \WC\JQueryHelperBundle\jQuery\NoConflictMode $noConflictModeHelper
     * @return void
     * @throws \WC\JQueryHelperBundle\jQuery\InvalidArgumentException
     *         If wrong class NoConflictMode helper
     */
    public function setNoConflictModeHelper($noConflictModeHelper)
    {
        if (! $noConflictModeHelper instanceof  NoConflictMode) {
            throw new InvalidArgumentException('Wrong class NoConflictMode helper');
        }
        $this->_noConflictModeHelper = $noConflictModeHelper;
    }

    /**
     * Get NoConflictMode helper
     *
     * @return \WC\JQueryHelperBundle\jQuery\NoConflictMode
     */
    public function getNoConflictModeHelper()
    {
        return $this->_noConflictModeHelper;
    }
    
    /**
     * Start capturing routines to run onLoad
     *
     * @return boolean
     */
    public function onLoadCaptureStart()
    {
        if ($this->_captureLock) {
            throw new BadFunctionCallException('Cannot nest onLoad captures');
        }

        $this->_captureLock = true;
        return \ob_start();
    }

    /**
     * Stop capturing routines to run onLoad
     *
     * @return boolean
     */
    public function onLoadCaptureEnd()
    {
        $data = \ob_get_clean();
        $this->_captureLock = false;
        $this->addOnLoad($data);
        return true;
    }

    /**
     * Add a script to execute onLoad
     *
     * @param  string $callback Lambda
     * @return \WC\JQueryHelperBundle\jQuery\Capture
     */
    public function addOnLoad($callback)
    {
        if (! in_array($callback, $this->_onLoadActions, true)) {
            $this->_onLoadActions[] = $callback;
        }
        return $this;
    }
    
    /**
     * Retrieve all registered onLoad actions
     *
     * @return array
     */
    public function getOnLoadActions()
    {
        return $this->_onLoadActions;
    }

    /**
     * Clear the onLoadActions stack.
     *
     * @return \WC\JQueryHelperBundle\jQuery\Capture
     */
    public function clearOnLoadActions()
    {
        $this->_onLoadActions = array();
        return $this;
    }

    /**
     * Renders captured javascript code.
     *
     * @return string
     */
    public function render()
    {
        $content = '';
        $onLoadActions = $this->getOnLoadActions();
        if (count($onLoadActions) > 0) {
            $content .= $this->getNoConflictModeHelper()->getNoConflictModeHandler();
            $content .= '(document).ready(function() {';
            $content .= "\n    ";
            $content .= implode("\n    ", $onLoadActions) . "\n";
            $content .= '});'."\n";
        }

        if (preg_match('/^\s*$/s', $content)) {
            return '';
        }

        $html = '<script type="text/javascript">' . PHP_EOL
              . (($this->_isXhtml) ? '//<![CDATA[' : '//<!--') . PHP_EOL
              . $content
              . (($this->_isXhtml) ? '//]]>' : '//-->') . PHP_EOL
              . PHP_EOL . '</script>';

        return $html;
    }
}