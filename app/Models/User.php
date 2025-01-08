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
    private $focusartists = 'focus_artists';
    protected $connection;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }
    public function login($email, $pass, $type = 'artists')
    {
        $user_email = mysqli_real_escape_string($this->connection, $email);
        $user_password = mysqli_real_escape_string($this->connection, $pass);
        if (empty($user_email)) {
            return ['error' => 'Fill up Email field!'];
        }
        if (empty($user_password)) {
            return ['error' => 'Fill up Password field!'];
        }
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        $stmt = '';
        if ($type === 'admin') {
            $stmt = $this->connection->prepare("SELECT user_id, first_name, email, pass, userphoto,userrole, status FROM {$this->userstable} WHERE first_name = ? AND userrole = ? LIMIT 1");
        } else {
            $stmt = $this->connection->prepare("SELECT user_id, first_name, email, pass, userphoto, userrole, status FROM {$this->userstable} WHERE email = ? AND userrole = ? LIMIT 1");
        }
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
    public function signup($data, $type = 'artists')
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
    public function artists()
    {
        $artists = [];
        $role = 'artists';
        $status = 1;
        $stmt = $this->connection->prepare("SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone, u.userphoto,u.coverphoto, u.bio, u.userrole, u.status, u.cr_at
            FROM {$this->userstable} u
            WHERE u.status = ? AND u.userrole = ?
        ");
        $stmt->bind_param('ss', $status, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $artists[] = $row;
        }
        return $artists;
    }
    public function paginateArtist($page, $limit)
    {
        $artists = [];
        $offset = ($page - 1) * $limit;
        $role = 'artists';
        $status = 1;
        $stmt = $this->connection->prepare("SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone, u.userphoto,u.coverphoto, u.userrole, u.status, u.cr_at
            FROM {$this->userstable} u
            WHERE u.status =? AND u.userrole = ?
            ORDER BY u.id DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bind_param('ssii', $status, $role, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $artists[] = $row;
        }
        return $artists;
    }
    public function get($id, $role = 'artists')
    {
        $stmt = $this->connection->prepare("SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone, u.userphoto, u.coverphoto, u.lifespan, u.origin, u.bio1, u.bio2, u.bio3
            FROM {$this->userstable} u
            WHERE u.user_id = ? AND u.userrole = ?
        ");
        $stmt->bind_param('ss', $id, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function focusArtists()
    {
        $artists = [];
        $role = 'artists';
        $stmt = $this->connection->prepare("SELECT u.user_id, u.first_name, u.last_name,  u.userphoto, u.coverphoto
            FROM {$this->userstable} u
            INNER JOIN {$this->focusartists} f
            ON u.user_id = f.user_id
            WHERE u.userrole = ? AND u.status = 1 
            ORDER BY f.sl LIMIT 4
        ");
        $stmt->bind_param('s', $role);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $artists[] = $row;
        }
        return $artists;
    }
    public function storeArtists($data)
    {
        $insertStmt = $this->connection->prepare("INSERT INTO {$this->userstable} (user_id, first_name, last_name, userphoto, coverphoto, lifespan, origin, bio1, bio2, bio3, userip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($insertStmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $insertStmt->bind_param('sssssssssss', $data['user_id'], $data['fname'], $data['lname'], $data['userphoto'], $data['coverphoto'], $data['lifespan'], $data['origin'], $data['bio1'], $data['bio2'], $data['bio3'], $data['ip']);

        if ($insertStmt->execute()) {
            return true;
        }
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
    public function delete($id)
    {
        $fetchStmt = $this->connection->prepare("SELECT userphoto, coverphoto FROM {$this->userstable} WHERE user_id = ?");
        if ($fetchStmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $fetchStmt->bind_param('s', $id);
        $fetchStmt->execute();
        $result = $fetchStmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userphoto = $row['userphoto'];
            $coverphoto = $row['coverphoto'];
            $realPath1 = realpath($userphoto);
            if ($realPath1 && file_exists($realPath1)) {
                unlink($realPath1);
            }
            if ($coverphoto !== 'storage/artists/default-cover.jpg') {
                $realPath2 = realpath($coverphoto);
                if ($realPath2 && file_exists($realPath2)) {
                    unlink($realPath2);
                }
            }

        } else {
            return ['success' => false, 'message' => 'Record not found!'];
        }
        $deleteStmt = $this->connection->prepare("DELETE FROM {$this->userstable} WHERE user_id = ?");
        if ($deleteStmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $deleteStmt->bind_param('s', $id);
        if ($deleteStmt->execute()) {
            if ($deleteStmt->affected_rows > 0) {
                return ['success' => true, 'message' => 'Record and image deleted successfully!'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete the record!'];
            }
        } else {
            return ['success' => false, 'message' => 'Delete query failed!'];
        }
    }
}