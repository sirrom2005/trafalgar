<?php defined('RAXANPDI')||exit(); ?>
<div class="row">
	<h2 class="page-header">
    	<a style="float:right" href="ads.php" class="btn btn-social btn-bitbucket btn-success"><i class="fa fa-list fa-fw"></i> List Advertisement</a>
    	Add Advertisement
    </h2>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-ticket fa-fw"></i> <span id="panel-heading">Add</span> </div>	
            <div class="panel-body">
                <form name="frm" id="frm" method="post" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" placeholder="title" name="title" id="title" maxlength="100" required="true" />
                    </div>
                    <div class="form-group">
                        <label for="message">Content</label>
                        <textarea class="form-control" placeholder="news body" name="details" id="details" rows="10"></textarea>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-6">
                                <label for="start_date">Start date</label>
                                <input type="text" class="form-control"  name="start_date" id="start_date" placeholder="yyyy-mm-dd"  required="true"/>
                            </div>
                            <div class="col-lg-6">
                                <label for="end_date">End date</label>
                                <input type="text" class="form-control"  name="end_date" id="end_date"  placeholder="yyyy-mm-dd"  required="true" />
                            </div>                      
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-6">
                                <label for="message">Banner</label>
                                <input type="file" name="file_data" id="file_data"/>
                            </div>
                            <div class="col-lg-6 text-right">
                                <label for="enable">Publish</label>
                                <input type="checkbox" name="enabled" id="enabled" value="1" />
                            </div>                       
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary" id="btn"><i class="fa fa-save fa-fw"></i> <span>Save</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <img width="400" src="views/images/blank.gif" id="gallery"/>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Alert</h4>
            </div>
            <div class="modal-body">
                Destination updated successfully;
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="views/dist/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
  selector: 'textarea',
  height: 500,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons | link codesample help',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });  
function callModal(){    
    //$('#myModal').modal();                      // initialized with defaults
    //$('#myModal').modal({ keyboard: false });   // initialized with no keyboard
    $('#myModal').modal('show');                // initializes and invokes show immediately   
}
</script>