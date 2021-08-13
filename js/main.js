function readyrun(){
	var previousscrolltop = 0; //上次滚动条位置
	var starttop = 80;
	$(window).scroll(function() {
	    var nowscrolltop = $(window).scrollTop();//现在滚动条位置
	    var navbar = $('.header'); //导航条
	    var hidenavbar = $('.hideheader'); //占位导航条
	    hidenavbar.css({'height':navbar.height()});
	    if(nowscrolltop > previousscrolltop){
	        //下滑
	        if(nowscrolltop > starttop){
	        	navbar.removeClass("sticky");
	        	navbar.addClass("is-hidden");
	        	hidenavbar.css({'display':'block'});
	    	}
	    }else{
	        //上滑
	        if(nowscrolltop != 0){
	            navbar.addClass("sticky");
	            navbar.removeClass("is-hidden");
	        }else{
	            //顶部
	            navbar.removeClass("sticky");
	            navbar.removeClass("is-hidden");
	            hidenavbar.css({'display':'none'});
	        }
	    }
	    previousscrolltop = nowscrolltop;
	});
  
	//emoji表情
	$(".emoji-btn").click(function () {
		$(".emoji-box").toggleClass(function(){
	    	return "emoji-box-show";
	    });
	});

	if(typeof respondId !== 'undefined'){
		//评论框跟随JS
		window.TypechoComment = {
	        dom : function (id) {
	            return document.getElementById(id);
	        },
	        create : function (tag, attr) {
	            var el = document.createElement(tag);       
	            for (var key in attr) {
	                el.setAttribute(key, attr[key]);
	            }
	            return el;
	        },
	        reply : function (cid, coid) {
	            var comment = this.dom(cid), parent = comment.parentNode,
	                response = this.dom(respondId), input = this.dom('comment-parent'),
	                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
	                textarea = response.getElementsByTagName('textarea')[0];

	            if (null == input) {
	                input = this.create('input', {
	                    'type' : 'hidden',
	                    'name' : 'parent',
	                    'id'   : 'comment-parent'
	                });

	                form.appendChild(input);
	            }

	            input.setAttribute('value', coid);

	            if (null == this.dom('comment-form-place-holder')) {
	                var holder = this.create('div', {
	                    'id' : 'comment-form-place-holder'
	                });

	                response.parentNode.insertBefore(holder, response);
	            }

	            comment.children[0].children[0].appendChild(response);
	            this.dom('cancel-comment-reply-link').style.display = '';

	            if (null != textarea && 'text' == textarea.name) {
	                textarea.focus();
	            }

	            return false;
	        },

	        cancelReply : function () {
	            var response = this.dom(respondId),
	            holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');

	            if (null != input) {
	                input.parentNode.removeChild(input);
	            }

	            if (null == holder) {
	                return true;
	            }

	            this.dom('cancel-comment-reply-link').style.display = 'none';
	            holder.parentNode.insertBefore(response, holder);
	            return false;
	        }
	    };
	    if(typeof shuffleScriptVar !== 'undefined'){
	   		//反垃圾评论JS函数
		    var event = document.addEventListener ? {
		        add: 'addEventListener',
		        triggers: ['scroll', 'mousemove', 'keyup', 'touchstart'],
		        load: 'DOMContentLoaded'
		    } : {
		        add: 'attachEvent',
		        triggers: ['onfocus', 'onmousemove', 'onkeyup', 'ontouchstart'],
		        load: 'onload'
		    }, added = false;

		    document[event.add](event.load, function () {
		        var r = document.getElementById(respondId),
		            input = document.createElement('input');
		        input.type = 'hidden';
		        input.name = '_';
		        input.value = shuffleScriptVar;

		        if (null != r) {
		            var forms = r.getElementsByTagName('form');
		            if (forms.length > 0) {
		                function append() {
		                    if (!added) {
		                        forms[0].appendChild(input);
		                        added = true;
		                    }
		                }
		            
		                for (var i = 0; i < event.triggers.length; i ++) {
		                    var trigger = event.triggers[i];
		                    document[event.add](trigger, append);
		                    window[event.add](trigger, append);
		                }
		            }
		        }
		    });
	    }
	}
}

$(document).ready(function(){
  //时间样式修改
   $.lately({
            'target' : '.lately-a,.lately-b,.lately-c'
        });
  
	if(typeof respondId !== 'undefined'){
		$(".SubtitleBox").SubtitleBox($('.post-content'),$('#respond-textarea'));
	}
	$.emoji.Init();
	$(".floatblock").FloatBlock('.sidebar');

	$('.GoTop').click(function(){
		var _this = this;
		if($(window).scrollTop() > 100){
			$(window).scrollTop(0);
			$('html,body').animate({scrollTop:0},800,function(){
				$(_this).css('bottom','-30px');
				$(_this).animate({bottom:'50px'},800);
			});
			$(_this).animate({bottom:'700px'},700);
		}
	});
}); 

