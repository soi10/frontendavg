<?php
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp',
    'fontdata' => $fontData + [
            'sarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNewItalic.ttf',
                'B' =>  'THSarabunNewBold.ttf',
                'BI' => "THSarabunNewBoldItalic.ttf",
            ]
        ],
]);

$head = '
<!DOCTYPE html>
<html>
<head>
<title>PDF</title>
<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap demo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</head>
<style>
body {
    font-family: sarabun;
    font-size: 20px;
}
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  width: 50%;
}

</style>
</head>
<body>

<img src="./image/logo-pea.jpg" alt="ddd" width="150" height="120" />
<br>
<br>
<table>
  <tr>
    <th>จาก</th>
    <th>ถึง</th>
  </tr>
  <tr>
    <td>เลขที่</td>
    <td>วันที่</td>
  </tr>
  <tr>
    <td>เรื่อง รายงานผลการตรวจสอบและเฉลี่ยหน่วย ราย </td>
    <td></td>
  </tr>
  <tr>
    <td>เรียน  ผจก</td>
    <td></td>
  </tr>
</table>




</body>
</html>
';
$mpdf->WriteHTML($head);
$mpdf->defaultfooterline = 0;
$mpdf->SetFooter('<div style="text-align: left;font-size:18px;">มต.ทม.๕/๑ ป.๕๘</div>');
$mpdf->SetTitle('แบบฟอร์มการตรวจสอบมิเตอร์ ชนิด 1 เฟส 2 สาย');
// $mpdf->SetWatermarkText('PMAC');
$mpdf->showWatermarkText = true;
$mpdf->Output('singlephase.pdf', 'I');
$mpdf->Output();
?>
