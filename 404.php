<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
    <div class="col-12">
        <div class="error-page">
            <p class="Letter404">404</p>
            <p class="words404">奇怪？ 页面消失了哦...(╥╯^╰╥)<span>&nbsp;去<a href="<?php $this->options->siteUrl(); ?>">首页</a>看看吧</span></p>
        </div>
    </div><!-- end #content-->
	<?php $this->need('footer.php'); ?>
