<script  id="usersettings_render" type="text/x-jsrender">
<div style="position: relative">
        <div  class="block">
            <div class="block-heading" data-toggle="collapse"><?php echo Yii::t('translation','User_Preveliges'); ?></div>
            <div id="tablewidget" class="block-body collapse in " style="margin: auto;">
                <table class="table table-hover">                    
                    <tbody>                        
                        {{for data.data}}    
                            <tr class="odd">
                                        <input type="hidden" value="{{>UserId}}" id="settingUserId"/>
                                <td>
                                    {{>DisplayLabel}} 
                                </td>
                                <td>                          
                                  <input type="checkbox" name="actionItem" value="{{>Id}}"{{if Status == 1}} checked {{/if}} id="{{>Id}}" />
                                </td>
                            </tr>
                        {{/for}}
                    </tbody>
                </table>
              </div>
</div>

</div>
</script>