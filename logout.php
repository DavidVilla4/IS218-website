<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Logout</title>
        <link rel="stylesheet" href="project.css" />
    </head>
    <body>
        <?php
        include('/////put the php file name here for whatever needed to be included/////');
        session_start();
        if(session_destroy()) {
            redirect('You are logging out, please wait!', 'signout.php', 5);
        }
        ?>
    </body>
</html>