var k;
function pic(i) {
    var pics=[null,"5855774224","5856697109","6119130918","8711645510","9504449928"];
    var title=[null,"Battle","Luneburg","Bermuda","Athens","Florence"];
    document.getElementById("featured").innerHTML="" +
        "<img src=\"images/medium/"+pics[i]+".jpg\" onmouseleave=\"MouseOut()\" onmouseenter=\"MouseIn()\"/>\n" +
        "<figcaption id=\"figcaption\">"+title[i]+"</figcaption>";
    k=i;
}

function MouseOut() {
    var fig=document.getElementById("figcaption");
    fadeOut(fig,1000.0/80.0,0);
}

function MouseIn() {
    var fig=document.getElementById("figcaption");
    fadeIn(fig,1000.0/80.0,80.0);
}

var iBase = {
    Id: function(name){
        return document.getElementById(name);
    },
    SetOpacity: function(ev, v){
        ev.filters ? ev.style.filter = 'alpha(opacity=' + v + ')' : ev.style.opacity = v / 100;
    }
};

function fadeIn(elem, speed, opacity) {
    elem.style.display = 'block';
    iBase.SetOpacity(elem, 0);
    var val = 0;
        (function () {
            iBase.SetOpacity(elem, val);
            val += 1;
            if (val <= opacity) {
                setTimeout(arguments.callee, speed);
            }
        })();
}

function fadeOut(elem, speed, opacity){
    var val = 80;
    (function(){
        iBase.SetOpacity(elem, val);
        val -= 1;
        if (val >= opacity) {
            setTimeout(arguments.callee, speed);
        }
    })();
}