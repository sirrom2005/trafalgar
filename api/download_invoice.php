<?php
require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');
include_once("config/ps_config.php");
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('rohanmorris.info');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Invoice Document');
$pdf->SetKeywords('invoice, travel, mobile app');
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
$sql = "SELECT inv.fare,inv.classofsvc,inv.route,pr.firstname,pr.lastname,bk.vatamt,bk.vendorname,pr.address1,pr.address2, pr.address3, inv.client_lin, inv.issuedate, inv.invoicenum, inv.dk_number,inv.tramsno,inv.currency_key, 
        inv.ja_to_us,inv.approver ,inv.duedate, inv.name, inv.profiletyp, inv.agntname, bk.departdate, bk.returndate, pr.email,pr.ind_compy,b.taxnumber, 
        b.iatano,al.nitnumber,bk.vendor_lin,bk.totaltaxes, inv.recordloca, inv.agent_link, b.branch_name, tt.traveldesc,pr.taxnum, 
        bk.traveltype, b.address_1, b.address_2, pr.telephone1, pr.telephone2,pr.email1,pr.tlend, pr.cell, 
        bk.validal,bk.invoice_li, bk.startingti, bk.passengern, bk.calcbasefa
        FROM invoice inv 
        INNER JOIN profile pr ON inv.dk_number = pr.dk_number 
        INNER JOIN booking bk ON inv.invoiceno = bk.invoice_li 
        LEFT JOIN airline al ON bk.validal = al.validal 
        INNER JOIN branch b ON b.branch_key = inv.branch_key 
        LEFT OUTER JOIN traveltypes tt ON tt.traveltype = bk.traveltype     
        WHERE inv.invoiceno = ?";
try{
    $sth = $db->prepare($sql);
    $sth->execute(array($key));
    $rs = $sth->fetchAll(PDO::FETCH_NAMED);
    //echo "<pre>"; print_r($rs); echo "</pre>"; return;
}catch(Exception $ex){
    echo '_SYS_ERROR_';
    exit();
}
ob_start();
?>
<style>
table,body{font-family:Arial, Helvetica, sans-serif;font-size:10px;}
div#title{font-weight:bold;color:#000; font-size:20px;}
table#info th{text-align:left;color:#000; font-weight:bold;}
</style>
<table width="100%">
    <tr>
        <td width="75%"><img width="200" src="i/page_header.png" /></td>
        <td width="25%">
            <div id="title">Tax Invoice</div>
        </td>
    </tr>
    <tr><td colspan="2"><?php echo $rs[0]['address_1'];?>, <?php echo $rs[0]['address_2'];?></td></tr>
</table>
<div style="height:20px;"></div>
<table id="info" width="100%"  cellpadding="2" cellspacing="0">
  <tr>
    <th width="18%">Branch Location:</th>
    <td width="50%"><?php echo $rs[0]['branch_name'];?></td>
    <th width="17%">Invoice No:</th>
    <td width="15%"><?php echo $rs[0]['invoicenum'];?></td>
  </tr>
  <tr>
    <th>Client No:</th>
    <td><?php echo $rs[0]['dk_number'];?></td>
    <th>Invoice Date:</th>
    <td><?php echo $rs[0]['issuedate'];?></td>
  </tr>
  <tr>
    <th>Client Name:</th>
    <td style="font-size:9px;"><?php echo $rs[0]['name'];?></td>
    <th>Due Date:</th>
    <td><?php echo $rs[0]['duedate'];?></td>
  </tr>
  <tr>
    <th>Client Address:</th>
    <td><?php echo $rs[0]['address1'];?>, <?php echo $rs[0]['address2'];?></td>
    <th>Consultant:</th>
    <td><?php echo $rs[0]['agntname'];?></td>
  </tr>
  <tr>
    <th>Purchase Order:</th>
    <td>&nbsp;</td>
    <th>Record Locator:</th>
    <td><?php echo $rs[0]['recordloca'];?></td>
  </tr>
</table>
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr>      
    	<th>Travel</th>
        <th>Carr/Ven</th>
        <th>Passenger(s)</th>
        <th>Ticket</th>
        <th>Depart</th>
        <th>Return</th>
        <th>Amount</th>
    </tr>
    <tr>      
    	<td><?php echo $rs[0]['traveldesc'];?></td>
        <td><?php echo $rs[0]['vendorname'];?></td>
        <td><?php echo $rs[0]['passengern'];?></td>
        <td><?php echo $rs[0]['startingti'];?></td>
        <td><?php echo $rs[0]['departdate'];?></td>
        <td><?php echo $rs[0]['returndate'];?></td>
        <td>---</td>
    </tr>
</table>  
<table cellpadding="5" cellspacing="0" border="1" width="100%">
    <tr>      
    	<td>Service:</td>
        <td><?php echo $rs[0]['fare'].' - '.$rs[0]['classofsvc'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>      
    	<td>Route:</td>
        <td><?php echo $rs[0]['route'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>      
    	<td width="20%">Invoice Total:</td>
        <td width="65%">-</td>
        <td width="15%" align="right">2,000,000</td>
    </tr>
</table>
<p>&nbsp;</p>  
<p style="font-size:8px; text-align:center;">CREDIT CARD CHARGES MAY DIFFER FROM THE AMOUNT STATED ON YOUR INVOICE.<br>
THIS MAY BE DUE TO THE FEES THAT ARE IMPOSED ON CREDIT CARD TRANSACTIONS BY THE AIRLINES' PROCESSING AGENTS.<br>
PROCESSING FEE RATES VARY BETWEEN A LOW OF 1.75% TO A HIGH OF 5%.<br>
FOR ANY QUERIES, PLEASE EMAIL <a href="mailto:accounts@thetrafalgartravel.com" title="">ACCOUNTS@THETRAFALGARTRAVEL.COM</a></p>

<p style="font-size:8px; color:red; text-align:center;">LOCAL & INTERNATIONAL TRAVEL ARRANGEMENTS * HOTELS * CAR RENTALS * CRUISES * ITINERARY PLANNING<br>
TOUR PACKAGES * CUSTOM VACATION PLANNING</p>
<?php
$html = ob_get_contents();
ob_end_clean();
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('invoice.pdf', 'I');