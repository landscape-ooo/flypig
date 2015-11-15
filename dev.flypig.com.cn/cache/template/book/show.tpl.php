<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<link type="text/css" href="<?php echo SITE_URL;?>public/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo SITE_URL;?>public/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('book','index')?>" title="飞猪网精品图书汇">精品汇</a>  &gt;  图书详情
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="show_base" class="clearfix">
			<div class="pic">
				<a href="<?php echo $strBook['bookicon'];?>" title="《<?php echo $strBook['bookname'];?>》封面" class="bookicon_image" target="_blank"><img src="<?php echo $strBook['icon_180'];?>" alt="《<?php echo $strBook['bookname'];?>》封面" /></a>
				<script type="text/javascript">
				$(document).ready(function() {
					$(".bookicon_image").fancybox();
				});
				</script>
			</div>
			<div class="info">
				<h1><a href="<?php echo tsurl('book','show',array('id'=>$strBook['bookid']))?>" class="name">《<?php echo $strBook['bookname'];?>》</a></h1>
				<?php if($strBook['title'] && $strBook['title']!=$strBook['bookname']) { ?><p class="title"><em>——</em> <?php echo $strBook['title'];?></p><?php } ?>
				<?php if($strBook['description']) { ?>
				<div class="description">
					<div class="sup">
						<div class="sub">
							<p class="desc"><?php echo $strBook['description'];?></p>
							<?php if($strBook['awardsrecord']) { ?><p class="awards"><?php echo $strBook['awardsrecord'];?></p><?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>
				<ul class="baseinfo">
					<?php if($strBook['author']) { ?>
					<li class="author">
						<dl>
							<dt>作者：</dt>
							<dd><?php echo $strBook['author'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['isbn']) { ?>
					<li class="price">
						<dl>
							<dt>ISBN：</dt>
							<dd><?php echo $strBook['isbn'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['price']) { ?>
					<li class="price">
						<dl>
							<dt>定价：</dt>
							<dd><?php echo $strBook['price'];?> 元</dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['pubdate']!='0000-00-00') { ?>
					<li class="price">
						<dl>
							<dt>出版日期：</dt>
							<dd><?php echo $strBook['pubdate'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['numrev']) { ?>
					<li class="price">
						<dl>
							<dt>版次：</dt>
							<dd><?php echo $strBook['numrev'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['prtdate']!='0000-00-00') { ?>
					<li class="price">
						<dl>
							<dt>印刷日期：</dt>
							<dd><?php echo $strBook['prtdate'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['num_print']) { ?>
					<li class="price">
						<dl>
							<dt>印次：</dt>
							<dd><?php echo $strBook['num_print'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['cnt_pages']) { ?>
					<li class="price">
						<dl>
							<dt>页数：</dt>
							<dd><?php echo $strBook['cnt_pages'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['cnt_words']) { ?>
					<li class="price">
						<dl>
							<dt>字数：</dt>
							<dd><?php echo $strBook['cnt_words'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['paper']) { ?>
					<li class="price">
						<dl>
							<dt>纸张：</dt>
							<dd><?php echo $strBook['paper'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['packing']) { ?>
					<li class="price">
						<dl>
							<dt>包装：</dt>
							<dd><?php echo $strBook['packing'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['format']) { ?>
					<li class="price">
						<dl>
							<dt>开本：</dt>
							<dd><?php echo $strBook['format'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['pubhouse']) { ?>
					<li class="star">
						<dl>
							<dt>出版社：</dt>
							<dd><?php echo $strBook['pubhouse'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['company']) { ?>
					<li class="star">
						<dl>
							<dt>出版商：</dt>
							<dd><?php echo $strBook['company'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['star']) { ?>
					<li class="star">
						<dl>
							<dt>推荐星级：</dt>
							<dd><?php echo $strBook['star'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['age']) { ?>
					<li class="age">
						<dl>
							<dt>阅读年龄：</dt>
							<dd><?php echo $strBook['age'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['intel']) { ?>
					<li class="intel">
						<dl>
							<dt>图书智能：</dt>
							<dd><?php echo $strBook['intel'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['theme']) { ?>
					<li class="theme">
						<dl>
							<dt>阅读主题：</dt>
							<dd><?php echo $strBook['theme'];?></dd>
						</dl>
					</li>
					<?php } ?>
					<?php if($strBook['spec']) { ?>
					<li class="spec">
						<dl>
							<dt>其　　它：</dt>
							<dd><?php echo $strBook['spec'];?></dd>
						</dl>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="brtool">
				<a href="javascript:void(0);" onclick="doBook('<?php echo $strBook['bookid'];?>',1)" class="btn_do<?php if($strBook['dotype']=='1') { ?> btn_on<?php } ?>"><span>想读(<?php echo $strBook['count_want'];?>)</span></a>
				<a href="javascript:void(0);" onclick="doBook('<?php echo $strBook['bookid'];?>',2)" class="btn_do<?php if($strBook['dotype']=='2') { ?> btn_on<?php } ?>"><span>正读(<?php echo $strBook['count_read'];?>)</span></a>
				<a href="javascript:void(0);" onclick="doBook('<?php echo $strBook['bookid'];?>',3)" class="btn_do<?php if($strBook['dotype']=='3') { ?> btn_on<?php } ?>"><span>已读(<?php echo $strBook['count_done'];?>)</span></a>
			</div>
		</div>
		<?php if($strBook['bookphoto']) { ?>
		<div id="show_photo">
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-images"></span>
					内页展示
				</div>
			</div>
			<div class="photo_box">
				<div class="next" style="display: none;"><span class="icon icon-arrow-right2"></span></div>
				<div class="prev" style="display: none;"><span class="icon icon-arrow-left3"></span></div>
				<ul>
					<?php foreach((array)$strBook['bookphoto'] as $key=>$item) {?>
					<li><a href="<?php echo $item['src'];?>" title="<?php echo $item['title'];?>" class="bookphoto_image" rel="bookphoto_image" target="_blank"><img src="<?php echo $item['thumb'];?>" alt="<?php echo $item['title'];?>"></a></li>
					<?php }?>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$(".bookphoto_image").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';
				}
			});
			$('#show_photo .photo_box').hover(function () {
				var timeLeft = 0;
				var leg = $(this).find('li').length;
				var sum = 0;
				for (i = 0; i < leg; i++) {
					var liWidth = $($(this).find('li').get(i)).width() + 15;
					sum += liWidth;
				};

				$(this).find('ul').css('width', sum+2);

				rollStatus($(this).find('ul'));

				function rollStatus(box) {
					function checkStatus() {
						var offset = parseInt(box.position().left);
						if (offset < 0) {
							box.parent().find('.prev').unbind('click').one('click', leftClick);
						} if (offset > -(sum - 640)) {
							box.parent().find('.next').unbind('click').one('click', rightClick);
						};
						if (offset == 0) {
							box.parent().find('.prev').hide();
						} else {
							box.parent().find('.prev').show();
						}
						if (offset <= -(sum - 640)) {
							box.parent().find('.next').hide().unbind();
						} else {
							box.parent().find('.next').show();
						}
					};
					function leftClick() {
						var left = box.position().left;
						if (-left < 640) {
							box.animate({ 'left': '+=' + (-left) }, 500, function () {
								checkStatus();
							});
							var left = 0;
						} else {
							box.animate({ 'left': '+=' + 640 }, 500, function () {
								checkStatus();
							});
						}
					};
					function rightClick() {
						var left = box.position().left - 640;
						if ((sum + left) < 640) {
							box.animate({ 'left': '-=' + (sum + left) }, 500, function () {
								checkStatus();
							});
						} else {
							box.animate({ 'left': '-=' + 640 }, 500, function () {
								checkStatus();
							});
						};
					};
					checkStatus(box);
				};
			}, function () {
				$('.next').hide();
				$('.prev').hide();
			});
		});
		</script>
		<?php } ?>
		<?php if($strBook['bookadd1']) { ?>
		<div id="show_bookadd1">
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-newspaper"></span>
					内容介绍
				</div>
			</div>
			<div class="bookadd_box">
				<div class="con">
					<?php echo $strBook['bookadd1'];?>
				</div>
			</div>
			<div class="bookadd_btn">
				<div class="down">展开内容</div>
				<div class="up">收起内容</div>
			</div>
		</div>
		<?php } ?>
		<?php if($strBook['bookadd2']) { ?>
		<div id="show_bookadd2">
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-user"></span>
					专家推荐
				</div>
			</div>
			<div class="bookadd_box">
				<div class="con">
					<?php echo $strBook['bookadd2'];?>
				</div>
			</div>
			<div class="bookadd_btn">
				<div class="down">展开内容</div>
				<div class="up">收起内容</div>
			</div>
		</div>
		<?php } ?>
		<?php if($strBook['bookadd3']) { ?>
		<div id="show_bookadd3">
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-image"></span>
					图画赏析
				</div>
			</div>
			<div class="bookadd_box">
				<div class="con">
					<?php echo $strBook['bookadd3'];?>
				</div>
			</div>
			<div class="bookadd_btn">
				<div class="down">展开内容</div>
				<div class="up">收起内容</div>
			</div>
		</div>
		<?php } ?>
		<?php if($strBook['bookadd1'] || $strBook['bookadd2'] || $strBook['bookadd3']) { ?>
		<script type="text/javascript">
		$(function(){
			$('.bookadd_box .con').each(function () {
				if ($(this).height() > 120) {
					$(this).parent().parent().find('.down').css('display', 'block');
					$(this).parent().prepend("<span class=\"mark\"></span>");
				};
			});
			$('.bookadd_btn .down').click(function () {
				var el = $(this).parent().parent().find('.bookadd_box'),
					curHeight = el.height(),
					autoHeight = el.css('height', 'auto').height();
				el.height(curHeight).animate({height: autoHeight});
				$(this).hide();
				$(this).parent().find('.up').show();
			});
			$('.bookadd_btn .up').click(function () {
				var el = $(this).parent().parent().find('.bookadd_box');
				el.animate({height:'120px'});
				$(this).hide();
				$(this).parent().find('.down').show();
			});
		});
		</script>
		<?php } ?>
		<div id="show_review">
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-bubbles4"></span>
					精彩书评
				</div>
				<div class="com-bar-more">
					<span class="icon icon-eye"></span>
					<a href="<?php echo tsurl('review','index',array('bookid'=>$strBook['bookid']))?>" class="look_all">查看全部(<?php echo $reviewNum;?>)</a>
					<?php if($TS_APP['options'][iscreate]==0 || $TS_USER['user'][isadmin]==1) { ?>
					&nbsp;&nbsp;<span class="icon icon-pencil2"></span> <a target="_blank" href="<?php echo tsurl('review','add',array('bookid'=>$strBook['bookid']))?>">写书评</a>
					<?php } ?>
				</div>
			</div>
			<div class="review_box">
				<?php if($arrReview) { ?>
				<div class="review_list">
					<ul>
						<?php foreach((array)$arrReview as $key=>$item) {?>
						<li>
							<div class="show-face">
								<a href="<?php echo tsurl('user','space',array('id'=>$item['user'][userid]))?>"><img class="userface" src="<?php echo $item['user'][face];?>" width="75" height="75" alt="<?php echo $item['user']['username'];?>" title="<?php echo $item['user']['username'];?>" /></a>
								<a class="username" href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>"><?php echo $item['user'][username];?></a>
							</div>
							<div class="show-info">
								<div class="review_title">
									<?php if($item['typeid'] != 0) { ?>
									<a href="<?php echo tsurl('book','show',array('id'=>$item['bookid'],typeid=>$item['typeid']))?>">[<?php echo $item['typename'];?>]</a>
									<?php } ?>
									<a target="_blank" title="<?php echo $item['title'];?>" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>"><?php echo $item['title'];?></a>
									<?php if($item['istop']=='1') { ?>
									<img src="<?php echo SITE_URL;?>public/images/tops.gif" title="[置顶]" alt="[置顶]" /> 
									<?php } ?> 
									<?php if($item['isposts'] == '1') { ?>
									<img src="<?php echo SITE_URL;?>public/images/posts.gif" title="[精华]" alt="[精华]" />
									<?php } ?>
									<?php if($item['postby']==1) { ?>
									<a href="<?php echo tsurl('home','phone')?>"><img align="absmiddle" alt="通过Iphone手机端发布" title="通过Iphone手机端发布" src="<?php echo SITE_URL;?>public/images/ios.jpg" /></a>
									<?php } ?>
									<span class="data">
										<span class="icon icon-eye"></span>
										<a target="_blank" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" title="浏览数"><?php echo $item['count_view'];?></a>
										<span class="icon icon-bubble2"></span>
										<a target="_blank" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" title="回复数"><?php echo $item['count_comment'];?></a>
										<span class="icon icon-heart"></span>
										<a target="_blank" href="<?php echo tsurl('review','show',array('id'=>$item['reviewid']))?>" title="喜欢数"><?php echo $item['count_love'];?></a>
									</span>
								</div>
								<div class="review_content">
									<?php echo cututf8(t($item['content']),0,80)?>
								</div>
								<div class="review_info">
									<span style="float:left;">
									<?php echo getTime($item['uptime'],time())?>
									</span>
									<span style="float:right;">
										
									</span>
								</div>
							</div>
							<div class="clear"></div>
						</li>
						<?php }?>
					</ul>
				</div>
				<div class="com-page"><?php echo $pageUrl;?></div>
				<?php } else { ?>
				<p style="width:640px;margin:15px 15px 30px 15px;text-align:center;color:gray;">暂无书评</p>
				<?php } ?>
			</div>
		</div>
		
	</div>
	<div class="bd-right">
		
		<p class="clearfix">
			<a href="<?php echo tsurl('review','add',array('bookid'=>$strBook['bookid']))?>" class="btn3d btn3d-two"><span class="icon-pen"></span> 发布书评(<?php echo $strBook['count_review'];?>)</a>
			<a href="javascript:void('0');" onclick="collectBook('<?php echo $strBook['bookid'];?>')" class="btn3d btn3d-two fr"><span class="icon-heart2"></span> 收藏(<?php echo $strBook['count_collect'];?>)</a>
		</p>
		
		<div id="book_set" class="com-box">
			<div class="content">
				<p class="info">
					<span class="icon icon-user2"></span> <a href="<?php echo tsurl('user','space',array('id'=>$strLeader['userid']))?>"  rel="face" uid="<?php echo $strLeader['userid'];?>"><?php echo $strLeader['username'];?></a>
					<span class="icon icon-file2"></span> 书评(<a href="<?php echo tsurl('book','show',array('id'=>$strBook['bookid']))?>"><?php echo $reviewNum;?></a>)<!--&nbsp;&nbsp;<span class="icon icon-users2"></span> <a href="<?php echo tsurl('book','user',array('id'=>$strBook['bookid']))?>"><?php echo $strBook['count_user'];?></a> 成员-->
				</p>
				<!--<p class="status">
					<?php if($isBookUser > 0 && $TS_USER['user'][userid] != $strBook['userid']) { ?>
					，我是本书的<?php echo $strBook['role_user'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="j a_confirm_link" href="<?php echo tsurl('book','do',array('ts'=>'exit','bookid'=>$strBook['bookid'],'token'=>$_SESSION['token']))?>" style="margin-left: 6px;">&gt;退出</a>
					<?php } elseif ($isBookUser > 0 && $TS_USER['user'][userid] == $strBook['userid']) { ?>
					，我是本书的<?php echo $strBook['role_leader'];?>
					<?php } elseif ($strBook['joinway'] == '0') { ?>
					，<a href="<?php echo tsurl('book','do',array('ts'=>'join','bookid'=>$strBook['bookid'],'token'=>$_SESSION['token']))?>">加入本图书成员</a>
					<?php } else { ?>
					，本图书圈子目前禁止加入
					<?php } ?>
				</p>
				<?php if($strBook['joinway']==1 && $strBook['userid'] == $TS_USER['user']['userid']) { ?>
				<p>
					<form method="post" action="<?php echo tsurl('book','do',array('ts'=>'invite'))?>">
						<input type="text" name="userid" value="" /> 
						<input type="hidden" name="bookid" value="<?php echo $strBook['bookid'];?>" />
						<button class="btn btn-success" type="submit">邀请</button>
					</form>
				</p>
				<?php } ?>
				-->
				<?php if($TS_USER['user'][userid] == $strBook['userid'] || $TS_USER['user']['isadmin']=='1') { ?>
				<p class="do">
					<span class="icon icon-pen"></span> <a href="<?php echo tsurl('book','edit',array('ts'=>'icon','bookid'=>$strBook['bookid']))?>">图书修改</a>
					<?php if($count_review_audit>0) { ?>
					&nbsp;&nbsp;<span class="icon icon-quill"></span> <a href="<?php echo tsurl('book','audit',array('ts'=>'review','bookid'=>$strBook['bookid']))?>">书评审核</a> (<?php echo $count_review_audit;?>)
					<?php } ?>
					<!--
					&nbsp;&nbsp;<span class="icon icon-cog"></span> <a href="<?php echo tsurl('book','edit',array(bookid=>$strBook['bookid'],ts=>set))?>">图书设置</a>
					-->
				</p>
				<?php } ?>
				<div class="clear"></div>
				<!--<p class="pl"><span class="feed"><a href="<?php echo tsurl('book','rss',array(bookid=>$strBook['bookid']))?>">feed: rss 2.0</a></span></p>-->

			</div>
		</div>
		
		<!--
		<div id="book_user" class="com-box">
			<h3>
				<span class="icon icon-users2"></span>
				图书成员
			</h3>
			<div class="content">
				<?php foreach((array)$arrBookUser as $key=>$item) {?>
				<dl>
				<dt>
					<a href="<?php echo tsurl('user','space',array('id'=>$item['userid']))?>" rel="face" uid="<?php echo $item['userid'];?>"><img class="m_sub_img" src="<?php echo $item['face'];?>" width="48" height="48" alt="<?php echo $item['username'];?>" title="<?php echo $item['username'];?>" /></a></dt>
					<dd><?php echo $item['username'];?></dd>
				</dl>
				<?php }?>
			</div>
		</div>
		-->
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>