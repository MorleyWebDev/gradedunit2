<?php
session_start();
require('../includes/dbconx.php');


$target_dir = "../img/userUploaded/";
$target_file = $target_dir . basename($_FILES["updatedProfPic"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["updatedProfPic"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
      header('location: ../userprofile.php?alertBarMsg=Please upload an image file only.');
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    header('location: ../userprofile.php?alertBarMsg=That file already exists in our database, either rename it or choose another file, sorry!');
    $uploadOk = 0;
}
// Check file size
if ($_FILES["updatedProfPic"]["size"] > 500000) {
    header('location: ../userprofile.php?alertBarMsg=Sorry, that picture is too big for our database. Please upload a smaller one (<500kb)');
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    header('location: ../userprofile.php?alertBarMsg=Please upload an image file only.');
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["updatedProfPic"]["tmp_name"], $target_file)) {
        $uid = $_SESSION['id'];
        $picUrl = basename($_FILES["updatedProfPic"]["name"]);
        #do some cool stuff here
        $updateProfPic = mysqli_query($conn, "UPDATE users set image = '$picUrl' WHERE userid = $uid");
        if($updateProfPic) {
          header('location: ../userprofile.php?alertBarMsg=Profile picture changed!');
        }
          else {header('location: ../userprofile.php?alertBarMsg=Server error. Please try again later!');}
                //
        // $i = imagecreatefromjpeg($target_file);
        // echo $target_file;
        //
        // $thumb = thumbnail_box($i, 210, 150);
        // $imagedestroy($i);
        //
        // if(is_null($thumb)) {
        //     /* image creation or copying failed */
        //     header('HTTP/1.1 500 Internal Server Error');
        //     exit();
        // }
        // header('Content-Type: image/jpeg');
        // imagejpeg($thumb);

    } else {
      header('location: ../userprofile.php?alertBarMsg=Sorry, there was a server error, please try again later.');

    }
}


function thumbnail_box($img, $box_w, $box_h) {
    //create the image, of the required size
    $new = imagecreatetruecolor($box_w, $box_h);
    if($new === false) {
        //creation failed -- probably not enough memory
        return null;
    }
    //Fill the image with a light grey color
    //(this will be visible in the padding around the image,
    //if the aspect ratios of the image and the thumbnail do not match)
    //Replace this with any color you want, or comment it out for black.
    //I used grey for testing =)
    $fill = imagecolorallocate($new, 200, 200, 205);
    imagefill($new, 0, 0, $fill);

    //compute resize ratio
    $hratio = $box_h / imagesy($img);
    $wratio = $box_w / imagesx($img);
    $ratio = min($hratio, $wratio);

    //if the source is smaller than the thumbnail size,
    //don't resize -- add a margin instead
    //(that is, dont magnify images)
    if($ratio > 1.0)
        $ratio = 1.0;

    //compute sizes
    $sy = floor(imagesy($img) * $ratio);
    $sx = floor(imagesx($img) * $ratio);

    //compute margins
    //Using these margins centers the image in the thumbnail.
    //If you always want the image to the top left,
    //set both of these to 0
    $m_y = floor(($box_h - $sy) / 2);
    $m_x = floor(($box_w - $sx) / 2);

    //Copy the image data, and resample
    //
    //If you want a fast and ugly thumbnail,
    //replace imagecopyresampled with imagecopyresized
    if(!imagecopyresampled($new, $img,
        $m_x, $m_y, //dest x, y (margins)
        0, 0, //src x, y (0,0 means top left)
        $sx, $sy,//dest w, h (resample to this size (computed above)
        imagesx($img), imagesy($img)) //src w, h (the full size of the original)
    ) {
        //copy failed
        imagedestroy($new);
        return null;
    }
    //copy successful
    return $new;
}

?>
