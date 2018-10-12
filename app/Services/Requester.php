<?php

namespace App\Services;

use App\User;
use \GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.07.2015
 * Time: 16:44
 */
class Requester {

    public static function sendRemoveUser($id)
    {
        //ICELANDIC.SCANDINAVER.ORG//
        $client = new Client([
            'base_uri' => Options::$icelandic,
            'curl' => [CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]
        ]);

        $response = $client->delete('/api/removeUser/'.$id);
        $response = json_decode($response->getBody());
        l(' на ' .Options::$icelandic. ' отправлены данные об удалении пользователя '.$id, 'success');

        if($response->success == '3')
            l(' ' .Options::$icelandic. ' пользователь ' . $id . ' удален ', 'success');
    }

    public static function createForumUser($params)
    {
        $client = new Client([
            'base_uri' => config('app.FORUM'),
            'curl' => [CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]
        ]);

        $response = $client->request('POST', '/api/adduser.php', [
            'form_params' => [
                'username' => $params->data['login'],
                'email' => $params->data['email'],
                'password' => $params->data['password'],
            ]
        ]);

        if($response->getBody()->getContents() == 'success')
            activity()->log('Пользователь '.$params->data['login'].' зарегистрирован на форуме');
        else
            activity()->log('Пользователь '.$params->data['login'].' - ошибка регистрации на форуме');
    }

    /**
     * @param array $data
     * @param $oldemail
     * @return bool
     * @internal param User $user
     */
    public static function updateForumUser(Array $data, $oldemail)
    {
        $client = new Client([
            'base_uri' => config('app.FORUM'),
            'curl' => [CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]
        ]);

        $response = $client->request('POST', '/api/updateuser.php', [
            'form_params' => [
                'username' => $data['login'],
                'email'    => $data['email'],
                'oldemail' => $oldemail,
                'password' => $data['password'],
            ]
        ]);

        if($response->getBody()->getContents() == 'success')
            activity()->log('forum user updated email - '.$data['email']);
        else
            activity()->log($response->getBody());


        return true;
    }


    public static function updateForumUserAvatar(User $user)
    {
        $client = new Client([
            'base_uri' => config('app.FORUM'),
            'curl' => [CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]
        ]);

        $response = $client->request('POST', '/api/updateuserphoto.php', [
            'form_params' => [
                'email'    => $user->email,
                'avatar'   => config('app.SITE').'/uploads/u/'.$user->photo,
            ]
        ]);

        if($response->getBody()->getContents() == 'success')
            activity()->log('forum user updated email - '.$user->email);
        else
            activity()->log($response->getBody());


        return true;
    }

    public static function loginForumUser($params)
    {
        $client = new Client([
            'base_uri' => config('app.FORUM'),
            'curl' => [CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false]
        ]);

        $response = $client->request('POST', '/index.php?login/login', [
            'form_params' => [
                '_xfToken'=> '1518553156,7fbce47c7ede95773cee960ebcb2fa9d',
                'login' => $params['username'],
                'password' => $params['password'],

            ]
        ]);
       // print($response->getBody()->getContents());die();
        $cookies = $response->getHeader('set-cookie');
      //  d($cookies);
        foreach ($cookies as $cookie) {
            $newCookie =\GuzzleHttp\Cookie\SetCookie::fromString($cookie);
            setcookie($newCookie->getName(), $newCookie->getValue(), time() + (365 * 86400), '/', '.'.Options::$site);
        }

        return true;
    }
}