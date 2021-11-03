<section id="content">
	<div class="content-inner-wrapper">
		<div class="collection-title-desc" data-collection-id="52a00f3ce4b09c19d517c837">
			<div class="collection-title-basic">
			<h1 class="page-title"><?php echo $section?></h1>
			</div>
		</div>
		<div class="main-content-wrapper" data-content-field="main-content" data-collection-id="52a00f3ce4b09c19d517c837">
			<div class="sqs-system-gallery sqs-system-gallery-init">
				<div class="gallery-wrapper">
					<div class="slides-controls">
						<div class="slides">
				
							<?php
								include __DIR__."/memories_table.php";
								include __DIR__."/mysql.php";
								$table_name = "memories_gallery";
								$img_sql = "SELECT DATE_FORMAT(fTIME, '%Y%m'), fNUM, fDES FROM ".$table_name." ORDER BY fTIME DESC;";
								if ($records = $mysql->query($img_sql)){
									$i = 0;
									$img_time = array();
									$img_desp = array();
									$img_name = array();
									while ($fieldinfo = $records->fetch_row()) {
										$img_time[$i] = $fieldinfo[0];
										$img_desp[$i] = $fieldinfo[2];
										$num_tmp = $fieldinfo[1];
										if ($num_tmp==0) {
											$img_name_tmp = $img_time[$i]."-".$img_desp[$i].".jpg";
										} else {
											$img_name_tmp = $img_time[$i]."_".$num_tmp."-".$img_desp[$i].".jpg";
										}
										$img_name[$i++] = $img_name_tmp;
									}
								}
								$mysql->close();

								$img_rel_path = $base_href."/".$section."/";
								for ($i=0; $i<count($img_time); $i++){
									echo '<div class="slide" data-slide-id="52a0ac53e4b06b0439cfdc8c" data-slide-url="83bry7sq117qk89xssgqxs6vsz2leu">'."\n";
									echo '<img data-src="'.$img_rel_path.$img_name[$i].'" data-image="'.$img_rel_path.$img_name[$i].'" data-image-dimensions="1280x851" data-image-focal-point="0.5,0.5" data-load="false" style="" alt="201806" class="loaded" data-image-resolution="1500w" src="'.$img_rel_path.$img_name[$i].'">'."\n";
									echo '<div class="slide-meta" data-slide-id="52a0ac53e4b06b0439cfdc8c">'."\n";
									echo '<p class="title">'.$img_desp[$i].'</p>'."\n";
									echo '</div>'."\n";
									echo '</div>'."\n\n\n";
								}

							?>
											
						</div>

						<span class="arrow previous-slide"></span>
						<span class="arrow next-slide"></span>


						<div class="circles gallery-nav">
							<?php 
								for ($i=0; $i<count($img_time); $i++) {
									echo '<span class="circle"></span>'."\n";
								}
							?>
						</div>

					</div>
				</div>

				<div class="dots gallery-nav">
					<?php 
						for ($i=0; $i<count($img_time); $i++) {
							echo '<span class="dot"></span>'."\n";
						}
					?>
				</div>


				<div class="numbers gallery-nav">
					<?php 
						for ($i=0; $i<count($img_time); $i++) {
							echo '<span class="number">'.($i+1).'</span>'."\n";
						}
					?>
				</div>

				<div class="simple gallery-nav">
					<span class="current-index"></span>
					<span class="total-slides"></span>
					<span class="previous"></span>
					<span class="next"></span>
				</div>



				<div class="thumbnail-wrapper gallery-nav">
									
					<?php 
						for ($i=0; $i<count($img_time); $i++) {
							echo '<div class="thumbnail">'."\n";
							echo '<img data-src="'.$img_rel_path.$img_name[$i].'" data-image="'.$img_rel_path.$img_name[$i].'" data-image-dimensions="1280x851" data-image-focal-point="0.5,0.5" alt="201806" data-load="false" />'."\n";
							echo '</div>'."\n\n\n";
						}
					?>
	
				</div>

				<div class="collection-title-desc" data-collection-id="">
					<div class="gallery-collection-title-basic">
					<h1 class="page-title"><?php echo $section?></h1>
					</div>
					<div class="gallery-collection-desc"></div>
				</div>

			</div>


							<!--JS-->

			<script>

			Y.use('squarespace-gallery-ng', function (Y) {document.getElementsByClassName("gallery-wrapper")[0].style.cssText="opacity :0;"
				window.onload=function(){
					
				setTimeout(function(){document.getElementsByClassName("gallery-wrapper")[0].style.cssText="opacity :1;"},200)
				}
				
			  var Gallery = function () {

			    var els = {
				body: Y.one('body'),
				gallery: Y.one('.sqs-system-gallery'),
				slideWrapper:  Y.one('.sqs-system-gallery').one('.gallery-wrapper'),
				slidesAndControls: Y.one('.sqs-system-gallery').one('.slides-controls'),
				circles: Y.one('.sqs-system-gallery').one('.circles')
			      },
			      classes = {
				show: 'show',
				ready: 'sqs-system-gallery-ready',
				interaction: 'sqs-system-gallery-interaction',
				mouseenterleft: 'sqs-system-gallery-hover-slides-left',
				mouseenterright: 'sqs-system-gallery-hover-slides-right',
				init: 'sqs-system-gallery-init',
				circlesNav: 'gallery-navigation-circles',
				crop: 'gallery-auto-crop',
				iframe: 'sqs-system-gallery-video-iframe'
			      },
			      galleryObj = null,
			      thumbnailsObj = null,
			      windowWidth = window.innerWidth;

			    // Current tweak value
			    function getTweakValue(name, number) {
			      var value = Y.Squarespace.Template.getTweakValue(name);

			      if (number) {
				value = parseFloat(value);
			      } else if (typeof value === 'string') {
				value = value.toLowerCase();
			      }

			      if (value === 'true') {
				value = true;
			      } else if (value === 'false') {
				value = false;
			      }

			      return value;
			    }

			    function getAspectRatio(tweakValue) {
			      var aspectRatio = 0,
				  matches = tweakValue && tweakValue.match(/(\d+):(\d+)/);

			      if (matches && matches.length === 3) {
				aspectRatio = matches[1]/matches[2];
			      }

			      return aspectRatio;
			    }

			    // Remove inline styles
			    function cleanSlideMeta() {
			      var slide = els.gallery.one('.slide.sqs-active-slide'),
				activeSlideId = (slide && slide.getAttribute('data-slide-id')) || null,
				slideMeta = els.gallery.one('.slide-meta[data-slide-id="' + activeSlideId + '"]');

			      if (slideMeta) {
				if (els.body.hasClass(classes.crop)) {
				  slideMeta.setStyles({
				    'top': null,
				    'bottom': null,
				    'left': null,
				    'width': null
				  });
				} else {
				  if (els.body.hasClass(classes.circlesNav)) {
				    slideMeta.setStyle('top', (parseFloat(slide._node.clientHeight) - parseFloat(slide.one('img')._node.clientHeight)) / 2);
				    slideMeta.setStyle('bottom', null);
				  } else {
				    slideMeta.setStyle('top', null);
				    slideMeta.setStyle('bottom', (parseFloat(slide._node.clientHeight) - parseFloat(slide.one('img')._node.clientHeight)) / 2);
				  }

				  slideMeta.setStyles({
				    'left': slide.one('img').getComputedStyle('left'),
				    'width': slide.one('img')._node.clientWidth
				  });
				}
			      }
			    }

			    // Check if current slide has title or description
			    function hasSlideMeta(slide, slideMeta, check) {
			      var title,
				description,
				found;

			      if (slideMeta) {
				title = slideMeta.one('.title');
				description = slideMeta.one('.description');

				if ((title && title._node.innerHTML) || (description && description._node.innerHTML)) {
				  if (check) {
				    found = true;
				  } else {
				    slideMeta.addClass(classes.show);
				    cleanSlideMeta();
				  }
				}
			      }

			      return found;
			    }

			    // Slide title and description
			    function slideChange(e) {
			      var activeSlide = els.gallery.one('.slide.sqs-active-slide'),
				activeImage = activeSlide && activeSlide.one('img'),
				activeSlideId = (activeSlide && activeSlide.getAttribute('data-slide-id')) || null,
				bottom;

			      els.gallery.all('.slide-meta').removeClass(classes.show);

			      if (e && Modernizr && !Modernizr.touch) {
				els.gallery.addClass(classes.interaction);
			      }

			      // When hovering over an iframe, mouseover does not fire
			      // -- Always show arrows if this happens
			      if (isVideo()) {
				els.gallery.addClass(classes.iframe);
				els.gallery.removeClass(classes.mouseenterleft);
				els.gallery.removeClass(classes.mouseenterright);
			      } else {
				els.gallery.removeClass(classes.iframe);

				// Show/hide arrows
				if (e && e.type === 'Gallery:currentIndexChange') {
				  if (e.direction === -1) {
				    els.gallery.addClass(classes.mouseenterleft);
				  } else {
				    els.gallery.addClass(classes.mouseenterright);
				  }

				}
			      }

			      if (activeSlideId) {
				hasSlideMeta(activeSlide, els.gallery.one('.slide-meta[data-slide-id="' + activeSlideId + '"]'));

				if (activeImage && els.body.hasClass(classes.circlesNav)) {
				  var setBottom = function() {
				    bottom = Math.max(0, (parseFloat(activeSlide._node.clientHeight) - parseFloat(activeImage._node.clientHeight)) / 2);
				    els.circles.setStyle('bottom', bottom);
				  };
				  if (activeImage.get('complete')) {
				    setBottom();
				  } else {
				    activeImage.on('load', setBottom);
				  }
				}
			      }
			    }

			    // SQS Gallery API
			    function buildGallery() {
			      var galleryLoop = getTweakValue('gallery-loop'),
				galleryAutoCrop = getTweakValue('gallery-auto-crop'),
				galleryAutoplay = getTweakValue('gallery-autoplay'),
				gallerySlideTransition = getTweakValue('gallery-transitions'),
				galleryAutoplaySpeed = getTweakValue('galleryAutoplaySpeed', true) * 1000,
				galleryNavigation = getTweakValue('gallery-navigation'),
				galleryHeight = getTweakValue('gallery-aspect-ratio'),
				slideshowAspectRatio = galleryHeight.split(' ')[0],
				galleryGrid = !isSlideshow(),
				galleryIndex = 0;

			      // Prepare height
			      slideshowAspectRatio = parseInt(galleryHeight.split(':')[1], 10) / parseInt(galleryHeight.split(':')[0], 10);
			      galleryHeight = els.gallery._node.clientWidth * slideshowAspectRatio;

			      // Building
			      els.gallery.removeClass(classes.init);
			      els.gallery.removeClass(classes.ready);
			      els.gallery.removeClass(classes.interaction);
			      els.gallery.removeClass(classes.mouseenterleft);
			      els.gallery.removeClass(classes.mouseenterright);
			      els.gallery.all('.slide-meta').removeClass(classes.show);

			      // Destroy and clean gallery
			      if (galleryObj) {
				galleryIndex = galleryObj.get('currentIndex');

				els.gallery.all('.sqs-disabled').removeClass('sqs-disabled');
				els.gallery.all('.sqs-active-slide').removeClass('sqs-active-slide');

				// Cleanup fade / scroll related CSS
				els.gallery.all('.slide, img').setStyles({
				  visibility: null,
				  left: null,
				  top: null,
				  overflow: null,
				  width: null,
				  height: null
				});

				galleryObj.destroy();
			      }

			      // Destroy thumbnail strip
			      if (thumbnailsObj) {
				els.gallery.all('.thumbnail img[data-src]').each(function (img) {
				  img.setStyles({
				    'height': null,
				    'width': null,
				    'top': null,
				    'left': null
				  });
				});
				thumbnailsObj.destroy();
			      }

			      // Adjust gallery height
			      els.gallery.one('.slides-controls').setStyle('height', galleryGrid ? null : galleryHeight);
			      els.slideWrapper.setStyle('minHeight', galleryGrid ? null : galleryHeight);

			      // New object
			      galleryObj = new Y.Squarespace.Gallery2({
				container: '.slides',
				slides: '.slide',
				currentIndex: galleryIndex,
				elements: {
				  next: '.next-slide, .simple .next',
				  previous: '.previous-slide, .simple .previous',
				  controls: '.dots, .numbers, .circles',
				  currentIndex: '.current-index',
				  totalSlides: '.total-slides'
				},
				loop: galleryLoop,
				autoplay: galleryGrid ? false : galleryAutoplay,
				autoplayOptions: {
				  randomize: false,
				  timeout: galleryAutoplaySpeed,
				  pauseOnMouseover: ['.thumbnail-wrapper']
				},
				lazyLoad: true,
				loaderOptions: {
				  mode: galleryGrid ? (getTweakValue('aspect-ratio') === 'auto' ? 'none' : 'fill') : (galleryAutoCrop ? 'fill' : 'fit')
				},
				design: galleryGrid ? 'autocolumns' : 'stacked',
				designOptions: {
				  transition: gallerySlideTransition,
				  clickBehavior: 'auto',
				  gutter: getTweakValue('gridSpacing', true),
				  columnWidth: getTweakValue('gridSize', true),
				  aspectRatio: getAspectRatio(getTweakValue('aspect-ratio'))
				},
				historyHash: true
			      });

			      // Set arrows
			      // top: 50%; in CSS does not look good -- use px instead
			      els.gallery.all('.arrow').each(function (e) {
				e.setStyle('top', els.slideWrapper._node.clientHeight / 2);
			      });

			      // Init Thumbnails only when required
			      if (!galleryGrid && galleryNavigation === 'thumbnails') {

				thumbnailsObj = new Y.Squarespace.Gallery2({
				  container: '.thumbnail-wrapper',
				  currentIndex: galleryIndex,
				  loaderOptions: {
				    mode: 'fill',
				    load: true
				  },
				  lazyLoad: true,
				  design: 'strip'
				});

				galleryObj.addChild(thumbnailsObj);
			      }

			      // Keep track of slide changes
			      galleryObj.after('currentIndexChange', slideChange);
			      slideChange();

			      // refresh meta positioning after images load
			      galleryObj.after('image-loaded', cleanSlideMeta);
			      cleanSlideMeta();

			      els.gallery.addClass(classes.ready);
			    }

			    // Slow down fn calls
			    function throttle(fn) {

			      if (typeof fn === 'function') {

				if (window.throttleTimeout) {
				  clearTimeout(window.throttleTimeout);
				}

				window.throttleTimeout = setTimeout(fn, 750);
			      }
			    }

			    // Handle mouseenter/leave interaction
			    function interaction(e, leave) {
			      var x = e._event.offsetX || e._event.layerX;

			      // Keep track of interactions
			      els.gallery.addClass(classes.interaction);

			      // Hover over img or Video Overlay
			      if (e._event.target && (e._event.target.localName === 'img' || e._event.target.className === 'sqs-video-opaque' || e.target.hasClass('slide'))) {
				if (!leave) {
				  if (x <= e._currentTarget.clientWidth / 2) {
				    els.gallery.removeClass(classes.mouseenterright);
				    els.gallery.addClass(classes.mouseenterleft);
				  } else {
				    els.gallery.removeClass(classes.mouseenterleft);
				    els.gallery.addClass(classes.mouseenterright);
				  }
				} else {
				  els.gallery.removeClass(classes.mouseenterleft);
				  els.gallery.removeClass(classes.mouseenterright);
				}
			      }
			    }

			    // Listen for keystrokes
			    function keyDown(e) {
			      var key = e.keyCode;

			      if (key === 37 || key === 39 && isSlideshow()) {
				els.gallery.addClass(classes.interaction);
			      }
			    }

			    // Check if current slide is video
			    function isVideo() {
			      var activeSlide = els.gallery.one('.slide.sqs-active-slide');

			      return (activeSlide && activeSlide.getAttribute('data-type') === 'video' && activeSlide.one('iframe'));
			    }

			    function isSlideshow() {
			      return getTweakValue('gallery-design') !== 'grid';
			    }

			    // Register Events
			    function events() {
			      var resizer = new Y.Squarespace.ResizeEmitter({timeout: 100});
			      resizer.on('resize:end', function() {
				if (window.innerWidth !== windowWidth) {
				  windowWidth = window.innerWidth;
				  throttle(buildGallery);
				}
			      });

			      if (Modernizr && !Modernizr.touch) {
				Y.on('mousemove', function (e) {
				  if(isSlideshow()) {
				    interaction(e, false);
				  }
				}, els.gallery.one('.slides-controls'));

				Y.on('mouseleave', function (e) {
				  if(isSlideshow()) {
				    interaction(e, true);
				    els.gallery.removeClass(classes.iframe);
				  }
				}, els.gallery.one('.slides-controls'));

				Y.on('mouseenter', function (e) {
				  if (isSlideshow() && isVideo()) {
				    els.gallery.addClass(classes.iframe);
				  }
				}, els.gallery.one('.slides-controls'));
			      }

			      var lightboxSet = [];
			      els.gallery.all('.slide').each(function(slide) {
				var meta = slide.one('.slide-meta');

				lightboxSet.push({
				  content: slide.one('.sqs-video-wrapper') || slide.one('img'),
				  meta: meta && meta.get('children').size() > 0 ? meta.get('children') : null
				});

				slide.on('click', function(e) {
				  if (!isSlideshow()) {
				    e.halt();

				    new Y.Squarespace.Lightbox2({
				      set: lightboxSet,
				      currentSetIndex: els.gallery.all('.slide').indexOf(slide),
				      controls: { previous: true, next: true }
				    }).render();
				  }
				});
			      });

			      Y.on('keydown', keyDown);
			    }

			    // Tweak Changes
			    function watchTweak(tweakName, callback) {

			      if (Y.Global) {
				Y.Global.on('tweak:change', function (f) {
				  if ((f.getName() === tweakName) && (typeof callback === 'function')) {
				    var value = f.getValue();

				    if (value === 'true') {
				      value = true;
				    } else if (value === 'false') {
				      value = false;
				    }

				    callback(value);
				  }
				});
			      }
			    }

			    // Respond to tweak changes
			    function tweaks() {
			      watchTweak('gallery-loop', buildGallery);
			      watchTweak('gallery-transitions', buildGallery);
			      watchTweak('gallery-auto-crop', buildGallery);

			      watchTweak('gallery-navigation', function (newTweakValue) {
				if (newTweakValue === 'Thumbnails' && !els.gallery.one('.thumbnail-wrapper img[src]')) {
				  buildGallery();
				}

				cleanSlideMeta();
			      });

			      watchTweak('gallery-autoplay', function (newTweakValue) {
				galleryObj.set('autoplay', newTweakValue);
			      });

			      watchTweak('gallery-aspect-ratio', function () {
				buildGallery();
			      });

			      watchTweak('galleryAutoplaySpeed', function () {
				throttle(buildGallery);
			      });

			      watchTweak('galleryInfoBackground', function () {
				slideChange();
			      });

			      watchTweak('gallery-design', buildGallery);
			      watchTweak('aspect-ratio', buildGallery);
			      watchTweak('gridSpacing', buildGallery);
			      watchTweak('gridSize', buildGallery);

			      Y.Global && Y.Global.on(['tweak:reset', 'tweak:close'], function(f){
				Y.later(500, this, buildGallery);
			      },this);

			    }

			    // Constructor
			    function init() {
			      buildGallery();
			      events();
			      if (Y.Lang.isValue(Static.SQUARESPACE_CONTEXT.authenticatedAccount)) {
				tweaks();
			      }
			    }

			    init();
			  }

			  // Ready?
			  Y.on('domready', function () {
			    new Gallery();
			  });
			});

			</script>
            
		</div>
	</div>
</section>
