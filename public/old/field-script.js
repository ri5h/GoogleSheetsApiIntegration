function updateField(field){
  
    var base1 = document.getElementById("base-1")
    var base2 = document.getElementById("base-2")
    var base3 = document.getElementById("base-3")
    
    base1.classList.remove("active")
    base2.classList.remove("active")
    base3.classList.remove("active")
  
    if(field.base1) base1.classList.add("active")
    if(field.base2) base2.classList.add("active")
    if(field.base3) base3.classList.add("active")
    
  }

  window.addEventListener('load', (event) => {

    var chk_b_1 = (document.getElementById("chk_b_1").innerHTML == true);
    var chk_b_2 = (document.getElementById("chk_b_2").innerHTML == true);
    var chk_b_3 = (document.getElementById("chk_b_3").innerHTML == true);
  
    updateField({
        base1:chk_b_1,
        base2:chk_b_2,
        base3:chk_b_3
    });
        
  });
