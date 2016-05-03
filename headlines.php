<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<style>

	  body {
	  	width: 800px;
      margin: 0 auto;
    }
    div { padding:4px; }
		body,div,td { font-family:arial; }
		a:link { color:silver; }
		a:visited { color:silver; }
		a:hover { color:blue; }
	</style>
</head>
<body>

<div id="wrapper">

<?php

/************************************************************************

		GET HEADLINES FROM REDDIT
		Notes:

		<meta property="og:description" content="">

		() Get Headlines from Reddit
		() Get Title/Descriptions - <meta property="og:description" content="">
		() Merge and compile into data file with most recent on top

***************************************************************************/

$headline_urlsource_name='';
$headline_urlsource_type='';
$checked_new='';
$checked_top='';

// echo $_POST["headline_urlsource_type"];
if ((empty($_POST))|| ($_POST["headline_urlsource_type"]=="Select a feed")){
	$headline_urlsource_type="top";
	$checked_top='checked';
}
// echo 'Top check: '  . $checked_top;
// echo $_POST["headline_urlsource_type"];
if (!empty($_POST)){
	$headline_urlsource_name=$_POST["headline_urlsource_name"];
	if(isset($_POST["headline_urlsource_type"])){
		$headline_urlsource_type=$_POST["headline_urlsource_type"];
		if ($headline_urlsource_type=="headline_urlsource_new"){
			$checked_new='checked';
			$checked_top='';
		} else {
			$checked_new='';
			$checked_top='checked';
		}
	// echo $_POST["headline_urlsource_type"];
	} else {
	}
	if(!isset($_POST["headline_urlsource_type"])){
		$headline_urlsource_type=$_POST["headline_urlsource_type"];
		$checked_new='';
		$checked_top='checked';
	} else {
	}
	//echo $_POST["headline_urlsource_name"];

} else {

	$checked_new='';
	$checked_top='checked';
}
// echo $headline_urlsource_type; // catch posting errors
// echo 'New check: ' . $checked_new . 'Top check: ' . $checked_top;

$arr = array(
	'Reddit: Futurology' => 'https://pay.reddit.com/r/Futurology/',
	'Reddit: Science' => 'https://pay.reddit.com/r/science/',
	'Reddit: Technology' => 'https://pay.reddit.com/r/technology/',
	'Reddit: Gadgets' => 'https://pay.reddit.com/r/gadgets/',
	'Reddit: Bitcoin' => 'https://pay.reddit.com/r/Bitcoin',
	'Reddit: Rad Decentralization' => 'https://pay.reddit.com/r/Rad_Decentralization',
	'Reddit: Shut Up and Take My Money' => 'https://pay.reddit.com/r/shutupandtakemymoney',
	'Reddit: Futurology' => 'https://pay.reddit.com/r/Futurology/'
);

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
	<select name="headline_urlsource_name" id="headline_urlsource_name" onchange="this.form.submit()">
		<option>Select a feed</option>
	  <?php foreach($arr as $key => $value) {
	  	if($key==$headline_urlsource_name){ $selected='selected'; } else { $selected=''; } // set selected option
	  ?>
	    <option value="<?php echo $key ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
	  <?php }?>
	</select>

	<input type="radio" <?php echo $checked_new; ?> value="headline_urlsource_new" name="headline_urlsource_type" id="headline_urlsource_new"> New only
	<input type="radio" <?php echo $checked_top; ?> value="headline_urlsource_top" name="headline_urlsource_type" id="headline_urlsource_top"> Top only
</form>

<?php

if (!empty($_POST)){

	if ($checked_new=="checked"){
		$headline_urlsource_name_json = $arr[$headline_urlsource_name] . 'new/.json';
		$type_category=' - New';
	} else {
		$headline_urlsource_name_json = $arr[$headline_urlsource_name] . '.json';
		$type_category=' - Top';
	}
	echo '<h2>' . $headline_urlsource_name . $type_category . '</h2>';
	echo $headline_urlsource_name_json;
} else {
	$headline_urlsource_name_json='';
	exit;

}

$data_json=file_get_contents($headline_urlsource_name_json);

//echo $data_json;

$json = json_decode($data_json);

// echo $json->data->children[0]->kind;

$string_output = '<table>';
$string_output .= '<tr><td width=600>';

//print_r($json->data->children);

$x=1;

$count_articles = count($json->data->children);

foreach($json->data->children as $key=>$value){

	//echo $json->data->children[$key]->data->domain . '<br>';

	$post_domain=$json->data->children[$key]->data->domain;
	$post_score=$json->data->children[$key]->data->score;
	$post_num_comments=$json->data->children[$key]->data->num_comments;
	$post_url=$json->data->children[$key]->data->url;
	$post_title=$json->data->children[$key]->data->title;

	$pos_domain = strpos($post_domain,'self.');

	if ($pos_domain === false) {

	} else {
		continue; // skip the Reddit "Self" posts
	}


	$string_output .= '<div>';
	$string_output .= '<h3 style="display:inline;">' . $post_title . '</h3> |';
	$string_output .= '<a href="' . $post_url . '" target="_blank">' . $post_url . '</a><br>';
	$string_output .= '</div>';


$x++;

}

$string_output .= '</td></tr>';
$string_output .= '</table>';

echo $string_output;

//

/* Testing
print_r($json);
foreach($json as $obj){
   var_dump($obj);
}
*/

?>

</div>

</body>
</html>
