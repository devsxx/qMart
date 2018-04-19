<script>
var offset = 32;
var limit = 32;
var adsoffset = 8;
</script>
<style>
.no-more {
	font-weight: bold;
	padding: 5%;
	text-align: center;
	margin-top: 20px;
}
#content {
    min-height: 0 !important;
}
</style>
<?php if(empty($subcats)) { ?>
<!--  <div class="jumbotron banner-bg fixed">
	<div class="container">
		<br>
		<h1 align="center">Welcome To Happy Sale!</h1>
		<p>This is a template for a simple marketing or informational website.
			It includes a large callout called a jumbotron and three supporting
			pieces of content. Use it as a starting point to create something
			more unique.</p>
		<p>
			<a role="button" href="#" class="btn btn-primary btn-lg">Learn more »</a>
		</p>
	</div>
</div> -->
<?php }?>
	<!-- location Modal -->	
	
	<div class="container">	
	<?php 
//if(!empty($subcats)) { 
	if(!empty($category)) {?>
<div class="col-md-12 category_button">
<?php	//foreach($subcats as $subcat):
$subactive = "";$subIcon = "";
$subcategoryUrl = Yii::app()->createAbsoluteUrl('/category/'.$category.'/'.$subcat->slug);
if($subcategory == $subcat->slug){
$subactive = "active";
//$subcategoryUrl = Yii::app()->createAbsoluteUrl('/category/'.$category);
$categoryUrl = Yii::app()->createAbsoluteUrl('/category/'.$category);
$subIcon = "<i class='fa fa-times-circle'></i> ";
}
if(!empty($subcategory)){
	$subcategoryUrl = Yii::app()->createAbsoluteUrl('/category/'.$category.'/'.$subcat->slug);
}
if(!empty($category)){
	$categoryUrl = Yii::app()->createAbsoluteUrl('/category/'.$category);
}

$searchUrl = "";
if(!empty($search)){
	$searchUrl = "?search=".$search;
}?>
<?php /*?>
	<div class="btn-group">
	<?php echo CHtml::link($subIcon.$subcat->name, $subcategoryUrl, array('class' => 'btn btn-lg btn-category '.$subactive));  ?>
	</div>
<?php */ ?>
	<div class="row">		
			<div class="qMart-breadcrumb add-product col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				 <ol class="breadcrumb">
					<li><a href="<?php echo Yii::app()->createAbsoluteUrl('/')?>"><?php echo Yii::t('app','Home');?></a></li>
					<li><a href="<?php echo $categoryUrl.$searchUrl; ?>"><?php echo $categoryname; ?></a></li>			
					<?php if (!empty($subcategory)) ?>	
						<li><a href="<?php echo $subcategoryUrl.$searchUrl; ?>"><?php echo $subcatname; ?></a></li> 
				 </ol>			
			</div>			
		</div>	
		
			<div class="row">
				<div class="full-horizontal-line col-xs-12 col-sm-12 col-md-12 col-lg-12 "></div>	
			</div>
	<?php //endforeach; ?>
</div>
	<?php  }if(!empty($search)) { ?>
	<div class="row">		
		<div class="search-result col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			<div><?php echo Yii::t('app','Search Result');?> <span class="search-result-text">"<?php echo $search; ?>"</span></div>					 			
		</div>			
	</div>	
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			<div class="full-horizontal-line col-xs-12 col-sm-12 col-md-12 col-lg-12 "></div>	
		</div>	
	</div>
	<?php } //echo CHtml::link('Clear',Yii::app()->createAbsoluteUrl('/'),array('class' => 'btn btn-lg btn-primary')); } ?>
	
	<?php /*?>	
			<a class="dropdown-near-you col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" href="#" data-toggle="modal" data-target="#nearmemodals">
			<img src="<?php echo Yii::app()->createAbsoluteUrl('images/design/location.png'); ?>" alt="Location">
			<span class="miles">3 mi from you</span>
			<div class="dropdown-btn"><img src="<?php echo Yii::app()->createAbsoluteUrl('images/design/down-arrow.png'); ?>" alt="arrow"></div></a>	
	<?php */ ?>
	<div class="find-near-you fixed-affix col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">   
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-12">
                <a class="dropdown-near-you col-xs-12 col-sm-offset-4 col-sm-4 col-md-offset-4 col-md-4 col-lg-offset-4 col-lg-4 no-hor-padding" href="#" data-toggle="modal" data-target="#nearmemodals">
                <img src="<?php echo Yii::app()->createAbsoluteUrl('images/design/location.png'); ?>" alt="Location">
                <?php if ($place != ""){ ?>
                <span class="miles"><?php echo $displayInfo." from ".$place; ?></span>
                <?php }else{ ?>
                <span class="miles"><?php echo Yii::t('admin', 'World Wide...'); ?></span>
                <?php } ?>
                <div class="dropdown-btn"><img src="<?php echo Yii::app()->createAbsoluteUrl('images/design/down-arrow.png'); ?>" alt="arrow"></div></a>
              </div>
         	</div>
                
			<!-- Modal content-->
	    <div id="nearmemodals" class="modal fade col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding" role="dialog" aria-hidden="true">
	       <div class="modal-dialog nearmemodal-content">		
			<div class="modal-content">
				<div class="modal-header">											
					<div class="location-section col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">	
						<button data-dismiss="modal" class="close map-close" type="button">×</button>					
						<div class="map-input-section col-xs-12 col-sm-12 col-md-12 col-lg-8 no-hor-padding">
							<div class="map-input-box">
								<input id="pac-input" type="text" placeholder="<?php echo Yii::t('admin', 'Where do you want to search?'); ?>" class="controls" autocomplete="off"></input>
							</div>								
							<?php
							$sitesetting = Myclass::getSitesettings();
							$searchList = $sitesetting->searchList;
							$searcharr = explode(",",$searchList);
							$searchType = $sitesetting->searchType;
							if($searchType != 'miles'){
								$searchTypedisplay = 'km';
							}else{
								$searchTypedisplay = 'mi';
							}
							?>
							<div class="map-select-box">							 
								<select id="select-mapdistance" class="select-box-arrow" >						
								<?php
								for($i=0;$i<count($searcharr);$i++)
								{
								echo '<option value="'.$searcharr[$i].'">'.$searcharr[$i].' '.$searchTypedisplay.'</option>';
								}
