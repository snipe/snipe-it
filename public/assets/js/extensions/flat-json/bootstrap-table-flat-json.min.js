/*
* bootstrap-table - v1.8.1 - 2015-05-29
* https://github.com/wenzhixin/bootstrap-table
* Copyright (c) 2015 zhixin wen
* Licensed MIT License
*/
!function(a){"use strict";a.extend(a.fn.bootstrapTable.defaults,{flat:!1});var b=a.fn.bootstrapTable.Constructor,c=b.prototype.initData;b.prototype.initData=function(a,b){this.options.flat&&(a=void 0===a?this.options.data:a,a=d.flatHelper(a)),c.apply(this,[a,b])};var d={flat:function(b){function c(b,e){if(Object(b)!==b)d[e]=b;else if(a.isArray(b))for(var f=0,g=b.length;g>f;f++)c(b[f],e?e+"."+f:""+f),0==g&&(d[e]=[]);else{var h=!0;for(var i in b)h=!1,c(b[i],e?e+"."+i:i);h&&(d[e]={})}}var d={};return c(b,""),d},flatHelper:function(b){var c=[],e=[];return a.isArray(b)||(e.push(b),b=e),a.each(b,function(a,b){c.push(d.flat(b))}),c}}}(jQuery);