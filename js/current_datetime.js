function currenTime()
{
    let date = new Date();
    let hh = date.getHours();
    let mm = date.getMinutes();
    let ss = date.getSeconds();
    let session = " AM";


    if(hh > 12)
    {
        session = " PM";
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

    // var utcDate = date.toUTCString();
    var utcHours = date.getUTCHours();
    let utcMinutes = date.getUTCMinutes();
    let utcSeconds = date.getUTCSeconds();
    let session = " GMT";

    utcHours = (utcHours < 10) ? "0" + utcHours : utcHours;
    utcMinutes = (utcMinutes < 10) ? "0" + utcMinutes : utcMinutes;
    utcSeconds = (utcSeconds < 10) ? "0" + utcSeconds : utcSeconds;

    let utc_time = utcHours + ':' + utcMinutes + ':' + utcSeconds + '' +session;

    document.getElementById("gmt_clock").innerHTML = utc_time;
    let t = setTimeout(function(){getUTC()}, 1000);    
}


function getCurrentDate()
{
    var date = new Date();
    // let weekday_name = date.toLocaleString('default', {weekday: 'long'});

    let weekdays = new Array(7);
    weekdays = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
    let weekday_name = weekdays[date.getDay()];

    let day = date.getDate();
    // let month = date.getMonth() + 1;
    // let month = date.toLocaleString('default', {month : 'long'});
    let months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    let month = months[date.getMonth()] ;
    let year = date.getFullYear();

    let today = weekday_name + ' '+ day + ' ' + month + ' ' + year;
    document.getElementById("current_date").innerHTML = today;
    let t = setTimeout(function(){getCurrentDate},1000);
}

getCurrentDate();

getUTC();