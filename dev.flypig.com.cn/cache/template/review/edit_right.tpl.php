<?php defined('IN_TS') or die('Access Denied.'); ?>		<div class="com-box">
			<div class="content">
				&gt; <a href="<?php echo tsurl('book','show',array('id'=>$strBook['bookid']))?>">返回《<?php echo $strBook['bookname'];?>》</a>
			</div>
		</div>

		<?php doAction('gobad','300')?>
