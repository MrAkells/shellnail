/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//(function(d, s, id) {
//  var js, fjs = d.getElementsByTagName(s)[0];
//  if (d.getElementById(id)) return;
//  js = d.createElement(s); js.id = id;
//  js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.0&appId=179241882791748&autoLogAppEvents=1';
//  fjs.parentNode.insertBefore(js, fjs);
//}(document, 'script', 'facebook-jssdk'));

  $(document).ready(adjust_fb_coments);
        $(window).resize(adjust_fb_coments);

        function adjust_fb_coments(){
            var width=$('#column-left').width()-10;

            var interval=setInterval(function(){
                if($('.fb_iframe_widget').attr('fb-xfbml-state')=='rendered'){
                    clearInterval(interval);
                    
                   $('#column-left .fb_iframe_widget').find('iframe').css('width',width+'px');
		   
		   
                }
            }, 200);
        }
