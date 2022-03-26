<?php
function file_upload($picture, $source = 'user'): stdClass
{
    $result = new stdClass(); //this object will carry status from file upload
    $result->fileName = 'avatar.png';
    if (isset($_SESSION['adm'])) {
        $result->fileName = 'leer.png';
    }
    $result->error = 1; //it could also be a boolean true/false
    //collect data from object $picture
    $fileName = $picture["name"];
    $fileTmpName = $picture["tmp_name"];
    $fileError = $picture["error"];
    $fileSize = $picture["size"];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $filesAllowed = ["png", "jpg", "jpeg"];
    if ($fileError == 4) {
        $result->ErrorMessage = "No picture was chosen. It can always be updated later.";
    } else {
        if (in_array($fileExtension, $filesAllowed)) {
            if ($fileError === 0) {
                if ($fileSize < 500000) { //500kb this number is in bytes
                    //it gives a file name based microseconds
                    $fileNewName = uniqid() . "." . $fileExtension; // 1233343434.jpg i.e
                    if ($source == 'animal') {
                        $destination = "../../images/$fileNewName"; //in this case I take my own folder with the same rel path
                    } elseif ($source == 'user') {
                        $destination = "images/$fileNewName";
                    }
                    if (move_uploaded_file($fileTmpName, $destination)) {
                        $result->error = 0;
                        $result->fileName = $fileNewName;
                    } else {
                        $result->ErrorMessage = "There was an error uploading this file, you can try again later";
                    }
                } else {
                    $result->ErrorMessage = "This picture is bigger than the allowed 500Kb. <br> Please choose a smaller one and Update your profile.";
                }
            } else {
                $result->ErrorMessage = "There was an error uploading - $fileError code. Check php documentation.";
            }
        } else {
            $result->ErrorMessage = "This file type cant be uploaded.";
        }
    }
    return $result;
}