(function ($) {
	//浮动盒子
	$.fn.FloatBlock = function (hidebox) {
		var _this  = this;
		var allchild = $(hidebox).children();
		var hideheight = 100; 
		if(allchild.length >0 ){
			var boxwidth = allchild.eq(1);
			$.each(allchild,function() {
				hideheight += $(this).height();
			});

			$(window).scroll(function () {
				var nowscrolltop = $(window).scrollTop();//现在滚动条位置
				if (nowscrolltop > hideheight ){
					$(_this).css('width',$(hidebox).width());
					$(_this).addClass('floatblockshow');
				}else{
					$(_this).removeClass('floatblockshow');
				}
			});
		}
	}
})(jQuery);

(function ($) {
	$.extend({
		allTitleNode:{},
		TitleLocation:function(topval){
			if(typeof topval === 'number'){
				var nowscrolltop = $(window).scrollTop();//现在滚动条位置
				if(topval > nowscrolltop){ //往下滑动就添加导航偏移
					topval += $('.header').height();
				}
				$('html,body').animate({scrollTop:topval},800);
			}
		},
	});
	//浮动副标题
	$.fn.SubtitleBox = function (contnet,comment = null) {
		var _this = this;
		var parentHeight = $(this).parent().height() - $(this).height();
		var allTitleNode = contnet.children('h5,h4,h3,h2,h1');
		if (allTitleNode.length > 0 ){
			$.allTitleNode = allTitleNode;
			$.each(allTitleNode, function () {
				$(_this).html($(_this).html() + '<div><a href="#" onclick="$.TitleLocation('+this.offsetTop+');" ><' + $(this)[0].localName + '>' + $(this).text() + '</' + $(this)[0].localName + '></a></div>');
			});
		}
		if($(comment).length > 0){
			$(_this).html($(_this).html() + '<div><a href="#" onclick="$.TitleLocation('+$(comment).offset().top+');" ></a></div>');
		}
		/*if($(comment).length > 0 || allTitleNode.length > 0 ){
			$(_this).css('visibility','visible');
			$(window).scroll(function () {
				var nowscrolltop = $(window).scrollTop();//现在滚动条位置
				var headheight = $('.header').height();
				if (nowscrolltop < (parentHeight - $(_this).height())){
					$(_this).css('top', nowscrolltop  );
				}
			});
		}*/
	}
})(jQuery);

