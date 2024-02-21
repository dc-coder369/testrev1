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
    $dataToUpdate = [ 'lock_upload' => $reqeust['status'] ];
    $condition = 'date="'.$reqeust['date'].'"';
    $stations = $database->select('tab_user_details', "*", ['account_type' => 'station'], "AND", 'multiple');
        $insert = [ 
            'date' => $reqeust['date'], 
            'lock_status' => ($reqeust['status'] == 1) ? 'Locked' : 'Unlocked', 
            'timestamp' =>date('Y-m-d H:i:s')
        ]; 
        $database->insert('tab_logs_lockunlock' , $insert ); 

        if ($database->update($table, $dataToUpdate, $condition)) { 
            foreach($stations as $station)
            {
                $updating_all = [  
                    $station['user_code'] => ($reqeust['status'] == 1) ? '1' : '0',  
                ]; 
                $database->update($table, $updating_all, $condition);
            }
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

if($type == 'update_lock_status_station')
{
    $table = "tab_status_lockupload";
    $condition = 'date="'.$reqeust['date'].'"';
   
        $insert = [  
            $reqeust['user_code'] => ($reqeust['status'] == 1) ? '1' : '0',  
        ];  
        
        if ($database->update($table, $insert, $condition)) {
            $stations = $database->select('tab_user_details', "*", ['account_type' => 'station'], "AND", 'multiple');
            $filelog = $database->select('tab_status_lockupload', "*", ['date' => $reqeust['date']], "AND", 'single');
            $zeroCount = 0;
            $oneCount = 0;
            foreach($stations as $station)
            {
                $userCode = $station['user_code'];
                $codeStatus = $filelog[$userCode] ?? null; // Get the status of the user code from the filelog
                
                // Increment the count based on the status
                if ($codeStatus == 0) {
                    $zeroCount++;
                } elseif ($codeStatus == 1) {
                    $oneCount++;
                }
            }
            if ($zeroCount > 0 || $oneCount === 0) {
                $lock_upload = [  
                    'lock_upload' =>'0',  
                ];  
                $database->update($table, $lock_upload, $condition);
            } elseif ($zeroCount === 0 || $oneCount > 0) {
                $lock_upload = [  
                    'lock_upload' =>'1' , 
                ];  
                $database->update($table, $lock_upload, $condition);
            }  
          
            $response = json_encode(['success' => true , 'lock_upload' => $reqeust['status'] ,$zeroCount,$oneCount]);
        }else{
            $response = json_encode(['success' => false]);
        } 
    echo $response;die; 
}





if ($type == 'logout') {
    $_SESSION = array();
    header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/login.php");
}


if ($type == 'download-all-latest') {
    $recordDate = $_POST['hiddenrecordDate2'];
    $date = new DateTime($recordDate);
    // Prepare the SQL statement with placeholders
    $sql = "
        SELECT filename, id 
        FROM tab_logs_fileupload 
        WHERE log_type = 'upload' 
        AND record_date = ?
        AND (file_type, upload_by, record_date, upload_time) IN ( 
            SELECT file_type, upload_by, record_date, MAX(upload_time) AS latest_uploaded_at 
            FROM tab_logs_fileupload 
            WHERE log_type = 'upload' 
            GROUP BY file_type, upload_by, record_date
        )
    ";

    // Execute the query with the parameter binding
    $result = $database->querydownload($sql, [$recordDate]);

    // Initialize the data array
    $data = [];

    // Fetch the results
    while ($row = $database->fetchAssoc($result)) {
    $data[] = $row;
    }

    $latestFilename = '';
    $latestIds = [];
    foreach ($result as $file) { 
         $latestIds[] = $file['id']; 
    } 
    if(!empty($latestIds))
    {
        $response = DownloadSelectedFiles($database,$recordDate, 'scdata/', $recordDate . '.zip', 'scdata/' . $recordDate . '.zip', $latestIds);

        echo "Latest Filename: $latestFilename\n";
        echo "Latest IDs: " . implode(', ', $latestIds) . "\n";die; 
    
        echo "<pre>"; print_r( $result); die; 
    }
    else
    {
        $response = 'error';
        $message ="There is no file to download";  
    }
  

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

if($type == 'create log for single file')
{

    $recordDate = $reqeust['record_date'] ?? null;
    $path = $reqeust['path'] ?? null;
    $sc_name=$reqeust['Sc_Name'] ?? null;
    $file_type = $reqeust['file_type'] ?? null;
    $station_name = $reqeust['station_name'] ?? null;
    $fileName = $reqeust['fileName'] ?? null;
    $insert = [ 
        'record_date' => $recordDate, 
        'log_type' => 'download',
        'station_name' =>$station_name,
        'filename' => $fileName,
        'Sc_Name' =>   $sc_name,
    ]; 
    $result = $database->insert('tab_logs_fileupload' , $insert ); 
    if($result)
    {
        $response = json_encode(['success' => true , 'filepath' => $path ]);
    }
    else
    {
        $response = json_encode(['success' => false]);
    }
    echo $response;die; 
   
}

if($type == 'update-privilege'){
    $httpRefer = basename($_SERVER['HTTP_REFERER']);  
    $fileNamephp = parse_url($httpRefer, PHP_URL_PATH);
    $selectedUserId = isset($_POST['select_s1']) ? $_POST['select_s1'] : '';
    $selectedUsers = isset($_POST['checkbox_array']) ? $_POST['checkbox_array'] : [];
    $chk = implode(",", $selectedUsers);
    $condition = 'username="'.$selectedUserId.'"';
    if ($database->update('tab_user_details', ['stations_allotted' => $chk ],  $condition )) { 
        setSuccessMessage("Privilege updated successfully");  
    }else{
        setErrorMessage("Error");  
    }
    header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) ."/".$fileNamephp);exit(); 

}




