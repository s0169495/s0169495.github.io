function calc() {
    let cost = document.getElementsByName("cost");
    let kol = document.getElementsByName("kol");
    let result = document.getElementById("result");
    let re = /\D/;
    if ((cost[0].value.match(re) || kol[0].value.match(re)) === null)
        result.innerHTML = ("Стоимость вашего заказа: " + parseFloat(cost[0].value, 10) * parseInt(kol[0].value, 10));
    else result.innerHTML = "Ошибка! Неверный формат чисел";
    return false;
}
window.addEventListener('DOMContentLoaded', function(event) {
    let btn = document.getElementById("button1");
    btn.addEventListener("click", getResult);
});