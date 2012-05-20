jQuery.fn.parseXml = function(){
    $.ajax({
        type: "GET",
        url: "./ready/sample0/results.xml",
        dataType: "xml",
        success: function(xml) {
        $(xml).find('measures').each(function(){
            var comId = $(this).attr('comId');
            $('<div class="commission" id="com_'+comId+'"></div>').html('<h1>Commission: ' + comId + '</h1>').appendTo('#container');
            $('<div style="display: none"></div>').html('<table class="commission_table" id="comTable_'+comId+'"></table>').appendTo('#com_'+comId);
            var headers = '<th>Holon ID</th><th>Number of commissions</th>';
            headers += '<th>Average distance from current location to base for all commissions</th>';
            headers += '<th>Average distance per commission before change</th>';
            $('<tr></tr>').html(headers).appendTo('#comTable_'+comId);
            $(this).find('holon').each(function(){
                var holonId = $(this).attr('id');
                
                $('<tr id="holon_'+holonId+'"></tr>').html('<td>'+ holonId + '</td>').appendTo('#comTable_'+comId);
                
                $(this).find('measure').each(function() {
                    // convert BigCamelCase to 'Big Camel Case'
                    var name = $(this).attr('name').replace(/([a-z])([A-Z])/g, '$1 $2');
                    var value = $(this).text();
                    $('<td></td>').html(value).appendTo('#com_' + comId + ' #holon_'+holonId);
                    
                });
            });         
            
        });
        }
    });
};