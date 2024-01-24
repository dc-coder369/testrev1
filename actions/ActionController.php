<?php

require_once 'db.php';
session_start();
$reqeust = $_REQUEST;
$type = $reqeust['type'];
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($type == 'login') {
    $username = $reqeust['username'];
    $password =  $reqeust['password'];
    $conditions = ['username' => $username, 'password' => $password];

    $result = $database->select('tab_user_details', "*", $conditions, "AND", 'single');
    // echo $_SERVER['PHP_SELF']; die; 
    if (!empty($result)) { 
      //  resetSessionMessages();
        setSession($result , 'Login Successful'); 
        header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/dashboard.php");
        exit();
    } else {  
        // resetSessionMessages();
        setErrorMessage("Invaild Username and Password. Please check try again");
        header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/login.php");
        exit();
    }
}
if ($type == 'local_unlock_status') {
    $result = $database->select('tab_status_lockupload', "*", ['date' => $reqeust['date']], "AND", 'single');
    if ($result) { 
        $response = json_encode($result);
        header('Content-Type: application/json');
        echo $response;die; 
    } else {
        // Handle the case where no data is found
        echo json_encode(['error' => 'No data found for the specified date']); die; 
    }
}

if ($type == 'update_lock_status') {

    $table = "tab_status_lockupload";
    $dataToUpdate = [  'lock_upload' => $reqeust['status'] ];
    $condition = 'date="'.$reqeust['date'].'"';

    $insert = [ 
        'date' => $reqeust['date'],
        'lock_status' => ($reqeust['status'] == 1) ? 'Locked' : 'Unlocked', 
        'timestamp' =>date('Y-m-d H:i:s')
    ];  
    $database->insert('tab_logs_lockunlock' , $insert ); 
    
    if ($database->update($table, $dataToUpdate, $condition)) { 
        $response = json_encode(['success' => true , 'lock_upload' => $reqeust['status'] ]);
    }else{
        $response = json_encode(['success' => false]);
    }
    echo $response;die; 


    // $result = $database->select('tab_status_lockupload', "*", ['date' => $reqeust['date']], "AND", 'single');
    // if ($result) { 
    //     $response = json_encode($result);
    //     header('Content-Type: application/json');
    //     echo $response;die; 
    // } else {
    //     // Handle the case where no data is found
    //     echo json_encode(['error' => 'No data found for the specified date']); die; 
    // }
}





if ($type == 'logout') {
    $_SESSION = array();
    header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/login.php");
}

if ($type == 'download-all-files') {
    $recordDate = $_POST['hiddenrecordDate2'];
    $date = new DateTime($recordDate);
    $formattedDate = $date->format('Y-M-d');
    $folderArr = explode('-',$formattedDate); 

    $ids = (isset($_POST['ids'])) ? $_POST['ids'] : [];
    // echo "<pre>"; print_r( $ids); die; 
    // $baseFolderPath = 'scdata/' .$folderArr[0].'/'.$folderArr[1].'/'.$folderArr[2];
    $baseFolderPath = 'scdata/';
    if(!empty($ids)){ 
         $response = DownloadSelectedFiles($database,$recordDate, 'scdata/', $recordDate . '.zip', 'scdata/' . $recordDate . '.zip', $ids);
    }else{
        $response = 'error';
        $message ="There is no file to download";  
         
    } 
  


     
   if($response == 'error'){
        setErrorMessage($message); 
        header("Location:".$_SERVER['HTTP_REFERER']);
   }else{
    $insert = [ 
        'record_date' => $recordDate, 
        'log_type' => 'download',
        'station_name' =>'revenuecell',
        'filename' => 'download-all',
        'station_name' => 'revenuecell',
    ]; 
    $result = $database->insert('tab_logs_fileupload' , $insert ); 
   }
   

}

