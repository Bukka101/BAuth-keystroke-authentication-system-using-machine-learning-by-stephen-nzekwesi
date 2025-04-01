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


function train_model($name,$dataset_name,$date_trained,$type,$path){
 		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
			$name=mysqli_escape_string($conn,htmlentities(trim($name)));
			$dataset_name=mysqli_escape_string($conn,htmlentities(trim($dataset_name)));
			$date_trained=mysqli_escape_string($conn,htmlentities(trim($date_trained)));
			$type=mysqli_escape_string($conn,htmlentities(trim($type)));
			$path=mysqli_escape_string($conn,htmlentities(trim($path)));
			
			
			$sql='INSERT INTO model(name,dataset_name,date_trained,type,path)VALUES(?,?,?,?,?)';
								$query = $conn->prepare($sql);

									$query->bind_param('sssss',$name,$dataset_name,$date_trained,$type,$path);
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
    
    $sql = "SELECT model_id, name, type, date_trained FROM model ORDER BY model_id DESC";
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
                        <td>
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
                            <a href='edit_user.php?action={$row['user_id']}'>Assign Auth</a> | 
                            <a href='?action=edit_user&&user_id={$row['user_id']}'>Edit</a> | 
                            <a href='?action=delete_user&&user_id={$row['user_id']}' onclick='return confirm(\"Are you sure you want to delete this model?\")'>Delete</a>
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


function delete_user($userID){
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->DB);
    
    $sql = "DELETE FROM users WHERE user_id = ?";
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

     



}













?>
