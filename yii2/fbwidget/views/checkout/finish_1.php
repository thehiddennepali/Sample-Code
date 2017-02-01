<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="img/sub_header_cart.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
        
        <?php echo $this->render('sub_header');?>
    	
	</div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#0">Home</a></li>
                <li><a href="#0">Category</a></li>
                <li>Page active</li>
            </ul>
        </div>
    </div><!-- Position -->

<!-- Content ================================================== -->
<div class="container margin_60_35">
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="box_style_2">
				<h2 class="inner">Appointment confirmed!</h2>
				<div id="confirm">
					<i class="icon_check_alt2"></i>
					<h3>Thank you!</h3>
					<p>
						Lorem ipsum dolor sit amet, nostrud nominati vis ex, essent conceptam eam ad. Cu etiam comprehensam nec. Cibo delicata mei an, eum porro legere no.
					</p>
				</div>

				<h3>Your booking <i class="icon_calendar pull-right"></i></h3>
					<hr>
					<div class="row" id="options_2">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<i class="icon_calendar"></i> Datum/Uhrzeit</label>
							16.02.2016 10 Uhr
						</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
							<i class="icon-user-2"></i> Mitarbeiter/in</label>
							bei Daniela
						</div>
					</div><!-- Edn options 2 -->
					<hr>					
					<h4>Behandlungen / Leistungen</h4>
					<hr>
					<table class="table table_summary">
					<tbody>
                                            
                                            <?php //echo $this->render('/merchant/orders', ['orders' => $orders]);?>
					<tr>
						<td>
							<strong>1x</strong> Gesichtsbehandlung Premium
						</td>
						<td>
							<strong class="pull-right">€ 139,--</strong>
						</td>
					</tr>
					<tr>
						<td>
							<strong>1x</strong> Decolteé-Behandlung
						</td>
						<td>
							<strong class="pull-right">€ 25,--</strong>
						</td>
					</tr>
				<tr>
					<td>
						 <hr>
					</td>
				</tr>
					<tr>
						<td>
							 Subtotal 
						</td>
						<td>
							<strong class="pull-right">€ 164,--</strong>
						</td>
					</tr>
					<tr>
						<td>
							 Coupon 10% 
						</td>
						<td>
							<strong class="pull-right">€ 16,40</strong>
						</td>
					</tr>
				<tr>
					<td class="total_confirm">
						 TOTAL
					</td>
					<td class="total_confirm">
						<span class="pull-right">€ 147,60</span>
					</td>
				</tr>
				<tr>
					<td>
						 Loyalty Points <a href="#" class="tooltip-1" data-placement="top" title="" data-original-title="For this appointment you receive 25 Loyalty Points "><i class="icon_question_alt"></i></a>
					</td>
				</tr>
					</tbody>
					</table>
			</div>
		</div>
	</div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->