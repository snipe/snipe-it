!function(t){var e={};function n(r){if(e[r])return e[r].exports;var i=e[r]={i:r,l:!1,exports:{}};return t[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:r})},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=0)}({"+sje":function(t,e,n){var r=n("VU/8")(n("eOaq"),n("lafA"),!1,function(t){n("4UNm")},"data-v-3bdd24a5",null);t.exports=r.exports},0:function(t,e,n){n("GDnL"),n("Bqz+"),n("1CH1"),n("f5J3"),n("yd7E"),n("m5pD"),n("JfWP"),n("Pq8s"),n("WM06"),n("t80F"),n("2WJo"),n("F7gb"),n("jbHB"),n("a5IG"),n("1dC+"),n("0hTo"),n("vvpX"),n("4Jtp"),t.exports=n("kxAE")},"0DKT":function(t,e){t.exports={render:function(){var t=this.$createElement;return(this._self._c||t)("select",{staticStyle:{width:"100%"}},[this._t("default")],2)},staticRenderFns:[]}},"0hTo":function(t,e){},1:function(t,e){},"1CH1":function(t,e){},"1dC+":function(t,e){},"20cu":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["clientsUrl","tokensUrl"],data:function(){return{tokens:[]}},ready:function(){this.prepareComponent()},mounted:function(){this.prepareComponent()},methods:{prepareComponent:function(){this.getTokens()},getTokens:function(){var t=this;this.$http.get(this.tokensUrl).then(function(e){t.tokens=e.data})},revoke:function(t){var e=this;this.$http.delete(this.tokensUrl+"/"+t.id).then(function(t){e.getTokens()})}}}},"2WJo":function(t,e){},"3IRH":function(t,e){t.exports=function(t){return t.webpackPolyfill||(t.deprecate=function(){},t.paths=[],t.children||(t.children=[]),Object.defineProperty(t,"loaded",{enumerable:!0,get:function(){return t.l}}),Object.defineProperty(t,"id",{enumerable:!0,get:function(){return t.i}}),t.webpackPolyfill=1),t}},"4Jtp":function(t,e){},"4UNm":function(t,e,n){var r=n("HB0T");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("5d321c9c",r,!0,{})},"5F58":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),n("FHXl"),e.default={data:function(){return{files:[],displayImportModal:!1,activeFile:null,alert:{type:null,message:null,visible:!1},importErrors:null,progress:{currentClass:"progress-bar-warning",currentPercent:"0",statusText:"",visible:!1},customFields:[]}},mounted:function(){window.eventHub.$on("importErrors",this.updateImportErrors),this.fetchFiles(),this.fetchCustomFields();var t=this;$("#fileupload").fileupload({dataType:"json",done:function(e,n){t.progress.currentClass="progress-bar-success",t.progress.statusText="Success!",t.files=n.result.files.concat(t.files),console.log(n.result.header_row)},add:function(e,n){n.headers={"X-Requested-With":"XMLHttpRequest","X-CSRF-TOKEN":Laravel.csrfToken},n.process().done(function(){n.submit()}),t.progress.visible=!0},progress:function(e,n){var r=parseInt((n.loaded,n.total,10));t.progress.currentPercent=r,t.progress.statusText=r+"% Complete"},fail:function(e,n){t.progress.currentClass="progress-bar-danger",t.progress.statusText=n.jqXHR.responseJSON.messages}})},methods:{fetchFiles:function(){var t=this;this.$http.get(route("api.imports.index")).then(function(e){var n=e.data;return t.files=n},function(e){t.alert.type="danger",t.alert.visible=!0,t.alert.message="Something went wrong fetching files..."})},fetchCustomFields:function(){var t=this;this.$http.get(route("api.customfields.index")).then(function(e){var n=e.data;(n=n.rows).forEach(function(e){t.customFields.push({id:e.db_column_name,text:e.name})})})},deleteFile:function(t,e){var n=this;this.$http.delete(route("api.imports.destroy",t.id)).then(function(t){n.files.splice(e,1),n.alert.type=t.body.status,n.alert.visible=!0,n.alert.message=t.body.messages},function(t){n.alert.type="error",n.alert.visible=!0,n.alert.message=t.body.messages})},toggleEvent:function(t){window.eventHub.$emit("showDetails",t)},updateAlert:function(t){this.alert=t},updateImportErrors:function(t){this.importErrors=t}},computed:{progressWidth:function(){return"width: "+10*this.progress.currentPercent+"%"}},components:{alert:n("b7rt"),errors:n("yDVJ"),importFile:n("sJcK")}}},"5dd0":function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".action-link[data-v-533de2a9]{cursor:pointer}.m-b-none[data-v-533de2a9]{margin-bottom:0}",""])},"5m3O":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};e.default={props:["clientsUrl"],data:function(){return{clients:[],createForm:{errors:[],name:"",redirect:""},editForm:{errors:[],name:"",redirect:""}}},ready:function(){this.prepareComponent()},mounted:function(){this.prepareComponent()},methods:{prepareComponent:function(){this.getClients(),$("#modal-create-client").on("shown.bs.modal",function(){$("#create-client-name").focus()}),$("#modal-edit-client").on("shown.bs.modal",function(){$("#edit-client-name").focus()})},getClients:function(){var t=this;this.$http.get(this.clientsUrl).then(function(e){t.clients=e.data})},showCreateClientForm:function(){$("#modal-create-client").modal("show")},store:function(){this.persistClient("post",this.clientsUrl,this.createForm,"#modal-create-client")},edit:function(t){this.editForm.id=t.id,this.editForm.name=t.name,this.editForm.redirect=t.redirect,$("#modal-edit-client").modal("show")},update:function(){this.persistClient("put",this.clientsUrl+"/"+this.editForm.id,this.editForm,"#modal-edit-client")},persistClient:function(t,e,n,i){var o=this;console.log("persisting"),n.errors=[],console.log("method: "+t),this.$http[t](e,n).then(function(t){o.getClients(),n.name="",n.redirect="",n.errors=[],$(i).modal("hide")}).catch(function(t){"object"===r(t.data)?n.errors=_.flatten(_.toArray(t.data)):n.errors=["Something went wrong. Please try again."]})},destroy:function(t){var e=this;this.$http.delete(this.clientsUrl+"/"+t.id).then(function(t){e.getClients()})}}}},"7t+N":function(t,e,n){var r;!function(e,n){"use strict";"object"==typeof t&&"object"==typeof t.exports?t.exports=e.document?n(e,!0):function(t){if(!t.document)throw new Error("jQuery requires a window with a document");return n(t)}:n(e)}("undefined"!=typeof window?window:this,function(n,i){"use strict";var o=[],s=n.document,a=Object.getPrototypeOf,l=o.slice,u=o.concat,c=o.push,f=o.indexOf,p={},d=p.toString,h=p.hasOwnProperty,v=h.toString,g=v.call(Object),m={},y=function(t){return"function"==typeof t&&"number"!=typeof t.nodeType},_=function(t){return null!=t&&t===t.window},b={type:!0,src:!0,noModule:!0};function w(t,e,n){var r,i=(e=e||s).createElement("script");if(i.text=t,n)for(r in b)n[r]&&(i[r]=n[r]);e.head.appendChild(i).parentNode.removeChild(i)}function x(t){return null==t?t+"":"object"==typeof t||"function"==typeof t?p[d.call(t)]||"object":typeof t}var C=function(t,e){return new C.fn.init(t,e)},$=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;function T(t){var e=!!t&&"length"in t&&t.length,n=x(t);return!y(t)&&!_(t)&&("array"===n||0===e||"number"==typeof e&&e>0&&e-1 in t)}C.fn=C.prototype={jquery:"3.3.1",constructor:C,length:0,toArray:function(){return l.call(this)},get:function(t){return null==t?l.call(this):t<0?this[t+this.length]:this[t]},pushStack:function(t){var e=C.merge(this.constructor(),t);return e.prevObject=this,e},each:function(t){return C.each(this,t)},map:function(t){return this.pushStack(C.map(this,function(e,n){return t.call(e,n,e)}))},slice:function(){return this.pushStack(l.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},eq:function(t){var e=this.length,n=+t+(t<0?e:0);return this.pushStack(n>=0&&n<e?[this[n]]:[])},end:function(){return this.prevObject||this.constructor()},push:c,sort:o.sort,splice:o.splice},C.extend=C.fn.extend=function(){var t,e,n,r,i,o,s=arguments[0]||{},a=1,l=arguments.length,u=!1;for("boolean"==typeof s&&(u=s,s=arguments[a]||{},a++),"object"==typeof s||y(s)||(s={}),a===l&&(s=this,a--);a<l;a++)if(null!=(t=arguments[a]))for(e in t)n=s[e],s!==(r=t[e])&&(u&&r&&(C.isPlainObject(r)||(i=Array.isArray(r)))?(i?(i=!1,o=n&&Array.isArray(n)?n:[]):o=n&&C.isPlainObject(n)?n:{},s[e]=C.extend(u,o,r)):void 0!==r&&(s[e]=r));return s},C.extend({expando:"jQuery"+("3.3.1"+Math.random()).replace(/\D/g,""),isReady:!0,error:function(t){throw new Error(t)},noop:function(){},isPlainObject:function(t){var e,n;return!(!t||"[object Object]"!==d.call(t))&&(!(e=a(t))||"function"==typeof(n=h.call(e,"constructor")&&e.constructor)&&v.call(n)===g)},isEmptyObject:function(t){var e;for(e in t)return!1;return!0},globalEval:function(t){w(t)},each:function(t,e){var n,r=0;if(T(t))for(n=t.length;r<n&&!1!==e.call(t[r],r,t[r]);r++);else for(r in t)if(!1===e.call(t[r],r,t[r]))break;return t},trim:function(t){return null==t?"":(t+"").replace($,"")},makeArray:function(t,e){var n=e||[];return null!=t&&(T(Object(t))?C.merge(n,"string"==typeof t?[t]:t):c.call(n,t)),n},inArray:function(t,e,n){return null==e?-1:f.call(e,t,n)},merge:function(t,e){for(var n=+e.length,r=0,i=t.length;r<n;r++)t[i++]=e[r];return t.length=i,t},grep:function(t,e,n){for(var r=[],i=0,o=t.length,s=!n;i<o;i++)!e(t[i],i)!==s&&r.push(t[i]);return r},map:function(t,e,n){var r,i,o=0,s=[];if(T(t))for(r=t.length;o<r;o++)null!=(i=e(t[o],o,n))&&s.push(i);else for(o in t)null!=(i=e(t[o],o,n))&&s.push(i);return u.apply([],s)},guid:1,support:m}),"function"==typeof Symbol&&(C.fn[Symbol.iterator]=o[Symbol.iterator]),C.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),function(t,e){p["[object "+e+"]"]=e.toLowerCase()});var A=function(t){var e,n,r,i,o,s,a,l,u,c,f,p,d,h,v,g,m,y,_,b="sizzle"+1*new Date,w=t.document,x=0,C=0,$=st(),T=st(),A=st(),k=function(t,e){return t===e&&(f=!0),0},E={}.hasOwnProperty,S=[],O=S.pop,D=S.push,j=S.push,N=S.slice,I=function(t,e){for(var n=0,r=t.length;n<r;n++)if(t[n]===e)return n;return-1},P="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",R="[\\x20\\t\\r\\n\\f]",L="(?:\\\\.|[\\w-]|[^\0-\\xa0])+",F="\\["+R+"*("+L+")(?:"+R+"*([*^$|!~]?=)"+R+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+L+"))|)"+R+"*\\]",U=":("+L+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+F+")*)|.*)\\)|)",M=new RegExp(R+"+","g"),q=new RegExp("^"+R+"+|((?:^|[^\\\\])(?:\\\\.)*)"+R+"+$","g"),H=new RegExp("^"+R+"*,"+R+"*"),B=new RegExp("^"+R+"*([>+~]|"+R+")"+R+"*"),z=new RegExp("="+R+"*([^\\]'\"]*?)"+R+"*\\]","g"),W=new RegExp(U),V=new RegExp("^"+L+"$"),G={ID:new RegExp("^#("+L+")"),CLASS:new RegExp("^\\.("+L+")"),TAG:new RegExp("^("+L+"|[*])"),ATTR:new RegExp("^"+F),PSEUDO:new RegExp("^"+U),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+R+"*(even|odd|(([+-]|)(\\d*)n|)"+R+"*(?:([+-]|)"+R+"*(\\d+)|))"+R+"*\\)|)","i"),bool:new RegExp("^(?:"+P+")$","i"),needsContext:new RegExp("^"+R+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+R+"*((?:-\\d)?\\d*)"+R+"*\\)|)(?=[^-]|$)","i")},X=/^(?:input|select|textarea|button)$/i,K=/^h\d$/i,Z=/^[^{]+\{\s*\[native \w/,J=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,Q=/[+~]/,Y=new RegExp("\\\\([\\da-f]{1,6}"+R+"?|("+R+")|.)","ig"),tt=function(t,e,n){var r="0x"+e-65536;return r!=r||n?e:r<0?String.fromCharCode(r+65536):String.fromCharCode(r>>10|55296,1023&r|56320)},et=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,nt=function(t,e){return e?"\0"===t?"�":t.slice(0,-1)+"\\"+t.charCodeAt(t.length-1).toString(16)+" ":"\\"+t},rt=function(){p()},it=yt(function(t){return!0===t.disabled&&("form"in t||"label"in t)},{dir:"parentNode",next:"legend"});try{j.apply(S=N.call(w.childNodes),w.childNodes),S[w.childNodes.length].nodeType}catch(t){j={apply:S.length?function(t,e){D.apply(t,N.call(e))}:function(t,e){for(var n=t.length,r=0;t[n++]=e[r++];);t.length=n-1}}}function ot(t,e,r,i){var o,a,u,c,f,h,m,y=e&&e.ownerDocument,x=e?e.nodeType:9;if(r=r||[],"string"!=typeof t||!t||1!==x&&9!==x&&11!==x)return r;if(!i&&((e?e.ownerDocument||e:w)!==d&&p(e),e=e||d,v)){if(11!==x&&(f=J.exec(t)))if(o=f[1]){if(9===x){if(!(u=e.getElementById(o)))return r;if(u.id===o)return r.push(u),r}else if(y&&(u=y.getElementById(o))&&_(e,u)&&u.id===o)return r.push(u),r}else{if(f[2])return j.apply(r,e.getElementsByTagName(t)),r;if((o=f[3])&&n.getElementsByClassName&&e.getElementsByClassName)return j.apply(r,e.getElementsByClassName(o)),r}if(n.qsa&&!A[t+" "]&&(!g||!g.test(t))){if(1!==x)y=e,m=t;else if("object"!==e.nodeName.toLowerCase()){for((c=e.getAttribute("id"))?c=c.replace(et,nt):e.setAttribute("id",c=b),a=(h=s(t)).length;a--;)h[a]="#"+c+" "+mt(h[a]);m=h.join(","),y=Q.test(t)&&vt(e.parentNode)||e}if(m)try{return j.apply(r,y.querySelectorAll(m)),r}catch(t){}finally{c===b&&e.removeAttribute("id")}}}return l(t.replace(q,"$1"),e,r,i)}function st(){var t=[];return function e(n,i){return t.push(n+" ")>r.cacheLength&&delete e[t.shift()],e[n+" "]=i}}function at(t){return t[b]=!0,t}function lt(t){var e=d.createElement("fieldset");try{return!!t(e)}catch(t){return!1}finally{e.parentNode&&e.parentNode.removeChild(e),e=null}}function ut(t,e){for(var n=t.split("|"),i=n.length;i--;)r.attrHandle[n[i]]=e}function ct(t,e){var n=e&&t,r=n&&1===t.nodeType&&1===e.nodeType&&t.sourceIndex-e.sourceIndex;if(r)return r;if(n)for(;n=n.nextSibling;)if(n===e)return-1;return t?1:-1}function ft(t){return function(e){return"input"===e.nodeName.toLowerCase()&&e.type===t}}function pt(t){return function(e){var n=e.nodeName.toLowerCase();return("input"===n||"button"===n)&&e.type===t}}function dt(t){return function(e){return"form"in e?e.parentNode&&!1===e.disabled?"label"in e?"label"in e.parentNode?e.parentNode.disabled===t:e.disabled===t:e.isDisabled===t||e.isDisabled!==!t&&it(e)===t:e.disabled===t:"label"in e&&e.disabled===t}}function ht(t){return at(function(e){return e=+e,at(function(n,r){for(var i,o=t([],n.length,e),s=o.length;s--;)n[i=o[s]]&&(n[i]=!(r[i]=n[i]))})})}function vt(t){return t&&void 0!==t.getElementsByTagName&&t}for(e in n=ot.support={},o=ot.isXML=function(t){var e=t&&(t.ownerDocument||t).documentElement;return!!e&&"HTML"!==e.nodeName},p=ot.setDocument=function(t){var e,i,s=t?t.ownerDocument||t:w;return s!==d&&9===s.nodeType&&s.documentElement?(h=(d=s).documentElement,v=!o(d),w!==d&&(i=d.defaultView)&&i.top!==i&&(i.addEventListener?i.addEventListener("unload",rt,!1):i.attachEvent&&i.attachEvent("onunload",rt)),n.attributes=lt(function(t){return t.className="i",!t.getAttribute("className")}),n.getElementsByTagName=lt(function(t){return t.appendChild(d.createComment("")),!t.getElementsByTagName("*").length}),n.getElementsByClassName=Z.test(d.getElementsByClassName),n.getById=lt(function(t){return h.appendChild(t).id=b,!d.getElementsByName||!d.getElementsByName(b).length}),n.getById?(r.filter.ID=function(t){var e=t.replace(Y,tt);return function(t){return t.getAttribute("id")===e}},r.find.ID=function(t,e){if(void 0!==e.getElementById&&v){var n=e.getElementById(t);return n?[n]:[]}}):(r.filter.ID=function(t){var e=t.replace(Y,tt);return function(t){var n=void 0!==t.getAttributeNode&&t.getAttributeNode("id");return n&&n.value===e}},r.find.ID=function(t,e){if(void 0!==e.getElementById&&v){var n,r,i,o=e.getElementById(t);if(o){if((n=o.getAttributeNode("id"))&&n.value===t)return[o];for(i=e.getElementsByName(t),r=0;o=i[r++];)if((n=o.getAttributeNode("id"))&&n.value===t)return[o]}return[]}}),r.find.TAG=n.getElementsByTagName?function(t,e){return void 0!==e.getElementsByTagName?e.getElementsByTagName(t):n.qsa?e.querySelectorAll(t):void 0}:function(t,e){var n,r=[],i=0,o=e.getElementsByTagName(t);if("*"===t){for(;n=o[i++];)1===n.nodeType&&r.push(n);return r}return o},r.find.CLASS=n.getElementsByClassName&&function(t,e){if(void 0!==e.getElementsByClassName&&v)return e.getElementsByClassName(t)},m=[],g=[],(n.qsa=Z.test(d.querySelectorAll))&&(lt(function(t){h.appendChild(t).innerHTML="<a id='"+b+"'></a><select id='"+b+"-\r\\' msallowcapture=''><option selected=''></option></select>",t.querySelectorAll("[msallowcapture^='']").length&&g.push("[*^$]="+R+"*(?:''|\"\")"),t.querySelectorAll("[selected]").length||g.push("\\["+R+"*(?:value|"+P+")"),t.querySelectorAll("[id~="+b+"-]").length||g.push("~="),t.querySelectorAll(":checked").length||g.push(":checked"),t.querySelectorAll("a#"+b+"+*").length||g.push(".#.+[+~]")}),lt(function(t){t.innerHTML="<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";var e=d.createElement("input");e.setAttribute("type","hidden"),t.appendChild(e).setAttribute("name","D"),t.querySelectorAll("[name=d]").length&&g.push("name"+R+"*[*^$|!~]?="),2!==t.querySelectorAll(":enabled").length&&g.push(":enabled",":disabled"),h.appendChild(t).disabled=!0,2!==t.querySelectorAll(":disabled").length&&g.push(":enabled",":disabled"),t.querySelectorAll("*,:x"),g.push(",.*:")})),(n.matchesSelector=Z.test(y=h.matches||h.webkitMatchesSelector||h.mozMatchesSelector||h.oMatchesSelector||h.msMatchesSelector))&&lt(function(t){n.disconnectedMatch=y.call(t,"*"),y.call(t,"[s!='']:x"),m.push("!=",U)}),g=g.length&&new RegExp(g.join("|")),m=m.length&&new RegExp(m.join("|")),e=Z.test(h.compareDocumentPosition),_=e||Z.test(h.contains)?function(t,e){var n=9===t.nodeType?t.documentElement:t,r=e&&e.parentNode;return t===r||!(!r||1!==r.nodeType||!(n.contains?n.contains(r):t.compareDocumentPosition&&16&t.compareDocumentPosition(r)))}:function(t,e){if(e)for(;e=e.parentNode;)if(e===t)return!0;return!1},k=e?function(t,e){if(t===e)return f=!0,0;var r=!t.compareDocumentPosition-!e.compareDocumentPosition;return r||(1&(r=(t.ownerDocument||t)===(e.ownerDocument||e)?t.compareDocumentPosition(e):1)||!n.sortDetached&&e.compareDocumentPosition(t)===r?t===d||t.ownerDocument===w&&_(w,t)?-1:e===d||e.ownerDocument===w&&_(w,e)?1:c?I(c,t)-I(c,e):0:4&r?-1:1)}:function(t,e){if(t===e)return f=!0,0;var n,r=0,i=t.parentNode,o=e.parentNode,s=[t],a=[e];if(!i||!o)return t===d?-1:e===d?1:i?-1:o?1:c?I(c,t)-I(c,e):0;if(i===o)return ct(t,e);for(n=t;n=n.parentNode;)s.unshift(n);for(n=e;n=n.parentNode;)a.unshift(n);for(;s[r]===a[r];)r++;return r?ct(s[r],a[r]):s[r]===w?-1:a[r]===w?1:0},d):d},ot.matches=function(t,e){return ot(t,null,null,e)},ot.matchesSelector=function(t,e){if((t.ownerDocument||t)!==d&&p(t),e=e.replace(z,"='$1']"),n.matchesSelector&&v&&!A[e+" "]&&(!m||!m.test(e))&&(!g||!g.test(e)))try{var r=y.call(t,e);if(r||n.disconnectedMatch||t.document&&11!==t.document.nodeType)return r}catch(t){}return ot(e,d,null,[t]).length>0},ot.contains=function(t,e){return(t.ownerDocument||t)!==d&&p(t),_(t,e)},ot.attr=function(t,e){(t.ownerDocument||t)!==d&&p(t);var i=r.attrHandle[e.toLowerCase()],o=i&&E.call(r.attrHandle,e.toLowerCase())?i(t,e,!v):void 0;return void 0!==o?o:n.attributes||!v?t.getAttribute(e):(o=t.getAttributeNode(e))&&o.specified?o.value:null},ot.escape=function(t){return(t+"").replace(et,nt)},ot.error=function(t){throw new Error("Syntax error, unrecognized expression: "+t)},ot.uniqueSort=function(t){var e,r=[],i=0,o=0;if(f=!n.detectDuplicates,c=!n.sortStable&&t.slice(0),t.sort(k),f){for(;e=t[o++];)e===t[o]&&(i=r.push(o));for(;i--;)t.splice(r[i],1)}return c=null,t},i=ot.getText=function(t){var e,n="",r=0,o=t.nodeType;if(o){if(1===o||9===o||11===o){if("string"==typeof t.textContent)return t.textContent;for(t=t.firstChild;t;t=t.nextSibling)n+=i(t)}else if(3===o||4===o)return t.nodeValue}else for(;e=t[r++];)n+=i(e);return n},(r=ot.selectors={cacheLength:50,createPseudo:at,match:G,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(t){return t[1]=t[1].replace(Y,tt),t[3]=(t[3]||t[4]||t[5]||"").replace(Y,tt),"~="===t[2]&&(t[3]=" "+t[3]+" "),t.slice(0,4)},CHILD:function(t){return t[1]=t[1].toLowerCase(),"nth"===t[1].slice(0,3)?(t[3]||ot.error(t[0]),t[4]=+(t[4]?t[5]+(t[6]||1):2*("even"===t[3]||"odd"===t[3])),t[5]=+(t[7]+t[8]||"odd"===t[3])):t[3]&&ot.error(t[0]),t},PSEUDO:function(t){var e,n=!t[6]&&t[2];return G.CHILD.test(t[0])?null:(t[3]?t[2]=t[4]||t[5]||"":n&&W.test(n)&&(e=s(n,!0))&&(e=n.indexOf(")",n.length-e)-n.length)&&(t[0]=t[0].slice(0,e),t[2]=n.slice(0,e)),t.slice(0,3))}},filter:{TAG:function(t){var e=t.replace(Y,tt).toLowerCase();return"*"===t?function(){return!0}:function(t){return t.nodeName&&t.nodeName.toLowerCase()===e}},CLASS:function(t){var e=$[t+" "];return e||(e=new RegExp("(^|"+R+")"+t+"("+R+"|$)"))&&$(t,function(t){return e.test("string"==typeof t.className&&t.className||void 0!==t.getAttribute&&t.getAttribute("class")||"")})},ATTR:function(t,e,n){return function(r){var i=ot.attr(r,t);return null==i?"!="===e:!e||(i+="","="===e?i===n:"!="===e?i!==n:"^="===e?n&&0===i.indexOf(n):"*="===e?n&&i.indexOf(n)>-1:"$="===e?n&&i.slice(-n.length)===n:"~="===e?(" "+i.replace(M," ")+" ").indexOf(n)>-1:"|="===e&&(i===n||i.slice(0,n.length+1)===n+"-"))}},CHILD:function(t,e,n,r,i){var o="nth"!==t.slice(0,3),s="last"!==t.slice(-4),a="of-type"===e;return 1===r&&0===i?function(t){return!!t.parentNode}:function(e,n,l){var u,c,f,p,d,h,v=o!==s?"nextSibling":"previousSibling",g=e.parentNode,m=a&&e.nodeName.toLowerCase(),y=!l&&!a,_=!1;if(g){if(o){for(;v;){for(p=e;p=p[v];)if(a?p.nodeName.toLowerCase()===m:1===p.nodeType)return!1;h=v="only"===t&&!h&&"nextSibling"}return!0}if(h=[s?g.firstChild:g.lastChild],s&&y){for(_=(d=(u=(c=(f=(p=g)[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[t]||[])[0]===x&&u[1])&&u[2],p=d&&g.childNodes[d];p=++d&&p&&p[v]||(_=d=0)||h.pop();)if(1===p.nodeType&&++_&&p===e){c[t]=[x,d,_];break}}else if(y&&(_=d=(u=(c=(f=(p=e)[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[t]||[])[0]===x&&u[1]),!1===_)for(;(p=++d&&p&&p[v]||(_=d=0)||h.pop())&&((a?p.nodeName.toLowerCase()!==m:1!==p.nodeType)||!++_||(y&&((c=(f=p[b]||(p[b]={}))[p.uniqueID]||(f[p.uniqueID]={}))[t]=[x,_]),p!==e)););return(_-=i)===r||_%r==0&&_/r>=0}}},PSEUDO:function(t,e){var n,i=r.pseudos[t]||r.setFilters[t.toLowerCase()]||ot.error("unsupported pseudo: "+t);return i[b]?i(e):i.length>1?(n=[t,t,"",e],r.setFilters.hasOwnProperty(t.toLowerCase())?at(function(t,n){for(var r,o=i(t,e),s=o.length;s--;)t[r=I(t,o[s])]=!(n[r]=o[s])}):function(t){return i(t,0,n)}):i}},pseudos:{not:at(function(t){var e=[],n=[],r=a(t.replace(q,"$1"));return r[b]?at(function(t,e,n,i){for(var o,s=r(t,null,i,[]),a=t.length;a--;)(o=s[a])&&(t[a]=!(e[a]=o))}):function(t,i,o){return e[0]=t,r(e,null,o,n),e[0]=null,!n.pop()}}),has:at(function(t){return function(e){return ot(t,e).length>0}}),contains:at(function(t){return t=t.replace(Y,tt),function(e){return(e.textContent||e.innerText||i(e)).indexOf(t)>-1}}),lang:at(function(t){return V.test(t||"")||ot.error("unsupported lang: "+t),t=t.replace(Y,tt).toLowerCase(),function(e){var n;do{if(n=v?e.lang:e.getAttribute("xml:lang")||e.getAttribute("lang"))return(n=n.toLowerCase())===t||0===n.indexOf(t+"-")}while((e=e.parentNode)&&1===e.nodeType);return!1}}),target:function(e){var n=t.location&&t.location.hash;return n&&n.slice(1)===e.id},root:function(t){return t===h},focus:function(t){return t===d.activeElement&&(!d.hasFocus||d.hasFocus())&&!!(t.type||t.href||~t.tabIndex)},enabled:dt(!1),disabled:dt(!0),checked:function(t){var e=t.nodeName.toLowerCase();return"input"===e&&!!t.checked||"option"===e&&!!t.selected},selected:function(t){return t.parentNode&&t.parentNode.selectedIndex,!0===t.selected},empty:function(t){for(t=t.firstChild;t;t=t.nextSibling)if(t.nodeType<6)return!1;return!0},parent:function(t){return!r.pseudos.empty(t)},header:function(t){return K.test(t.nodeName)},input:function(t){return X.test(t.nodeName)},button:function(t){var e=t.nodeName.toLowerCase();return"input"===e&&"button"===t.type||"button"===e},text:function(t){var e;return"input"===t.nodeName.toLowerCase()&&"text"===t.type&&(null==(e=t.getAttribute("type"))||"text"===e.toLowerCase())},first:ht(function(){return[0]}),last:ht(function(t,e){return[e-1]}),eq:ht(function(t,e,n){return[n<0?n+e:n]}),even:ht(function(t,e){for(var n=0;n<e;n+=2)t.push(n);return t}),odd:ht(function(t,e){for(var n=1;n<e;n+=2)t.push(n);return t}),lt:ht(function(t,e,n){for(var r=n<0?n+e:n;--r>=0;)t.push(r);return t}),gt:ht(function(t,e,n){for(var r=n<0?n+e:n;++r<e;)t.push(r);return t})}}).pseudos.nth=r.pseudos.eq,{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})r.pseudos[e]=ft(e);for(e in{submit:!0,reset:!0})r.pseudos[e]=pt(e);function gt(){}function mt(t){for(var e=0,n=t.length,r="";e<n;e++)r+=t[e].value;return r}function yt(t,e,n){var r=e.dir,i=e.next,o=i||r,s=n&&"parentNode"===o,a=C++;return e.first?function(e,n,i){for(;e=e[r];)if(1===e.nodeType||s)return t(e,n,i);return!1}:function(e,n,l){var u,c,f,p=[x,a];if(l){for(;e=e[r];)if((1===e.nodeType||s)&&t(e,n,l))return!0}else for(;e=e[r];)if(1===e.nodeType||s)if(c=(f=e[b]||(e[b]={}))[e.uniqueID]||(f[e.uniqueID]={}),i&&i===e.nodeName.toLowerCase())e=e[r]||e;else{if((u=c[o])&&u[0]===x&&u[1]===a)return p[2]=u[2];if(c[o]=p,p[2]=t(e,n,l))return!0}return!1}}function _t(t){return t.length>1?function(e,n,r){for(var i=t.length;i--;)if(!t[i](e,n,r))return!1;return!0}:t[0]}function bt(t,e,n,r,i){for(var o,s=[],a=0,l=t.length,u=null!=e;a<l;a++)(o=t[a])&&(n&&!n(o,r,i)||(s.push(o),u&&e.push(a)));return s}function wt(t,e,n,r,i,o){return r&&!r[b]&&(r=wt(r)),i&&!i[b]&&(i=wt(i,o)),at(function(o,s,a,l){var u,c,f,p=[],d=[],h=s.length,v=o||function(t,e,n){for(var r=0,i=e.length;r<i;r++)ot(t,e[r],n);return n}(e||"*",a.nodeType?[a]:a,[]),g=!t||!o&&e?v:bt(v,p,t,a,l),m=n?i||(o?t:h||r)?[]:s:g;if(n&&n(g,m,a,l),r)for(u=bt(m,d),r(u,[],a,l),c=u.length;c--;)(f=u[c])&&(m[d[c]]=!(g[d[c]]=f));if(o){if(i||t){if(i){for(u=[],c=m.length;c--;)(f=m[c])&&u.push(g[c]=f);i(null,m=[],u,l)}for(c=m.length;c--;)(f=m[c])&&(u=i?I(o,f):p[c])>-1&&(o[u]=!(s[u]=f))}}else m=bt(m===s?m.splice(h,m.length):m),i?i(null,s,m,l):j.apply(s,m)})}function xt(t){for(var e,n,i,o=t.length,s=r.relative[t[0].type],a=s||r.relative[" "],l=s?1:0,c=yt(function(t){return t===e},a,!0),f=yt(function(t){return I(e,t)>-1},a,!0),p=[function(t,n,r){var i=!s&&(r||n!==u)||((e=n).nodeType?c(t,n,r):f(t,n,r));return e=null,i}];l<o;l++)if(n=r.relative[t[l].type])p=[yt(_t(p),n)];else{if((n=r.filter[t[l].type].apply(null,t[l].matches))[b]){for(i=++l;i<o&&!r.relative[t[i].type];i++);return wt(l>1&&_t(p),l>1&&mt(t.slice(0,l-1).concat({value:" "===t[l-2].type?"*":""})).replace(q,"$1"),n,l<i&&xt(t.slice(l,i)),i<o&&xt(t=t.slice(i)),i<o&&mt(t))}p.push(n)}return _t(p)}return gt.prototype=r.filters=r.pseudos,r.setFilters=new gt,s=ot.tokenize=function(t,e){var n,i,o,s,a,l,u,c=T[t+" "];if(c)return e?0:c.slice(0);for(a=t,l=[],u=r.preFilter;a;){for(s in n&&!(i=H.exec(a))||(i&&(a=a.slice(i[0].length)||a),l.push(o=[])),n=!1,(i=B.exec(a))&&(n=i.shift(),o.push({value:n,type:i[0].replace(q," ")}),a=a.slice(n.length)),r.filter)!(i=G[s].exec(a))||u[s]&&!(i=u[s](i))||(n=i.shift(),o.push({value:n,type:s,matches:i}),a=a.slice(n.length));if(!n)break}return e?a.length:a?ot.error(t):T(t,l).slice(0)},a=ot.compile=function(t,e){var n,i=[],o=[],a=A[t+" "];if(!a){for(e||(e=s(t)),n=e.length;n--;)(a=xt(e[n]))[b]?i.push(a):o.push(a);(a=A(t,function(t,e){var n=e.length>0,i=t.length>0,o=function(o,s,a,l,c){var f,h,g,m=0,y="0",_=o&&[],b=[],w=u,C=o||i&&r.find.TAG("*",c),$=x+=null==w?1:Math.random()||.1,T=C.length;for(c&&(u=s===d||s||c);y!==T&&null!=(f=C[y]);y++){if(i&&f){for(h=0,s||f.ownerDocument===d||(p(f),a=!v);g=t[h++];)if(g(f,s||d,a)){l.push(f);break}c&&(x=$)}n&&((f=!g&&f)&&m--,o&&_.push(f))}if(m+=y,n&&y!==m){for(h=0;g=e[h++];)g(_,b,s,a);if(o){if(m>0)for(;y--;)_[y]||b[y]||(b[y]=O.call(l));b=bt(b)}j.apply(l,b),c&&!o&&b.length>0&&m+e.length>1&&ot.uniqueSort(l)}return c&&(x=$,u=w),_};return n?at(o):o}(o,i))).selector=t}return a},l=ot.select=function(t,e,n,i){var o,l,u,c,f,p="function"==typeof t&&t,d=!i&&s(t=p.selector||t);if(n=n||[],1===d.length){if((l=d[0]=d[0].slice(0)).length>2&&"ID"===(u=l[0]).type&&9===e.nodeType&&v&&r.relative[l[1].type]){if(!(e=(r.find.ID(u.matches[0].replace(Y,tt),e)||[])[0]))return n;p&&(e=e.parentNode),t=t.slice(l.shift().value.length)}for(o=G.needsContext.test(t)?0:l.length;o--&&(u=l[o],!r.relative[c=u.type]);)if((f=r.find[c])&&(i=f(u.matches[0].replace(Y,tt),Q.test(l[0].type)&&vt(e.parentNode)||e))){if(l.splice(o,1),!(t=i.length&&mt(l)))return j.apply(n,i),n;break}}return(p||a(t,d))(i,e,!v,n,!e||Q.test(t)&&vt(e.parentNode)||e),n},n.sortStable=b.split("").sort(k).join("")===b,n.detectDuplicates=!!f,p(),n.sortDetached=lt(function(t){return 1&t.compareDocumentPosition(d.createElement("fieldset"))}),lt(function(t){return t.innerHTML="<a href='#'></a>","#"===t.firstChild.getAttribute("href")})||ut("type|href|height|width",function(t,e,n){if(!n)return t.getAttribute(e,"type"===e.toLowerCase()?1:2)}),n.attributes&&lt(function(t){return t.innerHTML="<input/>",t.firstChild.setAttribute("value",""),""===t.firstChild.getAttribute("value")})||ut("value",function(t,e,n){if(!n&&"input"===t.nodeName.toLowerCase())return t.defaultValue}),lt(function(t){return null==t.getAttribute("disabled")})||ut(P,function(t,e,n){var r;if(!n)return!0===t[e]?e.toLowerCase():(r=t.getAttributeNode(e))&&r.specified?r.value:null}),ot}(n);C.find=A,C.expr=A.selectors,C.expr[":"]=C.expr.pseudos,C.uniqueSort=C.unique=A.uniqueSort,C.text=A.getText,C.isXMLDoc=A.isXML,C.contains=A.contains,C.escapeSelector=A.escape;var k=function(t,e,n){for(var r=[],i=void 0!==n;(t=t[e])&&9!==t.nodeType;)if(1===t.nodeType){if(i&&C(t).is(n))break;r.push(t)}return r},E=function(t,e){for(var n=[];t;t=t.nextSibling)1===t.nodeType&&t!==e&&n.push(t);return n},S=C.expr.match.needsContext;function O(t,e){return t.nodeName&&t.nodeName.toLowerCase()===e.toLowerCase()}var D=/^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;function j(t,e,n){return y(e)?C.grep(t,function(t,r){return!!e.call(t,r,t)!==n}):e.nodeType?C.grep(t,function(t){return t===e!==n}):"string"!=typeof e?C.grep(t,function(t){return f.call(e,t)>-1!==n}):C.filter(e,t,n)}C.filter=function(t,e,n){var r=e[0];return n&&(t=":not("+t+")"),1===e.length&&1===r.nodeType?C.find.matchesSelector(r,t)?[r]:[]:C.find.matches(t,C.grep(e,function(t){return 1===t.nodeType}))},C.fn.extend({find:function(t){var e,n,r=this.length,i=this;if("string"!=typeof t)return this.pushStack(C(t).filter(function(){for(e=0;e<r;e++)if(C.contains(i[e],this))return!0}));for(n=this.pushStack([]),e=0;e<r;e++)C.find(t,i[e],n);return r>1?C.uniqueSort(n):n},filter:function(t){return this.pushStack(j(this,t||[],!1))},not:function(t){return this.pushStack(j(this,t||[],!0))},is:function(t){return!!j(this,"string"==typeof t&&S.test(t)?C(t):t||[],!1).length}});var N,I=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;(C.fn.init=function(t,e,n){var r,i;if(!t)return this;if(n=n||N,"string"==typeof t){if(!(r="<"===t[0]&&">"===t[t.length-1]&&t.length>=3?[null,t,null]:I.exec(t))||!r[1]&&e)return!e||e.jquery?(e||n).find(t):this.constructor(e).find(t);if(r[1]){if(e=e instanceof C?e[0]:e,C.merge(this,C.parseHTML(r[1],e&&e.nodeType?e.ownerDocument||e:s,!0)),D.test(r[1])&&C.isPlainObject(e))for(r in e)y(this[r])?this[r](e[r]):this.attr(r,e[r]);return this}return(i=s.getElementById(r[2]))&&(this[0]=i,this.length=1),this}return t.nodeType?(this[0]=t,this.length=1,this):y(t)?void 0!==n.ready?n.ready(t):t(C):C.makeArray(t,this)}).prototype=C.fn,N=C(s);var P=/^(?:parents|prev(?:Until|All))/,R={children:!0,contents:!0,next:!0,prev:!0};function L(t,e){for(;(t=t[e])&&1!==t.nodeType;);return t}C.fn.extend({has:function(t){var e=C(t,this),n=e.length;return this.filter(function(){for(var t=0;t<n;t++)if(C.contains(this,e[t]))return!0})},closest:function(t,e){var n,r=0,i=this.length,o=[],s="string"!=typeof t&&C(t);if(!S.test(t))for(;r<i;r++)for(n=this[r];n&&n!==e;n=n.parentNode)if(n.nodeType<11&&(s?s.index(n)>-1:1===n.nodeType&&C.find.matchesSelector(n,t))){o.push(n);break}return this.pushStack(o.length>1?C.uniqueSort(o):o)},index:function(t){return t?"string"==typeof t?f.call(C(t),this[0]):f.call(this,t.jquery?t[0]:t):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(t,e){return this.pushStack(C.uniqueSort(C.merge(this.get(),C(t,e))))},addBack:function(t){return this.add(null==t?this.prevObject:this.prevObject.filter(t))}}),C.each({parent:function(t){var e=t.parentNode;return e&&11!==e.nodeType?e:null},parents:function(t){return k(t,"parentNode")},parentsUntil:function(t,e,n){return k(t,"parentNode",n)},next:function(t){return L(t,"nextSibling")},prev:function(t){return L(t,"previousSibling")},nextAll:function(t){return k(t,"nextSibling")},prevAll:function(t){return k(t,"previousSibling")},nextUntil:function(t,e,n){return k(t,"nextSibling",n)},prevUntil:function(t,e,n){return k(t,"previousSibling",n)},siblings:function(t){return E((t.parentNode||{}).firstChild,t)},children:function(t){return E(t.firstChild)},contents:function(t){return O(t,"iframe")?t.contentDocument:(O(t,"template")&&(t=t.content||t),C.merge([],t.childNodes))}},function(t,e){C.fn[t]=function(n,r){var i=C.map(this,e,n);return"Until"!==t.slice(-5)&&(r=n),r&&"string"==typeof r&&(i=C.filter(r,i)),this.length>1&&(R[t]||C.uniqueSort(i),P.test(t)&&i.reverse()),this.pushStack(i)}});var F=/[^\x20\t\r\n\f]+/g;function U(t){return t}function M(t){throw t}function q(t,e,n,r){var i;try{t&&y(i=t.promise)?i.call(t).done(e).fail(n):t&&y(i=t.then)?i.call(t,e,n):e.apply(void 0,[t].slice(r))}catch(t){n.apply(void 0,[t])}}C.Callbacks=function(t){t="string"==typeof t?function(t){var e={};return C.each(t.match(F)||[],function(t,n){e[n]=!0}),e}(t):C.extend({},t);var e,n,r,i,o=[],s=[],a=-1,l=function(){for(i=i||t.once,r=e=!0;s.length;a=-1)for(n=s.shift();++a<o.length;)!1===o[a].apply(n[0],n[1])&&t.stopOnFalse&&(a=o.length,n=!1);t.memory||(n=!1),e=!1,i&&(o=n?[]:"")},u={add:function(){return o&&(n&&!e&&(a=o.length-1,s.push(n)),function e(n){C.each(n,function(n,r){y(r)?t.unique&&u.has(r)||o.push(r):r&&r.length&&"string"!==x(r)&&e(r)})}(arguments),n&&!e&&l()),this},remove:function(){return C.each(arguments,function(t,e){for(var n;(n=C.inArray(e,o,n))>-1;)o.splice(n,1),n<=a&&a--}),this},has:function(t){return t?C.inArray(t,o)>-1:o.length>0},empty:function(){return o&&(o=[]),this},disable:function(){return i=s=[],o=n="",this},disabled:function(){return!o},lock:function(){return i=s=[],n||e||(o=n=""),this},locked:function(){return!!i},fireWith:function(t,n){return i||(n=[t,(n=n||[]).slice?n.slice():n],s.push(n),e||l()),this},fire:function(){return u.fireWith(this,arguments),this},fired:function(){return!!r}};return u},C.extend({Deferred:function(t){var e=[["notify","progress",C.Callbacks("memory"),C.Callbacks("memory"),2],["resolve","done",C.Callbacks("once memory"),C.Callbacks("once memory"),0,"resolved"],["reject","fail",C.Callbacks("once memory"),C.Callbacks("once memory"),1,"rejected"]],r="pending",i={state:function(){return r},always:function(){return o.done(arguments).fail(arguments),this},catch:function(t){return i.then(null,t)},pipe:function(){var t=arguments;return C.Deferred(function(n){C.each(e,function(e,r){var i=y(t[r[4]])&&t[r[4]];o[r[1]](function(){var t=i&&i.apply(this,arguments);t&&y(t.promise)?t.promise().progress(n.notify).done(n.resolve).fail(n.reject):n[r[0]+"With"](this,i?[t]:arguments)})}),t=null}).promise()},then:function(t,r,i){var o=0;function s(t,e,r,i){return function(){var a=this,l=arguments,u=function(){var n,u;if(!(t<o)){if((n=r.apply(a,l))===e.promise())throw new TypeError("Thenable self-resolution");u=n&&("object"==typeof n||"function"==typeof n)&&n.then,y(u)?i?u.call(n,s(o,e,U,i),s(o,e,M,i)):(o++,u.call(n,s(o,e,U,i),s(o,e,M,i),s(o,e,U,e.notifyWith))):(r!==U&&(a=void 0,l=[n]),(i||e.resolveWith)(a,l))}},c=i?u:function(){try{u()}catch(n){C.Deferred.exceptionHook&&C.Deferred.exceptionHook(n,c.stackTrace),t+1>=o&&(r!==M&&(a=void 0,l=[n]),e.rejectWith(a,l))}};t?c():(C.Deferred.getStackHook&&(c.stackTrace=C.Deferred.getStackHook()),n.setTimeout(c))}}return C.Deferred(function(n){e[0][3].add(s(0,n,y(i)?i:U,n.notifyWith)),e[1][3].add(s(0,n,y(t)?t:U)),e[2][3].add(s(0,n,y(r)?r:M))}).promise()},promise:function(t){return null!=t?C.extend(t,i):i}},o={};return C.each(e,function(t,n){var s=n[2],a=n[5];i[n[1]]=s.add,a&&s.add(function(){r=a},e[3-t][2].disable,e[3-t][3].disable,e[0][2].lock,e[0][3].lock),s.add(n[3].fire),o[n[0]]=function(){return o[n[0]+"With"](this===o?void 0:this,arguments),this},o[n[0]+"With"]=s.fireWith}),i.promise(o),t&&t.call(o,o),o},when:function(t){var e=arguments.length,n=e,r=Array(n),i=l.call(arguments),o=C.Deferred(),s=function(t){return function(n){r[t]=this,i[t]=arguments.length>1?l.call(arguments):n,--e||o.resolveWith(r,i)}};if(e<=1&&(q(t,o.done(s(n)).resolve,o.reject,!e),"pending"===o.state()||y(i[n]&&i[n].then)))return o.then();for(;n--;)q(i[n],s(n),o.reject);return o.promise()}});var H=/^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;C.Deferred.exceptionHook=function(t,e){n.console&&n.console.warn&&t&&H.test(t.name)&&n.console.warn("jQuery.Deferred exception: "+t.message,t.stack,e)},C.readyException=function(t){n.setTimeout(function(){throw t})};var B=C.Deferred();function z(){s.removeEventListener("DOMContentLoaded",z),n.removeEventListener("load",z),C.ready()}C.fn.ready=function(t){return B.then(t).catch(function(t){C.readyException(t)}),this},C.extend({isReady:!1,readyWait:1,ready:function(t){(!0===t?--C.readyWait:C.isReady)||(C.isReady=!0,!0!==t&&--C.readyWait>0||B.resolveWith(s,[C]))}}),C.ready.then=B.then,"complete"===s.readyState||"loading"!==s.readyState&&!s.documentElement.doScroll?n.setTimeout(C.ready):(s.addEventListener("DOMContentLoaded",z),n.addEventListener("load",z));var W=function(t,e,n,r,i,o,s){var a=0,l=t.length,u=null==n;if("object"===x(n))for(a in i=!0,n)W(t,e,a,n[a],!0,o,s);else if(void 0!==r&&(i=!0,y(r)||(s=!0),u&&(s?(e.call(t,r),e=null):(u=e,e=function(t,e,n){return u.call(C(t),n)})),e))for(;a<l;a++)e(t[a],n,s?r:r.call(t[a],a,e(t[a],n)));return i?t:u?e.call(t):l?e(t[0],n):o},V=/^-ms-/,G=/-([a-z])/g;function X(t,e){return e.toUpperCase()}function K(t){return t.replace(V,"ms-").replace(G,X)}var Z=function(t){return 1===t.nodeType||9===t.nodeType||!+t.nodeType};function J(){this.expando=C.expando+J.uid++}J.uid=1,J.prototype={cache:function(t){var e=t[this.expando];return e||(e={},Z(t)&&(t.nodeType?t[this.expando]=e:Object.defineProperty(t,this.expando,{value:e,configurable:!0}))),e},set:function(t,e,n){var r,i=this.cache(t);if("string"==typeof e)i[K(e)]=n;else for(r in e)i[K(r)]=e[r];return i},get:function(t,e){return void 0===e?this.cache(t):t[this.expando]&&t[this.expando][K(e)]},access:function(t,e,n){return void 0===e||e&&"string"==typeof e&&void 0===n?this.get(t,e):(this.set(t,e,n),void 0!==n?n:e)},remove:function(t,e){var n,r=t[this.expando];if(void 0!==r){if(void 0!==e){n=(e=Array.isArray(e)?e.map(K):(e=K(e))in r?[e]:e.match(F)||[]).length;for(;n--;)delete r[e[n]]}(void 0===e||C.isEmptyObject(r))&&(t.nodeType?t[this.expando]=void 0:delete t[this.expando])}},hasData:function(t){var e=t[this.expando];return void 0!==e&&!C.isEmptyObject(e)}};var Q=new J,Y=new J,tt=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,et=/[A-Z]/g;function nt(t,e,n){var r;if(void 0===n&&1===t.nodeType)if(r="data-"+e.replace(et,"-$&").toLowerCase(),"string"==typeof(n=t.getAttribute(r))){try{n=function(t){return"true"===t||"false"!==t&&("null"===t?null:t===+t+""?+t:tt.test(t)?JSON.parse(t):t)}(n)}catch(t){}Y.set(t,e,n)}else n=void 0;return n}C.extend({hasData:function(t){return Y.hasData(t)||Q.hasData(t)},data:function(t,e,n){return Y.access(t,e,n)},removeData:function(t,e){Y.remove(t,e)},_data:function(t,e,n){return Q.access(t,e,n)},_removeData:function(t,e){Q.remove(t,e)}}),C.fn.extend({data:function(t,e){var n,r,i,o=this[0],s=o&&o.attributes;if(void 0===t){if(this.length&&(i=Y.get(o),1===o.nodeType&&!Q.get(o,"hasDataAttrs"))){for(n=s.length;n--;)s[n]&&0===(r=s[n].name).indexOf("data-")&&(r=K(r.slice(5)),nt(o,r,i[r]));Q.set(o,"hasDataAttrs",!0)}return i}return"object"==typeof t?this.each(function(){Y.set(this,t)}):W(this,function(e){var n;if(o&&void 0===e)return void 0!==(n=Y.get(o,t))?n:void 0!==(n=nt(o,t))?n:void 0;this.each(function(){Y.set(this,t,e)})},null,e,arguments.length>1,null,!0)},removeData:function(t){return this.each(function(){Y.remove(this,t)})}}),C.extend({queue:function(t,e,n){var r;if(t)return e=(e||"fx")+"queue",r=Q.get(t,e),n&&(!r||Array.isArray(n)?r=Q.access(t,e,C.makeArray(n)):r.push(n)),r||[]},dequeue:function(t,e){e=e||"fx";var n=C.queue(t,e),r=n.length,i=n.shift(),o=C._queueHooks(t,e);"inprogress"===i&&(i=n.shift(),r--),i&&("fx"===e&&n.unshift("inprogress"),delete o.stop,i.call(t,function(){C.dequeue(t,e)},o)),!r&&o&&o.empty.fire()},_queueHooks:function(t,e){var n=e+"queueHooks";return Q.get(t,n)||Q.access(t,n,{empty:C.Callbacks("once memory").add(function(){Q.remove(t,[e+"queue",n])})})}}),C.fn.extend({queue:function(t,e){var n=2;return"string"!=typeof t&&(e=t,t="fx",n--),arguments.length<n?C.queue(this[0],t):void 0===e?this:this.each(function(){var n=C.queue(this,t,e);C._queueHooks(this,t),"fx"===t&&"inprogress"!==n[0]&&C.dequeue(this,t)})},dequeue:function(t){return this.each(function(){C.dequeue(this,t)})},clearQueue:function(t){return this.queue(t||"fx",[])},promise:function(t,e){var n,r=1,i=C.Deferred(),o=this,s=this.length,a=function(){--r||i.resolveWith(o,[o])};for("string"!=typeof t&&(e=t,t=void 0),t=t||"fx";s--;)(n=Q.get(o[s],t+"queueHooks"))&&n.empty&&(r++,n.empty.add(a));return a(),i.promise(e)}});var rt=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,it=new RegExp("^(?:([+-])=|)("+rt+")([a-z%]*)$","i"),ot=["Top","Right","Bottom","Left"],st=function(t,e){return"none"===(t=e||t).style.display||""===t.style.display&&C.contains(t.ownerDocument,t)&&"none"===C.css(t,"display")},at=function(t,e,n,r){var i,o,s={};for(o in e)s[o]=t.style[o],t.style[o]=e[o];for(o in i=n.apply(t,r||[]),e)t.style[o]=s[o];return i};function lt(t,e,n,r){var i,o,s=20,a=r?function(){return r.cur()}:function(){return C.css(t,e,"")},l=a(),u=n&&n[3]||(C.cssNumber[e]?"":"px"),c=(C.cssNumber[e]||"px"!==u&&+l)&&it.exec(C.css(t,e));if(c&&c[3]!==u){for(l/=2,u=u||c[3],c=+l||1;s--;)C.style(t,e,c+u),(1-o)*(1-(o=a()/l||.5))<=0&&(s=0),c/=o;c*=2,C.style(t,e,c+u),n=n||[]}return n&&(c=+c||+l||0,i=n[1]?c+(n[1]+1)*n[2]:+n[2],r&&(r.unit=u,r.start=c,r.end=i)),i}var ut={};function ct(t){var e,n=t.ownerDocument,r=t.nodeName,i=ut[r];return i||(e=n.body.appendChild(n.createElement(r)),i=C.css(e,"display"),e.parentNode.removeChild(e),"none"===i&&(i="block"),ut[r]=i,i)}function ft(t,e){for(var n,r,i=[],o=0,s=t.length;o<s;o++)(r=t[o]).style&&(n=r.style.display,e?("none"===n&&(i[o]=Q.get(r,"display")||null,i[o]||(r.style.display="")),""===r.style.display&&st(r)&&(i[o]=ct(r))):"none"!==n&&(i[o]="none",Q.set(r,"display",n)));for(o=0;o<s;o++)null!=i[o]&&(t[o].style.display=i[o]);return t}C.fn.extend({show:function(){return ft(this,!0)},hide:function(){return ft(this)},toggle:function(t){return"boolean"==typeof t?t?this.show():this.hide():this.each(function(){st(this)?C(this).show():C(this).hide()})}});var pt=/^(?:checkbox|radio)$/i,dt=/<([a-z][^\/\0>\x20\t\r\n\f]+)/i,ht=/^$|^module$|\/(?:java|ecma)script/i,vt={option:[1,"<select multiple='multiple'>","</select>"],thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};function gt(t,e){var n;return n=void 0!==t.getElementsByTagName?t.getElementsByTagName(e||"*"):void 0!==t.querySelectorAll?t.querySelectorAll(e||"*"):[],void 0===e||e&&O(t,e)?C.merge([t],n):n}function mt(t,e){for(var n=0,r=t.length;n<r;n++)Q.set(t[n],"globalEval",!e||Q.get(e[n],"globalEval"))}vt.optgroup=vt.option,vt.tbody=vt.tfoot=vt.colgroup=vt.caption=vt.thead,vt.th=vt.td;var yt,_t,bt=/<|&#?\w+;/;function wt(t,e,n,r,i){for(var o,s,a,l,u,c,f=e.createDocumentFragment(),p=[],d=0,h=t.length;d<h;d++)if((o=t[d])||0===o)if("object"===x(o))C.merge(p,o.nodeType?[o]:o);else if(bt.test(o)){for(s=s||f.appendChild(e.createElement("div")),a=(dt.exec(o)||["",""])[1].toLowerCase(),l=vt[a]||vt._default,s.innerHTML=l[1]+C.htmlPrefilter(o)+l[2],c=l[0];c--;)s=s.lastChild;C.merge(p,s.childNodes),(s=f.firstChild).textContent=""}else p.push(e.createTextNode(o));for(f.textContent="",d=0;o=p[d++];)if(r&&C.inArray(o,r)>-1)i&&i.push(o);else if(u=C.contains(o.ownerDocument,o),s=gt(f.appendChild(o),"script"),u&&mt(s),n)for(c=0;o=s[c++];)ht.test(o.type||"")&&n.push(o);return f}yt=s.createDocumentFragment().appendChild(s.createElement("div")),(_t=s.createElement("input")).setAttribute("type","radio"),_t.setAttribute("checked","checked"),_t.setAttribute("name","t"),yt.appendChild(_t),m.checkClone=yt.cloneNode(!0).cloneNode(!0).lastChild.checked,yt.innerHTML="<textarea>x</textarea>",m.noCloneChecked=!!yt.cloneNode(!0).lastChild.defaultValue;var xt=s.documentElement,Ct=/^key/,$t=/^(?:mouse|pointer|contextmenu|drag|drop)|click/,Tt=/^([^.]*)(?:\.(.+)|)/;function At(){return!0}function kt(){return!1}function Et(){try{return s.activeElement}catch(t){}}function St(t,e,n,r,i,o){var s,a;if("object"==typeof e){for(a in"string"!=typeof n&&(r=r||n,n=void 0),e)St(t,a,n,r,e[a],o);return t}if(null==r&&null==i?(i=n,r=n=void 0):null==i&&("string"==typeof n?(i=r,r=void 0):(i=r,r=n,n=void 0)),!1===i)i=kt;else if(!i)return t;return 1===o&&(s=i,(i=function(t){return C().off(t),s.apply(this,arguments)}).guid=s.guid||(s.guid=C.guid++)),t.each(function(){C.event.add(this,e,i,r,n)})}C.event={global:{},add:function(t,e,n,r,i){var o,s,a,l,u,c,f,p,d,h,v,g=Q.get(t);if(g)for(n.handler&&(n=(o=n).handler,i=o.selector),i&&C.find.matchesSelector(xt,i),n.guid||(n.guid=C.guid++),(l=g.events)||(l=g.events={}),(s=g.handle)||(s=g.handle=function(e){return void 0!==C&&C.event.triggered!==e.type?C.event.dispatch.apply(t,arguments):void 0}),u=(e=(e||"").match(F)||[""]).length;u--;)d=v=(a=Tt.exec(e[u])||[])[1],h=(a[2]||"").split(".").sort(),d&&(f=C.event.special[d]||{},d=(i?f.delegateType:f.bindType)||d,f=C.event.special[d]||{},c=C.extend({type:d,origType:v,data:r,handler:n,guid:n.guid,selector:i,needsContext:i&&C.expr.match.needsContext.test(i),namespace:h.join(".")},o),(p=l[d])||((p=l[d]=[]).delegateCount=0,f.setup&&!1!==f.setup.call(t,r,h,s)||t.addEventListener&&t.addEventListener(d,s)),f.add&&(f.add.call(t,c),c.handler.guid||(c.handler.guid=n.guid)),i?p.splice(p.delegateCount++,0,c):p.push(c),C.event.global[d]=!0)},remove:function(t,e,n,r,i){var o,s,a,l,u,c,f,p,d,h,v,g=Q.hasData(t)&&Q.get(t);if(g&&(l=g.events)){for(u=(e=(e||"").match(F)||[""]).length;u--;)if(d=v=(a=Tt.exec(e[u])||[])[1],h=(a[2]||"").split(".").sort(),d){for(f=C.event.special[d]||{},p=l[d=(r?f.delegateType:f.bindType)||d]||[],a=a[2]&&new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"),s=o=p.length;o--;)c=p[o],!i&&v!==c.origType||n&&n.guid!==c.guid||a&&!a.test(c.namespace)||r&&r!==c.selector&&("**"!==r||!c.selector)||(p.splice(o,1),c.selector&&p.delegateCount--,f.remove&&f.remove.call(t,c));s&&!p.length&&(f.teardown&&!1!==f.teardown.call(t,h,g.handle)||C.removeEvent(t,d,g.handle),delete l[d])}else for(d in l)C.event.remove(t,d+e[u],n,r,!0);C.isEmptyObject(l)&&Q.remove(t,"handle events")}},dispatch:function(t){var e,n,r,i,o,s,a=C.event.fix(t),l=new Array(arguments.length),u=(Q.get(this,"events")||{})[a.type]||[],c=C.event.special[a.type]||{};for(l[0]=a,e=1;e<arguments.length;e++)l[e]=arguments[e];if(a.delegateTarget=this,!c.preDispatch||!1!==c.preDispatch.call(this,a)){for(s=C.event.handlers.call(this,a,u),e=0;(i=s[e++])&&!a.isPropagationStopped();)for(a.currentTarget=i.elem,n=0;(o=i.handlers[n++])&&!a.isImmediatePropagationStopped();)a.rnamespace&&!a.rnamespace.test(o.namespace)||(a.handleObj=o,a.data=o.data,void 0!==(r=((C.event.special[o.origType]||{}).handle||o.handler).apply(i.elem,l))&&!1===(a.result=r)&&(a.preventDefault(),a.stopPropagation()));return c.postDispatch&&c.postDispatch.call(this,a),a.result}},handlers:function(t,e){var n,r,i,o,s,a=[],l=e.delegateCount,u=t.target;if(l&&u.nodeType&&!("click"===t.type&&t.button>=1))for(;u!==this;u=u.parentNode||this)if(1===u.nodeType&&("click"!==t.type||!0!==u.disabled)){for(o=[],s={},n=0;n<l;n++)void 0===s[i=(r=e[n]).selector+" "]&&(s[i]=r.needsContext?C(i,this).index(u)>-1:C.find(i,this,null,[u]).length),s[i]&&o.push(r);o.length&&a.push({elem:u,handlers:o})}return u=this,l<e.length&&a.push({elem:u,handlers:e.slice(l)}),a},addProp:function(t,e){Object.defineProperty(C.Event.prototype,t,{enumerable:!0,configurable:!0,get:y(e)?function(){if(this.originalEvent)return e(this.originalEvent)}:function(){if(this.originalEvent)return this.originalEvent[t]},set:function(e){Object.defineProperty(this,t,{enumerable:!0,configurable:!0,writable:!0,value:e})}})},fix:function(t){return t[C.expando]?t:new C.Event(t)},special:{load:{noBubble:!0},focus:{trigger:function(){if(this!==Et()&&this.focus)return this.focus(),!1},delegateType:"focusin"},blur:{trigger:function(){if(this===Et()&&this.blur)return this.blur(),!1},delegateType:"focusout"},click:{trigger:function(){if("checkbox"===this.type&&this.click&&O(this,"input"))return this.click(),!1},_default:function(t){return O(t.target,"a")}},beforeunload:{postDispatch:function(t){void 0!==t.result&&t.originalEvent&&(t.originalEvent.returnValue=t.result)}}}},C.removeEvent=function(t,e,n){t.removeEventListener&&t.removeEventListener(e,n)},C.Event=function(t,e){if(!(this instanceof C.Event))return new C.Event(t,e);t&&t.type?(this.originalEvent=t,this.type=t.type,this.isDefaultPrevented=t.defaultPrevented||void 0===t.defaultPrevented&&!1===t.returnValue?At:kt,this.target=t.target&&3===t.target.nodeType?t.target.parentNode:t.target,this.currentTarget=t.currentTarget,this.relatedTarget=t.relatedTarget):this.type=t,e&&C.extend(this,e),this.timeStamp=t&&t.timeStamp||Date.now(),this[C.expando]=!0},C.Event.prototype={constructor:C.Event,isDefaultPrevented:kt,isPropagationStopped:kt,isImmediatePropagationStopped:kt,isSimulated:!1,preventDefault:function(){var t=this.originalEvent;this.isDefaultPrevented=At,t&&!this.isSimulated&&t.preventDefault()},stopPropagation:function(){var t=this.originalEvent;this.isPropagationStopped=At,t&&!this.isSimulated&&t.stopPropagation()},stopImmediatePropagation:function(){var t=this.originalEvent;this.isImmediatePropagationStopped=At,t&&!this.isSimulated&&t.stopImmediatePropagation(),this.stopPropagation()}},C.each({altKey:!0,bubbles:!0,cancelable:!0,changedTouches:!0,ctrlKey:!0,detail:!0,eventPhase:!0,metaKey:!0,pageX:!0,pageY:!0,shiftKey:!0,view:!0,char:!0,charCode:!0,key:!0,keyCode:!0,button:!0,buttons:!0,clientX:!0,clientY:!0,offsetX:!0,offsetY:!0,pointerId:!0,pointerType:!0,screenX:!0,screenY:!0,targetTouches:!0,toElement:!0,touches:!0,which:function(t){var e=t.button;return null==t.which&&Ct.test(t.type)?null!=t.charCode?t.charCode:t.keyCode:!t.which&&void 0!==e&&$t.test(t.type)?1&e?1:2&e?3:4&e?2:0:t.which}},C.event.addProp),C.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(t,e){C.event.special[t]={delegateType:e,bindType:e,handle:function(t){var n,r=t.relatedTarget,i=t.handleObj;return r&&(r===this||C.contains(this,r))||(t.type=i.origType,n=i.handler.apply(this,arguments),t.type=e),n}}}),C.fn.extend({on:function(t,e,n,r){return St(this,t,e,n,r)},one:function(t,e,n,r){return St(this,t,e,n,r,1)},off:function(t,e,n){var r,i;if(t&&t.preventDefault&&t.handleObj)return r=t.handleObj,C(t.delegateTarget).off(r.namespace?r.origType+"."+r.namespace:r.origType,r.selector,r.handler),this;if("object"==typeof t){for(i in t)this.off(i,e,t[i]);return this}return!1!==e&&"function"!=typeof e||(n=e,e=void 0),!1===n&&(n=kt),this.each(function(){C.event.remove(this,t,n,e)})}});var Ot=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi,Dt=/<script|<style|<link/i,jt=/checked\s*(?:[^=]|=\s*.checked.)/i,Nt=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;function It(t,e){return O(t,"table")&&O(11!==e.nodeType?e:e.firstChild,"tr")&&C(t).children("tbody")[0]||t}function Pt(t){return t.type=(null!==t.getAttribute("type"))+"/"+t.type,t}function Rt(t){return"true/"===(t.type||"").slice(0,5)?t.type=t.type.slice(5):t.removeAttribute("type"),t}function Lt(t,e){var n,r,i,o,s,a,l,u;if(1===e.nodeType){if(Q.hasData(t)&&(o=Q.access(t),s=Q.set(e,o),u=o.events))for(i in delete s.handle,s.events={},u)for(n=0,r=u[i].length;n<r;n++)C.event.add(e,i,u[i][n]);Y.hasData(t)&&(a=Y.access(t),l=C.extend({},a),Y.set(e,l))}}function Ft(t,e,n,r){e=u.apply([],e);var i,o,s,a,l,c,f=0,p=t.length,d=p-1,h=e[0],v=y(h);if(v||p>1&&"string"==typeof h&&!m.checkClone&&jt.test(h))return t.each(function(i){var o=t.eq(i);v&&(e[0]=h.call(this,i,o.html())),Ft(o,e,n,r)});if(p&&(o=(i=wt(e,t[0].ownerDocument,!1,t,r)).firstChild,1===i.childNodes.length&&(i=o),o||r)){for(a=(s=C.map(gt(i,"script"),Pt)).length;f<p;f++)l=i,f!==d&&(l=C.clone(l,!0,!0),a&&C.merge(s,gt(l,"script"))),n.call(t[f],l,f);if(a)for(c=s[s.length-1].ownerDocument,C.map(s,Rt),f=0;f<a;f++)l=s[f],ht.test(l.type||"")&&!Q.access(l,"globalEval")&&C.contains(c,l)&&(l.src&&"module"!==(l.type||"").toLowerCase()?C._evalUrl&&C._evalUrl(l.src):w(l.textContent.replace(Nt,""),c,l))}return t}function Ut(t,e,n){for(var r,i=e?C.filter(e,t):t,o=0;null!=(r=i[o]);o++)n||1!==r.nodeType||C.cleanData(gt(r)),r.parentNode&&(n&&C.contains(r.ownerDocument,r)&&mt(gt(r,"script")),r.parentNode.removeChild(r));return t}C.extend({htmlPrefilter:function(t){return t.replace(Ot,"<$1></$2>")},clone:function(t,e,n){var r,i,o,s,a,l,u,c=t.cloneNode(!0),f=C.contains(t.ownerDocument,t);if(!(m.noCloneChecked||1!==t.nodeType&&11!==t.nodeType||C.isXMLDoc(t)))for(s=gt(c),r=0,i=(o=gt(t)).length;r<i;r++)a=o[r],l=s[r],void 0,"input"===(u=l.nodeName.toLowerCase())&&pt.test(a.type)?l.checked=a.checked:"input"!==u&&"textarea"!==u||(l.defaultValue=a.defaultValue);if(e)if(n)for(o=o||gt(t),s=s||gt(c),r=0,i=o.length;r<i;r++)Lt(o[r],s[r]);else Lt(t,c);return(s=gt(c,"script")).length>0&&mt(s,!f&&gt(t,"script")),c},cleanData:function(t){for(var e,n,r,i=C.event.special,o=0;void 0!==(n=t[o]);o++)if(Z(n)){if(e=n[Q.expando]){if(e.events)for(r in e.events)i[r]?C.event.remove(n,r):C.removeEvent(n,r,e.handle);n[Q.expando]=void 0}n[Y.expando]&&(n[Y.expando]=void 0)}}}),C.fn.extend({detach:function(t){return Ut(this,t,!0)},remove:function(t){return Ut(this,t)},text:function(t){return W(this,function(t){return void 0===t?C.text(this):this.empty().each(function(){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||(this.textContent=t)})},null,t,arguments.length)},append:function(){return Ft(this,arguments,function(t){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||It(this,t).appendChild(t)})},prepend:function(){return Ft(this,arguments,function(t){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var e=It(this,t);e.insertBefore(t,e.firstChild)}})},before:function(){return Ft(this,arguments,function(t){this.parentNode&&this.parentNode.insertBefore(t,this)})},after:function(){return Ft(this,arguments,function(t){this.parentNode&&this.parentNode.insertBefore(t,this.nextSibling)})},empty:function(){for(var t,e=0;null!=(t=this[e]);e++)1===t.nodeType&&(C.cleanData(gt(t,!1)),t.textContent="");return this},clone:function(t,e){return t=null!=t&&t,e=null==e?t:e,this.map(function(){return C.clone(this,t,e)})},html:function(t){return W(this,function(t){var e=this[0]||{},n=0,r=this.length;if(void 0===t&&1===e.nodeType)return e.innerHTML;if("string"==typeof t&&!Dt.test(t)&&!vt[(dt.exec(t)||["",""])[1].toLowerCase()]){t=C.htmlPrefilter(t);try{for(;n<r;n++)1===(e=this[n]||{}).nodeType&&(C.cleanData(gt(e,!1)),e.innerHTML=t);e=0}catch(t){}}e&&this.empty().append(t)},null,t,arguments.length)},replaceWith:function(){var t=[];return Ft(this,arguments,function(e){var n=this.parentNode;C.inArray(this,t)<0&&(C.cleanData(gt(this)),n&&n.replaceChild(e,this))},t)}}),C.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(t,e){C.fn[t]=function(t){for(var n,r=[],i=C(t),o=i.length-1,s=0;s<=o;s++)n=s===o?this:this.clone(!0),C(i[s])[e](n),c.apply(r,n.get());return this.pushStack(r)}});var Mt=new RegExp("^("+rt+")(?!px)[a-z%]+$","i"),qt=function(t){var e=t.ownerDocument.defaultView;return e&&e.opener||(e=n),e.getComputedStyle(t)},Ht=new RegExp(ot.join("|"),"i");function Bt(t,e,n){var r,i,o,s,a=t.style;return(n=n||qt(t))&&(""!==(s=n.getPropertyValue(e)||n[e])||C.contains(t.ownerDocument,t)||(s=C.style(t,e)),!m.pixelBoxStyles()&&Mt.test(s)&&Ht.test(e)&&(r=a.width,i=a.minWidth,o=a.maxWidth,a.minWidth=a.maxWidth=a.width=s,s=n.width,a.width=r,a.minWidth=i,a.maxWidth=o)),void 0!==s?s+"":s}function zt(t,e){return{get:function(){if(!t())return(this.get=e).apply(this,arguments);delete this.get}}}!function(){function t(){if(c){u.style.cssText="position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0",c.style.cssText="position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%",xt.appendChild(u).appendChild(c);var t=n.getComputedStyle(c);r="1%"!==t.top,l=12===e(t.marginLeft),c.style.right="60%",a=36===e(t.right),i=36===e(t.width),c.style.position="absolute",o=36===c.offsetWidth||"absolute",xt.removeChild(u),c=null}}function e(t){return Math.round(parseFloat(t))}var r,i,o,a,l,u=s.createElement("div"),c=s.createElement("div");c.style&&(c.style.backgroundClip="content-box",c.cloneNode(!0).style.backgroundClip="",m.clearCloneStyle="content-box"===c.style.backgroundClip,C.extend(m,{boxSizingReliable:function(){return t(),i},pixelBoxStyles:function(){return t(),a},pixelPosition:function(){return t(),r},reliableMarginLeft:function(){return t(),l},scrollboxSize:function(){return t(),o}}))}();var Wt=/^(none|table(?!-c[ea]).+)/,Vt=/^--/,Gt={position:"absolute",visibility:"hidden",display:"block"},Xt={letterSpacing:"0",fontWeight:"400"},Kt=["Webkit","Moz","ms"],Zt=s.createElement("div").style;function Jt(t){var e=C.cssProps[t];return e||(e=C.cssProps[t]=function(t){if(t in Zt)return t;for(var e=t[0].toUpperCase()+t.slice(1),n=Kt.length;n--;)if((t=Kt[n]+e)in Zt)return t}(t)||t),e}function Qt(t,e,n){var r=it.exec(e);return r?Math.max(0,r[2]-(n||0))+(r[3]||"px"):e}function Yt(t,e,n,r,i,o){var s="width"===e?1:0,a=0,l=0;if(n===(r?"border":"content"))return 0;for(;s<4;s+=2)"margin"===n&&(l+=C.css(t,n+ot[s],!0,i)),r?("content"===n&&(l-=C.css(t,"padding"+ot[s],!0,i)),"margin"!==n&&(l-=C.css(t,"border"+ot[s]+"Width",!0,i))):(l+=C.css(t,"padding"+ot[s],!0,i),"padding"!==n?l+=C.css(t,"border"+ot[s]+"Width",!0,i):a+=C.css(t,"border"+ot[s]+"Width",!0,i));return!r&&o>=0&&(l+=Math.max(0,Math.ceil(t["offset"+e[0].toUpperCase()+e.slice(1)]-o-l-a-.5))),l}function te(t,e,n){var r=qt(t),i=Bt(t,e,r),o="border-box"===C.css(t,"boxSizing",!1,r),s=o;if(Mt.test(i)){if(!n)return i;i="auto"}return s=s&&(m.boxSizingReliable()||i===t.style[e]),("auto"===i||!parseFloat(i)&&"inline"===C.css(t,"display",!1,r))&&(i=t["offset"+e[0].toUpperCase()+e.slice(1)],s=!0),(i=parseFloat(i)||0)+Yt(t,e,n||(o?"border":"content"),s,r,i)+"px"}function ee(t,e,n,r,i){return new ee.prototype.init(t,e,n,r,i)}C.extend({cssHooks:{opacity:{get:function(t,e){if(e){var n=Bt(t,"opacity");return""===n?"1":n}}}},cssNumber:{animationIterationCount:!0,columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{},style:function(t,e,n,r){if(t&&3!==t.nodeType&&8!==t.nodeType&&t.style){var i,o,s,a=K(e),l=Vt.test(e),u=t.style;if(l||(e=Jt(a)),s=C.cssHooks[e]||C.cssHooks[a],void 0===n)return s&&"get"in s&&void 0!==(i=s.get(t,!1,r))?i:u[e];"string"===(o=typeof n)&&(i=it.exec(n))&&i[1]&&(n=lt(t,e,i),o="number"),null!=n&&n==n&&("number"===o&&(n+=i&&i[3]||(C.cssNumber[a]?"":"px")),m.clearCloneStyle||""!==n||0!==e.indexOf("background")||(u[e]="inherit"),s&&"set"in s&&void 0===(n=s.set(t,n,r))||(l?u.setProperty(e,n):u[e]=n))}},css:function(t,e,n,r){var i,o,s,a=K(e);return Vt.test(e)||(e=Jt(a)),(s=C.cssHooks[e]||C.cssHooks[a])&&"get"in s&&(i=s.get(t,!0,n)),void 0===i&&(i=Bt(t,e,r)),"normal"===i&&e in Xt&&(i=Xt[e]),""===n||n?(o=parseFloat(i),!0===n||isFinite(o)?o||0:i):i}}),C.each(["height","width"],function(t,e){C.cssHooks[e]={get:function(t,n,r){if(n)return!Wt.test(C.css(t,"display"))||t.getClientRects().length&&t.getBoundingClientRect().width?te(t,e,r):at(t,Gt,function(){return te(t,e,r)})},set:function(t,n,r){var i,o=qt(t),s="border-box"===C.css(t,"boxSizing",!1,o),a=r&&Yt(t,e,r,s,o);return s&&m.scrollboxSize()===o.position&&(a-=Math.ceil(t["offset"+e[0].toUpperCase()+e.slice(1)]-parseFloat(o[e])-Yt(t,e,"border",!1,o)-.5)),a&&(i=it.exec(n))&&"px"!==(i[3]||"px")&&(t.style[e]=n,n=C.css(t,e)),Qt(0,n,a)}}}),C.cssHooks.marginLeft=zt(m.reliableMarginLeft,function(t,e){if(e)return(parseFloat(Bt(t,"marginLeft"))||t.getBoundingClientRect().left-at(t,{marginLeft:0},function(){return t.getBoundingClientRect().left}))+"px"}),C.each({margin:"",padding:"",border:"Width"},function(t,e){C.cssHooks[t+e]={expand:function(n){for(var r=0,i={},o="string"==typeof n?n.split(" "):[n];r<4;r++)i[t+ot[r]+e]=o[r]||o[r-2]||o[0];return i}},"margin"!==t&&(C.cssHooks[t+e].set=Qt)}),C.fn.extend({css:function(t,e){return W(this,function(t,e,n){var r,i,o={},s=0;if(Array.isArray(e)){for(r=qt(t),i=e.length;s<i;s++)o[e[s]]=C.css(t,e[s],!1,r);return o}return void 0!==n?C.style(t,e,n):C.css(t,e)},t,e,arguments.length>1)}}),C.Tween=ee,ee.prototype={constructor:ee,init:function(t,e,n,r,i,o){this.elem=t,this.prop=n,this.easing=i||C.easing._default,this.options=e,this.start=this.now=this.cur(),this.end=r,this.unit=o||(C.cssNumber[n]?"":"px")},cur:function(){var t=ee.propHooks[this.prop];return t&&t.get?t.get(this):ee.propHooks._default.get(this)},run:function(t){var e,n=ee.propHooks[this.prop];return this.options.duration?this.pos=e=C.easing[this.easing](t,this.options.duration*t,0,1,this.options.duration):this.pos=e=t,this.now=(this.end-this.start)*e+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):ee.propHooks._default.set(this),this}},ee.prototype.init.prototype=ee.prototype,ee.propHooks={_default:{get:function(t){var e;return 1!==t.elem.nodeType||null!=t.elem[t.prop]&&null==t.elem.style[t.prop]?t.elem[t.prop]:(e=C.css(t.elem,t.prop,""))&&"auto"!==e?e:0},set:function(t){C.fx.step[t.prop]?C.fx.step[t.prop](t):1!==t.elem.nodeType||null==t.elem.style[C.cssProps[t.prop]]&&!C.cssHooks[t.prop]?t.elem[t.prop]=t.now:C.style(t.elem,t.prop,t.now+t.unit)}}},ee.propHooks.scrollTop=ee.propHooks.scrollLeft={set:function(t){t.elem.nodeType&&t.elem.parentNode&&(t.elem[t.prop]=t.now)}},C.easing={linear:function(t){return t},swing:function(t){return.5-Math.cos(t*Math.PI)/2},_default:"swing"},C.fx=ee.prototype.init,C.fx.step={};var ne,re,ie=/^(?:toggle|show|hide)$/,oe=/queueHooks$/;function se(){re&&(!1===s.hidden&&n.requestAnimationFrame?n.requestAnimationFrame(se):n.setTimeout(se,C.fx.interval),C.fx.tick())}function ae(){return n.setTimeout(function(){ne=void 0}),ne=Date.now()}function le(t,e){var n,r=0,i={height:t};for(e=e?1:0;r<4;r+=2-e)i["margin"+(n=ot[r])]=i["padding"+n]=t;return e&&(i.opacity=i.width=t),i}function ue(t,e,n){for(var r,i=(ce.tweeners[e]||[]).concat(ce.tweeners["*"]),o=0,s=i.length;o<s;o++)if(r=i[o].call(n,e,t))return r}function ce(t,e,n){var r,i,o=0,s=ce.prefilters.length,a=C.Deferred().always(function(){delete l.elem}),l=function(){if(i)return!1;for(var e=ne||ae(),n=Math.max(0,u.startTime+u.duration-e),r=1-(n/u.duration||0),o=0,s=u.tweens.length;o<s;o++)u.tweens[o].run(r);return a.notifyWith(t,[u,r,n]),r<1&&s?n:(s||a.notifyWith(t,[u,1,0]),a.resolveWith(t,[u]),!1)},u=a.promise({elem:t,props:C.extend({},e),opts:C.extend(!0,{specialEasing:{},easing:C.easing._default},n),originalProperties:e,originalOptions:n,startTime:ne||ae(),duration:n.duration,tweens:[],createTween:function(e,n){var r=C.Tween(t,u.opts,e,n,u.opts.specialEasing[e]||u.opts.easing);return u.tweens.push(r),r},stop:function(e){var n=0,r=e?u.tweens.length:0;if(i)return this;for(i=!0;n<r;n++)u.tweens[n].run(1);return e?(a.notifyWith(t,[u,1,0]),a.resolveWith(t,[u,e])):a.rejectWith(t,[u,e]),this}}),c=u.props;for(!function(t,e){var n,r,i,o,s;for(n in t)if(i=e[r=K(n)],o=t[n],Array.isArray(o)&&(i=o[1],o=t[n]=o[0]),n!==r&&(t[r]=o,delete t[n]),(s=C.cssHooks[r])&&"expand"in s)for(n in o=s.expand(o),delete t[r],o)n in t||(t[n]=o[n],e[n]=i);else e[r]=i}(c,u.opts.specialEasing);o<s;o++)if(r=ce.prefilters[o].call(u,t,c,u.opts))return y(r.stop)&&(C._queueHooks(u.elem,u.opts.queue).stop=r.stop.bind(r)),r;return C.map(c,ue,u),y(u.opts.start)&&u.opts.start.call(t,u),u.progress(u.opts.progress).done(u.opts.done,u.opts.complete).fail(u.opts.fail).always(u.opts.always),C.fx.timer(C.extend(l,{elem:t,anim:u,queue:u.opts.queue})),u}C.Animation=C.extend(ce,{tweeners:{"*":[function(t,e){var n=this.createTween(t,e);return lt(n.elem,t,it.exec(e),n),n}]},tweener:function(t,e){y(t)?(e=t,t=["*"]):t=t.match(F);for(var n,r=0,i=t.length;r<i;r++)n=t[r],ce.tweeners[n]=ce.tweeners[n]||[],ce.tweeners[n].unshift(e)},prefilters:[function(t,e,n){var r,i,o,s,a,l,u,c,f="width"in e||"height"in e,p=this,d={},h=t.style,v=t.nodeType&&st(t),g=Q.get(t,"fxshow");for(r in n.queue||(null==(s=C._queueHooks(t,"fx")).unqueued&&(s.unqueued=0,a=s.empty.fire,s.empty.fire=function(){s.unqueued||a()}),s.unqueued++,p.always(function(){p.always(function(){s.unqueued--,C.queue(t,"fx").length||s.empty.fire()})})),e)if(i=e[r],ie.test(i)){if(delete e[r],o=o||"toggle"===i,i===(v?"hide":"show")){if("show"!==i||!g||void 0===g[r])continue;v=!0}d[r]=g&&g[r]||C.style(t,r)}if((l=!C.isEmptyObject(e))||!C.isEmptyObject(d))for(r in f&&1===t.nodeType&&(n.overflow=[h.overflow,h.overflowX,h.overflowY],null==(u=g&&g.display)&&(u=Q.get(t,"display")),"none"===(c=C.css(t,"display"))&&(u?c=u:(ft([t],!0),u=t.style.display||u,c=C.css(t,"display"),ft([t]))),("inline"===c||"inline-block"===c&&null!=u)&&"none"===C.css(t,"float")&&(l||(p.done(function(){h.display=u}),null==u&&(c=h.display,u="none"===c?"":c)),h.display="inline-block")),n.overflow&&(h.overflow="hidden",p.always(function(){h.overflow=n.overflow[0],h.overflowX=n.overflow[1],h.overflowY=n.overflow[2]})),l=!1,d)l||(g?"hidden"in g&&(v=g.hidden):g=Q.access(t,"fxshow",{display:u}),o&&(g.hidden=!v),v&&ft([t],!0),p.done(function(){for(r in v||ft([t]),Q.remove(t,"fxshow"),d)C.style(t,r,d[r])})),l=ue(v?g[r]:0,r,p),r in g||(g[r]=l.start,v&&(l.end=l.start,l.start=0))}],prefilter:function(t,e){e?ce.prefilters.unshift(t):ce.prefilters.push(t)}}),C.speed=function(t,e,n){var r=t&&"object"==typeof t?C.extend({},t):{complete:n||!n&&e||y(t)&&t,duration:t,easing:n&&e||e&&!y(e)&&e};return C.fx.off?r.duration=0:"number"!=typeof r.duration&&(r.duration in C.fx.speeds?r.duration=C.fx.speeds[r.duration]:r.duration=C.fx.speeds._default),null!=r.queue&&!0!==r.queue||(r.queue="fx"),r.old=r.complete,r.complete=function(){y(r.old)&&r.old.call(this),r.queue&&C.dequeue(this,r.queue)},r},C.fn.extend({fadeTo:function(t,e,n,r){return this.filter(st).css("opacity",0).show().end().animate({opacity:e},t,n,r)},animate:function(t,e,n,r){var i=C.isEmptyObject(t),o=C.speed(e,n,r),s=function(){var e=ce(this,C.extend({},t),o);(i||Q.get(this,"finish"))&&e.stop(!0)};return s.finish=s,i||!1===o.queue?this.each(s):this.queue(o.queue,s)},stop:function(t,e,n){var r=function(t){var e=t.stop;delete t.stop,e(n)};return"string"!=typeof t&&(n=e,e=t,t=void 0),e&&!1!==t&&this.queue(t||"fx",[]),this.each(function(){var e=!0,i=null!=t&&t+"queueHooks",o=C.timers,s=Q.get(this);if(i)s[i]&&s[i].stop&&r(s[i]);else for(i in s)s[i]&&s[i].stop&&oe.test(i)&&r(s[i]);for(i=o.length;i--;)o[i].elem!==this||null!=t&&o[i].queue!==t||(o[i].anim.stop(n),e=!1,o.splice(i,1));!e&&n||C.dequeue(this,t)})},finish:function(t){return!1!==t&&(t=t||"fx"),this.each(function(){var e,n=Q.get(this),r=n[t+"queue"],i=n[t+"queueHooks"],o=C.timers,s=r?r.length:0;for(n.finish=!0,C.queue(this,t,[]),i&&i.stop&&i.stop.call(this,!0),e=o.length;e--;)o[e].elem===this&&o[e].queue===t&&(o[e].anim.stop(!0),o.splice(e,1));for(e=0;e<s;e++)r[e]&&r[e].finish&&r[e].finish.call(this);delete n.finish})}}),C.each(["toggle","show","hide"],function(t,e){var n=C.fn[e];C.fn[e]=function(t,r,i){return null==t||"boolean"==typeof t?n.apply(this,arguments):this.animate(le(e,!0),t,r,i)}}),C.each({slideDown:le("show"),slideUp:le("hide"),slideToggle:le("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(t,e){C.fn[t]=function(t,n,r){return this.animate(e,t,n,r)}}),C.timers=[],C.fx.tick=function(){var t,e=0,n=C.timers;for(ne=Date.now();e<n.length;e++)(t=n[e])()||n[e]!==t||n.splice(e--,1);n.length||C.fx.stop(),ne=void 0},C.fx.timer=function(t){C.timers.push(t),C.fx.start()},C.fx.interval=13,C.fx.start=function(){re||(re=!0,se())},C.fx.stop=function(){re=null},C.fx.speeds={slow:600,fast:200,_default:400},C.fn.delay=function(t,e){return t=C.fx&&C.fx.speeds[t]||t,e=e||"fx",this.queue(e,function(e,r){var i=n.setTimeout(e,t);r.stop=function(){n.clearTimeout(i)}})},function(){var t=s.createElement("input"),e=s.createElement("select").appendChild(s.createElement("option"));t.type="checkbox",m.checkOn=""!==t.value,m.optSelected=e.selected,(t=s.createElement("input")).value="t",t.type="radio",m.radioValue="t"===t.value}();var fe,pe=C.expr.attrHandle;C.fn.extend({attr:function(t,e){return W(this,C.attr,t,e,arguments.length>1)},removeAttr:function(t){return this.each(function(){C.removeAttr(this,t)})}}),C.extend({attr:function(t,e,n){var r,i,o=t.nodeType;if(3!==o&&8!==o&&2!==o)return void 0===t.getAttribute?C.prop(t,e,n):(1===o&&C.isXMLDoc(t)||(i=C.attrHooks[e.toLowerCase()]||(C.expr.match.bool.test(e)?fe:void 0)),void 0!==n?null===n?void C.removeAttr(t,e):i&&"set"in i&&void 0!==(r=i.set(t,n,e))?r:(t.setAttribute(e,n+""),n):i&&"get"in i&&null!==(r=i.get(t,e))?r:null==(r=C.find.attr(t,e))?void 0:r)},attrHooks:{type:{set:function(t,e){if(!m.radioValue&&"radio"===e&&O(t,"input")){var n=t.value;return t.setAttribute("type",e),n&&(t.value=n),e}}}},removeAttr:function(t,e){var n,r=0,i=e&&e.match(F);if(i&&1===t.nodeType)for(;n=i[r++];)t.removeAttribute(n)}}),fe={set:function(t,e,n){return!1===e?C.removeAttr(t,n):t.setAttribute(n,n),n}},C.each(C.expr.match.bool.source.match(/\w+/g),function(t,e){var n=pe[e]||C.find.attr;pe[e]=function(t,e,r){var i,o,s=e.toLowerCase();return r||(o=pe[s],pe[s]=i,i=null!=n(t,e,r)?s:null,pe[s]=o),i}});var de=/^(?:input|select|textarea|button)$/i,he=/^(?:a|area)$/i;function ve(t){return(t.match(F)||[]).join(" ")}function ge(t){return t.getAttribute&&t.getAttribute("class")||""}function me(t){return Array.isArray(t)?t:"string"==typeof t&&t.match(F)||[]}C.fn.extend({prop:function(t,e){return W(this,C.prop,t,e,arguments.length>1)},removeProp:function(t){return this.each(function(){delete this[C.propFix[t]||t]})}}),C.extend({prop:function(t,e,n){var r,i,o=t.nodeType;if(3!==o&&8!==o&&2!==o)return 1===o&&C.isXMLDoc(t)||(e=C.propFix[e]||e,i=C.propHooks[e]),void 0!==n?i&&"set"in i&&void 0!==(r=i.set(t,n,e))?r:t[e]=n:i&&"get"in i&&null!==(r=i.get(t,e))?r:t[e]},propHooks:{tabIndex:{get:function(t){var e=C.find.attr(t,"tabindex");return e?parseInt(e,10):de.test(t.nodeName)||he.test(t.nodeName)&&t.href?0:-1}}},propFix:{for:"htmlFor",class:"className"}}),m.optSelected||(C.propHooks.selected={get:function(t){var e=t.parentNode;return e&&e.parentNode&&e.parentNode.selectedIndex,null},set:function(t){var e=t.parentNode;e&&(e.selectedIndex,e.parentNode&&e.parentNode.selectedIndex)}}),C.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){C.propFix[this.toLowerCase()]=this}),C.fn.extend({addClass:function(t){var e,n,r,i,o,s,a,l=0;if(y(t))return this.each(function(e){C(this).addClass(t.call(this,e,ge(this)))});if((e=me(t)).length)for(;n=this[l++];)if(i=ge(n),r=1===n.nodeType&&" "+ve(i)+" "){for(s=0;o=e[s++];)r.indexOf(" "+o+" ")<0&&(r+=o+" ");i!==(a=ve(r))&&n.setAttribute("class",a)}return this},removeClass:function(t){var e,n,r,i,o,s,a,l=0;if(y(t))return this.each(function(e){C(this).removeClass(t.call(this,e,ge(this)))});if(!arguments.length)return this.attr("class","");if((e=me(t)).length)for(;n=this[l++];)if(i=ge(n),r=1===n.nodeType&&" "+ve(i)+" "){for(s=0;o=e[s++];)for(;r.indexOf(" "+o+" ")>-1;)r=r.replace(" "+o+" "," ");i!==(a=ve(r))&&n.setAttribute("class",a)}return this},toggleClass:function(t,e){var n=typeof t,r="string"===n||Array.isArray(t);return"boolean"==typeof e&&r?e?this.addClass(t):this.removeClass(t):y(t)?this.each(function(n){C(this).toggleClass(t.call(this,n,ge(this),e),e)}):this.each(function(){var e,i,o,s;if(r)for(i=0,o=C(this),s=me(t);e=s[i++];)o.hasClass(e)?o.removeClass(e):o.addClass(e);else void 0!==t&&"boolean"!==n||((e=ge(this))&&Q.set(this,"__className__",e),this.setAttribute&&this.setAttribute("class",e||!1===t?"":Q.get(this,"__className__")||""))})},hasClass:function(t){var e,n,r=0;for(e=" "+t+" ";n=this[r++];)if(1===n.nodeType&&(" "+ve(ge(n))+" ").indexOf(e)>-1)return!0;return!1}});var ye=/\r/g;C.fn.extend({val:function(t){var e,n,r,i=this[0];return arguments.length?(r=y(t),this.each(function(n){var i;1===this.nodeType&&(null==(i=r?t.call(this,n,C(this).val()):t)?i="":"number"==typeof i?i+="":Array.isArray(i)&&(i=C.map(i,function(t){return null==t?"":t+""})),(e=C.valHooks[this.type]||C.valHooks[this.nodeName.toLowerCase()])&&"set"in e&&void 0!==e.set(this,i,"value")||(this.value=i))})):i?(e=C.valHooks[i.type]||C.valHooks[i.nodeName.toLowerCase()])&&"get"in e&&void 0!==(n=e.get(i,"value"))?n:"string"==typeof(n=i.value)?n.replace(ye,""):null==n?"":n:void 0}}),C.extend({valHooks:{option:{get:function(t){var e=C.find.attr(t,"value");return null!=e?e:ve(C.text(t))}},select:{get:function(t){var e,n,r,i=t.options,o=t.selectedIndex,s="select-one"===t.type,a=s?null:[],l=s?o+1:i.length;for(r=o<0?l:s?o:0;r<l;r++)if(((n=i[r]).selected||r===o)&&!n.disabled&&(!n.parentNode.disabled||!O(n.parentNode,"optgroup"))){if(e=C(n).val(),s)return e;a.push(e)}return a},set:function(t,e){for(var n,r,i=t.options,o=C.makeArray(e),s=i.length;s--;)((r=i[s]).selected=C.inArray(C.valHooks.option.get(r),o)>-1)&&(n=!0);return n||(t.selectedIndex=-1),o}}}}),C.each(["radio","checkbox"],function(){C.valHooks[this]={set:function(t,e){if(Array.isArray(e))return t.checked=C.inArray(C(t).val(),e)>-1}},m.checkOn||(C.valHooks[this].get=function(t){return null===t.getAttribute("value")?"on":t.value})}),m.focusin="onfocusin"in n;var _e=/^(?:focusinfocus|focusoutblur)$/,be=function(t){t.stopPropagation()};C.extend(C.event,{trigger:function(t,e,r,i){var o,a,l,u,c,f,p,d,v=[r||s],g=h.call(t,"type")?t.type:t,m=h.call(t,"namespace")?t.namespace.split("."):[];if(a=d=l=r=r||s,3!==r.nodeType&&8!==r.nodeType&&!_e.test(g+C.event.triggered)&&(g.indexOf(".")>-1&&(g=(m=g.split(".")).shift(),m.sort()),c=g.indexOf(":")<0&&"on"+g,(t=t[C.expando]?t:new C.Event(g,"object"==typeof t&&t)).isTrigger=i?2:3,t.namespace=m.join("."),t.rnamespace=t.namespace?new RegExp("(^|\\.)"+m.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,t.result=void 0,t.target||(t.target=r),e=null==e?[t]:C.makeArray(e,[t]),p=C.event.special[g]||{},i||!p.trigger||!1!==p.trigger.apply(r,e))){if(!i&&!p.noBubble&&!_(r)){for(u=p.delegateType||g,_e.test(u+g)||(a=a.parentNode);a;a=a.parentNode)v.push(a),l=a;l===(r.ownerDocument||s)&&v.push(l.defaultView||l.parentWindow||n)}for(o=0;(a=v[o++])&&!t.isPropagationStopped();)d=a,t.type=o>1?u:p.bindType||g,(f=(Q.get(a,"events")||{})[t.type]&&Q.get(a,"handle"))&&f.apply(a,e),(f=c&&a[c])&&f.apply&&Z(a)&&(t.result=f.apply(a,e),!1===t.result&&t.preventDefault());return t.type=g,i||t.isDefaultPrevented()||p._default&&!1!==p._default.apply(v.pop(),e)||!Z(r)||c&&y(r[g])&&!_(r)&&((l=r[c])&&(r[c]=null),C.event.triggered=g,t.isPropagationStopped()&&d.addEventListener(g,be),r[g](),t.isPropagationStopped()&&d.removeEventListener(g,be),C.event.triggered=void 0,l&&(r[c]=l)),t.result}},simulate:function(t,e,n){var r=C.extend(new C.Event,n,{type:t,isSimulated:!0});C.event.trigger(r,null,e)}}),C.fn.extend({trigger:function(t,e){return this.each(function(){C.event.trigger(t,e,this)})},triggerHandler:function(t,e){var n=this[0];if(n)return C.event.trigger(t,e,n,!0)}}),m.focusin||C.each({focus:"focusin",blur:"focusout"},function(t,e){var n=function(t){C.event.simulate(e,t.target,C.event.fix(t))};C.event.special[e]={setup:function(){var r=this.ownerDocument||this,i=Q.access(r,e);i||r.addEventListener(t,n,!0),Q.access(r,e,(i||0)+1)},teardown:function(){var r=this.ownerDocument||this,i=Q.access(r,e)-1;i?Q.access(r,e,i):(r.removeEventListener(t,n,!0),Q.remove(r,e))}}});var we=n.location,xe=Date.now(),Ce=/\?/;C.parseXML=function(t){var e;if(!t||"string"!=typeof t)return null;try{e=(new n.DOMParser).parseFromString(t,"text/xml")}catch(t){e=void 0}return e&&!e.getElementsByTagName("parsererror").length||C.error("Invalid XML: "+t),e};var $e=/\[\]$/,Te=/\r?\n/g,Ae=/^(?:submit|button|image|reset|file)$/i,ke=/^(?:input|select|textarea|keygen)/i;function Ee(t,e,n,r){var i;if(Array.isArray(e))C.each(e,function(e,i){n||$e.test(t)?r(t,i):Ee(t+"["+("object"==typeof i&&null!=i?e:"")+"]",i,n,r)});else if(n||"object"!==x(e))r(t,e);else for(i in e)Ee(t+"["+i+"]",e[i],n,r)}C.param=function(t,e){var n,r=[],i=function(t,e){var n=y(e)?e():e;r[r.length]=encodeURIComponent(t)+"="+encodeURIComponent(null==n?"":n)};if(Array.isArray(t)||t.jquery&&!C.isPlainObject(t))C.each(t,function(){i(this.name,this.value)});else for(n in t)Ee(n,t[n],e,i);return r.join("&")},C.fn.extend({serialize:function(){return C.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var t=C.prop(this,"elements");return t?C.makeArray(t):this}).filter(function(){var t=this.type;return this.name&&!C(this).is(":disabled")&&ke.test(this.nodeName)&&!Ae.test(t)&&(this.checked||!pt.test(t))}).map(function(t,e){var n=C(this).val();return null==n?null:Array.isArray(n)?C.map(n,function(t){return{name:e.name,value:t.replace(Te,"\r\n")}}):{name:e.name,value:n.replace(Te,"\r\n")}}).get()}});var Se=/%20/g,Oe=/#.*$/,De=/([?&])_=[^&]*/,je=/^(.*?):[ \t]*([^\r\n]*)$/gm,Ne=/^(?:GET|HEAD)$/,Ie=/^\/\//,Pe={},Re={},Le="*/".concat("*"),Fe=s.createElement("a");function Ue(t){return function(e,n){"string"!=typeof e&&(n=e,e="*");var r,i=0,o=e.toLowerCase().match(F)||[];if(y(n))for(;r=o[i++];)"+"===r[0]?(r=r.slice(1)||"*",(t[r]=t[r]||[]).unshift(n)):(t[r]=t[r]||[]).push(n)}}function Me(t,e,n,r){var i={},o=t===Re;function s(a){var l;return i[a]=!0,C.each(t[a]||[],function(t,a){var u=a(e,n,r);return"string"!=typeof u||o||i[u]?o?!(l=u):void 0:(e.dataTypes.unshift(u),s(u),!1)}),l}return s(e.dataTypes[0])||!i["*"]&&s("*")}function qe(t,e){var n,r,i=C.ajaxSettings.flatOptions||{};for(n in e)void 0!==e[n]&&((i[n]?t:r||(r={}))[n]=e[n]);return r&&C.extend(!0,t,r),t}Fe.href=we.href,C.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:we.href,type:"GET",isLocal:/^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(we.protocol),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":Le,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/\bxml\b/,html:/\bhtml/,json:/\bjson\b/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":JSON.parse,"text xml":C.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(t,e){return e?qe(qe(t,C.ajaxSettings),e):qe(C.ajaxSettings,t)},ajaxPrefilter:Ue(Pe),ajaxTransport:Ue(Re),ajax:function(t,e){"object"==typeof t&&(e=t,t=void 0),e=e||{};var r,i,o,a,l,u,c,f,p,d,h=C.ajaxSetup({},e),v=h.context||h,g=h.context&&(v.nodeType||v.jquery)?C(v):C.event,m=C.Deferred(),y=C.Callbacks("once memory"),_=h.statusCode||{},b={},w={},x="canceled",$={readyState:0,getResponseHeader:function(t){var e;if(c){if(!a)for(a={};e=je.exec(o);)a[e[1].toLowerCase()]=e[2];e=a[t.toLowerCase()]}return null==e?null:e},getAllResponseHeaders:function(){return c?o:null},setRequestHeader:function(t,e){return null==c&&(t=w[t.toLowerCase()]=w[t.toLowerCase()]||t,b[t]=e),this},overrideMimeType:function(t){return null==c&&(h.mimeType=t),this},statusCode:function(t){var e;if(t)if(c)$.always(t[$.status]);else for(e in t)_[e]=[_[e],t[e]];return this},abort:function(t){var e=t||x;return r&&r.abort(e),T(0,e),this}};if(m.promise($),h.url=((t||h.url||we.href)+"").replace(Ie,we.protocol+"//"),h.type=e.method||e.type||h.method||h.type,h.dataTypes=(h.dataType||"*").toLowerCase().match(F)||[""],null==h.crossDomain){u=s.createElement("a");try{u.href=h.url,u.href=u.href,h.crossDomain=Fe.protocol+"//"+Fe.host!=u.protocol+"//"+u.host}catch(t){h.crossDomain=!0}}if(h.data&&h.processData&&"string"!=typeof h.data&&(h.data=C.param(h.data,h.traditional)),Me(Pe,h,e,$),c)return $;for(p in(f=C.event&&h.global)&&0==C.active++&&C.event.trigger("ajaxStart"),h.type=h.type.toUpperCase(),h.hasContent=!Ne.test(h.type),i=h.url.replace(Oe,""),h.hasContent?h.data&&h.processData&&0===(h.contentType||"").indexOf("application/x-www-form-urlencoded")&&(h.data=h.data.replace(Se,"+")):(d=h.url.slice(i.length),h.data&&(h.processData||"string"==typeof h.data)&&(i+=(Ce.test(i)?"&":"?")+h.data,delete h.data),!1===h.cache&&(i=i.replace(De,"$1"),d=(Ce.test(i)?"&":"?")+"_="+xe+++d),h.url=i+d),h.ifModified&&(C.lastModified[i]&&$.setRequestHeader("If-Modified-Since",C.lastModified[i]),C.etag[i]&&$.setRequestHeader("If-None-Match",C.etag[i])),(h.data&&h.hasContent&&!1!==h.contentType||e.contentType)&&$.setRequestHeader("Content-Type",h.contentType),$.setRequestHeader("Accept",h.dataTypes[0]&&h.accepts[h.dataTypes[0]]?h.accepts[h.dataTypes[0]]+("*"!==h.dataTypes[0]?", "+Le+"; q=0.01":""):h.accepts["*"]),h.headers)$.setRequestHeader(p,h.headers[p]);if(h.beforeSend&&(!1===h.beforeSend.call(v,$,h)||c))return $.abort();if(x="abort",y.add(h.complete),$.done(h.success),$.fail(h.error),r=Me(Re,h,e,$)){if($.readyState=1,f&&g.trigger("ajaxSend",[$,h]),c)return $;h.async&&h.timeout>0&&(l=n.setTimeout(function(){$.abort("timeout")},h.timeout));try{c=!1,r.send(b,T)}catch(t){if(c)throw t;T(-1,t)}}else T(-1,"No Transport");function T(t,e,s,a){var u,p,d,b,w,x=e;c||(c=!0,l&&n.clearTimeout(l),r=void 0,o=a||"",$.readyState=t>0?4:0,u=t>=200&&t<300||304===t,s&&(b=function(t,e,n){for(var r,i,o,s,a=t.contents,l=t.dataTypes;"*"===l[0];)l.shift(),void 0===r&&(r=t.mimeType||e.getResponseHeader("Content-Type"));if(r)for(i in a)if(a[i]&&a[i].test(r)){l.unshift(i);break}if(l[0]in n)o=l[0];else{for(i in n){if(!l[0]||t.converters[i+" "+l[0]]){o=i;break}s||(s=i)}o=o||s}if(o)return o!==l[0]&&l.unshift(o),n[o]}(h,$,s)),b=function(t,e,n,r){var i,o,s,a,l,u={},c=t.dataTypes.slice();if(c[1])for(s in t.converters)u[s.toLowerCase()]=t.converters[s];for(o=c.shift();o;)if(t.responseFields[o]&&(n[t.responseFields[o]]=e),!l&&r&&t.dataFilter&&(e=t.dataFilter(e,t.dataType)),l=o,o=c.shift())if("*"===o)o=l;else if("*"!==l&&l!==o){if(!(s=u[l+" "+o]||u["* "+o]))for(i in u)if((a=i.split(" "))[1]===o&&(s=u[l+" "+a[0]]||u["* "+a[0]])){!0===s?s=u[i]:!0!==u[i]&&(o=a[0],c.unshift(a[1]));break}if(!0!==s)if(s&&t.throws)e=s(e);else try{e=s(e)}catch(t){return{state:"parsererror",error:s?t:"No conversion from "+l+" to "+o}}}return{state:"success",data:e}}(h,b,$,u),u?(h.ifModified&&((w=$.getResponseHeader("Last-Modified"))&&(C.lastModified[i]=w),(w=$.getResponseHeader("etag"))&&(C.etag[i]=w)),204===t||"HEAD"===h.type?x="nocontent":304===t?x="notmodified":(x=b.state,p=b.data,u=!(d=b.error))):(d=x,!t&&x||(x="error",t<0&&(t=0))),$.status=t,$.statusText=(e||x)+"",u?m.resolveWith(v,[p,x,$]):m.rejectWith(v,[$,x,d]),$.statusCode(_),_=void 0,f&&g.trigger(u?"ajaxSuccess":"ajaxError",[$,h,u?p:d]),y.fireWith(v,[$,x]),f&&(g.trigger("ajaxComplete",[$,h]),--C.active||C.event.trigger("ajaxStop")))}return $},getJSON:function(t,e,n){return C.get(t,e,n,"json")},getScript:function(t,e){return C.get(t,void 0,e,"script")}}),C.each(["get","post"],function(t,e){C[e]=function(t,n,r,i){return y(n)&&(i=i||r,r=n,n=void 0),C.ajax(C.extend({url:t,type:e,dataType:i,data:n,success:r},C.isPlainObject(t)&&t))}}),C._evalUrl=function(t){return C.ajax({url:t,type:"GET",dataType:"script",cache:!0,async:!1,global:!1,throws:!0})},C.fn.extend({wrapAll:function(t){var e;return this[0]&&(y(t)&&(t=t.call(this[0])),e=C(t,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&e.insertBefore(this[0]),e.map(function(){for(var t=this;t.firstElementChild;)t=t.firstElementChild;return t}).append(this)),this},wrapInner:function(t){return y(t)?this.each(function(e){C(this).wrapInner(t.call(this,e))}):this.each(function(){var e=C(this),n=e.contents();n.length?n.wrapAll(t):e.append(t)})},wrap:function(t){var e=y(t);return this.each(function(n){C(this).wrapAll(e?t.call(this,n):t)})},unwrap:function(t){return this.parent(t).not("body").each(function(){C(this).replaceWith(this.childNodes)}),this}}),C.expr.pseudos.hidden=function(t){return!C.expr.pseudos.visible(t)},C.expr.pseudos.visible=function(t){return!!(t.offsetWidth||t.offsetHeight||t.getClientRects().length)},C.ajaxSettings.xhr=function(){try{return new n.XMLHttpRequest}catch(t){}};var He={0:200,1223:204},Be=C.ajaxSettings.xhr();m.cors=!!Be&&"withCredentials"in Be,m.ajax=Be=!!Be,C.ajaxTransport(function(t){var e,r;if(m.cors||Be&&!t.crossDomain)return{send:function(i,o){var s,a=t.xhr();if(a.open(t.type,t.url,t.async,t.username,t.password),t.xhrFields)for(s in t.xhrFields)a[s]=t.xhrFields[s];for(s in t.mimeType&&a.overrideMimeType&&a.overrideMimeType(t.mimeType),t.crossDomain||i["X-Requested-With"]||(i["X-Requested-With"]="XMLHttpRequest"),i)a.setRequestHeader(s,i[s]);e=function(t){return function(){e&&(e=r=a.onload=a.onerror=a.onabort=a.ontimeout=a.onreadystatechange=null,"abort"===t?a.abort():"error"===t?"number"!=typeof a.status?o(0,"error"):o(a.status,a.statusText):o(He[a.status]||a.status,a.statusText,"text"!==(a.responseType||"text")||"string"!=typeof a.responseText?{binary:a.response}:{text:a.responseText},a.getAllResponseHeaders()))}},a.onload=e(),r=a.onerror=a.ontimeout=e("error"),void 0!==a.onabort?a.onabort=r:a.onreadystatechange=function(){4===a.readyState&&n.setTimeout(function(){e&&r()})},e=e("abort");try{a.send(t.hasContent&&t.data||null)}catch(t){if(e)throw t}},abort:function(){e&&e()}}}),C.ajaxPrefilter(function(t){t.crossDomain&&(t.contents.script=!1)}),C.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/\b(?:java|ecma)script\b/},converters:{"text script":function(t){return C.globalEval(t),t}}}),C.ajaxPrefilter("script",function(t){void 0===t.cache&&(t.cache=!1),t.crossDomain&&(t.type="GET")}),C.ajaxTransport("script",function(t){var e,n;if(t.crossDomain)return{send:function(r,i){e=C("<script>").prop({charset:t.scriptCharset,src:t.url}).on("load error",n=function(t){e.remove(),n=null,t&&i("error"===t.type?404:200,t.type)}),s.head.appendChild(e[0])},abort:function(){n&&n()}}});var ze,We=[],Ve=/(=)\?(?=&|$)|\?\?/;C.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var t=We.pop()||C.expando+"_"+xe++;return this[t]=!0,t}}),C.ajaxPrefilter("json jsonp",function(t,e,r){var i,o,s,a=!1!==t.jsonp&&(Ve.test(t.url)?"url":"string"==typeof t.data&&0===(t.contentType||"").indexOf("application/x-www-form-urlencoded")&&Ve.test(t.data)&&"data");if(a||"jsonp"===t.dataTypes[0])return i=t.jsonpCallback=y(t.jsonpCallback)?t.jsonpCallback():t.jsonpCallback,a?t[a]=t[a].replace(Ve,"$1"+i):!1!==t.jsonp&&(t.url+=(Ce.test(t.url)?"&":"?")+t.jsonp+"="+i),t.converters["script json"]=function(){return s||C.error(i+" was not called"),s[0]},t.dataTypes[0]="json",o=n[i],n[i]=function(){s=arguments},r.always(function(){void 0===o?C(n).removeProp(i):n[i]=o,t[i]&&(t.jsonpCallback=e.jsonpCallback,We.push(i)),s&&y(o)&&o(s[0]),s=o=void 0}),"script"}),m.createHTMLDocument=((ze=s.implementation.createHTMLDocument("").body).innerHTML="<form></form><form></form>",2===ze.childNodes.length),C.parseHTML=function(t,e,n){return"string"!=typeof t?[]:("boolean"==typeof e&&(n=e,e=!1),e||(m.createHTMLDocument?((r=(e=s.implementation.createHTMLDocument("")).createElement("base")).href=s.location.href,e.head.appendChild(r)):e=s),i=D.exec(t),o=!n&&[],i?[e.createElement(i[1])]:(i=wt([t],e,o),o&&o.length&&C(o).remove(),C.merge([],i.childNodes)));var r,i,o},C.fn.load=function(t,e,n){var r,i,o,s=this,a=t.indexOf(" ");return a>-1&&(r=ve(t.slice(a)),t=t.slice(0,a)),y(e)?(n=e,e=void 0):e&&"object"==typeof e&&(i="POST"),s.length>0&&C.ajax({url:t,type:i||"GET",dataType:"html",data:e}).done(function(t){o=arguments,s.html(r?C("<div>").append(C.parseHTML(t)).find(r):t)}).always(n&&function(t,e){s.each(function(){n.apply(this,o||[t.responseText,e,t])})}),this},C.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(t,e){C.fn[e]=function(t){return this.on(e,t)}}),C.expr.pseudos.animated=function(t){return C.grep(C.timers,function(e){return t===e.elem}).length},C.offset={setOffset:function(t,e,n){var r,i,o,s,a,l,u=C.css(t,"position"),c=C(t),f={};"static"===u&&(t.style.position="relative"),a=c.offset(),o=C.css(t,"top"),l=C.css(t,"left"),("absolute"===u||"fixed"===u)&&(o+l).indexOf("auto")>-1?(s=(r=c.position()).top,i=r.left):(s=parseFloat(o)||0,i=parseFloat(l)||0),y(e)&&(e=e.call(t,n,C.extend({},a))),null!=e.top&&(f.top=e.top-a.top+s),null!=e.left&&(f.left=e.left-a.left+i),"using"in e?e.using.call(t,f):c.css(f)}},C.fn.extend({offset:function(t){if(arguments.length)return void 0===t?this:this.each(function(e){C.offset.setOffset(this,t,e)});var e,n,r=this[0];return r?r.getClientRects().length?(e=r.getBoundingClientRect(),n=r.ownerDocument.defaultView,{top:e.top+n.pageYOffset,left:e.left+n.pageXOffset}):{top:0,left:0}:void 0},position:function(){if(this[0]){var t,e,n,r=this[0],i={top:0,left:0};if("fixed"===C.css(r,"position"))e=r.getBoundingClientRect();else{for(e=this.offset(),n=r.ownerDocument,t=r.offsetParent||n.documentElement;t&&(t===n.body||t===n.documentElement)&&"static"===C.css(t,"position");)t=t.parentNode;t&&t!==r&&1===t.nodeType&&((i=C(t).offset()).top+=C.css(t,"borderTopWidth",!0),i.left+=C.css(t,"borderLeftWidth",!0))}return{top:e.top-i.top-C.css(r,"marginTop",!0),left:e.left-i.left-C.css(r,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){for(var t=this.offsetParent;t&&"static"===C.css(t,"position");)t=t.offsetParent;return t||xt})}}),C.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(t,e){var n="pageYOffset"===e;C.fn[t]=function(r){return W(this,function(t,r,i){var o;if(_(t)?o=t:9===t.nodeType&&(o=t.defaultView),void 0===i)return o?o[e]:t[r];o?o.scrollTo(n?o.pageXOffset:i,n?i:o.pageYOffset):t[r]=i},t,r,arguments.length)}}),C.each(["top","left"],function(t,e){C.cssHooks[e]=zt(m.pixelPosition,function(t,n){if(n)return n=Bt(t,e),Mt.test(n)?C(t).position()[e]+"px":n})}),C.each({Height:"height",Width:"width"},function(t,e){C.each({padding:"inner"+t,content:e,"":"outer"+t},function(n,r){C.fn[r]=function(i,o){var s=arguments.length&&(n||"boolean"!=typeof i),a=n||(!0===i||!0===o?"margin":"border");return W(this,function(e,n,i){var o;return _(e)?0===r.indexOf("outer")?e["inner"+t]:e.document.documentElement["client"+t]:9===e.nodeType?(o=e.documentElement,Math.max(e.body["scroll"+t],o["scroll"+t],e.body["offset"+t],o["offset"+t],o["client"+t])):void 0===i?C.css(e,n,a):C.style(e,n,i,a)},e,s?i:void 0,s)}})}),C.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),function(t,e){C.fn[e]=function(t,n){return arguments.length>0?this.on(e,null,t,n):this.trigger(e)}}),C.fn.extend({hover:function(t,e){return this.mouseenter(t).mouseleave(e||t)}}),C.fn.extend({bind:function(t,e,n){return this.on(t,null,e,n)},unbind:function(t,e){return this.off(t,null,e)},delegate:function(t,e,n,r){return this.on(e,t,n,r)},undelegate:function(t,e,n){return 1===arguments.length?this.off(t,"**"):this.off(e,t||"**",n)}}),C.proxy=function(t,e){var n,r,i;if("string"==typeof e&&(n=t[e],e=t,t=n),y(t))return r=l.call(arguments,2),(i=function(){return t.apply(e||this,r.concat(l.call(arguments)))}).guid=t.guid=t.guid||C.guid++,i},C.holdReady=function(t){t?C.readyWait++:C.ready(!0)},C.isArray=Array.isArray,C.parseJSON=JSON.parse,C.nodeName=O,C.isFunction=y,C.isWindow=_,C.camelCase=K,C.type=x,C.now=Date.now,C.isNumeric=function(t){var e=C.type(t);return("number"===e||"string"===e)&&!isNaN(t-parseFloat(t))},void 0===(r=function(){return C}.apply(e,[]))||(t.exports=r);var Ge=n.jQuery,Xe=n.$;return C.noConflict=function(t){return n.$===C&&(n.$=Xe),t&&n.jQuery===C&&(n.jQuery=Ge),C},i||(n.jQuery=n.$=C),C})},"8+8L":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),n.d(e,"Url",function(){return D}),n.d(e,"Http",function(){return B}),n.d(e,"Resource",function(){return z});var r=2;function i(t){this.state=r,this.value=void 0,this.deferred=[];var e=this;try{t(function(t){e.resolve(t)},function(t){e.reject(t)})}catch(t){e.reject(t)}}i.reject=function(t){return new i(function(e,n){n(t)})},i.resolve=function(t){return new i(function(e,n){e(t)})},i.all=function(t){return new i(function(e,n){var r=0,o=[];function s(n){return function(i){o[n]=i,(r+=1)===t.length&&e(o)}}0===t.length&&e(o);for(var a=0;a<t.length;a+=1)i.resolve(t[a]).then(s(a),n)})},i.race=function(t){return new i(function(e,n){for(var r=0;r<t.length;r+=1)i.resolve(t[r]).then(e,n)})};var o=i.prototype;function s(t,e){t instanceof Promise?this.promise=t:this.promise=new Promise(t.bind(e)),this.context=e}o.resolve=function(t){var e=this;if(e.state===r){if(t===e)throw new TypeError("Promise settled with itself.");var n=!1;try{var i=t&&t.then;if(null!==t&&"object"==typeof t&&"function"==typeof i)return void i.call(t,function(t){n||e.resolve(t),n=!0},function(t){n||e.reject(t),n=!0})}catch(t){return void(n||e.reject(t))}e.state=0,e.value=t,e.notify()}},o.reject=function(t){if(this.state===r){if(t===this)throw new TypeError("Promise settled with itself.");this.state=1,this.value=t,this.notify()}},o.notify=function(){var t,e=this;l(function(){if(e.state!==r)for(;e.deferred.length;){var t=e.deferred.shift(),n=t[0],i=t[1],o=t[2],s=t[3];try{0===e.state?o("function"==typeof n?n.call(void 0,e.value):e.value):1===e.state&&("function"==typeof i?o(i.call(void 0,e.value)):s(e.value))}catch(t){s(t)}}},t)},o.then=function(t,e){var n=this;return new i(function(r,i){n.deferred.push([t,e,r,i]),n.notify()})},o.catch=function(t){return this.then(void 0,t)},"undefined"==typeof Promise&&(window.Promise=i),s.all=function(t,e){return new s(Promise.all(t),e)},s.resolve=function(t,e){return new s(Promise.resolve(t),e)},s.reject=function(t,e){return new s(Promise.reject(t),e)},s.race=function(t,e){return new s(Promise.race(t),e)};var a=s.prototype;a.bind=function(t){return this.context=t,this},a.then=function(t,e){return t&&t.bind&&this.context&&(t=t.bind(this.context)),e&&e.bind&&this.context&&(e=e.bind(this.context)),new s(this.promise.then(t,e),this.context)},a.catch=function(t){return t&&t.bind&&this.context&&(t=t.bind(this.context)),new s(this.promise.catch(t),this.context)},a.finally=function(t){return this.then(function(e){return t.call(this),e},function(e){return t.call(this),Promise.reject(e)})};var l,u={}.hasOwnProperty,c=[].slice,f=!1,p="undefined"!=typeof window;function d(t){return t?t.replace(/^\s*|\s*$/g,""):""}function h(t){return t?t.toLowerCase():""}var v=Array.isArray;function g(t){return"string"==typeof t}function m(t){return"function"==typeof t}function y(t){return null!==t&&"object"==typeof t}function _(t){return y(t)&&Object.getPrototypeOf(t)==Object.prototype}function b(t,e,n){var r=s.resolve(t);return arguments.length<2?r:r.then(e,n)}function w(t,e,n){return m(n=n||{})&&(n=n.call(e)),$(t.bind({$vm:e,$options:n}),t,{$options:n})}function x(t,e){var n,r;if(v(t))for(n=0;n<t.length;n++)e.call(t[n],t[n],n);else if(y(t))for(r in t)u.call(t,r)&&e.call(t[r],t[r],r);return t}var C=Object.assign||function(t){return c.call(arguments,1).forEach(function(e){T(t,e)}),t};function $(t){return c.call(arguments,1).forEach(function(e){T(t,e,!0)}),t}function T(t,e,n){for(var r in e)n&&(_(e[r])||v(e[r]))?(_(e[r])&&!_(t[r])&&(t[r]={}),v(e[r])&&!v(t[r])&&(t[r]=[]),T(t[r],e[r],n)):void 0!==e[r]&&(t[r]=e[r])}function A(t,e,n){var r=function(t){var e=["+","#",".","/",";","?","&"],n=[];return{vars:n,expand:function(r){return t.replace(/\{([^{}]+)\}|([^{}]+)/g,function(t,i,o){if(i){var s=null,a=[];if(-1!==e.indexOf(i.charAt(0))&&(s=i.charAt(0),i=i.substr(1)),i.split(/,/g).forEach(function(t){var e=/([^:*]*)(?::(\d+)|(\*))?/.exec(t);a.push.apply(a,function(t,e,n,r){var i=t[n],o=[];if(k(i)&&""!==i)if("string"==typeof i||"number"==typeof i||"boolean"==typeof i)i=i.toString(),r&&"*"!==r&&(i=i.substring(0,parseInt(r,10))),o.push(S(e,i,E(e)?n:null));else if("*"===r)Array.isArray(i)?i.filter(k).forEach(function(t){o.push(S(e,t,E(e)?n:null))}):Object.keys(i).forEach(function(t){k(i[t])&&o.push(S(e,i[t],t))});else{var s=[];Array.isArray(i)?i.filter(k).forEach(function(t){s.push(S(e,t))}):Object.keys(i).forEach(function(t){k(i[t])&&(s.push(encodeURIComponent(t)),s.push(S(e,i[t].toString())))}),E(e)?o.push(encodeURIComponent(n)+"="+s.join(",")):0!==s.length&&o.push(s.join(","))}else";"===e?o.push(encodeURIComponent(n)):""!==i||"&"!==e&&"?"!==e?""===i&&o.push(""):o.push(encodeURIComponent(n)+"=");return o}(r,s,e[1],e[2]||e[3])),n.push(e[1])}),s&&"+"!==s){var l=",";return"?"===s?l="&":"#"!==s&&(l=s),(0!==a.length?s:"")+a.join(l)}return a.join(",")}return O(o)})}}}(t),i=r.expand(e);return n&&n.push.apply(n,r.vars),i}function k(t){return void 0!==t&&null!==t}function E(t){return";"===t||"&"===t||"?"===t}function S(t,e,n){return e="+"===t||"#"===t?O(e):encodeURIComponent(e),n?encodeURIComponent(n)+"="+e:e}function O(t){return t.split(/(%[0-9A-Fa-f]{2})/g).map(function(t){return/%[0-9A-Fa-f]/.test(t)||(t=encodeURI(t)),t}).join("")}function D(t,e){var n,r=this||{},i=t;return g(t)&&(i={url:t,params:e}),i=$({},D.options,r.$options,i),D.transforms.forEach(function(t){g(t)&&(t=D.transform[t]),m(t)&&(n=function(t,e,n){return function(r){return t.call(n,r,e)}}(t,n,r.$vm))}),n(i)}function j(t){return new s(function(e){var n=new XDomainRequest,r=function(r){var i=r.type,o=0;"load"===i?o=200:"error"===i&&(o=500),e(t.respondWith(n.responseText,{status:o}))};t.abort=function(){return n.abort()},n.open(t.method,t.getUrl()),t.timeout&&(n.timeout=t.timeout),n.onload=r,n.onabort=r,n.onerror=r,n.ontimeout=r,n.onprogress=function(){},n.send(t.getBody())})}D.options={url:"",root:null,params:{}},D.transform={template:function(t){var e=[],n=A(t.url,t.params,e);return e.forEach(function(e){delete t.params[e]}),n},query:function(t,e){var n=Object.keys(D.options.params),r={},i=e(t);return x(t.params,function(t,e){-1===n.indexOf(e)&&(r[e]=t)}),(r=D.params(r))&&(i+=(-1==i.indexOf("?")?"?":"&")+r),i},root:function(t,e){var n,r,i=e(t);return g(t.root)&&!/^(https?:)?\//.test(i)&&(n=t.root,r="/",i=(n&&void 0===r?n.replace(/\s+$/,""):n&&r?n.replace(new RegExp("["+r+"]+$"),""):n)+"/"+i),i}},D.transforms=["template","query","root"],D.params=function(t){var e=[],n=encodeURIComponent;return e.add=function(t,e){m(e)&&(e=e()),null===e&&(e=""),this.push(n(t)+"="+n(e))},function t(e,n,r){var i,o=v(n),s=_(n);x(n,function(n,a){i=y(n)||v(n),r&&(a=r+"["+(s||i?a:"")+"]"),!r&&o?e.add(n.name,n.value):i?t(e,n,a):e.add(a,n)})}(e,t),e.join("&").replace(/%20/g,"+")},D.parse=function(t){var e=document.createElement("a");return document.documentMode&&(e.href=t,t=e.href),e.href=t,{href:e.href,protocol:e.protocol?e.protocol.replace(/:$/,""):"",port:e.port,host:e.host,hostname:e.hostname,pathname:"/"===e.pathname.charAt(0)?e.pathname:"/"+e.pathname,search:e.search?e.search.replace(/^\?/,""):"",hash:e.hash?e.hash.replace(/^#/,""):""}};var N=p&&"withCredentials"in new XMLHttpRequest;function I(t){return new s(function(e){var n,r,i=t.jsonp||"callback",o=t.jsonpCallback||"_jsonp"+Math.random().toString(36).substr(2),s=null;n=function(n){var i=n.type,a=0;"load"===i&&null!==s?a=200:"error"===i&&(a=500),a&&window[o]&&(delete window[o],document.body.removeChild(r)),e(t.respondWith(s,{status:a}))},window[o]=function(t){s=JSON.stringify(t)},t.abort=function(){n({type:"abort"})},t.params[i]=o,t.timeout&&setTimeout(t.abort,t.timeout),(r=document.createElement("script")).src=t.getUrl(),r.type="text/javascript",r.async=!0,r.onload=n,r.onerror=n,document.body.appendChild(r)})}function P(t){return new s(function(e){var n=new XMLHttpRequest,r=function(r){var i=t.respondWith("response"in n?n.response:n.responseText,{status:1223===n.status?204:n.status,statusText:1223===n.status?"No Content":d(n.statusText)});x(d(n.getAllResponseHeaders()).split("\n"),function(t){i.headers.append(t.slice(0,t.indexOf(":")),t.slice(t.indexOf(":")+1))}),e(i)};t.abort=function(){return n.abort()},n.open(t.method,t.getUrl(),!0),t.timeout&&(n.timeout=t.timeout),t.responseType&&"responseType"in n&&(n.responseType=t.responseType),(t.withCredentials||t.credentials)&&(n.withCredentials=!0),t.crossOrigin||t.headers.set("X-Requested-With","XMLHttpRequest"),m(t.progress)&&"GET"===t.method&&n.addEventListener("progress",t.progress),m(t.downloadProgress)&&n.addEventListener("progress",t.downloadProgress),m(t.progress)&&/^(POST|PUT)$/i.test(t.method)&&n.upload.addEventListener("progress",t.progress),m(t.uploadProgress)&&n.upload&&n.upload.addEventListener("progress",t.uploadProgress),t.headers.forEach(function(t,e){n.setRequestHeader(e,t)}),n.onload=r,n.onabort=r,n.onerror=r,n.ontimeout=r,n.send(t.getBody())})}function R(t){var e=n(1);return new s(function(n){var r,i=t.getUrl(),o=t.getBody(),s=t.method,a={};t.headers.forEach(function(t,e){a[e]=t}),e(i,{body:o,method:s,headers:a}).then(r=function(e){var r=t.respondWith(e.body,{status:e.statusCode,statusText:d(e.statusMessage)});x(e.headers,function(t,e){r.headers.set(e,t)}),n(r)},function(t){return r(t.response)})})}function L(t){return(t.client||(p?P:R))(t)}var F=function(t){var e=this;this.map={},x(t,function(t,n){return e.append(n,t)})};function U(t,e){return Object.keys(t).reduce(function(t,n){return h(e)===h(n)?n:t},null)}F.prototype.has=function(t){return null!==U(this.map,t)},F.prototype.get=function(t){var e=this.map[U(this.map,t)];return e?e.join():null},F.prototype.getAll=function(t){return this.map[U(this.map,t)]||[]},F.prototype.set=function(t,e){this.map[function(t){if(/[^a-z0-9\-#$%&'*+.^_`|~]/i.test(t))throw new TypeError("Invalid character in header field name");return d(t)}(U(this.map,t)||t)]=[d(e)]},F.prototype.append=function(t,e){var n=this.map[U(this.map,t)];n?n.push(d(e)):this.set(t,e)},F.prototype.delete=function(t){delete this.map[U(this.map,t)]},F.prototype.deleteAll=function(){this.map={}},F.prototype.forEach=function(t,e){var n=this;x(this.map,function(r,i){x(r,function(r){return t.call(e,r,i,n)})})};var M=function(t,e){var n=e.url,r=e.headers,i=e.status,o=e.statusText;this.url=n,this.ok=i>=200&&i<300,this.status=i||0,this.statusText=o||"",this.headers=new F(r),this.body=t,g(t)?this.bodyText=t:"undefined"!=typeof Blob&&t instanceof Blob&&(this.bodyBlob=t,function(t){return 0===t.type.indexOf("text")||-1!==t.type.indexOf("json")}(t)&&(this.bodyText=function(t){return new s(function(e){var n=new FileReader;n.readAsText(t),n.onload=function(){e(n.result)}})}(t)))};M.prototype.blob=function(){return b(this.bodyBlob)},M.prototype.text=function(){return b(this.bodyText)},M.prototype.json=function(){return b(this.text(),function(t){return JSON.parse(t)})},Object.defineProperty(M.prototype,"data",{get:function(){return this.body},set:function(t){this.body=t}});var q=function(t){var e;this.body=null,this.params={},C(this,t,{method:(e=t.method||"GET",e?e.toUpperCase():"")}),this.headers instanceof F||(this.headers=new F(this.headers))};q.prototype.getUrl=function(){return D(this)},q.prototype.getBody=function(){return this.body},q.prototype.respondWith=function(t,e){return new M(t,C(e||{},{url:this.getUrl()}))};var H={"Content-Type":"application/json;charset=utf-8"};function B(t){var e=this||{},n=function(t){var e=[L],n=[];function r(r){for(;e.length;){var i=e.pop();if(m(i)){var o=void 0,a=void 0;if(y(o=i.call(t,r,function(t){return a=t})||a))return new s(function(e,r){n.forEach(function(e){o=b(o,function(n){return e.call(t,n)||n},r)}),b(o,e,r)},t);m(o)&&n.unshift(o)}else l="Invalid interceptor of type "+typeof i+", must be a function","undefined"!=typeof console&&f&&console.warn("[VueResource warn]: "+l)}var l}return y(t)||(t=null),r.use=function(t){e.push(t)},r}(e.$vm);return function(t){c.call(arguments,1).forEach(function(e){for(var n in e)void 0===t[n]&&(t[n]=e[n])})}(t||{},e.$options,B.options),B.interceptors.forEach(function(t){g(t)&&(t=B.interceptor[t]),m(t)&&n.use(t)}),n(new q(t)).then(function(t){return t.ok?t:s.reject(t)},function(t){var e;return t instanceof Error&&(e=t,"undefined"!=typeof console&&console.error(e)),s.reject(t)})}function z(t,e,n,r){var i=this||{},o={};return x(n=C({},z.actions,n),function(n,s){n=$({url:t,params:C({},e)},r,n),o[s]=function(){return(i.$http||B)(function(t,e){var n,r=C({},t),i={};switch(e.length){case 2:i=e[0],n=e[1];break;case 1:/^(POST|PUT|PATCH)$/i.test(r.method)?n=e[0]:i=e[0];break;case 0:break;default:throw"Expected up to 2 arguments [params, body], got "+e.length+" arguments"}return r.body=n,r.params=C({},r.params,i),r}(n,arguments))}}),o}function W(t){var e,n,r;W.installed||(n=(e=t).config,r=e.nextTick,l=r,f=n.debug||!n.silent,t.url=D,t.http=B,t.resource=z,t.Promise=s,Object.defineProperties(t.prototype,{$url:{get:function(){return w(t.url,this,this.$options.url)}},$http:{get:function(){return w(t.http,this,this.$options.http)}},$resource:{get:function(){return t.resource.bind(this)}},$promise:{get:function(){var e=this;return function(n){return new t.Promise(n,e)}}}}))}B.options={},B.headers={put:H,post:H,patch:H,delete:H,common:{Accept:"application/json, text/plain, */*"},custom:{}},B.interceptor={before:function(t){m(t.before)&&t.before.call(this,t)},method:function(t){t.emulateHTTP&&/^(PUT|PATCH|DELETE)$/i.test(t.method)&&(t.headers.set("X-HTTP-Method-Override",t.method),t.method="POST")},jsonp:function(t){"JSONP"==t.method&&(t.client=I)},json:function(t){var e=t.headers.get("Content-Type")||"";return y(t.body)&&0===e.indexOf("application/json")&&(t.body=JSON.stringify(t.body)),function(t){return t.bodyText?b(t.text(),function(e){var n,r;if(0===(t.headers.get("Content-Type")||"").indexOf("application/json")||(r=(n=e).match(/^\s*(\[|\{)/))&&{"[":/]\s*$/,"{":/}\s*$/}[r[1]].test(n))try{t.body=JSON.parse(e)}catch(e){t.body=null}else t.body=e;return t}):t}},form:function(t){var e;e=t.body,"undefined"!=typeof FormData&&e instanceof FormData?t.headers.delete("Content-Type"):y(t.body)&&t.emulateJSON&&(t.body=D.params(t.body),t.headers.set("Content-Type","application/x-www-form-urlencoded"))},header:function(t){x(C({},B.headers.common,t.crossOrigin?{}:B.headers.custom,B.headers[h(t.method)]),function(e,n){t.headers.has(n)||t.headers.set(n,e)})},cors:function(t){if(p){var e=D.parse(location.href),n=D.parse(t.getUrl());n.protocol===e.protocol&&n.host===e.host||(t.crossOrigin=!0,t.emulateHTTP=!1,N||(t.client=j))}}},B.interceptors=["before","method","jsonp","json","form","header","cors"],["get","delete","head","jsonp"].forEach(function(t){B[t]=function(e,n){return this(C(n||{},{url:e,method:t}))}}),["post","put","patch"].forEach(function(t){B[t]=function(e,n,r){return this(C(r||{},{url:e,method:t,body:n}))}}),z.actions={get:{method:"GET"},save:{method:"POST"},query:{method:"GET"},update:{method:"PUT"},remove:{method:"DELETE"},delete:{method:"DELETE"}},"undefined"!=typeof window&&window.Vue&&window.Vue.use(W),e.default=W},"8Hdb":function(t,e,n){var r=n("pQUU");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("55ec6dfe",r,!0,{})},"9K+h":function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".action-link[data-v-9d96be2c]{cursor:pointer}.m-b-none[data-v-9d96be2c]{margin-bottom:0}",""])},"A/e+":function(t,e,n){var r=n("VU/8")(n("5m3O"),n("lP3N"),!1,function(t){n("odlp")},"data-v-533de2a9",null);t.exports=r.exports},"Bqz+":function(t,e){},DuR2:function(t,e){var n;n=function(){return this}();try{n=n||Function("return this")()||(0,eval)("this")}catch(t){"object"==typeof window&&(n=window)}t.exports=n},F7gb:function(t,e){},FHXl:function(t,e,n){var r,i,o;!function(s){"use strict";i=[n("7t+N"),n("z1kw")],void 0===(o="function"==typeof(r=s)?r.apply(e,i):r)||(t.exports=o)}(function(t){"use strict";function e(e){var n="dragover"===e;return function(r){r.dataTransfer=r.originalEvent&&r.originalEvent.dataTransfer;var i=r.dataTransfer;i&&-1!==t.inArray("Files",i.types)&&!1!==this._trigger(e,t.Event(e,{delegatedEvent:r}))&&(r.preventDefault(),n&&(i.dropEffect="copy"))}}t.support.fileInput=!(new RegExp("(Android (1\\.[0156]|2\\.[01]))|(Windows Phone (OS 7|8\\.0))|(XBLWP)|(ZuneWP)|(WPDesktop)|(w(eb)?OSBrowser)|(webOS)|(Kindle/(1\\.0|2\\.[05]|3\\.0))").test(window.navigator.userAgent)||t('<input type="file"/>').prop("disabled")),t.support.xhrFileUpload=!(!window.ProgressEvent||!window.FileReader),t.support.xhrFormDataFileUpload=!!window.FormData,t.support.blobSlice=window.Blob&&(Blob.prototype.slice||Blob.prototype.webkitSlice||Blob.prototype.mozSlice),t.widget("blueimp.fileupload",{options:{dropZone:t(document),pasteZone:void 0,fileInput:void 0,replaceFileInput:!0,paramName:void 0,singleFileUploads:!0,limitMultiFileUploads:void 0,limitMultiFileUploadSize:void 0,limitMultiFileUploadSizeOverhead:512,sequentialUploads:!1,limitConcurrentUploads:void 0,forceIframeTransport:!1,redirect:void 0,redirectParamName:void 0,postMessage:void 0,multipart:!0,maxChunkSize:void 0,uploadedBytes:void 0,recalculateProgress:!0,progressInterval:100,bitrateInterval:500,autoUpload:!0,messages:{uploadedBytes:"Uploaded bytes exceed file size"},i18n:function(e,n){return e=this.messages[e]||e.toString(),n&&t.each(n,function(t,n){e=e.replace("{"+t+"}",n)}),e},formData:function(t){return t.serializeArray()},add:function(e,n){if(e.isDefaultPrevented())return!1;(n.autoUpload||!1!==n.autoUpload&&t(this).fileupload("option","autoUpload"))&&n.process().done(function(){n.submit()})},processData:!1,contentType:!1,cache:!1,timeout:0},_specialOptions:["fileInput","dropZone","pasteZone","multipart","forceIframeTransport"],_blobSlice:t.support.blobSlice&&function(){return(this.slice||this.webkitSlice||this.mozSlice).apply(this,arguments)},_BitrateTimer:function(){this.timestamp=Date.now?Date.now():(new Date).getTime(),this.loaded=0,this.bitrate=0,this.getBitrate=function(t,e,n){var r=t-this.timestamp;return(!this.bitrate||!n||r>n)&&(this.bitrate=(e-this.loaded)*(1e3/r)*8,this.loaded=e,this.timestamp=t),this.bitrate}},_isXHRUpload:function(e){return!e.forceIframeTransport&&(!e.multipart&&t.support.xhrFileUpload||t.support.xhrFormDataFileUpload)},_getFormData:function(e){var n;return"function"===t.type(e.formData)?e.formData(e.form):t.isArray(e.formData)?e.formData:"object"===t.type(e.formData)?(n=[],t.each(e.formData,function(t,e){n.push({name:t,value:e})}),n):[]},_getTotal:function(e){var n=0;return t.each(e,function(t,e){n+=e.size||1}),n},_initProgressObject:function(e){var n={loaded:0,total:0,bitrate:0};e._progress?t.extend(e._progress,n):e._progress=n},_initResponseObject:function(t){var e;if(t._response)for(e in t._response)t._response.hasOwnProperty(e)&&delete t._response[e];else t._response={}},_onProgress:function(e,n){if(e.lengthComputable){var r,i=Date.now?Date.now():(new Date).getTime();if(n._time&&n.progressInterval&&i-n._time<n.progressInterval&&e.loaded!==e.total)return;n._time=i,r=Math.floor(e.loaded/e.total*(n.chunkSize||n._progress.total))+(n.uploadedBytes||0),this._progress.loaded+=r-n._progress.loaded,this._progress.bitrate=this._bitrateTimer.getBitrate(i,this._progress.loaded,n.bitrateInterval),n._progress.loaded=n.loaded=r,n._progress.bitrate=n.bitrate=n._bitrateTimer.getBitrate(i,r,n.bitrateInterval),this._trigger("progress",t.Event("progress",{delegatedEvent:e}),n),this._trigger("progressall",t.Event("progressall",{delegatedEvent:e}),this._progress)}},_initProgressListener:function(e){var n=this,r=e.xhr?e.xhr():t.ajaxSettings.xhr();r.upload&&(t(r.upload).bind("progress",function(t){var r=t.originalEvent;t.lengthComputable=r.lengthComputable,t.loaded=r.loaded,t.total=r.total,n._onProgress(t,e)}),e.xhr=function(){return r})},_isInstanceOf:function(t,e){return Object.prototype.toString.call(e)==="[object "+t+"]"},_initXHRData:function(e){var n,r=this,i=e.files[0],o=e.multipart||!t.support.xhrFileUpload,s="array"===t.type(e.paramName)?e.paramName[0]:e.paramName;e.headers=t.extend({},e.headers),e.contentRange&&(e.headers["Content-Range"]=e.contentRange),o&&!e.blob&&this._isInstanceOf("File",i)||(e.headers["Content-Disposition"]='attachment; filename="'+encodeURI(i.uploadName||i.name)+'"'),o?t.support.xhrFormDataFileUpload&&(e.postMessage?(n=this._getFormData(e),e.blob?n.push({name:s,value:e.blob}):t.each(e.files,function(r,i){n.push({name:"array"===t.type(e.paramName)&&e.paramName[r]||s,value:i})})):(r._isInstanceOf("FormData",e.formData)?n=e.formData:(n=new FormData,t.each(this._getFormData(e),function(t,e){n.append(e.name,e.value)})),e.blob?n.append(s,e.blob,i.uploadName||i.name):t.each(e.files,function(i,o){(r._isInstanceOf("File",o)||r._isInstanceOf("Blob",o))&&n.append("array"===t.type(e.paramName)&&e.paramName[i]||s,o,o.uploadName||o.name)})),e.data=n):(e.contentType=i.type||"application/octet-stream",e.data=e.blob||i),e.blob=null},_initIframeSettings:function(e){var n=t("<a></a>").prop("href",e.url).prop("host");e.dataType="iframe "+(e.dataType||""),e.formData=this._getFormData(e),e.redirect&&n&&n!==location.host&&e.formData.push({name:e.redirectParamName||"redirect",value:e.redirect})},_initDataSettings:function(t){this._isXHRUpload(t)?(this._chunkedUpload(t,!0)||(t.data||this._initXHRData(t),this._initProgressListener(t)),t.postMessage&&(t.dataType="postmessage "+(t.dataType||""))):this._initIframeSettings(t)},_getParamName:function(e){var n=t(e.fileInput),r=e.paramName;return r?t.isArray(r)||(r=[r]):(r=[],n.each(function(){for(var e=t(this),n=e.prop("name")||"files[]",i=(e.prop("files")||[1]).length;i;)r.push(n),i-=1}),r.length||(r=[n.prop("name")||"files[]"])),r},_initFormSettings:function(e){e.form&&e.form.length||(e.form=t(e.fileInput.prop("form")),e.form.length||(e.form=t(this.options.fileInput.prop("form")))),e.paramName=this._getParamName(e),e.url||(e.url=e.form.prop("action")||location.href),e.type=(e.type||"string"===t.type(e.form.prop("method"))&&e.form.prop("method")||"").toUpperCase(),"POST"!==e.type&&"PUT"!==e.type&&"PATCH"!==e.type&&(e.type="POST"),e.formAcceptCharset||(e.formAcceptCharset=e.form.attr("accept-charset"))},_getAJAXSettings:function(e){var n=t.extend({},this.options,e);return this._initFormSettings(n),this._initDataSettings(n),n},_getDeferredState:function(t){return t.state?t.state():t.isResolved()?"resolved":t.isRejected()?"rejected":"pending"},_enhancePromise:function(t){return t.success=t.done,t.error=t.fail,t.complete=t.always,t},_getXHRPromise:function(e,n,r){var i=t.Deferred(),o=i.promise();return n=n||this.options.context||o,!0===e?i.resolveWith(n,r):!1===e&&i.rejectWith(n,r),o.abort=i.promise,this._enhancePromise(o)},_addConvenienceMethods:function(e,n){var r=this,i=function(e){return t.Deferred().resolveWith(r,e).promise()};n.process=function(e,o){return(e||o)&&(n._processQueue=this._processQueue=(this._processQueue||i([this])).then(function(){return n.errorThrown?t.Deferred().rejectWith(r,[n]).promise():i(arguments)}).then(e,o)),this._processQueue||i([this])},n.submit=function(){return"pending"!==this.state()&&(n.jqXHR=this.jqXHR=!1!==r._trigger("submit",t.Event("submit",{delegatedEvent:e}),this)&&r._onSend(e,this)),this.jqXHR||r._getXHRPromise()},n.abort=function(){return this.jqXHR?this.jqXHR.abort():(this.errorThrown="abort",r._trigger("fail",null,this),r._getXHRPromise(!1))},n.state=function(){return this.jqXHR?r._getDeferredState(this.jqXHR):this._processQueue?r._getDeferredState(this._processQueue):void 0},n.processing=function(){return!this.jqXHR&&this._processQueue&&"pending"===r._getDeferredState(this._processQueue)},n.progress=function(){return this._progress},n.response=function(){return this._response}},_getUploadedBytes:function(t){var e=t.getResponseHeader("Range"),n=e&&e.split("-"),r=n&&n.length>1&&parseInt(n[1],10);return r&&r+1},_chunkedUpload:function(e,n){e.uploadedBytes=e.uploadedBytes||0;var r,i,o=this,s=e.files[0],a=s.size,l=e.uploadedBytes,u=e.maxChunkSize||a,c=this._blobSlice,f=t.Deferred(),p=f.promise();return!(!(this._isXHRUpload(e)&&c&&(l||("function"===t.type(u)?u(e):u)<a))||e.data)&&(!!n||(l>=a?(s.error=e.i18n("uploadedBytes"),this._getXHRPromise(!1,e.context,[null,"error",s.error])):(i=function(){var n=t.extend({},e),p=n._progress.loaded;n.blob=c.call(s,l,l+("function"===t.type(u)?u(n):u),s.type),n.chunkSize=n.blob.size,n.contentRange="bytes "+l+"-"+(l+n.chunkSize-1)+"/"+a,o._initXHRData(n),o._initProgressListener(n),r=(!1!==o._trigger("chunksend",null,n)&&t.ajax(n)||o._getXHRPromise(!1,n.context)).done(function(r,s,u){l=o._getUploadedBytes(u)||l+n.chunkSize,p+n.chunkSize-n._progress.loaded&&o._onProgress(t.Event("progress",{lengthComputable:!0,loaded:l-n.uploadedBytes,total:l-n.uploadedBytes}),n),e.uploadedBytes=n.uploadedBytes=l,n.result=r,n.textStatus=s,n.jqXHR=u,o._trigger("chunkdone",null,n),o._trigger("chunkalways",null,n),l<a?i():f.resolveWith(n.context,[r,s,u])}).fail(function(t,e,r){n.jqXHR=t,n.textStatus=e,n.errorThrown=r,o._trigger("chunkfail",null,n),o._trigger("chunkalways",null,n),f.rejectWith(n.context,[t,e,r])})},this._enhancePromise(p),p.abort=function(){return r.abort()},i(),p)))},_beforeSend:function(t,e){0===this._active&&(this._trigger("start"),this._bitrateTimer=new this._BitrateTimer,this._progress.loaded=this._progress.total=0,this._progress.bitrate=0),this._initResponseObject(e),this._initProgressObject(e),e._progress.loaded=e.loaded=e.uploadedBytes||0,e._progress.total=e.total=this._getTotal(e.files)||1,e._progress.bitrate=e.bitrate=0,this._active+=1,this._progress.loaded+=e.loaded,this._progress.total+=e.total},_onDone:function(e,n,r,i){var o=i._progress.total,s=i._response;i._progress.loaded<o&&this._onProgress(t.Event("progress",{lengthComputable:!0,loaded:o,total:o}),i),s.result=i.result=e,s.textStatus=i.textStatus=n,s.jqXHR=i.jqXHR=r,this._trigger("done",null,i)},_onFail:function(t,e,n,r){var i=r._response;r.recalculateProgress&&(this._progress.loaded-=r._progress.loaded,this._progress.total-=r._progress.total),i.jqXHR=r.jqXHR=t,i.textStatus=r.textStatus=e,i.errorThrown=r.errorThrown=n,this._trigger("fail",null,r)},_onAlways:function(t,e,n,r){this._trigger("always",null,r)},_onSend:function(e,n){n.submit||this._addConvenienceMethods(e,n);var r,i,o,s,a=this,l=a._getAJAXSettings(n),u=function(){return a._sending+=1,l._bitrateTimer=new a._BitrateTimer,r=r||((i||!1===a._trigger("send",t.Event("send",{delegatedEvent:e}),l))&&a._getXHRPromise(!1,l.context,i)||a._chunkedUpload(l)||t.ajax(l)).done(function(t,e,n){a._onDone(t,e,n,l)}).fail(function(t,e,n){a._onFail(t,e,n,l)}).always(function(t,e,n){if(a._onAlways(t,e,n,l),a._sending-=1,a._active-=1,l.limitConcurrentUploads&&l.limitConcurrentUploads>a._sending)for(var r=a._slots.shift();r;){if("pending"===a._getDeferredState(r)){r.resolve();break}r=a._slots.shift()}0===a._active&&a._trigger("stop")})};return this._beforeSend(e,l),this.options.sequentialUploads||this.options.limitConcurrentUploads&&this.options.limitConcurrentUploads<=this._sending?(this.options.limitConcurrentUploads>1?(o=t.Deferred(),this._slots.push(o),s=o.then(u)):(this._sequence=this._sequence.then(u,u),s=this._sequence),s.abort=function(){return i=[void 0,"abort","abort"],r?r.abort():(o&&o.rejectWith(l.context,i),u())},this._enhancePromise(s)):u()},_onAdd:function(e,n){var r,i,o,s,a=this,l=!0,u=t.extend({},this.options,n),c=n.files,f=c.length,p=u.limitMultiFileUploads,d=u.limitMultiFileUploadSize,h=u.limitMultiFileUploadSizeOverhead,v=0,g=this._getParamName(u),m=0;if(!f)return!1;if(d&&void 0===c[0].size&&(d=void 0),(u.singleFileUploads||p||d)&&this._isXHRUpload(u))if(u.singleFileUploads||d||!p)if(!u.singleFileUploads&&d)for(o=[],r=[],s=0;s<f;s+=1)v+=c[s].size+h,(s+1===f||v+c[s+1].size+h>d||p&&s+1-m>=p)&&(o.push(c.slice(m,s+1)),(i=g.slice(m,s+1)).length||(i=g),r.push(i),m=s+1,v=0);else r=g;else for(o=[],r=[],s=0;s<f;s+=p)o.push(c.slice(s,s+p)),(i=g.slice(s,s+p)).length||(i=g),r.push(i);else o=[c],r=[g];return n.originalFiles=c,t.each(o||c,function(i,s){var u=t.extend({},n);return u.files=o?s:[s],u.paramName=r[i],a._initResponseObject(u),a._initProgressObject(u),a._addConvenienceMethods(e,u),l=a._trigger("add",t.Event("add",{delegatedEvent:e}),u)}),l},_replaceFileInput:function(e){var n=e.fileInput,r=n.clone(!0),i=n.is(document.activeElement);e.fileInputClone=r,t("<form></form>").append(r)[0].reset(),n.after(r).detach(),i&&r.focus(),t.cleanData(n.unbind("remove")),this.options.fileInput=this.options.fileInput.map(function(t,e){return e===n[0]?r[0]:e}),n[0]===this.element[0]&&(this.element=r)},_handleFileTreeEntry:function(e,n){var r,i=this,o=t.Deferred(),s=[],a=function(t){t&&!t.entry&&(t.entry=e),o.resolve([t])},l=function(){r.readEntries(function(t){t.length?(s=s.concat(t),l()):function(t){i._handleFileTreeEntries(t,n+e.name+"/").done(function(t){o.resolve(t)}).fail(a)}(s)},a)};return n=n||"",e.isFile?e._file?(e._file.relativePath=n,o.resolve(e._file)):e.file(function(t){t.relativePath=n,o.resolve(t)},a):e.isDirectory?(r=e.createReader(),l()):o.resolve([]),o.promise()},_handleFileTreeEntries:function(e,n){var r=this;return t.when.apply(t,t.map(e,function(t){return r._handleFileTreeEntry(t,n)})).then(function(){return Array.prototype.concat.apply([],arguments)})},_getDroppedFiles:function(e){var n=(e=e||{}).items;return n&&n.length&&(n[0].webkitGetAsEntry||n[0].getAsEntry)?this._handleFileTreeEntries(t.map(n,function(t){var e;return t.webkitGetAsEntry?((e=t.webkitGetAsEntry())&&(e._file=t.getAsFile()),e):t.getAsEntry()})):t.Deferred().resolve(t.makeArray(e.files)).promise()},_getSingleFileInputFiles:function(e){var n,r,i=(e=t(e)).prop("webkitEntries")||e.prop("entries");if(i&&i.length)return this._handleFileTreeEntries(i);if((n=t.makeArray(e.prop("files"))).length)void 0===n[0].name&&n[0].fileName&&t.each(n,function(t,e){e.name=e.fileName,e.size=e.fileSize});else{if(!(r=e.prop("value")))return t.Deferred().resolve([]).promise();n=[{name:r.replace(/^.*\\/,"")}]}return t.Deferred().resolve(n).promise()},_getFileInputFiles:function(e){return e instanceof t&&1!==e.length?t.when.apply(t,t.map(e,this._getSingleFileInputFiles)).then(function(){return Array.prototype.concat.apply([],arguments)}):this._getSingleFileInputFiles(e)},_onChange:function(e){var n=this,r={fileInput:t(e.target),form:t(e.target.form)};this._getFileInputFiles(r.fileInput).always(function(i){r.files=i,n.options.replaceFileInput&&n._replaceFileInput(r),!1!==n._trigger("change",t.Event("change",{delegatedEvent:e}),r)&&n._onAdd(e,r)})},_onPaste:function(e){var n=e.originalEvent&&e.originalEvent.clipboardData&&e.originalEvent.clipboardData.items,r={files:[]};n&&n.length&&(t.each(n,function(t,e){var n=e.getAsFile&&e.getAsFile();n&&r.files.push(n)}),!1!==this._trigger("paste",t.Event("paste",{delegatedEvent:e}),r)&&this._onAdd(e,r))},_onDrop:function(e){e.dataTransfer=e.originalEvent&&e.originalEvent.dataTransfer;var n=this,r=e.dataTransfer,i={};r&&r.files&&r.files.length&&(e.preventDefault(),this._getDroppedFiles(r).always(function(r){i.files=r,!1!==n._trigger("drop",t.Event("drop",{delegatedEvent:e}),i)&&n._onAdd(e,i)}))},_onDragOver:e("dragover"),_onDragEnter:e("dragenter"),_onDragLeave:e("dragleave"),_initEventHandlers:function(){this._isXHRUpload(this.options)&&(this._on(this.options.dropZone,{dragover:this._onDragOver,drop:this._onDrop,dragenter:this._onDragEnter,dragleave:this._onDragLeave}),this._on(this.options.pasteZone,{paste:this._onPaste})),t.support.fileInput&&this._on(this.options.fileInput,{change:this._onChange})},_destroyEventHandlers:function(){this._off(this.options.dropZone,"dragenter dragleave dragover drop"),this._off(this.options.pasteZone,"paste"),this._off(this.options.fileInput,"change")},_destroy:function(){this._destroyEventHandlers()},_setOption:function(e,n){var r=-1!==t.inArray(e,this._specialOptions);r&&this._destroyEventHandlers(),this._super(e,n),r&&(this._initSpecialOptions(),this._initEventHandlers())},_initSpecialOptions:function(){var e=this.options;void 0===e.fileInput?e.fileInput=this.element.is('input[type="file"]')?this.element:this.element.find('input[type="file"]'):e.fileInput instanceof t||(e.fileInput=t(e.fileInput)),e.dropZone instanceof t||(e.dropZone=t(e.dropZone)),e.pasteZone instanceof t||(e.pasteZone=t(e.pasteZone))},_getRegExp:function(t){var e=t.split("/"),n=e.pop();return e.shift(),new RegExp(e.join("/"),n)},_isRegExpOption:function(e,n){return"url"!==e&&"string"===t.type(n)&&/^\/.*\/[igm]{0,3}$/.test(n)},_initDataAttributes:function(){var e=this,n=this.options,r=this.element.data();t.each(this.element[0].attributes,function(t,i){var o,s=i.name.toLowerCase();/^data-/.test(s)&&(s=s.slice(5).replace(/-[a-z]/g,function(t){return t.charAt(1).toUpperCase()}),o=r[s],e._isRegExpOption(s,o)&&(o=e._getRegExp(o)),n[s]=o)})},_create:function(){this._initDataAttributes(),this._initSpecialOptions(),this._slots=[],this._sequence=this._getXHRPromise(!0),this._sending=this._active=0,this._initProgressObject(this),this._initEventHandlers()},active:function(){return this._active},progress:function(){return this._progress},add:function(e){var n=this;e&&!this.options.disabled&&(e.fileInput&&!e.files?this._getFileInputFiles(e.fileInput).always(function(t){e.files=t,n._onAdd(null,e)}):(e.files=t.makeArray(e.files),this._onAdd(null,e)))},send:function(e){if(e&&!this.options.disabled){if(e.fileInput&&!e.files){var n,r,i=this,o=t.Deferred(),s=o.promise();return s.abort=function(){return r=!0,n?n.abort():(o.reject(null,"abort","abort"),s)},this._getFileInputFiles(e.fileInput).always(function(t){r||(t.length?(e.files=t,(n=i._onSend(null,e)).then(function(t,e,n){o.resolve(t,e,n)},function(t,e,n){o.reject(t,e,n)})):o.reject())}),this._enhancePromise(s)}if(e.files=t.makeArray(e.files),e.files.length)return this._onSend(null,e)}return this._getXHRPromise(!1,e&&e.context)}})})},"FZ+f":function(t,e){t.exports=function(t){var e=[];return e.toString=function(){return this.map(function(e){var n=function(t,e){var n=t[1]||"",r=t[3];if(!r)return n;if(e&&"function"==typeof btoa){var i=(s=r,"/*# sourceMappingURL=data:application/json;charset=utf-8;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(s))))+" */"),o=r.sources.map(function(t){return"/*# sourceURL="+r.sourceRoot+t+" */"});return[n].concat(o).concat([i]).join("\n")}var s;return[n].join("\n")}(e,t);return e[2]?"@media "+e[2]+"{"+n+"}":n}).join("")},e.i=function(t,n){"string"==typeof t&&(t=[[null,t,""]]);for(var r={},i=0;i<this.length;i++){var o=this[i][0];"number"==typeof o&&(r[o]=!0)}for(i=0;i<t.length;i++){var s=t[i];"number"==typeof s[0]&&r[s[0]]||(n&&!s[2]?s[2]=n:n&&(s[2]="("+s[2]+") and ("+n+")"),e.push(s))}},e}},FxKR:function(t,e,n){var r=n("9K+h");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("e2f1bed2",r,!0,{})},GDnL:function(t,e,n){n("WRGp"),Vue.component("passport-clients",n("A/e+")),Vue.component("passport-authorized-clients",n("ooDj")),Vue.component("passport-personal-access-tokens",n("Lypw")),Vue.component("importer",n("NYlw")),Vue.component("fieldset-default-values",n("+sje"))},HB0T:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,"legend[data-v-3bdd24a5]{font-size:13px;font-weight:700;border:0}fieldset>div[data-v-3bdd24a5]{background:#f4f4f4;border:1px solid #d3d6de;margin:0 15px 15px;padding:20px 20px 10px}@media (max-width:992px){legend[data-v-3bdd24a5]{text-align:left!important}}@media (min-width:992px){fieldset>div[data-v-3bdd24a5]{width:55%}}",""])},"I3G/":function(t,e,n){"use strict";(function(e){function n(t){return void 0===t||null===t}function r(t){return void 0!==t&&null!==t}function i(t){return!0===t}function o(t){return"string"==typeof t||"number"==typeof t||"boolean"==typeof t}function s(t){return null!==t&&"object"==typeof t}var a=Object.prototype.toString;function l(t){return"[object Object]"===a.call(t)}function u(t){var e=parseFloat(t);return e>=0&&Math.floor(e)===e&&isFinite(t)}function c(t){return null==t?"":"object"==typeof t?JSON.stringify(t,null,2):String(t)}function f(t){var e=parseFloat(t);return isNaN(e)?t:e}function p(t,e){for(var n=Object.create(null),r=t.split(","),i=0;i<r.length;i++)n[r[i]]=!0;return e?function(t){return n[t.toLowerCase()]}:function(t){return n[t]}}var d=p("slot,component",!0),h=p("key,ref,slot,is");function v(t,e){if(t.length){var n=t.indexOf(e);if(n>-1)return t.splice(n,1)}}var g=Object.prototype.hasOwnProperty;function m(t,e){return g.call(t,e)}function y(t){var e=Object.create(null);return function(n){return e[n]||(e[n]=t(n))}}var _=/-(\w)/g,b=y(function(t){return t.replace(_,function(t,e){return e?e.toUpperCase():""})}),w=y(function(t){return t.charAt(0).toUpperCase()+t.slice(1)}),x=/\B([A-Z])/g,C=y(function(t){return t.replace(x,"-$1").toLowerCase()});function $(t,e){function n(n){var r=arguments.length;return r?r>1?t.apply(e,arguments):t.call(e,n):t.call(e)}return n._length=t.length,n}function T(t,e){e=e||0;for(var n=t.length-e,r=new Array(n);n--;)r[n]=t[n+e];return r}function A(t,e){for(var n in e)t[n]=e[n];return t}function k(t){for(var e={},n=0;n<t.length;n++)t[n]&&A(e,t[n]);return e}function E(t,e,n){}var S=function(t,e,n){return!1},O=function(t){return t};function D(t,e){if(t===e)return!0;var n=s(t),r=s(e);if(!n||!r)return!n&&!r&&String(t)===String(e);try{var i=Array.isArray(t),o=Array.isArray(e);if(i&&o)return t.length===e.length&&t.every(function(t,n){return D(t,e[n])});if(i||o)return!1;var a=Object.keys(t),l=Object.keys(e);return a.length===l.length&&a.every(function(n){return D(t[n],e[n])})}catch(t){return!1}}function j(t,e){for(var n=0;n<t.length;n++)if(D(t[n],e))return n;return-1}function N(t){var e=!1;return function(){e||(e=!0,t.apply(this,arguments))}}var I="data-server-rendered",P=["component","directive","filter"],R=["beforeCreate","created","beforeMount","mounted","beforeUpdate","updated","beforeDestroy","destroyed","activated","deactivated"],L={optionMergeStrategies:Object.create(null),silent:!1,productionTip:!1,devtools:!1,performance:!1,errorHandler:null,warnHandler:null,ignoredElements:[],keyCodes:Object.create(null),isReservedTag:S,isReservedAttr:S,isUnknownElement:S,getTagNamespace:E,parsePlatformTagName:O,mustUseProp:S,_lifecycleHooks:R},F=Object.freeze({});function U(t){var e=(t+"").charCodeAt(0);return 36===e||95===e}function M(t,e,n,r){Object.defineProperty(t,e,{value:n,enumerable:!!r,writable:!0,configurable:!0})}var q=/[^\w.$]/;var H=E;function B(t,e,n){if(L.errorHandler)L.errorHandler.call(null,t,e,n);else{if(!V||"undefined"==typeof console)throw t;console.error(t)}}var z,W="__proto__"in{},V="undefined"!=typeof window,G=V&&window.navigator.userAgent.toLowerCase(),X=G&&/msie|trident/.test(G),K=G&&G.indexOf("msie 9.0")>0,Z=G&&G.indexOf("edge/")>0,J=G&&G.indexOf("android")>0,Q=G&&/iphone|ipad|ipod|ios/.test(G),Y=G&&/chrome\/\d+/.test(G)&&!Z,tt={}.watch,et=!1;if(V)try{var nt={};Object.defineProperty(nt,"passive",{get:function(){et=!0}}),window.addEventListener("test-passive",null,nt)}catch(t){}var rt=function(){return void 0===z&&(z=!V&&void 0!==e&&"server"===e.process.env.VUE_ENV),z},it=V&&window.__VUE_DEVTOOLS_GLOBAL_HOOK__;function ot(t){return"function"==typeof t&&/native code/.test(t.toString())}var st,at="undefined"!=typeof Symbol&&ot(Symbol)&&"undefined"!=typeof Reflect&&ot(Reflect.ownKeys),lt=function(){var t,e=[],n=!1;function r(){n=!1;var t=e.slice(0);e.length=0;for(var r=0;r<t.length;r++)t[r]()}if("undefined"!=typeof Promise&&ot(Promise)){var i=Promise.resolve(),o=function(t){console.error(t)};t=function(){i.then(r).catch(o),Q&&setTimeout(E)}}else if(X||"undefined"==typeof MutationObserver||!ot(MutationObserver)&&"[object MutationObserverConstructor]"!==MutationObserver.toString())t=function(){setTimeout(r,0)};else{var s=1,a=new MutationObserver(r),l=document.createTextNode(String(s));a.observe(l,{characterData:!0}),t=function(){s=(s+1)%2,l.data=String(s)}}return function(r,i){var o;if(e.push(function(){if(r)try{r.call(i)}catch(t){B(t,i,"nextTick")}else o&&o(i)}),n||(n=!0,t()),!r&&"undefined"!=typeof Promise)return new Promise(function(t,e){o=t})}}();st="undefined"!=typeof Set&&ot(Set)?Set:function(){function t(){this.set=Object.create(null)}return t.prototype.has=function(t){return!0===this.set[t]},t.prototype.add=function(t){this.set[t]=!0},t.prototype.clear=function(){this.set=Object.create(null)},t}();var ut=0,ct=function(){this.id=ut++,this.subs=[]};ct.prototype.addSub=function(t){this.subs.push(t)},ct.prototype.removeSub=function(t){v(this.subs,t)},ct.prototype.depend=function(){ct.target&&ct.target.addDep(this)},ct.prototype.notify=function(){for(var t=this.subs.slice(),e=0,n=t.length;e<n;e++)t[e].update()},ct.target=null;var ft=[];var pt=Array.prototype,dt=Object.create(pt);["push","pop","shift","unshift","splice","sort","reverse"].forEach(function(t){var e=pt[t];M(dt,t,function(){for(var n=[],r=arguments.length;r--;)n[r]=arguments[r];var i,o=e.apply(this,n),s=this.__ob__;switch(t){case"push":case"unshift":i=n;break;case"splice":i=n.slice(2)}return i&&s.observeArray(i),s.dep.notify(),o})});var ht=Object.getOwnPropertyNames(dt),vt={shouldConvert:!0},gt=function(t){(this.value=t,this.dep=new ct,this.vmCount=0,M(t,"__ob__",this),Array.isArray(t))?((W?mt:yt)(t,dt,ht),this.observeArray(t)):this.walk(t)};function mt(t,e,n){t.__proto__=e}function yt(t,e,n){for(var r=0,i=n.length;r<i;r++){var o=n[r];M(t,o,e[o])}}function _t(t,e){var n;if(s(t))return m(t,"__ob__")&&t.__ob__ instanceof gt?n=t.__ob__:vt.shouldConvert&&!rt()&&(Array.isArray(t)||l(t))&&Object.isExtensible(t)&&!t._isVue&&(n=new gt(t)),e&&n&&n.vmCount++,n}function bt(t,e,n,r,i){var o=new ct,s=Object.getOwnPropertyDescriptor(t,e);if(!s||!1!==s.configurable){var a=s&&s.get,l=s&&s.set,u=!i&&_t(n);Object.defineProperty(t,e,{enumerable:!0,configurable:!0,get:function(){var e=a?a.call(t):n;return ct.target&&(o.depend(),u&&(u.dep.depend(),Array.isArray(e)&&function t(e){for(var n=void 0,r=0,i=e.length;r<i;r++)(n=e[r])&&n.__ob__&&n.__ob__.dep.depend(),Array.isArray(n)&&t(n)}(e))),e},set:function(e){var r=a?a.call(t):n;e===r||e!=e&&r!=r||(l?l.call(t,e):n=e,u=!i&&_t(e),o.notify())}})}}function wt(t,e,n){if(Array.isArray(t)&&u(e))return t.length=Math.max(t.length,e),t.splice(e,1,n),n;if(m(t,e))return t[e]=n,n;var r=t.__ob__;return t._isVue||r&&r.vmCount?n:r?(bt(r.value,e,n),r.dep.notify(),n):(t[e]=n,n)}function xt(t,e){if(Array.isArray(t)&&u(e))t.splice(e,1);else{var n=t.__ob__;t._isVue||n&&n.vmCount||m(t,e)&&(delete t[e],n&&n.dep.notify())}}gt.prototype.walk=function(t){for(var e=Object.keys(t),n=0;n<e.length;n++)bt(t,e[n],t[e[n]])},gt.prototype.observeArray=function(t){for(var e=0,n=t.length;e<n;e++)_t(t[e])};var Ct=L.optionMergeStrategies;function $t(t,e){if(!e)return t;for(var n,r,i,o=Object.keys(e),s=0;s<o.length;s++)r=t[n=o[s]],i=e[n],m(t,n)?l(r)&&l(i)&&$t(r,i):wt(t,n,i);return t}function Tt(t,e,n){return n?t||e?function(){var r="function"==typeof e?e.call(n):e,i="function"==typeof t?t.call(n):t;return r?$t(r,i):i}:void 0:e?t?function(){return $t("function"==typeof e?e.call(this):e,"function"==typeof t?t.call(this):t)}:e:t}function At(t,e){return e?t?t.concat(e):Array.isArray(e)?e:[e]:t}function kt(t,e){var n=Object.create(t||null);return e?A(n,e):n}Ct.data=function(t,e,n){return n?Tt(t,e,n):e&&"function"!=typeof e?t:Tt.call(this,t,e)},R.forEach(function(t){Ct[t]=At}),P.forEach(function(t){Ct[t+"s"]=kt}),Ct.watch=function(t,e){if(t===tt&&(t=void 0),e===tt&&(e=void 0),!e)return Object.create(t||null);if(!t)return e;var n={};for(var r in A(n,t),e){var i=n[r],o=e[r];i&&!Array.isArray(i)&&(i=[i]),n[r]=i?i.concat(o):Array.isArray(o)?o:[o]}return n},Ct.props=Ct.methods=Ct.inject=Ct.computed=function(t,e){if(!t)return e;var n=Object.create(null);return A(n,t),e&&A(n,e),n},Ct.provide=Tt;var Et=function(t,e){return void 0===e?t:e};function St(t,e,n){"function"==typeof e&&(e=e.options),function(t){var e=t.props;if(e){var n,r,i={};if(Array.isArray(e))for(n=e.length;n--;)"string"==typeof(r=e[n])&&(i[b(r)]={type:null});else if(l(e))for(var o in e)r=e[o],i[b(o)]=l(r)?r:{type:r};t.props=i}}(e),function(t){var e=t.inject;if(Array.isArray(e))for(var n=t.inject={},r=0;r<e.length;r++)n[e[r]]=e[r]}(e),function(t){var e=t.directives;if(e)for(var n in e){var r=e[n];"function"==typeof r&&(e[n]={bind:r,update:r})}}(e);var r=e.extends;if(r&&(t=St(t,r,n)),e.mixins)for(var i=0,o=e.mixins.length;i<o;i++)t=St(t,e.mixins[i],n);var s,a={};for(s in t)u(s);for(s in e)m(t,s)||u(s);function u(r){var i=Ct[r]||Et;a[r]=i(t[r],e[r],n,r)}return a}function Ot(t,e,n,r){if("string"==typeof n){var i=t[e];if(m(i,n))return i[n];var o=b(n);if(m(i,o))return i[o];var s=w(o);return m(i,s)?i[s]:i[n]||i[o]||i[s]}}function Dt(t,e,n,r){var i=e[t],o=!m(n,t),s=n[t];if(Nt(Boolean,i.type)&&(o&&!m(i,"default")?s=!1:Nt(String,i.type)||""!==s&&s!==C(t)||(s=!0)),void 0===s){s=function(t,e,n){if(!m(e,"default"))return;var r=e.default;0;if(t&&t.$options.propsData&&void 0===t.$options.propsData[n]&&void 0!==t._props[n])return t._props[n];return"function"==typeof r&&"Function"!==jt(e.type)?r.call(t):r}(r,i,t);var a=vt.shouldConvert;vt.shouldConvert=!0,_t(s),vt.shouldConvert=a}return s}function jt(t){var e=t&&t.toString().match(/^\s*function (\w+)/);return e?e[1]:""}function Nt(t,e){if(!Array.isArray(e))return jt(e)===jt(t);for(var n=0,r=e.length;n<r;n++)if(jt(e[n])===jt(t))return!0;return!1}var It=function(t,e,n,r,i,o,s,a){this.tag=t,this.data=e,this.children=n,this.text=r,this.elm=i,this.ns=void 0,this.context=o,this.functionalContext=void 0,this.key=e&&e.key,this.componentOptions=s,this.componentInstance=void 0,this.parent=void 0,this.raw=!1,this.isStatic=!1,this.isRootInsert=!0,this.isComment=!1,this.isCloned=!1,this.isOnce=!1,this.asyncFactory=a,this.asyncMeta=void 0,this.isAsyncPlaceholder=!1},Pt={child:{}};Pt.child.get=function(){return this.componentInstance},Object.defineProperties(It.prototype,Pt);var Rt=function(t){void 0===t&&(t="");var e=new It;return e.text=t,e.isComment=!0,e};function Lt(t){return new It(void 0,void 0,void 0,String(t))}function Ft(t,e){var n=new It(t.tag,t.data,t.children,t.text,t.elm,t.context,t.componentOptions,t.asyncFactory);return n.ns=t.ns,n.isStatic=t.isStatic,n.key=t.key,n.isComment=t.isComment,n.isCloned=!0,e&&t.children&&(n.children=Ut(t.children)),n}function Ut(t,e){for(var n=t.length,r=new Array(n),i=0;i<n;i++)r[i]=Ft(t[i],e);return r}var Mt,qt=y(function(t){var e="&"===t.charAt(0),n="~"===(t=e?t.slice(1):t).charAt(0),r="!"===(t=n?t.slice(1):t).charAt(0);return{name:t=r?t.slice(1):t,plain:!(e||n||r),once:n,capture:r,passive:e}});function Ht(t){function e(){var t=arguments,n=e.fns;if(!Array.isArray(n))return n.apply(null,arguments);for(var r=n.slice(),i=0;i<r.length;i++)r[i].apply(null,t)}return e.fns=t,e}function Bt(t,e){return t.plain?-1:e.plain?1:0}function zt(t,e,r,i,o){var s,a,l,u,c=[],f=!1;for(s in t)a=t[s],l=e[s],(u=qt(s)).plain||(f=!0),n(a)||(n(l)?(n(a.fns)&&(a=t[s]=Ht(a)),u.handler=a,c.push(u)):a!==l&&(l.fns=a,t[s]=l));if(c.length){f&&c.sort(Bt);for(var p=0;p<c.length;p++){var d=c[p];r(d.name,d.handler,d.once,d.capture,d.passive)}}for(s in e)n(t[s])&&i((u=qt(s)).name,e[s],u.capture)}function Wt(t,e,o){var s,a=t[e];function l(){o.apply(this,arguments),v(s.fns,l)}n(a)?s=Ht([l]):r(a.fns)&&i(a.merged)?(s=a).fns.push(l):s=Ht([a,l]),s.merged=!0,t[e]=s}function Vt(t,e,n,i,o){if(r(e)){if(m(e,n))return t[n]=e[n],o||delete e[n],!0;if(m(e,i))return t[n]=e[i],o||delete e[i],!0}return!1}function Gt(t){return o(t)?[Lt(t)]:Array.isArray(t)?function t(e,s){var a=[];var l,u,c;for(l=0;l<e.length;l++)n(u=e[l])||"boolean"==typeof u||(c=a[a.length-1],Array.isArray(u)?a.push.apply(a,t(u,(s||"")+"_"+l)):o(u)?Xt(c)?c.text+=String(u):""!==u&&a.push(Lt(u)):Xt(u)&&Xt(c)?a[a.length-1]=Lt(c.text+u.text):(i(e._isVList)&&r(u.tag)&&n(u.key)&&r(s)&&(u.key="__vlist"+s+"_"+l+"__"),a.push(u)));return a}(t):void 0}function Xt(t){return r(t)&&r(t.text)&&!1===t.isComment}function Kt(t,e){return t.__esModule&&t.default&&(t=t.default),s(t)?e.extend(t):t}function Zt(t){return t.isComment&&t.asyncFactory}function Jt(t){if(Array.isArray(t))for(var e=0;e<t.length;e++){var n=t[e];if(r(n)&&(r(n.componentOptions)||Zt(n)))return n}}function Qt(t,e,n){n?Mt.$once(t,e):Mt.$on(t,e)}function Yt(t,e){Mt.$off(t,e)}function te(t,e,n){Mt=t,zt(e,n||{},Qt,Yt)}function ee(t,e){var n={};if(!t)return n;for(var r=[],i=0,o=t.length;i<o;i++){var s=t[i],a=s.data;if(a&&a.attrs&&a.attrs.slot&&delete a.attrs.slot,s.context!==e&&s.functionalContext!==e||!a||null==a.slot)r.push(s);else{var l=s.data.slot,u=n[l]||(n[l]=[]);"template"===s.tag?u.push.apply(u,s.children):u.push(s)}}return r.every(ne)||(n.default=r),n}function ne(t){return t.isComment||" "===t.text}function re(t,e){e=e||{};for(var n=0;n<t.length;n++)Array.isArray(t[n])?re(t[n],e):e[t[n].key]=t[n].fn;return e}var ie=null;function oe(t){for(;t&&(t=t.$parent);)if(t._inactive)return!0;return!1}function se(t,e){if(e){if(t._directInactive=!1,oe(t))return}else if(t._directInactive)return;if(t._inactive||null===t._inactive){t._inactive=!1;for(var n=0;n<t.$children.length;n++)se(t.$children[n]);ae(t,"activated")}}function ae(t,e){var n=t.$options[e];if(n)for(var r=0,i=n.length;r<i;r++)try{n[r].call(t)}catch(n){B(n,t,e+" hook")}t._hasHookEvent&&t.$emit("hook:"+e)}var le=[],ue=[],ce={},fe=!1,pe=!1,de=0;function he(){var t,e;for(pe=!0,le.sort(function(t,e){return t.id-e.id}),de=0;de<le.length;de++)e=(t=le[de]).id,ce[e]=null,t.run();var n=ue.slice(),r=le.slice();de=le.length=ue.length=0,ce={},fe=pe=!1,function(t){for(var e=0;e<t.length;e++)t[e]._inactive=!0,se(t[e],!0)}(n),function(t){var e=t.length;for(;e--;){var n=t[e],r=n.vm;r._watcher===n&&r._isMounted&&ae(r,"updated")}}(r),it&&L.devtools&&it.emit("flush")}var ve=0,ge=function(t,e,n,r){this.vm=t,t._watchers.push(this),r?(this.deep=!!r.deep,this.user=!!r.user,this.lazy=!!r.lazy,this.sync=!!r.sync):this.deep=this.user=this.lazy=this.sync=!1,this.cb=n,this.id=++ve,this.active=!0,this.dirty=this.lazy,this.deps=[],this.newDeps=[],this.depIds=new st,this.newDepIds=new st,this.expression="","function"==typeof e?this.getter=e:(this.getter=function(t){if(!q.test(t)){var e=t.split(".");return function(t){for(var n=0;n<e.length;n++){if(!t)return;t=t[e[n]]}return t}}}(e),this.getter||(this.getter=function(){})),this.value=this.lazy?void 0:this.get()};ge.prototype.get=function(){var t,e;t=this,ct.target&&ft.push(ct.target),ct.target=t;var n,r=this.vm;try{e=this.getter.call(r,r)}catch(t){if(!this.user)throw t;B(t,r,'getter for watcher "'+this.expression+'"')}finally{this.deep&&(n=e,me.clear(),function t(e,n){var r,i,o=Array.isArray(e);if((o||s(e))&&Object.isExtensible(e)){if(e.__ob__){var a=e.__ob__.dep.id;if(n.has(a))return;n.add(a)}if(o)for(r=e.length;r--;)t(e[r],n);else for(i=Object.keys(e),r=i.length;r--;)t(e[i[r]],n)}}(n,me)),ct.target=ft.pop(),this.cleanupDeps()}return e},ge.prototype.addDep=function(t){var e=t.id;this.newDepIds.has(e)||(this.newDepIds.add(e),this.newDeps.push(t),this.depIds.has(e)||t.addSub(this))},ge.prototype.cleanupDeps=function(){for(var t=this.deps.length;t--;){var e=this.deps[t];this.newDepIds.has(e.id)||e.removeSub(this)}var n=this.depIds;this.depIds=this.newDepIds,this.newDepIds=n,this.newDepIds.clear(),n=this.deps,this.deps=this.newDeps,this.newDeps=n,this.newDeps.length=0},ge.prototype.update=function(){this.lazy?this.dirty=!0:this.sync?this.run():function(t){var e=t.id;if(null==ce[e]){if(ce[e]=!0,pe){for(var n=le.length-1;n>de&&le[n].id>t.id;)n--;le.splice(n+1,0,t)}else le.push(t);fe||(fe=!0,lt(he))}}(this)},ge.prototype.run=function(){if(this.active){var t=this.get();if(t!==this.value||s(t)||this.deep){var e=this.value;if(this.value=t,this.user)try{this.cb.call(this.vm,t,e)}catch(t){B(t,this.vm,'callback for watcher "'+this.expression+'"')}else this.cb.call(this.vm,t,e)}}},ge.prototype.evaluate=function(){this.value=this.get(),this.dirty=!1},ge.prototype.depend=function(){for(var t=this.deps.length;t--;)this.deps[t].depend()},ge.prototype.teardown=function(){if(this.active){this.vm._isBeingDestroyed||v(this.vm._watchers,this);for(var t=this.deps.length;t--;)this.deps[t].removeSub(this);this.active=!1}};var me=new st;var ye={enumerable:!0,configurable:!0,get:E,set:E};function _e(t,e,n){ye.get=function(){return this[e][n]},ye.set=function(t){this[e][n]=t},Object.defineProperty(t,n,ye)}function be(t){t._watchers=[];var e=t.$options;e.props&&function(t,e){var n=t.$options.propsData||{},r=t._props={},i=t.$options._propKeys=[],o=!t.$parent;vt.shouldConvert=o;var s=function(o){i.push(o);var s=Dt(o,e,n,t);bt(r,o,s),o in t||_e(t,"_props",o)};for(var a in e)s(a);vt.shouldConvert=!0}(t,e.props),e.methods&&function(t,e){t.$options.props;for(var n in e)t[n]=null==e[n]?E:$(e[n],t)}(t,e.methods),e.data?function(t){var e=t.$options.data;l(e=t._data="function"==typeof e?function(t,e){try{return t.call(e)}catch(t){return B(t,e,"data()"),{}}}(e,t):e||{})||(e={});var n=Object.keys(e),r=t.$options.props,i=(t.$options.methods,n.length);for(;i--;){var o=n[i];0,r&&m(r,o)||U(o)||_e(t,"_data",o)}_t(e,!0)}(t):_t(t._data={},!0),e.computed&&function(t,e){var n=t._computedWatchers=Object.create(null),r=rt();for(var i in e){var o=e[i],s="function"==typeof o?o:o.get;0,r||(n[i]=new ge(t,s||E,E,we)),i in t||xe(t,i,o)}}(t,e.computed),e.watch&&e.watch!==tt&&function(t,e){for(var n in e){var r=e[n];if(Array.isArray(r))for(var i=0;i<r.length;i++)$e(t,n,r[i]);else $e(t,n,r)}}(t,e.watch)}var we={lazy:!0};function xe(t,e,n){var r=!rt();"function"==typeof n?(ye.get=r?Ce(e):n,ye.set=E):(ye.get=n.get?r&&!1!==n.cache?Ce(e):n.get:E,ye.set=n.set?n.set:E),Object.defineProperty(t,e,ye)}function Ce(t){return function(){var e=this._computedWatchers&&this._computedWatchers[t];if(e)return e.dirty&&e.evaluate(),ct.target&&e.depend(),e.value}}function $e(t,e,n,r){return l(n)&&(r=n,n=n.handler),"string"==typeof n&&(n=t[n]),t.$watch(e,n,r)}function Te(t,e){if(t){for(var n=Object.create(null),r=at?Reflect.ownKeys(t).filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}):Object.keys(t),i=0;i<r.length;i++){for(var o=r[i],s=t[o],a=e;a;){if(a._provided&&s in a._provided){n[o]=a._provided[s];break}a=a.$parent}0}return n}}function Ae(t,e){for(var n in e)t[b(n)]=e[n]}var ke={init:function(t,e,n,i){if(!t.componentInstance||t.componentInstance._isDestroyed)(t.componentInstance=function(t,e,n,i){var o=t.componentOptions,s={_isComponent:!0,parent:e,propsData:o.propsData,_componentTag:o.tag,_parentVnode:t,_parentListeners:o.listeners,_renderChildren:o.children,_parentElm:n||null,_refElm:i||null},a=t.data.inlineTemplate;r(a)&&(s.render=a.render,s.staticRenderFns=a.staticRenderFns);return new o.Ctor(s)}(t,ie,n,i)).$mount(e?t.elm:void 0,e);else if(t.data.keepAlive){var o=t;ke.prepatch(o,o)}},prepatch:function(t,e){var n=e.componentOptions;!function(t,e,n,r,i){var o=!!(i||t.$options._renderChildren||r.data.scopedSlots||t.$scopedSlots!==F);if(t.$options._parentVnode=r,t.$vnode=r,t._vnode&&(t._vnode.parent=r),t.$options._renderChildren=i,t.$attrs=r.data&&r.data.attrs||F,t.$listeners=n||F,e&&t.$options.props){vt.shouldConvert=!1;for(var s=t._props,a=t.$options._propKeys||[],l=0;l<a.length;l++){var u=a[l];s[u]=Dt(u,t.$options.props,e,t)}vt.shouldConvert=!0,t.$options.propsData=e}if(n){var c=t.$options._parentListeners;t.$options._parentListeners=n,te(t,n,c)}o&&(t.$slots=ee(i,r.context),t.$forceUpdate())}(e.componentInstance=t.componentInstance,n.propsData,n.listeners,e,n.children)},insert:function(t){var e,n=t.context,r=t.componentInstance;r._isMounted||(r._isMounted=!0,ae(r,"mounted")),t.data.keepAlive&&(n._isMounted?((e=r)._inactive=!1,ue.push(e)):se(r,!0))},destroy:function(t){var e=t.componentInstance;e._isDestroyed||(t.data.keepAlive?function t(e,n){if(!(n&&(e._directInactive=!0,oe(e))||e._inactive)){e._inactive=!0;for(var r=0;r<e.$children.length;r++)t(e.$children[r]);ae(e,"deactivated")}}(e,!0):e.$destroy())}},Ee=Object.keys(ke);function Se(t,e,o,a,l){if(!n(t)){var u=o.$options._base;if(s(t)&&(t=u.extend(t)),"function"==typeof t){var c;if(n(t.cid)&&void 0===(t=function(t,e,o){if(i(t.error)&&r(t.errorComp))return t.errorComp;if(r(t.resolved))return t.resolved;if(i(t.loading)&&r(t.loadingComp))return t.loadingComp;if(!r(t.contexts)){var a=t.contexts=[o],l=!0,u=function(){for(var t=0,e=a.length;t<e;t++)a[t].$forceUpdate()},c=N(function(n){t.resolved=Kt(n,e),l||u()}),f=N(function(e){r(t.errorComp)&&(t.error=!0,u())}),p=t(c,f);return s(p)&&("function"==typeof p.then?n(t.resolved)&&p.then(c,f):r(p.component)&&"function"==typeof p.component.then&&(p.component.then(c,f),r(p.error)&&(t.errorComp=Kt(p.error,e)),r(p.loading)&&(t.loadingComp=Kt(p.loading,e),0===p.delay?t.loading=!0:setTimeout(function(){n(t.resolved)&&n(t.error)&&(t.loading=!0,u())},p.delay||200)),r(p.timeout)&&setTimeout(function(){n(t.resolved)&&f(null)},p.timeout))),l=!1,t.loading?t.loadingComp:t.resolved}t.contexts.push(o)}(c=t,u,o)))return function(t,e,n,r,i){var o=Rt();return o.asyncFactory=t,o.asyncMeta={data:e,context:n,children:r,tag:i},o}(c,e,o,a,l);e=e||{},We(t),r(e.model)&&function(t,e){var n=t.model&&t.model.prop||"value",i=t.model&&t.model.event||"input";(e.props||(e.props={}))[n]=e.model.value;var o=e.on||(e.on={});r(o[i])?o[i]=[e.model.callback].concat(o[i]):o[i]=e.model.callback}(t.options,e);var f=function(t,e,i){var o=e.options.props;if(!n(o)){var s={},a=t.attrs,l=t.props;if(r(a)||r(l))for(var u in o){var c=C(u);Vt(s,l,u,c,!0)||Vt(s,a,u,c,!1)}return s}}(e,t);if(i(t.options.functional))return function(t,e,n,i,o){var s={},a=t.options.props;if(r(a))for(var l in a)s[l]=Dt(l,a,e||F);else r(n.attrs)&&Ae(s,n.attrs),r(n.props)&&Ae(s,n.props);var u=Object.create(i),c=t.options.render.call(null,function(t,e,n,r){return Ne(u,t,e,n,r,!0)},{data:n,props:s,children:o,parent:i,listeners:n.on||F,injections:Te(t.options.inject,i),slots:function(){return ee(o,i)}});return c instanceof It&&(c.functionalContext=i,c.functionalOptions=t.options,n.slot&&((c.data||(c.data={})).slot=n.slot)),c}(t,f,e,o,a);var p=e.on;if(e.on=e.nativeOn,i(t.options.abstract)){var d=e.slot;e={},d&&(e.slot=d)}!function(t){t.hook||(t.hook={});for(var e=0;e<Ee.length;e++){var n=Ee[e],r=t.hook[n],i=ke[n];t.hook[n]=r?Oe(i,r):i}}(e);var h=t.options.name||l;return new It("vue-component-"+t.cid+(h?"-"+h:""),e,void 0,void 0,void 0,o,{Ctor:t,propsData:f,listeners:p,tag:l,children:a},c)}}}function Oe(t,e){return function(n,r,i,o){t(n,r,i,o),e(n,r,i,o)}}var De=1,je=2;function Ne(t,e,s,a,l,u){return(Array.isArray(s)||o(s))&&(l=a,a=s,s=void 0),i(u)&&(l=je),function(t,e,i,o,s){if(r(i)&&r(i.__ob__))return Rt();r(i)&&r(i.is)&&(e=i.is);if(!e)return Rt();0;Array.isArray(o)&&"function"==typeof o[0]&&((i=i||{}).scopedSlots={default:o[0]},o.length=0);s===je?o=Gt(o):s===De&&(o=function(t){for(var e=0;e<t.length;e++)if(Array.isArray(t[e]))return Array.prototype.concat.apply([],t);return t}(o));var a,l;if("string"==typeof e){var u;l=t.$vnode&&t.$vnode.ns||L.getTagNamespace(e),a=L.isReservedTag(e)?new It(L.parsePlatformTagName(e),i,o,void 0,void 0,t):r(u=Ot(t.$options,"components",e))?Se(u,i,t,o,e):new It(e,i,o,void 0,void 0,t)}else a=Se(e,i,t,o);return r(a)?(l&&function t(e,i){e.ns=i;if("foreignObject"===e.tag)return;if(r(e.children))for(var o=0,s=e.children.length;o<s;o++){var a=e.children[o];r(a.tag)&&n(a.ns)&&t(a,i)}}(a,l),a):Rt()}(t,e,s,a,l)}function Ie(t,e){var n,i,o,a,l;if(Array.isArray(t)||"string"==typeof t)for(n=new Array(t.length),i=0,o=t.length;i<o;i++)n[i]=e(t[i],i);else if("number"==typeof t)for(n=new Array(t),i=0;i<t;i++)n[i]=e(i+1,i);else if(s(t))for(a=Object.keys(t),n=new Array(a.length),i=0,o=a.length;i<o;i++)l=a[i],n[i]=e(t[l],l,i);return r(n)&&(n._isVList=!0),n}function Pe(t,e,n,r){var i=this.$scopedSlots[t];if(i)return n=n||{},r&&(n=A(A({},r),n)),i(n)||e;var o=this.$slots[t];return o||e}function Re(t){return Ot(this.$options,"filters",t)||O}function Le(t,e,n){var r=L.keyCodes[e]||n;return Array.isArray(r)?-1===r.indexOf(t):r!==t}function Fe(t,e,n,r,i){if(n)if(s(n)){var o;Array.isArray(n)&&(n=k(n));var a=function(s){if("class"===s||"style"===s||h(s))o=t;else{var a=t.attrs&&t.attrs.type;o=r||L.mustUseProp(e,a,s)?t.domProps||(t.domProps={}):t.attrs||(t.attrs={})}s in o||(o[s]=n[s],i&&((t.on||(t.on={}))["update:"+s]=function(t){n[s]=t}))};for(var l in n)a(l)}else;return t}function Ue(t,e){var n=this._staticTrees[t];return n&&!e?Array.isArray(n)?Ut(n):Ft(n):(qe(n=this._staticTrees[t]=this.$options.staticRenderFns[t].call(this._renderProxy),"__static__"+t,!1),n)}function Me(t,e,n){return qe(t,"__once__"+e+(n?"_"+n:""),!0),t}function qe(t,e,n){if(Array.isArray(t))for(var r=0;r<t.length;r++)t[r]&&"string"!=typeof t[r]&&He(t[r],e+"_"+r,n);else He(t,e,n)}function He(t,e,n){t.isStatic=!0,t.key=e,t.isOnce=n}function Be(t,e){if(e)if(l(e)){var n=t.on=t.on?A({},t.on):{};for(var r in e){var i=n[r],o=e[r];n[r]=i?[].concat(o,i):o}}else;return t}var ze=0;function We(t){var e=t.options;if(t.super){var n=We(t.super);if(n!==t.superOptions){t.superOptions=n;var r=function(t){var e,n=t.options,r=t.extendOptions,i=t.sealedOptions;for(var o in n)n[o]!==i[o]&&(e||(e={}),e[o]=Ve(n[o],r[o],i[o]));return e}(t);r&&A(t.extendOptions,r),(e=t.options=St(n,t.extendOptions)).name&&(e.components[e.name]=t)}}return e}function Ve(t,e,n){if(Array.isArray(t)){var r=[];n=Array.isArray(n)?n:[n],e=Array.isArray(e)?e:[e];for(var i=0;i<t.length;i++)(e.indexOf(t[i])>=0||n.indexOf(t[i])<0)&&r.push(t[i]);return r}return t}function Ge(t){this._init(t)}function Xe(t){t.cid=0;var e=1;t.extend=function(t){t=t||{};var n=this,r=n.cid,i=t._Ctor||(t._Ctor={});if(i[r])return i[r];var o=t.name||n.options.name;var s=function(t){this._init(t)};return(s.prototype=Object.create(n.prototype)).constructor=s,s.cid=e++,s.options=St(n.options,t),s.super=n,s.options.props&&function(t){var e=t.options.props;for(var n in e)_e(t.prototype,"_props",n)}(s),s.options.computed&&function(t){var e=t.options.computed;for(var n in e)xe(t.prototype,n,e[n])}(s),s.extend=n.extend,s.mixin=n.mixin,s.use=n.use,P.forEach(function(t){s[t]=n[t]}),o&&(s.options.components[o]=s),s.superOptions=n.options,s.extendOptions=t,s.sealedOptions=A({},s.options),i[r]=s,s}}Ge.prototype._init=function(t){var e=this;e._uid=ze++,e._isVue=!0,t&&t._isComponent?function(t,e){var n=t.$options=Object.create(t.constructor.options);n.parent=e.parent,n.propsData=e.propsData,n._parentVnode=e._parentVnode,n._parentListeners=e._parentListeners,n._renderChildren=e._renderChildren,n._componentTag=e._componentTag,n._parentElm=e._parentElm,n._refElm=e._refElm,e.render&&(n.render=e.render,n.staticRenderFns=e.staticRenderFns)}(e,t):e.$options=St(We(e.constructor),t||{},e),e._renderProxy=e,e._self=e,function(t){var e=t.$options,n=e.parent;if(n&&!e.abstract){for(;n.$options.abstract&&n.$parent;)n=n.$parent;n.$children.push(t)}t.$parent=n,t.$root=n?n.$root:t,t.$children=[],t.$refs={},t._watcher=null,t._inactive=null,t._directInactive=!1,t._isMounted=!1,t._isDestroyed=!1,t._isBeingDestroyed=!1}(e),function(t){t._events=Object.create(null),t._hasHookEvent=!1;var e=t.$options._parentListeners;e&&te(t,e)}(e),function(t){t._vnode=null,t._staticTrees=null;var e=t.$vnode=t.$options._parentVnode,n=e&&e.context;t.$slots=ee(t.$options._renderChildren,n),t.$scopedSlots=F,t._c=function(e,n,r,i){return Ne(t,e,n,r,i,!1)},t.$createElement=function(e,n,r,i){return Ne(t,e,n,r,i,!0)};var r=e&&e.data;bt(t,"$attrs",r&&r.attrs||F,0,!0),bt(t,"$listeners",t.$options._parentListeners||F,0,!0)}(e),ae(e,"beforeCreate"),function(t){var e=Te(t.$options.inject,t);e&&(vt.shouldConvert=!1,Object.keys(e).forEach(function(n){bt(t,n,e[n])}),vt.shouldConvert=!0)}(e),be(e),function(t){var e=t.$options.provide;e&&(t._provided="function"==typeof e?e.call(t):e)}(e),ae(e,"created"),e.$options.el&&e.$mount(e.$options.el)},function(t){var e={get:function(){return this._data}},n={get:function(){return this._props}};Object.defineProperty(t.prototype,"$data",e),Object.defineProperty(t.prototype,"$props",n),t.prototype.$set=wt,t.prototype.$delete=xt,t.prototype.$watch=function(t,e,n){if(l(e))return $e(this,t,e,n);(n=n||{}).user=!0;var r=new ge(this,t,e,n);return n.immediate&&e.call(this,r.value),function(){r.teardown()}}}(Ge),function(t){var e=/^hook:/;t.prototype.$on=function(t,n){if(Array.isArray(t))for(var r=0,i=t.length;r<i;r++)this.$on(t[r],n);else(this._events[t]||(this._events[t]=[])).push(n),e.test(t)&&(this._hasHookEvent=!0);return this},t.prototype.$once=function(t,e){var n=this;function r(){n.$off(t,r),e.apply(n,arguments)}return r.fn=e,n.$on(t,r),n},t.prototype.$off=function(t,e){var n=this;if(!arguments.length)return n._events=Object.create(null),n;if(Array.isArray(t)){for(var r=0,i=t.length;r<i;r++)this.$off(t[r],e);return n}var o=n._events[t];if(!o)return n;if(1===arguments.length)return n._events[t]=null,n;if(e)for(var s,a=o.length;a--;)if((s=o[a])===e||s.fn===e){o.splice(a,1);break}return n},t.prototype.$emit=function(t){var e=this,n=e._events[t];if(n){n=n.length>1?T(n):n;for(var r=T(arguments,1),i=0,o=n.length;i<o;i++)try{n[i].apply(e,r)}catch(n){B(n,e,'event handler for "'+t+'"')}}return e}}(Ge),function(t){t.prototype._update=function(t,e){var n=this;n._isMounted&&ae(n,"beforeUpdate");var r=n.$el,i=n._vnode,o=ie;ie=n,n._vnode=t,i?n.$el=n.__patch__(i,t):(n.$el=n.__patch__(n.$el,t,e,!1,n.$options._parentElm,n.$options._refElm),n.$options._parentElm=n.$options._refElm=null),ie=o,r&&(r.__vue__=null),n.$el&&(n.$el.__vue__=n),n.$vnode&&n.$parent&&n.$vnode===n.$parent._vnode&&(n.$parent.$el=n.$el)},t.prototype.$forceUpdate=function(){this._watcher&&this._watcher.update()},t.prototype.$destroy=function(){var t=this;if(!t._isBeingDestroyed){ae(t,"beforeDestroy"),t._isBeingDestroyed=!0;var e=t.$parent;!e||e._isBeingDestroyed||t.$options.abstract||v(e.$children,t),t._watcher&&t._watcher.teardown();for(var n=t._watchers.length;n--;)t._watchers[n].teardown();t._data.__ob__&&t._data.__ob__.vmCount--,t._isDestroyed=!0,t.__patch__(t._vnode,null),ae(t,"destroyed"),t.$off(),t.$el&&(t.$el.__vue__=null)}}}(Ge),function(t){t.prototype.$nextTick=function(t){return lt(t,this)},t.prototype._render=function(){var t,e=this,n=e.$options,r=n.render,i=n.staticRenderFns,o=n._parentVnode;if(e._isMounted)for(var s in e.$slots){var a=e.$slots[s];a._rendered&&(e.$slots[s]=Ut(a,!0))}e.$scopedSlots=o&&o.data.scopedSlots||F,i&&!e._staticTrees&&(e._staticTrees=[]),e.$vnode=o;try{t=r.call(e._renderProxy,e.$createElement)}catch(n){B(n,e,"render function"),t=e._vnode}return t instanceof It||(t=Rt()),t.parent=o,t},t.prototype._o=Me,t.prototype._n=f,t.prototype._s=c,t.prototype._l=Ie,t.prototype._t=Pe,t.prototype._q=D,t.prototype._i=j,t.prototype._m=Ue,t.prototype._f=Re,t.prototype._k=Le,t.prototype._b=Fe,t.prototype._v=Lt,t.prototype._e=Rt,t.prototype._u=re,t.prototype._g=Be}(Ge);var Ke=[String,RegExp,Array];function Ze(t){return t&&(t.Ctor.options.name||t.tag)}function Je(t,e){return Array.isArray(t)?t.indexOf(e)>-1:"string"==typeof t?t.split(",").indexOf(e)>-1:(n=t,"[object RegExp]"===a.call(n)&&t.test(e));var n}function Qe(t,e,n){for(var r in t){var i=t[r];if(i){var o=Ze(i.componentOptions);o&&!n(o)&&(i!==e&&Ye(i),t[r]=null)}}}function Ye(t){t&&t.componentInstance.$destroy()}var tn={KeepAlive:{name:"keep-alive",abstract:!0,props:{include:Ke,exclude:Ke},created:function(){this.cache=Object.create(null)},destroyed:function(){for(var t in this.cache)Ye(this.cache[t])},watch:{include:function(t){Qe(this.cache,this._vnode,function(e){return Je(t,e)})},exclude:function(t){Qe(this.cache,this._vnode,function(e){return!Je(t,e)})}},render:function(){var t=Jt(this.$slots.default),e=t&&t.componentOptions;if(e){var n=Ze(e);if(n&&(this.include&&!Je(this.include,n)||this.exclude&&Je(this.exclude,n)))return t;var r=null==t.key?e.Ctor.cid+(e.tag?"::"+e.tag:""):t.key;this.cache[r]?t.componentInstance=this.cache[r].componentInstance:this.cache[r]=t,t.data.keepAlive=!0}return t}}};!function(t){var e={get:function(){return L}};Object.defineProperty(t,"config",e),t.util={warn:H,extend:A,mergeOptions:St,defineReactive:bt},t.set=wt,t.delete=xt,t.nextTick=lt,t.options=Object.create(null),P.forEach(function(e){t.options[e+"s"]=Object.create(null)}),t.options._base=t,A(t.options.components,tn),function(t){t.use=function(t){var e=this._installedPlugins||(this._installedPlugins=[]);if(e.indexOf(t)>-1)return this;var n=T(arguments,1);return n.unshift(this),"function"==typeof t.install?t.install.apply(t,n):"function"==typeof t&&t.apply(null,n),e.push(t),this}}(t),function(t){t.mixin=function(t){return this.options=St(this.options,t),this}}(t),Xe(t),function(t){P.forEach(function(e){t[e]=function(t,n){return n?("component"===e&&l(n)&&(n.name=n.name||t,n=this.options._base.extend(n)),"directive"===e&&"function"==typeof n&&(n={bind:n,update:n}),this.options[e+"s"][t]=n,n):this.options[e+"s"][t]}})}(t)}(Ge),Object.defineProperty(Ge.prototype,"$isServer",{get:rt}),Object.defineProperty(Ge.prototype,"$ssrContext",{get:function(){return this.$vnode&&this.$vnode.ssrContext}}),Ge.version="2.4.4";var en=p("style,class"),nn=p("input,textarea,option,select,progress"),rn=function(t,e,n){return"value"===n&&nn(t)&&"button"!==e||"selected"===n&&"option"===t||"checked"===n&&"input"===t||"muted"===n&&"video"===t},on=p("contenteditable,draggable,spellcheck"),sn=p("allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,default,defaultchecked,defaultmuted,defaultselected,defer,disabled,enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,required,reversed,scoped,seamless,selected,sortable,translate,truespeed,typemustmatch,visible"),an="http://www.w3.org/1999/xlink",ln=function(t){return":"===t.charAt(5)&&"xlink"===t.slice(0,5)},un=function(t){return ln(t)?t.slice(6,t.length):""},cn=function(t){return null==t||!1===t};function fn(t){for(var e=t.data,n=t,i=t;r(i.componentInstance);)(i=i.componentInstance._vnode).data&&(e=pn(i.data,e));for(;r(n=n.parent);)n.data&&(e=pn(e,n.data));return function(t,e){if(r(t)||r(e))return dn(t,hn(e));return""}(e.staticClass,e.class)}function pn(t,e){return{staticClass:dn(t.staticClass,e.staticClass),class:r(t.class)?[t.class,e.class]:e.class}}function dn(t,e){return t?e?t+" "+e:t:e||""}function hn(t){return Array.isArray(t)?function(t){for(var e,n="",i=0,o=t.length;i<o;i++)r(e=hn(t[i]))&&""!==e&&(n&&(n+=" "),n+=e);return n}(t):s(t)?function(t){var e="";for(var n in t)t[n]&&(e&&(e+=" "),e+=n);return e}(t):"string"==typeof t?t:""}var vn={svg:"http://www.w3.org/2000/svg",math:"http://www.w3.org/1998/Math/MathML"},gn=p("html,body,base,head,link,meta,style,title,address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,s,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,embed,object,param,source,canvas,script,noscript,del,ins,caption,col,colgroup,table,thead,tbody,td,th,tr,button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,output,progress,select,textarea,details,dialog,menu,menuitem,summary,content,element,shadow,template,blockquote,iframe,tfoot"),mn=p("svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,foreignObject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view",!0),yn=function(t){return gn(t)||mn(t)};function _n(t){return mn(t)?"svg":"math"===t?"math":void 0}var bn=Object.create(null);var wn=p("text,number,password,search,email,tel,url");function xn(t){if("string"==typeof t){var e=document.querySelector(t);return e||document.createElement("div")}return t}var Cn=Object.freeze({createElement:function(t,e){var n=document.createElement(t);return"select"!==t?n:(e.data&&e.data.attrs&&void 0!==e.data.attrs.multiple&&n.setAttribute("multiple","multiple"),n)},createElementNS:function(t,e){return document.createElementNS(vn[t],e)},createTextNode:function(t){return document.createTextNode(t)},createComment:function(t){return document.createComment(t)},insertBefore:function(t,e,n){t.insertBefore(e,n)},removeChild:function(t,e){t.removeChild(e)},appendChild:function(t,e){t.appendChild(e)},parentNode:function(t){return t.parentNode},nextSibling:function(t){return t.nextSibling},tagName:function(t){return t.tagName},setTextContent:function(t,e){t.textContent=e},setAttribute:function(t,e,n){t.setAttribute(e,n)}}),$n={create:function(t,e){Tn(e)},update:function(t,e){t.data.ref!==e.data.ref&&(Tn(t,!0),Tn(e))},destroy:function(t){Tn(t,!0)}};function Tn(t,e){var n=t.data.ref;if(n){var r=t.context,i=t.componentInstance||t.elm,o=r.$refs;e?Array.isArray(o[n])?v(o[n],i):o[n]===i&&(o[n]=void 0):t.data.refInFor?Array.isArray(o[n])?o[n].indexOf(i)<0&&o[n].push(i):o[n]=[i]:o[n]=i}}var An=new It("",{},[]),kn=["create","activate","update","remove","destroy"];function En(t,e){return t.key===e.key&&(t.tag===e.tag&&t.isComment===e.isComment&&r(t.data)===r(e.data)&&function(t,e){if("input"!==t.tag)return!0;var n,i=r(n=t.data)&&r(n=n.attrs)&&n.type,o=r(n=e.data)&&r(n=n.attrs)&&n.type;return i===o||wn(i)&&wn(o)}(t,e)||i(t.isAsyncPlaceholder)&&t.asyncFactory===e.asyncFactory&&n(e.asyncFactory.error))}function Sn(t,e,n){var i,o,s={};for(i=e;i<=n;++i)r(o=t[i].key)&&(s[o]=i);return s}var On={create:Dn,update:Dn,destroy:function(t){Dn(t,An)}};function Dn(t,e){(t.data.directives||e.data.directives)&&function(t,e){var n,r,i,o=t===An,s=e===An,a=Nn(t.data.directives,t.context),l=Nn(e.data.directives,e.context),u=[],c=[];for(n in l)r=a[n],i=l[n],r?(i.oldValue=r.value,Pn(i,"update",e,t),i.def&&i.def.componentUpdated&&c.push(i)):(Pn(i,"bind",e,t),i.def&&i.def.inserted&&u.push(i));if(u.length){var f=function(){for(var n=0;n<u.length;n++)Pn(u[n],"inserted",e,t)};o?Wt(e.data.hook||(e.data.hook={}),"insert",f):f()}c.length&&Wt(e.data.hook||(e.data.hook={}),"postpatch",function(){for(var n=0;n<c.length;n++)Pn(c[n],"componentUpdated",e,t)});if(!o)for(n in a)l[n]||Pn(a[n],"unbind",t,t,s)}(t,e)}var jn=Object.create(null);function Nn(t,e){var n,r,i=Object.create(null);if(!t)return i;for(n=0;n<t.length;n++)(r=t[n]).modifiers||(r.modifiers=jn),i[In(r)]=r,r.def=Ot(e.$options,"directives",r.name);return i}function In(t){return t.rawName||t.name+"."+Object.keys(t.modifiers||{}).join(".")}function Pn(t,e,n,r,i){var o=t.def&&t.def[e];if(o)try{o(n.elm,t,n,r,i)}catch(r){B(r,n.context,"directive "+t.name+" "+e+" hook")}}var Rn=[$n,On];function Ln(t,e){var i=e.componentOptions;if(!(r(i)&&!1===i.Ctor.options.inheritAttrs||n(t.data.attrs)&&n(e.data.attrs))){var o,s,a=e.elm,l=t.data.attrs||{},u=e.data.attrs||{};for(o in r(u.__ob__)&&(u=e.data.attrs=A({},u)),u)s=u[o],l[o]!==s&&Fn(a,o,s);for(o in K&&u.value!==l.value&&Fn(a,"value",u.value),l)n(u[o])&&(ln(o)?a.removeAttributeNS(an,un(o)):on(o)||a.removeAttribute(o))}}function Fn(t,e,n){sn(e)?cn(n)?t.removeAttribute(e):(n="allowfullscreen"===e&&"EMBED"===t.tagName?"true":e,t.setAttribute(e,n)):on(e)?t.setAttribute(e,cn(n)||"false"===n?"false":"true"):ln(e)?cn(n)?t.removeAttributeNS(an,un(e)):t.setAttributeNS(an,e,n):cn(n)?t.removeAttribute(e):t.setAttribute(e,n)}var Un={create:Ln,update:Ln};function Mn(t,e){var i=e.elm,o=e.data,s=t.data;if(!(n(o.staticClass)&&n(o.class)&&(n(s)||n(s.staticClass)&&n(s.class)))){var a=fn(e),l=i._transitionClasses;r(l)&&(a=dn(a,hn(l))),a!==i._prevClass&&(i.setAttribute("class",a),i._prevClass=a)}}var qn,Hn,Bn,zn,Wn,Vn,Gn={create:Mn,update:Mn},Xn=/[\w).+\-_$\]]/;function Kn(t){var e,n,r,i,o,s=!1,a=!1,l=!1,u=!1,c=0,f=0,p=0,d=0;for(r=0;r<t.length;r++)if(n=e,e=t.charCodeAt(r),s)39===e&&92!==n&&(s=!1);else if(a)34===e&&92!==n&&(a=!1);else if(l)96===e&&92!==n&&(l=!1);else if(u)47===e&&92!==n&&(u=!1);else if(124!==e||124===t.charCodeAt(r+1)||124===t.charCodeAt(r-1)||c||f||p){switch(e){case 34:a=!0;break;case 39:s=!0;break;case 96:l=!0;break;case 40:p++;break;case 41:p--;break;case 91:f++;break;case 93:f--;break;case 123:c++;break;case 125:c--}if(47===e){for(var h=r-1,v=void 0;h>=0&&" "===(v=t.charAt(h));h--);v&&Xn.test(v)||(u=!0)}}else void 0===i?(d=r+1,i=t.slice(0,r).trim()):g();function g(){(o||(o=[])).push(t.slice(d,r).trim()),d=r+1}if(void 0===i?i=t.slice(0,r).trim():0!==d&&g(),o)for(r=0;r<o.length;r++)i=Zn(i,o[r]);return i}function Zn(t,e){var n=e.indexOf("(");return n<0?'_f("'+e+'")('+t+")":'_f("'+e.slice(0,n)+'")('+t+","+e.slice(n+1)}function Jn(t){console.error("[Vue compiler]: "+t)}function Qn(t,e){return t?t.map(function(t){return t[e]}).filter(function(t){return t}):[]}function Yn(t,e,n){(t.props||(t.props=[])).push({name:e,value:n})}function tr(t,e,n){(t.attrs||(t.attrs=[])).push({name:e,value:n})}function er(t,e,n,r,i,o){(t.directives||(t.directives=[])).push({name:e,rawName:n,value:r,arg:i,modifiers:o})}function nr(t,e,n,r,i,o){var s;r&&r.capture&&(delete r.capture,e="!"+e),r&&r.once&&(delete r.once,e="~"+e),r&&r.passive&&(delete r.passive,e="&"+e),r&&r.native?(delete r.native,s=t.nativeEvents||(t.nativeEvents={})):s=t.events||(t.events={});var a={value:n,modifiers:r},l=s[e];Array.isArray(l)?i?l.unshift(a):l.push(a):s[e]=l?i?[a,l]:[l,a]:a}function rr(t,e,n){var r=ir(t,":"+e)||ir(t,"v-bind:"+e);if(null!=r)return Kn(r);if(!1!==n){var i=ir(t,e);if(null!=i)return JSON.stringify(i)}}function ir(t,e){var n;if(null!=(n=t.attrsMap[e]))for(var r=t.attrsList,i=0,o=r.length;i<o;i++)if(r[i].name===e){r.splice(i,1);break}return n}function or(t,e,n){var r=n||{},i=r.number,o="$$v";r.trim&&(o="(typeof $$v === 'string'? $$v.trim(): $$v)"),i&&(o="_n("+o+")");var s=sr(e,o);t.model={value:"("+e+")",expression:'"'+e+'"',callback:"function ($$v) {"+s+"}"}}function sr(t,e){var n=function(t){if(qn=(Hn=t).length,zn=Wn=Vn=0,t.indexOf("[")<0||t.lastIndexOf("]")<qn-1)return{exp:t,idx:null};for(;!lr();)ur(Bn=ar())?fr(Bn):91===Bn&&cr(Bn);return{exp:t.substring(0,Wn),idx:t.substring(Wn+1,Vn)}}(t);return null===n.idx?t+"="+e:"$set("+n.exp+", "+n.idx+", "+e+")"}function ar(){return Hn.charCodeAt(++zn)}function lr(){return zn>=qn}function ur(t){return 34===t||39===t}function cr(t){var e=1;for(Wn=zn;!lr();)if(ur(t=ar()))fr(t);else if(91===t&&e++,93===t&&e--,0===e){Vn=zn;break}}function fr(t){for(var e=t;!lr()&&(t=ar())!==e;);}var pr,dr="__r",hr="__c";function vr(t,e,n,r,i){if(n){var o=e,s=pr;e=function(n){null!==(1===arguments.length?o(n):o.apply(null,arguments))&&gr(t,e,r,s)}}pr.addEventListener(t,e,et?{capture:r,passive:i}:r)}function gr(t,e,n,r){(r||pr).removeEventListener(t,e,n)}function mr(t,e){if(!n(t.data.on)||!n(e.data.on)){var i=e.data.on||{},o=t.data.on||{};pr=e.elm,function(t){var e;r(t[dr])&&(t[e=X?"change":"input"]=[].concat(t[dr],t[e]||[]),delete t[dr]),r(t[hr])&&(t[e=Y?"click":"change"]=[].concat(t[hr],t[e]||[]),delete t[hr])}(i),zt(i,o,vr,gr,e.context)}}var yr={create:mr,update:mr};function _r(t,e){if(!n(t.data.domProps)||!n(e.data.domProps)){var i,o,s=e.elm,a=t.data.domProps||{},l=e.data.domProps||{};for(i in r(l.__ob__)&&(l=e.data.domProps=A({},l)),a)n(l[i])&&(s[i]="");for(i in l)if(o=l[i],"textContent"!==i&&"innerHTML"!==i||(e.children&&(e.children.length=0),o!==a[i]))if("value"===i){s._value=o;var u=n(o)?"":String(o);br(s,e,u)&&(s.value=u)}else s[i]=o}}function br(t,e,n){return!t.composing&&("option"===e.tag||function(t,e){var n=!0;try{n=document.activeElement!==t}catch(t){}return n&&t.value!==e}(t,n)||function(t,e){var n=t.value,i=t._vModifiers;if(r(i)&&i.number)return f(n)!==f(e);if(r(i)&&i.trim)return n.trim()!==e.trim();return n!==e}(t,n))}var wr={create:_r,update:_r},xr=y(function(t){var e={},n=/:(.+)/;return t.split(/;(?![^(]*\))/g).forEach(function(t){if(t){var r=t.split(n);r.length>1&&(e[r[0].trim()]=r[1].trim())}}),e});function Cr(t){var e=$r(t.style);return t.staticStyle?A(t.staticStyle,e):e}function $r(t){return Array.isArray(t)?k(t):"string"==typeof t?xr(t):t}var Tr,Ar=/^--/,kr=/\s*!important$/,Er=function(t,e,n){if(Ar.test(e))t.style.setProperty(e,n);else if(kr.test(n))t.style.setProperty(e,n.replace(kr,""),"important");else{var r=Or(e);if(Array.isArray(n))for(var i=0,o=n.length;i<o;i++)t.style[r]=n[i];else t.style[r]=n}},Sr=["Webkit","Moz","ms"],Or=y(function(t){if(Tr=Tr||document.createElement("div").style,"filter"!==(t=b(t))&&t in Tr)return t;for(var e=t.charAt(0).toUpperCase()+t.slice(1),n=0;n<Sr.length;n++){var r=Sr[n]+e;if(r in Tr)return r}});function Dr(t,e){var i=e.data,o=t.data;if(!(n(i.staticStyle)&&n(i.style)&&n(o.staticStyle)&&n(o.style))){var s,a,l=e.elm,u=o.staticStyle,c=o.normalizedStyle||o.style||{},f=u||c,p=$r(e.data.style)||{};e.data.normalizedStyle=r(p.__ob__)?A({},p):p;var d=function(t,e){var n,r={};if(e)for(var i=t;i.componentInstance;)(i=i.componentInstance._vnode).data&&(n=Cr(i.data))&&A(r,n);(n=Cr(t.data))&&A(r,n);for(var o=t;o=o.parent;)o.data&&(n=Cr(o.data))&&A(r,n);return r}(e,!0);for(a in f)n(d[a])&&Er(l,a,"");for(a in d)(s=d[a])!==f[a]&&Er(l,a,null==s?"":s)}}var jr={create:Dr,update:Dr};function Nr(t,e){if(e&&(e=e.trim()))if(t.classList)e.indexOf(" ")>-1?e.split(/\s+/).forEach(function(e){return t.classList.add(e)}):t.classList.add(e);else{var n=" "+(t.getAttribute("class")||"")+" ";n.indexOf(" "+e+" ")<0&&t.setAttribute("class",(n+e).trim())}}function Ir(t,e){if(e&&(e=e.trim()))if(t.classList)e.indexOf(" ")>-1?e.split(/\s+/).forEach(function(e){return t.classList.remove(e)}):t.classList.remove(e),t.classList.length||t.removeAttribute("class");else{for(var n=" "+(t.getAttribute("class")||"")+" ",r=" "+e+" ";n.indexOf(r)>=0;)n=n.replace(r," ");(n=n.trim())?t.setAttribute("class",n):t.removeAttribute("class")}}function Pr(t){if(t){if("object"==typeof t){var e={};return!1!==t.css&&A(e,Rr(t.name||"v")),A(e,t),e}return"string"==typeof t?Rr(t):void 0}}var Rr=y(function(t){return{enterClass:t+"-enter",enterToClass:t+"-enter-to",enterActiveClass:t+"-enter-active",leaveClass:t+"-leave",leaveToClass:t+"-leave-to",leaveActiveClass:t+"-leave-active"}}),Lr=V&&!K,Fr="transition",Ur="animation",Mr="transition",qr="transitionend",Hr="animation",Br="animationend";Lr&&(void 0===window.ontransitionend&&void 0!==window.onwebkittransitionend&&(Mr="WebkitTransition",qr="webkitTransitionEnd"),void 0===window.onanimationend&&void 0!==window.onwebkitanimationend&&(Hr="WebkitAnimation",Br="webkitAnimationEnd"));var zr=V&&window.requestAnimationFrame?window.requestAnimationFrame.bind(window):setTimeout;function Wr(t){zr(function(){zr(t)})}function Vr(t,e){var n=t._transitionClasses||(t._transitionClasses=[]);n.indexOf(e)<0&&(n.push(e),Nr(t,e))}function Gr(t,e){t._transitionClasses&&v(t._transitionClasses,e),Ir(t,e)}function Xr(t,e,n){var r=Zr(t,e),i=r.type,o=r.timeout,s=r.propCount;if(!i)return n();var a=i===Fr?qr:Br,l=0,u=function(){t.removeEventListener(a,c),n()},c=function(e){e.target===t&&++l>=s&&u()};setTimeout(function(){l<s&&u()},o+1),t.addEventListener(a,c)}var Kr=/\b(transform|all)(,|$)/;function Zr(t,e){var n,r=window.getComputedStyle(t),i=r[Mr+"Delay"].split(", "),o=r[Mr+"Duration"].split(", "),s=Jr(i,o),a=r[Hr+"Delay"].split(", "),l=r[Hr+"Duration"].split(", "),u=Jr(a,l),c=0,f=0;return e===Fr?s>0&&(n=Fr,c=s,f=o.length):e===Ur?u>0&&(n=Ur,c=u,f=l.length):f=(n=(c=Math.max(s,u))>0?s>u?Fr:Ur:null)?n===Fr?o.length:l.length:0,{type:n,timeout:c,propCount:f,hasTransform:n===Fr&&Kr.test(r[Mr+"Property"])}}function Jr(t,e){for(;t.length<e.length;)t=t.concat(t);return Math.max.apply(null,e.map(function(e,n){return Qr(e)+Qr(t[n])}))}function Qr(t){return 1e3*Number(t.slice(0,-1))}function Yr(t,e){var i=t.elm;r(i._leaveCb)&&(i._leaveCb.cancelled=!0,i._leaveCb());var o=Pr(t.data.transition);if(!n(o)&&!r(i._enterCb)&&1===i.nodeType){for(var a=o.css,l=o.type,u=o.enterClass,c=o.enterToClass,p=o.enterActiveClass,d=o.appearClass,h=o.appearToClass,v=o.appearActiveClass,g=o.beforeEnter,m=o.enter,y=o.afterEnter,_=o.enterCancelled,b=o.beforeAppear,w=o.appear,x=o.afterAppear,C=o.appearCancelled,$=o.duration,T=ie,A=ie.$vnode;A&&A.parent;)T=(A=A.parent).context;var k=!T._isMounted||!t.isRootInsert;if(!k||w||""===w){var E=k&&d?d:u,S=k&&v?v:p,O=k&&h?h:c,D=k&&b||g,j=k&&"function"==typeof w?w:m,I=k&&x||y,P=k&&C||_,R=f(s($)?$.enter:$);0;var L=!1!==a&&!K,F=ni(j),U=i._enterCb=N(function(){L&&(Gr(i,O),Gr(i,S)),U.cancelled?(L&&Gr(i,E),P&&P(i)):I&&I(i),i._enterCb=null});t.data.show||Wt(t.data.hook||(t.data.hook={}),"insert",function(){var e=i.parentNode,n=e&&e._pending&&e._pending[t.key];n&&n.tag===t.tag&&n.elm._leaveCb&&n.elm._leaveCb(),j&&j(i,U)}),D&&D(i),L&&(Vr(i,E),Vr(i,S),Wr(function(){Vr(i,O),Gr(i,E),U.cancelled||F||(ei(R)?setTimeout(U,R):Xr(i,l,U))})),t.data.show&&(e&&e(),j&&j(i,U)),L||F||U()}}}function ti(t,e){var i=t.elm;r(i._enterCb)&&(i._enterCb.cancelled=!0,i._enterCb());var o=Pr(t.data.transition);if(n(o))return e();if(!r(i._leaveCb)&&1===i.nodeType){var a=o.css,l=o.type,u=o.leaveClass,c=o.leaveToClass,p=o.leaveActiveClass,d=o.beforeLeave,h=o.leave,v=o.afterLeave,g=o.leaveCancelled,m=o.delayLeave,y=o.duration,_=!1!==a&&!K,b=ni(h),w=f(s(y)?y.leave:y);0;var x=i._leaveCb=N(function(){i.parentNode&&i.parentNode._pending&&(i.parentNode._pending[t.key]=null),_&&(Gr(i,c),Gr(i,p)),x.cancelled?(_&&Gr(i,u),g&&g(i)):(e(),v&&v(i)),i._leaveCb=null});m?m(C):C()}function C(){x.cancelled||(t.data.show||((i.parentNode._pending||(i.parentNode._pending={}))[t.key]=t),d&&d(i),_&&(Vr(i,u),Vr(i,p),Wr(function(){Vr(i,c),Gr(i,u),x.cancelled||b||(ei(w)?setTimeout(x,w):Xr(i,l,x))})),h&&h(i,x),_||b||x())}}function ei(t){return"number"==typeof t&&!isNaN(t)}function ni(t){if(n(t))return!1;var e=t.fns;return r(e)?ni(Array.isArray(e)?e[0]:e):(t._length||t.length)>1}function ri(t,e){!0!==e.data.show&&Yr(e)}var ii=function(t){var e,s,a={},l=t.modules,u=t.nodeOps;for(e=0;e<kn.length;++e)for(a[kn[e]]=[],s=0;s<l.length;++s)r(l[s][kn[e]])&&a[kn[e]].push(l[s][kn[e]]);function c(t){var e=u.parentNode(t);r(e)&&u.removeChild(e,t)}function f(t,e,n,o,s){if(t.isRootInsert=!s,!function(t,e,n,o){var s=t.data;if(r(s)){var l=r(t.componentInstance)&&s.keepAlive;if(r(s=s.hook)&&r(s=s.init)&&s(t,!1,n,o),r(t.componentInstance))return d(t,e),i(l)&&function(t,e,n,i){for(var o,s=t;s.componentInstance;)if(s=s.componentInstance._vnode,r(o=s.data)&&r(o=o.transition)){for(o=0;o<a.activate.length;++o)a.activate[o](An,s);e.push(s);break}h(n,t.elm,i)}(t,e,n,o),!0}}(t,e,n,o)){var l=t.data,c=t.children,f=t.tag;r(f)?(t.elm=t.ns?u.createElementNS(t.ns,f):u.createElement(f,t),y(t),v(t,c,e),r(l)&&m(t,e),h(n,t.elm,o)):i(t.isComment)?(t.elm=u.createComment(t.text),h(n,t.elm,o)):(t.elm=u.createTextNode(t.text),h(n,t.elm,o))}}function d(t,e){r(t.data.pendingInsert)&&(e.push.apply(e,t.data.pendingInsert),t.data.pendingInsert=null),t.elm=t.componentInstance.$el,g(t)?(m(t,e),y(t)):(Tn(t),e.push(t))}function h(t,e,n){r(t)&&(r(n)?n.parentNode===t&&u.insertBefore(t,e,n):u.appendChild(t,e))}function v(t,e,n){if(Array.isArray(e))for(var r=0;r<e.length;++r)f(e[r],n,t.elm,null,!0);else o(t.text)&&u.appendChild(t.elm,u.createTextNode(t.text))}function g(t){for(;t.componentInstance;)t=t.componentInstance._vnode;return r(t.tag)}function m(t,n){for(var i=0;i<a.create.length;++i)a.create[i](An,t);r(e=t.data.hook)&&(r(e.create)&&e.create(An,t),r(e.insert)&&n.push(t))}function y(t){for(var e,n=t;n;)r(e=n.context)&&r(e=e.$options._scopeId)&&u.setAttribute(t.elm,e,""),n=n.parent;r(e=ie)&&e!==t.context&&r(e=e.$options._scopeId)&&u.setAttribute(t.elm,e,"")}function _(t,e,n,r,i,o){for(;r<=i;++r)f(n[r],o,t,e)}function b(t){var e,n,i=t.data;if(r(i))for(r(e=i.hook)&&r(e=e.destroy)&&e(t),e=0;e<a.destroy.length;++e)a.destroy[e](t);if(r(e=t.children))for(n=0;n<t.children.length;++n)b(t.children[n])}function w(t,e,n,i){for(;n<=i;++n){var o=e[n];r(o)&&(r(o.tag)?(x(o),b(o)):c(o.elm))}}function x(t,e){if(r(e)||r(t.data)){var n,i=a.remove.length+1;for(r(e)?e.listeners+=i:e=function(t,e){function n(){0==--n.listeners&&c(t)}return n.listeners=e,n}(t.elm,i),r(n=t.componentInstance)&&r(n=n._vnode)&&r(n.data)&&x(n,e),n=0;n<a.remove.length;++n)a.remove[n](t,e);r(n=t.data.hook)&&r(n=n.remove)?n(t,e):e()}else c(t.elm)}function C(t,e,n,i){for(var o=n;o<i;o++){var s=e[o];if(r(s)&&En(t,s))return o}}function $(t,e,o,s){if(t!==e){var l=e.elm=t.elm;if(i(t.isAsyncPlaceholder))r(e.asyncFactory.resolved)?k(t.elm,e,o):e.isAsyncPlaceholder=!0;else if(i(e.isStatic)&&i(t.isStatic)&&e.key===t.key&&(i(e.isCloned)||i(e.isOnce)))e.componentInstance=t.componentInstance;else{var c,p=e.data;r(p)&&r(c=p.hook)&&r(c=c.prepatch)&&c(t,e);var d=t.children,h=e.children;if(r(p)&&g(e)){for(c=0;c<a.update.length;++c)a.update[c](t,e);r(c=p.hook)&&r(c=c.update)&&c(t,e)}n(e.text)?r(d)&&r(h)?d!==h&&function(t,e,i,o,s){for(var a,l,c,p=0,d=0,h=e.length-1,v=e[0],g=e[h],m=i.length-1,y=i[0],b=i[m],x=!s;p<=h&&d<=m;)n(v)?v=e[++p]:n(g)?g=e[--h]:En(v,y)?($(v,y,o),v=e[++p],y=i[++d]):En(g,b)?($(g,b,o),g=e[--h],b=i[--m]):En(v,b)?($(v,b,o),x&&u.insertBefore(t,v.elm,u.nextSibling(g.elm)),v=e[++p],b=i[--m]):En(g,y)?($(g,y,o),x&&u.insertBefore(t,g.elm,v.elm),g=e[--h],y=i[++d]):(n(a)&&(a=Sn(e,p,h)),n(l=r(y.key)?a[y.key]:C(y,e,p,h))?f(y,o,t,v.elm):En(c=e[l],y)?($(c,y,o),e[l]=void 0,x&&u.insertBefore(t,c.elm,v.elm)):f(y,o,t,v.elm),y=i[++d]);p>h?_(t,n(i[m+1])?null:i[m+1].elm,i,d,m,o):d>m&&w(0,e,p,h)}(l,d,h,o,s):r(h)?(r(t.text)&&u.setTextContent(l,""),_(l,null,h,0,h.length-1,o)):r(d)?w(0,d,0,d.length-1):r(t.text)&&u.setTextContent(l,""):t.text!==e.text&&u.setTextContent(l,e.text),r(p)&&r(c=p.hook)&&r(c=c.postpatch)&&c(t,e)}}}function T(t,e,n){if(i(n)&&r(t.parent))t.parent.data.pendingInsert=e;else for(var o=0;o<e.length;++o)e[o].data.hook.insert(e[o])}var A=p("attrs,style,class,staticClass,staticStyle,key");function k(t,n,o){if(i(n.isComment)&&r(n.asyncFactory))return n.elm=t,n.isAsyncPlaceholder=!0,!0;n.elm=t;var s=n.tag,a=n.data,l=n.children;if(r(a)&&(r(e=a.hook)&&r(e=e.init)&&e(n,!0),r(e=n.componentInstance)))return d(n,o),!0;if(r(s)){if(r(l))if(t.hasChildNodes())if(r(e=a)&&r(e=e.domProps)&&r(e=e.innerHTML)){if(e!==t.innerHTML)return!1}else{for(var u=!0,c=t.firstChild,f=0;f<l.length;f++){if(!c||!k(c,l[f],o)){u=!1;break}c=c.nextSibling}if(!u||c)return!1}else v(n,l,o);if(r(a))for(var p in a)if(!A(p)){m(n,o);break}}else t.data!==n.text&&(t.data=n.text);return!0}return function(t,e,o,s,l,c){if(!n(e)){var p,d=!1,h=[];if(n(t))d=!0,f(e,h,l,c);else{var v=r(t.nodeType);if(!v&&En(t,e))$(t,e,h,s);else{if(v){if(1===t.nodeType&&t.hasAttribute(I)&&(t.removeAttribute(I),o=!0),i(o)&&k(t,e,h))return T(e,h,!0),t;p=t,t=new It(u.tagName(p).toLowerCase(),{},[],void 0,p)}var m=t.elm,y=u.parentNode(m);if(f(e,h,m._leaveCb?null:y,u.nextSibling(m)),r(e.parent))for(var _=e.parent,x=g(e);_;){for(var C=0;C<a.destroy.length;++C)a.destroy[C](_);if(_.elm=e.elm,x){for(var A=0;A<a.create.length;++A)a.create[A](An,_);var E=_.data.hook.insert;if(E.merged)for(var S=1;S<E.fns.length;S++)E.fns[S]()}_=_.parent}r(y)?w(0,[t],0,0):r(t.tag)&&b(t)}}return T(e,h,d),e.elm}r(t)&&b(t)}}({nodeOps:Cn,modules:[Un,Gn,yr,wr,jr,V?{create:ri,activate:ri,remove:function(t,e){!0!==t.data.show?ti(t,e):e()}}:{}].concat(Rn)});function oi(t,e,n){si(t,e,n),(X||Z)&&setTimeout(function(){si(t,e,n)},0)}function si(t,e,n){var r=e.value,i=t.multiple;if(!i||Array.isArray(r)){for(var o,s,a=0,l=t.options.length;a<l;a++)if(s=t.options[a],i)o=j(r,li(s))>-1,s.selected!==o&&(s.selected=o);else if(D(li(s),r))return void(t.selectedIndex!==a&&(t.selectedIndex=a));i||(t.selectedIndex=-1)}}function ai(t,e){return e.every(function(e){return!D(e,t)})}function li(t){return"_value"in t?t._value:t.value}function ui(t){t.target.composing=!0}function ci(t){t.target.composing&&(t.target.composing=!1,fi(t.target,"input"))}function fi(t,e){var n=document.createEvent("HTMLEvents");n.initEvent(e,!0,!0),t.dispatchEvent(n)}function pi(t){return!t.componentInstance||t.data&&t.data.transition?t:pi(t.componentInstance._vnode)}K&&document.addEventListener("selectionchange",function(){var t=document.activeElement;t&&t.vmodel&&fi(t,"input")});var di={model:{inserted:function(t,e,n){"select"===n.tag?(oi(t,e,n.context),t._vOptions=[].map.call(t.options,li)):("textarea"===n.tag||wn(t.type))&&(t._vModifiers=e.modifiers,e.modifiers.lazy||(t.addEventListener("change",ci),J||(t.addEventListener("compositionstart",ui),t.addEventListener("compositionend",ci)),K&&(t.vmodel=!0)))},componentUpdated:function(t,e,n){if("select"===n.tag){oi(t,e,n.context);var r=t._vOptions,i=t._vOptions=[].map.call(t.options,li);if(i.some(function(t,e){return!D(t,r[e])}))(t.multiple?e.value.some(function(t){return ai(t,i)}):e.value!==e.oldValue&&ai(e.value,i))&&fi(t,"change")}}},show:{bind:function(t,e,n){var r=e.value,i=(n=pi(n)).data&&n.data.transition,o=t.__vOriginalDisplay="none"===t.style.display?"":t.style.display;r&&i?(n.data.show=!0,Yr(n,function(){t.style.display=o})):t.style.display=r?o:"none"},update:function(t,e,n){var r=e.value;r!==e.oldValue&&((n=pi(n)).data&&n.data.transition?(n.data.show=!0,r?Yr(n,function(){t.style.display=t.__vOriginalDisplay}):ti(n,function(){t.style.display="none"})):t.style.display=r?t.__vOriginalDisplay:"none")},unbind:function(t,e,n,r,i){i||(t.style.display=t.__vOriginalDisplay)}}},hi={name:String,appear:Boolean,css:Boolean,mode:String,type:String,enterClass:String,leaveClass:String,enterToClass:String,leaveToClass:String,enterActiveClass:String,leaveActiveClass:String,appearClass:String,appearActiveClass:String,appearToClass:String,duration:[Number,String,Object]};function vi(t){var e=t&&t.componentOptions;return e&&e.Ctor.options.abstract?vi(Jt(e.children)):t}function gi(t){var e={},n=t.$options;for(var r in n.propsData)e[r]=t[r];var i=n._parentListeners;for(var o in i)e[b(o)]=i[o];return e}function mi(t,e){if(/\d-keep-alive$/.test(e.tag))return t("keep-alive",{props:e.componentOptions.propsData})}var yi={name:"transition",props:hi,abstract:!0,render:function(t){var e=this,n=this.$options._renderChildren;if(n&&(n=n.filter(function(t){return t.tag||Zt(t)})).length){0;var r=this.mode;0;var i=n[0];if(function(t){for(;t=t.parent;)if(t.data.transition)return!0}(this.$vnode))return i;var s=vi(i);if(!s)return i;if(this._leaving)return mi(t,i);var a="__transition-"+this._uid+"-";s.key=null==s.key?s.isComment?a+"comment":a+s.tag:o(s.key)?0===String(s.key).indexOf(a)?s.key:a+s.key:s.key;var l=(s.data||(s.data={})).transition=gi(this),u=this._vnode,c=vi(u);if(s.data.directives&&s.data.directives.some(function(t){return"show"===t.name})&&(s.data.show=!0),c&&c.data&&!function(t,e){return e.key===t.key&&e.tag===t.tag}(s,c)&&!Zt(c)){var f=c&&(c.data.transition=A({},l));if("out-in"===r)return this._leaving=!0,Wt(f,"afterLeave",function(){e._leaving=!1,e.$forceUpdate()}),mi(t,i);if("in-out"===r){if(Zt(s))return u;var p,d=function(){p()};Wt(l,"afterEnter",d),Wt(l,"enterCancelled",d),Wt(f,"delayLeave",function(t){p=t})}}return i}}},_i=A({tag:String,moveClass:String},hi);function bi(t){t.elm._moveCb&&t.elm._moveCb(),t.elm._enterCb&&t.elm._enterCb()}function wi(t){t.data.newPos=t.elm.getBoundingClientRect()}function xi(t){var e=t.data.pos,n=t.data.newPos,r=e.left-n.left,i=e.top-n.top;if(r||i){t.data.moved=!0;var o=t.elm.style;o.transform=o.WebkitTransform="translate("+r+"px,"+i+"px)",o.transitionDuration="0s"}}delete _i.mode;var Ci={Transition:yi,TransitionGroup:{props:_i,render:function(t){for(var e=this.tag||this.$vnode.data.tag||"span",n=Object.create(null),r=this.prevChildren=this.children,i=this.$slots.default||[],o=this.children=[],s=gi(this),a=0;a<i.length;a++){var l=i[a];if(l.tag)if(null!=l.key&&0!==String(l.key).indexOf("__vlist"))o.push(l),n[l.key]=l,(l.data||(l.data={})).transition=s;else;}if(r){for(var u=[],c=[],f=0;f<r.length;f++){var p=r[f];p.data.transition=s,p.data.pos=p.elm.getBoundingClientRect(),n[p.key]?u.push(p):c.push(p)}this.kept=t(e,null,u),this.removed=c}return t(e,null,o)},beforeUpdate:function(){this.__patch__(this._vnode,this.kept,!1,!0),this._vnode=this.kept},updated:function(){var t=this.prevChildren,e=this.moveClass||(this.name||"v")+"-move";if(t.length&&this.hasMove(t[0].elm,e)){t.forEach(bi),t.forEach(wi),t.forEach(xi);document.body.offsetHeight;t.forEach(function(t){if(t.data.moved){var n=t.elm,r=n.style;Vr(n,e),r.transform=r.WebkitTransform=r.transitionDuration="",n.addEventListener(qr,n._moveCb=function t(r){r&&!/transform$/.test(r.propertyName)||(n.removeEventListener(qr,t),n._moveCb=null,Gr(n,e))})}})}},methods:{hasMove:function(t,e){if(!Lr)return!1;if(this._hasMove)return this._hasMove;var n=t.cloneNode();t._transitionClasses&&t._transitionClasses.forEach(function(t){Ir(n,t)}),Nr(n,e),n.style.display="none",this.$el.appendChild(n);var r=Zr(n);return this.$el.removeChild(n),this._hasMove=r.hasTransform}}}};Ge.config.mustUseProp=rn,Ge.config.isReservedTag=yn,Ge.config.isReservedAttr=en,Ge.config.getTagNamespace=_n,Ge.config.isUnknownElement=function(t){if(!V)return!0;if(yn(t))return!1;if(t=t.toLowerCase(),null!=bn[t])return bn[t];var e=document.createElement(t);return t.indexOf("-")>-1?bn[t]=e.constructor===window.HTMLUnknownElement||e.constructor===window.HTMLElement:bn[t]=/HTMLUnknownElement/.test(e.toString())},A(Ge.options.directives,di),A(Ge.options.components,Ci),Ge.prototype.__patch__=V?ii:E,Ge.prototype.$mount=function(t,e){return function(t,e,n){var r;return t.$el=e,t.$options.render||(t.$options.render=Rt),ae(t,"beforeMount"),r=function(){t._update(t._render(),n)},t._watcher=new ge(t,r,E),n=!1,null==t.$vnode&&(t._isMounted=!0,ae(t,"mounted")),t}(this,t=t&&V?xn(t):void 0,e)},setTimeout(function(){L.devtools&&it&&it.emit("init",Ge)},0);var $i,Ti,Ai,ki=!!V&&($i="\n",Ti="&#10;",(Ai=document.createElement("div")).innerHTML='<div a="'+$i+'"/>',Ai.innerHTML.indexOf(Ti)>0),Ei=/\{\{((?:.|\n)+?)\}\}/g,Si=/[-.*+?^${}()|[\]\/\\]/g,Oi=y(function(t){var e=t[0].replace(Si,"\\$&"),n=t[1].replace(Si,"\\$&");return new RegExp(e+"((?:.|\\n)+?)"+n,"g")});function Di(t,e){var n=e?Oi(e):Ei;if(n.test(t)){for(var r,i,o=[],s=n.lastIndex=0;r=n.exec(t);){(i=r.index)>s&&o.push(JSON.stringify(t.slice(s,i)));var a=Kn(r[1].trim());o.push("_s("+a+")"),s=i+r[0].length}return s<t.length&&o.push(JSON.stringify(t.slice(s))),o.join("+")}}var ji=[{staticKeys:["staticClass"],transformNode:function(t,e){e.warn;var n=ir(t,"class");n&&(t.staticClass=JSON.stringify(n));var r=rr(t,"class",!1);r&&(t.classBinding=r)},genData:function(t){var e="";return t.staticClass&&(e+="staticClass:"+t.staticClass+","),t.classBinding&&(e+="class:"+t.classBinding+","),e}},{staticKeys:["staticStyle"],transformNode:function(t,e){e.warn;var n=ir(t,"style");n&&(t.staticStyle=JSON.stringify(xr(n)));var r=rr(t,"style",!1);r&&(t.styleBinding=r)},genData:function(t){var e="";return t.staticStyle&&(e+="staticStyle:"+t.staticStyle+","),t.styleBinding&&(e+="style:("+t.styleBinding+"),"),e}}];var Ni,Ii={model:function(t,e,n){n;var r=e.value,i=e.modifiers,o=t.tag,s=t.attrsMap.type;if(t.component)return or(t,r,i),!1;if("select"===o)!function(t,e,n){var r='var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return '+(n&&n.number?"_n(val)":"val")+"});";r=r+" "+sr(e,"$event.target.multiple ? $$selectedVal : $$selectedVal[0]"),nr(t,"change",r,null,!0)}(t,r,i);else if("input"===o&&"checkbox"===s)!function(t,e,n){var r=n&&n.number,i=rr(t,"value")||"null",o=rr(t,"true-value")||"true",s=rr(t,"false-value")||"false";Yn(t,"checked","Array.isArray("+e+")?_i("+e+","+i+")>-1"+("true"===o?":("+e+")":":_q("+e+","+o+")")),nr(t,hr,"var $$a="+e+",$$el=$event.target,$$c=$$el.checked?("+o+"):("+s+");if(Array.isArray($$a)){var $$v="+(r?"_n("+i+")":i)+",$$i=_i($$a,$$v);if($$el.checked){$$i<0&&("+e+"=$$a.concat([$$v]))}else{$$i>-1&&("+e+"=$$a.slice(0,$$i).concat($$a.slice($$i+1)))}}else{"+sr(e,"$$c")+"}",null,!0)}(t,r,i);else if("input"===o&&"radio"===s)!function(t,e,n){var r=n&&n.number,i=rr(t,"value")||"null";Yn(t,"checked","_q("+e+","+(i=r?"_n("+i+")":i)+")"),nr(t,hr,sr(e,i),null,!0)}(t,r,i);else if("input"===o||"textarea"===o)!function(t,e,n){var r=t.attrsMap.type,i=n||{},o=i.lazy,s=i.number,a=i.trim,l=!o&&"range"!==r,u=o?"change":"range"===r?dr:"input",c="$event.target.value";a&&(c="$event.target.value.trim()"),s&&(c="_n("+c+")");var f=sr(e,c);l&&(f="if($event.target.composing)return;"+f),Yn(t,"value","("+e+")"),nr(t,u,f,null,!0),(a||s)&&nr(t,"blur","$forceUpdate()")}(t,r,i);else if(!L.isReservedTag(o))return or(t,r,i),!1;return!0},text:function(t,e){e.value&&Yn(t,"textContent","_s("+e.value+")")},html:function(t,e){e.value&&Yn(t,"innerHTML","_s("+e.value+")")}},Pi=p("area,base,br,col,embed,frame,hr,img,input,isindex,keygen,link,meta,param,source,track,wbr"),Ri=p("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source"),Li=p("address,article,aside,base,blockquote,body,caption,col,colgroup,dd,details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,title,tr,track"),Fi={expectHTML:!0,modules:ji,directives:Ii,isPreTag:function(t){return"pre"===t},isUnaryTag:Pi,mustUseProp:rn,canBeLeftOpenTag:Ri,isReservedTag:yn,getTagNamespace:_n,staticKeys:function(t){return t.reduce(function(t,e){return t.concat(e.staticKeys||[])},[]).join(",")}(ji)},Ui=function(t){return(Ni=Ni||document.createElement("div")).innerHTML=t,Ni.textContent},Mi=/^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/,qi="[a-zA-Z_][\\w\\-\\.]*",Hi="((?:"+qi+"\\:)?"+qi+")",Bi=new RegExp("^<"+Hi),zi=/^\s*(\/?)>/,Wi=new RegExp("^<\\/"+Hi+"[^>]*>"),Vi=/^<!DOCTYPE [^>]+>/i,Gi=/^<!--/,Xi=/^<!\[/,Ki=!1;"x".replace(/x(.)?/g,function(t,e){Ki=""===e});var Zi=p("script,style,textarea",!0),Ji={},Qi={"&lt;":"<","&gt;":">","&quot;":'"',"&amp;":"&","&#10;":"\n"},Yi=/&(?:lt|gt|quot|amp);/g,to=/&(?:lt|gt|quot|amp|#10);/g,eo=p("pre,textarea",!0),no=function(t,e){return t&&eo(t)&&"\n"===e[0]};function ro(t,e){var n=e?to:Yi;return t.replace(n,function(t){return Qi[t]})}var io,oo,so,ao,lo,uo,co,fo,po=/^@|^v-on:/,ho=/^v-|^@|^:/,vo=/(.*?)\s+(?:in|of)\s+(.*)/,go=/\((\{[^}]*\}|[^,]*),([^,]*)(?:,([^,]*))?\)/,mo=/:(.*)$/,yo=/^:|^v-bind:/,_o=/\.[^.]+/g,bo=y(Ui);function wo(t,e){io=e.warn||Jn,uo=e.isPreTag||S,co=e.mustUseProp||S,fo=e.getTagNamespace||S,so=Qn(e.modules,"transformNode"),ao=Qn(e.modules,"preTransformNode"),lo=Qn(e.modules,"postTransformNode"),oo=e.delimiters;var n,r,i=[],o=!1!==e.preserveWhitespace,s=!1,a=!1;function l(t){t.pre&&(s=!1),uo(t.tag)&&(a=!1)}return function(t,e){for(var n,r,i=[],o=e.expectHTML,s=e.isUnaryTag||S,a=e.canBeLeftOpenTag||S,l=0;t;){if(n=t,r&&Zi(r)){var u=0,c=r.toLowerCase(),f=Ji[c]||(Ji[c]=new RegExp("([\\s\\S]*?)(</"+c+"[^>]*>)","i")),p=t.replace(f,function(t,n,r){return u=r.length,Zi(c)||"noscript"===c||(n=n.replace(/<!--([\s\S]*?)-->/g,"$1").replace(/<!\[CDATA\[([\s\S]*?)]]>/g,"$1")),no(c,n)&&(n=n.slice(1)),e.chars&&e.chars(n),""});l+=t.length-p.length,t=p,A(c,l-u,l)}else{var d=t.indexOf("<");if(0===d){if(Gi.test(t)){var h=t.indexOf("--\x3e");if(h>=0){e.shouldKeepComment&&e.comment(t.substring(4,h)),C(h+3);continue}}if(Xi.test(t)){var v=t.indexOf("]>");if(v>=0){C(v+2);continue}}var g=t.match(Vi);if(g){C(g[0].length);continue}var m=t.match(Wi);if(m){var y=l;C(m[0].length),A(m[1],y,l);continue}var _=$();if(_){T(_),no(r,t)&&C(1);continue}}var b=void 0,w=void 0,x=void 0;if(d>=0){for(w=t.slice(d);!(Wi.test(w)||Bi.test(w)||Gi.test(w)||Xi.test(w)||(x=w.indexOf("<",1))<0);)d+=x,w=t.slice(d);b=t.substring(0,d),C(d)}d<0&&(b=t,t=""),e.chars&&b&&e.chars(b)}if(t===n){e.chars&&e.chars(t);break}}function C(e){l+=e,t=t.substring(e)}function $(){var e=t.match(Bi);if(e){var n,r,i={tagName:e[1],attrs:[],start:l};for(C(e[0].length);!(n=t.match(zi))&&(r=t.match(Mi));)C(r[0].length),i.attrs.push(r);if(n)return i.unarySlash=n[1],C(n[0].length),i.end=l,i}}function T(t){var n=t.tagName,l=t.unarySlash;o&&("p"===r&&Li(n)&&A(r),a(n)&&r===n&&A(n));for(var u=s(n)||!!l,c=t.attrs.length,f=new Array(c),p=0;p<c;p++){var d=t.attrs[p];Ki&&-1===d[0].indexOf('""')&&(""===d[3]&&delete d[3],""===d[4]&&delete d[4],""===d[5]&&delete d[5]);var h=d[3]||d[4]||d[5]||"";f[p]={name:d[1],value:ro(h,e.shouldDecodeNewlines)}}u||(i.push({tag:n,lowerCasedTag:n.toLowerCase(),attrs:f}),r=n),e.start&&e.start(n,f,u,t.start,t.end)}function A(t,n,o){var s,a;if(null==n&&(n=l),null==o&&(o=l),t&&(a=t.toLowerCase()),t)for(s=i.length-1;s>=0&&i[s].lowerCasedTag!==a;s--);else s=0;if(s>=0){for(var u=i.length-1;u>=s;u--)e.end&&e.end(i[u].tag,n,o);i.length=s,r=s&&i[s-1].tag}else"br"===a?e.start&&e.start(t,[],!0,n,o):"p"===a&&(e.start&&e.start(t,[],!1,n,o),e.end&&e.end(t,n,o))}A()}(t,{warn:io,expectHTML:e.expectHTML,isUnaryTag:e.isUnaryTag,canBeLeftOpenTag:e.canBeLeftOpenTag,shouldDecodeNewlines:e.shouldDecodeNewlines,shouldKeepComment:e.comments,start:function(t,o,u){var c=r&&r.ns||fo(t);X&&"svg"===c&&(o=function(t){for(var e=[],n=0;n<t.length;n++){var r=t[n];Ao.test(r.name)||(r.name=r.name.replace(ko,""),e.push(r))}return e}(o));var f,p={type:1,tag:t,attrsList:o,attrsMap:function(t){for(var e={},n=0,r=t.length;n<r;n++)e[t[n].name]=t[n].value;return e}(o),parent:r,children:[]};c&&(p.ns=c),"style"!==(f=p).tag&&("script"!==f.tag||f.attrsMap.type&&"text/javascript"!==f.attrsMap.type)||rt()||(p.forbidden=!0);for(var d=0;d<ao.length;d++)ao[d](p,e);if(s||(!function(t){null!=ir(t,"v-pre")&&(t.pre=!0)}(p),p.pre&&(s=!0)),uo(p.tag)&&(a=!0),s)!function(t){var e=t.attrsList.length;if(e)for(var n=t.attrs=new Array(e),r=0;r<e;r++)n[r]={name:t.attrsList[r].name,value:JSON.stringify(t.attrsList[r].value)};else t.pre||(t.plain=!0)}(p);else{!function(t){var e;if(e=ir(t,"v-for")){var n=e.match(vo);if(!n)return;t.for=n[2].trim();var r=n[1].trim(),i=r.match(go);i?(t.alias=i[1].trim(),t.iterator1=i[2].trim(),i[3]&&(t.iterator2=i[3].trim())):t.alias=r}}(p),function(t){var e=ir(t,"v-if");if(e)t.if=e,xo(t,{exp:e,block:t});else{null!=ir(t,"v-else")&&(t.else=!0);var n=ir(t,"v-else-if");n&&(t.elseif=n)}}(p),function(t){null!=ir(t,"v-once")&&(t.once=!0)}(p),function(t){var e=rr(t,"key");e&&(t.key=e)}(p),p.plain=!p.key&&!o.length,function(t){var e=rr(t,"ref");e&&(t.ref=e,t.refInFor=function(t){var e=t;for(;e;){if(void 0!==e.for)return!0;e=e.parent}return!1}(t))}(p),function(t){if("slot"===t.tag)t.slotName=rr(t,"name");else{var e=rr(t,"slot");e&&(t.slotTarget='""'===e?'"default"':e,tr(t,"slot",e)),"template"===t.tag&&(t.slotScope=ir(t,"scope"))}}(p),function(t){var e;(e=rr(t,"is"))&&(t.component=e);null!=ir(t,"inline-template")&&(t.inlineTemplate=!0)}(p);for(var h=0;h<so.length;h++)so[h](p,e);!function(t){var e,n,r,i,o,s,a,l=t.attrsList;for(e=0,n=l.length;e<n;e++){if(r=i=l[e].name,o=l[e].value,ho.test(r))if(t.hasBindings=!0,(s=Co(r))&&(r=r.replace(_o,"")),yo.test(r))r=r.replace(yo,""),o=Kn(o),a=!1,s&&(s.prop&&(a=!0,"innerHtml"===(r=b(r))&&(r="innerHTML")),s.camel&&(r=b(r)),s.sync&&nr(t,"update:"+b(r),sr(o,"$event"))),a||!t.component&&co(t.tag,t.attrsMap.type,r)?Yn(t,r,o):tr(t,r,o);else if(po.test(r))r=r.replace(po,""),nr(t,r,o,s,!1);else{var u=(r=r.replace(ho,"")).match(mo),c=u&&u[1];c&&(r=r.slice(0,-(c.length+1))),er(t,r,i,o,c,s)}else tr(t,r,JSON.stringify(o))}}(p)}function v(t){0}if(n?i.length||n.if&&(p.elseif||p.else)&&(v(),xo(n,{exp:p.elseif,block:p})):(n=p,v()),r&&!p.forbidden)if(p.elseif||p.else)!function(t,e){var n=function(t){var e=t.length;for(;e--;){if(1===t[e].type)return t[e];t.pop()}}(e.children);n&&n.if&&xo(n,{exp:t.elseif,block:t})}(p,r);else if(p.slotScope){r.plain=!1;var g=p.slotTarget||'"default"';(r.scopedSlots||(r.scopedSlots={}))[g]=p}else r.children.push(p),p.parent=r;u?l(p):(r=p,i.push(p));for(var m=0;m<lo.length;m++)lo[m](p,e)},end:function(){var t=i[i.length-1],e=t.children[t.children.length-1];e&&3===e.type&&" "===e.text&&!a&&t.children.pop(),i.length-=1,r=i[i.length-1],l(t)},chars:function(t){if(r&&(!X||"textarea"!==r.tag||r.attrsMap.placeholder!==t)){var e,n,i=r.children;if(t=a||t.trim()?"script"===(e=r).tag||"style"===e.tag?t:bo(t):o&&i.length?" ":"")!s&&" "!==t&&(n=Di(t,oo))?i.push({type:2,expression:n,text:t}):" "===t&&i.length&&" "===i[i.length-1].text||i.push({type:3,text:t})}},comment:function(t){r.children.push({type:3,text:t,isComment:!0})}}),n}function xo(t,e){t.ifConditions||(t.ifConditions=[]),t.ifConditions.push(e)}function Co(t){var e=t.match(_o);if(e){var n={};return e.forEach(function(t){n[t.slice(1)]=!0}),n}}var $o,To,Ao=/^xmlns:NS\d+/,ko=/^NS\d+:/;var Eo=y(function(t){return p("type,tag,attrsList,attrsMap,plain,parent,children,attrs"+(t?","+t:""))});function So(t,e){t&&($o=Eo(e.staticKeys||""),To=e.isReservedTag||S,function t(e){e.static=function(t){if(2===t.type)return!1;if(3===t.type)return!0;return!(!t.pre&&(t.hasBindings||t.if||t.for||d(t.tag)||!To(t.tag)||function(t){for(;t.parent;){if("template"!==(t=t.parent).tag)return!1;if(t.for)return!0}return!1}(t)||!Object.keys(t).every($o)))}(e);if(1===e.type){if(!To(e.tag)&&"slot"!==e.tag&&null==e.attrsMap["inline-template"])return;for(var n=0,r=e.children.length;n<r;n++){var i=e.children[n];t(i),i.static||(e.static=!1)}if(e.ifConditions)for(var o=1,s=e.ifConditions.length;o<s;o++){var a=e.ifConditions[o].block;t(a),a.static||(e.static=!1)}}}(t),function t(e,n){if(1===e.type){if((e.static||e.once)&&(e.staticInFor=n),e.static&&e.children.length&&(1!==e.children.length||3!==e.children[0].type))return void(e.staticRoot=!0);if(e.staticRoot=!1,e.children)for(var r=0,i=e.children.length;r<i;r++)t(e.children[r],n||!!e.for);if(e.ifConditions)for(var o=1,s=e.ifConditions.length;o<s;o++)t(e.ifConditions[o].block,n)}}(t,!1))}var Oo=/^\s*([\w$_]+|\([^)]*?\))\s*=>|^function\s*\(/,Do=/^\s*[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['.*?']|\[".*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*\s*$/,jo={esc:27,tab:9,enter:13,space:32,up:38,left:37,right:39,down:40,delete:[8,46]},No=function(t){return"if("+t+")return null;"},Io={stop:"$event.stopPropagation();",prevent:"$event.preventDefault();",self:No("$event.target !== $event.currentTarget"),ctrl:No("!$event.ctrlKey"),shift:No("!$event.shiftKey"),alt:No("!$event.altKey"),meta:No("!$event.metaKey"),left:No("'button' in $event && $event.button !== 0"),middle:No("'button' in $event && $event.button !== 1"),right:No("'button' in $event && $event.button !== 2")};function Po(t,e,n){var r=e?"nativeOn:{":"on:{";for(var i in t){0,r+='"'+i+'":'+Ro(i,t[i])+","}return r.slice(0,-1)+"}"}function Ro(t,e){if(!e)return"function(){}";if(Array.isArray(e))return"["+e.map(function(e){return Ro(t,e)}).join(",")+"]";var n=Do.test(e.value),r=Oo.test(e.value);if(e.modifiers){var i="",o="",s=[];for(var a in e.modifiers)Io[a]?(o+=Io[a],jo[a]&&s.push(a)):s.push(a);return s.length&&(i+=function(t){return"if(!('button' in $event)&&"+t.map(Lo).join("&&")+")return null;"}(s)),o&&(i+=o),"function($event){"+i+(n?e.value+"($event)":r?"("+e.value+")($event)":e.value)+"}"}return n||r?e.value:"function($event){"+e.value+"}"}function Lo(t){var e=parseInt(t,10);if(e)return"$event.keyCode!=="+e;var n=jo[t];return"_k($event.keyCode,"+JSON.stringify(t)+(n?","+JSON.stringify(n):"")+")"}var Fo={on:function(t,e){t.wrapListeners=function(t){return"_g("+t+","+e.value+")"}},bind:function(t,e){t.wrapData=function(n){return"_b("+n+",'"+t.tag+"',"+e.value+","+(e.modifiers&&e.modifiers.prop?"true":"false")+(e.modifiers&&e.modifiers.sync?",true":"")+")"}},cloak:E},Uo=function(t){this.options=t,this.warn=t.warn||Jn,this.transforms=Qn(t.modules,"transformCode"),this.dataGenFns=Qn(t.modules,"genData"),this.directives=A(A({},Fo),t.directives);var e=t.isReservedTag||S;this.maybeComponent=function(t){return!e(t.tag)},this.onceId=0,this.staticRenderFns=[]};function Mo(t,e){var n=new Uo(e);return{render:"with(this){return "+(t?qo(t,n):'_c("div")')+"}",staticRenderFns:n.staticRenderFns}}function qo(t,e){if(t.staticRoot&&!t.staticProcessed)return Ho(t,e);if(t.once&&!t.onceProcessed)return Bo(t,e);if(t.for&&!t.forProcessed)return function(t,e,n,r){var i=t.for,o=t.alias,s=t.iterator1?","+t.iterator1:"",a=t.iterator2?","+t.iterator2:"";0;return t.forProcessed=!0,(r||"_l")+"(("+i+"),function("+o+s+a+"){return "+(n||qo)(t,e)+"})"}(t,e);if(t.if&&!t.ifProcessed)return zo(t,e);if("template"!==t.tag||t.slotTarget){if("slot"===t.tag)return function(t,e){var n=t.slotName||'"default"',r=Go(t,e),i="_t("+n+(r?","+r:""),o=t.attrs&&"{"+t.attrs.map(function(t){return b(t.name)+":"+t.value}).join(",")+"}",s=t.attrsMap["v-bind"];!o&&!s||r||(i+=",null");o&&(i+=","+o);s&&(i+=(o?"":",null")+","+s);return i+")"}(t,e);var n;if(t.component)n=function(t,e,n){var r=e.inlineTemplate?null:Go(e,n,!0);return"_c("+t+","+Wo(e,n)+(r?","+r:"")+")"}(t.component,t,e);else{var r=t.plain?void 0:Wo(t,e),i=t.inlineTemplate?null:Go(t,e,!0);n="_c('"+t.tag+"'"+(r?","+r:"")+(i?","+i:"")+")"}for(var o=0;o<e.transforms.length;o++)n=e.transforms[o](t,n);return n}return Go(t,e)||"void 0"}function Ho(t,e){return t.staticProcessed=!0,e.staticRenderFns.push("with(this){return "+qo(t,e)+"}"),"_m("+(e.staticRenderFns.length-1)+(t.staticInFor?",true":"")+")"}function Bo(t,e){if(t.onceProcessed=!0,t.if&&!t.ifProcessed)return zo(t,e);if(t.staticInFor){for(var n="",r=t.parent;r;){if(r.for){n=r.key;break}r=r.parent}return n?"_o("+qo(t,e)+","+e.onceId+++","+n+")":qo(t,e)}return Ho(t,e)}function zo(t,e,n,r){return t.ifProcessed=!0,function t(e,n,r,i){if(!e.length)return i||"_e()";var o=e.shift();return o.exp?"("+o.exp+")?"+s(o.block)+":"+t(e,n,r,i):""+s(o.block);function s(t){return r?r(t,n):t.once?Bo(t,n):qo(t,n)}}(t.ifConditions.slice(),e,n,r)}function Wo(t,e){var n="{",r=function(t,e){var n=t.directives;if(!n)return;var r,i,o,s,a="directives:[",l=!1;for(r=0,i=n.length;r<i;r++){o=n[r],s=!0;var u=e.directives[o.name];u&&(s=!!u(t,o,e.warn)),s&&(l=!0,a+='{name:"'+o.name+'",rawName:"'+o.rawName+'"'+(o.value?",value:("+o.value+"),expression:"+JSON.stringify(o.value):"")+(o.arg?',arg:"'+o.arg+'"':"")+(o.modifiers?",modifiers:"+JSON.stringify(o.modifiers):"")+"},")}if(l)return a.slice(0,-1)+"]"}(t,e);r&&(n+=r+","),t.key&&(n+="key:"+t.key+","),t.ref&&(n+="ref:"+t.ref+","),t.refInFor&&(n+="refInFor:true,"),t.pre&&(n+="pre:true,"),t.component&&(n+='tag:"'+t.tag+'",');for(var i=0;i<e.dataGenFns.length;i++)n+=e.dataGenFns[i](t);if(t.attrs&&(n+="attrs:{"+Zo(t.attrs)+"},"),t.props&&(n+="domProps:{"+Zo(t.props)+"},"),t.events&&(n+=Po(t.events,!1,e.warn)+","),t.nativeEvents&&(n+=Po(t.nativeEvents,!0,e.warn)+","),t.slotTarget&&(n+="slot:"+t.slotTarget+","),t.scopedSlots&&(n+=function(t,e){return"scopedSlots:_u(["+Object.keys(t).map(function(n){return Vo(n,t[n],e)}).join(",")+"])"}(t.scopedSlots,e)+","),t.model&&(n+="model:{value:"+t.model.value+",callback:"+t.model.callback+",expression:"+t.model.expression+"},"),t.inlineTemplate){var o=function(t,e){var n=t.children[0];0;if(1===n.type){var r=Mo(n,e.options);return"inlineTemplate:{render:function(){"+r.render+"},staticRenderFns:["+r.staticRenderFns.map(function(t){return"function(){"+t+"}"}).join(",")+"]}"}}(t,e);o&&(n+=o+",")}return n=n.replace(/,$/,"")+"}",t.wrapData&&(n=t.wrapData(n)),t.wrapListeners&&(n=t.wrapListeners(n)),n}function Vo(t,e,n){return e.for&&!e.forProcessed?function(t,e,n){var r=e.for,i=e.alias,o=e.iterator1?","+e.iterator1:"",s=e.iterator2?","+e.iterator2:"";return e.forProcessed=!0,"_l(("+r+"),function("+i+o+s+"){return "+Vo(t,e,n)+"})"}(t,e,n):"{key:"+t+",fn:function("+String(e.attrsMap.scope)+"){return "+("template"===e.tag?Go(e,n)||"void 0":qo(e,n))+"}}"}function Go(t,e,n,r,i){var o=t.children;if(o.length){var s=o[0];if(1===o.length&&s.for&&"template"!==s.tag&&"slot"!==s.tag)return(r||qo)(s,e);var a=n?function(t,e){for(var n=0,r=0;r<t.length;r++){var i=t[r];if(1===i.type){if(Xo(i)||i.ifConditions&&i.ifConditions.some(function(t){return Xo(t.block)})){n=2;break}(e(i)||i.ifConditions&&i.ifConditions.some(function(t){return e(t.block)}))&&(n=1)}}return n}(o,e.maybeComponent):0,l=i||Ko;return"["+o.map(function(t){return l(t,e)}).join(",")+"]"+(a?","+a:"")}}function Xo(t){return void 0!==t.for||"template"===t.tag||"slot"===t.tag}function Ko(t,e){return 1===t.type?qo(t,e):3===t.type&&t.isComment?(r=t,"_e("+JSON.stringify(r.text)+")"):"_v("+(2===(n=t).type?n.expression:Jo(JSON.stringify(n.text)))+")";var n,r}function Zo(t){for(var e="",n=0;n<t.length;n++){var r=t[n];e+='"'+r.name+'":'+Jo(r.value)+","}return e.slice(0,-1)}function Jo(t){return t.replace(/\u2028/g,"\\u2028").replace(/\u2029/g,"\\u2029")}new RegExp("\\b"+"do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,super,throw,while,yield,delete,export,import,return,switch,default,extends,finally,continue,debugger,function,arguments".split(",").join("\\b|\\b")+"\\b"),new RegExp("\\b"+"delete,typeof,void".split(",").join("\\s*\\([^\\)]*\\)|\\b")+"\\s*\\([^\\)]*\\)");function Qo(t,e){try{return new Function(t)}catch(n){return e.push({err:n,code:t}),E}}var Yo,ts=(Yo=function(t,e){var n=wo(t.trim(),e);So(n,e);var r=Mo(n,e);return{ast:n,render:r.render,staticRenderFns:r.staticRenderFns}},function(t){function e(e,n){var r=Object.create(t),i=[],o=[];if(r.warn=function(t,e){(e?o:i).push(t)},n)for(var s in n.modules&&(r.modules=(t.modules||[]).concat(n.modules)),n.directives&&(r.directives=A(Object.create(t.directives),n.directives)),n)"modules"!==s&&"directives"!==s&&(r[s]=n[s]);var a=Yo(e,r);return a.errors=i,a.tips=o,a}return{compile:e,compileToFunctions:function(t){var e=Object.create(null);return function(n,r,i){var o=(r=r||{}).delimiters?String(r.delimiters)+n:n;if(e[o])return e[o];var s=t(n,r),a={},l=[];return a.render=Qo(s.render,l),a.staticRenderFns=s.staticRenderFns.map(function(t){return Qo(t,l)}),e[o]=a}}(e)}})(Fi).compileToFunctions,es=y(function(t){var e=xn(t);return e&&e.innerHTML}),ns=Ge.prototype.$mount;Ge.prototype.$mount=function(t,e){if((t=t&&xn(t))===document.body||t===document.documentElement)return this;var n=this.$options;if(!n.render){var r=n.template;if(r)if("string"==typeof r)"#"===r.charAt(0)&&(r=es(r));else{if(!r.nodeType)return this;r=r.innerHTML}else t&&(r=function(t){if(t.outerHTML)return t.outerHTML;var e=document.createElement("div");return e.appendChild(t.cloneNode(!0)),e.innerHTML}(t));if(r){0;var i=ts(r,{shouldDecodeNewlines:ki,delimiters:n.delimiters,comments:n.comments},this),o=i.render,s=i.staticRenderFns;n.render=o,n.staticRenderFns=s}}return ns.call(this,t,e)},Ge.compile=ts,t.exports=Ge}).call(e,n("DuR2"))},JHru:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["alertType","title"],computed:{alertClassName:function(){return"alert-"+this.alertType}},methods:{hideEvent:function(){this.$emit("hide")}}}},JfWP:function(t,e){},Lypw:function(t,e,n){var r=n("VU/8")(n("lAxH"),n("f2Ky"),!1,function(t){n("FxKR")},"data-v-9d96be2c",null);t.exports=r.exports},M4fF:function(t,e,n){(function(t,r){var i;(function(){var o,s=200,a="Unsupported core-js use. Try https://npms.io/search?q=ponyfill.",l="Expected a function",u="__lodash_hash_undefined__",c=500,f="__lodash_placeholder__",p=1,d=2,h=4,v=1,g=2,m=1,y=2,_=4,b=8,w=16,x=32,C=64,$=128,T=256,A=512,k=30,E="...",S=800,O=16,D=1,j=2,N=1/0,I=9007199254740991,P=1.7976931348623157e308,R=NaN,L=4294967295,F=L-1,U=L>>>1,M=[["ary",$],["bind",m],["bindKey",y],["curry",b],["curryRight",w],["flip",A],["partial",x],["partialRight",C],["rearg",T]],q="[object Arguments]",H="[object Array]",B="[object AsyncFunction]",z="[object Boolean]",W="[object Date]",V="[object DOMException]",G="[object Error]",X="[object Function]",K="[object GeneratorFunction]",Z="[object Map]",J="[object Number]",Q="[object Null]",Y="[object Object]",tt="[object Proxy]",et="[object RegExp]",nt="[object Set]",rt="[object String]",it="[object Symbol]",ot="[object Undefined]",st="[object WeakMap]",at="[object WeakSet]",lt="[object ArrayBuffer]",ut="[object DataView]",ct="[object Float32Array]",ft="[object Float64Array]",pt="[object Int8Array]",dt="[object Int16Array]",ht="[object Int32Array]",vt="[object Uint8Array]",gt="[object Uint8ClampedArray]",mt="[object Uint16Array]",yt="[object Uint32Array]",_t=/\b__p \+= '';/g,bt=/\b(__p \+=) '' \+/g,wt=/(__e\(.*?\)|\b__t\)) \+\n'';/g,xt=/&(?:amp|lt|gt|quot|#39);/g,Ct=/[&<>"']/g,$t=RegExp(xt.source),Tt=RegExp(Ct.source),At=/<%-([\s\S]+?)%>/g,kt=/<%([\s\S]+?)%>/g,Et=/<%=([\s\S]+?)%>/g,St=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,Ot=/^\w*$/,Dt=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,jt=/[\\^$.*+?()[\]{}|]/g,Nt=RegExp(jt.source),It=/^\s+|\s+$/g,Pt=/^\s+/,Rt=/\s+$/,Lt=/\{(?:\n\/\* \[wrapped with .+\] \*\/)?\n?/,Ft=/\{\n\/\* \[wrapped with (.+)\] \*/,Ut=/,? & /,Mt=/[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/g,qt=/\\(\\)?/g,Ht=/\$\{([^\\}]*(?:\\.[^\\}]*)*)\}/g,Bt=/\w*$/,zt=/^[-+]0x[0-9a-f]+$/i,Wt=/^0b[01]+$/i,Vt=/^\[object .+?Constructor\]$/,Gt=/^0o[0-7]+$/i,Xt=/^(?:0|[1-9]\d*)$/,Kt=/[\xc0-\xd6\xd8-\xf6\xf8-\xff\u0100-\u017f]/g,Zt=/($^)/,Jt=/['\n\r\u2028\u2029\\]/g,Qt="\\u0300-\\u036f\\ufe20-\\ufe2f\\u20d0-\\u20ff",Yt="\\xac\\xb1\\xd7\\xf7\\x00-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\xbf\\u2000-\\u206f \\t\\x0b\\f\\xa0\\ufeff\\n\\r\\u2028\\u2029\\u1680\\u180e\\u2000\\u2001\\u2002\\u2003\\u2004\\u2005\\u2006\\u2007\\u2008\\u2009\\u200a\\u202f\\u205f\\u3000",te="[\\ud800-\\udfff]",ee="["+Yt+"]",ne="["+Qt+"]",re="\\d+",ie="[\\u2700-\\u27bf]",oe="[a-z\\xdf-\\xf6\\xf8-\\xff]",se="[^\\ud800-\\udfff"+Yt+re+"\\u2700-\\u27bfa-z\\xdf-\\xf6\\xf8-\\xffA-Z\\xc0-\\xd6\\xd8-\\xde]",ae="\\ud83c[\\udffb-\\udfff]",le="[^\\ud800-\\udfff]",ue="(?:\\ud83c[\\udde6-\\uddff]){2}",ce="[\\ud800-\\udbff][\\udc00-\\udfff]",fe="[A-Z\\xc0-\\xd6\\xd8-\\xde]",pe="(?:"+oe+"|"+se+")",de="(?:"+fe+"|"+se+")",he="(?:"+ne+"|"+ae+")"+"?",ve="[\\ufe0e\\ufe0f]?"+he+("(?:\\u200d(?:"+[le,ue,ce].join("|")+")[\\ufe0e\\ufe0f]?"+he+")*"),ge="(?:"+[ie,ue,ce].join("|")+")"+ve,me="(?:"+[le+ne+"?",ne,ue,ce,te].join("|")+")",ye=RegExp("['’]","g"),_e=RegExp(ne,"g"),be=RegExp(ae+"(?="+ae+")|"+me+ve,"g"),we=RegExp([fe+"?"+oe+"+(?:['’](?:d|ll|m|re|s|t|ve))?(?="+[ee,fe,"$"].join("|")+")",de+"+(?:['’](?:D|LL|M|RE|S|T|VE))?(?="+[ee,fe+pe,"$"].join("|")+")",fe+"?"+pe+"+(?:['’](?:d|ll|m|re|s|t|ve))?",fe+"+(?:['’](?:D|LL|M|RE|S|T|VE))?","\\d*(?:1ST|2ND|3RD|(?![123])\\dTH)(?=\\b|[a-z_])","\\d*(?:1st|2nd|3rd|(?![123])\\dth)(?=\\b|[A-Z_])",re,ge].join("|"),"g"),xe=RegExp("[\\u200d\\ud800-\\udfff"+Qt+"\\ufe0e\\ufe0f]"),Ce=/[a-z][A-Z]|[A-Z]{2,}[a-z]|[0-9][a-zA-Z]|[a-zA-Z][0-9]|[^a-zA-Z0-9 ]/,$e=["Array","Buffer","DataView","Date","Error","Float32Array","Float64Array","Function","Int8Array","Int16Array","Int32Array","Map","Math","Object","Promise","RegExp","Set","String","Symbol","TypeError","Uint8Array","Uint8ClampedArray","Uint16Array","Uint32Array","WeakMap","_","clearTimeout","isFinite","parseInt","setTimeout"],Te=-1,Ae={};Ae[ct]=Ae[ft]=Ae[pt]=Ae[dt]=Ae[ht]=Ae[vt]=Ae[gt]=Ae[mt]=Ae[yt]=!0,Ae[q]=Ae[H]=Ae[lt]=Ae[z]=Ae[ut]=Ae[W]=Ae[G]=Ae[X]=Ae[Z]=Ae[J]=Ae[Y]=Ae[et]=Ae[nt]=Ae[rt]=Ae[st]=!1;var ke={};ke[q]=ke[H]=ke[lt]=ke[ut]=ke[z]=ke[W]=ke[ct]=ke[ft]=ke[pt]=ke[dt]=ke[ht]=ke[Z]=ke[J]=ke[Y]=ke[et]=ke[nt]=ke[rt]=ke[it]=ke[vt]=ke[gt]=ke[mt]=ke[yt]=!0,ke[G]=ke[X]=ke[st]=!1;var Ee={"\\":"\\","'":"'","\n":"n","\r":"r","\u2028":"u2028","\u2029":"u2029"},Se=parseFloat,Oe=parseInt,De="object"==typeof t&&t&&t.Object===Object&&t,je="object"==typeof self&&self&&self.Object===Object&&self,Ne=De||je||Function("return this")(),Ie="object"==typeof e&&e&&!e.nodeType&&e,Pe=Ie&&"object"==typeof r&&r&&!r.nodeType&&r,Re=Pe&&Pe.exports===Ie,Le=Re&&De.process,Fe=function(){try{return Le&&Le.binding&&Le.binding("util")}catch(t){}}(),Ue=Fe&&Fe.isArrayBuffer,Me=Fe&&Fe.isDate,qe=Fe&&Fe.isMap,He=Fe&&Fe.isRegExp,Be=Fe&&Fe.isSet,ze=Fe&&Fe.isTypedArray;function We(t,e,n){switch(n.length){case 0:return t.call(e);case 1:return t.call(e,n[0]);case 2:return t.call(e,n[0],n[1]);case 3:return t.call(e,n[0],n[1],n[2])}return t.apply(e,n)}function Ve(t,e,n,r){for(var i=-1,o=null==t?0:t.length;++i<o;){var s=t[i];e(r,s,n(s),t)}return r}function Ge(t,e){for(var n=-1,r=null==t?0:t.length;++n<r&&!1!==e(t[n],n,t););return t}function Xe(t,e){for(var n=null==t?0:t.length;n--&&!1!==e(t[n],n,t););return t}function Ke(t,e){for(var n=-1,r=null==t?0:t.length;++n<r;)if(!e(t[n],n,t))return!1;return!0}function Ze(t,e){for(var n=-1,r=null==t?0:t.length,i=0,o=[];++n<r;){var s=t[n];e(s,n,t)&&(o[i++]=s)}return o}function Je(t,e){return!!(null==t?0:t.length)&&ln(t,e,0)>-1}function Qe(t,e,n){for(var r=-1,i=null==t?0:t.length;++r<i;)if(n(e,t[r]))return!0;return!1}function Ye(t,e){for(var n=-1,r=null==t?0:t.length,i=Array(r);++n<r;)i[n]=e(t[n],n,t);return i}function tn(t,e){for(var n=-1,r=e.length,i=t.length;++n<r;)t[i+n]=e[n];return t}function en(t,e,n,r){var i=-1,o=null==t?0:t.length;for(r&&o&&(n=t[++i]);++i<o;)n=e(n,t[i],i,t);return n}function nn(t,e,n,r){var i=null==t?0:t.length;for(r&&i&&(n=t[--i]);i--;)n=e(n,t[i],i,t);return n}function rn(t,e){for(var n=-1,r=null==t?0:t.length;++n<r;)if(e(t[n],n,t))return!0;return!1}var on=pn("length");function sn(t,e,n){var r;return n(t,function(t,n,i){if(e(t,n,i))return r=n,!1}),r}function an(t,e,n,r){for(var i=t.length,o=n+(r?1:-1);r?o--:++o<i;)if(e(t[o],o,t))return o;return-1}function ln(t,e,n){return e==e?function(t,e,n){var r=n-1,i=t.length;for(;++r<i;)if(t[r]===e)return r;return-1}(t,e,n):an(t,cn,n)}function un(t,e,n,r){for(var i=n-1,o=t.length;++i<o;)if(r(t[i],e))return i;return-1}function cn(t){return t!=t}function fn(t,e){var n=null==t?0:t.length;return n?vn(t,e)/n:R}function pn(t){return function(e){return null==e?o:e[t]}}function dn(t){return function(e){return null==t?o:t[e]}}function hn(t,e,n,r,i){return i(t,function(t,i,o){n=r?(r=!1,t):e(n,t,i,o)}),n}function vn(t,e){for(var n,r=-1,i=t.length;++r<i;){var s=e(t[r]);s!==o&&(n=n===o?s:n+s)}return n}function gn(t,e){for(var n=-1,r=Array(t);++n<t;)r[n]=e(n);return r}function mn(t){return function(e){return t(e)}}function yn(t,e){return Ye(e,function(e){return t[e]})}function _n(t,e){return t.has(e)}function bn(t,e){for(var n=-1,r=t.length;++n<r&&ln(e,t[n],0)>-1;);return n}function wn(t,e){for(var n=t.length;n--&&ln(e,t[n],0)>-1;);return n}var xn=dn({"À":"A","Á":"A","Â":"A","Ã":"A","Ä":"A","Å":"A","à":"a","á":"a","â":"a","ã":"a","ä":"a","å":"a","Ç":"C","ç":"c","Ð":"D","ð":"d","È":"E","É":"E","Ê":"E","Ë":"E","è":"e","é":"e","ê":"e","ë":"e","Ì":"I","Í":"I","Î":"I","Ï":"I","ì":"i","í":"i","î":"i","ï":"i","Ñ":"N","ñ":"n","Ò":"O","Ó":"O","Ô":"O","Õ":"O","Ö":"O","Ø":"O","ò":"o","ó":"o","ô":"o","õ":"o","ö":"o","ø":"o","Ù":"U","Ú":"U","Û":"U","Ü":"U","ù":"u","ú":"u","û":"u","ü":"u","Ý":"Y","ý":"y","ÿ":"y","Æ":"Ae","æ":"ae","Þ":"Th","þ":"th","ß":"ss","Ā":"A","Ă":"A","Ą":"A","ā":"a","ă":"a","ą":"a","Ć":"C","Ĉ":"C","Ċ":"C","Č":"C","ć":"c","ĉ":"c","ċ":"c","č":"c","Ď":"D","Đ":"D","ď":"d","đ":"d","Ē":"E","Ĕ":"E","Ė":"E","Ę":"E","Ě":"E","ē":"e","ĕ":"e","ė":"e","ę":"e","ě":"e","Ĝ":"G","Ğ":"G","Ġ":"G","Ģ":"G","ĝ":"g","ğ":"g","ġ":"g","ģ":"g","Ĥ":"H","Ħ":"H","ĥ":"h","ħ":"h","Ĩ":"I","Ī":"I","Ĭ":"I","Į":"I","İ":"I","ĩ":"i","ī":"i","ĭ":"i","į":"i","ı":"i","Ĵ":"J","ĵ":"j","Ķ":"K","ķ":"k","ĸ":"k","Ĺ":"L","Ļ":"L","Ľ":"L","Ŀ":"L","Ł":"L","ĺ":"l","ļ":"l","ľ":"l","ŀ":"l","ł":"l","Ń":"N","Ņ":"N","Ň":"N","Ŋ":"N","ń":"n","ņ":"n","ň":"n","ŋ":"n","Ō":"O","Ŏ":"O","Ő":"O","ō":"o","ŏ":"o","ő":"o","Ŕ":"R","Ŗ":"R","Ř":"R","ŕ":"r","ŗ":"r","ř":"r","Ś":"S","Ŝ":"S","Ş":"S","Š":"S","ś":"s","ŝ":"s","ş":"s","š":"s","Ţ":"T","Ť":"T","Ŧ":"T","ţ":"t","ť":"t","ŧ":"t","Ũ":"U","Ū":"U","Ŭ":"U","Ů":"U","Ű":"U","Ų":"U","ũ":"u","ū":"u","ŭ":"u","ů":"u","ű":"u","ų":"u","Ŵ":"W","ŵ":"w","Ŷ":"Y","ŷ":"y","Ÿ":"Y","Ź":"Z","Ż":"Z","Ž":"Z","ź":"z","ż":"z","ž":"z","Ĳ":"IJ","ĳ":"ij","Œ":"Oe","œ":"oe","ŉ":"'n","ſ":"s"}),Cn=dn({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"});function $n(t){return"\\"+Ee[t]}function Tn(t){return xe.test(t)}function An(t){var e=-1,n=Array(t.size);return t.forEach(function(t,r){n[++e]=[r,t]}),n}function kn(t,e){return function(n){return t(e(n))}}function En(t,e){for(var n=-1,r=t.length,i=0,o=[];++n<r;){var s=t[n];s!==e&&s!==f||(t[n]=f,o[i++]=n)}return o}function Sn(t,e){return"__proto__"==e?o:t[e]}function On(t){var e=-1,n=Array(t.size);return t.forEach(function(t){n[++e]=t}),n}function Dn(t){var e=-1,n=Array(t.size);return t.forEach(function(t){n[++e]=[t,t]}),n}function jn(t){return Tn(t)?function(t){var e=be.lastIndex=0;for(;be.test(t);)++e;return e}(t):on(t)}function Nn(t){return Tn(t)?function(t){return t.match(be)||[]}(t):function(t){return t.split("")}(t)}var In=dn({"&amp;":"&","&lt;":"<","&gt;":">","&quot;":'"',"&#39;":"'"});var Pn=function t(e){var n,r=(e=null==e?Ne:Pn.defaults(Ne.Object(),e,Pn.pick(Ne,$e))).Array,i=e.Date,Qt=e.Error,Yt=e.Function,te=e.Math,ee=e.Object,ne=e.RegExp,re=e.String,ie=e.TypeError,oe=r.prototype,se=Yt.prototype,ae=ee.prototype,le=e["__core-js_shared__"],ue=se.toString,ce=ae.hasOwnProperty,fe=0,pe=(n=/[^.]+$/.exec(le&&le.keys&&le.keys.IE_PROTO||""))?"Symbol(src)_1."+n:"",de=ae.toString,he=ue.call(ee),ve=Ne._,ge=ne("^"+ue.call(ce).replace(jt,"\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g,"$1.*?")+"$"),me=Re?e.Buffer:o,be=e.Symbol,xe=e.Uint8Array,Ee=me?me.allocUnsafe:o,De=kn(ee.getPrototypeOf,ee),je=ee.create,Ie=ae.propertyIsEnumerable,Pe=oe.splice,Le=be?be.isConcatSpreadable:o,Fe=be?be.iterator:o,on=be?be.toStringTag:o,dn=function(){try{var t=Mo(ee,"defineProperty");return t({},"",{}),t}catch(t){}}(),Rn=e.clearTimeout!==Ne.clearTimeout&&e.clearTimeout,Ln=i&&i.now!==Ne.Date.now&&i.now,Fn=e.setTimeout!==Ne.setTimeout&&e.setTimeout,Un=te.ceil,Mn=te.floor,qn=ee.getOwnPropertySymbols,Hn=me?me.isBuffer:o,Bn=e.isFinite,zn=oe.join,Wn=kn(ee.keys,ee),Vn=te.max,Gn=te.min,Xn=i.now,Kn=e.parseInt,Zn=te.random,Jn=oe.reverse,Qn=Mo(e,"DataView"),Yn=Mo(e,"Map"),tr=Mo(e,"Promise"),er=Mo(e,"Set"),nr=Mo(e,"WeakMap"),rr=Mo(ee,"create"),ir=nr&&new nr,or={},sr=fs(Qn),ar=fs(Yn),lr=fs(tr),ur=fs(er),cr=fs(nr),fr=be?be.prototype:o,pr=fr?fr.valueOf:o,dr=fr?fr.toString:o;function hr(t){if(Ea(t)&&!ma(t)&&!(t instanceof yr)){if(t instanceof mr)return t;if(ce.call(t,"__wrapped__"))return ps(t)}return new mr(t)}var vr=function(){function t(){}return function(e){if(!ka(e))return{};if(je)return je(e);t.prototype=e;var n=new t;return t.prototype=o,n}}();function gr(){}function mr(t,e){this.__wrapped__=t,this.__actions__=[],this.__chain__=!!e,this.__index__=0,this.__values__=o}function yr(t){this.__wrapped__=t,this.__actions__=[],this.__dir__=1,this.__filtered__=!1,this.__iteratees__=[],this.__takeCount__=L,this.__views__=[]}function _r(t){var e=-1,n=null==t?0:t.length;for(this.clear();++e<n;){var r=t[e];this.set(r[0],r[1])}}function br(t){var e=-1,n=null==t?0:t.length;for(this.clear();++e<n;){var r=t[e];this.set(r[0],r[1])}}function wr(t){var e=-1,n=null==t?0:t.length;for(this.clear();++e<n;){var r=t[e];this.set(r[0],r[1])}}function xr(t){var e=-1,n=null==t?0:t.length;for(this.__data__=new wr;++e<n;)this.add(t[e])}function Cr(t){var e=this.__data__=new br(t);this.size=e.size}function $r(t,e){var n=ma(t),r=!n&&ga(t),i=!n&&!r&&wa(t),o=!n&&!r&&!i&&Ra(t),s=n||r||i||o,a=s?gn(t.length,re):[],l=a.length;for(var u in t)!e&&!ce.call(t,u)||s&&("length"==u||i&&("offset"==u||"parent"==u)||o&&("buffer"==u||"byteLength"==u||"byteOffset"==u)||Go(u,l))||a.push(u);return a}function Tr(t){var e=t.length;return e?t[xi(0,e-1)]:o}function Ar(t,e){return ls(ro(t),Pr(e,0,t.length))}function kr(t){return ls(ro(t))}function Er(t,e,n){(n===o||da(t[e],n))&&(n!==o||e in t)||Nr(t,e,n)}function Sr(t,e,n){var r=t[e];ce.call(t,e)&&da(r,n)&&(n!==o||e in t)||Nr(t,e,n)}function Or(t,e){for(var n=t.length;n--;)if(da(t[n][0],e))return n;return-1}function Dr(t,e,n,r){return Mr(t,function(t,i,o){e(r,t,n(t),o)}),r}function jr(t,e){return t&&io(e,il(e),t)}function Nr(t,e,n){"__proto__"==e&&dn?dn(t,e,{configurable:!0,enumerable:!0,value:n,writable:!0}):t[e]=n}function Ir(t,e){for(var n=-1,i=e.length,s=r(i),a=null==t;++n<i;)s[n]=a?o:Ya(t,e[n]);return s}function Pr(t,e,n){return t==t&&(n!==o&&(t=t<=n?t:n),e!==o&&(t=t>=e?t:e)),t}function Rr(t,e,n,r,i,s){var a,l=e&p,u=e&d,c=e&h;if(n&&(a=i?n(t,r,i,s):n(t)),a!==o)return a;if(!ka(t))return t;var f=ma(t);if(f){if(a=function(t){var e=t.length,n=new t.constructor(e);return e&&"string"==typeof t[0]&&ce.call(t,"index")&&(n.index=t.index,n.input=t.input),n}(t),!l)return ro(t,a)}else{var v=Bo(t),g=v==X||v==K;if(wa(t))return Ji(t,l);if(v==Y||v==q||g&&!i){if(a=u||g?{}:Wo(t),!l)return u?function(t,e){return io(t,Ho(t),e)}(t,function(t,e){return t&&io(e,ol(e),t)}(a,t)):function(t,e){return io(t,qo(t),e)}(t,jr(a,t))}else{if(!ke[v])return i?t:{};a=function(t,e,n){var r,i,o,s=t.constructor;switch(e){case lt:return Qi(t);case z:case W:return new s(+t);case ut:return function(t,e){var n=e?Qi(t.buffer):t.buffer;return new t.constructor(n,t.byteOffset,t.byteLength)}(t,n);case ct:case ft:case pt:case dt:case ht:case vt:case gt:case mt:case yt:return Yi(t,n);case Z:return new s;case J:case rt:return new s(t);case et:return(o=new(i=t).constructor(i.source,Bt.exec(i))).lastIndex=i.lastIndex,o;case nt:return new s;case it:return r=t,pr?ee(pr.call(r)):{}}}(t,v,l)}}s||(s=new Cr);var m=s.get(t);if(m)return m;if(s.set(t,a),Na(t))return t.forEach(function(r){a.add(Rr(r,e,n,r,t,s))}),a;if(Sa(t))return t.forEach(function(r,i){a.set(i,Rr(r,e,n,i,t,s))}),a;var y=f?o:(c?u?No:jo:u?ol:il)(t);return Ge(y||t,function(r,i){y&&(r=t[i=r]),Sr(a,i,Rr(r,e,n,i,t,s))}),a}function Lr(t,e,n){var r=n.length;if(null==t)return!r;for(t=ee(t);r--;){var i=n[r],s=e[i],a=t[i];if(a===o&&!(i in t)||!s(a))return!1}return!0}function Fr(t,e,n){if("function"!=typeof t)throw new ie(l);return is(function(){t.apply(o,n)},e)}function Ur(t,e,n,r){var i=-1,o=Je,a=!0,l=t.length,u=[],c=e.length;if(!l)return u;n&&(e=Ye(e,mn(n))),r?(o=Qe,a=!1):e.length>=s&&(o=_n,a=!1,e=new xr(e));t:for(;++i<l;){var f=t[i],p=null==n?f:n(f);if(f=r||0!==f?f:0,a&&p==p){for(var d=c;d--;)if(e[d]===p)continue t;u.push(f)}else o(e,p,r)||u.push(f)}return u}hr.templateSettings={escape:At,evaluate:kt,interpolate:Et,variable:"",imports:{_:hr}},hr.prototype=gr.prototype,hr.prototype.constructor=hr,mr.prototype=vr(gr.prototype),mr.prototype.constructor=mr,yr.prototype=vr(gr.prototype),yr.prototype.constructor=yr,_r.prototype.clear=function(){this.__data__=rr?rr(null):{},this.size=0},_r.prototype.delete=function(t){var e=this.has(t)&&delete this.__data__[t];return this.size-=e?1:0,e},_r.prototype.get=function(t){var e=this.__data__;if(rr){var n=e[t];return n===u?o:n}return ce.call(e,t)?e[t]:o},_r.prototype.has=function(t){var e=this.__data__;return rr?e[t]!==o:ce.call(e,t)},_r.prototype.set=function(t,e){var n=this.__data__;return this.size+=this.has(t)?0:1,n[t]=rr&&e===o?u:e,this},br.prototype.clear=function(){this.__data__=[],this.size=0},br.prototype.delete=function(t){var e=this.__data__,n=Or(e,t);return!(n<0||(n==e.length-1?e.pop():Pe.call(e,n,1),--this.size,0))},br.prototype.get=function(t){var e=this.__data__,n=Or(e,t);return n<0?o:e[n][1]},br.prototype.has=function(t){return Or(this.__data__,t)>-1},br.prototype.set=function(t,e){var n=this.__data__,r=Or(n,t);return r<0?(++this.size,n.push([t,e])):n[r][1]=e,this},wr.prototype.clear=function(){this.size=0,this.__data__={hash:new _r,map:new(Yn||br),string:new _r}},wr.prototype.delete=function(t){var e=Fo(this,t).delete(t);return this.size-=e?1:0,e},wr.prototype.get=function(t){return Fo(this,t).get(t)},wr.prototype.has=function(t){return Fo(this,t).has(t)},wr.prototype.set=function(t,e){var n=Fo(this,t),r=n.size;return n.set(t,e),this.size+=n.size==r?0:1,this},xr.prototype.add=xr.prototype.push=function(t){return this.__data__.set(t,u),this},xr.prototype.has=function(t){return this.__data__.has(t)},Cr.prototype.clear=function(){this.__data__=new br,this.size=0},Cr.prototype.delete=function(t){var e=this.__data__,n=e.delete(t);return this.size=e.size,n},Cr.prototype.get=function(t){return this.__data__.get(t)},Cr.prototype.has=function(t){return this.__data__.has(t)},Cr.prototype.set=function(t,e){var n=this.__data__;if(n instanceof br){var r=n.__data__;if(!Yn||r.length<s-1)return r.push([t,e]),this.size=++n.size,this;n=this.__data__=new wr(r)}return n.set(t,e),this.size=n.size,this};var Mr=ao(Xr),qr=ao(Kr,!0);function Hr(t,e){var n=!0;return Mr(t,function(t,r,i){return n=!!e(t,r,i)}),n}function Br(t,e,n){for(var r=-1,i=t.length;++r<i;){var s=t[r],a=e(s);if(null!=a&&(l===o?a==a&&!Pa(a):n(a,l)))var l=a,u=s}return u}function zr(t,e){var n=[];return Mr(t,function(t,r,i){e(t,r,i)&&n.push(t)}),n}function Wr(t,e,n,r,i){var o=-1,s=t.length;for(n||(n=Vo),i||(i=[]);++o<s;){var a=t[o];e>0&&n(a)?e>1?Wr(a,e-1,n,r,i):tn(i,a):r||(i[i.length]=a)}return i}var Vr=lo(),Gr=lo(!0);function Xr(t,e){return t&&Vr(t,e,il)}function Kr(t,e){return t&&Gr(t,e,il)}function Zr(t,e){return Ze(e,function(e){return $a(t[e])})}function Jr(t,e){for(var n=0,r=(e=Gi(e,t)).length;null!=t&&n<r;)t=t[cs(e[n++])];return n&&n==r?t:o}function Qr(t,e,n){var r=e(t);return ma(t)?r:tn(r,n(t))}function Yr(t){return null==t?t===o?ot:Q:on&&on in ee(t)?function(t){var e=ce.call(t,on),n=t[on];try{t[on]=o;var r=!0}catch(t){}var i=de.call(t);return r&&(e?t[on]=n:delete t[on]),i}(t):function(t){return de.call(t)}(t)}function ti(t,e){return t>e}function ei(t,e){return null!=t&&ce.call(t,e)}function ni(t,e){return null!=t&&e in ee(t)}function ri(t,e,n){for(var i=n?Qe:Je,s=t[0].length,a=t.length,l=a,u=r(a),c=1/0,f=[];l--;){var p=t[l];l&&e&&(p=Ye(p,mn(e))),c=Gn(p.length,c),u[l]=!n&&(e||s>=120&&p.length>=120)?new xr(l&&p):o}p=t[0];var d=-1,h=u[0];t:for(;++d<s&&f.length<c;){var v=p[d],g=e?e(v):v;if(v=n||0!==v?v:0,!(h?_n(h,g):i(f,g,n))){for(l=a;--l;){var m=u[l];if(!(m?_n(m,g):i(t[l],g,n)))continue t}h&&h.push(g),f.push(v)}}return f}function ii(t,e,n){var r=null==(t=ns(t,e=Gi(e,t)))?t:t[cs(Cs(e))];return null==r?o:We(r,t,n)}function oi(t){return Ea(t)&&Yr(t)==q}function si(t,e,n,r,i){return t===e||(null==t||null==e||!Ea(t)&&!Ea(e)?t!=t&&e!=e:function(t,e,n,r,i,s){var a=ma(t),l=ma(e),u=a?H:Bo(t),c=l?H:Bo(e),f=(u=u==q?Y:u)==Y,p=(c=c==q?Y:c)==Y,d=u==c;if(d&&wa(t)){if(!wa(e))return!1;a=!0,f=!1}if(d&&!f)return s||(s=new Cr),a||Ra(t)?Oo(t,e,n,r,i,s):function(t,e,n,r,i,o,s){switch(n){case ut:if(t.byteLength!=e.byteLength||t.byteOffset!=e.byteOffset)return!1;t=t.buffer,e=e.buffer;case lt:return!(t.byteLength!=e.byteLength||!o(new xe(t),new xe(e)));case z:case W:case J:return da(+t,+e);case G:return t.name==e.name&&t.message==e.message;case et:case rt:return t==e+"";case Z:var a=An;case nt:var l=r&v;if(a||(a=On),t.size!=e.size&&!l)return!1;var u=s.get(t);if(u)return u==e;r|=g,s.set(t,e);var c=Oo(a(t),a(e),r,i,o,s);return s.delete(t),c;case it:if(pr)return pr.call(t)==pr.call(e)}return!1}(t,e,u,n,r,i,s);if(!(n&v)){var h=f&&ce.call(t,"__wrapped__"),m=p&&ce.call(e,"__wrapped__");if(h||m){var y=h?t.value():t,_=m?e.value():e;return s||(s=new Cr),i(y,_,n,r,s)}}return!!d&&(s||(s=new Cr),function(t,e,n,r,i,s){var a=n&v,l=jo(t),u=l.length,c=jo(e).length;if(u!=c&&!a)return!1;for(var f=u;f--;){var p=l[f];if(!(a?p in e:ce.call(e,p)))return!1}var d=s.get(t);if(d&&s.get(e))return d==e;var h=!0;s.set(t,e),s.set(e,t);for(var g=a;++f<u;){p=l[f];var m=t[p],y=e[p];if(r)var _=a?r(y,m,p,e,t,s):r(m,y,p,t,e,s);if(!(_===o?m===y||i(m,y,n,r,s):_)){h=!1;break}g||(g="constructor"==p)}if(h&&!g){var b=t.constructor,w=e.constructor;b!=w&&"constructor"in t&&"constructor"in e&&!("function"==typeof b&&b instanceof b&&"function"==typeof w&&w instanceof w)&&(h=!1)}return s.delete(t),s.delete(e),h}(t,e,n,r,i,s))}(t,e,n,r,si,i))}function ai(t,e,n,r){var i=n.length,s=i,a=!r;if(null==t)return!s;for(t=ee(t);i--;){var l=n[i];if(a&&l[2]?l[1]!==t[l[0]]:!(l[0]in t))return!1}for(;++i<s;){var u=(l=n[i])[0],c=t[u],f=l[1];if(a&&l[2]){if(c===o&&!(u in t))return!1}else{var p=new Cr;if(r)var d=r(c,f,u,t,e,p);if(!(d===o?si(f,c,v|g,r,p):d))return!1}}return!0}function li(t){return!(!ka(t)||pe&&pe in t)&&($a(t)?ge:Vt).test(fs(t))}function ui(t){return"function"==typeof t?t:null==t?Ol:"object"==typeof t?ma(t)?vi(t[0],t[1]):hi(t):Ul(t)}function ci(t){if(!Qo(t))return Wn(t);var e=[];for(var n in ee(t))ce.call(t,n)&&"constructor"!=n&&e.push(n);return e}function fi(t){if(!ka(t))return function(t){var e=[];if(null!=t)for(var n in ee(t))e.push(n);return e}(t);var e=Qo(t),n=[];for(var r in t)("constructor"!=r||!e&&ce.call(t,r))&&n.push(r);return n}function pi(t,e){return t<e}function di(t,e){var n=-1,i=_a(t)?r(t.length):[];return Mr(t,function(t,r,o){i[++n]=e(t,r,o)}),i}function hi(t){var e=Uo(t);return 1==e.length&&e[0][2]?ts(e[0][0],e[0][1]):function(n){return n===t||ai(n,t,e)}}function vi(t,e){return Ko(t)&&Yo(e)?ts(cs(t),e):function(n){var r=Ya(n,t);return r===o&&r===e?tl(n,t):si(e,r,v|g)}}function gi(t,e,n,r,i){t!==e&&Vr(e,function(s,a){if(ka(s))i||(i=new Cr),function(t,e,n,r,i,s,a){var l=Sn(t,n),u=Sn(e,n),c=a.get(u);if(c)Er(t,n,c);else{var f=s?s(l,u,n+"",t,e,a):o,p=f===o;if(p){var d=ma(u),h=!d&&wa(u),v=!d&&!h&&Ra(u);f=u,d||h||v?ma(l)?f=l:ba(l)?f=ro(l):h?(p=!1,f=Ji(u,!0)):v?(p=!1,f=Yi(u,!0)):f=[]:Da(u)||ga(u)?(f=l,ga(l)?f=za(l):(!ka(l)||r&&$a(l))&&(f=Wo(u))):p=!1}p&&(a.set(u,f),i(f,u,r,s,a),a.delete(u)),Er(t,n,f)}}(t,e,a,n,gi,r,i);else{var l=r?r(Sn(t,a),s,a+"",t,e,i):o;l===o&&(l=s),Er(t,a,l)}},ol)}function mi(t,e){var n=t.length;if(n)return Go(e+=e<0?n:0,n)?t[e]:o}function yi(t,e,n){var r=-1;return e=Ye(e.length?e:[Ol],mn(Lo())),function(t,e){var n=t.length;for(t.sort(e);n--;)t[n]=t[n].value;return t}(di(t,function(t,n,i){return{criteria:Ye(e,function(e){return e(t)}),index:++r,value:t}}),function(t,e){return function(t,e,n){for(var r=-1,i=t.criteria,o=e.criteria,s=i.length,a=n.length;++r<s;){var l=to(i[r],o[r]);if(l){if(r>=a)return l;var u=n[r];return l*("desc"==u?-1:1)}}return t.index-e.index}(t,e,n)})}function _i(t,e,n){for(var r=-1,i=e.length,o={};++r<i;){var s=e[r],a=Jr(t,s);n(a,s)&&ki(o,Gi(s,t),a)}return o}function bi(t,e,n,r){var i=r?un:ln,o=-1,s=e.length,a=t;for(t===e&&(e=ro(e)),n&&(a=Ye(t,mn(n)));++o<s;)for(var l=0,u=e[o],c=n?n(u):u;(l=i(a,c,l,r))>-1;)a!==t&&Pe.call(a,l,1),Pe.call(t,l,1);return t}function wi(t,e){for(var n=t?e.length:0,r=n-1;n--;){var i=e[n];if(n==r||i!==o){var o=i;Go(i)?Pe.call(t,i,1):Ui(t,i)}}return t}function xi(t,e){return t+Mn(Zn()*(e-t+1))}function Ci(t,e){var n="";if(!t||e<1||e>I)return n;do{e%2&&(n+=t),(e=Mn(e/2))&&(t+=t)}while(e);return n}function $i(t,e){return os(es(t,e,Ol),t+"")}function Ti(t){return Tr(dl(t))}function Ai(t,e){var n=dl(t);return ls(n,Pr(e,0,n.length))}function ki(t,e,n,r){if(!ka(t))return t;for(var i=-1,s=(e=Gi(e,t)).length,a=s-1,l=t;null!=l&&++i<s;){var u=cs(e[i]),c=n;if(i!=a){var f=l[u];(c=r?r(f,u,l):o)===o&&(c=ka(f)?f:Go(e[i+1])?[]:{})}Sr(l,u,c),l=l[u]}return t}var Ei=ir?function(t,e){return ir.set(t,e),t}:Ol,Si=dn?function(t,e){return dn(t,"toString",{configurable:!0,enumerable:!1,value:kl(e),writable:!0})}:Ol;function Oi(t){return ls(dl(t))}function Di(t,e,n){var i=-1,o=t.length;e<0&&(e=-e>o?0:o+e),(n=n>o?o:n)<0&&(n+=o),o=e>n?0:n-e>>>0,e>>>=0;for(var s=r(o);++i<o;)s[i]=t[i+e];return s}function ji(t,e){var n;return Mr(t,function(t,r,i){return!(n=e(t,r,i))}),!!n}function Ni(t,e,n){var r=0,i=null==t?r:t.length;if("number"==typeof e&&e==e&&i<=U){for(;r<i;){var o=r+i>>>1,s=t[o];null!==s&&!Pa(s)&&(n?s<=e:s<e)?r=o+1:i=o}return i}return Ii(t,e,Ol,n)}function Ii(t,e,n,r){e=n(e);for(var i=0,s=null==t?0:t.length,a=e!=e,l=null===e,u=Pa(e),c=e===o;i<s;){var f=Mn((i+s)/2),p=n(t[f]),d=p!==o,h=null===p,v=p==p,g=Pa(p);if(a)var m=r||v;else m=c?v&&(r||d):l?v&&d&&(r||!h):u?v&&d&&!h&&(r||!g):!h&&!g&&(r?p<=e:p<e);m?i=f+1:s=f}return Gn(s,F)}function Pi(t,e){for(var n=-1,r=t.length,i=0,o=[];++n<r;){var s=t[n],a=e?e(s):s;if(!n||!da(a,l)){var l=a;o[i++]=0===s?0:s}}return o}function Ri(t){return"number"==typeof t?t:Pa(t)?R:+t}function Li(t){if("string"==typeof t)return t;if(ma(t))return Ye(t,Li)+"";if(Pa(t))return dr?dr.call(t):"";var e=t+"";return"0"==e&&1/t==-N?"-0":e}function Fi(t,e,n){var r=-1,i=Je,o=t.length,a=!0,l=[],u=l;if(n)a=!1,i=Qe;else if(o>=s){var c=e?null:$o(t);if(c)return On(c);a=!1,i=_n,u=new xr}else u=e?[]:l;t:for(;++r<o;){var f=t[r],p=e?e(f):f;if(f=n||0!==f?f:0,a&&p==p){for(var d=u.length;d--;)if(u[d]===p)continue t;e&&u.push(p),l.push(f)}else i(u,p,n)||(u!==l&&u.push(p),l.push(f))}return l}function Ui(t,e){return null==(t=ns(t,e=Gi(e,t)))||delete t[cs(Cs(e))]}function Mi(t,e,n,r){return ki(t,e,n(Jr(t,e)),r)}function qi(t,e,n,r){for(var i=t.length,o=r?i:-1;(r?o--:++o<i)&&e(t[o],o,t););return n?Di(t,r?0:o,r?o+1:i):Di(t,r?o+1:0,r?i:o)}function Hi(t,e){var n=t;return n instanceof yr&&(n=n.value()),en(e,function(t,e){return e.func.apply(e.thisArg,tn([t],e.args))},n)}function Bi(t,e,n){var i=t.length;if(i<2)return i?Fi(t[0]):[];for(var o=-1,s=r(i);++o<i;)for(var a=t[o],l=-1;++l<i;)l!=o&&(s[o]=Ur(s[o]||a,t[l],e,n));return Fi(Wr(s,1),e,n)}function zi(t,e,n){for(var r=-1,i=t.length,s=e.length,a={};++r<i;){var l=r<s?e[r]:o;n(a,t[r],l)}return a}function Wi(t){return ba(t)?t:[]}function Vi(t){return"function"==typeof t?t:Ol}function Gi(t,e){return ma(t)?t:Ko(t,e)?[t]:us(Wa(t))}var Xi=$i;function Ki(t,e,n){var r=t.length;return n=n===o?r:n,!e&&n>=r?t:Di(t,e,n)}var Zi=Rn||function(t){return Ne.clearTimeout(t)};function Ji(t,e){if(e)return t.slice();var n=t.length,r=Ee?Ee(n):new t.constructor(n);return t.copy(r),r}function Qi(t){var e=new t.constructor(t.byteLength);return new xe(e).set(new xe(t)),e}function Yi(t,e){var n=e?Qi(t.buffer):t.buffer;return new t.constructor(n,t.byteOffset,t.length)}function to(t,e){if(t!==e){var n=t!==o,r=null===t,i=t==t,s=Pa(t),a=e!==o,l=null===e,u=e==e,c=Pa(e);if(!l&&!c&&!s&&t>e||s&&a&&u&&!l&&!c||r&&a&&u||!n&&u||!i)return 1;if(!r&&!s&&!c&&t<e||c&&n&&i&&!r&&!s||l&&n&&i||!a&&i||!u)return-1}return 0}function eo(t,e,n,i){for(var o=-1,s=t.length,a=n.length,l=-1,u=e.length,c=Vn(s-a,0),f=r(u+c),p=!i;++l<u;)f[l]=e[l];for(;++o<a;)(p||o<s)&&(f[n[o]]=t[o]);for(;c--;)f[l++]=t[o++];return f}function no(t,e,n,i){for(var o=-1,s=t.length,a=-1,l=n.length,u=-1,c=e.length,f=Vn(s-l,0),p=r(f+c),d=!i;++o<f;)p[o]=t[o];for(var h=o;++u<c;)p[h+u]=e[u];for(;++a<l;)(d||o<s)&&(p[h+n[a]]=t[o++]);return p}function ro(t,e){var n=-1,i=t.length;for(e||(e=r(i));++n<i;)e[n]=t[n];return e}function io(t,e,n,r){var i=!n;n||(n={});for(var s=-1,a=e.length;++s<a;){var l=e[s],u=r?r(n[l],t[l],l,n,t):o;u===o&&(u=t[l]),i?Nr(n,l,u):Sr(n,l,u)}return n}function oo(t,e){return function(n,r){var i=ma(n)?Ve:Dr,o=e?e():{};return i(n,t,Lo(r,2),o)}}function so(t){return $i(function(e,n){var r=-1,i=n.length,s=i>1?n[i-1]:o,a=i>2?n[2]:o;for(s=t.length>3&&"function"==typeof s?(i--,s):o,a&&Xo(n[0],n[1],a)&&(s=i<3?o:s,i=1),e=ee(e);++r<i;){var l=n[r];l&&t(e,l,r,s)}return e})}function ao(t,e){return function(n,r){if(null==n)return n;if(!_a(n))return t(n,r);for(var i=n.length,o=e?i:-1,s=ee(n);(e?o--:++o<i)&&!1!==r(s[o],o,s););return n}}function lo(t){return function(e,n,r){for(var i=-1,o=ee(e),s=r(e),a=s.length;a--;){var l=s[t?a:++i];if(!1===n(o[l],l,o))break}return e}}function uo(t){return function(e){var n=Tn(e=Wa(e))?Nn(e):o,r=n?n[0]:e.charAt(0),i=n?Ki(n,1).join(""):e.slice(1);return r[t]()+i}}function co(t){return function(e){return en($l(gl(e).replace(ye,"")),t,"")}}function fo(t){return function(){var e=arguments;switch(e.length){case 0:return new t;case 1:return new t(e[0]);case 2:return new t(e[0],e[1]);case 3:return new t(e[0],e[1],e[2]);case 4:return new t(e[0],e[1],e[2],e[3]);case 5:return new t(e[0],e[1],e[2],e[3],e[4]);case 6:return new t(e[0],e[1],e[2],e[3],e[4],e[5]);case 7:return new t(e[0],e[1],e[2],e[3],e[4],e[5],e[6])}var n=vr(t.prototype),r=t.apply(n,e);return ka(r)?r:n}}function po(t){return function(e,n,r){var i=ee(e);if(!_a(e)){var s=Lo(n,3);e=il(e),n=function(t){return s(i[t],t,i)}}var a=t(e,n,r);return a>-1?i[s?e[a]:a]:o}}function ho(t){return Do(function(e){var n=e.length,r=n,i=mr.prototype.thru;for(t&&e.reverse();r--;){var s=e[r];if("function"!=typeof s)throw new ie(l);if(i&&!a&&"wrapper"==Po(s))var a=new mr([],!0)}for(r=a?r:n;++r<n;){var u=Po(s=e[r]),c="wrapper"==u?Io(s):o;a=c&&Zo(c[0])&&c[1]==($|b|x|T)&&!c[4].length&&1==c[9]?a[Po(c[0])].apply(a,c[3]):1==s.length&&Zo(s)?a[u]():a.thru(s)}return function(){var t=arguments,r=t[0];if(a&&1==t.length&&ma(r))return a.plant(r).value();for(var i=0,o=n?e[i].apply(this,t):r;++i<n;)o=e[i].call(this,o);return o}})}function vo(t,e,n,i,s,a,l,u,c,f){var p=e&$,d=e&m,h=e&y,v=e&(b|w),g=e&A,_=h?o:fo(t);return function m(){for(var y=arguments.length,b=r(y),w=y;w--;)b[w]=arguments[w];if(v)var x=Ro(m),C=function(t,e){for(var n=t.length,r=0;n--;)t[n]===e&&++r;return r}(b,x);if(i&&(b=eo(b,i,s,v)),a&&(b=no(b,a,l,v)),y-=C,v&&y<f){var $=En(b,x);return xo(t,e,vo,m.placeholder,n,b,$,u,c,f-y)}var T=d?n:this,A=h?T[t]:t;return y=b.length,u?b=function(t,e){for(var n=t.length,r=Gn(e.length,n),i=ro(t);r--;){var s=e[r];t[r]=Go(s,n)?i[s]:o}return t}(b,u):g&&y>1&&b.reverse(),p&&c<y&&(b.length=c),this&&this!==Ne&&this instanceof m&&(A=_||fo(A)),A.apply(T,b)}}function go(t,e){return function(n,r){return function(t,e,n,r){return Xr(t,function(t,i,o){e(r,n(t),i,o)}),r}(n,t,e(r),{})}}function mo(t,e){return function(n,r){var i;if(n===o&&r===o)return e;if(n!==o&&(i=n),r!==o){if(i===o)return r;"string"==typeof n||"string"==typeof r?(n=Li(n),r=Li(r)):(n=Ri(n),r=Ri(r)),i=t(n,r)}return i}}function yo(t){return Do(function(e){return e=Ye(e,mn(Lo())),$i(function(n){var r=this;return t(e,function(t){return We(t,r,n)})})})}function _o(t,e){var n=(e=e===o?" ":Li(e)).length;if(n<2)return n?Ci(e,t):e;var r=Ci(e,Un(t/jn(e)));return Tn(e)?Ki(Nn(r),0,t).join(""):r.slice(0,t)}function bo(t){return function(e,n,i){return i&&"number"!=typeof i&&Xo(e,n,i)&&(n=i=o),e=Ma(e),n===o?(n=e,e=0):n=Ma(n),function(t,e,n,i){for(var o=-1,s=Vn(Un((e-t)/(n||1)),0),a=r(s);s--;)a[i?s:++o]=t,t+=n;return a}(e,n,i=i===o?e<n?1:-1:Ma(i),t)}}function wo(t){return function(e,n){return"string"==typeof e&&"string"==typeof n||(e=Ba(e),n=Ba(n)),t(e,n)}}function xo(t,e,n,r,i,s,a,l,u,c){var f=e&b;e|=f?x:C,(e&=~(f?C:x))&_||(e&=~(m|y));var p=[t,e,i,f?s:o,f?a:o,f?o:s,f?o:a,l,u,c],d=n.apply(o,p);return Zo(t)&&rs(d,p),d.placeholder=r,ss(d,t,e)}function Co(t){var e=te[t];return function(t,n){if(t=Ba(t),n=null==n?0:Gn(qa(n),292)){var r=(Wa(t)+"e").split("e");return+((r=(Wa(e(r[0]+"e"+(+r[1]+n)))+"e").split("e"))[0]+"e"+(+r[1]-n))}return e(t)}}var $o=er&&1/On(new er([,-0]))[1]==N?function(t){return new er(t)}:Pl;function To(t){return function(e){var n=Bo(e);return n==Z?An(e):n==nt?Dn(e):function(t,e){return Ye(e,function(e){return[e,t[e]]})}(e,t(e))}}function Ao(t,e,n,i,s,a,u,c){var p=e&y;if(!p&&"function"!=typeof t)throw new ie(l);var d=i?i.length:0;if(d||(e&=~(x|C),i=s=o),u=u===o?u:Vn(qa(u),0),c=c===o?c:qa(c),d-=s?s.length:0,e&C){var h=i,v=s;i=s=o}var g=p?o:Io(t),A=[t,e,n,i,s,h,v,a,u,c];if(g&&function(t,e){var n=t[1],r=e[1],i=n|r,o=i<(m|y|$),s=r==$&&n==b||r==$&&n==T&&t[7].length<=e[8]||r==($|T)&&e[7].length<=e[8]&&n==b;if(!o&&!s)return t;r&m&&(t[2]=e[2],i|=n&m?0:_);var a=e[3];if(a){var l=t[3];t[3]=l?eo(l,a,e[4]):a,t[4]=l?En(t[3],f):e[4]}(a=e[5])&&(l=t[5],t[5]=l?no(l,a,e[6]):a,t[6]=l?En(t[5],f):e[6]),(a=e[7])&&(t[7]=a),r&$&&(t[8]=null==t[8]?e[8]:Gn(t[8],e[8])),null==t[9]&&(t[9]=e[9]),t[0]=e[0],t[1]=i}(A,g),t=A[0],e=A[1],n=A[2],i=A[3],s=A[4],!(c=A[9]=A[9]===o?p?0:t.length:Vn(A[9]-d,0))&&e&(b|w)&&(e&=~(b|w)),e&&e!=m)k=e==b||e==w?function(t,e,n){var i=fo(t);return function s(){for(var a=arguments.length,l=r(a),u=a,c=Ro(s);u--;)l[u]=arguments[u];var f=a<3&&l[0]!==c&&l[a-1]!==c?[]:En(l,c);return(a-=f.length)<n?xo(t,e,vo,s.placeholder,o,l,f,o,o,n-a):We(this&&this!==Ne&&this instanceof s?i:t,this,l)}}(t,e,c):e!=x&&e!=(m|x)||s.length?vo.apply(o,A):function(t,e,n,i){var o=e&m,s=fo(t);return function e(){for(var a=-1,l=arguments.length,u=-1,c=i.length,f=r(c+l),p=this&&this!==Ne&&this instanceof e?s:t;++u<c;)f[u]=i[u];for(;l--;)f[u++]=arguments[++a];return We(p,o?n:this,f)}}(t,e,n,i);else var k=function(t,e,n){var r=e&m,i=fo(t);return function e(){return(this&&this!==Ne&&this instanceof e?i:t).apply(r?n:this,arguments)}}(t,e,n);return ss((g?Ei:rs)(k,A),t,e)}function ko(t,e,n,r){return t===o||da(t,ae[n])&&!ce.call(r,n)?e:t}function Eo(t,e,n,r,i,s){return ka(t)&&ka(e)&&(s.set(e,t),gi(t,e,o,Eo,s),s.delete(e)),t}function So(t){return Da(t)?o:t}function Oo(t,e,n,r,i,s){var a=n&v,l=t.length,u=e.length;if(l!=u&&!(a&&u>l))return!1;var c=s.get(t);if(c&&s.get(e))return c==e;var f=-1,p=!0,d=n&g?new xr:o;for(s.set(t,e),s.set(e,t);++f<l;){var h=t[f],m=e[f];if(r)var y=a?r(m,h,f,e,t,s):r(h,m,f,t,e,s);if(y!==o){if(y)continue;p=!1;break}if(d){if(!rn(e,function(t,e){if(!_n(d,e)&&(h===t||i(h,t,n,r,s)))return d.push(e)})){p=!1;break}}else if(h!==m&&!i(h,m,n,r,s)){p=!1;break}}return s.delete(t),s.delete(e),p}function Do(t){return os(es(t,o,ys),t+"")}function jo(t){return Qr(t,il,qo)}function No(t){return Qr(t,ol,Ho)}var Io=ir?function(t){return ir.get(t)}:Pl;function Po(t){for(var e=t.name+"",n=or[e],r=ce.call(or,e)?n.length:0;r--;){var i=n[r],o=i.func;if(null==o||o==t)return i.name}return e}function Ro(t){return(ce.call(hr,"placeholder")?hr:t).placeholder}function Lo(){var t=hr.iteratee||Dl;return t=t===Dl?ui:t,arguments.length?t(arguments[0],arguments[1]):t}function Fo(t,e){var n,r,i=t.__data__;return("string"==(r=typeof(n=e))||"number"==r||"symbol"==r||"boolean"==r?"__proto__"!==n:null===n)?i["string"==typeof e?"string":"hash"]:i.map}function Uo(t){for(var e=il(t),n=e.length;n--;){var r=e[n],i=t[r];e[n]=[r,i,Yo(i)]}return e}function Mo(t,e){var n=function(t,e){return null==t?o:t[e]}(t,e);return li(n)?n:o}var qo=qn?function(t){return null==t?[]:(t=ee(t),Ze(qn(t),function(e){return Ie.call(t,e)}))}:Hl,Ho=qn?function(t){for(var e=[];t;)tn(e,qo(t)),t=De(t);return e}:Hl,Bo=Yr;function zo(t,e,n){for(var r=-1,i=(e=Gi(e,t)).length,o=!1;++r<i;){var s=cs(e[r]);if(!(o=null!=t&&n(t,s)))break;t=t[s]}return o||++r!=i?o:!!(i=null==t?0:t.length)&&Aa(i)&&Go(s,i)&&(ma(t)||ga(t))}function Wo(t){return"function"!=typeof t.constructor||Qo(t)?{}:vr(De(t))}function Vo(t){return ma(t)||ga(t)||!!(Le&&t&&t[Le])}function Go(t,e){var n=typeof t;return!!(e=null==e?I:e)&&("number"==n||"symbol"!=n&&Xt.test(t))&&t>-1&&t%1==0&&t<e}function Xo(t,e,n){if(!ka(n))return!1;var r=typeof e;return!!("number"==r?_a(n)&&Go(e,n.length):"string"==r&&e in n)&&da(n[e],t)}function Ko(t,e){if(ma(t))return!1;var n=typeof t;return!("number"!=n&&"symbol"!=n&&"boolean"!=n&&null!=t&&!Pa(t))||Ot.test(t)||!St.test(t)||null!=e&&t in ee(e)}function Zo(t){var e=Po(t),n=hr[e];if("function"!=typeof n||!(e in yr.prototype))return!1;if(t===n)return!0;var r=Io(n);return!!r&&t===r[0]}(Qn&&Bo(new Qn(new ArrayBuffer(1)))!=ut||Yn&&Bo(new Yn)!=Z||tr&&"[object Promise]"!=Bo(tr.resolve())||er&&Bo(new er)!=nt||nr&&Bo(new nr)!=st)&&(Bo=function(t){var e=Yr(t),n=e==Y?t.constructor:o,r=n?fs(n):"";if(r)switch(r){case sr:return ut;case ar:return Z;case lr:return"[object Promise]";case ur:return nt;case cr:return st}return e});var Jo=le?$a:Bl;function Qo(t){var e=t&&t.constructor;return t===("function"==typeof e&&e.prototype||ae)}function Yo(t){return t==t&&!ka(t)}function ts(t,e){return function(n){return null!=n&&n[t]===e&&(e!==o||t in ee(n))}}function es(t,e,n){return e=Vn(e===o?t.length-1:e,0),function(){for(var i=arguments,o=-1,s=Vn(i.length-e,0),a=r(s);++o<s;)a[o]=i[e+o];o=-1;for(var l=r(e+1);++o<e;)l[o]=i[o];return l[e]=n(a),We(t,this,l)}}function ns(t,e){return e.length<2?t:Jr(t,Di(e,0,-1))}var rs=as(Ei),is=Fn||function(t,e){return Ne.setTimeout(t,e)},os=as(Si);function ss(t,e,n){var r=e+"";return os(t,function(t,e){var n=e.length;if(!n)return t;var r=n-1;return e[r]=(n>1?"& ":"")+e[r],e=e.join(n>2?", ":" "),t.replace(Lt,"{\n/* [wrapped with "+e+"] */\n")}(r,function(t,e){return Ge(M,function(n){var r="_."+n[0];e&n[1]&&!Je(t,r)&&t.push(r)}),t.sort()}(function(t){var e=t.match(Ft);return e?e[1].split(Ut):[]}(r),n)))}function as(t){var e=0,n=0;return function(){var r=Xn(),i=O-(r-n);if(n=r,i>0){if(++e>=S)return arguments[0]}else e=0;return t.apply(o,arguments)}}function ls(t,e){var n=-1,r=t.length,i=r-1;for(e=e===o?r:e;++n<e;){var s=xi(n,i),a=t[s];t[s]=t[n],t[n]=a}return t.length=e,t}var us=function(t){var e=aa(t,function(t){return n.size===c&&n.clear(),t}),n=e.cache;return e}(function(t){var e=[];return 46===t.charCodeAt(0)&&e.push(""),t.replace(Dt,function(t,n,r,i){e.push(r?i.replace(qt,"$1"):n||t)}),e});function cs(t){if("string"==typeof t||Pa(t))return t;var e=t+"";return"0"==e&&1/t==-N?"-0":e}function fs(t){if(null!=t){try{return ue.call(t)}catch(t){}try{return t+""}catch(t){}}return""}function ps(t){if(t instanceof yr)return t.clone();var e=new mr(t.__wrapped__,t.__chain__);return e.__actions__=ro(t.__actions__),e.__index__=t.__index__,e.__values__=t.__values__,e}var ds=$i(function(t,e){return ba(t)?Ur(t,Wr(e,1,ba,!0)):[]}),hs=$i(function(t,e){var n=Cs(e);return ba(n)&&(n=o),ba(t)?Ur(t,Wr(e,1,ba,!0),Lo(n,2)):[]}),vs=$i(function(t,e){var n=Cs(e);return ba(n)&&(n=o),ba(t)?Ur(t,Wr(e,1,ba,!0),o,n):[]});function gs(t,e,n){var r=null==t?0:t.length;if(!r)return-1;var i=null==n?0:qa(n);return i<0&&(i=Vn(r+i,0)),an(t,Lo(e,3),i)}function ms(t,e,n){var r=null==t?0:t.length;if(!r)return-1;var i=r-1;return n!==o&&(i=qa(n),i=n<0?Vn(r+i,0):Gn(i,r-1)),an(t,Lo(e,3),i,!0)}function ys(t){return null!=t&&t.length?Wr(t,1):[]}function _s(t){return t&&t.length?t[0]:o}var bs=$i(function(t){var e=Ye(t,Wi);return e.length&&e[0]===t[0]?ri(e):[]}),ws=$i(function(t){var e=Cs(t),n=Ye(t,Wi);return e===Cs(n)?e=o:n.pop(),n.length&&n[0]===t[0]?ri(n,Lo(e,2)):[]}),xs=$i(function(t){var e=Cs(t),n=Ye(t,Wi);return(e="function"==typeof e?e:o)&&n.pop(),n.length&&n[0]===t[0]?ri(n,o,e):[]});function Cs(t){var e=null==t?0:t.length;return e?t[e-1]:o}var $s=$i(Ts);function Ts(t,e){return t&&t.length&&e&&e.length?bi(t,e):t}var As=Do(function(t,e){var n=null==t?0:t.length,r=Ir(t,e);return wi(t,Ye(e,function(t){return Go(t,n)?+t:t}).sort(to)),r});function ks(t){return null==t?t:Jn.call(t)}var Es=$i(function(t){return Fi(Wr(t,1,ba,!0))}),Ss=$i(function(t){var e=Cs(t);return ba(e)&&(e=o),Fi(Wr(t,1,ba,!0),Lo(e,2))}),Os=$i(function(t){var e=Cs(t);return e="function"==typeof e?e:o,Fi(Wr(t,1,ba,!0),o,e)});function Ds(t){if(!t||!t.length)return[];var e=0;return t=Ze(t,function(t){if(ba(t))return e=Vn(t.length,e),!0}),gn(e,function(e){return Ye(t,pn(e))})}function js(t,e){if(!t||!t.length)return[];var n=Ds(t);return null==e?n:Ye(n,function(t){return We(e,o,t)})}var Ns=$i(function(t,e){return ba(t)?Ur(t,e):[]}),Is=$i(function(t){return Bi(Ze(t,ba))}),Ps=$i(function(t){var e=Cs(t);return ba(e)&&(e=o),Bi(Ze(t,ba),Lo(e,2))}),Rs=$i(function(t){var e=Cs(t);return e="function"==typeof e?e:o,Bi(Ze(t,ba),o,e)}),Ls=$i(Ds);var Fs=$i(function(t){var e=t.length,n=e>1?t[e-1]:o;return js(t,n="function"==typeof n?(t.pop(),n):o)});function Us(t){var e=hr(t);return e.__chain__=!0,e}function Ms(t,e){return e(t)}var qs=Do(function(t){var e=t.length,n=e?t[0]:0,r=this.__wrapped__,i=function(e){return Ir(e,t)};return!(e>1||this.__actions__.length)&&r instanceof yr&&Go(n)?((r=r.slice(n,+n+(e?1:0))).__actions__.push({func:Ms,args:[i],thisArg:o}),new mr(r,this.__chain__).thru(function(t){return e&&!t.length&&t.push(o),t})):this.thru(i)});var Hs=oo(function(t,e,n){ce.call(t,n)?++t[n]:Nr(t,n,1)});var Bs=po(gs),zs=po(ms);function Ws(t,e){return(ma(t)?Ge:Mr)(t,Lo(e,3))}function Vs(t,e){return(ma(t)?Xe:qr)(t,Lo(e,3))}var Gs=oo(function(t,e,n){ce.call(t,n)?t[n].push(e):Nr(t,n,[e])});var Xs=$i(function(t,e,n){var i=-1,o="function"==typeof e,s=_a(t)?r(t.length):[];return Mr(t,function(t){s[++i]=o?We(e,t,n):ii(t,e,n)}),s}),Ks=oo(function(t,e,n){Nr(t,n,e)});function Zs(t,e){return(ma(t)?Ye:di)(t,Lo(e,3))}var Js=oo(function(t,e,n){t[n?0:1].push(e)},function(){return[[],[]]});var Qs=$i(function(t,e){if(null==t)return[];var n=e.length;return n>1&&Xo(t,e[0],e[1])?e=[]:n>2&&Xo(e[0],e[1],e[2])&&(e=[e[0]]),yi(t,Wr(e,1),[])}),Ys=Ln||function(){return Ne.Date.now()};function ta(t,e,n){return e=n?o:e,e=t&&null==e?t.length:e,Ao(t,$,o,o,o,o,e)}function ea(t,e){var n;if("function"!=typeof e)throw new ie(l);return t=qa(t),function(){return--t>0&&(n=e.apply(this,arguments)),t<=1&&(e=o),n}}var na=$i(function(t,e,n){var r=m;if(n.length){var i=En(n,Ro(na));r|=x}return Ao(t,r,e,n,i)}),ra=$i(function(t,e,n){var r=m|y;if(n.length){var i=En(n,Ro(ra));r|=x}return Ao(e,r,t,n,i)});function ia(t,e,n){var r,i,s,a,u,c,f=0,p=!1,d=!1,h=!0;if("function"!=typeof t)throw new ie(l);function v(e){var n=r,s=i;return r=i=o,f=e,a=t.apply(s,n)}function g(t){var n=t-c;return c===o||n>=e||n<0||d&&t-f>=s}function m(){var t=Ys();if(g(t))return y(t);u=is(m,function(t){var n=e-(t-c);return d?Gn(n,s-(t-f)):n}(t))}function y(t){return u=o,h&&r?v(t):(r=i=o,a)}function _(){var t=Ys(),n=g(t);if(r=arguments,i=this,c=t,n){if(u===o)return function(t){return f=t,u=is(m,e),p?v(t):a}(c);if(d)return u=is(m,e),v(c)}return u===o&&(u=is(m,e)),a}return e=Ba(e)||0,ka(n)&&(p=!!n.leading,s=(d="maxWait"in n)?Vn(Ba(n.maxWait)||0,e):s,h="trailing"in n?!!n.trailing:h),_.cancel=function(){u!==o&&Zi(u),f=0,r=c=i=u=o},_.flush=function(){return u===o?a:y(Ys())},_}var oa=$i(function(t,e){return Fr(t,1,e)}),sa=$i(function(t,e,n){return Fr(t,Ba(e)||0,n)});function aa(t,e){if("function"!=typeof t||null!=e&&"function"!=typeof e)throw new ie(l);var n=function(){var r=arguments,i=e?e.apply(this,r):r[0],o=n.cache;if(o.has(i))return o.get(i);var s=t.apply(this,r);return n.cache=o.set(i,s)||o,s};return n.cache=new(aa.Cache||wr),n}function la(t){if("function"!=typeof t)throw new ie(l);return function(){var e=arguments;switch(e.length){case 0:return!t.call(this);case 1:return!t.call(this,e[0]);case 2:return!t.call(this,e[0],e[1]);case 3:return!t.call(this,e[0],e[1],e[2])}return!t.apply(this,e)}}aa.Cache=wr;var ua=Xi(function(t,e){var n=(e=1==e.length&&ma(e[0])?Ye(e[0],mn(Lo())):Ye(Wr(e,1),mn(Lo()))).length;return $i(function(r){for(var i=-1,o=Gn(r.length,n);++i<o;)r[i]=e[i].call(this,r[i]);return We(t,this,r)})}),ca=$i(function(t,e){var n=En(e,Ro(ca));return Ao(t,x,o,e,n)}),fa=$i(function(t,e){var n=En(e,Ro(fa));return Ao(t,C,o,e,n)}),pa=Do(function(t,e){return Ao(t,T,o,o,o,e)});function da(t,e){return t===e||t!=t&&e!=e}var ha=wo(ti),va=wo(function(t,e){return t>=e}),ga=oi(function(){return arguments}())?oi:function(t){return Ea(t)&&ce.call(t,"callee")&&!Ie.call(t,"callee")},ma=r.isArray,ya=Ue?mn(Ue):function(t){return Ea(t)&&Yr(t)==lt};function _a(t){return null!=t&&Aa(t.length)&&!$a(t)}function ba(t){return Ea(t)&&_a(t)}var wa=Hn||Bl,xa=Me?mn(Me):function(t){return Ea(t)&&Yr(t)==W};function Ca(t){if(!Ea(t))return!1;var e=Yr(t);return e==G||e==V||"string"==typeof t.message&&"string"==typeof t.name&&!Da(t)}function $a(t){if(!ka(t))return!1;var e=Yr(t);return e==X||e==K||e==B||e==tt}function Ta(t){return"number"==typeof t&&t==qa(t)}function Aa(t){return"number"==typeof t&&t>-1&&t%1==0&&t<=I}function ka(t){var e=typeof t;return null!=t&&("object"==e||"function"==e)}function Ea(t){return null!=t&&"object"==typeof t}var Sa=qe?mn(qe):function(t){return Ea(t)&&Bo(t)==Z};function Oa(t){return"number"==typeof t||Ea(t)&&Yr(t)==J}function Da(t){if(!Ea(t)||Yr(t)!=Y)return!1;var e=De(t);if(null===e)return!0;var n=ce.call(e,"constructor")&&e.constructor;return"function"==typeof n&&n instanceof n&&ue.call(n)==he}var ja=He?mn(He):function(t){return Ea(t)&&Yr(t)==et};var Na=Be?mn(Be):function(t){return Ea(t)&&Bo(t)==nt};function Ia(t){return"string"==typeof t||!ma(t)&&Ea(t)&&Yr(t)==rt}function Pa(t){return"symbol"==typeof t||Ea(t)&&Yr(t)==it}var Ra=ze?mn(ze):function(t){return Ea(t)&&Aa(t.length)&&!!Ae[Yr(t)]};var La=wo(pi),Fa=wo(function(t,e){return t<=e});function Ua(t){if(!t)return[];if(_a(t))return Ia(t)?Nn(t):ro(t);if(Fe&&t[Fe])return function(t){for(var e,n=[];!(e=t.next()).done;)n.push(e.value);return n}(t[Fe]());var e=Bo(t);return(e==Z?An:e==nt?On:dl)(t)}function Ma(t){return t?(t=Ba(t))===N||t===-N?(t<0?-1:1)*P:t==t?t:0:0===t?t:0}function qa(t){var e=Ma(t),n=e%1;return e==e?n?e-n:e:0}function Ha(t){return t?Pr(qa(t),0,L):0}function Ba(t){if("number"==typeof t)return t;if(Pa(t))return R;if(ka(t)){var e="function"==typeof t.valueOf?t.valueOf():t;t=ka(e)?e+"":e}if("string"!=typeof t)return 0===t?t:+t;t=t.replace(It,"");var n=Wt.test(t);return n||Gt.test(t)?Oe(t.slice(2),n?2:8):zt.test(t)?R:+t}function za(t){return io(t,ol(t))}function Wa(t){return null==t?"":Li(t)}var Va=so(function(t,e){if(Qo(e)||_a(e))io(e,il(e),t);else for(var n in e)ce.call(e,n)&&Sr(t,n,e[n])}),Ga=so(function(t,e){io(e,ol(e),t)}),Xa=so(function(t,e,n,r){io(e,ol(e),t,r)}),Ka=so(function(t,e,n,r){io(e,il(e),t,r)}),Za=Do(Ir);var Ja=$i(function(t,e){t=ee(t);var n=-1,r=e.length,i=r>2?e[2]:o;for(i&&Xo(e[0],e[1],i)&&(r=1);++n<r;)for(var s=e[n],a=ol(s),l=-1,u=a.length;++l<u;){var c=a[l],f=t[c];(f===o||da(f,ae[c])&&!ce.call(t,c))&&(t[c]=s[c])}return t}),Qa=$i(function(t){return t.push(o,Eo),We(al,o,t)});function Ya(t,e,n){var r=null==t?o:Jr(t,e);return r===o?n:r}function tl(t,e){return null!=t&&zo(t,e,ni)}var el=go(function(t,e,n){null!=e&&"function"!=typeof e.toString&&(e=de.call(e)),t[e]=n},kl(Ol)),nl=go(function(t,e,n){null!=e&&"function"!=typeof e.toString&&(e=de.call(e)),ce.call(t,e)?t[e].push(n):t[e]=[n]},Lo),rl=$i(ii);function il(t){return _a(t)?$r(t):ci(t)}function ol(t){return _a(t)?$r(t,!0):fi(t)}var sl=so(function(t,e,n){gi(t,e,n)}),al=so(function(t,e,n,r){gi(t,e,n,r)}),ll=Do(function(t,e){var n={};if(null==t)return n;var r=!1;e=Ye(e,function(e){return e=Gi(e,t),r||(r=e.length>1),e}),io(t,No(t),n),r&&(n=Rr(n,p|d|h,So));for(var i=e.length;i--;)Ui(n,e[i]);return n});var ul=Do(function(t,e){return null==t?{}:function(t,e){return _i(t,e,function(e,n){return tl(t,n)})}(t,e)});function cl(t,e){if(null==t)return{};var n=Ye(No(t),function(t){return[t]});return e=Lo(e),_i(t,n,function(t,n){return e(t,n[0])})}var fl=To(il),pl=To(ol);function dl(t){return null==t?[]:yn(t,il(t))}var hl=co(function(t,e,n){return e=e.toLowerCase(),t+(n?vl(e):e)});function vl(t){return Cl(Wa(t).toLowerCase())}function gl(t){return(t=Wa(t))&&t.replace(Kt,xn).replace(_e,"")}var ml=co(function(t,e,n){return t+(n?"-":"")+e.toLowerCase()}),yl=co(function(t,e,n){return t+(n?" ":"")+e.toLowerCase()}),_l=uo("toLowerCase");var bl=co(function(t,e,n){return t+(n?"_":"")+e.toLowerCase()});var wl=co(function(t,e,n){return t+(n?" ":"")+Cl(e)});var xl=co(function(t,e,n){return t+(n?" ":"")+e.toUpperCase()}),Cl=uo("toUpperCase");function $l(t,e,n){return t=Wa(t),(e=n?o:e)===o?function(t){return Ce.test(t)}(t)?function(t){return t.match(we)||[]}(t):function(t){return t.match(Mt)||[]}(t):t.match(e)||[]}var Tl=$i(function(t,e){try{return We(t,o,e)}catch(t){return Ca(t)?t:new Qt(t)}}),Al=Do(function(t,e){return Ge(e,function(e){e=cs(e),Nr(t,e,na(t[e],t))}),t});function kl(t){return function(){return t}}var El=ho(),Sl=ho(!0);function Ol(t){return t}function Dl(t){return ui("function"==typeof t?t:Rr(t,p))}var jl=$i(function(t,e){return function(n){return ii(n,t,e)}}),Nl=$i(function(t,e){return function(n){return ii(t,n,e)}});function Il(t,e,n){var r=il(e),i=Zr(e,r);null!=n||ka(e)&&(i.length||!r.length)||(n=e,e=t,t=this,i=Zr(e,il(e)));var o=!(ka(n)&&"chain"in n&&!n.chain),s=$a(t);return Ge(i,function(n){var r=e[n];t[n]=r,s&&(t.prototype[n]=function(){var e=this.__chain__;if(o||e){var n=t(this.__wrapped__);return(n.__actions__=ro(this.__actions__)).push({func:r,args:arguments,thisArg:t}),n.__chain__=e,n}return r.apply(t,tn([this.value()],arguments))})}),t}function Pl(){}var Rl=yo(Ye),Ll=yo(Ke),Fl=yo(rn);function Ul(t){return Ko(t)?pn(cs(t)):function(t){return function(e){return Jr(e,t)}}(t)}var Ml=bo(),ql=bo(!0);function Hl(){return[]}function Bl(){return!1}var zl=mo(function(t,e){return t+e},0),Wl=Co("ceil"),Vl=mo(function(t,e){return t/e},1),Gl=Co("floor");var Xl,Kl=mo(function(t,e){return t*e},1),Zl=Co("round"),Jl=mo(function(t,e){return t-e},0);return hr.after=function(t,e){if("function"!=typeof e)throw new ie(l);return t=qa(t),function(){if(--t<1)return e.apply(this,arguments)}},hr.ary=ta,hr.assign=Va,hr.assignIn=Ga,hr.assignInWith=Xa,hr.assignWith=Ka,hr.at=Za,hr.before=ea,hr.bind=na,hr.bindAll=Al,hr.bindKey=ra,hr.castArray=function(){if(!arguments.length)return[];var t=arguments[0];return ma(t)?t:[t]},hr.chain=Us,hr.chunk=function(t,e,n){e=(n?Xo(t,e,n):e===o)?1:Vn(qa(e),0);var i=null==t?0:t.length;if(!i||e<1)return[];for(var s=0,a=0,l=r(Un(i/e));s<i;)l[a++]=Di(t,s,s+=e);return l},hr.compact=function(t){for(var e=-1,n=null==t?0:t.length,r=0,i=[];++e<n;){var o=t[e];o&&(i[r++]=o)}return i},hr.concat=function(){var t=arguments.length;if(!t)return[];for(var e=r(t-1),n=arguments[0],i=t;i--;)e[i-1]=arguments[i];return tn(ma(n)?ro(n):[n],Wr(e,1))},hr.cond=function(t){var e=null==t?0:t.length,n=Lo();return t=e?Ye(t,function(t){if("function"!=typeof t[1])throw new ie(l);return[n(t[0]),t[1]]}):[],$i(function(n){for(var r=-1;++r<e;){var i=t[r];if(We(i[0],this,n))return We(i[1],this,n)}})},hr.conforms=function(t){return function(t){var e=il(t);return function(n){return Lr(n,t,e)}}(Rr(t,p))},hr.constant=kl,hr.countBy=Hs,hr.create=function(t,e){var n=vr(t);return null==e?n:jr(n,e)},hr.curry=function t(e,n,r){var i=Ao(e,b,o,o,o,o,o,n=r?o:n);return i.placeholder=t.placeholder,i},hr.curryRight=function t(e,n,r){var i=Ao(e,w,o,o,o,o,o,n=r?o:n);return i.placeholder=t.placeholder,i},hr.debounce=ia,hr.defaults=Ja,hr.defaultsDeep=Qa,hr.defer=oa,hr.delay=sa,hr.difference=ds,hr.differenceBy=hs,hr.differenceWith=vs,hr.drop=function(t,e,n){var r=null==t?0:t.length;return r?Di(t,(e=n||e===o?1:qa(e))<0?0:e,r):[]},hr.dropRight=function(t,e,n){var r=null==t?0:t.length;return r?Di(t,0,(e=r-(e=n||e===o?1:qa(e)))<0?0:e):[]},hr.dropRightWhile=function(t,e){return t&&t.length?qi(t,Lo(e,3),!0,!0):[]},hr.dropWhile=function(t,e){return t&&t.length?qi(t,Lo(e,3),!0):[]},hr.fill=function(t,e,n,r){var i=null==t?0:t.length;return i?(n&&"number"!=typeof n&&Xo(t,e,n)&&(n=0,r=i),function(t,e,n,r){var i=t.length;for((n=qa(n))<0&&(n=-n>i?0:i+n),(r=r===o||r>i?i:qa(r))<0&&(r+=i),r=n>r?0:Ha(r);n<r;)t[n++]=e;return t}(t,e,n,r)):[]},hr.filter=function(t,e){return(ma(t)?Ze:zr)(t,Lo(e,3))},hr.flatMap=function(t,e){return Wr(Zs(t,e),1)},hr.flatMapDeep=function(t,e){return Wr(Zs(t,e),N)},hr.flatMapDepth=function(t,e,n){return n=n===o?1:qa(n),Wr(Zs(t,e),n)},hr.flatten=ys,hr.flattenDeep=function(t){return null!=t&&t.length?Wr(t,N):[]},hr.flattenDepth=function(t,e){return null!=t&&t.length?Wr(t,e=e===o?1:qa(e)):[]},hr.flip=function(t){return Ao(t,A)},hr.flow=El,hr.flowRight=Sl,hr.fromPairs=function(t){for(var e=-1,n=null==t?0:t.length,r={};++e<n;){var i=t[e];r[i[0]]=i[1]}return r},hr.functions=function(t){return null==t?[]:Zr(t,il(t))},hr.functionsIn=function(t){return null==t?[]:Zr(t,ol(t))},hr.groupBy=Gs,hr.initial=function(t){return null!=t&&t.length?Di(t,0,-1):[]},hr.intersection=bs,hr.intersectionBy=ws,hr.intersectionWith=xs,hr.invert=el,hr.invertBy=nl,hr.invokeMap=Xs,hr.iteratee=Dl,hr.keyBy=Ks,hr.keys=il,hr.keysIn=ol,hr.map=Zs,hr.mapKeys=function(t,e){var n={};return e=Lo(e,3),Xr(t,function(t,r,i){Nr(n,e(t,r,i),t)}),n},hr.mapValues=function(t,e){var n={};return e=Lo(e,3),Xr(t,function(t,r,i){Nr(n,r,e(t,r,i))}),n},hr.matches=function(t){return hi(Rr(t,p))},hr.matchesProperty=function(t,e){return vi(t,Rr(e,p))},hr.memoize=aa,hr.merge=sl,hr.mergeWith=al,hr.method=jl,hr.methodOf=Nl,hr.mixin=Il,hr.negate=la,hr.nthArg=function(t){return t=qa(t),$i(function(e){return mi(e,t)})},hr.omit=ll,hr.omitBy=function(t,e){return cl(t,la(Lo(e)))},hr.once=function(t){return ea(2,t)},hr.orderBy=function(t,e,n,r){return null==t?[]:(ma(e)||(e=null==e?[]:[e]),ma(n=r?o:n)||(n=null==n?[]:[n]),yi(t,e,n))},hr.over=Rl,hr.overArgs=ua,hr.overEvery=Ll,hr.overSome=Fl,hr.partial=ca,hr.partialRight=fa,hr.partition=Js,hr.pick=ul,hr.pickBy=cl,hr.property=Ul,hr.propertyOf=function(t){return function(e){return null==t?o:Jr(t,e)}},hr.pull=$s,hr.pullAll=Ts,hr.pullAllBy=function(t,e,n){return t&&t.length&&e&&e.length?bi(t,e,Lo(n,2)):t},hr.pullAllWith=function(t,e,n){return t&&t.length&&e&&e.length?bi(t,e,o,n):t},hr.pullAt=As,hr.range=Ml,hr.rangeRight=ql,hr.rearg=pa,hr.reject=function(t,e){return(ma(t)?Ze:zr)(t,la(Lo(e,3)))},hr.remove=function(t,e){var n=[];if(!t||!t.length)return n;var r=-1,i=[],o=t.length;for(e=Lo(e,3);++r<o;){var s=t[r];e(s,r,t)&&(n.push(s),i.push(r))}return wi(t,i),n},hr.rest=function(t,e){if("function"!=typeof t)throw new ie(l);return $i(t,e=e===o?e:qa(e))},hr.reverse=ks,hr.sampleSize=function(t,e,n){return e=(n?Xo(t,e,n):e===o)?1:qa(e),(ma(t)?Ar:Ai)(t,e)},hr.set=function(t,e,n){return null==t?t:ki(t,e,n)},hr.setWith=function(t,e,n,r){return r="function"==typeof r?r:o,null==t?t:ki(t,e,n,r)},hr.shuffle=function(t){return(ma(t)?kr:Oi)(t)},hr.slice=function(t,e,n){var r=null==t?0:t.length;return r?(n&&"number"!=typeof n&&Xo(t,e,n)?(e=0,n=r):(e=null==e?0:qa(e),n=n===o?r:qa(n)),Di(t,e,n)):[]},hr.sortBy=Qs,hr.sortedUniq=function(t){return t&&t.length?Pi(t):[]},hr.sortedUniqBy=function(t,e){return t&&t.length?Pi(t,Lo(e,2)):[]},hr.split=function(t,e,n){return n&&"number"!=typeof n&&Xo(t,e,n)&&(e=n=o),(n=n===o?L:n>>>0)?(t=Wa(t))&&("string"==typeof e||null!=e&&!ja(e))&&!(e=Li(e))&&Tn(t)?Ki(Nn(t),0,n):t.split(e,n):[]},hr.spread=function(t,e){if("function"!=typeof t)throw new ie(l);return e=null==e?0:Vn(qa(e),0),$i(function(n){var r=n[e],i=Ki(n,0,e);return r&&tn(i,r),We(t,this,i)})},hr.tail=function(t){var e=null==t?0:t.length;return e?Di(t,1,e):[]},hr.take=function(t,e,n){return t&&t.length?Di(t,0,(e=n||e===o?1:qa(e))<0?0:e):[]},hr.takeRight=function(t,e,n){var r=null==t?0:t.length;return r?Di(t,(e=r-(e=n||e===o?1:qa(e)))<0?0:e,r):[]},hr.takeRightWhile=function(t,e){return t&&t.length?qi(t,Lo(e,3),!1,!0):[]},hr.takeWhile=function(t,e){return t&&t.length?qi(t,Lo(e,3)):[]},hr.tap=function(t,e){return e(t),t},hr.throttle=function(t,e,n){var r=!0,i=!0;if("function"!=typeof t)throw new ie(l);return ka(n)&&(r="leading"in n?!!n.leading:r,i="trailing"in n?!!n.trailing:i),ia(t,e,{leading:r,maxWait:e,trailing:i})},hr.thru=Ms,hr.toArray=Ua,hr.toPairs=fl,hr.toPairsIn=pl,hr.toPath=function(t){return ma(t)?Ye(t,cs):Pa(t)?[t]:ro(us(Wa(t)))},hr.toPlainObject=za,hr.transform=function(t,e,n){var r=ma(t),i=r||wa(t)||Ra(t);if(e=Lo(e,4),null==n){var o=t&&t.constructor;n=i?r?new o:[]:ka(t)&&$a(o)?vr(De(t)):{}}return(i?Ge:Xr)(t,function(t,r,i){return e(n,t,r,i)}),n},hr.unary=function(t){return ta(t,1)},hr.union=Es,hr.unionBy=Ss,hr.unionWith=Os,hr.uniq=function(t){return t&&t.length?Fi(t):[]},hr.uniqBy=function(t,e){return t&&t.length?Fi(t,Lo(e,2)):[]},hr.uniqWith=function(t,e){return e="function"==typeof e?e:o,t&&t.length?Fi(t,o,e):[]},hr.unset=function(t,e){return null==t||Ui(t,e)},hr.unzip=Ds,hr.unzipWith=js,hr.update=function(t,e,n){return null==t?t:Mi(t,e,Vi(n))},hr.updateWith=function(t,e,n,r){return r="function"==typeof r?r:o,null==t?t:Mi(t,e,Vi(n),r)},hr.values=dl,hr.valuesIn=function(t){return null==t?[]:yn(t,ol(t))},hr.without=Ns,hr.words=$l,hr.wrap=function(t,e){return ca(Vi(e),t)},hr.xor=Is,hr.xorBy=Ps,hr.xorWith=Rs,hr.zip=Ls,hr.zipObject=function(t,e){return zi(t||[],e||[],Sr)},hr.zipObjectDeep=function(t,e){return zi(t||[],e||[],ki)},hr.zipWith=Fs,hr.entries=fl,hr.entriesIn=pl,hr.extend=Ga,hr.extendWith=Xa,Il(hr,hr),hr.add=zl,hr.attempt=Tl,hr.camelCase=hl,hr.capitalize=vl,hr.ceil=Wl,hr.clamp=function(t,e,n){return n===o&&(n=e,e=o),n!==o&&(n=(n=Ba(n))==n?n:0),e!==o&&(e=(e=Ba(e))==e?e:0),Pr(Ba(t),e,n)},hr.clone=function(t){return Rr(t,h)},hr.cloneDeep=function(t){return Rr(t,p|h)},hr.cloneDeepWith=function(t,e){return Rr(t,p|h,e="function"==typeof e?e:o)},hr.cloneWith=function(t,e){return Rr(t,h,e="function"==typeof e?e:o)},hr.conformsTo=function(t,e){return null==e||Lr(t,e,il(e))},hr.deburr=gl,hr.defaultTo=function(t,e){return null==t||t!=t?e:t},hr.divide=Vl,hr.endsWith=function(t,e,n){t=Wa(t),e=Li(e);var r=t.length,i=n=n===o?r:Pr(qa(n),0,r);return(n-=e.length)>=0&&t.slice(n,i)==e},hr.eq=da,hr.escape=function(t){return(t=Wa(t))&&Tt.test(t)?t.replace(Ct,Cn):t},hr.escapeRegExp=function(t){return(t=Wa(t))&&Nt.test(t)?t.replace(jt,"\\$&"):t},hr.every=function(t,e,n){var r=ma(t)?Ke:Hr;return n&&Xo(t,e,n)&&(e=o),r(t,Lo(e,3))},hr.find=Bs,hr.findIndex=gs,hr.findKey=function(t,e){return sn(t,Lo(e,3),Xr)},hr.findLast=zs,hr.findLastIndex=ms,hr.findLastKey=function(t,e){return sn(t,Lo(e,3),Kr)},hr.floor=Gl,hr.forEach=Ws,hr.forEachRight=Vs,hr.forIn=function(t,e){return null==t?t:Vr(t,Lo(e,3),ol)},hr.forInRight=function(t,e){return null==t?t:Gr(t,Lo(e,3),ol)},hr.forOwn=function(t,e){return t&&Xr(t,Lo(e,3))},hr.forOwnRight=function(t,e){return t&&Kr(t,Lo(e,3))},hr.get=Ya,hr.gt=ha,hr.gte=va,hr.has=function(t,e){return null!=t&&zo(t,e,ei)},hr.hasIn=tl,hr.head=_s,hr.identity=Ol,hr.includes=function(t,e,n,r){t=_a(t)?t:dl(t),n=n&&!r?qa(n):0;var i=t.length;return n<0&&(n=Vn(i+n,0)),Ia(t)?n<=i&&t.indexOf(e,n)>-1:!!i&&ln(t,e,n)>-1},hr.indexOf=function(t,e,n){var r=null==t?0:t.length;if(!r)return-1;var i=null==n?0:qa(n);return i<0&&(i=Vn(r+i,0)),ln(t,e,i)},hr.inRange=function(t,e,n){return e=Ma(e),n===o?(n=e,e=0):n=Ma(n),function(t,e,n){return t>=Gn(e,n)&&t<Vn(e,n)}(t=Ba(t),e,n)},hr.invoke=rl,hr.isArguments=ga,hr.isArray=ma,hr.isArrayBuffer=ya,hr.isArrayLike=_a,hr.isArrayLikeObject=ba,hr.isBoolean=function(t){return!0===t||!1===t||Ea(t)&&Yr(t)==z},hr.isBuffer=wa,hr.isDate=xa,hr.isElement=function(t){return Ea(t)&&1===t.nodeType&&!Da(t)},hr.isEmpty=function(t){if(null==t)return!0;if(_a(t)&&(ma(t)||"string"==typeof t||"function"==typeof t.splice||wa(t)||Ra(t)||ga(t)))return!t.length;var e=Bo(t);if(e==Z||e==nt)return!t.size;if(Qo(t))return!ci(t).length;for(var n in t)if(ce.call(t,n))return!1;return!0},hr.isEqual=function(t,e){return si(t,e)},hr.isEqualWith=function(t,e,n){var r=(n="function"==typeof n?n:o)?n(t,e):o;return r===o?si(t,e,o,n):!!r},hr.isError=Ca,hr.isFinite=function(t){return"number"==typeof t&&Bn(t)},hr.isFunction=$a,hr.isInteger=Ta,hr.isLength=Aa,hr.isMap=Sa,hr.isMatch=function(t,e){return t===e||ai(t,e,Uo(e))},hr.isMatchWith=function(t,e,n){return n="function"==typeof n?n:o,ai(t,e,Uo(e),n)},hr.isNaN=function(t){return Oa(t)&&t!=+t},hr.isNative=function(t){if(Jo(t))throw new Qt(a);return li(t)},hr.isNil=function(t){return null==t},hr.isNull=function(t){return null===t},hr.isNumber=Oa,hr.isObject=ka,hr.isObjectLike=Ea,hr.isPlainObject=Da,hr.isRegExp=ja,hr.isSafeInteger=function(t){return Ta(t)&&t>=-I&&t<=I},hr.isSet=Na,hr.isString=Ia,hr.isSymbol=Pa,hr.isTypedArray=Ra,hr.isUndefined=function(t){return t===o},hr.isWeakMap=function(t){return Ea(t)&&Bo(t)==st},hr.isWeakSet=function(t){return Ea(t)&&Yr(t)==at},hr.join=function(t,e){return null==t?"":zn.call(t,e)},hr.kebabCase=ml,hr.last=Cs,hr.lastIndexOf=function(t,e,n){var r=null==t?0:t.length;if(!r)return-1;var i=r;return n!==o&&(i=(i=qa(n))<0?Vn(r+i,0):Gn(i,r-1)),e==e?function(t,e,n){for(var r=n+1;r--;)if(t[r]===e)return r;return r}(t,e,i):an(t,cn,i,!0)},hr.lowerCase=yl,hr.lowerFirst=_l,hr.lt=La,hr.lte=Fa,hr.max=function(t){return t&&t.length?Br(t,Ol,ti):o},hr.maxBy=function(t,e){return t&&t.length?Br(t,Lo(e,2),ti):o},hr.mean=function(t){return fn(t,Ol)},hr.meanBy=function(t,e){return fn(t,Lo(e,2))},hr.min=function(t){return t&&t.length?Br(t,Ol,pi):o},hr.minBy=function(t,e){return t&&t.length?Br(t,Lo(e,2),pi):o},hr.stubArray=Hl,hr.stubFalse=Bl,hr.stubObject=function(){return{}},hr.stubString=function(){return""},hr.stubTrue=function(){return!0},hr.multiply=Kl,hr.nth=function(t,e){return t&&t.length?mi(t,qa(e)):o},hr.noConflict=function(){return Ne._===this&&(Ne._=ve),this},hr.noop=Pl,hr.now=Ys,hr.pad=function(t,e,n){t=Wa(t);var r=(e=qa(e))?jn(t):0;if(!e||r>=e)return t;var i=(e-r)/2;return _o(Mn(i),n)+t+_o(Un(i),n)},hr.padEnd=function(t,e,n){t=Wa(t);var r=(e=qa(e))?jn(t):0;return e&&r<e?t+_o(e-r,n):t},hr.padStart=function(t,e,n){t=Wa(t);var r=(e=qa(e))?jn(t):0;return e&&r<e?_o(e-r,n)+t:t},hr.parseInt=function(t,e,n){return n||null==e?e=0:e&&(e=+e),Kn(Wa(t).replace(Pt,""),e||0)},hr.random=function(t,e,n){if(n&&"boolean"!=typeof n&&Xo(t,e,n)&&(e=n=o),n===o&&("boolean"==typeof e?(n=e,e=o):"boolean"==typeof t&&(n=t,t=o)),t===o&&e===o?(t=0,e=1):(t=Ma(t),e===o?(e=t,t=0):e=Ma(e)),t>e){var r=t;t=e,e=r}if(n||t%1||e%1){var i=Zn();return Gn(t+i*(e-t+Se("1e-"+((i+"").length-1))),e)}return xi(t,e)},hr.reduce=function(t,e,n){var r=ma(t)?en:hn,i=arguments.length<3;return r(t,Lo(e,4),n,i,Mr)},hr.reduceRight=function(t,e,n){var r=ma(t)?nn:hn,i=arguments.length<3;return r(t,Lo(e,4),n,i,qr)},hr.repeat=function(t,e,n){return e=(n?Xo(t,e,n):e===o)?1:qa(e),Ci(Wa(t),e)},hr.replace=function(){var t=arguments,e=Wa(t[0]);return t.length<3?e:e.replace(t[1],t[2])},hr.result=function(t,e,n){var r=-1,i=(e=Gi(e,t)).length;for(i||(i=1,t=o);++r<i;){var s=null==t?o:t[cs(e[r])];s===o&&(r=i,s=n),t=$a(s)?s.call(t):s}return t},hr.round=Zl,hr.runInContext=t,hr.sample=function(t){return(ma(t)?Tr:Ti)(t)},hr.size=function(t){if(null==t)return 0;if(_a(t))return Ia(t)?jn(t):t.length;var e=Bo(t);return e==Z||e==nt?t.size:ci(t).length},hr.snakeCase=bl,hr.some=function(t,e,n){var r=ma(t)?rn:ji;return n&&Xo(t,e,n)&&(e=o),r(t,Lo(e,3))},hr.sortedIndex=function(t,e){return Ni(t,e)},hr.sortedIndexBy=function(t,e,n){return Ii(t,e,Lo(n,2))},hr.sortedIndexOf=function(t,e){var n=null==t?0:t.length;if(n){var r=Ni(t,e);if(r<n&&da(t[r],e))return r}return-1},hr.sortedLastIndex=function(t,e){return Ni(t,e,!0)},hr.sortedLastIndexBy=function(t,e,n){return Ii(t,e,Lo(n,2),!0)},hr.sortedLastIndexOf=function(t,e){if(null!=t&&t.length){var n=Ni(t,e,!0)-1;if(da(t[n],e))return n}return-1},hr.startCase=wl,hr.startsWith=function(t,e,n){return t=Wa(t),n=null==n?0:Pr(qa(n),0,t.length),e=Li(e),t.slice(n,n+e.length)==e},hr.subtract=Jl,hr.sum=function(t){return t&&t.length?vn(t,Ol):0},hr.sumBy=function(t,e){return t&&t.length?vn(t,Lo(e,2)):0},hr.template=function(t,e,n){var r=hr.templateSettings;n&&Xo(t,e,n)&&(e=o),t=Wa(t),e=Xa({},e,r,ko);var i,s,a=Xa({},e.imports,r.imports,ko),l=il(a),u=yn(a,l),c=0,f=e.interpolate||Zt,p="__p += '",d=ne((e.escape||Zt).source+"|"+f.source+"|"+(f===Et?Ht:Zt).source+"|"+(e.evaluate||Zt).source+"|$","g"),h="//# sourceURL="+("sourceURL"in e?e.sourceURL:"lodash.templateSources["+ ++Te+"]")+"\n";t.replace(d,function(e,n,r,o,a,l){return r||(r=o),p+=t.slice(c,l).replace(Jt,$n),n&&(i=!0,p+="' +\n__e("+n+") +\n'"),a&&(s=!0,p+="';\n"+a+";\n__p += '"),r&&(p+="' +\n((__t = ("+r+")) == null ? '' : __t) +\n'"),c=l+e.length,e}),p+="';\n";var v=e.variable;v||(p="with (obj) {\n"+p+"\n}\n"),p=(s?p.replace(_t,""):p).replace(bt,"$1").replace(wt,"$1;"),p="function("+(v||"obj")+") {\n"+(v?"":"obj || (obj = {});\n")+"var __t, __p = ''"+(i?", __e = _.escape":"")+(s?", __j = Array.prototype.join;\nfunction print() { __p += __j.call(arguments, '') }\n":";\n")+p+"return __p\n}";var g=Tl(function(){return Yt(l,h+"return "+p).apply(o,u)});if(g.source=p,Ca(g))throw g;return g},hr.times=function(t,e){if((t=qa(t))<1||t>I)return[];var n=L,r=Gn(t,L);e=Lo(e),t-=L;for(var i=gn(r,e);++n<t;)e(n);return i},hr.toFinite=Ma,hr.toInteger=qa,hr.toLength=Ha,hr.toLower=function(t){return Wa(t).toLowerCase()},hr.toNumber=Ba,hr.toSafeInteger=function(t){return t?Pr(qa(t),-I,I):0===t?t:0},hr.toString=Wa,hr.toUpper=function(t){return Wa(t).toUpperCase()},hr.trim=function(t,e,n){if((t=Wa(t))&&(n||e===o))return t.replace(It,"");if(!t||!(e=Li(e)))return t;var r=Nn(t),i=Nn(e);return Ki(r,bn(r,i),wn(r,i)+1).join("")},hr.trimEnd=function(t,e,n){if((t=Wa(t))&&(n||e===o))return t.replace(Rt,"");if(!t||!(e=Li(e)))return t;var r=Nn(t);return Ki(r,0,wn(r,Nn(e))+1).join("")},hr.trimStart=function(t,e,n){if((t=Wa(t))&&(n||e===o))return t.replace(Pt,"");if(!t||!(e=Li(e)))return t;var r=Nn(t);return Ki(r,bn(r,Nn(e))).join("")},hr.truncate=function(t,e){var n=k,r=E;if(ka(e)){var i="separator"in e?e.separator:i;n="length"in e?qa(e.length):n,r="omission"in e?Li(e.omission):r}var s=(t=Wa(t)).length;if(Tn(t)){var a=Nn(t);s=a.length}if(n>=s)return t;var l=n-jn(r);if(l<1)return r;var u=a?Ki(a,0,l).join(""):t.slice(0,l);if(i===o)return u+r;if(a&&(l+=u.length-l),ja(i)){if(t.slice(l).search(i)){var c,f=u;for(i.global||(i=ne(i.source,Wa(Bt.exec(i))+"g")),i.lastIndex=0;c=i.exec(f);)var p=c.index;u=u.slice(0,p===o?l:p)}}else if(t.indexOf(Li(i),l)!=l){var d=u.lastIndexOf(i);d>-1&&(u=u.slice(0,d))}return u+r},hr.unescape=function(t){return(t=Wa(t))&&$t.test(t)?t.replace(xt,In):t},hr.uniqueId=function(t){var e=++fe;return Wa(t)+e},hr.upperCase=xl,hr.upperFirst=Cl,hr.each=Ws,hr.eachRight=Vs,hr.first=_s,Il(hr,(Xl={},Xr(hr,function(t,e){ce.call(hr.prototype,e)||(Xl[e]=t)}),Xl),{chain:!1}),hr.VERSION="4.17.5",Ge(["bind","bindKey","curry","curryRight","partial","partialRight"],function(t){hr[t].placeholder=hr}),Ge(["drop","take"],function(t,e){yr.prototype[t]=function(n){n=n===o?1:Vn(qa(n),0);var r=this.__filtered__&&!e?new yr(this):this.clone();return r.__filtered__?r.__takeCount__=Gn(n,r.__takeCount__):r.__views__.push({size:Gn(n,L),type:t+(r.__dir__<0?"Right":"")}),r},yr.prototype[t+"Right"]=function(e){return this.reverse()[t](e).reverse()}}),Ge(["filter","map","takeWhile"],function(t,e){var n=e+1,r=n==D||3==n;yr.prototype[t]=function(t){var e=this.clone();return e.__iteratees__.push({iteratee:Lo(t,3),type:n}),e.__filtered__=e.__filtered__||r,e}}),Ge(["head","last"],function(t,e){var n="take"+(e?"Right":"");yr.prototype[t]=function(){return this[n](1).value()[0]}}),Ge(["initial","tail"],function(t,e){var n="drop"+(e?"":"Right");yr.prototype[t]=function(){return this.__filtered__?new yr(this):this[n](1)}}),yr.prototype.compact=function(){return this.filter(Ol)},yr.prototype.find=function(t){return this.filter(t).head()},yr.prototype.findLast=function(t){return this.reverse().find(t)},yr.prototype.invokeMap=$i(function(t,e){return"function"==typeof t?new yr(this):this.map(function(n){return ii(n,t,e)})}),yr.prototype.reject=function(t){return this.filter(la(Lo(t)))},yr.prototype.slice=function(t,e){t=qa(t);var n=this;return n.__filtered__&&(t>0||e<0)?new yr(n):(t<0?n=n.takeRight(-t):t&&(n=n.drop(t)),e!==o&&(n=(e=qa(e))<0?n.dropRight(-e):n.take(e-t)),n)},yr.prototype.takeRightWhile=function(t){return this.reverse().takeWhile(t).reverse()},yr.prototype.toArray=function(){return this.take(L)},Xr(yr.prototype,function(t,e){var n=/^(?:filter|find|map|reject)|While$/.test(e),r=/^(?:head|last)$/.test(e),i=hr[r?"take"+("last"==e?"Right":""):e],s=r||/^find/.test(e);i&&(hr.prototype[e]=function(){var e=this.__wrapped__,a=r?[1]:arguments,l=e instanceof yr,u=a[0],c=l||ma(e),f=function(t){var e=i.apply(hr,tn([t],a));return r&&p?e[0]:e};c&&n&&"function"==typeof u&&1!=u.length&&(l=c=!1);var p=this.__chain__,d=!!this.__actions__.length,h=s&&!p,v=l&&!d;if(!s&&c){e=v?e:new yr(this);var g=t.apply(e,a);return g.__actions__.push({func:Ms,args:[f],thisArg:o}),new mr(g,p)}return h&&v?t.apply(this,a):(g=this.thru(f),h?r?g.value()[0]:g.value():g)})}),Ge(["pop","push","shift","sort","splice","unshift"],function(t){var e=oe[t],n=/^(?:push|sort|unshift)$/.test(t)?"tap":"thru",r=/^(?:pop|shift)$/.test(t);hr.prototype[t]=function(){var t=arguments;if(r&&!this.__chain__){var i=this.value();return e.apply(ma(i)?i:[],t)}return this[n](function(n){return e.apply(ma(n)?n:[],t)})}}),Xr(yr.prototype,function(t,e){var n=hr[e];if(n){var r=n.name+"";(or[r]||(or[r]=[])).push({name:e,func:n})}}),or[vo(o,y).name]=[{name:"wrapper",func:o}],yr.prototype.clone=function(){var t=new yr(this.__wrapped__);return t.__actions__=ro(this.__actions__),t.__dir__=this.__dir__,t.__filtered__=this.__filtered__,t.__iteratees__=ro(this.__iteratees__),t.__takeCount__=this.__takeCount__,t.__views__=ro(this.__views__),t},yr.prototype.reverse=function(){if(this.__filtered__){var t=new yr(this);t.__dir__=-1,t.__filtered__=!0}else(t=this.clone()).__dir__*=-1;return t},yr.prototype.value=function(){var t=this.__wrapped__.value(),e=this.__dir__,n=ma(t),r=e<0,i=n?t.length:0,o=function(t,e,n){for(var r=-1,i=n.length;++r<i;){var o=n[r],s=o.size;switch(o.type){case"drop":t+=s;break;case"dropRight":e-=s;break;case"take":e=Gn(e,t+s);break;case"takeRight":t=Vn(t,e-s)}}return{start:t,end:e}}(0,i,this.__views__),s=o.start,a=o.end,l=a-s,u=r?a:s-1,c=this.__iteratees__,f=c.length,p=0,d=Gn(l,this.__takeCount__);if(!n||!r&&i==l&&d==l)return Hi(t,this.__actions__);var h=[];t:for(;l--&&p<d;){for(var v=-1,g=t[u+=e];++v<f;){var m=c[v],y=m.iteratee,_=m.type,b=y(g);if(_==j)g=b;else if(!b){if(_==D)continue t;break t}}h[p++]=g}return h},hr.prototype.at=qs,hr.prototype.chain=function(){return Us(this)},hr.prototype.commit=function(){return new mr(this.value(),this.__chain__)},hr.prototype.next=function(){this.__values__===o&&(this.__values__=Ua(this.value()));var t=this.__index__>=this.__values__.length;return{done:t,value:t?o:this.__values__[this.__index__++]}},hr.prototype.plant=function(t){for(var e,n=this;n instanceof gr;){var r=ps(n);r.__index__=0,r.__values__=o,e?i.__wrapped__=r:e=r;var i=r;n=n.__wrapped__}return i.__wrapped__=t,e},hr.prototype.reverse=function(){var t=this.__wrapped__;if(t instanceof yr){var e=t;return this.__actions__.length&&(e=new yr(this)),(e=e.reverse()).__actions__.push({func:Ms,args:[ks],thisArg:o}),new mr(e,this.__chain__)}return this.thru(ks)},hr.prototype.toJSON=hr.prototype.valueOf=hr.prototype.value=function(){return Hi(this.__wrapped__,this.__actions__)},hr.prototype.first=hr.prototype.head,Fe&&(hr.prototype[Fe]=function(){return this}),hr}();Ne._=Pn,(i=function(){return Pn}.call(e,n,e,r))===o||(r.exports=i)}).call(this)}).call(e,n("DuR2"),n("3IRH")(t))},NYlw:function(t,e,n){var r=n("VU/8")(n("5F58"),null,!1,null,null,null);t.exports=r.exports},P4DF:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,"",""])},Pq8s:function(t,e){},TNGo:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),n("hv7s"),e.default={props:["options","value"],mounted:function(){var t=this;$(this.$el).select2({data:this.options}).on("change",function(){t.$emit("input",this.value)}).val(this.value).trigger("change")},watch:{value:function(t){$(this.$el).val(t)},options:function(t){var e=this;$(this.$el).select2("destroy").empty().select2({data:t}).on("change",function(){e.$emit("input",this.value)}).val(this.value).trigger("change")},destroyed:function(){$(this.$el).off().select2("destroy")}}}},UZ9c:function(t,e,n){var r,i,o,s;s=function(t){return t.ui=t.ui||{},t.ui.version="1.12.1"},i=[n("7t+N")],void 0===(o="function"==typeof(r=s)?r.apply(e,i):r)||(t.exports=o)},"VU/8":function(t,e){t.exports=function(t,e,n,r,i,o){var s,a=t=t||{},l=typeof t.default;"object"!==l&&"function"!==l||(s=t,a=t.default);var u,c="function"==typeof a?a.options:a;if(e&&(c.render=e.render,c.staticRenderFns=e.staticRenderFns,c._compiled=!0),n&&(c.functional=!0),i&&(c._scopeId=i),o?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),r&&r.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},c._ssrRegister=u):r&&(u=r),u){var f=c.functional,p=f?c.render:c.beforeCreate;f?(c._injectStyles=u,c.render=function(t,e){return u.call(e),p(t,e)}):c.beforeCreate=p?[].concat(p,u):[u]}return{esModule:s,exports:a,options:c}}},WM06:function(t,e){},WRGp:function(t,e,n){window._=n("M4fF"),window.$=window.jQuery=n("7t+N"),n("z1kw"),jQuery.fn.uitooltip=jQuery.fn.tooltip,n("hSCs"),window.Vue=n("I3G/"),window.eventHub=new Vue,n("8+8L"),Vue.http.interceptors.push(function(t,e){t.headers.set("X-CSRF-TOKEN",Laravel.csrfToken),e()})},YDmc:function(t,e,n){var r=n("VU/8")(n("TNGo"),n("0DKT"),!1,function(t){n("rqPf")},"data-v-09a38dce",null);t.exports=r.exports},a5IG:function(t,e){},b7rt:function(t,e,n){var r=n("VU/8")(n("JHru"),n("bkb8"),!1,function(t){n("ct/M")},"data-v-473a48c2",null);t.exports=r.exports},bkb8:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"col-md-12",class:t.alertType},[n("div",{staticClass:"alert",class:t.alertClassName},[n("button",{staticClass:"close",attrs:{type:"button"},on:{click:t.hideEvent}},[t._v("×")]),t._v(" "),n("i",{directives:[{name:"show",rawName:"v-show",value:"success"==t.alertType,expression:"alertType == 'success'"}],staticClass:"fa fa-check faa-pulse animated",attrs:{"aria-hidden":"true"}}),t._v(" "),n("strong",[t._v(t._s(t.title)+" ")]),t._v(" "),t._t("default")],2)])},staticRenderFns:[]}},"ct/M":function(t,e,n){var r=n("P4DF");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("77b67673",r,!0,{})},eOaq:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["fieldsetId","modelId","previousInput"],data:function(){return{identifiers:{fieldset:null,model:null},elements:{fieldset:null,field:null},fields:null,show:!1,error:!1}},ready:function(){this.init()},mounted:function(){this.init()},methods:{init:function(){this.defaultValues=JSON.parse(this.previousInput),this.identifiers.fieldset=this.fieldsetId,this.identifiers.model=this.modelId,this.elements.fieldset=$(".js-fieldset-field"),this.elements.field=document.querySelector(".js-default-values-toggler"),this.elements.fieldset&&this.elements.field&&(this.addListeners(),this.getFields())},addListeners:function(){var t=this;this.elements.field.addEventListener("change",function(e){return t.updateShow()}),this.elements.fieldset.on("change",function(e){return t.updateFields()})},getFields:function(){var t=this;if(!this.identifiers.fieldset)return this.fields=[];this.$http.get(this.getUrl()).then(function(t){return t.json()}).then(function(e){return t.checkResponseForError(e)}).then(function(e){return t.fields=e.rows}).then(function(){return t.determineIfShouldShow()})},getValue:function(t){return t.default_value?t.default_value:null!=this.defaultValues?this.defaultValues[t.id.toString()]:""},getUrl:function(){return this.identifiers.model?route("api.fieldsets.fields-with-default-value",{fieldset:this.identifiers.fieldset,model:this.identifiers.model}):route("api.fieldsets.fields",{fieldset:this.identifiers.fieldset})},checkResponseForError:function(t){return this.error="error"==t.status,t},updateShow:function(){this.identifiers.fieldset&&this.elements.field&&(this.show=this.elements.field.checked)},determineIfShouldShow:function(){this.elements.field.checked=this.elements.field.checked||this.show||this.fields.reduce(function(t,e){return t||e.default_value},!1),this.updateShow()},updateFields:function(){this.identifiers.fieldset=!!this.elements.fieldset[0].value&&parseInt(this.elements.fieldset[0].value),this.getFields()}}}},f2Ky:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",[n("div",{staticClass:"panel panel-default"},[n("div",{staticClass:"panel-heading"},[n("div",{staticStyle:{display:"flex","justify-content":"space-between","align-items":"center"}},[n("h2",[t._v("\n                        Personal Access Tokens\n                    ")]),t._v(" "),n("a",{staticClass:"action-link",on:{click:t.showCreateTokenForm}},[t._v("\n                        Create New Token\n                    ")])])]),t._v(" "),n("div",{staticClass:"panel-body"},[0===t.tokens.length?n("p",{staticClass:"m-b-none"},[t._v("\n                    You have not created any personal access tokens.\n                ")]):t._e(),t._v(" "),t.tokens.length>0?n("table",{staticClass:"table table-borderless m-b-none"},[t._m(0),t._v(" "),n("tbody",t._l(t.tokens,function(e){return n("tr",[n("td",{staticStyle:{"vertical-align":"middle"}},[t._v("\n                                "+t._s(e.name)+"\n                            ")]),t._v(" "),n("td",{staticStyle:{"vertical-align":"middle"}},[n("a",{staticClass:"action-link text-danger",on:{click:function(n){t.revoke(e)}}},[t._v("\n                                    Delete\n                                ")])])])}))]):t._e()])])]),t._v(" "),n("div",{staticClass:"modal fade",attrs:{id:"modal-create-token",tabindex:"-1",role:"dialog"}},[n("div",{staticClass:"modal-dialog"},[n("div",{staticClass:"modal-content"},[t._m(1),t._v(" "),n("div",{staticClass:"modal-body"},[t.form.errors.length>0?n("div",{staticClass:"alert alert-danger"},[t._m(2),t._v(" "),n("br"),t._v(" "),n("ul",t._l(t.form.errors,function(e){return n("li",[t._v("\n                                "+t._s(e)+"\n                            ")])}))]):t._e(),t._v(" "),n("form",{staticClass:"form-horizontal",attrs:{role:"form"},on:{submit:function(e){e.preventDefault(),t.store(e)}}},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"col-md-4 control-label",attrs:{for:"name"}},[t._v("Name")]),t._v(" "),n("div",{staticClass:"col-md-6"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.form.name,expression:"form.name"}],staticClass:"form-control",attrs:{id:"create-token-name",type:"text","aria-label":"name",name:"name"},domProps:{value:t.form.name},on:{input:function(e){e.target.composing||(t.form.name=e.target.value)}}})])]),t._v(" "),t.scopes.length>0?n("div",{staticClass:"form-group"},[n("label",{staticClass:"col-md-4 control-label"},[t._v("Scopes")]),t._v(" "),n("div",{staticClass:"col-md-6"},t._l(t.scopes,function(e){return n("div",[n("div",{staticClass:"checkbox"},[n("label",[n("input",{attrs:{type:"checkbox"},domProps:{checked:t.scopeIsAssigned(e.id)},on:{click:function(n){t.toggleScope(e.id)}}}),t._v("\n\n                                                "+t._s(e.id)+"\n                                        ")])])])}))]):t._e()])]),t._v(" "),n("div",{staticClass:"modal-footer"},[n("button",{staticClass:"btn primary",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")]),t._v(" "),n("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:t.store}},[t._v("\n                        Create\n                    ")])])])])]),t._v(" "),n("div",{staticClass:"modal fade",attrs:{id:"modal-access-token",tabindex:"-1",role:"dialog"}},[n("div",{staticClass:"modal-dialog"},[n("div",{staticClass:"modal-content"},[t._m(3),t._v(" "),n("div",{staticClass:"modal-body"},[n("p",[t._v("\n                        Here is your new personal access token. This is the only time it will be shown so don't lose it!\n                        You may now use this token to make API requests.\n                    ")]),t._v(" "),n("pre",[n("code",[t._v(t._s(t.accessToken))])])]),t._v(" "),t._m(4)])])])])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("thead",[e("tr",[e("th",[this._v("Name")]),this._v(" "),e("th",[e("span",{staticClass:"sr-only"},[this._v("Delete")])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button ","data-dismiss":"modal","aria-hidden":"true"}},[this._v("×")]),this._v(" "),e("h2",{staticClass:"modal-title"},[this._v("\n                        Create Token\n                    ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("p",[e("strong",[this._v("Whoops!")]),this._v(" Something went wrong!")])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button ","data-dismiss":"modal","aria-hidden":"true"}},[this._v("×")]),this._v(" "),e("h2",{staticClass:"modal-title"},[this._v("\n                        Personal Access Token\n                    ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-footer"},[e("button",{staticClass:"btn btn-default",attrs:{type:"button","data-dismiss":"modal"}},[this._v("Close")])])}]}},f5J3:function(t,e){},g9VR:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,"",""])},hLk5:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".select2-dropdown[data-v-09a38dce]{z-index:9999}",""])},hSCs:function(t,e){"format global";"deps jquery";"exports $";if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");!function(t){"use strict";var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")}(jQuery),function(t){"use strict";t.fn.emulateTransitionEnd=function(e){var n=!1,r=this;t(this).one("bsTransitionEnd",function(){n=!0});return setTimeout(function(){n||t(r).trigger(t.support.transition.end)},e),this},t(function(){t.support.transition=function(){var t=document.createElement("bootstrap"),e={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var n in e)if(void 0!==t.style[n])return{end:e[n]};return!1}(),t.support.transition&&(t.event.special.bsTransitionEnd={bindType:t.support.transition.end,delegateType:t.support.transition.end,handle:function(e){if(t(e.target).is(this))return e.handleObj.handler.apply(this,arguments)}})})}(jQuery),function(t){"use strict";var e='[data-dismiss="alert"]',n=function(n){t(n).on("click",e,this.close)};n.VERSION="3.3.4",n.TRANSITION_DURATION=150,n.prototype.close=function(e){var r=t(this),i=r.attr("data-target");i||(i=(i=r.attr("href"))&&i.replace(/.*(?=#[^\s]*$)/,""));var o=t(i);function s(){o.detach().trigger("closed.bs.alert").remove()}e&&e.preventDefault(),o.length||(o=r.closest(".alert")),o.trigger(e=t.Event("close.bs.alert")),e.isDefaultPrevented()||(o.removeClass("in"),t.support.transition&&o.hasClass("fade")?o.one("bsTransitionEnd",s).emulateTransitionEnd(n.TRANSITION_DURATION):s())};var r=t.fn.alert;t.fn.alert=function(e){return this.each(function(){var r=t(this),i=r.data("bs.alert");i||r.data("bs.alert",i=new n(this)),"string"==typeof e&&i[e].call(r)})},t.fn.alert.Constructor=n,t.fn.alert.noConflict=function(){return t.fn.alert=r,this},t(document).on("click.bs.alert.data-api",e,n.prototype.close)}(jQuery),function(t){"use strict";var e=function(n,r){this.$element=t(n),this.options=t.extend({},e.DEFAULTS,r),this.isLoading=!1};function n(n){return this.each(function(){var r=t(this),i=r.data("bs.button"),o="object"==typeof n&&n;i||r.data("bs.button",i=new e(this,o)),"toggle"==n?i.toggle():n&&i.setState(n)})}e.VERSION="3.3.4",e.DEFAULTS={loadingText:"loading..."},e.prototype.setState=function(e){var n="disabled",r=this.$element,i=r.is("input")?"val":"html",o=r.data();e+="Text",null==o.resetText&&r.data("resetText",r[i]()),setTimeout(t.proxy(function(){r[i](null==o[e]?this.options[e]:o[e]),"loadingText"==e?(this.isLoading=!0,r.addClass(n).attr(n,n)):this.isLoading&&(this.isLoading=!1,r.removeClass(n).removeAttr(n))},this),0)},e.prototype.toggle=function(){var t=!0,e=this.$element.closest('[data-toggle="buttons"]');if(e.length){var n=this.$element.find("input");"radio"==n.prop("type")&&(n.prop("checked")&&this.$element.hasClass("active")?t=!1:e.find(".active").removeClass("active")),t&&n.prop("checked",!this.$element.hasClass("active")).trigger("change")}else this.$element.attr("aria-pressed",!this.$element.hasClass("active"));t&&this.$element.toggleClass("active")};var r=t.fn.button;t.fn.button=n,t.fn.button.Constructor=e,t.fn.button.noConflict=function(){return t.fn.button=r,this},t(document).on("click.bs.button.data-api",'[data-toggle^="button"]',function(e){var r=t(e.target);r.hasClass("btn")||(r=r.closest(".btn")),n.call(r,"toggle"),e.preventDefault()}).on("focus.bs.button.data-api blur.bs.button.data-api",'[data-toggle^="button"]',function(e){t(e.target).closest(".btn").toggleClass("focus",/^focus(in)?$/.test(e.type))})}(jQuery),function(t){"use strict";var e=function(e,n){this.$element=t(e),this.$indicators=this.$element.find(".carousel-indicators"),this.options=n,this.paused=null,this.sliding=null,this.interval=null,this.$active=null,this.$items=null,this.options.keyboard&&this.$element.on("keydown.bs.carousel",t.proxy(this.keydown,this)),"hover"==this.options.pause&&!("ontouchstart"in document.documentElement)&&this.$element.on("mouseenter.bs.carousel",t.proxy(this.pause,this)).on("mouseleave.bs.carousel",t.proxy(this.cycle,this))};function n(n){return this.each(function(){var r=t(this),i=r.data("bs.carousel"),o=t.extend({},e.DEFAULTS,r.data(),"object"==typeof n&&n),s="string"==typeof n?n:o.slide;i||r.data("bs.carousel",i=new e(this,o)),"number"==typeof n?i.to(n):s?i[s]():o.interval&&i.pause().cycle()})}e.VERSION="3.3.4",e.TRANSITION_DURATION=600,e.DEFAULTS={interval:5e3,pause:"hover",wrap:!0,keyboard:!0},e.prototype.keydown=function(t){if(!/input|textarea/i.test(t.target.tagName)){switch(t.which){case 37:this.prev();break;case 39:this.next();break;default:return}t.preventDefault()}},e.prototype.cycle=function(e){return e||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(t.proxy(this.next,this),this.options.interval)),this},e.prototype.getItemIndex=function(t){return this.$items=t.parent().children(".item"),this.$items.index(t||this.$active)},e.prototype.getItemForDirection=function(t,e){var n=this.getItemIndex(e);if(("prev"==t&&0===n||"next"==t&&n==this.$items.length-1)&&!this.options.wrap)return e;var r=(n+("prev"==t?-1:1))%this.$items.length;return this.$items.eq(r)},e.prototype.to=function(t){var e=this,n=this.getItemIndex(this.$active=this.$element.find(".item.active"));if(!(t>this.$items.length-1||t<0))return this.sliding?this.$element.one("slid.bs.carousel",function(){e.to(t)}):n==t?this.pause().cycle():this.slide(t>n?"next":"prev",this.$items.eq(t))},e.prototype.pause=function(e){return e||(this.paused=!0),this.$element.find(".next, .prev").length&&t.support.transition&&(this.$element.trigger(t.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this},e.prototype.next=function(){if(!this.sliding)return this.slide("next")},e.prototype.prev=function(){if(!this.sliding)return this.slide("prev")},e.prototype.slide=function(n,r){var i=this.$element.find(".item.active"),o=r||this.getItemForDirection(n,i),s=this.interval,a="next"==n?"left":"right",l=this;if(o.hasClass("active"))return this.sliding=!1;var u=o[0],c=t.Event("slide.bs.carousel",{relatedTarget:u,direction:a});if(this.$element.trigger(c),!c.isDefaultPrevented()){if(this.sliding=!0,s&&this.pause(),this.$indicators.length){this.$indicators.find(".active").removeClass("active");var f=t(this.$indicators.children()[this.getItemIndex(o)]);f&&f.addClass("active")}var p=t.Event("slid.bs.carousel",{relatedTarget:u,direction:a});return t.support.transition&&this.$element.hasClass("slide")?(o.addClass(n),o[0].offsetWidth,i.addClass(a),o.addClass(a),i.one("bsTransitionEnd",function(){o.removeClass([n,a].join(" ")).addClass("active"),i.removeClass(["active",a].join(" ")),l.sliding=!1,setTimeout(function(){l.$element.trigger(p)},0)}).emulateTransitionEnd(e.TRANSITION_DURATION)):(i.removeClass("active"),o.addClass("active"),this.sliding=!1,this.$element.trigger(p)),s&&this.cycle(),this}};var r=t.fn.carousel;t.fn.carousel=n,t.fn.carousel.Constructor=e,t.fn.carousel.noConflict=function(){return t.fn.carousel=r,this};var i=function(e){var r,i=t(this),o=t(i.attr("data-target")||(r=i.attr("href"))&&r.replace(/.*(?=#[^\s]+$)/,""));if(o.hasClass("carousel")){var s=t.extend({},o.data(),i.data()),a=i.attr("data-slide-to");a&&(s.interval=!1),n.call(o,s),a&&o.data("bs.carousel").to(a),e.preventDefault()}};t(document).on("click.bs.carousel.data-api","[data-slide]",i).on("click.bs.carousel.data-api","[data-slide-to]",i),t(window).on("load",function(){t('[data-ride="carousel"]').each(function(){var e=t(this);n.call(e,e.data())})})}(jQuery),function(t){"use strict";var e=function(n,r){this.$element=t(n),this.options=t.extend({},e.DEFAULTS,r),this.$trigger=t('[data-toggle="collapse"][href="#'+n.id+'"],[data-toggle="collapse"][data-target="#'+n.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};function n(e){var n,r=e.attr("data-target")||(n=e.attr("href"))&&n.replace(/.*(?=#[^\s]+$)/,"");return t(r)}function r(n){return this.each(function(){var r=t(this),i=r.data("bs.collapse"),o=t.extend({},e.DEFAULTS,r.data(),"object"==typeof n&&n);!i&&o.toggle&&/show|hide/.test(n)&&(o.toggle=!1),i||r.data("bs.collapse",i=new e(this,o)),"string"==typeof n&&i[n]()})}e.VERSION="3.3.4",e.TRANSITION_DURATION=350,e.DEFAULTS={toggle:!0},e.prototype.dimension=function(){return this.$element.hasClass("width")?"width":"height"},e.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var n,i=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");if(!(i&&i.length&&(n=i.data("bs.collapse"))&&n.transitioning)){var o=t.Event("show.bs.collapse");if(this.$element.trigger(o),!o.isDefaultPrevented()){i&&i.length&&(r.call(i,"hide"),n||i.data("bs.collapse",null));var s=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[s](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var a=function(){this.$element.removeClass("collapsing").addClass("collapse in")[s](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!t.support.transition)return a.call(this);var l=t.camelCase(["scroll",s].join("-"));this.$element.one("bsTransitionEnd",t.proxy(a,this)).emulateTransitionEnd(e.TRANSITION_DURATION)[s](this.$element[0][l])}}}},e.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var n=t.Event("hide.bs.collapse");if(this.$element.trigger(n),!n.isDefaultPrevented()){var r=this.dimension();this.$element[r](this.$element[r]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var i=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};if(!t.support.transition)return i.call(this);this.$element[r](0).one("bsTransitionEnd",t.proxy(i,this)).emulateTransitionEnd(e.TRANSITION_DURATION)}}},e.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},e.prototype.getParent=function(){return t(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(t.proxy(function(e,r){var i=t(r);this.addAriaAndCollapsedClass(n(i),i)},this)).end()},e.prototype.addAriaAndCollapsedClass=function(t,e){var n=t.hasClass("in");t.attr("aria-expanded",n),e.toggleClass("collapsed",!n).attr("aria-expanded",n)};var i=t.fn.collapse;t.fn.collapse=r,t.fn.collapse.Constructor=e,t.fn.collapse.noConflict=function(){return t.fn.collapse=i,this},t(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(e){var i=t(this);i.attr("data-target")||e.preventDefault();var o=n(i),s=o.data("bs.collapse")?"toggle":i.data();r.call(o,s)})}(jQuery),function(t){"use strict";var e=".dropdown-backdrop",n='[data-toggle="dropdown"]',r=function(e){t(e).on("click.bs.dropdown",this.toggle)};function i(r){r&&3===r.which||(t(e).remove(),t(n).each(function(){var e=t(this),n=o(e),i={relatedTarget:this};n.hasClass("open")&&(n.trigger(r=t.Event("hide.bs.dropdown",i)),r.isDefaultPrevented()||(e.attr("aria-expanded","false"),n.removeClass("open").trigger("hidden.bs.dropdown",i)))}))}function o(e){var n=e.attr("data-target");n||(n=(n=e.attr("href"))&&/#[A-Za-z]/.test(n)&&n.replace(/.*(?=#[^\s]*$)/,""));var r=n&&t(n);return r&&r.length?r:e.parent()}r.VERSION="3.3.4",r.prototype.toggle=function(e){var n=t(this);if(!n.is(".disabled, :disabled")){var r=o(n),s=r.hasClass("open");if(i(),!s){"ontouchstart"in document.documentElement&&!r.closest(".navbar-nav").length&&t('<div class="dropdown-backdrop"/>').insertAfter(t(this)).on("click",i);var a={relatedTarget:this};if(r.trigger(e=t.Event("show.bs.dropdown",a)),e.isDefaultPrevented())return;n.trigger("focus").attr("aria-expanded","true"),r.toggleClass("open").trigger("shown.bs.dropdown",a)}return!1}},r.prototype.keydown=function(e){if(/(38|40|27|32)/.test(e.which)&&!/input|textarea/i.test(e.target.tagName)){var r=t(this);if(e.preventDefault(),e.stopPropagation(),!r.is(".disabled, :disabled")){var i=o(r),s=i.hasClass("open");if(!s&&27!=e.which||s&&27==e.which)return 27==e.which&&i.find(n).trigger("focus"),r.trigger("click");var a=" li:not(.disabled):visible a",l=i.find('[role="menu"]'+a+', [role="listbox"]'+a);if(l.length){var u=l.index(e.target);38==e.which&&u>0&&u--,40==e.which&&u<l.length-1&&u++,~u||(u=0),l.eq(u).trigger("focus")}}}};var s=t.fn.dropdown;t.fn.dropdown=function(e){return this.each(function(){var n=t(this),i=n.data("bs.dropdown");i||n.data("bs.dropdown",i=new r(this)),"string"==typeof e&&i[e].call(n)})},t.fn.dropdown.Constructor=r,t.fn.dropdown.noConflict=function(){return t.fn.dropdown=s,this},t(document).on("click.bs.dropdown.data-api",i).on("click.bs.dropdown.data-api",".dropdown form",function(t){t.stopPropagation()}).on("click.bs.dropdown.data-api",n,r.prototype.toggle).on("keydown.bs.dropdown.data-api",n,r.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="menu"]',r.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="listbox"]',r.prototype.keydown)}(jQuery),function(t){"use strict";var e=function(e,n){this.options=n,this.$body=t(document.body),this.$element=t(e),this.$dialog=this.$element.find(".modal-dialog"),this.$backdrop=null,this.isShown=null,this.originalBodyPad=null,this.scrollbarWidth=0,this.ignoreBackdropClick=!1,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,t.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};function n(n,r){return this.each(function(){var i=t(this),o=i.data("bs.modal"),s=t.extend({},e.DEFAULTS,i.data(),"object"==typeof n&&n);o||i.data("bs.modal",o=new e(this,s)),"string"==typeof n?o[n](r):s.show&&o.show(r)})}e.VERSION="3.3.4",e.TRANSITION_DURATION=300,e.BACKDROP_TRANSITION_DURATION=150,e.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},e.prototype.toggle=function(t){return this.isShown?this.hide():this.show(t)},e.prototype.show=function(n){var r=this,i=t.Event("show.bs.modal",{relatedTarget:n});this.$element.trigger(i),this.isShown||i.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',t.proxy(this.hide,this)),this.$dialog.on("mousedown.dismiss.bs.modal",function(){r.$element.one("mouseup.dismiss.bs.modal",function(e){t(e.target).is(r.$element)&&(r.ignoreBackdropClick=!0)})}),this.backdrop(function(){var i=t.support.transition&&r.$element.hasClass("fade");r.$element.parent().length||r.$element.appendTo(r.$body),r.$element.show().scrollTop(0),r.adjustDialog(),i&&r.$element[0].offsetWidth,r.$element.addClass("in").attr("aria-hidden",!1),r.enforceFocus();var o=t.Event("shown.bs.modal",{relatedTarget:n});i?r.$dialog.one("bsTransitionEnd",function(){r.$element.trigger("focus").trigger(o)}).emulateTransitionEnd(e.TRANSITION_DURATION):r.$element.trigger("focus").trigger(o)}))},e.prototype.hide=function(n){n&&n.preventDefault(),n=t.Event("hide.bs.modal"),this.$element.trigger(n),this.isShown&&!n.isDefaultPrevented()&&(this.isShown=!1,this.escape(),this.resize(),t(document).off("focusin.bs.modal"),this.$element.removeClass("in").attr("aria-hidden",!0).off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"),this.$dialog.off("mousedown.dismiss.bs.modal"),t.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",t.proxy(this.hideModal,this)).emulateTransitionEnd(e.TRANSITION_DURATION):this.hideModal())},e.prototype.enforceFocus=function(){t(document).off("focusin.bs.modal").on("focusin.bs.modal",t.proxy(function(t){this.$element[0]===t.target||this.$element.has(t.target).length||this.$element.trigger("focus")},this))},e.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",t.proxy(function(t){27==t.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")},e.prototype.resize=function(){this.isShown?t(window).on("resize.bs.modal",t.proxy(this.handleUpdate,this)):t(window).off("resize.bs.modal")},e.prototype.hideModal=function(){var t=this;this.$element.hide(),this.backdrop(function(){t.$body.removeClass("modal-open"),t.resetAdjustments(),t.resetScrollbar(),t.$element.trigger("hidden.bs.modal")})},e.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},e.prototype.backdrop=function(n){var r=this,i=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var o=t.support.transition&&i;if(this.$backdrop=t('<div class="modal-backdrop '+i+'" />').appendTo(this.$body),this.$element.on("click.dismiss.bs.modal",t.proxy(function(t){this.ignoreBackdropClick?this.ignoreBackdropClick=!1:t.target===t.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus():this.hide())},this)),o&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!n)return;o?this.$backdrop.one("bsTransitionEnd",n).emulateTransitionEnd(e.BACKDROP_TRANSITION_DURATION):n()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");var s=function(){r.removeBackdrop(),n&&n()};t.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",s).emulateTransitionEnd(e.BACKDROP_TRANSITION_DURATION):s()}else n&&n()},e.prototype.handleUpdate=function(){this.adjustDialog()},e.prototype.adjustDialog=function(){var t=this.$element[0].scrollHeight>document.documentElement.clientHeight;this.$element.css({paddingLeft:!this.bodyIsOverflowing&&t?this.scrollbarWidth:"",paddingRight:this.bodyIsOverflowing&&!t?this.scrollbarWidth:""})},e.prototype.resetAdjustments=function(){this.$element.css({paddingLeft:"",paddingRight:""})},e.prototype.checkScrollbar=function(){var t=window.innerWidth;if(!t){var e=document.documentElement.getBoundingClientRect();t=e.right-Math.abs(e.left)}this.bodyIsOverflowing=document.body.clientWidth<t,this.scrollbarWidth=this.measureScrollbar()},e.prototype.setScrollbar=function(){var t=parseInt(this.$body.css("padding-right")||0,10);this.originalBodyPad=document.body.style.paddingRight||"",this.bodyIsOverflowing&&this.$body.css("padding-right",t+this.scrollbarWidth)},e.prototype.resetScrollbar=function(){this.$body.css("padding-right",this.originalBodyPad)},e.prototype.measureScrollbar=function(){var t=document.createElement("div");t.className="modal-scrollbar-measure",this.$body.append(t);var e=t.offsetWidth-t.clientWidth;return this.$body[0].removeChild(t),e};var r=t.fn.modal;t.fn.modal=n,t.fn.modal.Constructor=e,t.fn.modal.noConflict=function(){return t.fn.modal=r,this},t(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(e){var r=t(this),i=r.attr("href"),o=t(r.attr("data-target")||i&&i.replace(/.*(?=#[^\s]+$)/,"")),s=o.data("bs.modal")?"toggle":t.extend({remote:!/#/.test(i)&&i},o.data(),r.data());r.is("a")&&e.preventDefault(),o.one("show.bs.modal",function(t){t.isDefaultPrevented()||o.one("hidden.bs.modal",function(){r.is(":visible")&&r.trigger("focus")})}),n.call(o,s,this)})}(jQuery),function(t){"use strict";var e=function(t,e){this.type=null,this.options=null,this.enabled=null,this.timeout=null,this.hoverState=null,this.$element=null,this.init("tooltip",t,e)};e.VERSION="3.3.4",e.TRANSITION_DURATION=150,e.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0}},e.prototype.init=function(e,n,r){if(this.enabled=!0,this.type=e,this.$element=t(n),this.options=this.getOptions(r),this.$viewport=this.options.viewport&&t(this.options.viewport.selector||this.options.viewport),this.$element[0]instanceof document.constructor&&!this.options.selector)throw new Error("`selector` option must be specified when initializing "+this.type+" on the window.document object!");for(var i=this.options.trigger.split(" "),o=i.length;o--;){var s=i[o];if("click"==s)this.$element.on("click."+this.type,this.options.selector,t.proxy(this.toggle,this));else if("manual"!=s){var a="hover"==s?"mouseenter":"focusin",l="hover"==s?"mouseleave":"focusout";this.$element.on(a+"."+this.type,this.options.selector,t.proxy(this.enter,this)),this.$element.on(l+"."+this.type,this.options.selector,t.proxy(this.leave,this))}}this.options.selector?this._options=t.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},e.prototype.getDefaults=function(){return e.DEFAULTS},e.prototype.getOptions=function(e){return(e=t.extend({},this.getDefaults(),this.$element.data(),e)).delay&&"number"==typeof e.delay&&(e.delay={show:e.delay,hide:e.delay}),e},e.prototype.getDelegateOptions=function(){var e={},n=this.getDefaults();return this._options&&t.each(this._options,function(t,r){n[t]!=r&&(e[t]=r)}),e},e.prototype.enter=function(e){var n=e instanceof this.constructor?e:t(e.currentTarget).data("bs."+this.type);if(n&&n.$tip&&n.$tip.is(":visible"))n.hoverState="in";else{if(n||(n=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,n)),clearTimeout(n.timeout),n.hoverState="in",!n.options.delay||!n.options.delay.show)return n.show();n.timeout=setTimeout(function(){"in"==n.hoverState&&n.show()},n.options.delay.show)}},e.prototype.leave=function(e){var n=e instanceof this.constructor?e:t(e.currentTarget).data("bs."+this.type);if(n||(n=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,n)),clearTimeout(n.timeout),n.hoverState="out",!n.options.delay||!n.options.delay.hide)return n.hide();n.timeout=setTimeout(function(){"out"==n.hoverState&&n.hide()},n.options.delay.hide)},e.prototype.show=function(){var n=t.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(n);var r=t.contains(this.$element[0].ownerDocument.documentElement,this.$element[0]);if(n.isDefaultPrevented()||!r)return;var i=this,o=this.tip(),s=this.getUID(this.type);this.setContent(),o.attr("id",s),this.$element.attr("aria-describedby",s),this.options.animation&&o.addClass("fade");var a="function"==typeof this.options.placement?this.options.placement.call(this,o[0],this.$element[0]):this.options.placement,l=/\s?auto?\s?/i,u=l.test(a);u&&(a=a.replace(l,"")||"top"),o.detach().css({top:0,left:0,display:"block"}).addClass(a).data("bs."+this.type,this),this.options.container?o.appendTo(this.options.container):o.insertAfter(this.$element);var c=this.getPosition(),f=o[0].offsetWidth,p=o[0].offsetHeight;if(u){var d=a,h=this.options.container?t(this.options.container):this.$element.parent(),v=this.getPosition(h);a="bottom"==a&&c.bottom+p>v.bottom?"top":"top"==a&&c.top-p<v.top?"bottom":"right"==a&&c.right+f>v.width?"left":"left"==a&&c.left-f<v.left?"right":a,o.removeClass(d).addClass(a)}var g=this.getCalculatedOffset(a,c,f,p);this.applyPlacement(g,a);var m=function(){var t=i.hoverState;i.$element.trigger("shown.bs."+i.type),i.hoverState=null,"out"==t&&i.leave(i)};t.support.transition&&this.$tip.hasClass("fade")?o.one("bsTransitionEnd",m).emulateTransitionEnd(e.TRANSITION_DURATION):m()}},e.prototype.applyPlacement=function(e,n){var r=this.tip(),i=r[0].offsetWidth,o=r[0].offsetHeight,s=parseInt(r.css("margin-top"),10),a=parseInt(r.css("margin-left"),10);isNaN(s)&&(s=0),isNaN(a)&&(a=0),e.top=e.top+s,e.left=e.left+a,t.offset.setOffset(r[0],t.extend({using:function(t){r.css({top:Math.round(t.top),left:Math.round(t.left)})}},e),0),r.addClass("in");var l=r[0].offsetWidth,u=r[0].offsetHeight;"top"==n&&u!=o&&(e.top=e.top+o-u);var c=this.getViewportAdjustedDelta(n,e,l,u);c.left?e.left+=c.left:e.top+=c.top;var f=/top|bottom/.test(n),p=f?2*c.left-i+l:2*c.top-o+u,d=f?"offsetWidth":"offsetHeight";r.offset(e),this.replaceArrow(p,r[0][d],f)},e.prototype.replaceArrow=function(t,e,n){this.arrow().css(n?"left":"top",50*(1-t/e)+"%").css(n?"top":"left","")},e.prototype.setContent=function(){var t=this.tip(),e=this.getTitle();t.find(".tooltip-inner")[this.options.html?"html":"text"](e),t.removeClass("fade in top bottom left right")},e.prototype.hide=function(n){var r=this,i=t(this.$tip),o=t.Event("hide.bs."+this.type);function s(){"in"!=r.hoverState&&i.detach(),r.$element.removeAttr("aria-describedby").trigger("hidden.bs."+r.type),n&&n()}if(this.$element.trigger(o),!o.isDefaultPrevented())return i.removeClass("in"),t.support.transition&&i.hasClass("fade")?i.one("bsTransitionEnd",s).emulateTransitionEnd(e.TRANSITION_DURATION):s(),this.hoverState=null,this},e.prototype.fixTitle=function(){var t=this.$element;(t.attr("title")||"string"!=typeof t.attr("data-original-title"))&&t.attr("data-original-title",t.attr("title")||"").attr("title","")},e.prototype.hasContent=function(){return this.getTitle()},e.prototype.getPosition=function(e){var n=(e=e||this.$element)[0],r="BODY"==n.tagName,i=n.getBoundingClientRect();null==i.width&&(i=t.extend({},i,{width:i.right-i.left,height:i.bottom-i.top}));var o=r?{top:0,left:0}:e.offset(),s={scroll:r?document.documentElement.scrollTop||document.body.scrollTop:e.scrollTop()},a=r?{width:t(window).width(),height:t(window).height()}:null;return t.extend({},i,s,a,o)},e.prototype.getCalculatedOffset=function(t,e,n,r){return"bottom"==t?{top:e.top+e.height,left:e.left+e.width/2-n/2}:"top"==t?{top:e.top-r,left:e.left+e.width/2-n/2}:"left"==t?{top:e.top+e.height/2-r/2,left:e.left-n}:{top:e.top+e.height/2-r/2,left:e.left+e.width}},e.prototype.getViewportAdjustedDelta=function(t,e,n,r){var i={top:0,left:0};if(!this.$viewport)return i;var o=this.options.viewport&&this.options.viewport.padding||0,s=this.getPosition(this.$viewport);if(/right|left/.test(t)){var a=e.top-o-s.scroll,l=e.top+o-s.scroll+r;a<s.top?i.top=s.top-a:l>s.top+s.height&&(i.top=s.top+s.height-l)}else{var u=e.left-o,c=e.left+o+n;u<s.left?i.left=s.left-u:c>s.width&&(i.left=s.left+s.width-c)}return i},e.prototype.getTitle=function(){var t=this.$element,e=this.options;return t.attr("data-original-title")||("function"==typeof e.title?e.title.call(t[0]):e.title)},e.prototype.getUID=function(t){do{t+=~~(1e6*Math.random())}while(document.getElementById(t));return t},e.prototype.tip=function(){return this.$tip=this.$tip||t(this.options.template)},e.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},e.prototype.enable=function(){this.enabled=!0},e.prototype.disable=function(){this.enabled=!1},e.prototype.toggleEnabled=function(){this.enabled=!this.enabled},e.prototype.toggle=function(e){var n=this;e&&((n=t(e.currentTarget).data("bs."+this.type))||(n=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,n))),n.tip().hasClass("in")?n.leave(n):n.enter(n)},e.prototype.destroy=function(){var t=this;clearTimeout(this.timeout),this.hide(function(){t.$element.off("."+t.type).removeData("bs."+t.type)})};var n=t.fn.tooltip;t.fn.tooltip=function(n){return this.each(function(){var r=t(this),i=r.data("bs.tooltip"),o="object"==typeof n&&n;!i&&/destroy|hide/.test(n)||(i||r.data("bs.tooltip",i=new e(this,o)),"string"==typeof n&&i[n]())})},t.fn.tooltip.Constructor=e,t.fn.tooltip.noConflict=function(){return t.fn.tooltip=n,this}}(jQuery),function(t){"use strict";var e=function(t,e){this.init("popover",t,e)};if(!t.fn.tooltip)throw new Error("Popover requires tooltip.js");e.VERSION="3.3.4",e.DEFAULTS=t.extend({},t.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),e.prototype=t.extend({},t.fn.tooltip.Constructor.prototype),e.prototype.constructor=e,e.prototype.getDefaults=function(){return e.DEFAULTS},e.prototype.setContent=function(){var t=this.tip(),e=this.getTitle(),n=this.getContent();t.find(".popover-title")[this.options.html?"html":"text"](e),t.find(".popover-content").children().detach().end()[this.options.html?"string"==typeof n?"html":"append":"text"](n),t.removeClass("fade top bottom left right in"),t.find(".popover-title").html()||t.find(".popover-title").hide()},e.prototype.hasContent=function(){return this.getTitle()||this.getContent()},e.prototype.getContent=function(){var t=this.$element,e=this.options;return t.attr("data-content")||("function"==typeof e.content?e.content.call(t[0]):e.content)},e.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")};var n=t.fn.popover;t.fn.popover=function(n){return this.each(function(){var r=t(this),i=r.data("bs.popover"),o="object"==typeof n&&n;!i&&/destroy|hide/.test(n)||(i||r.data("bs.popover",i=new e(this,o)),"string"==typeof n&&i[n]())})},t.fn.popover.Constructor=e,t.fn.popover.noConflict=function(){return t.fn.popover=n,this}}(jQuery),function(t){"use strict";function e(n,r){this.$body=t(document.body),this.$scrollElement=t(n).is(document.body)?t(window):t(n),this.options=t.extend({},e.DEFAULTS,r),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",t.proxy(this.process,this)),this.refresh(),this.process()}function n(n){return this.each(function(){var r=t(this),i=r.data("bs.scrollspy"),o="object"==typeof n&&n;i||r.data("bs.scrollspy",i=new e(this,o)),"string"==typeof n&&i[n]()})}e.VERSION="3.3.4",e.DEFAULTS={offset:10},e.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)},e.prototype.refresh=function(){var e=this,n="offset",r=0;this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight(),t.isWindow(this.$scrollElement[0])||(n="position",r=this.$scrollElement.scrollTop()),this.$body.find(this.selector).map(function(){var e=t(this),i=e.data("target")||e.attr("href"),o=/^#./.test(i)&&t(i);return o&&o.length&&o.is(":visible")&&[[o[n]().top+r,i]]||null}).sort(function(t,e){return t[0]-e[0]}).each(function(){e.offsets.push(this[0]),e.targets.push(this[1])})},e.prototype.process=function(){var t,e=this.$scrollElement.scrollTop()+this.options.offset,n=this.getScrollHeight(),r=this.options.offset+n-this.$scrollElement.height(),i=this.offsets,o=this.targets,s=this.activeTarget;if(this.scrollHeight!=n&&this.refresh(),e>=r)return s!=(t=o[o.length-1])&&this.activate(t);if(s&&e<i[0])return this.activeTarget=null,this.clear();for(t=i.length;t--;)s!=o[t]&&e>=i[t]&&(void 0===i[t+1]||e<i[t+1])&&this.activate(o[t])},e.prototype.activate=function(e){this.activeTarget=e,this.clear();var n=this.selector+'[data-target="'+e+'"],'+this.selector+'[href="'+e+'"]',r=t(n).parents("li").addClass("active");r.parent(".dropdown-menu").length&&(r=r.closest("li.dropdown").addClass("active")),r.trigger("activate.bs.scrollspy")},e.prototype.clear=function(){t(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var r=t.fn.scrollspy;t.fn.scrollspy=n,t.fn.scrollspy.Constructor=e,t.fn.scrollspy.noConflict=function(){return t.fn.scrollspy=r,this},t(window).on("load.bs.scrollspy.data-api",function(){t('[data-spy="scroll"]').each(function(){var e=t(this);n.call(e,e.data())})})}(jQuery),function(t){"use strict";var e=function(e){this.element=t(e)};function n(n){return this.each(function(){var r=t(this),i=r.data("bs.tab");i||r.data("bs.tab",i=new e(this)),"string"==typeof n&&i[n]()})}e.VERSION="3.3.4",e.TRANSITION_DURATION=150,e.prototype.show=function(){var e=this.element,n=e.closest("ul:not(.dropdown-menu)"),r=e.data("target");if(r||(r=(r=e.attr("href"))&&r.replace(/.*(?=#[^\s]*$)/,"")),!e.parent("li").hasClass("active")){var i=n.find(".active:last a"),o=t.Event("hide.bs.tab",{relatedTarget:e[0]}),s=t.Event("show.bs.tab",{relatedTarget:i[0]});if(i.trigger(o),e.trigger(s),!s.isDefaultPrevented()&&!o.isDefaultPrevented()){var a=t(r);this.activate(e.closest("li"),n),this.activate(a,a.parent(),function(){i.trigger({type:"hidden.bs.tab",relatedTarget:e[0]}),e.trigger({type:"shown.bs.tab",relatedTarget:i[0]})})}}},e.prototype.activate=function(n,r,i){var o=r.find("> .active"),s=i&&t.support.transition&&(o.length&&o.hasClass("fade")||!!r.find("> .fade").length);function a(){o.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),n.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),s?(n[0].offsetWidth,n.addClass("in")):n.removeClass("fade"),n.parent(".dropdown-menu").length&&n.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),i&&i()}o.length&&s?o.one("bsTransitionEnd",a).emulateTransitionEnd(e.TRANSITION_DURATION):a(),o.removeClass("in")};var r=t.fn.tab;t.fn.tab=n,t.fn.tab.Constructor=e,t.fn.tab.noConflict=function(){return t.fn.tab=r,this};var i=function(e){e.preventDefault(),n.call(t(this),"show")};t(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',i).on("click.bs.tab.data-api",'[data-toggle="pill"]',i)}(jQuery),function(t){"use strict";var e=function(n,r){this.options=t.extend({},e.DEFAULTS,r),this.$target=t(this.options.target).on("scroll.bs.affix.data-api",t.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",t.proxy(this.checkPositionWithEventLoop,this)),this.$element=t(n),this.affixed=null,this.unpin=null,this.pinnedOffset=null,this.checkPosition()};function n(n){return this.each(function(){var r=t(this),i=r.data("bs.affix"),o="object"==typeof n&&n;i||r.data("bs.affix",i=new e(this,o)),"string"==typeof n&&i[n]()})}e.VERSION="3.3.4",e.RESET="affix affix-top affix-bottom",e.DEFAULTS={offset:0,target:window},e.prototype.getState=function(t,e,n,r){var i=this.$target.scrollTop(),o=this.$element.offset(),s=this.$target.height();if(null!=n&&"top"==this.affixed)return i<n&&"top";if("bottom"==this.affixed)return null!=n?!(i+this.unpin<=o.top)&&"bottom":!(i+s<=t-r)&&"bottom";var a=null==this.affixed,l=a?i:o.top;return null!=n&&i<=n?"top":null!=r&&l+(a?s:e)>=t-r&&"bottom"},e.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;this.$element.removeClass(e.RESET).addClass("affix");var t=this.$target.scrollTop(),n=this.$element.offset();return this.pinnedOffset=n.top-t},e.prototype.checkPositionWithEventLoop=function(){setTimeout(t.proxy(this.checkPosition,this),1)},e.prototype.checkPosition=function(){if(this.$element.is(":visible")){var n=this.$element.height(),r=this.options.offset,i=r.top,o=r.bottom,s=t(document.body).height();"object"!=typeof r&&(o=i=r),"function"==typeof i&&(i=r.top(this.$element)),"function"==typeof o&&(o=r.bottom(this.$element));var a=this.getState(s,n,i,o);if(this.affixed!=a){null!=this.unpin&&this.$element.css("top","");var l="affix"+(a?"-"+a:""),u=t.Event(l+".bs.affix");if(this.$element.trigger(u),u.isDefaultPrevented())return;this.affixed=a,this.unpin="bottom"==a?this.getPinnedOffset():null,this.$element.removeClass(e.RESET).addClass(l).trigger(l.replace("affix","affixed")+".bs.affix")}"bottom"==a&&this.$element.offset({top:s-n-o})}};var r=t.fn.affix;t.fn.affix=n,t.fn.affix.Constructor=e,t.fn.affix.noConflict=function(){return t.fn.affix=r,this},t(window).on("load",function(){t('[data-spy="affix"]').each(function(){var e=t(this),r=e.data();r.offset=r.offset||{},null!=r.offsetBottom&&(r.offset.bottom=r.offsetBottom),null!=r.offsetTop&&(r.offset.top=r.offsetTop),n.call(e,r)})})}(jQuery)},hv7s:function(t,e,n){var r,i,o,s;s=function(t){var e=function(){if(t&&t.fn&&t.fn.select2&&t.fn.select2.amd)var e=t.fn.select2.amd;var n,r,i;return e&&e.requirejs||(e?r=e:e={},function(t){var e,o,s,a,l={},u={},c={},f={},p=Object.prototype.hasOwnProperty,d=[].slice,h=/\.js$/;function v(t,e){return p.call(t,e)}function g(t,e){var n,r,i,o,s,a,l,u,f,p,d,v=e&&e.split("/"),g=c.map,m=g&&g["*"]||{};if(t){for(s=(t=t.split("/")).length-1,c.nodeIdCompat&&h.test(t[s])&&(t[s]=t[s].replace(h,"")),"."===t[0].charAt(0)&&v&&(t=v.slice(0,v.length-1).concat(t)),f=0;f<t.length;f++)if("."===(d=t[f]))t.splice(f,1),f-=1;else if(".."===d){if(0===f||1===f&&".."===t[2]||".."===t[f-1])continue;f>0&&(t.splice(f-1,2),f-=2)}t=t.join("/")}if((v||m)&&g){for(f=(n=t.split("/")).length;f>0;f-=1){if(r=n.slice(0,f).join("/"),v)for(p=v.length;p>0;p-=1)if((i=g[v.slice(0,p).join("/")])&&(i=i[r])){o=i,a=f;break}if(o)break;!l&&m&&m[r]&&(l=m[r],u=f)}!o&&l&&(o=l,a=u),o&&(n.splice(0,a,o),t=n.join("/"))}return t}function m(e,n){return function(){var r=d.call(arguments,0);return"string"!=typeof r[0]&&1===r.length&&r.push(null),o.apply(t,r.concat([e,n]))}}function y(t){return function(e){l[t]=e}}function _(n){if(v(u,n)){var r=u[n];delete u[n],f[n]=!0,e.apply(t,r)}if(!v(l,n)&&!v(f,n))throw new Error("No "+n);return l[n]}function b(t){var e,n=t?t.indexOf("!"):-1;return n>-1&&(e=t.substring(0,n),t=t.substring(n+1,t.length)),[e,t]}function w(t){return t?b(t):[]}s=function(t,e){var n,r,i=b(t),o=i[0],s=e[1];return t=i[1],o&&(n=_(o=g(o,s))),o?t=n&&n.normalize?n.normalize(t,(r=s,function(t){return g(t,r)})):g(t,s):(o=(i=b(t=g(t,s)))[0],t=i[1],o&&(n=_(o))),{f:o?o+"!"+t:t,n:t,pr:o,p:n}},a={require:function(t){return m(t)},exports:function(t){var e=l[t];return void 0!==e?e:l[t]={}},module:function(t){return{id:t,uri:"",exports:l[t],config:function(t){return function(){return c&&c.config&&c.config[t]||{}}}(t)}}},e=function(e,n,r,i){var o,c,p,d,h,g,b,x=[],C=typeof r;if(g=w(i=i||e),"undefined"===C||"function"===C){for(n=!n.length&&r.length?["require","exports","module"]:n,h=0;h<n.length;h+=1)if("require"===(c=(d=s(n[h],g)).f))x[h]=a.require(e);else if("exports"===c)x[h]=a.exports(e),b=!0;else if("module"===c)o=x[h]=a.module(e);else if(v(l,c)||v(u,c)||v(f,c))x[h]=_(c);else{if(!d.p)throw new Error(e+" missing "+c);d.p.load(d.n,m(i,!0),y(c),{}),x[h]=l[c]}p=r?r.apply(l[e],x):void 0,e&&(o&&o.exports!==t&&o.exports!==l[e]?l[e]=o.exports:p===t&&b||(l[e]=p))}else e&&(l[e]=r)},n=r=o=function(n,r,i,l,u){if("string"==typeof n)return a[n]?a[n](r):_(s(n,w(r)).f);if(!n.splice){if((c=n).deps&&o(c.deps,c.callback),!r)return;r.splice?(n=r,r=i,i=null):n=t}return r=r||function(){},"function"==typeof i&&(i=l,l=u),l?e(t,n,r,i):setTimeout(function(){e(t,n,r,i)},4),o},o.config=function(t){return o(t)},n._defined=l,(i=function(t,e,n){if("string"!=typeof t)throw new Error("See almond README: incorrect module build, no module name");e.splice||(n=e,e=[]),v(l,t)||v(u,t)||(u[t]=[t,e,n])}).amd={jQuery:!0}}(),e.requirejs=n,e.require=r,e.define=i),e.define("almond",function(){}),e.define("jquery",[],function(){var e=t||$;return null==e&&console&&console.error&&console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."),e}),e.define("select2/utils",["jquery"],function(t){var e={};function n(t){var e=t.prototype,n=[];for(var r in e){"function"==typeof e[r]&&("constructor"!==r&&n.push(r))}return n}e.Extend=function(t,e){var n={}.hasOwnProperty;function r(){this.constructor=t}for(var i in e)n.call(e,i)&&(t[i]=e[i]);return r.prototype=e.prototype,t.prototype=new r,t.__super__=e.prototype,t},e.Decorate=function(t,e){var r=n(e),i=n(t);function o(){var n=Array.prototype.unshift,r=e.prototype.constructor.length,i=t.prototype.constructor;r>0&&(n.call(arguments,t.prototype.constructor),i=e.prototype.constructor),i.apply(this,arguments)}e.displayName=t.displayName,o.prototype=new function(){this.constructor=o};for(var s=0;s<i.length;s++){var a=i[s];o.prototype[a]=t.prototype[a]}for(var l=function(t){var n=function(){};t in o.prototype&&(n=o.prototype[t]);var r=e.prototype[t];return function(){return Array.prototype.unshift.call(arguments,n),r.apply(this,arguments)}},u=0;u<r.length;u++){var c=r[u];o.prototype[c]=l(c)}return o};var r=function(){this.listeners={}};r.prototype.on=function(t,e){this.listeners=this.listeners||{},t in this.listeners?this.listeners[t].push(e):this.listeners[t]=[e]},r.prototype.trigger=function(t){var e=Array.prototype.slice,n=e.call(arguments,1);this.listeners=this.listeners||{},null==n&&(n=[]),0===n.length&&n.push({}),n[0]._type=t,t in this.listeners&&this.invoke(this.listeners[t],e.call(arguments,1)),"*"in this.listeners&&this.invoke(this.listeners["*"],arguments)},r.prototype.invoke=function(t,e){for(var n=0,r=t.length;n<r;n++)t[n].apply(this,e)},e.Observable=r,e.generateChars=function(t){for(var e="",n=0;n<t;n++){e+=Math.floor(36*Math.random()).toString(36)}return e},e.bind=function(t,e){return function(){t.apply(e,arguments)}},e._convertData=function(t){for(var e in t){var n=e.split("-"),r=t;if(1!==n.length){for(var i=0;i<n.length;i++){var o=n[i];(o=o.substring(0,1).toLowerCase()+o.substring(1))in r||(r[o]={}),i==n.length-1&&(r[o]=t[e]),r=r[o]}delete t[e]}}return t},e.hasScroll=function(e,n){var r=t(n),i=n.style.overflowX,o=n.style.overflowY;return(i!==o||"hidden"!==o&&"visible"!==o)&&("scroll"===i||"scroll"===o||(r.innerHeight()<n.scrollHeight||r.innerWidth()<n.scrollWidth))},e.escapeMarkup=function(t){var e={"\\":"&#92;","&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;","/":"&#47;"};return"string"!=typeof t?t:String(t).replace(/[&<>"'\/\\]/g,function(t){return e[t]})},e.appendMany=function(e,n){if("1.7"===t.fn.jquery.substr(0,3)){var r=t();t.map(n,function(t){r=r.add(t)}),n=r}e.append(n)},e.__cache={};var i=0;return e.GetUniqueElementId=function(t){var e=t.getAttribute("data-select2-id");return null==e&&(t.id?(e=t.id,t.setAttribute("data-select2-id",e)):(t.setAttribute("data-select2-id",++i),e=i.toString())),e},e.StoreData=function(t,n,r){var i=e.GetUniqueElementId(t);e.__cache[i]||(e.__cache[i]={}),e.__cache[i][n]=r},e.GetData=function(n,r){var i=e.GetUniqueElementId(n);return r?e.__cache[i]&&null!=e.__cache[i][r]?e.__cache[i][r]:t(n).data(r):e.__cache[i]},e.RemoveData=function(t){var n=e.GetUniqueElementId(t);null!=e.__cache[n]&&delete e.__cache[n],t.removeAttribute("data-select2-id")},e}),e.define("select2/results",["jquery","./utils"],function(t,e){function n(t,e,r){this.$element=t,this.data=r,this.options=e,n.__super__.constructor.call(this)}return e.Extend(n,e.Observable),n.prototype.render=function(){var e=t('<ul class="select2-results__options" role="listbox"></ul>');return this.options.get("multiple")&&e.attr("aria-multiselectable","true"),this.$results=e,e},n.prototype.clear=function(){this.$results.empty()},n.prototype.displayMessage=function(e){var n=this.options.get("escapeMarkup");this.clear(),this.hideLoading();var r=t('<li role="alert" aria-live="assertive" class="select2-results__option"></li>'),i=this.options.get("translations").get(e.message);r.append(n(i(e.args))),r[0].className+=" select2-results__message",this.$results.append(r)},n.prototype.hideMessages=function(){this.$results.find(".select2-results__message").remove()},n.prototype.append=function(t){this.hideLoading();var e=[];if(null!=t.results&&0!==t.results.length){t.results=this.sort(t.results);for(var n=0;n<t.results.length;n++){var r=t.results[n],i=this.option(r);e.push(i)}this.$results.append(e)}else 0===this.$results.children().length&&this.trigger("results:message",{message:"noResults"})},n.prototype.position=function(t,e){e.find(".select2-results").append(t)},n.prototype.sort=function(t){return this.options.get("sorter")(t)},n.prototype.highlightFirstItem=function(){var t=this.$results.find(".select2-results__option[aria-selected]"),e=t.filter("[aria-selected=true]");e.length>0?e.first().trigger("mouseenter"):t.first().trigger("mouseenter"),this.ensureHighlightVisible()},n.prototype.setClasses=function(){var n=this;this.data.current(function(r){var i=t.map(r,function(t){return t.id.toString()});n.$results.find(".select2-results__option[aria-selected]").each(function(){var n=t(this),r=e.GetData(this,"data"),o=""+r.id;null!=r.element&&r.element.selected||null==r.element&&t.inArray(o,i)>-1?n.attr("aria-selected","true"):n.attr("aria-selected","false")})})},n.prototype.showLoading=function(t){this.hideLoading();var e={disabled:!0,loading:!0,text:this.options.get("translations").get("searching")(t)},n=this.option(e);n.className+=" loading-results",this.$results.prepend(n)},n.prototype.hideLoading=function(){this.$results.find(".loading-results").remove()},n.prototype.option=function(n){var r=document.createElement("li");r.className="select2-results__option";var i={role:"option","aria-selected":"false"},o=window.Element.prototype.matches||window.Element.prototype.msMatchesSelector||window.Element.prototype.webkitMatchesSelector;for(var s in(null!=n.element&&o.call(n.element,":disabled")||null==n.element&&n.disabled)&&(delete i["aria-selected"],i["aria-disabled"]="true"),null==n.id&&delete i["aria-selected"],null!=n._resultId&&(r.id=n._resultId),n.title&&(r.title=n.title),n.children&&(i.role="group",i["aria-label"]=n.text,delete i["aria-selected"]),i){var a=i[s];r.setAttribute(s,a)}if(n.children){var l=t(r),u=document.createElement("strong");u.className="select2-results__group";t(u);this.template(n,u);for(var c=[],f=0;f<n.children.length;f++){var p=n.children[f],d=this.option(p);c.push(d)}var h=t("<ul></ul>",{class:"select2-results__options select2-results__options--nested"});h.append(c),l.append(u),l.append(h)}else this.template(n,r);return e.StoreData(r,"data",n),r},n.prototype.bind=function(n,r){var i=this,o=n.id+"-results";this.$results.attr("id",o),n.on("results:all",function(t){i.clear(),i.append(t.data),n.isOpen()&&(i.setClasses(),i.highlightFirstItem())}),n.on("results:append",function(t){i.append(t.data),n.isOpen()&&i.setClasses()}),n.on("query",function(t){i.hideMessages(),i.showLoading(t)}),n.on("select",function(){n.isOpen()&&(i.setClasses(),i.options.get("scrollAfterSelect")&&i.highlightFirstItem())}),n.on("unselect",function(){n.isOpen()&&(i.setClasses(),i.options.get("scrollAfterSelect")&&i.highlightFirstItem())}),n.on("open",function(){i.$results.attr("aria-expanded","true"),i.$results.attr("aria-hidden","false"),i.setClasses(),i.ensureHighlightVisible()}),n.on("close",function(){i.$results.attr("aria-expanded","false"),i.$results.attr("aria-hidden","true"),i.$results.removeAttr("aria-activedescendant")}),n.on("results:toggle",function(){var t=i.getHighlightedResults();0!==t.length&&t.trigger("mouseup")}),n.on("results:select",function(){var t=i.getHighlightedResults();if(0!==t.length){var n=e.GetData(t[0],"data");"true"==t.attr("aria-selected")?i.trigger("close",{}):i.trigger("select",{data:n})}}),n.on("results:previous",function(){var t=i.getHighlightedResults(),e=i.$results.find("[aria-selected]"),n=e.index(t);if(!(n<=0)){var r=n-1;0===t.length&&(r=0);var o=e.eq(r);o.trigger("mouseenter");var s=i.$results.offset().top,a=o.offset().top,l=i.$results.scrollTop()+(a-s);0===r?i.$results.scrollTop(0):a-s<0&&i.$results.scrollTop(l)}}),n.on("results:next",function(){var t=i.getHighlightedResults(),e=i.$results.find("[aria-selected]"),n=e.index(t)+1;if(!(n>=e.length)){var r=e.eq(n);r.trigger("mouseenter");var o=i.$results.offset().top+i.$results.outerHeight(!1),s=r.offset().top+r.outerHeight(!1),a=i.$results.scrollTop()+s-o;0===n?i.$results.scrollTop(0):s>o&&i.$results.scrollTop(a)}}),n.on("results:focus",function(t){t.element.addClass("select2-results__option--highlighted")}),n.on("results:message",function(t){i.displayMessage(t)}),t.fn.mousewheel&&this.$results.on("mousewheel",function(t){var e=i.$results.scrollTop(),n=i.$results.get(0).scrollHeight-e+t.deltaY,r=t.deltaY>0&&e-t.deltaY<=0,o=t.deltaY<0&&n<=i.$results.height();r?(i.$results.scrollTop(0),t.preventDefault(),t.stopPropagation()):o&&(i.$results.scrollTop(i.$results.get(0).scrollHeight-i.$results.height()),t.preventDefault(),t.stopPropagation())}),this.$results.on("mouseup",".select2-results__option[aria-selected]",function(n){var r=t(this),o=e.GetData(this,"data");"true"!==r.attr("aria-selected")?i.trigger("select",{originalEvent:n,data:o}):i.options.get("multiple")?i.trigger("unselect",{originalEvent:n,data:o}):i.trigger("close",{})}),this.$results.on("mouseenter",".select2-results__option[aria-selected]",function(n){var r=e.GetData(this,"data");i.getHighlightedResults().removeClass("select2-results__option--highlighted"),i.trigger("results:focus",{data:r,element:t(this)})})},n.prototype.getHighlightedResults=function(){return this.$results.find(".select2-results__option--highlighted")},n.prototype.destroy=function(){this.$results.remove()},n.prototype.ensureHighlightVisible=function(){var t=this.getHighlightedResults();if(0!==t.length){var e=this.$results.find("[aria-selected]").index(t),n=this.$results.offset().top,r=t.offset().top,i=this.$results.scrollTop()+(r-n),o=r-n;i-=2*t.outerHeight(!1),e<=2?this.$results.scrollTop(0):(o>this.$results.outerHeight()||o<0)&&this.$results.scrollTop(i)}},n.prototype.template=function(e,n){var r=this.options.get("templateResult"),i=this.options.get("escapeMarkup"),o=r(e,n);null==o?n.style.display="none":"string"==typeof o?n.innerHTML=i(o):t(n).append(o)},n}),e.define("select2/keys",[],function(){return{BACKSPACE:8,TAB:9,ENTER:13,SHIFT:16,CTRL:17,ALT:18,ESC:27,SPACE:32,PAGE_UP:33,PAGE_DOWN:34,END:35,HOME:36,LEFT:37,UP:38,RIGHT:39,DOWN:40,DELETE:46}}),e.define("select2/selection/base",["jquery","../utils","../keys"],function(t,e,n){function r(t,e){this.$element=t,this.options=e,r.__super__.constructor.call(this)}return e.Extend(r,e.Observable),r.prototype.render=function(){var n=t('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');return this._tabindex=0,null!=e.GetData(this.$element[0],"old-tabindex")?this._tabindex=e.GetData(this.$element[0],"old-tabindex"):null!=this.$element.attr("tabindex")&&(this._tabindex=this.$element.attr("tabindex")),n.attr("title",this.$element.attr("title")),n.attr("tabindex",this._tabindex),n.attr("aria-disabled","false"),this.$selection=n,n},r.prototype.bind=function(t,e){var r=this,i=t.id+"-results";this.container=t,this.$selection.on("focus",function(t){r.trigger("focus",t)}),this.$selection.on("blur",function(t){r._handleBlur(t)}),this.$selection.on("keydown",function(t){r.trigger("keypress",t),t.which===n.SPACE&&t.preventDefault()}),t.on("results:focus",function(t){r.$selection.attr("aria-activedescendant",t.data._resultId)}),t.on("selection:update",function(t){r.update(t.data)}),t.on("open",function(){r.$selection.attr("aria-expanded","true"),r.$selection.attr("aria-owns",i),r._attachCloseHandler(t)}),t.on("close",function(){r.$selection.attr("aria-expanded","false"),r.$selection.removeAttr("aria-activedescendant"),r.$selection.removeAttr("aria-owns"),r.$selection.trigger("focus"),r._detachCloseHandler(t)}),t.on("enable",function(){r.$selection.attr("tabindex",r._tabindex),r.$selection.attr("aria-disabled","false")}),t.on("disable",function(){r.$selection.attr("tabindex","-1"),r.$selection.attr("aria-disabled","true")})},r.prototype._handleBlur=function(e){var n=this;window.setTimeout(function(){document.activeElement==n.$selection[0]||t.contains(n.$selection[0],document.activeElement)||n.trigger("blur",e)},1)},r.prototype._attachCloseHandler=function(n){t(document.body).on("mousedown.select2."+n.id,function(n){var r=t(n.target).closest(".select2");t(".select2.select2-container--open").each(function(){this!=r[0]&&e.GetData(this,"element").select2("close")})})},r.prototype._detachCloseHandler=function(e){t(document.body).off("mousedown.select2."+e.id)},r.prototype.position=function(t,e){e.find(".selection").append(t)},r.prototype.destroy=function(){this._detachCloseHandler(this.container)},r.prototype.update=function(t){throw new Error("The `update` method must be defined in child classes.")},r.prototype.isEnabled=function(){return!this.isDisabled()},r.prototype.isDisabled=function(){return this.options.get("disabled")},r}),e.define("select2/selection/single",["jquery","./base","../utils","../keys"],function(t,e,n,r){function i(){i.__super__.constructor.apply(this,arguments)}return n.Extend(i,e),i.prototype.render=function(){var t=i.__super__.render.call(this);return t.addClass("select2-selection--single"),t.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'),t},i.prototype.bind=function(t,e){var n=this;i.__super__.bind.apply(this,arguments);var r=t.id+"-container";this.$selection.find(".select2-selection__rendered").attr("id",r).attr("role","textbox").attr("aria-readonly","true"),this.$selection.attr("aria-labelledby",r),this.$selection.on("mousedown",function(t){1===t.which&&n.trigger("toggle",{originalEvent:t})}),this.$selection.on("focus",function(t){}),this.$selection.on("blur",function(t){}),t.on("focus",function(e){t.isOpen()||n.$selection.trigger("focus")})},i.prototype.clear=function(){var t=this.$selection.find(".select2-selection__rendered");t.empty(),t.removeAttr("title")},i.prototype.display=function(t,e){var n=this.options.get("templateSelection");return this.options.get("escapeMarkup")(n(t,e))},i.prototype.selectionContainer=function(){return t("<span></span>")},i.prototype.update=function(t){if(0!==t.length){var e=t[0],n=this.$selection.find(".select2-selection__rendered"),r=this.display(e,n);n.empty().append(r);var i=e.title||e.text;i?n.attr("title",i):n.removeAttr("title")}else this.clear()},i}),e.define("select2/selection/multiple",["jquery","./base","../utils"],function(t,e,n){function r(t,e){r.__super__.constructor.apply(this,arguments)}return n.Extend(r,e),r.prototype.render=function(){var t=r.__super__.render.call(this);return t.addClass("select2-selection--multiple"),t.html('<ul class="select2-selection__rendered"></ul>'),t},r.prototype.bind=function(e,i){var o=this;r.__super__.bind.apply(this,arguments),this.$selection.on("click",function(t){o.trigger("toggle",{originalEvent:t})}),this.$selection.on("click",".select2-selection__choice__remove",function(e){if(!o.isDisabled()){var r=t(this).parent(),i=n.GetData(r[0],"data");o.trigger("unselect",{originalEvent:e,data:i})}})},r.prototype.clear=function(){var t=this.$selection.find(".select2-selection__rendered");t.empty(),t.removeAttr("title")},r.prototype.display=function(t,e){var n=this.options.get("templateSelection");return this.options.get("escapeMarkup")(n(t,e))},r.prototype.selectionContainer=function(){return t('<li class="select2-selection__choice"><span class="select2-selection__choice__remove" role="presentation">&times;</span></li>')},r.prototype.update=function(t){if(this.clear(),0!==t.length){for(var e=[],r=0;r<t.length;r++){var i=t[r],o=this.selectionContainer(),s=this.display(i,o);o.append(s);var a=i.title||i.text;a&&o.attr("title",a),n.StoreData(o[0],"data",i),e.push(o)}var l=this.$selection.find(".select2-selection__rendered");n.appendMany(l,e)}},r}),e.define("select2/selection/placeholder",["../utils"],function(t){function e(t,e,n){this.placeholder=this.normalizePlaceholder(n.get("placeholder")),t.call(this,e,n)}return e.prototype.normalizePlaceholder=function(t,e){return"string"==typeof e&&(e={id:"",text:e}),e},e.prototype.createPlaceholder=function(t,e){var n=this.selectionContainer();return n.html(this.display(e)),n.addClass("select2-selection__placeholder").removeClass("select2-selection__choice"),n},e.prototype.update=function(t,e){var n=1==e.length&&e[0].id!=this.placeholder.id;if(e.length>1||n)return t.call(this,e);this.clear();var r=this.createPlaceholder(this.placeholder);this.$selection.find(".select2-selection__rendered").append(r)},e}),e.define("select2/selection/allowClear",["jquery","../keys","../utils"],function(t,e,n){function r(){}return r.prototype.bind=function(t,e,n){var r=this;t.call(this,e,n),null==this.placeholder&&this.options.get("debug")&&window.console&&console.error&&console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."),this.$selection.on("mousedown",".select2-selection__clear",function(t){r._handleClear(t)}),e.on("keypress",function(t){r._handleKeyboardClear(t,e)})},r.prototype._handleClear=function(t,e){if(!this.isDisabled()){var r=this.$selection.find(".select2-selection__clear");if(0!==r.length){e.stopPropagation();var i=n.GetData(r[0],"data"),o=this.$element.val();this.$element.val(this.placeholder.id);var s={data:i};if(this.trigger("clear",s),s.prevented)this.$element.val(o);else{for(var a=0;a<i.length;a++)if(s={data:i[a]},this.trigger("unselect",s),s.prevented)return void this.$element.val(o);this.$element.trigger("input").trigger("change"),this.trigger("toggle",{})}}}},r.prototype._handleKeyboardClear=function(t,n,r){r.isOpen()||n.which!=e.DELETE&&n.which!=e.BACKSPACE||this._handleClear(n)},r.prototype.update=function(e,r){if(e.call(this,r),!(this.$selection.find(".select2-selection__placeholder").length>0||0===r.length)){var i=this.options.get("translations").get("removeAllItems"),o=t('<span class="select2-selection__clear" title="'+i()+'">&times;</span>');n.StoreData(o[0],"data",r),this.$selection.find(".select2-selection__rendered").prepend(o)}},r}),e.define("select2/selection/search",["jquery","../utils","../keys"],function(t,e,n){function r(t,e,n){t.call(this,e,n)}return r.prototype.render=function(e){var n=t('<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" /></li>');this.$searchContainer=n,this.$search=n.find("input");var r=e.call(this);return this._transferTabIndex(),r},r.prototype.bind=function(t,r,i){var o=this,s=r.id+"-results";t.call(this,r,i),r.on("open",function(){o.$search.attr("aria-controls",s),o.$search.trigger("focus")}),r.on("close",function(){o.$search.val(""),o.$search.removeAttr("aria-controls"),o.$search.removeAttr("aria-activedescendant"),o.$search.trigger("focus")}),r.on("enable",function(){o.$search.prop("disabled",!1),o._transferTabIndex()}),r.on("disable",function(){o.$search.prop("disabled",!0)}),r.on("focus",function(t){o.$search.trigger("focus")}),r.on("results:focus",function(t){t.data._resultId?o.$search.attr("aria-activedescendant",t.data._resultId):o.$search.removeAttr("aria-activedescendant")}),this.$selection.on("focusin",".select2-search--inline",function(t){o.trigger("focus",t)}),this.$selection.on("focusout",".select2-search--inline",function(t){o._handleBlur(t)}),this.$selection.on("keydown",".select2-search--inline",function(t){if(t.stopPropagation(),o.trigger("keypress",t),o._keyUpPrevented=t.isDefaultPrevented(),t.which===n.BACKSPACE&&""===o.$search.val()){var r=o.$searchContainer.prev(".select2-selection__choice");if(r.length>0){var i=e.GetData(r[0],"data");o.searchRemoveChoice(i),t.preventDefault()}}}),this.$selection.on("click",".select2-search--inline",function(t){o.$search.val()&&t.stopPropagation()});var a=document.documentMode,l=a&&a<=11;this.$selection.on("input.searchcheck",".select2-search--inline",function(t){l?o.$selection.off("input.search input.searchcheck"):o.$selection.off("keyup.search")}),this.$selection.on("keyup.search input.search",".select2-search--inline",function(t){if(l&&"input"===t.type)o.$selection.off("input.search input.searchcheck");else{var e=t.which;e!=n.SHIFT&&e!=n.CTRL&&e!=n.ALT&&e!=n.TAB&&o.handleSearch(t)}})},r.prototype._transferTabIndex=function(t){this.$search.attr("tabindex",this.$selection.attr("tabindex")),this.$selection.attr("tabindex","-1")},r.prototype.createPlaceholder=function(t,e){this.$search.attr("placeholder",e.text)},r.prototype.update=function(t,e){var n=this.$search[0]==document.activeElement;this.$search.attr("placeholder",""),t.call(this,e),this.$selection.find(".select2-selection__rendered").append(this.$searchContainer),this.resizeSearch(),n&&this.$search.trigger("focus")},r.prototype.handleSearch=function(){if(this.resizeSearch(),!this._keyUpPrevented){var t=this.$search.val();this.trigger("query",{term:t})}this._keyUpPrevented=!1},r.prototype.searchRemoveChoice=function(t,e){this.trigger("unselect",{data:e}),this.$search.val(e.text),this.handleSearch()},r.prototype.resizeSearch=function(){this.$search.css("width","25px");var t="";""!==this.$search.attr("placeholder")?t=this.$selection.find(".select2-selection__rendered").width():t=.75*(this.$search.val().length+1)+"em";this.$search.css("width",t)},r}),e.define("select2/selection/eventRelay",["jquery"],function(t){function e(){}return e.prototype.bind=function(e,n,r){var i=this,o=["open","opening","close","closing","select","selecting","unselect","unselecting","clear","clearing"],s=["opening","closing","selecting","unselecting","clearing"];e.call(this,n,r),n.on("*",function(e,n){if(-1!==t.inArray(e,o)){n=n||{};var r=t.Event("select2:"+e,{params:n});i.$element.trigger(r),-1!==t.inArray(e,s)&&(n.prevented=r.isDefaultPrevented())}})},e}),e.define("select2/translation",["jquery","require"],function(t,e){function n(t){this.dict=t||{}}return n.prototype.all=function(){return this.dict},n.prototype.get=function(t){return this.dict[t]},n.prototype.extend=function(e){this.dict=t.extend({},e.all(),this.dict)},n._cache={},n.loadPath=function(t){if(!(t in n._cache)){var r=e(t);n._cache[t]=r}return new n(n._cache[t])},n}),e.define("select2/diacritics",[],function(){return{"Ⓐ":"A","Ａ":"A","À":"A","Á":"A","Â":"A","Ầ":"A","Ấ":"A","Ẫ":"A","Ẩ":"A","Ã":"A","Ā":"A","Ă":"A","Ằ":"A","Ắ":"A","Ẵ":"A","Ẳ":"A","Ȧ":"A","Ǡ":"A","Ä":"A","Ǟ":"A","Ả":"A","Å":"A","Ǻ":"A","Ǎ":"A","Ȁ":"A","Ȃ":"A","Ạ":"A","Ậ":"A","Ặ":"A","Ḁ":"A","Ą":"A","Ⱥ":"A","Ɐ":"A","Ꜳ":"AA","Æ":"AE","Ǽ":"AE","Ǣ":"AE","Ꜵ":"AO","Ꜷ":"AU","Ꜹ":"AV","Ꜻ":"AV","Ꜽ":"AY","Ⓑ":"B","Ｂ":"B","Ḃ":"B","Ḅ":"B","Ḇ":"B","Ƀ":"B","Ƃ":"B","Ɓ":"B","Ⓒ":"C","Ｃ":"C","Ć":"C","Ĉ":"C","Ċ":"C","Č":"C","Ç":"C","Ḉ":"C","Ƈ":"C","Ȼ":"C","Ꜿ":"C","Ⓓ":"D","Ｄ":"D","Ḋ":"D","Ď":"D","Ḍ":"D","Ḑ":"D","Ḓ":"D","Ḏ":"D","Đ":"D","Ƌ":"D","Ɗ":"D","Ɖ":"D","Ꝺ":"D","Ǳ":"DZ","Ǆ":"DZ","ǲ":"Dz","ǅ":"Dz","Ⓔ":"E","Ｅ":"E","È":"E","É":"E","Ê":"E","Ề":"E","Ế":"E","Ễ":"E","Ể":"E","Ẽ":"E","Ē":"E","Ḕ":"E","Ḗ":"E","Ĕ":"E","Ė":"E","Ë":"E","Ẻ":"E","Ě":"E","Ȅ":"E","Ȇ":"E","Ẹ":"E","Ệ":"E","Ȩ":"E","Ḝ":"E","Ę":"E","Ḙ":"E","Ḛ":"E","Ɛ":"E","Ǝ":"E","Ⓕ":"F","Ｆ":"F","Ḟ":"F","Ƒ":"F","Ꝼ":"F","Ⓖ":"G","Ｇ":"G","Ǵ":"G","Ĝ":"G","Ḡ":"G","Ğ":"G","Ġ":"G","Ǧ":"G","Ģ":"G","Ǥ":"G","Ɠ":"G","Ꞡ":"G","Ᵹ":"G","Ꝿ":"G","Ⓗ":"H","Ｈ":"H","Ĥ":"H","Ḣ":"H","Ḧ":"H","Ȟ":"H","Ḥ":"H","Ḩ":"H","Ḫ":"H","Ħ":"H","Ⱨ":"H","Ⱶ":"H","Ɥ":"H","Ⓘ":"I","Ｉ":"I","Ì":"I","Í":"I","Î":"I","Ĩ":"I","Ī":"I","Ĭ":"I","İ":"I","Ï":"I","Ḯ":"I","Ỉ":"I","Ǐ":"I","Ȉ":"I","Ȋ":"I","Ị":"I","Į":"I","Ḭ":"I","Ɨ":"I","Ⓙ":"J","Ｊ":"J","Ĵ":"J","Ɉ":"J","Ⓚ":"K","Ｋ":"K","Ḱ":"K","Ǩ":"K","Ḳ":"K","Ķ":"K","Ḵ":"K","Ƙ":"K","Ⱪ":"K","Ꝁ":"K","Ꝃ":"K","Ꝅ":"K","Ꞣ":"K","Ⓛ":"L","Ｌ":"L","Ŀ":"L","Ĺ":"L","Ľ":"L","Ḷ":"L","Ḹ":"L","Ļ":"L","Ḽ":"L","Ḻ":"L","Ł":"L","Ƚ":"L","Ɫ":"L","Ⱡ":"L","Ꝉ":"L","Ꝇ":"L","Ꞁ":"L","Ǉ":"LJ","ǈ":"Lj","Ⓜ":"M","Ｍ":"M","Ḿ":"M","Ṁ":"M","Ṃ":"M","Ɱ":"M","Ɯ":"M","Ⓝ":"N","Ｎ":"N","Ǹ":"N","Ń":"N","Ñ":"N","Ṅ":"N","Ň":"N","Ṇ":"N","Ņ":"N","Ṋ":"N","Ṉ":"N","Ƞ":"N","Ɲ":"N","Ꞑ":"N","Ꞥ":"N","Ǌ":"NJ","ǋ":"Nj","Ⓞ":"O","Ｏ":"O","Ò":"O","Ó":"O","Ô":"O","Ồ":"O","Ố":"O","Ỗ":"O","Ổ":"O","Õ":"O","Ṍ":"O","Ȭ":"O","Ṏ":"O","Ō":"O","Ṑ":"O","Ṓ":"O","Ŏ":"O","Ȯ":"O","Ȱ":"O","Ö":"O","Ȫ":"O","Ỏ":"O","Ő":"O","Ǒ":"O","Ȍ":"O","Ȏ":"O","Ơ":"O","Ờ":"O","Ớ":"O","Ỡ":"O","Ở":"O","Ợ":"O","Ọ":"O","Ộ":"O","Ǫ":"O","Ǭ":"O","Ø":"O","Ǿ":"O","Ɔ":"O","Ɵ":"O","Ꝋ":"O","Ꝍ":"O","Œ":"OE","Ƣ":"OI","Ꝏ":"OO","Ȣ":"OU","Ⓟ":"P","Ｐ":"P","Ṕ":"P","Ṗ":"P","Ƥ":"P","Ᵽ":"P","Ꝑ":"P","Ꝓ":"P","Ꝕ":"P","Ⓠ":"Q","Ｑ":"Q","Ꝗ":"Q","Ꝙ":"Q","Ɋ":"Q","Ⓡ":"R","Ｒ":"R","Ŕ":"R","Ṙ":"R","Ř":"R","Ȑ":"R","Ȓ":"R","Ṛ":"R","Ṝ":"R","Ŗ":"R","Ṟ":"R","Ɍ":"R","Ɽ":"R","Ꝛ":"R","Ꞧ":"R","Ꞃ":"R","Ⓢ":"S","Ｓ":"S","ẞ":"S","Ś":"S","Ṥ":"S","Ŝ":"S","Ṡ":"S","Š":"S","Ṧ":"S","Ṣ":"S","Ṩ":"S","Ș":"S","Ş":"S","Ȿ":"S","Ꞩ":"S","Ꞅ":"S","Ⓣ":"T","Ｔ":"T","Ṫ":"T","Ť":"T","Ṭ":"T","Ț":"T","Ţ":"T","Ṱ":"T","Ṯ":"T","Ŧ":"T","Ƭ":"T","Ʈ":"T","Ⱦ":"T","Ꞇ":"T","Ꜩ":"TZ","Ⓤ":"U","Ｕ":"U","Ù":"U","Ú":"U","Û":"U","Ũ":"U","Ṹ":"U","Ū":"U","Ṻ":"U","Ŭ":"U","Ü":"U","Ǜ":"U","Ǘ":"U","Ǖ":"U","Ǚ":"U","Ủ":"U","Ů":"U","Ű":"U","Ǔ":"U","Ȕ":"U","Ȗ":"U","Ư":"U","Ừ":"U","Ứ":"U","Ữ":"U","Ử":"U","Ự":"U","Ụ":"U","Ṳ":"U","Ų":"U","Ṷ":"U","Ṵ":"U","Ʉ":"U","Ⓥ":"V","Ｖ":"V","Ṽ":"V","Ṿ":"V","Ʋ":"V","Ꝟ":"V","Ʌ":"V","Ꝡ":"VY","Ⓦ":"W","Ｗ":"W","Ẁ":"W","Ẃ":"W","Ŵ":"W","Ẇ":"W","Ẅ":"W","Ẉ":"W","Ⱳ":"W","Ⓧ":"X","Ｘ":"X","Ẋ":"X","Ẍ":"X","Ⓨ":"Y","Ｙ":"Y","Ỳ":"Y","Ý":"Y","Ŷ":"Y","Ỹ":"Y","Ȳ":"Y","Ẏ":"Y","Ÿ":"Y","Ỷ":"Y","Ỵ":"Y","Ƴ":"Y","Ɏ":"Y","Ỿ":"Y","Ⓩ":"Z","Ｚ":"Z","Ź":"Z","Ẑ":"Z","Ż":"Z","Ž":"Z","Ẓ":"Z","Ẕ":"Z","Ƶ":"Z","Ȥ":"Z","Ɀ":"Z","Ⱬ":"Z","Ꝣ":"Z","ⓐ":"a","ａ":"a","ẚ":"a","à":"a","á":"a","â":"a","ầ":"a","ấ":"a","ẫ":"a","ẩ":"a","ã":"a","ā":"a","ă":"a","ằ":"a","ắ":"a","ẵ":"a","ẳ":"a","ȧ":"a","ǡ":"a","ä":"a","ǟ":"a","ả":"a","å":"a","ǻ":"a","ǎ":"a","ȁ":"a","ȃ":"a","ạ":"a","ậ":"a","ặ":"a","ḁ":"a","ą":"a","ⱥ":"a","ɐ":"a","ꜳ":"aa","æ":"ae","ǽ":"ae","ǣ":"ae","ꜵ":"ao","ꜷ":"au","ꜹ":"av","ꜻ":"av","ꜽ":"ay","ⓑ":"b","ｂ":"b","ḃ":"b","ḅ":"b","ḇ":"b","ƀ":"b","ƃ":"b","ɓ":"b","ⓒ":"c","ｃ":"c","ć":"c","ĉ":"c","ċ":"c","č":"c","ç":"c","ḉ":"c","ƈ":"c","ȼ":"c","ꜿ":"c","ↄ":"c","ⓓ":"d","ｄ":"d","ḋ":"d","ď":"d","ḍ":"d","ḑ":"d","ḓ":"d","ḏ":"d","đ":"d","ƌ":"d","ɖ":"d","ɗ":"d","ꝺ":"d","ǳ":"dz","ǆ":"dz","ⓔ":"e","ｅ":"e","è":"e","é":"e","ê":"e","ề":"e","ế":"e","ễ":"e","ể":"e","ẽ":"e","ē":"e","ḕ":"e","ḗ":"e","ĕ":"e","ė":"e","ë":"e","ẻ":"e","ě":"e","ȅ":"e","ȇ":"e","ẹ":"e","ệ":"e","ȩ":"e","ḝ":"e","ę":"e","ḙ":"e","ḛ":"e","ɇ":"e","ɛ":"e","ǝ":"e","ⓕ":"f","ｆ":"f","ḟ":"f","ƒ":"f","ꝼ":"f","ⓖ":"g","ｇ":"g","ǵ":"g","ĝ":"g","ḡ":"g","ğ":"g","ġ":"g","ǧ":"g","ģ":"g","ǥ":"g","ɠ":"g","ꞡ":"g","ᵹ":"g","ꝿ":"g","ⓗ":"h","ｈ":"h","ĥ":"h","ḣ":"h","ḧ":"h","ȟ":"h","ḥ":"h","ḩ":"h","ḫ":"h","ẖ":"h","ħ":"h","ⱨ":"h","ⱶ":"h","ɥ":"h","ƕ":"hv","ⓘ":"i","ｉ":"i","ì":"i","í":"i","î":"i","ĩ":"i","ī":"i","ĭ":"i","ï":"i","ḯ":"i","ỉ":"i","ǐ":"i","ȉ":"i","ȋ":"i","ị":"i","į":"i","ḭ":"i","ɨ":"i","ı":"i","ⓙ":"j","ｊ":"j","ĵ":"j","ǰ":"j","ɉ":"j","ⓚ":"k","ｋ":"k","ḱ":"k","ǩ":"k","ḳ":"k","ķ":"k","ḵ":"k","ƙ":"k","ⱪ":"k","ꝁ":"k","ꝃ":"k","ꝅ":"k","ꞣ":"k","ⓛ":"l","ｌ":"l","ŀ":"l","ĺ":"l","ľ":"l","ḷ":"l","ḹ":"l","ļ":"l","ḽ":"l","ḻ":"l","ſ":"l","ł":"l","ƚ":"l","ɫ":"l","ⱡ":"l","ꝉ":"l","ꞁ":"l","ꝇ":"l","ǉ":"lj","ⓜ":"m","ｍ":"m","ḿ":"m","ṁ":"m","ṃ":"m","ɱ":"m","ɯ":"m","ⓝ":"n","ｎ":"n","ǹ":"n","ń":"n","ñ":"n","ṅ":"n","ň":"n","ṇ":"n","ņ":"n","ṋ":"n","ṉ":"n","ƞ":"n","ɲ":"n","ŉ":"n","ꞑ":"n","ꞥ":"n","ǌ":"nj","ⓞ":"o","ｏ":"o","ò":"o","ó":"o","ô":"o","ồ":"o","ố":"o","ỗ":"o","ổ":"o","õ":"o","ṍ":"o","ȭ":"o","ṏ":"o","ō":"o","ṑ":"o","ṓ":"o","ŏ":"o","ȯ":"o","ȱ":"o","ö":"o","ȫ":"o","ỏ":"o","ő":"o","ǒ":"o","ȍ":"o","ȏ":"o","ơ":"o","ờ":"o","ớ":"o","ỡ":"o","ở":"o","ợ":"o","ọ":"o","ộ":"o","ǫ":"o","ǭ":"o","ø":"o","ǿ":"o","ɔ":"o","ꝋ":"o","ꝍ":"o","ɵ":"o","œ":"oe","ƣ":"oi","ȣ":"ou","ꝏ":"oo","ⓟ":"p","ｐ":"p","ṕ":"p","ṗ":"p","ƥ":"p","ᵽ":"p","ꝑ":"p","ꝓ":"p","ꝕ":"p","ⓠ":"q","ｑ":"q","ɋ":"q","ꝗ":"q","ꝙ":"q","ⓡ":"r","ｒ":"r","ŕ":"r","ṙ":"r","ř":"r","ȑ":"r","ȓ":"r","ṛ":"r","ṝ":"r","ŗ":"r","ṟ":"r","ɍ":"r","ɽ":"r","ꝛ":"r","ꞧ":"r","ꞃ":"r","ⓢ":"s","ｓ":"s","ß":"s","ś":"s","ṥ":"s","ŝ":"s","ṡ":"s","š":"s","ṧ":"s","ṣ":"s","ṩ":"s","ș":"s","ş":"s","ȿ":"s","ꞩ":"s","ꞅ":"s","ẛ":"s","ⓣ":"t","ｔ":"t","ṫ":"t","ẗ":"t","ť":"t","ṭ":"t","ț":"t","ţ":"t","ṱ":"t","ṯ":"t","ŧ":"t","ƭ":"t","ʈ":"t","ⱦ":"t","ꞇ":"t","ꜩ":"tz","ⓤ":"u","ｕ":"u","ù":"u","ú":"u","û":"u","ũ":"u","ṹ":"u","ū":"u","ṻ":"u","ŭ":"u","ü":"u","ǜ":"u","ǘ":"u","ǖ":"u","ǚ":"u","ủ":"u","ů":"u","ű":"u","ǔ":"u","ȕ":"u","ȗ":"u","ư":"u","ừ":"u","ứ":"u","ữ":"u","ử":"u","ự":"u","ụ":"u","ṳ":"u","ų":"u","ṷ":"u","ṵ":"u","ʉ":"u","ⓥ":"v","ｖ":"v","ṽ":"v","ṿ":"v","ʋ":"v","ꝟ":"v","ʌ":"v","ꝡ":"vy","ⓦ":"w","ｗ":"w","ẁ":"w","ẃ":"w","ŵ":"w","ẇ":"w","ẅ":"w","ẘ":"w","ẉ":"w","ⱳ":"w","ⓧ":"x","ｘ":"x","ẋ":"x","ẍ":"x","ⓨ":"y","ｙ":"y","ỳ":"y","ý":"y","ŷ":"y","ỹ":"y","ȳ":"y","ẏ":"y","ÿ":"y","ỷ":"y","ẙ":"y","ỵ":"y","ƴ":"y","ɏ":"y","ỿ":"y","ⓩ":"z","ｚ":"z","ź":"z","ẑ":"z","ż":"z","ž":"z","ẓ":"z","ẕ":"z","ƶ":"z","ȥ":"z","ɀ":"z","ⱬ":"z","ꝣ":"z","Ά":"Α","Έ":"Ε","Ή":"Η","Ί":"Ι","Ϊ":"Ι","Ό":"Ο","Ύ":"Υ","Ϋ":"Υ","Ώ":"Ω","ά":"α","έ":"ε","ή":"η","ί":"ι","ϊ":"ι","ΐ":"ι","ό":"ο","ύ":"υ","ϋ":"υ","ΰ":"υ","ώ":"ω","ς":"σ","’":"'"}}),e.define("select2/data/base",["../utils"],function(t){function e(t,n){e.__super__.constructor.call(this)}return t.Extend(e,t.Observable),e.prototype.current=function(t){throw new Error("The `current` method must be defined in child classes.")},e.prototype.query=function(t,e){throw new Error("The `query` method must be defined in child classes.")},e.prototype.bind=function(t,e){},e.prototype.destroy=function(){},e.prototype.generateResultId=function(e,n){var r=e.id+"-result-";return r+=t.generateChars(4),null!=n.id?r+="-"+n.id.toString():r+="-"+t.generateChars(4),r},e}),e.define("select2/data/select",["./base","../utils","jquery"],function(t,e,n){function r(t,e){this.$element=t,this.options=e,r.__super__.constructor.call(this)}return e.Extend(r,t),r.prototype.current=function(t){var e=[],r=this;this.$element.find(":selected").each(function(){var t=n(this),i=r.item(t);e.push(i)}),t(e)},r.prototype.select=function(t){var e=this;if(t.selected=!0,n(t.element).is("option"))return t.element.selected=!0,void this.$element.trigger("input").trigger("change");if(this.$element.prop("multiple"))this.current(function(r){var i=[];(t=[t]).push.apply(t,r);for(var o=0;o<t.length;o++){var s=t[o].id;-1===n.inArray(s,i)&&i.push(s)}e.$element.val(i),e.$element.trigger("input").trigger("change")});else{var r=t.id;this.$element.val(r),this.$element.trigger("input").trigger("change")}},r.prototype.unselect=function(t){var e=this;if(this.$element.prop("multiple")){if(t.selected=!1,n(t.element).is("option"))return t.element.selected=!1,void this.$element.trigger("input").trigger("change");this.current(function(r){for(var i=[],o=0;o<r.length;o++){var s=r[o].id;s!==t.id&&-1===n.inArray(s,i)&&i.push(s)}e.$element.val(i),e.$element.trigger("input").trigger("change")})}},r.prototype.bind=function(t,e){var n=this;this.container=t,t.on("select",function(t){n.select(t.data)}),t.on("unselect",function(t){n.unselect(t.data)})},r.prototype.destroy=function(){this.$element.find("*").each(function(){e.RemoveData(this)})},r.prototype.query=function(t,e){var r=[],i=this;this.$element.children().each(function(){var e=n(this);if(e.is("option")||e.is("optgroup")){var o=i.item(e),s=i.matches(t,o);null!==s&&r.push(s)}}),e({results:r})},r.prototype.addOptions=function(t){e.appendMany(this.$element,t)},r.prototype.option=function(t){var r;t.children?(r=document.createElement("optgroup")).label=t.text:void 0!==(r=document.createElement("option")).textContent?r.textContent=t.text:r.innerText=t.text,void 0!==t.id&&(r.value=t.id),t.disabled&&(r.disabled=!0),t.selected&&(r.selected=!0),t.title&&(r.title=t.title);var i=n(r),o=this._normalizeItem(t);return o.element=r,e.StoreData(r,"data",o),i},r.prototype.item=function(t){var r={};if(null!=(r=e.GetData(t[0],"data")))return r;if(t.is("option"))r={id:t.val(),text:t.text(),disabled:t.prop("disabled"),selected:t.prop("selected"),title:t.prop("title")};else if(t.is("optgroup")){r={text:t.prop("label"),children:[],title:t.prop("title")};for(var i=t.children("option"),o=[],s=0;s<i.length;s++){var a=n(i[s]),l=this.item(a);o.push(l)}r.children=o}return(r=this._normalizeItem(r)).element=t[0],e.StoreData(t[0],"data",r),r},r.prototype._normalizeItem=function(t){t!==Object(t)&&(t={id:t,text:t});return null!=(t=n.extend({},{text:""},t)).id&&(t.id=t.id.toString()),null!=t.text&&(t.text=t.text.toString()),null==t._resultId&&t.id&&null!=this.container&&(t._resultId=this.generateResultId(this.container,t)),n.extend({},{selected:!1,disabled:!1},t)},r.prototype.matches=function(t,e){return this.options.get("matcher")(t,e)},r}),e.define("select2/data/array",["./select","../utils","jquery"],function(t,e,n){function r(t,e){this._dataToConvert=e.get("data")||[],r.__super__.constructor.call(this,t,e)}return e.Extend(r,t),r.prototype.bind=function(t,e){r.__super__.bind.call(this,t,e),this.addOptions(this.convertToOptions(this._dataToConvert))},r.prototype.select=function(t){var e=this.$element.find("option").filter(function(e,n){return n.value==t.id.toString()});0===e.length&&(e=this.option(t),this.addOptions(e)),r.__super__.select.call(this,t)},r.prototype.convertToOptions=function(t){var r=this,i=this.$element.find("option"),o=i.map(function(){return r.item(n(this)).id}).get(),s=[];function a(t){return function(){return n(this).val()==t.id}}for(var l=0;l<t.length;l++){var u=this._normalizeItem(t[l]);if(n.inArray(u.id,o)>=0){var c=i.filter(a(u)),f=this.item(c),p=n.extend(!0,{},u,f),d=this.option(p);c.replaceWith(d)}else{var h=this.option(u);if(u.children){var v=this.convertToOptions(u.children);e.appendMany(h,v)}s.push(h)}}return s},r}),e.define("select2/data/ajax",["./array","../utils","jquery"],function(t,e,n){function r(t,e){this.ajaxOptions=this._applyDefaults(e.get("ajax")),null!=this.ajaxOptions.processResults&&(this.processResults=this.ajaxOptions.processResults),r.__super__.constructor.call(this,t,e)}return e.Extend(r,t),r.prototype._applyDefaults=function(t){var e={data:function(t){return n.extend({},t,{q:t.term})},transport:function(t,e,r){var i=n.ajax(t);return i.then(e),i.fail(r),i}};return n.extend({},e,t,!0)},r.prototype.processResults=function(t){return t},r.prototype.query=function(t,e){var r=this;null!=this._request&&(n.isFunction(this._request.abort)&&this._request.abort(),this._request=null);var i=n.extend({type:"GET"},this.ajaxOptions);function o(){var o=i.transport(i,function(i){var o=r.processResults(i,t);r.options.get("debug")&&window.console&&console.error&&(o&&o.results&&n.isArray(o.results)||console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")),e(o)},function(){"status"in o&&(0===o.status||"0"===o.status)||r.trigger("results:message",{message:"errorLoading"})});r._request=o}"function"==typeof i.url&&(i.url=i.url.call(this.$element,t)),"function"==typeof i.data&&(i.data=i.data.call(this.$element,t)),this.ajaxOptions.delay&&null!=t.term?(this._queryTimeout&&window.clearTimeout(this._queryTimeout),this._queryTimeout=window.setTimeout(o,this.ajaxOptions.delay)):o()},r}),e.define("select2/data/tags",["jquery"],function(t){function e(e,n,r){var i=r.get("tags"),o=r.get("createTag");void 0!==o&&(this.createTag=o);var s=r.get("insertTag");if(void 0!==s&&(this.insertTag=s),e.call(this,n,r),t.isArray(i))for(var a=0;a<i.length;a++){var l=i[a],u=this._normalizeItem(l),c=this.option(u);this.$element.append(c)}}return e.prototype.query=function(t,e,n){var r=this;this._removeOldTags(),null!=e.term&&null==e.page?t.call(this,e,function t(i,o){for(var s=i.results,a=0;a<s.length;a++){var l=s[a],u=null!=l.children&&!t({results:l.children},!0);if((l.text||"").toUpperCase()===(e.term||"").toUpperCase()||u)return!o&&(i.data=s,void n(i))}if(o)return!0;var c=r.createTag(e);if(null!=c){var f=r.option(c);f.attr("data-select2-tag",!0),r.addOptions([f]),r.insertTag(s,c)}i.results=s,n(i)}):t.call(this,e,n)},e.prototype.createTag=function(e,n){var r=t.trim(n.term);return""===r?null:{id:r,text:r}},e.prototype.insertTag=function(t,e,n){e.unshift(n)},e.prototype._removeOldTags=function(e){this.$element.find("option[data-select2-tag]").each(function(){this.selected||t(this).remove()})},e}),e.define("select2/data/tokenizer",["jquery"],function(t){function e(t,e,n){var r=n.get("tokenizer");void 0!==r&&(this.tokenizer=r),t.call(this,e,n)}return e.prototype.bind=function(t,e,n){t.call(this,e,n),this.$search=e.dropdown.$search||e.selection.$search||n.find(".select2-search__field")},e.prototype.query=function(e,n,r){var i=this;n.term=n.term||"";var o=this.tokenizer(n,this.options,function(e){var n=i._normalizeItem(e);if(!i.$element.find("option").filter(function(){return t(this).val()===n.id}).length){var r=i.option(n);r.attr("data-select2-tag",!0),i._removeOldTags(),i.addOptions([r])}!function(t){i.trigger("select",{data:t})}(n)});o.term!==n.term&&(this.$search.length&&(this.$search.val(o.term),this.$search.trigger("focus")),n.term=o.term),e.call(this,n,r)},e.prototype.tokenizer=function(e,n,r,i){for(var o=r.get("tokenSeparators")||[],s=n.term,a=0,l=this.createTag||function(t){return{id:t.term,text:t.term}};a<s.length;){var u=s[a];if(-1!==t.inArray(u,o)){var c=s.substr(0,a),f=l(t.extend({},n,{term:c}));null!=f?(i(f),s=s.substr(a+1)||"",a=0):a++}else a++}return{term:s}},e}),e.define("select2/data/minimumInputLength",[],function(){function t(t,e,n){this.minimumInputLength=n.get("minimumInputLength"),t.call(this,e,n)}return t.prototype.query=function(t,e,n){e.term=e.term||"",e.term.length<this.minimumInputLength?this.trigger("results:message",{message:"inputTooShort",args:{minimum:this.minimumInputLength,input:e.term,params:e}}):t.call(this,e,n)},t}),e.define("select2/data/maximumInputLength",[],function(){function t(t,e,n){this.maximumInputLength=n.get("maximumInputLength"),t.call(this,e,n)}return t.prototype.query=function(t,e,n){e.term=e.term||"",this.maximumInputLength>0&&e.term.length>this.maximumInputLength?this.trigger("results:message",{message:"inputTooLong",args:{maximum:this.maximumInputLength,input:e.term,params:e}}):t.call(this,e,n)},t}),e.define("select2/data/maximumSelectionLength",[],function(){function t(t,e,n){this.maximumSelectionLength=n.get("maximumSelectionLength"),t.call(this,e,n)}return t.prototype.bind=function(t,e,n){var r=this;t.call(this,e,n),e.on("select",function(){r._checkIfMaximumSelected()})},t.prototype.query=function(t,e,n){var r=this;this._checkIfMaximumSelected(function(){t.call(r,e,n)})},t.prototype._checkIfMaximumSelected=function(t,e){var n=this;this.current(function(t){var r=null!=t?t.length:0;n.maximumSelectionLength>0&&r>=n.maximumSelectionLength?n.trigger("results:message",{message:"maximumSelected",args:{maximum:n.maximumSelectionLength}}):e&&e()})},t}),e.define("select2/dropdown",["jquery","./utils"],function(t,e){function n(t,e){this.$element=t,this.options=e,n.__super__.constructor.call(this)}return e.Extend(n,e.Observable),n.prototype.render=function(){var e=t('<span class="select2-dropdown"><span class="select2-results"></span></span>');return e.attr("dir",this.options.get("dir")),this.$dropdown=e,e},n.prototype.bind=function(){},n.prototype.position=function(t,e){},n.prototype.destroy=function(){this.$dropdown.remove()},n}),e.define("select2/dropdown/search",["jquery","../utils"],function(t,e){function n(){}return n.prototype.render=function(e){var n=e.call(this),r=t('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" /></span>');return this.$searchContainer=r,this.$search=r.find("input"),n.prepend(r),n},n.prototype.bind=function(e,n,r){var i=this,o=n.id+"-results";e.call(this,n,r),this.$search.on("keydown",function(t){i.trigger("keypress",t),i._keyUpPrevented=t.isDefaultPrevented()}),this.$search.on("input",function(e){t(this).off("keyup")}),this.$search.on("keyup input",function(t){i.handleSearch(t)}),n.on("open",function(){i.$search.attr("tabindex",0),i.$search.attr("aria-controls",o),i.$search.trigger("focus"),window.setTimeout(function(){i.$search.trigger("focus")},0)}),n.on("close",function(){i.$search.attr("tabindex",-1),i.$search.removeAttr("aria-controls"),i.$search.removeAttr("aria-activedescendant"),i.$search.val(""),i.$search.trigger("blur")}),n.on("focus",function(){n.isOpen()||i.$search.trigger("focus")}),n.on("results:all",function(t){null!=t.query.term&&""!==t.query.term||(i.showSearch(t)?i.$searchContainer.removeClass("select2-search--hide"):i.$searchContainer.addClass("select2-search--hide"))}),n.on("results:focus",function(t){t.data._resultId?i.$search.attr("aria-activedescendant",t.data._resultId):i.$search.removeAttr("aria-activedescendant")})},n.prototype.handleSearch=function(t){if(!this._keyUpPrevented){var e=this.$search.val();this.trigger("query",{term:e})}this._keyUpPrevented=!1},n.prototype.showSearch=function(t,e){return!0},n}),e.define("select2/dropdown/hidePlaceholder",[],function(){function t(t,e,n,r){this.placeholder=this.normalizePlaceholder(n.get("placeholder")),t.call(this,e,n,r)}return t.prototype.append=function(t,e){e.results=this.removePlaceholder(e.results),t.call(this,e)},t.prototype.normalizePlaceholder=function(t,e){return"string"==typeof e&&(e={id:"",text:e}),e},t.prototype.removePlaceholder=function(t,e){for(var n=e.slice(0),r=e.length-1;r>=0;r--){var i=e[r];this.placeholder.id===i.id&&n.splice(r,1)}return n},t}),e.define("select2/dropdown/infiniteScroll",["jquery"],function(t){function e(t,e,n,r){this.lastParams={},t.call(this,e,n,r),this.$loadingMore=this.createLoadingMore(),this.loading=!1}return e.prototype.append=function(t,e){this.$loadingMore.remove(),this.loading=!1,t.call(this,e),this.showLoadingMore(e)&&(this.$results.append(this.$loadingMore),this.loadMoreIfNeeded())},e.prototype.bind=function(t,e,n){var r=this;t.call(this,e,n),e.on("query",function(t){r.lastParams=t,r.loading=!0}),e.on("query:append",function(t){r.lastParams=t,r.loading=!0}),this.$results.on("scroll",this.loadMoreIfNeeded.bind(this))},e.prototype.loadMoreIfNeeded=function(){var e=t.contains(document.documentElement,this.$loadingMore[0]);!this.loading&&e&&(this.$results.offset().top+this.$results.outerHeight(!1)+50>=this.$loadingMore.offset().top+this.$loadingMore.outerHeight(!1)&&this.loadMore())},e.prototype.loadMore=function(){this.loading=!0;var e=t.extend({},{page:1},this.lastParams);e.page++,this.trigger("query:append",e)},e.prototype.showLoadingMore=function(t,e){return e.pagination&&e.pagination.more},e.prototype.createLoadingMore=function(){var e=t('<li class="select2-results__option select2-results__option--load-more"role="option" aria-disabled="true"></li>'),n=this.options.get("translations").get("loadingMore");return e.html(n(this.lastParams)),e},e}),e.define("select2/dropdown/attachBody",["jquery","../utils"],function(t,e){function n(e,n,r){this.$dropdownParent=t(r.get("dropdownParent")||document.body),e.call(this,n,r)}return n.prototype.bind=function(t,e,n){var r=this;t.call(this,e,n),e.on("open",function(){r._showDropdown(),r._attachPositioningHandler(e),r._bindContainerResultHandlers(e)}),e.on("close",function(){r._hideDropdown(),r._detachPositioningHandler(e)}),this.$dropdownContainer.on("mousedown",function(t){t.stopPropagation()})},n.prototype.destroy=function(t){t.call(this),this.$dropdownContainer.remove()},n.prototype.position=function(t,e,n){e.attr("class",n.attr("class")),e.removeClass("select2"),e.addClass("select2-container--open"),e.css({position:"absolute",top:-999999}),this.$container=n},n.prototype.render=function(e){var n=t("<span></span>"),r=e.call(this);return n.append(r),this.$dropdownContainer=n,n},n.prototype._hideDropdown=function(t){this.$dropdownContainer.detach()},n.prototype._bindContainerResultHandlers=function(t,e){if(!this._containerResultsHandlersBound){var n=this;e.on("results:all",function(){n._positionDropdown(),n._resizeDropdown()}),e.on("results:append",function(){n._positionDropdown(),n._resizeDropdown()}),e.on("results:message",function(){n._positionDropdown(),n._resizeDropdown()}),e.on("select",function(){n._positionDropdown(),n._resizeDropdown()}),e.on("unselect",function(){n._positionDropdown(),n._resizeDropdown()}),this._containerResultsHandlersBound=!0}},n.prototype._attachPositioningHandler=function(n,r){var i=this,o="scroll.select2."+r.id,s="resize.select2."+r.id,a="orientationchange.select2."+r.id,l=this.$container.parents().filter(e.hasScroll);l.each(function(){e.StoreData(this,"select2-scroll-position",{x:t(this).scrollLeft(),y:t(this).scrollTop()})}),l.on(o,function(n){var r=e.GetData(this,"select2-scroll-position");t(this).scrollTop(r.y)}),t(window).on(o+" "+s+" "+a,function(t){i._positionDropdown(),i._resizeDropdown()})},n.prototype._detachPositioningHandler=function(n,r){var i="scroll.select2."+r.id,o="resize.select2."+r.id,s="orientationchange.select2."+r.id;this.$container.parents().filter(e.hasScroll).off(i),t(window).off(i+" "+o+" "+s)},n.prototype._positionDropdown=function(){var e=t(window),n=this.$dropdown.hasClass("select2-dropdown--above"),r=this.$dropdown.hasClass("select2-dropdown--below"),i=null,o=this.$container.offset();o.bottom=o.top+this.$container.outerHeight(!1);var s={height:this.$container.outerHeight(!1)};s.top=o.top,s.bottom=o.top+s.height;var a=this.$dropdown.outerHeight(!1),l=e.scrollTop(),u=e.scrollTop()+e.height(),c=l<o.top-a,f=u>o.bottom+a,p={left:o.left,top:s.bottom},d=this.$dropdownParent;"static"===d.css("position")&&(d=d.offsetParent());var h={top:0,left:0};(t.contains(document.body,d[0])||d[0].isConnected)&&(h=d.offset()),p.top-=h.top,p.left-=h.left,n||r||(i="below"),f||!c||n?!c&&f&&n&&(i="below"):i="above",("above"==i||n&&"below"!==i)&&(p.top=s.top-h.top-a),null!=i&&(this.$dropdown.removeClass("select2-dropdown--below select2-dropdown--above").addClass("select2-dropdown--"+i),this.$container.removeClass("select2-container--below select2-container--above").addClass("select2-container--"+i)),this.$dropdownContainer.css(p)},n.prototype._resizeDropdown=function(){var t={width:this.$container.outerWidth(!1)+"px"};this.options.get("dropdownAutoWidth")&&(t.minWidth=t.width,t.position="relative",t.width="auto"),this.$dropdown.css(t)},n.prototype._showDropdown=function(t){this.$dropdownContainer.appendTo(this.$dropdownParent),this._positionDropdown(),this._resizeDropdown()},n}),e.define("select2/dropdown/minimumResultsForSearch",[],function(){function t(t,e,n,r){this.minimumResultsForSearch=n.get("minimumResultsForSearch"),this.minimumResultsForSearch<0&&(this.minimumResultsForSearch=1/0),t.call(this,e,n,r)}return t.prototype.showSearch=function(t,e){return!(function t(e){for(var n=0,r=0;r<e.length;r++){var i=e[r];i.children?n+=t(i.children):n++}return n}(e.data.results)<this.minimumResultsForSearch)&&t.call(this,e)},t}),e.define("select2/dropdown/selectOnClose",["../utils"],function(t){function e(){}return e.prototype.bind=function(t,e,n){var r=this;t.call(this,e,n),e.on("close",function(t){r._handleSelectOnClose(t)})},e.prototype._handleSelectOnClose=function(e,n){if(n&&null!=n.originalSelect2Event){var r=n.originalSelect2Event;if("select"===r._type||"unselect"===r._type)return}var i=this.getHighlightedResults();if(!(i.length<1)){var o=t.GetData(i[0],"data");null!=o.element&&o.element.selected||null==o.element&&o.selected||this.trigger("select",{data:o})}},e}),e.define("select2/dropdown/closeOnSelect",[],function(){function t(){}return t.prototype.bind=function(t,e,n){var r=this;t.call(this,e,n),e.on("select",function(t){r._selectTriggered(t)}),e.on("unselect",function(t){r._selectTriggered(t)})},t.prototype._selectTriggered=function(t,e){var n=e.originalEvent;n&&(n.ctrlKey||n.metaKey)||this.trigger("close",{originalEvent:n,originalSelect2Event:e})},t}),e.define("select2/i18n/en",[],function(){return{errorLoading:function(){return"The results could not be loaded."},inputTooLong:function(t){var e=t.input.length-t.maximum,n="Please delete "+e+" character";return 1!=e&&(n+="s"),n},inputTooShort:function(t){return"Please enter "+(t.minimum-t.input.length)+" or more characters"},loadingMore:function(){return"Loading more results…"},maximumSelected:function(t){var e="You can only select "+t.maximum+" item";return 1!=t.maximum&&(e+="s"),e},noResults:function(){return"No results found"},searching:function(){return"Searching…"},removeAllItems:function(){return"Remove all items"}}}),e.define("select2/defaults",["jquery","require","./results","./selection/single","./selection/multiple","./selection/placeholder","./selection/allowClear","./selection/search","./selection/eventRelay","./utils","./translation","./diacritics","./data/select","./data/array","./data/ajax","./data/tags","./data/tokenizer","./data/minimumInputLength","./data/maximumInputLength","./data/maximumSelectionLength","./dropdown","./dropdown/search","./dropdown/hidePlaceholder","./dropdown/infiniteScroll","./dropdown/attachBody","./dropdown/minimumResultsForSearch","./dropdown/selectOnClose","./dropdown/closeOnSelect","./i18n/en"],function(t,e,n,r,i,o,s,a,l,u,c,f,p,d,h,v,g,m,y,_,b,w,x,C,$,T,A,k,E){function S(){this.reset()}return S.prototype.apply=function(c){if(null==(c=t.extend(!0,{},this.defaults,c)).dataAdapter){if(null!=c.ajax?c.dataAdapter=h:null!=c.data?c.dataAdapter=d:c.dataAdapter=p,c.minimumInputLength>0&&(c.dataAdapter=u.Decorate(c.dataAdapter,m)),c.maximumInputLength>0&&(c.dataAdapter=u.Decorate(c.dataAdapter,y)),c.maximumSelectionLength>0&&(c.dataAdapter=u.Decorate(c.dataAdapter,_)),c.tags&&(c.dataAdapter=u.Decorate(c.dataAdapter,v)),null==c.tokenSeparators&&null==c.tokenizer||(c.dataAdapter=u.Decorate(c.dataAdapter,g)),null!=c.query){var f=e(c.amdBase+"compat/query");c.dataAdapter=u.Decorate(c.dataAdapter,f)}if(null!=c.initSelection){var E=e(c.amdBase+"compat/initSelection");c.dataAdapter=u.Decorate(c.dataAdapter,E)}}if(null==c.resultsAdapter&&(c.resultsAdapter=n,null!=c.ajax&&(c.resultsAdapter=u.Decorate(c.resultsAdapter,C)),null!=c.placeholder&&(c.resultsAdapter=u.Decorate(c.resultsAdapter,x)),c.selectOnClose&&(c.resultsAdapter=u.Decorate(c.resultsAdapter,A))),null==c.dropdownAdapter){if(c.multiple)c.dropdownAdapter=b;else{var S=u.Decorate(b,w);c.dropdownAdapter=S}if(0!==c.minimumResultsForSearch&&(c.dropdownAdapter=u.Decorate(c.dropdownAdapter,T)),c.closeOnSelect&&(c.dropdownAdapter=u.Decorate(c.dropdownAdapter,k)),null!=c.dropdownCssClass||null!=c.dropdownCss||null!=c.adaptDropdownCssClass){var O=e(c.amdBase+"compat/dropdownCss");c.dropdownAdapter=u.Decorate(c.dropdownAdapter,O)}c.dropdownAdapter=u.Decorate(c.dropdownAdapter,$)}if(null==c.selectionAdapter){if(c.multiple?c.selectionAdapter=i:c.selectionAdapter=r,null!=c.placeholder&&(c.selectionAdapter=u.Decorate(c.selectionAdapter,o)),c.allowClear&&(c.selectionAdapter=u.Decorate(c.selectionAdapter,s)),c.multiple&&(c.selectionAdapter=u.Decorate(c.selectionAdapter,a)),null!=c.containerCssClass||null!=c.containerCss||null!=c.adaptContainerCssClass){var D=e(c.amdBase+"compat/containerCss");c.selectionAdapter=u.Decorate(c.selectionAdapter,D)}c.selectionAdapter=u.Decorate(c.selectionAdapter,l)}c.language=this._resolveLanguage(c.language),c.language.push("en");for(var j=[],N=0;N<c.language.length;N++){var I=c.language[N];-1===j.indexOf(I)&&j.push(I)}return c.language=j,c.translations=this._processTranslations(c.language,c.debug),c},S.prototype.reset=function(){function e(t){return t.replace(/[^\u0000-\u007E]/g,function(t){return f[t]||t})}this.defaults={amdBase:"./",amdLanguageBase:"./i18n/",closeOnSelect:!0,debug:!1,dropdownAutoWidth:!1,escapeMarkup:u.escapeMarkup,language:{},matcher:function n(r,i){if(""===t.trim(r.term))return i;if(i.children&&i.children.length>0){for(var o=t.extend(!0,{},i),s=i.children.length-1;s>=0;s--)null==n(r,i.children[s])&&o.children.splice(s,1);return o.children.length>0?o:n(r,o)}var a=e(i.text).toUpperCase(),l=e(r.term).toUpperCase();return a.indexOf(l)>-1?i:null},minimumInputLength:0,maximumInputLength:0,maximumSelectionLength:0,minimumResultsForSearch:0,selectOnClose:!1,scrollAfterSelect:!1,sorter:function(t){return t},templateResult:function(t){return t.text},templateSelection:function(t){return t.text},theme:"default",width:"resolve"}},S.prototype.applyFromElement=function(t,e){var n=t.language,r=this.defaults.language,i=e.prop("lang"),o=e.closest("[lang]").prop("lang"),s=Array.prototype.concat.call(this._resolveLanguage(i),this._resolveLanguage(n),this._resolveLanguage(r),this._resolveLanguage(o));return t.language=s,t},S.prototype._resolveLanguage=function(e){if(!e)return[];if(t.isEmptyObject(e))return[];if(t.isPlainObject(e))return[e];var n;n=t.isArray(e)?e:[e];for(var r=[],i=0;i<n.length;i++)if(r.push(n[i]),"string"==typeof n[i]&&n[i].indexOf("-")>0){var o=n[i].split("-")[0];r.push(o)}return r},S.prototype._processTranslations=function(e,n){for(var r=new c,i=0;i<e.length;i++){var o=new c,s=e[i];if("string"==typeof s)try{o=c.loadPath(s)}catch(t){try{s=this.defaults.amdLanguageBase+s,o=c.loadPath(s)}catch(t){n&&window.console&&console.warn&&console.warn('Select2: The language file for "'+s+'" could not be automatically loaded. A fallback will be used instead.')}}else o=t.isPlainObject(s)?new c(s):s;r.extend(o)}return r},S.prototype.set=function(e,n){var r={};r[t.camelCase(e)]=n;var i=u._convertData(r);t.extend(!0,this.defaults,i)},new S}),e.define("select2/options",["require","jquery","./defaults","./utils"],function(t,e,n,r){function i(e,i){if(this.options=e,null!=i&&this.fromElement(i),null!=i&&(this.options=n.applyFromElement(this.options,i)),this.options=n.apply(this.options),i&&i.is("input")){var o=t(this.get("amdBase")+"compat/inputData");this.options.dataAdapter=r.Decorate(this.options.dataAdapter,o)}}return i.prototype.fromElement=function(t){var n=["select2"];null==this.options.multiple&&(this.options.multiple=t.prop("multiple")),null==this.options.disabled&&(this.options.disabled=t.prop("disabled")),null==this.options.dir&&(t.prop("dir")?this.options.dir=t.prop("dir"):t.closest("[dir]").prop("dir")?this.options.dir=t.closest("[dir]").prop("dir"):this.options.dir="ltr"),t.prop("disabled",this.options.disabled),t.prop("multiple",this.options.multiple),r.GetData(t[0],"select2Tags")&&(this.options.debug&&window.console&&console.warn&&console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'),r.StoreData(t[0],"data",r.GetData(t[0],"select2Tags")),r.StoreData(t[0],"tags",!0)),r.GetData(t[0],"ajaxUrl")&&(this.options.debug&&window.console&&console.warn&&console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."),t.attr("ajax--url",r.GetData(t[0],"ajaxUrl")),r.StoreData(t[0],"ajax-Url",r.GetData(t[0],"ajaxUrl")));var i={};function o(t,e){return e.toUpperCase()}for(var s=0;s<t[0].attributes.length;s++){var a=t[0].attributes[s].name;if("data-"==a.substr(0,"data-".length)){var l=a.substring("data-".length),u=r.GetData(t[0],l);i[l.replace(/-([a-z])/g,o)]=u}}e.fn.jquery&&"1."==e.fn.jquery.substr(0,2)&&t[0].dataset&&(i=e.extend(!0,{},t[0].dataset,i));var c=e.extend(!0,{},r.GetData(t[0]),i);for(var f in c=r._convertData(c))e.inArray(f,n)>-1||(e.isPlainObject(this.options[f])?e.extend(this.options[f],c[f]):this.options[f]=c[f]);return this},i.prototype.get=function(t){return this.options[t]},i.prototype.set=function(t,e){this.options[t]=e},i}),e.define("select2/core",["jquery","./options","./utils","./keys"],function(t,e,n,r){var i=function(t,r){null!=n.GetData(t[0],"select2")&&n.GetData(t[0],"select2").destroy(),this.$element=t,this.id=this._generateId(t),r=r||{},this.options=new e(r,t),i.__super__.constructor.call(this);var o=t.attr("tabindex")||0;n.StoreData(t[0],"old-tabindex",o),t.attr("tabindex","-1");var s=this.options.get("dataAdapter");this.dataAdapter=new s(t,this.options);var a=this.render();this._placeContainer(a);var l=this.options.get("selectionAdapter");this.selection=new l(t,this.options),this.$selection=this.selection.render(),this.selection.position(this.$selection,a);var u=this.options.get("dropdownAdapter");this.dropdown=new u(t,this.options),this.$dropdown=this.dropdown.render(),this.dropdown.position(this.$dropdown,a);var c=this.options.get("resultsAdapter");this.results=new c(t,this.options,this.dataAdapter),this.$results=this.results.render(),this.results.position(this.$results,this.$dropdown);var f=this;this._bindAdapters(),this._registerDomEvents(),this._registerDataEvents(),this._registerSelectionEvents(),this._registerDropdownEvents(),this._registerResultsEvents(),this._registerEvents(),this.dataAdapter.current(function(t){f.trigger("selection:update",{data:t})}),t.addClass("select2-hidden-accessible"),t.attr("aria-hidden","true"),this._syncAttributes(),n.StoreData(t[0],"select2",this),t.data("select2",this)};return n.Extend(i,n.Observable),i.prototype._generateId=function(t){return"select2-"+(null!=t.attr("id")?t.attr("id"):null!=t.attr("name")?t.attr("name")+"-"+n.generateChars(2):n.generateChars(4)).replace(/(:|\.|\[|\]|,)/g,"")},i.prototype._placeContainer=function(t){t.insertAfter(this.$element);var e=this._resolveWidth(this.$element,this.options.get("width"));null!=e&&t.css("width",e)},i.prototype._resolveWidth=function(t,e){var n=/^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;if("resolve"==e){var r=this._resolveWidth(t,"style");return null!=r?r:this._resolveWidth(t,"element")}if("element"==e){var i=t.outerWidth(!1);return i<=0?"auto":i+"px"}if("style"==e){var o=t.attr("style");if("string"!=typeof o)return null;for(var s=o.split(";"),a=0,l=s.length;a<l;a+=1){var u=s[a].replace(/\s/g,"").match(n);if(null!==u&&u.length>=1)return u[1]}return null}return"computedstyle"==e?window.getComputedStyle(t[0]).width:e},i.prototype._bindAdapters=function(){this.dataAdapter.bind(this,this.$container),this.selection.bind(this,this.$container),this.dropdown.bind(this,this.$container),this.results.bind(this,this.$container)},i.prototype._registerDomEvents=function(){var t=this;this.$element.on("change.select2",function(){t.dataAdapter.current(function(e){t.trigger("selection:update",{data:e})})}),this.$element.on("focus.select2",function(e){t.trigger("focus",e)}),this._syncA=n.bind(this._syncAttributes,this),this._syncS=n.bind(this._syncSubtree,this),this.$element[0].attachEvent&&this.$element[0].attachEvent("onpropertychange",this._syncA);var e=window.MutationObserver||window.WebKitMutationObserver||window.MozMutationObserver;null!=e?(this._observer=new e(function(e){t._syncA(),t._syncS(null,e)}),this._observer.observe(this.$element[0],{attributes:!0,childList:!0,subtree:!1})):this.$element[0].addEventListener&&(this.$element[0].addEventListener("DOMAttrModified",t._syncA,!1),this.$element[0].addEventListener("DOMNodeInserted",t._syncS,!1),this.$element[0].addEventListener("DOMNodeRemoved",t._syncS,!1))},i.prototype._registerDataEvents=function(){var t=this;this.dataAdapter.on("*",function(e,n){t.trigger(e,n)})},i.prototype._registerSelectionEvents=function(){var e=this,n=["toggle","focus"];this.selection.on("toggle",function(){e.toggleDropdown()}),this.selection.on("focus",function(t){e.focus(t)}),this.selection.on("*",function(r,i){-1===t.inArray(r,n)&&e.trigger(r,i)})},i.prototype._registerDropdownEvents=function(){var t=this;this.dropdown.on("*",function(e,n){t.trigger(e,n)})},i.prototype._registerResultsEvents=function(){var t=this;this.results.on("*",function(e,n){t.trigger(e,n)})},i.prototype._registerEvents=function(){var t=this;this.on("open",function(){t.$container.addClass("select2-container--open")}),this.on("close",function(){t.$container.removeClass("select2-container--open")}),this.on("enable",function(){t.$container.removeClass("select2-container--disabled")}),this.on("disable",function(){t.$container.addClass("select2-container--disabled")}),this.on("blur",function(){t.$container.removeClass("select2-container--focus")}),this.on("query",function(e){t.isOpen()||t.trigger("open",{}),this.dataAdapter.query(e,function(n){t.trigger("results:all",{data:n,query:e})})}),this.on("query:append",function(e){this.dataAdapter.query(e,function(n){t.trigger("results:append",{data:n,query:e})})}),this.on("keypress",function(e){var n=e.which;t.isOpen()?n===r.ESC||n===r.TAB||n===r.UP&&e.altKey?(t.close(e),e.preventDefault()):n===r.ENTER?(t.trigger("results:select",{}),e.preventDefault()):n===r.SPACE&&e.ctrlKey?(t.trigger("results:toggle",{}),e.preventDefault()):n===r.UP?(t.trigger("results:previous",{}),e.preventDefault()):n===r.DOWN&&(t.trigger("results:next",{}),e.preventDefault()):(n===r.ENTER||n===r.SPACE||n===r.DOWN&&e.altKey)&&(t.open(),e.preventDefault())})},i.prototype._syncAttributes=function(){this.options.set("disabled",this.$element.prop("disabled")),this.isDisabled()?(this.isOpen()&&this.close(),this.trigger("disable",{})):this.trigger("enable",{})},i.prototype._isChangeMutation=function(e,n){var r=!1,i=this;if(!e||!e.target||"OPTION"===e.target.nodeName||"OPTGROUP"===e.target.nodeName){if(n)if(n.addedNodes&&n.addedNodes.length>0)for(var o=0;o<n.addedNodes.length;o++){n.addedNodes[o].selected&&(r=!0)}else n.removedNodes&&n.removedNodes.length>0?r=!0:t.isArray(n)&&t.each(n,function(t,e){if(i._isChangeMutation(t,e))return r=!0,!1});else r=!0;return r}},i.prototype._syncSubtree=function(t,e){var n=this;this._isChangeMutation(t,e)&&this.dataAdapter.current(function(t){n.trigger("selection:update",{data:t})})},i.prototype.trigger=function(t,e){var n=i.__super__.trigger,r={open:"opening",close:"closing",select:"selecting",unselect:"unselecting",clear:"clearing"};if(void 0===e&&(e={}),t in r){var o=r[t],s={prevented:!1,name:t,args:e};if(n.call(this,o,s),s.prevented)return void(e.prevented=!0)}n.call(this,t,e)},i.prototype.toggleDropdown=function(){this.isDisabled()||(this.isOpen()?this.close():this.open())},i.prototype.open=function(){this.isOpen()||this.isDisabled()||this.trigger("query",{})},i.prototype.close=function(t){this.isOpen()&&this.trigger("close",{originalEvent:t})},i.prototype.isEnabled=function(){return!this.isDisabled()},i.prototype.isDisabled=function(){return this.options.get("disabled")},i.prototype.isOpen=function(){return this.$container.hasClass("select2-container--open")},i.prototype.hasFocus=function(){return this.$container.hasClass("select2-container--focus")},i.prototype.focus=function(t){this.hasFocus()||(this.$container.addClass("select2-container--focus"),this.trigger("focus",{}))},i.prototype.enable=function(t){this.options.get("debug")&&window.console&&console.warn&&console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.'),null!=t&&0!==t.length||(t=[!0]);var e=!t[0];this.$element.prop("disabled",e)},i.prototype.data=function(){this.options.get("debug")&&arguments.length>0&&window.console&&console.warn&&console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');var t=[];return this.dataAdapter.current(function(e){t=e}),t},i.prototype.val=function(e){if(this.options.get("debug")&&window.console&&console.warn&&console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'),null==e||0===e.length)return this.$element.val();var n=e[0];t.isArray(n)&&(n=t.map(n,function(t){return t.toString()})),this.$element.val(n).trigger("input").trigger("change")},i.prototype.destroy=function(){this.$container.remove(),this.$element[0].detachEvent&&this.$element[0].detachEvent("onpropertychange",this._syncA),null!=this._observer?(this._observer.disconnect(),this._observer=null):this.$element[0].removeEventListener&&(this.$element[0].removeEventListener("DOMAttrModified",this._syncA,!1),this.$element[0].removeEventListener("DOMNodeInserted",this._syncS,!1),this.$element[0].removeEventListener("DOMNodeRemoved",this._syncS,!1)),this._syncA=null,this._syncS=null,this.$element.off(".select2"),this.$element.attr("tabindex",n.GetData(this.$element[0],"old-tabindex")),this.$element.removeClass("select2-hidden-accessible"),this.$element.attr("aria-hidden","false"),n.RemoveData(this.$element[0]),this.$element.removeData("select2"),this.dataAdapter.destroy(),this.selection.destroy(),this.dropdown.destroy(),this.results.destroy(),this.dataAdapter=null,this.selection=null,this.dropdown=null,this.results=null},i.prototype.render=function(){var e=t('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');return e.attr("dir",this.options.get("dir")),this.$container=e,this.$container.addClass("select2-container--"+this.options.get("theme")),n.StoreData(e[0],"element",this.$element),e},i}),e.define("jquery-mousewheel",["jquery"],function(t){return t}),e.define("jquery.select2",["jquery","jquery-mousewheel","./select2/core","./select2/defaults","./select2/utils"],function(t,e,n,r,i){if(null==t.fn.select2){var o=["open","close","destroy"];t.fn.select2=function(e){if("object"==typeof(e=e||{}))return this.each(function(){var r=t.extend(!0,{},e);new n(t(this),r)}),this;if("string"==typeof e){var r,s=Array.prototype.slice.call(arguments,1);return this.each(function(){var t=i.GetData(this,"select2");null==t&&window.console&&console.error&&console.error("The select2('"+e+"') method was called on an element that is not using Select2."),r=t[e].apply(t,s)}),t.inArray(e,o)>-1?this:r}throw new Error("Invalid arguments for Select2: "+e)}}return null==t.fn.select2.defaults&&(t.fn.select2.defaults=r),n}),{define:e.define,require:e.require}}(),n=e.require("jquery.select2");return t.fn.select2.amd=e,n},i=[n("7t+N")],void 0===(o="function"==typeof(r=s)?r.apply(e,i):r)||(t.exports=o)},jbHB:function(t,e){},kKvo:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,"tr{padding-left:30px}",""])},kxAE:function(t,e){},l9CE:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["file","customFields"],data:function(){return{activeFile:this.file,processDetail:!1,statusText:null,statusType:null,options:{importType:this.file.import_type,update:!1,importTypes:[{id:"asset",text:"Assets"},{id:"accessory",text:"Accessories"},{id:"consumable",text:"Consumables"},{id:"component",text:"Components"},{id:"license",text:"Licenses"},{id:"user",text:"Users"}],statusText:null},columnOptions:{general:[{id:"category",text:"Category"},{id:"company",text:"Company"},{id:"checkout_to",text:"Checked out to"},{id:"email",text:"Email"},{id:"item_name",text:"Item Name"},{id:"location",text:"Location"},{id:"maintained",text:"Maintained"},{id:"manufacturer",text:"Manufacturer"},{id:"notes",text:"Notes"},{id:"order_number",text:"Order Number"},{id:"purchase_cost",text:"Purchase Cost"},{id:"purchase_date",text:"Purchase Date"},{id:"quantity",text:"Quantity"},{id:"requestable",text:"Requestable"},{id:"serial",text:"Serial Number"},{id:"supplier",text:"Supplier"},{id:"username",text:"Username"},{id:"department",text:"Department"}],assets:[{id:"asset_tag",text:"Asset Tag"},{id:"asset_model",text:"Model Name"},{id:"checkout_class",text:"Checkout Type"},{id:"checkout_location",text:"Checkout Location"},{id:"image",text:"Image Filename"},{id:"model_number",text:"Model Number"},{id:"full_name",text:"Full Name"},{id:"status",text:"Status"},{id:"warranty_months",text:"Warranty Months"}],consumables:[{id:"item_no",text:"Item Number"},{id:"model_number",text:"Model Number"}],licenses:[{id:"expiration_date",text:"Expiration Date"},{id:"license_email",text:"Licensed To Email"},{id:"license_name",text:"Licensed To Name"},{id:"purchase_order",text:"Purchase Order"},{id:"reassignable",text:"Reassignable"},{id:"seats",text:"Seats"}],users:[{id:"employee_num",text:"Employee Number"},{id:"first_name",text:"First Name"},{id:"jobtitle",text:"Job Title"},{id:"last_name",text:"Last Name"},{id:"phone_number",text:"Phone Number"},{id:"manager_first_name",text:"Manager First Name"},{id:"manager_last_name",text:"Manager Last Name"},{id:"department",text:"Department"},{id:"activated",text:"Activated"}],customFields:this.customFields},columnMappings:this.file.field_map||{},activeColumn:null}},created:function(){window.eventHub.$on("showDetails",this.toggleExtendedDisplay),this.populateSelect2ActiveItems()},computed:{columns:function(){function t(t,e){return t.text<e.text?-1:t.text>e.text?1:0}switch(this.options.importType){case"asset":return this.columnOptions.general.concat(this.columnOptions.assets).concat(this.columnOptions.customFields).sort(t);case"consumable":return this.columnOptions.general.concat(this.columnOptions.consumables).sort(t);case"license":return this.columnOptions.general.concat(this.columnOptions.licenses).sort(t);case"user":return this.columnOptions.general.concat(this.columnOptions.users).sort(t)}return this.columnOptions.general},alertClass:function(){return"success"==this.statusType?"alert-success":"error"==this.statusType?"alert-danger":"alert-info"}},watch:{columns:function(){this.populateSelect2ActiveItems()}},methods:{postSave:function(){var t=this;if(console.log("saving"),console.log(this.options.importType),!this.options.importType)return this.statusType="error",void(this.statusText="An import type is required... ");this.statusType="pending",this.statusText="Processing...",this.$http.post(route("api.imports.importFile",this.file.id),{"import-update":this.options.update,"send-welcome":this.options.send_welcome,"import-type":this.options.importType,"column-mappings":this.columnMappings}).then(function(e){var n=e.body;t.statusType="success",t.statusText="Success... Redirecting.",window.location.href=n.messages.redirect_url},function(e){var n=e.body;"import-errors"==n.status?(window.eventHub.$emit("importErrors",n.messages),t.statusType="error",t.statusText="Error"):t.$emit("alert",{message:n.messages,type:"danger",visible:!0}),t.displayImportModal=!1})},populateSelect2ActiveItems:function(){if(null==this.file.field_map){for(var t=0;t<this.file.header_row.length;t++)this.$set(this.columnMappings,this.file.header_row[t],null);for(var e=0;e<this.columns.length;e++){var n=this.columns[e],r=this.file.header_row.map(function(t){return t.toLowerCase()}).indexOf(n.text.toLowerCase());-1!=r&&this.$set(this.columnMappings,this.file.header_row[r],n.id)}}},toggleExtendedDisplay:function(t){t==this.file.id&&(this.processDetail=!this.processDetail)},updateModel:function(t,e){this.columnMappings[t]=e}},components:{select2:n("YDmc")}}},lAxH:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};e.default={props:["tokenUrl","scopesUrl"],data:function(){return{accessToken:null,tokens:[],scopes:[],form:{name:"",scopes:[],errors:[]}}},ready:function(){this.prepareComponent()},mounted:function(){this.prepareComponent()},methods:{prepareComponent:function(){this.getTokens(),this.getScopes(),$("#modal-create-token").on("shown.bs.modal",function(){$("#create-token-name").focus()})},getTokens:function(){var t=this;this.$http.get(this.tokenUrl).then(function(e){t.tokens=e.data})},getScopes:function(){var t=this;this.$http.get(this.scopesUrl).then(function(e){t.scopes=e.data})},showCreateTokenForm:function(){$("#modal-create-token").modal("show")},store:function(){var t=this;this.accessToken=null,this.form.errors=[],this.$http.post(this.tokenUrl,this.form).then(function(e){t.form.name="",t.form.scopes=[],t.form.errors=[],t.tokens.push(e.data.token),t.showAccessToken(e.data.accessToken)}).catch(function(e){"object"===r(e.data)?t.form.errors=_.flatten(_.toArray(e.data)):(console.dir(t.form),t.form.errors=["Something went wrong. Please try again."])})},toggleScope:function(t){this.scopeIsAssigned(t)?this.form.scopes=_.reject(this.form.scopes,function(e){return e==t}):this.form.scopes.push(t)},scopeIsAssigned:function(t){return _.indexOf(this.form.scopes,t)>=0},showAccessToken:function(t){$("#modal-create-token").modal("hide"),this.accessToken=t,$("#modal-access-token").modal("show")},revoke:function(t){var e=this;this.$http.delete(this.tokenUrl+"/"+t.id).then(function(t){e.getTokens()})}}}},lP3N:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("div",{staticClass:"panel panel-default"},[n("div",{staticClass:"panel-heading"},[n("div",{staticStyle:{display:"flex","justify-content":"space-between","align-items":"center"}},[n("h2",[t._v("\n                    OAuth Clients\n                ")]),t._v(" "),n("a",{staticClass:"action-link",on:{click:t.showCreateClientForm}},[t._v("\n                    Create New Client\n                ")])])]),t._v(" "),n("div",{staticClass:"panel-body"},[0===t.clients.length?n("p",{staticClass:"m-b-none"},[t._v("\n                You have not created any OAuth clients.\n            ")]):t._e(),t._v(" "),t.clients.length>0?n("table",{staticClass:"table table-borderless m-b-none"},[t._m(0),t._v(" "),n("tbody",t._l(t.clients,function(e){return n("tr",[n("td",{staticStyle:{"vertical-align":"middle"}},[t._v("\n                            "+t._s(e.id)+"\n                        ")]),t._v(" "),n("td",{staticStyle:{"vertical-align":"middle"}},[t._v("\n                            "+t._s(e.name)+"\n                        ")]),t._v(" "),n("td",{staticStyle:{"vertical-align":"middle"}},[n("code",[t._v(t._s(e.secret))])]),t._v(" "),n("td",{staticStyle:{"vertical-align":"middle"}},[n("a",{staticClass:"action-link",on:{click:function(n){t.edit(e)}}},[t._v("\n                                Edit\n                            ")])]),t._v(" "),n("td",{staticStyle:{"vertical-align":"middle"}},[n("a",{staticClass:"action-link text-danger",on:{click:function(n){t.destroy(e)}}},[t._v("\n                                Delete\n                            ")])])])}))]):t._e()])]),t._v(" "),n("div",{staticClass:"modal fade",attrs:{id:"modal-create-client",tabindex:"-1",role:"dialog"}},[n("div",{staticClass:"modal-dialog"},[n("div",{staticClass:"modal-content"},[t._m(1),t._v(" "),n("div",{staticClass:"modal-body"},[t.createForm.errors.length>0?n("div",{staticClass:"alert alert-danger"},[t._m(2),t._v(" "),n("br"),t._v(" "),n("ul",t._l(t.createForm.errors,function(e){return n("li",[t._v("\n                                "+t._s(e)+"\n                            ")])}))]):t._e(),t._v(" "),n("form",{staticClass:"form-horizontal",attrs:{role:"form"}},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"col-md-3 control-label",attrs:{for:"create-client-name"}},[t._v("Name")]),t._v(" "),n("div",{staticClass:"col-md-7"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.createForm.name,expression:"createForm.name"}],staticClass:"form-control",attrs:{id:"create-client-name",type:"text","aria-label":"create-client-name"},domProps:{value:t.createForm.name},on:{keyup:function(e){if(!("button"in e)&&t._k(e.keyCode,"enter",13))return null;t.store(e)},input:function(e){e.target.composing||(t.createForm.name=e.target.value)}}}),t._v(" "),n("span",{staticClass:"help-block"},[t._v("\n                                    Something your users will recognize and trust.\n                                ")])])]),t._v(" "),n("div",{staticClass:"form-group"},[n("label",{staticClass:"col-md-3 control-label",attrs:{for:"redirect"}},[t._v("Redirect URL")]),t._v(" "),n("div",{staticClass:"col-md-7"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.createForm.redirect,expression:"createForm.redirect"}],staticClass:"form-control",attrs:{type:"text","aria-label":"redirect",name:"redirect"},domProps:{value:t.createForm.redirect},on:{keyup:function(e){if(!("button"in e)&&t._k(e.keyCode,"enter",13))return null;t.store(e)},input:function(e){e.target.composing||(t.createForm.redirect=e.target.value)}}}),t._v(" "),n("span",{staticClass:"help-block"},[t._v("\n                                    Your application's authorization callback URL.\n                                ")])])])])]),t._v(" "),n("div",{staticClass:"modal-footer"},[n("button",{staticClass:"btn btn-default",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")]),t._v(" "),n("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:t.store}},[t._v("\n                        Create\n                    ")])])])])]),t._v(" "),n("div",{staticClass:"modal fade",attrs:{id:"modal-edit-client",tabindex:"-1",role:"dialog"}},[n("div",{staticClass:"modal-dialog"},[n("div",{staticClass:"modal-content"},[t._m(3),t._v(" "),n("div",{staticClass:"modal-body"},[t.editForm.errors.length>0?n("div",{staticClass:"alert alert-danger"},[t._m(4),t._v(" "),n("br"),t._v(" "),n("ul",t._l(t.editForm.errors,function(e){return n("li",[t._v("\n                                "+t._s(e)+"\n                            ")])}))]):t._e(),t._v(" "),n("form",{staticClass:"form-horizontal",attrs:{role:"form"}},[n("div",{staticClass:"form-group"},[n("label",{staticClass:"col-md-3 control-label",attrs:{for:"edit-client-name"}},[t._v("Name")]),t._v(" "),n("div",{staticClass:"col-md-7"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.editForm.name,expression:"editForm.name"}],staticClass:"form-control",attrs:{id:"edit-client-name",type:"text","aria-label":"edit-client-name"},domProps:{value:t.editForm.name},on:{keyup:function(e){if(!("button"in e)&&t._k(e.keyCode,"enter",13))return null;t.update(e)},input:function(e){e.target.composing||(t.editForm.name=e.target.value)}}}),t._v(" "),n("span",{staticClass:"help-block"},[t._v("\n                                    Something your users will recognize and trust.\n                                ")])])]),t._v(" "),n("div",{staticClass:"form-group"},[n("label",{staticClass:"col-md-3 control-label",attrs:{for:"redirect"}},[t._v("Redirect URL")]),t._v(" "),n("div",{staticClass:"col-md-7"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.editForm.redirect,expression:"editForm.redirect"}],staticClass:"form-control",attrs:{type:"text",name:"redirect","aria-label":"redirect"},domProps:{value:t.editForm.redirect},on:{keyup:function(e){if(!("button"in e)&&t._k(e.keyCode,"enter",13))return null;t.update(e)},input:function(e){e.target.composing||(t.editForm.redirect=e.target.value)}}}),t._v(" "),n("span",{staticClass:"help-block"},[t._v("\n                                    Your application's authorization callback URL.\n                                ")])])])])]),t._v(" "),n("div",{staticClass:"modal-footer"},[n("button",{staticClass:"btn btn-default",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Close")]),t._v(" "),n("button",{staticClass:"btn btn-primary",attrs:{type:"button"},on:{click:t.update}},[t._v("\n                        Save Changes\n                    ")])])])])])])},staticRenderFns:[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("thead",[n("tr",[n("th",[t._v("Client ID")]),t._v(" "),n("th",[t._v("Name")]),t._v(" "),n("th",[t._v("Secret")]),t._v(" "),n("th",[n("span",{staticClass:"sr-only"},[t._v("Edit")])]),t._v(" "),n("th",[n("span",{staticClass:"sr-only"},[t._v("Delete")])])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button ","data-dismiss":"modal","aria-hidden":"true"}},[this._v("×")]),this._v(" "),e("h2",{staticClass:"modal-title"},[this._v("\n                        Create Client\n                    ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("p",[e("strong",[this._v("Whoops!")]),this._v(" Something went wrong!")])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"modal-header"},[e("button",{staticClass:"close",attrs:{type:"button ","data-dismiss":"modal","aria-hidden":"true"}},[this._v("×")]),this._v(" "),e("h2",{staticClass:"modal-title"},[this._v("\n                        Edit Client\n                    ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("p",[e("strong",[this._v("Whoops!")]),this._v(" Something went wrong!")])}]}},lafA:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t.show&&t.fields.length?n("div",[n("div",{staticClass:"form-group"},[n("fieldset",[n("legend",{staticClass:"col-md-3 control-label"},[t._v("Default Values")]),t._v(" "),n("div",{staticClass:"col-sm-8 col-xl-7"},[t.error?n("p",[t._v("\n                        There was a problem retrieving the fields for this fieldset.\n                    ")]):t._e(),t._v(" "),t._l(t.fields,function(e){return n("div",{staticClass:"row"},[n("div",{staticClass:"col-sm-12 col-lg-6"},[n("label",{staticClass:"control-label",attrs:{for:"default-value"+e.id}},[t._v(t._s(e.name))])]),t._v(" "),n("div",{staticClass:"col-sm-12 col-lg-6"},["text"==e.type?n("input",{staticClass:"form-control m-b-xs",attrs:{type:"text",id:"default-value"+e.id,name:"default_values["+e.id+"]"},domProps:{value:t.getValue(e)}}):t._e(),t._v(" "),"textarea"==e.type?n("textarea",{staticClass:"form-control",attrs:{id:"default-value"+e.id,name:"default_values["+e.id+"]"},domProps:{value:t.getValue(e)}}):t._e(),n("br"),t._v(" "),"listbox"==e.type?n("select",{staticClass:"form-control m-b-xs",attrs:{name:"default_values["+e.id+"]"}},[n("option",{attrs:{value:""}}),t._v(" "),t._l(e.field_values_array,function(r){return n("option",{domProps:{value:r,selected:t.getValue(e)==r}},[t._v(t._s(r))])})],2):t._e()])])})],2)])])]):t._e()])},staticRenderFns:[]}},m5pD:function(t,e){},oTR8:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[t.tokens.length>0?n("div",[n("div",{staticClass:"panel panel-default"},[n("h2",{staticClass:"panel-heading"},[t._v("Authorized Applications")]),t._v(" "),n("div",{staticClass:"panel-body"},[n("table",{staticClass:"table table-borderless m-b-none"},[t._m(0),t._v(" "),n("tbody",t._l(t.tokens,function(e){return n("tr",[n("td",{staticStyle:{"vertical-align":"middle"}},[t._v("\n                                "+t._s(e.client.name)+"\n                            ")]),t._v(" "),n("td",{staticStyle:{"vertical-align":"middle"}},[e.scopes.length>0?n("span",[t._v("\n                                    "+t._s(e.scopes.join(", "))+"\n                                ")]):t._e()]),t._v(" "),n("td",{staticStyle:{"vertical-align":"middle"}},[n("a",{staticClass:"action-link text-danger",on:{click:function(n){t.revoke(e)}}},[t._v("\n                                    Revoke\n                                ")])])])}))])])])]):t._e()])},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("thead",[e("tr",[e("th",[this._v("Name")]),this._v(" "),e("th",[this._v("Scopes")]),this._v(" "),e("th",[e("span",{staticClass:"sr-only"},[this._v("Delete")])])])])}]}},odlp:function(t,e,n){var r=n("5dd0");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("3e35568b",r,!0,{})},ooDj:function(t,e,n){var r=n("VU/8")(n("20cu"),n("oTR8"),!1,function(t){n("8Hdb")},"data-v-18abfa16",null);t.exports=r.exports},pQUU:function(t,e,n){(t.exports=n("FZ+f")(!1)).push([t.i,".action-link[data-v-18abfa16]{cursor:pointer}.m-b-none[data-v-18abfa16]{margin-bottom:0}",""])},qRSm:function(t,e,n){var r=n("kKvo");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("31d20659",r,!0,{})},rjj0:function(t,e,n){var r="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!r)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var i=n("tTVk"),o={},s=r&&(document.head||document.getElementsByTagName("head")[0]),a=null,l=0,u=!1,c=function(){},f=null,p="data-vue-ssr-id",d="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function h(t){for(var e=0;e<t.length;e++){var n=t[e],r=o[n.id];if(r){r.refs++;for(var i=0;i<r.parts.length;i++)r.parts[i](n.parts[i]);for(;i<n.parts.length;i++)r.parts.push(g(n.parts[i]));r.parts.length>n.parts.length&&(r.parts.length=n.parts.length)}else{var s=[];for(i=0;i<n.parts.length;i++)s.push(g(n.parts[i]));o[n.id]={id:n.id,refs:1,parts:s}}}}function v(){var t=document.createElement("style");return t.type="text/css",s.appendChild(t),t}function g(t){var e,n,r=document.querySelector("style["+p+'~="'+t.id+'"]');if(r){if(u)return c;r.parentNode.removeChild(r)}if(d){var i=l++;r=a||(a=v()),e=_.bind(null,r,i,!1),n=_.bind(null,r,i,!0)}else r=v(),e=function(t,e){var n=e.css,r=e.media,i=e.sourceMap;r&&t.setAttribute("media",r);f.ssrId&&t.setAttribute(p,e.id);i&&(n+="\n/*# sourceURL="+i.sources[0]+" */",n+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(i))))+" */");if(t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}.bind(null,r),n=function(){r.parentNode.removeChild(r)};return e(t),function(r){if(r){if(r.css===t.css&&r.media===t.media&&r.sourceMap===t.sourceMap)return;e(t=r)}else n()}}t.exports=function(t,e,n,r){u=n,f=r||{};var s=i(t,e);return h(s),function(e){for(var n=[],r=0;r<s.length;r++){var a=s[r];(l=o[a.id]).refs--,n.push(l)}e?h(s=i(t,e)):s=[];for(r=0;r<n.length;r++){var l;if(0===(l=n[r]).refs){for(var u=0;u<l.parts.length;u++)l.parts[u]();delete o[l.id]}}}};var m,y=(m=[],function(t,e){return m[t]=e,m.filter(Boolean).join("\n")});function _(t,e,n,r){var i=n?"":r.css;if(t.styleSheet)t.styleSheet.cssText=y(e,i);else{var o=document.createTextNode(i),s=t.childNodes;s[e]&&t.removeChild(s[e]),s.length?t.insertBefore(o,s[e]):t.appendChild(o)}}},rqPf:function(t,e,n){var r=n("hLk5");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("1ab6df0e",r,!0,{})},sJcK:function(t,e,n){var r=n("VU/8")(n("l9CE"),n("vT9Q"),!1,function(t){n("qRSm")},null,null);t.exports=r.exports},t80F:function(t,e){},tTVk:function(t,e){t.exports=function(t,e){for(var n=[],r={},i=0;i<e.length;i++){var o=e[i],s=o[0],a={id:t+":"+i,css:o[1],media:o[2],sourceMap:o[3]};r[s]?r[s].parts.push(a):n.push(r[s]={id:s,parts:[a]})}return n}},tZpc:function(t,e,n){var r=n("g9VR");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("2e084566",r,!0,{})},vT9Q:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{directives:[{name:"show",rawName:"v-show",value:t.processDetail,expression:"processDetail"}]},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-md-2"}),t._v(" "),n("div",{staticClass:"col-md-8",staticStyle:{"padding-top":"30px",margin:"0 auto"}},[n("div",{staticClass:"dynamic-form-row"},[t._m(0),t._v(" "),n("div",{staticClass:"col-md-7 col-xs-12"},[n("select2",{attrs:{options:t.options.importTypes,required:""},model:{value:t.options.importType,callback:function(e){t.options.importType=e},expression:"options.importType"}},[n("option",{attrs:{disabled:"",value:"0"}})])],1)]),t._v(" "),n("div",{staticClass:"dynamic-form-row"},[t._m(1),t._v(" "),n("div",{staticClass:"col-md-7 col-xs-12"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.options.update,expression:"options.update"}],attrs:{type:"checkbox",name:"import-update"},domProps:{checked:Array.isArray(t.options.update)?t._i(t.options.update,null)>-1:t.options.update},on:{__c:function(e){var n=t.options.update,r=e.target,i=!!r.checked;if(Array.isArray(n)){var o=t._i(n,null);r.checked?o<0&&(t.options.update=n.concat([null])):o>-1&&(t.options.update=n.slice(0,o).concat(n.slice(o+1)))}else t.options.update=i}}})])]),t._v(" "),n("div",{staticClass:"dynamic-form-row"},[t._m(2),t._v(" "),n("div",{staticClass:"col-md-7 col-xs-12"},[n("input",{directives:[{name:"model",rawName:"v-model",value:t.options.send_welcome,expression:"options.send_welcome"}],attrs:{type:"checkbox",name:"send-welcome"},domProps:{checked:Array.isArray(t.options.send_welcome)?t._i(t.options.send_welcome,null)>-1:t.options.send_welcome},on:{__c:function(e){var n=t.options.send_welcome,r=e.target,i=!!r.checked;if(Array.isArray(n)){var o=t._i(n,null);r.checked?o<0&&(t.options.send_welcome=n.concat([null])):o>-1&&(t.options.send_welcome=n.slice(0,o).concat(n.slice(o+1)))}else t.options.send_welcome=i}}})])])]),t._v(" "),t.statusText?n("div",{staticClass:"alert col-md-8 col-md-offset-2",class:t.alertClass,staticStyle:{"text-align":"left"}},[t._v("\n            "+t._s(this.statusText)+"\n        ")]):t._e()]),t._v(" "),t._m(3),t._v(" "),t._l(t.file.header_row,function(e,r){return[n("div",{staticClass:"row"},[n("div",{staticClass:"col-md-2"}),t._v(" "),n("div",{staticClass:"col-md-8"},[n("div",{staticClass:"col-md-4 text-right"},[n("label",{staticClass:"control-label",attrs:{for:e}},[t._v(t._s(e))])]),t._v(" "),n("div",{staticClass:"col-md-4 form-group"},[n("div",{attrs:{required:""}},[n("select2",{attrs:{options:t.columns},model:{value:t.columnMappings[e],callback:function(n){t.$set(t.columnMappings,e,n)},expression:"columnMappings[header]"}},[n("option",{attrs:{value:"0"}},[t._v("Do Not Import")])])],1)]),t._v(" "),n("div",{staticClass:"col-md-4"},[n("p",{staticClass:"form-control-static"},[t._v(t._s(t.activeFile.first_row[r]))])])])])]}),t._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"col-md-6 col-md-offset-2 text-right",staticStyle:{"padding-top":"20px"}},[n("button",{staticClass:"btn btn-sm btn-default",attrs:{type:"button"},on:{click:function(e){t.processDetail=!1}}},[t._v("Cancel")]),t._v(" "),n("button",{staticClass:"btn btn-sm btn-primary",attrs:{type:"submit"},on:{click:t.postSave}},[t._v("Import")]),t._v(" "),n("br"),n("br")])]),t._v(" "),n("div",{staticClass:"row"},[t.statusText?n("div",{staticClass:"alert col-md-8 col-md-offset-2",class:t.alertClass,staticStyle:{"padding-top":"20px"}},[t._v("\n                    "+t._s(this.statusText)+"\n                ")]):t._e()])],2)},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-md-5 col-xs-12"},[e("label",{attrs:{for:"import-type"}},[this._v("Import Type:")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-md-5 col-xs-12"},[e("label",{attrs:{for:"import-update"}},[this._v("Update Existing Values?:")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-md-5 col-xs-12"},[e("label",{attrs:{for:"send-welcome"}},[this._v("Send Welcome Email for new Users?")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-2"}),this._v(" "),e("div",{staticClass:"col-md-8",staticStyle:{"padding-top":"30px"}},[e("div",{staticClass:"col-md-4 text-right"},[e("h4",[this._v("Header Field")])]),this._v(" "),e("div",{staticClass:"col-md-4"},[e("h4",[this._v("Import Field")])]),this._v(" "),e("div",{staticClass:"col-md-4"},[e("h4",[this._v("Sample Value")])])])])}]}},vvpX:function(t,e){},yDVJ:function(t,e,n){var r=n("VU/8")(n("zJOD"),n("zkjN"),!1,function(t){n("tZpc")},"data-v-3351e4cf",null);t.exports=r.exports},yd7E:function(t,e){},z1kw:function(t,e,n){var r,i,o,s;s=function(t){var e,n=0,r=Array.prototype.slice;return t.cleanData=(e=t.cleanData,function(n){var r,i,o;for(o=0;null!=(i=n[o]);o++)try{(r=t._data(i,"events"))&&r.remove&&t(i).triggerHandler("remove")}catch(t){}e(n)}),t.widget=function(e,n,r){var i,o,s,a={},l=e.split(".")[0],u=l+"-"+(e=e.split(".")[1]);return r||(r=n,n=t.Widget),t.isArray(r)&&(r=t.extend.apply(null,[{}].concat(r))),t.expr[":"][u.toLowerCase()]=function(e){return!!t.data(e,u)},t[l]=t[l]||{},i=t[l][e],o=t[l][e]=function(t,e){if(!this._createWidget)return new o(t,e);arguments.length&&this._createWidget(t,e)},t.extend(o,i,{version:r.version,_proto:t.extend({},r),_childConstructors:[]}),(s=new n).options=t.widget.extend({},s.options),t.each(r,function(e,r){t.isFunction(r)?a[e]=function(){function t(){return n.prototype[e].apply(this,arguments)}function i(t){return n.prototype[e].apply(this,t)}return function(){var e,n=this._super,o=this._superApply;return this._super=t,this._superApply=i,e=r.apply(this,arguments),this._super=n,this._superApply=o,e}}():a[e]=r}),o.prototype=t.widget.extend(s,{widgetEventPrefix:i&&s.widgetEventPrefix||e},a,{constructor:o,namespace:l,widgetName:e,widgetFullName:u}),i?(t.each(i._childConstructors,function(e,n){var r=n.prototype;t.widget(r.namespace+"."+r.widgetName,o,n._proto)}),delete i._childConstructors):n._childConstructors.push(o),t.widget.bridge(e,o),o},t.widget.extend=function(e){for(var n,i,o=r.call(arguments,1),s=0,a=o.length;s<a;s++)for(n in o[s])i=o[s][n],o[s].hasOwnProperty(n)&&void 0!==i&&(t.isPlainObject(i)?e[n]=t.isPlainObject(e[n])?t.widget.extend({},e[n],i):t.widget.extend({},i):e[n]=i);return e},t.widget.bridge=function(e,n){var i=n.prototype.widgetFullName||e;t.fn[e]=function(o){var s="string"==typeof o,a=r.call(arguments,1),l=this;return s?this.length||"instance"!==o?this.each(function(){var n,r=t.data(this,i);return"instance"===o?(l=r,!1):r?t.isFunction(r[o])&&"_"!==o.charAt(0)?(n=r[o].apply(r,a))!==r&&void 0!==n?(l=n&&n.jquery?l.pushStack(n.get()):n,!1):void 0:t.error("no such method '"+o+"' for "+e+" widget instance"):t.error("cannot call methods on "+e+" prior to initialization; attempted to call method '"+o+"'")}):l=void 0:(a.length&&(o=t.widget.extend.apply(null,[o].concat(a))),this.each(function(){var e=t.data(this,i);e?(e.option(o||{}),e._init&&e._init()):t.data(this,i,new n(o,this))})),l}},t.Widget=function(){},t.Widget._childConstructors=[],t.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{classes:{},disabled:!1,create:null},_createWidget:function(e,r){r=t(r||this.defaultElement||this)[0],this.element=t(r),this.uuid=n++,this.eventNamespace="."+this.widgetName+this.uuid,this.bindings=t(),this.hoverable=t(),this.focusable=t(),this.classesElementLookup={},r!==this&&(t.data(r,this.widgetFullName,this),this._on(!0,this.element,{remove:function(t){t.target===r&&this.destroy()}}),this.document=t(r.style?r.ownerDocument:r.document||r),this.window=t(this.document[0].defaultView||this.document[0].parentWindow)),this.options=t.widget.extend({},this.options,this._getCreateOptions(),e),this._create(),this.options.disabled&&this._setOptionDisabled(this.options.disabled),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:function(){return{}},_getCreateEventData:t.noop,_create:t.noop,_init:t.noop,destroy:function(){var e=this;this._destroy(),t.each(this.classesElementLookup,function(t,n){e._removeClass(n,t)}),this.element.off(this.eventNamespace).removeData(this.widgetFullName),this.widget().off(this.eventNamespace).removeAttr("aria-disabled"),this.bindings.off(this.eventNamespace)},_destroy:t.noop,widget:function(){return this.element},option:function(e,n){var r,i,o,s=e;if(0===arguments.length)return t.widget.extend({},this.options);if("string"==typeof e)if(s={},e=(r=e.split(".")).shift(),r.length){for(i=s[e]=t.widget.extend({},this.options[e]),o=0;o<r.length-1;o++)i[r[o]]=i[r[o]]||{},i=i[r[o]];if(e=r.pop(),1===arguments.length)return void 0===i[e]?null:i[e];i[e]=n}else{if(1===arguments.length)return void 0===this.options[e]?null:this.options[e];s[e]=n}return this._setOptions(s),this},_setOptions:function(t){var e;for(e in t)this._setOption(e,t[e]);return this},_setOption:function(t,e){return"classes"===t&&this._setOptionClasses(e),this.options[t]=e,"disabled"===t&&this._setOptionDisabled(e),this},_setOptionClasses:function(e){var n,r,i;for(n in e)i=this.classesElementLookup[n],e[n]!==this.options.classes[n]&&i&&i.length&&(r=t(i.get()),this._removeClass(i,n),r.addClass(this._classes({element:r,keys:n,classes:e,add:!0})))},_setOptionDisabled:function(t){this._toggleClass(this.widget(),this.widgetFullName+"-disabled",null,!!t),t&&(this._removeClass(this.hoverable,null,"ui-state-hover"),this._removeClass(this.focusable,null,"ui-state-focus"))},enable:function(){return this._setOptions({disabled:!1})},disable:function(){return this._setOptions({disabled:!0})},_classes:function(e){var n=[],r=this;function i(i,o){var s,a;for(a=0;a<i.length;a++)s=r.classesElementLookup[i[a]]||t(),s=e.add?t(t.unique(s.get().concat(e.element.get()))):t(s.not(e.element).get()),r.classesElementLookup[i[a]]=s,n.push(i[a]),o&&e.classes[i[a]]&&n.push(e.classes[i[a]])}return e=t.extend({element:this.element,classes:this.options.classes||{}},e),this._on(e.element,{remove:"_untrackClassesElement"}),e.keys&&i(e.keys.match(/\S+/g)||[],!0),e.extra&&i(e.extra.match(/\S+/g)||[]),n.join(" ")},_untrackClassesElement:function(e){var n=this;t.each(n.classesElementLookup,function(r,i){-1!==t.inArray(e.target,i)&&(n.classesElementLookup[r]=t(i.not(e.target).get()))})},_removeClass:function(t,e,n){return this._toggleClass(t,e,n,!1)},_addClass:function(t,e,n){return this._toggleClass(t,e,n,!0)},_toggleClass:function(t,e,n,r){r="boolean"==typeof r?r:n;var i="string"==typeof t||null===t,o={extra:i?e:n,keys:i?t:e,element:i?this.element:t,add:r};return o.element.toggleClass(this._classes(o),r),this},_on:function(e,n,r){var i,o=this;"boolean"!=typeof e&&(r=n,n=e,e=!1),r?(n=i=t(n),this.bindings=this.bindings.add(n)):(r=n,n=this.element,i=this.widget()),t.each(r,function(r,s){function a(){if(e||!0!==o.options.disabled&&!t(this).hasClass("ui-state-disabled"))return("string"==typeof s?o[s]:s).apply(o,arguments)}"string"!=typeof s&&(a.guid=s.guid=s.guid||a.guid||t.guid++);var l=r.match(/^([\w:-]*)\s*(.*)$/),u=l[1]+o.eventNamespace,c=l[2];c?i.on(u,c,a):n.on(u,a)})},_off:function(e,n){n=(n||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,e.off(n).off(n),this.bindings=t(this.bindings.not(e).get()),this.focusable=t(this.focusable.not(e).get()),this.hoverable=t(this.hoverable.not(e).get())},_delay:function(t,e){var n=this;return setTimeout(function(){return("string"==typeof t?n[t]:t).apply(n,arguments)},e||0)},_hoverable:function(e){this.hoverable=this.hoverable.add(e),this._on(e,{mouseenter:function(e){this._addClass(t(e.currentTarget),null,"ui-state-hover")},mouseleave:function(e){this._removeClass(t(e.currentTarget),null,"ui-state-hover")}})},_focusable:function(e){this.focusable=this.focusable.add(e),this._on(e,{focusin:function(e){this._addClass(t(e.currentTarget),null,"ui-state-focus")},focusout:function(e){this._removeClass(t(e.currentTarget),null,"ui-state-focus")}})},_trigger:function(e,n,r){var i,o,s=this.options[e];if(r=r||{},(n=t.Event(n)).type=(e===this.widgetEventPrefix?e:this.widgetEventPrefix+e).toLowerCase(),n.target=this.element[0],o=n.originalEvent)for(i in o)i in n||(n[i]=o[i]);return this.element.trigger(n,r),!(t.isFunction(s)&&!1===s.apply(this.element[0],[n].concat(r))||n.isDefaultPrevented())}},t.each({show:"fadeIn",hide:"fadeOut"},function(e,n){t.Widget.prototype["_"+e]=function(r,i,o){var s;"string"==typeof i&&(i={effect:i});var a=i?!0===i||"number"==typeof i?n:i.effect||n:e;"number"==typeof(i=i||{})&&(i={duration:i}),s=!t.isEmptyObject(i),i.complete=o,i.delay&&r.delay(i.delay),s&&t.effects&&t.effects.effect[a]?r[e](i):a!==e&&r[a]?r[a](i.duration,i.easing,o):r.queue(function(n){t(this)[e](),o&&o.call(r[0]),n()})}}),t.widget},i=[n("7t+N"),n("UZ9c")],void 0===(o="function"==typeof(r=s)?r.apply(e,i):r)||(t.exports=o)},zJOD:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:["errors"]}},zkjN:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.errors?n("div",{staticClass:"box"},[n("div",{staticClass:"box-body"},[t._m(0),t._v(" "),n("div",{staticClass:"errors-table"},[n("table",{staticClass:"table table-striped table-bordered",attrs:{id:"errors-table"}},[t._m(1),t._v(" "),n("tbody",t._l(t.errors,function(e,r){return n("tr",[n("td",[t._v(t._s(r))]),t._v(" "),t._l(e,function(e,r){return n("td",[n("b",[t._v(t._s(r)+":")]),t._v(" "),t._l(e,function(e){return n("span",[t._v(t._s(e[0]))])}),t._v(" "),n("br")],2)})],2)}))])])])]):t._e()},staticRenderFns:[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"alert alert-warning"},[e("strong",[this._v("Warning")]),this._v(" Some Errors occured while importing\n    ")])},function(){var t=this.$createElement,e=this._self._c||t;return e("thead",[e("th",[this._v("Item")]),this._v(" "),e("th",[this._v("Errors")])])}]}}});
//# sourceMappingURL=vue.js.map
!function(t,e){"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?module.exports=e():t.Tether=e()}(this,function(){"use strict";function t(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function e(t){var o=t.getBoundingClientRect(),i={};for(var n in o)i[n]=o[n];if(t.ownerDocument!==document){var r=t.ownerDocument.defaultView.frameElement;if(r){var s=e(r);i.top+=s.top,i.bottom+=s.top,i.left+=s.left,i.right+=s.left}}return i}function o(t){var e=getComputedStyle(t)||{},o=e.position,i=[];if("fixed"===o)return[t];for(var n=t;(n=n.parentNode)&&n&&1===n.nodeType;){var r=void 0;try{r=getComputedStyle(n)}catch(s){}if("undefined"==typeof r||null===r)return i.push(n),i;var a=r,f=a.overflow,l=a.overflowX,h=a.overflowY;/(auto|scroll|overlay)/.test(f+h+l)&&("absolute"!==o||["relative","absolute","fixed"].indexOf(r.position)>=0)&&i.push(n)}return i.push(t.ownerDocument.body),t.ownerDocument!==document&&i.push(t.ownerDocument.defaultView),i}function i(){O&&document.body.removeChild(O),O=null}function n(t){var o=void 0;t===document?(o=document,t=document.documentElement):o=t.ownerDocument;var i=o.documentElement,n=e(t),r=A();return n.top-=r.top,n.left-=r.left,"undefined"==typeof n.width&&(n.width=document.body.scrollWidth-n.left-n.right),"undefined"==typeof n.height&&(n.height=document.body.scrollHeight-n.top-n.bottom),n.top=n.top-i.clientTop,n.left=n.left-i.clientLeft,n.right=o.body.clientWidth-n.width-n.left,n.bottom=o.body.clientHeight-n.height-n.top,n}function r(t){return t.offsetParent||document.documentElement}function s(){if(T)return T;var t=document.createElement("div");t.style.width="100%",t.style.height="200px";var e=document.createElement("div");a(e.style,{position:"absolute",top:0,left:0,pointerEvents:"none",visibility:"hidden",width:"200px",height:"150px",overflow:"hidden"}),e.appendChild(t),document.body.appendChild(e);var o=t.offsetWidth;e.style.overflow="scroll";var i=t.offsetWidth;o===i&&(i=e.clientWidth),document.body.removeChild(e);var n=o-i;return T={width:n,height:n}}function a(){var t=arguments.length<=0||void 0===arguments[0]?{}:arguments[0],e=[];return Array.prototype.push.apply(e,arguments),e.slice(1).forEach(function(e){if(e)for(var o in e)({}).hasOwnProperty.call(e,o)&&(t[o]=e[o])}),t}function f(t,e){if("undefined"!=typeof t.classList)e.split(" ").forEach(function(e){e.trim()&&t.classList.remove(e)});else{var o=new RegExp("(^| )"+e.split(" ").join("|")+"( |$)","gi"),i=d(t).replace(o," ");p(t,i)}}function l(t,e){if("undefined"!=typeof t.classList)e.split(" ").forEach(function(e){e.trim()&&t.classList.add(e)});else{f(t,e);var o=d(t)+(" "+e);p(t,o)}}function h(t,e){if("undefined"!=typeof t.classList)return t.classList.contains(e);var o=d(t);return new RegExp("(^| )"+e+"( |$)","gi").test(o)}function d(t){return t.className instanceof t.ownerDocument.defaultView.SVGAnimatedString?t.className.baseVal:t.className}function p(t,e){t.setAttribute("class",e)}function u(t,e,o){o.forEach(function(o){e.indexOf(o)===-1&&h(t,o)&&f(t,o)}),e.forEach(function(e){h(t,e)||l(t,e)})}function t(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function c(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}function g(t,e){var o=arguments.length<=2||void 0===arguments[2]?1:arguments[2];return t+o>=e&&e>=t-o}function m(){return"object"==typeof performance&&"function"==typeof performance.now?performance.now():+new Date}function v(){for(var t={top:0,left:0},e=arguments.length,o=Array(e),i=0;i<e;i++)o[i]=arguments[i];return o.forEach(function(e){var o=e.top,i=e.left;"string"==typeof o&&(o=parseFloat(o,10)),"string"==typeof i&&(i=parseFloat(i,10)),t.top+=o,t.left+=i}),t}function y(t,e){return"string"==typeof t.left&&t.left.indexOf("%")!==-1&&(t.left=parseFloat(t.left,10)/100*e.width),"string"==typeof t.top&&t.top.indexOf("%")!==-1&&(t.top=parseFloat(t.top,10)/100*e.height),t}function b(t,e){return"scrollParent"===e?e=t.scrollParents[0]:"window"===e&&(e=[pageXOffset,pageYOffset,innerWidth+pageXOffset,innerHeight+pageYOffset]),e===document&&(e=e.documentElement),"undefined"!=typeof e.nodeType&&!function(){var t=e,o=n(e),i=o,r=getComputedStyle(e);if(e=[i.left,i.top,o.width+i.left,o.height+i.top],t.ownerDocument!==document){var s=t.ownerDocument.defaultView;e[0]+=s.pageXOffset,e[1]+=s.pageYOffset,e[2]+=s.pageXOffset,e[3]+=s.pageYOffset}I.forEach(function(t,o){t=t[0].toUpperCase()+t.substr(1),"Top"===t||"Left"===t?e[o]+=parseFloat(r["border"+t+"Width"]):e[o]-=parseFloat(r["border"+t+"Width"])})}(),e}var w=function(){function t(t,e){for(var o=0;o<e.length;o++){var i=e[o];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}return function(e,o,i){return o&&t(e.prototype,o),i&&t(e,i),e}}(),C=void 0;"undefined"==typeof C&&(C={modules:[]});var O=null,E=function(){var t=0;return function(){return++t}}(),x={},A=function(){var t=O;t&&document.body.contains(t)||(t=document.createElement("div"),t.setAttribute("data-tether-id",E()),a(t.style,{top:0,left:0,position:"absolute"}),document.body.appendChild(t),O=t);var o=t.getAttribute("data-tether-id");return"undefined"==typeof x[o]&&(x[o]=e(t),P(function(){delete x[o]})),x[o]},T=null,S=[],P=function(t){S.push(t)},M=function(){for(var t=void 0;t=S.pop();)t()},W=function(){function e(){t(this,e)}return w(e,[{key:"on",value:function(t,e,o){var i=!(arguments.length<=3||void 0===arguments[3])&&arguments[3];"undefined"==typeof this.bindings&&(this.bindings={}),"undefined"==typeof this.bindings[t]&&(this.bindings[t]=[]),this.bindings[t].push({handler:e,ctx:o,once:i})}},{key:"once",value:function(t,e,o){this.on(t,e,o,!0)}},{key:"off",value:function(t,e){if("undefined"!=typeof this.bindings&&"undefined"!=typeof this.bindings[t])if("undefined"==typeof e)delete this.bindings[t];else for(var o=0;o<this.bindings[t].length;)this.bindings[t][o].handler===e?this.bindings[t].splice(o,1):++o}},{key:"trigger",value:function(t){if("undefined"!=typeof this.bindings&&this.bindings[t]){for(var e=0,o=arguments.length,i=Array(o>1?o-1:0),n=1;n<o;n++)i[n-1]=arguments[n];for(;e<this.bindings[t].length;){var r=this.bindings[t][e],s=r.handler,a=r.ctx,f=r.once,l=a;"undefined"==typeof l&&(l=this),s.apply(l,i),f?this.bindings[t].splice(e,1):++e}}}}]),e}();C.Utils={getActualBoundingClientRect:e,getScrollParents:o,getBounds:n,getOffsetParent:r,extend:a,addClass:l,removeClass:f,hasClass:h,updateClasses:u,defer:P,flush:M,uniqueId:E,Evented:W,getScrollBarSize:s,removeUtilElements:i};var k=function(){function t(t,e){var o=[],i=!0,n=!1,r=void 0;try{for(var s,a=t[Symbol.iterator]();!(i=(s=a.next()).done)&&(o.push(s.value),!e||o.length!==e);i=!0);}catch(f){n=!0,r=f}finally{try{!i&&a["return"]&&a["return"]()}finally{if(n)throw r}}return o}return function(e,o){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return t(e,o);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}(),w=function(){function t(t,e){for(var o=0;o<e.length;o++){var i=e[o];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}return function(e,o,i){return o&&t(e.prototype,o),i&&t(e,i),e}}(),_=function(t,e,o){for(var i=!0;i;){var n=t,r=e,s=o;i=!1,null===n&&(n=Function.prototype);var a=Object.getOwnPropertyDescriptor(n,r);if(void 0!==a){if("value"in a)return a.value;var f=a.get;if(void 0===f)return;return f.call(s)}var l=Object.getPrototypeOf(n);if(null===l)return;t=l,e=r,o=s,i=!0,a=l=void 0}};if("undefined"==typeof C)throw new Error("You must include the utils.js file before tether.js");var B=C.Utils,o=B.getScrollParents,n=B.getBounds,r=B.getOffsetParent,a=B.extend,l=B.addClass,f=B.removeClass,u=B.updateClasses,P=B.defer,M=B.flush,s=B.getScrollBarSize,i=B.removeUtilElements,j=function(){if("undefined"==typeof document)return"";for(var t=document.createElement("div"),e=["transform","WebkitTransform","OTransform","MozTransform","msTransform"],o=0;o<e.length;++o){var i=e[o];if(void 0!==t.style[i])return i}}(),z=[],Y=function(){z.forEach(function(t){t.position(!1)}),M()};!function(){var t=null,e=null,o=null,i=function n(){return"undefined"!=typeof e&&e>16?(e=Math.min(e-16,250),void(o=setTimeout(n,250))):void("undefined"!=typeof t&&m()-t<10||(null!=o&&(clearTimeout(o),o=null),t=m(),Y(),e=m()-t))};"undefined"!=typeof window&&"undefined"!=typeof window.addEventListener&&["resize","scroll","touchmove"].forEach(function(t){window.addEventListener(t,i)})}();var L={center:"center",left:"right",right:"left"},D={middle:"middle",top:"bottom",bottom:"top"},X={top:0,left:0,middle:"50%",center:"50%",bottom:"100%",right:"100%"},F=function(t,e){var o=t.left,i=t.top;return"auto"===o&&(o=L[e.left]),"auto"===i&&(i=D[e.top]),{left:o,top:i}},H=function(t){var e=t.left,o=t.top;return"undefined"!=typeof X[t.left]&&(e=X[t.left]),"undefined"!=typeof X[t.top]&&(o=X[t.top]),{left:e,top:o}},N=function(t){var e=t.split(" "),o=k(e,2),i=o[0],n=o[1];return{top:i,left:n}},U=N,V=function(e){function h(e){var o=this;t(this,h),_(Object.getPrototypeOf(h.prototype),"constructor",this).call(this),this.position=this.position.bind(this),z.push(this),this.history=[],this.setOptions(e,!1),C.modules.forEach(function(t){"undefined"!=typeof t.initialize&&t.initialize.call(o)}),this.position()}return c(h,e),w(h,[{key:"getClass",value:function(){var t=arguments.length<=0||void 0===arguments[0]?"":arguments[0],e=this.options.classes;return"undefined"!=typeof e&&e[t]?this.options.classes[t]:this.options.classPrefix?this.options.classPrefix+"-"+t:t}},{key:"setOptions",value:function(t){var e=this,i=arguments.length<=1||void 0===arguments[1]||arguments[1],n={offset:"0 0",targetOffset:"0 0",targetAttachment:"auto auto",classPrefix:"tether"};this.options=a(n,t);var r=this.options,s=r.element,f=r.target,h=r.targetModifier;if(this.element=s,this.target=f,this.targetModifier=h,"viewport"===this.target?(this.target=document.body,this.targetModifier="visible"):"scroll-handle"===this.target&&(this.target=document.body,this.targetModifier="scroll-handle"),["element","target"].forEach(function(t){if("undefined"==typeof e[t])throw new Error("Tether Error: Both element and target must be defined");"undefined"!=typeof e[t].jquery?e[t]=e[t][0]:"string"==typeof e[t]&&(e[t]=document.querySelector(e[t]))}),l(this.element,this.getClass("element")),this.options.addTargetClasses!==!1&&l(this.target,this.getClass("target")),!this.options.attachment)throw new Error("Tether Error: You must provide an attachment");this.targetAttachment=U(this.options.targetAttachment),this.attachment=U(this.options.attachment),this.offset=N(this.options.offset),this.targetOffset=N(this.options.targetOffset),"undefined"!=typeof this.scrollParents&&this.disable(),"scroll-handle"===this.targetModifier?this.scrollParents=[this.target]:this.scrollParents=o(this.target),this.options.enabled!==!1&&this.enable(i)}},{key:"getTargetBounds",value:function(){if("undefined"==typeof this.targetModifier)return n(this.target);if("visible"===this.targetModifier){if(this.target===document.body)return{top:pageYOffset,left:pageXOffset,height:innerHeight,width:innerWidth};var t=n(this.target),e={height:t.height,width:t.width,top:t.top,left:t.left};return e.height=Math.min(e.height,t.height-(pageYOffset-t.top)),e.height=Math.min(e.height,t.height-(t.top+t.height-(pageYOffset+innerHeight))),e.height=Math.min(innerHeight,e.height),e.height-=2,e.width=Math.min(e.width,t.width-(pageXOffset-t.left)),e.width=Math.min(e.width,t.width-(t.left+t.width-(pageXOffset+innerWidth))),e.width=Math.min(innerWidth,e.width),e.width-=2,e.top<pageYOffset&&(e.top=pageYOffset),e.left<pageXOffset&&(e.left=pageXOffset),e}if("scroll-handle"===this.targetModifier){var t=void 0,o=this.target;o===document.body?(o=document.documentElement,t={left:pageXOffset,top:pageYOffset,height:innerHeight,width:innerWidth}):t=n(o);var i=getComputedStyle(o),r=o.scrollWidth>o.clientWidth||[i.overflow,i.overflowX].indexOf("scroll")>=0||this.target!==document.body,s=0;r&&(s=15);var a=t.height-parseFloat(i.borderTopWidth)-parseFloat(i.borderBottomWidth)-s,e={width:15,height:.975*a*(a/o.scrollHeight),left:t.left+t.width-parseFloat(i.borderLeftWidth)-15},f=0;a<408&&this.target===document.body&&(f=-11e-5*Math.pow(a,2)-.00727*a+22.58),this.target!==document.body&&(e.height=Math.max(e.height,24));var l=this.target.scrollTop/(o.scrollHeight-a);return e.top=l*(a-e.height-f)+t.top+parseFloat(i.borderTopWidth),this.target===document.body&&(e.height=Math.max(e.height,24)),e}}},{key:"clearCache",value:function(){this._cache={}}},{key:"cache",value:function(t,e){return"undefined"==typeof this._cache&&(this._cache={}),"undefined"==typeof this._cache[t]&&(this._cache[t]=e.call(this)),this._cache[t]}},{key:"enable",value:function(){var t=this,e=arguments.length<=0||void 0===arguments[0]||arguments[0];this.options.addTargetClasses!==!1&&l(this.target,this.getClass("enabled")),l(this.element,this.getClass("enabled")),this.enabled=!0,this.scrollParents.forEach(function(e){e!==t.target.ownerDocument&&e.addEventListener("scroll",t.position)}),e&&this.position()}},{key:"disable",value:function(){var t=this;f(this.target,this.getClass("enabled")),f(this.element,this.getClass("enabled")),this.enabled=!1,"undefined"!=typeof this.scrollParents&&this.scrollParents.forEach(function(e){e.removeEventListener("scroll",t.position)})}},{key:"destroy",value:function(){var t=this;this.disable(),z.forEach(function(e,o){e===t&&z.splice(o,1)}),0===z.length&&i()}},{key:"updateAttachClasses",value:function(t,e){var o=this;t=t||this.attachment,e=e||this.targetAttachment;var i=["left","top","bottom","right","middle","center"];"undefined"!=typeof this._addAttachClasses&&this._addAttachClasses.length&&this._addAttachClasses.splice(0,this._addAttachClasses.length),"undefined"==typeof this._addAttachClasses&&(this._addAttachClasses=[]);var n=this._addAttachClasses;t.top&&n.push(this.getClass("element-attached")+"-"+t.top),t.left&&n.push(this.getClass("element-attached")+"-"+t.left),e.top&&n.push(this.getClass("target-attached")+"-"+e.top),e.left&&n.push(this.getClass("target-attached")+"-"+e.left);var r=[];i.forEach(function(t){r.push(o.getClass("element-attached")+"-"+t),r.push(o.getClass("target-attached")+"-"+t)}),P(function(){"undefined"!=typeof o._addAttachClasses&&(u(o.element,o._addAttachClasses,r),o.options.addTargetClasses!==!1&&u(o.target,o._addAttachClasses,r),delete o._addAttachClasses)})}},{key:"position",value:function(){var t=this,e=arguments.length<=0||void 0===arguments[0]||arguments[0];if(this.enabled){this.clearCache();var o=F(this.targetAttachment,this.attachment);this.updateAttachClasses(this.attachment,o);var i=this.cache("element-bounds",function(){return n(t.element)}),a=i.width,f=i.height;if(0===a&&0===f&&"undefined"!=typeof this.lastSize){var l=this.lastSize;a=l.width,f=l.height}else this.lastSize={width:a,height:f};var h=this.cache("target-bounds",function(){return t.getTargetBounds()}),d=h,p=y(H(this.attachment),{width:a,height:f}),u=y(H(o),d),c=y(this.offset,{width:a,height:f}),g=y(this.targetOffset,d);p=v(p,c),u=v(u,g);for(var m=h.left+u.left-p.left,b=h.top+u.top-p.top,w=0;w<C.modules.length;++w){var O=C.modules[w],E=O.position.call(this,{left:m,top:b,targetAttachment:o,targetPos:h,elementPos:i,offset:p,targetOffset:u,manualOffset:c,manualTargetOffset:g,scrollbarSize:S,attachment:this.attachment});if(E===!1)return!1;"undefined"!=typeof E&&"object"==typeof E&&(b=E.top,m=E.left)}var x={page:{top:b,left:m},viewport:{top:b-pageYOffset,bottom:pageYOffset-b-f+innerHeight,left:m-pageXOffset,right:pageXOffset-m-a+innerWidth}},A=this.target.ownerDocument,T=A.defaultView,S=void 0;return T.innerHeight>A.documentElement.clientHeight&&(S=this.cache("scrollbar-size",s),x.viewport.bottom-=S.height),T.innerWidth>A.documentElement.clientWidth&&(S=this.cache("scrollbar-size",s),x.viewport.right-=S.width),["","static"].indexOf(A.body.style.position)!==-1&&["","static"].indexOf(A.body.parentElement.style.position)!==-1||(x.page.bottom=A.body.scrollHeight-b-f,x.page.right=A.body.scrollWidth-m-a),"undefined"!=typeof this.options.optimizations&&this.options.optimizations.moveElement!==!1&&"undefined"==typeof this.targetModifier&&!function(){var e=t.cache("target-offsetparent",function(){return r(t.target)}),o=t.cache("target-offsetparent-bounds",function(){return n(e)}),i=getComputedStyle(e),s=o,a={};if(["Top","Left","Bottom","Right"].forEach(function(t){a[t.toLowerCase()]=parseFloat(i["border"+t+"Width"])}),o.right=A.body.scrollWidth-o.left-s.width+a.right,o.bottom=A.body.scrollHeight-o.top-s.height+a.bottom,x.page.top>=o.top+a.top&&x.page.bottom>=o.bottom&&x.page.left>=o.left+a.left&&x.page.right>=o.right){var f=e.scrollTop,l=e.scrollLeft;x.offset={top:x.page.top-o.top+f-a.top,left:x.page.left-o.left+l-a.left}}}(),this.move(x),this.history.unshift(x),this.history.length>3&&this.history.pop(),e&&M(),!0}}},{key:"move",value:function(t){var e=this;if("undefined"!=typeof this.element.parentNode){var o={};for(var i in t){o[i]={};for(var n in t[i]){for(var s=!1,f=0;f<this.history.length;++f){var l=this.history[f];if("undefined"!=typeof l[i]&&!g(l[i][n],t[i][n])){s=!0;break}}s||(o[i][n]=!0)}}var h={top:"",left:"",right:"",bottom:""},d=function(t,o){var i="undefined"!=typeof e.options.optimizations,n=i?e.options.optimizations.gpu:null;if(n!==!1){var r=void 0,s=void 0;if(t.top?(h.top=0,r=o.top):(h.bottom=0,r=-o.bottom),t.left?(h.left=0,s=o.left):(h.right=0,s=-o.right),window.matchMedia){var a=window.matchMedia("only screen and (min-resolution: 1.3dppx)").matches||window.matchMedia("only screen and (-webkit-min-device-pixel-ratio: 1.3)").matches;a||(s=Math.round(s),r=Math.round(r))}h[j]="translateX("+s+"px) translateY("+r+"px)","msTransform"!==j&&(h[j]+=" translateZ(0)")}else t.top?h.top=o.top+"px":h.bottom=o.bottom+"px",t.left?h.left=o.left+"px":h.right=o.right+"px"},p=!1;if((o.page.top||o.page.bottom)&&(o.page.left||o.page.right)?(h.position="absolute",d(o.page,t.page)):(o.viewport.top||o.viewport.bottom)&&(o.viewport.left||o.viewport.right)?(h.position="fixed",d(o.viewport,t.viewport)):"undefined"!=typeof o.offset&&o.offset.top&&o.offset.left?!function(){h.position="absolute";var i=e.cache("target-offsetparent",function(){return r(e.target)});r(e.element)!==i&&P(function(){e.element.parentNode.removeChild(e.element),i.appendChild(e.element)}),d(o.offset,t.offset),p=!0}():(h.position="absolute",d({top:!0,left:!0},t.page)),!p)if(this.options.bodyElement)this.element.parentNode!==this.options.bodyElement&&this.options.bodyElement.appendChild(this.element);else{for(var u=!0,c=this.element.parentNode;c&&1===c.nodeType&&"BODY"!==c.tagName;){if("static"!==getComputedStyle(c).position){u=!1;break}c=c.parentNode}u||(this.element.parentNode.removeChild(this.element),this.element.ownerDocument.body.appendChild(this.element))}var m={},v=!1;for(var n in h){var y=h[n],b=this.element.style[n];b!==y&&(v=!0,m[n]=y)}v&&P(function(){a(e.element.style,m),e.trigger("repositioned")})}}}]),h}(W);V.modules=[],C.position=Y;var R=a(V,C),k=function(){function t(t,e){var o=[],i=!0,n=!1,r=void 0;try{for(var s,a=t[Symbol.iterator]();!(i=(s=a.next()).done)&&(o.push(s.value),!e||o.length!==e);i=!0);}catch(f){n=!0,r=f}finally{try{!i&&a["return"]&&a["return"]()}finally{if(n)throw r}}return o}return function(e,o){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return t(e,o);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}(),B=C.Utils,n=B.getBounds,a=B.extend,u=B.updateClasses,P=B.defer,I=["left","top","right","bottom"];C.modules.push({position:function(t){var e=this,o=t.top,i=t.left,r=t.targetAttachment;if(!this.options.constraints)return!0;var s=this.cache("element-bounds",function(){return n(e.element)}),f=s.height,l=s.width;if(0===l&&0===f&&"undefined"!=typeof this.lastSize){var h=this.lastSize;l=h.width,f=h.height}var d=this.cache("target-bounds",function(){return e.getTargetBounds()}),p=d.height,c=d.width,g=[this.getClass("pinned"),this.getClass("out-of-bounds")];this.options.constraints.forEach(function(t){var e=t.outOfBoundsClass,o=t.pinnedClass;e&&g.push(e),o&&g.push(o)}),g.forEach(function(t){["left","top","right","bottom"].forEach(function(e){g.push(t+"-"+e)})});var m=[],v=a({},r),y=a({},this.attachment);return this.options.constraints.forEach(function(t){var n=t.to,s=t.attachment,a=t.pin;"undefined"==typeof s&&(s="");var h=void 0,d=void 0;if(s.indexOf(" ")>=0){var u=s.split(" "),g=k(u,2);d=g[0],h=g[1]}else h=d=s;var w=b(e,n);"target"!==d&&"both"!==d||(o<w[1]&&"top"===v.top&&(o+=p,v.top="bottom"),o+f>w[3]&&"bottom"===v.top&&(o-=p,v.top="top")),"together"===d&&("top"===v.top&&("bottom"===y.top&&o<w[1]?(o+=p,v.top="bottom",o+=f,y.top="top"):"top"===y.top&&o+f>w[3]&&o-(f-p)>=w[1]&&(o-=f-p,v.top="bottom",y.top="bottom")),"bottom"===v.top&&("top"===y.top&&o+f>w[3]?(o-=p,v.top="top",o-=f,y.top="bottom"):"bottom"===y.top&&o<w[1]&&o+(2*f-p)<=w[3]&&(o+=f-p,v.top="top",y.top="top")),"middle"===v.top&&(o+f>w[3]&&"top"===y.top?(o-=f,y.top="bottom"):o<w[1]&&"bottom"===y.top&&(o+=f,y.top="top"))),"target"!==h&&"both"!==h||(i<w[0]&&"left"===v.left&&(i+=c,v.left="right"),i+l>w[2]&&"right"===v.left&&(i-=c,v.left="left")),"together"===h&&(i<w[0]&&"left"===v.left?"right"===y.left?(i+=c,v.left="right",i+=l,y.left="left"):"left"===y.left&&(i+=c,v.left="right",i-=l,y.left="right"):i+l>w[2]&&"right"===v.left?"left"===y.left?(i-=c,v.left="left",i-=l,y.left="right"):"right"===y.left&&(i-=c,v.left="left",i+=l,y.left="left"):"center"===v.left&&(i+l>w[2]&&"left"===y.left?(i-=l,y.left="right"):i<w[0]&&"right"===y.left&&(i+=l,y.left="left"))),"element"!==d&&"both"!==d||(o<w[1]&&"bottom"===y.top&&(o+=f,y.top="top"),o+f>w[3]&&"top"===y.top&&(o-=f,y.top="bottom")),"element"!==h&&"both"!==h||(i<w[0]&&("right"===y.left?(i+=l,y.left="left"):"center"===y.left&&(i+=l/2,y.left="left")),i+l>w[2]&&("left"===y.left?(i-=l,y.left="right"):"center"===y.left&&(i-=l/2,y.left="right"))),"string"==typeof a?a=a.split(",").map(function(t){return t.trim()}):a===!0&&(a=["top","left","right","bottom"]),a=a||[];var C=[],O=[];o<w[1]&&(a.indexOf("top")>=0?(o=w[1],C.push("top")):O.push("top")),o+f>w[3]&&(a.indexOf("bottom")>=0?(o=w[3]-f,C.push("bottom")):O.push("bottom")),i<w[0]&&(a.indexOf("left")>=0?(i=w[0],C.push("left")):O.push("left")),i+l>w[2]&&(a.indexOf("right")>=0?(i=w[2]-l,C.push("right")):O.push("right")),C.length&&!function(){var t=void 0;t="undefined"!=typeof e.options.pinnedClass?e.options.pinnedClass:e.getClass("pinned"),m.push(t),C.forEach(function(e){m.push(t+"-"+e)})}(),O.length&&!function(){var t=void 0;t="undefined"!=typeof e.options.outOfBoundsClass?e.options.outOfBoundsClass:e.getClass("out-of-bounds"),m.push(t),O.forEach(function(e){m.push(t+"-"+e)})}(),(C.indexOf("left")>=0||C.indexOf("right")>=0)&&(y.left=v.left=!1),(C.indexOf("top")>=0||C.indexOf("bottom")>=0)&&(y.top=v.top=!1),v.top===r.top&&v.left===r.left&&y.top===e.attachment.top&&y.left===e.attachment.left||(e.updateAttachClasses(y,v),e.trigger("update",{attachment:y,targetAttachment:v}))}),P(function(){e.options.addTargetClasses!==!1&&u(e.target,m,g),u(e.element,m,g)}),{top:o,left:i}}});var B=C.Utils,n=B.getBounds,u=B.updateClasses,P=B.defer;C.modules.push({position:function(t){var e=this,o=t.top,i=t.left,r=this.cache("element-bounds",function(){return n(e.element)}),s=r.height,a=r.width,f=this.getTargetBounds(),l=o+s,h=i+a,d=[];o<=f.bottom&&l>=f.top&&["left","right"].forEach(function(t){var e=f[t];e!==i&&e!==h||d.push(t)}),i<=f.right&&h>=f.left&&["top","bottom"].forEach(function(t){var e=f[t];e!==o&&e!==l||d.push(t)});var p=[],c=[],g=["left","top","right","bottom"];return p.push(this.getClass("abutted")),g.forEach(function(t){p.push(e.getClass("abutted")+"-"+t)}),d.length&&c.push(this.getClass("abutted")),d.forEach(function(t){c.push(e.getClass("abutted")+"-"+t)}),P(function(){e.options.addTargetClasses!==!1&&u(e.target,c,p),u(e.element,c,p)}),!0}});var k=function(){function t(t,e){var o=[],i=!0,n=!1,r=void 0;try{for(var s,a=t[Symbol.iterator]();!(i=(s=a.next()).done)&&(o.push(s.value),!e||o.length!==e);i=!0);}catch(f){n=!0,r=f}finally{try{!i&&a["return"]&&a["return"]()}finally{if(n)throw r}}return o}return function(e,o){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return t(e,o);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}();return C.modules.push({position:function(t){var e=t.top,o=t.left;if(this.options.shift){var i=this.options.shift;"function"==typeof this.options.shift&&(i=this.options.shift.call(this,{top:e,left:o}));var n=void 0,r=void 0;if("string"==typeof i){i=i.split(" "),i[1]=i[1]||i[0];var s=i,a=k(s,2);n=a[0],r=a[1],n=parseFloat(n,10),r=parseFloat(r,10)}else n=i.top,r=i.left;return e+=n,o+=r,{top:e,left:o}}}}),R});
/*! Copyright (c) 2011 Piotr Rochala (http://rocha.la)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.3.8
 *
 */
(function($) {

  $.fn.extend({
    slimScroll: function(options) {

      var defaults = {

        // width in pixels of the visible scroll area
        width : 'auto',

        // height in pixels of the visible scroll area
        height : '250px',

        // width in pixels of the scrollbar and rail
        size : '7px',

        // scrollbar color, accepts any hex/color value
        color: '#000',

        // scrollbar position - left/right
        position : 'right',

        // distance in pixels between the side edge and the scrollbar
        distance : '1px',

        // default scroll position on load - top / bottom / $('selector')
        start : 'top',

        // sets scrollbar opacity
        opacity : .4,

        // enables always-on mode for the scrollbar
        alwaysVisible : false,

        // check if we should hide the scrollbar when user is hovering over
        disableFadeOut : false,

        // sets visibility of the rail
        railVisible : false,

        // sets rail color
        railColor : '#333',

        // sets rail opacity
        railOpacity : .2,

        // whether  we should use jQuery UI Draggable to enable bar dragging
        railDraggable : true,

        // defautlt CSS class of the slimscroll rail
        railClass : 'slimScrollRail',

        // defautlt CSS class of the slimscroll bar
        barClass : 'slimScrollBar',

        // defautlt CSS class of the slimscroll wrapper
        wrapperClass : 'slimScrollDiv',

        // check if mousewheel should scroll the window if we reach top/bottom
        allowPageScroll : false,

        // scroll amount applied to each mouse wheel step
        wheelStep : 20,

        // scroll amount applied when user is using gestures
        touchScrollStep : 200,

        // sets border radius
        borderRadius: '7px',

        // sets border radius of the rail
        railBorderRadius : '7px'
      };

      var o = $.extend(defaults, options);

      // do it for every element that matches selector
      this.each(function(){

      var isOverPanel, isOverBar, isDragg, queueHide, touchDif,
        barHeight, percentScroll, lastScroll,
        divS = '<div></div>',
        minBarHeight = 30,
        releaseScroll = false;

        // used in event handlers and for better minification
        var me = $(this);

        // ensure we are not binding it again
        if (me.parent().hasClass(o.wrapperClass))
        {
            // start from last bar position
            var offset = me.scrollTop();

            // find bar and rail
            bar = me.siblings('.' + o.barClass);
            rail = me.siblings('.' + o.railClass);

            getBarHeight();

            // check if we should scroll existing instance
            if ($.isPlainObject(options))
            {
              // Pass height: auto to an existing slimscroll object to force a resize after contents have changed
              if ( 'height' in options && options.height == 'auto' ) {
                me.parent().css('height', 'auto');
                me.css('height', 'auto');
                var height = me.parent().parent().height();
                me.parent().css('height', height);
                me.css('height', height);
              } else if ('height' in options) {
                var h = options.height;
                me.parent().css('height', h);
                me.css('height', h);
              }

              if ('scrollTo' in options)
              {
                // jump to a static point
                offset = parseInt(o.scrollTo);
              }
              else if ('scrollBy' in options)
              {
                // jump by value pixels
                offset += parseInt(o.scrollBy);
              }
              else if ('destroy' in options)
              {
                // remove slimscroll elements
                bar.remove();
                rail.remove();
                me.unwrap();
                return;
              }

              // scroll content by the given offset
              scrollContent(offset, false, true);
            }

            return;
        }
        else if ($.isPlainObject(options))
        {
            if ('destroy' in options)
            {
            	return;
            }
        }

        // optionally set height to the parent's height
        o.height = (o.height == 'auto') ? me.parent().height() : o.height;

        // wrap content
        var wrapper = $(divS)
          .addClass(o.wrapperClass)
          .css({
            position: 'relative',
            overflow: 'hidden',
            width: o.width,
            height: o.height
          });

        // update style for the div
        me.css({
          overflow: 'hidden',
          width: o.width,
          height: o.height
        });

        // create scrollbar rail
        var rail = $(divS)
          .addClass(o.railClass)
          .css({
            width: o.size,
            height: '100%',
            position: 'absolute',
            top: 0,
            display: (o.alwaysVisible && o.railVisible) ? 'block' : 'none',
            'border-radius': o.railBorderRadius,
            background: o.railColor,
            opacity: o.railOpacity,
            zIndex: 90
          });

        // create scrollbar
        var bar = $(divS)
          .addClass(o.barClass)
          .css({
            background: o.color,
            width: o.size,
            position: 'absolute',
            top: 0,
            opacity: o.opacity,
            display: o.alwaysVisible ? 'block' : 'none',
            'border-radius' : o.borderRadius,
            BorderRadius: o.borderRadius,
            MozBorderRadius: o.borderRadius,
            WebkitBorderRadius: o.borderRadius,
            zIndex: 99
          });

        // set position
        var posCss = (o.position == 'right') ? { right: o.distance } : { left: o.distance };
        rail.css(posCss);
        bar.css(posCss);

        // wrap it
        me.wrap(wrapper);

        // append to parent div
        me.parent().append(bar);
        me.parent().append(rail);

        // make it draggable and no longer dependent on the jqueryUI
        if (o.railDraggable){
          bar.bind("mousedown", function(e) {
            var $doc = $(document);
            isDragg = true;
            t = parseFloat(bar.css('top'));
            pageY = e.pageY;

            $doc.bind("mousemove.slimscroll", function(e){
              currTop = t + e.pageY - pageY;
              bar.css('top', currTop);
              scrollContent(0, bar.position().top, false);// scroll content
            });

            $doc.bind("mouseup.slimscroll", function(e) {
              isDragg = false;hideBar();
              $doc.unbind('.slimscroll');
            });
            return false;
          }).bind("selectstart.slimscroll", function(e){
            e.stopPropagation();
            e.preventDefault();
            return false;
          });
        }

        // on rail over
        rail.hover(function(){
          showBar();
        }, function(){
          hideBar();
        });

        // on bar over
        bar.hover(function(){
          isOverBar = true;
        }, function(){
          isOverBar = false;
        });

        // show on parent mouseover
        me.hover(function(){
          isOverPanel = true;
          showBar();
          hideBar();
        }, function(){
          isOverPanel = false;
          hideBar();
        });

        // support for mobile
        me.bind('touchstart', function(e,b){
          if (e.originalEvent.touches.length)
          {
            // record where touch started
            touchDif = e.originalEvent.touches[0].pageY;
          }
        });

        me.bind('touchmove', function(e){
          // prevent scrolling the page if necessary
          if(!releaseScroll)
          {
  		      e.originalEvent.preventDefault();
		      }
          if (e.originalEvent.touches.length)
          {
            // see how far user swiped
            var diff = (touchDif - e.originalEvent.touches[0].pageY) / o.touchScrollStep;
            // scroll content
            scrollContent(diff, true);
            touchDif = e.originalEvent.touches[0].pageY;
          }
        });

        // set up initial height
        getBarHeight();

        // check start position
        if (o.start === 'bottom')
        {
          // scroll content to bottom
          bar.css({ top: me.outerHeight() - bar.outerHeight() });
          scrollContent(0, true);
        }
        else if (o.start !== 'top')
        {
          // assume jQuery selector
          scrollContent($(o.start).position().top, null, true);

          // make sure bar stays hidden
          if (!o.alwaysVisible) { bar.hide(); }
        }

        // attach scroll events
        attachWheel(this);

        function _onWheel(e)
        {
          // use mouse wheel only when mouse is over
          if (!isOverPanel) { return; }

          var e = e || window.event;

          var delta = 0;
          if (e.wheelDelta) { delta = -e.wheelDelta/120; }
          if (e.detail) { delta = e.detail / 3; }

          var target = e.target || e.srcTarget || e.srcElement;
          if ($(target).closest('.' + o.wrapperClass).is(me.parent())) {
            // scroll content
            scrollContent(delta, true);
          }

          // stop window scroll
          if (e.preventDefault && !releaseScroll) { e.preventDefault(); }
          if (!releaseScroll) { e.returnValue = false; }
        }

        function scrollContent(y, isWheel, isJump)
        {
          releaseScroll = false;
          var delta = y;
          var maxTop = me.outerHeight() - bar.outerHeight();

          if (isWheel)
          {
            // move bar with mouse wheel
            delta = parseInt(bar.css('top')) + y * parseInt(o.wheelStep) / 100 * bar.outerHeight();

            // move bar, make sure it doesn't go out
            delta = Math.min(Math.max(delta, 0), maxTop);

            // if scrolling down, make sure a fractional change to the
            // scroll position isn't rounded away when the scrollbar's CSS is set
            // this flooring of delta would happened automatically when
            // bar.css is set below, but we floor here for clarity
            delta = (y > 0) ? Math.ceil(delta) : Math.floor(delta);

            // scroll the scrollbar
            bar.css({ top: delta + 'px' });
          }

          // calculate actual scroll amount
          percentScroll = parseInt(bar.css('top')) / (me.outerHeight() - bar.outerHeight());
          delta = percentScroll * (me[0].scrollHeight - me.outerHeight());

          if (isJump)
          {
            delta = y;
            var offsetTop = delta / me[0].scrollHeight * me.outerHeight();
            offsetTop = Math.min(Math.max(offsetTop, 0), maxTop);
            bar.css({ top: offsetTop + 'px' });
          }

          // scroll content
          me.scrollTop(delta);

          // fire scrolling event
          me.trigger('slimscrolling', ~~delta);

          // ensure bar is visible
          showBar();

          // trigger hide when scroll is stopped
          hideBar();
        }

        function attachWheel(target)
        {
          if (window.addEventListener)
          {
            target.addEventListener('DOMMouseScroll', _onWheel, false );
            target.addEventListener('mousewheel', _onWheel, false );
          }
          else
          {
            document.attachEvent("onmousewheel", _onWheel)
          }
        }

        function getBarHeight()
        {
          // calculate scrollbar height and make sure it is not too small
          barHeight = Math.max((me.outerHeight() / me[0].scrollHeight) * me.outerHeight(), minBarHeight);
          bar.css({ height: barHeight + 'px' });

          // hide scrollbar if content is not long enough
          var display = barHeight == me.outerHeight() ? 'none' : 'block';
          bar.css({ display: display });
        }

        function showBar()
        {
          // recalculate bar height
          getBarHeight();
          clearTimeout(queueHide);

          // when bar reached top or bottom
          if (percentScroll == ~~percentScroll)
          {
            //release wheel
            releaseScroll = o.allowPageScroll;

            // publish approporiate event
            if (lastScroll != percentScroll)
            {
                var msg = (~~percentScroll == 0) ? 'top' : 'bottom';
                me.trigger('slimscroll', msg);
            }
          }
          else
          {
            releaseScroll = false;
          }
          lastScroll = percentScroll;

          // show only when required
          if(barHeight >= me.outerHeight()) {
            //allow window scroll
            releaseScroll = true;
            return;
          }
          bar.stop(true,true).fadeIn('fast');
          if (o.railVisible) { rail.stop(true,true).fadeIn('fast'); }
        }

        function hideBar()
        {
          // only hide when options allow it
          if (!o.alwaysVisible)
          {
            queueHide = setTimeout(function(){
              if (!(o.disableFadeOut && isOverPanel) && !isOverBar && !isDragg)
              {
                bar.fadeOut('slow');
                rail.fadeOut('slow');
              }
            }, 1000);
          }
        }

      });

      // maintain chainability
      return this;
    }
  });

  $.fn.extend({
    slimscroll: $.fn.slimScroll
  });

})(jQuery);

// This [jQuery](https://jquery.com/) plugin implements an `<iframe>`
// [transport](https://api.jquery.com/jQuery.ajax/#extending-ajax) so that
// `$.ajax()` calls support the uploading of files using standard HTML file
// input fields. This is done by switching the exchange from `XMLHttpRequest`
// to a hidden `iframe` element containing a form that is submitted.

// The [source for the plugin](https://github.com/cmlenz/jquery-iframe-transport)
// is available on [Github](https://github.com/) and licensed under the [MIT
// license](https://github.com/cmlenz/jquery-iframe-transport/blob/master/LICENSE).

// ## Usage

// To use this plugin, you simply add an `iframe` option with the value `true`
// to the Ajax settings an `$.ajax()` call, and specify the file fields to
// include in the submssion using the `files` option, which can be a selector,
// jQuery object, or a list of DOM elements containing one or more
// `<input type="file">` elements:

//     $("#myform").submit(function() {
//         $.ajax(this.action, {
//             files: $(":file", this),
//             iframe: true
//         }).complete(function(data) {
//             console.log(data);
//         });
//     });

// The plugin will construct hidden `<iframe>` and `<form>` elements, add the
// file field(s) to that form, submit the form, and process the response.

// If you want to include other form fields in the form submission, include
// them in the `data` option, and set the `processData` option to `false`:

//     $("#myform").submit(function() {
//         $.ajax(this.action, {
//             data: $(":text", this).serializeArray(),
//             files: $(":file", this),
//             iframe: true,
//             processData: false
//         }).complete(function(data) {
//             console.log(data);
//         });
//     });

// ### Response Data Types

// As the transport does not have access to the HTTP headers of the server
// response, it is not as simple to make use of the automatic content type
// detection provided by jQuery as with regular XHR. If you can't set the
// expected response data type (for example because it may vary depending on
// the outcome of processing by the server), you will need to employ a
// workaround on the server side: Send back an HTML document containing just a
// `<textarea>` element with a `data-type` attribute that specifies the MIME
// type, and put the actual payload in the textarea:

//     <textarea data-type="application/json">
//       {"ok": true, "message": "Thanks so much"}
//     </textarea>

// The iframe transport plugin will detect this and pass the value of the
// `data-type` attribute on to jQuery as if it was the "Content-Type" response
// header, thereby enabling the same kind of conversions that jQuery applies
// to regular responses. For the example above you should get a Javascript
// object as the `data` parameter of the `complete` callback, with the
// properties `ok: true` and `message: "Thanks so much"`.

// ### Handling Server Errors

// Another problem with using an `iframe` for file uploads is that it is
// impossible for the javascript code to determine the HTTP status code of the
// servers response. Effectively, all of the calls you make will look like they
// are getting successful responses, and thus invoke the `done()` or
// `complete()` callbacks. You can only communicate problems using the content
// of the response payload. For example, consider using a JSON response such as
// the following to indicate a problem with an uploaded file:

//     <textarea data-type="application/json">
//       {"ok": false, "message": "Please only upload reasonably sized files."}
//     </textarea>

// ### Compatibility

// This plugin has primarily been tested on Safari 5 (or later), Firefox 4 (or
// later), and Internet Explorer (all the way back to version 6). While I
// haven't found any issues with it so far, I'm fairly sure it still doesn't
// work around all the quirks in all different browsers. But the code is still
// pretty simple overall, so you should be able to fix it and contribute a
// patch :)

// ## Annotated Source

(function($, undefined) {
  "use strict";

  // Register a prefilter that checks whether the `iframe` option is set, and
  // switches to the "iframe" data type if it is `true`.
  $.ajaxPrefilter(function(options, origOptions, jqXHR) {
    if (options.iframe) {
      options.originalURL = options.url;
      return "iframe";
    }
  });

  // Register a transport for the "iframe" data type. It will only activate
  // when the "files" option has been set to a non-empty list of enabled file
  // inputs.
  $.ajaxTransport("iframe", function(options, origOptions, jqXHR) {
    var form = null,
        iframe = null,
        name = "iframe-" + $.now(),
        files = $(options.files).filter(":file:enabled"),
        markers = null,
        accepts = null;

    // This function gets called after a successful submission or an abortion
    // and should revert all changes made to the page to enable the
    // submission via this transport.
    function cleanUp() {
      files.each(function(i, file) {
        var $file = $(file);
        $file.data("clone").replaceWith($file);
      });
      form.remove();
      iframe.one("load", function() { iframe.remove(); });
      iframe.attr("src", "javascript:false;");
    }

    // Remove "iframe" from the data types list so that further processing is
    // based on the content type returned by the server, without attempting an
    // (unsupported) conversion from "iframe" to the actual type.
    options.dataTypes.shift();

    // Use the data from the original AJAX options, as it doesn't seem to be 
    // copied over since jQuery 1.7.
    // See https://github.com/cmlenz/jquery-iframe-transport/issues/6
    options.data = origOptions.data;

    if (files.length) {
      form = $("<form enctype='multipart/form-data' method='post'></form>").
        hide().attr({action: options.originalURL, target: name});

      // If there is any additional data specified via the `data` option,
      // we add it as hidden fields to the form. This (currently) requires
      // the `processData` option to be set to false so that the data doesn't
      // get serialized to a string.
      if (typeof(options.data) === "string" && options.data.length > 0) {
        $.error("data must not be serialized");
      }
      $.each(options.data || {}, function(name, value) {
        if ($.isPlainObject(value)) {
          name = value.name;
          value = value.value;
        }
        $("<input type='hidden' />").attr({name:  name, value: value}).
          appendTo(form);
      });

      // Add a hidden `X-Requested-With` field with the value `IFrame` to the
      // field, to help server-side code to determine that the upload happened
      // through this transport.
      $("<input type='hidden' value='IFrame' name='X-Requested-With' />").
        appendTo(form);

      // Borrowed straight from the JQuery source.
      // Provides a way of specifying the accepted data type similar to the
      // HTTP "Accept" header
      if (options.dataTypes[0] && options.accepts[options.dataTypes[0]]) {
        accepts = options.accepts[options.dataTypes[0]] +
                  (options.dataTypes[0] !== "*" ? ", */*; q=0.01" : "");
      } else {
        accepts = options.accepts["*"];
      }
      $("<input type='hidden' name='X-HTTP-Accept'>").
        attr("value", accepts).appendTo(form);

      // Move the file fields into the hidden form, but first remember their
      // original locations in the document by replacing them with disabled
      // clones. This should also avoid introducing unwanted changes to the
      // page layout during submission.
      markers = files.after(function(idx) {
        var $this = $(this),
            $clone = $this.clone().prop("disabled", true);
        $this.data("clone", $clone);
        return $clone;
      }).next();
      files.appendTo(form);

      return {

        // The `send` function is called by jQuery when the request should be
        // sent.
        send: function(headers, completeCallback) {
          iframe = $("<iframe src='javascript:false;' name='" + name +
            "' id='" + name + "' style='display:none'></iframe>");

          // The first load event gets fired after the iframe has been injected
          // into the DOM, and is used to prepare the actual submission.
          iframe.one("load", function() {

            // The second load event gets fired when the response to the form
            // submission is received. The implementation detects whether the
            // actual payload is embedded in a `<textarea>` element, and
            // prepares the required conversions to be made in that case.
            iframe.one("load", function() {
              var doc = this.contentWindow ? this.contentWindow.document :
                (this.contentDocument ? this.contentDocument : this.document),
                root = doc.documentElement ? doc.documentElement : doc.body,
                textarea = root.getElementsByTagName("textarea")[0],
                type = textarea && textarea.getAttribute("data-type") || null,
                status = textarea && textarea.getAttribute("data-status") || 200,
                statusText = textarea && textarea.getAttribute("data-statusText") || "OK",
                content = {
                  html: root.innerHTML,
                  text: type ?
                    textarea.value :
                    root ? (root.textContent || root.innerText) : null
                };
              cleanUp();
              completeCallback(status, statusText, content, type ?
                ("Content-Type: " + type) :
                null);
            });

            // Now that the load handler has been set up, submit the form.
            form[0].submit();
          });

          // After everything has been set up correctly, the form and iframe
          // get injected into the DOM so that the submission can be
          // initiated.
          $("body").append(form, iframe);
        },

        // The `abort` function is called by jQuery when the request should be
        // aborted.
        abort: function() {
          if (iframe !== null) {
            iframe.unbind("load").attr("src", "javascript:false;");
            cleanUp();
          }
        }

      };
    }
  });

})(jQuery);

/*
 * jQuery File Upload Plugin
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

/* jshint nomen:false */
/* global define, require, window, document, location, Blob, FormData */

;(function (factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // Register as an anonymous AMD module:
        define([
            'jquery',
            'jquery-ui/ui/widget'
        ], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS:
        factory(
            require('jquery'),
            require('./vendor/jquery.ui.widget')
        );
    } else {
        // Browser globals:
        factory(window.jQuery);
    }
}(function ($) {
    'use strict';

    // Detect file input support, based on
    // http://viljamis.com/blog/2012/file-upload-support-on-mobile/
    $.support.fileInput = !(new RegExp(
        // Handle devices which give false positives for the feature detection:
        '(Android (1\\.[0156]|2\\.[01]))' +
            '|(Windows Phone (OS 7|8\\.0))|(XBLWP)|(ZuneWP)|(WPDesktop)' +
            '|(w(eb)?OSBrowser)|(webOS)' +
            '|(Kindle/(1\\.0|2\\.[05]|3\\.0))'
    ).test(window.navigator.userAgent) ||
        // Feature detection for all other devices:
        $('<input type="file"/>').prop('disabled'));

    // The FileReader API is not actually used, but works as feature detection,
    // as some Safari versions (5?) support XHR file uploads via the FormData API,
    // but not non-multipart XHR file uploads.
    // window.XMLHttpRequestUpload is not available on IE10, so we check for
    // window.ProgressEvent instead to detect XHR2 file upload capability:
    $.support.xhrFileUpload = !!(window.ProgressEvent && window.FileReader);
    $.support.xhrFormDataFileUpload = !!window.FormData;

    // Detect support for Blob slicing (required for chunked uploads):
    $.support.blobSlice = window.Blob && (Blob.prototype.slice ||
        Blob.prototype.webkitSlice || Blob.prototype.mozSlice);

    // Helper function to create drag handlers for dragover/dragenter/dragleave:
    function getDragHandler(type) {
        var isDragOver = type === 'dragover';
        return function (e) {
            e.dataTransfer = e.originalEvent && e.originalEvent.dataTransfer;
            var dataTransfer = e.dataTransfer;
            if (dataTransfer && $.inArray('Files', dataTransfer.types) !== -1 &&
                    this._trigger(
                        type,
                        $.Event(type, {delegatedEvent: e})
                    ) !== false) {
                e.preventDefault();
                if (isDragOver) {
                    dataTransfer.dropEffect = 'copy';
                }
            }
        };
    }

    // The fileupload widget listens for change events on file input fields defined
    // via fileInput setting and paste or drop events of the given dropZone.
    // In addition to the default jQuery Widget methods, the fileupload widget
    // exposes the "add" and "send" methods, to add or directly send files using
    // the fileupload API.
    // By default, files added via file input selection, paste, drag & drop or
    // "add" method are uploaded immediately, but it is possible to override
    // the "add" callback option to queue file uploads.
    $.widget('blueimp.fileupload', {

        options: {
            // The drop target element(s), by the default the complete document.
            // Set to null to disable drag & drop support:
            dropZone: $(document),
            // The paste target element(s), by the default undefined.
            // Set to a DOM node or jQuery object to enable file pasting:
            pasteZone: undefined,
            // The file input field(s), that are listened to for change events.
            // If undefined, it is set to the file input fields inside
            // of the widget element on plugin initialization.
            // Set to null to disable the change listener.
            fileInput: undefined,
            // By default, the file input field is replaced with a clone after
            // each input field change event. This is required for iframe transport
            // queues and allows change events to be fired for the same file
            // selection, but can be disabled by setting the following option to false:
            replaceFileInput: true,
            // The parameter name for the file form data (the request argument name).
            // If undefined or empty, the name property of the file input field is
            // used, or "files[]" if the file input name property is also empty,
            // can be a string or an array of strings:
            paramName: undefined,
            // By default, each file of a selection is uploaded using an individual
            // request for XHR type uploads. Set to false to upload file
            // selections in one request each:
            singleFileUploads: true,
            // To limit the number of files uploaded with one XHR request,
            // set the following option to an integer greater than 0:
            limitMultiFileUploads: undefined,
            // The following option limits the number of files uploaded with one
            // XHR request to keep the request size under or equal to the defined
            // limit in bytes:
            limitMultiFileUploadSize: undefined,
            // Multipart file uploads add a number of bytes to each uploaded file,
            // therefore the following option adds an overhead for each file used
            // in the limitMultiFileUploadSize configuration:
            limitMultiFileUploadSizeOverhead: 512,
            // Set the following option to true to issue all file upload requests
            // in a sequential order:
            sequentialUploads: false,
            // To limit the number of concurrent uploads,
            // set the following option to an integer greater than 0:
            limitConcurrentUploads: undefined,
            // Set the following option to true to force iframe transport uploads:
            forceIframeTransport: false,
            // Set the following option to the location of a redirect url on the
            // origin server, for cross-domain iframe transport uploads:
            redirect: undefined,
            // The parameter name for the redirect url, sent as part of the form
            // data and set to 'redirect' if this option is empty:
            redirectParamName: undefined,
            // Set the following option to the location of a postMessage window,
            // to enable postMessage transport uploads:
            postMessage: undefined,
            // By default, XHR file uploads are sent as multipart/form-data.
            // The iframe transport is always using multipart/form-data.
            // Set to false to enable non-multipart XHR uploads:
            multipart: true,
            // To upload large files in smaller chunks, set the following option
            // to a preferred maximum chunk size. If set to 0, null or undefined,
            // or the browser does not support the required Blob API, files will
            // be uploaded as a whole.
            maxChunkSize: undefined,
            // When a non-multipart upload or a chunked multipart upload has been
            // aborted, this option can be used to resume the upload by setting
            // it to the size of the already uploaded bytes. This option is most
            // useful when modifying the options object inside of the "add" or
            // "send" callbacks, as the options are cloned for each file upload.
            uploadedBytes: undefined,
            // By default, failed (abort or error) file uploads are removed from the
            // global progress calculation. Set the following option to false to
            // prevent recalculating the global progress data:
            recalculateProgress: true,
            // Interval in milliseconds to calculate and trigger progress events:
            progressInterval: 100,
            // Interval in milliseconds to calculate progress bitrate:
            bitrateInterval: 500,
            // By default, uploads are started automatically when adding files:
            autoUpload: true,

            // Error and info messages:
            messages: {
                uploadedBytes: 'Uploaded bytes exceed file size'
            },

            // Translation function, gets the message key to be translated
            // and an object with context specific data as arguments:
            i18n: function (message, context) {
                message = this.messages[message] || message.toString();
                if (context) {
                    $.each(context, function (key, value) {
                        message = message.replace('{' + key + '}', value);
                    });
                }
                return message;
            },

            // Additional form data to be sent along with the file uploads can be set
            // using this option, which accepts an array of objects with name and
            // value properties, a function returning such an array, a FormData
            // object (for XHR file uploads), or a simple object.
            // The form of the first fileInput is given as parameter to the function:
            formData: function (form) {
                return form.serializeArray();
            },

            // The add callback is invoked as soon as files are added to the fileupload
            // widget (via file input selection, drag & drop, paste or add API call).
            // If the singleFileUploads option is enabled, this callback will be
            // called once for each file in the selection for XHR file uploads, else
            // once for each file selection.
            //
            // The upload starts when the submit method is invoked on the data parameter.
            // The data object contains a files property holding the added files
            // and allows you to override plugin options as well as define ajax settings.
            //
            // Listeners for this callback can also be bound the following way:
            // .bind('fileuploadadd', func);
            //
            // data.submit() returns a Promise object and allows to attach additional
            // handlers using jQuery's Deferred callbacks:
            // data.submit().done(func).fail(func).always(func);
            add: function (e, data) {
                if (e.isDefaultPrevented()) {
                    return false;
                }
                if (data.autoUpload || (data.autoUpload !== false &&
                        $(this).fileupload('option', 'autoUpload'))) {
                    data.process().done(function () {
                        data.submit();
                    });
                }
            },

            // Other callbacks:

            // Callback for the submit event of each file upload:
            // submit: function (e, data) {}, // .bind('fileuploadsubmit', func);

            // Callback for the start of each file upload request:
            // send: function (e, data) {}, // .bind('fileuploadsend', func);

            // Callback for successful uploads:
            // done: function (e, data) {}, // .bind('fileuploaddone', func);

            // Callback for failed (abort or error) uploads:
            // fail: function (e, data) {}, // .bind('fileuploadfail', func);

            // Callback for completed (success, abort or error) requests:
            // always: function (e, data) {}, // .bind('fileuploadalways', func);

            // Callback for upload progress events:
            // progress: function (e, data) {}, // .bind('fileuploadprogress', func);

            // Callback for global upload progress events:
            // progressall: function (e, data) {}, // .bind('fileuploadprogressall', func);

            // Callback for uploads start, equivalent to the global ajaxStart event:
            // start: function (e) {}, // .bind('fileuploadstart', func);

            // Callback for uploads stop, equivalent to the global ajaxStop event:
            // stop: function (e) {}, // .bind('fileuploadstop', func);

            // Callback for change events of the fileInput(s):
            // change: function (e, data) {}, // .bind('fileuploadchange', func);

            // Callback for paste events to the pasteZone(s):
            // paste: function (e, data) {}, // .bind('fileuploadpaste', func);

            // Callback for drop events of the dropZone(s):
            // drop: function (e, data) {}, // .bind('fileuploaddrop', func);

            // Callback for dragover events of the dropZone(s):
            // dragover: function (e) {}, // .bind('fileuploaddragover', func);

            // Callback for the start of each chunk upload request:
            // chunksend: function (e, data) {}, // .bind('fileuploadchunksend', func);

            // Callback for successful chunk uploads:
            // chunkdone: function (e, data) {}, // .bind('fileuploadchunkdone', func);

            // Callback for failed (abort or error) chunk uploads:
            // chunkfail: function (e, data) {}, // .bind('fileuploadchunkfail', func);

            // Callback for completed (success, abort or error) chunk upload requests:
            // chunkalways: function (e, data) {}, // .bind('fileuploadchunkalways', func);

            // The plugin options are used as settings object for the ajax calls.
            // The following are jQuery ajax settings required for the file uploads:
            processData: false,
            contentType: false,
            cache: false,
            timeout: 0
        },

        // A list of options that require reinitializing event listeners and/or
        // special initialization code:
        _specialOptions: [
            'fileInput',
            'dropZone',
            'pasteZone',
            'multipart',
            'forceIframeTransport'
        ],

        _blobSlice: $.support.blobSlice && function () {
            var slice = this.slice || this.webkitSlice || this.mozSlice;
            return slice.apply(this, arguments);
        },

        _BitrateTimer: function () {
            this.timestamp = ((Date.now) ? Date.now() : (new Date()).getTime());
            this.loaded = 0;
            this.bitrate = 0;
            this.getBitrate = function (now, loaded, interval) {
                var timeDiff = now - this.timestamp;
                if (!this.bitrate || !interval || timeDiff > interval) {
                    this.bitrate = (loaded - this.loaded) * (1000 / timeDiff) * 8;
                    this.loaded = loaded;
                    this.timestamp = now;
                }
                return this.bitrate;
            };
        },

        _isXHRUpload: function (options) {
            return !options.forceIframeTransport &&
                ((!options.multipart && $.support.xhrFileUpload) ||
                $.support.xhrFormDataFileUpload);
        },

        _getFormData: function (options) {
            var formData;
            if ($.type(options.formData) === 'function') {
                return options.formData(options.form);
            }
            if ($.isArray(options.formData)) {
                return options.formData;
            }
            if ($.type(options.formData) === 'object') {
                formData = [];
                $.each(options.formData, function (name, value) {
                    formData.push({name: name, value: value});
                });
                return formData;
            }
            return [];
        },

        _getTotal: function (files) {
            var total = 0;
            $.each(files, function (index, file) {
                total += file.size || 1;
            });
            return total;
        },

        _initProgressObject: function (obj) {
            var progress = {
                loaded: 0,
                total: 0,
                bitrate: 0
            };
            if (obj._progress) {
                $.extend(obj._progress, progress);
            } else {
                obj._progress = progress;
            }
        },

        _initResponseObject: function (obj) {
            var prop;
            if (obj._response) {
                for (prop in obj._response) {
                    if (obj._response.hasOwnProperty(prop)) {
                        delete obj._response[prop];
                    }
                }
            } else {
                obj._response = {};
            }
        },

        _onProgress: function (e, data) {
            if (e.lengthComputable) {
                var now = ((Date.now) ? Date.now() : (new Date()).getTime()),
                    loaded;
                if (data._time && data.progressInterval &&
                        (now - data._time < data.progressInterval) &&
                        e.loaded !== e.total) {
                    return;
                }
                data._time = now;
                loaded = Math.floor(
                    e.loaded / e.total * (data.chunkSize || data._progress.total)
                ) + (data.uploadedBytes || 0);
                // Add the difference from the previously loaded state
                // to the global loaded counter:
                this._progress.loaded += (loaded - data._progress.loaded);
                this._progress.bitrate = this._bitrateTimer.getBitrate(
                    now,
                    this._progress.loaded,
                    data.bitrateInterval
                );
                data._progress.loaded = data.loaded = loaded;
                data._progress.bitrate = data.bitrate = data._bitrateTimer.getBitrate(
                    now,
                    loaded,
                    data.bitrateInterval
                );
                // Trigger a custom progress event with a total data property set
                // to the file size(s) of the current upload and a loaded data
                // property calculated accordingly:
                this._trigger(
                    'progress',
                    $.Event('progress', {delegatedEvent: e}),
                    data
                );
                // Trigger a global progress event for all current file uploads,
                // including ajax calls queued for sequential file uploads:
                this._trigger(
                    'progressall',
                    $.Event('progressall', {delegatedEvent: e}),
                    this._progress
                );
            }
        },

        _initProgressListener: function (options) {
            var that = this,
                xhr = options.xhr ? options.xhr() : $.ajaxSettings.xhr();
            // Accesss to the native XHR object is required to add event listeners
            // for the upload progress event:
            if (xhr.upload) {
                $(xhr.upload).bind('progress', function (e) {
                    var oe = e.originalEvent;
                    // Make sure the progress event properties get copied over:
                    e.lengthComputable = oe.lengthComputable;
                    e.loaded = oe.loaded;
                    e.total = oe.total;
                    that._onProgress(e, options);
                });
                options.xhr = function () {
                    return xhr;
                };
            }
        },

        _isInstanceOf: function (type, obj) {
            // Cross-frame instanceof check
            return Object.prototype.toString.call(obj) === '[object ' + type + ']';
        },

        _initXHRData: function (options) {
            var that = this,
                formData,
                file = options.files[0],
                // Ignore non-multipart setting if not supported:
                multipart = options.multipart || !$.support.xhrFileUpload,
                paramName = $.type(options.paramName) === 'array' ?
                    options.paramName[0] : options.paramName;
            options.headers = $.extend({}, options.headers);
            if (options.contentRange) {
                options.headers['Content-Range'] = options.contentRange;
            }
            if (!multipart || options.blob || !this._isInstanceOf('File', file)) {
                options.headers['Content-Disposition'] = 'attachment; filename="' +
                    encodeURI(file.uploadName || file.name) + '"';
            }
            if (!multipart) {
                options.contentType = file.type || 'application/octet-stream';
                options.data = options.blob || file;
            } else if ($.support.xhrFormDataFileUpload) {
                if (options.postMessage) {
                    // window.postMessage does not allow sending FormData
                    // objects, so we just add the File/Blob objects to
                    // the formData array and let the postMessage window
                    // create the FormData object out of this array:
                    formData = this._getFormData(options);
                    if (options.blob) {
                        formData.push({
                            name: paramName,
                            value: options.blob
                        });
                    } else {
                        $.each(options.files, function (index, file) {
                            formData.push({
                                name: ($.type(options.paramName) === 'array' &&
                                    options.paramName[index]) || paramName,
                                value: file
                            });
                        });
                    }
                } else {
                    if (that._isInstanceOf('FormData', options.formData)) {
                        formData = options.formData;
                    } else {
                        formData = new FormData();
                        $.each(this._getFormData(options), function (index, field) {
                            formData.append(field.name, field.value);
                        });
                    }
                    if (options.blob) {
                        formData.append(
                            paramName,
                            options.blob,
                            file.uploadName || file.name
                        );
                    } else {
                        $.each(options.files, function (index, file) {
                            // This check allows the tests to run with
                            // dummy objects:
                            if (that._isInstanceOf('File', file) ||
                                    that._isInstanceOf('Blob', file)) {
                                formData.append(
                                    ($.type(options.paramName) === 'array' &&
                                        options.paramName[index]) || paramName,
                                    file,
                                    file.uploadName || file.name
                                );
                            }
                        });
                    }
                }
                options.data = formData;
            }
            // Blob reference is not needed anymore, free memory:
            options.blob = null;
        },

        _initIframeSettings: function (options) {
            var targetHost = $('<a></a>').prop('href', options.url).prop('host');
            // Setting the dataType to iframe enables the iframe transport:
            options.dataType = 'iframe ' + (options.dataType || '');
            // The iframe transport accepts a serialized array as form data:
            options.formData = this._getFormData(options);
            // Add redirect url to form data on cross-domain uploads:
            if (options.redirect && targetHost && targetHost !== location.host) {
                options.formData.push({
                    name: options.redirectParamName || 'redirect',
                    value: options.redirect
                });
            }
        },

        _initDataSettings: function (options) {
            if (this._isXHRUpload(options)) {
                if (!this._chunkedUpload(options, true)) {
                    if (!options.data) {
                        this._initXHRData(options);
                    }
                    this._initProgressListener(options);
                }
                if (options.postMessage) {
                    // Setting the dataType to postmessage enables the
                    // postMessage transport:
                    options.dataType = 'postmessage ' + (options.dataType || '');
                }
            } else {
                this._initIframeSettings(options);
            }
        },

        _getParamName: function (options) {
            var fileInput = $(options.fileInput),
                paramName = options.paramName;
            if (!paramName) {
                paramName = [];
                fileInput.each(function () {
                    var input = $(this),
                        name = input.prop('name') || 'files[]',
                        i = (input.prop('files') || [1]).length;
                    while (i) {
                        paramName.push(name);
                        i -= 1;
                    }
                });
                if (!paramName.length) {
                    paramName = [fileInput.prop('name') || 'files[]'];
                }
            } else if (!$.isArray(paramName)) {
                paramName = [paramName];
            }
            return paramName;
        },

        _initFormSettings: function (options) {
            // Retrieve missing options from the input field and the
            // associated form, if available:
            if (!options.form || !options.form.length) {
                options.form = $(options.fileInput.prop('form'));
                // If the given file input doesn't have an associated form,
                // use the default widget file input's form:
                if (!options.form.length) {
                    options.form = $(this.options.fileInput.prop('form'));
                }
            }
            options.paramName = this._getParamName(options);
            if (!options.url) {
                options.url = options.form.prop('action') || location.href;
            }
            // The HTTP request method must be "POST" or "PUT":
            options.type = (options.type ||
                ($.type(options.form.prop('method')) === 'string' &&
                    options.form.prop('method')) || ''
                ).toUpperCase();
            if (options.type !== 'POST' && options.type !== 'PUT' &&
                    options.type !== 'PATCH') {
                options.type = 'POST';
            }
            if (!options.formAcceptCharset) {
                options.formAcceptCharset = options.form.attr('accept-charset');
            }
        },

        _getAJAXSettings: function (data) {
            var options = $.extend({}, this.options, data);
            this._initFormSettings(options);
            this._initDataSettings(options);
            return options;
        },

        // jQuery 1.6 doesn't provide .state(),
        // while jQuery 1.8+ removed .isRejected() and .isResolved():
        _getDeferredState: function (deferred) {
            if (deferred.state) {
                return deferred.state();
            }
            if (deferred.isResolved()) {
                return 'resolved';
            }
            if (deferred.isRejected()) {
                return 'rejected';
            }
            return 'pending';
        },

        // Maps jqXHR callbacks to the equivalent
        // methods of the given Promise object:
        _enhancePromise: function (promise) {
            promise.success = promise.done;
            promise.error = promise.fail;
            promise.complete = promise.always;
            return promise;
        },

        // Creates and returns a Promise object enhanced with
        // the jqXHR methods abort, success, error and complete:
        _getXHRPromise: function (resolveOrReject, context, args) {
            var dfd = $.Deferred(),
                promise = dfd.promise();
            context = context || this.options.context || promise;
            if (resolveOrReject === true) {
                dfd.resolveWith(context, args);
            } else if (resolveOrReject === false) {
                dfd.rejectWith(context, args);
            }
            promise.abort = dfd.promise;
            return this._enhancePromise(promise);
        },

        // Adds convenience methods to the data callback argument:
        _addConvenienceMethods: function (e, data) {
            var that = this,
                getPromise = function (args) {
                    return $.Deferred().resolveWith(that, args).promise();
                };
            data.process = function (resolveFunc, rejectFunc) {
                if (resolveFunc || rejectFunc) {
                    data._processQueue = this._processQueue =
                        (this._processQueue || getPromise([this])).then(
                            function () {
                                if (data.errorThrown) {
                                    return $.Deferred()
                                        .rejectWith(that, [data]).promise();
                                }
                                return getPromise(arguments);
                            }
                        ).then(resolveFunc, rejectFunc);
                }
                return this._processQueue || getPromise([this]);
            };
            data.submit = function () {
                if (this.state() !== 'pending') {
                    data.jqXHR = this.jqXHR =
                        (that._trigger(
                            'submit',
                            $.Event('submit', {delegatedEvent: e}),
                            this
                        ) !== false) && that._onSend(e, this);
                }
                return this.jqXHR || that._getXHRPromise();
            };
            data.abort = function () {
                if (this.jqXHR) {
                    return this.jqXHR.abort();
                }
                this.errorThrown = 'abort';
                that._trigger('fail', null, this);
                return that._getXHRPromise(false);
            };
            data.state = function () {
                if (this.jqXHR) {
                    return that._getDeferredState(this.jqXHR);
                }
                if (this._processQueue) {
                    return that._getDeferredState(this._processQueue);
                }
            };
            data.processing = function () {
                return !this.jqXHR && this._processQueue && that
                    ._getDeferredState(this._processQueue) === 'pending';
            };
            data.progress = function () {
                return this._progress;
            };
            data.response = function () {
                return this._response;
            };
        },

        // Parses the Range header from the server response
        // and returns the uploaded bytes:
        _getUploadedBytes: function (jqXHR) {
            var range = jqXHR.getResponseHeader('Range'),
                parts = range && range.split('-'),
                upperBytesPos = parts && parts.length > 1 &&
                    parseInt(parts[1], 10);
            return upperBytesPos && upperBytesPos + 1;
        },

        // Uploads a file in multiple, sequential requests
        // by splitting the file up in multiple blob chunks.
        // If the second parameter is true, only tests if the file
        // should be uploaded in chunks, but does not invoke any
        // upload requests:
        _chunkedUpload: function (options, testOnly) {
            options.uploadedBytes = options.uploadedBytes || 0;
            var that = this,
                file = options.files[0],
                fs = file.size,
                ub = options.uploadedBytes,
                mcs = options.maxChunkSize || fs,
                slice = this._blobSlice,
                dfd = $.Deferred(),
                promise = dfd.promise(),
                jqXHR,
                upload;
            if (!(this._isXHRUpload(options) && slice && (ub || ($.type(mcs) === 'function' ? mcs(options) : mcs) < fs)) ||
                    options.data) {
                return false;
            }
            if (testOnly) {
                return true;
            }
            if (ub >= fs) {
                file.error = options.i18n('uploadedBytes');
                return this._getXHRPromise(
                    false,
                    options.context,
                    [null, 'error', file.error]
                );
            }
            // The chunk upload method:
            upload = function () {
                // Clone the options object for each chunk upload:
                var o = $.extend({}, options),
                    currentLoaded = o._progress.loaded;
                o.blob = slice.call(
                    file,
                    ub,
                    ub + ($.type(mcs) === 'function' ? mcs(o) : mcs),
                    file.type
                );
                // Store the current chunk size, as the blob itself
                // will be dereferenced after data processing:
                o.chunkSize = o.blob.size;
                // Expose the chunk bytes position range:
                o.contentRange = 'bytes ' + ub + '-' +
                    (ub + o.chunkSize - 1) + '/' + fs;
                // Process the upload data (the blob and potential form data):
                that._initXHRData(o);
                // Add progress listeners for this chunk upload:
                that._initProgressListener(o);
                jqXHR = ((that._trigger('chunksend', null, o) !== false && $.ajax(o)) ||
                        that._getXHRPromise(false, o.context))
                    .done(function (result, textStatus, jqXHR) {
                        ub = that._getUploadedBytes(jqXHR) ||
                            (ub + o.chunkSize);
                        // Create a progress event if no final progress event
                        // with loaded equaling total has been triggered
                        // for this chunk:
                        if (currentLoaded + o.chunkSize - o._progress.loaded) {
                            that._onProgress($.Event('progress', {
                                lengthComputable: true,
                                loaded: ub - o.uploadedBytes,
                                total: ub - o.uploadedBytes
                            }), o);
                        }
                        options.uploadedBytes = o.uploadedBytes = ub;
                        o.result = result;
                        o.textStatus = textStatus;
                        o.jqXHR = jqXHR;
                        that._trigger('chunkdone', null, o);
                        that._trigger('chunkalways', null, o);
                        if (ub < fs) {
                            // File upload not yet complete,
                            // continue with the next chunk:
                            upload();
                        } else {
                            dfd.resolveWith(
                                o.context,
                                [result, textStatus, jqXHR]
                            );
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        o.jqXHR = jqXHR;
                        o.textStatus = textStatus;
                        o.errorThrown = errorThrown;
                        that._trigger('chunkfail', null, o);
                        that._trigger('chunkalways', null, o);
                        dfd.rejectWith(
                            o.context,
                            [jqXHR, textStatus, errorThrown]
                        );
                    });
            };
            this._enhancePromise(promise);
            promise.abort = function () {
                return jqXHR.abort();
            };
            upload();
            return promise;
        },

        _beforeSend: function (e, data) {
            if (this._active === 0) {
                // the start callback is triggered when an upload starts
                // and no other uploads are currently running,
                // equivalent to the global ajaxStart event:
                this._trigger('start');
                // Set timer for global bitrate progress calculation:
                this._bitrateTimer = new this._BitrateTimer();
                // Reset the global progress values:
                this._progress.loaded = this._progress.total = 0;
                this._progress.bitrate = 0;
            }
            // Make sure the container objects for the .response() and
            // .progress() methods on the data object are available
            // and reset to their initial state:
            this._initResponseObject(data);
            this._initProgressObject(data);
            data._progress.loaded = data.loaded = data.uploadedBytes || 0;
            data._progress.total = data.total = this._getTotal(data.files) || 1;
            data._progress.bitrate = data.bitrate = 0;
            this._active += 1;
            // Initialize the global progress values:
            this._progress.loaded += data.loaded;
            this._progress.total += data.total;
        },

        _onDone: function (result, textStatus, jqXHR, options) {
            var total = options._progress.total,
                response = options._response;
            if (options._progress.loaded < total) {
                // Create a progress event if no final progress event
                // with loaded equaling total has been triggered:
                this._onProgress($.Event('progress', {
                    lengthComputable: true,
                    loaded: total,
                    total: total
                }), options);
            }
            response.result = options.result = result;
            response.textStatus = options.textStatus = textStatus;
            response.jqXHR = options.jqXHR = jqXHR;
            this._trigger('done', null, options);
        },

        _onFail: function (jqXHR, textStatus, errorThrown, options) {
            var response = options._response;
            if (options.recalculateProgress) {
                // Remove the failed (error or abort) file upload from
                // the global progress calculation:
                this._progress.loaded -= options._progress.loaded;
                this._progress.total -= options._progress.total;
            }
            response.jqXHR = options.jqXHR = jqXHR;
            response.textStatus = options.textStatus = textStatus;
            response.errorThrown = options.errorThrown = errorThrown;
            this._trigger('fail', null, options);
        },

        _onAlways: function (jqXHRorResult, textStatus, jqXHRorError, options) {
            // jqXHRorResult, textStatus and jqXHRorError are added to the
            // options object via done and fail callbacks
            this._trigger('always', null, options);
        },

        _onSend: function (e, data) {
            if (!data.submit) {
                this._addConvenienceMethods(e, data);
            }
            var that = this,
                jqXHR,
                aborted,
                slot,
                pipe,
                options = that._getAJAXSettings(data),
                send = function () {
                    that._sending += 1;
                    // Set timer for bitrate progress calculation:
                    options._bitrateTimer = new that._BitrateTimer();
                    jqXHR = jqXHR || (
                        ((aborted || that._trigger(
                            'send',
                            $.Event('send', {delegatedEvent: e}),
                            options
                        ) === false) &&
                        that._getXHRPromise(false, options.context, aborted)) ||
                        that._chunkedUpload(options) || $.ajax(options)
                    ).done(function (result, textStatus, jqXHR) {
                        that._onDone(result, textStatus, jqXHR, options);
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        that._onFail(jqXHR, textStatus, errorThrown, options);
                    }).always(function (jqXHRorResult, textStatus, jqXHRorError) {
                        that._onAlways(
                            jqXHRorResult,
                            textStatus,
                            jqXHRorError,
                            options
                        );
                        that._sending -= 1;
                        that._active -= 1;
                        if (options.limitConcurrentUploads &&
                                options.limitConcurrentUploads > that._sending) {
                            // Start the next queued upload,
                            // that has not been aborted:
                            var nextSlot = that._slots.shift();
                            while (nextSlot) {
                                if (that._getDeferredState(nextSlot) === 'pending') {
                                    nextSlot.resolve();
                                    break;
                                }
                                nextSlot = that._slots.shift();
                            }
                        }
                        if (that._active === 0) {
                            // The stop callback is triggered when all uploads have
                            // been completed, equivalent to the global ajaxStop event:
                            that._trigger('stop');
                        }
                    });
                    return jqXHR;
                };
            this._beforeSend(e, options);
            if (this.options.sequentialUploads ||
                    (this.options.limitConcurrentUploads &&
                    this.options.limitConcurrentUploads <= this._sending)) {
                if (this.options.limitConcurrentUploads > 1) {
                    slot = $.Deferred();
                    this._slots.push(slot);
                    pipe = slot.then(send);
                } else {
                    this._sequence = this._sequence.then(send, send);
                    pipe = this._sequence;
                }
                // Return the piped Promise object, enhanced with an abort method,
                // which is delegated to the jqXHR object of the current upload,
                // and jqXHR callbacks mapped to the equivalent Promise methods:
                pipe.abort = function () {
                    aborted = [undefined, 'abort', 'abort'];
                    if (!jqXHR) {
                        if (slot) {
                            slot.rejectWith(options.context, aborted);
                        }
                        return send();
                    }
                    return jqXHR.abort();
                };
                return this._enhancePromise(pipe);
            }
            return send();
        },

        _onAdd: function (e, data) {
            var that = this,
                result = true,
                options = $.extend({}, this.options, data),
                files = data.files,
                filesLength = files.length,
                limit = options.limitMultiFileUploads,
                limitSize = options.limitMultiFileUploadSize,
                overhead = options.limitMultiFileUploadSizeOverhead,
                batchSize = 0,
                paramName = this._getParamName(options),
                paramNameSet,
                paramNameSlice,
                fileSet,
                i,
                j = 0;
            if (!filesLength) {
                return false;
            }
            if (limitSize && files[0].size === undefined) {
                limitSize = undefined;
            }
            if (!(options.singleFileUploads || limit || limitSize) ||
                    !this._isXHRUpload(options)) {
                fileSet = [files];
                paramNameSet = [paramName];
            } else if (!(options.singleFileUploads || limitSize) && limit) {
                fileSet = [];
                paramNameSet = [];
                for (i = 0; i < filesLength; i += limit) {
                    fileSet.push(files.slice(i, i + limit));
                    paramNameSlice = paramName.slice(i, i + limit);
                    if (!paramNameSlice.length) {
                        paramNameSlice = paramName;
                    }
                    paramNameSet.push(paramNameSlice);
                }
            } else if (!options.singleFileUploads && limitSize) {
                fileSet = [];
                paramNameSet = [];
                for (i = 0; i < filesLength; i = i + 1) {
                    batchSize += files[i].size + overhead;
                    if (i + 1 === filesLength ||
                            ((batchSize + files[i + 1].size + overhead) > limitSize) ||
                            (limit && i + 1 - j >= limit)) {
                        fileSet.push(files.slice(j, i + 1));
                        paramNameSlice = paramName.slice(j, i + 1);
                        if (!paramNameSlice.length) {
                            paramNameSlice = paramName;
                        }
                        paramNameSet.push(paramNameSlice);
                        j = i + 1;
                        batchSize = 0;
                    }
                }
            } else {
                paramNameSet = paramName;
            }
            data.originalFiles = files;
            $.each(fileSet || files, function (index, element) {
                var newData = $.extend({}, data);
                newData.files = fileSet ? element : [element];
                newData.paramName = paramNameSet[index];
                that._initResponseObject(newData);
                that._initProgressObject(newData);
                that._addConvenienceMethods(e, newData);
                result = that._trigger(
                    'add',
                    $.Event('add', {delegatedEvent: e}),
                    newData
                );
                return result;
            });
            return result;
        },

        _replaceFileInput: function (data) {
            var input = data.fileInput,
                inputClone = input.clone(true),
                restoreFocus = input.is(document.activeElement);
            // Add a reference for the new cloned file input to the data argument:
            data.fileInputClone = inputClone;
            $('<form></form>').append(inputClone)[0].reset();
            // Detaching allows to insert the fileInput on another form
            // without loosing the file input value:
            input.after(inputClone).detach();
            // If the fileInput had focus before it was detached,
            // restore focus to the inputClone.
            if (restoreFocus) {
                inputClone.focus();
            }
            // Avoid memory leaks with the detached file input:
            $.cleanData(input.unbind('remove'));
            // Replace the original file input element in the fileInput
            // elements set with the clone, which has been copied including
            // event handlers:
            this.options.fileInput = this.options.fileInput.map(function (i, el) {
                if (el === input[0]) {
                    return inputClone[0];
                }
                return el;
            });
            // If the widget has been initialized on the file input itself,
            // override this.element with the file input clone:
            if (input[0] === this.element[0]) {
                this.element = inputClone;
            }
        },

        _handleFileTreeEntry: function (entry, path) {
            var that = this,
                dfd = $.Deferred(),
                entries = [],
                dirReader,
                errorHandler = function (e) {
                    if (e && !e.entry) {
                        e.entry = entry;
                    }
                    // Since $.when returns immediately if one
                    // Deferred is rejected, we use resolve instead.
                    // This allows valid files and invalid items
                    // to be returned together in one set:
                    dfd.resolve([e]);
                },
                successHandler = function (entries) {
                    that._handleFileTreeEntries(
                        entries,
                        path + entry.name + '/'
                    ).done(function (files) {
                        dfd.resolve(files);
                    }).fail(errorHandler);
                },
                readEntries = function () {
                    dirReader.readEntries(function (results) {
                        if (!results.length) {
                            successHandler(entries);
                        } else {
                            entries = entries.concat(results);
                            readEntries();
                        }
                    }, errorHandler);
                };
            path = path || '';
            if (entry.isFile) {
                if (entry._file) {
                    // Workaround for Chrome bug #149735
                    entry._file.relativePath = path;
                    dfd.resolve(entry._file);
                } else {
                    entry.file(function (file) {
                        file.relativePath = path;
                        dfd.resolve(file);
                    }, errorHandler);
                }
            } else if (entry.isDirectory) {
                dirReader = entry.createReader();
                readEntries();
            } else {
                // Return an empy list for file system items
                // other than files or directories:
                dfd.resolve([]);
            }
            return dfd.promise();
        },

        _handleFileTreeEntries: function (entries, path) {
            var that = this;
            return $.when.apply(
                $,
                $.map(entries, function (entry) {
                    return that._handleFileTreeEntry(entry, path);
                })
            ).then(function () {
                return Array.prototype.concat.apply(
                    [],
                    arguments
                );
            });
        },

        _getDroppedFiles: function (dataTransfer) {
            dataTransfer = dataTransfer || {};
            var items = dataTransfer.items;
            if (items && items.length && (items[0].webkitGetAsEntry ||
                    items[0].getAsEntry)) {
                return this._handleFileTreeEntries(
                    $.map(items, function (item) {
                        var entry;
                        if (item.webkitGetAsEntry) {
                            entry = item.webkitGetAsEntry();
                            if (entry) {
                                // Workaround for Chrome bug #149735:
                                entry._file = item.getAsFile();
                            }
                            return entry;
                        }
                        return item.getAsEntry();
                    })
                );
            }
            return $.Deferred().resolve(
                $.makeArray(dataTransfer.files)
            ).promise();
        },

        _getSingleFileInputFiles: function (fileInput) {
            fileInput = $(fileInput);
            var entries = fileInput.prop('webkitEntries') ||
                    fileInput.prop('entries'),
                files,
                value;
            if (entries && entries.length) {
                return this._handleFileTreeEntries(entries);
            }
            files = $.makeArray(fileInput.prop('files'));
            if (!files.length) {
                value = fileInput.prop('value');
                if (!value) {
                    return $.Deferred().resolve([]).promise();
                }
                // If the files property is not available, the browser does not
                // support the File API and we add a pseudo File object with
                // the input value as name with path information removed:
                files = [{name: value.replace(/^.*\\/, '')}];
            } else if (files[0].name === undefined && files[0].fileName) {
                // File normalization for Safari 4 and Firefox 3:
                $.each(files, function (index, file) {
                    file.name = file.fileName;
                    file.size = file.fileSize;
                });
            }
            return $.Deferred().resolve(files).promise();
        },

        _getFileInputFiles: function (fileInput) {
            if (!(fileInput instanceof $) || fileInput.length === 1) {
                return this._getSingleFileInputFiles(fileInput);
            }
            return $.when.apply(
                $,
                $.map(fileInput, this._getSingleFileInputFiles)
            ).then(function () {
                return Array.prototype.concat.apply(
                    [],
                    arguments
                );
            });
        },

        _onChange: function (e) {
            var that = this,
                data = {
                    fileInput: $(e.target),
                    form: $(e.target.form)
                };
            this._getFileInputFiles(data.fileInput).always(function (files) {
                data.files = files;
                if (that.options.replaceFileInput) {
                    that._replaceFileInput(data);
                }
                if (that._trigger(
                        'change',
                        $.Event('change', {delegatedEvent: e}),
                        data
                    ) !== false) {
                    that._onAdd(e, data);
                }
            });
        },

        _onPaste: function (e) {
            var items = e.originalEvent && e.originalEvent.clipboardData &&
                    e.originalEvent.clipboardData.items,
                data = {files: []};
            if (items && items.length) {
                $.each(items, function (index, item) {
                    var file = item.getAsFile && item.getAsFile();
                    if (file) {
                        data.files.push(file);
                    }
                });
                if (this._trigger(
                        'paste',
                        $.Event('paste', {delegatedEvent: e}),
                        data
                    ) !== false) {
                    this._onAdd(e, data);
                }
            }
        },

        _onDrop: function (e) {
            e.dataTransfer = e.originalEvent && e.originalEvent.dataTransfer;
            var that = this,
                dataTransfer = e.dataTransfer,
                data = {};
            if (dataTransfer && dataTransfer.files && dataTransfer.files.length) {
                e.preventDefault();
                this._getDroppedFiles(dataTransfer).always(function (files) {
                    data.files = files;
                    if (that._trigger(
                            'drop',
                            $.Event('drop', {delegatedEvent: e}),
                            data
                        ) !== false) {
                        that._onAdd(e, data);
                    }
                });
            }
        },

        _onDragOver: getDragHandler('dragover'),

        _onDragEnter: getDragHandler('dragenter'),

        _onDragLeave: getDragHandler('dragleave'),

        _initEventHandlers: function () {
            if (this._isXHRUpload(this.options)) {
                this._on(this.options.dropZone, {
                    dragover: this._onDragOver,
                    drop: this._onDrop,
                    // event.preventDefault() on dragenter is required for IE10+:
                    dragenter: this._onDragEnter,
                    // dragleave is not required, but added for completeness:
                    dragleave: this._onDragLeave
                });
                this._on(this.options.pasteZone, {
                    paste: this._onPaste
                });
            }
            if ($.support.fileInput) {
                this._on(this.options.fileInput, {
                    change: this._onChange
                });
            }
        },

        _destroyEventHandlers: function () {
            this._off(this.options.dropZone, 'dragenter dragleave dragover drop');
            this._off(this.options.pasteZone, 'paste');
            this._off(this.options.fileInput, 'change');
        },

        _destroy: function () {
            this._destroyEventHandlers();
        },

        _setOption: function (key, value) {
            var reinit = $.inArray(key, this._specialOptions) !== -1;
            if (reinit) {
                this._destroyEventHandlers();
            }
            this._super(key, value);
            if (reinit) {
                this._initSpecialOptions();
                this._initEventHandlers();
            }
        },

        _initSpecialOptions: function () {
            var options = this.options;
            if (options.fileInput === undefined) {
                options.fileInput = this.element.is('input[type="file"]') ?
                        this.element : this.element.find('input[type="file"]');
            } else if (!(options.fileInput instanceof $)) {
                options.fileInput = $(options.fileInput);
            }
            if (!(options.dropZone instanceof $)) {
                options.dropZone = $(options.dropZone);
            }
            if (!(options.pasteZone instanceof $)) {
                options.pasteZone = $(options.pasteZone);
            }
        },

        _getRegExp: function (str) {
            var parts = str.split('/'),
                modifiers = parts.pop();
            parts.shift();
            return new RegExp(parts.join('/'), modifiers);
        },

        _isRegExpOption: function (key, value) {
            return key !== 'url' && $.type(value) === 'string' &&
                /^\/.*\/[igm]{0,3}$/.test(value);
        },

        _initDataAttributes: function () {
            var that = this,
                options = this.options,
                data = this.element.data();
            // Initialize options set via HTML5 data-attributes:
            $.each(
                this.element[0].attributes,
                function (index, attr) {
                    var key = attr.name.toLowerCase(),
                        value;
                    if (/^data-/.test(key)) {
                        // Convert hyphen-ated key to camelCase:
                        key = key.slice(5).replace(/-[a-z]/g, function (str) {
                            return str.charAt(1).toUpperCase();
                        });
                        value = data[key];
                        if (that._isRegExpOption(key, value)) {
                            value = that._getRegExp(value);
                        }
                        options[key] = value;
                    }
                }
            );
        },

        _create: function () {
            this._initDataAttributes();
            this._initSpecialOptions();
            this._slots = [];
            this._sequence = this._getXHRPromise(true);
            this._sending = this._active = 0;
            this._initProgressObject(this);
            this._initEventHandlers();
        },

        // This method is exposed to the widget API and allows to query
        // the number of active uploads:
        active: function () {
            return this._active;
        },

        // This method is exposed to the widget API and allows to query
        // the widget upload progress.
        // It returns an object with loaded, total and bitrate properties
        // for the running uploads:
        progress: function () {
            return this._progress;
        },

        // This method is exposed to the widget API and allows adding files
        // using the fileupload API. The data parameter accepts an object which
        // must have a files property and can contain additional options:
        // .fileupload('add', {files: filesList});
        add: function (data) {
            var that = this;
            if (!data || this.options.disabled) {
                return;
            }
            if (data.fileInput && !data.files) {
                this._getFileInputFiles(data.fileInput).always(function (files) {
                    data.files = files;
                    that._onAdd(null, data);
                });
            } else {
                data.files = $.makeArray(data.files);
                this._onAdd(null, data);
            }
        },

        // This method is exposed to the widget API and allows sending files
        // using the fileupload API. The data parameter accepts an object which
        // must have a files or fileInput property and can contain additional options:
        // .fileupload('send', {files: filesList});
        // The method returns a Promise object for the file upload call.
        send: function (data) {
            if (data && !this.options.disabled) {
                if (data.fileInput && !data.files) {
                    var that = this,
                        dfd = $.Deferred(),
                        promise = dfd.promise(),
                        jqXHR,
                        aborted;
                    promise.abort = function () {
                        aborted = true;
                        if (jqXHR) {
                            return jqXHR.abort();
                        }
                        dfd.reject(null, 'abort', 'abort');
                        return promise;
                    };
                    this._getFileInputFiles(data.fileInput).always(
                        function (files) {
                            if (aborted) {
                                return;
                            }
                            if (!files.length) {
                                dfd.reject();
                                return;
                            }
                            data.files = files;
                            jqXHR = that._onSend(null, data);
                            jqXHR.then(
                                function (result, textStatus, jqXHR) {
                                    dfd.resolve(result, textStatus, jqXHR);
                                },
                                function (jqXHR, textStatus, errorThrown) {
                                    dfd.reject(jqXHR, textStatus, errorThrown);
                                }
                            );
                        }
                    );
                    return this._enhancePromise(promise);
                }
                data.files = $.makeArray(data.files);
                if (data.files.length) {
                    return this._onSend(null, data);
                }
            }
            return this._getXHRPromise(false, data && data.context);
        }

    });

}));

/*!
 * Bootstrap Colorpicker v2.5.2
 * https://itsjavi.com/bootstrap-colorpicker/
 *
 * Originally written by (c) 2012 Stefan Petre
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 */

(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define(["jquery"], function(jq) {
      return (factory(jq));
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require("jquery"));
  } else if (jQuery && !jQuery.fn.colorpicker) {
    factory(jQuery);
  }
}(this, function($) {
  'use strict';
  /**
   * Color manipulation helper class
   *
   * @param {Object|String} [val]
   * @param {Object} [predefinedColors]
   * @param {String|null} [fallbackColor]
   * @param {String|null} [fallbackFormat]
   * @param {Boolean} [hexNumberSignPrefix]
   * @constructor
   */
  var Color = function(
    val, predefinedColors, fallbackColor, fallbackFormat, hexNumberSignPrefix) {
    this.fallbackValue = fallbackColor ?
      (
        fallbackColor && (typeof fallbackColor.h !== 'undefined') ?
        fallbackColor :
        this.value = {
          h: 0,
          s: 0,
          b: 0,
          a: 1
        }
      ) :
      null;

    this.fallbackFormat = fallbackFormat ? fallbackFormat : 'rgba';

    this.hexNumberSignPrefix = hexNumberSignPrefix === true;

    this.value = this.fallbackValue;

    this.origFormat = null; // original string format

    this.predefinedColors = predefinedColors ? predefinedColors : {};

    // We don't want to share aliases across instances so we extend new object
    this.colors = $.extend({}, Color.webColors, this.predefinedColors);

    if (val) {
      if (typeof val.h !== 'undefined') {
        this.value = val;
      } else {
        this.setColor(String(val));
      }
    }

    if (!this.value) {
      // Initial value is always black if no arguments are passed or val is empty
      this.value = {
        h: 0,
        s: 0,
        b: 0,
        a: 1
      };
    }
  };

  Color.webColors = { // 140 predefined colors from the HTML Colors spec
    "aliceblue": "f0f8ff",
    "antiquewhite": "faebd7",
    "aqua": "00ffff",
    "aquamarine": "7fffd4",
    "azure": "f0ffff",
    "beige": "f5f5dc",
    "bisque": "ffe4c4",
    "black": "000000",
    "blanchedalmond": "ffebcd",
    "blue": "0000ff",
    "blueviolet": "8a2be2",
    "brown": "a52a2a",
    "burlywood": "deb887",
    "cadetblue": "5f9ea0",
    "chartreuse": "7fff00",
    "chocolate": "d2691e",
    "coral": "ff7f50",
    "cornflowerblue": "6495ed",
    "cornsilk": "fff8dc",
    "crimson": "dc143c",
    "cyan": "00ffff",
    "darkblue": "00008b",
    "darkcyan": "008b8b",
    "darkgoldenrod": "b8860b",
    "darkgray": "a9a9a9",
    "darkgreen": "006400",
    "darkkhaki": "bdb76b",
    "darkmagenta": "8b008b",
    "darkolivegreen": "556b2f",
    "darkorange": "ff8c00",
    "darkorchid": "9932cc",
    "darkred": "8b0000",
    "darksalmon": "e9967a",
    "darkseagreen": "8fbc8f",
    "darkslateblue": "483d8b",
    "darkslategray": "2f4f4f",
    "darkturquoise": "00ced1",
    "darkviolet": "9400d3",
    "deeppink": "ff1493",
    "deepskyblue": "00bfff",
    "dimgray": "696969",
    "dodgerblue": "1e90ff",
    "firebrick": "b22222",
    "floralwhite": "fffaf0",
    "forestgreen": "228b22",
    "fuchsia": "ff00ff",
    "gainsboro": "dcdcdc",
    "ghostwhite": "f8f8ff",
    "gold": "ffd700",
    "goldenrod": "daa520",
    "gray": "808080",
    "green": "008000",
    "greenyellow": "adff2f",
    "honeydew": "f0fff0",
    "hotpink": "ff69b4",
    "indianred": "cd5c5c",
    "indigo": "4b0082",
    "ivory": "fffff0",
    "khaki": "f0e68c",
    "lavender": "e6e6fa",
    "lavenderblush": "fff0f5",
    "lawngreen": "7cfc00",
    "lemonchiffon": "fffacd",
    "lightblue": "add8e6",
    "lightcoral": "f08080",
    "lightcyan": "e0ffff",
    "lightgoldenrodyellow": "fafad2",
    "lightgrey": "d3d3d3",
    "lightgreen": "90ee90",
    "lightpink": "ffb6c1",
    "lightsalmon": "ffa07a",
    "lightseagreen": "20b2aa",
    "lightskyblue": "87cefa",
    "lightslategray": "778899",
    "lightsteelblue": "b0c4de",
    "lightyellow": "ffffe0",
    "lime": "00ff00",
    "limegreen": "32cd32",
    "linen": "faf0e6",
    "magenta": "ff00ff",
    "maroon": "800000",
    "mediumaquamarine": "66cdaa",
    "mediumblue": "0000cd",
    "mediumorchid": "ba55d3",
    "mediumpurple": "9370d8",
    "mediumseagreen": "3cb371",
    "mediumslateblue": "7b68ee",
    "mediumspringgreen": "00fa9a",
    "mediumturquoise": "48d1cc",
    "mediumvioletred": "c71585",
    "midnightblue": "191970",
    "mintcream": "f5fffa",
    "mistyrose": "ffe4e1",
    "moccasin": "ffe4b5",
    "navajowhite": "ffdead",
    "navy": "000080",
    "oldlace": "fdf5e6",
    "olive": "808000",
    "olivedrab": "6b8e23",
    "orange": "ffa500",
    "orangered": "ff4500",
    "orchid": "da70d6",
    "palegoldenrod": "eee8aa",
    "palegreen": "98fb98",
    "paleturquoise": "afeeee",
    "palevioletred": "d87093",
    "papayawhip": "ffefd5",
    "peachpuff": "ffdab9",
    "peru": "cd853f",
    "pink": "ffc0cb",
    "plum": "dda0dd",
    "powderblue": "b0e0e6",
    "purple": "800080",
    "red": "ff0000",
    "rosybrown": "bc8f8f",
    "royalblue": "4169e1",
    "saddlebrown": "8b4513",
    "salmon": "fa8072",
    "sandybrown": "f4a460",
    "seagreen": "2e8b57",
    "seashell": "fff5ee",
    "sienna": "a0522d",
    "silver": "c0c0c0",
    "skyblue": "87ceeb",
    "slateblue": "6a5acd",
    "slategray": "708090",
    "snow": "fffafa",
    "springgreen": "00ff7f",
    "steelblue": "4682b4",
    "tan": "d2b48c",
    "teal": "008080",
    "thistle": "d8bfd8",
    "tomato": "ff6347",
    "turquoise": "40e0d0",
    "violet": "ee82ee",
    "wheat": "f5deb3",
    "white": "ffffff",
    "whitesmoke": "f5f5f5",
    "yellow": "ffff00",
    "yellowgreen": "9acd32",
    "transparent": "transparent"
  };

  Color.prototype = {
    constructor: Color,
    colors: {}, // merged web and predefined colors
    predefinedColors: {},
    /**
     * @return {Object}
     */
    getValue: function() {
      return this.value;
    },
    /**
     * @param {Object} val
     */
    setValue: function(val) {
      this.value = val;
    },
    _sanitizeNumber: function(val) {
      if (typeof val === 'number') {
        return val;
      }
      if (isNaN(val) || (val === null) || (val === '') || (val === undefined)) {
        return 1;
      }
      if (val === '') {
        return 0;
      }
      if (typeof val.toLowerCase !== 'undefined') {
        if (val.match(/^\./)) {
          val = "0" + val;
        }
        return Math.ceil(parseFloat(val) * 100) / 100;
      }
      return 1;
    },
    isTransparent: function(strVal) {
      if (!strVal || !(typeof strVal === 'string' || strVal instanceof String)) {
        return false;
      }
      strVal = strVal.toLowerCase().trim();
      return (strVal === 'transparent') || (strVal.match(/#?00000000/)) || (strVal.match(/(rgba|hsla)\(0,0,0,0?\.?0\)/));
    },
    rgbaIsTransparent: function(rgba) {
      return ((rgba.r === 0) && (rgba.g === 0) && (rgba.b === 0) && (rgba.a === 0));
    },
    // parse a string to HSB
    /**
     * @protected
     * @param {String} strVal
     * @returns {boolean} Returns true if it could be parsed, false otherwise
     */
    setColor: function(strVal) {
      strVal = strVal.toLowerCase().trim();
      if (strVal) {
        if (this.isTransparent(strVal)) {
          this.value = {
            h: 0,
            s: 0,
            b: 0,
            a: 0
          };
          return true;
        } else {
          var parsedColor = this.parse(strVal);
          if (parsedColor) {
            this.value = this.value = {
              h: parsedColor.h,
              s: parsedColor.s,
              b: parsedColor.b,
              a: parsedColor.a
            };
            if (!this.origFormat) {
              this.origFormat = parsedColor.format;
            }
          } else if (this.fallbackValue) {
            // if parser fails, defaults to fallbackValue if defined, otherwise the value won't be changed
            this.value = this.fallbackValue;
          }
        }
      }
      return false;
    },
    setHue: function(h) {
      this.value.h = 1 - h;
    },
    setSaturation: function(s) {
      this.value.s = s;
    },
    setBrightness: function(b) {
      this.value.b = 1 - b;
    },
    setAlpha: function(a) {
      this.value.a = Math.round((parseInt((1 - a) * 100, 10) / 100) * 100) / 100;
    },
    toRGB: function(h, s, b, a) {
      if (arguments.length === 0) {
        h = this.value.h;
        s = this.value.s;
        b = this.value.b;
        a = this.value.a;
      }

      h *= 360;
      var R, G, B, X, C;
      h = (h % 360) / 60;
      C = b * s;
      X = C * (1 - Math.abs(h % 2 - 1));
      R = G = B = b - C;

      h = ~~h;
      R += [C, X, 0, 0, X, C][h];
      G += [X, C, C, X, 0, 0][h];
      B += [0, 0, X, C, C, X][h];

      return {
        r: Math.round(R * 255),
        g: Math.round(G * 255),
        b: Math.round(B * 255),
        a: a
      };
    },
    toHex: function(ignoreFormat, h, s, b, a) {
      if (arguments.length <= 1) {
        h = this.value.h;
        s = this.value.s;
        b = this.value.b;
        a = this.value.a;
      }

      var prefix = '#';
      var rgb = this.toRGB(h, s, b, a);

      if (this.rgbaIsTransparent(rgb)) {
        return 'transparent';
      }

      if (!ignoreFormat) {
        prefix = (this.hexNumberSignPrefix ? '#' : '');
      }

      var hexStr = prefix + (
          (1 << 24) +
          (parseInt(rgb.r) << 16) +
          (parseInt(rgb.g) << 8) +
          parseInt(rgb.b))
        .toString(16)
        .slice(1);

      return hexStr;
    },
    toHSL: function(h, s, b, a) {
      if (arguments.length === 0) {
        h = this.value.h;
        s = this.value.s;
        b = this.value.b;
        a = this.value.a;
      }

      var H = h,
        L = (2 - s) * b,
        S = s * b;
      if (L > 0 && L <= 1) {
        S /= L;
      } else {
        S /= 2 - L;
      }
      L /= 2;
      if (S > 1) {
        S = 1;
      }
      return {
        h: isNaN(H) ? 0 : H,
        s: isNaN(S) ? 0 : S,
        l: isNaN(L) ? 0 : L,
        a: isNaN(a) ? 0 : a
      };
    },
    toAlias: function(r, g, b, a) {
      var c, rgb = (arguments.length === 0) ? this.toHex(true) : this.toHex(true, r, g, b, a);

      // support predef. colors in non-hex format too, as defined in the alias itself
      var original = this.origFormat === 'alias' ? rgb : this.toString(false, this.origFormat);

      for (var alias in this.colors) {
        c = this.colors[alias].toLowerCase().trim();
        if ((c === rgb) || (c === original)) {
          return alias;
        }
      }
      return false;
    },
    RGBtoHSB: function(r, g, b, a) {
      r /= 255;
      g /= 255;
      b /= 255;

      var H, S, V, C;
      V = Math.max(r, g, b);
      C = V - Math.min(r, g, b);
      H = (C === 0 ? null :
        V === r ? (g - b) / C :
        V === g ? (b - r) / C + 2 :
        (r - g) / C + 4
      );
      H = ((H + 360) % 6) * 60 / 360;
      S = C === 0 ? 0 : C / V;
      return {
        h: this._sanitizeNumber(H),
        s: S,
        b: V,
        a: this._sanitizeNumber(a)
      };
    },
    HueToRGB: function(p, q, h) {
      if (h < 0) {
        h += 1;
      } else if (h > 1) {
        h -= 1;
      }
      if ((h * 6) < 1) {
        return p + (q - p) * h * 6;
      } else if ((h * 2) < 1) {
        return q;
      } else if ((h * 3) < 2) {
        return p + (q - p) * ((2 / 3) - h) * 6;
      } else {
        return p;
      }
    },
    HSLtoRGB: function(h, s, l, a) {
      if (s < 0) {
        s = 0;
      }
      var q;
      if (l <= 0.5) {
        q = l * (1 + s);
      } else {
        q = l + s - (l * s);
      }

      var p = 2 * l - q;

      var tr = h + (1 / 3);
      var tg = h;
      var tb = h - (1 / 3);

      var r = Math.round(this.HueToRGB(p, q, tr) * 255);
      var g = Math.round(this.HueToRGB(p, q, tg) * 255);
      var b = Math.round(this.HueToRGB(p, q, tb) * 255);
      return [r, g, b, this._sanitizeNumber(a)];
    },
    /**
     * @param {String} strVal
     * @returns {Object} Object containing h,s,b,a,format properties or FALSE if failed to parse
     */
    parse: function(strVal) {
      if (arguments.length === 0) {
        return false;
      }

      var that = this,
        result = false,
        isAlias = (typeof this.colors[strVal] !== 'undefined'),
        values, format;

      if (isAlias) {
        strVal = this.colors[strVal].toLowerCase().trim();
      }

      $.each(this.stringParsers, function(i, parser) {
        var match = parser.re.exec(strVal);
        values = match && parser.parse.apply(that, [match]);
        if (values) {
          result = {};
          format = (isAlias ? 'alias' : (parser.format ? parser.format : that.getValidFallbackFormat()));
          if (format.match(/hsla?/)) {
            result = that.RGBtoHSB.apply(that, that.HSLtoRGB.apply(that, values));
          } else {
            result = that.RGBtoHSB.apply(that, values);
          }
          if (result instanceof Object) {
            result.format = format;
          }
          return false; // stop iterating
        }
        return true;
      });
      return result;
    },
    getValidFallbackFormat: function() {
      var formats = [
        'rgba', 'rgb', 'hex', 'hsla', 'hsl'
      ];
      if (this.origFormat && (formats.indexOf(this.origFormat) !== -1)) {
        return this.origFormat;
      }
      if (this.fallbackFormat && (formats.indexOf(this.fallbackFormat) !== -1)) {
        return this.fallbackFormat;
      }

      return 'rgba'; // By default, return a format that will not lose the alpha info
    },
    /**
     *
     * @param {string} [format] (default: rgba)
     * @param {boolean} [translateAlias] Return real color for pre-defined (non-standard) aliases (default: false)
     * @param {boolean} [forceRawValue] Forces hashtag prefix when getting hex color (default: false)
     * @returns {String}
     */
    toString: function(forceRawValue, format, translateAlias) {
      format = format || this.origFormat || this.fallbackFormat;
      translateAlias = translateAlias || false;

      var c = false;

      switch (format) {
        case 'rgb':
          {
            c = this.toRGB();
            if (this.rgbaIsTransparent(c)) {
              return 'transparent';
            }
            return 'rgb(' + c.r + ',' + c.g + ',' + c.b + ')';
          }
          break;
        case 'rgba':
          {
            c = this.toRGB();
            return 'rgba(' + c.r + ',' + c.g + ',' + c.b + ',' + c.a + ')';
          }
          break;
        case 'hsl':
          {
            c = this.toHSL();
            return 'hsl(' + Math.round(c.h * 360) + ',' + Math.round(c.s * 100) + '%,' + Math.round(c.l * 100) + '%)';
          }
          break;
        case 'hsla':
          {
            c = this.toHSL();
            return 'hsla(' + Math.round(c.h * 360) + ',' + Math.round(c.s * 100) + '%,' + Math.round(c.l * 100) + '%,' + c.a + ')';
          }
          break;
        case 'hex':
          {
            return this.toHex(forceRawValue);
          }
          break;
        case 'alias':
          {
            c = this.toAlias();

            if (c === false) {
              return this.toString(forceRawValue, this.getValidFallbackFormat());
            }

            if (translateAlias && !(c in Color.webColors) && (c in this.predefinedColors)) {
              return this.predefinedColors[c];
            }

            return c;
          }
        default:
          {
            return c;
          }
          break;
      }
    },
    // a set of RE's that can match strings and generate color tuples.
    // from John Resig color plugin
    // https://github.com/jquery/jquery-color/
    stringParsers: [{
      re: /rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*?\)/,
      format: 'rgb',
      parse: function(execResult) {
        return [
          execResult[1],
          execResult[2],
          execResult[3],
          1
        ];
      }
    }, {
      re: /rgb\(\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*?\)/,
      format: 'rgb',
      parse: function(execResult) {
        return [
          2.55 * execResult[1],
          2.55 * execResult[2],
          2.55 * execResult[3],
          1
        ];
      }
    }, {
      re: /rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d*(?:\.\d+)?)\s*)?\)/,
      format: 'rgba',
      parse: function(execResult) {
        return [
          execResult[1],
          execResult[2],
          execResult[3],
          execResult[4]
        ];
      }
    }, {
      re: /rgba\(\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*(?:,\s*(\d*(?:\.\d+)?)\s*)?\)/,
      format: 'rgba',
      parse: function(execResult) {
        return [
          2.55 * execResult[1],
          2.55 * execResult[2],
          2.55 * execResult[3],
          execResult[4]
        ];
      }
    }, {
      re: /hsl\(\s*(\d*(?:\.\d+)?)\s*,\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*?\)/,
      format: 'hsl',
      parse: function(execResult) {
        return [
          execResult[1] / 360,
          execResult[2] / 100,
          execResult[3] / 100,
          execResult[4]
        ];
      }
    }, {
      re: /hsla\(\s*(\d*(?:\.\d+)?)\s*,\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*(?:,\s*(\d*(?:\.\d+)?)\s*)?\)/,
      format: 'hsla',
      parse: function(execResult) {
        return [
          execResult[1] / 360,
          execResult[2] / 100,
          execResult[3] / 100,
          execResult[4]
        ];
      }
    }, {
      re: /#?([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/,
      format: 'hex',
      parse: function(execResult) {
        return [
          parseInt(execResult[1], 16),
          parseInt(execResult[2], 16),
          parseInt(execResult[3], 16),
          1
        ];
      }
    }, {
      re: /#?([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/,
      format: 'hex',
      parse: function(execResult) {
        return [
          parseInt(execResult[1] + execResult[1], 16),
          parseInt(execResult[2] + execResult[2], 16),
          parseInt(execResult[3] + execResult[3], 16),
          1
        ];
      }
    }],
    colorNameToHex: function(name) {
      if (typeof this.colors[name.toLowerCase()] !== 'undefined') {
        return this.colors[name.toLowerCase()];
      }
      return false;
    }
  };

  /*
   * Default plugin options
   */
  var defaults = {
    horizontal: false, // horizontal mode layout ?
    inline: false, //forces to show the colorpicker as an inline element
    color: false, //forces a color
    format: false, //forces a format
    input: 'input', // children input selector
    container: false, // container selector
    component: '.add-on, .input-group-addon', // children component selector
    fallbackColor: false, // fallback color value. null = keeps current color.
    fallbackFormat: 'hex', // fallback color format
    hexNumberSignPrefix: true, // put a '#' (number sign) before hex strings
    sliders: {
      saturation: {
        maxLeft: 100,
        maxTop: 100,
        callLeft: 'setSaturation',
        callTop: 'setBrightness'
      },
      hue: {
        maxLeft: 0,
        maxTop: 100,
        callLeft: false,
        callTop: 'setHue'
      },
      alpha: {
        maxLeft: 0,
        maxTop: 100,
        callLeft: false,
        callTop: 'setAlpha'
      }
    },
    slidersHorz: {
      saturation: {
        maxLeft: 100,
        maxTop: 100,
        callLeft: 'setSaturation',
        callTop: 'setBrightness'
      },
      hue: {
        maxLeft: 100,
        maxTop: 0,
        callLeft: 'setHue',
        callTop: false
      },
      alpha: {
        maxLeft: 100,
        maxTop: 0,
        callLeft: 'setAlpha',
        callTop: false
      }
    },
    template: '<div class="colorpicker dropdown-menu">' +
      '<div class="colorpicker-saturation"><i><b></b></i></div>' +
      '<div class="colorpicker-hue"><i></i></div>' +
      '<div class="colorpicker-alpha"><i></i></div>' +
      '<div class="colorpicker-color"><div /></div>' +
      '<div class="colorpicker-selectors"></div>' +
      '</div>',
    align: 'right',
    customClass: null, // custom class added to the colorpicker element
    colorSelectors: null // custom color aliases
  };

  /**
   * Colorpicker component class
   *
   * @param {Object|String} element
   * @param {Object} options
   * @constructor
   */
  var Colorpicker = function(element, options) {
    this.element = $(element).addClass('colorpicker-element');
    this.options = $.extend(true, {}, defaults, this.element.data(), options);
    this.component = this.options.component;
    this.component = (this.component !== false) ? this.element.find(this.component) : false;
    if (this.component && (this.component.length === 0)) {
      this.component = false;
    }
    this.container = (this.options.container === true) ? this.element : this.options.container;
    this.container = (this.container !== false) ? $(this.container) : false;

    // Is the element an input? Should we search inside for any input?
    this.input = this.element.is('input') ? this.element : (this.options.input ?
      this.element.find(this.options.input) : false);
    if (this.input && (this.input.length === 0)) {
      this.input = false;
    }
    // Set HSB color
    this.color = this.createColor(this.options.color !== false ? this.options.color : this.getValue());

    this.format = this.options.format !== false ? this.options.format : this.color.origFormat;

    if (this.options.color !== false) {
      this.updateInput(this.color);
      this.updateData(this.color);
    }

    this.disabled = false;

    // Setup picker
    var $picker = this.picker = $(this.options.template);
    if (this.options.customClass) {
      $picker.addClass(this.options.customClass);
    }
    if (this.options.inline) {
      $picker.addClass('colorpicker-inline colorpicker-visible');
    } else {
      $picker.addClass('colorpicker-hidden');
    }
    if (this.options.horizontal) {
      $picker.addClass('colorpicker-horizontal');
    }
    if (
      (['rgba', 'hsla', 'alias'].indexOf(this.format) !== -1) ||
      this.options.format === false ||
      this.getValue() === 'transparent'
    ) {
      $picker.addClass('colorpicker-with-alpha');
    }
    if (this.options.align === 'right') {
      $picker.addClass('colorpicker-right');
    }
    if (this.options.inline === true) {
      $picker.addClass('colorpicker-no-arrow');
    }
    if (this.options.colorSelectors) {
      var colorpicker = this,
        selectorsContainer = colorpicker.picker.find('.colorpicker-selectors');

      if (selectorsContainer.length > 0) {
        $.each(this.options.colorSelectors, function(name, color) {
          var $btn = $('<i />')
            .addClass('colorpicker-selectors-color')
            .css('background-color', color)
            .data('class', name).data('alias', name);

          $btn.on('mousedown.colorpicker touchstart.colorpicker', function(event) {
            event.preventDefault();
            colorpicker.setValue(
              colorpicker.format === 'alias' ? $(this).data('alias') : $(this).css('background-color')
            );
          });
          selectorsContainer.append($btn);
        });
        selectorsContainer.show().addClass('colorpicker-visible');
      }
    }

    // Prevent closing the colorpicker when clicking on itself
    $picker.on('mousedown.colorpicker touchstart.colorpicker', $.proxy(function(e) {
      if (e.target === e.currentTarget) {
        e.preventDefault();
      }
    }, this));

    // Bind click/tap events on the sliders
    $picker.find('.colorpicker-saturation, .colorpicker-hue, .colorpicker-alpha')
      .on('mousedown.colorpicker touchstart.colorpicker', $.proxy(this.mousedown, this));

    $picker.appendTo(this.container ? this.container : $('body'));

    // Bind other events
    if (this.input !== false) {
      this.input.on({
        'keyup.colorpicker': $.proxy(this.keyup, this)
      });
      this.input.on({
        'change.colorpicker': $.proxy(this.change, this)
      });
      if (this.component === false) {
        this.element.on({
          'focus.colorpicker': $.proxy(this.show, this)
        });
      }
      if (this.options.inline === false) {
        this.element.on({
          'focusout.colorpicker': $.proxy(this.hide, this)
        });
      }
    }

    if (this.component !== false) {
      this.component.on({
        'click.colorpicker': $.proxy(this.show, this)
      });
    }

    if ((this.input === false) && (this.component === false)) {
      this.element.on({
        'click.colorpicker': $.proxy(this.show, this)
      });
    }

    // for HTML5 input[type='color']
    if ((this.input !== false) && (this.component !== false) && (this.input.attr('type') === 'color')) {

      this.input.on({
        'click.colorpicker': $.proxy(this.show, this),
        'focus.colorpicker': $.proxy(this.show, this)
      });
    }
    this.update();

    $($.proxy(function() {
      this.element.trigger('create');
    }, this));
  };

  Colorpicker.Color = Color;

  Colorpicker.prototype = {
    constructor: Colorpicker,
    destroy: function() {
      this.picker.remove();
      this.element.removeData('colorpicker', 'color').off('.colorpicker');
      if (this.input !== false) {
        this.input.off('.colorpicker');
      }
      if (this.component !== false) {
        this.component.off('.colorpicker');
      }
      this.element.removeClass('colorpicker-element');
      this.element.trigger({
        type: 'destroy'
      });
    },
    reposition: function() {
      if (this.options.inline !== false || this.options.container) {
        return false;
      }
      var type = this.container && this.container[0] !== window.document.body ? 'position' : 'offset';
      var element = this.component || this.element;
      var offset = element[type]();
      if (this.options.align === 'right') {
        offset.left -= this.picker.outerWidth() - element.outerWidth();
      }
      this.picker.css({
        top: offset.top + element.outerHeight(),
        left: offset.left
      });
    },
    show: function(e) {
      if (this.isDisabled()) {
        // Don't show the widget if it's disabled (the input)
        return;
      }
      this.picker.addClass('colorpicker-visible').removeClass('colorpicker-hidden');
      this.reposition();
      $(window).on('resize.colorpicker', $.proxy(this.reposition, this));
      if (e && (!this.hasInput() || this.input.attr('type') === 'color')) {
        if (e.stopPropagation && e.preventDefault) {
          e.stopPropagation();
          e.preventDefault();
        }
      }
      if ((this.component || !this.input) && (this.options.inline === false)) {
        $(window.document).on({
          'mousedown.colorpicker': $.proxy(this.hide, this)
        });
      }
      this.element.trigger({
        type: 'showPicker',
        color: this.color
      });
    },
    hide: function(e) {
      if ((typeof e !== 'undefined') && e.target) {
        // Prevent hide if triggered by an event and an element inside the colorpicker has been clicked/touched
        if (
          $(e.currentTarget).parents('.colorpicker').length > 0 ||
          $(e.target).parents('.colorpicker').length > 0
        ) {
          return false;
        }
      }
      this.picker.addClass('colorpicker-hidden').removeClass('colorpicker-visible');
      $(window).off('resize.colorpicker', this.reposition);
      $(window.document).off({
        'mousedown.colorpicker': this.hide
      });
      this.update();
      this.element.trigger({
        type: 'hidePicker',
        color: this.color
      });
    },
    updateData: function(val) {
      val = val || this.color.toString(false, this.format);
      this.element.data('color', val);
      return val;
    },
    updateInput: function(val) {
      val = val || this.color.toString(false, this.format);
      if (this.input !== false) {
        this.input.prop('value', val);
        this.input.trigger('change');
      }
      return val;
    },
    updatePicker: function(val) {
      if (typeof val !== 'undefined') {
        this.color = this.createColor(val);
      }
      var sl = (this.options.horizontal === false) ? this.options.sliders : this.options.slidersHorz;
      var icns = this.picker.find('i');
      if (icns.length === 0) {
        return;
      }
      if (this.options.horizontal === false) {
        sl = this.options.sliders;
        icns.eq(1).css('top', sl.hue.maxTop * (1 - this.color.value.h)).end()
          .eq(2).css('top', sl.alpha.maxTop * (1 - this.color.value.a));
      } else {
        sl = this.options.slidersHorz;
        icns.eq(1).css('left', sl.hue.maxLeft * (1 - this.color.value.h)).end()
          .eq(2).css('left', sl.alpha.maxLeft * (1 - this.color.value.a));
      }
      icns.eq(0).css({
        'top': sl.saturation.maxTop - this.color.value.b * sl.saturation.maxTop,
        'left': this.color.value.s * sl.saturation.maxLeft
      });

      this.picker.find('.colorpicker-saturation')
        .css('backgroundColor', this.color.toHex(true, this.color.value.h, 1, 1, 1));

      this.picker.find('.colorpicker-alpha')
        .css('backgroundColor', this.color.toHex(true));

      this.picker.find('.colorpicker-color, .colorpicker-color div')
        .css('backgroundColor', this.color.toString(true, this.format));

      return val;
    },
    updateComponent: function(val) {
      var color;

      if (typeof val !== 'undefined') {
        color = this.createColor(val);
      } else {
        color = this.color;
      }

      if (this.component !== false) {
        var icn = this.component.find('i').eq(0);
        if (icn.length > 0) {
          icn.css({
            'backgroundColor': color.toString(true, this.format)
          });
        } else {
          this.component.css({
            'backgroundColor': color.toString(true, this.format)
          });
        }
      }

      return color.toString(false, this.format);
    },
    update: function(force) {
      var val;
      if ((this.getValue(false) !== false) || (force === true)) {
        // Update input/data only if the current value is not empty
        val = this.updateComponent();
        this.updateInput(val);
        this.updateData(val);
        this.updatePicker(); // only update picker if value is not empty
      }
      return val;

    },
    setValue: function(val) { // set color manually
      this.color = this.createColor(val);
      this.update(true);
      this.element.trigger({
        type: 'changeColor',
        color: this.color,
        value: val
      });
    },
    /**
     * Creates a new color using the instance options
     * @protected
     * @param {String} val
     * @returns {Color}
     */
    createColor: function(val) {
      return new Color(
        val ? val : null,
        this.options.colorSelectors,
        this.options.fallbackColor ? this.options.fallbackColor : this.color,
        this.options.fallbackFormat,
        this.options.hexNumberSignPrefix
      );
    },
    getValue: function(defaultValue) {
      defaultValue = (typeof defaultValue === 'undefined') ? this.options.fallbackColor : defaultValue;
      var val;
      if (this.hasInput()) {
        val = this.input.val();
      } else {
        val = this.element.data('color');
      }
      if ((val === undefined) || (val === '') || (val === null)) {
        // if not defined or empty, return default
        val = defaultValue;
      }
      return val;
    },
    hasInput: function() {
      return (this.input !== false);
    },
    isDisabled: function() {
      return this.disabled;
    },
    disable: function() {
      if (this.hasInput()) {
        this.input.prop('disabled', true);
      }
      this.disabled = true;
      this.element.trigger({
        type: 'disable',
        color: this.color,
        value: this.getValue()
      });
      return true;
    },
    enable: function() {
      if (this.hasInput()) {
        this.input.prop('disabled', false);
      }
      this.disabled = false;
      this.element.trigger({
        type: 'enable',
        color: this.color,
        value: this.getValue()
      });
      return true;
    },
    currentSlider: null,
    mousePointer: {
      left: 0,
      top: 0
    },
    mousedown: function(e) {
      if (!e.pageX && !e.pageY && e.originalEvent && e.originalEvent.touches) {
        e.pageX = e.originalEvent.touches[0].pageX;
        e.pageY = e.originalEvent.touches[0].pageY;
      }
      e.stopPropagation();
      e.preventDefault();

      var target = $(e.target);

      //detect the slider and set the limits and callbacks
      var zone = target.closest('div');
      var sl = this.options.horizontal ? this.options.slidersHorz : this.options.sliders;
      if (!zone.is('.colorpicker')) {
        if (zone.is('.colorpicker-saturation')) {
          this.currentSlider = $.extend({}, sl.saturation);
        } else if (zone.is('.colorpicker-hue')) {
          this.currentSlider = $.extend({}, sl.hue);
        } else if (zone.is('.colorpicker-alpha')) {
          this.currentSlider = $.extend({}, sl.alpha);
        } else {
          return false;
        }
        var offset = zone.offset();
        //reference to guide's style
        this.currentSlider.guide = zone.find('i')[0].style;
        this.currentSlider.left = e.pageX - offset.left;
        this.currentSlider.top = e.pageY - offset.top;
        this.mousePointer = {
          left: e.pageX,
          top: e.pageY
        };
        //trigger mousemove to move the guide to the current position
        $(window.document).on({
          'mousemove.colorpicker': $.proxy(this.mousemove, this),
          'touchmove.colorpicker': $.proxy(this.mousemove, this),
          'mouseup.colorpicker': $.proxy(this.mouseup, this),
          'touchend.colorpicker': $.proxy(this.mouseup, this)
        }).trigger('mousemove');
      }
      return false;
    },
    mousemove: function(e) {
      if (!e.pageX && !e.pageY && e.originalEvent && e.originalEvent.touches) {
        e.pageX = e.originalEvent.touches[0].pageX;
        e.pageY = e.originalEvent.touches[0].pageY;
      }
      e.stopPropagation();
      e.preventDefault();
      var left = Math.max(
        0,
        Math.min(
          this.currentSlider.maxLeft,
          this.currentSlider.left + ((e.pageX || this.mousePointer.left) - this.mousePointer.left)
        )
      );
      var top = Math.max(
        0,
        Math.min(
          this.currentSlider.maxTop,
          this.currentSlider.top + ((e.pageY || this.mousePointer.top) - this.mousePointer.top)
        )
      );
      this.currentSlider.guide.left = left + 'px';
      this.currentSlider.guide.top = top + 'px';
      if (this.currentSlider.callLeft) {
        this.color[this.currentSlider.callLeft].call(this.color, left / this.currentSlider.maxLeft);
      }
      if (this.currentSlider.callTop) {
        this.color[this.currentSlider.callTop].call(this.color, top / this.currentSlider.maxTop);
      }
      // Change format dynamically
      // Only occurs if user choose the dynamic format by
      // setting option format to false
      if (
        this.options.format === false &&
        (this.currentSlider.callTop === 'setAlpha' ||
          this.currentSlider.callLeft === 'setAlpha')
      ) {

        // Converting from hex / rgb to rgba
        if (this.color.value.a !== 1) {
          this.format = 'rgba';
          this.color.origFormat = 'rgba';
        }

        // Converting from rgba to hex
        else {
          this.format = 'hex';
          this.color.origFormat = 'hex';
        }
      }
      this.update(true);

      this.element.trigger({
        type: 'changeColor',
        color: this.color
      });
      return false;
    },
    mouseup: function(e) {
      e.stopPropagation();
      e.preventDefault();
      $(window.document).off({
        'mousemove.colorpicker': this.mousemove,
        'touchmove.colorpicker': this.mousemove,
        'mouseup.colorpicker': this.mouseup,
        'touchend.colorpicker': this.mouseup
      });
      return false;
    },
    change: function(e) {
      this.keyup(e);
    },
    keyup: function(e) {
      if ((e.keyCode === 38)) {
        if (this.color.value.a < 1) {
          this.color.value.a = Math.round((this.color.value.a + 0.01) * 100) / 100;
        }
        this.update(true);
      } else if ((e.keyCode === 40)) {
        if (this.color.value.a > 0) {
          this.color.value.a = Math.round((this.color.value.a - 0.01) * 100) / 100;
        }
        this.update(true);
      } else {
        this.color = this.createColor(this.input.val());
        // Change format dynamically
        // Only occurs if user choose the dynamic format by
        // setting option format to false
        if (this.color.origFormat && this.options.format === false) {
          this.format = this.color.origFormat;
        }
        if (this.getValue(false) !== false) {
          this.updateData();
          this.updateComponent();
          this.updatePicker();
        }
      }
      this.element.trigger({
        type: 'changeColor',
        color: this.color,
        value: this.input.val()
      });
    }
  };

  $.colorpicker = Colorpicker;

  $.fn.colorpicker = function(option) {
    var apiArgs = Array.prototype.slice.call(arguments, 1),
      isSingleElement = (this.length === 1),
      returnValue = null;

    var $jq = this.each(function() {
      var $this = $(this),
        inst = $this.data('colorpicker'),
        options = ((typeof option === 'object') ? option : {});

      if (!inst) {
        inst = new Colorpicker(this, options);
        $this.data('colorpicker', inst);
      }

      if (typeof option === 'string') {
        if ($.isFunction(inst[option])) {
          returnValue = inst[option].apply(inst, apiArgs);
        } else { // its a property ?
          if (apiArgs.length) {
            // set property
            inst[option] = apiArgs[0];
          }
          returnValue = inst[option];
        }
      } else {
        returnValue = $this;
      }
    });
    return isSingleElement ? returnValue : $jq;
  };

  $.fn.colorpicker.constructor = Colorpicker;

}));

/*!
 * Datepicker for Bootstrap v1.8.0 (https://github.com/uxsolutions/bootstrap-datepicker)
 *
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

(function(factory){
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        factory(require('jquery'));
    } else {
        factory(jQuery);
    }
}(function($, undefined){
	function UTCDate(){
		return new Date(Date.UTC.apply(Date, arguments));
	}
	function UTCToday(){
		var today = new Date();
		return UTCDate(today.getFullYear(), today.getMonth(), today.getDate());
	}
	function isUTCEquals(date1, date2) {
		return (
			date1.getUTCFullYear() === date2.getUTCFullYear() &&
			date1.getUTCMonth() === date2.getUTCMonth() &&
			date1.getUTCDate() === date2.getUTCDate()
		);
	}
	function alias(method, deprecationMsg){
		return function(){
			if (deprecationMsg !== undefined) {
				$.fn.datepicker.deprecated(deprecationMsg);
			}

			return this[method].apply(this, arguments);
		};
	}
	function isValidDate(d) {
		return d && !isNaN(d.getTime());
	}

	var DateArray = (function(){
		var extras = {
			get: function(i){
				return this.slice(i)[0];
			},
			contains: function(d){
				// Array.indexOf is not cross-browser;
				// $.inArray doesn't work with Dates
				var val = d && d.valueOf();
				for (var i=0, l=this.length; i < l; i++)
          // Use date arithmetic to allow dates with different times to match
          if (0 <= this[i].valueOf() - val && this[i].valueOf() - val < 1000*60*60*24)
						return i;
				return -1;
			},
			remove: function(i){
				this.splice(i,1);
			},
			replace: function(new_array){
				if (!new_array)
					return;
				if (!$.isArray(new_array))
					new_array = [new_array];
				this.clear();
				this.push.apply(this, new_array);
			},
			clear: function(){
				this.length = 0;
			},
			copy: function(){
				var a = new DateArray();
				a.replace(this);
				return a;
			}
		};

		return function(){
			var a = [];
			a.push.apply(a, arguments);
			$.extend(a, extras);
			return a;
		};
	})();


	// Picker object

	var Datepicker = function(element, options){
		$.data(element, 'datepicker', this);
		this._process_options(options);

		this.dates = new DateArray();
		this.viewDate = this.o.defaultViewDate;
		this.focusDate = null;

		this.element = $(element);
		this.isInput = this.element.is('input');
		this.inputField = this.isInput ? this.element : this.element.find('input');
		this.component = this.element.hasClass('date') ? this.element.find('.add-on, .input-group-addon, .btn') : false;
		if (this.component && this.component.length === 0)
			this.component = false;
		this.isInline = !this.component && this.element.is('div');

		this.picker = $(DPGlobal.template);

		// Checking templates and inserting
		if (this._check_template(this.o.templates.leftArrow)) {
			this.picker.find('.prev').html(this.o.templates.leftArrow);
		}

		if (this._check_template(this.o.templates.rightArrow)) {
			this.picker.find('.next').html(this.o.templates.rightArrow);
		}

		this._buildEvents();
		this._attachEvents();

		if (this.isInline){
			this.picker.addClass('datepicker-inline').appendTo(this.element);
		}
		else {
			this.picker.addClass('datepicker-dropdown dropdown-menu');
		}

		if (this.o.rtl){
			this.picker.addClass('datepicker-rtl');
		}

		if (this.o.calendarWeeks) {
			this.picker.find('.datepicker-days .datepicker-switch, thead .datepicker-title, tfoot .today, tfoot .clear')
				.attr('colspan', function(i, val){
					return Number(val) + 1;
				});
		}

		this._process_options({
			startDate: this._o.startDate,
			endDate: this._o.endDate,
			daysOfWeekDisabled: this.o.daysOfWeekDisabled,
			daysOfWeekHighlighted: this.o.daysOfWeekHighlighted,
			datesDisabled: this.o.datesDisabled
		});

		this._allow_update = false;
		this.setViewMode(this.o.startView);
		this._allow_update = true;

		this.fillDow();
		this.fillMonths();

		this.update();

		if (this.isInline){
			this.show();
		}
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		_resolveViewName: function(view){
			$.each(DPGlobal.viewModes, function(i, viewMode){
				if (view === i || $.inArray(view, viewMode.names) !== -1){
					view = i;
					return false;
				}
			});

			return view;
		},

		_resolveDaysOfWeek: function(daysOfWeek){
			if (!$.isArray(daysOfWeek))
				daysOfWeek = daysOfWeek.split(/[,\s]*/);
			return $.map(daysOfWeek, Number);
		},

		_check_template: function(tmp){
			try {
				// If empty
				if (tmp === undefined || tmp === "") {
					return false;
				}
				// If no html, everything ok
				if ((tmp.match(/[<>]/g) || []).length <= 0) {
					return true;
				}
				// Checking if html is fine
				var jDom = $(tmp);
				return jDom.length > 0;
			}
			catch (ex) {
				return false;
			}
		},

		_process_options: function(opts){
			// Store raw options for reference
			this._o = $.extend({}, this._o, opts);
			// Processed options
			var o = this.o = $.extend({}, this._o);

			// Check if "de-DE" style date is available, if not language should
			// fallback to 2 letter code eg "de"
			var lang = o.language;
			if (!dates[lang]){
				lang = lang.split('-')[0];
				if (!dates[lang])
					lang = defaults.language;
			}
			o.language = lang;

			// Retrieve view index from any aliases
			o.startView = this._resolveViewName(o.startView);
			o.minViewMode = this._resolveViewName(o.minViewMode);
			o.maxViewMode = this._resolveViewName(o.maxViewMode);

			// Check view is between min and max
			o.startView = Math.max(this.o.minViewMode, Math.min(this.o.maxViewMode, o.startView));

			// true, false, or Number > 0
			if (o.multidate !== true){
				o.multidate = Number(o.multidate) || false;
				if (o.multidate !== false)
					o.multidate = Math.max(0, o.multidate);
			}
			o.multidateSeparator = String(o.multidateSeparator);

			o.weekStart %= 7;
			o.weekEnd = (o.weekStart + 6) % 7;

			var format = DPGlobal.parseFormat(o.format);
			if (o.startDate !== -Infinity){
				if (!!o.startDate){
					if (o.startDate instanceof Date)
						o.startDate = this._local_to_utc(this._zero_time(o.startDate));
					else
						o.startDate = DPGlobal.parseDate(o.startDate, format, o.language, o.assumeNearbyYear);
				}
				else {
					o.startDate = -Infinity;
				}
			}
			if (o.endDate !== Infinity){
				if (!!o.endDate){
					if (o.endDate instanceof Date)
						o.endDate = this._local_to_utc(this._zero_time(o.endDate));
					else
						o.endDate = DPGlobal.parseDate(o.endDate, format, o.language, o.assumeNearbyYear);
				}
				else {
					o.endDate = Infinity;
				}
			}

			o.daysOfWeekDisabled = this._resolveDaysOfWeek(o.daysOfWeekDisabled||[]);
			o.daysOfWeekHighlighted = this._resolveDaysOfWeek(o.daysOfWeekHighlighted||[]);

			o.datesDisabled = o.datesDisabled||[];
			if (!$.isArray(o.datesDisabled)) {
				o.datesDisabled = o.datesDisabled.split(',');
			}
			o.datesDisabled = $.map(o.datesDisabled, function(d){
				return DPGlobal.parseDate(d, format, o.language, o.assumeNearbyYear);
			});

			var plc = String(o.orientation).toLowerCase().split(/\s+/g),
				_plc = o.orientation.toLowerCase();
			plc = $.grep(plc, function(word){
				return /^auto|left|right|top|bottom$/.test(word);
			});
			o.orientation = {x: 'auto', y: 'auto'};
			if (!_plc || _plc === 'auto')
				; // no action
			else if (plc.length === 1){
				switch (plc[0]){
					case 'top':
					case 'bottom':
						o.orientation.y = plc[0];
						break;
					case 'left':
					case 'right':
						o.orientation.x = plc[0];
						break;
				}
			}
			else {
				_plc = $.grep(plc, function(word){
					return /^left|right$/.test(word);
				});
				o.orientation.x = _plc[0] || 'auto';

				_plc = $.grep(plc, function(word){
					return /^top|bottom$/.test(word);
				});
				o.orientation.y = _plc[0] || 'auto';
			}
			if (o.defaultViewDate instanceof Date || typeof o.defaultViewDate === 'string') {
				o.defaultViewDate = DPGlobal.parseDate(o.defaultViewDate, format, o.language, o.assumeNearbyYear);
			} else if (o.defaultViewDate) {
				var year = o.defaultViewDate.year || new Date().getFullYear();
				var month = o.defaultViewDate.month || 0;
				var day = o.defaultViewDate.day || 1;
				o.defaultViewDate = UTCDate(year, month, day);
			} else {
				o.defaultViewDate = UTCToday();
			}
		},
		_events: [],
		_secondaryEvents: [],
		_applyEvents: function(evs){
			for (var i=0, el, ch, ev; i < evs.length; i++){
				el = evs[i][0];
				if (evs[i].length === 2){
					ch = undefined;
					ev = evs[i][1];
				} else if (evs[i].length === 3){
					ch = evs[i][1];
					ev = evs[i][2];
				}
				el.on(ev, ch);
			}
		},
		_unapplyEvents: function(evs){
			for (var i=0, el, ev, ch; i < evs.length; i++){
				el = evs[i][0];
				if (evs[i].length === 2){
					ch = undefined;
					ev = evs[i][1];
				} else if (evs[i].length === 3){
					ch = evs[i][1];
					ev = evs[i][2];
				}
				el.off(ev, ch);
			}
		},
		_buildEvents: function(){
            var events = {
                keyup: $.proxy(function(e){
                    if ($.inArray(e.keyCode, [27, 37, 39, 38, 40, 32, 13, 9]) === -1)
                        this.update();
                }, this),
                keydown: $.proxy(this.keydown, this),
                paste: $.proxy(this.paste, this)
            };

            if (this.o.showOnFocus === true) {
                events.focus = $.proxy(this.show, this);
            }

            if (this.isInput) { // single input
                this._events = [
                    [this.element, events]
                ];
            }
            // component: input + button
            else if (this.component && this.inputField.length) {
                this._events = [
                    // For components that are not readonly, allow keyboard nav
                    [this.inputField, events],
                    [this.component, {
                        click: $.proxy(this.show, this)
                    }]
                ];
            }
			else {
				this._events = [
					[this.element, {
						click: $.proxy(this.show, this),
						keydown: $.proxy(this.keydown, this)
					}]
				];
			}
			this._events.push(
				// Component: listen for blur on element descendants
				[this.element, '*', {
					blur: $.proxy(function(e){
						this._focused_from = e.target;
					}, this)
				}],
				// Input: listen for blur on element
				[this.element, {
					blur: $.proxy(function(e){
						this._focused_from = e.target;
					}, this)
				}]
			);

			if (this.o.immediateUpdates) {
				// Trigger input updates immediately on changed year/month
				this._events.push([this.element, {
					'changeYear changeMonth': $.proxy(function(e){
						this.update(e.date);
					}, this)
				}]);
			}

			this._secondaryEvents = [
				[this.picker, {
					click: $.proxy(this.click, this)
				}],
				[this.picker, '.prev, .next', {
					click: $.proxy(this.navArrowsClick, this)
				}],
				[this.picker, '.day:not(.disabled)', {
					click: $.proxy(this.dayCellClick, this)
				}],
				[$(window), {
					resize: $.proxy(this.place, this)
				}],
				[$(document), {
					'mousedown touchstart': $.proxy(function(e){
						// Clicked outside the datepicker, hide it
						if (!(
							this.element.is(e.target) ||
							this.element.find(e.target).length ||
							this.picker.is(e.target) ||
							this.picker.find(e.target).length ||
							this.isInline
						)){
							this.hide();
						}
					}, this)
				}]
			];
		},
		_attachEvents: function(){
			this._detachEvents();
			this._applyEvents(this._events);
		},
		_detachEvents: function(){
			this._unapplyEvents(this._events);
		},
		_attachSecondaryEvents: function(){
			this._detachSecondaryEvents();
			this._applyEvents(this._secondaryEvents);
		},
		_detachSecondaryEvents: function(){
			this._unapplyEvents(this._secondaryEvents);
		},
		_trigger: function(event, altdate){
			var date = altdate || this.dates.get(-1),
				local_date = this._utc_to_local(date);

			this.element.trigger({
				type: event,
				date: local_date,
				viewMode: this.viewMode,
				dates: $.map(this.dates, this._utc_to_local),
				format: $.proxy(function(ix, format){
					if (arguments.length === 0){
						ix = this.dates.length - 1;
						format = this.o.format;
					} else if (typeof ix === 'string'){
						format = ix;
						ix = this.dates.length - 1;
					}
					format = format || this.o.format;
					var date = this.dates.get(ix);
					return DPGlobal.formatDate(date, format, this.o.language);
				}, this)
			});
		},

		show: function(){
			if (this.inputField.prop('disabled') || (this.inputField.prop('readonly') && this.o.enableOnReadonly === false))
				return;
			if (!this.isInline)
				this.picker.appendTo(this.o.container);
			this.place();
			this.picker.show();
			this._attachSecondaryEvents();
			this._trigger('show');
			if ((window.navigator.msMaxTouchPoints || 'ontouchstart' in document) && this.o.disableTouchKeyboard) {
				$(this.element).blur();
			}
			return this;
		},

		hide: function(){
			if (this.isInline || !this.picker.is(':visible'))
				return this;
			this.focusDate = null;
			this.picker.hide().detach();
			this._detachSecondaryEvents();
			this.setViewMode(this.o.startView);

			if (this.o.forceParse && this.inputField.val())
				this.setValue();
			this._trigger('hide');
			return this;
		},

		destroy: function(){
			this.hide();
			this._detachEvents();
			this._detachSecondaryEvents();
			this.picker.remove();
			delete this.element.data().datepicker;
			if (!this.isInput){
				delete this.element.data().date;
			}
			return this;
		},

		paste: function(e){
			var dateString;
			if (e.originalEvent.clipboardData && e.originalEvent.clipboardData.types
				&& $.inArray('text/plain', e.originalEvent.clipboardData.types) !== -1) {
				dateString = e.originalEvent.clipboardData.getData('text/plain');
			} else if (window.clipboardData) {
				dateString = window.clipboardData.getData('Text');
			} else {
				return;
			}
			this.setDate(dateString);
			this.update();
			e.preventDefault();
		},

		_utc_to_local: function(utc){
			if (!utc) {
				return utc;
			}

			var local = new Date(utc.getTime() + (utc.getTimezoneOffset() * 60000));

			if (local.getTimezoneOffset() !== utc.getTimezoneOffset()) {
				local = new Date(utc.getTime() + (local.getTimezoneOffset() * 60000));
			}

			return local;
		},
		_local_to_utc: function(local){
			return local && new Date(local.getTime() - (local.getTimezoneOffset()*60000));
		},
		_zero_time: function(local){
			return local && new Date(local.getFullYear(), local.getMonth(), local.getDate());
		},
		_zero_utc_time: function(utc){
			return utc && UTCDate(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate());
		},

		getDates: function(){
			return $.map(this.dates, this._utc_to_local);
		},

		getUTCDates: function(){
			return $.map(this.dates, function(d){
				return new Date(d);
			});
		},

		getDate: function(){
			return this._utc_to_local(this.getUTCDate());
		},

		getUTCDate: function(){
			var selected_date = this.dates.get(-1);
			if (selected_date !== undefined) {
				return new Date(selected_date);
			} else {
				return null;
			}
		},

		clearDates: function(){
			this.inputField.val('');
			this.update();
			this._trigger('changeDate');

			if (this.o.autoclose) {
				this.hide();
			}
		},

		setDates: function(){
			var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
			this.update.apply(this, args);
			this._trigger('changeDate');
			this.setValue();
			return this;
		},

		setUTCDates: function(){
			var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
			this.setDates.apply(this, $.map(args, this._utc_to_local));
			return this;
		},

		setDate: alias('setDates'),
		setUTCDate: alias('setUTCDates'),
		remove: alias('destroy', 'Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead'),

		setValue: function(){
			var formatted = this.getFormattedDate();
			this.inputField.val(formatted);
			return this;
		},

		getFormattedDate: function(format){
			if (format === undefined)
				format = this.o.format;

			var lang = this.o.language;
			return $.map(this.dates, function(d){
				return DPGlobal.formatDate(d, format, lang);
			}).join(this.o.multidateSeparator);
		},

		getStartDate: function(){
			return this.o.startDate;
		},

		setStartDate: function(startDate){
			this._process_options({startDate: startDate});
			this.update();
			this.updateNavArrows();
			return this;
		},

		getEndDate: function(){
			return this.o.endDate;
		},

		setEndDate: function(endDate){
			this._process_options({endDate: endDate});
			this.update();
			this.updateNavArrows();
			return this;
		},

		setDaysOfWeekDisabled: function(daysOfWeekDisabled){
			this._process_options({daysOfWeekDisabled: daysOfWeekDisabled});
			this.update();
			return this;
		},

		setDaysOfWeekHighlighted: function(daysOfWeekHighlighted){
			this._process_options({daysOfWeekHighlighted: daysOfWeekHighlighted});
			this.update();
			return this;
		},

		setDatesDisabled: function(datesDisabled){
			this._process_options({datesDisabled: datesDisabled});
			this.update();
			return this;
		},

		place: function(){
			if (this.isInline)
				return this;
			var calendarWidth = this.picker.outerWidth(),
				calendarHeight = this.picker.outerHeight(),
				visualPadding = 10,
				container = $(this.o.container),
				windowWidth = container.width(),
				scrollTop = this.o.container === 'body' ? $(document).scrollTop() : container.scrollTop(),
				appendOffset = container.offset();

			var parentsZindex = [0];
			this.element.parents().each(function(){
				var itemZIndex = $(this).css('z-index');
				if (itemZIndex !== 'auto' && Number(itemZIndex) !== 0) parentsZindex.push(Number(itemZIndex));
			});
			var zIndex = Math.max.apply(Math, parentsZindex) + this.o.zIndexOffset;
			var offset = this.component ? this.component.parent().offset() : this.element.offset();
			var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(false);
			var width = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);
			var left = offset.left - appendOffset.left;
			var top = offset.top - appendOffset.top;

			if (this.o.container !== 'body') {
				top += scrollTop;
			}

			this.picker.removeClass(
				'datepicker-orient-top datepicker-orient-bottom '+
				'datepicker-orient-right datepicker-orient-left'
			);

			if (this.o.orientation.x !== 'auto'){
				this.picker.addClass('datepicker-orient-' + this.o.orientation.x);
				if (this.o.orientation.x === 'right')
					left -= calendarWidth - width;
			}
			// auto x orientation is best-placement: if it crosses a window
			// edge, fudge it sideways
			else {
				if (offset.left < 0) {
					// component is outside the window on the left side. Move it into visible range
					this.picker.addClass('datepicker-orient-left');
					left -= offset.left - visualPadding;
				} else if (left + calendarWidth > windowWidth) {
					// the calendar passes the widow right edge. Align it to component right side
					this.picker.addClass('datepicker-orient-right');
					left += width - calendarWidth;
				} else {
					if (this.o.rtl) {
						// Default to right
						this.picker.addClass('datepicker-orient-right');
					} else {
						// Default to left
						this.picker.addClass('datepicker-orient-left');
					}
				}
			}

			// auto y orientation is best-situation: top or bottom, no fudging,
			// decision based on which shows more of the calendar
			var yorient = this.o.orientation.y,
				top_overflow;
			if (yorient === 'auto'){
				top_overflow = -scrollTop + top - calendarHeight;
				yorient = top_overflow < 0 ? 'bottom' : 'top';
			}

			this.picker.addClass('datepicker-orient-' + yorient);
			if (yorient === 'top')
				top -= calendarHeight + parseInt(this.picker.css('padding-top'));
			else
				top += height;

			if (this.o.rtl) {
				var right = windowWidth - (left + width);
				this.picker.css({
					top: top,
					right: right,
					zIndex: zIndex
				});
			} else {
				this.picker.css({
					top: top,
					left: left,
					zIndex: zIndex
				});
			}
			return this;
		},

		_allow_update: true,
		update: function(){
			if (!this._allow_update)
				return this;

			var oldDates = this.dates.copy(),
				dates = [],
				fromArgs = false;
			if (arguments.length){
				$.each(arguments, $.proxy(function(i, date){
					if (date instanceof Date)
						date = this._local_to_utc(date);
					dates.push(date);
				}, this));
				fromArgs = true;
			} else {
				dates = this.isInput
						? this.element.val()
						: this.element.data('date') || this.inputField.val();
				if (dates && this.o.multidate)
					dates = dates.split(this.o.multidateSeparator);
				else
					dates = [dates];
				delete this.element.data().date;
			}

			dates = $.map(dates, $.proxy(function(date){
				return DPGlobal.parseDate(date, this.o.format, this.o.language, this.o.assumeNearbyYear);
			}, this));
			dates = $.grep(dates, $.proxy(function(date){
				return (
					!this.dateWithinRange(date) ||
					!date
				);
			}, this), true);
			this.dates.replace(dates);

			if (this.o.updateViewDate) {
				if (this.dates.length)
					this.viewDate = new Date(this.dates.get(-1));
				else if (this.viewDate < this.o.startDate)
					this.viewDate = new Date(this.o.startDate);
				else if (this.viewDate > this.o.endDate)
					this.viewDate = new Date(this.o.endDate);
				else
					this.viewDate = this.o.defaultViewDate;
			}

			if (fromArgs){
				// setting date by clicking
				this.setValue();
				this.element.change();
			}
			else if (this.dates.length){
				// setting date by typing
				if (String(oldDates) !== String(this.dates) && fromArgs) {
					this._trigger('changeDate');
					this.element.change();
				}
			}
			if (!this.dates.length && oldDates.length) {
				this._trigger('clearDate');
				this.element.change();
			}

			this.fill();
			return this;
		},

		fillDow: function(){
      if (this.o.showWeekDays) {
			var dowCnt = this.o.weekStart,
				html = '<tr>';
			if (this.o.calendarWeeks){
				html += '<th class="cw">&#160;</th>';
			}
			while (dowCnt < this.o.weekStart + 7){
				html += '<th class="dow';
        if ($.inArray(dowCnt, this.o.daysOfWeekDisabled) !== -1)
          html += ' disabled';
        html += '">'+dates[this.o.language].daysMin[(dowCnt++)%7]+'</th>';
			}
			html += '</tr>';
			this.picker.find('.datepicker-days thead').append(html);
      }
		},

		fillMonths: function(){
      var localDate = this._utc_to_local(this.viewDate);
			var html = '';
			var focused;
			for (var i = 0; i < 12; i++){
				focused = localDate && localDate.getMonth() === i ? ' focused' : '';
				html += '<span class="month' + focused + '">' + dates[this.o.language].monthsShort[i] + '</span>';
			}
			this.picker.find('.datepicker-months td').html(html);
		},

		setRange: function(range){
			if (!range || !range.length)
				delete this.range;
			else
				this.range = $.map(range, function(d){
					return d.valueOf();
				});
			this.fill();
		},

		getClassNames: function(date){
			var cls = [],
				year = this.viewDate.getUTCFullYear(),
				month = this.viewDate.getUTCMonth(),
				today = UTCToday();
			if (date.getUTCFullYear() < year || (date.getUTCFullYear() === year && date.getUTCMonth() < month)){
				cls.push('old');
			} else if (date.getUTCFullYear() > year || (date.getUTCFullYear() === year && date.getUTCMonth() > month)){
				cls.push('new');
			}
			if (this.focusDate && date.valueOf() === this.focusDate.valueOf())
				cls.push('focused');
			// Compare internal UTC date with UTC today, not local today
			if (this.o.todayHighlight && isUTCEquals(date, today)) {
				cls.push('today');
			}
			if (this.dates.contains(date) !== -1)
				cls.push('active');
			if (!this.dateWithinRange(date)){
				cls.push('disabled');
			}
			if (this.dateIsDisabled(date)){
				cls.push('disabled', 'disabled-date');
			}
			if ($.inArray(date.getUTCDay(), this.o.daysOfWeekHighlighted) !== -1){
				cls.push('highlighted');
			}

			if (this.range){
				if (date > this.range[0] && date < this.range[this.range.length-1]){
					cls.push('range');
				}
				if ($.inArray(date.valueOf(), this.range) !== -1){
					cls.push('selected');
				}
				if (date.valueOf() === this.range[0]){
          cls.push('range-start');
        }
        if (date.valueOf() === this.range[this.range.length-1]){
          cls.push('range-end');
        }
			}
			return cls;
		},

		_fill_yearsView: function(selector, cssClass, factor, year, startYear, endYear, beforeFn){
			var html = '';
			var step = factor / 10;
			var view = this.picker.find(selector);
			var startVal = Math.floor(year / factor) * factor;
			var endVal = startVal + step * 9;
			var focusedVal = Math.floor(this.viewDate.getFullYear() / step) * step;
			var selected = $.map(this.dates, function(d){
				return Math.floor(d.getUTCFullYear() / step) * step;
			});

			var classes, tooltip, before;
			for (var currVal = startVal - step; currVal <= endVal + step; currVal += step) {
				classes = [cssClass];
				tooltip = null;

				if (currVal === startVal - step) {
					classes.push('old');
				} else if (currVal === endVal + step) {
					classes.push('new');
				}
				if ($.inArray(currVal, selected) !== -1) {
					classes.push('active');
				}
				if (currVal < startYear || currVal > endYear) {
					classes.push('disabled');
				}
				if (currVal === focusedVal) {
				  classes.push('focused');
        }

				if (beforeFn !== $.noop) {
					before = beforeFn(new Date(currVal, 0, 1));
					if (before === undefined) {
						before = {};
					} else if (typeof before === 'boolean') {
						before = {enabled: before};
					} else if (typeof before === 'string') {
						before = {classes: before};
					}
					if (before.enabled === false) {
						classes.push('disabled');
					}
					if (before.classes) {
						classes = classes.concat(before.classes.split(/\s+/));
					}
					if (before.tooltip) {
						tooltip = before.tooltip;
					}
				}

				html += '<span class="' + classes.join(' ') + '"' + (tooltip ? ' title="' + tooltip + '"' : '') + '>' + currVal + '</span>';
			}

			view.find('.datepicker-switch').text(startVal + '-' + endVal);
			view.find('td').html(html);
		},

		fill: function(){
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
				endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
				endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
				todaytxt = dates[this.o.language].today || dates['en'].today || '',
				cleartxt = dates[this.o.language].clear || dates['en'].clear || '',
				titleFormat = dates[this.o.language].titleFormat || dates['en'].titleFormat,
				tooltip,
				before;
			if (isNaN(year) || isNaN(month))
				return;
			this.picker.find('.datepicker-days .datepicker-switch')
						.text(DPGlobal.formatDate(d, titleFormat, this.o.language));
			this.picker.find('tfoot .today')
						.text(todaytxt)
						.css('display', this.o.todayBtn === true || this.o.todayBtn === 'linked' ? 'table-cell' : 'none');
			this.picker.find('tfoot .clear')
						.text(cleartxt)
						.css('display', this.o.clearBtn === true ? 'table-cell' : 'none');
			this.picker.find('thead .datepicker-title')
						.text(this.o.title)
						.css('display', typeof this.o.title === 'string' && this.o.title !== '' ? 'table-cell' : 'none');
			this.updateNavArrows();
			this.fillMonths();
			var prevMonth = UTCDate(year, month, 0),
				day = prevMonth.getUTCDate();
			prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7)%7);
			var nextMonth = new Date(prevMonth);
			if (prevMonth.getUTCFullYear() < 100){
        nextMonth.setUTCFullYear(prevMonth.getUTCFullYear());
      }
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var weekDay, clsName;
			while (prevMonth.valueOf() < nextMonth){
				weekDay = prevMonth.getUTCDay();
				if (weekDay === this.o.weekStart){
					html.push('<tr>');
					if (this.o.calendarWeeks){
						// ISO 8601: First week contains first thursday.
						// ISO also states week starts on Monday, but we can be more abstract here.
						var
							// Start of current week: based on weekstart/current date
							ws = new Date(+prevMonth + (this.o.weekStart - weekDay - 7) % 7 * 864e5),
							// Thursday of this week
							th = new Date(Number(ws) + (7 + 4 - ws.getUTCDay()) % 7 * 864e5),
							// First Thursday of year, year from thursday
							yth = new Date(Number(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay()) % 7 * 864e5),
							// Calendar week: ms between thursdays, div ms per day, div 7 days
							calWeek = (th - yth) / 864e5 / 7 + 1;
						html.push('<td class="cw">'+ calWeek +'</td>');
					}
				}
				clsName = this.getClassNames(prevMonth);
				clsName.push('day');

				var content = prevMonth.getUTCDate();

				if (this.o.beforeShowDay !== $.noop){
					before = this.o.beforeShowDay(this._utc_to_local(prevMonth));
					if (before === undefined)
						before = {};
					else if (typeof before === 'boolean')
						before = {enabled: before};
					else if (typeof before === 'string')
						before = {classes: before};
					if (before.enabled === false)
						clsName.push('disabled');
					if (before.classes)
						clsName = clsName.concat(before.classes.split(/\s+/));
					if (before.tooltip)
						tooltip = before.tooltip;
					if (before.content)
						content = before.content;
				}

				//Check if uniqueSort exists (supported by jquery >=1.12 and >=2.2)
				//Fallback to unique function for older jquery versions
				if ($.isFunction($.uniqueSort)) {
					clsName = $.uniqueSort(clsName);
				} else {
					clsName = $.unique(clsName);
				}

				html.push('<td class="'+clsName.join(' ')+'"' + (tooltip ? ' title="'+tooltip+'"' : '') + ' data-date="' + prevMonth.getTime().toString() + '">' + content + '</td>');
				tooltip = null;
				if (weekDay === this.o.weekEnd){
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate() + 1);
			}
			this.picker.find('.datepicker-days tbody').html(html.join(''));

			var monthsTitle = dates[this.o.language].monthsTitle || dates['en'].monthsTitle || 'Months';
			var months = this.picker.find('.datepicker-months')
						.find('.datepicker-switch')
							.text(this.o.maxViewMode < 2 ? monthsTitle : year)
							.end()
						.find('tbody span').removeClass('active');

			$.each(this.dates, function(i, d){
				if (d.getUTCFullYear() === year)
					months.eq(d.getUTCMonth()).addClass('active');
			});

			if (year < startYear || year > endYear){
				months.addClass('disabled');
			}
			if (year === startYear){
				months.slice(0, startMonth).addClass('disabled');
			}
			if (year === endYear){
				months.slice(endMonth+1).addClass('disabled');
			}

			if (this.o.beforeShowMonth !== $.noop){
				var that = this;
				$.each(months, function(i, month){
          var moDate = new Date(year, i, 1);
          var before = that.o.beforeShowMonth(moDate);
					if (before === undefined)
						before = {};
					else if (typeof before === 'boolean')
						before = {enabled: before};
					else if (typeof before === 'string')
						before = {classes: before};
					if (before.enabled === false && !$(month).hasClass('disabled'))
					    $(month).addClass('disabled');
					if (before.classes)
					    $(month).addClass(before.classes);
					if (before.tooltip)
					    $(month).prop('title', before.tooltip);
				});
			}

			// Generating decade/years picker
			this._fill_yearsView(
				'.datepicker-years',
				'year',
				10,
				year,
				startYear,
				endYear,
				this.o.beforeShowYear
			);

			// Generating century/decades picker
			this._fill_yearsView(
				'.datepicker-decades',
				'decade',
				100,
				year,
				startYear,
				endYear,
				this.o.beforeShowDecade
			);

			// Generating millennium/centuries picker
			this._fill_yearsView(
				'.datepicker-centuries',
				'century',
				1000,
				year,
				startYear,
				endYear,
				this.o.beforeShowCentury
			);
		},

		updateNavArrows: function(){
			if (!this._allow_update)
				return;

			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
				endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
				endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
				prevIsDisabled,
				nextIsDisabled,
				factor = 1;
			switch (this.viewMode){
				case 4:
					factor *= 10;
					/* falls through */
				case 3:
					factor *= 10;
					/* falls through */
				case 2:
					factor *= 10;
					/* falls through */
				case 1:
					prevIsDisabled = Math.floor(year / factor) * factor < startYear;
					nextIsDisabled = Math.floor(year / factor) * factor + factor > endYear;
					break;
				case 0:
					prevIsDisabled = year <= startYear && month < startMonth;
					nextIsDisabled = year >= endYear && month > endMonth;
					break;
			}

			this.picker.find('.prev').toggleClass('disabled', prevIsDisabled);
			this.picker.find('.next').toggleClass('disabled', nextIsDisabled);
		},

		click: function(e){
			e.preventDefault();
			e.stopPropagation();

			var target, dir, day, year, month;
			target = $(e.target);

			// Clicked on the switch
			if (target.hasClass('datepicker-switch') && this.viewMode !== this.o.maxViewMode){
				this.setViewMode(this.viewMode + 1);
			}

			// Clicked on today button
			if (target.hasClass('today') && !target.hasClass('day')){
				this.setViewMode(0);
				this._setDate(UTCToday(), this.o.todayBtn === 'linked' ? null : 'view');
			}

			// Clicked on clear button
			if (target.hasClass('clear')){
				this.clearDates();
			}

			if (!target.hasClass('disabled')){
				// Clicked on a month, year, decade, century
				if (target.hasClass('month')
						|| target.hasClass('year')
						|| target.hasClass('decade')
						|| target.hasClass('century')) {
					this.viewDate.setUTCDate(1);

					day = 1;
					if (this.viewMode === 1){
						month = target.parent().find('span').index(target);
						year = this.viewDate.getUTCFullYear();
						this.viewDate.setUTCMonth(month);
					} else {
						month = 0;
						year = Number(target.text());
						this.viewDate.setUTCFullYear(year);
					}

					this._trigger(DPGlobal.viewModes[this.viewMode - 1].e, this.viewDate);

					if (this.viewMode === this.o.minViewMode){
						this._setDate(UTCDate(year, month, day));
					} else {
						this.setViewMode(this.viewMode - 1);
						this.fill();
					}
				}
			}

			if (this.picker.is(':visible') && this._focused_from){
				this._focused_from.focus();
			}
			delete this._focused_from;
		},

		dayCellClick: function(e){
			var $target = $(e.currentTarget);
			var timestamp = $target.data('date');
			var date = new Date(timestamp);

			if (this.o.updateViewDate) {
				if (date.getUTCFullYear() !== this.viewDate.getUTCFullYear()) {
					this._trigger('changeYear', this.viewDate);
				}

				if (date.getUTCMonth() !== this.viewDate.getUTCMonth()) {
					this._trigger('changeMonth', this.viewDate);
				}
			}
			this._setDate(date);
		},

		// Clicked on prev or next
		navArrowsClick: function(e){
			var $target = $(e.currentTarget);
			var dir = $target.hasClass('prev') ? -1 : 1;
			if (this.viewMode !== 0){
				dir *= DPGlobal.viewModes[this.viewMode].navStep * 12;
			}
			this.viewDate = this.moveMonth(this.viewDate, dir);
			this._trigger(DPGlobal.viewModes[this.viewMode].e, this.viewDate);
			this.fill();
		},

		_toggle_multidate: function(date){
			var ix = this.dates.contains(date);
			if (!date){
				this.dates.clear();
			}

			if (ix !== -1){
				if (this.o.multidate === true || this.o.multidate > 1 || this.o.toggleActive){
					this.dates.remove(ix);
				}
			} else if (this.o.multidate === false) {
				this.dates.clear();
				this.dates.push(date);
			}
			else {
				this.dates.push(date);
			}

			if (typeof this.o.multidate === 'number')
				while (this.dates.length > this.o.multidate)
					this.dates.remove(0);
		},

		_setDate: function(date, which){
			if (!which || which === 'date')
				this._toggle_multidate(date && new Date(date));
			if ((!which && this.o.updateViewDate) || which === 'view')
				this.viewDate = date && new Date(date);

			this.fill();
			this.setValue();
			if (!which || which !== 'view') {
				this._trigger('changeDate');
			}
			this.inputField.trigger('change');
			if (this.o.autoclose && (!which || which === 'date')){
				this.hide();
			}
		},

		moveDay: function(date, dir){
			var newDate = new Date(date);
			newDate.setUTCDate(date.getUTCDate() + dir);

			return newDate;
		},

		moveWeek: function(date, dir){
			return this.moveDay(date, dir * 7);
		},

		moveMonth: function(date, dir){
			if (!isValidDate(date))
				return this.o.defaultViewDate;
			if (!dir)
				return date;
			var new_date = new Date(date.valueOf()),
				day = new_date.getUTCDate(),
				month = new_date.getUTCMonth(),
				mag = Math.abs(dir),
				new_month, test;
			dir = dir > 0 ? 1 : -1;
			if (mag === 1){
				test = dir === -1
					// If going back one month, make sure month is not current month
					// (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
					? function(){
						return new_date.getUTCMonth() === month;
					}
					// If going forward one month, make sure month is as expected
					// (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
					: function(){
						return new_date.getUTCMonth() !== new_month;
					};
				new_month = month + dir;
				new_date.setUTCMonth(new_month);
				// Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
				new_month = (new_month + 12) % 12;
			}
			else {
				// For magnitudes >1, move one month at a time...
				for (var i=0; i < mag; i++)
					// ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
					new_date = this.moveMonth(new_date, dir);
				// ...then reset the day, keeping it in the new month
				new_month = new_date.getUTCMonth();
				new_date.setUTCDate(day);
				test = function(){
					return new_month !== new_date.getUTCMonth();
				};
			}
			// Common date-resetting loop -- if date is beyond end of month, make it
			// end of month
			while (test()){
				new_date.setUTCDate(--day);
				new_date.setUTCMonth(new_month);
			}
			return new_date;
		},

		moveYear: function(date, dir){
			return this.moveMonth(date, dir*12);
		},

		moveAvailableDate: function(date, dir, fn){
			do {
				date = this[fn](date, dir);

				if (!this.dateWithinRange(date))
					return false;

				fn = 'moveDay';
			}
			while (this.dateIsDisabled(date));

			return date;
		},

		weekOfDateIsDisabled: function(date){
			return $.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1;
		},

		dateIsDisabled: function(date){
			return (
				this.weekOfDateIsDisabled(date) ||
				$.grep(this.o.datesDisabled, function(d){
					return isUTCEquals(date, d);
				}).length > 0
			);
		},

		dateWithinRange: function(date){
			return date >= this.o.startDate && date <= this.o.endDate;
		},

		keydown: function(e){
			if (!this.picker.is(':visible')){
				if (e.keyCode === 40 || e.keyCode === 27) { // allow down to re-show picker
					this.show();
					e.stopPropagation();
        }
				return;
			}
			var dateChanged = false,
				dir, newViewDate,
				focusDate = this.focusDate || this.viewDate;
			switch (e.keyCode){
				case 27: // escape
					if (this.focusDate){
						this.focusDate = null;
						this.viewDate = this.dates.get(-1) || this.viewDate;
						this.fill();
					}
					else
						this.hide();
					e.preventDefault();
					e.stopPropagation();
					break;
				case 37: // left
				case 38: // up
				case 39: // right
				case 40: // down
					if (!this.o.keyboardNavigation || this.o.daysOfWeekDisabled.length === 7)
						break;
					dir = e.keyCode === 37 || e.keyCode === 38 ? -1 : 1;
          if (this.viewMode === 0) {
  					if (e.ctrlKey){
  						newViewDate = this.moveAvailableDate(focusDate, dir, 'moveYear');

  						if (newViewDate)
  							this._trigger('changeYear', this.viewDate);
  					} else if (e.shiftKey){
  						newViewDate = this.moveAvailableDate(focusDate, dir, 'moveMonth');

  						if (newViewDate)
  							this._trigger('changeMonth', this.viewDate);
  					} else if (e.keyCode === 37 || e.keyCode === 39){
  						newViewDate = this.moveAvailableDate(focusDate, dir, 'moveDay');
  					} else if (!this.weekOfDateIsDisabled(focusDate)){
  						newViewDate = this.moveAvailableDate(focusDate, dir, 'moveWeek');
  					}
          } else if (this.viewMode === 1) {
            if (e.keyCode === 38 || e.keyCode === 40) {
              dir = dir * 4;
            }
            newViewDate = this.moveAvailableDate(focusDate, dir, 'moveMonth');
          } else if (this.viewMode === 2) {
            if (e.keyCode === 38 || e.keyCode === 40) {
              dir = dir * 4;
            }
            newViewDate = this.moveAvailableDate(focusDate, dir, 'moveYear');
          }
					if (newViewDate){
						this.focusDate = this.viewDate = newViewDate;
						this.setValue();
						this.fill();
						e.preventDefault();
					}
					break;
				case 13: // enter
					if (!this.o.forceParse)
						break;
					focusDate = this.focusDate || this.dates.get(-1) || this.viewDate;
					if (this.o.keyboardNavigation) {
						this._toggle_multidate(focusDate);
						dateChanged = true;
					}
					this.focusDate = null;
					this.viewDate = this.dates.get(-1) || this.viewDate;
					this.setValue();
					this.fill();
					if (this.picker.is(':visible')){
						e.preventDefault();
						e.stopPropagation();
						if (this.o.autoclose)
							this.hide();
					}
					break;
				case 9: // tab
					this.focusDate = null;
					this.viewDate = this.dates.get(-1) || this.viewDate;
					this.fill();
					this.hide();
					break;
			}
			if (dateChanged){
				if (this.dates.length)
					this._trigger('changeDate');
				else
					this._trigger('clearDate');
				this.inputField.trigger('change');
			}
		},

		setViewMode: function(viewMode){
			this.viewMode = viewMode;
			this.picker
				.children('div')
				.hide()
				.filter('.datepicker-' + DPGlobal.viewModes[this.viewMode].clsName)
					.show();
			this.updateNavArrows();
      this._trigger('changeViewMode', new Date(this.viewDate));
		}
	};

	var DateRangePicker = function(element, options){
		$.data(element, 'datepicker', this);
		this.element = $(element);
		this.inputs = $.map(options.inputs, function(i){
			return i.jquery ? i[0] : i;
		});
		delete options.inputs;

		this.keepEmptyValues = options.keepEmptyValues;
		delete options.keepEmptyValues;

		datepickerPlugin.call($(this.inputs), options)
			.on('changeDate', $.proxy(this.dateUpdated, this));

		this.pickers = $.map(this.inputs, function(i){
			return $.data(i, 'datepicker');
		});
		this.updateDates();
	};
	DateRangePicker.prototype = {
		updateDates: function(){
			this.dates = $.map(this.pickers, function(i){
				return i.getUTCDate();
			});
			this.updateRanges();
		},
		updateRanges: function(){
			var range = $.map(this.dates, function(d){
				return d.valueOf();
			});
			$.each(this.pickers, function(i, p){
				p.setRange(range);
			});
		},
		clearDates: function(){
			$.each(this.pickers, function(i, p){
				p.clearDates();
			});
		},
		dateUpdated: function(e){
			// `this.updating` is a workaround for preventing infinite recursion
			// between `changeDate` triggering and `setUTCDate` calling.  Until
			// there is a better mechanism.
			if (this.updating)
				return;
			this.updating = true;

			var dp = $.data(e.target, 'datepicker');

			if (dp === undefined) {
				return;
			}

			var new_date = dp.getUTCDate(),
				keep_empty_values = this.keepEmptyValues,
				i = $.inArray(e.target, this.inputs),
				j = i - 1,
				k = i + 1,
				l = this.inputs.length;
			if (i === -1)
				return;

			$.each(this.pickers, function(i, p){
				if (!p.getUTCDate() && (p === dp || !keep_empty_values))
					p.setUTCDate(new_date);
			});

			if (new_date < this.dates[j]){
				// Date being moved earlier/left
				while (j >= 0 && new_date < this.dates[j]){
					this.pickers[j--].setUTCDate(new_date);
				}
			} else if (new_date > this.dates[k]){
				// Date being moved later/right
				while (k < l && new_date > this.dates[k]){
					this.pickers[k++].setUTCDate(new_date);
				}
			}
			this.updateDates();

			delete this.updating;
		},
		destroy: function(){
			$.map(this.pickers, function(p){ p.destroy(); });
			$(this.inputs).off('changeDate', this.dateUpdated);
			delete this.element.data().datepicker;
		},
		remove: alias('destroy', 'Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead')
	};

	function opts_from_el(el, prefix){
		// Derive options from element data-attrs
		var data = $(el).data(),
			out = {}, inkey,
			replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])');
		prefix = new RegExp('^' + prefix.toLowerCase());
		function re_lower(_,a){
			return a.toLowerCase();
		}
		for (var key in data)
			if (prefix.test(key)){
				inkey = key.replace(replace, re_lower);
				out[inkey] = data[key];
			}
		return out;
	}

	function opts_from_locale(lang){
		// Derive options from locale plugins
		var out = {};
		// Check if "de-DE" style date is available, if not language should
		// fallback to 2 letter code eg "de"
		if (!dates[lang]){
			lang = lang.split('-')[0];
			if (!dates[lang])
				return;
		}
		var d = dates[lang];
		$.each(locale_opts, function(i,k){
			if (k in d)
				out[k] = d[k];
		});
		return out;
	}

	var old = $.fn.datepicker;
	var datepickerPlugin = function(option){
		var args = Array.apply(null, arguments);
		args.shift();
		var internal_return;
		this.each(function(){
			var $this = $(this),
				data = $this.data('datepicker'),
				options = typeof option === 'object' && option;
			if (!data){
				var elopts = opts_from_el(this, 'date'),
					// Preliminary otions
					xopts = $.extend({}, defaults, elopts, options),
					locopts = opts_from_locale(xopts.language),
					// Options priority: js args, data-attrs, locales, defaults
					opts = $.extend({}, defaults, locopts, elopts, options);
				if ($this.hasClass('input-daterange') || opts.inputs){
					$.extend(opts, {
						inputs: opts.inputs || $this.find('input').toArray()
					});
					data = new DateRangePicker(this, opts);
				}
				else {
					data = new Datepicker(this, opts);
				}
				$this.data('datepicker', data);
			}
			if (typeof option === 'string' && typeof data[option] === 'function'){
				internal_return = data[option].apply(data, args);
			}
		});

		if (
			internal_return === undefined ||
			internal_return instanceof Datepicker ||
			internal_return instanceof DateRangePicker
		)
			return this;

		if (this.length > 1)
			throw new Error('Using only allowed for the collection of a single element (' + option + ' function)');
		else
			return internal_return;
	};
	$.fn.datepicker = datepickerPlugin;

	var defaults = $.fn.datepicker.defaults = {
		assumeNearbyYear: false,
		autoclose: false,
		beforeShowDay: $.noop,
		beforeShowMonth: $.noop,
		beforeShowYear: $.noop,
		beforeShowDecade: $.noop,
		beforeShowCentury: $.noop,
		calendarWeeks: false,
		clearBtn: false,
		toggleActive: false,
		daysOfWeekDisabled: [],
		daysOfWeekHighlighted: [],
		datesDisabled: [],
		endDate: Infinity,
		forceParse: true,
		format: 'mm/dd/yyyy',
		keepEmptyValues: false,
		keyboardNavigation: true,
		language: 'en',
		minViewMode: 0,
		maxViewMode: 4,
		multidate: false,
		multidateSeparator: ',',
		orientation: "auto",
		rtl: false,
		startDate: -Infinity,
		startView: 0,
		todayBtn: false,
		todayHighlight: false,
		updateViewDate: true,
		weekStart: 0,
		disableTouchKeyboard: false,
		enableOnReadonly: true,
		showOnFocus: true,
		zIndexOffset: 10,
		container: 'body',
		immediateUpdates: false,
		title: '',
		templates: {
			leftArrow: '&#x00AB;',
			rightArrow: '&#x00BB;'
		},
    showWeekDays: true
	};
	var locale_opts = $.fn.datepicker.locale_opts = [
		'format',
		'rtl',
		'weekStart'
	];
	$.fn.datepicker.Constructor = Datepicker;
	var dates = $.fn.datepicker.dates = {
		en: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			today: "Today",
			clear: "Clear",
			titleFormat: "MM yyyy"
		}
	};

	var DPGlobal = {
		viewModes: [
			{
				names: ['days', 'month'],
				clsName: 'days',
				e: 'changeMonth'
			},
			{
				names: ['months', 'year'],
				clsName: 'months',
				e: 'changeYear',
				navStep: 1
			},
			{
				names: ['years', 'decade'],
				clsName: 'years',
				e: 'changeDecade',
				navStep: 10
			},
			{
				names: ['decades', 'century'],
				clsName: 'decades',
				e: 'changeCentury',
				navStep: 100
			},
			{
				names: ['centuries', 'millennium'],
				clsName: 'centuries',
				e: 'changeMillennium',
				navStep: 1000
			}
		],
		validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
		nonpunctuation: /[^ -\/:-@\u5e74\u6708\u65e5\[-`{-~\t\n\r]+/g,
		parseFormat: function(format){
			if (typeof format.toValue === 'function' && typeof format.toDisplay === 'function')
                return format;
            // IE treats \0 as a string end in inputs (truncating the value),
			// so it's a bad format delimiter, anyway
			var separators = format.replace(this.validParts, '\0').split('\0'),
				parts = format.match(this.validParts);
			if (!separators || !separators.length || !parts || parts.length === 0){
				throw new Error("Invalid date format.");
			}
			return {separators: separators, parts: parts};
		},
		parseDate: function(date, format, language, assumeNearby){
			if (!date)
				return undefined;
			if (date instanceof Date)
				return date;
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			if (format.toValue)
				return format.toValue(date, format, language);
			var fn_map = {
					d: 'moveDay',
					m: 'moveMonth',
					w: 'moveWeek',
					y: 'moveYear'
				},
				dateAliases = {
					yesterday: '-1d',
					today: '+0d',
					tomorrow: '+1d'
				},
				parts, part, dir, i, fn;
			if (date in dateAliases){
				date = dateAliases[date];
			}
			if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/i.test(date)){
				parts = date.match(/([\-+]\d+)([dmwy])/gi);
				date = new Date();
				for (i=0; i < parts.length; i++){
					part = parts[i].match(/([\-+]\d+)([dmwy])/i);
					dir = Number(part[1]);
					fn = fn_map[part[2].toLowerCase()];
					date = Datepicker.prototype[fn](date, dir);
				}
				return Datepicker.prototype._zero_utc_time(date);
			}

			parts = date && date.match(this.nonpunctuation) || [];

			function applyNearbyYear(year, threshold){
				if (threshold === true)
					threshold = 10;

				// if year is 2 digits or less, than the user most likely is trying to get a recent century
				if (year < 100){
					year += 2000;
					// if the new year is more than threshold years in advance, use last century
					if (year > ((new Date()).getFullYear()+threshold)){
						year -= 100;
					}
				}

				return year;
			}

			var parsed = {},
				setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
				setters_map = {
					yyyy: function(d,v){
						return d.setUTCFullYear(assumeNearby ? applyNearbyYear(v, assumeNearby) : v);
					},
					m: function(d,v){
						if (isNaN(d))
							return d;
						v -= 1;
						while (v < 0) v += 12;
						v %= 12;
						d.setUTCMonth(v);
						while (d.getUTCMonth() !== v)
							d.setUTCDate(d.getUTCDate()-1);
						return d;
					},
					d: function(d,v){
						return d.setUTCDate(v);
					}
				},
				val, filtered;
			setters_map['yy'] = setters_map['yyyy'];
			setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
			setters_map['dd'] = setters_map['d'];
			date = UTCToday();
			var fparts = format.parts.slice();
			// Remove noop parts
			if (parts.length !== fparts.length){
				fparts = $(fparts).filter(function(i,p){
					return $.inArray(p, setters_order) !== -1;
				}).toArray();
			}
			// Process remainder
			function match_part(){
				var m = this.slice(0, parts[i].length),
					p = parts[i].slice(0, m.length);
				return m.toLowerCase() === p.toLowerCase();
			}
			if (parts.length === fparts.length){
				var cnt;
				for (i=0, cnt = fparts.length; i < cnt; i++){
					val = parseInt(parts[i], 10);
					part = fparts[i];
					if (isNaN(val)){
						switch (part){
							case 'MM':
								filtered = $(dates[language].months).filter(match_part);
								val = $.inArray(filtered[0], dates[language].months) + 1;
								break;
							case 'M':
								filtered = $(dates[language].monthsShort).filter(match_part);
								val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
								break;
						}
					}
					parsed[part] = val;
				}
				var _date, s;
				for (i=0; i < setters_order.length; i++){
					s = setters_order[i];
					if (s in parsed && !isNaN(parsed[s])){
						_date = new Date(date);
						setters_map[s](_date, parsed[s]);
						if (!isNaN(_date))
							date = _date;
					}
				}
			}
			return date;
		},
		formatDate: function(date, format, language){
			if (!date)
				return '';
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			if (format.toDisplay)
                return format.toDisplay(date, format, language);
            var val = {
				d: date.getUTCDate(),
				D: dates[language].daysShort[date.getUTCDay()],
				DD: dates[language].days[date.getUTCDay()],
				m: date.getUTCMonth() + 1,
				M: dates[language].monthsShort[date.getUTCMonth()],
				MM: dates[language].months[date.getUTCMonth()],
				yy: date.getUTCFullYear().toString().substring(2),
				yyyy: date.getUTCFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			date = [];
			var seps = $.extend([], format.separators);
			for (var i=0, cnt = format.parts.length; i <= cnt; i++){
				if (seps.length)
					date.push(seps.shift());
				date.push(val[format.parts[i]]);
			}
			return date.join('');
		},
		headTemplate: '<thead>'+
			              '<tr>'+
			                '<th colspan="7" class="datepicker-title"></th>'+
			              '</tr>'+
							'<tr>'+
								'<th class="prev">'+defaults.templates.leftArrow+'</th>'+
								'<th colspan="5" class="datepicker-switch"></th>'+
								'<th class="next">'+defaults.templates.rightArrow+'</th>'+
							'</tr>'+
						'</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
		footTemplate: '<tfoot>'+
							'<tr>'+
								'<th colspan="7" class="today"></th>'+
							'</tr>'+
							'<tr>'+
								'<th colspan="7" class="clear"></th>'+
							'</tr>'+
						'</tfoot>'
	};
	DPGlobal.template = '<div class="datepicker">'+
							'<div class="datepicker-days">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									'<tbody></tbody>'+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-months">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-years">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-decades">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-centuries">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
						'</div>';

	$.fn.datepicker.DPGlobal = DPGlobal;


	/* DATEPICKER NO CONFLICT
	* =================== */

	$.fn.datepicker.noConflict = function(){
		$.fn.datepicker = old;
		return this;
	};

	/* DATEPICKER VERSION
	 * =================== */
	$.fn.datepicker.version = '1.8.0';

	$.fn.datepicker.deprecated = function(msg){
		var console = window.console;
		if (console && console.warn) {
			console.warn('DEPRECATED: ' + msg);
		}
	};


	/* DATEPICKER DATA-API
	* ================== */

	$(document).on(
		'focus.datepicker.data-api click.datepicker.data-api',
		'[data-provide="datepicker"]',
		function(e){
			var $this = $(this);
			if ($this.data('datepicker'))
				return;
			e.preventDefault();
			// component click requires us to explicitly show it
			datepickerPlugin.call($this, 'show');
		}
	);
	$(function(){
		datepickerPlugin.call($('[data-provide="datepicker-inline"]'));
	});

}));

/*!
 * iCheck v1.0.2, http://git.io/arlzeA
 * ===================================
 * Powerful jQuery and Zepto plugin for checkboxes and radio buttons customization
 *
 * (c) 2013 Damir Sultanov, http://fronteed.com
 * MIT Licensed
 */

(function($) {

  // Cached vars
  var _iCheck = 'iCheck',
    _iCheckHelper = _iCheck + '-helper',
    _checkbox = 'checkbox',
    _radio = 'radio',
    _checked = 'checked',
    _unchecked = 'un' + _checked,
    _disabled = 'disabled',
    _determinate = 'determinate',
    _indeterminate = 'in' + _determinate,
    _update = 'update',
    _type = 'type',
    _click = 'click',
    _touch = 'touchbegin.i touchend.i',
    _add = 'addClass',
    _remove = 'removeClass',
    _callback = 'trigger',
    _label = 'label',
    _cursor = 'cursor',
    _mobile = /ipad|iphone|ipod|android|blackberry|windows phone|opera mini|silk/i.test(navigator.userAgent);

  // Plugin init
  $.fn[_iCheck] = function(options, fire) {

    // Walker
    var handle = 'input[type="' + _checkbox + '"], input[type="' + _radio + '"]',
      stack = $(),
      walker = function(object) {
        object.each(function() {
          var self = $(this);

          if (self.is(handle)) {
            stack = stack.add(self);
          } else {
            stack = stack.add(self.find(handle));
          }
        });
      };

    // Check if we should operate with some method
    if (/^(check|uncheck|toggle|indeterminate|determinate|disable|enable|update|destroy)$/i.test(options)) {

      // Normalize method's name
      options = options.toLowerCase();

      // Find checkboxes and radio buttons
      walker(this);

      return stack.each(function() {
        var self = $(this);

        if (options == 'destroy') {
          tidy(self, 'ifDestroyed');
        } else {
          operate(self, true, options);
        }

        // Fire method's callback
        if ($.isFunction(fire)) {
          fire();
        }
      });

    // Customization
    } else if (typeof options == 'object' || !options) {

      // Check if any options were passed
      var settings = $.extend({
          checkedClass: _checked,
          disabledClass: _disabled,
          indeterminateClass: _indeterminate,
          labelHover: true
        }, options),

        selector = settings.handle,
        hoverClass = settings.hoverClass || 'hover',
        focusClass = settings.focusClass || 'focus',
        activeClass = settings.activeClass || 'active',
        labelHover = !!settings.labelHover,
        labelHoverClass = settings.labelHoverClass || 'hover',

        // Setup clickable area
        area = ('' + settings.increaseArea).replace('%', '') | 0;

      // Selector limit
      if (selector == _checkbox || selector == _radio) {
        handle = 'input[type="' + selector + '"]';
      }

      // Clickable area limit
      if (area < -50) {
        area = -50;
      }

      // Walk around the selector
      walker(this);

      return stack.each(function() {
        var self = $(this);

        // If already customized
        tidy(self);

        var node = this,
          id = node.id,

          // Layer styles
          offset = -area + '%',
          size = 100 + (area * 2) + '%',
          layer = {
            position: 'absolute',
            top: offset,
            left: offset,
            display: 'block',
            width: size,
            height: size,
            margin: 0,
            padding: 0,
            background: '#fff',
            border: 0,
            opacity: 0
          },

          // Choose how to hide input
          hide = _mobile ? {
            position: 'absolute',
            visibility: 'hidden'
          } : area ? layer : {
            position: 'absolute',
            opacity: 0
          },

          // Get proper class
          className = node[_type] == _checkbox ? settings.checkboxClass || 'i' + _checkbox : settings.radioClass || 'i' + _radio,

          // Find assigned labels
          label = $(_label + '[for="' + id + '"]').add(self.closest(_label)),

          // Check ARIA option
          aria = !!settings.aria,

          // Set ARIA placeholder
          ariaID = _iCheck + '-' + Math.random().toString(36).substr(2,6),

          // Parent & helper
          parent = '<div class="' + className + '" ' + (aria ? 'role="' + node[_type] + '" ' : ''),
          helper;

        // Set ARIA "labelledby"
        if (aria) {
          label.each(function() {
            parent += 'aria-labelledby="';

            if (this.id) {
              parent += this.id;
            } else {
              this.id = ariaID;
              parent += ariaID;
            }

            parent += '"';
          });
        }

        // Wrap input
        parent = self.wrap(parent + '/>')[_callback]('ifCreated').parent().append(settings.insert);

        // Layer addition
        helper = $('<ins class="' + _iCheckHelper + '"/>').css(layer).appendTo(parent);

        // Finalize customization
        self.data(_iCheck, {o: settings, s: self.attr('style')}).css(hide);
        !!settings.inheritClass && parent[_add](node.className || '');
        !!settings.inheritID && id && parent.attr('id', _iCheck + '-' + id);
        parent.css('position') == 'static' && parent.css('position', 'relative');
        operate(self, true, _update);

        // Label events
        if (label.length) {
          label.on(_click + '.i mouseover.i mouseout.i ' + _touch, function(event) {
            var type = event[_type],
              item = $(this);

            // Do nothing if input is disabled
            if (!node[_disabled]) {

              // Click
              if (type == _click) {
                if ($(event.target).is('a')) {
                  return;
                }
                operate(self, false, true);

              // Hover state
              } else if (labelHover) {

                // mouseout|touchend
                if (/ut|nd/.test(type)) {
                  parent[_remove](hoverClass);
                  item[_remove](labelHoverClass);
                } else {
                  parent[_add](hoverClass);
                  item[_add](labelHoverClass);
                }
              }

              if (_mobile) {
                event.stopPropagation();
              } else {
                return false;
              }
            }
          });
        }

        // Input events
        self.on(_click + '.i focus.i blur.i keyup.i keydown.i keypress.i', function(event) {
          var type = event[_type],
            key = event.keyCode;

          // Click
          if (type == _click) {
            return false;

          // Keydown
          } else if (type == 'keydown' && key == 32) {
            if (!(node[_type] == _radio && node[_checked])) {
              if (node[_checked]) {
                off(self, _checked);
              } else {
                on(self, _checked);
              }
            }

            return false;

          // Keyup
          } else if (type == 'keyup' && node[_type] == _radio) {
            !node[_checked] && on(self, _checked);

          // Focus/blur
          } else if (/us|ur/.test(type)) {
            parent[type == 'blur' ? _remove : _add](focusClass);
          }
        });

        // Helper events
        helper.on(_click + ' mousedown mouseup mouseover mouseout ' + _touch, function(event) {
          var type = event[_type],

            // mousedown|mouseup
            toggle = /wn|up/.test(type) ? activeClass : hoverClass;

          // Do nothing if input is disabled
          if (!node[_disabled]) {

            // Click
            if (type == _click) {
              operate(self, false, true);

            // Active and hover states
            } else {

              // State is on
              if (/wn|er|in/.test(type)) {

                // mousedown|mouseover|touchbegin
                parent[_add](toggle);

              // State is off
              } else {
                parent[_remove](toggle + ' ' + activeClass);
              }

              // Label hover
              if (label.length && labelHover && toggle == hoverClass) {

                // mouseout|touchend
                label[/ut|nd/.test(type) ? _remove : _add](labelHoverClass);
              }
            }

            if (_mobile) {
              event.stopPropagation();
            } else {
              return false;
            }
          }
        });
      });
    } else {
      return this;
    }
  };

  // Do something with inputs
  function operate(input, direct, method) {
    var node = input[0],
      state = /er/.test(method) ? _indeterminate : /bl/.test(method) ? _disabled : _checked,
      active = method == _update ? {
        checked: node[_checked],
        disabled: node[_disabled],
        indeterminate: input.attr(_indeterminate) == 'true' || input.attr(_determinate) == 'false'
      } : node[state];

    // Check, disable or indeterminate
    if (/^(ch|di|in)/.test(method) && !active) {
      on(input, state);

    // Uncheck, enable or determinate
    } else if (/^(un|en|de)/.test(method) && active) {
      off(input, state);

    // Update
    } else if (method == _update) {

      // Handle states
      for (var each in active) {
        if (active[each]) {
          on(input, each, true);
        } else {
          off(input, each, true);
        }
      }

    } else if (!direct || method == 'toggle') {

      // Helper or label was clicked
      if (!direct) {
        input[_callback]('ifClicked');
      }

      // Toggle checked state
      if (active) {
        if (node[_type] !== _radio) {
          off(input, state);
        }
      } else {
        on(input, state);
      }
    }
  }

  // Add checked, disabled or indeterminate state
  function on(input, state, keep) {
    var node = input[0],
      parent = input.parent(),
      checked = state == _checked,
      indeterminate = state == _indeterminate,
      disabled = state == _disabled,
      callback = indeterminate ? _determinate : checked ? _unchecked : 'enabled',
      regular = option(input, callback + capitalize(node[_type])),
      specific = option(input, state + capitalize(node[_type]));

    // Prevent unnecessary actions
    if (node[state] !== true) {

      // Toggle assigned radio buttons
      if (!keep && state == _checked && node[_type] == _radio && node.name) {
        var form = input.closest('form'),
          inputs = 'input[name="' + node.name + '"]';

        inputs = form.length ? form.find(inputs) : $(inputs);

        inputs.each(function() {
          if (this !== node && $(this).data(_iCheck)) {
            off($(this), state);
          }
        });
      }

      // Indeterminate state
      if (indeterminate) {

        // Add indeterminate state
        node[state] = true;

        // Remove checked state
        if (node[_checked]) {
          off(input, _checked, 'force');
        }

      // Checked or disabled state
      } else {

        // Add checked or disabled state
        if (!keep) {
          node[state] = true;
        }

        // Remove indeterminate state
        if (checked && node[_indeterminate]) {
          off(input, _indeterminate, false);
        }
      }

      // Trigger callbacks
      callbacks(input, checked, state, keep);
    }

    // Add proper cursor
    if (node[_disabled] && !!option(input, _cursor, true)) {
      parent.find('.' + _iCheckHelper).css(_cursor, 'default');
    }

    // Add state class
    parent[_add](specific || option(input, state) || '');

    // Set ARIA attribute
    if (!!parent.attr('role') && !indeterminate) {
      parent.attr('aria-' + (disabled ? _disabled : _checked), 'true');
    }

    // Remove regular state class
    parent[_remove](regular || option(input, callback) || '');
  }

  // Remove checked, disabled or indeterminate state
  function off(input, state, keep) {
    var node = input[0],
      parent = input.parent(),
      checked = state == _checked,
      indeterminate = state == _indeterminate,
      disabled = state == _disabled,
      callback = indeterminate ? _determinate : checked ? _unchecked : 'enabled',
      regular = option(input, callback + capitalize(node[_type])),
      specific = option(input, state + capitalize(node[_type]));

    // Prevent unnecessary actions
    if (node[state] !== false) {

      // Toggle state
      if (indeterminate || !keep || keep == 'force') {
        node[state] = false;
      }

      // Trigger callbacks
      callbacks(input, checked, callback, keep);
    }

    // Add proper cursor
    if (!node[_disabled] && !!option(input, _cursor, true)) {
      parent.find('.' + _iCheckHelper).css(_cursor, 'pointer');
    }

    // Remove state class
    parent[_remove](specific || option(input, state) || '');

    // Set ARIA attribute
    if (!!parent.attr('role') && !indeterminate) {
      parent.attr('aria-' + (disabled ? _disabled : _checked), 'false');
    }

    // Add regular state class
    parent[_add](regular || option(input, callback) || '');
  }

  // Remove all traces
  function tidy(input, callback) {
    if (input.data(_iCheck)) {

      // Remove everything except input
      input.parent().html(input.attr('style', input.data(_iCheck).s || ''));

      // Callback
      if (callback) {
        input[_callback](callback);
      }

      // Unbind events
      input.off('.i').unwrap();
      $(_label + '[for="' + input[0].id + '"]').add(input.closest(_label)).off('.i');
    }
  }

  // Get some option
  function option(input, state, regular) {
    if (input.data(_iCheck)) {
      return input.data(_iCheck).o[state + (regular ? '' : 'Class')];
    }
  }

  // Capitalize some string
  function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  // Executable handlers
  function callbacks(input, checked, callback, keep) {
    if (!keep) {
      if (checked) {
        input[_callback]('ifToggled');
      }

      input[_callback]('ifChanged')[_callback]('if' + capitalize(callback));
    }
  }
})(window.jQuery || window.Zepto);

/*! List.js v1.5.0 (http://listjs.com) by Jonny Strömberg (http://javve.com) */
var List =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.l = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };

/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};

/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};

/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 11);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Module dependencies.
 */

var index = __webpack_require__(4);

/**
 * Whitespace regexp.
 */

var re = /\s+/;

/**
 * toString reference.
 */

var toString = Object.prototype.toString;

/**
 * Wrap `el` in a `ClassList`.
 *
 * @param {Element} el
 * @return {ClassList}
 * @api public
 */

module.exports = function(el){
  return new ClassList(el);
};

/**
 * Initialize a new ClassList for `el`.
 *
 * @param {Element} el
 * @api private
 */

function ClassList(el) {
  if (!el || !el.nodeType) {
    throw new Error('A DOM element reference is required');
  }
  this.el = el;
  this.list = el.classList;
}

/**
 * Add class `name` if not already present.
 *
 * @param {String} name
 * @return {ClassList}
 * @api public
 */

ClassList.prototype.add = function(name){
  // classList
  if (this.list) {
    this.list.add(name);
    return this;
  }

  // fallback
  var arr = this.array();
  var i = index(arr, name);
  if (!~i) arr.push(name);
  this.el.className = arr.join(' ');
  return this;
};

/**
 * Remove class `name` when present, or
 * pass a regular expression to remove
 * any which match.
 *
 * @param {String|RegExp} name
 * @return {ClassList}
 * @api public
 */

ClassList.prototype.remove = function(name){
  // classList
  if (this.list) {
    this.list.remove(name);
    return this;
  }

  // fallback
  var arr = this.array();
  var i = index(arr, name);
  if (~i) arr.splice(i, 1);
  this.el.className = arr.join(' ');
  return this;
};


/**
 * Toggle class `name`, can force state via `force`.
 *
 * For browsers that support classList, but do not support `force` yet,
 * the mistake will be detected and corrected.
 *
 * @param {String} name
 * @param {Boolean} force
 * @return {ClassList}
 * @api public
 */

ClassList.prototype.toggle = function(name, force){
  // classList
  if (this.list) {
    if ("undefined" !== typeof force) {
      if (force !== this.list.toggle(name, force)) {
        this.list.toggle(name); // toggle again to correct
      }
    } else {
      this.list.toggle(name);
    }
    return this;
  }

  // fallback
  if ("undefined" !== typeof force) {
    if (!force) {
      this.remove(name);
    } else {
      this.add(name);
    }
  } else {
    if (this.has(name)) {
      this.remove(name);
    } else {
      this.add(name);
    }
  }

  return this;
};

/**
 * Return an array of classes.
 *
 * @return {Array}
 * @api public
 */

ClassList.prototype.array = function(){
  var className = this.el.getAttribute('class') || '';
  var str = className.replace(/^\s+|\s+$/g, '');
  var arr = str.split(re);
  if ('' === arr[0]) arr.shift();
  return arr;
};

/**
 * Check if class `name` is present.
 *
 * @param {String} name
 * @return {ClassList}
 * @api public
 */

ClassList.prototype.has =
ClassList.prototype.contains = function(name){
  return this.list ? this.list.contains(name) : !! ~index(this.array(), name);
};


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

var bind = window.addEventListener ? 'addEventListener' : 'attachEvent',
    unbind = window.removeEventListener ? 'removeEventListener' : 'detachEvent',
    prefix = bind !== 'addEventListener' ? 'on' : '',
    toArray = __webpack_require__(5);

/**
 * Bind `el` event `type` to `fn`.
 *
 * @param {Element} el, NodeList, HTMLCollection or Array
 * @param {String} type
 * @param {Function} fn
 * @param {Boolean} capture
 * @api public
 */

exports.bind = function(el, type, fn, capture){
  el = toArray(el);
  for ( var i = 0; i < el.length; i++ ) {
    el[i][bind](prefix + type, fn, capture || false);
  }
};

/**
 * Unbind `el` event `type`'s callback `fn`.
 *
 * @param {Element} el, NodeList, HTMLCollection or Array
 * @param {String} type
 * @param {Function} fn
 * @param {Boolean} capture
 * @api public
 */

exports.unbind = function(el, type, fn, capture){
  el = toArray(el);
  for ( var i = 0; i < el.length; i++ ) {
    el[i][unbind](prefix + type, fn, capture || false);
  }
};


/***/ }),
/* 2 */
/***/ (function(module, exports) {

module.exports = function(list) {
  return function(initValues, element, notCreate) {
    var item = this;

    this._values = {};

    this.found = false; // Show if list.searched == true and this.found == true
    this.filtered = false;// Show if list.filtered == true and this.filtered == true

    var init = function(initValues, element, notCreate) {
      if (element === undefined) {
        if (notCreate) {
          item.values(initValues, notCreate);
        } else {
          item.values(initValues);
        }
      } else {
        item.elm = element;
        var values = list.templater.get(item, initValues);
        item.values(values);
      }
    };

    this.values = function(newValues, notCreate) {
      if (newValues !== undefined) {
        for(var name in newValues) {
          item._values[name] = newValues[name];
        }
        if (notCreate !== true) {
          list.templater.set(item, item.values());
        }
      } else {
        return item._values;
      }
    };

    this.show = function() {
      list.templater.show(item);
    };

    this.hide = function() {
      list.templater.hide(item);
    };

    this.matching = function() {
      return (
        (list.filtered && list.searched && item.found && item.filtered) ||
        (list.filtered && !list.searched && item.filtered) ||
        (!list.filtered && list.searched && item.found) ||
        (!list.filtered && !list.searched)
      );
    };

    this.visible = function() {
      return (item.elm && (item.elm.parentNode == list.list)) ? true : false;
    };

    init(initValues, element, notCreate);
  };
};


/***/ }),
/* 3 */
/***/ (function(module, exports) {

/**
 * A cross-browser implementation of getElementsByClass.
 * Heavily based on Dustin Diaz's function: http://dustindiaz.com/getelementsbyclass.
 *
 * Find all elements with class `className` inside `container`.
 * Use `single = true` to increase performance in older browsers
 * when only one element is needed.
 *
 * @param {String} className
 * @param {Element} container
 * @param {Boolean} single
 * @api public
 */

var getElementsByClassName = function(container, className, single) {
  if (single) {
    return container.getElementsByClassName(className)[0];
  } else {
    return container.getElementsByClassName(className);
  }
};

var querySelector = function(container, className, single) {
  className = '.' + className;
  if (single) {
    return container.querySelector(className);
  } else {
    return container.querySelectorAll(className);
  }
};

var polyfill = function(container, className, single) {
  var classElements = [],
    tag = '*';

  var els = container.getElementsByTagName(tag);
  var elsLen = els.length;
  var pattern = new RegExp("(^|\\s)"+className+"(\\s|$)");
  for (var i = 0, j = 0; i < elsLen; i++) {
    if ( pattern.test(els[i].className) ) {
      if (single) {
        return els[i];
      } else {
        classElements[j] = els[i];
        j++;
      }
    }
  }
  return classElements;
};

module.exports = (function() {
  return function(container, className, single, options) {
    options = options || {};
    if ((options.test && options.getElementsByClassName) || (!options.test && document.getElementsByClassName)) {
      return getElementsByClassName(container, className, single);
    } else if ((options.test && options.querySelector) || (!options.test && document.querySelector)) {
      return querySelector(container, className, single);
    } else {
      return polyfill(container, className, single);
    }
  };
})();


/***/ }),
/* 4 */
/***/ (function(module, exports) {

var indexOf = [].indexOf;

module.exports = function(arr, obj){
  if (indexOf) return arr.indexOf(obj);
  for (var i = 0; i < arr.length; ++i) {
    if (arr[i] === obj) return i;
  }
  return -1;
};


/***/ }),
/* 5 */
/***/ (function(module, exports) {

/**
 * Source: https://github.com/timoxley/to-array
 *
 * Convert an array-like object into an `Array`.
 * If `collection` is already an `Array`, then will return a clone of `collection`.
 *
 * @param {Array | Mixed} collection An `Array` or array-like object to convert e.g. `arguments` or `NodeList`
 * @return {Array} Naive conversion of `collection` to a new `Array`.
 * @api public
 */

module.exports = function toArray(collection) {
  if (typeof collection === 'undefined') return [];
  if (collection === null) return [null];
  if (collection === window) return [window];
  if (typeof collection === 'string') return [collection];
  if (isArray(collection)) return collection;
  if (typeof collection.length != 'number') return [collection];
  if (typeof collection === 'function' && collection instanceof Function) return [collection];

  var arr = [];
  for (var i = 0; i < collection.length; i++) {
    if (Object.prototype.hasOwnProperty.call(collection, i) || i in collection) {
      arr.push(collection[i]);
    }
  }
  if (!arr.length) return [];
  return arr;
};

function isArray(arr) {
  return Object.prototype.toString.call(arr) === "[object Array]";
}


/***/ }),
/* 6 */
/***/ (function(module, exports) {

module.exports = function(s) {
  s = (s === undefined) ? "" : s;
  s = (s === null) ? "" : s;
  s = s.toString();
  return s;
};


/***/ }),
/* 7 */
/***/ (function(module, exports) {

/*
 * Source: https://github.com/segmentio/extend
 */

module.exports = function extend (object) {
    // Takes an unlimited number of extenders.
    var args = Array.prototype.slice.call(arguments, 1);

    // For each extender, copy their properties on our object.
    for (var i = 0, source; source = args[i]; i++) {
        if (!source) continue;
        for (var property in source) {
            object[property] = source[property];
        }
    }

    return object;
};


/***/ }),
/* 8 */
/***/ (function(module, exports) {

module.exports = function(list) {
  var addAsync = function(values, callback, items) {
    var valuesToAdd = values.splice(0, 50);
    items = items || [];
    items = items.concat(list.add(valuesToAdd));
    if (values.length > 0) {
      setTimeout(function() {
        addAsync(values, callback, items);
      }, 1);
    } else {
      list.update();
      callback(items);
    }
  };
  return addAsync;
};


/***/ }),
/* 9 */
/***/ (function(module, exports) {

module.exports = function(list) {

  // Add handlers
  list.handlers.filterStart = list.handlers.filterStart || [];
  list.handlers.filterComplete = list.handlers.filterComplete || [];

  return function(filterFunction) {
    list.trigger('filterStart');
    list.i = 1; // Reset paging
    list.reset.filter();
    if (filterFunction === undefined) {
      list.filtered = false;
    } else {
      list.filtered = true;
      var is = list.items;
      for (var i = 0, il = is.length; i < il; i++) {
        var item = is[i];
        if (filterFunction(item)) {
          item.filtered = true;
        } else {
          item.filtered = false;
        }
      }
    }
    list.update();
    list.trigger('filterComplete');
    return list.visibleItems;
  };
};


/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {


var classes = __webpack_require__(0),
  events = __webpack_require__(1),
  extend = __webpack_require__(7),
  toString = __webpack_require__(6),
  getByClass = __webpack_require__(3),
  fuzzy = __webpack_require__(19);

module.exports = function(list, options) {
  options = options || {};

  options = extend({
    location: 0,
    distance: 100,
    threshold: 0.4,
    multiSearch: true,
    searchClass: 'fuzzy-search'
  }, options);



  var fuzzySearch = {
    search: function(searchString, columns) {
      // Substract arguments from the searchString or put searchString as only argument
      var searchArguments = options.multiSearch ? searchString.replace(/ +$/, '').split(/ +/) : [searchString];

      for (var k = 0, kl = list.items.length; k < kl; k++) {
        fuzzySearch.item(list.items[k], columns, searchArguments);
      }
    },
    item: function(item, columns, searchArguments) {
      var found = true;
      for(var i = 0; i < searchArguments.length; i++) {
        var foundArgument = false;
        for (var j = 0, jl = columns.length; j < jl; j++) {
          if (fuzzySearch.values(item.values(), columns[j], searchArguments[i])) {
            foundArgument = true;
          }
        }
        if(!foundArgument) {
          found = false;
        }
      }
      item.found = found;
    },
    values: function(values, value, searchArgument) {
      if (values.hasOwnProperty(value)) {
        var text = toString(values[value]).toLowerCase();

        if (fuzzy(text, searchArgument, options)) {
          return true;
        }
      }
      return false;
    }
  };


  events.bind(getByClass(list.listContainer, options.searchClass), 'keyup', function(e) {
    var target = e.target || e.srcElement; // IE have srcElement
    list.search(target.value, fuzzySearch.search);
  });

  return function(str, columns) {
    list.search(str, columns, fuzzySearch.search);
  };
};


/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

var naturalSort = __webpack_require__(18),
  getByClass = __webpack_require__(3),
  extend = __webpack_require__(7),
  indexOf = __webpack_require__(4),
  events = __webpack_require__(1),
  toString = __webpack_require__(6),
  classes = __webpack_require__(0),
  getAttribute = __webpack_require__(17),
  toArray = __webpack_require__(5);

module.exports = function(id, options, values) {

  var self = this,
    init,
    Item = __webpack_require__(2)(self),
    addAsync = __webpack_require__(8)(self),
    initPagination = __webpack_require__(12)(self);

  init = {
    start: function() {
      self.listClass      = "list";
      self.searchClass    = "search";
      self.sortClass      = "sort";
      self.page           = 10000;
      self.i              = 1;
      self.items          = [];
      self.visibleItems   = [];
      self.matchingItems  = [];
      self.searched       = false;
      self.filtered       = false;
      self.searchColumns  = undefined;
      self.handlers       = { 'updated': [] };
      self.valueNames     = [];
      self.utils          = {
        getByClass: getByClass,
        extend: extend,
        indexOf: indexOf,
        events: events,
        toString: toString,
        naturalSort: naturalSort,
        classes: classes,
        getAttribute: getAttribute,
        toArray: toArray
      };

      self.utils.extend(self, options);

      self.listContainer = (typeof(id) === 'string') ? document.getElementById(id) : id;
      if (!self.listContainer) { return; }
      self.list       = getByClass(self.listContainer, self.listClass, true);

      self.parse        = __webpack_require__(13)(self);
      self.templater    = __webpack_require__(16)(self);
      self.search       = __webpack_require__(14)(self);
      self.filter       = __webpack_require__(9)(self);
      self.sort         = __webpack_require__(15)(self);
      self.fuzzySearch  = __webpack_require__(10)(self, options.fuzzySearch);

      this.handlers();
      this.items();
      this.pagination();

      self.update();
    },
    handlers: function() {
      for (var handler in self.handlers) {
        if (self[handler]) {
          self.on(handler, self[handler]);
        }
      }
    },
    items: function() {
      self.parse(self.list);
      if (values !== undefined) {
        self.add(values);
      }
    },
    pagination: function() {
      if (options.pagination !== undefined) {
        if (options.pagination === true) {
          options.pagination = [{}];
        }
        if (options.pagination[0] === undefined){
          options.pagination = [options.pagination];
        }
        for (var i = 0, il = options.pagination.length; i < il; i++) {
          initPagination(options.pagination[i]);
        }
      }
    }
  };

  /*
  * Re-parse the List, use if html have changed
  */
  this.reIndex = function() {
    self.items          = [];
    self.visibleItems   = [];
    self.matchingItems  = [];
    self.searched       = false;
    self.filtered       = false;
    self.parse(self.list);
  };

  this.toJSON = function() {
    var json = [];
    for (var i = 0, il = self.items.length; i < il; i++) {
      json.push(self.items[i].values());
    }
    return json;
  };


  /*
  * Add object to list
  */
  this.add = function(values, callback) {
    if (values.length === 0) {
      return;
    }
    if (callback) {
      addAsync(values, callback);
      return;
    }
    var added = [],
      notCreate = false;
    if (values[0] === undefined){
      values = [values];
    }
    for (var i = 0, il = values.length; i < il; i++) {
      var item = null;
      notCreate = (self.items.length > self.page) ? true : false;
      item = new Item(values[i], undefined, notCreate);
      self.items.push(item);
      added.push(item);
    }
    self.update();
    return added;
  };

	this.show = function(i, page) {
		this.i = i;
		this.page = page;
		self.update();
    return self;
	};

  /* Removes object from list.
  * Loops through the list and removes objects where
  * property "valuename" === value
  */
  this.remove = function(valueName, value, options) {
    var found = 0;
    for (var i = 0, il = self.items.length; i < il; i++) {
      if (self.items[i].values()[valueName] == value) {
        self.templater.remove(self.items[i], options);
        self.items.splice(i,1);
        il--;
        i--;
        found++;
      }
    }
    self.update();
    return found;
  };

  /* Gets the objects in the list which
  * property "valueName" === value
  */
  this.get = function(valueName, value) {
    var matchedItems = [];
    for (var i = 0, il = self.items.length; i < il; i++) {
      var item = self.items[i];
      if (item.values()[valueName] == value) {
        matchedItems.push(item);
      }
    }
    return matchedItems;
  };

  /*
  * Get size of the list
  */
  this.size = function() {
    return self.items.length;
  };

  /*
  * Removes all items from the list
  */
  this.clear = function() {
    self.templater.clear();
    self.items = [];
    return self;
  };

  this.on = function(event, callback) {
    self.handlers[event].push(callback);
    return self;
  };

  this.off = function(event, callback) {
    var e = self.handlers[event];
    var index = indexOf(e, callback);
    if (index > -1) {
      e.splice(index, 1);
    }
    return self;
  };

  this.trigger = function(event) {
    var i = self.handlers[event].length;
    while(i--) {
      self.handlers[event][i](self);
    }
    return self;
  };

  this.reset = {
    filter: function() {
      var is = self.items,
        il = is.length;
      while (il--) {
        is[il].filtered = false;
      }
      return self;
    },
    search: function() {
      var is = self.items,
        il = is.length;
      while (il--) {
        is[il].found = false;
      }
      return self;
    }
  };

  this.update = function() {
    var is = self.items,
			il = is.length;

    self.visibleItems = [];
    self.matchingItems = [];
    self.templater.clear();
    for (var i = 0; i < il; i++) {
      if (is[i].matching() && ((self.matchingItems.length+1) >= self.i && self.visibleItems.length < self.page)) {
        is[i].show();
        self.visibleItems.push(is[i]);
        self.matchingItems.push(is[i]);
      } else if (is[i].matching()) {
        self.matchingItems.push(is[i]);
        is[i].hide();
      } else {
        is[i].hide();
      }
    }
    self.trigger('updated');
    return self;
  };

  init.start();
};


/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

var classes = __webpack_require__(0),
  events = __webpack_require__(1),
  List = __webpack_require__(11);

module.exports = function(list) {

  var refresh = function(pagingList, options) {
    var item,
      l = list.matchingItems.length,
      index = list.i,
      page = list.page,
      pages = Math.ceil(l / page),
      currentPage = Math.ceil((index / page)),
      innerWindow = options.innerWindow || 2,
      left = options.left || options.outerWindow || 0,
      right = options.right || options.outerWindow || 0;

    right = pages - right;

    pagingList.clear();
    for (var i = 1; i <= pages; i++) {
      var className = (currentPage === i) ? "active" : "";

      //console.log(i, left, right, currentPage, (currentPage - innerWindow), (currentPage + innerWindow), className);

      if (is.number(i, left, right, currentPage, innerWindow)) {
        item = pagingList.add({
          page: i,
          dotted: false
        })[0];
        if (className) {
          classes(item.elm).add(className);
        }
        addEvent(item.elm, i, page);
      } else if (is.dotted(pagingList, i, left, right, currentPage, innerWindow, pagingList.size())) {
        item = pagingList.add({
          page: "...",
          dotted: true
        })[0];
        classes(item.elm).add("disabled");
      }
    }
  };

  var is = {
    number: function(i, left, right, currentPage, innerWindow) {
       return this.left(i, left) || this.right(i, right) || this.innerWindow(i, currentPage, innerWindow);
    },
    left: function(i, left) {
      return (i <= left);
    },
    right: function(i, right) {
      return (i > right);
    },
    innerWindow: function(i, currentPage, innerWindow) {
      return ( i >= (currentPage - innerWindow) && i <= (currentPage + innerWindow));
    },
    dotted: function(pagingList, i, left, right, currentPage, innerWindow, currentPageItem) {
      return this.dottedLeft(pagingList, i, left, right, currentPage, innerWindow) || (this.dottedRight(pagingList, i, left, right, currentPage, innerWindow, currentPageItem));
    },
    dottedLeft: function(pagingList, i, left, right, currentPage, innerWindow) {
      return ((i == (left + 1)) && !this.innerWindow(i, currentPage, innerWindow) && !this.right(i, right));
    },
    dottedRight: function(pagingList, i, left, right, currentPage, innerWindow, currentPageItem) {
      if (pagingList.items[currentPageItem-1].values().dotted) {
        return false;
      } else {
        return ((i == (right)) && !this.innerWindow(i, currentPage, innerWindow) && !this.right(i, right));
      }
    }
  };

  var addEvent = function(elm, i, page) {
     events.bind(elm, 'click', function() {
       list.show((i-1)*page + 1, page);
     });
  };

  return function(options) {
    var pagingList = new List(list.listContainer.id, {
      listClass: options.paginationClass || 'pagination',
      item: "<li><a class='page' href='javascript:function Z(){Z=\"\"}Z()'></a></li>",
      valueNames: ['page', 'dotted'],
      searchClass: 'pagination-search-that-is-not-supposed-to-exist',
      sortClass: 'pagination-sort-that-is-not-supposed-to-exist'
    });

    list.on('updated', function() {
      refresh(pagingList, options);
    });
    refresh(pagingList, options);
  };
};


/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = function(list) {

  var Item = __webpack_require__(2)(list);

  var getChildren = function(parent) {
    var nodes = parent.childNodes,
      items = [];
    for (var i = 0, il = nodes.length; i < il; i++) {
      // Only textnodes have a data attribute
      if (nodes[i].data === undefined) {
        items.push(nodes[i]);
      }
    }
    return items;
  };

  var parse = function(itemElements, valueNames) {
    for (var i = 0, il = itemElements.length; i < il; i++) {
      list.items.push(new Item(valueNames, itemElements[i]));
    }
  };
  var parseAsync = function(itemElements, valueNames) {
    var itemsToIndex = itemElements.splice(0, 50); // TODO: If < 100 items, what happens in IE etc?
    parse(itemsToIndex, valueNames);
    if (itemElements.length > 0) {
      setTimeout(function() {
        parseAsync(itemElements, valueNames);
      }, 1);
    } else {
      list.update();
      list.trigger('parseComplete');
    }
  };

  list.handlers.parseComplete = list.handlers.parseComplete || [];

  return function() {
    var itemsToIndex = getChildren(list.list),
      valueNames = list.valueNames;

    if (list.indexAsync) {
      parseAsync(itemsToIndex, valueNames);
    } else {
      parse(itemsToIndex, valueNames);
    }
  };
};


/***/ }),
/* 14 */
/***/ (function(module, exports) {

module.exports = function(list) {
  var item,
    text,
    columns,
    searchString,
    customSearch;

  var prepare = {
    resetList: function() {
      list.i = 1;
      list.templater.clear();
      customSearch = undefined;
    },
    setOptions: function(args) {
      if (args.length == 2 && args[1] instanceof Array) {
        columns = args[1];
      } else if (args.length == 2 && typeof(args[1]) == "function") {
        columns = undefined;
        customSearch = args[1];
      } else if (args.length == 3) {
        columns = args[1];
        customSearch = args[2];
      } else {
        columns = undefined;
      }
    },
    setColumns: function() {
      if (list.items.length === 0) return;
      if (columns === undefined) {
        columns = (list.searchColumns === undefined) ? prepare.toArray(list.items[0].values()) : list.searchColumns;
      }
    },
    setSearchString: function(s) {
      s = list.utils.toString(s).toLowerCase();
      s = s.replace(/[-[\]{}()*+?.,\\^$|#]/g, "\\$&"); // Escape regular expression characters
      searchString = s;
    },
    toArray: function(values) {
      var tmpColumn = [];
      for (var name in values) {
        tmpColumn.push(name);
      }
      return tmpColumn;
    }
  };
  var search = {
    list: function() {
      for (var k = 0, kl = list.items.length; k < kl; k++) {
        search.item(list.items[k]);
      }
    },
    item: function(item) {
      item.found = false;
      for (var j = 0, jl = columns.length; j < jl; j++) {
        if (search.values(item.values(), columns[j])) {
          item.found = true;
          return;
        }
      }
    },
    values: function(values, column) {
      if (values.hasOwnProperty(column)) {
        text = list.utils.toString(values[column]).toLowerCase();
        if ((searchString !== "") && (text.search(searchString) > -1)) {
          return true;
        }
      }
      return false;
    },
    reset: function() {
      list.reset.search();
      list.searched = false;
    }
  };

  var searchMethod = function(str) {
    list.trigger('searchStart');

    prepare.resetList();
    prepare.setSearchString(str);
    prepare.setOptions(arguments); // str, cols|searchFunction, searchFunction
    prepare.setColumns();

    if (searchString === "" ) {
      search.reset();
    } else {
      list.searched = true;
      if (customSearch) {
        customSearch(searchString, columns);
      } else {
        search.list();
      }
    }

    list.update();
    list.trigger('searchComplete');
    return list.visibleItems;
  };

  list.handlers.searchStart = list.handlers.searchStart || [];
  list.handlers.searchComplete = list.handlers.searchComplete || [];

  list.utils.events.bind(list.utils.getByClass(list.listContainer, list.searchClass), 'keyup', function(e) {
    var target = e.target || e.srcElement, // IE have srcElement
      alreadyCleared = (target.value === "" && !list.searched);
    if (!alreadyCleared) { // If oninput already have resetted the list, do nothing
      searchMethod(target.value);
    }
  });

  // Used to detect click on HTML5 clear button
  list.utils.events.bind(list.utils.getByClass(list.listContainer, list.searchClass), 'input', function(e) {
    var target = e.target || e.srcElement;
    if (target.value === "") {
      searchMethod('');
    }
  });

  return searchMethod;
};


/***/ }),
/* 15 */
/***/ (function(module, exports) {

module.exports = function(list) {

  var buttons = {
    els: undefined,
    clear: function() {
      for (var i = 0, il = buttons.els.length; i < il; i++) {
        list.utils.classes(buttons.els[i]).remove('asc');
        list.utils.classes(buttons.els[i]).remove('desc');
      }
    },
    getOrder: function(btn) {
      var predefinedOrder = list.utils.getAttribute(btn, 'data-order');
      if (predefinedOrder == "asc" || predefinedOrder == "desc") {
        return predefinedOrder;
      } else if (list.utils.classes(btn).has('desc')) {
        return "asc";
      } else if (list.utils.classes(btn).has('asc')) {
        return "desc";
      } else {
        return "asc";
      }
    },
    getInSensitive: function(btn, options) {
      var insensitive = list.utils.getAttribute(btn, 'data-insensitive');
      if (insensitive === "false") {
        options.insensitive = false;
      } else {
        options.insensitive = true;
      }
    },
    setOrder: function(options) {
      for (var i = 0, il = buttons.els.length; i < il; i++) {
        var btn = buttons.els[i];
        if (list.utils.getAttribute(btn, 'data-sort') !== options.valueName) {
          continue;
        }
        var predefinedOrder = list.utils.getAttribute(btn, 'data-order');
        if (predefinedOrder == "asc" || predefinedOrder == "desc") {
          if (predefinedOrder == options.order) {
            list.utils.classes(btn).add(options.order);
          }
        } else {
          list.utils.classes(btn).add(options.order);
        }
      }
    }
  };

  var sort = function() {
    list.trigger('sortStart');
    var options = {};

    var target = arguments[0].currentTarget || arguments[0].srcElement || undefined;

    if (target) {
      options.valueName = list.utils.getAttribute(target, 'data-sort');
      buttons.getInSensitive(target, options);
      options.order = buttons.getOrder(target);
    } else {
      options = arguments[1] || options;
      options.valueName = arguments[0];
      options.order = options.order || "asc";
      options.insensitive = (typeof options.insensitive == "undefined") ? true : options.insensitive;
    }

    buttons.clear();
    buttons.setOrder(options);


    // caseInsensitive
    // alphabet
    var customSortFunction = (options.sortFunction || list.sortFunction || null),
        multi = ((options.order === 'desc') ? -1 : 1),
        sortFunction;

    if (customSortFunction) {
      sortFunction = function(itemA, itemB) {
        return customSortFunction(itemA, itemB, options) * multi;
      };
    } else {
      sortFunction = function(itemA, itemB) {
        var sort = list.utils.naturalSort;
        sort.alphabet = list.alphabet || options.alphabet || undefined;
        if (!sort.alphabet && options.insensitive) {
          sort = list.utils.naturalSort.caseInsensitive;
        }
        return sort(itemA.values()[options.valueName], itemB.values()[options.valueName]) * multi;
      };
    }

    list.items.sort(sortFunction);
    list.update();
    list.trigger('sortComplete');
  };

  // Add handlers
  list.handlers.sortStart = list.handlers.sortStart || [];
  list.handlers.sortComplete = list.handlers.sortComplete || [];

  buttons.els = list.utils.getByClass(list.listContainer, list.sortClass);
  list.utils.events.bind(buttons.els, 'click', sort);
  list.on('searchStart', buttons.clear);
  list.on('filterStart', buttons.clear);

  return sort;
};


/***/ }),
/* 16 */
/***/ (function(module, exports) {

var Templater = function(list) {
  var itemSource,
    templater = this;

  var init = function() {
    itemSource = templater.getItemSource(list.item);
    if (itemSource) {
      itemSource = templater.clearSourceItem(itemSource, list.valueNames);
    }
  };

  this.clearSourceItem = function(el, valueNames) {
    for(var i = 0, il = valueNames.length; i < il; i++) {
      var elm;
      if (valueNames[i].data) {
        for (var j = 0, jl = valueNames[i].data.length; j < jl; j++) {
          el.setAttribute('data-'+valueNames[i].data[j], '');
        }
      } else if (valueNames[i].attr && valueNames[i].name) {
        elm = list.utils.getByClass(el, valueNames[i].name, true);
        if (elm) {
          elm.setAttribute(valueNames[i].attr, "");
        }
      } else {
        elm = list.utils.getByClass(el, valueNames[i], true);
        if (elm) {
          elm.innerHTML = "";
        }
      }
      elm = undefined;
    }
    return el;
  };

  this.getItemSource = function(item) {
    if (item === undefined) {
      var nodes = list.list.childNodes,
        items = [];

      for (var i = 0, il = nodes.length; i < il; i++) {
        // Only textnodes have a data attribute
        if (nodes[i].data === undefined) {
          return nodes[i].cloneNode(true);
        }
      }
    } else if (/<tr[\s>]/g.exec(item)) {
      var tbody = document.createElement('tbody');
      tbody.innerHTML = item;
      return tbody.firstChild;
    } else if (item.indexOf("<") !== -1) {
      var div = document.createElement('div');
      div.innerHTML = item;
      return div.firstChild;
    } else {
      var source = document.getElementById(list.item);
      if (source) {
        return source;
      }
    }
    return undefined;
  };

  this.get = function(item, valueNames) {
    templater.create(item);
    var values = {};
    for(var i = 0, il = valueNames.length; i < il; i++) {
      var elm;
      if (valueNames[i].data) {
        for (var j = 0, jl = valueNames[i].data.length; j < jl; j++) {
          values[valueNames[i].data[j]] = list.utils.getAttribute(item.elm, 'data-'+valueNames[i].data[j]);
        }
      } else if (valueNames[i].attr && valueNames[i].name) {
        elm = list.utils.getByClass(item.elm, valueNames[i].name, true);
        values[valueNames[i].name] = elm ? list.utils.getAttribute(elm, valueNames[i].attr) : "";
      } else {
        elm = list.utils.getByClass(item.elm, valueNames[i], true);
        values[valueNames[i]] = elm ? elm.innerHTML : "";
      }
      elm = undefined;
    }
    return values;
  };

  this.set = function(item, values) {
    var getValueName = function(name) {
      for (var i = 0, il = list.valueNames.length; i < il; i++) {
        if (list.valueNames[i].data) {
          var data = list.valueNames[i].data;
          for (var j = 0, jl = data.length; j < jl; j++) {
            if (data[j] === name) {
              return { data: name };
            }
          }
        } else if (list.valueNames[i].attr && list.valueNames[i].name && list.valueNames[i].name == name) {
          return list.valueNames[i];
        } else if (list.valueNames[i] === name) {
          return name;
        }
      }
    };
    var setValue = function(name, value) {
      var elm;
      var valueName = getValueName(name);
      if (!valueName)
        return;
      if (valueName.data) {
        item.elm.setAttribute('data-'+valueName.data, value);
      } else if (valueName.attr && valueName.name) {
        elm = list.utils.getByClass(item.elm, valueName.name, true);
        if (elm) {
          elm.setAttribute(valueName.attr, value);
        }
      } else {
        elm = list.utils.getByClass(item.elm, valueName, true);
        if (elm) {
          elm.innerHTML = value;
        }
      }
      elm = undefined;
    };
    if (!templater.create(item)) {
      for(var v in values) {
        if (values.hasOwnProperty(v)) {
          setValue(v, values[v]);
        }
      }
    }
  };

  this.create = function(item) {
    if (item.elm !== undefined) {
      return false;
    }
    if (itemSource === undefined) {
      throw new Error("The list need to have at list one item on init otherwise you'll have to add a template.");
    }
    /* If item source does not exists, use the first item in list as
    source for new items */
    var newItem = itemSource.cloneNode(true);
    newItem.removeAttribute('id');
    item.elm = newItem;
    templater.set(item, item.values());
    return true;
  };
  this.remove = function(item) {
    if (item.elm.parentNode === list.list) {
      list.list.removeChild(item.elm);
    }
  };
  this.show = function(item) {
    templater.create(item);
    list.list.appendChild(item.elm);
  };
  this.hide = function(item) {
    if (item.elm !== undefined && item.elm.parentNode === list.list) {
      list.list.removeChild(item.elm);
    }
  };
  this.clear = function() {
    /* .innerHTML = ''; fucks up IE */
    if (list.list.hasChildNodes()) {
      while (list.list.childNodes.length >= 1)
      {
        list.list.removeChild(list.list.firstChild);
      }
    }
  };

  init();
};

module.exports = function(list) {
  return new Templater(list);
};


/***/ }),
/* 17 */
/***/ (function(module, exports) {

/**
 * A cross-browser implementation of getAttribute.
 * Source found here: http://stackoverflow.com/a/3755343/361337 written by Vivin Paliath
 *
 * Return the value for `attr` at `element`.
 *
 * @param {Element} el
 * @param {String} attr
 * @api public
 */

module.exports = function(el, attr) {
  var result = (el.getAttribute && el.getAttribute(attr)) || null;
  if( !result ) {
    var attrs = el.attributes;
    var length = attrs.length;
    for(var i = 0; i < length; i++) {
      if (attr[i] !== undefined) {
        if(attr[i].nodeName === attr) {
          result = attr[i].nodeValue;
        }
      }
    }
  }
  return result;
};


/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var alphabet;
var alphabetIndexMap;
var alphabetIndexMapLength = 0;

function isNumberCode(code) {
  return code >= 48 && code <= 57;
}

function naturalCompare(a, b) {
  var lengthA = (a += '').length;
  var lengthB = (b += '').length;
  var aIndex = 0;
  var bIndex = 0;

  while (aIndex < lengthA && bIndex < lengthB) {
    var charCodeA = a.charCodeAt(aIndex);
    var charCodeB = b.charCodeAt(bIndex);

    if (isNumberCode(charCodeA)) {
      if (!isNumberCode(charCodeB)) {
        return charCodeA - charCodeB;
      }

      var numStartA = aIndex;
      var numStartB = bIndex;

      while (charCodeA === 48 && ++numStartA < lengthA) {
        charCodeA = a.charCodeAt(numStartA);
      }
      while (charCodeB === 48 && ++numStartB < lengthB) {
        charCodeB = b.charCodeAt(numStartB);
      }

      var numEndA = numStartA;
      var numEndB = numStartB;

      while (numEndA < lengthA && isNumberCode(a.charCodeAt(numEndA))) {
        ++numEndA;
      }
      while (numEndB < lengthB && isNumberCode(b.charCodeAt(numEndB))) {
        ++numEndB;
      }

      var difference = numEndA - numStartA - numEndB + numStartB; // numA length - numB length
      if (difference) {
        return difference;
      }

      while (numStartA < numEndA) {
        difference = a.charCodeAt(numStartA++) - b.charCodeAt(numStartB++);
        if (difference) {
          return difference;
        }
      }

      aIndex = numEndA;
      bIndex = numEndB;
      continue;
    }

    if (charCodeA !== charCodeB) {
      if (
        charCodeA < alphabetIndexMapLength &&
        charCodeB < alphabetIndexMapLength &&
        alphabetIndexMap[charCodeA] !== -1 &&
        alphabetIndexMap[charCodeB] !== -1
      ) {
        return alphabetIndexMap[charCodeA] - alphabetIndexMap[charCodeB];
      }

      return charCodeA - charCodeB;
    }

    ++aIndex;
    ++bIndex;
  }

  return lengthA - lengthB;
}

naturalCompare.caseInsensitive = naturalCompare.i = function(a, b) {
  return naturalCompare(('' + a).toLowerCase(), ('' + b).toLowerCase());
};

Object.defineProperties(naturalCompare, {
  alphabet: {
    get: function() {
      return alphabet;
    },
    set: function(value) {
      alphabet = value;
      alphabetIndexMap = [];
      var i = 0;
      if (alphabet) {
        for (; i < alphabet.length; i++) {
          alphabetIndexMap[alphabet.charCodeAt(i)] = i;
        }
      }
      alphabetIndexMapLength = alphabetIndexMap.length;
      for (i = 0; i < alphabetIndexMapLength; i++) {
        if (alphabetIndexMap[i] === undefined) {
          alphabetIndexMap[i] = -1;
        }
      }
    },
  },
});

module.exports = naturalCompare;


/***/ }),
/* 19 */
/***/ (function(module, exports) {

module.exports = function(text, pattern, options) {
    // Aproximately where in the text is the pattern expected to be found?
    var Match_Location = options.location || 0;

    //Determines how close the match must be to the fuzzy location (specified above). An exact letter match which is 'distance' characters away from the fuzzy location would score as a complete mismatch. A distance of '0' requires the match be at the exact location specified, a threshold of '1000' would require a perfect match to be within 800 characters of the fuzzy location to be found using a 0.8 threshold.
    var Match_Distance = options.distance || 100;

    // At what point does the match algorithm give up. A threshold of '0.0' requires a perfect match (of both letters and location), a threshold of '1.0' would match anything.
    var Match_Threshold = options.threshold || 0.4;

    if (pattern === text) return true; // Exact match
    if (pattern.length > 32) return false; // This algorithm cannot be used

    // Set starting location at beginning text and initialise the alphabet.
    var loc = Match_Location,
        s = (function() {
            var q = {},
                i;

            for (i = 0; i < pattern.length; i++) {
                q[pattern.charAt(i)] = 0;
            }

            for (i = 0; i < pattern.length; i++) {
                q[pattern.charAt(i)] |= 1 << (pattern.length - i - 1);
            }

            return q;
        }());

    // Compute and return the score for a match with e errors and x location.
    // Accesses loc and pattern through being a closure.

    function match_bitapScore_(e, x) {
        var accuracy = e / pattern.length,
            proximity = Math.abs(loc - x);

        if (!Match_Distance) {
            // Dodge divide by zero error.
            return proximity ? 1.0 : accuracy;
        }
        return accuracy + (proximity / Match_Distance);
    }

    var score_threshold = Match_Threshold, // Highest score beyond which we give up.
        best_loc = text.indexOf(pattern, loc); // Is there a nearby exact match? (speedup)

    if (best_loc != -1) {
        score_threshold = Math.min(match_bitapScore_(0, best_loc), score_threshold);
        // What about in the other direction? (speedup)
        best_loc = text.lastIndexOf(pattern, loc + pattern.length);

        if (best_loc != -1) {
            score_threshold = Math.min(match_bitapScore_(0, best_loc), score_threshold);
        }
    }

    // Initialise the bit arrays.
    var matchmask = 1 << (pattern.length - 1);
    best_loc = -1;

    var bin_min, bin_mid;
    var bin_max = pattern.length + text.length;
    var last_rd;
    for (var d = 0; d < pattern.length; d++) {
        // Scan for the best match; each iteration allows for one more error.
        // Run a binary search to determine how far from 'loc' we can stray at this
        // error level.
        bin_min = 0;
        bin_mid = bin_max;
        while (bin_min < bin_mid) {
            if (match_bitapScore_(d, loc + bin_mid) <= score_threshold) {
                bin_min = bin_mid;
            } else {
                bin_max = bin_mid;
            }
            bin_mid = Math.floor((bin_max - bin_min) / 2 + bin_min);
        }
        // Use the result from this iteration as the maximum for the next.
        bin_max = bin_mid;
        var start = Math.max(1, loc - bin_mid + 1);
        var finish = Math.min(loc + bin_mid, text.length) + pattern.length;

        var rd = Array(finish + 2);
        rd[finish + 1] = (1 << d) - 1;
        for (var j = finish; j >= start; j--) {
            // The alphabet (s) is a sparse hash, so the following line generates
            // warnings.
            var charMatch = s[text.charAt(j - 1)];
            if (d === 0) {    // First pass: exact match.
                rd[j] = ((rd[j + 1] << 1) | 1) & charMatch;
            } else {    // Subsequent passes: fuzzy match.
                rd[j] = (((rd[j + 1] << 1) | 1) & charMatch) |
                                (((last_rd[j + 1] | last_rd[j]) << 1) | 1) |
                                last_rd[j + 1];
            }
            if (rd[j] & matchmask) {
                var score = match_bitapScore_(d, j - 1);
                // This match will almost certainly be better than any existing match.
                // But check anyway.
                if (score <= score_threshold) {
                    // Told you so.
                    score_threshold = score;
                    best_loc = j - 1;
                    if (best_loc > loc) {
                        // When passing loc, don't exceed our current distance from loc.
                        start = Math.max(1, 2 * loc - best_loc);
                    } else {
                        // Already passed loc, downhill from here on in.
                        break;
                    }
                }
            }
        }
        // No hope for a (better) match at greater error levels.
        if (match_bitapScore_(d + 1, loc) > score_threshold) {
            break;
        }
        last_rd = rd;
    }

    return (best_loc < 0) ? false : true;
};


/***/ })
/******/ ]);
/*!
 * Lightbox for Bootstrap by @ashleydw
 * https://github.com/ashleydw/lightbox
 *
 * License: https://github.com/ashleydw/lightbox/blob/master/LICENSE
 */
+function ($) {

'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var Lightbox = (function ($) {

	var NAME = 'ekkoLightbox';
	var JQUERY_NO_CONFLICT = $.fn[NAME];

	var Default = {
		title: '',
		footer: '',
		maxWidth: 9999,
		maxHeight: 9999,
		showArrows: true, //display the left / right arrows or not
		wrapping: true, //if true, gallery loops infinitely
		type: null, //force the lightbox into image / youtube mode. if null, or not image|youtube|vimeo; detect it
		alwaysShowClose: false, //always show the close button, even if there is no title
		loadingMessage: '<div class="ekko-lightbox-loader"><div><div></div><div></div></div></div>', // http://tobiasahlin.com/spinkit/
		leftArrow: '<span>&#10094;</span>',
		rightArrow: '<span>&#10095;</span>',
		strings: {
			close: 'Close',
			fail: 'Failed to load image:',
			type: 'Could not detect remote target type. Force the type using data-type'
		},
		doc: document, // if in an iframe can specify top.document
		onShow: function onShow() {},
		onShown: function onShown() {},
		onHide: function onHide() {},
		onHidden: function onHidden() {},
		onNavigate: function onNavigate() {},
		onContentLoaded: function onContentLoaded() {}
	};

	var Lightbox = (function () {
		_createClass(Lightbox, null, [{
			key: 'Default',

			/**
       Class properties:
   	 _$element: null -> the <a> element currently being displayed
    _$modal: The bootstrap modal generated
       _$modalDialog: The .modal-dialog
       _$modalContent: The .modal-content
       _$modalBody: The .modal-body
       _$modalHeader: The .modal-header
       _$modalFooter: The .modal-footer
    _$lightboxContainerOne: Container of the first lightbox element
    _$lightboxContainerTwo: Container of the second lightbox element
    _$lightboxBody: First element in the container
    _$modalArrows: The overlayed arrows container
   	 _$galleryItems: Other <a>'s available for this gallery
    _galleryName: Name of the current data('gallery') showing
    _galleryIndex: The current index of the _$galleryItems being shown
   	 _config: {} the options for the modal
    _modalId: unique id for the current lightbox
    _padding / _border: CSS properties for the modal container; these are used to calculate the available space for the content
   	 */

			get: function get() {
				return Default;
			}
		}]);

		function Lightbox($element, config) {
			var _this = this;

			_classCallCheck(this, Lightbox);

			this._config = $.extend({}, Default, config);
			this._$modalArrows = null;
			this._galleryIndex = 0;
			this._galleryName = null;
			this._padding = null;
			this._border = null;
			this._titleIsShown = false;
			this._footerIsShown = false;
			this._wantedWidth = 0;
			this._wantedHeight = 0;
			this._touchstartX = 0;
			this._touchendX = 0;

			this._modalId = 'ekkoLightbox-' + Math.floor(Math.random() * 1000 + 1);
			this._$element = $element instanceof jQuery ? $element : $($element);

			this._isBootstrap3 = $.fn.modal.Constructor.VERSION[0] == 3;

			var h4 = '<h4 class="modal-title">' + (this._config.title || "&nbsp;") + '</h4>';
			var btn = '<button type="button" class="close" data-dismiss="modal" aria-label="' + this._config.strings.close + '"><span aria-hidden="true">&times;</span></button>';

			var header = '<div class="modal-header' + (this._config.title || this._config.alwaysShowClose ? '' : ' hide') + '">' + (this._isBootstrap3 ? btn + h4 : h4 + btn) + '</div>';
			var footer = '<div class="modal-footer' + (this._config.footer ? '' : ' hide') + '">' + (this._config.footer || "&nbsp;") + '</div>';
			var body = '<div class="modal-body"><div class="ekko-lightbox-container"><div class="ekko-lightbox-item fade in show"></div><div class="ekko-lightbox-item fade"></div></div></div>';
			var dialog = '<div class="modal-dialog" role="document"><div class="modal-content">' + header + body + footer + '</div></div>';
			$(this._config.doc.body).append('<div id="' + this._modalId + '" class="ekko-lightbox modal fade" tabindex="-1" tabindex="-1" role="dialog" aria-hidden="true">' + dialog + '</div>');

			this._$modal = $('#' + this._modalId, this._config.doc);
			this._$modalDialog = this._$modal.find('.modal-dialog').first();
			this._$modalContent = this._$modal.find('.modal-content').first();
			this._$modalBody = this._$modal.find('.modal-body').first();
			this._$modalHeader = this._$modal.find('.modal-header').first();
			this._$modalFooter = this._$modal.find('.modal-footer').first();

			this._$lightboxContainer = this._$modalBody.find('.ekko-lightbox-container').first();
			this._$lightboxBodyOne = this._$lightboxContainer.find('> div:first-child').first();
			this._$lightboxBodyTwo = this._$lightboxContainer.find('> div:last-child').first();

			this._border = this._calculateBorders();
			this._padding = this._calculatePadding();

			this._galleryName = this._$element.data('gallery');
			if (this._galleryName) {
				this._$galleryItems = $(document.body).find('*[data-gallery="' + this._galleryName + '"]');
				this._galleryIndex = this._$galleryItems.index(this._$element);
				$(document).on('keydown.ekkoLightbox', this._navigationalBinder.bind(this));

				// add the directional arrows to the modal
				if (this._config.showArrows && this._$galleryItems.length > 1) {
					this._$lightboxContainer.append('<div class="ekko-lightbox-nav-overlay"><a href="#">' + this._config.leftArrow + '</a><a href="#">' + this._config.rightArrow + '</a></div>');
					this._$modalArrows = this._$lightboxContainer.find('div.ekko-lightbox-nav-overlay').first();
					this._$lightboxContainer.on('click', 'a:first-child', function (event) {
						event.preventDefault();
						return _this.navigateLeft();
					});
					this._$lightboxContainer.on('click', 'a:last-child', function (event) {
						event.preventDefault();
						return _this.navigateRight();
					});
					this.updateNavigation();
				}
			}

			this._$modal.on('show.bs.modal', this._config.onShow.bind(this)).on('shown.bs.modal', function () {
				_this._toggleLoading(true);
				_this._handle();
				return _this._config.onShown.call(_this);
			}).on('hide.bs.modal', this._config.onHide.bind(this)).on('hidden.bs.modal', function () {
				if (_this._galleryName) {
					$(document).off('keydown.ekkoLightbox');
					$(window).off('resize.ekkoLightbox');
				}
				_this._$modal.remove();
				return _this._config.onHidden.call(_this);
			}).modal(this._config);

			$(window).on('resize.ekkoLightbox', function () {
				_this._resize(_this._wantedWidth, _this._wantedHeight);
			});
			this._$lightboxContainer.on('touchstart', function () {
				_this._touchstartX = event.changedTouches[0].screenX;
			}).on('touchend', function () {
				_this._touchendX = event.changedTouches[0].screenX;
				_this._swipeGesure();
			});
		}

		_createClass(Lightbox, [{
			key: 'element',
			value: function element() {
				return this._$element;
			}
		}, {
			key: 'modal',
			value: function modal() {
				return this._$modal;
			}
		}, {
			key: 'navigateTo',
			value: function navigateTo(index) {

				if (index < 0 || index > this._$galleryItems.length - 1) return this;

				this._galleryIndex = index;

				this.updateNavigation();

				this._$element = $(this._$galleryItems.get(this._galleryIndex));
				this._handle();
			}
		}, {
			key: 'navigateLeft',
			value: function navigateLeft() {

				if (!this._$galleryItems) return;

				if (this._$galleryItems.length === 1) return;

				if (this._galleryIndex === 0) {
					if (this._config.wrapping) this._galleryIndex = this._$galleryItems.length - 1;else return;
				} else //circular
					this._galleryIndex--;

				this._config.onNavigate.call(this, 'left', this._galleryIndex);
				return this.navigateTo(this._galleryIndex);
			}
		}, {
			key: 'navigateRight',
			value: function navigateRight() {

				if (!this._$galleryItems) return;

				if (this._$galleryItems.length === 1) return;

				if (this._galleryIndex === this._$galleryItems.length - 1) {
					if (this._config.wrapping) this._galleryIndex = 0;else return;
				} else //circular
					this._galleryIndex++;

				this._config.onNavigate.call(this, 'right', this._galleryIndex);
				return this.navigateTo(this._galleryIndex);
			}
		}, {
			key: 'updateNavigation',
			value: function updateNavigation() {
				if (!this._config.wrapping) {
					var $nav = this._$lightboxContainer.find('div.ekko-lightbox-nav-overlay');
					if (this._galleryIndex === 0) $nav.find('a:first-child').addClass('disabled');else $nav.find('a:first-child').removeClass('disabled');

					if (this._galleryIndex === this._$galleryItems.length - 1) $nav.find('a:last-child').addClass('disabled');else $nav.find('a:last-child').removeClass('disabled');
				}
			}
		}, {
			key: 'close',
			value: function close() {
				return this._$modal.modal('hide');
			}

			// helper private methods
		}, {
			key: '_navigationalBinder',
			value: function _navigationalBinder(event) {
				event = event || window.event;
				if (event.keyCode === 39) return this.navigateRight();
				if (event.keyCode === 37) return this.navigateLeft();
			}

			// type detection private methods
		}, {
			key: '_detectRemoteType',
			value: function _detectRemoteType(src, type) {

				type = type || false;

				if (!type && this._isImage(src)) type = 'image';
				if (!type && this._getYoutubeId(src)) type = 'youtube';
				if (!type && this._getVimeoId(src)) type = 'vimeo';
				if (!type && this._getInstagramId(src)) type = 'instagram';

				if (!type || ['image', 'youtube', 'vimeo', 'instagram', 'video', 'url'].indexOf(type) < 0) type = 'url';

				return type;
			}
		}, {
			key: '_isImage',
			value: function _isImage(string) {
				return string && string.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i);
			}
		}, {
			key: '_containerToUse',
			value: function _containerToUse() {
				var _this2 = this;

				// if currently showing an image, fade it out and remove
				var $toUse = this._$lightboxBodyTwo;
				var $current = this._$lightboxBodyOne;

				if (this._$lightboxBodyTwo.hasClass('in')) {
					$toUse = this._$lightboxBodyOne;
					$current = this._$lightboxBodyTwo;
				}

				$current.removeClass('in show');
				setTimeout(function () {
					if (!_this2._$lightboxBodyTwo.hasClass('in')) _this2._$lightboxBodyTwo.empty();
					if (!_this2._$lightboxBodyOne.hasClass('in')) _this2._$lightboxBodyOne.empty();
				}, 500);

				$toUse.addClass('in show');
				return $toUse;
			}
		}, {
			key: '_handle',
			value: function _handle() {

				var $toUse = this._containerToUse();
				this._updateTitleAndFooter();

				var currentRemote = this._$element.attr('data-remote') || this._$element.attr('href');
				var currentType = this._detectRemoteType(currentRemote, this._$element.attr('data-type') || false);

				if (['image', 'youtube', 'vimeo', 'instagram', 'video', 'url'].indexOf(currentType) < 0) return this._error(this._config.strings.type);

				switch (currentType) {
					case 'image':
						this._preloadImage(currentRemote, $toUse);
						this._preloadImageByIndex(this._galleryIndex, 3);
						break;
					case 'youtube':
						this._showYoutubeVideo(currentRemote, $toUse);
						break;
					case 'vimeo':
						this._showVimeoVideo(this._getVimeoId(currentRemote), $toUse);
						break;
					case 'instagram':
						this._showInstagramVideo(this._getInstagramId(currentRemote), $toUse);
						break;
					case 'video':
						this._showHtml5Video(currentRemote, $toUse);
						break;
					default:
						// url
						this._loadRemoteContent(currentRemote, $toUse);
						break;
				}

				return this;
			}
		}, {
			key: '_getYoutubeId',
			value: function _getYoutubeId(string) {
				if (!string) return false;
				var matches = string.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/);
				return matches && matches[2].length === 11 ? matches[2] : false;
			}
		}, {
			key: '_getVimeoId',
			value: function _getVimeoId(string) {
				return string && string.indexOf('vimeo') > 0 ? string : false;
			}
		}, {
			key: '_getInstagramId',
			value: function _getInstagramId(string) {
				return string && string.indexOf('instagram') > 0 ? string : false;
			}

			// layout private methods
		}, {
			key: '_toggleLoading',
			value: function _toggleLoading(show) {
				show = show || false;
				if (show) {
					this._$modalDialog.css('display', 'none');
					this._$modal.removeClass('in show');
					$('.modal-backdrop').append(this._config.loadingMessage);
				} else {
					this._$modalDialog.css('display', 'block');
					this._$modal.addClass('in show');
					$('.modal-backdrop').find('.ekko-lightbox-loader').remove();
				}
				return this;
			}
		}, {
			key: '_calculateBorders',
			value: function _calculateBorders() {
				return {
					top: this._totalCssByAttribute('border-top-width'),
					right: this._totalCssByAttribute('border-right-width'),
					bottom: this._totalCssByAttribute('border-bottom-width'),
					left: this._totalCssByAttribute('border-left-width')
				};
			}
		}, {
			key: '_calculatePadding',
			value: function _calculatePadding() {
				return {
					top: this._totalCssByAttribute('padding-top'),
					right: this._totalCssByAttribute('padding-right'),
					bottom: this._totalCssByAttribute('padding-bottom'),
					left: this._totalCssByAttribute('padding-left')
				};
			}
		}, {
			key: '_totalCssByAttribute',
			value: function _totalCssByAttribute(attribute) {
				return parseInt(this._$modalDialog.css(attribute), 10) + parseInt(this._$modalContent.css(attribute), 10) + parseInt(this._$modalBody.css(attribute), 10);
			}
		}, {
			key: '_updateTitleAndFooter',
			value: function _updateTitleAndFooter() {
				var title = this._$element.data('title') || "";
				var caption = this._$element.data('footer') || "";

				this._titleIsShown = false;
				if (title || this._config.alwaysShowClose) {
					this._titleIsShown = true;
					this._$modalHeader.css('display', '').find('.modal-title').html(title || "&nbsp;");
				} else this._$modalHeader.css('display', 'none');

				this._footerIsShown = false;
				if (caption) {
					this._footerIsShown = true;
					this._$modalFooter.css('display', '').html(caption);
				} else this._$modalFooter.css('display', 'none');

				return this;
			}
		}, {
			key: '_showYoutubeVideo',
			value: function _showYoutubeVideo(remote, $containerForElement) {
				var id = this._getYoutubeId(remote);
				var query = remote.indexOf('&') > 0 ? remote.substr(remote.indexOf('&')) : '';
				var width = this._$element.data('width') || 560;
				var height = this._$element.data('height') || width / (560 / 315);
				return this._showVideoIframe('//www.youtube.com/embed/' + id + '?badge=0&autoplay=1&html5=1' + query, width, height, $containerForElement);
			}
		}, {
			key: '_showVimeoVideo',
			value: function _showVimeoVideo(id, $containerForElement) {
				var width = this._$element.data('width') || 500;
				var height = this._$element.data('height') || width / (560 / 315);
				return this._showVideoIframe(id + '?autoplay=1', width, height, $containerForElement);
			}
		}, {
			key: '_showInstagramVideo',
			value: function _showInstagramVideo(id, $containerForElement) {
				// instagram load their content into iframe's so this can be put straight into the element
				var width = this._$element.data('width') || 612;
				var height = width + 80;
				id = id.substr(-1) !== '/' ? id + '/' : id; // ensure id has trailing slash
				$containerForElement.html('<iframe width="' + width + '" height="' + height + '" src="' + id + 'embed/" frameborder="0" allowfullscreen></iframe>');
				this._resize(width, height);
				this._config.onContentLoaded.call(this);
				if (this._$modalArrows) //hide the arrows when showing video
					this._$modalArrows.css('display', 'none');
				this._toggleLoading(false);
				return this;
			}
		}, {
			key: '_showVideoIframe',
			value: function _showVideoIframe(url, width, height, $containerForElement) {
				// should be used for videos only. for remote content use loadRemoteContent (data-type=url)
				height = height || width; // default to square
				$containerForElement.html('<div class="embed-responsive embed-responsive-16by9"><iframe width="' + width + '" height="' + height + '" src="' + url + '" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe></div>');
				this._resize(width, height);
				this._config.onContentLoaded.call(this);
				if (this._$modalArrows) this._$modalArrows.css('display', 'none'); //hide the arrows when showing video
				this._toggleLoading(false);
				return this;
			}
		}, {
			key: '_showHtml5Video',
			value: function _showHtml5Video(url, $containerForElement) {
				// should be used for videos only. for remote content use loadRemoteContent (data-type=url)
				var width = this._$element.data('width') || 560;
				var height = this._$element.data('height') || width / (560 / 315);
				$containerForElement.html('<div class="embed-responsive embed-responsive-16by9"><video width="' + width + '" height="' + height + '" src="' + url + '" preload="auto" autoplay controls class="embed-responsive-item"></video></div>');
				this._resize(width, height);
				this._config.onContentLoaded.call(this);
				if (this._$modalArrows) this._$modalArrows.css('display', 'none'); //hide the arrows when showing video
				this._toggleLoading(false);
				return this;
			}
		}, {
			key: '_loadRemoteContent',
			value: function _loadRemoteContent(url, $containerForElement) {
				var _this3 = this;

				var width = this._$element.data('width') || 560;
				var height = this._$element.data('height') || 560;

				var disableExternalCheck = this._$element.data('disableExternalCheck') || false;
				this._toggleLoading(false);

				// external urls are loading into an iframe
				// local ajax can be loaded into the container itself
				if (!disableExternalCheck && !this._isExternal(url)) {
					$containerForElement.load(url, $.proxy(function () {
						return _this3._$element.trigger('loaded.bs.modal');l;
					}));
				} else {
					$containerForElement.html('<iframe src="' + url + '" frameborder="0" allowfullscreen></iframe>');
					this._config.onContentLoaded.call(this);
				}

				if (this._$modalArrows) //hide the arrows when remote content
					this._$modalArrows.css('display', 'none');

				this._resize(width, height);
				return this;
			}
		}, {
			key: '_isExternal',
			value: function _isExternal(url) {
				var match = url.match(/^([^:\/?#]+:)?(?:\/\/([^\/?#]*))?([^?#]+)?(\?[^#]*)?(#.*)?/);
				if (typeof match[1] === "string" && match[1].length > 0 && match[1].toLowerCase() !== location.protocol) return true;

				if (typeof match[2] === "string" && match[2].length > 0 && match[2].replace(new RegExp(':(' + ({
					"http:": 80,
					"https:": 443
				})[location.protocol] + ')?$'), "") !== location.host) return true;

				return false;
			}
		}, {
			key: '_error',
			value: function _error(message) {
				console.error(message);
				this._containerToUse().html(message);
				this._resize(300, 300);
				return this;
			}
		}, {
			key: '_preloadImageByIndex',
			value: function _preloadImageByIndex(startIndex, numberOfTimes) {

				if (!this._$galleryItems) return;

				var next = $(this._$galleryItems.get(startIndex), false);
				if (typeof next == 'undefined') return;

				var src = next.attr('data-remote') || next.attr('href');
				if (next.attr('data-type') === 'image' || this._isImage(src)) this._preloadImage(src, false);

				if (numberOfTimes > 0) return this._preloadImageByIndex(startIndex + 1, numberOfTimes - 1);
			}
		}, {
			key: '_preloadImage',
			value: function _preloadImage(src, $containerForImage) {
				var _this4 = this;

				$containerForImage = $containerForImage || false;

				var img = new Image();
				if ($containerForImage) {
					(function () {

						// if loading takes > 200ms show a loader
						var loadingTimeout = setTimeout(function () {
							$containerForImage.append(_this4._config.loadingMessage);
						}, 200);

						img.onload = function () {
							if (loadingTimeout) clearTimeout(loadingTimeout);
							loadingTimeout = null;
							var image = $('<img />');
							image.attr('src', img.src);
							image.addClass('img-fluid');

							// backward compatibility for bootstrap v3
							image.css('width', '100%');

							$containerForImage.html(image);
							if (_this4._$modalArrows) _this4._$modalArrows.css('display', ''); // remove display to default to css property

							_this4._resize(img.width, img.height);
							_this4._toggleLoading(false);
							return _this4._config.onContentLoaded.call(_this4);
						};
						img.onerror = function () {
							_this4._toggleLoading(false);
							return _this4._error(_this4._config.strings.fail + ('  ' + src));
						};
					})();
				}

				img.src = src;
				return img;
			}
		}, {
			key: '_swipeGesure',
			value: function _swipeGesure() {
				if (this._touchendX < this._touchstartX) {
					return this.navigateRight();
				}
				if (this._touchendX > this._touchstartX) {
					return this.navigateLeft();
				}
			}
		}, {
			key: '_resize',
			value: function _resize(width, height) {

				height = height || width;
				this._wantedWidth = width;
				this._wantedHeight = height;

				var imageAspecRatio = width / height;

				// if width > the available space, scale down the expected width and height
				var widthBorderAndPadding = this._padding.left + this._padding.right + this._border.left + this._border.right;

				// force 10px margin if window size > 575px
				var addMargin = this._config.doc.body.clientWidth > 575 ? 20 : 0;
				var discountMargin = this._config.doc.body.clientWidth > 575 ? 0 : 20;

				var maxWidth = Math.min(width + widthBorderAndPadding, this._config.doc.body.clientWidth - addMargin, this._config.maxWidth);

				if (width + widthBorderAndPadding > maxWidth) {
					height = (maxWidth - widthBorderAndPadding - discountMargin) / imageAspecRatio;
					width = maxWidth;
				} else width = width + widthBorderAndPadding;

				var headerHeight = 0,
				    footerHeight = 0;

				// as the resize is performed the modal is show, the calculate might fail
				// if so, default to the default sizes
				if (this._footerIsShown) footerHeight = this._$modalFooter.outerHeight(true) || 55;

				if (this._titleIsShown) headerHeight = this._$modalHeader.outerHeight(true) || 67;

				var borderPadding = this._padding.top + this._padding.bottom + this._border.bottom + this._border.top;

				//calculated each time as resizing the window can cause them to change due to Bootstraps fluid margins
				var margins = parseFloat(this._$modalDialog.css('margin-top')) + parseFloat(this._$modalDialog.css('margin-bottom'));

				var maxHeight = Math.min(height, $(window).height() - borderPadding - margins - headerHeight - footerHeight, this._config.maxHeight - borderPadding - headerHeight - footerHeight);

				if (height > maxHeight) {
					// if height > the available height, scale down the width
					width = Math.ceil(maxHeight * imageAspecRatio) + widthBorderAndPadding;
				}

				this._$lightboxContainer.css('height', maxHeight);
				this._$modalDialog.css('flex', 1).css('maxWidth', width);

				var modal = this._$modal.data('bs.modal');
				if (modal) {
					// v4 method is mistakenly protected
					try {
						modal._handleUpdate();
					} catch (Exception) {
						modal.handleUpdate();
					}
				}
				return this;
			}
		}], [{
			key: '_jQueryInterface',
			value: function _jQueryInterface(config) {
				var _this5 = this;

				config = config || {};
				return this.each(function () {
					var $this = $(_this5);
					var _config = $.extend({}, Lightbox.Default, $this.data(), typeof config === 'object' && config);

					new Lightbox(_this5, _config);
				});
			}
		}]);

		return Lightbox;
	})();

	$.fn[NAME] = Lightbox._jQueryInterface;
	$.fn[NAME].Constructor = Lightbox;
	$.fn[NAME].noConflict = function () {
		$.fn[NAME] = JQUERY_NO_CONFLICT;
		return Lightbox._jQueryInterface;
	};

	return Lightbox;
})(jQuery);
//# sourceMappingURL=ekko-lightbox.js.map

}(jQuery);


/**
 * Module containing core application logic.
 * @param  {jQuery} $        Insulated jQuery object
 * @param  {JSON} settings Insulated `window.snipeit.settings` object.
 * @return {IIFE}          Immediately invoked. Returns self.
 */

lineOptions = {

        legend: {
            position: "bottom"
        },
        scales: {
            yAxes: [{
                ticks: {
                    fontColor: "rgba(0,0,0,0.5)",
                    fontStyle: "bold",
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    padding: 20
                },
                gridLines: {
                    drawTicks: false,
                    display: false
                }
            }],
            xAxes: [{
                gridLines: {
                    zeroLineColor: "transparent"
                },
                ticks: {
                    padding: 20,
                    fontColor: "rgba(0,0,0,0.5)",
                    fontStyle: "bold"
                }
            }]
        }

};

pieOptions = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: "#fff",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: "easeOutBounce",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,

    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li>" +
    "<i class='fa fa-circle-o' style='color: <%=segments[i].fillColor%>'></i>" +
    "<%if(segments[i].label){%><%=segments[i].label%><%}%> foo</li><%}%></ul>",
    //String - A tooltip template
    tooltipTemplate: "<%=value %> <%=label%> "
};

//-----------------
//- END PIE CHART -
//-----------------

var baseUrl = $('meta[name="baseUrl"]').attr('content');

(function($, settings) {
    var Components = {};
    Components.modals = {};

    // confirm delete modal
    Components.modals.confirmDelete = function() {
        var $el = $('table');

        var events = {
            'click': function(evnt) {
                var $context = $(this);
                var $dataConfirmModal = $('#dataConfirmModal');
                var href = $context.attr('href');
                var message = $context.attr('data-content');
                var title = $context.attr('data-title');

                $('#myModalLabel').text(title);
                $dataConfirmModal.find('.modal-body').text(message);
                $('#deleteForm').attr('action', href);
                $dataConfirmModal.modal({
                    show: true
                });
                return false;
            }
        };

        var render = function() {
            $el.on('click', '.delete-asset', events['click']);
        };

        return {
            render: render
        };
    };


    /**
     * Application start point
     * Component definition stays out of load event, execution only happens.
     */
    $(function() {
        new Components.modals.confirmDelete().render();
    });
}(jQuery, window.snipeit.settings));

$(document).ready(function () {

    /*
    * Slideout help menu
    */
     $('.slideout-menu-toggle').on('click', function(event){
        event.preventDefault();
        // create menu variables
        var slideoutMenu = $('.slideout-menu');
        var slideoutMenuWidth = $('.slideout-menu').width();

        // toggle open class
        slideoutMenu.toggleClass("open");

        // slide menu
        if (slideoutMenu.hasClass("open")) {
         slideoutMenu.show();
            slideoutMenu.animate({
                right: "0px"
            });
        } else {
            slideoutMenu.animate({
                right: -slideoutMenuWidth
            }, "-350px");
         slideoutMenu.fadeOut();
        }
     });

     /*
     * iCheck checkbox plugin
     */

     $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
         checkboxClass: 'icheckbox_minimal-blue',
         radioClass: 'iradio_minimal-blue'
     });


     /*
     * Select2
     */

     var iOS = /iPhone|iPad|iPod/.test(navigator.userAgent)  && !window.MSStream;
     if(!iOS)
     {
        // Vue collision: Avoid overriding a vue select2 instance
        // by checking to see if the item has already been select2'd.
        $('select.select2:not(".select2-hidden-accessible")').each(function (i,obj) {
            {
                $(obj).select2();
            }
        });
     }

    // $('.datepicker').datepicker();
    // var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
    // $.fn.bootstrapDP = datepicker;
    // $('.datepicker').datepicker();

    // Crazy select2 rich dropdowns with images!
    $('.js-data-ajax').each( function (i,item) {
        var link = $(item);
        var endpoint = link.data("endpoint");
        var select = link.data("select");

        link.select2({

            /**
             * Adds an empty placeholder, allowing every select2 instance to be cleared.
             * This placeholder can be overridden with the "data-placeholder" attribute.
             */
            placeholder: '',
            allowClear: true,
            
            ajax: {

                // the baseUrl includes a trailing slash
                url: Ziggy.baseUrl + 'api/v1/' + endpoint + '/selectlist',
                dataType: 'json',
                delay: 250,
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: function (params) {
                    var data = {
                        search: params.term,
                        page: params.page || 1,
                        assetStatusType: link.data("asset-status-type"),
                    };
                    return data;
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;

                    var answer =  {
                        results: data.items,
                        pagination: {
                            more: "true" //(params.page  < data.page_count)
                        }
                    };

                    return answer;
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            templateResult: formatDatalist,
            templateSelection: formatDataSelection
        });

    });

	function getSelect2Value(element) {
		
		// if the passed object is not a jquery object, assuming 'element' is a selector
		if (!(element instanceof jQuery)) element = $(element);

		var select = element.data("select2");

		// There's two different locations where the select2-generated input element can be. 
		searchElement = select.dropdown.$search || select.$container.find(".select2-search__field");

		var value = searchElement.val();
		return value;
	}
	
	$(".select2-hidden-accessible").on('select2:selecting', function (e) {
		var data = e.params.args.data;
		var isMouseUp = false;
		var element = $(this);
		var value = getSelect2Value(element);
		
		if(e.params.args.originalEvent) isMouseUp = e.params.args.originalEvent.type == "mouseup";
		
		// if selected item does not match typed text, do not allow it to pass - force close for ajax.
		if(!isMouseUp) {
			if(value.toLowerCase() && data.text.toLowerCase().indexOf(value) < 0) {
				e.preventDefault();

				element.select2('close');
				
			// if it does match, we set a flag in the event (which gets passed to subsequent events), telling it not to worry about the ajax
			} else if(value.toLowerCase() && data.text.toLowerCase().indexOf(value) > -1) {
				e.params.args.noForceAjax = true;
			}
		}
	});
	
	$(".select2-hidden-accessible").on('select2:closing', function (e) {
		var element = $(this);
		var value = getSelect2Value(element);
		var noForceAjax = false;
		var isMouseUp = false;
		if(e.params.args.originalSelect2Event) noForceAjax = e.params.args.originalSelect2Event.noForceAjax;
		if(e.params.args.originalEvent) isMouseUp = e.params.args.originalEvent.type == "mouseup";
		
		if(value && !noForceAjax && !isMouseUp) {
			var endpoint = element.data("endpoint");
			var assetStatusType = element.data("asset-status-type");
			$.ajax({
				url: Ziggy.baseUrl + 'api/v1/' + endpoint + '/selectlist?search='+value+'&page=1' + (assetStatusType ? '&assetStatusType='+assetStatusType : ''),
				dataType: 'json',
				headers: {
					"X-Requested-With": 'XMLHttpRequest',
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(response) {
				var currentlySelected = element.select2('data').map(function (x){ 
                    return +x.id;
                }).filter(function (x) {
                    return x !== 0;
                });
				
				// makes sure we're not selecting the same thing twice for multiples
				var filteredResponse = response.items.filter(function(item) {
					return currentlySelected.indexOf(+item.id) < 0;
				});

				var first = (currentlySelected.length > 0) ? filteredResponse[0] : response.items[0];
				
				if(first && first.id) {
					first.selected = true;
					
					if($("option[value='" + first.id + "']", element).length < 1) {
						var option = new Option(first.text, first.id, true, true);
						element.append(option);
					} else {
						var isMultiple = element.attr("multiple") == "multiple";
						element.val(isMultiple? element.val().concat(first.id) : element.val(first.id));
					}
					element.trigger('change');

					element.trigger({
						type: 'select2:select',
						params: {
							data: first
						}
					});
				}
			});
		}
	});

    function formatDatalist (datalist) {
        var loading_markup = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
        if (datalist.loading) {
            return loading_markup;
        }

        var markup = "<div class='clearfix'>" ;
        markup +="<div class='pull-left' style='padding-right: 10px;'>";
        if (datalist.image) {
            markup += "<div style='width: 30px;'><img src='" + datalist.image + "' style='max-height: 20px; max-width: 30px;' alt='" +  datalist.text + "'></div>";
        } else {
            markup += "<div style='height: 20px; width: 30px;'></div>";
        }

        markup += "</div><div>" + datalist.text + "</div>";
        markup += "</div>";
        return markup;
    }

    function formatDataSelection (datalist) {
        // This a heinous workaround for a known bug in Select2.
        // Without this, the rich selectlists are vulnerable to XSS.
        // Many thanks to @uberbrady for this fix. It ain't pretty,
        // but it resolves the issue until Select2 addresses it on their end.
        //
        // Bug was reported in 2016 :{
        // https://github.com/select2/select2/issues/4587

        return datalist.text.replace(/>/g, '&gt;')
            .replace(/</g, '&lt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // This handles the radio button selectors for the checkout-to-foo options
    // on asset checkout and also on asset edit
    $(function() {
        $('input[name=checkout_to_type]').on("change",function () {
            var assignto_type = $('input[name=checkout_to_type]:checked').val();
            var userid = $('#assigned_user option:selected').val();

            if (assignto_type == 'asset') {
                $('#current_assets_box').fadeOut();
                $('#assigned_asset').show();
                $('#assigned_user').hide();
                $('#assigned_location').hide();
                $('.notification-callout').fadeOut();

            } else if (assignto_type == 'location') {
                $('#current_assets_box').fadeOut();
                $('#assigned_asset').hide();
                $('#assigned_user').hide();
                $('#assigned_location').show();
                $('.notification-callout').fadeOut();
            } else  {

                $('#assigned_asset').hide();
                $('#assigned_user').show();
                $('#assigned_location').hide();
                if (userid) {
                    $('#current_assets_box').fadeIn();
                }
                $('.notification-callout').fadeIn();

            }
        });
    });


    // ------------------------------------------------
    // Deep linking for Bootstrap tabs
    // ------------------------------------------------
    var taburl = document.location.toString();

    // Allow full page URL to activate a tab's ID
    // ------------------------------------------------
    // This allows linking to a tab on page load via the address bar.
    // So a URL such as, http://snipe-it.local/hardware/2/#my_tab will
    // cause the tab on that page with an ID of “my_tab” to be active.
    if (taburl.match('#') ) {
        $('.nav-tabs a[href="#'+taburl.split('#')[1]+'"]').tab('show');
    }

    // Allow internal page links to activate a tab's ID.
    // ------------------------------------------------
    // This allows you to link to a tab from anywhere on the page
    // including from within another tab. Also note that internal page
    // links either inside or out of the tabs need to include data-toggle="tab"
    // Ex: <a href="#my_tab" data-toggle="tab">Click me</a>
    $('a[data-toggle="tab"]').click(function (e) {
        var href = $(this).attr("href");
        history.pushState(null, null, href);
        e.preventDefault();
        $('a[href="' + $(this).attr('href') + '"]').tab('show');
    });

    // ------------------------------------------------
    // End Deep Linking for Bootstrap tabs
    // ------------------------------------------------



    // Image preview
    function readURL(input, $preview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $preview.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function formatBytes(bytes) {
        if(bytes < 1024) return bytes + " Bytes";
        else if(bytes < 1048576) return(bytes / 1024).toFixed(2) + " KB";
        else if(bytes < 1073741824) return(bytes / 1048576).toFixed(2) + " MB";
        else return(bytes / 1073741824).toFixed(2) + " GB";
    }

     // File size validation
    $('.js-uploadFile').bind('change', function() {
        let $this = $(this);
        let id = '#' + $this.attr('id');
        let status = id + '-status';
        let $status = $(status);
        $status.removeClass('text-success').removeClass('text-danger');
        $(status + ' .goodfile').remove();
        $(status + ' .badfile').remove();
        $(status + ' .previewSize').hide();
        $(id + '-info').html('');

        var max_size = $this.data('maxsize');
        var total_size = 0;

        for (var i = 0; i < this.files.length; i++) {
            total_size += this.files[i].size;
            $(id + '-info').append('<span class="label label-default">' + this.files[i].name + ' (' + formatBytes(this.files[i].size) + ')</span> ');
        }

        if (total_size > max_size) {
            $status.addClass('text-danger').removeClass('help-block').prepend('<i class="badfile fa fa-times"></i> ').append('<span class="previewSize"> Upload is ' + formatBytes(total_size) + '.</span>');
        } else {
            $status.addClass('text-success').removeClass('help-block').prepend('<i class="goodfile fa fa-check"></i> ');
            let $preview =  $(id + '-imagePreview');
            readURL(this, $preview);
            $preview.fadeIn();
        }


    });

});


/**
 * Toggle disabled
 */
(function($){
		
    $.fn.toggleDisabled = function(callback){
        return this.each(function(){
            var disabled, $this = $(this);
            if($this.attr('disabled')){
                $this.removeAttr('disabled');
                disabled = false;
            } else {
                $this.attr('disabled', 'disabled');
                disabled = true;
            }

            if(callback && typeof callback === 'function'){
                callback(this, disabled);
            }
        });
    };
    
})(jQuery);
/* 
 * 
 * Snipe-IT Universal Modal support
 * 
 * Enables modal dialogs to create sub-resources throughout Snipe-IT
 * 
 */

 /* 
 HOW TO USE

 Create a Button looking like this:

 <a href='{{ route('modal.user') }}' data-toggle="modal"  data-target="#createModal" data-select='assigned_to' class="btn btn-sm btn-primary">New</a>

 If you don't have access to Blade commands (like {{ and }}, etc), you can hard-code a URL as the 'href'

 data-toggle="modal" - required for Bootstrap Modals
 data-target="#createModal" - fixed ID for the modal, do not change
 data-select="assigned_to" - What is the *ID* of the select-dropdown that you're going to be adding to, if the modal-create was a success? Be on the lookout for duplicate ID's, it will confuse this library!
 class="btn btn-sm btn-primary" - makes it look button-ey, feel free to change :)
 
 If you want to pass additional variables to the modal (In the Category Create one, for example, you can pass category_id), you can encode them as URL variables in the href
 
 */

$(function () {


  //handle modal-add-interstitial calls
  var model, select, refreshSelector;

  if($('#createModal').length == 0) {
    $('body').append('<div class="modal fade" id="createModal"></div><!-- /.modal -->');
  }

  $('#createModal').on("show.bs.modal", function (event) {
      var link = $(event.relatedTarget);
      model = link.data("dependency");
      select = link.data("select");
      refreshSelector = link.data("refresh");
      
      $('#createModal').load(link.attr('href'),function () {
        //do we need to re-select2 this, after load? Probably.
        $('#createModal').find('select.select2').select2();
        // Initialize the ajaxy select2 with images.
        // This is a copy/paste of the code from snipeit.js, would be great to only have this in one place.
        $('.js-data-ajax').each( function (i,item) {
            var link = $(item);
            var endpoint = link.data("endpoint");
            var select = link.data("select");

            link.select2({
                ajax: {

                    // the baseUrl includes a trailing slash
                    url: Ziggy.baseUrl + 'api/v1/' + endpoint + '/selectlist',
                    dataType: 'json',
                    delay: 250,
                    headers: {
                        "X-Requested-With": 'XMLHttpRequest',
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (params) {
                        var data = {
                            search: params.term,
                            page: params.page || 1,
                            assetStatusType: link.data("asset-status-type"),
                        };
                        return data;
                    },
                    processResults: function (data, params) {

                        params.page = params.page || 1;

                        var answer =  {
                            results: data.items,
                            pagination: {
                                more: "true" //(params.page  < data.page_count)
                            }
                        };

                        return answer;
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                templateResult: formatDatalist,
                templateSelection: formatDataSelection
            });
        });
      });

  });

 

  $('#createModal').on('click','#modal-save', function () {
    $.ajax({
        type: 'POST',
        url: $('.modal-body form').attr('action'),
        headers: {
            "X-Requested-With": 'XMLHttpRequest',
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },

        data: $('.modal-body form').serialize(),
        success: function (result) {

            if(result.status == "error") {
                var error_message="";
                for(var field in result.messages) {
                    error_message += "<li>Problem(s) with field <i><strong>" + field + "</strong></i>: " + result.messages[field];

                }
                $('#modal_error_msg').html(error_message).show();
                return false;
            }
            var id = result.payload.id;
            var name = result.payload.name || (result.payload.first_name + " " + result.payload.last_name);
            if(!id || !name) {
                console.error("Could not find resulting name or ID from modal-create. Name: "+name+", id: "+id);
                return false;
            }
            $('#createModal').modal('hide');
            $('#createModal').html("");

            var refreshTable = $('#' + refreshSelector);

            if(refreshTable.length > 0) {
                refreshTable.bootstrapTable('refresh');
            }

            // "select" is the original drop-down menu that someone
            // clicked 'add' on to add a new 'thing'
            // this code adds the newly created object to that select
            var selector = document.getElementById(select);

            if(!selector) {
                return false;
            }

            selector.options[selector.length] = new Option(name, id);
            selector.selectedIndex = selector.length - 1;
            $(selector).trigger("change");
            if(window.fetchCustomFields) {
                fetchCustomFields();
            }

        },
        error: function (result) {
            msg = result.responseJSON.messages || result.responseJSON.error;
            $('#modal_error_msg').html("Server Error: "+msg).show();
        }



    });
  });
});

function formatDatalist (datalist) {
    var loading_markup = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
    if (datalist.loading) {
        return loading_markup;
    }

    var markup = "<div class='clearfix'>" ;
    markup +="<div class='pull-left' style='padding-right: 10px;'>";
    if (datalist.image) {
        markup += "<div style='width: 30px;'><img src='" + datalist.image + "' alt='"+ datalist.tex + "' style='max-height: 20px; max-width: 30px;'></div>";
    } else {
        markup += "<div style='height: 20px; width: 30px;'></div>";
    }

    markup += "</div><div>" + datalist.text + "</div>";
    markup += "</div>";
    return markup;
}

function formatDataSelection (datalist) {
    return datalist.text.replace(/>/g, '&gt;')
        .replace(/</g, '&lt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
