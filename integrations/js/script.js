function confirmAge(){
    var d = new Date();
    //var time_stmp = Math.round(d.getTime()/1000);
    var now_us = d.getTime();
    
    
    var myDate=document.getElementById('day').value +"-"+ document.getElementById('mon').value +"-"+ document.getElementById('yer').value;
    myDate=myDate.split("-");
    var newDate=myDate[1]+"/"+myDate[0]+"/"+myDate[2];
    var date_us=new Date(newDate).getTime();
    
    var age_us=(now_us-date_us)/(1000*356*24*3600);
    
    
    if(age_us<18){
        alert("You must be 18 years of age to see this site.");
        return false;
    }
    else
        document.getElementById('ac-wrapper').style.display="none"; 
    
    location.href="index.html";
       }
