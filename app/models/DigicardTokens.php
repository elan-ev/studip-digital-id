<?php

namespace DigiCard;

class DigicardTokens extends \SimpleORMap
{
    protected static function configure($config = [])
    {
        $config['db_table'] = 'digicard_tokens';

        parent::configure($config);
    }
}