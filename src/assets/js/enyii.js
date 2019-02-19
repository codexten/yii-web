function dynamicFieldUpdate(wrapper, url, config) {
    config = JSON.parse(config);
    var data = $(wrapper + ' form').serializeArray();

    data.push({name: '_action', value: config['action']});
    data.push({name: '_relationName', value: config['relationName']});
    data.push({name: '_inputName', value: config['inputName']});

    if (config['action'] === 'remove') {
        data.push({name: '_removeIndex', value: config['removeIndex']});
    }
    var activeTabs = [];
    $(wrapper + " .tab-pane.active").each(function () {
        activeTabs.push({id: $(this).attr('id'), class: $(this).attr('class')});
    });
    // $('.page').plainOverlay('show', {
    //     opacity: .85,
    //     fillColor: '#FFF',
    // });
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (data) {
            $(wrapper).html(data);
            $(wrapper + " .nav-tabs .active").each(function () {
                $(this).removeClass();
            });
            $(wrapper + " .tab-pane").each(function () {
                $(this).removeClass('active');
            });
            $.each(activeTabs, function (index, activeTab) {
                $('a[href="#' + activeTab.id + '"]').parent('li').addClass('active');
                $("#" + activeTab.id).addClass(activeTab.class);
            });
            // $('.page').plainOverlay('hide');
        }
    });
}
//select2 reset
$("select").closest("form").on("reset",function(ev){
    var targetJQForm = $(ev.target);
    setTimeout((function(){
        this.find("select").trigger("change");
    }).bind(targetJQForm),0);
});
