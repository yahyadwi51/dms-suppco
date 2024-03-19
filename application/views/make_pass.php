<?php

use setasign\FpdiProtection\FpdiProtection;

require_once 'vendor/pass/fpdip/src/autoload.php';
require_once 'vendor/pass/fpdi/src/autoload.php';
require_once 'vendor/pass/fpdf/fpdf.php';

/**
 * password for the pdf file
 */
foreach ($data1 as $row): {
        $nama_dok = $row['nama_dokumen'];
        //   // endforeach;
        $idq = $row['password'];

    }endforeach;

$password = $this->encryption->decrypt($row['password']);
// echo $idq;

/**
 * name of the original file (unprotected)
 */
$origFile1 = FCPATH . $destFile3;

/**
 * name of the destination file
 */
// $destFile1 = "download-file".$username.".pdf";
$destFile1 = "DMS-File-" . $nama_dok . ".pdf";

if ($izin_dok == "Approve") {
    pdfEncrypt_print($origFile1, $password, $destFile1);
} else {
    pdfEncrypt($origFile1, $password, $destFile1);
}

function pdfEncrypt($origFile1, $password, $destFile1)
{
    $pdf = new FpdiProtection();

//calculate the number of pages from the original document
    $pageCount = $pdf->setSourceFile($origFile1);

// copy all pages from the old unprotected pdf in the new one
    for ($loop = 1; $loop <= $pageCount; $loop++) {
        $tplidx = $pdf->importPage($loop);
        $pdf->addPage();
        $pdf->useTemplate($tplidx);
    }

// protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
    $pdf->SetProtection(array('annot-forms'));
    // $output=$destFile1.".pdf";
    $pdf->Output($destFile1, 'D');

    // return $destFile1;

}

function pdfEncrypt_print($origFile1, $password, $destFile1)
{
    $pdf = new FpdiProtection();

//calculate the number of pages from the original document
    $pageCount = $pdf->setSourceFile($origFile1);

// copy all pages from the old unprotected pdf in the new one
    for ($loop = 1; $loop <= $pageCount; $loop++) {
        $tplidx = $pdf->importPage($loop);
        $pdf->addPage();
        $pdf->useTemplate($tplidx);
    }

// protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
    $pdf->SetProtection(array('print', 'copy'), $password, "");
    // $output=$destFile1.".pdf";
    $pdf->Output($destFile1, 'D');
    // redirect('c_pengelolah_dokumen_dms/index');

    // return $destFile1;

}
// redirect('c_pengelolah_dokumen_dms/index');
