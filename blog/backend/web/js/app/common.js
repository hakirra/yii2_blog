//wuhan code
Array.prototype.indexOf = function (val) {//判断数组是否存在某个值，如果存在返回该值对应的索引，否则返回-1
    for (var i = 0; i < this.length; i++) {	
        if(typeof val === 'object' && typeof this[i]==='object'){
             var str1 = JSON.stringify(val);
            var str2 = JSON.stringify(this[i]);
            var index = str1.indexOf('bool');
            if(index>0 && str1.substring(0,index) === str2.substring(0,index)){
                return i;
            }
//          if(str1 === str2) return i;                 
        }
        if (this[i] === val) return i;
    }
    return -1;
};

/*
*删除指定的元素,支持数组对象
*num为删除的个数，从当前的元素开始算，可选
*item1和item2给删除的元素的位置上插入新元素，可选
**/
Array.prototype.remove = function (val, num, item1, item2) {
    if (!num)
        num = 1;
    if (!item1)
        item1 = "";
    if (!item2)
        item2 = "";
    var index = this.indexOf(val);
    if (index > -1) {
        if (item1 == "" && item2 == "") {
            this.splice(index, num);
        } else if (item1 != "" && item2 == "") {
            this.splice(index, num, item1);
        } else {
            this.splice(index, num, item1, item2);
        }
    }
};

Array.prototype.del = function (val) {//删除指定的元素，且返回被删除的元素，支持数组对象

    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
        return val;
    }

}

Array.prototype.delete = function (index) {//根据索引删除数组元素，支持数组对象

    if (index >= 0) {
        this.splice(index, 1);
    }

}

Array.prototype.delComm = function (val) { //删除数组里相同的元素
    for (var i = 0; i < this.length; i++) {
        if (this[i] === val) {
            this.splice(i, 1);
            i--;
        }
    }
};


String.prototype.getDate = function getDate() {
    var strDate = this;
    var date = eval('new Date(' + strDate.replace(/\d+(?=-[^-]+$)/,
        function (a) { return parseInt(a, 10) - 1; }).match(/\d+/g) + ')');
    return date;
};




//获取URL参数
$.extend({ getUrlVars: function () {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
},
    getUrlVar: function (name) {
        return $.getUrlVars()[name];
    }
}); 

//获取所有选中数据的ID
function getSelectedIds(arr,keyname){
	var ids = [];
	for(var i=0;i<arr.length;i++){
		ids.push(arr[i][keyname]);
	}
	return ids;
}

function getSelectedId(arr,keyname){
	var id;
	if(arr.length ==1){
		id = arr[0][keyname];
	}
	return id;
}