


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
            <option value="1950">1950 год</option>
            <option value="1951">1951 год</option>
            <option value="1952">1952 год</option>
            <option value="1953">1953 год</option>
            <option value="1954">1954 год</option>
            <option value="1955">1955 год</option>
            <option value="1956">1956 год</option>
            <option value="1957">1957 год</option>
            <option value="1958">1958 год</option>
            <option value="1959">1959 год</option>
            <option value="1960">1960 год</option>
            <option value="1961">1961 год</option>
            <option value="1962">1962 год</option>
            <option value="1963">1963 год</option>
            <option value="1964">1964 год</option>
            <option value="1965">1965 год</option>
            <option value="1966">1966 год</option>
            <option value="1967">1967 год</option>
            <option value="1968">1968 год</option>
            <option value="1969">1969 год</option>
            <option value="1970">1970 год</option>
            <option value="1971">1971 год</option>
            <option value="1972">1972 год</option>
            <option value="1973">1973 год</option>
            <option value="1974">1974 год</option>
            <option value="1975">1975 год</option>
            <option value="1976">1976 год</option>
            <option value="1977">1977 год</option>
            <option value="1978">1978 год</option>
            <option value="1979">1979 год</option>
            <option value="1980">1980 год</option>
            <option value="1981">1981 год</option>
            <option value="1982">1982 год</option>
            <option value="1983">1983 год</option>
            <option value="1984">1984 год</option>
            <option value="1985">1985 год</option>
            <option value="1986">1986 год</option>
            <option value="1987">1987 год</option>
            <option value="1988">1988 год</option>
            <option value="1989">1989 год</option>
            <option value="1990">1990 год</option>
            <option value="1991">1991 год</option>
            <option value="1992">1992 год</option>
            <option value="1993">1993 год</option>
            <option value="1994">1994 год</option>
            <option value="1995">1995 год</option>
            <option value="1996">1996 год</option>
            <option value="1997">1997 год</option>
            <option value="1998">1998 год</option>
            <option value="1999">1999 год</option>
            <option value="2000">2000 год</option>
            <option value="2001">2001 год</option>
            <option value="2002">2002 год</option>
            <option value="2003">2003 год</option>
            <option value="2004">2004 год</option>
            <option value="2005">2005 год</option>
            <option value="2006">2006 год</option>
            <option value="2007">2007 год</option>
            <option value="2008">2008 год</option>
            <option value="2009">2009 год</option>
            <option value="2010">2010 год</option>
            <option value="2011">2011 год</option>
            <option value="2012">2012 год</option>
            <option value="2013">2013 год</option>
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
              <option value=0>Бессмертие</option>
              <option value=1>Левитация</option>
              <option value=2>Прохождение сквозь стены</option>
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