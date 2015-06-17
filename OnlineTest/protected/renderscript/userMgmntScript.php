<script  id="contactlistTmp_render" type="text/x-jsrender">
<div style="position: relative">

        <div  class="block">
 
            <div  class="tablehead tableheadright pull-right">
            <div  id="addNewAdminMessage"  onclick="newEmployersPopup()"  style="cursor: pointer;position: absolute;left: 8px;margin-top: 3px;"><i data-toggle="tooltip" title="add new Test taker" rel="tooltip"  class="add">&nbsp;</i></div>
            <div class="tabletopcorner">
                 <input type="text" placeholder="search"  class="textfield textfieldsearch " id="searchTextId" onkeypress="return searchAUser(event)" />
                             </div>
                  <div class="tabletopcorner">
                 <select id="filter" class="styled textfield textfielddatasearch">
                    <option value="all">
                        All
                    </option>
                    <option value="active">
                        Active
                    </option>
                    <option value="inprogress">
                        Inprogress
                    </option>
                    <option value="suspended">
                        Suspended
                    </option> 
                  <option value="reject">
                        Rejected
                    </option>
                    <option value="countryChange">
                        Country Changed
                    </option>
                </select>
                </div>
                 <div class="btn-group pagesize tabletopcorner tabletopcornerpaddingtop">
                <button data-toggle="dropdown" style="position:static" class="btn btn-mini dropdown-toggle" data-placement="top">Page size<span class="caret"></span></button>
                <ul class="dropdown-menu" style="min-width:70px;">
                    <li><a href="#" id="pagesize_5" onclick="setPageLength(5,'usermanagement')">5</a></li>
                    <li><a href="#" id="pagesize_10" onclick="setPageLength(10,'usermanagement')">10</a></li>
                    <li><a href="#" id="pagesize_15" onclick="setPageLength(15,'usermanagement')">15</a></li>                  
                </ul>
            </div>
            
            <div class="tabletopcorner tabletopcornerpaddingtop">
            <div class="label label-warning record_size" >+
                {{for data.total}}
                    {{>totalCount}}
                {{/for}} 
            </div>
            </div>
            </div>
            <a class="block-heading" data-toggle="collapse">&nbsp;</a>
            <div id="tablewidget" style="margin: auto;">



                <span id="spinner_admin"></span>
                <table class="table table-hover">

                    <thead><tr><th>Name</th><th class="data_t_hide">Email</th><th class="data_t_hide">Phone</th><th class="data_t_hide">Registered Date</th><th>Actions</th></tr></thead>
                    <tbody>
                        <tr id="noRecordsTR" style="display: none">
                            <td colspan="8">
                                <span class="text-error"> <b>No records found</b></span>
                            </td>
                        </tr>
                        {{for data.data}}    
                        <tr class="odd">
                            <td>
                                {{>LastName}} {{>FirstName}} 
                            </td>  
                            <td  class="data_t_hide">
                                {{>Email}}
                            </td>
                           <td  class="data_t_hide">
                                {{>Phone}}
                            </td>
                           
                            
                           
                            <td class="data_t_hide">                          
                                {{>RegistredDate}}   
                            </td>
                            

                    <td>                         
                        <a rel="tooltip" style="cursor: pointer;" onclick="viewAUserDetailsById('{{>UserId}}')" role="button"  data-toggle="tooltip" title="View" > <i class="icon-place-view"></i></a> 
                        <span class="adminDropDownParent" rel="tooltip" style="cursor: pointer;" title="Change Role">
                            <i data-placement="right" data-toggle="dropdown" class="icon-place-changerole"></i>
                            <div id="ChangeRoleDropDown" class="dropdown-menu adminDropDown adminDropDownAlign" role="menu">
                                 <ul id="ChangeRoleDropDown_{{>UserId}}">
                                 {{for #parent.parent.data.data.userTypes}}
                                     {{if #parent.parent.data.UserTypeId==Id}}
                                    <li class="active"><a class="Filter" data-userId="{{>#parent.parent.parent.data.UserId}}" data-roleId = "{{>Id}}">{{>Name}}</a></li>   
                                    {{else}}
                                    <li><a class="Filter" data-userId="{{>#parent.parent.parent.data.UserId}}" data-roleId = "{{>Id}}">{{>Name}}</a></li>   
                                    {{/if}}
                                {{/for}}


                                 </ul>
                                </div>
                        </span>
                         
                        
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

</div>
</script>

<script  id="userView_render" type="text/x-jsrender">
    {{for data.tinyUserCollectionData}} 
     
     <div class="row-fluid">
         
             
             
                 {{/for}} 
             </div>
             
               <div class="span8">
                  <table cellspacing="1"  cellpadding="3" border="0" class="charttable3" >
                            
                   <tbody>
                        {{for data}}
                            {{for data}}
                            <tr>
                                <td class="l_label">Name</td>
                                <td class="t_b ">: {{>FirstName}} {{>LastName}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">Email </td>
                                <td class="t_b ">: {{>Email}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">Phone  </td>
                                <td class="t_b "> : {{>Phone}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">Qualification  </td>
                                <td class="t_b "> : {{>Qualification}}</td>
                            </tr>       {{/for}}
                                
                            </tbody></table>  
                            
                   
                   
             </div>
         </div>
     </div>
     
     
           
</script>
