<script>
    
    
    function checkFluency()
	{
		alert("Js imported!");
    }
    function changecheck(check_id)
    {            
        var check_idplus = check_id;
        var id = 'bdt'+check_id;
        var id2 = 'bdt'+check_idplus;
        if (document.getElementById(id2).checked == false)
        {
            // document.getElementById(id2).checked = true;
            document.getElementById(id2).value = '0';
        }
        else
        {
            // document.getElementById(id2).checked = false;
            document.getElementById(id2).value = '1';

        }

        // var check_idplus = check_id;
        // var id2 = 'bdt'+check_idplus;
        // if(document.getElementById(id2).checked == true){
        //     arr.push(check_id);
        //     // document.getElementById(id2).checked = false

        // }
        // // neu un check thi pop
        // else if(document.getElementById(id2).checked == false){
            
        //     var idx = arr.findIndex(e=> {return e == check_id})
            
        //     if(idx >=0){
        //         arr.splice(idx, 1)
        //     }
        // }
        // alert('xinchao');
        
    }
    function changecheck_hedt(check_id)
    {            
        var check_idplus = check_id;
        var id = 'hdt'+check_id;
        var id2 = 'hdt'+check_idplus;
        if (document.getElementById(id2).checked == false)
        {
            // document.getElementById(id2).checked = true;
            document.getElementById(id2).value = '0';
        }
        else
        {
            // document.getElementById(id2).checked = false;
            document.getElementById(id2).value = '1';

        }


        // var check_idplus = check_id;
        // var id2 = 'bdt'+check_idplus;
        // if(document.getElementById(id2).checked == true){
        //     arr.push(check_id);
        //     // document.getElementById(id2).checked = false

        // }
        // // neu un check thi pop
        // else if(document.getElementById(id2).checked == false){
            
        //     var idx = arr.findIndex(e=> {return e == check_id})
            
        //     if(idx >=0){
        //         arr.splice(idx, 1)
        //     }
        // }
        // alert('xinchao');
        
    }
    function changecheck1(check_id)
    {
        // var check_idplus = check_id + 1;
        // var id = 'bdt'+check_id;
        // var id2 = 'bdt'+check_idplus;
        // alert(id2);
        // if (document.getElementById(id2).checked == false)
        // {
        //     document.getElementById(id2).checked = true;
        // }
        // else
        // {
        //     document.getElementById(id2).checked = false;
        // }

        // alert(document.getElementById($check_id).checked);
        // Check
        
        // neu check thi push

        var check_idplus = check_id;
        var id2 = 'bdt'+check_idplus;
        if(document.getElementById(id2).checked == true){
            arr.push(check_id);
            // document.getElementById(id2).checked = false

        }
        // neu un check thi pop
        else if(document.getElementById(id2).checked == false){
            
            var idx = arr.findIndex(e=> {return e == check_id})
            
            if(idx >=0){
                arr.splice(idx, 1)
            }
        }
        alert('xinchao');
        
    }
    
</script>

