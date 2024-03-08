<?php


$response_separator = ":";
$response_value_separator = ",";
$response_chunk_separator = ";";

$baseurl = "http://mysms.exposys.in/api/transactional_template_list_api.php";

$myuid = htmlspecialchars("u6442");
$token = htmlspecialchars("8DnWEI");
$url = $baseurl."?myuid=$myuid&mytoken=$token";

//$response = call_url($url);

	$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL,$url);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			//curl_exec($curl);
			
			$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
$templates=array();

if (strpos($response,'ERROR:') !== false)
{
$arr = explode($response_separator, $response);
echo $arr[0].$response_separator.$arr[1];
exit;
}
else
{
$arr = explode($response_chunk_separator, $response);
for($i=0; $i<=sizeof($arr); $i++)
{
if(array_key_exists($i,$arr))
{
$string = $arr[$i];
$arr_two = explode($response_separator, $string);
if(trim($arr_two[0])=='SUCCESS')
{

array_push($templates,$arr_two[1]);

}
}
}
}
			
print_r($templates);


			
			
?>