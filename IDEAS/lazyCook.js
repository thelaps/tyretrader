$.extend({
    lazyCook:{
        init:function(sObj){
            var oObj=$(sObj);
            console.log('lazyCook-> initialize',sObj);
            oObj.bind({
                change:function(){
                    console.log('lazyCook-> cange state');
                    //var fn=$(this).attr('data-fn');
                    var id=$(this).attr('data-id');
                    if($(this).is(':checked')){
                        console.log('lazyCook-> add to WL: '+id);
                        $.lazyCook.add(id);
                    }else{
                        console.log('lazyCook-> remove from WL: '+id);
                        $.lazyCook.remove(id);
                    }
                }
            });
        },
        add:function(id){
            var wl_data=$.lazyCook.getCookie('mobile_wishlist');
            var wl_exportStr=new Array;
            if(wl_data!=undefined){
                $.lazyCook.setCookie('mobile_wishlist', null, { expires: -1 });
                var wl_array=wl_data.split(',');

                var wl_length=wl_array.length;
                for(i=0; i<wl_length; i++){
                    if(id!=wl_array[i]){
                        wl_exportStr.push(wl_array[i]);
                    }
                }
                wl_exportStr.push(id);
            }else{
                wl_exportStr[0]=id;
            }
            $.lazyCook.setCookie('mobile_wishlist',wl_exportStr,{expires:3600,path:'/'});
        },
        remove:function(id){
            var wl_data=$.lazyCook.getCookie('mobile_wishlist');
            if(wl_data!=undefined){
                if(id!=undefined){
                    var wl_array=wl_data.split(',');
                    var wl_exportStr=new Array;
                    var wl_length=wl_array.length;
                    for(i=0; i<wl_length; i++){
                        if(id!=wl_array[i]){
                            wl_exportStr.push(wl_array[i]);
                        }
                    }
                    $.lazyCook.setCookie('mobile_wishlist',wl_exportStr,{expires:3600,path:'/'});
                }else{
                    $.lazyCook.setCookie('mobile_wishlist', null, { expires: -1 });
                }
            }
        },
        getCookie:function(name){
            var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
            console.log('lazyCook-> getCookie',name,matches);
            return matches ? decodeURIComponent(matches[1]) : undefined;
        },
        setCookie:function(name, value, props){
            console.log('lazyCook-> setCookie',name,value,props);
            props = props || {};
            var exp = props.expires;
            if(typeof exp == "number" && exp){
                var d = new Date();
                d.setTime(d.getTime() + exp*1000);
                exp = props.expires = d;
            }
            if(exp && exp.toUTCString) {
                props.expires = exp.toUTCString();
            }

            value = encodeURIComponent(value);
            var updatedCookie = name + "=" + value;
            for(var propName in props){
                updatedCookie += "; " + propName;
                var propValue = props[propName];
                if(propValue !== true){
                    updatedCookie += "=" + propValue;
                }
            }
            console.log('lazyCook-> cookieReturn',updatedCookie);
            document.cookie = updatedCookie;
        }
    }
});