if ($type == 'add-new-user') { 
   
    $httpRefer = basename($_SERVER['HTTP_REFERER']);  
    $fileNamephp = parse_url($httpRefer, PHP_URL_PATH);

    $station_type = $_POST['station_type'];
    $station_name = $_POST['station_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_code = $_POST['user_code'];
    
    $result = $database->select('tab_user_details', "id", ['username' => $username], "AND", 'single');
    if(!empty($result)){
        setSuccessMessage("Error: Username already exists. Please choose a different username.");  
    }else{
        if (empty($_POST["station_name"]) && empty($_POST["username"]) && empty($_POST["password"])) {
            setSuccessMessage("Fill all fields");  
        }else{

            $insert = [
                'username' => $username,
                'user_code' => $user_code,
                'password' => $password,
                'stationname' => $station_name,
                'account_type' => $station_type, 
            ];
            $result = $database->insert('tab_user_details' , $insert ); 
            if ($result) {
                setSuccessMessage("User created successfully");
            } else {
                setErrorMessage("Error"); 
            } 
        } 
            
    }
 
    header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) ."/".$fileNamephp);exit(); 

}


if ($type == 'update-password') { 
   
    $httpRefer = basename($_SERVER['HTTP_REFERER']);  
    $fileNamephp = parse_url($httpRefer, PHP_URL_PATH);
    $condition = 'id="'.$_POST['user_id'].'"';
    if ($database->update('tab_user_details', ['password' => $_POST['new_password'] ],  $condition )) { 
        setSuccessMessage("Password has been successfully updated");  
    }else{
        setErrorMessage("There is some error"); 
    }
    header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) ."/".$fileNamephp);exit(); 

}

