<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('ask')?>" title="<?php echo $TS_APP['options'][appname];?>"><?php echo $TS_APP['options'][appname];?></a>  &gt;  问答列表
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div class="com-bar clearfix">
			<?php if($ts == 'new') { ?>
			<div class="com-bar-tit">
				<span class="icon icon-question"></span>
				待解决的问题
				<span class="f12 color-gray">(<?php echo $askNum;?>)</span>
			</div>
			<div class="com-bar-more">
				&nbsp;&nbsp;<span class="icon icon-bubbles3"></span> <a href="<?php echo tsurl('ask')?>">最新问答</a>
			</div>
			<?php } else { ?>
			<div class="com-bar-tit">
				<span class="icon icon-bubbles3"></span>
				最新问答
				<span class="f12 color-gray">(<?php echo $askNum;?>)</span>
			</div>
			<div class="com-bar-more">
				&nbsp;&nbsp;<span class="icon icon-question"></span> <a href="<?php echo tsurl('ask', 'index', array('ts'=>'new'))?>">待解决的问题</a>
			</div>
			<?php } ?>
		</div>
		
		<ul id="ask_list">
			<?php foreach((array)$askArr as $v) {?>
			<li class="clearfix">
				<div class="li-face">
					<a href="<?php echo tsurl('user','space',array('id'=>$v[userid]))?>">
						<img alt="<?php echo $v[user][username];?>" class="userface" src="<?php echo $v[user][face];?>" width="75" height="75" />
						<span class="username"><?php echo $v['user']['username'];?></span>
					</a>
				</div>
				<div class="li-info">
					
					<h2 class="title wordfix">
						<a href="<?php echo tsurl('ask', 'show', array('id'=>$v['askid']))?>" target="_blank"><?php echo $v['title'];?></a>
					</h2>
					
					<div class="meta">
						<?php echo $v['actionarr']['addtime'];?><?php if($v['cate']) { ?>&nbsp;&nbsp;•&nbsp;&nbsp;分类：<?php foreach((array)$v['cate'] as $k=>$c) {?><a href="<?php echo tsurl('ask', 'cate', array('cateid'=>$c['cateid']))?>"><?php echo $c['catename'];?></a><?php if(((count($v['cate'])-1)>$k)) { ?>、<?php } ?><?php }?><?php } ?>&nbsp;&nbsp;•&nbsp;&nbsp;<?php echo $v['count_comment'];?> 答案
					</div>
					
					<div class="content wordfix">
						<?php echo cututf8(t($v['summary']),0,80)?>
					</div>
					
					<div class="more">
						<a class="btn-more" href="<?php echo tsurl('ask', 'show', array('id'=>$v['askid']))?>" target="_blank">Read More</a>
					</div>
					
				</div>
			</li>
			<?php } ?>
		</ul>
		
		<div class="com-page"><?php echo $pageUrl;?></div>
		
	</div>
	<div class="bd-right">
		
		<?php if($TS_APP['options']['iscreate']==0 || $TS_USER['user']['isadmin']=='1') { ?>
		<a class="btn3d btn3d-full" href="<?php echo tsurl('ask', 'add')?>"><span class="icon-pen"></span> 我要提问</a><br><br>
		<?php } ?>
		
		<div class="com-box">
			<div class="com-bar3 clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-tags"></span>
					问答分类
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;
				</div>
			</div>
			<ul class="side-tags" id="tagList">
				<?php foreach((array)$arrCate as $v) {?>
				<li>
					<p class="side-tags-l"><a class="tag<?php if($myCateArr) { ?><?php foreach((array)$myCateArr as $cate) {?><?php if($cate['cateid']==$v['cateid']) { ?> selected<?php } ?><?php } ?><?php } ?>" href="<?php echo tsurl('ask', 'cate', array('cateid'=>$v['cateid']))?>"><?php echo $v['catename'];?><span class="followCounter">(<?php echo $v['count_ask'];?>)</span></a></p>
					<a data-id="<?php echo $v['cateid'];?>" data-operation="follow" class="followBt side-tags-<?php if($myCateArr) { ?><?php foreach((array)$myCateArr as $cate) {?><?php if($cate['cateid']==$v['cateid']) { ?>un<?php } ?><?php } ?><?php } ?>follow" href="javascript:void 0;"><?php if($myCateArr) { ?><?php foreach((array)$myCateArr as $cate) {?><?php if($cate['cateid']==$v['cateid']) { ?>取消<?php } ?><?php } ?><?php } ?>关注</a>
				</li>
				<?php } ?>
			</ul>
		</div>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>