<?php 
  $Call = new Enginess();
?>

<?php 
$action ='';
    if (!empty($_GET['action'])) {
      $action = $_GET['action'];
    }
    
    
    switch ($action) {   

    case 'home':
      
    require_once 'View/home.php';
    break;

    case 'model':
        $modelID = rand(02,99);
        $model_ID = m0 . $modelID;
        
        if (isset($_POST['train'])) {
        $name = $_POST['model_name'];
        //$dataset_name = $_POST['dataset_name'];
        $date_trained = date("Y-m-d");
        $type = $_POST['type'];
        $filePath = $_POST['file_path'];
       
        // Handle File Upload (Dataset)
    if (isset($_FILES["dataset_name"]) && $_FILES["dataset_name"]["error"] == 0) {
        $datasetName = basename($_FILES["dataset_name"]["name"]);
        $datasetPath = "View/assets/dataset/" . $datasetName; // Folder to store files

        // Move uploaded file to server folder
        if (!move_uploaded_file($_FILES["dataset_name"]["tmp_name"], $datasetPath)) {
            die("Error uploading dataset.");
        }
        $Call->train_model($model_ID, $name,$datasetName,$date_trained,$type,$filePath);
    } else {
        die("Please upload a dataset.");
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
    die("Model ID not provided.");
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
    die("Model ID not provided.");
    }
    require_once 'View/view_single_model.php';
    break;
    
    
    case 'test':
           if (isset($_POST['test_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $keystrokeInput = $_POST['keystroke_input'];
    $keystrokeData = json_decode($_POST['keystroke_data'], true);
    
    $Call->test_login($username, $password);
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
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT); //Encrypt password
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
    require_once 'View/performance.php';
    break;

  default:
    require_once "View/home.php";
    break;

    }
?>
