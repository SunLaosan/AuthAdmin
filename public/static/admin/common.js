	/**发送ajax请求
     * [sendAjax description]
     * @param  {[type]} url     [description]
     * @param  {[type]} jumpUrl [description]
     * @param  {[type]} data    [description]
     * @param  {String} method  [description]
     * @return {[type]}         [description]
     */
function sendAjax(url,jumpUrl,data,method = "POST")
{
	$.ajax({
        url: url,
        type: method,
        data: data,
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.code == 1) {
                layer.msg(data.msg,{icon:1,time:1000});
                window.setTimeout("window.location='" + jumpUrl + "'", 1000);
            } else {
                layer.msg(data.msg,{icon:5,time:1000});
            }
               
        },
        error:function (data) {
            console.log(data);
        }
    });

}
/*批量删除*/
function datadel(url)
{
    layer.confirm('确认要删除吗？删除不可恢复！',function(index){
        var cks=$("[name='delids']");  
        var str='';  //拼接id  
        for(var i=0;i<cks.length;i++){  
            if(cks[i].checked){  
                if(cks[i].value!=0){
                    str+=cks[i].value+","; 
                }
            }  
         }  //去掉字符串末尾的‘&'  
         str=str.substring(0, str.length-1); 
        //console.log(str);
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                id:str
            },
            success: function(data){
                if(data.code==1){
                    layer.msg(data.msg,{icon:1,time:1000});
                     location.reload(true);
                }else{
                    layer.msg(data.msg,{icon:5,time:1000});
                }
            },
            error:function(data) {
                console.log(data.msg);
            },
        });     
    });
}
/*单条删除*/
function article_del(obj,id,url){
    layer.confirm('确认要删除吗？删除不可恢复！',function(index){
        $.ajax({
            type: 'POST',
            url: url,
            data:{
                id:id
            },
            dataType: 'json',
            success: function(data){
                if(data.code==1){
                //$(obj).parents("tr").remove();
                layer.msg(data.msg,{icon:1,time:1000});
                location.reload(true);
                }else{
                    layer.msg(data.msg,{icon:5,time:1000});
                }
            },
            error:function(data) {
             console.log(data.msg);
            },
        });     
    });
}

