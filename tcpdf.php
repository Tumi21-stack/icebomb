<?php

// Include the TCPDF library
include 'tcpdf.php';

// Function to generate a PDF for the newsletter
function generateNewsletterPDF($subject, $message) {
    // Create a new PDF document
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('ICE BOMBS');
    $pdf->SetTitle($subject);
    $pdf->SetSubject($subject);
    $pdf->SetKeywords('Newsletter, PDF, ICE BOMBS');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Prepare the content for the PDF
    $htmlContent = '
        <h1>' . htmlspecialchars($subject) . '</h1>
        <p>' . nl2br(htmlspecialchars($message)) . '</p>
    ';

    // Write the HTML content to the PDF
    $pdf->writeHTML($htmlContent, true, false, true, false, '');

    // Define the path to save the PDF
    $fileName = 'newsletter_' . time() . '.pdf';
    $filePath = __DIR__ . '/' . $fileName;

    // Save the PDF to the filesystem
    $pdf->Output($filePath, 'F'); // Save as a file (F)

    // Return the path to the generated PDF
    return $filePath;
}
?>