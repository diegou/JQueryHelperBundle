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
 * Render javascript code for include library.
 *
 * @author  naydav <web@naydav.com>
 */
abstract class AbstractLibrary implements Library,
                                          Renderer
{
    /**
     * @see http://code.google.com/apis/ajaxlibs/documentation/index.html#jquery
     * @const string Base path to CDN
     */
    const CDN_BASE_GOOGLE = 'http://ajax.googleapis.com/ajax/libs/';

    /**
     * @see http://code.google.com/apis/ajaxlibs/documentation/index.html#jquery
     * @const string Base path to CDN
     */
    const CDN_BASE_GOOGLE_SSL = 'https://ajax.googleapis.com/ajax/libs/';

    /**
     * Current default jQuery library
     *
     * @const string
     */
    protected $_version;

     /**
     * Load CDN Path from SSL or Non-SSL?
     *
     * @var boolean
     */
    protected $_useSsl = false;
    
    /**
     * Local path to library
     *
     * @var String
     */
    protected $_libraryLocalPath = null;

    /**
     * Path to library
     *
     * @var String
     */
    protected $_libraryPath = null;

    /**
     * Get the version used with the jQuery library
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }

     /**
     * Set the version of the jQuery library used.
     *
     * @param string $version
     * @return \WC\JQueryHelperBundle\JQuery\Library
     */
    public function setVersion($version)
    {
        $this->_version = $version;
        return $this;
    }

    /**
     * Set Use SSL Flag
     *
     * @return \WC\JQueryHelperBundle\JQuery\Library
     */
    public function setSsl($flag)
    {
        $this->_useSsl = (bool) $flag;
        return $this;
    }

    /**
     * Are we using the SSL?
     *
     * @return boolean
     */
    public function useSsl()
    {
        return $this->_useSsl;
    }

    /**
     * Set path to local library
     *
     * @param  string $path
     * @return \WC\JQueryHelperBundle\JQuery\Library
     */
    public function setLocalPath($path)
    {
        if ($path !== false) {
            $this->_libraryLocalPath = (string) $path;
        }
        return $this;
    }

    /**
     * Get local path to jQuery
     *
     * @return string
     */
    public function getLocalPath()
    {
        return $this->_libraryLocalPath;
    }

    /**
     * Are we using a local path?
     *
     * @return boolean
     */
    public function useLocalPath()
    {
        return (null === $this->_libraryLocalPath) ? false : true;
    }

    /**
     * Render javascript code for include library.
     *
     * @return string
     */
    public function render()
    {
        $source = $this->useLocalPath() ? $this->getLocalPath() : $this->getLibraryPath();
        $script = '<script type="text/javascript" src="' . $source . '"></script>' . PHP_EOL;
        return $script;
    }

    /**
     * Internal function that constructs the include path of the jQuery UI library.
     *
     * @return string
     */
    public function getLibraryPath()
    {
        if ($this->_libraryPath == null) {
            $this->_libraryPath = $this->_getLibraryBaseCdnUri()
                                . static::CDN_SUBFOLDER_GOOGLE
                                . $this->getVersion()
                                . static::CDN_PATH_GOOGLE;
        }
        return $this->_libraryPath;
    }

    /**
     * @return string
     */
    protected function _getLibraryBaseCdnUri()
    {
        $baseUri = $this->useSsl() == true
                 ? self::CDN_BASE_GOOGLE_SSL
                 : self::CDN_BASE_GOOGLE;
        return $baseUri;
    }
}