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

class ModuleList extends BaseCommand
{
    /**
     * The Modules's Group
     *
     * @var string
     */
    protected $group = 'HMVC Modules';

    /**
     * The Modules's Name
     *
     * @var string
     */
    protected $name = 'module:list';

    /**
     * The Modules's Description
     *
     * @var string
     */
    protected $description = 'Show all list of registered modules';

    /**
     * The Modules's Usage
     *
     * @var string
     */
    protected $usage = 'module:list [ModuleList]';

    /**
     * The Modules's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'ModuleList' => 'The module list.',
    ];

    /**
     * The Modules's Options
     *
     * @var array
     */
    protected $options = [];

    protected $module_path = ROOTPATH . 'Modules';

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {

        if (! is_dir(ROOTPATH . 'Modules')) {
            CLI::write("Directory \"Modules\" not found");
            return false;
        }

        if (empty(glob($this->module_path.'/*', GLOB_ONLYDIR))) {
            CLI::write('Nothing modules in here');
            return false;
        }

        $dir = glob($this->module_path.'/*', GLOB_ONLYDIR);
        
        $tbody = [];

        $i = 1;
        foreach ($dir as $item) {
            $tbody[] = [$i, pathinfo($item, PATHINFO_FILENAME), pathinfo($item, PATHINFO_DIRNAME)];
            $i++;
        }

        $thead = ['#', 'Module Name', 'Module Path'];
        CLI::table($tbody, $thead);
    }
}
