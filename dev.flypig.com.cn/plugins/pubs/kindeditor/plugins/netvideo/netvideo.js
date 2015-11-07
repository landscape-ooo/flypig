/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('netvideo', function(K) {
	var self = this, name = 'netvideo', lang = self.lang(name + '.'),
		allowNetvideoUpload = K.undef(self.allowNetvideoUpload, true),
		allowFileManager = K.undef(self.allowFileManager, false),
		formatUploadUrl = K.undef(self.formatUploadUrl, true),
		extraParams = K.undef(self.extraFileUploadParams, {}),
		filePostName = K.undef(self.filePostName, 'imgFile'),
		uploadJson = K.undef(self.uploadJson, self.basePath + 'php/upload_json.php');
	self.plugin.netvideo = {
		edit : function() {
			var html = [
				'<div style="padding:20px;">',
				//url
				'<div class="ke-dialog-row">',
				'<label for="keUrl" style="width:60px;">' + lang.url + '</label>',
				'<input class="ke-input-text" type="text" id="keUrl" name="url" value="" style="width:300px;" /> &nbsp;',
				'</div>',
				//width
				'<div class="ke-dialog-row">',
				'<label for="keWidth" style="width:60px;">' + lang.width + '</label>',
				'<input type="text" id="keWidth" class="ke-input-text ke-input-number" name="width" value="500" maxlength="4" /> ',
				//blank
				'<label for="keWidth" style="width:60px;"></label>',
				//height
				'<label for="keHeight" style="width:60px;">' + lang.height + '</label>',
				'<input type="text" id="keHeight" class="ke-input-text ke-input-number" name="height" value="400" maxlength="4" /> ',
				'</div>',
				'<div class="ke-dialog-row">',
				'<label for="keWidth" style="width:400px;">' + lang.tips + '</label>',
				'</div>',
				'</div>'
			].join('');
			var dialog = self.createDialog({
				name : name,
				width : 450,
				title : self.lang(name),
				body : html,
				yesBtn : {
					name : self.lang('yes'),
					click : function(e) {
						var url = K.trim(urlBox.val()),
							width = widthBox.val(),
							height = heightBox.val();
						if (url == 'http://' || K.invalidUrl(url)) {
							alert(self.lang('invalidUrl'));
							urlBox[0].focus();
							return;
						}
						if (!/^\d*$/.test(width)) {
							alert(self.lang('invalidWidth'));
							widthBox[0].focus();
							return;
						}
						if (!/^\d*$/.test(height)) {
							alert(self.lang('invalidHeight'));
							heightBox[0].focus();
							return;
						}
						
						//根据URL解析视频地址
						//注：不支持新浪视频和乐视
						//优酷
						//优酷：http://v.youku.com/v_show/id_XNzMwMzI1MzY0_ev_1.html?from=y1.3-idx-grid-1519-9909.86808-86807.1-1
						if (url.indexOf('.html')!=-1 && url.indexOf('.youku.com')!=-1){
								//var urlArr = [];
								//urlArr = newUrl.split('/');
								var regexYouku1 = /id_[0-9a-zA-Z]+/;
								if (url.match(regexYouku1)){
									var youKu1 = url.match(regexYouku1);
									var urlOut = 'http://player.youku.com/player.php/sid/'+youKu1[0].replace('id_','')+'/v.swf';
								}else{
									alert(self.lang('invalidUrl'));
									urlBox[0].focus();
									return;
								}
						}
						//http://player.youku.com/player.php/sid/XNzMwMzI1MzY0/v.swf
						if (url.indexOf('.swf')!=-1 && url.indexOf('.youku.com')!=-1){
								var regexYouku2 = /sid\/[0-9a-zA-Z]+/;
								if (url.match(regexYouku2)){
									var youKu2 = url.match(regexYouku2);
									var urlOut = 'http://player.youku.com/player.php/sid/'+youKu2[0].replace('sid/','')+'/v.swf';
								}else{
									alert(self.lang('invalidUrl'));
									urlBox[0].focus();
									return;
								}
						}
						
						//土豆
						//土豆：http://www.tudou.com/albumplay/bXTHnX7iFbQ/tx52808mNCw.html
						if (url.indexOf('.html')!=-1 && url.indexOf('.tudou.com')!=-1){
								var regexTudou1 = /albumplay\/[0-9a-zA-Z]+/;
								if (url.match(regexTudou1)){
									var tuDou1 = url.match(regexTudou1);
									var urlOut = 'http://www.tudou.com/a/'+tuDou1[0].replace('albumplay/','')+'/v.swf';
								}else{
									alert(self.lang('invalidUrl'));
									urlBox[0].focus();
									return;
								}
						}
						//http://www.tudou.com/a/bXTHnX7iFbQ/&bid=05&iid=131749185&resourceId=0_05_05_99/v.swf
						if (url.indexOf('.swf')!=-1 && url.indexOf('.tudou.com')!=-1){
								var regexTudou2 = /a\/[0-9a-zA-Z]+/;
								if (url.match(regexTudou2)){
									var tuDou2 = url.match(regexTudou2);
									var urlOut = 'http://www.tudou.com/a/'+tuDou2[0].replace('a/','')+'/v.swf';
								}else{
									alert(self.lang('invalidUrl'));
									urlBox[0].focus();
									return;
								}
						}
						
						//酷6
						//酷6：http://v.ku6.com/show/qLp5gUR8Z31NUfRPvXDpmg...html?hpsrc=1_9_1_1_0
						if (url.indexOf('.html')!=-1 && url.indexOf('.ku6.com')!=-1){
								var regexKu1 = /show\/[0-9a-zA-Z.]+[.]html/;
								if (url.match(regexKu1)){
									var ku1 = url.match(regexKu1);
									var ku3 = ku1[0].replace('.html','');
									var urlOut = 'http://player.ku6.com/refer/'+ku3.replace('show/','')+'/v.swf';
								}else{
									alert(self.lang('invalidUrl'));
									urlBox[0].focus();
									return;
								}
						}
						//http://player.ku6.com/refer/qLp5gUR8Z31NUfRPvXDpmg../v.swf
						if (url.indexOf('.swf')!=-1 && url.indexOf('.ku6.com')!=-1){
								var regexKu2 = /refer\/[0-9a-zA-Z.]+/;
								if (url.match(regexKu2)){
									var ku2 = url.match(regexKu2);
									var urlOut = 'http://player.ku6.com/'+ku2[0]+'/v.swf';
								}else{
									alert(self.lang('invalidUrl'));
									urlBox[0].focus();
									return;
								}
						}
						
						//56
						//56：http://www.56.com/u97/v_MTE3MjI1NTAy.html
						if (url.indexOf('.html')!=-1 && url.indexOf('.56.com')!=-1){
								var regex561 = /v_[0-9a-zA-Z]+[.]html/;
								if (url.match(regex561)){
									var k51 = url.match(regex561);
									var urlOut = 'http://player.56.com/'+k51[0].replace('.html','')+'.swf';
								}else{
									alert(self.lang('invalidUrl'));
									urlBox[0].focus();
									return;
								}
						}
						//http://player.56.com/v_MTE3MjI1NTAy.swf
						if (url.indexOf('.swf')!=-1 && url.indexOf('.56.com')!=-1){
								var regex562 = /v_[0-9a-zA-Z]+[.]swf/;
								if (url.match(regex562)){
									var k52 = url.match(regex562);
									var urlOut = 'http://player.56.com/'+k52[0]+'.swf';
								}else{
									alert(self.lang('invalidUrl'));
									urlBox[0].focus();
									return;
								}
						}
						
						//腾讯
						//腾讯：http://v.qq.com/boke/page/i/z/s/i0130tfphzs.html
						if (url.indexOf('.html')!=-1 && url.indexOf('.qq.com')!=-1){
							var regexQq1 = /\/[0-9a-zA-Z]+[.]html/;
							if (url.match(regexQq1)){
								var qq1 = url.match(regexQq1);
								//alert(typeof(qq1));
								//alert(qq1[0]);
								//return;
								var qq3 = qq1[0].replace(/\//,"")
								var urlOut = 'http://static.video.qq.com/TPout.swf?vid='+qq3.replace('.html','')+'&auto=0';
							}else{
								alert(self.lang('invalidUrl'));
								urlBox[0].focus();
								return;
							}
						}
						//http://static.video.qq.com/TPout.swf?vid=i0130tfphzs&auto=0
						//http://static.video.qq.com/TPout.swf?vid=vid=i0130tfphzs&auto=0
						if (url.indexOf('.swf')!=-1 && url.indexOf('static.video.qq.com')!=-1){
							var regexQq2 = /vid=[0-9a-zA-Z]+/;
							if (url.match(regexQq2)){
								var qq2 = url.match(regexQq2);
								var urlOut = 'http://static.video.qq.com/TPout.swf?'+qq2[0]+'&auto=0';
							}else{
								alert(self.lang('invalidUrl'));
								urlBox[0].focus();
								return;
							}
						}
						
						var html = K.mediaImg(self.themesPath + 'common/blank.gif', {
								src : urlOut,
								type : K.mediaType('.swf'),
								width : width,
								height : height,
								quality : 'high'
							});
						self.insertHtml(html).hideDialog().focus();
					}
				}
			}),
			div = dialog.div,
			urlBox = K('[name="url"]', div),
			viewServerBtn = K('[name="viewServer"]', div),
			widthBox = K('[name="width"]', div),
			heightBox = K('[name="height"]', div);
			urlBox.val('http://');

			if (allowNetvideoUpload) {
				var uploadbutton = K.uploadbutton({
					button : K('.ke-upload-button', div)[0],
					fieldName : filePostName,
					extraParams : extraParams,
					url : K.addParam(uploadJson, 'dir=netvideo'),
					afterUpload : function(data) {
						dialog.hideLoading();
						if (data.error === 0) {
							var url = data.url;
							if (formatUploadUrl) {
								url = K.formatUrl(url, 'absolute');
							}
							urlBox.val(url);
							if (self.afterUpload) {
								self.afterUpload.call(self, url, data, name);
							}
							alert(self.lang('uploadSuccess'));
						} else {
							alert(data.message);
						}
					},
					afterError : function(html) {
						dialog.hideLoading();
						self.errorDialog(html);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					dialog.showLoading(self.lang('uploadLoading'));
					uploadbutton.submit();
				});
			} else {
				K('.ke-upload-button', div).hide();
			}

			if (allowFileManager) {
				viewServerBtn.click(function(e) {
					self.loadPlugin('filemanager', function() {
						self.plugin.filemanagerDialog({
							viewType : 'LIST',
							dirName : 'netvideo',
							clickFn : function(url, title) {
								if (self.dialogs.length > 1) {
									K('[name="url"]', div).val(url);
									if (self.afterSelectFile) {
										self.afterSelectFile.call(self, url);
									}
									self.hideDialog();
								}
							}
						});
					});
				});
			} else {
				viewServerBtn.hide();
			}

			var img = self.plugin.getSelectedNetvideo();
			if (img) {
				var attrs = K.mediaAttrs(img.attr('data-ke-tag'));
				urlBox.val(attrs.src);
				widthBox.val(K.removeUnit(img.css('width')) || attrs.width || 0);
				heightBox.val(K.removeUnit(img.css('height')) || attrs.height || 0);
			}
			urlBox[0].focus();
			urlBox[0].select();
		},
		'delete' : function() {
			self.plugin.getSelectedNetvideo().remove();
			// [IE] 删除图片后立即点击图片按钮出错
			self.addBookmark();
		}
	};
	self.clickToolbar(name, self.plugin.netvideo.edit);
});
