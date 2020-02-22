<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/trafalgar/content/images/'; // Relative to the root

$verifyToken = md5('unique_salt' . time());
$prefix = filter_input(INPUT_POST, 'prefix');

if (!empty($_FILES) && !empty($prefix)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
    
    // Validate the file type
    $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    //New file name
    $filename = $prefix.'_'.date('Y_m_d').'.'.$fileParts['extension'];
    $targetFile = rtrim($targetPath,'/') . '/' . $filename;
    

    if (in_array($fileParts['extension'],$fileTypes)) {
            move_uploaded_file($tempFile,$targetFile);
            echo $filename;
    } else {
            echo 'Invalid file type.';
    }
}
?>