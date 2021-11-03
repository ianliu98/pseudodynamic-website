<?php
        $musings_file = $_SERVER['DOCUMENT_ROOT']."/Musings_file/musings.txt";
        $fp = fopen($musings_file, 'r');
        $musing_dates = array();
        $musing_conts = array();
        while ($string=fgets($fp)) {
                if (preg_match('/\d{4}-\d{1,2}-\d{1,2}/', $string)){
                        array_push($musing_dates, rtrim($string));
                } else if (strlen($string) > 1) {
                        array_push($musing_conts, rtrim($string));
                }
        }

        include $include_dir."mysql.php";
        $table_name = "musings_table";
        $create = "CREATE TABLE IF NOT EXISTS ".$table_name." (fTIME date, fCON text);";

	$mysql->query($create);

        for ($i=0; $i<count($musing_dates); $i++) {
                $insert = "INSERT INTO ".$table_name." VALUES ('".$musing_dates[$i]."', '".$musing_conts[$i]."' );";
                $mysql->query($insert);
        }

        $mysql->query("CREATE TABLE tmp SELECT DISTINCT * FROM ".$table_name.";");
        $mysql->query("DROP TABLE ".$table_name.";");
        $mysql->query("ALTER TABLE tmp RENAME ".$table_name.";");

	$extra = $mysql->query("SELECT fCON FROM ".$table_name.";");
	$i = 0;
	$fcon_old = array();
	while ($fieldinfo = $extra->fetch_row()) {
		if (!in_array($fieldinfo[0], $musing_conts)){
			$mysql->query("DELETE FROM ".$table_name." WHERE fCON='".$fieldinfo[0]."';");
		}
	}

        $mysql->close();
?>

