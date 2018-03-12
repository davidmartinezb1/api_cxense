<?php 
    $start= isset($_GET['start']) ? $_GET['start']: date ('Y-m-j' ,strtotime ( '-1 day' , strtotime ( date('Y-m-d'))));
    $stop= isset($_GET['stop']) ? $_GET['stop']: date ('Y-m-j');
    $count=isset($_GET['ctn']) ? $_GET['ctn'] : 5;
    
    $request='traffic/event';
    $payload='
        {"fields":
            ["events","uniqueUsers"],
            "groups":
                [
                    "country",
                    "isoRegion",
                    "referrerHost"
                ],
            "start":"'.date("Y-m-d\TH:i:s.000O",strtotime($start)).'",
            "stop":"'.date("Y-m-d\TH:i:s.000O",strtotime($stop)).'",
            "siteIds":["'.variable_get('siteIds_cxense', "").'"],
            "count":'.$count.'
        }';
    $data=ShowResponse($request,$payload);

?>

<section id="form">
    <form action="" method="get">
       
        <div>
            <label for="start">Desde</label>
            <input type="date" id="start" name="start" id="start" value="<?php print date ( 'Y-m-j' ,strtotime ( '-1 day' , strtotime ( date('Y-m-d')))) ?>">
        </div>    

        <div>
            <label for="stop">Hasta</label>
            <input type="date" id="stop" name="stop" id="stop" value="<?php print date('Y-m-d') ?>">
        </div>  

        <input type="submit" value="Buscar">    
    </form>
</section>

<?php 
    $obj=isset($data->groups[0]) ? $data->groups[0] : null;
    if($obj){?>
    <section id="pageVisit">
        <h2>Fuente de tráfico de usuarios únicos</h2>
        <table class="tg">
            <tr>
                <th class="tg-yw4l">#</th>
                <th class="tg-yw4l">Fuente</th>
                <th class="tg-yw4l">Page View</th>
                <th class="tg-yw4l">Usuarios únicos</th>
            </tr>

            <?php foreach ($data->groups[0]->items as $key => $users) {?>
                <tr>
                    <td class="tg-yw4l"><?php print $key+1 ?></td>
                    <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
                    <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '' ?></td>
                    <td class="tg-yw4l"><?php print isset($users->data->uniqueUsers) ? number_format($users->data->uniqueUsers, 0, ',', '.') : '0' ?></td>
                </tr>
            <?php } ?>

        </table>
    </section>

    <section id="pageVisit">
        <h2>Tráfico por país de usuarios únicos</h2>
        <table class="tg">
            <tr>
                <th class="tg-yw4l">#</th>
                <th class="tg-yw4l">País</th>
                <th class="tg-yw4l">Page View</th>
                <th class="tg-yw4l">Usuarios únicos</th>
            </tr>

            <?php foreach ($data->groups[2]->items as $key => $users) {?>
                <tr>
                    <td class="tg-yw4l"><?php print $key+1 ?></td>
                    <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
                    <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '0' ?></td>
                    <td class="tg-yw4l"><?php print isset($users->data->uniqueUsers) ? number_format($users->data->uniqueUsers, 0, ',', '.') : '0' ?></td>
                </tr>
            <?php } ?>

        </table>
    </section>


<?php } ?>