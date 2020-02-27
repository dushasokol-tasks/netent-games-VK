/*! netent_gcc_fullscreen-notifications : 0.3.6 - Wed, 12 Dec 2018 11:59:24 GMT | (c) 2018  undefined | ISC | undefined */!function(n){var r={};function o(e){if(r[e])return r[e].exports;var t=r[e]={i:e,l:!1,exports:{}};return n[e].call(t.exports,t,t.exports,o),t.l=!0,t.exports}o.m=n,o.c=r,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(t,e){if(1&e&&(t=o(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)o.d(n,r,function(e){return t[e]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="",o(o.s=5)}([function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=function(){function e(e){this.Controller=e}return e.prototype.show=function(e){var n=this;if(this.View){this.View.show(e,function(){n.Controller.fullScreenShown();var e=document.querySelector(".coveo-small-close");e&&e.addEventListener("click",n.hide.bind(n));var t=document.querySelector(".coveo-modal-backdrop");t&&t.addEventListener("click",n.hide.bind(n)),document.addEventListener("keyup",function(e){27===e.keyCode&&n.hide()})})}},e.prototype.hide=function(){var e=this;this.View&&this.View.hide(function(){e.Controller.fullScreenClosed()})},e.prototype.setView=function(e){this.View=e},e}();t.FullScreenViewAdapter=r},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=function(){this.gameIsIdle=!1,this.showingFullScreen=!1,this.autoPlayActive=!1};t.FullScreenModel=r},function(N,O,P){
/*! netent_gcc_shared - Wed, 12 Dec 2018 11:33:37 GMT | (c) 2018  NetEnt AB (publ) | ISC | https://www.netent.com/ */
window,N.exports=function(n){var r={};function o(e){if(r[e])return r[e].exports;var t=r[e]={i:e,l:!1,exports:{}};return n[e].call(t.exports,t,t.exports,o),t.l=!0,t.exports}return o.m=n,o.c=r,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(t,e){if(1&e&&(t=o(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)o.d(n,r,function(e){return t[e]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="",o(o.s=11)}([function(ia,ja){var ka;ka=function(){return this}();try{ka=ka||Function("return this")()||eval("this")}catch(ia){"object"==typeof window&&(ka=window)}ia.exports=ka},function(e,t,n){"use strict";t.a=function(t){var n=this.constructor;return this.then(function(e){return n.resolve(t()).then(function(){return e})},function(e){return n.resolve(t()).then(function(){return n.reject(e)})})}},function(e,t){!function(){function e(e,t){t=t||{bubbles:!1,cancelable:!1,detail:void 0};var n=document.createEvent("CustomEvent");return n.initCustomEvent(e,t.bubbles,t.cancelable,t.detail),n}e.prototype=Event.prototype,window.CustomEvent=e}()},function(e,t,n){"use strict";var r,o;Object.defineProperty(t,"__esModule",{value:!0}),r=t.Enums||(t.Enums={}),(o=r.MessageType||(r.MessageType={}))[o.Toast=0]="Toast",o[o.Dialog=1]="Dialog"},function(e,t,n){"use strict";var r;Object.defineProperty(t,"__esModule",{value:!0}),(r=t.Constants||(t.Constants={})).GCC={CONNECT_PNS:"GCC.connectPNS",DISCONNECT_PNS:"GCC.disconnectPNS"},r.Game={AUTOPLAY_STARTED:"Game.autoPlayStarted",AUTOPLAY_STOPPED:"Game.autoPlayStopped",GAME_RESOURCES_REQUEST:"Game.gameResourcesRequest",GAME_RESOURCES_RESPONSE:"Game.gameResourcesResponse",IDLE:"Game.idle",NOT_IDLE:"Game.notIdle",ROUND_ENDED:"Game.roundEnded",USER_INPUT_END:"Game.userInputEnd"},r.Notification={HIDE_MESSAGE:"Notification.hideMessage",RENDER_MESSAGE:"Notification.renderMessage",SEND_MESSAGE:"Notification.addMessageToQueue",SET_DIALOG_VIEW:"Notification.setDialogView",SET_FULLSCREEN_VIEW:"Notification.setFullscreenView",SET_TOAST_VIEW:"Notification.setToastView",SHOW_MESSAGE:"Notification.showMessage",SHOW_NEXT_TOAST:"Notification.showNextToastMessage"}},function(e,t){!function(e){"use strict";if(!e.fetch){var u={searchParams:"URLSearchParams"in e,iterable:"Symbol"in e&&"iterator"in Symbol,blob:"FileReader"in e&&"Blob"in e&&function(){try{return new Blob,!0}catch(e){return!1}}(),formData:"FormData"in e,arrayBuffer:"ArrayBuffer"in e};if(u.arrayBuffer)var t=["[object Int8Array]","[object Uint8Array]","[object Uint8ClampedArray]","[object Int16Array]","[object Uint16Array]","[object Int32Array]","[object Uint32Array]","[object Float32Array]","[object Float64Array]"],n=function(e){return e&&DataView.prototype.isPrototypeOf(e)},r=ArrayBuffer.isView||function(e){return e&&-1<t.indexOf(Object.prototype.toString.call(e))};l.prototype.append=function(e,t){e=s(e),t=a(t);var n=this.map[e];this.map[e]=n?n+","+t:t},l.prototype.delete=function(e){delete this.map[s(e)]},l.prototype.get=function(e){return e=s(e),this.has(e)?this.map[e]:null},l.prototype.has=function(e){return this.map.hasOwnProperty(s(e))},l.prototype.set=function(e,t){this.map[s(e)]=a(t)},l.prototype.forEach=function(e,t){for(var n in this.map)this.map.hasOwnProperty(n)&&e.call(t,this.map[n],n,this)},l.prototype.keys=function(){var n=[];return this.forEach(function(e,t){n.push(t)}),c(n)},l.prototype.values=function(){var t=[];return this.forEach(function(e){t.push(e)}),c(t)},l.prototype.entries=function(){var n=[];return this.forEach(function(e,t){n.push([t,e])}),c(n)},u.iterable&&(l.prototype[Symbol.iterator]=l.prototype.entries);var i=["DELETE","GET","HEAD","OPTIONS","POST","PUT"];m.prototype.clone=function(){return new m(this,{body:this._bodyInit})},y.call(m.prototype),y.call(b.prototype),b.prototype.clone=function(){return new b(this._bodyInit,{status:this.status,statusText:this.statusText,headers:new l(this.headers),url:this.url})},b.error=function(){var e=new b(null,{status:0,statusText:""});return e.type="error",e};var o=[301,302,303,307,308];b.redirect=function(e,t){if(-1==o.indexOf(t))throw new RangeError("Invalid status code");return new b(null,{status:t,headers:{location:e}})},e.Headers=l,e.Request=m,e.Response=b,e.fetch=function(n,o){return new Promise(function(r,e){var t=new m(n,o),i=new XMLHttpRequest;i.onload=function(){var e,o,t={status:i.status,statusText:i.statusText,headers:(e=i.getAllResponseHeaders()||"",o=new l,e.replace(/\r?\n[\t ]+/g," ").split(/\r?\n/).forEach(function(e){var t=e.split(":"),n=t.shift().trim();if(n){var r=t.join(":").trim();o.append(n,r)}}),o)};t.url="responseURL"in i?i.responseURL:t.headers.get("X-Request-URL");var n="response"in i?i.response:i.responseText;r(new b(n,t))},i.onerror=function(){e(new TypeError("Network request failed"))},i.ontimeout=function(){e(new TypeError("Network request failed"))},i.open(t.method,t.url,!0),"include"===t.credentials?i.withCredentials=!0:"omit"===t.credentials&&(i.withCredentials=!1),"responseType"in i&&u.blob&&(i.responseType="blob"),t.headers.forEach(function(e,t){i.setRequestHeader(t,e)}),i.send(void 0===t._bodyInit?null:t._bodyInit)})},e.fetch.polyfill=!0}function s(e){if("string"!=typeof e&&(e+=""),/[^a-z0-9\-#$%&'*+.\^_`|~]/i.test(e))throw new TypeError("Invalid character in header field name");return e.toLowerCase()}function a(e){return"string"!=typeof e&&(e+=""),e}function c(t){var e={next:function(){var e=t.shift();return{done:void 0===e,value:e}}};return u.iterable&&(e[Symbol.iterator]=function(){return e}),e}function l(t){this.map={},t instanceof l?t.forEach(function(e,t){this.append(t,e)},this):Array.isArray(t)?t.forEach(function(e){this.append(e[0],e[1])},this):t&&Object.getOwnPropertyNames(t).forEach(function(e){this.append(e,t[e])},this)}function f(e){if(e.bodyUsed)return Promise.reject(new TypeError("Already read"));e.bodyUsed=!0}function d(n){return new Promise(function(e,t){n.onload=function(){e(n.result)},n.onerror=function(){t(n.error)}})}function h(e){var t=new FileReader,n=d(t);return t.readAsArrayBuffer(e),n}function p(e){if(e.slice)return e.slice(0);var t=new Uint8Array(e.byteLength);return t.set(new Uint8Array(e)),t.buffer}function y(){return this.bodyUsed=!1,this._initBody=function(e){if(this._bodyInit=e)if("string"==typeof e)this._bodyText=e;else if(u.blob&&Blob.prototype.isPrototypeOf(e))this._bodyBlob=e;else if(u.formData&&FormData.prototype.isPrototypeOf(e))this._bodyFormData=e;else if(u.searchParams&&URLSearchParams.prototype.isPrototypeOf(e))this._bodyText=e.toString();else if(u.arrayBuffer&&u.blob&&n(e))this._bodyArrayBuffer=p(e.buffer),this._bodyInit=new Blob([this._bodyArrayBuffer]);else{if(!u.arrayBuffer||!ArrayBuffer.prototype.isPrototypeOf(e)&&!r(e))throw Error("unsupported BodyInit type");this._bodyArrayBuffer=p(e)}else this._bodyText="";this.headers.get("content-type")||("string"==typeof e?this.headers.set("content-type","text/plain;charset=UTF-8"):this._bodyBlob&&this._bodyBlob.type?this.headers.set("content-type",this._bodyBlob.type):u.searchParams&&URLSearchParams.prototype.isPrototypeOf(e)&&this.headers.set("content-type","application/x-www-form-urlencoded;charset=UTF-8"))},u.blob&&(this.blob=function(){var e=f(this);if(e)return e;if(this._bodyBlob)return Promise.resolve(this._bodyBlob);if(this._bodyArrayBuffer)return Promise.resolve(new Blob([this._bodyArrayBuffer]));if(this._bodyFormData)throw Error("could not read FormData body as blob");return Promise.resolve(new Blob([this._bodyText]))},this.arrayBuffer=function(){return this._bodyArrayBuffer?f(this)||Promise.resolve(this._bodyArrayBuffer):this.blob().then(h)}),this.text=function(){var e,t,n,r=f(this);if(r)return r;if(this._bodyBlob)return e=this._bodyBlob,t=new FileReader,n=d(t),t.readAsText(e),n;if(this._bodyArrayBuffer)return Promise.resolve(function(e){for(var t=new Uint8Array(e),n=Array(t.length),r=0;r<t.length;r++)n[r]=String.fromCharCode(t[r]);return n.join("")}(this._bodyArrayBuffer));if(this._bodyFormData)throw Error("could not read FormData body as text");return Promise.resolve(this._bodyText)},u.formData&&(this.formData=function(){return this.text().then(v)}),this.json=function(){return this.text().then(JSON.parse)},this}function m(e,t){var n,r,o=(t=t||{}).body;if(e instanceof m){if(e.bodyUsed)throw new TypeError("Already read");this.url=e.url,this.credentials=e.credentials,t.headers||(this.headers=new l(e.headers)),this.method=e.method,this.mode=e.mode,o||null==e._bodyInit||(o=e._bodyInit,e.bodyUsed=!0)}else this.url=e+"";if(this.credentials=t.credentials||this.credentials||"omit",!t.headers&&this.headers||(this.headers=new l(t.headers)),this.method=(n=t.method||this.method||"GET",r=n.toUpperCase(),-1<i.indexOf(r)?r:n),this.mode=t.mode||this.mode||null,this.referrer=null,("GET"===this.method||"HEAD"===this.method)&&o)throw new TypeError("Body not allowed for GET or HEAD requests");this._initBody(o)}function v(e){var o=new FormData;return e.trim().split("&").forEach(function(e){if(e){var t=e.split("="),n=t.shift().replace(/\+/g," "),r=t.join("=").replace(/\+/g," ");o.append(decodeURIComponent(n),decodeURIComponent(r))}}),o}function b(e,t){t||(t={}),this.type="default",this.status=void 0===t.status?200:t.status,this.ok=200<=this.status&&this.status<300,this.statusText="statusText"in t?t.statusText:"OK",this.headers=new l(t.headers),this.url=t.url||"",this._initBody(e)}}("undefined"!=typeof self?self:this)},function(e,t){var n,r,o=e.exports={};function i(){throw Error("setTimeout has not been defined")}function u(){throw Error("clearTimeout has not been defined")}function s(t){if(n===setTimeout)return setTimeout(t,0);if((n===i||!n)&&setTimeout)return(n=setTimeout)(t,0);try{return n(t,0)}catch(e){try{return n.call(null,t,0)}catch(e){return n.call(this,t,0)}}}!function(){try{n="function"==typeof setTimeout?setTimeout:i}catch(e){n=i}try{r="function"==typeof clearTimeout?clearTimeout:u}catch(e){r=u}}();var a,c=[],l=!1,f=-1;function d(){l&&a&&(l=!1,a.length?c=a.concat(c):f=-1,c.length&&h())}function h(){if(!l){var e=s(d);l=!0;for(var t=c.length;t;){for(a=c,c=[];++f<t;)a&&a[f].run();f=-1,t=c.length}a=null,l=!1,function(t){if(r===clearTimeout)return clearTimeout(t);if((r===u||!r)&&clearTimeout)return(r=clearTimeout)(t);try{r(t)}catch(e){try{return r.call(null,t)}catch(e){return r.call(this,t)}}}(e)}}function p(e,t){this.fun=e,this.array=t}function y(){}o.nextTick=function(e){var t=Array(arguments.length-1);if(1<arguments.length)for(var n=1;n<arguments.length;n++)t[n-1]=arguments[n];c.push(new p(e,t)),1!==c.length||l||s(h)},p.prototype.run=function(){this.fun.apply(null,this.array)},o.title="browser",o.browser=!0,o.env={},o.argv=[],o.version="",o.versions={},o.on=y,o.addListener=y,o.once=y,o.off=y,o.removeListener=y,o.removeAllListeners=y,o.emit=y,o.prependListener=y,o.prependOnceListener=y,o.listeners=function(e){return[]},o.binding=function(e){throw Error("process.binding is not supported")},o.cwd=function(){return"/"},o.chdir=function(e){throw Error("process.chdir is not supported")},o.umask=function(){return 0}},function(e,t,n){(function(e,p){!function(n,r){"use strict";if(!n.setImmediate){var o,i=1,u={},s=!1,a=n.document,e=Object.getPrototypeOf&&Object.getPrototypeOf(n);e=e&&e.setTimeout?e:n,o="[object process]"==={}.toString.call(n.process)?function(e){p.nextTick(function(){h(e)})}:function(){if(n.postMessage&&!n.importScripts){var e=!0,t=n.onmessage;return n.onmessage=function(){e=!1},n.postMessage("","*"),n.onmessage=t,e}}()?(l="setImmediate$"+Math.random()+"$",f=function(e){e.source===n&&"string"==typeof e.data&&0==e.data.indexOf(l)&&h(+e.data.slice(l.length))},n.addEventListener?n.addEventListener("message",f,!1):n.attachEvent("onmessage",f),function(e){n.postMessage(l+e,"*")}):n.MessageChannel?((t=new MessageChannel).port1.onmessage=function(e){h(e.data)},function(e){t.port2.postMessage(e)}):a&&"onreadystatechange"in a.createElement("script")?(c=a.documentElement,function(e){var t=a.createElement("script");t.onreadystatechange=function(){h(e),t.onreadystatechange=null,c.removeChild(t),t=null},c.appendChild(t)}):function(e){setTimeout(h,0,e)},e.setImmediate=function(e){"function"!=typeof e&&(e=Function(""+e));for(var t=Array(arguments.length-1),n=0;n<t.length;n++)t[n]=arguments[n+1];var r={callback:e,args:t};return u[i]=r,o(i),i++},e.clearImmediate=d}var c,t,l,f;function d(e){delete u[e]}function h(e){if(s)setTimeout(h,0,e);else{var t=u[e];if(t){s=!0;try{!function(e){var t=e.callback,n=e.args;switch(n.length){case 0:t();break;case 1:t(n[0]);break;case 2:t(n[0],n[1]);break;case 3:t(n[0],n[1],n[2]);break;default:t.apply(r,n)}}(t)}finally{d(e),s=!1}}}}}("undefined"==typeof self?void 0===e?this:e:self)}).call(this,n(0),n(6))},function(e,o,i){(function(e){var t=void 0!==e&&e||"undefined"!=typeof self&&self||window,n=Function.prototype.apply;function r(e,t){this._id=e,this._clearFn=t}o.setTimeout=function(){return new r(n.call(setTimeout,t,arguments),clearTimeout)},o.setInterval=function(){return new r(n.call(setInterval,t,arguments),clearInterval)},o.clearTimeout=o.clearInterval=function(e){e&&e.close()},r.prototype.unref=r.prototype.ref=function(){},r.prototype.close=function(){this._clearFn.call(t,this._id)},o.enroll=function(e,t){clearTimeout(e._idleTimeoutId),e._idleTimeout=t},o.unenroll=function(e){clearTimeout(e._idleTimeoutId),e._idleTimeout=-1},o._unrefActive=o.active=function(e){clearTimeout(e._idleTimeoutId);var t=e._idleTimeout;0<=t&&(e._idleTimeoutId=setTimeout(function(){e._onTimeout&&e._onTimeout()},t))},i(7),o.setImmediate="undefined"!=typeof self&&self.setImmediate||void 0!==e&&e.setImmediate||this&&this.setImmediate,o.clearImmediate="undefined"!=typeof self&&self.clearImmediate||void 0!==e&&e.clearImmediate||this&&this.clearImmediate}).call(this,i(0))},function(e,l,f){"use strict";f.r(l),function(t){var e=f(1),n=setTimeout;function r(){}function i(e){if(!(this instanceof i))throw new TypeError("Promises must be constructed via new");if("function"!=typeof e)throw new TypeError("not a function");this._state=0,this._handled=!1,this._value=void 0,this._deferreds=[],c(e,this)}function o(n,r){for(;3===n._state;)n=n._value;0!==n._state?(n._handled=!0,i._immediateFn(function(){var e=1===n._state?r.onFulfilled:r.onRejected;if(null!==e){var t;try{t=e(n._value)}catch(e){return void s(r.promise,e)}u(r.promise,t)}else(1===n._state?u:s)(r.promise,n._value)})):n._deferreds.push(r)}function u(e,t){try{if(t===e)throw new TypeError("A promise cannot be resolved with itself.");if(t&&("object"==typeof t||"function"==typeof t)){var n=t.then;if(t instanceof i)return e._state=3,e._value=t,void a(e);if("function"==typeof n)return void c((r=n,o=t,function(){r.apply(o,arguments)}),e)}e._state=1,e._value=t,a(e)}catch(t){s(e,t)}var r,o}function s(e,t){e._state=2,e._value=t,a(e)}function a(e){2===e._state&&0===e._deferreds.length&&i._immediateFn(function(){e._handled||i._unhandledRejectionFn(e._value)});for(var t=0,n=e._deferreds.length;t<n;t++)o(e,e._deferreds[t]);e._deferreds=null}function c(e,t){var n=!1;try{e(function(e){n||(n=!0,u(t,e))},function(e){n||(n=!0,s(t,e))})}catch(e){if(n)return;n=!0,s(t,e)}}i.prototype.catch=function(e){return this.then(null,e)},i.prototype.then=function(e,t){var n=new this.constructor(r);return o(this,new function(e,t,n){this.onFulfilled="function"==typeof e?e:null,this.onRejected="function"==typeof t?t:null,this.promise=n}(e,t,n)),n},i.prototype.finally=e.a,i.all=function(t){return new i(function(r,o){if(!t||void 0===t.length)throw new TypeError("Promise.all accepts an array");var i=Array.prototype.slice.call(t);if(0===i.length)return r([]);var u=i.length;function s(t,e){try{if(e&&("object"==typeof e||"function"==typeof e)){var n=e.then;if("function"==typeof n)return void n.call(e,function(e){s(t,e)},o)}i[t]=e,0==--u&&r(i)}catch(t){o(t)}}for(var e=0;e<i.length;e++)s(e,i[e])})},i.resolve=function(t){return t&&"object"==typeof t&&t.constructor===i?t:new i(function(e){e(t)})},i.reject=function(n){return new i(function(e,t){t(n)})},i.race=function(o){return new i(function(e,t){for(var n=0,r=o.length;n<r;n++)o[n].then(e,t)})},i._immediateFn="function"==typeof t&&function(e){t(e)}||function(e){n(e,0)},i._unhandledRejectionFn=function(e){},l.default=i}(f(8).setImmediate)},function(e,t,n){
/*! netent_gcc_mediator : 0.2.2 - Wed, 12 Dec 2018 11:33:25 GMT | (c) 2018  NetEnt AB (publ) | ISC | https://www.netent.com/ */
window,e.exports=function(n){var r={};function o(e){if(r[e])return r[e].exports;var t=r[e]={i:e,l:!1,exports:{}};return n[e].call(t.exports,t,t.exports,o),t.l=!0,t.exports}return o.m=n,o.c=r,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(t,e){if(1&e&&(t=o(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)o.d(n,r,function(e){return t[e]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="",o(o.s=0)}([function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.Mediator=function(){this.fire=function(e,t){document.body.dispatchEvent(new CustomEvent(e,{detail:t}))},this.listen=function(e,t){document.body.addEventListener(e,t)},this.removeListener=function(e,t){document.body.removeEventListener(e,t)}}}])},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n(10),o=n(9);n(5);var i,u=n(4),s=n(3);n(2),window.Promise||(window.Promise=o.default),(i=t.netent_gcc_shared||(t.netent_gcc_shared={})).AppConstants=u.Constants,i.AppEnums=s.Enums,i.EventsMediator=new r.Mediator}])},function(e,t,n){
/*! netent_gcc_queue : 0.2.2 - Wed, 12 Dec 2018 11:33:50 GMT | (c) 2018  NetEnt AB (publ) | ISC | https://www.netent.com/ */
window,e.exports=function(n){var r={};function o(e){if(r[e])return r[e].exports;var t=r[e]={i:e,l:!1,exports:{}};return n[e].call(t.exports,t,t.exports,o),t.l=!0,t.exports}return o.m=n,o.c=r,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(t,e){if(1&e&&(t=o(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)o.d(n,r,function(e){return t[e]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="",o(o.s=1)}([function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=function(){function e(e){void 0===e&&(e=[]),this.queue=e}return e.prototype.length=function(){return this.queue.length},e.prototype.enqueue=function(e){this.queue.push(e)},e.prototype.dequeue=function(){return!!(this&&this.queue&&this.queue.length)&&this.queue.shift()},e.prototype.dequeueLast=function(){return!!(this&&this.queue&&this.queue.length)&&this.queue.pop()},e.prototype.clear=function(){this.queue=[]},e}();t.QueueCore=r},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=n(0);t.QueueCore=r.QueueCore}])},function(e,t,n){"use strict";var r=this&&this.__assign||Object.assign||function(e){for(var t,n=1,r=arguments.length;n<r;n++)for(var o in t=arguments[n])Object.prototype.hasOwnProperty.call(t,o)&&(e[o]=t[o]);return e};Object.defineProperty(t,"__esModule",{value:!0});var o=n(3),i=n(2),u=n(1),s=n(0),a=function(){function e(e,t){void 0===e&&(e=new u.FullScreenModel),void 0===t&&(t=new o.QueueCore),this.model=e,this.queue=t,this.fullScreenView=new s.FullScreenViewAdapter(this),this.registerListeners(),this.model.gameIsIdle=!0}return e.prototype.removeAllFullScreens=function(){this.queue.clear()},e.prototype.fullScreenShown=function(){this.model.showingFullScreen=!0},e.prototype.fullScreenClosed=function(){this.model.showingFullScreen=!1},e.prototype.registerListeners=function(){var n=this,e=i.netent_gcc_shared.EventsMediator,t=i.netent_gcc_shared.AppConstants;e.listen(t.Notification.SET_FULLSCREEN_VIEW,function(e){n.fullScreenView.setView(e.detail)}),e.listen(t.Notification.SEND_MESSAGE,function(e){var t=e.detail;"FULLSCREEN"===t.displayType&&(n.queue.enqueue(t),n.reactOnFullScreenMessage())}),e.listen(t.Game.NOT_IDLE,function(e){n.model.gameIsIdle=!1,n.fullScreenView.hide(),n.model.autoPlayActive||n.removeAllFullScreens()}),e.listen(t.Game.IDLE,function(e){n.model.autoPlayActive||(n.model.gameIsIdle=!0,n.reactOnFullScreenMessage())}),e.listen(t.Game.AUTOPLAY_STARTED,function(e){n.model.autoPlayActive=!0,n.model.gameIsIdle=!1}),e.listen(t.Game.AUTOPLAY_STOPPED,function(e){n.model.autoPlayActive=!1}),window.onmessage=function(e){"closeFullScreen"===e.data&&(n.fullScreenView.hide(),n.removeAllFullScreens())},e.listen(t.Game.GAME_RESOURCES_RESPONSE,function(e){n.model.gameResources=e.detail})},e.prototype.reactOnFullScreenMessage=function(){if(this.model.gameIsIdle){if(!this.model.showingFullScreen){var e=this.queue.dequeue();if(e){var t=this.buildContentURI(e);this.fullScreenView.show(t),this.fullScreenShown()}}}else this.fullScreenView.hide()},e.prototype.buildContentURI=function(e){if(!e.adventureParams&&e.messageContent)return e.messageContent;this.model.gameResources;var t=this.model.gameResources.adventureURI,n=r({},this.model.gameResources);return delete n.adventureURI,delete n.pnsURI,t+=this.convertToQueryString(n),e.adventureParams&&(t+=e.adventureParams),t},e.prototype.convertToQueryString=function(n){return"?"+Object.keys(n).reduce(function(e,t){return e.push(t+"="+encodeURIComponent(n[t])),e},[]).join("&")},e}();t.FullScreenController=a},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});new(n(4).FullScreenController)}]);