?>					 
								</select>
							</div>
						</div>							
							<div class="location-button col-xs-12 col-sm-12 col-md-12 col-lg-4 no-hor-padding">							
								<a href="javascript:void(0);" class="location-submit-button" onclick="return gotogetLocationData();"><?php echo Yii::t('admin', 'Submit'); ?></a>
								<a href="javascript:void(0);" class="location-find-button" onclick="removeLocation();"><?php echo Yii::t('admin', 'Remove'); ?></a>								
							</div>						
					</div>
					<a href="javascript:void(0);" class="map-mylocation-button" data-toggle="tooltip" title="Find my location!" 
						onclick="getLatLong();">
						<img alt="find my location" src="<?php echo Yii::app()->createAbsoluteUrl('images/gps.png'); ?>">
					</a>		
					<div id="googleMap" class="google-Map col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">
					</div>	</div>
											
				</div>
													
						  
			</div>
	    </div>
	  </div>
	  
	  
	</div>
	
 

<input id="map-latitude" class="map-latitude" type="hidden" value="<?php echo $lat; ?>">
<input id="map-longitude" class="map-longitude" type="hidden" value="<?php echo $lon; ?>">

<script>
var map;
<?php if ($place == ""){ ?>
var myCenter=new google.maps.LatLng(51.508742,-0.120850);
var mapzoom = 2;
<?php }else{ ?>
console.log("Default Location: <?php echo $lat.",".$lon; ?>");
var myCenter=new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lon; ?>);
var mapzoom = 10;
<?php } ?>
var geocoder = new google.maps.Geocoder();
var marker;
geocoder.geocode({'latLng': myCenter}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
    //console.log(results)
      if (results[1]) {
          // document.getElementById("pac-input").value = results[0].formatted_address;

      } else {
        alert("No results found");
      }
    } else {
      alert("Geocoder failed due to: " + status);
    }
  });

function mapinitialize()
{
var mapProp = {
		  center:myCenter,
		  zoom:mapzoom,
		  mapTypeId:google.maps.MapTypeId.ROADMAP,
		  disableDefaultUI: true
		  
  	};
map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var input = document.getElementById('pac-input');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.bindTo('bounds', map);
autocomplete.addListener('place_changed', function() {
    //infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    var address = place.formatted_address;
    var latitude = place.geometry.location.lat();
    var longitude = place.geometry.location.lng();
    document.getElementById("map-latitude").value = latitude;
    document.getElementById("map-longitude").value = longitude;
    /*if (!place.geometry) {
      window.alert("Autocomplete's returned place contains no geometry");
      return;
    }*/
    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
      //map.setZoom(15);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(10);  // Why 17? Because it looks good.
    }
    /* marker.setIcon(/** @type {google.maps.Icon} *-/({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    })); */
    //$.("#googleMap").val(place.formatted_address);
    document.getElementById('googleMap').value = place.formatted_address
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

    //infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    //infowindow.open(map, marker);
  });

map.addListener('zoom_changed', function() {
    console.log('Zoom: ' + map.getZoom());
  });

map.addListener("drag", function()
{
	google.maps.event.trigger(map, "resize");
})

var infowindow = new google.maps.InfoWindow();
marker = new google.maps.Marker({
  map: map,
  draggable:true,
  position: myCenter,
  icon:'<?php echo Yii::app()->createAbsoluteUrl("/images/map_pointer.png");?>',
  anchorPoint: new google.maps.Point(0, -29)
});

marker.addListener('mouseover', function() {
    //infowindow.open(map, this);
    marker.setAnimation(google.maps.Animation.BOUNCE);
});

//assuming you also want to hide the infowindow when user mouses-out
marker.addListener('mouseout', function() {
    //infowindow.close();
    marker.setAnimation(null);  
});

