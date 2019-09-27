<?php

//echo $command = "C:\xampp\mysql\bin\mysqldump.exe"; // mysqldump.exe on Windows
//include_once $_SERVER['DOCUMENT_ROOT'] . "/CalpeSystem/globalPHP.php";
$db_host = "localhost";
$db_name = "grupocal_calpe";
$db_username = "grupocal_root";
$db_password = "compaq12";
//
ob_start();
system("C:/xampp/mysql/bin/mysqldump.exe -h $db_host -u $db_username -p$db_password $db_name");
$dump = ob_get_contents();
ob_end_clean();

////// send dump file to the output
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
//header('Content-Type: text/vcard; charset=utf-8');

//header('Content-Disposition: attachment; filename=' . basename($db_name . "_" . date("Y-m-d") . ".sql"));
header('Content-Disposition: attachment; filename=' . basename($db_name . "_" . date("Y-m-d_H-i-s") . ".sql"));
flush();
echo $dump;
exit();


//$zipname = 'grupocalpe.zip';
//$zip = new ZipArchive;
//$zip->open($zipname, ZipArchive::CREATE);
//if ($handle = opendir('.')) {
//    while (false !== ($entry = readdir($handle))) {
//        //if ($entry != "." && $entry != "..") {
//            $zip->addFile($entry);
//            
//        //}
//    }
//    closedir($handle);
//}
//
//$zip->close();
//
//
////$files = array('readme.txt', 'test.html', 'image.gif');
////$zipname = 'file.zip';
////$zip = new ZipArchive;
////$zip->open($zipname, ZipArchive::CREATE);
////foreach ($files as $file) {
////    $zip->addFile($file);
////}
////$zip->close();
//
//
//header('Content-Type: application/zip');
//header('Content-disposition: attachment; filename=' . $zipname);
//header('Content-Length: ' . filesize($zipname));
//readfile($zipname);



//$server_file = "CCC.txt"; //system("C:/xampp/mysql/bin/mysqldump.exe -h $db_host -u $db_username -p$db_password $db_name > theBackUp.sql");
//// define some variables
//$local_file = $db_name . "_" . date("Y-m-d_H-i-s") . ".sql";
////$server_file = 'server.zip';
//
//
//$ftp_server = "192.168.0.2";
//$ftpUserName = "falcon";
//$ftpPass = "Fe7943";
//
//// set up basic connection
//$conn_id = ftp_connect($ftp_server);
//$login_Result = ftp_login($conn_id, $ftpUserName, $ftpPass);
//// ftp_pasv($conn_id, true);
//if ((!$conn_id) || (!$login_Result)) {
//    echo "FTP connection has failed!";
//    echo "Attempted to connect to $ftp_server for user $ftpUserName";
//    exit;
//} else {
//    echo "Connected to $ftp_server, for user $ftpUserName";
//}
//
//
//
//if (file_exists("C:/xampp/htdocs")) {
//    echo "The file exists!";
//}
//
////
////
////// try to download $server_file and save to $local_file
//if (ftp_get($conn_id,$local_file,$server_file, FTP_ASCII)) {
//    echo "Successfully written to $local_file\n";
//} else {
//    echo "There was a problem\n";
//}
//// close the connection
//ftp_close($conn_id);
