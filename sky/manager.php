<?php

if ($argc != 3 || !in_array($argv[1], ['add', 'remove'])) {
    exit('error input');
}

$action = $argv[1];
$params = $argv[2];

$input = explode('===', $params);
$in = $action . ': {"server_port":' . $input[0] . ', "password":"' . $input[1] .'"}';

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_connect($socket, '127.0.0.1', 55555);

if(!socket_write($socket, $in, strlen($in))) {
    var_dump("socket_write() failed: reason: " . socket_strerror($socket));
}else {
    var_dump("发送成功! 内容为:{$in}");
}

$out = socket_read($socket, 8192);

var_dump("回传成功! 内容为:{$out}");

socket_close($socket);
