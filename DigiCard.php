<?php

/**
 * DigiCard.php - Stud.IP plugin for digital campus card
 *
 * This file is part of the digital campus card Stud.IP plugin.
 *
 * @package    DigicardWebApp
 * @author     Till Glöggler <gloeggler@elan-ev.de>
 * @copyright  2025 ELAN e.V.
 * @license    https://www.gnu.org/licenses/agpl-3.0.html AGPL-3.0-or-later
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */
/*
 * DigiCard.class.php - Digitaler Studierendenausweis
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * @author      Till Glöggler <gloeggler@elan-ev.de>
 */

require_once 'bootstrap.php';

class DigiCard extends StudipPlugin implements SystemPlugin
{
    /**
     * Initialize a new instance of the plugin.
     */
    public function __construct()
    {
        parent::__construct();

        $template_path = $this->getPluginPath() . '/templates';
        $this->template_factory = new Flexi_TemplateFactory($template_path);

        if (Navigation::hasItem('/profile')) {
            // $digicard_nav->addSubNavigation('digicard', new Navigation(
            //         _('Digitaler Studierendenausweis'),
            //         PluginEngine::getURL('digicard/index/index/')
            //     )
            // );

            Navigation::insertItem('profile/digicard', new Navigation(
                _('Digitaler Studierendenausweis'),
                PluginEngine::getURL('digicard/index/index/'),
            ), '');
        }
    }

    /**
     * This method dispatches all actions.
     *
     * @param string   part of the dispatch path that was not consumed
     */
    public function perform($unconsumed_path)
    {
        URLHelper::removeLinkParam('cid');

        $trails_root = $this->getPluginPath() . '/app';

        $dispatcher = new Trails_Dispatcher(
            $trails_root,
            PluginEngine::getUrl('digicard/'),
            'index'
        );

        $dispatcher->current_plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
    }
}
