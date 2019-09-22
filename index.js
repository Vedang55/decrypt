function getTime() {
    return (new Date()).getTime();
  }
  
  function intervalHeartbeat() {
    var now = getTime();
    var diff = now - lastInterval;
    var offBy = diff - 1000; 
    lastInterval = now;
  
    if(offBy > 100) { 
        clearInterval(startinterval);
        ctime();
    }
  }
  
  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }
  
  function diff(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET','./handlers/getStart.php',true);
    xhr.onload = function(){
      countdown = this.responseText.split(':');    
      ctime();    
    }
    xhr.send();
  }
    
  function ctime(){
    var xhr2 = new XMLHttpRequest();
    xhr2.open('GET','./handlers/getTime.php',true);
  
    xhr2.onload = function(){
        var time1 = xhr2.responseText;
        time = time1.split(':');
  
        var h = parseInt(time[0]);
        var m = parseInt(time[1]);
        var s = parseInt(time[2]);
      
        newtime[0] = countdown[0] - h;
      
        if(m > countdown[1]){
            newtime[0] = newtime[0] - 1;
            newtime[1] = 60 - (m - countdown[1]);
        } 
        else{
            newtime[1] = countdown[1] - m;
        }
        if(s > countdown[2]){
            newtime[1] = newtime[1] - 1;
            newtime[2] = 60 - (s - countdown[2]);
        }
        else{
            newtime[2] = countdown[2] - s;
        }
        document.getElementById('time').innerHTML = checkTime(newtime[0]) + ":" + checkTime(newtime[1]) + ":" + checkTime(newtime[2]);
        start();
    }
  xhr2.send();
  }
  
  function start(){
    startinterval = setInterval(function stime(){
       newtime[2] = newtime[2] - 1;
       if(newtime[2]<0){
           newtime[1] = newtime[1] - 1;
           newtime[2]=59
       }
       if(newtime[1]<0){
           newtime[0] = newtime[0] - 1;
           newtime[1] = 59 ;
       }
       if(newtime[0]<0){
            document.getElementById("play").style.display = "block";
            document.getElementById('time').style.display="none";
            document.getElementById("si").style.display = "none";
            document.getElementById('usernameField').style.display='block';
       }
       else{   
        document.getElementById('time').style.display="block";
        document.getElementById("si").style.display = "block";
        document.getElementById('time').innerHTML = checkTime(newtime[0]) + ":" + checkTime(newtime[1]) + ":" + checkTime(newtime[2]);
       }
       
     }, 1000);
   }
  
  
  //start
  var time = [];
  var countdown = [];
  var newtime = [];

    document.getElementById("play").style.display = "none";
    document.getElementById('time').style.display="none";
    document.getElementById("si").style.display = "none";
    document.getElementById('usernameField').style.display='none';
  
  var startinterval;
  
  window.onload = function(){
    diff();
  }
  
  var lastInterval = getTime();
  setInterval(intervalHeartbeat, 1000);
  