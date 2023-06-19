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
      'mode' => 'utf-8',
      'format' => 'A4',
      'margin_left' => 25,
      'margin_right' => 20,
      'margin_top' => 15,
      'margin_bottom' => 15,
      'margin_header' => 0,
      'margin_footer' => 0,
]);
$id = $_GET['id'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://172.21.1.60:442/datadetail/id?id=' . $id . '',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$data = json_decode($response, true);
//echo "peacode: " . $data[0]['peacode'] . "<br>";

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
  border: 0px solid #dddddd;
  text-align: left;
  padding: 1px;
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
    <td colspan="2">เรื่อง&nbsp;&nbsp;&nbsp;&nbsp;รายงานผลการตรวจสอบและเฉลี่ยหน่วย ราย '.$data[0]['name_customer'].' ('.$data[0]['ca_no'].')</td>
  </tr>
  <tr>
    <td>เรียน&nbsp;&nbsp;&nbsp;&nbsp;ผจก</td>
    <td></td>
  </tr>
  <tr>
  <td></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;พบช.ตรวจสอบหน่วย ได้ดำเนินการตรวจสอบหน่วยการใช้ไฟฟ้า ราย '.$data[0]['name_customer'].' ('.$data[0]['ca_no'].') ในรอบบิล '.$data[0]['billing_Cycle'].' '.$data[0]['year'].' พบว่ามิเตอร์ชำรุดเนื่องจาก '.$data[0]['cause'].' 
    ทั้งนี้ เพื่อเป็นการลดหน่วยสูญเสียให้แก่ กฟภ. และลดการปรับปรุงค่าไฟฟ้าย้อนหลัง
    พบช.ตรวจสอบหน่วย ได้ดำเนินการเฉลี่ยหน่วยโดยใช้วิธีเฉลี่ยหน่วยจาก '.$data[0]['in_cause'].'   ในรอบบิล '.$data[0]['billing_Cycle'].' '.$data[0]['year'].' แล้วจำนวน '.$data[0]['sum_to_sap_final'].' หน่วย จึงขอรายงานผลการดำเนินการ โดยมีรายละเอียดตามเอกสารแนบ จำนวน ......... ฉบับ </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาโปรดทราบ และแจ้งให้ส่วนที่เกี่ยวข้องดำเนินการต่อไป</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(..................................................)</td>
  </tr>
  <tr>
  <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;......................................................................</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="2">ที่&nbsp;&nbsp;&nbsp;&nbsp;ฉ.2 ......................................</td>
</tr>
<tr>
<td colspan="2">เรียน&nbsp;&nbsp;&nbsp;&nbsp;........................................</td>
</tr>
<tr>
<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ทราบ และแจ้งให้ส่วนที่เกี่ยวข้องดำเนินการต่อไป</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ</td>
</tr>
<tr>
<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(..................................................)</td>
</tr>
<tr>
<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;......................................................................</td>
</tr>
</table>




</body>
</html>
';
$mpdf->WriteHTML($head);

$mpdf->defaultfooterline = 0;
// $mpdf->SetFooter('<div style="text-align: left;font-size:18px;">Report By Everest</div>');
$mpdf->SetTitle('ข้อมูลการเฉลี่ยหน่วย '.$data[0]['name_customer'].' '.$data[0]['billing_Cycle'].' '.$data[0]['year'].'');
// $mpdf->SetWatermarkText('PMAC');
$mpdf->showWatermarkText = true;
$mpdf->Output('ข้อมูลการเฉลี่ยหน่วย '.$data[0]['name_customer'].' '.$data[0]['billing_Cycle'].' '.$data[0]['year'].'.pdf', 'I');
$mpdf->Output();
?>
