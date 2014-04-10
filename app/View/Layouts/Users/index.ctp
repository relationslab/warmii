<h2>Home Page</h2>
<?php
echo $this->Facebook->logout(array('redirect' => array('controller' => 'users', 'action' => 'logout')));
?>