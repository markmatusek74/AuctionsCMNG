<?php
$basePath =  str_replace("update_help_topic.php","",$_SERVER["SCRIPT_FILENAME"]);

require_once($basePath . "../../../includes/classes/help.class.php");
$help = new help();
$errors = array(); //To store errors
$form_data = array(); //Pass back the data to `form.php`
$help->HelpTopic = $_POST['topic'];
$help->HelpText = $_POST['text'];
if (!empty($_POST['topic'])) { //Name cannot be empty
   // $form_data['helpTopic'] = $_POST["topic"];
}

/* Validate the form on the server side */
if (empty($_POST['text'])) { //Name cannot be empty
    $errors['helpText'] = 'Help Text can not be blank.';
}

if (empty($_POST['topic'])) { //Name cannot be empty
    $errors['helpTopic'] = 'Help Topic can not be blank.';
}

if (!empty($errors))
    { //If errors in validation
        $form_data['success'] = false;
        $form_data['errors']  = $errors;
    }
else
    {
        $form_data['success'] = true;
        $form_data['errors']  = $errors;


      //  print "help topic: " . $help->HelpTopic . "\n";
        //print "help text: " . $help->HelpText . "\n";

        $help->updateHelpTopic();

        //$help->
    }

//Return the data back to form.php
echo json_encode($form_data);
?>