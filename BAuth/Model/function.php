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


function train_model($model_id,$name,$dataset_name,$date_trained,$type,$path){
 		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
 		    $model_id=mysqli_escape_string($conn,htmlentities(trim($model_id)));
			$name=mysqli_escape_string($conn,htmlentities(trim($name)));
			$dataset_name=mysqli_escape_string($conn,htmlentities(trim($dataset_name)));
			$date_trained=mysqli_escape_string($conn,htmlentities(trim($date_trained)));
			$type=mysqli_escape_string($conn,htmlentities(trim($type)));
			$path=mysqli_escape_string($conn,htmlentities(trim($path)));
			
			
			$sql='INSERT INTO model(model_id,name,dataset_name,date_trained,type,path)VALUES(?,?,?,?,?,?)';
								$query = $conn->prepare($sql);

									$query->bind_param('ssssss',$model_id,$name,$dataset_name,$date_trained,$type,$path);
														if ($query->execute()) {
        echo "<script>alert('Model Trained Successfully!'); window.location.href='index.php?action=model';</script>";
    } else {
        echo "Error: " . $query->error;
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

	}																					}

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


// Fetch users from database
function fetch_users(){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "SELECT user_id, username, password, auth_type FROM users ORDER BY user_id DESC";
    $query = $conn->prepare($sql);
    $query->execute();
						$result =$query->get_result();
    if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['user_id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['password']}</td>
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
        echo "<script>alert('Keystroke Auth assigned successfully!'); window.location.href='index.php?action=users';</script>";
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


}



?>
