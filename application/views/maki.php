<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/brand.css">
    <script src="<?php echo base_url();?>jquery/jquery-3.6.1.js" defer></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="<?php echo base_url();?>js/hide_divs.js" defer></script>
    <title>Super Maki</title>
    <script type="text/javascript" defer>    
    
        setInterval(function()
            {
                $.ajax({
                        url: "<?php echo base_url('chart_controller/fetch_maki_data');?>",
                        method: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            makichart(data);
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
                        url: "<?php echo base_url('chart_controller/maki_table');?>",
                        method: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                            makitable(data);
                        },
                        error: function(error)
                        {
                            console.log(error);
                        }
                    });
                },1000
        );

        function makitable(tableData)
        {
            var store_data = '';
            store_data +=   `
                                <table>
                                <th>Rang</th>
                                <th>Numéro</th>
                                <th>Nom</th>
                                <th>Adresse</th>
                                <th>Chiffre d'affaires</th>
                            `;
                  
            // console.log(tableData);
            $.each(tableData, function(key, value){
                
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

        };         
        
        setInterval(function()
        {
            $.ajax({
                url: "<?php echo base_url('chart_controller/maki_last_week_rate');?>",
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
            url: "<?php echo base_url('chart_controller/maki_last_month_rate');?>",
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
            url: "<?php echo base_url('chart_controller/maki_last_year_rate');?>",
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
            url: "<?php echo base_url('chart_controller/maki_data');?>",
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
        // console.log(sales);
        $.each(sales, function(i, json_data){
            console.log(json_data.total_sell);
            var global = parseFloat(json_data.total_sell);            
            var formated_number = global.toLocaleString('fr-FR');
            // console.log(formated_number);
            document.getElementById("money_change").innerHTML = formated_number;
        });
        
    }

    function last_month_rate(sales)
    {
        // console.log(sales);
        $.each(sales, function(i, json_data){
            var rate = json_data.rate;
            // console.log("yesterday:" + global );
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
        // console.log(sales);
        $.each(sales, function(i, json_data){
            var rate = json_data.rate;
            // console.log("today: " + global);
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
        // console.log(sales);
        $.each(sales, function(i, json_data){
            var rate = json_data.rate;
            // console.log("today: " + global);
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


        google.charts.load('current', {'packages': ['corechart']});        

        google.charts.setOnLoadCallback(makichart);
     
        function makichart(chart_data)
        {
            var jsonData = chart_data;
            console.log(jsonData);

            var data = new google.visualization.DataTable();
            data.addColumn('string', "Heure de l'achat");
            data.addColumn("number", "Chiffres d'affaires");
            // data.addColumn("number", "Hors taxes");

            let maxDatas = 30;
            $.each(jsonData, function(i, json_data){
                var total_sell = parseFloat(json_data.total_sell);
                var total_with_taxes = parseFloat(json_data.total_with_taxes);
                var sell_time = json_data.sell_time;                
                // data.addRows([[sell_time,total_sell,total_with_taxes]]); 
                if(data.getNumberOfRows()>maxDatas)
                {
                    data.removeRows(0, data.getNumberOfRows() - maxDatas);
                }
                data.addRows([[sell_time,total_sell]]); 
            });       

            var options = {
                // backgroundColor: 'none',        
                colors: ['goldenrod'],
                legend: 'bottom',
                // explorer: {axis: 'horizontal'}
                chartArea: {width: '90%', height: '60%', top:70},
                // chartArea: { height: '60%', top:70},
            }
            
            var chart = new google.visualization.AreaChart(document.getElementById('maki_chart'));
            chart.draw(data, options);
        }

        // function drawTable2()
        // {
        //     var data = new google.visualization.DataTable();
        //     data.addColumn('number', 'Rang');
        //             data.addColumn('string', 'Nom du Magasin');
        //             data.addColumn('string', 'Adresse');
        //             data.addColumn('string', 'Ville');
        //             data.addColumn('string', 'Région');
        //             data.addColumn('string', 'Province');
        //             data.addColumn('number', 'Chiffre d\'affaires');

        //             data.addRows([            
        //                 <?php 
        //                     foreach($rank as $row)
        //                     {                        
        //                         echo "[". $row['store_rank'].",'".$row['store_name']. "','".$row['address']. "','".$row['city_name']."','" . $row['region']."','" .$row['province']."',".$row['total_revenue']."],";
        //                     }            
        //                 ?>
        //             ]);

        //     // var chart = new google.visualization.Table(document.getElementById('table_div'));
        //     var table = new google.visualization.Table(document.getElementById('table_div'));
        //     table.draw(data, {showRowNumber: true, width: '100%', height: '30%'});
                    
        // }


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
                    <a href="#">
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
 

    <h1>Supermaki</h1>
    <div class="search_box">
        <form action="" method="post">
            <button type="submit" class="search-button">
                <img src="<?php echo base_url(); ?>images/search.png" alt="search button">
            </button>
            <input type="text" name="Text" value="" placeholder="Search" class="search-input">

            <button type="reset" class="search-clear">
                <img src="<?php echo base_url(); ?>images/close.png" alt="clear search">
            </button>

            <div class="search-option">
                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" value="all" checked="checked">
                        <span class="icon"><img src="<?php echo base_url(); ?>images/All.png" alt="Search radio"></span>
                    </label>
                    <span class="title">Tout</span>
                </div>

                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" value="store">
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
                    <span class="title">Date/Heure</span>
                </div>
                
                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" value="product">
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
            else if(strtolower($_POST['Text'])== "maki" OR strtolower($_POST['Text']) == "super maki")
            {
                redirect("Chart_controller/maki_contains");
            }
            else if(strtolower($_POST['Text']) == "galana" OR strtolower($_POST['Text']) == "tsena galana")
            {
                redirect("Chart_controller/galana_contains");
            }
            else if(strtolower($_POST['Text']) == "classement")
            {
                redirect("Chart_controller/storerank_contains");
            }    
            else if(strtolower($_POST['Text']) == "accueil" OR strtolower($_POST['Text']) == "home")
            {
                redirect("Chart_controller/home_contains");
            }      
        }        
    ?>
    </div>


    <div class="container">        
       <div class="contain_maki">
       <button class="hide-container">Cacher le graphe</button>
        <div class="chart storechart">         
            <h3 class="chart_title">Supermaki</h3>
            <div class="wrapper">
                <div id="maki_chart"></div>
            </div>
        </div>
        <div class="chart rank">
            <h3 class="chart_title">Classement</h3>
            <!-- <div class="draw" id="table_div"></div>      -->

            <!-- <div id="table_result"> -->
            <?php
            // echo ' <div class="table_result"';
            if(isset($message))
            {             
                echo  '<div id="not_found">'.$message.'</div>';                 
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
                    // .="<th>Code postal</th>";
                 
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
                    echo '<div id="table_div"></div>'; 
            }    
            // echo "</div>";
        ?>      
        
            <!-- <nav class="pagination-container">
                <button id="pagination-button" id="prev-button" title="Previous page" aria-label="Previous page">
                    &lt;
                </button>

                <div id="pagination-numbers">

                </div>

                <button id="pagination-button" id="next-button" title="Next page" aria-label="Next page">
                    &gt;
                </button>
            </nav> -->
            <!-- </div> -->
        </div>
       </div>
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
        
        <span class="money_change" id="money_change" onload="total_sales()">
     
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
    
    
    <!-- <div id="tax">
        <h3 class="side_content">Taxe</h3>
        <span>20%</span>
        <img id="tax_icon" src="<?php echo base_url(); ?>images/tax.png" alt="tax">
    </div> -->
</section>
<script src="<?php echo base_url();?>js/toggle_menu.js"></script>
<!-- <script src="<?php echo base_url();?>js/script_maki.js"></script> -->
<script src="<?php echo base_url();?>js/drag_scroll.js" defer></script>
<script src="<?php echo base_url();?>js/current_datetime.js"></script>

</body>
</html>




