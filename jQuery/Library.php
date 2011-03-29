<?php
/**
 * CMF for web applications based on
 * Symfony 2, Domain Model DDD, Doctrine 2 (Doctrine Extension)
 *
 * @copyright  Copyright (c) 2011 Valery Nayda aka naydav <web@naydav.com>
 * @link  http://www.webcreator.kiev.ua
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GPLv3
 */

namespace WC\JQueryHelperBundle\JQuery;

/**
 * Render javascript code for include library.
 *
 * @author  naydav <web@naydav.com>
 */
interface Library
{
    /**
     * Set the version of the jQuery library used.
     *
     * @param string $version
     * @return \WC\JQueryHelperBundle\JQuery\Library
     */
    public function setVersion($version);

    /**
     * Get the version used with the jQuery library
     *
     * @return string
     */
    public function getVersion();

    /**
     * Set Use SSL Flag
     *
     * @return \WC\JQueryHelperBundle\JQuery\Library
     */
    public function setSsl($flag);

    /**
     * Are we using the SSL?
     *
     * @return boolean
     */
    public function useSsl();

    /**
     * Set path to local library
     *
     * @param  string $path
     * @return \WC\JQueryHelperBundle\JQuery\Library
     */
    public function setLocalPath($path);

    /**
     * Get local path to jQuery
     *
     * @return string
     */
    public function getLocalPath();

    /**
     * Are we using a local path?
     *
     * @return boolean
     */
    public function useLocalPath();
}