<article class="hentry category-life-philosophy category-models author-Ian-Liu post-type-text article-index-1" >
	<a class="anchor" id=<?php echo "post".$article_number ?>></a>

	<h1 class="title-learning">
		<?php echo $article_title."\n"?>
	</h1>

	<h2 class="date-author-learning">
		<time><?php //echo date("F d, Y", $article_date) ?></time>
		<time><?php echo $article_date ?></time>
	</h2>

        <!--MAIN CONTENT-->
        <div class="sqs-layout sqs-grid-12 columns-12" data-layout-label="Post Body" data-type="item">
                <div class="row sqs-row">
                        <div class="col sqs-col-12 span-12">
                                <div class="sqs-block html-block sqs-block-html" data-block-type="2">
                                        <div class="sqs-block-content">

					<?php 
						$file_path = $data_abs_path."/".$article_file;
						$file_cont = file_get_contents($file_path);
						preg_match("/<body[^>]*>(.*?)<\/body>/is", $file_cont, $matches);
						echo($matches[1]);
					?>

                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</article>

