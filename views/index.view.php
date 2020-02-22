<?php defined('RAXANPDI')||exit(); ?>
<div class="row">
	<h2 class="page-header">Dashboard</h2>
</div>

<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <a href="news.php">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="news_count"></div>
                        <div>News Articles</div>
                    </div>
                </div>
            </div> 
            <div class="panel-footer">
                <span class="pull-left">View List</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="destinations.php">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-map-marker fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="des_count" ></div>
                        <div>Featured Destinations</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">View List</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="specials.php">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="spec_count"></div>
                        <div>Specials/Discount</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">View List</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6">
        <a href="ads.php">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-ticket fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="ad_count"></div>
                        <div>Ads</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <span class="pull-left">View list</span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
        </a>
    </div>
</div>
<!-- /.row -->    

<!-- Message --> 
<div class="row">
<div class="col-lg-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-comment fa-fw"></i> Send notification to device
        </div>
        <div class="panel-body">
        	<form name="frm" id="frm" method="post">
            <!--div class="form-group">
          	<label for="group">Group</label>
                <select class="form-control" name="group" id="group">
                    <option>Option 1</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                </select>
           	</div-->
			<div class="form-group">
           		<label for="subject">Subject</label>
                <input class="form-control" placeholder="(Optional)" name="subject" id="subject" maxlength="100" />
       		</div>
           	<div class="form-group">
           		<label for="message">Message</label>
                <input class="form-control" placeholder="Enter message here" name="message" id="message" maxlength="200" required />
            </div>
            <div class="form-group text-right"><button type="submit" class="btn btn-primary" id="btn">Send Message</button></div>
            </form>
        </div>
    </div>
</div>
<!-- End Message --> 

<!--div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-info-circle fa-fw"></i> Statistics
        </div>
        <div class="panel-body">
              <div class="list-group">
                <a href="#" class="list-group-item">
                    <i class="fa fa-comment fa-fw"></i>Clients
                    <span class="pull-right text-muted small"><em>-</em>
                    </span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-comment fa-fw"></i>App Installed
                    <span class="pull-right text-muted small"><em>12</em>
                    </span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-comment fa-fw"></i>App Installed This Week
                    <span class="pull-right text-muted small"><em>12</em>
                    </span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-twitter fa-fw"></i>Registered users
                    <span class="pull-right text-muted small"><em>12</em>
                    </span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-envelope fa-fw"></i> Logon user for today
                    <span class="pull-right text-muted small"><em>2</em>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
</div-->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Alert</h4>
            </div>
            <div class="modal-body" id="msg_body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
function callModal(){    
    //$('#myModal').modal();                      // initialized with defaults
    //$('#myModal').modal({ keyboard: false });   // initialized with no keyboard
    $('#myModal').modal('show');                // initializes and invokes show immediately   
}
</script>