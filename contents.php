<section id="content" class="show"> <!--CONTENT INJECTION POINT-->
	<div class="content-inner-wrapper" style="margin-top: 221px;">
		<div class="collection-title-desc" 
			 data-collection-id="52a01aa4e4b0d7c82c6184da" 
			 data-edit-main-image="Banner">
			<div class="collection-title-basic">
			<h1 class="page-title"><?php echo $base_href ?></h1>
			</div>
		</div>
		<div class="main-content-wrapper" 
			 data-content-field="main-content" 
			 data-collection-id="52a01aa4e4b0d7c82c6184da" 
			 data-edit-main-image="Banner" 
			 id="yui_3_17_2_1_1623312749920_71">
							 
			<div class="sqs-layout sqs-grid-12 columns-12" 
				 data-type="page" 
				 data-updated-on="1606913562896" 
				 id="page-52a01aa4e4b0d7c82c6184da">
								 
				<div class="row sqs-row" 
					id="yui_3_17_2_1_1623312749920_70">
					<div class="col sqs-col-2 span-2" 
						id="yui_3_17_2_1_1623312749920_69">
						<div class="sqs-block image-block sqs-block-image sqs-text-ready" 
							data-aspect-ratio="100.46082949308757" 
							data-block-type="5" 
							id="block-yui_3_10_1_1_1397842617391_6560">
							<div class="sqs-block-content" 
								id="yui_3_17_2_1_1623312749920_68">   
								<div class="image-block-outer-wrapper
									layout-caption-hidden
									design-layout-inline
									combination-animation-none
									individual-animation-none
									individual-text-animation-none
									sqs-narrow-width" 
									data-test="image-block-inline-outer-wrapper" 
									id="yui_3_17_2_1_1623312749920_67">
													
									<!-- avatar -->
									<figure class="sqs-block-image-figure intrinsic" 
										style="max-width:2111px;" 
										id="yui_3_17_2_1_1623312749920_66">
										<div style="padding-bottom: 100.461%; overflow: hidden;" 
											 class=" image-block-wrapper has-aspect-ratio" 
											 data-animation-role="image" 
											 id="yui_3_17_2_1_1623312749920_65">
											<img class="thumb-image loaded" 
											src=<?php
												$avatar_src = $base_href."/Chang_files/ian.png";
												echo $avatar_src;
											 ?>
												 style="left: 0%; top: 0%; 
													width: 95%; height: 100%; 
													position: absolute;">
										</div>
									</figure>
		  
								</div>
							</div>
						</div>
					</div>

									
					<!-- content -->
					<div class="col sqs-col-10 span-10">
						<div class="sqs-block html-block sqs-block-html" 
							data-block-type="2" 
							id="block-8765bfad595255fcb0cc">
							<div class="sqs-block-content">

								<?php 
									$introduction = __DIR__.'/self_introduction.html';
									echo fread(fopen($introduction, "r"), filesize($introduction)); 
									fclose($introduction);
								?>								

							</div>
						</div>
					</div>

				</div>
				<div class="row sqs-row">
					<div class="col sqs-col-12 span-12"></div>
				</div>
			</div>
		</div>
	</div>
</section>