// Function to convert full name of file category to short code of file category
function generateCategoryCodeFromCategoryName($categoryName) {
    // Define an associative array mapping full names to short codes
    $categoryMappings = array(
        "Daily Earning Sheet" => "DER",
        "SBI POS Transaction" => "SPOS",
        "Paytm POS Transaction" => "PPOS",
        "URC Images" => "URCI",
        "URC" => "URC",
        "Manual Collection" => "MC",
        "Penalty" => "PR",
        "Refund Memo" => "RM",
        "Outstanding" => "OS",
        "Forfeit Format" => "FOF",
        "1st Periodical" => "1stP",
        "2nd Periodical" => "2ndP",
        "3rd Periodical" => "3rdP",
        "Balance Sheet" => "BS",
        "Ref. Def. CSC / Def. CST" => "DR-CSC-CST"
    );

    // Check if the category name exists in the mappings array
    if (array_key_exists($categoryName, $categoryMappings)) {
        // Return the corresponding short code
        return $categoryMappings[$categoryName];
    } else {
        // If category name not found, return an error message or handle it as needed
        return "OTH";
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
    $uploaded_for = $_SESSION['user_code'];
    $fileType = generateCategoryCodeFromCategoryName($_POST['fileType']) ; 
    $httpRefer = basename($_SERVER['HTTP_REFERER']);  
    $fileNamephp = parse_url($httpRefer, PHP_URL_PATH);

 
     
    $result = $database->select('tab_status_lockupload', "*", ['date' => $recordDate], "AND", 'single');
    // echo "<pre>"; print_r($_SERVER); die; 
    if ($_SESSION['user_code'] != 'revenuecell' && ($result['lock_upload'] == 1 || $result['lock_upload'] == '1' )){ 
        setErrorMessage("You are not allowed to upload Images or Csv."); 
        header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) . "/scdata-list.php?date=".$recordDate."&i=".$result['lock_upload']);
          
    } else {
          
      
        if (empty($_FILES['files']['tmp_name'][0])) {
 
            setErrorMessage("You must select a file to upload."); 
            header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) ."/".$fileNamephp. "?date=".$recordDate."&i=".$result['lock_upload']);exit(); 
        } 
 
        if (isset($_FILES['files']['error'][0]) && $_FILES['files']['error'][0] == 0) {

           

            $folderType = $fileType.'/'. $folderArr[0].'/'.$folderArr[1].'/'.$folderArr[2]; 
            // $folderType = "Data-scdata-Earning-Data-". $recordDate; 
            handleFileUpload($database,$_FILES['files'], $folderType, $recordDate, $station_name, $sc_name, $remark , $user_id, $fileType ,$uploaded_for );

            header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) ."/".$fileNamephp. "?date=".$recordDate."&i=".$result['lock_upload']);exit(); 
            
             
    
        }
        // Check if files are uploaded for "URC"
        /* if (isset($_FILES['files2']['error'][0]) && $_FILES['files2']['error'][0] == 0) {
            $folderType = $fileType.'/'. $folderArr[0].'/'.$folderArr[1].'/'.$folderArr[2]; 
            // $folderType = "Data-scdata-URC-" . $recordDate; 
            handleFileUpload($database,$_FILES['files2'], $folderType, $recordDate, $station_name, $sc_name, $remark ,  $user_id , $fileType);
            header("Location: " . dirname(dirname($_SERVER['PHP_SELF'])) ."/".$fileNamephp. "?date=".$recordDate."&i=".$result['lock_upload']);exit(); 
           
        } */
      
    }
 
    
    
}