(function($){
	$.fn.num = function(options){
		_this = $(this)
		var _thisTop,_thisRight,_thisBottom,_thisLeft,_thisTopBottom,_thisRightLeft,_thisAll
		
		n1 = _this.width();
		h1 = _this.height();
		
		var defaults = {
			Type:'num',
			Color:'#219a26',
			speed:300,
		}
		var options = $.extend({},defaults,options)
		var becurr = "background:"+options.Color+";position:absolute;border-radius:10px;opahide;"

		num();//执行
		
		function than(_this){
			var obj = new Object();
			obj.name = '123'
			obj.thsn = function(){
				_thisTop = _this.find('.divTop').stop().show()
				_thisRight = _this.find('.divRight').stop().show()
				_thisBottom = _this.find('.divBottom').stop().show()
				_thisLeft = _this.find('.divLeft').stop().show()
				_thisTopBottom = _this.find('.divTop,.divBottom').stop().show()
				_thisRightLeft = _this.find('.divLeft,.divRight').stop().show()
				_thisAll = _this.find('.divTop,.divBottom,.divLeft,.divRight').stop().show()
			}
			return obj;
		}
		var opashow = 'opashow',opahide = 'opahide'
		function num(){
			// top杈规
			var divTop ="<div style='"+becurr+"top:-2px;left:"+n1/2+"px;width:0;height:2px' class='divTop'></div>";
			// right杈规
			var divRight ="<div style='"+becurr+"top:"+h1/2+"px;right:-2px;width:2px;height:0;' class='divRight'></div>";
			// Bottom杈规
			var divBottom ="<div style='"+becurr+"bottom:-2px;right:"+n1/2+"px;width:0;height:2px' class='divBottom'></div>";
			// Left杈规
			var divLeft ="<div style='"+becurr+"bottom:"+h1/2+"px;left:-2px;width:2px;height:0;' class='divLeft'></div>"; 
			_this.hover(function(){
				el = $(this)
				el.append(divTop,divRight,divBottom,divLeft);
				num6 = new than(el)
				num6.thsn()
				_thisTopBottom.animate({width:n1+3.5,left:-2},options.speed);
				_thisRightLeft.animate({height:h1+3.5,top:-2},options.speed);
			},function(){
				_thisTopBottom.animate({width:0,left:n1/2},options.speed);
				_thisRightLeft.animate({height:0,top:h1/2},options.speed,function(){
					_thisAll.remove()
				});
			})
		}
	}
})(jQuery);
(function(){
	$.extend({
		emoji:{
			facePath:[
			    {facereg:"(!)[zface_1.png]",faceName:"[U+1F60B]",facePath:"zface_1.png"},
				{facereg:"(!)[zface_2.png]",faceName:"[U+1F60E]",facePath:"zface_2.png"},
				{facereg:"(!)[zface_3.png]",faceName:"[U+1F61C]",facePath:"zface_3.png"},
				{facereg:"(!)[zface_4.png]",faceName:"[U+1F62D]",facePath:"zface_4.png"},
				{facereg:"(!)[zface_5.png]",faceName:"[U+1F62F]",facePath:"zface_5.png"},
				{facereg:"(!)[zface_6.png]",faceName:"[U+1F600]",facePath:"zface_6.png"},
				{facereg:"(!)[zface_7.png]",faceName:"[U+1F601]",facePath:"zface_7.png"},
				{facereg:"(!)[zface_8.png]",faceName:"[U+1F602]",facePath:"zface_8.png"},
				{facereg:"(!)[zface_9.png]",faceName:"[U+1F914]",facePath:"zface_9.png"},
				{facereg:"(!)[zface_10.png]",faceName:"[U+1F620]",facePath:"zface_10.png"},
				{facereg:"(!)[zface_11.png]",faceName:"[U+1F605]",facePath:"zface_11.png"},
				{facereg:"(!)[zface_12.png]",faceName:"[U+1F618]",facePath:"zface_12.png"},
				{facereg:"(!)[zface_13.png]",faceName:"[U+1F644]",facePath:"zface_13.png"},
				{facereg:"(!)[zface_14.png]",faceName:"[U+1F910]",facePath:"zface_14.png"},
				{facereg:"(!)[zface_15.png]",faceName:"[U+1F911]",facePath:"zface_15.png"},
				{facereg:"(!)[zface_16.png]",faceName:"[U+1F611]",facePath:"zface_16.png"},
				{facereg:"(!)[zface_17.png]",faceName:"[U+1F923]",facePath:"zface_17.png"},
			],
			Init:function(options = null){
				var defaults = {
					textinput:'.comment-textarea', 
					imgbox:'.emoji-box',
					commentbox:'.zface-box',
				};

				//装载表情
				$.each($.emoji.facePath,function(){
					if($(defaults.imgbox).length > 0){
						$(defaults.imgbox).append('<img data-zface=\"'+ this.facereg +'\" class=\"z-emoji-img\" src=\"'+ themeUrl +'/face/'+this.facePath+'\" />');
					}

					$(defaults.commentbox).each(function(){
						var regstr = /\(\!\)\[(\w[-\w.+]*)\]/g;
						$(this).html($(this).html().replace(regstr,'<img class=\"z-emoji-img\" src=\"'+ themeUrl +'/face/$1\" />'));
					});
				});

				$(defaults.imgbox).children('img').click(function(){
					$(defaults.textinput).val($(defaults.textinput).val() + $(this).attr('data-zface') + ' ');
					$(defaults.textinput).focus();
				});
			},
		},
	});
})(jQuery);
//赞赏JS
function ZanShang(){
  this.popbg = $('.zs-modal-bg');
  this.popcon = $('.zs-modal-box');
  this.closeBtn = $('.zs-modal-box .close');
  this.zsbtn = $('.zs-modal-btns .btn');
  this.zsPay = $('.zs-modal-pay');
  this.zsBtns = $('.zs-modal-btns');
  this.zsFooter = $('.zs-modal-footer');
  var that = this;
  $('.show-zs').on('click',function(){
    //点击赞赏按钮出现弹窗
    that._show();
    that._init();
  })
}
ZanShang.prototype._hide = function(){
  this.popbg.hide();
  this.popcon.hide();
}
ZanShang.prototype._show = function(){
  this.popbg.show();
  this.popcon.show();
  this.zsBtns.show();
  this.zsFooter.show();
  this.zsPay.hide();
}
ZanShang.prototype._init = function(){
  var that = this;
  this.closeBtn.on('click',function(){
    that._hide();
  })
  this.popbg.on('click',function(){
    that._hide();
  })
  this.zsbtn.each(function(el){
    $(this).on('click',function(){
      var num = $(this).attr('data-num'); //按钮的对应的数字
      var type = $('.zs-type:radio:checked').val();//付款方式
      //根据不同付款方式和选择对应的按钮的数字来生成对应的二维码图片，你可以自定义这个图片的路径，默认放在当前images目录中
      //假如你需要加一个远程路径，比如我的就是
      //'https://www.zuozuovera.com/usr/themes/pinghsu/images/'+type+'-'+num+'.jpg';
      var src = ''
      var text = $(this).html();
      var payType=$('#pay-type'), payImage = $('#pay-image'),payText = $('#pay-text');
      if(type=='alipay'){
        payType.html('支付宝');
        src = 'https://www.fengxianqi.com/usr/themes/7TEC/img/'+type+'_'+num+'.png';
      }else{
        payType.html('微信');
        src = 'https://www.fengxianqi.com/usr/themes/7TEC/img/wechat_any.png';
      }
      payImage.attr('src',src);
      payText.html(text);
      that.zsPay.show();
      that.zsBtns.hide();
      that.zsFooter.hide();

    })
  })
}
var zs = new ZanShang();
