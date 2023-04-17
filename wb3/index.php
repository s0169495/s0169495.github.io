<?php

header('Content-Type: text/html; charset=UTF-8');

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print('<div style="color:##FFFFFF; background-color:#008080;">Данные успешно сохранены! </div>');
    }
    include('form.php');
    exit();
}else {
    $errors = FALSE;
    $errors_string = array();
    for($i=0; $i<4; $i++){
        $errors_string[$i]='';
    }

    if (empty($_POST['field-name'])) {
        $errors_string[0] = '<div style="color:#FFFFFF; background-color:#008080;">Заполните имя. </div>';
        $errors = TRUE;
    }
    if (empty($_POST['field-email'])) {
        $errors_string[1] = '<div style="color:#FFFFFF; background-color:#008080;">Заполните email. </div>';
        $errors = TRUE;
    } else if (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $_POST['field-email'])) {
        $errors_string[2]='<div style="color:#FFFFFF; background-color:#008080;">Неверно введён email.</div>';
        $errors = TRUE;
    }
     if (empty($_POST['field-name-2'])) {
        $errors_string[3] = '<div style="color:#FFFFFF; background-color:#008080;">Заполните биографию. </div>';
        $errors = TRUE;
    }
    if ($errors) {
        for($i=0; $i<4; $i++){
            print($errors_string[$i]);
        }
        include('form.php');
        exit();
    }
    $userName = $_POST['field-name'];
    $userEmail = $_POST['field-email'];
    $userDate = $_POST['year'];
    $userGender = $_POST['radio-group-1'];
    $userLimbs = $_POST['radio-group-2'];
    $userBio = $_POST['field-name-2'];

    $userAb = array();

        $n = count($_POST['field-name-3']);
        for ($i = 0; $i < $n; $i++) {
                $userAb[$i] = $_POST['field-name-3'][$i];
    }

    try {
        $user = 'u53720';
        $pass = '8531034';
        $db = new PDO('mysql:host=localhost;dbname=u53720', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        $stmt_1 = $db->prepare("INSERT INTO app (name, email, yearper, gender, kol, bio) VALUES (:name, :email, :yearper, :gender, :kol, :bio)");
        $stmt_1->bindParam(':name', $userName);
        $stmt_1->bindParam(':email', $userEmail);
        $stmt_1->bindParam(':yearper', $userDate);
        $stmt_1->bindParam(':gender', $userGender);
        $stmt_1->bindParam(':kol', $userLimbs);
        $stmt_1->bindParam(':bio', $userBio);
        $db->beginTransaction();
        $stmt_1->execute();
        $id = $db->lastInsertId();
        $db->commit();

        for ($i = 0; $i<$n; $i++){

    
        $stmt_2 = $db->prepare("INSERT INTO capapp (id, id_cap) VALUES (:id, :id_cap)");
        $stmt_2->bindParam(':id', $id);
        $stmt_2->bindParam(':id_cap', $userAb[$i]);

        $db->beginTransaction();
        $stmt_2->execute();
        $db->commit();

        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    header('Location: ?save=1');
}