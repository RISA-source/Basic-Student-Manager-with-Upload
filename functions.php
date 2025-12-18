<?php

function formatName($name) {
    $name = trim($name);
    $name = ucwords(strtolower($name));
    return $name;
}

function validateEmail($email) {
    $email = trim($email);
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function cleanSkills($string) {
    $string = trim($string);
    $string = strtolower($string);
    return $string;
}

function saveStudent($name, $email, $skillsArray) {
    try {
        $skillsString = implode(',', $skillsArray);
        $data = $name . '|' . $email . '|' . $skillsString . PHP_EOL;
        
        if (file_put_contents('students.txt', $data, FILE_APPEND) === false) {
            throw new Exception("Failed to save student data");
        }
        
        return true;
    } catch (Exception $e) {
        throw $e;
    }
}

function uploadPortfolioFile($file) {
    try {
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload error occurred");
        }
        
        if ($file['size'] > $maxSize) {
            throw new Exception("File size exceeds 2MB");
        }
        
        $fileType = $file['type'];
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Only PDF, JPG, and PNG files are allowed");
        }
        
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception("Invalid file extension");
        }
        
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                throw new Exception("Failed to create upload directory");
            }
        }
        
        $timestamp = time();
        $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
        $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
        $newFileName = $cleanName . '_' . $timestamp . '.' . $extension;
        
        $destination = $uploadDir . $newFileName;
        
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Failed to move uploaded file");
        }
        
        return $newFileName;
    } catch (Exception $e) {
        throw $e;
    }
}

?>