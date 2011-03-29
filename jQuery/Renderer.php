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
 * Renderer.
 *
 * @author  naydav <web@naydav.com>
 */
interface Renderer
{
    /**
     * Renders of the jQuery enviroment.
     *
     * @return string
     */
    public function render();
}