if ($type == 'upload-files') {

    $recordDate = $_POST['recordDate']; 
    $date = new DateTime($recordDate);
    $formattedDate = $date->format('Y-M-d');

    $folderArr = explode('-',$formattedDate); 



    $sc_name = isset($_POST['sc_name']) ? $_POST['sc_name'] : '';
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    // $station_name_si = isset($_POST['station_name_si']) ? $_POST['station_name_si'] : ''; 
    $station_name = $_SESSION['stationname']; 
    $fileType = str_replace(" ","_",$_POST['fileType']) ; 
    
     
    $result = $database->select('tab_status_lockupload', "*", ['date' => $recordDate], "AND", 'single');
    // echo "<pre>"; print_r($_SERVER); die; 
    if ($result['lock_upload'] == 1 || $result['lock_upload'] == '1' ){ 
        setErrorMessage("You are not allowed to upload Images or Csv."); 
        header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/scdata-list.php?date=".$recordDate."&i=".$result['lock_upload']);
          
    } else {
          
        if (empty($_FILES['files']['tmp_name'][0])  && empty($_FILES['files2']['tmp_name'][0])  ) {
            
            setErrorMessage("You must Select One file from Earning Data Or URC."); 
            header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/scdata-list.php?date=".$recordDate."&i=".$result['lock_upload']);exit(); 
        } 
 
        if (isset($_FILES['files']['error'][0]) && $_FILES['files']['error'][0] == 0) {

            $folderType = $fileType.'/'. $folderArr[0].'/'.$folderArr[1].'/'.$folderArr[2]; 
            // $folderType = "Data-scdata-Earning-Data-". $recordDate; 
            handleFileUpload($database,$_FILES['files'], $folderType, $recordDate, $station_name, $sc_name, $remark , $user_id, $fileType );
            
            header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/scdata-list.php?date=".$recordDate."&i=".$result['lock_upload']);
    
        }
        // Check if files are uploaded for "URC"
        if (isset($_FILES['files2']['error'][0]) && $_FILES['files2']['error'][0] == 0) {
            $folderType = $fileType.'/'. $folderArr[0].'/'.$folderArr[1].'/'.$folderArr[2]; 
            // $folderType = "Data-scdata-URC-" . $recordDate; 
            handleFileUpload($database,$_FILES['files2'], $folderType, $recordDate, $station_name, $sc_name, $remark ,  $user_id , $fileType);
            header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/scdata-list.php?date=".$recordDate."&i=".$result['lock_upload']);
        }
      
    }
 
    
    
}

 
function setSession($user , $message)
{
    $_SESSION['user_id'] = $user['id']; // Replace 'id' with the actual column name
    $_SESSION['username'] = $user['username'];
    $_SESSION['account_type'] = $user['account_type'];
    $_SESSION['stationname'] = $user['stationname'];
    
    $_SESSION['success'] = $message;
    session_commit();
}


function setSuccessMessage($message)
{
    unset($_SESSION['error']);
    $_SESSION['success'] = $message;
    session_commit();
}

function setErrorMessage($message)
{
    unset($_SESSION['success']);
    $_SESSION['error'] = $message;
    session_commit();
}

function resetSessionMessages()
{
    unset($_SESSION['success']);
    unset($_SESSION['error']); 
}




function handleFileUpload($database, $fileArray, $folderType, $recordDate, $station_name, $sc_name, $remark ,  $user_id, $fileType )
{
    // Create the date-wise folder
    $baseFolder = 'scdata/';
    $folderPath = createFolder($baseFolder,$folderType); 

    // Handle multiple file uploads
    if (!empty($fileArray['name'][0]) && is_array($fileArray['name'])) {
        $numFiles = count($fileArray['name']);

        for ($i = 0; $i < $numFiles; $i++) {
            $targetDir = $folderPath . '/';

            $originalFileName = basename($fileArray['name'][$i]);
            // $prefixedFileName = $station_name . "_" . $originalFileName;

            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $fileInfo = pathinfo($originalFileName);
            $filenameWithoutExtension = $fileInfo['filename'];

            $uniqueId = uniqid();
            $prefixedFileName = $station_name."_".$filenameWithoutExtension ."_". $uniqueId . '.' . $fileExtension;


            $targetFile = $targetDir . handleDuplicateFile($prefixedFileName, $targetDir);  
            if (move_uploaded_file($fileArray['tmp_name'][$i], $targetFile)) {
               
                $filesize = round($_FILES['files']['size'][$i] / 1024 / 1024, 2);

                $insert = [
                    'Sc_Name' => $sc_name,
                    'station_name' => $station_name,
                    'filename' => $prefixedFileName,
                    'size' => $filesize,
                    'record_date' => $recordDate,
                    'Remark' => $remark,
                    'upload_by' =>  $user_id,
                    'folder_name' => $folderType,
                    'log_type' => 'upload',
                    'file_type' => $fileType
                ];

 

                $result = $database->insert('tab_logs_fileupload' , $insert ); 
                 

                if ($result) {
                    setSuccessMessage("File uploaded successfully");
                    // echo "Log Generated Successfully.";

                } else {
                    setErrorMessage("Error Generating Log."); 
                    // echo "Error Generating Log.";
                }


            } else {
                setErrorMessage("Error uploading file "); 
               // echo "Error uploading file .<br>";
            }
        }


    } else {
        setErrorMessage("No files were uploaded."); 
         
    }
}

