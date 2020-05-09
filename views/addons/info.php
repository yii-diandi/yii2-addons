<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-03 09:22:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-03 09:52:46
 */
?>

<div class="media" >
    <a class="pull-left" href="#">
        <img class="media-object"   src="<?= $logo; ?>" alt="Image">
    </a>
    <div class="media-body"  style="margin-left:10px;">        
        <h5 class="media-heading" style="line-height:35px;"><?= $model['title']; ?></h5>
        
        <p class="text-muted">版本：<?= $model['version']; ?></p>
    </div>
</div>