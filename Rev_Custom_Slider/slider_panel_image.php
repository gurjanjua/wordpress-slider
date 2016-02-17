<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' ); 
$HostName = 'http://'.$_SERVER['HTTP_HOST'];
$level=$_REQUEST['level'];
$counter = $_REQUEST['counter'];
$id=$_REQUEST['id'];
?>
<script src="<?php echo plugins_url('Rev_Custom_Slider/js/swiper.jquery.js');?>"></script>
<link href="<?php echo plugins_url('Rev_Custom_Slider/css/new.css');?>" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- Magnific Popup core JS file -->
<script src="<?php echo plugins_url('Rev_Custom_Slider/js/jquery.magnific-popup.js');?>"></script>
<script src="<?php echo plugins_url('Rev_Custom_Slider/js/jquery.colorbox.js');?>"></script>
<link rel="stylesheet" href="<?php echo plugins_url('Rev_Custom_Slider/css/colorbox.css');?>" />
<style type="text/css">
	/* padding-bottom and top for image */
	button.mfp-close{
		padding:25px;
	}
	.mfp-iframe-holder .mfp-close, .mfp-image-holder .mfp-close{
		right: 0px !important;
		
	}
</style>
<script>
var mySwiper = new Swiper('.swiper-container', {
	slidesPerView : 'auto',
	initialSlide : 0,
});
</script>
<script type= "text/javascript">
	jQuery(function(){
					//Get our elements for faster access and set overlay width
					var div = jQuery('div.sc_menu'),
					ul = jQuery('ul.sc_menu'),
					ulPadding = 15;
					//Get menu width
					var divWidth = div.width();
					//Remove scrollbars	
					div.css({overflow: 'hidden'});
					//Find last image container
					var lastLi = ul.find('li:last-child');
					
					//When user move mouse over menu
					div.mousemove(function(e){
						//As images are loaded ul width increases,
						//so we recalculate it each time
						var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;	
						var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
						div.scrollLeft(left);
					});
				});
	jQuery(document).ready(function(){
		var txt = jQuery('.header-text').text();
		jQuery('h5.fittext').text(txt);
		jQuery('h1.fittext').text(txt);
		jQuery('.image-popup-no-margins').magnificPopup({
			
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		image: {
			verticalFit: true,
			overflow : scroll
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});
	});
</script>
	<script>
			jQuery(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				jQuery(".group1").colorbox({rel:'group1'});
				jQuery(".group2").colorbox({rel:'group2', transition:"fade"});
				jQuery(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
				jQuery(".group4").colorbox({rel:'group4', slideshow:true});
				jQuery(".ajax").colorbox();
				jQuery(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				jQuery(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				jQuery(".iframe").colorbox({iframe:true, width:"55%", height:"80%"});
				jQuery(".inline").colorbox({inline:true, width:"50%"});
				jQuery(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				jQuery('.non-retina').colorbox({rel:'group5', transition:'none'})
				jQuery('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				jQuery("#click").click(function(){ 
					jQuery('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
<?php 
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM wp_slider WHERE id='$id'");
foreach ($results as $value) {
?>
<div class="sc_menu swiper-container" style="overflow:hidden;">
	<ul class="sc_menu swiper-wrapper">
		<?php
		$Product_name = $value->product_name;
		$panels=$value->panels_image;
		$panels=json_decode($panels,true);
		//$counter=count($panels);
		for($i=$level;$i<=$level;$i++) {
			$length=count($panels[$i]);
			for($j=$counter;$j<=$counter;$j++) {
				$lengthAgain = count($panels[$i][$j]);
				for($k=0;$k<$lengthAgain;$k++) {
					$images=$panels[$i][$j][$k];
					?>
					<li class="swiper-slide">
						<a class="iframe" href="<?php echo plugins_url('Rev_Custom_Slider/products/large/'.$images)?>">
							<img src="<?php echo plugins_url('Rev_Custom_Slider/products/small/'.$images)?>" class="panel-image" alt=""/>
							<?php if($lengthAgain == 1){?>
							<style type="text/css">.panel-size-text{visibility: hidden;}</style> <?php }
							else { ?>
							<?php }?>
							<span class="panel-size-text">Panel <?php echo $k+1;?></span>
							<div style="height:15px;"></div>
						</a>
					</li>
					<?php }}}?>
				</ul>
			</div>
			<?php }?>