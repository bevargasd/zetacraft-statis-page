<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="cs">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Zetacraft &ndash; Sanciones</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link
            href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
            rel="stylesheet">
        <link rel="shortcut icon" href="../public/images/favicon.ico">
        <link rel="stylesheet" href="../public/css/style.css">
    </head>

    <body>
        <main>
            <header id="particles-js" class="d-flex flex-column small">
                <div class="bars">
                </div>
                <div class="navigation d-flex justify-content-between align-items-center row">
                    <div class="left d-flex align-items-center">
                        <div class="logo"></div>
                        <p>Your-Site.com</p>
                        <nav class="nav">
                            <a class="nav-link" href="../">Inicio</a>
                            <a class="nav-link" href="/adminteam">STAFF</a>
                            <a class="nav-link" href="https://zetacraft.tebex.io/">Tienda</a>
                        </nav>
                    </div>
                </div>
            <div class="content m-auto">
                <h1>Sanciones</h1>
            </div>
        </header>

        <section id="banlist">
            <div class="row">
                <div class="info">
                    <p>¿Te gustaría revisar si algún usuario ha sido sancionado?, ¡Este es tu lugar!.</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Sanción</th>
                                <th scope="col">Id</th>
                                <th scope="col">Jugador</th>
                                <th scope="col">Staff</th>
                                <th scope="col">Razón</th>
                                <th scope="col">Expiración</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                include '../database.php';
				    	    	$db = mysqli_connect($db_host, $db_user, $db_password, $db_bans);
				    	    	$db->set_charset("utf8");
				    	    	$selectban = mysqli_query($db, "SELECT * FROM `litebans_bans` ORDER BY `litebans_bans`.`id` DESC");
				    	    	while ($row = mysqli_fetch_assoc($selectban)) {
				    	    		$selectplayer = mysqli_query($db, "SELECT * FROM litebans_history WHERE uuid = '" . $row['uuid'] . "'");
				    	    		while ($row2 = mysqli_fetch_assoc($selectplayer)) {
				    	    			if ($row['banned_by_name'] == null) {
				    	    				$row['banned_by_name'] = 'Console';
				    	    			}
				    	    			if ($row['reason'] == null) {
				    	    				$row['reason'] = 'The reason was not specified.';
				    	    			}
				    	    			if ($row['until'] == -1) {
				    	    				$expire = '<span class="badge badge-danger">Never</span>';
				    	    			} else {
				    	    				$expire = '<span class="badge badge-success">' . date("H:i:s d.m.Y", ($row['until'] / 1000)) . '</span>';
				    	    			}
				    	    			if ($row['active'] == '1') {
                                            $banlist[] = array (
                                                "type"           => 'ban',
                                                "id"             => $row['id'],
                                                "timestamp"      => $row['time'],
                                                "name"           => $row2['name'],
                                                "banned_by_name" => $row['banned_by_name'],
                                                "reason"         => $row['reason'],
                                                "expire"         => $expire,
                                            );
				    	    			}
				    	    		}
				    	    	}
                                $selectkick = mysqli_query($db, "SELECT * FROM `litebans_kicks` ORDER BY `litebans_kicks`.`id` DESC");
				    	    	while ($row = mysqli_fetch_assoc($selectkick)) {
				    	    		$selectplayer = mysqli_query($db, "SELECT * FROM litebans_history WHERE uuid = '" . $row['uuid'] . "'");
				    	    		while ($row2 = mysqli_fetch_assoc($selectplayer)) {
				    	    			if ($row['banned_by_name'] == null) {
				    	    				$row['banned_by_name'] = 'Console';
				    	    			}
				    	    			if ($row['reason'] == null) {
				    	    				$row['reason'] = 'The reason was not specified.';
				    	    			}
				    	    			$expire = '<span class="badge badge-danger">Never</span>';
                                        $banlist[] = array (
                                            "type"           => 'kick',
                                            "id"             => $row['id'],
                                            "timestamp"      => $row['time'],
                                            "name"           => $row2['name'],
                                            "banned_by_name" => $row['banned_by_name'],
                                            "reason"         => $row['reason'],
                                            "expire"         => $expire,
                                        );
				    	    		}
				    	    	}
                                $selectmute = mysqli_query($db, "SELECT * FROM `litebans_mutes` ORDER BY `litebans_mutes`.`id` DESC");
				    	    	while ($row = mysqli_fetch_assoc($selectmute)) {
				    	    		$selectplayer = mysqli_query($db, "SELECT * FROM litebans_history WHERE uuid = '" . $row['uuid'] . "'");
				    	    		while ($row2 = mysqli_fetch_assoc($selectplayer)) {
				    	    			if ($row['banned_by_name'] == null) {
				    	    				$row['banned_by_name'] = 'Console';
				    	    			}
				    	    			if ($row['reason'] == null) {
				    	    				$row['reason'] = 'The reason was not specified.';
				    	    			}
				    	    			if ($row['until'] == -1) {
				    	    				$expire = '<span class="badge badge-danger">Never</span>';
				    	    			} else {
				    	    				$expire = '<span class="badge badge-success">' . date("H:i:s d.m.Y", ($row['until'] / 1000)) . '</span>';
				    	    			}
				    	    			if ($row['active'] == '1') {
                                            $banlist[] = array (
                                                "type"           => 'mute',
                                                "id"             => $row['id'],
                                                "timestamp"      => $row['time'],
                                                "name"           => $row2['name'],
                                                "banned_by_name" => $row['banned_by_name'],
                                                "reason"         => $row['reason'],
                                                "expire"         => $expire,
                                            );
				    	    			}
				    	    		}
				    	    	}
                                $selectwarn = mysqli_query($db, "SELECT * FROM `litebans_warnings` ORDER BY `litebans_warnings`.`id` DESC");
				    	    	while ($row = mysqli_fetch_assoc($selectwarn)) {
				    	    		$selectplayer = mysqli_query($db, "SELECT * FROM litebans_history WHERE uuid = '" . $row['uuid'] . "'");
				    	    		while ($row2 = mysqli_fetch_assoc($selectplayer)) {
				    	    			if ($row['banned_by_name'] == null) {
				    	    				$row['banned_by_name'] = 'Console';
				    	    			}
				    	    			if ($row['reason'] == null) {
				    	    				$row['reason'] = 'The reason was not specified.';
				    	    			}
				    	    			if ($row['until'] == -1) {
				    	    				$expire = '<span class="badge badge-danger">Never</span>';
				    	    			} else {
				    	    				$expire = '<span class="badge badge-success">' . date("H:i:s d.m.Y", ($row['until'] / 1000)) . '</span>';
				    	    			}
				    	    			if ($row['active'] == '1') {
                                            $banlist[] = array (
                                                "type"           => 'warn',
                                                "id"             => $row['id'],
                                                "timestamp"      => $row['time'],
                                                "name"           => $row2['name'],
                                                "banned_by_name" => $row['banned_by_name'],
                                                "reason"         => $row['reason'],
                                                "expire"         => $expire,
                                            );
				    	    			}
				    	    		}
				    	    	}
				    	    	mysqli_close($db);
                                function compareByTimeStamp($time1, $time2) {
                                    if (@strtotime($time1) < @strtotime($time2))
                                        return 1;
                                    else if (@strtotime($time1) > @strtotime($time2)) 
                                        return -1;
                                    else
                                        return 0;
                                }
                                usort($banlist, "compareByTimeStamp");
                                foreach ($banlist as $punish) {
                                    echo '<tr>';
                                        echo '<td class="' . $punish['type'] . '">' . ucfirst($punish['type']) . '</td>';
				    	    			echo '<td>' . $punish['id'] . '</td>';
				    	    			echo '<td><img src="https://minotar.net/avatar/' . $punish['name'] . '/30" alt=""> ' . $punish['name'] . '</td>';
				    	    			echo '<td><img src="https://minotar.net/avatar/' . $punish['banned_by_name'] . '/30" alt=""> ' . $punish['banned_by_name'] . '</td>';
				    	    			echo '<td>' . $punish['reason'] . '</td>';
				    	    			echo '<td>' . $punish['expire'] . '</td>';
				    	    		echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <footer>
        <div class="row">
                <div class="col-md-10 offset-md-1 row align-items-center">
                    <div class="col-md info">
                        <p>¿Qué esperas?, ¡Entra ya!</p>
                        <p class="ip">MC.ZETACRAFT.CL</p>
                    </div>
                    <div class="col-md copyright">
                        <p>Nosotros no estamos afiliados con Mojang.</p>
                        <p>&copy; <span class="year"></span> Zetacraft 1.18.</p>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <script type="text/javascript" src="../public/js/particles.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="../public/js/main.js"></script>
    <script>
        $('.year').text(new Date().getFullYear());
    </script>
</body>

</html>