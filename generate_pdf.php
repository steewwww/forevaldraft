<?php
header('Content-type: text/plain;charset=UTF-8');
require_once('tcpdf/tcpdf.php');
include("config.php");

// Step 1: Receive JSON POST data and decode it
$jsonInput = file_get_contents('php://input');
$data = json_decode($jsonInput, true);

// Step 2: Validate that the necessary data is present
if (!isset($data['input_one'], $data['input_two'], $data['input_three'])) {
    die('Missing data in the input');
}

$input_one = $data['input_one'];
$input_two = $data['input_two'];
$input_three = $data['input_three'];

// Fetch data from the database table
$query = "SELECT * FROM cart";
$result = mysqli_query($conn, $query);

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

// Calculate grand total
$grand_total = array_reduce($rows, function ($sum, $row) {
    return $sum + $row['total_price'];
}, 0);

// Extend TCPDF for custom header and footer
class MYPDF extends TCPDF {
    public function Header() {
        // Header content if needed
    }

    public function Footer() {
        // Footer content if needed
    }
}

// Create PDF instance
$pdf = new MYPDF();

// Set margins
$pdf->SetMargins(25, 10, 15); // Left, Top, Right

$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Set image file
$imageFile = 'cvsu.jpg';

// Set X and Y position on the page, and the width and height of the image
$x = 30;
$y = 10;
$width = 30;
$height = 0; // If set to 0, TCPDF will automatically calculate the height to maintain the aspect ratio

// Add image to the page
$pdf->Image($imageFile, $x, $y, $width, $height);

