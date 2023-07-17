<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
    <script src="<?php echo base_url();?>jquery/jquery-3.6.1.min.js" defer></script>
    <script src="<?php echo base_url();?>jquery/jquery-3.6.1.js" defer></script>

    <!-- CDN de Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    
   
</head>
<body>
    <div class="menu-container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="<?php echo site_url("Chart_controller/home_contains") ?>">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/HomePage.png" alt=""></span>
                        <span class="title">Accueil</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("Chart_controller/jumboScore_contains") ?>">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/buying.png" alt=""></span>
                        <span class="title">Jumbo Score</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("Chart_controller/score_contains") ?>">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/basket_100.png" alt=""></span>
                        <span class="title">Score</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("Chart_controller/maki_contains") ?>">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/ShoppingBag.png" alt=""></span>
                        <span class="title">Supermaki</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("Chart_controller/storerank_contains") ?>">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/leaderboard.png" alt=""></span>
                        <span class="title">Classement</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="<?php echo site_url("Chart_controller/settings_contains")?>">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/settings.png" alt=""></span>
                        <span class="title">Paramètres</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url("Chart_controller/help_contains") ?>">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/help.png" alt=""></span>
                        <span class="title">Aide</span>
                    </a>
                </li> -->
            </ul>
        </div>

        <!-- <div id="show">Hide me!</div> -->

        <div class="toggle">
            <img src="<?php echo base_url(); ?>images/ChevronRight.png" alt="right chevron" class="chevron">
        </div>

    </div>

    <h1>Chiffre d'affaires</h1>

    <!-- <button class="button open-button">open modal</button>   -->
<dialog class="modal" id="modal">
    <button class="button close-button">close modal</button>
    <div class="modal_content">
    <div class="search_box">
        <form action="" method="post" id="search_form">

            <button type="submit" class="search-button" id="btn-submit">
                <img src="<?php echo base_url(); ?>images/search.png" alt="search button">
            </button>
            <input type="text" name="Text" placeholder="Search" class="search-input">

            <button type="reset" class="search-clear">
                <img src="<?php echo base_url(); ?>images/close.png" alt="clear search">
            </button>

            <div class="search-option">
                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" class="radio_btn" value="all" checked="checked">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/All.png" alt="Search radio"></span>
                    </label>
                    <span class="title">Tout</span>
                </div>

                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" class="radio_btn" value="store" >
                        <span class="icon"><img src="<?php echo base_url(); ?>images/Store.png" alt="Search radio"></span>
                    </label>
                    <span class="title">Magasin</span>
                </div>

                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" class="radio_btn" value="location">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/location.png" alt="Search radio"></span>
                    </label>               
                    <span class="title">Emplacement</span>
                </div>

                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" class="radio_btn" value="rank">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/leaderboard2.png" alt="Search radio"></span>
                    </label>
                
                    <span class="title">Rang</span>
                </div>

                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" class="radio_btn" value="time">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/Schedule.png" alt="Search radio"></span>
                    </label>              
                    <span class="title">Date/Heure</span>
                </div>
                
                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" class="radio_btn" value="product">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/product.png" alt="Search radio"></span>
                    </label>            
                    <span class="title">Produit</span>
                </div>  
            </div>    
    </form>
    <?php
        if(isset($_POST['Text']))
        {
            if(strtolower($_POST['Text']) == "score")
            {
                redirect("Chart_controller/score_contains");
            }
            else if(strtolower($_POST['Text'])== "maki" OR strtolower($_POST['Text']) == "supermaki")
            {
                redirect("Chart_controller/maki_contains");
            }
            else if(strtolower($_POST['Text']) == "jumbo" OR strtolower($_POST['Text']) == "jumbo score")
            {
                redirect("Chart_controller/jumboScore_contains");
            }
            else if(strtolower($_POST['Text']) == "classement")
            {
                redirect("Chart_controller/storerank_contains");
            }            
        }        
    ?>
</div>
<!-- <?php

