var offline = true;
var ga = ga || {}

/**
 * Push information
 */
ga.push = function(type,category,action,label,value) {
  if (type == '_trackEvent') {
    if (!offline)
      _gaq.push([type,category,action,label,value]);
    else
      console.log(type,category,action,label,value);
  }
  else if(type == '_trackPageview') {
    if (!offline)
      _gaq.push([type,category]);
    else
      console.log(type,category);
  }
}

jQuery(document).ready(function() {
  
  // Formulário de busca do topo
  $('#buscaTopo input[name="pc_action"]').click(function(e) {
    e.preventDefault();
    var foto    = $('#buscaTopo input[name^="filtro"]').eq(0);
    var video   = $('#buscaTopo input[name^="filtro"]').eq(1);
    var search  = $('#buscaTopo input[name="query"]').val();
    var label   = '';
    if ((foto.is(':checked') && video.is(':checked')) || (!foto.is(':checked') && !video.is(':checked')))
      label  = 'todos';
    else
      label = $('#buscaTopo input[name^="filtro"]:checked').val();
    ga.push('_trackEvent','busca', 'topo', label, search);
    $('#buscaTopo').submit();
    //return false;
  });
  
  // Menu nossos temas
  $('.menu-nossos-temas li a').click(function(e) {
    e.preventDefault();
    var tema = $(this).text();
    ga.push('_trackEvent','busca', 'topo', 'nossos-temas', tema);
    window.location = $(this).attr('href');
    //return false;
  });
  
  // Busca lateral
  $('#buscaLateral #bt-ok"]').click(function(e) {
    e.preventDefault();
    var foto    = $('#buscaLateral input[name^="filtro"]').eq(0);
    var video   = $('#buscaLateral input[name^="filtro"]').eq(1);
    var search  = $('#buscaLateral input[name="query"]').val();
    var label   = '';
    if ((foto.is(':checked') && video.is(':checked')) || (!foto.is(':checked') && !video.is(':checked')))
      label  = 'todos';
    else
      label = $('#buscaLateral input[name^="filtro"]:checked').val();
    ga.push('_trackEvent','busca', 'lateral', label, search);
    $('#buscaLateral').submit();
    //return false;
  });
  
  /**
   * Busca avançada
   */ 
  /* mapa */
  $('#MapArea area').click(function(e){
    e.preventDefault();
    ga.push('_trackEvent','busca', 'avancada', 'mapa', $(this).attr('id'));
    window.location = $(this).attr('href');
    //return false;
  })
  /* formulário*/
  $('form[name="form1"] input[name="pa_action"]').click(function(e) {
    e.preventDefault(); 
    ga.push('_trackEvent','busca', 'avancada', 'fracao', $('form[name="form1"] input[name="fracao"]').val());
    ga.push('_trackEvent','busca', 'avancada', 'cidade', $('form[name="form1"] input[name="local"]').val());
    ga.push('_trackEvent','busca', 'avancada', 'pais', $('form[name="form1"] select[name="pais"]').val());
    ga.push('_trackEvent','busca', 'avancada', 'autor', $('form[name="form1"] select[name^="id_autor"]').val());
    $('#buscaTopo').submit();
    //return false;
  });
  
  /**
   * Menu Rodapé
   */
  /* redes sociais*/
  $('div.socialbar a').click(function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    ga.push('_trackEvent','menu', 'footer', 'social', url);
    window.location = $(this).attr('href');
    //return false;
  });
  
  /* menu */
  $('div.map a').click(function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    ga.push('_trackPageview', url);
    window.location = $(this).attr('href');
    //return false;
  });
  
  
});


