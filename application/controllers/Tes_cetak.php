<?php
class Tes_cetak {
  function index(){
    require_once(APPPATH.'libraries/tcpdf/tcpdf.php');
      require_once(APPPATH.'libraries/tcpdf/tcpdi.php');
      print_r();
      // Create new PDF document.
      $pdf = new TCPDI(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      
      // Add a page from a PDF by file path.
     
      print_r(base_url('uploads/generated.pdf'));
      $pdfdata = file_get_contents(base_url('uploads/generated.pdf')); // Simulate only having raw data available.
      $pagecount = $pdf->setSourceData($pdfdata);
      for ($i = 1; $i <= $pagecount; $i++) {
          $tplidx = $pdf->importPage($i);
          $pdf->AddPage();
          $pdf->useTemplate($tplidx);
      }
      $pdf->Output('D', $datadok);
}


}
 ?>
