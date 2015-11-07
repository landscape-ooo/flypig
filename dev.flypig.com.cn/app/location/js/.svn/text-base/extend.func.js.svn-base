function joinLocation(locationid){
	$.post(siteUrl+'index.php?app=location&ac=ajax&ts=join',{'locationid':locationid},function(rs){
		if(rs==0){
			art.dialog({
				lock: true,
				content: '请登陆后再加入',
				time: 2000
			})
		}else if(rs==1){
			art.dialog({
				lock: true,
				content: '加入成功！',
				time: 2000
			})
			
			window.location.reload()
			
		}
	})
}