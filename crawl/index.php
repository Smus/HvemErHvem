<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('simple_html_dom.php');
include_once('male-female.php');
$target_url = "http://194.150.111.137/phonelist/";
$html = new simple_html_dom();
$html->load_file($target_url);

function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb");
    $data = explode(',', $base64_string);
    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp);
    return $output_file;
}

$json_arr = array();

$html = substr($html, strpos($html, '<section>') + 9);
$html = substr($html, 0, strpos($html, '</section>'));

$arr = explode('<a href="', $html);
foreach ($arr as $k => $line) {
    if ($k == 0) continue;

    $phone = substr($line, 0, strpos($line, '"'));
    $phone = str_replace('tel:', '', $phone);
    $phone = trim($phone);

    $image = substr($line, strpos($line, '<img src="') + 10);
    $image = substr($image, 0, strpos($image, '"'));

    $name = substr($line, strpos($line, '<div class="employee-desc">') + 37);
    $name = substr($name, 0, strpos($name, '</div>'));
    $name = trim($name);
    $name = substr($name, 0, strpos($name, '<br'));

    base64_to_jpeg($image,'image/'.$k.'.jpg');

    $json_arr[$k - 1]['Image'] = 'image/'.$k.'.jpg';
    $json_arr[$k - 1]['Name'] = $name;
    $json_arr[$k - 1]['Phone'] = $phone;

    $fname = substr($name, 0, strpos($name, ' '));
    $json_arr[$k - 1]['Gender'] = findGender($fname);

}

$json = json_encode($json_arr);
//echo $json;
echo "Crawling done!";
file_put_contents('../json/employees.json', $json);

?>
