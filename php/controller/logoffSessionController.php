<?php
session_start();
sleep(0.5);
session_destroy();
sleep(0.5);
echo'<script>window.location.href = "../view/index.php"</script>';
?>