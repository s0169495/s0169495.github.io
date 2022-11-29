
window.addEventListener("popstate", function(e) {
    getContent(location.pathname, false);
});

/*
document.addEventListener("DOMContentLoaded", function() { 
    document.querySelectorAll('textarea, input').forEach(function(e) {
        if(e.value === '') e.value = window.sessionStorage.getItem(e.name, e.value);
        e.addEventListener('input', function() {
            window.sessionStorage.setItem(e.name, e.value);
        })
    })

}); 
*/


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
    var d = document.getElementById("ch");
    persistInput(d);

}
