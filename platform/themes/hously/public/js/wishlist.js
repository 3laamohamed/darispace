(()=>{"use strict";window.showAlert=function(e,t){if(e&&""!==t){var i=Math.floor(1e3*Math.random()),o='<div class="alert '.concat(e,' alert-dismissible" id="').concat(i,'">\n                        <span class="close cursor-pointer mdi mdi-close-box" aria-label="close"></span>\n                        <i class="')+("alert-success"===e?"mdi mdi-check":"mdi mdi-exclamation")+' message-icon"></i>\n                        '.concat(t,"\n                    </div>");$("#alert-container").append(o).ready((function(){window.setTimeout((function(){$("#alert-container #".concat(i)).remove()}),6e3)}))}};var e=function(e,t,i){var o=new Date,r=window.siteUrl;r.includes(window.location.protocol)||(r=window.location.protocol+r);var n=new URL(r);o.setTime(o.getTime()+24*i*60*60*1e3);var a="expires="+o.toUTCString();document.cookie=e+"="+t+"; "+a+"; path=/; domain="+n.hostname},t=function(e){for(var t=e+"=",i=document.cookie.split(";"),o=0;o<i.length;o++){for(var r=i[o];" "===r.charAt(0);)r=r.substring(1);if(0===r.indexOf(t))return r.substring(t.length,r.length)}return""},i=function(e){var t=window.siteUrl;t.includes(window.location.protocol)||(t=window.location.protocol+t);var i=new URL(t);document.cookie=e+"=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/; domain="+i.hostname};function o(e){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},o(e)}function r(e,t){for(var i=0;i<t.length;i++){var r=t[i];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,(n=r.key,a=void 0,a=function(e,t){if("object"!==o(e)||null===e)return e;var i=e[Symbol.toPrimitive];if(void 0!==i){var r=i.call(e,t||"default");if("object"!==o(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(n,"string"),"symbol"===o(a)?a:String(a)),r)}var n,a}var n=function(){function o(){var e=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,o),this.refresh(),$(document).on("click",".add-to-wishlist",(function(t){t.preventDefault(),e.addOrRemove($(t.currentTarget))}))}var n,a,s;return n=o,a=[{key:"addOrRemove",value:function(o){var r="real_estate_wishlist",n=o.data("id"),a=o.data("type"),s=decodeURIComponent(t(r));if(s=s?JSON.parse(s):{projects:[],properties:[]},null!=n&&0!==n&&void 0!==n){var c=s.properties;"project"===a&&(c=s.projects);var d=c.map((function(e){return e})).indexOf(n);-1===d?("project"===a?s.projects.push(n):s.properties.push(n),i(r),e(r,JSON.stringify(s),60),o.find("i").removeClass("mdi mdi-heart-outline").addClass("mdi mdi-heart")):("project"===a?s.projects.splice(d,1):s.properties.splice(d,1),i(r),e(r,JSON.stringify(s),60),o.find("i").removeClass("mdi mdi-heart").addClass("mdi mdi-heart-outline"))}var l=JSON.parse(t(r)),u=l.properties.length+l.projects.length;$(".wishlist-count").text(u),this.refresh()}},{key:"refresh",value:function(){var e=decodeURIComponent(t("real_estate_wishlist"));if(null!=e&&e){var i=JSON.parse(e);i.properties.length&&$.each($(document).find('.add-to-wishlist[data-type="property"]'),(function(e,t){var o=$(t).data("id");-1!==i.properties.indexOf(o)&&$(t).find("i").removeClass("mdi mdi-heart-outline").addClass("mdi mdi-heart")})),i.projects.length&&$.each($(document).find('.add-to-wishlist[data-type="project"]'),(function(e,t){var o=$(t).data("id");-1!==i.projects.indexOf(o)&&$(t).find("i").removeClass("mdi mdi-heart-outline").addClass("mdi mdi-heart")}))}}}],a&&r(n.prototype,a),s&&r(n,s),Object.defineProperty(n,"prototype",{writable:!1}),o}();new n})();