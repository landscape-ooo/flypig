 /**
 * 图片预加载等比例缩放
 */
jQuery.fn.imgLoader=function(scaling,width,height,loadpic){
	if(loadpic==null)loadpic="/public/images/loading.gif";
	return this.each(function(){
		var t=$(this);
		var src=$(this).attr("src")
		var img=new Image();
		img.src=src;
		//自动缩放图片
		var autoScaling=function(){
			if(scaling){
			
				if(img.width>0 && img.height>0){ 
					if(img.width/img.height>=width/height){ 
						if(img.width>width){ 
							t.width(width); 
							t.height((img.height*width)/img.width); 
						}else{ 
							t.width(img.width); 
							t.height(img.height); 
						} 
					} 
					else{ 
						if(img.height>height){ 
							t.height(height); 
							t.width((img.width*height)/img.height); 
						}else{ 
							t.width(img.width); 
							t.height(img.height); 
						} 
					} 
				} 
			}	
		}
		if(img.complete){
			autoScaling();
			return;
		}
		$(this).attr("src","");
		var loading=$("<img alt=\"加载中...\" title=\"图片加载中...\" src=\""+loadpic+"\" />");
		
		t.hide();
		t.after(loading);
		$(img).load(function(){
			autoScaling();
			loading.remove();
			t.attr("src",this.src);
			loading.remove();
			t.show();
		});
		
	});
}