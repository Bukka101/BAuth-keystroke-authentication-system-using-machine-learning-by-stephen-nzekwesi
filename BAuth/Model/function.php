<?php


class Enginess{

	private $host = 'localhost';
	private $user = 'xpressm2_keystroke';
	private $password = '_keystroke!';
	private $DB ='xpressm2_keystroke';


	function test_conn(){
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
		if ($conn==true) {
			echo 'connected';
		}
}


function train_model($model_id,$name,$dataset_name,$date_trained,$type){
 		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
 		    $model_id=mysqli_escape_string($conn,htmlentities(trim($model_id)));
			$name=mysqli_escape_string($conn,htmlentities(trim($name)));
			$dataset_name=mysqli_escape_string($conn,htmlentities(trim($dataset_name)));
			$date_trained=mysqli_escape_string($conn,htmlentities(trim($date_trained)));
			$type=mysqli_escape_string($conn,htmlentities(trim($type)));
			
			
			$sql='INSERT INTO model(model_id,name,dataset_name,date_trained,type)VALUES(?,?,?,?,?)';
								$query = $conn->prepare($sql);

									$query->bind_param('sssss',$model_id,$name,$dataset_name,$date_trained,$type);
														if ($query->execute()) {
        echo "<script>alert('Model Trained Successfully!'); window.location.href='index.php?action=model';</script>";
    } else {
        echo "Error: " . $query->error;
    }
}

// create new user
function new_user($user_id,$username,$password,$auth_type){
 		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
			$user_id=mysqli_escape_string($conn,htmlentities(trim($user_id)));
			$username=mysqli_escape_string($conn,htmlentities(trim($username)));
			$password=mysqli_escape_string($conn,htmlentities(trim($password)));
			$auth_type=mysqli_escape_string($conn,htmlentities(trim($auth_type)));
		
			
			$sql='INSERT INTO users(user_id,username,password,auth_type)VALUES(?,?,?,?)';
								$query = $conn->prepare($sql);

									$query->bind_param('ssss',$user_id,$username,$password,$auth_type);
														if ($query->execute()) {
        echo "<script>alert('User added successfully!'); window.location.href='index.php?action=model';</script>";
    } else {
        echo "Error: " . $query->error;
    }

	}
	
    
function logPrediction($model_id, $user_id, $ts, $tp, $tn, $fp, $fn) {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "INSERT INTO model_performance (model_id, user_id, timestamp, true_positive, true_negative, false_positive, false_negative) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiii", $model_id, $user_id, $ts, $tp, $tn, $fp, $fn);
        if ($stmt->execute()) {
    echo "<script>alert('Model Performance saved'); </script>";
    $stmt->close();
        }
        else {
        echo "Error: " . $stmt->error;
    }
    
}

// Fetch models from database
function fetch_models(){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "SELECT model_id, name, type, date_trained, status FROM model ORDER BY model_id DESC";
    $query = $conn->prepare($sql);
    $query->execute();
						$result =$query->get_result();
    if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['model_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['date_trained']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <a href='?action=turn_active&&model_id={$row['model_id']}'>Turn Active</a> |
                            <a href='?action=view_single_model&&model_id={$row['model_id']}'>View</a> |
                            <a href='?action=edit_model&&model_id={$row['model_id']}'>Edit</a> | 
                            <a href='?action=delete_model&&model_id={$row['model_id']}' onclick='return confirm(\"Are you sure you want to delete this model?\")'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No models found.</td></tr>";
        }
}


// Function to check if model_ID exists
function modelIDExists($model_ID) {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
     
    $stmt = $conn->prepare("SELECT COUNT(*) FROM model WHERE model_id = ?");
    $stmt->bind_param("s", $model_ID);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}


