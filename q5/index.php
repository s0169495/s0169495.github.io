<?php

header('Content-Type: text/html; charset=UTF-8');

$user = 'u53720';
$pass = '8531034';

function okLetsGo($errors, $error_type, $i){
    if($i<12) {
        return !$errors[$error_type[$i]] && okLetsGo($errors, $error_type, $i + 1);
    }
    else return !$errors[$error_type[$i]];
}

function goBack(){
    header('Location: index.php');
    exit();
}

function generateUniqueLogin(){
    $user = 'u53720';
    $pass = '8531034';
    $login = uniqid();
    try {
        $db = new PDO('mysql:host=localhost;dbname=u53720', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("SELECT login FROM logpass WHERE login=(:login)");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        while($stmt->fetchColumn() == $login){
            if(strlen($login)<21) {
                $postfix = rand(0, 9);
                $login = $login.$postfix;
            } else {
                $login = generateUniqueLogin();
                break;
            }
        }
        return $login;
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
}

function getId($login){
    $user = 'u53720';
    $pass = '8531034';
    $db = new PDO('mysql:host=localhost;dbname=u53720', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $get_id = $db->prepare("SELECT id FROM logpass WHERE login=:login");
    $get_id->bindParam(':login', $login);
    $get_id->execute();
    return $get_id->fetchColumn();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);

        $messages[] = '<div style="color:#191970;">Спасибо, результаты сохранены. </div>';

        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('<div style="color:#191970;">Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong> и паролем <strong>%s</strong> для изменения данных.</div>', strip_tags($_COOKIE['login']), strip_tags($_COOKIE['pass']));
        }
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

    session_start();
    if (!$errors && !empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
        try{
            $id = getId($_SESSION['login']);
            $db = new PDO('mysql:host=localhost;dbname=u53720', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $get_data = $db->prepare("SELECT * FROM app WHERE id=:id");
            $get_data->bindParam(':id' , $id);
            $get_data->execute();
            $data = array();
            $data = $get_data->fetchAll(PDO::FETCH_ASSOC);
            $get_ab = $db->prepare("SELECT * FROM capapp WHERE id=:id");
            $get_ab->bindParam(':id' , $id);
            $get_ab->execute();
            $data_ab = array();
            $data_ab = $get_ab->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        $values['userName'] = filter_var($data[0]['name'],FILTER_SANITIZE_SPECIAL_CHARS);
        $values['userEmail'] = filter_var($data[0]['email'], FILTER_SANITIZE_SPECIAL_CHARS);
        $values['userDate'] = $data[0]['date'];
        $values['userGender'] = $data[0]['gender'];
        $values['userLimbs'] = $data[0]['limbs'];
        $values['userBio'] = filter_var($data[0]['bio'], FILTER_SANITIZE_SPECIAL_CHARS);
        $values['userAb0'] = $data_ab[0]['immortality'];
        $values['userAb1'] = $data_ab[0]['levitation'];
        $values['userAb2'] = $data_ab[0]['passing through walls'];
        print('<div style="color:#191970;">');
        printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
        print('</div>');
    }
    include('form.php');
}

else{

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
            if ($userAb[$i] == 0) {$Ab0=1;  setcookie('userAb0', 1, time() + 365 * 24 * 60 * 60);}
            else if ($userAb[$i] == 1)  {$Ab1=1;  setcookie('userAb1', 1, time() + 365 * 24 * 60 * 60);}
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


    if (!empty($_COOKIE[session_name()]) &&
    session_start() && !empty($_SESSION['login'])) {
    try {
        $id = getId($_SESSION['login']);
        $db = new PDO('mysql:host=localhost;dbname=u53720', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        $stmt_1 = $db->prepare("UPDATE app SET name=:name, email=:email, yearper=:yearper, gender=:gender, kol=:kol, bio=:bio WHERE id=:id");
        $stmt_1->bindParam(':name', $userName);
        $stmt_1->bindParam(':email', $userEmail);
        $stmt_1->bindParam(':yearper', $userDate);
        $stmt_1->bindParam(':gender', $userGender);
        $stmt_1->bindParam(':kol', $userLimbs);
        $stmt_1->bindParam(':bio', $userBio);
        $stmt_1->bindParam(':id', $id);
       // $db->beginTransaction();
        $stmt_1->execute();
      //  $db->commit();

        $stmt_2 = $db->prepare("UPDATE capapp SET god=:god, noclip=:noclip, levitation=:levitation WHERE id=:id");
        $stmt_2->bindParam(':id', $id);
        $stmt_2->bindParam(':god', $userAb[0]);
        $stmt_2->bindParam(':noclip', $userAb[1]);
        $stmt_2->bindParam(':levitation', $userAb[2]);
      //  $db->beginTransaction();
        $stmt_2->execute();
     //   $db->commit();

     for ($i = 0; $i<$n; $i++){

        $stmt_2 = $db->prepare("INSERT INTO capapp (id, id_cap) VALUES (:id, :id_cap)");
        $stmt_2->bindParam(':id', $id);
        $stmt_2->bindParam(':id_cap', $userAb[$i]);
        $stmt_2->execute();

        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }}
    else {
        $login = generateUniqueLogin();
        $password = uniqid();
        $serverpass = $password.md5('Ui4N9c');

        setcookie('login', $login);
        setcookie('pass', $password);
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

    
        $stmt_2 = $db->prepare("INSERT INTO capapp (id, id_cap) VALUES (:id, :id_cap)");
        $stmt_2->bindParam(':id', $id);
        $stmt_2->bindParam(':id_cap', $userAb[$i]);
        $stmt_2->execute();

        }

        $stmt_3 = $db->prepare("INSERT INTO logpass (id, login, pass) VALUES (:id, :login, :password)");
        $stmt_3->bindParam(':id', $id);
        $stmt_3->bindParam(':login', $login);
        $stmt_3->bindParam(':password', $password);
       // $db->beginTransaction();
        $stmt_3->execute();
       // $db->commit();
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    }
    setcookie('save', '1');
    header('Location: ?save=1');
}
