/** 
 * constants
 */
const br = "\n";
const firstSentence = br+"<!--【START】hooked by WP Plugin: Sugoi Tag Inserter -->" +br;
const lastSentence = "<!--【END】hooked by WP Plugin: Sugoi tag inserter-->" +br;

/** 
 * check if those radio buttons should be enabled or not 
 */
window.addEventListener('load', ()=>{
  jQuery(function(){
      init();
      listenEvents();
  });
});

function init(){
  let gtmEnabled = document.getElementById('gtm-yes').checked
  let awEnabled = document.getElementById('aw-yes').checked
  let gaEnabled = document.getElementById('ga-yes').checked;
  let cdEnabled = document.getElementById('sugotag-cross-domain-checkbox').checked
  if(!gtmEnabled){
    jQuery('#gtm-id-input').addClass('disabled');
  } 
  if(!awEnabled){
    jQuery('#aw-id-input').addClass('disabled');
  }
  if(!gaEnabled){
    jQuery('#ga-id-input').addClass('disabled');
  }
  if(!cdEnabled){
    jQuery('.cross-domain-id-input').addClass('disabled');
  }
};

function listenEvents(){

  // on submit
  jQuery(document).submit(function(e) {
      insertHiddenScripts();
      decorateCustomScripts();
      checkEmptyString();
      checkCrossDomainSetting();
      return true; // return false to cancel form action
  });
    
  // cross domain setting check box on change
  jQuery('input:checkbox').on('change', function(e){
    let id = e.target.id;
    if(!e.target.checked){
      jQuery('.cross-domain-id-input').addClass('disabled');
    } else if(e.target.checked){
      jQuery('.cross-domain-id-input').removeClass('disabled');
   }
  });
    
  // GTM, GA, Google Ads settings on change
  jQuery('input:radio').on('change', function(e){
    let target = e.target;
    let id = e.target.id;
    let prefix = id.substring(0, id.indexOf('-'));
    let inputId = '#'+prefix+'-id-input';
    if(id.includes('no')){
      jQuery(inputId).addClass('disabled');
    } else if (id.includes('yes')){
      jQuery(inputId).removeClass('disabled');
    } 
  // check if cross domain setting should be disabled
  checkCrossDomainSetting();
  });
};

function checkCrossDomainSetting(){   
  let awEnabled = document.getElementById('aw-yes').checked
  let gaEnabled = document.getElementById('ga-yes').checked;
  if(!awEnabled && !gaEnabled){
    jQuery('.cross-domain-id-input').addClass('disabled');
    jQuery('#sugotag-cross-domain-checkbox').removeAttr('checked');
  }  
};

function decorateCustomScripts(){
  let $customHeader =document.getElementById('sugotag_insert_header');
  if($customHeader.value && !$customHeader.value.includes("WP Plugin: Sugoi Tag Inserter")){
    $customHeader.value = 
      firstSentence + 
      $customHeader.value + br +
      lastSentence;
  }
  let $customFooter =document.getElementById('sugotag_insert_footer');
  if($customFooter.value &&!$customFooter.value.includes("WP Plugin: Sugoi Tag Inserter")){
    $customFooter.value = 
      firstSentence + 
      $customFooter.value+ + br +
      lastSentence;        
  }
};

function checkEmptyString(){
  let gtmid = document.getElementById('gtm-id-input').value;
  if(gtmid.indexOf(' ')!==-1){
    gtmid.replace(' ', '');
  } 
  if(gtmid.indexOf('　')!==-1){
    gtmid.replace('　', '');
  }

  let awid = document.getElementById('aw-id-input').value;
  if(awid.indexOf(' ')!==-1){
    awid.replace(' ', '');
  } 
  if(awid.indexOf('　')!==-1){
    awid.replace('　', '');
  }
  
  let gaid = document.getElementById('ga-id-input').value;
  if(gaid.indexOf(' ')!==-1){
    gaid.replace(' ', '');
  } 
  if(gaid.indexOf('　')!==-1){
    gaid.replace('　', '');
  }
};

function insertHiddenScripts(){
  let gtmid = document.getElementById('gtm-id-input').value;
  let awid = document.getElementById('aw-id-input').value;
  let gaid = document.getElementById('ga-id-input').value;

  let gtmEnabled = document.getElementById('gtm-yes').checked
  let awEnabled = document.getElementById('aw-yes').checked
  let gaEnabled = !!document.getElementById('ga-yes').checked;

  let cdEnabled = document.getElementById('sugotag-cross-domain-checkbox').checked
  let firstDomain = document.getElementById('sugotag-cross-domain-1st').value;
  let secondDomain = document.getElementById('sugotag-cross-domain-2nd').value;
  
  let declairDataLayer = !!cdEnabled ?
  "<script>\n"+
  "window.dataLayer = window.dataLayer || [];\n"+
  "function gtag(){dataLayer.push(arguments);}\n"+
  "gtag('set', 'linker', {\n"+
  "  'domains': ['"+ firstDomain +"', '"+ secondDomain +"'],\n" +
  "  'decorate_forms': true\n" +
  "});\n" +
  "gtag('js', new Date());\n":

  "<script>\n"+
  "window.dataLayer = window.dataLayer || [];\n"+
  "function gtag(){dataLayer.push(arguments);}\n"+
  "gtag('js', new Date());\n";
  
  const $hiddenHeader = document.getElementById('sugotag-insert-hidden-header');
  const $hiddenFooter = document.getElementById('sugotag-insert-hidden-footer');
  let headerScript ='';
  let footerScript ='';


  if(gtmEnabled){
    headerScript = 
    firstSentence +
    "<!-- Google Tag Manager -->\n" +
    "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':\n"+
    "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],\n"+
    "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=\n"+
    "'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);\n"+
    "})(window,document,'script','dataLayer', '"+ gtmid+"');</script>\n" +
    "<!-- End Google Tag Manager -->\n" +
    lastSentence;

    // for Footer
    footerScript = 
    firstSentence +
    "<!-- Google Tag Manager (noscript) -->\n"+
    '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' + gtmid +'"\n'+
    'height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>\n'+
    "<!-- End Google Tag Manager (noscript) -->\n" +
    lastSentence;

  } 
  if (awEnabled&& !gaEnabled){
    headerScript = headerScript +
    firstSentence +
    "<!-- Google Ads/Google Analytics Global site tag (gtag.js) -->\n"+
    '<script async src="https://www.googletagmanager.com/gtag/js?id='+ awid +'"></script>\n'+
    declairDataLayer +
    "gtag('config', '"+ awid +"');\n"+
    "</script>\n"+
    lastSentence;

  } else if (!awEnabled&& gaEnabled){
    headerScript = headerScript + 
    firstSentence +
    "<!-- Google Ads/Google Analytics Global site tag (gtag.js) -->\n"+
    '<script async src="https://www.googletagmanager.com/gtag/js?id=' + gaid +'"></script>\n' +
    declairDataLayer +
    "gtag('config', '"+ gaid +"');\n"+
    "</script>\n"+
    lastSentence;
  } else if (awEnabled && gaEnabled) {
    headerScript = headerScript + 
    firstSentence +
    "<!-- Google Ads/Google Analytics Global site tag (gtag.js) -->\n"+
    '<script async src="https://www.googletagmanager.com/gtag/js?id='+awid +'"></script>\n'+
    declairDataLayer +
    "gtag('config', '"+ awid +"');\n"+
    "gtag('config', '"+ gaid +"');\n"+
    "</script>\n"+
    lastSentence;
  }
  $hiddenHeader.innerHTML = headerScript;
  $hiddenFooter.innerHTML = footerScript;
};