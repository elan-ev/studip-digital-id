<?php

use DigiCard\DigitalIdCard;
use DigiCard\DigicardTokens;
use DigiCard\User as DigiCardUser;

class IndexController extends StudipController
{
    function index_action()
    {
        global $user;

        Navigation::activateItem('/profile/digicard');

        $db_token = DigicardTokens::findOneByUser_id($user->id);

        $this->token = md5(uniqid());

        if (!empty($db_token)) {
            $this->token = $db_token->token;
        } else {
            $db_token = new DigicardTokens();
            $db_token->setData([
                'token' => $this->token,
                'user_id' => $user->id
            ]);

            $db_token->store();
        }

        if (false || !empty($user->matriculation_number)) {
            $card = new DigitalIdCard(
                'class_suffix',
                \Config::get()->DIGICARD_ISSUER_ID,
                __DIR__ . '/../../credentials/project.json',
                PluginEngine::getUrl('digicard/index/verify/'. $this->token),
            );

            $this->digicard_user = DigiCardUser::getDigicardUser($user, $this->token);

            $this->wallet_link = $card->getWalletLink($this->digicard_user);
        } else {
            $this->redirect('dispatch.php');
        }
    }

    function student_photo_action($token)
    {
        $db_token = DigicardTokens::findOneByToken($token);

        if (!$db_token) {
            throw new \AccessDeniedException();
        }

        $filename = \Avatar::getAvatar($db_token->user_id)->getFilename(\Avatar::NORMAL);

        // Get the contents of the file
        $contents = file_get_contents($filename);

        // Detect the MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->buffer($contents);

        // Set the appropriate header
        header("Content-Type: $mime_type");

        // Output the contents
        echo $contents;
        exit;
    }

    function verify_action($token)
    {
        $db_token = DigicardTokens::findOneByToken($token);

        if (!$db_token) {
            throw new \AccessDeniedException();
        }

        $user = \User::find($db_token->user_id);

        $this->set_layout(null);

        $this->digicard_user = DigiCardUser::getDigicardUser($user, $token);

        $this->token = $db_token->token;
    }

    function user_action($user_id)
    {

        $api_token = Request::get('api_token');

        if (!$api_token || $api_token!= \Config::get()->DIGICARD_API_TOKEN) {
            throw new \AccessDeniedException();
        }

        $user = User::findOneByUser_id($user_id);

        if (!$user_id) {
            $this->render_json(['error' => 'User not found']);
            return;
        }

        $db_token = DigicardTokens::findOneByUser_id($user->id);

        $token = md5(uniqid());

        if (!empty($db_token)) {
            $token = $db_token->token;
        } else {
            $db_token = new DigicardTokens();
            $db_token->setData([
                'token' => $token,
                'user_id' => $user->id
            ]);

            $db_token->store();
        }

        $this->render_json(DigiCardUser::getDigicardUser($user, $token)->toArray());
    }
}