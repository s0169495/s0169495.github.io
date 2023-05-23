
<?php
 function authorize() {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}

if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW'])) {
  authorize();
}
$user = 'u53720';
$pass = '8531034';
$db = new PDO('mysql:host=localhost;dbname=u53720', $user, $pass, [PDO::ATTR_PERSISTENT => true]);
$stmt = $db->prepare("SELECT * FROM admin;");
$stmtErr = $stmt->execute();
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
$isAdmin = false;
foreach ($admins as $admin){
    if ($admin['login'] == $_SERVER['PHP_AUTH_USER'] && $admin['pass'] == ($_SERVER['PHP_AUTH_PW'])) {
        $isAdmin = true;
        break;
    }
}
if (!$isAdmin) {
    authorize();
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
    if (!empty($_GET['delete'])) {
        $stmt = $db->prepare("DELETE FROM capapp WHERE id=:id;");
        $stmtErr = $stmt->execute(['id' => $_GET['delete']]);
        $stmt = $db->prepare("DELETE FROM app WHERE id=:id;");
        $stmtErr = $stmt->execute(['id' => $_GET['delete']]);
        $stmt = $db->prepare("DELETE FROM logpass WHERE id=:id;");
        $stmtErr = $stmt->execute(['id' => $_GET['delete']]);
        header('Location: ./admin.php');
    }
    if (!empty($_GET['change'])) {
        $stmt = $db->prepare("SELECT * FROM app WHERE id=:id;");
        $stmtErr = $stmt->execute(['id' => $_GET['change']]);
        $person = $stmt->fetch();
        $stmt = $db->prepare("SELECT * FROM capapp WHERE id=:id;");
        $stmtErr = $stmt->execute(['id' => $_GET['change']]);
        $personAbilities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = $db->prepare("SELECT * FROM cap;");
        $stmtErr =  $stmt -> execute();
        $abilities = $stmt->fetchAll();
        $stmt = $db->prepare("SELECT * FROM logpass WHERE id=:id;");
        $stmtErr = $stmt->execute(['id' => $_GET['change']]);
        $logpass = $stmt->fetch();
    
            $a=array();
            foreach ($abilities as $ability) {
                $a[$ability['capability']] = 0;
            }
            foreach ($personAbilities as $personAbility) {
                foreach ($abilities as $ability) {
                    if ($ability['id_cap'] == $personAbility['id_cap']) {
                        $a[$ability['capability']]=1;
                        break;
                    }
                }
        }
        setcookie('changed_uid', $person['id'], time() + 30 * 24 * 60 * 60);
        ?>
    <p>Изменение данный пользователя с ID <?php print ($person['id']);?></p>
        <form action="" method="POST">

    <label>
        Имя:<br>
        <input name="name"
               placeholder="Имя" required <?php print('value="' . $person['name'] . '"'); ?>>
</label><br>

<label>
    E-mail:<br>
    <input name="email"
           type="email"
           placeholder="e-mail" required <?php print('value="' . $person['email'] . '"');  ?>>
</label><br>

<label>
    Год рождения:<br>
    <select name="year">
        <?php
        for ($i = 1923; $i <= 2023; $i++) {
            printf('<option value="%d"'. (intval($person['yearper'])==$i ? 'selected' : '') .'>%d год</option>', $i, $i);
        }
        ?>
    </select>
</label><br>

Пол: <br>
<label><input type="radio"
              name="gender" value="0" required <?php if(intval($person['gender'])==0) print ("checked"); ?>>
    Мужской</label>
<label><input type="radio"
              name="gender" value="1" required <?php if(intval($person['gender'])==1) print ("checked");?>>
    Женский</label><br>

Количество: <br>
<label><input type="radio"
              name="limbs" value="1" required <?php if(!$person['kol']=='' && intval($person['kol'])==1) print ("checked");?>>
    1</label>
<label><input type="radio"
              name="limbs" value="2" required <?php if(!$person['kol']=='' && intval($person['kol'])==2) print ("checked");?>>
    2</label>
<label><input type="radio"
              name="limbs" value="3" required <?php if(!$person['kol']=='' && intval($person['kol'])==3) print ("checked");?>>
    3</label>
<label><input type="radio"
              name="limbs" value="4" required <?php if(!$person['kol']=='' && intval($person['kol'])==4) print ("checked");?>>
    4</label><br>

<label>
    Суперсилы:
    <br>
    <select name="powers[]"
            multiple="multiple">
        <option value="immortality" <?php if(intval($a['immortality'])==1) print ("selected") ?>>Бессмертие</option>
        <option value="passing through walls" <?php if(intval($a['passing through walls'])==1) print ("selected") ?>>Левитация</option>
        <option value="levitation" <?php if(intval($a['levitation'])==1) print ("selected") ?>>Прохождение сквозь стены</option>
    </select>
</label><br>

<label>
    Биография:<br>
    <textarea name="biography"><?php print($person['bio']); ?></textarea>
</label><br>

            <label>
                Логин:<br>
                <input name="p_login"
                       placeholder="Логин" required <?php print('value="' . $logpass['login'] . '"'); ?>>
            </label><br>

            <label>
                Пароль:<br>
                <input name="p_pass"
                       placeholder="" required       <?php print('value="' . $logpass['pass'] . '"'); ?>>
            </label><br>


<input type="submit" value="Отправить">
</form>
<?php
    exit();
    }
    

    $stmt = $db->prepare("SELECT * FROM app ORDER BY id;");
    $stmtErr = $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $db->prepare("SELECT * FROM capapp ORDER BY id;");
    $stmtErr = $stmt->execute();
    $resultAbility = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = $db->prepare("SELECT * FROM logpass ORDER BY id;");
    $stmtErr = $stmt->execute();
    $resultLog = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt = $db->prepare("SELECT * FROM app a LEFT JOIN logpass b ON a.id=b.id;");
    $stmtErr = $stmt->execute();
    $result33 = $stmt->fetchAll(PDO::FETCH_ASSOC);

    print ('<table>
	<thead>
		<tr>
			<td>ID</td>
			<td>Имя</td>
			<td>Почта</td>
			<td>Год рождения</td>
			<td>Пол</td>
			<td>Количество конечностей</td>
            <td>Биография</td>
            <td>Логин</td>
			<td>Хеш пароля</td>
			<td>Способности</td>
			<td>Удалить</td>
			<td>Изменить</td>
		</tr>
	</thead>
	<tbody>');

    foreach ($result33 as $person) {
        print ('<tr>');
        foreach ($person as $key => $value) {
            if ($key=="gender") print ('<td>' . ($value=="0" ? "Муж" : "Жен") . '</td>');
            else print('<td>' . $value . '</td>');
        }
        print ('<td>');
       
        foreach ($resultAbility as $personAbility) {
            if ($personAbility['id'] == $person['id']){
                switch ($personAbility['id_cap']) {
                    case 0:
                        print ('Бессмертие ');
                        break;
                    case 1:
                        print ('Прохождение сквозь стены ');
                        break;
                    case 2:
                        print ('Левитация ');
                        break;
                }
            }
        }
      
        print ('<td><a href="./admin.php?delete=' . $person['id'] . '">Удалить данные</a></td>');
        print ('<td><a href="./admin.php?change=' . $person['id'] . '">Изменить данные</a></td>');
        print ('</tr>');
    }
    print ('</tbody>
    </table>');

    $stmt = $db->prepare("SELECT COUNT(1), id_cap FROM capapp GROUP BY id_cap;");
    $stmtErr = $stmt->execute();
    $statistics = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($statistics as $statistic) {
        print ('<p>' . $statistic['COUNT(1)'] . ' человек обладают ');
        switch ($statistic['id_cap']) {
            case 0:
                print ('Бессмертие ');
                break;
            case 1:
                print ('Прохождение сквозь стены ');
                break;
            case 2:
                print ('Левитация ');
                break;
        }
        print ('</p>');
    }

} else {
    $stmt = $db->prepare("UPDATE app SET name= :name, email= :mail, yearper= :year, gender= :gender, kol= :limbs_num, bio= :biography where id = :id");
    $stmtErr = $stmt->execute(['id' => $_COOKIE['changed_uid'], 'name' => $_POST['name'],'mail' => $_POST['email'] , 'year' => $_POST['year'], 'gender' => $_POST['gender'], 'limbs_num' => $_POST['limbs'], 'biography' => $_POST['biography']]);
    setcookie('changed_uid', '', 1);
    $stmt = $db->prepare("UPDATE logpass SET login=:p_login, pass=:p_pass where id = :id");
    $stmtErr = $stmt->execute(['id' => $_COOKIE['changed_uid'], 'p_login' => $_POST['p_login'], 'p_pass' => hash("adler32",$_POST['p_pass'])]);
    $stmt = $db->prepare("DELETE FROM capapp WHERE id=:id;");
    $stmtErr = $stmt->execute(['id' => $_COOKIE['changed_uid']]);
    $stmt = $db->prepare("SELECT * FROM cap;");
    $stmtErr =  $stmt -> execute();
    $abilities = $stmt->fetchAll();
    if (isset($_POST['powers'])) {
        foreach ($_POST['powers'] as $item) {
            foreach ($abilities as $ability) {
                if ($ability['capability'] == $item) {
                    $stmt = $db->prepare("INSERT INTO capapp (id, id_cap) VALUES (:p_id, :a_id);");
                    $stmtErr = $stmt->execute(['p_id' => $_COOKIE['changed_uid'], 'a_id' => $ability['id_cap']]);
                    break;
                }
            }
            if (!$stmtErr) {
                header("HTTP/1.1 500 Some server issue");
                exit();
            }
        }
    }
    header('Location: admin.php');
}






