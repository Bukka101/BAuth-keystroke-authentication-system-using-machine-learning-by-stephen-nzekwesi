<?php 
  $Call = new Enginess();
?>

<?php 
$response = null;
$notice = null;
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
        $date_trained = date("Y-m-d");
        $type = $_POST['type'];
        $filePath = $_POST['save_path'];
        $datasetName = $_FILES["dataset_name"]["name"];
       
   
    // Send to Flask API
            $cfile = new CURLFile($dataset['tmp_name'], 'text/csv', $datasetName);
            $postData = [
                'model_name' => $name,
                'model_type' => $type,
                'path' => $filePath,
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
        if ($httpCode == 200 && isset($responseData['status']) && $responseData['status'] == 'success') {

        $Call->train_model($model_ID, $name,$datasetName,$date_trained,$type,$filePath);
        echo "<p><strong>Model trained and saved successfully:</strong></p>";
    }
    else {
        echo "<p><strong>Error training model:</strong></p>";
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
        

        $Call->update_model($name, $type, $datasetName, $model_id);

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
   
     $authType = $Call->get_user_auth_type($username, $password);

    if (!$authType) {
        $notice = "Invalid username or password.";
    } elseif (strpos($authType, 'ks') === false) {
        echo "<script>alert('Login successful... User only has username-password authentication enabled!'); </script>";
        
    }else {
        $modelName = $Call->get_active_model_name($status);

        if (!$modelName) {
            echo "<script>alert('Keystroke authentication active, but no active model found.'); </script>";
           
        } else {
            // Build model_path
            $basePath = "/Users/Bukka/Courseworks/system/";
            $modelPath = $basePath . $modelName . ".joblib";
            
            // Merge JSON input
            $data = json_decode($jsonText, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo "<script>alert('Invalid JSON format.'); </script>";
                
            } else {
                $data['model_path'] = $modelPath;
               
                // Send to Flask
                $payload = json_encode($data);
                $ch = curl_init('http://127.0.0.1:5000/predict');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                $response = curl_exec($ch);
                curl_close($ch);
            }
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
    $info = $Call->delete_user('model', 'model_id', $model_id);
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
    //     $model = new PerformanceModel();
    //$metrics = $model->getPerformanceMetrics();

    require_once 'View/performance.php';
    break;

  default:
    require_once "View/home.php";
    break;

    }
?>
