/* should include jquery b4 this code*/
/*FVC = formValidatorClass*/
$.ajaxSetup ({  
        cache: false,
        async: false
    }); 



var FVC = function()
{
    
};
var dup = 'no';

FVC.prototype.checkIfExistTest = function(field,valtocheck,db_field,pd_base)
{
    
    
    
        
        
        /*do an ajax call */
        $.get(
                           pd_base+'/html/script/check.php',{tocheck:valtocheck,dtype:'duplicate',db_field:db_field},function(data,status,dxhr)
                           {
                            if (status == 'success')
                            {
                              dup = data;
                              
                                
                            }
                           }
                           
                );
        
        return dup;
        
        
        
    
}

FVC.prototype.CheckIfEmpty = function()
{
    //function that checks if input is empty
    //$('span[id^="msg"]').html('<em style="display:none">Please fill this field.</em>');
    
    
    //first clear all errors left
    var emptyfields = "";

    $('.req').each(function(n)
                   {
                    if (this.value == '')
                    {
                        
                     emptyfields = emptyfields + n;
                     
                    }
                   }
                   );
    emptyfields = emptyfields.toString();
    emptyfields = emptyfields.split('');
    if (emptyfields.length == 0)
    {
        
        //no empty fields
        //remove previous messages
        return "noerror";
    }
    else
    {
        //put the message
        for (m in emptyfields)
        {
            
            
            var idname = 'msg_' + $('.req')[emptyfields[m]].id.replace(" ","_");
            $('span#' + idname).css('display','inline');
            $('span#' + idname).html('<em style="color:red">Please fill this field.</em>');
            
        }
        
        
        
        //prevent from sending
        //send true coz empty field was found
        return "error";
        
    }
    
}      

