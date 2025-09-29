<?php

namespace diandi\addons;


use yii\helpers\FileHelper;

define("LB_API_DEBUG", false);
define("LB_SHOW_UPDATE_PROGRESS", true);

define("LB_TEXT_CONNECTION_FAILED", '服务器目前无法使用，请重试。');
define("LB_TEXT_INVALID_RESPONSE", '服务器返回无效响应，请联系支持。');
define("LB_TEXT_VERIFIED_RESPONSE", '已验证！感谢您的购买。');
define("LB_TEXT_PREPARING_MAIN_DOWNLOAD", '正在准备下载主要更新...');
define("LB_TEXT_MAIN_UPDATE_SIZE", '更新包大小：');
define("LB_TEXT_DONT_REFRESH", '（请不要刷新页面）。');
define("LB_TEXT_DOWNLOADING_MAIN", '正在下载更新包...');
define("LB_TEXT_UPDATE_PERIOD_EXPIRED", '您的更新期限已结束或许可证无效，请联系支持。');
define("LB_TEXT_UPDATE_PATH_ERROR", '文件夹没有读写权限或更新文件路径无法解析，请联系支持。');
define("LB_TEXT_MAIN_UPDATE_DONE", '下载并解压了更新包。');
define("LB_TEXT_UPDATE_EXTRACTION_ERROR", '更新zip提取失败。');
define("LB_TEXT_PREPARING_SQL_DOWNLOAD", '正在准备下载SQL更新...');
define("LB_TEXT_SQL_UPDATE_SIZE", 'SQL更新大小：');
define("LB_TEXT_DOWNLOADING_SQL", '正在下载SQL更新...');
define("LB_TEXT_SQL_UPDATE_DONE", 'SQL更新文件已下载。');
define("LB_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED", '应用程序已成功更新，但自动 SQL 导入失败，请手动在数据库中导入下载的 SQL 文件。');
define("LB_TEXT_UPDATE_WITH_SQL_IMPORT_DONE", '已成功更新应用程序并自动导入 SQL 文件。');
define("LB_TEXT_UPDATE_WITH_SQL_DONE", '应用程序已成功更新，请手动将下载的 SQL 文件导入数据库。');
define("LB_TEXT_UPDATE_WITHOUT_SQL_DONE", '应用程序已成功更新，没有 SQL 更新。');

if (!LB_API_DEBUG) {
    @ini_set('display_errors', 0);
}

if ((@ini_get('max_execution_time') !== '0') && (@ini_get('max_execution_time')) < 600) {
    @ini_set('max_execution_time', 600);
}
@ini_set('memory_limit', '256M');
class cloud
{
    private $product_id;
    private $api_url = 'http://listen.ddicms.cn/';
    private $api_key = '3A0F52ABE92AFD50587B';
    private $api_language = 'chinese';
    private $current_version;
    private $verify_type;
    private $verification_period = 365;
    private $current_path;
    private $root_path;
    private $license_file;


    public function __construct($root_path, $product_id, $current_version = '1.0.0', $verify_type = 'envato')
    {
        $this->product_id = $product_id;
        $this->current_version = $current_version;
        $this->verify_type = $verify_type;
        $this->root_path = $root_path;
        $this->current_path = $this->root_path;
        
        $this->license_file = $this->current_path . '/.lic';
    }

    /**
     * 检查本地授权文件是否存在
     * @return bool
     */
    public function check_local_license_exist()
    {
        return is_file($this->license_file);
    }

    /**
     * 获取当前版本号
     * @return mixed|string
     */
    public function get_current_version()
    {
        return $this->current_version;
    }


