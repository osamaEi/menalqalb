// $(function(){
//     var  windowHeight = $(window).height(),
//          navtop = $('.navTop').innerHeight(),
//          navBottom = $('.navBottom').innerHeight();

//          $('.slider').height(windowHeight - (navBottom + navtop));
// });

// $(function(){
//     var windowHeight = $(window).height(),
//         navTop = $('.navTop').innerHeight(),
//         navBottom = $('.navBottom').innerHeight();

//         $('.slider').height(windowHeight - (navTop + navBottom ));


//     $('.list ul li').on('click' , function(){
//         $(this).addClass('active').siblings().removeClass('active')
//     });


// });

$('.icon').click(function(){
    $('.languages').toggleClass('active') ; 
})
$(' .languages ul li').click(function(){
    $('.languages').removeClass('active') ; 
})


letterScanner( $('body'), 'o' )

function letterScanner( $el, letter ){
$el.contents().each( function(){
    if( this.nodeType == 3 ){
    $( this ).replaceWith( this.textContent.replace( new RegExp( '('+letter+'+)', 'g' ), "<span class='newcharacter'>$1</span>" ) );
    }else{
        letterScanner( $( this ), letter )
    }
} );
}

function setLang(language) {
    document.getElementById("rootElement").lang = language;
    
    // Not really needed, see below.
    setCookie("lang", language, 365); 
}

/*
  None of this below is really needed. I only added it for ease of use.
  If I were using this in a production environment, I'd probably 
  inspect the Accept-Language HTTP header sent from the client browser
  to determine the language to display initially. Then enable the user
  to change that default selection, and save their choice in a cookie.
*/
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

var ml4 = {};
ml4.opacityIn = [0,1];
ml4.scaleIn = [0.2, 1];
ml4.scaleOut = 3;
ml4.durationIn = 800;
ml4.durationOut = 600;
ml4.delay = 500;

anime.timeline({loop: true})
  .add({
    targets: '.ml4 .letters-1',
    opacity: ml4.opacityIn,
    scale: ml4.scaleIn,
    duration: ml4.durationIn
  }).add({
    targets: '.ml4 .letters-1',
    opacity: 0,
    scale: ml4.scaleOut,
    duration: ml4.durationOut,
    easing: "easeInExpo",
    delay: ml4.delay
  }).add({
    targets: '.ml4 .letters-2',
    opacity: ml4.opacityIn,
    scale: ml4.scaleIn,
    duration: ml4.durationIn
  }).add({
    targets: '.ml4 .letters-2',
    opacity: 0,
    scale: ml4.scaleOut,
    duration: ml4.durationOut,
    easing: "easeInExpo",
    delay: ml4.delay
  }).add({
    targets: '.ml4 .letters-3',
    opacity: ml4.opacityIn,
    scale: ml4.scaleIn,
    duration: ml4.durationIn
  }).add({
    targets: '.ml4 .letters-3',
    opacity: 0,
    scale: ml4.scaleOut,
    duration: ml4.durationOut,
    easing: "easeInExpo",
    delay: ml4.delay
  }).add({
    targets: '.ml4',
    opacity: 0,
    duration: 500,
    delay: 500
  });
  
document.getElementById("rootElement").lang = getCookie("lang");



