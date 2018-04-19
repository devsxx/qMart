<?php
$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->baseUrl;
$cs->registerScriptFile($baseUrl.'/js/plugins/morris/raphael.min.js');
$cs->registerScriptFile($baseUrl.'/js/plugins/morris/morris.js');
//$cs->registerScriptFile($baseUrl.'/js/plugins/morris/morris-data.js');
?>
<div id="page-wrapper">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title"><?php echo Yii::t('admin','Dashboard'); ?></h4>
            <p class="text-muted page-title-alt"><?php echo Yii::t('admin','Welcome to admin panel !'); ?></p>
        </div>
    </div>

	<!-- /.row -->
	<div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-bg-color-icon card-box fadeInDown animated">
                <div class="bg-icon bg-icon-info pull-left">
                    <i class="md  md-account-circle text-info"></i>
                </div>
                <div class="text-right">
                    <h3 class="text-dark"><b class="counter"><?php echo Myclass::getTotalUsers(); ?></b></h3>
                    <p class="text-muted"><?php echo Yii::t('admin','Total').' '.Yii::t('admin','Users'); ?></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-bg-color-icon card-box">
                <div class="bg-icon bg-icon-pink pull-left">
                    <i class="md md-add-shopping-cart text-pink"></i>
                </div>
                <div class="text-right">
                    <h3 class="text-dark"><b class="counter"><?php echo Myclass::getTotalItems(); ?></b></h3>
                    <p class="text-muted"><?php echo Yii::t('admin','Total').' '.Yii::t('admin','Items'); ?></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-bg-color-icon card-box">
                <div class="bg-icon bg-icon-purple pull-left">
                    <i class="md  md-trending-up text-purple"></i>
                </div>
                <div class="text-right">
                    <h3 class="text-dark"><b class="counter"><?php echo Myclass::getTotalPromotions(); ?></b></h3>
                    <p class="text-muted"><?php echo Yii::t('admin','Total').' '.Yii::t('admin','Promotions'); ?></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-bg-color-icon card-box">
                <div class="bg-icon bg-icon-success pull-left">
                    <i class="md  md-swap-vert-circle text-success"></i>
                </div>
                <div class="text-right">
                    <h3 class="text-dark"><b class="counter"><?php echo Myclass::getTotalExchanges(); ?></b></h3>
                    <p class="text-muted"><?php echo Yii::t('admin','Total').' '.Yii::t('admin','Exchanges'); ?></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


       <div class="row">
	    	<div class="col-lg-8">
	    		<div class="card-box">
	    			<h4 class="text-dark header-title m-t-0 m-b-30"><?php echo Yii::t('admin','Items added this week'); ?></h4>
	    			<div>
	                	<div id="morris-bar-chart" style="height: 320px;"></div>
	                </div>
	    		</div>
	    	</div>
	    	<!-- col -->
			<div class="col-lg-4">
				<div class="card-box">
					<h4 class="text-dark header-title m-t-0 m-b-0"><?php echo Yii::t('admin',"Today's").' '.Yii::t('admin','Users').' '.Yii::t('admin','Log'); ?></h4>
					<div>
						<div id="morris-donut-chart" style="height: 350px;"></div>
					</div>
					<!-- /.panel-body -->
				</div>
			</div>
	    	<!-- col -->
	    		
	    	
	    </div>
	    <!-- end row -->


	    <div class="row">
	    	<div class="col-lg-8">
	    		<div class="card-box">
	    			<h4 class="text-dark header-title m-t-0 m-b-30"><?php echo Yii::t('admin','Promotions added this week'); ?></h4>
	    			<div>
	                	<div id="morris-area-chart-sales" style="height: 320px;"></div>
	                </div>
	    		</div>
	    	</div>
	    	<!-- col -->
	    	
			<div class="col-lg-4">
				<div class="card-box">
					<h4 class="text-dark header-title m-t-0 m-b-0"><?php echo Yii::t('admin',"Today's").' '.Yii::t('admin','Promotions').' '.Yii::t('admin','Log'); ?></h4>
					<div class="">
						<div id="morris-donut-chart-sales" style="height: 350px;"></div>
					</div>
					<!-- /.panel-body -->
				</div>
			</div>
	    	<!-- col -->
	    		
	    	
	    </div>
	    <!-- end row -->



		<div class="row">
			<div class="col-lg-8">
				<div class="card-box">
						<h4 class="text-dark header-title m-t-0 m-b-0"><?php echo Yii::t('admin','Users').' '.Yii::t('admin','Log'); ?></h4>
					
					<!-- /.panel-heading -->
					<div class="">
						<div id="morris-area-chart"></div>
					</div>
					<!-- /.panel-body -->
				</div>
			</div>
			<div class="col-lg-4">
			<!-- /.panel -->
			<div class="card-box">
					<h4 class="text-dark header-title m-t-0 m-b-0"><?php echo Yii::t('admin','Send Pushnotification'); ?></h4></br>
				<div class="">
					
						<div class="contact-message form-group">
					<input type=hidden name=lastkey id=lastkey>
					<textarea class="admin-textarea" name="admin-textarea" rows="5" cols="30"
						id="admin-textarea" onkeyup="keyban(event)"
						onkeydown="keyHandler(event)"></textarea>
					
					
				</div>
					<div class="option-error adminpushnot-error"></div>
					<div class="option-success adminpushnot-success"></div>
					<div class="contact-buttons-area">
					<div class="btn btn-success send-button" id="adminpushnot">
					<?php echo Yii::t('app','Send'); ?>
					</div>
				</div>

					</div>
			</div>
			<!-- /.panel -->
			</div>

		</div>

	</div>
	<!--  <div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-clock-o fa-fw"></i> Responsive Timeline
			</div>
			
			<div class="panel-body">
				<ul class="timeline">
					<li>
						<div class="timeline-badge">
							<i class="fa fa-check"></i>
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">Lorem ipsum dolor</h4>
								<p>
									<small class="text-muted"><i class="fa fa-clock-o"></i> 11
										hours ago via Twitter</small>
								</p>
							</div>
							<div class="timeline-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
									Libero laboriosam dolor perspiciatis omnis exercitationem.
									Beatae, officia pariatur? Est cum veniam excepturi. Maiores
									praesentium, porro voluptas suscipit facere rem dicta, debitis.</p>
							</div>
						</div>
					</li>
					<li class="timeline-inverted">
						<div class="timeline-badge warning">
							<i class="fa fa-credit-card"></i>
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">Lorem ipsum dolor</h4>
							</div>
							<div class="timeline-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
									Autem dolorem quibusdam, tenetur commodi provident cumque magni
									voluptatem libero, quis rerum. Fugiat esse debitis optio,
									tempore. Animi officiis alias, officia repellendus.</p>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
									Laudantium maiores odit qui est tempora eos, nostrum provident
									explicabo dignissimos debitis vel! Adipisci eius voluptates, ad
									aut recusandae minus eaque facere.</p>
							</div>
						</div>
					</li>
					<li>
						<div class="timeline-badge danger">
							<i class="fa fa-bomb"></i>
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">Lorem ipsum dolor</h4>
							</div>
							<div class="timeline-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
									Repellendus numquam facilis enim eaque, tenetur nam id qui vel
									velit similique nihil iure molestias aliquam, voluptatem totam
									quaerat, magni commodi quisquam.</p>
							</div>
						</div>
					</li>
					<li class="timeline-inverted">
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">Lorem ipsum dolor</h4>
							</div>
							<div class="timeline-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
									Voluptates est quaerat asperiores sapiente, eligendi, nihil.
									Itaque quos, alias sapiente rerum quas odit! Aperiam officiis
									quidem delectus libero, omnis ut debitis!</p>
							</div>
						</div>
					</li>
					<li>
						<div class="timeline-badge info">
							<i class="fa fa-save"></i>
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">Lorem ipsum dolor</h4>
							</div>
							<div class="timeline-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
									Nobis minus modi quam ipsum alias at est molestiae excepturi
									delectus nesciunt, quibusdam debitis amet, beatae consequuntur
									impedit nulla qui! Laborum, atque.</p>
								<hr>
								<div class="btn-group">
									<button type="button"
										class="btn btn-primary btn-sm dropdown-toggle"
										data-toggle="dropdown">
										<i class="fa fa-gear"></i> <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">Action</a>
										</li>
										<li><a href="#">Another action</a>
										</li>
										<li><a href="#">Something else here</a>
										</li>
										<li class="divider"></li>
										<li><a href="#">Separated link</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">Lorem ipsum dolor</h4>
							</div>
							<div class="timeline-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
									Sequi fuga odio quibusdam. Iure expedita, incidunt unde quis
									nam! Quod, quisquam. Officia quam qui adipisci quas
									consequuntur nostrum sequi. Consequuntur, commodi.</p>
							</div>
						</div>
					</li>
					<li class="timeline-inverted">
						<div class="timeline-badge success">
							<i class="fa fa-graduation-cap"></i>
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title">Lorem ipsum dolor</h4>
							</div>
							<div class="timeline-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
									Deserunt obcaecati, quaerat tempore officia voluptas debitis
									consectetur culpa amet, accusamus dolorum fugiat, animi dicta
									aperiam, enim incidunt quisquam maxime neque eaque.</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
			
		</div>
		
	</div>
	
	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bell fa-fw"></i> Notifications Panel
			</div>
			
			<div class="panel-body">
				<div class="list-group">
					<a href="#" class="list-group-item"> <i class="fa fa-comment fa-fw"></i>
						New Comment <span class="pull-right text-muted small"><em>4
								minutes ago</em> </span>
					</a> <a href="#" class="list-group-item"> <i
						class="fa fa-twitter fa-fw"></i> 3 New Followers <span
						class="pull-right text-muted small"><em>12 minutes ago</em> </span>
					</a> <a href="#" class="list-group-item"> <i
						class="fa fa-envelope fa-fw"></i> Message Sent <span
						class="pull-right text-muted small"><em>27 minutes ago</em> </span>
					</a> <a href="#" class="list-group-item"> <i
						class="fa fa-tasks fa-fw"></i> New Task <span
						class="pull-right text-muted small"><em>43 minutes ago</em> </span>
					</a> <a href="#" class="list-group-item"> <i
						class="fa fa-upload fa-fw"></i> Server Rebooted <span
						class="pull-right text-muted small"><em>11:32 AM</em> </span>
					</a> <a href="#" class="list-group-item"> <i
						class="fa fa-bolt fa-fw"></i> Server Crashed! <span
						class="pull-right text-muted small"><em>11:13 AM</em> </span>
					</a> <a href="#" class="list-group-item"> <i
						class="fa fa-warning fa-fw"></i> Server Not Responding <span
						class="pull-right text-muted small"><em>10:57 AM</em> </span>
					</a> <a href="#" class="list-group-item"> <i
						class="fa fa-shopping-cart fa-fw"></i> New Order Placed <span
						class="pull-right text-muted small"><em>9:49 AM</em> </span>
					</a> <a href="#" class="list-group-item"> <i
						class="fa fa-money fa-fw"></i> Payment Received <span
						class="pull-right text-muted small"><em>Yesterday</em> </span>
					</a>
				</div>
				
				<a href="#" class="btn btn-default btn-block">View All Alerts</a>
			</div>
			
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
			</div>
			<div class="panel-body">
				<div id="morris-donut-chart"></div>
				<a href="#" class="btn btn-default btn-block">View Details</a>
			</div>
			
		</div>
		
		<div class="chat-panel panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-comments fa-fw"></i> Chat
				<div class="btn-group pull-right">
					<button type="button"
						class="btn btn-default btn-xs dropdown-toggle"
						data-toggle="dropdown">
						<i class="fa fa-chevron-down"></i>
					</button>
					<ul class="dropdown-menu slidedown">
						<li><a href="#"> <i class="fa fa-refresh fa-fw"></i> Refresh
						</a>
						</li>
						<li><a href="#"> <i class="fa fa-check-circle fa-fw"></i>
								Available
						</a>
						</li>
						<li><a href="#"> <i class="fa fa-times fa-fw"></i> Busy
						</a>
						</li>
						<li><a href="#"> <i class="fa fa-clock-o fa-fw"></i> Away
						</a>
						</li>
						<li class="divider"></li>
						<li><a href="#"> <i class="fa fa-sign-out fa-fw"></i> Sign Out
						</a>
						</li>
					</ul>
				</div>
			</div>
			
			<div class="panel-body">
				<ul class="chat">
					<li class="left clearfix"><span class="chat-img pull-left"> <img
							src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
							class="img-circle" />
					</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">Jack Sparrow</strong> <small
									class="pull-right text-muted"> <i class="fa fa-clock-o fa-fw"></i>
									12 mins ago
								</small>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Curabitur bibendum ornare dolor, quis ullamcorper ligula
								sodales.</p>
						</div>
					</li>
					<li class="right clearfix"><span class="chat-img pull-right"> <img
							src="http://placehold.it/50/FA6F57/fff" alt="User Avatar"
							class="img-circle" />
					</span>
						<div class="chat-body clearfix">
							<div class="header">
								<small class=" text-muted"> <i class="fa fa-clock-o fa-fw"></i>
									13 mins ago
								</small> <strong class="pull-right primary-font">Bhaumik Patel</strong>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Curabitur bibendum ornare dolor, quis ullamcorper ligula
								sodales.</p>
						</div>
					</li>
					<li class="left clearfix"><span class="chat-img pull-left"> <img
							src="http://placehold.it/50/55C1E7/fff" alt="User Avatar"
							class="img-circle" />
					</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">Jack Sparrow</strong> <small
									class="pull-right text-muted"> <i class="fa fa-clock-o fa-fw"></i>
									14 mins ago
								</small>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Curabitur bibendum ornare dolor, quis ullamcorper ligula
								sodales.</p>
						</div>
					</li>
					<li class="right clearfix"><span class="chat-img pull-right"> <img
							src="http://placehold.it/50/FA6F57/fff" alt="User Avatar"
							class="img-circle" />
					</span>
						<div class="chat-body clearfix">
							<div class="header">
								<small class=" text-muted"> <i class="fa fa-clock-o fa-fw"></i>
									15 mins ago
								</small> <strong class="pull-right primary-font">Bhaumik Patel</strong>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Curabitur bibendum ornare dolor, quis ullamcorper ligula
								sodales.</p>
						</div>
					</li>
				</ul>
			</div>
			
			<div class="panel-footer">
				<div class="input-group">
					<input id="btn-input" type="text" class="form-control input-sm"
						placeholder="Type your message here..." /> <span
						class="input-group-btn">
						<button class="btn btn-warning btn-sm" id="btn-chat">Send</button>
					</span>
				</div>
			</div>
			<!-- /.panel-footer -->
