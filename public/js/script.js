
$('#myTab a').click(function(e) {
    e.preventDefault();
    $(this).tab('show');
  });
  
  // store the currently selected tab in the hash value
  $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;
  });
  
  // on load of the page: switch to the currently selected tab
  var hash = window.location.hash;
  $('#myTab a[href="' + hash + '"]').tab('show');

  ClassicEditor
  .create( document.querySelector( '#editor' ) )
  .catch( error => {
      console.error( error );
  } );


$('#myTab a').click(function(e) {
e.preventDefault();
$(this).tab('show');
});

// store the currently selected tab in the hash value
$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
var id = $(e.target).attr("href").substr(1);
window.location.hash = id;
});

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
$('#myTab a[href="' + hash + '"]').tab('show');

ClassicEditor
.create( document.querySelector( '#editor' ) )
.catch( error => {
  console.error( error );
} );
ClassicEditor
.create( document.querySelector( '#editor2' ) )
.catch( error => {
  console.error( error );
} );
ClassicEditor

.create( document.querySelector( '#editor3' ) )
.catch( error => {
  console.error( error );
} );

ClassicEditor

.create( document.querySelector( '#editor4' ) )
.catch( error => {
  console.error( error );
} );

if (location.hash) {
  $('a[href=\'' + location.hash + '\']').tab('show');
}
var activeTab = localStorage.getItem('activeTab');
if (activeTab) {
  $('a[href="' + activeTab + '"]').tab('show');
}

$('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
  e.preventDefault()
  var tab_name = this.getAttribute('href')
  if (history.pushState) {
    history.pushState(null, null, tab_name)
  }
  else {
    location.hash = tab_name
  }
  localStorage.setItem('activeTab', tab_name)

  $(this).tab('show');
  return false;
});
$(window).on('popstate', function () {
  var anchor = location.hash ||
    $('a[data-toggle=\'tab\']').first().attr('href');
  $('a[href=\'' + anchor + '\']').tab('show');
});


  
