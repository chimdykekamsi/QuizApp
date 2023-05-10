


  

   function modal() {
       document.querySelector('.modal').style.display = 'block';
   }

   function closeModal() {
       document.querySelector('.modal').style.display = 'none';
      // alert("hello")
   }
   let page =  Array();
   function openCity(cityName,elmnt) {
    
    page.push(elmnt);
    
   
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(cityName).style.display = "block"; 

    if (page[page.length - 1] == page[page.length - 2]) {
      page[page.length - 1].style.fontWeight = 'bolder';
      page[page.length - 1].style.color = 'white';
     page[page.length - 1].style.fontSize = 'large';
    }else{
      page[page.length - 1].style.fontWeight = 'bolder';
      page[page.length - 1].style.color = 'white';
     page[page.length - 1].style.fontSize = 'large';

     page[page.length - 2].style.fontWeight = 'normal';
      page[page.length - 2].style.color = 'black';
     page[page.length - 2].style.fontSize = '17px';
    }
   
  }
  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();