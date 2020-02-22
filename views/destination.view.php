<?php defined('RAXANPDI')||exit(); ?>
<!-- DataTables CSS -->
<link href="views/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
<!-- DataTables Responsive CSS -->
<link href="views/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

<div class="row">
	<h2 class="page-header">
    	<a style="float:right" href="add_destination.php" class="btn btn-social btn-bitbucket btn-success"><i class="fa fa-plus-circle fa-fw"></i>Add Destination</a>
    	Featured Destination
    </h2>
</div>

<div class="row">
<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
        	<i class="fa fa-map-marker fa-fw"></i> Destination</div>	
        <div class="panel-body">
            <table id="data_table" width="100%" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th width="200">Date added</th>
                    <th width="100">Enabled</th>
                    <th width="20" class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td>{title}</td>
                    <td>{date_added}</td>
                    <td>{enabled}</td>
                    <td class="right">
                        <a href="#{id}" class="delete" data-event-confirm="This record will be deleted"><i class="glyphicon glyphicon-remove red"></i></a>&nbsp;
                        <a href="add_destination.php?id={id}" class="edit"><i class="fa fa-edit"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- /.table-responsive -->
        </div>
    </div>
</div>
</div>

<!-- DataTables JavaScript -->
<script src="views/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="views/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="views/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script>
$(document).ready(function() {
	$('#data_table').DataTable()({
			responsive: true,
			"order": [],
	"columnDefs": [ {
	  "targets"  : 'no-sort',
	  "orderable": false,
	}]
							});
});
	
</script>