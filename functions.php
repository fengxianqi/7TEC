<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以在网站标题前加上一个 LOGO'));
    $form->addInput($logoUrl);
    
    $sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
    array('ShowCategory' => _t('显示分类'),
    'ShowHotPosts' => _t('显示最热文章'),
    'ShowRecentComments' => _t('显示最近回复'),
    'ShowOther' => _t('显示其它杂项')),
    array('ShowCategory', 'ShowHotPosts', 'ShowRecentComments', 'ShowOther'), _t('侧边栏显示'));
    
    $form->addInput($sidebarBlock->multiMode());
         //侧栏广告
    $Sidebarads = new Typecho_Widget_Helper_Form_Element_Textarea('Sidebarads', NULL, NULL, _t('侧栏广告'), _t('填写广告代码，只能在电脑端显示'));
    $form->addInput($Sidebarads);
         //评论广告
    $Commentads = new Typecho_Widget_Helper_Form_Element_Textarea('Commentads', NULL, NULL, _t('评论广告'), _t('填写广告代码，只能在电脑端显示'));
    $form->addInput($Commentads);
         //备案号
    $beian = new Typecho_Widget_Helper_Form_Element_Text('beian', NULL, $siteUrl, _t('备案号'), _t('填写备案号'));
    $form->addInput($beian);
	
	//统计代码
    $Analytics = new Typecho_Widget_Helper_Form_Element_Textarea('Analytics', NULL, NULL, _t('统计代码'), _t('填写你从谷歌Analytics或百度统计获取到的代码，不需要script标签'));
    $form->addInput($Analytics);

}


/*
function themeFields($layout) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点LOGO地址'), _t('在这里填入一个图片URL地址, 以在网站标题前加上一个LOGO'));
    $layout->addItem($logoUrl);
}
*/

