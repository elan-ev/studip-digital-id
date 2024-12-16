<?php
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