if(isset($message))
{          
    echo  '<div id="not_found">'.$message.'</div>';            
}                        
else if(isset($_POST['Search']))
{    
    $table_title ="
            <table>
            <th>Rang</th>
            <th>Numéro du Magasin</th>
            <th>Nom du Magasin</th>
            <th>Adresse</th>
            <th>Chiffre d'affaires</th>";            

    if($_POST['Search'][0] == "store")
    {
        echo $table_title;

        foreach($search_result as $row)
        {
            redirect('Display_slug/view/' . $row['store_slug']);
        }
    }        
    elseif($_POST['Search'][0] == "location")
    {
        $table_title = " <table>
            <th>Rang</th>
            <th>Numéro du Magasin</th>
            <th>Nom du Magasin</th>
            <th>Adresse</th>
            <th>Chiffre d'affaires</th>";
        echo $table_title;
        foreach($search_result as $row)
        {
            echo '<tr><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_rank"].
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_num"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_name"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["address"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["total_revenue"].'</a></td></tr>';  
        }
    }
    elseif($_POST['Search'][0] == "rank")
    {
        echo $table_title;
        foreach($search_result as $row)
        {
            echo '<tr><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_rank"].
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_num"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_name"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["address"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["total_revenue"].'</a></td></tr>';    
        }
    }
    elseif($_POST['Search'][0] == "time")
    {
        $table_title .="<th>Date et heure</th>";
        echo $table_title;
        foreach($search_result as $row)
        {
            echo '<tr><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_rank"].
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_num"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_name"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["address"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["total_revenue"].'</a></td>'.
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["sell_time"].'</a></td></tr>';     
        }
    }
    else
    {
        echo $table_title;
        foreach($search_result as $row)
        {
            echo '<tr><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_rank"].
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_num"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["store_name"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["address"]. 
            '</a></td><td><a href="' . site_url('Display_slug/view/' . $row['store_slug']) . '">' . $row["total_revenue"].'</a></td></tr>';                   
        }                      
    }
    echo '</table>';
    echo $_POST['Search'][0];
}           
else
{                                    
        // echo 'We have some issues, sorry!'; 
} 

?> -->
    <div id="table_div"></div>
    </div>
</dialog>

<div class="container"> 

        <div class="contain_all">
            <div class="chart chart1" onclick="JumboScorePage()">                
                <h3 class="chart_title">Jumbo Score</h3>            
                <div class="draw"  id="drawchart3"></div>
            </div>
            <div class="chart chart2" onclick="ScorePage()">
                <h3 class="chart_title">Score</h3>
                <div class="draw" id="drawchart1"></div>
            </div>
            <div class="chart chart3" onclick="MakiPage()">
                <h3 class="chart_title">Supermaki</h3>
                <div class="draw"  id="drawchart2"></div>
            </div>          
            <div class="chart chart5">
            <h3 class="chart_title">S2M</h3>            
                <div class="S2M_chart" id="S2M_chart">
                    <!-- Div qui contient le graphique en barres. -->
                    <div id="drawchart4"></div>
                </div> 
            </div>
            <div class="chart chart4" id="store_type"></div>    
        </div> 

    </div>
<!-- </main> -->
    <section class="sidebar">
        
        <div id="timer">
            <h3 class="side_content">Heure actuelle</h3>
            <div id="current_date" onload="getCurrentDate()"></div>
            <div id="current_time" onload="currentTime()"></div>
            <div id="gmt_clock" onload="getUTC()"></div>
            <img id="clock_icon" src="<?php echo base_url(); ?>images/clock2.png" alt="clock">
        </div>
    
        <div id="revenue_value">
            <h3 class="side_content">Valeur du CA actuelle</h3>            
            <span id="money_change" class="money_change" onload="total_sales()">
                 </span><i>Ar</i>
            <img id="coins" src="<?php echo base_url(); ?>images/stack_of_coins.png" alt="stack of coins">
        </div>

        <div id="rate">            
            <h3 class="side_content">Taux de croissance</h3>
            <em>Semaine dernière : </em><span id="last_week_rate"></span><br>
            <em>Mois dernier : </em><span id="last_month_rate"></span><br>
            <em>Année dernière : </em><span id="last_year_rate"></span><br>
            <img src="<?php echo base_url(); ?>images/percentage2.png" alt="percentage" id="percentage">
        </div>        
    </section>
  
    
</section>

<script type="text/javascript" defer>

   
setInterval(function()
        {
            $.ajax({
                url: "<?php echo base_url('chart_controller/last_week_rate');?>",
                method: "POST",            
                dataType: "JSON",
                success: function(data)
                {
                    last_week_rate(data);
                    
                },
                error: function(error)
                {
                    console.log(error);
                }
            })
        }    , 1000);

        setInterval(function()
    {
    $.ajax({
            url: "<?php echo base_url('chart_controller/last_month_rate');?>",
            method: "POST",            
            dataType: "JSON",
            success: function(data)
            {
                last_month_rate(data);       
                
            },
            error: function(error)
            {
                console.log(error);
            }
        })
    }    , 1000);

    setInterval(function()
    {
    $.ajax({
            url: "<?php echo base_url('chart_controller/last_year_rate');?>",
            method: "POST",            
            dataType: "JSON",
            success: function(data)
            {
                last_year_rate(data);                
            },
            error: function(error)
            {
                console.log(error);
            }
        })
    }    , 1000);

    setInterval(function()
    {
        $.ajax({
            url: "<?php echo base_url('chart_controller/home_data');?>",
            method: "POST",
            dataType: "JSON",
            success: function(data)
            {
                total_sales(data);                
            },
            error: function(error)
            {
                console.log(error);
            } 
        })
    }    , 1000);

    function total_sales(sales)
    {
        $.each(sales, function(i, json_data){
            var global = parseFloat(json_data.total_sell);            
            var formated_number = global.toLocaleString('fr-FR');
            document.getElementById("money_change").innerHTML = formated_number;
        });        
    }

   
    function last_month_rate(sales)
    {
        $.each(sales, function(i, json_data){
            var rate = json_data.rate;
            if(isNaN(rate))
            {
                document.getElementById("last_month_rate").innerHTML = rate;
            }
            else
                document.getElementById("last_month_rate").innerHTML = rate.toFixed(2) + ' %';

            if(rate < 0)
            {
                document.getElementById("last_month_rate").style.color = "darkred";
            }
        });
        
    }

    function last_week_rate(sales)
    {
        $.each(sales, function(i, json_data){
            var rate = json_data.rate;
            if(isNaN(rate))
            {
                document.getElementById("last_week_rate").innerHTML = rate;
            }
            else
                document.getElementById("last_week_rate").innerHTML = rate.toFixed(2) + ' %';
            if(rate < 0)
            {
                document.getElementById("last_week_rate").style.color = "red";
            }
        });
        
    }

    function last_year_rate(sales)
    {
        $.each(sales, function(i, json_data){
            var rate = json_data.rate;

            if(isNaN(rate))
            {
                document.getElementById("last_year_rate").innerHTML = rate;
            }
            else
                document.getElementById("last_year_rate").innerHTML = rate.toFixed(2) + ' %';
            if(rate < 0)
            {
                document.getElementById("last_year_rate").style.color = "crimson";
            }
        });
        
    }

    // Charge l'API de visualisation et les paquets.
    google.charts.load('current', {'packages': ['corechart']});
    // Fait fonctionner un `callback` quand la Google Visualization API est chargée.
    google.charts.setOnLoadCallback(society_chart);

    google.charts.setOnLoadCallback(pie_chart);
    google.charts.setOnLoadCallback(linechart1);
    google.charts.setOnLoadCallback(linechart2);
    google.charts.setOnLoadCallback(linechart3);
    
    
    setInterval(function()
    {
        $.ajax({
            url: "<?php echo base_url('chart_controller/fetch_score_data');?>",
            method: "POST",
            // data:{} //we don't have data to send to the server
            dataType: "JSON",
            success: function(data)
            {
                linechart1(data);
                
            },
            error: function(error)
            {
                console.log(error);
            }
        })
    }    , 1000);

    setInterval(function()
        {
            $.ajax({
                url: "<?php echo base_url('chart_controller/fetch_maki_data');?>",
                method: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    linechart2(data);
                },
                error: function(error)
                {
                    console.log(error);
                }
            })
        },1000
    );

    setInterval(function()
        {
            $.ajax({
                url: "<?php echo base_url('chart_controller/fetch_jumboScore_data');?>",
                method: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    linechart3(data);
                },
                error: function(error)
                {
                    console.log(error);
                }
            })
        },1000
    );

    setInterval(function()
        {
            $.ajax({
                url: "<?php echo base_url('chart_controller/fetch_piechart_data');?>",
                method: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    pie_chart(data);
                },
                error: function(error)
                {
                    console.log(error);
                }
            })
        },1000
    );

    setInterval(function()
        {
            $.ajax({
                url: "<?php echo base_url('chart_controller/fetch_society_data');?>",
                method: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    society_chart(data);
                    
                },
                error: function(error)
                {
                    console.log(error);
                }
            })
        },1000
    );
     

    // Live search with Ajax

    $(document).ready(function(){
        $('.search-input').keyup(function(){
            var input_value = $(".search-input").val();
            var radio_value = $("input[type=radio]:checked").val();

            $(".radio_btn").on('change',function(){
                console.log(radio_value);
                $.ajax({
                url:"<?php echo base_url('chart_controller/show_result_search');?>",
                method:"POST",
                dataType: "JSON",
                data:{query:input_value, btn: radio_value},
                success: function(data){
                    scoretable(data); 
                    // console.log(data);
                    $("#table_div").html(data.message);
                },
                error: function(error){
                    console.log(error); 
                },
            })
        })         
        })
    });

    function scoretable(tableData)
    {
            var store_data = '';
            store_data +=   `
                                <table>
                                <th>Rang</th>
                                <th>Numéro du Magasin</th>
                                <th>Nom du Magasin</th>
                                <th>Adresse</th>
                                <th>Chiffre d'affaires</th>
                            `;
            $.each(tableData.search_result, function(key, value){
                
                store_data += '<tr>'
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + value.store_rank    + '</td>';
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + value.store_num    + '</td>';
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + value.store_name      + '</td>';
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + value.address     + '</td>';
                var total_revenue_formatted = parseFloat(value.total_revenue);
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + total_revenue_formatted.toLocaleString('fr-FR') + '</td>';
                store_data += '</tr>'
            });
            
            $("#table_div").html(store_data);
            store_data += '</table>';
        }

      
        function linechart1(chart_data)
        {
            var jsonData = chart_data;
            // console.log(jsonData);

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Heure de l\'achat');
            data.addColumn('number', 'Chiffres d\'affaires');
             
            let maxDatas = 30;
            $.each(jsonData, function(i, jsonData) {
                var total_sell = parseFloat(jsonData.total_sell);
                var sell_time = jsonData.sell_time;
                if(data.getNumberOfRows()>maxDatas)
                {
                    data.removeRows(0, data.getNumberOfRows() - maxDatas);
                }
                data.addRows([[sell_time,total_sell]]);
            });
        

            var options = {
            backgroundColor: {
                'fill': '#ffffff',
                'fillOpacity': 1
              },     
            colors: ['#515251'],
            legend: 'bottom',
            hAxis: {
                textStyle:{color: '#51525'},
                // textFontSize: 11,
            },  
            vAxis: {
                textStyle:{color: '#51525'},
                textFontSize: 12,
            },             
            legend: 'bottom',
            legendFontSize: 12,
            legendTextStyle:{color: '#51525'},
            chartArea: {height: '65%', top:35, right: 20, left: 90},
        }

            var chart = new google.visualization.LineChart(document.getElementById('drawchart1'));
            chart.draw(data, options);
        }

       
    // });
   

    function pie_chart(chart_data)
    {
        var jsonData = chart_data;
        
        var data = new google.visualization.DataTable();
        data.addColumn('string', "Enseigne");
        data.addColumn("number", "Chiffres d'affaires");
        
        $.each(jsonData, function(i, json_data){
            var total_sales = parseFloat(json_data.total_sales);                
            var store_type = json_data.store_type;              
            data.addRows([[store_type, total_sales]]); 
        });
        
        var options = {
            backgroundColor: 'none',           
            colors: ['whitesmoke', '#ffeaa7', '#bf981b'],
            legend: 'bottom', 
            legendTextStyle:{color: '#050404', fontSize: 14},
            pieSliceTextStyle: {
                color: '#534323',
                fontSize: 18,
              },
            title: 'Pourcentage de chaque enseigne',
            // title: {alignment:'center'},
            fontName: 'Times',        
            titleFontSize: 22,
            titleColor: '#050404',    
            chartArea: {right: 20, left: 20},                 
        }; 

        var chart = new google.visualization.PieChart(document.getElementById('store_type'));
        chart.draw(data, options);
    }


    function linechart2(chart_data)
    {
        var jsonData = chart_data;

        var data = new google.visualization.DataTable();
        data.addColumn('string', "Heure de l'achat");
        data.addColumn("number", "Chiffres d'affaires");
        let maxDatas = 30;
        $.each(jsonData, function(i, json_data){
            var total_sell = parseFloat(json_data.total_sell);
            var sell_time = json_data.sell_time;   
            if(data.getNumberOfRows() > maxDatas)
            {
                data.removeRows(0, data.getNumberOfRows() - maxDatas);
            }             
            data.addRows([[sell_time,total_sell]]); 
        }); 

        var options = {
            
            colors: ['goldenrod'],
            legend: 'bottom',
            hAxis: {
                textStyle:{color: '#51525'},
            },  
            vAxis: {
                textStyle:{color: '#51525'},
                textFontSize: 12,
            },             
            legend: 'bottom',
            legendFontSize: 12,
            legendTextStyle:{color: '#51525'},
            chartArea: {width: '80%', height: '65%', top:35, right: 20, left: 90},
        }
        var chart = new google.visualization.LineChart(document.getElementById('drawchart2'));
        
        chart.draw(data, options);
    }

    function linechart3(chart_data)
    {
        var jsonData = chart_data;
        // console.log(jsonData);

        var data = new google.visualization.DataTable();
        data.addColumn('string', "Heure de l'achat");
        data.addColumn("number", "Chiffres d'affaires");
        
        // data.addColumn("number", "Hors taxes");
        let maxDatas = 30;
        $.each(jsonData, function(i, json_data){
            var total_sell = parseFloat(json_data.total_sell);
            // var total_with_taxes = parseFloat(json_data.total_with_taxes);
            var sell_time = json_data.sell_time; 
          
            if(data.getNumberOfRows()>maxDatas)
            {
                data.removeRows(0, data.getNumberOfRows() - maxDatas);
            }
                    
            data.addRows([[sell_time,total_sell]]); 
        });   

        var options = { 
            colors: ['gold'],
            hAxis: {
                textStyle:{color: '#515251'},
            },  
            vAxis: {
                textStyle:{color: '#515251'},
                textFontSize: 12,
            },             
            legend: 'bottom',
            legendFontSize: 12,
            legendTextStyle:{color: '#515251'},
            chartArea: {width: '80%', height: '65%', top:35, right: 20, left: 100},
        }
           // when data is populated with 4 rows, remove first one [0]
       

        var chart = new google.visualization.LineChart(document.getElementById('drawchart3'));
        chart.draw(data, options);
    } 
    
    // Construit le graphique en barres représentant les magasins avec leur CA 
    // et leur taux par rapport au CA global et au CA de leur enseigne
    function society_chart(jsonData)
    {
        // Crée le data table.
        var data = new google.visualization.DataTable();        
        
        // Les colonnes nécessaires aux barres
        data.addColumn("string", "Numéro Magasin");
        data.addColumn("number", "Par rapport au CA de l'enseigne");
        data.addColumn({role: 'annotation'}, "Pourcentage");
        data.addColumn({role: 'style'});
        data.addColumn("number", "Par rapport au CA global");  
        data.addColumn({role: 'annotation'}, "Pourcentage"); 
        data.addColumn({role: 'style'});
         
        // Parcourt le tableau en format JSON pour prendre les items nécessaires 
        // à la construction des barres.
        $.each(jsonData, function(i, json_data){
            for(var j = 0; j <json_data.length; j++)
            {
                // Attribution des items correspondant aux magasins `Jumbo Score`.
                if(json_data[j].jumboScore_revenue)
                {
                    var total_sales = parseFloat(json_data[j].jumboScore_revenue);                    
                    var JumboScore_sales_rate = (json_data[j].jumboScore_sales_rate).toFixed(2) + '%';  
                    var store_num = json_data[j].jumboScore_store_num;  
                    var store_rate = (json_data[j].store_rate).toFixed(2) + '%';
                    //  Les lignes attribuées aux magasins `Jumbo Score`.
                    data.addRows([[store_num, total_sales,JumboScore_sales_rate, '#e60049', total_sales, store_rate, 'gold']]);  
                }

                // Attribution des items correspondant aux magasins `Score`.
                if(json_data[j].score_revenue)
                {
                    var total_sales = parseFloat(json_data[j].score_revenue);                     
                    var score_sales_rate = (json_data[j].score_sales_rate).toFixed(2) + '%';  
                    var store_num = json_data[j].score_store_num;  
                    var store_rate = (json_data[j].store_rate).toFixed(2) + '%'; 
                     //  Les lignes attribuées aux magasins `Score`.    
                    data.addRows([[store_num, total_sales,score_sales_rate , '#00bfa0', total_sales, store_rate , 'silver']]);  
                }

                // Attribution des items correspondant aux magasins `Supermaki`.
                if(json_data[j].maki_revenue)
                {
                    var total_sales = parseFloat(json_data[j].maki_revenue);                     
                    var maki_sales_rate = (json_data[j].maki_sales_rate).toFixed(2) + '%';  
                    var store_num = json_data[j].maki_store_num;  
                    var store_rate = (json_data[j].store_rate).toFixed(2) + '%'; 
                     //  Les lignes attribuées aux magasins `Supermaki`    
                    data.addRows([[store_num, total_sales,maki_sales_rate,'#ee0537', total_sales, store_rate, 'lawngreen']]);  
                }
            }
                                      
        });

        // Options pour la mise en forme du graphique.
        var options = {
            colors: ['#e60049', 'gold', 'red', 'green'],
            hAxis: {
                textStyle:{color: '#515251'},
                textFontSize: 16,
            },  
            vAxis: {
                textStyle:{color: '#515251'},
                textFontSize: 16,
            },             
            legendFontSize: 12,        
            legend: 'top', 
            chartArea: {width: '80%', height: '60%', top:50, right: 20, left: 100},
            annotations: {
                textStyle: {
                fontName: 'Times-Roman',
                fontSize: 18,
                bold: true,
                italic: true,                
                },            
            },            
        }

        // Instancie et dessine le graphique en passant les options définies.
        var chart = new google.visualization.ColumnChart(document.getElementById('drawchart4'));
        chart.draw(data, options);
    } 
    
    var form = document.getElementById('btn-submit');

    form.addEventListener('submit', function catch_submission(event){
        window.location.href="<?php echo site_url('Chart_controller/search'); ?>";
    });
        
    function ScorePage()
    {
        window.location.href="<?php echo site_url('Chart_controller/score_contains')?>";
    }

    function MakiPage()
    {
        window.location.href="<?php echo site_url('Chart_controller/maki_contains')?>";
    }

    function JumboScorePage()
    {
        window.location.href="<?php echo site_url('Chart_controller/jumboScore_contains')?>";
    }
   
</script>
<script src="<?php echo base_url();?>js/toggle_menu.js"></script>
<script src="<?php echo base_url();?>js/current_datetime.js"></script>
<script src="<?php echo base_url();?>js/drag_scroll.js"></script>
<script src="<?php echo base_url();?>js/script.js"></script>

</body>
</html>