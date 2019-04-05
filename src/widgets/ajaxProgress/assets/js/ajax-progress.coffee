do ($ = jQuery, window, document) ->
pluginName = "ajaxProgress"
defaults =
  statusUrl: null,
  endStatus: 'stopped',
  refreshRate: 1000,
  onComplete: null

class Plugin
  constructor: (@element, options) ->
    @settings = $.extend {}, defaults, options
    @_defaults = defaults
    @_name = pluginName
    @init()
  init: ->
    @enableAjax()
  enableAjax: ->
    progressBar = $ @element
    statusUrl = @settings.statusUrl
    onComplete = @settings.onComplete

    id = setInterval ->
      $.ajax statusUrl,
        success: (data, textStatus, jqXHR) ->
          progress = parseInt(data.progress)
          progressBar.html data.statusMessage + ' ' + progress.toPrecision(3) + '%'
          progressBar.css
            width: progress + '%'
          if progress is 100
            progressBar.removeClass('progress-bar-info');
            progressBar.addClass('progress-bar-success');
            progressBar.parent("div").removeClass('progress-striped');
            clearInterval id;
            progressBar.trigger('complete')
    , @settings.refreshRate

$.fn[pluginName] = (options) ->
  @each ->
    unless $.data @, "plugin_#{pluginName}"
      $.data @, "plugin_#{pluginName}", new Plugin @, options