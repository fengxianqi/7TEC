<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="col-sm-12 col-lg-8" id="main" role="main">
    <article class="post Card typo" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="post-box paddingall">
            <div class="post-title-box">
            <h1 class="post-title" itemprop="name headline"><?php $this->title() ?></h1>
            </div>
            <div class="post-content" itemprop="articleBody">
                <?php $this->content(); ?>
            </div>
        </div>
        <div class="info">
            <ul class="post-meta">
                <li itemprop="author" itemscope itemtype="http://schema.org/Person"><i class="fa fa-user-circle-o" aria-hidden="true">&nbsp; </i><a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author"><?php $this->author(); ?></a></li>
                <li><i class="fa fa-calendar" aria-hidden="true">&nbsp; </i><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time></li>
                <li itemprop="interactionCount"><i class="fa fa-comments-o" aria-hidden="true">&nbsp; </i><a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论', '1 条评论', '%d 条评论'); ?></a></li>
            </ul>
        </div>
    </article>
    <?php $this->need('comments.php'); ?>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