google.maps.event.addListener(map, 'click', function (e) {
    var lat = e.latLng.lat();
    var lng = e.latLng.lng();
    var latlng = new google.maps.LatLng(lat, lng);
    //placeMarker(event.latLng);
    marker.setPosition(latlng)
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
        //console.log(results)
          if (results[1]) {
           //alert(results[0].formatted_address)
         
               document.getElementById("pac-input").value = results[0].formatted_address;
               document.getElementById("map-latitude").value = lat;
               document.getElementById("map-longitude").value = lng;
               map.setCenter(latlng); // Set map center to marker position
               //map.setZoom(15);

          } else {
            alert("No results found");
          }
        } else {
          alert("Geocoder failed due to: " + status);
        }
      });
});

google.maps.event.addListener(marker, 'dragend', function (event) {
    var lat = this.getPosition().lat();
    var lng = this.getPosition().lng();
    var latlng = new google.maps.LatLng(lat, lng);
    marker.setPosition(latlng)
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
        //console.log(results)
          if (results[1]) {
               document.getElementById("pac-input").value = results[0].formatted_address;
               document.getElementById("map-latitude").value = lat;
               document.getElementById("map-longitude").value = lng;
               map.setCenter(latlng); // Set map center to marker position
               //map.setZoom(15);

          } else {
            alert("No results found");
          }
        } else {
          alert("Geocoder failed due to: " + status);
        }
      });
    //alert(results[0].formatted_address)
    
});

google.maps.event.addListenerOnce(map, 'idle', function(){
	<?php if ($place == ""){ ?>
	getLatLong(1);
	<?php } ?>
});

//To add the marker to the map, call setMap();
marker.setMap(map);

  /* google.maps.event.addListener(map, 'click', function(event) {
    placeMarker(event.latLng);
  }); */
}

/*function placeMarker(location) {
  var marker = new google.maps.Marker({
    position: location,
    map: map,
    icon:'<?php //echo Yii::app()->createAbsoluteUrl("/images/map_pointer.png");?>',
   /*animation:google.maps.Animation.BOUNCE
  });
  var infowindow = new google.maps.InfoWindow({
    content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
  });
  infowindow.open(map,marker);
} */

google.maps.event.addDomListener(window, 'load', mapinitialize);

var mapStickyTrack;
<?php if(!empty(Yii::app()->user->id)) {?>
var userdetails = 1;
<?php }else{ ?>
var userdetails = 0;
<?php } ?>
$(document).ready(function(){
	$(window).on('load resize', function () {
		if($(window).width() >= 1024){
			if(userdetails == 0)
				mapStickyTrack = $('.qMart-menu').height() + $('.qMart-app-download').height();
			else
				mapStickyTrack = $('.qMart-menu').height();
		}else{
			if(userdetails == 0)
				mapStickyTrack = $('.qMart-app-download').height();
			else
				mapStickyTrack = $('.qMart-header').height();
		}
		mapStickyTrack -= 56;
		console.log('mapStickyTrack: '+mapStickyTrack);
	   // $('.sticky-screen').height($(window).height()).width($(window).width());
	});

	$(window).on('scroll', function () {
	    if ($(window).scrollTop() >= mapStickyTrack) {
	        $('.find-near-you').addClass('map-menu-fixed');
	    } else {
	        $('.find-near-you').removeClass('map-menu-fixed');
	    }
	});
});
</script>

		<div id="products" class="slider container section_container">
		<?php $this->renderPartial('loadresults',compact('adsProducts','catrest','products','locationReset','pages','search','category','subcategory','subcats','lat','lon','place','loadMore')); ?>
		</div>
		<div class="row no-more" style="display: none;">		
			<div class="no-item col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
				<div>
					<span class="no-item-text col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo Yii::t('app','Sorry! No item this location'); ?>.
					</span>
					<span class="world-wide col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo Yii::t('app','We are showing world wide'); ?>
					</span>
					<div class="back-botton col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<a href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>" class="back-btn">
							<?php echo Yii::t('app','Back'); ?>
						</a>
					</div>
				</div>				 			
			</div>			
		</div>
		
		
		<?php /* <div class="no-more" style="display: none; min-height: 320px;margin-top:3%">
			<div class="paypal-success" style="margin: 0 auto;">
				<div class="paypal-success-icon fa fa-exclamation-triangle"
					style="color: #2FDAB8; font-size: 40px;"></div>
				<br>
				<div class="not-found-message"></div>
				<a class="btn btn-primary sell-button"
					href="<?php echo Yii::app()->createAbsoluteUrl('/'); ?>"> <i
					class="fa fa-home" style="font-size: 20px;"> </i> <?php echo Yii::t('app','Back To Home Page'); ?>
				</a>
			</div>
		</div>
		<?php /* $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
		'contentSelector' => '#products',
		'itemSelector' => 'div.col-md-4.product',
		'loadingText' => 'Loading...',
		'donetext' => 'No More Products',
		'pages' => $pages,
		)); */
		?>
		<?php if(empty($products)) { ?>
		<script>
            /* $(".load").hide();
            $(".no-more").show();
            $("#products").hide();
            $(".not-found-message").html('<b>'+Yii.t('app','No Items Found.')+'</b>'); */
		</script>
		<?php } ?>
