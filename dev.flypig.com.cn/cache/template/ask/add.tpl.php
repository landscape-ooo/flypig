<?php defined('IN_TS') or die('Access Denied.'); ?><?php include template('header'); ?>

<div id="path" class="bd clearfix">
	<span class="icon icon-home"></span>
	<a href="<?php echo SITE_URL;?>" title="<?php echo $TS_SITE['base'][site_title];?>首页">首页</a>  &gt;  <a href="<?php echo tsurl('ask')?>" title="<?php echo $TS_APP['options'][appname];?>"><?php echo $TS_APP['options'][appname];?></a>  &gt;  提新问题
</div>

<div id="bd" class="bd clearfix">
	<div class="bd-left">
		
		<div id="ask-edit" class="com-box">
			<div class="editor">
				
				<form method="POST" action="<?php echo SITE_URL;?>index.php?app=ask&ac=add&ts=do" onsubmit="return addFormCheck()">
				<table class="com-table">
					<tr>
						<th>问题标题：</th>
						<td>
							<input type="text" name="title" value="" style="width:494px;height:24px;" maxlength="64">
						</td>
					</tr>
					<tr>
						<th>详细说明：</th>
						<td>
							<textarea name="content" style="width:500px;height:300px;" id="content"></textarea>
						</td>
					</tr>
					<tr>
						<th>分类：</th>
						<td>
							<i class="tip">将问题投递到正确的分类会有助于更快的获得解答</i><br>
							<div id="tag-cates" class="tag-cates clearfix">
								<?php foreach((array)$arrCate as $v) {?>
								<a data-id="<?php echo $v['cateid'];?>" class="tag-cate<?php if($v['cateid'] == $cateid) { ?> selected<?php } ?>" href="javascript:void 0;"><?php echo $v['catename'];?></a>
								<?php } ?>
								<?php if($cateid != 0) { ?><input id="tag-cate<?php echo $cateid;?>" type="hidden" value="<?php echo $cateid;?>" name="tag[]"><?php } ?>
							</div>
						</td>
					</tr>
					<?php if($TS_SITE['base']['isauthcode']) { ?>
					<tr>
						<th>验证码：</th>
						<td>
							<input name="authcode" /> <img align="absmiddle" src="<?php echo tsurl('pubs','code')?>" onclick="javascript:newgdcode(this,this.src);" title="点击刷新验证码" alt="点击刷新验证码" style="cursor:pointer;"/>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<th></th>
						<td>
							<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
							<button class="btn btn-ok" type="submit">提 交</button>
							&nbsp;&nbsp;<a href="<?php echo tsurl('ask')?>">取消</a>
						</td>
					</tr>
				</table>
				</form>
				<script type="text/javascript">
				function addFormCheck(){
					var title = $("input[name='title']").val();
					var content = $("input[name='content']").val();
					if(title == '' || content == ''){
						alert('请填写标题和内容');
						return false;
					}
					var tags = 0;
					$("input[name^=tag]").each(function() {
						if($(this).val()!='') tags = tags + 1;
					});
					
					if(tags == 0){
						alert('请选择分类');
						return false;
					}
					<?php if($TS_SITE['base']['isauthcode']) { ?>
					var authcode = $('input[name=authcode]').val();
					if(authcode == ''){
						alert('请填写验证码');
						return false;
					}
					<?php } ?>
					$("button[type='submit']").html('正在提交^_^').css({'background':'#ccc'}).removeAttr('type');
				}
				</script>
				
			</div>
		</div>
		
	</div>
	<div class="bd-right">
		
		<div id="createTip" class="com-box">
			<h3>
				<span class="icon icon-bullhorn"></span>
				友情提示
			</h3>
			<div class="content">
				<p>以下要点可以方便你更快寻求到靠谱的答案：</p>
				<ul>
					<li>请先搜索是否已经有同类问题得到解决；</li>
					<li>请在标题使用更精确的描述定义你的问题，而不要“详情请入内”；</li>
					<li>用户更热衷于回答能引起思考和讨论的知识性问题；</li>
					<!--<li>提问时，@相关领域的达人们，会让他们更快关注到你的问题；</li>-->
				</ul>
				<!--<a href="<?php echo tsurl('ask', 'help')?>" target="_blank" style="float:right">问答详细指南&gt;&gt;</a>-->
			</div>
		</div>
		
		<?php doAction('gobad','300')?>
		
	</div>
</div>

<?php doAction('tseditor2','#content')?>

<?php include template('footer'); ?>