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
 * Api Class implements jQuery support.
 *
 * @author  naydav <web@naydav.com>
 */
class Api implements Renderer
{
    /**
     * Indicates wheater the jQuery Helper is enabled.
     *
     * @var Boolean
     */
    protected $_enabled = false;

    /**
     * Renders helpers list.
     *
     * @param array
     */
    protected $_renderHelpers;

    /**
     * Set Enable/Disable jQuery flag
     *
     * @param bool $flag
     * @return \WC\JQueryHelperBundle\jQuery\Api
     */
    public function setEnable($flag)
    {
        $this->_enabled = (bool) $flag;
        return $this;
    }

    /**
     * Is jQuery enabled?
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Set render helpers.
     *
     * @param array $renderHelpers
     * @return void
     */
    public function setRenderHelpers(array $renderHelpers)
    {
        foreach ($renderHelpers as $name => $renderHelper) {
            $this->setRenderHelper($name, $renderHelper);
        }
    }

    /**
     * Set render helper.
     *
     * @paramm string $name Helper name
     * @param \WC\JQueryHelperBundle\jQuery\Renderer $renderHelper
     * @return void
     * @throws \WC\JQueryHelperBundle\jQuery\InvalidArgumentException
     *         If render helper not implements of Renderer
     */
    public function setRenderHelper($name, Renderer $renderHelper)
    {
        if (! $renderHelper instanceof Renderer) {
            throw new InvalidArgumentException(
                    'Render helper must implements Renderer');
        }
        $this->_renderHelpers[$name] = $renderHelper;
    }

    /**
     * Get render helpers.
     *
     * @return array
     */
    public function getRenderHelpers()
    {
        return $this->_renderHelpers;
    }

    /**
     * Get render helper by name.
     *
     * @param $name Helper name
     * @return array
     */
    public function getRenderHelper($name)
    {
        if (! \array_key_exists($name, $this->_renderHelpers)) {
            throw new InvalidArgumentException("Helper with name '{$name}' not setted");
        }

        return $this->_renderHelpers[$name];
    }

    /**
     * String representation of jQuery
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Renders all javascript file related stuff of the jQuery enviroment.
     *
     * @return string
     * @throws
     */
    public function render()
    {
        if (! $this->isEnabled()) {
            return '';
        }

        $html = '';
        foreach ($this->getRenderHelpers() as $helper) {
            $html .= $helper->render();
        }
        return $html;
    }

    /**
     * Renders only onLoad javascript code.
     *
     * @return string
     * @throws
     */
    public function renderOnLoad()
    {
        if (! $this->isEnabled()) {
            return '';
        }

        return $this->getRenderHelper('Capture')->render();
    }

    /**
     * Start stream add onLoad
     *
     * @return void
     */
    public function addOnLoad()
    {
        $this->getRenderHelper('Capture')->onLoadCaptureStart();
    }

    /**
     * End stream add onLoad
     *
     * @return void
     */
    public function addOnLoadEnd()
    {
        $this->getRenderHelper('Capture')->onLoadCaptureEnd();
    }
}