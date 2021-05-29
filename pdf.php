<?php

require __DIR__."/vendor/autoload.php";

$pdf = new TCPDF($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false);
$pdf->AddPage();

$html = "<html><body><table><tr><th><b>Subject</b></th><th><b>Room</b></th></tr>";

$xml = simplexml_load_file("class.xml") or die("Error: Cannot create object");
foreach($xml->course as $course) {
    $html = $html."<tr>";
    $html = $html."<td>".$course->subject."</td>";
    $html = $html."<td>".$course->room."</td>";
    $html = $html."</tr>";
}

$html = $html."</table></body></html>";


$pdf->writeHTML($html,$ln = true,$fill = false,$reseth = false,$cell = false,$align = '');

$pdf->Output('rooms.pdf'); 

?>