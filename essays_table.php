<?php

	// This file is used to update the table that stores learnings information
	// connection to MySQL database is necessary
	//
	// This program wil create new entries for new files, and delete extra entries 
	// while files are removed -> a recursive method is implemented
	
	include __DIR__."/mysql.php";	// MySQL API based on mysqli

	/* funtion: recursively fetche file information and update table
	 *   INPUT: $path    -> path to the target dirctory
	 *          $names   -> an array of file names fetched from table
	 *          $sqli    -> mysqli class
	 *          $old_k   -> an array of file names fetched from the old table (we do not modify file info that in the old table)
	 *          $old_a1  -> an associated array stored file names and file time fetched from the old table
	 *          $old_a2  -> an associated array stored file names and file category fetched from the old table
	 */
	function recursiveUP ($path, $names, $sqli, $tbnm, $tb_old, $old_k){
		$files = scandir($path);
		for ($i=2; $i<count($files); $i++){
			if (is_file($path."/".$files[$i])){
				$new_time = date("Y-m-d", filemtime($path."/".$files[$i]));
				$category = explode("/",$path);
				$files_tmp = explode(".", $files[$i]);
				if (in_array($files[$i], $names)){
					$sqli->query("UPDATE ".$tbnm." SET fLABEL=1 WHERE fNAME='".$files[$i]."';");
					$old_time_tmp = $sqli->query("SELECT fTIME FROM ".$tbnm." WHERE fNAME='".$files[$i]."';");
					$old_time = $old_time_tmp->fetch_row();
					$old_time_tmp->free_result();
					if ($new_time != $old_time[0]){
						if (in_array($files_tmp[0], $old_k)){
							$fetch_time = "SELECT fTIME FROM ".$tb_old." WHERE fNAME='".$files_tmp[0]."';";
							$fetch_tmp = $sqli->query($fetch_time);
							$fetched_time = $fetch_tmp->fetch_row();
							$fetch_tmp->free_result();
							$time_modify = "UPDATE ".$tbnm." SET fTIME='".$fetched_time[0]."' WHERE fNAME='".$files[$i]."';";
						} else {
							$time_modify = "UPDATE ".$tbnm." SET fTIME='".$new_time."' WHERE fNAME='".$files[$i]."';";
						}
						$sqli->query($time_modify);
					} else {
						continue;
					}
				} else {
					if (in_array($files_tmp[0], $old_k)){
						$fetch_time = "SELECT fTIME FROM ".$tb_old." WHERE fNAME='".$files_tmp[0]."';";
						$fetch_tmp = $sqli->query($fetch_time);
						$fetched_time = $fetch_tmp->fetch_row();
						$fetch_tmp->free_result();
						$insertion = "INSERT INTO ".$tbnm." (fNAME, fTIME, fLABEL) VALUES ('".$files[$i]."','".$fetched_time[0]."', 1);";
					} else {
						$insertion = "INSERT INTO ".$tbnm." (fNAME, fTIME, fLABEL) VALUES ('".$files[$i]."','".$new_time."', 1);";
					}
					$sqli->query($insertion);
				}
			} else if (substr($files[$i],-5)!="files"){
				recursiveUP($path."/".$files[$i], $names, $sqli, $tbnm, $tb_old, $old_k);
			}
		}
        }


	// create a table if not exists
	$table_name = "essays_table";
	$create = "CREATE TABLE IF NOT EXISTS ".$table_name." (fID int PRIMARY KEY AUTO_INCREMENT, fNAME varchar(50), fTIME date, fCATE varchar(50) DEFAULT 'category', fLABEL bool);";
        $mysql->query($create);

	// fetch file names from table, if newly created, then empty array 
        if ($records = $mysql->query("SELECT fNAME FROM ".$table_name.";")){
                $i = 0;
                $fnames = array();
                while ($fieldinfo = $records->fetch_row()){
                        $fnames[$i++] = $fieldinfo[0];
                }
        }
        $records->free_result();

	// fetch info from the old table -> this table is created by old_learnings.php with some modifications (normally, we don't need do this, for the table is already there.)
        $table_old = "old_essays";
        if ($records_old = $mysql->query("SELECT fNAME, fTIME FROM ".$table_old.";")){
                $i = 0;
                $old_items = array();
                while ($fieldinfo_old = $records_old->fetch_row()){
                        $old_items[$i++] = $fieldinfo_old[0];
                }
        }
        $records_old->free_result();


	// path to the learnings data directory
        $essays_dir = $_SERVER['DOCUMENT_ROOT']."/Essays_file/data";

        $reset = "UPDATE ".$table_name." SET fLABEL=0;";  // use a fLABEL field to remove extra entries
        $mysql->query($reset);
        recursiveUP($essays_dir, $fnames, $mysql, $table_name, $table_old, $old_items);
        $remove_extra = "DELETE FROM ".$table_name." WHERE fLABEL=0";
        $mysql->query($remove_extra);


	// create file.php in ./Essays_file/
	$essays_single_dir = $_SERVER['DOCUMENT_ROOT']."/Essays_file";
	$src = $essays_single_dir."/on observation.php";
	$essay_phps_dir = scandir($essays_single_dir);
	$essay_phps = array();
	for ($i=0; $i<count($essay_phps_dir); $i++){
		if (is_file($essay_phps_dir[$i])) {
			array_push($essay_phps, basename($essay_phps_dir[$i], '.php'));
		}
	}
        if ($records = $mysql->query("SELECT fNAME FROM ".$table_name.";")){
                $i = 0;
                $fnames_new = array();
                while ($fieldinfo = $records->fetch_row()){
                        $fnames_new[$i++] = $fieldinfo[0];
                }
        }
        $records->free_result();
	for ($i=0; $i<count($fnames_new); $i++){
		if (!in_array(basename($fnames_new[$i],'.html'), $essay_phps)){
			copy($src, $essays_single_dir."/".basename($fnames_new[$i],'.html').".php");	
		}
	}
	for ($i=0; $i<count($essay_phps); $i++){
		if (!in_array($essay_phps[$i].".html", $fnames_new)){
			unlink($essays_single_dir."/".$essay_phps[$i].".php");
		}
	}


        $mysql->close();

?>
