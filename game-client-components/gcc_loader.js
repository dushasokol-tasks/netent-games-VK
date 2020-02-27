loadjs=function(){var l=function(){},c={},f={},u={};function s(e,n){if(e){var t=u[e];if(f[e]=n,t)for(;t.length;)t[0](e,n),t.splice(0,1)}}function o(e,n){e.call&&(e={success:e}),n.length?(e.error||l)(n):(e.success||l)(e)}function h(t,r,i,c){var s,o,e=document,n=i.async,f=(i.numRetries||0)+1,u=i.before||l,a=t.replace(/^(css|img)!/,"");c=c||0,/(^css!|\.css$)/.test(t)?(s=!0,(o=e.createElement("link")).rel="stylesheet",o.href=a):/(^img!|\.(png|gif|jpg|svg)$)/.test(t)?(o=e.createElement("img")).src=a:((o=e.createElement("script")).src=t,o.async=void 0===n||n),!(o.onload=o.onerror=o.onbeforeload=function(e){var n=e.type[0];if(s&&"hideFocus"in o)try{o.sheet.cssText.length||(n="e")}catch(e){n="e"}if("e"==n&&(c+=1)<f)return h(t,r,i,c);r(t,n,e.defaultPrevented)})!==u(t,o)&&e.head.appendChild(o)}function t(e,n,t){var r,i;if(n&&n.trim&&(r=n),i=(r?t:n)||{},r){if(r in c)throw"LoadJS";c[r]=!0}!function(e,r,n){var t,i,c=(e=e.push?e:[e]).length,s=c,o=[];for(t=function(e,n,t){if("e"==n&&o.push(e),"b"==n){if(!t)return;o.push(e)}--c||r(o)},i=0;i<s;i++)h(e[i],t,n)}(e,function(e){o(i,e),s(r,e)},i)}return t.ready=function(e,n){return function(e,t){e=e.push?e:[e];var n,r,i,c=[],s=e.length,o=s;for(n=function(e,n){n.length&&c.push(e),--o||t(c)};s--;)r=e[s],(i=f[r])?n(r,i):(u[r]=u[r]||[]).push(n)}(e,function(e){o(n,e)}),t},t.done=function(e){s(e,[])},t.reset=function(){c={},f={},u={}},t.isDefined=function(e){return e in c},t}();
let relativeLocation;
if (typeof gccLocation === 'undefined') {
  relativeLocation = '../../../game-client-components';
}
else {
  relativeLocation = gccLocation;
}

// Shared and Infrastructure libraries are loaded completely
loadjs([
  relativeLocation + '/netent_gcc_shared/shared.js',
  relativeLocation + '/netent_gcc_api/gcc_api.js'
], {

  success: function() {
    loadjs([relativeLocation + '/netent_gcc_websockets/websockets.js'],
      'communication', {
        async: false,
        success: function() {

          // Shared and Infrastructure libraries are loaded completely
          // Now Load the implemented components like Player Notification, Player Progress etc.
          var gccComponents = [
            relativeLocation + '/netent_gcc_toast-notifications/toast-notifications.js',
            relativeLocation + '/netent_gcc_advantures_button/advantures_button.js'
            /// Other future components
          ];
          loadjs(gccComponents, 'gccComponents', {
            async: false,
            success: function(){
              // All the client components are loaded now...
              // Load NetEnt Game Adapter ( or send call back to 3rd Party Integrator for calling initialisation/configurations for the Client Components as Adapter for them is not required).
              loadjs([
                relativeLocation + '/netent_gcc_toast-view/toast-view.js',
                relativeLocation + '/netent_gcc_fullscreen-notifications/fullscreen-notifications.js',
                relativeLocation + '/netent_gcc_fullscreen-view/fullscreen-view.js'
              ], 'fullscreen', {
                async: false,
                success: function() {
                  loadjs([relativeLocation + '/netent_gcc-netent_game_adapter/game_adapter.js'], 'netent_game_adapter')
                }
              })
            }
          });
        }
      });
  },
  async: false
});
