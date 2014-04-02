<?php
// Set language to German
putenv('LC_ALL=pt_BR');
setlocale(LC_ALL, 'pt_BR');

// Specify location of translation tables
bindtextdomain("pulsar", "./locale");

// Choose domain
textdomain("pulsar");
?>