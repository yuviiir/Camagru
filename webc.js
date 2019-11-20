var video = document.getElementById('video'),
canvas = document.getElementById('canvas'),
context = canvas.getContext('2d');

var image;

let pic_taken = false;
navigator.getMedia = navigator.getUserMedia ||
                     navigator.webkitGetUserMedia;
navigator.getMedia
    ({
        video: true,
        audio: false
    },
function(stream)
    {
        video.srcObject=stream;
        video.play();
    },
function(error)
    {
       
    }),
document.getElementById('capture').addEventListener('click', function()
{
    pic_taken = true;
    context.drawImage(video, 0, 0, 300, 150);
    if (image.src)
        context.drawImage(image, 20, 10, 100, 70);
}),
document.getElementById('upload').addEventListener('click', function()
{
    if (pic_taken)
    {
    var image = canvas.toDataURL();
     let params = "image="+image;

     let xhr = new XMLHttpRequest();
     xhr.open('POST', '/Camagru/storeimage.php', true);
     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
     xhr.onload = function()
     {
         if (this.status == 200){
             console.log(this.responseText);
             window.location.href = 'imgsaved.php';
         }
     };
     xhr.send(params);
    }
    else
        alert("No picture taken");
 });

function selectsticker(id)
{
    BtnDeselect("1");
    BtnDeselect("2");
    BtnDeselect("3");
    var item = document.getElementById(id).src;
    console.log(item);
    image = new Image();
    image.src = item;
    if (id == 's1')
        BtnSelect("1");
    if (id == 's2')
        BtnSelect("2");
    if (id == 's3')
        BtnSelect("3");
    BtnEnable("capture");
    BtnEnable("upload");
}

function BtnEnable(id)
{
    var style = document.getElementById(id).style;
    style.backgroundColor = "rgb(209, 111, 144)";
    style.cursor = "pointer";
    style.pointerEvents = "all";
}
function BtnSelect(id)
{
    var style = document.getElementById(id).style;
    style.border = "0.3vw solid black";
}
function BtnDeselect(id)
{
    var style = document.getElementById(id).style;
    style.border = "rgb(209, 111, 144)";
}