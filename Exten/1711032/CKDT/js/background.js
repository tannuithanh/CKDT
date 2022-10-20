var po =0;
async function getapi(url) {
    // Storing response
    let response = await fetch(url);
    let posts = await response.json();
    po=posts;
}
const api_url ="http://113.161.6.153:4375/API/Controller/Question/Read.php?id=1711032";
function notify(notifyMessage) {
    var options = {
        type: "basic",
        title: "Chữ ký điện tử",
        message: notifyMessage,
        iconUrl: "icon.png"
    };
    chrome.notifications.create("", options, function(notificationId) {
        setTimeout(function(){
            chrome.notifications.clear(notificationId, function(){});
        }, 15000);
    });
    chrome.notifications.onClicked.addListener(function(notificationId, byUser) {
        chrome.tabs.create({url: "http://113.161.6.153:4375/TKACManager/ManagerFile.php?page=1"});
    });
}

// Calling that async function

var count = 0;
var oldcount = 0;
function ClockApp()
{
    getapi(api_url)
    count = po;
    if(count!="0" && count!=oldcount) {
        console.log(count);
        notify("Bạn có thông báo mới");
        oldcount=count;
    }
    setTimeout(ClockApp, 30000);
}
ClockApp();