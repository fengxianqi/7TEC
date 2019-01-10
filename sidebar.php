<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="col-12 col-lg-4 hidden-md sidebar" id="secondary" role="complementary">

    <section class="widget paddingall floatblock">
        <h5 class="widget-title"><?php _e('关于博主'); ?></h5>
        <div class="side-info-img">
          <a href="" data-action="imageZoomIn"><img src="https://avatars1.githubusercontent.com/u/15716381?s=460&v=4" width="50px" height="50px" style="border-radius: 50%;"> </a> 
        </div>
        <div class="side-info-author">
            <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a>
        </div>
        <div class="side-info-con"><?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>
                 <p>共写了<?php $stat->publishedPostsNum() ?>篇文章，获得<?php $stat->publishedCommentsNum() ?>条评论。</p>
             <p><?php $this->options->description() ?></p> 
                 <p class="cute"><a href="<?php $this->options->siteUrl('/about.html'); ?>">了解更多</a></p>
        </div>
        <?php if($this->options->Sidebarads): ?>
        <div class="side-ad">
        <?php $this->options->Sidebarads(); ?>
        </div>
    </section>
    <?php endif; ?>
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
    <section class="widget paddingall">
        <h5 class="widget-title"><?php _e('文章分类'); ?></h5>
        <?php //$this->widget('Widget_Metas_Category_List')->listCategories('wrapClass=widget-list');
        _e('<ul class="widget-list">');
        $this->widget('Widget_Metas_Category_List')->parse('<li><a href="{permalink}"><i class="fa fa-book fa-lg" aria-hidden="true">&nbsp; </i>{name}({count})</a></li>'); 
        _e('</ul>');
        ?>
    </section>
    <?php endif; ?>
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowHotPosts', $this->options->sidebarBlock)): ?>
    <section class="widget paddingall">
        <h5 class="widget-title"><?php _e('最受欢迎的文章'); ?></h5>
        <ul class="widget-list">
             <?php theMostViewed(); ?>
        </ul>
    </section>
    <?php endif; ?>
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
    <section class="widget paddingall">
        <h5 class="widget-title"><?php _e('最近回复'); ?></h5>
        <ul class="widget-list RecentReply zface-box">
        <?php $this->widget('Widget_Comments_Recent','ignoreAuthor=true')->to($comments); ?>
        <?php while($comments->next()): ?>
            <li><span itemprop="image"><?php $number=$comments->mail; echo '<img src="https://q2.qlogo.cn/headimg_dl? bs='.$number.'&dst_uin='.$number.'&dst_uin='.$number.'&;dst_uin='.$number.'&spec=100&url_enc=0&referer=bu_interface&term_type=PC" width="24px" height="24px" style="border-radius: 50%;margin-right: 10px;">'; ?></span><a href="<?php $comments->permalink(); ?>"><?php $comments->author(false); ?></a>: <?php $comments->excerpt(100, '...'); ?></li>
        <?php endwhile; ?>
        </ul>
    </section>
    <?php endif; ?>
    <?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
    <section class="widget paddingall">
        <h5 class="widget-title"><?php _e('其它'); ?></h5>
        <ul class="widget-list">
            <?php if($this->user->hasLogin()): ?>
                <li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?> (<?php $this->user->screenName(); ?>)</a></li>
                <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
            <?php else: ?>
                <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
            <?php endif; ?>
            <li><a href="<?php $this->options->feedUrl(); ?>"><?php _e('文章 RSS'); ?></a></li>
            <li><a href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('评论 RSS'); ?></a></li>
        </ul>
    </section>
    <?php endif; ?>

</div><!-- end #sidebar -->
