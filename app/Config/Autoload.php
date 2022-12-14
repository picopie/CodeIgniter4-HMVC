<?php

/**
 * CodeIgniter
 *
 * Copyright (c) 2014-2019 British Columbia Institute of Technology
 * Copyright (c) 2019-2022 CodeIgniter Foundation
 *
 * @author     CodeIgniter Dev Team, Enrico Pradana
 * @copyright  2019-2022 CodeIgniter Foundation
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       https://codeigniter.com
 * @since      Version 4.2.10
 * @filesource
 */

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTOLOADER CONFIGURATION
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
    /**
     * -------------------------------------------------------------------
     * Namespaces
     * -------------------------------------------------------------------
     * This maps the locations of any namespaces in your application to
     * their location on the file system. These are used by the autoloader
     * to locate files the first time they have been instantiated.
     *
     * The '/app' and '/system' directories are already mapped for you.
     * you may change the name of the 'App' namespace if you wish,
     * but this should be done prior to creating any namespaced classes,
     * else you will need to modify all of those classes for this to work.
     *
     * Prototype:
     *```
     *   $psr4 = [
     *       'CodeIgniter' => SYSTEMPATH,
     *       'App'	       => APPPATH
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
    ];

    public function __construct()
    {
        $modules = self::modulesPath();
        foreach ($modules as $module => $path) {
            $this->psr4 = array_merge($this->psr4, array(
                "Modules\\$module"      => $path,
            ));
        }

        parent::__construct();
    }

    /**
     * Fetch all modules paths
     * @return array
     */
    public static function modulesPath(): array
    {
        // If ROOTPATH not found return array
        if (! is_dir(ROOTPATH)) {
            return array();
        } else if (! is_dir(ROOTPATH . 'Modules')) {
            return array();
        }

        $paths = array();
        $dir = array_diff(scandir(ROOTPATH . 'Modules'), array(".", ".."));

        foreach ($dir as $item) {
            $paths[$item] = ROOTPATH.'Modules/'.$item.'/';
        }

        return $paths;
    }

    /**
     * -------------------------------------------------------------------
     * Class Map
     * -------------------------------------------------------------------
     * The class map provides a map of class names and their exact
     * location on the drive. Classes loaded in this manner will have
     * slightly faster performance because they will not have to be
     * searched for within one or more directories as they would if they
     * were being autoloaded through a namespace.
     *
     * Prototype:
     *```
     *   $classmap = [
     *       'MyClass'   => '/path/to/class/file.php'
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * -------------------------------------------------------------------
     * Files
     * -------------------------------------------------------------------
     * The files array provides a list of paths to __non-class__ files
     * that will be autoloaded. This can be useful for bootstrap operations
     * or for loading functions.
     *
     * Prototype:
     * ```
     *	  $files = [
     *	 	   '/path/to/my/file.php',
     *    ];
     * ```
     *
     * @var array<int, string>
     */
    public $files = [];
}

