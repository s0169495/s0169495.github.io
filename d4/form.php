
<!DOCTYPE html>

<html lang="ru">
<head>
<title>Задание</title>
<meta charset="utf-8">
<link rel="stylesheet" href="index.css">
<style>
.error {
  border: 2px solid red;
}
    </style>
</head>


<body>
    
<?php
if(!empty($messages)){
    print('<div id="messages">');
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>
    <form action="index.php" method="POST">



        <b><a>Форма</a></b></br></br>
        <label <?php if ( $errors['userName'] || $errors['userName_wrong']) {print 'class="error"' ; } ?>>
            Имя:<br />
            <input name="field-name"
                   placeholder="Введите ваше имя" value="<?php print $values['userName']; ?>"/>
        </label><br />

        <label <?php if ($errors['userEmail'] || $errors['userEmail_wrong']) {print 'class="error"';} ?>>
            email:<br />
            <input name="field-email"
                   type="email"
                   placeholder="Введите вашу почту" value="<?php print $values['userEmail']; ?>"/>
        </label><br />

        <br>
        <label>
            Год рождения:<br>


            <select name="year" value="<?php print $values['userDate']; ?>">
                <option value="1990" <?php if($values['userDate'] == 1990) {print 'selected';}?>>1990 год</option>
                <option value="1991" <?php if($values['userDate'] == 1991) {print 'selected';}?>>1991 год</option>
                <option value="1992" <?php if($values['userDate'] == 1992) {print 'selected';}?>>1992 год</option>
                <option value="1993" <?php if($values['userDate'] == 1993) {print 'selected';}?>>1993 год</option>
                <option value="1994" <?php if($values['userDate'] == 1994) {print 'selected';}?>>1994 год</option>
                <option value="1995" <?php if($values['userDate'] == 1995) {print 'selected';}?>>1995 год</option>
                <option value="1996" <?php if($values['userDate'] == 1996) {print 'selected';}?>>1996 год</option>
                <option value="1997" <?php if($values['userDate'] == 1997) {print 'selected';}?>>1997 год</option>
                <option value="1998" <?php if($values['userDate'] == 1998) {print 'selected';}?>>1998 год</option>
              </select>
              <br />     

        Пол:<br />
        
            <input type="radio" checked="checked" <?php if($values['userGender'] == 0) {print 'checked="checked"';} ?>
                   name="radio-group-1" value="0" />
                   <label>М
        </label>
       
            <input type="radio" <?php if($values['userGender'] == 1) {print 'checked="checked"';} ?>
                   name="radio-group-1" value="1" />
                   <label>Ж
        </label><br />

        Количество конечностей:<br />
      
            <input type="radio" checked="checked" <?php if($values['userLimbs'] == 4) {print 'checked="checked"';} ?>
                   name="radio-group-2" value="4"/>
                   <label>4
        </label>
        
            <input type="radio" <?php if($values['userLimbs'] == 3) {print 'checked="checked"';} ?>
                   name="radio-group-2" value="3" />
                   <label>3
        </label>
       
            <input type="radio" <?php if($values['userLimbs'] == 2) {print 'checked="checked"';} ?>
                   name="radio-group-2" value="2" />
                   <label>2
        </label>
        
            <input type="radio" <?php if($values['userLimbs'] == 1) {print 'checked="checked"';} ?>
                   name="radio-group-2" value="1" />
                   <label>1
        </label><br />

        Сверхспособности:<label>
            <br />
            <select multiple name="field-name-3[]">
            <option value='immortality' <?php if($values['Ab0'] == 1){print 'selected';}?>>Бессмертие</option>
                <option value='levitation' <?php if($values['Ab1'] == 1){print 'selected';}?>>Прохождение сквозь стены</option>
                <option value='passing through walls' <?php if($values['Ab2'] == 1){print 'selected';}?>>Левитация</option>
            </select>
        </label><br />

        <label>
            Биография:<br />
            <textarea name="field-name-2"><?php print $values['userBio']; ?></textarea>
        </label><br />


        С контрактом ознакомлен (а):<br />


        <input type="checkbox" id="ch" name="send-enabled" />
        <input type="submit" name="send" value="Отправить" />
    </form>
</body>
</html>
