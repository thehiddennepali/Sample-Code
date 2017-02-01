<?php
$this->registerCssFile(Yii::$app->urlManager->baseUrl.'/css/date/style.css');
$this->registerCssFile(Yii::$app->urlManager->baseUrl.'/css/date/clndr.css');
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/date/underscore-min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/date/moment-2.2.1.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/date/clndr.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/date/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<?php $this->registerJs("function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML =
    h + ':' + m + ':' + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = '0' + i};  // add zero in front of numbers < 10
    return i;
}")?>

<body>

<h1>Datum und freien Termin wählen</h1>

<div class="content">

<div class="calender">

    	<div class="cal1">
    		<div class="clndr">

    			<table class="clndr-table" border="0" cellspacing="0" cellpadding="0">

    				<thead>
						<tr class="header-days">
							<td class="header-day">S</td>
							<td class="header-day">M</td>
							<td class="header-day">T</td>
							<td class="header-day">W</td>
							<td class="header-day">T</td>
							<td class="header-day">F</td>
							<td class="header-day">S</td>
    					</tr>
    				</thead>

    				<tbody>

				    	<tr>
					    	<td class="day past calendar-day-2015-11-01">
					    		<div class="day-contents">01</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-02">
					    		<div class="day-contents">02</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-03">
					    		<div class="day-contents">03</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-04">
					    		<div class="day-contents">04</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-05">
					    		<div class="day-contents">05</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-06">
					    		<div class="day-contents">06</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-07">
					    		<div class="day-contents">07</div>
					    	</td>
				    	</tr>

				    	<tr>
					    	<td class="day past calendar-day-2015-11-08">
					    		<div class="day-contents">08</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-09">
					    		<div class="day-contents">09</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-10">
					    		<div class="day-contents">10</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-11">
					    		<div class="day-contents">11</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-12">
					    		<div class="day-contents">12</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-13">
					    		<div class="day-contents">13</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-14">
					    		<div class="day-contents">14</div>
					    	</td>
				    	</tr>

				    	<tr>
					    	<td class="day past calendar-day-2015-11-05">
					    		<div class="day-contents">15</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-16">
					    		<div class="day-contents">16</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-17">
					    		<div class="day-contents">17</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-18">
					    		<div class="day-contents">18</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-19">
					    		<div class="day-contents">19</div>
					    	</td>
					    	<td class="day past calendar-day-2015-11-20">
					    		<div class="day-contents">20</div>
					    	</td>
					    	<td class="day today calendar-day-2015-11-21">
					    		<div class="day-contents">21</div>
					    	</td>
				    	</tr>

				    	<tr>
					    	<td class="day calendar-day-2015-11-22">
					    		<div class="day-contents">22</div>
					    	</td>
					    	<td class="day calendar-day-2015-11-23">
					    		<div class="day-contents">23</div>
					    	</td>
					    	<td class="day calendar-day-2015-11-24">
					    		<div class="day-contents">24</div>
					    	</td>
					    	<td class="day calendar-day-2015-11-25">
					    		<div class="day-contents">25</div>
					    	</td>
					    	<td class="day calendar-day-2015-11-26">
					    		<div class="day-contents">26</div>
					    	</td>
					    	<td class="day calendar-day-2015-11-27">
					    		<div class="day-contents">27</div>
					    	</td>
					    	<td class="day calendar-day-2015-11-28">
					    		<div class="day-contents">28</div>
					    	</td>
				    	</tr>

				    	<tr>
					    	<td class="day calendar-day-2015-11-29">
					    		<div class="day-contents">29</div>
					    	</td>
					    	<td class="day calendar-day-2015-11-30">
					    		<div class="day-contents">30</div>
					    	</td>
					    	<td class="day adjacent-month next-month calendar-day-2015-12-01">
					    		<div class="day-contents">01</div>
					    	</td>
					    	<td class="day adjacent-month next-month calendar-day-2015-12-02">
					    		<div class="day-contents">02</div>
					    	</td>
					    	<td class="day adjacent-month next-month calendar-day-2015-12-03">
					    		<div class="day-contents">03</div>
					    	</td>
					    	<td class="day adjacent-month next-month calendar-day-2015-12-04">
					    		<div class="day-contents">04</div>
					    	</td>
					    	<td class="day adjacent-month next-month calendar-day-2015-12-05">
					    		<div class="day-contents">05</div>
					    	</td>
				    	</tr>

    				</tbody>

    			</table>

    		</div>
    	</div>
</div>

<div class="date">
	<div id="dd1" class="wrapper-dropdown-3" tabindex="1">
	<span><img src="images/nav.png" alt="Navbar"/></span>
			<ul class="dropdown">
				<li><a href="#">All</a></li>
				<li><a href="#">Iris</a></li>
				<li><a href="#">Marina</a></li>
				<li><a href="#">Susi</a></li>
				<li><a href="#">Martina</a></li>
				<li><a href="#">erster freier Termin</a></li>
			</ul>
        
        <?php $this->registerJs("function DropDown(el) {
				this.dd = el;
				this.initEvents();
				}
				DropDown.prototype = {
				initEvents : function() {
				var obj = this;					
				obj.dd.on('click', function(event){
				$(this).toggleClass('active');
				event.stopPropagation();
				});	
				}
				}
				$(function() {
				var dd = new DropDown( $('#dd1') );
				$(document).click(function() {
				// all dropdowns
				$('.wrapper-dropdown-3').removeClass('active');
				});
				});")?>
			
			</div>

			<div id="txt"></div>

			<div class="dmy">
                            
                            <?php 
                            $this->registerJs('
                                var mydate=new Date()
               var year=mydate.getYear()
               if(year<1000)
                 year+=1900
                 var day=mydate.getDay()
                 var month=mydate.getMonth()
                 var daym=mydate.getDate()
               if(daym<10)
                 daym="0"+daym
                 var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
                 var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
                 document.write(""+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+"")
            ')?>
			
            </div>

            <h2>Freie Termine:</h2>
			<ul class="reminder">
				<li><label><input type="radio" value="" name="option_2" class="icheck">09:00</label></li>
				<li><label><input type="radio" value="" name="option_2" class="icheck">11:00</label></li>
				<li><label><input type="radio" value="" name="option_2" class="icheck">13:30</label></li>
				<li><label><input type="radio" value="" name="option_2" class="icheck">15:00</label></li>
				<li><label><input type="radio" value="" name="option_2" class="icheck">17:30</label></li>
				<li><label><input type="radio" value="" name="option_2" class="icheck">18:30</label></li>
			</ul>
			</div>

</div>

<div class="clear"></div>

</div>
</div>


</body>
</html>