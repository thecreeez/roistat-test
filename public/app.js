// В миллисекундах
const longVisitTime = 30 * 1000;

document.getElementById("isVisitLong").value = 0;
setTimeout(() => {
    document.getElementById("isVisitLong").value = 1;
}, longVisitTime);