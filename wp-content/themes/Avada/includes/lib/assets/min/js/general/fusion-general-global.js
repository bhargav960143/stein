function checkHoverTouchState(){var o,e=!1;document.addEventListener("touchstart",function(){clearTimeout(o),e=!0,jQuery("body").addClass("fusion-touch"),jQuery("body").removeClass("fusion-no-touch"),o=setTimeout(function(){e=!1},500)},{passive:!0}),document.addEventListener("mouseover",function(){e||(e=!1,jQuery("body").addClass("fusion-no-touch"),jQuery("body").removeClass("fusion-touch"))})}checkHoverTouchState();