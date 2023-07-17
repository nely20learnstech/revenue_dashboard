<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?php echo base_url();?>jquery/jquery-3.6.1.js" defer></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style_rank.css"> 
    <script src="js/globaldatatables.min.js"></script>
    <title>Global Store Rank</title>

    <script type="text/javascript" defer>
        setInterval(function()
        {
            $.ajax({
                url: "<?php echo base_url('chart_controller/store_table');?>",
                method: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    storetable(data);
                },
                error: function(error)
                {
                    console.log(error);
                }
            });
        },1000
        );

        function storetable(tableData)
        {
            var store_data = '';
            store_data +=   `
                                <table>
                                <th>Rang</th>
                                <th>Numéro Magasin</th>
                                <th>Nom du Magasin</th>
                                <th>Adresse</th>            
                                <th>Chiffre d'affaires</th>
                            `;
            console.log(tableData);            
            // console.log(tableData);
            $.each(tableData, function(key, value){
                
                store_data += '<tr>'
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + value.store_rank    + '</td>';                
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + value.store_num      + '</td>';
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + value.store_name    + '</td>';
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + value.address       + '</td>';
                var total_revenue_formatted = parseFloat(value.total_revenue);
                store_data += '<td><a href="<?php echo site_url('Display_slug/view/')?>' + value.store_slug + '">' + total_revenue_formatted.toLocaleString('fr-FR') + '</td>';
                store_data += '</tr>'
            });
            
            $("#table_div").html(store_data);
            store_data += '</table>';
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
                    <a href="<?php echo site_url("Chart_controller/settings_contains") ?>">
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

    <h1>Classement des magasins</h1>
    <div class="timer_for_rank">
        <div id="current_date" onload="getCurrentDate()"></div>
        <div id="current_time" onload="currentTime()"></div>
    </div>
    <div class="search_box">     
        
        <form action="" method="post">
            <button type="submit" class="search-button" value="Submit">
                <img src="<?php echo base_url(); ?>images/search.png" alt="search button">
            </button>
            <input type="text" value="" placeholder="Rechercher" class="search-input" name="Text">

            <button type="reset" class="search-clear" value="Reset">
                <img src="<?php echo base_url(); ?>images/close.png" alt="clear search">
            </button>

            <div class="search-option">
                <div class="specific_search">
                    <label>
                        <input type="radio" name="Search[]" value="all" checked>
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
        <?php
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
                    // $table_title = "<table>
                    //     <th>Rang</th>
                    //     <th>Numéro du Magasin</th>
                    //     <th>Nom du Magasin</th>
                    //     <th>Adresse</th>
                    //     <th>Chiffre d'affaires</th>";
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
                echo '</table>';
                echo $_POST['Search'][0];
            }           
            else
            {                                    
                    echo '<div id="table_div"></div> </div>'; 
            }    

        ?>
        
    </div>
    
</body>
</html>

<script src="<?php echo base_url();?>js/toggle_menu.js"></script>
<script src="<?php echo base_url();?>js/current_datetime.js"></script>
<!-- <script src="<?php echo base_url();?>js/script_for_rank.js"></script> -->

