<?php defined('RAXANPDI')||exit(); ?>
<div class="row">
	<h2 class="page-header">
    	<a style="float:right" href="news.php" class="btn btn-social btn-bitbucket btn-success"><i class="fa fa-list fa-fw"></i> List news</a>
    	News Article
    </h2>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-file-o fa-fw"></i> <span id="panel-heading">Add</span> </div>	
            <div class="panel-body">
                <form name="frm" id="frm" method="post" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label for="subject">Title</label>
                        <input type="text" class="form-control" placeholder="title" name="title" id="title" maxlength="100" required="true" />
                    </div>
                    <div class="form-group">
                        <label for="message">Content</label>
                        <textarea class="form-control" placeholder="news body" name="body" id="body" rows="10"></textarea>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-6">
                                <label for="message">Photo</label>
                                <!--input type="hidden" name="photo" id="photo"/-->
                                <input type="file" name="file_data" id="file_data" />
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
                Article updated successfully;
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script src="views/dist/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
  selector: 'textarea',
  height:300,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor emoticons | codesample help',
  content_css: '//www.tinymce.com/css/codepen.min.css'
});

function callModal(){    
    //$('#myModal').modal();                      // initialized with defaults
    //$('#myModal').modal({ keyboard: false });   // initialized with no keyboard
    $('#myModal').modal('show');                // initializes and invokes show immediately   
}
</script>