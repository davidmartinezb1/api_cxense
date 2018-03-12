<?php 
    $request='traffic';
    $payload='
        {
        "fields":
            ["events","uniqueUsers","sessionStarts","sessionBounces","activeTime"],
            "start":"2018-02-15T00:00:00.000-05:00",
            "stop":"2018-02-15T10:30:57.000-05:00",
            "siteIds":["'.variable_get('siteIds_cxense', "").'"]
        }';
    $data=ShowResponse($request,$payload);
    $page_user=round(($data->data->events)/($data->data->uniqueUsers),2);

    $settings['chart']['chartOne'] = array(  
        'header' => array('Page View', 'Usuarios únicos', 'Page View / Usuarios', 'Rebote', 'Tiempo'),
        'rows' => array(
            array(
                 number_format($data->data->events, 0, ',', '.'), 
                 number_format($data->data->uniqueUsers, 0, ',', '.'), 
                 number_format($page_user, 0, ',', '.'),
                 number_format($data->data->sessionBounces, 0, ',', '.'),
                 number_format($data->data->activeTime, 0, ',', '.')
            )
        ),
        'columns' => array(''),
        'chartType' => 'PieChart',
        'containerId' =>  'content',
        'options' => array( 
            'curveType' => "function",
            'is3D' => TRUE,
            'forceIFrame' => TRUE,
            'title' => 'Reporte General',
            'width' => 500,
            'height' => 300
        )   
    );
     


?>
<section>
    <?php $ret = draw_chart($settings); ?>
</section>

<?php  print"<pre>".print_r($data,1).print"</pre>"; ?>