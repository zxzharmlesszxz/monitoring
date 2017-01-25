<?php

function socketmail($server='localhost', $to, $from, $subject, $message) {
    $connect = fsockopen ($server, 25, $errno, $errstr, 30);
    sleep(10);
    fputs($connect, "HELO localhost\r\n");
    sleep(3);
    fputs($connect, "MAIL FROM: $from\n");
    sleep(5);
    fputs($connect, "RCPT TO: $to\n");
    sleep(5);
    fputs($connect, "DATA\r\n");
    sleep(1);
    fputs($connect, "Content-Type: text/plain; charset=iso-8859-1\n");
    fputs($connect, "To: $to\n");
    fputs($connect, "Subject: $subject\n");
    fputs($connect, "\n\n");
    fputs($connect, stripslashes($message)." \r\n");
    fputs($connect, ".\r\n");
    sleep(1);
    fputs($connect, "RSET\r\n");
}

socketmail('mail',
 'harmless@bc-gold.org.ua',
 "muchmoney@contra.net.ua",
 'Test PHP socketmail',
 'Text of Test message');
