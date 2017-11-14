


function showPage(jsonData){
    var list = $('#list');
    list.empty();
    $.each(jsonData, function( i, value ) {
        var item = $('<div class="column">');
        var btn = $('<label>');
        btn.attr('data-element',i);
        btn.attr('class','column fa fa-edit fa-2x');
        btn.click(function(){
            enableInput($(this))
        });
        $.each(value, function( j, value ) {
            var input = $('<input>');
            input.prop('disabled',true);
            input.attr('type','text');
            input.attr('data-element',i);
            input.attr('data-prop',j);
            input.attr('class','column');
            input.attr('placeholder',value.NAME);
            input.val(value.VALUE);
            input.appendTo(item);
        });
        btn.appendTo(item);
        item.appendTo(list);
    });
}

function onClickBtnPage(btn){
    var page = btn.attr('data-page');
    $('.active-page').removeClass('active-page');
    btn.addClass('active-page');
    $.getJSON("/?ajax_action=get&page="+page, function (data) {
        showPage(data);
    });
}

function disableInput(btn,elementId) {
    btn.addClass('fa-edit');
    btn.removeClass('fa-save');
    $('[data-element='+elementId+']').prop('disabled',true);
}

function enableInput(btn) {
    var elementId = btn.attr('data-element');
    btn.removeClass('fa-edit');
    btn.addClass('fa-save');
    $('[data-element='+elementId+']').prop('disabled',false);
    btn.click(function(){
        saveFio(elementId);
        disableInput($(this),elementId);
    });
}

function saveFio(elementId) {
    var data ={props:[]};
    $('input[data-element='+elementId+']').each(function() {
        data.props.push({
            "element":elementId,
            "value":$(this).val(),
            "prop":$(this).attr('data-prop')
        });
    });
    $.post( "/?ajax_action=save",data);
}

$(document).ready(function() {

    $(".btn-page").click(function(){
        onClickBtnPage($(this));
    });

    $('button[data-page=1]').click();

});