/*
* 回复评论添加 @ 标签
*/
function get_comment_at($coid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ? AND status = ?', $parent, 'approved'));
        $author = $arow['author'];
        $href = '回复 <a href="#comment-' . $parent . '">@' . $author . '</a>';
        echo $href;
    } else {
        echo '';
    }
}
/*
* 记录文章浏览量
*/
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    }
    echo $row['views'];
}
/*重写分页样式 START*/
/**
* 重写page函数  修改分页样式
*/
function pagex($archive,$index,$currentPage,$prev = '&laquo;', $next = '&raquo;', $splitPage = 3, $splitWord = '...', $template = ''){
    $_this = $archive;
    if ($_this->have()) {
        $hasNav = false;
        $default = array(
            'wrapTag'       =>  'ol',
            'wrapClass'     =>  'page-navigator'
        );

        if (is_string($template)) {
            parse_str($template, $config);
        } else {
            $config = $template;
        }

        $template = array_merge($default, $config);
        
        $total = $_this->getTotal();

        if (!$hasNav && $total > $_this->parameter->pageSize) {
            $query = Typecho_Router::url($_this->parameter->type .
                (false === strpos($_this->parameter->type, '_page') ? '_page' : NULL),
                $_this->_pageRow, $index);
            $nav = new boxrw($total, $currentPage, $_this->parameter->pageSize, $query);

            echo '<' . $template['wrapTag'] . (empty($template['wrapClass']) 
                    ? '' : ' class="' . $template['wrapClass'] . '"') . '>';
            $nav->render($prev, $next, $splitPage, $splitWord, $template);
            echo '</' . $template['wrapTag'] . '>';
        }
    }
}   
/**
* 重写box_render函数  修改分页样式
*/
class boxrw extends Typecho_Widget_Helper_PageNavigator_Box
{
    /**
     * 输出盒装样式分页栏
     *
     * @access public
     * @param string $prevWord 上一页文字
     * @param string $nextWord 下一页文字
     * @param int $splitPage 分割范围
     * @param string $splitWord 分割字符
     * @param string $currentClass 当前激活元素class
     * @return void
     */
    public function render($prevWord = 'PREV', $nextWord = 'NEXT', $splitPage = 3, $splitWord = '...', array $template = array())
    { 
        if ($this->_total < 1) {
            return;
        }

        $default = array(
            'itemTag'       =>  'li',
            'textTag'       =>  'span',
            'currentClass'  =>  'current',
            'prevClass'     =>  'prev',
            'nextClass'     =>  'next'
        );

        $template = array_merge($default, $template);
        extract($template);

        // 定义item
        $itemBegin = empty($itemTag) ? '' : ('<' . $itemTag . '>');
        $itemCurrentBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($currentClass) ? '' : ' class="' . $currentClass . '"') . '>');
        $itemPrevBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($prevClass) ? '' : ' class="' . $prevClass . '"') . '>');
        $itemNextBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($nextClass) ? '' : ' class="' . $nextClass . '"') . '>');
        $itemEnd = empty($itemTag) ? '' : ('</' . $itemTag . '>');
        $textBegin = empty($textTag) ? '' : ('<' . $textTag . '>');
        $textEnd = empty($textTag) ? '' : ('</' . $textTag . '>');
        $linkBegin = '<a href="%s">';
        $linkCurrentBegin = empty($itemTag) ? ('<a href="%s"'
            . (empty($currentClass) ? '' : ' class="' . $currentClass . '"') . '>')
            : $linkBegin;
        $linkPrevBegin = empty($itemTag) ? ('<a href="%s"'
            . (empty($prevClass) ? '' : ' class="' . $prevClass . '"') . '>')
            : $linkBegin;
        $linkNextBegin = empty($itemTag) ? ('<a href="%s"'
            . (empty($nextClass) ? '' : ' class="' . $nextClass . '"') . '>')
            : $linkBegin;
        $linkEnd = '</a>';

        $from = max(1, $this->_currentPage - $splitPage);
        $to = min($this->_totalPage, $this->_currentPage + $splitPage);

        //输出上一页
        if ($this->_currentPage > 1) {
            echo $itemPrevBegin . sprintf($linkPrevBegin,
                str_replace($this->_pageHolder, $this->_currentPage - 1, $this->_pageTemplate) . $this->_anchor)
                . $prevWord . $linkEnd . $itemEnd;
        }
        /*
        //取消显示页数
        //输出第一页
        if ($from > 1) {
            echo $itemBegin . sprintf($linkBegin, str_replace($this->_pageHolder, 1, $this->_pageTemplate) . $this->_anchor)
                . '1' . $linkEnd . $itemEnd;

            if ($from > 2) {
                //输出省略号
                echo $itemBegin . $textBegin . $splitWord . $textEnd . $itemEnd;
            }
        }

        //输出中间页
        for ($i = $from; $i <= $to; $i ++) {
            $current = ($i == $this->_currentPage);
            
            echo ($current ? $itemCurrentBegin : $itemBegin) . sprintf(($current ? $linkCurrentBegin : $linkBegin),
                str_replace($this->_pageHolder, $i, $this->_pageTemplate) . $this->_anchor)
                . $i . $linkEnd . $itemEnd;
        }

        //输出最后页
        if ($to < $this->_totalPage) {
            if ($to < $this->_totalPage - 1) {
                echo $itemBegin . $textBegin . $splitWord . $textEnd . $itemEnd;
            }
            
            echo $itemBegin . sprintf($linkBegin, str_replace($this->_pageHolder, $this->_totalPage, $this->_pageTemplate) . $this->_anchor)
                . $this->_totalPage . $linkEnd . $itemEnd;
        }
        */
        //输出下一页
        if ($this->_currentPage < $this->_totalPage) {
            echo $itemNextBegin . sprintf($linkNextBegin,
                str_replace($this->_pageHolder, $this->_currentPage + 1, $this->_pageTemplate) . $this->_anchor)
                . $nextWord . $linkEnd . $itemEnd;
        }
    }
}
/*重写分页样式 END*/
    /**
     * 输出最受欢迎文章
     *
     * 语法: Views_Plugin::theMostViewed();
     *
     * @access public
     * @param int     $limit  文章数目
     * @param string  $before 前字串
     * @param string  $after  后字串
     * @return string
     */
  function theMostViewed($limit = 10, $before = '(', $after = '人看过 ) ')
    {
        $db = Typecho_Db::get();
        $options = Typecho_Widget::widget('Widget_Options');
        $limit = is_numeric($limit) ? $limit : 10;
        $posts = $db->fetchAll($db->select()->from('table.contents')
                 ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish')
                 ->order('views', Typecho_Db::SORT_DESC)
                 ->limit($limit)
                 );

        if ($posts) {
            foreach ($posts as $post) {
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($post);
                $post_views = number_format($result['views']);
                $post_title = htmlspecialchars($result['title']);
                $permalink = $result['permalink'];
                echo "<li><a href='$permalink' title='$post_title'>$post_title</a><span class='views'>$before $post_views $after</span></li>\n";
            }

        } else {
            echo "<li>N/A</li>\n";
        }
    }

//统计文章字数
function  art_count ($cid){
$db=Typecho_Db::get ();
$rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1));
echo mb_strlen($rs['text'], 'UTF-8');
}
/**
 * 判断时间区间
 * 
 * 使用方法  if(timeZone($this->date->timeStamp)) echo 'ok';
 */
function timeZone($from){
$now = new Typecho_Date(Typecho_Date::gmtTime());
return $now->timeStamp - $from < 24*60*60 ? true : false;
}