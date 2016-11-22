$(document).ready(function()
{
    $('#generate-report').click(function(event)
    {
        var month = $('#month option:selected').text();
        var year = $('#year option:selected').text();
        var type = $('#admin-type').val();
        var typename = '';

        if(type=='LMO')
        {
          typename = 'Laboratory Management Office';
        }
        else
        {
          typename = 'Campus Development and Maintenance Office';
        }
        var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';

        tab_text = tab_text + '<x:Name>Room</x:Name>';

        tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
        tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

        tab_text = tab_text + "<table border='1px'>";
        tab_text = tab_text + "<center>Malayan Colleges Laguna</center>";
        tab_text = tab_text + "<center>" + typename + "</center>";
        tab_text = tab_text + "<center>Room Reservation Report</center>";
        tab_text = tab_text + "<center>" + month + " " + year + "</center>";
        tab_text = tab_text + $('#report-table').html();
        tab_text = tab_text + '</table></body></html>';

        var data_type = 'data:application/vnd.ms-excel';
        
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
            if (window.navigator.msSaveBlob) {
                var blob = new Blob([tab_text], {
                    type: "application/csv;charset=utf-8;"
                });
                navigator.msSaveBlob(blob, 'REQUESTS_' + month + '_' + year + '.xls');
            }
        } else {
            $('#generate-report').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
            $('#generate-report').attr('download', 'REQUESTS_' + month + '_' + year + '.xls');
        }

    });
});