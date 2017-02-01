<div id="sub_content">
    <h1>
        <?php echo Yii::t('basicfield', 'Appointment booking made simple');?>
    </h1>
    
    <p>
        <?php echo Yii::t('basicfield', 'Enter where and what you are looking for');?>
        
    </p>
    
    <form  method="get" action="<?php echo Yii::$app->urlManager->createUrl('/site/index')?>" >
        <div id="custom-search-input">
            <div class="input-group ">
                <input type="text" class=" search-query" placeholder="<?php echo Yii::t('basicfield', 'Your Address / Postal code / City / Name of merchant / Categories')?>" id="search" name="Merchant[search]" required>
                <span class="input-group-btn">
                    <input type="submit" class="btn_search" value="submit">
                </span>
            </div>
        </div>
    </form>
</div><!-- End sub_content -->



<?php
$this->registerJs("
    $(document).ready(function(){
    
    if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            
            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                
                    if (results[0]) {
                        console.log(results[0]);
                        $('#search').val(results[0].formatted_address);
                        //alert('sLocation: ' + results[0].formatted_address);
                    }
                }
            });

            
          }, function() {
            //handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          alert('Browser doesnot support geolocation.')
        }

});
        ");
?>

<script>
    
    </script>

