<?php
namespace App\Models;

use App\Config\Database;

class User
{
    public $firstname;
    public $lastname;
    public $role;
    public $email;
    public $phone;
    public $userphoto;
    public $coverphoto;
    public $error;
    private $userstable = 'users';
    private $abouttable = 'userabouts';
    protected $connection;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }
    public function login($email, $pass, $type = 'writer')
    {
        $user_email = mysqli_real_escape_string($this->connection, $email);
        $user_password = mysqli_real_escape_string($this->connection, $pass);

        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        if (empty($user_email)) {
            return ['error' => 'Fill up Email field!'];
        }
        if (empty($user_password)) {
            return ['error' => 'Fill up Password field!'];
        }
        $stmt = $this->connection->prepare("SELECT user_id, first_name, email, pass, userphoto, status FROM {$this->userstable} WHERE email = ? AND userrole = ? LIMIT 1");
        $stmt->bind_param("ss", $user_email, $type);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($user_password, $row['pass'])) {
                if ($row['status'] == 1) {
                    return ['userid' => $row['user_id']];
                } else {
                    return ['error' => 'Please Contact to Admin !'];
                }

            } else {
                return ['error' => 'Incorrect Password'];
            }
        } else {
            return ['error' => 'User Not Found!'];
        }
    }
    public function signup($data, $type = 'user')
    {
        $pass = password_hash($data['pass'], PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("SELECT * FROM {$this->userstable} WHERE (email =? OR userip = ?)  LIMIT 1");
        $stmt->bind_param('ss', $data['email'], $data['ip']);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $_SESSION['error'][] = 'You are already Registered. Please Log In !';
            return redirect('writer');
        } else {
            // Insert new user record
            $insertStmt = $this->connection->prepare("INSERT INTO {$this->userstable} (user_id, first_name, last_name, email, phone, pass, userrole, userip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($insertStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->connection->error));
            }
            $insertStmt->bind_param('ssssssss', $data['userid'], $data['fname'], $data['lname'], $data['email'], $data['phone'], $pass, $type, $data['ip']);

            if ($insertStmt->execute()) {
                return [$data['userid'], $data['fname']];
            }
        }

    }
    public function tempRegister($data, $type = 'temp')
    {
        $authuser = $this->connection->prepare("SELECT first_name FROM {$this->userstable} WHERE (user_id = ? OR userip = ? OR  uuid = ?) AND pass IS NOT NULL LIMIT 1");
        $authuser->bind_param("sss", $data['user_id'], $data['ip'], $data['uuid']);
        $authuser->execute();
        $result = $authuser->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(['redirect' => 'login']);
            exit;
        }

        $findexisted = $this->connection->prepare("SELECT user_id, first_name FROM {$this->userstable} WHERE (user_id =? OR userip = ? OR  uuid = ?) AND pass IS NULL LIMIT 1");
        $findexisted->bind_param("sss", $data['user_id'], $data['ip'], $data['uuid']);
        $findexisted->execute();
        $result = $findexisted->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['user_id'];
        } else {
            $stmt = $this->connection->prepare("INSERT INTO {$this->userstable} (user_id, first_name, email, userrole, uuid, userip) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->connection->error));
            }
            $stmt->bind_param("ssssss", $data['user_id'], $data['first_name'], $data['email'], $type, $data['uuid'], $data['ip']);

            if ($stmt->execute()) {
                return $data['user_id'];
            } else {
                return false;
            }
        }
    }
    public function user($id)
    {
        $stmt = $this->connection->prepare("SELECT first_name, last_name, email, phone, userphoto, coverphoto, userrole FROM {$this->userstable} WHERE user_id = ? LIMIT 1");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->firstname = $row['first_name'];
            $this->lastname = $row['last_name'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->userphoto = $row['userphoto'];
            $this->coverphoto = $row['coverphoto'];
            $this->role = $row['userrole'];
        } else {
            $this->error = 'User Not Found!';
        }
        return $this;
    }
    public function allWriter()
    {
        $writers = [];
        $role = 'writer';
        $stmt = $this->connection->prepare("SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone, u.userphoto, u.userrole, u.status, u.useragent, u.geolocation, u.cr_at, 
                   COUNT(a.article_id) AS article_count
            FROM {$this->userstable} u
            LEFT JOIN articles a ON u.user_id = a.user_id
            WHERE u.userrole = ?
            GROUP BY u.user_id
        ");
        $stmt->bind_param('s', $role);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $writers[] = $row;
        }
        return $writers;
    }
    public function userStatusUpdate($uid, $s)
    {
        $stmt = $this->connection->prepare("UPDATE {$this->userstable} SET status = ? WHERE user_id = ?");
        $stmt->bind_param('ss', $s, $uid);
        if ($stmt->execute()) {
            return true;
        }
        return false;

    }

}