<article id="post-54e2d341e4b062ed7b0cb369" class="hentry category-life-philosophy category-models author-Ian-Liu post-type-text article-index-1">

<?php 
	$article_abs_path = $_SERVER['DOCUMENT_ROOT']."/Essays_file/data/";
	$article_rel_path = $base_href."/Essays_file/";
	$article_cont = file_get_contents($article_abs_path.$essay_file[$post_num]);
	preg_match("/<body[^>]*>(.*?)<\/body>/is", $article_cont, $body_matches);
        preg_match("/<title[^>]*>(.*?)<\/title>/is", $article_cont, $title_matches);
	$article_title = preg_replace('/\s+/', ' ', $title_matches[1]);
	$article_title = trim($article_title);
?>
        <h1 class="title">
	<a href="<?php echo $article_rel_path.basename($essay_file[$post_num],'.html')?>"><?php echo $article_title?></a>
        </h1>

        <h2 class="date-author">
	<time datetime="2021-06-23"><?php echo $essay_date[$post_num] ?></time>
        </h2>

        <div class="sqs-layout sqs-grid-12 columns-12" data-layout-label="Post Body" data-type="item" data-updated-on="1424151533829">
                <div class="row sqs-row">
                        <div class="col sqs-col-12 span-12">
                                <div class="sqs-block html-block sqs-block-html" data-block-type="2">
                                        <div class="sqs-block-content">

					<?php echo $body_matches[1]?>

                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</article>

