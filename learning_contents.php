<section id="content" class="show">
	<div class="content-inner-wrapper" style="margin-top: 221px;">
		<div class="collection-title-desc" data-edit-main-image="Banner">
			<div class="collection-title-basic">
				<h1 class="page-title"><?php echo $section?></h1>
			</div>
			<div class="collection-desc">
				<p>&nbsp;</p>
				<p>&nbsp;</p>
			</div>
		</div>
		<div class="main-content-wrapper" data-content-field="main-content" data-edit-main-image="Banner">

			<!-- button -->
			<button onclick="topFunction()" id="myBtn" title="Go to top"><u>Go to Top</u></button>
			<script>
				//Get the button
				var mybutton = document.getElementById("myBtn");

				// When the user scrolls down 20px from the top of the document, show the button
				window.onscroll = function() {scrollFunction()};

				function scrollFunction() {
					if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
						mybutton.style.display = "block";
					} else {
						mybutton.style.display = "none";
					}
				}

				// When the user clicks on the button, scroll to the top of the document
				function topFunction() {
					document.body.scrollTop = 0;
					document.documentElement.scrollTop = 0;
				}
			</script>

			<div class="post-wrapper">
				<div class="post-navigation hidden-mobile">

					<!-- side bar -->
					<h1>Contents</h1>
					<hr class="line-1">
					<?php
						include __DIR__."/learnings_table.php";

						include __DIR__."/mysql.php";
						$table_name = "learnings_table";
						$select = "SELECT fNAME, DATE_FORMAT(fTIME, '%M %d, %Y') FROM ".$table_name." WHERE fCATE='"
							.$basename."' ORDER BY fTIME DESC;";
						if ($records = $mysql->query($select)){
							$i = 0;
							$titles = array();
							$dates = array();
							while ($fieldinfo = $records->fetch_row()) {
								$titles[$i] = $fieldinfo[0];
								$dates[$i++] = $fieldinfo[1];
							}
						}
						$records->free_result();

						$data_abs_path = $_SERVER['DOCUMENT_ROOT']."/Learnings_file/data/".$basename;
						$data_rel_path = $base_href."/Learnings_file/data/".$basename;

						include __DIR__."/src_chk.php";

						$cfile = $_SERVER['PHP_SELF'];
						$cfile = substr($cfile,0,-4);
						$cfile_nospace = str_replace(' ', '%20', $cfile);
						for ($side=0; $side<count($titles); $side++){
							echo "<p><a href=".$cfile_nospace."#post".($side+1).">".UCwords(basename($titles[$side],'.html'))."</a></p>\n";
							echo "<hr class='line-2'>\n";
						}

					?>
				</div>
				
				<section class="body">
					<?php
						$article_number = 0;
						for ($ii=0; $ii<count($titles); $ii++){
							$article_title = basename($titles[$ii],'.html');
							$article_date = $dates[$ii];
							$article_file = $titles[$ii];
							$article_number++;

							include __DIR__."/article.php";
							echo "\n\n";
						}
					?>
				</section>

			</div>
                </div>
        </div>
</section>

