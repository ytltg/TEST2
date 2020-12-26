<?php
       $mysqli = new mysqli('localhost', 'root','ytltg146','information_schema');
       if($mysqli->connect_errno){
	echo '[mysql 연결오류]';
	}
        else{
	echo'[mysql 연결 성공]';
	}
	mysqli_close($mysqli);
?>