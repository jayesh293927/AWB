<?php
if(move_uploaded_file('/home/dharmendra/AWB/images/img4.jpg','/var/www/html/AWB/uploads')) {
    echo('if');
}else {
    echo('else');
}
?>