<?php

include('database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$error     = '';
$message   = '';
$val_error = '';
$name      = '';
$prog_lang = '';

if(empty($form_data->person_name)) {
 	$error[] = 'Name is Required';
} else {
 	$name = $form_data->person_name;
}

if(empty($form_data->skill)) {
 	$error[] = 'Programming Language is Required';
} else {
 	foreach($form_data->skill as $language) {
  		$prog_lang .= $language . ', ';
 	}
 	$prog_lang = substr($prog_lang, 0, -2);
}

$data = [
	':name'                  => $name,
	':programming_languages' => $prog_lang
];

if(empty($error)) {
 	$query = "
 		INSERT INTO tbl_name 
 		(name, programming_languages) VALUES 
 		(:name, :programming_languages)
 	";

 	$statement = $connect->prepare($query);
 	if($statement->execute($data)) {
  		$message = 'Data Inserted';
 	}
} else {
 	$val_error = implode(", ", $error);
}

$output = array(
 	'error'   => $val_error,
 	'message' => $message
);

echo json_encode($output);