// Add centered text
$BookmanOldStyle = TCPDF_FONTS::addTTFfont('\xampp\htdocs\CvsuCanvassing\tcpdf\customfonts\BookmanOldStyle.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($BookmanOldStyle, 'B', 11);
$text = 'Republic of the Philippines';
$pdf->Cell(0, 10, $text, 0, 1, 'C', 0, '', 0, false, 'T', 'M'); // 'C' stands for center alignment, 'T' stands for top alignment, 'M' stands for middle of the cell



// Set Y position for the HTML content
$pdf->SetY(15); // Adjust this value as needed

// Add another centered text
$BOOKOSB = TCPDF_FONTS::addTTFfont('\xampp\htdocs\CvsuCanvassing\tcpdf\customfonts\BOOKOSB.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($BOOKOSB, 'B', 11);
$text2 = 'CAVITE STATE UNIVERSITY';
$pdf->Cell(0, 10, $text2, 0, 1, 'C', 0, '', 0, false, 'T', 'M'); // 'C' stands for center alignment, 'T' stands for top alignment, 'M' stands for middle of the cell

// Set Y position for the HTML content
$pdf->SetY(20); // Adjust this value as needed

// Add another centered text
$GOTHICB = TCPDF_FONTS::addTTFfont('\xampp\htdocs\CvsuCanvassing\tcpdf\customfonts\GOTHICB.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($GOTHICB, 'B', 11);
$text3 = 'Don Severino de las Alas Campus';
$pdf->Cell(0, 10, $text3, 0, 1, 'C', 0, '', 0, false, 'T', 'M'); // 'C' stands for center alignment, 'T' stands for top alignment, 'M' stands for middle of the cell

// Set Y position for the HTML content
$pdf->SetY(25); // Adjust this value as needed

// Add another centered text
$CenturyGothic = TCPDF_FONTS::addTTFfont('\xampp\htdocs\CvsuCanvassing\tcpdf\customfonts\CenturyGothic.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($CenturyGothic, '', 11);
$text4 = 'Indang, Cavite, Philippines';
$pdf->Cell(0, 10, $text4, 0, 1, 'C', 0, '', 0, false, 'T', 'M'); // 'C' stands for center alignment, 'T' stands for top alignment, 'M' stands for middle of the cell

// Set Y position for the HTML content
$pdf->SetY(30); // Adjust this value as needed

// Add another centered text
$text5 = '(046) 889-6373';
$pdf->Cell(0, 10, $text5, 0, 1, 'C', 0, '', 0, false, 'T', 'M'); // 'C' stands for center alignment, 'T' stands for top alignment, 'M' stands for middle of the cell

// Set Y position for the HTML content
$pdf->SetY(35); // Adjust this value as needed

// Add another centered text
$text6 = 'www.cvsu.edu.ph';
$pdf->Cell(0, 10, $text6, 0, 1, 'C', 0, '', 0, false, 'T', 'M'); // 'C' stands for center alignment, 'T' stands for top alignment, 'M' stands for middle of the cell

// Set font to bold
$pdf->SetFont('helvetica', 'B', 10);

// Add another centered text
$text7 = 'INVITATION TO SUBMIT QUOTATION';
$pdf->Cell(0, 10, $text7, 0, 1, 'C', 0, '', 0, false, 'T', 'M');

// Set Y position for the HTML content
$pdf->SetY(50); // Adjust this value as needed

// Display the result of input_one
$text10 = $input_one;
$pdf->Cell(0, 10, $text10, 0, 1, 'C', 0, '', 0, false, 'T', 'M');

$pdf->SetFont('helvetica', '', 10);

// Set Y position for the first HTML section
$yPositionSection1 = 20; // Adjust this value as needed
$pdf->SetY($yPositionSection1);

// Your existing HTML content for the first section
$htmlSection1 = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body>
        <div class="center-container">
            <div class="row justify-content-center">
                <div class="col-lg- px-20" id="order">
                    <header>
                        <p></p>
                    </header> 
                    <div class="container">
                        <h4></h4>
                        <p style="font-size: 11px; margin-left: 20px; text-align: justify;">
                        1. The Cavite State University (CvSU) invites interested firms/supplier to submit 
                        quotation for the project “<b>' . htmlspecialchars($input_one) . '</b>” with an  
                        Approved Budget for the Contract (ABC) 
                        <b>PhP ' . number_format($grand_total, 2) . '</b>
                        Quotation received in excess of the ABC shall be automatically rejected at the opening.
                    </p>
                    </div>
                    <table border="1" cellspacing="0" cellpadding="5" width="100%">
                        <thead>
                        <tr>
                            <th style="width: 35px;"><b>Item No.</b></th>
                            <th style="width: 55px;"><b>Quantity</b></th>
                            <th style="width: 45px;"><b>Unit</b></th>
                            <th style="width: 180px;"><b>Description</b></th>
                            <th><b>Unit Cost</b></th>
                            <th><b>Total Cost</b></th>
                        </tr>
                    
                        </thead>
                        <tbody>';

                        foreach ($rows as $item_num => $row) {
                            $htmlSection1 .= '<tr>
                                        <td style="width: 35px;">' . ($item_num + 1) . '</td>
                                        <td style="width: 55px;">' . $row['qty'] . '</td>
                                        <td style="width: 45px;">' . $row['product_name'] . '</td>
                                        <td style="width: 180px;">' . nl2br(htmlspecialchars($row['description'])) . '</td>
                                        <td>' . number_format($row['product_price'], 2) . '</td>
                                        <td>' . number_format($row['total_price'], 2) . '</td>
                                      </tr>';
                        }
                        

// Output the table and total for the first section
$htmlSection1 .= '</tbody>
    </table>
    <div id="invoice-total" style="text-align: right; margin-top: 10px; padding-right: 20px;">
        <p>Total Amount: <b style="border: 1px solid #000; padding: 5px;">' . number_format($grand_total, 2) . '</b></p>
    </div>
</div>
</div>
</div>';

// Output the first section
$pdf->writeHTML($htmlSection1, true, false, true, false, '');

// Set Y position for the second HTML section
$yPositionSection2 = $pdf->GetY() + 10; // Add some margin between sections
$pdf->SetY($yPositionSection2);

$htmlSection2 = '<header>
        <p style="font-size: 11px; margin-left: 20px; text-align: justify;">2. Delivery Period: ____ calendar days from the receipt of P.O.<br></p>
        <p style="font-size: 11px; margin-left: 20px; text-align: justify;">3. Price quotations must be valid for a period of sixty (60) calendar days from date of
            submission and shall include all taxes, duties, and/or levies payable. Bidders shall also
            indicate the brand and model of the items being offered.<br></p>
        <p style="font-size: 11px; margin-left: 20px; text-align: justify;">4. Warranty shall be for a period of six (6) months for supplies and materials. The warranty for
            equipment must not be less than one (1) year from the date of acceptance and shall be
            accompanied by a Warranty Certificate.<br></p>
        <p style="font-size: 11px; margin-left: 20px; text-align: justify;">5. The quotation must be submitted to the Procurement Office through mail, fax, or email at
            the contact details listed below <b>' . htmlspecialchars($input_two) . '</b> of <b>' . htmlspecialchars($input_three) . '</b>. <br></p>
            <table cellspacing="0" cellpadding="0">
            <tr>
                <td style="font-size: 9px; text-align: center;">Address:</td>
                <td style="font-size: 9px;">Procurement Office, Administration Building Cavite State University Indang, Cavite</td>
            </tr>
            <tr>
                <td style="font-size: 9px; text-align: center;">E-mail:</td>
                <td style="font-size: 9px;">procurementoffice@cvsu.edu.ph / rfqmain@cvsu.edu.ph</td>
            </tr>
            <tr>
                <td style="font-size: 9px; text-align: center;">Telefax:</td>
                <td style="font-size: 9px;">(046) 889-6373</td>
            </tr>
        </table>
                <p style="font-size: 11px; margin-left: 20px; text-align: justify;">6. The CvSU reserves the right to reject any or all quotations and/or proposals and waive
            any formalities/informalities therein and to accept such bids it may consider as most
            advantageous to the agency and to the government. CvSU neither assumes any
            obligation for whatsoever losses that may be incurred in the preparation of bids, nor does
            it guarantee that an award will be made. <br></p>
    </header>';
// Output the second section
$pdf->writeHTML($htmlSection2, true, false, true, false, '');


// Set font to bold
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(15);
$pdf->Cell(0, 15, 'JANJAN BALABA                                                     ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 15, 'BAC Secretary, Goods and Consulting Services', 0, false, 'R', 0, '', 0, false, 'M', 'M');
$pdf->Image('\xampp\htdocs\CvsuCanvassing\img\signature.png', 115, ($pdf->GetY() - 20), 18, 18, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

// Output PDF as a download
$pdf->Output('your_filename.pdf', 'D');

?>
