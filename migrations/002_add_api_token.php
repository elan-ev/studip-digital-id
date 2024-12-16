<?php

class AddApiToken extends Migration {
    public function up()
    {
        $db = DBManager::get();

        // Add global config to edit clear interval of videos in recycle bin
        $stmt = $db->prepare('REPLACE INTO config (field, value, section, type, `range`, mkdate, chdate, description)
            VALUES (:name, :value, :section, :type, :range, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), :description)');

        $stmt->execute([
            'name'        => 'DIGICARD_API_TOKEN',
            'section'     => 'digicard',
            'description' => 'Digicard API Token to fetch user data from WebApp',
            'range'       => 'global',
            'type'        => 'string',
            'value'       => 'myapitoken_1234'
        ]);
    }
}