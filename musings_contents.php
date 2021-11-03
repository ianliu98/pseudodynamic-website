<section id="content" class="show">
        <div class="content-inner-wrapper" style="margin-top: 221px;">
                <div class="collection-title-desc" data-edit-main-image="Banner">
                        <div class="collection-title-basic">
				<h1 class="page-title"><?php echo $section ?></h1>
                        </div>
                </div>
                <div class="main-content-wrapper" data-content-field="main-content" data-edit-main-image="Banner">
                        <div class="post-wrapper">
                                <section class="body">

					<?php
						include __DIR__."/musings_table.php";
						include __DIR__."/mysql.php";

						$table_name = "musings_table";
						$musing_sql = "SELECT DATE_FORMAT(fTIME, '%M %d, %Y'), fCON FROM ".$table_name." ORDER BY fTIME DESC;";
						if ($records = $mysql->query($musing_sql)) {
							$i = 0;
							$mdate = array();
							$mcont = array();
							while ($fieldinfo = $records->fetch_row()) {
								$mdate[$i] = $fieldinfo[0];
								$mcont[$i++] = $fieldinfo[1];
							}
						}
						$mysql->close();

						$musings_per_page = 10;
						$pages_total = ceil(count($mdate) / $musings_per_page);
						if (isset($_REQUEST['page'])) {
							 $current_page = $_REQUEST['page'];
						 } else {
							 $current_page = 1;
						 }
						 if ($current_page > $pages_total) {
							 echo "You are out of pages !<br>\n";
							 echo 'The maximum page number is <span style="color: red;">'.$pages_total.'</span> !<br>';
						 }
						 for ($i=0; $i<$musings_per_page; $i++){
							 $post_num = ($current_page-1) * $musings_per_page + $i;
							 if ($post_num < count($mdate)){
								 include __DIR__."/musing.php";
								 echo "\n\n\n";
							 }
						 }


					?>



                                </section>

                        </div>


			<nav class="pagination">
				<?php
					if ($current_page == 1 && $pages_total == 1) {
						echo '<span class="disabled prev">'."\n";
						echo "←\n";
						echo "</span>\n";
						echo '<span class="disabled next">'."\n";
						echo '→'."\n";
						echo '</span>'."\n";
					} else if ($current_page == $pages_total) {
						echo '<span class="prev">'."\n";
						echo '<button class="prev_next_button" id="prev_arrow">←</button>'."\n";
						echo "</span>\n";
						echo '<span class="disabled next">'."\n";
						echo '→'."\n";
						echo '</span>'."\n";
					} else if ($current_page == 1) {
						echo '<span class="disabled prev">'."\n";
						echo "←\n";
						echo "</span>\n";
						echo '<span class="next">'."\n";
						echo '<button class="prev_next_button" id="next_arrow">→</button>'."\n";
						echo '</span>'."\n";
					} else if ($current_page < $pages_total) {
						echo '<span class="prev">'."\n";
						echo '<button class="prev_next_button" id="prev_arrow">←</button>'."\n";
						echo "</span>\n";
						echo '<span class="next">'."\n";
						echo '<button class="prev_next_button" id="next_arrow">→</button>'."\n";
						echo '</span>'."\n";
					}
				?>
			</nav>

			<form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>" id="page_form">
				<input type="hidden" name="page" id="pagination" value=1>
			</form>

			<script>
				document.getElementById("prev_arrow").onclick = function() {prev_page()};

				function prev_page() {
					var page_num_php = document.getElementById("pagination").value;
					<?php
						if (isset($_REQUEST['page'])) {
							echo "var page_num_php = ".$_REQUEST['page']."\n;";
						}
					?>

					if (localStorage.getItem("page_stored")) {
						var page_num = page_num_php;
					} else {
						var page_num = 1;
					}

					if (page_num >= 2) {
						page_num--;
					}

					localStorage.setItem("page_stored", page_num);
					document.getElementById("pagination").value = page_num;
					document.getElementById("page_form").submit();
				}
			</script>

			<script>
				document.getElementById("next_arrow").onclick = function() {next_page()};

				function next_page() {
					var page_num_php = document.getElementById("pagination").value;
					<?php
						if (isset($_REQUEST['page'])) {
							echo "var page_num_php = ".$_REQUEST['page']."\n;";
						}
					?>

					if (localStorage.getItem("page_stored")) {
						var page_num = page_num_php;
					} else {
						var page_num = 1;
					}

					page_num++;

					localStorage.setItem("page_stored", page_num);
					document.getElementById("pagination").value = page_num;
					document.getElementById("page_form").submit();
				}
			</script>

                </div>
        </div>
</section>