// Fetch users from database
function fetch_users(){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "SELECT user_id, username, auth_type FROM users ORDER BY user_id DESC";
    $query = $conn->prepare($sql);
    $query->execute();
						$result =$query->get_result();
    if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['user_id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['auth_type']}</td>
                        <td>
                            <a href='?action=assign_auth&&user_id={$row['user_id']}'>Assign Auth</a> | 
                            <a href='?action=edit_user&&user_id={$row['user_id']}'>Edit</a> | 
                            <a href='?action=delete_user&&user_id={$row['user_id']}' onclick='return confirm(\"Are you sure you want to delete this model?\")'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
        }
}


function list_auth_type(){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "SELECT user_id, auth_type FROM users ORDER BY user_id DESC";
    $query = $conn->prepare($sql);
    $query->execute();
						$result =$query->get_result();
    if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['user_id']}</td>
                        
                        <td>{$row['auth_type']}</td>
                        
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
        }
}

function auth_keystroke(){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "SELECT user_id, auth_type FROM users ORDER BY user_id DESC";
    $query = $conn->prepare($sql);
    $query->execute();
						$result =$query->get_result();
    if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['user_id']}</td>
                        
                        <td>{$row['auth_type']}</td>
                        <td>
                            <a href='?action=assign_auth&&user_id={$row['user_id']}'>Assign Auth</a> 
                        </td>
                        
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
        }
}

function get_user($table, $field, $user_id){
    error_reporting(E_ALL);
ini_set('display_errors', 1);

    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "SELECT * FROM $table WHERE $field = '$user_id' ";
   $query = $conn->query($sql) or print(mysqli_error($conn));
    $row = mysqli_fetch_array($query);
					if ($query == true) {
						return $row;
							}else{
								return false;
									}
									$conn->close();
   
   
} 


function get_model_name($table, $field, $active){
    error_reporting(E_ALL);
ini_set('display_errors', 1);

    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "SELECT name FROM $table WHERE $field = '$active' ";
   $query = $conn->query($sql) or print(mysqli_error($conn));
    $row = mysqli_fetch_array($query);
					if ($query == true) {
						return $row;
							}else{
								return false;
									}
									$conn->close();
   
   
} 

function update_user($username, $password, $auth_type, $user_id){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
      $sql = "UPDATE users SET username = ?, password = ?, auth_type = ? WHERE user_id = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("ssss", $username, $password, $auth_type, $user_id);

    if ($query->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href='index.php?action=users';</script>";
    } else {
        echo "Error updating record: " . $query->error;
    }

    // Close Connection
    $query->close();
    $conn->close();
}

    // Update Model
function update_model($name, $type, $dataset_name, $model_id){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);

    $sql = "UPDATE model SET name = ?, type = ?, dataset_name = ? WHERE model_id = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("ssss", $name, $type, $dataset_name, $model_id);

    if ($query->execute()) {
        echo "<script>alert('Model updated successfully!'); window.location.href='index.php?action=viewModel';</script>";
    } else {
        echo "Error updating record: " . $query->error;
    }

    // Close Connection
    $query->close();
    $conn->close();
}

function assign_auth($auth_type, $user_id){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);

    $sql = "UPDATE users SET auth_type = ? WHERE user_id = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("ss", $auth_type, $user_id);

    if ($query->execute()) {
        echo "<script>alert('Keystroke Auth assigned successfully!'); window.location.href='index.php?action=assign_auth';</script>";
    } else {
        echo "Error updating record: " . $query->error;
    }

    // Close Connection
    $query->close();
    $conn->close();
}

   // Update Model
function update_model_status($model_id, $Active, $Inactive){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);

    $sql = "UPDATE model SET status = CASE WHEN model_id = ? THEN ? ELSE ? END"; 
    $query = $conn->prepare($sql);
    $query->bind_param("sss", $model_id, $Active, $Inactive);

    if ($query->execute()) {
        echo "<script>alert('Status updated successfully!'); window.location.href='index.php?action=viewModel';</script>";
    } else {
        echo "Error updating record: " . $query->error;
    }

    // Close Connection
    $query->close();
    $conn->close();
}


