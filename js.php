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

    // Các hàm xử lí sự kiện khi check vào checkbox
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

    function changecheck_muctieumonhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'muctieumonhoc'+check_id;
        var id2 = 'muctieumonhoc'+check_idplus;
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

    function changecheck_kehoachgiangday_LT(check_id)
    {            
        var check_idplus = check_id;
        var id = 'kehoachgiangday_LT'+check_id;
        var id2 = 'kehoachgiangday_LT'+check_idplus;
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

    function changecheck_danhgiamonhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'danhgiamonhoc'+check_id;
        var id2 = 'danhgiamonhoc'+check_idplus;
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

    function changecheck_tainguyenmonhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'tainguyenmonhoc'+check_id;
        var id2 = 'tainguyenmonhoc'+check_idplus;
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

    function changecheck_quydinhchung_monhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'quydinhchung_monhoc'+check_id;
        var id2 = 'quydinhchung_monhoc'+check_idplus;
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
    
    function changecheck_monhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'monhoc'+check_id;
        var id2 = 'monhoc'+check_idplus;
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
	function changecheck_listmonthuockhoi(check_id)
    {
        var id = 'kktlistmon' + check_id;
        if (document.getElementById(id).checked == false)
        {
            document.getElementById(id).value = '0';
        }
        else
        {
            document.getElementById(id).value = '1';
        }
    }

    function changecheck_decuongmonhoc(check_id)
    {            
        var check_idplus = check_id;
        var id = 'decuongmonhoc'+check_id;
        var id2 = 'decuongmonhoc'+check_idplus;
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
	// Caykkt
	function changecheck_checkbox_addcaykkt(check_id)
    {
        var id = 'addcaykkt' + check_id;
        if (document.getElementById(id).checked == false)
        {
            document.getElementById(id).value = '0';
        }
        else
        {
            document.getElementById(id).value = '1';
        }
    }
   
    function changecheck_quyen(check_id) {
        var check_idplus = check_id;
        var id2 = check_idplus;
        if (document.getElementById(id2).checked == false) {
            // document.getElementById(id2).checked = true;
            document.getElementById(id2).value = '0';

        } else {
            // document.getElementById(id2).checked = false;
            document.getElementById(id2).value = '1';

        }
    }
</script>