function handleDuplicateFile($prefixedFileName, $targetDir)
{
    $targetFile = $targetDir . $prefixedFileName;

    // Check if the file already exists
    $counter = 1;
    while (file_exists($targetFile)) {
        // File already exists, add a number to the filename
        $prefixedFileName = pathinfo($prefixedFileName, PATHINFO_FILENAME) . "_$counter." . pathinfo($prefixedFileName, PATHINFO_EXTENSION);
        $targetFile = $targetDir . $prefixedFileName;
        $counter++;
    }

    return $prefixedFileName;
}

function createFolder($baseFolder, $date, $additionalFolder = null)
{
    $folderPath = $baseFolder . '/' . $date;

    // If an additional folder is specified, append it to the path
    if ($additionalFolder !== null) {
        $folderPath .= '/' . $additionalFolder;
    }

    // Check if the folder doesn't exist, then create it
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    return $folderPath;
}

function DownloadAllFiles( $recordDate ,  $baseFolderPath, $zipFileName , $zipFilePath){
       

        try {
            // Check if the base folder exists
            if (!is_dir($baseFolderPath)) {
                setErrorMessage("Base folder not found. "); 
                return "error";
            }

            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE) !== true) {
                throw new Exception('Cannot open the zip file.');
                return "error";
            }

            // Add all files and subdirectories within the specified date folder
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($baseFolderPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            if (iterator_count($files) === 0) {
                throw new Exception('No files found in the specified folder.');
            }

            foreach ($files as $name => $file) {
                // Skip directories (they will be added automatically with their contents)
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($baseFolderPath) + 1);

                    if ($zip->addFile($filePath, $relativePath) !== true) {
                        throw new Exception('Error adding file to the zip archive.');
                    }
                }
            }

            $zip->close();

            // Download the zip file
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $zipFileName);
            header('Content-Length: ' . filesize($zipFilePath));
            readfile($zipFilePath);

            // Clean up: Remove the created zip file
            unlink($zipFilePath);
            return "success"; 
            // Exit to prevent further output
            exit();
        } catch (Exception $e) {
            // Handle exceptions
            echo 'Error: ' . $e->getMessage();
            // You may want to redirect the user or perform other actions here
            exit();
        }
}

function DownloadSelectedFiles($database,$recordDate, $baseFolderPath, $zipFileName, $zipFilePath, $selectedIds)
{
    try {
        // Check if the base folder exists
        if (!is_dir($baseFolderPath)) {
            setErrorMessage("Base folder not found.");
            return "error";
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== true) {
            throw new Exception('Cannot open the zip file.');
            return "error";
        }

        foreach ($selectedIds as $id) {
            // Retrieve file path based on ID
            $fileInfo = $database->select('tab_logs_fileupload', 'filename, folder_name', ['id' => $id], 'AND', 'single');

            if (!$fileInfo) {
                throw new Exception('File not found for ID: ' . $id);
            }

            $filePath = $baseFolderPath . $fileInfo['folder_name'] . '/' . $fileInfo['filename'];
            $relativePath = $recordDate . '/' . $fileInfo['folder_name'] . '/' . $fileInfo['filename'];

            if ($zip->addFile($filePath, $relativePath) !== true) {
                throw new Exception('Error adding file to the zip archive.');
            }
        }

        $zip->close();

        // Download the zip file
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zipFileName);
        header('Content-Length: ' . filesize($zipFilePath));
        readfile($zipFilePath);

        // Clean up: Remove the created zip file
        unlink($zipFilePath);

        return "success";
    } catch (Exception $e) {
        // Handle exceptions
        echo 'Error: ' . $e->getMessage();
        // You may want to redirect the user or perform other actions here
        exit();
    }
}




// close connection when operation is done
//  session_destroy(); 
// $database->closeConnection();

?>
