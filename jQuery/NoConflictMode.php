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
 * NoConflictMode Class.
 *
 * @author  naydav <web@naydav.com>
 */
class NoConflictMode implements Renderer
{
    /**
     * jQuery no Conflict Mode
     *
     * @see       http://docs.jquery.com/Using_jQuery_with_Other_Libraries
     * @var       Boolean Status of noConflict Mode
     */
    protected $_noConflictMode;

    /**
     * jQuery no Conflict Mode Handler
     *
     * @see       http://docs.jquery.com/Using_jQuery_with_Other_Libraries
     * @var       String Instead of $ to overcome conflicts
     */
    protected $_noConflictModeHandler;

    /**
     * Enable/Disable the jQuery internal noConflict Mode to work with
     * other Javascript libraries.
     *
     * @link http://docs.jquery.com/Using_jQuery_with_Other_Libraries
     * @param Boolean
     * @return void
     */
    public function setNoConflictMode($flag)
    {
        $this->_noConflictMode = (bool) $flag;
    }

    /**
     * Return current status of the jQuery no Conflict Mode
     *
     * @return Boolean
     */
    public function getNoConflictMode()
    {
        return $this->_noConflictMode;
    }

    /**
     * Set jQuery noConflict mode handler.
     * Will setup jQuery in the variable
     * $noConflictModeHandler instead of $ to overcome conflicts.
     *
     * @param string $noConflictModehandler
     * @return void
     */
    public function setNoConflictModeHandler($noConflictModeHandler)
    {
        $this->_noConflictModeHandler = $noConflictModeHandler;
    }

    /**
     * Return jQuery noConflict mode handler.
     *
     * @return String
     */
    public function getNoConflictModeHandler()
    {
        return $this->_noConflictModeHandler;
    }
    
    /**
     * Generate javascript for set No conflict mode.
     *
     * @return string
     */
    public function render()
    {
        if (! $this->getNoConflictMode()) {
            return '';
        }
        return sprintf(
            '<script type="text/javascript">var %s = jQuery.noConflict();</script>%s',
            $this->getNoConflictModeHandler(),
            PHP_EOL
       );
    }
}