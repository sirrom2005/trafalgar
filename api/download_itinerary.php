<?php
require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');
include_once("config/ps_config.php");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('rohanmorris.info');
$pdf->SetTitle('Itnerary');
$pdf->SetSubject('Itnerary Document');
$pdf->SetKeywords('itnerary, travel, mobile app');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(255,255,255));
$pdf->setFooterData(array(0,64,0), array(255,255,255));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set some language-dependent strings (optional)
if(file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
}
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 12, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


$key  = filter_input(INPUT_GET, 'key');
if(empty($key)){ echo '_NOT_DATA_'; return null; }
$sql = "SELECT 
        invoiceno,
        issuedate,
        route,
        name,
        trim(recordloca) AS recordloca,
        trim(inv.classofsvc) AS classofsvc,     
        dap.a_name AS dap_airport,
        aap.a_name AS a_airport,
        trim(destination) AS destination,
        trim(flightno) AS flightno,
        departcity AS departcity, 
        trim(departcityname) AS departcityname,
        departdate,
        departtime,
        trim(arrivecity) AS arrivecity,
        trim(cityname) AS cityname,
        arrivedate, 
        arrivetime,
        airlinename AS airline,
        trim(mileage) AS mileage 
        FROM invoice inv 
        INNER JOIN itinerary it ON it.invoicenum = inv.invoiceno 
        INNER JOIN airline air ON air.validal = airline 
        INNER JOIN airports_iata dap ON trim(dap.iata_code) = trim(departcity)
        INNER JOIN airports_iata aap ON trim(aap.iata_code) = trim(arrivecity)
        WHERE invoiceno = ?
        ORDER BY indexno";
try{
    $sth = $db->prepare($sql);
    $sth->execute(array($key));
    $rs = $sth->fetchAll(PDO::FETCH_NAMED);
    
    //echo "<pre>"; print_r($rs); echo "</pre>"; 

}catch(Exception $ex){
    echo '_SYS_ERROR_';
    exit();
}
ob_start();
?>
<style>
table,body{font-family:Arial, Helvetica, sans-serif;font-size:10px;}
div#title{font-weight:bold;color:#000; font-size:18px;}
table#info th{text-align:left;color:#000; font-weight:bold;}
table#info td{border-bottom:solid 0px #000; padding:5px; text-align:left;}
table#travel{border:solid 1px #CCCCCC;}
table#travel th{text-align: left; padding:2px 5px 2px 5px; font-size:20px; color:#CCCCCC;}   
table#travel td{font-size:12px;}  
tr td.h2{font-size:14px;}
tr td.h3{font-size:10px;}
tr td.h4{font-weight:normal;}
</style>
<table width="100%">
    <tr>
        <td width="75%"><img width="200" src="i/page_header.png" /></td>
        <td width="25%">
        	<div id="title">ITNERARY</div>
            Booking ref: <?php echo $rs[0]['recordloca'];?>
        </td>
    </tr>
</table>
<div style="height:20px;"></div>
<table id="info" width="100%">
    <tr>
        <th width="10%">Traveler</th><td width="55%"><?php echo $rs[0]['name'];?></td>
        <th width="13%">Issued date:</th><td width="20%"><?php echo date('F d, Y', strtotime($rs[0]['issuedate']));?></td>
    </tr>
    <tr>
        <th><div style="height:0px;"></div>Your trip</th><td colspan="3"><div style="height:0px;"></div><?php echo str_replace('/','&raquo;',$rs[0]['route']);?></td>
    </tr>
</table>
<div style="height:20px;"></div>
<table cellspacing="0" cellpadding="0" width="100%">
    <tr style="background-color:#497389;">
        <td>
            <table cellspacing="0" cellpadding="0">
            	<tr>
                    <th width="35"><img width="32" src="i/plane_101.png"/></th>
                    <th>
                    	<table cellspacing="0" cellpadding="5"><tr><td style="color:#FFFFFF;font-size:15px; font-weight:bold;">Flights</td></tr></table>
                    </th>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php foreach($rs as $key => $value){ ?>
<table id="travel" cellspacing="0" cellpadding="5" width="100%">
    <tr style="background-color:#666;">
        <th style="text-align:center;font-size:14px;color:#FFFFFF;font-weight:normal;height:20px;">DEPARTURE</th>
        <th style="text-align:center;font-size:14px;color:#FFFFFF;font-weight:normal;height:20px;">ARRIVAL</th>
    </tr>
    <tr>
    	<td style="border-right:solid 1px #CCCCCC;"><table>
            	<tr><td class="h2"><?php echo $value['departcityname'];?></td></tr>
                <tr><td class="h3"><?php echo $value['dap_airport'];?></td></tr>
            </table>
        </td>
        <td><table>
                <tr><td class="h2"><?php echo $value['cityname'];?></td></tr>
                <tr><td class="h3"><?php echo $value['a_airport'];?></td></tr>
            </table>
        </td>
     </tr>
     <tr>
    	<td style="border-right:solid 1px #CCCCCC;"><table>
            	<tr>
                    <td class="h3"><b style="color:#333333;">SCHEDULED DEPARTURE</b><br />
                        <?php echo date('F d, Y.', strtotime($value['departdate']));?><br />
                        <?php echo date('g:i a', strtotime($value['departtime']));?>
                    </td>
                </tr>
             </table>   
          </td>
          <td><table>
                <tr>
                    <td class="h3"><b style="color:#333333;">ESTIMATED ARRIVAL</b><br />
                        <?php echo date('F d, Y.', strtotime($value['arrivedate']));?><br />
                        <?php echo date('g:i a', strtotime($value['arrivetime']));?>
                    </td>
            	</tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center; border-top:solid 1px #CCCCCC;">
        	<table cellspacing="0"  width="100%" cellpadding="10">
            	<tr>
                    <th>
                    	<b><?php echo (substr_count($value['airline'], 'air')==0)? $value['airline']. ' Airline' : $value['airline'];?></b><br />
                           <?php echo 'Flight '.$value['flightno'];?><br />
                           [<?php echo (substr_count($value['classofsvc'],'class')==0)? $value['classofsvc'] . ' Class' : $value['classofsvc'];?>]
                    </th>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div style="height:20px;"></div>
<?php } ?>

<?php
$html = ob_get_contents();
ob_end_clean();
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('itnerary.pdf', 'I');