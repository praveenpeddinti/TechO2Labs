<script id="pageAnalyticsTmpl" type="text/x-jsrender"> 
      {{for data}}
{{>percentage}}
      {{for PagesAnalyticsData}}

                               <div class="customrows">
                                     <div class="customcolumns">{{>PageNumber}}</div>

                                     <div class="customcolumns aligncenter">{{>timeSpentString}}</div>
                                      <div class="customcolumns" style="text-align: center">
                                {{>Percentage}}% </div>
                        </div>
                {{/for}}
    {{/for}}
    </script>