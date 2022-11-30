

function goBack() {
    window.history.back()
}




function persistInput(input)
{
  var key = "input-" + input.id;

  var storedValue = localStorage.getItem(key);

  if (storedValue)
      input.value = storedValue;

  input.addEventListener('input', function ()
  {
      localStorage.setItem(key, input.value);
  });
}





window.onload = function(){

    var a = document.getElementById("name");
    persistInput(a);
    var b = document.getElementById("post");
    persistInput(b);
    var c = document.getElementById("text");
    persistInput(c);


}






const form = document.getElementById("myForm");

form.addEventListener('submit', (e) => {
  e.preventDefault();
  e.target.reset();
})
