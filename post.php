<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="col-sm-12 col-lg-10 post-main" id="main" role="main">
    <article class="post Card typo" itemscope itemtype="http://schema.org/BlogPosting">       
        <div class="post-box paddingall">
            <div class="post-title-box">
            <h1 class="post-title" itemprop="name headline"><?php $this->title(); ?></h1>
            </div>
            <div class="tags-box">本文共有<?php echo art_count($this->cid); ?>个字，关键词：<span itemprop="keywords" class="tags"><?php $this->tags('、', true, ''); ?></span></div>
            <div class="post-content" itemprop="articleBody">
                <?php $this->content(); ?>
<!---赞赏模块---->
<div class="entry-shang text-center">
		<p>「一键投喂 软糖/蛋糕/布丁/牛奶/冰阔乐！」</p>
		<button class="zs show-zs btn btn-bred">赞赏</button>
	</div>
	<div class="zs-modal-bg"></div>
	<div class="zs-modal-box">
		<div class="zs-modal-head">
			<button type="button" class="close">×</button>
			<p class="author">
                                <img src="https://avatars1.githubusercontent.com/u/15716381?s=460&v=4" width="32px" height="32px" style="border-radius: 50%;"><?php $this->author(); ?>
			</p>
			<p class="tip"><i></i><span> (๑＞ڡ＜)☆谢谢老板~</span></p>
		</div>
		<div class="zs-modal-body">
			<div class="zs-modal-btns">
				<button class="btn btn-blink" data-num="2">2元</button>
				<button class="btn btn-blink" data-num="5">5元</button>
				<button class="btn btn-blink" data-num="10">10元</button>
				<button class="btn btn-blink" data-num="50">50元</button>
				<button class="btn btn-blink" data-num="100">100元</button>
				<button class="btn btn-blink" data-num="any">任意金额</button>
			</div>
			<div class="zs-modal-pay">
				<button class="btn btn-bred" id="pay-text">2元</button>
				<p>使用<span id="pay-type">微信</span>扫描二维码完成支付</p>
				<img width="150" height="150" src="<?php $this->options->themeUrl('img/alipay_2.png'); ?>" id="pay-image"/>
			</div>
		</div>
		<div class="zs-modal-footer">
			<label style="float: left;width: 130px;">
				<input type="radio" name="zs-type" value="alipay" class="zs-type" checked="checked" style="float: left;">
				<span class="zs-alipay">
					<img src="<?php $this->options->themeUrl('img/alipay-btn.png'); ?>" />
				</span>
			</label>
			<label style="float: left;width: 130px;">
				<input type="radio" name="zs-type" value="wechat" class="zs-type" style="float: left;">
				<span class="zs-wechat">
					<img src="<?php $this->options->themeUrl('img/wechat-btn.png'); ?>" />
				</span>
			</label>
		</div>
	</div>
<!---赞赏模块---->
            </div>
        </div>
        <div class="tags-box paddingall">
            版权声明：本文为作者原创，如需转载须联系作者本人同意，未经作者本人同意不得擅自转载。
        </div>
        <div class="info">
            <ul class="post-meta">
                <li><i class="fa fa-book fa-fw" aria-hidden="true">&nbsp; </i><?php $this->category(','); ?></li>
                <li><i class="fa fa-calendar" aria-hidden="true">&nbsp; </i><time class="lately-a" datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time></li>
                <li itemprop="interactionCount"><i class="fa fa-comments-o" aria-hidden="true">&nbsp; </i><a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论', '1 条评论', '%d 条评论'); ?></a></li>
                <li><i class="fa fa-hand-o-up" aria-hidden="true">&nbsp; </i><span><?php get_post_view($this);_e(' 次浏览'); ?></span></li>
            </ul>
        </div>
    </article>
    <div class="SubtitleBox hidden-md"></div>
    <div class="Card turned">
        <span style="float: left;padding:2px;"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;<?php $this->thePrev('%s','没有了'); ?></span>
        <span class="num" style="visibility:hidden">1/1</span>
        <span style="float: right;padding:2px;"><?php $this->theNext('%s','没有了'); ?>&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></span>
    </div>
    <?php $this->need('comments.php'); ?>
</div><!-- end #main-->

<?php $this->need('footer.php'); ?>
