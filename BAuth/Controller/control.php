<?php 
  $Call = new Enginess();
?>

<?php 
$response = null;
$notice = null;

function getUserHomeDirectory() {
    // Check if PHP_OS_FAMILY is defined
    $osFamily = defined('PHP_OS_FAMILY') ? PHP_OS_FAMILY : php_uname('s');

    if (stripos($osFamily, 'Windows') !== false) {
        // Windows system
        $homeDrive = getenv('HOMEDRIVE');
        $homePath = getenv('HOMEPATH');

        if ($homeDrive && $homePath) {
            return $homeDrive . $homePath;
        }

        // Try USERPROFILE if HOMEDRIVE/HOMEPATH not available
        $userProfile = getenv('USERPROFILE');
        if ($userProfile) {
            return $userProfile;
        }
    } else {
        // Linux/Mac
        $home = getenv('HOME');
        if ($home) {
            return $home;
        }
    }

    // Still nothing
    return false;
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
        
                // Check if the request was successful
                if ($httpCode == 200 || (isset($responseData['status']) && $responseData['status'] == 'success')) {
                    // Save model details in the database
                    $Call->train_model($model_ID, $name, $datasetName, $date_trained, $type);
                    echo "<script>alert('Model trained and saved successfully'); </script>";
                } else {
                    // If training failed, show an error message
                    echo "<script>alert('Error training model.'); </script>";
                    echo "<pre>Flask Response:\n" . print_r($responseData, true) . "</pre>";
                }
            }
        
            // Include the view for the model page
            require_once 'View/model.php';
            break;
            
  
        case 'edit_model':
            if (isset($_GET['model_id'])) {
                $model_id = $_GET['model_id'];
                $info = $Call->get_user('model', 'model_id', $model_id);
            } else {
                die("Model ID not provided.");
            }
        
            if (isset($_POST['update_model'])) {
                $model_id = $_POST['model_id'];
                $new_name = trim($_POST['model_name']);
                $type = $_POST['modelType'];
                $datasetName = trim($_POST['file_path']);
        
                // Fetch old model information
                $oldInfo = $Call->get_user('model', 'model_id', $model_id);
                $old_model_name = $oldInfo['name'];
        
                // Get user's home directory
                $homeDir = getUserHomeDirectory();
        
                if ($homeDir) {
                    // Define local model files directory
                    $folderPath = rtrim($homeDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'BAuth' . DIRECTORY_SEPARATOR . 'model_files' . DIRECTORY_SEPARATOR;
        
                    // Old file paths
                    $oldModelFile = $folderPath . $old_model_name . '.joblib';
                    $oldScalerFile = $folderPath . $old_model_name . '_scaler.joblib';
        
                    // New file paths
                    $newModelFile = $folderPath . $new_name . '.joblib';
                    $newScalerFile = $folderPath . $new_name . '_scaler.joblib';
        
                    $modelRenamed = false;
                    $scalerRenamed = false;
        
                    // Rename the model file if it exists
                    if (file_exists($oldModelFile)) {
                        $modelRenamed = rename($oldModelFile, $newModelFile);
                    }
        
                    // Rename the scaler file if it exists
                    if (file_exists($oldScalerFile)) {
                        $scalerRenamed = rename($oldScalerFile, $newScalerFile);
                    }
        
                    if ($modelRenamed && $scalerRenamed) {
                        // Update model information in database
                        $Call->update_model($new_name, $type, $datasetName, $model_id);
        
                        echo "<script>alert('Model updated successfully!'); window.location.href='?action=model';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Failed to rename files. Please check if the files exist and have correct permissions'); </script>";
                    }
                } else {
                    echo "<p style='color:red;'>Could not determine the user home directory.</p>";
                }
            }
        
            require_once 'View/edit_model.php';
            break;
            
    
        case 'view_single_model':
            if (isset($_GET['model_id'])) {
                $model_id = $_GET['model_id'];
                $info = $Call->get_user('model', 'model_id', $model_id);
            } else {
                die("Model ID not provided.");
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
                $authType = $Call->get_user_auth_type($username, $password);
        
                if (!$authType) {
                    echo "<script>alert('Invalid username or password.'); </script>";
                } elseif (strpos($authType, 'ks') === false) {
                    echo "<script>alert('Login successful... User only has username-password authentication enabled!'); </script>";
                } else {
                    $modelName = $Call->get_active_model_name($status);
                    $modelID = $Call->get_active_model_id($status);
        
                    if (!$modelName) {
                        echo "<script>alert('Keystroke authentication active, but no active model found.'); </script>";
                    } else {
                        // Try decoding as-is first
                        $data_array = json_decode($jsonText_stripped, true);
        
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            echo "<p style='color:red;'>JSON Decode Error: " . json_last_error_msg() . "</p>";
                            $data_array = null;
                        }
        
                        if ($data_array !== null) {
                            // Send keystroke JSON to Flask
                            $data_array['model_name'] = $modelName;
                            $jsonPayload = json_encode($data_array);
                            
                            $ch = curl_init('http://127.0.0.1:5000/predict');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
                            $response = curl_exec($ch);
                            curl_close($ch);
                            
                            $user_id = $Call->get_user_id($username, $password);
                            $responseData = json_decode($response, true);
                            $prediction = $responseData["Prediction"] ?? "No prediction";
                            $predictionResult = "Prediction: <strong>$prediction</strong>";
                            
                            $predictedUserId = $prediction; // From your API prediction
        
                            // Fetch user information
                            $predictedUser = $Call->get_username($predictedUserId);
        
                            // Save test outcome into session
                            $_SESSION['performance_output'] = [
                                'actual_username' => $username,
                                'actual_user_id' => $user_id,
                                'predicted_user_id' => $predictedUserId,
                                'model_id' => $modelID
                            ];
        
                            // Redirect to the performance page
                            echo '<script>window.location.href="index.php?action=test_outcome"</script>';
                            exit;
                        } else {
                            echo "<p style='color:red;'>Invalid JSON submitted!</p>";
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
            } else {
                die("Model ID not provided.");
            }
            require_once 'View/turn_active.php';
            break;
            
    
        case 'edit_user':
            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
                $info = $Call->get_user('users', 'user_id', $user_id);
            } else {
                die("User ID not provided.");
            }
            
            if (isset($_POST['update'])) {
                $user_id = $_POST['user_id'];
                $username = $_POST['username'];
                $password = $_POST["password"]; // Encrypt password
                $auth_type = $_POST['auth_type'];
                
                if ($username != "" || $password != "") {
                    $Call->update_user($username, $password, $auth_type, $user_id);
                }
            }
            
            if (isset($_POST['back'])) {
                echo '<script>window.location.href="index.php?action=users"</script>';
            }
            
            require_once 'View/edit_user.php';
            break;
            
    
        case 'delete_user':
            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
                $deleted = $Call->delete_user('users', 'user_id', $user_id);
                
                echo "<script>alert('User deleted successfully.');window.location.href='index.php?action=users'; </script>";
                exit;
            } else {
                die("User ID not provided.");
            }
            require_once 'View/delete_user.php';
            break;
            
    
        case 'delete_model':
            if (isset($_GET['model_id'])) {
                $model_id = $_GET['model_id'];
                
                // Get model information
                $model = $Call->get_user('model', 'model_id', $model_id);
                if (!$model) {
                    echo "<script>alert('Model not found.'); window.location.href='index.php?action=viewModel';</script>";
                    exit;
                }
        
                $model_name = $model['name'];
                
                // Get the user's home directory
                $homeDir = getUserHomeDirectory();
                if (!$homeDir) {
                    echo "<script>alert('Failed to determine user home directory.'); window.location.href='index.php?action=viewModel';</script>";
                    exit;
                }
        
                // Define local model directory
                $folderPath = rtrim($homeDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'BAuth' . DIRECTORY_SEPARATOR . 'model_files' . DIRECTORY_SEPARATOR;
        
                // File paths for model and scaler
                $modelFile = $folderPath . $model_name . '.joblib';
                $scalerFile = $folderPath . $model_name . '_scaler.joblib';
        
                // Delete model and scaler files from disk first
                $deleteSuccess = false;
                
                // Delete model file if it exists
                if (file_exists($modelFile)) {
                    if (unlink($modelFile)) {
                        $deleteSuccess = true;
                    } else {
                        echo "<script>alert('Failed to delete model file from disk.');</script>";
                    }
                }
        
                // Delete scaler file if it exists
                if (file_exists($scalerFile)) {
                    if (unlink($scalerFile)) {
                        $deleteSuccess = true;
                    } else {
                        echo "<script>alert('Failed to delete scaler file from disk.');</script>";
                    }
                }
        
                // If the files were successfully deleted, proceed to remove the model from the database
                if ($deleteSuccess) {
                    // Delete model from the database
                    $deleted = $Call->delete_user('model', 'model_id', $model_id);
                    // Return success message and redirect
                    echo "<script>alert('Model deleted successfully.'); window.location.href='index.php?action=viewModel';</script>";
                } else {
                    // If deletion from disk failed, do not delete the model from the database
                    echo "<script>alert('Model deletion failed. Either model files do not exist or you do not have the required permission to delete files.');</script>";
                }
            } else {
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
                $info = $Call->assign_auth('Password + ks', $user_id);
            }
        
            require_once 'View/assign_auth.php';
            break;
            
    
        case 'test_outcome':
            // Handle saving to database if a button is clicked
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['performance'])) {
                $performanceType = $_POST['performance'];
                $modelID = $_POST['model_id'];
                $actualUserId = $_POST['actual_user_id'];
        
                $Call->save_performance([
                    'model_id' => $modelID,
                    'user_id' => $actualUserId,
                    'performance' => $performanceType
                ]);
        
                unset($_SESSION['performance_output']); // Clear after saving
        
                // echo "<script>alert('Performance recorded successfully!'); window.location.href='?action=test';</script>";
                exit;
            }
            require_once 'View/test_outcome.php';
            break;
            

        case 'viewModel':
            require_once 'View/viewModel.php';
            break;
            
    
        case 'model_performance':
            if (isset($_GET['model_id'])) {
                $modelId = $_GET['model_id'];
        
                // Fetch performance counts from the database
                $performance = $Call->get_model_performance_counts($modelId);
                
                // Get model id from GET or default to active model
                $selectedModelId = isset($_GET['model_id']) ? $_GET['model_id'] : $Call->get_active_model_id('Active');
        
                $performance = $Call->get_model_performance_counts($selectedModelId);
                $modelList = $Call->get_all_models(); // New: Fetch all models for dropdown
                $activeModelInfo = $Call->get_model_info($selectedModelId);
        
                if ($modelId) {
                    $performance = $Call->get_model_performance_counts($modelId);
                    $activeModelInfo = $Call->get_model_info($modelId); // to display model name/type if you want
                    
                    require_once 'View/performance.php';
                }
            } else {
                echo "<script>alert('No Model ID provided.'); window.location.href='?action=viewModel';</script>";
            }
            break;
            

        case 'performance':
            // Always get the active model
            $activeModelId = $Call->get_active_model_id('Active');
        
            // Get model id from GET or default to active model
            $selectedModelId = isset($_GET['model_id']) ? $_GET['model_id'] : $Call->get_active_model_id('Active');
        
            $performance = $Call->get_model_performance_counts($selectedModelId);
            $modelList = $Call->get_all_models(); // New: Fetch all models for dropdown
            $activeModelInfo = $Call->get_model_info($selectedModelId);
        
            if ($activeModelId) {
                $performance = $Call->get_model_performance_counts($activeModelId);
                $activeModelInfo = $Call->get_model_info($activeModelId); // to display model name/type if you want
                
                require_once 'View/performance.php';
            } else {
                echo "<script>alert('No active model found. Please activate a model first.'); window.location.href='control.php?action=viewModel';</script>";
            }
            break;
            

    default:
        require_once "View/home.php";
        break;

    }
?>
