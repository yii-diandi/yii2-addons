<?php

namespace diandi\addons;


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
    private $addons;
    private $product_id;
    private $api_url = 'http://listen.ddicms.cn/';
    private $api_key = '3A0F52ABE92AFD50587B';
    private $api_language = 'chinese';
    private $current_version;
    private $verify_type;
    private $verification_period  = 365;
    private $current_path;
    private $root_path;
    private $license_file;

    public function __construct($addons,$product_id,$current_version = '1.0.0',$verify_type= 'envato')
    {
            $config = require $confPath;
            $this->product_id = $product_id;
            $this->current_version = $current_version;
            $this->verify_type = $verify_type;
            $this->root_path = \Yii::getAlias('@addons/' . $this->addons);
            $this->current_path = $this->root_path;
            $this->license_file = $this->current_path . '/.lic';
    }

    public function check_local_license_exist()
    {
        return is_file($this->license_file);
    }

    public function get_current_version()
    {
        return $this->current_version;
    }

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
                    'message' => LB_TEXT_INVALID_RESPONSE
                );
                return json_encode($rs);
            }
        }
        curl_close($curl);
        return $result;
    }

    public function check_connection()
    {
        $get_data = $this->call_api(
            'POST',
            $this->api_url . 'api/check_connection_ext'
        );
        $response = json_decode($get_data, true);
        return $response;
    }

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
        var_dump($response);

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

    public function download_update($update_id, $type, $version, $license = false, $client = false, $db_for_import = false)
    {
        if (!empty($license) && !empty($client)) {
            $data_array = array(
                "license_file" => null,
                "license_code" => $license,
                "client_name" => $client
            );
        } else {
            if (is_file($this->license_file)) {
                $data_array = array(
                    "license_file" => file_get_contents($this->license_file),
                    "license_code" => null,
                    "client_name" => null
                );
            } else {
                $data_array = array();
            }
        }
        ob_end_flush();
        ob_implicit_flush(true);
        $version = str_replace(".", "_", $version);
        ob_start();
        $source_size = $this->api_url . "api/get_update_size/main/" . $update_id;
        echo LB_TEXT_PREPARING_MAIN_DOWNLOAD . "<br>";
        if (LB_SHOW_UPDATE_PROGRESS) {
            echo '<script>document.getElementById(\'prog\').value = 1;</script>';
        }
//        ob_flush();
        echo LB_TEXT_MAIN_UPDATE_SIZE . " " . $this->get_remote_filesize($source_size) . " " . LB_TEXT_DONT_REFRESH . "<br>";
        if (LB_SHOW_UPDATE_PROGRESS) {
            echo '<script>document.getElementById(\'prog\').value = 5;</script>';
        }
//        ob_flush();
        $temp_progress = '';
        $ch = curl_init();
        $source = $this->api_url . "api/download_update/main/" . $update_id;
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
//        getenv('SERVER_ADDR')?:
//            $_SERVER['SERVER_ADDR']?:
//                $this->get_ip_from_third_party()?:
//                    gethostbyname(gethostname());
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'LB-API-KEY: ' . $this->api_key,
                'LB-URL: ' . $this_url,
                'LB-IP: ' . $this_ip,
                'LB-LANG: ' . $this->api_language)
        );
        if (LB_SHOW_UPDATE_PROGRESS) {
            curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, array($this, 'progress'));
        }
        if (LB_SHOW_UPDATE_PROGRESS) {
            curl_setopt($ch, CURLOPT_NOPROGRESS, false);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        echo LB_TEXT_DOWNLOADING_MAIN . "<br>";
        if (LB_SHOW_UPDATE_PROGRESS) {
            echo '<script>document.getElementById(\'prog\').value = 10;</script>';
        }
//        ob_flush();
        $data = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status != 200) {
            if ($http_status == 401) {
                curl_close($ch);
                exit("<br>" . LB_TEXT_UPDATE_PERIOD_EXPIRED);
            } else {
                curl_close($ch);
                exit("<br>" . LB_TEXT_INVALID_RESPONSE);
            }
        }
        curl_close($ch);
        $destination = $this->root_path . "/update_main_" . $version . ".zip";
        $file = fopen($destination, "w+");
        if (!$file) {
            exit("<br>" . LB_TEXT_UPDATE_PATH_ERROR);
        }
        fputs($file, $data);
        fclose($file);
        if (LB_SHOW_UPDATE_PROGRESS) {
            echo '<script>document.getElementById(\'prog\').value = 65;</script>';
        }
