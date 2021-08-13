<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</div><!-- end .row -->
</div>
<div class="GoTop" title="返回顶部"></div>
</div><!-- end #body -->

<footer id="footer" class="footer" role="contentinfo">
  <em><a href="https://beian.miit.gov.cn"  target="_blank"><?php echo $this->options->beian;?></a>
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <?php _e('由 <a href="//www.typecho.org">Typecho</a> 强力驱动.'); ?>
  </em>
</footer><!-- end #footer -->

<?php $this->footer(); ?>
<script src="<?php $this->options->themeUrl('js/jquery-3.3.1.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/lately.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('bootstrap/bootstrap.min.js'); ?>"></script>
<script src="//cdn.bootcss.com/highlight.js/9.12.0/highlight.min.js"></script>
<script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>

<script type="text/javascript">
    //获取评论参数
    <?php
    if ($this->options->commentsThreaded && $this->is('single')) {
      echo 'var respondId = "' .$this->respondId.'";';
    }
    /** 反垃圾设置 */
    if ($this->options->commentsAntiSpam && $this->is('single')) {
      echo 'var shuffleScriptVar = ' .Typecho_Common::shuffleScriptVar($this->security->getToken($this->request->getRequestUrl()));
    }
    echo 'var themeUrl = "' .$this->options->themeUrl .'";';
    ?>
    hljs.initHighlightingOnLoad();//开启代码高亮插件 highlightjs
    readyrun();
  </script>
	<?php if($this->options->Analytics): ?>
	<script>
	<?php $this->options->Analytics(); ?>
	</script>
	<?php endif; ?>
</body>
</html>