function delete_user($table, $field, $userID){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "DELETE FROM $table WHERE $field = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("s", $userID);

    if ($query->execute()) {
        echo "<script>alert('User deleted successfully!'); window.location.href='index.php?action=users';</script>";
    } else {
        echo "Error deleting record: " . $query->error;
    }

    // Close Connection
    $query->close();
    $conn->close();

}

function test_login($username, $password){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    // Step 1: Validate user credentials
$query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$query->bind_param("ss", $username, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if ($user['auth_type'] === 'Password + ks') {
        // Step 2: Simulate a basic behavior match
        // In real cases, you'd compare to trained model features
        $avgInterval = 0;
        $count = 0;

        foreach ($keystrokeData as $stroke) {
            if (isset($stroke['interval'])) {
                $avgInterval += $stroke['interval'];
                $count++;
            }
        }

        $avgInterval = ($count > 0) ? $avgInterval / $count : 0;

        // Simulate verification: accept if average interval is within a reasonable range
        if ($avgInterval > 50 && $avgInterval < 500) {
            echo "<script>alert('Login successful with Keystroke Authentication!'); </script>";
        } else {
            echo "<script>alert('Keystroke behavior does not match. Access Denied.'); </script>";
          
        }

    } else {
        echo "<script>alert('Login succesful with password only.'); </script>";
    }

} else {
    echo "<script>alert('Invalid credentials.'); </script>";
}
}
     

function test_auth_login($username, $password){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    // Step 1: Validate user credentials
$query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$query->bind_param("ss", $username, $password);
$query->execute();
$result = $query->get_result()->fetch_assoc();

}

function get_user_auth_type($username, $password) {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $stmt = $conn->prepare("SELECT auth_type FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($authType);
    $stmt->fetch();
    $stmt->close();
    return $authType;
}

function get_user_id($username, $password) {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
    return $user_id;
}

function get_active_model_name($status) {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $stmt = $conn->prepare("SELECT name FROM model WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $stmt->bind_result($modelName);
    $stmt->fetch();
    $stmt->close();
    return $modelName;
}

function get_active_model_id($status) {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $stmt = $conn->prepare("SELECT model_id FROM model WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $stmt->bind_result($modelID);
    $stmt->fetch();
    $stmt->close();
    return $modelID;
}

    // Fetch performance counts from a log table
function getPerformanceMetrics() {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
        $query = "SELECT result_type, COUNT(*) as count FROM auth_logs GROUP BY result_type";
        $result = $this->conn->query($query);

        $metrics = ['TP' => 0, 'TN' => 0, 'FP' => 0, 'FN' => 0];
        while ($row = $result->fetch_assoc()) {
            $type = strtoupper($row['result_type']);
            if (isset($metrics[$type])) {
                $metrics[$type] = $row['count'];
            }
        }

        return $metrics;
    }
    
   function getModelPerformanceData() {
       $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
       
    $sql = "SELECT 
                SUM(true_positive) AS tp, 
                SUM(true_negative) AS tn, 
                SUM(false_positive) AS fp, 
                SUM(false_negative) AS fn 
            FROM model_performance";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

}


function getUserCount() {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    $query = $conn->prepare("SELECT COUNT(*) FROM users");
    $query->execute();
    $query->bind_result($count);
    $query->fetch();
    $query->close();
    return $count;
    
}

function getModelCount() {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    $query = $conn->query("SELECT COUNT(*) FROM model");
    return $query->fetchColumn();
}

function getKeystrokeUserCount() {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    $query = $conn->query("SELECT COUNT(*) FROM users WHERE auth_type LIKE '%kPassword + ks%'");
    return $query->fetchColumn();
}

function getTodayLoginAttempts() {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    $today = date('Y-m-d');
    $query = $conn->prepare("SELECT COUNT(*) FROM model_performance WHERE DATE(timestamp) = ?");
    $query->execute([$today]);
    return $query->fetchColumn();
}



?>
