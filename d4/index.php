<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        $messages[] = '<div style="color:#191970;">Спасибо, результаты сохранены. </div>';
    }

    $errors = array();
    $errors['userName'] = !empty($_COOKIE['userName_error']);
    $errors['userEmail'] = !empty($_COOKIE['userEmail_error']);
    $errors['userName_wrong'] = !empty($_COOKIE['userName_wrong']);
    $errors['userEmail_wrong'] = !empty($_COOKIE['userEmail_wrong']);

    if($errors['userName']) {
        setcookie('userName_error', '', 100000);
        $messages[] = '<div style="color:#8b0000;">Заполните имя.</div>';
    }
    if($errors['userEmail']) {
        setcookie('userEmail_error', '', 100000);
        $messages[] = '<div style="color:#8b0000;">Заполните email.</div>';
    }
 
    if($errors['userName_wrong']) {
        setcookie('userName_wrong', '', 100000);
        $messages[] = '<div style="color:#8b0000;">Используются недопустимые символы в поле "Имя".</div>';
    }
    if($errors['userEmail_wrong']) {
        setcookie('userEmail_wrong', '', 100000);
        $messages[] = '<div style="color:#8b0000;">Используются недопустимые символы в поле "Email".</div>';
    }

    $values = array();
    $values['userName'] = empty($_COOKIE['userName_value']) ? '' : $_COOKIE['userName_value'];
    $values['userEmail'] = empty($_COOKIE['userEmail_value']) ? '' : $_COOKIE['userEmail_value'];
    $values['userDate'] = empty($_COOKIE['userDate_value']) ? '' : $_COOKIE['userDate_value'];
    $values['userGender'] = empty($_COOKIE['userGender_value']) ? '' : $_COOKIE['userGender_value'];
    $values['userLimbs'] = empty($_COOKIE['userLimbs_value']) ? '' : $_COOKIE['userLimbs_value'];
    $values['userBio'] = empty($_COOKIE['userBio_value']) ? '' : $_COOKIE['userBio_value'];
    $values['Ab0'] = empty($_COOKIE['userAb0']) ? '' : $_COOKIE['userAb0'];
    $values['Ab1'] = empty($_COOKIE['userAb1']) ? '' : $_COOKIE['userAb1'];
    $values['Ab2'] = empty($_COOKIE['userAb2']) ? '' : $_COOKIE['userAb2'];

    include('form.php');

}else{

    $errors = FALSE;

    if (empty($_POST['field-name'])) {
        setcookie('userName_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if(!preg_match('/^[a-zA-Zа-яА-Я]+$/ui', $_POST['field-name'])){
        setcookie('userName_wrong', '3', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $userName = $_POST['field-name'];
        setcookie('userName_value', $userName, time() + 365 * 24 * 60 * 60);
    }

    if (empty($_POST['field-email'])) {
        setcookie('userEmail_error', '2', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else if(!preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/', $_POST['field-email'])){
        setcookie('userEmail_wrong', '4', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        $userEmail = $_POST['field-email'];
        setcookie('userEmail_value', $userEmail, time() + 365 * 24 * 60 * 60);
    }

        $userDate = $_POST['year'];
        setcookie('userDate_value', $userDate, time() + 365 * 24 * 60 * 60);

        $userGender = $_POST['radio-group-1'];
        setcookie('userGender_value', $userGender, time() + 365 * 24 * 60 * 60);
   
        $userLimbs = $_POST['radio-group-2'];
        setcookie('userLimbs_value', $userLimbs, time() + 365 * 24 * 60 * 60);

        $userBio = $_POST['field-name-2'];
        setcookie('userBio_value', $userBio, time() + 365 * 24 * 60 * 60);

        $userAb = array();
        $n = count($_POST['field-name-3']);
        for ($i = 0; $i < $n; $i++) {
            $userAb[$i] = $_POST['field-name-3'][$i];
    }
         for ($i = 0; $i < $n; $i++) {
            if ($userAb[$i] == 'immortality') {$Ab0=1;  setcookie('userAb0', 1, time() + 365 * 24 * 60 * 60);}
            else if ($userAb[$i] == 'levitation')  {$Ab1=1;  setcookie('userAb1', 1, time() + 365 * 24 * 60 * 60);}
            else {$Ab2=1;  setcookie('userAb2', 1, time() + 365 * 24 * 60 * 60);}
    }

    if($errors){
        header('Location: index.php');
        exit();
    }else {
        setcookie('userName_error', '', 100000);
        setcookie('userEmail_error', '', 100000);
        setcookie('userName_wrong', '', 100000);
        setcookie('userEmail_wrong', '', 100000);
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
        $stmt_1->execute();
        $id = $db->lastInsertId();

          for ($i = 0; $i<$n; $i++){
            $q = $db->prepare("SELECT id_cap FROM cap WHERE capability=:cap");
            $q->bindParam(':cap', $userAb[$i]);
            $q->execute();
            $cp = $q->fetchAll(PDO::FETCH_ASSOC);
            $id_cap=$cp[0]['id_cap'];
        $stmt_2 = $db->prepare("INSERT INTO capapp (id, id_cap) VALUES (:id, :id_cap)");
        $stmt_2->bindParam(':id', $id);
        $stmt_2->bindParam(':id_cap', $id_cap);
        $stmt_2->execute();
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    setcookie('save', '1');
    header('Location: ?save=1');
}
