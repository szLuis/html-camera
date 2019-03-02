<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div>
                <a href="index.html" class="btn btn-primary" >Home</a> 
                <p style="margin-top: 30px; display:block; clear:both;">Last galleries</p> 
            </div>

        </div>
        <div class="row">
            <div class="list-group">
                <?php
                    define('UPLOAD_DIR', 'images/');
                    if (is_dir(UPLOAD_DIR)){
                        $directoryList = scandir(UPLOAD_DIR, 1);
                        
                        foreach ($directoryList as $directory) {
                            if ($directory !== "." && $directory !== ".." && is_dir(UPLOAD_DIR . $directory)){
                                print("<a href='show.php?dir=$directory' class='list-group-item list-group-item-action list-group-item-primary' >  " . $directory . "</a>" . "<br>");
                            }
                        }
                        
                    }

                ?>
            </div>
        </div>

    </div>
</body>
</html>

