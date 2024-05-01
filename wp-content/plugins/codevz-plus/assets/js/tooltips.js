var $jscomp$this=this;!function(e,a){"function"==typeof define&&define.amd?define([],a):"object"==typeof module&&module.exports?module.exports=a():e.anime=a()}(this,function(){function e(e){if(!Y.col(e))try{return document.querySelectorAll(e)}catch(e){}}function a(e){return e.reduce(function(e,t){return e.concat(Y.arr(t)?a(t):t)},[])}function t(a){return Y.arr(a)?a:(Y.str(a)&&(a=e(a)||a),a instanceof NodeList||a instanceof HTMLCollection?[].slice.call(a):[a])}function n(e,a){return e.some(function(e){return e===a})}function i(e){var a,t={};for(a in e)t[a]=e[a];return t}function r(e,a){var t,n=i(e);for(t in e)n[t]=a.hasOwnProperty(t)?a[t]:e[t];return n}function u(e,a){var t,n=i(e);for(t in a)n[t]=Y.und(e[t])?a[t]:e[t];return n}function s(e){if(e=/([\+\-]?[0-9#\.]+)(%|px|pt|em|rem|in|cm|mm|ex|pc|vw|vh|deg|rad|turn)?/.exec(e))return e[2]}function o(e,a){return Y.fnc(e)?e(a.target,a.id,a.total):e}function l(e,a){if(a in e.style)return getComputedStyle(e).getPropertyValue(a.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase())||"0"}function d(e,a){return Y.dom(e)&&n(w,a)?"transform":Y.dom(e)&&(e.getAttribute(a)||Y.svg(e)&&e[a])?"attribute":Y.dom(e)&&"transform"!==a&&l(e,a)?"css":null!=e[a]?"object":void 0}function c(e,a){switch(d(e,a)){case"transform":return function(e,a){var t=function(e){return-1<e.indexOf("translate")?"px":-1<e.indexOf("rotate")||-1<e.indexOf("skew")?"deg":void 0}(a);if(t=-1<a.indexOf("scale")?1:0+t,!(e=e.style.transform))return t;for(var n=[],i=[],r=[],u=/(\w+)\((.+?)\)/g;n=u.exec(e);)i.push(n[1]),r.push(n[2]);return(e=r.filter(function(e,t){return i[t]===a})).length?e[0]:t}(e,a);case"css":return l(e,a);case"attribute":return e.getAttribute(a)}return e[a]||0}function g(e,a){var t=/^(\*=|\+=|-=)/.exec(e);if(!t)return e;switch(a=parseFloat(a),e=parseFloat(e.replace(t[0],"")),t[0][0]){case"+":return a+e;case"-":return a-e;case"*":return a*e}}function p(e){return Y.obj(e)&&e.hasOwnProperty("totalLength")}function v(e,a){function t(t){return t=void 0===t?0:t,e.el.getPointAtLength(1<=a+t?a+t:0)}var n=t(),i=t(-1),r=t(1);switch(e.property){case"x":return n.x;case"y":return n.y;case"angle":return 180*Math.atan2(r.y-i.y,r.x-i.x)/Math.PI}}function f(e,a){var t=/-?\d*\.?\d+/g;if(e=p(e)?e.totalLength:e,Y.col(e))a=Y.rgb(e)?e:Y.hex(e)?function(e){e=e.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,a,t,n){return a+a+t+t+n+n});var a=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return"rgb("+(e=parseInt(a[1],16))+","+parseInt(a[2],16)+","+(a=parseInt(a[3],16))+")"}(e):Y.hsl(e)?function(e){function a(e,a,t){return 0>t&&(t+=1),1<t&&--t,t<1/6?e+6*(a-e)*t:.5>t?a:t<2/3?e+(a-e)*(2/3-t)*6:e}var t=/hsl\((\d+),\s*([\d.]+)%,\s*([\d.]+)%\)/g.exec(e);e=parseInt(t[1])/360;var n=parseInt(t[2])/100;if(t=parseInt(t[3])/100,0==n)n=t=e=t;else{var i=.5>t?t*(1+n):t+n-t*n,r=2*t-i;n=a(r,i,e+1/3),t=a(r,i,e),e=a(r,i,e-1/3)}return"rgb("+255*n+","+255*t+","+255*e+")"}(e):void 0;else{var n=s(e);e=n?e.substr(0,e.length-n.length):e,a=a?e+a:e}return{original:a+="",numbers:a.match(t)?a.match(t).map(Number):[0],strings:a.split(t)}}function h(e,a){return a.reduce(function(a,t,n){return a+e[n-1]+t})}function y(e){return(e?a(Y.arr(e)?e.map(t):t(e)):[]).filter(function(e,a,t){return t.indexOf(e)===a})}function O(e,a){var n=i(a);if(Y.arr(e)){var r=e.length;2!==r||Y.obj(e[0])?Y.fnc(a.duration)||(n.duration=a.duration/r):e={value:e}}return t(e).map(function(e,t){return t=t?0:a.delay,e=Y.obj(e)&&!p(e)?e:{value:e},Y.und(e.delay)&&(e.delay=t),e}).map(function(e){return u(e,n)})}function m(e,a){var t;return e.tweens.map(function(n){var i=(n=function(e,a){var t,n={};for(t in e){var i=o(e[t],a);Y.arr(i)&&1===(i=i.map(function(e){return o(e,a)})).length&&(i=i[0]),n[t]=i}return n.duration=parseFloat(n.duration),n.delay=parseFloat(n.delay),n}(n,a)).value,r=c(a.target,e.name),u=t?t.to.original:r,l=(u=Y.arr(i)?i[0]:u,g(Y.arr(i)?i[1]:i,u));r=s(l)||s(u)||s(r);return n.isPath=p(i),n.from=f(u,r),n.to=f(l,r),n.start=t?t.end:e.offset,n.end=n.start+n.delay+n.duration,n.easing=function(e){return Y.arr(e)?L.apply(this,e):C[e]}(n.easing),n.elasticity=(1e3-Math.min(Math.max(n.elasticity,1),999))/1e3,Y.col(n.from.original)&&(n.round=1),t=n})}function Q(e,t){return a(e.map(function(e){return t.map(function(a){var t=d(e.target,a.name);if(t){var n=m(a,e);a={type:t,property:a.name,animatable:e,tweens:n,duration:n[n.length-1].end,delay:n[0].delay}}else a=void 0;return a})})).filter(function(e){return!Y.und(e)})}function b(e,a,t){var n="delay"===e?Math.min:Math.max;return a.length?n.apply(Math,a.map(function(a){return a[e]})):t[e]}function M(e){var a,t=r(E,e),n=r(D,e),i=function(e){var a=y(e);return a.map(function(e,t){return{target:e,id:t,total:a.length}})}(e.targets),s=[],o=u(t,n);for(a in e)o.hasOwnProperty(a)||"targets"===a||s.push({name:a,offset:o.offset,tweens:O(e[a],n)});return u(t,{animatables:i,animations:e=Q(i,s),duration:b("duration",e,n),delay:b("delay",e,n)})}function I(e){function a(){return window.Promise&&new Promise(function(e){return c=e})}function t(e){return p.reversed?p.duration-e:e}function n(e){for(var a=0,t={},n=p.animations,i={};a<n.length;){var r=n[a],u=r.animatable,s=r.tweens;i.tween=s.filter(function(a){return e<a.end})[0]||s[s.length-1],i.isPath$0=i.tween.isPath,i.round=i.tween.round,i.eased=i.tween.easing(Math.min(Math.max(e-i.tween.start-i.tween.delay,0),i.tween.duration)/i.tween.duration,i.tween.elasticity),s=h(i.tween.to.numbers.map(function(e){return function(a,t){return a=(t=e.isPath$0?0:e.tween.from.numbers[t])+e.eased*(a-t),e.isPath$0&&(a=v(e.tween.value,a)),e.round&&(a=Math.round(a*e.round)/e.round),a}}(i)),i.tween.to.strings),S[r.type](u.target,r.property,s,t,u.id),r.currentValue=s,a++,i={isPath$0:i.isPath$0,tween:i.tween,eased:i.eased,round:i.round}}if(t)for(var o in t)x||(x=l(document.body,"transform")?"transform":"-webkit-transform"),p.animatables[o].target.style[x]=t[o].join(" ");p.currentTime=e,p.progress=e/p.duration*100}function i(e){p[e]&&p[e](p)}function r(){p.remaining&&!0!==p.remaining&&p.remaining--}function u(e){var u=p.duration,l=p.offset,v=p.delay,f=p.currentTime,h=p.reversed,y=t(e);if((y=Math.min(Math.max(y,0),u))>l&&y<u?(n(y),!p.began&&y>=v&&(p.began=!0,i("begin")),i("run")):(y<=l&&0!==f&&(n(0),h&&r()),y>=u&&f!==u&&(n(u),h||r())),e>=u&&(p.remaining?(o=s,"alternate"===p.direction&&(p.reversed=!p.reversed)):(p.pause(),c(),g=a(),p.completed||(p.completed=!0,i("complete"))),d=0),p.children)for(e=p.children,u=0;u<e.length;u++)e[u].seek(y);i("update")}e=void 0===e?{}:e;var s,o,d=0,c=null,g=a(),p=M(e);return p.reset=function(){var e=p.direction,a=p.loop;p.currentTime=0,p.progress=0,p.paused=!0,p.began=!1,p.completed=!1,p.reversed="reverse"===e,p.remaining="alternate"===e&&1===a?2:a},p.tick=function(e){s=e,o||(o=s),u((d+s-o)*I.speed)},p.seek=function(e){u(t(e))},p.pause=function(){var e=X.indexOf(p);-1<e&&X.splice(e,1),p.paused=!0},p.play=function(){p.paused&&(p.paused=!1,o=0,d=p.completed?0:t(p.currentTime),X.push(p),A||F())},p.reverse=function(){p.reversed=!p.reversed,o=0,d=t(p.currentTime)},p.restart=function(){p.pause(),p.reset(),p.play()},p.finished=g,p.reset(),p.autoplay&&p.play(),p}var x,E={update:void 0,begin:void 0,run:void 0,complete:void 0,loop:1,direction:"normal",autoplay:!0,offset:0},D={duration:1e3,delay:0,easing:"easeOutElastic",elasticity:500,round:0},w="translateX translateY translateZ rotate rotateX rotateY rotateZ scale scaleX scaleY scaleZ skewX skewY".split(" "),Y={arr:function(e){return Array.isArray(e)},obj:function(e){return-1<Object.prototype.toString.call(e).indexOf("Object")},svg:function(e){return e instanceof SVGElement},dom:function(e){return e.nodeType||Y.svg(e)},str:function(e){return"string"==typeof e},fnc:function(e){return"function"==typeof e},und:function(e){return void 0===e},hex:function(e){return/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(e)},rgb:function(e){return/^rgb/.test(e)},hsl:function(e){return/^hsl/.test(e)},col:function(e){return Y.hex(e)||Y.rgb(e)||Y.hsl(e)}},L=function(){function e(e,a,t){return(((1-3*t+3*a)*e+(3*t-6*a))*e+3*a)*e}return function(a,t,n,i){if(0<=a&&1>=a&&0<=n&&1>=n){var r=new Float32Array(11);if(a!==t||n!==i)for(var u=0;11>u;++u)r[u]=e(.1*u,a,n);return function(u){if(a===t&&n===i)return u;if(0===u)return 0;if(1===u)return 1;for(var s=0,o=1;10!==o&&r[o]<=u;++o)s+=.1;o=s+(u-r[--o])/(r[o+1]-r[o])*.1;var l=3*(1-3*n+3*a)*o*o+2*(3*n-6*a)*o+3*a;if(.001<=l){for(s=0;4>s&&0!==(l=3*(1-3*n+3*a)*o*o+2*(3*n-6*a)*o+3*a);++s){var d=e(o,a,n)-u;o=o-d/l}u=o}else if(0===l)u=o;else{o=s,s=s+.1;var c=0;do{0<(l=e(d=o+(s-o)/2,a,n)-u)?s=d:o=d}while(1e-7<Math.abs(l)&&10>++c);u=d}return e(u,t,i)}}}}(),C=function(){function e(e,a){return 0===e||1===e?e:-Math.pow(2,10*(e-1))*Math.sin(2*(e-1-a/(2*Math.PI)*Math.asin(1))*Math.PI/a)}var a,t="Quad Cubic Quart Quint Sine Expo Circ Back Elastic".split(" "),n={In:[[.55,.085,.68,.53],[.55,.055,.675,.19],[.895,.03,.685,.22],[.755,.05,.855,.06],[.47,0,.745,.715],[.95,.05,.795,.035],[.6,.04,.98,.335],[.6,-.28,.735,.045],e],Out:[[.25,.46,.45,.94],[.215,.61,.355,1],[.165,.84,.44,1],[.23,1,.32,1],[.39,.575,.565,1],[.19,1,.22,1],[.075,.82,.165,1],[.175,.885,.32,1.275],function(a,t){return 1-e(1-a,t)}],InOut:[[.455,.03,.515,.955],[.645,.045,.355,1],[.77,0,.175,1],[.86,0,.07,1],[.445,.05,.55,.95],[1,0,0,1],[.785,.135,.15,.86],[.68,-.55,.265,1.55],function(a,t){return.5>a?e(2*a,t)/2:1-e(-2*a+2,t)/2}]},i={linear:L(.25,.25,.75,.75)},r={};for(a in n)r.type=a,n[r.type].forEach(function(e){return function(a,n){i["ease"+e.type+t[n]]=Y.fnc(a)?a:L.apply($jscomp$this,a)}}(r)),r={type:r.type};return i}(),S={css:function(e,a,t){return e.style[a]=t},attribute:function(e,a,t){return e.setAttribute(a,t)},object:function(e,a,t){return e[a]=t},transform:function(e,a,t,n,i){n[i]||(n[i]=[]),n[i].push(a+"("+t+")")}},X=[],A=0,F=function(){function e(){A=requestAnimationFrame(a)}function a(a){var t=X.length;if(t){for(var n=0;n<t;)X[n]&&X[n].tick(a),n++;e()}else cancelAnimationFrame(A),A=0}return e}();return I.version="2.0.1",I.speed=1,I.running=X,I.remove=function(e){e=y(e);for(var a=X.length-1;0<=a;a--)for(var t=X[a],i=t.animations,r=i.length-1;0<=r;r--)n(e,i[r].animatable.target)&&(i.splice(r,1),i.length||t.pause())},I.getValue=c,I.path=function(a,t){var n=Y.str(a)?e(a)[0]:a,i=t||100;return function(e){return{el:n,property:e,totalLength:n.getTotalLength()*(i/100)}}},I.setDashoffset=function(e){var a=e.getTotalLength();return e.setAttribute("stroke-dasharray",a),a},I.bezier=L,I.easings=C,I.timeline=function(e){var a=I(e);return a.duration=0,a.children=[],a.add=function(e){return t(e).forEach(function(e){var t=e.offset,n=a.duration;e.autoplay=!1,e.offset=Y.und(t)?n:g(t,n),(e=I(e)).duration>n&&(a.duration=e.duration),a.children.push(e)}),a},a},I.random=function(e,a){return Math.floor(Math.random()*(a-e+1))+e},I}),function(e){"undefined"==typeof module?this.charming=e:module.exports=e}(function(e,a){"use strict";var t=(a=a||{}).tagName||"span",n=null!=a.classPrefix?a.classPrefix:"char",i=1,r=function(e){for(var a=e.parentNode,r=e.nodeValue,u=r.length,s=-1;++s<u;){var o=document.createElement(t);n&&(o.className=n+i,i++),o.appendChild(document.createTextNode(r[s])),a.insertBefore(o,e)}a.removeChild(e)};return function e(a){for(var t=[].slice.call(a.childNodes),n=t.length,i=-1;++i<n;)e(t[i]);a.nodeType===Node.TEXT_NODE&&r(a)}(e),e});{const e={cora:{in:{base:{duration:600,easing:"easeOutQuint",scale:[0,1],rotate:[-180,0],opacity:{value:1,easing:"linear",duration:100}},content:{duration:300,delay:250,easing:"easeOutQuint",translateY:[20,0],opacity:{value:1,easing:"linear",duration:100}},trigger:{duration:300,easing:"easeOutExpo",scale:[1,.9],color:"#6fbb95"}},out:{base:{duration:150,delay:50,easing:"easeInQuad",scale:0,opacity:{delay:100,value:0,easing:"linear"}},content:{duration:100,easing:"easeInQuad",translateY:20,opacity:{value:0,easing:"linear"}},trigger:{duration:300,delay:50,easing:"easeOutExpo",scale:1,color:"#666"}}},smaug:{in:{base:{duration:200,easing:"easeOutQuad",rotate:[35,0],opacity:{value:1,easing:"linear",duration:100}},content:{duration:1e3,delay:50,easing:"easeOutElastic",translateX:[50,0],rotate:[10,0],opacity:{value:1,easing:"linear",duration:100}},trigger:{translateX:[{value:"-30%",duration:130,easing:"easeInQuad"},{value:["30%","0%"],duration:900,easing:"easeOutElastic"}],opacity:[{value:0,duration:130,easing:"easeInQuad"},{value:1,duration:130,easing:"easeOutQuad"}],color:[{value:"#6fbb95",duration:1,delay:130,easing:"easeOutQuad"}]}},out:{base:{duration:200,delay:100,easing:"easeInQuad",rotate:-35,opacity:0},content:{duration:200,easing:"easeInQuad",translateX:-30,rotate:-10,opacity:0},trigger:{translateX:[{value:"-30%",duration:200,easing:"easeInQuad"},{value:["30%","0%"],duration:200,easing:"easeOutQuad"}],opacity:[{value:0,duration:200,easing:"easeInQuad"},{value:1,duration:200,easing:"easeOutQuad"}],color:[{value:"#666",duration:1,delay:200,easing:"easeOutQuad"}]}}},uldor:{in:{base:{duration:400,easing:"easeOutExpo",scale:[.5,1],opacity:{value:1,easing:"linear",duration:100}},path:{duration:900,easing:"easeOutElastic",d:"M 33.5,31 C 33.5,31 145,31 200,31 256,31 367,31 367,31 367,31 367,110 367,150 367,190 367,269 367,269 367,269 256,269 200,269 145,269 33.5,269 33.5,269 33.5,269 33.5,190 33.5,150 33.5,110 33.5,31 33.5,31 Z"},content:{duration:900,easing:"easeOutElastic",delay:100,scale:[.8,1],opacity:{value:1,easing:"linear",duration:100}},trigger:{translateY:[{value:"-50%",duration:100,easing:"easeInQuad"},{value:["50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#6fbb95",duration:1,delay:100,easing:"easeOutQuad"}}},out:{base:{duration:200,easing:"easeInExpo",scale:.5,opacity:{value:0,duration:75,easing:"linear"}},path:{duration:200,easing:"easeOutQuint",d:"M 79.5,66 C 79.5,66 128,106 202,105 276,104 321,66 321,66 321,66 287,84 288,155 289,226 318,232 318,232 318,232 258,198 200,198 142,198 80.5,230 80.5,230 80.5,230 112,222 111,152 110,82 79.5,66 79.5,66 Z"},content:{duration:100,easing:"easeOutQuint",scale:.8,opacity:{value:0,duration:50,easing:"linear"}},trigger:{translateY:[{value:"50%",duration:100,easing:"easeInQuad"},{value:["-50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#666",duration:1,delay:100,easing:"easeOutQuad"}}}},dori:{in:{base:{duration:800,easing:"easeOutElastic",translateY:[60,0],scale:[.5,1],opacity:{value:1,easing:"linear",duration:100}},path:{duration:1200,delay:50,easing:"easeOutElastic",elasticity:700,d:"M 22,74.2 22,202 C 22,202 82,202 103,202 124,202 184,202 184,202 L 200,219 216,202 C 216,202 274,202 297,202 320,202 378,202 378,202 L 378,74.2 C 378,74.2 318,73.7 200,73.7 82,73.7 22,74.2 22,74.2 Z"},content:{duration:300,delay:100,easing:"easeOutQuint",translateY:[20,0],opacity:{value:1,easing:"linear",duration:100}},trigger:{translateY:[{value:"-50%",duration:100,easing:"easeInQuad"},{value:["50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#6fbb95",duration:1,delay:100,easing:"easeOutQuad"}}},out:{base:{duration:200,easing:"easeInQuad",translateY:60,scale:.5,opacity:{value:0,delay:100,duration:100,easing:"linear"}},path:{duration:200,easing:"easeInQuad",d:"M 22,108 22,236 C 22,236 64,216 103,212 142,208 184,212 184,212 L 200,229 216,212 C 216,212 258,207 297,212 336,217 378,236 378,236 L 378,108 C 378,108 318,83.7 200,83.7 82,83.7 22,108 22,108 Z"},content:{duration:100,easing:"easeInQuad",translateY:20,opacity:{value:0,easing:"linear"}},trigger:{translateY:[{value:"-50%",duration:100,easing:"easeInQuad"},{value:["50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#666",duration:1,delay:100,easing:"easeOutQuad"}}}},walda:{in:{base:{duration:100,easing:"linear",opacity:1},deco:{duration:500,easing:"easeOutExpo",scaleY:[0,1]},content:{duration:125,easing:"easeOutExpo",delay:function(e,a){return 15*a},easing:"linear",translateY:["50%","0%"],opacity:[0,1]},trigger:{translateX:[{value:"30%",duration:100,easing:"easeInQuad"},{value:["-30%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:[{value:"#6fbb95",duration:1,delay:100,easing:"easeOutQuad"}]}},out:{base:{duration:100,delay:100,easing:"linear",opacity:0},deco:{duration:400,easing:"easeOutExpo",scaleY:0},content:{duration:1,easing:"linear",opacity:0},trigger:{translateX:[{value:"30%",duration:100,easing:"easeInQuad"},{value:["-30%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:[{value:"#666",duration:1,delay:100,easing:"easeOutQuad"}]}}},gram:{in:{base:{duration:400,easing:"easeOutQuint",scaleX:[1.2,1],opacity:{value:1,easing:"linear",duration:50}},path:{duration:600,easing:"easeOutQuint",d:"M 92.4,79 C 136,79 156,79.1 200,79.4 244,79.7 262,79 308,79 354,79 381,111 381,150 381,189 346,220 308,221 270,222 236,221 200,221 164,221 130,222 92.4,221 54.4,220 19,189 19,150 19,111 48.6,79 92.4,79 Z"},content:{delay:100,scale:{value:[.8,1],duration:300,easing:"easeOutQuint"},opacity:{value:[0,1],easing:"linear",duration:100}},trigger:{duration:300,easing:"easeOutQuint",scale:[1,.9],color:"#6fbb95"}},out:{base:{duration:200,easing:"easeInQuint",scaleX:1.1,scaleY:.9,opacity:{value:0,delay:100,duration:150,easing:"linear"}},path:{duration:200,easing:"easeInQuint",d:"M 92.4,79 C 136,79 154,115 200,116 246,117 263,80.4 308,79 353,77.6 381,111 381,150 381,189 346,220 308,221 270,222 236,188 200,188 164,188 130,222 92.4,221 54.4,220 19,189 19,150 19,111 48.6,79 92.4,79 Z"},content:{duration:150,easing:"easeInQuint",scale:.8,opacity:{value:0,duration:100,easing:"linear"}},trigger:{duration:200,easing:"easeInQuint",scale:1,color:"#666"}}},narvi:{in:{base:{duration:1,easing:"linear",opacity:1},path:{duration:800,easing:"easeOutQuint",rotate:[0,90],opacity:{value:1,duration:200,easing:"linear"}},content:{duration:600,easing:"easeOutQuint",translateX:[50,0],opacity:{value:1,duration:100,easing:"linear"}},trigger:{translateX:[{value:"-30%",duration:100,easing:"easeInQuint"},{value:["30%","0%"],duration:250,easing:"easeOutQuint"}],opacity:[{value:0,duration:100,easing:"easeInQuint"},{value:1,duration:250,easing:"easeOutQuint"}],color:[{value:"#6fbb95",duration:1,delay:100,easing:"easeOutQuint"}]}},out:{base:{duration:100,delay:400,easing:"linear",opacity:0},path:{duration:500,delay:0,easing:"easeInOutQuint",rotate:0,opacity:{value:0,duration:50,delay:210,easing:"linear"}},content:{duration:500,easing:"easeInOutQuint",translateX:100,opacity:{value:0,duration:50,delay:210,easing:"linear"}},trigger:{translateX:[{value:"30%",duration:200,easing:"easeInQuint"},{value:["-30%","0%"],duration:200,easing:"easeOutQuint"}],opacity:[{value:0,duration:200,easing:"easeInQuint"},{value:1,duration:200,easing:"easeOutQuint"}],color:[{value:"#666",duration:1,delay:200,easing:"easeOutQuint"}]}}},indis:{in:{base:{duration:500,easing:"easeOutQuint",translateY:[100,0],opacity:{value:1,duration:50,easing:"linear"}},shape:{duration:350,easing:"easeOutBack",scaleY:{value:[1.3,1],duration:1300,easing:"easeOutElastic",elasticity:500},scaleX:{value:[.3,1],duration:1300,easing:"easeOutElastic",elasticity:500}},path:{duration:450,easing:"easeInOutQuad",d:"M 44.5,24 C 148,24 252,24 356,24 367,24 376,32.9 376,44 L 376,256 C 376,267 367,276 356,276 252,276 148,276 44.5,276 33.4,276 24.5,267 24.5,256 L 24.5,44 C 24.5,32.9 33.4,24 44.5,24 Z"},content:{duration:300,delay:50,easing:"easeOutQuad",translateY:[10,0],opacity:{value:1,easing:"linear",duration:100}},trigger:{translateY:[{value:"-50%",duration:100,easing:"easeInQuad"},{value:["50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#6fbb95",duration:1,delay:100,easing:"easeOutQuad"}}},out:{base:{duration:320,delay:50,easing:"easeInOutQuint",scaleY:1.5,scaleX:0,translateY:-100,opacity:{value:0,duration:100,delay:130,easing:"linear"}},path:{duration:300,delay:50,easing:"easeInOutQuint",d:"M 44.5,24 C 138,4.47 246,-6.47 356,24 367,26.9 376,32.9 376,44 L 376,256 C 376,267 367,279 356,276 231,240 168,241 44.5,276 33.8,279 24.5,267 24.5,256 L 24.5,44 C 24.5,32.9 33.6,26.3 44.5,24 Z"},content:{duration:300,easing:"easeInOutQuad",translateY:-40,opacity:{value:0,duration:100,delay:135,easing:"linear"}},trigger:{translateY:[{value:"-50%",duration:100,easing:"easeInQuad"},{value:["50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#666",duration:1,delay:100,easing:"easeOutQuad"}}}},amras:{in:{base:{duration:1,delay:50,easing:"linear",opacity:1},path:{duration:800,delay:100,easing:"easeOutElastic",delay:function(e,a){return 20*a},scale:[0,1]},content:{duration:300,delay:250,easing:"easeOutExpo",scale:[.7,1],opacity:{value:1,easing:"linear",duration:100}},trigger:{translateY:[{value:"50%",duration:100,easing:"easeInQuad"},{value:["-50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#6fbb95",duration:1,delay:100,easing:"easeOutQuad"}}},out:{base:{duration:1,delay:450,easing:"linear",opacity:0},path:{duration:500,easing:"easeOutExpo",delay:function(e,a,t){return 40*(t-a-1)},scale:0},content:{duration:300,easing:"easeOutExpo",scale:.7,opacity:{value:0,duration:100,easing:"linear"}},trigger:{translateY:[{value:"-50%",duration:100,easing:"easeInQuad"},{value:["50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#666",duration:1,delay:100,easing:"easeOutQuad"}}}},hador:{in:{base:{duration:1,delay:100,easing:"linear",opacity:1},path:{duration:1e3,easing:"easeOutExpo",delay:function(e,a){return 150*a},scale:[0,1],translateY:function(e,a,t){return a===t-1?["50%","0%"]:0},rotate:function(e,a,t){return a===t-1?[90,0]:0}},content:{duration:600,delay:750,easing:"easeOutExpo",scale:[.5,1],opacity:{value:1,easing:"linear",duration:400}},trigger:{translateX:[{value:"30%",duration:200,easing:"easeInExpo"},{value:["-30%","0%"],duration:200,easing:"easeOutExpo"}],opacity:[{value:0,duration:200,easing:"easeInExpo"},{value:1,duration:200,easing:"easeOutExpo"}],color:[{value:"#6fbb95",duration:1,delay:200,easing:"easeOutExpo"}]}},out:{base:{duration:1,delay:450,easing:"linear",opacity:0},path:{duration:300,easing:"easeOutExpo",delay:function(e,a,t){return 50*(t-a-1)},scale:0},content:{duration:200,easing:"easeOutExpo",scale:.7,opacity:{value:0,duration:50,easing:"linear"}},trigger:{translateX:[{value:"30%",duration:100,easing:"easeInQuad"},{value:["-30%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:[{value:"#666",duration:1,delay:100,easing:"easeOutQuad"}]}}},malva:{in:{base:{translateX:[{value:3,duration:100,delay:150,easing:"linear"},{value:-3,duration:100,easing:"linear"},{value:3,duration:100,easing:"linear"},{value:-3,duration:100,easing:"linear"},{value:3,duration:100,easing:"linear"},{value:-3,duration:100,easing:"linear"},{value:3,duration:100,easing:"linear"},{value:-3,duration:100,easing:"linear"},{value:0,duration:100,easing:[.1,1,.3,1]}],translateY:[{value:-3,duration:100,delay:150,easing:"linear"},{value:3,duration:100,easing:"linear"},{value:-3,duration:100,easing:"linear"},{value:3,duration:100,easing:"linear"},{value:-3,duration:100,easing:"linear"},{value:3,duration:100,easing:"linear"},{value:-3,duration:100,easing:"linear"},{value:3,duration:100,easing:"linear"},{value:0,duration:100,easing:[.1,1,.3,1]}],scale:[{value:[0,1.1],duration:150,easing:[.1,1,.3,1]},{value:1.4,duration:800,easing:"linear"},{value:1,duration:150,easing:[.1,1,.3,1]}],opacity:{value:1,easing:"linear",duration:1}},content:{duration:100,easing:"linear",opacity:1},trigger:{duration:300,easing:"easeOutExpo",scale:[1,.9],color:"#6fbb95"}},out:{base:{duration:150,delay:50,easing:"easeInQuad",scale:0,opacity:{delay:100,value:0,easing:"linear"}},content:{duration:100,easing:"easeInQuad",opacity:{value:0,easing:"linear"}},trigger:{duration:300,delay:50,easing:"easeOutExpo",scale:1,color:"#666"}}},sadoc:{in:{base:{duration:1,delay:100,easing:"linear",opacity:1,translateY:{value:[-40,0],duration:800,easing:"easeOutElastic"}},path:{duration:600,easing:"easeInOutSine",strokeDashoffset:[anime.setDashoffset,0],fill:{duration:400,delay:500,easing:"linear"}},content:{duration:800,delay:420,easing:"easeOutElastic",translateY:[20,0],opacity:{value:1,easing:"linear",duration:100}},trigger:{translateY:[{value:"50%",duration:100,easing:"easeInQuad"},{value:["-50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#6fbb95",duration:1,delay:100,easing:"easeOutQuad"}}},out:{base:{duration:1,delay:400,easing:"linear",opacity:0},path:{duration:300,easing:"easeInOutSine",strokeDashoffset:anime.setDashoffset,fill:{duration:400,easing:"linear"}},content:{duration:200,easing:"easeOutExpo",translateY:20,opacity:{value:0,easing:"linear",duration:50}},trigger:{translateY:[{value:"50%",duration:100,easing:"easeInQuad"},{value:["-50%","0%"],duration:100,easing:"easeOutQuad"}],opacity:[{value:0,duration:100,easing:"easeInQuad"},{value:1,duration:100,easing:"easeOutQuad"}],color:{value:"#666",duration:1,delay:100,easing:"easeOutQuad"}}}}},a=Array.from(document.querySelectorAll(".tooltip"));class t{constructor(e){this.DOM={},this.DOM.el=e,this.type=this.DOM.el.getAttribute("data-type"),this.DOM.trigger=this.DOM.el.querySelector(".tooltip__trigger"),this.DOM.triggerSpan=this.DOM.el.querySelector(".tooltip__trigger-text"),this.DOM.base=this.DOM.el.querySelector(".tooltip__base"),this.DOM.shape=this.DOM.base.querySelector(".tooltip__shape"),this.DOM.shape&&(this.DOM.path=this.DOM.shape.childElementCount>1?Array.from(this.DOM.shape.querySelectorAll("path")):this.DOM.shape.querySelector("path")),this.DOM.deco=this.DOM.base.querySelector(".tooltip__deco"),this.DOM.content=this.DOM.base.querySelector(".tooltip__content"),this.DOM.letters=this.DOM.content.querySelector(".tooltip__letters"),this.DOM.letters&&(charming(this.DOM.letters),this.DOM.content=this.DOM.letters.querySelectorAll("span")),this.initEvents()}initEvents(){this.mouseenterFn=(()=>{this.mouseTimeout=setTimeout(()=>{this.isShown=!0,this.show()},75)}),this.mouseleaveFn=(()=>{clearTimeout(this.mouseTimeout),this.isShown&&(this.isShown=!1,this.hide())}),this.DOM.trigger.addEventListener("mouseenter",this.mouseenterFn),this.DOM.trigger.addEventListener("mouseleave",this.mouseleaveFn),this.DOM.trigger.addEventListener("touchstart",this.mouseenterFn),this.DOM.trigger.addEventListener("touchend",this.mouseleaveFn)}show(){this.animate("in")}hide(){this.animate("out")}animate(a){if(e[this.type][a].base){anime.remove(this.DOM.base);let t={targets:this.DOM.base};anime(Object.assign(t,e[this.type][a].base))}if(e[this.type][a].shape){anime.remove(this.DOM.shape);let t={targets:this.DOM.shape};anime(Object.assign(t,e[this.type][a].shape))}if(e[this.type][a].path){anime.remove(this.DOM.path);let t={targets:this.DOM.path};anime(Object.assign(t,e[this.type][a].path))}if(e[this.type][a].content){anime.remove(this.DOM.content);let t={targets:this.DOM.content};anime(Object.assign(t,e[this.type][a].content))}if(e[this.type][a].trigger){anime.remove(this.DOM.triggerSpan);let t={targets:this.DOM.triggerSpan};anime(Object.assign(t,e[this.type][a].trigger))}if(e[this.type][a].deco){anime.remove(this.DOM.deco);let t={targets:this.DOM.deco};anime(Object.assign(t,e[this.type][a].deco))}}destroy(){this.DOM.trigger.removeEventListener("mouseenter",this.mouseenterFn),this.DOM.trigger.removeEventListener("mouseleave",this.mouseleaveFn),this.DOM.trigger.removeEventListener("touchstart",this.mouseenterFn),this.DOM.trigger.removeEventListener("touchend",this.mouseleaveFn)}}(()=>a.forEach(e=>new t(e)))()}