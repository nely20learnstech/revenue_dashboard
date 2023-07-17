google.charts.load('current', {'packages': ['corechart']});
google.charts.load('current', {'packages' : ['table']});

   
    google.charts.setOnLoadCallback(pie_chart);
    google.charts.setOnLoadCallback(linechart1);
    google.charts.setOnLoadCallback(linechart2);
    google.charts.setOnLoadCallback(linechart3);
    google.charts.setOnLoadCallback(drawTable);
    
    function pie_chart()
    {
        var data = google.visualization.arrayToDataTable([
            ['Chiffres d\'affaires', 'Heure de l\'achat'],
            ['Score', 36],
            ['Super Maki',36],
            ['Tsena Galana', 33]            
        ]);

        var options = {
            backgroundColor: 'none',           
            title: 'Per store type',
            colors: ['dodgerblue', 'lightblue', 'lightgray'],
            legend: 'bottom',                      
        }; 

        var chart = new google.visualization.PieChart(document.getElementById('store_type'));
        chart.draw(data, options);

    }

    function linechart1()
    {
        var data = google.visualization.arrayToDataTable([
            ["Heure de l'achat","Chiffres d'affaires", 'Hors Taxes'],
            ['08:56:03', 150000, 14800],
            ['08:57:03', 1500, 1400],
            ['08:59:03', 80000, 78000],
            ['09:26:03', 180000, 17650],
            ['09:56:03', 450000, 412364]
        ]);

        var options = {
            backgroundColor: 'none',
            // title: 'Magasins Score',        
            colors: ['blue', 'lightblue'],
            legend: 'bottom'
        }

        var chart = new google.visualization.LineChart(document.getElementById('drawchart1'));
        chart.draw(data, options);
    }

    function linechart2()
    {
        var data = google.visualization.arrayToDataTable([
            ["Chiffres d'affaires", "Heure de l'achat"],
            ['08:56:03', 100],
            ['08:57:03', 1500],
            ['08:59:03', 280000],
            ['09:26:03', 160000],
            ['09:56:03', 4500]
        ]);

        var options = {
            backgroundColor: 'none',
            // title: 'Magasins ', 
            // width: '350px',
            colors: ['crimson'],
            legend: 'bottom',
        }

        var chart = new google.visualization.AreaChart(document.getElementById('drawchart2'));
        
        chart.draw(data, options);
    }

    function makichart()
    {
        var data = google.visualization.arrayToDataTable([
            ["Chiffres d'affaires", "Heure de l'achat"],
            ['08:56:03', 100],
            ['08:57:03', 1500],
            ['08:59:03', 280000],
            ['09:26:03', 160000],
            ['09:56:03', 4500]
        ]);

        var options = {
            backgroundColor: 'none',
            // title: 'Magasins ', 
            // width: '350px',
            colors: ['crimson'],
            legend: 'bottom',
        }
        
        var chart = new google.visualization.AreaChart(document.getElementById('maki_chart'));
        chart.draw(data, options);
    }

    function linechart3()
    {
        var data = google.visualization.arrayToDataTable([
            ["Chiffres d'affaires", "Heure de l'achat"],
            ['08:56:03', 150000],
            ['08:57:03', 1500],
            ['08:59:03', 80000],
            ['09:26:03', 180000],
            ['09:56:03', 450000]
        ]);

        var options = {
            backgroundColor: 'none',
            // title: 'Magasins Score', 
            colors: ['forestgreen'],
            legend: 'bottom',
        }

        var chart = new google.visualization.AreaChart(document.getElementById('drawchart3'));
        chart.draw(data, options);
    } 
    
    
    function drawTable()
    {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Store Name');
        data.addColumn('string', 'Store Address');
        data.addColumn('number', 'Total Sell');
        data.addColumn('string', 'Sell Time');

        data.addRows([

        ['Score Rue Colbert' , 'Diégo-Suarez', 150000, '09:02:03'],
        ['Score Rue Point 6' , 'Diégo-Suarez', 140000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 130000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 120000, '09:02:03'],
        ['Score Ankorondrano' , 'Antananarivo', 110000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 100000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 90000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 80000, '09:02:03'],
        ['Score Ambatomena'  , 'Fianarantsoa', 70000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 60000, '09:02:03'],
                          
        ]);

        // var chart = new google.visualization.Table(document.getElementById('table_div'));
        var table = new google.visualization.Table(document.getElementById('store_rank'));
        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
                
    }

    function drawTable2()
    {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Store Name');
        data.addColumn('string', 'Store Address');
        data.addColumn('number', 'Total Sell');
        data.addColumn('string', 'Sell Time');

        data.addRows([

        ['Score Rue Colbert' , 'Diégo-Suarez', 150000, '09:02:03'],
        ['Score Rue Point 6' , 'Diégo-Suarez', 140000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 130000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 120000, '09:02:03'],
        ['Score Ankorondrano' , 'Antananarivo', 110000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 100000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 90000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 80000, '09:02:03'],
        ['Score Ambatomena'  , 'Fianarantsoa', 70000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 60000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 50000, '09:02:03'],
        ['Score Ambatomena'  , 'Fianarantsoa', 70000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 60000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 50000, '09:02:03'],
        ['Score Rue Colbert' , 'Diégo-Suarez', 50000, '09:02:03']         
        ]);

        // var chart = new google.visualization.Table(document.getElementById('table_div'));
        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
                
    }