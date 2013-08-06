<?php
// {{{ICINGA_LICENSE_HEADER}}}
/**
 * Icinga 2 Web - Head for multiple monitoring frontends
 * Copyright (C) 2013 Icinga Development Team
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * @copyright 2013 Icinga Development Team <info@icinga.org>
 * @author Icinga Development Team <info@icinga.org>
 */
// {{{ICINGA_LICENSE_HEADER}}}

/**
 * Module action controller
 */
namespace Icinga\Web;

use Icinga\Config\Config as IcingaConfig;
use Icinga\Application\Icinga;

/**
 * Base class for all module action controllers
 *
 * All Icinga Web module controllers should extend this class
 *
 * @copyright  Copyright (c) 2013 Icinga-Web Team <info@icinga.org>
 * @author     Icinga-Web Team <info@icinga.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class ModuleActionController extends ActionController
{
    protected $module;
    protected $module_dir;

    /**
     * Gives you this modules base directory
     *
     * @return string
     */
    public function getModuleDir()
    {
        if ($this->module_dir === null) {
            $this->module_dir = $this->getModule()->getBaseDir();
        }
        return $this->module_dir;
    }

    public function getModule()
    {
        if ($this->module === null) {
            $this->module = Icinga::app()->getModule(
                $this->module_name
            );
        }
        return $this->module;
    }

    /**
     * Translates the given string with the modules translation catalog
     *
     * @param  string $string The string that should be translated
     *
     * @return string
     */
    public function translate($string)
    {
        return mt($this->module_name, $string);
    }

    /**
     * This is where the module configuration is going to be loaded
     *
     * @return void
     */
    protected function loadConfig()
    {
        $this->config = IcingaConfig::module($this->module_name);
    }

    /**
     * Once dispatched we are going to place each modules output in a div
     * container having the icinga-module and the icinga-$module-name classes
     *
     * @return void
     */
    public function postDispatch()
    {
        parent::postDispatch();
        $this->_helper->layout()->moduleStart =
        '<div class="icinga-module module-'
          . $this->module_name
          . '">'
          . "\n"
          ;
        $this->_helper->layout()->moduleEnd = "</div>\n";
    }
}
