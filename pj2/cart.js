var pics=new Set();
var t=0;
function ajax(t=1) {
    var xml=new XMLHttpRequest();
    xml.onreadystatechange=function () {
        if (xml.readyState === 4 && xml.status === 200) {
            document.getElementById("result").innerHTML = xml.responseText;
        }
    };
    xml.open("GET","cartDeal.php?page="+t+"&name="+getCookie("username"),true);
    xml.send();
}
function jmp(id)
{
    window.location.href="artworks.php?id="+id;
}
function del(id,t=1)
{
    var xml=new XMLHttpRequest();
    xml.onreadystatechange=function () {
        if (xml.readyState === 4 && xml.status === 200) {
        }
    };
    xml.open("GET","cartDel.php?id="+id,true);
    xml.send();
    ajax(t);
}
function determine(paintingID) {
    if ($("#a"+paintingID).get(0).checked) {
        choose(paintingID)
    }
    else
    {
        dele(paintingID);
    }
}
function choose(paintingID) {
    var xml=new XMLHttpRequest();
    xml.open("POST","cartCal.php",true);
    xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xml.onreadystatechange=function () {
        if (xml.readyState === 4 && xml.status === 200) {

            document.getElementById("cal").innerText=xml.responseText;
        }
    };
    xml.send("paintingID="+paintingID);
}
function dele(paintingID) {
    var xml=new XMLHttpRequest();
    xml.open("POST","cartCal.php",true);
    xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xml.onreadystatechange=function () {
        if (xml.readyState === 4 && xml.status === 200) {
            document.getElementById("cal").innerText=xml.responseText;
        }
    };
    xml.send("delPaintingID="+paintingID);
}
function onDeal() {
    // var xml=new XMLHttpRequest();
    // xml.open("POST","onDeal.php",true);
    // xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // xml.onreadystatechange=function () {
    //     if (xml.readyState === 4 && xml.status === 200) {
    //
    //         if (xml.responseText!="你没有选择商品！") window.location.href="personalInfo.php";
    //     }
    // };
    // xml.send("pay=true");
    window.location.href="deal.php";
}
function reset() {
    pics.clear();
    var xml=new XMLHttpRequest();
    xml.open("POST","cartClear.php",true);
    xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xml.onreadystatechange=function () {
        if (xml.readyState === 4 && xml.status === 200) {
            $("[name='checkbox']").removeAttr("checked");//全选
            document.getElementById("cal").innerText="　";
        }
    };
    xml.send();

}