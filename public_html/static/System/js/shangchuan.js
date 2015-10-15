//此处js作用为初始化上传组件，并且对上传成功之后的数据进行处理。swfurl为swf文件的路径，uploadurl为上传文件提交的php程序路径,delurl为删除文件路径
        $(document).ready(function()
        {
            $("#file_upload").uploadify({
                 'swf' : swfurl,
				 'uploader' : uploadurl,
				 'cancelImage': 'uploadify-cancel.png',
        		 'buttonClass': 'btn btn-primary',
				 'height':'36px',
				 'width':'102px',
				 'removeTimeout': 0,
				 'uploadLimit':count,
				 'fileSizeLimit': '300kb',
				 'buttonText': '<i class="icon-plus-sign"></i> 添加图片',
				 'buttonCursor': 'pointer',
				 'onUploadError': function (file, errorCode, errorMsg, errorString, queue) { alert(file.name + "上传失败"+errorMsg+"   "+errorString) },
				 'onUploadStart': function (file) {
					$('#file_upload-button').html('<i class="icon-plus-sign"></i> 继续上传');
					if ($("#bsubmit").length == 0) { $('#file_upload-button').parent().append('   <button id="bsubmit" type="submit" data-loading-text="提交中..." class="btn">保存</button>') }
		  
				},
				'onInit': function(instance) {
					if ((count - $("li.imgbox").length) <= 0) {
						var button = $("#file_upload-button");
						button.addClass("disabled").attr("style", "z-index: 999;")
						button.html('上传已达限制...');
					}
				},
				'onUploadSuccess': function (file, data, response) {
			//	alert(data);
				  // var json = $.parseJSON(data);
				  var json=eval("("+data+")")

					if (json.result !== 'SUCCESS') {
						alert(json.message || data);
						return;
					}else{
						//alert(json.image);
						addFile(json.image.Filedata);
					}
				} 
            });
			
			$('#fileList .item_close').live('click', function () {
				if(confirm("确定要删除吗？")){
				var el = $(this).parent();
				var rs=delimg(el.attr('data-url'),el.attr('data-post-id'),delurl,el);

				}
       		 });
        });
function addFile(image) {
			
    var el = $('<li class="imgbox" data-url="'+image.savepath + image.savename+'" data-post-id="0"><a class="item_close" href="javascript:void(0)" title="删除"></a> <input type="hidden" value="'+image.savepath + image.savename+'" name="phout_url[]" /> <span class="item_box"><img src="'+image.savepath + image.savename+'" /></span> <span class="item_input"> <input name="imagestitle[]" class="imagestitle" placeholder="图片标题" value="'+image.name+'" /></span> <textarea name="imagestexts[]" class="imagestexts" cols="3" rows="4" style="resize: none" data-rule-maxlength="150" placeholder="图片描述..."></textarea></li>').appendTo($('#fileList'));
    //$("html,body").animate({scrollTop:'+=145'})
    return el;
    //根据现在的代码，上传成功或者像素数提示的字符被隐藏无法显示出来。
}  

function delimg(imgurl,imgid,delurl,el){

	$.post(delurl,{'imgurl':imgurl,'imgid':imgid},function(data){
			 var json=eval("("+data+")")

			 if(json.result=="SUCCESS"){
				 el.remove(); 
				return true;	 
			}
			return false;
	});
}