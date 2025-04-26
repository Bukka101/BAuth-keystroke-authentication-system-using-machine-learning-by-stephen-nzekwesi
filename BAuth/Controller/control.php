<?php 
  $Call = new Enginess();
?>

<?php 
$response = null;
$notice = null;

function getUserHomeDirectory() {
    // On Unix-like systems (Linux, macOS)
    if (PHP_OS_FAMILY === 'Linux' || PHP_OS_FAMILY === 'Darwin') {
        return getenv('HOME');
    }

    // On Windows
    if (PHP_OS_FAMILY === 'Windows') {
        return getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }

    // Fallback
    return null;
}

$action ='';
    if (!empty($_GET['action'])) {
      $action = $_GET['action'];
    }
    
    
    switch ($action) {   

    case 'home':
      
    require_once 'View/home.php';
    break;

    case 'model':
      //  $modelID = rand(02,99);
      //  $model_ID = m0 . $modelID;
        
        // Generate unique model_ID
    do {
    $modelID = str_pad(rand(2, 99), 2, '0', STR_PAD_LEFT); // Ensure 2 digits
    $model_ID = 'm0' . $modelID;
        } while ($Call->modelIDExists($model_ID));

        
        if (isset($_POST['train'])) {
        $name = $_POST['model_name'];
        $dataset = $_FILES['dataset_name'];
        $date_trained = date("Y-m-d h:i:s");
        $type = $_POST['type'];
        $datasetName = $dataset["name"];
       
   
    // Send to Flask API
            $cfile = new CURLFile($dataset['tmp_name'], 'text/csv', $datasetName);
            $postData = [
                'model_name' => $name,
                'model_type' => $type,
                'dataset' => $cfile
            ];

            $ch = curl_init("http://127.0.0.1:5000/train");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            curl_close($ch);
            
             // Decode Flask response
        $responseData = json_decode($response, true);

        // Only save to database if Flask responded with success
        if ($httpCode == 200 || isset($responseData['status']) || $responseData['status'] == 'success') {

        $Call->train_model($model_ID, $name,$datasetName,$date_trained,$type);
        echo "<script>alert('Model trained and saved successfully'); </script>";
    }
    else {
        echo "<script>alert('Error training model.'); </script>";
        echo "<pre>Flask Response:\n" . print_r($responseData, true) . "</pre>";
      }
    }
    require_once 'View/model.php';
    break;
  
    case 'edit_model':
       if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];
    $info = $Call->get_user('model', 'model_id', $model_id);
        }
        else {
    die("User ID not provided.");
    }
    
    if (isset($_POST['update_model'])) {
        $model_id = $_POST['model_id'];
        $name = $_POST['model_name'];
        $type = $_POST["modelType"]; 
        $datasetName = $_POST['file_path'];
        
        // Fetch old model name
    $oldInfo = $Call->get_user('model', 'model_id', $_GET['model_id']);
    $old_model_name = $oldInfo['name'];

    $homeDir = getUserHomeDirectory(); // This returns something like C:\Users\John or /home/john
    
    // Define local model directory
    $folderPath = $homeDir . '/BAuth/model_files/'; // Update if different  // Change this to your model save location

    // Build full paths for model and scaler files
    $oldModelFile = $folderPath . $old_model_name . '.joblib';
    $oldScalerFile = $folderPath . $old_model_name . '_scaler.joblib';
    $newModelFile = $folderPath . $name . '.joblib';
    $newScalerFile = $folderPath . $name . '_scaler.joblib';

    // Attempt to rename both files
    $modelRenamed = true;
    $scalerRenamed = true;

    if (file_exists($oldModelFile)) {
        $modelRenamed = rename($oldModelFile, $newModelFile);
    }

    if (file_exists($oldScalerFile)) {
        $scalerRenamed = rename($oldScalerFile, $newScalerFile);
    }

    if ($modelRenamed && $scalerRenamed) {

        $Call->update_model($name, $type, $datasetName, $model_id);
    } else {
        echo "<p>Failed to rename one or both files. Please check if they exist and have write permission.</p>";
    } 

    }
    require_once 'View/edit_model.php';
    break;
    
    case 'view_single_model':
         if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];
    $info = $Call->get_user('model', 'model_id', $model_id);
        }
        else {
    die("User ID not provided.");
    }
    require_once 'View/view_single_model.php';
    break;
    
    
    case 'test':
        if (isset($_POST['test_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = 'Active';
    $jsonText = $_POST['json_data'];
    $date_trained = date("Y-m-d h:i:s");
    
    $jsonText_stripped = trim($jsonText);
   // $jsonText_stripped = preg_replace('/^\s*{\s*/', '', $jsonText_stripped);
  //  $jsonText_stripped = preg_replace('/\s*}\s*$/', '', $jsonText_stripped);
  //  $final_json = $jsonText_stripped;
    
   // echo "<pre>Raw JSON:\n" . htmlspecialchars($jsonText_stripped) . "</pre>";
    
   
     $authType = $Call->get_user_auth_type($username, $password);

    if (!$authType) {
        echo "<script>alert('Invalid username or password.'); </script>";
    } elseif (strpos($authType, 'ks') === false) {
        echo "<script>alert('Login successful... User only has username-password authentication enabled!'); </script>";
        
    }else {
        $modelName = $Call->get_active_model_name($status);
        $modelID = $Call->get_active_model_id($status);

        if (!$modelName) {
            echo "<script>alert('Keystroke authentication active, but no active model found.'); </script>";
        } 
        else {
           
            // Try decoding as-is first
    $data_array = json_decode($jsonText_stripped, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p style='color:red;'>JSON Decode Error: " . json_last_error_msg() . "</p>";
    $data_array = null;
    }
    if ($data_array !== null) {
        
        // Send keystroke JSON to Flask
    $jsonPayload = json_encode([
        "model_name" => $modelName,
        "data" => $data_array
            ]);
            
           // echo "<pre>Payload Sent:\n" . htmlspecialchars($jsonPayload) . "</pre>";
            //      $payload = json_encode($jsonData);
                echo "<script>alert('$jsonPayload'); </script>";
                $ch = curl_init('http://127.0.0.1:5000/predict');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
                $response = curl_exec($ch);
                curl_close($ch);
                
                $user_id = $Call->get_user_id($username, $password);
                
                $responseData = json_decode($response, true);
                $prediction = $responseData["prediction"] ?? "No prediction";
                $predictionResult = "Prediction: <strong>$prediction</strong>";

                $isGenuine = strtolower($prediction) === "genuine";
                $Call->logPrediction($modelID, $user_id, $date_trained, $isGenuine ? 1 : 0, 0, 0, !$isGenuine ? 1 : 0);
        } else {
            echo "<p style='color:red;'>Invalid JSON submitted!</p>";
        }
    
        
         //    $jsonData = [
         //       "model_name" => $modelName,
         //       "data" => json_decode($final_json, true)
        //    ];
                
         
            }
        }
}

    require_once 'View/test.php';
    break;
    
    case 'users':
    require_once 'View/users.php';
    break;
    
    case 'turn_active':
        if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];
    $Call->update_model_status($model_id, 'Active', 'Inactive');
        }
        else {
    die("Model ID not provided.");
    }
    require_once 'View/turn_active.php';
    break;
    
    case 'edit_user':
       if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $info = $Call->get_user('users', 'user_id', $user_id);
        }
        else {
    die("User ID not provided.");
    }
    
    if (isset($_POST['update'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $password = $_POST["password"]; //Encrypt password
        $auth_type = $_POST['auth_type'];
        if($username != "" || $password != ""){
            $Call->update_user($username, $password, $auth_type, $user_id);
        }
    }
    
    if(isset($_POST['back'])){
       echo '<script>window.location.href="index.php?action=users"</script>';
    }
    require_once 'View/edit_user.php';
    break;
    
    case 'delete_user':
        if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $info = $Call->delete_user('users', 'user_id', $user_id);
        }
        else {
    die("User ID not provided.");
    }
    require_once 'View/delete_user.php';
    break;   
    
    case 'delete_model':
        if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];
    
    // Get model info
    $model = $Call->get_user('model', 'model_id', $model_id);
    $model_name = $model['name'];
    
    $homeDir = getUserHomeDirectory(); // This returns something like C:\Users\John or /home/john
    
    // Define local model directory
    $folderPath = $homeDir . '/BAuth/model_files/'; // Update if different

    // File paths
    $modelFile = $folderPath . $model_name . '.joblib';
    $scalerFile = $folderPath . $model_name . '_scaler.joblib';

    // Delete files if they exist
    if (file_exists($modelFile)) {
        unlink($modelFile);
    }

    if (file_exists($scalerFile)) {
        unlink($scalerFile);
    }
    
    $info = $Call->delete_user('model', 'model_id', $model_id);
     if ($deleted) {
         echo "<script>alert('Model deleted successfully.'); </script>";
        exit;
    } else {
         echo "<script>alert('Failed to delete model from database.'); </script>";
    }
    }
        else {
    die("Model ID not provided.");
    }
    require_once 'View/delete_model.php';
    break; 
    
    case 'authentication':
        
    require_once 'View/authentication.php';
    break;
    
    case 'assign_auth':
       
    if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $info = $Call->assign_auth('Password + ks',  $user_id);
        }
 
    require_once 'View/assign_auth.php';
    break;

    case 'viewModel':
        
    require_once 'View/viewModel.php';
    break;

    case 'performance':
    $chartData = $Call->getModelPerformanceData();
   

    require_once 'View/performance.php';
    break;

  default:
    require_once "View/home.php";
    break;

    }
?>
