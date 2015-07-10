<script  id="inviteUserList_render" type="text/x-jsrender">
<div style="position: relative">

        <div  class="block">
       <table cellspacing="0" cellpadding="0" width="100%" border="0" class="dtb_header">

                    <thead><tr><th class="customcheckthall"><input type="checkbox" name="userallcheck" class="styled" />All</th><th class="data_t_hide">Name</th><th class="data_t_hide">Email</th></tr></thead>
                    <tbody>
                        <tr id="noRecordsTR" style="display: none">
                            <td colspan="8">
                                <span class="text-error"> <b>No records found</b></span>
                            </td>
                        </tr>
                        {{for data.data}}    
                        <tr class="{{if (#index)%2==0}} even {{else}} odd {{/if}}">
                            <td class="UserTd" id="UserId_{{>UserId}}">
                                 
                        <input type="checkbox" name="usercheck" data-id="{{>UserId}}" class="styled" value="{{>UserId}}" />
                            </td>  
                            <td  class="data_t_hide">
                                {{>FirstName}} {{>LastName}} 
                            </td>
                            <td  class="data_t_hide">
                                {{>Email}} 
                            </td>

                </tr>

                {{/for}}
            </tbody>

        </table>

        <div class="pagination pagination-right">
            <div id="pagination"></div>  

        </div>




    </div>        

</div>


</script>