    /**
     * 调用API
     * @param $method
     * @param $url
     * @param $data
     * @return bool|string
     */
    private function call_api($method, $url, $data = null)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        $this_server_name = getenv('SERVER_NAME') ?:
            $_SERVER['SERVER_NAME'] ?:
                getenv('HTTP_HOST') ?:
                    $_SERVER['HTTP_HOST'];
        $this_http_or_https = ((
            (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on")) or
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and
                $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        ) ? 'https://' : 'http://');
        $this_url = $this_http_or_https . $this_server_name . $_SERVER['REQUEST_URI'];
        $this_ip = $this->get_ip_from_third_party();
//        getenv('SERVER_ADDR')?:
//            $_SERVER['SERVER_ADDR']?:
//                $this->get_ip_from_third_party()?:
//                    gethostbyname(gethostname());
//        var_dump($this->get_ip_from_third_party());
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json',
                'LB-API-KEY: ' . $this->api_key,
                'LB-URL: ' . $this_url,
                'LB-IP: ' . $this_ip,
                'LB-LANG: ' . $this->api_language)
        );
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($curl);
        if (!$result && !LB_API_DEBUG) {
            $rs = array(
                'status' => FALSE,
                'message' => LB_TEXT_CONNECTION_FAILED
            );
            return json_encode($rs);
        }

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($http_status != 200) {
            if (LB_API_DEBUG) {
                $temp_decode = json_decode($result, true);
                $rs = array(
                    'status' => FALSE,
                    'message' => ((!empty($temp_decode['error'])) ?
                        $temp_decode['error'] :
                        $temp_decode['message'])
                );
                return json_encode($rs);
            } else {
                $rs = array(
                    'status' => FALSE,
                    'http_status' => $http_status,
                    'url' => $url,
                    'message' => LB_TEXT_INVALID_RESPONSE
                );
                return json_encode($rs);
            }
        }
        curl_close($curl);
        return $result;
    }

    /**
     * 检查网络连接
     * @return mixed
     */
    public function check_connection()
    {
        $get_data = $this->call_api(
            'POST',
            $this->api_url . 'api/check_connection_ext'
        );
        $response = json_decode($get_data, true);
        return $response;
    }

    /**
     * 获取最新版本信息
     * @return mixed
     */
    public function get_latest_version()
    {
        $data_array = array(
            "product_id" => $this->product_id
        );
        $get_data = $this->call_api(
            'POST',
            $this->api_url . 'api/latest_version',
            json_encode($data_array)
        );
        $response = json_decode($get_data, true);
        return $response;
    }

    /**
     * 激活授权
     * @param $license
     * @param $client
     * @param $create_lic
     * @return mixed
     */
    public function activate_license($license, $client, $create_lic = true)
    {
        $data_array = array(
            "product_id" => $this->product_id,
            "license_code" => $license,
            "client_name" => $client,
            "verify_type" => $this->verify_type
        );
        $get_data = $this->call_api(
            'POST',
            $this->api_url . 'api/activate_license',
            json_encode($data_array)
        );

        $response = json_decode($get_data, true);

        if (!empty($create_lic)) {
            if ($response['status']) {
                $licfile = trim($response['lic_response']);
                file_put_contents($this->license_file, $licfile, LOCK_EX);
            } else {
                @chmod($this->license_file, 0777);
                if (is_writeable($this->license_file)) {
                    unlink($this->license_file);
                }
            }
        }
        return $response;
    }

    /**
     * 验证授权
     * @param $time_based_check
     * @param $license
     * @param $client
     * @return array|mixed
     */
    public function verify_license($time_based_check = false, $license = false, $client = false)
    {
        if (!empty($license) && !empty($client)) {
            $data_array = array(
                "product_id" => $this->product_id,
                "license_file" => null,
                "license_code" => $license,
                "client_name" => $client
            );
        } else {
            if (is_file($this->license_file)) {
                $data_array = array(
                    "product_id" => $this->product_id,
                    "license_file" => file_get_contents($this->license_file),
                    "license_code" => null,
                    "client_name" => null
                );
            } else {
                $data_array = array();
            }
        }
        $res = array('status' => TRUE, 'message' => LB_TEXT_VERIFIED_RESPONSE);
        if ($time_based_check && $this->verification_period > 0) {
            ob_start();
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $type = (int)$this->verification_period;
            $today = date('d-m-Y');
            if (empty($_SESSION["dd5cda4a8b066c7"])) {
                $_SESSION["dd5cda4a8b066c7"] = '00-00-0000';
            }
            if ($type == 1) {
                $type_text = '1 day';
            } elseif ($type == 3) {
                $type_text = '3 days';
            } elseif ($type == 7) {
                $type_text = '1 week';
            } elseif ($type == 30) {
                $type_text = '1 month';
            } elseif ($type == 90) {
                $type_text = '3 months';
            } elseif ($type == 365) {
                $type_text = '1 year';
            } else {
                $type_text = $type . ' days';
            }
            if (strtotime($today) >= strtotime($_SESSION["dd5cda4a8b066c7"])) {
                $get_data = $this->call_api(
                    'POST',
                    $this->api_url . 'api/verify_license',
                    json_encode($data_array)
                );
                $res = json_decode($get_data, true);
                if ($res['status'] == true) {
                    $tomo = date('d-m-Y', strtotime($today . ' + ' . $type_text));
                    $_SESSION["dd5cda4a8b066c7"] = $tomo;
                }
            }
            ob_end_clean();
        } else {
            $get_data = $this->call_api(
                'POST',
                $this->api_url . 'api/verify_license',
                json_encode($data_array)
            );
            $res = json_decode($get_data, true);
        }
        return $res;
    }

    /**
     * 撤销授权
     * @param $license
     * @param $client
     * @return mixed
     */
    public function deactivate_license($license = false, $client = false)
    {
        if (!empty($license) && !empty($client)) {
            $data_array = array(
                "product_id" => $this->product_id,
                "license_file" => null,
                "license_code" => $license,
                "client_name" => $client
            );
        } else {
            if (is_file($this->license_file)) {
                $data_array = array(
                    "product_id" => $this->product_id,
                    "license_file" => file_get_contents($this->license_file),
                    "license_code" => null,
                    "client_name" => null
                );
            } else {
                $data_array = array();
            }
        }
        $get_data = $this->call_api(
            'POST',
            $this->api_url . 'api/deactivate_license',
            json_encode($data_array)
        );
        $response = json_decode($get_data, true);
        if ($response['status']) {
            @chmod($this->license_file, 0777);
            if (is_writeable($this->license_file)) {
                unlink($this->license_file);
            }
        }
        return $response;
    }

    /**
     * 检查更新
     * @return mixed
     */
    public function check_update()
    {
        $data_array = array(
            "product_id" => $this->product_id,
            "current_version" => $this->current_version
        );
        $get_data = $this->call_api(
            'POST',
            $this->api_url . 'api/check_update',
            json_encode($data_array)
        );
        $response = json_decode($get_data, true);
        return $response;
    }

    public function download_update_api($update_id, $type, $version, $license = false, $client = false, $db_for_import = false)
    {
        $data_array = [];

        if (!empty($license) && !empty($client)) {
            $data_array = [
                "license_file" => null,
                "license_code" => $license,
                "client_name" => $client
            ];
        } elseif (is_file($this->license_file)) {
            $data_array = [
                "license_file" => file_get_contents($this->license_file),
                "license_code" => null,
                "client_name" => null
            ];
        }
        $version = str_replace(".", "_", $version);

        $source_size = $this->api_url . "api/get_update_size/main/" . $update_id;
        $main_update_url = $this->api_url . "api/download_update/main/" . $update_id;
        $sql_update_url = $this->api_url . "api/download_update/sql/" . $update_id;

        if ($type === 'main') {
            // 获取主更新文件大小
            $main_update_size = $this->get_remote_filesize($source_size);
            // 下载主更新文件
            $main_update_response = $this->curl_request($main_update_url, $data_array, $version);
            if ($main_update_response['status'] !== 1) {
                return [
                    'status' => 0,
                    'message' => 'Invalid response for main update',
                    'main_update_url' => $main_update_url,
                    'data' => $main_update_response
                ];
            }
            // 解压并提取主更新文件
            $destination = $this->root_path . "/update_main_" . $version . ".zip";
            if ($this->check_local_license_exist()) {
                $backName = $this->product_id . '-' . $this->current_version . '-' . date('Ymdhis');
                $back_root = \Yii::getAlias('@public/backup/' . $backName);
                /**
                 * 需要更新备份
                 */
                $this->back_dir($this->root_path,$back_root);
                /**
                 * 解压
                 */
                $this->extract_zip($destination, $this->root_path,$back_root);
            } else {
                return [
                    'status' => 0,
                    'message' => 'Invalid license file',
                    'main_update_url' => $main_update_url,
                    'data' => $main_update_response
                ];
            }
        }


        // 如果有 SQL 更新
        if ($type === 'sql') {
            $sql_source_size = $this->api_url . "api/get_update_size/sql/" . $update_id;
            $sql_update_size = $this->get_remote_filesize($sql_source_size);

            // 下载 SQL 更新文件
            $sql_update_response = $this->curl_request($sql_update_url, $data_array, $version);
            if ($sql_update_response['status'] !== 1) {
                return [
                    'status' => 0,
                    'message' => '当前版本无sql更新',
                    'sql_update_url' => $sql_update_url,
                    'data' => $sql_update_response
                ];
            }

            // 存储 SQL 更新文件
            $sql_destination = $this->root_path . "/update_sql_" . $version . ".sql";
//            file_put_contents($sql_destination, $sql_update_response['data']);
            /**
             * 执行 SQL
             */
            // 分割 SQL 文件中的多个语句
            $statements = explode(";", trim($sql_update_response['data']));

            $db = \Yii::$app->db;
            foreach ($statements as $statement) {
                if (trim($statement) !== '') {
                    try {
                        $command = $db->createCommand($statement . ';'); // 添加分号以确保完整语句
                        $command->execute();
                    } catch (\Exception $e) {
                        return [
                            'status' => 0,
                            'message' => 'Error executing statement: ' . $statement,
                            'error_message' => $e->getMessage()
                        ];
                    }
                }
            }
//            @chmod($sql_destination, 0777);
//            if (is_writable($sql_destination)) {
//                unlink($sql_destination);
//            }
        }

        return [
            'status' => 1,
            'message' => 'Update completed successfully',
            'sqlData' => $statements ?? null,
            'root_path' => $this->root_path,
            'sql_update_response' => $sql_update_response ?? null,
            'main_update_url' => $main_update_url ?? null,
            'sql_update_url' => $sql_update_url ?? null
        ];
    }

    /**
     * 文件下载
     * @param $url
     * @param $data
     * @param $version
     * @return array
     */
    private function curl_request($source, $version, $data_array = [])
    {
        /**
         * 设置内存限制
         */
        ini_set('memory_limit', '512M');
  
        $version = str_replace(".", "_", $version);
        $temp_progress = '';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_array);

        $this_server_name = getenv('SERVER_NAME') ?:
            $_SERVER['SERVER_NAME'] ?:
                getenv('HTTP_HOST') ?:
                    $_SERVER['HTTP_HOST'];

        $this_http_or_https = ((
            (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on")) or
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and
                $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        ) ? 'https://' : 'http://');

        $this_url = $this_http_or_https . $this_server_name . $_SERVER['REQUEST_URI'];
        $this_ip = $this->get_ip_from_third_party();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'LB-API-KEY: ' . $this->api_key,
            'LB-URL: ' . $this_url,
            'LB-IP: ' . $this_ip,
            'LB-LANG: ' . $this->api_language
        ));

        if (LB_SHOW_UPDATE_PROGRESS) {
            curl_setopt($ch, CURLOPT_NOPROGRESS, false);
            curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, function ($resource, $download_size, $downloaded, $upload_size, $uploaded) use (&$temp_progress) {
                $temp_progress = "Downloaded: $downloaded of $download_size bytes";
                ob_flush();
            });
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        $destination = $this->root_path . "/update_main_" . $version . ".zip";
        if (!file_exists($this->root_path)){
            mkdir($this->root_path);
            @chmod($this->root_path, 0777);
        }
        $file = fopen($destination, "w+");
        if (!$file) {
            return [
                'status' => 0,
                'message' => LB_TEXT_UPDATE_PATH_ERROR,
            ];
        }

        curl_setopt($ch, CURLOPT_FILE, $file);

        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_status != 200) {
            if ($http_status == 401) {
                curl_close($ch);
                return [
                    'status' => 0,
                    'message' => LB_TEXT_UPDATE_PERIOD_EXPIRED,
                ];
            } else {
                curl_close($ch);
                return [
                    'status' => 0,
                    'message' => LB_TEXT_INVALID_RESPONSE,
                ];
            }
        }

        curl_close($ch);
        if ($result){
            fputs($file, $result);
            fclose($file);
        }


        return [
            'http_status' => $http_status,
            'status' => 1,
            'data' => $destination
        ];
    }


    private function parse_file_size($response)
    {
        $filesize = curl_getinfo($response, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        if ($filesize) {
            switch ($filesize) {
                case $filesize < 1024:
                    $size = $filesize . ' B';
                    break;
                case $filesize < 1048576:
                    $size = round($filesize / 1024, 2) . ' KB';
                    break;
                case $filesize < 1073741824:
                    $size = round($filesize / 1048576, 2) . ' MB';
                    break;
                case $filesize < 1099511627776:
                    $size = round($filesize / 1073741824, 2) . ' GB';
                    break;
            }
            return $size;
        }
        return 'Unknown size';
    }

    private function extract_zip($zip_file, $root_path, $back_root)
    {
        //        Zstandard
        $zip = new \ZipArchive();
        $res = $zip->open($zip_file);
        if ($res === TRUE) {
            $zip->extractTo($root_path);
            $zip->close();
            unlink($zip_file);
            /**
             * 如果back_root目录存在configs目录，就复制到根目录
             */
            $configs_dir = $back_root . '/configs';
            if (file_exists($configs_dir)) {
                @chmod($configs_dir, 0777);
                FileHelper::copyDirectory($configs_dir, $this->root_path. '/configs');
            }
        }
    }

    /**
     * 备份更新目录文件
     * @param $root_path
     * @return void
     */
    private function back_dir($root_path, $back_root)
    {
        if (!file_exists($root_path)) {
            return;
        }
        /**
         * 备份目录
         */
        // 定义排除规则
        $except = [
            '^.*\\.zip$',  // 匹配以 .zip 结尾的字符串
            '^.*\\.lic$',  // 匹配以 .lic 结尾的字符串
            '^update_main_.+',  // 匹配以 update_main_ 开头，后面至少有一个字符的字符串
            '^update_sql_.+',  // 匹配以 update_sql_ 开头的任何字符串
        ];

        $this->copyFiles($root_path, $back_root, $except);

        $public = \Yii::getAlias('@public');
        if (file_exists($public . '/shop.html')) {
            copy($public . '/shop.html', $back_root. '/shop.html');
        }
        if (file_exists($public . '/backend.html')) {
            copy($public . '/backend.html', $back_root. '/backend.html');
        }
        /**
         * 只有前端资源文件才全量更新
         */
        if (strpos($root_path, 'resource') !== false) {
            $this->removeDirectoryWithExclusions($root_path, $except);
        }
    }

    //    copyFiles
    private function copyFiles($root_path, $destinationDir, $exclusions)
    {
        if (!is_dir($root_path)) {
            return;
        }
        $files = FileHelper::findFiles($root_path);
        foreach ($files as $file) {
            // 检查是否排除当前文件或目录
            $exclude = false;
            foreach ($exclusions as $pattern) {
                if (preg_match("/" . $pattern . "/", $file)) {
                    $exclude = true;
                    break;
                }
            }
            if (!$exclude) {
                $relativePath = substr($file, strlen($root_path) + 1);
                $destinationPath = $destinationDir . '/' . $relativePath;
                if (!is_dir(dirname($destinationPath))) {
                    mkdir(dirname($destinationPath), 0755, true);
                }
                copy($file, $destinationPath);
            }
        }
    }

    /**
     * 删除目录，但排除特定文件或目录
     * @param $dir
     * @param $exclusions
     * @return void
     */
    function removeDirectoryWithExclusions($dir, $exclusions)
    {
        if (!is_dir($dir)) {
            return;
        }
        $files = FileHelper::findFiles($dir);
        foreach ($files as $fileInfo) {
            // 检查是否排除当前文件或目录
            $exclude = false;
            foreach ($exclusions as $pattern) {
                /**
                 * 增加文件路径存在configs判断
                 */
                if (preg_match("/" . $pattern . "/", $fileInfo) || strpos($fileInfo, 'configs') !== false) {
                    $exclude = true;
                    break;
                }
            }

            if (!$exclude) {
                if (is_dir($fileInfo)) {
                    rmdir($fileInfo);
                } else {
                    unlink($fileInfo);
                }
            }
        }
    }


    /**
     * Progress callback function
     * @param $resource
     * @param $download_size
     * @param $downloaded
     * @param $upload_size
     * @param $uploaded
     * @return void
     */
    private function progress($resource, $download_size, $downloaded, $upload_size, $uploaded)
    {
        static $prev = 0;
        if ($download_size == 0) {
            $progress = 0;
        } else {
            $progress = round($downloaded * 100 / $download_size);
        }
        if (($progress != $prev) && ($progress == 25)) {
            $prev = $progress;
            echo '<script>document.getElementById(\'prog\').value = 22.5;</script>';
//            ob_flush();
        }
        if (($progress != $prev) && ($progress == 50)) {
            $prev = $progress;
            echo '<script>document.getElementById(\'prog\').value = 35;</script>';
//            ob_flush();
        }
        if (($progress != $prev) && ($progress == 75)) {
            $prev = $progress;
            echo '<script>document.getElementById(\'prog\').value = 47.5;</script>';
//            ob_flush();
        }
        if (($progress != $prev) && ($progress == 100)) {
            $prev = $progress;
            echo '<script>document.getElementById(\'prog\').value = 60;</script>';
//            ob_flush();
        }
    }

    private function get_ip_from_third_party()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://ipecho.net/plain");
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    private function get_remote_filesize($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_NOBODY, TRUE);
        $this_server_name = getenv('SERVER_NAME') ?:
            $_SERVER['SERVER_NAME'] ?:
                getenv('HTTP_HOST') ?:
                    $_SERVER['HTTP_HOST'];
        $this_http_or_https = ((
            (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on")) or
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and
                $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        ) ? 'https://' : 'http://');
        $this_url = $this_http_or_https . $this_server_name . $_SERVER['REQUEST_URI'];
        $this_ip = $this->get_ip_from_third_party();
//        getenv('SERVER_ADDR') ?:
//            $_SERVER['SERVER_ADDR'] ?:
//                $this->get_ip_from_third_party() ?:
//                    gethostbyname(gethostname());
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'LB-API-KEY: ' . $this->api_key,
                'LB-URL: ' . $this_url,
                'LB-IP: ' . $this_ip,
                'LB-LANG: ' . $this->api_language)
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        $result = curl_exec($curl);
        $filesize = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        if ($filesize) {
            switch ($filesize) {
                case $filesize < 1024:
                    $size = $filesize . ' B';
                    break;
                case $filesize < 1048576:
                    $size = round($filesize / 1024, 2) . ' KB';
                    break;
                case $filesize < 1073741824:
                    $size = round($filesize / 1048576, 2) . ' MB';
                    break;
                case $filesize < 1099511627776:
                    $size = round($filesize / 1073741824, 2) . ' GB';
                    break;
            }
            return $size;
        }
    }


}
