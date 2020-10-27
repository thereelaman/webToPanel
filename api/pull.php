<?php

if ( $_POST['payload'] ) {
shell_exec( ‘cd /var/www/thedisplay.studio/ && git reset –hard HEAD && git pull’ );
}

?>hi
