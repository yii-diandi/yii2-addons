<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-21 13:50:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-21 19:01:09
 */

namespace diandi\addons;

use GuzzleHttp\Client;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidCallException;

class cloud extends BaseObject
{
    public static $apiUrl = 'http://www.dandicloud.com';

    public static $username;

    public static $password;

    public static $bloc_id;

    public static $store_id;

    public static $client_secret;

    public static $access_token;
    public static $uid;
    public static $refresh_token;
    public static $expires_in;
    public static $auth_key = 'diandi—auth-token';

    public static $header = [
        'ContentType' => 'application/x-www-form-urlencoded',
    ];

    public static function __init()
    {
        $confPath = Yii::getAlias('@common/config/diandi.php');
        if (file_exists($confPath)) {
            $config = require $confPath;
            self::$username = $config['username'];
            self::$password = $config['password'];
            self::$bloc_id = (int) $config['bloc_id'];
            self::$store_id = (int) $config['store_id'];
            // 鉴权
            self::apartmentLogin(self::$username, self::$password, self::$bloc_id, self::$store_id);
        } else {
            self::putAuthConf();
        }
    }

    /**
     * 统一请求
     *
     * @param [type] $datas   请求参数
     * @param [type] $url     请求地址
     * @param array  $params  地址栏的参数
     * @param array  $headers 请求头部
     *
     * @return void
     * @date 2022-05-11
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function postHttp($datas, $url, $params = [], $headers = [])
    {
        $headersToeken = array_merge(self::$header, [
            'access-token' => self::$access_token,
            'store-id' => self::$store_id,
            'bloc-id' => self::$bloc_id,
        ]);
        $headers = array_merge(self::$header, $headers, $headersToeken);
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => self::$apiUrl,
            // You can set any number of default request options.
            'timeout' => 10,
        ]);

        $res = $client->request('POST', $url, [
            'form_params' => $datas,
            'headers' => $headers,
        ]);

        $body = $res->getBody();
        $remainingBytes = $body->getContents();

        return self::analysisRes(json_decode($remainingBytes, true));
    }

    public static function createData($data)
    {
        return $data;
    }

    // 解析返回的内容
    public static function analysisRes($Res)
    {
        if ((int) $Res['errcode']) {
            throw new InvalidCallException($Res['message']);
        } else {
            $data = [
                  'code' => $Res['resultCode'],
                  'content' => $Res['reason'],
              ];

            return $Res;
        }
    }

    /**
     * 鉴权V1.0.
     *
     * @param [type] $password
     *
     * @return void
     */
    public static function apartmentLogin($username, $password, $client_id, $client_secret)
    {
        $key = self::$auth_key;
        $tokenIdS = Yii::$app->cache->get($key);

        if (!empty($tokenIdS['access_token'])) {
            self::$access_token = $tokenIdS['access_token'];
            self::$uid = $tokenIdS['uid'];
            self::$refresh_token = $tokenIdS['refresh_token'];
            self::$expires_in = $tokenIdS['expires_in'];
        } else {
            $data = self::createData([
                'username' => $username,
                'password' => $password,
            ]);
            $Res = self::postHttp($data, '/api/user/login');
            if ($Res['code'] === 200) {
                self::$access_token = $Res['data']['access_token'];
                self::$uid = $Res['data']['uid'];
                self::$refresh_token = $Res['data']['refresh_token'];
                self::$expires_in = $Res['data']['expiration_time'];
                Yii::$app->cache->set($key, [
                    'access_token' => $Res['data']['access_token'],
                    'uid' => $Res['data']['member']['member_id'],
                    'refresh_token' => $Res['data']['refresh_token'],
                    'expires_in' => $Res['data']['expiration_time'],
                ], $Res['data']['expiration_time']);
            }
        }
    }

    public static function putAuthConf($username = '', $password = '', $bloc_id = '', $store_id = '')
    {
        $confPath = yii::getAlias('@common/config/diandi.php');
        if (!file_exists($confPath)) {
            $config = self::local_auth_config();
            $config = str_replace([
                '{username}', '{password}', '{bloc_id}', '{store_id}',
            ], [
                $username, $password, $bloc_id, $store_id,
            ], $config);
            file_put_contents($confPath, $config);
        }
    }

    public static function checkAuth($addons)
    {
        $data = self::createData([
            'addons' => $addons,
            'url' => Yii::$app->request->hostInfo,
        ]);

        $Res = self::postHttp($data, '/api/diandi_cloud/addons/authlist');
        if ($Res['code'] === 200) {
            return $Res['data'];
        }
    }

    public static function local_auth_config()
    {
        $cfg = <<<EOF
<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-18 16:51:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-28 10:21:41
 */

return [
    'username' => '{username}',
    'password' => '{password}',
    'bloc_id' => '{bloc_id}',
    'store_id' => '{store_id}',
];
EOF;

        return trim($cfg);
    }
}

cloud::__init();
