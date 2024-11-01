(()=>{"use strict";var e={n:t=>{var o=t&&t.__esModule?()=>t.default:()=>t;return e.d(o,{a:o}),o},d:(t,o)=>{for(var a in o)e.o(o,a)&&!e.o(t,a)&&Object.defineProperty(t,a,{enumerable:!0,get:o[a]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.React,o=window.wp.data,a=window.wp.components,l=window.wp.blockEditor,r=window.wp.serverSideRender;var i=e.n(r);(0,window.wp.blocks.registerBlockType)("jb-block/jb-jobs-list",{edit:function(e){const r=(0,l.useBlockProps)(),n=(0,o.useSelect)((e=>e("core").getEntityRecords("root","user",{per_page:-1,_fields:["id","name"]}))),s=(0,o.useSelect)((e=>e("core").getEntityRecords("taxonomy","jb-job-type",{per_page:-1,_fields:["id","name"]}))),b=(0,o.useSelect)((e=>e("core").getEntityRecords("taxonomy","jb-job-category",{per_page:-1,_fields:["id","name"]})));let d=e.attributes.user_id,c=[{id:"",name:""}],_=e.attributes.per_page,p=e.attributes.no_logo,u=e.attributes.hide_filled,h=e.attributes.hide_expired,j=e.attributes.hide_search,g=e.attributes.hide_location_search,w=e.attributes.hide_filters,m=e.attributes.hide_job_types,y=e.attributes.no_jobs_text,x=e.attributes.no_job_search_text,f=e.attributes.load_more_text,C=e.attributes.orderby,v=e.attributes.order,E=[{label:wp.i18n.__("Date","jobboardwp"),value:"date"},{label:wp.i18n.__("Title","jobboardwp"),value:"title"}],N=[{label:wp.i18n.__("Ascending","jobboardwp"),value:"ASC"},{label:wp.i18n.__("Descending","jobboardwp"),value:"DESC"}],A=e.attributes.type,S=[],k=e.attributes.category,T=[],H=e.attributes.filled_only,B="-hide",J="-hide";function P(e,t){let o=[];return"user"===t?e.map((function(e){o.push({label:e.name,value:e.id})})):"type"===t?e.map((function(e){o.push({label:e.name,value:e.id})})):"category"===t&&e.map((function(e){o.push({label:e.name,value:e.id})})),o}function Q(e,t,o,a,l,r,i,n,s,b,d,c,_,p,u,h,j){let g="[jb_jobs";return void 0!==e&&""!==e&&(g=g+' employer-id="'+e+'"'),void 0!==t&&""!==t&&(g=g+' per-page="'+t+'"'),g+=!0===o?' no-logo="1"':' no-logo="0"',g+=!0===a?' hide-filled="1"':' hide-filled="0"',g+=!0===l?' hide-expired="1"':' hide-expired="0"',g+=!0===r?' hide-search="1"':' hide-search="0"',g+=!0===i?' hide-location-search="1"':' hide-location-search="0"',g+=!0===n?' hide-filters="1"':' hide-filters="0"',g+=!0===s?' hide-job-types="1"':' hide-job-types="0"',void 0!==b&&""!==b&&(g=g+' no-jobs-text="'+b+'"'),void 0!==d&&""!==d&&(g=g+' no-jobs-search-text="'+d+'"'),void 0!==c&&""!==c&&(g=g+' load-more-text="'+c+'"'),void 0!==p&&""!==p&&(g=g+' type="'+p+'"'),void 0!==_&&""!==_&&(g=g+' category="'+_+'"'),void 0!==u&&(g=g+' orderby="'+u+'"'),void 0!==h&&(g=g+' order="'+h+'"'),g+=!0===j?' filled-only="1"':' filled-only="0"',g+="]",g}if(""===k&&(k=[]),""===A&&(A=[]),null!==n&&(c=c.concat(n)),null!==s&&(S=S.concat(s),0!==s.length&&""),null!==b&&(T=T.concat(b),0!==b.length&&(B="")),!c||!S||!T)return(0,t.createElement)("p",null,(0,t.createElement)(a.Spinner,null),wp.i18n.__("Loading...","jobboardwp"));if(0===c.length||0===S.length||0===T.length)return"No data.";let R=P(T,"category"),D=P(c,"user"),O=P(S,"type");return(0,t.createElement)("div",{...r},(0,t.createElement)(i(),{block:"jb-block/jb-jobs-list",attributes:e.attributes}),(0,t.createElement)(l.InspectorControls,null,(0,t.createElement)(a.PanelBody,{title:wp.i18n.__("Jobs list","jobboardwp")},(0,t.createElement)(a.SelectControl,{label:wp.i18n.__("Select employer","jobboardwp"),className:"jb_select_employer",value:e.attributes.user_id,options:D,style:{height:"35px",lineHeight:"20px",padding:"0 7px"},onChange:t=>{e.setAttributes({user_id:t}),Q(t,_,p,u,h,j,g,w,m,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.TextControl,{label:wp.i18n.__("Per page","jobboardwp"),className:"jb_per_page",type:"number",min:1,value:e.attributes.per_page,onChange:t=>{""===t&&(t=1),e.setAttributes({per_page:t}),Q(d,t,p,u,h,j,g,w,m,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.ToggleControl,{label:wp.i18n.__("Hide logo","jobboardwp"),className:"jb_no_logo",checked:e.attributes.no_logo,onChange:t=>{e.setAttributes({no_logo:t}),Q(d,_,t,u,h,j,g,w,m,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.ToggleControl,{label:wp.i18n.__("Hide filled","jobboardwp"),className:"jb_hide_filled",checked:e.attributes.hide_filled,onChange:t=>{e.setAttributes({hide_filled:t}),Q(d,_,p,t,h,j,g,w,m,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.ToggleControl,{label:wp.i18n.__("Hide expired","jobboardwp"),className:"jb_hide_expired",checked:e.attributes.hide_expired,onChange:t=>{e.setAttributes({hide_expired:t}),Q(d,_,p,u,t,j,g,w,m,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.ToggleControl,{label:wp.i18n.__("Hide search","jobboardwp"),className:"jb_hide_search",checked:e.attributes.hide_search,onChange:t=>{e.setAttributes({hide_search:t}),Q(d,_,p,u,h,t,g,w,m,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.ToggleControl,{label:wp.i18n.__("Hide location search","jobboardwp"),className:"jb_hide_location_search",checked:e.attributes.hide_location_search,onChange:t=>{e.setAttributes({hide_location_search:t}),Q(d,_,p,u,h,j,t,w,m,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.ToggleControl,{label:wp.i18n.__("Hide filters","jobboardwp"),className:"jb_hide_filters",checked:e.attributes.hide_filters,onChange:t=>{e.setAttributes({hide_filters:t}),Q(d,_,p,u,h,j,g,t,m,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.ToggleControl,{label:wp.i18n.__("Hide job types","jobboardwp"),className:"jb_hide_job_types",checked:e.attributes.hide_job_types,onChange:t=>{e.setAttributes({hide_job_types:t}),Q(d,_,p,u,h,j,g,w,t,y,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.TextControl,{label:wp.i18n.__("No jobs text","jobboardwp"),className:"jb_no_jobs_text",type:"text",value:e.attributes.no_jobs_text,onChange:t=>{e.setAttributes({no_jobs_text:t}),Q(d,_,p,u,h,j,g,w,m,t,x,f,k,A,C,v,H)}}),(0,t.createElement)(a.TextControl,{label:wp.i18n.__("No job search text","jobboardwp"),className:"jb_no_job_search_text",type:"text",value:e.attributes.no_job_search_text,onChange:t=>{e.setAttributes({no_job_search_text:t}),Q(d,_,p,u,h,j,g,w,m,y,t,f,k,A,C,v,H)}}),(0,t.createElement)(a.TextControl,{label:wp.i18n.__("Load more text","jobboardwp"),className:"jb_load_more_text",type:"text",value:e.attributes.load_more_text,onChange:t=>{e.setAttributes({load_more_text:t}),Q(d,_,p,u,h,j,g,w,m,y,x,t,k,A,C,v,H)}}),(0,t.createElement)(a.SelectControl,{label:wp.i18n.__("Select category","jobboardwp"),className:"jb_select_category"+B,value:k,options:R,multiple:!0,suffix:" ",style:{height:"35px",lineHeight:"20px",padding:"0 7px"},onChange:t=>{e.setAttributes({category:t}),Q(d,_,p,u,h,j,g,w,m,y,x,f,t,A,C,v,H)}}),(0,t.createElement)(a.SelectControl,{label:wp.i18n.__("Select type","jobboardwp"),className:"{'jb_select_type' + type_hide}",value:A,options:O,multiple:!0,suffix:" ",style:{height:"80px",overflow:"auto"},onChange:t=>{e.setAttributes({type:t}),Q(d,_,p,u,h,j,g,w,m,y,x,f,k,t,C,v,H)}}),(0,t.createElement)(a.SelectControl,{label:wp.i18n.__("Select order by","jobboardwp"),className:"jb_select_orderby",value:e.attributes.orderby,options:E,style:{height:"35px",lineHeight:"20px",padding:"0 7px"},onChange:t=>{e.setAttributes({orderby:t}),Q(d,_,p,u,h,j,g,w,m,y,x,f,k,A,t,v,H)}}),(0,t.createElement)(a.SelectControl,{label:wp.i18n.__("Select order","jobboardwp"),className:"jb_select_order",value:e.attributes.order,options:N,style:{height:"35px",lineHeight:"20px",padding:"0 7px"},onChange:t=>{e.setAttributes({order:t}),Q(d,_,p,u,h,j,g,w,m,y,x,f,k,A,C,t,H)}}),(0,t.createElement)(a.ToggleControl,{label:wp.i18n.__("Filled only","jobboardwp"),className:"jb_filled_only",checked:e.attributes.filled_only,onChange:t=>{e.setAttributes({filled_only:t}),Q(d,_,p,u,h,j,g,w,m,y,x,f,k,A,C,v,t)}}))))},save:function(e){return null}}),jQuery(window).on("load",(function(e){new MutationObserver((function(e){e.forEach((function(e){jQuery(e.addedNodes).find(".jb-jobs").each((function(){wp.JB.jobs_list.objects.wrapper=jQuery(".jb-jobs"),wp.JB.jobs_list.objects.wrapper.length&&wp.JB.jobs_list.objects.wrapper.each((function(){wp.JB.jobs_list.ajax(jQuery(this))}))})),jQuery(e.addedNodes).find(".jb").each((function(){jb_responsive()}))}))})).observe(document,{attributes:!1,childList:!0,characterData:!1,subtree:!0})}))})();