<?php
/**
 *  7TEC清新风格主题
 * 
 * @package 7TEC
 * @author yuzhiblue
 * @version 2.0
 * @link http://7tec.cn
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>

<div class="col-12 col-lg-8" id="main" role="main">
	<?php while($this->next()): ?>
        <article class="post Card typo indexCard" itemscope itemtype="http://schema.org/BlogPosting">
        	<div class="post-box paddingall">
        		<div class="post-title-box">
				<h4 class="post-title" itemprop="name headline"><a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a><span><?php if(timeZone($this->date->timeStamp)) echo ' new'; ?></span></h4>
				</div>
	            <div class="post-content abstract" itemprop="articleBody">
					<?php $this->excerpt(135, '...'); ?>
<p class="more"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>">阅读全文</a></p>
				</div>
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
	<?php endwhile; ?>

	<?php 
		$currentPage =  $this->_currentPage;
		$index = $this->options->index;
		pagex($this,$index,$currentPage,'&laquo; 前一页', '后一页 &raquo;');
	?>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
