/*! jQuery UI - v1.13.2 - 2022-11-15
* http://jqueryui.com
* Includes: effect-highlight.js
* Copyright jQuery Foundation and other contributors; Licensed MIT */
(function(factory){if(typeof define==="function"&&define.amd){define(["jquery","./effect"],factory);}else{factory(jQuery);}})(function($,undefined){return $.effects.define("highlight","show",function(options,done){var mode=options.mode,animation={backgroundColor:$(this).css("backgroundColor")};if(mode==="hide"){animation.opacity=0;}$(this).css({backgroundColor:options.color||"#ffff99",opacity:options.opacity||1}).animate(animation,{queue:false,duration:options.duration,easing:options.easing,complete:done});});});
