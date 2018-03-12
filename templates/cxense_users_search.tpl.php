<?php 
    $user_name=isset($_GET['user_search']) ? $_GET['user_search'] : null;
    $start= isset($_GET['start']) ? $_GET['start']: date ('Y-m-j' ,strtotime ( '-1 day' , strtotime ( date('Y-m-d'))));
    $stop= isset($_GET['stop']) ? $_GET['stop']: date ('Y-m-j');
    if($user_name){
        $request='traffic/event';
        $payload='
            {"filters":
                [
                    {"type":"user","group":"elh","item":"'.$user_name.'"}
                ],
                "start":"'.date("Y-m-d\TH:i:s.000O",strtotime($start)).'",
                "stop":"'.date("Y-m-d\T23:59:59.000O",strtotime($stop)).'",
                "siteIds":["'.variable_get('siteIds_cxense', "").'"]
            }';
        $data=ShowResponse($request,$payload);
        //print"<pre>".print_r($data,1).print"</pre>"; 
    }
    


?>

<section id="form">
    <form action="" method="get">
        <div>
            <label for="user">Usuario</label>
            <input id="user" name="user_search" placeholder="Digite el usuario a buscar" type="text" value="<?php if($user_name){ print $user_name; } ?>">
        </div>  

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

<?php if($user_name){ ?>
    <?php 
        $obj=isset($data->groups[0]) ? $data->groups[0] : null;
        if($obj){?>
        <!-- Páginas visitadas -->
        <section id="pageVisit">
            <h2>Páginas visitadas</h2>
            <table class="tg">
                <tr>
                    <th class="tg-yw4l">#</th>
                    <th class="tg-yw4l">Url</th>
                    <th class="tg-yw4l">Page View</th>
                </tr>

                <?php foreach ($data->groups[5]->items as $key => $users) {?>
                    <tr>
                        <td class="tg-yw4l"><?php print $key+1 ?></td>
                        <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
                        <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '' ?></td>
                    </tr>
                <?php } ?>

            </table>
        </section>


        <!-- Tráfico desde redes sociales -->
        <section id="socialNetwork">
            <h2>Tráfico desde redes sociales</h2>
            <table class="tg">
                <tr>
                    <th class="tg-yw4l">#</th>
                    <th class="tg-yw4l">Red Social</th>
                    <th class="tg-yw4l">Page View</th>
                </tr>

                <?php foreach ($data->groups[4]->items as $key => $users) {?>
                    <tr>
                        <td class="tg-yw4l"><?php print $key+1 ?></td>
                        <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
                        <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '' ?></td>
                    </tr>
                <?php } ?>

            </table>
        </section>

        <!-- Páginas tráfico desde redes sociales -->
        <section id="referrerHost">
            <h2>Fuentes de tráfico</h2>
            <table class="tg">
                <tr>
                    <th class="tg-yw4l">#</th>
                    <th class="tg-yw4l">Fuentes</th>
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
        </section>

        <section id="referrerHost">
            <h2>Navegadores utilizados</h2>
            <table class="tg">
                <tr>
                    <th class="tg-yw4l">#</th>
                    <th class="tg-yw4l">Dispositivos</th>
                    <th class="tg-yw4l">Page View</th>
                </tr>

                <?php foreach ($data->groups[8]->items as $key => $users) {?>
                    <tr>
                        <td class="tg-yw4l"><?php print $key+1 ?></td>
                        <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
                        <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '' ?></td>
                    </tr>
                <?php } ?>

            </table>
        </section>

        <section id="referrerHost">
            <h2>Dispositivos utilizados</h2>
            <table class="tg">
                <tr>
                    <th class="tg-yw4l">#</th>
                    <th class="tg-yw4l">Dispositivos</th>
                    <th class="tg-yw4l">Page View</th>
                </tr>

                <?php foreach ($data->groups[6]->items as $key => $users) {?>
                    <tr>
                        <td class="tg-yw4l"><?php print $key+1 ?></td>
                        <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
                        <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '' ?></td>
                    </tr>
                <?php } ?>

            </table>
        </section>

        <section id="referrerHost">
            <h2>Sistemas operativos utilizados</h2>
            <table class="tg">
                <tr>
                    <th class="tg-yw4l">#</th>
                    <th class="tg-yw4l">Dispositivos</th>
                    <th class="tg-yw4l">Page View</th>
                </tr>

                <?php foreach ($data->groups[8]->items as $key => $users) {?>
                    <tr>
                        <td class="tg-yw4l"><?php print $key+1 ?></td>
                        <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
                        <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '' ?></td>
                    </tr>
                <?php } ?>

            </table>
        </section>

        <section id="referrerHost">
            <h2>Motores de busquedas utilizados</h2>
            <table class="tg">
                <tr>
                    <th class="tg-yw4l">#</th>
                    <th class="tg-yw4l">Dispositivos</th>
                    <th class="tg-yw4l">Page View</th>
                </tr>

                <?php foreach ($data->groups[16]->items as $key => $users) {?>
                    <tr>
                        <td class="tg-yw4l"><?php print $key+1 ?></td>
                        <td class="tg-yw4l"><?php print isset($users->item) ? $users->item : '' ?></td>
                        <td class="tg-yw4l"><?php print isset($users->data->events) ? number_format($users->data->events, 0, ',', '.') : '' ?></td>
                    </tr>
                <?php } ?>

            </table>
        </section>
    <?php }else{ ?> 
        <section id="not-search">
            <h3>No se encontraron resultados relacionados a la búsqueda por "<?php print $user_name; ?>"</h3>
        </section>
    <?php } ?>               
<?php }else{ ?>
    <section id="not-search">
        <h3>Por favor ingrese un nombre de usuario para iniciar la búsqueda</h3>
    </section>
<?php } ?>