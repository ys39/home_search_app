$(function() {

  // cancel buttonをクリックしたときの挙動（テキストボックスからテキストを削除）
  $('.cancel_button').on('click', function() {
    $('input[name="search_word"]').val("");
  });

  //$('.thumbs-down').on('click', function() {
  $("[class^='thumbs-down']").on('click', function() {
    $.ajax({
      type: "POST",
      url: "./api/home_favorite.php",
      data: {home_id : $(this).data("home-id"), status : "thumbs-down" },
      dataType: 'json'
    }).done(function(data){
      var thumbsdownclass = ".thumbs-down-" + data[0].home_id;
      var thumbsupclass = ".thumbs-up-" + data[0].home_id;
      if($(thumbsdownclass).children("article").hasClass('is-light')){
        $(thumbsdownclass).children("article").removeClass('is-light');
        $(thumbsdownclass).children("article").addClass('is-danger');
        if($(thumbsupclass).children("article").hasClass('is-danger')){
          $(thumbsupclass).children("article").removeClass('is-danger');
          $(thumbsupclass).children("article").addClass('is-light');
        }
      }else if($(thumbsdownclass).children("article").hasClass('is-danger')){
        $(thumbsdownclass).children("article").removeClass('is-danger');
        $(thumbsdownclass).children("article").addClass('is-light');
      }
    }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
      alert("読み込みに失敗しました");
    })
  });

  //$('.thumbs-up').on('click', function() {
  $("[class^='thumbs-up']").on('click', function() {
    $.ajax({
      type: "POST",
      url: "./api/home_favorite.php",
      data: {home_id : $(this).data("home-id"), status : "thumbs-up" },
      dataType: 'json'
    }).done(function(data){
      var thumbsdownclass = ".thumbs-down-" + data[0].home_id;
      var thumbsupclass = ".thumbs-up-" + data[0].home_id;
      if($(thumbsupclass).children("article").hasClass('is-light')){
        $(thumbsupclass).children("article").removeClass('is-light');
        $(thumbsupclass).children("article").addClass('is-danger');
        if($(thumbsdownclass).children("article").hasClass('is-danger')){
          $(thumbsdownclass).children("article").removeClass('is-danger');
          $(thumbsdownclass).children("article").addClass('is-light');
        }
      }else if($(thumbsupclass).children("article").hasClass('is-danger')){
        $(thumbsupclass).children("article").removeClass('is-danger');
        $(thumbsupclass).children("article").addClass('is-light');
      }
    }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
      alert("読み込みに失敗しました");
    })
  });

});
