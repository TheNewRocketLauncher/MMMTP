<script>

    function myFunctionToDoSomething() {
        // alert('Say hi!');
        // var sel = document.getElementById('id_maheplus');
        // var opts = sel.options;
        // for (var opt, j = 0; opt = opts[j]; j++) {
        //     if (1) {
        //         document.getElementById('id_maheplus').selectedIndex = 4;
        //     break;
        //     }
        // }
        alert('capcap');

        var x = document.getElementById('id_maheplus');
        // Remove all options
        while(x.length > 0){
            x.remove(x.length-1);
        }
        // Add new options , tim theo bac
        var option = document.createElement("option");
        option.text = "Kiwisss44";
        // x.add(option);
    }
    
    
    function checkFluency()
	{
		alert("Js imported!");
    }

    // C�c h�m x? l� s? ki?n khi check v�o checkbox
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
    }

    function changecheck_muctieu_monhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'muctieu_monhoc'+check_id;
        var id2 = 'muctieu_monhoc'+check_idplus;
        if (document.getElementById(id2).checked == false)
        {
            // document.getElementById(id2).checked = true;
            // alert('unchecked');
            document.getElementById(id2).value = '0';
        }
        else
        {
            // document.getElementById(id2).checked = false;
            // alert('checked');

            document.getElementById(id2).value = '1';

        }        
    }

    function changecheck_chuandaura_monhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'chuandaura_monhoc'+check_id;
        var id2 = 'chuandaura_monhoc'+check_idplus;
        if (document.getElementById(id2).checked == false)
        {
            // document.getElementById(id2).checked = true;
            // alert('unchecked');
            document.getElementById(id2).value = '0';
        }
        else
        {
            // document.getElementById(id2).checked = false;
            // alert('checked');

            document.getElementById(id2).value = '1';

        }        
    }

    function changecheck_kehoach_giangday_LT(check_id)
    {            
        var check_idplus = check_id;
        var id = 'kehoach_giangday_LT'+check_id;
        var id2 = 'kehoach_giangday_LT'+check_idplus;
        if (document.getElementById(id2).checked == false)
        {
            // document.getElementById(id2).checked = true;
            // alert('unchecked');
            document.getElementById(id2).value = '0';
        }
        else
        {
            // document.getElementById(id2).checked = false;
            // alert('checked');

            document.getElementById(id2).value = '1';

        }        
    }

    function changecheck_danhgia_monhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'danhgia_monhoc'+check_id;
        var id2 = 'danhgia_monhoc'+check_idplus;
        if (document.getElementById(id2).checked == false)
        {
            // document.getElementById(id2).checked = true;
            // alert('unchecked');
            document.getElementById(id2).value = '0';
        }
        else
        {
            // document.getElementById(id2).checked = false;
            // alert('checked');

            document.getElementById(id2).value = '1';

        }        
    }

    function changecheck_tainguyen_monhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'tainguyen_monhoc'+check_id;
        var id2 = 'tainguyen_monhoc'+check_idplus;
        if (document.getElementById(id2).checked == false)
        {
            // document.getElementById(id2).checked = true;
            // alert('unchecked');
            document.getElementById(id2).value = '0';
        }
        else
        {
            // document.getElementById(id2).checked = false;
            // alert('checked');

            document.getElementById(id2).value = '1';

        }        
    }

    function changecheck_quydinh_chung_monhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'quydinh_chung_monhoc'+check_id;
        var id2 = 'quydinh_chung_monhoc'+check_idplus;
        if (document.getElementById(id2).checked == false)
        {
            // document.getElementById(id2).checked = true;
            // alert('unchecked');
            document.getElementById(id2).value = '0';
        }
        else
        {
            // document.getElementById(id2).checked = false;
            // alert('checked');

            document.getElementById(id2).value = '1';

        }        
    }

    function changecheck_nganhdt(check_id)
    {            
        var check_idplus = check_id;
        var id = 'nganhdt'+check_id;
        var id2 = 'nganhdt'+check_idplus;
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

        
    }

    function changecheck_chuyennganhdt(check_id)
    {            
        var check_idplus = check_id;
        var id = 'chuyennganhdt'+check_id;
        var id2 = 'chuyennganhdt'+check_idplus;
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

        
    }
   
    
</script>

