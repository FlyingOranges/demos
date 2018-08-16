<?php
/*
* cli模式或者内置server打印调试信息，而不在浏览器输出
* param fixed $data    参数可以是除了对象以外的所有数据类型，比如：字符串，数组，jason等
*/
function console($data){
     $stdout = fopen('php://stdout', 'w');
     fwrite($stdout,json_encode($data)."\n");   //为了打印出来的格式更加清晰，把所有数据都格式化成Json字符串
     fclose($stdout);
}
