
<?php
$ds = DIRECTORY_SEPARATOR; 
  $id = $_GET['id'];
$storeFolder = '../upload/article-'.$id;  
 
if (!empty($_FILES)) {
    
   
    $tempFile = $_FILES['file']['tmp_name'];         
    $targetPath = $storeFolder . $ds; 
    $targetFile =  $targetPath. '/article-'.$id.'.jpg'; 
    move_uploaded_file($tempFile,$targetFile);
 
} else {      
    
    $result  = array();
    $files = scandir($storeFolder);               
    if ( false!==$files ) {
        foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {       
                $obj['name'] = $file;
                $obj['size'] = filesize($storeFolder.$ds.$file);
                $result[] = $obj;
            }
        }
    }
    header('Content-type: text/json');             
    header('Content-type: application/json');
    echo json_encode($result);
}



