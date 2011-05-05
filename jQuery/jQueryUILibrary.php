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
 * Render javascript code for include jQueryUI library.
 *
 * @author  naydav <web@naydav.com>
 */
class jQueryUILibrary extends AbstractLibrary
{
    /**
     * @const string
     */
    const CDN_SUBFOLDER_GOOGLE = 'jqueryui/';

    /**
     * Always uses compressed version, because this is assumed to be the use case
     * in production enviroment. An uncompressed version has to included manually.
     *
     * @see http://code.google.com/apis/ajaxlibs/documentation/index.html#jquery
     * @const string File path after base and version
     */
    const CDN_PATH_GOOGLE = '/jquery-ui.min.js';
}