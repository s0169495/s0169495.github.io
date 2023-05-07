


<!DOCTYPE html>

<html lang="ru">
<head>
<title>Задание</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="index.css">
</head>


<body> 

 <form action="index.php" method="POST">

     <b><a>Форма</a></b></br></br>
    
    <label>
      Имя:<br />
      <input name="field-name"
      placeholder="Введите ваше имя" />
    </label><br />

    <label>
      email:<br />
      <input name="field-email"
        type="email"
        placeholder="Введите вашу почту" />
    </label><br />

    <br>
    <label>
    Год рождения:<br>
        <select name="year">
            <option value="1990">1990 год</option>
            <option value="1991">1991 год</option>
            <option value="1992">1992 год</option>
            <option value="1993">1993 год</option>
            <option value="1994">1994 год</option>
            <option value="1995">1995 год</option>
            <option value="1996">1996 год</option>
            <option value="1997">1997 год</option>
            <option value="1998">1998 год</option>
        </select>
    </label>
    <br>

   
    Пол:<br />
    <label><input type="radio" checked="checked"
      name="radio-group-1" value=0 />
      М</label>
    <label><input type="radio"
      name="radio-group-1" value=1 />
      Ж</label><br />
    
    Количество конечностей:<br />
      <label><input type="radio" checked="checked"
        name="radio-group-2" value=4 />
        4</label>
      <label><input type="radio"
        name="radio-group-2" value=3 />
        3</label>
      <label><input type="radio"
        name="radio-group-2" value=2 />
        2</label>
      <label><input type="radio"
        name="radio-group-2" value=1 />
        1</label><br />

    Сверхспособности:<label>
            <br />
            <select multiple name="field-name-3[]">
              <option value='immortality'>Бессмертие</option>
              <option value='levitation'>Левитация</option>
              <option value='passing through walls'>Прохождение сквозь стены</option>
            </select>
          </label><br />

    <label>
    Биография:<br />
    <textarea name="field-name-2"></textarea>
    </label><br />
      
      
    С контрактом ознакомлен (а)::<br />


    <input type="checkbox" id="ch" name="send-enabled" />
<input type="submit" name="send" value="Отправить"/> 
</form>
</body>
</html>
