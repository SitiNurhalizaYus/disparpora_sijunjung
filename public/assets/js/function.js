
function convertStringToDate(str) {
    var date = new Date(str);
    let options = {
        // weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        // hour: "numeric",
        // minute: "numeric",
        // second: "numeric"
    };
    var newdate = date.toLocaleDateString('id', options);
    return newdate;
}
