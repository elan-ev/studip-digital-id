<?php

/**
 * 001_add_tables.php - Stud.IP plugin for digital campus card
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

class AddTables extends Migration {
    public function up()
    {
        $db = DBManager::get();

        $db->exec("CREATE TABLE IF NOT EXISTS `digicard_tokens` (
            `user_id` VARCHAR(32) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
            `token` VARCHAR(32) NOT NULL,
            PRIMARY KEY (`user_id`)
        )");

        // Add global config to edit clear interval of videos in recycle bin
        $stmt = $db->prepare('REPLACE INTO config (field, value, section, type, `range`, mkdate, chdate, description)
            VALUES (:name, :value, :section, :type, :range, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), :description)');

        $stmt->execute([
            'name'        => 'DIGICARD_ISSUER_ID',
            'section'     => 'digicard',
            'description' => 'IssuerID von Google, siehe https://developers.google.com/wallet/generic/getting-started/onboarding-guide#1.-sign-up-for-a-google-wallet-api-issuer-account',
            'range'       => 'global',
            'type'        => 'string',
            'value'       => ''
        ]);
    }
}