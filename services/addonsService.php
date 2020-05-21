<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 04:22:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-20 23:42:59
 */

namespace diandi\addons\services;

use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use Yii;
use common\services\BaseService;
use diandi\addons\modules\searchs\DdAddons;
use diandi\admin\models\Route;
use diandi\admin\models\searchs\Menu;
use phpDocumentor\Reflection\Types\Null_;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class addonsService extends BaseService
{


    public static function  ext_module_manifest_parse($xml)
    {

        if (false === strpos($xml, '<manifest')) {
            $xml = base64_decode($xml);
        }
        if (empty($xml)) {
            return array();
        }

        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $root = $dom->getElementsByTagName('manifest')->item(0);
        if (empty($root)) {
            return array();
        }
        $vcode = explode(',', $root->getAttribute('versionCode'));
        $manifest['versions'] = array();
        if (is_array($vcode)) {
            foreach ($vcode as $v) {
                $v = trim($v);
                if (!empty($v)) {
                    $manifest['versions'][] = $v;
                }
            }
            $manifest['versions'] = array_unique($manifest['versions']);
        }
        $manifest['install'] = $root->getElementsByTagName('install')->item(0)->textContent;
        $manifest['uninstall'] = $root->getElementsByTagName('uninstall')->item(0)->textContent;
        $manifest['upgrade'] = $root->getElementsByTagName('upgrade')->item(0)->textContent;
        $application = $root->getElementsByTagName('application')->item(0);
        if (empty($application)) {
            return array();
        }
        $identifie = trim($application->getElementsByTagName('identifie')->item(0)->textContent);
        $manifest['application'] = array(
            'logo' => self::getlogoUrl($identifie),
            'title' => trim($application->getElementsByTagName('title')->item(0)->textContent),
            'identifie' =>  $identifie,
            'version' => trim($application->getElementsByTagName('version')->item(0)->textContent),
            'type' => trim($application->getElementsByTagName('type')->item(0)->textContent),
            'ability' => trim($application->getElementsByTagName('ability')->item(0)->textContent),
            'description' => trim($application->getElementsByTagName('description')->item(0)->textContent),
            'author' => trim($application->getElementsByTagName('author')->item(0)->textContent),
            'url' => trim($application->getElementsByTagName('url')->item(0)->textContent),
            'setting' => trim($application->getAttribute('setting')) == 'true',
        );
        $bindings = $root->getElementsByTagName('bindings')->item(0);
        if (!empty($bindings)) {
            $points = self::ext_module_bindings();
            if (!empty($points)) {
                $ps = array_keys($points);
                $manifest['bindings'] = array();
                foreach ($ps as $p) {
                    $define = $bindings->getElementsByTagName($p)->item(0);
                    $manifest['bindings'][$p] = self::_ext_module_manifest_entries($define);
                }
            }
        }
        return $manifest;
    }

    // 获取模块logo
    public static function getLogo($addon)
    {
        $logog = Yii::getAlias("@common/addons/{$addon}/logo.png");
        return self::imgToBase64($logog);
    }

    public static function ext_module_bindings()
    {
        static $bindings = array(
            'menus' => array(
                'name' => "name",
                'route' => "route",
                'order' => "order",
                'icon' => "icon",
                'menu' => array(
                    'name' => "name",
                    'route' => "route",
                    'order' => "order",
                    'icon' => "icon",
                )
            )
        );
        return $bindings;
    }



    /**
     * 获取图片的Base64编码(不支持url)
     * @date 2017-02-20 19:41:22
     *
     * @param $img_file 传入本地图片地址
     *
     * @return string
     */
    public static function imgToBase64($img_file)
    {

        $img_base64 = '';
        if (file_exists($img_file)) {
            $app_img_file = $img_file; // 图片路径
            $img_info = getimagesize($app_img_file); // 取得图片的大小，类型等

            //echo '<pre>' . print_r($img_info, true) . '</pre><br>';
            $fp = fopen($app_img_file, "r"); // 图片是否可读权限

            if ($fp) {
                $filesize = filesize($app_img_file);
                $content = fread($fp, $filesize);
                $file_content = chunk_split(base64_encode($content)); // base64编码
                switch ($img_info[2]) {           //判读图片类型
                    case 1:
                        $img_type = "gif";
                        break;
                    case 2:
                        $img_type = "jpg";
                        break;
                    case 3:
                        $img_type = "png";
                        break;
                }

                $img_base64 = 'data:image/' . $img_type . ';base64,' . $file_content; //合成图片的base64编码

            }
            fclose($fp);
        }

        return $img_base64; //返回图片的base64
    }


    public static function  _ext_module_manifest_entries($elm)
    {
        $ret = array();
        if (!empty($elm)) {

            $entries = $elm->getElementsByTagName('menu');
            for ($i = 0; $i < $entries->length; $i++) {
                $entry = $entries->item($i);
                $direct = $entry->getAttribute('direct');
                $is_multilevel_menu = $entry->getAttribute('multilevel');
                $row = array(
                    'name' => $entry->getAttribute('name'),
                    'route' => $entry->getAttribute('route'),
                    'order' => $entry->getAttribute('order'),
                    'icon' => $entry->getAttribute('icon'),
                );
                $parent = $entry->getAttribute('parent');
                $row['parent'] = $parent ? $parent : 0;
                if (!empty($row['name']) && !empty($row['route'])) {
                    if (empty($row['parent'])) {
                        $ret[$row['route']] = $row;
                    } else {
                        $ret[$row['parent']]['child'][] = $row;
                    }
                }
            }
        }
        return $ret;
    }

    // xml配置校验
    public static function  ext_manifest_check($module_name, $manifest)
    {
        if (is_string($manifest)) {
            $message = '模块 mainfest.xml 配置文件有误, 具体错误内容为: <br />' . $manifest;
            throw new BadRequestHttpException($message);
        }
        $error_msg = '';
        if (empty($manifest['application']['name'])) {
            $error_msg .= '<br/>&lt;application&gt;&lt;name&gt;名称节点不能为空';
        }
        if (empty($manifest['application']['identifie']) || !preg_match('/^[a-z][a-z\d_]+$/i', $manifest['application']['identifie'])) {
            $error_msg .= '<br/>&lt;application&gt;&lt;identifie&gt;标识符节点不能为空或格式错误(仅支持字母和数字, 且只能以字母开头)';
        } elseif (strtolower($module_name) != strtolower($manifest['application']['identifie'])) {
            $error_msg .= '<br/>&lt;application&gt;&lt;identifie&gt;标识符节点与模块路径名称定义不匹配';
        }
        if (empty($manifest['application']['version']) || !preg_match('/^[\d\.]+$/i', $manifest['application']['version'])) {
            $error_msg .= '<br/>&lt;application&gt;&lt;version&gt;版本号节点未定义或格式不正确(仅支持数字和句点)';
        }
        if (empty($manifest['application']['ability'])) {
            $error_msg .= '<br/>&lt;application&gt;&lt;ability&gt;功能简述节点不能为空';
        }
        if ($manifest['platform']['isrulefields'] && !in_array('text', $manifest['platform']['handles'])) {
            $error_msg .= '<br/>模块功能定义错误, 嵌入规则必须要能够处理文本类型消息';
        }
        if ((!empty($manifest['cover']) || !empty($manifest['rule'])) && !$manifest['platform']['isrulefields']) {
            $error_msg .= '<br/>模块功能定义错误, 存在封面或规则功能入口绑定时, 必须要嵌入规则';
        }
        global $points;
        if (!empty($points)) {
            foreach ($points as $name => $point) {
                if (is_array($manifest[$name])) {
                    foreach ($manifest[$name] as $menu) {
                        if (trim($menu['title']) == ''  || !preg_match('/^[a-z\d]+$/i', $menu['do']) && empty($menu['call'])) {
                            $error_msg .= "<br/>&lt;$name&gt;节点" . $point['title'] . ' 扩展项功能入口定义错误, (操作标题[title], 入口方法[do])格式不正确.';
                        }
                    }
                }
            }
        }
        if (is_array($manifest['permissions']) && !empty($manifest['permissions'])) {
            foreach ($manifest['permissions'] as $permission) {
                if (trim($permission['title']) == ''  || !preg_match('/^[a-z\d_]+$/i', $permission['permission'])) {
                    $error_msg .= '<br/>' . "&lt;permissions&gt;节点名称为： {$permission['title']} 的权限标识格式不正确,请检查标识名称或标识格式是否正确";
                }
            }
        }
        if (!is_array($manifest['versions'])) {
            $error_msg .= '<br/>&lt;versions&gt;节点兼容版本格式错误';
        }
        if (!empty($error_msg)) {
            throw new BadRequestHttpException('模块 mainfest.xml 配置文件有误<br/>' . $error_msg);
        }
        return true;
    }

    // 文件完整校验
    public static function  ext_file_check($module_name)
    {
        $module_root = Yii::getAlias("@common/addons/");
        $module_path = $module_root . $module_name . '/';
        if (
            !file_exists($module_path . 'api.php') &&
            !file_exists($module_path . 'install.php') &&
            !file_exists($module_path . 'uninstall.php') &&
            !file_exists($module_path . 'upgrade.php') &&
            !file_exists($module_path . 'site.php')
        ) {
            throw new NotFoundHttpException('模块缺失文件，请检查模块文件中site.php,api.php, install.php,uninstall.php,upgrade.php, logo.png 文件是否存在！');
        }
        return true;
    }

    // 获取单个未安装的
    public static  function unAddon($addon)
    {
        // 获取模块目录下所有的模块
        $module_root = Yii::getAlias("@common/addons");
        $module_path_list = glob($module_root . '/*');
        // 获取所有已经安装的模块
        $DdAddons = new DdAddons();
        $addonsAll = $DdAddons->find()->all();
        foreach ($module_path_list as $path) {
            $modulename = pathinfo($path, PATHINFO_BASENAME);
            if (!in_array($modulename, $addonsAll) && $addon == $modulename) {
                // 检查文件
                addonsService::ext_file_check($modulename);
                $xmlPath = trim($module_root . '/' . $modulename . '/manifest.xml');
                // 检查配置
                $xml = file_get_contents($module_root . '/' . $modulename . '/manifest.xml');
                $addonsXml = addonsService::ext_module_manifest_parse($xml);
                continue;
            }
        }
        return $addonsXml;
    }

    // 获取未安装的
    public static function unAddons()
    {

        $unAddons = Yii::$app->cache->get('unAddons');
        if ($unAddons) {
            return $unAddons;
        } else {
            // 获取模块目录下所有的模块
            $module_root = Yii::getAlias("@common/addons");
            $module_path_list = glob($module_root . '/*');
            // 获取所有已经安装的模块
            $DdAddons = new DdAddons();
            $addonsAll = $DdAddons->find()->select('identifie')->column();
            foreach ($module_path_list as $path) {
                $modulename = pathinfo($path, PATHINFO_BASENAME);

                if (!in_array($modulename, $addonsAll)) {
                    // 检查文件
                    addonsService::ext_file_check($modulename);
                    $xmlPath = trim($module_root . '/' . $modulename . '/manifest.xml');
                    // 检查配置
                    $xml = file_get_contents($module_root . '/' . $modulename . '/manifest.xml');
                    $addonsXml = addonsService::ext_module_manifest_parse($xml);
                    if ($addonsXml['application']['identifie'] != $modulename) {
                        continue;
                    }
                    $list[] = $addonsXml['application'];
                }
            }
            $unAddons = Yii::$app->cache->set('unAddons', $list);
            return $list;
        }
    }

    // 后台使用logo
    public static function getlogoUrl($addon)
    {
        return Url::to(['addons/logo', 'addon' => $addon]);
    }


    // 根据数组结构执行安装
    public static function install($addons)
    {
        // 写入基础信息进入模块目录
        $logPath = Yii::getAlias("@runtime/log/install");
        $application = $addons['application'];
        $DdAddons = new DdAddons();
        $transaction =  $DdAddons::getDb()->beginTransaction();

        try {
            $parent = [];
            // 唯一标识是否重复
            $is_have = $DdAddons::findOne(['identifie' => $application['identifie']]);
            if ($is_have) {
                throw new BadRequestHttpException('模块标识' . $application['identifie'] . '已经存在');
            }
            $DdAddons->load($application, '');
            $DdAddons->save();
            // 写入菜单信息进系统菜单
            $Menu = new Menu();
            $baseMenus = $addons['bindings']['menus'];
            foreach ($baseMenus as $item) {
                $_Menu = clone  $Menu;
                $MenuData = [
                    'name' => $item['name'],
                    'parent' => !empty($item['parent']) ? $item['parent'] : null,
                    'route' => $item['route'],
                    'order' => !empty($item['order']) ? $item['order'] : 0,
                    'type' => 'plugins',
                    'icon' => $item['icon'] ? $item['icon'] : '',
                    'is_sys' => 'addons',
                    'module_name' => $application['identifie'],
                ];
                // FileHelper::writeLog($logPath, '父级菜单：' . Json::encode($MenuDataparent));
                $_Menu->setAttributes($MenuData);
                FileHelper::writeLog($logPath, 'zilei 菜单' . Json::encode($item['child']));
                $_Menu->save();
                $parent[$item['route']] = $_Menu->id;
                if (!empty($item['child'])) {
                    foreach ($item['child'] as $child) {
                        $_Menuchild = clone  $Menu;

                        $MenuData = [
                            'name' => $child['name'],
                            'parent' => $parent[$child['parent']] ? $parent[$child['parent']] : null,
                            'route' => $child['route'],
                            'order' => $child['order'] ? $child['order'] : 0,
                            'type' => 'plugins',
                            'icon' => $child['icon'] ? $child['icon'] : '',
                            'is_sys' => 'addons',
                            'module_name' => $application['identifie'],
                        ];
                        // FileHelper::writeLog($logPath, '子类菜单' . Json::encode($MenuData));
                        $_Menuchild->setAttributes($MenuData);
                        $_Menuchild->save();
                    }
                }
            }
            // 写入主入口菜单
            $MenuData = [
                'name' => $application['title'],
                'parent' => 12,
                'route' => '/' . $application['identifie'] . '/default/index',
                'order' => null,
                'type' => 'plugins',
                'icon' => $application['icon'] ? $application['icon'] : '',
                'is_sys' => 'addons',
                'module_name' => $application['identifie'],
            ];
            // FileHelper::writeLog($logPath, '模块入口：' . Json::encode($MenuIndex));
            $Menu->setAttributes($MenuData);
            $Menu->save();
            Yii::$app->cache->delete('unAddons');
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
        // 执行操作权限

    }



    // 根据数组结构执行安装
    public static function unInstall($identifie)
    {
        $parent = [];
        // 写入基础信息进入模块目录
        $logPath = Yii::getAlias("@runtime/log/install");
        $DdAddons = new DdAddons();
        $transaction =  $DdAddons::getDb()->beginTransaction();
        try {

            // 删除模块信息
            $DdAddons->deleteAll(['identifie' => $identifie]);
            // 删除菜单信息进系统菜单
            $Menu = new Menu();
            $Menu->deleteAll(['module_name' => $identifie]);
            Yii::$app->cache->delete('unAddons');
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

    // 获取所有的路由
    public static function addonsRules($addon)
    {
        $Route = new Route();
        $routes = $Route->getAppRoutes($addon);
        return $routes;
        // $model = new Route();
        // $model->addNew($routes);

    }
}
