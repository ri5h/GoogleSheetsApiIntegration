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
  
  function updateUI(){  
    var ck_base_1 = document.getElementById("ck_b_1").checked;
    var ck_base_2 = document.getElementById("ck_b_2").checked;
    var ck_base_3 = document.getElementById("ck_b_3").checked;
    
    var field = {
      base1:ck_base_1,
      base2:ck_base_2,
      base3:ck_base_3
    }
    
    updateField(field);
  }
  

  window.addEventListener('load', (event) => {
    console.log('page is fully loaded');
    
    // Input for testing
    var ck_base_1 = document.getElementById("ck_b_1");
    ck_base_1.addEventListener( 'change', () => updateUI());
    
    var ck_base_2 = document.getElementById("ck_b_2");
    ck_base_2.addEventListener( 'change', () => updateUI());
    
    var ck_base_3 = document.getElementById("ck_b_3");
    ck_base_3.addEventListener('change', () => updateUI())
    
    
    //default state
    updateField({
        base1:true,
        base2:false,
        base3:true
    });
        
  });
