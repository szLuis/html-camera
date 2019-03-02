<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photos</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div>
                <a style="margin: 30px 0 30px 0;  display:block; clear:both;" class="btn btn-primary" href="gallery.php"><- Gallery</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" >
                <ul class="list-unstyled">
                    <?php
                        $relativePath = $_SERVER["SERVER_NAME"] . substr($_SERVER["SCRIPT_NAME"], 0,-8);
                        $dir  = $_GET['dir'];
                        if (isset($dir)){
                            define('UPLOAD_DIR', 'images/');
                            define('RELATIVE_PATH', $relativePath);

                            $destination = UPLOAD_DIR . $dir;
                            
                            if (is_dir($destination)){
                                $fileList = scandir($destination, 1);
                                
                                if (count($fileList)===2){
                                    echo "No files in this directory";
                                }
                                $i=0;
                                foreach ($fileList as $file) {
                                    $filePath = $destination . "/" . $file;
                                    if (is_file($filePath)){
                                        print(" <li class='media'>
                                                    <img src='$filePath' class='align-self-center mr-3' width=160>" . 
                                                    '<div class="media-body">
                                                        <input readonly style="width:60%" type="url" name="picture-url" id="picture-url'. $i .'" value="' . RELATIVE_PATH . $filePath . '">
                                                        <button style="margin-left: 0;" class="btn-copy" data-clipboard-target="#picture-url'. $i .'">
                                                            <img src="assets/clippy.svg" width="24" height="24" alt="Copy to clipboard">
                                                        </button>
                                                    </div>
                                                </li>
                                            <br>');
                                    }
                                    $i++;
                                }
                                
                            }
                        }


                    ?>
                </ul>
            </div>
        </div>

    </div>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
<script>
    $('.btn-copy').tooltip({
        trigger: 'click',
        placement: 'bottom'
    });
    
    function setTooltip(message, e) {
        $(e.trigger).tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
    }
    
    function hideTooltip() {
        setTimeout(function() {
        $('.btn-copy').tooltip('hide');
        }, 1000);
    }
    
    var clipboard = new ClipboardJS('.btn-copy');
    
    clipboard.on('success', function(e) {
        setTooltip('Copied!', e);
        hideTooltip();
    
        e.clearSelection();
    });
    
    clipboard.on('error', function(e) {
        setTooltip('Failed!');
        hideTooltip();
    });
    
</script>

</body>
</html>
