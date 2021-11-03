<?php
        $img_path = $_SERVER['DOCUMENT_ROOT']."/Memories_file";
        $files = scandir($img_path);
        $img_date = array();
        $img_num  = array();
        $img_desc = array();
        for ($i=0; $i<count($files); $i++){
                if (!is_dir($files[$i])){
                        $img_tmp = $files[$i];
                        $img_tmp2 = explode("-",$img_tmp);
                        $date_tmp = $img_tmp2[0];
                        $desc_tmp = $img_tmp2[1];
                        $date_tmp2 = explode("_",$date_tmp);
                        $desc_tmp2 = explode(".",$desc_tmp);

                        if (count($date_tmp2)==2) {
                                array_push($img_num, $date_tmp2[1]);
                        } else {
                                array_push($img_num, 0);
                        }
                        $date_tmp3 = $date_tmp2[0];
                        $img_year = substr($date_tmp3,0,4);
                        $img_month = str_replace($img_year,'',$date_tmp3);
                        $img_date_tmp = $img_year."-".$img_month."-01";
                        array_push($img_date,$img_date_tmp);
                        array_push($img_desc,$desc_tmp2[0]);
                }
        }


        include $_SERVER['DOCUMENT_ROOT']."/include/mysql.php";

        $table_name = "memories_gallery";
        $create = "CREATE TABLE IF NOT EXISTS ".$table_name." (fTIME date, fNUM int, fDES varchar(255));";
        $mysql->query($create);

        for ($i=0; $i<count($img_date); $i++) {
                $insert_info = "INSERT INTO ".$table_name." VALUES ( '".$img_date[$i]."', ".$img_num[$i].", '".$img_desc[$i]."' );";
                $mysql->query($insert_info);
        }

        $update_1 = "CREATE TABLE tmp SELECT DISTINCT * FROM ".$table_name.";";
        $mysql->query($update_1);
        $update_2 = "DROP TABLE ".$table_name.";";
        $mysql->query($update_2);
        $update_3 = "ALTER TABLE tmp RENAME ".$table_name.";";
        $mysql->query($update_3);

        $mysql->close();

?>
