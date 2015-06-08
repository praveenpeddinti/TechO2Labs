<script  id="contactlistTmp_render" type="text/x-jsrender">
<div style="position: relative">

        <div  class="block">
 
            <div  class="tablehead tableheadright pull-right">
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

                    <thead><tr><th>Name</th><th class="data_t_hide">Email</th><th class="data_t_hide">Segment</th><th  class="data_t_hide">User Type</th><th>Status</th><th class="data_t_hide">Registered Date</th><th>Actions</th></tr></thead>
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
                                {{>SegmentName}}
                            </td>
                            <td id="usertype_{{>UserId}}"  class="data_t_hide">
                                {{>UserType}}
                            </td>
                            <td>
                                                
                                <div id="usrMgmnt_{{>UserId}}">
                                
                                    {{if Status == 1}}
                                        Active
                                    {{else Status == 2}}
                                        Suspended
                                    {{else Status == 0}}
                                        Inprogress
                                    {{else Status == 3}}
                                        Rejected
                                    {{/if}}

                                </div>   
                                <div id="usrMgmnt_edit_{{>UserId}}" style="display: none" class="changestatus">
                                <div class="positionrelative" style="width:120px;">
                                 {{if Status != 3}}
                                    <select style="width:120px;" id="statusType" class="styled" data-userid="{{>UserId}}" name="usrMgmntselect_{{>UserId}}" id="usrMgmntselect_{{>UserId}}" >
                                                    {{if Status == 1}}
                                                        <option value="1" selected>
                                                                Active
                                                        </option>
                                                        <option value="2"> 
                                                                Suspend
                                                        </option>
                                                    {{else Status == 2}}
                                                    <option value="2" selected>
                                                            Suspended
                                                    </option>
                                                    <option value="1"> 
                                                            Active
                                                    </option>
                                                    {{else Status == 0}}
                                                    <option value="0" selected>
                                                            InProgress
                                                    </option>
                                                    <option value="1"> 
                                                            Active
                                                    </option>
                                                    <option value="3" > 
                                                            Reject
                                                    </option>
                                            {{/if}}
                                       
                                       
                                       
                                       
                                       
                                    </select>
                              {{/if}}
                            </div>
                                </div>
                        
                            </td>
                           
                            <td class="data_t_hide">                          
                                {{>RegistredDate}}   
                            </td>
                            

                    <td>                         
                        <a rel="tooltip" style="cursor: pointer;" onclick="viewAUserDetailsById('{{>UserId}}')" role="button"  data-toggle="tooltip" title="View" > <i class="icon-place-view"></i></a> 
                        {{if Status != 3}}                
                            <a rel="tooltip" style="cursor: pointer;" onclick="changeStatus('{{>UserId}}','status')" role="button"  data-toggle="tooltip" title="Change Status" > <i class="icon-place-renewstatus"></i></a> 
                            
                         {{/if}}
                         {{if Status == 1 || Status == 2}}
                         <a rel="tooltip" style="cursor: pointer;" onclick="getUserPreveligesByType({{>UserId}},{{>UserTypeId}})" role="button"  data-toggle="tooltip" title="Advanced" > <i class="icon-place-changestatus"></i></a> 
                         {{/if}}
                            <a rel="tooltip" style="cursor: pointer;" onclick="changeUserType('{{>UserId}}','{{>UserIdentityType}}')" role="button"  data-toggle="tooltip" title="Change UserType" > <i class="icon-place-changeuserIdentity"></i></a> 
                         {{if CountryRequest == 1}}                
                            <a rel="tooltip" style="cursor: pointer;" id="countryChangeLink_{{>UserId}}" onclick="countryChangePopup('{{>UserId}}')" role="button"  data-toggle="tooltip" title="Country Changed" > <i class="icon-place-changecountry"></i></a> 
                            
                         {{/if}}

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
                         
                        <!--
                        <a rel="tooltip" style="cursor: pointer;" onclick="deleteContact('{{>UserId}}')" role="button"  data-toggle="tooltip" title="Delete" id="removedHrefId"> <i class="icon-place-delete"></i></a>           
                       
                        
                         <a rel="tooltip" style="cursor: pointer;" onclick="viewContactDetailsById('{{>Id}}')" role="button"  data-toggle="tooltip" title="View" > <i class="icon-place-view"></i></a> 

                        <a rel="tooltip" style="cursor: pointer;" onclick="changeStatus('{{>Id}}','status')" role="button"  data-toggle="tooltip" title="Change Status" > <i class="icon-place-renewstatus"></i></a> 

                        <a rel="tooltip" style="cursor: pointer;" onclick="deleteContact('{{>Id}}')" role="button"  data-toggle="tooltip" title="Delete" id="removedHrefId"> <i class="icon-place-delete"></i></a>           
                        -->
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
         <div class="span12">
             
             <div class="span4" style="position:relative">
                 {{if profile250x250 !=null && profile250x250 !='' }} 
                    <img  src="{{>profile250x250}}" style="width: 100%" /> 
                  {{else}}
             <img  src="/images/icons/user_noimage.png" style="width: 100%" />
               {{/if}}
               <img  src="/images/segment_flags/{{>#parent.data.data.segmentObj.SegmentFlag}}" class="image-ove-image" /> 
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
                                <td class="l_label">DisplayName  </td>
                                <td class="t_b "> : {{>DisplayName}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">Company </td>
                                <td class="t_b ">: {{>Company}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">Email </td>
                                <td class="t_b ">: {{>Email}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">City </td>
                                <td class="t_b ">: {{>City}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">State </td>
                                <td class="t_b ">: {{>State}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">Country </td>
                                <td class="t_b ">: {{>Name}}</td>
                            </tr>
                            <tr>
                                <td class="l_label">Zip </td>
                                <td class="t_b ">: {{>Zip}}</td>
                            </tr>                           
                            <!--tr>
                                <td class="l_label"></td>
                                <td class="t_b ">
                                    {{if Sex == 1}}
                                        Male
                                     {{else}}
                                        Female
                                        {{/if}}
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="l_label">Age</td>
                                <td class="t_b ">
                                    {{>age}}
                                </td>
                            </tr -->                           
                             
                            
                             <tr>
                                <td class="l_label">Pharmacist </td>
                                <td class="t_b ">:{{if IsPharmacist == 0}} No {{else IsPharmacist == 1}} Yes {{/if}}</td>
                            </tr>
                           
                            <tr>
                                      {{if HavingNPINumber == 1}}
                                 <td class="l_label">NPI Number </td>
                                <td class="t_b ">: {{>NPINumber}}</td>
                                    {{else}}
                                    <td class="l_label">State License Number </td>
                                <td class="t_b ">: {{>LicensedNumber}}</td>
                                       {{/if}}
                                
                             </tr>
                          
                                                 
                                    
                            <tr>
                            {{if PrimaryAffiliation != 'Other' && PrimaryAffiliation != "" && PrimaryAffiliation != null && PrimaryAffiliation != 'null'}}
                                <td class="l_label">Primary Affiliation </td>
                                <td class="t_b ">: {{>Value}}
                                </td>
                                {{else OtherAffiliation != "" && OtherAffiliation != null && OtherAffiliation != 'null'}}
                                <td class="l_label">Other Affiliation </td>
                                <td class="t_b ">: {{>OtherAffiliation}}</td>
                             {{/if}}
                            </tr>
                            <tr>
                                <td class="l_label">Status </td>
                                <td class="t_b ">: {{if Status == 0}} Inprogress {{else Status == 1}} Active {{else Status == 2}} Suspended {{/if}}</td>
                            </tr>
                                    
                                            {{/for}}
                                
                            </tbody></table>  
                            
                   
                   
             </div>
         </div>
     </div>
     
     
           
</script>
