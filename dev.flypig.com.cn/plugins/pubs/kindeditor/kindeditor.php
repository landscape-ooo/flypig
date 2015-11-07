<?php 
defined('IN_TS') or die('Access Denied.');
/*
@ adan 20131112
@ KindEditor 编辑器配置
@ 参照文档(http://kindeditor.net/docs/)
*/
function loadKindEditor($element,$style,$limit=0){
	echo "<script type=\"text/javascript\">\r\n";
	switch($style){
		case 'review_comment':
			echo "
				var defaultEditor;
				KindEditor.ready(function(K) {
					defaultEditor = K.create(\"".$element."\", {
						basePath : '/plugins/pubs/kindeditor/',
						readonlyMode : false,
						minWidth : 100,
						minHeight: 100,
						autoHeightMode : true,
						resizeType : 1,
						pasteType : 1,
						cssPath : '/plugins/pubs/kindeditor/themes/default/add.css',
						items : [
								'removeformat', '|', 'emoticons'
								],
						afterCreate : function(){
							this.loadPlugin('autoheight');
						},
						afterChange : function() {
							this.sync();
							if(K(\"".$element."_cnt\").length>0){
								K(\"".$element."_cnt\").html(this.count());
							}
						},
						afterFocus : function(){
							this.sync();
						},
						afterBlur:function(){
							this.sync();
						}
					});
				});\r\n";
			break;
			
		case 'bookadd':
			echo "
				var defaultEditor;
				KindEditor.ready(function(K) {
					defaultEditor = K.create(\"".$element."\", {
						basePath : '/plugins/pubs/kindeditor/',
						readonlyMode : false,
						minWidth : 100,
						minHeight : 100,
						autoHeightMode : true,
						resizeType : 1,
						pasteType : 1,
						cssPath : '/plugins/pubs/kindeditor/themes/default/add.css',
						items : [
								'removeformat', '|','bold', '|', 'justifyleft', 'justifycenter', 'justifyright', '|', 'emoticons', 'image', 'netvideo', 'link', '|', 'fullscreen'
								],
						afterCreate : function(){
							this.loadPlugin('autoheight');
						},
						afterChange : function() {
							this.sync();
							if(K(\"".$element."_cnt\").length>0){
								K(\"".$element."_cnt\").html(this.count());
							}
						},
						afterFocus : function(){
							this.sync();
						},
						afterBlur:function(){
							this.sync();
						}
					});
				});\r\n";
			break;
		case 'default':
		default:
			echo "
				var defaultEditor;
				KindEditor.ready(function(K) {
					defaultEditor = K.create(\"".$element."\", {
						basePath : '/plugins/pubs/kindeditor/',
						readonlyMode : false,
						minWidth : 100,
						minHeight: 100,
						autoHeightMode : true,
						resizeType : 1,
						pasteType : 1,
						cssPath : '/plugins/pubs/kindeditor/themes/default/add.css?v=".time()."',
						items : [
								'source','removeformat', '|','bold', '|', 'justifyleft', 'justifycenter', 'justifyright', '|', 'emoticons', 'image', 'netvideo', 'link', '|', 'fullscreen'
								],
						afterCreate : function(){
							this.sync();
							this.loadPlugin('autoheight');
							$('.ke-toolbar').scrollFix(53);
//							var self = this;
//							K.ctrl(document, 13, function() {
//								self.sync();
//								K('form[name=example]')[0].submit();
//							});
//							K.ctrl(self.edit.doc, 13, function() {
//								self.sync();
//								K('form[name=example]')[0].submit();
//							});
						},
						afterChange : function() {
							this.sync();
							if(K(\"".$element."_tip\").length>0){
								var limitNum = ".$limit.";
								//计算剩余字数
								if(limitNum>0){
									var result = limitNum - this.count('text');
									var patternTip = '还可以输入 <font color=\"red\">' + result + '</font> 字';
									K(\"".$element."_tip\").html(patternTip);
								}
							}
						},
						afterFocus : function(){
							this.sync();
						},
						afterBlur:function(){
							this.sync();
						}
					});
				});
			\r\n";
			break;
	}
	echo "</script>\r\n";
}

function jscssKindEditor(){
	echo "<link rel=\"stylesheet\" href=\"".SITE_URL."plugins/pubs/kindeditor/themes/default/default.css\" type=\"text/css\" />\r\n";
	echo "<script type=\"text/javascript\" src=\"".SITE_URL."plugins/pubs/kindeditor/kindeditor.js\"></script>\r\n";
	echo "<script type=\"text/javascript\" src=\"".SITE_URL."plugins/pubs/kindeditor/lang/zh_CN.js\"></script>\r\n";
}

if($_SESSION['tsuser']){
	addAction('pub_header_top','jscssKindEditor');
	addAction('tseditor2','loadKindEditor');
}