<?php

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