function getUniqueFileName($targetDir ,$fileName) {
    $fileInfo = pathinfo($fileName);
    $baseName = $fileInfo['filename'];
    $extension = $fileInfo['extension'];

    $counter = 1;
    $newFileName = $baseName . '.' . $extension;

    // echo $targetDir.$newFileName; die; 
    if(!file_exists($targetDir.$newFileName))
    { 
        $newFileName = $baseName . '_' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '.' . $extension;
    }
    while (file_exists($targetDir.$newFileName)) {
        $counter++;
        $newFileName = $baseName . '_' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '.' . $extension;
    }

    return $newFileName;
}

 
function setSession($user , $message)
{
    $_SESSION['user_id'] = $user['id']; // Replace 'id' with the actual column name
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_code'] = $user['user_code'];
    $_SESSION['account_type'] = $user['account_type'];
    $_SESSION['stationname'] = $user['stationname'];
    $_SESSION['page_access'] =  AccessToPageAsPerLogin($user['account_type']); 
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




function handleFileUpload($database, $fileArray, $folderType, $recordDate, $station_name, $sc_name, $remark ,  $user_id, $fileType,$uploaded_for)
{
    // Create the date-wise folder
    $baseFolder = 'scdata';
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

            // $uniqueId = date('YMd', strtotime($recordDate));
            $uniqueId = date('d-m-y', strtotime($recordDate));
           
            $prefixedFileName = $_SESSION['user_code'] . "_" . $fileType . "_" . $uniqueId . "." . $fileExtension;

            $newFileName = getUniqueFileName($targetDir,$prefixedFileName);
 
            $targetFile = $targetDir . handleDuplicateFile($newFileName, $targetDir);  
           
            if (move_uploaded_file($fileArray['tmp_name'][$i], $targetFile)) {
               
                $filesize = round($_FILES['files']['size'][$i] / 1024 / 1024, 2);

                $insert = [
                    'Sc_Name' => $sc_name,
                    'station_name' => $station_name,
                    'filename' => $newFileName,
                    'original_filename' => $originalFileName,
                    'size' => $filesize,
                    'record_date' => $recordDate,
                    'Remark' => $remark,
                    'upload_by' =>  $user_id,
                    'folder_name' => $folderType,
                    'log_type' => 'upload',
                    'file_type' => $fileType,
                    'uploaded_for'=>$uploaded_for ?? NULL,
                    'hostname' => gethostname()
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
    $counter = 1;

   
    // Check if the file already exists
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
                setErrorMessage("Cannot open the zip file."); 
              
                return "error";
            }

            // Add all files and subdirectories within the specified date folder
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($baseFolderPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            if (iterator_count($files) === 0) {
                setErrorMessage("No files found in the specified folder.");
                return "error";  
                // throw new Exception('No files found in the specified folder.');
            }

            foreach ($files as $name => $file) {
                // Skip directories (they will be added automatically with their contents)
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($baseFolderPath) + 1);

                    if ($zip->addFile($filePath, $relativePath) !== true) {
                        setErrorMessage("Error adding file to the zip archive.");
                        return "error"; 
                        // throw new Exception('Error adding file to the zip archive.');
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
            setErrorMessage($e->getMessage());
            return "error"; 
            
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
            setErrorMessage('Cannot open the zip file.');
            // throw new Exception('Cannot open the zip file.');
            return "error";
        }

        foreach ($selectedIds as $id) {
            // Retrieve file path based on ID
            $fileInfo = $database->select('tab_logs_fileupload', 'filename, folder_name', ['id' => $id], 'AND', 'single');

            if (!$fileInfo) {
                setErrorMessage('File not found for ID: ');
                return 'error';
                // throw new Exception('File not found for ID: ' . $id);
            }

            $filePath = $baseFolderPath . $fileInfo['folder_name'] . '/' . $fileInfo['filename'];

            //Folder name contains multiple folders. So taking just main category folder in the zip.
            $tempfolderParts = explode('/', $fileInfo['folder_name']); 

            $relativePath = $tempfolderParts[0] . '/' . $fileInfo['filename'];

            if ($zip->addFile($filePath, $relativePath) !== true) {
                setErrorMessage('Error adding file to the zip archive.');
                return 'error';

                // throw new Exception('Error adding file to the zip archive.');
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

        setErrorMessage($e->getMessage());
        return 'error';
   
    }
}


function AccessToPageAsPerLogin($type){
    $pageArr = []; 

    if($type == 'admin'){
        $pageArr = ['view-reports-uploaded-by-revenuecell.php','view-reports-uploaded-by-revenuecell.php','download-log.php','revenuecell-list.php','admin.php' ,'file-logs.php' ,'add-new-user.php' , 'change-password.php' , 'priviledges.php','dashboard.php' ,'logs_lock_unlock.php']; 
    }else if($type == 'revenuecell'){
        $pageArr = ['lock_station.php','upload-data-for-higher-authority.php','revenuecell-list.php','file-logs.php','dashboard.php' ,'logs_status.php']; 
    }else if($type == 'SI' || $type == 'si'){
        $pageArr = ['si-list.php','dashboard.php']; 
    }else if($type == 'station'){
        $pageArr = ['upload-periodicals-balance-sheets.php','scdata-list.php','dashboard.php']; 
    } 
    return $pageArr; 
}




// close connection when operation is done
//  session_destroy(); 
// $database->closeConnection();

?>
