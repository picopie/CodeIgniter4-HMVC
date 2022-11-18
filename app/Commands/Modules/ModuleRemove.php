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

namespace App\Commands\Modules;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ModuleRemove extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'HMVC Modules';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'module:remove';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Important! Before remove module via CLI make sure again \'cause module cannot restore.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'module:remove [ModuleRemove]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'ModuleRemove' => 'Remove HMVC module'
    ];

    protected $module_path = ROOTPATH . 'Modules';

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        helper('inflector');

        $module = array_shift($params);
        $dir = array_diff(scandir($this->module_path), ['.', '..']);

        CLI::write('Input module name');

        // Check module in ROOTPATH/Modules
        if (! is_dir($this->module_path)) {
            CLI::write('ModuleS in ROOTPATH not initialized', 'yellow');
        }

        if (empty($module)) {
            $module = pascalize(CLI::prompt('Module name'));
        }

        if (empty($module)) {
            CLI::error('You must provide a module name');
            return false;
        }

        if (! array_search($module, $dir)) {
            CLI::error('Module: \''.$module.'\' not exists');
            return false;
        }

        if (CLI::prompt('Remove \''.$module.'\' module?', ['y', 'n']) === 'y') {
            if (CLI::prompt('Are you sure?', ['yes', 'no']) === 'yes') {

                // Remove file
                rmdir($this->module_path.'/'.$module);
                CLI::write('Module '.$module. ' has been deleted.', 'green');

            } else {
                CLI::write('You must input \'yes\' to confirm!');
            }
        }
    }
}
