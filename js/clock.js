function currenTime()
{
    let date = new Date();
    let hh = date.getHours();
    let mm = date.getMinutes();
    let ss = date.getSeconds();
    let session = "AM";

    if (hh == 0)
    {
        hh = 12;
    }

    if(hh> 12)
    {
        hh = hh -12;
        session = "PM";
    }

    hh = (hh < 10) ? "0" + hh : hh;
    mm = (mm < 10) ? "0" + mm : mm;
    ss = (ss < 10) ? "0" + ss : ss;

    let time = hh + ':' + mm + ':' + ss + '' +session;

    document.getElementById("current_time").innerHTML = time;
    let t = setTimeout(function(){currenTime()}, 1000);
}

currenTime();


function getUTC()
{
    var date = new Date();

    var utcDate = date.toUTCString();

    document.getElementById("gmt_clock").innerHTML = utcDate;

}

getUTC();