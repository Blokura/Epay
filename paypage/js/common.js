function getId(value){
    return document.getElementById(value);
}

//ajax post
function Post(option){
	var url = option.url || "";
	var data = (function(){
        var text = '';
        if(option.data && option.data.constructor == Object){
            var arr = [];
            for(var key in option.data){
                arr.push(key+'='+option.data[key]);
            }
            text = arr.join('&');
        }
        return text;
    })();
    var toJson = option.dataType == 'text' ? false : true;
	var success = option.success || function(){};
	var error = option.error || function(){};
    var timeout = option.timeout || 30000;
	var isTimeout = false;
	var http = new XMLHttpRequest();
	var timer = setTimeout(function(){
		isTimeout = true;
		http.abort();
		error();
	},timeout);
	http.open("POST",url,true);
	http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	http.onreadystatechange = function(){
		if(http.readyState != 4 || isTimeout){return;}
		clearTimeout(timer);
		if(http.status == 200){
            var response = toJson ? JSON.parse(http.responseText) : http.responseText;
			success(response);
		}else{
			error();
		}
	};
	http.send(data);
}

//loading
function Loading(){
    var obj = document.createElement('div');
    var box = document.createElement('div');
    var img = document.createElement('div');
    var txt = document.createElement('p');
    
    obj.className = 'circle-box none';
    box.className = 'circle_animate';
    img.className = 'circle';
    box.appendChild(img);
    box.appendChild(txt);
    obj.appendChild(box);
    if(script){
        script.parentNode.insertBefore(obj,script);
    }else{
        document.body.appendChild(obj);
    }
    
    this.show = function(value){
        txt.innerHTML = value || '加载中...';
        obj.classList.remove('none');
    };
    
    this.hide = function(){
        obj.classList.add('none');
        txt.innerHTML = '';
    };
}

//tips
function Tips(){
    var obj = document.createElement('div');
    var box = document.createElement('div');
    var con = document.createElement('div');
    var txt = document.createElement('div');
    var p = document.createElement('p');
    var btnBox = document.createElement('p');
    var btn = document.createElement('span');
    
    obj.className = 'pop_wrapper none';
    box.className = 'pop_outer';
    con.className = 'pop_cont';
    txt.className = 'pop_tip';
    p.className = 'border b_top';
    btnBox.className = 'pop_wbtn';
    btn.className='pop_btn'
    
    btn.innerHTML = '我知道了';
    
    p.appendChild(btn);
    con.appendChild(txt);
    con.appendChild(p);
    box.appendChild(con);
    obj.appendChild(box);
    if(script){
        script.parentNode.insertBefore(obj,script);
    }else{
        document.body.appendChild(obj);
    }
    
    function hideFun(){
        obj.classList.add('none');
    }
    
    this.show = function(value,callback){
        var fun = callback || hideFun;
        txt.innerHTML = value || ' ';
        p.onclick = callback || hideFun;
        obj.classList.remove('none');
    };
    
    this.hide = hideFun;
}

document.body.addEventListener('touchstart',function(){},false);
var script = document.body.getElementsByTagName('script')[0];
var loading = new Loading();