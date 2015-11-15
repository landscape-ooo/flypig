<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base']['site_title'];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('share','index')?>" title="飞猪网好分享">好分享</a>  &gt;  分类管理
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="share_list">
			
			<div class="com-bar clearfix">
				<div class="com-bar-tit">
					<span class="icon icon-cog"></span>
					我的分类
				</div>
				<div class="com-bar-more">
					&nbsp;&nbsp;<span class="icon icon-plus"></span> <a href="<?php echo tsurl('share','cate',array('ts'=>'add'))?>">添加分类</a>
				</div>
			</div>
			
			<table id="cate-list" class="com-table">
				<tr class="old">
					<td>分类ID</td>
					<td>分类名称</td>
					<td>分享内容统计</td>
					<td>操作</td>
				</tr>
				<?php foreach((array)$arrCate as $key=>$item) {?>
				<tr class="odd">
					<td><?php echo $item['cateid'];?></td>
					<td><?php echo $item['catename'];?></td>
					<td><?php echo $item['count_share'];?></td>
					<td>
						<a href="<?php echo SITE_URL;?>index.php?app=share&ac=cate&ts=edit&cateid=<?php echo $item['cateid'];?>">[修改]</a>
						<a href="<?php echo SITE_URL;?>index.php?app=share&ac=cate&ts=del&cateid=<?php echo $item['cateid'];?>&token=<?php echo $_SESSION['token'];?>" onclick="return confirm('确定删除?')">[删除]</a>
					</td>
				</tr>
				<?php }?>
			</table>
			
		</div>
		
	</div>
	<div class="bd-right">
		
		<?php if($TS_APP['options']['iscreate']==0 || $TS_USER['user']['isadmin']==1) { ?>
		<a class="btn3d btn3d-full" href="<?php echo tsurl('share','add')?>" style="margin-top:30px;"><span class="icon-pen"></span> 发布分享</a>
		<?php } ?>
		
		<!--广告位-->
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php include template('footer'); ?>