//        ob_flush();
        $zip = new \ZipArchive();
        $res = $zip->open($destination);
        if ($res === TRUE) {
            $zip->extractTo($this->root_path . "/");
            $zip->close();
            unlink($destination);
            echo LB_TEXT_MAIN_UPDATE_DONE . "<br><br>";
            if (LB_SHOW_UPDATE_PROGRESS) {
                echo '<script>document.getElementById(\'prog\').value = 75;</script>';
            }
//            ob_flush();
        } else {
            echo LB_TEXT_UPDATE_EXTRACTION_ERROR . "<br><br>";
//            ob_flush();
        }
        if ($type == true) {
            $source_size = $this->api_url . "api/get_update_size/sql/" . $update_id;
            echo LB_TEXT_PREPARING_SQL_DOWNLOAD . "<br>";
//            ob_flush();
            echo LB_TEXT_SQL_UPDATE_SIZE . " " . $this->get_remote_filesize($source_size) . " " . LB_TEXT_DONT_REFRESH . "<br>";
            if (LB_SHOW_UPDATE_PROGRESS) {
                echo '<script>document.getElementById(\'prog\').value = 85;</script>';
            }
//            ob_flush();
            $temp_progress = '';
            $ch = curl_init();
            $source = $this->api_url . "api/download_update/sql/" . $update_id;
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
//            getenv('SERVER_ADDR') ?:
//                $_SERVER['SERVER_ADDR'] ?:
//                    $this->get_ip_from_third_party() ?:
//                        gethostbyname(gethostname());
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'LB-API-KEY: ' . $this->api_key,
                    'LB-URL: ' . $this_url,
                    'LB-IP: ' . $this_ip,
                    'LB-LANG: ' . $this->api_language)
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            echo LB_TEXT_DOWNLOADING_SQL . "<br>";
            if (LB_SHOW_UPDATE_PROGRESS) {
                echo '<script>document.getElementById(\'prog\').value = 90;</script>';
            }
//            ob_flush();
            $data = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_status != 200) {
                curl_close($ch);
                exit(LB_TEXT_INVALID_RESPONSE);
            }
            curl_close($ch);
            $destination = $this->root_path . "/update_sql_" . $version . ".sql";
            $file = fopen($destination, "w+");
            if (!$file) {
                exit(LB_TEXT_UPDATE_PATH_ERROR);
            }
            fputs($file, $data);
            fclose($file);
            echo LB_TEXT_SQL_UPDATE_DONE . "<br><br>";
            if (LB_SHOW_UPDATE_PROGRESS) {
                echo '<script>document.getElementById(\'prog\').value = 95;</script>';
            }
//            ob_flush();
            if (is_array($db_for_import)) {
                if (!empty($db_for_import["db_host"]) && !empty($db_for_import["db_user"]) && !empty($db_for_import["db_name"])) {
                    $db_host = strip_tags(trim((string)$db_for_import["db_host"]));
                    $db_user = strip_tags(trim((string)$db_for_import["db_user"]));
                    $db_pass = strip_tags(trim((string)$db_for_import["db_pass"]));
                    $db_name = strip_tags(trim((string)$db_for_import["db_name"]));
                    $con = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
                    if (mysqli_connect_errno()) {
                        echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED;
                    } else {
                        $templine = '';
                        $lines = file($destination);
                        foreach ($lines as $line) {
                            if (substr($line, 0, 2) == '--' || $line == '')
                                continue;
                            $templine .= $line;
                            $query = false;
                            if (substr(trim($line), -1, 1) == ';') {
                                $query = mysqli_query($con, $templine);
                                $templine = '';
                            }
                        }
                        @chmod($destination, 0777);
                        if (is_writeable($destination)) {
                            unlink($destination);
                        }
                        echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_DONE;
                    }
                } else {
                    echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED;
                }
            } else {
                echo LB_TEXT_UPDATE_WITH_SQL_DONE;
            }
            if (LB_SHOW_UPDATE_PROGRESS) {
                echo '<script>document.getElementById(\'prog\').value = 100;</script>';
            }
//            ob_flush();
        } else {
            if (LB_SHOW_UPDATE_PROGRESS) {
                echo '<script>document.getElementById(\'prog\').value = 100;</script>';
            }
            echo LB_TEXT_UPDATE_WITHOUT_SQL_DONE;
//            ob_flush();
        }
//        ob_end_flush();
    }

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
