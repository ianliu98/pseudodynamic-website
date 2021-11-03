<section id="content" class="show">
	<div class="content-inner-wrapper" style="margin-top: 221px;">
		<div class="main-content-wrapper" data-content-field="main-content" data-edit-main-image="Banner">
			<div class="sqs-layout sqs-grid-12 columns-12" data-type="page">
				<div class="row sqs-row">
					<div class="col sqs-col-12 span-12">
						<div class="sqs-block html-block sqs-block-html" data-block-type="2">


							<?php
								$excerpt_title = array();
								$excerpt_title[0] = $lear_cate[0]." (".$cate_num[0].') <i><b style="color:red;font-size:30px;">New!</b></i>';
								for ($i=1; $i<count($lear_cate); $i++){
									$excerpt_title[$i] = $lear_cate[$i]." (".$cate_num[$i].")";	
								}
								sort($lear_cate);
								sort($excerpt_title);

								include __DIR__."/mysql.php";
								for ($i=0; $i<count($lear_cate); $i++) {
									echo '<h1 class="title">'."\n";
									echo '<a href="'.$base_href.'/Learnings_file/'.$lear_cate[$i].'">'.$excerpt_title[$i].'</a>'."\n";
									echo '</h1>'."\n";
									echo '<div class="learning-excerpt">'."\n";
									$excerpt_final = mb_substr($excerpt_con[$i],0,200,"utf-8");
									echo '<p>'.$excerpt_final.'... </p><p class="" style="white-space:pre-wrap;">&nbsp;</p>'."\n";
									echo '</div>'."\n";

									echo "\n\n\n";
								}
							?>

							<div class="sqs-block spacer-block sqs-block-spacer" data-aspect-ratio="3.512396694214876" data-block-type="21">
								<div class="sqs-block-content sqs-intrinsic" style="padding-bottom: 3.5124%;"></div>
							</div>

							<div class="sqs-block image-block sqs-block-image sqs-text-ready" data-block-type="5">
								<div class="sqs-block-content">

									<div class="image-block-outer-wrapper layout-caption-below design-layout-inline combination-animation-none individual-animation-none individual-text-animation-none" data-test="image-block-inline-outer-wrapper">
										<figure class="sqs-block-image-figure intrinsic" style="max-width:931px;">
											<div style="padding-bottom: 39.2052%; overflow: hidden;" class="image-block-wrapper has-aspect-ratio" data-animation-role="image">
												<img     class="thumb-image loaded" 
													 data-image-dimensions="2678x1785" 
													 data-image-focal-point="0.5,0.5" 
													 data-load="false" 
													 data-image-id="5dd15fe87f96080e4ad3370b" 
													 data-type="image" 
													 alt="Website Logos.png" 
													 data-image-resolution="1000w" 
													 src="<?php echo $base_href."/img/learning4.jpg"?>" 
													 style="left: 30px; top: 0%; right: 50px; width: 100%; height: 100%; 
															position: absolute;">
											</div>
										</figure>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