</div>
<!-- /.panel .chat-panel -->
</div>
<!-- /.col-lg-4 -->
</div>
<?php
$leastDate = date("d-m-Y",strtotime("-7 days"));
?>

<script>
var chat = '<?php echo Myclass::getChatBuyCount(); ?>';
var adds = '<?php echo Myclass::getPromotionsAddsCount(); ?>';
var urgent = '<?php echo Myclass::getPromotionsUrgentCount(); ?>';

var reguser = '<?php echo Myclass::getRegisteredUsers(); ?>';
var loguser = '<?php echo Myclass::getLoggedUsers(); ?>';
function changeDateFormat(mydate)   {  
	var dateDMY = new Date(mydate);  
    var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ]; 
	var date =  dateDMY.getDate();   
	var month = monthNames[dateDMY.getMonth()];    
	var year = dateDMY.getFullYear();  
	var mydate = "";  
	var seperator = "-";  
	mydate = mydate.concat(date,seperator,month,seperator,year);    
    return mydate;  
     }  
$(function() {

	Morris.Bar({
        element: 'morris-area-chart-sales',
        data: [
        <?php for($i=1;$i<=7; $i++) { 
        	echo '{
        	      period: "'.date("Y-m-d",strtotime($leastDate."+".$i."days")).'",
        	      exchange:'.Myclass::getPromotionsAdds(date("d-m-Y",strtotime($leastDate."+".$i."days"))).',
        	      instant:'.Myclass::getPromotionsUrgent(date("d-m-Y",strtotime($leastDate."+".$i."days"))).',
                  },'; 
        } ?>
        ],
        xkey: 'period',
        ykeys: ['exchange','instant'],
        labels: ['<?php echo Yii::t('admin','Ads Promotions'); ?>','<?php echo Yii::t('admin','Urgent Promotions'); ?>'],
        //pointSize: 5,
        xLabelMargin: 7,
        //ymin : 0,
        //xLabelFormat : function(x) { return changeDateFormat(x); },
        //dateFormat : function(x) { return changeDateFormat(x); },
        //gridIntegers :true,
        hideHover: 'auto',
        resize: true,
    });
	Morris.Donut({
	    element: 'morris-donut-chart-sales',
	    data: [{
	        label: "<?php echo Yii::t('admin','Ads Promotions'); ?>",
	        value: adds
	    }, {
	        label: "<?php echo Yii::t('admin','Urgent Promotions'); ?>",
	        value: urgent
	    }],
	   
	    resize: true
	});

	Morris.Bar({
        element: 'morris-area-chart',
        data: [
        <?php for($i=1;$i<=7; $i++) { 
        	echo '{
        	      period: "'.date("Y-m-d",strtotime($leastDate."+".$i."days")).'",
        	      regcount:'.Myclass::getRegisteredUsers(date("d-m-Y",strtotime($leastDate."+".$i."days"))).',
        	      logcount:'.Myclass::getLoggedUsers(date("d-m-Y",strtotime($leastDate."+".$i."days"))).',
                  },'; 
        } ?>
        ],
        xkey: 'period',
        ykeys: ['regcount','logcount'],
        labels: ['<?php echo Yii::t('admin','Registered').' '.Yii::t('admin','Users'); ?>','<?php echo Yii::t('admin','Logged In').' '.Yii::t('admin','Users'); ?>'],
        //pointSize: 5,
        xLabelMargin: 7,
        //xLabelFormat : function(x) { return changeDateFormat(x); },
        //dateFormat : function(x) { return changeDateFormat(x); },
        hideHover: 'auto',
        //ymin:0,
        //gridIntegers :true,
        resize: true
    });

	Morris.Donut({
	    element: 'morris-donut-chart',
	    data: [{
	        label: "<?php echo Yii::t('admin','Registered').' '.Yii::t('admin','Users'); ?>",
	        value: reguser
	    }, {
	        label: "<?php echo Yii::t('admin','Logged In').' '.Yii::t('admin','Users'); ?>",
	        value: loguser
	    }],
	   
	    resize: true
	});


Morris.Area({
    element: 'morris-bar-chart',
    data: [
           <?php for($i=1;$i<=7; $i++) { 
           	echo '{
           	      period: "'.date("Y-m-d",strtotime($leastDate."+".$i."days")).'",
           	      count:'.Myclass::getItemsAdded(date("d-m-Y",strtotime($leastDate."+".$i."days"))).',
                     },'; 
           } ?>
          ],
    xkey: 'period',
    ykeys: ['count'],
    labels: ['<?php echo Yii::t('admin','Items').' '.Yii::t('admin','Added'); ?>'],
    pointSize: 5,
    xLabelMargin: 7,
    xLabelFormat : function(x) { return changeDateFormat(x); },
    dateFormat : function(x) { return changeDateFormat(x); },
    hideHover: 'auto',
    ymin:0,
    gridIntegers :true,
    resize: true,
});

});

</script>


