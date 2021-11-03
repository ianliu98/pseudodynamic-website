<?php
        for ($i=0; $i<count($titles); $i++){
                $dom = new DOMDocument();
                $file_cont = file_get_contents($data_abs_path."/".$titles[$i]);
                $dom->loadHTML($file_cont);
                $imgs = $dom->getElementsByTagName('img');
                foreach ($imgs as $img) {
                        $old_src = $img->getAttribute('src');
                        $old_srcs = explode("/", $old_src);
                        $imgfile = end($old_srcs);
                        $new_src = $data_rel_path."/".basename($titles[$i],'.html')."_files/".$imgfile;
                        $img->setAttribute('src',$new_src);
                }
                $file_cont = $dom->saveHTML();
                $file_cont = urldecode($file_cont);
                file_put_contents($data_abs_path."/".$titles[$i], $file_cont);
        }
?>

