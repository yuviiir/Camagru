<?php
require "database.php";
try 
{
    $conn = new PDO($db_, $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch (PDOException $e)
{
	die("Error : " . $e->getMessage());	
}

try 
{
    $sql = "DROP DATABASE IF EXISTS camagru";
    $conn->exec($sql);
    try 
    {
        $sql = "CREATE DATABASE IF NOT EXISTS camagru"; 
        $conn->exec($sql);
        try 
        {
            $sql = "CREATE TABLE camagru.users (
                uid INT NOT NULL AUTO_INCREMENT,
                email VARCHAR(500) UNIQUE NOT NULL,
                username VARCHAR(500) UNIQUE NOT NULL,
                password VARCHAR(500) NOT NULL,
                active BOOLEAN NOT NULL default 0,
                notif BOOLEAN NOT NULL default 1,
                PRIMARY KEY(uid)
                )";
            $conn->exec($sql);
            try 
            {
                $sql = "CREATE TABLE camagru.pictures (
                    pid INT AUTO_INCREMENT,
                    uid INT,
                    picture VARCHAR(500) UNIQUE NOT NULL,
                    PRIMARY KEY(pid),
                    FOREIGN KEY(uid) REFERENCES users(uid)
                    )";
                $conn->exec($sql);
                try 
                {
                    $sql = "CREATE TABLE camagru.comments (
                        cid INT AUTO_INCREMENT,
                        pid INT,
                        uid INT,
                        comment VARCHAR(500) NOT NULL,
                        PRIMARY KEY(cid),
                        FOREIGN KEY(pid) REFERENCES pictures(pid)
                        )";
                    $conn->exec($sql);
                    try 
                    {
                        $sql = "CREATE TABLE camagru.likes (
                            pid INT,
                            uid INT,
                            FOREIGN KEY(pid) REFERENCES pictures(pid)
                            )";
                        $conn->exec($sql);
                    }
                    catch (PDOException $e)
                    {
                        die("Error : " . $e->getMessage());	
                    }
                }
                catch (PDOException $e)
                {
                    die("Error : " . $e->getMessage());	
                }
            }
            catch (PDOException $e)
            {
                die("Error : " . $e->getMessage());	
            }
        }
        catch (PDOException $e)
        {
            die("Error : " . $e->getMessage());	
        }

    }
    catch (PDOException $e)
    {
        die("Error : " . $e->getMessage());	
    }
}
catch (PDOException $e)
{
	die("Error : " . $e->getMessage());	
}
//header("Location: ../index.php");

?>