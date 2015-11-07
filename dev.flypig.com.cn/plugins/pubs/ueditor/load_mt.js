//实例化编辑器
var options = {
	toolbars:[['Bold','link','unlink']],
	lang:/^zh/.test(navigator.language || navigator.browserLanguage || navigator.userLanguage) ? 'zh-cn' : 'en',
	langPath:UEDITOR_HOME_URL + "lang/",
	initialFrameWidth:'100%',
	initialFrameHeight:100,
	focus:true
};
var ue = UE.getEditor('tseditor', options);

var domUtils = UE.dom.domUtils;

ue.addListener("ready", function () {
	ue.focus(true);
});

function setLanguage(obj) {
	var value = obj.value,
			opt = {
				lang:value
			};
	UE.utils.extend(opt, options, true);

	UE.getEditor("editor").destroy();
	UE.getEditor('editor', opt);
}
function createEditor() {
	enableBtn();
	UE.getEditor('editor', {
		initialFrameWidth:"100%"
	})
}
function getAllHtml() {
	alert(UE.getEditor('editor').getAllHtml())
}
function getContent() {
	var arr = [];
	arr.push("使用editor.getContent()方法可以获得编辑器的内容");
	arr.push("内容为：");
	arr.push(UE.getEditor('editor').getContent());
	alert(arr.join("\n"));
}
function getPlainTxt() {
	var arr = [];
	arr.push("使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容");
	arr.push("内容为：");
	arr.push(UE.getEditor('editor').getPlainTxt());
	alert(arr.join('\n'))
}
function setContent() {
	var arr = [];
	arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
	UE.getEditor('editor').setContent('欢迎使用ueditor');
	alert(arr.join("\n"));
}
function setDisabled() {
	UE.getEditor('editor').setDisabled('fullscreen');
	disableBtn("enable");
}

function setEnabled() {
	UE.getEditor('editor').setEnabled();
	enableBtn();
}

function getText() {
	//当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
	var range = UE.getEditor('editor').selection.getRange();
	range.select();
	var txt = UE.getEditor('editor').selection.getText();
	alert(txt)
}

function getContentTxt() {
	var arr = [];
	arr.push("使用editor.getContentTxt()方法可以获得编辑器的纯文本内容");
	arr.push("编辑器的纯文本内容为：");
	arr.push(UE.getEditor('editor').getContentTxt());
	alert(arr.join("\n"));
}
function hasContent() {
	var arr = [];
	arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
	arr.push("判断结果为：");
	arr.push(UE.getEditor('editor').hasContents());
	alert(arr.join("\n"));
}
function setFocus() {
	UE.getEditor('editor').focus();
}
function deleteEditor() {
	disableBtn();
	UE.getEditor('editor').destroy();
}
function disableBtn(str) {
	var div = document.getElementById('btns');
	var btns = domUtils.getElementsByTagName(div, "input");
	for (var i = 0, btn; btn = btns[i++];) {
		if (btn.id == str) {
			domUtils.removeAttributes(btn, ["disabled"]);
		} else {
			btn.setAttribute("disabled", "true");
		}
	}
}
function enableBtn() {
	var div = document.getElementById('btns');
	var btns = domUtils.getElementsByTagName(div, "input");
	for (var i = 0, btn; btn = btns[i++];) {
		domUtils.removeAttributes(btn, ["disabled"]);
	}
}