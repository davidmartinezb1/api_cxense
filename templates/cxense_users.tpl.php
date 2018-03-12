<?php 
    $count=isset($_GET['ctn']) ? $_GET['ctn'] : 30;
    $start=isset($_GET['start']) ? $_GET['start'] : date("Y-m-d\TH:i:s.000O");
    $stop=isset($_GET['stop']) ? $_GET['stop'] : date("Y-m-d\TH:i:s.000O");

    $request='traffic/user';
    $payload='
        {"fields":
            ["events"],
            "groups":["elh"],
            "start":"2018-02-14T00:00:00.000-05:00",
            "stop":"2018-02-14T10:09:14.000-05:00",
            "siteIds":["'.variable_get('siteIds_cxense', "").'"],
            "count":'.$count.'}';

    $data=ShowResponse($request,$payload);
    //print"<pre>".print_r($data,1).print"</pre>"; 
?>

<form action="" method="get">
    <label for="ctn">Cantidad de usuarios</label>
    <input id="ctn" name="ctn" type="number" value="<?php print $count ?>">
    <input type="submit" value="Consultar">    
</form>

<hr><br>

<table class="tg">
    <tr>
        <th class="tg-yw4l">#</th>
        <th class="tg-yw4l">Usuario</th>
        <th class="tg-yw4l">Page View</th>
    </tr>

    <?php foreach ($data->groups[0]->items as $key => $users) {?>
        <tr>
            <td class="tg-yw4l"><?php print $key+1 ?></td>
            <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
            <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '' ?></td>
        </tr>
    <?php } ?>

</table>

