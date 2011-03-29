<?php
/**
 * CMF for web applications based on
 * Symfony 2, Domain Model DDD, Doctrine 2 (Doctrine Extension)
 *
 * @copyright  Copyright (c) 2011 Valery Nayda aka naydav <web@naydav.com>
 * @link  http://www.webcreator.kiev.ua
 * @license  http://www.gnu.org/licenses/gpl-3.0.html  GNU GPLv3
 */

namespace WC\JQueryHelperBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Component\Config\FileLocator,
    Symfony\Component\Yaml\Yaml;

/**
 * JQueryHelperExtension.
 *
 * @author  naydav <web@naydav.com>
 */
class JQueryHelperExtension extends Extension
{
    /**
     * Loads the JQueryHelper configuration.
     *
     * @param array            $configs   An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // load default config
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');
        $defaultConfig = Yaml::load($fileLocator->locate('default.yml'));

        // build main config
        foreach ($configs as $config) {
            $config = $this->_mergeOptions($defaultConfig, $config);
            // set parametrs to container
            $this->_setParametrsToContainer($config, $container);
        }
        
        // load dependency injection config
        $loader = new XmlFileLoader($container, $fileLocator);
        $loader->load('helper.xml');
    }

    /**
     * Simple method to merge two configuration arrays
     *
     * @param  array $current
     * @param  array $options
     * @return array
     */
    protected function _mergeOptions(array $current, array $options)
    {
        foreach ($options as $key => $option) {
            $current[$key] = \is_array($option)
                           ? \array_merge($current[$key], $option)
                           : $option;
        }
        return $current;
    }
    
    /**
     * Set parametrs into container.
     *
     * @param array            $config    An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function _setParametrsToContainer($config, $container)
    {
        foreach ($config as $blockName => $block) {
            $blockName = sprintf('templating.%s', $blockName);
            if (\is_array($block)) {
                foreach ($block as $optionName => $option) {
                    $optionName = sprintf('%s.%s', $blockName, $optionName);
                    $container->setParameter($optionName, $option);
                }
            } else {
                $container->setParameter($blockName, $block);
            }
        }
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'j_query_helper';
    }
}