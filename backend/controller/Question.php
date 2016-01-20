<?php 

$url = "../index.php?mod=question&act=list";

require_once "../model/Question.php";

$model = new Question;

$question_id = (int) $_POST['question_id'];

$content = $_POST['content'];

$answer = $_POST['answer'];

if(trim($content)!='' && trim($answer) ){

if($question_id > 0) {	

	$model->updateQuestion($question_id,$content,$answer);

	header('location:'.$url);

}else{

	$model->insertQuestion($content,$answer);

	header('location:'.$url);

}
}else{
	header('location:'.$url);	
}



?>