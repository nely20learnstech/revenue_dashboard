
google.charts.load('current', {'packages' : ['table']});
google.charts.setOnLoadCallback(drawTable);
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