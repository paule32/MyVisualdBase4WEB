<pre>
<?php
session_start();

echo 'REMOTE_USER =' . $_SERVER['REMOTE_USER'] . '<br>';

print_r($_SERVER);
die();
exit();

?>
</pre>
