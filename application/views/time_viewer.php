<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/store.css">
    <script src="<?php echo base_url();?>jquery/jquery-3.6.1.js" defer></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title><?php $store["store_name"]?></title>

    <script type="text/javascript" defer>
        
        setInterval(function()
        {
            $.ajax({
                url: "<?php echo base_url('display_time_slug/fetch_store_data/') . $store["slug"] . '/' .str_replace("/", "-",$store['date_heure_extraction']);?>",
                method: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    storechart(data);
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
                url: "<?php echo base_url('display_time_slug/last_week_rate/') . $store["slug"].  '/' .str_replace("/", "-",$store['date_heure_extraction']);?>",
                method: "POST",            
                dataType: "JSON",
                success: function(data)
                {
                    show_last_week_rate(data);                    
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
                url: "<?php echo base_url('display_time_slug/last_month_rate/') . $store["slug"] .  '/' .str_replace("/", "-",$store['date_heure_extraction']);?>",
                method: "POST",            
                dataType: "JSON",
                success: function(data)
                {
                    show_last_month_rate(data);       
                    
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
                url: "<?php echo base_url('display_time_slug/last_year_rate/') . $store["slug"] .  '/' .str_replace("/", "-",$store['date_heure_extraction']);?>",
                method: "POST",            
                dataType: "JSON",
                success: function(data)
                {
                    show_last_year_rate(data);       
                    
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
                url: "<?php echo base_url('display_time_slug/actual_revenue/') . $store["slug"] .  '/' .str_replace("/", "-",$store['date_heure_extraction']);?>",
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
            var global = parseFloat(sales); 
            console.log(typeof(global));            
            var formated_number = global.toLocaleString('fr-FR');
            document.getElementById("money_change").innerHTML = formated_number;                 
        }

        function show_last_week_rate(rate)
        {
            console.log("last_week_rate = " + rate);           
                
            if(isNaN(rate))
                document.getElementById("last_week_rate").innerHTML = rate;            
            else
                document.getElementById("last_week_rate").innerHTML = rate.toFixed(2) + ' %';

            if(rate < 0)
            {
                document.getElementById("last_week_rate").style.color = "red";
            }            
        }

        function show_last_month_rate(rate)
        {          
            if(isNaN(rate))
                document.getElementById("last_month_rate").innerHTML = rate;            
            else
                document.getElementById("last_month_rate").innerHTML = rate.toFixed(2) + ' %';

            if(rate < 0)
            {
                document.getElementById("last_month_rate").style.color = "red";
            }            
        }


        function show_last_year_rate(rate)
        {
            if(isNaN(rate))
                document.getElementById("last_year_rate").innerHTML = rate;            
            else
                document.getElementById("last_year_rate").innerHTML = rate.toFixed(2) + ' %';

            if(rate < 0)
            {
                document.getElementById("last_year_rate").style.color = "crimson";
            }
        }

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(storechart);
        function storechart(chart_data)
        {
            var jsonData = chart_data;
            // console.log(jsonData);

            var data = new google.visualization.DataTable();
            data.addColumn('string', "Heure de l'achat");
            data.addColumn("number", "Chiffres d'affaires");

            $.each(jsonData, function(i, json_data){
                var total_sell = parseFloat(json_data.total_sell);
                var sell_time = json_data.sell_time;                
                data.addRows([[sell_time,total_sell]]);
            });

            var options = {
                colors: ['limegreen', 'aliceblue'],
                legend: 'bottom',
                chartArea: {width: '85%', height: '60%', top:70},
            }
            
            var chart = new google.visualization.AreaChart(document.getElementById('maki_chart'));
            chart.draw(data, options);
        }

    </script>
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
                        <span class="title">SuperMaki</span>
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

        <div class="toggle">
            <img src="<?php echo base_url(); ?>images/ChevronRight.png" alt="right chevron" class="chevron">
        </div>

    </div>
 
    <div class="header">
        <h1><?php echo $store["store_name"]?></h1>
        <h2>Magasin: <span><?php echo $store["store_type_name"]?></span></h2>
        <h2>Date et heure: <span><?php echo $store["date_heure_extraction"]?></span></h2>
        <h3>Numéro: <span><?php echo $store["store_num"]?></span></h3>
    </div>
 
<form action="" method="post">
<div class="search_box">
        <button type="submit" class="search-button">
            <img src="<?php echo base_url(); ?>images/search.png" alt="search button">
        </button>
        <input type="text" name="Text" placeholder="Search" class="search-input">

        <button type="reset" class="search-clear">
            <img src="<?php echo base_url(); ?>images/close.png" alt="clear search">
        </button>

        <div class="search-option">
            <div class="specific_search">
                <label>
                    <input type="radio" name="Search[]" value="all">
                    <span class="icon"><img src="<?php echo base_url(); ?>images/All.png" alt="Search radio"></span>
                </label>
                <span class="title">Tout</span>
            </div>

            <div class="specific_search">
                <label>
                    <input type="radio" name="Search[]" value="store" checked="checked">
                    <span class="icon"><img src="<?php echo base_url(); ?>images/Store.png" alt="Search radio"></span>
                </label>
                <span class="title">Magasin</span>
            </div>

            <div class="specific_search">
                <label>
                    <input type="radio" name="Search[]" value="location">
                    <span class="icon"><img src="<?php echo base_url(); ?>images/location.png" alt="Search radio"></span>
                </label>               
                <span class="title">Emplacement</span>
            </div>

            <div class="specific_search">
                <label>
                    <input type="radio" name="Search[]" value="rank">
                    <span class="icon"><img src="<?php echo base_url(); ?>images/leaderboard2.png" alt="Search radio"></span>
                </label>
               
                <span class="title">Rang</span>
            </div>

            <div class="specific_search">
                <label>
                    <input type="radio" name="Search[]" value="time">
                    <span class="icon"><img src="<?php echo base_url(); ?>images/Schedule.png" alt="Search radio"></span>
                </label>              
                <span class="title">Date / Heure</span>
            </div>
            
            <div class="specific_search">
                <label>
                    <input type="radio" name="Search[]" value="product">
                    <span class="icon"><img src="<?php echo base_url(); ?>images/product.png" alt="Search radio"></span>
                </label>            
                <span class="title">Produit</span>
            </div>  
        </div>
    </div>
    <?php
        if(isset($_POST['Text']))
        {
            if(strtolower($_POST['Text']) == "score")
            {
                redirect("Chart_controller/score_contains");
            }
            else if(strtolower($_POST['Text'])== "maki" OR strtolower($_POST['Text']) == "super maki")
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
</form>


    <div class="container">      
    <?php

if(isset($message))
{          
    echo  '<div id="not_found">'.$message.'</div>';       
// <?php
}                        
else if(isset($_POST['Search']))
{
    
    $table_title ="
    <div id='response_container'>  
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
        $table_title ="<div id='response_container'>
        <table>
        <th>Numéro du Magasin</th>
        <th>Nom du Magasin</th>
        <th>Adresse</th>
        <th>Chiffre d'affaires</th>
        <th>Date et heure</th>";
        echo $table_title;
        foreach($search_result as $row)
        {
            $formatted_datetime = str_replace("/", "-",$row['sell_time']);
            echo 
            // '<tr><td><a href="' . site_url('Display_time_slug/view/' . $row['store_slug']) . '/' .  '">' . $formatted_datetime. $row["store_rank"] .
            '<tr></a></td><td><a href="' . site_url('Display_time_slug/view/' . $row['store_slug']) . '/' . $formatted_datetime. '">' . $row["store_num"]. 
            '</a></td><td><a href="' . site_url('Display_time_slug/view/' . $row['store_slug']) . '/' . $formatted_datetime. '">' . $row["store_name"]. 
            '</a></td><td><a href="' . site_url('Display_time_slug/view/' . $row['store_slug']) . '/' . $formatted_datetime. '">' . $row["address"]. 
            '</a></td><td><a href="' . site_url('Display_time_slug/view/' . $row['store_slug']) . '/' . $formatted_datetime. '">' . $row["total_revenue"].
            '</a></td><td><a href="' . site_url('Display_time_slug/view/' . $row['store_slug']) . '/' . $formatted_datetime. '">' . $row["sell_time"].'</a></td></tr>';  

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
    echo '</table></div>';
    echo $_POST['Search'][0];
}           
else
{                                    
    echo'
        <div class="chart storechart">
        <h3 class="chart_title">'.$store["store_name"].'</h3>
        <div class="wrapper">
                <div id="maki_chart"></div>
        </div>
    </div>    
   </div>';
}    
?> 
</div>   
   

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
        
        <span class="money_change" id="money_change" onload="total_sales()"></span><i>Ar</i>
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
<script src="<?php echo base_url();?>js/toggle_menu.js"></script>
<script src="<?php echo base_url();?>js/current_datetime.js"></script>
<script src="<?php echo base_url();?>js/drag_scroll.js"></script>

</body>
</html>