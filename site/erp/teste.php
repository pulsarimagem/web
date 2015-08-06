<!DOCTYPE HTML>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Date/Time Picker for Twitter Bootstrap"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Thiago de Arruda" />
    <title>Bootstrap Date/Time Picker</title>
    <link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
  </head>
  <body>
<div class="well">
  <div id="datetimepicker1" class="input-append date">
    <input data-format="dd/MM/yyyy hh:mm:ss" type="text"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>