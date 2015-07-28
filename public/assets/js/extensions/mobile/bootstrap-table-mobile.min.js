/*
* bootstrap-table - v1.8.1 - 2015-05-29
* https://github.com/wenzhixin/bootstrap-table
* Copyright (c) 2015 zhixin wen
* Licensed MIT License
*/
!function(a){"use strict";var b=function(a){(a.options.height||a.options.showFooter)&&setTimeout(a.resetView(),1)},c=function(a,c,h){a.options.minHeight?d(c,a.options.minWidth)&&d(h,a.options.minHeight)?f(a):e(c,a.options.minWidth)&&e(h,a.options.minHeight)&&g(a):d(c,a.options.minWidth)?f(a):e(c,a.options.minWidth)&&g(a),b(a)},d=function(a,b){return b>=a},e=function(a,b){return a>b},f=function(a){h(a,!1)},g=function(a){h(a,!0)},h=function(a,b){a.options.cardView=b,a.toggleView()};a.extend(a.fn.bootstrapTable.defaults,{mobileResponsive:!1,minWidth:562,minHeight:void 0,checkOnInit:!0,toggled:!1});var i=a.fn.bootstrapTable.Constructor,j=i.prototype.init;i.prototype.init=function(){if(j.apply(this,Array.prototype.slice.apply(arguments)),this.options.mobileResponsive&&this.options.minWidth){var b=this;a(window).resize(function(){c(b,a(this).width(),a(this).height())}),this.options.checkOnInit&&c(this,a(window).width(),a(window).height())}}}(jQuery);